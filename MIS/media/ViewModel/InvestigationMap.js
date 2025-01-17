function viewModel() {
	var self = this;

	var map = null;
	var markerList = [];
	var lineList = [];
	var maindata = [];
	var distanceMarker = [];
	var place = null;

	var distanceLine = new google.maps.Polyline({
		strokeColor: '#3273EB',
		strokeWeight: 2
	});

	var distanceLabel = new google.maps.Marker({
		icon: {
			path: 'M -6 -2 L 6 -2 L 6 1.5 L -6 1.5 z',
			fillColor: 'yellow',
			strokeWeight: 0,
			fillOpacity: 1,
			scale: 5,
		}
	});

	self.pvList = ko.observableArray();
	self.pv = ko.observable('05');
	self.monthFrom = ko.observable(moment());
	self.monthTo = ko.observable(moment());
	self.species = ko.observable('FM');
	self.measure = ko.observable(false);
	self.displayLabel = ko.observable(false);
	self.listModel = ko.observableArray();
	self.bigModal = ko.observable(false);

	app.getPlace(['pv', 'vl'], function (p) {
		place = p;
		place.pv = place.pv.filter(r => r.target == 1);
		self.pvList(place.pv);
	});

	app.readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
		eval(script);

		var returnObj = {};
		map = app.createGoogleMap('map', {
			zoom: 7.8,
		}, returnObj);

		[
			{ name: 'Chamlong Teav', lat: 11.41177, long: 104.0399 },
			{ name: 'ChamBok', lat: 11.40421, long: 104.0756 },
		].forEach(r => {
			var marker = new google.maps.Marker({
				position: { lat: r.lat, lng: r.long },
				icon: '/media/images/marker-forest-ranger.png?2',
				map: map
			});

			var infowindow = new google.maps.InfoWindow({ content: `<b>Forest Ranger Post:<br>${r.name}</b>` });
			marker.addListener('mouseover', () => infowindow.open(map, marker));
			marker.addListener('mouseout', () => infowindow.close());

			marker.addListener('click', function (e) {
				if (self.measure()) {
					drawDistanceMarker(e);
					return;
				}
			});
		});

		[
            { name: 'Spean Thmor', lat: 11.484532, long: 103.973237, patient: 0},
            { name: 'Boeung Chumpou', lat: 11.48354, long: 104.01489, patient: 0},
            { name: 'Tronoab Sa Uy', lat: 11.397211, long: 103.956828, patient: 0},

            { name: 'កំពង់ពូលឿន', lat: 12.125080, long: 103.959746, patient: 0},
            { name: 'ដំណាក់បំបែករោងម៉ាស៊ីន', lat: 12.123665, long: 103.979445, patient: 0 },
            { name: 'ដើមថ្កូវ', lat: 12.128833, long: 103.979877, patient: 0},
            { name: 'ដំណាក់ដើមថ្កូវចាស់', lat: 12.129010, long: 103.980590, patient: 0 },
            { name: 'ដំណាក់ដើមថ្កូវទី១  ', lat: 12.129553, long: 103.982240, patient: 0 },
            { name: 'ដំណាក់ដើមថ្កូវទី២', lat: 12.130293, long: 103.983473, patient: 0},
            { name: 'ដំណាក់ដើមថ្កូវ (កន្លែងអ្នកឈឺដេកនៅ)', lat: 12.129787, long: 103.982730, patient: 1},
		].forEach(r => {
			var circle = new google.maps.Circle({
				center: { lat: r.lat, lng: r.long },
                radius: r.name.in('Spean Thmor', 'Boeung Chumpou', 'Tronoab Sa Uy') ? 1500 : 0,
				strokeColor: 'red',
				strokeWeight: 1,
				fillColor: 'red',
				fillOpacity: 0.2,
				map: map
			});

			var marker = new google.maps.Marker({
                position: { lat: r.lat, lng: r.long },
                icon: r.patient == 0 ? '/media/images/marker-tree.png?2' : '/media/images/marker-tree-yellow.png?2',
				map: map
			});

			var infowindow = new google.maps.InfoWindow({ content: `<b>Hotspot: ${r.name}</b>` });
			marker.addListener('mouseover', () => infowindow.open(map, marker));
			marker.addListener('mouseout', () => infowindow.close());

			circle.addListener('click', function (e) {
				if (self.measure()) {
					drawDistanceMarker(e);
					return;
				}
			});

			marker.addListener('click', function (e) {
				if (self.measure()) {
					drawDistanceMarker(e);
					return;
				}
			});
		});

		map.addListener('click', drawDistanceMarker);
		returnObj.polygon.addListener('click', drawDistanceMarker);

		var legend = document.createElement('div');
		legend.style = 'padding:10px; margin:10px 10px 0 0; background:white; box-shadow:#0000004d 0px 1px 4px -1px; border-radius:2px';

		var div = document.createElement('div');
		div.style = 'display:table';
		div.innerHTML = '<div class="inlineblock" style="width:30px; height:20px; background:red"></div>'
			+ '<span style="display:table-cell; vertical-align:middle; padding-left:5px; font-size:12px">PF + Mix</span>';
		legend.appendChild(div);

		var div = document.createElement('div');
		div.style = 'display:table';
		div.innerHTML = '<div class="inlineblock" style="width:30px; height:20px; background:#ff8c00"></div>'
			+ '<span style="display:table-cell; vertical-align:middle; padding-left:5px; font-size:12px">PV</span>';
		legend.appendChild(div);

		var div = document.createElement('div');
		div.style = 'display:table';
		div.innerHTML = '<img src="/media/images/marker-forest-ranger.png?2" width="24" height="20" style="margin:2px 1px" />'
			+ '<span style="display:table-cell; vertical-align:middle; padding-left:8px; font-size:12px">Forest Ranger</span>';
		legend.appendChild(div);

		var div = document.createElement('div');
		div.style = 'display:table';
		div.innerHTML = '<img src="/media/images/marker-cross.png?2" width="14" height="22" style="margin:2px 6px" />'
			+ '<span style="display:table-cell; vertical-align:middle; padding-left:8px; font-size:12px">Unknown Location</span>';
		legend.appendChild(div);

		var div = document.createElement('div');
		div.style = 'display:table';
		div.innerHTML = '<img src="/media/images/marker-vmw-small.png?2" width="14" height="22" style="margin:2px 6px" />'
			+ '<span style="display:table-cell; vertical-align:middle; padding-left:8px; font-size:12px">VMW</span>';
		legend.appendChild(div);

		var div = document.createElement('div');
		div.style = 'display:table';
		div.innerHTML = '<img src="/media/images/marker-mmw.png?2" width="14" height="22" style="margin:2px 6px" />'
			+ '<span style="display:table-cell; vertical-align:middle; padding-left:8px; font-size:12px">MMW</span>';
		legend.appendChild(div);

		var div = document.createElement('div');
		div.style = 'display:table';
		div.innerHTML = '<img src="/media/images/marker-tree.png?2" width="14" height="22" style="margin:5px 6px" />'
			+ '<span style="display:table-cell; vertical-align:middle; padding-left:8px; font-size:12px">Hotspot</span>';
		legend.appendChild(div);

		var div = document.createElement('div');
		div.style = 'display:table';
		div.innerHTML = '<img src="/media/images/north.png?2" width="20" height="26" style="margin:0px 3px" />'
			+ '<span style="display:table-cell; vertical-align:middle; padding-left:8px; font-size:12px">North</span>';
		legend.appendChild(div);

		map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);

		self.viewClick();
	});

	self.measure.subscribe(function (v) {
		if (v == false) {
			distanceMarker.forEach(r => r.setMap(null));
			distanceMarker = [];
			distanceLine.setMap(null);
			distanceLabel.setMap(null);
		}
	});

	self.viewClick = function () {
		var submit = {
			from: self.monthFrom().format('YYYYMM'),
			to: self.monthTo().format('YYYYMM'),
			species: self.species()
		};
		app.ajax('/InvestigationMap/getData', submit).done(function (rs) {
			maindata = rs;

			markerList.forEach(r => r.setMap(null));
			lineList.forEach(r => r.setMap(null));
			markerList = [];
			lineList = [];

			drawHC();
		});
	};

	function drawHC() {
		var founds = self.pv() == null ? maindata : maindata.filter(r => r.Code_Prov_N == self.pv());

		founds.forEach(hc => {
			var positive = hc.Pf + hc.Pv + hc.Mix;
			var color = hc.Pf + hc.Mix > 0 ? 'red' : '#ff8c00';

			var label = new MapLabel({
				text: positive,
				position: new google.maps.LatLng(hc.Lat, hc.Long),
				strokeWeight: 0,
				fontSize: 'bold 14',
				fontColor: color,
				map: map
			});
			markerList.push(label);

			var marker = new google.maps.Marker({
				position: { lat: hc.Lat, lng: hc.Long },
				icon: {
					path: google.maps.SymbolPath.CIRCLE,
					strokeWeight: 0,
					scale: 8,
					labelOrigin: { x: 0, y: 2 }
				},
				label: {
					text: hc.Name_Facility_E,
					fontSize: '14px',
					color: color
				},
				map: map
			});
			markerList.push(marker);

			var txt = '<b>OD:</b> ' + hc.Name_OD_E
					+ '<br><b>HC:</b> ' + hc.Name_Facility_E
					+ '<br><b>PF:</b> ' + hc.Pf
					+ '<br><b>PV:</b> ' + hc.Pv
					+ '<br><b>Mix:</b> ' + hc.Mix;

			var infowindow = new google.maps.InfoWindow({ content: txt });
			marker.addListener('mouseover', () => infowindow.open(map, marker));
			marker.addListener('mouseout', () => infowindow.close());

			marker.addListener('click', function (e) {
				if (self.measure()) {
					drawDistanceMarker(e);
					return;
				}

				google.maps.event.clearListeners(marker, 'click');

				if (map.getZoom() < 11) {
					map.panTo(marker.getPosition());
					map.setZoom(11);
					setTimeout(() => drawVillage(hc.Code_Facility_T, marker, txt), 1000);
				} else {
					drawVillage(hc.Code_Facility_T, marker, txt);
				}
			});
		});
	}

	function drawVillage(hccode, hcMarker, hctxt) {
		var submit = {
			from: self.monthFrom().format('YYYYMM'),
			to: self.monthTo().format('YYYYMM'),
			hccode: hccode,
			species: self.species()
		};
		app.ajax('/InvestigationMap/getVillage', submit).done(function (rs) {
			var obj = {
				vlMarker: [],
				vlLine: [],
				houseMarker: [],
				houseLine: []
			};

			rs.filter(r => r.Lat != null && r.Long != null).groupby('Code_Vill_T').forEach(arr => {
				var vl = arr[0];
				var positive = null;

				if (vl.Inv != null) {
					vl.Pf = arr.filter(r => r.Diagnosis == 'F').length;
					vl.Pv = arr.filter(r => r.Diagnosis == 'V').length;
					vl.Mix = arr.filter(r => r.Diagnosis == 'M').length;
					positive = vl.Pf + vl.Pv + vl.Mix;
				}

				if (positive != null) {
					var label = new MapLabel({
						text: positive,
						position: new google.maps.LatLng(vl.Lat, vl.Long),
						strokeWeight: 0,
						fontSize: 'bold 14',
						fontColor: vl.Pf + vl.Mix > 0 ? 'red' : '#ff8c00',
						map: map
					});
					markerList.push(label);
					obj.vlMarker.push(label);

					var marker = new google.maps.Marker({
						position: { lat: vl.Lat, lng: vl.Long },
						icon: {
							path: google.maps.SymbolPath.CIRCLE,
							strokeWeight: 0,
							scale: 8,
							labelOrigin: { x: 0, y: 2 }
						},
						label: {
							text: vl.Name_Vill_E,
							fontSize: '14px',
							color: 'blue'
						},
						map: map
					});
					markerList.push(marker);
					obj.vlMarker.push(marker);
				} else {
					var marker = new google.maps.Marker({
						position: { lat: vl.Lat, lng: vl.Long },
						icon: {
							url: '/media/images/' + (vl.Name_Vill_E.contain('(M)') ? 'marker-mmw.png?2' : 'marker-vmw-small.png?2'),
							labelOrigin: { x: 13, y: 55 }
						},
						map: map
					});
					markerList.push(marker);
					obj.vlMarker.push(marker);
				}

				if (positive != null) {
					var a = hcMarker.getPosition();
					var b = marker.getPosition();
					var line = new google.maps.Polyline({
						path: [a, b],
						strokeOpacity: 0,
						icons: [{
							icon: {
								path: 'M 0,-1 0,1',
								strokeOpacity: 1,
								strokeColor: 'blue',
								scale: 1
							},
							offset: '0',
							repeat: '7px'
						}],
						map: map
					});
					lineList.push(line);
					obj.vlLine.push(line);
				}

				if (positive != null) {
					var txt = '<b>Village:</b> ' + vl.Name_Vill_E
							+ '<br><b>PF:</b> ' + vl.Pf
							+ '<br><b>PV:</b> ' + vl.Pv
							+ '<br><b>Mix:</b> ' + vl.Mix
							+ '<br><b>VMW:</b> ' + vl.VMW;
				} else {
					var title = vl.Name_Vill_E.contain('(M)') ? 'MMW' : 'VMW'
					var txt = `<b>${title}:</b> ${vl.Name_Vill_E}`;
				}

				var infowindow = new google.maps.InfoWindow({ content: txt });
				marker.addListener('mouseover', () => infowindow.open(map, marker));
				marker.addListener('mouseout', () => infowindow.close());

				marker.addListener('click', function (e) {
					if (self.measure()) {
						drawDistanceMarker(e);
						return;
					}

					if (positive != null) {
						self.listModel(arr);
						self.bigModal(false);
						$('#modalList .modal-title').text(vl.Name_Vill_E);
						$('#modalList').modal('show');
						$('#modalList .modal-body').scrollTop(0);
					}
				});
			});

			var arrNoLocation = rs.filter(r => r.Lat == null || r.Long == null);
			if (arrNoLocation.length > 0) {
				google.maps.event.clearListeners(hcMarker, 'mouseover');
				google.maps.event.clearListeners(hcMarker, 'mouseout');

				var txt = hctxt + '<br><b>Non-Coordinate Village:</b> ' + arrNoLocation.groupby('Code_Vill_T').length;

				var infowindow = new google.maps.InfoWindow({ content: txt });
				hcMarker.addListener('mouseover', () => infowindow.open(map, hcMarker));
				hcMarker.addListener('mouseout', () => infowindow.close());

				//--------------------------------------------------------------
				var a = hcMarker.getPosition();
				var b = { lat: a.lat() + 0.002, lng: a.lng() };
				var marker = new google.maps.Marker({
					position: b,
					icon: '/media/images/marker-cross.png?2',
					map: map
				});
				markerList.push(marker);
				obj.houseMarker.push(marker);

				var line = new google.maps.Polyline({
					path: [a, b],
					strokeOpacity: 0,
					icons: [{
						icon: {
							path: 'M 0,-1 0,1',
							strokeOpacity: 1,
							strokeColor: '#cc00a9',
							scale: 1
						},
						offset: '0',
						repeat: '7px'
					}],
					zIndex: 9,
					map: map
				});
				lineList.push(line);
				obj.houseLine.push(line);

				var txt = '<b>Non-Coordinate Villages:</b>'
						+ '<br><b>PF:</b> ' + arrNoLocation.filter(r => r.Diagnosis == 'F').length
						+ '<br><b>PV:</b> ' + arrNoLocation.filter(r => r.Diagnosis == 'V').length
						+ '<br><b>Mix:</b> ' + arrNoLocation.filter(r => r.Diagnosis == 'M').length;

				var infowindow2 = new google.maps.InfoWindow({ content: txt });
				marker.addListener('mouseover', () => infowindow2.open(map, marker));
				marker.addListener('mouseout', () => infowindow2.close());

				marker.addListener('click', function (e) {
					if (self.measure()) {
						drawDistanceMarker(e);
						return;
					}

					self.listModel(arrNoLocation);
					self.bigModal(true);
					$('#modalList .modal-title').text('Non-Coordinate Villages');
					$('#modalList').modal('show');
					$('#modalList .modal-body').scrollTop(0);
				});
			}

			hcMarker.addListener('click', function (e) {
				if (self.measure()) {
					drawDistanceMarker(e);
					return;
				}

				if (obj.vlMarker[0].getMap() == null) {
					obj.vlMarker.forEach(r => r.setMap(map));
					obj.vlLine.forEach(r => r.setMap(map));
					obj.houseMarker.forEach(r => r.setMap(map));
					obj.houseLine.forEach(r => r.setMap(map));
				} else {
					obj.vlMarker.forEach(r => r.setMap(null));
					obj.vlLine.forEach(r => r.setMap(null));
					obj.houseMarker.forEach(r => r.setMap(null));
					obj.houseLine.forEach(r => r.setMap(null));
				}
			});
		});
	}

	self.displayLabel.subscribe(function (isTrue) {
		map.setOptions({
			styles: [{ elementType: 'labels', stylers: [{ visibility: isTrue ? 'on' : 'off' }] }]
		});
	});

	function drawDistanceLine() {
		distanceLine.setPath(distanceMarker.map(r => r.getPosition()));

		var bounds = new google.maps.LatLngBounds();
		distanceMarker.forEach(r => bounds.extend(r.getPosition()));

		distanceLabel.setPosition(bounds.getCenter());

		var a = distanceMarker[0].getPosition();
		var b = distanceMarker[1].getPosition();
		var km = google.maps.geometry.spherical.computeDistanceBetween(a, b) / 1000;

		distanceLabel.setLabel({
			text: parseFloat(km.toFixed(1)).toString() + 'km',
			fontSize: '14px',
			color: 'red'
		});
	}

	function drawDistanceMarker(e) {
		if (!self.measure() || distanceMarker.length == 2) return;

		var marker = new google.maps.Marker({
			position: e.latLng,
			draggable: true,
			icon: '/media/images/marker-blue.png?2',
			map: map
		});
		distanceMarker.push(marker);

		marker.addListener('drag', function () {
			if (distanceMarker.length == 2) drawDistanceLine();
		});

		if (distanceMarker.length == 2) {
			drawDistanceLine();
			distanceLine.setMap(map);
			distanceLabel.setMap(map);
		}
	}

	function getVillName(code) {
		var found = place.vl.find(r => r.code == code);
		return found == null ? 'Unknown' : found.name;
	}

	self.dropMarker = function (lat, long) {
		new google.maps.Marker({
			position: { lat: lat, lng: long },
			animation: google.maps.Animation.DROP,
			map: map
		});
	};
}