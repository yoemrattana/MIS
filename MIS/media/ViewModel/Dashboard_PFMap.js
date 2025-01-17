if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {
	self.tablePf = ko.observableArray();
	self.tablePfCount = ko.observableArray();

	var map = null;
	var markerList = [];
	var circles = [
		{ name: '1 Case', color: 'blue', range: [1, 1] },
		{ name: '2 - 5 Cases', color: 'lime', range: [2, 5] },
		{ name: '6 - 10 Cases', color: 'yellow', range: [6, 10] },
		{ name: '11 - 20 Cases', color: 'orange', range: [11, 20] },
		{ name: '> 20 Cases', color: 'red', range: [21, 1000000] }
	];
	var mapTitle = null;

	self.showTabPFMap = function () {
		app.ajax('/Dashboard/tabPFMap/', self.lastSubmit).done(function (rs) {
			Object.keys(rs).forEach(key => self.mainData[key] = rs[key]);

			drawPFMap();
			self.tablePf(self.mainData.pfMap);
			self.tablePfCount(self.mainData.pfMapCount);

			self.loaded(true);
		});
	};

	function drawPFMap() {
		if (map == null) {
			map = app.createGoogleMap('mapPf', {
				zoom: 7.3,
				zoomControlOptions: { position: google.maps.ControlPosition.TOP_RIGHT },
				mapTypeControl: false
			});

			var legend = document.createElement('div');
			legend.style = 'padding:10px; margin:10px; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';

			var title = document.createElement('div');
			title.style = 'margin-bottom:5px';
			title.innerHTML = '<b>Number of PF + Mix</b><br>';
			legend.appendChild(title);

			for (var c of circles) {
				var div = document.createElement('div');
				div.style = 'margin-bottom:5px; line-height:16px';
				div.innerHTML = '<span style="width:15px; height:15px; background:' + c.color + '; border:1px solid; border-radius:50%; float:left"></span>';
				div.innerHTML += '<span style="padding-left:5px" class="font12">' + c.name + '</span>';
				legend.appendChild(div);
			}
			map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

			mapTitle = document.createElement('div');
			mapTitle.style = 'font-size:18px; padding:8px; margin:10px; background:white; box-shadow:rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius:2px';
			map.controls[google.maps.ControlPosition.TOP_CENTER].push(mapTitle);
		}
		mapTitle.innerHTML = 'Pf and Mix Cases by Health Center, ' + self.from() + '-' + self.to() + ' ' + self.year();

		markerList.forEach(r => r.setMap(null));
		markerList = [];

		self.mainData.pfMap.forEach(i => {
			var marker = new google.maps.Marker({
				position: { lat: i.Lat, lng: i.Long },
				icon: {
					path: google.maps.SymbolPath.CIRCLE,
					fillOpacity: 1,
					fillColor: circles.find(r => i.PfMix >= r.range[0] && i.PfMix <= r.range[1]).color,
					strokeColor: '#555',
					strokeWeight: 1,
					scale: 5
				},
				map: map
			});
			markerList.push(marker);

			var txt = '<b>OD:</b> ' + i.Name_OD_E
					+ '<br><b>HC:</b> ' + i.Name_Facility_E
					+ '<br><b>PF + Mix:</b> ' + i.PfMix;

			var infowindow = new google.maps.InfoWindow({ content: txt });
			marker.addListener('mouseover', () => infowindow.open(map, marker));
            marker.addListener('mouseout', () => infowindow.close());

            marker.addListener("click", () => {
                self.showCase(i.Code_Facility_T);
            });
		});
    }

    self.showCase = (Code_Facility_T) => {
        self.title('PF + Mix');
        $.when(getPfMix(Code_Facility_T)).then(function () {
            $('#modalCase').modal('show');
        });
    }

    function getPfMix(Code_Facility_T) {
        self.cases([]);
        let from = moment().month(self.from()).format("M");
        let to = moment().month(self.to()).format("M");
        app.ajax('/Dashboard/getPfMix', { Code_Facility_T: Code_Facility_T, Year: self.year(), From: from, To: to }).done(function (rs) {
            self.cases(rs);
        });
    }

	self.exportPFMap = function (onSuccess) {
		var image = new Image();
		image.src = '/media/images/pf-map.jpg';
		image.onload = function () {
			var canvas = document.createElement('canvas');
			canvas.width = this.width;
			canvas.height = this.height;

			var ctx = canvas.getContext('2d');
			ctx.drawImage(this, 0, 0);

			var title = 'Pf and Mix Cases by Health Center, ' + self.from() + '-' + self.to() + ' ' + self.year();
			ctx.textAlign = 'center';
			ctx.font = '20px sans-serif';
			ctx.fillText(title, this.width / 2, 30);

			self.mainData.pfMap.forEach(i => {
				var x = (i.Long * 158) - 16090;
				var y = 2425 - (i.Lat * 162);

				ctx.beginPath();
				ctx.arc(x, y, 5, 0, Math.PI * 2);
				ctx.stroke();
				ctx.fillStyle = circles.find(r => i.PfMix >= r.range[0] && i.PfMix <= r.range[1]).color;
				ctx.fill();
			});

			onSuccess(canvas.toDataURL('image/jpeg', 1));
		};
	};
});