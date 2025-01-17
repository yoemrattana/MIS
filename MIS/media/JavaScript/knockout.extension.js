ko.bindingHandlers.fixedHeader = {
	init: function (element, valueAccessor, allBindings, viewModel) {
		var fixedHeaderValue = ko.unwrap(valueAccessor());
		if (fixedHeaderValue === false) return;

		var listModel = allBindings().sortModel || allBindings().foreach || [];
		var fixedTop = allBindings().fixedTop || 0;
		var fixedLeft = allBindings().fixedLeft || 0;

		var table = $(element).closest('table');
		table.addClass('fixed-header');
		table.find('thead th, thead td').each(function (colIndex) {
			var direction = this.getAttribute('sortable');
			if (direction == null) return;
			$(this).click(function () {
				sortTable(colIndex, direction);
			});
		});

		var divFh = document.createElement('div');
		divFh.className = 'hidden-print fixed-header';
		divFh.style.display = 'none';
		divFh.style.top = fixedTop == 0 ? null : fixedTop + 'px';
		table.after(divFh);

		var fh = document.createElement('table');
		$.each(table[0].attributes, function () {
			if (this.name == 'data-bind') return;
			fh.setAttribute(this.name, this.value);
		});
		fh.style.display = '';
		fh.style.visibility = '';
		fh.style.width = '';
		fh.style.maxWidth = '';
		fh.style.minWidth = '';
		divFh.appendChild(fh);

		var divFc = null;
		var divFhc = null;
		if (allBindings().fixedColumn !== undefined) { //using: (fixedColumn: 1 or 2)
			divFc = document.createElement('div');
			divFc.className = 'hidden-print fixed-column';
			divFc.style.display = 'none';
			divFc.style.left = fixedLeft == 0 ? null : fixedLeft + 'px';
			divFh.after(divFc);

			divFhc = document.createElement('div');
			divFhc.className = 'hidden-print fixed-header-column';
			divFhc.style.display = 'none';
			divFhc.style.left = fixedLeft == 0 ? null : fixedLeft + 'px';
			divFc.after(divFhc);

			var fc = document.createElement('table');
			var fhc = document.createElement('table');
			$.each(table[0].attributes, function () {
				if (this.name == 'data-bind') return;
				fc.setAttribute(this.name, this.value);
				fhc.setAttribute(this.name, this.value);
			});

			fc.style.display = '';
			fc.style.visibility = '';
			fc.style.width = '';
			fc.style.maxWidth = '';
			fc.style.minWidth = '';
			divFc.appendChild(fc);

			fhc.style.display = '';
			fhc.style.visibility = '';
			fhc.style.width = '';
			fhc.style.maxWidth = '';
			fhc.style.minWidth = '';
			divFhc.appendChild(fhc);

			if (typeof allBindings().fixedColumn == 'number') {
				var cells = table.find('thead tr:first').find('th,td').slice(0, allBindings().fixedColumn);
				[fc, fhc].forEach(function (obj) {
					var thead = obj.createTHead();
					var newRow = thead.insertRow();
					$.each(table.find('thead')[0].attributes, function () {
						thead.setAttribute(this.name, this.value);
					});
					cells.each(function (colIndex) {
						var newCell = $(this).clone().removeAttr('rowspan data-bind');
						$(newRow).append(newCell);

						var direction = newCell.attr('sortable');
						if (direction == null) return;
						newCell.click(function () {
							sortTable(colIndex, direction);
						});
					});
				});
			} else if (allBindings().fixedColumn == 'manual') {
				var len = table.find('thead [fc]').length;
				[fc, fhc].forEach(function (obj) {
					var thead = obj.createTHead();
					var newRow = null;
					for (var i = 1; i <= len; i++) {
						var found = table.find('thead [fc=' + i + ']');
						if (found[0].tagName == 'TR') {
							newRow = thead.insertRow();
							$(newRow).attr('class', found.attr('class'));
							$(newRow).attr('style', found.attr('style'));
						}
						else $(newRow).append(found.clone().removeAttr('data-bind'));
					}
				});
			}

			function createFcBody() {
				var tbody = fc.createTBody();
				table.find('tbody tr').toArray().forEach(function (row) {
					var newRow = tbody.insertRow();
					$(newRow).attr('class', $(row).attr('class'));
					$(newRow).attr('style', $(row).attr('style'));

					var fc = allBindings().fixedColumn;
					var cells = typeof fc == 'number' ? $(row).find('th,td').slice(0, fc) : $(row).find('[fc]');
				
					cells.each(function () {
						$(newRow).append($(this).clone());
					});
				});
			}
			createFcBody();

			if (allBindings().fixedColumn == 'manual') {
				var len = table.find('tfoot [fc]').length;
				if (len > 0) {
					var tfoot = fc.createTFoot();
					var newRow = null;
					for (var i = 1; i <= len; i++) {
						var found = table.find('tfoot [fc=' + i + ']');
						if (found[0].tagName == 'TR') {
							newRow = tfoot.insertRow();
							$(newRow).attr('class', found.attr('class'));
							$(newRow).attr('style', found.attr('style'));
						}
						else $(newRow).append(found.clone().removeAttr('data-bind'));
					}
				}
			}
		}

		function sortTable(colIndex, direction, firstSort) {
			function sortMethod(a, b) {
				var rs = 0;
				if (!isNaN(a) && !isNaN(b)) {
					rs = parseFloat(a || 0) - parseFloat(b || 0);
				} else {
					rs = (a || '').toLowerCase().localeCompare((b || '').toLowerCase());
				}
				return direction === 'desc' ? rs * -1 : rs;
			}

			function checkAndReverse(before, after) {
				if (firstSort === true) return;
				var sorted = true;
				var after2 = ko.unwrap(after);
				for (var i = 0; i < before.length; i++) {
					if (before[i] === after2[i]) continue;
					sorted = false;
					break;
				}
				if (sorted) after.reverse();
			}

			if (ko.isObservable(listModel)) {
				var cells = table.find('tbody tr:first td');
				if (cells.length == 0) return;

				var node = cells[colIndex];
				var context = ko.contextFor(element);
				var before = listModel.slice(0);
				listModel.fh.isSorting = true;
				listModel.sort(function (a, b) {
					var x = ko.bindingProvider.instance.getBindings(node, context.createChildContext(a));
					var y = ko.bindingProvider.instance.getBindings(node, context.createChildContext(b));

					x = x.sortValue !== undefined ? x.sortValue
						: ko.unwrap(x.text) !== undefined ? ko.unwrap(x.text)
						: '';

					y = y.sortValue !== undefined ? y.sortValue
						: ko.unwrap(y.text) !== undefined ? ko.unwrap(y.text)
						: '';

					return sortMethod(x, y);
				});
				checkAndReverse(before, listModel);
				listModel.fh.isSorting = false;
			} else {
				var before = table.find('tbody tr').toArray();
				var rows = before.slice(0).sort(function (a, b) {
					var x = $(a.cells[colIndex]).text();
					var y = $(b.cells[colIndex]).text();
					return sortMethod(x, y);
				});
				checkAndReverse(before, rows);

				var tbody = table.find('tbody')[0];
				var firstRow = table.find('tbody tr')[0];
				var firstCol = table.find('thead th, thead td').first().text();
				for (var i = rows.length - 1; i >= 0; i--) {
					tbody.insertBefore(rows[i], firstRow);
					firstRow = rows[i];
					if (firstCol == '#') firstRow.cells[0].innerHTML = i + 1;
				}
			}

			if (divFc != null) {
				$(fc).find('tbody').remove();
				createFcBody();
			}
		}

		function copyFH() {
			var template = allBindings().theadTemplate;

			if (template === undefined) {
				fh.innerHTML = table.find('thead')[0].outerHTML;

				$(fh).find('thead th, thead td').each(function (colIndex) {
					var direction = this.getAttribute('sortable');
					if (direction == null) return;
					$(this).click(function () {
						sortTable(colIndex, direction);
					});
				});
			} else if(document.getElementById(template) != null) {
				fh.innerHTML = "<!--ko template:{name:'" + template + "'}--><!--/ko-->";
				ko.cleanNode(fh);
				ko.applyBindings(viewModel, fh);
			}
		}
		setTimeout(copyFH);

		var scrollContainer = $(window);
		if (allBindings().scrollContainer !== undefined) {
			scrollContainer = $(allBindings().scrollContainer);
		}
		var firstRefresh = true;

		function refreshFH() {
			if (!document.body.contains(divFh)) {
				scrollContainer.off('scroll', refreshFH);
				$(window).off('resize', refreshFH);
				return;
			}

			var isWindow = scrollContainer[0] === window;
			var tableTop = (isWindow ? table.offset().top : table.position().top) - fixedTop;
			var tableWidth = table[0].offsetWidth;
			var shouldShowFh = tableWidth > 0 && table.css('visibility') == 'visible';

			if (shouldShowFh) {
				if (isWindow) {
					var tableBottom = tableTop + table.height() - $(divFh).height();
					shouldShowFh = scrollContainer.scrollTop() > tableTop && scrollContainer.scrollTop() < tableBottom;
				} else {
					shouldShowFh = tableTop < 0;
				}
			}

			if (shouldShowFh) {
				$(divFh).show();

				var left = table.position().left;
				if (isWindow) left = table.offset().left - scrollContainer.scrollLeft();
				$(divFh).css('left', left + 'px');

				if (firstRefresh == true || tableWidth != fh.offsetWidth) {
					table.find('thead tr').each(function (rowIndex) {
						$(this).find('th,td').each(function (colIndex) {
							var col = $(fh).find('tr').eq(rowIndex).find('th,td').eq(colIndex);
							var w = $(this).outerWidth();
							if (w > 0) col.css({ 'min-width': w, 'max-width': w }).removeAttr('width');
						});
					});

					firstRefresh = false;
				}
			} else {
				$(divFh).hide();
			}

			if (divFc != null) {
				var tableLeft = (isWindow ? table.offset().left : table.position().left) - fixedLeft;
				var tableHeight = table[0].offsetHeight;
				var shouldShowFc = tableHeight > 0 && table.css('visibility') == 'visible';

				if (shouldShowFc) {
					if (isWindow) {
						var tableRight = tableLeft + table.width() - $(divFc).width();
						shouldShowFc = scrollContainer.scrollLeft() > tableLeft && scrollContainer.scrollLeft() < tableRight;
					} else {
						shouldShowFc = tableLeft < 0;
					}
				}

				if (shouldShowFc) {
					$(divFc).show();

					var top = table.position().top;
					if (isWindow) top = table.offset().top - scrollContainer.scrollTop();
					$(divFc).css('top', top + 'px');

					if (table.find('thead').height() != $(fc).find('thead').height()) {
						if (typeof allBindings().fixedColumn == 'number') {
							var cells = table.find('thead tr:first').find('th,td').slice(0, allBindings().fixedColumn);
							[fc, fhc].forEach(function (obj) {
								cells.each(function (i) {
									$(obj).find('thead th, thead td').eq(i).css({
										'min-width': $(this).outerWidth(),
										'max-width': $(this).outerWidth(),
										'height': $(this).outerHeight()
									});
								});
							});
						} else if (allBindings().fixedColumn == 'manual') {
							[fc, fhc].forEach(function (obj) {
								$(obj).find('thead th[fc], thead td[fc]').each(function () {
									var cell = table.find('thead [fc=' + $(this).attr('fc') + ']');
									$(this).css({
										'min-width': cell.outerWidth(),
										'max-width': cell.outerWidth(),
										'height': cell.outerHeight()
									});
								});
							});
						}
					}

					if (table.find('tbody').height() != $(fc).find('tbody').height()) {
						table.find('tbody tr').each(function (i) {
							$(fc).find('tbody tr').eq(i).css({
								height: $(this).outerHeight()
							});
						});
					}
				} else {
					$(divFc).hide();
				}

				if (shouldShowFh && shouldShowFc) {
					$(divFhc).show();
				} else {
					$(divFhc).hide();
				}
			}
		}

		scrollContainer.scroll(refreshFH);
		$(window).resize(refreshFH);

		if (ko.isObservable(listModel) && listModel.fh === undefined) {
			listModel.fh = { isSorting: false };
			listModel.subscribe(function () {
				if (listModel.fh.isSorting) return;

				copyFH();
				if (divFc != null) {
					$(fc).find('tbody').remove();
					createFcBody();
				}
				refreshFH();

				// for default sort (fixedHeader: [0,1,2])
				if (Array.isArray(fixedHeaderValue)) {
					fixedHeaderValue.reverse().forEach(function (i) {
						sortTable(i, null, true);
					});
				} else if (typeof fixedHeaderValue == 'number') {
					sortTable(fixedHeaderValue, null, true);
				}
			});
		}
	}
};

