function viewModel() {
    var self = this;

    self.model = ko.observable();
    self.listModel = ko.observableArray();
    self.hcList = ko.observableArray();
    self.referredFrom = ko.observable();
    self.has = ko.observable();

    self.case = ko.observable();
    var G6PDCode = '';

    self.getCase = function (submit) {
        app.ajax('/CaseReport/getHFCase/', submit).done(function (rs) {
            self.case(convertObj(rs));
            self.has(rs.Rec_ID != null);
        });
    }

    app.getPlace(['hc'], function (p) {
        var arr = location.pathname.split('/');
        self.hcList(p.hc.filter(r => r.odcode == arr.last()));
        G6PDCode = arr[arr.length - 2];
        var submit = { G6PDCode: G6PDCode };
        self.getCase(submit);
    });

    function convertObj(r) {
        var obj = app.ko(r);
        return obj;
    }

    self.save = function () {
        var c = self.case();
        var submit = app.unko(c);
        submit.G6PDCode = G6PDCode;
        app.ajax('/CaseReport/updateG6PD/', { submit: JSON.stringify(submit) }).done(function (rs) {
            app.showMsg('Update', 'Update/Insert successful!');
            self.has(true);
        });
    }

    self.delete = function () {
        app.showDelete(function () {
            var submit = {
                table: 'tblG6PDInvestigation',
                where: { G6PDCode: G6PDCode }
            };
            submit = { submit: JSON.stringify(submit) };

            app.ajax('/Direct/delete', submit).done(function () {
                app.showMsg('Delete', 'Delete successful!');
                window.close();
            });
        });
    }

    self.radioChange = function (evt) {
        if (evt.G6PD() == 'N') {
            evt.Consult('');
            evt.ASMQ('');
            evt.Primaquine('');
            evt.Primaquine15('');
            evt.Primaquine75('');
        }
    }
}