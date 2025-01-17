function subViewModel(self) {
	var tableName = 'tblQMFollowup';

	self.getData(tableName);

	self.detailModel.subscribe(function (model) {
		var temp = model.Disease();
		var oldValue = model.Disease.oldValue;
		temp = isnullempty(temp) ? [] : temp.split(', ');
		model.Disease = ko.observableArray(temp);
		model.Disease.oldValue = oldValue;

		var temp = model.MalariaTreatment();
		var oldValue = model.MalariaTreatment.oldValue;
		temp = isnullempty(temp) ? [] : temp.split(', ');
		model.MalariaTreatment = ko.observableArray(temp);
		model.MalariaTreatment.oldValue = oldValue;

		var temp = model.AntibioticTreatment();
		var oldValue = model.AntibioticTreatment.oldValue;
		temp = isnullempty(temp) ? [] : temp.split(', ');
		model.AntibioticTreatment = ko.observableArray(temp);
		model.AntibioticTreatment.oldValue = oldValue;

		var temp = model.OtherTreatment();
		var oldValue = model.OtherTreatment.oldValue;
		temp = isnullempty(temp) ? [] : temp.split(', ');
		model.OtherTreatment = ko.observableArray(temp);
		model.OtherTreatment.oldValue = oldValue;
	});

	self.checkboxOtherChange = function (model, event) {
		var element = event.currentTarget;
		model[element.name](element.checked ? ['Other'] : []);
	};

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
		if (model.PatientCode() == '') {
			scrollToElement(model.PatientCode.element);
			app.showMsg('Missing Data', 'Please input Patient Code');
			return;
		}
		if (Rec_ID == '' && self.listModel().some(r => r.PatientCode == model.PatientCode())) {
			scrollToElement(model.PatientCode.element);
			app.showMsg('Duplicate Patient Code', 'This Patient Code is already existed');
			return;
		}
		if (!isnullempty(model.Temp()) && (model.Temp() < 30 || model.Temp() > 45)) {
			scrollToElement(model.Temp.element);
			app.showMsg('Incorrect Data', 'Please input Axillary temperature between 30.0 and 45.0');
			return;
		}

		model = app.unko(self.detailModel());

		model.Temp = isempty(model.Temp, null);

		model.Disease = model.Disease.join(', ');
		if (!model.Disease.contain('Other')) model.DiseaseOther = null;

		model.MalariaTreatment = model.MalariaTreatment.join(', ');
		if (!model.MalariaTreatment.contain('Other')) model.MalariaTreatmentOther = null;

		model.AntibioticTreatment = model.AntibioticTreatment.join(', ');
		if (!model.AntibioticTreatment.contain('Other')) model.AntibioticTreatmentOther = null;

		model.OtherTreatment = model.OtherTreatment.join(', ');
		if (!model.OtherTreatment.contain('Other')) model.OtherTreatmentOther = null;

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

				self.view('list');
			});
		} else if (changeLogs.length > 0) {
			app.ajax('/Direct/update', submit).done(function (rs) {
				var old = self.listModel().find(r => r.Rec_ID == Rec_ID);
				self.listModel.replace(old, rs);

				var submit = {
					table: 'tblQMFollowupLog',
					batch: changeLogs
				};
				submit = { submit: JSON.stringify(submit) };
				app.ajax('/Direct/insert', submit).done(function () {
					self.view('list');
				});
			});
		}
	};

	self.choosePlace = function () {
		self.placeModel1().showEnglish(function (p) {
			self.detailModel().Code_Facility_T(p.hc());
		});
	};
}

