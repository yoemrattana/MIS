function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.detailList = ko.observableArray();
	self.offerModel = ko.observable();
	self.rejectModel = ko.observable();
	self.view = ko.observable('list');

	self.provList = ko.observableArray();
	self.odList = ko.observableArray();
	self.yearList = ko.observableArray();
	self.monthList = ko.observableArray();

	self.prov = ko.observable();
	self.od = ko.observable();
	self.status = ko.observable();
	self.year = ko.observable(moment().year());
	self.month = ko.observable();

	self.detailName = ko.observable();
	self.detailMonth = ko.observable();

	var place = null;
	var mainData = [];

	for (var i = 2018; i <= self.year() ; i++) {
		self.yearList.push(i);
	}
	for (var i = 1; i <= 12; i++) {
		self.monthList.push({ id: i, name: ('0' + i).substr(-2) });
	}

	app.getPlace(['pv', 'od'], function (rs) {
		place = rs;
		if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);
		self.provList(place.pv);
	});

	app.ajax('/Stock/getRequest').done(function (rs) {
		mainData = rs;
		filterListModel();
	});

	self.detailClick = function (model) {
		var submit = {
			hf: model.Code_Facility_T,
			year: model.Year,
			month: model.Month
		};

		self.detailName(model.Name_Facility_E);
		self.detailMonth(model.Month + '-' + model.Year);

		app.ajax('/Stock/getDetail', submit).done(function (rs) {
			rs.forEach(r => r.Estimate = (r.AMC * 2) - r.Balance);
			self.detailList(rs);
			self.view('detail');
		});
	};

	self.showOffer = function (model) {
		model.Comment = '';
		model = app.ko(model);
		self.offerModel(model);
		app.setNumberOnly(model.Offer.element, 'int');
		$('#modalOffer').modal('show');
	};

	self.showReject = function (model) {
		model.Comment = '';
		self.rejectModel(app.ko(model));
		$('#modalReject').modal('show');
	};

	self.saveOffer = function () {
		var model = self.offerModel();

		if (model.Offer() == null || model.Offer() == '') {
			app.showWarning(model.Offer.element, 'Please input this box.');
			return;
		}
		$('#modalOffer').modal('hide');

		var submit = {
			id: model.Rec_ID(),
			offer: model.Offer(),
			comment: model.Comment()
		};

		app.ajax('/Stock/offer', submit).done(function () {
			var old = self.detailList().find(r => r.Rec_ID == model.Rec_ID());
			var newModel = JSON.parse(JSON.stringify(old));
			newModel.Offer = model.Offer();
			newModel.Status = 'Offered';
			newModel.Comment = model.Comment();
			self.detailList.replace(old, newModel);
		});
	};

	self.saveReject = function (model) {
		$('#modalReject').modal('hide');

		var model = self.rejectModel();

		var submit = {
			table: 'tblStockV2',
			value: { Request: null, Status: 'Rejected', Comment: model.Comment(), CommentDate: 'getdate()' },
			where: { Rec_ID: model.Rec_ID() }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			var old = self.detailList().find(r => r.Rec_ID == model.Rec_ID());
			var newModel = JSON.parse(JSON.stringify(old));
			newModel.Status = 'Rejected';
			newModel.Comment = model.Comment();
			self.detailList.replace(old, newModel);
		});
	};

	self.back = function () {
		self.view('list');
	};

	self.prov.subscribe(function (code) {
		var before = self.od();
		self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code && r.target == 1));
		if (self.od() == before) filterListModel();
	});

	self.od.subscribe(filterListModel);

	self.status.subscribe(filterListModel);

	self.year.subscribe(filterListModel);

	self.month.subscribe(filterListModel);

	function filterListModel() {
		var list = mainData;

		if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.prov() != null) list = list.filter(r => r.Code_Prov_T == self.prov());
		list = list.filter(r => r.Status == self.status());
		list = list.filter(r => r.Year == self.year());
		if (self.month() != null) list = list.filter(r => r.Month == self.month());

		self.listModel(list);
	}
}