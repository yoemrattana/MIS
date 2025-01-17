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
    self.vlList = ko.observableArray();
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.vl = ko.observable();
    self.inputPlaceModel = ko.observable();
    self.yearList = [];
    self.monthList = [];
    self.year = ko.observable(moment().year());
    self.month = ko.observable();
    var place = null;

    var pvAll = [];

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

        getData()
    });

    function getData() {
        let submit = {
            pv: self.pv(),
            od: self.od(),
            hc: self.hc(),
            year: self.year(),
        };

        app.ajax('/MRRT_IPTf/getData', submit).done(function (rs) {
            self.listModel(rs);
        });
    }

    self.getListModel = function () {
        var list = self.listModel();

        if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());
        if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
        if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
        if (self.vl() != null) list = list.filter(r => r.Code_Vill_T == self.vl());

        return list;
    };

    self.showNew = function () {
        self.detailModel(new setQuestion())
        self.view('detail')

        setTimeout(() => {
            $('input[numonly]').each(function () {
                app.setNumberOnly(this, $(this).attr('numonly'));
            });
        }, 300)
    };

    self.viewData = function () {
        let submit = {
            pv: self.pv(),
            od: self.od(),
            hc: self.hc(),
            year: self.year(),
        };

        app.ajax('/MRRT_IPTf/getData', submit).done(function (rs) {
            self.listModel(data);
        });
    }

    self.viewDetail = function (model) {
        let submit = {
            Rec_ID: model.Rec_ID,
        }

        app.ajax('/MRRT_IPTf/getDetail', submit).done(function (rs) {
            self.detailModel(app.ko(rs));
            self.view('detail');
        });

        setTimeout(() => {
            $('input[numonly]').each(function () {
                app.setNumberOnly(this, $(this).attr('numonly'));
            });
        }, 200)
    }

    function setQuestion() {
        let item = {
            Rec_ID: ko.observable(0),
            Year: ko.observable().extend({ required: true }),
            Month: ko.observable().extend({ required: true }),
            IPTfDate: ko.observable().extend({ required: true }),
            Code_Vill: ko.observable().extend({ required: true }),
            Code_Vill_T: ko.observable().extend({ required: true }),
            Member: ko.pureComputed(function () {
                return parseInt(self.detailModel().Members().length);
            }),
            HouseHolder: ko.observable().extend({ required: true }),
            Phone: ko.observable().extend({ required: true }),
            ReportedBy: ko.observable().extend({ required: true }),

            Members: ko.observableArray([new setMember()])
        }

        return item;
    }

    function setMember() {
        let item = {
            Rec_ID: ko.observable(0),
            Name: ko.observable().extend({ required: true }),
            IPTfTarget: ko.observable(),
            NotDrug: ko.observable(),
            IPTfReceived: ko.observable(),
            IPTfReceivedDate: ko.observable(),
        }

        item.IPTfReceivedDate.extend({
            required: {
                onlyIf: function () {
                    return item.IPTfReceived() == 1
                }
            }
        });

        return item;
    }

    self.addMember = function () {
        self.detailModel().Members.push(new setMember());
        $('input[numonly]').each(function () {
            app.setNumberOnly(this, $(this).attr('numonly'));
        });
    }

    var deleteList = [];
    self.removeMember = function (model) {
        if (model.Rec_ID() > 0) {
            deleteList.push(model);
        }
        self.detailModel().Members.remove(model)
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = self.detailModel()
        model = app.unko(model);
        let Members = model.Members;

        deleteList.forEach(r => Members.push({ Rec_ID: r.Rec_ID() * -1 }));

        delete model.Members;

        let submit = {
            Question: model,
            Members: JSON.stringify(Members)
        }

        app.ajax('/MRRT_IPTf/save', submit).done(function (rs) {
            if (model.Rec_ID == 0) {
                self.listModel.push(rs);
            }
            self.view('list')
        });
    }

    self.showDelete = function (model) {
        app.showDelete(function () {
            var submit = {
                table: 'tblMRRT_IPTf',
                where: { Rec_ID: model.Rec_ID }
            };
            submit = { submit: JSON.stringify(submit) };

            app.ajax('/Direct/delete', submit).done(function () {
                let r = self.listModel().find(r => r.Rec_ID == model.Rec_ID)
                self.listModel.remove(r);
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

    self.hc.subscribe(function (code) {
        self.vlList(code == null ? [] : place.vl.filter(r => r.hccode == code));
    });

    self.getPVName = function (code) {
        return code == null ? '' : place.pv.find(r => r.code == code).name;
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

        var code = obj.Code_Vill_T.old || obj.Code_Vill_T();

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

            obj.Code_Vill_T(village);
            obj.Code_Vill_T.old = code;

        };

        self.inputPlaceCancelClick = function () {
            obj.Code_Vill_T(obj.Code_Vill_T.old || obj.Code_Vill_T());
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
}