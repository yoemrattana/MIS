function viewModel() {
	var self = this;

	self.tab = ko.observable('Pre Filter');
	self.isCountry = ko.observable(false);

	self.dateFrom = ko.observable(moment().add(-1, 'months').month('Jan'));
	self.dateTo = ko.observable(moment().add(-1, 'months'));

	self.pv = ko.observable();
	self.od = ko.observable();

	self.pivot = ko.observable();
	self.chart = new chartClass(self);
	self.cellEditor = new cellEditorClass();
	self.joinFilter = ko.observable();

	self.rawData = [];
	self.decimal = ko.observable(2);
	self.displayRow = ko.observable(0);
	self.displayTotal = ko.observable(true);

	self.place = ko.observable();

	app.getPlace(['pv', 'od'], function (place) {
		if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

		self.place(place);
	});

	self.pvList = ko.pureComputed(function () {
		if (self.place() == null) return [];
		return self.isCountry() ? self.place().pv : self.place().pv.filter(r => r.target == 1);
	});

	self.odList = ko.pureComputed(function () {
		var list = [];
		if (self.pv() != null) list = self.place().od.filter(r => r.pvcode == self.pv());
		return self.isCountry() ? list : list.filter(r => r.target == 1);
	});

	self.tabClick = function (model, event) {
		if (self.pivot() == null) return;
		self.tab(event.currentTarget.innerHTML);
		if (self.tab() == 'Chart') self.chart.updateChart();
	};

	self.rightClick = function (data, event) {
		return event.ctrlKey;
	};

	self.checkValue = function (value) {
		return typeof value != 'number' || Math.floor(value) == value ? value
			: value.toFixed(self.decimal());
	};

	self.changeDecimal = function (i) {
		var n = self.decimal() + i;
		if (n >= 0 && n <= 8) self.decimal(n);
	};

	self.joinFitlerClick = function () {
		self.joinFilter(new joinFilterClass(self));
		$('#modalJoinFilter').modal('show');
	};

	self.submitClick = function () {
		var start = parseInt(self.dateFrom().format('YYYYMM'));
		var end = parseInt(self.dateTo().format('YYYYMM'));
		var list = [];
		var rs = [];

		for (var i = start; i <= end; i++) {
			if (i.toString().substr(-2) == '13') i += 88;
			list.push({ name: i, loaded: false });
		}
		var total = list.length;

		$('#modalLoading .modal-title').text(`Data Loaded: 0 / ${total} (0%)`);
		$('#modalLoading').modal('show');

		list.forEach(item => {
			var submit = {
				type: self.isCountry() ? 'Country' : 'Endemic',
				name: item.name
			};
			app.ajax('/PivotChart/getData', submit, false).done(function (data) {
				rs = rs.concat(data);
				item.loaded = true;

				var got = list.filter(r => r.loaded).length;
				var percent = (got * 100 / total).toFixed(0);
				$('#modalLoading .modal-title').text(`Data Loaded: ${got} / ${total} (${percent}%)`);

				if (list.every(r => r.loaded)) {
					setTimeout(function () {
						$('#modalLoading').modal('hide');
						done();
					}, 500);
				}
			});
		});

		function done() {
			var pv = self.pv() || app.user.prov;
			var od = self.od() || app.user.od;

			if (pv != '') pv = self.pvList().filter(r => pv.contain(r.code)).map(r => r.name).join(',');
			if (od != '') od = self.odList().find(r => r.code == od).name;

			if (pv != '' || od != '') {
				rs = rs.filter(r => od != '' ? r.OD == od : pv.contain(r.Province));
			}
			self.rawData = rs;

			if (rs.length == 0) {
				app.showMsg('No Data', 'Please change filter');
				self.pivot(null);
			} else {
				self.tab('Pivot Table');
				self.pivot(new pivotClass(self));
			}
		}
	};

	self.exportExcel = function () {
		var p = self.pivot();
		if (p.tableHead().length == 0) return;

		var data = {
			head: p.tableHead().map(tr => tr.map(r => { return { rowspan: r.rowspan, colspan: r.colspan, text: r.text() } })),
			body: p.tableBody(),
			foot: p.tableFoot(),
			textcolumn: self.pivot().rowList().length
		};
		var submit = { data: JSON.stringify(data) };

		app.downloadBlob('/PivotChart/exportExcel', submit).done(function (blob) {
			saveAs(blob, 'Pivot Table.xlsx');
		});
	};

	$('.splitbar').mousedown(function (event) {
		if (event.which == 3) return; //which = 3 is right click

		$(document).one('mouseup', function () {
			$(document).off('mousemove.mis');
		});

		var bar = this;
		var display = $('.panel')[0];
		var control = $('.controlbox')[0];
		var displayWidth = display.offsetWidth;
		var controlWidth = control.offsetWidth;

		$(document).on('mousemove.mis', function (mouse) {
			var offset = mouse.clientX - event.clientX;
			bar.style.right = (controlWidth - offset) + 'px';
			display.style.width = (displayWidth + offset) + 'px';
			control.style.width = (controlWidth - offset) + 'px';
		});
	});

	self.itemMousedown = function (model, event) {
		if (event.which == 3) return; //which = 3 is right click

		var oldItem = event.currentTarget;
		var oldBoxId = oldItem.parentNode.id;
		var divPlace = document.createElement('div');
		divPlace.className = 'listitem-place';

		var item = document.body.appendChild(oldItem.cloneNode(true));
		item.style.position = 'absolute';
		updatePosition(event);

		if (oldBoxId != 'fieldList') event.touches ? $(oldItem).hide() : $(oldItem).remove();

		$(document).one(event.touches ? 'touchend' : 'mouseup', function () {
			$(document).off(event.touches ? 'touchmove.listitem' : 'mousemove.listitem');
			$('.listbox').css('border-color', '');
			$(item).remove();

			var inside = $(divPlace).parent().length > 0;

			if (inside) {
				var index = $(divPlace).parent().children().index(divPlace);
				var newBoxId = divPlace.parentNode.id;

				['columnList', 'rowList', 'valueList', 'filterList'].forEach(id => {
					if (oldBoxId == newBoxId && id != oldBoxId) return;
					if (newBoxId == 'filterList') {
						if (oldBoxId == 'fieldList' && id != 'filterList') return;
					} else {
						if (oldBoxId != 'filterList' && id == 'filterList') return;
					}

					var removed = self.pivot()[id].remove(model);
					if (id == 'filterList' && oldBoxId != newBoxId && removed.length > 0) {
						self.pivot().filterData[model.name].forEach(r => r.checked(true));
						self.pivot().filterLog[model.name] = null;
						model.filterText(' (All)');
					}
				});

				self.pivot()[newBoxId].splice(index, 0, model);
				$(divPlace).remove();

				if (oldBoxId != newBoxId) {
					if (newBoxId == 'valueList') {
						model.sort('none');
						model.formula(model.isNumber ? 'Sum' : 'Count');
					} else {
						model.sort('asc');
					}
				}
			} else {
				if (oldBoxId != 'fieldList') self.pivot()[oldBoxId].remove(model);
			}

			if (inside || oldBoxId != 'fieldList') {
				self.pivot().fieldList().forEach(r => {
					if (r.sort() == 'none') r.sort('asc');
				});
				self.pivot().refreshDisplay();
			}
		});

		$(document).on(event.touches ? 'touchmove.listitem' : 'mousemove.listitem', updatePosition);

		function updatePosition(mouse) {
			var x = xx = mouse.clientX || mouse.touches[0].clientX;
			var y = yy = mouse.clientY || mouse.touches[0].clientY;

			if (navigator.userAgent.contain('iPhone') || navigator.userAgent.contain('iPad')) {
				xx = mouse.touches[0].screenX;
				yy = mouse.touches[0].screenY;
			}

			item.style.left = (xx - (item.offsetWidth / 2)) + 'px';
			item.style.top = (yy - (item.offsetHeight / 2)) + 'px';

			var inside = false;
			var boxid = null;
			$('.listbox').css('borderColor', '').each(function () {
				var rect = this.getBoundingClientRect();
				inside = x > rect.left && x < rect.right && y > rect.top && y < rect.bottom;
				if (inside) {
					this.style.borderColor = 'red';
					boxid = this.id;
					if (boxid != 'fieldList') {
						var listitems = $(this).find('.listitem');
						if (listitems.length == 0) $(this).append(divPlace);
						else {
							listitems.each(function (i) {
								var rect = this.getBoundingClientRect();

								var inside2 = listitems.length == 1 ? true
									: i == 0 ? y <= rect.bottom
									: i < listitems.length - 1 ? y >= rect.top && y <= rect.bottom
									: y >= rect.top;

								if (inside2) {
									var middle = rect.top + (rect.height / 2);
									y <= middle ? $(this).before(divPlace) : $(this).after(divPlace);
									return false;
								}
							});
						}
					}
					return false;
				}
			});
			if (!inside || boxid == 'fieldList') $(divPlace).remove();
		}
	};

	self.showContextMenu = function (model, event) {
		if (event.ctrlKey) return true;

		var item = event.currentTarget;
		var menu = $('.ctmenu');
		var setting = model.setting || model;
		var isHead = item.tagName != 'TBODY';

		var hideSort = isHead && self.pivot().valueList().contain(setting);
		menu.find('.item').removeClass('active');
		menu.find('.sort').css('display', hideSort ? 'none' : '');
		menu.find('.formula').css('display', hideSort ? '' : 'none');

		if (isHead) {
			menu.find('#' + setting.sort() + ',#' + setting.formula()).addClass('active');
			menu.find('.formula').find('.item:not(#Count)').css('display', setting.isNumber ? '' : 'none');
		} else {
			item = event.target;
		}

		item.style.backgroundColor = '#00fa9a';

		var x = event.clientX, y = event.clientY;
		var w = menu.outerWidth(), h = menu.outerHeight();

		menu.css({
			left: x + w < innerWidth ? x : x - w,
			top: y + h < innerHeight - 30 ? y : y - h
		}).show();

		function hideMenu() {
			item.style.backgroundColor = '';
			menu.hide();

			$(document).off('mousedown.ctmenu');
			$('.ctmenu .item').off('click');
		}

		$(document).on('mousedown.ctmenu', function (e) {
			if (!$.contains(menu[0], e.target)) hideMenu();
		});

		$('.ctmenu .item').click(function (e) {
			hideMenu();

			var type = e.currentTarget.getAttribute('type');
			var id = e.currentTarget.id;

			if (isHead) {
				setting[type](id);
				self.pivot().refreshDisplay();
			} else {
				self.pivot().sortBodyByValue($(item).index(), id);
			}
		});
	};

	self.showFitlerMenu = function (setting, event) {
		var btn = event.currentTarget;
		var menu = $('.filtermenu');

		if (menu.is(':visible')) return;

		var filterMenu = self.pivot().filterMenu;
		filterMenu.name(setting.name);

		var rect = btn.getBoundingClientRect();
		menu.css({ left: rect.left, top: rect.bottom + 4 }).show();

		$(document).on('mousedown.filtermenu', function (e) {
			if ($.contains(menu[0], e.target)) return;
			if (btn == e.target || $.contains(btn, e.target)) return;

			menu.hide();
			$(document).off('mousedown.filtermenu');

			filterMenu.refresh(setting);
		});
	};
}

