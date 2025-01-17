function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
    self.importModel = { name: ko.observable(), status: ko.observable() };
    self.view = ko.observable('completeness')
    self.month = ko.observable(moment().format('MMM'));
    self.mf = ko.observable(moment().month(0));
    self.listData = ko.observableArray();

	app.ajax('/BorderImport/getData').done(prepare);

	function prepare(rs) {
		var list = [];
		var years = rs.map(r => r.YearMonth.substr(0, 4)).distinct();
		for (var y of years) {
			var months = [];
			for (var m = 1; m <= 12; m++) {
				var ym = y + ('0' + m).substr(-2);
				months.push(rs.some(r => r.YearMonth == ym));
			}
			list.push({ year: y, months });
		}
		self.listModel(list);
	}

	self.selectFile = function () {
		$('#file').val('').click();
	};

	self.fileChanged = function (files) {
		self.importModel.name(files[0].name);
		self.importModel.status('Importing');
		$('#modalImport').modal('show');

		var reader = new FileReader();
		reader.onload = function () {
			var submit = { base64: reader.result.split(',')[1] };
			app.ajax('/BorderImport/importExcel', submit, false).done(function (rs) {
				prepare(rs);
				$('#modalImport').modal('hide');
			});
		};
		reader.readAsDataURL(files[0]);
    };

    self.viewClick = function () {
        var submit = {
            yearMonth: self.mf().format('YYYYMM'),
        };

        app.ajax('/BorderImport/getList', submit).done(function (rs) {
            self.listData(rs);
        })
    }
}