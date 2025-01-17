function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	self.provList = ko.observableArray();
	self.distList = ko.observableArray();
	self.prov = ko.observable();
	self.dist = ko.observable();

	var mainData = [];
	var distData = [];

	app.getPlace(['pv', 'ds'], function (p) {
		distData = p.ds;
		self.provList(p.pv);
		self.prov(location.pathname.split('/')[3]);

		app.ajax('/SystemMenu/getCommune').done(function (rs) {
			mainData = rs;
			self.prov.notifySubscribers(self.prov());
		});
	});

	self.showCreate = function () {
		var model = {
			Code_Comm_T: '',
			Name_Comm_E: '',
			Name_Comm_K: '',
		};

		self.showEdit(model);
	};

	self.showEdit = function (model) {
		model.isNew = model.Code_Comm_T == '';
		model.dist = null;

		model = app.ko(model);
		self.editModel(model);

		model.dist.subscribe(code => {
			if (code == null) {
				model.Code_Comm_T('');
				return;
			}
			var found = mainData.filter(r => r.Code_Dist_T == code);
			var n = 0;
			found.forEach(r => {
				var v = parseInt(r.Code_Comm_T.substr(4, 2));
				if (n < v) n = v;
			});
			n = (n + 1).toString().padStart(2, '0');
			model.Code_Comm_T(code + n);
		});

		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		model.Name_Comm_E((model.Name_Comm_E() || '').trim());
		model.Name_Comm_K((model.Name_Comm_K() || '').trim());

		var missing = false;
		if (model.isNew() && model.dist() == null) {
			app.showWarning(model.dist.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Comm_E() == '') {
			app.showWarning(model.Name_Comm_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Comm_K() == '') {
			app.showWarning(model.Name_Comm_K.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);

		var submit = {
			submit: JSON.stringify({
				value: { Name_Comm_E: model.Name_Comm_E, Name_Comm_K: model.Name_Comm_K },
				where: { Code_Comm_T: model.Code_Comm_T },
				isnew: model.isNew
			})
		};

		app.ajax('/SystemMenu/saveCommune', submit).done(function () {
			if (model.isNew) {
				var p = self.provList().find(r => r.code == self.prov());
				model.Code_Prov_T = p.code;
				model.Name_Prov_E = p.name;
				model.Name_Prov_K = p.nameK;
				var d = self.distList().find(r => r.code == self.dist());
				model.Code_Dist_T = d.code;
				model.Name_Dist_E = d.name;
				model.Name_Dist_K = d.nameK;

				self.listModel.push(model);
			} else {
				var old = self.listModel().find(r => r.Code_Comm_T == model.Code_Comm_T);
				self.listModel.replace(old, model);
			}
		});
	};

	self.delete = function (model) {
		app.showDelete(function () {
			var submit = { code: model.Code_Comm_T };
			app.ajax('/SystemMenu/deleteCommune', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.prov.subscribe(function (pv) {
		var before = self.dist();
		self.distList(distData.filter(r => r.pvcode == pv));
		if (self.dist() == before) updateFilter();
	});

	self.dist.subscribe(updateFilter);

	function updateFilter() {
		if (self.dist() != null) {
			self.listModel(mainData.filter(r => r.Code_Dist_T == self.dist()));
		} else {
			self.listModel(mainData.filter(r => r.Code_Prov_T == self.prov()));
		}
	}
}