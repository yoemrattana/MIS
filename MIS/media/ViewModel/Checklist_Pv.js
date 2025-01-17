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

    self.listModel = ko.observableArray();
    self.detailModel = ko.observable();
    self.view = ko.observable('list');

    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.inputPlaceModel = ko.observable();
    self.yearList = [];

    self.year = ko.observable();
    self.optionList = ko.observableArray(["", "Yes", "No"]);

    var place = null;
    var pvAll = [];

    for (var i = 2024; i <= moment().year(); i++) {
        self.yearList.push(i);
    }

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        pvAll = p.pv;
        vls = p.vl;

        place = p;
        if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

        var arr = place.od.map(r => r.pvcode).distinct();
        place.pv = place.pv.filter(r => arr.contain(r.code));
        self.pvList(place.pv);

        app.ajax('/ChecklistPv/getList').done(function (rs) {
            self.listModel( rs )
        })
    });

    self.getListModel = function () {
        var list = self.listModel();

        if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());
        if (self.od() != null) list = list.filter(r => r.Code_OD_T == self.od());
        if (self.hc() != null) list = list.filter(r => r.Code_Facility_T == self.hc());

        return list;
    };

    self.create = () => {
        app.ajax('/ChecklistPv/getDetail').done(function (rs) {
            self.detailModel(setQuestion(rs))
            self.view('detail')
        });
    }

    self.setValue = function (arr, sort) {
        let section = getSection(sort)
        
        let lst = arr.Children()
        let rs = _.filter(lst, ['Section', section])
        
        let totalScore = _.sumBy(rs, x => Number(x.Score()))
        console.log(totalScore);
        if (totalScore >= 90 && totalScore <= 100) return '90-100'
        return ''
    }

    function getPart(index) {
        if (index == 0) return '1-1';
        if (index == 1) return '1-2';
        if (index == 2) return '1-3';
        if (index == 3) return '2-1-1';
        if (index == 4) return '2-1-2';
        if (index == 5) return '2-1-3';
        if (index == 6) return '2-1-4';
        if (index == 7) return '3-1-1';
        if (index == 8) return '4-1-1';
    }

    self.partScore = function (arr, data, index) {
        let part = getPart(index)
        let lst = app.unko(arr);
        let rs = _.filter(lst.Children, ['Section', part])
        let score = _.sumBy(rs, 'Score')

        let questionNumber = rs.filter(x => x.NotApplicable != true && x.DataType == 'int').length

        if (part === '3-1-1') {
            questionNumber = rs.filter(x => x.NotApplicable == true).length
            score = _.sumBy(rs, x => Number(x.Subscore))
        }

        if (part === '4-1-1') {
            questionNumber = rs.filter(x => x.NotApplicable != true).length
        }

        let denominator = scoreCondition(part) * questionNumber

        let percentage = (score * 100 / denominator).toFixed(2)

        let finalScore = 0
        let perScore = ''

        if (percentage >= 90 && percentage <= 100) {
            finalScore = 5
            perScore = '90-100'
        }

        if (percentage >= 75 && percentage <= 89) {
            finalScore = 4
            perScore = '75-89'
        }

        if (percentage >= 60 && percentage <= 74) {
            finalScore = 3
            perScore = '60-74'
        }

        if (percentage >= 50 && percentage <= 59) {
            finalScore = 2
            perScore = '50-59'
        }

        if (percentage >= 40 && percentage <= 49) {
            finalScore = 1
            perScore = '40-49'
        }

        if (percentage < 40) {
            finalScore = 0
            perScore = '40'
        }

        data.Value(perScore)

        return finalScore
    }

    function getSection(sort) {
        if( sort == 1) return '1-1'
        if( sort == 2) return '1-2'
        if( sort == 3) return '1-3'
        if( sort == 4) return '2-1-1'
        if( sort == 5) return '2-1-2'
        if( sort == 6) return '2-1-3'
        if( sort == 7) return '2-1-4'
        if( sort == 8) return '3-1-1'
        if( sort == 9) return '4-1-1'
    }

    self.viewDetail = function (model) {
        let submit = {
            Rec_ID: model.Rec_ID
        }
        app.ajax('/ChecklistPv/getDetail', submit).done(function (rs) {
            self.detailModel(setQuestion(rs))
            self.view('detail')
        });
    }

    function setQuestion(model) {
        let item = {
            Rec_ID: ko.observable(model?.Rec_ID || 0),
            Code_Prov_T: ko.observable(model?.Code_Prov_T).extend({ required: true }),
            Code_OD_T: ko.observable(model?.Code_OD_T).extend({ required: true }),
            Code_Facility_T: ko.observable(model?.Code_Facility_T).extend({ required: true }),
            DateAssessment: ko.observable(model?.DateAssessment).extend({ required: true }),
            EvaluatedBy: ko.observable(model?.EvaluatedBy).extend({ required: true }),
            AssessmentType: ko.observable(model?.AssessmentType).extend({ required: true }),
            TimeStart: ko.observable(model?.TimeStart).extend({ required: true }),
            TimeEnd: ko.observable(model?.TimeEnd).extend({ required: true }),
            Children: ko.observableArray(model?.Items.map(r => setChild(r))),
            TotalScore: ko.pureComputed(() => {
                return item.Children().filter(r => r.Section() == '4-1-2').reduce((t, e) => t + e.Score(), 0)
                //let score = _.sumBy(item.Children(), x => Number(x.Score()))
                //let subscore = _.sumBy(item.Children(), x => Number(x.Subscore()))
                //return score + subscore
            })
        }
        if (item.Rec_ID() === 0) {
            item.Code_Prov_T.subscribe(function (code) {
                self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
            });

            item.Code_OD_T.subscribe(function (code) {
                self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
            });
        } else {
            let ods = place.od.filter(r => r.pvcode == item.Code_Prov_T())
            self.odList(ods)
            let hcs = place.hc.filter(r => r.odcode == item.Code_OD_T())
            self.hcList(hcs)
        }

        return item;
    }

    function objValue(model) {
        if (model.Value() != null && model.Value() != '' && model.Value != undefined) {
            model.Value = JSON.parse(model.Value())
        } else {
            model.Value = {
                attr: ko.observable(),
                value: ko.observable()
            }
        }
        
        return model
    }

    function setChild(model) {
        let m = { ...model }

        let item = {
            Sort: ko.observable(model?.Sort),
            AttributeID: ko.observable(model?.AttributeID),
            AttributeName: ko.observable(model?.AttributeName),
            DataType: ko.observable(model?.DataType),
            ShortName: ko.observable(model?.ShortName),
            Section: ko.observable(model?.Section),
            Value: ko.observable(model?.Value),
            Score: ko.pureComputed(function (r) {
                return calculateScore(item)
            }),
            Subscore: ko.observable(0),
            NotApplicable: ko.observable(model.NotApplicable || 0),
        }
        
        if (item.Section() == '3-1-1') {
            let score = m.Score == undefined ? 0 : m.Score
            item.Subscore(score)
            objValue(item)
        }

        return item;
    }

    function scoreCondition( section ) {
        if (section.in('1-1', '3-1-1')) return 2;
        if ( section.in('1-2','1-3', '2-1-1', '2-1-2', '2-1-3', '2-1-4', '4-1-1') ) return 1;
    }

    self.totalScoreBySection = (arr, section) => {
        let lst = app.unko(arr);
        let rs = _.filter(lst, ['Section', section])
        let score = _.sumBy(rs, 'Score')
        let questionNumber = rs.filter(x => x.NotApplicable != true && x.DataType == 'int').length

        if (section === '3-1-1') {
            questionNumber = rs.filter(x => x.NotApplicable == true).length
            score = _.sumBy(rs, x => Number(x.Subscore))
        }

        if (section === '4-1-1') {
            questionNumber = rs.filter(x => x.NotApplicable != true).length
        }

        let denominator = scoreCondition(section) * questionNumber

        return {
            score: score,
            percentage: (score * 100 / denominator).toFixed(2)
        }
    }

    function calculateScore(item) {

        if (item.NotApplicable() == true) return 0

        if (item.Section() == '4-1-2') {
            if (item.Value() == '90-100') return 5
            if (item.Value() == '75-89') return 4
            if (item.Value() == '60-74') return 3
            if (item.Value() == '50-59') return 2
            if (item.Value() == '40-49') return 1
            if (item.Value() == '40') return 0
        }

        if (item.Section() == '1-1') {
            if (item.ShortName() == 'pv_supervisor_name') return 0
            if (Number(item.Value()) < 2) return 0
            if (Number(item.Value()) === 2) return 1
            if (Number(item.Value()) > 2) return 2
        }

        if (item.Section().in('1-2', '1-3', '2-1-1', '2-1-2', '2-1-3', '2-1-4', '4-1-1')) {
            if (item.Value() === 'Yes') return 1
        }

        if (item.Section() == '3-1-1') {
            return Number(item.Subscore());
        }

        return 0
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = app.unko(self.detailModel());

        model.Children = model.Children.map(r => {
            if (r.Section == '3-1-1') {
                r.Score = r.Subscore
            }
            delete (r.AttributeName)
            return r
        })

        model.DateAssessment = model.DateAssessment.format('YYYY-MM-DD')

        app.ajax('/ChecklistPv/save', { submit: model }).done(function (rs) {
            if (model.Rec_ID === 0) {
                self.listModel.push(rs)
            }
            self.view('list');
        });
    }

    self.delete = function (model) {
        app.showDelete(function () {
            var submit = {
                table: 'tblChecklistPv',
                where: { Rec_ID: model.Rec_ID }
            };

            submit = { submit: JSON.stringify(submit) };

            app.ajax('/Direct/delete', submit).done(function () {
                let r = self.listModel().find(r => r.Rec_ID == model.Rec_ID)
                self.listModel.remove(r)
            });
        });
    }

    self.getODName = function (code) {
        var found = place.od.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getProvName = function (code) {
        var found = place.pv.find(r => r.code == code.trim());
        return found == null ? code : found.nameK;
    };

    self.getHCName = function (code) {
        var found = place.hc.find(r => r.code == code.trim());
        return found == null ? code : found.nameK;
    };

    self.pv.subscribe(function (code) {
        self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
    });

    self.back = function () {
        self.view('list');
    }

    var temp = '';
    self.radioClick = (model, e) => {
        if (temp == model['Value']()) {
            model['Value']('');
        }
        temp = model['Value']();
        return true;
    }

    self.showNotApplicable = (arr, section) => {
        let obj = app.unko(arr);
        if (section == '1-1' && obj.Sort.in(5,6,8)) return true;

        if (section == '4-1-1') return true
        return false
    }
}

