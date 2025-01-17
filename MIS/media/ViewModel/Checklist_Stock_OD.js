function subViewModel(self) {
	self.tableName = 'tblChecklistStockOD';
	self.getData();

	self.stockList = ko.observableArray();

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Code_Prov_N: null,
			Code_OD_T: null,
			VisitorName: '',
			VisitDate: null,
			Interest: ''
		};
		self.showDetail(model);
	};

	function newStockList() {
		var arr = [
			{ code: 'ND0082', name: 'RDT -(Kit/10 Tests)', system: 'ODDID', unit: 'Test' },
			{ code: 'ND0082', name: 'RDT -(Kit/10 Tests)', system: 'MIS', unit: 'Test' },
			{ code: 'ND0067', name: 'ASMQ 100/200mg', system: 'ODDID', unit: 'Box/6 tabs' },
			{ code: 'ND0067', name: 'ASMQ 100/200mg', system: 'MIS', unit: 'Box/6 tabs' },
			{ code: 'ND0132', name: 'Primaquine 7.5mg', system: 'ODDID', unit: 'Tab' },
			{ code: 'ND0132', name: 'Primaquine 7.5mg', system: 'MIS', unit: 'Tab' },
			{ code: 'ND0075', name: 'Pyramax 60/20mg', system: 'ODDID', unit: 'Suchet' },
			{ code: 'ND0075', name: 'Pyramax 60/20mg', system: 'MIS', unit: 'Suchet' },
			{ code: 'ND0068', name: 'Pyramax,180/60mg', system: 'ODDID', unit: 'Blister' },
			{ code: 'ND0068', name: 'Pyramax,180/60mg', system: 'MIS', unit: 'Blister' },
			{ code: 'ND0023', name: 'Icaridine 100ml', system: 'ODDID', unit: 'Bottle' },
			{ code: 'ND0023', name: 'Icaridine 100ml', system: 'MIS', unit: 'Bottle' },
			{ code: 'ND0010', name: 'Albendazol', system: 'ODDID', unit: 'Tab' },
			{ code: 'ND0010', name: 'Albendazol', system: 'MIS', unit: 'Tab' },
			{ code: 'NQ0004', name: 'Albendazol', system: 'ODDID', unit: 'Tab' },
			{ code: 'NQ0004', name: 'Albendazol', system: 'MIS', unit: 'Tab' },
		];

		return arr = arr.map(item => {
			return { code: item.code, name: item.name, system: item.system, unit: item.unit, month1: '', month2: '', month3: '' };
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
				VisitorName: master.VisitorName(),
				VisitDate: master.VisitDate(),
				Code_OD_T: master.Code_OD_T(),
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