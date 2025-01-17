function viewModel() {
	var self = this;
	var today = moment();

	self.odList = ko.observableArray();
	self.reportList = ko.observableArray();
	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	self.year = ko.observable(today.year());
	self.od = ko.observable();
	self.view = ko.observable('report');

	var prov = sessionStorage.code_prov;
	var currentReport = null;
	var ready = false;
	var place = null;
	var hfLog = [];

	app.getPlace(['pv', 'od', 'hc', 'ds', 'cm', 'vl'], function (p) {
		place = p;

		self.odList(place.od.filter(r => r.pvcode == prov && r.target == 1));
		ready = true;

		if (self.odList().length == 1) self.getReport();
	});

	self.previousYear = function () {
		self.year(self.year() - 1);
		self.getReport();
	};

	self.nextYear = function () {
		self.year(self.year() + 1);
		self.getReport();
	};

	self.od.subscribe(function () {
		if (ready) self.getReport();
	});

	self.getReport = function () {
		if (self.od() == null) {
			self.reportList([]);
			return;
		}

		var submit = { year: self.year(), od: self.od() };
		app.ajax('/PPMReferralSlip/getReport', submit).done(function (rs) {
			hfLog = rs.hfs;
			var hfs = hfLog.distinct(r => r.Code_Facility_T);
			hfs.forEach(hf => {
				hf.reports = [];
				for (var i = 1; i <= 12; i++) {
					var m = ('0' + i).substr(-2);
					var obj = {
						id: hf.Code_Facility_T,
						en: hf.Name_Facility_E,
						kh: hf.Name_Facility_K,
						month: m,
						has: ko.observable(rs.reports.some(r => r.Code_Facility_T == hf.Code_Facility_T && r.Month == m))
					};
					hf.reports.push(obj);
				}
			});
			self.reportList(hfs);
		});
	};

	self.showList = function (model) {
		currentReport = model;

		var submit = {
			Year: self.year(),
			Month: currentReport.month,
			Code_Facility_T: currentReport.id
		};
		app.ajax('/PPMReferralSlip/getList', submit).done(function (rs) {
			self.listModel(rs);
			self.view('list');
		});
	};

	function newModel() {
		return {
			Rec_ID: 0,
			Code_Facility_T: currentReport.id,
			Year: self.year(),
			Month: currentReport.month,
			Card: '',
			ServicePerson: '',
			PrivateService: '',
			Code_Vill_T: '',
			NearbyHF: '',
			Code_OD_T: '',
			PatientName: '',
			Sex: '',
			Age: '',
			Pregnant: '',
			Symptom: '',
			OtherSymptom: '',
			ReferredHFType: '',
			ReferredHFName: '',
			ReferredDate: '',
			ReferredTime: '',
			SymptomDate: '',
			MedicineName: ''
		};
	}

	self.showNew = function () {
		self.showDetail(newModel());
	};

	self.showDetail = function (model) {
		model.cm = model.Rec_ID == 0 ? '' : place.vl.find(r => r.code == model.Code_Vill_T).cmcode;
		model.ds = model.Rec_ID == 0 ? '' : place.cm.find(r => r.code == model.cm).dscode;
		model.pv1 = model.Rec_ID == 0 ? '' : place.ds.find(r => r.code == model.ds).pvcode;
		model.pv2 = model.Rec_ID == 0 ? '' : place.od.find(r => r.code == model.Code_OD_T).pvcode;

		model = app.ko(model);

		model.pvList = place.pv;
		model.dsList = ko.pureComputed(() => place.ds.filter(r => r.pvcode == model.pv1()));
		model.cmList = ko.pureComputed(() => place.cm.filter(r => r.dscode == model.ds()));
		model.vlList = ko.pureComputed(() => place.vl.filter(r => r.cmcode == model.cm()));
		model.odList = ko.pureComputed(() => place.od.filter(r => r.pvcode == model.pv2()));

		model.Symptom(model.Symptom().split(',').filter(r => r != ''));

		self.editModel(model);
		self.view('detail');
	};

	self.save = function () {
		var model = self.editModel();
		var missing = false;

		if (model.Card.trim() == '') {
			app.showWarning(model.Card.element);
			missing = true;
		}
		if (model.ServicePerson.trim() == '') {
			app.showWarning(model.ServicePerson.element);
			missing = true;
		}
		if (model.PrivateService.trim() == '') {
			app.showWarning(model.PrivateService.element);
			missing = true;
		}
		if (model.pv1() == null) {
			app.showWarning(model.pv1.element);
			missing = true;
		}
		if (model.ds() == null) {
			app.showWarning(model.ds.element);
			missing = true;
		}
		if (model.cm() == null) {
			app.showWarning(model.cm.element);
			missing = true;
		}
		if (model.Code_Vill_T() == null) {
			app.showWarning(model.Code_Vill_T.element);
			missing = true;
		}
		if (model.NearbyHF.trim() == '') {
			app.showWarning(model.NearbyHF.element);
			missing = true;
		}
		if (model.pv2() == null) {
			app.showWarning(model.pv2.element);
			missing = true;
		}
		if (model.Code_OD_T() == null) {
			app.showWarning(model.Code_OD_T.element);
			missing = true;
		}
		if (model.PatientName.trim() == '') {
			app.showWarning(model.PatientName.element);
			missing = true;
		}
		if (model.Sex() == '') {
			app.showWarning(model.Sex.element);
			missing = true;
		}
		if (model.Age() == '') {
			app.showWarning(model.Age.element);
			missing = true;
		}
		if (model.Pregnant() == '') {
			app.showWarning(model.Pregnant.element);
			missing = true;
		}
		if (model.ReferredHFType() == '') {
			app.showWarning(model.ReferredHFType.element);
			missing = true;
		}
		if (model.ReferredHFName.trim() == '') {
			app.showWarning(model.ReferredHFName.element);
			missing = true;
		}
		if (model.ReferredDate() == '') {
			app.showWarning(model.ReferredDate.element);
			missing = true;
		}
		if (model.ReferredTime.trim() == '') {
			app.showWarning(model.ReferredTime.element);
			missing = true;
		}
		if (model.SymptomDate() == '') {
			app.showWarning(model.SymptomDate.element);
			missing = true;
		}
		if (model.MedicineName.trim() == '') {
			app.showWarning(model.MedicineName.element);
			missing = true;
		}
		if (missing) return;

		model = app.unko(model);
		model.Symptom = model.Symptom.join(',');

		var submit = {};
		Object.keys(newModel()).forEach(k => submit[k] = model[k]);

		app.ajax('/PPMReferralSlip/save', submit).done(function (id) {
			if (submit.Rec_ID == 0) {
				submit.Rec_ID = id;
				self.listModel.push(submit);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == id);
				self.listModel.replace(old, submit);
			}
			currentReport.has(true);

			self.back();
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblPPMReferralSlip',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
				currentReport.has(self.listModel().length > 0);
			});
		});
	};

	self.back = function () {
		self.view() == 'detail' ? self.view('list') : self.view('report');
	};

	self.visibleReport = function (model) {
		return model.has() || hfLog.some(r => r.Code_Facility_T == model.id && r.Month == model.month);
	};

	self.ifcan = function (permission) {
		return app.user.permiss['PPM Referral Slip'].contain(permission);
	};

	self.exportExcel = function () {
		app.downloadBlob('/PPMReferralSlip/exportExcel/').done(function (blob) {
			saveAs(blob, 'PPM Referral Slip.xlsx');
		});
	};
}