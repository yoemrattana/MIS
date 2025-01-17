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

    self.quizList = ko.observableArray();
    self.questionList = ko.observableArray();
    var quizArr = [];
    self.view = ko.observable();
    self.tab = ko.observable();
    var questionArr = [];
    self.question = ko.observable();
    self.selectedQuiz = ko.observable();

    self.quiz = ko.observable();
    function setQuiz(ele) {
        return {
            Rec_ID: ko.observable(ele == undefined ? '' : ele.Rec_ID),
            Title: ko.observable(ele == undefined ? '' : ele.Title).extend({ required: true }),
            Description: ko.observable(ele == undefined ? '' : ele.Description),
            Category: ko.observable(ele == undefined ? self.tab() : ele.Category).extend({ required: true }),
            Candidate: ko.observable(ele == undefined ? '' : ele.Candidate).extend({ required: true }),
        }
    }

    function setQuestion(ele) {
        return {
            Rec_ID: ko.observable(ele == undefined ? '' : ele.Rec_ID),
            Question: ko.observable(ele == undefined ? '' : ele.Question).extend({ required: true }),
            Module: ko.observable(ele == undefined ? '' : ele.Module).extend({ required: true }),
            Answers: ko.observableArray(ele == undefined ? setAnswers(undefined) : ele.Answers),
            QuizID: ko.observable(self.selectedQuiz().Rec_ID)
        }
    }

    function setAnswers(ele) { 
        var answers = [];
        for (let i = 0; i <= 3; i++) {
            let answer = {
                Rec_ID: ko.observable(ele == undefined ? '' : ele.Rec_ID),
                QuestionID: ko.observable(ele == undefined ? '' : ele.QuestionID),
                Answer: ko.observable(ele == undefined ? '' : ele.Answer).extend({ required: true }),
                IsCorrect: ko.observable(ele == undefined ? '' : ele.IsCorrect),
            };
            answers.push(answer);
        }

        return answers;
    }

    self.errors = ko.validation.group(this, { deep: true, observable: false });

    app.ajax('Quiz/getQuizList').done(function (rs) {
        quizArr = rs;
        self.quizList(quizArr);
    })

    self.addQuiz = function () {
        self.quiz(new setQuiz(undefined));
        
        $('#modalQuiz').modal('show');
    }

    self.editQuiz = function (model) {
        self.quiz(new setQuiz(model));
        $('#modalQuiz').modal('show');
    }

    self.saveQuiz = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            return;
        }

        var model = self.quiz();
        model = app.unko(model);
        app.ajax('Quiz/saveQuiz', { submit: JSON.stringify(model) }).done(function (rs) {
            $('#modalQuiz').modal('hide');
            app.showMsg('Successful', 'Update/Insert data successful!');
            if (model.Rec_ID == '') {
                self.quizList.push(rs);
                quizArr.push(rs);
            } else {
                let result = self.quizList().find(r=>r.Rec_ID == model.Rec_ID);
                self.quizList.remove(result);
                self.quizList.push(rs);

                quizArr.remove(result);
                quizArr.push(rs);
            }
            filterQuiz();
        })
    }

    self.deleteQuiz = function (model) {
        app.showDelete(function () {
            app.ajax('Quiz/deleteQuiz', { rec_id: model.Rec_ID }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.quizList.remove(model);
                quizArr.remove(model)
            });
        })
    }

    
    /*
    *   Question
    */

    self.viewQuestions = function (model) {
        self.selectedQuiz(model);
        app.ajax('Quiz/getQuestionList', { quizId: model.Rec_ID }).done(function (rs) {
            self.questionList(rs)
            self.view('question');
        });
    }

    self.saveQuestion = function () {

        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            return;
        }

        var model = self.question();
        model = app.unko(model);
        app.ajax('Quiz/saveQuestion', { submit: JSON.stringify(model) }).done(function (rs) {
            $('#modalQuestion').modal('hide');
            app.showMsg('Successful', 'Update/Insert data successful!');
            if (model.Rec_ID == '') {
                self.questionList.push(rs);
            } else {
                let result = self.questionList().find(r=>r.Rec_ID == model.Rec_ID);
                self.questionList.remove(result);
                self.questionList.push(rs);
            }
        })
    }

    self.editQuestion = function (model) {
        self.question(new setQuestion(model));
        $('#modalQuestion').modal('show');
    }

    self.addQuestion = function () {
        self.question(new setQuestion(undefined));

        $('#modalQuestion').modal('show');
    }

    self.deleteQuestion = function (model) {
        app.showDelete(function () {
            app.ajax('Quiz/deleteQuestion', { rec_id: model.Rec_ID }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.questionList.remove(model);
                
            });
        })
    }

    self.menuClick = function (root, event) {
        $('.btn-menu').removeClass('active btn-default');
        $('.btn-menu').each(function () {
            this == event.currentTarget ? $(this).addClass('active') : $(this).addClass('btn-default');
        });

        self.view('quiz');

        let tabName = $(event.currentTarget).text();
        self.tab(tabName);

        filterQuiz();
    };

    function filterQuiz() {
        let rs = quizArr.filter(r => r.Category == self.tab());
        self.quizList(rs);
    }

    self.importModel = ko.observable();
    self.status = ko.observable();
    self.selectFile = function () {
        self.importModel({ name: ko.observable('-'), status: ko.observable() });

        $('#modalUpload').modal('show');
        $('#file').val('').click();
    };

    self.fileChanged = function (files) {
        var model = self.importModel();
        model.name(files[0].name);
        model.status('Importing');

        var reader = new FileReader();
        reader.onload = function () {
            var submit = { base64: reader.result.split(',')[1], QuizID: self.selectedQuiz().Rec_ID };
            app.ajax('/Quiz/upload', submit).done(function (rs) {
                model.status('Done');
                self.questionList(rs);
            });
        };
        reader.readAsDataURL(files[0]);
    };

    self.dateFormat = function (date) {
        return moment(date, "YYYYMMDD h:mm:ss").fromNow();
    }
}