function subViewModel(self) {
	self.tableName = 'tblChecklistMnEHC';
	self.getData();

	self.vmwQty = ko.observable(0);

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
			VisitorSex: null,
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

		var keys = ['P1Q1', 'P1Q1_1', 'P1Q1_2', 'P1Q2', 'P1Q3', 'P1Q4', 'P1Q5', 'P1Q7'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ tick: '' }),
				Score: function () {
					return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
				}
			};
		});

		obj.P1Q6 = {
			Answer: app.ko({ tick: [] }),
			Score: function () {
				return this.Answer.tick().length * 2;
			}
		};

		var keys = ['P2Q1', 'P2Q2', 'P2Q3', 'P2Q4', 'P2Q5', 'P2Q6'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ tick: '' }),
				Score: function () {
					return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
				}
			};
		});

		obj.P3Q1 = {
			Answer: app.ko({ test: '', pf: '', pv: '', mix: '', positive: '' }),
			Score: () => ''
		};

		var keys = ['P3Q2', 'P3Q3'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ pf: '', pv: '', mix: '', positive: '' }),
				Score: () => ''
			};
		});

		var keys = ['P3Q2_1', 'P3Q3_1', 'P3Q5'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko(''),
				Score: () => ''
			};
		});

		obj.P3Q4 = {
			Answer: app.ko({ l1: '', lc: '' }),
			Score: () => ''
		};

		var keys = ['P3Q3_2', 'P3Q3_3', 'P3Q3_4'];
		obj.P3Q3_2 = {
			Answer: {
				tick: function () {
					var pfmix = parseInt(isempty(obj.P3Q2.Answer.pf(), 0)) + parseInt(isempty(obj.P3Q2.Answer.mix(), 0));
					var total = parseInt(isempty(obj.P3Q1.Answer.pf(), 0)) + parseInt(isempty(obj.P3Q1.Answer.mix(), 0));
					var percent = total == 0 ? 100 : pfmix * 100 / total;
					return pfmix == 0 ? 'No'
						: percent < 25 ? 'Under 25%'
						: percent < 50 ? '25%-49%'
						: percent < 75 ? '50%-74%'
						: '75%-100%';
				}
			}
		};
		obj.P3Q3_3 = {
			Answer: {
				tick: function () {
					var pv = parseInt(isempty(obj.P3Q2.Answer.pv(), 0));
					var total = parseInt(isempty(obj.P3Q1.Answer.pv(), 0));
					var percent = total == 0 ? 100 : pv * 100 / total;
					return pv == 0 ? 'No'
						: percent < 25 ? 'Under 25%'
						: percent < 50 ? '25%-49%'
						: percent < 75 ? '50%-74%'
						: '75%-100%';
				}
			}
		};
		obj.P3Q3_4 = {
			Answer: {
				tick: function () {
					var pfmix = parseInt(isempty(obj.P3Q3.Answer.pf(), 0)) + parseInt(isempty(obj.P3Q3.Answer.mix(), 0));
					var total = parseInt(isempty(obj.P3Q1.Answer.pf(), 0)) + parseInt(isempty(obj.P3Q1.Answer.mix(), 0));
					var percent = total == 0 ? 100 : pfmix * 100 / total;
					return pfmix == 0 ? 'No'
						: percent < 25 ? 'Under 25%'
						: percent < 50 ? '25%-49%'
						: percent < 75 ? '50%-74%'
						: '75%-100%';
				}
			}
		};

		keys.forEach(k => {
			obj[k].Score = function () {
				var weights = {
					P3Q3_2: { 'No': 8, 'Under 25%': 2, '25%-49%': 4, '50%-74%': 6, '75%-100%': 8 },
					P3Q3_3: { 'No': 8, 'Under 25%': 2, '25%-49%': 4, '50%-74%': 6, '75%-100%': 8 },
					P3Q3_4: { 'No': 4, 'Under 25%': 1, '25%-49%': 2, '50%-74%': 3, '75%-100%': 4 }
				};
				return this.Answer.tick() == '' ? '' : weights[k][this.Answer.tick()];
			};
		});

		obj.P4 = {
			Answer: app.ko({ qty: '', list: [] }),
			Score: () => ''
		};
		obj.P4.Answer.qty.subscribe(function () {
			var a = obj.P4.Answer;
			var qty = a.qty().toFloat();
			var len = a.list().length;
			if (len < qty) {
				for (var i = 0; i < qty - len ; i++) {
					var row = app.ko({ sex: '', age: '', virus: '', medicine: '', pill: '', duration: '', tick: '', score: '' });
					row.getScore = function () {
						this.score(this.tick() == '' ? '' : this.tick() == 'Correct' ? (10 / a.qty()).toFixed(2).toFloat() : 0);
						return this.score();
					}
					a.list.push(row);
				}
			} else if (len > qty) {
				a.list.splice(qty, len - qty);
			}

			$('input[numonly2]').each(function (index, el) {
				app.setNumberOnly(el, $(el).attr('numonly2'));
			});
		});

		var keys = ['P5Q1', 'P5Q2', 'P5Q3', 'P5Q4', 'P5Q5'];
		keys.forEach(k => {
			obj[k] = {
				Answer: app.ko({ tick: '' }),
				Score: function () {
					return this.Answer.tick() == '' ? '' : this.Answer.tick() == 'Stockout' ? 0 : 2;
				}
			};
		});

		var keys = ['P6Q1', 'P6Q2'];
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
		model.hcList = () => self.place.hc.filter(r => r.odcode == model.Code_OD_T());

		//model.Code_Facility_T.subscribe(getMISData);

		function refreshMaster(model) {
			self.masterModel(model);

			model.CheckFrom.subscribe(function (from) {
				$(model.CheckTo.element).data('DateTimePicker').minDate(from);
				if (model.CheckTo() != null && model.CheckTo() < from) model.CheckTo(null);
			});
		}

		var detail = newDetailModel();

		if (model.Rec_ID() == 0) {
			self.detailModel(detail);
			refreshMaster(model);
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
					if (r.Question.in('P3Q3_2', 'P3Q3_3', 'P3Q3_4')) return;

					if (r.Question == 'P4') {
						var a = JSON.parse(r.Answer);
						detail.P4.Answer.qty(a.qty);
						a.list.forEach((row, i) => {
							for (var k in row) {
								detail.P4.Answer.list()[i][k](row[k]);
							}
						});
					} else {
						detail[r.Question].Answer = app.ko(JSON.parse(r.Answer));
					}
				});

				self.detailModel(detail);
				refreshMaster(model);
				self.view('detail');

				$('input[numonly]').each(function () {
					app.setNumberOnly(this, $(this).attr('numonly'));
				});
			});
		}

		window.scrollTo(0, 0);
	};

	function getMISData() {
		var hccode = self.masterModel().Code_Facility_T();
		if (hccode == null) return;

		var submit = { hc: hccode };
		app.ajax('/Checklist/getMISDataHC', submit).done(function (rs) {
			self.vmwQty(rs.vmw);
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
		master.Part5Score = self.P5score();
		master.Participants = JSON.stringify(master.Participants);
		var completeness = master.completeness;
		delete master.pvList;
		delete master.odList;
		delete master.hcList;
		delete master.Code_Prov_N;
		delete master.Code_OD_T;
        delete master.completeness;
        delete master.isFinished;
        delete master.children;
        delete master.c;
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
		        ps1 = ps.P6Q1.problem != '' && ps.P6Q1.solution != '';
		        ps2 = ps.P6Q2.problem != '' && ps.P6Q2.solution != '';
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

	function sumScore(arr) {
		return arr.sum(name => self.detailModel()[name].Score().toFloat());
	}

	self.P1score = function () {
		return sumScore(['P1Q1', 'P1Q1_1', 'P1Q1_2', 'P1Q2', 'P1Q3', 'P1Q4', 'P1Q5', 'P1Q6', 'P1Q7']);
	};

	self.P2score = function () {
		return sumScore(['P2Q1', 'P2Q2', 'P2Q3', 'P2Q4', 'P2Q5', 'P2Q6']);
	};

	self.P3score = function () {
		return sumScore(['P3Q3_2', 'P3Q3_3', 'P3Q3_4']);
	};

	self.P4score = function () {
		return self.detailModel().P4.Answer.list().sum(r => r.score());
	};

	self.P5score = function () {
		return sumScore(['P5Q1', 'P5Q2', 'P5Q3', 'P5Q4', 'P5Q5']);
	};

	self.grandTotal = function () {
		return ['P1score', 'P2score', 'P3score', 'P4score', 'P5score'].sum(k => self[k]().toFloat()).toFixed(2).toFloat();
	};
}