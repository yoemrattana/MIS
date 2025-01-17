function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable()
	self.categoryList = ['ACT', 'RDT'];

	app.ajax('/Stock/getItem').done(function (rs) {
		self.listModel(rs);
	});

	self.showAdd = function () {
		var model = {
			Id: 0,
			Code: '',
			Description: '',
			Strength: '',
			Unit: '',
			Category: null,
			EnableHF: 1,
			EnableOD: 1,
			EnableVMW: 1
		};
		self.showEdit(model);
	};

	self.showEdit = function (model) {
		model = app.ko(model);
		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.save = function (model) {
		model.Code(model.Code().trim());
		model.Description(model.Description().trim());
		model.Strength(model.Strength().trim());
		model.Unit(model.Unit().trim());

		var missing = false;
		if (model.Code() == '') {
			app.showWarning(model.Code.element, 'Please input this box.');
			missing = true;
		}
		if (model.Description() == '') {
			app.showWarning(model.Description.element, 'Please input this box.');
			missing = true;
		}
		if (model.Unit() == '') {
			app.showWarning(model.Unit.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		var model = app.unko(model);
		model.Category = is(model.Category, undefined, null);

		app.ajax('/Stock/saveItem', model).done(function (id) {
			if (model.Id == 0) {
				model.Id == id;
				self.listModel.push(model);
			} else {
				var old = self.listModel().find(r => r.Id == model.Id);
				self.listModel.replace(old, model);
			}
		});
	};
}