function viewModel() {
    var self = this;
    var today = moment();

    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.reportList = ko.observableArray();
    self.master = ko.observable();
    self.dataByVMWList = ko.observableArray();
    self.data = ko.observable();

    self.year = ko.observable(today.year());
    self.od = ko.observable();
    self.hc = ko.observable();
    self.isListView = ko.observable(true);
    self.treatmentList = [];

    var prov = sessionStorage.code_prov;
    var currentReport = null;
    var ready = false;
    var firstWarnElement = null;
    var deletedList = [];
    var hcData = [];
    var lastScrollTop = 0;

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
        app.ajax('vwmDataAccuracyReport', submit).done(function (rs) {
            rs.vmws.forEach(vmw => {
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
            self.reportList(rs.vmws);

            if (url.id != null) {
                var report = rs.vmws.find(r => r.Code_Vill_T == url.id);
                report = report.reports[parseInt(url.month) - 1];
                self.editReport(report);
            }
        });
    };

    self.editReport = function (model) {

        changeURL({ year: self.year(), od: self.od(), hc: self.hc(), id: model.id, month: model.month });

        var submit = {
            id: model.id,
            year: self.year(),
            month: model.month,
            has: model.has()
        };

        app.ajax('vmwGetCase', submit).done(function (rs) {
            self.dataByVMWList(rs.detail);
        });

        if (model.has()) {
            app.ajax('vmwGetDataAccuracy', submit).done(prepare);
            
        } else {
            prepare({ detail: [] });
        }

        function prepare(rs) {
            // master
            var master = {};
            master.DateAdded = ko.observable(rs.DateAdded == null ? null : moment(rs.DateAdded));
            master.od = self.odList().find(r => r.code == self.od()).name;
            master.hc = self.hcList().find(r => r.code == self.hc()).name;
            master.en = model.en;
            master.kh = model.kh;
            master.month = model.month + '-' + self.year();
            master.has = model.has();
            master.createdby = model.has() ? rs.CreatedBy : app.user.username;
            // detail
            if (app.user.role.in('OD', 'AU', 'AUDITOR') && !model.has()) rs.detail = createObj();
            var d = {};

            self.master(master);

            d = rs.detail
            self.data(convertObj(d));

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
            //NumberRefered: "",
        };
    }

    function convertObj(r) {
        var obj = app.ko(r);
        return obj;
    }

    self.saveReport = function () {
        var missing = false;
        firstWarnElement = null;

        var m = self.master();
        if (m.DateAdded() == null) { showWarning(m.DateAdded); missing = true; }

        var d = self.data();

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
            //NumberReferred: d.NumberReferred(),
            CreatedBy: app.user.username,
        }

        var defaultDate = self.year() + '-' + currentReport.month + '-01';

        app.ajax('vmwUpdateDataAccuracy', { submit: JSON.stringify(submit) }).done(function () {
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

            app.ajax('vmwDataAccuracyDeleteRpt', submit).done(function () {
                currentReport.has(false);
                self.back(true);
            });
        });
    };

    self.back = function (dontAsk) {
        changeURL({ year: self.year(), od: self.od(), hc: self.hc() });
        self.isListView(true);
        $(window).scrollTop(lastScrollTop);
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
    
    self.getPFByVMW = function () {
        return self.dataByVMWList().filter(r => r.Rec_ID != -1 && r.Diagnosis == 'F').length;
    }
    self.getPVByVMW = function () {
        return self.dataByVMWList().filter(r => r.Rec_ID != -1 && r.Diagnosis == 'V').length;
    }
    self.getMixByVMW = function () {
        return self.dataByVMWList().filter(r => r.Rec_ID != -1 && r.Diagnosis == 'M').length;
    }
    self.getTestByVMW = function () {
        return self.dataByVMWList().filter(r => r.Rec_ID != -1).length;
    };

    self.getPositiveByVMW = function () {
        return self.dataByVMWList().filter(r => r.Rec_ID != -1 && r.Diagnosis != 'N').length;
    };

    self.getNegativeByVMW = function () {
        return self.dataByVMWList().filter(r => r.Rec_ID != -1 && r.Diagnosis == 'N').length;
    };
    self.getReferedByVMW = function () {
        return self.dataByVMWList().filter(r => r.Rec_ID != -1 && r.Refered == 1).length;
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
}