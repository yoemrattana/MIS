function viewModel() {
	var self = this;

	var report2E = [
		{ id: 'SP_V2_CaseFromHF', name: 'Malaria cases from Public Health Facilities' },
		{ id: 'SP_V2_CaseFromVMW', name: 'Malaria cases from VMWs' },
		{ id: 'SP_V2_HFCompleteness', name: 'Public Health Facility Report Completeness' },
		{ id: 'SP_V2_VMWCompleteness', name: 'VMW Report Completeness' },
		{ id: 'SP_V2_NetStatic', name: 'Nets distribution (Mass Campaign / Mini Mass Campaign)' },
		{ id: 'SP_V2_NetMobile', name: 'Nets distribution (Mobile)' },
		{ id: 'SP_V2_NetContinue', name: 'Nets distribution (Continue)' },
		{ id: 'SP_V2_NetMobileContinue', name: 'Nets distribution (Mobile + Continue)' },
		{ id: 'SP_V2_NetOther', name: 'Other nets distribution' },
		{ id: 'SP_V2_Investigation', name: 'Case Investigation & Reactive Case Detection' },
		{ id: 'SP_V2_HaveStock', name: 'Public Health Facility Without Stock-out' },
		{ id: 'SP_V2_APIALL', name: 'Annual Parasite Incidence of Whole Country' }
	].filter(r => app.user.permiss['Reports V2'].contain('RAI2E ' + r.name));

	var report3E = [
		{ id: 'SP_V2_AnnualCaseCountry', name: 'Annual cases whole country' },
		{ id: 'SP_V2_AnnualCaseOD', name: 'Annual cases endemic ODs' },
		{ id: 'SP_V2_CIFI', name: 'CI & FI' },
		{ id: 'SP_V2_CaseFromHF', name: 'Whole country cases HF' },
		{ id: 'SP_V2_CaseFromVMW', name: 'Malaria Cases VMW' },
		{ id: 'SP_V2_HFCompleteness', name: 'HF Completeness' },
		{ id: 'SP_V2_VMWCompleteness', name: 'VMW Completeness' },
		{ id: 'SP_V2_NetStatic', name: 'Nets distribution (Mass Campaign)' },
		{ id: 'SP_V2_NetMobile', name: 'Nets distribution (Mobile)' },
		{ id: 'SP_V2_NetContinue', name: 'Nets distribution (Continue)' },
		{ id: 'SP_V2_NetOther', name: 'Other nets distribution' },
		{ id: 'SP_V2_HaveStock', name: 'Public Health Facility Without Stock-out' },
		{ id: 'SP_V2_CIFI_CMEP', name: 'CI & FI (CMEP)' }
	].filter(r => app.user.permiss['Reports V2'].contain('RAI3E ' + r.name));

	var report4E = [
		{ id: 'SP_V2_RAI4_Country', name: 'Malaria cases in whole country' },
		{ id: 'SP_V2_RAI4_HF', name: 'Malaria cases from HFs in whole country' },
		{ id: 'SP_V2_RAI4_VMW', name: 'Malaria cases from VMWs' },
		{ id: 'SP_V2_RAI4_PvTreatment', name: 'Pv Radical Cure Treatment' },
		{ id: 'SP_V2_RAI4_CFI', name: 'Case and Foci Investigation' },
		{ id: 'SP_V2_RAI4_NetMass', name: 'Nets distribution (Mass Campaign)' },
		{ id: 'SP_V2_RAI4_NetContinue', name: 'Nets distribution (Continue)' },
		{ id: 'SP_V2_RAI4_NetMobile', name: 'Nets distribution (Mobile)' },
		{ id: 'SP_V2_RAI4_NetOther', name: 'Other nets distribution' },
		{ id: 'SP_V2_RAI4_StockACT', name: 'HFs Without Stock-out of ACT' },
		{ id: 'SP_V2_RAI4_StockRDT', name: 'HFs Without Stock-out of RDT' },
		{ id: 'SP_V2_RAI4_HFCompleteness', name: 'HFs Report Completeness' },
		{ id: 'SP_V2_RAI4_VMWCompleteness', name: 'VMW Report Completeness' },
	].filter(r => app.user.permiss['Reports V2'].contain('RAI4E ' + r.name));

	self.yearList = ko.observableArray();
	self.year = ko.observable(moment().year());
	self.monthList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	self.from = ko.observable('Jan');
	self.to = ko.observable(moment().add(-1, 'months').format('MMM'));
	self.selectedReport = ko.observable();
	self.reportList = ko.observableArray(report4E.length > 0 ? report4E : report3E.length > 0 ? report3E : report2E);
	self.grant = ko.observable(report4E.length > 0 ? 'RAI4E' : report3E.length > 0 ? 'RAI3E' : 'RAI2E');
	self.grantList = [];
	self.visibleBody = ko.observable(false);

	self.SP_V2_HFCompleteness_footer1 = ko.observableArray();
	self.SP_V2_HFCompleteness_footer2 = ko.observableArray();
	self.SP_V2_HFCompleteness_footer3 = ko.observableArray();

	self.SP_V2_VMWCompleteness_footer1 = ko.observableArray();
	self.SP_V2_VMWCompleteness_footer2 = ko.observableArray();
	self.SP_V2_VMWCompleteness_footer3 = ko.observableArray();

	self.SP_V2_RAI4_StockACT_footer1 = ko.observableArray();
	self.SP_V2_RAI4_StockACT_footer2 = ko.observableArray();
	self.SP_V2_RAI4_StockACT_footer3 = ko.observableArray();

	self.SP_V2_RAI4_StockRDT_footer1 = ko.observableArray();
	self.SP_V2_RAI4_StockRDT_footer2 = ko.observableArray();
	self.SP_V2_RAI4_StockRDT_footer3 = ko.observableArray();

	self.SP_V2_RAI4_HFCompleteness_footer1 = ko.observableArray();
	self.SP_V2_RAI4_HFCompleteness_footer2 = ko.observableArray();
	self.SP_V2_RAI4_HFCompleteness_footer3 = ko.observableArray();

	self.SP_V2_RAI4_VMWCompleteness_footer1 = ko.observableArray();
	self.SP_V2_RAI4_VMWCompleteness_footer2 = ko.observableArray();
	self.SP_V2_RAI4_VMWCompleteness_footer3 = ko.observableArray();

	self.SP_V2_Investigation_footer = ko.observable();
	self.SP_V2_CIFI_footer = ko.observableArray();
	self.SP_V2_CIFI_CMEP_footer = ko.observableArray();

	for (var i = 2018; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}
	if (report2E.length > 0) self.grantList.push('RAI2E');
	if (report3E.length > 0) self.grantList.push('RAI3E');
	if (report4E.length > 0) self.grantList.push('RAI4E');

	[report2E, report3E, report4E].forEach(reports => {
		for (var i = 0; i < reports.length; i++) {
			var model = self[reports[i].id] = ko.observableArray();
			model.year = ko.observable();
			model.from = ko.observable();
			model.to = ko.observable();
			reports[i].title = ko.observable();
		}
	});

	self.grant.subscribe(function (value) {
		self.reportList(value == 'RAI2E' ? report2E : value == 'RAI3E' ? report3E : report4E);
		refreshYearList();
	});

	function refreshYearList() {
		if (self.grant() == 'RAI2E') self.yearList([2018, 2019, 2020]);
		else if (self.grant() == 'RAI3E') self.yearList(Array.range(2021, moment().year()));
		else if (self.grant() == 'RAI4E') self.yearList(Array.range(2024, moment().year()));
	}
	refreshYearList();

	self.submit = function () {
		var submit = {
			year: self.year(),
			from: self.monthList.indexOf(self.from()) + 1,
			to: self.monthList.indexOf(self.to()) + 1,
			report: self.selectedReport().id
		};

		app.ajax('/reportv2/getreport/', submit).done(function (data) {
			var rid = submit.report;
			self[rid].year(self.year());
			self[rid].from(self.from());
			self[rid].to(self.to());

			var report = self.selectedReport();
			report.title(report.name + ', ' + self.from() + ' - ' + self.to() + ' ' + self.year());

			if (self[rid + '_fn'] === undefined) self[rid](data);
			else self[rid + '_fn'](data);

			self.visibleBody(true);
		});
	};

	self.selectedReport.subscribe(function (report) {
		self.visibleBody(false);
	});

	self.SP_V2_HFCompleteness_fn = function (data) {
		var footer1 = [], footer2 = [], footer3 = [];
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		var totalHF = data.find(r => r.Name_Prov_E == '# of hf');
		data = data.filter(r => r.Name_Prov_E != '# of hf');

		for (var key in data[0]) {
			if (key.length <= 3) {
				var m = parseInt(key.substr(1));
				if (m >= mf && m <= mt) {
					footer1.push(data.sum(r => parseInt(r[key])));
					footer2.push(totalHF[key]);
					var value = 0;
					if (totalHF[key] > 0) value = footer1.last() / totalHF[key];
					footer3.push(percent(value));
				} else {
					data.forEach(r => delete r[key]);
				}
			}
		}

		if (mf != mt) {
			footer1.push(data.sum(r => parseInt(r.TotalReport)));
			footer2.push(totalHF.TotalReport);
			footer3.push(percent(footer1.last() / footer2.last()));
		} else {
			data.forEach(r => delete r.TotalReport);
		}

		self.SP_V2_HFCompleteness(data);
		self.SP_V2_HFCompleteness_footer1(footer1);
		self.SP_V2_HFCompleteness_footer2(footer2);
		self.SP_V2_HFCompleteness_footer3(footer3);
	};

	self.SP_V2_VMWCompleteness_fn = function (data) {
		var footer1 = [], footer2 = [], footer3 = [];
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		var totalVMW = data.find(r => r.Name_Prov_E == '# of vmw');
		data = data.filter(r => r.Name_Prov_E != '# of vmw');

		for (var key in data[0]) {
			if (key.length <= 3) {
				var m = parseInt(key.substr(1));
				if (m >= mf && m <= mt) {
					footer1.push(data.sum(r => parseInt(r[key])));
					footer2.push(totalVMW[key]);
					var value = 0;
					if (totalVMW[key] > 0) value = footer1.last() / totalVMW[key];
					footer3.push(percent(value));
				} else {
					data.forEach(r => delete r[key]);
				}
			}
		}

		if (mf != mt) {
			footer1.push(data.sum(r => parseInt(r.TotalReport)));
			footer2.push(totalVMW.TotalReport);
			footer3.push(percent(footer1.last() / footer2.last()));
		} else {
			data.forEach(r => delete r.TotalReport);
		}

		self.SP_V2_VMWCompleteness(data);
		self.SP_V2_VMWCompleteness_footer1(footer1);
		self.SP_V2_VMWCompleteness_footer2(footer2);
		self.SP_V2_VMWCompleteness_footer3(footer3);
	};

	self.SP_V2_Investigation_fn = function (data) {
		var totalPfMix = data.sum(r => r.PFMix - r.Referred);
		var totalInv = data.sum(r => r.Investigated);
		var totalL1L2 = data.sum(r => r.L1 + r.L2);
		var totalReac = data.sum(r => r.Reactive);

		var footer = {
			investigation: percent(totalPfMix == 0 ? 0 : totalInv / totalPfMix),
			reactive: percent(totalL1L2 == 0 ? 0 : totalReac / totalL1L2)
		};

		self.SP_V2_Investigation(data);
		self.SP_V2_Investigation_footer(footer);
	};

	self.SP_V2_HaveStock_fn = function (data) {
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		if (mf != 1 || mt != 12) {
			data.forEach(obj => {
				for (var key in obj) {
					var m = key.replace(/\D/g, '');
					if (m == '' || (m >= mf && m <= mt)) continue;
					delete obj[key];
				}
				if (mf == mt) {
					delete obj.TotalACT;
					delete obj.ReportACT;
					delete obj.TotalRDT;
					delete obj.ReportRDT;
				}
			});
		}

		self.SP_V2_HaveStock(data);
	};

	self.SP_V2_CIFI_fn = function (data) {
		self.SP_V2_CIFI(data);

		var footer = [];
		Object.keys(data[0]).forEach((k, i) => {
			if (i < 2) return;
			if (i < 18) {
				footer.push(data.sum(k));
			}
		});

		var positive = data.sum('PfMix') + data.sum('Pv') + data.sum('PmPoPk');
		var notify24 = data.sum('Notify24');
		footer.push((positive == 0 ? 100 : notify24 * 100 / positive).toFixed(0) + '%');

		var classify = data.sum('Classify');
		footer.push(classify, (positive == 0 ? 100 : classify * 100 / positive).toFixed(0) + '%');

		var racdNeed = data.sum('RacdNeed');
		var racd3d = data.sum('Racd3d');
		footer.push(racdNeed, racd3d, (racdNeed == 0 ? 100 : racd3d * 100 / racdNeed).toFixed(0) + '%');

		var fociNeed = data.sum('FociNeed');
		var foci = data.sum('Foci');
		var foci7d = data.sum('Foci7d');
		footer.push(fociNeed, foci, foci7d, (fociNeed == 0 ? 100 : foci7d * 100 / fociNeed).toFixed(0) + '%');

		var fociResponse = data.sum('FociResponse');
		footer.push(fociResponse, (foci == 0 ? 100 : fociResponse * 100 / foci).toFixed(0) + '%');

		self.SP_V2_CIFI_footer(footer);
	};

	self.SP_V2_CIFI_CMEP_fn = function (data) {
		self.SP_V2_CIFI_CMEP(data);

		var footer = [];
		Object.keys(data[0]).forEach((k, i) => {
			if (i < 2) return;
			if (i < 18) {
				footer.push(data.sum(k));
			}
		});

		var positive = data.sum('PfMix') + data.sum('Pv') + data.sum('PmPoPk');
		var notify24 = data.sum('Notify24');
		footer.push((positive == 0 ? 100 : notify24 * 100 / positive).toFixed(0) + '%');

		var classify = data.sum('Classify');
		footer.push(classify, (positive == 0 ? 100 : classify * 100 / positive).toFixed(0) + '%');

		var racdNeed = data.sum('RacdNeed');
		var racd3d = data.sum('Racd3d');
		footer.push(racdNeed, racd3d, (racdNeed == 0 ? 100 : racd3d * 100 / racdNeed).toFixed(0) + '%');

		var fociNeed = data.sum('FociNeed');
		var foci = data.sum('Foci');
		var foci7d = data.sum('Foci7d');
		footer.push(fociNeed, foci, foci7d, (fociNeed == 0 ? 100 : foci7d * 100 / fociNeed).toFixed(0) + '%');

		var fociResponse = data.sum('FociResponse');
		footer.push(fociResponse, (foci == 0 ? 100 : fociResponse * 100 / foci).toFixed(0) + '%');

		self.SP_V2_CIFI_CMEP_footer(footer);
	};

	self.SP_V2_RAI4_StockACT_fn = function (data) {
		var footer1 = [''], footer2 = [], footer3 = [''];
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		var totalHF = data.find(r => r.Name_Prov_E == '# of hf');
		data = data.filter(r => r.Name_Prov_E != '# of hf');

		footer2.push(totalHF['TotalHF']);

		for (var key in data[0]) {
			if (key.length <= 3) {
				var m = parseInt(key.substr(1));
				if (m >= mf && m <= mt) {
					footer1.push(data.sum(r => parseInt(r[key])));
					footer2.push(totalHF[key]);
					var value = 0;
					if (totalHF[key] > 0) value = footer1.last() / totalHF[key];
					footer3.push(percent(value));
				} else {
					data.forEach(r => delete r[key]);
				}
			}
		}

		if (mf != mt) {
			footer1.push(data.sum(r => parseInt(r.TotalReport)));
			footer2.push(totalHF.TotalReport);
			footer3.push(percent(footer1.last() / footer2.last()));
		} else {
			data.forEach(r => delete r.TotalReport);
		}

		self.SP_V2_RAI4_StockACT(data);
		self.SP_V2_RAI4_StockACT_footer1(footer1);
		self.SP_V2_RAI4_StockACT_footer2(footer2);
		self.SP_V2_RAI4_StockACT_footer3(footer3);
	};

	self.SP_V2_RAI4_StockRDT_fn = function (data) {
		var footer1 = [''], footer2 = [], footer3 = [''];
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		var totalHF = data.find(r => r.Name_Prov_E == '# of hf');
		data = data.filter(r => r.Name_Prov_E != '# of hf');

		footer2.push(totalHF['TotalHF']);

		for (var key in data[0]) {
			if (key.length <= 3) {
				var m = parseInt(key.substr(1));
				if (m >= mf && m <= mt) {
					footer1.push(data.sum(r => parseInt(r[key])));
					footer2.push(totalHF[key]);
					var value = 0;
					if (totalHF[key] > 0) value = footer1.last() / totalHF[key];
					footer3.push(percent(value));
				} else {
					data.forEach(r => delete r[key]);
				}
			}
		}

		if (mf != mt) {
			footer1.push(data.sum(r => parseInt(r.TotalReport)));
			footer2.push(totalHF.TotalReport);
			footer3.push(percent(footer1.last() / footer2.last()));
		} else {
			data.forEach(r => delete r.TotalReport);
		}

		self.SP_V2_RAI4_StockRDT(data);
		self.SP_V2_RAI4_StockRDT_footer1(footer1);
		self.SP_V2_RAI4_StockRDT_footer2(footer2);
		self.SP_V2_RAI4_StockRDT_footer3(footer3);
	};

	self.SP_V2_RAI4_HFCompleteness_fn = function (data) {
		var footer1 = [''], footer2 = [], footer3 = [''];
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		var totalHF = data.find(r => r.Name_Prov_E == '# of hf');
		data = data.filter(r => r.Name_Prov_E != '# of hf');

		footer2.push(totalHF['TotalHF']);

		for (var key in data[0]) {
			if (key.length <= 3) {
				var m = parseInt(key.substr(1));
				if (m >= mf && m <= mt) {
					footer1.push(data.sum(r => parseInt(r[key])));
					footer2.push(totalHF[key]);
					var value = 0;
					if (totalHF[key] > 0) value = footer1.last() / totalHF[key];
					footer3.push(percent(value));
				} else {
					data.forEach(r => delete r[key]);
				}
			}
		}

		if (mf != mt) {
			footer1.push(data.sum(r => parseInt(r.TotalReport)));
			footer2.push(totalHF.TotalReport);
			footer3.push(percent(footer1.last() / footer2.last()));
		} else {
			data.forEach(r => delete r.TotalReport);
		}

		self.SP_V2_RAI4_HFCompleteness(data);
		self.SP_V2_RAI4_HFCompleteness_footer1(footer1);
		self.SP_V2_RAI4_HFCompleteness_footer2(footer2);
		self.SP_V2_RAI4_HFCompleteness_footer3(footer3);
	};

	self.SP_V2_RAI4_VMWCompleteness_fn = function (data) {
		var footer1 = [''], footer2 = [], footer3 = [''];
		var mf = self.monthList.indexOf(self.from()) + 1;
		var mt = self.monthList.indexOf(self.to()) + 1;

		var totalVMW = data.find(r => r.Name_Prov_E == '# of vmw');
		data = data.filter(r => r.Name_Prov_E != '# of vmw');

		footer2.push(totalVMW['TotalVMW']);

		for (var key in data[0]) {
			if (key.length <= 3) {
				var m = parseInt(key.substr(1));
				if (m >= mf && m <= mt) {
					footer1.push(data.sum(r => parseInt(r[key])));
					footer2.push(totalVMW[key]);
					var value = 0;
					if (totalVMW[key] > 0) value = footer1.last() / totalVMW[key];
					footer3.push(percent(value));
				} else {
					data.forEach(r => delete r[key]);
				}
			}
		}

		if (mf != mt) {
			footer1.push(data.sum(r => parseInt(r.TotalReport)));
			footer2.push(totalVMW.TotalReport);
			footer3.push(percent(footer1.last() / footer2.last()));
		} else {
			data.forEach(r => delete r.TotalReport);
		}

		self.SP_V2_RAI4_VMWCompleteness(data);
		self.SP_V2_RAI4_VMWCompleteness_footer1(footer1);
		self.SP_V2_RAI4_VMWCompleteness_footer2(footer2);
		self.SP_V2_RAI4_VMWCompleteness_footer3(footer3);
	};

	self.footerTotal = function (data, fromIndex) {
		var rs = [];
		var i = 0;
		for (var key in data[0]) {
			if (i >= fromIndex) {
				var v = data.sum(r => toFloat(r[key]));
				rs.push(isNaN(v) ? 'NA' : v);
			}
			i++;
		}
		return rs;
	};

	self.exportExcel = function () {
		var rid = self.selectedReport().id;
		var model = self[rid];
		var data = model();

		if (self[rid + '_footer2'] != null) data = [data, self[rid + '_footer2']()];

		var submit = {
			year: model.year(),
			from: model.from(),
			to: model.to(),
			report: rid,
			json: JSON.stringify(data)
		};

		app.downloadBlob('reportv2/exportExcel', submit).done(function (blob) {
			var filename = rid.replace('SP_V2_', '') + ' ' + model.year() + ' ' + model.from() + '-' + model.to() + '.xlsx';
			saveAs(blob, filename); //from FileSaver.js
		});
	};

	self.isRight = function (value) {
		return value == 'NA' || !isNaN(value);
	};

	self.visibleMonth = function (m) {
		var rid = self.selectedReport().id;
		var model = self[rid];
		var mf = moment(model.from(), 'MMM').month();
		var mt = moment(model.to(), 'MMM').month();
		return m >= mf && m <= mt;
	};

	self.countMonth = function () {
		var rid = self.selectedReport().id;
		var model = self[rid];
		var mf = moment(model.from(), 'MMM').month();
		var mt = moment(model.to(), 'MMM').month();
		return mt - mf + 1;
	};

	function percent(value) {
		return Math.round(value * 100) + '%';
	}
};