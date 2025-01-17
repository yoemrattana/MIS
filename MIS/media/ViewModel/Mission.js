function viewModel() {
	var self = this;

	self.nameList = ['Pengby', 'Vanna', 'Kimleng', 'Rattana', 'Serey', 'Saky', 'Dara'];
	self.year = ko.observable(moment().year());
	self.editModel = ko.observable();
	self.pvList = [];
	self.listModel = ko.observableArray();
    self.today = moment().format('YYYY-MM-DD');

    self.statusList = ['Plan', 'Done', 'Cancel', 'Official'];

	var updating = false;

	app.getPlace(['pv'], function (p) {
		self.pvList = p.pv;

		getData();
	});

	function getData() {
		var submit = { year: self.year() };

		app.ajax('/Mission/getData', submit).done(function (rs) {
			self.listModel(rs);
		});
	}

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
			Name: '',
			Name2: '',
			Name3: '',
			Name4: '',
			Name5: '',
			DateFrom: '',
			DateTo: '',
			Code_Prov_T: null,
			Code_Prov_T2: null,
            Driver: '',
            Status: '',
		};
		if (obj.id > 0) model = self.listModel().find(r => r.Rec_ID == obj.id);

		model = app.ko(model);
		model.dateError = function () {
			if (model.DateFrom() == '' || model.DateTo() == '') return '';

			var from = model.DateFrom();
			var to = model.DateTo();

			if (from > to) return 'Date Error';

			var names = ['', '2', '3', '4', '5'].map(r => isnot(model['Name' + r], undefined, f => f())).filter(r => r != null);
			if (names.length == 0) return '';
			
			var overlap = self.listModel().some(r => {
				if (r.Rec_ID == model.Rec_ID()) return false;
				if (!names.contain(r.Name)) return false;
				if (from >= r.DateFrom && from <= r.DateTo) return true;
				if (to >= r.DateFrom && to <= r.DateTo) return true;
				return false;
			});
			if (overlap) return 'Mission Overlap';

			return '';
		};

		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.save = function (model) {
		if (model.Name() == null) return;
		if (model.DateFrom() == '') return;
		if (model.DateTo() == '') return;
		if (model.Code_Prov_T() == null) return;
		if (model.dateError() != '') return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);
		var id = model.Rec_ID;
		delete model.Rec_ID;

		if (id == 0) {
			var arr = ['', '2', '3', '4', '5'];
			model.names = arr.map(r => model['Name' + r]).filter(r => r != null).distinct();
			arr.forEach(r => delete model['Name' + r]);

			app.ajax('/Mission/save', model).done(function (rs) {
				self.listModel.push(...rs);
			});
		} else {
			model.Code_Prov_T2 = model.Code_Prov_T2 || null;

			var submit = {
				table: 'tblMission',
				value: model,
				where: { Rec_ID: id }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/update', submit).done(function (rs) {
				self.listModel.remove(r => r.Rec_ID == id);
				self.listModel.push(rs);
			});
		}
	};

	self.delete = function (model) {
		setTimeout(function () {
			var submit = {
				table: 'tblMission',
				where: { Rec_ID: model.Rec_ID() }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function (rs) {
				self.listModel.remove(r => r.Rec_ID == model.Rec_ID());
			});
		});
	};

	self.getPvList2 = function () {
		var code1 = self.editModel().Code_Prov_T();
		return code1 == null ? [] : self.pvList.filter(r => r.code != code1);
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

		var obj = { id: found.Rec_ID, tooltip: name, place: 'right' };

		if (found.DateFrom.substr(0, 7) == found.DateTo.substr(0, 7)) {
			if (found.DateFrom == date) {
				obj.length = moment(found.DateTo).diff(found.DateFrom, 'day') + 1;
				if (moment(found.DateTo).add('day', 2).date() <= 2) obj.place = 'left';
			} else {
				return null;
			}
		} else {
			if (found.DateFrom == date) {
				var to = moment(found.DateFrom);
				to.date(to.daysInMonth());
				obj.length = to.diff(found.DateFrom, 'day') + 1;
				obj.place = 'left';
			} else if (found.DateTo.substr(0, 7) == date.substr(0, 7) && date.substr(-2) == '01') {
				obj.length = moment(found.DateTo).diff(date, 'day') + 1;
			} else {
				return null;
			}
		}

		var len = obj.length * 46 - 10;
		obj.length = len + 'px';

        var colors = ['info', 'primary', 'danger', 'success', 'warning', 'default'];
		obj.color = 'progress-bar-' + colors[self.nameList.indexOf(name)];

		obj.prov = self.pvList.find(r => r.code == found.Code_Prov_T).name;
		if (found.Code_Prov_T2 != null) {
			obj.prov += ' & ' + self.pvList.find(r => r.code == found.Code_Prov_T2).name;
        }

        obj.status = found.Status;

		if (getTextWidth(obj.prov) > len) obj.tooltip = obj.prov;

		return obj;
	};

	function getTextWidth(text) {
		$('#textMeasure').text(text);
		return $('#textMeasure')[0].getBoundingClientRect().width;
    }

    self.quarterList = ko.observableArray();
    self.getQuarter = function () {
        app.ajax('Mission/getQuarter', { year: self.year() }).done(function (rs) {
            self.quarterList(rs)
            $('#modalQuarter').modal('show');
        })
    }
}