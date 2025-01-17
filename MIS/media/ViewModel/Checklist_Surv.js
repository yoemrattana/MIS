function subViewModel(self) {
	self.tableName = 'tblChecklistSurv';
	self.getData();

	function newMasterModel() {
		return {
			Rec_ID: 0,
			Code_Facility_T: null,
			VisitDate: null,
			VisitorName: '',
			VisitorSex: null,
			Position: '',
			Phone: '',
			Workplace: '',
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

		var keys = Array.range(1, 5).map(r => 'Q' + r);
		keys.forEach(k => obj[k] = { lastYear: '', thisYear: '' });

		var keys = Array.range(6, 7).map(r => 'Q' + r);
		keys.forEach(k => obj[k] = { answer: '' });

		var keys = ['Q8', 'Q10', 'Q12', 'Q13'];
		keys.forEach(k => obj[k] = { cases: '', total: '', percent: '', score: '' });

		var keys = ['Q9'];
		keys.forEach(k => obj[k] = { tablet: { rec: '', la: '', id: '', imp: '' }, paper: { rec: '', la: '', id: '', imp: '' }, score: '' });

		var keys = ['Q11', 'Q14', 'Q16'];
		keys.forEach(k => obj[k] = { tick: '', other: '' });

		var keys = ['Q15'];
		keys.forEach(k => obj[k] = { tick: '', a: { qty: '', percent: '' }, b: { qty: '', percent: '' }, c: { qty: '', percent: '' }, score: '' });

		var keys = ['Q17'];
		keys.forEach(k => obj[k] = { tick: '', ce: '', census: '', vmw: '', itn: '', afs: '', tda: '', ipt: '', other: '', score: '' });

		var keys = ['Q18'];
		keys.forEach(k => obj[k] = { answer: '' });

		return obj;
	}

	self.showDetail = function (model) {
		self.lastScrollY = window.scrollY;

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

		var detail = model.Rec_ID() == 0 ? newDetailModel() : JSON.parse(model.Detail());
		Object.keys(detail).forEach(k => {
			if (detail[k].score === undefined) return;
			detail[k].score = ko.observable(detail[k].score);
		});

		self.detailModel(detail);
		self.view('detail');

		window.scrollTo(0, 0);
	};

	self.save = function () {
		if (document.forms.myform.checkValidity() == false) return true;

		var master = newMasterModel().applyData(app.unko(self.masterModel()));
		master.VisitDate = master.VisitDate.sqlformat();
		master.Participants = JSON.stringify(master.Participants);
		master.Detail = JSON.stringify(app.unko(self.detailModel()));

		var submit = {
			tbl: self.tableName,
			master: master
		};
		submit = { submit: JSON.stringify(submit) };
		app.ajax('/Checklist/save', submit).done(function (rs) {
			if (master.Rec_ID == 0) {
				self.listModel.push(rs);
			} else {
				var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
				self.listModel.replace(old, rs);
			}

			self.view('list');
		});
	};

	self.totalScore = function (part) {
		var detail = self.detailModel();
		var keys = Array.range(8, 17);

		if (part == 1) keys = Array.range(8, 10);
		if (part == 2) keys = Array.range(12, 13);
		if (part == 3) keys = Array.range(15, 17);

		return keys.sum(k => ko.unwrap(detail['Q' + k].score));
	};

	self.percent = function (part, score) {
		var p = self.totalScore(part) * 100 / score;
		return p.toFixed(0) + '%';
	};
}