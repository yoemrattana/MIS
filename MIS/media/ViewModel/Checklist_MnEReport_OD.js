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

        var keys = ['P1Q1_1', 'P1Q1_2', 'P1Q1_3'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '' }),
                Score: function () {
                    return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
                }
            };
        });

        var keys = ['P1Q2_1', 'P1Q2_2', 'P1Q2_3'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ plan: '', result: '' }),
                Score: function () {
                    var a = this.Answer;
                    return a.plan() == '' || a.result() == '' ? ''
						: a.plan() == 0 ? '0'
						: (a.result() / a.plan() * 100).toFixed(0);
                }
            };
        });

        var keys = ['P1Q3_1', 'P1Q3_2', 'P1Q3_3', 'P1Q4', 'P1Q5', 'P1Q6', 'P1Q7'];
        keys.forEach(k => {
            obj[k] = {
                Answer: k != 'P1Q4' ? app.ko({ tick: '' }) : app.ko({ tick: '', other: '' }),
                Score: function () {
                    return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
                }
            };
        });

        var keys = ['P1Q8_1', 'P1Q8_2', 'P1Q8_3'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ plan: '', result: '' }),
                Score: function () {
                    var weights = { P1Q8_1: 2, P1Q8_2: 1, P1Q8_3: 2 };
                    var a = this.Answer;
                    return a.plan() == '' || a.result() == '' ? ''
						: a.plan() == 0 ? '0.00'
						: (a.result() * weights[k] / a.plan()).toFixed(2);
                }
            };
        });

        var keys = ['P2Q1', 'P2Q2', 'P2Q3', 'P2Q4', 'P2Q5'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko({ tick: '', stockin: '', stockout: '', balance: '', amc: '' }),
                Score: function () {
                    return this.Answer.tick() == '' ? '' : $(this.Answer.tick.elements).filter(':checked').attr('score') || '';
                }
            };
        });

        var keys = ['Test', 'Positive', 'Pf', 'Pv', 'Mix', 'Minor', 'Severe', 'Death', 'Report'];
        keys.forEach(k => {
            obj['P3VMW_' + k] = { Answer: app.ko(''), Score: () => '' };
            obj['P3HC_' + k] = { Answer: app.ko(''), Score: () => '' };
        });

        var keys = ['P4Q1', 'P4Q2', 'P4Q3', 'P4Q4', 'P4Q5'];
        keys.forEach(k => {
            obj[k] = {
                Answer: app.ko(''),
                Score: function () {
                    var weights = k == 'P4Q1' ? 0.12 : 0.045;
                    var percent = self.misAuto('P4G2', k).percent();
                    return percent === '' ? '' : (percent.toFloat() * weights).toFixed(2).toFloat();
                }
            };
        });

        var keys = ['P5Q1', 'P5Q2'];
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

        app.ajax('/Checklist/getMnEOdReport', { mission_no: self.mission_no }).done(function (rs) {
            
            self.master(rs.parents);
            let participants = rs.parents.map(function (o) {
                return JSON.parse(o.Participants);
            });

            self.participants(participants[0]);

            let date = rs.parents[0].StartDate + ' - ' + rs.parents[0].EndDate;
            self.date(date);

            let places = rs.parents.map(function (o) {
                return o.Name_OD_K;
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
                let problem = r.P5Q1.Answer;
                problemArr.push(problem);

                let problem2 = r.P5Q2.Answer;
                problemArr.push(problem2);
            })
            
            problemArr = [...new Set(problemArr)];
            self.problems(problemArr);
            self.detailModel(detailArr);
        });

        window.scrollTo(0, 0);
    };
}