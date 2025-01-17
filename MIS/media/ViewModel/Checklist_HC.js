function subViewModel(self) {
	self.tableName = 'tblChecklistHC';
	self.getData();

	self.misData = ko.observable();

	function newMasterModel() {
		return {
			Rec_ID: 0,
			Code_Facility_T: null,
			VisitDate: null,
			CheckFrom: null,
			CheckTo: null,
			VisitorName: '',
			VisitorSex: null,
			MissionNo: '',
			Participants: [newParticipant()],
			Detail: null
		};
	}

	self.showNew = function () {
		self.showDetail(newMasterModel());
	};

	function newParticipant() {
		return { name: '', position: '' }
	}

	self.addParticipant = function () {
		self.masterModel().Participants.push(newParticipant());
	}

	self.deleteParticipant = function (model) {
		self.masterModel().Participants.remove(model);
	}

	function newDetailModel() {
		var obj = {};
        
		obj['P1Q1'] = { tick: '', date: '' };

		var keys = ['P1Q1_1', 'P1Q5'];
		keys.forEach(k => obj[k] = { tick: [] });

		var keys = ['P1Q2', 'P1Q3', 'P1Q4', 'P1Q6'];
		keys.forEach(k => obj[k] = { tick: '', reason: '' });

		var keys = ['P1Q1_1', 'P1Q5'];
		keys.forEach(k => obj[k] = { tick: [] });

		var keys = Array.repeat(6).map((r, i) => 'P1Q7_' + (i + 1));
		keys.forEach(k => obj[k] = { tick: false, problem: '' });

		var keys = Array.repeat(10).map((r, i) => 'P2Q' + (i + 1));
		keys.forEach(k => obj[k] = { tick: '', reason: '' });

		var keys = ['test', 'pf', 'pv', 'mix', 'minor', 'severe', 'death'];
		obj['P2Q11'] = {};
		keys.forEach(k => obj['P2Q11'][k] = { month1: '', month2: '', month3: '', remark: '' });

		var keys = ['P3Q1', 'P3Q2', 'P3Q6', 'P3Q7'];
		keys.forEach(k => obj[k] = { qty: '', reason: '' });

		obj['P4'] = ko.observableArray([newPatient()]);

		var keys = Array.repeat(10).map((r, i) => 'P5Q' + (i + 1));
		keys.forEach(k => obj[k] = { tick: '', reason: '' });

		obj['P6'] = ko.observableArray([newChallenge()]);

		return obj;
	}

	function newPatient() {
		return { sex: '', age: '', species: '', medicine: '', qty: '', duration: '', answer: '', note: '' };
	}

	self.addPatient = function () {
		self.detailModel().P4.push(newPatient());

		$('input[numonly]').each(function () {
			app.setNumberOnly(this, $(this).attr('numonly'));
		});
	}

	self.deletePatient = function (model) {
		self.detailModel().P4.remove(model);
	}

	function newChallenge(old) {
		old = old || {};

		return {
			problem: old.problem || '',
			solution: old.solution || '',
			duty: ko.observableArray(old.duty || []),
			status: old.status || '',
			date: old.date || ''
		};
	}

	self.addChallenge = function () {
		self.detailModel().P6.push(newChallenge());
	}

	self.deleteChallenge = function (model) {
		self.detailModel().P6.remove(model);
	}

	self.showDetail = function (model) {
		self.lastScrollY = window.scrollY;
		self.misData({});

		if (model.Rec_ID > 0) {
			if (model.Participants == null) model.Participants = [newParticipant()]
			else if (!Array.isArray(model.Participants)) model.Participants = JSON.parse(model.Participants);
		}

		model = app.ko(model);

		if (model.Code_Prov_N == null) model.Code_Prov_N = ko.observable();
		if (model.Code_OD_T == null) model.Code_OD_T = ko.observable();

		model.pvList = self.place.pv;
		model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());
		model.hcList = () => self.place.hc.filter(r => r.odcode == model.Code_OD_T());

		self.masterModel(model);

		model.CheckFrom.subscribe(function (from) {
			$(model.CheckTo.element).data('DateTimePicker').minDate(from);
			if (model.CheckTo() != null && model.CheckTo() < from) model.CheckTo(null);
		});

		model.Code_Facility_T.subscribe(getMISData);
		model.CheckFrom.subscribe(getMISData);
		model.CheckTo.subscribe(getMISData);

		var detail = newDetailModel();
		if (model.Rec_ID() > 0) {
			var d = JSON.parse(model.Detail());

			for (var key in detail) {
				if (key == 'P4') {
					detail[key](d[key]);
					continue;
				}
				if (key == 'P6') {
					detail[key](d[key].map(r => newChallenge(r)));
					continue;
				}

				var item = detail[key];
				for (var name in item) {
					if (ko.isObservable(item[name])) item[name](d[key][name]);
					else item[name] = d[key][name];
				}
			}

			setTimeout(getMISData, 1);
		}

		self.detailModel(detail);
		self.view('detail');

		$('input[numonly]').each(function () {
			app.setNumberOnly(this, $(this).attr('numonly'));
		});

		window.scrollTo(0, 0);
	};

	function getMISData() {
		if (['Code_Facility_T', 'CheckFrom', 'CheckTo'].some(k => self.masterModel()[k]() == null)) return;

		var submit = {
			hc: self.masterModel().Code_Facility_T(),
			from: self.masterModel().CheckFrom().format('YYYYMM'),
			to: self.masterModel().CheckFrom().clone().add(2, 'month').format('YYYYMM')
		};

		app.ajax('/Checklist/getMISDataHC', submit).done(function (rs) {
			rs.pfmix24 = (rs.pfmix24 || 100) + '%';
			rs.pv24 = (rs.pv24 || 100) + '%';
			rs.pfmix3 = (rs.pfmix3 || 100) + '%';

			for (var k in rs) {
				rs[k] = rs[k] || 0;
			}

			rs.deathMonth1 = 0;
			rs.deathMonth2 = 0;
			rs.deathMonth3 = 0;

			self.misData(rs);
		});
	}

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
		if (model.MissionNo() == '') {
			window.scrollTo(0, 0);
			app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខបេសកកម្ម</kh>');
			return;
		}

		var master = app.unko(model);
		master.VisitDate = master.VisitDate.format('YYYY-MM-DD');
		master.CheckFrom = master.CheckFrom.format('YYYY-MM');
		master.CheckTo = master.CheckTo.format('YYYY-MM');
		master.Participants = JSON.stringify(master.Participants);
		master.Detail = JSON.stringify(app.unko(self.detailModel()));

        delete master.completeness;

		master = Object.keys(newMasterModel()).reduce((rs, k) => {
			rs[k] = typeof master[k] == 'string' && k != 'MissionNo' ? master[k].trim() : master[k];
			return rs;
		}, {});

		var submit = {
			tbl: self.tableName,
			master: master
		};
		submit = { submit: JSON.stringify(submit) };
		app.ajax('/Checklist/save', submit).done(function (rs) {
            if (master.Rec_ID == 0) {
                rs.completeness = 1;
				self.listModel.push(rs);
			} else {
                var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
                rs.completeness = 1;
				self.listModel.replace(old, rs);
			}

			self.view('list');
		});
	};
}