var label = 'Annex 1: Village Selection';
$('.btnmenu').each(function (index, el) {
	if (location.pathname.contain($(el).attr('href'))) {
		$(el).removeClass('btn-default').addClass('btn-info');
		label = el.text;
	}
});

function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.detailModel = ko.observable();
	self.view = ko.observable('list');

	self.placeModel1 = ko.observable();
	self.placeModel2 = ko.observable();

	self.provList = ko.observableArray();
	self.odList = ko.observableArray();
	self.prov = ko.observable();
	self.od = ko.observable();
	self.hasSub = ko.observable(false);

	self.tab = ko.observable(label);

	var dbTable = '';
	var newModel = null;
	var place = null;
	var mainData = [];
	var prov = app.user.prov.length == 2 ? app.user.prov : sessionStorage.code_prov;

	self.getData = function (tableName) {
		dbTable = tableName;

		app.getPlace(['pv', 'od', 'hc', 'ds', 'cm', 'vl'], function (p) {
			place = p
			place.vl = place.vl.filter(r => isnull(r.nameK, '') != '');
			self.provList(place.pv.filter(r => r.target == 1));

			preparePlace1();
			preparePlace2();

			self.hasSub(true);

			app.ajax('/Question/getData/' + tableName).done(function (rs) {
				newModel = rs.model;
				mainData = rs.data;
				app.user.prov == '' ? self.prov('01') : self.prov(app.user.prov);
			});
		});
	};

	function preparePlace1() {
		var obj = {
			prov: ko.observable(),
			od: ko.observable(),
			hc: ko.observable(),
			vill: ko.observable(),
			provList: ko.observableArray(),
			odList: ko.observableArray(),
			hcList: ko.observableArray(),
			villList: ko.observableArray(),
			level: ko.observable(),
			callback: null
		};

		obj.provList(place.pv);

		obj.prov.subscribe(code => {
			obj.odList(place.od.filter(r => r.pvcode == code));
		});

		obj.od.subscribe(code => {
			obj.hcList(place.hc.filter(r => r.odcode == code));
		});

		obj.hc.subscribe(code => {
			obj.villList(place.vl.filter(r => r.hccode == code));
		});

		obj.show = function (level, callback) {
			obj.prov(prov);
			obj.od(app.user.od);
			obj.level(level);
			obj.callback = callback;
			app.removeAllWarning();
			$('#modalPlace1').modal('show');
		};

		obj.ok = function () {
			var missing = false;
			if (obj.prov() == null) {
				app.showWarning(obj.prov.element, 'Please select Province');
				missing = true;
			}
			if (obj.od() == null && obj.level() >= 2) {
				app.showWarning(obj.od.element, 'Please select OD');
				missing = true;
			}
			if (obj.hc() == null && obj.level() >= 3) {
				app.showWarning(obj.hc.element, 'Please select HC');
				missing = true;
			}
			if (obj.vill() == null && obj.level() >= 4) {
				app.showWarning(obj.vill.element, 'Please select Village');
				missing = true;
			}
			if (missing) return;

			obj.callback(obj);
			$('#modalPlace1').modal('hide');
		};

		self.placeModel1(obj);
	}

	function preparePlace2() {
		var obj = {
			prov: ko.observable(),
			dist: ko.observable(),
			comm: ko.observable(),
			vill: ko.observable(),
			provList: ko.observableArray(),
			distList: ko.observableArray(),
			commList: ko.observableArray(),
			villList: ko.observableArray(),
			level: ko.observable(),
			callback: null
		};

		obj.provList(place.pv);

		obj.prov.subscribe(code => {
			obj.distList(place.ds.filter(r => r.pvcode == code));
		});
		obj.dist.subscribe(code => {
			obj.commList(place.cm.filter(r => r.dscode == code));
		});
		obj.comm.subscribe(code => {
			obj.villList(place.vl.filter(r => r.cmcode == code));
		});

		obj.show = function (level, callback) {
			obj.prov(null);
			obj.level(level);
			obj.callback = callback;
			app.removeAllWarning();
			$('#modalPlace2').modal('show');
		};

		obj.ok = function () {
			var missing = false;
			if (obj.prov() == null) {
				app.showWarning(obj.prov.element, 'Please select Province');
				missing = true;
			}
			if (obj.dist() == null && obj.level() >= 2) {
				app.showWarning(obj.dist.element, 'Please select District');
				missing = true;
			}
			if (obj.comm() == null && obj.level() >= 3) {
				app.showWarning(obj.comm.element, 'Please select Commune');
				missing = true;
			}
			if (obj.vill() == null && obj.level() >= 4) {
				app.showWarning(obj.vill.element, 'Please select Village');
				missing = true;
			}
			if (missing) return;

			obj.callback(obj);
			$('#modalPlace2').modal('hide');
		};

		self.placeModel2(obj);
	};

	self.showNew = function () {
		self.showDetail(newModel);
	};

	self.showDetail = function (model) {
		model = app.ko(model);
		self.detailModel(model);
		ko.track(self.detailModel());
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

			if (dbTable == 'tblQuestion13') {
				var s = {
					table: 'tblVMWActiveCaseDection',
					where: { Q13ID: model.Rec_ID }
				};
				s = { submit: JSON.stringify(s) };

				app.ajax('/Direct/delete', s).done(function () {
					self.listModel.remove(model);
				});
			}
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

	function filterListModel() {
		var list = mainData;

		if (self.od() != null) list = list.filter(r => r.SubmitOD == self.od());
		else if (self.prov() != null) {
			var ods = place.od.filter(r => r.pvcode == self.prov()).map(r => r.code);
			list = list.filter(r => ods.contain(r.SubmitOD));
		}

		self.listModel(list);
	}

	self.getProvName = function (code) {
		var found = place.pv.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getODName = function (code) {
		var found = place.od.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getHCName = function (code) {
		var found = place.hc.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getVillName = function (code) {
		var found = place.vl.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getDistName = function (code) {
		var found = place.ds.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getCommName = function (code) {
		var found = place.cm.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getProvNameE = function (odcode) {
		var found = place.od.find(r => r.code == odcode);
		if (found == null) return odcode;
		found = place.pv.find(r => r.code == found.pvcode);
		return found == null ? code : found.name;
	};

	self.getODNameE = function (code) {
		var found = place.od.find(r => r.code == code);
		return found == null ? code : found.name;
	};

	if (typeof subViewModel === 'function') subViewModel(self);

	self.isSingle = function (arr) {
		return arr.length <= 1;
	};
}