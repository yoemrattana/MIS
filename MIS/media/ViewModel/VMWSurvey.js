function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.view = ko.observable('list');

	self.yearList = Array.range(2023, moment().year());
	self.monthList = Array.range(0, 11).map(i => moment().month(i).format('MM'));
	self.year = ko.observable(moment().year());
	self.month = ko.observable();

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.vl = ko.observable();

	self.masterModel = ko.observable();
	self.detailModel = ko.observableArray();

	var place = null;

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
		place = p;
		place.pv = place.pv.filter(r => r.target == 1);
		place.od = place.od.filter(r => r.target == 1);

		if (app.user.prov != '') {
			place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
			place.od = place.od.filter(r => app.user.prov.contain(r.pvcode));
		}
		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

		self.pvList(place.pv);

		app.ajax('/VMWSurvey/getData').done(function (rs) {
			self.listModel(rs);
		});
	});

	self.getListModel = ko.pureComputed(function () {
		var list = self.listModel();

		if (self.vl() != null) list = list.filter(r => r.Code_Vill_T == self.vl());
		else if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
		else if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());

		if (self.year() != null) list = list.filter(r => r.AuditDate.substr(0, 4) == self.year());
		if (self.month() != null) list = list.filter(r => r.AuditDate.substr(5, 2) == self.month());

		return list;
	});

	self.showNew = function () {
		self.showDetail(newModel());
	};

	self.showDetail = function (model) {
		var master = app.ko(newModel().applyData(model)).extendIsEmpty(newModel());

		master.odList = ko.observableArray(place.od);
		master.hcList = ko.pureComputed(() => self.hcList(master.od()));
		master.vlList = ko.pureComputed(() => self.vlList(master.hc()));
		master.od = ko.observable(model.Code_OD_T);
		master.hc = ko.observable(model.Code_Facility_T);

		var details = Array.repeat(5).map(newRow);

		if (model.Rec_ID == 0) {
			goOn();
		} else {
			var submit = { id: model.Rec_ID };
			app.ajax('/VMWSurvey/getDetail', submit).done(function (rs) {
				model.details = details = rs;
				goOn();
			});
		}

		function goOn() {
			details = details.map(r => app.ko(newRow().applyData(r)).extendIsEmpty(newRow()));

			self.masterModel(master);
			self.detailModel(details);
			self.view('detail');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		}
	};

	self.save = function () {
		var master = self.masterModel();

		var missing = false;
		if (master.od() == null) {
			app.showWarning(master.od.element);
			missing = true;
		}
		if (master.hc() == null) {
			app.showWarning(master.hc.element);
			missing = true;
		}
		if (master.Code_Vill_T() == null) {
			app.showWarning(master.Code_Vill_T.element);
			missing = true;
		}
		if (master.AuditorName.trim() == '') {
			app.showWarning(master.AuditorName.element);
			missing = true;
		}
		if (master.AuditDate() == '') {
			app.showWarning(master.AuditDate.element);
			missing = true;
		}
		if (master.VMWName.trim() == '') {
			app.showWarning(master.VMWName.element);
			missing = true;
		}
		if (master.VMWDate() == '') {
			app.showWarning(master.VMWDate.element);
			missing = true;
		}
		if (missing) {
			app.showMsg('<kh>ទិន្នន័យមិនទាន់គ្រប់</kh>', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh>');
			return;
		}

		master = app.unko(master);
		master.InterpersonalMale = self.getInterpersonal();
		master.InterpersonalFemale = self.getInterpersonal();
		master.GroupMale = self.getTotal('EducatedMale') - self.getInterpersonal();
		master.GroupFemale = self.getTotal('EducatedMale') - self.getInterpersonal();

		var details = self.detailModel().filter(r => r.Name.trim() != '').map(app.unko);
		if (details.length == 0) return;

		var submit = {
			master: JSON.stringify(master),
			details: JSON.stringify(details)
		};
		app.ajax('/VMWSurvey/save', submit).done(function (rs) {
			if (master.Rec_ID == 0) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
				self.listModel.replace(old, rs);
			}

			self.back();
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblVMWSurvey',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.addRow = function () {
		self.detailModel.push(app.ko(newRow()));
	};

	self.removeRow = function (model) {
		self.detailModel.remove(model);
	};

	self.back = function () {
		self.view('list');
	};

	self.odList = function (pv) {
		pv = pv || self.pv();
		return pv == null ? [] : place.od.filter(r => r.pvcode == pv);
	};

	self.hcList = function (od) {
		od = od || self.od();
		return od == null ? [] : place.hc.filter(r => r.odcode == od);
	};

	self.vlList = function (hc) {
		hc = hc || self.hc();
		return hc == null ? [] : place.vl.filter(r => r.hccode == hc);
	};

	self.getTotal = function (name) {
		return self.detailModel().sum(r => r[name]().toFloat());
	};

	self.getInterpersonal = function () {
		return self.detailModel().filter(r => r.EducatedMale() == 1 && r.EducatedFemale() == 1).length;
	};

	self.ifcan = function (permission) {
		return app.user.permiss['VMW Survey'].contain(permission);
	};

	self.exportExcel = function () {
		app.downloadBlob('/VMWSurvey/exportExcel/').done(function (blob) {
			saveAs(blob, 'VMW Survey.xlsx');
		});
	};

	function newModel() {
		return {
			Rec_ID: 0,
			Code_Vill_T: null,
			InterpersonalMale: null,
			InterpersonalFemale: null,
			GroupMale: null,
			GroupFemale: null,
			AuditorName: '',
			AuditDate: '',
			VMWName: '',
			VMWDate: ''
		};
	}

	function newRow() {
		return {
			Name: '',
			Age: '',
			Sex: '',
			Permanence: '',
			Mobile: '',
			UsableLLIN: '',
			UsableLLIHN: '',
			NoBednet: '',
			LastNightBednet: '',
			EveryNightBednet: '',
			HangedBednet: '',
			UnusedBednet: '',
			BrokenBednet: '',
			MoreLLIN: '',
			MoreLLIHN: '',
			BednetUsage: '',
			EducatedMale: '',
			EducatedFemale: ''
		};
	}
}