ko.components.register('section-4-1-2-A', {
    viewModel: viewModel.setChild,
    template: 
        '<td colspan="7">'
        + '<label data-bind="text: AttributeName"></label>'
        + '<input data-bind="value: Value, attr: { name: ShortName}" type="text" class="form-control"/>'
        + '</td>'
})

ko.components.register('section-1-1', {
    viewModel: viewModel.setChild,
    template:
        '<td data-bind="text: Sort">'
        + '<td data-bind="text: AttributeName"></td>'
        + '<td> <input type="checkbox" class="form-control" data-bind="visible: $root.showNotApplicable($data, \'1-1\'),checked: NotApplicable"> </td>'
        + '<td>'
        + '<input data-bind="value: Value, attr: { name: ShortName, type: DataType() == \'nvarchar\' ? \'text\': \'number\' }" class="form-control"/>'
        + '</td>'
        + '<td>'
        + '<input data-bind="visible: DataType() == \'int\', value: Score, attr: { name: ShortName}" type="text" class="form-control" disabled/>'
        + '</td>'
})

ko.components.register('section-1-2', {
    viewModel: viewModel.setChild,
    template:
          '<!-- ko if: !ShortName().in("staff_name", "g6pd_level_1", "g6pd_level_2", "hb_level_1", "hb_level_2") -->'
        + '<td data-bind="text: Sort">'
        + '<td data-bind="text: AttributeName"></td>'
        + '<td>'
        + '<select data-bind="options: $root.optionList, value: Value, attr: { name: ShortName}" class="form-control"> </select>'
        + '</td>'
        + '<td>'
        + '<input data-bind="value: Score, attr: { name: ShortName}" type="text" class="form-control" disabled/>'
        + '</td>'
        + '<!-- /ko -->'
})

