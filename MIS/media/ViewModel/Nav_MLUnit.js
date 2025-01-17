function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();
	self.rgList = ko.observableArray();
	self.rg = ko.observable();

	var isNew = true;

	app.getPlace(['rg'], function (p) {
		self.rgList(p.rg);

		app.ajax('/SystemMenu/getMlUnit').done(function (rs) {
			self.listModel(rs);
		});
	});

	self.getListModel = function () {
		var list = self.listModel();

		if (self.rg() != null) list = list.filter(r => r.Code_Regional_T == self.rg());

		return list;
	};

	self.showNew = function () {
		var model = {
			Code_Regional_T: '',
			Code_Unit_T: '',
			Name_Unit_E: '',
			Name_Unit_K: ''
		};
		self.showEdit(model);
	};

	self.showEdit = function (model) {
		if (model.Code_Unit_T == '') {
			isNew = true;
			model.Code_Unit_T = Math.max(...self.listModel().map(r => r.Code_Unit_T)) + 1;
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
		if (model.Code_Regional_T() == null) {
			app.showWarning(model.Code_Regional_T.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Unit_E.trim() == '') {
			app.showWarning(model.Name_Unit_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Unit_K.trim() == '') {
			app.showWarning(model.Name_Unit_K.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);

		if (isNew) {
			var submit = {
				value: { Name_Unit_E: model.Name_Unit_E, Name_Unit_K: model.Name_Unit_K, Code_Regional_T: model.Code_Regional_T, Code_Unit_T: model.Code_Unit_T }
			};
		} else {
			var submit = {
				value: { Name_Unit_E: model.Name_Unit_E, Name_Unit_K: model.Name_Unit_K, Code_Regional_T: model.Code_Regional_T },
				where: { Code_Unit_T: model.Code_Unit_T }
			};
		}
		var submit = { submit: JSON.stringify(submit) };

		app.ajax('/SystemMenu/saveMLUnit', submit).done(function () {
			var found = self.rgList().find(r => r.code == model.Code_Regional_T);
			model.Name_Regional_E = found.name;
			model.Name_Regional_K = found.nameK;

			var old = self.listModel().find(r => r.Code_Unit_T == model.Code_Unit_T);
			if (old == null) self.listModel.push(model);
			else self.listModel.replace(old, model);
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = { Code_Unit_T: model.Code_Unit_T };
			app.ajax('/SystemMenu/deleteMLUnit', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};
}