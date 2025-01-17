if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {
	self.dailyCase = ko.observable();
	self.cases = ko.observableArray();
	self.monthlyCase = ko.observableArray();
    self.netList = ko.observableArray();
    self.riskPop = ko.observableArray();
	self.caseList = ko.observableArray();
	self.caseNList = ko.observableArray();
	self.caseInvestigate = ko.observableArray();
	self.caseCountryList = ko.observableArray();
	self.foci = ko.observable();
	self.lastmileList = ko.observableArray();
	self.radicalCure = ko.observable();
	self.overviewPart1Ready = ko.observable(false);
	self.overviewPart2Ready = ko.observable(false);
	self.overviewPart3Ready = ko.observable(false);
	self.title = ko.observable();
	self.slideShow = ko.observableArray();
	self.todayVisit = ko.observable(0);
	self.yesterdayVisit = ko.observable(0);
	var months = ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'];
	var categories = [];
	var fromYear = 0;
	var displayWait = false;

	self.showTabOverview = function () {
		function preparePart1() {
            getSlideShow(self.mainData.slides);
            self.riskPop(self.mainData.riskPop)
			self.netList(self.mainData.net);
			self.caseList(self.mainData.cases);
			self.caseInvestigate(self.mainData.caseInvestigate);
			self.caseCountryList(self.mainData.casesCountry);
			self.foci(self.mainData.foci);
			self.lastmileList(self.mainData.lastMile);
			self.radicalCure(self.mainData.radicalCure);

			categories = [];
			fromYear = self.year() - 3 <= 2017 ? 2018 : self.year() - 3;
			for (var y = fromYear; y <= self.year() ; y++) {
				categories.push({ name: y, categories: months });
			}

			drawTreatedChart();
			drawSevereChart();
			drawTestChart();
			drawChartCaseDeath();
			drawChartSpecie();
			drawChartSexAge();
			drawChartSpecieProvince();
			drawChartIncidentMortality();
			drawNotify();
			drawRCD();
			drawFoci();
			drawRadicalCure();
			drawLastmileChart();
			self.drawChartTop30Vill();
			self.drawChartTop30HFbySpecies();
		}
		app.hideLoader()
		self.overviewPart2Ready(false);
		app.ajax('/Dashboard/tabOverview/1', self.lastSubmit, displayWait).done(function (rs) {
            Object.keys(rs).forEach(key => self.mainData[key] = rs[key]);
            if (self.mainData.mneElimination == null) {
                self.mainData.mneElimination = {
                    Classify: 0,
                    Foci: 0,
                    Foci7d: 0,
                    FociNeed: 0,
                    Notify24: 0,
                    Positive: 0,
                    Racd: 0,
                    Racd3d: 0,
                    RacdNeed: 0,
                }
            }
            if (self.mainData.riskPop == null) {
                self.mainData.riskPop = {
                    High: 'N/A',
                    Medium: 'N/A',
                    Low: 'N/A',
                    No: 'N/A'
                }
            }
			preparePart1();
			self.loaded(true);
			self.overviewPart1Ready(true);
			app.ajax('/Dashboard/tabOverview/2', self.lastSubmit, displayWait).done(function (rs) {
				self.dailyCase(rs.dailyCase[0]);
				self.todayVisit(rs.visit.today);
				self.yesterdayVisit(rs.visit.yesterday);
				self.overviewPart2Ready(true);

				app.ajax('/Dashboard/tabOverview/3', self.lastSubmit, displayWait).done(function (rs) {
					self.monthlyCase(rs.monthlyCase);
					drawChartPf();
					drawChartPv();
					drawChartMix();
					drawChartPmPoPk();
					self.overviewPart3Ready(true);
					displayWait = true;
				})
			})
		});
	};

	getSlideShow = function(slides) {
		var rs = slides.map((r) => {
			r.image = "/media/blog/" + r.Thumbnail;
			r.description = r.Title;
			return r;
		})

        self.slideShow(rs);

        if (!isMobile && rs.length > 1) {
            nineslider(document.getElementById("slide"), {});
        }
	}

	self.duration = self.from() + ' - ' + self.to() + ' ' + self.year();

	function drawChartPf() {
		var model = self.monthlyCase();
		Highcharts.chart('pfChart', {
			title: { text: 'Pf', },
			chart: { type: 'column', height: 300, },
			xAxis: { categories: ['Pf'] },
			yAxis: { min: 0, title: { text: 'Number of Pf' } },
			plotOptions: {
				column: { pointPadding: 0.2, borderWidth: 0 },
			},
			series: [
                { name: moment().add(-1, 'M').format('MMM'), data: model.filter(r => r.Peroid == 'lastM').map(r => r.Pf), events: { click: function () { self.showMonthlyCase('F', moment().add(-1, 'M')) } } },
                { name: moment().format('MMM'), data: model.filter(r => r.Peroid == 'thisM').map(r => r.Pf), events: { click: function () { self.showMonthlyCase('F', moment()) } } }
			]
		});
	}

	function drawChartPv() {
		var model = self.monthlyCase();
		Highcharts.chart('pvChart', {
			title: {
				text: 'Pv',
			},
			chart: {
				type: 'column',
				height: 300,
			},
			xAxis: {
				categories: ['Pv'],
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Number of Pv'
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [
                {
                	name: moment().add(-1, 'M').format('MMM'),
                	data: model.filter(r => r.Peroid == 'lastM').map(r => r.Pv),
                	events: { click: function () { self.showMonthlyCase('V', moment().add(-1, 'M')) } }
                },
                {
                	name: moment().format('MMM'),
                	data: model.filter(r => r.Peroid == 'thisM').map(r => r.Pv),
                	events: { click: function () { self.showMonthlyCase('V', moment()) } }
                }
			]
		});

	}

	function drawChartMix() {
		var model = self.monthlyCase();
		Highcharts.chart('mixChart', {
			title: {
				text: 'Mix <span style="font-size:14px">(PF + PV)</span>',
				HTML: true
			},
			chart: {
				type: 'column',
				height: 300,
			},
			xAxis: {
				categories: ['Mix'],
				crosshair: true,
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Number of Mix'
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [
                {
                	name: moment().add(-1, 'M').format('MMM'),
                	data: model.filter(r => r.Peroid == 'lastM').map(r => r.Mix),
                	events: { click: function () { self.showMonthlyCase('M', moment().add(-1, 'M')) } }
                },
                {
                	name: moment().format('MMM'),
                	data: model.filter(r => r.Peroid == 'thisM').map(r => r.Mix),
                	events: { click: function () { self.showMonthlyCase('M', moment()) } }
                }
			]
		});

	}

	function drawChartPmPoPk() {
		var model = self.monthlyCase();
		Highcharts.chart('pmpopkChart', {
			title: {
				text: 'PM + PO + PK',
			},
			chart: {
				type: 'column',
				height: 300,
			},
			xAxis: {
				categories: ['PM + PO + PK'],
				crosshair: true,
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Number of PM + PO + PK'
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [
                {
                	name: moment().add(-1, 'M').format('MMM'),
                	data: model.filter(r => r.Peroid == 'lastM').map(r => r.PmPoPk),
                	events: { click: function () { self.showMonthlyCase("A','O','K", moment().add(-1, 'M')) } }
                },
                {
                	name: moment().format('MMM'),
                	data: model.filter(r => r.Peroid == 'thisM').map(r => r.PmPoPk),
                	events: { click: function () { self.showMonthlyCase("A', 'O', 'K", moment()) } }
                }
			]
		});

	}

	function drawNotify() {
		var model = self.mainData.mneElimination;
        if (model == null) return;
		Highcharts.chart('notify', {
			chart: { type: 'solidgauge', height: 350, marginLeft: -220 },
			title: { text: 'Notified Case', style: { fontSize: '24px' } },
			tooltip: {
				borderWidth: 0,
				backgroundColor: 'none',
				shadow: false,
				style: {
					fontSize: '16px'
				},
				valueSuffix: '%',
				pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}</span>',
				positioner: function (labelWidth) {
					return {
						x: (this.chart.chartWidth - labelWidth) / 2,
						y: (this.chart.plotHeight / 2) + 15
					};
				}
			},
			exporting: { sourceWidth: 700 },

			pane: {
				startAngle: 140,
				endAngle: 450,
				background: [
                    {
                    	outerRadius: '100%',
                    	innerRadius: '90%',
                    	backgroundColor: Highcharts.color('#FFFFFF')
                            .setOpacity(0.3)
                            .get(),
                    	borderWidth: 0,
                    	borderColor: '#FFFFFF',
                    },
                    {
                    	outerRadius: '88%',
                    	innerRadius: '78%',
                    	backgroundColor: Highcharts.color('#cccccc')
                            .setOpacity(0.7)
                            .get(),
                    	borderWidth: 0,
                    	borderColor: '#FFFFFF',
                    	shape: 'arc'
                    },
                    {
                    	outerRadius: '76%',
                    	innerRadius: '66%',
                    	backgroundColor: Highcharts.color('#cccccc')
                            .setOpacity(0.7)
                            .get(),
                    	borderWidth: 0,
                    	shape: 'arc'
                    }
				],
			},

			yAxis: { min: 0, max: 100, lineWidth: 0, tickPositions: [] },

			legend: {
				layout: "vertical",
				x: 100,
				verticalAlign: "middle",
				itemMarginTop: 5,
				itemStyle: {
					fontSize: "15px",
					fontWeight: 'bold',
				},
				itemMarginBottom: 5,
				labelFormatter: function () {
					return '<span style="color:' + this.userOptions.data[0].color + '">' + this.name + '</span>';
				},
				symbolHeight: 0.001
			},

			plotOptions: {
				solidgauge: {
					dataLabels: {
						enabled: false
					},
					linecap: 'round',
					stickyTracking: true,
					rounded: false
				}
			},

			series: [{
				name: 'Positive Cases',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[0],
					radius: '100%',
					innerRadius: '90%',
					y: model.Positive == 0 ? 0 : 100
				}]
			}, {
				name: 'Notified/Classified Cases',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[1],
					radius: '88%',
					innerRadius: '78%',
                    y: parseInt((model.Classify / model.Positive * 100).toFixed(0))
				}]
			}, {
				name: 'Notified/Classified Cases < 24h',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[2],
					radius: '76%',
					innerRadius: '66%',
                    y: parseInt((model.Notify24 / model.Positive * 100).toFixed(0))
				}]
			}]
		}, function () {
			this.series.forEach((s, i) => {
				var e = $(s.legendItem.element).find('tspan');
				e.text(e.text() + ': ' + (i == 0 ? model.Positive : s.yData[0] + '%'));
			});
		})
	}

	function drawRCD() {
		var model = self.mainData.mneElimination;
        if (model == null) return;
		Highcharts.chart('reactiveCaseDetection', {
			chart: { type: 'solidgauge', height: 350, marginLeft: -220 },
			title: { text: 'Reactive Case Detection', style: { fontSize: '24px' } },
			tooltip: {
				borderWidth: 0,
				backgroundColor: 'none',
				shadow: false,
				style: {
					fontSize: '16px'
				},
				valueSuffix: '%',
				pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}</span>',
				positioner: function (labelWidth) {
					return {
						x: (this.chart.chartWidth - labelWidth) / 2,
						y: (this.chart.plotHeight / 2) + 15
					};
				}
			},

			pane: {
				startAngle: 140,
				endAngle: 450,
				background: [
                    {
                    	outerRadius: '100%',
                    	innerRadius: '90%',
                    	backgroundColor: Highcharts.color('#FFFFFF')
                            .setOpacity(0.001)
                            .get(),
                    	borderWidth: 1,
                    	borderColor: '#FFFFFF',
                    	shape: 'arc'
                    },
                    {
                    	outerRadius: '88%',
                    	innerRadius: '78%',
                    	backgroundColor: Highcharts.color('#cccccc')
                            .setOpacity(0.7)
                            .get(),
                    	borderWidth: 1,
                    	borderColor: '#FFFFFF',
                    	shape: 'arc'
                    },
                    {
                    	outerRadius: '76%',
                    	innerRadius: '66%',
                    	backgroundColor: Highcharts.color('#cccccc')
                            .setOpacity(0.7)
                            .get(),
                    	borderWidth: 0,
                    	shape: 'arc'
                    }
				],
			},

			yAxis: { min: 0, max: 100, lineWidth: 0, tickPositions: [] },

			legend: {
				layout: "vertical",
				x: 80,
				verticalAlign: "middle",
				itemMarginTop: 5,
				itemStyle: {
					fontSize: "15px",
					fontWeight: 'bold',
				},
				itemMarginBottom: 5,
				labelFormatter: function () {
					return '<span style="color:' + this.userOptions.data[0].color + '">' + this.name + '</span>';
				},
				symbolHeight: 0.001
			},

			plotOptions: {
				solidgauge: {
					dataLabels: {
						enabled: false
					},
					stickyTracking: true,
					rounded: false
				}
			},

			series: [{
				name: 'Eligible RCD',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[0],
					radius: '100%',
					innerRadius: '90%',
					y: model.RacdNeed == 0 ? 0 : 100
				}]
			}, {
				name: 'RCD',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[1],
					radius: '88%',
					innerRadius: '78%',
                    y: model.RacdNeed == 0 ? 0 : parseInt((model.Racd / model.RacdNeed * 100).toFixed(0))
				}]
			}, {
				name: 'RCD < 3 days',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[2],
					radius: '76%',
                    innerRadius: '66%',
                    y: model.RacdNeed == 0 ? 0 : parseInt((model.Racd3d / model.RacdNeed * 100).toFixed(0))
				}]
			}]
		}, function () {
			this.series.forEach((s, i) => {
				var e = $(s.legendItem.element).find('tspan');
				e.text(e.text() + ': ' + (i == 0 ? model.RacdNeed + ' Cases' : s.yData[0] + '%'));
			});
		})
	}

	function drawFoci() {
		var model = self.mainData.mneElimination;
        if (model == null) return;
		Highcharts.chart('foci', {
			chart: { type: 'solidgauge', height: 350, marginLeft: -220 },
			title: { text: 'Foci Investigation', style: { fontSize: '24px' } },
			tooltip: {
				borderWidth: 0,
				backgroundColor: 'none',
				shadow: false,
				style: {
					fontSize: '16px'
				},
				valueSuffix: '%',
				pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}</span>',
				positioner: function (labelWidth) {
					return {
						x: (this.chart.chartWidth - labelWidth) / 2,
						y: (this.chart.plotHeight / 2) + 15
					};
				}
			},
			exporting: { sourceWidth: 800 },

			pane: {
				startAngle: 140,
				endAngle: 450,
				background: [
                    {
                    	outerRadius: '100%',
                    	innerRadius: '90%',
                    	backgroundColor: Highcharts.color('#FFFFFF')
                            .setOpacity(0.001)
                            .get(),
                    	borderWidth: 1,
                    	borderColor: '#FFFFFF',
                    	shape: 'arc'
                    },
                    {
                    	outerRadius: '88%',
                    	innerRadius: '78%',
                    	backgroundColor: Highcharts.color('#cccccc')
                            .setOpacity(0.7)
                            .get(),
                    	borderWidth: 1,
                    	borderColor: '#FFFFFF',
                    	shape: 'arc'
                    },
                    {
                    	outerRadius: '76%',
                    	innerRadius: '66%',
                    	backgroundColor: Highcharts.color('#cccccc')
                            .setOpacity(0.7)
                            .get(),
                    	borderWidth: 0,
                    	shape: 'arc'
                    }
				],
			},

			yAxis: { min: 0, max: 100, lineWidth: 0, tickPositions: [] },

			legend: {
				layout: "vertical",
				x: 80,
				verticalAlign: "middle",
				itemMarginTop: 5,
				itemMarginBottom: 5,
				itemStyle: {
					fontSize: "15px",
					fontWeight: 'bold',
				},
				labelFormatter: function () {
					return '<span style="color:' + this.userOptions.data[0].color + '">' + this.name + '</span>';
				},
				symbolHeight: 0.001
			},

			plotOptions: {
				solidgauge: {
					dataLabels: {
						enabled: false
					},
					stickyTracking: true,
					rounded: false
				}
			},

			series: [{
				name: 'Eligible Foci Investigation',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[0],
					radius: '100%',
					innerRadius: '90%',
					y: model.FociNeed == 0 ? 0 : 100
				}]
			}, {
				name: 'Foci Investigation',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[1],
					radius: '88%',
					innerRadius: '78%',
                    y: model.FociNeed == 0 ? 0 : parseInt((model.Foci / model.FociNeed * 100).toFixed(0))
				}]
			}, {
				name: 'Foci Response < 7 days',
				showInLegend: true,
				data: [{
					color: Highcharts.getOptions().colors[2],
					radius: '76%',
					innerRadius: '66%',
                    y: model.FociNeed == 0 ? 0 : parseInt((model.Foci7d / model.FociNeed * 100).toFixed(0))
				}]
			}]
		}, function () {
			this.series.forEach((s, i) => {
				var e = $(s.legendItem.element).find('tspan');
				e.text(e.text() + ': ' + (i == 0 ? model.FociNeed + ' Cases' : s.yData[0] + '%'));
			});
		})
	}

	function drawRadicalCure() {
		var model = self.mainData.radicalCure;

		Highcharts.chart('radicalCure', {
			chart: { type: 'solidgauge', marginLeft: -150 },
			title: { text: 'Pv Radical Cure', style: { fontSize: '24px' } },
			tooltip: {
				borderWidth: 0,
				backgroundColor: 'none',
				shadow: false,
				style: {
					fontSize: '16px'
				},
				valueSuffix: '%',
				pointFormat: '{series.name}<br><span style="font-size:2em; color: {point.color}; font-weight: bold">{point.y}</span>',
				positioner: function (labelWidth) {
					return {
						x: (this.chart.chartWidth - labelWidth) / 2,
						y: (this.chart.plotHeight / 2) + 15
					};
				}
			},
			exporting: { sourceWidth: 700 },

			pane: {
				center: ['50%', '50%'],
				size: '90%',
				startAngle: 140,
				endAngle: 450,
				background: [
                    {
                    	outerRadius: '100%',
                    	innerRadius: '90%',
                    	backgroundColor: Highcharts.color('#FFFFFF')
                            .setOpacity(0.001)
                            .get(),
                    	borderWidth: 1,
                    	borderColor: '#FFFFFF',
                    	shape: 'arc'
                    },
                {
                	outerRadius: '88%',
                	innerRadius: '78%',
                	backgroundColor: Highcharts.color('#cccccc')
                        .setOpacity(0.7)
                        .get(),
                	borderWidth: 1,
                	borderColor: '#FFFFFF',
                	shape: 'arc'
                },
                {
                	outerRadius: '76%',
                	innerRadius: '66%',
                	backgroundColor: Highcharts.color('#cccccc')
                        .setOpacity(0.7)
                        .get(),
                	borderWidth: 1,
                	borderColor: '#FFFFFF',
                	shape: 'arc'
                },
                {
                	outerRadius: '64%',
                	innerRadius: '54%',
                	backgroundColor: Highcharts.color('#cccccc')
                        .setOpacity(0.7)
                        .get(),
                	borderWidth: 0,
                	shape: 'arc'
                },
                {
                	outerRadius: '52%',
                	innerRadius: '42%',
                	backgroundColor: Highcharts.color('#cccccc')
                            .setOpacity(0.7)
                            .get(),
                	borderWidth: 0,
                	shape: 'arc'
                }
				],
			},

			yAxis: { min: 0, max: 100, lineWidth: 0, tickPositions: [] },

			legend: {
				layout: "vertical",
				x: 130,
				verticalAlign: "middle",
				itemMarginTop: 5,
				itemStyle: {
					fontSize: "15px",
					fontWeight: 'bold',
				},
				itemMarginBottom: 5,
				labelFormatter: function () {
					return '<span style="color:' + this.userOptions.data[0].color + '">' + this.name + '</span>';
				},
				symbolHeight: 0.001
			},

			plotOptions: {
				solidgauge: {
					dataLabels: {
						enabled: false
					},
					stickyTracking: true,
					rounded: false
				}
			},

			series: [
                {
                	name: 'Pv + Mix Cases',
                	showInLegend: true,
                	data: [{
                		color: Highcharts.getOptions().colors[0],
                		radius: '100%',
                		innerRadius: '90%',
                		y: model.Pv == 0 ? 0 : 100
                	}]
                },
                {
                	name: 'Eligible G6PD',
                	showInLegend: true,
                	data: [{
                		color: Highcharts.getOptions().colors[1],
                		radius: '88%',
                		innerRadius: '78%',
                        y: parseInt((model.EligibleG6PD / model.Pv * 100).toFixed(0))
                	}]
                }, {
                	name: 'G6PD Test',
                	showInLegend: true,
                	data: [{
                		color: Highcharts.getOptions().colors[2],
                		radius: '76%',
                		innerRadius: '66%',
                        y: parseInt((model.G6PDTest / model.EligibleG6PD * 100).toFixed(0))
                	}]
                }, {
                	name: 'Normal G6PD',
                	showInLegend: true,
                	data: [{
                		color: Highcharts.getOptions().colors[3],
                		radius: '64%',
                		innerRadius: '54%',
                        y: parseInt((model.G6PDNormal / model.G6PDTest * 100).toFixed(0))
                	}]
                }, {
                	name: 'Primaquine',
                	showInLegend: true,
                	data: [{
                		color: Highcharts.getOptions().colors[4],
                		radius: '52%',
                		innerRadius: '42%',
                        y: parseInt((model.Primaquine / model.G6PDNormal * 100).toFixed(0))
                	}]
                }
			]
		}, function () {
			this.series.forEach((s, i) => {
				var e = $(s.legendItem.element).find('tspan');
				e.text(e.text() + ': ' + (i == 0 ? model.Pv : s.yData[0] + '%'));
			});
		})
	}

	function drawLastmileChart() {
		var model = self.mainData.lastMile;
		$('#lastmileChart').highcharts({
			chart: { type: 'column', },
			title: { text: 'Last mile (2022 - 2023)' },
			subtitle: { text: '.' },
			xAxis: { categories: ['Last mile'], crosshair: true, gridLineWidth: 1 },
			tooltip: { shared: true, enabled: !self.isGuest },
			plotOptions: { series: { pointWidth: 30, pointPadding: 1, } },
			exporting: { sourceWidth: 1600, sourceHeight: 400 },
			series: [
                { index: 1, id: 'tda-eli', name: 'TDA Eligible', data: model.filter(r => r.Criteria == 'TDA Eligible').map(r => parseFloat(r.Value)) },
                { index: 2, id: 'tda', name: 'TDA', data: model.filter(r => r.Criteria == 'TDA').map(r => parseFloat(r.Value)) },
                { index: 3, id: 'ipt-eli', name: 'IPT Eligible', data: model.filter(r => r.Criteria == 'IPT Eligible').map(r => parseFloat(r.Value)) },
                { index: 4, id: 'ipt', name: 'IPT', data: model.filter(r => r.Criteria == 'IPT').map(r => parseFloat(r.Value)) }
			]
		}, function (chart) {
			self.tickChbox('.lastmCbox', chart);
		});
	}

	function drawTreatedChart() {
		var model = self.mainData.chart;
		var duration = 'Jan ' + fromYear + ' - ' + self.to() + ' ' + self.year();

		$('#treated').highcharts({
			chart: { type: 'spline' },
			title: { text: 'Treated malaria cases from HF and VMW by month, ' + duration },
			subtitle: { text: '.' },
			xAxis: { categories: categories, crosshair: true },
			yAxis: { title: { text: 'Number of Cases' } },
			tooltip: { shared: true, enabled: !self.isGuest },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
                { id: 'HF', name: 'HF', data: model.map(r => parseInt(r.HIS)) },
                { id: 'VMW', name: 'VMW', data: model.map(r => parseInt(r.VMW)) },
                { id: 'All', name: 'All', data: model.map(r => parseInt(r.All)) }
			]
		}, function (chart) {
			self.tickChbox('.lgCbox', chart);
		});
	}

	function drawSevereChart() {
		var model = self.mainData.chart;
		var duration = 'Jan ' + fromYear + ' - ' + self.to() + ' ' + self.year();

		$('#severe').highcharts({
			chart: { type: 'spline' },
			title: { text: 'Severe malaria cases and deaths from HF by month, ' + duration },
			subtitle: { text: '.' },
			xAxis: { categories: categories, crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'Severe Cases' } }, { title: { text: 'Deaths' }, opposite: true, allowDecimals: false }],
			tooltip: { shared: true, enabled: !self.isGuest },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
                { id: 'Severe', name: 'Severe', data: model.map(r => parseInt(r.Severe)) },
                { id: 'Deaths', name: 'Deaths', data: model.map(r => parseInt(r.Death)), yAxis: 1 }
			]
		}, function (chart) {
			self.tickChbox('.servereCbox', chart);
		});
	}

	function drawTestChart() {
		var model = self.mainData.chart;
		var duration = 'Jan ' + fromYear + ' - ' + self.to() + ' ' + self.year();

		$('#test').highcharts({
			chart: { type: 'spline' },
			colors: ["#e67e22", "#e74c3c", "#3498db"],
			title: { text: 'Malaria test results (HF, VMW) by species, ' + duration },
			subtitle: { text: '.' },
			xAxis: { categories: categories, crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'No of Cases' } }, { title: { text: 'TPR' }, opposite: true }],
			tooltip: { shared: true, enabled: !self.isGuest },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
                { id: 'PV', name: 'PV', data: model.map(r => parseInt(r.Pv)) },
                { id: 'PF + Mix', name: 'PF + Mix', data: model.map(r => parseInt(r.PfMix)) },
                { id: 'TPR', name: 'TPR', data: model.map(r => parseFloat(r.TPR)), yAxis: 1 }
			]
		}, function (chart) {
			self.tickChbox('.testCbox', chart);
		});
	}

	function drawChartCaseDeath() {
		var model = self.mainData.chartCaseDeathSpecie;
		var duration = 'Jan ' + model[0].Year + ' - ' + self.to() + ' ' + model.last().Year;

		$('#chartCaseDeath').highcharts({
			title: { text: 'Number of Malaria-Reported Case and Death by Year, ' + duration, style: { fontSize: '13px' } },
			subtitle: { text: '.' },
			xAxis: { categories: model.map(r => r.Year), crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'Cases' } }, { title: { text: 'Deaths' }, opposite: true, allowDecimals: false }],
			tooltip: { shared: true, enabled: !self.isGuest },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
                { id: 'Cases', name: 'Cases', type: 'column', data: model.map(r => r.Cases) },
                { id: 'Deaths', name: 'Deaths', type: 'spline', data: model.map(r => r.Deaths), yAxis: 1 }
			]
		}, function (chart) {
			self.tickChbox('.cdCbox', chart);
		});
	}

	function drawChartSpecie() {
		var model = self.mainData.chartCaseDeathSpecie;
		var duration = 'Jan ' + model[0].Year + ' - ' + self.to() + ' ' + model.last().Year;

		$('#chartSpecie').highcharts({
			chart: { type: 'column' },
			colors: ["#FF7474", "#F7A35C", "#95CEFF"],
			title: { text: 'Percentage of Malaria Cases by Species and Year, ' + duration, style: { fontSize: '13px' } },
			subtitle: { text: '.' },
			xAxis: { categories: model.map(r => r.Year), crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' }, reversedStacks: false },
			tooltip: {
				shared: true, enabled: !self.isGuest,
				pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.percentage:.0f}%</b><br/>'
			},
			plotOptions: {
				column: {
					stacking: 'percent',
					dataLabels: { enabled: true, format: '{point.percentage:.0f}%' },
				}
			},
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
                { id: 'Pf', name: 'Pf', data: model.map(r => r.Pf) },
                { id: 'Pv', name: 'Pv', data: model.map(r => r.Pv) },
                { id: 'Mix', name: 'Mix', data: model.map(r => r.Mix) }
			]
		}, function (chart) {
			self.tickChbox('.specieCbox', chart);
		});
	}

	function drawChartSexAge() {
		var model = self.mainData.chartSexAge;
		var duration = 'Jan ' + fromYear + ' - ' + self.to() + ' ' + self.year();
		var years = [];
		for (var i = fromYear; i <= self.year() ; i++) {
			years.push(i);
		}
		var categories = [
            { name: '0-4', categories: years },
            { name: '5-14', categories: years },
            { name: '15-49', categories: years },
            { name: '>49', categories: years }
		];
		var males = [], females = [];
		categories.forEach(c => {
			years.forEach(y => {
				var m = 0, f = 0;
				var found = model.find(r => r.Age == c.name && r.Year == y);
				if (found != null) {
					m = parseInt(found.Male);
					f = parseInt(found.Female);
				}
				males.push(m);
				females.push(f);
			});
		});

		$('#chartSexAge').highcharts({
			chart: { type: 'column' },
			title: { text: 'Percentage of Malaria Cases by Sex and Age Group, ' + duration },
			subtitle: { text: '.' },
			xAxis: { categories: categories, crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' }, reversedStacks: false },
			tooltip: { shared: true, valueSuffix: '%', enabled: !self.isGuest },
			plotOptions: { column: { stacking: 'normal' } },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
                { id: 'Male', name: 'Male', data: males },
                { id: 'Female', name: 'Female', data: females }
			]
		}, function (chart) {
			self.tickChbox('.sexCbox', chart);
		});
	}

	function drawChartSpecieProvince() {
		var model = self.mainData.chartSpecieProvince;
		var duration = String.format('{0}-{1} {2} and {3}', self.from(), self.to(), self.year() - 1, self.year());
		var cate = [], pv = [], pfmix = [];

		model.map(r => r.ShortName).distinct().forEach(sn => {
			cate.push({ name: sn, categories: [self.year() - 1, self.year()] });

			for (var y = self.year() - 1; y <= self.year() ; y++) {
				var found = model.find(r => r.ShortName == sn && r.Year == y);
				pv.push(found == null ? 0 : found.Pv);

				var found = model.find(r => r.ShortName == sn && r.Year == y);
				pfmix.push(found == null ? 0 : found.PfMix);
			}
		});

		$('#chartSpecieProvince').highcharts({
			chart: { type: 'column', zoomType: 'x', },
			colors: ["#F7A35C", "#FF7474"],
			title: { text: 'Malaria Cases by Species, Provinces and Year, ' + duration },
			subtitle: { text: '.' },
			xAxis: { categories: cate, crosshair: true, labels: { rotation: 0 }, gridLineWidth: 1 },
			yAxis: { title: { text: '' }, reversedStacks: false },
			tooltip: { shared: true, enabled: !self.isGuest },
			plotOptions: { column: { stacking: 'normal' }, series: { pointWidth: 20, pointPadding: 1, groupPadding: 1 } },
			exporting: { sourceWidth: 1600, sourceHeight: 400 },
			series: [
                { id: 'Pv', name: 'Pv', data: pv },
                { id: 'Pf+Mix', name: 'Pf+Mix', data: pfmix }
			]
		}, function (chart) {
			self.tickChbox('.spCbox', chart);
		});

	}

	function drawChartIncidentMortality() {
		var model = self.mainData.chartIncidentMortality;
		var lastYear = self.year() - 1;
		var duration = 'Jan ' + lastYear + ' - ' + self.to() + ' ' + self.year();

		$('#chartIncidentMortality').highcharts({
			title: { text: 'Malaria Incidence and Mortality Rate by Year and Provinces, ' + duration },
			subtitle: { text: '.' },
			xAxis: { categories: model.map(r => r.ShortName).distinct(), crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'Incidence/1,000' } }, { title: { text: 'Mortality rate/100,000' }, opposite: true }],
			tooltip: { shared: true, enabled: !self.isGuest },
			plotOptions: { series: { pointWidth: 30, pointPadding: 1, groupPadding: 1 } },
			exporting: { sourceWidth: 1600, sourceHeight: 400 },
			series: [
                { id: 'inc-0', name: 'Inc ' + lastYear, type: 'column', data: model.filter(r => r.Year == lastYear).map(r => parseFloat(r.Inc)) },
                { id: 'inc-1', name: 'Inc ' + self.year(), type: 'column', data: model.filter(r => r.Year == self.year()).map(r => parseFloat(r.Inc)) },
                { id: 'mr', name: 'MR ' + self.year(), type: 'spline', data: model.filter(r => r.Year == self.year()).map(r => parseFloat(r.MR)), yAxis: 1 }
			]
		}, function (chart) {
			chart.series.forEach(function (v, k) {
				$('span#im-lg-' + k).text(v.name);
			});
			self.tickChbox('.imCbox', chart);
		});
	}

	self.drawChartTop30Vill = function () {
		var model = self.mainData.chartTop30Vill;

		var pf = $('#chartTop30VillPf').prop('checked');
		var pv = $('#chartTop30VillPv').prop('checked');
		var mix = $('#chartTop30VillMix').prop('checked');

		var data = model.map(r => {
			var totalpf = 0, totalpv = 0, totalmix = 0;
			if (pf) totalpf += r.Pf;
			if (pv) totalpv += r.Pv;
			if (mix) totalmix += r.Mix;
			return { name: r.Name, pf: totalpf, pv: totalpv, mix: totalmix };
		});
		data = data.sortdesc(r => r.pf + r.pv + r.mix).slice(0, 10);
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();
		$('#chartTop30Vill').highcharts({
			chart: { type: 'bar' },
			title: { text: 'Top 10 Villages Having Most Cases by Species, ' + duration },
			subtitle: { text: '.' },
			colors: ["#FF2700", "#FA8832", "#41B5E9"],
			xAxis: { categories: data.map(r => r.name), crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of cases' }, reversedStacks: false, allowDecimals: false },
			tooltip: { shared: true, enabled: !self.isGuest },
			plotOptions: { series: { stacking: 'normal' }, bar: { pointWidth: 20 } },
			legend: { symbolRadius: 0 },
			exporting: { sourceWidth: 1200, sourceHeight: 450 },
			series: [
                { name: 'PF', data: data.map(r => r.pf), visible: pf },
                { name: 'PV', data: data.map(r => r.pv), visible: pv },
                { name: 'Mix', data: data.map(r => r.mix), visible: mix }
			]
		}, function () {
			var x = this.plotLeft - 15;
			var y = 55;
			var style = { 'font-weight': 'bold', 'text-anchor': 'end' };
			this.renderer.text('OD / Health Facility / Village', x, y).attr(style).add();
		});

		return true;
	};

	self.drawChartTop30HFbySpecies = function () {
		var model = self.mainData.chartTop30HF;

		var pf = $('#chartTop30HFbySpeciesPf').prop('checked');
		var pv = $('#chartTop30HFbySpeciesPv').prop('checked');
		var mix = $('#chartTop30HFbySpeciesMix').prop('checked');

		var data = model.map(r => {
			var totalpf = 0, totalpv = 0, totalmix = 0;
			if (pf) totalpf += r.HFPf + r.VMWPf;
			if (pv) totalpv += r.HFPv + r.VMWPv;
			if (mix) totalmix += r.HFMix + r.VMWMix;
			return { name: r.Name, pf: totalpf, pv: totalpv, mix: totalmix };
		});
		data = data.sortdesc(r => r.pf + r.pv + r.mix).slice(0, 10);
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();
		$('#chartTop30HFbySpecies').highcharts({
			chart: { type: 'bar' },
			title: { text: 'Top 10 HFs Having Most Cases by Species, ' + duration },
			subtitle: { text: '.' },
			colors: ["#FF2700", "#FA8832", "#41B5E9"],
			xAxis: { categories: data.map(r => r.name), crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: 'Number of cases' }, reversedStacks: false, allowDecimals: false },
			tooltip: { shared: true, enabled: !self.isGuest },
			plotOptions: { series: { stacking: 'normal' }, bar: { pointWidth: 20 } },
			exporting: { sourceWidth: 1200, sourceHeight: 450 },
			series: [
                { name: 'PF', data: data.map(r => r.pf), visible: pf },
                { name: 'PV', data: data.map(r => r.pv), visible: pv },
                { name: 'Mix', data: data.map(r => r.mix), visible: mix }
			]
		}, function () {
			var x = this.plotLeft - 15;
			var y = 55;
			var style = { 'font-weight': 'bold', 'text-anchor': 'end' };
			this.renderer.text('OD / Health Facility', x, y).attr(style).add();
		});

		return true;
	};

	function drawChartCasePie() {
		var targetOD = parseInt(self.mainData.cases.find(r => r.Indicators == 'Malaria Confirmed Cases').AllThisYear);
		var otherOD = parseInt(self.mainData.casesCountry.find(r => r.Indicators == 'Malaria Confirmed Cases').AllThisYear) - targetOD;

		$('#chartCasePie').highcharts({
			chart: { type: 'pie', backgroundColor: 'transparent' },
			title: { text: 'Malaria cases in endemic area and none endemic area ' + self.year() },
			plotOptions: {
				series: {
					enableMouseTracking: false,
					startAngle: 180,
					dataLabels: {
						enabled: true,
						format: '{point.name}: {point.y} cases ({point.percentage:.0f}%)',
						style: { fontSize: '13px', textOutline: 0, width: '150px' }
					}
				}
			},
			exporting: { enabled: false, sourceWidth: 400, sourceHeight: 450 },
			series: [{
				name: 'Cases',
				data: [
                    { name: 'Endemic area in 55 ODs', y: targetOD, dataLabels: { distance: -70 } },
                    { name: 'None Endemic area in 48 ODs', y: otherOD }
				]
			}]
		});
	}

	self.showDailyCase = function(modal, event) {
		var specie = event.currentTarget.attributes.param.value;
		self.title('Today Case ' + self.getSpecie(specie));
		$.when(getDailyCase(specie)).then(function () {
			$('#modalCase').modal('show');
		});
	}

	function getDailyCase(specie) {
		self.cases([]);
		app.ajax('/Dashboard/getDailyCase', { specie: specie }).done(function (rs) {
			self.cases(rs);
		});
	}

	self.showMonthlyCase = function(specie, month) {
		self.title('Malaria Cases ' + self.getSpecie(specie) + ' in ' + month.format('MMMM - Y'));
		$.when(getMonthlyCases(specie, month.format('MM'))).then(function () {
			$('#modalCase').modal('show');
		});
	}

	function getMonthlyCases(specie, month) {
		self.cases([]);
		app.ajax('/Dashboard/getMonthlyCase', { specie: specie, month: month }).done(function (rs) {
			self.cases(rs);
		});
	}

	self.getSpecie = function(specie) {
		return specie == 'F' ? 'Pf'
			: specie == 'V' ? 'Pv'
			: specie == 'M' ? 'Mix'
			: specie == 'A' ? 'Pm'
			: specie == 'O' ? 'Po'
			: 'Pk';
	}

	self.dateFormat = function(date) {
		return moment(date).format('DD-MM-YYYY');
	}

	self.lastmileFormat = function(criteria, value) {
		if (criteria == 'TDA %' || criteria == 'IPT %') return value + '%'
		return value;
	}
});