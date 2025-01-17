function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.detailModel = ko.observable();
	self.view = ko.observable('list');

	var place = null;
	var mainData = [];

	self.back = function () {
		self.view('list');
	};

	app.ajax('/SystemMenu/getVMWlogTrackingLog').done(function (rs) {
		
		_.forEach(rs, function (r) {
			var newValue = JSON.parse(r.NewValue);

			r.NewValue = {
				VMW: newValue.HaveVMW,
				IP1: newValue.IP1,
				IP2: newValue.IP2
			};

			var oldValue = JSON.parse(r.OldValue);

			r.OldValue = {
				VMW: oldValue.HaveVMW,
				IP1: oldValue.IP1,
				IP2: oldValue.IP2
			};
		});
		
		self.listModel(rs);
	});

}