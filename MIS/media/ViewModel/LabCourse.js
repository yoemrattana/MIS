function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.detailList = ko.observableArray();
	self.participant = ko.observable();
	self.view = ko.observable('list');

	var recid = 0;
	var tbl = 'tblLab' + location.pathname.split('/').last().split('_')[0];

	self.prepare = function () {
		app.ajax(`/Lab/getTraining/${tbl}/0`).done(function (rs) {
			self.listModel(rs.list);
		});
	};

	self.showDetail = function (model) {
		recid = model.Rec_ID;

		var submit = { ParentId: recid };
		app.ajax(`/Lab/getCourse/${tbl}/`, submit).done(function (rs) {
			self.participant(rs.qty);
			self.detailList(rs.list.map(app.ko));
			self.view('detail');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.save = function () {
		var submit = {
			where: { ParentId: recid },
			list: JSON.stringify(self.detailList().map(r => {
				return {
					ParentId: recid,
					Question: r.Question(),
					Total1: isempty(r.Total1(), null),
					Total2: isempty(r.Total2(), null),
					Total4: isempty(r.Total4(), null),
					Total5: isempty(r.Total5(), null),
					Answer: r.Question().toString().length == 1 ? null : r.Answer()
				};
			}))
		};
		app.ajax(`/Lab/saveCourse/${tbl}`, submit).done(self.back);
	};

	self.back = function () {
		self.view('list');
	};

	self.getTotal = function (e, n) {
		var q = $(e).closest('tr').find('td:first').text();
		var found = self.detailList().find(r => r.Question() == q);

		if (found == null) {
			found = { Question: q, Total1: null, Total2: null, Total4: null, Total5: null, Answer: '' };
			self.detailList.push(app.ko(found));
		}

		return found['Total' + n];
	};

	self.getPercent = function (e) {
		var q = $(e).closest('tr').find('td:first').text();
		var found = self.detailList().find(r => r.Question() == q);

		if (found == null) return 0;
		var value = [1, 2, 4, 5].sum(n => toFloat(found['Total' + n]()) * n);
		value = (value * 0.2) / self.participant();
		return (value * 100).toFixed(0) + '%';
	};

	self.getAnswer = function (q) {
		var found = self.detailList().find(r => r.Question() == q);

		if (found == null) {
			found = { Question: q, Total1: null, Total2: null, Total4: null, Total5: null, Answer: '' };
			self.detailList.push(app.ko(found));
		}

		return found.Answer;
	};
}