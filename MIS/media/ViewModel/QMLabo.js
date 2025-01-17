function subViewModel(self) {
	var tableName = 'tblQMLabo';

	self.getData(tableName);

	self.detailModel.subscribe(function (model) {
		model.ParticipantCode(model.ParticipantCode().substr(-6));
	});

	function scrollToElement(e) {
		$(e).get(0).scrollIntoView();
		window.scrollTo(window.scrollX, window.scrollY - 80);
	}

	self.save = function () {
		var model = self.detailModel();
		var Rec_ID = model.Rec_ID();

		if (Rec_ID == '' && model.Code_Facility_T() == '') {
			scrollToElement(document.getElementById('hcname'));
			app.showMsg('Missing Data', 'Please input Health Center');
			return;
		}
		if (model.ParticipantCode() == '') {
			scrollToElement(model.ParticipantCode.element);
			app.showMsg('Missing Data', 'Please input Patient Code');
			return;
		}
		if (Rec_ID == '' && self.listModel().some(r => r.ParticipantCode == 'MA011' + model.ParticipantCode())) {
			scrollToElement(model.ParticipantCode.element);
			app.showMsg('Duplicate Patient Code', 'This Patient Code is already existed');
			return;
		}
		if (model.BloodDate() != null) {
			if (model.BloodKeepingDate() != null && model.BloodKeepingDate().format('YYYYMMDD') < model.BloodDate().format('YYYYMMDD')) {
				scrollToElement(model.BloodKeepingDate.element);
				app.showMsg('Incorrect Data', 'Date of freezing sample cound not be earlier than Date of blood sample');
				return;
			}
			if (model.TestDate() != null && model.TestDate().format('YYYYMMDD') < model.BloodDate().format('YYYYMMDD')) {
				scrollToElement(model.TestDate.element);
				app.showMsg('Incorrect Data', 'Date of testing sample cound not be earlier than Date of blood sample');
				return;
			}
		}
		if (model.CRPLevel() != '' && model.CRPLevel() == 0) {
			scrollToElement(model.CRPLevel.element);
			app.showMsg('Incorrect Data', 'Level of CRP measured cound not be zero');
			return;
		}
		
		model = app.unko(self.detailModel());
		model.ParticipantCode = 'MA011' + model.ParticipantCode;

		var changeLogs = [];

		Object.keys(model).forEach(name => {
			if (name == '__ko_mapping__') return;

			if (self.datatype.date.contain(name) && model[name] != null) model[name] = model[name].format('YYYY-MM-DD');

			var oldValue = self.detailModel()[name].oldValue;
			var newValue = model[name];
			if (oldValue !== newValue) {
				changeLogs.push({
					ParentID: Rec_ID,
					Name: name,
					OldValue: oldValue,
					NewValue: newValue,
					ModiUser: app.user.username
				});
			}
		});

		delete model.Rec_ID;
		delete model.InitTime;
		delete model.Code_Prov_N;
		delete model.Code_OD_T;

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

				self.back();
			});
		} else if (changeLogs.length > 0) {
			app.ajax('/Direct/update', submit).done(function (rs) {
				var old = self.listModel().find(r => r.Rec_ID == Rec_ID);
				self.listModel.replace(old, rs);

				var submit = {
					table: 'tblQMLaboLog',
					batch: changeLogs
				};
				submit = { submit: JSON.stringify(submit) };
				app.ajax('/Direct/insert', submit).done(self.back);
			});
		} else {
			self.back();
		}
	};

	self.choosePlace = function () {
		self.placeModel1().showEnglish(function (p) {
			self.detailModel().Code_Facility_T(p.hc());
		});
	};
}