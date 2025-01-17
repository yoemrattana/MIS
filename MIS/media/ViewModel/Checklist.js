$('.btnmenu').each(function (index, el) {
	if ($(el).attr('href') == location.pathname) {
		$(el).removeClass('btn-default').addClass('btn-info');
	}
});
$('a[title]').tooltip();

function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.masterModel = ko.observable();
	self.detailModel = ko.observable();
	self.view = ko.observable('list');

	self.provList = ko.observableArray();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.prov = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.visitYear = ko.observable(moment().year());
	self.hasSub = ko.observable(false);

	self.lastScrollY = 0;
	self.tableName = null;
	self.place = null;
	self.tab = $('.btnmenu.btn-info').attr('name');
	self.visitYearList = Array.repeat(moment().year() - 2020, 2021).map((y, i) => y + i);
	self.trashMode = ko.observable(false);

	self.getData = function () {
		app.getPlace(['pv', 'od', 'hc', 'vl', 'ds'], function (p) {
			if (app.user.prov != '') p.pv = p.pv.filter(r => app.user.prov.contain(r.code));
			if (app.user.od != '') p.od = p.od.filter(r => r.code == app.user.od);

			p.pv = p.pv.filter(r => r.target == 1).sortasc('nameK');
			p.od = p.od.filter(r => r.target == 1).sortasc('nameK');
			p.hc = p.hc.sortasc('nameK');
			p.vl = p.vl.filter(r => r.hccode != null).sortasc('nameK');
			p.ds = p.ds.sortasc('nameK');

			self.place = p;
			self.provList(p.pv);

			self.hasSub(true);

			var submit = { tbl: self.tableName };
			app.ajax('/Checklist/getData', submit).done(function (rs) {
				getCompleteness(rs, self.tableName);

				if (self.tableName.in('tblChecklistOD', 'tblChecklistHC')) {
					var mne = location.pathname.contain('mne');
					rs.reports = rs.reports.filter(r => mne ? r.InitUser == 'm&ecnm' : r.InitUser != 'm&ecnm');
				}

				self.listModel(rs.reports);
			});
		});
	};

	getCompleteness = (data, table) => {
		if (table == "tblChecklistMnEHC") return getMnEHCCompleteness(data);
		if (table == "tblChecklistMnEOD") return getMnEODCompleteness(data);
		if (table == 'tblChecklistHC') return getHCCompleteness(data);
		if (table == 'tblChecklistOD') return getODCompleteness(data);
		return data;
	}

	getMnEHCCompleteness = (data) => {
		let detail = data['details'].map(r => {
			r.Answer = JSON.parse(r.Answer);
			return r;
		});

		let list = data['reports'].map(r => {
			let _detail = detail.filter(x => x.ParentId == r.Rec_ID)

			let isTick = _detail.filter(o => o.Answer.tick == '').length > 0 ? 0 : 1;
			let isProblem = _detail.filter(o => o.Answer.problem == '').length > 0 ? 0 : 1;
			let isTreat = _detail.filter(o => o.Answer.qty == '').length > 0 ? 0 : 1;
			//let isOther = children.filter(o => o.Answer == '').length > 0 ? 0 : 1;
			let isTest = _detail.filter(o => o.Answer.test == '').length > 0 ? 0 : 1;

			r.completeness = isTick && isProblem && isTreat && isTest;

			r.c = _detail;
			return r;
		});

		return list;
	}

	getMnEODCompleteness = (data) => {
		let detail = data['details'].map(r => {
			r.Answer = JSON.parse(r.Answer);
			return r;
		});

		let list = data['reports'].map(r => {
			let _detail = detail.filter(x => x.ParentId == r.Rec_ID)

			let isTick = _detail.filter(o => o.Answer.tick == '').length > 0 ? 0 : 1;
			let isProblem = _detail.filter(o => o.Answer.problem == '').length > 0 ? 0 : 1;
			let isPlan = _detail.filter(o => o.Answer.plan == '').length > 0 ? 0 : 1;
			let isStock = _detail.filter(o => o.Answer.stockin == '').length > 0 ? 0 : 1;
			let isTest = _detail.filter(o => o.Answer == '').length > 0 ? 0 : 1;

			r.completeness = isTick && isProblem && isPlan && isStock && isTest;

			return r;
		});

		return list;
	}

	getHCCompleteness = (data) => {
		let list = data.reports.map(r => {
			let detail = JSON.parse(r.Detail)

			let children = [];
			for (let k in detail) {
				let d = detail[k];
				d.q = k;
				children.push(d);
			}

			//r.d = children;
			let isTick = children.filter(o => o.tick === '').length > 0 ? 0 : 1;
			let isQty = children.filter(o => o.qty == '').length > 0 ? 0 : 1;
			let [cases, problems] = children.filter(o => Array.isArray(o));
			let isProblem = problems.filter(o => o.problem == '').length > 0 ? 0 : 1;

			r.completeness = isProblem && isTick && isQty;
			return r;
		});
	}

	getODCompleteness = (data) => {
		let list = data.reports.map(r => {
			let detail = JSON.parse(r.Detail)

			let children = [];
			for (let k in detail) {
				let d = detail[k];
				d.q = k;
				children.push(d);
			}

			//r.d = children;
			let isTick = children.filter(o => o.tick === '').length > 0 ? 0 : 1;
			let isQty = children.filter(o => o.qty == '').length > 0 ? 0 : 1;
			let [budgets, problems] = children.filter(o => Array.isArray(o))
			let isBudget = budgets.filter(o => o.budget == '').length > 0 ? 0 : 1;
			let isProblem = problems.filter(o => o.problem == '').length > 0 ? 0 : 1;

			r.completeness = isBudget && isProblem && isTick && isQty;
			return r;
		});
	}

	self.showDelete = function (model) {
		if (app.user.role != 'AU' && model.InitUser.toLowerCase() != app.user.username.toLowerCase()) {
			app.showMsg('<kh>មិនអាចលុបបាន</kh>', '<kh>ម្ចាស់ដើមទើបអាចលុបបាន</kh>', true);
			return;
		}

		app.showDelete(function () {
			var submit = {
				table: self.tableName,
				value: { Deleted: 1, DeletedTime: 'getdate()', DeletedUser: app.user.username },
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/update', submit).done(function () {
				model.Deleted = 1;
				model.DeletedTime = moment().sqlformat('datetime');
				model.DeletedUser = app.user.username;

				self.listModel.notifySubscribers();
			});
		});
	};

	self.showRestore = function (model) {
		app.showRestore(function () {
			var submit = {
				table: self.tableName,
				value: { Deleted: 0, DeletedTime: null, DeletedUser: null },
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/update', submit).done(function () {
				model.Deleted = 0;
				model.DeletedTime = null;
				model.DeletedUser = null;

				self.listModel.notifySubscribers();
			});
		});
	};

	self.back = function () {
		self.view('list');
		window.scrollTo(0, self.lastScrollY);
	};

	self.getListModel = ko.pureComputed(function () {
		var list = self.listModel();

		if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
		else if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.prov() != null) list = list.filter(r => r.Code_Prov_N == self.prov());

		if (self.visitYear() != null) list = list.filter(r => r.VisitDate.substr(0, 4) == self.visitYear());

		return list.filter(r => r.Deleted == self.trashMode());
	});

	self.getTotalScore = function (row) {
		var score = 0;
		var keys = Object.keys(row);
		for (var i = 1; true; i++) {
			var name = 'Part' + i + 'Score';
			if (!keys.contain(name)) break;
			score += row[name];
		}
		return score.toFixed(0);
	};

	self.export = () => {
		var filename = self.tableName + '.xlsx';

		var submit = {
			tableName: self.tableName,
		};

		app.downloadBlob('/Checklist/exportExcel', submit).done(function (blob) {
			saveAs(blob, filename); //from FileSaver.js
		});
	};

	self.prov.subscribe(function (code) {
		self.odList(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
	});

	self.od.subscribe(function (code) {
		self.hcList(code == null ? [] : self.place.hc.filter(r => r.odcode == code));
	});

	self.getProvName = function (code) {
		return self.place.pv.find(r => r.code == code)?.nameK;
	};

	self.getODName = function (code) {
		return self.place.od.find(r => r.code == code)?.nameK;
	};

	self.getHCName = function (code) {
		return self.place.hc.find(r => r.code == code)?.nameK;
	};

	self.getDistName = function (code) {
		return self.place.ds.find(r => r.code == code)?.nameK;
	};

	self.getNextTrip = function () {
		let unit = window.location.pathname.split("/").pop();
	};

	self.showReport = function (model) {
		let report = window.location.pathname.split("/").pop()
		window.open("/Checklist/showReport/" + report + '/' + model.MissionNo);
	};

	self.showTrash = function () {
		self.trashMode(!self.trashMode());

		if (self.listModel().length == 0) self.listModel.notifySubscribers();
	};

	self.khmerNum = function (n) {
		var arr = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
		return n.toString().split('').map(r => arr[r]).join('');
	};

	if (typeof subViewModel === 'function') subViewModel(self);
}