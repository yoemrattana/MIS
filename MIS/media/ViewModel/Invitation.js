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
    self.queryString = window.location.pathname
    self.language = ko.observable('kh');
    self.errors = ko.validation.group(this, { deep: true, observable: false });
    self.ui = ko.observable()
    self.confirmation = ko.observable()
    self.participant = JSON.parse(participant == null ? {} : participant)

    self.createConfirmTextKH = () => {
        let participantCookie = getCookie("participant");
        if (participantCookie) {	
            self.participant = JSON.parse(participantCookie);
        }

        if (self.participant != null && self.participant?.WillAttend == 1) {
            return self.participant?.ParticipantName +  ' នឹងអញ្ចើញចូលរួម' 
        } else if (self.participant != null && self.participant?.WillAttend == 0) {
            return self.participant?.ParticipantName +  ' មិនបានអញ្ចើញចូលរួម' 
        }
        
        return ''
    }

    self.createConfirmTextEN = () => {
        let participantCookie = getCookie("participant");
        if (participantCookie) {
            self.participant = JSON.parse(participantCookie);
        }

        if (self.participant != null && self.participant?.WillAttend == 1) {
            return self.participant.ParticipantName + ' will attend'
        } else if (self.participant != null && self.participant?.WillAttend == 0) {
            return self.participant.ParticipantName + ' cannot attend'
        }
        return ''
    }

    getUI(eventId)

    checkCookie();
    function getUI(eventId) {
        app.ajax('/Invitation/getData/', { Rec_ID: eventId }).done(function (rs) {
            self.ui(rs)

            var qrcode = new QRCode("qrcode");

            if (rs) qrcode.makeCode(rs.VenueMap);
        })
    }

    self.confirm = () => {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            return;
        }
        
        let model = app.unko(self.confirmation())

        app.ajax('/Invitation/confirm/', { submit: model }).done(function (rs) {
            setCookie('participant', JSON.stringify(rs), 365)
        });

        Swal.fire({
            title: self.language() == 'en' ? "Confirm successful" : "បានជោគជ័យ",
            text: self.language() == 'en' ? "Thank you for your confirmation" : "សូមអរគុណ",
            icon: "success",
            willClose: () => {
                location.reload();
            }
        });
    }

    function createConfirmation(willAttend) {
        let p = self.participant
        return {
            Rec_ID: ko.observable(p?.Rec_ID || 0),
            ParticipantName: ko.observable(p?.ParticipantName).extend({ required: true }),
            EventId: eventId,
            Comment: ko.observable(),
            ParticipantPhone: ko.observable(p?.ParticipantPhone),
            ParticipantEmail: ko.observable(p?.ParticipantEmail),
            Organization: ko.observable(p?.Organization).extend({ required: true }),
            WillAttend: ko.observable(willAttend)
        }
    }

    self.attendModal = (willAttend) => {
        $("#sticky").modal({
            escapeClose: false,
            clickClose: false,
            showClose: false
        });
        self.confirmation(new createConfirmation(willAttend)) 
    }

    self.videoModal = () => {
        $("#modalVideo").modal({
            escapeClose: false,
            clickClose: false,
            showClose: false
        });
    }

    self.dateFormat = function (date) {
        return moment(date).format('DD-MM-YYYY');
    }

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function checkCookie() {
        let participant = JSON.parse(getCookie("participant") || '{}') ;

        if (participant) {
            //window.open('/Invitation/index/' + participant.EventID + '/' + participant.Rec_ID, '_blank').focus();

            //document.cookie = "participant=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

            //alert("Welcome again " + participant);
        } 
    }
}