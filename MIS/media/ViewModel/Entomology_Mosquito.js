function viewModel() {
	var self = this;

	self.collectionTimes = [16, 17, 18, 19, 20, 21, 22, 23, 0, 1, 2, 3, 4, 5];
	self.listModel = ko.observableArray();
	self.editModel = ko.observable();
	self.detailModel = ko.observable();
	self.view = ko.observable('list');

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.ds = ko.observable();
	self.cm = ko.observable();
	self.vl = ko.observable();

	var place = null;
	var fieldData = [];
	var lastScrollY = 0;

	app.getPlace(['pv', 'ds', 'cm', 'vl'], function (p) {
		place = p;
		self.pvList(app.user.prov == '' ? place.pv : place.pv.filter(r => app.user.prov.contain(r.code)));

		app.ajax('/Entomology/getMosquitoList').done(function (rs) {
			fieldData = rs.fieldData;
			self.listModel(rs.list);
		});
	});

	self.getListModel = function () {
		var list = self.listModel();

		if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());
		if (self.ds() != null) list = list.filter(r => r.Code_Dist_T == self.ds());
		if (self.cm() != null) list = list.filter(r => r.Code_Comm_T == self.cm());
		if (self.vl() != null) list = list.filter(r => r.Code_Vill_T == self.vl());

		return list;
	};

	self.showNew = function () {
		var model = {};
		fieldData.forEach(r => model[r.name] = null);

		model.Code_Prov_T = null;
		model.Code_Dist_T = null;
		model.Code_Comm_T = null;

		model.SurroundingEnvironment = [];
		model.NetBrand = [];
		model.NetBrandList = [];

		self.showEdit(model);
	};

	self.showEdit = function (model) {
		lastScrollY = window.scrollY;

		if (model.Rec_ID == null) {
			prepare([]);
		} else {
			var submit = { ParentId: model.Rec_ID };
			app.ajax('/Entomology/getMosquitoDetail', submit).done(prepare);
		}

		function prepare(details) {
			model = app.ko(model);

			model.pvList = ko.observable(place.pv);
			model.dsList = () => model.Code_Prov_T() == null ? [] : place.ds.filter(r => r.pvcode == model.Code_Prov_T());
			model.cmList = () => model.Code_Dist_T() == null ? [] : place.cm.filter(r => r.dscode == model.Code_Dist_T());
			model.vlList = () => model.Code_Comm_T() == null ? [] : place.vl.filter(r => r.cmcode == model.Code_Comm_T());

			if (model.StartTime() != null) model.StartTime(moment(model.StartTime(), 'HH:mm'));
			if (model.EndTime() != null) model.EndTime(moment(model.EndTime(), 'HH:mm'));

			var d = {
				head: ko.observableArray(),
				body: [],
				total: { values: ko.observableArray(), female: ko.observable(null) },
				UF: ko.observableArray(),
				F: ko.observableArray(),
				HG: ko.observableArray(),
				G: ko.observableArray()
			};

			if (details.length == 0) {
				var qty = 6;
				d.head(Array.repeat(qty, newValue));
				d.total.values(Array.repeat(qty, newValue));
				d.UF(Array.repeat(qty, newValue));
				d.F(Array.repeat(qty, newValue));
				d.HG(Array.repeat(qty, newValue));
				d.G(Array.repeat(qty, newValue));

				self.collectionTimes.forEach(r => {
					d.body.push({
						time: getTime(r),
						values: ko.observableArray(Array.repeat(qty, newValue)),
						female: ko.observable(null)
					});
				});
			} else {
				details.sortasc(r => is(r.ColumnIndex, 'Female', 99).toFloat());

				details.filter(r => r.Section == 'Head').forEach(r => d.head.push(oldValue(r.Value)));
				details.filter(r => r.Section == 'Body').groupby('CollectionTime').forEach(r => {
					d.body.push({
						time: r[0].CollectionTime,
						values: ko.observableArray(r.filter(a => a.ColumnIndex != 'Female').map(a => oldValue(a.Value))),
						female: ko.observable(r.find(a => a.ColumnIndex == 'Female').Value)
					});
				});
				var founds = details.filter(r => r.Section == 'Total' && r.ColumnIndex != 'Female');
				d.total.values(founds.map(r => oldValue(r.Value)));

				var found = details.find(r => r.Section == 'Total' && r.ColumnIndex == 'Female');
				d.total.female(found.Value);

				var founds = details.filter(r => r.Section == 'UF');
				d.UF(founds.map(r => oldValue(r.Value)));

				var founds = details.filter(r => r.Section == 'F');
				d.F(founds.map(r => oldValue(r.Value)));

				var founds = details.filter(r => r.Section == 'HG');
				d.HG(founds.map(r => oldValue(r.Value)));

				var founds = details.filter(r => r.Section == 'G');
				d.G(founds.map(r => oldValue(r.Value)));
			}

			if (typeof model.SurroundingEnvironment() == 'string') {
				model.SurroundingEnvironment(model.SurroundingEnvironment().split(',').filter(r => r != ''));
			}
			if (typeof model.NetBrand() == 'string') {
				model.NetBrand(model.NetBrand().split(',').filter(r => r != ''));
			}
			if (typeof model.NetBrandList() == 'string') {
				model.NetBrandList(JSON.parse(model.NetBrandList()));
			}

			model.NetBrand.subscribe(function (arr) {
				var temp = {};
				model.NetBrandList().forEach(r => temp[r.brand] = r.qty);

				model.NetBrandList(arr.map(b => {
					return { brand: b, qty: temp[b] || '' };
				}));

				$('input[numonly]').each(function () {
					app.setNumberOnly(this, $(this).attr('numonly'));
				});
			});

			self.editModel(model);
			self.detailModel(d);
			self.view('edit');
			window.scrollTo(0, 0);

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		}
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblEntomologyMosquito',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

            logDelete(submit);

            setTimeout(() => {
                app.ajax('/Direct/delete', submit).done(function() {
                    self.listModel.remove(model);
                });
            }, 300);
		});
    };

    function logDelete(submit) {
        app.ajax('/Entomology/logDelete', submit).done(function () { })
    }

	self.save = function () {
		var model = self.editModel();
		var d = self.detailModel();

		if (model.Institution() == 'Other' && isnone(model.InstitutionOther())) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Institution Completing Collection');
			return;
		}
		if (isnone(model.CompletingPerson())) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Name of Person Completing Form');
			return;
		}
		if (model.CollectionDate() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Date of Mosquito Collection');
			return;
		}
		if (model.Code_Prov_T() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Province');
			return;
		}
		if (model.Code_Dist_T() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'District');
			return;
		}
		if (model.Code_Comm_T() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Commune');
			return;
		}
		if (model.Code_Vill_T() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Village');
			return;
		}
		if (model.Site() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Sentinel Site');
			return;
		}
		if (!isnone(model.Lat()) && model.Lat().toString().length != 8) {
			window.scrollTo(0, 0);
			app.showMsg('Incorrect Format', 'Latitude format: XX.XXXXX');
			return;
		}
		if (!isnone(model.Long()) && model.Long().toString().length != 9) {
			window.scrollTo(0, 0);
			app.showMsg('Incorrect Format', 'Longitude format: XXX.XXXXX');
			return;
		}

		for (var i = 0; i < d.total.values().length; i++) {
			if (self.checkEqualTotal(i) == 'red') {
				app.showMsg('Incorrect Data', 'Unfed + Fed + Half Gravid + Gravid ≠ Total');
				return;
			}
		}

		model = app.unko(model);
		model.CollectionDate = model.CollectionDate.sqlformat();
		model.StartTime = model.StartTime == null ? null : model.StartTime.format('HH:mm');
		model.EndTime = model.EndTime == null ? null : model.EndTime.format('HH:mm');

		model.SurroundingEnvironment = model.SurroundingEnvironment.join(',');
		model.NetBrand = model.NetBrand.join(',');
		model.NetBrandList = JSON.stringify(model.NetBrandList);

		if (model.Institution != 'Other') model.InstitutionOther = null;
		if (!model.SurroundingEnvironment.contain('Other')) model.SurroundingEnvironmentOther = null;
		if (model.RoofType != 'Other') model.RoofTypeOther = null;
		if (model.WallType != 'Other') model.WallTypeOther = null;
		if (!model.NetBrand.contain('Other')) model.NetBrandOther = null;

		var names = [];
		for (var r of fieldData) {
			names.push(r.name);

			if (r.type.in('int', 'float')) model[r.name] = isempty(model[r.name], null);
		}

		for (var key in model) {
			if (!names.contain(key)) delete model[key];
		}

		delete model.InitTime;
		delete model.InitUser;
		delete model.ModiTime;
		delete model.ModiUser;

		if (model.Rec_ID == null) {
			model.InitUser = app.user.username;
		} else {
			model.ModiUser = app.user.username;
			model.ModiTime = moment().sqlformat('datetime');
		}

		var details = [];

		d.head().forEach((r, i) => {
			details.push({ Section: 'Head', ColumnIndex: i, Value: r.value() });
		});

		d.body.forEach(b => {
			b.values().forEach((r, i) => {
				details.push({
					Section: 'Body',
					CollectionTime: b.time,
					ColumnIndex: i,
					Value: model.CollectionType == 'Hourly Collection' ? r.value() : null
				});
			});
			details.push({
				Section: 'Body',
				CollectionTime: b.time,
				ColumnIndex: 'Female',
				Value: model.CollectionType == 'Hourly Collection' ? b.female() : null
			});
		});

		d.total.values().forEach((r, i) => {
			details.push({
				Section: 'Total',
				ColumnIndex: i,
				Value: model.CollectionType == 'Non-hourly Collection' ? r.value() : null
			});
		});
		details.push({
			Section: 'Total',
			ColumnIndex: 'Female',
			Value: model.CollectionType == 'Non-hourly Collection' ? d.total.female() : null
		});

		['UF', 'F', 'HG', 'G'].forEach(k => {
			d[k]().forEach((r, i) => {
				details.push({
					Section: k,
					ColumnIndex: i,
					Value: model.CollectionMethod == 'CDC-LT with human attractant' ? r.value() : null
				});
			});
		});

		var submit = {
			master: JSON.stringify(model),
			details: JSON.stringify(details)
		};

		app.ajax('/Entomology/saveMosquito', submit).done(function (rs) {
			if (model.Rec_ID == null) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
				self.listModel.replace(old, rs);
			}

			self.back();
		});
	};

	self.back = function () {
		self.view('list');
		window.scrollTo(0, lastScrollY);
	};

	self.addColumn = function () {
		var detail = self.detailModel();
		detail.body.forEach(r => r.values.push(newValue()));
		detail.head.push(newValue());
		detail.total.values.push(newValue());
		detail.UF.push(newValue());
		detail.F.push(newValue());
		detail.HG.push(newValue());
		detail.G.push(newValue());

		$('input[numonly]').each(function () {
			app.setNumberOnly(this, $(this).attr('numonly'));
		});
	};

	self.removeColumn = function (obj) {
		var detail = self.detailModel();
		var i = detail.head.indexOf(obj);

		detail.head.remove(obj);
		detail.total.values.splice(i, 1);
		detail.UF.splice(i, 1);
		detail.F.splice(i, 1);
		detail.HG.splice(i, 1);
		detail.G.splice(i, 1);
		detail.body.forEach(r => r.values.splice(i, 1));
	};

	function newValue() {
		return { value: ko.observable(null) };
	}

	function oldValue(value) {
		return { value: ko.observable(value) };
	}

	function getTime(hour) {
		var end = hour == 23 ? 0 : hour + 1;
		return ('0' + hour).substr(-2) + ':00-' + ('0' + end).substr(-2) + ':00';
	}

	self.sumDetail = function (name) {
		var body = self.detailModel().body;

		if (name == 'female') {
			if (body.every(r => isnone(r[name]()))) return '';
			return body.sum(r => isnone(r[name](), 0).toFloat());
		}

		if (body.every(r => isnone(r.values()[name].value()))) return '';
		return body.sum(r => isnone(r.values()[name].value(), 0).toFloat());
	};

	self.sumAnophelesFemale = function () {
		var detail = self.detailModel();
		if (detail == null) return;

		if (self.editModel().CollectionType() == 'Non-hourly Collection') {
			return detail.total.values().sum(r => (r.value() || 0).toFloat());
		}

		var total = 0;
		detail.head().forEach((r, i) => total += self.sumDetail(i).toFloat());
		return total;
	};

	self.sumCulicineFemale = function () {
		var detail = self.detailModel();
		if (detail == null) return;

		var result = self.editModel().CollectionType() == 'Non-hourly Collection' ? detail.total.female() : self.sumDetail('female');
		return result || 0;
	};

	self.getPVName = function (code) {
		return code == null ? '' : place.pv.find(r => r.code == code).name;
	};

	self.getDSName = function (code) {
		return code == null ? '' : place.ds.find(r => r.code == code).name;
	};

	self.getCMName = function (code) {
		return code == null ? '' : place.cm.find(r => r.code == code).name;
	};

	self.getVLName = function (code) {
		return code == null ? '' : place.vl.find(r => r.code == code).name;
	};

	self.dsList = function () {
		return self.pv() == null ? [] : place.ds.filter(r => r.pvcode == self.pv());
	};

	self.cmList = function () {
		return self.ds() == null ? [] : place.cm.filter(r => r.dscode == self.ds());
	};

	self.vlList = function () {
		return self.cm() == null ? [] : place.vl.filter(r => r.cmcode == self.cm());
	};

	self.letterOnly = function (model, event) {
		var code = event.keyCode;
		return (code > 64 && code < 91) || (code > 96 && code < 123) || [8, 9, 32].contain(code);
	};

	self.latOnly = function (model, event) {
		var key = event.key;
		var code = event.keyCode;
		var len = event.currentTarget.value.length;

		if (code == 8 || code == 9) return true;
		if (len == 2) return key == '.';
		return key >= 0 && key <= 9;
	};

	self.longOnly = function (model, event) {
		var key = event.key;
		var code = event.keyCode;
		var len = event.currentTarget.value.length;

		if (code == 8 || code == 9) return true;
		if (len == 3) return key == '.';
		return key >= 0 && key <= 9;
	};

	self.only60 = function (model, event) {
		if (event.keyCode == 8 || event.keyCode == 9) return true;
		return event.currentTarget.value + event.key <= 60;
	};

	self.checkEqualTotal = function (index) {
		if (self.editModel().CollectionMethod() != 'CDC-LT with human attractant') return '';

		var detail = self.detailModel();
		if (detail.total.values().length < index + 1) return '';

		var total = (detail.total.values()[index].value() || 0).toFloat();
		total += (self.sumDetail(index) || 0).toFloat();

		var result = ['UF', 'F', 'HG', 'G'].sum(r => {
			var found = detail[r]()[index];
			return found == null ? 0 : (found.value() || 0).toFloat();
		});
		
		return total == result ? '' : 'red';
	};

	self.mosquitoList = function (index) {
		var list = [
			'An. aconitus',
			'An. annularis',
			'An. argyropus',
			'An. baimaii',
			'An. barbirostris',
			'An. barbirostris (a, b, and c)',
			'An. campestris',
			'An. crawfordi',
			'An. dirus s.l.',
			'An. hyrcanus grp',
			'An. indefinitus',
			'An. interruptus',
			'An. jamesii',
			'An. karwari',
			'An. kochi',
			'An. maculatus s.l.',
			'An. minimus s.l.',
			'An. nigerrimus',
			'An. nitidus',
			'An. nivipes',
			'An. notanandai',
			'An. pampanai',
			'An. peditaeniatus',
			'An. philippinensis',
			'An. pseudojamesi',
			'An. pursati',
			'An. sawadwongporni s.l.',
			'An. sinensis',
			'An. splendidus',
			'An. subpictus',
			'An. tessellatus',
			'An. umbrosis',
			'An. vagus',
			'An. varuna',
			'An. willmori',

			'An. Cellia',
			'Aubgenus Cellia',
			'Anularis Group',
			'Barbirostris Group',
			'Funestus Group',
			'Hyrcanus Group',
			'Jamesii Group',
			'Leucosphyrus Group',
			'Maculatus Group',
			'Sawadwongporni Subgroup',
			'Subgenus Anopheles',
			'Subgenus Cellia'
		];

		var arr = [];
		self.detailModel().head().forEach((r, i) => {
			if (i != index && r.value() != null) arr.push(r.value());
		});

		return list.filter(r => !arr.contain(r));
	};
}