function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	self.provList = ko.observableArray();
	self.prov = ko.observable();

	var mainData = [];

	app.getPlace(['pv'], function (p) {
		self.provList(p.pv);
		self.prov(location.pathname.split('/')[3]);

		app.ajax('/SystemMenu/getDistrict').done(function (rs) {
			mainData = rs;
			updateFilter();
		});
	});

	self.showEdit = function (model) {
		model = app.ko(model);
		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		model.Name_Dist_E((model.Name_Dist_E() || '').trim());
		model.Name_Dist_K((model.Name_Dist_K() || '').trim());

		var missing = false;
		if (model.Name_Dist_E() == '') {
			app.showWarning(model.Name_Dist_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Dist_K() == '') {
			app.showWarning(model.Name_Dist_K.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);

		var submit = {
			submit: JSON.stringify({
				value: { Name_Dist_E: model.Name_Dist_E, Name_Dist_K: model.Name_Dist_K },
				where: { Code_Dist_T: model.Code_Dist_T }
			})
		};

		app.ajax('/SystemMenu/saveDistrict', submit).done(function () {
			var old = self.listModel().find(r => r.Code_Dist_T == model.Code_Dist_T);
			self.listModel.replace(old, model);
		});
	};

	self.prov.subscribe(updateFilter);

	function updateFilter() {
		self.listModel(mainData.filter(r => r.Code_Prov_T == self.prov()));
	}
}