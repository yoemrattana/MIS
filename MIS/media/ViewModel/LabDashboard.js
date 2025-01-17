function viewModel() {
	var self = this;

	self.dash = ko.observable(2);
	self.year = moment().year();
	self.yearList = Array.range(2024, moment().year());
	self.reportYear = ko.observable();
	self.loaded1 = ko.observable(false);
	self.loaded2 = ko.observable(false);
	self.loaded3 = ko.observable(false);
	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.training = ko.observable();

	self.totalCase = ko.observable();
	self.monthlyCase = ko.observableArray();
	self.logbook = ko.observableArray();
	self.crosscheck = ko.observableArray();
	self.reference = ko.observableArray();
	self.panel = ko.observableArray();
	self.staff = ko.observableArray();

	self.basic = ko.observableArray();
	self.refresher = ko.observableArray();
	self.ncamm = ko.observableArray();
	self.preecamm = ko.observableArray();
	self.ecamm = ko.observableArray();

	self.dash2Table = ko.observableArray();

	var place = null;

	$('.menu').each(function () {
		if (!app.user.permiss['Lab'].contain(this.innerHTML)) $(this).remove();
		else if ($(this).attr('href') == location.pathname) $(this).addClass('active');
	});

	app.getPlace(['pv'], function(p) {
		place = p;
		self.pvList(place.pv);

		self.viewClick();
	});

	self.viewClick = function () {
		self.dash() == 1 ? getDashboard1()
			: self.dash() == 2 ? getDashboard2()
			: getDashboard3();
	};

	function getDashboard1() {
		var submit = { year: self.year };
		app.ajax('/Lab/getDashboard1', submit).done(function (rs) {
			self.loaded1(true);
			self.reportYear(self.year);

			self.totalCase(rs.totalCase);

			var arr = rs.monthlyCase.groupby('Name_Prov_E').map(r => {
				return {
					province: r[0].Name_Prov_E,
					months: Array.range(1, 12).map(i => r.find(x => x.Month == i)),
					Q1: [1, 2, 3].sum(i => r.find(x => x.Month == i)?.Total ?? 0),
					Q2: [4, 5, 6].sum(i => r.find(x => x.Month == i)?.Total ?? 0),
					Q3: [7, 8, 9].sum(i => r.find(x => x.Month == i)?.Total ?? 0),
					Q4: [10, 11, 12].sum(i => r.find(x => x.Month == i)?.Total ?? 0)
				};
			});
			self.monthlyCase(arr.sortasc('province'));

			rs.logbook.forEach(r => {
				var f = self.monthlyCase().find(x => x.province == r.Name_Prov_E);

				r.Q1 = f.Q1 == 0 ? '-' : (r.Q1 * 100 / f.Q1).toFixed(0) + '%';
				r.Q2 = f.Q2 == 0 ? '-' : (r.Q2 * 100 / f.Q2).toFixed(0) + '%';
				r.Q3 = f.Q3 == 0 ? '-' : (r.Q3 * 100 / f.Q3).toFixed(0) + '%';
				r.Q4 = f.Q4 == 0 ? '-' : (r.Q4 * 100 / f.Q4).toFixed(0) + '%';

				updateQ(r);
			});
			self.logbook(rs.logbook);

			rs.crosscheck.forEach(r => {
				r.Q1 = r.Q1 == null ? '-' : r.Q1 + '%';
				r.Q2 = r.Q2 == null ? '-' : r.Q2 + '%';
				r.Q3 = r.Q3 == null ? '-' : r.Q3 + '%';
				r.Q4 = r.Q4 == null ? '-' : r.Q4 + '%';

				updateQ(r);
			});
			self.crosscheck(rs.crosscheck);

			rs.reference.forEach(r => {
				r.Q1 = r.Q1 == null ? '-' : r.Q1 + '%';
				r.Q2 = r.Q2 == null ? '-' : r.Q2 + '%';
				r.Q3 = r.Q3 == null ? '-' : r.Q3 + '%';
				r.Q4 = r.Q4 == null ? '-' : r.Q4 + '%';

				updateQ(r);
			});
			self.reference(rs.reference);

			rs.panel.forEach(r => {
				r.S1 = r.S1 == null ? '-' : r.S1 + '%';
				r.S2 = r.S2 == null ? '-' : r.S2 + '%';

				updateS(r);
			});
			self.panel(rs.panel);

			self.staff(rs.staff);

			updateTraining(rs, 'basic');
			updateTraining(rs, 'refresher');
			updateTraining(rs, 'ncamm');
			updateTraining(rs, 'preecamm');
			updateTraining(rs, 'ecamm');

			drawChart();
		});
	}

	function getDashboard2() {
		var submit = { pv: self.pv() };
		app.ajax('/Lab/getDashboard2', submit).done(function (rs) {
			self.loaded2(true);

			drawD2MainChart(rs.main);

			calculateData(rs.tbl);
			self.dash2Table(rs.tbl);
		});
	}

	function getDashboard3() {
		var submit = { pv: self.pv() };
		app.ajax('/Lab/getDashboard3', submit).done(function (rs) {
			self.loaded3(true);
			
			drawD2SubChart(rs);
		});
	}

	self.checkMonth = function (i) {
		return moment().year(self.year).month(i).format('YYYYMM') <= moment().format('YYYYMM');
	};

	function updateQ(r) {
		if (self.year == moment().year()) {
			if (moment().month() + 1 < 10) r.Q4 = '';
			if (moment().month() + 1 < 7) r.Q3 = '';
			if (moment().month() + 1 < 4) r.Q2 = '';
		}
	}

	function updateS(r) {
		if (self.year == moment().year()) {
			if (moment().month() + 1 < 7) r.S2 = '';
		}
	}

	function updateTraining(rs, name) {
		var arr = rs[name].map(r => r.Name_Prov_E).distinct().map(p => {
			return {
				province: p,
				list: self.yearList.map(y => rs[name].find(r => r.Name_Prov_E == p && r.Year == y)?.Qty ?? 0)
			};
		});
		self[name](arr.sortasc('province'));
	}

	function drawChart() {
		var cat = [];
		var data = [];

		Array.range(2024, moment().year()).forEach(y => {
			var i = y - 2024;
			var ncamm = self.ncamm().sum(r => r.list[i]);
			var ecamm = self.ecamm().sum(r => r.list[i]);
			var preecamm = self.preecamm().sum(r => r.list[i]);
			var basic = self.basic().sum(r => r.list[i]);
			var refresher = self.refresher().sum(r => r.list[i]);

			if (ncamm > 0) {
				cat.push(y + ' NCAMM');
				data.push(ncamm);
			}
			if (ecamm > 0) {
				cat.push(y + ' ECAMM');
				data.push(ecamm);
			}
			if (preecamm > 0) {
				cat.push(y + ' PRE-ECAMM');
				data.push(preecamm);
			}
			if (basic > 0) {
				cat.push(y + ' Basic');
				data.push(basic);
			}
			if (refresher > 0) {
				cat.push(y + ' Refresher');
				data.push(refresher);
			}
		});

		Highcharts.chart('chart', {
			chart: { type: 'column' },
			title: { text: 'Laboratory Training' },
			xAxis: { categories: cat, labels: { style: { fontWeight: 'bold' } } },
			yAxis: { title: { text: '' }, allowDecimals: false },
			series: [{ 
				name: 'Training',
				data: data,
				showInLegend: false,
				dataLabels: { enabled: true } 
			}]
		});
	}

	function drawD2MainChart(rs) {
		var category = rs.map(r => r.Year).distinct();
		
		rs = calculateData(rs);
		
		var prov = self.pv() == null ? 'Cambodia' : place.pv.find(r => r.code == self.pv()).name;

		Highcharts.chart('D2MainChart', {
			chart: { type: 'column' },
			title: { text: 'Trend of Microscopy Training Coverage and Competency Assessment from 2018 to 2026 in ' + prov },
			xAxis: { categories: category, labels: { style: { fontWeight: 'bold' } }, crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: '' }, allowDecimals: false, labels: { format: '{value}%' }, max: 100 },
			tooltip: { shared: true, valueSuffix: '%' },
			exporting: { sourceWidth: 1500 },
			series: [
				{ name: 'Microscopist Population', data: rs.map(r => r.MicroPercent) },

				{ name: 'Eligibility for BMMT', data: rs.map(r => r.BasicEligiblePercent) },
				{ name: 'BMMT Output', data: rs.map(r => r.BasicOutputPercent) },
				{ name: 'BMMT Outcome', data: rs.map(r => r.BasicOutcomePercent) },
				
				{ name: 'Eligibility for RMMT', data: rs.map(r => r.RefresherEligiblePercent) },
				{ name: 'RMMT Output', data: rs.map(r => r.RefresherOutputPercent) },
				{ name: 'RMMT Outcome', data: rs.map(r => r.RefresherOutcomePercent) },
				
				{ name: 'Eligibility for NCAMM', data: rs.map(r => r.NCAMMEligiblePercent) },
				{ name: 'NCAMM Output', data: rs.map(r => r.NCAMMOutputPercent) },
				{ name: 'NCAMM Outcome', data: rs.map(r => r.NCAMMOutcomePercent) },
				
				{ name: 'Eligibility for ECAMM', data: rs.map(r => r.ECAMMEligiblePercent) },
				{ name: 'ECAMM Output', data: rs.map(r => r.ECAMMOutputPercent) },
				{ name: 'ECAMM Outcome', data: rs.map(r => r.ECAMMOutcomePercent) }
			]
		});
	}

	function drawD2SubChart(rs) {
		rs = rs.groupby('Year', 'Name_Prov_E', 'Name_OD_E').map(g => {
			var r = g[0];
			
			r.LabTechnician = g.sum('LabTechnician'),
			r.MicroPop = g.sum('MicroPop'),
			r.BasicEligible = g.sum('BasicEligible'),
			r.BasicOutput = g.sum('BasicOutput'),
			r.BasicOutcome = g.sum('BasicOutcome'),
			r.RefresherEligible = g.sum('RefresherEligible'),
			r.RefresherOutput = g.sum('RefresherOutput'),
			r.RefresherOutcome = g.sum('RefresherOutcome'),
			r.NCAMMEligible = g.sum('NCAMMEligible'),
			r.NCAMMOutput = g.sum('NCAMMOutput'),
			r.NCAMMOutcome = g.sum('NCAMMOutcome'),
			r.ECAMMEligible = g.sum('ECAMMEligible'),
			r.ECAMMOutput = g.sum('ECAMMOutput'),
			r.ECAMMOutcome = g.sum('ECAMMOutcome')

			return r
		});
		rs = calculateData(rs);

		var years = rs.map(r => r.Year).distinct().sortasc();
		var ods = rs.map(r => r.Name_OD_E).distinct().sortasc();
		var category = [];
		var data = Array.range(0, 13).map(r => []);

		var keys = [
			'', 'MicroPercent',
			'BasicEligiblePercent', 'BasicOutputPercent', 'BasicOutcomePercent', 
			'RefresherEligiblePercent', 'RefresherOutputPercent', 'RefresherOutcomePercent',
			'NCAMMEligiblePercent', 'NCAMMOutputPercent', 'NCAMMOutcomePercent',
			'ECAMMEligiblePercent', 'ECAMMOutputPercent', 'ECAMMOutcomePercent'
		];

		years.forEach(y => {
			ods.forEach(od => {
				category.push(y + '<br>' + od);
				keys.forEach((k, i) => {
					if (i == 0) return;
					data[i].push(rs.find(r => r.Year == y && r.Name_OD_E == od)?.[k] ?? 0);
				});
			});
		});

		var titles = [
			'', 'Microscopist Population',

			'Microscopist Eligible for Basic Malaria Microscopy Training',
			'Microscopist attended for Basic Malaria Microscopy Training',
			'Microscopist got more than 80% Score for Basic Malaria Microscopy Training',
			
			'Microscopist Eligible for Refresher Malaria Microscopy Training',
			'Microscopist attended for Refresher Malaria Microscopy Training',
			'Microscopist got more than 80% Score for Refresher Malaria Microscopy Training',

			'Microscopist Eligible for National Competency Assessment Malaria Microscopy (NCAMM)',
			'Microscopist attended for National Competency Assessment Malaria Microscopy (NCAMM)',
			'Microscopist got Level A and B for National Competency Assessment Malaria Microscopy (NCAMM)',

			'Microscopist Eligible for External Competency Assessment Malaria Microscopy (ECAMM)',
			'Microscopist attended for External Competency Assessment Malaria Microscopy (ECAMM)',
			'Microscopist got Level 1 and 2 for External Competency Assessment Malaria Microscopy (ECAMM)'
		];

		var from = {
			'BMMT': 2,
			'RMMT': 5,
			'NCAMM': 8,
			'ECAMM': 11
		}[self.training()];

		for (var i = from, n = 1; i <= from + 2; i++, n++) {
			Highcharts.chart('D2SubChart' + n, {
				chart: { type: 'column' },
				title: { text: `Percentage of ${titles[i]} from 2018 to ${moment().year()} in ` + rs[0].Name_Prov_E },
				xAxis: { categories: category, labels: { style: { fontWeight: 'bold' }, crosshair: true, gridLineWidth: 1, rotation: -45 } },
				yAxis: { title: { text: '' }, allowDecimals: false, labels: { format: '{value}%' }, max: 100 },
				tooltip: { enabled: false },
				legend: { enabled: false },
				plotOptions: { series: { dataLabels: { enabled: true, format: '{y}%' } } },
				exporting: { sourceWidth: 1500 },
				series: [
					{ name: 'Percentage', data: data[i], color: Highcharts.getOptions().colors[i > 9 ? i - 10 : i - 1] }
				]
			});
		}
	}

	function calculateData(rs) {
		rs.forEach(r => {
			r.MicroPercent = Math.round(r.MicroPop / r.LabTechnician * 100) || 0;
			{
				r.BasicEligiblePercent = Math.round(r.BasicEligible / r.LabTechnician * 100) || 0;

				r.BasicOutput > r.BasicEligible && (r.BasicOutput = r.BasicEligible);
				r.BasicOutputPercent = Math.round(r.BasicOutput / r.BasicEligible * 100) || 0;

				r.BasicOutcome > r.BasicOutput && (r.BasicOutcome = r.BasicOutput);
				r.BasicOutcomePercent = Math.round(r.BasicOutcome / r.BasicOutput * 100) || 0;
			}
			{
				r.RefresherEligiblePercent = Math.round(r.RefresherEligible / r.LabTechnician * 100) || 0;

				r.RefresherOutput > r.RefresherEligible && (r.RefresherOutput = r.RefresherEligible);
				r.RefresherOutputPercent = Math.round(r.RefresherOutput / r.RefresherEligible * 100) || 0;

				r.RefresherOutcome > r.RefresherOutput && (r.RefresherOutcome = r.RefresherOutput);
				r.RefresherOutcomePercent = Math.round(r.RefresherOutcome / r.RefresherOutput * 100) || 0;
			}
			{
				r.NCAMMEligiblePercent = Math.round(r.NCAMMEligible / r.LabTechnician * 100) || 0;

				r.NCAMMOutput > r.NCAMMEligible && (r.NCAMMOutput = r.NCAMMEligible);
				r.NCAMMOutputPercent = Math.round(r.NCAMMOutput / r.NCAMMEligible * 100) || 0;

				r.NCAMMOutcome > r.NCAMMOutput && (r.NCAMMOutcome = r.NCAMMOutput);
				r.NCAMMOutcomePercent = Math.round(r.NCAMMOutcome / r.NCAMMOutput * 100) || 0;
			}
			{
				r.ECAMMEligiblePercent = Math.round(r.ECAMMEligible / r.LabTechnician * 100) || 0;

				r.ECAMMOutput > r.ECAMMEligible && (r.ECAMMOutput = r.ECAMMEligible);
				r.ECAMMOutputPercent = Math.round(r.ECAMMOutput / r.ECAMMEligible * 100) || 0;

				r.ECAMMOutcome > r.ECAMMOutput && (r.ECAMMOutcome = r.ECAMMOutput);
				r.ECAMMOutcomePercent = Math.round(r.ECAMMOutcome / r.ECAMMOutput * 100) || 0;
			}
		});
		
		return rs;
	}
}