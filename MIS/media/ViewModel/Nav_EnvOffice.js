function viewModel() {
    var self = this;

    self.listModel = ko.observableArray();
    self.editModel = ko.observable();

    self.provList = ko.observableArray();
    self.prov = ko.observable();

    var mainData = [];

    app.getPlace(['pv'], function (p) {
        self.provList(p.pv);

        app.ajax('/SystemMenu/getEnvOffice').done(function (rs) {
            mainData = rs;
            updateFilter();
        });
    });

    self.showCreate = function () {
        var arr = mainData.map(r => r.Code_Office_T);
        var model = {
            Code_Prov_T: null,
            Code_Office_T: arr.length == 0 ? '001' : (Math.max(...arr) + 1).toString().padStart(3, '0'),
            Name_Office_E: '',
            Name_Office_K: '',
            Rec_ID: 0
        };

        self.showEdit(model);
    };

    self.showEdit = function (model) {
        model = app.ko(model);
        self.editModel(model);
        $('#modalEdit').modal('show');
    };

    self.edit = function () {
        var model = self.editModel();

        model.Name_Office_E(model.Name_Office_E().trim());
        model.Name_Office_K(model.Name_Office_K().trim());

        var missing = false;
        if (model.Rec_ID() == 0 && model.Code_Prov_T() == null) {
            app.showWarning(model.Code_Prov_T.element, 'Please input this box.');
            missing = true;
        }
        if (model.Name_Office_E() == '') {
            app.showWarning(model.Name_Office_E.element, 'Please input this box.');
            missing = true;
        }
        if (model.Name_Office_K() == '') {
            app.showWarning(model.Name_Office_K.element, 'Please input this box.');
            missing = true;
        }
        if (missing) return;

        $('#modalEdit').modal('hide');
        model = app.unko(model);

        var submit = {
            submit: JSON.stringify({
                value: {
                    Code_Office_T: model.Code_Office_T,
                    Name_Office_E: model.Name_Office_E,
                    Name_Office_K: model.Name_Office_K,
                    Code_Prov_T: model.Code_Prov_T
                },
                where: { Rec_ID: model.Rec_ID }
            })
        };

        app.ajax('/SystemMenu/saveOffice', submit).done(function (rs) {
            if (model.Rec_ID == 0) {
                self.listModel.push(rs);
                mainData.push(rs);
            } else {
                var old = self.listModel().find(r => r.Rec_ID == model.Rec_ID);
                self.listModel.replace(old, rs);

                mainData = mainData.filter(r => r.Rec_ID != old.Rec_ID);
                mainData.push(rs);
            }
        });
    };

    self.delete = function (model) {
        app.showDelete(function () {
            var submit = { Rec_ID: model.Rec_ID };
            app.ajax('/SystemMenu/deleteOffice', submit).done(function () {
                self.listModel.remove(model);
                mainData = mainData.filter(r => r.Rec_ID != old.Rec_ID);
            });
        });
    };

    self.prov.subscribe(updateFilter);

    function updateFilter() {
        self.listModel(self.prov() == null ? mainData : mainData.filter(r => r.Code_Prov_T == self.prov()));
    }
}