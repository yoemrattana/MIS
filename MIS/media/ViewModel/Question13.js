function subViewModel(self) {

	self.getData('tblQuestion13');

	self.save = function () {
		var model = app.unko(self.detailModel());
		var Rec_ID = model.Rec_ID;
		var locations = [{ name: 'L1', value: model.Q1aName }, { name: 'L2', value: model.Q1bName }, { name: 'L3', value: model.Q1cName }];

		if (Rec_ID == null) {
			model.InitTime = moment().format('YYYY-MM-DD HH:mm:ss');
			model.ModiTime = null;
			model.InitUser = app.user.username;
			model.SubmitOD = app.user.role == 'OD' ? app.user.od : null;
			url = '/Direct/insert';
		} else {
			model.ModiUser = app.user.username;
			model.ModiTime = moment().format('YYYY-MM-DD HH:mm:ss');
			url = '/Direct/update';
		}

		delete model.Rec_ID;

		var submit = {
			table: 'tblQuestion13',
			value: model,
			where: { Rec_ID: Rec_ID }
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax(url, submit).done(function (rs) {
			if (Rec_ID == null) {
			    self.listModel.push(rs);
			    self.detailModel().Rec_ID(rs.Rec_ID);
			    ko.acceptChanges(self.detailModel());
			} else {
				var old = self.listModel().find(r => r.Rec_ID == Rec_ID);
				self.listModel.replace(old, rs);
			}
		    self.view('list');
		});
		ko.acceptChanges(self.detailModel());

		locations.forEach(function (r) {
		    if (r.value == '') {
		        var del = {
		            table: 'tblVMWActiveCaseDection',
		            where: { Q13ID: Rec_ID, Location: r.name }
		        };
		        submit = { submit: JSON.stringify(del) };
		        app.ajax('/Direct/delete', submit);
		    }
		});
	};

	self.choosePlace = function () {
		self.placeModel1().show(4, function (p) {
			var model = self.detailModel();
			model.Code_Prov_T(p.prov());
			model.Code_OD_T(p.od());
			model.Code_Facility_T(p.hc());
			model.Code_Vill_T(p.vill());
		});
	};

	self.chooseMMW = function () {
		self.placeModel1().show(4, function (p) {
			var model = self.detailModel();
			model.HFMMW(p.hc());
			model.VillMMW(p.vill());
		});
	};

	self.chooseVill = function () {
		self.placeModel1().show(4, function (p) {
			var model = self.detailModel();
			model.VOR(p.vill());
		});
	};

	self.addCases = function (index, el) {
	    var label = el.currentTarget.text;
	    if (ko.isDirty(self.detailModel())) {
	        $('#modalSave').modal('show');
	        return;
	    }
	    var element = $(el.currentTarget);
	    var location = element.attr('name');
	    if (location == 'L1' && self.detailModel().Q1aName() == '') {
	        app.showMsg('Warning!', '<kh>មិនទាន់បានបញ្ចូលទីតាំង</kh> Please insert location!'); return;
	    }

	    if (location == 'L2' && self.detailModel().Q1bName() == '') {
	        app.showMsg('Warning!', '<kh>មិនទាន់បានបញ្ចូលទីតាំង</kh> Please insert location!'); return;
	    }

	    if (location == 'L3' && self.detailModel().Q1cName() == '') {
	        app.showMsg('Warning!', '<kh>មិនទាន់បានបញ្ចូលទីតាំង</kh> Please insert location!'); return;
	    }
	    
	    var link = '/Question/q13Cases/' + self.detailModel().Rec_ID() + '/' + location + '/' + self.detailModel().Code_Vill_T() + '';
	    window.open(link, '_blank');
	}

}