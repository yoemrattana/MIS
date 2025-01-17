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

    self.tab = ko.observable();
    self.view = ko.observable('list');
    self.item = ko.observable(new setItem(undefined));
    self.subCat = ko.observable();
    self.itemPreview = ko.observable();
    self.listComment = ko.observableArray();
    self.unreadComments = ko.observableArray();
    self.unreadCmtCount = ko.observable();
    self.titleComment = ko.observable();
    var itemArr = [];
    var unreadCommentArr = [];
    var commentArr = [];

    var place = '';
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.vl = ko.observable();
    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.vlList = ko.observableArray();

    self.errors = ko.validation.group(this, { deep: true, observable: false });
    self.listModel = ko.observableArray();
    self.subCatList = ko.observableArray();

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        p.pv = p.pv.filter(r => r.target == 1);
        p.od = p.od.filter(r => r.target == 1);
        self.place = p;
        place = p;
        if (app.user.prov != '') self.place.pv = self.place.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') self.place.od = self.place.od.filter(r => r.code == app.user.od);

        var arr = self.place.od.map(r => r.pvcode).distinct();
        self.place.pv = self.place.pv.filter(r => arr.contain(r.code));
        self.pvList(self.place.pv);
    });

    self.pv.subscribe(function (code) {
        self.odList(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
        filterComment(code, 'pv');
        filterUnreadCmt(code, 'pv');
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : self.place.hc.filter(r => r.odcode == code));
        filterComment(code, 'od');
        filterUnreadCmt(code, 'pv');
    });

    self.hc.subscribe(function (code) {
        self.vlList(code == null ? [] : self.place.vl.filter(r => r.hccode == code));
        filterComment(code, 'hc');
        filterUnreadCmt(code, 'pv');
    });

    function setItem(ele) {
        var item = {
            Rec_ID: ko.observable(ele == undefined ? '' : ele.Rec_ID),
            Title: ko.observable(ele == undefined ? '' : ele.Title).extend({ required: true }),
            Audience: ko.observableArray(ele == undefined ? [] : ele.Audience).extend({ required: true }),
            Type: ko.observable(ele == undefined ? '' : ele.Type).extend({ required: true }),
            Category: ko.observable(ele == undefined ? '' : ele.Category).extend({ required: true }),
            SubCategory: ko.observable(ele == undefined ? '' : ele.SubCategory),
            Source: ko.observable(ele == undefined ? '' : ele.Source),
            File: ko.observable(),
            Thumbnail: ko.observable(ele == undefined ? '' : ele.Thumbnail).extend({ required: true }),
            YouTube: ko.observable(ele == undefined ? '' : ele.YouTube),
            Unit: ko.observable(ele == undefined ? '' : ele.Unit)
        }

        item.YouTube.extend({
            required: {
                onlyIf: function () {
                    return item.Type() == 'Video';
                }
            }
        })

        return item;
    }

    function setSubCat(ele) {
        return {
            Rec_ID: ko.observable(ele == undefined ? '' : ele.Rec_ID),
            Title: ko.observable(ele == undefined ? '' : ele.Title),
        }
    }

    app.ajax('Train/getList').done(function (rs) {
        itemArr = rs['materials'];
        
        self.subCatList(rs.subCats) ;
        
        itemArr.map(r => {
            r.Link =  '/media/Training/' + r.Source;
        });
        self.listModel(itemArr);

        unreadCmt = rs['unreadComments'];
        unreadCmt.map(r => {
            r.Place = r.Code_Place.length == 10 ? self.getVLName(r.Code_Place) : self.getHCName(r.Code_Place);
        });

        self.unreadCmtCount(unreadCmt.length);
        unreadCommentArr = unreadCmt;
        self.unreadComments(unreadCommentArr);
    })

    self.add = function () {
        self.item(setItem(undefined));
        $('#modalUpload').modal('show');
    }

    self.addSubCat = function () {
        self.subCat(setSubCat(undefined));
        $('#modalSubCat').modal('show');
    }

    self.edit = function (model) {
        var temp = model.Audience;
        temp = isnullempty(temp) ? [] : Array.isArray(temp) ? temp : temp.split(', ');
        model.Audience = temp;
        self.item(setItem(model));
        $('#modalUpload').modal('show');
    }

    self.preview = function (model) {
        self.itemPreview(model);
        $('#modalView').modal('show');
    }

    self.selectFile = function () {
        $('#file').val('').click();
    }

    self.fileChanged = function (files) {
        if (files[0].size > 157286400) {
            self.item().File('');
            alert('File too large! File size cannot exceed 150MB.');
            return;
        }

        var reader = new FileReader();
            
        reader.onload = function () {
            self.item().File(reader.result.split(',')[1]);
        }

        reader.readAsDataURL(files[0]);
    }

    self.selectThumbnail = function () {
        $('#thumbnail').val('').click();
    }

    self.thumbnailChanged = function (files) {
        var reader = new FileReader();

        reader.onload = function () {
            self.item().Thumbnail(reader.result.split(',')[1]);
        }

        reader.readAsDataURL(files[0]);
    }

    self.saveSubCat = function () {

        let model = self.subCat();
        model = app.unko(model);

        if (model.Title == '') {
            alert("Please insert title"); return;
        }

        app.ajax('Train/saveSubCat', { submit: JSON.stringify(model) }).done(function (rs) {
            //$("#modalSubCat").modal('hide');
            self.subCatList(rs);
            self.subCat(new setSubCat())
        });
    }

    self.editSubCat = function (model) {
        self.subCat(model);
    }

    self.deleteSubCat = function (model) {
        app.ajax('Train/deleteSubCat', { rec_id: model.Rec_ID }).done(function (rs) {
            self.subCatList.remove(model);
        });
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            
            return;
        }
        $('#modalUpload').modal('hide');
        var model = self.item();
        model = app.unko(model);
        model.Audience = model.Audience.join(', ');

        app.ajax('Train/save', { submit: JSON.stringify(model) }).done(function (rs) {
            $('#modalUpload').modal('hide');
            app.showMsg('Successful', 'Update data successful!');
            if (model.Rec_ID == undefined || model.Rec_ID == '') {
                rs.Link = '/media/Training/' + rs.Source;
                itemArr.push(rs);
                self.listModel.push(rs);
            } else {
                let result = self.listModel().find(r=>r.Rec_ID == model.Rec_ID);
                self.listModel.remove(result);
                rs.Link =  '/media/Training/' + rs.Source;
                self.listModel.push(rs);

                itemArr.remove(result);
                itemArr.push(rs);
            }
            filter();
        })
    }

    self.delete = function (model) {
        app.showDelete(function () {
            app.ajax('Train/delete', { rec_id: model.Rec_ID, source: model.Source, thumbnail: model.Thumbnail }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                self.listModel.remove(model);
                itemArr.remove(model);
            });
        })
    }

    self.menuClick = function (root, event) {
        $('.btn-menu').removeClass('active btn-default');
        $('.btn-menu').each(function () {
            this == event.currentTarget ? $(this).addClass('active') : $(this).addClass('btn-default');
        });

        let tabName = $(event.currentTarget).text();
        self.tab(tabName);

        filter();
    };

    function filter() {
        let rs = itemArr.filter(r => r.Unit == self.tab());
        self.listModel(rs);
    }

    self.dateFormat = function (date) {
        return moment(date, "YYYYMMDD h:mm:ss").fromNow();
    }

    self.RenderIdentIcon = function (id, value) {
        jdenticon.updateSvg(id, value);
    }

    self.viewComment = function (model) {
        self.pv(null);
        self.titleComment(model.Title);
        self.view('comment');
        $.when(getComments(model.Rec_ID)).then(function (rs) {
            self.listComment().forEach(x => {
                self.RenderIdentIcon('#i' + x.Code_Place, x.Code_Place);
                x.Reply().forEach(r => {
                    self.RenderIdentIcon('#i' + r.Code_Place, r.Code_Place);
                });
            });
        });      
    }

    function getComments(rec_id) {
        return app.ajax('Train/getComments', { material_id:rec_id }).done(function (rs) {
            rs.map(x => {
                x.Reply.map(r=> {
                    r.IsNew = ko.observable(0);
                });
                x.Place = x.Code_Place.length == 10 ? 'VMW ' + self.getVLName(x.Code_Place) : 'HC ' + self.getHCName(x.Code_Place);
                x.Reply = ko.observableArray(x.Reply)
            });
            commentArr = rs
            self.listComment(commentArr);
        });
    }

    function filterComment(code, type) {
        let comments = [];

        if (type == 'pv') {
            comments = self.pv() == undefined ? commentArr : commentArr.filter(x=>x.Code_Prov_N == self.pv());
        } else if (type == 'od') {
            comments = self.od() == undefined ? commentArr.filter(x=>x.Code_Prov_N == self.pv()) : commentArr.filter(x=>x.Code_OD_T == self.od());
        } else if (type == 'hc') {
            comments = self.hc() == undefined ? commentArr.filter(x=>x.Code_OD_T == self.od()) : commentArr.filter(x=>x.Code_Facility_T == self.hc());
        }
        
        self.listComment(comments);

        self.listComment().forEach(x => {
            self.RenderIdentIcon('#i' + x.Code_Place, x.Code_Place);
            x.Reply().forEach(r => {
                self.RenderIdentIcon('#i' + r.Code_Place, r.Code_Place);
            });
        });
    }

    function filterUnreadCmt(code, type) {
        let comments = [];
        
        if (type == 'pv') {
            comments = self.pv() == undefined ? unreadCommentArr : unreadCommentArr.filter(x=>x.Code_Prov_N == self.pv());
        } else if (type == 'od') {
            comments = self.od() == undefined ? unreadCommentArr.filter(x=>x.Code_Prov_N == self.pv()) : unreadCommentArr.filter(x=>x.Code_OD_T == self.od());
        } else if (type == 'hc') {
            comments = self.hc() == undefined ? unreadCommentArr.filter(x=>x.Code_OD_T == self.od()) : unreadCommentArr.filter(x=>x.Code_Facility_T == self.hc());
        }
        
        self.unreadComments(comments);
    }

    self.reply = function ( model ) {
        model.Reply.push({
            Text: ko.observable(),
            Parent_ID: model.Rec_ID,
            Material_ID: model.Material_ID,
            Code_Place: app.user.username,
            InitTime: moment(),
            IsNew: ko.observable(1),
            Rec_ID: ko.observable('')
        })

        self.RenderIdentIcon('#i' + app.user.username, app.user.username);
    }

    self.saveReply = function (model) {
        
        if (model.Text() == undefined) {
            alert('Please input text');
            return;
        }
        var submit = app.unko(model);
        
        app.ajax('Train/saveReply', { submit: JSON.stringify(submit) }).done(function (rs) {
            model.IsNew(0);
            model.Rec_ID(rs);
        })
    }

    self.deleteComment = function (model) {
        app.showDelete(function () {
            app.ajax('Train/deleteComment', { rec_id: model.Rec_ID }).done(function (rs) {
                app.showMsg('Successful', 'Delete successful!');
                if (model.Parent_ID == null) {
                    self.listComment.remove(model);
                }
                else {
                    let comment = self.listComment().find(r => r.Rec_ID == model.Parent_ID);
                    comment.Reply.remove(model);
                }
            });
        })
    }

    self.cancelComment = function (model) {
        let comment = self.listComment().find(r => r.Rec_ID == model.Parent_ID);
        comment.Reply.remove(model);
    }

    self.getHCName = function (code) {
        var found = place.hc.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVLName = function (code) {
        var found = place.vl.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.isNum = function (n) {
        return !isNaN(n);
    }

    self.getSubCat = function (model) {
        let list = self.subCatList().find(r => r.Rec_ID == model)
        return list?.Title;
    }

    self.readMe = function () {
        $('#modalReadMe').modal('show');
    }

    self.viewUnreadCmt = function (model) {
        self.titleComment(model.Title);
        self.view('comment');
        $.when(getComments(model.Material_ID)).then(function () {
            self.listComment().forEach(x => {
                self.RenderIdentIcon('#i' + x.Code_Place, x.Code_Place);
                x.Reply().forEach(r => {
                    self.RenderIdentIcon('#i' + r.Code_Place, r.Code_Place);
                });
            });

            document.getElementById('s' + model.Rec_ID).scrollIntoView({
                behavior: 'smooth'
            });

            var element = document.getElementById('b' + model.Rec_ID);
            element.classList.add("highligh");

            updateStatus(model);
        });
    }

    function updateStatus(model) {
        app.ajax('Train/updateStatus', { comment_id: model.Rec_ID }).done(function (rs) {
            rs = self.unreadComments().find(r => r.Rec_ID == model.Rec_ID);
            self.unreadComments.destroy(rs);
            rs.IsRead = 1;
            self.unreadCmtCount(self.unreadComments().filter(r => r.IsRead == 0).length)
            self.unreadComments.push(rs);
        });
    }
}