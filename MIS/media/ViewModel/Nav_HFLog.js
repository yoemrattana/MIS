function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.provList = ko.observableArray();
	self.odList = ko.observableArray();
	self.prov = ko.observable();
	self.od = ko.observable();

	self.yearList = ko.observableArray();
	self.year = ko.observable(moment().add(-1, 'months').year());

	var place = null;
	var changeList = [], hfChangeList = [];

	for (var i = 2010; i <= self.year() ; i++) {
		self.yearList.push(i);
	}

	app.getPlace(['pv', 'od', 'hc'], function (p) {
		place = p;
		self.provList(p.pv);
		self.prov(location.pathname.split('/')[3]);
		getData();
	});

	function getData() {
		var submit = { pv: self.prov(), year: self.year() };

		app.ajax('/SystemMenu/getHFLog', submit).done(function (rs) {
			var list = [];
			rs.hc.forEach(item => {
				var code = item.code;
				var hc = place.hc.find(r => r.code == code);
				var od = place.od.find(r => r.code == hc.odcode);
				var type = rs.hc.find(r => r.code == code).type;

				var row = {
					odName: od.name, odNameK: od.nameK,
					hcName: hc.name, hcNameK: hc.nameK,
					odCode: od.code, hcCode: hc.code,
					type: type,
					IP1: ko.observable(item.IP1 == 1),
					IP2: ko.observable(item.IP2 == 1)
				};

				function addChange() {
					hfChangeList = hfChangeList.filter(r => r.where.Code_Facility_T != code);
					hfChangeList.push({
						where: { Code_Facility_T: code },
						value: {
							IP1: row.IP1() ? 1 : 0,
							IP2: row.IP2() ? 1 : 0
						}
					});
				}

				row.IP1.subscribe(addChange);
				row.IP2.subscribe(addChange);

				for (var m = 1; m <= 12; m++) {
					var mm = ('0' + m).substr(-2);
					var info = changeList.find(r => r.code == code && r.year == self.year() && r.month == mm);
					if (info == null) {
						var has = rs.log.some(r => r.code == code && r.Month == mm);
						row[m] = ko.observable(has);
						row[m].info = { code: hc.code, year: self.year(), month: mm, has: has };
					} else {
						row[m] = ko.observable(!info.has);
						row[m].info = info;
					}
					row[m].subscribe(function (value) {
						var info = this._target.info;
						value === info.has ? changeList.remove(info) : changeList.push(info);
					});
				}
				list.push(row);
			});
			self.listModel(list);
			self.odList(place.od.filter(r => r.pvcode == self.prov()));
		});
	}

	self.save = function () {
		if (changeList.length == 0 && hfChangeList.length == 0) return;
		
		var submit = {
			list: JSON.stringify(changeList),
			hf: JSON.stringify(hfChangeList)
		};

		app.ajax('/SystemMenu/saveHFLog', submit).done(function () {
			changeList.forEach(r => r.has = !r.has);
			changeList = [];
			hfChangeList = [];
		});
	};

	self.prov.subscribe(getData);
	self.year.subscribe(getData);
}