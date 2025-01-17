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
	self.treatmentList = [];

	var prov = sessionStorage.code_prov;
	var currentReport = null;
	var ready = false;
	var firstWarnElement = null;
	var deletedList = [];
	var lastScrollTop = 0;
	var place = null;

	app.getPlace(['od', 'ds', 'cm', 'vl'], function (p) {
		place = p;
		self.odList(place.od.filter(r => r.pvcode == prov || r.code == app.user.od));
		if (prov == null) prov = place.od.find(r => r.code == app.user.od).pvcode;
		var dss = place.ds.filter(r => r.pvcode == prov).map(r => r.code);
		place.cm = place.cm.filter(r => dss.contain(r.dscode));
		var cms = place.cm.map(r => r.code);
		place.vl = place.vl.filter(r => cms.contain(r.cmcode));

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
		app.ajax('bednetGetReport', submit).done(function (rs) {
			rs.hfs.forEach(hf => {
				hf.reports = [];
				for (var i = 1; i <= 12; i++) {
					var m = ('0' + i).substr(-2);
					var obj = {
						id: hf.Code_Facility_T,
						en: hf.Name_Facility_E,
						kh: hf.Name_Facility_K,
						month: m,
						has: ko.observable(rs.reports.some(r => r.ID == hf.Code_Facility_T && r.Month == m))
					};
					hf.reports.push(obj);
				}
			});
			self.reportList(rs.hfs);

			if (url.id != null) {
				var report = rs.hfs.find(r => r.Code_Facility_T == url.id);
				report = report.reports[parseInt(url.month) - 1];
				self.editReport(report);
			}
		});
	};

	self.editReport = function (model) {
		changeURL({ year: self.year(), od: self.od(), id: model.id, month: model.month });

		if (model.has()) {
			var submit = {
				id: model.id,
				year: self.year(),
				month: model.month,
				has: model.has()
			};

			app.ajax('bednetGetCase', submit).done(prepare);
		} else {
			prepare({ detail: [] });
		}

		function prepare(rs) {
			currentReport = model;

			// master
			var master = {};
			master.od = self.odList().find(r => r.code == self.od()).name;
			master.en = model.en;
			master.kh = model.kh;
			master.month = model.month + '-' + self.year();
			master.has = model.has();
			master.changed = false;

			// detail
			if (app.user.role.in('OD', 'AU')) rs.detail.push(createObj());
			var details = [];
			rs.detail.forEach(r => details.push(convertObj(r)));

			ready = false;
			self.master(master);
			self.detailList(details);

			details.forEach(r => {
				app.setNumberOnly(r.LLIN.element, 'int');
				app.setNumberOnly(r.LLIHN.element, 'int');
			});
			ready = true;

			deletedList = [];
			lastScrollTop = $(window).scrollTop();
			self.isListView(false);
			$(window).scrollTop(0);

			if (app.user.role.in('OD', 'AU')) {
				var newModel = details.last();
				newModel.VillCode.popObject.villClick(newModel, { currentTarget: $('.btnvill').last()[0] });
			}
		}
	};

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

		newModel.skipFirst = true;
		newModel.VillCode.popObject.villClick(newModel, { currentTarget: $('.btnvill').last()[0] });
	};

	function createObj() {
		return {
			Rec_ID: -1,
			VillCode: null,
			LLIN: '',
            LLIHN: '',
            HammokNet: '',
            Pregnancy: '',
			Campaign: 0,
			Continued: 0,
			Mobile: 0,
			Type: ''
		};
	}

	function convertObj(r) {
		r.Type = r.Campaign == 1 ? 'Campaign' : r.Continued == 1 ? 'Continued' : r.Mobile == 1 ? 'Mobile' : '';

		var obj = app.ko(r);
		bindPopAddress(obj.VillCode);

		obj.changed = false;
		for (var key in createObj()) {
			obj[key].subscribe(function () {
				if (ready) obj.changed = true;
			});
		}

		return obj;
	}

	function bindPopAddress(column) {
		var cmcodes = place.vl.filter(r => r.hccode == currentReport.id).map(r => r.cmcode).distinct();
		var cms = place.cm.filter(r => cmcodes.contain(r.code));

		var po = column.popObject = {
			popVisible: ko.observable(false),
			villWarn: ko.observable(false),
			commune: ko.observable(null),
			village: ko.observable(null),
			commList: ko.observableArray(cms),
			villList: ko.observableArray(),
			base: column
		};

		po.commune.subscribe(code => {
			po.villList(place.vl.filter(x => x.cmcode == code));
			if (code != null || place.vl.some(r => r.code == column())) column(null);
		});
		po.village.subscribe(code => {
			if (po.commune() != null) column(code);
		});

		var code = column();
		if (code != null) {
			var vcode = code;
			var found = place.vl.find(r => r.code == code);
			if (found != null) po.commune(found.cmcode);
			po.village(vcode);
		}

		po.ok = function () {
			po.popVisible(false);
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
					//$(document).off('click', null, func);
					//po.popVisible(false);
				}
			};

			setTimeout(function () {
				$(document).on('click', func);
			});
		};
	}

	function warnDetail(model) {
		var missing = false;

		if (model.VillCode() == null) {
			var po = model.VillCode.popObject;
			po.villWarn(true);
			if (model.VillCode.handle == null) {
				model.VillCode.handle = model.VillCode.subscribe(v => po.villWarn(v == null));
				lstWarnDestroyFn.push(function () {
					model.VillCode.handle.dispose();
					model.VillCode.handle = null;
					po.villWarn(false);
				});
			}
			if (firstWarnElement == null) firstWarnElement = model.VillCode.element;
			missing = true;
		}
		if (model.LLIN() === '') { showWarning(model.LLIN); missing = true; }
		if (model.LLIHN() === '') { showWarning(model.LLIHN); missing = true; }
		if (model.Type() === '') { showWarning(model.Type); missing = true; }

		return missing;
	}

	self.saveReport = function () {
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

		if (details.length == 0 && deletedList.length == 0) {
			self.back(true);
			return;
		}

		var submit = {
			master: {
				ID: currentReport.id,
				Year: self.year(),
				Month: currentReport.month
			},
			details: []
		};

		details.forEach(d => {
			submit.details.push({
				Rec_ID: d.Rec_ID(),
				VillCode: d.VillCode(),
				LLIN: d.LLIN(),
                LLIHN: d.LLIHN(),
                HammokNet: d.HammokNet(),
                Pregnancy: d.Pregnancy(),
				Campaign: d.Type() == 'Campaign' ? 1 : 0,
				Continued: d.Type() == 'Continued' ? 1 : 0,
				Mobile: d.Type() == 'Mobile' ? 1 : 0
			});
		});

		deletedList.forEach(d => submit.details.push({ Rec_ID: d.Rec_ID() * -1 }));

		app.ajax('bednetUpdateCase', { submit: JSON.stringify(submit) }).done(function () {
			currentReport.has(self.detailList().length > 1);
			self.back(true);
		});
	};

	self.deleteReport = function () {
		app.showDelete(function () {
			var submit = {
				where: {
					ID: currentReport.id,
					Year: self.year(),
					Month: currentReport.month,
				}
			};

			app.ajax('bednetDeleteReport', submit).done(function () {
				currentReport.has(false);
				self.back(true);
			});
		});
	};

	self.deleteCase = function (model) {
		if (model.Rec_ID() > 0) {
			deletedList.push(model);
		}
		self.detailList.remove(model);
	};

	self.back = function (dontAsk) {
		if (dontAsk !== true && app.user.role.in('OD', 'AU')) {
			var dchanged = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed).length > 0;
			var deleted = deletedList.length > 0;
			if (dchanged || deleted) {
				showSave(() => setTimeout(self.saveReport, 100), () => self.back(true));
				return;
			}
		}

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
		var found = place.vl.find(r => r.code == code);
		return found == null ? code : found.name;
	};

	self.visibleReport = function (model) {
		return model.has() || self.year() < today.year() || (self.year() == today.year() && parseInt(model.month) <= today.month() + 1);
	};

	var lstWarnDestroyFn = [];
	function showWarning(bindingValue) {
		var el = $(bindingValue.element);

		if (el.attr('type') == 'radio') {
			var name = el.attr('name');
			el = $('input[name=' + name + ']').parent();
		}

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

	function changeURL(obj) {
		var search = location.pathname.split('/').last() + (obj == null ? '' : '?s=' + JSON.stringify(obj));
		window.history.replaceState(null, null, search);
	}

	function getURL() {
		var para = location.search.substr(3);
		return para != '' ? JSON.parse(decodeURI(para)) : null;
	}

	function showSave(callYes, callNo) {
		$('#modalSave').modal('show');
		$('#modalSave .btn-primary').off().click(callYes);
		$('#modalSave .btn-danger').off().click(callNo);
	}

	self.isSingle = function (arr) {
		return arr.length == 1;
	};
}