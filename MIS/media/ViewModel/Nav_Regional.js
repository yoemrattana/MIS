function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	var isNew = true;

	app.ajax('/SystemMenu/getRegional').done(function (rs) {
		self.listModel(rs);
	});

	self.showNew = function () {
		var model = {
			Code_Regional_T: '',
			Name_Regional_E: '',
			Name_Regional_K: ''
		};
		self.showEdit(model);
	};

	self.showEdit = function (model) {
		if (model.Code_Regional_T == '') {
			isNew = true;
			model.Code_Regional_T = Math.max(...self.listModel().map(r => r.Code_Regional_T)) + 1;
		} else {
			isNew = false;
		}

		model = app.ko(model);
		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		var missing = false;
		if (model.Name_Regional_E.trim() == '') {
			app.showWarning(model.Name_Regional_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Regional_K.trim() == '') {
			app.showWarning(model.Name_Regional_K.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);

		if (isNew) {
			var submit = { value: model };
		} else {
			var submit = {
				value: { Name_Regional_E: model.Name_Regional_E, Name_Regional_K: model.Name_Regional_K },
				where: { Code_Regional_T: model.Code_Regional_T }
			};
		}
		var submit = { submit: JSON.stringify(submit) };

		app.ajax('/SystemMenu/saveRegional', submit).done(function () {
			var old = self.listModel().find(r => r.Code_Regional_T == model.Code_Regional_T);
			if (old == null) self.listModel.push(model);
			else self.listModel.replace(old, model);
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = { Code_Regional_T: model.Code_Regional_T };
			app.ajax('/SystemMenu/deleteRegional', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};
}