function subViewModel(self) {
	self.tableName = 'tblChecklistStockHC';
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
			{ code: 'AA0280', name: 'Mebendazol', strength: '500mg', unit: 'Tablet'},
			{ code: 'ND0010', name: 'Albendazol', strength: '400mg', unit: 'Tablet'},
			{ code: 'NQ0004', name: 'Albendazol', strength: '400mg', unit: 'Tablet'},
			{ code: 'ND0023', name: 'Icaridine 100ml', strength: '20g/100ml', unit: 'Bottle'},
			{ code: 'ND0067', name: 'Artesunate + Mefloquine', strength: '100mg+200mg', unit: 'Box/6tablets'},
			{ code: 'ND0068', name: 'Artesunate + Pyronaridine', strength: '60mg+180mg', unit: 'Blister/9tabs'},
			{ code: 'ND0075', name: 'Pyramax', strength: '60/20mg', unit: 'Suchet'},
			{ code: 'ND0089', name: 'G6PD Control (Level1+Level2)', strength: 'Kit/10tests', unit: 'Test'},
			{ code: 'ND0097', name: 'G6PD Rapid Diagnostic Test', strength: 'Kit/10tests', unit: 'Test'},
			{ code: 'ND0132', name: 'Primaquine', strength: '7.5mg', unit: 'Tablet'},
			{ code: 'ND0150', name: 'Quinine sulfate', strength: '300mg', unit: 'Tablet'},
			{ code: 'ND0225', name: 'LLIN', strength: '', unit: 'Piece'},
			{ code: 'ND0227', name: 'LLIHN', strength: '', unit: 'Piece'},
			{ code: 'ND0082', name: 'Rapid Diagnostic Test (Kit/10 tests)', strength: '', unit: 'Test'},
			{ code: 'N/A', name: 'Integrated Hammock', strength: '', unit: 'Piece'},

		];

		return arr = arr.map(item => {
			return { code: item.code, name: item.name, strength: item.strength, unit: item.unit, stock: '', qty: '', date: '', note: '' };
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