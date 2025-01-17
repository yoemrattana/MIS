function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	app.ajax('/SystemMenu/getProvince').done(function (rs) {
		self.listModel(rs);
	});

	self.showEdit = function (model) {
		model = app.ko(model);
		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		model.Name_Prov_E((model.Name_Prov_E() || '').trim());
		model.Name_Prov_K((model.Name_Prov_K() || '').trim());
		model.CSO((model.CSO() || '').trim());
		model.CSO2021((model.CSO2021() || '').trim());

		var missing = false;
		if (model.Name_Prov_E() == '') {
			app.showWarning(model.Name_Prov_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Prov_K() == '') {
			app.showWarning(model.Name_Prov_K.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);

		var submit = {
			submit: JSON.stringify({
				value: {
					Name_Prov_E: model.Name_Prov_E,
					Name_Prov_K: model.Name_Prov_K,
					CSO: model.CSO,
					CSO2021: model.CSO2021
				},
				where: { Code_Prov_T: model.Code_Prov_T }
			})
		};

		app.ajax('/SystemMenu/saveProvince', submit).done(function () {
			var old = self.listModel().find(r => r.Code_Prov_T == model.Code_Prov_T);
			self.listModel.replace(old, model);
		});
	};
}