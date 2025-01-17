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
        return {
            Q2: {
                village: '', villageVMW: '', villageMMW: '',
                vmw: '', mmw: '', vhv: '',
                mobile: '', immigration: '',
                site: '', worker: '',
                hcData: {
                    m1: { total: '', pf: '', pv: '', mix: '' },
                    m2: { total: '', pf: '', pv: '', mix: '' },
                    m3: { total: '', pf: '', pv: '', mix: '' },
                },
                vmwData: {
                    m1: { total: '', pf: '', pv: '', mix: '' },
                    m2: { total: '', pf: '', pv: '', mix: '' },
                    m3: { total: '', pf: '', pv: '', mix: '' },
                },
                asmqAdult: { total: '', expire: null },
                asmqChildren: { total: '', expire: null },
                primarquine: { total: '', expire: null },
                rdt: { total: '', expire: null },
            },
            Q31: {
                meeting: '', meetingReason: '',
                vmw: '', absent: '', absentReason: '',
                message: '', messageReason: '',
                topic: '', meetingSetup: '', meetingSetupReason: ''
            },
            Q32: {
                educate: '', reason: '',
                times: '', people: '', female: '',
                who: '', other: '',
                schedule: '', method: ''
            },
            Q331: {
                community: '', reason: '',
                people: '', female: '', male: '',
                equipment: [],
                implement: '',
                experience: ''
            },
            Q332: {
                educate: '', educatedVillage: '',
                people: '', female: '', male: '',
                noneducatedVillage: '', reason: '',
                challenge: ''
            },
            Q341: '',
            Q342: {
                equipment: [], distribution: '',
                banner: '', location: '', broken: ''
            },
            Q4: {
                bednet: '', total: '', reason: ''
            },
            Q5: '',
            Q6: '',
            Q7: '',
            Problem: '',
            Solution: '',
        };
    }

    function getData() {
        self.lastScrollY = window.scrollY;

        app.ajax('/Checklist/getEduHCReport', { mission_no: self.mission_no }).done(function (rs) {
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