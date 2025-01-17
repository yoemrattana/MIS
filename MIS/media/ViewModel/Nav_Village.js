function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.addModel = ko.observable();
	self.addAnnexModel = ko.observable();
	self.editModel = ko.observable();
	self.moveModel = ko.observable();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.odFilter = ko.observable();
	self.hcFilter = ko.observable();
	self.isAdmin = ko.observable(app.user.role == 'AU');

	var mainData = [];
	var odData = [];
	var hcData = [];
	var distData = [];
	var commData = [];
	var prov = $('#code_prov').val();
	var place = null;
	var rowLimit = app.newRowLimit(200);

	app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
		place = p;

		odData = p.od.filter(r => r.pvcode == prov);
		var ods = odData.map(r => r.code);
		hcData = p.hc.filter(r => ods.contain(r.odcode));
		distData = p.ds.filter(r => r.pvcode == prov);
		var dss = distData.map(r => r.code);
		commData = p.cm.filter(r => dss.contain(r.dscode));

		self.odList(odData);
		self.hcList(hcData);

		app.ajax('/SystemMenu/getVillage/' + prov).done(function (data) {
			mainData = data;
			mainData.forEach(r => {
				if (r.HcDistance != null) {
					r.HcDistance = parseFloat(parseFloat(r.HcDistance).toFixed(2));
				}
			});

			mainData.sortasc(r => r.Name_Vill_E.toLowerCase());

			self.listModel(mainData);
		});
	});

	self.showAdd = function () {
		var model = {
			district: '',
			commune: '',
			od: '',
			hc: '',
			english: '',
			khmer: '',
			village: '',

			distList: distData,
			commList: [],
			odList: odData,
			hcList: []
		};

		model = app.ko(model);

		model.district.subscribe(code => {
			model.commList(commData.filter(r => r.dscode == code));
		});
		model.od.subscribe(code => {
			model.hcList(hcData.filter(r => r.odcode == code));
		});
		model.commune.subscribe(code => {
			if (code == null) return;
			var found = mainData.filter(r => r.Code_Comm_T == code);
			var n = 0;
			found.forEach(r => {
				var v = parseInt(r.Code_Vill_T.substr(6, 2));
				if (n < v) n = v;
			});
			n = (n + 1).toString().padStart(2, '0');
			model.village(code + n);
		});

		self.addModel(model);
		app.setNumberOnly(model.village.element, 'int');
		$('#modalAdd').modal('show');
	};

	self.add = function () {
		var model = self.addModel();

		model.english(model.english().trim());
		model.khmer(model.khmer().trim());

		var missing = false;
		if (model.district() == null) {
			app.showWarning(model.district.element, 'Please input this box.');
			missing = true;
		}
		if (model.commune() == null) {
			app.showWarning(model.commune.element, 'Please input this box.');
			missing = true;
		}
		if (model.od() == null) {
			app.showWarning(model.od.element, 'Please input this box.');
			missing = true;
		}
		if (model.hc() == null) {
			app.showWarning(model.hc.element, 'Please input this box.');
			missing = true;
		}
		if (model.english() == '') {
			app.showWarning(model.english.element, 'Please input this box.');
			missing = true;
		}
		if (model.khmer() == '') {
			app.showWarning(model.khmer.element, 'Please input this box.');
			missing = true;
		}
		if (model.village() == '' || parseInt(model.village()) == 0) {
			app.showWarning(model.village.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		if (mainData.some(r => r.Code_Vill_T == model.village() + '00')) {
			app.showWarning(model.village.element, 'Already existed.');
			return;
		}
		$('#modalAdd').modal('hide');

		var submit = {
			submit: JSON.stringify({
				Code_Prov_T: prov,
				Code_Dist_T: model.district(),
				Code_Comm_T: model.commune(),
				Name_Vill_E: model.english(),
				Name_Vill_K: model.khmer(),
				Code_Vill_Census: model.village(),
				HCCode: model.hc()
			})
		};

		app.ajax('/SystemMenu/saveVillage/insert', submit).done(function () {
			model = {
				Code_Dist_T: model.district(),
				Name_Dist_E: distData.find(r => r.code == model.district()).name,
				Code_Comm_T: model.commune(),
				Name_Comm_E: commData.find(r => r.code == model.commune()).name,
				Name_Vill_E: model.english(),
				Name_Vill_K: model.khmer(),
				Code_Vill_T: model.village() + '00',
				DistanceFromHC: null,
				HaveVMW: 0,
				VMWType: null,
				Unregistered: 0,
				BorderCountry: null,
				BorderDistance: null,
				Lat: null,
				long: null,
				LatLongUpdateDate: null,
				Lat_Census: null,
				Long_Census: null,
				IsLastmile: 0,
				LastmileStartDate: null,
				HCCode: model.hc(),
				Code_OD_T: model.od(),
				HCCode_Meeting: model.hc(),
				MeetingMonth: null,
				Census: null,
				TDA: null,
				IPT: null,
				AFS: null
			};
			mainData.unshift(model);

			self.hcFilter.notifySubscribers(self.hcFilter());
		});
	};

	self.showAddAnnex = function () {
		var model = {
			district: '',
			commune: '',
			village: '',
			english: '',
			khmer: '',
			annex: '',

			distList: distData,
			commList: [],
			villList: []
		};

		model = app.ko(model);

		model.district.subscribe(code => {
			model.commList(commData.filter(r => r.dscode == code));
		});
		model.commune.subscribe(code => {
			var vl = mainData.filter(r => r.Code_Comm_T == code && r.Code_Vill_T.substr(-2) == '00');
			vl = vl.map(r => ({ code: r.Code_Vill_T.substr(0, 8), name: r.Name_Vill_E }));
			model.villList(vl);
		});
		model.village.subscribe(code => {
			var found = mainData.filter(r => r.Code_Vill_T.substr(0, 8) == code);
			var n = 0;
			found.forEach(r => {
				var v = parseInt(r.Code_Vill_T.substr(-2));
				if (n < v) n = v;
			});
			n = (n + 1).toString().padStart(2, '0');
			model.annex(code + n);
		});

		self.addAnnexModel(model);
		$('#modalAddAnnex').modal('show');
	};

	self.addAnnex = function () {
		var model = self.addAnnexModel();

		model.english(model.english().trim());
		model.khmer(model.khmer().trim());

		var missing = false;
		if (model.district() == null) {
			app.showWarning(model.district.element, 'Please input this box.');
			missing = true;
		}
		if (model.commune() == null) {
			app.showWarning(model.commune.element, 'Please input this box.');
			missing = true;
		}
		if (model.village() == null) {
			app.showWarning(model.village.element, 'Please input this box.');
			missing = true;
		}
		if (model.english() == '') {
			app.showWarning(model.english.element, 'Please input this box.');
			missing = true;
		}
		if (model.khmer() == '') {
			app.showWarning(model.khmer.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalAddAnnex').modal('hide');

		var submit = {
			submit: JSON.stringify({
				Name_Vill_E: model.english(),
				Name_Vill_K: model.khmer(),
				Code_Vill_Census: model.village(),
				Code_Vill_T: model.annex(),
				Annex: model.annex().substr(-2)
			})
		};

		app.ajax('/SystemMenu/saveVillage/insertannex', submit).done(function () {
			var hc = mainData.find(r => r.Code_Vill_T.substr(0, 8) == model.village()).HCCode;

			model = {
				Code_Dist_T: model.district(),
				Name_Dist_E: distData.find(r => r.code == model.district()).name,
				Code_Comm_T: model.commune(),
				Name_Comm_E: commData.find(r => r.code == model.commune()).name,
				Name_Vill_E: model.english(),
				Name_Vill_K: model.khmer(),
				Code_Vill_T: model.annex(),
				DistanceFromHC: null,
				HaveVMW: 0,
				VMWType: null,
				Unregistered: 1,
				BorderCountry: null,
				BorderDistance: null,
				Lat: null,
				long: null,
				LatLongUpdateDate: null,
				Lat_Census: null,
				Long_Census: null,
				IsLastmile: 0,
				LastmileStartDate: null,
				HCCode: hc,
				Code_OD_T: place.hc.find(r => r.code == hc).odcode,
				HCCode_Meeting: hc,
				MeetingMonth: null,
				Census: null,
				TDA: null,
				IPT: null,
				AFS: null
			};

			mainData.unshift(model);
			self.hcFilter.notifySubscribers(self.hcFilter());
		});
	};

	self.showEdit = function (model) {
		model.od = place.hc.find(r => r.code == model.HCCode).odcode;
		model.odList = odData;
		model.hcList = [];
		model.countryList = ['Thailand', 'Vietnam', 'Laos', 'Sea'];
		model.distanceList = [{ code: '1', name: '1 km' }, { code: '2', name: '1-2 km' }, { code: '5', name: '2-5 km' }, { code: '10', name: '5-10 km' }];
		model.distList = distData,
		model.commList = [],

		model = app.ko(model);

		model.od.subscribe(code => {
			model.hcList(hcData.filter(r => r.odcode == code));
		});
		model.Code_Dist_T.subscribe(code => {
			model.commList(commData.filter(r => r.dscode == code));
		});

		model.od.notifySubscribers(model.od());
		model.Code_Dist_T.notifySubscribers(model.Code_Dist_T());

		model.HCCode.subscribe(code => model.HCCode_Meeting(code));

		self.editModel(model);

		app.setNumberOnly(model.DistanceFromHC.element, 'float');
		app.setNumberOnly(model.Lat.element, 'float');
		app.setNumberOnly(model.long.element, 'float');

		$('#modalEdit').modal('show');
	};

	self.edit = function () {
		var model = self.editModel();

		model.Name_Vill_E((model.Name_Vill_E() || '').trim());
		model.Name_Vill_K((model.Name_Vill_K() || '').trim());

		var missing = false;
		if (model.Name_Vill_E() == '') {
			app.showWarning(model.Name_Vill_E.element, 'Please input this box.');
			missing = true;
		}
		if (model.Name_Vill_K() == '') {
			app.showWarning(model.Name_Vill_K.element, 'Please input this box.');
			missing = true;
		}
		if (model.HCCode() == null) {
			app.showWarning(model.HCCode.element, 'Please input this box.');
			missing = true;
		}
		if (model.IsLastmile() == '1' && model.LastmileStartDate() == null) {
			app.showWarning(model.LastmileStartDate.element, 'Please input this box.');
			missing = true;
		}
		if (model.HaveVMW() == 1 && model.MeetingMonth() == '') {
			app.showWarning(model.MeetingMonth.element, 'Please input this box.');
			missing = true;
		}
		if (model.HaveVMW() == 1 && model.VMWType() == null) {
			app.showWarning(model.VMWType.element, 'Please input this box.');
			missing = true;
		}
		
		var hasActivity = ['Census', 'TDA', 'IPT', 'AFS'].some(r => model[r]());
		if (model.IsLastmile() == '1' && hasActivity == false) {
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);
		model.DistanceFromHC = isnullempty(model.DistanceFromHC) ? null : parseFloat(model.DistanceFromHC);

		model.LastmileStartDate = model.IsLastmile == 0 ? null : model.LastmileStartDate;
		model.Census = model.IsLastmile == 0 ? null : model.Census ? 1 : 0;
		model.TDA = model.IsLastmile == 0 ? null : model.TDA ? 1 : 0;
		model.IPT = model.IsLastmile == 0 ? null : model.IPT ? 1 : 0;
		model.AFS = model.IsLastmile == 0 ? null : model.AFS ? 1 : 0;
		model.VMWType = model.HaveVMW == 0 ? null : model.VMWType;

		var submit = {
			Code_Dist_T: model.Code_Dist_T,
			Code_Comm_T: model.Code_Comm_T,
			Name_Vill_E: model.Name_Vill_E,
			Name_Vill_K: model.Name_Vill_K,
			DistanceFromHC: model.DistanceFromHC,
			HaveVMW: model.HaveVMW,
			VMWType: model.VMWType,
			Unregistered: model.Unregistered,
			HCCode: model.HCCode,
			BorderCountry: model.BorderCountry || null,
			BorderDistance: model.BorderDistance || null,
			HCCode_Meeting: model.HCCode_Meeting,
			Lat: model.Lat,
			long: model.long,
			Code_Vill_T: model.Code_Vill_T,
			IsLastmile: model.IsLastmile,
			LastmileStartDate: model.LastmileStartDate,
			MeetingMonth: model.MeetingMonth || null,
			Census: model.Census,
			TDA: model.TDA,
			IPT: model.IPT,
			AFS: model.AFS
		};

		if (model.Lat != model.Lat_Census || model.long != model.Long_Census) {
			submit.LatLongUpdateDate = model.LatLongUpdateDate = moment().format('YYYY-MM-DD HH:mm:ss');
		}

		var submit = { submit: JSON.stringify(submit) };
		app.ajax('/SystemMenu/saveVillage/update', submit).done(function (rs) {
			var old = self.listModel().find(r => r.Code_Vill_T == model.Code_Vill_T);
			self.listModel.replace(old, model);

			var i = mainData.findIndex(r => r.Code_Vill_T == model.Code_Vill_T);
			mainData[i] = model;

			$('tr.success').removeClass('success');
			$("#" + model.Code_Vill_T).addClass('success');
		});
	};

	self.showMove = function (row) {
		var model = {
			fromPV: place.pv.find(r => r.code == prov).name,
			fromOD: self.getOdName(row.Code_OD_T),
			fromHC: self.getHcName(row.HCCode),
			fromVL: (isnull(row.Name_Vill_E, '') + ' ' + isnull(row.Name_Vill_K, '')).trim(),
			fromCode: row.Code_Vill_T,
			pv: prov,
			od: '',
			hc: '',
			vl: '',

			pvList: place.pv,
			odList: odData,
			hcList: [],
			vlList: []
		};

		model = app.ko(model);

		model.pv.subscribe(code => {
			model.odList(place.od.filter(r => r.pvcode == code));
		});

		model.od.subscribe(code => {
			model.hcList(place.hc.filter(r => r.odcode == code));
		});

		model.hc.subscribe(code => {
			var list = [];

			if (code != null) {
				list = place.vl.filter(r => r.hccode == code && r.code != row.Code_Vill_T).map(r => {
					return {
						code: r.code,
						name: (isnull(r.name, '') + ' ' + isnull(r.nameK)).trim()
					};
				});
			}

			model.vlList(list);
		});

		self.moveModel(model);
		$('#modalMove').modal('show');
	};

	self.moveData = function () {
		var model = self.moveModel();

		var missing = false;
		if (model.pv() == null) {
			app.showWarning(model.pv.element, 'Please input this box.');
			missing = true;
		}
		if (model.od() == null) {
			app.showWarning(model.od.element, 'Please input this box.');
			missing = true;
		}
		if (model.hc() == null) {
			app.showWarning(model.hc.element, 'Please input this box.');
			missing = true;
		}
		if (model.vl() == null) {
			app.showWarning(model.vl.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalMove').modal('hide');

		var submit = {
			submit: JSON.stringify({
				from: model.fromCode(),
				to: model.vl(),
			})
		};

		app.ajax('/SystemMenu/saveVillage/movedata', submit);
	};

	self.getDistName = function (code) {
		var obj = distData.find(r => r.code == code)
		return obj == null ? code : obj.name;
	};

	self.getCommName = function (code) {
		var obj = commData.find(r => r.code == code)
		return obj == null ? code : obj.name;
	};

	self.getOdName = function (code) {
		var obj = self.odList().find(r => r.code == code)
		return obj == null ? code : obj.name;
	};

	self.getHcName = function (code) {
		var obj = hcData.find(r => r.code == code)
		return obj == null ? '' : obj.name;
	};

	self.getBorder = function (value) {
		switch (value) {
			case null: return '';
			case 'T': return 'Thailand';
			case 'V': return 'Vietnam';
			case 'L': return 'Laos';
			case 'S': return 'Sea';
		}
	};

	self.getBorderDistance = function (value) {
		switch (value) {
			case null: return '';
			case '1': return '1 km';
			case '2': return '1-2 km';
			case '5': return '2-5 km';
			case '10': return '5-10 km';
		}
	};

	self.odFilter.subscribe(function (code) {
		var hcBefore = self.hcFilter();

		if (code == null) {
			self.hcList(hcData);
		} else {
			self.hcList(hcData.filter(r => r.odcode == code));
		}

		if (hcBefore == self.hcFilter()) {
			self.hcFilter.notifySubscribers(hcBefore);
		}
	});

	self.hcFilter.subscribe(function (code) {
		if (code != null) {
			self.listModel(mainData.filter(r => r.HCCode == code));
		} else if (self.odFilter() != null) {
			self.listModel(mainData.filter(r => r.Code_OD_T == self.odFilter()));
		} else {
			self.listModel(mainData);
		}

		rowLimit.reset();
	});

	self.delete = function (model) {
		app.showDelete(function () {
			var submit = { submit: JSON.stringify({ Code_Vill_T: model.Code_Vill_T }) };
			app.ajax('/SystemMenu/saveVillage/delete', submit).done(function (error) {
				if (error == null) self.listModel.remove(model);
				else app.showMsg('Unable to Delete', 'This village is in relationship with other tables.', true);
			});
		});
	};

	function getODFromHC(code) {
		return place.hc.find(r => r.code == code);
	}

	self.sortTable = function (col, method) {
		var before = self.listModel.slice(0);

		self.listModel.sort(function (a, b) {
			var aa = a[col], bb = b[col];
			if (method !== undefined) {
				aa = self[method](aa);
				bb = self[method](bb);
			}
			if (typeof aa == 'string' || typeof bb == 'string') {
				aa = (aa || '').toLowerCase();
				bb = (bb || '').toLowerCase();
			}
			return aa > bb ? 1 : aa < bb ? -1 : 0;
		});
		var rows = self.listModel();

		var sorted = true;
		for (var i = 0; i < before.length; i++) {
			if (before[i] === rows[i]) continue;
			sorted = false;
			break;
		}
		if (sorted) self.listModel.reverse();

		window.scrollTo({ top: 0 });
		rowLimit.reset();
	};

	self.getLastmileActivity = function (data) {
		return ['Census', 'TDA', 'IPT', 'AFS'].filter(r => data[r]).join(', ');
	};

	self.getListModel = ko.pureComputed(function () {
		return self.listModel().slice(0, rowLimit());
	});

	self.lastmileRequire = ko.pureComputed(function () {
		var model = self.editModel();
		if (model == null || model.IsLastmile() == 0) return false;
		return !['Census', 'TDA', 'IPT', 'AFS'].some(key => model[key]());
	});

	$(window).scroll(function () {
		if (innerHeight + scrollY + 1000 < document.body.scrollHeight) return;
		if (rowLimit() > self.listModel().length) return;

		rowLimit.increase();
	});
}