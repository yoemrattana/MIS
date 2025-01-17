function iDesTable(root) {
	var self = this;

	self.filter = ko.observable();
	self.mf = ko.observable(moment().month(0));
	self.mt = ko.observable(moment());
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.vl = ko.observable();
	self.site = ko.observable();
	self.loaded = ko.observable(false);

	self.tblSummary = ko.observableArray();
	self.tblSite = ko.observableArray();
	self.tblSiteCount = ko.observableArray();
	self.tblCase = ko.observable();
	self.tblEnroll = ko.observableArray();
	self.tblFollowup = ko.observableArray();

	self.viewClick = function () {
		var submit = {
			filter: self.filter(),
			mf: self.mf().format('YYYYMM'),
			mt: self.mt().format('YYYYMM'),
			pv: self.pv(),
			od: self.od(),
			hc: self.hc(),
			vl: self.vl(),
			site: self.site()
		};
		app.ajax('/iDes/getTable', submit).done(function (rs) {
			self.loaded(true);

			if (self.filter() == 'iDES Summary') self.tblSummary(rs);
			else if (self.filter() == 'iDES Sites') {
				self.tblSite(rs.site);
				self.tblSiteCount(rs.count);
			}
			else if (self.filter() == 'Case Notification') {
				Object.keys(rs).forEach(k => rs[k] = isnull(rs[k], 0));
				self.tblCase(rs);
			}
			else if (self.filter() == 'Case Enrollment') self.tblEnroll(rs);
			else if (self.filter() == 'Follow-up') self.tblFollowup(rs);
		});
	};

	self.filter.subscribe(() => self.loaded(false));

	self.odList = function () {
		return self.pv() == null ? [] : root.place.od.filter(r => r.pvcode == self.pv());
	};

	self.hcList = function () {
		return self.od() == null ? [] : root.place.hc.filter(r => r.odcode == self.od());
	};

	self.vlList = function () {
		return self.hc() == null ? [] : root.place.vl.filter(r => r.hccode == self.hc() && r.type != null);
	};

	self.getFollowupPercent = function (day, species) {
		if (day == 'Day 0') return 'NA';

		var a = self.tblFollowup().find(r => r.Day == 'Day 0')[species];
		var b = self.tblFollowup().find(r => r.Day == day)[species];
		return a == 0 ? 'NA' : (b * 100 / a).toFixed(0);
	};
}