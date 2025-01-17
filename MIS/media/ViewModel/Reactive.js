function viewModel() {
	var self = this;

	self.detailModel = ko.observable();
	self.list = ko.observableArray();

	var caseid = location.pathname.split('/').last();

	app.ajax('/Reactive/getData/' + caseid).done(function (rs) {
		var detail = rs.data;
		detail.forEach(r => {
			r.Date_Of_Nof = r.Date_Of_Nof == null ? '' : moment(r.Date_Of_Nof).format('DD/MM/YY');
			r.Date_Of_Birth = r.Date_Of_Birth == null ? '' : moment(r.Date_Of_Birth).format('DD/MM/YY');
			r.Date_Of_Invest = r.Date_Of_Invest == null ? '' : moment(r.Date_Of_Invest).format('DD/MM/YY');

			var name = r.Name_K.split(' ');
			r.First_Name = name[0];
			r.Last_Name = name[1];

			r.positive = (r.Fever == 'P' ? 1 : 0) + (r.Forest == 'P' ? 1 : 0) + (r.Travel == 'P' ? 1 : 0)
				+ (r.History == 'P' ? 1 : 0) + (r.Relative == 'P' ? 1 : 0);

			r.negative = (r.Fever == 'N' ? 1 : 0) + (r.Forest == 'N' ? 1 : 0) + (r.Travel == 'N' ? 1 : 0)
				+ (r.History == 'N' ? 1 : 0) + (r.Relative == 'N' ? 1 : 0);
		});

		rs.model.First_Name = '';
		rs.model.Last_Name = '';
		rs.model.Name_Vill_E = '';
		rs.model.Name_OD_E = '';
		rs.model.Name_Prov_E = '';

		self.detailModel(detail.length == 0 ? rs.model : detail[0]);
		self.list(detail);
	});

	self.deleteReport = function () {
		app.showDelete(function () {
			var submit = {
				table: 'tblReactiveCases',
				where: { Passive_Case_Id: caseid }
			};
			submit = { submit: JSON.stringify(submit) };

			app.ajax('/Direct/delete', submit).done(function () {
				window.close();
			});
		});
	};
}