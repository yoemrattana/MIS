function subViewModel(self) {
	self.view = ko.observable('list');
	self.listModel = ko.observableArray();
	self.editModel = ko.observable();
	self.detailList = ko.observableArray();

	self.staff = ko.observable();

	var staffs = [];
	var tbl = 'tblLab' + location.pathname.split('/').last().split('_')[0];

	self.prepare = function () {
		self.pvList.unshift({ code: 'CNM', name: 'CNM' });

		app.ajax(`/Lab/getTraining/${tbl}`).done(function (rs) {
			self.listModel(rs.list);
			staffs = rs.staffs;
		});
	};

	self.showNew = function () {
		var head = {
			Rec_ID: 0,
			DateFrom: '',
			DateTo: '',
			Venue: '',
			Support: '',
			Batch: ''
		};
		self.editModel(app.ko(head));
		self.detailList([]);

		self.view('detail');
	};

	self.showEdit = function (model) {
		var submit = { ParentId: model.Rec_ID };
		app.ajax(`/Lab/getTrainingStaff/${tbl}`, submit).done(function (rs) {
			self.editModel(app.ko(model));
			self.detailList(rs.map(r => staffs.find(s => s.Staff_ID == r.Staff_ID)).sortasc('Name'));
			self.view('detail');
		});
	};

	self.save = function () {
		var model = self.editModel();
		var missing = false;

		if (model.DateFrom() == '') {
			self.showWarning(model.DateFrom);
			missing = true;
		}
		if (model.DateTo() == '') {
			self.showWarning(model.DateTo);
			missing = true;
		}
		if (model.Venue() == '') {
			self.showWarning(model.Venue);
			missing = true;
		}
		if (missing) return;

		if (self.detailList().length == 0) {
			app.showMsg('Missing Trainee', 'Please add trainee.');
			return;
		}

		var head = app.unko(model);
		var submit = {
			head: head,
			list: self.detailList().map(r => {
				return { Staff_ID: r.Staff_ID };
			})
		};

		app.ajax(`/Lab/saveTraining/${tbl}`, submit).done(function (id) {
			if (head.Rec_ID == 0) {
				head.Rec_ID = id;
				self.listModel.push(head);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == id);
				self.listModel.replace(old, head);
			}
			self.back();
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: tbl,
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.back = function () {
		self.view('list');
	};

	self.showAdd = function () {
		$('#modalStaff').modal('show');
	};

	self.addStaff = function () {
		if (self.staff() == null) return;
		self.detailList.push(self.staff());
	};

	self.deleteStaff = function (model) {
		self.detailList.remove(model);
	};

	self.staffList = function () {
		var list = self.pv() != 'CNM' && self.hc() == null ? [] : staffs.filter(r => r.Code_Facility_T == (self.pv() == 'CNM' ? 'CNM' : self.hc())).sortasc('Name');
		var arr = self.detailList().map(r => r.Staff_ID);
		return list.filter(r => !arr.contain(r.Staff_ID));
	};

	self.getAge = function (yob) {
		return yob == '' ? '' : moment().year() - yob.toFloat();
	};

	self.getPVName = function (hccode) {
		if (hccode == 'CNM') return 'CNM';

		var od = self.place.hc.find(r => r.code == hccode).odcode;
		var pv = self.place.od.find(r => r.code == od).pvcode;
		return self.place.pv.find(r => r.code == pv).name;
	};

	self.getHCName = function (hccode) {
		if (hccode == 'CNM') return 'CNM';

		return self.place.hc.find(r => r.code == hccode).name;
	};

	self.exportExcel = function () {
		var submit = { tbl };
		app.ajax('/Lab/getTrainingExport', submit).done(function (rs) {
			rs.forEach(r => {
				r.DateFrom = moment(r.DateFrom).toDate();
				r.DateTo = moment(r.DateTo).toDate();
			});

			self.writeExcel(rs, $('.menu.active').text());
		});
	};
}