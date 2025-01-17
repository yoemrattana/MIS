function viewModel() {
	var self = this;

	var place = null;
	var mainData = [];
	var rowLimit = app.newRowLimit(100);

	self.menu = ko.observable('');
	self.editModel = ko.observable();

	self.pn = ko.observable();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.unit = ko.observable();
	self.pnList = ko.observableArray();
	self.pvList = ko.observableArray();
	self.odList = ko.pureComputed(() => place.od.filter(r => r.pvcode == self.pv()));
	self.hcList = ko.pureComputed(() => place.hc.filter(r => r.odcode == self.od()));
	self.unitList = ko.observableArray();

	self.listCNM = ko.observableArray();
	self.dataPartner = ko.observableArray();
	self.dataPHD = ko.observableArray();
	self.dataOD = ko.observableArray();
	self.dataHC = ko.observableArray();
	self.dataVMW = ko.observableArray();

	self.listPartner = ko.pureComputed(function () {
		return self.pn() != null ? self.dataPartner().filter(r => r.Partner == self.pn()) : self.dataPartner();
	});

	self.listPHD = ko.pureComputed(function () {
		return self.pv() != null ? self.dataPHD().filter(r => r.pv == self.pv()) : self.dataPHD();
	});

	self.listOD = ko.pureComputed(function () {
		return self.pv() != null ? self.dataOD().filter(r => r.pv == self.pv()) : self.dataOD();
	});

	self.listHC = ko.pureComputed(function () {
		var list = self.od() != null ? self.dataHC().filter(r => r.od == self.od())
			: self.pv() != null ? self.dataHC().filter(r => r.pv == self.pv())
			: self.dataHC();

		return list.slice(0, rowLimit());
	});

	self.getUnitName = function (id) {
		var rs = self.unitList().find(x => x.Rec_ID == id);
		return rs == undefined ? '' : rs.Name;
	}

	self.listVMW = ko.pureComputed(function () {
		var list = self.hc() != null ? self.dataVMW().filter(r => r.hc == self.hc())
			: self.od() != null ? self.dataVMW().filter(r => r.od == self.od())
			: self.pv() != null ? self.dataVMW().filter(r => r.pv == self.pv())
			: self.dataVMW();

		return list.slice(0, rowLimit());
	});

	self.pv.subscribe(rowLimit.reset);
	self.od.subscribe(rowLimit.reset);
	self.hc.subscribe(rowLimit.reset);

	self.menuClick = function (model, event) {
		self.menu($(event.currentTarget).text());
		rowLimit.reset();

		if (self.menu() == 'CNM' && self.listCNM().length == 0) {
			self.listCNM(mainData.filter(r => r.Type == 'CNM').sortasc(r => r.Unit, r => r.Name.split('.').last()));
		}
		else if (self.menu() == 'Partner' && self.listPartner().length == 0) {
			self.dataPartner(mainData.filter(r => r.Type == 'Partner').sortasc(r => r.Partner, r => r.Name));
			self.pnList(self.dataPartner().map(r => r.Partner).distinct());
		}
		else if (self.menu() == 'PHD' && self.dataPHD().length == 0) {
			var list = mainData.filter(r => r.Type == 'PHD');
			list.forEach(pv => pv.pv = pv.PlaceCode);
			list.sortasc(r => self.getPVName(r.pv));
			self.dataPHD(list);
		}
		else if (self.menu() == 'OD' && self.dataOD().length == 0) {
			var list = mainData.filter(r => r.Type == 'OD');
			list.forEach(od => {
				od.od = od.PlaceCode;
				od.pv = place.od.find(r => r.code == od.od).pvcode;
			});
			list.sortasc(r => self.getPVName(r.pv), r => self.getODName(r.od));
			self.dataOD(list);
		}
		else if (self.menu() == 'HC' && self.dataHC().length == 0) {
			var list = mainData.filter(r => r.Type == 'HC');
			list.forEach(hc => {
				hc.hc = hc.PlaceCode;
				hc.od = place.hc.find(r => r.code == hc.hc).odcode;
				hc.pv = place.od.find(r => r.code == hc.od).pvcode;
			});
			list.sortasc(r => self.getPVName(r.pv), r => self.getODName(r.od), r => self.getHCName(r.hc));
			self.dataHC(list);
		}
		else if (self.menu() == 'VMW' && self.dataVMW().length == 0) {
			app.showLoader();
			setTimeout(function () {
				app.hideLoader();

				var list = mainData.filter(r => r.Type == 'VMW');
				list.forEach(vmw => {
					vmw.vl = vmw.PlaceCode;
					vmw.hc = place.vl.find(r => r.code == vmw.vl).hccode;
					vmw.od = place.hc.find(r => r.code == vmw.hc).odcode;
					vmw.pv = place.od.find(r => r.code == vmw.od).pvcode;
				});
				list.sortasc(r => self.getPVName(r.pv), r => self.getODName(r.od), r => self.getHCName(r.hc), r => self.getVLName(r.vl));
				self.dataVMW(list);
			});
		}
	};

	self.menuSelected = function (element) {
		return $(element).text() == self.menu();
	};

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
		place = p;
		self.pvList(place.pv);

		app.ajax('/Contact/getData').done(function (rs) {
			var units = rs.unit;
			units.forEach(x=> {
				x.unit = x.Rec_ID
			})

			self.unitList(units);
			mainData = rs.contact;
		});
	});

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Type: self.menu(),
			Name: '',
			Phone: '',
			Email: '',
			Partner: '',
			Position: '',
			Unit: ''
		};
		self.showEdit(model);
	};

	self.showEdit = function (model) {
		model = app.ko(model);

		if (model.pv == null) model.pv = ko.observable('');
		if (model.od == null) model.od = ko.observable('');
		if (model.hc == null) model.hc = ko.observable('');
		if (model.vl == null) model.vl = ko.observable('');

		model.pvList = ko.observableArray(place.pv);
		model.odList = ko.pureComputed(() => place.od.filter(r => r.pvcode == model.pv()));
		model.hcList = ko.pureComputed(() => place.hc.filter(r => r.odcode == model.od()));
		model.vlList = ko.pureComputed(() => place.vl.filter(r => r.hccode == model.hc()));

		model.unitList = ko.observableArray(self.unitList());

		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.save = function () {
		var model = self.editModel();
		model.Partner(model.Partner().trim());
		model.Name(model.Name().trim());
		model.Phone(model.Phone().trim());
		model.Email(model.Email().trim());
		model.Position(model.Position().trim());

		var missing = false;
		if (model.Partner() == '' && self.menu() == 'Partner') {
			app.showWarning(model.Partner.element, 'Please input this box');
			missing = true;
		}
		if (model.pv() == null && self.menu().in('PHD', 'OD', 'HC', 'VMW')) {
			app.showWarning(model.pv.element, 'Please input this box');
			missing = true;
		}
		if (model.od() == null && self.menu().in('OD', 'HC', 'VMW')) {
			app.showWarning(model.od.element, 'Please input this box');
			missing = true;
		}
		if (model.hc() == null && self.menu().in('HC', 'VMW')) {
			app.showWarning(model.hc.element, 'Please input this box');
			missing = true;
		}
		if (model.vl() == null && self.menu() == 'VMW') {
			app.showWarning(model.vl.element, 'Please input this box');
			missing = true;
		}
		if (model.Name() == '') {
			app.showWarning(model.Name.element, 'Please input this box');
			missing = true;
		}
		if (model.Position() == '' && self.menu().in('CNM', 'Partner', 'PHD', 'OD')) {
			app.showWarning(model.Position.element, 'Please input this box');
			missing = true;
		}
		if (model.Unit() == '' && self.menu().in('CNM')) {
			app.showWarning(model.Unit.element, 'Please input this box');
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		var placeCode = self.menu() == 'PHD' ? model.pv()
			: self.menu() == 'OD' ? model.od()
			: self.menu() == 'HC' ? model.hc()
			: self.menu() == 'VMW' ? model.vl()
			: '';
		
		var submit = {
			table: 'tblContact',
			value: {
				Type: model.Type(),
				Name: model.Name(),
				Phone: model.Phone(),
				Email: model.Email(),
				Position: model.Position(),
				Unit: model.Unit(),
				PlaceCode: placeCode,
				Partner: model.Partner(),
				ModiUser: app.user.username,
				ModiTime: 'getdate()'
			},
			where: { Rec_ID: model.Rec_ID() }
		};
		submit = { submit: JSON.stringify(submit) };

		if (model.Rec_ID() == 0) {
			app.ajax('/Direct/insert', submit).done(function (rs) {
				if (self.menu() == 'CNM') self.listCNM.unshift(rs);
				else if (self.menu() == 'Partner') {
					self.dataPartner.unshift(rs);
					self.pnList(self.dataPartner().map(r => r.Partner).distinct());
				}
				else if (self.menu() == 'PHD') {
					rs.pv = model.pv();
					self.dataPHD.unshift(rs);
				}
				else if (self.menu() == 'OD') {
					rs.pv = model.pv();
					rs.od = model.od();
					self.dataOD.unshift(rs);
				}
				else if (self.menu() == 'HC') {
					rs.pv = model.pv();
					rs.od = model.od();
					rs.hc = model.hc();
					self.dataHC.unshift(rs);
				}
				else if (self.menu() == 'VMW') {
					rs.pv = model.pv();
					rs.od = model.od();
					rs.hc = model.hc();
					rs.vl = model.vl();
					self.dataVMW.unshift(rs);
				}
			});
		} else {
			app.ajax('/Direct/update', submit).done(function (rs) {
				if (self.menu() == 'CNM') {
					var old = self.listCNM().find(r => r.Rec_ID == rs.Rec_ID);
					self.listCNM.replace(old, rs);
				}
				else if (self.menu() == 'Partner') {
					var old = self.dataPartner().find(r => r.Rec_ID == rs.Rec_ID);
					self.dataPartner.replace(old, rs);
					self.pnList(self.dataPartner().map(r => r.Partner).distinct());
				}
				else if (self.menu() == 'PHD') {
					var old = self.dataPHD().find(r => r.Rec_ID == rs.Rec_ID);
					rs.pv = model.pv();
					self.dataPHD.replace(old, rs);
				}
				else if (self.menu() == 'OD') {
					var old = self.dataOD().find(r => r.Rec_ID == rs.Rec_ID);
					rs.pv = model.pv();
					rs.od = model.od();
					self.dataOD.replace(old, rs);
				}
				else if (self.menu() == 'HC') {
					var old = self.dataHC().find(r => r.Rec_ID == rs.Rec_ID);
					rs.pv = model.pv();
					rs.od = model.od();
					rs.hc = model.hc();
					self.dataHC.replace(old, rs);
				}
				else if (self.menu() == 'VMW') {
					var old = self.dataVMW().find(r => r.Rec_ID == rs.Rec_ID);
					rs.pv = model.pv();
					rs.od = model.od();
					rs.hc = model.hc();
					rs.vl = model.vl();
					self.dataVMW.replace(old, rs);
				}
			});
		}
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblContact',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };
			app.ajax('/Direct/delete', submit).done(function () {
				mainData.remove(model);

				if (self.menu() == 'CNM') self.listCNM.remove(model);
				else if (self.menu() == 'Partner') {
					self.dataPartner.remove(model);
					self.pnList(self.dataPartner().map(r => r.Partner).distinct());
				}
				else if (self.menu() == 'PHD') self.dataPHD.remove(model);
				else if (self.menu() == 'OD') self.dataOD.remove(model);
				else if (self.menu() == 'HC') self.dataHC.remove(model);
				else if (self.menu() == 'VMW') self.dataVMW.remove(model);
			});
		});
	};

	self.getPVName = function (code) {
		return place.pv.find(r => r.code == code).nameK;
	};

	self.getODName = function (code) {
		return place.od.find(r => r.code == code).nameK;
	};

	self.getHCName = function (code) {
		return place.hc.find(r => r.code == code).nameK;
	};

	self.getVLName = function (code) {
		return place.vl.find(r => r.code == code).nameK;
	};

	$(window).scroll(function () {
		if (innerHeight + scrollY + 1000 < document.body.scrollHeight) return;
		if (rowLimit() > self['list' + self.menu()]().length) return;

		rowLimit.increase();
	});
}