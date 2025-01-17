function subViewModel(self) {
	var tableName = 'tblQMBasicData';

	self.getData(tableName);

	self.save = function () {
		var model = app.unko(self.detailModel());
		var Rec_ID = model.Rec_ID;

		Object.keys(model).forEach(name => {
			if (self.datatype.date.contain(name)) model[name] = model[name].format('YYYY-MM-DD');
		});

		model.ModiUser = app.user.username;
		model.ModiTime = 'getdate()';
		delete model.Rec_ID;
		delete model.InitTime;
		delete model.Code_Prov_N;
		delete model.Code_OD_T;

		var submit = {
			table: tableName,
			value: model,
			where: { Rec_ID: Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function (rs) {
			var old = self.listModel().find(r => r.Rec_ID == Rec_ID);
			self.listModel.replace(old, rs);

			self.view('list');
		});
	};

	self.choosePlace = function () {
		self.placeModel1().show(function (p) {
			self.detailModel().Code_Facility_T(p.hc());
		});
	};
}