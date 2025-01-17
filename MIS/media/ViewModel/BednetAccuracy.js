function viewModel() {
	var self = this;

	self.yearList = [];
	self.pvList = ko.observableArray();
	self.listModel = ko.observableArray();
	self.quarter = ko.observable();

	self.year = ko.observable(2019);
	self.q = ko.observable('Q1');
	self.pv = ko.observable();
	self.loop = [];

	self.mf = ko.computed(() => {
		if (self.quarter() != undefined) 
			return self.quarter().substr(1) * 3 - 2
	});

	self.mt = ko.computed(() => {
		if (self.quarter() != undefined)
			return self.quarter().substr(1) * 3;
	});

	self.q = ko.computed(() => {
		if (self.quarter() != undefined)
			return self.quarter().substr(1);
	});

	var place = null;
	var mainData = [];
	var changeList = [];

	for (var i = 2018; i <= moment().year(); i++) {
		self.yearList.push(i);
	}

	self.loop.push('LLINContinue');
	self.loop.push('LLIHNContinue');
	self.loop.push('LLINMobile');
	self.loop.push('LLIHNMobile');
	self.loop.push('LLINCampaign');
	self.loop.push('LLIHNCampaign');

	app.getPlace(['pv', 'od'], function (p) {
		place = p;
		self.pvList(place.pv);
	});

	function getType(value) {
		return value.contain('Continue') ? 'Continue' : value.contain('Mobile') ? 'Mobile' : 'Campaign';
	}
	
	function getQ(value) {
		return value.split(getType(value))[0].substr(-1);
	}

	function getData() {
		var submit = {
			year: self.year(),
			mf: self.mf(),
			mt: self.mt(),
			q: self.q()
		};
		app.ajax('getBednetAccuracy', submit).done(function (rs) {
			rs.forEach(row => {
				self.loop.forEach(name => {
					var note = name + 'Note';
					name += 'A';
					row[note] = ko.observable(isnull(row[note], ''));
					row[name] = ko.observable(isnull(row[name], ''));
					row[name].info = JSON.stringify({
						Year: self.year(),
						Code_OD_T: row.Code_OD_T,
						Type: getType(name),
						Quarter: self.q()
					});

					row[name].subscribe(function () {
						var info = this._target.info;
						var has = changeList.some(r => r == info);
						if (!has) changeList.push(info);
					});
					
					row[note].subscribe(function () {
						var i = row[name].info
						var has = changeList.some(r => r == i);
						if (!has) changeList.push(i);
					});
				})
			});

			self.listModel(rs);
		});
	}

	self.getListModel = ko.pureComputed(function () {
		return self.pv() == null ? self.listModel() : self.listModel().filter(r => r.Code_Prov_T == self.pv());
	});

	self.calculate = function (r, name) {
		return parseInt(isempty(r[name + 'A'](), 0)) - r[name];
	};

	self.getColor = function(value) {
		return value < 0 ? 'red' : 'orange';
	}

	self.save = function (goAfterSave) {
		if (changeList.length == 0) return;

		var list = [];
		changeList.forEach(r => {
			var obj = JSON.parse(r);
			var found = self.listModel().find(r => r.Code_OD_T == obj.Code_OD_T);
			list.push({
				where: obj,
				value: {
					LLIN: isempty(found['LLIN' + obj.Type + 'A'](), 0),
					LLIHN: isempty(found['LLIHN' + obj.Type + 'A'](), 0),
					LLINNote: isempty(found['LLIN' + obj.Type + 'Note'](), ''),
					LLIHNNote: isempty(found['LLIHN' + obj.Type + 'Note'](), ''),
				}
			});
		});

		var submit = { list: list };
		app.ajax('updateBednetAccuracy', submit).done(function () {
			changeList = []
			if (goAfterSave === 1) location = '/';
			if (goAfterSave === 2) getData();
		});
	};

	self.year.subscribe(function () {
		if (changeList.length > 0) {
			$('#modalSave').modal('show');
			$('#modalSave .btn-primary').off().click(function () {
				$('#modalSave').modal('hide');
				self.save(2);
			});
			$('#modalSave .btn-danger').off().click(function () {
				$('#modalSave').modal('hide');
				getData();
			});
			$('#modalSave .btn-default').hide();
		}
		else getData();
	});

	self.q.subscribe(function () {
		if (changeList.length > 0) {
			$('#modalSave').modal('show');
			$('#modalSave .btn-primary').off().click(function () {
				$('#modalSave').modal('hide');
				self.save(2);
			});
			$('#modalSave .btn-danger').off().click(function () {
				$('#modalSave').modal('hide');
				getData();
			});
			$('#modalSave .btn-default').hide();
		}
		else getData();
	})

	self.home = function () {
		if (changeList.length > 0) {
			$('#modalSave').modal('show');
			$('#modalSave .btn-primary').off().click(function () {
				$('#modalSave').modal('hide');
				self.save(1);
			});
			$('#modalSave .btn-danger').off().click(function () {
				location = '/';
			});
			$('#modalSave .btn-default').show();
		}
		else location = '/';
	};

	$(document).ready(function () {
		getData();
	});
}