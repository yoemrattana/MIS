function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.dateList = ko.observableArray();

	self.odList = ko.observableArray();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.year = ko.observable(moment());
	self.year.skip = 0;

	var place = null;

	app.getPlace(['od', 'hc'], function (p) {
		var pv = sessionStorage.code_prov || app.user.prov;

		place = p;
		place.od = place.od.filter(r => r.target == 1 && r.pvcode == pv);

		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

		self.odList(place.od);
	});

	self.hc.subscribe(getData);
	self.year.subscribe(function () {
		if (self.year.skip == 2) getData();
		else self.year.skip++;
	})

	function getData() {
		if (self.hc() == null) {
			self.listModel([]);
			self.dateList([]);
			return;
		}

		var submit = {
			code: self.hc(),
			year: self.year().year()
		};
		app.ajax('/VMWMeeting/getData', submit).done(prepare);
	}

	function prepare(rs) {
		var vmws = rs.meeting.distinct('Code_Vill_T');
		vmws.forEach(vmw => {
			vmw.months = [];
			for (var i = 1; i <= 12; i++) {
				var m = ('0' + i).substr(-2);
				var found = rs.meeting.find(r => r.Code_Vill_T == vmw.Code_Vill_T && r.Month == m) || {};
				var obj = {
					id: found.Rec_ID || 0,
					active: found.Month != null,
					met: found.Met == 1,
					old: found.Met == 1
				};
				vmw.months.push(obj);
			}
		});
		self.listModel(vmws);

		var temp = rs.date || {};
		var arr = Array.repeat(13).map((r, i) => temp['M' + i] || '').slice(1);
		self.dateList(arr);
	}

	self.save = function () {
		if (self.listModel().length == 0) return;

		var list = [];
		self.listModel().forEach(r => {
			r.months.forEach((m, i) => {
				if (m.met == m.old) return;

				list.push({
					Rec_ID: m.id,
					Year: self.year().year(),
					Month: (i + 1).toString().padStart(2, '0'),
					Code_Vill_T: r.Code_Vill_T,
					Met: m.met ? 1 : 0,
					ModiUser: app.user.username,
					ModiTime: moment().sqlformat('datetime')
				});
			})
		});

		var date = self.dateList().reduce((rs, r, i) => {
			rs['M' + (i  + 1)] = r == '' ? null : r;
			return rs;
		}, {});
		date.Code_Facility_T = self.hc();
		date.Year = self.year().year();
		date.ModiUser = app.user.username;
		date.ModiTime = moment().sqlformat('datetime');

		var submit = {
			list,
			date: JSON.stringify(date),
			code: self.hc(),
			year: self.year().year()
		};
		app.ajax('/VMWMeeting/save', submit).done(prepare);
	};

	self.hcList = function () {
		return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
	};

	self.exportExcel = function () {
		app.downloadBlob('/VMWMeeting/exportExcel/').done(function (blob) {
			saveAs(blob, 'VMW Meeting.xlsx');
		});
	};
}