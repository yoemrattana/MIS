function viewModel() {
	var self = this;

	self.numRDT = ko.observable(25000000);
	self.pcRDT = ko.observable(3);
	self.costPerCRP = ko.observable(1);
	self.costPerDose = ko.observable(0);

	self.Bacterial = ko.observable(5);

	self.Antibiotic1 = ko.observable(57);
	self.Antibiotic2 = ko.observable(59);
	self.Antibiotic3 = ko.observable(86);
	self.Antibiotic4 = ko.observable(33);

	self.Resolved1 = ko.observable(80);
	self.Resolved2 = ko.observable(10);
	self.Resolved3 = ko.observable(5);

	self.sumDoses1 = function () {
		var rs = 0;
		with (self) {
			rs += Bacterial() * Antibiotic1();
			rs += (100 - Bacterial()) * Antibiotic2();
		}
		return rs / 100;
	};

	self.sumDoses2 = function () {
		var rs = 0;
		with (self) {
			rs += Bacterial() * Antibiotic3();
			rs += (100 - Bacterial()) * Antibiotic4();
		}
		return rs / 100;
	};

	self.sumResolved1 = function () {
		var rs = 0;
		with (self) {
			rs += Bacterial() * Antibiotic1() * Resolved1();
			rs += Bacterial() * (100 - Antibiotic1()) * Resolved2();
			rs += (100 - Bacterial()) * Antibiotic2() * Resolved3();
			rs += (100 - Bacterial()) * (100 - Antibiotic2()) * Resolved3();
		}
		return rs / 10000;
	};

	self.sumResolved2 = function () {
		var rs = 0;
		with (self) {
			rs += Bacterial() * Antibiotic3() * Resolved1();
			rs += Bacterial() * (100 - Antibiotic3()) * Resolved2();
			rs += (100 - Bacterial()) * Antibiotic4() * Resolved3();
			rs += (100 - Bacterial()) * (100 - Antibiotic4()) * Resolved3();
		}
		return rs / 10000;
	};

	self.AdditionalCasesResolved = function () {
		var rs = 0;
		with (self) {
			rs = (100 - pcRDT()) * numRDT() * (sumResolved2() - sumResolved1());
		}
		return (rs / 10000).toFixed(2).toFloat();
	};

	self.DosesAverted = function () {
		var rs = 0;
		with (self) {
			rs = (100 - pcRDT()) * numRDT() * (sumDoses1() - sumDoses2());
		}
		return (rs / 10000).toFixed(2).toFloat();
	};

	self.ICERcase = function () {
		var rs = 0;
		with (self) {
			rs = (100 - pcRDT()) * costPerCRP() * numRDT() / AdditionalCasesResolved();
		}
		if (rs == Infinity) rs = 0;

		return (rs / 100).toFixed(0);
	};

	self.ICERdose = function () {
		var rs = 0;
		with (self) {
			rs = (100 - pcRDT()) * costPerCRP() * numRDT() / DosesAverted();
		}
		if (rs == Infinity) rs = 0;

		return (rs / 100).toFixed(0);
	};

	self.CostCurrent = function () {
		var rs = 0;
		with (self) {
			rs = (sumDoses1() + sumDoses2()) * costPerDose();
		}
		return rs.toFixed(1);
	};

	self.CostCRP = function () {
		var rs = 0;
		with (self) {
			rs = (sumDoses1() + sumDoses2()) * (costPerDose() + costPerCRP());
		}
		return rs.toFixed(1);
	};
}