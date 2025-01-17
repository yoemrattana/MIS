function subViewModel(self) {
	self.tableName = 'tblChecklistEpi';
	self.getData();

	self.showNew = function () {
		var newMasterModel = {
			Rec_ID: 0,
			Code_Prov_N: null,
			Code_OD_T: null,
			Code_Facility_T: null,
			VisitDate: null,
			CheckFrom: null,
			CheckTo: null,
			VisitorName: '',
			VisitorSex: 'M',
			VisitorPosition: '',
			VisitorPhone: '',
			VisitorWorkplace: '',
			Part1Score: null,
			Part2Score: null,
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
		var obj = {};

		var keys = ['Q1', 'Q2', 'Q3', 'Q4'];
		keys.forEach(k => {
			obj[k] = {
				Answer: {
					thisYear: {
						hc: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
						vmw: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
						total: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' }
					},
					lastYear: {
						hc: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
						vmw: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
						total: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' }
					}
				},
				Score: ''
			};
		});

		var keys = ['Q5', 'Q6', 'Q7', 'Q8', 'P1Q1', 'P1Q2', 'P1Q4'];
		keys.forEach(k => {
			obj[k] = {
				Answer: {
					hc: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
					vmw: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
					total: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' }
				},
				Score: ''
			};
		});

		var keys = ['P1Q1', 'P1Q2', 'P1Q4'];
		keys.forEach(k => {
			obj[k] = {
				Answer: {
					hc: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
					vmw: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
					total: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
				},
				Score: ''
			};
		});

		var keys = ['P1Q6', 'P1Q7'];
		keys.forEach(k => {
			obj[k] = {
				Answer: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
				Score: ''
			};
		});

		var keys = ['P1Q3', 'P1Q5', 'P1Q8'];
		keys.forEach(k => {
			obj[k] = {
				Answer: { tick: [], other: '' },
				Score: ''
			};
		});

		var keys = ['Q9', 'Q10', 'P1Q6_1', 'P1Q7_1', 'Request', 'Problem', 'Solution'];
		keys.forEach(k => {
			obj[k] = { Answer: '', Score: '' };
		});

		var keys = ['P1Q11', 'P2Q1'];
		keys.forEach(k => {
			obj[k] = {
				Answer: { tick: '', other: '', qty1: '', percent1: '', qty2: '', percent2: '', qty3: '', percent3: '' },
				Score: ''
			};
		});

		var keys = ['P2Q3', 'P2Q4'];
		keys.forEach(k => {
			obj[k] = {
				Answer: { tick: '', other: '', qty1: '', qty2: '' },
				Score: ''
			};
		});

		obj.P1Q9 = {
			Answer: {
				tablet: { L1: '', L2: '', L3: '', L4: '', IMP: '' },
				paper: { L1: '', L2: '', L3: '', L4: '', IMP: '' }
			},
			Score: ''
		};

		obj.P1Q10 = {
			Answer: { tick: '', other: '' },
			Score: ''
		};

		obj.P2Q2 = {
			Answer: { tick: '', other: '', qty1: '', qty2: '', qty3: '' },
			Score: ''
		};

		obj.P2Q5 = {
			Answer: { test: '', bednet: '', educate: '' },
			Score: ''
		};

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

		model.CheckFrom.subscribe(function (from) {
			$(model.CheckTo.element).data('DateTimePicker').minDate(from);
			if (model.CheckTo() != null && model.CheckTo() < from) model.CheckTo(null);
		});

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
					detail[r.Question] = {
						Answer: JSON.parse(r.Answer),
						Score: r.Score
					};
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
		if (model.VisitDate() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ថ្ងៃចុះអភិបាល</kh>');
			return;
		}
		if (model.CheckFrom() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ត្រួតពិនិត្យពី</kh>');
			return;
		}
		if (model.CheckTo() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ត្រួតពិនិត្យដល់</kh>');
			return;
		}
		if (model.VisitorName().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ឈ្មោះអ្នកបំពេញទំរង់</kh>');
			return;
		}
		if (model.VisitorPosition().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល តួនាទី</kh>');
			return;
		}
		if (model.VisitorPhone().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ទូរស័ព្ទលេខ</kh>');
			return;
		}
		if (model.VisitorWorkplace() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ទីកន្លែងធ្វើការ</kh>');
			return;
		}
		if (model.MissionNo() == '') {
		    window.scrollTo(0, 0);
		    app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខបេសកកម្ម</kh>');
		    return;
		}

		var master = app.unko(model);
		master.VisitDate = master.VisitDate.format('YYYY-MM-DD');
		master.CheckFrom = master.CheckFrom.format('YYYY-MM');
		master.CheckTo = master.CheckTo.format('YYYY-MM');
		master.VisitorName = master.VisitorName.trim();
		master.VisitorPosition = master.VisitorPosition.trim();
		master.VisitorPhone = master.VisitorPhone.trim();
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
				Answer: JSON.stringify(detail[k].Answer),
				Score: isempty(detail[k].Score, null)
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