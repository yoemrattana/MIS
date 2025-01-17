function viewModel() {
	var self = this;
	var completeness = $('#percent').val();
	var currentMonth = moment().format('MMM');
	var yearGuest;
	var monthToGuest;

	if (currentMonth.in('Jan', 'Feb', 'Mar') || (currentMonth == 'Apr' && completeness < 90)) {
		yearGuest = moment().year() - 1;
		monthToGuest = 'Dec';
	}
	else if (currentMonth.in('Apr', 'May', 'Jun') || (currentMonth == 'Jul' && completeness < 90)) {
		yearGuest = moment().year();
		monthToGuest = 'Mar';
	}
	else if (currentMonth.in('Jul', 'Aug', 'Sep') || (currentMonth == 'Oct' && completeness < 90)) {
		yearGuest = moment().year();
		monthToGuest = 'Jun';
	}
	else if (currentMonth.in('Oct', 'Nov', 'Dec')) {
		yearGuest = moment().year();
		monthToGuest = 'Sep';
	}

	self.mainData = {};
	self.isOptChange = ko.observable(false);
	self.isGuest = app.user.role == "GUEST";
	self.yearList = ko.observableArray();
	self.year = ko.observable(moment().year());
	self.provList = ko.observableArray();
	self.prov = ko.observable();
	self.monthList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    self.from = ko.observable('Jan');
    self.to = ko.observable(moment().format('MMM'));
	self.filterMode = ko.observable();
	self.tab = ko.observable();
    self.loaded = ko.observable(false);
    
	self.lastSearch = ko.observable({ prov: self.prov(), year: self.year(), from: self.from(), to: self.to() });

	self.surveillanceList = ko.observableArray();
	self.surveillanceFooter = ko.observable();
	self.tableSpecieProvinceMonth = ko.observableArray();
	self.tableSevereMonth = ko.observableArray();
	self.tableAgeSex = ko.observableArray();
	self.tableAgeSexSpecie = ko.observableArray();
	self.tableAgeSexSevere = ko.observableArray();

	var loadedTabs = [];

	if (self.isGuest) {
		self.yearList.push(self.year() - 1, self.year());
	} else {
		for (var i = 2018; i <= self.year(); i++) {
			self.yearList.push(i);
		}
	}

	app.vmSubs.forEach(sub => sub(self));
    
    self.menuClick = function (root, event) {
		$('.btn-menu').removeClass('active btn-default');
		$('.btn-menu').each(function () {
			this == event.currentTarget ? $(this).addClass('active') : $(this).addClass('btn-default');
		});

		var tabName = $(event.currentTarget).text();
		self.tab(tabName);
        
		if (!loadedTabs.contain(tabName)) {
			loadedTabs.push(tabName);
			self.loaded(false);
			self['showTab' + tabName.replace(/ /g, '')]();
        } 
	};
    
	app.getPlace(['pv', 'od', 'hc', 'vl'], function (rs) {
		self.place = rs;
		self.place.pv = self.place.pv.filter(r => r.target == 1);
		self.place.od = self.place.od.filter(r => r.target == 1);
		self.targetOD = self.place.od.map(r => r.code);

		if (app.user.prov != '') self.place.pv = self.place.pv.filter(r => app.user.prov.contain(r.code));
		if (app.user.od != '') self.place.od = self.place.od.filter(r => r.code == app.user.od);

        var od55 = {
            code: 0,
            name: '55 ODs',
            nameK: '55 ODs',
            target: 1
        }
        if (self.place.pv.length > 1) {
            self.place.pv.unshift(od55)
        }

		self.pvList(self.place.pv);
        self.provList(self.place.pv);

		var intenProv = ['05', '10', '11', '13', '15', '16', '18', '19'];
		self.visibleInten(self.place.pv.some(r => intenProv.contain(r.code)));

		//load map data in zip file
		app.readFileInZip($('#chartODBorder').val(), 'chartODBorder.js', function (script) {
			eval(script); //run script

			app.readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
				eval(script);
				
				app.readFileInZip($('#chartNeighbourBorder').val(), function (arr) {
					arr.forEach(r => {
						try {
							eval(r.value);
						} catch (err) {
							console.log(err);
						}
					});
					self.submit(true);

				}, undefined, false);
			}, false);
		}, false);
	}, false);
    
	self.year.subscribe(function (y) {
		self.from('Jan');
		y < moment().year() ? self.to('Dec') : self.to(moment().format('MMM'));
	});

    self.submit = function () {
        if (self.prov() == 0) return;
		var submit = {
			year: self.year(),
			from: self.monthList.indexOf(self.from()) + 1,
			to: self.monthList.indexOf(self.to()) + 1,
			prov: isnull(self.prov(), ''),
			filterDateCase: self.filterMode()
		};

		self.lastSubmit = submit;
		self.isOptChange(false);
		self.ip('2');
		self.lastSearch({ prov: self.prov(), year: self.year(), from: self.from(), to: self.to() });
		loadedTabs = [];

		$('.btn-tab.active').click();
	};

	self.showTabSurveillance = function () {
		app.ajax('/Dashboard/tabSurveillance/', self.lastSubmit).done(function (rs) {
			self.mainData.od = rs;
			self.surveillanceList(rs.filter(r => r.Level != 3));
			self.surveillanceFooter(rs.find(r => r.Level == 3));
			self.loaded(true);
		});
	};

	self.showTabTable = function () {
		app.ajax('/Dashboard/tabTable/', self.lastSubmit).done(function (rs) {
			self.tableSpecieProvinceMonth(rs.tableSpecieProvinceMonth);
			self.tableSevereMonth(rs.tableSevereMonth);
			self.tableAgeSex(rs.tableAgeSex);
			self.tableAgeSexSpecie(rs.tableAgeSexSpecie);
			self.tableAgeSexSevere(rs.tableAgeSexSevere);

			self.loaded(true);
		});
	};

	self.changeOpt = function () {
		self.isOptChange(true);
	};

	self.tickChbox = function (className, chart) {
		$(className).click(function () {
			if (!isEmptyObject(chart)) {
				var id = $(this).attr('id');
				series = chart.get(id);
				series.setVisible(!series.visible);
			}
		});
	};

	self.fixValue = function (value, column, indicators) {
		if (indicators.in('Data Completeness')) {
			if (column.in('MAllLastYear', 'MAllThisYear', 'FAllLastYear', 'FAllThisYear')) return '';

			if (column.indexOf('Change') == -1) {
				return toFloat(value).toFixed(0) + '%';
			} else {
				return '';
			}
		}

		if (indicators.in('Malaria Suspect')) {
			if (column.in('MAllLastYear', 'MAllThisYear', 'FAllLastYear', 'FAllThisYear')) return '';
		}

        if (indicators == 'Malaria Patient (Persons)') {
            if (column.in('MAllThisYear', 'FAllThisYear', 'AllThisYear', 'HisThisYear', 'VmwThisYear') && self.lastSearch().year < 2022) return 'N/A';
            if (column.in('MAllLastYear', 'FAllLastYear', 'AllLastYear', 'HisLastYear', 'VmwLastYear') && self.lastSearch().year - 1 < 2022) return 'N/A';

            if (column.indexOf('Change') > -1 &&  self.lastSearch().year-1 < 2023) {
                return '';
            } 
        }

		if (indicators == 'Cases Referred to Hospital') {
			if (column.indexOf('Change') > -1) return '';
		}

		if (indicators == 'ABER' || indicators == 'Positive Rate') {
			if (column.indexOf('Change') == -1) {
				return toFloat(value).toFixed(2) + '%';
			} else {
				return '';
			}
		}

		if (column.indexOf('Change') > -1) {
			return toFloat(value).toFixed(0) + '%';
		} else {
			return comma(toFloat(toFloat(value).toFixed(2)));
		}
	};

	self.removeCellBorder = function (column) {
		return column.indexOf('Year') > -1 && column != 'PopThisYear' ? '1px solid white' : '';
	};

	self.highlight = function (value, column, indicators) {
		if (column.indexOf('Change') == -1) return '';
        if (['Data Completeness', 'ABER', 'Positive Rate', 'Cases Referred to Hospital'].contain(indicators)) return '';

        if (indicators == 'Malaria Patient (Persons)') {
            if (column.indexOf('Change') > -1 && self.lastSearch().year - 1 < 2023) return '';
        }

		value = parseInt(value);

		if (indicators == 'Test') {
			if (value < 0) return 'label label-danger';
			return 'label label-success';
		}

		if (value > 0) return 'label label-danger';
		if (value <= -30) return 'label label-success';

		return '';
	};

	self.getPvName = function (code) {
		return self.place.pv.find(r => r.code == code)?.name;
	};

	self.exportExcel = function () {
		if (self.isOptChange()) {
			app.showMsg('Warning!', 'សូមចុចលើ <span style="color:blue"> ប៊ូតុង View</span> ជាមុនសិន! <br/> Please click <span style="color:blue">View Button</span> first!');
			return;
		}
		app.showLoader();

		var submit = {
			tab: self.tab(),
			images: []
		};
		var ids = [];

		if (self.tab() == 'Overview') {
			ids = [
				'exportOverview1',
				'chartCasePie',
				'exportOverview2',
				'chartTop30HFbyType',
				'chartTop30HFbySpecies',
				'chartTop30Vill',
				'treated',
				'severe',
				'test',
				'chartCaseDeath',
				'chartSpecie',
				'chartSexAge',
				'chartSpecieProvince',
				'chartIncidentMortality'
			];
		}
		else if (self.tab() == 'Surveillance') {
			ids = ['exportSurveillance'];
		}
		else if (self.tab() == 'Border') {
			ids = [
				'chartborder',
				'mapCommuneBorder',
				'mapCommuneBorderPfMix',
				'mapCommuneBorderPv',
			];
		}
		else if (self.tab() == 'Map') {
			ids = [
				self.exportFociMap,
				'exportMap',
				'chartTop10OD',
				'mapOD',
				self.exportHotspotMap,
				'mapAber',
				'mapAPI'
			];
		}
		else if (self.tab() == 'Table') {
			ids = ['exportTable'];
		}
		else if (self.tab() == 'CNM Outbreak Detection Tool') {
			ids = ['OutbreakDetection'];
		}
		else if (self.tab() == 'Intensification Plan') {
			ids = [
				'chartIntenSpecies',
				'chartIntenFacility',
				'chartIntenRate',
				'chartIntenTop10Vill',
				'chartSLDP',
				'chartIntenMap'
			];
		}
		else if (self.tab() == 'PF Map') {
			ids = [
				self.exportPFMap,
				'exportPfList'
			];
		}

		ids = ids.filter(id => (typeof id == 'string' ? document.getElementById(id) : id) != null);
		var i = 0;

		function convertToImage() {
			var id = ids[i];
			if (typeof id == 'function') {
				id(onSuccess);
			} else if (id.indexOf('export') == 0) {
				domtoimage.toPng(document.getElementById(id), { bgcolor: 'white' }).then(onSuccess);
			} else {
				exportChartImage($('#' + id).highcharts(), onSuccess);
			}
		}

		function onSuccess(imageurl) {
			var base64 = imageurl.substr(imageurl.indexOf(',') + 1);
			submit.images.push(base64);
			i++;
			i < ids.length ? convertToImage() : sendToServer();
		}

		function sendToServer() {
			app.downloadBlob('/Dashboard/exportExcel', submit).done(function (blob) {
				var filename = 'Dashboard ' + self.tab() + '.xlsx';
				saveAs(blob, filename);
			});
		}

		setTimeout(convertToImage);
	};

	function isEmptyObject(obj) {
		var name;
		for (name in obj) {
			if (obj.hasOwnProperty(name)) {
				return false;
			}
		}
		return true;
	}

};

