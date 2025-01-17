function viewModel() {
    var self = this;

    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.vlList = ko.observableArray();
    self.dataList = ko.observableArray();
    self.yearList = [];
    self.monthList = [];

    self.tab = ko.observable('Case');
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.vl = ko.observable();
    self.year = ko.observable(moment().year());
    self.month = ko.observable(moment().format('MM'));
    self.place = null;
    self.dataArr = [];

    self.formatDate = function (date) {
        moment(date).format('DD-MM-YYYY')
    }

    for (var i = 2018; i <= moment().year() ; i++) {
        self.yearList.push(i);
    }

    for (var i = 1; i <= 12; i++) {
        self.monthList.push(('0' + i).substr(-2));
    }

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        self.place = p;
        if (app.user.prov != '') self.place.pv = self.place.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') self.place.od = self.place.od.filter(r => r.code == app.user.od);

        var arr = self.place.od.map(r => r.pvcode).distinct();
        self.place.pv = self.place.pv.filter(r => arr.contain(r.code));
        self.pvList(self.place.pv);
        getDataCase();
    });

    self.pv.subscribe(function (code) {
        self.odList(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
        changeCriteria();
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : self.place.hc.filter(r => r.odcode == code));
        let rs = dataArr.filter(r => r.Code_OD_T == code);
        code == undefined ? self.dataList(dataArr) : self.dataList(rs);
    });

    self.hc.subscribe(function (code) {
        self.vlList(code == null ? [] : self.place.vl.filter(r => r.hccode == code));
        let od = dataArr.filter(r => r.Code_OD_T == self.od());
        let hc = dataArr.filter(r => r.Code_Facility_T == code);
        code == undefined ? self.dataList(od) : self.dataList(hc);
    });

    self.year.subscribe(function () {
        changeCriteria();
    });

    self.month.subscribe(function () {
        changeCriteria();
    });

    function changeCriteria() {
        if (self.tab() == 'Stock HC') {
            getDataStockHC();
        } else if (self.tab() == 'Case') {
            getDataCase();
        } else if (self.tab() == 'Stock OD') {
            getDataStockOD();
        } else if (self.tab() == 'Follow Up') {
            getFollowUp();
        }
    }

    self.getProvinceName = function (code) {
        var found = self.place.pv.find(r => r.code == code);
        return found == null ? code : found.nameK;
    }

    self.getODName = function (code) {
        var found = self.place.od.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getHCName = function (code) {
        var found = self.place.hc.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVLName = function (code) {
        var found = self.place.vl.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    function getFollowUp() {
        app.ajax('/Log/getFollowupLog', { month: self.month(), year: self.year(), prov: self.pv() }).done(function (r) {
            rs = r.filter(x => {
                let t = JSON.parse(x.Description)
                return t.Diagnosis != 'N'
            })
            rs.map(function (x) {
                x.Description = self.formatDesc(x.Description)
                x.IsMobile = self.formatIsMobile(x.IsMobile)
                x.InitTime = formatDateTime(x.InitTime)
            });
            dataArr = rs;
            self.dataList(rs);
        })
    }

    function getDataCase() {
        app.ajax('/Log/getCaseLog', { month: self.month(), year: self.year(), prov: self.pv() }).done(function (r) {
            rs = r.filter(x => {
                let t = JSON.parse(x.Description)
                return t.Diagnosis != 'N'
            })
            rs.map(function (x) {
                x.Description = self.formatDesc(x.Description)
                x.IsMobile = self.formatIsMobile(x.IsMobile)
                x.InitTime = formatDateTime(x.InitTime)
            });
            dataArr = rs;
            self.dataList(rs);
        })
    }

    function getDataStockHC() {
        app.ajax('/Log/getStockHCLog', { month: self.month(), year: self.year(), prov: self.pv() }).done(function (r) {
            r.map(function (x) {
                x.IsMobile = self.formatIsMobile(x.IsMobile)
                x.InitTime = formatDateTime(x.InitTime)
            });
            dataArr = r;
            self.dataList(r);
        })
    }

    function getDataStockOD() {
        app.ajax('/Log/getStockODLog', { month: self.month(), year: self.year(), prov: self.pv() }).done(function (r) {
            r.map(function (x) {
                x.IsMobile = self.formatIsMobile(x.IsMobile)
                x.InitTime = formatDateTime(x.InitTime)
            });
            dataArr = r;
            self.dataList(r);
        })
    }

    self.formatDesc = function (str) {
        let obj = JSON.parse(str);
        return ' <i class="text-success">Diagnosis</i>: ' + formatSpecie(obj.Diagnosis)
            + ' <i class="text-success">Date Case</i>: ' + formatDate(obj.DateCase)
            + ' <i class="text-success">Name</i>: ' + obj.NameK
            + ' <i class="text-success">Age</i>: ' + obj.Age
            + ' <i class="text-success">Sex</i>: ' + obj.Sex
            //+ ' <i class="text-success">Weight</i>: ' + obj.Weight
    }

    self.formatIsMobile = function (str) {
        return str == 1 ? '<i class="fa fa-check-square-o "> </i>' : '<i class="fa fa-square-o"> </i>';
    }

    function formatDate(date) {
        return date == null ? 'N/A' : moment(date).format('DD-MM-YYYY')
    }

    function formatSpecie(specie) {
        let bg = specie == 'N' ? "bg-danger" : "bg-info";
        return '<span class="badge ' + bg +' text-dark">' + specie + ' </span>'
    }

    function formatDateTime(date) {
        return moment(date).format('DD-MM-YYYY HH:mm');
    }

    self.menuClick = function (root, event) {
        $('.btn-menu').removeClass('active btn-default');
        $('.btn-menu').each(function () {
            this == event.currentTarget ? $(this).addClass('active') : $(this).addClass('btn-default');
        });

        self.dataList([]);

        let tabName = $(event.currentTarget).text();
        self.tab(tabName);

        if (tabName == 'Case') getDataCase();
        if (tabName == 'Stock HC') getDataStockHC();
        if (tabName == 'Stock OD') getDataStockOD();
        if (tabName == 'Follow Up') getFollowUp();
    };

}