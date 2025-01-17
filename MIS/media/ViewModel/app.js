
var app = new function () {
	var self = this;

	self.printDate = ko.observable();
	setInterval(() => self.printDate(moment().format('dddd, MMMM D, YYYY h:mm A')), 1000);

	self.showWait = function () {
		$('#modalWait').modal('show');
	};

	self.hideWait = function () {
		$('#modalWait').modal('hide');
	};

	self.showLoader = function () {
		$('#modalLoader').modal('show');
	};

	self.hideLoader = function () {
		$('#modalLoader').modal('hide');
	};

	self.showDelete = function (callback) {
		$('#modalDelete').modal('show');
		$('#modalDelete .btn-danger').off().click(function () {
			setTimeout(callback, 100);
		});
	};

	self.showRestore = function (callback) {
		$('#modalRestore').modal('show');
		$('#modalRestore .btn-danger').off().click(function () {
			setTimeout(callback, 100);
		});
	};

	self.showConfirm = function (callback) {
		$('#modalConfirm').modal('show');
		$('#modalConfirm .btn-danger').off().click(function () {
			setTimeout(callback, 100);
		});
	};

	self.showMsg = function (title, msg, error) {
		$('#modalMessage .modal-title').html(title);
		$('#modalMessage .modal-body').html(msg);
		$('#modalMessage').modal('show');
		$('#modalMessage .modal-title')[error ? 'addClass' : 'removeClass']('text-danger');
	};

	self.ko = function (data) {
		var result = ko.mapping.fromJS(data);

		if (typeof result == 'object') {
			result.extendIsEmpty = function (sample) {
				if (sample instanceof Object) {
					var sampleKeys = Object.keys(sample);
					for (var key in data) {
						if (sampleKeys.indexOf(key) > -1) {
							this[key] = this[key].extend({ isEmpty: sample[key] });
						}
					}
					return this;
				}

				for (var key in data) {
					this[key] = this[key].extend({ isEmpty: sample });
				}
				return this;
			}
		}

		return result;
	};

	self.unko = function (data) {
		return ko.mapping.toJS(data);
	};

	self.phpError = function (html) {
		$('#modalPHPError').modal('show');
		var found = $('#modalPHPError iframe').contents().find('html');
		found[0].innerHTML = html;
		found.find('body').css('margin', 0);
	};

	self.ajax = function (url, submit, showWait) {
		if (showWait !== false) self.showLoader();
		return $.ajax({
			url: url,
			method: submit === undefined ? 'GET' : 'POST',
			data: submit == null ? undefined : submit,
			dataType: 'json'
		}).fail(function (xhr) {
			if (showWait !== false) self.hideLoader();
			if (xhr.status == 0) { alert('No Internet!'); return; }
			if (xhr.status == 401) location = '/';
			else self.phpError(xhr.responseText);
		}).always(function () {
			if (showWait !== false) self.hideLoader();
		});
	};

	self.ajax2 = function (url, submit, showWait) {
		submit = submit === undefined ? undefined : JSON.stringify(submit);
		return self.ajax(url, submit, showWait);
	};

	self.calculateFileSize = function (size) {
		var unit = ['B', 'KB', 'MB', 'GB'];
		for (var i = 0; i < unit.length; i++) {
			if (size < 1000 || i == unit.length - 1) {
				return (Math.floor(size * 10) / 10) + ' ' + unit[i];
			}
			size /= 1024;
		}
	};

	self.downloadBlob = function (url, submit, showWait) {
		var process = { done: function (callback) { this.done = callback; } };
		var xhr = new XMLHttpRequest();
		xhr.open(submit == null ? 'GET' : 'POST', url, true);
		xhr.responseType = 'blob';
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('caller', 'ajax');

		if (showWait !== false && !url.contain('.js')) self.showLoader();
		xhr.onload = function () {
			self.hideLoader();
			self.hideWait();

			var blob = this.response;
			if (this.status == 200) {
				process.done(blob, this);
			} else if (this.status == 401) {
				location = '/';
			} else {
				var reader = new FileReader();
				reader.onload = function () {
					self.phpError(this.result);
				}
				reader.readAsText(blob);
			}
		};

		var lastLoaded = 0;
		var lastSecond = 0;
		xhr.onprogress = function (e) {
			if (!e.lengthComputable || url.contain('.js')) return;

			var now = new Date().getTime();
			var duration = lastSecond == 0 ? 1 : (now - lastSecond) / 1000;
			if (duration < 1) return;

			var rate = self.calculateFileSize((e.loaded - lastLoaded) / duration);
			var speed = `Speed: ${rate}/s`;
			lastLoaded = e.loaded;
			lastSecond = now;

			var loaded = self.calculateFileSize(e.loaded);
			var total = self.calculateFileSize(e.total);
			var percent = (Math.floor(e.loaded * 10000 / e.total) / 100).toFixed(2);
			var download = `Downloaded: ${loaded} / ${total} (${percent}%)`;

			$('#modalWait .modal-footer .pull-left').text(speed);
			$('#modalWait .modal-footer .pull-right').text(download);

			self.hideLoader();
			self.showWait();
		};

		xhr.send(submit == null ? undefined : $.param(submit));
		return process;
	};

	self.readFileInZip = function (zipfileUrl, filenameInZip, callback, showWait) {
		self.downloadBlob(zipfileUrl, undefined, showWait).done(function (blob) {
			if (showWait !== false) self.showLoader();
			new JSZip().loadAsync(blob).then(function (zip) {
				if (typeof filenameInZip === 'string') {
					zip.file(filenameInZip).async('string').then(function (rs) {
						self.hideLoader();
						callback(rs);
					});
				} else if (typeof filenameInZip === 'function') {
					callback = filenameInZip;
					var arr = Object.keys(zip.files).map(name => {
						return { fileName: name, value: null };
					});
					zip.forEach(name => {
						zip.file(name).async('string').then(function (rs) {
							arr.find(r => r.fileName == name).value = rs;
							if (arr.every(r => r.value != null)) {
								self.hideLoader();
								callback(arr);
							}
						});
					});
				}
			});
		});
	};

	self.base64toBlob = function (base64Data, contentType) {
		contentType = contentType || '';
		var sliceSize = 1024;
		var byteCharacters = atob(base64Data);
		var bytesLength = byteCharacters.length;
		var slicesCount = Math.ceil(bytesLength / sliceSize);
		var byteArrays = new Array(slicesCount);

		for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
			var begin = sliceIndex * sliceSize;
			var end = Math.min(begin + sliceSize, bytesLength);

			var bytes = new Array(end - begin);
			for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
				bytes[i] = byteCharacters[offset].charCodeAt(0);
			}
			byteArrays[sliceIndex] = new Uint8Array(bytes);
		}
		return new Blob(byteArrays, { type: contentType });
	};

	self.setNumberOnly = function (element, dataType, minus) {
		if ($(element).data('mis_numberonly') === true) return;
		$(element).data('mis_numberonly', true);

		$(element).keydown(function (e) {
			var allow = [];
			if (dataType == 'float') allow.push('.'); // Allow: .
			if (minus) allow.push('-'); // Allow: -

			if ([8, 46, 9, 27, 13].indexOf(e.keyCode) > -1 || // Allow: backspace, delete, tab, escape, enter
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: Ctrl+A, Command+A
				(e.keyCode === 67 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: Ctrl+C, Command+C
				(e.keyCode === 86 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: Ctrl+V, Command+V
				(e.keyCode === 88 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: Ctrl+X, Command+X
				(e.keyCode >= 35 && e.keyCode <= 40) || // Allow: home, end, left, right, down, up
				(allow.indexOf(e.key) > -1)) {
				if ((e.key == '.' && this.value.indexOf('.') > -1) ||
					(e.key == '-' && (this.value.indexOf('-') > -1 || this.selectionStart > 0))) {
					e.preventDefault();
				}
			} else if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});

		$(element).keyup(function () {
			var v = $(this).val();
			var rs = "";
			for (var i = 0; i < v.length; i++) {
				var allow = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
				if (dataType == 'float') allow.push('.');
				if (minus) allow.push('-');
				if (allow.indexOf(v[i]) > -1) rs += v[i];
			}
			if (v != rs) $(this).val(rs);
		});
	};

	var lstWarnDestroyFn = [];
	self.showWarning = function (idOrElement, msg, SecondWarning) {
		var el = typeof idOrElement == 'string' ? $('#' + idOrElement) : $(idOrElement);
		el.data('firstWarnValue', (el.hasClass('dropdown') ? el.find('.dropdown-toggle span:first').text() : el.val()).toLowerCase());

		if (SecondWarning === false) {
			el.get(0).scrollIntoView();
			window.scrollTo(window.scrollX, window.scrollY - 80);
		}

		function addError() {
			if (el.closest('.form-group, td').hasClass('has-error')) return;
			remove();
			el.closest('.form-group, td').addClass('has-error');
			if (msg !== undefined) {
				var ig = el.parent().hasClass('input-group');
				(ig ? el.parent() : el).after('<span class="help-block">' + msg + '</span>');
			}
		}

		function addSuccess() {
			if (el.closest('.form-group, td').hasClass('has-success')) return;
			remove();
			el.closest('.form-group, td').addClass('has-success');
			if (msg !== undefined) {
				(el.parent().hasClass('input-group') ? el.parent() : el).after('<span class="help-block">OK</span>');
			}
		}

		function remove() {
			el.closest('.form-group, td').removeClass('has-error has-success');
			if (msg !== undefined) {
				(el.parent().hasClass('input-group') ? el.parent() : el).next('.help-block').remove();
			}
		}

		function checkValue() {
			var val = el.hasClass('dropdown') ? el.find('.dropdown-toggle span:first').text() : el.val();
			val.toLowerCase() == el.data('firstWarnValue') ? addError()
				: val == '' ? remove()
					: addSuccess();
		}

		function destroy() {
			el.hasClass('dropdown') ? el.find('.dropdown-toggle span:first').off('DOMSubtreeModified', checkValue)
				: el.prop('tagName') == 'SELECT' ? el.off('change', checkValue)
					: el.off('keyup', checkValue);
			remove();
			el.data('hasWarnEvent', false);
			el[0].destroyWarning = function () { };
		}

		addError();

		if (el.data('hasWarnEvent') === true) return;
		el.data('hasWarnEvent', true);

		el.hasClass('dropdown') ? el.find('.dropdown-toggle span:first').on('DOMSubtreeModified', checkValue)
			: el.prop('tagName') == 'SELECT' ? el.change(checkValue)
				: el.keyup(checkValue);

		lstWarnDestroyFn.push(destroy);
		el[0].destroyWarning = destroy;
	};

	self.removeAllWarning = function () {
		lstWarnDestroyFn.forEach(function (fn) { fn(); });
		lstWarnDestroyFn = [];
	};

	self.selectTr = function (model, event) {
		var old = $(event.currentTarget).closest('tbody').find('tr.selected');
		old.removeClass('selected');
		$(event.currentTarget).addClass('selected');
		return true;
	};

	self.tableFooter = function (el) {
		var count = $(el).closest('table').find('th').length;
		$(el).find('td').attr('colspan', count);

		el = $(el).prev()[0];
		var rows = ko.bindingProvider.instance.getBindings(el, ko.contextFor(el)).foreach;
		return ko.unwrap(rows).length == 0;
	};

	self.getPlace = function (request, callback, showWait) {
		var submit = { request: [] };
		var localPU = localStorage.placeUpdate === undefined ? {} : JSON.parse(localStorage.placeUpdate);

		request.forEach(r => {
			if (localStorage[r] === undefined || localPU[r] === undefined || localPU[r] < app.placeUpdate[r]) {
				submit.request.push(r);
			}
		});

		function prepare(rs) {
			if (rs == null) rs = {};
            
			request.forEach(r => {
				if (rs[r] === undefined) rs[r] = JSON.parse(localStorage[r]);
				else {
					localStorage[r] = JSON.stringify(rs[r]);
					localPU[r] = app.placeUpdate[r];
				}
			});
			localStorage.placeUpdate = JSON.stringify(localPU);
			callback(rs);
		}

		if (submit.request.length > 0) {
			self.ajax('/Home/getPlace', submit, showWait).done(prepare);
		} else {
			setTimeout(prepare);
		}
	};

	self.newRowLimit = function (limit) {
		var obj = ko.observable(limit);
		obj.increase = () => obj(obj() + limit);
		obj.reset = () => obj(limit);
		obj.scrolling = false;
		return obj;
	};

	self.rowLimit = function (limit, vm, key) {
		var row = ko.observable(limit);
		var increase = () => row(row() + limit);
		var reset = () => row(limit);
		var increasing = false;
		var listModel = vm[key];

		vm[key] = ko.pureComputed(() => {
			if (!increasing) reset();
			return listModel().slice(0, row());
		});

		$(window).scroll(function () {
			if (innerHeight + scrollY + 1000 < document.body.scrollHeight) return;
			if (row() > listModel().length) return;

			increasing = true;
			increase();
			increasing = false;
		});
	};

	self.uniqueNumber = function () {
		return Date.now() + Math.random().toFixed(7).substr(2);
	};

	self.createGoogleMap = function (elementId, options, returnObj) {
		options.center = { lat: 12.5, lng: 105 };
		options.mapTypeId = 'terrain';
		options.streetViewControl = false;
		options.fullscreenControl = false;
		options.styles = [{ featureType: 'all', elementType: 'labels', stylers: [{ visibility: 'off' }] }];

		returnObj = returnObj || {};

		var map = new google.maps.Map(document.getElementById(elementId), options);
		var polygonBorders = [];
		var polygonLabels = [];

		googleODBorder.forEach(od => {
			var odObj = { name: od.name, polygons: [] };
			od.coor.forEach(a => {
				a.forEach(b => {
					var polygon = [];
					b.forEach(r => {
						var coor = { lat: r[0], lng: r[1] };
						polygon.push(coor);
						odObj.polygons.push(coor);
					});
					polygonBorders.push(polygon);
				});
			});
			polygonLabels.push(odObj);
		});

		var polygon = new google.maps.Polygon({
			paths: polygonBorders,
			strokeColor: '#2980b9',
			strokeWeight: 1,
			fillOpacity: 0,
			map: map
		});
		returnObj.polygon = polygon;

		var adjust = {
			'Kralanh': [-0.05, -0.05],
			'Angkor Chhum': [0.17, 0],
			'Siem Reap': [0, -0.15],
			'Banlung': [0, -0.15],
			'Kampong Chhnang': [-0.08, 0],
			'Boribo': [0, 0.05],
			'Oudong': [-0.06, 0],
			'Kampong Speu': [-0.07, 0],
			'Kravanh': [0.07, 0],
			'Ang Rokar': [0, 0.05],
			'Kep Ville': [0.03, 0],
			'Kirivong': [-0.06, 0],
			'Smach Meanchey': [0, 0.1],
			'Sre Ambel': [0.3, -0.1],
			'Sihanouk Ville': [-0.25, 0],
			'Bakan': [0, 0.07],
			'Chhlong': [0.05, 0],
			'Baray and Santuk': [0.1, 0],
			'Stueng Trang': [0.05, 0],
			'Suong': [0.05, 0],
			'Tbong Khmum': [-0.02, -0.07],
			'Thmor Koul': [0.1, -0.05]
		};

		polygonLabels.forEach(r => {
			var bounds = new google.maps.LatLngBounds();
			r.polygons.forEach(coor => bounds.extend(coor));

			var pos = bounds.getCenter();
			var aj = adjust[r.name];
			if (aj != null) pos = new google.maps.LatLng(pos.lat() + aj[0], pos.lng() + aj[1]);

			new MapLabel({ text: r.name, position: pos, map: map, strokeWeight: 0 });
		});

		if (app.user.role != 'AU') {
			new google.maps.Marker({
				position: map.getCenter(),
				icon: {
					url: '/media/images/background-blur.png',
					anchor: { x: 100, y: 150 }
				},
				map: map
			});
		}

		return map;
	};

	self.writeExcel = function (data, filename) {
		var wb = XLSX.utils.book_new();
		XLSX.utils.book_append_sheet(wb, XLSX.utils.json_to_sheet(data));
		XLSX.writeFileXLSX(wb, filename + '.xlsx', { compression: true });
	};
}();