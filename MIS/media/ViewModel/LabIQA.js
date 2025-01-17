function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.loaded = ko.observable(false);
	self.newModel = ko.observable();

	self.prepare = function () {
		self.pv.subscribe(() => self.loaded(false));
		self.od.subscribe(() => self.loaded(false));
		self.hc.subscribe(() => self.loaded(false));
		self.year.subscribe(() => self.loaded(false));
		self.qt.subscribe(() => self.loaded(false));
	};

	self.viewClick = function () {
		if (self.hc() == null) {
			self.loaded(false);
			return;
		}

		var submit = {
			hc: self.hc(),
			q: self.q()
		};
		app.ajax('/Lab/getIQA', submit).done(function (rs) {
			rs.forEach(r => {
				r.Answer = ko.observable(r.Answer == null ? null : r.Answer.toString());
			});
			self.listModel(rs);
			self.loaded(true);
		});
	};

	self.save = function () {
		var list = self.listModel().map(r => {
			return {
				Rec_ID: r.Rec_ID,
				Code_Facility_T: self.hc(),
				Q: self.q(),
				Statement_ID: r.Statement_ID,
				Answer: r.Answer(),
				Remark: r.Remark
			};
		});

		var submit = {
			list: JSON.stringify(list)
		};
		app.ajax('/Lab/saveIQA', submit).done(self.viewClick);
	};

	self.showNew = function () {
		self.newModel(app.ko({ Category: '', Statement: '' }));
		$('#modalNew').modal('show');
	};

	self.saveNew = function () {
		var model = self.newModel();
		var missing = false;

		if (model.Category.trim() == '') {
			app.showWarning(model.Category.element);
			missing = true;
		}
		if (model.Statement.trim() == '') {
			app.showWarning(model.Statement.element);
			missing = true;
		}
		if (missing) return;

		$('#modalNew').modal('hide');

		app.ajax('/Lab/newIQAStatement', app.unko(model)).done(self.viewClick);
	};

	self.getTotal = function () {
		var rs = self.listModel().filter(r => r.Answer() == 1).length;
		$('div.fixed-header .total').text(rs);
		return rs;
	};

	self.exportExcel = function () {
		if (self.pv() == null) {
			var submit = { year: self.year() };
			app.ajax('/Lab/getIQAExport', submit).done(function (rs) {
				rs.sortasc('Name_Prov_E', 'Name_OD_E', 'Name_Facility_E');
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
					'Q': r.Q,
					'Category': r.Category,
					'Statement': r.Statement,
					'Answer': r.Answer == null ? null : r.Answer == 1 ? 'Yes' : 'No',
					'Score': r.Answer,
					'Remark': r.Remark
				};
			});
			self.writeExcel(data, 'IQA');
		}
	};
}