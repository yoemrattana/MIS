function iDesGraph(root) {
	var self = this;

	self.filter = ko.observable();
	self.mf = ko.observable(moment().month(0));
	self.mt = ko.observable(moment());
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.vl = ko.observable();
	self.species = ko.observable();
	self.site = ko.observable();
	self.loaded = ko.observable(false);

	root.menu.subscribe(function (menu) {
		if (menu == 'Graphs' && Highcharts.maps.chartODBorder == null) {
			app.readFileInZip($('#chartODBorder').val(), 'chartODBorder.js', function (script) {
				eval(script); //run script
			});
		}
	});

	self.viewClick = function () {
		var submit = {
			filter: self.filter(),
			mf: self.mf().format('YYYYMM'),
			mt: self.mt().format('YYYYMM'),
			pv: self.pv(),
			od: self.od(),
			hc: self.hc(),
			vl: self.vl(),
			species: self.species(),
			site: self.site()
		};
		app.ajax('/iDes/getGraph', submit).done(function (rs) {
			self.loaded(true);

			if (self.filter() == 'iDES follow up rate') {
				drawFollow(rs.follow);
				drawChatBySpecies('Pv', rs.species.find(r => r.Diagnosis == 'V'));
				drawChatBySpecies('Pf', rs.species.find(r => r.Diagnosis == 'F'));
				drawChatBySpecies('Pm', rs.species.find(r => r.Diagnosis == 'A'));
				drawChatBySpecies('Pk', rs.species.find(r => r.Diagnosis == 'K'));
			}
			if (self.filter() == 'Geographical Distribution of Cases') drawMap(rs);
			if (self.filter() == 'Case Enrollment') {
				drawChartCaseEnroll(rs.a);
				drawChartCaseEnrollOD(rs.b);
			}
			if (self.filter() == 'Weekly Case Enrollment') drawChartWeek(rs);
			if (self.filter() == 'Blood Slides/DBS') drawChartDBS(rs);
			if (self.filter() == 'Samples Collected') drawChartSample(rs);
			if (self.filter() == 'iDES cases with side effects') drawChartSideEffect(rs);
			if (self.filter() == 'PCR Result') drawChartPCR(rs);
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

	function fullSpecies(value) {
		return value == '' ? 'All'
			: value == 'F' ? 'Pf'
			: value == 'V' ? 'Pv'
			: value == 'M' ? 'Mix'
			: value == 'A' ? 'Pm'
			: value == 'K' ? 'Pk'
			: 'Po';
	}

	function drawFollow(rs) {
		//var category = ['Eligible iDES', 'iDES', 'D1', 'D2', 'D3', 'D7', 'D28', 'D42', 'D90'];
		var category = ['iDES', 'D1', 'D2', 'D3', 'D7', 'D28', 'D42', 'D90'];
		var colors = Highcharts.getOptions().colors;
		var data = [
			//{ name: 'Eligible iDES', color: colors[0], y: rs.Eligible_iDes == 0 ? 0 : 100 },
			{ name: 'iDES', color: colors[1], y: rs.Eligible_iDes == 0 ? 0 : rs.iDes * 100 / rs.Eligible_iDes },
			{ name: 'D1', color: colors[2], y: rs.iDes == 0 ? 0 : rs.D1 * 100 / rs.iDes },
			{ name: 'D2', color: colors[3], y: rs.iDes == 0 ? 0 : rs.D2 * 100 / rs.iDes },
			{ name: 'D3', color: colors[4], y: rs.iDes == 0 ? 0 : rs.D3 * 100 / rs.iDes },
			{ name: 'D7', color: colors[5], y: rs.iDes == 0 ? 0 : rs.D7 * 100 / rs.iDes },
			{ name: 'D28', color: colors[7], y: rs.iDes == 0 ? 0 : rs.D28 * 100 / rs.iDes },
			{ name: 'D42', color: colors[8], y: rs.iDesPfMixPmPk == 0 ? 0 : rs.D42 * 100 / rs.iDesPfMixPmPk },
			{ name: 'D90', color: colors[9], y: rs.iDesPvPo == 0 ? 0 : rs.D90 * 100 / rs.iDesPvPo }
		];

		if (self.species().in('F','M','A','K')) {
			category = category.filter(r => r != 'D90');
			data = data.filter(r => r.name != 'D90');
		}
		if (self.species().in('V','O')) {
			category = category.filter(r => r != 'D42');
			data = data.filter(r => r.name != 'D42');
		}

		for (var i = 1; i < category.length; i++) {
			var s = '{0}<br><span style="color:gray;font-size:10px">({0} / {1})</span>';
			category[i] = String.format(s, category[i], i == 1 ? 'Eligible' : 'iDES');
		}

		var sameYear = self.mf().year() == self.mt().year();
		var duration = self.mf().format(sameYear ? 'MMM' : 'MMM YYYY') + ' - ' + self.mt().format('MMM YYYY');
		var subtitle = 'Species: ' + fullSpecies(self.species());

		function dataLabel() {
			return this.y.toFixed(0) + '%' + (
				this.x.substr(0, 1) == 'E' ? ''
				: this.x.substr(0, 1) == 'i' ? ` (${rs.iDes}/${rs.Eligible_iDes})`
				: this.x.substr(0, 3) == 'D42' ? ' (' + (this.y * rs.iDesPfMixPmPk / 100).toFixed(0) + `/${rs.iDesPfMixPmPk})`
				: this.x.substr(0, 3) == 'D90' ? ' (' + (this.y * rs.iDesPvPo / 100).toFixed(0) + `/${rs.iDesPvPo})`
				: ' (' + (this.y * rs.iDes / 100).toFixed(0) + `/${rs.iDes})`
			);
		}

		function tooltip() {
			if (this.key == 'Eligible iDES') return this.y.toFixed(0) + '%';
			if (this.key == 'iDES') {
				var a = self.species().in('F', 'M', 'A', 'K') ? rs.D42 : self.species().in('V', 'O') ? rs.D90 : rs.D42 + rs.D90;
				var b = self.species().in('F', 'M', 'A', 'K') ? rs.D42_Future : self.species().in('V', 'O') ? rs.D90_Future : rs.D42_Future + rs.D90_Future;
				return 'Completed follow up: ' + a
				+ '<br>Ongoing: ' + b
				+ '<br>Lost follow up: ' + (rs.iDes - (a + b));
			}
			if (this.key == 'D42') {
				var a = parseInt((this.y * rs.iDesPfMixPmPk / 100).toFixed(0));
				var b = rs[this.key + '_Future'];
				return 'Followed up: ' + a
					+ '<br>Future follow up: ' + b
					+ '<br>Did not folow up: ' + (rs.iDesPfMixPmPk - (a + b));
			}
			if (this.key == 'D90') {
				var a = parseInt((this.y * rs.iDesPvPo / 100).toFixed(0));
				var b = rs[this.key + '_Future'];
				return 'Followed up: ' + a
					+ '<br>Future follow up: ' + b
					+ '<br>Did not folow up: ' + (rs.iDesPvPo - (a + b));
			}

			var a = parseInt((this.y * rs.iDes / 100).toFixed(0));
			var b = rs[this.key + '_Future'];
			return 'Followed up: ' + a
				+ '<br>Future follow up: ' + b
				+ '<br>Did not folow up: ' + (rs.iDes - (a + b));
		}

		$('#chartFollowup').highcharts({
			chart: { type: 'column' },
			title: { text: 'iDES follow up rate (' + duration + ')' },
			subtitle: { text: subtitle },
			xAxis: { categories: category, crosshair: true, gridLineColor: '#e6e6e6', gridLineWidth: 1 },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' }, allowDecimals: false, max: 100 },
			plotOptions: { series: { dataLabels: { enabled: true, formatter: dataLabel } } },
			tooltip: { formatter: tooltip },
			legend: { enabled: false },
			exporting: { sourceWidth: 1000 },
			series: [{ name: 'iDES', data: data }]
		});
	}

	function drawChatBySpecies(species, rs) {
		var sameYear = self.mf().year() == self.mt().year();
		var duration = self.mf().format(sameYear ? 'MMM' : 'MMM YYYY') + ' - ' + self.mt().format('MMM YYYY');

		$('#chart' + species).highcharts({
			chart: { type: 'column' },
			title: { text: species + ' Chart (' + duration + ')' },
			xAxis: { categories: ['Total', 'Ongoing', 'ACPR', 'Lost follow up', 'New infection', 'Relapse'] },
			yAxis: { title: { text: '' }, labels: { enabled: false } },
			legend: { enabled: false },
			tooltip: { enabled: false },
			series: [{
				colorByPoint: true,
				dataLabels: { enabled: true },
				data: [
					{ name: 'Total', y: rs.Total },
					{ name: 'Ongoing', y: rs.Ongoing },
					{ name: 'ACPR', y: rs.ACPR },
					{ name: 'Lost follow up', y: rs.Total - (rs.Complete + rs.Ongoing) },
					{ name: 'New infection', y: rs.NewInfection },
					{ name: 'Relapse', y: 0 },
				]
			}]
		});
	}

	function drawMap(rs) {
		var sameYear = self.mf().year() == self.mt().year();
		var duration = self.mf().format(sameYear ? 'MMM' : 'MMM YYYY') + ' - ' + self.mt().format('MMM YYYY');
		var data = root.place.od.map(od => {
			var found = rs.map1.find(r => r.Code_OD_T == od.code);
			var value = found == null ? 0 : found.Positive;
			return [od.code, value];
		});

		$('#chartMap').highcharts('Map', {
			chart: { map: 'chartODBorder' },
			title: { text: 'Total of ' + fullSpecies(self.species()) + ' Cases (' + duration + ')' },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			colorAxis: {
				dataClasses: [
					{ from: 1, to: 10, color: '#FFBFBF' },
					{ from: 11, to: 50, color: '#FF0000' },
					{ from: 50, color: '#930000' }
				]
			},
			legend: {
				title: { text: 'Number of cases' },
				layout: 'vertical', align: 'right',
				valueDecimals: 0,
				symbolRadius: 0, symbolWidth: 30, symbolHeight: 15, squareSymbol: false,
				itemMarginTop: 5, margin: 5
			},
			series: [{
				name: fullSpecies(self.species()) + ' Cases',
				data: data,
				color: '#F7F7F7',
				borderColor: '#aaa',
				dataLabels: {
					enabled: true,
					format: '{point.name}',
					style: { color: 'black', textOutline: '', fontSize: '10px' }
				}
			}]
		});

		$('#chartMap2').highcharts('Map', {
			title: { text: 'No. of ' + fullSpecies(self.species()) + ' Cases enrolled to iDES by site (' + duration + ')' },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			legend: {
				layout: 'vertical', align: 'right',
				valueDecimals: 0,
				symbolRadius: 0, symbolWidth: 30, symbolHeight: 15, squareSymbol: false,
				itemMarginTop: 5, margin: 5
			},
			tooltip: { pointFormat: '{point.Place}: {point.z}' },
			series: [
				{
					mapData: Highcharts.maps['chartODBorder'],
					showInLegend: false,
					dataLabels: { enabled: true, format: '{point.name}', style: { color: 'black', textOutline: '', fontSize: '10px' } }
				},
				{
					type: 'mapbubble',
					name: 'Enrolled Cases',
					color: 'darkred',
					maxSize: '10%',
					marker: { fillColor: '#ff000080' },
					data: rs.map2
				},
				{
					type: 'mappoint',
					name: 'iDES Site',
					color: 'green',
					data: rs.map2.filter(r => r.iDesSite == 1)
				}
			]
		});
	}

	function drawChartCaseEnroll(rs) {
		var rs = rs.slice(1).filter(r => r.Eligible > 0);
		var percent = rs.map(r => Math.round(r.iDes * 100 / r.Eligible));

		var place = self.od() != null ? 'HFs' : self.pv() != null ? 'ODs' : 'Provinces';
		var mfFormat = self.mf().year() == self.mt().year() ? 'MMM' : 'MMM YYYY';

		$('#chartCaseEnroll').highcharts({
			chart: { type: 'column' },
			title: { text: `iDES-eligible cases enrolled to iDES by ${place} from ${self.mf().format(mfFormat)} to ${self.mt().format('MMM YYYY')}` },
			xAxis: { categories: rs.map(r => r.Place), crosshair: true, gridLineWidth: 1, gridLineColor: '#e6e6e6' },
			yAxis: [{ title: { text: 'Number of cases' } }, { title: { text: '' }, opposite: true, allowDecimals: false, labels: { format: '{value}%' }, max: 100 }],
			plotOptions: {
				series: { dataLabels: { enabled: true } },
				scatter: { marker: { radius: 5 }, tooltip: { pointFormat: '{point.y}%' } }
			},
			tooltip: { shared: true },
			exporting: { sourceWidth: 1000, sourceHeight: 500 },
			series: [
				{ name: 'Positive Malaria', data: rs.map(r => r.Positive), color: '#7cb5ec' },
				{ name: 'Eligible Cases', data: rs.map(r => r.Eligible), color: '#f7a35c' },
				{ name: 'Enrolled in iDES', data: rs.map(r => r.iDes), color: '#2b908f' },
				{ name: '% Enrolled in iDES', data: percent, type: 'scatter', yAxis: 1, dataLabels: { format: '{y}%' }, color: '#f45b5b' }
			]
		});
	}

	function drawChartCaseEnrollOD(rs) {
		var percent = rs.map(r => Math.round(r.iDes * 100 / r.Eligible));
		var mfFormat = self.mf().year() == self.mt().year() ? 'MMM' : 'MMM YYYY';

		$('#chartCaseEnrollOD').highcharts({
			chart: { type: 'column' },
			title: { text: `iDES-eligible cases enrolled to iDES by OD from ${self.mf().format(mfFormat)} to ${self.mt().format('MMM YYYY')}` },
			xAxis: { categories: rs.map(r => r.Name_OD_E), crosshair: true, gridLineWidth: 1, gridLineColor: '#e6e6e6' },
			yAxis: [{ title: { text: 'Number of cases' } }, { title: { text: '' }, opposite: true, allowDecimals: false, labels: { format: '{value}%' }, max: 100 }],
			plotOptions: {
				series: { dataLabels: { enabled: true } },
				scatter: { marker: { radius: 5 }, tooltip: { pointFormat: '{point.y}%' } }
			},
			tooltip: { shared: true },
			exporting: { sourceWidth: 1000, sourceHeight: 500 },
			series: [
				{ name: 'Positive Malaria', data: rs.map(r => r.Positive), color: '#7cb5ec' },
				{ name: 'Eligible Cases', data: rs.map(r => r.Eligible), color: '#f7a35c' },
				{ name: 'Enrolled in iDES', data: rs.map(r => r.iDes), color: '#2b908f' },
				{ name: '% Enrolled in iDES', data: percent, type: 'scatter', yAxis: 1, dataLabels: { format: '{y}%' }, color: '#f45b5b' }
			]
		});
	}

	function drawChartWeek(rs) {
		var data = [];

		var w = self.mt().clone();
		w.date(w.daysInMonth());
		w = w > moment() ? moment().week() : w.week();

		if (self.mt().month() == 11 && rs.some(r => r.WeekNum == 53)) w = 53;

		for (var i = 1; i <= w; i++) {
			var found = rs.find(r => r.WeekNum == i);
			if (found == null) found = { WeekNum: i, NoniDes: 0, iDes: 0 };
			data.push(found);
		}

		var percent = data.map(r => r.iDes + r.NoniDes == 0 ? 0 : Math.round(r.iDes * 100 / (r.iDes + r.NoniDes)));
		var mfFormat = self.mf().year() == self.mt().year() ? 'MMM' : 'MMM YYYY';

		$('#chartiDesWeek').highcharts({
			chart: { type: 'column' },
			title: { text: 'No. of Weekly iDES-eligible Cases from 1<sup>st</sup> Week of Jan to Current Week', useHTML: true },
			xAxis: { categories: data.map(r => 'Wk' + r.WeekNum), crosshair: true, gridLineWidth: 1, gridLineColor: '#e6e6e6', labels: { rotation: -90 } },
			yAxis: [{ title: { text: '' }, reversedStacks: false }, { title: { text: '' }, opposite: true, allowDecimals: false, labels: { format: '{value}%' }, max: 100 }],
			plotOptions: { column: { stacking: 'normal' } },
			tooltip: { shared: true },
			exporting: { sourceWidth: 1400, sourceHeight: 500 },
			series: [
				{ name: 'Non Enrolled', data: data.map(r => r.NoniDes), color: '#7cb5ec' },
				{ name: 'Enrolled', data: data.map(r => r.iDes), color: '#f7a35c' },
				{ name: '% of Eligible cases Enrolled', data: percent, yAxis: 1, type: 'line', color: '#f45b5b', tooltip: { valueSuffix: '%' } },
			]
		});
	}

	function drawChartDBS(rs) {
		var category = ['DBS', 'D0', 'D28', 'D42', 'D90'];
		var colors = Highcharts.getOptions().colors;
		var data = [
			{ color: colors[0], y: rs.DBS * 100 / rs.Positive },
			{ color: colors[1], y: rs.D0 * 100 / rs.DBS },
			{ color: colors[2], y: rs.D28 * 100 / rs.DBS },
			{ color: colors[3], y: rs.D42 * 100 / rs.DBS },
			{ color: colors[4], y: rs.D90 * 100 / rs.DBS }
		];

		for (var i = 0; i < category.length; i++) {
			var s = '{0}<br><span style="color:gray;font-size:10px">({0} / {1})</span>';
			category[i] = String.format(s, category[i], i == 0 ? 'Positive Cases' : 'DBS');
		}

		var sameYear = self.mf().year() == self.mt().year();
		var duration = self.mf().format(sameYear ? 'MMM' : 'MMM YYYY') + ' - ' + self.mt().format('MMM YYYY');

		function dataLabel() {
			var name = this.x.split('<br>')[0];
			return this.y.toFixed(0) + (
				name == 'DBS' ? `% (${rs.DBS}/${rs.Positive})` : `% (${rs[name]}/${rs.DBS})`
			);
		}

		$('#chartDBS').highcharts({
			chart: { type: 'column' },
			title: { text: 'Blood slide/DBS follow up rate (' + duration + ')' },
			xAxis: { categories: category, crosshair: true, gridLineColor: '#e6e6e6', gridLineWidth: 1 },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' }, allowDecimals: false, max: 100 },
			plotOptions: { series: { dataLabels: { enabled: true, formatter: dataLabel } } },
			tooltip: { enabled: false },
			legend: { enabled: false },
			exporting: { sourceWidth: 1000 },
			series: [{ name: 'DBS', data: data }]
		});
	}

	function drawChartSample(rs) {
		var mfFormat = self.mf().year() == self.mt().year() ? 'MMM' : 'MMM YYYY';

		$('#chartSample').highcharts({
			chart: { type: 'column' },
			title: { text: `# of samples collected during follow up visit from ${self.mf().format(mfFormat)} to ${self.mt().format('MMM YYYY')}` },
			xAxis: { categories: ['D0', 'D28 or D42', 'D90'], gridLineColor: '#e6e6e6', gridLineWidth: 1 },
			yAxis: { title: { text: '' } },
			plotOptions: {
				series: {
					enableMouseTracking: false,
					pointPadding: 0,
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						formatter: function () {
							if (this.x == 'D0') return this.y;
							var D0 = this.series.name == 'Slide' ? rs.D0_Slide : rs.D0_DBS;
							return this.y + ' (' + (this.y * 100 / D0).toFixed(0) + '%)';
						}
					}
				}
			},
			tooltip: { enabled: false },
			series: [
				{ name: 'Slides', data: [rs.D0_Slide, rs.D28_42_Slide, rs.D90_Slide], color: '#003E78' },
				{ name: 'DBS', data: [rs.D0_DBS, rs.D28_42_DBS, rs.D90_DBS], color: '#1282A2' }
			]
		});
	}

	function drawChartSideEffect(rs) {
		var mfFormat = self.mf().year() == self.mt().year() ? 'MMM' : 'MMM YYYY';

		function getdata(name) {
			return [
				rs.find(r => r.Days == 'D0')[name],
				rs.find(r => r.Days == 'D3')[name],
				rs.find(r => r.Days == 'D7')[name],
				rs.filter(r => r.Days.in('D28', 'D42')).sum(name),
				rs.find(r => r.Days == 'D90')[name]
			];
		}

		$('#chartSideEffect').highcharts({
			chart: { type: 'line' },
			title: { text: `# iDES cases with side effects reported from ${self.mf().format(mfFormat)} to ${self.mt().format('MMM YYYY')}` },
			xAxis: { categories: ['D0', 'D3', 'D7', 'D28 or D42', 'D90'], crosshair: true, gridLineColor: '#e6e6e6', gridLineWidth: 1 },
			yAxis: { title: { text: '' } },
			tooltip: { shared: true },
			series: [
				{ name: 'Vomit', data: getdata('Vomit2hrs') },
				{ name: 'Dizziness', data: getdata('Dizziness') },
				{ name: 'Headache', data: getdata('Headache') },
				{ name: 'Abdominal pain', data: getdata('Pain') },
				{ name: 'Diarrhoea', data: getdata('Diarrhoea') },
				{ name: 'Skin rashes', data: getdata('SkinRash') },
				{ name: 'Other', data: [0, 0, 0, 0, 0] }
			]
		});
	}

	function drawChartPCR(rs) {
		$('#chartPCR').highcharts({
			chart: { type: 'pie' },
			title: { text: 'PCR Result' },
			tooltip: {
				headerFormat: '<b>{series.name}</b><br>',
				pointFormat: '<span style="color:{point.color}">\u25CF</span> {point.name}: {point.y} ({point.percentage:.0f}%)'
			},
			series: [
				{ name: 'PCR Result', data: rs.map(r => { return { name: r.PCR, y: r.Qty } }) }
			]
		});
	}
}