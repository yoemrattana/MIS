function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.addModel = ko.observable();
	self.tab = ko.observable('Treatment');
	self.specie = ko.observable();
	self.species = [{ key: 'F', val: 'PF' }, { key: 'V', val: 'PV' }, { key: 'M', val: 'Mix' }];
	self.treatmentSpecies = ko.observableArray();

	var treatmentSpecies = [];
	var treatements = [];

	app.ajax('/Treatment/get').done(function (rs) {
	    treatements = rs.treatment;
	    treatements.forEach(r => {
			r.HF = r.HF == 1;
			r.VMW = r.VMW == 1;
			r.Match = ko.observable(false);
		});

	    self.listModel(treatements);

		treatmentSpecies = rs.treatmentSpecie
		self.treatmentSpecies(treatmentSpecies)
	});

	self.showAdd = function () {
		self.addModel({
			treatment: ko.observable(''),
			description: ko.observable(''),
			hf: false,
			vmw: false
		});
		$('#modalAdd').modal('show');
	};

	self.saveClick = function () {
		var model = self.addModel();
		model.treatment(model.treatment().trim());

		if (model.treatment() == '') {
			app.showWarning(model.treatment.element, 'Please input this box.');
			return;
		}
		$('#modalAdd').modal('hide');

		var submit = {
			table: 'tblTreatment',
			value: {
				Treatment: model.treatment(),
				Description: model.description(),
				HF: model.hf ? 1 : 0,
				VMW: model.vmw ? 1 : 0,
				PPM: 0,
				InitUser: app.user.username,
				InitTime: 'getdate()'
			}
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/insert', submit).done(function (id) {
			self.listModel.push({
				Rec_ID: id,
				Treatment: model.treatment(),
				Description: model.description(),
				HF: model.hf,
				VMW: model.vmw
			});
		});
	};

	self.updateClick = function (model) {
		if (model.Treatment.trim() == '') return;

		var submit = {
			table: 'tblTreatment',
			value: {
				Treatment: model.Treatment,
				Description: model.Description,
				HF: model.HF ? 1 : 0,
				VMW: model.VMW ? 1 : 0,
				ModiUser: app.user.username,
				ModiTime: 'getdate()'
			},
			where: { Rec_ID: model.Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit);
	};

	self.deleteClick = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblTreatment',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.tabClick = function (model, event) {
	    self.tab($(event.currentTarget).text());
	    if (self.tab() == 'Treatment by Specie') self.changeSpecie();
	};

	self.changeSpecie = function () {
	    var arr = treatmentSpecies.filter(r => r.Specie == self.specie());
	    treatements.forEach(r => { r.Match(arr.some(s => s.TreatmentID == r.Rec_ID)) });
	    self.listModel(treatements);
	}

	self.saveTreatmentSpecie = function () {
	    var submit = {
	        specie: self.specie(),
	        treatmentIDs: treatements.filter(r=>r.Match()).map(r=>r.Rec_ID)
	    }
	    
	    app.ajax('/Treatment/saveTreatmentSpecie', submit).done(function (rs) {
	        treatmentSpecies = rs;
	        treatements.forEach(r => { r.Match(submit.treatmentIDs.some(s=>s == r.Rec_ID)) })
	        self.listModel(treatements);
	        app.showMsg('Save Treatment Species', 'Data has been saved successfully.');
	    });
	}
}