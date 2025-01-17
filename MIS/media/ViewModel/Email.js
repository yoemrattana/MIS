function viewModel() {
    var self = this;

    ko.validation.init({
        registerExtenders: true,
        messagesOnModified: true,
        insertMessages: false,
        parseInputAttributes: true,
        messageTemplate: null,
        errorElementClass: 'input-error',
        errorClass: 'message-error',
        decorateElementOnModified: true,
        decorateInputElement: true
    }, true);

    self.errors = ko.validation.group(this, { deep: true, observable: false });

    self.config = ko.observable( new setConfig(undefined));

    function setConfig(element) {
        return {
            smtp_user: ko.observable(element == undefined ? '' : element.smtp_user).extend({ required: true, email: true }),
            smtp_pass: ko.observable(element == undefined ? '' : element.smtp_pass).extend({ required: true }),
            to: ko.observable(element == undefined ? '' : element.to).extend({ required: true, email: true }),
            cc: ko.observable(element == undefined ? '' : element.cc).extend({ required: true, email: true }),
        }
    }

    getData();

    function getData() {
        app.ajax('/Email/getData').done(function (rs) {
            let item = setConfig(rs);
            self.config(item);
        })
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        var model = self.config();
        model = app.unko(model);

        var submit = { submit: JSON.stringify(model) };
        app.ajax('/Email/save', submit).done(function (rs) {
            app.showMsg('Successful', 'Update data successful!');
        });
    };


    self.back = function () {
        if (dataChanged) {
            $('#modalSave').modal('show');
            $('#modalSave .btn-primary').off().click(self.save);
            $('#modalSave .btn-danger').off().click(() => self.view('list'));
        } else {
            self.view('list');
        }
    };

}