function viewModel() {
	var self = this;

	self.pvList = ko.observableArray();
	self.odList = ko.observableArray();
	self.pv = ko.observable();
	self.od = ko.observable();
	self.monthFrom = ko.observable(moment().add(-moment().month(), 'month'));
	self.monthTo = ko.observable(moment());
	self.detailList = ko.observableArray();
	self.displayPercent = ko.observable(true);

	var map = null;
	var markerList = [];
	var percentMarkerList = [];
	var maindata = null;
	var place = null;
	var mapFilter = 'Primaquine';
    var CSOs = JSON.parse($('#cso').val());
    var HFs = JSON.parse($('#hf').val());
	var running = false;
	var zoom = 7.8;

	var circles = [
		{ name: '0% - 50%', color: 'red', range: [0, 50] },
		{ name: '51% - 70%', color: 'orange', range: [51, 70] },
		{ name: '71% - 95%', color: 'yellow', range: [71, 95] },
		{ name: '96% - 100%', color: 'blue', range: [96, 100] }
	];

	var csoInfo = {
		CRS: { position: { lat: 13.406, lng: 107.092 }, color: 'red' },
		CHAI: { position: { lat: 12.92, lng: 105.657 }, color: 'orange' },
		URC: { position: { lat: 12.462, lng: 103.337 }, color: 'green' },
		CNM: { position: { lat: 14.150, lng: 103.800 }, color: 'blue' }
	};

	app.getPlace(['pv', 'od', 'hc'], function (p) {
        place = p;
		place.pv = place.pv.filter(r => r.target == 1);
		place.od = place.od.filter(r => r.target == 1);
		self.pvList(p.pv);
	});

	app.readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
		eval(script);

		var returnObj = {};
		map = app.createGoogleMap('map', { zoom: zoom, }, returnObj);

		returnObj.polygon.setMap(null);

		CSOs.groupby('CSO').forEach(arr => {
			var cso = arr[0].CSO;
			var ods = arr.map(r => r.Code_OD_T);

			var polygonBorders = [];
			googleODBorder.filter(r => ods.contain(r.code)).forEach(od => {
				od.coor.forEach(a => {
					a.forEach(b => {
						var polygon = [];
						b.forEach(r => polygon.push({ lat: r[0], lng: r[1] }));
						polygonBorders.push(polygon);
					});
				});
			});

			new google.maps.Polygon({
				paths: polygonBorders,
				strokeColor: '#2980b9',
				strokeWeight: 1,
				fillColor: csoInfo[cso].color,
				map: map
			});
		});

		var legend = document.createElement('div');
		legend.style = 'padding:10px; margin:10px 10px 0 0; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px; font-size:12px';

		for (var name in csoInfo) {
			var color = csoInfo[name].color;
			var div = document.createElement('div');
			div.style = 'margin-bottom:5px; line-height:16px';
			div.innerHTML = '<span style="width:25px; height:15px; background:' + color + '; float:left; opacity:0.5"></span>';
			div.innerHTML += '<span style="vertical-align:middle; padding-left:5px" class="kh font12">' + name + '</span>';
			legend.appendChild(div);
		}

		for (var c of circles) {
			var div = document.createElement('div');
			div.style = 'margin-bottom:5px; line-height:16px';
			div.innerHTML = '<span style="width:15px; height:15px; background:' + c.color + '; border:1px solid; border-radius:50%; float:left"></span>';
			div.innerHTML += '<span style="vertical-align:middle; padding-left:5px" class="kh font12">' + c.name + '</span>';
			legend.appendChild(div);
		}

		legend.appendChild(document.createElement('hr'));

		var option = [
			['Primaquine', 'Primaquine'],
			['Day3', 'Followup Day 3'],
			['Day7', 'Followup Day 7'],
            ['Day14', 'Followup Day 14'],
            ['Hf', 'Radical Cure HFs']
		].map(r => `<option value="${r[0]}">${r[1]}</option>`).join('');

		var div = document.createElement('div');
		div.innerHTML = '<select onchange="app.vm.filterChanged(this)">' + option + '</select>';
		legend.appendChild(div);

		map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);

		self.viewClick();
	});

	self.viewClick = function () {
		var submit = {
			pv: self.pv(),
			od: self.od(),
			from: self.monthFrom().format('YYYYMM'),
			to: self.monthTo().format('YYYYMM')
		};
		app.ajax('/PvRadicalCureMap/getData', submit).done(function (rs) {
			maindata = rs;
			updateMap();
		});
	};

	function updateMap() {
		markerList.forEach(r => r.setMap(null));
		markerList = [];
        percentMarkerList = [];

        var list = [];
        if (mapFilter == 'Hf') list = HFs;
        else list = mapFilter == 'Primaquine' ? maindata : maindata.filter(r => r.Primaquine > 0);

		list.filter(r => r.Lat != null).forEach(i => {
            if (mapFilter == 'Hf') {
                color = '#000';
            } else {
                var color = circles.find(r => {
                    if (mapFilter == 'Primaquine') {
                        var percent = i[mapFilter] * 100 / i.G6PD;
                    } else {
                        var percent = i[mapFilter] * 100 / i.Primaquine;
                    }
                    return percent >= r.range[0] && percent <= r.range[1];
                }).color;
            }

			var marker = new google.maps.Marker({
				position: { lat: parseFloat(i.Lat), lng: parseFloat(i.Long) },
				icon: {
					path: google.maps.SymbolPath.CIRCLE,
					fillOpacity: 1,
					fillColor: color,
					strokeColor: '#555',
					strokeWeight: 1,
					scale: 5
				},
				map: map
			});
			markerList.push(marker);

			var txt = '<b>OD:</b> ' + i.Name_OD_E
					+ '<br><b>HC:</b> ' + i.Name_Facility_E;

			var infowindow = new google.maps.InfoWindow({ content: txt });
			marker.addListener('mouseover', () => infowindow.open(map, marker));
			marker.addListener('mouseout', () => infowindow.close());

			marker.addListener('click', () => showDetail(i));
		});

		CSOs.groupby('CSO').forEach(arr => {
			var cso = arr[0].CSO;
			var ods = arr.map(r => r.Code_OD_T);

			var founds = list.filter(r => ods.contain(r.Code_OD_T));
			var percent = founds.length == 0 ? 100
				: mapFilter == 'Primaquine' ? founds.sum(mapFilter) * 100 / founds.sum('G6PD')
				: founds.sum(mapFilter) * 100 / founds.sum('Primaquine');

			var marker = new google.maps.Marker({
				position: csoInfo[cso].position,
				icon: {
					path: google.maps.SymbolPath.CIRCLE,
					strokeWeight: 2,
					strokeColor: 'white',
					scale: 23
				},
				label: {
					text: percent.toFixed(0) + '%',
					fontSize: '18px',
					fontWeight: 'bold',
					color: 'white'
                },
                map: mapFilter == 'Hf' ? null : self.displayPercent() ? map : null
			});
			
			percentMarkerList.push(marker);
			markerList.push(marker);
		});
	}

	function showDetail(model) {
		var submit = {
			hc: model.Code_Facility_T,
			from: self.monthFrom().format('YYYYMM'),
			to: self.monthTo().format('YYYYMM')
		};
		app.ajax('/PvRadicalCureMap/getDetail', submit).done(function (rs) {
			if (mapFilter != 'Primaquine') rs = rs.filter(r => r.PrimaquineDate != '');
			self.detailList(rs);

			$('#modalDetail .modal-title').text(model.Name_Facility_E + ' (Normal G6PD Only)');
			$('#modalDetail').modal('show');
			$('#modalDetail .modal-body').scrollTop(0);
		});
	}

	self.filterChanged = function (element) {
        mapFilter = element.value;
		updateMap();
	};

	self.pv.subscribe(function (code) {
		if (code == null) {
			map.setCenter({ lat: 12.5, lng: 105 });
			map.setZoom(zoom);
			self.odList([]);
		} else {
			var ods = place.od.filter(r => r.pvcode == code).map(r => r.code);
			var bounds = new google.maps.LatLngBounds();
			googleODBorder.filter(r => ods.contain(r.code)).forEach(od => {
				od.coor.forEach(a => {
					a.forEach(b => {
						b.forEach(r => bounds.extend({ lat: r[0], lng: r[1] }));
					});
				});
			});
			map.fitBounds(bounds);

			let od = place.od.filter(r => r.pvcode == self.pv())
			self.odList(od);
		}

		running = true;
		setTimeout(() => running = false);
	});

	self.od.subscribe(function (code) {
		if (running) return;

		if (code == null) {
			self.pv.notifySubscribers(self.pv());
		} else {
			var bounds = new google.maps.LatLngBounds();
			googleODBorder.find(r => r.code == code).coor.forEach(a => {
				a.forEach(b => {
					b.forEach(r => bounds.extend({ lat: r[0], lng: r[1] }));
				});
			});
			map.fitBounds(bounds);
		}
	});

    self.displayPercent.subscribe(function (value) {
		percentMarkerList.forEach(r => r.setMap(value ? map : null));
	});
}