function getChartImageUrl(chart, scale, onSuccess) {
	var onError = console.log;
	if (chart == undefined) return;
	var chartOptions = { chart: { borderWidth: 2, borderColor: '#01c0c8', backgroundColor: 'white' } };
	chart.getSVGForLocalExport(undefined, chartOptions, onError, function (svg) {
		var svgurl = Highcharts.svgToDataUrl(svg);
		Highcharts.imageToDataUrl(svgurl, 'image/png', null, scale, onSuccess, onError, onError, onError);
	});
}

function exportChartImage(chart, onSuccess) {
	if (onSuccess === undefined) chart = this;
	var scale = onSuccess === undefined ? 2 : 1;

	getChartImageUrl(chart, scale, function (image) {
		var ex = chart.options.exporting;
		var images = [{ src: image }];

		if (app.user.role != 'AU') {
			var imgsrc = scale == 1 ? '/media/images/background.png' : '/media/images/background-x2.png';
			var x = ex.sourceWidth * scale / 2 - (200 * scale / 2);
			var y = ex.sourceHeight * scale / 2 - (220 * scale / 2);

			if (chart.renderTo.id == 'OutbreakDetection') {
				imgsrc = '/media/images/background-moru.png';
				x = ex.sourceWidth * scale / 2 - 207;
				y = ex.sourceHeight * scale / 2 - 100;
			}
			images.push({ src: imgsrc, opacity: 0.3, x: x, y: y });
		}

		mergeImages(images).then(function (result) {
			onSuccess === undefined ? Highcharts.downloadURL(result, chart.options.title.text.trim()) : onSuccess(result);
		});
	});
}

