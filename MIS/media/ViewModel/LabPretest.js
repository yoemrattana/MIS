function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.view = ko.observable('list');
	self.mode = ko.observable();

	self.theoryScore = ko.observable();
	self.theoryList = ko.observableArray();

	self.heads = ko.observableArray();
	self.staffs = ko.observableArray();
	self.details = ko.observableArray();

	self.smearPart = ko.observable();
	self.smearList = ko.observableArray();

	self.numList = ko.observableArray(Array.range(1, 19));

	var recid = 0;
	var tbl = 'tblLab' + location.pathname.split('/').last().split('_')[0];
	var part = location.pathname.split('_')[1];

	self.prepare = function () {
		app.ajax(`/Lab/getTraining/${tbl}/0`).done(function (rs) {
			self.listModel(rs.list);
		});
	};

	self.showTheory = function (model) {
		recid = model.Rec_ID;

		var submit = { id: recid, part: part };
		app.ajax(`/Lab/getTheory/${tbl}`, submit).done(function (rs) {
			self.theoryScore(rs.score);

			rs.list.forEach(r => r.Score = ko.observable(isnull(r.Score, '')));
			self.theoryList(rs.list);

			self.view('detail');
			self.mode('Theory');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.showPractical = function (model) {
		recid = model.Rec_ID;

		var submit = { ParentId: recid, Part: part };
		app.ajax(`/Lab/getPractical/${tbl}`, submit).done(function (rs) {
			self.numList().forEach(i => {
				if (rs.heads.some(r => r.Num == i)) return;
				rs.heads.push({
					Num: i,
					Diagnosis1: '',
					Diagnosis2: '',
					Count: '',
					Mean: '',
				});
			});
			if (!rs.heads.some(r => r.Num == null)) {
				rs.heads.push({
					Num: null,
					Negative: '',
					Detection: '',
					Identification: '',
					Counting: ''
				});
			}
			self.heads(rs.heads.map(app.ko));

			rs.staffs.forEach(s => {
				self.numList().forEach(i => {
					if (rs.details.some(r => r.Staff_ID == s.Staff_ID && r.Num == i)) return;
					rs.details.push({
						Staff_ID: s.Staff_ID,
						Num: i,
						Diagnosis1: '',
						Diagnosis2: '',
						Count: ''
					});
				});

				if (rs.details.some(r => r.Staff_ID == s.Staff_ID && r.Num == null)) return;
				rs.details.push({
					Staff_ID: s.Staff_ID,
					Num: null,
					Negative: '',
					Detection: '',
					Identification: '',
					Counting: ''
				});
			});
			self.staffs(rs.staffs);
			self.details(rs.details.map(app.ko));

			self.view('detail');
			self.mode('Practical');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.showSmear = function (model, smear) {
		recid = model.Rec_ID;
		self.smearPart(smear);

		var submit = { id: recid, part: self.smearPart() };
		app.ajax(`/Lab/getSmear/${tbl}`, submit).done(function (rs) {
			self.smearList(rs.map(app.ko));
			self.view('detail');
			self.mode('Smear');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	}

	self.save = function () {
		if (self.mode() == 'Theory') {
			var submit = {
				where: { ParentId: recid, Part: part },
				score: isnone(self.theoryScore(), () => undefined),
				list: JSON.stringify(self.theoryList().map(r => {
					return {
						ParentId: recid,
						Staff_ID: r.Staff_ID,
						Part: part,
						Score: isempty(r.Score(), null)
					};
				}))
			};
			app.ajax(`/Lab/saveTheory/${tbl}`, submit).done(self.back);
		}

		if (self.mode() == 'Practical') {
			var submit = {
				where: { ParentId: recid, Part: part },
				heads: JSON.stringify(self.heads().map(r => {
					if (r.Num() != null) {
						return {
							ParentId: recid,
							Part: part,
							Num: r.Num(),
							Diagnosis1: isempty(r.Diagnosis1(), null),
							Diagnosis2: isempty(r.Diagnosis2(), null),
							Count: r.Count(),
							Mean: isempty(r.Mean(), null),
						};
					}
					return {
						ParentId: recid,
						Part: part,
						Num: r.Num(),
						Negative: isempty(r.Negative(), null),
						Detection: isempty(r.Detection(), null),
						Identification: isempty(r.Identification(), null),
						Counting: isempty(r.Counting(), null)
					};
				})),
				details: JSON.stringify(self.details().map(r => {
					if (r.Num() != null) {
						return {
							ParentId: recid,
							Staff_ID: r.Staff_ID(),
							Part: part,
							Num: r.Num(),
							Diagnosis1: isempty(r.Diagnosis1(), null),
							Diagnosis2: isempty(r.Diagnosis2(), null),
							Count: isempty(r.Count(), null),
						};
					}
					return {
						ParentId: recid,
						Staff_ID: r.Staff_ID(),
						Part: part,
						Num: r.Num(),
						Negative: isempty(r.Negative(), null),
						Detection: isempty(r.Detection(), null),
						Identification: isempty(r.Identification(), null),
						Counting: isempty(r.Counting(), null)
					};
				}))
			};
			app.ajax(`/Lab/savePractical/${tbl}`, submit).done(self.back);
		}

		if (self.mode() == 'Smear') {
			var submit = {
				where: { ParentId: recid, Part: self.smearPart() },
				list: JSON.stringify(self.smearList().map(r => {
					return {
						ParentId: recid,
						Staff_ID: r.Staff_ID(),
						Part: self.smearPart(),
						Slide: isempty(r.Slide(), null),
						Question1: isempty(r.Question1(), null),
						Question2: isempty(r.Question2(), null),
						Question3: isempty(r.Question3(), null),
						Question4: isempty(r.Question4(), null),
						Question5: isempty(r.Question5(), null),
						Question6: isempty(r.Question6(), null),
						Question7: isempty(r.Question7(), null),
						Question8: isempty(r.Question8(), null),
						Question9: isempty(r.Question9(), null),
						Question10: isempty(r.Question10(), null),
						Question11: isempty(r.Question11(), null),
						Question12: isempty(r.Question12(), null)
					};
				}))
			};
			app.ajax(`/Lab/saveSmear/${tbl}`, submit).done(self.back);
		}
	};

	self.back = function () {
		self.view('list');

		self.staffs([]);
		self.heads([]);
		self.details([]);
	};

	self.getHCName = function (hccode) {
		if (hccode == 'CNM') return 'CNM';

		return self.place.hc.find(r => r.code == hccode).name;
	};

	self.getTotalSmear1 = function (model) {
		return Array.range(1, 7).sum(n => toFloat(model['Question' + n]()));
	};

	self.getTotalSmear2 = function (model) {
		return Array.range(8, 12).sum(n => toFloat(model['Question' + n]()));
	};

	self.getPercentSmear1 = function (model) {
		return (self.getTotalSmear1(model) / 0.35).toFixed(0) + '%';
	};

	self.getPercentSmear2 = function (model) {
		return (self.getTotalSmear2(model) / 0.25).toFixed(0) + '%';
	};

	self.getGrandTotalSmear = function (model) {
		var a = self.getTotalSmear1(model) / 0.35;
		var b = self.getTotalSmear2(model) / 0.25;
		return ((a + b) / 2).toFixed(0) + '%';
	};

	self.getTheoryPercent = function (model) {
		if (isnone(self.theoryScore()) || isnone(model.Score())) return '';
		var total = self.theoryScore().toFloat();
		if (total == 0) return '0%';
		return (model.Score().toFloat() * 100 / total).toFixed(0) + '%';
	};

	assessmentFunction(self);
}