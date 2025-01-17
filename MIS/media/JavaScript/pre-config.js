$.ajaxSetup({
	converters: {
		'text json': function (json) {
			return json === '' ? undefined : JSON.parse(json);
		}
	}
});

moment.updateLocale('en', {
	week: { dow: 1 } //set monday to the first day of the week
});

moment.prototype.format_original = moment.prototype.format;
moment.prototype.format = function (format) {
	return this.isValid() ? this.format_original(format) : null;
};

moment.prototype.toDate_original = moment.prototype.toDate;
moment.prototype.toDate = function () {
	return this.isValid() ? this.toDate_original() : null;
};

moment.prototype.sqlformat = function (mode) {
	return mode == 'datetime' ? this.format('YYYY-MM-DD HH:mm:ss')
		: mode == 'time' ? this.format('HH:mm:ss')
			: this.format('YYYY-MM-DD');
};

moment.prototype.displayformat = function (mode) {
	return mode == 'datetime' ? this.format('DD/MM/YYYY HH:mm')
		: mode == 'time' ? this.format('HH:mm')
			: this.format('DD/MM/YYYY');
};

if (window.Highcharts) {
	(function () {
		function chartTitle(title) {
			var n = title.lastIndexOf(",");
			if (n == -1) return title;
			return title.substring(0, n);
		}

		function exportDataSource() {
			var title = chartTitle(this.userOptions.title.text).trim();
			if (app.user.permiss['Data Chart'] != undefined && app.user.permiss['Data Chart'].contain(title)) {
				this.downloadXLS();
				return;
			}
			app.showMsg('<kh>សិទ្ធិ</kh> Permission', '<kh>លោកអ្នកមិនមានសិទ្ធិក្នុងការទាញយកទិន្នន័យនេះទេ!</kh></br> You are not authorize to donwload this data source!')
		}

		Highcharts.Chart.prototype.downloadXLS = function () {
			var hasParent = false;
			var data = this.getDataRows().map(r => {
				var cells = r.slice();
				if (typeof r[0] === 'object') {
					cells[0] = r[0].name;
					if (r[0].parent != null) {
						hasParent = true;
						cells.unshift(r[0].parent.name);
					}
				}
				return cells;
			});
			if (hasParent) data[0].unshift('Category');

    		var wb = XLSX.utils.book_new();
    		XLSX.utils.book_append_sheet(wb, XLSX.utils.aoa_to_sheet(data));
    		XLSX.writeFile(wb, this.userOptions.title.text + '.xlsx', { compression: true });
		};

        Highcharts.setOptions({
			credits: { enabled: false },
			colors: ['#7cb5ec', '#f45b5b', '#f7a35c', '#2b908f', '#8085e9', '#90ed7d', '#e4d354', '#f15c80', '#434348', '#91e8e1'],
			plotOptions: { spline: { marker: { symbol: 'circle' } } },
			lang: { downloadPNG: 'Download Image', downloadXLS: 'Download Data Source', thousandsSep: '' },
			exporting: {
				buttons: { contextButton: { menuItems: ['downloadPNG', 'downloadXLS'] } },
				menuItemDefinitions: { downloadXLS: { onclick: exportDataSource } }
            },
        });
	})();
}


Object.defineProperty(Object.prototype, 'in', {
	value: function () {
		if (arguments.length == 0) return false;
		var arr = Array.isArray(arguments[0]) ? arguments[0] : arguments;
		for (var i = 0; i < arr.length; i++) {
			if (arr[i] == this) return true;
		}
		return false;
	}
});

Object.defineProperty(Object.prototype, 'applyData', {
	value: function () {
		var data = arguments[0];
		if (data instanceof Object) {
			var dataKeys = Object.keys(data);
			for (var key in this) {
				if (dataKeys.includes(key)) this[key] = data[key];
			}
		}
		return this;
	}
});

window.is = function (obj, condition, newValueOrFn) {
	if (obj !== condition) return obj;
	return typeof newValueOrFn == 'function' ? newValueOrFn(obj) : newValueOrFn;
}

window.isnot = function (obj, condition, newValueOrFn) {
	if (obj === condition) return obj;
	return typeof newValueOrFn == 'function' ? newValueOrFn(obj) : newValueOrFn;
}

window.isnull = function (value, replace) {
	if (value != null) return value;
	return typeof replace == 'function' ? replace(value) : replace;
};

