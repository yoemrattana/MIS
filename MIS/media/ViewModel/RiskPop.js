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
    self.listModel = ko.observableArray();
    self.view = ko.observable('list');
    self.yearList = [];
    self.year = ko.observable();
    self.Pop = ko.observable(new setPop());
    self.isEdit = false;

    self.pvList = ko.observableArray();
    self.pv = ko.observable();

    for (var i = 2021; i <= moment().year(); i++) {
        self.yearList.push(i);
    }


    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        place = p;
        self.pvList(place.pv);
    });

    app.ajax('/RiskPop/getData').done(function (rs) {
        self.listModel(rs);
    });

    self.addNew = function () {
        self.isEdit = false;
        self.Pop(new setPop());
        $('#modalEdit').modal('show');  
    }

    function setPop() {
        return {
            Year: ko.observable().extend({ required: true }),
            Code_Prov_T: ko.observable().extend({ required: true }),
            High: ko.observable().extend({ required: true }),
            Medium: ko.observable().extend({ required: true }),
            Low: ko.observable().extend({ required: true }),
            No: ko.observable().extend({ required: true }),
        }
    }

    self.getProvName = function (code) {
        var found = place.pv.find(r => r.code == code.trim());
        return found == null ? code : found.nameK;
    };

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = app.unko(self.Pop());
        let exist = self.listModel().filter(r => r.Year == model.Year && r.Code_Prov_T == model.Code_Prov_T)
        if (exist.length > 0 && self.isEdit == false) {
            app.showMsg('ដំណឹង', 'ទិន្នន័យស្ទួនឆ្នាំ');
            return;
        }

        app.ajax('/RiskPop/save', { submit: model }).done(function (rs) {
            if (self.isEdit) {
                let r = self.listModel().find(r => r.Year == model.Year && r.Code_Prov_T == model.Code_Prov_T);
                self.listModel.remove(r);
            }
            
            self.listModel.push(model);
            $('#modalEdit').modal('hide');
        })

    }

    self.delete = (model) => {
        app.showDelete(function () {
            app.ajax('RiskPop/delete', { year: model.Year, Code_Prov_T: model.Code_Prov_T }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.listModel.remove(model);
            });
        })
    }

    self.edit = (model) => {
        self.isEdit = true;
        self.Pop(app.ko(model));
        $('#modalEdit').modal('show');
    }
}