<style>
	#panelmap { position: absolute; left: 10px; right: 10px; top: 10px; bottom: 40px; padding: 5px; }
	#map { height: 100%; }
</style>

<div id="panelmap" class="panel panel-default">
	<div id="map"></div>
</div>

<?=form_hidden('mapdata', json_encode($data))?>
<?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCVXxd9fjjh1c2wrsRlZfyHfEkBiI4XQ8Q"></script>
<script src="/media/JavaScript/maplabel.js"></script>

<script>
	app.readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
		eval(script);
		window.googleODBorder = googleODBorder;
		drawMap();
	});

	function drawMap() {
		var map = new google.maps.Map(document.getElementById('map'), {
			mapTypeId: 'terrain',
			streetViewControl: false,
			fullscreenControl: false,
			styles: [{ featureType: 'all', elementType: 'labels', stylers: [{ visibility: 'off' }] }]
		});

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

		new google.maps.Polygon({
			paths: polygonBorders,
			strokeColor: '#006400',
			strokeWeight: 1.5,
			fillOpacity: 0,
			map: map
		});

		var adjust = {
			'Kralanh': [-0.05, -0.05],
			'Uo Chrov': [-0.04, 0.07],
			'Angkor Chhum': [0.17, 0],
			'Siem Reap': [0, -0.15],
			'Banlung': [0, -0.15],
			'Kampong Chhnang': [-0.1, 0],
			'Boribo': [-0.05, 0],
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
			'Chhlong': [-0.07, 0.15],
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
			if (aj != null) {
				pos = new google.maps.LatLng(pos.lat() + aj[0], pos.lng() + aj[1]);
			}

			new MapLabel({ text: r.name, position: pos, map: map, strokeWeight: 0, fontSize: 14 });
		});

		var data = JSON.parse($('#mapdata').val());
		var hc = data.hc;
		var bounds = new google.maps.LatLngBounds();

		var marker = new google.maps.Marker({
			position: { lat: parseFloat(hc.Lat), lng: parseFloat(hc.long) },
			icon: {
				url: '/media/images/marker-hc.png',
				labelOrigin: new google.maps.Point(14, 50)
			},
			label: {
				text: hc.Name_Facility_E,
				fontSize: '14px',
				color: 'red'
			},
			map: map
		});
		bounds.extend({ lat: parseFloat(hc.Lat), lng: parseFloat(hc.long) });

		
		var list = data.list;
		var founds = list.filter(r => r.Lat == null);
		if (founds.length > 0) {
			var txt = '<b>Non-Coordinate Villages:</b> ' + founds.length
					+ '<br><b>Positive Cases:</b> ' + founds.sum(r => r.Positive);

			var infowindow = new google.maps.InfoWindow({ content: txt });
			marker.addListener('mouseover', () => infowindow.open(map, marker));
			marker.addListener('mouseout', () => infowindow.close());
		}

		list.filter(r => r.Lat != null).forEach(r => {
			var marker = new google.maps.Marker({
				position: { lat: r.Lat, lng: r.long },
				icon: {
					url: '/media/images/marker-blue.png',
					labelOrigin: new google.maps.Point(14, 50)
				},
				label: {
					text: r.Name_Vill_E,
					fontSize: '14px',
					color: 'blue'
				},
				map: map
			});

			var txt = '<b>HC:</b> ' + hc.Name_Facility_E
				+ '<br><b>Village:</b> ' + r.Name_Vill_E
				+ '<br><b>Positive Cases:</b> ' + r.Positive;

			var infowindow = new google.maps.InfoWindow({ content: txt });
			marker.addListener('mouseover', () => infowindow.open(map, marker));
			marker.addListener('mouseout', () => infowindow.close());

			bounds.extend({ lat: r.Lat, lng: r.long });
		});

		map.fitBounds(bounds);
	}
</script>