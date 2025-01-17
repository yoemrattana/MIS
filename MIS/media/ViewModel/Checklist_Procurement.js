function subViewModel(self) {
    self.tableName = 'tblChecklistProcurement';
    self.getData();

    self.misData = ko.observable();

    self.showNew = function () {
        var newMasterModel = {
            Rec_ID: 0,
            Code_Prov_N: null,
            Code_OD_T: null,
            VisitDate: null,
            CheckFrom: null,
            CheckTo: null,
            VisitorName: '',
            Quarter: null,
            MissionNo: '',
            Participants: [new participant()],
        };

        self.showDetail(newMasterModel);
    };

    function participant() {
        return {
            name: ko.observable(null),
            position: ko.observable(null)
        }
    }

    self.addParticipant = function () {
        self.masterModel().Participants.push(new participant());
    }

    self.deleteParticipant = function (model) {
        self.masterModel().Participants.remove(model);
    }

    function newDetailModel() {
        return {
            Q1: {
                quarter_plan: '',
                semester_plan: ''
            },
            Q21: {
                plan_reference: '',
                approver: ''
            },
            Q22: {
                phone: '',
                email: '',
                goshop: '',
                atleast3suplier: ''
            },
            Q23: {
                quotation: '',
                approver: ''
            },
            Q24: '',
            Q25: {
                pre_payment: '',
                post_payment: '',
                pre_badget: '',
                invoice: '',
                no_invoice_reason: ''
            },
            Problem: '',
            Solution: '',
            Enquiry: ''
        }
    }

    self.showDetail = function (model) {
        self.lastScrollY = window.scrollY;

        if (model.Rec_ID > 0) {
            if (model.Participants == null) model.Participants = [new participant()]
            else if (!Array.isArray(model.Participants)) model.Participants = JSON.parse(model.Participants);
        }

        model = app.ko(model);

        model.pvList = self.place.pv;
        model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());

        self.masterModel(model);

        model.CheckFrom.subscribe(function (from) {
            $(model.CheckTo.element).data('DateTimePicker').minDate(from);
            if (model.CheckTo() != null && model.CheckTo() < from) model.CheckTo(null);
        });

        var detail = newDetailModel();

        if (model.Rec_ID() == 0) {
            self.detailModel(detail);
            self.view('detail');

            $('input[numonly]').each(function () {
                app.setNumberOnly(this, $(this).attr('numonly'));
            });
        } else {
            var submit = {
                id: model.Rec_ID(),
                tbl: self.tableName
            };
            app.ajax('/Checklist/getDetail', submit).done(function (rs) {
                rs.forEach(r => {
                    detail[r.Question] = JSON.parse(r.Answer);
                });
                self.detailModel(detail);
                self.view('detail');

                $('input[numonly]').each(function () {
                    app.setNumberOnly(this, $(this).attr('numonly'));
                });
            });
        }

        window.scrollTo(0, 0);
    };

    self.save = function () {
        var model = self.masterModel();

        if (model.Code_Prov_N() == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ខេត្ត</kh>');
            return;
        }
        if (model.Code_OD_T() == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ស្រុកប្រតិបត្ត</kh>');
            return;
        }
        if (model.VisitDate() == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ថ្ងៃចុះអភិបាល</kh>');
            return;
        }
        if (model.CheckFrom() == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ត្រួតពិនិត្យពី</kh>');
            return;
        }
        if (model.CheckTo() == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ត្រួតពិនិត្យដល់</kh>');
            return;
        }
        if (model.VisitorName().trim() == '') {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ឈ្មោះអ្នកបំពេញទំរង់</kh>');
            return;
        }
        if (model.MissionNo() == '') {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល លេខបេសកកម្ម</kh>');
            return;
        }
        if (model.Quarter() == '') {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ត្រីមាស</kh>');
            return;
        }

        var master = app.unko(model);
        master.VisitDate = master.VisitDate.format('YYYY-MM-DD');
        master.CheckFrom = master.CheckFrom.format('YYYY-MM');
        master.CheckTo = master.CheckTo.format('YYYY-MM');
        master.VisitorName = master.VisitorName.trim();
        master.MissionNo = master.MissionNo.trim();
        master.Quarter = master.Quarter.trim();
        master.Participants = JSON.stringify(master.Participants);

        delete master.pvList;
        delete master.odList;
        delete master.hcList;
        delete master.Code_Prov_N;
        delete master.completeness;
     
        var detail = self.detailModel();
        var list = [];
        Object.keys(detail).forEach(k => {
            list.push({
                Question: k,
                Answer: JSON.stringify(detail[k]),
            });
        });

        var submit = {
            tbl: self.tableName,
            master: master,
            details: list
        };
        submit = { submit: JSON.stringify(submit) };
        app.ajax('/Checklist/save', submit).done(function (rs) {
            if (master.Rec_ID == 0) {
                self.listModel.push(rs);
            } else {
                var old = self.listModel().find(r => r.Rec_ID == rs.Rec_ID);
                self.listModel.replace(old, rs);
            }

            self.view('list');
        });
    };
}