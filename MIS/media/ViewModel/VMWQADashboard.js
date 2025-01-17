function subViewModel(self) {
	self.overall = ko.observable();
	self.supervisorList = ko.observableArray();
	self.dashboardReady = ko.observable(false);

	var targetOD = null;

	self.showDashboard = function () {
		if (!self.dashboardReady()) {
			self.pv(null);

			app.getPlace(['od'], function (p) {
				targetOD = p.od.filter(r => r.target == 1);

				app.readFileInZip($('#chartODBorder').val(), 'chartODBorder.js', function (script) {
					eval(script); //run script
					self.getDashboardData();
				});
			});
		}
	};

	self.getDashboardData = function () {
		var submit = {
			pv: self.pv(),
			od: self.od()
		};

		app.ajax('/VMWQA/getDashboard/', submit).done(function (rs) {
			rs.chartNeverAssessed.forEach(r => r.YearMonth = moment(r.YearMonth).format('MMM-YYYY'));

			self.overall(rs.overall);
			drawChartPie(rs.chartPie);
			drawChartQAVisit(rs.chartNeverAssessed);
			drawChartNeverAssessed(rs.chartNeverAssessed);
			drawChartTop5(rs.chartTop5);
			drawChartBoxPlot(rs.chartBoxPlot);
			drawMapQA(rs.mapQA);

			var total = rs.tableSupervisor.sum('Number');
			rs.tableSupervisor.forEach(r => r.Percent = (r.Number / total * 100).toFixed(2));
			rs.tableSupervisor.sortasc(r => {
				return r.WorkPlace == 'CNM' ? 1
					: r.WorkPlace == 'Province' ? 2
					: r.WorkPlace == 'OD' ? 3
					: 4;
			})
			self.supervisorList(rs.tableSupervisor);

			drawChartSupervision();

			self.dashboardReady(true);
		});
	}

	function drawChartPie(data) {
		$('#chartPie').highcharts({
			chart: { type: 'pie' },
			title: { text: 'Percentage of Providers by Score Category' },
			colors: ['#EE9589', '#89BCEE', '#7AB9C2'],
			plotOptions: {
				series: {
					innerSize: '50%',
					dataLabels: {
						distance: '-25%',
						format: '{y}%',
						style: { color: 'white', fontSize: '14px', textOutline: '' }
					},
					showInLegend: true,
					enableMouseTracking: false
				}
			},
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [{
				name: 'Providers (%)',
				data: [
					['Low (0-39)', data.Low],
					['Medium (40-79)', data.Medium],
					['High (80-100)', data.High]
				]
			}]
		});
	}

	function drawChartQAVisit(data) {
		$('#chartQAVisit').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of QA Visits Completed, Targeted and Expected by Month' },
			colors: ['#89BCEE', '#EE9589', '#7AB9C2'],
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: '' } },
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: '# Completed', data: data.map(r =>[r.YearMonth, r.Complete]) },
				{ name: '# Targeted', data: data.map(r =>[r.YearMonth, r.Target]) },
				{ name: '# Expected', data: data.map(r =>[r.YearMonth, r.ExpectOverdue]) }
			]
		});
	}

	function drawChartNeverAssessed(data) {
		$('#chartNeverAssessed').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of Never Assessed, Overdue, This Month and Future Assessments Completed by Month' },
			colors: ['#D46C4E', '#F9AD6A', '#F9E07F', '#43978D'],
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: '' } },
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Never Assessed', data: data.map(r =>[r.YearMonth, r.Never]) },
				{ name: 'Overdue', data: data.map(r =>[r.YearMonth, r.ExpectOverdue]) },
				{ name: 'This Month', data: data.map(r =>[r.YearMonth, r.ThisMonth]) },
				{ name: 'Future', data: data.map(r =>[r.YearMonth, r.Future]) }
			]
		});
	}

	function drawChartTop5(data) {
		var colors = ['#89BCEE', '#EE9589', '#7AB9C2', '#E7985A', '#E4AC69'];

		$('#chartTop5').highcharts({
			chart: { type: 'bar' },
			title: { text: 'Top Five Questions with the Lowest Average Scores' },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' } },
			plotOptions: {
				series: {
					dataLabels: {
						enabled: true,
						inside: true,
						format: '{y}%',
						style: { color: 'white', fontSize: '14px', textOutline: '' }
					},
					pointWidth: 46
				}
			},
			tooltip: { enabled: false },
			legend: { enabled: false },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [{
				name: 'Score (%)',
				data: data.map((r, i) => {
					return { name: r.English, y: Math.round(r.Percentage), color: colors[i] };
				})
			}]
		});
	}

	function drawChartBoxPlot(data) {
		var category = [
			'Section 2:<br>Test',
			'Section 3:<br>Treat',
			'Section 4:<br>Reporting and Documentation',
			'Section 5:<br>Workplace Assessment',
			'Section 6:<br>Waste Management',
			'Section 7:<br>Education Check'
		];

		$('#chartBoxPlot').highcharts({
			chart: { type: 'columnrange', inverted: true },
			title: { text: 'Box Plots of Scores by Section' },
			xAxis: { categories: category, crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: '' } },
			plotOptions: { series: { pointWidth: 35 } },
			tooltip: { enabled: false },
			legend: { enabled: false },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [{
				name: 'Score',
				data: [
					{ low: data.Section2Min, high: data.Section2Max, color: '#89BCEE' },
					{ low: data.Section3Min, high: data.Section3Max, color: '#EE9589' },
					{ low: data.Section4Min, high: data.Section4Max, color: '#7AB9C2' },
					{ low: data.Section5Min, high: data.Section5Max, color: '#E7985A' },
					{ low: data.Section6Min, high: data.Section6Max, color: '#E4AC69' },
					{ low: data.Section7Min, high: data.Section7Max, color: '#89BCEE' }
				]
			}]
		});
	}

	function drawMapQA(data) {
		var arr = targetOD;

		if (self.od() != null) arr = targetOD.filter(r => r.code == self.od());
		else if (self.pv() != null) arr = targetOD.filter(r => r.pvcode == self.pv());

		var mapData = arr.map(od => {
			var found = data.find(r => r.Code_OD_T == od.code);
			var score = found == null ? 0 : Math.round(found.Score);
			return [od.code, score];
		});

		$('#mapQA').highcharts('Map', {
			chart: { map: 'chartODBorder', backgroundColor: '#AADAFF' },
			title: { text: 'Average Score by OD' },
			colorAxis: {
				dataClasses: [
					{ from: 80, to: 100, color: '#44A34C' },
					{ from: 40, to: 79, color: '#F7BD4C' },
					{ from: 0, to: 39, color: '#F74A4C' }
				]
			},
			legend: {
				layout: 'vertical', align: 'right',
				valueDecimals: 0,
				symbolRadius: 0, symbolHeight: 20, symbolPadding: 10,
				itemMarginTop: 5,
				borderColor: '#ccc', borderWidth: 1, borderRadius: 6,
				backgroundColor: 'white',
				padding: 12
			},
			exporting: { sourceWidth: 900, sourceHeight: 600 },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			series: [{
				data: mapData,
				name: 'Average Score',
				dataLabels: { enabled: true, format: '{point.name}', style: { color: 'black', textOutline: '' } }
			}]
		});
	}

	function drawChartSupervision() {
		var obj = {};
		self.supervisorList().forEach(r => obj[r.WorkPlace] = r.Number);

		$('#chartSupervision').highcharts({
			chart: { type: 'bar' },
			title: { text: 'Number of Supervisions Conducted' },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1, labels: { style: { fontWeight: 'bold' } } },
			yAxis: { title: { text: '' } },
			plotOptions: {
				series: {
					dataLabels: {
						enabled: true,
						inside: true,
						style: { color: 'white', fontSize: '14px', textOutline: '' }
					},
					pointWidth: 46
				}
			},
			tooltip: { enabled: false },
			legend: { enabled: false },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [{
				name: '# Supervision',
				colorByPoint: true,
				data: [
					['CNM', obj.CNM],
					['Province', obj.Province],
					['OD', obj.OD],
					['HC', obj.HC]
				]
			}]
		});
	}
}

Highcharts.setOptions({
	xAxis: {
		labels: { style: { color: 'black', fontSize: '12px' } }
	},
	yAxis: {
		title: { style: { color: 'black' } },
		labels: { style: { color: 'black', fontSize: '12px' } }
	},
	exporting: {
		menuItemDefinitions: {
			downloadXLS: { onclick: Highcharts.Chart.prototype.downloadXLS }
		}
	}
});