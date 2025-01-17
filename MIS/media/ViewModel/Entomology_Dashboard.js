function viewModel() {
	var self = this;

	self.from = ko.observable(moment().month(0));
	self.to = ko.observable(moment());
	self.isFoci = ko.observable();
	self.trap = ko.observable();
	self.loaded = ko.observable(false);

	self.fociList = ko.observableArray();
	self.hourlyFoci = ko.observable();
	self.hourlyMethod = ko.observable();
	self.mortalitySpecies = ko.observable('An. dirus s.l.');

	self.tableFoci = ko.observableArray();

	self.provList = ko.observableArray();
	self.selectedProv = ko.observableArray();

	app.getPlace(['pv'], function (place) {
		self.provList(place.pv.filter(r => r.target == 1));

		app.readFileInZip($('#chartODBorder').val(), 'chartODBorder.js', function (script) {
			eval(script); //run script

			app.ajax('/Entomology/getFociNumber').done(function (rs) {
				self.fociList(rs.map(r => r.FociNumber));

				self.hourlyFoci.subscribe(getChartHourly);
				self.hourlyMethod.subscribe(getChartHourly);
				self.mortalitySpecies.subscribe(getChartMortality);

				self.viewClick();
			});
		});
	});

	self.viewClick = function () {
		if (self.from() == null || self.to() == null) return;

		var submit = {
			from: self.from().format('YYYYMM'),
			to: self.to().format('YYYYMM'),
			pv: self.selectedProv().length == 21 ? '' : self.selectedProv().join(','),
			isFoci: self.isFoci(),
			trap: self.trap(),
			hourlyFoci: self.hourlyFoci(),
			hourlyMethod: self.hourlyMethod(),
			mortalitySpecies: self.mortalitySpecies()
		};

		app.ajax('/Entomology/getDashboard', submit).done(function (rs) {
			self.loaded(true);

			drawPie(rs);
			drawAbdominalStage(rs);
			drawMap(rs);
			drawMapFoci(rs);
			drawChartHourlyBiting(rs);
			drawChartMonthlyBitingHDN(rs);
			drawChartMonthlyBitingCDN(rs);
			drawChartMonthlyBitingCDC(rs);
			drawChartMonthlyBitingCBT(rs);
			drawChartMortality(rs);

			self.tableFoci(rs.fociTable);
		});
	};

	function getChartHourly() {
		var submit = {
			from: self.from().format('YYYYMM'),
			to: self.to().format('YYYYMM'),
			pv: self.selectedProv().length == 21 ? '' : self.selectedProv().join(','),
			isFoci: self.isFoci(),
			trap: self.trap(),
			hourlyFoci: self.hourlyFoci(),
			hourlyMethod: self.hourlyMethod()
		};

		app.ajax('/Entomology/getChartHourly', submit).done(drawChartHourlyBiting);
	}

	function getChartMortality() {
		var submit = {
			from: self.from().format('YYYYMM'),
			to: self.to().format('YYYYMM'),
			pv: self.selectedProv().length == 21 ? '' : self.selectedProv().join(','),
			mortalitySpecies: self.mortalitySpecies()
		};

		app.ajax('/Entomology/getChartMortality', submit).done(drawChartMortality);
	}

	function drawPie(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');

		$('#pie').highcharts({
			chart: { type: 'pie', height: 500 },
			title: { text: 'Species Composition (An. dirus s.l., An. minimus s.l., An. maculatus s.l.)' },
			subtitle: { text: duration },
			tooltip: { enabled: false },
			plotOptions: {
				series: {
					enableMouseTracking: false,
					dataLabels: {
						enabled: true,
						format: '{point.name} <b>{point.y}</b> ({point.percentage:.0f}%)',
						style: { fontWeight: 'regular', fontSize: '14px' }
					}
				}
			},
			series: [{
				data: rs.pie.map(r =>[r.Species, r.Total])
			}]
		});
	}

	function drawAbdominalStage(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');
		var data = rs.abdominalStage;

		$('#abdominalStage').highcharts({
			chart: { type: 'column', height: 500 },
			title: { text: 'Abdominal Stage' },
			subtitle: { text: duration },
			xAxis: { categories: ['An. dirus s.l.', 'An. maculatus s.l.', 'An. minimus s.l.'], crosshair: true },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' } },
			tooltip: {
				shared: true,
				pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>'
			},
			plotOptions: {
				column: {
					stacking: 'percent',
					dataLabels: { enabled: true, format: '{point.percentage:.0f}%' },
				}
			},
			series: [
				{ name: 'UF', data: data.filter(r => r.Section == 'UF').map(r => r.Result) },
				{ name: 'F', data: data.filter(r => r.Section == 'F').map(r => r.Result) },
				{ name: 'HG', data: data.filter(r => r.Section == 'HG').map(r => r.Result) },
				{ name: 'G', data: data.filter(r => r.Section == 'G').map(r => r.Result) }
			]
		});
	}

	function drawMap(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');
		var data = rs.map;

		for (var r of data) {
			r.name = `Province: <b>${r.Name_Prov_E}</b><br>`
					+ `District: <b>${r.Name_Dist_E}</b><br>`
					+ `Commune: <b>${r.Name_Comm_E}</b><br>`
					+ `Village: <b>${r.Name_Vill_E}</b><br>`
					+ `Sentinel Site: <b>${r.Site}</b>`;
		}

		$('#map').highcharts('Map', {
			chart: { height: 800 },
			title: { text: 'Species on map' },
			subtitle: { text: duration },
			tooltip: { pointFormat: '{point.name}' },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			legend: {
				title: { text: 'Click on species to hide' },
				layout: 'vertical', align: 'right',
				itemMarginBottom: 5, backgroundColor: 'white', borderWidth: 1
			},
			exporting: { sourceWidth: 900, sourceHeight: 800 },
			series: [{
				mapData: Highcharts.maps['chartODBorder'], nullColor: '#e6faea',
				showInLegend: false,
				dataLabels: { enabled: true, format: '{point.name}', style: { color: 'gray', textOutline: '' } }
			}, {
				name: 'An. dirus s.l.',
				type: 'mappoint',
				dataLabels: { enabled: false },
				data: data.filter(r => r.Species == 'An. dirus s.l.').map(r => {
					return { name: r.name, lat: r.Lat.toFloat(), lon: r.Long.toFloat() };
				})
			}, {
				name: 'An. maculatus s.l.',
				type: 'mappoint',
				dataLabels: { enabled: false },
				data: data.filter(r => r.Species == 'An. maculatus s.l.').map(r => {
					return { name: r.name, lat: r.Lat.toFloat(), lon: r.Long.toFloat() };
				})
			}, {
				name: 'An. minimus s.l.',
				type: 'mappoint',
				dataLabels: { enabled: false },
				data: data.filter(r => r.Species == 'An. minimus s.l.').map(r => {
					return { name: r.name, lat: r.Lat.toFloat(), lon: r.Long.toFloat() };
				})
			}]
		});
	}

	function drawMapFoci(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');
		var data = rs.mapFoci;

		for (var r of data) {
			r.name = `Province: <b>${r.Name_Prov_E}</b><br>`
					+ `OD: <b>${r.Name_OD_E}</b><br>`
					+ `HC: <b>${r.Name_Facility_E}</b><br>`
					+ `Village: <b>${r.Name_Vill_E}</b><br>`
					+ `Foci Number: <b>${r.FociCode}</b>`;
		}

		$('#mapFoci').highcharts('Map', {
			chart: { height: 800 },
			title: { text: 'Foci Village Map' },
			subtitle: { text: duration },
			tooltip: { pointFormat: '{point.name}' },
			legend: { enabled: false },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			exporting: { sourceWidth: 900, sourceHeight: 800 },
			series: [{
				mapData: Highcharts.maps['chartODBorder'], nullColor: '#e6faea',
				showInLegend: false,
				dataLabels: { enabled: true, format: '{point.name}', style: { color: 'gray', textOutline: '' } }
			}, {
				name: 'Foci Village',
				type: 'mappoint',
				dataLabels: { enabled: false },
				color: Highcharts.getOptions().colors[2],
				marker: { lineWidth: 1, lineColor: '#2B908F' },
				data: data.map(r => {
					return { name: r.name, lat: r.Lat, lon: r.Long };
				})
			}]
		});
	}

	function drawChartHourlyBiting(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');

		$('#chartHourlyBiting').highcharts({
			chart: { type: 'spline', height: 500 },
			title: { text: 'Average Number of Mosquitoes Collected Hourly' },
			subtitle: { text: duration },
			xAxis: { type: 'category', crosshair: true },
			yAxis: { title: { text: 'Average Number' } },
			tooltip: { shared: true },
			plotOptions: {
				series: {
					dataLabels: { enabled: true, style: { fontSize: '13px' } }
				}
			},
			series: [{
				name: 'An. dirus s.l.',
				data: rs.hourlyBiting.filter(r => r.Species == 'An. dirus s.l.').map(r =>[r.CollectionTime, r.Result.toFixed(1).toFloat()])
			}, {
				name: 'An. minimus s.l.',
				data: rs.hourlyBiting.filter(r => r.Species == 'An. minimus s.l.').map(r =>[r.CollectionTime, r.Result.toFixed(1).toFloat()])
			}, {
				name: 'An. maculatus s.l.',
				data: rs.hourlyBiting.filter(r => r.Species == 'An. maculatus s.l.').map(r =>[r.CollectionTime, r.Result.toFixed(1).toFloat()])
			}]
		});
	}

	function drawChartMonthlyBitingHDN(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');
		var categories = Array.repeat(12, i => moment().month(i).format('MMM'));

		var dirus = Array.repeat(12, i => {
			var found = rs.monthlyBitingHDN.find(r => r.Species == 'An. dirus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});
		var minimus = Array.repeat(12, i => {
			var found = rs.monthlyBitingHDN.find(r => r.Species == 'An. minimus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});
		var maculatus = Array.repeat(12, i => {
			var found = rs.monthlyBitingHDN.find(r => r.Species == 'An. maculatus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});

		$('#chartMonthlyBitingHDN').highcharts({
			chart: { type: 'column', height: 500 },
			title: { text: 'Average Number of Mosquitoes Collected Monthly (HDN only)' },
			subtitle: { text: duration },
			xAxis: { categories: categories, crosshair: true },
			yAxis: { title: { text: 'Average Number' } },
			tooltip: { shared: true },
			plotOptions: { series: { dataLabels: { enabled: true, style: { fontSize: '13px' } } } },
			series: [
				{ name: 'An. dirus s.l.', data: dirus },
				{ name: 'An. minimus s.l.', data: minimus },
				{ name: 'An. maculatus s.l.', data: maculatus }
			]
		});
	}

	function drawChartMonthlyBitingCDN(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');
		var categories = Array.repeat(12, i => moment().month(i).format('MMM'));

		var dirus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCDN.find(r => r.Species == 'An. dirus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});
		var minimus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCDN.find(r => r.Species == 'An. minimus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});
		var maculatus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCDN.find(r => r.Species == 'An. maculatus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});

		$('#chartMonthlyBitingCDN').highcharts({
			chart: { type: 'column', height: 500 },
			title: { text: 'Average Number of Mosquitoes Collected Monthly (CDN only)' },
			subtitle: { text: duration },
			xAxis: { categories: categories, crosshair: true },
			yAxis: { title: { text: 'Average Number' } },
			tooltip: { shared: true },
			plotOptions: { series: { dataLabels: { enabled: true, style: { fontSize: '13px' } } } },
			series: [
				{ name: 'An. dirus s.l.', data: dirus },
				{ name: 'An. minimus s.l.', data: minimus },
				{ name: 'An. maculatus s.l.', data: maculatus }
			]
		});
	}

	function drawChartMonthlyBitingCDC(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');
		var categories = Array.repeat(12, i => moment().month(i).format('MMM'));

		var dirus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCDC.find(r => r.Species == 'An. dirus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});
		var minimus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCDC.find(r => r.Species == 'An. minimus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});
		var maculatus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCDC.find(r => r.Species == 'An. maculatus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});

		$('#chartMonthlyBitingCDC').highcharts({
			chart: { type: 'column', height: 500 },
			title: { text: 'Average Number of Mosquitoes Collected Monthly (CDC-LT only)' },
			subtitle: { text: duration },
			xAxis: { categories: categories, crosshair: true },
			yAxis: { title: { text: 'Average Number' } },
			tooltip: { shared: true },
			plotOptions: { series: { dataLabels: { enabled: true, style: { fontSize: '13px' } } } },
			series: [
				{ name: 'An. dirus s.l.', data: dirus },
				{ name: 'An. minimus s.l.', data: minimus },
				{ name: 'An. maculatus s.l.', data: maculatus }
			]
		});
	}

	function drawChartMonthlyBitingCBT(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');
		var categories = Array.repeat(12, i => moment().month(i).format('MMM'));

		var dirus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCBT.find(r => r.Species == 'An. dirus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});
		var minimus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCBT.find(r => r.Species == 'An. minimus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});
		var maculatus = Array.repeat(12, i => {
			var found = rs.monthlyBitingCBT.find(r => r.Species == 'An. maculatus s.l.' && r.Month == i + 1);
			return found == null ? 0 : found.Result.toFixed(1).toFloat();
		});

		$('#chartMonthlyBitingCBT').highcharts({
			chart: { type: 'column', height: 500 },
			title: { text: 'Average Number of Mosquitoes Collected Monthly (CBT only)' },
			subtitle: { text: duration },
			xAxis: { categories: categories, crosshair: true },
			yAxis: { title: { text: 'Average Number' } },
			tooltip: { shared: true },
			plotOptions: { series: { dataLabels: { enabled: true, style: { fontSize: '13px' } } } },
			series: [
				{ name: 'An. dirus s.l.', data: dirus },
				{ name: 'An. minimus s.l.', data: minimus },
				{ name: 'An. maculatus s.l.', data: maculatus }
			]
		});
	}

	function drawChartMortality(rs) {
		var duration = self.from().format('MMM YYYY') + ' - ' + self.to().format('MMM YYYY');

		$('#chartMortality').highcharts({
			chart: { type: 'column' },
			title: { text: 'Insecticide Resistance Mortality' },
			subtitle: { text: duration },
			xAxis: { type: 'category', crosshair: true },
			yAxis: { title: { text: 'Percentage' }, labels: { format: '{value}%' } },
			tooltip: { enabled: false },
			legend: { enabled: false },
			plotOptions: {
				series: {
					enableMouseTracking: false,
					dataLabels: { enabled: true, format: '{y}%', style: { fontSize: '13px' } }
				}
			},
			series: [{
				data: rs.mortality.map(r =>[r.InsecticideTested, r.Mortality]),
				color: Highcharts.getOptions().colors[2]
			}]
		});
	}

	self.getProvInfo = function () {
		var arr = self.selectedProv();

		return arr.length == 0 || arr.length == 21 ? 'All'
			: arr.length == 1 ? self.provList().find(r => r.code == arr[0]).name
			: arr.length + ' Proivnces';
	};
}