if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {
	var laoMap, thaiMap, vietMap;
	var laoCode, thaiCode, vietCode, camCode;

	self.showTabBorder = function () {
		if (laoMap == null) {
			laoMap = structuredClone(Highcharts.maps['chartOtherBorder']);
			laoMap.features = laoMap.features.filter(r => r.properties.country == 'Lao');

			thaiMap = structuredClone(Highcharts.maps['chartOtherBorder']);
			thaiMap.features = thaiMap.features.filter(r => r.properties.country == 'Thailand');

			vietMap = structuredClone(Highcharts.maps['chartOtherBorder']);
			vietMap.features = vietMap.features.filter(r => r.properties.country == 'Vietnam');

			laoCode = laoMap.features.map(r => r.properties['hc-key']);
			thaiCode = thaiMap.features.map(r => r.properties['hc-key']);
			vietCode = vietMap.features.map(r => r.properties['hc-key']);
			camCode = Highcharts.maps['chartCommuneBorder'].features.map(r => r.properties['hc-key']);
		}

		app.ajax('/Dashboard/tabBorder/', self.lastSubmit).done(function (rs) {
			Object.keys(rs).forEach(key => self.mainData[key] = rs[key]);

			self.drawBorderChart();
			self.drawMapCommuneBorder();
			self.drawMapCommuneBorderPfMix();
			self.drawMapCommuneBorderPv();

			self.loaded(true);
		});
	};

	self.drawBorderChart = function () {
		var model = self.mainData.borderChart;
		var fromYear = self.year() - 2 <= 2017 ? 2018 : self.year() - 2;
		var duration = 'Jan ' + fromYear + ' - ' + self.to() + ' ' + self.year();
		var categories = [];
		var mf = moment(self.from(), 'MMM').month() + 1;
		var mt = moment(self.to(), 'MMM').month() + 1;
		var country = ['Lao', 'Thailand', 'Vietnam'];
		var series = {};

		for (var y = fromYear; y <= self.year() ; y++) {
			for (var m = 1; m <= 12; m++) {
				if (y == self.year() && m > mt) break;
				categories.push(moment(m, 'M').format('MM') + '/' + y.toString().substr(-2));
			}
		}
		var type = [], species = [];
		$('.borderCboxFilter').each(function () {
			if ($(this).prop('checked')) {
				var val = $(this).attr('val');
				if (val == 'F') species.push('PF');
				else if (val == 'V') species.push('PV');
				else if (val == 'M') species.push('Mix');
				else type.push(val);
				return;
			};

			model = model.filter(r => r[$(this).attr('col')] != $(this).attr('val'));
		});

		var filter = '';
		if (type.length == 1) filter = type[0] + ' only';
		else if (type.length > 1) filter = type.join('+');

		if (filter != '') filter += ', ';

		if (species.length == 1) filter += species[0] + ' only';
		else if (species.length > 1) filter += species.join('+');

		country.forEach(c => {
			series[c] = categories.map(my => model.filter(r => r.Country == c && r.MonthYear == my).length);
		});

		$('#chartborder').highcharts({
			chart: { type: 'spline' },
			title: { text: 'Trends in Border Areas, ' + duration },
			subtitle: { text: filter },
			xAxis: { categories: categories, crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of Cases' } },
			tooltip: { shared: true, enabled: !self.isGuest },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ id: 'Lao', name: 'Lao', data: series.Lao, visible: $('#Lao').prop('checked') },
				{ id: 'Thailand', name: 'Thailand', data: series.Thailand, visible: $('#Thailand').prop('checked') },
				{ id: 'Vietnam', name: 'Vietnam', data: series.Vietnam, visible: $('#Vietnam').prop('checked') }
			]
		}, function (chart) {
			self.tickChbox('.borderCbox', chart);
		});

		return true;
	};

	self.drawMapCommuneBorder = function () {
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();

		var laoData = laoCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.Positive];
		});
		var thaiData = thaiCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.Positive];
		});
		var vietData = vietCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.Positive];
		});
		var camData = camCode.map(code => {
			var found = self.mainData.borderMap.find(r => r.Code_Comm_T == code);
			return [code, found == null ? 0 : found.Positive];
		});

		$('#mapCommuneBorder').highcharts('Map', {
			chart: { style: { fontFamily: 'Arial, Helvetica, sans-serif, Verdana' } },
			title: { text: 'All malaria species cases by commune along the border, ' + duration },
			colorAxis: {
				dataClasses: [
					{ name: '0', color: '#F7F7F7' },
					{ from: 1, to: 5, color: 'yellow' },
					{ from: 6, to: 20, color: '#A6C43E' },
					{ from: 21, to: 50, color: 'darkorange' },
					{ from: 50, color: '#BE2B21' }
				]
			},
			legend: {
				title: { text: 'All Positive Cases' },
				layout: 'vertical', align: 'right',
				valueDecimals: 0,
				symbolRadius: 0, symbolWidth: 30, symbolHeight: 15, squareSymbol: false,
				itemMarginTop: 2,
				x: -106,
				y: -85
			},
			exporting: { sourceWidth: 1300, sourceHeight: 600 },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			tooltip: { enabled: true, formatter: drawTooltip },
			series: [
				{
					mapData: Highcharts.maps['chartCountryBorder'],
					nullColor: 'none',
					borderWidth: 0
				},
				{
					mapData: laoMap,
					name: 'Lao',
					borderColor: 'darkviolet',
					data: laoData
				},
				{
					mapData: thaiMap,
					name: 'Thailand',
					borderColor: 'green',
					data: thaiData
				},
				{
					mapData: vietMap,
					name: 'Vietnam',
					borderColor: 'red',
					data: vietData
				},
				{
					mapData: Highcharts.maps['chartCommuneBorder'],
					name: 'Cambodia',
					data: camData
				},
				...drawCountryBorderAndLabel()
			]
		}, drawLegend);
	};

	self.drawMapCommuneBorderPfMix = function () {
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();

		var laoData = laoCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.PfMix];
		});
		var thaiData = thaiCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.PfMix];
		});
		var vietData = vietCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.PfMix];
		});
		var camData = camCode.map(code => {
			var found = self.mainData.borderMapPfMix.find(r => r.Code_Comm_T == code);
			return [code, found == null ? 0 : found.Positive];
		});

		$('#mapCommuneBorderPfMix').highcharts('Map', {
			chart: { style: { fontFamily: 'Arial, Helvetica, sans-serif, Verdana' } },
			title: { text: 'Pf + Mix cases by commune along the border, ' + duration },
			colorAxis: {
				dataClasses: [
                    { name: '0', color: '#F7F7F7' },
                    { from: 1, to: 5, color: 'yellow' },
                    { from: 6, to: 20, color: '#A6C43E' },
                    { from: 21, to: 50, color: 'darkorange' },
                    { from: 50, color: '#BE2B21' }
				]
			},
			legend: {
				title: { text: 'Pf + Mix Cases' },
				layout: 'vertical', align: 'right',
				valueDecimals: 0,
				symbolRadius: 0, symbolWidth: 30, symbolHeight: 15, squareSymbol: false,
				itemMarginTop: 2,
				x: -126,
				y: -85
			},
			exporting: { sourceWidth: 1300, sourceHeight: 600 },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			tooltip: { enabled: true, formatter: drawTooltip },
			series: [
				{
					mapData: Highcharts.maps['chartCountryBorder'],
					nullColor: 'none',
					borderWidth: 0
				},
				{
					mapData: laoMap,
					name: 'Lao',
					borderColor: 'darkviolet',
					data: laoData
				},
				{
					mapData: thaiMap,
					name: 'Thailand',
					borderColor: 'green',
					data: thaiData
				},
				{
					mapData: vietMap,
					name: 'Vietnam',
					borderColor: 'red',
					data: vietData
				},
				{
					mapData: Highcharts.maps['chartCommuneBorder'],
					name: 'Cambodia',
					data: camData
				},
				...drawCountryBorderAndLabel()
			]
		}, drawLegend);
	};

	self.drawMapCommuneBorderPv = function () {
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();

		var laoData = laoCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.Pv];
		});
		var thaiData = thaiCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.Pv];
		});
		var vietData = vietCode.map(code => {
			var found = self.mainData.borderData.find(r => r.PlaceCode == code);
			return [code, found == null ? 0 : found.Pv];
		});
		var camData = camCode.map(code => {
			var found = self.mainData.borderMapPv.find(r => r.Code_Comm_T == code);
			return [code, found == null ? 0 : found.Positive];
		});

		$('#mapCommuneBorderPv').highcharts('Map', {
			chart: { style: { fontFamily: 'Arial, Helvetica, sans-serif, Verdana' } },
			title: { text: 'Pv cases by commune along the border, ' + duration },
			colorAxis: {
				dataClasses: [
                    { name: '0', color: '#F7F7F7' },
                    { from: 1, to: 5, color: 'yellow' },
                    { from: 6, to: 20, color: '#A6C43E' },
                    { from: 21, to: 50, color: 'darkorange' },
                    { from: 50, color: '#BE2B21' }
				]
			},
			legend: {
				title: { text: 'Pv Cases' },
				layout: 'vertical', align: 'right',
				valueDecimals: 0,
				symbolRadius: 0, symbolWidth: 30, symbolHeight: 15, squareSymbol: false,
				itemMarginTop: 2,
				x: -133,
				y: -85
			},
			exporting: { sourceWidth: 1300, sourceHeight: 600 },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			tooltip: { enabled: true, formatter: drawTooltip },
			series: [
				{
					mapData: Highcharts.maps['chartCountryBorder'],
					nullColor: 'none',
					borderWidth: 0
				},
				{
					mapData: laoMap,
					name: 'Lao',
					borderColor: 'darkviolet',
					data: laoData
				},
				{
					mapData: thaiMap,
					name: 'Thailand',
					borderColor: 'green',
					data: thaiData
				},
				{
					mapData: vietMap,
					name: 'Vietnam',
					borderColor: 'red',
					data: vietData
				},
				{
					mapData: Highcharts.maps['chartCommuneBorder'],
					name: 'Cambodia',
					data: camData
				},
				...drawCountryBorderAndLabel()
			]
		}, drawLegend);
	};

	function drawCountryBorderAndLabel() {
		return [
			{
				mapData: Highcharts.maps['chartCountryBorder'],
				nullColor: 'none',
				borderColor: 'black',
				borderWidth: 2
			},
			{
				type: 'mappoint',
				dataLabels: { format: '{point.name}', style: { fontSize: 12 } },
				marker: { enabled: false },
				enableMouseTracking: false,
				showInLegend: false,
				data: [
					{ name: 'Cambodia', lat: 12.5, lon: 105 },
					{ name: 'Lao', lat: 14.8, lon: 107 },
					{ name: 'Thailand', lat: 14, lon: 102 },
					{ name: 'Vietnam', lat: 11, lon: 107.5 }
				]
			}
		];
	}

	function drawLegend() {
		var font = { fontSize: '12px', color: '#333333', fontWeight: 'bold' };
		var x = this.chartWidth - 192;
		var y = this.chartHeight - 90;

		this.renderer.text('Country Boundary', x, y).css(font).add();
		this.renderer.text('Cambodia Admin 3 (Commune)', x, y += 18).css(font).add();
		this.renderer.text('Thailand Admin 3 (Subdistrict)', x, y += 18).css(font).add();
		this.renderer.text('Lao Admin 2 (District)', x, y += 18).css(font).add();
		this.renderer.text('Vietnam Admin 1 (Province)', x, y += 18).css(font).add();

		x -= 34;
		x2 = x + 30;
		y = this.chartHeight - 93;
		this.renderer.path(['M', x, y, 'L', x2, y]).attr({ 'stroke-width': 2, stroke: 'black' }).add();
		this.renderer.path(['M', x, y += 18, 'L', x2, y]).attr({ 'stroke-width': 2, stroke: '#00B0F0' }).add();
		this.renderer.path(['M', x, y += 18, 'L', x2, y]).attr({ 'stroke-width': 2, stroke: 'green' }).add();
		this.renderer.path(['M', x, y += 18, 'L', x2, y]).attr({ 'stroke-width': 2, stroke: 'darkviolet' }).add();
		this.renderer.path(['M', x, y += 18, 'L', x2, y]).attr({ 'stroke-width': 2, stroke: 'red' }).add();

		$(this.renderTo).find('.highcharts-legend-item rect[fill="#F7F7F7"]').attr('stroke', '#00B0F0');

		var pos = this.fromLatLonToPoint({ lat: 12.5, lon: 104.9 });
		this.mapZoom(0.3, pos.x, pos.y);
	}

	function drawTooltip(h) {
		var text = `<b>Country: </b>${this.series.name}<br><b>`;
		text += this.series.name == 'Cambodia' ? 'Commune'
			: this.series.name == 'Thailand' ? 'Subdistrict'
			: this.series.name == 'Lao' ? 'District'
			: 'Province';

		var species = h.chart.legend.title.textStr.replace(' Cases', '');
		text += `: </b> ${this.point.name}<br><b>${species}: </b>${this.point.value} cases`;

		return text;
	}
});