function subViewModel(self) {
	self.tableName = 'tblChecklistLabo';
	self.getData();

	function setOrderNumber() {
		$('#laboDetail thead').find('th:first').each(function () {
			var th = document.createElement('th');
			th.width = 30;
			if ($(this).attr('rowspan') > 0) th.rowSpan = $(this).attr('rowspan');
			$(this).before(th);
		});

		$('#laboDetail tbody').each(function () {
			$(this).find('tr').each(function (i) {
				$(this).prepend('<td class="en" align="center" valign="middle">' + (i + 1) + '</td>')
			});
		});
	}

	self.showNew = function () {
		var newMasterModel = {
			Rec_ID: 0,
			Code_Prov_N: null,
			Code_Dist_T: null,
			VisitDate: null,
			VisitorWorkplace: '',
			HFName: '',
			HFPhone: '',
			HFTelegram: '',
			LaboChief: '',
			LaboChiefTelegram: '',
			HospitalChief: '',
			HospitalChiefTelegram: '',
			Interviewee: '',
			Interviewer: '',
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

		var part = 'P2';
		for (var i = 1; i <= 3; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		obj['P2Q4'] = Array.repeat(5, () => {
			return {
				microscope: '',
				month: '',
				basis: '',
				refresher: '',
				evaluation: '',
				note: ''
			};
		});

		var part = 'P3';
		for (var i = 1; i <= 7; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P4_1';
		for (var i = 1; i <= 5; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P4_2';
		for (var i = 1; i <= 4; i++) {
			var k = part + 'Q' + i;
			obj[k] = i <= 3 ? { answer: '', note: '' } : { answer: '', note: '', useColor: false, other: '' };
		}

		var part = 'P4_3';
		for (var i = 1; i <= 2; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P4_4';
		for (var i = 1; i <= 8; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P5_1';
		for (var i = 1; i <= 12; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P5_2';
		for (var i = 1; i <= 6; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: ['', '', '', '', ''] };
		}

		var part = 'P6';
		for (var i = 1; i <= 5; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P7';
		for (var i = 1; i <= 9; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P8';
		for (var i = 1; i <= 10; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P9_1';
		for (var i = 1; i <= 8; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P9_2';
		for (var i = 1; i <= 7; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P9_3';
		for (var i = 1; i <= 10; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P9_4';
		for (var i = 1; i <= 23; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		var part = 'P10';
		for (var i = 1; i <= 6; i++) {
			var k = part + 'Q' + i;
			obj[k] = { answer: '', note: '' };
		}

		obj['ProblemSolution'] = '';

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
		model.dsList = () => self.place.ds.filter(r => r.pvcode == model.Code_Prov_N());

		self.masterModel(model);
		var detail = newDetailModel();

		if (model.Rec_ID() == 0) {
			self.detailModel(detail);
			setOrderNumber();
			self.view('detail');
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
				setOrderNumber();
				self.view('detail');
			});
		}

		window.scrollTo(0, 0);
	};

	self.save = function () {
		var model = self.masterModel();

		if (model.HFName().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ឈ្មោះគ្រឹះស្ថានសុខាភិបាល</kh>');
			return;
		}
		if (model.VisitDate() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ថ្ងៃចុះអភិបាល</kh>');
			return;
		}
		if (model.VisitorWorkplace() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ទីកន្លែងធ្វើការ</kh>');
			return;
		}
		if (model.Code_Prov_N() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ខេត្ត</kh>');
			return;
		}
		if (model.Code_Dist_T() == null) {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ស្រុក</kh>');
			return;
		}
		if (model.HFPhone().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខទូរសព្ទគ្រឹះស្ថានសុខភាព</kh>');
			return;
		}
		if (model.HFTelegram().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខតេឡេក្រាមគ្រឹះស្ថានសុខភាព</kh>');
			return;
		}
		if (model.LaboChief().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ប្រធានមន្ទីរពិសោធន៍</kh>');
			return;
		}
		if (model.LaboChiefTelegram().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខតេឡេក្រាមប្រធានមន្ទីរពិសោធន៍</kh>');
			return;
		}
		if (model.HospitalChief().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ប្រធានមន្ទីរពេទ្យ</kh>');
			return;
		}
		if (model.HospitalChiefTelegram().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខតេឡេក្រាមប្រធានមន្ទីរពេទ្យ</kh>');
			return;
		}
		if (model.Interviewee().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល បុគ្គលិកមន្ទីរពិសោធន៍ទទួលសម្ភាសន៍</kh>');
			return;
		}
		if (model.Interviewer().trim() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល អ្នកសម្ភាសន៍</kh>');
			return;
		}
		if (model.MissionNo() == '') {
		    window.scrollTo(0, 0);
		    app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខបេសកកម្ម</kh>');
		    return;
		}

		var master = app.unko(model);
		master.HFName = master.HFName.trim();
		master.VisitDate = master.VisitDate.format('YYYY-MM-DD');
		master.HFPhone = master.HFPhone.trim();
		master.HFTelegram = master.HFTelegram.trim();
		master.LaboChief = master.LaboChief.trim();
		master.LaboChiefTelegram = master.LaboChiefTelegram.trim();
		master.HospitalChief = master.HospitalChief.trim();
		master.HospitalChiefTelegram = master.HospitalChiefTelegram.trim();
		master.Interviewee = master.Interviewee.trim();
		master.Interviewer = master.Interviewer.trim();
		master.MissionNo = master.MissionNo.trim();
		master.Participants = JSON.stringify(master.Participants);

		delete master.pvList;
		delete master.dsList;
		delete master.Code_Prov_N;
		delete master.completeness;

		var detail = self.detailModel();
		var list = [];
		Object.keys(detail).forEach(k => {
			list.push({
				Question: k,
				Answer: JSON.stringify(detail[k])
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