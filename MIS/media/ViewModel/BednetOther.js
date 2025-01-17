function viewModel() {
	var self = this;

	self.detailList = ko.observableArray();
	self.provList = ko.observableArray();
	self.yearList = [];
	self.monthList = [];

	var ready = false;
	var firstWarnElement = null;
	var deletedList = [];

	for (var i = 2017; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}
	for (var i = 1; i <= 12; i++) {
		self.monthList.push(moment(i, 'M').format('MM'));
	}

	app.ajax('bednetOtherGetReport').done(function (rs) {
		self.provList(rs.prov);
		prepareDetail(rs.detail);
	});

	function prepareDetail(rs) {
		var details = [];
		rs.push(createObj());
		rs.forEach(r => details.push(convertObj(r)));

		ready = false;
		self.detailList(details);
		details.forEach(r => {
			app.setNumberOnly(r.LLIN.element, 'int');
			app.setNumberOnly(r.LLIHN.element, 'int');
		});
		ready = true;

		deletedList = [];
	}

	self.addCase = function (model) {
		if (warnDetail(model)) {
			app.showMsg('<kh>ខ្វះទិន្នន័យ</kh> - Missing Data', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh><br><br>Please input data in red box');
			return;
		}
		removeAllWarning();

		model.Rec_ID(0);

		ready = false;
		var newModel = convertObj(createObj());
		self.detailList.push(newModel);

		app.setNumberOnly(newModel.LLIN.element, 'int');
		app.setNumberOnly(newModel.LLIHN.element, 'int');

		ready = true;
	};

	self.deleteCase = function (model) {
		if (model.Rec_ID() > 0) {
			deletedList.push(model);
		}
		self.detailList.remove(model);
	};

	self.saveReport = function (back) {
		var missing = false;
		firstWarnElement = null;

		var details = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed);
		details.forEach(d => {
			if (warnDetail(d)) missing = true;
		});

		if (missing) {
			app.showMsg('<kh>ខ្វះទិន្នន័យ</kh> - Missing Data', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh><br><br>Please input data in red box');
			var top = $(firstWarnElement).offset().top;
			if (top < window.scrollY || top > window.scrollY + window.innerHeight - 50) {
				window.scrollTo(window.scrollX, top - 80);
			}
			return;
		}
		removeAllWarning();

		var submit = [];

		details = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed);
		details.forEach(d => {
			submit.push({
				Rec_ID: d.Rec_ID(),
				Year: d.Year(),
				Month: d.Month(),
				Code_Prov_T: is(d.Code_Prov_T(), undefined, null),
				Place: d.Place(),
				LLIN: d.LLIN(),
				LLIHN: d.LLIHN(),
				HamokNet: d.HamokNet(),
				Mobile: d.Mobile()
			});
		});

		deletedList.forEach(d => submit.push({ Rec_ID: d.Rec_ID() * -1 }));

		app.ajax('bednetOtherUpdateReport', { submit: JSON.stringify(submit) }).done(function (rs) {
			if (back !== true) prepareDetail(rs);
			if (back === true) self.back(true);
		});
	};

	self.back = function (dontAsk) {
		if (dontAsk !== true) {
			var dchanged = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed).length > 0;
			var deleted = deletedList.length > 0;
			if (dchanged || deleted) {
				showSave(() => setTimeout(() => {
					self.saveReport(true);
				}, 100), () => self.back(true));
				return;
			}
		}
		location = '/Home';
	};

	function createObj() {
		return {
			Rec_ID: -1,
			Year: null,
			Month: null,
			Code_Prov_T: null,
			Place: '',
			LLIN: '',
			LLIHN: '',
			HamokNet: '',
			Mobile: 1
		};
	}

	function convertObj(r) {
		var obj = app.ko(r);

		obj.changed = false;
		for (var key in createObj()) {
			obj[key].subscribe(function () {
				if (ready) obj.changed = true;
			});
		}

		return obj;
	}

	function warnDetail(model) {
		var missing = false;
		if (model.Year() == null) { showWarning(model.Year); missing = true; }
		if (model.Month() == null) { showWarning(model.Month); missing = true; }
		if (model.Place() === '') { showWarning(model.Place); missing = true; }
		if (model.LLIN() === '') { showWarning(model.LLIN); missing = true; }
		if (model.LLIHN() === '') { showWarning(model.LLIHN); missing = true; }

		return missing;
	}

	var lstWarnDestroyFn = [];
	function showWarning(bindingValue) {
		var el = $(bindingValue.element);

		function addError() {
			el.css('border', '2px solid red');
		}

		function removeError() {
			el.css('border', '');
		}

		function checkValue() {
			bindingValue() == null || bindingValue() === '' ? addError() : removeError();
		}

		function destroy() {
			if (el.data('warnEvent') != null) el.data('warnEvent').dispose();
			el.data('warnEvent', null);
			removeError();
		}
		addError();

		if (firstWarnElement == null) firstWarnElement = el[0];

		if (el.data('warnEvent') != null) return;
		el.data('warnEvent', bindingValue.subscribe(checkValue))
		el[0].destroyWarning = destroy;
		lstWarnDestroyFn.push(destroy);
	};

	function removeAllWarning() {
		lstWarnDestroyFn.forEach(function (fn) { fn(); });
		lstWarnDestroyFn = [];
	};

	function showSave(callYes, callNo) {
		$('#modalSave').modal('show');
		$('#modalSave .btn-primary').off().click(callYes);
		$('#modalSave .btn-danger').off().click(callNo);
	}
}