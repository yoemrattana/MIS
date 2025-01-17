function viewModel() {
	var self = this;

	self.tableDiff = ko.observableArray();
	self.tableMonthCount = ko.observable();
	self.ready = ko.observable(false);

	var hcNames = {
		'01': 'Trapeang Cho',
		'02': 'Phnom Kravanh',
		'03': 'Pramaoy',
		'04': 'Samraong',
		'05': 'Chambak',
		'06': 'Monor Rung Roeang',
		'07': 'Phnom Kravanh_RH',
		'08': 'Prongil',
		'09': 'Kampong Speu RH',
		'10': 'Cheung Roas Samaki',
		'11': 'Anglong Reap',
		'12': 'Chheu Tom',
		'13': 'Boeng Kantuot',
		'14': 'Ta Lat',
		'15': 'Chhouk Meas',
		'16': 'Pursat RH',
		'17': 'Svay Chochep',
		'18': 'Trapeang Kraloeung',
		'19': 'Bakan RH',
		'20': 'Ro Leab'
	};

	app.ajax('/RDTReader/getReport').done(function (rs) {
		self.ready(true);

		rs.diffRDT.forEach(r => {
			r.ScanTime = moment(parseInt(r.ScanTime)).utcOffset(7);
		});

		drawTableDiff(rs);
		drawChartDuplicate(rs.duplicate);
		drawChartUndefined(rs.error);
		drawTableMonthCount(rs.monthCount);
	});

	function drawTableDiff(rs) {
		rs.diffUser.forEach(r => {
			r.User1Time = moment(r.User1Date + 'T' + r.User1Time + '+07:00').utcOffset(7);
			r.ScanTime = null;
			r.MinDiff = null;

			var code = 'AM002' + r.ParticipantCode;
			var arr = rs.diffRDT.filter(x => x.patient_id == code);

			for (var i = 0; i < arr.length; i++) {
				var item = arr[i];
				var m = item.ScanTime.diff(r.User1Time, 'minute');

				function replace() {
					r.ScanTime = item.ScanTime;
					r.MinDiff = m;
				}

				if (m > 0 && m < 16) { replace(); break; }
				else if (r.MinDiff == null) replace();
				else if (r.MinDiff < 0 && m >= 0) replace();
				else if (r.MinDiff < 0 && m < 0 && m > r.MinDiff) replace();
				else if (r.MinDiff > 0 && m > 0 && m < r.MinDiff) replace();
			}
		});

		rs.diffUser = rs.diffUser.filter(r => r.MinDiff < 0 || r.MinDiff > 15);
		self.tableDiff(rs.diffUser.sortasc(r => r.ParticipantCode));
	}

	function drawChartDuplicate(data) {
		$('#chartDuplicate').highcharts({
			chart: { type: 'lollipop' },
			title: { text: 'Average of Number of Times Taken Photo by Health Facility' },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: {
				title: { text: 'Average of Times' }, tickInterval: 1, min: 0,
				plotLines: [{ color: 'red', width: 2, value: 1 }]
			},
			tooltip: { enabled: false },
			plotOptions: { series: { marker: { radius: 8 }, dataLabels: { enabled: true, y: -5 } } },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [{
				name: 'Average',
				data: data.map(r => {
					return {
						name: hcNames[r.Code],
						low: parseFloat(parseFloat(r.Avg).toFixed(1))
					};
				})
			}]
		});
	}

	function drawChartUndefined(data) {
		var list = data.sortasc(r => r.code).groupby('code').map(arr => {
			var patients = arr.groupby('patient_id');
			return {
				Code: arr[0].code,
				Undefined: patients.filter(a => a.some(r => r.error == 'undefined')).length,
				Other: patients.filter(a => a.every(r => r.error != 'undefined')).length
			};
		});

		$('#chartUndefined').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of Undefined Errors and Other Errors by Health Facility' },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number' } },
			plotOptions: { series: { dataLabels: { enabled: true } } },
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Undefined Errors', data: list.map(r =>[hcNames[r.Code], r.Undefined]) },
				{ name: 'Other Errors', data: list.map(r =>[hcNames[r.Code], r.Other]) }
			]
		});

		$('#chartComplete').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of Undefined-Error of RDT Images by Health Facility' },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number' } },
			plotOptions: { series: { dataLabels: { enabled: true } } },
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Undefined-Error of RDT Images', data: list.map(r =>[hcNames[r.Code], r.Undefined]) }
			]
		});
	}

	function drawTableMonthCount(data) {
		var months = data.map(r => r.Month).distinct().sortasc();
		var hfs = data.map(r => r.SiteCode).distinct().sortasc().map(code => {
			return {
				name: hcNames[code],
				items: months.map(m => {
					var found = data.find(r => r.SiteCode == code && r.Month == m);
					return {
						test: found == null ? 0 : found.Test,
						positive: found == null ? 0 : found.Positive,
						pf: found == null ? 0 : found.Pf,
						pv: found == null ? 0 : found.Pv,
						mix: found == null ? 0 : found.Mix,
						patient: found == null ? 0 : found.PatientCount
					};
				})
			};
		});
		self.tableMonthCount({ months: months, hfs: hfs });
	}

	self.getHCName = function (code) {
		return hcNames[code.substr(0, 2)];
	};
}