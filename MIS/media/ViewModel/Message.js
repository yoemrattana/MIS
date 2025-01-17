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
    self.detail = ko.observableArray();
    self.textReply = ko.observable().extend({required: true});
    self.parentID = ko.observable();
    var place = '';

    var messageArr = [];

    app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
        p.pv = p.pv.filter(r => r.target == 1);
        p.od = p.od.filter(r => r.target == 1);
        place = p;
    });

    app.ajax('Message/getList').done(function (rs) {
        messageArr = rs;
        rs.map(r => {
            r.Place = r.Code_Place.length == 10 ? self.getVLName(r.Code_Place) : self.getHCName(r.Code_Place);
            r.InitTime = dateFormat(r.InitTime);
            r.Label = r.Code_Place.length == 10 ? 'VMW' : 'HF';
            r.isCNM = self.isNum(r.Code_Place) ? false : true;
        });
        let list = rs.filter(r => r.Parent_ID == undefined);
        self.listModel(list);
    });

    function dateFormat(date) {
        return moment(date, "YYYYMMDD h:mm:ss").fromNow();
    }

    self.viewDetail = function (model) {
        let rs = messageArr.filter(r => r.Rec_ID == model.Rec_ID || r.Parent_ID == model.Rec_ID);
        self.detail(rs);
        self.parentID(model.Rec_ID);
        self.view('detail');
    }

    self.reply = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            return;
        }

        var model = {
            Text: app.unko(self.textReply()),
            Code_Place: 'CNM',
            Parent_ID: app.unko(self.parentID()),
            IsRead: 0,
            InitTime: moment().format('YYYY-MM-DD, h:mm:ss'),
            Place: 'CNM',
            Rec_ID: null,
            Label: 'CNM',
            isCNM: 1,
        }

        app.ajax('Message/reply', { submit: JSON.stringify(model) }).done(function (rs) {
            messageArr.push(model);
            self.detail.push(model);
        })
    }

    self.getHCName = function (code) {
        var found = place.hc.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVLName = function (code) {
        var found = place.vl.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.isNum = function (n) {
        return !isNaN(n);
    }
}