function viewModel() {
    var self = this;
    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.vlList = ko.observableArray();
    self.dataList = [];

    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.vl = ko.observable();
    self.tab = ko.observable();
    self.view = ko.observable();

    self.place = null;
    var pvData = [];

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        self.place = p;
        if (app.user.prov != '') self.place.pv = self.place.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') self.place.od = self.place.od.filter(r => r.code == app.user.od);

        var arr = self.place.od.map(r => r.pvcode).distinct();
        self.place.pv = self.place.pv.filter(r => arr.contain(r.code));
        self.pvList(self.place.pv);

        self.viewChart();
    });

    self.viewChart = () => {
        let submit = {
            pv: self.pv(),
            od: self.od(),
            hc: self.hc()
        }

        app.ajax('/Quiz/getDashboardData', submit).done(function (rs) {
            self.dataList = rs

            drawVMW()
            drawHC()
        })
    }

    function getTitle() {
        if (self.pv() == undefined) return ''
        if (self.pv() != undefined && self.od() == undefined) return ' in ' + self.getProvName(self.pv()) + ' Province'
        if (self.pv() != undefined && self.od() != undefined && self.hc() == undefined) return ' in ' + self.getProvName(self.pv()) + ' Province - OD ' + self.getODName(self.od())
        if (self.pv() != undefined && self.od() != undefined && self.hc() != undefined) return ' in ' + self.getProvName(self.pv()) + ' Province - OD ' + self.getODName(self.od()) + ' - HC ' + self.getHCName(self.hc())
    }
    /*
     * Donut chart
     * */
    function drawVMW() {
        var model = self.dataList.vmw
        
        Highcharts.chart('vmw', {
            title: { text: 'VMW Result ' + getTitle(), },
            chart: {
                type: 'pie', 
                custom: {},
                events: {
                    render() {
                        const chart = this,
                            series = chart.series[0];
                        let customLabel = chart.options.chart.custom.label;

                        if (!customLabel) {
                            customLabel = chart.options.chart.custom.label =
                                chart.renderer.label(
                                    '# Examination<br/>' +
                                    '<strong>' + model.Total + '</strong>'
                                )
                                    .css({
                                        color: '#000',
                                        textAnchor: 'middle'
                                    })
                                    .add();
                        }

                        const x = series.center[0] + chart.plotLeft,
                            y = series.center[1] + chart.plotTop -
                                (customLabel.attr('height') / 2);

                        customLabel.attr({
                            x,
                            y
                        });
                        // Set font size based on chart diameter
                        customLabel.css({
                            fontSize: `${series.center[2] / 12}px`
                        });
                    }
                }
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
            },
            legend: {
                enabled: true
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    borderRadius: 8,
                    dataLabels: [{
                        enabled: true,
                        //distance: 20,
                        format: '{point.name}'
                    }, {
                        enabled: true,
                        //distance: -15,
                        format: '{point.percentage:.0f}%',
                        style: {
                            fontSize: '0.9em'
                        }
                    }],
                    showInLegend: true
                }
            },
            series: [
                {
                    name: 'Exam',
                    colorByPoint: true,
                    innerSize: '75%',
                    data: [
                        {
                            name: 'Pass',
                            y: model?.Pass/ model?.Total *100
                        },
                        {
                            name: 'Failed',
                            y: model?.Failed / model?.Total * 100
                        }
                    ]
                }
            ]
        });
    }

    function drawHC() {
        var model = self.dataList.hc
        Highcharts.chart('hc', {
            title: { text: 'HC Result ' + getTitle(), },
            chart: {
                type: 'pie',
                custom: {},
                events: {
                    render() {
                        const chart = this,
                            series = chart.series[0];
                        let customLabel = chart.options.chart.custom.label;

                        if (!customLabel) {
                            customLabel = chart.options.chart.custom.label =
                                chart.renderer.label(
                                    '# Examination<br/>' +
                                    '<strong>' + model.Total + '</strong>'
                                )
                                    .css({
                                        color: '#000',
                                        textAnchor: 'middle'
                                    })
                                    .add();
                        }

                        const x = series.center[0] + chart.plotLeft,
                            y = series.center[1] + chart.plotTop -
                                (customLabel.attr('height') / 2);

                        customLabel.attr({
                            x,
                            y
                        });
                        // Set font size based on chart diameter
                        customLabel.css({
                            fontSize: `${series.center[2] / 12}px`
                        });
                    }
                }
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
            },
            legend: {
                enabled: true
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    borderRadius: 8,
                    dataLabels: [{
                        enabled: true,
                        //distance: 20,
                        format: '{point.name}'
                    }, {
                        enabled: true,
                        //distance: -15,
                        format: '{point.percentage:.0f}%',
                        style: {
                            fontSize: '0.9em'
                        }
                    }],
                    showInLegend: true
                }
            },
            series: [
                {
                    name: 'Exam',
                    colorByPoint: true,
                    innerSize: '75%',
                    data: [
                        {
                            name: 'Pass',
                            y: model?.Pass / model?.Total * 100
                        },
                        {
                            name: 'Failed',
                            y: model?.Failed / model?.Total * 100
                        }
                    ]
                }
            ]
        });
    }

    self.pv.subscribe(function (code) {
        self.odList(code == null ? [] : self.place.od.filter(r => r.pvcode == code));
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : self.place.hc.filter(r => r.odcode == code));
    });

    self.hc.subscribe(function (code) {
        self.vlList(code == null ? [] : self.place.vl.filter(r => r.hccode == code));
    });

    self.getProvName = function (code) {
        var found = self.place.pv.find(r => r.code == code);
        return found == null ? code : found.name;
    };

    self.getODName = function (code) {
        var found = self.place.od.find(r => r.code == code);
        return found == null ? code : found.name;
    };

    self.getHCName = function (code) {
        var found = self.place.hc.find(r => r.code == code);
        return found == null ? code : found.name;
    };

    self.getVLName = function (code) {
        var found = self.place.vl.find(r => r.code == code);
        return found == null ? code : found.name;
    };
}