app.user = $('#SessionUser').val() == null ? null : JSON.parse($('#SessionUser').val());
app.placeUpdate = JSON.parse($('#PlaceUpdate').val());
app.isMobile = $('#IsMobile').val() == 1;

window.onpopstate = function () {
	history.forward();
};
history.pushState(null, null);

$('.modal').modal({
	backdrop: 'static',
	keyboard: false,
	show: false
});


var indexOfCurrentPage = function (page) {
    return page.parentPage.children.indexOf(page);
};

var pageStep = function (page, step) {
    return ko.computed(function () {
        var rawStep = ko.utils.unwrapObservable(step);
        return page.parentPage.children()[(Math.abs(indexOfCurrentPage(page))) + rawStep] || page.nullObject;
    });
};


var NextPage = function (element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
    this.element = element;
    this.bindingContext = bindingContext;
    this.path = ko.observable();
    var parent = pager.getParentPage(bindingContext);
    this.siblingPage = pageStep(parent, valueAccessor());
    this.path = ko.computed(function () {
        var value = this.siblingPage();
        return value.getFullRoute()().join('/');
    }, this);
};

NextPage.prototype.bind = function () {
    var text = $(this.element).text();

    ko.computed(function () {
        var page = this.siblingPage();
        if (text.length === 0) {
            var newText = page.val('title');
            ko.applyBindingsToNode(this.element, {
                text: newText
            });
        } else if (text.indexOf('{0}')) {
            var replacedText = text.replace('{0}', page.val('title'));
            ko.applyBindingsToNode(this.element, {
                text: replacedText
            });
        }
    }, this);

    var hash = ko.computed(function () {
        return pager.Href.hash + this.path();
    }, this);

    ko.applyBindingsToNode(this.element, {
        attr: {
            'href': hash
        }
    });
};

ko.bindingHandlers['page-step'] = {
    init: function (element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
        var nextPage = new NextPage(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext);
        nextPage.bind();
    }
};


app.vm = typeof viewModel === 'function' ? new viewModel() : {};

pager.Href.hash = '#!/';
pager.extendWithPage(app.vm);

ko.applyBindings(app.vm);

pager.start();