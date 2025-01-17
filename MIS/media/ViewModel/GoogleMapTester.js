var app = { vm: new viewModel() };

function viewModel() {
	var self = this;
	var map = null;
	var ctx = document.getElementById('canvas').getContext('2d');

	self.phpError = function (html) {
		var title = '<title>PHP Error</title>';
		open().document.write(title + html);
	};

	readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
		eval(script);

		var submit = {
			year: 2021,
			from: 1,
			to: 6,
			prov: '',
			filterDateCase: 0
		};

		$.ajax({
			url: '/Dashboard/tabMap/',
			method: 'POST',
			data: submit,
			headers: { caller: 'ajax' },
			dataType: 'json'
		}).done(function (rs) {
			drawmap(rs.mapTop30Vill);
			draw(rs.mapTop30Vill);
		});
	});

	function draw(rs) {
		var image = new Image();
		image.src = '/media/images/hotspot-map-logo.jpg';
		image.onload = function () {
			ctx.drawImage(image, 0, 0);

			var data = rs.filter(r => r.Lat != null);
			data.distinct(r => r.Code_Vill_T).forEach(v => {
				var x = (v.long * 158) - 16090;
				var y = 2425 - (v.Lat * 162);

				var temp = selectHotspot(data, v.Total, v.N);

				ctx.beginPath();
				ctx.arc(x, y, temp.scale, 0, Math.PI * 2);
				ctx.strokeStyle = temp.strokeColor;
				ctx.stroke();
				ctx.fillStyle = temp.fillColor + 'b3';
				ctx.fill();
			});
		};
	}

	function readFileInZip(zipfileUrl, filenameInZip, callback) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', zipfileUrl, true);
		xhr.responseType = 'blob';

		xhr.onload = function () {
			new JSZip().loadAsync(this.response).then(function (zip) {
				zip.file(filenameInZip).async('string').then(callback);
			});
		};

		xhr.send();
	}

	Array.prototype.distinct = function (callbackOrName) {
		return this.reduce(function (rs, value) {
			var existed = rs.some(r => {
				return callbackOrName === undefined ? r == value
					: typeof callbackOrName == 'function' ? callbackOrName(r) == callbackOrName(value)
					: r[callbackOrName] == value[callbackOrName];
			});
			if (!existed) rs.push(value);
			return rs;
		}, []);
	};

	function drawmap(data) {
		data = data.filter(r => r.Lat != null && r.long != null);

		var options = {};
		options.center = { lat: 12.5, lng: 105 };
		options.zoom = 7.8;
		options.mapTypeId = 'terrain';
		options.streetViewControl = false;
		options.fullscreenControl = false;
		options.styles = [{ featureType: 'all', elementType: 'labels', stylers: [{ visibility: 'off' }] }];

		var map = new google.maps.Map(document.getElementById('map'), options);
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

		var polygon = new google.maps.Polygon({
			paths: polygonBorders,
			strokeColor: '#2980b9',
			strokeWeight: 1.0,
			fillOpacity: 0,
			map: map
		});

		var adjust = {
			'Kralanh': [-0.05, -0.05],
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
			'Chhlong': [0.05, 0],
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

			new MapLabel({ text: r.name, position: pos, map: map, strokeWeight: 0 });
		});

		data.distinct(r => r.Code_Vill_T).forEach(v => {
			new google.maps.Marker({
				position: { lat: parseFloat(v.Lat), lng: parseFloat(v.long) },
				icon: selectHotspot(data, v.Total, v.N),
				zIndex: 2,
				map: map
			});
		});
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
}