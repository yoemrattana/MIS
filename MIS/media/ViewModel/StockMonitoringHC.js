function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();

	self.yearList = Array.repeat(moment().year() - 2022).map((r, i) => i + 2023);
	self.year = ko.observable(moment().year());

	self.updateList = ko.observableArray();

	var place = null;

	app.getPlace(['pv', 'od'], function (p) {
		place = p;
		place.od = place.od.filter(r => r.target == 1);
		self.pvList(place.pv.filter(r => r.target == 1));

		var submit = { year: self.year() };
		app.ajax('/StockMonitoring/getDataHC', submit).done(function (rs) {
			self.listModel(rs);
		});
	});

	self.getListModel = function () {
		var list = self.listModel();

		if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());
		if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());

		return list;
	};

	self.odList = function () {
		return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
	};

	self.showDetail = function (model, index) {
		var obj = {
			menu: 'hf',
			year: self.year(),
			od: model.Code_OD_T,
			id: model.Code_Facility_T,
			month: moment().month(index).format('MM')
		};
		sessionStorage.code_prov = model.Code_Prov_N;
		window.open('/Stock/report?s=' + JSON.stringify(obj));
	};

	self.save = function () {
		var list = self.updateList().map(r => {
			return {
				Code_Facility_T: r.split('|')[0],
				Year: self.year(),
				Month: moment().month(r.split('|')[1]).format('MM')
			};
		});
		if (list.length == 0) return;

		var submit = { list, year: self.year() };
		app.ajax('/StockMonitoring/saveHC', submit).done(function (rs) {
			self.listModel(rs);
			self.updateList([]);
		});
	};
}