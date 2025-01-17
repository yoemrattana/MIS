function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();
	self.odList = ko.observableArray();
	self.typeList = ko.observableArray(['Care Room', 'Clinic', 'Conpany', 'Consult', 'Depot A', 'Depot B', 'Mobile Pro', 'Pharmacy', 'Shop']);
	self.villageList = ko.observableArray();
	self.odFilter = ko.observable();

	var villageData = [];
	var prov = $('#code_prov').val();

	app.getPlace(['od', 'hc', 'vl'], function (p) {
		villageData = p.vl;
		villageData.forEach(v => {
			var found = p.hc.find(r => r.code == v.hccode);
			v.OD = found == null ? null : found.odcode;
		});
		self.odList(p.od.filter(r => r.pvcode == prov));

		app.ajax('/SystemMenu/getDO/' + prov).done(function (data) {
			self.listModel(data);
		});
	});

	self.showCreate = function () {
		var model = {
			Prov_code_T: $('#code_prov').val(),
			Code_OD_T: '',
			Code_Vill_T: '',
			Name_Outlet_E: '',
			Name_Outlet_K: '',
			Lat: '',
			long: '',
			Type: '',
			PPM: 1,
			ID: ''
		};

		self.showEdit(model);
	};

	self.showEdit = function (model) {
		model = app.ko(model);

		model.Code_OD_T.subscribe(v => {
			var arr = villageData.filter(r => r.OD == v);
			arr.push({ code: '9999999999', name: '' });
			self.villageList(arr);
		});

		model.Code_OD_T.notifySubscribers(model.Code_OD_T());

		self.editModel(model);

		app.setNumberOnly(model.Lat.element, 'float');
		app.setNumberOnly(model.long.element, 'float');

		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		model.Name_Outlet_E(model.Name_Outlet_E().trim());
		model.Name_Outlet_K(model.Name_Outlet_K().trim());

		if (model.Name_Outlet_E() == '') {
			app.showWarning(model.Name_Outlet_E.element, 'Please input this box.');
			return;
		} else {
			if (model.ID() == '') {
				if (self.listModel().some(r => r.Code_Vill_T == model.Code_Vill_T() && r.Name_Outlet_E == model.Name_Outlet_E())) {
					app.showWarning(model.Name_Outlet_E.element, 'Already existed.');
					return;
				}
			} else {
				if (self.listModel().some(r => r.Code_Vill_T == model.Code_Vill_T() && r.Name_Outlet_E == model.Name_Outlet_E() && r.ID != model.ID())) {
					app.showWarning(model.Name_Outlet_E.element, 'Already existed.');
					return;
				}
			}
		}
		$('#modalEdit').modal('hide');

		model = app.unko(model);
		var submit = { submit: JSON.stringify(model) };

		app.ajax('/SystemMenu/saveDO', submit).done(function (id) {
			if (model.ID() == '') {
				model.ID = id;
				self.listModel.unshift(model);
			} else {
				var old = self.listModel().find(r => r.ID == model.ID);
				self.listModel.replace(old, model);
			}
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblDrugOutlets',
				value: { Deleted: 1 },
				where: { ID: model.ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/update', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.getOdName = function (code) {
		var obj = self.odList().find(r => r.code == code)
		return obj == null ? code : obj.name;
	};

	self.getVillName = function (code) {
		var obj = villageData.find(r => r.code == code)
		return obj == null ? '' : obj.name;
	};
}