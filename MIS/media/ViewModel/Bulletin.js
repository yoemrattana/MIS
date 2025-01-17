function viewModel() {
	var self = this;

	self.view = ko.observable('list');
	self.listModel = ko.observableArray();
	self.editModel = ko.observable();
	self.tableModel = ko.observableArray();
	self.isNew = ko.observable(true);

	self.pvList = ko.observableArray();
	self.pv = ko.observable(app.user.prov);
	self.month = ko.observable(null);
	self.modalPv = ko.observable();

	var place = null;
	var prov = null;

	app.getPlace(['pv'], function (p) {
		place = p;
		self.pvList(self.pv() == '' ? place.pv.filter(r => r.target == 1) : place.pv.filter(r => r.code == self.pv()));

		app.ajax('/Bulletin/getList').done(function (rs) {
			self.listModel(rs);
		});
	});

	self.getListModel = ko.pureComputed(function () {
		var list = self.listModel();
		if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());
		if (self.month() != null) list = list.filter(r => r.Year + r.Month == self.month().format('YYYYMM'));
		return list;
	});

	function showProvince() {
		$('#modalProvince').modal('show');
		$('#modalProvince .btn-primary').off().click(function () {
			$('#modalProvince').modal('hide');
			self.showNew(self.modalPv());
		});
	}

	self.showNew = function (pvcode) {
		prov = app.user.prov;
		
		if (prov == '') {
			if (typeof pvcode == 'object') {
				showProvince();
				return;
			} else {
				prov = pvcode;
			}
		}

		var model = {
			Year: moment().format('YYYY'),
			Month: moment().format('MM'),
			PublishDate: moment(),
			Volume: 1,
			Code_Prov_T: prov,
			Infrastructure: null,
			CaseloadData: null,
			Photo: ko.observable(),
			Activity: [],
			Challenge: [],
			WayForward: [],
			InitUser: app.user.username
		};
		var arr = self.listModel().filter(r => r.Year == model.Year && r.Month == model.Month && r.Code_Prov_T == prov);
		model.Volume = arr.length == 0 ? 1 : Math.max(...arr.map(r => r.Volume)) + 1;

		for (var i = 0; i < 6; i++) model.Activity.push({ text: '' });
		for (var i = 0; i < 3; i++) model.Challenge.push({ text: '' });
		for (var i = 0; i < 5; i++) model.WayForward.push({ text: '' });

		var submit = {
			prov: prov,
			from: moment().add(-2, 'month').format('YYYYMM'),
			to: moment().format('YYYYMM')
		};
		app.ajax('/Bulletin/getNewData', submit).done(function (rs) {
			model.Infrastructure = rs.infra;
			model.CaseloadData = { chart: rs.chart, table: rs.table };

			self.editModel(model);
			self.tableModel(rs.table.groupby('Name_OD_E'));
			self.isNew(true);
			self.view('detail');

			drawChart(rs.chart);
		});
	};

	self.showDetail = function (model) {
		prov = model.Code_Prov_T;

		var submit = { id: model.Rec_ID };
		app.ajax('/Bulletin/getOldData', submit).done(function (rs) {
			rs.PublishDate = moment(rs.PublishDate);
			rs.Infrastructure = JSON.parse(rs.Infrastructure);
			rs.CaseloadData = JSON.parse(rs.CaseloadData);
			rs.Photo = rs.Photo == null ? null : '/media/Bulletin/' + rs.Photo;
			rs.Activity = JSON.parse(rs.Activity);
			rs.Challenge = JSON.parse(rs.Challenge);
			rs.WayForward = JSON.parse(rs.WayForward);

			self.editModel(rs);
			self.tableModel(rs.CaseloadData.table.groupby('Name_OD_E'));
			self.isNew(false);
			self.view('detail');

			drawChart(rs.CaseloadData.chart);
		});
	};

	self.save = function () {
		var model = self.editModel();
		model.PublishDate = model.PublishDate.format('YYYY-MM-DD');
		model.Infrastructure = JSON.stringify(model.Infrastructure);
		model.CaseloadData = JSON.stringify(model.CaseloadData);
		model.Photo = model.Photo() == null ? null : model.Photo().split(',')[1];
		model.Activity = JSON.stringify(model.Activity);
		model.Challenge = JSON.stringify(model.Challenge);
		model.WayForward = JSON.stringify(model.WayForward);

		var submit = { submit: JSON.stringify(model) };
		app.ajax('/Bulletin/save', submit).done(function (arr) {
			self.listModel.push(arr[0]);
			self.view('list');
		});
	};

	self.delete = function (model) {
		app.showDelete(function () {
			var submit = {
				table: 'tblBulletin',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.back = function () {
		self.view('list');
	};

	self.getProvName = function (code) {
		return place.pv.find(r => r.code == code).name;
	};

	self.get3Row = function (index) {
		return self.tableModel().slice(index * 3, (index + 1) * 3);
	};

	self.fulfill = function (index) {
		var len = ((index + 1) * 3) - self.tableModel().length;
		return len < 0 ? 0 : len;
	};

	self.getValue = function (arr, type, col) {
		var found = arr.find(r => r.Type == type);
		return found == null ? '-' : found[col] + (col.contain('Rate') ? '%' : '');
	};

	self.getSum = function (arr, col) {
		return arr.sum(r => parseInt(r[col]));
	};

	self.getSum3 = function (index, col) {
		var arr = self.get3Row(index).flat();
		return arr.sum(r => parseInt(r[col]));
	};

	self.getAvg = function (arr, col) {
		return Math.round(arr.sum(r => parseInt(r[col])) / arr.length) + (col.contain('Rate') ? '%' : '');
	};

	self.getAvg3 = function (index, col) {
		var arr = self.get3Row(index).flat();
		return Math.round(arr.sum(r => parseInt(r[col])) / arr.length) + (col.contain('Rate') ? '%' : '');
	};

	self.selectFile = function () {
		$('#file').val('').click();
	};

	self.fileChanged = function (files) {
		var reader = new FileReader();
		reader.onload = function () {
			var img = new Image();
			img.src = reader.result;
			img.onload = function () {
				var w = img.width > 400 ? 400 : img.width;
				var h = img.height * (w / img.width);

				var canvas = document.createElement('canvas');
				canvas.width = w;
				canvas.height = h;

				var ctx = canvas.getContext('2d');
				ctx.drawImage(img, 0, 0, w, h);

				self.editModel().Photo(canvas.toDataURL('image/jpeg', 0.9));
			};
		};
		reader.readAsDataURL(files[0]);
	};

	function drawChart(data) {
		var arrMonth = data.map(r => moment(r.Month, 'MM').format('MMM'));
		var arrRate = data.map(r => Math.round(r.Positive * 100 / r.Test));

		$('#chart1').highcharts({
			chart: { type: 'column' },
			title: { text: 'POSITIVITY RATE BY MONTH', style: { fontWeight: 'bold', color: '#002060' } },
			subtitle: { text: self.getProvName(prov), style: { fontSize: '14px', color: '#002060' } },
			colors: ['#92D050', '#ED7D31', '#00B0F0'],
			xAxis: { categories: arrMonth, crosshair: true, gridLineWidth: 1 },
			yAxis: [{ title: { text: 'Number of Cases' } }, { title: { text: 'Positive Rate' }, labels: { format: '{value}%' }, opposite: true, max: 100 }],
			tooltip: { shared: true },
			exporting: { sourceWidth: 1200, sourceHeight: 800 },
			legend: { layout: 'vertical', align: 'right', verticalAlign: 'middle' },
			plotOptions: {
				series: { dataLabels: { enabled: true } },
				spline: { dataLabels: { format: '{y}%' } }
			},
			series: [
				{ name: '# Tested', data: data.map(r => r.Test) },
				{ name: '# Positive', data: data.map(r => r.Positive) },
				{ name: 'Positive Rate (%)', type: 'spline', data: arrRate, yAxis: 1, tooltip: { valueSuffix: '%' } }
			]
		});

		$('#chart2').highcharts({
			chart: { type: 'bar', height: 300 },
			title: { text: 'POSITIVITY RATE BY SPECIES', style: { fontWeight: 'bold', color: '#002060' } },
			subtitle: { text: self.getProvName(prov), style: { fontSize: '14px', color: '#002060' } },
			colors: ['#00B0F0', '#ED7D31', '#92D050'],
			xAxis: { categories: arrMonth, crosshair: true, gridLineWidth: 1 },
			yAxis: { title: { text: '' }, reversedStacks: false, labels: { format: '{value}%' } },
			tooltip: { shared: true, valueSuffix: '%' },
			exporting: { sourceWidth: 1200, sourceHeight: 800 },
			legend: { layout: 'vertical', align: 'right', verticalAlign: 'middle' },
			plotOptions: {
				bar: {
					stacking: 'percent',
					dataLabels: {
						enabled: true,
						format: '{point.percentage:.0f}%',
						style: { color: '#002060', textOutline: '1px' }
					}
				}
			},
			series: [
				{ name: '% PF', data: data.map(r => r.Pf) },
				{ name: '% Mix', data: data.map(r => r.Mix) },
				{ name: '% PV', data: data.map(r => r.Pv) }
			]
		});
	}
}