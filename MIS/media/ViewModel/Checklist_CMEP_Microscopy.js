function subViewModel(self) {
	self.tableName = 'tblChecklistCMEPMicroscopy';
	self.getData();

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Code_Prov_N: null,
			Code_OD_T: null,
			Code_Facility_T: null,
			FacilityType: null,
			Code_Dist_T: null,
			Phone: '',
			Fax: '',
			Email: '',
			LaboDirector: '',
			HospitalDirector: '',
			Interviewee: '',
			Interviewer: '',
			VisitorName: '',
			VisitDate: null
		};
		self.showDetail(model);
	};

	self.showDetail = function (model) {
		self.lastScrollY = window.scrollY;

		model = app.ko(model);

		model.pvList = self.place.pv;
		model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());
		model.hcList = () => self.place.hc.filter(r => r.odcode == model.Code_OD_T());
		model.dsList = () => self.place.ds.filter(r => r.pvcode == model.Code_Prov_N());

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
		if (master.FacilityType() == '') {
			app.showWarning(master.FacilityType.element);
			missing = true;
		}
		if (master.Code_Dist_T() == null) {
			app.showWarning(master.Code_Dist_T.element);
			missing = true;
		}
		if (master.LaboDirector.trim() == '') {
			app.showWarning(master.LaboDirector.element);
			missing = true;
		}
		if (master.HospitalDirector.trim() == '') {
			app.showWarning(master.HospitalDirector.element);
			missing = true;
		}
		if (master.Interviewee.trim() == '') {
			app.showWarning(master.Interviewee.element);
			missing = true;
		}
		if (master.Interviewer.trim() == '') {
			app.showWarning(master.Interviewer.element);
			missing = true;
		}
		if (master.VisitorName.trim() == '') {
			app.showWarning(master.VisitorName.element);
			missing = true;
		}
		if (master.VisitDate() == null) {
			app.showWarning(master.VisitDate.element);
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
				FacilityType: master.FacilityType(),
				Code_Dist_T: master.Code_Dist_T(),
				Phone: master.Phone.trim(),
				Fax: master.Fax.trim(),
				Email: master.Email.trim(),
				LaboDirector: master.LaboDirector(),
				HospitalDirector: master.HospitalDirector(),
				Interviewee: master.Interviewee(),
				Interviewer: master.Interviewer(),
				VisitorName: master.VisitorName(),
				VisitDate: master.VisitDate(),
				Detail: JSON.stringify(app.unko(self.detailModel())),
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

	self.getAnswer = function (e) {
		var found = self.detailModel().find(r => r.Question == e.name);

		if (found == null) {
			found = { Question: e.name, Answer: e.type == 'checkbox' ? [] : '' };
			self.detailModel().push(found);
		}
		if (!ko.isObservable(found.Answer)) found.Answer = ko.observable(found.Answer);

		return found.Answer;
	};
}