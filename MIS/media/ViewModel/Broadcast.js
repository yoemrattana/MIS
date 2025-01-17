function viewModel() {
    var self = this;

    self.listModel = ko.observableArray();
    self.message = ko.observable();
    self.tab = ko.observable('Log');

    getData();

    function getData() {
        app.ajax('/Broadcast/getData').done(function (rs) {
            mainData = rs;
            self.listModel(mainData);
        });
    }

    self.send = function () {
        let submit = app.unko(self.message());

        let msg = validate(submit);
        if (msg != '') {
            app.showMsg('Invalid', msg);
        } else {
            app.ajax('/Broadcast/send', submit).done(function (rs) {
                app.showMsg('Successful', 'Message has been sent successful');
                self.tab('Log');
                getData();
            })
        }
    }

    function validate(submit) {
        let msg = '';
        if (submit.title == '') msg = 'Please fill in title';
        if (submit.recipient == '') msg = 'Please select recipient';
        if (submit.body == '') msg = 'Please fill in message text';
        return msg;
    }

    function createMsg() {
        return {
            recipient: '',
            logedin: true,
            title: '',
            body: ''
        };
    }

    self.dateFormat = function (date) {
        return moment(date, "YYYYMMDD h:mm:ss").fromNow();
    }

    self.menuClick = function (root, event) {
        $('.btn-menu').removeClass('active btn-default');
        $('.btn-menu').each(function () {
            this == event.currentTarget ? $(this).addClass('active') : $(this).addClass('btn-default');
        });

        let tabName = $(event.currentTarget).text();
        self.tab(tabName);

        if (tabName == 'Log') getData();
        if (tabName == 'Message') self.message(app.ko(createMsg()));
    };

}