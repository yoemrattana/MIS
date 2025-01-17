if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {
	self.incEstimateCase = ko.observable(true);
	self.selectedYears = ko.observableArray();

	self.odListOption = ko.observableArray();
	self.hcList = ko.observableArray();
	self.pvList = ko.observableArray();

	self.yearTo = ko.observable(moment().year() - 1);
	self.yearFrom = ko.observable(2017);
	self.pvOB = ko.observable();
	self.odOB = ko.observable();
	self.hcOB = ko.observable();
	self.pvAPI = ko.observable();
	self.odAPI = ko.observable();
	self.hcAPI = ko.observable();
	
	self.v = ko.observable(true);
	self.f = ko.observable(true);
	self.m = ko.observable(true);

	var selectedIDs = [];

	self.showTabCNMOutbreakDetectionTool = function () {
		self.submitDetection();
	};

	self.submitDetection = function () {
		var submit = {
			yearFrom: self.yearFrom(),
			yearTo: self.yearTo(),
			pv: self.pvOB(),
			od: self.odOB(),
			hc: self.hcOB(),
			v: self.v() ? 'v' : '',
			f: self.f() ? 'f' : '',
			m: self.m() ? 'm' : '',
			filterDateCase: self.lastSubmit.filterDateCase
		};

		app.ajax('/Dashboard/tabOutbreakDetection', submit).done(function (rs) {
			drawOutbreakDetection(rs);
			self.loaded(true);
		});
	};

	self.pvOB.subscribe(code => {
		self.odListOption(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
	});

	self.odOB.subscribe(code => {
		self.hcList(code == null ? [] : self.place.hc.filter(r => r.odcode == code));
	});

	self.pvAPI.subscribe(code => {
		self.odListOption(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
	});

	self.odAPI.subscribe(code => {
		self.hcList(code == null ? [] : self.place.hc.filter(r => r.odcode == code));
	});

	$(".yrange").click(function () {
		var idSelector = function () { return this.id; };
		var selectedIDs = $("#baseRange :checkbox:checked").map(idSelector).get();
		self.selectedYears(selectedIDs);
	});

	function drawOutbreakDetection(model) {
		if (self.selectedYears().length == 0) self.selectedYears(["2019", "2020", "2021", "2022"]);
		var vmwCompleteness = (model.vmwReportCompleteness).map(r => parseInt(r.Value));
		var hfCompleteness = (model.hfReportCompleteness).map(r => parseInt(r.Value));
		var hfvmwPC = model.hfvmwPC;
		var hfPC = _.filter(hfvmwPC, function (o) { return o.VMW == 0 });

		var vmwPC = _.filter(hfvmwPC, function (o) { return o.VMW == 1 });
		var hfPostiveCases = hfPC.map(r=>r.PositiveCase);
		var vmwPositiveCases = vmwPC.map(r=>r.PositiveCase);

		var hfData = [];
		_.forEach(hfPC, function (o, k) {
			hfData.push({
				Year: o.Year, Month: o.Month, PositiveCase: o.PositiveCase, Completeness: hfCompleteness[k], estimatePC: parseInt((o.PositiveCase * (100 - hfCompleteness[k])) / hfCompleteness[k])
			});
		});

		hfData = _.filter(hfData, function (o) {
			return _.includes(self.selectedYears(), o.Year);
		});

		hfData = _.groupBy(hfData, function (o) {
			return o.Month;
		});

		var vmwData = [];
		_.forEach(vmwPC, function (o, k) {
			vmwData.push({
				Year: o.Year, Month: o.Month, PositiveCase: o.PositiveCase, Completeness: vmwCompleteness[k], estimatePC: parseInt((o.PositiveCase * (100 - vmwCompleteness[k])) / vmwCompleteness[k])
			});
		});

		vmwData = _.filter(vmwData, function (o) {
			return _.includes(self.selectedYears(), o.Year);
		});

		vmwData = _.groupBy(vmwData, function (o) {
			return o.Month;
		});

		var hfUncomplete = [];
		_.forEach(hfPostiveCases, function (val, key) {
			hfUncomplete.push(parseInt((val * (100 - hfCompleteness[key])) / hfCompleteness[key]));
		});

		var vmwUncomplete = [];
		_.forEach(vmwPositiveCases, function (val, key) {
			vmwUncomplete.push(parseInt((val * (100 - vmwCompleteness[key])) / vmwCompleteness[key]));
		});

		var estimateCases = [];
		_.forEach(hfUncomplete, function (val, key) {
			estimateCases.push(isNaN(val + vmwUncomplete[key]) ? 0 : val + vmwUncomplete[key]);
		});

		var obDetection = model.outbreakDetection;

		var obDetectionByY = _.filter(obDetection, function (o) {
			return _.includes(self.selectedYears(), o.Year);
		});

		var obDetectionByM = _.groupBy(obDetectionByY, function (o) {
			return (o.Month)
		});

		var keys = Object.keys(obDetectionByM).sort(); //month
		var baseLine = [];
		var std1 = [];
		var std2 = [];
		_.forEach(keys, function (k) {
			var tmp1 = [];
			var tmp2 = [];
			sumVMW = 0;
			sumHF = 0;
			if (self.incEstimateCase()) {
				var sumVMW = _.reduce(vmwData[k], function (s, a) {
					tmp1.push(a.estimatePC);
					return s + a.estimatePC;
				}, 0);

				var sumHF = _.reduce(hfData[k], function (s, a) {
					tmp2.push(a.estimatePC);
					return s + a.estimatePC;
				}, 0);
			}

			var tmp3 = [];
			var sum = _.reduce(obDetectionByM[k], function (s, a) {
				tmp3.push(a.PositiveCase);
				return s + a.PositiveCase;
			}, 0);
			var tmp = [];
			if (self.incEstimateCase()) {
				tmp3.forEach(function (v, k) {
					tmp.push(tmp1[k] + tmp2[k] + tmp3[k]);
				});
			} else {
				tmp3.forEach(function (v, k) {
					tmp.push(tmp3[k]);
				});
			}

			var stdev = getSD(tmp);
			baseLine.push(sum + sumVMW + sumHF / obDetectionByM[k].length);
			std1.push((sum + sumVMW + sumHF / obDetectionByM[k].length) + stdev);
			std2.push((sum + sumVMW + sumHF / obDetectionByM[k].length) + 2 * stdev)
		});

		var fstd1 = [];
		var fstd2 = [];
		var fbaseLine = [];
		var nyear = obDetection.length / 12;
		for (let i = 0 ; i < nyear ; i++) {
			fbaseLine[i] = _.map(baseLine, _.clone);
			fstd1[i] = _.map(std1, _.clone);
			fstd2[i] = _.map(std2, _.clone);
		}

		var months = ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'];

		$('#OutbreakDetection').highcharts({
			chart: { zoomType: 'x', height:700},
			colors: ['#c0392b', '#ffeaa7', '#17c0eb', '#55efc4', '#fd9644', '#c0392b', 'white'],
			title: { text: 'CNM Outbreak Detection Tool' },
			subtitle: { text: '.' },
			xAxis: {
				gridLineColor: 'transparent', gridLineWidth: 0,
				categories: [
					//{ name: 2015, categories: months },
					//{ name: 2016, categories: months },
					{ name: 2017, categories: months },
					{ name: 2018, categories: months },
					{ name: 2019, categories: months },
					{ name: 2020, categories: months },
                    { name: 2021, categories: months },
                    { name: 2022, categories: months },
				], crosshair: true, gridLineWidth: 1,
				labels: { style: { fontSize: '10px', fontWeight: '700' } }
			},
			tooltip: { shared: true, enabled: !self.isGuest },
			exporting: { sourceWidth: 1500, sourceHeight: 600 },
			yAxis: { minorTickInterval: 'null', labels: { format: '{value}' }, title: { text: 'Number of Malaria Cases' } },
			plotOptions: {
				column: {
					stacking: 'normal',
					borderColor: '#bdc3c7',
					borderWidth: 2,
				}
			},
			series: [
				{ id: 'EC', name: 'Estimated Case', type: 'column', data: estimateCases },
				{ id: 'VMW', name: 'VMW', type: 'column', data: vmwPC.map(r=>parseInt(r.PositiveCase)), dataLabels: { enabled: true, formatter: function () { return vmwCompleteness[this.point.x] + '%' }, inside: true, rotation: -90, style: { fontSize: '8px', textShadow: false, textOutline: false, color: 'black' }, "crop": false, } },
				{ id: 'HF', name: 'HF', type: 'column', data: hfPC.map(r=>parseInt(r.PositiveCase)), dataLabels: { enabled: true, formatter: function () { return hfCompleteness[this.point.x] + '%' }, inside: true, rotation: -90, style: { fontSize: '8px', textShadow: false, textOutline: false, color: 'black' }, "crop": false, } },
				{ id: 'BL', name: 'Base Line', type: 'spline', data: _.flatten(fbaseLine), dashStyle: 'ShortDash', marker: { enabled: false } },
				{ id: 'STD1', name: 'STD 1', type: 'spline', data: (_.flatten(fstd1)).map(r=>parseInt(r)), dashStyle: 'ShortDash', marker: { enabled: false } },
				{ id: 'STD2', name: 'STD 2', type: 'spline', dashStyle: 'ShortDash', data: (_.flatten(fstd2)).map(r=>parseInt(r)), marker: { enabled: false }, },
				{ name: 'xx%: Data Completeness' }
			]
		}, function (chart) {
			self.tickChbox('.obDetection', chart);
		});
	}

	// Standard deviation
	let getSD = function (data) {
		let m = getMean(data);
		return Math.sqrt(data.reduce(function (sq, n) {
			return sq + Math.pow(n - m, 2);
		}, 0) / (data.length - 1));
	};

	let getMean = function (data) {
		return data.reduce(function (a, b) {
			return Number(a) + Number(b);
		}) / data.length;
	};
});