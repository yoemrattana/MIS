function subViewModel(self) {
    self.tableName = 'tblChecklistCmepRH';
    self.getData();

    self.showNew = function () {
        var newMasterModel = {
            Rec_ID: 0,
            Code_Prov_N: null,
            Code_OD_T: null,
            Code_Facility_T: null,
            VisitDate: null,
            RHRepresentative: null,
            VisitorName: null,
        };

        self.showDetail(newMasterModel);
    };


    function newDetailModel() {
        var obj = {};

        var keys = ['P1', 'P2', 'P4', 'P5'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ interviewer: '', position: '' }),
            };
        });

        var keys = ['P1Q1', 'P1Q2', 'P2Q1', 'P2Q2', 'P5Q2', 'P5Q3', 'P5Q3_1'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
            };
        });

        var keys = ['P1Q2_1',];
        keys.forEach(k => {
            obj[k] = {
                Answer: '',
            };
        });

        var keys = ['P2Q1_1', 'P2Q2_1'];
        keys.forEach(k => {
            obj[k] = {
                Answer: {
                    treatment: { male: '', female: '' },
                    microscopy: { male: '', female: '' },
                    other_training: { male: '', female: '' },
                }
            };
        });

        obj['P3'] = {
            Answer: ko.observableArray([newPatient()])
        }

        obj.P4Q1 = {
            Answer: {
                dha: { amc: '', balance: '', mos: '', status: '' },
                asmq50: { amc: '', balance: '', mos: '', status: '' },
                asmq200: { amc: '', balance: '', mos: '', status: '' },
                asmq60: { amc: '', balance: '', mos: '', status: '' },
                asmq80: { amc: '', balance: '', mos: '', status: '' },
                quinine2ml: { amc: '', balance: '', mos: '', status: '' },
                quinine: { amc: '', balance: '', mos: '', status: '' },
                primaquin75: { amc: '', balance: '', mos: '', status: '' },
                primaquin15: { amc: '', balance: '', mos: '', status: '' },
                doxycycline: { amc: '', balance: '', mos: '', status: '' },
                tetracycline: { amc: '', balance: '', mos: '', status: '' }
            }
        }

        var keys = ['P5Q1', 'P5Q1_1'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ total: '' }),
            };
        });

        var keys = ['P5Q1_2',];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ total: '', pf: '', pv: '', mix: '' }),
            };
        });

        obj.P6 = {
            Answer: app.ko({date_from: '', date_to: ''})
        }

        var keys = ['P6Q1', 'P6Q2','P6Q3'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ patient_letter: '', ho2: '', }),
            };
        });

        var keys = ['P7Q1', 'P7Q2', 'P7Q3', 'P7Q4', 'P7Q5'];
        keys.forEach(k => {
            obj[k] = {
                Answer: { problem: '', solution: '', responsible: '', date: '' }
            };
        });

        var keys = ['P7Q6_1', 'P7Q6_2'];
        keys.forEach(k => {
            obj[k] = {
                Answer: ''
            };
        });

        return obj;
    }

    function newPatient() {
        return { sex: '', pregnancy:'', age: '', weight: '', species: '', medicine: '',how_to_use:'', qty: '',daily_dose:'', duration: '', answer: '', };
    }

    self.addPatient = function () {
        self.detailModel().P3.Answer.push(newPatient());

        $('input[numonly]').each(function () {
            app.setNumberOnly(this, $(this).attr('numonly'));
        });
    }

    self.deletePatient = function (model) {
        self.detailModel().P3.Answer.remove(model);
    }

    self.showDetail = function (model) {
        self.lastScrollY = window.scrollY;

        model = app.ko(model);

        model.pvList = self.place.pv;
        model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());
        model.hcList = () => self.place.hc.filter(r => r.odcode == model.Code_OD_T());

        self.masterModel(model);

        var detail = newDetailModel();

        if (model.Rec_ID() == 0) {
            self.detailModel(detail);
            self.view('detail');

            //$('input[numonly]').each(function () {
            //    app.setNumberOnly(this, $(this).attr('numonly'));
            //});
        } else {
            var submit = {
                id: model.Rec_ID(),
                tbl: self.tableName
            };
            app.ajax('/Checklist/getDetail', submit).done(function (rs) {
                rs.forEach(r => {
                    detail[r.Question].Answer = app.ko(JSON.parse(r.Answer));

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
        if (model.Code_Facility_T() == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល មណ្ឌលសុខភាព</kh>');
            return;
        }
        if (model.VisitDate() == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ថ្ងៃចុះអភិបាល</kh>');
            return;
        }

        var master = app.unko(model);
        master.VisitDate = master.VisitDate.format('YYYY-MM-DD');

        delete master.pvList;
        delete master.odList;
        delete master.hcList;
        delete master.Code_Prov_N;
        delete master.Code_OD_T;
        delete master.completeness;

        var detail = self.detailModel();
        var list = [];
        Object.keys(detail).forEach(k => {
            list.push({
                Question: k,
                Answer: JSON.stringify(app.unko(detail[k].Answer)),
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