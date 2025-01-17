function subViewModel(self) {
	self.tableName = 'tblChecklistMnEOD';
	self.getData();

	self.misData = ko.observable();

	self.showNew = function () {
		var newMasterModel = {
			Rec_ID: 0,
			Code_Prov_N: null,
			Code_OD_T: null,
			VisitDate: null,
			CheckFrom: null,
			CheckTo: null,
			VisitorName: '',
			VisitorSex: null,
			MissionNo: '',
		    Participants: [new participant()],
		};

		self.misData(null);
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

		var keys = ['P1Q1_1', 'P1Q1_2', 'P1Q1_3'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ tick: '' }),
				Score: function () {
					return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
				}
			};
		});

		var keys = ['P1Q2_1', 'P1Q2_2', 'P1Q2_3'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ plan: '', result: '' }),
				Score: function () {
					var a = this.Answer;
					return a.plan() == '' || a.result() == '' ? ''
						: a.plan() == 0 ? '0'
						: (a.result() / a.plan() * 100).toFixed(0);
				}
			};
		});

		var keys = ['P1Q3_1', 'P1Q3_2', 'P1Q3_3', 'P1Q4', 'P1Q5', 'P1Q6', 'P1Q7'];
		keys.forEach(k => {
			obj[k] = {
				Answer: k != 'P1Q4' ? app.ko({ tick: '' }) : app.ko({ tick: '', other: '' }),
				Score: function () {
					return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
				}
			};
		});

		var keys = ['P1Q8_1', 'P1Q8_2', 'P1Q8_3'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ plan: '', result: '' }),
				Score: function () {
					var weights = { P1Q8_1: 2, P1Q8_2: 1, P1Q8_3: 2 };
					var a = this.Answer;
					return a.plan() == '' || a.result() == '' ? ''
						: a.plan() == 0 ? '0.00'
						: (a.result() * weights[k] / a.plan()).toFixed(2);
				}
			};
		});

		var keys = ['P2Q1', 'P2Q2', 'P2Q3', 'P2Q4', 'P2Q5'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ tick: '', stockin: '', stockout: '', balance: '', amc: '' }),
				Score: function () {
					return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
				}
			};
		});

		var keys = ['Test', 'Positive', 'Pf', 'Pv', 'Mix', 'Minor', 'Severe', 'Death', 'Report'];
		keys.forEach(k => {
			obj['P3VMW_' + k] = { Answer: app.ko(''), Score: () => '' };
			obj['P3HC_' + k] = { Answer: app.ko(''), Score: () => '' };
		});

		var keys = ['P4Q1', 'P4Q2', 'P4Q3', 'P4Q4', 'P4Q5'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko(''),
				Score: function () {
					var weights = k == 'P4Q1' ? 0.12 : 0.045;
					var percent = self.misAuto('P4G2', k).percent();
					return percent === '' ? '' : (percent.toFloat() * weights).toFixed(2).toFloat();
				}
			};
		});

		var keys = ['P5Q1', 'P5Q2'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ problem: '', solution: '', person: '', date: null }),
				Score: () => ''
			};
        });


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

		self.masterModel(model);

		model.CheckFrom.subscribe(function (from) {
			$(model.CheckTo.element).data('DateTimePicker').minDate(from);
			if (model.CheckTo() != null && model.CheckTo() < from) model.CheckTo(null);
		});

		model.Code_OD_T.subscribe(getMISData);
		model.CheckFrom.subscribe(getMISData);
		model.CheckTo.subscribe(getMISData);

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
					detail[r.Question].Answer = app.ko(JSON.parse(r.Answer));

				});
				self.detailModel(detail);
				self.view('detail');

				$('input[numonly]').each(function () {
					app.setNumberOnly(this, $(this).attr('numonly'));
				});

				getMISData();
			});
		}

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
		master.VisitorName = master.VisitorName.trim();
		master.MissionNo = master.MissionNo.trim();
		master.Part1Score = self.P1score();
		master.Part2Score = self.P2score();
		master.Part3Score = self.P3score();
		master.Part4Score = self.P4score();
		master.Participants = JSON.stringify(master.Participants);

		var completeness = master.completeness;
		delete master.pvList;
		delete master.odList;
		delete master.Code_Prov_N;
		delete master.completeness;

		var detail = self.detailModel();
		var list = [];
		Object.keys(detail).forEach(k => {
			list.push({
				Question: k,
				Answer: JSON.stringify(app.unko(detail[k].Answer)),
				Score: isempty(detail[k].Score(), null)
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
		        let ps = app.unko(self.detailModel);
		        ps1 = ps.P5Q1.problem != '' && ps.P5Q1.solution != '';
		        ps2 = ps.P5Q2.problem != '' && ps.P5Q2.solution != '';
		        rs.completeness = ps1 && ps2;
				self.listModel.push(rs);
			} else {
		        var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
		        rs.completeness = completeness;
				self.listModel.replace(old, rs);
			}

			self.view('list');
		});
	};

	self.misAuto = function (type, key) {
		if (type == 'stock') {
			var key1 = type + key;
			return {
				mis: self.misData() == null ? '' : self.misData()[key1] + '%',
				score: self.misData() == null ? '' : (self.misData()[key1] * 0.02).toFixed(2).toFloat()
			};
		} else if (type == 'VMW' || type == 'HC') {
			var key1 = 'P3' + type + '_' + key;
			var key2 = type.toLowerCase() + key;
			return {
				paper: self.detailModel()[key1].Answer,
				mis: self.misData() == null ? '' : self.misData()[key2],
				remain: function () {
					return this.paper() === '' ? '' : this.paper() - this.mis;
				},
				percent: function () {
					return this.paper() === '' ? '' : this.paper() == 0 ? '0%' : (Math.abs(this.remain()) * 100 / this.paper()).toFixed(0) + '%';
				}
			};
		} else if (type == 'avg') {
			var names = ['Test', 'Positive', 'Pf', 'Pv', 'Mix', 'Minor', 'Severe', 'Death', 'Report'];
			return (names.sum(name => self.misAuto(key, name).percent().toFloat()) / names.length).toFixed(1) + '%';
		} else if (type == 'total') {
			if (self.misData() == null) return '';
			var value = ((100 - self.misAuto('avg', key).toFloat()) * 0.05);
			return (value < 0 ? 0 : value).toFixed(2).toFloat();
		} else if (type == 'P4G1') {
			return self.misData() == null ? '' : Array.isArray(key) ? key.sum(k => self.misAuto(type, k)) : self.misData()[key];
		} else if (type == 'P4G2') {
			return {
				answer: self.detailModel()[key].Answer,
				percent: function () {
					var a = this.answer();
					if (a == '' || self.misData() == null) return '';
					var b = key == 'P4Q1' ? self.misAuto('P4G1', ['pf', 'pv', 'mix'])
						: key == 'P4Q2' ? self.misAuto('P4G1', ['pfL1', 'pvL1', 'mixL1'])
						: key == 'P4Q3' ? self.misAuto('P4G1', ['pfFoci', 'pvFoci', 'mixFoci'])
						: key == 'P4Q4' ? self.misAuto('P4G1', ['pfFoci', 'pvFoci', 'mixFoci'])
						: key == 'P4Q5' ? self.misAuto('P4G1', 'pv')
						: 0;
					return (b == 0 ? 100 : a * 100 / b).toFixed(0) + '%';
				},
				score: self.detailModel()[key].Score
			};
		}
	};

	function sumScore(arr) {
		return arr.sum(name => self.detailModel()[name].Score().toFloat());
	}

	self.P1Q2score = function () {
		return (sumScore(['P1Q2_1', 'P1Q2_2', 'P1Q2_3']) / 3).toFixed(0);
	};

	self.P1G1score = function () {
		return sumScore(['P1Q1_1', 'P1Q1_2', 'P1Q1_3']);
	};

	self.P1G2score = function () {
		return (self.P1Q2score().toFloat() * 0.05).toFixed(2).toFloat();
	};

	self.P1G3score = function () {
		return sumScore(['P1Q3_1', 'P1Q3_2', 'P1Q3_3', 'P1Q4', 'P1Q5', 'P1Q6', 'P1Q7']);
	};

	self.P1G4score = function () {
		return sumScore(['P1Q8_1', 'P1Q8_2', 'P1Q8_3']).toFixed(2).toFloat();
	};

	self.P1score = function () {
		return ['P1G1score', 'P1G2score', 'P1G3score', 'P1G4score'].sum(name => self[name]()).toFixed(2);
	};

	self.P2score = function () {
		var total = sumScore(['P2Q1', 'P2Q2', 'P2Q3', 'P2Q4', 'P2Q5']);
		total += self.misAuto('stock', 'Report').score;
		total += self.misAuto('stock', 'ACT').score;
		total += self.misAuto('stock', 'RDT').score;
		return total.toFloat().toFixed(2);
	};

	self.P3score = function () {
		return ['VMW', 'HC'].sum(k => self.misAuto('total', k).toFloat()).toFixed(2);
	};

	self.P4score = function () {
		return sumScore(['P4Q1', 'P4Q2', 'P4Q3', 'P4Q4', 'P4Q5']).toFixed(2);
	};

	self.grandTotal = function () {
		return ['P1score', 'P2score', 'P3score', 'P4score'].sum(k => self[k]().toFloat()).toFixed(2).toFloat();
	};
}