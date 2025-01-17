function viewModel() {
    var self = this;
    var today = moment();
    
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.reportList = ko.observableArray();
    self.yearList = ko.observableArray();
    self.monthList = ko.observableArray();

    self.view = ko.observable('list');
    self.year = ko.observable(moment().year());
    self.month = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.detail = ko.observable();

    var prov = sessionStorage.code_prov;
    var hcData = [];
    var data = [];
    var firstWarnElement = null;

    for (var i = 2018; i <= self.year() ; i++) {
        self.yearList.push(i);
    }
    for (var i = 1; i <= 12; i++) {
        self.monthList.push({ id: i, name: ('0' + i).substr(-2) });
    }

    app.getPlace(['pv', 'od', 'hc'], function (p) {
        place = p;
        self.odList(place.od.filter(r => r.pvcode == prov || r.code == app.user.od));
        hcData = place.hc;
    });

    self.od.subscribe(function (code) {
        self.reportList([]);
        self.hcList(hcData.filter(r => r.odcode == code));
    });

    self.hc.subscribe(function () {
        self.getReport();
    });

    self.year.subscribe(function () {
        self.getReport();
    });

    self.month.subscribe(function () {
        self.getReport();
    })

    self.getReport = function () {
        if (self.hc() == null) {
            self.reportList([]);
            return;
        }
        var submit = { year: self.year(), month: self.month(), hc: self.hc() };
        app.ajax('getG6PD', submit).done(function (rs) {
            data = [];
            rs.forEach(r => data.push(app.ko(r)));
            self.reportList(data);
            for(x of self.reportList()) { ko.track(x) }
        });
    };

    self.dateFormat = function (date) {
        return moment(date()).format('DD-MM-YYYY');
    };

    self.edit = function (model) {
        var temp = model.Day1Code();
        temp = isnullempty(temp) ? [] : Array.isArray(temp) ? temp :  temp.split(', ');
        model.Day1Code = ko.observableArray(temp);
        
        var temp = model.Day3Code();
        temp = isnullempty(temp) ? [] : Array.isArray(temp) ? temp : temp.split(', ');
        model.Day3Code = ko.observableArray(temp);

        var temp = model.Day7Code();
        temp = isnullempty(temp) ? [] : Array.isArray(temp) ? temp : temp.split(', ');
        model.Day7Code = ko.observableArray(temp);

        var temp = model.Day14Code();
        temp = isnullempty(temp) ? [] : Array.isArray(temp) ? temp : temp.split(', ');
        model.Day14Code = ko.observableArray(temp);
        
        self.detail(model);
        self.view('detail');
    }

    self.update = function () {
        var submit = app.unko(self.detail());

        submit.Day1Code = submit.Day1Code.join(', ');
        submit.Day3Code = submit.Day3Code.join(', ');
        submit.Day7Code = submit.Day7Code.join(', ');
        submit.Day14Code = submit.Day14Code.join(', ');

        ko.acceptChanges(self.detail());
        app.ajax('/CaseReport/updateG6PD/', { submit: JSON.stringify(submit) }).done(function (rs) {
            self.reportList().find(x => {
                if (x.G6PDCode() == submit.G6PDCode) {
                    x.Rec_ID(rs);
                }
            });
            ko.acceptChanges(self.detail());
            self.view('list');
        });
    }

    self.delete = function (model) {
        app.showDelete(function () {
            var submit = {
                table: 'tblG6PDInvestigation',
                where: { Rec_ID: model.Rec_ID() }
            };
            submit = { submit: JSON.stringify(submit) };
            app.ajax('/Direct/delete', submit).done(function () {
                app.showMsg('Delete', 'Delete successful!');
                var old = self.reportList().find(x=>x.G6PDCode() == model.G6PDCode());
                old.Rec_ID(null);
                old.Consult('');
                old.ACT('');
                old.G6PDHb('');
                old.G6PDdL('');
                old.Primaquine('');
                old.Primaquine15('');
                old.Primaquine75('');
                old.Phone('');
                old.Day1Code('');
                old.Day1Refered('');
                old.Day3Code('');
                old.Day3Call('');
                old.Day3Refered('');
                old.Day7Code('');
                old.Day7Call('');
                old.Day7Refered('');
                old.Day14Code('');
                old.Day14Call('');
                old.Day14Tablet('');
                old.Day14Refered('');
                ko.acceptChanges(model);
            });
        });
    };

    self.notSave = function () {
        self.view('list');
    };

    self.isSingle = function (arr) {
        return arr.length <= 1;
    };

    self.back = function () {
        if (ko.isDirty(self.detail())) {
            $('#modalSave').modal('show');
            return;
        }
        self.view('list');
    };

    $(".search").bind("keyup", function (event) {
        var ekeyCode = event.keyCode;
        if (ekeyCode == 8 || ekeyCode == 46) {
            self.reportList(data);
        }
    });
}