function viewModel() {
    var self = this;

    self.listModel = ko.observableArray();
    self.provList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.prov = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();

    self.year = ko.observable(2016);

    var place = null;
    var changeList = [];
    var ready = false;

    app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
    	setTimeout(function () {
    		place = p;
    		self.provList(p.pv);
    		self.prov(location.pathname.split('/')[3]);
    		getData();
    	});
    });

    function getData() {
    	var from = parseInt(self.year());
    	var to = parseInt(self.year()) + 9;

    	var submit = { pv: self.prov(), from: from, to: to };
    	app.ajax('/SystemMenu/getBedNetTarget', submit).done(function (rs) {
    		var list = [];
    		rs.vl.forEach(item => {
    			var code = item.code;
    			var vl = place.vl.find(r => r.code == code);
    			var hc = place.hc.find(r => r.code == vl.hccode);
    			var od = place.od.find(r => r.code == hc.odcode);

    			var row = {
    				odCode: od.code, odName: od.name,
    				hcCode: hc.code, hcName: hc.name,
					vlName: vl.name, vlNameK: vl.nameK
    			};

    			for (var y = from; y <= to; y++) {
    				var has = rs.log.some(r => r.Code == code && r.Year == y);
    				row[y] = ko.observable(has);
    				row[y].info = { code: code, year: y, has: has };
    				row[y].subscribe(function (value) {
    					var info = this._target.info;
    					value === info.has ? changeList.remove(info) : changeList.push(info);
    				});
    			}
    			list.push(row);
    		});
    		self.listModel(list);
    		ready = true;
    	});
    }

    self.save = function () {
        if (changeList.length == 0) return;

        var submit = { list: JSON.stringify(changeList) };

        app.ajax('/SystemMenu/saveBedNetTarget', submit).done(function () {
        	changeList.forEach(r => r.has = !r.has);
        	changeList = [];
        });
    };

    self.prov.subscribe(function () {
    	self.odList(place.od.filter(r => r.pvcode == self.prov()));
    	if (ready) getData();
    });

    self.year.subscribe(function () {
    	if (ready) getData();
    });

    self.od.subscribe(function (odcode) {
    	self.hcList(place.hc.filter(r => r.odcode == odcode));
    });
}