ko.components.register('section-4-1-1', {
    viewModel: viewModel.setChild,
    template:
        '<td data-bind="text: Sort">'
        + '<td data-bind="text: AttributeName"></td>'
        + '<td> <input type="checkbox" class="form-control" data-bind="visible: $root.showNotApplicable($data, \'4-1-1\'),checked: NotApplicable"> </td>'
        + '<td>'
        + '<select data-bind="enable: NotApplicable() == false, options: $root.optionList, value: Value, attr: { name: ShortName}" class="form-control"> </select>'
        + '</td>'
        + '<td>'
        + '<input data-bind="value: Score, attr: { name: ShortName}" type="text" class="form-control" disabled/>'
        + '</td>'
})

ko.components.register('section-3-1-1', {
    viewModel: viewModel.setChild,
    template:
        '<td data-bind="text: Sort">' 
        + '<td data-bind="text: AttributeName"></td>'
        + '<td> <input type="checkbox" class="form-control" data-bind="checked: NotApplicable"> </td>'
        + '<td>'
        + '<input data-bind="visible: NotApplicable() == true, value: Value.attr, attr: { name: ShortName}" type="text" class="form-control"/>'
        + '</td>'
        + '<td>'
        + '<input data-bind="visible: NotApplicable() == true, value: Value.value, attr: { name: ShortName}" type="text" class="form-control"/>'
        + '</td>'
        + '<td>'
        + '<input type="number" min="0" max="2" data-bind="value: Subscore, attr: { name: ShortName}" type="number" class="form-control"/>'
        + '</td>'
})

