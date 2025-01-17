function subViewModel(self) {
	self.tableName = 'tblChecklistEduHC';
	self.getData();

	self.showNew = function () {
	    var newMasterModel = {
	        Rec_ID: 0,
	        Code_Prov_N: null,
	        Code_OD_T: null,
	        Code_Facility_T: null,
	        VisitDate: null,
	        VisitorName: '',
	        VisitorPosition: '',
	        VisitorWorkplace: null,
	        DoctorName: '',
	        DoctorSex: null,
	        DoctorPhone: '',
	        DoctorPosition: '',
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
			Q2: {
				village: '', villageVMW: '', villageMMW: '',
				vmw: '', mmw: '', vhv: '',
				mobile: '', immigration: '',
				site: '', worker: '',
				hcData: {
					m1: { total: '',test: '', pf: '', pv: '', mix: '', pm:'' , pk: '' },
					m2: { total: '',test: '', pf: '', pv: '', mix: '', pm:'' , pk: '' },
					m3: { total: '',test: '', pf: '', pv: '', mix: '', pm:'' , pk: '' },
				},
				vmwData: {
					m1: { total: '',test:'', pf: '', pv: '', mix: '', pm:'', pk:'' },
					m2: { total: '',test:'', pf: '', pv: '', mix: '', pm:'', pk:'' },
					m3: { total: '',test:'', pf: '', pv: '', mix: '', pm:'', pk:'' },
				},
				//asmqAdult: { total: '', expire: null },
				//asmqChildren: { total: '', expire: null },
				//primarquine: { total: '', expire: null },
				//rdt: { total: '', expire: null },
			},
			Q31: {
				meeting: '', meetingReason: '',
				vmw: '', absent: '', absentReason: '',
				message: '', messageReason: '',
				topic: '', meetingSetup: '', meetingSetupReason: ''
			},
			Q32: {
				educate: '', reason: '',
				times: '', people: '', female: '',
				who: '', other: '',
				schedule: '', method: ''
			},
			Q331: {
				community: '', reason: '',
				people: '', female: '', male: '',
				equipment: [],
				implement: '',
				experience: ''
			},
			Q332: {
				educate: '', educatedVillage: '',
				people: '', female: '', male: '',
				noneducatedVillage: '', reason: '',
				challenge: ''
			},
			Q341: '',
			Q342: {
				equipment: [], distribution: '',
				banner: '', location: '', broken: ''
			},
			//Q4: {
			//	bednet: '', total: '', reason: ''
			//},
			Q5: '',
			Q6: '',
			Q7: '',
			Problem: '',
            Solution: ''
		};
	}

	function prepareExpireIO(obj) {
		//['asmqAdult', 'asmqChildren', 'primarquine', 'rdt'].forEach(name => {
		//	var item = obj.Q2[name];

		//	item.expireIO = ko.pureComputed({
		//		read: function () {
		//			return item.expire;
		//		},
		//		write: function (value) {
		//			item.expire = value.format('YYYY-MM-DD');
		//		}
		//	});
		//});
		
		return obj;
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

		self.masterModel(model);
		var detail = newDetailModel();

		if (model.Rec_ID() == 0) {
			self.detailModel(prepareExpireIO(detail));
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
				self.detailModel(prepareExpireIO(detail));
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
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល តួនាទីអ្នកអភិបាល</kh>');
			return;
		}
		if (model.VisitorWorkplace() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ទីកន្លែងធ្វើការ</kh>');
			return;
		}
		if (model.DoctorName().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ឈ្មោះមន្ត្រីមណ្ឌលសុខភាព</kh>');
			return;
		}
		if (model.DoctorPhone().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខទូរស័ព្ទ</kh>');
			return;
		}
		if (model.DoctorPosition().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល តួនាទីមន្ត្រីមណ្ឌលសុខភាព</kh>');
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
		master.DoctorName = master.DoctorName.trim();
		master.DoctorPhone = master.DoctorPhone.trim();
		master.DoctorPosition = master.DoctorPosition.trim();
		master.MissionNo = master.MissionNo.trim();
		master.Participants = JSON.stringify(master.Participants);

		delete master.pvList;
		delete master.odList;
		delete master.hcList;
		delete master.Code_Prov_N;
		delete master.Code_OD_T;
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