window.isempty = function (value, replace) {
	if (value !== '') return value;
	return typeof replace == 'function' ? replace(value) : replace;
};

window.isnullempty = window.isnone = function (value, replace) {
	var isTrue = value == null || value === '';
	if (replace === undefined) return isTrue;
	return !isTrue ? value : typeof replace == 'function' ? replace(value) : replace;
};

window.trim = function (value) {
	return value == null ? '' : value.toString().trim();
};

window.clone = function (obj) {
	return JSON.parse(JSON.stringify(obj));
};

window.comma = function (value) {
	return value?.toLocaleString('en-US');
};

window.iskhmer = function (value) {
	return new RegExp('[ក-\u17fe᧠-᧾]', 'gi').test(value);
};

Array.prototype.contain = function (value) {
	return this.indexOf(value) > -1;
};

Array.prototype.sum = function (callbackOrName) {
	return this.reduce(function (a, b) {
		return a + parseFloat((callbackOrName === undefined ? b : typeof callbackOrName == 'function' ? callbackOrName(b) : b[callbackOrName]) || 0);
	}, 0);
};

Array.prototype.distinct = function (callbackOrName) {
	return this.reduce(function (rs, value) {
		var existed = rs.some(r => {
			return callbackOrName === undefined ? r == value
				: typeof callbackOrName == 'function' ? callbackOrName(r) == callbackOrName(value)
				: r[callbackOrName] == value[callbackOrName];
		});
		if (!existed) rs.push(value);
		return rs;
	}, []);
};

Array.prototype.last = function () {
	return this[this.length - 1];
};

Array.prototype.sortasc = function (...params) {
	if (params.length == 0) {
		this.sort((a, b) => a > b ? 1 : a < b ? -1 : 0);
	} else {
		this.sort(function (a, b) {
			for (var i = 0; i < params.length; i++) {
				var p = params[i];
				var aa = typeof p == 'function' ? p(a) : a[p];
				var bb = typeof p == 'function' ? p(b) : b[p];
				if (aa != bb) return aa > bb ? 1 : -1;
			}
			return 0;
		});
	}
	return this;
};

Array.prototype.sortdesc = function (...params) {
	if (params.length == 0) {
		this.sort((a, b) => a > b ? -1 : a < b ? 1 : 0);
	} else {
		this.sort(function (a, b) {
			for (var i = 0; i < params.length; i++) {
				var p = params[i];
				var aa = typeof p == 'function' ? p(a) : a[p];
				var bb = typeof p == 'function' ? p(b) : b[p];
				if (aa != bb) return aa > bb ? -1 : 1;
			}
			return 0;
		});
	}
	return this;
};

Array.prototype.insert = function (index, item) {
	this.splice(index, 0, item);
};

Array.prototype.remove = function (item) {
	var i = this.indexOf(item);
	if (i > -1) this.splice(i, 1);
};

Array.prototype.groupby = function (...params) {
	var uniqueValue = this.reduce(function (rs, value) {
		var existed = rs.some(r => params.every(p => typeof p == 'function' ? p(r) == p(value) : r[p] == value[p]));
		if (!existed) rs.push(value);
		return rs;
	}, []);
	return uniqueValue.map(uv => this.filter(r => params.every(p => typeof p == 'function' ? p(r) == p(uv) : r[p] == uv[p])));
};

Array.repeat = function (length, value) {
	var arr = [];
	for (var i = 0; i < length; i++) {
		arr.push(typeof value == 'function' ? value(i) : value);
	}
	return arr;
}

Array.range = function (start, end) {
	var arr = [];
	for (var i = start; i <= end; i++) {
		arr.push(i);
	}
	return arr;
}

String.prototype.contain = function (value) {
	return this.indexOf(value) > -1;
};

String.format = function (format) {
	var args = Array.prototype.slice.call(arguments, 1);
	return format.replace(/{(\d+)}/g, function (match, number) {
		return typeof args[number] != 'undefined' ? args[number] : match;
	});
};

String.prototype.toFloat = function () {
	return isNaN(parseFloat(this)) ? 0 : parseFloat(this);
};

Number.prototype.toFloat = function () {
	return isNaN(parseFloat(this)) ? 0 : parseFloat(this);
};

window.toFloat = function (value) {
	return isNaN(parseFloat(value)) ? 0 : parseFloat(value);
};