ko.components.register('section-4-1-2', {
    viewModel: viewModel.setChild,
    template: '<td data-bind="text: AttributeName"></td> '
        + '<td class="ct"> '
        + '<label class= "radio-inline radio-lg"> '
        + '<span data-bind="text: $root.partScore(Children, "1-1")">90% - 100%</span>'
        + '</label> '
        + '</td>'

        + '<td> '
        + '<label class= "radio-inline radio-lg"> '
        + '<input type="radio" value="75-89" data-bind="checked: Value, attr: { name: ShortName}, click: $root.radioClick" /> '
        + '<kh>៧៥% - ៨៩%</kh> '
        + '</label> '
        + '</td>'

        + '<td> '
        + '<label class= "radio-inline radio-lg"> '
        + '<input type="radio" value="60-74" data-bind="checked: Value, attr: { name: ShortName}, click: $root.radioClick" /> '
        + '<kh>៦០% - ៧៤%</kh> '
        + '</label> '
        + '</td>'

        + '<td> '
        + '<label class= "radio-inline radio-lg"> '
        + '<input type="radio"  value="50-59" data-bind="checked: Value, attr: { name: ShortName}, click: $root.radioClick" /> '
        + '<kh>៥០% - ៥៩%</kh> '
        + '</label> '
        + '</td>'

        + '<td> '
        + '<label class= "radio-inline radio-lg"> '
        + '<input type="radio" value="40-49" data-bind="checked: Value, attr: { name: ShortName}, click: $root.radioClick" /> '
        + '<kh>៤០% - ៤៩%</kh> '
        + '</label> '
        + '</td>'

        + '<td> '
        + '<label class= "radio-inline radio-lg"> '
        + '<input type="radio" value="40" data-bind="checked: Value, attr: { name: ShortName}, click: $root.radioClick" /> '
        + '<kh>៤០%</kh> '
        + '</label> '
        + '</td>'
});