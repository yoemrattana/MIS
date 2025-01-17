function viewModel() {
    var self = this;

    self.listModel = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.od = ko.observable();
    self.hc = ko.observable();

    self.hasChange = false;
    self.goto = '';

    var mainData = [];
    var hcData = [];
    var changeList = [];
    var prov = $('#code_prov').val();
    var rowLimit = app.newRowLimit(50);

    app.getPlace(['od', 'hc'], function (p) {
        odData = p.od.filter(r => r.pvcode == prov);
        var ods = odData.map(r => r.code);
        hcData = p.hc.filter(r => ods.contain(r.odcode));

        self.odList(odData);
        self.hcList(hcData);

        app.ajax('/SystemMenu/getHHold/' + prov).done(function (data) {
            for (var i = 0; i < data.length; i++) {
                for (var y = 2017; y <= 2025; y++) {
                    data[i][y] = ko.observable(data[i][y]);
                    data[i][y].vill = data[i]['Code_Vill_T'];
                    data[i][y].year = y;
                }
            }
            mainData = data;
            self.listModel(data);

            for (var i = 0; i < data.length; i++) {
            	for (var y = 2017; y <= 2025; y++) {
                    app.setNumberOnly(data[i][y].element, 'int');

                    data[i][y].subscribe(function (hhold) {
                        self.hasChange = true;

                        var vill = this._target.vill;
                        var year = this._target.year;
                        var found = changeList.find(r => r.vill == vill && r.year == year);
                        if (found == null) {
                            changeList.push({ vill: vill, year: year, hhold: hhold });
                        } else {
                            found.hhold = hhold;
                        }
                    });
                }
            }
        });
    });

    self.save = function (goAfterSave) {
        if (changeList.length == 0) return;

        var submit = { list: JSON.stringify(changeList) };

        app.ajax('/SystemMenu/saveHHold', submit).done(function () {
            self.hasChange = false;
            if (goAfterSave === 1) location = self.goto;
        });
    };

    self.od.subscribe(function (code) {
    	var before = self.hc();

    	self.hcList(code == null ? [] : hcData.filter(r => r.odcode == code));

    	if (before == self.hc()) self.hc.notifySubscribers(before);
    });

    self.hc.subscribe(function (code) {
    	if (code != null) {
    		self.listModel(mainData.filter(r => r.HCCode == code));
    	} else if (self.od() != null) {
    		self.listModel(mainData.filter(r => r.Code_OD_T == self.od()));
    	} else {
    		self.listModel(mainData);
    	}

    	rowLimit.reset();
    });

    self.home = function () {
        self.goto = '/';
        if (self.hasChange) $('#modalSave').modal('show');
        else location = '/';
    };

    self.yes = function () {
        $('#modalSave').modal('hide');
        self.save(1);
    };

    self.no = function () {
        location = self.goto;
    };

    self.sortTable = function (col, method) {
    	var before = self.listModel.slice(0);

    	self.listModel.sort(function (a, b) {
    		var aa = a[col], bb = b[col];
    		if (method !== undefined) {
    			aa = self[method](aa);
    			bb = self[method](bb);
    		}
    		if (typeof aa == 'string') {
    			aa = aa.toLowerCase();
    			bb = bb.toLowerCase();
    		}
    		return aa > bb ? 1 : aa < bb ? -1 : 0;
    	});
    	var rows = self.listModel();

    	var sorted = true;
    	for (var i = 0; i < before.length; i++) {
    		if (before[i] === rows[i]) continue;
    		sorted = false;
    		break;
    	}
    	if (sorted) self.listModel.reverse();

    	window.scrollTo({ top: 0 });
    	rowLimit.reset();
    };

    self.getListModel = ko.pureComputed(function () {
    	return self.listModel().filter((r, i) => i < rowLimit());
    });

    $(window).scroll(function () {
    	if (innerHeight + scrollY + 1000 < document.body.scrollHeight) return;
    	if (rowLimit() > self.listModel().length) return;
    	rowLimit.increase();
    });
}