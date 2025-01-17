function viewModel() {
	var self = this;

	self.model = ko.observable();
	self.listModel = ko.observableArray();
	self.hcList = ko.observableArray();
	self.referredFrom = ko.observable();
	
	var newModel = {
		Family_Name: '',
		Given_Name: '',
		Name_Vill_E: '',
		Name_Facility_E: '',
		Name_OD_E: '',
		Name_Prov_E: '',
	};
	var caseid = '';
	var ready = true;
	var lastReferred = null;
	var lastReason = null;
	var place = null;

	self.showDetail = function (model, submit) {
		if (model != null) submit = { id: model.Id };
		
		app.ajax('/CaseReport/getInvestigation/', submit).done(function (rs) {
			if (model == null) {
				rs.model.forEach(r => newModel[r] = '');
				self.listModel(rs.list);
			}

			if (rs.detail == null) {
				self.model(newModel);
				lastReferred = rs.referredFrom;
				ready = false;
				self.referredFrom(rs.referredFrom);
				ready = true;
				return;
			}
			
			var format = 'DD/MM/YY';
			var d = rs.detail;
			d.Date_Nof = isnot(d.Date_Nof, null, r => moment(r).format(format));
			d.Dob = isnot(d.Dob, null, r => moment(r).format(format));
			d.Date_Of_Invest = isnot(d.Date_Of_Invest, null, r => moment(r).format(format));
			d.Date_Of_Diagnosis = isnot(d.Date_Of_Diagnosis, null, r => moment(r).format(format));
			d.Date_Of_First_Symtom = isnot(d.Date_Of_First_Symtom, null, r => moment(r).format(format));
			d.Date_Last_Treatment = isnot(d.Date_Last_Treatment, null, r => moment(r).format(format));
			
			var name = d.Name_K.split(' ');
			if (name.length > 1) {
				d.Family_Name = name[0];
				d.Given_Name = name.slice(1).join(' ');
			} else {
				d.Family_Name = '';
				d.Given_Name = d.Name_K;
			}

			d.Longitude = parseFloat(d.Longitude).toFixed(4);
			d.Latitude = parseFloat(d.Latitude).toFixed(4);

			d.people_living = parseInt(d.People_Living_With_Lth_5Y) + parseInt(d.People_Living_With_5_To_15Y) + parseInt(d.People_Living_With_Gth_15Y);
			self.model(d);
		});
	};

	app.getPlace(['pv', 'hc', 'vl'], function (p) {
		place = p;
		var arr = location.pathname.split('/');
		self.hcList(place.hc.filter(r => r.odcode == arr.last()));
		caseid = arr[arr.length - 2];
		var submit = { caseid: caseid };
		self.showDetail(null, submit);
	});

	self.deleteCase = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblInvestigationCases',
				where: { Id: model.Id }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
				if (model.Id == self.model().Id) self.model(newModel);
			});
		});
	};

	self.changeReferredFrom = function (model) {
		if (!ready) return;

		var v = is(self.referredFrom(), undefined, null);
		var submit = {
			table: 'tblHFActivityCases',
			value: { ReferredFrom: v },
			where: { Rec_ID: caseid.split('_')[0] }
		};
		submit = { submit: JSON.stringify(submit) };
		
		app.ajax('/Direct/update', submit).done(function () {
			lastReferred = v;
		}).fail(function () {
			ready = false;
			self.referredFrom(lastReferred);
			ready = true;
		});
	};

	self.changeReason = function (model) {
		if (!ready) return;

		var v = isempty(model.IncompleteReason(), null);
		var submit = {
			table: 'tblInvestigationCases',
			value: { IncompleteReason: v },
			where: { Id: model.Id }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			lastReason = v;
		}).fail(function () {
			ready = false;
			model.IncompleteReason(lastReason);
			ready = true;
		});
	};

	self.getPVName = function (code) {
		var found = place.pv.find(r => r.code == code);
		return found == null ? code : found.name;
	};

	self.getVLName = function (code) {
		var found = place.vl.find(r => r.code == code);
		return found == null ? code : found.name;
	};
}