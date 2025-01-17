function subViewModel(self) {
	self.reportList = ko.observableArray();
	self.listModel = ko.observableArray();
	self.itemList = ko.observableArray();

	self.year = ko.observable(moment());

	self.view = ko.observable('list');
	self.head = ko.observable({});
	self.loaded = ko.observable(false);

	self.prepare = function () {
		if (app.user.prov == '') self.pvList.unshift({ code: 'CNM', name: 'CNM' });
		self.pv.subscribe(() => self.loaded(false));
		self.od.subscribe(() => self.loaded(false));
		self.hc.subscribe(() => self.loaded(false));
		self.year.subscribe(() => self.loaded(false));
	};

	self.viewClick = function () {
		if (self.pv() != 'CNM' && self.hc() == null) {
			self.loaded(false);
			return;
		}

		var submit = {
			hc: self.pv() == 'CNM' ? 'CNM' : self.hc(),
			year: self.year().year()
		};
		app.ajax('/Lab/getStock', submit).done(function (rs) {
			rs.forEach(r => r.Has = ko.observable(r.Has));
			self.reportList(rs);
			self.loaded(true);
		});
	}

	self.showManage = function () {
		var submit = { hc: self.pv() == 'CNM' ? 'CNM' : self.hc() };

		app.ajax('/Lab/getStockItem', submit).done(function (rs) {
			rs.forEach(r => r.ItemName = ko.observable(r.ItemName));
			self.itemList(rs);
			if (self.itemList().length == 0) self.addItem();
			$('#modalManage').modal('show');
		});
	};

	self.addItem = function () {
		var item = {
			Item_ID: 0,
			ItemName: ko.observable(''),
			Code_Facility_T: self.pv() == 'CNM' ? 'CNM' : self.hc()
		};
		self.itemList.push(item);
	};

	self.deleteItem = function (model) {
		if (model.Item_ID == 0) self.itemList.remove(model);
		else {
			$('#modalManage').modal('hide');

			$('#modalDelete .btn-default').off().one('click', function () {
				setTimeout(() => $('#modalManage').modal('show'));
			});

			app.showDelete(function () {
				$('#modalDelete .btn-default').off();

				var submit = { id: model.Item_ID };
				app.ajax('/Lab/deleteStockItem', submit).done(function (error) {
					if (error) {
						app.showMsg('Cannot delete this item', 'This item is linked with some data.', true);
						$('#modalMessage .btn').one('click', function () {
							setTimeout(() => $('#modalManage').modal('show'));
						});
					} else {
						self.itemList.remove(model);
						$('#modalManage').modal('show');
					}
				});
			});
		}
	};

	self.saveItem = function () {
		if (self.itemList().length == 0) return;

		var missing = false;

		self.itemList().forEach(r => {
			if (r.ItemName() == '') {
				self.showWarning(r.ItemName);
				missing = true;
			}
		});
		if (missing) return;

		$('#modalManage').modal('hide');

		var submit = {
			list: self.itemList().map(app.unko)
		};
		app.ajax('/Lab/saveStockItem', submit).done(function () {
			if (self.reportList().length == 0) getData();
		});
	};

	self.closeManage = function () {
		if (self.itemList().length == 0 && self.reportList().length > 0) self.reportList([]);
	};

	self.showDetail = function (model) {
		var submit = {
			hc: self.pv() == 'CNM' ? 'CNM' : self.hc(),
			year: self.year().year(),
			month: model.Month,
			has: model.Has()
		};
		self.head(submit);

		app.ajax('/Lab/getStockDetail', submit).done(function (rs) {
			rs.forEach(r => {
				r.StockStart = r.StockStart || 0;
				r.StockIn = ko.observable(r.StockIn);
				r.StockOut = ko.observable(r.StockOut);
				r.Adjustment = ko.observable(r.Adjustment);
				r.Balance = ko.computed(() => toFloat(r.StockStart) + toFloat(r.StockIn()) - toFloat(r.StockOut()) + toFloat(r.Adjustment()));
			});

			self.listModel(rs);
			self.view('detail');

			rs.forEach(r => {
				app.setNumberOnly(r.StockIn.element, 'int');
				app.setNumberOnly(r.StockOut.element, 'int');
				app.setNumberOnly(r.Adjustment.element, 'int', true);
			});
		});
	};

	self.getHCName = function () {
		return self.pv() == 'CNM' ? 'CNM'
			: self.hc() != null ? self.place.hc.find(r => r.code == self.hc()).name
			: '';
	};

	self.saveStock = function () {
		if (self.listModel().some(r => r.Balance() < 0)) {
			app.showMsg('<kh>តុល្យាការមិនអាចតូចជាងសូន្យ</kh>', '<kh>សូមបញ្ចូលទិន្ន័យអោយបានត្រឹមត្រូវ</kh>');
			return;
		}

		var submit = {
			where: {
				Code_Facility_T: self.head().hc,
				Year: self.head().year,
				Month: self.head().month
			},
			list: self.listModel().map(r => {
				return {
					Code_Facility_T: self.head().hc,
					Year: self.head().year,
					Month: self.head().month,
					Item_ID: r.Item_ID,
					StockStart: toFloat(r.StockStart),
					StockIn: toFloat(r.StockIn()),
					StockOut: toFloat(r.StockOut()),
					Adjustment: toFloat(r.Adjustment()),
					Balance: r.Balance()
				};
			})
		};

		app.ajax('/Lab/saveStock', submit).done(function () {
			self.reportList().find(r => r.Month == self.head().month).Has(1);
			self.back();
		});
	};

	self.deleteStock = function () {
		app.showDelete(function () {
			var submit = {
				where: {
					Code_Facility_T: self.head().hc,
					Year: self.head().year,
					Month: self.head().month
				}
			}
			app.ajax('/Lab/deleteStock', submit).done(function () {
				self.reportList().find(r => r.Month == self.head().month).Has(0);
				self.back();
			});
		});
	};

	self.back = function () {
		self.view('list');
	};

	self.exportExcel = function () {
		var submit = {
			hc: self.pv() == 'CNM' ? 'CNM' : self.hc(),
			year: self.year().year()
		};
		app.ajax('/Lab/getStockExport', submit).done(function (rs) {
			self.writeExcel(rs, 'Stock');
		});
	};

	self.exportExcel = function () {
		var submit = {
			hc: self.hc() || self.pv(),
			year: self.year().year()
		};
		app.ajax('/Lab/getStockExport', submit).done(function (rs) {
			self.writeExcel(rs, 'Stock');
		});
	};
}