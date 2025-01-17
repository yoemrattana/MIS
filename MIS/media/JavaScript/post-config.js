app.user = $('#SessionUser').val() == null ? null : JSON.parse($('#SessionUser').val());
app.placeUpdate = JSON.parse($('#PlaceUpdate').val());
app.isMobile = $('#IsMobile').val() == 1;

window.onpopstate = function () {
	history.forward();
};
history.pushState(null, null);

$('.modal:not(.fade)').modal({
	backdrop: 'static',
	keyboard: false,
	show: false
});

app.vm = typeof viewModel === 'function' ? new viewModel() : {};
ko.applyBindings(app.vm);
