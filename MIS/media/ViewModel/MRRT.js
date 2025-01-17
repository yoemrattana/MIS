function viewModel() {
	var self = this;

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.group = ko.observable();
	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	var place = null;

	app.getPlace(['pv', 'od'], function (p) {
		place = p;
		self.pvList(p.pv);

		app.ajax('/MRRT/getData').done(function (rs) {
			self.listModel(rs);
		});
	});

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Code_Prov_T: null,
			Code_OD_T: null,
			GroupName: '',
			Member: '',
			Position: '',
			TrainFrom: null,
			TrainTo: null,
			EntomoFrom: null,
			EntomoTo: null,
			Note: ''
		};
		self.showEdit(model);
	};

	self.showEdit = function (model) {
		var model = app.ko(model);

		model.pvList = ko.observableArray(place.pv);
		model.odList = () => place.od.filter(r => r.pvcode == model.Code_Prov_T());

		self.editModel(model);
		$('#modalEdit').modal('show');
	};

	self.save = function () {
		var model = self.editModel();
		var missing = false;

		app.removeAllWarning();

		if (model.Code_Prov_T() == null) {
			app.showWarning(model.Code_Prov_T.element);
			missing = true;
		}
		if (model.GroupName() == '') {
			app.showWarning(model.GroupName.element);
			missing = true;
		}
		if (model.Member() == '') {
			app.showWarning(model.Member.element);
			missing = true;
		}
		if (model.Position() == '') {
			app.showWarning(model.Position.element);
			missing = true;
		}
		if (model.TrainFrom() == null) {
			app.showWarning(model.TrainFrom.element);
			missing = true;
		}
		if (model.TrainTo() == null) {
			app.showWarning(model.TrainTo.element);
			missing = true;
		}
		if (model.EntomoFrom() != null && model.EntomoTo() == null) {
			app.showWarning(model.EntomoTo.element);
			missing = true;
		}
		if (missing) return;

		$('#modalEdit').modal('hide');

		model = app.unko(model);

		var submit = { model: JSON.stringify(model) };
		app.ajax('/MRRT/save', submit).done(function (id) {
			if (model.Rec_ID == 0) {
				model.Rec_ID = id;
				self.listModel.push(model);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == id);
				self.listModel.replace(old, model);
			}
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = { Rec_ID: model.Rec_ID };
			app.ajax('/MRRT/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.getListModel = function () {
		var list = self.listModel();

		if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());

		if (self.group() != 'All') list = list.filter(r => r.GroupName == self.group());

		return list;
	};

	self.odList = function () {
		return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
	};

	self.getPVName = function (code) {
		return place.pv.find(r => r.code == code).name;
	};

	self.getODName = function (code) {
		return code == null ? 'PHD' : place.od.find(r => r.code == code).name;
	};
}