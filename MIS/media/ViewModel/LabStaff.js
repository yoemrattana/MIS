function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.eventList = ko.observableArray();
	self.staffName = ko.observable();
	self.loaded = ko.observable(false);

	var staff = null;

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
		app.ajax('/Lab/getStaff', submit).done(function (rs) {
			var list = rs.map(app.ko);
			list.forEach(r => {
				r.Working = ko.computed(() => isnone(r.YOW()) ? '' : moment().year() - r.YOW());
			});

			self.listModel(list);
			self.loaded(true);

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	}

	self.addStaff = function () {
		var model = app.ko(newModel());
		model.Working = ko.computed(() => isnone(model.YOW()) ? '' : moment().year() - model.YOW());
		self.listModel.push(model);
	};

	self.save = function () {
		var list = self.listModel();
		var missing = false;

		if (list.length == 0) return;

		list.forEach(r => {
			if (r.Name() === '') {
				self.showWarning(r.Name);
				missing = true;
			}
		});
		if (missing) {
			app.showMsg('Missing Data', 'Please input data into the red boxes.');
			return;
		}

		list = list.map(r => {
			return {
				Staff_ID: r.Staff_ID(),
				Name: r.Name(),
				NameK: r.NameK(),
				Position: r.Position(),
				MaritalStatus: r.MaritalStatus(),
				Sex: r.Sex(),
				YOB: r.YOB(),
				YOW: r.YOW(),
				Working: r.Working(),
				Certificate: r.Certificate(),
				Phone: r.Phone(),
				BankAccount: r.BankAccount(),
				Remark: r.Remark(),
				Interesting: r.Interesting(),
				Forcol: r.Forcol(),
				Code_Facility_T: r.Code_Facility_T(),
				ModiUser: app.user.username,
				ModiTime: moment().sqlformat('datetime'),
			};
		});

		var submit = {
			list: JSON.stringify(list),
			hc: self.pv() == 'CNM' ? 'CNM' : self.hc()
		};
		app.ajax('/Lab/saveStaff', submit).done(function (rs) {
			self.listModel(rs.map(app.ko));
		});
	};

	self.delete = function (model) {
		app.showDelete(function () {
			if (model.Staff_ID() == 0) {
				self.listModel.remove(model);
			} else {
				var submit = { Staff_ID: model.Staff_ID() };
				app.ajax('/Lab/deleteStaff', submit).done(function (error) {
					if (error) app.showMsg('Cannot delete this staff', 'This staff is linked with some data.', true);
					else self.listModel.remove(model);
				});
			}
		});
	};

	self.showEvent = function (model) {
		staff = model;
		self.staffName(model.Name());

		var submit = {
			id: model.Staff_ID()
		};
		app.ajax('/Lab/getStaffEvent', submit).done(function (rs) {
			rs.forEach(r => delete r.Rec_ID);
			self.eventList(rs.map(app.ko));
			if (self.eventList().length == 0) self.addEvent();
			$('#modalEvent').modal('show');
		});
	};

	self.addEvent = function () {
		var obj = {
			Staff_ID: staff.Staff_ID(),
			FromDate: '',
			ToDate: '',
			EventType: '',
			EventName: '',
			Score: '',
			NextTraining: ''
		};
		self.eventList.push(app.ko(obj));
	};

	self.deleteEvent = function (model) {
		self.eventList.remove(model);
	};

	self.saveEvent = function () {
		var missing = false;

		self.removeAllWarning();
		self.eventList().forEach(r => {
			if (r.FromDate() == '') {
				self.showWarning(r.FromDate);
				missing = true;
			}
			if (r.ToDate() == '') {
				self.showWarning(r.ToDate);
				missing = true;
			}
			if (r.EventType() == '') {
				self.showWarning(r.EventType);
				missing = true;
			} else if (r.EventType() == 'Training') {
				if (r.Score() == '') {
					self.showWarning(r.Score);
					missing = true;
				}
				if (r.NextTraining() == '') {
					self.showWarning(r.NextTraining);
					missing = true;
				}
			}
			if (r.EventName() == '') {
				self.showWarning(r.EventName);
				missing = true;
			}
		});
		if (missing) return;

		$('#modalEvent').modal('hide');

		var submit = {
			id: staff.Staff_ID(),
			list: self.eventList().map(r => {
				r = app.unko(r);
				delete r.Rec_ID;
				return r;
			}),
			hc: self.pv() == 'CNM' ? 'CNM' : self.hc()
		};

		app.ajax('/Lab/saveStaffEvent', submit).done(function (rs) {
			self.listModel.replace(staff, app.ko(rs[0]));
		});
	};

	self.eventChange = function (model) {
		if (model.EventType() != 'Training') {
			model.Score('');
			model.NextTraining('');
		}
	};

	self.getAge = function (yob) {
		return yob == '' ? '' : moment().year() - yob.toFloat();
	};

	function newModel() {
		return {
			Staff_ID: 0,
			Name: '',
			NameK: '',
			Position: '',
			MaritalStatus: '',
			Sex: '',
			YOB: '',
			YOW: '',
			Working: '',
			Certificate: '',
			Phone: '',
			BankAccount: '',
			Remark: '',
			BasicYear: '',
			BasicScore: '',
			RefresherYear: '',
			RefresherScore: '',
			NCAMMYear: '',
			NCAMMScore: '',
			PreECAMMYear: '',
			PreECAMMScore: '',
			ECAMMYear: '',
			ECAMMScore: '',
			Interesting: '',
			Forcol: '',
			Code_Facility_T: self.pv() == 'CNM' ? 'CNM' : self.hc()
		};
	}

	self.exportExcel = function () {
		if (self.pv() == null) {
			app.ajax('/Lab/getStaff').done(function (rs) {
				rs.sortasc('Name_Prov_E', 'Name_OD_E', 'Name_Facility_E', 'Name');
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
					'Name En': r.Name,
					'Name Kh': r.NameK,
					'Position': r.Position,
					'Marital': r.MaritalStatus,
					'Sex': r.Sex,
					'YOB': r.YOB,
					'YOW': r.YOW,
					'Certificate': r.Certificate,
					'Phone': r.Phone,
					'ACLEDA': r.BankAccount,
					'Remark': r.Remark,
					'Basic Year': r.BasicYear,
					'Basic Score': r.BasicScore,
					'Refresher Year': r.RefresherYear,
					'Refresher Score': r.RefresherScore,
					'NCAMM Year': r.NCAMMYear,
					'NCAMM Score': r.NCAMMScore,
					'PreECAMM Year': r.PreNCAMMYear,
					'PreECAMM Score': r.PreNCAMMScore,
					'ECAMM Year': r.ECAMMYear,
					'ECAMM Score': r.ECAMMScore,
					'Interesting': r.Interesting,
					'Forcol': r.Forcol
				};
			});
			self.writeExcel(data, 'Staff Profile');
		}
	};
}