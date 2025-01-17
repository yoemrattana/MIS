function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.masterModel = ko.observable();
	self.detailModel = ko.observable();
	self.detailVMW = ko.observable();
	self.detailIntegrated = ko.observable();
	self.supervisionModel = ko.observable();
	self.monitorList = ko.observableArray();
	self.reportModel = ko.observable();
	self.view = ko.observable('list');
	self.menu = ko.observable();

	self.pvList = ko.observableArray();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.vlList = ko.observableArray();
	self.yearList = [];
	self.monthList = [];

	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.vl = ko.observable();
	self.year = ko.observable(moment().year());
	self.month = ko.observable(moment().format('MM'));

	self.supervisionLoaded = ko.observable(false);
	self.reportLoaded = ko.observable(false);

	self.pvList2 = ko.observableArray();

	var place = null;
	var monitorLoaded = false;
	var lastScrollY = 0;
	var rowLimit = app.newRowLimit(200);

	for (var i = 2020; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}

	for (var i = 1; i <= 12; i++) {
		self.monthList.push(('0' + i).substr(-2));
	}

	self.menuClick = function (root, event) {
		var element = $(event.currentTarget);
		element.removeClass('btn-info btn-default').addClass('btn-info');
		element.siblings().removeClass('btn-info btn-default').addClass('btn-default');
		self.menu(element.text());

		if ((self.menu() || '').contain('Questionnaire Form')) showForm();
		else if (self.menu() == 'Monitor') showMonitor();
		else if (self.menu() == 'Dashboard') self.showDashboard();
	};

	function showForm() {
		app.ajax('/VMWQA/getList').done(function (rs) {
			rs.forEach(r => {
				if (r.Section2 != null) r.Section2 = parseFloat(r.Section2);
				if (r.Section3 != null) r.Section3 = parseFloat(r.Section3);
				if (r.Section4 != null) r.Section4 = parseFloat(r.Section4);
				if (r.Section5 != null) r.Section5 = parseFloat(r.Section5);
				if (r.Section6 != null) r.Section6 = parseFloat(r.Section6);
				if (r.Section7 != null) r.Section7 = parseFloat(r.Section7);
				if (r.TotalScore != null) r.TotalScore = parseFloat(r.TotalScore);
			});

			self.listModel(rs);
		});
	}

	self.showReport = function () {
		if (self.menu() == 'Supervision Schedule') showSupervision();
		else if (self.menu() == 'Report') showReport();
		else if (self.menu() == 'Dashboard') self.getDashboardData();
	};

	function showSupervision() {
		var submit = {
			pvcode: self.pv(),
			odcode: self.od(),
			hccode: self.hc(),
			vlcode: self.vl()
		};
		app.ajax('/VMWQA/getSupervision', submit).done(function (rs) {
			self.supervisionLoaded(true);

			self.supervisionModel({
				never: rs.filter(r => r.VisitDate == null),
				overdue: rs.filter(r => r.VisitDate != null && r.Priority <= 2),
				next30: rs.filter(r => r.VisitDate != null && r.Priority.in(3, 4, 5, 6)),
				next90: rs.filter(r => r.VisitDate != null && r.Priority >= 7),
				neverOpen: ko.observable(false),
				overdueOpen: ko.observable(false),
				next30Open: ko.observable(false),
				next90Open: ko.observable(false)
			});
		});
	}

	function showMonitor() {
		if (monitorLoaded) return;

		app.ajax('/VMWQA/getMonitor').done(function (rs) {
			monitorLoaded = true;

			rs.forEach(r => {
				r.Code_Facility_T = place.vl.find(x => x.code == r.Code_Vill_T).hccode;
				r.Code_OD_T = place.hc.find(x => x.code == r.Code_Facility_T).odcode;
				r.Code_Prov_T = place.od.find(x => x.code == r.Code_OD_T).pvcode;
			});

			rs.sortasc(r => self.getVLName(r.Code_Vill_T));
			rs.sortasc(r => self.getHCName(r.Code_Facility_T));
			rs.sortasc(r => self.getODName(r.Code_OD_T));
			rs.sortasc(r => self.getPVName(r.Code_Prov_T));

			self.monitorList(rs);
		});
	}

	function showReport() {
		var submit = {
			pvcode: self.pv(),
			odcode: self.od(),
			hccode: self.hc(),
			vlcode: self.vl(),
			year: self.year(),
			month: self.month()
		};
		app.ajax('/VMWQA/getReport', submit).done(function (rs) {
			self.reportLoaded(true);

			rs.Detail.sortasc('Name_Prov_E', 'Name_OD_E', 'Name_Facility_E', 'Name_Vill_E');

			self.reportModel(rs);
		});
	}

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
		place = p;
		place.pv = place.pv.filter(r => r.target == 1);
		place.od = place.od.filter(r => r.target == 1);

		self.pvList(place.pv);
		self.pv('01');
	});

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Code_Prov_N: null,
			Code_OD_T: null,
			Code_Facility_T: null,
			Code_Vill_T: null,
			VMWName: null,
			VisitDate: null,
			VisitorName: null,
			Position: null,
			WorkPlace: null,
			Section2: null,
			Section3: null,
			Section4: null,
			Section5: null,
			Section6: null,
			Section7: null,
			Section8: null,
			Section9: null,
			Section10: null,
			Section12: null,
			Section13: null,
			Section14: null,
			Section15: null,
			Section16: null,
			TotalScore: null,
			TPR: null,
			FormType: 'VMW',
			Sex: null,
			Training: null
		};

		self.showDetail(model);
	};

	self.showDetail = function (model) {
		lastScrollY = window.scrollY;
        console.log(model);
		model = app.ko(model);
		model.pvList = ko.observableArray(place.pv);
		model.odList = () => place.od.filter(r => r.pvcode == model.Code_Prov_N());
		model.hcList = () => place.hc.filter(r => r.odcode == model.Code_OD_T() && !r.name.contain(' RH'));
		model.vlList = () => place.vl.filter(r => r.hccode != null && r.hccode == model.Code_Facility_T());

		model.FormType.subscribe(type => {
			if (type == 'Integrated') {
				var list = self.detailIntegrated();
				list.forEach(r => r.Answer.elements = []);
				self.detailIntegrated(list);
			} else {
				var list = self.detailVMW();
				list.forEach(r => r.Answer.elements = []);
				self.detailVMW(list);
			}
		});

		self.masterModel(model);

		if (model.Rec_ID() == 0) {
			var listA = newVMW();
			var listB = newIntegrated();

			listA.forEach(r => {
				r.Answer = ko.observable(r.Answer);
				r.Score = ko.observable(r.Score);
			});
			listB.forEach(r => {
				r.Answer = ko.observable(r.Answer);
				r.Score = ko.observable(r.Score);
			});

			self.detailVMW(listA);
			self.detailIntegrated(listB);

			self.view('detail');
		} else {
			var submit = { id: model.Rec_ID };
			app.ajax('/VMWQA/getDetail', submit).done(function (rs) {
				rs.forEach(r => {
					r.Answer = ko.observable(r.Answer);
					r.Score = ko.observable(r.Score);
				});

				if (model.FormType() == 'Old') self.detailModel(rs);
				else if (model.FormType() == 'Integrated') self.detailIntegrated(rs);
				else self.detailVMW(rs);

				self.view('detail');
			});
		}

		window.scrollTo(0, 0);
	};

	self.save = function () {
		var master = app.unko(self.masterModel());
		var type = master.FormType;
		var list = type == 'Old' ? self.detailModel() : type == 'Integrated' ? self.detailIntegrated() : self.detailVMW();
		var detail = app.unko(list);

		detail.forEach(r => {
			if (Array.isArray(r.Answer)) r.Answer = r.Answer.join(',');
			r.Score = r.Score.toFloat();
		});

		var submit = {
			master: JSON.stringify(master),
			detail: JSON.stringify(detail)
		};

		app.ajax('/VMWQA/save', submit).done(function (id) {
			if (master.Rec_ID == 0) {
				master.Rec_ID = id;
				self.listModel.push(master);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == master.Rec_ID);
				self.listModel.replace(old, master);
			}

			self.back();
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblVMWQuestionnaire',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			logDelete(submit);

			setTimeout(() => {
				app.ajax('/Direct/delete', submit).done(function () {
					self.listModel.remove(model);
				});
			}, 300);
		});
	};

	function logDelete(submit) {
		app.ajax('/VMWQA/logDelete', submit).done(function () { })
	}

	self.back = function () {
		self.view('list');
		window.scrollTo(0, lastScrollY);
	};

	self.pv.subscribe(function (code) {
		self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
	});

	self.od.subscribe(function (code) {
		self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
	});

	self.hc.subscribe(function (code) {
		self.vlList(code == null ? [] : place.vl.filter(r => r.hccode == code));
	});

	self.filteredListModel = ko.pureComputed(function () {
		var list = self.listModel();

		if (self.vl() != null) list = list.filter(r => r.Code_Vill_T == self.vl());
		else if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
		else if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());

		if (self.year() != null) list = list.filter(r => r.VisitDate.substr(0, 4) == self.year());
		if (self.month() != null) list = list.filter(r => r.VisitDate.substr(5, 2) == self.month());

		if (!rowLimit.scrolling) {
			window.scrollTo({ top: 0 });
			rowLimit.reset();
		}

		return list.slice(0, rowLimit());
	});

	self.filteredMonitorList = ko.pureComputed(function () {
		var list = self.vl() != null ? self.monitorList().filter(r => r.Code_Vill_T == self.vl())
			: self.hc() != null ? self.monitorList().filter(r => r.Code_Facility_T == self.hc())
			: self.od() != null ? self.monitorList().filter(r => r.Code_OD_T == self.od())
			: self.pv() != null ? self.monitorList().filter(r => r.Code_Prov_T == self.pv())
			: self.monitorList();

		if (self.year() != null) list = list.filter(r => r.VisitDate.substr(0, 4) == self.year());
		if (self.month() != null) list = list.filter(r => r.VisitDate.substr(5, 2) == self.month());

		return list;
	});

	self.getPVName = function (code) {
		return place.pv.find(r => r.code == code).name;
	};

	self.getODName = function (code) {
		return place.od.find(r => r.code == code).name;
	};

	self.getHCName = function (code) {
		return place.hc.find(r => r.code == code).name;
	};

	self.getVLName = function (code) {
		return place.vl.find(r => r.code == code).name;
	};

	self.getAnswer = function (e) {
		var type = self.masterModel().FormType();
		var list = type == 'Old' ? self.detailModel() : type == 'Integrated' ? self.detailIntegrated() : self.detailVMW();
		var found = list.find(r => r.Question == e.name);

		if (e.type == 'checkbox' && !Array.isArray(found.Answer())) {
			found.Answer(found.Answer().split(',').filter(r => r != ''));
		}

		return found.Answer;
	};

	self.getScore = function (e) {
		var q = $(e).siblings().first().text();
		var type = self.masterModel().FormType();
		var list = type == 'Old' ? self.detailModel() : type == 'Integrated' ? self.detailIntegrated() : self.detailVMW();
		var row = list.find(r => r.Question == q);

		if (type == 'Old') {
			if (['4', '5', '24'].contain(q)) {
				var len = row.Answer.elements.filter(r => row.Answer().contain(r.value) && r.getAttribute('score') != '0').length;
				row.Score(len <= 3 ? len : 3);
				return row.Score();
			}
		}
		if (type.in('VMW', 'MMW')) {
			if (['4', '5', '23', '25'].contain(q)) {
				var len = row.Answer.elements.filter(r => row.Answer().contain(r.value) && r.getAttribute('score') != '0').length;
				row.Score(len <= 3 ? len : 3);
				return row.Score();
			}
		}
		if (type == 'Integrated') {
			if (['3', '4', '19', '21'].contain(q)) {
				var len = row.Answer.elements.filter(r => row.Answer().contain(r.value) && r.getAttribute('score') != '0').length;
				row.Score(len <= 3 ? len : 3);
				return row.Score();
			}
			if (['24', '25', '28', '29', '30', '33'].contain(q)) {
				var len = row.Answer.elements.filter(r => row.Answer().contain(r.value) && r.getAttribute('score') != '0').length;
				row.Score((len <= 3 ? len : 3) * 0.5);
				return row.Score();
			}
		}

		if (type == 'Integrated') {
			if (['6', '10', '34'].contain(q)) {
				var found = row.Answer.elements.find(r => row.Answer().contain(r.value) && r.getAttribute('score') != '0');
				row.Score(found == null ? 0 : found.getAttribute('score'));
				return row.Score();
			}
		} else {
			if (['7', '11'].contain(q)) {
				var found = row.Answer.elements.find(r => row.Answer().contain(r.value) && r.getAttribute('score') != '0');
				row.Score(found == null ? 0 : found.getAttribute('score'));
				return row.Score();
			}
		}

		var found = row.Answer.elements.find(r => r.value == row.Answer());
		row.Score(found == null ? 0 : found.getAttribute('score'));
		return row.Score();
	};

	self.getGroupScore = function (e) {
		var q = $(e).siblings().first().text();
		var pre = q + '.';

		var type = self.masterModel().FormType();
		var list = type == 'Old' ? self.detailModel() : type == 'Integrated' ? self.detailIntegrated() : self.detailVMW();

		var score = list.filter(r => r.Question.substr(0, pre.length) == pre).sum(r => r.Score().toFloat()).toFixed(2).toFloat();
		list.find(r => r.Question == q).Score(score);
		return score;
	};

	self.getTotalScore = function (name) {
		var type = self.masterModel().FormType();
		var list = type == 'Old' ? self.detailModel() : type == 'Integrated' ? self.detailIntegrated() : self.detailVMW();
		var a = 0, b = 0;

		if (list == null) return;

		if (type == 'Old') {
			if (name == 'Section2') { a = 1; b = 9 }
			if (name == 'Section3') { a = 10; b = 15 }
			if (name == 'Section4') { a = 16; b = 19 }
			if (name == 'Section5') { a = 20; b = 21 }
			if (name == 'Section6') { a = 22; b = 22 }
			if (name == 'Section7') { a = 23; b = 24 }
			if (name == 'TotalScore') { a = 1; b = 24 }
			list = self.detailModel();
		} else if (type.in('VMW', 'MMW')) {
			if (name == 'Section2') { a = 1; b = 9 }
			if (name == 'Section3') { a = 10; b = 14 }
			if (name == 'Section4') { a = 15; b = 18 }
			if (name == 'Section5') { a = 19; b = 20 }
			if (name == 'Section6') { a = 21; b = 21 }
			if (name == 'Section7') { a = 22; b = 23 }
			if (name == 'Section8') { a = 24; b = 25 }
			if (name == 'TotalScore') { a = 1; b = 25 }
			list = self.detailVMW();
		} else if (type == 'Integrated') {
			if (name == 'Section2') { a = 1; b = 8 }
			if (name == 'Section3') { a = 9; b = 13 }
			if (name == 'Section4') { a = 14; b = 14 }
			if (name == 'Section5') { a = 15; b = 16 }
			if (name == 'Section6') { a = 17; b = 17 }
			if (name == 'Section7') { a = 18; b = 19 }
			if (name == 'Section8') { a = 20; b = 21 }
			if (name == 'Section9') { a = 22; b = 23 }
			if (name == 'Section10') { a = 24; b = 25 }
			if (name == 'Section12') { a = 27; b = 28 }
			if (name == 'Section13') { a = 29; b = 30 }
			if (name == 'Section14') { a = 31; b = 31 }
			if (name == 'Section15') { a = 32; b = 33 }
			if (name == 'Section16') { a = 34; b = 34 }
			if (name == 'TotalScore') { a = 1; b = 34 }
			list = self.detailIntegrated();
		}

		var arr = list.filter(r => !r.Question.contain('.') && r.Question >= a && r.Question <= b);
		var total = arr.sum(r => (r.Score() || 0).toFloat()).toFixed(2).toFloat();

		self.masterModel()[name](total);
		return total;
	};

	self.exportExcel = function () {
		if (self.menu() == 'Monitor') {
			var filename = 'VMW QA Monitor.xlsx';
			var list = self.filteredMonitorList();
			if (list.length == 0) return;

			var arr = [];
			for (var r of list) {
				arr.push({
					'Province': self.getPVName(r.Code_Prov_T),
					'OD': self.getODName(r.Code_OD_T),
					'HC': self.getHCName(r.Code_Facility_T),
					'Village': self.getVLName(r.Code_Vill_T),
					'Section 2 Test': r.Section2 + ' / 35',
					'Section 3 Treat': r.Section3 + ' / 35',
					'Section 4 Reporting': r.Section4 + ' / 15',
					'Section 5 Workplace Assessment': r.Section5 + ' / 5',
					'Section 6 Waste Management': r.Section6 + ' / 5',
					'Section 7 Education': r.Section7 + ' / 5',
					'Total': r.TotalScore + ' / 100'
				});
			}
		}

		if (self.menu() == 'Report') {
			var filename = 'VMW QA Report.xlsx';
			var list = (self.reportModel() || {}).Detail;
			if (list == null || list.length == 0) return;

			var arr = [];
			for (var r of list) {
				arr.push({
					'Province': r.Name_Prov_E,
					'OD': r.Name_OD_E,
					'HC': r.Name_Facility_E,
					'Village': r.Name_Vill_E,
					'Type': r.VMWType,
					'Last Supervision Date': r.VisitDate == null ? '' : moment(r.VisitDate).displayformat(),
					'Next Visit Status': r.NextVisit,
					'Total Score': r.TotalScore,
					'Section 2 Test (%)': r.Section2,
					'Section 3 Treat (%)': r.Section,
					'Section 4 Reporting (%)': r.Section4,
					'Section 5 Workplace Assessment (%)': r.Section5,
					'Section 6 Waste Management (%)': r.Section6,
					'Section 7 Education (%)': r.Section7
				});
			}
		}

		var submit = {
			data: JSON.stringify(arr)
		};

		app.downloadBlob('/VMWQA/exportExcel', submit).done(function (blob) {
			saveAs(blob, filename); //from FileSaver.js
		});
	};

	function newVMW() {
		return [
			{ Question: '1', Answer: '', Score: 0 },
			{ Question: '1.1', Answer: '', Score: 0 },
			{ Question: '1.2', Answer: '', Score: 0 },
			{ Question: '1.3', Answer: '', Score: 0 },
			{ Question: '1.4', Answer: '', Score: 0 },
			{ Question: '2', Answer: '', Score: 0 },
			{ Question: '3', Answer: '', Score: 0 },
			{ Question: '3.1', Answer: '', Score: 0 },
			{ Question: '3.2', Answer: '', Score: 0 },
			{ Question: '3.3', Answer: '', Score: 0 },
			{ Question: '4', Answer: '', Score: 0 },
			{ Question: '5', Answer: '', Score: 0 },
			{ Question: '6', Answer: '', Score: 0 },
			{ Question: '6.1', Answer: '', Score: 0 },
			{ Question: '6.2', Answer: '', Score: 0 },
			{ Question: '6.3', Answer: '', Score: 0 },
			{ Question: '6.4', Answer: '', Score: 0 },
			{ Question: '6.5', Answer: '', Score: 0 },
			{ Question: '6.6', Answer: '', Score: 0 },
			{ Question: '7', Answer: '', Score: 0 },
			{ Question: '8', Answer: '', Score: 0 },
			{ Question: '9', Answer: '', Score: 0 },
			{ Question: '9.1', Answer: '', Score: 0 },
			{ Question: '9.2', Answer: '', Score: 0 },
			{ Question: '9.3', Answer: '', Score: 0 },
			{ Question: '9.4', Answer: '', Score: 0 },
			{ Question: '9.5', Answer: '', Score: 0 },
			{ Question: '9.6', Answer: '', Score: 0 },
			{ Question: '9.7', Answer: '', Score: 0 },
			{ Question: '9.8', Answer: '', Score: 0 },
			{ Question: '9.9', Answer: '', Score: 0 },
			{ Question: '9.10', Answer: '', Score: 0 },
			{ Question: '9.11', Answer: '', Score: 0 },
			{ Question: '9.12', Answer: '', Score: 0 },
			{ Question: '9.13', Answer: '', Score: 0 },
			{ Question: '9.14', Answer: '', Score: 0 },
			{ Question: '10', Answer: '', Score: 0 },
			{ Question: '11', Answer: '', Score: 0 },
			{ Question: '12', Answer: '', Score: 0 },
			{ Question: '12.1', Answer: '', Score: 0 },
			{ Question: '12.2', Answer: '', Score: 0 },
			{ Question: '12.3', Answer: '', Score: 0 },
			{ Question: '12.4', Answer: '', Score: 0 },
			{ Question: '12.5', Answer: '', Score: 0 },
			{ Question: '12.6', Answer: '', Score: 0 },
			{ Question: '13', Answer: '', Score: 0 },
			{ Question: '13.1', Answer: '', Score: 0 },
			{ Question: '13.2', Answer: '', Score: 0 },
			{ Question: '14', Answer: '', Score: 0 },
			{ Question: '14.1', Answer: '', Score: 0 },
			{ Question: '14.2', Answer: '', Score: 0 },
			{ Question: '14.3', Answer: '', Score: 0 },
			{ Question: '15', Answer: '', Score: 0 },
			{ Question: '15.1', Answer: '', Score: 0 },
			{ Question: '15.2', Answer: '', Score: 0 },
			{ Question: '16', Answer: '', Score: 0 },
			{ Question: '16.1', Answer: '', Score: 0 },
			{ Question: '16.2', Answer: '', Score: 0 },
			{ Question: '16.3', Answer: '', Score: 0 },
			{ Question: '16.4', Answer: '', Score: 0 },
			{ Question: '17', Answer: '', Score: 0 },
			{ Question: '17.1', Answer: '', Score: 0 },
			{ Question: '17.2', Answer: '', Score: 0 },
			{ Question: '17.3', Answer: '', Score: 0 },
			{ Question: '18', Answer: '', Score: 0 },
			{ Question: '18.1', Answer: '', Score: 0 },
			{ Question: '19', Answer: '', Score: 0 },
			{ Question: '19.1', Answer: '', Score: 0 },
			{ Question: '19.2', Answer: '', Score: 0 },
			{ Question: '19.3', Answer: '', Score: 0 },
			{ Question: '19.4', Answer: '', Score: 0 },
			{ Question: '19.5', Answer: '', Score: 0 },
			{ Question: '19.6', Answer: '', Score: 0 },
			{ Question: '19.7', Answer: '', Score: 0 },
			{ Question: '19.8', Answer: '', Score: 0 },
			{ Question: '20', Answer: '', Score: 0 },
			{ Question: '20.1.1', Answer: '', Score: 0 },
			{ Question: '20.1.2', Answer: '', Score: 0 },
			{ Question: '20.2', Answer: '', Score: 0 },
			{ Question: '20.3', Answer: '', Score: 0 },
			{ Question: '20.4', Answer: '', Score: 0 },
			{ Question: '20.5', Answer: '', Score: 0 },
			{ Question: '20.6', Answer: '', Score: 0 },
			{ Question: '20.7', Answer: '', Score: 0 },
			{ Question: '20.8', Answer: '', Score: 0 },
			{ Question: '21', Answer: '', Score: 0 },
			{ Question: '21.1', Answer: '', Score: 0 },
			{ Question: '21.2', Answer: '', Score: 0 },
			{ Question: '21.3', Answer: '', Score: 0 },
			{ Question: '22', Answer: '', Score: 0 },
			{ Question: '23', Answer: '', Score: 0 },
			{ Question: '24', Answer: '', Score: 0 },
			{ Question: '25', Answer: '', Score: 0 }
		];
	}

	function newIntegrated() {
		return [
			{ Question: '1', Answer: '', Score: 0 },
			{ Question: '1.1', Answer: '', Score: 0 },
			{ Question: '1.2', Answer: '', Score: 0 },
			{ Question: '1.3', Answer: '', Score: 0 },
			{ Question: '1.4', Answer: '', Score: 0 },
			{ Question: '2', Answer: '', Score: 0 },
			{ Question: '3', Answer: '', Score: 0 },
			{ Question: '3.1', Answer: '', Score: 0 },
			{ Question: '3.2', Answer: '', Score: 0 },
			{ Question: '3.3', Answer: '', Score: 0 },
			{ Question: '4', Answer: '', Score: 0 },
			{ Question: '5', Answer: '', Score: 0 },
			{ Question: '6', Answer: '', Score: 0 },
			{ Question: '6.1', Answer: '', Score: 0 },
			{ Question: '6.2', Answer: '', Score: 0 },
			{ Question: '6.3', Answer: '', Score: 0 },
			{ Question: '6.4', Answer: '', Score: 0 },
			{ Question: '6.5', Answer: '', Score: 0 },
			{ Question: '6.6', Answer: '', Score: 0 },
			{ Question: '7', Answer: '', Score: 0 },
			{ Question: '8', Answer: '', Score: 0 },
			{ Question: '9', Answer: '', Score: 0 },
			{ Question: '9.1', Answer: '', Score: 0 },
			{ Question: '9.2', Answer: '', Score: 0 },
			{ Question: '9.3', Answer: '', Score: 0 },
			{ Question: '9.4', Answer: '', Score: 0 },
			{ Question: '9.5', Answer: '', Score: 0 },
			{ Question: '9.6', Answer: '', Score: 0 },
			{ Question: '9.7', Answer: '', Score: 0 },
			{ Question: '9.8', Answer: '', Score: 0 },
			{ Question: '9.9', Answer: '', Score: 0 },
			{ Question: '9.10', Answer: '', Score: 0 },
			{ Question: '9.11', Answer: '', Score: 0 },
			{ Question: '9.12', Answer: '', Score: 0 },
			{ Question: '9.13', Answer: '', Score: 0 },
			{ Question: '9.14', Answer: '', Score: 0 },
			{ Question: '10', Answer: '', Score: 0 },
			{ Question: '11', Answer: '', Score: 0 },
			{ Question: '12', Answer: '', Score: 0 },
			{ Question: '12.1', Answer: '', Score: 0 },
			{ Question: '12.2', Answer: '', Score: 0 },
			{ Question: '12.3', Answer: '', Score: 0 },
			{ Question: '12.4', Answer: '', Score: 0 },
			{ Question: '12.5', Answer: '', Score: 0 },
			{ Question: '12.6', Answer: '', Score: 0 },
			{ Question: '13', Answer: '', Score: 0 },
			{ Question: '13.1', Answer: '', Score: 0 },
			{ Question: '13.2', Answer: '', Score: 0 },
			{ Question: '14', Answer: '', Score: 0 },
			{ Question: '14.1', Answer: '', Score: 0 },
			{ Question: '14.2', Answer: '', Score: 0 },
			{ Question: '14.3', Answer: '', Score: 0 },
			{ Question: '15', Answer: '', Score: 0 },
			{ Question: '15.1', Answer: '', Score: 0 },
			{ Question: '15.2', Answer: '', Score: 0 },
			{ Question: '16', Answer: '', Score: 0 },
			{ Question: '16.1', Answer: '', Score: 0 },
			{ Question: '16.2', Answer: '', Score: 0 },
			{ Question: '16.3', Answer: '', Score: 0 },
			{ Question: '16.4', Answer: '', Score: 0 },
			{ Question: '17', Answer: '', Score: 0 },
			{ Question: '17.1', Answer: '', Score: 0 },
			{ Question: '17.2', Answer: '', Score: 0 },
			{ Question: '17.3', Answer: '', Score: 0 },
			{ Question: '18', Answer: '', Score: 0 },
			{ Question: '18.1', Answer: '', Score: 0 },
			{ Question: '19', Answer: '', Score: 0 },
			{ Question: '19.1', Answer: '', Score: 0 },
			{ Question: '19.2', Answer: '', Score: 0 },
			{ Question: '19.3', Answer: '', Score: 0 },
			{ Question: '19.4', Answer: '', Score: 0 },
			{ Question: '19.5', Answer: '', Score: 0 },
			{ Question: '19.6', Answer: '', Score: 0 },
			{ Question: '19.7', Answer: '', Score: 0 },
			{ Question: '19.8', Answer: '', Score: 0 },
			{ Question: '20', Answer: '', Score: 0 },
			{ Question: '20.1.1', Answer: '', Score: 0 },
			{ Question: '20.1.2', Answer: '', Score: 0 },
			{ Question: '20.2', Answer: '', Score: 0 },
			{ Question: '20.3', Answer: '', Score: 0 },
			{ Question: '20.4', Answer: '', Score: 0 },
			{ Question: '20.5', Answer: '', Score: 0 },
			{ Question: '20.6', Answer: '', Score: 0 },
			{ Question: '20.7', Answer: '', Score: 0 },
			{ Question: '20.8', Answer: '', Score: 0 },
			{ Question: '21', Answer: '', Score: 0 },
			{ Question: '21.1', Answer: '', Score: 0 },
			{ Question: '21.2', Answer: '', Score: 0 },
			{ Question: '21.3', Answer: '', Score: 0 },
			{ Question: '22', Answer: '', Score: 0 },
			{ Question: '23', Answer: '', Score: 0 },
			{ Question: '24', Answer: '', Score: 0 },
			{ Question: '25', Answer: '', Score: 0 },
			{ Question: '5.1', Answer: '', Score: 0 },
			{ Question: '5.2', Answer: '', Score: 0 },
			{ Question: '5.3', Answer: '', Score: 0 },
			{ Question: '5.4', Answer: '', Score: 0 },
			{ Question: '5.5', Answer: '', Score: 0 },
			{ Question: '5.6', Answer: '', Score: 0 },
			{ Question: '8.1', Answer: '', Score: 0 },
			{ Question: '8.2', Answer: '', Score: 0 },
			{ Question: '8.3', Answer: '', Score: 0 },
			{ Question: '8.4', Answer: '', Score: 0 },
			{ Question: '8.5', Answer: '', Score: 0 },
			{ Question: '8.6', Answer: '', Score: 0 },
			{ Question: '8.7', Answer: '', Score: 0 },
			{ Question: '8.8', Answer: '', Score: 0 },
			{ Question: '8.9', Answer: '', Score: 0 },
			{ Question: '8.10', Answer: '', Score: 0 },
			{ Question: '8.11', Answer: '', Score: 0 },
			{ Question: '8.12', Answer: '', Score: 0 },
			{ Question: '8.13', Answer: '', Score: 0 },
			{ Question: '8.14', Answer: '', Score: 0 },
			{ Question: '11.1', Answer: '', Score: 0 },
			{ Question: '11.2', Answer: '', Score: 0 },
			{ Question: '11.3', Answer: '', Score: 0 },
			{ Question: '11.4', Answer: '', Score: 0 },
			{ Question: '11.5', Answer: '', Score: 0 },
			{ Question: '11.6', Answer: '', Score: 0 },
			{ Question: '13.3', Answer: '', Score: 0 },
			{ Question: '15.3', Answer: '', Score: 0 },
			{ Question: '15.4', Answer: '', Score: 0 },
			{ Question: '15.5', Answer: '', Score: 0 },
			{ Question: '15.6', Answer: '', Score: 0 },
			{ Question: '15.7', Answer: '', Score: 0 },
			{ Question: '15.8', Answer: '', Score: 0 },
			{ Question: '16.1.1', Answer: '', Score: 0 },
			{ Question: '16.1.2', Answer: '', Score: 0 },
			{ Question: '16.5', Answer: '', Score: 0 },
			{ Question: '16.6', Answer: '', Score: 0 },
			{ Question: '16.7', Answer: '', Score: 0 },
			{ Question: '16.8', Answer: '', Score: 0 },
			{ Question: '26', Answer: '', Score: 0 },
			{ Question: '27', Answer: '', Score: 0 },
			{ Question: '28', Answer: '', Score: 0 },
			{ Question: '29', Answer: '', Score: 0 },
			{ Question: '30', Answer: '', Score: 0 },
			{ Question: '31', Answer: '', Score: 0 },
			{ Question: '32', Answer: '', Score: 0 },
			{ Question: '33', Answer: '', Score: 0 },
			{ Question: '34', Answer: '', Score: 0 }
		];
	}

	$(window).scroll(function () {
		if (innerHeight + scrollY + 1000 < document.body.scrollHeight) return;
		if (rowLimit() > self.listModel().length) return;

		rowLimit.scrolling = true;
		rowLimit.increase();
		rowLimit.scrolling = false;
	});

	subViewModel(self);
}