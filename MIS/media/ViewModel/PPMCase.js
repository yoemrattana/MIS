function viewModel() {
	var self = this;
	var today = moment();

	self.odList = ko.observableArray();
	self.reportList = ko.observableArray();
	self.master = ko.observable();
	self.detailList = ko.observableArray();

	self.year = ko.observable(today.year());
	self.od = ko.observable();
	self.isListView = ko.observable(true);

	var prov = sessionStorage.code_prov;
	var currentReport = null;
	var ready = false;
	var lastScrollTop = 0;
	var place = null;

	app.getPlace(['pv', 'od', 'ds', 'cm', 'vl'], function (p) {
		place = p;
		self.odList(place.od.filter(r => r.target == 1 && (r.pvcode == prov || r.code == app.user.od)));

		setTimeout(function () {
			ready = true;
			var url = getURL();
			if (url != null) {
				self.year(url.year);
				self.od(url.od);
			}
			if (self.odList().length == 1) self.getReport();
		});
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
		var url = getURL() || {};
		if (self.od() != null) {
			url.year = self.year();
			url.od = self.od();
		} else {
			url = null;
		}
		changeURL(url);

		if (self.od() == null) {
			self.reportList([]);
			return;
		}

		var submit = { year: self.year(), od: self.od() };
		app.ajax('ppmGetReport', submit).done(function (rs) {
			rs.ppms.forEach(ppm => {
				ppm.reports = [];
				for (var i = 1; i <= 12; i++) {
					var m = ('0' + i).substr(-2);
					var obj = {
						id: ppm.Code_Vill_T,
						en: ppm.Name_Outlet_E,
						month: m,
						has: ko.observable(rs.reports.some(r => r.Code_Vill_T == ppm.Code_Vill_T && r.Name_Outlet_E == ppm.Name_Outlet_E && r.Month == m))
					};
					ppm.reports.push(obj);
				}
			});
			self.reportList(rs.ppms);

			if (url.id != null) {
				var report = rs.ppms.find(r => r.Code_Vill_T == url.id && r.Name_Outlet_E == url.en);
				report = report.reports[parseInt(url.month) - 1];
				self.editReport(report);
			}
		});
	};

	self.editReport = function (model) {
		if (!model.has()) return;

		changeURL({ year: self.year(), od: self.od(), id: model.id, month: model.month, en: model.en });

		var submit = {
			od: self.od(),
			vl: model.id,
			name: model.en,
			year: self.year(),
			month: model.month
		};

		app.ajax('ppmGetCase', submit).done(function (rs) {
			// master
			var master = rs.master;
			master.DateAdded = moment(master.DateAdded).format('DD-MM-YYYY');
			master.od = self.odList().find(r => r.code == self.od()).name;
			master.en = model.en;
			master.month = model.month + '-' + self.year();
			master.has = model.has();

			// detail
			var details = [];
			rs.detail.forEach(r => details.push(convertObj(r)));

			self.master(master);
			self.detailList(details);

			currentReport = model;
			lastScrollTop = $(window).scrollTop();
			self.isListView(false);
			$(window).scrollTop(0);
		});
	};

	function convertObj(r) {
		r.DateCase = moment(r.DateCase).format('DD-MM-YYYY');
		r.ExtraCode = ko.observable(r.ExtraCode);
		bindPopAddress(r.ExtraCode);
		return r;
	}

	function bindPopAddress(column) {
		var po = column.popObject = {
			popVisible: ko.observable(false),
			villWarn: ko.observable(false),
			province: ko.observable(null),
			district: ko.observable(null),
			commune: ko.observable(null),
			village: ko.observable(null),
			provList: ko.observableArray(place.pv),
			distList: ko.observableArray(),
			commList: ko.observableArray(),
			villList: ko.observableArray(),
			base: column
		};

		po.province.subscribe(code => {
			po.distList(place.ds.filter(x => x.code.substr(0, 2) == code));

			if (code != null) column(code);
			else if (column() == null || column() == '999' || isNaN(column())) return;
			else if (column().length != 10 || place.vl.some(r => r.code == column())) column(null);
		});
		po.district.subscribe(code => {
			po.commList(place.cm.filter(x => x.code.substr(0, 4) == code));

			if (code != null) column(code);
			else if (po.province() != null) column(po.province());
		});
		po.commune.subscribe(code => {
			po.villList(place.vl.filter(x => x.cmcode == code));

			if (code != null) column(code);
			else if (po.district() != null) column(po.district());
		});
		po.village.subscribe(code => {
			if (po.commune() == null) return;

			if (code != null) column(code);
			else column(po.commune());
		});

		var code = column();
		if (code != null && code != '999') {
			var vcode, ccode, dcode, pcode;
			if (code.length == 10) {
				vcode = code;
				var found = place.vl.find(r => r.code == code);
				if (found != null) code = found.cmcode;
			}
			if (code.length == 6) { ccode = code; code = code.substr(0, 4); }
			if (code.length == 4) { dcode = code; code = code.substr(0, 2); }
			if (code.length == 2) pcode = code;

			if (pcode != null) po.province(pcode);
			if (dcode != null) po.district(dcode);
			if (ccode != null) po.commune(ccode);
			if (vcode != null) po.village(vcode);
		}

		po.villClick = function (model, event) {
			if (po.popVisible()) return;
			po.popVisible(true);

			var func = function () {
				if (model.skipFirst === true) {
					model.skipFirst = false;
					return;
				}
				var ele = $(event.currentTarget);
				if (!ele.next().is(':hover')) {
					$(document).off('click', null, func);
					po.popVisible(false);
				}
			};

			setTimeout(function () {
				$(document).on('click', func);
			});
		};

		po.unknownClick = function () {
			if (column() == '999') {
				column(null);
			} else {
				column('999');
				po.province(null);
			}
			return true;
		};
	}

	self.deleteReport = function () {
		app.showDelete(function () {
			var url = getURL();
			var submit = {
				where: {
					Code_OD_T: url.od,
					Code_Vill_T: url.id,
					Name_Outlet_E: url.en,
					Year: url.year,
					Month: url.month,
				}
			};

			app.ajax('ppmDeleteReport', submit).done(function () {
				currentReport.has(false);
				self.back(true);
			});
		});
	};

	self.back = function () {
		changeURL({ year: self.year(), od: self.od() });
		self.isListView(true);
		$(window).scrollTop(lastScrollTop);
	};

	self.getTop = function (ele) {
		return ($(ele).prev().position().top + 22) + 'px';
	};

	self.getLeft = function (ele) {
		return ($(ele).prev().position().left - 10) + 'px';
	};

	self.getVill = function (code) {
		if (code == null || code === '') return '';
		if (code == '999') return 'Unknown';
		var found = code.length == 10 ? place.vl.find(r => r.code == code)
			: code.length == 6 ? place.cm.find(r => r.code == code)
			: code.length == 4 ? place.ds.find(r => r.code == code)
			: code.length == 2 ? place.vl.find(r => r.code == code)
			: null;

		return found == null ? code : found.name;
	};

	self.visibleReport = function (model) {
		return model.has() || self.year() < today.year() || (self.year() == today.year() && parseInt(model.month) <= today.month() + 1);
	};

	function changeURL(obj) {
		var search = location.pathname.split('/').last() + (obj == null ? '' : '?s=' + JSON.stringify(obj));
		window.history.replaceState(null, null, search);
	}

	function getURL() {
		var para = location.search.substr(3);
		return para != '' ? JSON.parse(decodeURI(para)) : null;
	}

	self.isSingle = function (arr) {
		return arr.length == 1;
	};

	self.getDiagnosis = function (value) {
		return {
			'F': 'Pf',
			'V': 'Pv',
			'M': 'Mix',
		}[value];
	};

	self.getReason = function (num) {
		return {
			'': '',
			'1': 'Drug stock out',
			'2': 'Pregnancy',
			'3': 'Children under 5 years',
			'4': 'Suspected Treatment Failure'
		}[num];
	};
}