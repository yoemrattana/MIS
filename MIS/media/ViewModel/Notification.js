function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.detailModel = ko.observable();
	self.view = ko.observable('list');

	self.pvList = ko.observableArray();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.yearList = [];
	self.monthList = [];
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.year = ko.observable(moment().year());
	self.month = ko.observable();
	self.tab = ko.observable('Setting');

	var templates = ['FollowupVMW', 'FollowupHC', 'CaseVmwHc', 'CmiCase', 'FociCase', 'FociReminder', 'ReactiveCase', 'ReactiveReminder', 'StockOut'];
	var draggableEl = ['FollowupVMW', 'FollowupHC', 'CaseVmwHc', 'CmiCase', 'FociCase', 'FociReminder', 'ReactiveCase', 'ReactiveReminder', 'StockOut'];
	var configs = ['AlertDayBefore', 'StockGrace', 'Threshold', 'NotifySpecies'];

	$.each(configs, function(k, config){
		declareVar(config)
	})

	var place = null;
	var mainData = [];

	for (var i = 2018; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}
	for (var i = 1; i <= 12; i++) {
		self.monthList.push(('0' + i).substr(-2));
	}

	app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
		place = p;
		if (app.user.prov != '') {
			place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
			place.od = place.od.filter(r => app.user.prov.contain(r.pvcode));
		}
		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

		var arr = place.od.map(r => r.pvcode).distinct();
		place.pv = place.pv.filter(r => arr.contain(r.code));
		self.pvList(place.pv);

		app.ajax('/Notification/getData').done(function (rs) {
			mainData = rs['list'];
			self.listModel(mainData);

			$.each(templates, function (k, template) {
			    var t = template;
			    var v = rs[t];
			    eval('self.' + template + '("' + v + '")');
			})

			$.each(configs, function (k, config) {
				var v = rs[config]['Value'];
				eval('self.' + config + '("'+ v + '")');
			})
		});
	});

	self.back = function () {
		self.view('list');
	};

	self.pv.subscribe(function (code) {
		var before = self.od();
		self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
		if (self.od() == before) filterListModel();
	});

	self.od.subscribe(function (code) {
		var before = self.hc();
		self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
		if (self.hc() == before) filterListModel();
	});

	self.hc.subscribe(filterListModel);
	self.year.subscribe(filterListModel);
	self.month.subscribe(filterListModel);

	function filterListModel() {
		var list = mainData.filter(r => r.Year == self.year());

		if (self.month() != null) list = list.filter(r => r.Month == self.month());

		if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
		else if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
		else if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());

		self.listModel(list);
	}

	self.getODName = function (code) {
		var found = place.od.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getHCName = function (code) {
		var found = place.hc.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getVLName = function (code) {
		var found = place.vl.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.saveSetting = function () {
		$.each(templates, function (k, template) {
			var submit = {
				Name: template,
				Value: eval('self.' + template + '()')
			};
			submit = { submit: JSON.stringify(submit) };
			app.ajax('/Notification/saveTemplate', submit).done(function (rs) {
				console.log('Template saved');
			});
		})

		$.each(configs, function (k, config) {
			var submit = {
				Name: config,
				Value: eval('self.' + config + '()')
			};
			submit = { submit: JSON.stringify(submit) };

			console.log(submit);

			app.ajax('/Notification/saveSetting', submit).done(function (rs) {
				console.log('Config saved');
			});
		})
	}

	$.each(draggableEl, function (k, element) {
		initDragEl(element);
		declareVar(element);
		initDroppable($("#" + element + ""));
		initEvent(element);
	})

	function initDragEl(element) {
		$("#" + element + "-fields li").draggable({
			appendTo: "body",
			helper: "clone",
			cursor: "select",
			revert: "invalid"
		});
	}

	function initEvent(element) {
		$("#" + element + "").on('mouseover', function () {
			var text = $(this).val();
			eval('self.' + element + '("' + text + '")');
		})
	}

	function declareVar(element) {
		eval('self.' + element + '= ko.observable()')
	}

	function initDroppable($elements) {
		var id = $elements[0].id;
		$elements.droppable({
			hoverClass: "textarea",
			accept: ":not(.ui-sortable-helper)",
			drop: function (event, ui) {
				var $this = $(this);
				var tempid = ui.draggable.text();
				var dropText;
				if (id == 'NotifySpecies') {
					dropText = tempid;
				}else{
					dropText = " {" + tempid + "} ";
				}
				
				var droparea = document.getElementById(id);
				var range1 = droparea.selectionStart;
				var range2 = droparea.selectionEnd;
				var val = droparea.value;
				var str1 = val.substring(0, range1);
				var str3 = val.substring(range1, val.length);
				droparea.value = str1 + dropText + str3;
			}
		});
	}
}