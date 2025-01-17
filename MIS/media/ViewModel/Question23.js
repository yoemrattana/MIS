function subViewModel(self) {

	self.getData('tblQuestion23');

	self.save = function () {
		var model = app.unko(self.detailModel());
		var Rec_ID = model.Rec_ID;

		if (Rec_ID == null) {
			model.InitUser = app.user.username;
			model.InitTime = 'getdate()';
			model.ModiUser = null;
			model.ModiTime = null;
			model.SubmitOD = app.user.role == 'OD' ? app.user.od : null;
			url = '/Direct/insert';
		} else {
			model.ModiUser = app.user.username;
			model.ModiTime = 'getdate()';
			url = '/Direct/update';
		}
		delete model.Rec_ID;

		var submit = {
			table: 'tblQuestion23',
			value: model,
			where: { Rec_ID: Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax(url, submit).done(function (rs) {
			if (Rec_ID == null) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == Rec_ID);
				self.listModel.replace(old, rs);
			}
			
			self.view('list');
		});
	};

	self.choosePlace = function () {
		self.placeModel1().show(4, function (p) {
			var model = self.detailModel();
			model.Code_Prov_T(p.prov());
			model.Code_OD_T(p.od());
			model.Code_Facility_T(p.hc());
			model.Code_Vill_T(p.vill());
		});
	};

	self.chooseMMW = function () {
		self.placeModel1().show(4, function (p) {
			var model = self.detailModel();
			model.A2HFMMW(p.hc());
			model.A2VillMMW(p.vill());
		});
	};

	self.chooseVill = function () {
		self.placeModel1().show(4, function (p) {
			var model = self.detailModel();
			model.A2VOR(p.vill());
		});
	};
}