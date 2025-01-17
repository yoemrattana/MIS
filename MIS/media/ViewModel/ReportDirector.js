function viewModel() {
	var self = this;

	self.yearList = ko.observableArray();
	self.year = ko.observable(moment().add(-1, 'month').year());
	self.dataYear = ko.observable();
	self.dataMonthFrom = ko.observable();
	self.dataMonthTo = ko.observable();
	self.titleMonth = ko.observable();
	self.loaded = ko.observable(false);
	self.monthList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	self.from = ko.observable('Jan');
	self.to = ko.observable(moment().add(-1, 'month').format('MMM'));

	self.table1 = ko.observableArray();
	self.table2 = ko.observableArray();
	self.table3 = ko.observableArray();
	self.table4 = ko.observableArray();
	self.table5 = ko.observableArray();
	self.table6 = ko.observableArray();
	self.reportPfMix = ko.observableArray();

	var mainData = null;

	for (var i = 2018; i <= self.year() ; i++) {
		self.yearList.push(i);
	}

	self.submit = function () {
		var url = '/ReportDirector/getreport/';
		url += self.year();
		url += '/' + (self.monthList.indexOf(self.from()) + 1);
		url += '/' + (self.monthList.indexOf(self.to()) + 1);

		app.ajax(url).done(function (data) {
			self.loaded(true);

			mainData = data;
			self.dataYear(self.year());
			self.dataMonthFrom(self.from());
			self.dataMonthTo(self.to());

			var m = moment(self.from(), 'MMM').format('MMMM') + ' - ';
			m += moment(self.to(), 'MMM').format('MMMM') + ',';
			self.titleMonth(m);

			self.reportPfMix(mainData.reportPfMix);
			prepareReport1();
			prepareReport2();
			var provinces = prepareReport3();
			prepareChart1(provinces);
			prepareChart2(provinces);
			prepareChart3();
			prepareReportWeekly();
			prepareReport5(provinces);
			prepareReportWeeklyLastCurrent();
		});
	};
	self.submit();

	function prepareReport1() {
		var report1 = mainData.report1;

		var lastYear = report1.find(r => r.Year == self.year() - 1);
		var thisYear = report1.find(r => r.Year == self.year());

		var lastYearCase = lastYear.HfCase + lastYear.VmwCase;
		var thisYearCase = thisYear.HfCase + thisYear.VmwCase;

		var list = [];
		var row = [];
		row.push('Public Health Facilities');
		row.push(lastYear.HfCase);
		row.push(percent(lastYear.HfCase / lastYearCase));
		row.push(thisYear.HfCase);
		row.push(percent(thisYear.HfCase / thisYearCase));

		row.push(percent((thisYear.HfCase - lastYear.HfCase) / lastYear.HfCase));

		row.push(lastYear.HfDeath);
		row.push(thisYear.HfDeath);

		row.push((lastYear.HfCase / lastYear.Pop * 1000).toFixed(2));
		row.push((thisYear.HfCase / thisYear.Pop * 1000).toFixed(2));

		var mrLastHf = lastYear.HfDeath / lastYear.Pop * 100000;
		var mrThisHf = thisYear.HfDeath / thisYear.Pop * 100000;
		row.push(mrLastHf.toFixed(2));
		row.push(mrThisHf.toFixed(2));

		row.push(lastYear.Pop);
		row.push(thisYear.Pop);
		list.push(row);

		var totalVmwCase = report1.sum(r => r.VmwCase);
		row = [];
		row.push('VMW');
		row.push(lastYear.VmwCase);
		row.push(percent(lastYear.VmwCase / lastYearCase));
		row.push(thisYear.VmwCase);
		row.push(percent(thisYear.VmwCase / thisYearCase));

		row.push(percent((thisYear.VmwCase - lastYear.VmwCase) / lastYear.VmwCase));

		row.push(lastYear.VmwDeath);
		row.push(thisYear.VmwDeath);

		row.push((lastYear.VmwCase / lastYear.Pop * 1000).toFixed(2));
		row.push((thisYear.VmwCase / thisYear.Pop * 1000).toFixed(2));

		var mrLastVmw = lastYear.VmwDeath / lastYear.Pop * 100000;
		var mrThisVmw = thisYear.VmwDeath / thisYear.Pop * 100000;
		row.push(mrLastVmw.toFixed(2));
		row.push(mrThisVmw.toFixed(2));
		list.push(row);

		row = [];
		row.push('Total');
		row.push(lastYearCase);
		row.push('100%');
		row.push(thisYearCase);
		row.push('100%');

		row.push(percent((thisYearCase - lastYearCase) / lastYearCase));

		row.push(lastYear.HfDeath + lastYear.VmwDeath);
		row.push(thisYear.HfDeath + thisYear.VmwDeath);

		row.push((lastYearCase / lastYear.Pop * 1000).toFixed(2));
		row.push((thisYearCase / thisYear.Pop * 1000).toFixed(2));

		row.push((mrLastHf + mrLastVmw).toFixed(2));
		row.push((mrThisHf + mrThisVmw).toFixed(2));
		list.push(row);

		self.table1(list);

		var rows = document.getElementById('t1').rows;
		for (var i = 1; i < rows.length; i++) {
			rows[i].cells[5].style.backgroundColor = '#eee';
		}
		rows[4].style.fontWeight = 'bold';
		rows[2].cells[12].rowSpan = 3;
		rows[2].cells[13].rowSpan = 3;
	}

	function prepareReport2() {
		var report2 = mainData.report2;

		[self.year() - 1, self.year()].forEach((year, index) => {
			var hf = report2.find(r => r.Year == year && r.Type == 'hf');
			var vmw = report2.find(r => r.Year == year && r.Type == 'vmw');

			var list = [];
			var row = [];
			row.push('Public Health Facilities');

			row.push(hf.Pf);
			row.push(percent(hf.Pf / hf.Total));

			row.push(hf.Pv);
			row.push(percent(hf.Pv / hf.Total));

			row.push(hf.Mix);
			row.push(percent(hf.Mix / hf.Total));

			row.push(hf.Pm);
			row.push(percent(hf.Pm / hf.Total));

			row.push(hf.Po);
			row.push(percent(hf.Po / hf.Total));

			row.push(hf.Pk);
			row.push(percent(hf.Pk / hf.Total));

			row.push(hf.Total);
			list.push(row);

			row = [];
			row.push('VMW');

			row.push(vmw.Pf);
			row.push(percent(vmw.Pf / vmw.Total));

			row.push(vmw.Pv);
			row.push(percent(vmw.Pv / vmw.Total));

			row.push(vmw.Mix);
			row.push(percent(vmw.Mix / vmw.Total));

			row.push(vmw.Pm);
			row.push(percent(vmw.Pm / vmw.Total));

			row.push(vmw.Po);
			row.push(percent(vmw.Po / vmw.Total));

			row.push(vmw.Pk);
			row.push(percent(vmw.Pk / vmw.Total));

			row.push(vmw.Total);
			list.push(row);

			var total = hf.Total + vmw.Total;
			row = [];
			row.push('Total');

			row.push(hf.Pf + vmw.Pf);
			row.push(percent(row.last() / total));

			row.push(hf.Pv + vmw.Pv);
			row.push(percent(row.last() / total));

			row.push(hf.Mix + vmw.Mix);
			row.push(percent(row.last() / total));

			row.push(hf.Pm + vmw.Pm);
			row.push(percent(row.last() / total));

			row.push(hf.Po + vmw.Po);
			row.push(percent(row.last() / total));

			row.push(hf.Pk + vmw.Pk);
			row.push(percent(row.last() / total));

			row.push(total);
			list.push(row);

			self['table' + (index + 2)](list);
		});
	}

	function prepareReport3() {
		var report3 = mainData.report3;
		var tblPop = mainData.pop;

		var provinces = tblPop.map(r => r.Name_Prov_E).distinct().sort();
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		report3 = report3.filter(r => r.Year == self.year());
		report3 = report3.filter(r => parseInt(r.Month) >= mf && parseInt(r.Month) <= mt);

		var list = [];
		provinces.forEach(p => {
			var row = [p];
			var prov = report3.filter(r => r.Name_Prov_E == p);

			for (var m = 1; m <= 12; m++) {
				if (m >= mf && m <= mt) {
					var found = prov.find(r => parseInt(r.Month) == m);
					if (found != null) {
						row.push(found.Cases, found.Death);
					} else {
						row.push(0, 0);
					}
				} else {
					row.push('', '');
				}
			}

			var totalCase = prov.sum(r => r.Cases);
			var totalDeath = prov.sum(r => r.Death);
			row.push(totalCase, totalDeath);

			var pop = tblPop.find(r => r.Name_Prov_E == p && r.Year == self.year()).Pop;
			row.push(pop);

			if (pop == 0) {
				row.push(0, 0);
			} else {
				row.push((totalCase / pop * 1000).toFixed(3));
				row.push((totalDeath / pop * 100000).toFixed(3));
			}

			list.push(row);
		});

		var row = ['Grand Total'];
		for (var m = 1; m <= 12; m++) {
			if (m >= mf && m <= mt) {
				var founds = report3.filter(r => parseInt(r.Month) == m);
				row.push(founds.sum(r => r.Cases));
				row.push(founds.sum(r => r.Death));
			} else {
				row.push('', '');
			}
		}

		var totalCase = report3.sum(r => r.Cases);
		var totalDeath = report3.sum(r => r.Death);
		row.push(totalCase, totalDeath);

		var pop = tblPop.filter(r => r.Year == self.year()).sum(r => r.Pop);
		row.push(pop);

		if (pop == 0) {
			row.push(0, 0);
		} else {
			row.push((totalCase / pop * 1000).toFixed(3));
			row.push((totalDeath / pop * 100000).toFixed(3));
		}

		list.push(row);
		self.table4(list);

		return provinces;
	}

	function prepareChart1(provinces) {
		var report3 = mainData.report3;
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;
		var seriesData = [];

		report3 = report3.filter(r => parseInt(r.Month) >= mf && parseInt(r.Month) <= mt);
		var i = 0;
		[self.year() - 1, self.year()].forEach(year => {
			var row = { id: 'year-' + i, name: year, data: [] };
			provinces.forEach(p => {
				var founds = report3.filter(r => r.Year == year && r.Name_Prov_E == p);
				var cases = founds.sum(r => r.Cases);
				row.data.push(cases);
			});
			seriesData.push(row);
			i++;
		});

		var title = 'Number of malaria cases by province, (Public Health Facilities & VMWs), ';
		title += self.from() + '-' + self.to() + ', ';
		title += (self.year() - 1) + ' and ' + self.year();

		var lastYear = seriesData[0].data.sum();
		var thisYear = seriesData[1].data.sum();
		var subtitle = String.format('<br><br><b>{0}:</b> {1} cases, <b>{2}:</b> {3} cases', (self.year() - 1), lastYear, self.year(), thisYear);

		$('#chart1').highcharts({
			chart: { type: 'column', zoomType: 'xy' },
			title: { text: title },
			subtitle: { text: subtitle, useHTML: true },
			xAxis: { categories: provinces, labels: { rotation: -45 }, crosshair: true },
			yAxis: { title: { text: 'Number of cases' } },
			tooltip: {
				headerFormat: '<b>{point.x}</b><table>',
				pointFormat: '<tr><td style="color:{series.color}"><b>{series.name}:</b></td>'
					+ '<td style="padding-left:5px"><b>{point.y}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			exporting: { sourceWidth: 1000, sourceHeight: 500, filename: 'Chart1' },
			series: seriesData
		}, function (chart) {
			chart.series.forEach(function (v, k) {
				$('span#c-1-lg-' + k).text(v.name);
			});
			tickChbox('.c1Cbox', chart);
		});
	}

	function prepareChart2(provinces) {
		var report3 = mainData.report3;
		var tblPop = mainData.pop;
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;
		var seriesData = [];

		report3 = report3.filter(r => parseInt(r.Month) >= mf && parseInt(r.Month) <= mt);
		var i = 0;
		[self.year() - 1, self.year()].forEach(year => {
			var row = { id: 'inc-' + i, name: 'Inc ' + year, type: 'column', data: [] };
			provinces.forEach(p => {
				var founds = report3.filter(r => r.Year == year && r.Name_Prov_E == p);
				var cases = founds.sum(r => r.Cases);

				var pop = tblPop.find(r => r.Year == year && r.Name_Prov_E == p).Pop;

				var inc = 0
				if (pop > 0) inc = cases / pop * 1000;
				inc = parseFloat(inc.toFixed(1));
				row.data.push(inc);
			});
			seriesData.push(row);
			i++;
		});

		var year = self.year();
		var row = {
			id: 'mr',
			name: 'MR ' + year,
			type: 'spline',
			yAxis: 1,
			color: '#f00',
			dashStyle: 'shortdot',
			marker: { enabled: false },
			data: []
		};
		provinces.forEach(p => {
			var founds = report3.filter(r => r.Year == year && r.Name_Prov_E == p);
			var death = founds.sum(r => r.Death);

			var pop = tblPop.find(r => r.Year == year && r.Name_Prov_E == p).Pop;

			var mr = 0
			if (pop > 0) mr = death / pop * 100000;
			mr = parseFloat(mr.toFixed(1));
			row.data.push(mr);
		});
		seriesData.push(row);

		var title = 'Comparison of Malaria Incidence Rate (IR) by province, ';
		title += self.from() + '-' + self.to() + ', ';
		title += (self.year() - 1) + ' and ' + self.year();

		$('#chart2').highcharts({
			chart: { zoomType: 'xy' },
			title: { text: title },
			subtitle: { text: '.' },
			xAxis: { categories: provinces, labels: { rotation: -45 }, crosshair: true },
			yAxis: [{ title: { text: 'Incidence rate/1000' } }, { title: { text: 'Mortality rate/100,000' }, opposite: true }],
			tooltip: {
				headerFormat: '<b>{point.x}</b><table>',
				pointFormat: '<tr><td style="color:{series.color}"><b>{series.name}:</b></td>'
					+ '<td style="padding-left:5px"><b>{point.y}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			exporting: { sourceWidth: 1000, sourceHeight: 500, filename: 'Chart2' },
			series: seriesData
		}, function (chart) {
			chart.series.forEach(function (v, k) {
				$('span#c-2-lg-' + k).text(v.name);
			});
			tickChbox('.c2Cbox', chart);
		});
	}

	function prepareChart3() {
		var report3 = mainData.report3;
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;
		var seriesData = [];
		var i = 0;
		[self.year() - 1, self.year()].forEach(year => {
			var row = { id: 'cum-' + i, name: 'Cum ' + year, data: [] };
			var cum = 0;
			for (var m = 1; m <= 12; m++) {
				if (year == self.year() && (m < mf || m > mt)) continue;

				var founds = report3.filter(r => r.Year == year && parseInt(r.Month) == m);
				var cases = founds.sum(r => r.Cases);
				cum += cases;
				row.data.push([self.monthList[m - 1], cum]);
			}
			seriesData.push(row);
			i++;
		});

		var title = 'Number of Monthly Cumulative Malaria Cases, (Public Health Facilities & VMWs), ';
		title += self.from() + '-' + self.to() + ', ';
		title += (self.year() - 1) + ' and ' + self.year();

		$('#chart3').highcharts({
			chart: { type: 'line', zoomType: 'xy' },
			title: { text: title },
			subtitle: { text: '.' },
			xAxis: { type: 'category', categories: self.monthList, crosshair: true },
			yAxis: { title: { text: 'Nummber of acumulative cases' } },
			tooltip: {
				headerFormat: '<b>{point.x}</b><table>',
				pointFormat: '<tr><td style="color:{series.color}"><b>{series.name}:</b></td>'
					+ '<td style="padding-left:5px"><b>{point.y}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			exporting: { sourceWidth: 1000, sourceHeight: 500, filename: 'Chart3' },
			series: seriesData
		}, function (chart) {
			chart.series.forEach(function (v, k) {
				$('span#c-3-lg-' + k).text(v.name);
			});
			tickChbox('.c3Cbox', chart);
		});
	}

	function prepareReportWeekly() {
		var model = mainData.reportWeekly;

		function getInfo(p) {
			if (p == null) return p;

			return p.split(',').map(r => {
				var arr = r.split('/');
				return 'HC: ' + arr[0] + '<br>P: ' + arr[1];
			}).join('<br>------<br>');
		}

		var duration = self.from() + '-' + self.to() + ' ' + self.year();

		var found = mainData.report1.find(r => r.Year == self.year());
		var positive = found.HfCase + found.VmwCase;
		var pfmix = model.sum('PfMix');
		var subtitle = `<b>All Positive:</b> ${positive} cases, <b>PF + Mix:</b> ${pfmix} cases`;

		$('#chartWeekly').highcharts({
			chart: { type: 'column', height: 600 },
			title: { text: 'Malaria cases by week, ' + duration },
			subtitle: { text: subtitle },
			xAxis: { categories: model.map(r => r.Week), crosshair: true, gridLineWidth: 1, labels: { rotation: 90 } },
			yAxis: [{ title: { text: 'Number of All Positive Cases' } }, { title: { text: 'Number of PF + Mix Cases' }, opposite: true, allowDecimals: false }],
			tooltip: { shared: true },
			exporting: { sourceWidth: $('#chartWeekly').width(), sourceHeight: 600 },
			annotations: model.map((r, x) => {
				return {
					labelOptions: {
						allowOverlap: true,
						backgroundColor: '#ddddddbf',
						borderColor: 'gray',
						style: { color: 'black' }
					},
					labels: [{
						text: getInfo(r.Place),
						point: {
							xAxis: 0,
							yAxis: 1,
							x: x + 0.25,
							y: r.PfMix
						},
						align: 'left',
						x: 10, y: -50
					}]
				}
			}).filter(r => r.labels[0].point.y > 0),
			series: [
				{ name: 'All Positive Cases', data: model.map(r => r.Positive) },
				{ name: 'PF + Mix Cases', data: model.map(r => r.PfMix), yAxis: 1, dataLabels: { enabled: true, color: 'red' } }
			]
		});
	}

	function prepareReportWeeklyLastCurrent() {
		var model = mainData.weeklyCurrentLastY;

		var lastYear = model.sum('PfMixLastYear');
		var thisYear = model.sum('PfMixCurrentYear');
		var subtitle = String.format('<b>{0}:</b> {1} cases, <b>{2}:</b> {3} cases', (self.year() - 1), lastYear, self.year(), thisYear);

		$('#chartWeeklyCurrentLastY').highcharts({
			chart: { type: 'spline' },
			colors: ["#e67e22", "#e74c3c", "#3498db"],
			title: { text: 'PF + Mix Weekly ' + (self.year() - 1) + ' and ' + self.year() },
			subtitle: { text: subtitle },
			xAxis: { categories: model.map(r => r.Week), crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: (self.year() - 1) } }, { title: { text: self.year() }, opposite: true, allowDecimals: false }],
			tooltip: { shared: true },
			exporting: { sourceWidth: 1500, sourceHeight: 500 },
			series: [
                { id: 'last', name: (self.year() - 1), data: model.map(r => r.PfMixLastYear) },
                { id: 'current', name: self.year(), data: model.map(r => r.PfMixCurrentYear), yAxis: 1 }
			]
		});
	}

	function prepareReport5(provinces) {
		var report5 = mainData.report5;

		var hc = report5.filter(r => r.Type == 'HC');
		var vmw = report5.filter(r => r.Type == 'VMW');
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		var list = [];
		provinces.forEach(p => {
			var row = [p];
			var provs = hc.filter(r => r.Name_Prov_E == p);

			[self.year() - 1, self.year()].forEach(y => {
				var years = provs.filter(r => parseInt(r.Year) == y);

				var reports = 0;
				var totals = 0;
				for (var m = 1; m <= 12; m++) {
					if (m >= mf && m <= mt) {
						var found = years.find(r => parseInt(r.Month) == m);
						var report = found == null ? 0 : found.Report;
						var total = found == null ? 0 : found.Total;

						row.push(percentF(total == 0 ? 0 : report / total));
						reports += report
						totals += total;
					} else {
						row.push('');
					}
				}
				row.push(percentF(totals == 0 ? 0 : reports / totals));
			});
			list.push(row);
		});

		var row = ['Grand Total'];
		[self.year() - 1, self.year()].forEach(y => {
			var years = hc.filter(r => parseInt(r.Year) == y);

			var reports = 0;
			var totals = 0;
			for (var m = 1; m <= 12; m++) {
				if (m >= mf && m <= mt) {
					var founds = years.filter(r => parseInt(r.Month) == m);
					var report = founds.sum(r => r.Report);
					var total = founds.sum(r => r.Total);

					row.push(percentF(total == 0 ? 0 : report / total));
					reports += report
					totals += total;
				} else {
					row.push('');
				}
			}
			row.push(percentF(totals == 0 ? 0 : reports / totals));
		});
		list.push(row);
		self.table5(list);

		var list = [];
		provinces.forEach(p => {
			var row = [p];
			var provs = vmw.filter(r => r.Name_Prov_E == p);

			[self.year() - 1, self.year()].forEach(y => {
				var years = provs.filter(r => parseInt(r.Year) == y);

				var reports = 0;
				var totals = 0;
				for (var m = 1; m <= 12; m++) {
					if (m >= mf && m <= mt) {
						var found = years.find(r => parseInt(r.Month) == m);
						var report = found == null ? 0 : found.Report;
						var total = found == null ? 0 : found.Total;

						row.push(percentF(total == 0 ? 0 : report / total));
						reports += report
						totals += total;
					} else {
						row.push('');
					}
				}
				row.push(percentF(totals == 0 ? 0 : reports / totals));
			});
			list.push(row);
		});

		var row = ['Grand Total'];
		[self.year() - 1, self.year()].forEach(y => {
			var years = vmw.filter(r => parseInt(r.Year) == y);

			var reports = 0;
			var totals = 0;
			for (var m = 1; m <= 12; m++) {
				if (m >= mf && m <= mt) {
					var founds = years.filter(r => parseInt(r.Month) == m);
					var report = founds.sum(r => r.Report);
					var total = founds.sum(r => r.Total);

					row.push(percentF(total == 0 ? 0 : report / total));
					reports += report
					totals += total;
				} else {
					row.push('');
				}
			}
			row.push(percentF(totals == 0 ? 0 : reports / totals));
		});
		list.push(row);
		self.table6(list);
	}

	function percent(value) {
		return (value * 100).toFixed(0) + '%';
	}

	function percentF(value) {
		return Math.floor(value * 100) + '%';
	}

	self.exportExcel = function () {
		getChartImageUrl($('#chartWeekly').highcharts(), function (imageurl) {
			mainData.chartImage = imageurl.substr(imageurl.indexOf(',') + 1);

			var submit = {
				year: self.dataYear(),
				from: self.monthList.indexOf(self.dataMonthFrom()) + 1,
				to: self.monthList.indexOf(self.dataMonthTo()) + 1,
				data: JSON.stringify(mainData)
			};

			app.downloadBlob('/ReportDirector/export', submit).done(function (blob) {
				var filename = 'Report Director ' + self.dataMonthFrom() + '-' + self.dataMonthTo() + ' ' + self.dataYear() + '.xlsx';
				saveAs(blob, filename); //from FileSaver.js
			});
		});
	};

	function getChartImageUrl(chart, onSuccess) {
		var onError = console.log;
		var scale = 1;
		var chartOptions = null;

		chart.getSVGForLocalExport(undefined, chartOptions, onError, function (svg) {
			var svgurl = Highcharts.svgToDataUrl(svg);
			Highcharts.imageToDataUrl(svgurl, 'image/png', null, scale, onSuccess, onError, onError, onError);
		});
	}

	function isEmptyObject(obj) {
		var name;
		for (name in obj) {
			if (obj.hasOwnProperty(name)) {
				return false;
			}
		}
		return true;
	}

	function tickChbox(className, chart) {
		$(className).click(function () {
			if (!isEmptyObject(chart)) {
				var id = $(this).attr('id');
				series = chart.get(id);
				series.setVisible(!series.visible);
			}
		});
	}

	self.visibleMonth = function (month) {
		let mt = moment(self.to(), 'MMM').month();
		if (month <= mt) return true;
		else false;
	}
};

Highcharts.setOptions({
	chart: {
		height: 500,
		style: {
			fontFamily: 'Dosis, sans-serif'
		}
	},
	title: {
		style: {
			fontSize: '16px',
			fontWeight: 'bold',
			textTransform: 'uppercase'
		}
	},
	subtitle: {
		style: {
			fontSize: '14px',
			color: 'black'
		}
	},
	tooltip: {
		borderWidth: 0,
		backgroundColor: 'rgba(219,219,216,0.8)',
		shadow: false
	},
	legend: {
		itemStyle: {
			fontWeight: 'bold',
			fontSize: '13px'
		}
	},
	xAxis: {
		gridLineWidth: 1,
		labels: {
			style: {
				fontSize: '12px'
			}
		}
	},
	yAxis: {
		minorTickInterval: 'auto',
		title: {
			style: {
				textTransform: 'uppercase'
			}
		},
		labels: {
			style: {
				fontSize: '12px'
			}
		}
	},
	plotOptions: {
		candlestick: {
			lineColor: '#404048'
		}
	},

	// General
	background2: '#F0F0EA'
});