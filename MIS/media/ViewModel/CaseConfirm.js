function viewModel() {
    var self = this;
    self.pvList = ko.observableArray();
    self.listModel = ko.observableArray();
    self.detailModel = ko.observable();
    self.view = ko.observable('list');

    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.notifyDate = ko.observable('');
    self.editModel = ko.observable();
    self.filter = ko.observable();

    var place = null;

    app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
        place = p;
        place.od = place.od.filter(r => r.target == 1);
        self.pvList(place.pv.filter(r => r.target == 1));

        app.ajax('/CaseConfirm/getData').done(function (rs) {
            let list = rs.map(r => {
                r.IsConfirm = ko.observable(r.IsConfirm)
                return r;
            })
            self.listModel(list);
        });
    });


    self.getListModel = ko.pureComputed(function () {
        var list = self.listModel();

        if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());
        if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
        if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());

        return list;
    });

    self.confirm = function (model) {
        app.ajax('/CaseConfirm/confirm', { rec_id: model.Rec_ID, case_type: model.CaseType, description: model.Description }).done(function (rs) {
            model.IsConfirm(1);
        })
    }

    self.reject = function (model) {
        app.ajax('/CaseConfirm/reject', { rec_id: model.Rec_ID }).done(function (rs) {
            model.IsConfirm(2);
        })
    }

    self.odList = function () {
        return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
    };

    self.hcList = function () {
        return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
    };

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

    self.getVill = function (code) {
        if (code == null || code === '') return '';
        if (code == '999') return 'Unknown';
        var found = code.length == 10 ? place.vl.find(r => r.code == code)
            : code.length == 6 ? place.hc.find(r => r.code == code)
                : code.length == 4 ? place.ds.find(r => r.code == code)
                    : code.length == 2 ? place.pv.find(r => r.code == code)
                        : null;

        return found == null ? code : found.nameK;
    };

    self.getSpecie = function (specie) {
        return specie == 'F' ? 'Pf'
            : specie == 'V' ? 'Pv'
                : specie == 'M' ? 'Mix'
                    : specie == 'A' ? 'Pm'
                        : specie == 'O' ? 'Po'
                            : 'Pk';
    }
}