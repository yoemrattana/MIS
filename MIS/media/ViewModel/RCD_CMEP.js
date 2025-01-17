function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.editModel = ko.observable();

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.vl = ko.observable();

	self.view = ko.observable('list');
	self.yearList = Array.repeat(moment().year() - 2022).map((r, i) => i + 2023);
	self.monthList = Array.repeat(12).map((r, i) => moment().month(i).format('MM'));
	self.year = ko.observable(moment().year());
	self.month = ko.observable(moment().format('MM'));
	self.loaded = ko.observable(false);
	self.filter = ko.observable();

	var place = null;
	var lastScrollY = 0;

	app.getPlace(['pv', 'od', 'hc', 'ds', 'cm', 'vl'], function (p) {
		place = p;
		place.od = place.od.filter(r => r.target == 1);

		var arr = place.pv.filter(r => r.code.in('02', '07', '09', '15', '23', '24'));
		if (app.user.prov != '') arr = arr.filter(r => app.user.prov.contain(r.code));

		self.pvList(arr);
	});

	self.viewClick = function () {
		var submit = {
			pv: self.pv(),
			od: self.od(),
			hc: self.hc(),
			vl: self.vl(),
			year: self.year(),
			month: self.month(),
			hasform: self.filter() == 'Has Form' ? 1 : 0
		};

		app.ajax('/RCD_CMEP/getList', submit).done(function (rs) {
			self.loaded(true);
			self.listModel(rs);
		});
	};

	self.showDetail = function (model) {
		lastScrollY = window.scrollY;

		var obj = {
			displayOnly: {
				HC: self.getHCName(model.Code_Facility_T),
				OD: self.getODName(model.Code_Facility_T),
				Prov: self.getPVName(model.Code_Facility_T),
				PatientName: model.NameK,
				CaseCode: model.Case_Type + '-' + model.Case_ID
			},
			data: newModel(model.Case_ID, model.Case_Type)
		};

		if (model.HasForm == 0) {
			self.editModel(obj);
			self.view('detail');

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		} else {
			var submit = {
				Case_ID: model.Case_ID,
				Case_Type: model.Case_Type
			};
			app.ajax('/RCD_CMEP/getDetail', submit).done(function (rs) {
				rs.Detail = JSON.parse(rs.Detail);

				rs.Detail.SickAddress.other = rs.Detail.SickAddress.other || '';
				rs.Detail.Address.other = rs.Detail.Address.other || '';
				rs.Detail.Week1A.other = rs.Detail.Week1A.other || '';
				rs.Detail.Week1B.other = rs.Detail.Week1B.other || '';
				rs.Detail.Week2A.other = rs.Detail.Week2A.other || '';
				rs.Detail.Week2B.other = rs.Detail.Week2B.other || '';

				rs.Detail = app.ko(rs.Detail);

				obj.data = rs;

				self.editModel(obj);
				self.view('detail');

				$('input[numonly]').each(function () {
					app.setNumberOnly(this, $(this).attr('numonly'));
				});
			});
		}
	};

	self.save = function () {
		var data = self.editModel().data;
		data.Detail = app.unko(data.Detail);

		['SickAddress', 'Address', 'Week1A', 'Week1B', 'Week2A', 'Week2B'].forEach(name => {
			var d = data.Detail[name];
			d.Province = d.pvcode == '' ? '' : place.pv.find(r => r.code == d.pvcode).name;
			d.District = d.dscode == '' ? '' : place.ds.find(r => r.code == d.dscode).name;
			d.Commune = d.cmcode == '' ? '' : place.cm.find(r => r.code == d.cmcode).name;
			d.Village = d.vlcode == '' ? '' : place.vl.find(r => r.code == d.vlcode).name;
		});

		data.Detail = JSON.stringify(data.Detail);

		var submit = { data };
		app.ajax('/RCD_CMEP/save', submit).done(function () {
			var old = self.listModel().find(r => r.Case_ID == data.Case_ID && r.Case_Type == data.Case_Type);
			old.HasForm = 1;
			self.listModel.replace(old, clone(old));

			self.back();
		});
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblRCDCMEP',
				where: { Case_ID: model.Case_ID, Case_Type: model.Case_Type }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				model.HasForm = 0;
				self.listModel.replace(model, clone(model));
			});
		});
	};

	self.back = function () {
		self.view('list');
		window.scrollTo(0, lastScrollY);
	};

	self.getPVName = function (hccode) {
		var odcode = place.hc.find(r => r.code == hccode).odcode;
		var pvcode = place.od.find(r => r.code == odcode).pvcode;
		return place.pv.find(r => r.code == pvcode).name;
	};

	self.getODName = function (hccode) {
		var odcode = place.hc.find(r => r.code == hccode).odcode;
		return place.od.find(r => r.code == odcode).name;
	};

	self.getHCName = function (code) {
		return place.hc.find(r => r.code == code).name;
	};

	self.odList = function () {
		return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
	};

	self.hcList = function () {
		return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
	};

	self.pvList2 = function () {
		var rs = place.pv.slice();
		rs.unshift({ code: '', name: '' });
		return rs;
	};

	self.dsList = function (pvcode) {
		var rs = pvcode() == '' ? [] : place.ds.filter(r => r.pvcode == pvcode());
		rs.unshift({ code: '', name: '' });
		return rs;
	};

	self.cmList = function (dscode) {
		var rs = dscode() == '' ? [] : place.cm.filter(r => r.dscode == dscode());
		rs.unshift({ code: '', name: '' });
		return rs;
	};

	self.vlList = function (cmcode) {
		var rs = cmcode() == '' ? [] : place.vl.filter(r => r.cmcode == cmcode());
		rs.unshift({ code: '', name: '' });
		return rs;
	};

	self.getSpecies = function (d) {
		return d == 'F' ? 'Pf'
			: d == 'V' ? 'Pv'
			: d == 'M' ? 'Pv'
			: d == 'A' ? 'Pm'
			: d == 'O' ? 'Po'
			: d == 'K' ? 'Pk'
			: '';
	};

	self.getTotal = function (key, sex) {
		var detail = self.editModel().data.Detail;
		var arr = ['House', 'Traveler', 'HouseQty'];

		if (key == 'MetMember') {
			var a = arr.sum(r => detail['Member'][r][sex]().toFloat());
			var b = arr.sum(r => detail[key][r][sex]().toFloat());
			return a - b;
		}

		return arr.sum(r => (sex ? detail[key][r][sex] : detail[key][r])().toFloat());
	};

	self.ifcan = function (permission) {
		return app.user.permiss['RCD CMEP'].contain(permission);
	};

	self.exportExcel = function () {
		app.downloadBlob('/RCD_CMEP/exportExcel/').done(function (blob) {
			saveAs(blob, 'RCD CMEP.xlsx');
		});
	};

	function newModel(Case_ID, Case_Type) {
		return {
			Rec_ID: 0,
			Case_ID: Case_ID,
			Case_Type: Case_Type,
			Detail: app.ko({
				SickAddress: { Province: '', District: '', Commune: '', Village: '', pvcode: '', dscode: '', cmcode: '', vlcode: '', other: '' },
				Address: { Province: '', District: '', Commune: '', Village: '', pvcode: '', dscode: '', cmcode: '', vlcode: '', other: '' },
				Week1A: { Province: '', District: '', Commune: '', Village: '', pvcode: '', dscode: '', cmcode: '', vlcode: '', other: '' },
				Week1B: { Province: '', District: '', Commune: '', Village: '', pvcode: '', dscode: '', cmcode: '', vlcode: '', other: '' },
				Week2A: { Province: '', District: '', Commune: '', Village: '', pvcode: '', dscode: '', cmcode: '', vlcode: '', other: '' },
				Week2B: { Province: '', District: '', Commune: '', Village: '', pvcode: '', dscode: '', cmcode: '', vlcode: '', other: '' },
				DiagnosisDate: '',
				FeverDate: '',
				DiagnosticTool: '',
				Species: '',
				MicroscopeIncidence: '',
				Dot1: { Date: '', Time: '', Drug: '', Receive: '' },
				Dot2: { Date: '', Time: '', Drug: '', Receive: '' },
				Dot3: { Date: '', Time: '', Drug: '', Receive: '' },
				DotReason: '',
				Day28: '',
				MetPatient: '',
				NoMetReason: '',
				Temperature: '',
				Hot: '',
				Cold: '',
				Sweat: '',
				Headache: '',
				OtherSymptom: '',
				Result: '',
				MixIncidence: '',
				Gametocyte: '',
				Member: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				MetMember: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				Test: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				Positive: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				Pf: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				Pv: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				Mix: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				Treated: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				Educated: { House: { Male: '', Female: '' }, Traveler: { Male: '', Female: '' }, HouseQty: { Male: '', Female: '' } },
				HouseLLIN100: { House: '', Traveler: '', HouseQty: '' },
				HouseLLINLess100: { House: '', Traveler: '', HouseQty: '' },
				LLIN: { House: '', Traveler: '', HouseQty: '' },
				LLIHN: { House: '', Traveler: '', HouseQty: '' },
				Repellent: { House: '', Traveler: '', HouseQty: '' },
				Reporter: ''
			})
		};
	};
}