function viewModel() {
    self = this;

    self.master = ko.observableArray();
    self.place = ko.observable();
    self.date = ko.observable();
    self.participants = ko.observableArray();
    self.detailModel = ko.observableArray();
    self.problems = ko.observableArray();
    self.solutions = ko.observableArray();
    self.mission_no = window.location.pathname.split("/").pop();
    getData();

    self.showDetailModel = function () {
        var obj = {};

        var part = 'P2';
        for (var i = 1; i <= 3; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        obj['P2Q4'] = Array.repeat(5, () => {
            return {
                microscope: '',
                month: '',
                basis: '',
                refresher: '',
                evaluation: '',
                note: ''
            };
        });

        var part = 'P3';
        for (var i = 1; i <= 7; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P4_1';
        for (var i = 1; i <= 5; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P4_2';
        for (var i = 1; i <= 4; i++) {
            var k = part + 'Q' + i;
            obj[k] = i <= 3 ? { answer: '', note: '' } : { answer: '', note: '', useColor: false, other: '' };
        }

        var part = 'P4_3';
        for (var i = 1; i <= 2; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P4_4';
        for (var i = 1; i <= 8; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P5_1';
        for (var i = 1; i <= 12; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P5_2';
        for (var i = 1; i <= 6; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: ['', '', '', '', ''] };
        }

        var part = 'P6';
        for (var i = 1; i <= 5; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P7';
        for (var i = 1; i <= 9; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P8';
        for (var i = 1; i <= 10; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P9_1';
        for (var i = 1; i <= 8; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P9_2';
        for (var i = 1; i <= 7; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P9_3';
        for (var i = 1; i <= 10; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P9_4';
        for (var i = 1; i <= 23; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        var part = 'P10';
        for (var i = 1; i <= 6; i++) {
            var k = part + 'Q' + i;
            obj[k] = { answer: '', note: '' };
        }

        obj['ProblemSolution'] = '';

        return obj;
    }

    function getData() {
        self.lastScrollY = window.scrollY;

        app.ajax('/Checklist/getLaboReport', { mission_no: self.mission_no }).done(function (rs) {
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
                    detail[x.Question] = JSON.parse(x.Answer);
                })

                detailArr.push(detail);
            });

            let problemArr = [];
            detailArr.forEach(r => {
                let problem = r.ProblemSolution;
                problemArr.push(problem);
            })
            problemArr = [...new Set(problemArr)];
            self.problems(problemArr);
            self.detailModel(detailArr);
        });

        window.scrollTo(0, 0);
    };
}