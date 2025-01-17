function viewModel() {
    var self = this;

    ko.validation.init({
        registerExtenders: true,
        messagesOnModified: true,
        insertMessages: false,
        parseInputAttributes: true,
        messageTemplate: null,
        errorElementClass: 'input-error',
        errorClass: 'message-error',
        decorateElementOnModified: true,
        decorateInputElement: true
    }, true);

    self.errors = ko.validation.group(this, { deep: true, observable: false });

	var today = moment();

	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.reportList = ko.observableArray();
	self.master = ko.observable();
	self.detailList = ko.observableArray();
	self.moveModel = ko.observable();
	self.inputPlaceModel = ko.observable();

	self.year = ko.observable(today.year());
	self.od = ko.observable();
	self.hc = ko.observable();
	self.isListView = ko.observable(true);
	self.treatmentList = [];
	self.RdtImagePath = ko.observable();

	var prov = sessionStorage.code_prov;
	var currentReport = null;
	var ready = false;
	var firstWarnElement = null;
	var deletedList = [];
	var hcData = [];
	var lastScrollTop = 0;
	var place = null;
	var vmwLog = [];

	app.getPlace(['pv', 'od', 'hc', 'ds', 'cm', 'vl'], function (p) {
		p.pv = p.pv.filter(r => r.target == 1);
		p.od = p.od.filter(r => r.target == 1);
		place = p;

		app.ajax('vmwGetPreData', { prov: prov }).done(function (rs) {
			hcData = rs.hc;
			self.odList(rs.od);
			self.treatmentList = rs.treatmentList

			var url = getURL();
			if (url != null) {
				self.year(url.year);
				self.od(url.od);
				self.hc(url.hc);
			}
		});
	});

	self.previousYear = function () {
		self.year(self.year() - 1);
		self.getReport();
	};

	self.nextYear = function () {
		self.year(self.year() + 1);
		self.getReport();
	};

	self.od.subscribe(function (code) {
		self.hcList(hcData.filter(r => r.od == code));
	});

	self.hc.subscribe(function () {
		self.getReport();
	});

	self.getReport = function () {
		var url = getURL() || {};
		if (self.hc() != null) {
			url.year = self.year();
			url.od = self.od();
			url.hc = self.hc();
		} else {
			url = null;
		}
		changeURL(url);

		if (self.hc() == null) {
			self.reportList([]);
			return;
		}

		var submit = { year: self.year(), hc: self.hc() };
		app.ajax('vmwGetReport', submit).done(function (rs) {
			vmwLog = rs.vmws;
			var vmws = vmwLog.distinct(r => r.Code_Vill_T);
			vmws.forEach(vmw => {
				vmw.reports = [];
				for (var i = 1; i <= 12; i++) {
					var m = ('0' + i).substr(-2);
					var obj = {
						id: vmw.Code_Vill_T,
						en: vmw.Name_Vill_E,
						kh: vmw.Name_Vill_K,
						month: m,
						has: ko.observable(rs.reports.some(r => r.ID == vmw.Code_Vill_T && r.Month == m))
					};
					vmw.reports.push(obj);
				}
			});
			self.reportList(vmws);

			if (url.id != null) {
				var report = vmws.find(r => r.Code_Vill_T == url.id);
				if (report != null) {
					report = report.reports[parseInt(url.month) - 1];
					self.editReport(report);
				} else {
					self.back(true);
				}
			}
		});
	};

	self.editReport = function (model) {
		changeURL({ year: self.year(), od: self.od(), hc: self.hc(), id: model.id, month: model.month });

		if (model.has()) {
			var submit = {
				id: model.id,
				year: self.year(),
				month: model.month,
				has: model.has()
			};

			app.ajax('vmwGetCase', submit).done(prepare);
		} else {
			prepare({ detail: [] });
		}

		function prepare(rs) {
			// master
			var master = {};
			master.od = self.odList().find(r => r.code == self.od()).nameK;
			master.hc = self.hcList().find(r => r.code == self.hc()).nameK;
			master.vl = model.kh;
			master.month = ko.observable(moment(model.month + '-' + self.year(), 'MM-YYYY'));
			master.has = model.has();
			master.noTest = master.has && rs.detail.length == 0;
			master.changed = false;

			// detail
			if (app.user.role.in('OD', 'AU')) rs.detail.push(createObj());
			var details = [];
			rs.detail.forEach(r => details.push(convertObj(r)));

			ready = false;
			self.master(master);
			self.detailList(details);

			details.forEach(r => {
				app.setNumberOnly(r.Age.element, 'int');
				app.setNumberOnly(r.Weight.element, 'float');
				app.setNumberOnly(r.Temperature.element, 'float');
				app.setNumberOnly(r.G6PDHb.element, 'float');
				app.setNumberOnly(r.G6PDdL.element, 'float');
				app.setNumberOnly(r.Primaquine15.element, 'int');
				app.setNumberOnly(r.Primaquine75.element, 'int');
				app.setNumberOnly(r.Primaquine.element, 'int');
				app.setNumberOnly(r.ASMQ.element, 'int');
			});
			ready = true;

			currentReport = model;
			deletedList = [];
			lastScrollTop = $(window).scrollTop();
			self.isListView(false);
			$(window).scrollTop(0);

			master.month.subscribe(function (value) {
				if (value.year() == self.year()) {
					var found = self.reportList().find(r => r.Code_Vill_T == currentReport.id);
					self.editReport(found.reports[value.month()]);
				} else {
					var url = getURL();
					url.month = value.format('MM');
					changeURL(url);

					self.year(value.year());
					self.getReport();
				}
			});
		}
	};

	self.addCase = function (model) {
		if (model.Diagnosis != 'S' && warnDetail(model)) {
			app.showMsg('<kh>ខ្វះទិន្នន័យ</kh> - Missing Data', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh><br><br>Please input data in red box');
			return;
		}
		removeAllWarning();

		model.Rec_ID(0);

		ready = false;
		var newModel = convertObj(createObj());
		self.detailList.push(newModel);
		
		app.setNumberOnly(newModel.Age.element, 'int');
		app.setNumberOnly(newModel.Weight.element, 'float');
		app.setNumberOnly(newModel.Temperature.element, 'float');
		app.setNumberOnly(newModel.Primaquine.element, 'int');
		app.setNumberOnly(newModel.ASMQ.element, 'int');
        ready = true;

        newModel.skipFirst = true;
        newModel.Address.popObject.villClick(newModel, { currentTarget: $('.btnvill').last()[0] });
	};

	function createObj() {
		let obj = {
			Rec_ID: -1,
			NameK: '',
            PatientPhone: null,
            Address: null,
			Age: '',
			AgeType: 'Y',
			Sex: 'M',
			PregnantMTHS: null,
			Treatment: null,
			OtherTreatment: '',
			ASMQ: null,
            Primaquine: null,
            Refered: 0,
            ReferredFromService: null,
            ReferredFromServiceOther: null,
			ReferedReason: null,
			ReferedOtherReason: null,
			ReferedStudy: 0,
			Dead: 0,
			Diagnosis: null,
			Mobile: 0,
            DateCase: null,
            SymptomDate: null,
			DOT1: false,
			Remark: '',
			Weight: '',
			Temperature: '',
			Is_Mobile_Entry: false,
			Passive: false,
			PatientCode: null,
			G6PD: null,
			PQTreatment: null,
			G6PDHb: null,
			G6PDdL: null,
			IsConsult: false,
			IsACT: false,
			IsPrimaquine: false,
			Primaquine15: null,
			Primaquine75: null,
			PrimaquineDate: null,
			Relapse: 0,
			L1: 0,
			LC: null,
			IMP: null,
			LC_Code: null,
			IMP_Text: null,
			Fingerprint: null,
			RdtImage: null,
            Exclude: 0,
            EverHadMalaria: 0,
            Recrudescence: 0,
            LocallyAcquired: 0,
            DomesticallyImported: 0,
            InternationalImported: 0,
            Suspect: 0,
            PregnantTest: null,
            HbD0: null,
            HbD3: null,
			HbD7: null
        };

        var lst = self.detailList().filter(r => r.Rec_ID() == 0 && r.Address() != '999' && r.Address() != null);
        if (lst.length > 0) obj.Address = lst.last().Address().substr(0, 6);

        return obj;
	}

	function convertObj(r) {
		if (r.Treatment != null && !self.treatmentList.contain(r.Treatment)) {
			r.OtherTreatment = r.Treatment;
			r.Treatment = 'Other';
		}
		r.Refered = r.Refered == 1;
		r.ReferedStudy = r.ReferedStudy == 1;
		r.Dead = r.Dead == 1;
		r.Mobile = r.Mobile == 'Y';
		r.Passive = r.Passive == 1;
		r.IsConsult = r.IsConsult == 'Yes';
		r.IsACT = r.IsACT == 'Yes';
		r.IsPrimaquine = r.IsPrimaquine == 1;
		r.Relapse = r.Relapse == 1;
        r.L1 = r.L1 == 1;
        r.EverHadMalaria = r.EverHadMalaria == 1;

        r.Recrudescence = r.Recrudescence == 1;
        r.LocallyAcquired = r.LocallyAcquired == 1;
        r.DomesticallyImported = r.DomesticallyImported == 1;
        r.InternationalImported = r.InternationalImported == 1;

        r.Suspect = true;

		r.LCList = [
			{
				code: (r.LC_Code || 'No') == 'No' ? 'Yes' : r.LC_Code,
				name: (r.LC_Code || 'No') == 'No' ? 'Yes' : self.getVill(r.LC_Code)
			},
			{ code: 'Change', name: 'Change' },
			{ code: 'No', name: 'No' }
		];

		var obj = app.ko(r);
        if (obj.DateCase() != null) obj.DateCase(moment(obj.DateCase()));

        bindPopAddress(obj.Address);

		obj.LC_Code.old = obj.LC_Code();

		obj.Sex.subscribe(() => obj.PregnantMTHS(''));

		obj.Diagnosis.subscribe(d => {
			if (d == 'V' || d == 'M') {
				setTimeout(() => {
					app.setNumberOnly(obj.G6PDHb.element, 'float');
					app.setNumberOnly(obj.G6PDdL.element, 'float');
					app.setNumberOnly(obj.Primaquine15.element, 'int');
					app.setNumberOnly(obj.Primaquine75.element, 'int');
				});
			}
		});

		obj.ReferedReason.subscribe(() => obj.ReferedStudy(false));

		obj.LC_Code.subscribe(value => {
			if (value == null || value == 'No') {
				obj.LCList([{ code: 'Yes', name: 'Yes' }, { code: 'No', name: 'No' }]);
				obj.LC_Code.old = value;
			} else if (value == 'Yes' || value == 'Change') {
				var model = {
					pvList: ko.observableArray(place.pv),
					dsList: ko.observableArray(),
					cmList: ko.observableArray(),
					vlList: ko.observableArray(),
					pv: ko.observable(),
					ds: ko.observable(),
					cm: ko.observable(),
					vl: ko.observable(),
					other: ko.observable('')
				};

				model.pv.subscribe(function (code) {
					model.dsList(place.ds.filter(r => r.pvcode == code));
				});

				model.ds.subscribe(function (code) {
					model.cmList(place.cm.filter(r => r.dscode == code));
				});

				model.cm.subscribe(function (code) {
					model.vlList(place.vl.filter(r => r.cmcode == code));
				});

				var code = obj.LC_Code.old || '';
				if (!isNaN(code)) {
					var pv, ds, cm, vl;

					if (code.length == 10) {
						var found = place.vl.find(r => r.code == code);
						if (found != null) {
							vl = code;
							code = found.cmcode;
						}
					}
					if (code.length == 6) {
						var found = place.cm.find(r => r.code == code);
						if (found != null) {
							cm = code;
							code = found.dscode;
						}
					}
					if (code.length == 4) {
						var found = place.ds.find(r => r.code == code);
						if (found != null) {
							ds = code;
							code = found.pvcode;
						}
					}
					if (code.length == 2) {
						var found = place.pv.find(r => r.code == code);
						if (found != null) pv = code;
					}
					if (pv != null) model.pv(pv);
					if (ds != null) model.ds(ds);
					if (cm != null) model.cm(cm);
					if (vl != null) model.vl(vl);
				} else if (code != 'No') {
					model.other(code);
				}

				self.inputPlaceModel(model);
				$('#modalInputPlace').modal('show');

				self.inputPlaceOKClick = function () {
					var code = null;

					if (model.vl() != null) code = model.vl();
					else if (model.cm() != null) code = model.cm();
					else if (model.ds() != null) code = model.ds();
					else if (model.pv() != null) code = model.pv();

					if (code != null) {
						obj.LCList([
							{ code: code, name: self.getVill(code) },
							{ code: 'Change', name: 'Change' },
							{ code: 'No', name: 'No' }
						]);
					} else if (model.other().trim() != '') {
						code = model.other().trim();
						obj.LCList([
							{ code: code, name: code },
							{ code: 'Change', name: 'Change' },
							{ code: 'No', name: 'No' }
						]);
					}

					obj.LC_Code(code);
					obj.LC_Code.old = code;
				};

				self.inputPlaceCancelClick = function () {
					obj.LC_Code(obj.LC_Code.old);
				};
			}
		});

		obj.changed = false;
		for (var key in createObj()) {
			obj[key].subscribe(function () {
				if (ready) obj.changed = true;
			});
		}

		return obj;
	}

    function bindPopAddress(column) {
        var po = column.popObject = {
            popVisible: ko.observable(false),
            villWarn: ko.observable(false),
            province: ko.observable(null),
            district: ko.observable(null),
            commune: ko.observable(null),
            village: ko.observable(null),
            provList: ko.observableArray(place.pv),
            distList: ko.observableArray(),
            commList: ko.observableArray(),
            villList: ko.observableArray(),
            base: column
        };

        po.province.subscribe(code => {
            po.distList(place.ds.filter(x => x.pvcode == code));

            if (code != null) column(code);
            else if (column() == null || column() == '999' || isNaN(column())) return;
            else column(null);
        });
        po.district.subscribe(code => {
            po.commList(place.cm.filter(x => x.dscode == code));

            if (code != null) column(code);
            else if (po.province() != null) column(po.province());
        });
        po.commune.subscribe(code => {
            po.villList(place.vl.filter(x => x.cmcode == code));

            if (code != null) column(code);
            else if (po.district() != null) column(po.district());
        });
        po.village.subscribe(code => {
            if (po.commune() == null) return;

            if (code != null) column(code);
            else column(po.commune());
        });

        var code = column();
        if (code != null && code != '999') {
            var vcode, ccode, dcode, pcode;
            if (code.length == 10) {
                vcode = code;
                var found = place.vl.find(r => r.code == code);
                if (found != null) code = found.cmcode;
            }
            if (code.length == 6) {
                ccode = code;
                var found = place.cm.find(r => r.code == code);
                if (found != null) code = found.dscode;
            }
            if (code.length == 4) {
                dcode = code;
                var found = place.ds.find(r => r.code == code);
                if (found != null) code = found.pvcode;
            }
            if (code.length == 2) pcode = code;

            if (pcode != null) po.province(pcode);
            if (dcode != null) po.district(dcode);
            if (ccode != null) po.commune(ccode);
            if (vcode != null) po.village(vcode);
        }

        po.villClick = function (model, event) {
            if (po.popVisible()) return;
            po.popVisible(true);

            var func = function () {
                if (model.skipFirst === true) {
                    model.skipFirst = false;
                    return;
                }
				var ele = $(event.currentTarget);

				if (!ele.next().is(':hover')) {
					
				} else {
					$(document).off('click', null, func);
					po.popVisible(false);
                }
            };

            setTimeout(function () {
                $(document).on('click', func);
            });
		};

		po.ok = function () {
			po.popVisible(false);
        }

        po.unknownClick = function () {
            if (column() == '999') {
                column(null);
            } else {
                column('999');
                po.province(null);
            }
            return true;
        };

        po.noClick = function () {
            if (column() == 'No') {
                column(null);
            } else {
                column('No');
                po.province(null);
            }
            return true;
        };
    }

	function warnDetail(model) {
        var missing = false;
        if (model.Diagnosis() == 'S') return false;
		if (model.Age() === '' || (parseInt(model.Age()) > 12 && model.AgeType() == 'M')) { showWarning(model.Age); missing = true; }
		if (model.Diagnosis() === '') { showWarning(model.Diagnosis); missing = true; }

		if (model.Diagnosis() != 'N') {
			if (trim(model.NameK()) === '') { showWarning(model.NameK); missing = true; }
            if (model.DateCase() == null) { showWarning(model.DateCase); missing = true; }
            if (model.SymptomDate() == null) { showWarning(model.SymptomDate); missing = true; }

			if (model.Sex() == 'F' && model.PregnantMTHS() === '') {
				showWarning(model.PregnantMTHS);
				if (model.Sex.handle == null) {
					model.Sex.handle = model.Sex.subscribe(() => {
						if (model.Sex() == 'F' && model.PregnantMTHS() === '') showWarning(model.PregnantMTHS);
						else model.PregnantMTHS.element.destroyWarning();
					});
					lstWarnDestroyFn.push(function () {
						model.Sex.handle.dispose();
						model.Sex.handle = null;
					});
				}
				missing = true;
			}
			if (model.Weight() === '') { showWarning(model.Weight); missing = true; }
			if (model.Temperature() === '') { showWarning(model.Temperature); missing = true; }
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

			if (checkClassifyWarning(model, true)) missing = true;
		}

		return missing;
	}

	self.saveReport = function () {
		var missing = false;
		firstWarnElement = null;

		var details = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed);
		details.forEach(d => {
			if (warnDetail(d)) missing = true;
		});

		if (missing) {
			app.showMsg('<kh>ខ្វះទិន្នន័យ</kh> - Missing Data', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh><br><br>Please input data in red box');
			var top = $(firstWarnElement).offset().top;
			if (top < window.scrollY || top > window.scrollY + window.innerHeight - 50) {
				window.scrollTo(window.scrollX, top - 80);
			}
			return;
		}
		removeAllWarning();

		var submit = {
			master: {
				ID: currentReport.id,
				Year: self.year(),
				Month: currentReport.month
			},
			details: []
		};

		details.forEach(d => {
			if (d.Diagnosis() == 'N') {
				submit.details.push({
					Rec_ID: d.Rec_ID(),
					YearCase: submit.master.Year,
					MonthCase: submit.master.Month,
                    PatientPhone: null,
					Age: isempty(d.Age(), null),
					AgeType: isempty(d.AgeType(), null),
					Sex: d.Sex(),
					Positive: 'N',
					Refered: 0,
					ReferedStudy: 0,
					Dead: 0,
					Diagnosis: d.Diagnosis(),
					DOT1: 0,
					Weight: 0,
					Temperature: 0,
                    Passive: d.Passive() ? 1 : 0,
                    Suspect: d.Suspect() ? 1 : 0
				});
            } else if (d.Diagnosis() == 'S') {
                submit.details.push({
                    Rec_ID: d.Rec_ID(),
                    Diagnosis: d.Diagnosis(),
                    Positive: 'S',
                    YearCase: submit.master.Year,
                    MonthCase: submit.master.Month,
                    NameK: null,
                    PatientPhone: null,
                    Address: null,
                    Suspect: d.Suspect() ? 1 : 0,
                    Refered: 0,
                    Dead: 0,
                })
            }
            else {
				submit.details.push({
					Rec_ID: d.Rec_ID(),
					YearCase: d.DateCase().format('YYYY'),
					MonthCase: d.DateCase().format('MM'),
					NameK: d.NameK(),
                    PatientPhone: d.PatientPhone(),
                    Address: d.Address(),
					Age: d.Age(),
					AgeType: d.AgeType(),
					Sex: d.Sex(),
					PregnantMTHS: d.PregnantMTHS(),
					Positive: 'P',
					Treatment: d.Treatment(),
					ASMQ: d.Treatment() == 'ASMQ' || d.Treatment() == 'ASMQ + PQ' ? d.ASMQ() : 0,
					Primaquine: d.Treatment() == 'ASMQ + PQ' ? d.Primaquine() : 0,
                    Refered: d.ReferedReason() ? 1 : 0,
                    ReferedReason: d.ReferedReason(),
                    ReferedOtherReason: d.ReferedReason() == 'Other' ? trim(d.ReferedOtherReason()) : '',
                    ReferedStudy: d.ReferedReason() == 'Other' && d.ReferedStudy() ? 1 : 0,
                    ReferredFromService: d.ReferredFromService(),
                    ReferredFromServiceOther: d.ReferredFromService() == 'Other' ? trim(d.ReferredFromServiceOther()) : '',
                    Dead: d.Dead() ? 1 : 0,
					Diagnosis: d.Diagnosis(),
					Mobile: d.Mobile() ? 'Y' : 'N',
                    DateCase: d.DateCase().format('YYYY-MM-DD'),
                    SymptomDate: d.SymptomDate().format('YYYY-MM-DD'),
					DOT1: d.DOT1() ? 1 : 0,
					OtherTreatment: d.Treatment() == 'Other' ? trim(d.OtherTreatment()) : null,
					Remark: d.Remark(),
					Weight: d.Weight(),
					Temperature: d.Temperature(),
					Passive: d.Passive() ? 1 : 0,
					G6PD: d.G6PD(),
					PQTreatment: d.PQTreatment(),
					PatientCode: d.Diagnosis() == 'F' ? null : d.PatientCode(),
                    G6PDHb: d.Diagnosis() == 'F' ? null : d.G6PDHb() == '' ? null : d.G6PDHb(),
                    G6PDdL: d.Diagnosis() == 'F' ? null : d.G6PDdL() == '' ? null : d.G6PDdL(),
					IsConsult: d.Diagnosis() == 'F' ? null : d.IsConsult() ? 'Yes' : 'No',
					IsACT: d.Diagnosis() == 'F' ? null : d.IsACT() ? 'Yes' : 'No',
					IsPrimaquine: d.Diagnosis() == 'F' ? null : d.IsPrimaquine() ? '1' : '0',
					Primaquine15: d.Diagnosis() == 'F' ? null : d.Primaquine15(),
					Primaquine75: d.Diagnosis() == 'F' ? null : d.Primaquine75(),
					PrimaquineDate: d.Diagnosis() == 'F' ? null : d.PrimaquineDate()?.format('YYYY-MM-DD'),
                    EverHadMalaria: d.EverHadMalaria() ? 1:0,
					Relapse: d.Relapse() ? 1 : 0,
					L1: d.L1() ? 1 : 0,
					LC: d.LC_Code() != null && d.LC_Code() != 'No' ? 1 : 0,
					IMP: trim(d.IMP_Text()) != '' ? 1 : 0,
					LC_Code: d.LC_Code(),
					IMP_Text: trim(d.IMP_Text()),
                    Exclude: d.Exclude(),

                    Recrudescence: d.Recrudescence() ? 1 : 0,
                    LocallyAcquired: d.LocallyAcquired() ? 1 : 0,
                    DomesticallyImported: d.DomesticallyImported() ? 1 : 0,
                    InternationalImported: d.InternationalImported() ? 1 : 0,
                    Suspect: d.Suspect() ? 1 : 0,
                    PregnantTest: !d.Diagnosis().in('V', 'M', 'O') ? null : d.PregnantTest(),
                    HbD0: !d.Diagnosis().in('V', 'M', 'O') ? null : d.HbD0() == '' ? null : d.HbD0(),
                    HbD3: !d.Diagnosis().in('V', 'M', 'O') ? null : d.HbD3() == '' ? null : d.HbD3(),
					HbD7: !d.Diagnosis().in('V', 'M', 'O') ? null : d.HbD7() == '' ? null : d.HbD7(),
				});
			}
		});
		deletedList.forEach(d => submit.details.push({ Rec_ID: d.Rec_ID() * -1 }));

		app.ajax('vmwUpdateCase', { submit: JSON.stringify(submit) }).done(function () {
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

			app.ajax('vmwDeleteReport', submit).done(function () {
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
		if (dontAsk !== true && app.user.role.in('OD', 'AU')) {
			var mchanged = self.master().changed;
			var dchanged = self.detailList().filter(r => r.Rec_ID() != -1 && r.changed).length > 0;
			var deleted = deletedList.length > 0;
			if (mchanged || dchanged || deleted) {
				showSave(() => setTimeout(self.saveReport, 100), () => self.back(true));
				return;
			}
		}

		changeURL({ year: self.year(), od: self.od(), hc: self.hc() });

		if (window.opener == null) {
			self.isListView(true);
			$(window).scrollTop(lastScrollTop);
		} else {
			window.close();
		}
	};

	self.getTop = function (ele) {
		return ($(ele).prev().position().top + 22) + 'px';
	};

	self.getLeft = function (ele) {
		return ($(ele).prev().position().left - 10) + 'px';
	};

	self.getVill = function (code) {
		if (code == null || code === '') return '';
		if (code == 'No') return code;
		var found = code.length == 10 ? place.vl.find(r => r.code == code)
			: code.length == 6 ? place.cm.find(r => r.code == code)
			: code.length == 4 ? place.ds.find(r => r.code == code)
			: code.length == 2 ? place.pv.find(r => r.code == code)
			: null;

		return found == null ? code : found.name;
	};

	self.getMinDate = function () {
		return self.master().month().clone().subtract(1, 'month');
	};

	self.getMaxDate = function () {
		var mo = self.master().month().clone();
		mo.date(mo.daysInMonth());
		return mo.month() == today.month() && mo > today ? today : mo;
	};

	self.getDefaultDate = function () {
		return self.master().month();
	};

	self.visibleReport = function (model) {
		return model.has() || vmwLog.some(r => r.Code_Vill_T == model.id && r.Month == model.month);
	};

	self.getTest = function () {
		return self.detailList().filter(r => r.Rec_ID() != -1 && r.Diagnosis() != 'S').length;
	};

	self.getPositive = function () {
		return self.detailList().filter(r => r.Rec_ID() != -1 && !r.Diagnosis().in('N', 'S')).length;
	};

	self.getNegative = function () {
		return self.detailList().filter(r => r.Rec_ID() != -1 && r.Diagnosis() == 'N').length;
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
	}

	self.isSingle = function (arr) {
		return arr.length <= 1;
	};

	self.showMoveData = function (row, event) {
		var model = {
			pvList: ko.observableArray(place.pv),
			odList: ko.observableArray(),
			hcList: ko.observableArray(),
			vlList: ko.observableArray(),
			yearList: ko.observableArray(),
			monthList: ko.observableArray(),
			pv: ko.observable(),
			od: ko.observable(),
			hc: ko.observable(),
			vl: ko.observable(),
			year: ko.observable(self.year()),
			month: ko.observable(),
			detail: event.currentTarget.name == 'move detail' ? row : null
		};

		for (var i = 2017; i <= moment().year() ; i++) {
			model.yearList.push(i);
		}
		for (var i = 1; i <= 12; i++) {
			model.monthList.push(('0' + i).substr(-2));
		}

		model.pv.subscribe(function (code) {
			model.odList(place.od.filter(r => r.pvcode == code));
		});
		model.od.subscribe(function (code) {
			model.hcList(place.hc.filter(r => r.odcode == code));
		});
		model.hc.subscribe(function (code) {
			model.vlList(place.vl.filter(r => r.hccode == code));
		});

		model.pv(prov);
		model.od(self.od());
		model.hc(self.hc());
		model.vl(currentReport.id);

		self.moveModel(model);
		$('#modalMove').modal('show');
	};

	self.moveData = function () {
		var model = self.moveModel();

		var missing = false;
		['pv', 'od', 'hc', 'vl', 'year', 'month'].forEach(name => {
			if (model[name]() == null) {
				app.showWarning(model[name].element);
				if (!missing) model[name].element.focus();
				missing = true;
			}
		});
		if (missing) return;
		$('#modalMove').modal('hide');

		var submit = {
			from: {
				ID: currentReport.id,
				Year: self.year(),
				Month: currentReport.month,
			},
			to: {
				ID: model.vl(),
				Year: model.year(),
				Month: model.month()
			},
			detail_id: isnot(model.detail, null, r => r.Rec_ID())
		};

		if (['ID', 'Year', 'Month'].every(r => submit.from[r] == submit.to[r])) return;

		app.ajax('vmwMoveData', submit).done(function () {
			if (model.detail == null) {
				currentReport.has(false);
				self.back(true);
			} else {
				self.detailList.remove(model.detail);
			}

			if (model.year() == self.year()) {
				var found = self.reportList().find(r => r.Code_Vill_T == model.vl());
				if (found != null) found.reports.find(r => r.month == model.month()).has(true);
			}
		});
    };

    
    self.everHadMalariaClick = function (model) {
        model.Relapse(false);
        model.DomesticallyImported(false);
        model.LocallyAcquired(false);
        model.InternationalImported(false);

        //checkClassifyWarning(model);
        return true;
    };

	self.relapseClick = function (model) {
        model.DomesticallyImported(false);
        model.LocallyAcquired(false);
        model.InternationalImported(false);

		checkClassifyWarning(model);
		return true;
    };

    self.RecrudescenceClick = function (model) {
        model.Relapse(false);
        model.DomesticallyImported(false);
        model.LocallyAcquired(false);
        model.InternationalImported(false);

        checkClassifyWarning(model);
        return true;
    };

	self.L1Click = function (model) {
		model.LC(false);
		model.IMP(false);

		checkClassifyWarning(model);
		return true;
    };

    self.LocallyAcquiredClick = function (model) {
        model.DomesticallyImported(false);
        model.InternationalImported(false);

        checkClassifyWarning(model);
        return true;
    };

    self.LCClick = function (model) {
        model.L1(false);
        model.IMP(false);
        checkClassifyWarning(model);
        return true;
    };

    self.DomesticallyImportedClick = function (model) {
        model.LocallyAcquired(false);
        model.InternationalImported(false);
        checkClassifyWarning(model);
        return true;
    };

    self.IMPClick = function (model) {
        model.L1(false);
        model.LC(false);
        checkClassifyWarning(model);
        return true;
    };

    self.InternationalImportedClick = function (model) {
        model.LocallyAcquired(false);
        model.DomesticallyImported(false);
        checkClassifyWarning(model);
        return true;
    };

	self.LCChange = function (model) {
		if (model.LC_Code() == 'Yes') model.IMP_Text(null);

		checkClassifyWarning(model);
	};

	self.IMPChange = function (model) {
		checkClassifyWarning(model);
	};

	self.visibleReactive = function (model) {
		if (model.Rec_ID() == -1 || model.Relapse()) return false;
		if (model.Diagnosis() == 'V' && model.L1()) return true;

		var isLC = (model.LC_Code() || 'No') != 'No';
		return model.Diagnosis().in('F', 'M') && (model.L1() || isLC || !isnullempty(trim(model.IMP_Text())));
	};

	self.viewRdtImage = function (model) {
		if (model.RdtImage == undefined) return;
		self.RdtImagePath(null);
		$('#RdtImage').modal('show');

		setTimeout(() => self.RdtImagePath(model.RdtImage()));
	};

	function checkClassifyWarning(model, needReturn) {
        function check() {
            if (model.Relapse() || model.Recrudescence() || model.LocallyAcquired() || model.DomesticallyImported() || model.InternationalImported()) {
                if (model.Diagnosis() == 'V') $(model.Relapse.elements[0]).siblings('div:first').hide();
                else if (model.Diagnosis() == 'F') $(model.Recrudescence.elements[0]).siblings('div:first').hide();
                else $(model.LocallyAcquired.elements[0]).siblings('div:first').hide();
				return false;
            } else {
                if (model.Diagnosis() == 'V') $(model.Relapse.elements[0]).siblings('div:first').show();
                else if (model.Diagnosis() == 'F') $(model.Recrudescence.elements[0]).siblings('div:first').show();
                else $(model.LocallyAcquired.elements[0]).siblings('div:first').show();
                
                if (firstWarnElement == null) firstWarnElement = model.LocallyAcquired.elements[0];
				return true;
			}
		}

		if (needReturn === true) return check();
		setTimeout(check);
	}

	self.inputPlaceOKClick = () => { };
    self.inputPlaceCancelClick = () => { };

    //Worm
    self.worm = ko.observable();
    self.showWorm = function () {
        $.when(getWorm()).then(function () {
            $('#modalWorm').modal('show');
        })
    }

    function getWorm() {
        let submit = {
            Code_Vill_T: currentReport.id,
            Month: currentReport.month,
            Year: self.year()
        }

        app.ajax('getWorm', { submit: submit }).done(function (rs) {
            if (rs) {
                self.worm(app.ko(rs));
            } else {
                self.worm(new setWorm());
            }
        })
    }

    function setWorm() {
        return {
            Code_Vill_T: ko.observable(),
            Year: ko.observable(self.year()),
            Month: ko.observable(),
            WormStockStart: ko.observable().extend({ required: true }),
            WormStockIn: ko.observable().extend({ required: true }),
            WormStockOut: ko.observable().extend({ required: true }),
            WormBalance: ko.observable().extend({ required: true }),
            WormPeopleReceived: ko.observable().extend({ required: true }),
            WormFemaleReceived: ko.observable().extend({ required: true }),
            AbetStockIn: ko.observable().extend({ required: true }),
            AbetFamilyReceived: ko.observable().extend({ required: true }),
        }
    }

    self.saveWorm = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = app.unko(self.worm());
        model.Code_Vill_T = currentReport.id;
        model.Month = currentReport.month;

        app.ajax('saveWorm', { submit: model }).done(function () {
            $('#modalWorm').modal('hide');
        })
    }

    //Education

    self.education = ko.observable();
    self.showEdu = function () {
        $.when(getEdu()).then(function () {
            $('#modalEdu').modal('show');
        })
    }

    function getEdu() {
        let submit = {
            Code_Vill_T: currentReport.id,
            Month: currentReport.month,
            Year: self.year()
        }

        app.ajax('getEdu', { submit: submit }).done(function (rs) {
            if (rs) {
                self.education(app.ko(rs));
            } else {
                self.education(new setEdu());
            }
        })
    }

    self.saveEdu = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = app.unko(self.education());
        model.Code_Vill_T = currentReport.id;
        model.Month = currentReport.month;

        app.ajax('saveEdu', { submit: model }).done(function () {
            $('#modalEdu').modal('hide');
        })
    }

    function setEdu() {
        return {
            Code_Vill_T: ko.observable(),
            Year: ko.observable(self.year()),
            Month: ko.observable(),
            Dangue: ko.observable().extend({ required: true }),
            DangueFemale: ko.observable().extend({ required: true }),
            DangueTime: ko.observable().extend({ required: true }),
            Worm: ko.observable().extend({ required: true }),
            WormFemale: ko.observable().extend({ required: true }),
            WormTime: ko.observable().extend({ required: true }),
            Malaria: ko.observable().extend({ required: true }),
            MalariaFemale: ko.observable().extend({ required: true }),
            MalariaTime: ko.observable().extend({ required: true }),
            RepellentStockStart: ko.observable().extend({ required: true }),
            RepellentStockIn: ko.observable().extend({ required: true }),
            RepellentStockOut: ko.observable().extend({ required: true }),
            RepellentBalance: ko.observable().extend({ required: true }),
        }
    }

    //Commodity
    self.showCommodity = function () {
        $.when(getCommodity()).then(function() {
            $('#modalCommodity').modal('show');
        })
    }

    self.commodities = ko.observableArray();
    function getCommodity() {
        let submit = {
            Code_Vill_T: currentReport.id,
            Month: currentReport.month,
            Year: self.year()
        }
        app.ajax('getCommodity', { submit: submit }).done(function(rs) {
            let ls = rs.map(r => {
                r = app.ko(r);
                r.Total = ko.pureComputed(function() {
                    let stockOut = r.StockOut() ? r.StockOut() : 0;
                    let rs = parseInt(r.StockStart()) - parseInt(stockOut)
                    return isNaN(rs) ? null : rs;
                });
                r.Balance = ko.pureComputed(function() {
                    let stockIn = r.StockIn() ? r.StockIn() : 0;
                    let stockOut = r.StockOut() ? r.StockOut() : 0;
                    let rs = parseInt(r.StockStart()) + parseInt(stockIn) - parseInt(stockOut)
                    return isNaN(rs) ? null : rs;
                });

                return r;
            })

            self.commodities(ls);
        })
    }

    self.saveCommodity = function() {
        let model = {};
        let commodities = app.unko(self.commodities());
        model.Code_Vill_T = currentReport.id;
        model.Year = self.year();
        model.Month = currentReport.month;
        model.Commodities = commodities;

        app.ajax('saveCommodity', { submit: model }).done(function() {
            $('#modalCommodity').modal('hide');
        })
    }
}