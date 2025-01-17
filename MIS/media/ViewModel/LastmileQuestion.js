function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.masterModel = ko.observable();
	self.detailModel = ko.observable([]);
	self.view = ko.observable('list');
	self.menu = ko.observable(new URLSearchParams(location.search).get('type') || '');
	self.submenu = ko.observable('');
	self.vmwSummary = ko.observableArray();
	self.hfSummary = ko.observableArray();

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
			app.ajax('/LastmileQuestion/getList/' + self.menu()).done(function (rs) {
				self.listModel(rs);
			});
		}
	});

	self.getTitle = function () {
		return self.menu() == 'VMW' ? 'VMW/MMW'
			: self.menu() == 'Vill' ? 'Village Leader'
			: self.menu() == 'Pop' ? 'Target Population'
			: self.menu();
	};

	self.showNew = function () {
		var model = {
			Rec_ID: 0,
			Interviewer: '',
			InterviewDate: '',
			Interviewee: '',
			IntervieweePosition: ''
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

		if (model.Rec_ID() == 0) {
			self.detailModel([]);
			self.view('detail');
		} else {
			var submit = { ParentId: model.Rec_ID() };
			app.ajax('/LastmileQuestion/getDetail', submit).done(function (rs) {
				self.detailModel(rs);
				self.view('detail');
			});
		}
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblLastmileQuestion',
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
		if (master.od() == null && self.menu().in('OD', 'HC', 'VMW', 'Vill', 'Pop')) {
			app.showWarning(master.od.element);
			missing = true;
		}
		if (master.hc() == null && self.menu().in('HC', 'VMW', 'Vill', 'Pop')) {
			app.showWarning(master.hc.element);
			missing = true;
		}
		if (master.vl() == null && self.menu().in('VMW', 'Vill', 'Pop')) {
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
				IntervieweePosition: master.IntervieweePosition()
			},
			detail: app.unko(self.detailModel()).map(r => {
				r.Answer = r.Answer.trim();
				return r;
			})
		};

		app.ajax('/LastmileQuestion/save', submit).done(function (rs) {
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

	self.getAnswer = function (e) {
		var id = $(e).closest('tr').attr('id');
		var found = self.detailModel().find(r => r.QuestionId == id);

		if (found == null) {
			found = { QuestionId: id, Answer: '' };
			self.detailModel().push(found);
		}

		if (!ko.isObservable(found.Answer)) found.Answer = ko.observable(found.Answer);
		return found.Answer;
	};

	self.viewSummary = () => {
		var element = $(event.currentTarget);
		var param = element.attr('name');
		self.submenu(param);

		app.ajax('/LastmileQuestion/getSummary/', { submit: param }).done(function (rs) {
			if (param == 'HC') self.hfSummary(rs);
			else self.vmwSummary(rs);
		});
	}

	self.ifcan = function (permission) {
		return app.user.permiss['Last Mile Elimination Assessment'].contain(permission);
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

	self.showConsent = function () {
		self.view('consent');
	};

	self.exportExcel = () => {
		var submit = { type: self.menu() };

		app.downloadBlob('/LastmileQuestion/exportExcel', submit).done(function (blob) {
			var filename = self.menu() == 'Vill' ? 'Village Leader'
						: self.menu() == 'Pop' ? 'Target Population'
						: self.menu();

			saveAs(blob, filename + '.xlsx'); //from FileSaver.js
		});
    };

    self.getVill = function (code) {
        if (code == null || code === '') return '';
        if (code == '999') return 'Unknown';
        var found = code.length == 10 ? place.vl.find(r => r.code == code)
            : code.length == 6 ? place.cm.find(r => r.code == code)
                : code.length == 4 ? place.ds.find(r => r.code == code)
                    : code.length == 2 ? place.pv.find(r => r.code == code)
                        : null;

        return found == null ? code : found.name;
    };


	$('#menu button').each(function () {
		$(this).click(() => location = '/LastmileQuestion?type=' + this.name);
		if (this.name == self.menu()) $(this).removeClass('btn-default').addClass('btn-info');
		if (!self.ifcan(this.innerHTML)) $(this).hide();
	});

	$('#tbldetail tbody').each(function () {
		if (this.id != self.menu()) $(this).remove();
	});

	$('#tbldetail [type=radio]').each(function () {
		this.name = $(this).closest('tr').attr('id');
		this.value = $(this).next().text();
	});

	$('head').prepend('<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />');
}