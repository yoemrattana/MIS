function viewModel() {
	var self = this;

	self.headModel = ko.observable();
	self.listModel = ko.observableArray([]);

	var caseid = location.pathname.split('/').last();
	var place = null;

	for (var i = 0; i < 5; i++) {
		newRow();
	}

	setTimeout(function () {
		$('input[numonly]').each(function () {
			app.setNumberOnly(el, 'int');
		});
	});

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
		place = p;

		app.ajax('/Reactive/getData2/' + caseid).done(function (rs) {
			var head = {
				DateCase: ko.observable(moment(rs.head.DateCase)),
				PatientCode: ko.observable(rs.head.PatientCode),
				PatientName: ko.observable(rs.head.NameK),
				PatientIDCard: ko.observable(),
				PatientPhone: ko.observable(rs.head.PatientPhone),
				PatientAge: ko.observable(rs.head.Age),
				PatientSex: ko.observable(rs.head.Sex),
				Lat: ko.observable(),
				Long: ko.observable(),
				Code_Vill_T: rs.head.ID.length == 10 ? rs.head.ID : rs.head.Code_Vill_t,
				ForestSleep: ko.observable(),
				ForestSleepOther: ko.observable(),
				Workplace: ko.observable(),
				WorkplaceOther: ko.observable(),
				Shelter: ko.observable(),
				Bednet: ko.observable(),
				InvestigationDate: ko.observable(null),
				Investigator: ko.observable(''),
				InvestigatorJob: ko.observable(''),
				InvestigatorPhone: ko.observable(''),
				Classify: ko.observable(rs.head.L1 == 1 ? 'L1' : rs.head.LC == 1 ? 'LC' : rs.head.IMP == 1 ? 'IMP' : null)
			};

			if (rs.list.length > 0) {
				var obj = rs.list[0];
				head.DateCase(moment(obj.DateCase)),
				head.PatientCode(obj.PatientCode),
				head.PatientName(obj.PatientName),
				head.PatientIDCard(obj.PatientIDCard),
				head.PatientPhone(obj.PatientPhone),
				head.PatientAge(obj.PatientAge),
				head.PatientSex(obj.PatientSex),
				head.Lat(obj.Lat);
				head.Long(obj.Long);
				head.ForestSleep(obj.ForestSleep);
				head.ForestSleepOther(obj.ForestSleepOther);
				head.Workplace(obj.Workplace);
				head.WorkplaceOther(obj.WorkplaceOther);
				head.Shelter(obj.Shelter);
				head.Bednet(obj.Bednet);
				head.InvestigationDate(isnot(obj.InvestigationDate, null, r => moment(r))),
				head.Investigator(obj.Investigator);
				head.InvestigatorJob(obj.InvestigatorJob);
				head.InvestigatorPhone(obj.InvestigatorPhone);
				head.Classify(obj.Classify);

				self.listModel(rs.list.map(r => app.ko(r)));
				self.listModel().forEach(r => {
					r.Missing.oldValue = r.Missing();
					app.setNumberOnly(r.HouseNumber.element, 'int');
				});
			}

			self.headModel(head);

			app.setNumberOnly(head.PatientIDCard.element, 'int');
			app.setNumberOnly(head.PatientAge.element, 'int');
			app.setNumberOnly(head.Lat.element, 'float');
			app.setNumberOnly(head.Long.element, 'float');
		});
	});

	function newRow() {
		var obj = app.ko({
			HouseNumber: '',
			Member: '',
			Age: '',
			Sex: null,
			Missing: null,
			Diagnosis: null,
			Treatment: null,
			TreatmentOther: null,
			Fever: false,
			Forest: false,
			Travel: false,
			History: false,
			Relative: false
		});
		self.listModel.push(obj);
		app.setNumberOnly(obj.HouseNumber.element, 'int');
	}

	self.addMore = function () {
		newRow();
	};

	self.remove = function (model) {
		self.listModel.remove(model);
	};

	self.save = function () {
		var model = self.headModel();
		var missing = false;

		var arr = ['ForestSleep', 'Workplace', 'Shelter', 'Bednet', 'Classify'];
		arr.forEach(name => {
			var item = model[name];
			if (item() == null) {
				function check(value) {
					var e = $(item.element).closest('p').find('kh').first();
					e.css('color', value == null ? 'red' : '');
				}
				check(item());

				if (item.hasEvent !== true) {
					item.subscribe(check);
					item.hasEvent = true;
				}
				missing = true;
			}
		});

		var arr = ['InvestigationDate', 'Investigator', 'InvestigatorJob', 'InvestigatorPhone'];
		arr.forEach(name => {
			var item = model[name];

			function check(value) {
				$(item.element).css('border-color', value == '' ? 'red' : '');
			}
			check(trim(item()));

			if (item.hasEvent !== true) {
				item.subscribe(check);
				item.hasEvent = true;
			}
			if (trim(item()) == '') missing = true;
		});


		var arr = ['Member', 'Age', 'Sex'];
		self.listModel().forEach(row => {
			arr.forEach(name => {
				var item = row[name];

				function check(value) {
					$(item.element).css('border-color', value == '' ? 'red' : '');
				}
				check(trim(item()));

				if (item.hasEvent !== true) {
					item.subscribe(check);
					item.hasEvent = true;
				}
				if (trim(item()) == '') missing = true;
			});
		});

		if (missing) {
			app.showMsg('<kh>ខ្វះទិន្នន័យ</kh>', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh>');
			return;
		}

		var list = self.listModel().map(r => {
			return {
				Passive_Case_Id: caseid,
				DateCase: model.DateCase().format('YYYY-MM-DD'),
				PatientCode: trim(model.PatientCode()),
				PatientName: trim(model.PatientName()),
				PatientIDCard: trim(model.PatientIDCard()),
				PatientPhone: trim(model.PatientPhone()),
				PatientAge: model.PatientAge(),
				PatientSex: model.PatientSex(),
				Lat: isempty(trim(model.Lat()), null),
				Long: isempty(trim(model.Long()), null),
				Code_Vill_T: model.Code_Vill_T,
				ForestSleep: model.ForestSleep(),
				ForestSleepOther: model.ForestSleep() == 'Other' ? trim(model.ForestSleepOther()) : null,
				Workplace: model.Workplace(),
				WorkplaceOther: model.Workplace() == 'Other' ? trim(model.WorkplaceOther()) : null,
				Shelter: model.Shelter(),
				Bednet: model.Bednet(),
				InvestigationDate: model.InvestigationDate().format('YYYY-MM-DD'),
				Investigator: trim(model.Investigator()),
				InvestigatorJob: trim(model.InvestigatorJob()),
				InvestigatorPhone: trim(model.InvestigatorPhone()),
				Classify: model.Classify(),
				HouseNumber: isempty(r.HouseNumber(), null),
				Member: trim(r.Member()),
				Age: r.Age(),
				Sex: r.Sex(),
				Missing: r.Missing(),
				Diagnosis: isempty(r.Diagnosis(), null),
				Treatment: isempty(r.Treatment(), null),
				TreatmentOther: r.TreatmentOther(),
				Fever: r.Fever() ? 1 : 0,
				Forest: r.Forest() ? 1 : 0,
				Travel: r.Travel() ? 1 : 0,
				History: r.History() ? 1 : 0,
				Relative: r.Relative() ? 1 : 0,
			};
		});

		var submit = {
			id: caseid,
			list: JSON.stringify(list)
		};
		app.ajax('/Reactive/save2', submit);
	};

	self.showDelete = function () {
		app.showDelete(function () {
			var submit = {
				table: 'tblReactive2',
				where: { Passive_Case_Id: caseid }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				window.close();
			});
		});
	};

	self.getVLName = function (vlcode) {
		var vl = place.vl.find(r => r.code == vlcode);
		return vl == null ? '' : vl.nameK;
	};

	self.getHCName = function (vlcode) {
		var vl = place.vl.find(r => r.code == vlcode);
		if (vl == null) return '';
		return place.hc.find(r => r.code == vl.hccode).nameK;
	};

	self.getODName = function (vlcode) {
		var vl = place.vl.find(r => r.code == vlcode);
		if (vl == null) return '';
		var hc = place.hc.find(r => r.code == vl.hccode);
		return place.od.find(r => r.code == hc.odcode).nameK;
	};

	self.getPVName = function (vlcode) {
		var vl = place.vl.find(r => r.code == vlcode);
		if (vl == null) return '';
		var hc = place.hc.find(r => r.code == vl.hccode);
		var od = place.od.find(r => r.code == hc.odcode);
		return place.pv.find(r => r.code == od.pvcode).nameK;
	};

	self.missingClick = function (model) {
		if (model.Missing() == model.Missing.oldValue) model.Missing(null);
		model.Missing.oldValue = model.Missing();
		return true;
	};
}