function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.ready = ko.observable(false);

	app.ajax('/RDTReader/getPCR').done(function (rs) {
		self.ready(true);

		self.listModel(rs);
	});

	self.exportExcel = function () {
		app.downloadBlob('/media/PCR/CNM_FIND_PCR_Species.xlsx').done(function (blob) {
			saveAs(blob, 'CNM_FIND_PCR_Species.xlsx');
		});
	};
}