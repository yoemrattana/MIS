function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();
	self.detailModel = ko.observableArray();
	self.view = ko.observable('list');

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.ds = ko.observable();
	self.cm = ko.observable();
	self.vl = ko.observable();

	var place = null;
	var fieldData = [];

	app.getPlace(['pv', 'ds', 'cm', 'vl'], function (p) {
		place = p;
		self.pvList(app.user.prov == '' ? place.pv : place.pv.filter(r => app.user.prov.contain(r.code)));

		app.ajax('/Entomology/getInsecticideList').done(function (rs) {
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

		self.showEdit(model);
	};

	self.showEdit = function (model) {
		if (model.Rec_ID == null) {
			prepare([]);
		} else {
			var submit = { ParentId: model.Rec_ID };
			app.ajax('/Entomology/getInsecticideDetail', submit).done(prepare);
		}

		function prepare(details) {
			model = app.ko(model);

			model.pvList = ko.observable(place.pv);
			model.dsList = () => model.Code_Prov_T() == null ? [] : place.ds.filter(r => r.pvcode == model.Code_Prov_T());
			model.cmList = () => model.Code_Dist_T() == null ? [] : place.cm.filter(r => r.dscode == model.Code_Dist_T());
			model.vlList = () => model.Code_Comm_T() == null ? [] : place.vl.filter(r => r.cmcode == model.Code_Comm_T());

			if (details.length == 0) {
				var names = [
					'Number of Mosquitoes Tested',
					'KD/Dead 60 minutes',
					'KD/Dead 24 hours'
				];

				details = names.map(name => {
					return {
						Indicator: name,
						InsecticideOnly: ko.observable(null),
						SolventOnlyControl: ko.observable(null),
						InsecticideSynergist: ko.observable(null),
						SynergistOnlyControl: ko.observable(null)
					};
				});
			} else {
				details = details.filter(r => r.Indicator != 'Mortality at 24hrs (%)');
				details.forEach(r => {
					r.InsecticideOnly = ko.observable(r.InsecticideOnly);
					r.SolventOnlyControl = ko.observable(r.SolventOnlyControl);
					r.InsecticideSynergist = ko.observable(r.InsecticideSynergist);
					r.SynergistOnlyControl = ko.observable(r.SynergistOnlyControl);
				});
			}

			model.TemperatureExposureMax.subscribe(function (max) {
				if (max < parseFloat(model.TemperatureExposureMin())) model.TemperatureExposureMin(max);
			});
			model.TemperatureHoldingMax.subscribe(function (max) {
				if (max < parseFloat(model.TemperatureHoldingMin())) model.TemperatureHoldingMin(max);
			});

			self.editModel(model);
			self.detailModel(details);
			self.view('edit');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		}
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblEntomologyInsecticide',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

            logDelete(submit);

            setTimeout(() => {
                app.ajax('/Direct/delete', submit).done(function () {
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

		if (model.Institution() == 'Other' && isnone(model.InstitutionOther())) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Institution Completing Test');
			return;
		}
		if (isnone(model.CompletingPerson())) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Name of Person Completing Form');
			return;
		}
		if (model.InsecticideDate() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', 'Date of Insecticide Resistance Test');
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
		if (!isnone(model.Lat()) && model.Lat().length != 8) {
			window.scrollTo(0, 0);
			app.showMsg('Incorrect Format', 'Latitude format: XX.XXXXX');
			return;
		}
		if (!isnone(model.Long()) && model.Long().length != 9) {
			window.scrollTo(0, 0);
			app.showMsg('Incorrect Format', 'Longitude format: XXX.XXXXX');
			return;
		}
		if (!isnone(model.TemperatureExposureMin()) && model.TemperatureExposureMin() < 10) {
			app.showMsg('Incorrect Data', 'Minimum temperature must be &ge; 10');
			return;
		}
		if (!isnone(model.TemperatureHoldingMin()) && model.TemperatureHoldingMin() < 10) {
			app.showMsg('Incorrect Data', 'Minimum temperature must be &ge; 10');
			return;
		}

		for (var i = 1; i < 3 ; i++) {
			var indicator = self.detailModel()[i].Indicator;
			var arr = ['InsecticideOnly', 'SolventOnlyControl', 'InsecticideSynergist', 'SynergistOnlyControl'];
			if (arr.some(c => self.checkEqualTotal(indicator, c) == 'red')) {
				app.showMsg('Incorrect Data', indicator + ' should less than or equal to Number of Mosquitoes Tested');
				return;
			}
		}
		
		model = app.unko(model);
		model.InsecticideDate = model.InsecticideDate.sqlformat();

		if (model.Institution != 'Other') model.InstitutionOther = null;
		if (model.Species != 'Other') model.SpeciesOther = null;
		if (!model.Age.contain('Other')) model.AgeOther = null;
		if (model.InsecticideTested != 'Other') model.InsecticideTestedOther = null;
		if (model.SynergistTested != 'Other') model.SynergistTestedOther = null;

		var names = [];
		for (var r of fieldData) {
			names.push(r.name);

			if (r.type == 'float') model[r.name] = isempty(model[r.name], null);
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

		var details = app.unko(self.detailModel());
		details.forEach(r => {
			Object.keys(r).forEach(k => r[k] = isempty(r[k], null));
		});
		details.push({
			Indicator: 'Mortality at 24hrs (%)',
			InsecticideOnly: self.calculateMortality('InsecticideOnly'),
			SolventOnlyControl: self.calculateMortality('SolventOnlyControl'),
			InsecticideSynergist: self.calculateMortality('InsecticideSynergist'),
			SynergistOnlyControl: self.calculateMortality('SynergistOnlyControl')
		});

		var submit = {
			master: JSON.stringify(model),
			details: JSON.stringify(details)
		};

		app.ajax('/Entomology/saveInsecticide', submit).done(function (rs) {
			if (model.Rec_ID == null) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
				self.listModel.replace(old, rs);
			}

			self.view('list');
		});
	};

	self.back = function () {
		self.view('list');
	};

	self.getPVName = function (code) {
		return place.pv.find(r => r.code == code).name;
	};

	self.getDSName = function (code) {
		return place.ds.find(r => r.code == code).name;
	};

	self.getCMName = function (code) {
		return place.cm.find(r => r.code == code).name;
	};

	self.getVLName = function (vlcode) {
		return place.vl.find(r => r.code == vlcode).name;
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

	self.calculateMortality = function (name) {
		function calc(name) {
			var details = self.detailModel();
			var a = details.find(r => r.Indicator == 'KD/Dead 24 hours')[name]();
			var b = details.find(r => r.Indicator == 'Number of Mosquitoes Tested')[name]();
			return isnone(a) || isnone(b) ? null : a * 100 / b;
		}

		var result = calc(name);

		if (name == 'InsecticideOnly' && result != null) {
			var control = calc('SolventOnlyControl');
			if (control >= 5 && control <= 20) {
				result = (result - control) * 100 / (100 - control);
			} else if (control > 20) {
				result = -1;
			}
		}

		return result == null ? null : result.toFixed(0);
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

	self.only10 = function (model, event) {
		if (event.keyCode == 8 || event.keyCode == 9) return true;
		return event.currentTarget.value + event.key <= 10;
	};

	self.only100 = function (model, event) {
		if (event.keyCode == 8 || event.keyCode == 9) return true;
		return event.currentTarget.value + event.key <= 100;
	};

	self.only30 = function (model, event) {
		if (event.keyCode == 8 || event.keyCode == 9) return true;
		return event.currentTarget.value + event.key <= 30;
	};

	self.notOverExposure = function (model, event) {
		if (event.keyCode == 8 || event.keyCode == 9) return true;
		return event.currentTarget.value + event.key <= parseFloat(model.TemperatureExposureMax());
	};

	self.notOverHolding = function (model, event) {
		if (event.keyCode == 8 || event.keyCode == 9) return true;
		return event.currentTarget.value + event.key <= parseFloat(model.TemperatureHoldingMax());
	};

	self.checkEqualTotal = function (indicator, column) {
		if (indicator == 'Number of Mosquitoes Tested') return null;

		var detail = self.detailModel();
		var total = detail.find(r => r.Indicator == 'Number of Mosquitoes Tested')[column]();
		var dead = detail.find(r => r.Indicator == indicator)[column]();

		return isnone(total) || isnone(dead) || dead.toFloat() <= total.toFloat() ? null : 'red';
	};

	self.insecticideList = function () {
		var type = self.editModel().TestType();

		if (type == 'WHO Tube Test') {
			return [
				'Bendiocarb',
				'DDT',
				'Alpha-cypermethrin',
				'Deltamethrin',
				'Lambda-cyhalothrin',
				'Permethrin',
				'Pirimiphos-methyl',
				'Propoxur',
				'Clothianidin',
				'Other'
			];
		}
		if (type == 'CDC Bottle Bioassay') {
			return [
				'Bendiocarb',
				'DDT',
				'Alpha-cypermethrin',
				'Deltamethrin',
				'Permethrin',
				'Lambda-cyhalothrin',
				'Pirimiphos-methyl',
				'Chlorfenapyr',
				'Clothianidin',
				'Other'
			];
		}
		return [];
	};

	self.insecticideConcentrationList = function () {
		var type = self.editModel().TestType();
		var insect = self.editModel().InsecticideTested();

		if (type == '' || insect == null) {
			return [];
		}
		else if (type == 'WHO Tube Test') {
			var list = {
				'Bendiocarb': ['0.10%', '0.50%', '1%'],
				'DDT': ['4%'],
				'Alpha-cypermethrin': ['0.05%', '0.25%', '0.50%'],
				'Deltamethrin': ['0.05%', '0.25%', '0.50%'],
				'Lambda-cyhalothrin': ['0.05%', '0.25%', '0.50%'],
				'Permethrin': ['0.75%', '3.75%', '7.50%'],
				'Pirimiphos-methyl': ['0.25%', '1.25%', '2.50%'],
				'Propoxur': ['0.10%'],
				'Clothianidin': ['2%'],
				'Other': []
			}[insect];

		}
		else if (type == 'CDC Bottle Bioassay') {
			var list = {
				'Bendiocarb': ['12.5ug'],
				'DDT': ['100ug'],
				'Alpha-cypermethrin': ['12.5ug', '62.5ug', '125ug'],
				'Deltamethrin': ['12.5ug', '25ug', '62.5ug', '125ug'],
				'Permethrin': ['21.5ug', '107.5ug', '215ug'],
				'Lambda-cyhalothrin': ['12.5ug', '62.5ug', '125ug'],
				'Pirimiphos-methyl': ['20ug'],
				'Chlorfenapyr': ['100ug'],
				'Clothianidin': ['4ug'],
				'Other': []
			}[insect];
		}

		return list.concat('Other');
	};

	self.synergistConcentrationList = function () {
		var type = self.editModel().TestType();

		if (type == 'WHO Tube Test') return ['4%', 'Other'];
		if (type == 'CDC Bottle Bioassay') return ['80ug', '100ug', '125ug', '400ug', 'Other'];
	};
}