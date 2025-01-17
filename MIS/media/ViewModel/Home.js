function viewModel() {
	var self = this;

	self.monthList = [];
	self.yearList = ko.observableArray();
	self.thisMonth = moment().format('MM');
	self.thisYear = moment().year();
	self.password = ko.observable();
	self.exportList = ko.observableArray(JSON.parse($('#exportList').val()));
	self.exportItem = ko.observable();
	self.national = ko.observable(false);
	self.filterMode = ko.observable();

	var yearData = [];
	var previousSelectedStoreName = '';

	for (var i = 1; i <= 12; i++) {
		self.monthList.push(('0' + i).substr(-2));
	}

	for (var i = 2018; i <= moment().year() ; i++) {
		yearData.push(i);
	}

	self.showPassword = function () {
		self.password('');
		$('#modalPassword').modal('show');
	};

	self.changePassword = function () {
		if (self.password() == '') return;
		var submit = { password: self.password() };
		app.ajax('/Home/changePassword', submit);
	};

	self.exportExcel = function (preview) {
		var df = $('#datefrom').val().split(' / ');
		var dt = $('#dateto').val().split(' / ');
		df = df[1] + '-' + df[0];
		dt = dt[1] + '-' + dt[0];

		var submit = {
			storeName: self.exportItem().StoreName,
			prov: sessionStorage.code_prov,
			national: self.national() ? 1 : 0,
			df: df,
			dt: dt,
			fdc: self.filterMode()
		};

		if (preview === true) {
			open('/Home/previewExcel/?' + $.param(submit));
		} else {
			app.downloadBlob('/Home/exportExcel/?' + $.param(submit)).done(function (blob) {
				saveAs(blob, self.exportItem().Text + '.xlsx');
			});
		}
	};

	self.previewExcel = function () {
		self.exportExcel(true);
	};

	self.exportItem.subscribe(function (obj) {
		// if (obj.StoreName.in('SP_Export_DataForWHO', 'SP_Export_DataForWHONonEndemic')) {
		// var year = moment().year();
		// self.yearList([year - 1, year]);
		// } else {
		self.yearList(yearData);
		// }

		$('.choosemonth').each(function () {
			var m = $(this).next().find('select').first().val();
			var y = $(this).next().find('select').last().val();
			$(this).val(m + ' / ' + y);
		});

		if (previousSelectedStoreName == 'SP_Export_HFVMWWeeklyHC') setTimeout(() => self.filterMode(0));
		previousSelectedStoreName = obj.StoreName;
	});
}

$(function () {
	$('.choosemonth').focus(function () {
		$(this).next().show();

		var m = $(this).next().find('select').first().val();
		var y = $(this).next().find('select').last().val();
		$(this).val(m + ' / ' + y);
	});

	$('.choosemonth').next().find('select').change(function () {
		var m = $(this).closest('.dropdown-menu').find('select').first().val();
		var y = $(this).closest('.dropdown-menu').find('select').last().val();
		$(this).closest('.dropdown').find('input').val(m + ' / ' + y);
	});

	$('html').click(function () {
		$('.choosemonth').each(function () {
			var over = $(this).is(":focus") || $(this).next().is(":hover");
			if (!over) $(this).next().hide();
		});
	});

	$('.dropdown input').val(moment().format('MM/YYYY'));

	$('#labMenu .modal-body a').each(function () {
		if (!app.user.permiss['Lab'].contain(this.innerHTML)) $(this).remove();
	});

	//start pop-up menu
	$('.subMenu div').each(function () {
        var p = $(this).parent().attr('permiss');
		var permiss = app.user.permiss[p] || [];
		if (!permiss.contain($(this).text())) $(this).remove();
	});

	$('.subMenu div').click(function () {
		location = $(this).attr('href');
	});

	$('.mainMenu > div').each(function () {
		var sub = $(this).find('.subMenu');
		var btnLeft = $(this).offset().left;
		if (app.isMobile) {
			var x = 20 - btnLeft;
		} else {
			var subLeft = sub.css('left').toFloat();
			var x = btnLeft + subLeft > 0 ? subLeft : 5 - btnLeft;
		}
		$(this).find('.subMenu').css({ left: x });

		var top = this.getBoundingClientRect().bottom - sub.css('bottom').toFloat() - sub.height();
		if (top < 10) sub.css({ bottom: -sub.height() + this.getBoundingClientRect().bottom - 30 });
	});

	if (app.isMobile) {
		$('.mainMenu').click(function () {
			$('.subMenu').hide();
			$(this).find('.subMenu').show();
		});

		$('html').click(function (e) {
			if ($(e.target).closest('.mainMenu').length == 0) $('.subMenu').hide();
		});
	} else {
		$('.mainMenu').mouseover(function () {
			$(this).find('.subMenu').show();
		});

		$('.mainMenu').mouseout(function () {
			$(this).find('.subMenu').hide();
		});
	}
	//end pop-up menu
});