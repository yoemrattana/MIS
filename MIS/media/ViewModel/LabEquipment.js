function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.detailList = ko.observableArray();
	self.loaded = ko.observable(false);

	var eid = null;

	self.prepare = function () {
		if (app.user.prov == '') self.pvList.unshift({ code: 'CNM', name: 'CNM' });
		self.pv.subscribe(() => self.loaded(false));
		self.od.subscribe(() => self.loaded(false));
		self.hc.subscribe(() => self.loaded(false));
	};

	self.viewClick = function () {
		if (self.pv() != 'CNM' && self.hc() == null) {
			self.loaded(false);
			return;
		}

		var submit = {
			hc: self.pv() == 'CNM' ? 'CNM' : self.hc()
		};
		app.ajax('/Lab/getEquipment', submit).done(function (rs) {
			rs.forEach(r => {
				r.Code_Facility_T = submit.hc;
				r.ItemName = ko.observable(r.ItemName);
			});
			self.listModel(rs);

			if (self.listModel().length == 0) self.addItem();

			self.loaded(true);
		});
	}

	self.addItem = function () {
		var model = {
			Rec_ID: null,
			Code_Facility_T: self.pv() == 'CNM' ? 'CNM' : self.hc(),
			ItemName: ko.observable(''),
			Manufacturer: '',
			Model: '',
			Serial: '',
			ReceivedDate: '',
			Quality: '',
			Condition: '',
			NeedMaintenance: ''
		};
		self.listModel.push(model);
	};

	self.save = function () {
		var missing = false;

		self.listModel().forEach(r => {
			if (r.ItemName() == '') {
				self.showWarning(r.ItemName);
				missing = true;
			}
		});
		if (missing) {
			app.showMsg('Missing Data', 'Please input data into the red boxes.');
			return;
		}

		var list = self.listModel().map(r => {
			return {
				Rec_ID: r.Rec_ID,
				Code_Facility_T: r.Code_Facility_T,
				ItemName: r.ItemName(),
				Manufacturer: r.Manufacturer,
				Model: r.Model,
				Serial: r.Serial,
				ReceivedDate: r.ReceivedDate || null,
				Quality: r.Quality,
				Condition: r.Condition,
				NeedMaintenance: r.NeedMaintenance,
				ModiUser: app.user.username,
				ModiTime: moment().sqlformat('datetime')
			};
		});

		var submit = {
			list: JSON.stringify(list),
			hc: self.pv() == 'CNM' ? 'CNM' : self.hc()
		};
		app.ajax('/Lab/saveEquipment', submit).done(self.viewClick);
	};

	self.deleteItem = function (model) {
		app.showDelete(function () {
			if (model.Rec_ID == null) {
				self.listModel.remove(model);
			} else {
				var submit = { id: model.Rec_ID };
				app.ajax('/Lab/deleteEquipment', submit).done(function (error) {
					if (error) app.showMsg('Cannot delete this equipment', 'This equipment is linked with some data.', true);
					else self.listModel.remove(model);
				});
			}
		});
	};

	self.showDetail = function (model) {
		var submit = {
			Equipment_ID: model.Rec_ID
		};
		eid = model.Rec_ID;

		app.ajax('/Lab/getMaintenance', submit).done(function (rs) {
			self.detailList(rs.map(app.ko));
			$('#modalDetail').modal('show');

			if (self.detailList().length == 0) self.addDetail();
		});
	};

	self.addDetail = function () {
		self.detailList.push(app.ko({
			Equipment_ID: eid,
			MaintenanceDate: '',
			NextMaintenance: ''
		}));
	};

	self.saveDetail = function () {
		var missing = false;
		var list = self.detailList();

		list.forEach(r => {
			if (r.MaintenanceDate() == '') {
				self.showWarning(r.MaintenanceDate);
				missing = true;
			}
			if (r.NextMaintenance() == '') {
				self.showWarning(r.NextMaintenance);
				missing = true;
			}
		});
		if (missing) return;

		$('#modalDetail').modal('hide');

		var submit = {
			id: eid,
			list: list.map(app.unko)
		};
		app.ajax('/Lab/saveMaintenance', submit);
	};

	self.deleteDetail = function (model) {
		self.detailList.remove(model);
	};

	self.exportExcel = function () {
		if (self.pv() == null) {
			app.ajax('/Lab/getEquipment').done(function (rs) {
				rs.sortasc('Name_Prov_E', 'Name_OD_E', 'Name_Facility_E');
				prepare(rs);
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
					'Item': r.ItemName,
					'Manufacturer': r.Manufacturer,
					'Model': r.Model,
					'Serial': r.Serial,
					'Received Date': moment(r.ReceivedDate).toDate(),
					'Quality': r.Quality,
					'Condition': r.Condition,
					'NeedMaintenance': r.NeedMaintenance
				};
			});
			self.writeExcel(data, 'Equipment');
		}
	};
}