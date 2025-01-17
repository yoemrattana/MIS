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
    self.view = ko.observable('list');
    self.item = ko.observable(new setItem(undefined));
    
    self.listModel = ko.observableArray();
    var itemArr = [];

    function setItem(ele) {
        var item = {
            Rec_ID: ko.observable(ele == undefined ? '' : ele.Rec_ID),
            Title: ko.observable(ele == undefined ? '' : ele.Title).extend({ required: true }),
            PublishYear: ko.observable(ele == undefined ? '' : ele.PublishYear).extend({ required: true }),
            Language: ko.observable(ele == undefined ? '' : ele.Language).extend({ required: true }),
            FileName: ko.observable(ele == undefined ? '' : ele.FileName),
            File: ko.observable(ele == undefined ? '' : ele.FileName).extend({ required: true }),
            Thumbnail: ko.observable(ele == undefined ? '' : ele.Thumbnail).extend({ required: true }),
        }

        return item;
    }

    app.ajax('Document/getList').done(function (rs) {
        itemArr = rs;

        itemArr.map(r => {
            r.Link = '/media/Documents/' + r.FileName;
        });
        self.listModel(itemArr);
    })

    self.add = function () {
        self.item(setItem(undefined));
        $('#modalUpload').modal('show');
    }

    self.edit = function (model) {
        self.item(setItem(model));
        $('#modalUpload').modal('show');
    }

    self.selectFile = function () {
        $('#file').val('').click();
    }

    self.fileChanged = function (files) {
        if (files[0].size > 157286400) {
            self.item().File('');
            alert('File too large! File size cannot exceed 150MB.');
            return;
        }

        var reader = new FileReader();

        reader.onload = function () {
            self.item().File(reader.result.split(',')[1]);
        }

        reader.readAsDataURL(files[0]);
    }

    self.selectThumbnail = function () {
        $('#thumbnail').val('').click();
    }

    self.thumbnailChanged = function (files) {
        var reader = new FileReader();

        reader.onload = function () {
            self.item().Thumbnail(reader.result.split(',')[1]);
        }

        reader.readAsDataURL(files[0]);
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            return;
        }
        $('#modalUpload').modal('hide');
        var model = self.item();
        model = app.unko(model);
        
        app.ajax('Document/save', { submit: JSON.stringify(model) }).done(function (rs) {
            $('#modalUpload').modal('hide');
            app.showMsg('Successful', 'Update data successful!');
            if (model.Rec_ID == undefined || model.Rec_ID == '') {
                rs.Link = '/media/Documents/' + rs.FileName;
                self.listModel.push(rs);
            } else {
                let result = self.listModel().find(r => r.Rec_ID == model.Rec_ID);
                self.listModel.remove(result);
                rs.Link = '/media/Documents/' + rs.FileName;
                self.listModel.push(rs);
            }
            filter();
        })
    }

    self.delete = function (model) {
        app.showDelete(function () {
            app.ajax('Document/delete', { rec_id: model.Rec_ID, fileName: model.FileName, thumbnail: model.Thumbnail }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.listModel.remove(model);
                itemArr.remove(model);
            });
        })
    }

    self.dateFormat = function (date) {
        return moment(date, "YYYYMMDD h:mm:ss").fromNow();
    }

}