$('.btnmenu').each(function (index, el) {
	if (location.pathname.contain($(el).attr('href'))) {
		$(el).removeClass('btn-default').addClass('btn-info');
	}
});

function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.loaded = ko.observable(false);

	app.ajax('/QMalaria/getReportData1').done(function (rs) {
		self.listModel(rs.table);
		prepareChart(rs);

		self.loaded(true);
	});

	function prepareChart(rs) {
		var data = rs.chart1;
		var category = data.map(r => r.Name_Facility_E).distinct();
		var months = data.map(r => r.Month).distinct().sortasc();
		var series = months.map(m => {
			return {
				name: m < 13 ? moment(m, 'M').format('MMM') : 'Data not in 2019',
				data: data.filter(r => r.Month == m).map(r =>[r.Name_Facility_E, r.Total]),
				color: m == 13 ? '#ff0000' : ''
			}
		});

		$('#chart1').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of Patients by Health Center' },
			xAxis: { type: 'category', gridLineWidth: 1, crosshair: true },
			yAxis: { title: { text: 'Number of Patients' }, reversedStacks: false, minorTickInterval: 'auto' },
			tooltip: { shared: true },
			plotOptions: {
				series: {
					stacking: 'normal',
					dataLabels: { enabled: true },
					states: { inactive: { opacity: 1 } }
				}
			},
			exporting: {
				sourceWidth: 1200, sourceHeight: 800,
				menuItemDefinitions: { downloadXLS: { onclick: function () { this.downloadXLS() } } }
			},
			colors: ['#7cb5ec', '#ECEC00', '#f7a35c', '#2b908f', '#8085e9', '#90ed7d', '#e4d354', '#f15c80', '#434348', '#91e8e1', '#0000ff', '#008000'],
			series: series
		});

		var data = rs.chart2;
		$('#chart2').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of Reports by Health Center' },
			xAxis: { type: 'category', gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of reports' }, minorTickInterval: 'auto' },
			tooltip: { enabled: false },
			exporting: {
				sourceWidth: 1200, sourceHeight: 800,
				menuItemDefinitions: { downloadXLS: { onclick: function () { this.downloadXLS() } } }
			},
			series: [
				{ name: 'Reports', data: data.map(r =>[r.Name_Facility_E, r.Reported]), dataLabels: { enabled: true } }
			]
		});
	}

	self.exportAll = function () {
		app.downloadBlob('/QMalaria/exportAll').done(function (blob) {
			saveAs(blob, 'Labo & Clinical.xlsx'); //from FileSaver.js
		});
	};
}