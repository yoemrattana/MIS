function viewModel() {
	var self = this;

	self.nameList = ['Kimleng', 'Rattana', 'Vanna', 'Serey', 'Saky'];
	self.year = ko.observable(moment().year());
	self.editModel = ko.observable();
	self.listModel = ko.observableArray();
	self.today = moment().format('YYYY-MM-DD');
	self.filter = ko.observable();

	var updating = false;

	function getData() {
		var submit = { year: self.year() };

		app.ajax('/Task/getData', submit).done(function (rs) {
			self.listModel(rs);
		});
	}
	getData();

	self.previousYear = function () {
		updating = true;
		self.year(self.year() - 1);
		updating = false;

		getData();
	};

	self.nextYear = function () {
		updating = true;
		self.year(self.year() + 1);
		updating = false;

		getData();
	};

	self.calendar = function () {
		var c = [];
		var mo = moment(self.year() + '-01-01');

		while (mo.year() == self.year()) {
			var m = mo.month();
			if (c[m] == null) c[m] = [];
			c[m].push(mo.format('YYYY-MM-DD'));

			mo.add('day', 1);
		}

		return c;
	};

	self.showNew = function () {
		self.showEdit({ id: 0 });
	};

	self.showEdit = function (obj) {
		var model = {
			Rec_ID: 0,
			Title: '',
			Description: '',
			Name: '',
			DateFrom: '',
			DateTo: '',
			Done: false
		};
		if (obj.id > 0) model = self.listModel().find(r => r.Rec_ID == obj.id);

		model = app.ko(model);
		model.dateError = function () {
			if (model.DateFrom() == '' || model.DateTo() == '') return '';

			var from = model.DateFrom();
			var to = model.DateTo();

			if (from > to) return 'Date Error';
			if (model.Name() == null) return '';

			var overlap = self.listModel().some(r => {
				if (r.Rec_ID == model.Rec_ID()) return false;
				if (r.Name != model.Name()) return false;
				if (from >= r.DateFrom && from <= r.DateTo) return true;
				if (to >= r.DateFrom && to <= r.DateTo) return true;
				return false;
			});
			if (overlap) return 'Task Overlap';

			return '';
		};

		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.save = function (model) {
		if (model.Title() == null) return;
		if (model.Name() == null) return;
		if (model.DateFrom() == '') return;
		if (model.DateTo() == '') return;
		if (model.dateError() != '') return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);
		var id = model.Rec_ID;

		delete model.Rec_ID;

		var submit = {
			table: 'tblTask',
			value: model,
			where: { Rec_ID: id }
		};
		submit = { submit: JSON.stringify(submit) };

		var url = id == 0 ? '/Direct/insert' : '/Direct/update';
		app.ajax(url, submit).done(function (rs) {
			self.listModel.remove(r => r.Rec_ID == id);
			self.listModel.push(rs);
		});
	};

	self.delete = function (model) {
		setTimeout(function () {
			var submit = {
				table: 'tblTask',
				where: { Rec_ID: model.Rec_ID() }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function (rs) {
				self.listModel.remove(r => r.Rec_ID == model.Rec_ID());
			});
		});
	};

	self.getInfo = function (name, date) {
		if (updating == false) {
			updating = true;
			setTimeout(function () {
				$('.progress').tooltip();
				updating = false;
			});
		}

		var found = self.listModel().find(r => r.Name == name && date >= r.DateFrom && date <= r.DateTo);
		if (found == null) return null;

		if (self.filter() == 'In Progress' && found.Done == 1) return null;
		if (self.filter() == 'Done' && found.Done == 0) return null;

		var obj = { id: found.Rec_ID, title: found.Title, tooltip: found.Title, done: found.Done };

		if (found.DateFrom.substr(0, 7) == found.DateTo.substr(0, 7)) {
			if (found.DateFrom == date) {
				obj.length = moment(found.DateTo).diff(found.DateFrom, 'day') + 1;
			} else {
				return null;
			}
		} else {
			if (found.DateFrom == date) {
				var to = moment(found.DateFrom);
				to.date(to.daysInMonth());
				obj.length = to.diff(found.DateFrom, 'day') + 1;
			} else if (found.DateTo.substr(0, 7) > date.substr(0, 7) && date.substr(-2) == '01') {
				obj.length = moment(date).daysInMonth();
			} else if (found.DateTo.substr(0, 7) == date.substr(0, 7) && date.substr(-2) == '01') {
				obj.length = moment(found.DateTo).diff(date, 'day') + 1;
			} else {
				return null;
			}
		}
		
		var len = obj.length * 46 - 10;
		obj.length = len + 'px';

		var colors = ['danger', 'success', 'primary', 'warning', 'default'];
		obj.color = 'progress-bar-' + colors[self.nameList.indexOf(name)];

		return obj;
	};
}