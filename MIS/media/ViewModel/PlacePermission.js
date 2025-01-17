function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.provList = ko.observableArray();
	self.prov = ko.observable();

	self.tab = ko.observable('Permission');
	self.odList = ko.observableArray();
	self.od = ko.observable();
	self.hcList = ko.observableArray();
	self.hc = ko.observable();
	self.hcListModel = ko.observableArray();
	self.vlListModel = ko.observableArray();
	self.deviceModel = ko.observable();
	self.permissModel = ko.observableArray();

	var place = null;

	var listData = [];
	var listHCData = [];
	var permissList = [];
	var listVlData = [];

	app.getPlace(['pv', 'od', 'hc'], function (p) {
	    place = p;
		var pvs = p.od.map(r => r.pvcode).distinct();
		p.pv = p.pv.filter(r => pvs.contain(r.code));
		self.provList(p.pv);

		setTimeout(function () {
		    listData = JSON.parse($('#listModel').val());

			listData.forEach(r => {
				var p = self.provList().find(p => p.code == r.Code_OD_T.substr(0, 2));
				r.provE = p.name;
				r.provK = p.nameK;
				r.Is_Enable_VMW_Report = ko.observable(r.Is_Enable_VMW_Report);
				r.Is_Enable_Investigation_Report = ko.observable(r.Is_Enable_Investigation_Report);
				r.Is_Enable_Reactive_Report = ko.observable(r.Is_Enable_Reactive_Report);
				r.Is_Enable_SMS_Alert = ko.observable(r.Is_Enable_SMS_Alert);
				r.Is_Radical_Cure = ko.observable(r.Is_Radical_Cure);
				r.Is_Radical_Cure_HSD = ko.observable(r.Is_Radical_Cure_HSD);
                r.Is_Elimination = ko.observable(r.Is_Elimination);
                r.Is_URC_Stock = ko.observable(r.Is_URC_Stock);
                r.IsFinger = ko.observable(r.IsFinger);
                r.IsRdtPhoto = ko.observable(r.IsRdtPhoto);
			});
			
			self.listModel(listData);
		});
	});


	app.ajax('/PlacePermission/getData').done(function (rs) {
	    
	    listHCData = rs.reminder;
	    listHCData.forEach(r => {
            r.IsReminder = ko.observable(r.IsReminder);
            r.IsFinger = ko.observable(r.IsFinger);
            r.IsRdtPhoto = ko.observable(r.IsRdtPhoto);
	    });

	    listVlData = rs.village.sortasc('Name_Vill_E');
	    listVlData.forEach(r => {
	        r.IsLastmile = ko.observable(r.IsLastmile);
	    })
	    self.vlListModel(listVlData);

	    self.hcListModel(listHCData);
	    //self.deviceModel(rs.device);
	    device = rs.device;
	    
	    Object.keys(rs.device).forEach(r => {
	        permissList.push({ Permiss: r, Val: ko.observable(rs.device[r]) })
	    })
	    self.permissModel(permissList);
	});

	self.changeReminder = function (model) {
	    var v = model.IsReminder() ? 1 : 0;

	    var submit = {
	        table: 'tblHFCodes',
	        value: { IsReminder: v },
	        where: { Code_Facility_T: model.Code_Facility_T }
	    };
	    submit = { submit: JSON.stringify(submit) };

	    app.ajax('/Direct/update', submit).done(function () {
	        model.IsReminder(v);
	    });
    }

    self.changeFinger = function (model) {
        var v = model.IsFinger() ? 1 : 0;

        var submit = {
            table: 'tblHFCodes',
            value: { IsFinger: v },
            where: { Code_Facility_T: model.Code_Facility_T }
        };
        submit = { submit: JSON.stringify(submit) };

        app.ajax('/Direct/update', submit).done(function () {
            model.IsFinger(v);
        });
    }

    self.changeRdt = function (model) {
        var v = model.IsRdtPhoto() ? 1 : 0;

        var submit = {
            table: 'tblHFCodes',
            value: { IsRdtPhoto: v },
            where: { Code_Facility_T: model.Code_Facility_T }
        };
        submit = { submit: JSON.stringify(submit) };

        app.ajax('/Direct/update', submit).done(function () {
            model.IsRdtPhoto(v);
        });
    }

	self.changeLastmile = function (model) {
	    var v = model.IsLastmile() ? 1 : 0;

	    var submit = {
	        table: 'tblCensusVillage',
	        value: { IsLastmile: v },
	        where: { Code_Vill_T: model.Code_Vill_T }
	    };
	    submit = { submit: JSON.stringify(submit) };

	    app.ajax('/Direct/update', submit).done(function () {
	        model.IsLastmile(v);
	    });
	}

	self.changePermiss = function (model) {
	    var v = model.Val() ? 1 : 0;
	    var value = {};
	    value[model.Permiss] = v;
	    var submit = {
	        table: 'tblDevicePermission',
	        value: value,
	        where: {  }
	    };
	    submit = { submit: JSON.stringify(submit) };

	    app.ajax('/Direct/update', submit).done(function () {
	        model.Val(v);
	    });
	}

	self.changeVMW = function (model) {
		var v = model.Is_Enable_VMW_Report() ? 1 : 0;

		var submit = {
			table: 'tblOD',
			value: { Is_Enable_VMW_Report: v },
			where: { Code_OD_T: model.Code_OD_T }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			model.Is_Enable_VMW_Report(v);
		});
	};

	self.changeInvestigate = function (model) {
		var v = model.Is_Enable_Investigation_Report() ? 1 : 0;

		var submit = {
			table: 'tblOD',
			value: { Is_Enable_Investigation_Report: v },
			where: { Code_OD_T: model.Code_OD_T }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			model.Is_Enable_Investigation_Report(v);
		});
	};

	self.changeRadical = function (model) {
	    var v = model.Is_Radical_Cure() ? 1 : 0;
	    
	    var submit = {
	        table: 'tblOD',
	        value: { Is_Radical_Cure: v },
	        where: {Code_OD_T: model.Code_OD_T}
	    }
	    submit = { submit: JSON.stringify(submit) };

	    app.ajax('/Direct/update', submit).done(function () {
	        model.Is_Radical_Cure(v)
	    });
	}

	self.changeRadicalHSD = function (model) {
		var v = model.Is_Radical_Cure_HSD() ? 1 : 0;

		var submit = {
			table: 'tblOD',
			value: { Is_Radical_Cure_HSD: v },
			where: { Code_OD_T: model.Code_OD_T }
		}
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			model.Is_Radical_Cure_HSD(v)
		});
	}

	self.changeElimination = function (model) {
	    var v = model.Is_Elimination() ? 1 : 0;

	    var submit = {
	        table: 'tblOD',
	        value: { Is_Elimination: v },
	        where: { Code_OD_T: model.Code_OD_T }
	    }
	    submit = { submit: JSON.stringify(submit) };

	    app.ajax('/Direct/update', submit).done(function () {
	        model.Is_Elimination(v)
	    });
    }

    self.changeURCStock = function (model) {
        var v = model.Is_URC_Stock() ? 1 : 0;

        var submit = {
            table: 'tblOD',
            value: { Is_URC_Stock: v },
            where: { Code_OD_T: model.Code_OD_T }
        }
        submit = { submit: JSON.stringify(submit) };

        app.ajax('/Direct/update', submit).done(function () {
            model.Is_URC_Stock(v)
        });
    }

	self.changeReactive = function (model) {
		var v = model.Is_Enable_Reactive_Report() ? 1 : 0;

		var submit = {
			table: 'tblOD',
			value: { Is_Enable_Reactive_Report: v },
			where: { Code_OD_T: model.Code_OD_T }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			model.Is_Enable_Reactive_Report(v);
		});
	};

	self.changeSMS = function (model) {
		var v = model.Is_Enable_SMS_Alert() ? 1 : 0;

		var submit = {
			table: 'tblOD',
			value: { Is_Enable_SMS_Alert: v },
			where: { Code_OD_T: model.Code_OD_T }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/update', submit).done(function () {
			model.Is_Enable_SMS_Alert(v);
		});
	};

	self.prov.subscribe(function (pv) {
	    self.listModel(pv == null ? listData : listData.filter(r => r.Code_OD_T.substr(0, 2) == pv));
	    self.hcListModel(pv == null ? listHCData : listHCData.filter(r => r.Code_Prov_N == pv));
	    self.vlListModel([]);
	    var before = self.od();
	    self.odList(pv == null ? [] : place.od.filter(r => r.pvcode == pv));
	    if (before == self.od()) self.od.notifySubscribers(before);
	});

	self.od.subscribe(code => {
	    self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
	    self.vlListModel([]);
	    if (code != null) {
	        self.hcListModel(listHCData.filter(r=>r.Code_OD_T == code));
	    } else {
	        self.hcListModel(self.prov() == null ? listHCData : listHCData.filter(r=>r.Code_Prov_N == self.prov()));
	    }
	});

	self.hc.subscribe(code => {
	    if (code != null) {
	        self.hcListModel(listHCData.filter(r => r.Code_Facility_T == code));
	        self.vlListModel(listVlData.filter(r => r.HCCode == code));
	    } else {
	        self.hcListModel(self.od() == null ? listHCData : listHCData.filter(r => r.Code_OD_T == self.od()));
	        self.vlListModel([]);
	    }
	});

}