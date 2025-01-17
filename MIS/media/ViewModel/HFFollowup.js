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

    self.listModel = ko.observableArray();
    self.detailModel = ko.observable();
    self.view = ko.observable('list');

    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.yearList = [];
    self.monthList = [];
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.year = ko.observable(moment().year());
    self.month = ko.observable();
    self.new = ko.observable(false);
    self.patient = ko.observable();

    var prov = sessionStorage.code_prov;
    var place = null;
    var mainData = [];
    var dataChanged = false;
    var currentReport = null;

    for (var i = 2018; i <= moment().year() ; i++) {
        self.yearList.push(i);
    }
    for (var i = 1; i <= 12; i++) {
        self.monthList.push(('0' + i).substr(-2));
    }

    self.getReport = function () {
        var submit = {
            y: self.year(),
            od: app.user.od == '' ? self.od() : app.user.od,
            prov: prov
        }

        app.ajax('/HFFollowup/getData', submit).done(function (rs) {
            mainData = rs;
            mainData.forEach(r => {
                r.Day3 = ko.observable(r.Day3 || r.D3);
                r.Day7 = ko.observable(r.Day7 || r.D7);
                r.Day14 = ko.observable(r.Day14);
                r.W2 = ko.observable(r.W2);
                r.W3 = ko.observable(r.W3);
                r.W4 = ko.observable(r.W4);
                r.W5 = ko.observable(r.W5);
                r.W6 = ko.observable(r.W6);
                r.W7 = ko.observable(r.W7);
                r.W8 = ko.observable(r.W8);
            });
            self.listModel(mainData);
        });
    }

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        place = p;

        self.odList(place.od.filter(r => r.pvcode == prov || r.code == app.user.od));

        self.getReport();
    });

    self.showDetail = function (model) {
        var day = event.target.attributes.param.nodeValue;
        var submit = { patientCode: model.PatientCode, day: day, caseID: model.Case_ID };
        app.ajax('/HFFollowup/getDetail', submit).done(function (rs) {
            self.patient(rs.patient);
            if (rs.followup == null) {
                model.Day = day
                self.detailModel(createObj(model));
                self.new(true);
            } else {
                var temp = rs.followup.Code;
                temp = isnullempty(temp) ? [] : Array.isArray(temp) ? temp : temp.split(', ');
                rs.followup.Code = ko.observableArray(temp);

                rs.followup.Call = rs.followup.Call == 'Yes';
                rs.followup.Refered = rs.followup.Refered == 'Yes';
                currentReport = rs;
                self.detailModel(app.ko(rs.followup));
                self.new(false);
            }
        });

        self.view('detail');
    };

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }
        var model = self.detailModel();
        model = app.unko(model);

        model.Code = model.Code.join(', ');
        model.Call = model.Call ? 'Yes' : 'No';
        model.Refered = model.Refered ? 'Yes' : 'No';

        var submit = { submit: JSON.stringify(model) };
        app.ajax('/HFFollowup/save', submit).done(function (rs) {
            if (model.Rec_ID == "") {
                var r = self.listModel().find(r => r.Case_ID == model.Case_ID)
                r.Day3(rs.Day3);
                r.Day7(rs.Day7);
                r.Day14(rs.Day14);
                r.W2(rs.W2);
                r.W3(rs.W3);
                r.W4(rs.W4);
                r.W5(rs.W5);
                r.W6(rs.W6);
                r.W7(rs.W7);
                r.W8(rs.W8);
                //self.listModel().remove(x);
                //self.listModel.push(rs)
                //_.replace(self.listModel(), { PatientCode: r.PatientCode }, rs);
            } else {

            }
            self.view('list');
        });
    };

    _.replace = function (collection, identity, replacement) {
        var index = _.indexOf(collection, _.find(collection, identity));
        collection.splice(index, 1, replacement);
    };

    function createObj(submit) {
        return {
            Code_Vill_T: ko.observable(submit.Code_Vill_T),
            Rec_ID: ko.observable(''),
            Case_ID: ko.observable(submit.Case_ID),
            PatientCode: ko.observable(submit.PatientCode == null ? submit.Case_ID : submit.PatientCode).extend({ required: { message: 'សូមបញ្ចូលលេខកូដអ្នកជម្ងឺ​ ឲ្យដូចក្នុងទម្រង់រាយការណ៍ករណីគ្រុនចាញ់' }, }),
            Day: ko.observable(submit.Day),
            Date: ko.observable('').extend({ required: { message: 'សូមបញ្ចូលថ្ងៃខែឆ្នាំ' }, }),
            Call: ko.observable(0),
            Refered: ko.observable(0),
            Code: ko.observableArray([]).extend({ required: { message: 'សូមជ្រើសរើសឲ្យបានត្រឹមត្រូវ' }, }),
            TabletRemain: ko.observable(null),
        }
    }

    self.deleteDay = function () {
        var model = currentReport;
        model = app.unko(model);
        app.showDelete(function () {
            submit = { submit: JSON.stringify(model) };

            app.ajax('/HFFollowup/delete', submit).done(function (rs) {
                var r = self.listModel().find(r => r.Case_ID == model.followup.Case_ID)
                r.Day3(rs.Day3);
                r.Day7(rs.Day7);
                r.Day14(rs.Day14);
                r.W2(rs.W2);
                r.W3(rs.W3);
                r.W4(rs.W4);
                r.W5(rs.W5);
                r.W6(rs.W6);
                r.W7(rs.W7);
                r.W8(rs.W8);
                self.view('list');
            });
        });
    };

    self.back = function () {
        if (dataChanged) {
            $('#modalSave').modal('show');
            $('#modalSave .btn-primary').off().click(self.save);
            $('#modalSave .btn-danger').off().click(() => self.view('list'));
        } else {
            self.view('list');
        }
    };

    self.pv.subscribe(function (code) {
        var before = self.od();
        self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
        if (self.od() == before) filterListModel();
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
        self.getReport();
    });

    self.hc.subscribe(filterListModel);
    self.year.subscribe(filterListModel);
    self.month.subscribe(filterListModel);

    self.year.subscribe(function () {
        self.getReport();
    });

    function filterByYear() {
        var submit = {
            y: self.year()
        }

        app.ajax('/Followup/getData', submit).done(function (rs) {
            mainData = rs;
            self.listModel(mainData);
        });
    }

    function filterListModel() {
        var list = mainData.filter(r => r.Year == self.year());

        if (self.month() != null) list = list.filter(r => r.Month == self.month());

        if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
        else if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
        else if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());

        self.listModel(list);
    }

    self.getODName = function (code) {
        var found = place.od.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getHCName = function (code) {
        var found = place.hc.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVLName = function (code) {
        var found = place.vl.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getFollowupDate = function (model, day, type) {
        var date = model.PrimaquineDate || model.DateCase;
        let peroid = moment(date).add(day, type).format('DD-MM-YY') 
        return 'Create (' + peroid + ')';
    };
}