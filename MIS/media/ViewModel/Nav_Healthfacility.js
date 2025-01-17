function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();
	self.odList = ko.observableArray();

	self.typeList = ko.observableArray(['HC', 'HP', 'RH', 'PRH', 'NH']);
	self.odFilter = ko.observable();
	self.isAdmin = ko.observable(app.user.role == 'AU');

	var mainData = [];
	var prov = $('#code_prov').val();
	var place = null;

	app.getPlace(['pv', 'od', 'ds', 'cm', 'vl'], function (p) {
		place = p;
		self.odList(p.od.filter(r => r.pvcode == prov));

		app.ajax('/SystemMenu/getHF/' + prov).done(function (data) {
			mainData = data;
			self.listModel(mainData);
		});
	});

	self.showCreate = function () {
		var model = {
			Code_Prov_N: prov,
			Code_OD_T: '',
			Name_OD_E: '',
			Name_Facility_E: '',
			Name_Facility_K: '',
			Code_Facility_T: '',
			Type_Facility: '',
			Lat: '',
			long: '',
			Code_Vill_T: '',
			HIS_HFCode: '',
			isnew: 1
		};

		self.showEdit(model);
	};

	self.showEdit = function (model) {
		if (model.Code_Vill_T == null || model.Code_Vill_T == '') {
			model.commCode = null;
			model.distCode = null;
		} else {
			model.commCode = place.vl.find(r => r.code == model.Code_Vill_T).cmcode;
			model.distCode = place.cm.find(r => r.code == model.commCode).dscode;
		}
		model = app.ko(model);

		model.pvList = ko.observableArray(place.pv);
		model.odList = () => place.od.filter(r => r.pvcode == model.Code_Prov_N());
		model.distList = () => place.ds.filter(r => r.pvcode == model.Code_Prov_N());
		model.commList = () => place.cm.filter(r => r.dscode == model.distCode());
		model.villList = () => place.vl.filter(r => r.cmcode == model.commCode());

		if (model.Code_Facility_T() == '') {
			model.Code_OD_T.subscribe(code => {
				var found = self.listModel().filter(r => r.Code_OD_T == code);
				var n = 0;
				found.forEach(r => {
					var v = parseInt(r.Code_Facility_T.substr(-2));
					if (n < v) n = v;
				});
				n = (n + 1).toString().padStart(2, '0');
				model.Code_Facility_T(code + n);
			});
		}

		self.editModel(model);

		app.setNumberOnly(model.Code_Facility_T.element, 'int');
		app.setNumberOnly(model.HIS_HFCode.element, 'int');
		app.setNumberOnly(model.Lat.element, 'float');
		app.setNumberOnly(model.long.element, 'float');

		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		model.Name_Facility_E(model.Name_Facility_E().trim());
		model.Name_Facility_K(model.Name_Facility_K().trim());
		model.Code_Facility_T(model.Code_Facility_T().trim());

		var missing = false;
		if (model.Name_Facility_E() == '') {
			app.showWarning(model.Name_Facility_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Facility_K() == '') {
			app.showWarning(model.Name_Facility_K.element, 'Please input this box.');
			missing = true;
		}
		if (model.Code_Facility_T() == '') {
			app.showWarning(model.Code_Facility_T.element, 'Please input this box.');
			missing = true;
		}
		//if (isnullempty(model.HIS_HFCode())) {
		//	app.showWarning(model.HIS_HFCode.element, 'Please input this box.');
		//	missing = true;
		//}
		//if (model.Code_Vill_T() == null) {
		//	app.showWarning(model.Code_Vill_T.element, 'Please input this box.');
		//	missing = true;
		//}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);
		model.Name_OD_E = place.od.find(r => r.code == model.Code_OD_T).name;

		var submit = { submit: JSON.stringify(model) };
		app.ajax('/SystemMenu/saveHF', submit).done(function () {
			if (model.isnew == 1) {
				self.listModel.unshift(model);
			} else {
				model.isnew = 0;
				var old = self.listModel().find(r => r.Code_Facility_T == model.Code_Facility_T);
				self.listModel.replace(old, model);
			}
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = { code: model.Code_Facility_T }
			app.ajax('/SystemMenu/deleteHF', submit).done(function (error) {
				if (error == null) self.listModel.remove(model);
				else app.showMsg('Unable to Delete', 'This HF is in relationship with other tables.', true);
			});
		});
	};

	self.odFilter.subscribe(function (code) {
		if (code == null) {
			self.listModel(mainData);
		} else {
			self.listModel(mainData.filter(r => r.Code_OD_T == code));
		}
	});

	self.getOdName = function (code) {
		var obj = place.od.find(r => r.code == code)
		return obj == null ? id : obj.name;
	};

	self.getDistName = function (code) {
		if (code == null || code == '') return '';

		var obj = place.vl.find(r => r.code == code);
		if (obj == null) return '';
		var obj = place.cm.find(r => r.code == obj.cmcode);
		if (obj == null) return '';
		var obj = place.ds.find(r => r.code == obj.dscode);
		return obj == null ? '' : obj.name;
	};

	self.getCommName = function (code) {
		if (code == null || code == '') return '';

		var obj = place.vl.find(r => r.code == code);
		if (obj == null) return '';
		var obj = place.cm.find(r => r.code == obj.cmcode);
		return obj == null ? '' : obj.name;
	};

	self.getVillName = function (code) {
		if (code == null || code == '') return '';

		var obj = place.vl.find(r => r.code == code)
		return obj == null ? '' : obj.name;
	};
}