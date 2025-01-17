function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.detailModel = ko.observable();
	self.view = ko.observable('list');

	self.pvList = ko.observableArray();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();

	self.yearList = [];
	self.year = ko.observable();
	self.completed = ko.observable();
	self.filter = ko.observable('Real');
	self.place = null;
	self.dateList = ko.observableArray();

	for (var i = 2019; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}

	self.foci1 = new foci1ViewModel(self);
	self.foci2 = new foci2ViewModel(self);

	app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
		self.place = p;
		if (app.user.prov != '') self.place.pv = self.place.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') self.place.od = self.place.od.filter(r => r.code == app.user.od);

		var arr = self.place.od.map(r => r.pvcode).distinct();
		self.place.pv = self.place.pv.filter(r => arr.contain(r.code));
		self.pvList(self.place.pv);

		var open = $('#open').val();
		if (open == '') {
			app.ajax('/Foci/getData').done(function (rs) {
				self.listModel(rs);
			});
		} else {
			self.view(null);
			open == 'foci1' ? self.foci1.showDetail() : self.foci2.showDetail();
		}
	});

	self.showDetail = function (model) {
		if (model.TableName == 'tblFociInvestigation') {
			self.foci1.showDetail(model);
		} else {
			self.foci2.showDetail(model);
		}
	};

	self.delete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: model.TableName,
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.pv.subscribe(function (code) {
		self.odList(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
	});

	self.od.subscribe(function (code) {
		self.hcList(code == null ? [] : self.place.hc.filter(r => r.odcode == code));
	});

	self.getListModel = ko.pureComputed(function () {
		var list = self.listModel();

		if (self.completed() != 'All') list = list.filter(r => r.Completed == self.completed());

		if (self.filter() == 'Real') {
			if (self.year() != null) list = list.filter(r => r.FociInvestigationDate.substr(0, 4) == self.year());
			list = list.filter(r => r.Tag == 'Real');
		}
		else {
			if (self.year() != null) list = list.filter(r => (r.YearMonth || '').substr(0, 4) == self.year());
			list = list.filter(r => r.DateCase < r.FociInvestigationDate);
			list = list.groupby('Code_Vill_T').map(r => r[0]);
		}

		if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
		else if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());

		return list;
	});

	self.getODName = function (code) {
		var found = self.place.od.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getHCName = function (code) {
		var found = self.place.hc.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getVLName = function (code) {
		var found = self.place.vl.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getDiagnosisDate = function (code) {
		var founds = self.listModel().filter(r => r.Code_Vill_T == code && r.DateCase != null);

		return founds.length == 0 ? ''
			: founds.length == 1 ? moment(founds[0].DateCase).displayformat()
			: founds.length + ' Cases';
	};

	self.showDateList = function (model) {
		if (model.DateCase == null) return;

		self.dateList(self.listModel().filter(r => r.Code_Vill_T == model.Code_Vill_T).sortasc('DateCase'));
		$('#modalDateList').modal('show');
	};
}