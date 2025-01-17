if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {
	var mapApi = null;
	var mapHotspot = null;
	var mapFoci = null;
	var hotspotMakers = [];
	var fociMakers = [];

	self.y = ko.observable(moment().year());
	self.mf = ko.observable('Jan');
	self.mt = ko.observable('Dec');

	self.apiVillData = ko.observableArray();
	self.apiVill0 = ko.observable();
	self.apiVillLt1 = ko.observable();
	self.apiVillf1t5 = ko.observable();
	self.apiVillf5t30 = ko.observable();
	self.apiVillgt30 = ko.observable();
	self.tableFoci = ko.observableArray();

	var chboxAttr = [{ id: 'lt1', name: 'Less than 1', selected: ko.observable(true) }, { id: 'f1t5', name: 'From 1 to 5', selected: ko.observable(true) }, { id: 'f5t30', name: 'From 5 to 30', selected: ko.observable(true) }, { id: 'gt30', name: 'Greater than 30', selected: ko.observable(true) }];
	self.apiChboxs = ko.observableArray(chboxAttr);

	self.showTabMap = function () {
		app.ajax('/Dashboard/tabMap/', self.lastSubmit).done(function (rs) {
			Object.keys(rs).forEach(k => self.mainData[k] = rs[k]);

			drawChartTop10OD();
			drawMapAber();
			drawMapHotspot();
			drawMapFoci();
			drawMapODInc();
			self.submitAPIVill();
		});
	};

	function drawChartTop10OD() {
		var model = self.mainData.chartTop10OD;
		var totalCase = model.reduce((a, b) => a + b.value, 0);
		var data = [];
		model.forEach(function (k, v) {
			data.push({ code: k.code, name: k.name, value: k.value, totalCase: totalCase, percentage: (k.value * 100 / totalCase).toFixed(2) })
		})
		model = data;

		var start = 10;
		var gap = Math.floor((model.length - 10) / 4);
		var series = [];

		series.push({
			id: 'top-0',
			name: 'Top 10', data: model.slice(0, 10), dataLabels: {
				enabled: true,
				useHTML: true,
				align: 'center',
				format: '<div class="text-center"><b>{point.name}</b> <br/> {point.value} cases <br/> {point.percentage}%</div>',
				style: { color: 'black', textOutline: 'none', fontWeight: 'normal' }
			}
		});
		series.push({ id: 'top-1', name: '11 To 20', data: model.slice(start, start += gap) });
		series.push({ id: 'top-2', name: '21 To 30', data: model.slice(start, start += gap) });
		series.push({ id: 'top-3', name: '31 To 40', data: model.slice(start, start += gap) });
		series.push({ id: 'top-4', name: '41 To 53', data: model.slice(start) });

		var duration = String.format('{0}-{1} {2}', self.from(), self.to(), self.year());

		$('#chartTop10OD').highcharts({
			chart: { type: 'packedbubble', height: 600 },
			title: { text: 'Malaria Cases by OD, ' + duration },
			subtitle: { text: '.' },
			tooltip: { useHTML: true, enabled: !self.isGuest, pointFormat: '<div class="text-center"><b>{point.name}</b> <br/> {point.value} cases <br/> {point.percentage}%</div>' },
			plotOptions: {
				packedbubble: {
					minSize: '30%',
					maxSize: '150%',
					layoutAlgorithm: { splitSeries: false, gravitationalConstant: 0.02 },
					animation: false,
					dataLabels: {
						useHTML: true,
						format: '<div class="text-center"><b>{point.name}</b> <br/> {point.value} cases <br/> {point.percentage}%</div>',
						style: {
							color: 'black',
							textOutline: 'none',
							fontWeight: 'normal'
						}
					}
				}
			},
			exporting: { sourceWidth: 600, sourceHeight: 600 },
			series: series
		}, function (chart) {
			if (this.renderTo.id == '') return;

			chart.series.forEach(function (v, k) {
				$('span#t10-lg-' + k).text(v.name);
			});
			drawMapOD(chart.series[0].data);

			$('.top10Cbox').click(function () {
				if (!isEmptyObject(chart)) {
					var idSelector = function () { return this.id; };
					var selectedIDs = $("#bubble :checkbox:checked").map(idSelector).get();
					if (selectedIDs.length == 0) drawMapOD([]);
					var arrID = jQuery.map(selectedIDs, function (element) {
						return parseInt(element.split('-')[1]);
					});

					if (arrID.length != 0) {
						var j = 0;
						arrID.forEach(id => {
							series = chart.get('top-' + id);
							var opt = series.options;
							if (j == 0) {
								opt.dataLabels.enabled = true;
								drawMapOD(series.data);
							} else {
								opt.dataLabels.enabled = false;
								chart.series[id].update(opt);
							}
							j++;
						})
					}
					var id = $(this).attr('id');
					series = chart.get(id);
					series.setVisible(!series.visible);
				}
			});
		});
	}

	function drawMapOD(data) {
		var name = '';
		var color = "#F7F7F7";
		if (data.length != 0) {
			color = data[0].color;
			name = data[0].series.legendItem.textStr;
		}
		data = data.map(r => {
			return { code: r.code, name: r.name, value: r.value };
		});

		var duration = String.format('{0}-{1} {2}', self.from(), self.to(), self.year());

		$('#mapOD').highcharts('Map', {
			chart: { map: 'chartODBorder', style: { fontFamily: 'Arial, Helvetica, sans-serif, Verdana' } },
			title: { text: 'Malaria Cases by OD, ' + duration },
			plotOptions: {
				map: {
					allAreas: true,
					joinBy: ['hc-key', 'code'],
					dataLabels: { enabled: true, useHTML:true, format: '{point.name} <br>{point.value}', style: { color: 'black', textOutline: '', textAlign: 'center' } },
					tooltip: { headerFormat: '', pointFormat: '{point.name}: <b>{point.value} Cases</b>' }
				},
				series: {
					borderColor: '#ccc'
				}
			},
			colorAxis: { dataClasses: [{ name: name, color: color }] },
			exporting: { sourceWidth: 700, sourceHeight: 600 },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			tooltip: { enabled: !self.isGuest },
			series: [{
				data: data,
				name: 'Distribution Percentage',
				dataLabels: { enabled: true, style: { color: 'black', textOutline: '' } }
			}]
		});
	}

	function drawMapAber() {
		var data = self.targetOD.filter(code => self.prov() == null || code.substr(0, 2) == self.prov());
		data = data.map(key => {
			var found = self.mainData.mapAber.find(r => r.Code_OD_T == key);
			var percent = found == null ? 0 : found.Aber;
			return [key, percent];
		});

		var duration = String.format('{0}-{1} {2}', self.from(), self.to(), self.year());
		$('#mapAber').highcharts('Map', {
			chart: { map: 'chartODBorder', style: { fontFamily: 'Arial, Helvetica, sans-serif, Verdana' } },
			title: { text: 'Malaria ABER Percentage by OD, ' + duration },
			plotOptions: { series: { borderColor: '#ccc' } },
			colorAxis: {
				dataClasses: [
					{ name: 'Non-Target', color: "#000000" },
					{ name: '0.1 - 7', from: 0, to: 7, color: '#FFBFBF' },
					{ from: 8, to: 15, color: '#FF6262' },
					{ from: 16, to: 20, color: '#FF0000' },
					{ from: 20, color: '#930000' }
				]
			},
			legend: {
				title: { text: '% of ABER' },
				layout: 'vertical', align: 'right',
				valueDecimals: 0,
				symbolRadius: 0, symbolWidth: 30, symbolHeight: 15, squareSymbol: false,
				itemMarginTop: 5
			},
			exporting: { sourceWidth: 900, sourceHeight: 600 },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			tooltip: { enabled: !self.isGuest },
			series: [{
				name: 'Distribution Percentage',
				data: data,
				tooltip: { valueSuffix: '%' },
				dataLabels: { enabled: true, useHTML:true, format: '{point.name} <br> {point.value}%', style: { color: 'black', textOutline: '', textAlign: 'center' } }
			}]
		});

		var ele = $('#mapAber .highcharts-legend rect[fill="#000000"]').eq(0);
		ele.after('<rect x="1" y="7" width="28" height="13" fill="#F7F7F7" class="highcharts-point"></rect>');
		ele.parent().html(ele.parent().html());
	}

	function drawMapODInc() {
		var data = self.targetOD.map(key => {
			var found = self.mainData.mapODInc.find(r => r.Code_OD_T == key);
			var inc = found == null ? 0 : parseFloat(found.Inc);
			return [key, inc];
		});
		
		var duration = String.format('{0}-{1} {2}', self.from(), self.to(), self.year());
		$('#mapODInc').highcharts('Map', {
			chart: { map: 'chartODBorder', style: { fontFamily: 'Arial, Helvetica, sans-serif, Verdana' } },
			title: { text: 'Malaria Incidence by OD, ' + duration },
			plotOptions: { series: { borderColor: '#ccc' } },
			colorAxis: {
				dataClasses: [
					{ name: 'Non-Target', color: "#000000" },
					{ from: 0, to: 0.05, color: '#FFBFBF' },
					{ from: 0.06, to: 1, color: '#FF0000' },
					{ from: 1, color: '#930000' }
				]
			},
			legend: {
				title: { text: 'Number of Incidence' },
				layout: 'vertical', align: 'right',
				symbolRadius: 0, symbolWidth: 30, symbolHeight: 15, squareSymbol: false,
				itemMarginTop: 5
			},
			exporting: { sourceWidth: 900, sourceHeight: 600 },
			mapNavigation: { enabled: true, enableMouseWheelZoom: false },
			tooltip: { enabled: !self.isGuest },
			series: [{
				name: 'Incidence',
				data: data,
				dataLabels: { enabled: true, useHTML: true, format: '{point.name} <br> {point.value}', style: { color: 'black', textOutline: '', textAlign: 'center' } }
			}]
		});

		var ele = $('#mapODInc .highcharts-legend rect[fill="#000000"]').eq(0);
		ele.after('<rect x="1" y="8" width="28" height="13" fill="#F7F7F7" class="highcharts-point"></rect>');
		ele.parent().html(ele.parent().html());
	}

	self.submitAPIVill = function (vm) {
	    function draw(data) {
	        var dataVal = _.map(data.apiVill, function (o) {
	            return parseFloat(o.Value);
	        });
			var data = _.filter(data.apiVill, function (o) { return o.Lat != null });
			self.apiVillData(data);
			drawAPImap(data);

			var zero = _.filter(dataVal, function (o) { return o == 0 });
			var ltOne = _.filter(dataVal, function (o) { return o > 0 && o < 1 });
			var f1t5 = _.filter(dataVal, function (o) { return o >= 1 && o <= 5 });
			var f5t30 = _.filter(dataVal, function (o) { return o > 5 && o <= 30 });
			var gt30 = _.filter(dataVal, function (o) { return o > 30 });

			self.apiVill0(zero.length)
			self.apiVillLt1(ltOne.length);
			self.apiVillf1t5(f1t5.length);
			self.apiVillf5t30(f5t30.length);
			self.apiVillgt30(gt30.length);
		}

		var submit = {
			year: self.y(),
			from: self.monthList.indexOf(self.mf()) + 1,
			to: self.monthList.indexOf(self.mt()) + 1,
			pv: self.pvAPI(),
			od: self.odAPI(),
			hc: self.hcAPI(),
			v: self.v() ? 'v' : '',
			f: self.f() ? 'f' : '',
			m: self.m() ? 'm' : '',
			filterDateCase: self.lastSubmit.filterDateCase
		};

		app.ajax('/Dashboard/getAPIVill', submit).done(function (rs) {
			draw(rs);
			self.loaded(true);
		});
	};

	function drawAPImap(data) {
		data = data.filter(r => r.Lat != 0 && r.long != 0).map(o => {
			return {
				name: '',
				lat: parseFloat(o.Lat),
				lon: parseFloat(o.long),
				z: parseFloat(o.Value)
			}
		});

		var duration = String.format('{0}-{1} {2}', self.mf(), self.mt(), self.y());

		$('#mapAPI').highcharts('Map', {
			title: { text: 'Malaria API Map by Villages, ' + duration },
			tooltip: { enabled: false },
			plotOptions: { series: { marker: { states: { hover: { enabled: false } } }, borderColor: '#ccc' } },
			exporting: {
			    sourceWidth: 900, sourceHeight: 800,
			    buttons: { contextButton: { menuItems: ['downloadPNG'] } },
			},
			legend: {
				title: { text: 'Malaria API / 1000 Pop' },
				layout: 'vertical', align: 'right',
				itemMarginTop: 5
			},
			series: [{
				mapData: Highcharts.maps['chartODBorder'],
				showInLegend: false,
				dataLabels: { enabled: true, format: '{point.name}', style: { color: 'black', textOutline: '' } }
			}, {
				name: 'Less than 1',
				id: 'lt1',
				type: 'mapbubble',
				data: data.filter(r => r.z < 1),
				color: '#3498DB',
				marker: { fillOpacity: 1 },
				minSize: 2,
				maxSize: 2,
			}, {
				name: 'From 1 to 5',
				id: 'f1t5',
				type: 'mapbubble',
				data: data.filter(r => r.z >= 1 && r.z <= 5),
				color: '#F1C40F',
				marker: { fillOpacity: 1 },
				minSize: 2,
				maxSize: 2,
			}, {
				name: 'From 5 to 30',
				id: 'f5t30',
				type: 'mapbubble',
				data: data.filter(r => r.z > 5 && r.z <= 30),
				color: '#E91E63',
				marker: { fillOpacity: 1 },
				minSize: 2,
				maxSize: 2,
			}, {
				name: 'Greater than 30',
				id: 'gt30',
				type: 'mapbubble',
				data: data.filter(r => r.z > 30),
				color: '#EA2027',
				marker: { fillOpacity: 1 },
				minSize: 2,
				maxSize: 2,
			}]
		}, function (chart) {
			self.tickChbox('.apimap', chart);
		});
	}

	var downloadHotspot = [];
	function drawMapHotspot() {
		var data = self.mainData.mapTop30Vill;
		data = data.filter(r => r.Lat != null && r.long != null);

		if (mapHotspot == null) {
			mapHotspot = app.createGoogleMap('mapHotspot', {
				zoom: 7.3
			});

			var title = document.createElement('div');
			var div = document.createElement('div');
			let startYear = moment().add(-36, 'month').format('MMM/YYYY')
			let endYear = moment().format("MMM/YYYY");
			div.innerHTML = '<h6 style="font-weight: 900">MALARIA HOTSPOT BY VILLAGE ' + startYear + ' - ' + endYear + '</h6>';
			title.appendChild(div);

			mapHotspot.controls[google.maps.ControlPosition.TOP_CENTER].push(title);

			var maxCase = _.maxBy(data, function (o) { return o.Total }).Total;
			var divide = parseInt(maxCase / 3);
			var maxRank = _.max(data, function (r) { return r.N }).N;
			var rank = parseInt(maxRank / 3);

			var fociCircles = {
				circle1: {
					name: '1 - ' + divide,
					rank: '1 - ' + rank,
					size: '10px',
					color: '#ff8000',
				},
				circle2: {
					name: divide + ' - ' + divide * 2,
					rank: rank + ' - ' + rank * 2,
					size: '15px',
					color: '#ff0000',
				},
				circle3: {
					name: '> ' + divide * 2,
					rank: '> ' + rank * 2,
					size: '20px',
					color: '#660000',
				}
			};

			var legend = document.createElement('div');

			legend.style = 'padding:10px; margin:10px; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';

			var div = document.createElement('div');
			div.innerHTML = '<h9 style="font-weight: 900"># case for each village </h9>';
			legend.appendChild(div);

			for (var key in fociCircles) {
				var c = fociCircles[key];
				var div = document.createElement('div');
				var padding = key == 'circle1' ? 4 : key == 'circle2' ? 2 : 0;
				div.style = 'margin-top: 10px; padding-left: ' + padding + 'px';
				div.innerHTML = '<span style="width:' + c.size + '; height:' + c.size + '; background:white; border:1px solid; border-radius:50%; float:left"></span>';
				div.innerHTML += '<span style="vertical-align:middle; padding-left:5px">' + c.name + '</span>';
				legend.appendChild(div);
			}

			var div = document.createElement('div');
			div.innerHTML = '<h9 style="font-weight: 900"><br> # month of hotspot <br> for each village</h9>';
			legend.appendChild(div);

			for (var key in fociCircles) {
				var c = fociCircles[key];
				var div = document.createElement('div');
				div.style = 'margin-top: 10px';
				div.innerHTML = '<div style="width: 20px; height: 15px; background: ' + c.color + '; border:1px solid; float:left"></div>'
					+ '<span style="vertical-align:middle; padding-left:5px">' + c.rank + '</span>';
				legend.appendChild(div);
			}

			mapHotspot.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);
		}

		hotspotMakers.forEach(r => r.setMap(null));
		hotspotMakers = [];
		data.distinct(r => r.Code_Vill_T).forEach(v => {
			var marker = new google.maps.Marker({
				position: { lat: parseFloat(v.Lat), lng: parseFloat(v.long) },
				icon: selectHotspot(data, v.Total, v.N),
				zIndex: 2,
				map: mapHotspot
			});
			hotspotMakers.push(marker);

			var txt = '<b>OD:</b> ' + v.Name_OD_E;
			txt += '<br><b>HC:</b> ' + v.Name_Facility_E;
			txt += '<br><b>Village:</b> ' + v.Name_Vill_E;
			if (app.user.role == 'AU') {
				txt += '<br><br><b>Case:</b> ' + v.Total;
				txt += '<br><b># Month:</b> ' + v.N;
			}

			var infowindow = new google.maps.InfoWindow({ content: txt });
			marker.addListener('mouseover', () => infowindow.open(mapHotspot, marker));
			marker.addListener('mouseout', () => infowindow.close());
		});
		downloadHotspot = data;
	}

	function selectHotspot(data, totalCase, rank) {
		var maxCase = _.maxBy(data, function (o) { return o.Total }).Total;
		var divide = parseInt(maxCase / 3);
		var part1 = divide;
		var part2 = divide + divide;

		var maxRank = _.maxBy(data, function (o) { return o.N }).N;
		var divide = parseInt(maxRank / 3);
		var rank1 = divide;
		var rank2 = divide + divide;

		color = '';
		if (rank < rank1) color = '#ff8000';
		else if (rank > rank1 && rank < rank2) color = '#ff0000';
		else color = '#660000';

		if (totalCase < part1) return drawCircleHotspot(color, 5);
		else if (totalCase > part1 && totalCase < part2) return drawCircleHotspot(color, 13);
		else return drawCircleHotspot(color, 20);
	}

	function drawCircleHotspot(color, size) {
		return {
			path: google.maps.SymbolPath.CIRCLE,
			fillOpacity: 0.8,
			fillColor: color,
			strokeOpacity: 1,
			strokeColor: color,
			strokeWeight: 1,
			scale: size
		}
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

	var fociCircles = {
		circle1: { name: 'Active focus', color: '#FFC000' },
		circle2: { name: 'Residual focus', color: '#00B050' },
		circle3: { name: 'Cleared-up focus', color: '#2F75B5' },
	};

	function drawMapFoci() {
		if (mapFoci == null) {
			mapFoci = app.createGoogleMap('mapFoci', {
				zoom: 7.3,
				zoomControlOptions: { position: google.maps.ControlPosition.TOP_RIGHT }
			});

			var legend = document.createElement('div');
			legend.style = 'padding:10px; margin:10px; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';

			var title = document.createElement('div');
			title.innerHTML = '<h5><b>Annual Foci Classification<br>and Monitoring from 2020</b></h5>';
			legend.appendChild(title);

			for (var key in fociCircles) {
				var c = fociCircles[key];
				var div = document.createElement('div');
				div.style = 'margin-bottom:5px; line-height:16px';
				div.innerHTML += '<span style="width:15px; height:15px; background:' + c.color + '; border:1px solid; border-radius:50%; float:left"></span>';
				div.innerHTML += '<span style="padding-left:5px" class="font12">' + c.name + '</span>';
				legend.appendChild(div);
			}
			mapFoci.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
		}

		var list = self.mainData.mapFoci.slice().sortdesc('CurrentStatus');
		fociMakers.forEach(r => r.setMap(null));
		fociMakers = [];
		list.filter(r => r.Lat != null).forEach(v => {
			var marker = new google.maps.Marker({
				position: { lat: v.Lat, lng: v.Long },
				icon: {
					path: google.maps.SymbolPath.CIRCLE,
					fillOpacity: 1,
					fillColor: getFociCircleColor(v.CurrentStatus),
					strokeColor: '#555',
					strokeWeight: 1,
					scale: 5
				},
				zIndex: 2,
				map: mapFoci
			});
			fociMakers.push(marker);

			var txt = '<b>Province:</b> ' + v.Name_Prov_E
					+ '<br><b>OD:</b> ' + v.Name_OD_E
					+ '<br><b>HC:</b> ' + v.Name_Facility_E
					+ '<br><b>Village:</b> ' + v.Name_Vill_E;

			var infowindow = new google.maps.InfoWindow({ content: txt });
			marker.addListener('mouseover', () => infowindow.open(mapStock, marker));
			marker.addListener('mouseout', () => infowindow.close());
		});

		self.tableFoci(list);
	}

	function getFociCircleColor(status) {
		return status == 'Active' ? fociCircles.circle1.color
			: status == 'Residual' ? fociCircles.circle2.color
			: fociCircles.circle3.color;
	}

	self.exportFociMap = function (onSuccess) {
		var image = new Image();
		image.src = '/media/images/foci-map.jpg';
		image.onload = function () {
			var canvas = document.createElement('canvas');
			canvas.width = this.width;
			canvas.height = this.height;

			var ctx = canvas.getContext('2d');
			ctx.drawImage(this, 0, 0);

			var data = self.mainData.mapFoci.filter(r => r.Lat != null);
			data.forEach(v => {
				var x = (v.Long * 158) - 16090;
				var y = 2425 - (v.Lat * 162);

				ctx.beginPath();
				ctx.arc(x, y, 5, 0, Math.PI * 2);
				ctx.stroke();
				ctx.fillStyle = getFociCircleColor(v.Status);
				ctx.fill();
			});

			onSuccess(canvas.toDataURL('image/jpeg', 1));
		};
	};

	self.exportHotspotMap = function (onSuccess) {
		var image = new Image();
		image.src = '/media/images/hotspot-map.jpg';
		image.onload = function () {
			var canvas = document.createElement('canvas');
			canvas.width = this.width;
			canvas.height = this.height;

			var ctx = canvas.getContext('2d');
			ctx.drawImage(this, 0, 0);

			var data = self.mainData.mapTop30Vill.filter(r => r.Lat != null);
			data.distinct(r => r.Code_Vill_T).forEach(v => {
				var x = (v.long * 158) - 16090;
				var y = 2425 - (v.Lat * 162);

				var circle = selectHotspot(data, v.Total, v.N);

				ctx.beginPath();
				ctx.arc(x, y, circle.scale, 0, Math.PI * 2);
				ctx.strokeStyle = circle.strokeColor;
				ctx.stroke();
				ctx.fillStyle = circle.fillColor + 'b3';
				ctx.fill();
			});

			onSuccess(canvas.toDataURL('image/jpeg', 1));
		};
	};
});