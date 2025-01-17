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

    self.listModel = ko.observableArray();
    self.model = ko.observable(new setBlog());
    self.view = ko.observable('list');

    function setBlog(ele = undefined) {
        if (ele != undefined) ele = app.ko(ele);

        var blog = {
            Rec_ID: ko.observable(ele == undefined ? '' : ele.Rec_ID()),
            Title: ko.observable(ele == undefined ? '' : ele.Title()).extend({ Required: true }),
            Description: ko.observable(ele == undefined ? '' : ele.Description()).extend({ Required: true }),
            Thumbnail: ko.observable(ele == undefined ? '' : ele.Thumbnail()).extend({ Required: true }),
        };

        return blog;
    }

    getData();

    self.edit = function (model) {
        self.model(new setBlog(model));
        self.view('addEdit');
    }

    self.add = function () {
        self.model(new setBlog());
        self.view('addEdit');
    }

    self.errors = ko.validation.group(this, { deep: true, observable: false });

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            return;
        }

        let model = self.model();
        
        let submit = app.unko(model)
        app.ajax('Blog/save', { submit: JSON.stringify(submit) }).done(function (rs) {
            if (model.Rec_ID() == '') {
                self.listModel.push(rs);
            } else {
                let result = self.listModel().find(r => r.Rec_ID() == model.Rec_ID());
                self.listModel.remove(result);
                self.listModel.push(rs);
            }
            self.view('list');
            app.showMsg('Successful', 'Update/Insert data successful!');
        })
    }

    self.selectThumbnail = function () {
        $('#thumbnail').val('').click();
    }

    self.thumbnailChanged = function (files) {
        var reader = new FileReader();

        reader.onload = function () {
            self.model().Thumbnail(reader.result.split(',')[1]);
        }

        reader.readAsDataURL(files[0]);
    }

    self.delete = function (model) {
        app.showDelete(function () {
            app.ajax('Blog/delete', { rec_id: model.Rec_ID, thumbnail: model.Thumbnail }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.listModel.remove(model);
            });
        })
    }

    function getData() {
        app.ajax('/Blog/getData').done(function (rs) {
            let results = rs.map(r => app.ko(r));
            self.listModel(results);
        });
    }

    self.formatDate = function (date) {
        return moment(date).format("DD-MM-YYYY HH:mm:ss");
    }

}