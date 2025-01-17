function subViewModel(self) {
	var ranges = JSON.parse($('#ranges').val());

	self.listModel = ko.observableArray();
	self.view = ko.observable('list');
	self.assessment = ko.observable();
	self.assessmentGroups = Array.range(1, ranges.length);

	self.heads = ko.observableArray();
	self.staffs = ko.observableArray();
	self.details = ko.observableArray();

	var recid = 0;
	var tbl = 'tblLab' + location.pathname.split('/').last().split('_')[0];

	self.numList = function () {
		return ranges[self.assessment() - 1];
	};

	self.prepare = function () {
		app.ajax(`/Lab/getTraining/${tbl}/0`).done(function (rs) {
			self.listModel(rs.list);
		});
	};

	self.showDetail = function (model, ass) {
		recid = model.Rec_ID;
		self.assessment(ass);

		var submit = { ParentId: recid, Assessment: ass };
		app.ajax(`/Lab/getAssessment/${tbl}`, submit).done(function (rs) {
			self.numList().forEach(i => {
				if (rs.heads.some(r => r.Num == i)) return;
				rs.heads.push({
					Assessment: ass,
					Num: i,
					Diagnosis1: '',
					Diagnosis2: '',
					Count: '',
					Mean: '',
				});
			});
			if (!rs.heads.some(r => r.Num == null)) {
				rs.heads.push({
					Assessment: ass,
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
						Assessment: ass,
						Staff_ID: s.Staff_ID,
						Num: i,
						Diagnosis1: '',
						Diagnosis2: '',
						Count: ''
					});
				});

				if (rs.details.some(r => r.Staff_ID == s.Staff_ID && r.Num == null)) return;
				rs.details.push({
					Assessment: ass,
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

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.save = function () {
		var submit = {
			where: { ParentId: recid, Assessment: self.assessment() },
			heads: JSON.stringify(self.heads().map(r => {
				if (r.Num() != null) {
					return {
						ParentId: recid,
						Assessment: r.Assessment(),
						Num: r.Num(),
						Diagnosis1: isempty(r.Diagnosis1(), null),
						Diagnosis2: isempty(r.Diagnosis2(), null),
						Count: r.Count(),
						Mean: isempty(r.Mean(), null),
					};
				}
				return {
					ParentId: recid,
					Assessment: r.Assessment(),
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
						Assessment: r.Assessment(),
						Staff_ID: r.Staff_ID(),
						Num: r.Num(),
						Diagnosis1: isempty(r.Diagnosis1(), null),
						Diagnosis2: isempty(r.Diagnosis2(), null),
						Count: isempty(r.Count(), null),
					};
				}
				return {
					ParentId: recid,
					Assessment: r.Assessment(),
					Staff_ID: r.Staff_ID(),
					Num: r.Num(),
					Negative: isempty(r.Negative(), null),
					Detection: isempty(r.Detection(), null),
					Identification: isempty(r.Identification(), null),
					Counting: isempty(r.Counting(), null)
				};
			}))
		};
		app.ajax(`/Lab/saveAssessment/${tbl}`, submit).done(self.back);
	};

	self.back = function () {
		self.view('list');

		self.staffs([]);
		self.heads([]);
		self.details([]);
	};

	assessmentFunction(self);
}