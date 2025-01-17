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
	self.logList = ko.observableArray();

	self.placeModel1 = ko.observable();

	self.provList = ko.observableArray();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.prov = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.hasSub = ko.observable(false);
	self.tab = ko.observable();

	self.datatype = null;

	var dbTable = '';
	var place = null;
	var mainData = [];
	var newModel = null;
	var lastScrollY = 0;

	self.getData = function (tableName) {
	    dbTable = tableName;
	    
		app.getPlace(['pv', 'od', 'hc'], function (p) {
			place = p;
			self.provList(place.pv.filter(r => r.target == 1));

			self.prov('05');
			self.od('0501');

			preparePlace1();
			self.hasSub(true);

			var submit = {
				tbl: tableName,
				recid: new URLSearchParams(location.search).get('recid')
			};
			app.ajax('/QMalaria/getData', submit).done(function (rs) {
				mainData = rs.data;
				self.datatype = rs.datatype;
				newModel = rs.model;

				filterListModel();

				if (submit.recid != null) self.showDetail(mainData[0]);
			});
		});
	};

	self.getIdentityCode = function (obj) {
		var code = isnull(isnull(obj.PatientCode, obj.ParticipantCode), obj.DocNumber);
		return code.contain('MA011') ? code : 'MA011' + code;
	};

	self.getActivityDate = function (obj) {
		var date = dbTable == 'tblQMLabo' ? obj.BloodDate
			: dbTable == 'tblQMClinic' ? obj.ConsultDate
			: dbTable == 'tblQMFollowup' ? obj.ConsultDate
			: dbTable == 'tblQMBaselineData' ? obj.DataEntryDate
			: '';
		return date == '' ? '' : moment(date).format('DD-MM-YYYY');
	};

	function preparePlace1() {
		var obj = {
			prov: ko.observable(),
			od: ko.observable(),
			hc: ko.observable(),
			provList: ko.observableArray(),
			odList: ko.observableArray(),
			hcList: ko.observableArray(),
			callback: null
		};

		obj.provList(place.pv);

		obj.prov.subscribe(code => {
			obj.odList(place.od.filter(r => r.pvcode == code));
		});

		obj.od.subscribe(code => {
			obj.hcList(place.hc.filter(r => r.odcode == code));
		});

		obj.show = function (callback, modal) {
			obj.prov(null);
			obj.callback = callback;
			app.removeAllWarning();
			$(modal == null ? '#modalPlace1' : modal).modal('show');
		};

		obj.showEnglish = function (callback) {
			obj.show(callback, '#modalPlace1English');
		};

		obj.ok = function () {
			var missing = false;
			if (obj.prov() == null) {
				app.showWarning(obj.prov.element, 'Please select Province');
				missing = true;
			}
			if (obj.od() == null) {
				app.showWarning(obj.od.element, 'Please select OD');
				missing = true;
			}
			if (obj.hc() == null) {
				app.showWarning(obj.hc.element, 'Please select HC');
				missing = true;
			}
			if (missing) return;

			obj.callback(obj);
			$('#modalPlace1, #modalPlace1English').modal('hide');
		};

		self.placeModel1(obj);
	}

	self.showNew = function () {
		self.showDetail(newModel);
	};

	self.showDetail = function (model) {
		lastScrollY = window.scrollY;

		var model = app.ko(model);

		Object.keys(model).forEach(name => {
			if (name == '__ko_mapping__') return;

			model[name].oldValue = model[name]();

			if (self.datatype.date.contain(name) && model[name]() != null) {
				model[name](moment(model[name]()));
			}
		});

		self.detailModel(model);
		self.view('detail');

		window.scrollTo(0, 0);

		$('.numonly').each(function (index, el) {
			app.setNumberOnly(el, $(el).attr('data-type'));
		});
	};

	self.showLog = function (model) {
		var submit = { ParentID: model.Rec_ID };
		app.ajax('/QMalaria/getLog/' + dbTable + 'Log', submit).done(function (rs) {
			self.logList(rs);
			self.view('log');
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
		window.opener == null ? self.view('list'): window.close();
		window.scrollTo(0, lastScrollY);
	};

	self.exportExcel = function () {
		if (self.listModel().length == 0) return;
		
		var submit = {
			filename: location.pathname.split("/")[3]
		};
		app.downloadBlob('/QMalaria/exportExcel', submit).done(function (blob) {
			saveAs(blob, submit.filename + '.xlsx'); //from FileSaver.js
		});
	};

	self.exportAll = function () {
		app.downloadBlob('/QMalaria/exportAll').done(function (blob) {
			saveAs(blob, 'Labo & Clinical.xlsx'); //from FileSaver.js
		});
	};

	self.prov.subscribe(function (code) {
		var before = self.od();
		self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code && r.target == 1));
		if (self.od() == before) filterListModel();
	});

	self.od.subscribe(function (code) {
		var before = self.hc();
		self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
		if (self.hc() == before) filterListModel();
	});

	self.hc.subscribe(filterListModel);

	function filterListModel() {
		var list = mainData;
		
		if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
		else if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.prov() != null) list = list.filter(r => r.Code_Prov_N == self.prov());

		self.listModel(list);
	}

	self.getProvName = function (code) {
		return place.pv.find(r => r.code == code).nameK;
	};

	self.getODName = function (code) {
		return place.od.find(r => r.code == code).nameK;
	};

	self.getHCName = function (code) {
		return place.hc.find(r => r.code == code).nameK;
	};

	self.getProvNameE = function (hccode) {
		var odcode = place.hc.find(r => r.code == hccode).odcode;
		var pvcode = place.od.find(r => r.code == odcode).pvcode;
		return place.pv.find(r => r.code == pvcode).name;
	};

	self.getODNameE = function (hccode) {
		var odcode = place.hc.find(r => r.code == hccode).odcode;
		return place.od.find(r => r.code == odcode).name;
	};

	self.getHCNameE = function (code) {
		return code == '' ? '' : place.hc.find(r => r.code == code).name;
	};

	if (typeof subViewModel === 'function') subViewModel(self);
}