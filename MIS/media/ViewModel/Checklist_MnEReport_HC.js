function viewModel() {
    self = this;

    self.master = ko.observableArray();
    self.place = ko.observable();
    self.date = ko.observable();
    self.participants = ko.observableArray();
    self.detailModel = ko.observableArray();
    self.problems = ko.observableArray();
    self.mission_no = window.location.pathname.split("/").pop()
    
    getData();

    self.showDetailModel = function () {
        var obj = {};

        var keys = ['P1Q1', 'P1Q1_1', 'P1Q1_2', 'P1Q2', 'P1Q3', 'P1Q4', 'P1Q5', 'P1Q7'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
                Score: function () {
                    return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
                }
            };
        });

        obj.P1Q6 = {
            Answer: app.ko({ tick: [] }),
            Score: function () {
                return this.Answer.tick().length * 2;
            }
        };

        var keys = ['P2Q1', 'P2Q2', 'P2Q3', 'P2Q4', 'P2Q5', 'P2Q6'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
                Score: function () {
                    return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
                }
            };
        });

        obj.P3Q1 = {
            Answer: app.ko({ test: '', pf: '', pv: '', mix: '', positive: '' }),
            Score: () => ''
        };

        var keys = ['P3Q2', 'P3Q3'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ pf: '', pv: '', mix: '', positive: '' }),
                Score: () => ''
            };
        });

        var keys = ['P3Q2_1', 'P3Q3_1', 'P3Q5'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko(''),
                Score: () => ''
            };
        });

        obj.P3Q4 = {
            Answer: app.ko({ l1: '', lc: '' }),
            Score: () => ''
        };

        var keys = ['P3Q3_2', 'P3Q3_3', 'P3Q3_4'];
        obj.P3Q3_2 = {
            Answer: {
                tick: function () {
                    var pfmix = parseInt(isempty(obj.P3Q2.Answer.pf(), 0)) + parseInt(isempty(obj.P3Q2.Answer.mix(), 0));
                    var total = parseInt(isempty(obj.P3Q1.Answer.pf(), 0)) + parseInt(isempty(obj.P3Q1.Answer.mix(), 0));
                    var percent = total == 0 ? 100 : pfmix * 100 / total;
                    return pfmix == 0 ? 'No'
						: percent < 25 ? 'Under 25%'
						: percent < 50 ? '25%-49%'
						: percent < 75 ? '50%-74%'
						: '75%-100%';
                }
            }
        };
        obj.P3Q3_3 = {
            Answer: {
                tick: function () {
                    var pv = parseInt(isempty(obj.P3Q2.Answer.pv(), 0));
                    var total = parseInt(isempty(obj.P3Q1.Answer.pv(), 0));
                    var percent = total == 0 ? 100 : pv * 100 / total;
                    return pv == 0 ? 'No'
						: percent < 25 ? 'Under 25%'
						: percent < 50 ? '25%-49%'
						: percent < 75 ? '50%-74%'
						: '75%-100%';
                }
            }
        };
        obj.P3Q3_4 = {
            Answer: {
                tick: function () {
                    var pfmix = parseInt(isempty(obj.P3Q3.Answer.pf(), 0)) + parseInt(isempty(obj.P3Q3.Answer.mix(), 0));
                    var total = parseInt(isempty(obj.P3Q1.Answer.pf(), 0)) + parseInt(isempty(obj.P3Q1.Answer.mix(), 0));
                    var percent = total == 0 ? 100 : pfmix * 100 / total;
                    return pfmix == 0 ? 'No'
						: percent < 25 ? 'Under 25%'
						: percent < 50 ? '25%-49%'
						: percent < 75 ? '50%-74%'
						: '75%-100%';
                }
            }
        };

        keys.forEach(k => {
            obj[k].Score = function () {
                var weights = {
                    P3Q3_2: { 'No': 8, 'Under 25%': 2, '25%-49%': 4, '50%-74%': 6, '75%-100%': 8 },
                    P3Q3_3: { 'No': 8, 'Under 25%': 2, '25%-49%': 4, '50%-74%': 6, '75%-100%': 8 },
                    P3Q3_4: { 'No': 4, 'Under 25%': 1, '25%-49%': 2, '50%-74%': 3, '75%-100%': 4 }
                };
                return this.Answer.tick() == '' ? '' : weights[k][this.Answer.tick()];
            };
        });

        obj.P4 = {
            Answer: app.ko({ qty: '', list: [] }),
            Score: () => ''
        };
        obj.P4.Answer.qty.subscribe(function () {
            var a = obj.P4.Answer;
            var qty = a.qty().toFloat();
            var len = a.list().length;
            if (len < qty) {
                for (var i = 0; i < qty - len ; i++) {
                    var row = app.ko({ sex: '', age: '', virus: '', medicine: '', pill: '', duration: '', tick: '', score: '' });
                    row.getScore = function () {
                        this.score(this.tick() == '' ? '' : this.tick() == 'Correct' ? (10 / a.qty()).toFixed(2).toFloat() : 0);
                        return this.score();
                    }
                    a.list.push(row);
                }
            } else if (len > qty) {
                a.list.splice(qty, len - qty);
            }

            $('input[numonly2]').each(function (index, el) {
                app.setNumberOnly(el, $(el).attr('numonly2'));
            });
        });

        var keys = ['P5Q1', 'P5Q2', 'P5Q3', 'P5Q4', 'P5Q5'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
                Score: function () {
                    return this.Answer.tick() == '' ? '' : this.Answer.tick() == 'Stockout' ? 0 : 2;
                }
            };
        });

        var keys = ['P6Q1', 'P6Q2'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ problem: '', solution: '', person: '', date: null }),
                Score: () => ''
            };
        });

        return obj;
    }

    function getData() {
        self.lastScrollY = window.scrollY;

        app.ajax('/Checklist/getMnEHcReport', { mission_no: self.mission_no }).done(function (rs) {
            self.master(rs.parents);
            let participants = rs.parents.map(function (o) {
                return JSON.parse(o.Participants);
            });

            self.participants(participants[0]);

            let date = rs.parents[0].StartDate + ' - ' + rs.parents[0].EndDate;
            self.date(date);

            let places = rs.parents.map(function (o) {
                return o.Name_Facility_K;
            });
            places = [...new Set(places)];
            let placeTxt = places.join();
            self.place(placeTxt);

            var detailArr = [];
            rs.children.forEach(r => {
                var detail = self.showDetailModel();
                r.forEach(x => {
                    detail[x.Question].Answer = app.ko(JSON.parse(x.Answer));
                })

                detailArr.push(detail);
            });

            let problemArr = [];
            detailArr.forEach(r => {
                let problem = r.P6Q1.Answer;
                problemArr.push(problem);

                let problem2 = r.P6Q2.Answer;
                problemArr.push(problem2);
            })
            problemArr = [...new Set(problemArr)];
            self.problems(problemArr);
            self.detailModel(detailArr);
        });

        window.scrollTo(0, 0);
    };
}