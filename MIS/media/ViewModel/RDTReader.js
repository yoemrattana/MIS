function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.detailModel = ko.observable();
	self.view = ko.observable('list');
	self.yearList = [];
	self.monthList = [];
	self.year = ko.observable(moment().year());
	self.month = ko.observable(moment().format('MM'));
	self.hc = ko.observable();
	self.show = ko.observable(true);

	for (var i = 2018; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}
	for (var i = 1; i <= 12; i++) {
		self.monthList.push(('0' + i).substr(-2));
	}

	var newModel = null;
	var mainData = [];
	var dataChanged = false;

	self.hcList = [
		{ code: "01", name: "Trapeang Cho" },
		{ code: "09", name: "Kampong Speu RH" },
		{ code: "17", name: "Svay Chochep" },
		{ code: "06", name: "Monor Rung Roeang" },
		{ code: "10", name: "Cheung Roas Samaki" },
		{ code: "05", name: "Chambak" },
		{ code: "14", name: "Ta Lat" },
		{ code: "18", name: "Trapeang Kraloeung" },
		{ code: "19", name: "Bakan RH" },
		{ code: "12", name: "Chheu Tom" },
		{ code: "13", name: "Boeng Kantuot" },
		{ code: "15", name: "Chhouk Meas" },
		{ code: "02", name: "Phnom Kravanh" },
		{ code: "03", name: "Pramaoy" },
		{ code: "04", name: "Samraong" },
		{ code: "07", name: "Phnom Kravanh_RH" },
		{ code: "08", name: "Prongil" },
		{ code: "11", name: "Anglong Reap" },
		{ code: "16", name: "Pursat RH" },
		{ code: "20", name: "Ro Leab" }
	];

	if (self.show()) {
	    app.ajax('/RDTReader/getData').done(function (rs) {
			newModel = rs.model;
			mainData = rs.data;

			var list = mainData.filter(r => moment(r.InitTime).format('YYYY') == moment().year());
			list = list.filter(r => moment(r.InitTime).format('MM') == moment().format('MM'));
			self.listModel(list);
		});
	}

	self.showNew = function () {
		if (app.user.od != '') newModel.Code_OD_T = app.user.od;
		self.showDetail(newModel);
	};

	self.showDetail = function (model) {
		model = app.ko(model);
		model.image('/RDTReader/getImage/' + model.image());
		model.test_start_time(self.toDate(model.test_start_time()));
		model.scan_time(self.toDate(model.scan_time()));

		self.detailModel(model);
		self.view('detail');
	};

	self.toDate = function (unixDate) {
		return moment(parseInt(unixDate)).utcOffset(7);
	};

	function toUnixDate(date) {
		return moment(date.format().substr(0, 19) + '+07:00').format('x');
	}

	function getPatient() {
		var model = self.detailModel();
		var code = model.Code_Vill_T();
		var date = model.FociInvestigationDate();

		if (code == null || date == null) {
			resetPatient();
			return;
		}

		var merged = code + date.format('YYYY-MM-DD');
		if (merged == lastRequest) return;
		lastRequest = merged;

		function getDate(y) {
			return date.clone().add(y, 'year').format('YYYY-MM-DD');
		}

		var submit = {
			code: code,
			dateFrom1y: getDate(-1),
			dateFrom3y: getDate(-3),
			dateTo: getDate(0),
			oneYearAgo: { from: getDate(-2), to: getDate(-1) },
			twoYearAgo: { from: getDate(-3), to: getDate(-2) },
			threeYearAgo: { from: getDate(-4), to: getDate(-3) },
			fourYearAgo: { from: getDate(-5), to: getDate(-4) },
			fiveYearAgo: { from: getDate(-6), to: getDate(-5) },
		};
		app.ajax('/FociInvestigation/getPatient', submit).done(function (rs) {
			self.patientList(rs.investigation);
			self.bednet({
				y3llin: rs.bednet3y.LLIN,
				y3llihn: rs.bednet3y.LLIHN,
				y1llin: rs.bednet1y.LLIN,
				y1llihn: rs.bednet1y.LLIHN
			});

			var p = is(rs.profile, undefined, null);
			if (p != null) {
				p.Job = p.Agriculture == 1 ? 'កសិករ'
					: p.Manufacture == 1 ? 'បុគ្គលិក រឺ កម្មករ'
					: p.Student == 1 ? 'សិស្ស'
					: p.Trade == 1 ? 'អ្នកជំនួញ'
					: p.Civil_Servant == 1 ? 'មន្ត្រីរាជការ'
					: p.Other_Activity_Note;

				p.Address = getAddress(code);

				p.DiagnosisPlace = p.Point_Of_Care_Name != null && p.Point_Of_Care_Name != '' ? p.Point_Of_Care_Name : 'មណ្ឌលសុខភាព' + p.Health_Center_Name;
				p.DiagnosisDuration = p.DateCase == null ? null : moment(p.InitTime.substr(0, 10)).diff(p.DateCase.substr(0, 10), 'day');

				model.InvestigationID(p.Id);
			}
			self.profile(p);

			if (model.Lat() == null) {
				model.Lat(rs.gps.Lat);
				model.Long(rs.gps.Long);
			}

			self.classify(rs.classify);
		});
	}

	function trimKO(value) {
		if (value() != null) value(value().trim());
	}

	function checkInputMissing() {
		var model = self.detailModel();
		var missing = false;
		if (model.patient_id() == '') {
			showWarning(model.patient_id, missing);
			missing = true;
		}
		if (model.operator_name() == '') {
			showWarning(model.operator_name, missing);
			missing = true;
		}
		
		return missing;
	}

	self.save = function () {
		var model = self.detailModel();

		trimKO(model.operator_name);

		if (checkInputMissing()) return;

		model = app.unko(model);

		model.test_start_time = toUnixDate(model.test_start_time);
		model.scan_time = toUnixDate(model.scan_time);

		if (model.image != null && model.image.contain('.jpg')) {
			model.image = model.image.split('/').last();
		}

		var submit = { submit: JSON.stringify(model) };
		app.ajax('/RDTReader/save', submit).done(function (rs) {
			if (model.post_id == null) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.post_id == model.post_id);
				self.listModel.replace(old, rs);
			}
			self.view('list');
		});
	};

	self.delete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblMalariaRDT',
				where: { post_id: model.post_id }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.back = function () {
		if (dataChanged) {
			$('#modalSave').modal('show');
			$('#modalSave .btn-primary').off().click(self.save);
			$('#modalSave .btn-danger').off().click(() => self.view('list'));
		} else {
			self.view('list');
		}
	};

	self.selectFile = function () {
		$('#file').val('').click();
	};

	self.fileChanged = function (files) {
		var reader = new FileReader();
		reader.onload = function () {
			var img = new Image();
			img.src = reader.result;
			img.onload = function () {
				var w = img.width > 800 ? 800 : img.width;
				var h = img.height * (w / img.width);

				var canvas = document.createElement('canvas');
				canvas.width = w;
				canvas.height = h;

				var ctx = canvas.getContext('2d');
				ctx.drawImage(img, 0, 0, w, h);

				self.detailModel().image(canvas.toDataURL('image/jpeg', 0.9));
			};
		};
		reader.readAsDataURL(files[0]);
	};

	self.year.subscribe(filter);

	self.month.subscribe(filter);

	self.hc.subscribe(filter);

	function filter() {
		var list = mainData.filter(r => moment(r.InitTime).format('YYYY') == self.year());

		if (self.month() != null) list = list.filter(r => moment(r.InitTime).format('MM') == self.month());

		if (self.hc() != null) {
			list = list.filter(r => {
				var patient = r.patient_id;
				var code = patient.substring(5, 7);
				return code == self.hc();
			})
		}
			

		self.listModel(list);
	}

	self.getHcName = function(patient) {
		var code = patient.substring(5, 7);
		var hf = self.hcList.find(r=> r.code.trim() == code.trim());
		return hf == undefined ? patient : hf.name;
	}

	function showWarning(bindingValue, secondWarning) {
		var el = $(bindingValue.element);

		if (secondWarning === false) {
			$(window).scrollTop(0);
			el.focus();
		}

		function addError() {
			el.parent().addClass('has-error');
		}
		function removeError() {
			el.parent().removeClass('has-error');
		}
		function checkValue() {
			bindingValue() == null || bindingValue() === '' ? addError() : removeError();
		}
		addError();

		if (el.data('hasWarnEvent') === true) return;
		el.data('hasWarnEvent', true);
		bindingValue.subscribe(checkValue);
	}
}