ko.bindingHandlers.datePicker = {
	init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
		if (valueAccessor() != null) valueAccessor().element = element;

		//initialize datepicker with some optional options
		var allBindings = allBindings();
		var options = {
			format: allBindings.format || 'DD-MM-YYYY',
			showClear: allBindings.showClear || false,
			minDate: ko.unwrap(allBindings.minDate),
			maxDate: ko.unwrap(allBindings.maxDate),
			defaultDate: ko.unwrap(allBindings.defaultDate),
			useCurrent: false
		};
		if (!options.showClear) options.keyBinds = { 'delete': null };
		if (allBindings.allowKeyboard !== true) {
			$(element).keydown(function (event) { event.preventDefault(); });
		}
		$(element).datetimepicker(options);

		if (ko.isObservable(allBindings.minDate)) {
			allBindings.minDate.subscribe(function (value) {
				var picker = $(element).data("DateTimePicker");
				if (picker.viewDate().sqlformat() < value.sqlformat()) picker.date(value);
				picker.minDate(value);
			});
		}

		//when a user changes the date, update the view model
		ko.utils.registerEventHandler(element, "dp.change", function (event) {
			var value = valueAccessor();
			if (ko.isObservable(value)) {
				if (event.date instanceof moment) {
					if (allBindings.dataType == 'string') {
						value(event.date.format('YYYY-MM-DD'));
					} else {
						value(event.date);
						event.date.toJSON = function () {
							return this.format('YYYY-MM-DD');
						};
					}
				} else { //check if user click clear
					allBindings.dataType == 'string' ? value('') : value(null);
				}
			} else {
				var result = event.date instanceof moment ? event.date.format('YYYY-MM-DD') : '';
				var keyValueArray = ko.expressionRewriting.parseObjectLiteral(element.getAttribute('data-bind'));
				var propertyName = keyValueArray.find(function (obj) {
					return obj.key == 'datePicker';
				}).value;

				if (propertyName.indexOf('$') > -1) {
					var functionBody = "with(context){" + propertyName + "='" + result + "'}";
					var writeFunction = new Function('context', '$element', functionBody);
					writeFunction(bindingContext, element);
				} else {
					viewModel[propertyName] = result;
				}
			}

			$(element).keyup(); //to make showWarning work when value change

			if (event.date instanceof moment == false) {
				$(element).data("DateTimePicker").hide(); //hide after user click clear
			}
		});

		ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
			$(element).data("DateTimePicker").destroy();
		});
	},
	update: function (element, valueAccessor) {
		//when the view model is updated, update the widget
		var picker = $(element).data("DateTimePicker");
		var value = ko.unwrap(valueAccessor());

		if (value === '' || value === undefined) value = null;
		else if (typeof value == 'string') value = moment(value);

		picker.date(value);
	}
};

