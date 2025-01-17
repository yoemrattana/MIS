function subViewModel(self) {
	self.tableDiff = ko.observableArray();
	self.tableSame = ko.observableArray();
	self.tableFive = ko.observableArray();
	self.tableSummary = ko.observableArray();
	self.tableExpire = ko.observableArray();
	self.tableInvalid = ko.observableArray();
	self.tableAge = ko.observableArray();
	self.tableNonconcordant = ko.observableArray();

	app.ajax('/CRF/getReport').done(function (rs) {
		self.tableDiff(rs.diff.filter(r => r.User1 == null || r.User3 != null));
		self.tableSame(rs.same);
		self.tableFive(rs.five);
		self.tableExpire(rs.expire);
		self.tableInvalid(rs.invalid);
		self.tableAge(rs.age);
		self.tableNonconcordant(rs.nonconcordant);

		Object.keys(self.hcNames).forEach(code => {
			if (!rs.summary.some(r => r.Code == code)) {
				rs.summary.push({ Code: code, Negative: 0, Pf: 0, Pv: 0, Mix: 0, Positive: 0 });
			}
		});
		self.tableSummary(rs.summary.sortasc(r => r.Code));

		drawChart(rs['chart']);
	});

	function drawChart(data) {
		Object.keys(self.hcNames).forEach(code => {
			if (!data.some(r => r.Code == code)) {
				data.push({ Code: code, Qty: 0 });
			}
		});
		data.sortasc(r => r.Code);

		$('#chart').highcharts({
			chart: { type: 'column' },
			title: { text: 'Number of Participants by Health Facility' },
			xAxis: { type: 'category', crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of Participants' } },
			plotOptions: { series: { dataLabels: { enabled: true } } },
			tooltip: { shared: false },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Participants', data: data.map(r =>[self.hcNames[r.Code], r.Qty]) }
			]
		});
	}

	self.getHCName = function (code) {
		return self.hcNames[code.substr(0, 2)];
	};

	self.getHCNameByObj = function (obj) {
		var code = Object.values(obj).find(r => r != null);
		return self.getHCName(code);
	};
}