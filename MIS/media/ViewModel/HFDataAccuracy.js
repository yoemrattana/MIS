function viewModel() {
    var self = this;
    var today = moment();

    self.odList = ko.observableArray();
    self.reportList = ko.observableArray();
    self.master = ko.observable();
    self.dataByHFList = ko.observableArray();
    self.data = ko.observable();

    self.year = ko.observable(today.year());
    self.od = ko.observable();
    self.isListView = ko.observable(true);
    self.treatmentList = [];

    var prov = sessionStorage.code_prov;
    var currentReport = null;
    var ready = false;
    var firstWarnElement = null;
    var deletedList = [];
    var lastScrollTop = 0;
    var place = null;

    app.getPlace(['pv', 'od', 'ds', 'cm', 'vl'], function (p) {
        place = p;
        self.odList(place.od.filter(r => (r.pvcode == prov || r.code == app.user.od) && r.target == 1));

        app.ajax('hfGetPreData').done(function (rs) {
            self.treatmentList = rs.treatmentList
            ready = true;

            var url = getURL();
            if (url != null) {
                self.year(url.year);
                self.od(url.od);
            }
            if (self.odList().length == 1) self.getReport();
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

    self.od.subscribe(function () {
        if (ready) self.getReport();
    });

    self.getReport = function () {
        var url = getURL() || {};
        if (self.od() != null) {
            url.year = self.year();
            url.od = self.od();
        } else {
            url = null;
        }
        changeURL(url);

        if (self.od() == null) {
            self.reportList([]);
            return;
        }

        var submit = { year: self.year(), od: self.od() };
        app.ajax('hfDataAccuracyReport', submit).done(function (rs) {
            rs.hfs.forEach(hf => {
                hf.reports = [];
                for (var i = 1; i <= 12; i++) {
                    var m = ('0' + i).substr(-2);
                    var obj = {
                        id: hf.Code_Facility_T,
                        en: hf.Name_Facility_E,
                        kh: hf.Name_Facility_K,
                        month: m,
                        has: ko.observable(rs.reports.some(r => r.ID == hf.Code_Facility_T && r.Month == m))
                    };
                    hf.reports.push(obj);
                }
            });
            self.reportList(rs.hfs);

            if (url.id != null) {
                var report = rs.hfs.find(r => r.Code_Facility_T == url.id);
                report = report.reports[parseInt(url.month) - 1];
                self.editReport(report);
            }
        });
    };

    self.editReport = function (model) {
        changeURL({ year: self.year(), od: self.od(), id: model.id, month: model.month });
        var submit = {
            id: model.id,
            year: self.year(),
            month: model.month,
            has: model.has(),
        };

        app.ajax('hfGetCase', submit).done(function (rs) {
            self.dataByHFList(rs.detail);
        });

        if (model.has()) {
            app.ajax('hfGetDataAccuracy', submit).done(prepare);
        } else {
            prepare({ detail: [] });
        }

        function prepare(rs) {
            // master
            var master = {};
            master.DateAdded = ko.observable(rs.DateAdded == null ? null : moment(rs.DateAdded));
            master.od = self.odList().find(r => r.code == self.od()).name;
            master.en = model.en;
            master.kh = model.kh;
            master.month = model.month + '-' + self.year();
            master.has = model.has();
            master.createdby = model.has() ? rs.CreatedBy : app.user.username;

            // detail
            if (app.user.role.in('OD', 'AU', 'AUDITOR') && !model.has()) rs.detail = createObj();

            ready = false;

            self.master(master);

            self.data(convertObj(rs.detail));

            ready = true;

            currentReport = model;
            deletedList = [];
            lastScrollTop = $(window).scrollTop();
            self.isListView(false);
            $(window).scrollTop(0);
        }
    };

    function createObj() {
        return {
            NumberPF: "",
            NumberPV: "",
            NumberMix: "",
            NumberTest: "",
            NumberPositive: "",
            NumberNegative: "",
            IncludedSpecies: false,
        };
    }

    function convertObj(r) {
        var obj = app.ko(r);
        return obj;
    }

    function warnDetail(model) {
        var missing = false;

        if (model.Diagnosis() != 'N') {
            if (model.Code_Vill_t() == null) {
                var po = model.Code_Vill_t.popObject;
                po.villWarn(true);
                if (model.Code_Vill_t.handle == null) {
                    model.Code_Vill_t.handle = model.Code_Vill_t.subscribe(v => po.villWarn(v == null));
                    lstWarnDestroyFn.push(function () {
                        model.Code_Vill_t.handle.dispose();
                        model.Code_Vill_t.handle = null;
                        po.villWarn(false);
                    });
                }
                if (firstWarnElement == null) firstWarnElement = model.DateCase.element;
                missing = true;
            }

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
            if (model.DiagnosisText() === '') { showWarning(model.DiagnosisText); missing = true; }
            if (model.ServiceText() === '') { showWarning(model.ServiceText); missing = true; }
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
        }

        if (model.Age() === '' || (parseInt(model.Age()) > 12 && model.AgeType() == 'M')) { showWarning(model.Age); missing = true; }
        if (model.Test() === '') { showWarning(model.Test); missing = true; }
        if (model.Diagnosis() === '') { showWarning(model.Diagnosis); missing = true; }

        return missing;
    }

    self.saveReport = function () {
        var missing = false;
        firstWarnElement = null;

        var m = self.master();
        var d = self.data();

        if (m.DateAdded() == null) { showWarning(m.DateAdded); missing = true; }

        if (d.NumberTest() === "") { showWarning(d.NumberTest); missing = true; }
        if (d.NumberNegative() === "") { showWarning(d.NumberNegative); missing = true; }

        if (d.IncludedSpecies()) {
            if (d.NumberPF() === "") { showWarning(d.NumberPF); missing = true; }
            if (d.NumberPV() === "") { showWarning(d.NumberPV); missing = true; }
            if (d.NumberMix() === "") { showWarning(d.NumberMix); missing = true; }
        } else {
            if (d.NumberPositive() === "" || isNaN(d.NumberPositive())) { showWarning(d.NumberPositive); missing = true; }
        }
        
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
            ID: currentReport.id,
            Year: self.year(),
            Month: currentReport.month,
            DateAdded: m.DateAdded().format('YYYY-MM-DD'),
            NumberPF: d.NumberPF() == "" ? null : d.IncludedSpecies() ? d.NumberPF() : null,
            NumberPV: d.NumberPV() == "" ? null : d.IncludedSpecies() ? d.NumberPV() : null,
            NumberMix: d.NumberMix() == "" ? null : d.IncludedSpecies() ? d.NumberMix() : null,
            NumberTest: d.NumberTest(),
            NumberPositive: d.NumberPositive(),
            NumberNegative: d.NumberNegative(),
            IncludedSpecies: d.IncludedSpecies(),
            CreatedBy: app.user.username,
        }

        app.ajax('hfUpdateDataAccuracy', { submit: JSON.stringify(submit) }).done(function () {
            currentReport.has(true);
            self.back(true);
        });
    };

    ko.computed(function () {
        if (self.data() != undefined) {
            var f = parseInt(self.data().NumberPF());
            var v = parseInt(self.data().NumberPV());
            var m = parseInt(self.data().NumberMix());
            var n = parseInt(self.data().NumberNegative());
            var p = parseInt(self.data().NumberPositive());
            var t = 0;

            var iscal = true;
            if (isNaN(f) || isNaN(v) || isNaN(m)) iscal = false;

            if (self.data().IncludedSpecies() && iscal) {
                p = f + v + m;
                t = f + v + m + n;
            } else {
                t = n + p;
            }
            self.data().NumberPositive(p);
            self.data().NumberTest(t);
        }
    });

    self.deleteReport = function () {
        app.showDelete(function () {
            var submit = {
                where: {
                    ID: currentReport.id,
                    Year: self.year(),
                    Month: currentReport.month,
                }
            };

            app.ajax('hfDataAccuracyDeleteReport', submit).done(function () {
                currentReport.has(false);
                self.back(true);
            });
        });
    };

    self.back = function (dontAsk) {
        changeURL({ year: self.year(), od: self.od() });
        self.isListView(true);
        $(window).scrollTop(lastScrollTop);
    };

    self.getTop = function (ele) {
        return ($(ele).prev().position().top + 22) + 'px';
    };

    self.getLeft = function (ele) {
        return ($(ele).prev().position().left - 10) + 'px';
    };

    self.visibleReport = function (model) {
        return model.has() || self.year() < today.year() || (self.year() == today.year() && parseInt(model.month) <= today.month() + 1);
    };

    self.getTest = function () {
        return _.isObject(self.data()) ? self.data().NumberPF + self.data().NumberPV + self.data().NumberMix + self.data().NumberNegative : 0
    }

    self.getPositive = function () {
        return _.isObject(self.data()) ? self.data().NumberPF + self.data().NumberPV + self.data().NumberMix : 0;
    }

    self.getNegative = function () {
        return _.isObject(self.data()) ? self.data().NumberNegative : 0;
    }

    self.getPFByHF = function () {
        return self.dataByHFList().filter(r => r.Rec_ID != -1 && r.Diagnosis == 'F').length;
    }
    self.getPVByHF = function () {
        return self.dataByHFList().filter(r => r.Rec_ID != -1 && r.Diagnosis == 'V').length;
    }
    self.getMixByHF = function () {
        return self.dataByHFList().filter(r => r.Rec_ID != -1 && r.Diagnosis == 'M').length;
    }
    self.getTestByHF = function () {
        return self.dataByHFList().filter(r => r.Rec_ID != -1).length;
    };
    self.getPositiveByHF = function () {
        return self.dataByHFList().filter(r => r.Rec_ID != -1 && r.Diagnosis != 'N').length;
    };
    self.getNegativeByHF = function () {
        return self.dataByHFList().filter(r => r.Rec_ID != -1 && r.Diagnosis == 'N').length;
    };
    self.getReferedByHF = function () {
        return self.dataByHFList().filter(r => r.Rec_ID != -1 && r.Refered == 1).length;
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
        return arr.length == 1;
    };
}