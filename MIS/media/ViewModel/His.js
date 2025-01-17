function viewModel() {
	var self = this;

	self.listModel = ko.observableArray();
	self.listReport = ko.observableArray();
	self.listDiscrepancy = ko.observableArray();
	self.detailTreat = ko.observableArray();
	self.detailDipstick = ko.observableArray();
	self.detailSlide = ko.observableArray();
	self.detailVMW = ko.observableArray();
	self.view = ko.observable('list');

	self.pvList = ko.observableArray();
	self.odList = ko.observableArray();
	self.hcList = ko.observableArray();
	self.yearList = [];
	self.monthList = [];
	self.pv = ko.observable();
	self.od = ko.observable();
	self.hc = ko.observable();
	self.year = ko.observable(moment().year());
	self.y = ko.observable(moment().year());
	self.month = ko.observable();
	self.m = ko.observable(moment().month());
	self.tab = ko.observable('List');

	self.file = ko.observable();

	this.selectedFiles = ko.observableArray();

	var place = null;
	var mainData = [];
	var reportArr = [];
	var discrepancyArr = [];
	var fileArr = [];

	for (var i = 2018; i <= moment().year() ; i++) {
		self.yearList.push(i);
	}

	for (var i = 1; i <= 12; i++) {
		self.monthList.push(('0' + i).substr(-2));
	}

	app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
		place = p;
		if (app.user.prov != '') {
			place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
			place.od = place.od.filter(r => app.user.prov.contain(r.pvcode));
		}
		if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

		var arr = place.od.map(r => r.pvcode).distinct();
		place.pv = place.pv.filter(r => arr.contain(r.code));
		self.pvList(place.pv);

		getData();
	});

	self.selectFile = function (model, event) {
	    fileArr = [];
		$('#file').val('').click();
	}

	self.fileChanged = function (files) {
	    readFile(files);
	    
	    setTimeout(()=> {
	        uploadFile2();
	    }, 1500)
	}

	function readFile(files) {
	    ko.utils.arrayForEach(files, function (file) {
	        var reader = new FileReader();
	        reader.onload = function () {
	            let item = {
	                b64: reader.result.split(',')[1],
                    name: file.name
	            };
	            fileArr.push(item);
	        };
	        reader.readAsDataURL(file);
	    });
	}

	var fileNames = ['1-treat.xls', '2-dipstick.xls', '3-slide.xls', '4-vmw.xls'];

	function uploadFile2() {

	    if (fileArr.length != 4) {
	        app.showMsg('Error', 'Please select at lease 4 files');
	        return;
	    }

	    let msg = '';

	    fileArr.forEach(f => {
	        if (!fileNames.includes(f.name)) msg = 'Invalid file';
	    });

	    if (msg != ''){
	        app.showMsg('Error', 'Invalid file');
	        return;
	    }

	    var submit = {

	        files: [
                { fileName: fileArr[0].name, b64: fileArr[0].b64 },
	            { fileName: fileArr[1].name, b64: fileArr[1].b64 },
                { fileName: fileArr[2].name, b64: fileArr[2].b64 },
                { fileName: fileArr[3].name, b64: fileArr[3].b64 },
	        ]

	    };
	    
	    setTimeout(() => {
	        app.ajax('/His/upload', { submit: JSON.stringify(submit) }).done(function (response) {
	            if (response['status'] == 'successful') {
	                app.showMsg('Upload', 'Upload file successful!');
	            } else if (response['status'] == 'duplicated') {
	                self.showContinue();
	            } else if (response['status'] == 'error') {
	                app.showMsg('Error', response['msg']);
	            }
	        });
	    }, 1500)
	}

	self.uploadFile = function (isOverwrite, fileType) {
		var model = self.file();
		if (model.name().split('.').pop() == 'xlsx') {
			console.log('Wrong file extension!');
		} else {
			var reader = new FileReader();
			reader.onload = function () {
				var data = {
					base64: reader.result.split(',')[1],
					fileName: model.name(),
					ext: '.' + model.name().split('.').pop(),
					isOverwrite: isOverwrite,
                    fileType: fileType
				};
				app.ajax('/His/upload', data).done(function (response) {
				    if (response['status'] == 'successful') {
						app.showMsg('Upload', 'Upload file successful!');
				    } else if (response['status'] == 'duplicated') {
						self.showContinue();
				    } else if (response['status'] == 'error') {
				        app.showMsg('Error', response['msg']);
					}
				});
			};
			reader.readAsDataURL(model.file);
		}
	}

	function getData() {
		var submit = {year: self.year()};
		app.ajax('/His/getData', submit).done(function (rs) {
			mainData = rs;
			self.listModel(mainData);
		});
	}

	self.getDetail = function (model) {
	    self.tab('detail');
	    let submit = { year: model.Year, month: model.Month };
	    app.ajax('/His/getDetail', submit).done(function (rs) {
	        self.detailTreat(rs['treat']);
	        self.detailDipstick(rs['dipstick']);
	        self.detailSlide(rs['slide']);
	        self.detailVMW(rs['vmw']);
	    });
	}

	function getReport() {
	    let submit = { year: self.y(), month: self.m() }
	    app.ajax('/His/getReport', submit).done(function (rs) {
	        reportArr = rs;
	        self.listReport(reportArr);
	    });
	}

	function getDiscrepancy() {
	    let submit = { year: self.y(), month: self.m() }
	    app.ajax('/His/getDiscrepancy', submit).done(function (rs) {
	        discrepancyArr = rs;
	        self.listDiscrepancy(discrepancyArr);
	    });
	}

	self.tab.subscribe(function (model) {
	    if (model == 'Report') {
	        getReport();
	    } else if (model == 'List') {
	        getData();
	    } else if (model == 'Discrepancy') {
	       getDiscrepancy();
	    }
	});

	self.delete = function (model) {
	    app.showDelete(function () {
	        app.ajax('/His/delete', {Year: model.Year, Month: model.Month}).done(function (data) {
	            self.listModel.remove(model);
	        });
		});
	}

	self.pv.subscribe(function (code) {
		self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
		if (self.pv() != undefined)  filterListReport();
		else self.listReport(reportArr);
	});

	self.year.subscribe(function () {
	    getData();
	});

	self.y.subscribe(function () {
	    if (self.tab() == 'Report') getData();
	    else if (self.tab() == 'Discrepancy') getDiscrepancy();
	});

	self.m.subscribe(function () {
	    if (self.tab() == 'Report') getData();
	    else if (self.tab() == 'Discrepancy') getDiscrepancy();
	});
    
	self.month.subscribe(filterListModel);

	self.getODName = function (code) {
		var found = place.od.find(r => r.code == code);
		return found == null ? code : found.nameK;
	};

	self.getPvName = function (code) {
		var found = place.pv.find(r => r.code == code);
		return found == null ? code : found.nameK;
	}

	function filterListReport() {
	    let list = reportArr.filter(r => r.Code_Prov_T == self.pv())
	    self.listReport(list);
	}

	function filterListModel() {
		var list = mainData.filter(r => r.Year == self.year());

		if (self.month() != null) list = list.filter(r => r.Month == self.month());

		self.listModel(list);
	}

	self.back = function () {
		self.view('list');
	};

	self.overWrite = function (model) {
		self.uploadFile();
	};

	self.showContinue = function (description, fileName, index, model, isReimport) {
		$('#modalContinue').find('span').first().text(description);
		$('#modalContinue').find('span').last().text(fileName);
		$('#modalContinue').modal('show');

		$('#modalContinue .btn-primary').off().click(function () {
			self.uploadFile(1);
		});
	};

	self.calculatePer = function (mis, his) {
	    if (his == 0 && mis >0) return 100;
	    if (his > 0 && mis == 0) return 100;
	    if (his == 0 && mis == 0) return 0;
	    diff = (his - mis) * 100 / his;
	    return parseFloat(diff).toFixed(0);
	}
}