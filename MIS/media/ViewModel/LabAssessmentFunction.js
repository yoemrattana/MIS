function assessmentFunction(self) {

	self.getHead = function (key, i) {
		if (self.heads().length == 0) return;

		if (i != null) {
			var found = self.heads().find(r => r.Num() == i);
			return (found || {})[key];
		}

		var arr = self.heads().filter(r => r.Num() != null);
		var found = self.heads().find(r => r.Num() == null);
		if (found == null) return 0;

		if (key == 'Negative') {
			var len = arr.filter(r => r.Diagnosis1() == 'N').length;
			found.Negative(len);
			return len;
		}
		if (key == 'Detection') {
			var species = ['F', 'V', 'A', 'O', 'K'];
			var len = arr.filter(r => species.contain(r.Diagnosis1())).length;
			found.Detection(len);
			return len;
		}
		if (key == 'Identification') {
			var species = ['F', 'V', 'A', 'O', 'K'];
			var len = arr.filter(r => species.contain(r.Diagnosis1())).length;
			found.Identification(len);
			return len;
		}
		if (key == 'Counting') {
			var len = arr.filter(r => !isnone(r.Mean())).length;
			found.Counting(len);
			return len;
		}
	};

	self.getMin = function (i) {
		if (self.heads().length == 0) return;

		var value = self.getHead('Mean', i)();
		if (isnone(value)) return;
		value = value.toFloat();
		return (value - (value * 0.25)).toFixed(0);
	};

	self.getMax = function (i) {
		if (self.heads().length == 0) return;

		var value = self.getHead('Mean', i)();
		if (isnone(value)) return;
		value = value.toFloat();
		return (value + (value * 0.25)).toFixed(0);
	};

	self.getValue = function (id, key, i) {
		if (self.details().length == 0) return;

		if (i != null) {
			return self.details().find(r => r.Staff_ID() == id && r.Num() == i)[key];
		}

		var arr = self.details().filter(r => r.Staff_ID() == id && r.Num() != null);
		var found = self.details().find(r => r.Staff_ID() == id && r.Num() == null);
		var head = self.heads().reduce((a, b) => {
			if (b.Num() != null) a[b.Num()] = b;
			return a;
		}, {});

		if (key == 'Negative') {
			var len = arr.filter(r => head[r.Num()].Diagnosis1() == 'N' && r.Diagnosis1() == 'N').length;
			found.Negative(len);
			return len;
		}
		if (key == 'Detection') {
			var species = ['F', 'V', 'A', 'O', 'K'];
			var len = arr.filter(r => species.contain(head[r.Num()].Diagnosis1()) && (species.contain(r.Diagnosis1()) || species.contain(r.Diagnosis2()))).length;
			found.Detection(len);
			return len;
		}
		if (key == 'Identification') {
			var species = ['F', 'V', 'A', 'O', 'K'];
			var len = arr.filter(r => {
				var d1 = head[r.Num()].Diagnosis1();
				var d2 = head[r.Num()].Diagnosis2();
				if (!species.contain(d1)) return false;
				var list = [d1];
				if (species.contain(d2)) list.push(d2);
				return list.contain(r.Diagnosis1()) || list.contain(r.Diagnosis2());
			}).length;
			found.Identification(len);
			return len;
		}
		if (key == 'Counting') {
			var len = arr.filter(r => {
				if (isnone(head[r.Num()].Mean()) || isnone(r.Count())) return false;
				var min = toFloat(self.getMin(r.Num()));
				var max = toFloat(self.getMax(r.Num()));
				var c = r.Count().toFloat();
				return c >= min && c <= max;
			}).length;
			found.Counting(len);
			return len;
		}
	};

	self.isCorrect = function (id, key, i) {
		if (self.heads().length == 0 || self.details().length == 0) return false;

		if (key.contain('Diagnosis')) {
			var head = self.getHead(key, i)();
			var value = self.getValue(id, key, i)();
			return !isnone(value) && value == head;
		}

		if (key == 'Count') {
			var mean = self.getHead('Mean', i)();
			var value = self.getValue(id, key, i)();
			if (isnone(mean) || isnone(value)) return false;
			var min = toFloat(self.getMin(i));
			var max = toFloat(self.getMax(i));
			value = value.toFloat();
			return value >= min && value <= max;
		}
	};

	self.getPercent = function (id, key) {
		if (self.heads().length == 0 || self.details().length == 0) return;

		var value = self.details().find(r => r.Staff_ID() == id && r.Num() == null)[key]();
		var divisor = self.heads().find(r => r.Num() == null)[key]();
		return divisor == 0 ? '0%' : (value * 100 / divisor).toFixed(0) + '%';
	};

	self.getTotal = function (key, i) {
		if (self.heads().length == 0 || self.details().length == 0) return;

		if (key.contain('Diagnosis')) {
			var species = self.heads().find(r => r.Num() == i)[key]();
			return species == '' ? 0 : self.details().filter(r => r.Num() == i && r[key]() == species).length;
		}

		if (key == 'Count') {
			if (isnone(self.getHead('Mean', i)())) return 0;
			var min = toFloat(self.getMin(i));
			var max = toFloat(self.getMax(i));
			return self.details().filter(r => {
				if (r.Num() != i) return false;
				var c = r.Count();
				if (isnone(c)) return false;
				c = c.toFloat();
				return c >= min && c <= max;
			}).length;
		}
	};

	self.getTotalPercent = function (key, i) {
		var value = self.getTotal(key, i);
		var len = self.staffs().length;
		return (value * 100 / len).toFixed(0) + '%';
	};
}