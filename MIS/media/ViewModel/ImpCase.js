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
    self.masterModel = ko.observable();
    self.detailModel = ko.observable();
    self.view = ko.observable('list');
    self.menu = ko.observable(new URLSearchParams(location.search).get('tab') || '');
    self.submenu = ko.observable();
    self.mapData = ko.observableArray();
    self.pvList = ko.observableArray();
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.vl = ko.observable();

    var lastScrollY = 0;

    self.errors = ko.validation.group(this, { deep: true, observable: false });

    app.readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
        eval(script);
    });

    app.ajax('ImpCase/getData').done(function (rs) {
        let data = rs.patient.map(r => app.ko(r))
        self.listModel(data)
        self.mapData(rs.patient);
    })

    var mapImp = null;
    function drawMap() {
        var model = self.mapData();

        mapImp = app.createGoogleMap('mapImp', {
            zoom: 8.0
        });

        model.forEach(r => {
            var marker = new google.maps.Marker({
                position: { lat: parseFloat(r.Lat), lng: parseFloat(r.Long) },
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    fillOpacity: 1,
                    fillColor: 'red',
                    strokeColor: '#555',
                    strokeWeight: 1,
                    scale: 5
                },

                zIndex: 900
            });

            marker.setMap(mapImp);

            var txt = '';
            txt += '<br><b>Patient:</b> ' + r.NameK;
            txt += '<br><b>Address:</b> ' + r.Address;
            txt += '<br><b>From Country:</b> ' + r.FromCountry;

            var infowindow = new google.maps.InfoWindow({ content: txt });
            marker.addListener('mouseover', () => infowindow.open(mapImp, marker));
            marker.addListener('mouseout', () => infowindow.close());
        });
    }
    
    if (self.menu() == 'Map') {
        setTimeout(() => { drawMap()}, 300);
    }

    function setCase() {
        let item = {
            Rec_ID: ko.observable(0),
            NameK: ko.observable().extend({ required: true }),
            Sex: ko.observable().extend({ required: true }),
            Age: ko.observable(),
            DB: ko.observable().extend({ required: true }),
            DateCollect: ko.observable().extend({ required: true }),
            RDT: ko.observable(),
            Microscope: ko.observable(),
            PCR: ko.observable(),
            Address: ko.observable().extend({ required: true }),
            Code_Vill_T: ko.observable(),
            Lat: ko.observable(),
            Long: ko.observable(),
            Phone: ko.observable().extend({ required: true }),
            FromCountry: ko.observable().extend({ required: true }),
            Note: ko.observable(),
        }
        return item;
    }

    self.edit = function (model) {
        self.detailModel(model);
        self.view('detail');
    };

    self.add = function () {
        self.detailModel(new setCase());
        self.view('detail');
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            return;
        }

        let detail = app.unko(self.detailModel);
        app.ajax('/ImpCase/save', { submit: detail }).done(function (rs) {
            if (detail.Rec_ID == 0) {
                detail.Rec_ID = rs;
                self.listModel.push(app.ko(detail));
            }
            self.back();
        });
    };

    self.showDelete = function (model) {
        app.showDelete(function () {
            var submit = {
                table: 'tblImpCases',
                where: { Rec_ID: model.Rec_ID() }
            };
            submit = { submit: JSON.stringify(submit) };

            app.ajax('/Direct/delete', submit).done(function () {
                self.listModel.remove(model);
            });
        });
    };

    self.back = function () {
        self.view('list');
        window.scrollTo(0, lastScrollY);
    };

    self.ifcan = function (permission) {
        return app.user.permiss['Imported Cases'].contain(permission);
    };

    $('#menu button').each(function () {
        $(this).click(() => location = '/ImpCase?tab=' + this.name);
        if (this.name == self.menu()) $(this).removeClass('btn-default').addClass('btn-info');
        if (!self.ifcan(this.innerHTML)) $(this).hide();
    });

    self.getSpecie = (specie) => {
        return specie == 'F' ? 'Pf'
            : specie == 'V' ? 'Pv'
                : specie == 'M' ? 'Mix'
                    : specie == 'A' ? 'Pm'
                        : specie == 'O' ? 'Po'
                            : specie == 'K' ? 'Pk'
                                : 'Negative';
    }

    self.getSex = (sex) => {
        return sex == 'M' ? 'Male' : 'Female';
    }

}