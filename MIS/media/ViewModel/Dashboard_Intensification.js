if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {
	var markers = [];
	var ipMarkers = [];
	var ipHFs = [];
	var map = null;
	var firstDrawDone = false;

	self.ip = ko.observable('2');
	self.primaquineRate = ko.observable();
	self.table30HF = ko.observableArray();

	self.visibleInten = ko.observable(false);
	self.tableIPCase = ko.observableArray();
	self.tableIPOutReach = ko.observableArray();
	self.tableIPSLDP = ko.observableArray();
	self.ipFilterDateList = [];

	self.ipFilterDate = ko.observable();

	var i = moment('Dec 2019', 'MMM YYYY');
	while (i.format('YYYYMM') <= moment().format('YYYYMM')) {
		self.ipFilterDateList.push(i.format('MMM YYYY'));
		i.add(1, 'months');
	}

	self.showTabIntensificationPlan = function () {
		self.getIntensification();
	};

	self.ip.subscribe(function () {
		if (self.loaded()) self.getIntensification();
	});

	self.changeTick30HF = function (viewModel, event) {
		self.table30HF().forEach(cso => {
			cso.checked(event.currentTarget.checked);
			cso.tickChange(null, event);
		});
		return true;
	};

	self.getIntensification = function () {
		self.table30HF([]);

		var submit = {
			year: self.year(),
			from: self.monthList.indexOf(self.from()) + 1,
			to: self.monthList.indexOf(self.to()) + 1,
			prov: isnull(self.prov(), ''),
			ip: self.ip(),
			filterDateCase: self.lastSubmit.filterDateCase
		};
		app.ajax('/Dashboard/tabIntensification/', submit).done(function (rs) {
			Object.keys(rs).forEach(key => self.mainData[key] = rs[key]);

			self.drawChartIntensification();

			self.loaded(true);
			firstDrawDone = true;
		});
	};

	self.waitAndDrawIP = function () {
		if (self.waitAndDrawIP.wait !== true) {
			self.waitAndDrawIP.wait = true;

			app.showLoader();
			setTimeout(() => {
				self.waitAndDrawIP.wait = false;
				self.drawChartIntensification();
				app.hideLoader();
			});
		}
		return true;
	};

	self.getPrimaquineACT = function () {
		var primaquine = self.mainData.chartIntensification.sum(r => r.PrimaquineACT);
		var positive = self.mainData.chartIntensification.sum(r => r.Positive);
		self.primaquineRate((primaquine / positive).toFixed(3));
	};

	self.drawChartIntensification = function () {
		var model = self.mainData.chartIntensification;
		self.getPrimaquineACT();

		if (self.table30HF().length == 0) {
			var colors = {
				'Care': 'black',
				'CRS': 'red',
				'PSI': 'blue',
				'URC': 'green'
			};

			ipHFs = model.filter(r => r.IP == self.ip()).map(r => r.Code_Facility_T).distinct().map(code => {
				var hf = self.place.hc.find(r => r.code == code);
				var od = self.place.od.find(r => r.code == hf.odcode);
				var cso = model.find(r => r.Code_Facility_T == code).CSO;
				if (od == null || !self.place.pv.some(r => r.code == od.pvcode)) return null;
				return {
					cso: cso,
					od: 'OD - ' + od.name,
					hf: 'HC - ' + hf.name,
					odcode: od.code,
					hfcode: code,
					color: colors[cso],
					checked: ko.observable(true),
					tickChange: self.waitAndDrawIP
				};
			}).filter(r => r != null).sortasc(r => r.cso.toLowerCase(), r => r.od, r => r.hf);

			var list = ipHFs.map(r => r.cso).distinct().map(cso => {
				return {
					cso: 'CSO - ' + cso,
					color: colors[cso],
					checked: ko.observable(true),
					tickChange: function (vm, event) {
						this.ods.forEach(r => {
							r.checked(event.currentTarget.checked);
							r.tickChange(null, event);
						});
						return true;
					},
					ods: ipHFs.filter(r => r.cso == cso).map(r => r.od).distinct().map(od => {
						return {
							od: od,
							color: colors[cso],
							checked: ko.observable(true),
							tickChange: function (vm, event) {
								this.hfs.forEach(r => {
									r.checked(event.currentTarget.checked);
									r.tickChange();
								});
								return true;
							},
							hfs: ipHFs.filter(r => r.od == od)
						};
					})
				};
			});
			self.table30HF(list);
		}

		var monthYear = model.map(r => r.MonthYear).distinct();
		var filtered = ipHFs.filter(r => r.checked()).map(r => r.hfcode);
		model = model.filter(r => filtered.contain(r.Code_Facility_T));
		model = monthYear.map(my => {
			var founds = model.filter(r => r.MonthYear == my);
			var obj = {
				Pf: founds.sum(r => r.Pf),
				Pv: founds.sum(r => r.Pv),
				Mix: founds.sum(r => r.Mix),
				Positive: founds.sum(r => r.Positive),
				Test: founds.sum(r => r.Test),
				HF: founds.sum(r => r.HF),
				VMW: founds.sum(r => r.VMW),
				MMWIP: founds.sum(r => r.MMWIP),
				MMW: founds.sum(r => r.MMW),
				HF_test: founds.sum(r => r.HF_test),
				VMW_test: founds.sum(r => r.VMW_test),
				MMWIP_test: founds.sum(r => r.MMWIP_test),
				MMW_test: founds.sum(r => r.MMW_test),
			};
			obj.TPR = obj.Test == 0 ? 0 : Math.round(obj.Positive * 100 / obj.Test);
			return obj;
		});

		var categories = monthYear.map(r => r.substr(-4)).distinct().map(y => {
			return {
				name: y,
				categories: monthYear.filter(r => r.substr(-4) == y).map(r => parseInt(r.substr(0, 2)))
			}
		});
		var duration = 'Jan 2018 - ' + moment(monthYear.last(), 'MM/YYYY').format('MMM YYYY');

		$('#chartIntenSpecies').highcharts({
			chart: { type: 'column' },
			title: { text: 'Malaria Cases by Species, ' + duration },
			colors: ['#e74c3c', '#e67e22', '#3498db', '#2b908f'],
			subtitle: { text: '.' },
			xAxis: { categories: categories, labels: { rotation: 0 }, crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of Cases' }, reversedStacks: false },
			tooltip: { shared: true, enabled: !self.isGuest },
			plotOptions: { column: { stacking: 'normal' } },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ id: 'PF', name: 'PF', data: model.map(r => r.Pf), visible: $('.chartIntenSpeciesCbox#PF').prop('checked') },
				{ id: 'PV', name: 'PV', data: model.map(r => r.Pv), visible: $('.chartIntenSpeciesCbox#PV').prop('checked') },
				{ id: 'Mix', name: 'Mix', data: model.map(r => r.Mix), visible: $('.chartIntenSpeciesCbox#Mix').prop('checked') }
			]
		}, function (chart) {
			self.tickChbox('.chartIntenSpeciesCbox', chart);
		});

		$('#chartIntenRate').highcharts({
			chart: { type: 'spline' },
			title: { text: 'Malaria Test and Positive Rate, ' + duration },
			xAxis: { categories: categories, crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'Number of Test' }, reversedStacks: false }, { title: { text: 'Positive Rate' }, labels: { format: '{value}%' }, opposite: true, max: 100 }],
			tooltip: {
				shared: true, enabled: !self.isGuest,
				formatter: function () {
					var text = '';

					for (var i = 0; i < this.points.length; i++) {
						var p = this.points[i];
						var value = i == 0 ? p.y : p.y + '%';
						text += `<span style="color:${p.color}">●</span> ${p.series.name}: <b>${value}</b><br/>`;
					}

					['HF', 'VMW', 'MMW', 'MMW IP'].forEach((name, i) => {
						var c = Highcharts.getOptions().colors[i + 2];
						var p = this.points[0];
						text += `<span style="color:${c}">●</span> ${name}: <b>${p.point[name.replace(' ', '')]}</b><br/>`;
					});

					return text;
				}
			},
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{
					name: 'Total Test',
					data: model.map(r => {
						return {
							y: r.Test,
							HF: r.HF_test,
							VMW: r.VMW_test,
							MMW: r.MMW_test,
							MMWIP: r.MMWIP_test
						}
					})
				},
				{ name: 'Positive Rate', data: model.map(r => r.TPR), tooltip: { valueSuffix: '%' }, yAxis: 1 }
			]
		});

		self.drawChartIntenFacility();
		self.drawChartIntenTop10Vill();
		drawChartSLDP();
		self.drawTableIP();
		self.drawTableOutReach();
		drawTableSLDP();
		self.drawIntenMap();
		self.drawIP2Map();
		return true;
	};

	self.drawChartIntenTop10Vill = function (root, event) {
		if (event && event.currentTarget.tagName == 'SELECT') {
			this.month = event.currentTarget.value;
			if (!firstDrawDone) return;
		}

		var model = self.mainData.chartIntensificationTop10Vill;
		var pf = $('#chartIntenTop10VillPf').prop('checked');
		var pv = $('#chartIntenTop10VillPv').prop('checked');
		var mix = $('#chartIntenTop10VillMix').prop('checked');

		if (this.month != '') {
			var month = moment(this.month, 'MMM YYYY').format('MM/YYYY');
			model = model.filter(r => r.MonthYear == month);
		}

		var filtered = ipHFs.filter(r => r.checked()).map(r => r.hfcode);
		model = model.filter(r => filtered.contain(r.Code_Facility_T)).groupby('Name').map(arr => {
			return {
				name: arr[0].Name,
				pf: pf ? arr.sum(r => r.Pf) : 0,
				pv: pv ? arr.sum(r => r.Pv) : 0,
				mix: mix ? arr.sum(r => r.Mix) : 0
			};
		});
		model = model.sortdesc(r => r.pf + r.pv + r.mix).slice(0, 10).filter(r => r.pf + r.pv + r.mix > 0);
		var duration = self.ip() == 1 ? 'Jan 2018 - Nov 2019' : is(this.month, '', 'Dec 2019 - ' + moment().add(-1, 'months').format('MMM YYYY'));

		$('#chartIntenTop10Vill').highcharts({
			chart: { type: 'bar' },
			title: { text: 'Top 10 Villages Having Most Cases by Species, ' + duration },
			subtitle: { text: '.' },
			colors: ["#FF7474", "#F7A35C", "#95CEFF"],
			xAxis: { categories: model.map(r => r.name), crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of cases' }, reversedStacks: false },
			tooltip: { shared: true, enabled: !self.isGuest },
			plotOptions: { series: { stacking: 'normal' }, bar: { pointWidth: 20 } },
			exporting: { sourceWidth: 1200, sourceHeight: 800 },
			series: [
				{ name: 'PF', data: model.map(r => r.pf), visible: pf },
				{ name: 'PV', data: model.map(r => r.pv), visible: pv },
				{ name: 'Mix', data: model.map(r => r.mix), visible: mix }
			]
		}, function () {
			var x = this.plotLeft - 15;
			var y = 55;
			var style = { 'font-weight': 'bold', 'text-anchor': 'end' };
			this.renderer.text('OD / Health Facility / Village', x, y).attr(style).add();
		});

		return true;
	};

	function drawChartSLDP() {
		var model = self.mainData.IP2SLDP;

		var filtered = ipHFs.filter(r => r.checked()).map(r => r.hfcode);
		model = model.filter(r => filtered.contain(r.Code_Facility_T));

		var monthYear = self.ipFilterDateList.map(r => moment(r, 'MMM YYYY').format('MM/YYYY'));
		var categories = monthYear.map(r => r.substr(-4)).distinct().map(y => {
			return {
				name: y,
				categories: monthYear.filter(r => r.substr(-4) == y).map(r => parseInt(r.substr(0, 2)))
			}
		});

		var data = model.sort(r => r.YearMonth).groupby('YearMonth').map(arr => {
			return {
				PfMix: arr.sum(r => r.PfMix),
				SLDP: arr.sum(r => r.SLDP),
				Percent: Math.round(arr.sum(r => r.SLDP) / arr.sum(r => r.PfMix) * 100)
			};
		});

		var duration = 'Dec 2019 - ' + moment().add(-1, 'months').format('MMM YYYY');

		$('#chartSLDP').highcharts({
			chart: { type: 'column' },
			title: { text: '% PF + Mix Cases received SLDP, ' + duration },
			colors: ['#2b908f', '#e74c3c'],
			xAxis: { categories: categories, crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'Total PF / Mix' } }, { title: { text: 'SLDP Rate' }, labels: { format: '{value}%' }, opposite: true }],
			tooltip: {
				shared: true, enabled: !self.isGuest,
				formatter: function () {
					var p = this.points[0];
					var text = `<span style="color:${p.color}">●</span> ${p.series.name}: <b>${p.y}</b><br/>`;

					p = this.points[1];
					text += `<span style="color:${p.color}">●</span> ${p.series.name}: <b>${p.y}% (${p.point.SLDP} Cases)</b><br/>`;

					return text;
				}
			},
			plotOptions: { column: { stacking: 'normal' } },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'PF + Mix', data: data.map(r => r.PfMix) },
				{ name: 'SLDP Rate', type: 'spline', data: data.map(r => { return { y: r.Percent, SLDP: r.SLDP } }), yAxis: 1 }
			]
		});
	}

	self.drawChartIntenFacility = function () {
		var model = self.mainData.chartIntensification;

		var monthYear = model.map(r => r.MonthYear).distinct();
		var filtered = ipHFs.filter(r => r.checked()).map(r => r.hfcode);
		model = model.filter(r => filtered.contain(r.Code_Facility_T));

		var species = $('.chartIntenFacilityCbox:checked').toArray().map(r => r.value);
		var types = ['HF_', 'VMW_', 'MMWIP_', 'MMW_'];

		model = monthYear.map(my => {
			var founds = model.filter(r => r.MonthYear == my);
			var obj = {
				Positive: founds.sum(r => types.sum(t => species.sum(s => r[t + s]))),
				Test: founds.sum(r => r.Test),
				HF: founds.sum(r => species.sum(s => r['HF_' + s])),
				VMW: founds.sum(r => species.sum(s => r['VMW_' + s])),
				MMWIP: founds.sum(r => species.sum(s => r['MMWIP_' + s])),
				MMW: founds.sum(r => species.sum(s => r['MMW_' + s]))
			};
			return obj;
		});

		var categories = monthYear.map(r => r.substr(-4)).distinct().map(y => {
			return {
				name: y,
				categories: monthYear.filter(r => r.substr(-4) == y).map(r => parseInt(r.substr(0, 2)))
			}
		});
		var duration = 'Jan 2018 - ' + moment(monthYear.last(), 'MM/YYYY').format('MMM YYYY');

		$('#chartIntenFacility').highcharts({
			chart: { type: 'column' },
			title: { text: 'Malaria Cases by Health Facilities and VMWs, ' + duration },
			subtitle: { text: '.' },
			xAxis: { categories: categories, crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'Number of Cases' }, reversedStacks: false }, { title: { text: 'Number of Test' }, opposite: true }],
			tooltip: {
				shared: true, enabled: !self.isGuest,
				formatter: function () {
					var text = '';
					var founds = self.mainData.placeCount.filter(r => filtered.contain(r.Code_Facility_T));
					for (var i = 0; i < this.points.length; i++) {
						var p = this.points[i];
						var id = p.series.userOptions.id;

						var count = p.series.name == 'HF' ? '/ ' + filtered.length
							: id.in('VMW', 'MMW', 'MMWIP') ? '/ ' + founds.sum(r => r[id])
								: '';

						text += `<span style="color:${p.color}">●</span> ${p.series.name}: <b>${p.y} ${count}</b><br/>`;

						if (i == this.points.length - 1) {
							text += `<span style="color:yellow">●</span> Positive: <b>${p.point.positive}</b><br/>`;
						}
					}
					return text;
				}
			},
			plotOptions: { column: { stacking: 'normal' } },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ id: 'HF', name: 'HF', type: 'column', data: model.map(r => r.HF) },
				{ id: 'VMW', name: 'VMW', type: 'column', data: model.map(r => r.VMW) },
				{ id: 'MMW', name: 'MMW', type: 'column', data: model.map(r => r.MMW) },
				{ id: 'MMWIP', name: 'MMW IP', type: 'column', data: model.map(r => r.MMWIP) },
				{ id: 'Test', name: 'Total Test', type: 'spline', data: model.map(r => { return { y: r.Test, positive: r.Positive } }), yAxis: 1 }
			]
		});
	};

	self.drawTableIP = function (root, event) {
		if (event && event.currentTarget.tagName == 'SELECT') {
			self.drawTableIP.month = event.currentTarget.value;
			if (!firstDrawDone) return;
		}

		var duration = is(self.drawTableIP.month, '', 'Dec 2019 - ' + moment().add(-1, 'months').format('MMM YYYY'));
		$('#tableIPCaseTitle').text('Table of Summary Data By HFs in IP2, ' + duration);

		var data = self.mainData.chartIntensification.filter(r => r.IP == 2);
		var list = [];

		data.map(r => r.CSO).distinct().sortasc(r => r.toLowerCase()).forEach(cso => {
			var csoFounds = data.filter(r => r.CSO == cso);
			var hfs = csoFounds.sortasc(r => r.Name_Facility_E).map(r => r.Code_Facility_T).distinct();
			hfs.forEach(code => {
				var founds = data.filter(r => r.Code_Facility_T == code);
				addToList(founds, 1);
			});
			if (hfs.length > 1) addToList(csoFounds, 2);
		});
		addToList(data, 3);

		function addToList(founds, type) {
			var firstRow = founds[0];
			var forestPack = type == 1 ? firstRow.ForestPack || 0
				: type == 2 ? list.filter(r => r.CSO == firstRow.CSO).sum(r => r.ForestPack)
				: list.filter(r => r.HFName == 'Total').sum(r => r.ForestPack);

			if (self.drawTableIP.month != '') {
				var month = moment(self.drawTableIP.month, 'MMM YYYY').format('MM/YYYY');
				founds = founds.filter(r => r.MonthYear == month);
			}

			list.push({
				CSO: type < 3 ? firstRow.CSO : '',
				HFName: type == 1 ? firstRow.Name_Facility_E : type == 2 ? 'Total' : 'Grand Total',

				HF: founds.sum(r => r.HF),
				MMWIP: founds.sum(r => r.MMWIP),
				MMW: founds.sum(r => r.MMW),
				VMW: founds.sum(r => r.VMW),
				Positive: founds.sum(r => r.Positive),
				OutreachTest: founds.sum(r => r.OutreachTest),
				OutreachPositive: founds.sum(r => r.OutreachPositive),
				PrimaquineACT: founds.sum(r => r.PrimaquineACT),
				ForestPack: forestPack
			});
		}

		var cso = '';
		list.forEach(r => {
			if (r.CSO != cso) {
				cso = r.CSO;
				r.RowSpan = list.filter(x => x.CSO == cso).length;
			} else {
				r.RowSpan = 0;
			}
		});
		self.tableIPCase(list);
	};

	self.drawTableOutReach = function (root, event) {
		if (event && event.currentTarget.tagName == 'SELECT') {
			self.drawTableOutReach.month = event.currentTarget.value;
			if (!firstDrawDone) return;
		}

		var duration = is(self.drawTableOutReach.month, '', 'Dec 2019 - ' + moment().add(-1, 'months').format('MMM YYYY'));
		$('#tableIPOutReachTitle').text('Table of Out Reach Data By HFs in IP2, ' + duration);

		var data = self.mainData.tableOutreach;
		var list = [];

		data.map(r => r.CSO).distinct().forEach(cso => {
			var csoFounds = data.filter(r => r.CSO == cso);
			var hfs = csoFounds.map(r => r.Code_Facility_T).distinct();
			hfs.forEach(code => {
				var founds = data.filter(r => r.Code_Facility_T == code);
				addToList(founds, 1);
			});
			if (hfs.length > 1) addToList(csoFounds, 2);
		});
		addToList(data, 3);

		function addToList(founds, type) {
			var firstRow = founds[0];

			if (self.drawTableOutReach.month != '') {
				var month = moment(self.drawTableOutReach.month, 'MMM YYYY').format('MM/YYYY');
				founds = founds.filter(r => r.MonthYear == month);
			}

			list.push({
				CSO: type < 3 ? firstRow.CSO : '',
				HF: type == 1 ? firstRow.Name_Facility_E : type == 2 ? 'Total' : 'Grand Total',

				TestPassive: founds.sum(r => r.TestPassive),
				TestOutReach: founds.sum(r => r.TestOutReach),
				TestTotal: founds.sum(r => r.TestPassive + r.TestOutReach),

				PfPassive: founds.sum(r => r.PfPassive),
				PfOutReach: founds.sum(r => r.PfOutReach),
				PfTotal: founds.sum(r => r.PfPassive + r.PfOutReach),

				PvPassive: founds.sum(r => r.PvPassive),
				PvOutReach: founds.sum(r => r.PvOutReach),
				PvTotal: founds.sum(r => r.PvPassive + r.PvOutReach),

				MixPassive: founds.sum(r => r.MixPassive),
				MixOutReach: founds.sum(r => r.MixOutReach),
				MixTotal: founds.sum(r => r.MixPassive + r.MixOutReach),

				PositivePassive: founds.sum(r => r.PositivePassive),
				PositiveOutReach: founds.sum(r => r.PositiveOutReach),
				PositiveTotal: founds.sum(r => r.PositivePassive + r.PositiveOutReach),
			});
		}

		var cso = '';
		list.forEach(r => {
			if (r.CSO != cso) {
				cso = r.CSO;
				r.RowSpan = list.filter(x => x.CSO == cso).length;
			} else {
				r.RowSpan = 0;
			}
		});

		self.tableIPOutReach(list);
	};

	function drawTableSLDP() {
		var data = self.mainData.IP2SLDP;
		var list = [];

		data.map(r => r.CSO).distinct().forEach(cso => {
			var csoFounds = data.filter(r => r.CSO == cso);
			var hfs = csoFounds.map(r => r.Code_Facility_T).distinct();
			hfs.forEach(code => {
				var founds = data.filter(r => r.Code_Facility_T == code);
				addToList(founds, 1);
			});
			if (hfs.length > 1) addToList(csoFounds, 2);
		});
		addToList(data, 3);

		function addToList(founds, type) {
			var firstRow = founds[0];

			var obj = {
				CSO: type < 3 ? firstRow.CSO : '',
				HF: type == 1 ? firstRow.Name_Facility_E : type == 2 ? 'Total' : 'Grand Total',
				Values: []
			};

			self.ipFilterDateList.forEach(m => {
				var month = moment(m, 'MMM YYYY').format('YYYY-MM');
				var arr = founds.filter(r => r.YearMonth == month);
				obj.Values.push({
					pfmix: arr.sum(r => r.PfMix),
					sldp: arr.sum(r => r.SLDP),
					percent: arr.length == 0 ? '' : Math.round(arr.sum(r => r.SLDP) / arr.sum(r => r.PfMix) * 100)
				});

			});

			list.push(obj);
		}

		var cso = '';
		list.forEach(r => {
			if (r.CSO != cso) {
				cso = r.CSO;
				r.RowSpan = list.filter(x => x.CSO == cso).length;
			} else {
				r.RowSpan = 0;
			}
		});

		self.tableIPSLDP(list);
	}

	self.drawIntenMap = function (root, event) {
		if (event && event.currentTarget.tagName == 'SELECT') {
			this.month = event.currentTarget.value;
			if (!firstDrawDone) return;
		}

		var model = self.mainData.chartIntensification;
		var filtered = ipHFs.filter(r => r.checked()).map(r => r.hfcode);
		model = model.filter(r => filtered.contain(r.Code_Facility_T) && r.IP == self.ip());

		var yearmonth = 'all';
		if (this.month != '') {
			var month = moment(this.month, 'MMM YYYY').format('MM/YYYY');
			model = model.filter(r => r.MonthYear == month);
			yearmonth = moment(this.month, 'MMM YYYY').format('YYYYMM');
		}

		var species = [];
		$('.chartIntenMapCbox:checked').each(function () {
			species.push($(this).attr('specie'));
		});

		var hfs = model.map(r => {
			return {
				code: r.Code_Facility_T,
				lat: r.Lat,
				long: r.Long
			}
		}).distinct(r => r.code);

		var dataPositive = hfs.map(hf => {
			var founds = model.filter(r => r.Code_Facility_T == hf.code);
			var p = 0;
			if (species.contain('F')) p += founds.sum(r => r.Pf);
			if (species.contain('V')) p += founds.sum(r => r.Pv);
			if (species.contain('M')) p += founds.sum(r => r.Mix);

			return {
				hfcode: hf.code,
				name: self.place.hc.find(r => r.code == hf.code).name,
				lat: parseFloat(hf.lat),
				lon: parseFloat(hf.long),
				z: p
			};
		}).filter(r => r.z > 0);

		var dataTest = hfs.map(hf => {
			return {
				hfcode: hf.code,
				name: self.place.hc.find(r => r.code == hf.code).name,
				lat: parseFloat(hf.lat),
				lon: parseFloat(hf.long),
				z: model.filter(r => r.Code_Facility_T == hf.code).sum(r => r.Test)
			};
		}).filter(r => r.z > 0);

		var duration = self.ip() == 1 ? 'Jan 2018 - Nov 2019' : is(this.month, '', 'Dec 2019 - ' + moment().add(-1, 'months').format('MMM YYYY'));

		var color = '#008000';
		if (species.length == 1) {
			if (species[0] == 'F') color = '#ff0000';
			if (species[0] == 'V') color = '#ff8c00';
			if (species[0] == 'M') color = '#0000ff';
		}

		var ods = filtered.map(code => self.place.hc.find(r => r.code == code).odcode).distinct();
		ods = ods.map(code =>[code, self.place.od.find(r => r.code == code).name]);

		var maxPositve = dataPositive.length == 0 ? 0 : Math.max(...dataPositive.map(r => r.z));
		var positive1 = maxPositve < 30 ? 10 : Math.floor(maxPositve / 30) * 10;
		var positive2 = positive1 * 2;

		var maxTest = dataTest.length == 0 ? 0 : Math.max(...dataTest.map(r => r.z));
		var test1 = maxTest < 30 ? 10 : Math.floor(maxTest / 30) * 10;
		var test2 = test1 * 2;

		$('#chartIntenMap').highcharts('Map', {
			chart:{ height: 750},
			title: { text: 'Malaria Cases by HF in Intensification Plan Areas, ' + duration },
			legend: { enabled: false },
			tooltip: {
				enabled: !self.isGuest,
				formatter: function () {
					var p = this.point;
					var pc = dataPositive.find(r => r.hfcode == p.hfcode);
					pc = pc == null ? 0 : pc.z;
					return `<b>HC: ${p.name}</b><br/>`
						+ `<span>●</span> Total Tests: <b>${p.z}</b><br/>`
						+ `<span style="color:${color}">●</span> Positive Cases: <b>${pc}</b><br/>`;
				}
			},
			plotOptions: {
				series: {
					states: { inactive: { opacity: 1 } },
					events: {
						click: function (e) {
							open(`/Dashboard/ipMapPopup/${e.point.hfcode}/${yearmonth}`);
						}
					}
				}
			},
			exporting: { sourceWidth: 1100, sourceHeight: 600 },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			plotOptions: {
				series: {
					borderColor: '#ccc'
				}
			},
			series: [{
				mapData: Highcharts.maps['chartODBorder'],
				data: ods,
				dataLabels: { enabled: true, style: { textOutline: '' } },
				enableMouseTracking: false
			}, {
				name: 'Positive Cases',
				type: 'mapbubble',
				data: dataPositive.filter(r => r.z < positive1),
				color: color,
				enableMouseTracking: false,
				minSize: 6,
				maxSize: 6
			}, {
				name: 'Positive Cases',
				type: 'mapbubble',
				data: dataPositive.filter(r => r.z >= positive1 && r.z <= positive2),
				color: color,
				enableMouseTracking: false,
				minSize: 12,
				maxSize: 12
			}, {
				name: 'Positive Cases',
				type: 'mapbubble',
				data: dataPositive.filter(r => r.z > positive2),
				color: color,
				enableMouseTracking: false,
				minSize: 18,
				maxSize: 18
			}, {
				name: 'Total Tests',
				type: 'mapbubble',
				data: dataTest.filter(r => r.z < test1),
				color: '#000',
				marker: { fillOpacity: 0, lineColor: '#000000b3' },
				minSize: 25,
				maxSize: 25
			}, {
				name: 'Total Tests',
				type: 'mapbubble',
				data: dataTest.filter(r => r.z >= test1 && r.z <= test2),
				color: '#000',
				marker: { fillOpacity: 0, lineColor: '#000000b3' },
				minSize: 30,
				maxSize: 30
			}, {
				name: 'Total Tests',
				type: 'mapbubble',
				data: dataTest.filter(r => r.z > test2),
				color: '#000',
				marker: { fillOpacity: 0, lineColor: '#000000b3' },
				minSize: 35,
				maxSize: 35
			}]
		}, function () {
			var x = this.chartWidth - 170;
			var y = this.chartHeight - 285;
			var xCircle = x + 12;
			var xText = x + 37;
			var bold = { 'font-weight': 'bold' };
			var circleColor = { 'fill': color + '80', 'stroke': color, 'stroke-width': 1 };
			var circleBlack = { 'fill': '#ffffff', 'stroke': '#000000b3', 'stroke-width': 1 };

			this.renderer.text('Number of Malaria Cases', x, y).attr(bold).add();

			y += 12;
			this.renderer.circle(xCircle, y, 4).attr(circleColor).add();
			this.renderer.text(`< ${positive1}`, xText, y + 4).add();

			y += 17;
			this.renderer.circle(xCircle, y, 6).attr(circleColor).add();
			this.renderer.text(`${positive1} - ${positive2}`, xText, y + 5).add();

			y += 20;
			this.renderer.circle(xCircle, y, 9).attr(circleColor).add();
			this.renderer.text(`> ${positive2}`, xText, y + 5).add();

			y += 30;
			this.renderer.text('Number of Malaria Tests', x, y).attr(bold).add();

			y += 17;
			this.renderer.circle(xCircle, y, 12.5).attr(circleBlack).add();
			this.renderer.text(`< ${test1}`, xText, y + 5).add();

			y += 31;
			this.renderer.circle(xCircle, y, 15).attr(circleBlack).add();
			this.renderer.text(`${test1} - ${test2}`, xText, y + 5).add();

			y += 36;
			this.renderer.circle(xCircle, y, 17.5).attr(circleBlack).add();
			this.renderer.text(`> ${test2}`, xText, y + 5).add();

			y += 25;
			this.renderer.rect(x, y, 25, 15).attr({ fill: '#ff0000' }).add();
			this.renderer.text('PF', xText, y + 12).add();

			y += 18;
			this.renderer.rect(x, y, 25, 15).attr({ fill: '#ff8c00' }).add();
			this.renderer.text('PV', xText, y + 12).add();

			y += 18;
			this.renderer.rect(x, y, 25, 15).attr({ fill: '#0000ff' }).add();
			this.renderer.text('Mix', xText, y + 12).add();

			y += 18;
			this.renderer.rect(x, y, 25, 15).attr({ fill: '#008000' }).add();
			this.renderer.text('Merged Species', xText, y + 12).add();

			y += 18;
			this.renderer.rect(x, y, 25, 15).attr({ fill: '#96c4f0' }).add();
			this.renderer.text('Intensification Plan OD', xText, y + 12).add();
		});

		return true;
	};

	self.drawIP2Map = function (root, event) {
		if (event && event.currentTarget.tagName == 'SELECT') {
			this.month = event.currentTarget.value;
			if (!firstDrawDone) return;
		}

		var duration = is(this.month, '', 'Dec 2019 - ' + moment().add(-1, 'months').format('MMM YYYY'));
		$('#IP2MapTitle').text('Out Reach Test and Positive of MMW-IP2, ' + duration);

		if (map == null) {
			var returnObj = {};

			map = app.createGoogleMap('IP2Map', {
				zoom: 7.8,
			}, returnObj);

			returnObj.polygon.setMap(null);

			var CSOs = [
				{ name: 'Care', color: 'orange' },
				{ name: 'CRS', color: 'red' },
				{ name: 'PSI', color: 'blue' },
				{ name: 'URC', color: 'green' }
			];

			CSOs.forEach(cso => {
				cso.ods = ipHFs.filter(r => r.cso == cso.name).map(r => r.odcode).distinct();

				var polygonBorders = [];
				googleODBorder.filter(r => cso.ods.contain(r.code)).forEach(od => {
					od.coor.forEach(a => {
						a.forEach(b => {
							var polygon = [];
							b.forEach(r => polygon.push({ lat: r[0], lng: r[1] }));
							polygonBorders.push(polygon);
						});
					});
				});

				new google.maps.Polygon({
					paths: polygonBorders,
					strokeColor: '#2980b9',
					strokeWeight: 1,
					fillColor: cso.color,
					map: map
				});
			});

			var icons = {
				icon1: {
					name: 'PF + Mix',
					icon: 'place',
					color: 'red'
				},
				icon2: {
					name: 'PV',
					icon: 'place',
					color: 'darkorange'
				},
				icon3: {
					name: 'Negative',
					icon: 'place',
					color: 'blue'
				}
			};

			var legend = document.createElement('div');
			legend.style = 'padding:10px; margin:10px 10px 0 0; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';
			for (var key in icons) {
				var type = icons[key];
				var name = type.name;
				var icon = type.icon;
				var color = type.color;
				var div = document.createElement('div');
				div.innerHTML = '<i class="material-icons" style="padding-right: 5px; vertical-align: middle; color:' + color + ' "> ' + icon + '</i>' + name;
				legend.appendChild(div);
			}

			var div = document.createElement('div');
			div.style = 'display:table; margin-left:5px';
			div.innerHTML = '<div class="inlineblock" style="width:15px; height:15px; border:1px solid #000000b3; border-radius:50%"></div>'
				+ '<span style="display:table-cell; vertical-align:middle; padding-left:9px">MMW IP2</span>';
			legend.appendChild(div);

			var div = document.createElement('div');
			div.style = 'display:table';
			div.innerHTML = '<div class="inlineblock" style="width:30px; height:20px; background:#ffe4b2; border:1px solid green;"></div>'
				+ '<span style="display:table-cell; vertical-align:middle; padding-left:5px">Care</span>';
			legend.appendChild(div);

			var div = document.createElement('div');
			div.style = 'display:table';
			div.innerHTML = '<div class="inlineblock" style="width:30px; height:20px; background:#ffb2b2; border:1px solid green;"></div>'
				+ '<span style="display:table-cell; vertical-align:middle; padding-left:5px">CRS</span>';
			legend.appendChild(div);

			var div = document.createElement('div');
			div.style = 'display:table';
			div.innerHTML = '<div class="inlineblock" style="width:30px; height:20px; background:#b2b2ff; border:1px solid green;"></div>'
				+ '<span style="display:table-cell; vertical-align:middle; padding-left:5px">PSI</span>';
			legend.appendChild(div);

			var div = document.createElement('div');
			div.style = 'display:table';
			div.innerHTML = '<div class="inlineblock" style="width:30px; height:20px; background:#b2d9b2; border:1px solid green;"></div>'
				+ '<span style="display:table-cell; vertical-align:middle; padding-left:5px">URC</span>';
			legend.appendChild(div);

			map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);
		}

		var filtered = ipHFs.filter(r => r.checked()).map(r => r.hfcode);
		var model = founds = self.mainData.IP2Map.filter(r => filtered.contain(r.Code_Facility_T));

		if (this.month != '') {
			var month = moment(this.month, 'MMM YYYY').format('MM/YYYY');
			founds = founds.filter(r => r.MonthYear == month);
		}

		ipMarkers.forEach(r => r.setMap(null));
		ipMarkers = [];
		model.distinct(r => r.Code_Vill_T).forEach(v => {
			var marker = new google.maps.Marker({
				position: { lat: parseFloat(v.Lat), lng: parseFloat(v.Long) },
				icon: {
					path: google.maps.SymbolPath.CIRCLE,
					strokeColor: '#000000b3',
					strokeWeight: 1,
					scale: 8,
					anchor: { x: -0.65, y: 0.4 }
				},
				zIndex: 1,
				map: map
			});
			ipMarkers.push(marker);

			var some = founds.filter(r => r.Code_Vill_T == v.Code_Vill_T);

			var test = some.sum(r => r.OutreachTest);
			var pf = some.sum(r => r.OutreachPf);
			var pv = some.sum(r => r.OutreachPv);
			var mix = some.sum(r => r.OutreachMix);

			if (test > 0) {
				var marker = new google.maps.Marker({
					position: { lat: parseFloat(v.Lat), lng: parseFloat(v.Long) },
					icon: selectMarker(pf, pv, mix),
					zIndex: 2,
					map: map
				});
				ipMarkers.push(marker);

				var txt = '<b>OD:</b> ' + v.Name_OD_E;
				txt += '<br><b>HC:</b> ' + v.Name_Facility_E;
				txt += '<br><b>MMW:</b> ' + v.Name_Vill_E;
				txt += '<br><b>CSO:</b> ' + v.CSO;

				txt += '<br><br><b>Outreach Test:</b> ' + test;
				txt += '<br><b>Outreach Pf:</b> ' + pf;
				txt += '<br><b>Outreach Pv:</b> ' + pv;
				txt += '<br><b>Outreach Mix:</b> ' + mix;

				var infowindow = new google.maps.InfoWindow({ content: txt });
				marker.addListener('mouseover', () => infowindow.open(map, marker));
				marker.addListener('mouseout', () => infowindow.close());
			}
		});
	};

	function drawMarker(color) {
		return {
			path: fontawesome.markers.MAP_MARKER,
			scale: 0.3,
			strokeWeight: 0.2,
			strokeColor: 'black',
			strokeOpacity: 1,
			fillColor: color,
			fillOpacity: 1,
		};
	}

	function selectMarker(pf, pv, mix) {
		return pf + mix > 0 ? drawMarker('red')
			: pv > 0 ? drawMarker('orange')
				: drawMarker('blue');
	}

	function selectIcon(value) {
		if (value < 1) {
			return drawIcon('#3498DB');
		} else if (value >= 1 && value <= 5) {
			return drawIcon('#F1C40F');
		} else if (value > 5 && value <= 30) {
			return drawIcon('#E91E63');
		} else if (value > 30) {
			return drawIcon('#EA2027');
		}
	}

	function selectMarkerName(value) {
		if (value < 1) {
			return 'lt1';
		} else if (value >= 1 && value <= 5) {
			return 'f1t5';
		} else if (value > 5 && value <= 30) {
			return 'f5t30';
		} else if (value > 30) {
			return 'gt30';
		}
	}

	function drawIcon(color) {
		return {
			path: "M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0",
			fillColor: color,
			fillOpacity: 1,
			anchor: { x: 0, y: 0 },
			strokeWeight: 0,
			scale: 0.10
		}
	}
});