if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {
	self.stockMenu = ko.observable('Charts');
	self.stockItemCode = ko.observable('ND0067');
	self.stockLevel = ko.observable('HC');
	self.stockYear = ko.observable(moment().add(-1, 'M').year());
	self.stockMonth = ko.observable(moment().add(-1, 'M').format('MMM'));

	self.tblStockSummary = ko.observableArray();
	self.tblStockOver = ko.observableArray();
	self.tblStockGood = ko.observableArray();
	self.tblStockLow = ko.observableArray();
	self.tblStockOut = ko.observableArray();

	self.tblStockTop30 = ko.observableArray();
	self.tblStockFoci = ko.observableArray();
	self.tblStockPvRadical = ko.observableArray();

	self.tblStockCompletePopup = ko.observableArray();

	self.tickFilter = ko.observableArray();
	var StockStatusPopupData = ko.observableArray();

	var mapStock = null;
	var mapStockMakers = [];
	var mapFilter = 'RDT';
	var monitorOD = [];
	var monitorHC = [];

	self.showTabStock = function () {
		self.loaded(true);
		app.hideLoader();

		var list = [
			'StockStatusOD|StockStatusHC',
			'StockCompleteness|StockOut',
			'StockMalaria',
			'StockMap',
		];
		if (mapStock != null) list = list.filter(r => r != 'StockMap');

		function getData(index) {
			var part = self.lastSubmit.stockPart = list[index];
			app.ajax('/Dashboard/tabStock', self.lastSubmit, false).done(function (rs) {
				part.split('|').forEach(name => {
					self.mainData[name] = rs[name];
					eval('draw' + name + '()');
				});

				if (index + 1 < list.length) getData(index + 1);
			});
		}

		$('#tabStock .chart-container').each(function () {
			if (this.id == 'mapStock' && mapStock != null) return;
			this.innerHTML = $('#waitingTemplate').html();
		});
		getData(0);
	};

	self.stockMenu.subscribe(function (menu) {
		if (menu.in('Monitor', 'Table') && self.tblStockSummary().length == 0) {
			self.viewMonitor();
		}
	});

	setTimeout(function () {
		self.stockItemCode.subscribe(function () {
			['StockStatusOD', 'StockStatusHC', 'StockOut'].forEach(name => {
				if (self.mainData[name] !== undefined) eval('draw' + name + '()');
			});
			updateMonitorTable();
		});

		self.stockLevel.subscribe(updateMonitorTable);
	});

	self.viewMonitor = function () {
		var submit = {
			year: self.stockYear(),
			month: self.monthList.indexOf(self.stockMonth()) + 1,
			prov: self.lastSubmit.prov
		};
		app.ajax('/Dashboard/tabStockMonitor', submit).done(function (rs) {
			monitorOD = rs.monitorOD;
			monitorHC = rs.monitorHC;
			updateMonitorTable();

			self.tblStockFoci(rs.table.filter(r => r.Foci == 1));
			self.tblStockPvRadical(rs.table.filter(r => r.IsReminder == 1));
			self.tblStockTop30(rs.table.sortdesc('Total').slice(0, 30));
		});
	};

	function updateMonitorTable() {
		var monitorData = self.stockLevel() == 'OD' ? monitorOD : monitorHC;
		if (monitorData.length == 0) return;

		var data = monitorData.filter(r => r.Code == self.stockItemCode());
		var list = data.groupby(self.stockLevel() == 'OD' ? 'Name_Prov_E' : 'Name_OD_E').map(arr => {
			return {
				Name_Prov_E: arr[0].Name_Prov_E,
				Name_OD_E: arr[0].Name_OD_E,
				StockOver: arr.filter(r => r.Status == 'Over').length,
				StockGood: arr.filter(r => r.Status == 'Good').length,
				StockLow: arr.filter(r => r.Status == 'Low').length,
				StockOut: arr.filter(r => r.Status == 'Out').length
			};
		});
		self.tblStockSummary(list);

		self.tblStockOver(data.filter(r => r.Status == 'Over'));
		self.tblStockGood(data.filter(r => r.Status == 'Good'));
		self.tblStockLow(data.filter(r => r.Status == 'Low'));
		self.tblStockOut(data.filter(r => r.Status == 'Out'));
	}

	function drawStockMalaria() {
		var model = self.mainData.StockMalaria;

		var categories = [];
		for (var x of model) {
			var found = categories.find(r => r.name == x.Year);
			found == null
				? categories.push({ name: x.Year, categories: [x.Month] })
				: found.categories.push(x.Month);
		}

		$('#stockMalaria').highcharts({
			chart: { type: 'column' },
			title: { text: 'Malaria cases in endemic areas since 2022', style: { fontSize: '13px' } },
			xAxis: { categories: categories, crosshair: true },
			yAxis: [{ title: { text: 'Cases' }, reversedStacks: false }, { title: { text: '' }, opposite: true, allowDecimals: false }],
			plotOptions: { column: { stacking: 'normal', dataLabels: { enabled: true } } },
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Pv', data: model.map(r => r.Pv) },
				{ name: 'Pf/Mix', data: model.map(r => r.PfMix) },
				{ name: 'Test', data: model.map(r => r.Test), yAxis: 1, type: 'spline' }
			]
		});
	}

	function drawStockStatusOD() {
		var model = self.mainData.StockStatusOD.filter(r => r.Code == self.stockItemCode());
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();

		var myClick = function () {
			var submit = {
				year: self.year(),
				month: self.monthList.indexOf(this.category.name) + 1,
				prov: self.lastSubmit.prov,
				store: 'StockMonitorOD'
			};
			app.ajax('/Dashboard/tabStockMonitor', submit).done(function (rs) {
				self.stockLevel('OD');
				self.tickFilter(['Out', 'Low', 'Good', 'Over']);
				StockStatusPopupData(rs.monitorOD.filter(r => r.Code == self.stockItemCode()));
				$('#modalStockStatus').modal('show').find('.modal-body').scrollTop(0);
			});
		}

		$('#stockStatusOD').highcharts({
			chart: { type: 'column' },
			colors: ['yellow', '#00B050', 'orange', 'red'],
			title: { text: '% of Stock Status by Month - OD Level, ' + duration, style: { fontSize: '13px' } },
			xAxis: { categories: model.map(r => self.monthList[parseInt(r.Month) - 1]), crosshair: true },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' } },
			tooltip: {
				shared: true,
				pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.percentage:.0f}%</b><br/>'
			},
			plotOptions: {
				column: {
					stacking: 'percent',
					dataLabels: { enabled: true, format: '{point.percentage:.0f}%' },
					cursor: 'pointer',
					point: { events: { click: myClick } }
				}
			},
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Over Stock', data: model.map(r => r.StockOver) },
				{ name: 'Sufficient Stock', data: model.map(r => r.StockGood) },
				{ name: 'Low Stock', data: model.map(r => r.StockLow) },
				{ name: 'Stock Out', data: model.map(r => r.StockOut) },
			]
		});
	}

	function drawStockStatusHC() {
		var model = self.mainData.StockStatusHC.filter(r => r.Code == self.stockItemCode());
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();

		var myClick = function () {
			var submit = {
				year: self.year(),
				month: self.monthList.indexOf(this.category.name) + 1,
				prov: self.lastSubmit.prov,
				store: 'StockMonitorHC'
			};
			app.ajax('/Dashboard/tabStockMonitor', submit).done(function (rs) {
				self.stockLevel('HC');
				self.tickFilter(['Out', 'Low', 'Good', 'Over']);
				StockStatusPopupData(rs.monitorHC.filter(r => r.Code == self.stockItemCode()));
				$('#modalStockStatus').modal('show').find('.modal-body').scrollTop(0);
			});
		}

		$('#stockStatusHC').highcharts({
			chart: { type: 'column' },
			colors: ['yellow', '#00B050', 'orange', 'red'],
			title: { text: '% of Stock Status by Month - HF Level, ' + duration, style: { fontSize: '13px' } },
			xAxis: { categories: model.map(r => self.monthList[parseInt(r.Month) - 1]), crosshair: true },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' } },
			tooltip: {
				shared: true,
				pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.percentage:.0f}%</b><br/>'
			},
			plotOptions: {
				column: {
					stacking: 'percent',
					dataLabels: { enabled: true, format: '{point.percentage:.0f}%' },
					cursor: 'pointer',
					point: { events: { click: myClick } }
				}
			},
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'Over Stock', data: model.map(r => r.StockOver) },
				{ name: 'Sufficient Stock', data: model.map(r => r.StockGood) },
				{ name: 'Low Stock', data: model.map(r => r.StockLow) },
				{ name: 'Stock Out', data: model.map(r => r.StockOut) },
			]
		});
	}

	function drawStockCompleteness() {
		var model = self.mainData.StockCompleteness;
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();
		var category = model.map(r => self.monthList[parseInt(r.Month) - 1]).distinct();

		var myClick = function () {
			var submit = {
				year: self.year(),
				month: self.monthList.indexOf(this.category.name) + 1,
				prov: self.lastSubmit.prov,
				type: this.series.name.replace(' Level', '')
			};
			app.ajax('/Dashboard/stockPopup', submit).done(function (rs) {
				self.stockLevel(submit.type);
				self.tblStockCompletePopup(rs);
				$('#modalStockCompleteness').modal('show').find('.modal-body').scrollTop(0);
			});
		};

		$('#stockCompleteness').highcharts({
			chart: { type: 'spline' },
			title: { text: 'Stock Completeness Report, ' + duration, style: { fontSize: '13px' } },
			xAxis: { categories: category, crosshair: true },
			yAxis: { title: { text: '' }, labels: { format: '{value}%' }, max: 100 },
			tooltip: { shared: true, valueSuffix: '%' },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			plotOptions: {
				series: {
					cursor: 'pointer',
					point: { events: { click: myClick } }
				}
			},
			series: [
				{ name: 'OD Level', data: model.filter(r => r.Type == 'OD').map(r => r.Percentage) },
				{ name: 'HC Level', data: model.filter(r => r.Type == 'HC').map(r => r.Percentage) }
			]
		});
	}

	function drawStockOut() {
		var model = self.mainData.StockOut.filter(r => r.Code == self.stockItemCode());
		var duration = self.from() + ' - ' + self.to() + ' ' + self.year();
		var category = model.map(r => self.monthList[parseInt(r.Month) - 1]).distinct();

		$('#stockOut').highcharts({
			chart: { type: 'spline' },
			title: { text: '# of Stock-Out, ' + duration, style: { fontSize: '13px' } },
			xAxis: { categories: category, crosshair: true },
			yAxis: { title: { text: '' } },
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 400 },
			series: [
				{ name: 'OD Level', data: model.filter(r => r.Type == 'OD').map(r => r.StockOut) },
				{ name: 'HC Level', data: model.filter(r => r.Type == 'HC').map(r => r.StockOut) }
			]
		});
	}

	function drawStockMap() {
		var circles = {
			circle1: { name: 'ដាច់ស្តុក', color: '#e46a76' },
			circle2: { name: 'ជិតដាច់ស្តុក', color: '#fec107' },
			circle3: { name: 'ស្តុកសមស្រប', color: '#00c292' },
			circle4: { name: 'ស្តុកកកស្ទះ', color: 'yellow' }
		};

		if (mapStock == null) {
			mapStock = app.createGoogleMap('mapStock', {
				zoom: 7.5,
				mapTypeControl: false,
			});

			var legend = document.createElement('div');
			legend.style = 'padding:10px; margin:10px 10px 0 0; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';

			for (var key in circles) {
				var c = circles[key];
				var div = document.createElement('div');
				div.style = 'margin-bottom:5px; line-height:16px';
				div.innerHTML = '<span style="width:15px; height:15px; background:' + c.color + '; border:1px solid; border-radius:50%; float:left"></span>';
				div.innerHTML += '<span style="vertical-align:middle; padding-left:5px" class="kh font12">' + c.name + '</span>';
				legend.appendChild(div);
			}

			mapStock.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);

			var legend = document.createElement('div');
			legend.style = 'padding:10px; margin:10px 10px 0 0; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';

			var div = document.createElement('div');
			div.innerHTML = '<b>Filter: </b><select onchange="app.vm.changeStockMap(this)"><option>RDT</option><option>ASMQ</option><option>PQ</option><option>Pyramax</option></select>'
			             
			legend.appendChild(div);

			mapStock.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);
		}

		var type = mapFilter;
		var model = self.mainData.StockMap;
		model.forEach(r => {
			r.RDTstatus = findStatus(r.RDTmos);
			r.ASMQstatus = findStatus(r.ASMQmos);
			r.PQstatus = findStatus(r.PQmos);
			r.Pyramaxstatus = findStatus(r.Pyramaxmos);
		});

		function findStatus(MOS) {
			MOS = toFloat(MOS);
			return MOS == 0 ? 'out'
				: MOS <= 3 ? 'near'
					: MOS <= 6 ? 'proper'
						: 'congested';
		}

		mapStockMakers.forEach(r => r.setMap(null));
		mapStockMakers = [];
		model.forEach(v => {
			var marker = new google.maps.Marker({
				position: { lat: parseFloat(v.Lat), lng: parseFloat(v.Long) },
				icon: drawCircle(v),
				zIndex: 2,
				map: mapStock
			});
			mapStockMakers.push(marker);

			var txt = '<b>OD:</b> ' + v.Name_OD_E
				+ '<br><b>HC:</b> ' + v.Name_Facility_E
				+ '<br><b>SOH:</b> ' + v[type + 'balance']
				+ '<br><b>AMC:</b> ' + toFloat1d(v[type + 'amc'])
				+ '<br><b>MOS:</b> ' + toFloat1d(v[type + 'mos']);

			var infowindow = new google.maps.InfoWindow({ content: txt });
			marker.addListener('mouseover', () => infowindow.open(mapStock, marker));
			marker.addListener('mouseout', () => infowindow.close());
		});

		function drawCircle(row) {
			var key = type + 'status';
			var color = row[key] == 'out' ? circles.circle1.color
				: row[key] == 'near' ? circles.circle2.color
					: row[key] == 'proper' ? circles.circle3.color
						: circles.circle4.color;

			return {
				path: google.maps.SymbolPath.CIRCLE,
				fillOpacity: 1,
				fillColor: color,
				strokeColor: '#555',
				strokeWeight: 1,
				scale: 5
			};
		}
	}

	self.changeStockMap = function (element) {
		mapFilter = element.value;
		drawStockMap();
	};

	self.inModal = function (node) {
		return $(node).closest('.modal-body').length > 0;
	};

	self.tblStockStatusPopup = ko.pureComputed(() => {
		return StockStatusPopupData().filter(r => self.tickFilter().contain(r.Status));
	});

	function toFloat1d(value) {
		return parseFloat(toFloat(value).toFixed(1));
	}

	self.fullScreen = function () {
		var elem = document.getElementById("mapStock");

		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.webkitRequestFullscreen) { /* Safari */
			elem.webkitRequestFullscreen();
		} else if (elem.msRequestFullscreen) { /* IE11 */
			elem.msRequestFullscreen();
		}
    }
});