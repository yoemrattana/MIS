function viewModel() {
    var self = this;
    var today = moment();

    self.reportList = ko.observableArray();
    self.treatmentList = [];

    var ready = false;
    var firstWarnElement = null;
    var deletedList = [];
    var lastScrollTop = 0;

    var urlSegment = location.pathname.split('/');
    var q13ID = urlSegment[3]
    var place = decodeURI(urlSegment[4]);
    var villCode = urlSegment[5];

    var s = { rec_id: q13ID, location: place };
    getCases(s);
    function getCases(submit) {
        app.ajax('/Question/getQ13Cases/', submit).done(function (rs) {
            self.treatmentList = rs.treatmentList;
            var data = [];
            ready = false;
            rs.cases.push(createObj());
            rs.cases.forEach(r=>data.push(convertObj(r)));
            self.reportList(data);
            data.forEach(r => {
                app.setNumberOnly(r.Age.element, 'int');
                app.setNumberOnly(r.Weight.element, 'int');
                app.setNumberOnly(r.Temperature.element, 'float');
            });
            ready = true;
        });
    }

    function createObj() {
        return {
            Rec_ID: -1,
            NameK: '',
            Age: '',
            AgeType: 'Y',
            Sex: 'M',
            PregnantMTHS: null,
            Treatment: null,
            Refered: false,
            Dead: false,
            Diagnosis: null,
            Mobile: 0,
            DateCase: null,
            DOT3: false,
            OtherTreatment: '',
            Remark: '',
            Weight: '',
            Temperature: '',
            Is_Mobile_Entry: false,
            Passive: false,
        };
    }

    function convertObj(r) {
        if (r.Treatment != null && !self.treatmentList.contain(r.Treatment)) {
            r.OtherTreatment = r.Treatment;
            r.Treatment = 'Other';
        }
        r.Refered = r.Refered == 1;
        r.Dead = r.Dead == 1;
        r.Mobile = r.Mobile == 'Y';

        var obj = app.ko(r);
        if (obj.DateCase() != null) obj.DateCase(moment(obj.DateCase()));

        obj.Sex.subscribe(() => obj.PregnantMTHS(''));

        obj.changed = false;
        for (var key in createObj()) {
            obj[key].subscribe(function () {
                if (ready) obj.changed = true;
            });
        }

        return obj;
    }

    self.addCase = function (model) {
        if (warnDetail(model)) {
            app.showMsg('<kh>ខ្វះទិន្នន័យ</kh> - Missing Data', '<kh>សូមបញ្ចូលទិន្នន័យក្នុងប្រអប់ក្រហម</kh><br><br>Please input data in red box');
            return;
        }
        removeAllWarning();

        model.Rec_ID(0);

        ready = false;
        var newModel = convertObj(createObj());
        self.reportList.push(newModel);

        app.setNumberOnly(newModel.Age.element, 'int');
        app.setNumberOnly(newModel.Weight.element, 'int');
        app.setNumberOnly(newModel.Temperature.element, 'int');

        ready = true;
    };

    self.resetCase = function (model) {
        ready = false;
        self.reportList.remove(model);
        self.reportList.push(convertObj(createObj()));
        ready = true;
    };

    self.deleteCase = function (model) {
        app.showDelete(function () {
            if (model.Rec_ID() > 0) {
                deletedList.push(model);
            }
            self.reportList.remove(model);
        });
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

    function warnDetail(model) {
        var missing = false;

        if (model.Diagnosis() != 'N') {
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
        }

        if (model.Age() === '' || (parseInt(model.Age()) > 12 && model.AgeType() == 'M')) { showWarning(model.Age); missing = true; }
        if (model.Diagnosis() === '') { showWarning(model.Diagnosis); missing = true; }

        return missing;
    }

    self.saveReport = function () {
        var missing = false;
        firstWarnElement = null;

        var details = self.reportList().filter(r => r.Rec_ID() != -1 && r.changed);
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
        var submit = [];
        details.forEach(d => {
            if (d.Diagnosis() == 'N') {
                submit.push({
                    ID: villCode,
                    Rec_ID: d.Rec_ID(),
                    NameK: null,
                    Age: isempty(d.Age(), null),
                    AgeType: isempty(d.AgeType(), null),
                    Sex: d.Sex(),
                    PregnantMTHS: null,
                    Positive: 'N',
                    Treatment: null,
                    Refered: 0,
                    Dead: 0,
                    Diagnosis: d.Diagnosis(),
                    Mobile: null,
                    DateCase: null,
                    DOT3: 0,
                    OtherTreatment: null,
                    Remark: null,
                    Weight: 0,
                    Temperature: 0,
                    Passive: d.Passive(),
                    Q13ID: q13ID,
                    Location: place
                });
            } else {
                submit.push({
                    ID: villCode,
                    Code_Vill_t: villCode,
                    Rec_ID: d.Rec_ID(),
                    NameK: d.NameK(),
                    Age: d.Age(),
                    AgeType: d.AgeType(),
                    Sex: d.Sex(),
                    PregnantMTHS: d.PregnantMTHS(),
                    Positive: 'P',
                    Treatment: d.Treatment(),
                    Refered: d.Refered() ? 1 : 0,
                    Dead: d.Dead() ? 1 : 0,
                    Diagnosis: d.Diagnosis(),
                    Mobile: d.Mobile() ? 'Y' : 'N',
                    DateCase: d.DateCase() == null ? defaultDate : d.DateCase().format('YYYY-MM-DD'),
                    DOT3: d.DOT3() ? 1 : 0,
                    OtherTreatment: d.Treatment() == 'Other' ? d.OtherTreatment() : '',
                    Remark: d.Remark(),
                    Weight: d.Weight(),
                    Temperature: d.Temperature(),
                    Passive: d.Passive(),
                    Q13ID: q13ID,
                    Location: place
                });
            }
        });

        deletedList.forEach(d => submit.push({ Rec_ID: d.Rec_ID() * -1 }));

        app.ajax('/Question/q13UpdateCase', { submit: JSON.stringify(submit) }).done(function () {
            getCases(s);
        });
    };

    self.back = function (dontAsk) {
        if (dontAsk !== true && app.user.role.in('OD', 'AU')) {
            var dchanged = self.reportList().filter(r => r.Rec_ID() != -1 && r.changed).length > 0;
            var deleted = deletedList.length > 0;
            if (dchanged || deleted) {
                showSave(() => setTimeout(self.saveReport, 100), () => self.back(true));
                return;
            }
        }
        $(window).scrollTop(lastScrollTop);
        close();
    };

    function showSave(callYes, callNo) {
        $('#modalSave').modal('show');
        $('#modalSave .btn-primary').off().click(callYes);
        $('#modalSave .btn-danger').off().click(callNo);
    }
}