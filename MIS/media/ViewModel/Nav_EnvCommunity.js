function viewModel() {
    var self = this;

    self.editModel = ko.observable();

    self.provList = ko.observableArray();
    self.prov = ko.observable();
    self.Office = ko.observable();

    self.mainData = ko.observableArray();
    var Offices = ko.observableArray();

    app.getPlace(['pv'], function (p) {
        self.provList(p.pv);
    });

    app.ajax('/SystemMenu/getEnvCommunity').done(function (rs) {
        var provs = rs.preData.distinct(r => r.Code_Prov_T).map(r => {
            return {
                code: r.Code_Prov_T,
                name: r.Name_Prov_E
            }
        });
        self.provList(provs);

        var founds = rs.preData.distinct(r => r.Code_Office_T).map(r => {
            return {
                code: r.Code_Office_T,
                name: r.Name_Office_K,
                pvcode: r.Code_Prov_T
            }
        });
        Offices(founds);

        self.mainData(rs.mainData);
    });

    self.OfficeList = ko.pureComputed(function () {
        return self.prov() == null ? Offices() : Offices().filter(r => r.pvcode == self.prov());
    });

    self.listModel = ko.pureComputed(function () {
        return self.Office() != null ? self.mainData().filter(r => r.Code_Office_T == self.Office())
			: self.prov() != null ? self.mainData().filter(r => r.Code_Prov_T == self.prov())
			: self.mainData();
    });

    self.showCreate = function () {
        var arr = self.mainData().map(r => r.Code_Community_T);
        var model = {
            Code_Office_T: null,
            Code_Community_T: arr.length == 0 ? '001' : (Math.max(...arr) + 1).toString().padStart(3, '0'),
            Name_Community_E: '',
            Name_Community_K: '',
            Rec_ID: 0
        };

        self.showEdit(model);
    };

    self.showEdit = function (model) {
        model = app.ko(model);

        if (model.Code_Prov_T === undefined) model.Code_Prov_T = ko.observable();

        model.OfficeList = ko.pureComputed(function () {
            return Offices().filter(r => r.pvcode == model.Code_Prov_T());
        });

        self.editModel(model);
        $('#modalEdit').modal('show');
    };

    self.edit = function () {
        var model = self.editModel();

        model.Name_Community_E(model.Name_Community_E().trim());
        model.Name_Community_K(model.Name_Community_K().trim());

        var missing = false;
        if (model.Rec_ID() == 0 && model.Code_Prov_T() == null) {
            app.showWarning(model.Code_Prov_T.element, 'Please input this box.');
            missing = true;
        }
        if (model.Code_Office_T() == null) {
            app.showWarning(model.Code_Office_T.element, 'Please input this box.');
            missing = true;
        }
        if (model.Name_Community_K() == '') {
            app.showWarning(model.Name_Community_K.element, 'Please input this box.');
            missing = true;
        }
        if (missing) return;

        $('#modalEdit').modal('hide');
        model = app.unko(model);

        var submit = {
            submit: JSON.stringify({
                value: {
                    Code_Community_T: model.Code_Community_T,
                    Name_Community_E: model.Name_Community_E,
                    Name_Community_K: model.Name_Community_K,
                    Code_Office_T: model.Code_Office_T
                },
                where: { Rec_ID: model.Rec_ID }
            })
        };

        app.ajax('/SystemMenu/saveCommunity', submit).done(function (rs) {
            if (model.Rec_ID == 0) {
                self.mainData.push(rs);
            } else {
                var old = self.mainData().find(r => r.Rec_ID == model.Rec_ID);
                self.mainData.replace(old, rs);
            }
        });
    };

    self.delete = function (model) {
        app.showDelete(function () {
            var submit = { Rec_ID: model.Rec_ID };
            app.ajax('/SystemMenu/deleteCommunity', submit).done(function () {
                self.mainData.remove(model);
            });
        });
    };
}