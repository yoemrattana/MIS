function foci2ViewModel(root) {
	var self = this;

	self.detailModel = ko.observable();
	self.fociCode = ko.observable();
	self.classify = ko.observable();
	self.visibleDelete = ko.observable(false);
	self.primaryVector = ko.observable();
	self.secondaryVector = ko.observable();

	var newModel = null;
	var dataChanged = false;
	var tableName = 'tblFociInvestigation2';
	var isOpen = location.pathname.contain('/Foci/open');
	var villCode = location.pathname.split('/')[3];
	var lastScrollY = 0;

	self.getDetailPVList = function () {
		return root.place.pv.sortasc(r => r.nameK);
	};

	self.getDetailODList = function () {
		var code = self.detailModel().Code_Prov_N();
		if (code == null) return [];
		return root.place.od.filter(r => r.pvcode == code && !isnone(r.nameK)).sortasc(r => r.nameK);
	};

	self.getDetailHCList = function () {
		var code = self.detailModel().Code_OD_T();
		if (code == null) return [];
		return root.place.hc.filter(r => r.odcode == code && !isnone(r.nameK)).sortasc(r => r.nameK);
	};

	self.getDetailVLList = function () {
		var code = self.detailModel().Code_Facility_T();
		if (code == null) return [];
		return root.place.vl.filter(r => r.hccode == code && !isnone(r.nameK)).sortasc(r => r.nameK);
	};

	root.showNew = function () {
		self.showDetail({ Rec_ID: 0 });
	};

	self.showDetail = function (row) {
		lastScrollY = window.scrollY;

		var submit = {
			table: tableName,
			recid: isOpen ? 0 : row.Rec_ID,
			villcode: villCode || '',
			needNewModel: newModel == null ? 1 : 0
		};
		app.ajax('/Foci/getDetail', submit).done(function (rs) {
			if (rs.newModel != null) {
				newModel = rs.newModel;
				newModel.FociClassification = 'Active Foci';
				updatePlace(newModel);
			}
			self.visibleDelete(isOpen && rs.data != null);
			prepareDetail(rs.data || newModel);

			self.primaryVector(rs.mosquito.Primary);
			self.secondaryVector(rs.mosquito.Secondary);

			window.scrollTo(0, 0);
		});
	};

	function updatePlace(newModel) {
		if (isNaN(villCode) || villCode.length != 10) return;

		newModel.Code_Vill_T = villCode;
		newModel.Code_Facility_T = root.place.vl.find(r => r.code == villCode).hccode;
		newModel.Code_OD_T = root.place.hc.find(r => r.code == newModel.Code_Facility_T).odcode;
		newModel.Code_Prov_N = root.place.od.find(r => r.code == newModel.Code_OD_T).pvcode;

		newModel.FociCode = [villCode.substr(6, 2), villCode.substr(4, 2), villCode.substr(2, 2), villCode.substr(0, 2), moment().year()].join('/');
	}

	function prepareDetail(model) {
		var code = isnot(model.FociCode, null, c => c.split('/'));
		self.fociCode({
			vv: ko.observable(isnot(code, null, c => c[0])),
			cc: ko.observable(isnot(code, null, c => c[1])),
			dd: ko.observable(isnot(code, null, c => c[2])),
			pp: ko.observable(isnot(code, null, c => c[3])),
			yyyy: ko.observable(code == null ? moment().year() : code[4])
		});

		var fields = ['PatientMalariaHistory', 'PatientFullTreatment', 'PatientSleepInBednet', 'WaterIn3km', 'VectorType', 'DistanceToForest', 'Under5yIn12m', 'TravellerOver20p', 'ForesterOver20p', 'SeasonWorker'];
		fields.forEach(key => {
			if (model[key] != null) model[key] = model[key].toString();
		});

		model = app.ko(model);

		if (model.Rec_ID() != null) {
			model.FociInvestigationDate(moment(model.FociInvestigationDate()));
			if (model.Photo() != null) model.Photo('/media/FociInvestigation/' + model.Photo());
		}

		model.Code_Vill_T.subscribe(function (code) {
			if (code == null) {
				self.fociCode().vv(null);
				self.fociCode().cc(null);
				self.fociCode().dd(null);
				self.fociCode().pp(null);
			} else {
				self.fociCode().vv(code.substr(6, 2));
				self.fociCode().cc(code.substr(4, 2));
				self.fociCode().dd(code.substr(2, 2));
				self.fociCode().pp(code.substr(0, 2));
			}
			getClassification();
		});

		self.detailModel(model);
		root.view('detail2');
		getClassification();

		dataChanged = false;
		for (var key in newModel) {
			if (key.in('Code_OD_T', 'Code_Facility_T', 'FociClassification')) continue;
			model[key].subscribe(() => dataChanged = true);
		}
		for (var key in self.fociCode()) {
			self.fociCode()[key].subscribe(() => dataChanged = true);
		}

		$('input[numonly]').each(function () {
			app.setNumberOnly(this, $(this).attr('numonly'));
		});
	}

	function getClassification() {
		var model = self.detailModel();
		var code = model.Code_Vill_T();

		if (code == null) {
			self.classify({
				actives: [0, 0, 0, 0, 0],
				nonActives: [0, 0, 0, 0, 0],
				clears: [0, 0, 0, 0, 0]
			});
			model.FociClassification(null);
			return;
		}

		function getDate(y) {
			return moment().add(y, 'year').sqlformat();
		}

		var arrYear = Array.repeat(5).map((r, i) => {
			return { from: getDate(-2 - i), to: getDate(-1 - i) };
		}).reverse();

		var list = root.listModel().filter(r => r.Code_Vill_T == code);

		var obj = {};
		obj.actives = arrYear.map(y => list.filter(r => r.DateCase >= y.from && r.DateCase <= y.to).length);
		obj.nonActives = arrYear.map((y, i) => {
			if (list.length == 0) return 0;

			var minDate = list.map(r => r.DateCase).reduce((a, b) => a < b ? a : b);
			if (y.to < minDate || obj.actives[i] > 0) return 0;

			var from = moment(y.from).add(-2, 'year').sqlformat();
			var to = moment(y.to).add(-1, 'year').sqlformat();
			return list.filter(r => r.DateCase >= from && r.DateCase <= to).length == 0 ? 0 : 1;
		});
		obj.clears = arrYear.map((y, i) => {
			if (list.length == 0) return 0;

			var minDate = list.map(r => r.DateCase).reduce((a, b) => a < b ? a : b);
			if (y.to < minDate) return 0;

			return obj.actives[i] == 0 && obj.nonActives[i] == 0 ? 1 : 0;
		});
		self.classify(obj);

		var monthQty = 0;
		if (list.length > 0) {
			var maxDate = list.map(r => r.DateCase).reduce((a, b) => a > b ? a : b);
			monthQty = moment().diff(maxDate, 'month', true);
		}
		var status = monthQty <= 12 ? 'Active Foci' : monthQty <= 36 ? 'Residual Non-Active Foci' : 'Cleared Foci';
		model.FociClassification(status);
	}

	self.getTotal1 = function () {
		var model = self.detailModel();
		var arr = [model.WaterIn3km(), model.VectorType(), model.DistanceToForest(), model.Under5yIn12m()];
		if (arr.every(r => isnone(r))) return null;

		var total = parseInt(isempty(model.WaterIn3km(), 0))
			+ parseInt(isempty(model.VectorType(), 0))
			+ parseInt(isempty(model.DistanceToForest(), 0))
			+ parseInt(isempty(model.Under5yIn12m(), 0));

		model.R1(total > 6 ? 1 : 0);

		return total;
	};

	self.getTotal2 = function () {
		var model = self.detailModel();
		var arr = [model.TravellerOver20p(), model.ForesterOver20p(), model.SeasonWorker()];
		if (arr.every(r => isnone(r))) return null;

		var total = parseInt(isempty(model.TravellerOver20p(), 0))
			+ parseInt(isempty(model.ForesterOver20p(), 0))
			+ parseInt(isempty(model.SeasonWorker(), 0));

		model.V1(total > 6 ? 1 : 0);

		return total;
	};

	function trimKO(value) {
		if (value() != null) value(value().trim());
	}

	function checkInputMissing() {
		var model = self.detailModel();
		var missing = false;
		if (isnone(model.Investigator())) {
			showWarning(model.Investigator, missing);
			missing = true;
		}
		if (isnone(model.Phone())) {
			showWarning(model.Phone, missing);
			missing = true;
		}
		if (model.Code_Prov_N() == null) {
			showWarning(model.Code_Prov_N, missing);
			missing = true;
		}
		if (model.Code_OD_T() == null) {
			showWarning(model.Code_OD_T, missing);
			missing = true;
		}
		if (model.Code_Facility_T() == null) {
			showWarning(model.Code_Facility_T, missing);
			missing = true;
		}
		if (model.Code_Vill_T() == null) {
			showWarning(model.Code_Vill_T, missing);
			missing = true;
		}
		if (isnone(self.fociCode().vv())) {
			showWarning(self.fociCode().vv, missing);
			missing = true;
		}
		if (isnone(self.fociCode().cc())) {
			showWarning(self.fociCode().cc, missing);
			missing = true;
		}
		if (isnone(self.fociCode().dd())) {
			showWarning(self.fociCode().dd, missing);
			missing = true;
		}
		if (isnone(self.fociCode().pp())) {
			showWarning(self.fociCode().pp, missing);
			missing = true;
		}
		if (isnone(self.fociCode().yyyy())) {
			showWarning(self.fociCode().yyyy, missing);
			missing = true;
		}
		if (model.FociInvestigationDate() == null) {
			showWarning(model.FociInvestigationDate, missing);
			missing = true;
		}
		return missing;
	}

	self.save = function () {
		var model = self.detailModel();

		trimKO(model.Investigator);
		trimKO(model.Job);

		if (checkInputMissing()) return;

		model = app.unko(model);
		var fc = self.fociCode();
		model.FociCode = fc.vv() + '/' + fc.cc() + '/' + fc.dd() + '/' + fc.pp() + '/' + fc.yyyy();
		model.FociInvestigationDate = model.FociInvestigationDate.format('YYYY-MM-DD');
		model.PeopleFromHighRisk = model.PeopleFromHighRisk ? 1 : 0;
		model.WorkerNearVillage = model.WorkerNearVillage ? 1 : 0;

		model.EndDate = moment.sqlformat(model.EndDate);
		model.VMWDate = moment.sqlformat(model.VMWDate);
		model.ITNDate = moment.sqlformat(model.ITNDate);
		model.AFSDate = moment.sqlformat(model.AFSDate);
		model.TDADate = moment.sqlformat(model.TDADate);
		model.IPTDate = moment.sqlformat(model.IPTDate);

		if (model.Photo != null && model.Photo.contain('.jpg')) {
			model.Photo = model.Photo.split('/').last();
		}

		delete model.Code_Prov_N;
		delete model.Code_OD_T;
		delete model.Code_Facility_T;

		for (var key in newModel) {
			if (newModel[key] == null && model[key] === '') model[key] = null;
		}

		var keys = [
			'PatientName',
			'PatientAge',
			'PatientSex',
			'PatientJob',
			'PatientAddress',
			'PatientDiagnosisPlace',
			'FociBoundary',
			'Population',
			'House',
			'Lat',
			'Long',
			'Photo',
			'Traveller',
			'Forester',
			'PrimaryVectorQty',
			'SecondaryVectorQty',
			'WaterIn3km',
			'VectorType',
			'DistanceToForest',
			'Under5yIn12m',
			'TravellerOver20p',
			'ForesterOver20p',
			'SeasonWorker'
		];
		model.Completed = keys.some(k => model[k] == null) ? 0 : 1;

		var submit = { submit: JSON.stringify(model) };
		app.ajax('/Foci/save2', submit).done(function (rs) {
			if (isOpen) {
				close();
				return;
			}

			rs.TableName = tableName;

			if (model.Rec_ID == null) {
				rs.Tag = 'Real';
				root.listModel.push(rs);
			} else {
				var oldList = root.listModel().filter(r => r.TableName == tableName && r.Rec_ID == model.Rec_ID);
				oldList.forEach(old => {
					var newRow = clone(rs);
					newRow.Tag = old.Tag;
					root.listModel.replace(old, newRow);
				});
			}

			root.view('list');
			window.scrollTo(0, lastScrollY);
		});
	};

	self.deleteDetail = function () {
		app.showDelete(function () {
			var submit = {
				table: 'tblFociInvestigation2',
				where: { Rec_ID: self.detailModel().Rec_ID() }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				isOpen ? close() : root.listModel.remove(model);
			});
		});
	};

	self.back = function () {
		if (dataChanged) {
			$('#modalSave').modal('show');
			$('#modalSave .btn-primary').off().click(self.save);
			$('#modalSave .btn-danger').off().click(() => { dataChanged = false; self.back(); });
		} else {
			if (isOpen) {
				close();
			} else {
				root.view('list');
				window.scrollTo(0, lastScrollY);
			}
		}
	};

	self.selectFile = function () {
		$('#file2').val('').click();
	};

	self.fileChanged = function (files) {
		var reader = new FileReader();
		reader.onload = function () {
			var img = new Image();
			img.src = reader.result;
			img.onload = function () {
				var w = img.width > 800 ? 800 : img.width;
				var h = img.height * (w / img.width);

				var canvas = document.createElement('canvas');
				canvas.width = w;
				canvas.height = h;

				var ctx = canvas.getContext('2d');
				ctx.drawImage(img, 0, 0, w, h);

				self.detailModel().Photo(canvas.toDataURL('image/jpeg', 0.9));
			};
		};
		reader.readAsDataURL(files[0]);
	};

	function showWarning(bindingValue, secondWarning) {
		var el = $(bindingValue.element);

		if (secondWarning === false) {
			$(window).scrollTop(0);
			el.focus();
		}

		function addError() {
			el.parent().addClass('has-error');
		}
		function removeError() {
			el.parent().removeClass('has-error');
		}
		function checkValue() {
			bindingValue() == null || bindingValue() === '' ? addError() : removeError();
		}
		addError();

		if (el.data('hasWarnEvent') === true) return;
		el.data('hasWarnEvent', true);
		bindingValue.subscribe(checkValue);
	}
}