ko.bindingHandlers.dateTimePicker = {
	init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
		if (valueAccessor() != null) valueAccessor().element = element;

		//initialize datepicker with some optional options
		var allBindings = allBindings();
		var options = {
			format: allBindings.format || 'DD-MM-YYYY HH:mm',
			showClear: allBindings.showClear || false,
			minDate: allBindings.minDate,
			maxDate: allBindings.maxDate,
			defaultDate: allBindings.defaultDate,
			useCurrent: false
		};
		if (!options.showClear) options.keyBinds = { 'delete': null };
		if (allBindings.allowKeyboard !== true) {
			$(element).keydown(function (event) { event.preventDefault(); });
		}
		$(element).datetimepicker(options);

		//when a user changes the date, update the view model
		ko.utils.registerEventHandler(element, "dp.change", function (event) {
			var value = valueAccessor();
			if (ko.isObservable(value)) {
				if (event.date instanceof moment) {
					if (allBindings.dataType == 'string') {
						value(event.date.format('YYYY-MM-DD HH:mm:00'));
					} else {
						value(event.date);
						event.date.toJSON = function () {
							return this.format('YYYY-MM-DD HH:mm:00');
						};
					}
				} else { //check if user click clear
					allBindings.dataType == 'string' ? value('') : value(null);
				}
			} else {
				var result = event.date instanceof moment ? event.date.format('YYYY-MM-DD HH:mm:00') : '';
				var keyValueArray = ko.expressionRewriting.parseObjectLiteral(element.getAttribute('data-bind'));
				var propertyName = keyValueArray.find(function (obj) {
					return obj.key == 'dateTimePicker';
				}).value;

				if (propertyName.indexOf('$') > -1) {
					var functionBody = "with(context){" + propertyName + "='" + result + "'}";
					var writeFunction = new Function('context', functionBody);
					writeFunction(bindingContext);
				} else {
					viewModel[propertyName] = result;
				}
			}

			$(element).keyup(); //to make showWarning work when value change

			if (event.date instanceof moment == false) {
				$(element).data("DateTimePicker").hide(); //hide after user click clear
			}
		});

		ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
			$(element).data("DateTimePicker").destroy();
		});
	},
	update: function (element, valueAccessor) {
		//when the view model is updated, update the widget
		var picker = $(element).data("DateTimePicker");
		var value = ko.unwrap(valueAccessor());

		if (value === '') value = null;
		else if (typeof value == 'string') value = moment(value);

		picker.date(value);
	}
};

