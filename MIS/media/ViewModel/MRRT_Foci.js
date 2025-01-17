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
    self.yList = [];
    self.year = ko.observable(moment().year());
    self.month = ko.observable();
    self.noteModel = ko.observable();
    var place = null;
    var pvAll = [];
    var odAll = [];
    var hcAll = [];

    var dataArr = [];

    for (var i = 2024; i <= moment().year(); i++) {
        self.yearList.push(i);
    }

    for (var i = 1; i <= 12; i++) {
        self.monthList.push(('0' + i).substr(-2));
    }

    for (var i = 2021; i <= moment().year(); i++) {
        self.yList.push(i);
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

        self.viewData();
    });

    self.viewData = function () {
        let submit = {
            pv: self.pv(),
            od: self.od(),
            hc: self.hc(),
            year: self.year(),
            month: self.month(),
        };

        app.ajax('/MRRT_Foci/getData', submit).done(function (rs) {

            let ori = [...rs];

            function isDone(CodeVill) {
                let rs = ori.find(r => r.Code_Vill_t == CodeVill && r.Done == 1);
                return rs != undefined ?? true;
            }

            let data = rs.map(r => {
                r.CI_ID = ko.observable(r.CI_ID);
                r.Done = isDone(r.Code_Vill_t);
                r.HasData = r.Done && r.CI_ID() != null ? true : false;
                r.ReasonNotDo = ko.observable(r.ReasonNotDo);
                r.ToOD = ko.observable(r.ToOD);
                return r;
            })

            dataArr = data;

            self.listModel(dataArr);
        });
    }

    self.isDelete = ko.observable();
    self.viewDetail = function (model) {
        let submit = {
            Rec_ID: model.Rec_ID,
            Type: model.Type
        }
        self.isDelete(model.CI_ID() ? true : false);
        app.ajax('/MRRT_Foci/getDetail', submit).done(function (rs) {
            if (model.CI_ID()) {
                let PrimaryVectorType = rs.PrimaryVectorType;
                PrimaryVectorType = isnullempty(PrimaryVectorType) ? [] : Array.isArray(PrimaryVectorType) ? PrimaryVectorType : PrimaryVectorType.split(', ');
                rs.PrimaryVectorType = PrimaryVectorType;

                if (rs.Photo != null) rs.Photo = '/media/MRRT_Foci/' + rs.Photo;

                self.detailModel(app.ko(rs));
            } else {
                self.detailModel(setQuestion(model))
            }
            self.view('detail');
        });
    }

    self.createNote = function (model) {
        let submit = {
            Rec_ID: model.Rec_ID,
            Type: model.Type
        }

        app.ajax('/MRRT_Foci/getDetail', submit).done(function (rs) {
            if (model.CI_ID()) {
                self.noteModel(app.ko(rs))
            } else {
                self.noteModel(new setNote(model))
            }
        });

        $('#modalNote').modal('show');
    }

    function setNote(model) {
        return {
            Rec_ID: ko.observable(model?.CI_ID || 0),
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
            Note: ko.observable(model?.Note),
            Completed: ko.observable().extend(model?.Completed),
        }
    }

    self.saveNote = () => {

        let model = app.unko(self.noteModel());

        let submit = {
            Rec_ID: model?.Rec_ID,
            Case_ID: model?.Case_ID,
            Case_Type: model?.Case_Type,
            PatientCode: model?.PatientCode,
            DateCase: model?.DateCase,
            PatientName: model?.PatientName,
            Age: model?.Age,
            Sex: model?.Sex,
            NotDo: model?.NotDo,
            ReasonNotDo: model?.ReasonNotDo,
            OtherReasonNotDo: model?.OtherReasonNotDo,
            DeclaredNotDoBy: model?.DeclaredNotDoBy,
            Note: model?.Note,
            Completed: model?.Completed,
        }

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

        app.ajax('/MRRT_Foci/saveNote', { submit: submit }).done(function (rs) {
            $('#modalNote').modal('hide')
            Swal.fire({
                title: "Success",
                text: "Save successful!",
                icon: "success"
            });

            let r = self.listModel().find(r => r.Rec_ID == submit.Case_ID && r.Type == submit.Case_Type);
            r.CI_ID(rs);
            r.ReasonNotDo(submit.ReasonNotDo)

            self.noteModel(undefined)
        })

    }

    function setQuestion(model) {
        let item = {
            Rec_ID: ko.observable(model?.CI_ID || 0),
            Case_ID: ko.observable(model?.Rec_ID),
            Case_Type: ko.observable(model?.Type),
            PatientCode: ko.observable(model?.PatientCode),
            DateCase: ko.observable(model ?.DateCase).extend({ required: true }),
            //MRRT_FociDate: ko.observable().extend({required: true}),
            PatientName: ko.observable(model ?.NameK).extend({ required: true }),
            Age: ko.observable(model.Age).extend({ required: true }),
            Sex: ko.observable(model.Sex).extend({ required: true }),
            SymptomDate: ko.observable().extend({ required: true }),
            Diagnosis: ko.observable(model.Diagnosis).extend({ required: true }),
            DiagnosisPlace: ko.observable(model ?.Type).extend({ required: true }),
            CompletedTreatment: ko.observable().extend({ required: true }),
            Address: ko.observable().extend({ required: true }),
            PermanentAddress: ko.observable().extend({ required: true }),
            InfectionSourceAddress: ko.observable().extend({ required: true }),
            ReportedDate: ko.observable().extend({ required: true }),
            InvDate: ko.observable().extend({ required: true }),
            FociDate: ko.observable().extend({ required: true }),
            //Part 2
            Active_1: ko.observable(),
            Active_2: ko.observable(),
            Active_3: ko.observable(),
            Active_4: ko.observable(),
            Active_5: ko.observable(),
            Active_Present: ko.observable(),

            Residual_1: ko.observable(),
            Residual_2: ko.observable(),
            Residual_3: ko.observable(),
            Residual_4: ko.observable(),
            Residual_5: ko.observable(),
            Residual_Present: ko.observable(),

            Cleared_1: ko.observable(),
            Cleared_2: ko.observable(),
            Cleared_3: ko.observable(),
            Cleared_4: ko.observable(),
            Cleared_5: ko.observable(),
            Cleared_Present: ko.observable(),

            ResponseFoci: ko.observable(),

            //Part 3
            Notify24h: ko.observable(),
            ABER: ko.observable(),
            QA: ko.observable(),
            QAScore: ko.observable(),

            LLIN3y: ko.observable(),
            SufficientRdtAct: ko.observable(),

            //part 4
            HasVMW: ko.observable(),
            Pop: ko.observable(),
            Family: ko.observable(),

            Patient_To_VMW: ko.observable(),
            VMWName: ko.observable(),
            VMWLat: ko.observable(),
            VMWLong: ko.observable(),

            VMW_To_HC: ko.observable(),
            HCName: ko.observable(),
            HCLat: ko.observable(),
            HCLong: ko.observable(),

            HC_To_RH: ko.observable(),
            RHName: ko.observable(),
            RHLat: ko.observable(),
            RHLong: ko.observable(),

            Patient_To_Forest: ko.observable(),
            ForestName: ko.observable(),
            ForestLat: ko.observable(),
            ForestLong: ko.observable(),

            Patient_To_WaterSource: ko.observable(),
            WaterSourceName: ko.observable(),
            WaterSourceLat: ko.observable(),
            WaterSourceLong: ko.observable(),

            Photo: ko.observable().extend({ required: true }),

            //part 5
            ForestSleep: ko.observable(),
            LLINCoverage: ko.observable(),
            LLIHNCoverage: ko.observable(),
            ForestGoer: ko.observable(),
            MMP: ko.observable(),

            //part 6
            PrimaryVector: ko.observable(),
            PrimaryVectorType: ko.observableArray(),
            OtherVector: ko.observable(),

            //Part 7
            NoIntervention: ko.observable(),
            QALess90: ko.observable(),
            QALess10: ko.observable(),
            QALess80: ko.observable(),

            MoreLLIN_LLIHN: ko.observable(),
            MoreRDT_ACT: ko.observable(),
            MoreVMW: ko.observable(),
            IPTf: ko.observable(),
            IEC_BCC: ko.observable(),
            MoreLLIHN_IEC: ko.observable(),
            MoreLLIN_IEC: ko.observable(),
            CE: ko.observable(),
            PfMix: ko.observable(),
            TDA: ko.observable(),

            // 8
            QADate: ko.observable(),
            LLINDate: ko.observable(),
            RDT_ACTDate: ko.observable(),
            VMWDate: ko.observable(),
            IptfDate: ko.observable(),
            IecDate: ko.observable(),
            LLIN_IecDate: ko.observable(),
            LLIHN_IecDate: ko.observable(),
            CeDate: ko.observable(),
            DtaDate: ko.observable(),


            //
            Cases: ko.observableArray([new setMalaria()]),
            LLINs: ko.observableArray([]),

            Note: ko.observable(),
        }

        return item;
    }

    function setMalaria() {
        let item = {
            Year: ko.observable().extend({ required: true }),
            Test: ko.observable().extend({ required: true }),
            Positive: ko.observable().extend({ required: true }),
            PfMix: ko.observable().extend({ required: true }),
            PvPmPkPo: ko.observable().extend({ required: true }),
            AgeU5: ko.observable().extend({ required: true }),
            Age5_14: ko.observable().extend({ required: true }),
            Age15_49: ko.observable().extend({ required: true }),
            AgeG49: ko.observable().extend({ required: true }),
            L1: ko.observable().extend({ required: true }),
            LC: ko.observable().extend({ required: true }),
            IMP: ko.observable().extend({ required: true }),
            Relapse: ko.observable().extend({ required: true }),
        }
        
        return item;
    }

    function setLLIN() {
        let item = {
            LLIN: ko.observable().extend({ required: true }),
            Pop: ko.observable().extend({ required: true }),
            Coverage: ko.observable().extend({ required: true }),
            Note: ko.observable(),
        }
        return item;
    }

    self.selectFile = function() {
        $('#file').val('').click();
    };

    self.fileChanged = function(files) {
        var reader = new FileReader();
        reader.onload = function() {
            var img = new Image();
            img.src = reader.result;
            img.onload = function() {
                var w = img.width > 800 ? 800 : img.width;
                var h = img.height * (w / img.width);

                var canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;

                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, w, h);

                self.detailModel().Photo(canvas.toDataURL('image/jpeg', 0.9));
            };
        };
        reader.readAsDataURL(files[0]);
    };

    self.addMalaria = function () {
        self.detailModel().Cases.push(new setMalaria());
    }

    self.removeLLIN = function (model) {
        self.detailModel().LLINs.remove(model)
    }

    self.addLLIN = function () {
        self.detailModel().LLINs.push(new setLLIN());
    }

    self.removeMalaria = function (model) {
        self.detailModel().Cases.remove(model)
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

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = self.detailModel()
        model = app.unko(model);
        model.PrimaryVectorType = model.PrimaryVectorType.join(', ');

        if (model.Photo != null && model.Photo.contain('.jpg')) {
            model.Photo = model.Photo.split('/').last();
        }

        let LLINs = model.LLINs;

        let Cases = model.Cases;

        delete model.LLINs;
        delete model.Cases;

        model.QADate = model.QADate?.format('YYYY-MM-DD');
        model.LLINDate = model.LLINDate?.format('YYYY-MM-DD');
        model.RDT_ACTDate = model.RDT_ACTDate?.format('YYYY-MM-DD');
        model.VMWDate = model.VMWDate?.format('YYYY-MM-DD');
        model.IptfDate = model.IptfDate?.format('YYYY-MM-DD');
        model.IecDate = model.IecDate?.format('YYYY-MM-DD');
        model.LLIN_IecDate = model.LLIN_IecDate?.format('YYYY-MM-DD');
        model.LLIHN_IecDate = model.LLIHN_IecDate?.format('YYYY-MM-DD');
        model.CeDate = model.CeDate?.format('YYYY-MM-DD');
        model.DtaDate = model.DtaDate?.format('YYYY-MM-DD');

        let submit = {
            Question: model,
            Cases: JSON.stringify(Cases),
            LLINs: JSON.stringify(LLINs)
        }

        app.ajax('/MRRT_Foci/save', submit).done(function (rs) {
            let r = self.listModel().find(r => r.Rec_ID == model.Case_ID && r.Type == model.Case_Type);
            r.CI_ID(rs);
            self.view('list')
        });
    }

    self.showDelete = function () {
        app.showDelete(function () {
            var submit = {
                table: 'tblMRRT_Foci',
                where: { Rec_ID: self.detailModel().Rec_ID() }
            };
            submit = { submit: JSON.stringify(submit) };

            app.ajax('/Direct/delete', submit).done(function () {
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
        } else if (param == 'infaddress') {
            var code = obj.InfectionSourceAddress.old || obj.InfectionSourceAddress();
        } 

        if (!isNaN(code)) {
            var pv, ds, cm, vl;

            if (code?.length == 10) {
                var found = place.vl.find(r => r.code == code);
                if (found != null) {
                    vl = code;
                    code = found.cmcode;
                }
            }
            if (code?.length == 6) {
                var found = place.cm.find(r => r.code == code);
                if (found != null) {
                    cm = code;
                    code = found.dscode;
                }
            }
            if (code?.length == 4) {
                var found = place.ds.find(r => r.code == code);
                if (found != null) {
                    ds = code;
                    code = found.pvcode;
                }
            }
            if (code?.length == 2) {
                var found = place.pv.find(r => r.code == code);
                if (found != null) pv = code;
            }
            if (pv != null) model.pv(pv);
            if (ds != null) model.ds(ds);
            if (cm != null) model.cm(cm);
            if (vl != null) model.vl(vl);
            model.isOther('0')
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
            } else if (param == 'infaddress') {
                obj.InfectionSourceAddress(village);
                obj.InfectionSourceAddress.old = code;
            } 

        };

        self.inputPlaceCancelClick = function () {
            if (param == 'peraddress') obj.PermanentAddress(obj.PermanentAddress.old || obj.PermanentAddress());
            else if (param == 'address') obj.Address(obj.Address.old || obj.Address());
            else if (param == 'infaddress') obj.InfectionSourceAddress(obj.InfectionSourceAddress.old || obj.InfectionSourceAddress());
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