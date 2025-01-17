function subViewModel(self) {
	self.tableName = 'tblChecklistOD';
	self.getData();

	self.misData = ko.observable();

	function newMasterModel() {
		return {
			Rec_ID: 0,
			Code_OD_T: null,
			VisitDate: null,
			CheckFrom: null,
			CheckTo: null,
			VisitorName: '',
			VisitorSex: null,
			MissionNo: '',
			Participants: [newParticipant()],
			Interviewee: '',
			IntervieweePosition: '',
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

		var keys = ['P1Q1_1', 'P1Q1_2'];
		keys.forEach(k => obj[k] = { tick: '', reason: '' });

		obj['P1Q2'] = ko.observableArray([newBudget()]);

		obj['P1Q3_1'] = { tick: '', llin: '', llihn: '', reason: '' };

		var keys = ['P1Q3_2', 'P1Q3_3'];
		keys.forEach(k => obj[k] = { tick: '' });

		obj['P1Q4'] = { tick: '', qty: '', place: '', reason: '' };
		obj['P1Q5'] = { tick: '', reason: '', money: '' };
		obj['P1Q6'] = { tick: '', date: '' };
		obj['P1Q7'] = { tick: '', reason: '', report: [] };

		var keys = ['P1Q8_1', 'P1Q8_2'];
		keys.forEach(k => {
			obj[k] = {
				qty: '',
				plan: ko.observable(''),
				done: ko.observable(''),

				percent: function () {
					return this.plan() === '' || this.done() === '' ? ''
						: (parseInt(this.done()) * 100 / parseInt(this.plan())).toFixed(0) + '%';
				}
			};
		});

		obj['P2Q1'] = { tick: '', medicine: '', qty: '', date: '' };
		obj['P2Q2'] = { tick: '', test: '', qty: '', date: '' };
		obj['P2Q3'] = { tick: '', medicine: '', qty: '', date: '', reason: '' };

		var keys = ['P2Q4', 'P2Q5', 'P2Q6'];
		keys.forEach(k => obj[k] = { tick: '', reason: '' });

		var keys = ['P2Q7', 'P2Q8'];
		keys.forEach(k => obj[k] = { tick: '', qty: '', reason: '' });

		obj['P3Q1'] = { tick: '' };
		obj['P3Q2'] = { date: '' };
		obj['P3Q3'] = { tick: '', od: '', od_topic: '', hc: '', hc_topic: '', vmw: '', vmw_topic: '' };

		var keys = ['test', 'positive', 'pf', 'pv', 'mix', 'other', 'minor', 'severe', 'death'];
		obj['P3Q4'] = keys.reduce((rs, k) => {
			rs[k] = ko.observable('');
			rs[k + '_note'] = '';
			return rs;
		}, {});

		var keys = ['P4Q1', 'P4Q2', 'P4Q3'];
		keys.forEach(k => obj[k] = { qty: ko.observable(''), reason: '' });

		obj['P4Q4'] = { tick: [], qty: ko.observable(''), reason: '' };

		var keys = ['P4Q5', 'P4Q6', 'P4Q7'];
		keys.forEach(k => obj[k] = { qty: ko.observable(''), reason: '' });

		obj['P5'] = ko.observableArray([newChallenge()]);

		return obj;
	}

	function newBudget(old) {
		old = old || {};

		return {
			budget: old.budget || '',
			name: old.name || '',
			plan: ko.observable(old.plan || ''),
			result: ko.observable(old.result || ''),
			note: old.note || '',

			percent: function () {
				return this.plan() === '' || this.result() === '' ? ''
					: (parseFloat(this.result()) * 100 / parseFloat(this.plan())).toFixed(0) + '%';
			}
		};
	}

	self.addBudget = function () {
		self.detailModel().P1Q2.push(newBudget());

		$('input[numonly]').each(function () {
			app.setNumberOnly(this, $(this).attr('numonly'));
		});
	}

	self.deleteBudget = function (model) {
		self.detailModel().P1Q2.remove(model);
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
		self.detailModel().P5.push(newChallenge());
	}

	self.deleteChallenge = function (model) {
		self.detailModel().P5.remove(model);
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
		model.pvList = self.place.pv;
		model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());

		self.masterModel(model);

		model.CheckFrom.subscribe(function (from) {
			$(model.CheckTo.element).data('DateTimePicker').minDate(from);
			if (model.CheckTo() != null && model.CheckTo() < from) model.CheckTo(null);
		});

		model.Code_OD_T.subscribe(getMISData);
		model.CheckFrom.subscribe(getMISData);
		model.CheckTo.subscribe(getMISData);

		var detail = newDetailModel();
		if (model.Rec_ID() > 0) {
			var d = JSON.parse(model.Detail());

			for (var key in detail) {
				if (key == 'P1Q2') {
					detail[key](d[key].map(r => newBudget(r)));
					continue;
				}
				if (key == 'P5') {
					detail[key](d[key].map(r => newChallenge(r)));
					continue;
				}

				var item = detail[key];
				for (var name in item) {
					if (ko.isObservable(item[name])) item[name](d[key][name]);
					else if (typeof item[name] != 'function') item[name] = d[key][name];
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
		if (['Code_OD_T', 'CheckFrom', 'CheckTo'].some(k => self.masterModel()[k]() == null)) return;

		var submit = {
			od: self.masterModel().Code_OD_T(),
			from: self.masterModel().CheckFrom().format('YYYY-MM'),
			to: self.masterModel().CheckTo().format('YYYY-MM')
		};

		app.ajax('/Checklist/getMISDataOD', submit).done(function (rs) {
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