ko.bindingHandlers.dataTable = {
	page: 0,
	init: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
		if (valueAccessor().changePage !== undefined) { // changePage is from view model village 
			valueAccessor().subscribe(function () {
				var table = $(element).closest('table').DataTable();
				ko.bindingHandlers.dataTable.page = table.page();
			});
		}

		var nodes = Array.prototype.slice.call(element.childNodes, 0);
		ko.utils.arrayForEach(nodes, function (node) {
			if (node && node.nodeType !== 1) {
				node.parentNode.removeChild(node);
			}
		});

		ko.bindingHandlers.foreach.init(element, valueAccessor, allBindings, viewModel, bindingContext);
	},
	update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {
		var dtOptions = allBindings().dtOptions;
		if (dtOptions === undefined) dtOptions = {};
		dtOptions.searching = false;
		dtOptions.columnDefs = [{ orderable: false, targets: 'no-sort' }];
		dtOptions.pageLength = 200;
		dtOptions.bLengthChange = false;
		if (dtOptions.fixedHeader === undefined) dtOptions.fixedHeader = true;
		if (dtOptions.paging === undefined) dtOptions.paging = false;
		if (dtOptions.rowReorder === true) dtOptions.rowReorder = { snapX: 20, selector: 'td.selector' };
		// for use outside: ordering, bInfo

		$(element).closest('table').DataTable().destroy();
		ko.bindingHandlers.foreach.update(element, valueAccessor, allBindings, viewModel, bindingContext);
		var table = $(element).closest('table').DataTable(dtOptions);

		var found = $(element).closest('table').find('thead th:first');
		if (found.hasClass('no-sort') || dtOptions.ordering === false) found.removeClass('sorting_asc');
		if (dtOptions.rowReorder !== undefined && dtOptions.rowReorder !== false) {
			found.css('width', '');
			found.off();
		}

		var value = valueAccessor();
		var listModel = ko.unwrap(value);
		if (listModel.length == 0) return;

		if (found.text() == '#') {
			table.on('preDraw.dt', function () {
				table.column(0).nodes().each(function (cell, i) {
					cell.innerHTML = i + 1;
				});
			}).draw('page');
		}
		if (dtOptions.rowReorder !== undefined && dtOptions.rowReorder !== false) {
			table.on('row-reorder', function (e, details, edit) {
				var callback = allBindings().onReorder;
				if (details.length == 0 || callback === undefined) return;
				callback(details.map(function (r) {
					return {
						node: r.node, position: parseInt(r.newData)
					};
				}));
			});
		}
		if (value.changePage === true) { // changePage is from view model village
			value.changePage = false;
			table.page(ko.bindingHandlers.dataTable.page).draw(false);
		}
	}
};

