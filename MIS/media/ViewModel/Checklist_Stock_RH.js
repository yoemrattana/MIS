function subViewModel(self) {
	self.tableName = 'tblChecklistStockRH';
	self.getData();

	self.stockList = ko.observableArray();

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Code_Prov_N: null,
			Code_OD_T: null,
			Code_Facility_T: null,
			VisitorName: '',
			VisitDate: null,
			CaseQty: '',
			Interest: ''
		};
		self.showDetail(model);
	};

	function newStockList() {
		var arr = [
			'ASMQ (100/200mg)',
			'Primaquine 7.5mg',
			'Quinine tablets',
			'Injectable artesunate vials',
			'Injectable quinine (ampoules)',
			'Doxycycline',
			'Tetracycline',
			'G6PD test',
			'G6PD control',
			'Malaria Rapid Diagnostic test',
		];

		return arr = arr.map(name => {
			return { name, unit: '', stock: '', date: '', note: '' };
		});
	}

	self.showDetail = function (model) {
		self.lastScrollY = window.scrollY;

		model = app.ko(model);

		model.pvList = self.place.pv;
		model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());
		model.hcList = () => self.place.hc.filter(r => r.odcode == model.Code_OD_T());

		if (model.Rec_ID() == 0) {
			self.detailModel([]);
			self.stockList(newStockList());
		} else {
			let detail = JSON.parse(model.Detail())
			detail = detail.filter(r => r.Question != 'stock');
			self.detailModel(detail);
			self.stockList(JSON.parse(model.Stock()));
		}

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

		if (master.VisitorName.trim() == '') {
			app.showWarning(master.VisitorName.element);
			missing = true;
		}
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
		if (master.VisitDate() == null) {
			app.showWarning(master.VisitDate.element);
			missing = true;
		}
		if (missing) {
			window.scrollTo(0, 0);
			return;
		}

		self.detailModel().push({ Question: 'stock', Answer: JSON.stringify(self.stockList()) });

		var submit = {
			tbl: self.tableName,
			master: {
				Rec_ID: master.Rec_ID(),
				Code_Facility_T: master.Code_Facility_T(),
				VisitorName: master.VisitorName(),
				VisitDate: master.VisitDate(),
				CaseQty: master.CaseQty(),
				Interest: master.Interest(),
				Detail: JSON.stringify(app.unko(self.detailModel())),
				Stock: JSON.stringify(self.stockList())
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