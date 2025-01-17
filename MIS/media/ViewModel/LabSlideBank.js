function subViewModel(self) {
	self.listModel = ko.observableArray();
	self.loaded = ko.observable(false);

	self.viewClick = function () {
		app.ajax('/Lab/getSlide').done(function (rs) {
			self.listModel(rs);
			self.loaded(true);

			$('input[numonly]').each(function () {
				app.setNumberOnly(this, $(this).attr('numonly'));
			});
		});
	};
	self.viewClick();

	self.addNew = function () {
		var model = {
			Rec_ID: null,
			Year: '',
			CaseNo: '',
			CodeNo: '',
			SlideStart: '',
			SlideEnd: '',
			BoxNo: '',
			PCRResult: '',
			Microscopy: '',
			Density: '',
			Validate: '',
			TotalSlide: '',
			UsedSlide: '',
			CurrentSlide: '',
			BoxName: '',
			Location: '',
			Remark: '',
		};
		self.listModel.push(model);

		$('input[numonly]').each(function () {
			app.setNumberOnly(this, $(this).attr('numonly'));
		});
	};

	self.save = function () {
		if (self.listModel().length == 0) return;

		var submit = {
			list: JSON.stringify(self.listModel().map(r => {
				return {
					Rec_ID: r.Rec_ID,
					Year: r.Year,
					CaseNo: isempty(r.CaseNo, null),
					CodeNo: r.CodeNo,
					SlideStart: r.SlideStart,
					SlideEnd: r.SlideEnd,
					BoxNo: isempty(r.BoxNo, null),
					PCRResult: r.PCRResult,
					Microscopy: r.Microscopy,
					Density: isempty(r.Density, null),
					Validate: isempty(r.Validate, null),
					TotalSlide: isempty(r.TotalSlide, null),
					UsedSlide: isempty(r.UsedSlide, null),
					CurrentSlide: isempty(r.CurrentSlide, null),
					BoxName: r.BoxName,
					Location: r.Location,
					Remark: r.Remark,
					ModiUser: app.user.username,
					ModiTime: moment().sqlformat('datetime')
				};
			}))
		};

		app.ajax('/Lab/saveSlide', submit).done(self.viewClick);
	};

	self.showDelete = function (model) {
		app.showDelete(function () {
			if (model.Rec_ID == null) {
				self.listModel.remove(model);
				return;
			}

			var submit = {
				table: 'tblLabSlideBank',
				where: { Rec_ID: model.Rec_ID }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				self.listModel.remove(model);
			});
		});
	};

	self.exportExcel = function () {
		var data = self.listModel().map(app.unko).map(r => {
			return {
				'Case No': r.CaseNo,
				'Year': r.Year,
				'CodeNo': r.CodeNo,
				'Slide Start': r.SlideStart,
				'Slide End': r.SlideEnd,
				'Box No': r.BoxNo,
				'PCR Result': self.getSpecies(r.PCRResult),
				'Microscopy': self.getSpecies(r.Microscopy),
				'Density': r.Density,
				'Validate': r.Validate,
				'Total Slide': r.TotalSlide,
				'Used Slide': r.UsedSlide,
				'Current Slide': r.CurrentSlide,
				'Box Name': r.BoxName,
				'Location': r.Location,
				'Remark': r.Remark
			};
		});
		self.writeExcel(data, 'Slide Bank');
	};
}