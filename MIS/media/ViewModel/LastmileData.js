function viewModel() {
    var self = this;

    self.view = ko.observable('list');

    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.vlList = ko.observableArray();
    self.dataList = ko.observableArray();
    self.yearList = [];
    self.monthList = [];

    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.vl = ko.observable();
    self.year = ko.observable(moment().year());
    self.month = ko.observable();
    self.place = null;
    self.dataArr = [];

    var pvs = [];
    var ods = [];
    var hcs = [];
    var vls = [];

    self.rowLimit = ko.observable(200);

    self.back = function () {
        self.view('list');
    };

    self.backHouse = function () {
        self.view('houses');
    }

    self.formatDate = function (date) {
        return date == null ? '' : moment(date).format('DD-MM-YYYY')
    }

    for (var i = 2021; i <= moment().year() ; i++) {
        self.yearList.push(i);
    }

    for (var i = 1; i <= 12; i++) {
        self.monthList.push(('0' + i).substr(-2));
    }

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        self.place = p;
        
        app.ajax('LastmileData/getPreData').done(function (rs) {
            hcs = rs.hc;
            pvs = rs.pv;
            ods = rs.od;
            vls = rs.vl;

            if (app.user.prov != '') pvs = pvs.filter(r => app.user.prov.contain(r.code));
            if (app.user.od != '') ods = ods.filter(r => r.code == app.user.od);

            self.pvList(pvs);
            self.odList(ods);
            self.vlList(vls);

            if (pvs.length > 0) self.pv(pvs[0].code);
            else getData();
        });
    });

    self.pv.subscribe(function (code) {
        self.odList(code == null ? [] : ods.filter(r => r.pvcode == code));
        getData();
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : hcs.filter(r => r.od == code));
        let rs = dataArr.filter(r => r.Code_OD_T == code);
        code == undefined ? self.dataList(dataArr) : self.dataList(rs);
    });

    self.hc.subscribe(function (code) {
        self.vlList(code == null ? [] : vls.filter(r => r.hccode == code));
        let od = dataArr.filter(r => r.Code_OD_T == self.od());
        let hc = dataArr.filter(r => r.Code_Facility_T == code);
        code == undefined ? self.dataList(od) : self.dataList(hc);
    });

    self.vl.subscribe(function (code) {
        let od = dataArr.filter(r => r.Code_OD_T == self.od());
        let hc = dataArr.filter(r => r.Code_Facility_T == self.hc());
        let vl = dataArr.filter(r => r.Code_Vill_T == code);
        code == undefined ? self.dataList(hc) : self.dataList(vl);
    });

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

    /*
    *   Specific data
    */
    function getData() {
    	app.ajax('LastmileData/getData', { province: self.pv() }).done(function (rs) {
            dataArr = rs
            self.dataList(dataArr);
        });
    }

    self.loadHouse = function (callback, page) {
        house_id = page.viewModel.house_id();
        app.ajax('LastmileData/getHouse', { house_id: house_id }).done(function (rs) {
            callback(rs);
        });
    }

    self.loadTda = function (callback, page) {
        house_id = page.viewModel.house_id();
        app.ajax('LastmileData/getTda', { house_id: house_id }).done(function (rs) {
            callback(rs);
        });
    }

    self.loadIpt = function (callback, page) {
        house_id = page.viewModel.house_id();
        app.ajax('LastmileData/getIpt', { house_id: house_id }).done(function (rs) {
            callback(rs);
        });
    }

    self.loadAfs = function (callback, page) {
        house_id = page.viewModel.house_id();
        app.ajax('LastmileData/getAfs', { house_id: house_id }).done(function (rs) {
            callback(rs);
        });
    }

    self.dataList.subscribe(() => self.rowLimit(200));
}