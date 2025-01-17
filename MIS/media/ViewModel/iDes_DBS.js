function iDesDBS(root) {
	var self = this;

	self.listModel = ko.observableArray();
	self.pv = ko.observable();
	self.mf = ko.observable(moment().month(0));
	self.mt = ko.observable(moment());
	self.placeModel = ko.observable();

	var changedId = [];

	self.viewClick = function () {
		var submit = {
			prov: self.pv(),
			mf: self.mf().format('YYYYMM'),
			mt: self.mt().format('YYYYMM')
		};
		app.ajax('/iDes/getDBS', submit).done(function (rs) {
			var list = rs.groupby('Case_ID', 'Case_Type').map(g => {
				var obj = {
					Case_ID: g[0].Case_ID,
					Case_Type: g[0].Case_Type,
					DBS_Code: ko.observable(g[0].DBS_Code || ''),
					PatientName: g[0].NameK,
					days: ko.observableArray()
				};

				['0', '28', '42', '90', 'Other'].forEach(d => {
					var days = g.filter(r => r.Days == d);
					if (days.length > 0) {
						var item = {
							Days: ko.observable(d),
							DBS_Date: ko.observable(days[0].DBS_Date == '' ? null : moment(days[0].DBS_Date)),
							details: newDetail().map(a => {
								var v = days.find(r => r.Category == a.Category && r.Field == a.Field).Value;
								a.Value = ko.observable(!a.Field.contain('Date') ? v : moment(v));
								a.Value.subscribe(() => updateChange(obj));
								return a;
							})
						};
						obj.days.push(item);

						item.Days.subscribe(() => updateChange(obj));
						item.DBS_Date.subscribe(() => updateChange(obj));
					}
				});
				if (obj.days().length == 0) self.addDay(obj);

				obj.DBS_Code.subscribe(() => updateChange(obj));
				obj.days.subscribe(() => updateChange(obj));

				return obj;
			});

			self.listModel(list);
			changedId = [];
		});
	};

	function updateChange(model) {
		changedId.push(model.Case_Type + model.Case_ID);
	}

	self.addDay = function (obj) {
		var item = {
			Days: ko.observable(''),
			DBS_Date: ko.observable(null),
			details: newDetail().map(a => {
				a.Value = ko.observable('');
				a.Value.subscribe(() => updateChange(obj));
				return a;
			})
		};
		obj.days.push(item);

		item.Days.subscribe(() => updateChange(obj));
		item.DBS_Date.subscribe(() => updateChange(obj));
	};

	self.deleteDay = function (model, day) {
		if (model.days().length > 1) model.days.remove(day);
	};

    self.save = function() {
		if (changedId.length == 0) return;

		var list = [];
        var founds = self.listModel().filter(r => r.days().filter(d => d.Days() != '').length > 0);
		founds.forEach(a => {
			a.days().filter(r => r.Days() != '').forEach(b => {
				b.details.forEach(c => {
					list.push({
						Case_ID: a.Case_ID,
						Case_Type: a.Case_Type,
						DBS_Code: a.DBS_Code(),
						Days: b.Days(),
						DBS_Date: b.DBS_Date() == null ? '' : b.DBS_Date().sqlformat(),
						Category: c.Category,
                        Field: c.Field,
                        Value: c.Field.substring(0, 4) == 'Date' && c.Value() ? c.Value().sqlformat() : c.Value() || ''
					});
				});
			});
		});

		var submit = {
			list: JSON.stringify(list),
			changedId: changedId.distinct().join("','")
		};
		app.ajax('/iDes/saveDBS', submit).done(function () {
			changedId = [];
		});
	};

	self.choosePlace = function (value) {
		var obj = { pv: ko.observable(), od: ko.observable(), hc: ko.observable(), vl: ko.observable() };

		obj.pvList = root.place.pv;
		obj.odList = () => root.place.od.filter(r => r.pvcode == obj.pv());
		obj.hcList = () => root.place.hc.filter(r => r.odcode == obj.od());
		obj.vlList = () => root.place.vl.filter(r => r.hccode == obj.hc());

		if (value() != '') {
			var vlcode = value().length == 10 ? value() : null;
			console.log(vlcode);
			var hccode = value().length == 6 ? value() : (root.place.vl.find(r => r.code == vlcode) || {}).hccode;
			var odcode = (root.place.hc.find(r => r.code == hccode) || {}).odcode;
			var pvcode = (root.place.od.find(r => r.code == odcode) || {}).pvcode;

			obj.pv(pvcode);
			obj.od(odcode);
			obj.hc(hccode);
			obj.vl(vlcode);
		}

		obj.ok = function () {
			if (obj.pv() == null) value('');
			else {
				var missing = false;
				if (obj.od() == null) {
					app.showWarning(obj.od.element);
					missing = true;
				}
				if (obj.hc() == null) {
					app.showWarning(obj.hc.element);
					missing = true;
				}
				if (missing) return;
				value(obj.vl() == null ? obj.hc() : obj.vl());
			}

			$('#modalPlace').modal('hide');
		};

		self.placeModel(obj);
		$('#modalPlace').modal('show');
	};

	self.getPlaceName = function (code) {
		if (code.length == 6) {
			var found = root.place.hc.find(r => r.code == code);
			return found == null ? '' : found.name;
		}
		if (code.length == 10) {
			var found = root.place.vl.find(r => r.code == code);
			console.log(found, code);
			return found == null ? '' : found.name;
		}
		return '';
	};

	function newDetail() {
		return [
			{ Category: 'One Slide', Field: 'Name of Submission' },
			{ Category: 'One Slide', Field: 'Date of Submission' },
			{ Category: 'One Slide', Field: 'Name of Recipient' },
			{ Category: 'One Slide', Field: 'Date of Recipeint' },
			{ Category: 'One Slide', Field: 'Remarks of Recipient' },
			{ Category: 'One Slide', Field: 'Name of Microscopist Reading the slide' },
			{ Category: 'One Slide', Field: 'Date of Reading' },
			{ Category: 'One Slide', Field: 'Reading Results' },
			{ Category: 'One Slide', Field: 'Remakrs of Microscopist' },
			{ Category: 'Two DBS', Field: 'Name of Submission' },
			{ Category: 'Two DBS', Field: 'Date of Submission' },
			{ Category: 'Two DBS', Field: 'Name of Recipient' },
			{ Category: 'Two DBS', Field: 'Date of Recipeint' },
			{ Category: 'Two DBS', Field: 'Remarks of Recipient' },
			{ Category: 'Two DBS', Field: 'Name of Lab technician conducting PCR' },
			{ Category: 'Two DBS', Field: 'Date of PCR' },
			{ Category: 'Two DBS', Field: 'PCR Results' },
			{ Category: 'Two DBS', Field: 'Remakrs of Lab Technician' }
		];
	}
}