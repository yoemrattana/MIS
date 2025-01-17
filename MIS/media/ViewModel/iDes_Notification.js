function iDesNotification(root) {
	var self = this;

    self.listModel = ko.observableArray();

    self.getData = function () {
    	if (self.listModel().length > 0) return;

    	app.ajax('/iDes/getNotification').done(function (rs) {
    		self.listModel(rs);
    	});
    };
}