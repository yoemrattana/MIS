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
    self.listGroup = ko.observableArray();
    self.model = ko.observable();
    self.listMessage = ko.observableArray();
    
    var pvData = [];
    var odData = [];

    app.getPlace(['pv', 'od'], function (p) {
        pvData = p.pv;
        odData = p.od.filter(r => r.target == 1);
    });

    function setGroup(ele) {
        if (ele != undefined) {
            ele = app.ko(ele);
            ele.multiPvList = ko.observableArray();
            ele.multiOdList = ko.observableArray();
            ele.specieList  = ko.observableArray();
        }
        
        var item = {
            Rec_ID: ko.observable(ele == undefined ? '' : ele.Rec_ID()),
            ID: ko.observable(ele == undefined ? '' : ele.ID()).extend({ Required: true }),
            Name: ko.observable(ele == undefined ? '' : ele.Name()).extend({ Required: true }),
            Code_Prov: ko.observable(ele == undefined ? '' : ele.Code_Prov()).extend({ Required: true }),
            Code_OD: ko.observable(ele == undefined ? '' : ele.Code_OD()).extend({ Required: true }),
            Specie: ko.observable(ele == undefined ? '' : ele.Specie()).extend({ Required: true }),
            multiPvList: ko.observableArray(ele == undefined ? '' : ele.multiPvList()),
            multiOdList: ko.pureComputed(function () {
                let prov = item.multiPvList().filter(r => r.check());
                if (prov.length == 0) return [];
                if (prov.length > 1) return [];

                let rs_ods = odData.filter(r => r.pvcode == prov[0].code);

                let od_codes = item.Code_OD().split(',');
                let ods = rs_ods.map(r => {
                    let tick = item.Rec_ID() == '' ? false : od_codes.some(o => o == r.code)
                    return {
                        code: r.code,
                        name: r.name,
                        check: ko.observable(tick)
                    }
                });
                return ods;
            }),
            specieList: ko.observableArray(ele == undefined ? '' : ele.specieList()),
        };

        var arr = item.Code_Prov().split(',');

        pvData.filter(r => r.target == 1).forEach(p => {
            var tick = item.Rec_ID() == '' ? false : arr.some(r => r == p.code);
            item.multiPvList.push({
                code: p.code,
                name: p.name,
                check: ko.observable(tick)
            });
        });

        var specieArr = item.Specie().split(',');

        var diagnosisArr = [
            { code: 'F', name: 'Pf' },
            { code: 'V', name: 'Pv' },
            { code: 'M', name: 'Mix' },
            { code: 'A', name: 'Pm' },
            { code: 'O', name: 'Po' },
            { code: 'K', name: 'Pk' }
        ];

        diagnosisArr.forEach(r => {
            let tick = item.Rec_ID() == '' ? false : specieArr.some(x => x == r.code)
            item.specieList.push({
                code: r.code,
                name: r.name,
                check: ko.observable(tick)
            });
        });

        return item;
    }

    getData();

    self.edit = function (model) {
        self.model(new setGroup(model));
        $('#modalAdd').modal('show');
    }

    self.add = function () {
        self.model(new setGroup(undefined));
        $('#modalAdd').modal('show');
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            return;
        }
        
        var model = self.model();
        var multiPv = model.multiPvList().filter(r => r.check()).map(r => r.code).join(',');
        var multiOd = model.multiOdList().filter(r => r.check()).map(r => r.code).join(',');
        var multiSpecie = model.specieList().filter(r => r.check()).map(r => r.code).join(',');

        var submit = {
            Rec_ID: model.Rec_ID(),
            ID: model.ID(),
            Name: model.Name(),
            Code_Prov: multiPv,
            Code_OD: multiOd,
            Specie: multiSpecie,
        }

        app.ajax('TeleGroup/save', { submit: JSON.stringify(submit) }).done(function (rs) {
            $('#modalAdd').modal('hide');
            app.showMsg('Successful', 'Update/Insert data successful!');
            if (model.Rec_ID == '') {
                self.listModel.push(rs);
            } else {
                let result = self.listModel().find(r=>r.Rec_ID == model.Rec_ID());
                self.listModel.remove(result);
                self.listModel.push(rs);
            }
        })
    }

    self.delete = function (model) {
        app.showDelete(function () {
            app.ajax('TeleGroup/delete', { rec_id: model.Rec_ID }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.listModel.remove(model);
            });
        })
    }

    self.toDate = function (unixDate) {
        return moment.unix(unixDate).format("DD/MM/YYYY H:m:s");
    };

    self.readMe = function () {
        $('#modalReadMe').modal('show');
    }

    self.sync = function () {
        $.when(loadGroup()).then(function () {
            $('#modalSync').modal('show');
        });
    }

    self.showMsg = function (model) {
        $.when(getMessage(model.ID)).then(function () {
            $('#modalMsg').modal('show');
        });
    }

    self.formatDate = function(date) {
        return moment(date).format("DD-MM-YYYY HH:mm:ss");
    }

    function getMessage(groupId) {
        return app.ajax('TeleGroup/getMessage', { 'groupId': groupId }).done(function (rs) {
            self.listMessage(rs);
        });
    }

    self.changeStatus = function (model) {
        var v = model.IsActive() ? 1 : 0;
        var submit = {
            table: 'tblTelegramGroup',
            value: {IsActive: v},
            where: { Rec_ID: model.Rec_ID() }
        };
        submit = { submit: JSON.stringify(submit) };

        $.when(updateStatus(submit)).then(function () {
            getData();
        });
    }

    function loadGroup() {
        return app.ajax('TeleGroup/getRequest').done(function (rs) {
            if (!rs) return;
            rs = JSON.parse(rs);
            rs = rs['result'];
            var messages = [];
            rs.forEach(r => {
                if (r['message'] != undefined) messages.push(r['message']);
            });

            var groups = [];
            messages.forEach(m => {
                if (m['chat']['type'] == 'group') {
                    m['chat']['date'] = self.toDate(m['date'])
                    groups.push(m['chat']);
                };
            });

            self.listGroup(groups);
        });
    }

    function updateStatus(submit) {
        return app.ajax('/Direct/update', submit).done(function () {
            
        });
    }

    function getData() {
        app.ajax('/TeleGroup/getData').done(function (rs) {
            let results = rs.map(r => app.ko(r));
            self.listModel(results);
        });
    }

}