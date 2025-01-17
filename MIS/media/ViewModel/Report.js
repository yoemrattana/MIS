function viewModel() {
	var self = this;
	var today = moment();
	var place = null;
	var permiss = app.user.permiss['Reports'];
	var submitParam = null;

	self.type = ko.observable();
	self.monthList = [];
	self.monthNum = [];
	self.filterType = ko.observable();

	self.year = ko.observable(moment().year());
	self.quarter = ko.observable();
	self.month = ko.observable();
	self.from = ko.observable();
	self.to = ko.observable(12);
	self.preData = ko.observable();

	self.monthFrom = ko.computed(() => {
		return self.filterType() == 'q' ? self.quarter().substr(1) * 3 - 2
			: self.filterType() == 'm' ? parseInt(self.month())
			: self.filterType() == 'cus' ? parseInt(self.from())
			: 1;
	});

	self.monthTo = ko.computed(() => {
		return self.filterType() == 'q' ? self.quarter().substr(1) * 3
			: self.filterType() == 'm' ? parseInt(self.month())
			: self.filterType() == 'cus' ? parseInt(self.to())
			: 12;
	});

	self.pvList = ko.observableArray();

	self.pv = ko.observableArray();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.vl = ko.observable();

	self.nvmw = ko.observable(0);
	self.removevmw = ko.observable(0);
	self.neHC = ko.observable(521);
	self.meAber = ko.observable('');
	self.anualAber = ko.observable(0);
	self.neHCPositive = ko.observable(0);
	self.prevYear = ko.observable();
	self.anualPositiveRate = ko.observable();
	self.growthRate = ko.observable(1.54);
	self.positive_6m_11m = ko.observable('');
	self.positive_1y_6y = ko.observable('');
	self.positive_7y_12y = ko.observable('');
	self.positive_gt_12y = ko.observable('');
	self.positiveRate = ko.observable('');
	self.reduction = ko.observable('');
	self.popFromHC = ko.observable(true);

	self.listRDT = ko.observableArray();
	self.listModel = ko.observableArray();
	self.report = ko.observable(null);
	self.title = ko.observable();
	self.visibleExport = ko.observable(false);

	self.vmwSpecies = ko.observable();
	self.hfSpecies = ko.observable();
	self.hfvmwSpecies = ko.observable();
	self.bednetType = ko.observable();
	self.bednetDuration = ko.observable();
	self.invTypeFilter = ko.observable();
	self.invDateFilter = ko.observable();
	self.primaquine = ko.observable();
	self.primaquineV2 = ko.observable();
	self.G6PD = ko.observable();
	self.chartTopQty = ko.observable();
	self.investDetail = ko.observable();
	self.investPopup = ko.observableArray();
	self.investPopupRai4 = ko.observableArray();
	self.season = ko.observable();
	self.ipType = ko.observable(2);
	self.vmwFingerFilter = ko.observable();
	self.hfFingerFilter = ko.observable();
	self.RDTImagePopup = ko.observableArray();

	self.SP_V1_InvestigationIndicatorOD_header = ko.observableArray();
	self.SP_V1_IntensificationPlan_header = ko.observable();

	$('.frame').each((i, f) => {
		if (i == 0) return;
		if ($(f).attr('admin') == 1 && app.user.role == 'AU') return;

		var buttons = $(f).find('button, a');
		var hideCount = 0;
		buttons.each((i, e) => {
			if (!permiss.contain($(e).html().replace('<br>', ' ').replace('&amp;', '&'))) {
				if ($(e).parent().hasClass('btn-block') && $(e).parent().find('button').length == 1) $(e).parent().remove();
				else $(e).remove();
				hideCount++;
			}
		});
		if (buttons.length == hideCount) $(f).remove();
	});

	for (var i = 1; i <= 12; i++) {
		self.monthList.push({ value: moment(i, 'M').format('MM'), text: moment(i, 'M').format('MMM') });
		self.monthNum.push(i);
	}

	app.getPlace(['pv', 'od', 'hc', 'vl'], function (rs) {
		place = rs;
		place.pv = place.pv.filter(r => r.target == 1);
		place.od = place.od.filter(r => r.target == 1);

		if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

		self.pvList(place.pv);

        app.readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
            eval(script);
        });
	});

	self.getReport = function (root, event) {
		var element = $(event.currentTarget);
		var sp = element.attr('name');

		var submit = {
			y: self.year(),
			mf: self.monthFrom(),
			mt: self.monthTo(),
			pv: self.pv().join(',') || app.user.prov,
			od: self.od() || app.user.od,
			hc: self.hc() || '',
			vl: self.vl() || ''
		};

		var title = element.html().replace('<br>', ' ').replace('&amp;', '&') + ' - ' + self.year() + ' ';
		if (self.filterType() == 'q') {
			title += self.quarter();
		} else if (self.filterType() == 'm') {
			title += moment(self.month(), 'MM').format('MMM');
		} else if (self.filterType() == 'cus') {
			title += moment(self.from(), 'MM').format('MMM') + ' - ' + moment(self.to(), 'MM').format('MMM');
		} else {
			title += moment(self.monthFrom(), 'M').format('MMM') + ' - ' + moment(self.monthTo(), 'M').format('MMM');
		}

        if (sp == 'SP_V1_PopCompleteness') title = title.split('-')[0];
        if (sp == 'SP_V1_LastMile') title = title.split('-')[0];
        if (sp == 'SP_V1_LastmileNoData') title = title.split('-')[0];
        if (sp == 'SP_V1_Proactive2') {
            self.type($(event.currentTarget).attr('type'));
            title = title.split('-')[0] + ' - ' + self.year() + ' - ' + moment(self.monthTo(), 'M').format('MMM');
        }

		self.title(title);

		if (element.attr('addparam') !== undefined) {
			element.attr('addparam').split(',').forEach(r => {
				submit[r] = self[r] !== undefined ? self[r]() : element.attr(r);
			});
		}
		self.visibleExport(element.attr('export') == '1');

		if (sp == 'SP_V1_PrimaquineDistribution') {
			var p = self.primaquine();
			submit.vmw1 = isempty(p.vmw1(), 0);
			submit.vmw2 = isempty(p.vmw2(), 0);
			submit.hc1 = isempty(p.hc1(), 0);
			submit.hc2 = isempty(p.hc2(), 0);
		}

		if (sp == 'SP_V1_G6PD') {
			var p = self.G6PD();
			submit.refered = isempty(p.refered(), 1);
		}

		if (sp == 'SP_V1_Primaquine') {
			var p = self.primaquineV2();
			submit.deficiency = isempty(p.deficiency(), 1);
		}

		if (sp == 'SP_V1_StockForecasting') {
			if (self.positive_6m_11m() != '' || self.positive_1y_6y() != '' || self.positive_7y_12y() != '' || self.positive_gt_12y() != '') {
				if (parseInt(self.positive_6m_11m()) + parseInt(self.positive_1y_6y()) + parseInt(self.positive_7y_12y()) + parseInt(self.positive_gt_12y()) != 100) {
					app.showMsg('Warning!', 'ចំនួនសរុប ករណីវិជ្ជមានតាមអាយុ មិនស្មើរ 100%! <br/> Total of Positive Age Group not equal 100%');
					return;
				}
			}

			submit.nvmw = self.nvmw();
			submit.removevmw = self.removevmw();
			submit.neHC = self.neHC();
			submit.meAber = self.meAber();
			submit.neHCPositive = self.neHCPositive();
			submit.growthRate = self.growthRate();
			submit.positive_6m_11m = self.positive_6m_11m();
			submit.positive_1y_6y = self.positive_1y_6y();
			submit.positive_7y_12y = self.positive_7y_12y();
			submit.positive_gt_12y = self.positive_gt_12y();
			submit.positiveRate = self.positiveRate();
			submit.reduction = self.reduction();
			submit.popFromHC = self.popFromHC() ? 1 : 0;
			self.prevYear(self.year() - 1);
		}

		if (sp == 'SP_V1_StockOD' || sp == 'SP_V1_StockHC') {
			if (self.filterType() == 'cus' && self.year() + self.to() > moment().format("YYYYMM")) {
				app.showMsg('Warning!', 'Selected Month cannot over current Month');
				return;
			}
		}

        if (sp == 'SP_V1_StockOD' || sp == 'SP_V1_StockHC' || sp == 'SP_V1_VMWCommodity') {
			if (self.filterType() != 'm') {
				app.showMsg('Warning!', 'Stock report only available for a month selection! <kh> សូមជ្រើសរើសខែ</kh>');
				return;
			}
		}

		if (sp == 'SP_V1_SupervisionChecklist' && self.hc() == null) {
			app.showMsg('Warning!', 'Please select Health Facility');
			return;
		}

		submitParam = submit;
		app.ajax('/Report/getReport/' + sp, submit).done(function (rs) {
			if (sp == 'SP_V1_StockHC') {
				rs.forEach(r => {
					r.Total = toFloat(r.StockStart) + toFloat(r.StockIn);
					r.Balance = toFloat(r.Total) - toFloat(r.StockOut) + toFloat(r.Adjustment);
					r.AMC = r.AMC == null ? 'NA' : toFloat1d(r.AMC);
					r.Estimate = r.AMC == 'NA' ? 'NA' : Math.ceil((r.AMC * 6) - r.StockStart);

					var preBalance = r.Balance;
					r.MOS = r.AMC.in('NA', 0) ? 'NA' : toFloat1d(preBalance / r.AMC);
				});
			}

			if (sp == 'SP_V1_HighRiskVillage') {
				rs.map(r => {
					r.STD = parseFloat(r.STD).toFixed(2)
					r.Average = parseFloat(r.Average).toFixed(2)
					r.STDAVG = parseFloat(r.STDAVG).toFixed(2)
				})
			}

			if (self[sp + '_fn'] === undefined) self.listModel(rs);
			else self[sp + '_fn'](rs);

			self.report(sp);

			$(window).scrollTop(0);
		});
	};

	self.exportExcel = function () {
		var submit = {
			year: self.year(),
			from: self.monthFrom(),
			to: self.monthTo(),
			pv: self.pv().join(',') || app.user.prov,
			od: self.od() || app.user.od,
			hc: self.hc() || '',
			vl: self.vl() || '',
			report: self.report(),
			json: JSON.stringify(self.listModel()),
			type: self.type()
		};

		app.downloadBlob('report/exportExcel', submit).done(function (blob) {
			saveAs(blob, self.title().trim() + '.xlsx'); //from FileSaver.js
		});
	};

	self.exportExcelInvest = function () {
		var submit = {
			year: self.year(),
			from: self.monthFrom(),
			to: self.monthTo(),
			report: 'SP_V1_InvestigationPopup',
			json: JSON.stringify(self.investPopup())
		};

		$('#modalInvestPopup').modal('hide');
		app.downloadBlob('report/exportExcel', submit).done(function (blob) {
			saveAs(blob, self.title().trim() + '.xlsx'); //from FileSaver.js
			$('#modalInvestPopup').modal('show');
		});
	};

	self.exportExcelInvestRai4 = function () {
		var submit = {
			year: self.year(),
			from: self.monthFrom(),
			to: self.monthTo(),
			report: 'SP_V1_InvestigationPopupRai4',
			json: JSON.stringify(self.investPopupRai4())
		};

		$('#modalInvestPopupRai4').modal('hide');
		app.downloadBlob('report/exportExcel', submit).done(function (blob) {
			saveAs(blob, self.title().trim() + '.xlsx'); //from FileSaver.js
			$('#modalInvestPopupRai4').modal('show');
		});
	};

	self.previousClick = function () {
		self.year(self.year() - 1);
	};

	self.nextClick = function () {
		self.year(self.year() + 1);
	};

	self.resetClick = function () {
		self.filterType(null);
		self.quarter('Q1');
		self.month(1);
		self.from(1);
		self.to(12);
	};

	self.pvName = ko.pureComputed(function () {
		return self.pv().length.in(0, self.pvList().length) ? 'All'
			: self.pv().length == 1 ? place.pv.find(r => r.code == self.pv()[0]).name
			: 'Multiple Select';
	});

	self.odList = ko.pureComputed(function () {
		return self.pv().length != 1 ? [] : place.od.filter(r => r.pvcode == self.pv()[0]);
	});

	self.hcList = ko.pureComputed(function () {
		return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
	});

	self.vlList = ko.pureComputed(function () {
		return self.hc() == null ? [] : place.vl.filter(r => r.hccode == self.hc());
	});

	self.back = function () {
		self.report(null);
	};

	self.accuracyByMonth = function (model, index) {
		if (index < getMonthFrom() || index > getMonthTo()) return '';
		if (self.year() == today.year() && index > today.month()) return ''
		var value = model[moment(index + 1, 'M').format('MM')];
		if (value == null) return '';
		value = value.split('/');
		return value;
	}

	self.bgAccuracyWarning = function (model, index) {
		//var value = self.valueByMonth(model, index);
		//value = value.split('/');
		//value = Math.abs(value[0]);
		//if (value !== '' && value >= 1 && value <= 5) return '#ffff99';
		//else if (value !== '' && value > 5) return '#e74c3c';
		//else return '';
	};

	self.valueByMonth = function (model, index) {
		if (index < getMonthFrom() || index > getMonthTo()) return '';
		if (self.year() == today.year() && index > today.month()) return ''
		var value = model[moment(index + 1, 'M').format('MM')];
		if (value == null) return '';
		return value;
	};

	self.valueByYear = function (model, index) {
		var y = index + 2018;
		if (y > moment().year()) return '';
		var value = model[y];
		if (value == null) return '';
		return value;
	};

	self.bgWarning = function (model, index) {
		var value = self.valueByMonth(model, index);
		return value !== '' && value < 90 ? '#ffff99' : '';
	};

	self.bgWarningPop = function (model, index) {
		var value = self.valueByYear(model, index);
		return value === '' ? ''
			: value < 50 ? '#ff3535'
			: value < 90 ? '#ffae49'
			: '';
	};

	self.bgWarningPopCSO = function (model) {
		var arr = [];
		for (var i = 0; i < 8; i++) {
			var value = self.valueByYear(model, i);
			if (value !== '') arr.push(value);
		}
		var value = Math.floor(arr.sum() / arr.length);
		return value < 50 ? '#ff3535'
			: value < 90 ? '#ffae49'
			: '';
	};

	self.visibleMonth = function (m) {
		return m >= self.monthFrom() && m <= self.monthTo();
	};

	function getMonthFrom() {
		if (self.filterType() == null) return 0;
		else if (self.filterType() == 'q') return (self.quarter().substr(-1) - 1) * 3;
		else if (self.filterType() == 'm') return self.month() - 1;
		else if (self.filterType() == 'cus') return self.from() - 1;
	}

	function getMonthTo() {
		if (self.filterType() == null) return 11;
		else if (self.filterType() == 'q') return ((self.quarter().substr(-1) - 1) * 3) + 2;
		else if (self.filterType() == 'm') return self.month() - 1;
		else if (self.filterType() == 'cus') return self.to() - 1;
	}

	self.showRDT = function (root, event) {
		$.when(getPredata()).then(function () {
			rdtModal(root, event);
		});
	};

	function rdtModal(root, event) {
		if (self.year() - moment().format('YYYY') >= 2) {
			app.showMsg("Waring", "លោកអ្នកមិនអាចមើលទិន្នន័យលើសពី១ឆ្នាំបន្ទាប់!");
			return;
		}
		if (self.year() == 2018 || (self.year() == 2019 && self.monthTo() < moment().month())) {
			app.showMsg('Warning!', 'សូមជ្រើសរើស ខែឆ្នាំឲ្យបានត្រឹមត្រូវ! <br/> Please select proper Month and Year');
			return;
		}

		var model = {
			nvmw: ko.observable(),
			removevmw: ko.observable(),
			neHC: ko.observable()
		};

		self.anualPositiveRate(parseFloat(self.preData().PositiveRate).toFixed(3));
		self.anualAber(parseFloat(self.preData().Aber).toFixed(3));

		model.nvmw(0);
		model.removevmw(0);
		model.neHC(521);

		self.type($(event.currentTarget).attr('type'));
		if (self.od() != null) self.popFromHC(false);
		$("#modalRDT").modal("show");

		$('#modalRDT .btn-primary').off().click(function () {
			$('#modalRDT').modal('hide');
			self.getReport(root, event);
		});
	}

	self.showPrimaquine = function (root, event) {
		if (self.primaquine() == null) {
			var model = {
				vmw1: ko.observable(),
				vmw2: ko.observable(),
				hc1: ko.observable(),
				hc2: ko.observable(),
				level: ko.observable()
			};
			self.primaquine(model);
			app.setNumberOnly(model.vmw1.element, 'int');
			app.setNumberOnly(model.vmw2.element, 'int');
			app.setNumberOnly(model.hc1.element, 'int');
			app.setNumberOnly(model.hc2.element, 'int');
		}

		var level = $(event.currentTarget).attr('level');
		var model = self.primaquine();
		if (level == '7.5') {
			model.vmw1(1);
			model.vmw2(2);
			model.hc1(1);
			model.hc2(0);
		} else {
			model.vmw1(0);
			model.vmw2(0);
			model.hc1(0);
			model.hc2(1);
		}
		model.level(level);

		$('#modalPrimaquine').modal('show');

		$('#modalPrimaquine .btn-primary').off().click(function () {
			$('#modalPrimaquine').modal('hide');
			self.getReport(root, event);
		});
	};

	self.showASMQ = function (root, event) {
		$.when(getPredata()).then(function () {
			asmqModal(root, event);
		});
	};

	function asmqModal(root, event) {
		if (self.year() - moment().format('YYYY') >= 2) {
			app.showMsg("Waring", "លោកអ្នកមិនអាចមើលទិន្នន័យលើសពី១ឆ្នាំបន្ទាប់!");
			return;
		}
		if (self.year() == 2018 || (self.year() == 2019 && self.monthTo() < moment().month())) {
			app.showMsg('Warning!', 'សូមជ្រើសរើស ខែឆ្នាំឲ្យបានត្រឹមត្រូវ! <br/> Please select proper Month and Year');
			return;
		}

		var model = {
			nvmw: ko.observable(),
			removevmw: ko.observable(),
			neHC: ko.observable()
		};

		self.anualPositiveRate(parseFloat(self.preData().PositiveRate).toFixed(3));
		self.anualAber(parseFloat(self.preData().Aber).toFixed(3));

		model.nvmw(0);
		model.removevmw(0);
		model.neHC(521);

		self.type($(event.currentTarget).attr('type'));
		if (self.od() != null) self.popFromHC(false);
		$("#modalASMQ").modal("show");

		$('#modalASMQ .btn-primary').off().click(function () {
			$('#modalASMQ').modal('hide');
			self.getReport(root, event);
		});
	}

	function getPredata() {
		return app.ajax('Report/getPreData').done(function (rs) {
			rs = {
				Aber: parseFloat(rs.Aber).toFixed(3),
				PositiveRate: parseFloat(rs.PositiveRate).toFixed(3),
				p6m_11m: parseFloat(rs.p6m_11m).toFixed(3),
				p1y_6y: parseFloat(rs.p1y_6y).toFixed(3),
				p7y_12y: parseFloat(rs.p7y_12y).toFixed(3),
				p12y: parseFloat(rs.p12y).toFixed(3)
			}
			self.preData(rs);
		});
	}

	self.showPrimaquineV2 = function (root, event) {
		if (self.year() - moment().format('YYYY') >= 2) {
			app.showMsg("Waring", "លោកអ្នកមិនអាចមើលទិន្នន័យលើសពី១ឆ្នាំបន្ទាប់!");
			return;
		}
		var model = {
			deficiency: ko.observable(1),
			minHF: ko.observable(1),
			minOD: ko.observable(3),
			minCMS: ko.observable(6),
		};

		self.primaquineV2(model);

		$('#modalPrimaquineV2').modal('show');

		$('#modalPrimaquineV2 .btn-primary').off().click(function () {
			$('#modalPrimaquineV2').modal('hide');
			self.getReport(root, event);
		});
	};

	self.showG6PD = function (root, event) {
		if (self.year() - moment().format('YYYY') >= 2) {
			app.showMsg("Waring", "លោកអ្នកមិនអាចមើលទិន្នន័យលើសពី១ឆ្នាំបន្ទាប់!");
			return;
		}
		var model = {
			refered: ko.observable(1),
			minHF: ko.observable(1),
			minOD: ko.observable(3),
			minCMS: ko.observable(6),
		};

		self.G6PD(model);

		$('#modalG6PD').modal('show');

		$('#modalG6PD .btn-primary').off().click(function () {
			$('#modalG6PD').modal('hide');
			self.getReport(root, event);
		});
	};

	self.SP_V1_InvestigationIndicatorOD_fn = function (rs) {
		var ods = rs.map(r => r.Name_OD_E).distinct().sort();
		var names = rs.map(r => r.Name).distinct();
		var list = [];

		names.forEach(name => {
			var row = [name];
			ods.forEach(od => {
				var found = rs.find(r => r.Name == name && r.Name_OD_E == od);
				['L1', 'L2', 'L3', 'L4', 'IMP', 'Total'].forEach(k => {
					row.push(isnull(found[k], 'NA') + found.Percentage);
				});
			});
			list.push(row);
		});

		self.SP_V1_InvestigationIndicatorOD_header(ods);
		self.listModel(list);
	};

    var mapRacd = null;
    self.drawMapRacd = function() {
        var model = self.listModel();
        
        mapRacd = app.createGoogleMap('mapRacd', {
            zoom: 8.0
        });

        var legend = document.createElement('div');
        legend.style = 'padding:10px; margin:10px; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';

        var title = document.createElement('div');
        title.style = 'margin-bottom:5px';
        title.innerHTML = '<b>House Hold</b><br>';
        legend.appendChild(title);

        var div = document.createElement('div');
        div.style = 'margin-bottom:5px; line-height:16px';
        div.innerHTML = '<span style="width:15px; height:15px; background: red; border:1px solid; border-radius:50%; float:left"></span>';
        div.innerHTML += '<span style="padding-left:5px" class="font12"> Positive</span>';
        legend.appendChild(div);
        var div = document.createElement('div');
        div.style = 'margin-bottom:5px; line-height:16px';
        div.innerHTML = '<span style="width:15px; height:15px; background: blue; border:1px solid; border-radius:50%; float:left"></span>';
        div.innerHTML += '<span style="padding-left:5px" class="font12"> Negative</span>';
        legend.appendChild(div);

        mapRacd.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

        model.forEach(r => {
            var marker = new google.maps.Marker({
                position: { lat: parseFloat(r.Lat), lng: parseFloat(r.Long) },
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    fillOpacity: 1,
                    fillColor: r.Positive == 1 ? 'red' : 'blue',
                    strokeColor: '#555',
                    strokeWeight: 1,
                    scale: 5
                },
                
                zIndex: 900
            });

            marker.setMap(mapRacd);

            var txt = '';
            txt += '<br><b>Province:</b> ' + r.Name_Prov_E;
            txt += '<br><b>OD:</b> ' + r.Name_OD_E;
            txt += '<br><b>HC:</b> ' + r.Name_Facility_E;
            txt += '<br><b>Village:</b> ' + r.Name_Vill_E;

            var infowindow = new google.maps.InfoWindow({ content: txt });
            marker.addListener('mouseover', () => infowindow.open(mapRacd, marker));
            marker.addListener('mouseout', () => infowindow.close());
        });
    }

    var mapProactive = null;
    self.drawMapProactive = function () {
        var model = self.listModel();

        mapProactive = app.createGoogleMap('mapProactive', {
            zoom: 8.0
        });

        var legend = document.createElement('div');
        legend.style = 'padding:10px; margin:10px; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';

        var title = document.createElement('div');
        title.style = 'margin-bottom:5px';
        title.innerHTML = '<b>Village</b><br>';
        legend.appendChild(title);

        var div = document.createElement('div');
        div.style = 'margin-bottom:5px; line-height:16px';
        div.innerHTML = '<span style="width:15px; height:15px; background: red; border:1px solid; border-radius:50%; float:left"></span>';
        div.innerHTML += '<span style="padding-left:5px" class="font12"> Index Case (L1)</span>';
        legend.appendChild(div);
        var div = document.createElement('div');
        div.style = 'margin-bottom:5px; line-height:16px';
        div.innerHTML = '<span style="width:15px; height:15px; background: blue; border:1px solid; border-radius:50%; float:left"></span>';
        div.innerHTML += '<span style="padding-left:5px" class="font12"> Proactive</span>';
        legend.appendChild(div);

        mapProactive.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

        model.forEach(r => {
            var marker = new google.maps.Marker({
                position: { lat: parseFloat(r.Lat), lng: parseFloat(r.Long) },
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    fillOpacity: 1,
                    fillColor: r.L1=='Yes' ? 'red' : 'blue',
                    strokeColor: '#555',
                    strokeWeight: 1,
                    scale: 5
                },

                zIndex: 900
            });

            marker.setMap(mapProactive);

            var txt = '<br><b>Province:</b> ' + r.Name_Prov_E;
            txt += '<br><b>OD:</b> ' + r.Name_OD_E;
            txt += '<br><b>HC:</b> ' + r.Name_Facility_E;
            txt += '<br><b>Village:</b> ' + r.Name_Vill_E;

            var infowindow = new google.maps.InfoWindow({ content: txt });
            marker.addListener('mouseover', () => infowindow.open(mapProactive, marker));
            marker.addListener('mouseout', () => infowindow.close());
        });
    }

	self.drawChartTop10HFPie = function () {
		var model = self.listModel();
		var data = model.distinct(r => r.Name_Facility_E).map(item => {
			return {
				name: item.Name_OD_E + ' / ' + item.Name_Facility_E,
				y: model.filter(r => r.Name_Facility_E == item.Name_Facility_E).sum(r => r.HF + r.VMW)
			};
		});

		var seriesData = data.sortdesc(r => r.y).slice(0, 9);
		var top9 = seriesData.map(r => r.name);
		seriesData.push({
			name: 'Other HFs',
			y: data.filter(r => !top9.contain(r.name)).sum(r => r.y)
		});

		var date = self.title().substr(self.title().indexOf('-'));
		date.indexOf('-') == 0 ? date = date.replace('-', ',') : date;
		$('#chartTop10HFPie').highcharts({
			chart: { type: 'pie' },
			title: { text: 'Top 10 HFs Having Most Cases ' + date },
			tooltip: { enabled: false },
			plotOptions: {
				series: {
					enableMouseTracking: false,
					dataLabels: {
						enabled: true,
						format: '{point.name}: = <b> {point.y} ({point.percentage:.2f}%)</b>',
						style: { fontWeight: 'regular', fontSize: '13px' }
					}
				}
			},
			exporting: { sourceWidth: 1400, sourceHeight: 800 },
			series: [{ name: 'Cases', data: seriesData }]
		});
	};

	self.drawChartTop30ByType = function () {
		var model = self.listModel();

		var hf = $('#chartTop30ByTypeHF').prop('checked');
		var vmw = $('#chartTop30ByTypeVMW').prop('checked');

		var data = model.distinct(r => r.Name_Facility_E).map(item => {
			var founds = model.filter(r => r.Name_Facility_E == item.Name_Facility_E);
			return {
				name: item.Name_OD_E + ' / ' + item.Name_Facility_E,
				hf: hf ? founds.sum(r => r.HF) : 0,
				vmw: vmw ? founds.sum(r => r.VMW) : 0
			};
		});

		var topQty = parseInt(self.chartTopQty());
		data = data.sortdesc(r => r.hf + r.vmw).slice(0, topQty);

		var date = self.title().substr(self.title().indexOf('-'));
		date.indexOf('-') == 0 ? date = date.replace('-', ',') : date;
		$('#chartTop30ByType').highcharts({
			chart: { type: 'bar' },
			title: { text: 'Top ' + topQty + ' HFs Having Most Cases by HF & VMW ' + date },
			subtitle: { text: '.' },
			xAxis: { categories: data.map(r => r.name), crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of cases' }, reversedStacks: false },
			tooltip: { shared: true },
			plotOptions: { series: { stacking: 'normal' } },
			exporting: { sourceWidth: 1200, sourceHeight: 800 },
			series: [
				{ name: 'HF', data: data.map(r => r.hf) },
				{ name: 'VMW', data: data.map(r => r.vmw) }
			]
		}, function () {
			var x = 70;
			var y = 60;
			var bold = { 'font-weight': 'bold' };
			this.renderer.text('OD / Health Facility', x, y).attr(bold).add();
		});

		return true;
	};

	self.drawChartTop30BySpecie = function () {
		var model = self.listModel();

		var pf = $('#chartTop30BySpeciePf').prop('checked');
		var pv = $('#chartTop30BySpeciePv').prop('checked');
		var mix = $('#chartTop30BySpecieMix').prop('checked');

		var data = model.distinct(r => r.Name_Facility_E).map(item => {
			var founds = model.filter(r => r.Name_Facility_E == item.Name_Facility_E);
			return {
				name: item.Name_OD_E + ' / ' + item.Name_Facility_E,
				pf: pf ? founds.sum(r => r.Pf) : 0,
				pv: pv ? founds.sum(r => r.Pv) : 0,
				mix: mix ? founds.sum(r => r.Mix) : 0
			};
		});

		var topQty = parseInt(self.chartTopQty());
		data = data.sortdesc(r => r.pf + r.pv + r.mix).slice(0, topQty);

		var date = self.title().substr(self.title().indexOf('-'));
		date.indexOf('-') == 0 ? date = date.replace('-', ',') : date;
		$('#chartTop30BySpecie').highcharts({
			chart: { type: 'bar' },
			title: { text: 'Top ' + topQty + ' HFs Having Most Cases by Species ' + date },
			subtitle: { text: '.' },
			colors: ["#FF7474", "#F7A35C", "#95CEFF"],
			xAxis: { categories: data.map(r => r.name), crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of cases' }, reversedStacks: false },
			tooltip: { shared: true },
			plotOptions: { series: { stacking: 'normal' } },
			exporting: { sourceWidth: 1200, sourceHeight: 800 },
			series: [
				{ name: 'PF', data: data.map(r => r.pf) },
				{ name: 'PV', data: data.map(r => r.pv) },
				{ name: 'Mix', data: data.map(r => r.mix) }
			]
		}, function () {
			var x = 70;
			var y = 60;
			var bold = { 'font-weight': 'bold' };
			this.renderer.text('OD / Health Facility', x, y).attr(bold).add();
		});

		return true;
	};

	self.drawChartTop10VillPie = function () {
		var model = self.listModel();

		var data = model.filter(r => r.Name_Vill_E != null).distinct(r => r.Name_Vill_E).map(item => {
			return {
				name: item.Name_OD_E + ' / ' + item.Name_Facility_E + ' / ' + item.Name_Vill_E,
				y: model.filter(r => r.Name_Vill_E == item.Name_Vill_E).sum(r => r.Pf + r.Pv + r.Mix)
			};
		});

		var seriesData = data.sortdesc(r => r.y).slice(0, 9);
		var top9 = seriesData.map(r => r.name);
		seriesData.push({
			name: 'Other Villages',
			y: data.filter(r => !top9.contain(r.name)).sum(r => r.y)
		});

		var date = self.title().substr(self.title().indexOf('-'));
		date.indexOf('-') == 0 ? date = date.replace('-', ',') : date;
		$('#chartTop10VillPie').highcharts({
			chart: { type: 'pie' },
			title: { text: 'Top 10 Villages Having Most Cases ' + date },
			tooltip: { enabled: false },
			plotOptions: {
				series: {
					enableMouseTracking: false,
					dataLabels: {
						enabled: true,
						format: '{point.name}: <b>{point.y} ({point.percentage:.2f}%)</b>',
						style: { fontWeight: 'regular', fontSize: '13px' }
					}
				}
			},
			exporting: { sourceWidth: 1400, sourceHeight: 800 },
			series: [{ name: 'Cases', data: seriesData }]
		});
	};

	self.drawChartTop30ByVill = function () {
		var model = self.listModel();

		var pf = $('#chartTop30ByVillPf').prop('checked');
		var pv = $('#chartTop30ByVillPv').prop('checked');
		var mix = $('#chartTop30ByVillMix').prop('checked');

		var data = model.filter(r => r.Name_Vill_E != null).distinct(r => r.Name_Vill_E).map(item => {
			var founds = model.filter(r => r.Name_Vill_E == item.Name_Vill_E);
			return {
				name: item.Name_OD_E + ' / ' + item.Name_Facility_E + ' / ' + item.Name_Vill_E,
				pf: pf ? founds.sum(r => r.Pf) : 0,
				pv: pv ? founds.sum(r => r.Pv) : 0,
				mix: mix ? founds.sum(r => r.Mix) : 0
			};
		});

		var topQty = parseInt(self.chartTopQty());
		data = data.sortdesc(r => r.pf + r.pv + r.mix).slice(0, topQty);

		var date = self.title().substr(self.title().indexOf('-'));
		date.indexOf('-') == 0 ? date = date.replace('-', ',') : date;
		$('#chartTop30ByVill').highcharts({
			chart: { type: 'bar' },
			title: { text: 'Top ' + topQty + ' Villages Having Most Cases by Species ' + date },
			subtitle: { text: '.' },
			colors: ["#FF7474", "#F7A35C", "#95CEFF"],
			xAxis: { categories: data.map(r => r.name), crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of cases' }, reversedStacks: false },
			tooltip: { shared: true },
			plotOptions: { series: { stacking: 'normal' } },
			exporting: { sourceWidth: 1200, sourceHeight: 800 },
			series: [
				{ name: 'PF', data: data.map(r => r.pf) },
				{ name: 'PV', data: data.map(r => r.pv) },
				{ name: 'Mix', data: data.map(r => r.mix) }
			]
		}, function () {
			var x = 105;
			var y = 60;
			var bold = { 'font-weight': 'bold' };
			this.renderer.text('OD / Health Facility / Village', x, y).attr(bold).add();
		});

		return true;
    };

    self.SP_V1_HFVMWRACD_fn = function (rs) {
        self.listModel(rs);
       self.drawMapRacd()
    }

    self.SP_V1_Proactive2_fn = function (rs) {
        self.listModel(rs);
        self.drawMapProactive()
    }

    self.SP_V1_HFVMWTop30HFChart_fn = function (rs) {
		$('#SP_V1_HFVMWTop30HFChart input').prop('checked', true);
		self.listModel(rs);
		self.drawChartTop10HFPie();
		self.drawChartTop30ByType();
		self.drawChartTop30BySpecie();
	};

	self.SP_V1_HFVMWTop30VillChart_fn = function (rs) {
		$('#SP_V1_HFVMWTop30VillChart input').prop('checked', true);
		self.listModel(rs);
		self.drawChartTop10VillPie();
		self.drawChartTop30ByVill();
	};

	self.SP_V1_InvestigationDetail_fn = function (rs) {
		var ods = rs.map(r => r.Name_OD_E).distinct().sort();
		var list = ods.map(od => {
			return {
				odName: od,
				table: rs.filter(r => r.Name_OD_E == od)
			};
		});
		self.listModel(list);
	};

	self.SP_V1_IntensificationPlan_fn = function (rs) {
		if (rs.length > 0) {
			var head = {
				csos: rs.distinct(r => r.CSO).map(c => {
					return {
						name: c.CSO,
						colspan: rs.filter(r => r.CSO == c.CSO).length
					}
				}),
				pvs: rs.distinct(r => r.Name_Prov_E).map(pv => {
					return {
						name: pv.Name_Prov_E,
						colspan: rs.filter(r => r.Name_Prov_E == pv.Name_Prov_E).length
					}
				}),
				ods: rs.distinct(r => r.Name_OD_E).map(od => {
					return {
						name: od.Name_OD_E,
						colspan: rs.filter(r => r.Name_OD_E == od.Name_OD_E).length
					}
				}),
				hfs: rs.map(r => r.Name_Facility_E),
			};
			self.SP_V1_IntensificationPlan_header(head);
		}

		self.listModel(rs);
	};

	self.findIP = function (code) {
		return self.listModel().find(r => r.Code_Facility_T == code);
	};

	function tickChbox(className, chart) {
		$(className).click(function () {
			if (!isEmptyObject(chart)) {
				var id = $(this).attr('id');
				series = chart.get(id);
				series.setVisible(!series.visible);
			}
		});
	}

	function isEmptyObject(obj) {
		var name;
		for (name in obj) {
			if (obj.hasOwnProperty(name)) {
				return false;
			}
		}
		return true;
	}

	function toFloat1d(value) {
		return parseFloat(parseFloat(value).toFixed(1));
	}

	self.expire = function (param) {
		var dateLabel = '';
		if (param.length != 0) {
			var param = JSON.parse(param);
			if (!isEmptyObject(param)) {
				param.forEach(v => {
					dateLabel += ' <span style="font-size:12px" class="badge badge-danger"> ' + moment(v.Date).format('MM-DD-YYYY') + ' <span class="badge badge-light"> ' + v.Qty + ' </span> </span> ';
				})
			}
		}
		return dateLabel;
	};

	self.showInvestDetail = function (model) {
		var submit = { type: model.Type, id: model.Rec_ID };

		app.ajax('/Report/getInvestDetail', submit).done(function (rs) {
			self.investDetail({
				title: 'HC: ' + model.HC + ', Village: ' + model.Vill,
				table: rs
			});
			$('#modalInvestDetail').modal('show');
		});
	};

	self.saveNotError = function () {
		var list = [];
		$('#tblErrorCheck tbody input:checked').each(function () {
			list.push({
				Type: self.report() == 'SP_V1_HFErrorCheck' ? 'HF' : 'VMW',
				Rec_ID: $(this).attr('recid')
			});
		});

		if (list.length == 0) return;

		var submit = {
			table: 'tblHFVMWException',
			batch: list
		};
		submit = { submit: JSON.stringify(submit) };

		app.ajax('/Direct/insert', submit).done(self.back);
	};

	self.showInvestPopup = function (model) {
		submitParam.code = model.Code;
		app.ajax('/Report/getReport/SP_V1_InvestigationPopup', submitParam).done(function (rs) {
			self.investPopup(rs);
			$('#modalInvestPopup').modal('show');
			$('#modalInvestPopup .modal-body').scrollTop(0);
		});
	};

	self.showInvestPopupRai4 = function (model) {
		submitParam.code = model.Code;
		app.ajax('/Report/getReport/SP_V1_InvestigationPopupRai4', submitParam).done(function (rs) {
			self.investPopupRai4(rs);
			$('#modalInvestPopupRai4').modal('show');
			$('#modalInvestPopupRai4 .modal-body').scrollTop(0);
		});
	};

	self.showCaseEntryForm = function (model, event) {
		if (event.currentTarget.innerHTML == '') return;
		var obj = {
			year: self.year(),
			od: model.Code_OD_T,
			hc: model.ReportType == 'HF' ? undefined : model.Code_Facility_T,
			id: model.ReportType == 'HF' ? model.Code_Facility_T : model.Code_Vill_T,
			month: model.ReportMonth
		};
		sessionStorage.code_prov = model.Code_Prov_N;
		window.open('/CaseReport/' + model.ReportType + '?s=' + JSON.stringify(obj));
	};

	self.showInvestForm = function (model, event) {
		if (event.currentTarget.innerHTML == '') return;
		window.open('/CaseReport/investigation/' + model.Passive_Case_Id + '/0000');
	};

	self.showReactiveForm = function (model, event) {
		if (event.currentTarget.innerHTML == '') return;
		window.open('/Reactive/open/' + model.Passive_Case_Id);
	};

	self.showFociForm = function (model, event) {
		if (event.currentTarget.innerHTML == '') return;
		window.open('/Foci/open/' + model.Code_Vill_T);
	};

	self.noPeopleClick = function (model) {
		$('#modalNoPeople').modal('show');
		$('#modalNoPeople input.form-control').val('').focus();
		$('#modalNoPeople .btn-danger').off().click(function () {
			setTimeout(function () {
				var submit = {
					table: 'tblVillageNoPeople',
					value: {
						Code_Vill_T: model.Code_Vill_T,
						Reason: $('#modalNoPeople input.form-control').val().trim()
					}
				};
				var submit = { submit: JSON.stringify(submit) };

				app.ajax('/Direct/insert', submit).done(function () {
					self.listModel.remove(model);
				});
			}, 100);
		});
	};

	self.mergeExpire = function (expireDetail) {
		var arr = expireDetail == null ? [] : JSON.parse(expireDetail);
		if (arr.length == 0) return '';
		var temp = arr.map(r => moment(r.Date).format('DD-MM-YYYY') + ': ' + r.Qty);
		return '(' + temp.join(') (') + ')';
	};

	self.highlightFingerprint = function (row) {
		if (self.report() == 'SP_V1_VMWFingerprint') {
			if (row.Level != 'Village') return false;
		} else {
			if (row.Level != 'HC') return false;
		}

		return row.Positive != row.Fingerprint || row.Positive != row.RdtImage;
	};

	self.showRDTImage = function (model) {
		if (model.RdtImage == 0) return;

		submitParam.code = model.Code;
		submitParam.type = self.report() == 'SP_V1_VMWFingerprint' ? 'vmw' : 'hc';

		app.ajax('/Report/getReport/SP_V1_HFVMWRdtImagePopup', submitParam).done(function (rs) {
			self.RDTImagePopup(rs);
			$('#modalRDTImage').modal('show');
			$('#modalRDTImage .modal-body').scrollTop(0);
		});
	};

	self.getVill = function (code) {
		if (code == null || code === '') return '';
		if (code == '999') return 'Unknown';
		var found = code.length == 10 ? place?.vl?.find(r => r.code == code)
			: code.length == 6 ? place?.cm?.find(r => r.code == code)
				: code.length == 4 ? place?.ds?.find(r => r.code == code)
					: code.length == 2 ? place?.pv?.find(r => r.code == code)
						: null;

		return found == null ? code : found?.name;
	};
};

function getChartImageUrl(chart, scale, onSuccess) {
	var onError = console.log;
	chart.getSVGForLocalExport(undefined, undefined, onError, function (svg) {
		var svgurl = Highcharts.svgToDataUrl(svg);
		Highcharts.imageToDataUrl(svgurl, 'image/png', null, scale, onSuccess, onError, onError, onError);
	});
}

function exportChartImage(chart, onSuccess) {
	if (onSuccess === undefined) chart = this;
	var scale = 1.5;

	getChartImageUrl(chart, scale, function (image) {
		var ex = chart.options.exporting;
		var images = [{ src: image }]

		if (app.user.role != 'AU') {
			var imgsrc = '/media/images/background.png';
			var x = ex.sourceWidth * scale / 2 - 100;
			var y = ex.sourceHeight * scale / 2 - 110;

			images.push({ src: imgsrc, opacity: 0.3, x: x, y: y });
		}

		mergeImages(images).then(function (result) {
			onSuccess === undefined ? Highcharts.downloadURL(result, chart.options.title.text.trim()) : onSuccess(result);
		});
	});
}

Highcharts.setOptions({
	chart: {
		style: { fontFamily: 'Dosis, sans-serif' },
		events: {
			load: function () {
				if (app.user.role == 'AU' || this.renderTo.id == '') return;

				var imgurl = '/media/images/background.png';
				var w = 200;
				var x = this.chartWidth / 2 - 100;
				var y = this.chartHeight / 2 - 110
				var opacity = 0.1;

				if (this.options.chart.type == 'pie') {
					this.update({ plotOptions: { series: { opacity: 0.9 } } });
					opacity = 0.5;
				}

				this.renderer.image(imgurl, x, y, w, 216).attr({ opacity: opacity }).add();
			}
		}
	},
	title: { style: { fontSize: '18px', fontWeight: 'bold', textTransform: 'uppercase' } },
	tooltip: { borderWidth: 0, backgroundColor: 'rgba(219,219,216,0.8)', shadow: false },
	legend: { itemStyle: { fontWeight: 'bold', fontSize: '14px' } },
	xAxis: { gridLineWidth: 1, labels: { style: { fontSize: '14px' } } },
	yAxis: {
		minorTickInterval: 'auto',
		title: { style: { textTransform: 'uppercase' } },
		labels: { style: { fontSize: '14px' } }
	},
	exporting: { menuItemDefinitions: { downloadPNG: { onclick: exportChartImage } } }
});