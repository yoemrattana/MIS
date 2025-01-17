function viewModel() {
	var self = this;
	var today = moment();

	self.provList = ko.observableArray();
	self.troopList = ko.observableArray();
	self.reportList = ko.observableArray();
	self.master = ko.observable();
	self.detailList = ko.observableArray();

	self.year = ko.observable(today.year());
	self.prov = ko.observable();
	self.troop = ko.observable();
	self.isListView = ko.observable(true);
	self.treatmentList = [];

	var currentReport = null;
	var ready = false;
	var firstWarnElement = null;
	var deletedList = [];
	var provData = [];
	var lastScrollTop = 0;

	app.ajax('plGetPreData').done(function (rs) {
		troopData = rs.troop;
		self.provList(rs.prov);
		self.treatmentList = rs.treatmentList

		var url = getURL();
		if (url != null) {
			self.year(url.year);
			self.prov(url.prov);
			self.troop(url.troop);
		}
	});

	self.previousYear = function () {
		self.year(self.year() - 1);
		self.getReport();
	};

	self.nextYear = function () {
		self.year(self.year() + 1);
		self.getReport();
	};

	self.prov.subscribe(function (code) {
	    self.getReport();
		//self.troopList(troopData.filter(r => r.prov == code));
	});

	self.troop.subscribe(function () {
	    
		self.getReport();
	});

	self.getReport = function () {
	    var url = getURL() || {};
	    if (self.prov() != null) {
	        url.year = self.year();
	        url.prov = self.prov();
	    } else {
	        url = null;
	    }
	    changeURL(url);

	    if (self.prov() == null) {
	        self.reportList([]);
	        return;
	    }

	    var submit = { year: self.year(), prov: self.prov() };
	    app.ajax('plGetReport', submit).done(function (rs) {
	        rs.troops.forEach(post => {
				post.reports = [];
				for (var i = 1; i <= 12; i++) {
					var m = ('0' + i).substr(-2);
					var obj = {
					    id: post.Code_Troop_T,
					    en: post.Name_Troop_E,
					    kh: post.Name_Troop_K,
						month: m,
						has: ko.observable(rs.reports.some(r => r.ID == post.Code_Troop_T && r.Month == m))
					};
					post.reports.push(obj);
				}
			});
	        self.reportList(rs.troops);

			if (url.id != null) {
			    var report = rs.troops.find(r => r.Code_Troop_T == url.id);
				report = report.reports[parseInt(url.month) - 1];
				self.editReport(report);
			}
		});
	};

	self.editReport = function (model) {
		changeURL({ year: self.year(), prov: self.prov(), troop: self.troop(), id: model.id, month: model.month });

		if (model.has()) {
			var submit = {
				id: model.id,
				year: self.year(),
				month: model.month,
				has: model.has()
			};

			app.ajax('plGetCase', submit).done(prepare);
		} else {
			prepare({ detail: [] });
		}

		function prepare(rs) {
			// master
			var newObj = { NumberPositive: '', NumberNeg: '', NumberRDT: '', NumberMicroscopy: '' };
			var master = rs.master == null ? newObj : rs.master;
			master = app.ko(master);

			for (var key in newObj) {
				master[key].subscribe(function () {
					if (ready) master.changed = true;
				});
			}

			master.prov = self.provList().find(r => r.code == self.prov()).name;
			//master.troop = self.troopList().find(r => r.code == self.troop()).name;
			master.kh = model.kh;
			master.month = model.month + '-' + self.year();
			master.has = model.has();
			master.changed = false;

			function totalChange(value) {
				if (master.NumberPositive() === '' || master.NumberRDT() === '' || master.NumberMicroscopy() === '') {
					master.NumberNeg('');
				} else {
					master.NumberNeg((parseInt(master.NumberRDT()) + parseInt(master.NumberMicroscopy())) - parseInt(master.NumberPositive()));
				}
			}
			master.NumberPositive.subscribe(totalChange);
			master.NumberRDT.subscribe(totalChange);
			master.NumberMicroscopy.subscribe(totalChange);

			// detail
			rs.detail.push(createObj());
			var details = [];
			rs.detail.forEach(r => details.push(convertObj(r)));

			ready = false;
			self.master(master);
			self.detailList(details);

			app.setNumberOnly(master.NumberPositive.element, 'int');
			app.setNumberOnly(master.NumberRDT.element, 'int');
			app.setNumberOnly(master.NumberMicroscopy.element, 'int');
			details.forEach(r => {
				app.setNumberOnly(r.Age.element, 'int');
				app.setNumberOnly(r.SickQty.element, 'int');
			});
			ready = true;

			currentReport = model;
			deletedList = [];
			lastScrollTop = $(window).scrollTop();
			self.isListView(false);
			$(window).scrollTop(0);
		}
	};

	self.addCase = function (model) {
		if (warnDetail(model)) {
			app.showMsg('<kh>ខ្វះទិន្នន័យ</kh> - Missing Data', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh><br><br>Please input data in red box');
			return;
		}
		removeAllWarning();

		model.Rec_ID(0);

		ready = false;
		var newModel = convertObj(createObj());
		self.detailList.push(newModel);

		app.setNumberOnly(newModel.Age.element, 'int');
		app.setNumberOnly(newModel.SickQty.element, 'int');

		ready = true;
	};

	function createObj() {
		return {
			Rec_ID: -1,
			DateCase: null,
			Name: '',
			Sex: '',
			Age: '',
			Participant: '',
			SickQty: '',
			ClinicSign: false,
			Status: '',
			Pregnant: '',
			RDT: '',
			Microscopy: '',
			Treatment: null,
			OtherTreatment: '',
			Result: '',
			Bednet: false,
			Note: '',
            TreatmentPlace: ''
		};
	}

	function convertObj(r) {
		if (r.Treatment != null && !self.treatmentList.contain(r.Treatment)) {
			r.OtherTreatment = r.Treatment;
			r.Treatment = 'Other';
		}
		r.ClinicSign = r.ClinicSign == 1;
		r.Bednet = r.Bednet == 1;

		if (r.Rec_ID > 0) {
			r.Status = r.Severe == 1 ? 'Severe' : 'Simple'
			r.Result = r.Referred == 1 ? 'Referred' : r.Dead == 1 ? 'Dead' : 'Cured';
		}

		var obj = app.ko(r);
		if (obj.DateCase() != null) obj.DateCase(moment(obj.DateCase()));

		obj.Sex.subscribe(() => obj.Pregnant(''));

		obj.changed = false;
		for (var key in createObj()) {
			obj[key].subscribe(function () {
				if (ready) obj.changed = true;
			});
		}

		return obj;
	}

	function warnDetail(model) {
		var missing = false;

		if (model.DateCase() == null) { showWarning(model.DateCase); missing = true; }
		if (model.Name() === '') { showWarning(model.Name); missing = true; }
		if (model.Sex() === '') { showWarning(model.Sex); missing = true; }
		if (model.Age() === '') { showWarning(model.Age); missing = true; }
		if (model.Participant() === '') { showWarning(model.Participant); missing = true; }
		if (model.SickQty() === '') { showWarning(model.SickQty); missing = true; }
		if (model.Status() === '') { showWarning(model.Status); missing = true; }
		if (model.Sex() == 'F' && model.Pregnant() === '') {
			showWarning(model.Pregnant);
			if (model.Sex.handle == null) {
				model.Sex.handle = model.Sex.subscribe(() => {
					if (model.Sex() == 'F' && model.Pregnant() === '') showWarning(model.Pregnant);
					else model.Pregnant.element.destroyWarning();
				});
				lstWarnDestroyFn.push(function () {
					model.Sex.handle.dispose();
					model.Sex.handle = null;
				});
			}
			missing = true;
		}
		if (model.RDT() === '' && model.Microscopy() === '') {
			showWarning(model.RDT);
			showWarning(model.Microscopy);
			if (model.RDT.handle == null || model.Microscopy.handle == null) {
				model.RDT.handle = model.RDT.subscribe(() => {
					if (model.RDT() === '' && model.Microscopy() === '') {
						showWarning(model.RDT);
						showWarning(model.Microscopy);
					} else {
						model.RDT.element.destroyWarning();
						model.Microscopy.element.destroyWarning();
					}
				});
				model.Microscopy.handle = model.Microscopy.subscribe(() => {
					if (model.RDT() === '' && model.Microscopy() === '') {
						showWarning(model.RDT);
						showWarning(model.Microscopy);
					} else {
						model.RDT.element.destroyWarning();
						model.Microscopy.element.destroyWarning();
					}
				});
				lstWarnDestroyFn.push(function () {
					model.RDT.handle.dispose();
					model.RDT.handle = null;
					model.Microscopy.handle.dispose();
					model.Microscopy.handle = null;
				});
			}
			missing = true;
		}
		if (model.Treatment() == null) { showWarning(model.Treatment); missing = true; }
		if (model.Treatment() == 'Other' && model.OtherTreatment() === '') {
			showWarning(model.OtherTreatment);
			if (model.Treatment.handle == null) {
				model.Treatment.handle = model.Treatment.subscribe(() => {
					if (model.Treatment() == 'Other' && model.OtherTreatment() === '') showWarning(model.OtherTreatment);
					else model.OtherTreatment.element.destroyWarning();
				});
				lstWarnDestroyFn.push(function () {
					model.Treatment.handle.dispose();
					model.Treatment.handle = null;
				});
			}
			missing = true;
		}
		if (model.Result() === '') { showWarning(model.Result); missing = true; }

		return missing;
	}

	self.saveReport = function () {
		var missing = false;
		firstWarnElement = null;

		var details = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed);
		details.forEach(d => {
			if (warnDetail(d)) missing = true;
		});

		var m = self.master();
		if (m.NumberPositive() === '') { showWarning(m.NumberPositive); missing = true; }
		if (m.NumberRDT() === '') { showWarning(m.NumberRDT); missing = true; }
		if (m.NumberMicroscopy() === '') { showWarning(m.NumberMicroscopy); missing = true; }

		if (missing) {
			app.showMsg('<kh>ខ្វះទិន្នន័យ</kh> - Missing Data', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh><br><br>Please input data in red box');
			var top = $(firstWarnElement).offset().top;
			if (top < window.scrollY || top > window.scrollY + window.innerHeight - 50) {
				window.scrollTo(window.scrollX, top - 80);
			}
			return;
		}
		removeAllWarning();

		details = self.detailList().filter(r => r.Rec_ID() != -1);
		var count = details.length;
		if (count != parseInt(m.NumberPositive())) {
			showWarning(m.NumberPositive);
			app.showMsg('<kh>ចំនួនករណីវិជ្ជមាន មិនស្មើគ្នា</kh><br>Positive Cases Not Matched', '<kh>សូមត្រួតពិនិត្យករណីវិជ្ចមាន និង ចំនួនសរុបឡើងវិញ</kh><br><br>Please check positive cases and total number again');
			return;
		}

		count = details.filter(r => r.RDT() !== '').length;
		if (count > parseInt(m.NumberRDT())) {
			showWarning(m.NumberRDT);
			app.showMsg('<kh>ករណីតេស្តរហ័ស មិនអាចច្រើនជាង ចំនួនសរុប</kh><br>RDT Cases Can\'t Be More Than Total Number', '<kh>សូមត្រួតពិនិត្យករណីតេស្តរហ័ស(' + count + ') និង ចំនួនសរុបឡើងវិញ</kh><br><br>Please check RDT cases(' + count + ') and total number again');
			return;
		}

		count = details.filter(r => r.Microscopy() !== '').length;
		if (count > parseInt(m.NumberMicroscopy())) {
			showWarning(m.NumberMicroscopy);
			app.showMsg('<kh>ករណីតេមីក្រូទស្សន៍ មិនអាចច្រើនជាង ចំនួនសរុប</kh><br>Microscope Cases Can\'t Be More Than Total Number', '<kh>សូមត្រួតពិនិត្យករណីមីក្រូទស្សន៍(' + count + ') និង ចំនួនសរុបឡើងវិញ</kh><br><br>Please check microscope cases(' + count + ') and total number again');
			return;
		}

		var submit = {
			master: {
				ID: currentReport.id,
				Year: self.year(),
				Month: currentReport.month,
				NumberTests: parseInt(m.NumberPositive()) + parseInt(m.NumberNeg()),
				NumberPositive: m.NumberPositive(),
				NumberNeg: m.NumberNeg(),
				NumberRDT: m.NumberRDT(),
				NumberMicroscopy: m.NumberMicroscopy()
			},
			details: []
		};

		var defaultDate = self.year() + '-' + currentReport.month + '-01';

		details = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed);
		details.forEach(d => {
			submit.details.push({
				Rec_ID: d.Rec_ID(),
				DateCase: d.DateCase() == null ? defaultDate : d.DateCase().format('YYYY-MM-DD'),
				Name: d.Name(),
				Sex: d.Sex(),
				Age: d.Age(),
				Participant: d.Participant(),
				SickQty: d.SickQty(),
				ClinicSign: d.ClinicSign() ? 1 : 0,
				Severe: d.Status() == 'Severe' ? 1 : 0,
				Pregnant: d.Pregnant(),
				RDT: d.RDT(),
				Microscopy: d.Microscopy(),
				Treatment: d.Treatment(),
				OtherTreatment: d.Treatment() == 'Other' ? d.OtherTreatment() : '',
				Referred: d.Result() == 'Referred' ? 1 : 0,
				Dead: d.Result() == 'Dead' ? 1 : 0,
				Bednet: d.Bednet() ? 1 : 0,
				Note: d.Note(),
				TreatmentPlace: d.TreatmentPlace()
			});
		});

		deletedList.forEach(d => submit.details.push({ Rec_ID: d.Rec_ID() * -1 }));

		app.ajax('plUpdateCase', { submit: JSON.stringify(submit) }).done(function () {
			currentReport.has(true);
			self.back(true);
		});
	};

	self.deleteReport = function () {
		app.showDelete(function () {
			var submit = {
				where: {
					ID: currentReport.id,
					Year: self.year(),
					Month: currentReport.month,
				}
			};

			app.ajax('plDeleteReport', submit).done(function () {
				currentReport.has(false);
				self.back(true);
			});
		});
	};

	self.deleteCase = function (model) {
		if (model.Rec_ID() > 0) {
			deletedList.push(model);
		}
		self.detailList.remove(model);
	};

	self.resetCase = function (model) {
		ready = false;
		self.detailList.remove(model);
		self.detailList.push(convertObj(createObj()));
		ready = true;
	};

	self.back = function (dontAsk) {
		if (dontAsk !== true) {
			var mchanged = self.master().changed;
			var dchanged = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed).length > 0;
			var deleted = deletedList.length > 0;
			if (mchanged || dchanged || deleted) {
				showSave(() => setTimeout(self.saveReport, 100), () => self.back(true));
				return;
			}
		}

		changeURL({ year: self.year(), prov: self.prov() });
		self.isListView(true);
		$(window).scrollTop(lastScrollTop);
	};

	self.getMinDate = function () {
		return moment(self.master().month, 'MM-YYYY').subtract(1, 'months');
	};

	self.getMaxDate = function () {
		var mo = moment(self.master().month, 'MM-YYYY');
		mo.date(mo.daysInMonth());
		return mo.month() == today.month() && mo > today ? today : mo;
	};

	self.getDefaultDate = function () {
		return moment(self.master().month, 'MM-YYYY');
	};

	self.visibleReport = function (model) {
		return model.has() || self.year() < today.year() || (self.year() == today.year() && parseInt(model.month) <= today.month() + 1);
	};

	var lstWarnDestroyFn = [];
	function showWarning(bindingValue) {
		var el = $(bindingValue.element);

		function addError() {
			el.css('border', '2px solid red');
		}

		function removeError() {
			el.css('border', '');
		}

		function checkValue() {
			bindingValue() == null || bindingValue() === '' ? addError() : removeError();
		}

		function destroy() {
			if (el.data('warnEvent') != null) el.data('warnEvent').dispose();
			el.data('warnEvent', null);
			removeError();
		}
		addError();

		if (firstWarnElement == null) firstWarnElement = el[0];

		if (el.data('warnEvent') != null) return;
		el.data('warnEvent', bindingValue.subscribe(checkValue))
		el[0].destroyWarning = destroy;
		lstWarnDestroyFn.push(destroy);
	};

	function removeAllWarning() {
		lstWarnDestroyFn.forEach(function (fn) { fn(); });
		lstWarnDestroyFn = [];
	};

	function changeURL(obj) {
		var search = location.pathname.split('/').last() + (obj == null ? '' : '?s=' + JSON.stringify(obj));
		window.history.replaceState(null, null, search);
	}

	function getURL() {
		var para = location.search.substr(3);
		return para != '' ? JSON.parse(decodeURI(para)) : null;
	}

	function showSave(callYes, callNo) {
		$('#modalSave').modal('show');
		$('#modalSave .btn-primary').off().click(callYes);
		$('#modalSave .btn-danger').off().click(callNo);
	};

	self.isSingle = function (arr) {
		return arr.length <= 1;
	};
}