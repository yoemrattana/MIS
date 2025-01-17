$(document).ready(function () {
	$('#systable').change(function (e) {
		e.preventDefault();
		var self = $(this);
		var code_prov = isnull($('#code_prov').val(), '01');
		var systable = $(this).val();
		if (systable == 'choose') return;
		var url = '/Home/sysmenu/' + code_prov + '/' + systable;

		if (app.vm != null && app.vm.hasChange === true) {
			app.vm.goto = url;
			$('#modalSave').modal('show');
			return;
		}
		app.showLoader();
		location = url;
	});

	$('#sysmenuboard #code_prov').change(function () {
		if ($('#systable').val() == 'choose' || $('#code_prov').attr('data-bind') != null) return;
		var url = '/Home/sysmenu/' + $('#code_prov').val() + '/' + $('#systable').val();
		app.showLoader();
		location = url;
	});
});