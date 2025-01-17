navigator.serviceWorker.register('sw.js');
$(() => ko.applyBindings(app));

var app = new function () {
	var self = this;
	var place = null;

	self.usr = ko.observable();
	self.pwd = ko.observable();
	self.incorrect = ko.observable(false);
	self.logging = ko.observable(false);
	self.logged = ko.observable(localStorage.myusr != null);

	self.pvList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.vl = ko.observable();
	self.detail = ko.observable();
	self.loaded = ko.observable(false);
	self.view = ko.observable('list');
	self.newUpdate = ko.observable(false);

	self.hcCase = ko.observable();
	self.hcStock = ko.observable();
	self.vlCase = ko.observable();

	if (localStorage.myplace == null) {
		getPlace();
	} else {
		place = JSON.parse(localStorage.myplace);
		self.pvList(place.pv);
		self.loaded(true);
		checkUpdate();
	}

	function getPlace() {
		ajax('/pwa/getplace').done(function (rs) {
			rs.pt = ['pv', 'od', 'hc', 'vl'].reduce((a, b) => {
				a[b] = rs.pt[b];
				return a;
			}, {});

			localStorage.myplace = JSON.stringify(rs.p);
			localStorage.myplacetime = JSON.stringify(rs.pt);
			place = rs.p;
			self.pvList(place.pv);
			self.loaded(true);
			self.newUpdate(false);
		});
	}

	function checkUpdate() {
		var submit = localStorage.myplacetime == null ? { pv: 0, od: 0, hc: 0, vl: 0 } : JSON.parse(localStorage.myplacetime);
		ajax('/pwa/checkUpdate', submit).done(function (rs) {
			self.newUpdate(rs == 1);
		});
	}

	self.odList = ko.pureComputed(function () {
		return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
	});

	self.hcList = ko.pureComputed(function () {
		return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
	});

	self.vlList = ko.pureComputed(function () {
		return self.hc() == null ? [] : place.vl.filter(r => r.hccode == self.hc());
	});

	self.login = function () {
		self.incorrect(false);
		self.logging(true);

		var submit = {
			usr: self.usr(),
			pwd: self.pwd()
		};
		ajax('/login/pwa', submit).done(function (rs) {
			self.logging(false);

			if (rs == 'incorrect') self.incorrect(true);
			else {
				localStorage.myusr = self.usr();
				self.logged(true);
			}
		});
	};

	self.showDetail = function () {
		if (self.hc() == null) return;

		self.detail({
			hc: place.hc.find(r => r.code == self.hc()),
			vl: place.vl.find(r => r.code == self.vl())
		});

		self.view('detail');

		self.hcCase(null);
		self.hcStock(null);
		self.vlCase(null);

		var submit = {
			hc: self.hc(),
			vl: self.vl()
		};
		ajax('/pwa/checkEntry', submit).done(function (rs) {
			self.hcCase({
				ExpireEntry: (rs.hc || {}).ExpireEntry,
				type: 'hc'
			});
			self.hcStock({
				ExpireStock: (rs.hc || {}).ExpireStock,
				type: 'hc'
			});

			self.vlCase({
				ExpireEntry: (rs.vl || {}).ExpireEntry,
				type: 'vl'
			});
		});
	};

	self.checkboxClick = function (model) {
		if (model.type == 'hc') {
			if (model.ExpireEntry != null) {
				self.hcCase(null);

				var submit = {
					table: 'tblHFDevice',
					value: { ExpireEntry: model.ExpireEntry },
					where: { Code_Facility_T: self.hc() }
				};
				submit = { submit: JSON.stringify(submit) };
				ajax('/Direct/update', submit).done(function () {
					self.hcCase(model);
				});
			} else {
				self.hcStock(null);

				var submit = {
					table: 'tblHFDevice',
					value: { ExpireStock: model.ExpireStock },
					where: { Code_Facility_T: self.hc() }
				};
				submit = { submit: JSON.stringify(submit) };
				ajax('/Direct/update', submit).done(function () {
					self.hcStock(model);
				});
			}
		} else {
			self.vlCase(null);

			var submit = {
				table: 'tblVMWDevice',
				value: { ExpireEntry: model.ExpireEntry },
				where: { Code_Vill_T: self.vl() }
			};
			submit = { submit: JSON.stringify(submit) };
			ajax('/Direct/update', submit).done(function () {
				self.vlCase(model);
			});
		}
		return true;
	};

	self.showDownload = function () {
		self.loaded(false);
		getPlace();
		self.pv(null);
	};

	self.back = function () {
		self.view('list');
	};

	self.copyCode = function (obj) {
		Clipboard.copy(obj.code);
		notify('Copied!');
	};

	document.addEventListener('visibilitychange', function () {
		if (!document.hidden) checkUpdate();
	});

	function notify(text) {
		$('.notify').text(text).addClass('active');
		setTimeout(() => $('.notify').removeClass('active'), 300);
	}

	function ajax(url, submit) {
		return $.ajax({
			url: url,
			method: submit === undefined ? 'GET' : 'POST',
			data: submit == null ? undefined : submit,
			dataType: 'json'
		}).fail(function (xhr, statusText, errorThrow) {
			if (xhr.status == 0) {
				self.loaded(true)
				if (url != '/pwa/checkUpdate') notify('No Internet!');
			} else if (xhr.status == 401) {
				delete localStorage.myusr;
				self.logged(false);
				self.view('list');
			} else {
				console.log(errorThrow);
				document.write(xhr.responseText);
			}
		});
	}
}();

$.ajaxSetup({
	converters: {
		'text json': function (json) {
			return json === '' ? undefined : JSON.parse(json);
		}
	}
});

window.Clipboard = (function (window, document) {
	var textArea;

	function createTextArea(text) {
		textArea = document.createElement('textArea');
		textArea.value = text;
		document.body.appendChild(textArea);
	}

	function selectText() {
		var range = document.createRange();
		range.selectNodeContents(textArea);
		var selection = window.getSelection();
		selection.removeAllRanges();
		selection.addRange(range);
		textArea.setSelectionRange(0, 999999);
	}

	function copyToClipboard() {
		document.execCommand('copy');
		document.body.removeChild(textArea);
	}

	return {
		copy: function (text) {
			createTextArea(text);
			selectText();
			copyToClipboard();
		}
	};
})(window, document);