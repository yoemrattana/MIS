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
    var odAll = [];
    var dataArr = [];

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

        self.getData()
    });

    self.getData = () =>  {
        let submit = {
            pv: self.pv(),
            od: self.od(),
            hc: self.hc(),
            year: self.year(),
            month: self.month(),
        };

        app.ajax('/CiHf/getData', submit).done(function (rs) {
            let data = rs.map(r => {
                r.CI_ID = ko.observable(r.CI_ID);
                r.ToOD = ko.observable(r.ToOD);
                return r;
            })
            dataArr =data
            self.listModel(dataArr);
        });
    }

    self.isDelete = ko.observable();
    self.viewDetail = function (model) {
        let submit = {
            Rec_ID: model.Rec_ID,
            Type: model.Type
        }
        self.isDelete(model.CI_ID() ? true: false);
        app.ajax('/CiHf/getDetail', submit).done(function (rs) {
            if (model.CI_ID()) {
                let symptom = rs.Symptom;
                symptom = isnullempty(symptom) ? [] : Array.isArray(symptom) ? symptom : symptom.split(', ');
                rs.Symptom = symptom;

                self.detailModel(app.ko(rs));
            } else {
                self.detailModel(setQuestion(model))
            }
            self.view('detail');
            setTimeout(() => {
                $('input[numonly]').each(function () {
                    app.setNumberOnly(this, $(this).attr('numonly'));
                });
            }, 300)
        });
        
    }

    function setQuestion(model) {
        let item = {
            Rec_ID: ko.observable(model.CI_ID() || 0),
            Case_ID: ko.observable(model.Rec_ID),
            Case_Type: ko.observable(model.Type),
            PatientCode: ko.observable(model.PatientCode),
            DateCase: ko.observable(model.DateCase).extend({ required: true }),
            InvDate: ko.observable().extend({ required: true }),
            Diagnosis: ko.observable(model.Diagnosis).extend({ required: true }),
            PatientName: ko.observable(model.NameK).extend({ required: true }),
            PatientPhone: ko.observable(),
            Age: ko.observable(model.Age).extend({ required: true }),
            Sex: ko.observable(model.Sex).extend({ required: true }),
            Weight: ko.observable(model.Weight).extend({ required: true }),
            Address: ko.observable().extend({ required: true }),
            PermanentAddress: ko.observable().extend({ required: true }),
            Occupation: ko.observable(),
            OtherOccupation: ko.observable(),
            //part 2
            DetectionMethod: ko.observable(),
            OtherDetectionMethod: ko.observable(),
            EverPPMCure: ko.observable(),
            HCTest: ko.observable(),
            SymptomDate: ko.observable().extend({ required: true }),
            Symptom: ko.observableArray([]),
            OtherSymptom: ko.observable(),
            Q2Confirm: ko.observable(),
            //malaria and travel history
            EverHadMalaria: ko.observable(),
            OldDiagnosis: ko.observable(),
            SameDiagnosis: ko.observable(),
            EverHadfakv: ko.observable(),
            EverHadvo: ko.observable(),
            EverTreatfakv: ko.observable(),
            EverTreatvo: ko.observable(),

            ASMQfakvDay: ko.observable(),
            ASMQvoDay: ko.observable(),

            //ASMQPQfakvDay: ko.observable(),
            //ASMQPQvoDay: ko.observable(),

            ASMQSLDPfakvDay: ko.observable(),
            ASMQSLDPvoDay: ko.observable(),

            //RadicalCurefakvDay: ko.observable(),
            //RadicalCurevoDay: ko.observable(),

            RadicalCure7Dayfakv: ko.observable(),
            RadicalCure8Weekfakv: ko.observable(),
            RadicalCure7Dayvo: ko.observable(),
            RadicalCure8Weekvo: ko.observable(),

            RadicalCurefakvWeek: ko.observable(),
            RadicalCurevoWeek: ko.observable(),
            FAKVOther: ko.observable(),
            VOOther: ko.observable(),
            FAKVCompleted: ko.observable(),
            VOCompleted: ko.observable(),
            //Induce
            BloodTransfusion: ko.observable(),
            //Travel history
            Travel: ko.observableArray([]),
            SleepInVillage: ko.observable(),
            SleepOtherVillage: ko.observable(),
            SleepAbroad: ko.observable(),
            //Part 3
            Classify: ko.observable().extend({ required: true }),
        }

        return item;
    }

    function setTravel() {
        let item = {
            //TravelDate: ko.observable().extend({ required: true }),
            DateFrom: ko.observable().extend({ required: true }),
            DateTo: ko.observable().extend({ required: true }),
            AddressRisk: ko.observable().extend({ required: true }),
            Goal: ko.observable(),
            Day: ko.observable().extend({ required: true }),
            Sleep: ko.observable().extend({ required: true }),
            MalariaStatus: ko.observable(),
            InfectionSource: ko.observable()
        }
        return item;
    }

    self.addArea = function () {
        self.detailModel().Travel.push(new setTravel());
        $('input[numonly]').each(function () {
            app.setNumberOnly(this, $(this).attr('numonly'));
        });
    }

    self.removeArea = function (model) {
        self.detailModel().Travel.remove(model)
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = self.detailModel()
        model = app.unko(model);
        model.Symptom = model.Symptom.join(', ');

        model.OtherSymptom = model.OtherDiagnosis;

        let Travel = model.Travel.map(r => {
            //r.TravelDate == undefined ? null : r.TravelDate;
            //r.Sleep == undefined ? 0 : r.Sleep;
            //r.InfectionSource == undefined ? 0 : r.InfectionSource;
            return r;
        });

        delete model.Travel;

        let submit = {
            Question: model,
            Travel: JSON.stringify(Travel)
        }

        app.ajax('/CiHf/save', submit).done(function (rs) {
            let r = self.listModel().find(r => r.Rec_ID == model.Case_ID && r.Type == model.Case_Type);
            r.CI_ID(rs);
            self.view('list')
        });
    }

    self.showDelete = function () {
        app.showDelete(function () {
            submit = {
                Rec_ID: self.detailModel().Rec_ID(),
                Case_ID: self.detailModel().Case_ID(),
                Case_Type: self.detailModel().Case_Type()
            }

            app.ajax('/CiHf/delete', { submit: submit }).done(function () {
                let r = self.listModel().find(r => r.CI_ID() == self.detailModel().Rec_ID())
                r.CI_ID(null);
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

    self.getODName = function (code) {
        var found = place.od.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getProvName = function (code) {
        var found = place.pv.find(r => r.code == code);
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

        if (!isNaN(code) && code != null) {
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
            model.isOther('0')
        } else if (code != 'No') {
            model.other(code);
            if (code != undefined) model.isOther('1')
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
            } else if (param == 'addressrisk') {
                root.AddressRisk(village);
                root.AddressRisk.old = code;
            } else if (param == 'addressstake') {
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

    self.caseTransfer = ko.observable();
    self.showTransfer = function (model) {

        let mcase = {
            FromOD: model.Code_OD_T,
            ToOD: ko.observable(model?.ToOD()),
            FromHC: model.Code_Facility_T,
            ToHC: ko.observable(),
            Code_Vill_T: model.Code_Vill_t,
            Note: ko.observable(model?.Note),
            Case_ID: model.Rec_ID,
            Type: model.Type,

            pv: ko.observable(model?.Prov_Code),
            od: ko.observable(model?.ToOD()),
            pvList: ko.observableArray(pvAll),
            odList: ko.observableArray(),
            hcList: ko.observableArray(),
        }

        if (model.Prov_Code) {
            mcase.odList = ko.pureComputed(() => {
                return place.od.filter(r => r.pvcode == model.Prov_Code)
            })
        }

        mcase.pv.subscribe(function (code) {
            mcase.odList(code == null ? [] : odAll.filter(r => r.pvcode == code));
        });

        self.caseTransfer(mcase)

        $('#modalTransfer').modal('show')
    }

    self.transfer = function () {
        let model = self.caseTransfer()

        if (model.od() == undefined) {
            Swal.fire({
                title: "Warning",
                text: "Please select OD",
                icon: "error"
            });
            return
        }

        let submit = {
            FromOD: model.FromOD,
            ToOD: model.od(),
            FromHC: model.FromHC,
            ToHC: model.ToHC(),
            Code_Vill_T: model.Code_Vill_T,
            Note: model.Note(),
            Case_ID: model.Case_ID,
            Case_Type: model.Type,
        }

        app.ajax('/MRRT_Foci/transfer', { submit: submit }).done(function () {
            $('#modalTransfer').modal('hide')
            Swal.fire({
                title: "Success",
                text: "Case Transfer successful!",
                icon: "success"
            });

            let r = self.listModel().find(x => x.Rec_ID == model.Case_ID && x.Type == model.Type)
            r.ToOD(model.od())
            self.caseTransfer(undefined)
        })
    }

    self.closeTransfer = function () {
        self.caseTransfer(undefined)
        $('#modalTransfer').modal('hide')
    }

    self.month.subscribe(function (month) {
        let rs = dataArr.filter(r => r.Month == month)
        self.listModel(rs.length == 0 ? dataArr : rs)
    })
}

$("#modalTransfer").draggable({
    handle: ".modal-header"
});
