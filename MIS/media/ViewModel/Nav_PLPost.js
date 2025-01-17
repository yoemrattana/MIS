function viewModel() {
	var self = this;

	self.editModel = ko.observable();

	self.provList = ko.observableArray();
	self.prov = ko.observable();
	self.troop = ko.observable();

	self.mainData = ko.observableArray();
	var troops = ko.observableArray();

	app.ajax('/SystemMenu/getPLPost').done(function (rs) {
		var provs = rs.distinct(r => r.Code_Prov_T).map(r => {
			return {
				code: r.Code_Prov_T,
				name: r.Name_Prov_E
			}
		});
		self.provList(provs);

		var founds = rs.distinct(r => r.Code_Troop_T).map(r => {
			return {
				code: r.Code_Troop_T,
				name: r.Name_Troop_K,
				pvcode: r.Code_Prov_T
			}
		});
		troops(founds);

		self.mainData(rs);
	});

	self.troopList = ko.pureComputed(function () {
		return self.prov() == null ? troops() : troops().filter(r => r.pvcode == self.prov());
	});

	self.listModel = ko.pureComputed(function () {
		return self.troop() != null ? self.mainData().filter(r => r.Code_Troop_T == self.troop())
			: self.prov() != null ? self.mainData().filter(r => r.Code_Prov_T == self.prov())
			: self.mainData();
	});

	self.showCreate = function () {
		var arr = self.mainData().map(r => r.Code_Post_T);
		var model = {
			Code_Troop_T: null,
			Code_Post_T: (Math.max(...arr) + 1).toString().padStart(3, '0'),
			Name_Post_E: '',
			Name_Post_K: '',
			Rec_ID: 0
		};

		self.showEdit(model);
	};

	self.showEdit = function (model) {
		model = app.ko(model);

		if (model.Code_Prov_T === undefined) model.Code_Prov_T = ko.observable();

		model.troopList = ko.pureComputed(function () {
			return troops().filter(r => r.pvcode == model.Code_Prov_T());
		});

		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		model.Name_Post_E(model.Name_Post_E().trim());
		model.Name_Post_K(model.Name_Post_K().trim());

		var missing = false;
		if (model.Rec_ID() == 0 && model.Code_Prov_T() == null) {
			app.showWarning(model.Code_Prov_T.element, 'Please input this box.');
			missing = true;
		}
		if (model.Code_Troop_T() == null) {
			app.showWarning(model.Code_Troop_T.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Post_K() == '') {
			app.showWarning(model.Name_Post_K.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');
		model = app.unko(model);

		var submit = {
			submit: JSON.stringify({
				value: {
					Code_Post_T: model.Code_Post_T,
					Name_Post_E: model.Name_Post_E,
					Name_Post_K: model.Name_Post_K,
					Code_Troop_T: model.Code_Troop_T
				},
				where: { Rec_ID: model.Rec_ID }
			})
		};

		app.ajax('/SystemMenu/savePost', submit).done(function (rs) {
			if (model.Rec_ID == 0) {
				self.mainData.push(rs);
			} else {
				var old = self.mainData().find(r => r.Rec_ID == model.Rec_ID);
				self.mainData.replace(old, rs);
			}
		});
	};

	self.delete = function (model) {
		app.showDelete(function () {
			var submit = { Rec_ID: model.Rec_ID };
			app.ajax('/SystemMenu/deletePost', submit).done(function () {
				self.mainData.remove(model);
			});
		});
	};
}