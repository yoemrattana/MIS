function viewModel() {
	var self = this;
	var today = moment();

    self.odList = ko.observableArray();
    self.pvList = ko.observableArray();
	self.reportListOD = ko.observableArray();
	self.reportListHF = ko.observableArray();
	self.reportListVMW = ko.observableArray();
	self.master = ko.observable();
	self.detailList = ko.observableArray();

    self.year = ko.observable(today.year());
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.isListView = ko.observable(true);
	self.menu = ko.observable();
	self.reportLock = ko.observable(false);

	self.adjustmentPopup = ko.observable();
	self.expirePopup = ko.observable();
	self.allExpirationList = ko.observableArray();
	self.adjustmentOptions = ko.observableArray();
	self.notifyExpire = ko.observableArray();

	var prov = sessionStorage.code_prov;
	var currentReport = null;
	var ready = false;
	var place = null;
	var hfLog = [];
	var vmwLog = [];

	var IP2Items = ['Repellent', 'Forest pack', 'Mebendazole', 'Paracetamol'];
	var radicalCureItems = ['G6PD'];
	var RHPHNHItems = ['Quinine Dihydrochloride', 'Artesunate powder 60mg/ml/vial + solution sodium bicarbonate 5% ampoule/ml (IM+IV)'];
	var dataRadicalCure = [];
	var dataIP2 = [];
	var dataCase = [];

    app.getPlace(['pv', 'od', 'hc'], function (p) {
		place = p;

		place.od = place.od.filter(r => r.target != null);

		self.odList(app.user.od != '' ? place.od.filter(r => r.code == app.user.od) : place.od.filter(r => r.pvcode == prov));
        let provUser = app.user.username == 'Virrak' || app.user.prov == '' ? place.pv : place.pv.filter(r => app.user.prov.contain(r.code));
		self.pvList(provUser);

		var submit = { prov: prov };
		app.ajax('getPreData', submit).done(function (rs) {
			place.hc = place.hc.filter(r => rs.hcHasVMW.contain(r.code));

			dataRadicalCure = rs.radicalCure;
			dataIP2 = rs.IP2;

			getCaseData(function () {
				var url = getURL();
				if (url != null) {
					self.year(url.year);
					self.od(url.od);
					//self.hc(url.hc);
					self.menu(url.menu);
					ready = true;
				} else {
					ready = true;
					var founds = ['OD', 'HF', 'VMW'].filter(r => self.checkPermiss(r));
					if (founds.length == 1) self.menu(founds[0].toLowerCase());
				}
			});
		});
	});

	function getCaseData(callback) {
		var submit = { prov: self.pv(), year: self.year() };
		app.ajax('getCaseData', submit).done(function (rs) {
			dataCase = rs;

			callback();
		});
	}

	self.menu.subscribe(function () {
		if (ready) {
			changeURL({ menu: self.menu(), year: self.year(), od: self.od() });
		}

		if (self.menu() == 'od' && self.reportListOD().length == 0) self.getReportOD();
		if (self.menu() == 'hf' && self.od() != null && self.reportListHF().length == 0) self.getReportHF();
		if (self.menu() == 'vmw' && self.hc() != null && self.reportListVMW().length == 0) self.getReportVMW();
	});

	self.previousYear = function () {
		self.year(self.year() - 1);

		getCaseData(function () {
			self.menu() == 'od' ? self.getReportOD()
			: self.menu() == 'hf' ? self.getReportHF()
			: self.getReportVMW();
		});
	};

	self.nextYear = function () {
		self.year(self.year() + 1);

		getCaseData(function () {
			self.menu() == 'od' ? self.getReportOD()
			: self.menu() == 'hf' ? self.getReportHF()
			: self.getReportVMW();
		});
    };

	self.pv.subscribe(function (code) {
		sessionStorage.code_prov = code;
		getCaseData(function () {
			if (self.menu() == 'od') self.getReportOD();
			self.odList(code == null ? [] : app.user.od != '' ? place.od.filter(r => r.code == app.user.od) : place.od.filter(r => r.pvcode == code));
		});
    });
               
    self.od.subscribe(function (code) {
        if (ready && self.menu() == 'hf') self.getReportHF();
        self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
    });

    self.hc.subscribe(function () {
        if (ready) self.getReportVMW();
    });

    /*
	self.od.subscribe(function () {
		if (ready && self.menu() == 'hf') self.getReportHF();
	});

	self.hc.subscribe(function () {
		if (ready) self.getReportVMW();
	});
    */

    self.hcList = function () {
        return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
    };

	self.getReportOD = function () {
		var url = getURL() || {};
		url.menu = self.menu();
		url.year = self.year();
		changeURL(url);

		var submit = { prov: self.pv, year: self.year() };
		app.ajax('getReportOD', submit).done(function (rs) {
			rs.ods.forEach(od => {
				od.reports = [];
				for (var i = 1; i <= 12; i++) {
					var m = ('0' + i).substr(-2);
					var c = dataCase.filter(r => r.Code_OD_T == od.Code_OD_T && r.Month == m);
					var obj = {
						id: od.Code_OD_T,
						month: m,
						has: ko.observable(rs.reportODs.some(r => r.Code_OD_T == od.Code_OD_T && r.Month == m)),
						positive: c.sum(r => r.Positive),
						positiveHF: c.sum(r => r.PositiveHF),
						positiveVMW: c.sum(r => r.PositiveVMW),
						test: c.sum(r => r.Test),
						testHF: c.sum(r => r.TestHF),
						testVMW: c.sum(r => r.TestVMW),
						rdt: c.sum(r => r.RDT),
						microscopy: c.sum(r => r.Microscopy),
						radicalCure: dataRadicalCure.contain(od.Code_OD_T),
						isIP2: dataIP2.some(r => r.Code_OD_T == od.Code_OD_T)
					};
					od.reports.push(obj);
				}
            });
            if (app.user.od == '') self.reportListOD(rs.ods);
            else self.reportListOD(rs.ods.find(r => r.Code_OD_T == app.user.od));

			if (url.menu == 'od') {
				if (url.month != null) {
                    var report = rs.ods.find(r => r.Code_OD_T == url.id);
					report = report?.reports[parseInt(url.month) - 1];
                    self.editReportOD(report);
				}
			} else if (url.menu == 'hf') {
				self.getReportHF();
			} else {
				self.getReportVMW();
			}
		});
	};

	self.getReportHF = function () {
		var url = getURL() || {};
		url.menu = self.menu();
		url.year = self.year();
		url.od = self.od();
		changeURL(url);

		if (self.od() == null) {
			self.reportListHF([]);
			return;
		}

		var submit = { year: self.year(), od: self.od() };
		app.ajax('getReportHF', submit).done(function (rs) {
			hfLog = rs.hfs;
			var hfs = hfLog.distinct(r => r.Code_Facility_T);
			hfs.forEach(hf => {
				hf.reports = [];
				for (var i = 1; i <= 12; i++) {
					var m = ('0' + i).substr(-2);
					var c = dataCase.find(r => r.Code_Facility_T == hf.Code_Facility_T && r.Month == m);
					var obj = {
						id: hf.Code_Facility_T,
						en: hf.Name_Facility_E,
						kh: hf.Name_Facility_K,
						month: m,
						has: ko.observable(rs.reportHFs.some(r => r.Code_Facility_T == hf.Code_Facility_T && r.Month == m)),
						positive: c == null ? 0 : c.Positive,
						positiveHF: c == null ? 0 : c.PositiveHF,
						positiveVMW: c == null ? 0 : c.PositiveVMW,
						test: c == null ? 0 : c.Test,
						testHF: c == null ? 0 : c.TestHF,
						testVMW: c == null ? 0 : c.TestVMW,
						rdt: c == null ? 0 : c.RDT,
						microscopy: c == null ? 0 : c.Microscopy,
						radicalCure: dataRadicalCure.contain(self.od()),
						isIP2: dataIP2.some(r => r.Code_Facility_T == hf.Code_Facility_T),
						typeHF: hf.Type_Facility
					};
					hf.reports.push(obj);
				}
			});
			self.reportListHF(hfs);

			if (url.month != null) {
				var report = hfs.find(r => r.Code_Facility_T == url.id);
				report = report.reports[parseInt(url.month) - 1];
				self.editReportHF(report);
			}
		});
	};

	self.getReportVMW = function () {
		var url = getURL() || {};
		url.menu = self.menu();
		url.year = self.year();
		url.od = self.od();
		url.hc = self.hc();
		changeURL(url);

		if (self.hc() == null) {
			self.reportListVMW([]);
			return;
		}

		var submit = { year: self.year(), hc: self.hc() };
		app.ajax('getReportVMW', submit).done(function (rs) {
			vmwLog = rs.vmws;
			var vmws = vmwLog.distinct(r => r.Code_Vill_T);
			vmws.forEach(vmw => {
				vmw.reports = [];
				for (var i = 1; i <= 12; i++) {
					var m = ('0' + i).substr(-2);
					var obj = {
						id: vmw.Code_Vill_T,
						en: vmw.Name_Vill_E,
						kh: vmw.Name_Vill_K,
						month: m,
						has: ko.observable(rs.reportVMWs.some(r => r.Code_Vill_T == vmw.Code_Vill_T && r.Month == m))
					};
					vmw.reports.push(obj);
				}
			});
			self.reportListVMW(vmws);

			if (url.month != null) {
				var report = vmws.find(r => r.Code_Vill_T == url.id);
				report = report.reports[parseInt(url.month) - 1];
				self.editReportVMW(report);
			}
		});
	};

	self.editReportOD = function (model) {
		changeURL({ menu: self.menu(), year: self.year(), od: self.od(), id: model.id, month: model.month });
		var submit = {
			code: model.id,
			year: self.year(),
			month: model.month
		};

		app.ajax('getReportDetailOD', submit).done(function (rs) {
            var master = {};
            var od = self.odList().length ? self.odList().find(r => r.code == model.id) : self.odList();
			master.odkh = od.nameK;
			master.month = ko.observable(moment(model.month + '-' + self.year(), 'MM-YYYY'));
			master.has = model.has();
			master.type = 'od';
			master.positive = model.positive;
			master.positiveHF = model.positiveHF;
			master.positiveVMW = model.positiveVMW;
			master.test = model.test;
			master.testHF = model.testHF;
			master.testVMW = model.testVMW;
			master.rdt = model.rdt;
			master.microscopy = model.microscopy;

			if (!model.radicalCure) {
				rs = _.filter(rs, (v) => !_.includes(radicalCureItems, v.Description));
			}

			if (!model.isIP2) {
				rs = _.filter(rs, (v) => !_.includes(IP2Items, v.Description));
			}

			rs.filter(r => r.ItemId > 0).forEach(r => {
				r.StockStart = ko.observable(r.StockStart);
				r.StockIn = ko.observable(r.StockIn);
				r.Total = ko.computed(() => toFloat(r.StockStart()) + toFloat(r.StockIn()));
				r.StockOut = ko.observable(r.StockOut);
				r.Adjustment = ko.observable(r.Adjustment);
				r.AdjustmentDetail = r.AdjustmentDetail == null ? [] : JSON.parse(r.AdjustmentDetail);
				r.Balance = ko.computed(() => toFloat(r.Total()) - toFloat(r.StockOut()) + toFloat(r.Adjustment()));
				r.Request = ko.observable(r.Request);
				r.ExpireDetail = r.ExpireDetail == null ? [] : JSON.parse(r.ExpireDetail);
				r.Expire = ko.observable(r.Expire == null ? null : moment(r.Expire));
				r.Note = ko.observable(r.Note);
				r.AMC = toFloat1d(r.AMC);
				r.Estimate = ko.computed(() => {
					var v = Math.ceil((r.AMC * 6) - r.Balance());
					return v < 0 ? 0 : v;
				});

				var preBalance = r.Balance();
				r.MOS = ko.computed(() => r.AMC == 0 ? 'NA' : toFloat1d(preBalance / r.AMC));
			});

			var arrAct = rs.filter(r => r.Category == 'ACT');
			var act = rs.find(r => r.ItemId == 0);
			act.StockStart = sumACT('StockStart', arrAct);
			act.StockIn = sumACT('StockIn', arrAct);
			act.Total = sumACT('Total', arrAct);
			act.StockOut = sumACT('StockOut', arrAct);
			act.Adjustment = sumACT('Adjustment', arrAct);
			act.Balance = sumACT('Balance', arrAct);
			act.Request = sumACT('Request', arrAct);
			act.AMC = toFloat1d(act.AMC);
			act.Estimate = sumACT('Estimate', arrAct);

			var preBalance = act.Balance();
			act.MOS = ko.computed(() => act.AMC == 0 ? 'NA' : toFloat1d(preBalance / act.AMC));

			self.isListView(false);
			self.master(master);
			self.detailList(rs);
			currentReport = model;

			rs.filter(r => r.ItemId > 0).forEach(r => {
				app.setNumberOnly(r.StockStart.element, 'int');
				app.setNumberOnly(r.StockIn.element, 'int');
				app.setNumberOnly(r.StockOut.element, 'int');
				app.setNumberOnly(r.Adjustment.element, 'int', true);
				app.setNumberOnly(r.Request.element, 'int');
			});

			var reportMonth = master.month().clone().add(1, 'months');
			var thisMonth = moment(moment().format('MM-YYYY'), 'MM-YYYY');
			if (!app.user.permiss['Stock Data'].contain('Edit Locked Report') && reportMonth < thisMonth) {
				$('.tbldetail input').prop('disabled', true);
				self.reportLock(true);
			} else {
				self.reportLock(false);
			}

			master.month.subscribe(function (value) {
				if (value.year() == self.year()) {
					var found = self.reportListOD().find(r => r.Code_OD_T == currentReport.id);
					self.editReportOD(found.reports[value.month()]);
				} else {
					var url = getURL();
					url.month = value.format('MM');
					changeURL(url);

					self.year(value.year());
					self.getReportOD();
				}
			});

			var arr = [];
			rs.forEach(r => {
				if (r.ExpireDetail == null) return;
				r.ExpireDetail.forEach(e => {
					if (e.Date.substr(0, 7) <= moment().add(1, 'month').format('YYYY-MM')) {
						arr.push({
							Code: r.Code,
							Description: r.Description,
							Date: moment(e.Date).displayformat()
						});
					}
				});
			});
			if (arr.length > 0) {
				self.notifyExpire(arr);
				$('#modalNotifyExpire').modal('show');
			}
		});
	};

	self.editReportHF = function (model) {
		changeURL({ menu: self.menu(), year: self.year(), od: self.od(), id: model.id, month: model.month });

		var submit = {
			code: model.id,
			year: self.year(),
			month: model.month
		};

		app.ajax('getReportDetailHF', submit).done(function (rs) {
            var master = {};
            var od = self.odList().length ? self.odList().find(r => r.code == self.od()) : self.odList();
			master.od = od.name;
			master.odkh = od.nameK;
			master.en = model.en;
			master.kh = model.kh;
			master.month = ko.observable(moment(model.month + '-' + self.year(), 'MM-YYYY'));
			master.has = model.has();
			master.type = 'hf';
			master.positive = model.positive;
			master.positiveHF = model.positiveHF;
			master.positiveVMW = model.positiveVMW;
			master.test = model.test;
			master.testHF = model.testHF;
			master.testVMW = model.testVMW;
			master.rdt = model.rdt;
			master.microscopy = model.microscopy;

			if (!model.isIP2) {
				rs = _.filter(rs, (v) => !_.includes(IP2Items, v.Description));
			}

			if (!model.radicalCure) {
				rs = _.filter(rs, (v) => !_.includes(radicalCureItems, v.Description));
			}

			if (model.typeHF == 'HC') {
				rs = _.filter(rs, (v) => !_.includes(RHPHNHItems, v.Description));
			}

			rs.filter(r => r.ItemId > 0).forEach(r => {
				r.StockStart = ko.observable(r.StockStart);
				r.StockIn = ko.observable(r.StockIn);
				r.Total = ko.computed(() => toFloat(r.StockStart()) + toFloat(r.StockIn()));
				r.StockOut = ko.observable(r.StockOut);
				r.Adjustment = ko.observable(r.Adjustment);
				r.AdjustmentDetail = r.AdjustmentDetail == null ? [] : JSON.parse(r.AdjustmentDetail);
				r.Balance = ko.computed(() => toFloat(r.Total()) - toFloat(r.StockOut()) + toFloat(r.Adjustment()));
				r.ExpireDetail = r.ExpireDetail == null ? [] : JSON.parse(r.ExpireDetail);
				r.Expire = ko.observable(r.ExpireDetail[0] == null ? null : moment(r.ExpireDetail[0].Date));
				r.Note = ko.observable(r.Note);
				r.AMC = toFloat1d(r.AMC);
				r.Estimate = ko.computed(() => {
					var v = Math.ceil((r.AMC * 2) - r.Balance());
					return v < 0 ? 0 : v;
				});

				var preBalance = r.Balance();
				r.MOS = ko.computed(() => r.AMC == 0 ? 'NA' : toFloat1d(preBalance / r.AMC));
			});

			var arrAct = rs.filter(r => r.Category == 'ACT');
			var act = rs.find(r => r.ItemId == 0);
			act.StockStart = sumACT('StockStart', arrAct);
			act.StockIn = sumACT('StockIn', arrAct);
			act.Total = sumACT('Total', arrAct);
			act.StockOut = sumACT('StockOut', arrAct);
			act.Adjustment = sumACT('Adjustment', arrAct);
			act.Balance = sumACT('Balance', arrAct);
			act.AMC = toFloat1d(act.AMC);
			act.Estimate = sumACT('Estimate', arrAct);

			var preBalance = act.Balance();
			act.MOS = ko.computed(() => act.AMC == 0 ? 'NA' : toFloat1d(preBalance / act.AMC));

			self.isListView(false);
			self.master(master);
			self.detailList(rs);
			currentReport = model;

			rs.filter(r => r.ItemId > 0).forEach(r => {
				app.setNumberOnly(r.StockStart.element, 'int');
				app.setNumberOnly(r.StockIn.element, 'int');
				app.setNumberOnly(r.StockOut.element, 'int');
				app.setNumberOnly(r.Adjustment.element, 'int', true);
			});

			var reportMonth = master.month().clone().add(1, 'months');
			var thisMonth = moment(moment().format('MM-YYYY'), 'MM-YYYY');
			if (!app.user.permiss['Stock Data'].contain('Edit Locked Report') && reportMonth < thisMonth) {
				$('.tbldetail input').prop('disabled', true);
				self.reportLock(true);
			} else {
				self.reportLock(false);
			}

			master.month.subscribe(function (value) {
				if (value.year() == self.year()) {
					var found = self.reportListHF().find(r => r.Code_Facility_T == currentReport.id);
					self.editReportHF(found.reports[value.month()]);
				} else {
					var url = getURL();
					url.month = value.format('MM');
					changeURL(url);

					self.year(value.year());
					self.getReportHF();
				}
			});

			var arr = [];
			rs.forEach(r => {
				if (r.ExpireDetail == null) return;
				r.ExpireDetail.forEach(e => {
					if (e.Date.substr(0, 7) <= moment().add(1, 'month').format('YYYY-MM')) {
						arr.push({
							Code: r.Code,
							Description: r.Description,
							Date: moment(e.Date).displayformat()
						});
					}
				});
			});
			if (arr.length > 0) {
				self.notifyExpire(arr);
				$('#modalNotifyExpire').modal('show');
			}
		});
	};

	self.editReportVMW = function (model) {
		changeURL({ menu: self.menu(), year: self.year(), od: self.od(), hc: self.hc(), id: model.id, month: model.month });

		var submit = {
			code: model.id,
			year: self.year(),
			month: model.month
		};

		app.ajax('getReportDetailVMW', submit).done(function (rs) {
			var master = {};
			var od = self.odList().find(r => r.code == self.od());
			var hc = self.hcList().find(r => r.code == self.hc());
			master.od = od.name;
			master.odkh = od.nameK;
			master.hc = hc.name;
			master.hckh = hc.nameK;
			master.en = model.en;
			master.kh = model.kh;
			master.month = ko.observable(moment(model.month + '-' + self.year(), 'MM-YYYY'));
			master.has = model.has();
			master.type = 'vmw';

			rs.filter(r => r.ItemId > 0).forEach(r => {
				r.StockStart = ko.observable(r.StockStart);
				r.StockIn = ko.observable(r.StockIn);
				r.Total = ko.computed(() => toFloat(r.StockStart()) + toFloat(r.StockIn()));
				r.StockOut = ko.observable(r.StockOut);
				r.Adjustment = ko.observable(r.Adjustment);
				r.Balance = ko.computed(() => toFloat(r.Total()) - toFloat(r.StockOut()) + toFloat(r.Adjustment()));
				r.Expire = ko.observable(r.Expire);
				r.AMC = toFloat1d(r.AMC);
				r.Estimate = ko.computed(() => {
					var v = Math.ceil((r.AMC * 2) - r.Balance());
					return v < 0 ? 0 : v;
				});

				var preBalance = r.Balance();
				r.MOS = ko.computed(() => r.AMC == 0 ? 'NA' : toFloat1d(preBalance / r.AMC));
			});

			var arrAct = rs.filter(r => r.Category == 'ACT');
			var act = rs.find(r => r.ItemId == 0);
			act.StockStart = sumACT('StockStart', arrAct);
			act.StockIn = sumACT('StockIn', arrAct);
			act.Total = sumACT('Total', arrAct);
			act.StockOut = sumACT('StockOut', arrAct);
			act.Adjustment = sumACT('Adjustment', arrAct);
			act.Balance = sumACT('Balance', arrAct);
			act.AMC = toFloat1d(act.AMC);
			act.Estimate = sumACT('Estimate', arrAct);

			var preBalance = act.Balance();
			act.MOS = ko.computed(() => act.AMC == 0 ? 'NA' : toFloat1d(preBalance / act.AMC));

			self.isListView(false);
			self.master(master);
			self.detailList(rs);
			currentReport = model;

			rs.filter(r => r.ItemId > 0).forEach(r => {
				app.setNumberOnly(r.StockStart.element, 'int');
				app.setNumberOnly(r.StockIn.element, 'int');
				app.setNumberOnly(r.StockOut.element, 'int');
				app.setNumberOnly(r.Adjustment.element, 'int', true);
			});

			var reportMonth = master.month().clone().add(1, 'months');
			var thisMonth = moment(moment().format('MM-YYYY'), 'MM-YYYY');
			if (!app.user.permiss['Stock Data'].contain('Edit Locked Report') && reportMonth < thisMonth) {
				$('.tbldetail input').prop('disabled', true);
				self.reportLock(true);
			} else {
				self.reportLock(false);
			}

			master.month.subscribe(function (value) {
				if (value.year() == self.year()) {
					var found = self.reportListVMW().find(r => r.Code_Vill_T == currentReport.id);
					self.editReportVMW(found.reports[value.month()]);
				} else {
					var url = getURL();
					url.month = value.format('MM');
					changeURL(url);

					self.year(value.year());
					self.getReportVMW();
				}
			});
		});
	};

	function toFloat1d(value) {
		return parseFloat(parseFloat(value).toFixed(1));
	}

	function sumACT(name, arrAct) {
		return ko.computed(() =>
			arrAct.sum(r => {
				var value = parseFloat(ko.unwrap(r[name]));
				value = isNaN(value) ? 0 : value;
				return value < 0 ? 0 : value;
			})
		);
	}

	self.export = function () {
		var dList = [];
		self.detailList().forEach(r => {
			var obj = {
				Code: r.Code,
				Description: r.Description,
				Strength: r.Strength,
				Unit: r.Unit,
				StockStart: r.StockStart(),
				StockIn: r.StockIn(),
				Total: r.Total(),
				StockOut: r.StockOut(),
				Adjustment: r.Adjustment(),
				Balance: r.Balance(),
				Estimate: r.Estimate(),
				Expire: r.ExpireDetail == null ? '' : self.mergeExpire(r.ExpireDetail).replace(') (', ")\n("),
				AMC: r.AMC,
				MOS: r.MOS(),
				Note: r.Note == null ? '' : r.Note()
			};
			dList.push(obj);
		})

		var m = Object.entries(self.master())
		var txt = '{';
		m.forEach(function (v, k) {
			if (v[0] == 'month') {
				txt += '"' + v[0] + '" : "' + moment(v[1]()).format("MM-YYYY") + '",';
			} else {
				txt += '"' + v[0] + '" : "' + v[1] + '",';
			}
		})
		txt += '"None" : "None"';
		txt += '}';

		var mst = JSON.parse(txt);

		var submit = {
			report: self.menu(),
			details: JSON.stringify(dList),
			master: JSON.stringify(mst)
		}

		app.downloadBlob('exportExcel', submit).done(function (blob) {
			saveAs(blob, self.menu().trim() + '.xlsx'); //from FileSaver.js
		});
	}

	self.saveReport = function () {
		var type = self.master().type;
		var details = self.detailList().filter(r => r.ItemId > 0);

		if (details.some(r => r.Balance() < 0)) {
			app.showMsg('<kh>តុល្យាការមិនអាចតូចជាងសូន្យ</kh>', '<kh>សូមបញ្ចូលទិន្ន័យអោយបានត្រឹមត្រូវ</kh>');
			return;
		}

		removeAllWarning();

		if (type.in('od', 'hf')) {
			var missing = false;
			details.forEach(r => {
				if (r.Balance() != r.ExpireDetail.sum('Qty')) {
					showWarning(r.Expire);
					missing = true;
				}
			});
			if (missing) {
				app.showMsg('Expiration', '<kh>សូមបញ្ចូលឬកែទិន្ន័យ</kh> Expiration');
				return;
			}
		}

		var submit = [];
		details.forEach(r => {
			var obj = {
				Year: self.year(),
				Month: currentReport.month,
				ItemId: r.ItemId,
				StockStart: toFloat(r.StockStart()),
				StockIn: toFloat(r.StockIn()),
				StockOut: toFloat(r.StockOut()),
				Adjustment: toFloat(r.Adjustment()),
				Balance: r.Balance(),
				Expire: r.Expire() instanceof moment ? r.Expire().sqlformat() : r.Expire.trim(),
				Rec_ID: r.Rec_ID
			};

			if (type.in('od', 'hf')) {
				obj.AdjustmentDetail = JSON.stringify(r.AdjustmentDetail);
				obj.ExpireDetail = JSON.stringify(r.ExpireDetail);
				obj.Estimate = r.Estimate();
				obj.Note = isnull(r.Note()), '';
			}

			if (type == 'od') {
				obj.Code_OD_T = currentReport.id;
				obj.Request = toFloat(r.Request());
			}
			else if (type == 'hf') {
				obj.Code_Facility_T = currentReport.id;
				obj.VMWQty = r.AdjustmentDetail.filter(r => r.Name.toUpperCase() == 'VMW' && r.Qty < 0).sum('Qty') * -1;
			}
			else obj.Code_Vill_T = currentReport.id;

			submit.push(obj);
		});

		var submit = { submit: JSON.stringify(submit) };

		var url = type == 'od' ? '/Stock/saveStockOD' : type == 'hf' ? '/Stock/saveStockHF' : '/Stock/saveStockVMW';
		app.ajax(url, submit).done(function () {
			if (!currentReport.has()) self.back();
			currentReport.has(true);
		});
	};

	self.deleteReport = function () {
		app.showDelete(function () {
			var type = self.master().type;
			var submit = {
				table: type == 'od' ? 'tblStockOD' : type == 'hf' ? 'tblStockV2' : 'tblStockVMW',
				where: {
					Year: self.year(),
					Month: currentReport.month
				}
			};
			submit.where[type == 'od' ? 'Code_OD_T' : type == 'hf' ? 'Code_Facility_T' : 'Code_Vill_T'] = currentReport.id;
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Stock/deleteStock', submit).done(function () {
				currentReport.has(false);
				self.back();
			});
		});
	};

	self.back = function () {
		if (window.opener == null) {
			changeURL({ menu: self.menu(), year: self.year(), od: self.od(), hc: self.hc() });
			self.isListView(true);
			self.detailList([]);
			self.master(null);
		} else {
			window.close();
		}
	};

	self.visibleReport = function (model) {
		return self.menu() == 'od' ? model.has() || self.year() < today.year() || (self.year() == today.year() && parseInt(model.month) <= today.month() + 1)
			: self.menu() == 'hf' ? model.has() || hfLog.some(r => r.Code_Facility_T == model.id && r.Month == model.month)
			: model.has() || vmwLog.some(r => r.Code_Vill_T == model.id && r.Month == model.month);
	};

	self.getColor = function (mos) {
		if (mos == 0) return 'red';

		if (self.master().type == 'od') {
			return mos == 'NA' ? '' : mos > 0 && mos <= 3 ? 'orange' : mos <= 6 ? 'green' : 'yellow';
		} else {
			return mos == 'NA' ? '' : mos > 0 && mos <= 0.5 ? 'orange' : mos <= 3 ? 'green' : 'yellow';
		}
	};

	self.getHighlight = function (code) {
		return ['ND0067', 'ND0075', 'ND0082', 'ND0132'].contain(code) ? 'yellow' : '';
	};

	self.showAdjustment = function (detail) {
		$('#modalAdjustment').modal('show');
		self.adjustmentOptions(['VMW', 'Expired', 'Other']);

		detail.AdjustmentDetail.forEach(r => {
			if (!self.adjustmentOptions().contain(r.Name)) self.adjustmentOptions.push(r.Name);
		});

		var model = {};
		model.list = ko.observableArray();

		detail.AdjustmentDetail.forEach(obj => {
			model.list.push({
				Name: ko.observable(obj.Name),
				Qty: ko.observable(obj.Qty)
			});
		});

		model.remove = function (obj) {
			obj.Name('');
			obj.Qty('');
		};

		model.ok = function () {
			var missing = false;
			model.list().forEach(obj => {
				obj.Name(trim(obj.Name()));
				if ((obj.Name() || '') == '' && obj.Qty() == '') return;
				if ((obj.Name() || '') == '') { showWarning(obj.Name); missing = true }
				if (obj.Qty() == '') { showWarning(obj.Qty); missing = true; }
			});
			if (missing) return;

			detail.AdjustmentDetail = model.list().filter(r => (r.Name() || '') != '' && r.Qty() != '').map(obj => {
				return {
					Name: obj.Name(),
					Qty: parseInt(obj.Qty())
				};
			});
			detail.Adjustment(detail.AdjustmentDetail.sum(r => r.Qty));

			$('#modalAdjustment').modal('hide');
		};

		self.adjustmentPopup(model);
		model.list().forEach(applyEvent);
		check();

		function applyEvent(obj) {
			obj.Name.subscribe(check);
			obj.Qty.subscribe(check);
			app.setNumberOnly(obj.Qty.element, 'int', true);
		}

		function check() {
			var len = model.list().filter(r => trim(r.Name() || '') == '' && r.Qty() == '').length;
			for (var i = len; i < 2; i++) {
				var obj = {
					Name: ko.observable(''),
					Qty: ko.observable('')
				};
				model.list.push(obj);
				applyEvent(obj);
			}
		}
	};

	self.showExpire = function (detail) {
		$('#modalExpire').modal('show');
		var model = {};
		model.list = ko.observableArray();

		detail.ExpireDetail.forEach(obj => {
			model.list.push({
				Date: ko.observable(moment(obj.Date)),
				Qty: ko.observable(obj.Qty)
			});
		});

		model.remove = function (obj) {
			obj.Date(null);
			obj.Qty('');
		};

		model.ok = function () {
			var missing = false;
			model.list().forEach(obj => {
				if (obj.Date() == null && obj.Qty() === '') return;
				if (obj.Date() == null) { showWarning(obj.Date); missing = true }
				if (obj.Qty() === '') { showWarning(obj.Qty); missing = true; }
			});
			if (missing) return;

			detail.ExpireDetail = model.list().filter(r => r.Date() != null && r.Qty() !== '').map(obj => {
				return {
					Date: obj.Date().format('YYYY-MM-DD'),
					Qty: parseInt(obj.Qty())
				};
			});

			var ex = detail.ExpireDetail[0];
			detail.Expire(ex == null ? null : moment(ex.Date));

			$('#modalExpire').modal('hide');
		};

		self.expirePopup(model);
		model.list().forEach(applyEvent);
		check();

		function applyEvent(obj) {
			obj.Date.subscribe(check);
			obj.Qty.subscribe(check);
			app.setNumberOnly(obj.Qty.element, 'int');
		}

		function check() {
			var len = model.list().filter(r => r.Date() == null && r.Qty() == '').length;
			for (var i = len; i < 2; i++) {
				var obj = {
					Date: ko.observable(null),
					Qty: ko.observable('')
				};
				model.list.push(obj);
				applyEvent(obj);
			}
		}
	};

	self.showAllExpiration = function () {
		self.allExpirationList([]);
		self.allExpirationList(self.detailList().filter(r => r.ItemId != 0));
		$('#modalAllExpiration').modal('show');
	};

	self.mergeExpire = function (arr) {
		if (arr.length == 0) return '';
		var temp = arr.map(r => moment(r.Date).format('DD-MM-YYYY') + ': ' + r.Qty);
		return '(' + temp.join(') (') + ')';
	};

	self.checkPermiss = function (type) {
		return app.user.permiss['Stock Data'].contain('Stock ' + type);
	};

	function changeURL(obj) {
		var search = location.pathname.split('/').last() + (obj == null ? '' : '?s=' + JSON.stringify(obj));
		window.history.replaceState(null, null, search);
	}

	function getURL() {
		var para = location.search.substr(3);
		return para != '' ? JSON.parse(decodeURI(para)) : null;
	}

	var lstWarning = [];
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

		addError();

		if (el.data('warnEvent') != null) return;
		el.data('warnEvent', bindingValue.subscribe(checkValue));
		lstWarning.push(removeError);
	}

	function removeAllWarning() {
		lstWarning.forEach(f => f());
	}

	self.isSingle = function (arr) {
		return arr.length == 1;
	};
}