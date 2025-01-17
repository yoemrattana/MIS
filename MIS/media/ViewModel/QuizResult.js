function viewModel() {
    var self = this;
    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.vlList = ko.observableArray();
    self.dataList = ko.observableArray();

    self.pv  = ko.observable();
    self.od  = ko.observable();
    self.hc  = ko.observable();
    self.vl  = ko.observable();
    self.tab = ko.observable();
    self.view = ko.observable();
    
    self.place = null;
    var pvData = [];

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        self.place = p;
        if (app.user.prov != '') self.place.pv = self.place.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') self.place.od = self.place.od.filter(r => r.code == app.user.od);

        var arr = self.place.od.map(r => r.pvcode).distinct();
        self.place.pv = self.place.pv.filter(r => arr.contain(r.code));
        self.pvList(self.place.pv);

        getData();
    });

    function getData() {
        app.ajax('/Quiz/getQuizResult').done(function ( rs ) {
            dataArr = rs;
            self.dataList(dataArr);
        })
    }

    self.pv.subscribe(function (code) {
        setTimeout(() => {
            let rs = dataArr.filter(r => r.Code_Prov_N == code && r.Category == self.tab());
            pvData = rs;
            let pvByTab = dataArr.filter(r => r.Category == self.tab());
            code == undefined ? self.dataList(pvByTab) : self.dataList(rs);
            self.odList(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
        }, 300);
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : self.place.hc.filter(r => r.odcode == code));
        let rs = dataArr.filter(r => r.Code_OD_T == code);
        code == undefined ? self.dataList(pvData) : self.dataList(rs);
    });

    self.hc.subscribe(function (code) {
        self.vlList(code == null ? [] : self.place.vl.filter(r => r.hccode == code));
        let od = dataArr.filter(r => r.Code_OD_T == self.od());
        let hc = dataArr.filter(r => r.Code_Facility_T == code);
        code == undefined ? self.dataList(od) : self.dataList(hc);
    });

    self.menuClick = function (root, event) {
        $('.btn-menu').removeClass('active btn-default');
        $('.btn-menu').each(function () {
            this == event.currentTarget ? $(this).addClass('active') : $(this).addClass('btn-default');
        });

        self.view('quizresult');

        let tabName = $(event.currentTarget).text();
        self.tab(tabName);

        filter();
    };

    function filter() {
        let rs = dataArr.filter(r => r.Category == self.tab());
        self.dataList(rs);
    }

    self.getHCName = function (code) {
        var found = self.place.hc.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVLName = function (code) {
        var found = self.place.vl.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };
}