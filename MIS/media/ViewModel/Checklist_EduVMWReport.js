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
        return {
            Q1: { meeting: '', reason: '' },
            Q2: '',
            Q3: { times: '', participant: '', female: '' },
            Q4: { how: '', reason: '' },
            Q5: '',
            Q6: [],
            Q7: { who: '', name: '' },
            Q8: '',
            Q9: [],
            Q10: '',
            Q11: { transfer: '', virus: '' },
            Q12: '',
            Q13: '',
            Problem: '',
            Solution: '',
        };
    }

    function getData() {
        self.lastScrollY = window.scrollY;

        app.ajax('/Checklist/getEduVMWReport', { mission_no: self.mission_no }).done(function (rs) {
            self.master(rs.parents);
            let participants = rs.parents.map(function (o) {
                return JSON.parse(o.Participants);
            });

            self.participants(participants[0]);

            let date = rs.parents[0].StartDate + ' - ' + rs.parents[0].EndDate;
            self.date(date);

            let places = rs.parents.map(function (o) {
                return o.Name_Vill_K;
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
                let problem = r.Problem;
                problemArr.push(problem);
            })
            problemArr = [...new Set(problemArr)];
            self.problems(problemArr);

            let solutionArr = [];
            detailArr.forEach(r => {
                let solution = r.Solution;
                solutionArr.push(solution);
            })
            solutionArr = [...new Set(solutionArr)];
            self.solutions(solutionArr);

            self.detailModel(detailArr);
        });

        window.scrollTo(0, 0);
    };
}