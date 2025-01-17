function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	self.rgList = ko.observableArray();
	self.provList = ko.observableArray();
	self.rg = ko.observable();

	var mainData = [];
	var unitData = [];

	app.getPlace(['pv', 'rg'], function (p) {
		self.provList(p.pv);

		app.ajax('/SystemMenu/getRegional').done((rs) => {
			self.rgList(rs);
		})

		app.ajax('/SystemMenu/getMLUnit').done((rs) => {
			unitData = rs;
		})

		app.ajax('/SystemMenu/getGroup').done(function (rs) {
			mainData = rs;
			updateFilter();
		});
	});

	self.showCreate = function () {
		var arr = mainData.map(r => r.Code_Group_T);
		var model = {
			Code_Regional_T: null,
			Code_Unit_T: null,
			Code_Prov_T: null,
			Code_Group_T: Math.max(...arr) + 1,
			Name_Group_E: '',
			Name_Group_K: '',
			Rec_ID: 0
		};

		self.showEdit(model);
	};

	self.showEdit = function (model) {
		model = app.ko(model);

		model.unitList = () => unitData.filter(r => r.Code_Regional_T == model.Code_Regional_T());

		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		model.Name_Group_E((model.Name_Group_E() || '').trim());
		model.Name_Group_K((model.Name_Group_K() || '').trim());

		var missing = false;
		if (model.Rec_ID() == 0 && model.Code_Regional_T() == null) {
			app.showWarning(model.Code_Regional_T.element, 'Please input this box.');
			missing = true;
		}
		if (model.Rec_ID() == 0 && model.Code_Unit_T() == null) {
			app.showWarning(model.Code_Unit_T.element, 'Please input this box.');
			missing = true;
		}
		if (model.Rec_ID() == 0 && model.Code_Prov_T() == null) {
			app.showWarning(model.Code_Prov_T.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Group_E() == '') {
			app.showWarning(model.Name_Group_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Group_K() == '') {
			app.showWarning(model.Name_Group_K.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);
		var rg = self.rgList().find(r => r.code == model.Code_Regional_T);

		var submit = {
			submit: JSON.stringify({
				value: {
					Code_Unit_T: model.Code_Unit_T,
					Code_Group_T: model.Code_Group_T,
					Name_Group_E: model.Name_Group_E,
					Name_Group_K: model.Name_Group_K,
					Code_Prov_T: model.Code_Prov_T
				},
				where: { Rec_ID: model.Rec_ID }
			})
		};
		
		app.ajax('/SystemMenu/saveGroup', submit).done(function (rs) {
			if (model.Rec_ID == 0) {
				mainData.push(rs);
			} else {
				var index = mainData.findIndex(r => r.Code_Group_T == model.Code_Group_T);
				mainData[index] = rs;
			}
			updateFilter();
		});
	};

	self.delete = function (model) {
		app.showDelete(function () {
			var submit = { Rec_ID: model.Rec_ID };
			app.ajax('/SystemMenu/deleteGroup', submit).done(function () {
				mainData.remove(model);
				updateFilter();
			});
		});
	};

	self.rg.subscribe(updateFilter);

	function updateFilter() {
		self.listModel(self.rg() == null ? mainData : mainData.filter(r => r.Code_Regional_T == self.rg()));
	}
}