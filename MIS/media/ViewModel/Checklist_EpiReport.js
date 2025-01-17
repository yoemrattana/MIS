function viewModel() {
    self = this;

    self.master = ko.observableArray();
    self.place = ko.observable();
    self.date = ko.observable();
    self.participants = ko.observableArray();
    self.detailModel = ko.observableArray();
    self.problems = ko.observableArray();
    self.solutions = ko.observableArray();
    self.mission_no = window.location.pathname.split("/").pop()
    
    getData();

    self.showDetailModel = function () {
        var obj = {};

        var keys = ['Q1', 'Q2', 'Q3', 'Q4'];
        keys.forEach(k => {
            obj[k] = {
                Answer: {
                    thisYear: {
                        hc: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                        vmw: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                        total: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' }
                    },
                    lastYear: {
                        hc: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                        vmw: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                        total: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' }
                    }
                },
                Score: ''
            };
        });

        var keys = ['Q5', 'Q6', 'Q7', 'Q8', 'P1Q1', 'P1Q2', 'P1Q4'];
        keys.forEach(k => {
            obj[k] = {
                Answer: {
                    hc: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                    vmw: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                    total: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' }
                },
                Score: ''
            };
        });

        var keys = ['P1Q1', 'P1Q2', 'P1Q4'];
        keys.forEach(k => {
            obj[k] = {
                Answer: {
                    hc: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                    vmw: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                    total: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                },
                Score: ''
            };
        });

        var keys = ['P1Q6', 'P1Q7'];
        keys.forEach(k => {
            obj[k] = {
                Answer: { year: '', month1: '', value1: '', month2: '', value2: '', month3: '', value3: '' },
                Score: ''
            };
        });

        var keys = ['P1Q3', 'P1Q5', 'P1Q8'];
        keys.forEach(k => {
            obj[k] = {
                Answer: { tick: [], other: '' },
                Score: ''
            };
        });

        var keys = ['Q9', 'Q10', 'P1Q6_1', 'P1Q7_1', 'Request', 'Problem', 'Solution'];
        keys.forEach(k => {
            obj[k] = { Answer: '', Score: '' };
        });

        var keys = ['P1Q11', 'P2Q1'];
        keys.forEach(k => {
            obj[k] = {
                Answer: { tick: '', other: '', qty1: '', percent1: '', qty2: '', percent2: '', qty3: '', percent3: '' },
                Score: ''
            };
        });

        var keys = ['P2Q3', 'P2Q4'];
        keys.forEach(k => {
            obj[k] = {
                Answer: { tick: '', other: '', qty1: '', qty2: '' },
                Score: ''
            };
        });

        obj.P1Q9 = {
            Answer: {
                tablet: { L1: '', L2: '', L3: '', L4: '', IMP: '' },
                paper: { L1: '', L2: '', L3: '', L4: '', IMP: '' }
            },
            Score: ''
        };

        obj.P1Q10 = {
            Answer: { tick: '', other: '' },
            Score: ''
        };

        obj.P2Q2 = {
            Answer: { tick: '', other: '', qty1: '', qty2: '', qty3: '' },
            Score: ''
        };

        obj.P2Q5 = {
            Answer: { test: '', bednet: '', educate: '' },
            Score: ''
        };

        return obj;
    }

    function getData() {
        self.lastScrollY = window.scrollY;

        app.ajax('/Checklist/getEpiReport', { mission_no: self.mission_no }).done(function (rs) {
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

            var detail = self.showDetailModel();
            var detailArr = [];
            rs.children.forEach(r => {
                r.forEach(x => {
                    detail[x.Question].Answer = app.ko(JSON.parse(x.Answer));
                })

                detailArr.push(detail);
            });

            let problemArr = [];
            detailArr.forEach(r => {
                let problem = r.Problem.Answer;
                problemArr.push(problem);
            })
            problemArr = [...new Set(problemArr)];
            self.problems(problemArr);

            let solutionArr = [];
            detailArr.forEach(r => {
                let solution = r.Solution.Answer;
                solutionArr.push(solution);
            })
            solutionArr = [...new Set(solutionArr)];
            self.solutions(solutionArr);

            self.detailModel(detailArr);
        });
        
        window.scrollTo(0, 0);
    };
}