Highcharts.setOptions({
	chart: {
		style: { fontFamily: 'Calibri' },
		renderTo: 'container',
		events: {
			load: function () {
				if (this.renderTo.id == '') return;
				if (this.renderTo.id == 'stockMenu') return;

				if (app.user.role != 'AU') {
					var imgurl = '/media/images/background.png';
					var w = 200;
					var x = this.chartWidth / 2 - 100;
					var y = this.chartHeight / 2 - 110
					var opacity = this.renderTo.getAttribute('logoopacity');
					opacity = opacity == null ? 0.1 : parseFloat(opacity);
					if (this.renderTo.id == 'OutbreakDetection') {
						imgurl = '/media/images/background-moru.png';
						w = 414;
						x = this.chartWidth / 2 - 207;
					}
					this.renderer.image(imgurl, x, y, w, 216).attr({ opacity: opacity }).add();
				}
			}
		}
	},
	title: { style: { fontSize: '16px', fontWeight: 'bold', textTransform: 'uppercase', border: '1 solid #404048' } },
	tooltip: { borderWidth: 0, backgroundColor: 'rgba(219,219,216,0.8)', shadow: false },
	legend: { itemStyle: { fontWeight: 'bold', fontSize: '13px' }, symbolRadius: 0, },
	xAxis: {
		gridLineWidth: 0, minorGridLineWidth: 0, gridLineColor: "white",
		labels: { style: { fontSize: '12px', fontWeight: 'bold', color: 'black' } }, lineColor: '#00B0F0', lineWidth: 2,
		title: { style: { fontFamily: '"Calibri"', fontWeight: 500, color: 'black' } }
	},
	yAxis: {
		gridLineWidth: 0,
		minorGridLineWidth: 0,
		minorTickInterval: 'auto',
		title: { style: { textTransform: 'camelcase', fontFamily: '"Calibri"', fontWeight: 500, color: 'black' } },
		labels: { style: { fontSize: '12px', fontWeight: 'bold', color: 'black' } },
		lineWidth: 2, lineColor: '#00B0F0'
	},
	background2: '#F0F0EA',
	exporting: { menuItemDefinitions: { downloadPNG: { onclick: exportChartImage } } },
	plotOptions: { line: { marker: { enabled: false } }, series: { borderColor: '#00B0F0' } },
});