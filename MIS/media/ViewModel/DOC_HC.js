function viewModel() {
	var self = this;

	self.menu = ko.observable();
	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();

	self.listModel1 = ko.observableArray();
	self.listModel2 = ko.observableArray();
	self.listModel3 = ko.observableArray();

	self.loaded1 = ko.observable(false);
	self.loaded2 = ko.observable(false);
	self.loaded3 = ko.observable(false);

	var lastCode1, lastCode2, lastCode3;
	var place = null;

	$('.btn.menu').click(function () {
		self.menu(this.innerHTML);
		$('.btn.menu').each(function () {
			$(this).removeClass('btn-default btn-info');
			this.innerHTML == self.menu() ? $(this).addClass('btn-info') : $(this).addClass('btn-default');
		});
	});
	$('.btn.menu:first').click();

	app.getPlace(['pv', 'od', 'hc'], function (p) {
		place = p;
		self.pvList(p.pv);
	});

	self.viewClick = function () {
		if (self.hc() == null) return;

		var submit = {
			code: self.hc(),
			menu: self.menu()
		};
		app.ajax('/DOC/getData', submit).done(function (rs) {
			if (self.menu().contain('Availability')) {
				self.listModel1(rs.map(app.ko));
				self.loaded1(true);
				lastCode1 = self.hc();
			}
			else if (self.menu().contain('Accessibility')) {
				self.listModel2(rs.map(app.ko));
				self.loaded2(true);
				lastCode2 = self.hc();
			}
			else {
				self.listModel3(rs.map(app.ko));
				self.loaded3(true);
				lastCode3 = self.hc();
			}
		});
	};

	self.save = function () {
		if (self.menu().contain('Availability')) {
			var code = lastCode1;
			var list = self.listModel1().map(r => {
				return {
					Code_Facility_T: code,
					SN: r.SN(),
					Expect20: r.Expect20() || null,
					Actual20: r.Actual20() || null,
					Actual20e: r.Actual20e() || null,
					Expect21: r.Expect21() || null,
					Actual21: r.Actual21() || null,
					Actual21e: r.Actual21e() || null,
					Expect22: r.Expect22() || null,
					Actual22: r.Actual22() || null,
					Actual22e: r.Actual22e() || null,
					Expect23: r.Expect23() || null,
					Actual23: r.Actual23() || null,
					Actual23e: r.Actual23e() || null,
					Expect24: r.Expect24() || null,
					Actual24: r.Actual24() || null,
					Actual24e: r.Actual24e() || null,
					Rate: self.getRate(r, ''),
					RateE: self.getRate(r, 'e')
				};
			});
		}

		if (self.menu().contain('Accessibility')) {
			var code = lastCode2;
			var list = self.listModel2().map(r => {
				return {
					Code_Facility_T: code,
					SN: r.SN(),

					NoAccess20: r.NoAccess20() || null,
					Hard20: r.Hard20() || null,
					Soft20: r.Soft20() || null,
					MIS20: r.MIS20() || null,
					Web20: r.Web20() || null,

					NoAccess20e: r.NoAccess20e() || null,
					Hard20e: r.Hard20e() || null,
					Soft20e: r.Soft20e() || null,
					MIS20e: r.MIS20e() || null,
					Web20e: r.Web20e() || null,

					NoAccess21: r.NoAccess21() || null,
					Hard21: r.Hard21() || null,
					Soft21: r.Soft21() || null,
					MIS21: r.MIS21() || null,
					Web21: r.Web21() || null,

					NoAccess21e: r.NoAccess21e() || null,
					Hard21e: r.Hard21e() || null,
					Soft21e: r.Soft21e() || null,
					MIS21e: r.MIS21e() || null,
					Web21e: r.Web21e() || null,

					NoAccess22: r.NoAccess22() || null,
					Hard22: r.Hard22() || null,
					Soft22: r.Soft22() || null,
					MIS22: r.MIS22() || null,
					Web22: r.Web22() || null,

					NoAccess22e: r.NoAccess22e() || null,
					Hard22e: r.Hard22e() || null,
					Soft22e: r.Soft22e() || null,
					MIS22e: r.MIS22e() || null,
					Web22e: r.Web22e() || null,

					NoAccess23: r.NoAccess23() || null,
					Hard23: r.Hard23() || null,
					Soft23: r.Soft23() || null,
					MIS23: r.MIS23() || null,
					Web23: r.Web23() || null,

					NoAccess23e: r.NoAccess23e() || null,
					Hard23e: r.Hard23e() || null,
					Soft23e: r.Soft23e() || null,
					MIS23e: r.MIS23e() || null,
					Web23e: r.Web23e() || null,

					NoAccess24: r.NoAccess24() || null,
					Hard24: r.Hard24() || null,
					Soft24: r.Soft24() || null,
					MIS24: r.MIS24() || null,
					Web24: r.Web24() || null,

					NoAccess24e: r.NoAccess24e() || null,
					Hard24e: r.Hard24e() || null,
					Soft24e: r.Soft24e() || null,
					MIS24e: r.MIS24e() || null,
					Web24e: r.Web24e() || null,

					NoAccessRate: self.getNoAccessRate(r, ''),
					HardRate: self.getHardRate(r, ''),
					SoftRate: self.getSoftRate(r, ''),
					MISRate: self.getMISRate(r, ''),
					WebRate: self.getWebRate(r, ''),

					NoAccessRateE: self.getNoAccessRate(r, 'e'),
					HardRateE: self.getHardRate(r, 'e'),
					SoftRateE: self.getSoftRate(r, 'e'),
					MISRateE: self.getMISRate(r, 'e'),
					WebRateE: self.getWebRate(r, 'e')
				};
			});
		}

		if (self.menu().contain('Comp-Accuracy')) {
			var code = lastCode3;
			var list = self.listModel3().map(r => {
				return {
					Code_Facility_T: code,
					Doc2_ID: r.Doc2_ID(),

					Expect20: r.Expect20() || null,
					Complete20: r.Complete20() || null,
					Accurate20: r.Accurate20() || null,
					Complete20e: r.Complete20e() || null,
					Accurate20e: r.Accurate20e() || null,

					Expect21: r.Expect21() || null,
					Complete21: r.Complete21() || null,
					Accurate21: r.Accurate21() || null,
					Complete21e: r.Complete21e() || null,
					Accurate21e: r.Accurate21e() || null,

					Expect22: r.Expect22() || null,
					Complete22: r.Complete22() || null,
					Accurate22: r.Accurate22() || null,
					Complete22e: r.Complete22e() || null,
					Accurate22e: r.Accurate22e() || null,

					Expect23: r.Expect23() || null,
					Complete23: r.Complete23() || null,
					Accurate23: r.Accurate23() || null,
					Complete23e: r.Complete23e() || null,
					Accurate23e: r.Accurate23e() || null,

					Expect24: r.Expect24() || null,
					Complete24: r.Complete24() || null,
					Accurate24: r.Accurate24() || null,
					Complete24e: r.Complete24e() || null,
					Accurate24e: r.Accurate24e() || null,

					Completeness: self.getCompleteRate(r, ''),
					Accuracy: self.getAccuracyRate(r, ''),
					CompletenessE: self.getCompleteRate(r, 'e'),
					AccuracyE: self.getAccuracyRate(r, 'e')
				};
			});
		}

		var submit = {
			where: { Code_Facility_T: code },
			table: 'tblDoc' + self.menu().replace(' ', '').replace('-Accuracy', ''),
			list: JSON.stringify(list)
		};
		app.ajax('/DOC/save', submit);
	};

	self.odList = function () {
		return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
	};

	self.hcList = function () {
		return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od() && r.name.substr(-3) != ' RH');
	};

	self.visibleSave = function () {
		return self.menu().contain('Availability') && self.loaded1() ? true
			: self.menu().contain('Accessibility') && self.loaded2() ? true
			: self.menu().contain('Comp-Accuracy') && self.loaded3() ? true
			: false;
	};

	self.getRate = function (m, e) {
		var e20 = (m.Expect20() || 0).toFloat();
		var e21 = (m.Expect21() || 0).toFloat();
		var e22 = (m.Expect22() || 0).toFloat();
		var e23 = (m.Expect23() || 0).toFloat();
		var e24 = (m.Expect24() || 0).toFloat();

		var a20 = (m['Actual20' + e]() || 0).toFloat();
		var a21 = (m['Actual21' + e]() || 0).toFloat();
		var a22 = (m['Actual22' + e]() || 0).toFloat();
		var a23 = (m['Actual23' + e]() || 0).toFloat();
		var a24 = (m['Actual24' + e]() || 0).toFloat();

		var eTotal = e20 + e21 + e22 + e23 + e24;
		var aTotal = a20 + a21 + a22 + a23 + a24;

		var result = eTotal == 0 ? 0 : aTotal * 100 / eTotal;
		return result.toFixed(2);
	};

	self.getNoAccessRate = function (m, e) {
		var total = [20, 21, 22, 23, 24].sum(r => (m['NoAccess' + r + e]() || 0).toFloat());
		return (total * 100 / 5).toFixed(2);
	};

	self.getHardRate = function (m, e) {
		var total = [20, 21, 22, 23, 24].sum(r => (m['Hard' + r + e]() || 0).toFloat());
		return (total * 100 / 5).toFixed(2);
	};

	self.getSoftRate = function (m, e) {
		var total = [20, 21, 22, 23, 24].sum(r => (m['Soft' + r + e]() || 0).toFloat());
		return (total * 100 / 5).toFixed(2);
	};

	self.getMISRate = function (m, e) {
		var total = [20, 21, 22, 23, 24].sum(r => (m['MIS' + r + e]() || 0).toFloat());
		return (total * 100 / 5).toFixed(2);
	};

	self.getWebRate = function (m, e) {
		var total = [20, 21, 22, 23, 24].sum(r => (m['Web' + r + e]() || 0).toFloat());
		return (total * 100 / 5).toFixed(2);
	};

	self.getCompleteRate = function (m, e) {
		var a = [20, 21, 22, 23, 24].sum(r => (m['Expect' + r]() || 0).toFloat());
		var b = [20, 21, 22, 23, 24].sum(r => (m['Complete' + r + e]() || 0).toFloat());
		return (a == 0 ? 0 : b * 100 / a).toFixed(2);
	};

	self.getAccuracyRate = function (m, e) {
		var a = [20, 21, 22, 23, 24].sum(r => (m['Complete' + r + e]() || 0).toFloat());
		var b = [20, 21, 22, 23, 24].sum(r => (m['Accurate' + r + e]() || 0).toFloat());
		return (a == 0 ? 0 : b * 100 / a).toFixed(2);
	};

	self.ifNewGroup = function (i) {
		if (i == 0) return true;
		var a = self.listModel3()[i - 1].SN();
		var b = self.listModel3()[i].SN();
		return a != b;
	};

	self.getRowspan = function (m) {
		return self.listModel3().filter(r => r.SN() == m.SN()).length;
	};

	self.getDisable1 = function (sn, year) {
		if (sn >= 1 && sn <= 8 && year < 24) return true;
		if (sn >= 10 && sn <= 12 && year < 24) return true;
		return false;
	};

	self.getDisable2 = function (sn, year) {
		if (sn >= 1 && sn <= 8 && year < 24) return true;
		if (sn >= 10 && sn <= 12 && year < 24) return true;
		return false;
	};
}