<style>
	body { overflow-y: scroll; }
	text tspan { font-size: inherit; }
	.chartbox { margin-top: 30px; border: 1px solid black; }
	.table-bordered { border: 2px solid black; }
	
	.table-bordered > thead > tr > th,
	.table-bordered > tbody > tr > td,
	.table-bordered > tfoot > tr > th {
		border: 1px solid black; padding: 1px 5px 1px 5px;
	}
	
	.table-bordered > thead > tr > th { text-align: center; }
	.btn-success { position: absolute; right: 10px; }
	tbody td:nth-child(n+2) { text-align: right; }
	#t2 tbody tr:last-child,
	#t2 tbody td:last-child,
	#t3 tbody tr:last-child,
	#t3 tbody td:last-child,
	#t4 tbody tr:last-child,
	#t5 tbody tr:last-child,
	#t5 tbody td:nth-child(13n+14),
	#t6 tbody tr:last-child,
	#t6 tbody tr:last-child,
	#t6 tbody td:nth-child(13n+14) { font-weight: bold; }

    /*Graph*/
    .chart-container {
        position: relative;
        width: 100%;
        z-index: 1;
    }

    .chart-container .btn {
        position: absolute;
        top: 8%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        background-color: #555;
        color: white;
        font-size: 11.5px;
        padding: 3px 6px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        text-align: center;
    }

    .highcharts-axis-labels.highcharts-yaxis-labels text tspan {
        font-size: 14px;
        color: black;
        font-weight: 450;
        font-family: -apple-system,BlinkMacSystemFont,segoe ui,Roboto,Helvetica,Arial,sans-serif,apple color emoji,segoe ui emoji,segoe ui symbol;
    }

    .highcharts-axis-labels.highcharts-xaxis-labels text tspan {
        font-size: 14px;
        color: black;
        font-weight: 450;
        font-family: -apple-system,BlinkMacSystemFont,segoe ui,Roboto,Helvetica,Arial,sans-serif,apple color emoji,segoe ui emoji,segoe ui symbol;
    }

    .highcharts-axis.highcharts-yaxis text tspan {
        font-size: 14px;
        color: black;
        font-weight: 450;
        font-family: -apple-system,BlinkMacSystemFont,segoe ui,Roboto,Helvetica,Arial,sans-serif,apple color emoji,segoe ui emoji,segoe ui symbol;
    }

    text tspan.highcharts-text-outline {
        fill: #FFF;
        stroke: #FFF;
        stroke-width: 0;
        stroke-linejoin: round;
    }

    .highcharts-point.highcharts-color-0 {
        stroke-opacity: 1;
        fill-opacity: 0.8;
        stroke-width: 2;
        fill: #67b7dc;
        stroke: #67b7dc;
    }

    .highcharts-point.highcharts-color-1 {
        stroke-opacity: 1;
        fill-opacity: 0.8;
        stroke-width: 2;
        fill: #dc6967;
        stroke: #dc6967;
    }

    .highcharts-point.highcharts-color-2 {
        stroke-opacity: 1;
        fill-opacity: 0.8;
        stroke-width: 2;
        fill: rgb(247, 163, 92);
        stroke: rgb(247, 163, 92);
    }

    .stack text tspan {
        fill: #FFF;
    }

    .stack .highcharts-point.highcharts-color-0 {
        stroke-opacity: 0;
        fill: rgb(103, 183, 220);
        fill-opacity: 0.8;
        stroke: rgb(103, 183, 220);
        transform: translate(8.705, 36.2);
    }

    .stack .highcharts-point.highcharts-color-1 {
        stroke-opacity: 0;
        fill: #dc6967;
        fill-opacity: 0.8;
        stroke: #dc6967;
        transform: translate(8.705, 36.2);
    }

    .stack .highcharts-point.highcharts-color-2 {
        stroke-opacity: 0;
        fill: rgb(247, 163, 92);
        fill-opacity: 0.8;
        stroke: rgb(247, 163, 92);
        transform: translate(8.705, 36.2);
    }

    .highcharts-legend-item {
        pointer-events: none;
    }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix hidden-print">
		<div class="pull-left form-inline">
			<div class="input-group">
				<span class="input-group-addon">Year</span>
				<select class="form-control" data-bind="value: year, options: yearList"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">From</span>
				<select class="form-control" data-bind="value: from, options: monthList"></select>
				<span class="input-group-addon">To</span>
				<select class="form-control" data-bind="value: to, options: monthList"></select>
			</div>
			<button class="btn btn-primary width100" data-bind="click: submit">View</button>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>

	<div class="panel-body relative" data-bind="visible: loaded">
		<button class="btn btn-success hidden-print" data-bind="click: exportExcel">Export Excel</button>

		<div class="text-center">
			<span class="h4">Summary of Malaria situation</span>
			<span class="h4" data-bind="text: titleMonth">January - March,</span>
			<span class="h4" data-bind="text: dataYear">2018</span>
		</div>
		<h6 class="text-center">Whole Country Data</h6>

		<div class="text-bold" style="margin-top:20px">
			<span>Table 1: Malaria treated cases and deaths,</span>
			<span data-bind="text: dataMonthFrom() + ' - ' + dataMonthTo() + ','">Jan-Mar,</span>
			<span data-bind="text: (dataYear() - 1) + ' and ' + dataYear()">2017 and 2018</span>
		</div>
		<table class="table-bordered" id="t1">
			<thead>
				<tr>
					<th></th>
					<th colspan="5">Case, N (%)</th>
					<th colspan="2">Death, N</th>
					<th colspan="2">IR/1000</th>
					<th colspan="2">MR/100, 000</th>
					<th colspan="2">Pop</th>
				</tr>
				<tr>
					<th></th>
					<th data-bind="text: dataYear() - 1">2017</th>
					<th>%</th>
					<th data-bind="text: dataYear">2018</th>
					<th>%</th>
					<th>% Change</th>
					<th data-bind="text: dataYear() - 1">2017</th>
					<th data-bind="text: dataYear">2018</th>
					<th data-bind="text: dataYear() - 1">2017</th>
					<th data-bind="text: dataYear">2018</th>
					<th data-bind="text: dataYear() - 1">2017</th>
					<th data-bind="text: dataYear">2018</th>
					<th data-bind="text: dataYear() - 1">2017</th>
					<th data-bind="text: dataYear">2018</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: table1">
				<tr data-bind="foreach: $data">
					<td data-bind="text: $data"></td>
				</tr>
			</tbody>
		</table>

		<div class="text-bold" style="margin-top:30px">
			<span>Table 2: Malaria confirmed cases by species,</span>
			<span data-bind="text: dataMonthFrom() + ' - ' + dataMonthTo() + ','">Jan-Mar,</span>
			<span data-bind="text: (dataYear() - 1) + ' and ' + dataYear()">2017 and 2018</span>
		</div>
		<div style="display:inline-block">
			<div class="text-center text-bold" data-bind="text: dataMonthFrom() + ' - ' + dataMonthTo() + ', ' + (dataYear() - 1)">Jan - Mar, 2017</div>
			<table class="table-bordered" id="t2">
				<thead>
					<tr>
						<th></th>
						<th colspan="2">Pf</th>
						<th colspan="2">Pv</th>
						<th colspan="2">Mix</th>
						<th colspan="2">Pm</th>
						<th colspan="2">Po</th>
						<th colspan="2">Pk</th>
						<th></th>
					</tr>
					<tr>
						<th></th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: table2">
					<tr data-bind="foreach: $data">
						<td data-bind="text: $data"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="display:inline-block; margin-left:30px">
			<div class="text-center text-bold" data-bind="text: dataMonthFrom() + ' - ' + dataMonthTo() + ', ' + dataYear()">Jan - Mar, 2017</div>
			<table class="table-bordered" id="t3">
				<thead>
					<tr>
						<th></th>
						<th colspan="2">Pf</th>
						<th colspan="2">Pv</th>
						<th colspan="2">Mix</th>
						<th colspan="2">Pm</th>
						<th colspan="2">Po</th>
						<th colspan="2">Pk</th>
						<th></th>
					</tr>
					<tr>
						<th></th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Case</th>
						<th>%</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: table3">
					<tr data-bind="foreach: $data">
						<td data-bind="text: $data"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="text-bold" style="margin-top:30px">
			<span>Malaria treated cases by province (Public health facilities & VMWs) for</span>
			<span data-bind="text: dataMonthFrom() + ' - ' + dataMonthTo() + ','">Jan-Mar,</span>
			<span data-bind="text: dataYear">2018</span>
		</div>
		<table class="table table-bordered table-striped table-hover no-margin-bottom" id="t4">
			<thead>
				<tr>
					<th rowspan="2" valign="middle">Province</th>
					<!-- ko foreach: Array(12) -->
					<th colspan="2" data-bind="text: $root.monthList[$index()]"></th>
					<!-- /ko -->
					<th colspan="2">Total</th>
					<th rowspan="2" valign="middle">Population</th>
					<th rowspan="2" valign="middle">Inc/1000</th>
					<th rowspan="2" valign="middle">MR/100000</th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th>C</th>
					<th>D</th>
					<!-- /ko -->
					<th>Case</th>
					<th>Death</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: table4">
				<tr data-bind="foreach: $data, click: app.selectTr">
					<td data-bind="text: $data"></td>
				</tr>
			</tbody>
		</table>

        <div class="chart-container">
            <div id="chart1" class="chartbox"></div>
            <div class="btn">
                <label class="checkbox-inline checkbox-sm">
                    <input class="c1Cbox" id="year-0" type="checkbox" checked />
                    <span id="c-1-lg-0"></span>
                </label>
                <label class="checkbox-inline checkbox-sm">
                    <input class="c1Cbox" id="year-1" type="checkbox" checked />
                    <span id="c-1-lg-1"></span>
                </label>
            </div>
        </div>

        <div class="chart-container">
            <div id="chart2" class="chartbox"></div>
            <div class="btn">
                <label class="checkbox-inline checkbox-sm">
                    <input class="c2Cbox" id="inc-0" type="checkbox" checked />
                    <span id="c-2-lg-0"></span>
                </label>
                <label class="checkbox-inline checkbox-sm">
                    <input class="c2Cbox" id="inc-1" type="checkbox" checked />
                    <span id="c-2-lg-1"></span>
                </label>
                <label class="checkbox-inline checkbox-sm">
                    <input class="c2Cbox" id="mr" type="checkbox" checked />
                    <span id="c-2-lg-2"></span>
                </label>
            </div>
        </div>

        <div class="chart-container">
            <div id="chart3" class="chartbox"></div>
            <div class="btn">
                <label class="checkbox-inline checkbox-sm">
                    <input class="c3Cbox" id="cum-0" type="checkbox" checked />
                    <span id="c-3-lg-0"></span>
                </label>
                <label class="checkbox-inline checkbox-sm">
                    <input class="c3Cbox" id="cum-1" type="checkbox" checked />
                    <span id="c-3-lg-1"></span>
                </label>
            </div>
        </div>

        <div class="chart-container">
            <div id="chartWeeklyCurrentLastY" class="chartbox"></div>
        </div>

        <div class="text-bold" style="margin-top:30px">
            <span>PF + Mix Cases</span>
            <span data-bind="text: dataMonthFrom() + ' - ' + dataMonthTo() + ','">Jan-Mar,</span>
            <span data-bind="text: dataYear">2018</span>
        </div>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Province</th>
                    <th rowspan="2">OD</th>
                    <th rowspan="2">HC</th>
                    <th rowspan="2">Commune</th>
                    <th rowspan="2">Village</th>
                    <!-- ko foreach: Array(12) -->
                    <th colspan="5" data-bind="text: $root.monthList[$index()], visible: $root.visibleMonth($index())"></th>
                    <!-- /ko -->
                </tr>
                <tr>
                    <!-- ko foreach: Array(12) -->
                    <th data-bind="visible: $root.visibleMonth($index())">Pf</th>
                    <th data-bind="visible: $root.visibleMonth($index())">Mix</th>
					<th data-bind="visible: $root.visibleMonth($index())">L1</th>
					<th data-bind="visible: $root.visibleMonth($index())">LC</th>
                    <th data-bind="visible: $root.visibleMonth($index())">IMP</th>
                    <!-- /ko -->
                </tr>
            </thead>
            <tbody data-bind="foreach: reportPfMix">
                <tr>
					<td align="center" data-bind="text: $index() + 1"></td>
                    <td style="text-align:left" data-bind="text: Name_Prov_E"></td>
					<td style="text-align:left" data-bind="text: Name_OD_E"></td>
					<td style="text-align:left" data-bind="text: Name_Facility_E"></td>
					<td style="text-align:left" data-bind="text: Name_Comm_E"></td>
					<td style="text-align:left" data-bind="text: Name_Vill_E"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: $parent['Pf'+($index()+1)], visible: $root.visibleMonth($index())"></td>
					<td data-bind="text: $parent['Mix'+($index()+1)], visible: $root.visibleMonth($index())"></td>
					<td data-bind="text: $parent['L1_'+($index()+1)], visible: $root.visibleMonth($index())"></td>
					<td data-bind="text: $parent['LC'+($index()+1)], visible: $root.visibleMonth($index())"></td>
					<td data-bind="text: $parent['IMP'+($index()+1)], visible: $root.visibleMonth($index())"></td>
					<!-- /ko -->
                </tr>
            </tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="6">Grand Total</th>
					<!-- ko foreach: Array(12) -->
					<th align="right" data-bind="text: $root.reportPfMix().sum('Pf'+($index()+1)), visible: $root.visibleMonth($index())"></th>
					<th align="right" data-bind="text: $root.reportPfMix().sum('Mix'+($index()+1)), visible: $root.visibleMonth($index())"></th>
					<th align="right" data-bind="text: $root.reportPfMix().sum('L1_'+($index()+1)), visible: $root.visibleMonth($index())"></th>
					<th align="right" data-bind="text: $root.reportPfMix().sum('LC'+($index()+1)), visible: $root.visibleMonth($index())"></th>
					<th align="right" data-bind="text: $root.reportPfMix().sum('IMP'+($index()+1)), visible: $root.visibleMonth($index())"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
        </table>

		<div class="chart-container">
			<div id="chartWeekly" class="chartbox"></div>
		</div>

		<div class="text-bold" style="margin-top:30px">
			<span>Data completeness of public health facilities,</span>
			<span data-bind="text: dataMonthFrom() + ' - ' + dataMonthTo() + ','">Jan-Mar,</span>
			<span data-bind="text: (dataYear() - 1) + ' and ' + dataYear()">2017 and 2018</span>
		</div>
		<table class="table table-bordered table-striped table-hover no-margin-bottom" id="t5">
			<thead>
				<tr>
					<th rowspan="2" valign="middle">Province</th>
					<th colspan="13" data-bind="text: dataYear() - 1"></th>
					<th colspan="13" data-bind="text: dataYear"></th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th data-bind="text: $root.monthList[$index()]"></th>
					<!-- /ko -->
					<th>Total</th>
					<!-- ko foreach: Array(12) -->
					<th data-bind="text: $root.monthList[$index()]"></th>
					<!-- /ko -->
					<th>Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: table5">
				<tr data-bind="foreach: $data, click: app.selectTr">
					<td data-bind="text: $data"></td>
				</tr>
			</tbody>
		</table>

		<div class="text-bold" style="margin-top:30px">
			<span>Data completeness of VMWs,</span>
			<span data-bind="text: dataMonthFrom() + ' - ' + dataMonthTo() + ','">Jan-Mar,</span>
			<span data-bind="text: (dataYear() - 1) + ' and ' + dataYear()">2017 and 2018</span>
		</div>
		<table class="table table-bordered table-striped table-hover no-margin-bottom" id="t6">
			<thead>
				<tr>
					<th rowspan="2" valign="middle">Province</th>
					<th colspan="13" data-bind="text: dataYear() - 1"></th>
					<th colspan="13" data-bind="text: dataYear"></th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th data-bind="text: $root.monthList[$index()]"></th>
					<!-- /ko -->
					<th>Total</th>
					<!-- ko foreach: Array(12) -->
					<th data-bind="text: $root.monthList[$index()]"></th>
					<!-- /ko -->
					<th>Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: table6">
				<tr data-bind="foreach: $data, click: app.selectTr">
					<td data-bind="text: $data"></td>
				</tr>
			</tbody>
		</table>

	</div>
</div>

<?=latestJs('/media/ViewModel/ReportDirector.js')?>