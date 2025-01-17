function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.staffList = ko.observableArray();
	self.loaded = ko.observable(false);

	self.prepare = function () {
		self.pv.subscribe(() => self.loaded(false));
		self.od.subscribe(() => self.loaded(false));
		self.hc.subscribe(() => self.loaded(false));
		self.year.subscribe(() => self.loaded(false));
		self.qt.subscribe(() => self.loaded(false));
	};

	self.viewClick = function () {
		if (self.hc() == null) return;

		var submit = {
			hc: self.hc(),
			year: self.year(),
			mf: self.qt().substr(-1) * 3 - 2,
			mt: self.qt().substr(-1) * 3
		};
		app.ajax('/Lab/getCrossCheck', submit).done(function (rs) {
			self.staffList(rs.staff);
			self.listModel(rs.list.map(app.ko));
			self.loaded(true);

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.save = function () {
		var list = self.listModel().map(r => {
			r = app.unko(r);
			return {
				Rec_ID: r.Rec_ID,
				Logbook_ID: r.Logbook_ID,
				Microscope: r.Microscope,
				ParasiteCount: isempty(r.ParasiteCount, null),
				DetectionA: r.DetectionA,
				DetectionB: r.DetectionB,
				DetectionC: r.DetectionC,
				DetectionD: r.DetectionD,
				PfA: r.PfA,
				PfB: r.PfB,
				PfC: r.PfC,
				PfD: r.PfD,
				Accuracy: r.Accuracy,
				Counting: r.Counting,
				SmearExcellent: isempty(r.SmearExcellent, null),
				SmearGood: isempty(r.SmearGood, null),
				SmearPoor: isempty(r.SmearPoor, null),
				StainingExcellent: isempty(r.StainingExcellent, null),
				StainingGood: isempty(r.StainingGood, null),
				StainingPoor: isempty(r.StainingPoor, null),
				PCR: r.PCR,
				Staff_ID: r.Staff_ID || null,
				ModiUser: app.user.username,
				ModiTime: moment().sqlformat('datetime')
			};
		});

		var submit = {
			list: JSON.stringify(list),
			hc: self.hc(),
			year: self.year(),
			mf: self.qt().substr(-1) * 3 - 2,
			mt: self.qt().substr(-1) * 3
		};
		app.ajax('/Lab/saveCrossCheck', submit).done(function (rs) {
			self.listModel(rs.list.map(app.ko));

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};

	self.getAccuracy = function (m) {
		var rs = m.D1() == '' && m.Microscope() == '' ? null
			: m.D1() == m.Microscope() ? 1 : 0;

		m.Accuracy(rs);
		return rs;
	};

	self.getCounting = function (m) {
		if (m.ParaCount() == null && m.ParasiteCount() == null) {
			m.Counting(null);
			return null;
		}

		var a = m.ParaCount() > m.ParasiteCount() - (m.ParasiteCount() * 0.25);
		var b = m.ParaCount() < m.ParasiteCount() + (m.ParasiteCount() * 0.25);
		var rs = a && b ? 1 : 0;

		m.Counting(rs);
		return rs;
	};

	self.print = function () {
		open('/Lab/index/crosscheck_print/' + self.hc() + '/' + self.q());
	};

	self.calcDetect = function (m, key) {
		if (key == 'DetectionA') {
			var rs = m.D1().in('', 'N') == false && m.Microscope().in('', 'N') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionB') {
			var rs = m.D1().in('', 'N') == false && m.Microscope() == 'N' ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionC') {
			var rs = m.D1() == 'N' && m.Microscope().in('', 'N') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'DetectionD') {
			var rs = m.D1() == 'N' && m.Microscope() == 'N' ? 1 : null;
			m[key](rs);
		}

		return rs;
	};

	self.calcPf = function (m, key) {
		if (key == 'PfA') {
			var rs = m.D1() == 'F' && m.Microscope() == 'F' ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfB') {
			var rs = m.D1() == 'F' && m.Microscope().in('', 'F') == false ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfC') {
			var rs = m.D1().in('', 'F') == false && m.Microscope() == 'F' ? 1 : null;
			m[key](rs);
		}
		if (key == 'PfD') {
			var rs = m.D1().in('', 'F') == false && m.Microscope().in('', 'F') == false ? 1 : null;
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
		var a = list.filter(r => r.D1() != '' && r.D1() == r.Microscope()).length;
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
		var a = list.filter(r => !r.D1().in('', 'N') && r.ParaCount() == r.ParasiteCount()).length;
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

	self.calcSmearExcellent = function () {
		var list = self.listModel();
		var a = list.filter(r => r.SmearExcellent() > 0).length;
		if (list.length == 0) return '0%';
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcSmearGood = function () {
		var list = self.listModel();
		var a = list.filter(r => r.SmearGood() > 0).length;
		if (list.length == 0) return '0%';
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcSmearPoor = function () {
		var list = self.listModel();
		var a = list.filter(r => r.SmearPoor() > 0).length;
		if (list.length == 0) return '0%';
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcStainExcellent = function () {
		var list = self.listModel();
		var a = list.filter(r => r.StainingExcellent() > 0).length;
		if (list.length == 0) return '0%';
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcStainGood = function () {
		var list = self.listModel();
		var a = list.filter(r => r.StainingGood() > 0).length;
		if (list.length == 0) return '0%';
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.calcStainPoor = function () {
		var list = self.listModel();
		var a = list.filter(r => r.StainingPoor() > 0).length;
		if (list.length == 0) return '0%';
		return (a / list.length * 100).toFixed(0) + '%';
	};

	self.exportExcel = function () {
		if (self.pv() == null) {
			var submit = { year: self.year() };
			app.ajax('/Lab/getCrossCheck/0', submit).done(function (rs) {
				rs.list.sortasc('Name_Prov_E', 'Name_OD_E', 'Name_Facility_E', 'Month');
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
					'Year': r.Year,
					'Month': r.Month,
					'Slide ID': r.Logbook_ID,
					'Collection Date': moment(r.CollectionDate).toDate(),
					'Microscopist': self.getSpecies(r.D1),
					'Microscopist Parasite': r.ParaCount,
					'Cross-checker': self.getSpecies(r.Microscope),
					'Cross-checker Parasite': r.ParasiteCount,
					'Detection A': r.DetectionA,
					'Detection B': r.DetectionB,
					'Detection C': r.DetectionC,
					'Detection D': r.DetectionD,
					'Pf A': r.PfA,
					'Pf B': r.PfB,
					'Pf C': r.PfC,
					'Pf D': r.PfD,
					'Accuracy': r.Accuracy,
					'Counting': r.Counting,
					'Smear Excellent': r.SmearExcellent,
					'Smear Good': r.SmearGood,
					'Smear Poor': r.SmearPoor,
					'Staining Excellent': r.StainingExcellent,
					'Staining Good': r.StainingGood,
					'Staining Poor': r.StainingPoor,
					'Lab Staff': (self.staffList().find(x => x.Staff_ID == r.Staff_ID) || {}).Name
				};
			});
			self.writeExcel(data, 'Cross-checking');
		}
	};
}