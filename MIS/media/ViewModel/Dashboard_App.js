if (app.vmSubs == null) app.vmSubs = [];

app.vmSubs.push(function (self) {

    self.showTabAppGallery = function () {
        self.loaded(true);
        $('#modalLoader').modal('hide');
    }
})