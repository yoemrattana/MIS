<style>
	body { overflow-y: scroll; }
	text tspan { font-size: inherit; }
	.chartbox { margin-top: 30px; border: 1px solid black; }
	.table-bordered { border: 2px solid black; }
	.table-bordered th, .table-bordered td { 
		border-color: black !important;
		border-left: none !important;
		border-bottom-width: 0 !important;
		padding: 1px 5px;
	}
	.table-bordered > thead > tr > th { text-align: center; }
	.bednet tbody td:nth-child(5n + 7), .bednet tbody td:nth-child(13) { font-weight: bold; }
	table { white-space: nowrap; }
	.fixed-header table { border-bottom-width: 1px; }
	@media print {
		.panel { border: none; }
	}
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix hidden-print">
		<div class="pull-left form-inline" style="left:21px" data-bind="style: { position: app.isMobile ? '' : 'sticky' }">
			<div style="display:inline-block">
				<div class="text-bold">Grant</div>
				<select class="form-control" data-bind="value: grant, options: grantList"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Report</div>
				<select class="form-control minwidth150" data-bind="value: selectedReport, options: reportList, optionsText: 'name'"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Year</div>
				<select class="form-control" data-bind="value: year, options: yearList" style="width:70px"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">From</div>
				<select class="form-control" data-bind="value: from, options: monthList" style="width:70px"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">To</div>
				<select class="form-control" data-bind="value: to, options: monthList" style="width:70px"></select>
			</div>
			<button class="btn btn-primary" data-bind="click: submit" style="width:100px">View</button>
		</div>
		<div class="pull-right" style="right:21px" data-bind="style: { position: app.isMobile ? '' : 'sticky' }">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>

	<div class="panel-body relative" data-bind="visible: visibleBody">
		<div class="clearfix">
			<div class="pull-left" style="left:21px" data-bind="style: { position: app.isMobile ? '' : 'sticky' }">
				<h4 class="no-margin-top" data-bind="text: selectedReport().title"></h4>
			</div>
			<div class="pull-right" style="right:21px" data-bind="style: { position: app.isMobile ? '' : 'sticky' }">
				<button class="btn btn-success btn-sm hidden-print" data-bind="click: exportExcel">Export Excel</button>
			</div>
		</div>

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_Country' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="30">N</th>
					<th rowspan="2" width="200">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Population</th>
					<th rowspan="2">Population at risk</th>
					<th colspan="10">Tested Cases</th>
					<th colspan="14">Confirmed Cases</th>
					<th colspan="9">Treated Cases</th>
					<th rowspan="2">Death</th>
				</tr>
				<tr>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Passive</th>
					<th>Active</th>
					<th>Total</th>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>PF</th>
					<th>PV</th>
					<th>Mix</th>
					<th>PM</th>
					<th>PO</th>
					<th>PK</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
					<th>Treated reported to MIS &lt;24h</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_Country, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_Country(), 2) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_HF' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="30">N</th>
					<th rowspan="2" width="200">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Population</th>
					<th colspan="10">Tested Cases</th>
					<th colspan="14">Confirmed Cases</th>
					<th colspan="9">Treated Cases</th>
					<th rowspan="2">Death</th>
				</tr>
				<tr>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Passive</th>
					<th>Active</th>
					<th>Total</th>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>PF</th>
					<th>PV</th>
					<th>Mix</th>
					<th>PM</th>
					<th>PO</th>
					<th>PK</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
					<th>Treated reported to MIS &lt;24h</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_HF, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_HF(), 2) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_VMW' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="30">N</th>
					<th rowspan="2" width="200">Province</th>
					<th rowspan="2">OD</th>
					<th colspan="10">Tested Cases</th>
					<th colspan="14">Confirmed Cases</th>
					<th colspan="9">Treated Cases</th>
					<th rowspan="2">Death</th>
				</tr>
				<tr>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Passive</th>
					<th>Active</th>
					<th>Total</th>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>PF</th>
					<th>PV</th>
					<th>Mix</th>
					<th>PM</th>
					<th>PO</th>
					<th>PK</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
					<th>Male</th>
					<th>Female</th>
					<th>Age &lt; 5</th>
					<th>Age 5-14</th>
					<th>Age &gt;= 15</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
					<th>Treated reported to MIS &lt;24h</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_VMW, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_VMW(), 2) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_PvTreatment' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th width="30">N</th>
					<th>Province</th>
					<th>OD</th>
					<th>Total Pv/Mix case</th>
					<th>Eligible G6PD test</th>
					<th>G6PD test</th>
					<th>Radical cure eligible</th>
					<th>Received radical cure</th>
					<th>Completed cure</th>
					<th>Drop-out</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_PvTreatment, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_PvTreatment(), 2) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_CFI' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="30">N</th>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th colspan="3">Cases</th>
					<th colspan="3">Investigated</th>
					<th colspan="3">Relapse/Recrudecent</th>
					<th colspan="3">Locally Aquired</th>
					<th colspan="3">Domestically Imported</th>
					<th colspan="3">Internationally Imported</th>
					<th colspan="3">Induced</th>
					<th rowspan="2">Eligible Foci</th>
					<th rowspan="2">Foci Investigation</th>
					<th rowspan="2">Foci Responded &lt; 7D</th>
				</tr>
				<tr data-bind="foreach: Array(7)">
					<th>Pf + Mix</th>
					<th>Pv</th>
					<th>Pm/Po/Pk</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_CFI, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_CFI(), 2) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_NetMass' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th width="30">N</th>
					<th>Province</th>
					<th>OD</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
                    <!--<th>Hammok Net in Q1</th>
                    <th>Hammok Net in Q2</th>
                    <th>Hammok Net in Q3</th>
                    <th>Hammok Net in Q4</th>
                    <th>Total Hammok Net</th>
                    <th>Pregnancy Net in Q1</th>
                    <th>Pregnancy Net in Q2</th>
                    <th>Pregnancy Net in Q3</th>
                    <th>Pregnancy Net in Q4</th>
                    <th>Total Pregnancy Net</th>-->
					<th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_NetMass, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_NetMass(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_NetContinue' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th width="30">N</th>
					<th>Province</th>
					<th>OD</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
                    <!--<th>Hammok Net in Q1</th>
                    <th>Hammok Net in Q2</th>
                    <th>Hammok Net in Q3</th>
                    <th>Hammok Net in Q4</th>
                    <th>Total Hammok Net</th>
                    <th>Pregnancy Net in Q1</th>
                    <th>Pregnancy Net in Q2</th>
                    <th>Pregnancy Net in Q3</th>
                    <th>Pregnancy Net in Q4</th>
                    <th>Total Pregnancy Net</th>-->
                    <th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_NetContinue, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_NetContinue(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_NetMobile' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th width="30">N</th>
					<th>Province</th>
					<th>OD</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
                    <!--<th>Hammok Net in Q1</th>
                    <th>Hammok Net in Q2</th>
                    <th>Hammok Net in Q3</th>
                    <th>Hammok Net in Q4</th>
                    <th>Total Hammok Net</th>
                    <th>Pregnancy Net in Q1</th>
                    <th>Pregnancy Net in Q2</th>
                    <th>Pregnancy Net in Q3</th>
                    <th>Pregnancy Net in Q4</th>
                    <th>Total Pregnancy Net</th>-->
                    <th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_NetMobile, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_NetMobile(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_NetOther' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th width="30">N</th>
					<th>Place</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
                    <!--<th>Hammok Net in Q1</th>
                    <th>Hammok Net in Q2</th>
                    <th>Hammok Net in Q3</th>
                    <th>Hammok Net in Q4</th>
                    <th>Total Hammok Net</th>-->
					<th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_NetOther, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data]), 'kh': $data == 'Place'}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_RAI4_NetOther(), 1) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_StockACT' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th width="30">N</th>
					<th>Province</th>
					<th>OD</th>
					<th>Total HFs</th>
					<!-- ko foreach: Array(12) -->
					<th data-bind="visible: $root.visibleMonth($index()), text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th data-bind="visible: countMonth() > 1">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_StockACT, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total # of HFs without stock-out of ACT</th>
					<!-- ko foreach: SP_V2_RAI4_StockACT_footer1 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="3">Total # of HFs</th>
					<!-- ko foreach: SP_V2_RAI4_StockACT_footer2 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="3">Percentage of HF without stock-out of ACT</th>
					<!-- ko foreach: SP_V2_RAI4_StockACT_footer3 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_StockRDT' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th width="30">N</th>
					<th>Province</th>
					<th>OD</th>
					<th>Total HFs</th>
					<!-- ko foreach: Array(12) -->
					<th data-bind="visible: $root.visibleMonth($index()), text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th data-bind="visible: countMonth() > 1">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_StockRDT, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total # of HFs without stock-out of RDT</th>
					<!-- ko foreach: SP_V2_RAI4_StockRDT_footer1 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="3">Total # of HFs</th>
					<!-- ko foreach: SP_V2_RAI4_StockRDT_footer2 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="3">Percentage of HF without stock-out of RDT</th>
					<!-- ko foreach: SP_V2_RAI4_StockRDT_footer3 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_HFCompleteness' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="30">N</th>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Total HFs</th>
					<th data-bind="attr: {colspan: countMonth() + (countMonth() > 1 ? 1 : 0) }"># of completed reports submitted from each HF</th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th data-bind="visible: $root.visibleMonth($index()), text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th data-bind="visible: countMonth() > 1">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_HFCompleteness, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total # of HFs sumitted completed report</th>
					<!-- ko foreach: SP_V2_RAI4_HFCompleteness_footer1 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="3">Total # of HFs</th>
					<!-- ko foreach: SP_V2_RAI4_HFCompleteness_footer2 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="3">Percentage of HF submitted report</th>
					<!-- ko foreach: SP_V2_RAI4_HFCompleteness_footer3 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_RAI4_VMWCompleteness' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="30">N</th>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">HF</th>
					<th rowspan="2">Total<br />VMWs/MMWs</th>
					<th data-bind="attr: {colspan: countMonth() + (countMonth() > 1 ? 1 : 0) }"># of completed reports submitted from each VMWs/MMWs</th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th data-bind="visible: $root.visibleMonth($index()), text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th data-bind="visible: countMonth() > 1">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_RAI4_VMWCompleteness, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: Object.keys($data) -->
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="4">Total # of VMWs sumitted completed report</th>
					<!-- ko foreach: SP_V2_RAI4_VMWCompleteness_footer1 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="4">Total # of VMWs</th>
					<!-- ko foreach: SP_V2_RAI4_VMWCompleteness_footer2 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="4">Percentage of VMW submitted report</th>
					<!-- ko foreach: SP_V2_RAI4_VMWCompleteness_footer3 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_CaseFromHF' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="200">Province</th>
					<th rowspan="2">OD</th>
					<th colspan="5">Tested Cases</th>
					<th colspan="11">Confirmed Cases</th>
					<th colspan="5">Treated Cases</th>
					<th rowspan="2">Death</th>
				</tr>
				<tr>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>PF</th>
					<th>PV</th>
					<th>Mix</th>
					<th>PM</th>
					<th>PO</th>
					<th>PK</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_CaseFromHF, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_CaseFromHF(), 2) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_CaseFromVMW' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th colspan="4">Tested Cases</th>
					<th colspan="9">Confirmed Cases</th>
					<th colspan="3">Treated Cases</th>
					<th rowspan="2">Referred</th>
				</tr>
				<tr>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>PF</th>
					<th>PV</th>
					<th>Mix</th>
					<th>PM</th>
					<th>PO</th>
					<th>PK</th>
					<th>Total</th>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_CaseFromVMW, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_CaseFromVMW(), 2) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_HFCompleteness' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th data-bind="attr: {colspan: countMonth() + (countMonth() > 1 ? 1 : 0) }"># of completed reports submitted from each HF</th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th data-bind="visible: $root.visibleMonth($index()), text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th data-bind="visible: countMonth() > 1">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_HFCompleteness, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total # of HFs sumitted completed report</th>
					<!-- ko foreach: SP_V2_HFCompleteness_footer1 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="2">Total # of HFs</th>
					<!-- ko foreach: SP_V2_HFCompleteness_footer2 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="2">Percentage of HF submitted report</th>
					<!-- ko foreach: SP_V2_HFCompleteness_footer3 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_VMWCompleteness' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">HF</th>
					<th data-bind="attr: {colspan: countMonth() + (countMonth() > 1 ? 1 : 0) }"># of completed reports submitted from each VMWs</th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th data-bind="visible: $root.visibleMonth($index()), text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th data-bind="visible: countMonth() > 1">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_VMWCompleteness, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="3">Total # of VMWs sumitted completed report</th>
					<!-- ko foreach: SP_V2_VMWCompleteness_footer1 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="3">Total # of VMWs</th>
					<!-- ko foreach: SP_V2_VMWCompleteness_footer2 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<th align="center" colspan="3">Percentage of VMW submitted report</th>
					<!-- ko foreach: SP_V2_VMWCompleteness_footer3 -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_NetStatic' -->
		<table class="table-bordered table-hover bednet">
			<thead>
				<tr>
					<th>Province</th>
					<th>OD</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
					<th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_NetStatic, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_NetStatic(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_NetMobile' -->
		<table class="table-bordered table-hover bednet">
			<thead>
				<tr>
					<th>Province</th>
					<th>OD</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
					<th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_NetMobile, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_NetMobile(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_NetMobileContinue' -->
		<table class="table-bordered table-hover bednet">
			<thead>
				<tr>
					<th>Province</th>
					<th>OD</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
					<th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_NetMobileContinue, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_NetMobileContinue(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_NetContinue' -->
		<table class="table-bordered table-hover bednet">
			<thead>
				<tr>
					<th>Province</th>
					<th>OD</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
					<th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_NetContinue, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_NetContinue(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_NetOther' -->
		<table class="table-bordered table-hover bednet">
			<thead>
				<tr>
					<th>Place</th>
					<th>LLIN in Q1</th>
					<th>LLIN in Q2</th>
					<th>LLIN in Q3</th>
					<th>LLIN in Q4</th>
					<th>Total LLIN</th>
					<th>LLIHN in Q1</th>
					<th>LLIHN in Q2</th>
					<th>LLIHN in Q3</th>
					<th>LLIHN in Q4</th>
					<th>Total LLIHN</th>
					<th>Total LLIN + LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_NetOther, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data]), 'kh': $data == 'Place'}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_NetOther(), 1) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_Investigation' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th>Province</th>
					<th>OD</th>
					<th>PF + Mix</th>
					<th>Referred</th>
					<th>Investigated</th>
					<th width="60">L1</th>
					<th width="60">L2</th>
					<th>L3 + L4</th>
					<th>Imported</th>
					<th>Incomplete</th>
					<th>Reactive Case Detection</th>
					<th>Number of Foci</th>
					<th>Investigated Foci</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_Investigation, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_Investigation(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
				<!-- ko with: SP_V2_Investigation_footer -->
				<tr>
					<th colspan="2">Proportion of completed investigation</th>
					<th align="center" colspan="11" data-bind="text: investigation"></th>
				</tr>
				<tr>
					<th colspan="2">Proportion of completed reactive case detection</th>
					<th align="center" colspan="11" data-bind="text: reactive"></th>
				</tr>
				<!-- /ko -->
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_HaveStock' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="3">Province</th>
					<th rowspan="3">OD</th>
					<th rowspan="3">Total HFs</th>
					<th data-bind="attr: {colspan: countMonth() == 1 ? 2 : (countMonth() + 1) * 2}"># HC without stock-out of ACT</th>
					<th data-bind="attr: {colspan: countMonth() == 1 ? 2 : (countMonth() + 1) * 2}"># HC without stock-out of RDT</th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th colspan="2" data-bind="visible: $root.visibleMonth($index()), text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th colspan="2" data-bind="visible: countMonth() > 1">Total</th>

					<!-- ko foreach: Array(12) -->
					<th colspan="2" data-bind="visible: $root.visibleMonth($index()), text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th colspan="2" data-bind="visible: countMonth() > 1">Total</th>
				</tr>
				<tr>
					<!-- ko foreach: Array(12) -->
					<th data-bind="visible: $root.visibleMonth($index())">Stock</th>
					<th data-bind="visible: $root.visibleMonth($index())">Reported</th>
					<!-- /ko -->
					<th data-bind="visible: countMonth() > 1">Stock</th>
					<th data-bind="visible: countMonth() > 1">Reported</th>

					<!-- ko foreach: Array(12) -->
					<th data-bind="visible: $root.visibleMonth($index())">Stock</th>
					<th data-bind="visible: $root.visibleMonth($index())">Reported</th>
					<!-- /ko -->
					<th data-bind="visible: countMonth() > 1">Stock</th>
					<th data-bind="visible: countMonth() > 1">Reported</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_HaveStock, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': !isNaN($parent[$data]), 'text-bold': $data.in('TotalACT','ReportACT','TotalRDT','ReportRDT')}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_HaveStock(), 2) -->
					<th data-bind="text: $data" align="right"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_APIALL' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Population</th>
					<th rowspan="2">Tested Cases</th>
					<th colspan="2">Confirmed</th>
					<th rowspan="2">Death</th>
					<th rowspan="2">Mortality<br>Rate</th>
					<th rowspan="2">Test Positive<br>Rate</th>
					<th rowspan="2">ABER</th>
				</tr>
				<tr>
					<th width="70">Cases</th>
					<th width="70">API</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_APIALL, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Pop" align="right"></td>
					<td data-bind="text: Test" align="right"></td>
					<td data-bind="text: Confirm" align="right"></td>
					<td data-bind="text: (Confirm * 1000 / Pop).toFixed(2)" align="right"></td>
					<td data-bind="text: Death" align="right"></td>
					<td data-bind="text: (Death * 100000 / Pop).toFixed(2)" align="right"></td>
					<td data-bind="text: (Confirm * 100 / Test).toFixed(0) + '%'" align="right"></td>
					<td data-bind="text: (Test * 100 / Pop).toFixed(0) + '%'" align="right"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr data-bind="with: footerTotal(SP_V2_APIALL(), 2)">
					<th align="center" colspan="2">Total</th>
					<th data-bind="text: $data[0]" align="right"></th>
					<th data-bind="text: $data[1]" align="right"></th>
					<th data-bind="text: $data[2]" align="right"></th>
					<th data-bind="text: ($data[2] * 1000 / $data[0]).toFixed(2)" align="right"></th>
					<th data-bind="text: $data[3]" align="right"></th>
					<th data-bind="text: ($data[3] * 100000 / $data[0]).toFixed(2)" align="right"></th>
					<th data-bind="text: ($data[2] * 100 / $data[1]).toFixed(0) + '%'" align="right"></th>
					<th data-bind="text: ($data[1] * 100 / $data[0]).toFixed(0) + '%'" align="right"></th>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_APIElimination' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Population</th>
					<th rowspan="2">Tested Cases</th>
					<th colspan="2">Confirmed</th>
					<th rowspan="2">Death</th>
					<th rowspan="2">Mortality<br>Rate</th>
					<th rowspan="2">Test Positive<br>Rate</th>
					<th rowspan="2">ABER</th>
				</tr>
				<tr>
					<th width="70">Cases</th>
					<th width="70">API</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_APIElimination, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Pop" align="right"></td>
					<td data-bind="text: Test" align="right"></td>
					<td data-bind="text: Confirm" align="right"></td>
					<td data-bind="text: (Confirm * 1000 / Pop).toFixed(2)" align="right"></td>
					<td data-bind="text: Death" align="right"></td>
					<td data-bind="text: (Death * 100000 / Pop).toFixed(2)" align="right"></td>
					<td data-bind="text: (Confirm * 100 / Test).toFixed(0) + '%'" align="right"></td>
					<td data-bind="text: (Test * 100 / Pop).toFixed(0) + '%'" align="right"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr data-bind="with: footerTotal(SP_V2_APIElimination(), 2)">
					<th align="center" colspan="2">Total</th>
					<th data-bind="text: $data[0]" align="right"></th>
					<th data-bind="text: $data[1]" align="right"></th>
					<th data-bind="text: $data[2]" align="right"></th>
					<th data-bind="text: ($data[2] * 1000 / $data[0]).toFixed(2)" align="right"></th>
					<th data-bind="text: $data[3]" align="right"></th>
					<th data-bind="text: ($data[3] * 100000 / $data[0]).toFixed(2)" align="right"></th>
					<th data-bind="text: ($data[2] * 100 / $data[1]).toFixed(0) + '%'" align="right"></th>
					<th data-bind="text: ($data[1] * 100 / $data[0]).toFixed(0) + '%'" align="right"></th>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_AnnualCaseCountry' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="200">Province</th>
					<th rowspan="2">Population</th>
					<th colspan="3">Tested</th>
					<th colspan="7">Positive</th>
					<th rowspan="2">Treated</th>
					<th rowspan="2">Death</th>
				</tr>
				<tr>
					<th>Slide</th>
					<th>RDT</th>
					<th>Total</th>
					<th>PF</th>
					<th>PV</th>
					<th>Mix</th>
					<th>PM</th>
					<th>PO</th>
					<th>PK</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_AnnualCaseCountry, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_AnnualCaseCountry(), 1) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_AnnualCaseOD' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="200">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Population</th>
					<th colspan="7">Tested Cases</th>
					<th colspan="13">Confirmed Cases</th>
					<th colspan="5">Treated Cases</th>
					<th rowspan="2">Death</th>
				</tr>
				<tr>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Passive</th>
					<th>Active</th>
					<th>Total</th>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>PF</th>
					<th>PV</th>
					<th>Mix</th>
					<th>PM</th>
					<th>PO</th>
					<th>PK</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Local</th>
					<th>IMP</th>
					<th>Total</th>
					<th>Age &lt; 5</th>
					<th>Age 5+</th>
					<th>RDT</th>
					<th>Slide</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_AnnualCaseOD, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': $root.isRight($parent[$data])}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: footerTotal(SP_V2_AnnualCaseOD(), 2) -->
					<th data-bind="text: $data, css: {'text-right': $root.isRight($data)}"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_CIFI' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="200">Province</th>
					<th rowspan="2">OD</th>
					<th colspan="3">Cases</th>
					<th colspan="2">Investigated</th>
					<th colspan="2">Relapse</th>
					<th colspan="2">L1</th>
					<th colspan="2">LC</th>
					<th colspan="2">IMP</th>
					<th colspan="2">ReACD</th>
					<th rowspan="2">Notify&lt;24h</th>
					<th rowspan="2">% Notify&lt;24h</th>
					<th rowspan="2">Classify&lt;24h</th>
					<th rowspan="2">% Classify&lt;24h</th>
                    <th rowspan="2">Eligible RACD</th>
                    <th rowspan="2">RACD&lt;3D</th>
					<th rowspan="2">% RACD&lt;3D</th>
                    <th rowspan="2">Eligible Foci</th>
					<th rowspan="2">Foci Inv</th>
					<th rowspan="2">Foci Inv&lt;7D</th>
					<th rowspan="2">% Foci Inv&lt;7D</th>
                    <th rowspan="2">Foci Response&lt;7D</th>
                    <th rowspan="2">% Foci Response&lt;7D</th>
				</tr>
				<tr data-bind="foreach: Array(7)">
					<th width="70">Pf + Mix</th>
					<th width="70">Pv</th>
					<th data-bind="visible: $index() == 0">PM + PO + PK</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_CIFI, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': $index() > 1}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: SP_V2_CIFI_footer -->
					<th align="right" data-bind="text: $data"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: selectedReport().id == 'SP_V2_CIFI_CMEP' -->
		<table class="table-bordered table-hover">
			<thead>
				<tr>
					<th rowspan="2" width="200">Province</th>
					<th rowspan="2">OD</th>
					<th colspan="3">Cases</th>
					<th colspan="2">Investigated</th>
					<th colspan="2">Relapse</th>
					<th colspan="2">L1</th>
					<th colspan="2">LC</th>
					<th colspan="2">IMP</th>
					<th colspan="2">ReACD</th>
					<th rowspan="2">Notify&lt;24h</th>
					<th rowspan="2">% Notify&lt;24h</th>
					<th rowspan="2">Classify&lt;24h</th>
					<th rowspan="2">% Classify&lt;24h</th>
					<th rowspan="2">Eligible RACD</th>
					<th rowspan="2">RACD&lt;3D</th>
					<th rowspan="2">% RACD&lt;3D</th>
					<th rowspan="2">Eligible Foci</th>
					<th rowspan="2">Foci Inv</th>
					<th rowspan="2">Foci Inv&lt;7D</th>
					<th rowspan="2">% Foci Inv&lt;7D</th>
					<th rowspan="2">Foci Response&lt;7D</th>
					<th rowspan="2">% Foci Response&lt;7D</th>
				</tr>
				<tr data-bind="foreach: Array(7)">
					<th width="70">Pf + Mix</th>
					<th width="70">Pv</th>
					<th data-bind="visible: $index() == 0">PM + PO + PK</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: SP_V2_CIFI_CMEP, fixedHeader: true">
				<tr data-bind="foreach: Object.keys($data), click: app.selectTr">
					<td data-bind="text: $parent[$data], css: {'text-right': $index() > 1}"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th align="center" colspan="2">Total</th>
					<!-- ko foreach: SP_V2_CIFI_CMEP_footer -->
					<th align="right" data-bind="text: $data"></th>
					<!-- /ko -->
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<br />
		<!--<div>Note: Data is from 55 ODs in 21 Provinces</div>-->
	</div>
</div>

<?=latestJs('/media/ViewModel/ReportV2.js')?>