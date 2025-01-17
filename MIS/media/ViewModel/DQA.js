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

    self.listModel = ko.observableArray();
    self.listHcTarget = ko.observableArray();
    self.listVmwTarget = ko.observableArray();
    self.listDist = ko.observableArray();
    self.summary = ko.observableArray();
    self.masterModel = ko.observable();
    self.detailModel = ko.observable();
    self.view = ko.observable('list');
    self.menu = ko.observable(new URLSearchParams(location.search).get('type') || '');
    self.inputPlaceModel = ko.observable();
    self.inputHcModel = ko.observable();
    self.inputDistModel = ko.observable();
    self.inputProvModel = ko.observable();
    self.submenu = ko.observable();

    self.pvList = ko.observableArray();
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.vl = ko.observable();

    var lastScrollY = 0;
    var place = null;
    var hcs = [];
    var ods = [];
    var vls = [];
    var districts = []
    var pvAll = [];

    function setDqa() {
        let dqa = {
            Rec_ID: ko.observable(),
            HasDoc: ko.observable(1),
            Visitor: ko.observable(),
            VisitDate: ko.observable(),
            CaseInHC: ko.observable(),
            Year: ko.observable(),
            Month: ko.observable(),
            Case_ID: ko.observable(),
            Type: ko.observable(),
            PatientID: ko.observable(),
            Name: ko.observable('').extend({ required: true }),
            Age: ko.observable('').extend({ required: true }),
            Sex: ko.observable('').extend({ required: true }),
            ResidenceAddress: ko.observable(),
            PermanentAddress: ko.observable(''),
            Code_Facility_T: ko.observable(),
            Code_Vill_T: ko.observable(),
            Code_Dist: ko.observable(),
            Code_Prov: ko.observable(),
            DiagnosisDate: ko.observable(''),
            DiagnosisMethod: ko.observable('').extend({ required: true }),
            Species: ko.observable('').extend({ required: true }),
            TreatmentDate: ko.observable(null),
            TreatmentPrescribe: ko.observable(),
            IsFoundNotification: ko.observable(),
            NotificationDate: ko.observable(null),
            IsWithinCountry: ko.observable(),
            WithinCountry: ko.observable(),
            IsOutSideCountry: ko.observable(),
            OutSideCountry: ko.observable(),
            InvestigationDate: ko.observable(null),
            InvestigationLat: ko.observable(),
            InvestigationLong: ko.observable(),
            Classification: ko.observable(),
            IsAppropriate: ko.observable(),
            ReasonClasAppro: ko.observable(),
            IsFoundFocusInv: ko.observable(),
            FocusInvDate: ko.observable(null),
            FociClassification: ko.observable(),
            IsCompleteFocusInv: ko.observable(),
            ElementFocusInv: ko.observable(),
            IsCompleteRegister: ko.observable(),
            IsConcordance: ko.observable(),
        }
        return dqa;
    }

    function setDqaNote() {
        let note = {
            Rec_ID: ko.observable(),
            ParentID: ko.observable(),
            Name: ko.observable(),
            Age: ko.observable(),
            Sex: ko.observable(),
            PermanentAddress: ko.observable(),
            Code_Facility_T: ko.observable(),
            Code_Vill_T: ko.observable(),
            Code_Dist: ko.observable(),
            Code_Prov: ko.observable(),
            DiagnosisDate: ko.observable(),
            DiagnosisMethod: ko.observable(),
            Species: ko.observable(),
            TreatmentDate: ko.observable(),
            TreatmentPrescribe: ko.observable(),
            IsFoundNotification: ko.observable(),
            NotificationDate: ko.observable(),
            IsWithinCountry: ko.observable(),
            WithinCountry: ko.observable(),
            IsOutSideCountry: ko.observable(),
            OutSideCountry: ko.observable(),
            InvestigationDate: ko.observable(),
            InvestigationLat: ko.observable(),
            InvestigationLong: ko.observable(),
            Classification: ko.observable(),
            IsAppropriate: ko.observable(),
            ReasonClasAppro: ko.observable(),
            IsFoundFocusInv: ko.observable(),
            FocusInvDate: ko.observable(),
            FociClassification: ko.observable(),
            IsCompleteFocusInv: ko.observable(),
            ElementFocusInv: ko.observable(),
            IsCompleteRegister: ko.observable(),
            IsConcordance: ko.observable(),
        }

        return note;
    }

    self.errors = ko.validation.group(this, { deep: true, observable: false });

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
    	pvAll = p.pv;

    	p.pv = p.pv.filter(r => r.target == 1);
        p.od = p.od.filter(r => r.target == 1);

        if (app.user.prov != '') p.pv = p.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') p.od = p.od.filter(r => r.code == app.user.od);

        place = p;
        self.pvList(p.pv);

        if (self.menu() == 'HC') {
            app.ajax('/DQA/getHcPreData/' + self.menu()).done(function (rs) {
                self.pvList(rs.prov);
                ods = rs.od;
                hcs = rs.hc;
                districts = rs.dist;
            });
        } else if (self.menu() == 'VMW') {
            app.ajax('/DQA/getVMWPreData/' + self.menu()).done(function (rs) {
                self.pvList(rs.prov);
                ods = rs.od;
                hcs = rs.hc;
                vls = rs.vl.sortasc('name');
                districts = rs.dist;
            });
        } else {
            app.ajax('/DQA/getSummary/').done(function (rs) {
                self.summary(rs);
            });
        }
    });

    self.viewData = () => {
        if (self.pv() == null) {
            app.showMsg("Missing","Please select Province");
        }
        if (self.od() == null) {
            app.showMsg("Missing", "Please select OD");
        }
        if (self.hc() == null) {
            app.showMsg("Missing", "Please select HC");
        }
        if (self.vl() == null && self.menu()=='VMW') {
            app.showMsg("Missing", "Please select Village");
        }

        let submit = {
            pv: self.pv(),
            od: self.od(),
            hc: self.hc(),
            vl: self.vl(),
            menu: self.menu(),
        }
        app.ajax('/DQA/getData/', submit).done(function (rs) {
            let list = rs.map(r=> app.ko(r))
            self.listModel(list);
        });
    }

    self.getSpecie = (specie) => {
        return specie == 'F' ? 'Pf'
            : specie == 'V' ? 'Pv'
                : specie == 'M' ? 'Mix'
                    : specie == 'A' ? 'Pm'
                        : specie == 'O' ? 'Po'
                            : 'Pk';
    }

    self.getSex = (sex) => {
        return sex == 'M' ? 'Male' : 'Female';
    }

    self.selectAddress = (root, event) => {
        var element = $(event.currentTarget);
        var param = element.attr('param');

        var obj = self.detailModel().dqa;
        $('#modalInputPlace').modal('show');

        var model = {
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

        if (param == 'address') {
            var code = root.dqa.PermanentAddress() == null ? obj.PermanentAddress.old || '' : root.dqa.PermanentAddress();
        } else {
            var code = root.dqa.WithinCountry() == null ? obj.WithinCountry.old || '' : root.dqa.WithinCountry();
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

            var village = '';
            if (code != null) {
                village = code;
            } else if (model.other().trim() != '') {
                village = model.other().trim();
            }

            if (param == 'address') {
                obj.PermanentAddress(village);
                obj.PermanentAddress.old = code;
            } else {
                obj.WithinCountry(village);
                obj.WithinCountry.old = code;
            }
            
        };

        self.inputPlaceCancelClick = function () {
            if (param == 'address') obj.PermanentAddress(obj.PermanentAddress.old);
            else obj.WithinCountry(obj.WithinCountry.old);
        };
    }

    self.selectHF = (root, event) => {
        var obj = self.detailModel().dqa;
        $('#modalInputHF').modal('show');

        var model = {
            pvList: ko.observableArray(place.pv),
            odList: ko.observableArray(),
            hcList: ko.observableArray(),
            pv: ko.observable(),
            od: ko.observable(),
            hc: ko.observable(),
        };

        model.pv.subscribe(function (code) {
            model.odList(place.od.filter(r => r.pvcode == code));
        });

        model.od.subscribe(function (code) {
            model.hcList(place.hc.filter(r => r.odcode == code));
        });

        var code = root.dqa.Code_Facility_T() == null ? obj.Code_Facility_T.old || '' : root.dqa.Code_Facility_T();
        if (!isNaN(code)) {
            var pv, od, hc;

            if (code.length == 6) {
                var found = place.hc.find(r => r.code == code);
                if (found != null) {
                    hc = code;
                    code = found.odcode;
                }
            }

            if (code.length == 4) {
                var found = place.od.find(r => r.code == code);
                if (found != null) {
                    od = code;
                    code = found.pvcode;
                }
            }

            if (code.length == 2) {
                var found = place.pv.find(r => r.code == code);
                if (found != null) pv = code;
            }
            if (pv != null) model.pv(pv);
            if (od != null) model.od(od);
            if (hc != null) model.hc(hc);
        } else if (code != 'No') {
            model.other(code);
        }

        self.inputHcModel(model);
        $('#modalInputHF').modal('show');

        self.inputHcOKClick = function () {
            var code = null;

            if (model.hc() != null) code = model.hc();
            else if (model.od() != null) code = model.od();
            else if (model.pv() != null) code = model.pv();

            var hc = '';
            if (code != null) {
                hc = code;
            } else if (model.other().trim() != '') {
                hc = model.other().trim();
            }

            obj.Code_Facility_T(hc);
            obj.Code_Prov(model.pv());
            obj.Code_Facility_T.old = code;

            let district = districts.find(r => r.Code_Facility_T == hc);
            obj.Code_Dist(district.Code_Dist_T);
        };

        self.inputHcCancelClick = function () {
            obj.Code_Facility_T(obj.Code_Facility_T.old);
        };
    }

    self.selectDist = (root, element) => {
        var obj = self.detailModel().dqa;
        $('#modalInputDist').modal('show');

        var model = {
            pvList: ko.observableArray(place.pv),
            dsList: ko.observableArray(),
            pv: ko.observable(),
            ds: ko.observable(),
        };

        model.pv.subscribe(function (code) {
            model.dsList(place.ds.filter(r => r.pvcode == code));
        });

        var code = root.dqa.Code_Dist() == null ? obj.Code_Dist.old || '' : root.dqa.Code_Dist();
        if (!isNaN(code)) {
            var pv, ds;

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
        } else if (code != 'No') {
            model.other(code);
        }

        self.inputDistModel(model);
        $('#modalInputDist').modal('show');

        self.inputDistOKClick = function () {
            var code = null;

            if (model.ds() != null) code = model.ds();
            else if (model.pv() != null) code = model.pv();

            var ds = '';
            if (code != null) {
                ds = code;
            } else if (model.other().trim() != '') {
                ds = model.other().trim();
            }

            obj.Code_Dist(ds);
            obj.Code_Dist.old = code;
        };

        self.inputDistCancelClick = function () {
            obj.Code_Dist(obj.Code_Facility_T.old);
        };
    }

    self.selectProv = (root, element) => {
        var obj = self.detailModel().dqa;
        $('#modalInputProv').modal('show');

        var model = {
            pvList: ko.observableArray(place.pv),
            pv: ko.observable(),
        };

        var code = root.dqa.Code_Prov() == null ? obj.Code_Prov.old || '' : root.dqa.Code_Prov();
        if (!isNaN(code)) {
            var pv, ds;

            if (code.length == 2) {
                var found = place.pv.find(r => r.code == code);
                if (found != null) pv = code;
            }

            if (pv != null) model.pv(pv);
        } else if (code != 'No') {
            model.other(code);
        }

        self.inputProvModel(model);
        $('#modalInputProv').modal('show');

        self.inputProvOKClick = function () {
            var code = null;

            if (model.pv() != null) code = model.pv();

            var pv = '';
            if (code != null) {
                pv = code;
            } else if (model.other().trim() != '') {
                pv = model.other().trim();
            }

            obj.Code_Prov(pv);
            obj.Code_Prov.old = code;
        };

        self.inputProvCancelClick = function () {
            obj.Code_Prov(obj.Code_Prov.old);
        };
    }

    self.showDetail = function (model) {
        lastScrollY = window.scrollY;
        window.scrollTo(0, 0);

        var submit = { Rec_ID: model.Rec_ID, menu: self.menu() };

        app.ajax('/DQA/getDetail', submit).done(function (r) {
            let rs = r;
            if (rs.dqa == null) rs.dqa = setDqa();
            if (rs.dqaNote == null) rs.dqaNote = setDqaNote();

            self.detailModel(app.ko(rs));
            self.view('detail');
        });
    };

    self.dateFormat = function (date) {
        return date() == null ? '' : moment(date()).format('DD-MM-YYYY');
    };

    self.save = function () {
        //if (self.errors().length != 0) {
        //    self.errors.showAllMessages();
        //    return;
        //}

        let detail = app.unko(self.detailModel);

        let dqa = detail.dqa;
        dqa.Case_ID = detail.Rec_ID;
        dqa.Type = detail.CaseType;
        dqa.Year = detail.Year;
        dqa.Month = detail.Month;
        dqa.CaseInHC = detail.Code_Facility_T;

        let dqaNote = detail.dqaNote;

        if (dqa.Visitor == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល Visitor</kh>');
            return;
        }

        if (dqa.VisitDate == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ថ្ងៃខែឆ្នាំអភិបាល</kh>');
            return;
        }

        submit = {
            dqa: dqa,
            dqaNote: dqaNote
        }

        app.ajax('/DQA/save', { submit: submit }).done(function (rs) {
            var result = self.listModel().find(r => r.Rec_ID() == detail.Rec_ID);
            result.HasDQA(1);

            self.back();
        });
    };

    self.showDelete = function (model) {
        app.showDelete(function () {
            var submit = {
                table: 'tblDQA',
                where: { Case_ID: model.Rec_ID() }
            };
            submit = { submit: JSON.stringify(submit) };

            app.ajax('/Direct/delete', submit).done(function () {
                var result = self.listModel().find(r => r.Rec_ID() == model.Rec_ID());
                result.HasDQA(0);
            });
        });
    };

    self.back = function () {
        self.view('list');
        window.scrollTo(0, lastScrollY);
    };

    self.odList = ko.pureComputed(function () {
        return self.pv() == null ? [] : ods.filter(r => r.pvcode == self.pv());
    });

    self.hcList = ko.pureComputed(function () {
        return self.od() == null ? [] : hcs.filter(r => r.odcode == self.od());
    });

    self.vlList = ko.pureComputed(function () {
        return self.hc() == null ? [] : vls.filter(r => r.hccode == self.hc());
    });

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

    self.getHCName = function (code) {
        var found = place.hc.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getDistName = function (code) {
        var found = place.ds.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getProvName = function (code) {
        var found = place.pv.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.viewTarget = (model, event) => {
        var element = $(event.currentTarget);
        var param = element.attr('name');
        self.submenu(param);

        app.ajax('/DQA/getTarget/', { submit: param }).done(function (rs) {
            if (self.submenu() == 'HC') self.listHcTarget(rs);
            else self.listVmwTarget(rs);
        });
    }

    self.exportSummary = () => {
        let table = document.getElementsByClassName("tableSummary");
        TableToExcel.convert(table[0], { 
            name: `DQA_summary.xlsx`, 
            sheet: {
                name: 'Sheet 1' 
            }
        });
    }

    self.ifcan = function (permission) {
        return app.user.permiss['DQA'].contain(permission);
    };

    $('#menu button').each(function () {
        $(this).click(() => location = '/DQA?type=' + this.name);
        if (this.name == self.menu()) $(this).removeClass('btn-default').addClass('btn-info');
        if (!self.ifcan(this.innerHTML)) $(this).hide();
    });

    self.inputPlaceOKClick = () => { };
    self.inputPlaceCancelClick = () => { };

    self.inputHcOKClick = () => { };
    self.inputHcCancelClick = () => { };

    self.inputDistOKClick = () => { };
    self.inputDistCancelClick = () => { };

    self.inputProvOKClick = () => { };
    self.inputProvCancelClick = () => { };
}