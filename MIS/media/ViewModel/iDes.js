function viewModel() {
	var self = this;

	self.view = ko.observable('list');
	self.hcListModel = ko.observableArray();
	self.vmwListModel = ko.observableArray();
	self.rhListModel = ko.observableArray();
	self.masterModel = ko.observable();
	self.detailModel = ko.observable();
	self.followupModel = ko.observable();
	self.dbsModel = ko.observable();
	self.days = ko.observableArray();
	self.menu = ko.observable('');
	self.formMenu = ko.observable('ides');

	self.hcFuListModel = ko.observableArray();
	self.vmwFuListModel = ko.observableArray();

	self.hcLoaded = ko.observable(false);
	self.vmwLoaded = ko.observable(false);
	self.rhLoaded = ko.observable(false);

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.vl = ko.observable();

	self.yearList = [];
	self.monthList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	self.year = ko.observable(moment().year());
	self.month = ko.observable(moment().format('MMM'));
	self.mf = ko.observable(moment().month(0));
	self.mt = ko.observable(moment());
	self.filter = ko.observable();

	self.permission = new iDesPermission(self);
	self.dbs = new iDesDBS(self);
	self.table = new iDesTable(self);
	self.graph = new iDesGraph(self);
	self.notification = new iDesNotification(self);

	self.place = null;
	var masterColumns = [];
	var detailColumns = [];
	var lastScrollY = 0;

	for (var i = 2022; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (place) {
		if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

		self.place = place;
		self.pvList(self.place.pv);
	});

	self.menuClick = function (vm, event) {
		self.menu(event.currentTarget.innerHTML);

		if (self.menu() == 'Permission') self.permission.getData();
		if (self.menu() == 'Blood Slides/DBS') self.dbs.viewClick();
		if (self.menu() == 'Notification') self.notification.getData();
	};

	self.menuCss = function (element) {
		if (element.innerHTML == 'Linelist of iDES Cases' && self.menu().in('HC', 'VMW', 'PRH/RH')) {
			return 'btn-info';
		}
		return element.innerHTML == self.menu() ? 'btn-info' : 'btn-default';
	};

	self.viewClick = function () {
		var submit = {
			pv: self.pv(),
			od: self.od(),
			hc: self.hc(),
			vl: self.vl(),
			mf: self.mf().format('YYYYMM'),
			mt: self.mt().format('YYYYMM'),
			hasiDes: self.filter() == 'Has iDes' ? 1 : 0
		};

		var url = self.menu() == 'HC' ? '/iDes/getHCList' : self.menu() == 'VMW' ? '/iDes/getVMWList' : '/iDes/getRHList';
		app.ajax(url, submit).done(function (rs) {
			if (self.menu() == 'HC') {
				self.hcListModel(rs);
				self.hcLoaded(true);
				self.vmwLoaded(false);
				self.rhLoaded(false);
			} else if (self.menu() == 'VMW') {
				self.vmwListModel(rs);
				self.hcLoaded(false);
				self.vmwLoaded(true);
				self.rhLoaded(false);
			} else {
				self.rhListModel(rs);
				self.hcLoaded(false);
				self.vmwLoaded(false);
				self.rhLoaded(true);
			}
		});
	};

	self.getUpcomingFU = () => {
		var submit = {
			pv: self.pv(),
			od: self.od(),
			hc: self.hc(),
			y: self.year(),
			m: self.month() == null ? '' : self.convertMonth(self.month()),
			type: self.menu().substr(0, 3).trim()
		};
		var url = self.menu() == 'VMW Follow-up' ? '/iDes/getVmwUpcomingFU' : '/iDes/getHcUpcomingFU';

		app.ajax(url, submit).done(function (rs) {
			if (self.menu() == 'VMW Follow-up') {
				self.vmwFuListModel(rs);
			} else {
				self.hcFuListModel(rs);
			}
		});
	}

	self.showDetail = function (model) {
		lastScrollY = window.scrollY;

		var submit = {
			id: model.Case_ID,
			type: model.Case_Type
		};

		app.ajax('/iDes/getDetail', submit).done(function (rs) {
			self.detailModel(null);

			masterColumns = rs.masterColumns;
			detailColumns = rs.detailColumns;

			var master = rs.master;
			master.Case_ID = model.Case_ID;
			master.Case_Type = model.Case_Type;
			master.Code_Facility_T = model.Code_Facility_T;
			if (master.Case_Type == 'VMW') master.Code_Vill_T = model.Code_Vill_T;

			master.PCR = ko.observable(master.PCR);
			master.PCROther = ko.observable(master.PCROther);
			master.Conclusion = ko.observable(master.Conclusion);
			master.DayFailure = ko.observable(master.DayFailure);

			master.PCR.subscribe(() => master.PCROther(''));
			master.Conclusion.subscribe(() => master.DayFailure(''));

			var arr = ['D0', 'D1', 'D2', 'D3', 'D7', 'D14', 'D28', 'D42', 'D90'];

			if (master.Diagnosis.in('F', 'A', 'K')) self.days(arr.filter(r => r != 'D90'));
			if (master.Diagnosis.in('V', 'M', 'O')) self.days(arr.filter(r => r != 'D42'));

			var detail = {};

			self.days().forEach(d => {
				var model = {};
				var found = rs.detail.find(r => r.Days == d);
				if (found == null) {
					detailColumns.forEach(c => model[c] = '');

					model.Days = d;
					model.ExpectedDate = moment(master.DiagnosisDate).add(d.substr(1), 'day').format('YYYY-MM-DD');
				} else {
					detailColumns.forEach(c => model[c] = found[c]);
				}

				if (d.in('D3', 'D7') && model.G6PDNormalPQ == '') model.G6PDNormalPQ = model.ExpectedDate;

				detail[d] = model;
			});

			var follow = rs.followup;

			self.masterModel(master);
			self.detailModel(detail);
			self.followupModel(follow);
			self.formMenu('ides');
			self.view('detail');
			window.scrollTo(0, 0);

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.saveNote = (model) => {
		var type = self.menu() == 'HC Follow-up' ? 'HC'
			: self.menu() == 'VMW Follow-up' ? 'VMW'
			: self.menu() == 'PRH Follow-up' ? 'PRH'
			: 'RH';

		var submit = {
			Case_ID: model.Rec_ID,
			Type: type,
			Note: model.Note,
			DayFU: model.Day,
			Note_ID: model.Note_ID
		}

		app.ajax('/iDes/saveNote', { submit: submit });
	}

	self.save = function () {
		var model = app.unko(self.masterModel());
		var master = {};
		var details = [];
		var follow = {};

		masterColumns.forEach(c => master[c] = model[c]);
		model = self.detailModel();
		self.days().forEach(d => {
			if (model[d].SlideSpecies != '') {
				model[d].Case_ID = master.Case_ID;
				model[d].Case_Type = master.Case_Type;

				details.push(model[d]);
			}
		});

		if (details.length == 0) {
			app.showMsg('Missing Data', 'Please input follow up information.');
			return;
		}

		var f = self.followupModel();
		follow.Case_ID = master.Case_ID;
		follow.Case_Type = master.Case_Type;
		follow.HFPhone = f.HFPhone;
		follow.Hospital = f.Hospital;
		follow.HospitalPhone = f.HospitalPhone;

		for (var i = 0; i <= 2; i++) {
			follow['ACTDay' + i + 'Date'] = f['ACTDay' + i + 'Date'];
			follow['ACTDay' + i + 'Checked'] = f['ACTDay' + i + 'Checked'] ? 1 : 0;
		}

		follow.SLDDay0Date = f.SLDDay0Date;
		follow.SLDDay0Checked = f.SLDDay0Checked;

		for (var i = 0; i <= 13; i++) {
			follow['Day' + i + 'Date'] = f['Day' + i + 'Date'];
			follow['Day' + i + 'Checked'] = f['Day' + i + 'Checked'] ? 1 : 0;
		}
		for (var i = 1; i <= 8; i++) {
			follow['Week' + i + 'Date'] = f['Week' + i + 'Date'];
			follow['Week' + i + 'Checked'] = f['Week' + i + 'Checked'] ? 1 : 0;
		}

		var submit = { master: master, details: details, follow: JSON.stringify(follow) };

		app.ajax('/iDes/save', submit).done(function () {
			if (self.menu() == 'HC') {
				var old = self.hcListModel().find(r => r.Case_ID == master.Case_ID && r.Case_Type == master.Case_Type);
				old.HasiDes = 1;
				old.iDesDate = moment().sqlformat();
				self.hcListModel.replace(old, clone(old));
			} else if (self.menu() == 'VMW') {
				var old = self.vmwListModel().find(r => r.Case_ID == master.Case_ID && r.Case_Type == master.Case_Type);
				old.HasiDes = 1;
				old.iDesDate = moment().sqlformat();
				self.vmwListModel.replace(old, clone(old));
			} else {
				var old = self.rhListModel().find(r => r.Case_ID == master.Case_ID && r.Case_Type == master.Case_Type);
				old.HasiDes = 1;
				old.iDesDate = moment().sqlformat();
				self.rhListModel.replace(old, clone(old));
			}

			self.view('list');
			window.scrollTo(0, lastScrollY);
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				where: { Case_ID: model.Case_ID, Case_Type: model.Case_Type },
				hc: model.Code_Facility_T,
				vl: model.Code_Vill_T
			};

			app.ajax('/iDes/delete', submit).done(function () {
				model.HasiDes = 0;
				model.iDesDate = null;

				if (self.menu() == 'HC') {
					self.hcListModel.replace(model, clone(model));
				} else if (self.menu() == 'VMW') {
					self.vmwListModel.replace(model, clone(model));
				} else {
					self.rhListModel.replace(model, clone(model));
				}
			});
		});
	};

	self.back = function () {
		self.view('list');
		window.scrollTo(0, lastScrollY);
	};

	self.getPVName = function (hccode) {
		var odcode = self.place.hc.find(r => r.code == hccode).odcode;
		var pvcode = self.place.od.find(r => r.code == odcode).pvcode;
		return self.place.pv.find(r => r.code == pvcode).name;
	};

	self.getODName = function (hccode) {
		var odcode = self.place.hc.find(r => r.code == hccode).odcode;
		return self.place.od.find(r => r.code == odcode).name;
	};

	self.getHCName = function (code) {
		return self.place.hc.find(r => r.code == code).name;
	};

	self.getVLName = function (code) {
		return code == null ? '' : self.place.vl.find(r => r.code == code).name;
	};

	self.odList = function () {
		return self.pv() == null ? [] : self.place.od.filter(r => r.pvcode == self.pv());
	};

	self.hcList = function () {
		return self.od() == null ? [] : self.place.hc.filter(r => r.odcode == self.od());
	};

	self.vlList = function () {
		return self.hc() == null ? [] : self.place.vl.filter(r => r.hccode == self.hc());
	};

	self.getSpecies = function (d) {
		return d == 'F' ? 'Pf'
			: d == 'V' ? 'Pv'
			: d == 'M' ? 'Pv'
			: d == 'A' ? 'Pm'
			: d == 'O' ? 'Po'
			: d == 'K' ? 'Pk'
			: '';
	};

	self.convertMonth = function (mmm) {
		return moment(mmm, 'MMM').format('MM');
	};

	self.exportExcel = function () {
		var tbl = $('#tbl' + self.menu().replace('/', ''));
		var colNames = tbl.find('thead th').toArray();
		var arr = [];

		tbl.find('tbody tr').each(function () {
			var obj = {};
			colNames.forEach((item, i) => {
				if (item.getAttribute('export') == 'no') return;
				var name = item.innerHTML;
				obj[name] = $(this).find('td')[i].innerHTML;
				if (name.contain('Date') && obj[name] != '') obj[name] = moment(obj[name], 'DD-MM-YYYY').sqlformat();
			});
			arr.push(obj);
		});

		var submit = {
			data: JSON.stringify(arr)
		};

		app.downloadBlob('/iDes/exportExcel', submit).done(function (blob) {
			saveAs(blob, 'iDes.xlsx'); //from FileSaver.js
		});
	};
}

Highcharts.setOptions({
	title: { style: { textTransform: null } },
	xAxis: {
		gridLineColor: "white",
		labels: { style: { color: 'black', fontSize: '12px' } }
	},
	yAxis: {
		title: { style: { color: 'black' } },
		labels: { style: { color: 'black', fontSize: '12px' } }
	},
	plotOptions: { series: { dataLabels: { style: { fontSize: '12px', fontWeight: 'normal' } } } },
	exporting: {
		menuItemDefinitions: {
			downloadXLS: { onclick: Highcharts.Chart.prototype.downloadXLS }
		}
	}
});