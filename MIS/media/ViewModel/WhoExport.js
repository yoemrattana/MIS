function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.yearList = ko.observableArray();
	self.monthList = ko.observableArray();
	self.year = ko.observable();
	self.month = ko.observable();

	app.ajax('/WhoExport/getList').done(function (rs) {
		rs = rs.map(r => {
			return {
				filename: r,
				year: r.substr(9, 4),
				month: r.substr(14, 2)
			}
		});

		self.yearList(rs.map(r => r.year).distinct());
		self.monthList(rs.map(r => r.month).distinct());

		self.listModel(rs);
	});

	self.export = function (filename) {
		var submit = { filename: filename };
		app.downloadBlob('/WhoExport/export', submit).done(function (blob) {
			saveAs(blob, filename);
		});
	};
}