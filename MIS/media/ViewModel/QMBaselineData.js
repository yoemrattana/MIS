function subViewModel(self) {
	var tableName = 'tblQMBaselineData';

	self.detailListModel = ko.observableArray();

	self.getData(tableName);

	self.detailModel.subscribe(function (model) {
		self.detailListModel([]);
		var submit = { ParentId: model.Rec_ID() };
		app.ajax('/QMalaria/getDetail', submit).done(function (rs) {
			rs.forEach(r => r.DateCase = ko.observable(moment(r.DateCase)));
			self.detailListModel(rs);
		});
	});

	self.save = function () {
		var model = app.unko(self.detailModel());
		var Rec_ID = model.Rec_ID;

		$('#tbllist td').css('background', '');

		var missing = false;
		var list = self.detailListModel();
		for (var i = 0; i < list.length; i++) {
			var r = list[i];
			var arr = [r.DateCase(), r.PatientCode, r.Fever, r.RDT, r.Antimalarial, r.Antibiotic];
			if (arr.some(r => isnullempty(r))) {
				$('#tbllist tr').eq(i).find('td:not(:last)').css('background', '#ff6b6b');
				missing = true;
			}
		}
		if (missing) return;

		Object.keys(model).forEach(name => {
			if (self.datatype.date.contain(name)) model[name] = model[name].format('YYYY-MM-DD');
		});

		model.list = self.detailListModel();
		model.list.forEach(r => {
			r.DateCase = r.DateCase().format('YYYY-MM-DD');
			delete r.Rec_ID;
		});

		delete model.Code_Prov_N;
		delete model.Code_OD_T;

		var submit = { submit: JSON.stringify(model) };

		app.ajax('/QMalaria/saveBaselineData', submit).done(function (rs) {
			var old = self.listModel().find(r => r.Rec_ID == Rec_ID);
			self.listModel.replace(old, rs);

			self.view('list');
			self.detailListModel([]);
		});
	};

	self.addNewRow = function () {
		var list = self.detailListModel();
		self.detailListModel.push({
			Rec_ID: list.length == 0 ? 1 : Math.max(...list.map(r => r.Rec_ID)) + 1,
			ParentId: self.detailModel().Rec_ID(),
			DateCase: ko.observable(null),
			PatientCode: '',
			Fever: null,
			RDT: null,
			Species: '',
			Antimalarial: null,
			Antibiotic: null
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			self.detailListModel.remove(model);
		});
	};

	self.choosePlace = function () {
		self.placeModel1().showEnglish(function (p) {
			self.detailModel().Code_Facility_T(p.hc());
		});
	};

	setTimeout(() => {
		$(self.prov.element).prop('disabled', true);
		$(self.od.element).prop('disabled', true);
	});
}