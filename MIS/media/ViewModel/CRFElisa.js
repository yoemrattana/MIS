function subViewModel(self) {
	var tableName = 'tblCRFElisa';

	self.getData(tableName);

	self.save = function () {
		var model = self.detailModel();
		var Rec_ID = model.Rec_ID();

		var error = self.validateCode(model.ParticipantCode());
		if (!!error) {
			app.showWarning(model.ParticipantCode.element, error);
			return;
		}

		model = app.unko(self.detailModel());

		Object.keys(model).forEach(name => {
			if (self.datatype.date.contain(name) && model[name] != null) model[name] = model[name].format('YYYY-MM-DD');
		});

		delete model.Rec_ID;
		delete model.InitTime;

		if (Rec_ID == '') {
			delete model.ModiUser;
			delete model.ModiTime;
		} else {
			model.ModiUser = app.user.username;
			model.ModiTime = 'getdate()';
		}

		var submit = {
			table: tableName,
			value: model,
			where: { Rec_ID: Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		if (Rec_ID == '') {
			app.ajax('/Direct/insert', submit).done(function (rs) {
				self.listModel.push(rs);

				self.view('list');
			});
		} else {
			app.ajax('/Direct/update', submit).done(function (rs) {
				var old = self.listModel().find(r => r.Rec_ID == Rec_ID);
				self.listModel.replace(old, rs);

				self.view('list');
			});
		}
	};
}