ko.observable.fn.trim = ko.computed.fn.trim = function () {
	var value = this();
	if (typeof value === 'string') {
		value = value.trim();
		this(value);
		this.notifySubscribers(value);
	}
	return value;
};

ko.extenders.isEmpty = function (target, defaultValue) {
	return ko.pureComputed({
		read: target,
		write: function (newValue) {
			target(newValue === '' ? defaultValue : newValue);
		}
	});
};


/*************************
* Object Tracking change *
**************************/
ko['track'] = function (model) {
	for (var key in model) {
		if (model.hasOwnProperty(key) && ko.isObservable(model[key])) {
			model[key].extend({ trackChange: true });
		}
	}
};

ko['acceptChanges'] = function (model) {
	for (var key in model) {
		if (model.hasOwnProperty(key) && ko.isObservable(model[key]) && typeof model[key].isDirty === 'function') {
			model[key].isDirty(false);
			model[key].originalValue = model[key]();
		}
	}
};

ko['isDirty'] = function (model) {
	for (key in model) {
		if (model.hasOwnProperty(key) && ko.isObservable(model[key]) && typeof model[key].isDirty === 'function' && model[key].isDirty()) {
			return true;
		}
	}
	return false;
};

ko.extenders.trackChange = function (target, track) {
	if (track) {
		target.isDirty = ko.observable(false);
		target.originalValue = target();
		target.subscribe(function (newValue) {
			target.isDirty(newValue != target.originalValue);
		});
	}
	return target;
};

/*
* To get booth old and new value
*/
ko.subscribable.fn.subscribeChanged = function (callback) {
	var oldValue;
	this.subscribe(function (_oldValue) {
		oldValue = _oldValue;
	}, this, 'beforeChange');

	this.subscribe(function (newValue) {
		callback(newValue, oldValue);
	});
};

/*
 * Select 2
 * */

ko.bindingHandlers.select2 = {
	after: ["options", "value"],
	init: function (el, valueAccessor, allBindingsAccessor, viewModel) {
		$(el).select2(ko.unwrap(valueAccessor()));
		ko.utils.domNodeDisposal.addDisposeCallback(el, function () {
			$(el).select2('destroy');
		});
	},
	update: function (el, valueAccessor, allBindingsAccessor, viewModel) {
		var allBindings = allBindingsAccessor();
		var select2 = $(el).data("select2");
		if ("value" in allBindings) {
			var newValue = "" + ko.unwrap(allBindings.value);
			if ((allBindings.select2.multiple || el.multiple) && newValue.constructor !== Array) {
				select2.val([newValue.split(",")]);
			}
			else {
				select2.val([newValue]);
			}
		}
	}
};