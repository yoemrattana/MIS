function viewModel() {
    var self = this;

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
    self.month = ko.observable(moment().month());
    self.place = null;
    dataArr = [];

    self.backHouse = function () {
        self.view('houses');
    }

    self.formatDate = function (date) {
        moment(date).format('DD-MM-YYYY')
    }

    for (var i = 2020; i <= moment().year() ; i++) {
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
    });

    self.pv.subscribe(function (code) {
        self.odList(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
        getData();
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

    self.vl.subscribe(function (code) {
        let od = dataArr.filter(r => r.Code_OD_T == self.od());
        let hc = dataArr.filter(r => r.Code_Facility_T == self.hc());
        let vl = dataArr.filter(r => r.Code_Vill_T == code);
        code == undefined ? self.dataList(hc) : self.dataList(vl);
    });

    self.year.subscribe(function () {
        getData();
    });

    self.month.subscribe(function () {
        getData();
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
        app.ajax('HFFollowupData/getData', { province: self.pv(), year: self.year(), month: self.month() }).done(function (rs) {
            dataArr = rs
            self.dataList(dataArr);
        });
    }

    self.loadFollowup = function (callback, page) {

        let case_id = page.ctx.id();
        let day = page.currentId;

        app.ajax('HFFollowupData/getFollowup', { case_id: case_id, day: day }).done(function (rs) {
            if (rs.followup != null) {
                var temp = rs.followup.Code;
                temp = isnullempty(temp) ? [] : Array.isArray(temp) ? temp : temp.split(', ');
                rs.followup.Code = ko.observableArray(temp);

                rs.followup.Call = rs.followup.Call == 'Yes';
                rs.followup.Refered = rs.followup.Refered == 'Yes';
            }
            callback(rs);
        });
    }

}