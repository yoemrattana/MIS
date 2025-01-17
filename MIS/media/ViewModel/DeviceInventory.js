function viewModel() {
	var self = this;

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.type = ko.observable();
	self.listModel = ko.observableArray();

	var place = null;

	self.odList = () => self.pv() ? place.od.filter(r => r.pvcode == self.pv()) : [];
	self.hcList = () => self.od() ? place.hc.filter(r => r.odcode == self.od()) : [];

	app.getPlace(['pv', 'od', 'hc', 'vl'], p => {
		place = p;
		place.od = place.od.filter(r => r.target != null);
		place.vl = place.vl.filter(r => r.hccode != null);
		self.pvList(place.pv);

		app.ajax('/deviceInventory/getData').done(rs => {
			self.listModel(rs.map(prepare));
		});
	});

	self.getListModel = function () {
		var list = self.listModel();

		if (self.hc() != null) list = list.filter(r => r.Code_Facility_T() == self.hc());
		else if (self.od() != null) list = list.filter(r => r.Code_OD_T() == self.od());
		else if (self.pv() != null) list = list.filter(r => r.Code_Prov_T() == self.pv());

		if (self.type() == 'OD') list = list.filter(r => r.Code_Facility_T() == null);
		else if (self.type() == 'HC') list = list.filter(r => r.Code_Facility_T() != null && r.Code_Vill_T() == null);
		else if (self.type() == 'VMW') list = list.filter(r => r.Code_Vill_T() != null);

		return list;
	};
	app.rowLimit(100, self, 'getListModel');

	function prepare(model) {
		model = app.ko(model);
		model.odList = () => place.od.filter(r => r.pvcode == model.Code_Prov_T());
		model.hcList = () => place.hc.filter(r => r.odcode == model.Code_OD_T());
		model.vlList = () => place.vl.filter(r => r.hccode == model.Code_Facility_T());
		return model;
	}

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Code_Prov_T: null,
			Code_OD_T: null,
			Code_Facility_T: null,
			Code_Vill_T: null,
			Imei: '',
			Serial: '',
			Model: '',
			Phone: '',
			Note: ''
		};
		self.listModel.push(prepare(model));
	};

	self.save = function (model) {
		var missing = false;
		if (model.Code_Prov_T() == null) {
			app.showWarning(model.Code_Prov_T.element);
			missing = true;
		}
		if (model.Code_Prov_T() == null) {
			app.showWarning(model.Code_OD_T.element);
			missing = true;
		}
		if (missing) return;

		var submit = app.unko(model);
		delete submit.Code_Prov_T;

		submit.Code_OD_T ??= null;
		submit.Code_Facility_T ??= null;
		submit.Code_Vill_T ??= null;

		if (submit.Code_OD_T == null && submit.Code_Facility_T == null && submit.Code_Vill_T == null) return;

		if (submit.Code_Vill_T != null) {
			submit.Code_OD_T = null;
			submit.Code_Facility_T = null;
		} else if (submit.Code_Facility_T != null) {
			submit.Code_OD_T = null;
		}

		app.ajax2('/deviceInventory/save', submit).done(id => {
			model.Rec_ID(id);
		});
	};

	self.showDelete = function (model) {
		app.showDelete(async () => {
			if (model.Rec_ID() > 0) {
				var submit = {
					table: 'tblDeviceInventory',
					where: { Rec_ID: model.Rec_ID() }
				};
				submit = { submit: JSON.stringify(submit) };
				await app.ajax('/direct/delete', submit);
			}
			self.listModel.remove(model);
		});
	};

	self.exportExcel = function () {
		var list = app.unko(self.listModel());
		var od = list.filter(r => r.Code_Facility_T == null);
		var hc = list.filter(r => r.Code_Facility_T != null && r.Code_Vill_T == null);
		var vmw = list.filter(r => r.Code_Vill_T != null);

		function convert(arr) {
			return arr.map(a => {
				var obj = {};
				obj.Province = place.pv.find(r => r.code == a.Code_Prov_T).name;
				obj.OD = place.od.find(r => r.code == a.Code_OD_T).name;

				if (a.Code_Facility_T != null) obj.HC = place.hc.find(r => r.code == a.Code_Facility_T)?.name ?? a.Code_Facility_T;
				if (a.Code_Vill_T != null) obj.VMW = place.vl.find(r => r.code == a.Code_Vill_T)?.name ?? a.Code_Vill_T;

				obj.Imei = a.Imei;
				obj.Serial = a.Serial;
				obj.Model = a.Model;
				obj.Phone = a.Phone;
				obj.Note = a.Note;
				return obj;
			});
		}

		od = convert(od);
		hc = convert(hc);
		vmw = convert(vmw);

		var wb = XLSX.utils.book_new();
		XLSX.utils.book_append_sheet(wb, XLSX.utils.json_to_sheet(od), 'OD');
		XLSX.utils.book_append_sheet(wb, XLSX.utils.json_to_sheet(hc), 'HC');
		XLSX.utils.book_append_sheet(wb, XLSX.utils.json_to_sheet(vmw), 'VMW');
		XLSX.writeFileXLSX(wb, 'Device Inventory.xlsx', { compression: true });
	};
}