function pivotClass(vm) {
	var self = this;

	var colFilter = [];
	var filteredRawData = [];

	self.fieldList = ko.observableArray();
	self.filterList = ko.observableArray();
	self.columnList = ko.observableArray();
	self.rowList = ko.observableArray();
	self.valueList = ko.observableArray();

	self.joinFilterList = ko.observableArray();

	self.filterData = {};
	self.filterLog = {};
	self.tableHead = ko.observableArray();
	self.tableBody = ko.observableArray();
	self.tableFoot = ko.observableArray();
	self.columnTotal = ko.observable();

	if (vm.rawData.length > 0) {
		var item = vm.rawData[0];
		var fields = Object.keys(item).map(name => {
			return {
				name: name,
				isNumber: typeof item[name] == 'number',
				formula: ko.observable('none'),
				sort: ko.observable('none'),
				filterText: ko.observable(' (All)')
			};
		});
		self.fieldList(fields);
	}

	self.refreshDisplay = function () {
		colFilter = [];
		vm.displayRow(25);

		updateFilteredRawData();
		prepareFitler();
		preparTableHead();
		preparTableBody();

		if (vm.tab() == 'Chart') vm.updateChart();
	};

	self.getTableBody = ko.pureComputed(function () {
		return self.tableBody.slice(0, vm.displayRow());
	});

	self.filterMenu = new (function () {
		this.name = ko.observable('');
		this.search = ko.observable('').extend({ rateLimit: 100 });
		this.list = ko.pureComputed(() => {
			if (this.name() == '') return [];
			var search = this.search().toUpperCase();
			return self.filterData[this.name()].filter(r => {
				return r.value.toString().toUpperCase().contain(search);
			});
		});
		this.refresh = function (setting) {
			this.search('');
			var filters = self.filterData[this.name()];
			var founds = filters.filter(r => r.checked());
			var text = founds.length == filters.length ? 'All'
				: founds.length == 0 ? 'None'
				: founds.length == 1 ? founds[0].value
				: '...';
			setting.filterText(' (' + text + ')');

			self.filterLog[this.name()] = text == 'All' ? null
				: text == 'None' ? []
				: founds.length <= filters.length / 2 ? founds
				: filters.filter(r => !r.checked());

			self.refreshDisplay();
		};
	})();

	self.sortBodyByValue = function (index, direction) {
		var sort = direction == 'asc' ? 1 : -1;
		self.tableBody.sort((a, b) => {
			var aa = a[index], bb = b[index];
			return (aa > bb ? 1 : aa < bb ? -1 : 0) * sort;
		});
		self.rowList().forEach(r => r.sort('none'));
	};

	self.removeJoinFilter = function (model) {
		self.joinFilterList.remove(model);
		self.refreshDisplay();
	};

	function updateFilteredRawData() {
		var cols = self.columnList();
		var rows = self.rowList();
		var vals = self.valueList();
		if (cols.length == 0 && rows.length == 0 && vals.length == 0) return;

		var fils = self.filterList();
		var jfils = self.joinFilterList();

		filteredRawData = vm.rawData.filter(item => {
			for (var i = 0; i < fils.length; i++) {
				var name = fils[i].name;
				var log = self.filterLog[name];
				if (log == null) continue;
				if (log.length == 0) return false;
				var has = log.some(r => r.value == item[name]);
				if (log[0].checked()) {
					if (!has) return false;
				} else {
					if (has) return false;
				}
			}

			var matched = true;

			jfils.forEach(jf => {
				matched = jf.list.every(f => {
					var a = item[f.field];
					var b = f.value;

					if (typeof a == 'number') {
						var temp = parseFloat(b);
						if (!isNaN(temp)) b = temp;
					} else {
						a = a.toString().toUpperCase();
						b = b.toString().toUpperCase();
					}

					return f.operator == '==' ? a == b
						: f.operator == '!=' ? a != b
						: f.operator == '<' ? a < b
						: f.operator == '>' ? a > b
						: f.operator == '<=' ? a <= b
						: a >= b;
				});

				if (jf.mode == 'Exclude') matched = !matched;
			});

			return matched;
		});
	}

	function prepareFitler() {
		var newFilters = [];

		self.filterList().forEach(f => {
			if (self.filterData[f.name] == null) {
				newFilters.push(f.name);
				self.filterData[f.name] = [];
			}
		});
		if (newFilters.length == 0) return;

		vm.rawData.forEach(item => {
			newFilters.forEach(name => {
				if (self.filterData[name].some(r => r.value == item[name])) return;
				self.filterData[name].push({ value: item[name], checked: ko.observable(true) });
			});
		});

		newFilters.forEach(name => {
			self.filterData[name].sortasc(r => r.value);
		});
	}

	function preparTableHead() {
		var rows = self.rowList();
		var cols = self.columnList();
		var vals = self.valueList();
		var list = [];

		if (rows.length > 0) {
			var span = 1;
			if (cols.length > 0) {
				span = cols.length;
				if (vals.length > 1) span++;
			}

			list[0] = [];
			rows.forEach(s => {
				list[0].push({ text: ko.observable(s.name), rowspan: span, colspan: 1, setting: s });
			});
		}

		if (cols.length > 0) {
			if (cols.length == 0) return [];

			var founds = filteredRawData.reduce((arr, item) => {
				var existed = arr.some(r => cols.every(c => r[c.name] == item[c.name]));
				if (!existed) arr.push(item);
				return arr;
			}, []);
			sortData(founds, cols);

			var length = founds.length;
			var valCol = vals.length == 0 ? 1 : vals.length;
			var memory = {};

			for (var i = 0; i < length; i++) {
				var item = founds[i];
				var nextItem = i == length - 1 ? null : founds[i + 1];
				var different = false;
				var cf = [];

				for (var c = 0; c < cols.length; c++) {
					var colName = cols[c].name;

					if (length > 1 && i < length - 1) {
						if (!different && item[colName] != nextItem[colName]) different = true;
					} else {
						different = true;
					}

					var value = item[colName];
					memory[value] = memory[value] == null ? 1 : memory[value] + 1;
					if (different) {
						if (list[c] == null) list[c] = [];
						list[c].push({ text: ko.observable(value), rowspan: 1, colspan: memory[value] * valCol, setting: cols[c] });
						memory[value] = 0;
					}
					cf.push({ name: colName, value: value });
				}
				colFilter.push(cf);
			}
		}

		if (vals.length > 0) {
			var length = 0;

			if (cols.length == 0) length = 1;
			else if (vals.length > 1) {
				length = list.last().length;
				if (rows.length > 0 && cols.length == 1) length -= rows.length;
			}

			if (length > 0) {
				var tr = [];
				if (rows.length > 0 && cols.length == 0) {
					tr = list[0];
				} else {
					list.push(tr);
				}

				for (var i = 0; i < length; i++) {
					vals.forEach(s => {
						tr.push({ text: ko.observable(s.name), rowspan: 1, colspan: 1, setting: s });
					});
				}
			}
		}

		self.tableHead(list);
	}

	function preparTableBody() {
		var cols = self.columnList();
		var rows = self.rowList();
		var vals = self.valueList();
		var fils = self.filterList();

		if (rows.length == 0 && vals.length == 0) {
			self.tableBody([]);
			return;
		}

		var founds = filteredRawData;
		if (rows.length > 0) sortData(founds, rows);

		var rowTotal = [];
		var grandTotal = [];
		var list = [];
		var length = founds.length;

		for (var i = 0; i < length; i++) {
			var item = founds[i];
			var nextItem = i == length - 1 ? null : founds[i + 1];
			var different = false;

			if (length > 1 && i < length - 1) {
				for (var c = 0; c < rows.length; c++) {
					var colName = rows[c].name;

					if (item[colName] != nextItem[colName]) {
						different = true;
						break;
					}
				}
			} else {
				different = true;
			}

			var cflength = is(colFilter.length, 0, 1);
			var index = 0;
			for (var x = 0; x < cflength; x++) {
				var filters = colFilter.length == 0 ? null : colFilter[x];

				for (var v = 0; v < vals.length; v++) {
					var colName = vals[v].name;
					var formula = vals[v].formula();
					var rt = rowTotal[index];
					var gt = grandTotal[index];
					var value = null;

					if (filters == null || filters.every(f => item[f.name] == f.value)) {
						value = item[colName];
					}

					if (formula == 'Sum') {
						value = isnull(value, 0);
						rt = isnull(rt, 0) + value;
						gt = isnull(gt, 0) + value;
					}
					else if (formula == 'Count') {
						value = (value == null ? 0 : 1);
						rt = isnull(rt, 0) + value;
						gt = isnull(gt, 0) + value;
					}
					else if (formula == 'Max') {
						if (value != null) {
							if (rt == null || rt < value) rt = value;
							if (gt == null || gt < value) gt = value;
						}
					}
					else if (formula == 'Min') {
						if (value != null) {
							if (rt == null || rt > value) rt = value;
							if (gt == null || gt > value) gt = value;
						}
					}
					else if (formula == 'Avg') {
						if (rt == null) rt = [0, 0];
						if (gt == null) gt = [0, 0];
						if (value != null) {
							rt[0] += value;
							rt[1] += 1;
							gt[0] += value;
							gt[1] += 1;
						}
					}

					rowTotal[index] = rt;
					grandTotal[index] = gt;
					index++;
				}
			}

			if (different) {
				var tr = [];
				rows.forEach(c => tr.push(item[c.name]));
				rowTotal.forEach(value => {
					if (Array.isArray(value)) value = value[1] == 0 ? null : value[0] / value[1];
					tr.push(value);
				});
				list.push(tr);
				rowTotal = [];
			}
		}
		self.tableBody(list);

		var tr = [];
		grandTotal.forEach(value => {
			if (Array.isArray(value)) value = value[1] == 0 ? null : value[0] / value[1];
			tr.push(value);
		});
		self.tableFoot(tr);
	}

	function sortData(data, cols) {
		cols.forEach(r => {
			if (r.sort() == 'none') r.sort('asc');
		});

		data.sort((a, b) => {
			for (var i = 0; i < cols.length; i++) {
				var name = cols[i].name;
				var sort = cols[i].sort() == 'asc' ? 1 : -1;
				var aa = a[name], bb = b[name];
				if (aa != bb) return (aa > bb ? 1 : -1) * sort;
			}
			return 0;
		});
	}
}

