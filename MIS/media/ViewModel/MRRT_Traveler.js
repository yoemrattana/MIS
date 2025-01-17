function setQuestion(model) {
    return {
        Rec_ID: ko.observable(model?.Id || 0),
        Case_ID: ko.observable(model?.Rec_ID),
        Case_Type: ko.observable(model?.Type),
        PatientCode: ko.observable(model?.PatientCode).extend({ required: true }),
        PatientName: ko.observable(model?.NameK).extend({ required: true }),
        Age: ko.observable(model?.Age).extend({ required: true }),
        Sex: ko.observable(model?.Sex).extend({ required: true }),
        PatientPhone: ko.observable(),
        Diagnosis: ko.observable(model?.Diagnosis).extend({ required: true }),
        Classify: ko.observable().extend({ required: true }),
        PermanentAddress: ko.observable().extend({ required: true }),
        Address: ko.observable().extend({ required: true }),
        FollowupBy: ko.observable().extend({ required: true }),
        PositionFollowup: ko.observable().extend({ required: true }),
        DateRespone: ko.observable().extend({ required: true }),
        Code_Facility_T: ko.observable(model?.Code_Facility_T),
        Code_Prov_N: ko.observable(model?.Code_Prov_N),
        Code_OD_T: ko.observable(model?.Code_OD_T),
    }
}

