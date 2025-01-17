function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.pvList = ko.observableArray();
	self.pv = ko.observable();

	self.yearList = Array.repeat(moment().year() - 2022).map((r, i) => i + 2023);
	self.year = ko.observable(moment().year());

	self.updateList = ko.observableArray();

	app.getPlace(['pv'], function (p) {
		self.pvList(p.pv.filter(r => r.target == 1));

		var submit = { year: self.year() };
		app.ajax('/StockMonitoring/getDataOD', submit).done(function (rs) {
			self.listModel(rs);
		});
	});

	self.getListModel = function () {
		var list = self.listModel();

		if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());

		return list;
	};

	self.showDetail = function (model, index) {
		var obj = {
			menu: 'od',
			year: self.year(),
			id: model.Code_OD_T,
			month: moment().month(index).format('MM')
		};
		sessionStorage.code_prov = model.Code_Prov_T;
		window.open('/Stock/report?s=' + JSON.stringify(obj));
	};

	self.save = function () {
		var list = self.updateList().map(r => {
			return {
				Code_OD_T: r.split('|')[0],
				Year: self.year(),
				Month: moment().month(r.split('|')[1]).format('MM')
			};
		});
		if (list.length == 0) return;

		var submit = { list, year: self.year() };
		app.ajax('/StockMonitoring/saveOD', submit).done(function (rs) {
			self.listModel(rs);
			self.updateList([]);
		});
	};
}