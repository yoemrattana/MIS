$('.btnmenu').each(function (index, el) {
	if ($(el).attr('href') == location.pathname) {
		$(el).removeClass('btn-default').addClass('btn-info');
	}
});

function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.detailModel = ko.observable();
	self.view = ko.observable('list');
	self.menu = ko.observable(location.pathname.split('/').last());

	self.hasSub = ko.observable(false);
	self.datatype = null;
	self.hcNames = {
		'01': 'Trapeang Cho',
		'02': 'Phnom Kravanh',
		'03': 'Pramaoy',
		'04': 'Samraong',
		'05': 'Chambak',
		'06': 'Monor Rung Roeang',
		'07': 'Phnom Kravanh_RH',
		'08': 'Prongil',
		'09': 'Kampong Speu RH',
		'10': 'Cheung Roas Samaki',
		'11': 'Anglong Reap',
		'12': 'Chheu Tom',
		'13': 'Boeng Kantuot',
		'14': 'Ta Lat',
		'15': 'Chhouk Meas',
		'16': 'Pursat RH',
		'17': 'Kat Phluk',
		'18': 'Trapeang Kraloeung',
		'19': 'Bakan RH',
		'20': 'Ro Leab'
	};
	self.hcList = Object.keys(self.hcNames).map(r => { return { id: r, name: self.hcNames[r] } }).sortasc('name');
	self.hc = ko.observable();

	var dbTable = '';

	self.getData = function (tableName) {
		dbTable = tableName;
		self.hasSub(true);

		app.ajax('/CRF/getData/' + tableName).done(function (rs) {
			self.datatype = rs.datatype;
			newModel = rs.model;
			self.listModel(rs.data);
		});
	};

	self.getListModel = ko.pureComputed(function () {
		return self.hc() == null ? self.listModel()
			: self.listModel().filter(r => r.ParticipantCode.substr(0, 2) == self.hc());
	});

	self.showNew = function () {
		self.showDetail(newModel);
	};

	self.showDetail = function (model) {
		var model = app.ko(model);
		Object.keys(model).forEach(name => {
			if (self.datatype.date.contain(name) && model[name]() != null) {
				model[name](moment(model[name]()));
			}
		});

		self.detailModel(model);
		self.view('detail');

		$('.numonly').each(function (index, el) {
			app.setNumberOnly(el, $(el).attr('data-type'));
		});
	};

	self.delete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: dbTable,
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.back = function () {
		self.view('list');
	};

	self.validateCode = function (patient) {
		if (patient == '') return 'Code required!';
		if (patient.length != 6) return 'Code must be 6 digits!';
		var site = patient.substring(0, 2);
		if (!site.in(Object.keys(self.hcNames))) return 'Invalid site code!';
		return '';
	}

	if (typeof subViewModel === 'function') subViewModel(self);
}