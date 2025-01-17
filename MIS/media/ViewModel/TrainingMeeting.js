function viewModel() {
	var self = this;

	self.menu = ko.observable('');
	self.view = ko.observable('');

	self.odList = ko.observableArray();
	self.yearList = Array.repeat(moment().year() - 2022).map((r, i) => i + 2023);
	self.monthList = Array.repeat(12).map((r, i) => moment().month(i).format('MM'));

	self.od = ko.observable();
	self.year = ko.observable(moment().year());
	self.month = ko.observable();

	self.Training = new TrainingClass(self);
	self.Meeting = new MeetingClass(self);

	self.menuClick = function (vm, event) {
		self.menu(event.currentTarget.innerHTML);
		self[self.menu()].getList();
		self.view('list');
	};

	self.menuCss = function (element) {
		return element.innerHTML == self.menu() ? 'btn-info' : 'btn-default';
	};

	app.getPlace(['od'], function (p) {
		var arr = ['02', '07', '09', '15', '23', '24'];
		self.odList(p.od.filter(r => r.target == 1 && arr.contain(r.pvcode)));
	});

	self.showNew = function () {
		self[self.menu()].showNew();
	};

	self.ifcan = function (permission) {
		return app.user.permiss['Training and Meeting'].contain(permission);
	};

	self.exportExcel = function () {
		app.downloadBlob('/TrainingMeeting/exportExcel/' + self.menu()).done(function (blob) {
			saveAs(blob, self.menu() + '.xlsx');
		});
	};

	self.getODName = function (code) {
		return self.odList().find(r => r.code == code).name;
	};
}

