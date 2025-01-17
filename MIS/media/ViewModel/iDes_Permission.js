function iDesPermission(root) {
	var self = this;

	self.pv = ko.observable();
	self.od = ko.observable();
	self.listModel = ko.observableArray();

	self.odList = function () {
		return self.pv() == null ? [] : root.place.od.filter(r => r.pvcode == self.pv());
	};

	self.getData = function () {
		if (self.listModel().length > 0) return;

		app.ajax('/iDes/getPermission').done(function (rs) {
			rs.forEach(r => {
				r.Permission = ko.observable(r.Permission);
				r.StartDate = ko.observable(r.StartDate && moment(r.StartDate));
			});
			self.listModel(rs);
		});
	};

	self.getListModel = ko.pureComputed(function () {
		var list = self.listModel();

		if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());

		return list;
	});

	self.save = function () {
		var list = self.listModel().filter(r => r.Permission() == 1).map(r => {
			if (r.StartDate() == null) r.StartDate(moment('2022-01'));
			return {
				Code_Facility_T: r.Code_Facility_T,
				StartDate: r.StartDate().format('YYYY-MM')
			}
		});

		var submit = { list: JSON.stringify(list) };
		app.ajax('/iDes/savePermission', submit);
	};

	self.changePermission = function (model) {
		if (!model.Permission()) model.StartDate(null);
	};
}