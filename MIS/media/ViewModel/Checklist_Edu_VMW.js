function subViewModel(self) {
	self.tableName = 'tblChecklistEduVMW';
	self.getData();

	self.showNew = function () {
		var newMasterModel = {
			Rec_ID: 0,
			Code_Prov_N: null,
			Code_OD_T: null,
			Code_Facility_T: null,
			Code_Vill_T: null,
			VisitDate: null,
			VisitorName: '',
			VisitorPosition: '',
			VisitorWorkplace: null,
			VMWName: '',
			VMWSex: null,
			VMWPhone: '',
			MissionNo: '',
			Participants: [new participant()],
		};

		self.showDetail(newMasterModel);
	};

	function participant() {
		return {
			name: ko.observable(null),
			position: ko.observable(null)
	    }
	}

	self.addParticipant = function () {
	    self.masterModel().Participants.push(new participant());
	}

	self.deleteParticipant = function (model) {
	    self.masterModel().Participants.remove(model);
	}

	function newDetailModel() {
		return {
			Q1: { meeting: '', reason: '' },
			Q2: '',
			Q3: { times: '', participant: '', female: '' },
			Q4: { how: '', reason: '' },
			Q5: '',
			Q6: [],
			Q7: { who: '', name: '' },
			Q8: '',
			Q9: [],
			Q10: '',
			Q11: { transfer: '', virus: '' },
			Q12: '',
			Problem: '',
            Solution: '',
			Q13: ''
		};
	}

	self.showDetail = function (model) {
	    self.lastScrollY = window.scrollY;

	    if (model.Rec_ID > 0) {
	        if (model.Participants == null) model.Participants = [new participant()]
	        else if (!Array.isArray(model.Participants)) model.Participants = JSON.parse(model.Participants);
	    }

		model = app.ko(model);

		model.pvList = self.place.pv;
		model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());
		model.hcList = () => self.place.hc.filter(r => r.odcode == model.Code_OD_T());
		model.vlList = () => self.place.vl.filter(r => r.hccode == model.Code_Facility_T());

		self.masterModel(model);
		var detail = newDetailModel();

		if (model.Rec_ID() == 0) {
			self.detailModel(detail);
			self.view('detail');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		} else {
			var submit = {
				id: model.Rec_ID(),
				tbl: self.tableName
			};
			app.ajax('/Checklist/getDetail', submit).done(function (rs) {
				rs.forEach(r => {
					detail[r.Question] = JSON.parse(r.Answer);
				});
				self.detailModel(detail);
				self.view('detail');

				$('input[numonly]').each(function () {
					app.setNumberOnly(this, $(this).attr('numonly'));
				});
			});
		}

		window.scrollTo(0, 0);
	};

	self.save = function () {
		var model = self.masterModel();

		if (model.Code_Prov_N() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ខេត្ត</kh>');
			return;
		}
		if (model.Code_OD_T() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ស្រុកប្រតិបត្ត</kh>');
			return;
		}
		if (model.Code_Facility_T() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល មណ្ឌលសុខភាព</kh>');
			return;
		}
		if (model.Code_Vill_T() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ភូមិ</kh>');
			return;
		}
		if (model.VisitDate() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ថ្ងៃចុះអភិបាល</kh>');
			return;
		}
		if (model.VisitorName().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ឈ្មោះអ្នកអភិបាល</kh>');
			return;
		}
		if (model.VisitorPosition().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល តួនាទី</kh>');
			return;
		}
		if (model.VisitorWorkplace() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ទីកន្លែងធ្វើការ</kh>');
			return;
		}
		if (model.VMWName().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ឈ្មោះអ្នកស្ម័គ្រចិត្តភូមិ</kh>');
			return;
		}
		if (model.VMWPhone().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខទូរស័ព្ទ</kh>');
			return;
		}
		if (model.MissionNo() == '') {
		    window.scrollTo(0, 0);
		    app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខបេសកកម្ម</kh>');
		    return;
		}
		
		var master = app.unko(model);
		master.VisitDate = master.VisitDate.format('YYYY-MM-DD');
		master.VisitorName = master.VisitorName.trim();
		master.VisitorPosition = master.VisitorPosition.trim();
		master.VMWName = master.VMWName.trim();
		master.VMWPhone = master.VMWPhone.trim();
		master.MissionNo = master.MissionNo.trim();
		master.Participants = JSON.stringify(master.Participants);
		delete master.pvList;
		delete master.odList;
		delete master.hcList;
		delete master.vlList;
		delete master.Code_Prov_N;
		delete master.Code_OD_T;
		delete master.Code_Facility_T;
		delete master.completeness;

		var detail = self.detailModel();
		var list = [];
		Object.keys(detail).forEach(k => {
			list.push({
				Question: k,
				Answer: JSON.stringify(detail[k]),
			});
		});
		
		var submit = {
			tbl: self.tableName,
			master: master,
			details: list
		};
		
		submit = { submit: JSON.stringify(submit) };
		
		app.ajax('/Checklist/save', submit).done(function (rs) {
			if (master.Rec_ID == 0) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
				self.listModel.replace(old, rs);
			}

			self.view('list');
		});
	};
}