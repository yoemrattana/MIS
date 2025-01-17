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
    self.noteModel = ko.observable();
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
    var dataArr = [];

    for (var i = 2024; i <= moment().year(); i++) {
        self.yearList.push(i);
    }

    for (var i = 1; i <= 12; i++) {
        self.monthList.push(('0' + i).substr(-2));
    }

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        pvAll = p.pv;
        vls = p.vl;

        place = p;
        if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

        var arr = place.od.map(r => r.pvcode).distinct();
        place.pv = place.pv.filter(r => arr.contain(r.code));
        self.pvList(place.pv);

        self.getData()
    });

    self.getData = () => {
        let submit = {
            pv: self.pv(),
            od: self.od(),
            hc: self.hc(),
            year: self.year(),
            month: self.month(),
        };

        app.ajax('/MRRT_CICC/getData', submit).done(function (rs) {
            let data = rs.map(r => {
                r.CICC_ID = ko.observable(r.CICC_ID);
                r.ReasonNotDo = ko.observable(r.ReasonNotDo)
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
        self.isDelete(model.CICC_ID() ? true : false);

        app.ajax('/MRRT_CICC/getDetail', submit).done(function (rs) {
            if (model.CICC_ID()) {
                let treatment = rs.Treatment;
                treatment = isnullempty(treatment) ? [] : Array.isArray(treatment) ? treatment : treatment.split(', ');
                rs.Treatment = treatment;

                let symptom = rs.Symptom;
                rs.Symptom = isnullempty(symptom) ? [] : Array.isArray(symptom) ? symptom : symptom.split(', ');

                let bedNet = rs.BednetType;
                bedNet = isnullempty(bedNet) ? [] : Array.isArray(bedNet) ? bedNet : bedNet.split(', ');
                rs.BednetType = bedNet;

                self.detailModel(app.ko(rs));
            } else {
                self.detailModel(setQuestion(model))
            }
            self.view('detail');

        });
    }

    function setQuestion(model) {
        let item = {
            Rec_ID: ko.observable(model.CICC_ID() || 0),
            Case_ID: ko.observable(model.Rec_ID),
            Case_Type: ko.observable(model.Type),
            PatientCode: ko.observable(model.PatientCode).extend({ required: true }),
            DateCase: ko.observable(model.DateCase).extend({ required: true }),
            InvDate: ko.observable().extend({ required: true }),
            PatientName: ko.observable(model.NameK).extend({ required: true }),
            PatientPhone: ko.observable(),
            Age: ko.observable(model.Age).extend({ required: true }),
            Sex: ko.observable(model.Sex).extend({ required: true }),
            Weight: ko.observable(model.Weight).extend({ required: true }),
            Address: ko.observable().extend({ required: true }),
            PermanentAddress: ko.observable().extend({ required: true }),
            HasVMW: ko.observable(),
            Lat: ko.observable().extend({ required: true }),
            Long: ko.observable().extend({ required: true }),
            Occupation: ko.observable(),
            OtherOccupation: ko.observable(),

            //part 2
            ConfirmDate: ko.observable().extend({ required:true }),
            EverPPMCure: ko.observable(),
            HCTest: ko.observable(),
            DetectionMethod: ko.observable(),
            OtherDetectionMethod: ko.observable(),
            DiagnosticMethod: ko.observable(),
            Diagnosis: ko.observable(),
            OtherDiagnosis: ko.observable(),
            Treatment: ko.observableArray([]),
            OtherTreatment: ko.observable(),
            ASMQ: ko.observable(),
            SLDP: ko.observable(),
            
            Dosage: ko.observable(),
            Dosage2: ko.observable(),
            DosePerDay: ko.observable(),
            TreatmentDay: ko.observable(),

            PQ: ko.observable(),
            PQDosage: ko.observable(),
            PQDosePerDay: ko.observable(),
            PQDuration: ko.observable(),
            PQDurationType: ko.observable(),

            G6PDHb: ko.observable(),
            G6PDdL: ko.observable(),
            SymptomDate: ko.observable().extend({ required:true }),
            Symptom: ko.observableArray([]),
            OtherSymptom: ko.observable(),

            //Part 3
            EverHadMalaria: ko.observable(),
            OldDiagnosis: ko.observable(),
            SameDiagnosis: ko.observable(),
            EverHadfakv: ko.observable(),
            EverHadvo: ko.observable(),
            EverTreatfakv: ko.observable(),
            EverTreatvo: ko.observable(),
            ASMQfakvDay: ko.observable(),
            ASMQvoDay: ko.observable(),

            ASMQPQfakvDay: ko.observable(),
            ASMQPQvoDay: ko.observable(),

            ASMQSLDPfakvDay: ko.observable(),
            ASMQSLDPvoDay: ko.observable(),

            RadicalCurefakvDay: ko.observable(),
            RadicalCurevoDay: ko.observable(),
            RadicalCurefakvWeek: ko.observable(),
            RadicalCurevoWeek: ko.observable(),

            RadicalCure7Dayfakv: ko.observable(),
            RadicalCure8Weekfakv: ko.observable(),

            RadicalCure7Dayvo: ko.observable(),
            RadicalCure8Weekvo: ko.observable(),

            FAKVOther: ko.observable(),
            VOOther: ko.observable(),
            FAKVCompleted: ko.observable(),
            VOCompleted: ko.observable(),

            Q3Confirm: ko.observable(),

            //Induce
            BloodTransfusion: ko.observable(),
            GoRiskArea: ko.observable(),

            //Travel history
            TravelDuringInfection: ko.observable(),
            Travel: ko.observableArray([]),
            TravelNote: ko.observable(),

            SleepInVillage: ko.observable(),
            FoundInClearup: ko.observable(),
            NewImpCase: ko.observable(),
            SleepOtherVillage: ko.observable(),
            SleepAbroad: ko.observable(),

            //Part 4
            Stakeholders: ko.observableArray([]),

            //part 5
            Classify: ko.observable().extend({ required: true }),
            LAType: ko.observable(),
            POC: ko.observable(),
            HasBednet: ko.observable(),
            BednetType: ko.observableArray([]),
            AlwaysSleepInBednet: ko.observable(),
            Note: ko.observable(),
        }

        return item;
    }

    function setTravel() {
        let item = {
            TravelDate: ko.observable(),
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

    function setStakeHolder() {
        let item = {
            Name: ko.observable().extend({ required: true }),
            Address: ko.observable().extend({ required: true }),
            Phone: ko.observable(),
            Passenger: ko.observable(),
            RiskInfection: ko.observable(),
            //InvDate: ko.observable().extend({ required: true }),
            InvDateFrom: ko.observable().extend({ required: true }),
            InvDateTo: ko.observable().extend({ required: true }),
        }
        return item;
    }

    self.addArea = function () {
        self.detailModel().Travel.push(new setTravel());
    }

    self.removeArea = function (model) {
        self.detailModel().Travel.remove(model)
    }

    self.addStakeHolder = function () {
        self.detailModel().Stakeholders.push(setStakeHolder());
    }

    self.removeStakeHolder = function (model) {
        self.detailModel().Stakeholders.remove(model);
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = self.detailModel()
        model = app.unko(model);
        model.Treatment = model.Treatment.join(', ');
        model.Symptom = model.Symptom.join(', ');
        model.BednetType = model.BednetType.join(', ')

        model.OtherSymptom = model.OtherDiagnosis;
        let Travel = model.Travel.map(r => {
            //r.TravelDate == undefined ? null : r.TravelDate;
            //r.Sleep == undefined ? 0 : r.Sleep;
            //r.InfectionSource == undefined ? 0 : r.InfectionSource;
            return r;
        });

        let StakeHolders = model.Stakeholders;

        delete model.Travel;
        delete model.Stakeholders;

        let submit = {
            Question: model,
            Travel: JSON.stringify(Travel),
            StakeHolders: JSON.stringify(StakeHolders)
        }

        app.ajax('/MRRT_CICC/save', submit).done(function (rs) {
            let r = self.listModel().find(r => r.Rec_ID == model.Case_ID && r.Type == model.Case_Type);
            r.CICC_ID(rs);
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

            app.ajax('/MRRT_CICC/delete', { submit: submit}).done(function () {
                let r = self.listModel().find(r => r.CICC_ID() == self.detailModel().Rec_ID())
                r.CICC_ID(null);
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
        if (temp == model[e.target.name]()) {
            model[e.target.name]('');
        }
        temp = model[e.target.name]();
        return true;
    }

    self.createNote = function (model) {
        let submit = {
            Rec_ID: model.Rec_ID,
            Type: model.Type
        }

        app.ajax('/MRRT_CICC/getDetail', submit).done(function (rs) {
            if (model.CICC_ID()) {
                self.noteModel(app.ko(rs))
            } else {
                self.noteModel(new setNote(model))
            }
        });

        $('#modalNote').modal('show');
    }

    function setNote(model) {
        return {
            Rec_ID: ko.observable(model?.CICC_ID || 0),
            Case_ID: ko.observable(model?.Rec_ID),
            Case_Type: ko.observable(model?.Type),
            PatientCode: ko.observable(model?.PatientCode),
            DateCase: ko.observable(model?.DateCase).extend({ required: true }),
            PatientName: ko.observable(model?.NameK).extend({ required: true }),
            Age: ko.observable(model?.Age).extend({ required: true }),
            Sex: ko.observable(model?.Sex).extend({ required: true }),
            NotDo: ko.observable(model?.NotDo),
            ReasonNotDo: ko.observable(model?.ReasonNotDo),
            OtherReasonNotDo: ko.observable(model?.OtherReasonNotDo),
            DeclaredNotDoBy: ko.observable(model?.DeclaredNotDoBy),
            Completed: ko.observable().extend(model?.Completed),
        }
    }

    self.saveNote = () => {

        let submit = app.unko(self.noteModel());

        if (submit.NotDo && submit.ReasonNotDo == '') {
            Swal.fire({
                title: "Warning",
                text: "Please fill in Reason not do",
                icon: "error"
            });
            return
        }

        if (submit.DeclaredNotDoBy == undefined) {
            Swal.fire({
                title: "Warning",
                text: "Please fill in you name",
                icon: "error"
            });
            return
        }

        app.ajax('/MRRT_CICC/saveNote', { submit: submit }).done(function (rs) {
            $('#modalNote').modal('hide')
            Swal.fire({
                title: "Success",
                text: "Save successful!",
                icon: "success"
            });

            let r = self.listModel().find(r => r.Rec_ID == submit.Case_ID && r.Type == submit.Case_Type);
            r.CICC_ID(rs);
            r.ReasonNotDo(submit.ReasonNotDo)

            self.noteModel(undefined)
        })

       

    }

    self.month.subscribe(function (month) {
        let rs = dataArr.filter(r => r.Month == month)
        self.listModel(rs.length == 0 ? dataArr : rs)
    })
}

$("#modalNote").draggable({
    handle: ".modal-header"
});