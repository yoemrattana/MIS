function viewModel() {
	var self = this;

	self.userList = ko.observableArray();
	self.roleList = ko.observableArray();
	self.permissionList = ko.observableArray();
	self.rgList = ko.observableArray();

	self.menu = ko.observable('User');
	self.userEditModel = ko.observable();
	self.roleNewModel = ko.observable();
	self.permissGroupEditModel = ko.observable();
	self.permissEditModel = ko.observable();
	self.permissGroup = ko.observable();
	self.roleEditModel = ko.observable();
	self.role = ko.observable();
	self.permissGroupList = ko.observableArray();
	self.PPChildren = ko.observableArray();

	var permissData = [];
	var rolePermissionData = [];
	var pvData = [];
	var odData = [];
	var hcData = [];
	var unitData = [];

	app.getPlace(['pv', 'od', 'hc', 'rg', 'unit'], function (p) {
		pvData = p.pv;
		odData = p.od;
		hcData = p.hc;
		unitData = p.unit;

		self.rgList(p.rg);

		app.ajax('/User/getAllData').done(function (rs) {
			permissData = rs.permiss;
			rolePermissionData = rs.rolePermiss;

			permissData.forEach(r => r.allow = ko.observable(false));

			self.userList(rs.user);
			self.roleList(rs.role);
			self.permissGroupList(rs.permissGroup);
		});
	});

	self.menuClick = function (model, event) {
		self.menu($(event.currentTarget).text());
		if (self.menu() == 'Role Permission') self.roleChange();
		window.scrollTo(0, 0);
	};

	self.menuSelected = function (element) {
		return $(element).text() == self.menu();
	};

	self.roleChange = function () {
		var arrP = rolePermissionData.filter(r => r.Role == self.role());
		var nestArr = [];
		self.permissGroupList().forEach(function (val, key) {
			var arr = permissData.filter(r => r.GroupID == val.GroupID);
			arr.forEach(c => {
				c.allow(arrP.some(r => r.PermissionID == c.PermissionID));
			});
			nestArr.push({ name: val.GroupName, category: val.Category, children: ko.observableArray(arr) });
		});
		self.PPChildren(nestArr);
	};

	self.showCreateUser = function () {
		var model = {
			ID: '',
			Us: '',
			Ps: '',
			Role: '',
			Code_Prov: '',
			Code_OD: '',
			Code_HC: '',
			Code_RG: '',
			Code_Unit: '',
			Code_Prov_Notification: '',
			Code_OD_Notification: '',
			Specie_Notification: '',
		};

		self.showEditUser(model);
	};

	self.showEditUser = function (model) {
		model = app.ko(model);

		model.pvList = ko.observableArray(pvData);
		model.odList = ko.observableArray();
		model.hcList = ko.observableArray();
		model.multiPvList = ko.observableArray();
		model.notificationPvList = ko.observableArray();
		model.specieList = ko.observableArray();
		model.unitList = ko.observableArray();

		var arr = self.getRolePreSetup(model.Role()) == 0 ? model.Code_Prov().split(',') : [];
		var arr2 = model.Code_Prov_Notification().split(',');

		pvData.forEach(p => {
			var tick = model.ID() == '' ? false : model.Code_Prov() == '' ? true : arr.some(r => r == p.code);
			model.multiPvList.push({
				code: p.code,
				name: p.name,
				check: ko.observable(tick)
			});

			var tick2 = model.ID() == '' ? false : arr2.some(r => r == p.code);
			model.notificationPvList.push({
				code: p.code,
				name: p.name,
				check: ko.observable(tick2)
			});
		});

		var specieArr = model.Specie_Notification().split(',');
		var diagnosisArr = [
			{ code: 'F', name: 'Pf' },
			{ code: 'V', name: 'Pv' },
			{ code: 'M', name: 'Mix' },
			{ code: 'A', name: 'Pm' },
			{ code: 'O', name: 'Po' },
			{ code: 'K', name: 'Pk' }
		];
		diagnosisArr.forEach(r => {
			let tick = model.ID() == '' ? false : model.Specie_Notification() == '' ? true : specieArr.some(x => x == r.code);
			model.specieList.push({
				code: r.code,
				name: r.name,
				check: ko.observable(tick)
			});
		});

		model.Code_Prov.subscribe(function (v) {
			model.odList(odData.filter(r => r.pvcode == v));
		});

		model.Code_OD.subscribe(function (v) {
			model.hcList(hcData.filter(r => r.odcode == v));
		});

		model.Code_RG.subscribe(function (v) {
			model.unitList(unitData.filter(r => r.rgcode == v));
		});

		if (model.Us != '') {
			model.Role.notifySubscribers(model.Role());
			model.Code_Prov.notifySubscribers(model.Code_Prov());
			model.Code_OD.notifySubscribers(model.Code_OD());
			model.Code_RG.notifySubscribers(model.Code_RG());
		}

		self.userEditModel(model);
		$('#modalEditUser').modal('show');
	};

	self.editUser = function (model) {
		model.Us(model.Us().trim());

		var missing = false;
		if (model.Us() == '') {
			app.showWarning(model.Us.element, 'Please input this box.');
			missing = true;
		} else if (model.ID() == '' && self.userList().some(r => r.Us == model.Us())) {
			app.showWarning(model.Us.element, 'Username is already existed.');
			missing = true;
		}
		if (model.Ps() == '') {
			app.showWarning(model.Ps.element, 'Please input this box.');
			missing = true;
		}
		if (self.getRolePreSetup(model.Role()) == 0 && model.multiPvList().filter(r => r.check()).length == 0) {
			$('#selectProvince').show();
			missing = true;
		}
		if (missing) return;

		$('#modalEditUser').modal('hide');

		var multiPv = model.multiPvList().filter(r => r.check()).map(r => r.code).join(',');
		var notificationProv = model.notificationPvList().filter(r => r.check()).map(r => r.code).join(',');
		var specie = model.specieList().filter(r => r.check()).map(r => r.code).join(',');

		var submit = {
			ID: model.ID(),
			Us: model.Us(),
			Ps: model.Ps(),
			Role: model.Role(),
			Code_OD: model.Role().in('OD', 'STOCK OD', 'RH LAB') ? model.Code_OD() : '',
			Code_HC: model.Role() == 'RH LAB' ? model.Code_HC() : '',
			Code_RG: model.Role() == 'ML' ? model.Code_RG() || '' : '',
			Code_Unit: model.Role() == 'ML' ? model.Code_Unit() || '' : '',
			Code_Prov: model.Role().in('OD', 'PHD', 'STOCK OD', 'RH LAB') ? model.Code_Prov()
				: self.getRolePreSetup(model.Role()) == 0 && !model.multiPvList().every(r => r.check()) ? multiPv
				: '',
			Code_Prov_Notification: model.Role().in('AU', 'DIRECTOR', 'VICE DIRECTOR', 'CSO', 'M&E CNM', 'VMW', 'HEAD VMW') ? notificationProv
				: model.Role().in('OD', 'STOCK OD', 'PHD') ? model.Code_Prov()
				: '',
			Code_OD_Notification: model.Role().in('OD', 'STOCK OD') ? model.Code_OD() : '',
			Specie_Notification: specie,
		};
		submit = { submit: submit };

		app.ajax('/User/saveUser', submit).done(function (rs) {
			if (model.ID() == '') {
				self.userList.unshift(rs);
			} else {
				var old = self.userList().find(r => r.Us == rs.Us);
				self.userList.replace(old, rs);
			}
		});
	};

	self.deleteUser = function (model) {
		app.showDelete(function () {
			var submit = { us: model.Us };
			app.ajax('/User/deleteUser', submit).done(function () {
				self.userList.remove(model);
			});
		});
	};

	self.saveRole = function () {
		var submit = {
			Role: self.role(),
			PermissionID: permissData.filter(r => r.allow()).map(r => r.PermissionID)
		};

		app.ajax('/User/saveRole', submit).done(function () {
			rolePermissionData = rolePermissionData.filter(r => r.Role != self.role());
			submit.PermissionID.forEach(r => {
				rolePermissionData.push({ Role: self.role(), PermissionID: r });
			});
		});
	};

	self.getRolePreSetup = function (role) {
		var found = self.roleList().find(r => r.Role == role);
		return found == null ? 0 : found.PreSetup;
	};

	self.getProvName = function (code) {
		var found = pvData.find(r => r.code == code);
		return found == null ? code : found.name;
	};

	self.getODName = function (code) {
		var found = odData.find(r => r.code == code);
		return found == null ? code : found.name;
	};

	self.getHCName = function (code) {
		var found = hcData.find(r => r.code == code);
		return found == null ? code : found.name;
	};

	self.getRGName = function (code, role) {
		if (code == '' && role == 'ML') return 'All';
		var found = self.rgList().find(r => r.code == code);
		return found == null ? code : found.name;
	};

	self.getUnitName = function (code) {
		if (code == '') return 'All';
		var found = unitData.find(r => r.code == code);
		return found == null ? code : found.name;
	};

	self.showCreateRole = function () {
		var model = {
			Role: ko.observableArray(),
			Description: ko.observable()
		};
		self.roleNewModel(model);
		$('#modalNewRole').modal('show');
	};

	self.newRole = function (model) {
		if (model.Role() == '') {
			app.showWarning(model.Role.element, 'Please input Role.');
			return;
		}

		$('#modalNewRole').modal('hide');

		var newRole = {
			Role: model.Role().toUpperCase(),
			Description: isnull(model.Description(), ''),
			PreSetup: 0
		};
		var submit = {
			table: 'MIS_Role',
			value: newRole,
		};

		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/insert', submit).done(function () {
			self.roleList.push(newRole);
			self.roleList.sort((a, b) => mysort(a.Role, b.Role));
		});
	};

	self.showEditRole = function (model) {
		model = app.ko(model);
		model.Role.old = model.Role();

		self.roleEditModel(model);
		$('#modalEditRole').modal('show');
	};

	self.editRole = function (model) {
		if (model.Role() == '') {
			app.showWarning(model.Role.element, 'Please input Role.');
			return;
		}

		$('#modalEditRole').modal('hide');

		var oldRole = model.Role.old;
		model = app.unko(model);
		model.Role = model.Role.toUpperCase();

		var submit = {
			table: 'MIS_Role',
			value: model,
			where: { Role: oldRole }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			var old = self.roleList().find(r => r.Role == oldRole);
			self.roleList.replace(old, model);
			self.roleList.sort((a, b) => mysort(a.Role, b.Role));
		});
	};

	self.deleteRole = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'MIS_Role',
				where: { Role: model.Role }
			};
			submit = { submit: JSON.stringify(submit) };
			app.ajax('/Direct/delete', submit).done(function () {
				self.roleList.remove(model);
			});
		});
	};

	//PermissGroup
	self.showCreatePermissGroup = function () {
		var model = {
			GroupID: 0,
			GroupName: '',
			Category: ''
		};
		self.showEditPermissGroup(model);
	};

	self.showEditPermissGroup = function (model) {
		self.permissGroupEditModel(app.ko(model));
		$('#modalEditPermissGroup').modal('show');
	};

	self.editPermissGroup = function (model) {
		if (model.GroupName() == '') {
			app.showWarning(model.GroupName.element, 'Please input Group Name.');
			return;
		}
		$('#modalEditPermissGroup').modal('hide');
		model = app.unko(model);

		if (model.GroupID == 0) {
			delete model.GroupID;

			var submit = {
				table: 'MIS_PermissionGroup',
				value: model,
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/insert', submit).done(function (id) {
				model.GroupID = id;
				self.permissGroupList.push(model);
			});
		} else {
			var submit = {
				table: 'MIS_PermissionGroup',
				value: { GroupName: model.GroupName, Category: model.Category },
				where: { GroupID: model.GroupID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/update', submit).done(function () {
				var old = self.permissGroupList().find(r => r.GroupID == model.GroupID);
				self.permissGroupList.replace(old, model);
			});
		}
	};

	self.deletePermissGroup = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'MIS_PermissionGroup',
				where: { GroupID: model.GroupID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.permissGroupList.remove(model);
			});
		});
	};

	//Permission
	self.refreshPermissList = function () {
		self.permissionList([]);
		self.permissionList(permissData.filter(r => r.GroupID == self.permissGroup()));
	};

	self.showCreatePermiss = function () {
		var model = {
			PermissionID: 0,
			GroupID: self.permissGroup(),
			Permission: '',
		};
		self.showEditPermiss(model);
	};

	self.showEditPermiss = function (model) {
		self.permissEditModel(app.ko(model));
		$('#modalEditPermission').modal('show');
	};

	self.editPermiss = function (model) {
		if (model.Permission() == '') {
			app.showWarning(model.Permission.element, 'Please input Permission.');
			return;
		}
		$('#modalEditPermission').modal('hide');
		model = app.unko(model);

		if (model.PermissionID == 0) {
			delete model.PermissionID;

			var submit = {
				table: 'MIS_Permission',
				value: model
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/insert', submit).done(function (id) {
				model.PermissionID = id;
				model.allow = ko.observable(false);
				permissData.push(model);
				self.refreshPermissList();
			});
		} else {
			var submit = {
				table: 'MIS_Permission',
				value: { Permission: model.Permission },
				where: { PermissionID: model.PermissionID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/update', submit).done(function () {
				permissData.find(r => r.PermissionID == model.PermissionID).Permission = model.Permission;
				self.refreshPermissList();
			});
		}
	};

	self.deletePermiss = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'MIS_Permission',
				where: { PermissionID: model.PermissionID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				permissData = permissData.filter(r => r.PermissionID != model.PermissionID);
				self.refreshPermissList();
			});
		});
	};

	self.selectAll = function (model) {
		var arr = model.children();
		var allowAll = !arr.every(r => r.allow());
		arr.forEach(c => c.allow(allowAll));
	};

	function mysort(a, b) {
		var aa = a.toUpperCase(), bb = b.toUpperCase();
		return aa > bb ? 1 : aa < bb ? -1 : 0;
	}
}