function cellEditorClass() {
	var self = this;

	self.value = ko.observable({ text: '' });
	self.editing = ko.observable(false);
	self.cell = null;
	self.oldValue = '';
	self.textChangeEvent = null;

	self.edit = function (model, event) {
		var cell = self.cell = event.currentTarget;
		var table = $(cell).closest('table')[0];

		$('.celleditor').css({
			left: cell.offsetLeft + table.offsetLeft,
			top: cell.offsetTop + table.offsetTop,
			width: cell.offsetWidth,
			height: cell.offsetHeight
		});

		self.value(model);
		self.editing(true);
		self.oldValue = model.text();

		$('.celleditor').select();

		if (self.textChangeEvent != null) self.textChangeEvent.dispose();
		self.textChangeEvent = model.text.subscribe(function () {
			$('.celleditor').css('width', self.cell.offsetWidth);
		});

		$('.controlbox').off('mousedown.celleditor').one('mousedown.celleditor', () => self.editing(false));
	};

	self.onKeydown = function (model, event) {
		var key = event.keyCode;

		if (key.in(9, 13, 27)) self.editing(false);

		if (key == 9) $(self.cell).next().click();
		else if (key == 27) self.value().text(self.oldValue);
		else return true;
	};
}

function chartClass(vm) {
	var self = this;
	var ready = true;
	var hChart = null;

	self.chartTitle = ko.observable('Malaria Chart');
	self.chartType = ko.observable('column');
	self.seriesType = ko.observable('row');
	self.stacking = ko.observable('no');
	self.dataLabel = ko.observable('yes');
	self.YLabel = ko.observable('Number of Cases');

	self.secondY = ko.observable();
	self.secondYList = ko.observableArray();
	self.secondYLabel = ko.observable('');
	self.secondChartType = ko.observable();

	self.secondChartTypeList = ko.pureComputed(() => {
		return self.secondY() == null ? [] : [
			{ key: 'spline', text: 'Line' },
			{ key: 'column', text: 'Column' }
		];
	});

	self.chartTitle.subscribe(value => {
		hChart.update({
			title: { text: value }
		});
	});
	self.chartType.subscribe(() => self.updateChart());
	self.seriesType.subscribe(() => self.updateChart());
	self.stacking.subscribe(() => self.updateChart());
	self.dataLabel.subscribe(value => {
		hChart.update({
			plotOptions: { series: { dataLabels: { enabled: value == 'yes' } } }
		});
	});
	self.YLabel.subscribe(value => {
		hChart.yAxis[0].update({
			title: { text: value }
		});
	});
	self.secondY.subscribe(value => {
		ready = false;
		self.secondYLabel(value);
		self.updateChart();
		ready = true;
	});
	self.secondChartType.subscribe(() => {
		if (ready) self.updateChart();
	});
	self.secondYLabel.subscribe(value => {
		if (ready && self.secondY() != null) {
			hChart.yAxis[1].update({
				title: { text: value }
			});
		}
	});

	self.updateChart = function () {
		var p = vm.pivot();
		var body = p.tableBody();
		var head = p.tableHead();
		var rows = p.rowList();
		var vals = p.valueList();

		if (vals.length == 0) return;

		var categories = [];
		var series = [];

		if (self.seriesType() == 'row') {
			if (self.chartType() != 'pie') {
				head[0].slice(rows.length).forEach(th => {
					categories.push(th.text());
				});

				body.forEach(cells => {
					series.push({
						name: body.length == 1 ? vals[0].name : cells[0],
						data: cells.slice(rows.length)
					});
				});
			} else {
				series.push({
					name: head[0][1].text(),
					data: body.map(cells => {
						return { name: cells[0], y: cells[1] };
					})
				});
			}
		} else {
			if (self.chartType() != 'pie') {
				if (rows.length > 0) {
					body.forEach(cells => {
						categories.push(cells[0]);
					});
				} else {
					categories.push(vals[0].name);
				}

				for (var i = rows.length; i < head[0].length; i++) {
					var th = head[0][i];
					series.push({
						name: th.text(),
						data: body.map(cells => cells[i])
					});
				}
			} else {
				series.push({
					name: vals[0].name,
					data: head[0].map((th, i) => {
						return { name: th.text(), y: body[0][i] };
					})
				});
			}
		}


		var arr = [];
		if (self.chartType() != 'pie' && series.length > 1) {
			if (self.chartType() == 'spline' || self.stacking() == 'no') {
				arr = series.map(r => r.name);

				//if (self.secondY() == null) {
				//	var total = [];
				//	for (var i = 0; i < series[0].data.length; i++) {
				//		total.push(series.sum(r => r.data[i]));
				//	}
				//	series.push({ name: 'All', data: total });
				//}
			}
		}
		self.secondYList(arr);

		var setting = {
			chart: { type: self.chartType() },
			title: { text: self.chartTitle() },
			xAxis: { categories: categories, crosshair: true },
			yAxis: [{ title: { text: self.YLabel() } }],
			tooltip: { shared: true },
			plotOptions: { series: { dataLabels: { enabled: self.dataLabel() == 'yes' } } },
			exporting: {
				sourceWidth: 1200, sourceHeight: 500,
				menuItemDefinitions: { downloadXLS: { onclick: function () { this.downloadXLS() } } }
			},
			series: series
		};
		var dataLabels = setting.plotOptions.series.dataLabels;

		if (self.secondY() != null) {
			setting.yAxis.push({ title: { text: self.secondYLabel() }, opposite: true, allowDecimals: false });

			var s = series.find(r => r.name == self.secondY());
			s.yAxis = 1;
			s.type = self.secondChartType();
		}

		if (self.chartType().in('column', 'bar') && self.stacking() != 'no') {
			if (self.stacking() == 'percent') {
				dataLabels.format = '{point.percentage:.0f}%';
				setting.tooltip.pointFormat = '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.percentage:.0f}%</b><br/>';
				setting.yAxis[0].labels = { format: '{value}%' };
			}
			setting.plotOptions.series.stacking = self.stacking();
		}
		else if (self.chartType() == 'pie') {
			dataLabels.format = '{point.name}: <b>{point.y} ({point.percentage:.2f}%)</b>';
			dataLabels.style = { fontWeight: 'regular', fontSize: '13px' };
		}

		$('#chartboard').highcharts(setting);
		hChart = $('#chartboard').highcharts();
	};
}

function joinFilterClass(vm) {
	var self = this;

	self.mode = ko.observable('Only');
	self.fields = [];
	self.list = [];
	self.operators = [
		{ value: '==', text: '=' },
		{ value: '!=', text: '≠' },
		{ value: '<', text: '<' },
		{ value: '>', text: '>' },
		{ value: '<=', text: '≤' },
		{ value: '>=', text: '≥' }
	];

	for (var i = 0; i < 5; i++) {
		self.list.push({ field: null, operator: null, value: '' });
	}

	if (vm.rawData.length > 0) {
		var item = vm.rawData[0];
		self.fields = Object.keys(item).map(name => name);
	}

	self.okClick = function () {
		self.list.forEach(r => r.value = r.value.trim());
		var founds = self.list.filter(item => item.field != null && item.value != '');
		if (founds.length > 0) {
			vm.pivot().joinFilterList.push({
				mode: self.mode(),
				list: founds,
				text: self.mode() + '(' + founds.map(toText).join(' AND ') + ')'
			});
			vm.pivot().refreshDisplay();
		}
	};

	function toText(item) {
		return item.field
			+ self.operators.find(r => r.value == item.operator).text
			+ item.value;
	}
}