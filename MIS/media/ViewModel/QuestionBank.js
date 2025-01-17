function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.hfSummary = ko.observableArray();
	self.vmwSummary = ko.observableArray();
	self.masterModel = ko.observable();
	self.detailModel = ko.observable([]);
	self.view = ko.observable('list');
	self.menu = ko.observable(new URLSearchParams(location.search).get('type') || '');

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();

	self.lang = ko.observable();

	var lastScrollY = 0;
	var place = null;

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
		p.pv = p.pv.filter(r => r.target == 1);
		p.od = p.od.filter(r => r.target == 1);

		if (app.user.prov != '') p.pv = p.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') p.od = p.od.filter(r => r.code == app.user.od);

		place = p;
		self.pvList(p.pv);

		if (self.menu() != '') {
			app.ajax('/QuestionBank/getList/' + self.menu()).done(function (rs) {
				self.listModel(rs);
			});
		}
	});

	self.getTitle = function () {
		return self.menu() == 'VMW' ? 'VMW/MMW' : self.menu();
	};

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Interviewer: '',
			InterviewDate: '',
			Interviewee: '',
			IntervieweePosition: '',
			Agree: 0
		};
		self.showDetail(model);
	};

	self.showDetail = function (model) {
		lastScrollY = window.scrollY;
		window.scrollTo(0, 0);

		['pv', 'od', 'hc', 'vl'].forEach(k => model[k] = model[k]);

		model = app.ko(model);
		model.pvList = place.pv;
		model.odList = () => place.od.filter(r => r.pvcode == model.pv());
		model.hcList = () => place.hc.filter(r => r.odcode == model.od());
		model.vlList = () => place.vl.filter(r => r.hccode === model.hc());

		self.masterModel(model);

		model.Agree.subscribe(value => $('#tbldetail input').prop('disabled', value == 0));
		model.Agree.notifySubscribers(model.Agree());

		if (model.Rec_ID() == 0) {
			self.detailModel([]);
			self.view('detail');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		} else {
			var submit = { ParentId: model.Rec_ID() };
			app.ajax('/QuestionBank/getDetail', submit).done(function (rs) {
				self.detailModel(rs);
				self.view('detail');

				$('input[numonly]').each(function () {
					app.setNumberOnly(this, $(this).attr('numonly'));
				});
			});
		}
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblQuestionBank',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.save = function () {
		var master = self.masterModel();
		var missing = false;

		if (master.pv() == null) {
			app.showWarning(master.pv.element);
			missing = true;
		}
		if (master.od() == null && self.menu().in('OD', 'HC', 'VMW')) {
			app.showWarning(master.od.element);
			missing = true;
		}
		if (master.hc() == null && self.menu().in('HC', 'VMW')) {
			app.showWarning(master.hc.element);
			missing = true;
		}
		if (master.vl() == null && self.menu() == 'VMW') {
			app.showWarning(master.vl.element);
			missing = true;
		}
		if (master.Interviewer.trim() == '') {
			app.showWarning(master.Interviewer.element);
			missing = true;
		}
		if (master.InterviewDate() == '') {
			app.showWarning(master.InterviewDate.element);
			missing = true;
		}
		if (master.Interviewee.trim() == '') {
			app.showWarning(master.Interviewee.element);
			missing = true;
		}
		if (master.IntervieweePosition.trim() == '') {
			app.showWarning(master.IntervieweePosition.element);
			missing = true;
		}
		if (missing) {
			window.scrollTo(0, 0);
			return;
		}

		if (master.Agree() == 1) {
			var found = self.detailModel().find(r => Array.isArray(r.Answer()) ? r.Answer().length == 0 : r.Answer() == '');
			if (found != null) {
				var num = $(`[id="${found.QuestionId}"]`).find('td:first').text();
				app.showMsg('<kh>ចម្លើយមិនគ្រប់</kh>', `<kh>សូមបំពេញចម្លើយនៅសំនួរទី${num}</kh>`);
				return;
			}
		}

		var placeCode = self.menu() == 'PHD' ? master.pv()
			: self.menu() == 'OD' ? master.od()
			: self.menu() == 'HC' ? master.hc()
			: master.vl();

		var submit = {
			master: {
				Rec_ID: master.Rec_ID(),
				FormType: self.menu(),
				PlaceCode: placeCode,
				Interviewer: master.Interviewer(),
				InterviewDate: master.InterviewDate(),
				Interviewee: master.Interviewee(),
				IntervieweePosition: master.IntervieweePosition(),
				Agree: master.Agree()
			},
			detail: app.unko(self.detailModel()).map(r => {
				if (Array.isArray(r.Answer)) r.Answer = r.Answer.join('; ');
				return r;
			})
		};

		app.ajax('/QuestionBank/save', submit).done(function (rs) {
			if (master.Rec_ID() == 0) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
				self.listModel.replace(old, rs);
			}
			self.back();
		});
	};

	self.back = function () {
		self.view('list');
		window.scrollTo(0, lastScrollY);
	};

	self.getListModel = ko.pureComputed(function () {
		var list = self.listModel();

		if (self.hc() != null) list = list.filter(r => r.hc == self.hc());
		else if (self.od() != null) list = list.filter(r => r.od == self.od());
		else if (self.pv() != null) list = list.filter(r => r.pv == self.pv());

		return list;
	});

	self.odList = ko.pureComputed(function () {
		return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
	});

	self.hcList = ko.pureComputed(function () {
		return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
	});

	self.getAnswer = function (e, field) {
		var found = self.detailModel().find(r => r.QuestionId == e.name);

		if (found == null) {
			found = {
				QuestionId: e.name,
				IndicatorNum: e.name.split('-')[0],
				Indicator: $(e).closest('tr').find('[field=indicator]').text(),
				Question: $(e).closest('tr').find('[field=question]').text()
			};
			self.detailModel().push(found);
		}

		if (field == 'specify') {
			if (found.Specify === undefined) found.Specify = '';
			if (!ko.isObservable(found.Specify)) found.Specify = ko.observable(found.Specify);
			return found.Specify;
		}

		if (found.Answer === undefined) found.Answer = '';
		if (!ko.isObservable(found.Answer)) {
			if (e.type == 'checkbox' && !Array.isArray(found.Answer)) found.Answer = found.Answer.split('; ').filter(r => r != '');
			found.Answer = ko.observable(found.Answer);
			found.Answer.old = found.Answer();

			found.Answer.subscribe(function (value) {
				var s = $(e).closest('td').find('.input-group');
				var v = Array.isArray(value) ? value.some(r => r.contain('Other')) : value.contain('Other');

				if (e.name == '2.4.2-1' && value.contain('J')) v = true;
				if (e.name == '2.4.2-2' && value.contain('J')) v = true;
				if (e.name == '2.4.2-3' && value.contain('H')) v = true;
				if (e.name == '2.4.2-4' && value.contain('F')) v = true;
				if (e.name == '2.4.2-5' && value.contain('F')) v = true;
				if (e.name == '3.2.1' && value.contain('E')) v = true;
				if (e.name == '3.3.2-1' && value.contain('F')) v = true;
				if (e.name == '3.3.2-2' && value.contain('F')) v = true;
				if (e.name == '3.4.3-1' && value.contain('')) v = true;
				if (e.name == '3.6.1' && value.contain('F')) v = true;
				if (e.name == '3.6.1-1' && value.contain('F')) v = true;
				if (e.name == '3.6.2-2' && value.contain('H')) v = true;
				if (e.name == '3.6.2' && value.contain('G')) v = true;
				if (e.name == '4.4.1-2' && value.contain('I')) v = true;
				if (e.name == '4.4.1-3' && value.contain('H')) v = true;
				if (e.name == '1.3.2' && value.contain('E')) v = true;

				v ? s.show() : s.hide();
			});

			found.Answer.notifySubscribers(found.Answer());
		}
		return found.Answer;
	};

	self.radioClick = function (vm, e) {
		var found = self.detailModel().find(r => r.QuestionId == e.target.name);
		if (found.Answer() == found.Answer.old) found.Answer('');
		found.Answer.old = found.Answer();
		return true;
	};

	self.ifcan = function (permission) {
		return app.user.permiss['Surveillance Assessment Questionnaire'].contain(permission);
	};

	self.exportExcel = () => {
		var submit = { type: self.menu() };

		app.downloadBlob('/QuestionBank/exportExcel', submit).done(function (blob) {
			saveAs(blob, self.menu() + '.xlsx'); //from FileSaver.js
		});
	};

	self.lang.subscribe(function (value) {
		if (value == 'English') {
			$('.en').show();
			$('.kh').hide();
		} else {
			$('.en').hide();
			$('.kh').show();
		}
	});

	$('#menu button').each(function () {
		$(this).click(() => location = '/QuestionBank?type=' + this.name);
		if (this.name == self.menu()) $(this).removeClass('btn-default').addClass('btn-info');
		if (!self.ifcan(this.innerHTML)) $(this).hide();
	});

	$('[field=number]').each(function () {
		$(this).text($(this).closest('tr').attr('id').split('-')[0]);
	});

	$('[field=answer] [type=radio]').each(function () {
		this.name = $(this).closest('tr').attr('id');
		if ($(this).val() == 'on') this.value = $(this).next().text();
	});

	$('[field=answer] [type=checkbox]').each(function () {
		this.name = $(this).closest('tr').attr('id');
		if ($(this).val() == 'on') this.value = $(this).next().text();
	});

	$('[field=answer] [type=text]').each(function () {
		this.name = $(this).closest('tr').attr('id');
	});

	$('#tbldetail tbody tr').each(function (i) {
		var num = i + 1;

		if (self.menu().in('PHD', 'OD')) {
			if (num == 13) num = '12.1';
			else if (num == 14) num = '12.2';
			else if (num == 15) num = '12.3';
			else if (num == 16) num = '12.4';
			else if (num > 16) num -= 4;

			if (num == 47) num = '46.1';
			else if (num == 48) num = '46.2';
			else if (num == 49) num = '46.3';
			else if (num > 49) num -= 3;

			if (num == 50) num = '49.1';
			else if (num > 50) num -= 1;
		}

		if (self.menu() == 'HC') {
			if (num == 18) num = '17.1';
			else if (num == 19) num = '17.2';
			else if (num == 20) num = '17.3';
			else if (num == 21) num = '17.4';
			else if (num > 21) num -= 4;

			if (num == 31) num = '30.1';
			if (num == 32) num = '30.2';
			if (num == 33) num = '30.3';
			else if (num > 33) num -= 3;

			if (num == 39) num = '38.1';
			if (num == 40) num = '38.2';
			if (num == 41) num = '38.3';
			if (num == 42) num = '38.4';
			if (num == 43) num = '38.5';
			if (num == 44) num = '38.6';
			if (num == 45) num = '38.7';
			else if (num > 45) num -= 7;
		}

		if (self.menu() == 'VMW') {
			if (num == 14) num = '13.1';
			else if (num == 15) num = '13.2';
			else if (num == 16) num = '13.3';
			else if (num == 17) num = '13.4';
			else if (num > 17) num -= 4;
		}

		$(this).prepend('<td align="center">' + num + '</td>');
	});

	self.submenu = ko.observable();
	self.viewSummary = () => {
		var element = $(event.currentTarget);
		var param = element.attr('name');
		self.submenu(param);

		app.ajax('/QuestionBank/getSummary/', { submit: param }).done(function (rs) {
			if (param == 'HC') self.hfSummary(rs);
			else self.vmwSummary(rs);
		});
	}

	$('head').prepend('<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />');
}