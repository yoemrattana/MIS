function viewModel() {
	var self = this;

	self.view = ko.observable('list');
	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();

	self.listModel = ko.observableArray();
	self.masterModel = ko.observable();
	self.detailModel = ko.observableArray();

	var place = null;

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
		place = p;
		place.pv = place.pv.filter(r => r.target == 1);
		place.od = place.od.filter(r => r.target == 1);
		place.hc = place.hc.filter(r => r.type == 'HC');
		place.vl = place.vl.filter(r => r.hccode != null);

		self.pvList(place.pv);

		getData();
	});

	function getData() {
		app.ajax2('/vmwassessment/getData').done(function (rs) {
			self.listModel(rs);
		});
	}

	function newModel() {
		return {
			Rec_ID: 0,
			Code_Vill_T: null,
			VMWName: ''
		};
	}

	self.showNew = function () {
		var model = newModel();
		model.Code_Prov_N = null;
		model.Code_OD_T = null;
		model.Code_Facility_T = null;

		self.showDetail(model);
	};

	self.showDetail = function (model) {
		var master = app.ko(model);

		master.pvList = place.pv;
		master.odList = () => place.od.filter(r => r.pvcode == master.Code_Prov_N());
		master.hcList = () => place.hc.filter(r => r.odcode == master.Code_OD_T());
		master.vlList = () => place.vl.filter(r => r.hccode == master.Code_Facility_T());

		self.masterModel(master);

		if (model.Rec_ID == 0) {
			self.detailModel([]);
			self.view('detail');

			checkboxRequire();
		} else {
			var where = { ParentId: model.Rec_ID };
			app.ajax2('/vmwassessment/getDetail', where).done(function (rs) {
				self.detailModel(rs);
				self.view('detail');

				checkboxRequire();
			});
		}
	};

	function checkboxRequire() {
		var q10 = $('input[name=10]');
		q10.change(() => q10.prop('required', !q10.is(':checked'))).first().change();

		var q11 = $('input[name=11]');
		q11.change(() => q11.prop('required', !q11.is(':checked'))).first().change();

		$('#vhsg').change(function () {
			$('input[name=12]').prop('required', $(this).is(':checked')).prop('disabled', !$(this).is(':checked'));
			if (!$(this).is(':checked')) {
				self.detailModel().find(r => r.QuestionId == 12).Answer('');
			}
		}).change();
	}

	self.getListModel = function () {
		var list = self.listModel();

		if (self.pv() != null) list = list.filter(r => r.Code_Prov_N == self.pv());
		if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());

		return list;
	};

	self.odList = function () {
		return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
	};

	self.hcList = function () {
		return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
	};

	self.getAnswer = function (e) {
		var found = self.detailModel().find(r => r.QuestionId == e.name);

		if (found == null) {
			found = {
				QuestionId: e.name,
				Answer: ''
			};
			self.detailModel().push(found);
		}

		if (!ko.isObservable(found.Answer)) {
			if (e.type == 'checkbox' && !Array.isArray(found.Answer)) {
				found.Answer = found.Answer.split('; ').filter(r => r != '');
			}
			found.Answer = ko.observable(found.Answer);
		}
		return found.Answer;
	};

	self.back = function () {
		self.view('list');
	};

	self.save = function () {
		var master = self.masterModel();

		var submit = {
			master: newModel().applyData(app.unko(master)),
			detail: app.unko(self.detailModel()).map(r => {
				if (Array.isArray(r.Answer)) r.Answer = r.Answer.join('; ');
				return r;
			})
		};
		app.ajax2('/vmwassessment/save', submit).done(function () {
			self.back();
			getData();
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var where = { Rec_ID: model.Rec_ID };
			app.ajax2('/vmwassessment/delete', where).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.exportExcel = function () {
		app.ajax2('/vmwassessment/getDetail').done(function (rs) {
			var data = self.listModel().map(a => {
				var arr = rs.filter(r => r.ParentId == a.Rec_ID);
				var answer = Object.fromEntries(arr.map(r => [r.QuestionId, r.Answer]));
				return {
					Province: a.Name_Prov_E,
					OD: a.Name_OD_E,
					HC: a.Name_Facility_E,
					Village: a.Name_Vill_E,
					Name: a.VMWName,
					Position: answer['3'],
					VMW_Type: answer['4'],
					Village_Type: answer['5'],
					Sex: answer['6'],
					Age: answer['7'],
					Education: answer['8'],
					Work_Duration: answer['9'],
					Community_Job: answer['10'],
					Other_Community_Job: answer['11'],
					VHSG_Duration: answer['12'],
					Other_VHSG: answer['13']
				};
			});
			app.writeExcel(data, 'VMW Assessment');
		});
	};
}