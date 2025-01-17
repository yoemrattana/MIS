$('.btnmenu').each(function (index, el) {
	if (location.pathname.contain($(el).attr('href'))) {
		$(el).removeClass('btn-default').addClass('btn-info');
	}
});

function viewModel() {
	var self = this;

	self.laboList = ko.observableArray();
	self.clinicList = ko.observableArray();
	self.notBothList = ko.observableArray();
	self.checkResultList = ko.observableArray();
	self.tableMonthReport = ko.observable();

	self.loaded = ko.observable(false);

	app.getPlace(['pv', 'od', 'hc'], function (p) {
		place = p;

		app.ajax('/QMalaria/getReportData2').done(function (rs) {
			self.loaded(true);

			prepareLabo(rs.labo);
			prepareClinic(rs.clinic);
			self.notBothList(rs.notBoth);
			self.checkResultList(rs.checkResult);
			drawTableMonthReport(rs.monthReport, rs.malariaTest);
		});
	});

	function contain(text, find) {
		return text != null && text.contain(find);
	}

	function prepareLabo(data) {
		data.forEach(r => {
			r.missing = false;
			r.missingList = [];
			r.type = 'labo';

			function add(text) {
				r.missing = true;
				r.missingList.push(text);
			}

			if (isnullempty(r.TestCRP)) add('1');
			if (isnullempty(r.BloodDate)) add('2');
			if (isnullempty(r.BloodCondition)) add('3');
			if (isnullempty(r.BloodKeepingDate)) add('4');
			if (isnullempty(r.TestDate)) add('5');
			if (isnullempty(r.Nycocoard)) add('6');
			if (isnullempty(r.CRPLevel)) add('7');
			if (isnullempty(r.DataEntryDate)) add('9');
			if (isnullempty(r.DataEntryUser)) add('10');
		});

		self.laboList(data.filter(r => r.missing));
	}

	function prepareClinic(data) {
		data.forEach(r => {
			r.missing = false;
			r.missingList = [];
			r.type = 'clinic';

			function add(text) {
				r.missing = true;
				r.missingList.push(text);
			}

			if (isnullempty(r.ConsultDate)) add('A1');
			if (isnullempty(r.PlaceCode)) add('A2');
			if (isnullempty(r.B1)) add('B1');
			if (isnullempty(r.B2)) add('B2');
			if (isnullempty(r.B3)) add('B3');
			if (isnullempty(r.C1)) add('C1');
			if (isnullempty(r.C2)) add('C2');
			if (isnullempty(r.Age)) add('D1');
			if (isnullempty(r.Sex)) add('D1');
			if (isnullempty(r.Temp)) add('E1');
			if (isnullempty(r.ChiefComplaint)) add('E2');
			if (isnullempty(r.Disease)) add('E3');
			if (contain(r.Disease, 'Other') && isnullempty(r.DiseaseOther)) add('E3');
			if (isnullempty(r.RDTResult)) add('F1');

			if (['050112', '050104', '050124', '050108', '050119'].contain(r.Code_Facility_T) == false) {
				if (isnullempty(r.CRPMalariaResult)) add('G1');
				if (isnullempty(r.CRPResult)) add('G2');
			}

			if (isnullempty(r.Blood)) add('H1');
			if (isnullempty(r.MalariaTreatment)) add('I1');
			if (contain(r.MalariaTreatment, 'Other') && isnullempty(r.MalariaTreatmentOther)) add('I1');
			if (isnullempty(r.AntibioticTreatment)) add('J2');
			if (contain(r.AntibioticTreatment, 'Other') && isnullempty(r.AntibioticTreatmentOther)) add('J2');
			if (isnullempty(r.OtherTreatment)) add('K2');
			if (contain(r.OtherTreatment, 'Other') && isnullempty(r.OtherTreatmentOther)) add('K2');
		});

		self.clinicList(data.filter(r => r.missing));
	}

	self.showDetail = function (model) {
		open(`/QMalaria/index/${model.type}?recid=${model.Rec_ID}`);
	};

	self.exportAll = function () {
		app.downloadBlob('/QMalaria/exportAll').done(function (blob) {
			saveAs(blob, 'Labo & Clinical.xlsx'); //from FileSaver.js
		});
	};

	self.getProvName = function (hccode) {
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

	self.getIdentityCode = function (obj) {
		var code = isnull(isnull(obj.PatientCode, obj.ParticipantCode), obj.DocNumber);
		return code.contain('MA011') ? code : 'MA011' + code;
	};

	function drawTableMonthReport(data, malariaTest) {
		var yearMonths = data.map(r => r.YearMonth).distinct().sortasc();
		var hfs = data.map(r => r.Code_Facility_T).distinct().sortasc(r => self.getHCName(r));
		hfs = hfs.map(code => {
			return {
				name: self.getHCName(code),
				items: yearMonths.map(ym => {
					var found = data.find(r => r.Code_Facility_T == code && r.YearMonth == ym);
					var foundTest = malariaTest.find(r => r.Code_Facility_T == code && r.YearMonth == ym);
					return {
						labo: found == null ? 0 : found.Labo,
						clinic: found == null ? 0 : found.Clinic,
						followup: found == null ? 0 : found.Followup,
						test: foundTest == null ? 0 : foundTest.Test
					};
				})
			};
		});
		self.tableMonthReport({ yearMonths: yearMonths, hfs: hfs });
	}
}