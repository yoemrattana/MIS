function viewModel() {
    var self = this;
    self.pvList = ko.observableArray();
    self.listModel = ko.observableArray();
    self.listDuplicatedPatientCode = ko.observableArray();
    self.view = ko.observable('list');

    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.filter = ko.observable();
    self.yearList = [];
    self.monthList = [];
    self.year = ko.observable();
    self.month = ko.observable();
    self.menu = ko.observable();

    for (var i = 2021; i <= moment().year(); i++) {
        self.yearList.push(i);
    }

    for (var i = 1; i <= 12; i++) {
        self.monthList.push(('0' + i).substr(-2));
    }

    var place = null;

    app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
        place = p;
        place.od = place.od.filter(r => r.target == 1);
        self.pvList(place.pv.filter(r => r.target == 1));
    });

    function getPatients() {
        app.ajax('/Patient/getData').done(function (rs) {
            let data = rs.map(r => {
                //r.PatientCode = ko.observable(r.PatientCode)
                r.NameK = ko.observable(r.NameK)
                r.Status = ko.observable(r.Status)
                r.n = rs.filter(x => x.PatientCode == r.PatientCode).length
                return r
            })
            self.listModel(data);
        });
    }

    function getDuplicatedPatientCode() {
        app.ajax('/Patient/getDuplicatedPatientCode').done(function (rs) {
            let data = rs.map(r => {
                r.PatientCode = ko.observable(r.PatientCode)
                r.NameK = ko.observable(r.NameK)
                return r
            })

            self.listDuplicatedPatientCode(data);
        });
    }

    self.countSick = (patientCode) => {
        return countBy(self.getListModel(), 'PatientCode');
    }

    const countBy = (arr, prop) => arr.reduce((prev, curr) => (prev[curr[prop]] = ++prev[curr[prop]] || 1, prev), {});


    self.getListModel = ko.pureComputed(function () {
        var list = self.listModel();

        if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());
        if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
        if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());
        if (self.month() != null) list = list.filter(r => r.Month == self.month());
        if (self.year() != null) list = list.filter(r => r.Year == self.year());

        return list;
    });

    self.listSearch = ko.observableArray();
    self.viewCase = function (model) {
        let list = self.listModel().map(function(v,k) {
            v.id = k
            v.PatientCode = v.PatientCode
            v.Name = v.NameK()
            return v;
        })

        let miniSearch = new MiniSearch({
            fields: ['Name', 'Age', 'Sex', 'PatientCode', 'PatientPhone' ,'Code_Prov_T', 'Code_OD_T', 'Code_Facility_T', 'Code_Vill_t'], // fields to index for full-text search
            storeFields: ['NameK', 'Sex', 'Age', 'PatientCode', 'PatientPhone', 'Code_Prov_T', 'Code_OD_T', 'Code_Facility_T', 'Code_Vill_t','DateCase', 'Rec_ID', 'CaseType', 'Status', 'tbl'] // fields to return with search results
        })

        // Index all documents
        miniSearch.addAll(list)

        let stringToSearch = model.NameK() + ' '+ model.Sex;
        // Search with default options
        let results = miniSearch.search(stringToSearch)

        let rs = [];

        if (results.filter(r => r.score > 20).length == 0) rs = results.filter(r => r.score > 17)
        else rs = results.filter(r => r.score > 20)

        rs = rs.map(r => {
            ko.track(r);
            return r;
        })

        self.listSearch(rs)

        setTimeout(() => {
            $('#modalPatient').modal('show')
        },300)
    }

    self.listSelectedDuplicatedPatient = ko.observable();

    self.viewDuplicatedPatientCode = (model) => {
        self.listSelectedDuplicatedPatient(model)
        setTimeout(() => {
            $('#modalDuplicatedPatient').modal('show')
        }, 300)
    }

    self.closeModal = () => {
        var isChange = false;
        self.listSearch().forEach(x => {
            if (ko.isDirty(x)) isChange = true;
        });

        if (isChange) {
            Swal.fire({
                title: "Do you want to save the changes?",
                showCancelButton: true,
                confirmButtonText: "Don't save",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#modalPatient').modal('hide');
                }
            });
        } else {
            $('#modalPatient').modal('hide');
        }

    }

    self.updateCode = (model) => {
        ko.acceptChanges(model)
        app.ajax('/Patient/updateCode', { submit: app.unko(model) }).done(function (rs) {
            if (rs == 1) {
                alert('Update successful');
            }
        })
    }

    self.odList = function () {
        return self.pv() == null ? [] : place.od.filter(r => r.pvcode == self.pv());
    };

    self.hcList = function () {
        return self.od() == null ? [] : place.hc.filter(r => r.odcode == self.od());
    };

    self.getProvName = function (code) {
        var found = place.pv.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getODName = function (code) {
        var found = place.od.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getHCName = function (code) {
        var found = place.hc.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVLName = function (code) {
        var found = place.vl.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVill = function (code) {
        if (code == null || code === '') return '';
        if (code == '999') return 'Unknown';
        var found = code.length == 10 ? place.vl.find(r => r.code == code)
            : code.length == 6 ? place.hc.find(r => r.code == code)
                : code.length == 4 ? place.ds.find(r => r.code == code)
                    : code.length == 2 ? place.pv.find(r => r.code == code)
                        : null;

        return found == null ? code : found.nameK;
    };

    self.getSpecie = function (specie) {
        return specie == 'F' ? 'Pf'
            : specie == 'V' ? 'Pv'
                : specie == 'M' ? 'Mix'
                    : specie == 'A' ? 'Pm'
                        : specie == 'O' ? 'Po'
                            : 'Pk';
    }

    self.menuClick = function (vm, event) {
        self.menu(event.currentTarget.innerHTML);

        if (self.menu() == 'List') {
            getPatients()
        } else getDuplicatedPatientCode()
    };

    self.menuCss = function (element) {
        return element.innerHTML == self.menu() ? 'btn-info' : 'btn-default';
    };
}

$("#modalPatient").draggable({
    handle: ".modal-header"
});
$("#modalDuplicatedPatient").draggable({
    handle: ".modal-header"
});
