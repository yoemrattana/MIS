function viewModel() {
	var self = this;
	var today = moment();
	var place = null;

	self.monthList = [];
	self.filterType = ko.observable();

	self.year = ko.observable(moment().year());
	self.quarter = ko.observable();
	self.month = ko.observable();
	self.from = ko.observable();
	self.to = ko.observable(12);

	self.monthFrom = ko.computed(() => {
		return self.filterType() == 'q' ? self.quarter().substr(1) * 3 - 2
			: self.filterType() == 'm' ? parseInt(self.month())
			: self.filterType() == 'cus' ? parseInt(self.from())
			: 1;
	});

	self.monthTo = ko.computed(() => {
		return self.filterType() == 'q' ? self.quarter().substr(1) * 3
			: self.filterType() == 'm' ? parseInt(self.month())
			: self.filterType() == 'cus' ? parseInt(self.to())
			: 12;
	});

	self.rgList = ko.observableArray();
	self.unitList = ko.observableArray();
	self.unitList = ko.observableArray();
	self.gpList = ko.observableArray();

	self.rg = ko.observable();
	self.pv = ko.observable();
	self.unit = ko.observable();
	self.gp = ko.observable();

	self.listModel = ko.observableArray();
	self.report = ko.observable(null);
	self.title = ko.observable();

	for (var i = 1; i <= 12; i++) {
		self.monthList.push({ value: i, text: moment(i, 'M').format('MMM') });
	}

	app.getPlace(['rg', 'gp', 'unit'], function (rs) {
		place = rs;
		self.rgList(place.rg);
	});

	self.getReport = function (model, event) {
		var submit = {
			y: self.year(),
			mf: self.monthFrom(),
			mt: self.monthTo(),
			rg: '',
			unit: '',
			gp: ''
		};
		if (self.rg() != null) submit.rg = self.rg();
		if (self.unit() != null) submit.unit = self.unit();
		if (self.gp() != null) submit.gp = self.gp();

		var title = event.currentTarget.innerHTML + ' - ' + self.year() + ' ';
		if (self.filterType() == 'quarter') {
			title += self.quarter();
		} else if (self.filterType() == 'month') {
			title += moment(self.month(), 'M').format('MMM');
		} else if (self.filterType() == 'custom') {
			title += moment(self.from(), 'M').format('MMM') + ' - ' + moment(self.to(), 'M').format('MMM');
		}
		self.title(title);

		var sp = event.currentTarget.name;
		var link = '/ReportMilitary/getReport/' + sp;
		app.ajax(link, submit).done(function (rs) {
			console.log(submit);
			self.listModel(rs);
			self.report(sp);
		});
	};

	self.previousClick = function () {
		self.year(self.year() - 1);
	};

	self.nextClick = function () {
		self.year(self.year() + 1);
	};

	self.resetClick = function () {
		self.filterType(null);
		self.year(moment().year());
		self.quarter('Q1');
		self.month(1);
		self.from(1);
		self.to(12);
	};

	self.rg.subscribe(code => {
		if (code == null) self.unitList([]);
		else {
			self.unitList(place.unit.filter(r => r.rgcode == code));
		}
	});

	self.unit.subscribe(code => {
		self.gpList(code == null ? [] : place.gp.filter(r => r.unitcode == code));
	});

	self.back = function () {
		self.report(null);
	};

	self.valueByMonth = function (model, index) {
		if (index < getMonthFrom() || index > getMonthTo()) return '';
		if (self.year() == today.year() && index > today.month()) return ''
		return model[moment(index + 1, 'M').format('MM')];
	};

	self.bgWarning = function (model, index) {
		var value = self.valueByMonth(model, index);
		return value !== '' && value < 80 ? '#ffff99' : '';
	};

	function getMonthFrom() {
		if (self.filterType() == null) return 0;
		else if (self.filterType() == 'quarter') return (self.quarter().substr(-1) - 1) * 3;
		else if (self.filterType() == 'month') return self.month() - 1;
		else if (self.filterType() == 'custom') return self.from() - 1;
	}

	function getMonthTo() {
		if (self.filterType() == null) return 11;
		else if (self.filterType() == 'quarter') return ((self.quarter().substr(-1) - 1) * 3) + 2;
		else if (self.filterType() == 'month') return self.month() - 1;
		else if (self.filterType() == 'custom') return self.to() - 1;
	}
};