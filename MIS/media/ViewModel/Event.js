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

    self.events = ko.observableArray()
    self.participants = ko.observableArray()
    self.event = ko.observable()
    self.participant = ko.observable()
    self.tab = ko.observable('Events')
    self.eventID = ko.observable()
    self.view = ko.observable('list')
    var participantArr = [];

    app.ajax('/Event/getList').done(function (rs) {
        self.events(rs)
    });

    self.getStatus = (state) => {
        if (state == 1) return 'Yes'
        else return 'No'
    }

    self.createEvent = () => {
        self.event(new setEvent())
        self.view('form')
    }

    function setEvent() {
        return {
            Rec_ID: ko.observable(0),
            EventNameKH: ko.observable().extend({ required: true }),
            EventNameEN: ko.observable().extend({ required: true }),
            DateFrom: ko.observable().extend({ required: true }),
            DateTo: ko.observable().extend({ required: true }),
            OrganizationKH: ko.observable().extend({ required: true }),
            OrganizationEN: ko.observable().extend({ required: true }),
            VenueKH: ko.observable().extend({ required: true }),
            VenueEN: ko.observable().extend({ required: true }),
            AgendaKH: ko.observable('').extend({ required: true }),
            AgendaEN: ko.observable('').extend({ required: true }),
            BackdropEN: ko.observable().extend({ required: true }),
            BackdropKH: ko.observable().extend({ required: true }),
            Logo: ko.observable().extend({ required: true }),
            VenueMap: ko.observable().extend({ required: true }),
            UnitNameKH: ko.observable().extend({ required: true }),
            UnitNameEN: ko.observable().extend({ required: true }),
            Phone: ko.observable(),
            Email: ko.observable(),
        }
    }

    self.menuClick = function (root, event) {
        $('.btn-menu').removeClass('btn-info btn-default');
        $('.btn-menu').each(function () {
            this == event.currentTarget ? $(this).addClass('btn-info') : $(this).addClass('btn-default');
        });

        self.view('list');

        let tabName = $(event.currentTarget).text();
        self.tab(tabName);
    };

    self.saveEvent = () => {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = app.unko(self.event())

        app.ajax('Event/saveEvent', { submit: model }).done(function (rs) {
            if (model.Rec_ID == 0) self.events.push(rs)
            self.view('list')
        })
    }

    self.export = () => {
        if (self.eventID() == undefined) {
            app.showMsg('Info', 'Please select event name')
            return
        }
        app.downloadBlob('/Event/exportExcel', { event: self.eventID() }).done(function (blob) {
            saveAs(blob, self.eventName() + '.xlsx'); //from FileSaver.js
        });
    }

    self.createQRCode = (model, withParticipant = false) => {
        $('#qrCodeModal').modal('show')
        $('#qrcode').empty()
        var qrcode = new QRCode("qrcode");

        let link = ''
        if (withParticipant) link = 'https://mis.cnm.gov.kh/Invitation/index/' + model.EventID + '/' + model.Rec_ID
        else link = 'https://mis.cnm.gov.kh/Invitation/index/' + model.Rec_ID

        qrcode.makeCode(link);
    }

    self.viewInvitation = (model) => {
        window.open('/Invitation/index/' + model.EventID + '/' + model.Rec_ID, '_blank').focus();
    }

    self.editEvent = (model) => {
        self.event(app.ko(model));
        self.view('form')
    }

    self.eventName = ko.observable()
    self.eventID.subscribe(function (eventID) {
        let event = self.events().find(r => r.Rec_ID == eventID)
        self.eventName(event.EventNameEN)
    })

    self.deleteEvent = (model) => {
        let submit = {
            Rec_ID: model?.Rec_ID,
            Logo: model?.Logo,
            BackdropKH: model?.BackdropKH,
            BackdropEN: model?.BackdropEN,
            AgendaEN: model?.AgendaEN,
            AgendaKH: model?.AgendaKH,
        }

        app.showDelete(function () {
            app.ajax('Event/deleteEvent', { submit: submit }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.events.remove(model);
            });
        })
    }

    self.selectLogo = function () {
        $('#logo').val('').click();
    };

    self.selectBackdropKH = function () {
        $('#backdropKH').val('').click();
    };

    self.selectBackdropEN = function () {
        $('#backdropEN').val('').click();
    };

    self.selectAgendaEN = function () {
        $('#agendaEN').val('').click();
    };

    self.selectAgendaKH = function () {
        $('#agendaKH').val('').click();
    };

    self.logoChanged = function (files) {
        if (files[0]['type'] != 'image/png') {
            app.showMsg('Invlaid', 'Accept only png file')
            return
        }
        var reader = new FileReader();
        reader.onload = function () {
            var img = new Image();
            img.src = reader.result;
            img.onload = function () {
                var w = img.width > 800 ? 800 : img.width;
                var h = img.height * (w / img.width);

                var canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;

                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, w, h);

                self.event().Logo(canvas.toDataURL('image/png', 0.9));
            };
        };
        reader.readAsDataURL(files[0]);
    };

    self.backdropKHChanged = function (files) {
        var reader = new FileReader();
        reader.onload = function () {
            var img = new Image();
            img.src = reader.result;
            img.onload = function () {
                var w = img.width > 800 ? 800 : img.width;
                var h = img.height * (w / img.width);

                var canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;

                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, w, h);

                self.event().BackdropKH(canvas.toDataURL('image/jpeg', 0.9));
            };
        };
        reader.readAsDataURL(files[0]);
    };

    self.backdropENChanged = function (files) {
        var reader = new FileReader();
        reader.onload = function () {
            var img = new Image();
            img.src = reader.result;
            img.onload = function () {
                var w = img.width > 800 ? 800 : img.width;
                var h = img.height * (w / img.width);

                var canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;

                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, w, h);

                self.event().BackdropEN(canvas.toDataURL('image/jpeg', 0.9));
            };
        };
        reader.readAsDataURL(files[0]);
    };

    self.agendaENChanged = function (files) {
        if (files[0].size > 157286400) {
            self.event().File('');
            alert('File too large! File size cannot exceed 150MB.');
            return;
        }

        var reader = new FileReader();

        reader.onload = function () {
            self.event().AgendaEN(reader.result.split(',')[1]);
        }

        reader.readAsDataURL(files[0]);
    }

    self.agendaKHChanged = function (files) {
        if (files[0].size > 157286400) {
            self.event().File('');
            alert('File too large! File size cannot exceed 150MB.');
            return;
        }

        var reader = new FileReader();

        reader.onload = function () {
            self.event().AgendaKH(reader.result.split(',')[1]);
        }

        reader.readAsDataURL(files[0]);
    }

    /***
     * pariticipants
     * */

    getParticipants();
    function getParticipants() {
        app.ajax('Event/getParticipants').done(function (rs) {
            participantArr = rs
            self.participants(participantArr)
        })
    }

    self.eventID.subscribe(function (id) {
        let p = participantArr.filter(r => r.EventID == id)
        self.participants(p)
    })

    self.saveParticipant = () => {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = app.unko(self.participant())

        app.ajax('Event/saveParticipant', { submit: model }).done(function (rs) {
            if (model.Rec_ID == 0) self.participants.push(rs)
            self.view('list')
        })
    }

    self.createParticipant = () => {
        self.view('form')
        self.participant(new setParticipant())
    }

    function setParticipant() {
        return {
            Rec_ID: ko.observable(0).extend({ required:true }),
            ParticipantName: ko.observable().extend({ required: true }),
            ParticipantPhone: ko.observable().extend({ required: true }),
            ParticipantEmail: ko.observable().extend({ required: true }),
            Organization: ko.observable().extend({ required: true }),
            EventID: ko.observable().extend({ required: true }),
            Comment: ko.observable(),
            WillAttend: ko.observable(),
        }
    }

    self.editParticipant = (model) => {
        self.participant(app.ko(model));
        self.view('form')
    }

    self.deleteParticipant = (model) => {
        let submit = {
            Rec_ID: model?.Rec_ID,
        }

        app.showDelete(function () {
            app.ajax('Event/deleteParticipant', { submit: submit }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.eventParticipants.remove(model);
            });
        })
    }
}