function TrainingClass(root) {
	var self = this;

	self.view = root.view;
	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	self.getList = function () {
		if (self.listModel().length > 0) return;

		app.ajax('/TrainingMeeting/getTrainingList').done(function (rs) {
			self.listModel(rs);
		});
	};

	self.getListModel = function () {
		var list = self.listModel().filter(r => r.StartDate.substr(0, 4) == root.year());

		if (root.od() != null) list = list.filter(r => r.Code_OD_T == root.od());
		if (root.month() != null) list = list.filter(r => r.StartDate.substr(5, 2) == root.month());

		return list;
	};

	self.showNew = function () {
		var obj = {
			head: {
				Rec_ID: 0,
				Code_OD_T: '',
				StartDate: '',
				EndDate: '',
				Type: '',
				TrainTo: '',
				About: '',
				Result: '',
				NextStep: ''
			},
			body: []
		};
		self.editModel(app.ko(obj));
		checkBody();

		self.view('detail');
	};

	self.showDetail = function (model) {
		var submit = { ParentId: model.Rec_ID };
		app.ajax('/TrainingMeeting/getTrainingDetail', submit).done(function (rs) {
			var obj = app.ko({
				head: model,
				body: []
			});

			rs.forEach(r => {
				delete r.ParentId;
				var d = app.ko(r);
				applyBodyEvent(d);
				obj.body.push(d);
			});

			self.editModel(obj);
			checkBody();

			self.view('detail');
		});
	};

	self.save = function () {
		var missing = false;
		var head = self.editModel().head;

		if (head.Code_OD_T() == null) {
			app.showWarning(head.Code_OD_T.element);
			missing = true;
		};
		if (head.StartDate() == '') {
			app.showWarning(head.StartDate.element);
			missing = true;
		};
		if (head.EndDate() == '') {
			app.showWarning(head.EndDate.element);
			missing = true;
		};
		if (head.Type() == '') {
			app.showWarning(head.Type.element);
			missing = true;
		};
		if (head.TrainTo() == '') {
			app.showWarning(head.TrainTo.element);
			missing = true;
		};
		if (head.About.trim() == '') {
			app.showWarning(head.About.element);
			missing = true;
		};

		var body = self.editModel().body();
		if (body.length > 1) body = body.filter(hasValue);

		body.forEach(obj => {
			Object.keys(app.unko(obj)).forEach(k => {
				if (obj[k].trim() == '') {
					app.showWarning(obj[k].element);
					missing = true;
				}
			})
		});
		if (missing) return;

		head = app.unko(head);
		body = app.unko(body);

		var submit = { head, body };
		app.ajax('/TrainingMeeting/saveTraining', submit).done(function (id) {
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
				table: 'tblTraining',
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

	self.removeParticipant = function (item) {
		self.editModel().body.remove(item);
		checkBody();
	};

	function hasValue(obj) {
		return Object.keys(app.unko(obj)).some(k => obj[k]().trim() != '');
	}

	function applyBodyEvent(obj) {
		Object.keys(app.unko(obj)).forEach(k => obj[k].subscribe(checkBody));
	}

	function checkBody() {
		var body = self.editModel().body;
		if (body().length == 0 || hasValue(body().last())) {
			var obj = app.ko({
				Name: '',
				Sex: '',
				Position: '',
				Type: ''
			});
			applyBodyEvent(obj);
			body.push(obj);
		}
	}
}

function MeetingClass(root) {
	var self = this;

	self.view = root.view;
	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	self.getList = function () {
		if (self.listModel().length > 0) return;

		app.ajax('/TrainingMeeting/getMeetingList').done(function (rs) {
			self.listModel(rs);
		});
	};

	self.getListModel = function () {
		var list = self.listModel().filter(r => r.StartDate.substr(0, 4) == root.year());

		if (root.od() != null) list = list.filter(r => r.Code_OD_T == root.od());
		if (root.month() != null) list = list.filter(r => r.StartDate.substr(5, 2) == root.month());

		return list;
	};

	self.showNew = function () {
		var obj = {
			head: {
				Rec_ID: 0,
				Code_OD_T: '',
				StartDate: '',
				EndDate: '',
				Type: '',
				About: '',
				Result: '',
				NextStep: ''
			},
			body: []
		};
		self.editModel(app.ko(obj));
		checkBody();

		self.view('detail');
	};

	self.showDetail = function (model) {
		var submit = { ParentId: model.Rec_ID };
		app.ajax('/TrainingMeeting/getMeetingDetail', submit).done(function (rs) {
			var obj = app.ko({
				head: model,
				body: []
			});

			rs.forEach(r => {
				delete r.ParentId;
				var d = app.ko(r);
				applyBodyEvent(d);
				obj.body.push(d);
			});

			self.editModel(obj);
			checkBody();

			self.view('detail');
		});
	};

	self.save = function () {
		var missing = false;
		var head = self.editModel().head;

		if (head.Code_OD_T() == null) {
			app.showWarning(head.Code_OD_T.element);
			missing = true;
		};
		if (head.StartDate() == '') {
			app.showWarning(head.StartDate.element);
			missing = true;
		};
		if (head.EndDate() == '') {
			app.showWarning(head.EndDate.element);
			missing = true;
		};
		if (head.Type() == '') {
			app.showWarning(head.Type.element);
			missing = true;
		};
		if (head.About.trim() == '') {
			app.showWarning(head.About.element);
			missing = true;
		};

		var body = self.editModel().body();
		if (body.length > 1) body = body.filter(hasValue);

		body.forEach(obj => {
			Object.keys(app.unko(obj)).forEach(k => {
				if (obj[k].trim() == '') {
					app.showWarning(obj[k].element);
					missing = true;
				}
			})
		});
		if (missing) return;

		head = app.unko(head);
		body = app.unko(body);

		var submit = { head, body };
		app.ajax('/TrainingMeeting/saveMeeting', submit).done(function (id) {
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
				table: 'tblMeeting',
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

	self.removeParticipant = function (item) {
		self.editModel().body.remove(item);
		checkBody();
	};

	function hasValue(obj) {
		return Object.keys(app.unko(obj)).some(k => obj[k]().trim() != '');
	}

	function applyBodyEvent(obj) {
		Object.keys(app.unko(obj)).forEach(k => obj[k].subscribe(checkBody));
	}

	function checkBody() {
		var body = self.editModel().body;
		if (body().length == 0 || hasValue(body().last())) {
			var obj = app.ko({
				Name: '',
				Sex: '',
				Position: ''
			});
			applyBodyEvent(obj);
			body.push(obj);
		}
	}
}