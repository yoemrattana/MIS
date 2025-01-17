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

		app.ajax('/SystemMenu/getOD').done(function (rs) {
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

		model.Name_OD_E((model.Name_OD_E() || '').trim());
		model.Name_OD_K((model.Name_OD_K() || '').trim());

		var missing = false;
		if (model.Name_OD_E() == '') {
			app.showWarning(model.Name_OD_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_OD_K() == '') {
			app.showWarning(model.Name_OD_K.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);

		var submit = {
			submit: JSON.stringify({
				value: { Name_OD_E: model.Name_OD_E, Name_OD_K: model.Name_OD_K },
				where: { Code_OD_T: model.Code_OD_T }
			})
		};

		app.ajax('/SystemMenu/saveOD', submit).done(function () {
			var old = self.listModel().find(r => r.Code_OD_T == model.Code_OD_T);
			self.listModel.replace(old, model);
		});
	};

	self.prov.subscribe(updateFilter);

	function updateFilter() {
		self.listModel(mainData.filter(r => r.Code_Prov_T == self.prov()));
	}
}