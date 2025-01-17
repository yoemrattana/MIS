function subViewModel(self) {
    self.tableName = 'tblChecklistCmepOD';
    self.getData();

    self.showNew = function () {
        var newMasterModel = {
            Rec_ID: 0,
            Code_Prov_N: null,
            Code_OD_T: null,
            VisitDate: null,
            ODRepresentative: null,
            MnERepresentative: null,
        };

        self.showDetail(newMasterModel);
    };

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

        model.Code_OD_T.subscribe(getMISData);
        model.CheckFrom.subscribe(getMISData);
        model.CheckTo.subscribe(getMISData);

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
                    detail[r.Question].Answer = app.ko(JSON.parse(r.Answer));

                });
                self.detailModel(detail);
                self.view('detail');

                $('input[numonly]').each(function () {
                    app.setNumberOnly(this, $(this).attr('numonly'));
                });

                getMISData();
            });
        }

        window.scrollTo(0, 0);
    };


    function newDetailModel() {
        var obj = {};

        var keys = ['P1', 'P2', 'P3', 'P4'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ interviewer: '', position: '' }),
            };
        });

        var keys = ['P1Q1', 'P1Q2', 'P1Q3', 'P1Q4'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
            };
        });

        obj.P1Q1_1 = {
            Answer: app.ko({ tick: [] }),
        };

        var keys = ['P1Q2_1'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ pop: '', mobile_pop: '' }),
            };
        });

        var keys = ['P1Q2_2','P1Q2_3'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
            };
        });

        var keys = ['P1Q3_1'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ legal: '', ppm: '', new: '', ilegal: '' }),
            };
        });

        obj.P1Q3_2 = {Answer:''};

        var keys = ['P1Q4_1'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ hc: '', ppm: '', vmw: '' }),
            };
        });

        var keys = ['P2Q1', 'P2Q2'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
            };
        });

        obj.P2Q1_1 = {
            Answer: {
                treatment: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' },
                microscopy: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' },
                rdt: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' },
                education: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' },
                training: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' }
            }
        }

        obj.P2Q2_1 = {
            Answer: {
                treatment: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' },
                microscopy: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' },
                rdt: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' },
                education: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' },
                training: { od_male: '', od_female: '', hc_male: '', hc_female: '', vmw_male: '', vmw_female: '' }
            }
        }

        obj.P3Q1 = {
            Answer: {
                rdt: { amc: '', balance: '', mos: '', status: '' },
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

        var keys = ['P4Q1', 'P4Q2', 'P4Q2_2'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
            };
        });

        obj.P4Q2_1 = {Answer: ''};

        obj.P4Q3 = {
            Answer: app.ko({ tick: [], other: '' }),
        };

        obj.P4Q3_1 = {
            Answer: app.ko({ date_from: '', date_to: '' }),
        };

        obj.rdt = {
            Answer: {hc1: '',his: ''}
        }

        var keys = ['positive', 'pf', 'pv', 'mix','pk','pm','po', 'simple', 'severe', 'morality'];
        keys.forEach(k => {
            obj[k] = {
                Answer: { hc1: '', his: '', vmw: '', vmw_mis: '', ppm: '', ppm_mis: '' }
            };
        });


        var keys = ['P5Q1', 'P5Q2', 'P5Q3', 'P5Q4', 'P5Q5'];
        keys.forEach(k => {
            obj[k] = {
                Answer: { problem: '', solution:'', responsible: '', date:'' }
            };
        });

        var keys = ['P5Q6_1', 'P5Q6_2'];
        keys.forEach(k => {
            obj[k] = {
                Answer: ''
            };
        });

        return obj;
    }

    self.showDetail = function (model) {
        self.lastScrollY = window.scrollY;

        model = app.ko(model);

        model.pvList = self.place.pv;
        model.odList = () => self.place.od.filter(r => r.pvcode == model.Code_Prov_N());

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
        if (model.VisitDate() == null) {
            window.scrollTo(0, 0);
            app.showMsg('Missing Data', '<kh>សូមបញ្ចូល ថ្ងៃចុះអភិបាល</kh>');
            return;
        }

        var master = app.unko(model);
        master.VisitDate = master.VisitDate.format('YYYY-MM-DD');

        delete master.pvList;
        delete master.odList;
        delete master.Code_Prov_N;
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