function viewModel() {
	var self = this;
	var today = moment();

	self.reportList = ko.observableArray();
	self.master = ko.observable();
	self.detailList = ko.observableArray();

	self.year = ko.observable(today.year());
	self.isListView = ko.observable(true);
	self.expirePopup = ko.observable();

	var currentReport = null;

	setTimeout(function () {
		var url = getURL();
		if (url != null) self.year(url.year);
		self.getReport();
	});

	self.previousYear = function () {
		self.year(self.year() - 1);
		self.getReport();
	};

	self.nextYear = function () {
		self.year(self.year() + 1);
		self.getReport();
	};

	self.getReport = function () {
		var url = getURL() || {};
		url.year = self.year();
		changeURL(url);

		var submit = { year: self.year() };
		app.ajax('getReportCNM', submit).done(function (rs) {
			var reports = [];
			for (var i = 1; i <= 12; i++) {
				var m = ('0' + i).substr(-2);
				var c = rs.cases.filter(r => r.Month == m);
				reports.push({
					month: m,
					has: ko.observable(rs.reports.some(r => r.Month == m)),
					positive: c.sum(r => r.Positive),
					test: c.sum(r => r.Test)
				});
			}
			self.reportList(reports);

			if (url.month != null) {
				var report = reports[parseInt(url.month) - 1];
				self.editReport(report);
			}
		});
	};

	self.editReport = function (model) {
		changeURL({ year: self.year(), month: model.month });

		var submit = {
			year: self.year(),
			month: model.month
		};

		app.ajax('getReportDetailCNM', submit).done(function (rs) {
			var master = {};
			master.month = ko.observable(moment(model.month + '-' + self.year(), 'MM-YYYY'));
			master.has = model.has();
			master.positive = model.positive;
			master.test = model.test;

			rs.filter(r => r.ItemId > 0).forEach(r => {
				r.StockStart = ko.observable(r.StockStart);
				r.StockIn = ko.observable(r.StockIn);
				r.Total = ko.computed(() => toFloat(r.StockStart()) + toFloat(r.StockIn()));
				r.StockOut = ko.observable(r.StockOut);
				r.Adjustment = ko.observable(r.Adjustment);
				r.Balance = ko.computed(() => toFloat(r.Total()) - toFloat(r.StockOut()) + toFloat(r.Adjustment()));
				r.Expire = ko.observable(isnot(r.Expire, null, x => moment(x)));
				r.ExpireDetail = r.ExpireDetail == null ? [] : JSON.parse(r.ExpireDetail);
				r.Note = ko.observable(r.Note);
				r.AMC = r.AMC == null ? 'NA' : toFloat1d(r.AMC);

				var preBalance = r.Balance();
				r.MOS = ko.computed(() => r.AMC.in('NA', 0) ? 'NA' : toFloat1d(preBalance / r.AMC));
			});

			var arrAct = rs.filter(r => r.Category == 'ACT');
			var act = rs.find(r => r.ItemId == 0);
			act.StockStart = sumACT('StockStart', arrAct);
			act.StockIn = sumACT('StockIn', arrAct);
			act.Total = sumACT('Total', arrAct);
			act.StockOut = sumACT('StockOut', arrAct);
			act.Adjustment = sumACT('Adjustment', arrAct);
			act.Balance = sumACT('Balance', arrAct);
			act.AMC = act.AMC == null ? 'NA' : toFloat1d(act.AMC);

			var preBalance = act.Balance();
			act.MOS = ko.computed(() => act.AMC.in('NA', 0) ? 'NA' : toFloat1d(preBalance / act.AMC));

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

			master.month.subscribe(function (value) {
				if (value.year() == self.year()) {
					self.editReport(self.reportList()[value.month()]);
				} else {
					var url = getURL();
					url.month = value.format('MM');
					changeURL(url);

					self.year(value.year());
					self.getReport();
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
				return isNaN(value) ? 0 : value;
			})
		);
	}

	self.saveReport = function () {
		var details = self.detailList().filter(r => r.ItemId > 0);

		if (details.some(r => r.Balance() < 0)) {
			app.showMsg('<kh>តុល្យាការមិនអាចតូចជាងសូន្យ</kh>', '<kh>សូមបញ្ចូលទិន្ន័យអោយបានត្រឹមត្រូវ</kh>');
			return;
		}

		removeAllWarning();

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

		var submit = [];
		details.filter(r => r.ItemId > 0).forEach(r => {
			submit.push({
				Year: self.year(),
				Month: currentReport.month,
				ItemId: r.ItemId,
				StockStart: toFloat(r.StockStart()),
				StockIn: toFloat(r.StockIn()),
				StockOut: toFloat(r.StockOut()),
				Adjustment: toFloat(r.Adjustment()),
				Balance: r.Balance(),
				Expire: isnot(r.Expire(), null, x => x.format('YYYY-MM-DD')),
				ExpireDetail: JSON.stringify(r.ExpireDetail),
				Note: isnull(r.Note(), ''),
				InitUser: app.user.username,
				Rec_ID: r.Rec_ID
			});
		});
		var submit = { submit: JSON.stringify(submit) };

		app.ajax('/Stock/saveStockCNM', submit).done(function () {
			currentReport.has(true);
			self.back();
		});
	};

	self.deleteReport = function () {
		app.showDelete(function () {
			var type = self.master().type;
			var submit = {
				table: 'tblStockCNM',
				where: {
					Year: self.year(),
					Month: currentReport.month
				}
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Stock/deleteStock', submit).done(function () {
				currentReport.has(false);
				self.back();
			});
		});
	};

	self.back = function () {
		changeURL({ year: self.year() });
		self.isListView(true);
		self.detailList([]);
	};

	self.visibleReport = function (model) {
		return model.has() || self.year() < today.year() || (self.year() == today.year() && parseInt(model.month) <= today.month() + 1);
	};

	self.getColor = function (mos) {
		if (mos == 0) return 'red';
		return mos == 'NA' ? '' : mos <= 3 ? 'orange' : mos <= 6 ? 'green' : 'yellow';
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
}