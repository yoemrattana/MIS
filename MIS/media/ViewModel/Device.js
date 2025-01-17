function viewModel() {
	var self = this;

	self.hfRequestList = ko.observableArray();
	self.vmwRequestList = ko.observableArray();
	self.hfDeviceList = ko.observableArray();
	self.vmwDeviceList = ko.observableArray();
	self.cmiDeviceList = ko.observableArray();
	self.hfLogList = ko.observableArray();
	self.vmwLogList = ko.observableArray();
	self.odLogList = ko.observableArray();
	self.editModel = ko.observable();
	self.yearList = [];
	self.monthList = [];

	self.menu = ko.observable('');
	self.submenu = ko.observable('cmi-list');
	self.appModel = ko.observable();
	self.provList = ko.observableArray();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.prov = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.type = ko.observable();
	self.far = ko.observable(false);
	self.farKm = ko.observable(1);
	self.from = ko.observable(null);
	self.to = ko.observable(null);
	self.newPhone = ko.observable(false);
	self.newODModel = ko.observable();
	self.android = ko.observable(0);
	self.ios = ko.observable(0);
	self.cmiTotal = ko.observable();
	self.deviceModel = ko.observable();

	self.year = ko.observable(moment().year());
	self.month = ko.observable(moment().month());

	var place = null;
	var hfDevices = [];
	var vmwDevices = [];
	var hfLog = [];
	var vmwLog = [];
	var odLog = [];
	var map = null;
	var cimMap = null;
	var hfMarkers = [];
	var vmwMarkers = [];
	var hfFarMarkers = [];
	var vmwFarMarkers = [];
	var farLines = [];

	self.menuClick = function (model, event) {
		self.menu($(event.currentTarget).text());
		if (self.menu() == 'HF Request') hfGetRequest();
		else if (self.menu() == 'VMW Request') vmwGetRequest();
		else if (self.menu() == 'HF List') hfGetDeviceList();
		else if (self.menu() == 'VMW List') vmwGetDeviceList();
		else if (self.menu() == 'CMI') getCMIDevices();
		else if (self.menu() == 'Map') displayMap();
		else if (self.menu() == 'App Upload') appUpload();
		else if (self.menu() == 'Inventory') getDeviceLog();
	};

	self.submenu.subscribe(function (submenu) {
	    if (submenu == 'cmi-map') getCMIMap();
	})

	self.menuSelected = function (element) {
		return $(element).text() == self.menu();
	};

	for (var i = 2018; i <= moment().year() ; i++) {
	    self.yearList.push(i);
	}

	for (var i = 1; i <= 12; i++) {
	    self.monthList.push(('0' + i).substr(-2));
	}

	app.getPlace(['pv', 'od', 'hc'], function (p) {
		place = p;

		if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

		self.provList(place.pv);

		app.readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
			eval(script);
			self.prov('01');
		});
	});

	self.checkPermission = function (e) {
		var value = typeof e == 'object' ? e.innerHTML : e;
		return app.user.role == 'AU' || app.user.permiss['Device Management'].contain(value);
	}

	function hfGetRequest() {
		self.hfRequestList.removeAll();
		app.ajax('/Device/hfGetRequest').done(function (rs) {
			if (app.user.od != '') rs = rs.filter(r => r.Code_OD_T == app.user.od);
			else if (app.user.prov != '') rs = rs.filter(r => app.user.prov.contain(r.Code_Prov_T));

			self.hfRequestList(rs);
		});
	}

	function vmwGetRequest() {
		self.vmwRequestList.removeAll();
		app.ajax('/Device/vmwGetRequest').done(function (rs) {
			if (app.user.od != '') rs = rs.filter(r => r.Code_OD_T == app.user.od);
			else if (app.user.prov != '') rs = rs.filter(r => app.user.prov.contain(r.Code_Prov_T));

			self.vmwRequestList(rs);
		});
	}

	function getCMIDevices() {
		if (self.menu() != 'CMI') return;

	    let submit = {
	        year: self.year(),
            month: self.month()
	    }
	    app.ajax('/Device/getCMIDevices', submit).done(function (rs) {
	        self.cmiTotal(rs['total']);
		    self.cmiDeviceList(rs['users']);
		    let ios = self.cmiDeviceList().filter(r =>{
                return r.OS == 'IOS'
		    })

		    self.ios(ios.length);

		    let android = self.cmiDeviceList().filter(r => {
		        return r.OS == 'Android'
		    });

		    self.android(android.length);
		});
	}

	function getCMIMap() {
		cmiMap = app.createGoogleMap('cmiMap', {
			zoom: 7.8
		});

	    app.ajax('/Device/getCMIMap').done(function (rs) {
	        rs.forEach(r => {
	            var marker = new google.maps.Marker({
	                position: { lat: parseFloat(r.Lat), lng: parseFloat(r.Long) },
	                icon: r.UserName == 'Guest' ? '/media/images/marker-blue.png' : '/media/images/marker-red.png',
	                zIndex: 900
	            });

	            marker.setMap(cmiMap);

	            var txt = r.UserName == 'Guest' ? '<b>Guest</b>' : '<b>Logged in User</b>'
	            txt += '<br><b>User:</b> ' + r.UserName;
	            txt += '<br><b>Role:</b> ' + r.Role;
	            
	            var infowindow = new google.maps.InfoWindow({ content: txt });
	            marker.addListener('mouseover', () => infowindow.open(cmiMap, marker));
	            marker.addListener('mouseout', () => infowindow.close());
	        });

	    });
	}

	self.month.subscribe(function () {
	    getCMIDevices();
	});

	self.year.subscribe(function () {
	    getCMIDevices();
	});

	function hfGetDeviceList() {
		self.hfDeviceList.removeAll();
		app.ajax('/Device/hfDeviceList').done(function (rs) {
			if (app.user.od != '') rs = rs.filter(r => r.Code_OD_T == app.user.od);
			else if (app.user.prov != '') rs = rs.filter(r => app.user.prov.contain(r.Code_Prov_T));

			rs.forEach(r => {
				r.Phone = ko.observable(r.Phone);
				r.NewPhone = ko.observable(r.NewPhone);
				r.Model = ko.observable(r.Model);
				r.Active = ko.observable(r.Active);
				r.ExpireEntry = ko.observable(r.ExpireEntry);
				r.ExpireStock = ko.observable(r.ExpireStock);
				r.AutoPhone = ko.observable(r.AutoPhone);

				try {
					var u = JSON.parse(r.MalariaAppUsage);
					var score = parseInt(u.download || 0) + parseInt(u.upload || 0)
					r.MalariaAppUsage = calculateSize(Math.abs(score));

					var score = 0;
					JSON.parse(r.OtherAppUsage).forEach(u => {
						score += parseInt(u.download) + parseInt(u.upload);
					});
					r.OtherAppUsage = calculateSize(Math.abs(score));
				} catch (e) {

				}
			});
			hfDevices = rs;

			self.od.notifySubscribers(self.od());
		});
	}

	function vmwGetDeviceList() {
		self.vmwDeviceList.removeAll();
		app.ajax('/Device/vmwDeviceList').done(function (rs) {
			if (app.user.od != '') rs = rs.filter(r => r.Code_OD_T == app.user.od);
			else if (app.user.prov != '') rs = rs.filter(r => app.user.prov.contain(r.Code_Prov_T));

			rs.forEach(r => {
				r.Phone = ko.observable(r.Phone);
				r.NewPhone = ko.observable(r.NewPhone);
				r.Model = ko.observable(r.Model);
				r.Active = ko.observable(r.Active);
				r.ExpireEntry = ko.observable(r.ExpireEntry);
				r.AutoPhone = ko.observable(r.AutoPhone);

				try {
					var u = JSON.parse(r.MalariaAppUsage);
					var score = parseInt(u.download || 0) + parseInt(u.upload || 0)
					r.MalariaAppUsage = calculateSize(Math.abs(score));

					var score = 0;
					JSON.parse(r.OtherAppUsage).forEach(u => {
						score += parseInt(u.download) + parseInt(u.upload);
					});
					r.OtherAppUsage = calculateSize(Math.abs(score));
				} catch (e) {

				}
			});
			vmwDevices = rs;

			self.hc.notifySubscribers(self.hc());
		});
	}

	function getDeviceLog() {
		self.type('hf');

		self.hfLogList.removeAll();
		self.vmwLogList.removeAll();
		self.odLogList.removeAll();

		app.ajax('/Device/getDeviceLog').done(function (rs) {
			if (app.user.od != '') {
				rs.hf = rs.hf.filter(r => r.Code_OD_T == app.user.od);
				rs.vmw = rs.vmw.filter(r => r.Code_OD_T == app.user.od);
				rs.od = rs.od.filter(r => r.Code_OD_T == app.user.od);
			} else if (app.user.prov != '') {
				rs.hf = rs.hf.filter(r => app.user.prov.contain(r.Code_Prov_T));
				rs.vmw = rs.vmw.filter(r => app.user.prov.contain(r.Code_Prov_T));
				rs.od = rs.od.filter(r => app.user.prov.contain(r.Code_Prov_T));
			}

			hfLog = rs.hf;
			vmwLog = rs.vmw;
			odLog = rs.od;

			self.prov.notifySubscribers(self.prov());
		});
	}

	function displayMap() {
	    if (map != null) {
			mapFilterChange();
			return;
		}
	    
		self.type('hf');

		map = app.createGoogleMap('map', {
			zoom: 7.8
		});

		app.ajax('/Device/getDeviceMap').done(function (rs) {
			if (app.user.od != '') {
				rs.device = rs.device.filter(r => r.oc == app.user.od);
				rs.place = rs.place.filter(r => r.oc == app.user.od);
			} else if (app.user.prov != '') {
				rs.device = rs.device.filter(r => app.user.prov.contain(r.pc));
				rs.place = rs.place.filter(r => app.user.prov.contain(r.pc));
			}

			var list = {};

			rs.place.forEach(r => {
				var marker = new google.maps.Marker({
					position: { lat: parseFloat(r.lat), lng: parseFloat(r.long) },
					icon: r.code.length == 6 ? '/media/images/marker-hc.png' : '/media/images/marker-vmw.png',
					zIndex: 100
				});

				var txt = r.code.length == 6 ? '<b>Health Facility Location</b>' : '<b>VMW Location</b>'
				txt += '<br><b>Province:</b> ' + r.pe + ' ' + r.pk;
				txt += '<br><b>OD:</b> ' + r.oe + ' ' + r.ok;
				txt += '<br><b>HF:</b> ' + r.he + ' ' + r.hk;
				if (r.code.length == 10) txt += '<br><b>Village:</b> ' + r.ve + ' ' + r.vk;

				var infowindow = new google.maps.InfoWindow({ content: txt });
				marker.addListener('mouseover', () => infowindow.open(map, marker));
				marker.addListener('mouseout', () => infowindow.close());

				if (r.code.length == 6) {
					hfMarkers.push({ marker: marker, prov: r.pc, od: r.oc, hc: r.hc });
				} else {
					vmwMarkers.push({ marker: marker, prov: r.pc, od: r.oc, hc: r.hc });
				}

				list[r.code] = { marker: marker, position: marker.getPosition() };
			});

			rs.device.forEach(r => {
				var marker = new google.maps.Marker({
					position: { lat: parseFloat(r.lat), lng: parseFloat(r.long) },
					icon: r.code.length == 6 ? '/media/images/marker-red3.png' : '/media/images/marker-blue3.png',
					zIndex: 101
				});

				var txt = r.code.length == 6 ? '<b>HF Device Location</b>' : '<b>VMW Device Location</b>'
				txt += '<br><b>Province:</b> ' + r.pe + ' ' + r.pk;
				txt += '<br><b>OD:</b> ' + r.oe + ' ' + r.ok;
				txt += '<br><b>HF:</b> ' + r.he + ' ' + r.hk;
				if (r.code.length == 10) txt += '<br><b>Village:</b> ' + r.ve + ' ' + r.vk;
				txt += '<br><b>Last Online:</b> ' + moment(r.ud).format('lll');

				var infowindow = new google.maps.InfoWindow({ content: txt });
				marker.addListener('mouseover', () => infowindow.open(map, marker));
				marker.addListener('mouseout', () => infowindow.close());

				if (r.code.length == 6) {
					hfMarkers.push({ marker: marker, prov: r.pc, od: r.oc, hc: r.hc });
				} else {
					vmwMarkers.push({ marker: marker, prov: r.pc, od: r.oc, hc: r.hc });
				}

				var place = list[r.code];
				if (place != null) {
					var a = marker.getPosition();
					var b = place.position;
					var meter = google.maps.geometry.spherical.computeDistanceBetween(a, b);
					if (meter >= 1000) {
						var line = new google.maps.Polyline({
							path: [a, b],
							strokeColor: r.code.length == 6 ? 'red' : 'blue',
							strokeWeight: 2
						});
						farLines.push(line);

						var km = Math.floor(meter / 1000);

						if (r.code.length == 6) {
							hfFarMarkers.push({ marker: place.marker, prov: r.pc, od: r.oc, hc: r.hc, km: km });
							hfFarMarkers.push({ marker: marker, prov: r.pc, od: r.oc, hc: r.hc, km: km });
							hfFarMarkers.push({ marker: line, prov: r.pc, od: r.oc, hc: r.hc, km: km });
						} else {
							vmwFarMarkers.push({ marker: place.marker, prov: r.pc, od: r.oc, hc: r.hc, km: km });
							vmwFarMarkers.push({ marker: marker, prov: r.pc, od: r.oc, hc: r.hc, km: km });
							vmwFarMarkers.push({ marker: line, prov: r.pc, od: r.oc, hc: r.hc, km: km });
						}
					}
				}
			});

			mapFilterChange();
		});
	}

	function appUpload() {
		app.ajax('/Device/getAppVersion').done(function (rs) {
			rs.status = '';
			self.appModel(app.ko(rs));
		});
	}

	self.hfAcceptClick = function (model) {
		app.ajax('/Telegram/acceptDevice/hf/' + model.Rec_ID).done(function () {
			self.hfRequestList.remove(model);
		});
        
		var MD0User = { 
		    ID: 'HF_' + model.Rec_ID, 
		    Username: model.Name_Facility_E, 
		    Email: '', 
		    Phone: null,
		    Password: 'MD06789',
		    CodePlace: model.Code_Facility_T,
		    Place: model.Code_Facility_T + '-' + model.Name_Facility_E + ' (Health Facility)',
		    Role: 'Default',
		    Status: 1,
		    Action: 'New' 
		};
		var s = {
		    table: 'tblMDZeroUsers',
		    value: MD0User
		};

		var submit = { submit: JSON.stringify(s) };
		app.ajax('/Direct/insert', submit);
	};

	self.vmwAcceptClick = function (model) {
		app.ajax('/Telegram/acceptDevice/vmw/' + model.Rec_ID).done(function () {
			self.vmwRequestList.remove(model);
		});

		var MD0User = {
		    ID: 'VMW_' + model.Rec_ID,
		    Username: model.Name_Vill_E,
		    Phone: null,
		    Email: '',
		    Password: 'MD06789',
		    CodePlace: model.Code_Vill_T,
		    Place: model.Code_Vill_T + '-' + model.Name_Vill_E + ' (Village)',
		    Role: 'Default',
		    Status: 1,
		    Action: 'New'
		};
		var s = {
		    table: 'tblMDZeroUsers',
		    value: MD0User
		};

		var submit = { submit: JSON.stringify(s) };
		app.ajax('/Direct/insert', submit);
	};

	self.hfChangeActive = function (model) {
		model.Active(model.Active() == 0 ? 1 : 0);

		var submit = {
			table: 'tblHFDevice',
			value: { Active: model.Active() },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.vmwChangeActive = function (model) {
		model.Active(model.Active() == 0 ? 1 : 0);

		var submit = {
			table: 'tblVMWDevice',
			value: { Active: model.Active() },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.hfChangeExpireEntry = function (model) {
		model.ExpireEntry(model.ExpireEntry() == 0 ? 1 : 0);

		var submit = {
			table: 'tblHFDevice',
			value: { ExpireEntry: model.ExpireEntry() },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.vmwChangeExpireEntry = function (model) {
		model.ExpireEntry(model.ExpireEntry() == 0 ? 1 : 0);

		var submit = {
			table: 'tblVMWDevice',
			value: { ExpireEntry: model.ExpireEntry() },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.hfChangeExpireStock = function (model) {
		model.ExpireStock(model.ExpireStock() == 0 ? 1 : 0);

		var submit = {
			table: 'tblHFDevice',
			value: { ExpireStock: model.ExpireStock() },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.hfChangeAutoPhone = function (model) {
		model.AutoPhone(model.AutoPhone() == 0 ? 1 : 0);

		var submit = {
			table: 'tblHFDevice',
			value: { AutoPhone: model.AutoPhone() },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.vmwChangeAutoPhone = function (model) {
		model.AutoPhone(model.AutoPhone() == 0 ? 1 : 0);

		var submit = {
			table: 'tblVMWDevice',
			value: { AutoPhone: model.AutoPhone() },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.hfEditClick = function (model) {
		self.editModel({
			Rec_ID: model.Rec_ID,
			Name: model.Name_Facility_K,
			NameE: model.Name_Facility_E,
            Code: model.Code_Facility_T,
			Phone: model.Phone(),
			Model: model.Model(),
			Type: 'HF'
		});
		$('#modalEdit').modal('show');
	};

	self.vmwEditClick = function (model) {
		self.editModel({
			Rec_ID: model.Rec_ID,
			Name: model.Name_Vill_K,
			NameE: model.Name_Vill_E,
            Code: model.Code_Vill_T,
			Phone: model.Phone(),
			Model: model.Model(),
			Type: 'VMW'
		});
		$('#modalEdit').modal('show');
	};

	self.saveEdit = function () {
		$('#modalEdit').modal('hide');

		var model = self.editModel();
		var submit = {
			table: model.Type == 'HF' ? 'tblHFDevice' : 'tblVMWDevice',
			value: { Phone: model.Phone, Model: model.Model },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			var list = model.Type == 'HF' ? hfDevices : vmwDevices;
			var found = list.find(r => r.Rec_ID == model.Rec_ID);
			found.Phone(model.Phone);
			found.Model(model.Model);
		});
        
		var submitM = {
		    code: model.Code,
		    user: model.NameE,
		    phone: model.Phone
		};

		submitM = { submitM: JSON.stringify(submitM) };

		app.ajax('/Device/updateMD0', submitM);
	};

	self.hfDeleteClick = function (model) {
		app.showDelete(function () {
			app.ajax('/Telegram/deleteDevice/hf/' + model.Rec_ID).done(function () {
				hfDevices = hfDevices.filter(r => r.Rec_ID != model.Rec_ID);
				self.hfRequestList.remove(model);
				self.hfDeviceList.remove(model);
			});
		});
	};

	self.vmwDeleteClick = function (model) {
		app.showDelete(function () {
			app.ajax('/Telegram/deleteDevice/vmw/' + model.Rec_ID).done(function () {
				vmwDevices = vmwDevices.filter(r => r.Rec_ID != model.Rec_ID);
				self.vmwRequestList.remove(model);
				self.vmwDeviceList.remove(model);
			});
		});
	};

	self.newPhoneClick = function (model) {
		var form = $('#modalNewPhone');
		form.modal('show');

		form.find('.btn-primary').off().click(function () {
			$('#modalNewPhone').modal('hide');

			var submit = {
				table: model.Code_Vill_T == null ? 'tblHFDevice' : 'tblVMWDevice',
				value: { Phone: model.NewPhone(), NewPhone: null },
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/update', submit).done(function () {
				model.Phone(model.NewPhone());
				model.NewPhone(null);
			});
		});

		form.find('.btn-danger').off().click(function () {
			$('#modalNewPhone').modal('hide');

			var submit = {
				table: model.Code_Vill_T == null ? 'tblHFDevice' : 'tblVMWDevice',
				value: { NewPhone: null },
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/update', submit).done(function () {
				model.NewPhone(null);
			});
		});
	};

	self.logSaveClick = function (model) {
		var submit = {
			table: 'tblDeviceLog',
			value: { Note: model.Note },
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.logDeleteClick = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblDeviceLog',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				if (model.Code.length == 6) {
					hfLog = hfLog.filter(r => r.Rec_ID != model.Rec_ID);
					self.hfLogList.remove(model);
				} else if (model.Code.length == 10) {
					vmwLog = vmwLog.filter(r => r.Rec_ID != model.Rec_ID);
					self.vmwLogList.remove(model);
				} else {
					odLog = odLog.filter(r => r.Rec_ID != model.Rec_ID);
					self.odLogList.remove(model);
				}
			});
		});
	};

	self.exportExcel = function () {
		if (self.type() == 'hf') {
			if (self.hfLogList().length == 0) return;

			var filename = 'HF Devices Inventory';
			var data = self.hfLogList().map(r => {
				return {
					'Province Code': r.Code_Prov_T,
					'Province': r.Name_Prov_E,
					'OD Code': r.Code_OD_T,
					'OD': r.Name_OD_E,
					'HF Code': r.Code,
					'HF': r.Name_Facility_E,
					'Imei': r.Imei,
					'Model': r.Model,
					'Phone': r.Phone,
					'Registered On': moment(r.CreatedOn).toDate(),
					'Status': r.Status,
					'Note': r.Note
				}
			});
		} else if (self.type() == 'vmw') {
			if (self.vmwLogList().length == 0) return;

			var filename = 'VMW Devices Inventory';
			var data = self.vmwLogList().map(r => {
				return {
					'Province Code': r.Code_Prov_T,
					'Province': r.Name_Prov_E,
					'OD Code': r.Code_OD_T,
					'OD': r.Name_OD_E,
					'HF Code': r.Code_Facility_T,
					'HF': r.Name_Facility_E,
					'VMW Code': r.Code,
					'VMW': r.Name_Vill_E,
					'Imei': r.Imei,
					'Model': r.Model,
					'Phone': r.Phone,
					'Registered On': moment(r.CreatedOn).toDate(),
					'Status': r.Status,
					'Note': r.Note
				}
			});
		} else {
			if (self.odLogList().length == 0) return;

			var filename = 'OD Devices Inventory';
			var data = self.odLogList().map(r => {
				return {
					'Province Code': r.Code_Prov_T,
					'Province': r.Name_Prov_E,
					'OD Code': r.Code_OD_T,
					'OD': r.Name_OD_E,
					'Imei': r.Imei,
					'Model': r.Model,
					'Phone': r.Phone,
					'Registered On': moment(r.CreatedOn).toDate(),
					'Status': r.Status,
					'Note': r.Note
				}
			});
		}

		var wb = XLSX.utils.book_new();
		XLSX.utils.book_append_sheet(wb, XLSX.utils.json_to_sheet(data));
		XLSX.writeFile(wb, filename + '.xlsx', { compression: true });
	};

	self.prov.subscribe(function (code) {
		var before = self.od();

		self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
		self.odLogList(code == null ? odLog : odLog.filter(r => r.Code_Prov_T == code));

		if (before == self.od()) self.od.notifySubscribers(before);
	});

	self.od.subscribe(function (code) {
		var before = self.hc();
		var deviceList = hfDevices;
		var logList = hfLog;
		
		self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));

		if (code != null) {
			deviceList = hfDevices.filter(r => r.Code_OD_T == code);
			logList = hfLog.filter(r => r.Code_OD_T == code)
		} else if (self.prov() != null) {
			deviceList = hfDevices.filter(r => r.Code_Prov_T == self.prov());
			logList = hfLog.filter(r => r.Code_Prov_T == self.prov());
		}

		if (self.from() != null && self.to() != null) {
			logList = logList.filter(r => moment(r.CreatedOn) >= self.from() && moment(r.CreatedOn) <= self.to());
		}
		if (self.newPhone()) {
			deviceList = deviceList.filter(r => r.NewPhone() != null);
		}
		if (self.deviceModel() != 'All Model') {
			deviceList = deviceList.filter(r => r.Model() == self.deviceModel());
		}

		self.hfDeviceList(deviceList);
		self.hfLogList(logList);

		if (before == self.hc()) self.hc.notifySubscribers(before);
	});

	self.hc.subscribe(function (code) {
		var deviceList = vmwDevices;
		var logList = vmwLog;

		if (code != null) {
			deviceList = vmwDevices.filter(r => r.Code_Facility_T == code);
			logList = vmwLog.filter(r => r.Code_Facility_T == code);
		} else if (self.od() != null) {
			deviceList = vmwDevices.filter(r => r.Code_OD_T == self.od());
			logList = vmwLog.filter(r => r.Code_OD_T == self.od());
		} else if (self.prov() != null) {
			deviceList = vmwDevices.filter(r => r.Code_Prov_T == self.prov());
			logList = vmwLog.filter(r => r.Code_Prov_T == self.prov());
		}

		if (self.from() != null && self.to() != null) {
			logList = logList.filter(r => moment(r.CreatedOn) >= self.from() && moment(r.CreatedOn) <= self.to());
		}
		if (self.newPhone()) {
			deviceList = deviceList.filter(r => r.NewPhone() != null);
		}
		if (self.deviceModel() != 'All Model') {
			deviceList = deviceList.filter(r => r.Model() == self.deviceModel());
		}

		self.vmwDeviceList(deviceList);
		self.vmwLogList(logList);

		mapFilterChange();
	});

	self.type.subscribe(function () {
		mapFilterChange();
	});

	self.far.subscribe(function () {
		mapFilterChange();
	});

	self.farKm.subscribe(function () {
		if (self.far()) mapFilterChange();
	});

	self.newPhone.subscribe(function () {
		self.od.notifySubscribers(self.od());
	});

	self.deviceModel.subscribe(function () {
		self.od.notifySubscribers(self.od());
	});

	self.from.subscribe(function () {
		self.od.notifySubscribers(self.od());
	});

	self.to.subscribe(function () {
		self.od.notifySubscribers(self.od());
	});

	function mapFilterChange() {
		if (self.menu() != 'Map' || map == null) return;

		hfMarkers.forEach(r => r.marker.setMap(null));
		vmwMarkers.forEach(r => r.marker.setMap(null));
		farLines.forEach(r => r.setMap(null));

		if (self.type().in('hf', 'all')) {
			var hfArray = self.far() ? hfFarMarkers : hfMarkers;

			if (self.prov() != null) hfArray = hfArray.filter(r => r.prov == self.prov());
			if (self.od() != null) hfArray = hfArray.filter(r => r.od == self.od());
			if (self.hc() != null) hfArray = hfArray.filter(r => r.hc == self.hc());
			if (self.far()) hfArray = hfArray.filter(r => r.km >= self.farKm());

			hfArray.forEach(r => r.marker.setMap(map));
		}
		if (self.type().in('vmw', 'all')) {
			var vmwArray = self.far() ? vmwFarMarkers : vmwMarkers;

			if (self.prov() != null) vmwArray = vmwArray.filter(r => r.prov == self.prov());
			if (self.od() != null) vmwArray = vmwArray.filter(r => r.od == self.od());
			if (self.hc() != null) vmwArray = vmwArray.filter(r => r.hc == self.hc());
			if (self.far()) vmwArray = vmwArray.filter(r => r.km >= self.farKm());

			vmwArray.forEach(r => r.marker.setMap(map));
		}
	}

	self.selectFile = function () {
		$('#file').val('').click();
	};

	self.fileChanged = function (files) {
		var model = self.appModel();
		model.name(files[0].name);
		model.status('Uploading');
		model.version(model.name().split('build')[1].split('.')[0].trim());

		var reader = new FileReader();
		reader.onload = function () {
			var submit = {
				base64: reader.result.split(',')[1],
				name: model.name(),
				version: model.version()
			};
			app.ajax('/Device/uploadApp', submit).done(function () {
				model.status('Done');
			});
		};
		reader.readAsDataURL(files[0]);
	};

	function calculateSize(value) {
		value = value / 1024;
		return value < 1024 ? value.toFixed(1) + ' MB' : (value / 1024).toFixed(1) + ' GB';
	}

	self.showNewOD = function () {
		var model = {
			pvlist: place.pv,
			odlist: ko.observableArray(),
			pv: ko.observable(),
			od: ko.observable(),
			imei: ko.observable(''),
			model: ko.observable(''),
			phone: ko.observable('')
		};

		model.pv.subscribe(function (code) {
			model.odlist(place.od.filter(r => r.pvcode == code && r.target == 1));
		});
		self.newODModel(model);

		$('#modalNewOD').modal('show');
	};

	self.saveNewOD = function () {
		var model = self.newODModel();

		model.imei(model.imei().trim());
		model.model(model.model().trim());
		model.phone(model.phone().trim());

		var missing = false;
		if (model.imei() == '') {
			app.showWarning(model.imei.element, 'Please input this box.');
			missing = true;
		} else {
			var imei = model.imei();

			var found = odLog.find(r => r.Imei == imei);
			if (found != null) {
				var name = found.Name_Prov_E + ' > ' + found.Name_OD_E;
				app.showWarning(model.imei.element, 'This IMEI is already existed at OD: ' + name);
				missing = true;
			} else {
				found = hfLog.find(r => r.Imei == imei);
				if (found != null) {
					var name = found.Name_Prov_E + ' > ' + found.Name_OD_E + ' > ' + found.Name_Facility_E;
					app.showWarning(model.imei.element, 'This IMEI is already existed at HF: ' + name);
					missing = true;
				} else {
					found = vmwLog.find(r => r.Imei == imei);
					if (found != null) {
						var name = found.Name_Prov_E + ' > ' + found.Name_OD_E + ' > ' + found.Name_Facility_E + ' > ' + found.Name_Vill_E;
						app.showWarning(model.imei.element, 'This IMEI is already existed at VMW: ' + name);
						missing = true;
					}
				}
			}
		}
		if (model.model() == '') {
			app.showWarning(model.model.element, 'Please input this box.');
			missing = true;
		}
		if (missing) return;

		$('#modalNewOD').modal('hide');

		var newModel = {
			Code: model.od(),
			Imei: model.imei(),
			Model: model.model(),
			Phone: is(model.phone(), '', null),
			CreatedOn: 'getdate()'
		};
		var submit = {
			table: 'tblDeviceLog',
			value: newModel
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/insert', submit).done(function (id) {
			newModel.Code_Prov_T = model.pv();
			newModel.Name_Prov_E = place.pv.find(r => r.code == model.pv()).name;
			newModel.Name_OD_E = place.od.find(r => r.code == model.od()).name;
			newModel.Rec_ID = id;
			newModel.CreatedOn = moment().format('YYYY-MM-DD');
			newModel.Status = null;
			newModel.Note = null;

			odLog.push(newModel);
			odLog.sortasc(r => r.Name_Prov_E, r => r.Name_OD_E);
			self.prov.notifySubscribers(self.prov());
		});
	};

	self.checkPermission
}