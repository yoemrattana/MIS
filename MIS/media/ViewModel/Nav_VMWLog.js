function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.provList = ko.observableArray();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.prov = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.yearList = ko.observableArray();
	self.year = ko.observable(moment().add(-1, 'months').year());
	self.rs = ko.observable();

	var place = null;
	var changeList = [], vmwChangeList = [], noteChangeList = [];
	var mainData = [];
	var rowLimit = app.newRowLimit(50);

	for (var i = 2010; i <= self.year() ; i++) {
		self.yearList.push(i);
	}

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
		place = p;
		self.provList(p.pv);
		self.prov(location.pathname.split('/')[3]);
		
		getData();
	});

	function getData() {
		self.odList(place.od.filter(r => r.pvcode == self.prov()));

		var submit = { pv: self.prov(), year: self.year() };

		app.ajax('/SystemMenu/getVMWLog', submit).done(function (rs) {
			var list = [];
			rs.vmw.forEach(item => {
				var code = item.code;
				var vl = place.vl.find(r => r.code == code);
				var hc = place.hc.find(r => r.code == vl.hccode);
				var od = place.od.find(r => r.code == hc.odcode);

				var noteChange = noteChangeList.find(r => r.code == code && r.year == self.year());
				var noteServer = rs.note.find(r => r.code == code);
				var note = noteChange != null ? noteChange.note : isnot(noteServer, undefined, r => r.Note);

				var row = {
					odName: od.name, odNameK: od.nameK,
					hcName: hc.name, hcNameK: hc.nameK,
					vlName: vl.name, vlNameK: vl.nameK,
					odCode: od.code, hcCode: hc.code,
					vlCode: vl.code,
					HaveVMW: ko.observable(item.HaveVMW == 1),
					IP1: ko.observable(item.IP1 == 1),
					IP2: ko.observable(item.IP2 == 1),
					CSO: ko.observable(item.CSO),
					note: ko.observable(note),

					HaveVMWo: item.HaveVMW == 1,
					IP1o: item.IP1 == 1,
					IP2o: item.IP2 == 1
				};

				function addChange() {
					vmwChangeList = vmwChangeList.filter(r => r.where.Code_Vill_T != code);
					vmwChangeList.push({
						where: { Code_Vill_T: code },
						value: {
							HaveVMW: row.HaveVMW() ? 1 : 0,
							IP1: row.IP1() ? 1 : 0,
							IP2: row.IP2() ? 1 : 0
						},
						ori: {
							HaveVMW: row.HaveVMWo ? 1 : 0,
							IP1: row.IP1o ? 1 : 0,
							IP2: row.IP2o ? 1 : 0
						}
					});
				}

				row.HaveVMW.subscribe(addChange);
				row.IP1.subscribe(addChange);
				row.IP2.subscribe(addChange);
				row.CSO.subscribe(addChange);

				row.note.subscribe(function (value) {
					var found = noteChangeList.find(r => r.code == code && r.year == self.year());
					found == null ? noteChangeList.push({ code: code, year: self.year(), note: value.trim() }) : found.note = value.trim();
				});

				for (var m = 1; m <= 12; m++) {
					var mm = ('0' + m).substr(-2);
					var info = changeList.find(r => r.code == code && r.year == self.year() && r.month == mm);
					if (info == null) {
						var has = rs.log.some(r => r.code == code && r.Month == mm);
						row[m] = ko.observable(has);
						row[m].info = { code: vl.code, year: self.year(), month: mm, has: has };
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
			mainData = list;
			self.listModel(list);

			rowLimit.reset();
		});
	}

	self.save = function () {
		if (changeList.length == 0 && noteChangeList.length == 0 && vmwChangeList.length == 0) return;

		var log = [];
		_.each(vmwChangeList, function (v) {
			if (v.value.HaveVMW != v.ori.HaveVMW || v.value.IP1 != v.ori.IP1 || v.value.IP2 != v.ori.IP2) {
				var l = {
					Code_Vill_T: v.where.Code_Vill_T,
					NewValue: JSON.stringify(_.omit(v.value, ['CSO'])),
					OldValue: JSON.stringify(v.ori)
				}
				log.push(l);
			}
		});
		
		var submit = {
			log: JSON.stringify(log)
		}

		app.ajax('/SystemMenu/saveTrackingLog', submit);

		var submit = {
			list: JSON.stringify(changeList),
			vmw: JSON.stringify(vmwChangeList),
			note: JSON.stringify(noteChangeList)
		};

		app.ajax('/SystemMenu/saveVMWLog', submit).done(function () {
			changeList.forEach(r => r.has = !r.has);
			changeList = [];
			vmwChangeList = [];
			noteChangeList = [];
		});


	};

	self.prov.subscribe(getData);

	self.od.subscribe(function (code) {
		var before = self.hc();

		self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));

		if (before == self.hc()) self.hc.notifySubscribers(before);
	});

	self.hc.subscribe(function (code) {
		if (code != null) {
			self.listModel(mainData.filter(r => r.hcCode == code));
		} else if (self.od() != null) {
			self.listModel(mainData.filter(r => r.odCode == self.od()));
		} else {
			self.listModel(mainData);
		}

		rowLimit.reset();
	});

	self.year.subscribe(getData);

	self.sortTable = function (col, method) {
		var before = self.listModel.slice(0);

		self.listModel.sort(function (a, b) {
			var aa = a[col], bb = b[col];
			if (method !== undefined) {
				aa = self[method](aa);
				bb = self[method](bb);
			}
			if (typeof aa == 'string') {
				aa = aa.toLowerCase();
				bb = bb.toLowerCase();
			}
			return aa > bb ? 1 : aa < bb ? -1 : 0;
		});
		var rows = self.listModel();

		var sorted = true;
		for (var i = 0; i < before.length; i++) {
			if (before[i] === rows[i]) continue;
			sorted = false;
			break;
		}
		if (sorted) self.listModel.reverse();

		window.scrollTo({ top: 0 });
		rowLimit.reset();
	};

	self.getListModel = ko.pureComputed(function () {
		return self.listModel().slice(0, rowLimit());
	});

	$(window).scroll(function () {
		if (innerHeight + scrollY + 1000 < document.body.scrollHeight) return;
		if (rowLimit() > self.listModel().length) return;

		rowLimit.increase();
	});
}