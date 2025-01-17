function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.staffList = ko.observableArray();
	self.loaded = ko.observable(false);
	self.placeModel = ko.observable();

	self.prepare = function () {
		if (app.user.prov == '') self.pvList.unshift({ code: 'CNM', name: 'CNM' });
		self.pv.subscribe(() => self.loaded(false));
		self.od.subscribe(() => self.loaded(false));
		self.hc.subscribe(() => self.loaded(false));
		self.year.subscribe(() => self.loaded(false));
		self.month.subscribe(() => self.loaded(false));
	};

	self.viewClick = function () {
		if (self.pv() != 'CNM' && self.hc() == null) {
			self.loaded(false);
			return;
		}

		var submit = {
			hc: self.pv() == 'CNM' ? 'CNM' : self.hc(),
			year: self.year(),
			month: moment(self.month(), 'MMM').format('MM'),
			needStaff: self.staffList().length == 0 ? 1 : 0
		};
		return app.ajax('/Lab/getLogbook', submit).done(function (rs) {
			rs.staff && self.staffList(rs.staff);
			self.listModel(rs.list.map(app.ko));
			self.loaded(true);

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.addNew = function () {
		var model = {
			Rec_ID: null,
			Code_Facility_T: self.pv() == 'CNM' ? 'CNM' : self.hc(),
			Year: self.year(),
			Month: moment(self.month(), 'MMM').format('MM'),
			Name: '',
			Age: null,
			Sex: null,
			Address: null,
			CrossArea: null,
			TransferFrom: null,
			RDT: null,
			D1: null,
			D2: null,
			ParasiteCount: null,
			C1: null,
			C2: null,
			G6PD: null,
			Hb: null,
			Hb3: null,
			Hb7: null,
			CollectionDate: null,
			Staff_ID: null
		};
		self.listModel.push(app.ko(model));

		$('input[numonly]').each(function () {
			app.setNumberOnly(this, $(this).attr('numonly'));
		});
	};

	self.save = function () {
		if (self.listModel().length == 0) return;

		var missing = false;
		self.removeAllWarning();

		self.listModel().forEach(r => {
			Object.keys(r).forEach(k => {
				if (k.in('TransferFrom', 'RDT', 'D2', 'ParasiteCount', 'C1', 'C2', 'G6PD', 'Hb', 'Hb3', 'Hb7')) return;
				if (r[k].element != null && (r[k]() || '') == '') {
					if (r.D1() == 'N' && k.in('Name', 'CrossArea')) return;
					self.showWarning(r[k]);
					missing = true;
				}
			});
		});
		if (missing) return;

		var list = self.listModel().map(r => {
			r = app.unko(r);
			return {
				Rec_ID: r.Rec_ID,
				Code_Facility_T: r.Code_Facility_T,
				Year: r.Year,
				Month: r.Month,
				Name: r.Name,
				Age: r.Age,
				Sex: r.Sex,
				Address: r.Address,
				CrossArea: r.CrossArea,
				TransferFrom: r.TransferFrom,
				RDT: r.RDT,
				D1: r.D1,
				D2: r.D2,
				ParasiteCount: r.ParasiteCount || null,
				C1: r.C1,
				C2: r.C2,
				G6PD: r.G6PD || null,
				Hb: r.Hb || null,
				Hb3: r.Hb3 || null,
				Hb7: r.Hb7 || null,
				CollectionDate: r.CollectionDate,
				Staff_ID: r.Staff_ID || null,
				ModiUser: app.user.username,
				ModiTime: moment().sqlformat('datetime')
			};
		});

		var submit = {
			list: JSON.stringify(list)
		};
		app.ajax('/Lab/saveLogbook', submit).done(function (rs) {
			self.viewClick().done(function () {
				app.showMsg('Save Completed');
			});
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			if (model.Rec_ID() == null) {
				self.listModel.remove(model);
			} else {
				var submit = {
					table: 'tblLabLogbook',
					where: { Rec_ID: model.Rec_ID() }
				};
				submit = { submit: JSON.stringify(submit) };

				app.ajax('/Direct/delete', submit).done(function () {
					self.listModel.remove(model);
				});
			}
		});
	};

	self.getPlaceName = function (code) {
		return code == null ? ''
			: code.length == 2 ? self.place.pv.find(r => r.code == code).name
			: code.length == 4 ? self.place.ds.find(r => r.code == code).name
			: code.length == 6 ? self.place.cm.find(r => r.code == code).name
			: self.place.vl.find(r => r.code == code).name;
	};

	self.choosePlace = function (row) {
		var value = row.Address;
		var place = self.place;

		var model = {
			pvList: ko.observableArray(place.pvAll),
			pv: ko.observable(),
			ds: ko.observable(),
			cm: ko.observable(),
			vl: ko.observable()
		};

		model.dsList = () => model.pv() == null ? [] : place.ds.filter(r => r.pvcode == model.pv());
		model.cmList = () => model.ds() == null ? [] : place.cm.filter(r => r.dscode == model.ds());
		model.vlList = () => model.cm() == null ? [] : place.vl.filter(r => r.cmcode == model.cm());

		if (value() != null) {
			var pv, ds, cm, vl;
			var code = value();

			if (code.length == 10) {
				var found = place.vl.find(r => r.code == code);
				if (found != null) {
					vl = code;
					code = found.cmcode;
				}
			}
			if (code.length == 6) {
				var found = place.cm.find(r => r.code == code);
				if (found != null) {
					cm = code;
					code = found.dscode;
				}
			}
			if (code.length == 4) {
				var found = place.ds.find(r => r.code == code);
				if (found != null) {
					ds = code;
					code = found.pvcode;
				}
			}
			if (code.length == 2) {
				var found = place.pv.find(r => r.code == code);
				if (found != null) pv = code;
			}
			if (pv != null) model.pv(pv);
			if (ds != null) model.ds(ds);
			if (cm != null) model.cm(cm);
			if (vl != null) model.vl(vl);
		}

		model.ok = function () {
			var code = null;

			if (model.vl() != null) code = model.vl();
			else if (model.cm() != null) code = model.cm();
			else if (model.ds() != null) code = model.ds();
			else if (model.pv() != null) code = model.pv();

			value(code);
		};

		self.placeModel(model);
		$('#modalPlace .modal-title').text('Select Address');
		$('#modalPlace').modal('show');
	};

	self.exportExcel = function () {
		if (self.pv() == null) {
			var submit = { year: self.year() };
			app.ajax('/Lab/getLogbook', submit).done(function (rs) {
				rs.list.sortasc('Name_Prov_E', 'Name_OD_E', 'Name_Facility_E', 'Month');
				prepare(rs.list);
			});
		} else {
			prepare(self.listModel().map(app.unko));
		}

		function prepare(arr) {
			var data = arr.map(r => {
				return {
					'Province': r.Name_Prov_E,
					'OD': r.Name_OD_E,
					'RH': r.Name_Facility_E,
					'Year': r.Year,
					'Month': r.Month,
					'Slide ID': r.Rec_ID,
					'Name': r.Name,
					'Age': r.Age,
					'Sex': r.Sex,
					'Address': self.getPlaceName(r.Address),
					'Cross Area': r.CrossArea,
					'Transfer From': r.TransferFrom,
					'RDT': self.getSpecies(r.RDT),
					'D1': self.getSpecies(r.D1),
					'D2': self.getSpecies(r.D2),
					'Parasite Count': r.ParasiteCount,
					'C1': r.C1,
					'C2': r.C2,
					'G6PD': r.G6PD,
					'Hb': r.Hb,
					'Hb-3': r.Hb3,
					'Hb-7': r.Hb7,
					'Collection Date': moment(r.CollectionDate).toDate(),
					'Lab Staff': (self.staffList().find(x => x.Staff_ID == r.Staff_ID) || {}).Name
				};
			});
			self.writeExcel(data, 'Log Book');
		}
	};
}