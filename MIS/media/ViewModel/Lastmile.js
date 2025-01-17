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

    self.reportList = ko.observableArray();
    self.houseList = ko.observableArray();
    self.detailModel = ko.observable();
    self.houseHolder = ko.observable();
    self.memberList = ko.observableArray();
    self.TDAList = ko.observableArray();
    self.IPTfList = ko.observableArray();
    self.IPTDates = ko.observableArray();
    self.villTDAList = ko.observableArray();
    self.villIPTList = ko.observableArray();
    self.view = ko.observable('list');

    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.yearList = [];
    self.monthList = [];
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.year = ko.observable();
    self.month = ko.observable();
    self.village = ko.observable();
    self.TDADate = ko.observable();
    self.IPTDate = ko.observable();
    self.TDAnet = ko.observable();
    self.TDAsummary = ko.observable();
    self.TDAsummary2 = ko.observable();
    self.TDAtype = ko.observable();
    self.houseID = ko.observable();
    self.IPTsummary = ko.observable();
    self.IPTsummary2 = ko.observable();
    self.villageInfo = ko.observable();
    self.IPTmaster = ko.observable();
    self.AFSmaster = ko.observable();
    self.AFSDates = ko.observable();
    self.AFSDate = ko.observable();
    self.AFSList = ko.observable();
    self.noLatLong = ko.observable(false);

    var prov = sessionStorage.code_prov;
    var place = null;
    var hcs = [];
    var summaryArr = [];
    var HouseArr = [];

    self.getReport = function () {
        var submit = { hc: self.hc() };
        app.ajax('Lastmile/getReport', submit).done(function (rs) {
            self.reportList(rs.vmws);
        });
    }

    self.loadTDASummary = function (callback, page) {
        let vl = page.ctx.vl();
        self.village(vl);
        self.getTDASummary(callback);
    }

    self.getTDASummary = function (callback = null) {
        app.ajax('Lastmile/getTDASummary', { vl: self.village(), year: self.year(), month: self.month() }).done(function (rs) {
            summaryArr = rs;
            self.TDAsummary2(summaryArr)
            var obj = {
                TDAsummary2: self.TDAsummary2
            }
            if (typeof callback === 'function') callback(obj);
        });
    }

    self.loadIPTSummary = function (callback, page) {
        let vl = page.ctx.vl();
        self.village(vl);
        self.getIPTSummary(callback);
    }

    self.getIPTSummary = function (callback = null) {
        app.ajax('Lastmile/getIPTSummary', { vl: self.village(), year: self.year(), month: self.month() }).done(function (rs) {
            self.IPTsummary2(rs)
            var obj = {
                IPTsummary2: self.IPTsummary2
            }
            if (typeof callback === 'function') callback(obj);
        });
    }

    self.loadHouses = function (callback, page) {
        let vl = page.ctx.vl();
        self.village(vl);
        app.ajax('Lastmile/getHouses', { vl: vl }).done(function(rs) {
            HouseArr = rs;
            self.houseList(HouseArr);
            var obj = {
                houseList: self.houseList
            }
            callback(obj);
        });
    }

    self.loadHouse = function (callback, page) {
        let house_id = page.ctx.h();
        let vl = page.ctx.vl();
        self.village(vl);
        if (house_id == 0) {
            self.houseHolder(setHouse());
            self.memberList([setMember()]);
            callback(self.houseHolder());
        } else {
            app.ajax('Lastmile/getHouse', { house_id: house_id }).done(function (rs) {
                var members = [];
                rs.members.forEach(r=> {
                    r.Rec_ID = ko.observable(r.Rec_ID);
                    r.Name = ko.observable(r.Name);
                    r.Age = ko.observable(r.Age);
                    r.Sex = ko.observable(r.Sex);
                    r.ForestEntry = ko.observable(r.ForestEntry.trim() == 'Yes' ? 1 : 0);
                    r.TDA = ko.pureComputed(function () {
                        return r.Age() != undefined && r.Age() >= 15 && r.Age() <= 49 && r.Sex() == 'M' ? 1 : 0;
                    }),
                    r.IPT = ko.pureComputed(function () {
                        return r.Age() >= 15 && r.Age() <= 49 && r.Sex() == 'M' && r.ForestEntry() == 1 ? 1 : 0;
                    }),
                    members.push(r);
                });

                members.push(setMember());

                self.memberList(members);
                //HOUSE
                var h = app.ko(rs.house);
                h.TotalMember = ko.pureComputed(function () {
                    return parseInt(self.memberList().length - 1);
                });
                h.LLINLack = ko.pureComputed(function () {
                    let totalMember = parseInt(self.memberList().length - 1);
                    //return Math.round(house.LLIN() * 1.8) - totalMember;
                    return Math.round(totalMember / 1.8) - h.LLIN();
                });
                h.LLIHNLack = ko.pureComputed(function () {
                    let totalForestEntry = self.memberList().filter(r => r.ForestEntry() == 1 && r.Age() != undefined).length;
                    return parseInt(totalForestEntry) - parseInt(h.LLIHN());
                });
                h.TotalForestEntry = ko.pureComputed(function () {
                    let p = self.memberList().filter(r => r.ForestEntry() == 1);
                    return p.length;
                });

                self.houseHolder(h);

                callback(self.houseHolder);
            });
        }

    }

    self.addMember = function (model) {
        model.Rec_ID(0);
        var newModel = setMember();
        self.memberList.push(newModel);
    }

    var deleteList = [];
    self.deleteMember = function (model) {
        if (model.Rec_ID() > 0) {
            deleteList.push(model);
        }
        self.memberList.remove(model);
    }

    self.createHouse = function () {
        self.houseHolder(setHouse());
        self.memberList([setMember()]);
    }

    self.deleteHouse = function (model) {
        app.showDelete(function () {
            let submit = {
                Rec_ID: model.Rec_ID
            };
            
            app.ajax('Lastmile/deleteHouse', { submit: JSON.stringify(submit) }).done(function (rs) {
                self.houseList.remove(model);
            });
        })
    }

    self.saveHouse = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ជូនដំណឹង!', 'ទិន្នន័យមិនទាន់ត្រឹមត្រូវ/ខ្វះ!');
            return;
        }

        let members = app.unko(self.memberList());

        members.forEach(r => {
            r.ForestEntry = r.ForestEntry == 1 ? 'Yes' : 'No';
            r.TDA = r.TDA == 1 ? 'Yes' : 'No'
            r.IPT = r.IPT == 1 ? 'Yes' : 'No'
        });

        members = members.filter(r => r.Rec_ID >= 0);

        var submit = {
            house: app.unko(self.houseHolder()),
            members: app.unko(members),
            village: self.village()
        };

        deleteList.forEach(r => submit.members.push({ Rec_ID: r.Rec_ID() * -1 }));

        app.ajax('Lastmile/saveHouse', { submit: JSON.stringify(submit) }).done(function (rs) {
            app.showMsg('Info', 'រក្សាទុកបានជោគជ័យ / Save successful');
            var path = "#!/houses?vl=" + self.village();
            pager.navigate(path);
        });
    }

    function setHouse() {
        let house = {
            Rec_ID: ko.observable(0),
            Month: ko.observable().extend({
                required: true,
            }),
            Year: ko.observable().extend({
                required: true,
            }),
            HasMemberAtHome: ko.observable().extend({
                required: true,
            }),
            Code_Vill_T: ko.observable(),
            HouseNumber: ko.observable().extend({
                required: true,
                pattern: {
                    message: 'បញ្ចូលជាតួលេខ',
                    params: '[0-9]'
                }
            }),
            HouseHolder: ko.observable().extend({
                required: true,
            }),
            Phone: ko.observable().extend({
                required: true,
                //pattern: {
                //    message: 'បញ្ចូលជាតួលេខ',
                //    params: '[0-9]'
                //}
            }),
            TotalMember: ko.pureComputed(function () {
                return parseInt(self.memberList().length - 1);
            }),
            LLIN: ko.observable(0),
            LLINLack: ko.pureComputed(function () {
                let totalMember = parseInt(self.memberList().length - 1);
                //return Math.round(house.LLIN() * 1.8) - totalMember;
                return parseInt(Math.round(totalMember / 1.8)) - parseInt(house.LLIN());
            }),
            LLIHN: ko.observable(0),
            
            TotalForestEntry: ko.pureComputed(function () {
                let p = self.memberList().filter(r => r.ForestEntry() == 1);
                return p.length;
            }),
            LLIHNLack: ko.pureComputed(function () {
                let totalForestEntry = self.memberList().filter(r => r.ForestEntry() == 1 && r.Age() != undefined).length;
                return parseInt(totalForestEntry) - parseInt(house.LLIHN());
            }),
            Lat: ko.observable().extend({
                required: false,
                pattern: {
                    message: 'បញ្ចូលជាតួលេខ',
                    params: '[0-9]'
                }
            }),
            Long: ko.observable().extend({
                required: false,
                pattern: {
                    message: 'បញ្ចូលជាតួលេខ',
                    params: '[0-9]'
                }
            }),
            CompleteBy: ko.observable().extend({
                required: true,
            }),
            Position: ko.observable().extend({
                required: true,
            }),
            CompleteDate: ko.observable(null).extend({
                required: true,
            }),

        }
        return house;
    }

    function setMember() {
        var member = {
            Rec_ID: ko.observable(-1),
            Name: ko.observable(),
            Age: ko.observable(),
            Sex: ko.observable(),
            ForestEntry: ko.observable(),
            TDA: ko.pureComputed(function () {
                return member.Age() >= 15 && member.Age() <= 49 && member.Sex() == 'M' ? 1 : 0;
            }),
            IPT: ko.pureComputed(function () {
                return member.Age() >= 15 && member.Age() <= 49 && member.Sex() == 'M' && member.ForestEntry() == 1 ? 1 : 0;
            }),
        };
        member.Name.extend({
            required: {
                onlyIf: function () {
                    return member.Rec_ID() == 0;
                }
            }
        });
        member.Age.extend({
            required: {
                onlyIf: function () {
                    return member.Rec_ID() == 0;
                }
            }
        });
        return member;
    }

    /*
    *TDA
    */
    self.loadTda = function (callback, page) {
        let vl = page.ctx.vl();
        let h = page.ctx.h();
        let tda = page.ctx.tda();
        let date_tda = page.ctx.date_tda();

        self.village(vl);

        if (tda == 2 && date_tda == '') {
            app.showMsg('Warning!', 'លោកអ្នកមិនអាចធ្វើ TDA2 មុន TDA1 បានទេ!');
            var path = "#!/houses?vl=" + vl;
            pager.navigate(path);
            return;
        }

        let tda1date = moment(date_tda);
        let now = moment();

        if (tda == 2 && now.diff(tda1date, 'days') < 28) {
            app.showMsg('Warning!', 'លោកអ្នកមិនអាចធ្វើ TDA2 តិចជាង TDA1 ២៨ថ្ងៃទេ!');
            var path = "#!/houses?vl=" + vl;
            pager.navigate(path);
            return;
        };

        self.TDAtype(tda);
        self.TDADate.extend({ required: { message: 'សូមជ្រើសរើសថ្ងៃខែឆ្នាំ!'} });

        app.ajax('Lastmile/getTDA', { house_id: h, type: tda }).done(function (rs) {
            self.TDADate( rs.tdaDate === null ? '' : rs.tdaDate );

            let tda = rs.TDA.map(function ( x ) {
                let r = app.ko(x);

                r.DoNotUse(r.DoNotUse() == 'Yes');
                r.SideEffect(r.SideEffect() == 'Yes');
                r.NotSick(r.NotSick() == 'Yes');

                r.Absent(r.Absent() == 'Yes');

                r.Date.subscribe(function (d) {
                    if (d != null) {
                        r.DoNotUse(false);
                        r.NotSick(false);
                        r.RejectOtherReason('');
                        r.Absent(false);
                        r.SideEffect(false);
                    }
                });

                r.DoNotUse.subscribe(function (d) {
                    if (d == true) {
                        r.NotSick(false);
                        r.RejectOtherReason('');
                        r.Absent(false);
                        r.SideEffect(false);
                        r.Date(null);
                    }
                });

                r.Absent.subscribe(function (d) {
                    if (d == true) {
                        r.NotSick(false);
                        r.DoNotUse(false);
                        r.RejectOtherReason('');
                        r.SideEffect(false);
                        r.Date(null);
                    }
                });

                return r;
            });

            self.TDAList(tda);
            self.TDAnet(app.ko(rs.net));

            self.TDAsummary(TDAsummary());

            var obj = {
                TDADate: self.TDADate,
                TDAList: self.TDAList,
                TDAnet: self.TDAnet,
                TDAsummary: self.TDAsummary
            }

            callback(obj);
        });
    }

    function TDAsummary() {
        let summary = {
            TDA1Total: self.TDAList().filter(r => r.Type() == 1 && r.IsTDA() == 1).length,
            TDA1Recieved: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 1 && r.Date() != null).length
            }),
            TDA1DoNotUse: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 1 && r.DoNotUse() == true).length
            }),
            TDA1SideEffect: ko.pureComputed(function(){
                return self.TDAList().filter(r => r.Type() == 1 && r.SideEffect() == true).length
            }),
            TDA1NotSick: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 1 && r.NotSick() == true).length
            }),
            TDA1OtherReason: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 1 && (r.RejectOtherReason() != '' && r.RejectOtherReason() != null)).length
            }),
            TDA1Absent: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 1 && r.Absent() == true).length
            }),

            TDA2Total: self.TDAList().filter(r => r.Type() == 2 && r.IsTDA() == 1).length,
            TDA2Recieved: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 2 && r.Date() != null).length
            }),
            TDA2DoNotUse: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 2 && r.DoNotUse() == true).length
            }),
            TDA2SideEffect: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 2 && r.SideEffect() == true).length
            }),
            TDA2NotSick: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 2 && r.NotSick() == true).length
            }),
            TDA2OtherReason: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 2 && (r.RejectOtherReason() != '' && r.RejectOtherReason() != null)).length
            }),
            TDA2Absent: ko.pureComputed(function () {
                return self.TDAList().filter(r => r.Type() == 2 && r.Absent() == true).length
            }),
        }
        return summary;
    }

    self.saveTDA = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('Warning!', 'សូមបញ្ចូលទិន្នន័យឲ្យបានគ្រប់!');
            return;
        }

        self.TDAList().forEach(x => {
            x.DoNotUse(x.DoNotUse() == true ? 'Yes' : 'No');
            x.SideEffect(x.SideEffect() == true ? 'Yes' : 'No');
            x.NotSick(x.NotSick() == true ? 'Yes' : 'No');
            x.Absent(x.Absent() == true ? 'Yes' : 'No');
        })
        
        var submit = {
            TDADate: app.unko(self.TDADate()),
            TDA: app.unko(self.TDAList()),
            net: app.unko(self.TDAnet()),
            type: app.unko(self.TDAtype())
        };

        app.ajax('Lastmile/saveTDA', { submit: JSON.stringify(submit) }).done(function (rs) {
            app.showMsg('Successful!', 'ប្រតិបត្តិការណ៍ទទួលបានជោគជ័យ!');
            var path = "#!/houses?vl=" + self.village();
            pager.navigate(path);
        });
    }

    self.deleteTDA = function (model) {
        app.showDelete(function () {
            let submit = {
                tda: model.tda(),
                house_id: model.h()
            };

            app.ajax('Lastmile/deleteTDA', { submit: JSON.stringify(submit) }).done(function (rs) {
                var path = "#!/houses?vl=" + model.vl();
                pager.navigate(path);
            });
        })
    }

    /*
    *IPT
    */
    self.loadIpt = function (callback, page) {
        let is_new = page.ctx.is_new();
        let h = page.ctx.h();
        let ipt_date = page.ctx.date()
        var iptDate = is_new == true ? '' : ipt_date;
        self.village(page.ctx.vl());

        self.IPTDate.extend({ required: {message: 'សូមជ្រើសរើសថ្ងៃខែឆ្នាំ!'} });
        self.IPTDate(iptDate);
        app.ajax('Lastmile/getIPT', { house_id: h, ipt_date: iptDate }).done(function (rs) {

            let ipt = rs.IPT.map(function (x) {
                let r = app.ko(x);

                r.Absent(r.Absent() == 'Yes');
                r.DoNotUse(r.DoNotUse() == 'Yes');
                r.SideEffect(r.SideEffect() == 'Yes');
                r.NotSick(r.NotSick() == 'Yes');
                r.NotEnterForest(r.NotEnterForest() == 'No');
                //r.EnterForest = ko.observable(r.NotEnterForest() == 'No');

                //r.EnterForest.subscribe(function (d) {
                //    console.log(d);
                //    if (d == true) r.NotEnterForest(false);
                //    else r.NotEnterForest(true);
                //});

                //r.NotEnterForest.subscribe(function (d) {
                //    if (d == true) r.EnterForest(false);
                //    else r.EnterForest(true);
                //});

                r.Date.subscribe(function (d) {
                    if (d != null) {
                        r.Absent(false);
                        r.DoNotUse(false);
                        r.SideEffect(false);
                        r.NotSick(false);
                        r.RefuseOtherReason('');
                        r.NotEnterForest(true);
                    }
                });

                r.DoNotUse.subscribe(function (d) {
                    if (d == true) {
                        r.Absent(false);
                        r.Date(null);
                        r.SideEffect(false);
                        r.NotSick(false);
                        r.RefuseOtherReason('');
                        r.NotEnterForest(false);
                        //r.EnterForest(false);
                    }
                });

                r.Absent.subscribe(function (d) {
                    if (d == true) {
                        r.Date(null);
                        r.DoNotUse(false);
                        r.SideEffect(false);
                        r.NotSick(false);
                        r.RefuseOtherReason('');
                        r.NotEnterForest(false);
                        //r.EnterForest(false);
                    }
                });

                r.NotEnterForest.subscribe(function (d) {
                    if (d == true) {
                        r.DoNotUse(false);
                        r.SideEffect(false);
                        r.NotSick(false);
                        r.RefuseOtherReason('');
                    } else {
                        r.Date(null);
                    }
                });

                return r;

            })

            self.IPTfList(ipt);

            self.TDAsummary2(rs.TDA);

            self.IPTsummary(IPTsummary());

            self.view('IPT');
            $('#ipt').modal('hide');

            let obj = {
                IPTDate: self.IPTDate,
                IPTfList: self.IPTfList,
                TDAsummary2: self.TDAsummary2,
                IPTsummary: self.IPTsummary
            };

            callback(obj);
        });
    }

    self.preLoadIPT = function (model) {
        let tda1date = moment(model.TDA1);
        let tda2date = moment(model.TDA2);
        let now = moment();
        /*
        if (model.TDA1 == null && model.TDA2 == null) {
            app.showMsg('Warning!', 'លោកអ្នកមិនអាចធ្វើ IPT មុន TDA1 និង TDA2 បានទេ!');
            return;
        }

        if (model.TDA1 != null && model.TDA2 == null && now.diff(tda1date, 'days') < 14) {
            app.showMsg('Warning!', 'លោកអ្នកមិនអាចធ្វើ IPT មុន១៤ថ្ងៃបន្ទាប់ពី TDA1 បានទេ!');
            return;
        }

        if (model.TDA1 != null && model.TDA2 != null && now.diff(tda2date, 'days') <14) {
            app.showMsg('Warning!', 'លោកអ្នកមិនអាចធ្វើ IPT មុន២៨ថ្ងៃបន្ទាប់ពី TDA2 បានទេ!');
            return;
        }
        */
        let master = {
            vl: model.Code_Vill_T,
            h: model.Rec_ID,
            houseNumber: model.HouseNumber
        }

        self.IPTmaster(master);

        self.houseID(model.Rec_ID);
        app.ajax('Lastmile/getIPTDate', { house_id: model.Rec_ID }).done(function (rs) {
            console.log(rs);
            rs.forEach(r => {
                r.ipt_date= r.IPTDate,
                r.vl= model.Code_Vill_T,
                r.h = model.Rec_ID,
                r.houseNumber = model.HouseNumber
            });

            self.IPTDates(rs);

            $('#ipt').modal({ show: true })
        });
    }

    function IPTsummary() {
        let summary = {
            DoNotUse: ko.pureComputed(function () {
                return self.IPTfList().filter(r => r.DoNotUse() == true).length;
            }),
            Reject: ko.pureComputed(function () {
                return self.IPTfList().filter(r => r.Reject() == true).length;
            }),
            IPT: ko.pureComputed(function () {
                return self.IPTfList().filter(r => r.Date() != null).length;
            }),
            W1: ko.pureComputed(function () {
                return self.IPTfList().filter(r => r.W1() == 'Yes').length;
            }),
            W2: ko.pureComputed(function () {
                return self.IPTfList().filter(r => r.W2() == 'Yes').length;
            }),
            W3: ko.pureComputed(function () {
                return self.IPTfList().filter(r => r.W3() == 'Yes').length;
            }),
            W4: ko.pureComputed(function () {
                return self.IPTfList().filter(r => r.W4() == 'Yes').length;
            })
        }
        return summary;
    }

    self.saveIPT = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('Warning!', 'សូមបញ្ចូលទិន្នន័យឲ្យបានគ្រប់!');
            return;
        }
        let IPTs = app.unko(self.IPTfList());
        IPTs.forEach(x => {
            x.Rec_ID = x.IptRec_ID;
            x.DoNotUse = x.DoNotUse == true ? 'Yes' : 'No';
            x.SideEffect = x.SideEffect == true ? 'Yes' : 'No';
            x.NotSick = x.NotSick == true ? 'Yes' : 'No';
            x.Absent = x.Absent == true ? 'Yes' : 'No';
            x.NotEnterForest = x.NotEnterForest == false ? 'Yes' : 'No';
            delete (x.IptRec_ID);
        });

        var submit = {
            IPT: IPTs,
            IPTDate: app.unko(self.IPTDate())
        };

        app.ajax('Lastmile/saveIPT', { submit: JSON.stringify(submit) }).done(function (rs) {
            var path = "#!/houses?vl=" + self.village();
            pager.navigate(path);
            app.showMsg('Successful!', 'ប្រតិបត្តិការណ៍ទទួលបានជោគជ័យ!');
        });
    }

    self.deleteIPT = function (model) {
        app.showDelete(function () {
            let submit = {
                ipt_date: model.date(),
                house_id: model.h()
            };

            app.ajax('Lastmile/deleteIPT', { submit: JSON.stringify(submit) }).done(function (rs) {
                var path = "#!/houses?vl=" + model.vl();
                pager.navigate(path);
            });
        })
    }
    /*
    * AFS
    */

    self.preLoadAFS = function (model) {
        let master = {
            vl: model.Code_Vill_T,
            h: model.Rec_ID,
            houseNumber: model.HouseNumber
        }

        self.AFSmaster(master);

        self.houseID(model.Rec_ID);
        app.ajax('Lastmile/getAFSDate', { house_id: model.Rec_ID }).done(function (rs) {
            rs.forEach(r => {
                r.afs_date = r.AFSDate,
                r.vl = model.Code_Vill_T,
                r.h = model.Rec_ID,
                r.houseNumber= model.HouseNumber
            });

            self.AFSDates(rs);

            $('#afs').modal({ show: true })
        });
    }

    self.loadAfs = function (callback, page) {
        let is_new = page.ctx.is_new();
        let h = page.ctx.h();
        let afs_date = page.ctx.date()
        var afsDate = is_new == true ? '' : afs_date;
        self.village(page.ctx.vl());

        self.AFSDate.extend({ required: { message: 'សូមជ្រើសរើសថ្ងៃខែឆ្នាំ!' } });
        self.AFSDate(afsDate);
        app.ajax('Lastmile/getAFS', { house_id: h, afs_date: afsDate }).done(function (rs) {

            self.AFSList(rs.AFS);

            $('#afs').modal('hide');

            let obj = {
                AFSDate: self.AFSDate,
                AFSList: self.AFSList
            };

            callback(obj);
        });
    }

    self.saveAFS = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('Warning!', 'សូមបញ្ចូលទិន្នន័យឲ្យបានគ្រប់!');
            return;
        }

        var submit = {
            AFS: app.unko(self.AFSList()),
            AFSDate: app.unko(self.AFSDate())
        };

        app.ajax('Lastmile/saveAFS', { submit: JSON.stringify(submit) }).done(function (rs) {
            var path = "#!/houses?vl=" + self.village();
            pager.navigate(path);
            app.showMsg('Successful!', 'ប្រតិបត្តិការណ៍ទទួលបានជោគជ័យ!');
        });
    }

    self.deleteAFS = function (model) {
        app.showDelete(function () {
            let submit = {
                afs_date: model.date(),
                house_id: model.h()
            };

            app.ajax('Lastmile/deleteAFS', { submit: JSON.stringify(submit) }).done(function (rs) {
                var path = "#!/houses?vl=" + model.vl();
                pager.navigate(path);
            });
        })
    }


    /*
    *village summary
    */
    self.villageSummary = function () {
        self.view('village-summary');
        app.ajax('Lastmile/getVillSummary', { village: self.village() }).done(function (rs) {
            self.villageInfo(app.ko(rs.village));
            self.villTDAList(rs.TDA);
        });
    }

    self.getVillIPT = function () {
        var submit = {
            month: self.month(),
            year: self.year(),
            village: self.village()
        }
        app.ajax('Lastmile/getVillIPT', submit).done(function (rs) {
            self.villIPTList(rs);
        });
    }

    /*
    *general
    */

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

    self.formatDate = function (date) {
        moment(date).format('DD-MM-YYYY')
    }

    for (var i = 2021; i <= moment().year() ; i++) {
        self.yearList.push(i);
    }
    for (var i = 1; i <= 12; i++) {
        self.monthList.push(('0' + i).substr(-2));
    }

    app.getPlace(['pv', 'od', 'hc', 'vl'], function (p) {
    	p.pv = p.pv.filter(r => r.target == 1);
    	p.od = p.od.filter(r => r.target == 1);
        place = p;

        app.ajax('Lastmile/getPreData', { prov: prov }).done(function (rs) {
            hcs = rs.hc;
            self.odList(rs.od);
        });
    });

    self.od.subscribe(function (code) {
        self.hcList(hcs.filter(r => r.od == code));
    });

    self.hc.subscribe(function () {
        self.getReport();
    });

    self.noLatLong.subscribe(function(v) {
        if (v) {
            let h = HouseArr.filter(r => r.Lat == null || r.Long == null);
            self.houseList(h);
        } else {
            self.houseList(HouseArr);
        }
    });
}