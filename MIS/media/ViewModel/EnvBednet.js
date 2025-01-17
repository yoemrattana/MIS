function viewModel() {
    var self = this;
    var today = moment();

    self.provList = ko.observableArray();
    self.officeList = ko.observableArray();
    self.reportList = ko.observableArray();
    self.master = ko.observable();
    self.detail = ko.observable();

    self.year = ko.observable(today.year());
    self.prov = ko.observable();
    self.office = ko.observable();
    self.isListView = ko.observable(true);

    var officeArr = [];
    var currentReport = null;
    var ready = false;
    var deletedList = [];
    var lastScrollTop = 0;

    app.ajax('envGetPreData').done(function (rs) {
        self.provList(rs.prov);
        officeArr = rs.office;
        var url = getURL();
        if (url != null) {
            self.year(url.year);
            self.prov(url.prov);
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
        let rs = officeArr.filter(r => r.Code_Prov_T == code);
        self.officeList(rs);
    });

    self.office.subscribe(function (code) {
        self.getReport();
    })

    self.getReport = function () {
        var url = getURL() || {};
        if (self.prov() != null) {
            url.year = self.year();
            url.prov = self.prov();
            url.office = self.office();
        } else {
            url = null;
        }
        changeURL(url);

        if (self.prov() == null) {
            self.reportList([]);
            return;
        }

        var submit = { year: self.year(), office: self.office() };
        app.ajax('bednetEnvGetReport', submit).done(function (rs) {
            
            rs.communities.forEach(community => {
                community.reports = [];
                for (var i = 1; i <= 12; i++) {
                    var m = ('0' + i).substr(-2);
                    var obj = {
                        id: community.Code_Community_T,
                        kh: community.Name_Community_K,
                        month: m,
                        has: ko.observable(rs.reports.some(r => r.Code_Community_T == community.Code_Community_T && r.Month == m))
                    };

                    community.reports.push(obj);
                }
            });
            self.reportList(rs.communities);

            if (url.id != null) {
                var report = rs.communities.find(r => r.Code_Troop_T == url.id);
                report = report.reports[parseInt(url.month) - 1];
                self.editReport(report);
            }
        });
    };

    self.editReport = function (model) {
        changeURL({ year: self.year(), prov: self.prov(), id: model.id, month: model.month });

        if (model.has()) {
            var submit = {
                id: model.id,
                year: self.year(),
                month: model.month,
                has: model.has()
            };

            app.ajax('bednetEnvGetCase', submit).done(prepare);
        } else {
            prepare({ detail: null });
        }

        function prepare(rs) {
            // master
            var master = {};
            master.kh = model.kh;
            master.prov = self.provList().find(r => r.code == self.prov()).name;
            master.month = model.month + '-' + self.year();
            master.has = model.has();
            master.changed = false;

            ready = false;
            self.master(master);

            if (rs.detail == null) rs.detail = createObj();
            self.detail(app.ko(rs.detail));

            app.setNumberOnly(self.detail().LLIN.element, 'int');
            app.setNumberOnly(self.detail().LLIHN.element, 'int');
            ko.track(self.detail());
            ready = true;

            currentReport = model;
            lastScrollTop = $(window).scrollTop();
            self.isListView(false);
            $(window).scrollTop(0);
        }
    };

    function createObj() {
        return {
            Rec_ID: -1,
            LLIN: '',
            LLIHN: '',
            Mobile: false,
            ID: ''
        };
    }

    function warnDetail(model) {
        var missing = false;
        if (model.LLIN() == '') { showWarning(model.LLIN); missing = true; }
        if (model.LLIHN() === '') { showWarning(model.LLIHN); missing = true; }

        return missing;
    }

    self.saveReport = function () {
        var missing = false;
        var d = self.detail();

        if (warnDetail(d)) missing = true;

        if (missing) {
            app.showMsg('<kh>ខ្វះទិន្នន័យ</kh> - Missing Data', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh><br><br>Please input data in red box');
            return;
        }

        removeAllWarning();

        var submit = {
            Code_Community_T: currentReport.id,
            Year: self.year(),
            Month: currentReport.month,
            Rec_ID: d.Rec_ID(),
            LLIN: d.LLIN(),
            LLIHN: d.LLIHN()
        }

        app.ajax('bednetEnvUpdateCase', { submit: JSON.stringify(submit) }).done(function () {
            currentReport.has(true);
            self.back(true);
        });
    };

    self.deleteReport = function () {
        app.showDelete(function () {
            var submit = {
                where: {
                    Code_Community_T: currentReport.id,
                    Year: self.year(),
                    Month: currentReport.month,
                }
            };

            app.ajax('bednetEnvDeleteReport', submit).done(function () {
                currentReport.has(false);
                self.back(true);
            });
        });
    };

    self.back = function (dontAsk) {
        if (dontAsk !== true) {
            var dchanged = ko.isDirty(self.detail());
            if (dchanged) {
                showSave(() => setTimeout(self.saveReport, 100), () => self.back(true));
                return;
            }
        }

        changeURL({ year: self.year(), prov: self.prov() });
        self.isListView(true);
        $(window).scrollTop(lastScrollTop);
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