function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.loaded = ko.observable(false);

	self.hcName = ko.observable();
	self.Round = ko.observable();
	self.Microscopist = ko.observable();
	self.Provider = ko.observable();
	self.SlideSet = ko.observable();

	var headID = null;

	self.prepare = function () {
		self.pv.subscribe(() => self.loaded(false));
		self.od.subscribe(() => self.loaded(false));
		self.hc.subscribe(() => self.loaded(false));
		self.year.subscribe(() => self.loaded(false));
		self.smt.subscribe(() => self.loaded(false));
	};

	self.viewClick = function () {
		if (self.hc() == null) return;

		var submit = {
			hc: self.hc(),
			s: self.s()
		};
		app.ajax('/Lab/getPanelTesting', submit).done(function (rs) {
			var head = rs.head || {};
			headID = head.Rec_ID;

			self.hcName(self.place.hc.find(r => r.code == self.hc()).name);
			self.Round(head.Round);
			self.Microscopist(head.Microscopist);
			self.Provider(head.Provider);
			self.SlideSet(head.SlideSet);

			self.listModel(rs.list.map(app.ko));

			for (var i = self.listModel().length; i < 15; i++) {
				self.listModel.push(app.ko(newModel()));
			}

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});

			self.loaded(true);
		});
	};

	self.save = function () {
		var head = {
			Rec_ID: headID || null,
			Code_Facility_T: self.hc(),
			Semester: self.s(),
			Round: self.Round(),
			Microscopist: self.Microscopist(),
			Provider: self.Provider(),
			SlideSet: self.SlideSet(),
			ModiUser: app.user.username,
			ModiTime: moment().sqlformat('datetime')
		};

		var list = self.listModel().map(r => {
			r = app.unko(r);
			return {
				LamCode: r.LamCode || null,
				Microscopist: r.Microscopist,
				ParasiteCount1: isempty(r.ParasiteCount1, null),
				ReferenceSlide: r.ReferenceSlide,
				ParasiteCount2: isempty(r.ParasiteCount2, null),
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
		});

		var submit = {
			head: JSON.stringify(head),
			list: JSON.stringify(list),
			hc: self.hc(),
			s: self.s()
		};
		app.ajax('/Lab/savePanelTesting', submit).done(function (rs) {
			var head = rs.head || {};
			headID = head.Rec_ID;

			self.hcName(self.place.hc.find(r => r.code == self.hc()).name);
			self.Round(head.Round);
			self.Microscopist(head.Microscopist);
			self.Provider(head.Provider);

			self.listModel(rs.list.map(app.ko));

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.getAccuracy = function (m) {
		var rs = m.Microscopist() == '' || m.ReferenceSlide() == '' ? null
			: m.Microscopist() == m.ReferenceSlide() ? 1
			: 0;

		m.Accuracy(rs);
		return rs;
	};

	self.getCounting = function (m) {
		if (isnone(m.ParasiteCount1()) || isnone(m.ParasiteCount2())) {
			m.Counting(null);
			return null;
		}

		var a = m.ParasiteCount1() > m.ParasiteCount2() - (m.ParasiteCount2() * 0.25);
		var b = m.ParasiteCount1() < m.ParasiteCount2() + (m.ParasiteCount2() * 0.25);
		var rs = a && b ? 1 : 0;

		m.Counting(rs);
		return rs;
	};

	self.print = function () {
		open('/Lab/index/paneltesting_print/' + self.hc() + '/' + self.s());
	};

	function newModel() {
		return {
			LamCode: '',
			Microscopist: '',
			ParasiteCount1: '',
			ReferenceSlide: '',
			ParasiteCount2: '',
			DetectionA: '',
			DetectionB: '',
			DetectionC: '',
			DetectionD: '',
			PfA: '',
			PfB: '',
			PfC: '',
			PfD: '',
			Accuracy: '',
			Counting: ''
		};
	}

	self.calcDetect = function (m, key) {
		if (key == 'DetectionA') {
			var rs = m.Microscopist().in('', 'N') == false && m.ReferenceSlide().in('', 'N') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionB') {
			var rs = m.Microscopist().in('', 'N') == false && m.ReferenceSlide() == 'N' ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionC') {
			var rs = m.Microscopist() == 'N' && m.ReferenceSlide().in('', 'N') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionD') {
			var rs = m.Microscopist() == 'N' && m.ReferenceSlide() == 'N' ? 1 : null;
			m[key](rs);
		}

		return rs;
	};

	self.calcPf = function (m, key) {
		if (key == 'PfA') {
			var rs = m.Microscopist() == 'F' && m.ReferenceSlide() == 'F' ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfB') {
			var rs = m.Microscopist() == 'F' && m.ReferenceSlide().in('', 'F') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfC') {
			var rs = m.Microscopist().in('', 'F') == false && m.ReferenceSlide() == 'F' ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfD') {
			var rs = m.Microscopist().in('', 'F') == false && m.ReferenceSlide().in('', 'F') == false ? 1 : null;
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
		var a = list.filter(r => r.Microscopist() != '' && r.Microscopist() == r.ReferenceSlide()).length;
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
		var a = list.filter(r => !r.Microscopist().in('', 'N') && r.ParasiteCount1() == r.ParasiteCount2()).length;
		if (list.length == 0) return '0%';
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcG = function () {
		var list = self.listModel();
		var a = list.filter(r => r.Accuracy() > 0).length;
		if (list.length == 0) return '0%';
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
		if (self.pv() == null) {
			var submit = { s: self.year() };
			app.ajax('/Lab/getPanelTesting', submit).done(function (rs) {
				rs.list.sortasc('Name_Prov_E', 'Name_OD_E', 'Name_Facility_E', 'Semester');
				prepare(rs.list);
			});
		} else {
			prepare(self.listModel().map(app.unko));
		}

		function prepare(arr) {
			var data = arr.map(r => {
				return {
					'Province': r.Name_Prov_E,
					'OD': r.Name_OD_E,
					'RH': r.Name_Facility_E,
					'Semester': r.Semester,
					'No': r.LamCode,
					'Microscopist': self.getSpecies(r.Microscopist),
					'Parasite': r.ParasiteCount1,
					'Reference': self.getSpecies(r.ReferenceSlide),
					'Parasite': r.ParasiteCount2,
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
			self.writeExcel(data, 'Panel Testing');
		}
	};
}