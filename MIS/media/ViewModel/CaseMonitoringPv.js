function viewModel() {
	var self = this;

	self.colspan = $('#tblmain > thead th').length;
	self.pvList = ko.observableArray();
	self.listModel = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.notifyDate = ko.observable('');
	self.editModel = ko.observable();
	self.filter = ko.observable();
	self.colorFilter = ko.observable('red');

	var rowLimit = app.newRowLimit(200);
	var place = null;

	app.getPlace(['pv', 'od', 'hc'], function (p) {
		place = p;
		place.od = place.od.filter(r => r.target == 1);
		self.pvList(place.pv.filter(r => r.target == 1));

		app.ajax('/CaseMonitoring/getData/pv').done(function (rs) {
			rs.forEach(prepareModel);

			self.listModel(rs);
		});
	});

	function prepareModel(model) {
		model.visible = ko.observable(model.visible || false);
		return model;
	}

	self.showEdit = function (model) {
		self.editModel(app.ko(model));

		$('#modalEdit').modal('show');
	};

	self.save = function () {
		$('#modalEdit').modal('hide');
		var model = app.unko(self.editModel());

		var submit = {
			Case_Type: model.ReportType,
			Case_ID: model.Rec_ID,
			CallDate: model.CallDate,
			CallPerson: model.CallPerson,
			Comment: model.Comment,
			CompleteDate: model.CompleteDate
		};

		app.ajax('/CaseMonitoring/save', submit).done(function () {
			var old = self.listModel().find(r => r.ReportType == model.ReportType && r.Rec_ID == model.Rec_ID);
			self.listModel.replace(old, prepareModel(model));
		});
	};

	self.getListModel = ko.pureComputed(function() {
		var list = self.listModel();
		
		if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());
		if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
		if (self.notifyDate() != '') list = list.filter(r => r.NotifyDate.substr(0, 10) == self.notifyDate());
		
		if (self.colorFilter() == 'red') list = list.filter(self.isRed);
		else if (self.colorFilter() == 'black') list = list.filter(r => r.CompleteDate != '' || (r.Day3 == 1 && r.Day7 == 1 && r.Day14 == 1));

		if (self.filter() == 'Eligible RCD') list = list.filter(r => r.Classify == 'L1');
		if (self.filter() == 'Eligible G6PD') list = list.filter(r => r.Weight >= 20 && r.Pregnant == 0);
		if (self.filter() == 'Eligible Followup') list = list.filter(r => r.Primaquine > 0);
		
		if (!rowLimit.scrolling) {
			window.scrollTo({ top: 0 });
			rowLimit.reset();
		}

		return list.slice(0, rowLimit());
	});

	self.isRed = function (r) {
		return r.CompleteDate == '' && (r.Day3 != 1 || r.Day7 != 1);
	};

	self.odList = function () {
		return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
	};

	self.hcList = function () {
		return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
	};

	self.rowClick = function (model, event) {
		if (event.target.innerHTML == 'Verify') return;
		if (event.target.className.contain('underline')) return;
		model.visible(!model.visible());
	};

	self.callClick = function (model) {
		if (model.CallDate() == '') {
			model.CallDate(moment().sqlformat('datetime'));
			return true;
		}
		else if (app.user.username.toLowerCase() == 'ou_vunsokserey') {
			model.CallDate('');
			return true;
		}
	};

	self.completeClick = function (model) {
		if (model.CompleteDate() == '') {
			model.CompleteDate(moment().sqlformat('datetime'));
			return true;
		}
		else if (app.user.username.toLowerCase() == 'ou_vunsokserey') {
			model.CompleteDate('');
			return true;
		}
	};

	self.showCaseEntryForm = function (model, event) {
		if (event.currentTarget.innerHTML == '') return;
		var obj = {
			year: model.ReportMonth.substr(0, 4),
			od: model.Code_OD_T,
			hc: model.ReportType == 'HC' ? undefined : model.Code_Facility_T,
			id: model.ReportType == 'HC' ? model.Code_Facility_T : model.Code_Vill_T,
			month: model.ReportMonth.substr(-2)
		};
		sessionStorage.code_prov = model.Code_Prov_N;
		window.open('/CaseReport/' + model.ReportType.replace('HC', 'HF') + '?s=' + JSON.stringify(obj));
	};

	self.showReactiveForm = function (model, event) {
		if (event.currentTarget.innerHTML == '') return;
		window.open('/Reactive/open/' + model.Rec_ID + '_' + model.ReportType);
	};

	self.getFollowupDate = function (model, day) {
		if (model.Primaquine == null) return '';
		var date = model.PrimaquineDate || model.DateCase;
		return moment(date).add(day, 'day').sqlformat();
	};

	self.exportExcel = function () {
		var submit = {
			data: JSON.stringify(self.getListModel())
		};

		app.downloadBlob('/CaseMonitoring/exportExcel', submit).done(function (blob) {
			saveAs(blob, 'PV Monitoring.xlsx'); //from FileSaver.js
		});
	};

	$(window).scroll(function () {
		if (innerHeight + scrollY + 1000 < document.body.scrollHeight) return;
		if (rowLimit() > self.listModel().length) return;

		rowLimit.scrolling = true;
		rowLimit.increase();
		rowLimit.scrolling = false;
	});
}