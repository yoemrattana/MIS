function subViewModel(self) {
	self.tableName = 'tblChecklistCMEPPPM';
	self.getData();

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Code_Prov_N: '',
			Code_OD_T: '',
			Code_Facility_T: '',
			Code_Vill_T: '',
			PPM: '',
			VisitorName: '',
			VisitDate: null,
			Position: '',
			WorkPlace: '',
		};
		self.showDetail(model);
	};

	self.showDetail = function (model) {
		self.lastScrollY = window.scrollY;

		model = app.ko(model);

		model.pvList = self.place.pv;
		model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());
		model.hcList = () => self.place.hc.filter(r => r.odcode == model.Code_OD_T());
		model.vlList = () => self.place.vl.filter(r => r.hccode == model.Code_Facility_T());

		self.detailModel(model.Rec_ID() == 0 ? [] : JSON.parse(model.Detail()));
		self.masterModel(model);
		self.view('detail');

		$('input[numonly]').each(function () {
			app.setNumberOnly(this, $(this).attr('numonly'));
		});

		window.scrollTo(0, 0);
	};

	self.save = function () {
		var master = self.masterModel();
		var missing = false;

		if (master.Code_Prov_N() == null) {
			app.showWarning(master.Code_Prov_N.element);
			missing = true;
		}
		if (master.Code_OD_T() == null) {
			app.showWarning(master.Code_OD_T.element);
			missing = true;
		}
		if (master.Code_Facility_T() == null) {
			app.showWarning(master.Code_Facility_T.element);
			missing = true;
		}
		if (master.Code_Vill_T() == null) {
			app.showWarning(master.Code_Vill_T.element);
			missing = true;
		}
		if (master.PPM.trim() == '') {
			app.showWarning(master.PPM.element);
			missing = true;
		}
		if (master.VisitDate() == null) {
			app.showWarning(master.VisitDate.element);
			missing = true;
		}
		if (master.VisitorName.trim() == '') {
			app.showWarning(master.VisitorName.element);
			missing = true;
		}
		if (master.Position.trim() == '') {
			app.showWarning(master.Position.element);
			missing = true;
		}
		if (master.WorkPlace() == '') {
			app.showWarning(master.WorkPlace.element);
			missing = true;
		}
		if (missing) {
			window.scrollTo(0, 0);
			return;
		}

		var submit = {
			tbl: self.tableName,
			master: {
				Rec_ID: master.Rec_ID(),
				Code_Facility_T: master.Code_Facility_T(),
				Code_Vill_T: master.Code_Vill_T(),
				PPM: master.PPM(),
				VisitorName: master.VisitorName(),
				VisitDate: master.VisitDate(),
				Position: master.Position(),
				WorkPlace: master.WorkPlace(),
				Detail: JSON.stringify(app.unko(self.detailModel()))
			}
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Checklist/save', submit).done(function (rs) {
			if (master.Rec_ID() == 0) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
				self.listModel.replace(old, rs);
			}

			self.view('list');
		});
	};

	self.getAnswer = function (e, score) {
		var found = self.detailModel().find(r => r.Question == e.name);

		if (found == null) {
			found = { Question: e.name, Answer: e.type == 'checkbox' ? [] : '', Score: '' };
			self.detailModel().push(found);
		}
		if (!ko.isObservable(found.Answer)) {
			found.Answer = ko.observable(found.Answer);
			found.Score = ko.observable(found.Score);
		}

		return score ? found.Score : found.Answer;
	};

	self.getScore = function (e) {
		return self.getAnswer(e, true);
	};

	self.getPartScore = function (p) {
		var part = {
			'1': { a: 1, b: 7 },
			'2': { a: 8, b: 11 },
			'3': { a: 12, b: 32 },
			'4': { a: 33, b: 35 },
			'5': { a: 36, b: 36 },
			'6': { a: 37, b: 39 }
		}[p];

		var founds = self.detailModel().filter(r => {
			var q = r.Question.split('.')[0];
			return q >= part.a && q <= part.b;
		});

		return founds.sum(r => r.Score().toFloat()).toFixed(2).toFloat();
	};

	self.getTotalScore = function () {
		return self.detailModel().sum(r => r.Score().toFloat()).toFixed(2).toFloat();
	};
}