function setMember() {
    return {
        Rec_ID: ko.observable(),
        Name: ko.observable().extend({ required: true }),
        Address: ko.observable().extend({ required: true }),
        Phone: ko.observable(),
        FollowerType: ko.observable(),
        FollowDateFrom: ko.observable(),
        FollowDateTo: ko.observable(),
        CalledDate: ko.observable(),
        CanContact: ko.observable(),
        IsSymptom: ko.observable(),
        Symptom: ko.observableArray([]),
        OtherSymptom: ko.observable(),
        WayForward: ko.observableArray([]),
        Parent_ID: ko.observable(),
    }
}
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
    self.membersModel = ko.observableArray([]);
    self.view = ko.observable('list');

    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.inputPlaceModel = ko.observable();
    self.yearList = [];
    self.monthList = [];
    self.year = ko.observable(moment().year());
    self.month = ko.observable();
    var place = null;
    var pvAll = [];
    var dataArr = [];

    var pvAll = [];
    var odAll = [];
    var hcAll = [];

    for (var i = 2024; i <= moment().year(); i++) {
        self.yearList.push(i);
    }

    for (var i = 1; i <= 12; i++) {
        self.monthList.push(('0' + i).substr(-2));
    }

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        pvAll = p.pv;
        hcAll = p.hc;
        odAll = p.od;
        vls = p.vl;

        place = p;
        if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

        var arr = place.od.map(r => r.pvcode).distinct();
        place.pv = place.pv.filter(r => arr.contain(r.code));
        self.pvList(place.pv);

        self.viewData()
    });

    self.viewData = function () {
        let submit = {
            pv: self.pv(),
            od: self.od(),
            hc: self.hc(),
            year: self.year(),
            month: self.month(),
        };

        app.ajax('/MRRT_Traveler/getData', submit).done(function (rs) {
            let data = rs.map(r => {
                r.Id = ko.observable(r.Id);
                r.ToOD = ko.observable(r.ToOD);
                return r;
            })
            dataArr = data
            self.listModel(dataArr);
        });
    }

    self.isDelete = ko.observable();
    self.viewDetail = function (model) {

        let submit = {
            Rec_ID: model.Rec_ID,
            Type: model.Type
        }
        self.isDelete(model.Id() ? true : false);
        app.ajax('/MRRT_Traveler/getDetail', submit).done(function (rs) {
            if (model.Id()) {
                self.detailModel(app.ko(rs.master));

                let members = rs.members.map(r => {
                    r.Symptom = isnullempty(r.Symptom) ? [] : Array.isArray(r.Symptom) ? r.Symptom : r.Symptom.split(', ');
                    r.WayForward = isnullempty(r.WayForward) ? [] : Array.isArray(r.WayForward) ? r.WayForward : r.WayForward.split(', ');
                    return app.ko(r)
                })

                self.membersModel(members)

            } else {
                self.detailModel(new setQuestion(model))
                self.membersModel.push(new setMember())
            }
            self.view('detail');
        });
    }

    self.addMember = function () {
        self.membersModel.push(new setMember());
    }

    self.removeMember = function (model) {
        self.membersModel.remove(model)
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let members = app.unko(self.membersModel()).map(r => {
            r.Symptom = r.Symptom.join(', ')
            r.WayForward = r.WayForward.join(', ')

            return r
        })

        let submit = {
            detail: app.unko(self.detailModel()),
            members: JSON.stringify(members)
        }

        app.ajax('/MRRT_Traveler/save', submit).done(function (rs) {
            let r = self.listModel().find(r => r.Rec_ID == submit.detail.Case_ID && r.Type == submit.detail.Case_Type);
            r.Id(rs);
            self.view('list')
        });
    }

    self.showDelete = function () {
        app.showDelete(function () {
            var submit = {
                table: 'tblMRRT_Traveler',
                where: { Rec_ID: self.detailModel().Rec_ID() }
            };
            submit = { submit: JSON.stringify(submit) };

            app.ajax('/Direct/delete', submit).done(function () {
                let r = self.listModel().find(r => r.Id() == self.detailModel().Rec_ID())
                r.Id(null);
                self.view('list');
            });
        });
    }

    self.pv.subscribe(function (code) {
        self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
    });

    self.getProvName = function (code) {
        var found = place.pv.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

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

    self.getProvName = function (code) {
        var found = place.pv.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.selectAddress = (root, event) => {
        var element = $(event.currentTarget);
        var param = element.attr('param');
        var obj = self.detailModel();
        $('#modalInputPlace').modal('show');

        var model = {
            isOther: ko.observable('0'),
            pvList: ko.observableArray(pvAll),
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

        model.isOther.subscribe(function (data) {
            if (data == 1) {
                model.pv(undefined)
                model.ds(undefined)
                model.cm(undefined)
                model.vl(undefined)
            } else {
                model.other(undefined)
            }
        });

        if (param == 'peraddress') {
            var code = obj.PermanentAddress.old || obj.PermanentAddress();
        } else if (param == 'address') {
            var code = obj.Address.old || obj.Address();
        } else if (param == 'addressrisk') {
            var code = root.AddressRisk.old || root.AddressRisk();
        } else if (param == 'addressstake') {
            var code = root.Address.old || root.Address();
        }

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
            model.isOther('0')
            if (pv != null) model.pv(pv);
            if (ds != null) model.ds(ds);
            if (cm != null) model.cm(cm);
            if (vl != null) model.vl(vl);
        } else if (code != 'No') {
            if (code != undefined) model.isOther('1')
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

            var village = '';
            if (code != null) {
                village = code;
            } else if (model.other().trim() != '') {
                village = model.other().trim();
            }

            if (param == 'peraddress') {
                obj.PermanentAddress(village);
                obj.PermanentAddress.old = code;
            } else if (param == 'address') {
                obj.Address(village);
                obj.Address.old = code;
            }  else if (param == 'addressstake') {
                root.Address(village);
                root.Address.old = code;
            }

        };

        self.inputPlaceCancelClick = function () {
            if (param == 'peraddress') obj.PermanentAddress(obj.PermanentAddress.old || obj.PermanentAddress());
            else if (param == 'address') obj.Address(obj.Address.old || obj.Address());
            else if (param == 'addressrisk') root.AddressRisk(root.AddressRisk.old || root.AddressRisk());
            else if (param == 'addressstake') root.Address(root.Address.old || root.Address());
        };
    }

    self.getVill = function (code) {
        if (code == null || code === '') return '';
        if (code == '999') return 'Unknown';
        var found = code.length == 10 ? place.vl.find(r => r.code == code)
            : code.length == 6 ? place.cm.find(r => r.code == code)
                : code.length == 4 ? place.ds.find(r => r.code == code)
                    : code.length == 2 ? place.pv.find(r => r.code == code)
                        : null;

        return found == null ? code : found.nameK;
    };

    self.back = function () {
        self.view('list');
    }

    self.getSpecie = function (specie) {
        return specie == 'F' ? 'Pf'
            : specie == 'V' ? 'Pv'
                : specie == 'M' ? 'Mix'
                    : specie == 'A' ? 'Pm'
                        : specie == 'O' ? 'Po'
                            : 'Pk';
    }

    self.dateFormat = function (date) {
        return moment(date).format('DD-MM-YYYY');
    }

    self.inputPlaceOKClick = () => { };
    self.inputPlaceCancelClick = () => { };

    var temp = '';
    self.radioClick = (model, e) => {
        let [name, index] = e.target.name.split('-')

        if (temp == model[name]()) {
            model[name]('');
        }
        temp = model[name]();
        return true;
    }

    self.month.subscribe(function (month) {
        let rs = dataArr.filter(r => r.Month == month)
        self.listModel(rs.length == 0 ? dataArr : rs)
    }) 

}


$("#modalTransfer").draggable({
    handle: ".modal-header"
});

$("#modalNote").draggable({
    handle: ".modal-header"
});