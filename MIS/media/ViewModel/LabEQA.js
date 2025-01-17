function subViewModel(self) {
	self.editModel = ko.observable();
	self.listModel = ko.observableArray();

	self.prepare = function () {
		app.ajax('/Lab/getEQA').done(function (rs) {
			if (rs.head == null) {
				rs.head = {
					Rec_ID: 0,
					Username: app.user.username,
					Survey: '',
					Name: '',
					Position: '',
					LabNum: '',
					ExaminedDate: null
				};
			}
			if (rs.list.length == 0) {
				rs.list = Array.repeat(15).map(() => {
					return {
						Slide: '',
						SSP_Microscopist: '',
						Parasite: '',
						WBC: '',
						Counting_Microscopist: '',
						SSP_EQA: '',
						Counting_EQA: '',
						DetectionA: '',
						DetectionB: '',
						DetectionC: '',
						DetectionD: '',
						PfA: '',
						PfB: '',
						PfC: '',
						PfD: '',
						Accuracy: '',
						Counting: '',
					};
				});
			}

			self.editModel(rs.head);
			self.listModel(rs.list.map(app.ko));
		});
	};

	self.save = function () {
		var head = self.editModel();
		head.ExaminedDate = head.ExaminedDate || null;
		head.ModiUser = app.user.username;
		head.ModiTime = moment().sqlformat('datetime');

		var submit = {
			head: JSON.stringify(head),
			list: JSON.stringify(self.listModel().map(r => {
				r = app.unko(r);
				return {
					Slide: r.Slide,
					SSP_Microscopist: r.SSP_Microscopist,
					Parasite: isempty(r.Parasite, null),
					WBC: isempty(r.WBC, null),
					Counting_Microscopist: isempty(r.Counting_Microscopist, null),
					SSP_EQA: r.SSP_EQA,
					Counting_EQA: isempty(r.Counting_EQA, null),
					DetectionA: r.DetectionA,
					DetectionB: r.DetectionB,
					DetectionC: r.DetectionC,
					DetectionD: r.DetectionD,
					PfA: r.PfA,
					PfB: r.PfB,
					PfC: r.PfC,
					PfD: r.PfD,
					Accuracy: r.Accuracy,
					Counting: r.Counting
				};
			}))
		};

		app.ajax('/Lab/saveEQA', submit).done(function (id) {
			self.editModel().Rec_ID = id;
		});
	};

	self.getAccuracy = function (m) {
		var rs = m.SSP_Microscopist() == '' || m.SSP_EQA() == '' ? null
			: m.SSP_Microscopist() == m.SSP_EQA() ? 1
			: 0;

		m.Accuracy(rs);
		return rs;
	};

	self.getCounting = function (m) {
		if (isnone(m.Counting_Microscopist()) || isnone(m.Counting_EQA())) {
			m.Counting(null);
			return null;
		}

		var a = m.Counting_Microscopist() > m.Counting_EQA() - (m.Counting_EQA() * 0.25);
		var b = m.Counting_Microscopist() < m.Counting_EQA() + (m.Counting_EQA() * 0.25);
		var rs = a && b ? 1 : 0;

		m.Counting(rs);
		return rs;
	};

	self.print = function () {
		open('/Lab/index/eqa_print/' + self.hc() + '/' + self.q());
	};

	self.calcDetect = function (m, key) {
		if (key == 'DetectionA') {
			var rs = m.SSP_Microscopist().in('', 'N') == false && m.SSP_EQA().in('', 'N') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionB') {
			var rs = m.SSP_Microscopist().in('', 'N') == false && m.SSP_EQA() == 'N' ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionC') {
			var rs = m.SSP_Microscopist() == 'N' && m.SSP_EQA().in('', 'N') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionD') {
			var rs = m.SSP_Microscopist() == 'N' && m.SSP_EQA() == 'N' ? 1 : null;
			m[key](rs);
		}

		return rs;
	};

	self.calcPf = function (m, key) {
		if (key == 'PfA') {
			var rs = m.SSP_Microscopist() == 'F' && m.SSP_EQA() == 'F' ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfB') {
			var rs = m.SSP_Microscopist() == 'F' && m.SSP_EQA().in('', 'F') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfC') {
			var rs = m.SSP_Microscopist().in('', 'F') == false && m.SSP_EQA() == 'F' ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfD') {
			var rs = m.SSP_Microscopist().in('', 'F') == false && m.SSP_EQA().in('', 'F') == false ? 1 : null;
			m[key](rs);
		}

		return rs;
	};

	self.countTotal = function (key) {
		return self.listModel().filter(r => r[key]() > 0).length;
	};

	self.calcA = function () {
		var list = self.listModel();
		var a = list.filter(r => r.DetectionA() > 0).length;
		var b = list.filter(r => r.DetectionB() > 0).length;
		var c = list.filter(r => r.DetectionC() > 0).length;
		var d = list.filter(r => r.DetectionD() > 0).length;
		var abcd = a + b + c + d;
		var rs = abcd == 0 ? 0 : ((a + d) / abcd) * 100;
		return rs.toFixed(0) + '%';
	};

	self.calcB = function () {
		var list = self.listModel();
		var a = list.filter(r => r.SSP_Microscopist().in('', 'N') == false && r.SSP_Microscopist() == r.SSP_EQA()).length;
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcC = function () {
		var list = self.listModel();
		var a = list.filter(r => r.DetectionA() > 0).length;
		var b = list.filter(r => r.DetectionB() > 0).length;
		var ab = a + b;
		return ab == 0 ? '0%' : (b / ab * 100).toFixed(0) + '%';
	};

	self.calcD = function () {
		var list = self.listModel();
		var c = list.filter(r => r.DetectionC() > 0).length;
		var d = list.filter(r => r.DetectionD() > 0).length;
		var cd = c + d;
		return cd == 0 ? '0%' : (c / cd * 100).toFixed(0) + '%';
	};

	self.calcE = function () {
		var list = self.listModel();
		var a = list.filter(r => r.PfA() > 0).length;
		var b = list.filter(r => r.PfB() > 0).length;
		var c = list.filter(r => r.PfC() > 0).length;
		var d = list.filter(r => r.PfD() > 0).length;
		var abcd = a + b + c + d;
		var rs = abcd == 0 ? 0 : ((a + d) / abcd) * 100;
		return rs.toFixed(0) + '%';
	};

	self.calcF = function () {
		var list = self.listModel();
		var a = list.filter(r => r.Counting_Microscopist() == r.Counting_EQA()).length;
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcG = function () {
		var list = self.listModel();
		var a = list.filter(r => r.Accuracy() > 0).length;
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcH = function () {
		var list = self.listModel();
		var a = list.filter(r => r.DetectionA() > 0).length;
		var c = list.filter(r => r.DetectionC() > 0).length;
		var ac = a + c;
		var rs = ac == 0 ? 0 : a / ac * 100;
		return rs.toFixed(0) + '%';
	};

	self.calcI = function () {
		var list = self.listModel();
		var b = list.filter(r => r.DetectionB() > 0).length;
		var d = list.filter(r => r.DetectionD() > 0).length;
		var bd = b + d;
		var rs = bd == 0 ? 0 : d / bd * 100;
		return rs.toFixed(0) + '%';
	};

	self.exportExcel = function () {
		var data = self.listModel().map(app.unko).map(r => {
			return {
				'Slide No': r.Slide,
				'Microscopist SSP': r.SSP_Microscopist,
				'Parasite': r.Parasite,
				'WBCs': r.WBC,
				'Microscopist Counting': r.Counting_Microscopist,
				'EQA SSP': r.SSP_EQA,
				'EQA Counting': r.Counting_EQA,
				'Detection A': r.DetectionA,
				'Detection B': r.DetectionB,
				'Detection C': r.DetectionC,
				'Detection D': r.DetectionD,
				'Pf A': r.PfA,
				'Pf B': r.PfB,
				'Pf C': r.PfC,
				'Pf D': r.PfD,
				'Accuracy': r.Accuracy,
				'Counting': r.Counting
			};
		});
		self.writeExcel(data, 'EQA');
	};
}