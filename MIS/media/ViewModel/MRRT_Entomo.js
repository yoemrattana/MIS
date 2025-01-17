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
    self.mosquitosByHour = ko.observableArray();
    self.mainVector = ko.observableArray();
    self.detailModel = ko.observable();
    self.view = ko.observable('list');

    self.pvList = ko.observableArray();
    self.odList = ko.observableArray();
    self.dsList = ko.observableArray();
    self.hcList = ko.observableArray();
    self.pv = ko.observable();
    self.od = ko.observable();
    self.hc = ko.observable();
    self.ds = ko.observable();
    self.cm = ko.observable();
    self.vl = ko.observable();
    self.inputPlaceModel = ko.observable();
    self.yearList = [];
    self.year = ko.observable(moment().year());
    self.menu = ko.observable();
    self.mosquito = ko.observable();
    self.vector = ko.observable();
    self.isReady = ko.observable(false);
    var place = null;
    var forestStatus = { show: false, unzip: false };
    var forestMap = []

    self.mosquitoList = [
        'An. aconitus',
        'An. annularis',
        'An. argyropus',
        'An. baimaii',
        'An. barbirostris',
        'An. barbirostris (a, b, and c)',
        'An. campestris',
        'An. crawfordi',
        'An. dirus s.l.',
        'An. hyrcanus grp',
        'An. indefinitus',
        'An. interruptus',
        'An. jamesii',
        'An. karwari',
        'An. kochi',
        'An. maculatus s.l.',
        'An. minimus s.l.',
        'An. nigerrimus',
        'An. nitidus',
        'An. nivipes',
        'An. notanandai',
        'An. pampanai',
        'An. peditaeniatus',
        'An. philippinensis',
        'An. pseudojamesi',
        'An. pursati',
        'An. sawadwongporni s.l.',
        'An. sinensis',
        'An. splendidus',
        'An. subpictus',
        'An. tessellatus',
        'An. umbrosis',
        'An. vagus',
        'An. varuna',
        'An. willmori',

        'An. Cellia',
        'Aubgenus Cellia',
        'Anularis Group',
        'Barbirostris Group',
        'Funestus Group',
        'Hyrcanus Group',
        'Jamesii Group',
        'Leucosphyrus Group',
        'Maculatus Group',
        'Sawadwongporni Subgroup',
        'Subgenus Anopheles',
        'Subgenus Cellia'
    ];

    window.sleep = function (millisecond) {
        return new Promise(r => setTimeout(r, millisecond));
    };

    for (var i = 2024; i <= moment().year(); i++) {
        self.yearList.push(i);
    }

    app.getPlace(['pv', 'od', 'hc', 'vl', 'ds', 'cm'], function (p) {
        place = p;
        if (app.user.prov != '') place.pv = place.pv.filter(r => app.user.prov.contain(r.code));
        if (app.user.od != '') place.od = place.od.filter(r => r.code == app.user.od);

        var arr = place.od.map(r => r.pvcode).distinct();
        place.pv = place.pv.filter(r => arr.contain(r.code));
        self.pvList(place.pv);
        getData()

        //load map data in zip file
        app.readFileInZip($('#chartODBorder').val(), 'chartODBorder.js', function (script) {
            eval(script); //run script

            app.readFileInZip($('#googleODBorder').val(), 'googleODBorder.js', function (script) {
                eval(script);

                app.readFileInZip($('#chartNeighbourBorder').val(), function (arr) {
                    arr.forEach(r => {
                        try {
                            eval(r.value);
                        } catch (err) {
                            console.log(err);
                        }
                    });

                }, undefined, false);
            }, false);
        }, false);
    },false);

    function getData() {
        app.ajax('/MRRT_Entomo/getData').done(function (rs) {
            self.listModel(rs);
        });
    }

    self.getMosquitosByHour = () => {
        app.ajax('/MRRT_Entomo/getDashboardData').done(function (rs) {
            self.mosquitosByHour(rs['mosquitosByHuor']);
            self.mainVector(rs['mainVector']);
            self.vector(rs['vector']);
        });
    }

    function drawMosquitoByHour() {
        var model = self.mosquitosByHour().filter(r => r.Name == self.mosquito().Name)[0];

        $('#mosquito-by-hour').highcharts({
            chart: { type: 'spline' },
            title: { text: 'Mosquito by Hour'},
            subtitle: { text: '.' },
            xAxis: { categories: ['H 6-7', 'H 7-8', 'H 8-9', 'H 9-10', 'H 10-11', 'H 11-12'], crosshair: true, gridLineWidth: 1 },
            yAxis: [{ title: { text: 'Number of Mosquito(s)' }, },],
            tooltip: { shared: true, },
            exporting: { sourceWidth: 1200, sourceHeight: 400 },
            series: [
                { name: model?.Name, data: [model?.H6_7, model?.H7_8, model?.H8_9, model?.H9_10, model?.H10_11, model?.H11_12] },
            ]
        });
    }

    function drawVectorMap() {
        var data = self.vector().map(x => {
            return [x.Code_OD_T, x.Dirus, x.Minimus, x.Maculatus, x.OtherAnophele, x.Total,-1]
        })

        const maxValue = data.reduce((max, row) => Math.max(max, row[4]), 0);

        var chart = Highcharts.mapChart('map-vector', {
            title: { text: 'Main Vector' },
            chart: { zoomType: false },
            tooltip: { enabled: false },
            mapNavigation: {
                enabled: true
            },
            plotOptions: {
                series: {
                    enableMouseTracking: false
                },
                pie: {
                    borderColor: 'rgba(255,255,255,0.4)',
                    borderWidth: 1,
                    clip: true,
                    dataLabels: {
                        enabled: true
                    },
                    states: {
                        hover: {
                            halo: {
                                size: 1
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: ''
                    },
                }
            },
            legend: { enabled: false },
            series: (function () {
                var series = []
                series.push({
                    mapData: forestMap, 
                    data: data,
                    borderColor: "#000000",
                    borderWidth: 0,
                    nullColor: "#008000",
                    name: '',
                    joinBy: ['odcode', 'id'],
                    keys: [
                        'id', 'Dirus', 'Minimus', 'Maculatus', 'OtherAnophele', 'Total', 'value',  'pieOffset'
                    ],
                })

                return series
            }())
        });

        chart.series[0].points.forEach(state => {
            if (state.id.contain("highcharts-")) return;
            chart.addSeries({
                type: 'pie',
                zoomType: false,
                name: state.id,
                zIndex: 66,
                minSize: 1,
                maxSize: 2,
                onPoint: {
                    id: state.id,
                    minSize: 50,
                    maxSize: 50,
                    z: (() => {
                        return (Math.floor(Math.random() * 4) + 1) * 10;
                    })()
                },
                legend: { enabled: false },
                tooltip: {
                    pointFormatter() {
                        return state.series.tooltipOptions.pointFormatter.call({
                            id: state.id,
                            hoverVotes: this.name,
                            Dirus: state.Dirus,
                            Minimus: state.Minimus,
                            Maculatus: state.Maculatus,
                            OtherAnophele: state.OtherAnophele,
                            Total: state.Total
                        });
                    }
                },
                states: {
                    inactive: {
                        enabled: false
                    }
                },
                accessibility: {
                    enabled: false
                },
                data: [{
                    name: 'Dirus',
                    y: state.Dirus,
                }, {
                    name: 'Minimus',
                    y: state.Minimus,
                    },
                    {
                        name: 'Maculatus',
                        y: state.Maculatus,
                    },
                    {
                        name: 'OtherAnophele',
                        y: state.OtherAnophele,
                    }
                ]
               
            }, false);
        });

        chart.redraw();
    }

    function drawMainVectorMap() {
        var data = self.mainVector().filter(r => r.Lat > 0 && r.Long > 0).map(o => {
            return {
                name: o.Year,
                lat: parseFloat(o.Lat),
                lon: parseFloat(o.Long),
                z: parseFloat(o.Total)
            }
        });

        $('#map-main-vector').highcharts('Map', {
            title: { text: 'INVESTIGATED FOCI LOCATION' },
            tooltip: { enabled: false },
            plotOptions: {
                series: {
                    enableMouseTracking: false,
                    borderColor: '#ccc'
                }
            },
            chart: { zoomType: false },
            legend: {
                title: { text: 'year' },
                layout: 'vertical', align: 'right',
                itemMarginTop: 5
            },
            series: (function () {
                var series = []

                series.push({
                    mapData: forestMap,
                    borderColor: "#c70606",
                    borderWidth: 0,
                    nullColor: "#008000",
                    showInLegend: false,
                    dataLabels: { enabled: true, format: '{point.name}', style: { color: 'black', textOutline: '' } }
                })

                var years = _.uniq(_.map(data, 'name'))

                years.forEach(year => {
                    series.push(
                        {
                            name: year,
                            id: year,
                            type: 'mapbubble',
                            data: data.filter(r => r.name == year),
                            color: '#dbbc34',
                            marker: { fillOpacity: 1 },
                            minSize: 8,
                            maxSize: 8,
                        }
                    )
                })
                return series
            }())
        });
    }

    self.mosquito.subscribe(function () {
        drawMosquitoByHour()
    })

    self.getListModel = function () {
        var list = self.listModel();

        if (self.pv() != null) list = list.filter(r => r.Code_Prov_T == self.pv());
        if (self.ds() != null) list = list.filter(r => r.Code_Dist_T == self.ds());
        if (self.cm() != null) list = list.filter(r => r.Code_Comm_T == self.cm());
        if (self.vl() != null) list = list.filter(r => r.Code_Vill_T == self.vl());

        return list;
    };

    self.showNew = function () {
        self.detailModel(new setQuestion())
        self.view('edit')

        setTimeout(() => {
            $('input[numonly]').each(function () {
                app.setNumberOnly(this, $(this).attr('numonly'));
            });
        }, 300)
    };

    self.showEdit = function (model) {
        let submit = {
            Rec_ID: model.Rec_ID,
        }
        app.ajax('/MRRT_Entomo/getDetail', submit).done(function (rs) {
            let commodity = rs.Commodity;
            commodity = isnullempty(commodity) ? [] : Array.isArray(commodity) ? commodity : commodity.split(', ');
            rs.Commodity = commodity;

            model = app.ko(rs);
            model.pvList = ko.observable(place.pv);
            model.dsList = ko.pureComputed(() => {
                return place.ds.filter(r => r.pvcode == model.Code_Prov_T())
            }),
            model.cmList= ko.pureComputed(() => {
                return place.cm.filter(r => r.dscode == model.Code_Dist_T())
            });
            model.vlList= ko.pureComputed(() => {
                return place.vl.filter(r => r.cmcode == model.Code_Comm_T())
            });
            model.odList= ko.pureComputed(() => {
                return place.od.filter(r => r.pvcode == model.Code_Prov_T())
            });
            model.hcList= ko.pureComputed(() => {
                return place.hc.filter(r => r.odcode == model.Code_OD_T())
            });

            self.detailModel(model);
            self.view('edit');
        });

        setTimeout(() => {
            $('input[numonly]').each(function () {
                app.setNumberOnly(this, $(this).attr('numonly'));
            });
        }, 300)
    }
    
    function setQuestion() {
        let item = {
            Code_Prov_T: ko.observable().extend({
                required: true,
            }),
            Code_Dist_T: ko.observable().extend({
                required: true,
            }),
            Code_Comm_T: ko.observable().extend({
                required: true,
            }),
            Code_Vill_T: ko.observable().extend({
                required: true,
            }),
            Code_Facility_T: ko.observable().extend({
                required: true,
            }),
            Code_OD_T: ko.observable().extend({
                required: true,
            }),

            pvList: ko.observable(place.pv),
            dsList: ko.pureComputed(() => {
                return place.ds.filter(r => r.pvcode == item.Code_Prov_T())
            }),
            cmList: ko.pureComputed(() => {
                return place.cm.filter(r => r.dscode == item.Code_Dist_T())
            }),
            vlList: ko.pureComputed(() => {
                return place.vl.filter(r => r.cmcode == item.Code_Comm_T())
            }),
            odList: ko.pureComputed(() => {
                return place.od.filter(r => r.pvcode == item.Code_Prov_T())
            }),
            hcList: ko.pureComputed(() => {
                return place.hc.filter(r=> r.odcode == item.Code_OD_T())
            }),

            Rec_ID: ko.observable(0),
            CollectionDate: ko.observable().extend({
                required: true,
            }),

            CollectionDateTo: ko.observable().extend({ required: true }),
            
            OD_Captain: ko.observable().extend({
                required: true,
            }),
            Lat: ko.observable().extend({
                required: true,
            }),
            Long: ko.observable().extend({
                required: true,
            }),
            MosquitoCatcher1: ko.observable().extend({
                required: true,
            }),
            MosquitoCatcher2: ko.observable(),
            MosquitoCatcher3: ko.observable(),
            Commodity: ko.observableArray(),

            //
            ToalMosquito6_7: ko.observable(),
            ToalMosquito7_8: ko.observable(),
            ToalMosquito8_9: ko.observable(),
            ToalMosquito9_10: ko.observable(),
            ToalMosquito10_11: ko.observable(),
            ToalMosquito11_12: ko.observable(),
            TotalMosquito: ko.observable(),

            Anopheles6_7: ko.observable(),
            Anopheles7_8: ko.observable(),
            Anopheles8_9: ko.observable(),
            Anopheles9_10: ko.observable(),
            Anopheles10_11: ko.observable(),
            Anopheles11_12: ko.observable(),
            Anopheles: ko.observable(),

            NotAnopheles6_7: ko.observable(),
            NotAnopheles7_8: ko.observable(),
            NotAnopheles8_9: ko.observable(),
            NotAnopheles9_10: ko.observable(),
            NotAnopheles10_11: ko.observable(),
            NotAnopheles11_12: ko.observable(),
            NotAnopheles: ko.observable(),

            //
            ReceivedDate: ko.observable(),
            AnalysisDate: ko.observable(),
            SentDate: ko.observable(),

            //
            Leader: ko.observable().extend({
                required: true,
            }),
            LeaderDate: ko.observable().extend({
                required: true,
            }),
            Analyst: ko.observable().extend({
                required: true,
            }),
            AnalystDate: ko.observable().extend({
                required: true,
            }),
            EntomoCNM: ko.observable(),
            EntomoCNMDate: ko.observable(),

            Mosquitoes: ko.observableArray([]),
            Note: ko.observable(),
        }

        return item;
    }

    function setMosqito(type) {
        let item = {
            Name: ko.observable().extend({ required: true, }),
            H6_7: ko.observable().extend({ required: true, }),
            H7_8: ko.observable().extend({ required: true, }),
            H8_9: ko.observable().extend({ required: true, }),
            H9_10: ko.observable().extend({ required: true, }),
            H10_11: ko.observable().extend({ required: true, }),
            H11_12: ko.observable().extend({ required: true, }),
            Total: ko.observable().extend({ required: true, }),
            Type: ko.observable(type),
        }
        return item;
    }

    self.addPrimaryVector = function () {
        self.detailModel().Mosquitoes.push(new setMosqito('Primary'));
        $('input[numonly]').each(function () {
            app.setNumberOnly(this, $(this).attr('numonly'));
        });
    }

    self.addSecondaryVector = function () {
        self.detailModel().Mosquitoes.push(new setMosqito('Secondary'));
        $('input[numonly]').each(function () {
            app.setNumberOnly(this, $(this).attr('numonly'));
        });
    }

    self.removeMosquito = function (model) {
        self.detailModel().Mosquitoes.remove(model)
    }

    self.save = function () {
        if (self.errors().length != 0) {
            self.errors.showAllMessages();
            app.showMsg('ដំណឹង', 'សូមបញ្ចូលពត័មានឲ្យបានគ្រប់!');
            return;
        }

        let model = self.detailModel()
        model = app.unko(model);
        model.Commodity = model.Commodity.join(', ');
        model.ReceivedDate = model.ReceivedDate == '' || model.ReceivedDate == null ? null : model.ReceivedDate
        model.AnalysisDate = model.AnalysisDate == '' || model.AnalysisDate == null ? null : model.AnalysisDate
        model.SentDate = model.SentDate == '' || model.SentDate == null ? null : model.SentDate
        model.EntomoCNMDate = model.EntomoCNMDate == '' || model.EntomoCNMDate == null ? null : model.EntomoCNMDate
        model.AnalystDate = model.AnalystDate == '' || model.AnalystDate == null ? null : model.AnalystDate

        model.Note = model.Note

        let mosquitoes = model.Mosquitoes;

        delete model.Mosquitoes;
        delete model.Code_Comm_T;
        delete model.Code_Prov_T;
        delete model.Code_OD_T;
        delete model.Code_Dist_T;
        delete model.pvList;
        delete model.dsList;
        delete model.cmList;
        delete model.vlList;
        delete model.odList;
        delete model.hcList;

        let submit = {
            Question: model,
            Mosquitoes: JSON.stringify(mosquitoes)
        }

        app.ajax('/MRRT_Entomo/save', submit).done(function (rs) {
            if (model.Rec_ID == 0) {
                self.listModel.push(rs);
            }
            self.view('list')
        });
    }

    self.showDelete = function (model) {
        app.showDelete(function () {
            var submit = {
                table: 'tblMRRT_Entomo',
                where: { Rec_ID: model.Rec_ID }
            };
            submit = { submit: JSON.stringify(submit) };

            app.ajax('/Direct/delete', submit).done(function () {
                let r = self.listModel().find(r => r.Rec_ID == model.Rec_ID)
                self.listModel.remove(r);
                self.view('list');
            });
        });
    }

    async function downloadForest() {
        var fileInfo = JSON.parse(forestFile.value);

        var rs = await caches.match(fileInfo[0]);
        if (rs != null) {
            forestMap = await rs.json();
            return
        }

        var response = await fetch(fileInfo[0]);
        //var blob = await progress();
        var blob = await response.blob();

        var zip = await new JSZip().loadAsync(blob);
        var arr = [];
        for (var name in zip.files) {
            var json = await zip.file(name).async('text');
            arr = arr.concat(JSON.parse(json));
        }
        forestMap = arr;

        var json = JSON.stringify(forestMap);
        var response = new Response(json, {
            headers: { 'content-length': json.length }
        });
        caches.open('v1').then(c => c.put(fileInfo[0], response));

        //async function progress() {
        //    var total = fileInfo[1];
        //    var loaded = 0;
        //    var lastLoaded = 0;
        //    var lastSecond = 0;
        //    var reader = response.clone().body.getReader();
        //    var values = [];

        //    while (true) {
        //        const { done, value } = await reader.read();
        //        if (done) break;
        //        values.push(value);
        //        loaded += value.byteLength;

        //        if (Date.now() >= lastSecond + 500) {
        //            var rate = calculateFileSize((loaded - lastLoaded) * 2);
        //            var speed = `Speed: ${rate}/s`;
        //            lastLoaded = loaded;
        //            lastSecond = Date.now();

        //            $('#modalDownload .modal-body div:first').text(speed);
        //        }

        //        var loadedText = calculateFileSize(loaded);
        //        var totalText = calculateFileSize(total);
        //        var percent = (Math.floor(loaded * 10000 / total) / 100).toFixed(1);
        //        var download = `Downloaded: ${loadedText} / ${totalText} (${percent}%)`;

        //        $('#modalDownload .modal-body div:last').text(download);
        //    }

        //    return new Blob(values, { type: response.headers.get('content-type') });
        //}

        //function calculateFileSize(size) {
        //    var unit = ['B', 'KB', 'MB', 'GB'];
        //    for (var i = 0; i < unit.length; i++) {
        //        if (size < 1000 || i == unit.length - 1) {
        //            return (Math.floor(size * 10) / 10).toFixed(1) + ' ' + unit[i];
        //        }
        //        size /= 1024;
        //    }
        //}
    }

    self.pv.subscribe(function (code) {
        self.odList(code == null ? [] : place.od.filter(r => r.pvcode == code));
    });

    self.od.subscribe(function (code) {
        self.hcList(code == null ? [] : place.hc.filter(r => r.odcode == code));
    });

    self.getODName = function (code) {
        var found = place.od.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getPVName = function (code) {
        return code == null ? '' : place.pv.find(r => r.code == code)?.name;
    };

    self.getDSName = function (code) {
        return code == null ? '' : place.ds.find(r => r.code == code).name;
    };

    self.getCMName = function (code) {
        return code == null ? '' : place.cm.find(r => r.code == code).name;
    };

    self.getVLName = function (code) {
        return code == null ? '' : place.vl.find(r => r.code == code).name;
    };

    self.dsList = function () {
        return self.pv() == null ? [] : place.ds.filter(r => r.pvcode == self.pv());
    };

    self.cmList = function () {
        return self.ds() == null ? [] : place.cm.filter(r => r.dscode == self.ds());
    };

    self.vlList = function () {
        return self.cm() == null ? [] : place.vl.filter(r => r.cmcode == self.cm());
    };

    self.getHCName = function (code) {
        var found = place.hc.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVLName = function (code) {
        var found = place.vl.find(r => r.code == code);
        return found == null ? code : found.nameK;
    };

    self.getVill = function (code) {
        if (code == null || code === '') return '';
        if (code == '999') return 'Unknown';
        var found = code.length == 10 ? place.vl.find(r => r.code == code)
            : code.length == 6 ? place.cm.find(r => r.code == code)
                : code.length == 4 ? place.ds.find(r => r.code == code)
                    : code.length == 2 ? place.pv.find(r => r.code == code)
                        : null;

        return found == null ? code : found.nameK;
    };

    self.back = function () {
        self.view('list');
    }

    self.dateFormat = function (date) {
        return moment(date).format('DD-MM-YYYY');
    }

    self.menuClick = function (vm, event) {
        self.menu(event.currentTarget.innerHTML);
       
        if (self.menu() == 'Dashboard') {
            $.when(self.getMosquitosByHour(), downloadForest()).done(function () {
                drawMosquitoByHour()

                $.when(drawMainVectorMap()).done(function () {
                    drawVectorMap()
                })

                self.isReady(true)
            })            
        }
            
    };

    self.menuCss = function (element) {
        return element.innerHTML == self.menu() ? 'btn-info' : 'btn-default';
    };
}