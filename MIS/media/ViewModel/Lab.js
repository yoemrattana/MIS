function viewModel() {
	var self = this;

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();

	self.yearList = Array.range(2024, moment().year());
	self.year = ko.observable(moment().year());
	self.qt = ko.observable('Q1');
	self.smt = ko.observable('Semester 1');

	self.monthList = Array.range(0, 11).map(r => moment().month(r).format('MMM'));
	self.month = ko.observable(moment().format('MMM'));

	self.q = () => self.year() + ' ' + self.qt();
	self.s = () => self.year() + ' ' + self.smt();

	self.place = null;

	$('.menu').each(function () {
		if (!app.user.permiss['Lab'].contain(this.innerHTML)) $(this).remove();
		else if ($(this).attr('href') == location.pathname) $(this).addClass('active');
	});

	$('.menu2').each(function () {
		if ($(this).attr('href') == location.pathname) {
			$(this).addClass('active');
			var href = $(this).attr('href').split('_')[0];
			$('.menu[href="' + href + '_training"]').addClass('active');
		}
	});

	$('.pull-left').css({ 'left': $('.menubox').outerWidth() + 11 });

	app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
		p.pvAll = p.pv.slice();
		if (app.user.prov != '') p.pv = p.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') p.od = p.od.filter(r => r.code == app.user.od);
		
		self.place = p;
		self.pvList(p.pv);

		setTimeout(function () {
			if (self.prepare != null) self.prepare();

			if (app.user.hc != '') {
				self.pv(app.user.prov);
				self.od(app.user.od);
				self.hc(app.user.hc);
			}
		});
	});

	self.odList = function () {
		return self.pv() == null ? [] : self.place.od.filter(r => r.pvcode == self.pv());
	};

	self.hcList = function () {
		return self.od() == null ? [] : self.place.hc.filter(r => r.odcode == self.od() && r.type.in('RH','PRH','NH'));
	};

	self.getVLName = function (code) {
		var found = self.place.vl.find(r => r.code == code);
		return found == null ? '' : found.name;
	};

	self.getSpecies = function (value) {
		return value == 'F' ? 'PF'
			: value == 'V' ? 'PV'
			: value == 'M' ? 'PF/PV'
			: value == 'O' ? 'PO'
			: value == 'K' ? 'PK'
			: value == 'A' ? 'PM'
			: value == 'N' ? 'NMPS'
			: '';
	};

	var lstWarning = [];
	self.showWarning = function (bindingValue) {
		var el = $(bindingValue.element);

		function addError() {
			el.css('border', '2px solid red');
		}

		function removeError() {
			el.css('border', '');
		}

		function checkValue() {
			bindingValue() == null || bindingValue() === '' ? addError() : removeError();
		}

		addError();

		if (el.data('warnEvent') != null) return;
		el.data('warnEvent', bindingValue.subscribe(checkValue));
		lstWarning.push(removeError);
	};

	self.removeAllWarning = function () {
		lstWarning.forEach(f => f());
	};

	self.writeExcel = function (data, filename) {
		var wb = XLSX.utils.book_new();
		XLSX.utils.book_append_sheet(wb, XLSX.utils.json_to_sheet(data));
		XLSX.writeFile(wb, filename + '.xlsx', { compression: true });
	};

	subViewModel(self);
}