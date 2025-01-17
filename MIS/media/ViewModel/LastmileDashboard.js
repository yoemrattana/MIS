function viewModel() {
	var self = this;

	self.yearList = [];
	self.monthList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

	self.year = ko.observable(moment().year());
	self.mf = ko.observable('Jan');
	self.mt = ko.observable(moment().format('MMM'));
	self.loaded = ko.observable(false);

	self.table = ko.observableArray();

	for (var i = 2021; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}

	self.viewClick = function () {
		var submit = {
			year: self.year(),
			mf: convertMonth(self.mf()),
			mt: convertMonth(self.mt())
		};

		app.ajax('/LastmileDashboard/getData', submit).done(function (rs) {
			drawCountVillage(rs);
			drawCountHouse(rs);
			drawPeoplePositive(rs);
			drawPercentIPT(rs);
			drawPercentTDA(rs);
			drawNumberIPTTDA(rs);
			self.table(rs.table);

			self.loaded(true);
		});
	};
	self.viewClick();

	function convertMonth(mmm) {
		return moment(mmm, 'MMM').format('MM');
	}

	function drawCountVillage(rs) {
		var data = rs.countVillage;
		var duration = self.year();

		$('#countVillage').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of Eligible Lastmile Villages, ' + duration },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of Villages' } },
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Lastmile Village', data: data.map(r =>[r.Name_Prov_E, r.Village]) }
			]
		});
	}

	function drawCountHouse(rs) {
		var data = rs.countHouse;
		var duration = self.mf() + '-' + self.mt() + ' ' + self.year();

		$('#countHouse').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of Lastmile Villages and Households, ' + duration },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'Number of Villages' } }, { title: { text: 'Number of Households' }, opposite: true }],
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Lastmile Village', data: data.map(r =>[r.Name_Prov_E, r.Village]) },
				{ name: 'Household', data: data.map(r =>[r.Name_Prov_E, r.House]), yAxis: 1 }
			]
		});
	}

	function drawPeoplePositive(rs) {
		var data = rs.peoplePositive;
		var duration = self.mf() + '-' + self.mt() + ' ' + self.year();

		var x = data.sum('People') / data.length;
		var y = data.sum('Positive') / data.length;
		var m = data.sum(r => Math.pow(r.People - x, 2));
		var n = data.sum(r => (r.People - x) * (r.Positive - y));
		var b1 = n / m;
		var b2 = y - (b1 * x);
		var maxPeople = data.last().People;
		var a = data.sum(r => Math.pow(((r.People * b1) + b2) - y, 2));
		var b = data.sum(r => Math.pow(r.Positive - y, 2));
		var r2 = a / b;

		$('#peoplePositive').highcharts({
			title: { text: 'Comparision Between Target People and Malaria Cases, ' + duration },
			xAxis: { title: { text: 'Target People' } },
			yAxis: { title: { text: 'Malaria Cases' } },
			tooltip: {
				headerFormat: '{point.key}<br>',
				pointFormat: '<span style="color:{point.color}">●</span> Target People: <b>{point.x}</b><br>'
					+ '<span style="color:{point.color}">●</span> Malaria Case: <b>{point.y}</b>'
			},
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{
					type: 'scatter',
					name: 'Lastmile Village',
					color: Highcharts.getOptions().colors[2],
					data: data.map(r => {
						return {
							name: `OD: <b>${r.Name_OD_E}</b><br>`
								+ `HC: <b>${r.Name_Facility_E}</b><br>`
								+ `Village: <b>${r.Name_Vill_E}</b><br>`,
							x: r.People,
							y: r.Positive
						};
					})
				}, {
					type: 'line',
					name: 'Liner',
					data: [[0, b2], [maxPeople, (maxPeople * b1) + b2]],
					marker: { enabled: false },
					enableMouseTracking: false
				}
			]
		}, function () {
			var plus = b2 >= 0 ? '+' : '-';
			var text = `y = ${b1.toFixed(4)}x ${plus} ${b2.toFixed(4)}<br>`
					 + `R<sup>2</sup> = ${r2.toFixed(4)}`;

			var x = this.chartWidth / 2 + 110;
			var y = this.chartHeight - 40;
			this.renderer.text(text, x, y, true).add();
		});
	}

	function drawPercentIPT(rs) {
		var data = rs.percentIPTTDA.sortasc('IPT');
		var duration = self.mf() + '-' + self.mt() + ' ' + self.year();

		$('#percentIPT').highcharts({
			chart: { type: 'column' },
            title: { text: 'Percentage of IPT (Target) by Village, ' + duration },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1, labels: { rotation: -45 } },
			yAxis: { title: { text: 'Percentage' }, labels: { format: '{value}%' }, allowDecimals: false, max: 100 },
			tooltip: { shared: true, valueSuffix: '%', headerFormat: '{point.point.custom}<br>' },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [{
				name: 'IPT',
				data: data.map(r => {
					return {
						name: r.Name_Vill_E,
						y: r.IPT,
						custom: `OD: <b>${r.Name_OD_E}</b><br>`
							+ `HC: <b>${r.Name_Facility_E}</b><br>`
							+ `Village: <b>${r.Name_Vill_E}</b><br>`
					}
				})
			}]
		});
	}

	function drawPercentTDA(rs) {
		var data = rs.percentIPTTDA.sortasc('TDA');
		var duration = self.mf() + '-' + self.mt() + ' ' + self.year();

		$('#percentTDA').highcharts({
			chart: { type: 'column' },
			title: { text: 'Percentage of TDA (Target) by Village, ' + duration },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1, labels: { rotation: -45 } },
			yAxis: { title: { text: 'Percentage' }, labels: { format: '{value}%' }, allowDecimals: false, max: 100 },
			tooltip: { shared: true, valueSuffix: '%', headerFormat: '{point.point.custom}<br>' },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [{
				name: 'TDA',
				color: Highcharts.getOptions().colors[1],
				data: data.map(r => {
					return {
						name: r.Name_Vill_E,
						y: r.TDA,
						custom: `OD: <b>${r.Name_OD_E}</b><br>`
							+ `HC: <b>${r.Name_Facility_E}</b><br>`
							+ `Village: <b>${r.Name_Vill_E}</b><br>`
					}
				})
			}]
		});
	}

	function drawNumberIPTTDA(rs) {
		var arrIPT = rs.numberIPTTDA.filter(r => r.IPT > 0);
		var arrTDA = rs.numberIPTTDA.filter(r => r.TDA > 0);

		arrIPT = arrIPT.groupby('IPT').map(r => {
			return {
				IPT: r[0].IPT + ' time' + (r[0].IPT > 1 ? 's' : ''),
				People: r.length
			};
		});

		arrTDA = arrTDA.groupby('TDA').map(r => {
			return {
				TDA: r[0].TDA + ' time' + (r[0].TDA > 1 ? 's' : ''),
				People: r.length
			};
		});

		$('#numberIPTTDA').highcharts({
			chart: { type: 'column' },
            title: {
                text: 'Number of People received IPT (' + self.year() + ') and TDA1 + TDA2'  },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of People' } },
			tooltip: { shared: true, valueSuffix: ' people' },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'IPT', data: arrIPT.map(r =>[r.IPT, r.People]) },
				{ name: 'TDA', data: arrTDA.map(r =>[r.TDA, r.People]) }
			]
		});
	}
}