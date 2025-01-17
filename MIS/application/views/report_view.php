<style>
	.frame { margin: 5px; float: left; height: 406px; border: 1px solid #ccc; padding: 10px; }
	.frame header { font-weight: bold; margin: -10px -10px 10px -10px; background-color: #428bca; padding: 6px 10px; color: white; font-size: 16px; }
	.frame table td { padding: 5px; }
	input[type=radio] { margin: 4px 0 0; }
	input[type=checkbox]:not([name=pv]) { width: 20px; height: 20px; }

	#modalInvestPopup div.fixed-header,
    #modalRDTImage div.fixed-header { top: 1px; margin-left: 1px; }

	table.fixed-header thead th[sortable]:hover { background-color: lightgray; }
	table.fixed-header thead th[sortable]:active { background-color: lightgray; box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125); }
	.underline:not(:empty):hover { text-decoration: underline; cursor: pointer; }
	.circlepoint { width:15px; height:15px; border-radius:50%; display:inline-block; }

	@media print {
		.panel { border: none; }
		.panel-heading { border: none; padding: 0; background-color: white !important; }
		.panel-body { padding: 0; }
        .table-bordered > tbody > tr > td,
        .table-bordered > thead > tr > th { border: 1px solid black !important; }
	}

    .chart-container { position: relative; width: 100%; z-index:1; }
    .chart-container .btn {
        position: absolute;
        top: 6%;
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
    .chart-container [type=checkbox] { width: 15px; height: 15px; }
    .highcharts-legend-item { pointer-events: none; }
	.rotate90 { vertical-align: middle !important; }
	.rotate90 div { writing-mode: vertical-rl; transform: rotate(180deg); margin: auto; }
	l {
		margin-top: 17px;
		float: left;
		border: solid 1px #8e44ad;
		padding: 0 5px 0 5px;
		font-size: 10px;
	}
	r {
		margin-top: 17px;
		float: right;
		border: solid 1px #27ae60;
		padding: 0 5px 0 5px;
		font-size: 10px;
	}
	l-box { border: solid 1px #8e44ad; padding: 0 5px 0 5px; }
	r-box { border: solid 1px #27ae60; padding: 0 5px 0 5px; }

	.badge { line-height: normal; }
	.badge, .round { font-weight: 400; }
	.badge-danger { color: #fff; background-color: #e46a76; }
	.badge {
		display: inline-block;
		padding: .25em .4em;
		font-size: 75%;
		text-align: center;
		border-radius: .25rem;
		transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	.badge-light { color: #212529; background-color: #f8f9fa; }
</style>

<div class="panel panel-default" style="display:none" data-bind="visible: report() == null">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh34">
			<b>Reports</b>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<div class="frame">
			<div class="pull-left" style="width:245px">
				<table>
					<tr>
						<td style="padding-top:7px">
							<span style="margin-left:20px">Year</span>
						</td>
						<td>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-default" data-bind="click: previousClick">
										<i class="glyphicon glyphicon-triangle-left"></i>
									</button>
								</span>
								<input type="text" class="form-control text-center" data-bind="value: year" readonly id="chooseyear" />
								<span class="input-group-btn">
									<button class="btn btn-default" data-bind="click: nextClick">
										<i class="glyphicon glyphicon-triangle-right"></i>
									</button>
								</span>
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding-top:7px">
							<label class="radio-inline">
								<input type="radio" name="filterType" value="q" data-bind="checked: filterType" class="cusm" />
								<span>Quarter</span>
							</label>
						</td>
						<td>
							<select class="form-control" data-bind="value: quarter, enable: filterType() == 'q'" id="quarter">
								<option>Q1</option>
								<option>Q2</option>
								<option>Q3</option>
								<option>Q4</option>
							</select>
						</td>
					</tr>
					<tr>
						<td style="padding-top:7px">
							<label class="radio-inline">
								<input type="radio" name="filterType" value="m" data-bind="checked: filterType" class="cusm" />
								<span>Month</span>
							</label>
						</td>
						<td>
							<select class="form-control choosem" data-bind="value: month, options: monthList, optionsValue: 'value', optionsText: 'text', enable: filterType() == 'm'"></select>
						</td>
					</tr>
					<tr>
						<td style="padding-top:7px">
							<label class="radio-inline">
								<input type="radio" name="filterType" value="cus" data-bind="checked: filterType" class="cusm" />
								<span>Custom</span>
							</label>
						</td>
						<td>
							<div class="row">
								<div class="col-xs-6" style="padding-right:5px">
									<select class="form-control cusm1" data-bind="value: from, options: monthList, optionsValue: 'value', optionsText: 'text', enable: filterType() == 'cus'"></select>
								</div>
								<div class="col-xs-6" style="padding-left:5px">
									<select class="form-control cusm2" data-bind="value: to, options: monthList, optionsValue: 'value', optionsText: 'text', enable: filterType() == 'cus'"></select>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<button class="btn btn-primary btn-block" data-bind="click: resetClick">Reset</button>
						</td>
					</tr>
				</table>
			</div>

			<div class="pull-left" style="width:180px; margin-left:15px">
				<div class="form-group">
					<span>Province</span>
					<div class="dropdown">
						<button class="btn btn-default btn-block dropdown-toggle" style="padding:6px" data-toggle="dropdown">
							<span data-bind="text: pvName"></span>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" onclick="event.stopPropagation()">
							<li style="display:flex; justify-content:space-between;">
								<button class="btn-link" data-bind="click: () => pv(pvList().map(r => r.code))">ALL</button>
								<button class="btn-link" data-bind="click: () => pv([])">CLEAR</button>
							</li>
							<!-- ko foreach: pvList -->
							<li>
								<a class="no-padding">
									<div class="checkbox">
										<label style="width:100%; padding:2px 8px 2px 22px">
											<input type="checkbox" name="pv" data-bind="checked: $root.pv, attr: { value: code }" style="margin:3px 0 0 -17px" />
											<span data-bind="text: name"></span>
										</label>
									</div>
								</a>
							</li>
							<!-- /ko -->
						</ul>
					</div>
				</div>
				<div class="form-group">
					<span>Operational District</span>
					<select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: odList().length == 1 ? undefined : 'All'"></select>
				</div>
				<div class="form-group">
					<span>Health Facility</span>
					<select class="form-control" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
				</div>
				<div class="form-group">
					<span>Village</span>
					<select class="form-control" data-bind="value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
				</div>
			</div>
		</div>

		<div class="frame">
			<header>VMW</header>
			<button name="SP_V1_VMWReportCompleteness" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Report Completeness</button>
            <button name="SP_V1_VMWReportTimeline" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Report Timeline</button>
            <button name="SP_V1_VMWDataAccuracy" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Report Accuracy</button>
			<button name="SP_V1_VMWReportReceived" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Report Received</button>
			<button name="SP_V1_VMWDataSummary" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Data (Summary)</button>
			<button name="SP_V1_VMWDataByVillage" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Data (By Village)</button>
			<div class="form-inline btn-block">
				<button name="SP_V1_VMWDataByMonth" addparam="vmwSpecies" class="btn btn-primary" data-bind="click: getReport">VMW Data by Month</button>
				<select class="form-control" data-bind="value: vmwSpecies">
					<option value="ALL">All Species</option>
					<option value="FM">Pf + Mix</option>
					<option value="F">Pf</option>
					<option value="V">Pv</option>
					<option value="M">Mix</option>
				</select>
			</div>
            <div class="form-inline btn-block">
			    <button name="SP_V1_VMWFingerprint" addparam="vmwFingerFilter" class="btn btn-primary" data-bind="click: getReport" style="width:166px">VMW Fingerprint Data</button>
				<select class="form-control" data-bind="value: vmwFingerFilter">
					<option value="ALL">All</option>
					<option value="Red">Red Only</option>
				</select>
			</div>
		</div>

		<div class="frame">
			<header>Health Facility</header>
			<button name="SP_V1_HFReportCompleteness" class="btn btn-primary btn-block" data-bind="click: getReport">HF Report Completeness</button>
            <button name="SP_V1_HFReportTimeline" class="btn btn-primary btn-block" data-bind="click: getReport">HF Report Timeline</button>
            <button name="SP_V1_HFDataAccuracy" class="btn btn-primary btn-block" data-bind="click: getReport">HF Report Accuracy</button>
			<button name="SP_V1_HFReportReceived" class="btn btn-primary btn-block" data-bind="click: getReport">HF Report Received</button>
			<button name="SP_V1_HFDataSummary" class="btn btn-primary btn-block" data-bind="click: getReport">HF Data (Summary)</button>
			<button name="SP_V1_HFDataByVillage" class="btn btn-primary btn-block" data-bind="click: getReport">HF Data (By Village)</button>
			<div class="form-inline btn-block">
				<button name="SP_V1_HFDataByMonth" addparam="hfSpecies" class="btn btn-primary" data-bind="click: getReport">HF Data by Month</button>
				<select class="form-control" data-bind="value: hfSpecies">
					<option value="ALL">All Species</option>
					<option value="FM">Pf + Mix</option>
					<option value="F">Pf</option>
					<option value="V">Pv</option>
					<option value="M">Mix</option>
				</select>
			</div>
            <div class="form-inline btn-block">
			    <button name="SP_V1_HFFingerprint" addparam="hfFingerFilter" class="btn btn-primary" data-bind="click: getReport" style="width:150px">HF Fingerprint Data</button>
				<select class="form-control" data-bind="value: hfFingerFilter">
					<option value="ALL">All</option>
					<option value="Red">Red Only</option>
				</select>
			</div>
		</div>

		<div class="frame">
			<header>HF + VMW</header>
			<button name="SP_V1_HFVMWTop10OD" class="btn btn-primary btn-block" data-bind="click: getReport">Top 10 ODs Having Most Cases</button>
			<button name="SP_V1_HFVMWTop30HF" class="btn btn-primary btn-block" data-bind="click: getReport">Top 30 HFs Having Most Cases</button>
			<div class="form-inline btn-block">
				<button name="SP_V1_HFVMWTop30HFChart" class="btn btn-primary" data-bind="click: getReport" style="width:248px">HFs Having Most Cases (Chart)</button>
				<select class="form-control" data-bind="value: chartTopQty">
					<option value="10">Top 10</option>
					<option value="20">Top 20</option>
					<option value="30">Top 30</option>
				</select>
			</div>
			<div class="form-inline btn-block">
				<button name="SP_V1_HFVMWTop30VillChart" class="btn btn-primary" data-bind="click: getReport" style="width:248px">Villages Having Most Cases (Chart)</button>
				<select class="form-control" data-bind="value: chartTopQty">
					<option value="10">Top 10</option>
					<option value="20">Top 20</option>
					<option value="30">Top 30</option>
				</select>
			</div>
			<button name="SP_V1_HFVMWDataSummary" class="btn btn-primary btn-block" data-bind="click: getReport">HF + VMW Data (Summary)</button>
			<button name="SP_V1_HFVMWPvFollowup" class="btn btn-primary btn-block" data-bind="click: getReport">Pv Radical Cure and Follow Up</button>
            <button name="SP_V1_HFVMWRACD" class="btn btn-primary btn-block" data-bind="click: getReport">RACD Map</button>
			<button name="SP_V1_HighRiskVillage" class="btn btn-primary btn-block" data-bind="click: getReport">High Risk Villages</button>
            <div class="form-inline btn-block">
				<button name="SP_V1_HFVMWDataByMonth" addparam="hfvmwSpecies" class="btn btn-primary" data-bind="click: getReport" style="width:221px">HF + VMW Data by Month</button>
				<select class="form-control" data-bind="value: hfvmwSpecies">
					<option value="ALL">All Species</option>
					<option value="FM">Pf + Mix</option>
					<option value="F">Pf</option>
					<option value="V">Pv</option>
					<option value="M">Mix</option>
				</select>
			</div>
		</div>

		<div class="frame">
			<header>Bed Net</header>
			<div class="form-inline btn-block">
				<button name="SP_V1_BedNetReport" addparam="bednetType,bednetDuration,level" level="pv" class="btn btn-primary" data-bind="click: getReport" style="width:154px">Bed Net by Province</button>
                <select class="form-control" data-bind="value: bednetType" style="width:152px; padding-right:0">
					<option value="all">All</option>
					<option value="campaign">Campaign</option>
					<option value="mobile">Mobile</option>
					<option value="continue">Continue</option>
				</select>
			</div>
			<div class="form-inline btn-block">
				<button name="SP_V1_BedNetReport" addparam="bednetType,bednetDuration,level" level="od" class="btn btn-primary" data-bind="click: getReport" style="width:154px">Bed Net by OD</button>
                <select class="form-control" data-bind="value: bednetDuration" style="width:152px">
					<option value="1">By Filter</option>
					<option value="3">Last 3 Years</option>
				</select>
			</div>
			<button name="SP_V1_BedNetReport" addparam="bednetType,bednetDuration,level" level="hc" class="btn btn-primary btn-block" data-bind="click: getReport">Bed Net by HC</button>
			<button name="SP_V1_BedNetReport" addparam="bednetType,bednetDuration,level" level="vl" class="btn btn-primary btn-block" data-bind="click: getReport">Bed Net by Village</button>
			<button name="SP_V1_PercentPopLLIN" class="btn btn-primary btn-block" data-bind="click: getReport">Percentage of Pop at-risk covered<br>by LLIN mass campaigns</button>
			<button name="SP_V1_PopCompleteness" class="btn btn-primary btn-block" export="1" data-bind="click: getReport">Population Data Completeness</button>
		</div>

		<div class="frame">
			<header>Investigation</header>
			<div class="form-inline btn-block" style="border:1px solid #ccc; padding:7px">
				<div class="btn-block">
					<select class="form-control" data-bind="value: invTypeFilter">
						<option value="all">HF + VMW</option>
						<option value="hf">HF</option>
						<option value="vmw">VMW</option>
					</select>
					<select class="form-control" data-bind="value: invDateFilter">
						<option value="0">By Report Date</option>
						<option value="1">By Diagnosis Date</option>
					</select>
				</div>
				<button name="SP_V1_Investigation" addparam="invTypeFilter,invDateFilter" class="btn btn-primary btn-block" data-bind="click: getReport">Investigation and ReACD (RAI3E)</button>
				<button name="SP_V1_InvestigationRai4" addparam="invTypeFilter,invDateFilter" class="btn btn-primary btn-block" data-bind="click: getReport">Investigation and ReACD (RAI4E)</button>
			</div>
			<button name="SP_V1_MnEElimination" class="btn btn-primary btn-block" data-bind="click: getReport">M&E Elimination (RAI3E)</button>
			<button name="SP_V1_MnEEliminationRai4" class="btn btn-primary btn-block" data-bind="click: getReport">M&E Elimination (RAI4E)</button>
			<button name="SP_V1_RadicalCureHSD" class="btn btn-primary btn-block" data-bind="click: getReport">Radical Cure HSD</button>
            <button name="SP_V1_Proactive2" type="list" class="btn btn-primary btn-block" data-bind="click: getReport">Proactive Case Detection Village</button>
            <button name="SP_V1_Proactive2" type="map" class="btn btn-primary btn-block" data-bind="click: getReport">Map of Proactive Case Detection Village</button>
		</div>

		<div class="frame">
			<header>Stock</header>
			<button name="SP_V1_StockODCompleteness" class="btn btn-primary btn-block" export="1" data-bind="click: getReport">OD Stock Completeness</button>
			<button name="SP_V1_StockHFCompleteness" class="btn btn-primary btn-block" export="1" data-bind="click: getReport">HF Stock Completeness</button>
			<button name="SP_V1_HFStockOut" addparam="category" category="ACT" class="btn btn-primary btn-block" data-bind="click: getReport">HF Stock-Out (ACT)</button>
			<button name="SP_V1_HFStockOut" addparam="category" category="RDT" class="btn btn-primary btn-block" data-bind="click: getReport">HF Stock-Out (RDT)</button>
            <button name="SP_V1_StockOD" export="1" class="btn btn-primary btn-block" data-bind="click: getReport">OD Stock Data</button>
            <button name="SP_V1_StockHC" export="1" class="btn btn-primary btn-block" data-bind="click: getReport">HF Stock Data</button>
            <button name="SP_V1_VMWCommodityCompleteness" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Commodity Completeness</button>
            <button name="SP_V1_VMWCommodity" export="0" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Commodity Data</button>
		</div>

        <div class="frame">
            <header>Stock Forecasting</header>
			<button name="SP_V1_Primaquine" export="1" class="btn btn-primary btn-block" data-bind="click: showPrimaquineV2">Primaquine Distribution List (7.5 mg)</button>
			<!--<button name="SP_V1_PrimaquineDistribution" level="15" export="1" class="btn btn-primary btn-block" data-bind="click: showPrimaquine">Primaquine Distribution List (15 mg)</button>-->
			<button name="SP_V1_G6PD" export="1" data-bind="click: showG6PD" class="btn btn-primary btn-block">G6PD Distribution</button>
            <button name="SP_V1_StockForecasting" type="rdt" export="1" class="btn btn-primary btn-block" data-bind="click: showRDT">RDT Forecasting</button>
            <button name="SP_V1_StockForecasting" type="asmq" export="1" class="btn btn-primary btn-block" data-bind="click: showASMQ">ASMQ Forecasting</button>
        </div>

		<div class="frame">
			<header>Intensification Plan</header>

			<div class="form-inline btn-block">
				<button name="SP_V1_IntensificationPlan" addparam="ipType" export="1" class="btn btn-primary" data-bind="click: getReport">Intensification Plan</button>
				<select class="form-control" data-bind="value: ipType">
					<option value="1">IP1</option>
					<option value="2">IP2</option>
				</select>
			</div>
		</div>
		
		<div class="frame" admin="1">
			<header>Admin Tools</header>
			<button name="SP_V1_DashboardLogByRole" class="btn btn-primary btn-block" data-bind="click: getReport">Dashboard Log By Role</button>
			<button name="SP_V1_DashboardLogByUser" class="btn btn-primary btn-block" data-bind="click: getReport">Dashboard Log By User</button>
			<button name="SP_V1_SystemLogByRole" class="btn btn-primary btn-block" data-bind="click: getReport">System Log By Role</button>
			<button name="SP_V1_SystemLogByUser" class="btn btn-primary btn-block" data-bind="click: getReport">System Log By User</button>
			<button name="SP_V1_HFErrorCheck" class="btn btn-primary btn-block" data-bind="click: getReport">HF Referred Error</button>
			<button name="SP_V1_VMWErrorCheck" class="btn btn-primary btn-block" data-bind="click: getReport">VMW Referred Error</button>
		</div>

		<div class="frame">
			<header>Other</header>
			<button name="SP_V1_SupervisionChecklist" class="btn btn-primary btn-block" data-bind="click: getReport">For Supervision Checklist</button>
			<button name="SP_V1_Death" class="btn btn-primary btn-block" data-bind="click: getReport">Death</button>
			<button name="SP_V1_CaseAfterDeadline" class="btn btn-primary btn-block" data-bind="click: getReport">Case After Deadline</button>
		</div>

        <div class="frame">
			<header>Last Mile</header>
			<button name="SP_V1_LastMile" class="btn btn-primary btn-block" data-bind="click: getReport">Last Mile</button>
			<button name="SP_V1_LastMileCompleteness" class="btn btn-primary btn-block" data-bind="click: getReport">Last Mile Completeness</button>
            <button name="SP_V1_LastmileSummary" export="1" class="btn btn-primary btn-block" data-bind="click: getReport">Last Mile Summary</button>
            <button name="SP_V1_LastMileNoLatLong" export="1" class="btn btn-primary btn-block" data-bind="click: getReport">Last Mile House Without Lat Long</button>
            <button name="SP_V1_LastmileNoData" class="btn btn-primary btn-block" data-bind="click: getReport">Last Mile Villages Without Data</button>
            <button name="SP_V1_LastMileIPT" class="btn btn-primary btn-block" data-bind="click: getReport">Last Mile IPT</button>
            <button name="SP_V1_LastMileAFS" class="btn btn-primary btn-block" data-bind="click: getReport">Last Mile AFS</button>
		</div>
	</div>
</div>

<div class="panel panel-default" style="display:none; margin:-10px" data-bind="visible: report() != null">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh34" style="position:sticky; left:11px">
			<b data-bind="text: title"></b>
		</div>
		<div class="pull-right hidden-print" style="position:sticky; right:11px">
            <button class="btn btn-primary width100" onclick="window.print()">Print</button>
			<button class="btn btn-success" data-bind="click: exportExcel, visible: visibleExport">Export Excel</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body">

		<!-- ko if: ['SP_V1_VMWReportCompleteness','SP_V1_HFReportCompleteness'].contain(report()) -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th align="center" width="100">CSO</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: isnot($root.valueByMonth($parent, $index()), '', r => r + '%'), style: {backgroundColor: $root.bgWarning($parent, $index())}" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: ['SP_V1_VMWReportTimeline','SP_V1_HFReportTimeline'].contain(report()) -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th align="center">CSO</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: isnot($root.valueByMonth($parent, $index()), '', r => r + '%'), style: {backgroundColor: $root.bgWarning($parent, $index())}" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
        <div class="font16" style="margin-top:20px">
			* For elimination provinces, Must report malaria cases within 3 days after date of blood-test.
			<br />
			* For non-elimination provinces, Must report malaria cases between date of blood-test and 5<sup>th</sup> of next month.
		</div>
		<!-- /ko -->

        <!-- ko if: report() == 'SP_V1_VMWDataAccuracy' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th align="center">CSO</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="html: isnot($root.accuracyByMonth($parent, $index()), '', r => parseFloat(r[0]).toFixed(2) + '%' + '<l>' + r[1] + '</l>' + '<r>' + r[2] + '</r>') , style: {backgroundColor: $root.bgAccuracyWarning($parent, $index())}" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<div class="font16" style="margin-top:20px">
			* <l-box>&nbsp;&nbsp;&nbsp;&nbsp;</l-box> Total number of data.
			<br />
			* <r-box>&nbsp;&nbsp;&nbsp;&nbsp;</r-box> Number of sample data collected by auditor.
		</div>
		<!-- /ko -->

        <!-- ko if: report() == 'SP_V1_HFDataAccuracy' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th align="center">CSO</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="html: isnot($root.accuracyByMonth($parent, $index()), '', r => parseFloat(r[0]).toFixed(2) + '%' + '<l>' + r[1] + '</l>' + '<r>' + r[2] + '</r>') , style: {backgroundColor: $root.bgAccuracyWarning($parent, $index())}" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<div class="font16" style="margin-top:20px">
			* <l-box>&nbsp;&nbsp;&nbsp;&nbsp;</l-box> Total number of data.
			<br />
			* <r-box>&nbsp;&nbsp;&nbsp;&nbsp;</r-box> Number of sample data collected by auditor.
		</div>
		<!-- /ko -->

		<!-- ko if: ['SP_V1_VMWReportReceived','SP_V1_HFReportReceived'].contain(report()) -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th align="center">CSO</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: $root.valueByMonth($parent, $index())" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: ['SP_V1_VMWDataSummary','SP_V1_VMWDataByVillage'].contain(report()) -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th rowspan="2">Place</th>
					<th rowspan="2" align="center">Village</th>
					<th rowspan="2" align="center">Pop</th>
					<th rowspan="2" align="center">Test</th>
					<th rowspan="2" align="center">Positive</th>
					<th rowspan="2" align="center">Negative</th>
					<th rowspan="2" align="center">Pf</th>
					<th rowspan="2" align="center">Pv</th>
					<th rowspan="2" align="center">Mix</th>
					<th rowspan="2" align="center">Pm</th>
					<th rowspan="2" align="center">Po</th>
					<th rowspan="2" align="center">Pk</th>
					<th rowspan="2" align="center">Refer</th>
					<th rowspan="2" align="center">Death</th>
					<th rowspan="2" align="center">Treatment</th>
					<th rowspan="2" align="center">Mobile Test</th>
					<th rowspan="2" align="center">Mobile+</th>
					<th colspan="2" align="center">Outreach</th>
				</tr>
				<tr>
					<th align="center">Positive</th>
					<th align="center">Negative</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td>
						<span data-bind="text: '&emsp;'.repeat(Level == 'Nation' ? 0 : Level == 'Province' ? 1 : Level == 'OD' ? 2 : Level == 'HC' ? 3 : 4)"></span>
						<span data-bind="text: Level == 'OD' ? 'OD - ' : Level == 'HC' ? 'HF - ' : Level == 'Village' ? 'VL - ' : ''"></span>
						<span data-bind="text: $data[Level]"></span>
					</td>
					<td data-bind="text: VillageQty" align="center"></td>
					<td data-bind="text: Pop" align="center"></td>
					<td data-bind="text: Test" align="center"></td>
					<td data-bind="text: Positive" align="center"></td>
					<td data-bind="text: Negative" align="center"></td>
					<td data-bind="text: Pf" align="center"></td>
					<td data-bind="text: Pv" align="center"></td>
					<td data-bind="text: Mix" align="center"></td>
					<td data-bind="text: Pm" align="center"></td>
					<td data-bind="text: Po" align="center"></td>
					<td data-bind="text: Pk" align="center"></td>
					<td data-bind="text: Refered" align="center"></td>
					<td data-bind="text: Death" align="center"></td>
					<td data-bind="text: Treatment" align="center"></td>
					<td data-bind="text: MobileTest" align="center"></td>
					<td data-bind="text: MobilePositive" align="center"></td>
					<td data-bind="text: PositiveOutreach" align="center"></td>
					<td data-bind="text: NegativeOutreach" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: ['SP_V1_HFDataSummary','SP_V1_HFDataByVillage'].contain(report()) -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th rowspan="2">Place</th>
					<th rowspan="2" align="center">Village</th>
					<th rowspan="2" align="center">Pop</th>
					<th rowspan="2" align="center">Test</th>
					<th rowspan="2" align="center">Positive</th>
					<th rowspan="2" align="center">Negative</th>
					<th rowspan="2" align="center">Pf</th>
					<th rowspan="2" align="center">Pv</th>
					<th rowspan="2" align="center">Mix</th>
					<th rowspan="2" align="center">Pm</th>
					<th rowspan="2" align="center">Po</th>
					<th rowspan="2" align="center">Pk</th>
					<th rowspan="2" align="center">Refer</th>
					<th rowspan="2" align="center">Severe</th>
					<th rowspan="2" align="center">Death</th>
					<th colspan="6" align="center">ReACD</th>
				</tr>
				<tr>
					<th align="center">Positive</th>
					<th align="center">Negative</th>
					<th align="center">Pf</th>
					<th align="center">Pv</th>
					<th align="center">Mix</th>
					<th align="center" width="140">Unknown Species</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td>
						<span data-bind="text: '&emsp;'.repeat(Level == 'Nation' ? 0 : Level == 'Province' ? 1 : Level == 'OD' ? 2 : Level == 'HC' ? 3 : 4)"></span>
						<span data-bind="text: Level == 'OD' ? 'OD - ' : Level == 'HC' ? 'HF - ' : Level == 'Village' ? 'VL - ' : ''"></span>
						<span data-bind="text: $data[Level]"></span>
					</td>
					<td data-bind="text: VillageQty" align="center"></td>
					<td data-bind="text: Pop" align="center"></td>
					<td data-bind="text: Test" align="center"></td>
					<td data-bind="text: Positive" align="center"></td>
					<td data-bind="text: Negative" align="center"></td>
					<td data-bind="text: Pf" align="center"></td>
					<td data-bind="text: Pv" align="center"></td>
					<td data-bind="text: Mix" align="center"></td>
					<td data-bind="text: Pm" align="center"></td>
					<td data-bind="text: Po" align="center"></td>
					<td data-bind="text: Pk" align="center"></td>
					<td data-bind="text: Refered" align="center"></td>
					<td data-bind="text: Severe" align="center"></td>
					<td data-bind="text: Death" align="center"></td>
					<td data-bind="text: PositiveReacd" align="center"></td>
					<td data-bind="text: NegativeReacd" align="center"></td>
					<td data-bind="text: PfReacd" align="center"></td>
					<td data-bind="text: PvReacd" align="center"></td>
					<td data-bind="text: MixReacd" align="center"></td>
					<td data-bind="text: NoSpeciesReacd" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: ['SP_V1_VMWDataByMonth','SP_V1_HFDataByMonth','SP_V1_HFVMWDataByMonth','SP_V1_HFStockOut'].contain(report()) -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th align="center">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: $root.valueByMonth($parent, $index())" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: Total" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: ['SP_V1_VMWFingerprint','SP_V1_HFFingerprint'].contain(report()) -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<th align="center">Test</th>
					<th align="center">Negative</th>
					<th align="center">Positive</th>
					<th align="center">Fingerprint</th>
					<th align="center">RDT Image</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: { 'text-bold': $index() == 0, 'text-danger': $root.highlightFingerprint($data) }">
					<td>
						<span data-bind="text: '&emsp;'.repeat(Level == 'Nation' ? 0 : Level == 'Province' ? 1 : Level == 'OD' ? 2 : Level == 'HC' ? 3 : 4)"></span>
						<span data-bind="text: Level == 'OD' ? 'OD - ' : Level == 'HC' ? 'HF - ' : Level == 'Village' ? 'VL - ' : ''"></span>
						<span data-bind="text: $data[Level]"></span>
					</td>
					<td data-bind="text: Test" align="center"></td>
					<td data-bind="text: Negative" align="center"></td>
					<td data-bind="text: Positive" align="center"></td>
					<td data-bind="text: Fingerprint" align="center"></td>
					<td data-bind="text: RdtImage, click: $root.showRDTImage" align="center" class="underline"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_HFVMWTop10OD' -->
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th rowspan="2" valign="middle">Province</th>
					<th rowspan="2" valign="middle">OD</th>
					<th colspan="4" align="center" data-bind="text: year() - 1"></th>
					<th colspan="4" align="center" data-bind="text: year"></th>
				</tr>
				<tr>
					<th align="center" width="100">Pf</th>
					<th align="center" width="100">Pv</th>
					<th align="center" width="100">Mix</th>
					<th align="center" width="100">Total</th>
					<th align="center" width="100">Pf</th>
					<th align="center" width="100">Pv</th>
					<th align="center" width="100">Mix</th>
					<th align="center" width="100">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Pf1" align="center"></td>
					<td data-bind="text: Pv1" align="center"></td>
					<td data-bind="text: Mix1" align="center"></td>
					<td data-bind="text: Total1" align="center"></td>
					<td data-bind="text: Pf2" align="center"></td>
					<td data-bind="text: Pv2" align="center"></td>
					<td data-bind="text: Mix2" align="center"></td>
					<td data-bind="text: Total2" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_HFVMWTop30HF' -->
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th rowspan="2" valign="middle">Province</th>
					<th rowspan="2" valign="middle">OD</th>
					<th rowspan="2" valign="middle">HF</th>
					<th colspan="4" align="center" data-bind="text: year() - 1"></th>
					<th colspan="4" align="center" data-bind="text: year"></th>
				</tr>
				<tr>
					<th align="center" width="100">Pf</th>
					<th align="center" width="100">Pv</th>
					<th align="center" width="100">Mix</th>
					<th align="center" width="100">Total</th>
					<th align="center" width="100">Pf</th>
					<th align="center" width="100">Pv</th>
					<th align="center" width="100">Mix</th>
					<th align="center" width="100">Total</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Pf1" align="center"></td>
					<td data-bind="text: Pv1" align="center"></td>
					<td data-bind="text: Mix1" align="center"></td>
					<td data-bind="text: Total1" align="center"></td>
					<td data-bind="text: Pf2" align="center"></td>
					<td data-bind="text: Pv2" align="center"></td>
					<td data-bind="text: Mix2" align="center"></td>
					<td data-bind="text: Total2" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<div id="SP_V1_HFVMWTop30HFChart" data-bind="visible: report() == 'SP_V1_HFVMWTop30HFChart'">
			<div class="chart-container">
                <div id="chartTop10HFPie" style="height:600px"></div>
            </div>
			<hr />
			<div class="chart-container">
                <div id="chartTop30ByType" style="height:800px"></div>
                <div class="btn">
					<label class="checkbox-inline checkbox-sm">
						<input id="chartTop30ByTypeHF" type="checkbox" data-bind="click: drawChartTop30ByType" checked />
						<span>HF</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input id="chartTop30ByTypeVMW" type="checkbox" data-bind="click: drawChartTop30ByType" checked />
						<span>VMW</span>
					</label>
                </div>
            </div>
			<hr />
            <div class="chart-container">
                <div id="chartTop30BySpecie" style="height:800px"></div>
                <div class="btn">
                    <label class="checkbox-inline checkbox-sm">
						<input id="chartTop30BySpeciePf" type="checkbox" data-bind="click: drawChartTop30BySpecie" checked />
						<span>PF</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input id="chartTop30BySpeciePv" type="checkbox" data-bind="click: drawChartTop30BySpecie" checked />
						<span>PV</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input id="chartTop30BySpecieMix" type="checkbox" data-bind="click: drawChartTop30BySpecie" checked />
						<span>Mix</span>
					</label>
                </div>
            </div>
		</div>

		<div id="SP_V1_HFVMWTop30VillChart" data-bind="visible: report() == 'SP_V1_HFVMWTop30VillChart'">
			<div class="chart-container">
                <div id="chartTop10VillPie" style="height:600px"></div>
            </div>
			<hr />
            <div class="chart-container">
                <div id="chartTop30ByVill" style="height:800px"></div>
                <div class="btn">
                    <label class="checkbox-inline checkbox-sm">
						<input id="chartTop30ByVillPf" type="checkbox" data-bind="click: drawChartTop30ByVill" checked />
						<span>PF</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input id="chartTop30ByVillPv" type="checkbox" data-bind="click: drawChartTop30ByVill" checked />
						<span>PV</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input id="chartTop30ByVillMix" type="checkbox" data-bind="click: drawChartTop30ByVill" checked />
						<span>Mix</span>
					</label>
                </div>
            </div>
		</div>

		<!-- ko if: report() == 'SP_V1_HFVMWDataSummary' -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<th align="center">Village</th>
					<th align="center">Pop</th>
					<th align="center">Test</th>
					<th align="center">Positive</th>
					<th align="center">Negative</th>
					<th align="center">Pf</th>
					<th align="center">Pv</th>
					<th align="center">Mix</th>
					<th align="center">Pm</th>
					<th align="center">Po</th>
					<th align="center">Pk</th>
					<th align="center">HC Refer</th>
					<th align="center">VMW Refer</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td>
						<span data-bind="text: '&emsp;'.repeat(Level == 'Nation' ? 0 : Level == 'Province' ? 1 : Level == 'OD' ? 2 : Level == 'HC' ? 3 : 4)"></span>
						<span data-bind="text: Level == 'OD' ? 'OD - ' : Level == 'HC' ? 'HF - ' : Level == 'Village' ? 'VL - ' : ''"></span>
						<span data-bind="text: $data[Level]"></span>
					</td>
					<td data-bind="text: VillageQty" align="center"></td>
					<td data-bind="text: Pop" align="center"></td>
					<td data-bind="text: Test" align="center"></td>
					<td data-bind="text: Positive" align="center"></td>
					<td data-bind="text: Negative" align="center"></td>
					<td data-bind="text: Pf" align="center"></td>
					<td data-bind="text: Pv" align="center"></td>
					<td data-bind="text: Mix" align="center"></td>
					<td data-bind="text: Pm" align="center"></td>
					<td data-bind="text: Po" align="center"></td>
					<td data-bind="text: Pk" align="center"></td>
					<td data-bind="text: HCRefer" align="center"></td>
					<td data-bind="text: VMWRefer" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_HFVMWPvFollowup' -->
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th rowspan="2">Place</th>
					<th align="center" rowspan="2" class="text-nowrap">Pv + Mix</th>
					<th align="center" rowspan="2" class="text-nowrap">Eligible<br>G6PD Test</th>
					<th align="center" rowspan="2" class="text-nowrap">G6PD Test</th>
					<th align="center" rowspan="2">G6PD<br>Normal</th>
					<th align="center" rowspan="2">G6PD<br>Intermediate</th>
					<th align="center" rowspan="2">G6PD<br>Deficient</th>
					<th align="center" rowspan="2">Primaquine</th>
					<th align="center" colspan="3">Follow up</th>
					<th align="center" colspan="8">8 Weeks Follow up</th>
					<th align="center" rowspan="2">CSO</th>
				</tr>
				<tr>
					<th align="center" class="text-nowrap">Day 3</th>
					<th align="center" class="text-nowrap">Day 7</th>
					<th align="center" class="text-nowrap">Day 14</th>
					<th align="center" class="text-nowrap">Week 1</th>
					<th align="center" class="text-nowrap">Week 2</th>
					<th align="center" class="text-nowrap">Week 3</th>
					<th align="center" class="text-nowrap">Week 4</th>
					<th align="center" class="text-nowrap">Week 5</th>
					<th align="center" class="text-nowrap">Week 6</th>
					<th align="center" class="text-nowrap">Week 7</th>
					<th align="center" class="text-nowrap">Week 8</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place" class="text-nowrap"></td>
					<td data-bind="text: PvMix" align="center"></td>
					<td data-bind="text: EligibleG6PD" align="center"></td>
					<td data-bind="text: G6PDTest" align="center"></td>
					<td data-bind="text: Normal" align="center"></td>
					<td data-bind="text: Intermediate" align="center"></td>
					<td data-bind="text: Deficient" align="center"></td>
					<td data-bind="text: Primaquine" align="center"></td>
					<td data-bind="text: Day3" align="center"></td>
					<td data-bind="text: Day7" align="center"></td>
					<td data-bind="text: Day14" align="center"></td>
					<td data-bind="text: Week1" align="center"></td>
					<td data-bind="text: Week2" align="center"></td>
					<td data-bind="text: Week3" align="center"></td>
					<td data-bind="text: Week4" align="center"></td>
					<td data-bind="text: Week5" align="center"></td>
					<td data-bind="text: Week6" align="center"></td>
					<td data-bind="text: Week7" align="center"></td>
					<td data-bind="text: Week8" align="center"></td>
					<td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->
        
        <div style="display:none" data-bind="visible: report() == 'SP_V1_HFVMWRACD'" class="chart-container">
            <div id="mapRacd" class="chartbox no-margin" style="height:900px"></div>
		</div>

		<!-- ko if: report() == 'SP_V1_IntensificationPlan' -->
			<!-- ko if: listModel().length > 0 -->
			<table class="table table-bordered table-hover widthauto text-nowrap">
				<thead data-bind="with: SP_V1_IntensificationPlan_header">
					<tr>
						<th colspan="5">Implementing</th>
						<!-- ko foreach: csos -->
						<th align="center" data-bind="text: name, attr: { colspan: colspan }"></th>
						<!-- /ko -->
					</tr>
					<tr>
						<th colspan="5">Province</th>
						<!-- ko foreach: pvs -->
						<th align="center" data-bind="text: name, attr: { colspan: colspan }"></th>
						<!-- /ko -->
					</tr>
					<tr>
						<th colspan="5">OD</th>
						<!-- ko foreach: ods -->
						<th align="center" data-bind="text: name, attr: { colspan: colspan }"></th>
						<!-- /ko -->
					</tr>
					<tr>
						<th colspan="3">Health Center</th>
						<th>Comments</th>
						<th align="center">Data in MIS</th>
						<!-- ko foreach: hfs -->
						<th align="center" data-bind="text: $data"></th>
						<!-- /ko -->
					</tr>
				</thead>
				<tbody data-bind="fixedHeader: true">
					<tr class="bg-info">
						<th rowspan="20" class="rotate90 bg-warning"><div>Impact Indicators</div></th>
						<th rowspan="4" class="rotate90"><div>Testing</div></th>
						<th># Total Tests (HC+VMW+MMW_IP)</th>
						<th>Total tests by Point of Care</th>
						<th align="center">Yes</th>
						<!-- ko foreach: listModel -->
						<th align="center" data-bind="text: TestAll"></th>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># Total Tests from HC</td>
						<td>Total tests by HC</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: TestHC"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># Total Tests from VMW (VMW Role)</td>
						<td>Total tests by VMW</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: TestVMW"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># Total Tests from MMW (Active+Passive Case Detection) +VMW add Role as MMW</td>
						<td>Total tests by  both Active and Passive case detection in IP MMW</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: TestMMW"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<th rowspan="4" class="rotate90"><div>Cases</div></th>
						<th>Total tests by both Active and Passive case detection in IP MMW</th>
						<th>Total Cases by Point of Care</th>
						<th align="center">Yes</th>
						<!-- ko foreach: listModel -->
						<th align="center" data-bind="text: PositiveAll"></th>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># Positive Cases from HC</td>
						<td>Total Cases by HC</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: PositiveHC"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># Positive Cases from VMW (VMW Role)</td>
						<td>Total Cases by VMW</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: PositiveVMW"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># Positive Cases from MMW (Active + Passive Case Detection) + VMW add Role as MMW</td>
						<td>Total Cases by  both Active and Passive case detection in IP MMW</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: PositiveMMW"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<th rowspan="3" class="rotate90"><div>PV+PF+Mix</div></th>
						<td># Pf Cases (HC+VMW+MMW in IP+VMW upgraded role as MMW in IP)</td>
						<td>Total PF Cases by HC+VMW+IP MMW</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: Pf"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># Pv Cases (HC+VMW+MMW in IP+VMW upgraded role as MMW in IP)</td>
						<td>Total PV Cases by HC+VMW+IP MMW</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: Pv"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># Mix Cases (HC+VMW+MMW in IP+VMW upgraded role as MMW in IP)</td>
						<td>Total Mix Cases by HC+VMW+IP MMW</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: Mix"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<th class="rotate90"><div>SLDP</div></th>
						<td valign="middle"># Pf / Mix cases receiving Low Dose Primaquine</td>
						<td valign="middle">Filter <b>PF/Mix</b> and use <b>ACT (ASMQ+Primaquine)</b> ONLY by <b>HC+VMW+IP MMW</b></td>
						<td align="center" valign="middle">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" valign="middle" data-bind="text: PfMixAct"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<th rowspan="2" class="rotate90"><div>LLIN & LLIHN</div></th>
						<td valign="middle"># LLIN Distirbuted in Catchment Area This Month</td>
						<td></td>
						<td align="center" valign="middle">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" valign="middle" data-bind="text: LLIN"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td valign="middle"># LLIHN Distirbuted in Catchment Area This Month</td>
						<td></td>
						<td align="center" valign="middle">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" valign="middle" data-bind="text: LLIHN"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<th rowspan="6" class="rotate90"><div>MMW not in IP</div></th>
						<td># MMWs not in Intensification Plan (MC, HPA…)</td>
						<td></td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: MMWNotIP"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># Total Tests from MMW not in Intensification Plan</td>
						<td></td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: TestMMWNotIP"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># Positive Cases from MMWs not in Intensificaiton Plan</td>
						<td></td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: PositiveMMWNotIP"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># Pf Cases MMW not in IP</td>
						<td></td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: PfMMWNotIP"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># Pv Cases MMW not in IP</td>
						<td></td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: PvMMWNotIP"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># Mix Cases MMW not in IP</td>
						<td></td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: MixMMWNotIP"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<th rowspan="3" colspan="2" class="rotate90"><div>HCs</div></th>
						<td>1 Month of Stock (RDT&ACT) Available at HC for HC, VMW, and MMW?</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td>HC Data Entered in MIS?</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td>CSO visited HC this month (monthly meeting or supervision)?</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<th rowspan="4" colspan="2" class="rotate90"><div>VMWs</div></th>
						<td># VMWs Active</td>
						<td>Total Number of VMW</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: VMW"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td>VMW Monthly Meeting Occurred?</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># VMWs Attending Monthly Meeting</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-success">
						<td># VMW Reports in MIS</td>
						<td>Count reporting rate in HC by villages</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: VMWReported + '%'"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<th rowspan="10" colspan="2" class="rotate90"><div>MMWs and MMPs</div></th>
						<td># MMWs IP Active</td>
						<td>Total Number of MMW IP</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: MMW"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># MMWs+VMW add as MMW in IP Attending Monthly Meeting</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># MMWs Report in MIS</td>
						<td>Count reporting rate in HC by villages IP</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td align="center" data-bind="text: MMWReported + '%'"></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info text-danger">
						<td># Active Case Detection Visits Conducted by MMWs + VMW add as MMW in IP</td>
						<td>Count report in Questionair &gt; MMW Active Screen &gt; Number Outreach</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info text-danger">
						<td># People Screened via Active Case Detection by MMWs + VMW add as MMW in IP</td>
						<td>Sum tests in Questionair &gt; MMW Active Screen>Detail &gt; Tested by area</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info text-danger">
						<td># Positive Cases via Active Case Detection by MMWs + VMW add as MMW in IP</td>
						<td>Sum cases in Questionair &gt; MMW Active Screen>Detail &gt; Positive by area</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># Active Case Detection forms entered into MIS by MMWs + VMW add as MMW in IP</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># MMP questionnaires conducted by HC entered into MIS</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info">
						<td># Forest pack questionnaires conducted by MMWs entered into MIS</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr class="bg-info text-danger">
						<td># Forest Packs Distributed and enter in MIS</td>
						<td>Count reporting rate by villages</td>
						<td align="center">Yes</td>
						<!-- ko foreach: listModel -->
						<td></td>
						<!-- /ko -->
					</tr>
					<tr>
						<td colspan="2"></td>
						<td>MMWs/VMW Payment Status?</td>
						<td></td>
						<td align="center">No</td>
						<!-- ko foreach: listModel -->
						<td align="center">Paid Same Day</td>
						<!-- /ko -->
					</tr>
				</tbody>
			</table>
			<!-- /ko -->
			<!-- ko if: listModel().length == 0 -->
			<h2 class="text-warning text-center">No Data</h2>
			<!-- /ko -->
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_BedNetReport' -->
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th rowspan="2">Location</th>
					<th align="center" rowspan="2">Distributed Villages</th>
					<th align="center" colspan="4" data-bind="visible: bednetType() == 'all'">Total</th>
					<th align="center" colspan="6" data-bind="visible: bednetType().in('all','campaign')">Campaign</th>
					<th align="center" colspan="4" data-bind="visible: bednetType().in('all','mobile')">Mobile</th>
					<th align="center" colspan="4" data-bind="visible: bednetType().in('all','continue')">Continue</th>
				</tr>
				<tr>
					<!-- ko if: bednetType() == 'all' -->
					<th align="center" width="90">LLIN</th>
					<th align="center" width="90">LLIHN</th>
					<th align="center" width="90">Pregnancy</th>
					<th align="center" width="90">HammokNet</th>
					<!-- /ko -->
					<!-- ko if: bednetType().in('all','campaign') -->
					<th align="center" width="90">LLIN</th>
					<th align="center" width="100">Target Pop</th>
					<th align="center" width="90">Coverage</th>
					<th align="center" width="90">LLIHN</th>
					<th align="center" width="90">Pregnancy</th>
					<th align="center" width="90">HammokNet</th>
					<!-- /ko -->
					<!-- ko if: bednetType().in('all','mobile') -->
					<th align="center" width="90">LLIN</th>
					<th align="center" width="90">LLIHN</th>
					<th align="center" width="90">Pregnancy</th>
					<th align="center" width="90">HammokNet</th>
					<!-- /ko -->
					<!-- ko if: bednetType().in('all','continue') -->
					<th align="center" width="90">LLIN</th>
					<th align="center" width="90">LLIHN</th>
					<th align="center" width="90">Pregnancy</th>
					<th align="center" width="90">HammokNet</th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td>
						<span data-bind="text: '&emsp;'.repeat(Level == 'Nation' ? 0 : Level == 'Province' ? 1 : Level == 'OD' ? 2 : Level == 'HC' ? 3 : 4)"></span>
						<span data-bind="text: Level == 'OD' ? 'OD - ' : Level == 'HC' ? 'HF - ' : Level == 'Village' ? 'VL - ' : ''"></span>
						<span data-bind="text: $data[Level]"></span>
					</td>
					<td data-bind="text: ReportedVillage" align="center"></td>

					<td data-bind="text: LLIN, visible: $root.bednetType() == 'all'" align="center"></td>
					<td data-bind="text: LLIHN, visible: $root.bednetType() == 'all'" align="center"></td>
					<td data-bind="text: Pregnancy, visible: $root.bednetType() == 'all'" align="center"></td>
					<td data-bind="text: HammokNet, visible: $root.bednetType() == 'all'" align="center"></td>

					<td data-bind="text: LLINCampaign, visible: $root.bednetType().in('all','campaign')" align="center"></td>
					<td data-bind="text: Target, visible: $root.bednetType().in('all','campaign')" align="center"></td>
					<td data-bind="text: (Target == 0 ? 0 : LLINCampaign * 180 / Target).toFixed(0) + '%', visible: $root.bednetType().in('all','campaign')" align="center"></td>
					<td data-bind="text: LLIHNCampaign, visible: $root.bednetType().in('all','campaign')" align="center"></td>
					<td data-bind="text: PregnancyCampaign, visible: $root.bednetType().in('all','campaign')" align="center"></td>
					<td data-bind="text: HammokNetCampaign, visible: $root.bednetType().in('all','campaign')" align="center"></td>

					<td data-bind="text: LLINMobile, visible: $root.bednetType().in('all','mobile')" align="center"></td>
					<td data-bind="text: LLIHNMobile, visible: $root.bednetType().in('all','mobile')" align="center"></td>
					<td data-bind="text: PregnancyMobile, visible: $root.bednetType().in('all','mobile')" align="center"></td>
					<td data-bind="text: HammokNetMobile, visible: $root.bednetType().in('all','mobile')" align="center"></td>

					<td data-bind="text: LLINContinued, visible: $root.bednetType().in('all','continue')" align="center"></td>
					<td data-bind="text: LLIHNContinued, visible: $root.bednetType().in('all','continue')" align="center"></td>
					<td data-bind="text: PregnancyContinued, visible: $root.bednetType().in('all','continue')" align="center"></td>
					<td data-bind="text: HammokNetContinued, visible: $root.bednetType().in('all','continue')" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_PercentPopLLIN' -->
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th width="300">Place</th>
					<th align="center">Percentage</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<td data-bind="text: Percentage + '%'" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_Investigation' -->
		<table class="table table-bordered table-striped table-hover widthauto text-nowrap">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
                    <th rowspan="2">OD</th>
                    <th rowspan="2" data-bind="visible: od() != null">HF</th>
                    <th rowspan="2" data-bind="visible: hc() != null">Village</th>
					<th rowspan="2" align="center">Positive</th>
					<th rowspan="2" align="center">PF + Mix</th>
                    <th rowspan="2" align="center" width="60">PV</th>
                    <th rowspan="2" align="center">PM + PO + PK</th>
					<th rowspan="2" align="center">Investigated</th>
					<th rowspan="2" align="center">Relapse</th>
					<th colspan="3" align="center">L1</th>
					<th colspan="3" align="center">LC</th>
					<th rowspan="2" align="center" width="60">IMP</th>
					<th rowspan="2" align="center">Eligible<br />ReACD</th>
					<th rowspan="2" align="center">ReACD</th>
					<th rowspan="2" align="center">Eligible<br />Foci</th>
					<th rowspan="2" align="center">Foci<br />Inv</th>
					<th rowspan="2" align="center">Detail</th>
				</tr>
				<tr>
					<th align="center">PF + Mix</th>
					<th align="center" width="60">PV</th>
					<th align="center">PM + PO + PK</th>
					<th align="center">PF + Mix</th>
					<th align="center" width="60">PV</th>
					<th align="center">PM + PO + PK</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true, fixedColumn: 4">
				<tr data-bind="css: {'text-bold': $index() == 0}">
                    <td data-bind="text: Province"></td>
                    <td data-bind="text: OD"></td>
                    <td data-bind="text: HF, visible: $root.od() != null"></td>
                    <td data-bind="text: Village, visible: $root.hc() != null, css: { kh: iskhmer(Village) }"></td>
					<td data-bind="text: Positive" align="center"></td>
					<td data-bind="text: PfMix" align="center"></td>
                    <td data-bind="text: Pv" align="center"></td>
					<td data-bind="text: PmPoPk" align="center"></td>
					<td data-bind="text: Investigated + ' (' + (Investigated * 100 / (PfMix + Pv + PmPoPk)).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: Relapse" align="center"></td>
					<td data-bind="text: L1PfMix" align="center"></td>
					<td data-bind="text: L1Pv" align="center"></td>
					<td data-bind="text: L1PmPoPk" align="center"></td>
					<td data-bind="text: LCPfMix" align="center"></td>
					<td data-bind="text: LCPv" align="center"></td>
					<td data-bind="text: LCPmPoPk" align="center"></td>
					<td data-bind="text: IMP" align="center"></td>
					<td data-bind="text: RacdNeed" align="center"></td>
					<td data-bind="text: Racd + ' (' + (RacdNeed == 0 ? 100 : (Racd * 100 / RacdNeed)).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: FociNeed" align="center"></td>
					<td data-bind="text: Foci + ' (' + (FociNeed == 0 ? 100 : (Foci * 100 / FociNeed)).toFixed(0) + '%)'" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showInvestPopup">Detail</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_InvestigationRai4' -->
		<table class="table table-bordered table-striped table-hover widthauto text-nowrap">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
                    <th rowspan="2">OD</th>
                    <th rowspan="2" data-bind="visible: od() != null">HF</th>
                    <th rowspan="2" data-bind="visible: hc() != null">Village</th>
					<th rowspan="2" align="center">Positive</th>
					<th rowspan="2" align="center">PF + Mix</th>
                    <th rowspan="2" align="center" width="60">PV</th>
                    <th rowspan="2" align="center">PM + PO + PK</th>
					<th rowspan="2" align="center">Investigated</th>
					<th colspan="3" align="center">Relapse/Recrudecent</th>
					<th colspan="3" align="center">Locally Aquired</th>
					<th colspan="3" align="center">Domestically Imported</th>
					<th colspan="3" align="center">Internationally Imported</th>
					<th colspan="3" align="center">Induced</th>
					<th rowspan="2" align="center">Eligible<br>ReACD</th>
					<th rowspan="2" align="center">ReACD</th>
					<th rowspan="2" align="center">Eligible<br>Foci</th>
					<th rowspan="2" align="center">Foci<br>Inv</th>
					<th rowspan="2" align="center">Foci 7D<br>Response</th>
					<th rowspan="2" align="center">Detail</th>
				</tr>
				<tr data-bind="foreach: Array(5)">
					<th align="center">PF + Mix</th>
					<th align="center" width="60">PV</th>
					<th align="center">PM + PO + PK</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true, fixedColumn: 4">
				<tr data-bind="css: {'text-bold': $index() == 0}">
                    <td data-bind="text: Province"></td>
                    <td data-bind="text: OD"></td>
                    <td data-bind="text: HF, visible: $root.od() != null"></td>
                    <td data-bind="text: Village, visible: $root.hc() != null, css: { kh: iskhmer(Village) }"></td>
					<td data-bind="text: Positive" align="center"></td>
					<td data-bind="text: PfMix" align="center"></td>
                    <td data-bind="text: Pv" align="center"></td>
					<td data-bind="text: PmPoPk" align="center"></td>
					<td data-bind="text: Investigated + ' (' + (Investigated * 100 / (PfMix + Pv + PmPoPk)).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: RelapsePfMix" align="center"></td>
					<td data-bind="text: RelapsePv" align="center"></td>
					<td data-bind="text: RelapsePmPoPk" align="center"></td>
					<td data-bind="text: L1PfMix" align="center"></td>
					<td data-bind="text: L1Pv" align="center"></td>
					<td data-bind="text: L1PmPoPk" align="center"></td>
					<td data-bind="text: LCPfMix" align="center"></td>
					<td data-bind="text: LCPv" align="center"></td>
					<td data-bind="text: LCPmPoPk" align="center"></td>
					<td data-bind="text: IMPPfMix" align="center"></td>
					<td data-bind="text: IMPPv" align="center"></td>
					<td data-bind="text: IMPPmPoPk" align="center"></td>
					<td data-bind="text: InducePfMix" align="center"></td>
					<td data-bind="text: InducePv" align="center"></td>
					<td data-bind="text: InducePmPoPk" align="center"></td>
					<td data-bind="text: RacdNeed" align="center"></td>
					<td data-bind="text: Racd + ' (' + (RacdNeed == 0 ? 100 : (Racd * 100 / RacdNeed)).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: FociNeed" align="center"></td>
					<td data-bind="text: Foci + ' (' + (FociNeed == 0 ? 100 : (Foci * 100 / FociNeed)).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: Foci7d + ' (' + (FociNeed == 0 ? 100 : (Foci7d * 100 / FociNeed)).toFixed(0) + '%)'" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showInvestPopupRai4">Detail</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_MnEElimination' -->
		<table class="table table-bordered table-striped table-hover widthauto text-nowrap">
			<thead>
				<tr>
					<th rowspan="3">Province</th>
					<th rowspan="3">OD</th>
                    <th rowspan="3" data-bind="visible: od() != null">HF</th>
                    <th rowspan="3" data-bind="visible: hc() != null">Village</th>
					<th rowspan="3" align="center">Positive</th>
					<th rowspan="3" align="center">PF</th>
					<th rowspan="3" align="center">Mix</th>
					<th rowspan="3" align="center">PV</th>
					<th rowspan="3" align="center">PM</th>
					<th rowspan="3" align="center">PO</th>
					<th rowspan="3" align="center">PK</th>
					<th rowspan="3" align="center">Notfiy/Classify</th>
					<th rowspan="3">Notify/Classify&lt;24h</th>
					<th rowspan="3">Relapse</th>
					<th colspan="6" rowspan="2" align="center">L1</th>
					<th colspan="6" rowspan="2" align="center">LC</th>
					<th rowspan="3" align="center">IMP</th>
					<th rowspan="3" align="center">Eligible<br>RACD</th>
					<th rowspan="3" align="center">RACD</th>
					<th rowspan="3" align="center">RACD&lt;3D</th>
					<th rowspan="3" align="center">Eligible<br>Foci</th>
					<th rowspan="3" align="center">Foci<br>Inv</th>
					<th rowspan="3" align="center">Foci<br>Inv&lt;7D</th>
					<th colspan="10" align="center">Foci Response</th>
				</tr>
				<tr>
					<th rowspan="2" align="center">%</th>
					<th colspan="4" align="center">Classify</th>
					<th colspan="5" align="center">Intervention</th>
				</tr>
				<tr>
					<th align="center">PF</th>
					<th align="center">Mix</th>
					<th align="center">PV</th>
					<th align="center">PM</th>
					<th align="center">PO</th>
					<th align="center">PK</th>
					<th align="center">PF</th>
					<th align="center">Mix</th>
					<th align="center">PV</th>
					<th align="center">PM</th>
					<th align="center">PO</th>
					<th align="center">PK</th>
					<th align="center">R0V0</th>
					<th align="center">R0V1</th>
					<th align="center">R1V0</th>
					<th align="center">R1V1</th>
					<th align="center">VMW</th>
					<th align="center">INT</th>
					<th align="center">TDA</th>
					<th align="center">AFS</th>
					<th align="center">IPT</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true, fixedColumn: 4">
				<tr data-bind="css: { 'text-bold': $index() == 0 }">
					<td data-bind="text: Province"></td>
					<td data-bind="text: OD"></td>
                    <td data-bind="text: HF, visible: $root.od() != null"></td>
                    <td data-bind="text: Village, visible: $root.hc() != null, css: { kh: iskhmer(Village) }"></td>
					<td align="center" data-bind="text: Positive"></td>
					<td align="center" data-bind="text: Pf"></td>
					<td align="center" data-bind="text: Mix"></td>
					<td align="center" data-bind="text: Pv"></td>
					<td align="center" data-bind="text: Pm"></td>
					<td align="center" data-bind="text: Po"></td>
					<td align="center" data-bind="text: Pk"></td>
					<td align="center" data-bind="text: Classify + ' (' + (Classify * 100 / Positive).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: Notify24 + ' (' + (Notify24 * 100 / Positive).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: Relapse"></td>
					<td align="center" data-bind="text: L1Pf"></td>
					<td align="center" data-bind="text: L1Mix"></td>
					<td align="center" data-bind="text: L1Pv"></td>
					<td align="center" data-bind="text: L1Pm"></td>
					<td align="center" data-bind="text: L1Po"></td>
					<td align="center" data-bind="text: L1Pk"></td>
					<td align="center" data-bind="text: LCPf"></td>
					<td align="center" data-bind="text: LCMix"></td>
					<td align="center" data-bind="text: LCPv"></td>
					<td align="center" data-bind="text: LCPm"><td>
					<td align="center" data-bind="text: LCPo"></td>
					<td align="center" data-bind="text: LCPk"></td>
					<td align="center" data-bind="text: IMP"></td>
					<td align="center" data-bind="text: RacdNeed"></td>
					<td align="center" data-bind="text: Racd + ' (' + (RacdNeed == 0 ? 100 : Racd * 100 / RacdNeed).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: Racd3d + ' (' + (RacdNeed == 0 ? 100 : Racd3d * 100 / RacdNeed).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: FociNeed"></td>
					<td align="center" data-bind="text: Foci + ' (' + (FociNeed == 0 ? 100 : Foci * 100 / FociNeed).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: Foci7d + ' (' + (FociNeed == 0 ? 100 : Foci7d * 100 / FociNeed).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: R0V0"></td>
					<td align="center" data-bind="text: R0V1"></td>
					<td align="center" data-bind="text: R1V0"></td>
					<td align="center" data-bind="text: R1V1"></td>
					<td align="center" data-bind="text: VMW"></td>
					<td align="center" data-bind="text: INT"></td>
					<td align="center" data-bind="text: TDA"></td>
					<td align="center" data-bind="text: AFS"></td>
					<td align="center" data-bind="text: IPT"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_MnEEliminationRai4' -->
		<table class="table table-bordered table-hover widthauto text-nowrap">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
                    <th rowspan="2" data-bind="visible: od() != null">HF</th>
                    <th rowspan="2" data-bind="visible: hc() != null">Village</th>
					<th rowspan="2" align="center">Positive</th>
					<th rowspan="2" align="center">PF</th>
					<th rowspan="2" align="center">Mix</th>
					<th rowspan="2" align="center">PV</th>
					<th rowspan="2" align="center">PM</th>
					<th rowspan="2" align="center">PO</th>
					<th rowspan="2" align="center">PK</th>
					<th rowspan="2" align="center">Notfiy/<br>Classify</th>
					<th rowspan="2" align="center">Notify/<br>Classify &lt; 24h</th>
					<th colspan="6" align="center">Relapse/Recrudecent</th>
					<th colspan="6" align="center" class="success">Locally Aquired</th>
					<th colspan="6" align="center">Domestically Imported</th>
					<th colspan="6" align="center" class="success">Internationally Imported</th>
					<th colspan="6" align="center">Induced</th>
					<th rowspan="2" align="center">Eligible<br>RACD</th>
					<th rowspan="2" align="center">RACD</th>
					<th rowspan="2" align="center">RACD &lt; 3D</th>
					<th rowspan="2" align="center">Eligible<br>Foci</th>
					<th rowspan="2" align="center">Foci<br>Inv</th>
					<th rowspan="2" align="center">Foci 7D<br>Response</th>
				</tr>
				<tr data-bind="foreach: Array(5)">
					<th align="center" data-bind="css: { success: $index().in(1,3) }">PF</th>
					<th align="center" data-bind="css: { success: $index().in(1,3) }">Mix</th>
					<th align="center" data-bind="css: { success: $index().in(1,3) }">PV</th>
					<th align="center" data-bind="css: { success: $index().in(1,3) }">PM</th>
					<th align="center" data-bind="css: { success: $index().in(1,3) }">PO</th>
					<th align="center" data-bind="css: { success: $index().in(1,3) }">PK</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true, fixedColumn: 4">
				<tr data-bind="css: { 'text-bold': $index() == 0 }">
					<td data-bind="text: Province"></td>
					<td data-bind="text: OD"></td>
                    <td data-bind="text: HF, visible: $root.od() != null"></td>
                    <td data-bind="text: Village, visible: $root.hc() != null, css: { kh: iskhmer(Village) }"></td>
					<td align="center" data-bind="text: Positive"></td>
					<td align="center" data-bind="text: Pf"></td>
					<td align="center" data-bind="text: Mix"></td>
					<td align="center" data-bind="text: Pv"></td>
					<td align="center" data-bind="text: Pm"></td>
					<td align="center" data-bind="text: Po"></td>
					<td align="center" data-bind="text: Pk"></td>
					<td align="center" data-bind="text: Classify + ' (' + (Classify * 100 / Positive).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: Notify24 + ' (' + (Notify24 * 100 / Positive).toFixed(0) + '%)'"></td>
					<!-- ko foreach: ['Relapse','L1','LC','IMP','Induce'] -->
					<td align="center" data-bind="text: $parent[$data + 'Pf'], css: { success: $index().in(1,3) }"></td>
					<td align="center" data-bind="text: $parent[$data + 'Mix'], css: { success: $index().in(1,3) }"></td>
					<td align="center" data-bind="text: $parent[$data + 'Pv'], css: { success: $index().in(1,3) }"></td>
					<td align="center" data-bind="text: $parent[$data + 'Pm'], css: { success: $index().in(1,3) }"></td>
					<td align="center" data-bind="text: $parent[$data + 'Po'], css: { success: $index().in(1,3) }"></td>
					<td align="center" data-bind="text: $parent[$data + 'Pk'], css: { success: $index().in(1,3) }"></td>
					<!-- /ko -->
					<td align="center" data-bind="text: RacdNeed"></td>
					<td align="center" data-bind="text: Racd + ' (' + (RacdNeed == 0 ? 100 : Racd * 100 / RacdNeed).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: Racd3d + ' (' + (RacdNeed == 0 ? 100 : Racd3d * 100 / RacdNeed).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: FociNeed"></td>
					<td align="center" data-bind="text: Foci + ' (' + (FociNeed == 0 ? 100 : Foci * 100 / FociNeed).toFixed(0) + '%)'"></td>
					<td align="center" data-bind="text: Foci7d + ' (' + (FociNeed == 0 ? 100 : Foci7d * 100 / FociNeed).toFixed(0) + '%)'"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_RadicalCureHSD' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<th>Positive</th>
					<th>PV + Mix</th>
					<th>PV + Mix (HF)</th>
					<th>PV + Mix (VMW)</th>
					<th>G6PD Test</th>
					<th>PQ14 Treatment</th>
					<th>G6PD Normal</th>
					<th>Follow up</th>
					<th>Refered (PV + Mix)</th>
					<th>VMW Case with G6PD</th>
					<th>VMW Case without G6PD</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td>
						<span data-bind="text: '&emsp;'.repeat(Level == 'All' ? 0 : Level == 'HF' ? 1 : Level == 'Village' ? 2 : 3)"></span>
						<span data-bind="text: Level == 'HF' ? 'HF - ' : Level == 'Village' ? 'VL - ' : ''"></span>
						<span data-bind="text: $data[Level]"></span>
					</td>
					<!--<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>-->
					<td data-bind="text: Positive"></td>
					<td data-bind="text: VM"></td>
					<td data-bind="text: VMHF"></td>
					<td data-bind="text: VMVMW"></td>
					<td data-bind="text: G6PDTest"></td>
					<td data-bind="text: PQ14"></td>
					<td data-bind="text: G6PDNormal"></td>
					<td data-bind="text: FollowUp"></td>
					<td data-bind="text: VMRefered"></td>
					<td data-bind="text: VMWG6PD"></td>
					<td data-bind="text: VMWNoG6PD"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: report() == 'SP_V1_Proactive2' && type() == 'list' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Province</th>
					<th>OD</th>
					<th>HC</th>
					<th>Village</th>
                    <th>Positive last 2 months</th>
                    <th>Vector last 6 months</th>
                    <th>Forest</th>
                    <th>L1 Last 2 Months</th>
                    <th>Total Score</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
                    <td data-bind="text: Positive"></td>
                    <td data-bind="text: Vector"></td>
                    <td data-bind="text: Forest.toFixed(2)"></td>
                    <td data-bind="text: L1 + '( Reactive: '+ Reactive +' )'"></td>
                    <td data-bind="text: TotalScore.toFixed(2)"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
        <br />
        <div>
            <b>Notice</b>: Posive = 20%, L1 = 30%, Forest = 25%, Vector = 25%
        </div>
		<!-- /ko -->

        <div style="display:none" data-bind="visible: report() == 'SP_V1_Proactive2' && type() == 'map'" class="chart-container">
            <div id="mapProactive" class="chartbox no-margin" style="height:900px"></div>
		</div>

		<!-- ko if: report() == 'SP_V1_StockODCompleteness' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th align="center">CSO</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: isnot($root.valueByMonth($parent, $index()), '', r => r + '%'), style: {backgroundColor: $root.bgWarning($parent, $index())}" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: ['SP_V1_StockHFCompleteness','SP_V1_VMWCommodityCompleteness'].contain(report()) -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
					<th align="center">CSO</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: isnot($root.valueByMonth($parent, $index()), '', r => r + '%'), style: {backgroundColor: $root.bgWarning($parent, $index())}" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: report() == 'SP_V1_StockOD' -->
        <table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">Code</th>
					<th align="center" width="300">Description</th>
                    <th align="center">Strength</th>
                    <th align="center">Unit</th>
                    <th align="center" class="kh">ចំនួនសល់ពីមុន</th>
                    <th align="center" class="kh">ចំនួនចូល</th>
                    <th align="center" class="kh">សរុប</th>
                    <th align="center" class="kh">ចំនួនចេញ</th>
                    <th align="center" class="kh">ចំនួនកែតំរូវ</th>
                    <th align="center" class="kh">តុល្យាការ</th>
                    <th align="center" class="kh">ចំនួនស្នើ</th>
					<th align="center">Expiration</th>
                    <th align="center">AMC</th>
					<th align="center">MOS</th>
					<th align="center">Note</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Province"></td>
					<td data-bind="text: OD"></td>
					<td data-bind="text: Code"></td>
					<td data-bind="text: Description"></td>
                    <td data-bind="text: Strength"></td>
                    <td data-bind="text: Unit"></td>
                    <td data-bind="text: StockStart"></td>
                    <td data-bind="text: StockIn"></td>
                    <td data-bind="text: StockStart + StockIn"></td>
                    <td data-bind="text: StockOut"></td>
                    <td data-bind="text: Adjustment"></td>
                    <td data-bind="text: Balance"></td>
                    <td data-bind="text: Request == null ? 'N/A' : Request"></td>
                    <td data-bind="text: $root.mergeExpire(ExpireDetail)" class="text-nowrap"></td>
                    <td data-bind="text: AMC == null ? 'N/A' : parseFloat(AMC).toFixed(1)"></td>
					<td data-bind="text: AMC == null || AMC == 0 ? 'N/A' : parseFloat(Balance / AMC).toFixed(1)"></td>
                    <td data-bind="text: Note"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
        <!-- /ko -->

        <!-- ko if: report() == 'SP_V1_StockHC' -->
        <table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HF</th>
					<th align="center">Code</th>
					<th align="center" width="300">Description</th>
                    <th align="center">Strength</th>
                    <th align="center">Unit</th>
					<th align="center" class="kh">ចំនួនសល់ពីមុន</th>
                    <th align="center" class="kh">ចំនួនចូល</th>
                    <th align="center" class="kh">សរុប</th>
                    <th align="center" class="kh">ចំនួនចេញ</th>
                    <th align="center" class="kh">ចំនួនកែតំរូវ</th>
                    <th align="center" class="kh">តុល្យាការ</th>
					<th align="center">Expiration</th>
                    <th align="center">AMC</th>
					<th align="center">MOS</th>
					<th align="center">Note</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Province"></td>
					<td data-bind="text: OD"></td>
					<td data-bind="text: HF"></td>
					<td data-bind="text: Code"></td>
					<td data-bind="text: Description"></td>
                    <td data-bind="text: Strength"></td>
                    <td data-bind="text: Unit"></td>
                    <td data-bind="text: StockStart"></td>
                    <td data-bind="text: StockIn"></td>
                    <td data-bind="text: StockStart + StockIn"></td>
                    <td data-bind="text: StockOut"></td>
                    <td data-bind="text: Adjustment"></td>
                    <td data-bind="text: Balance"></td>
                    <td data-bind="text: $root.mergeExpire(ExpireDetail)" class="text-nowrap"></td>
                    <td data-bind="text: AMC == null ? 'N/A' : parseFloat(AMC).toFixed(1)"></td>
					<td data-bind="text: AMC == null || AMC == 0 ? 'N/A' : parseFloat(Balance / AMC).toFixed(1)"></td>
                    <td data-bind="text: Note"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
        <!-- /ko -->

        <!-- ko if: report() == 'SP_V1_VMWCommodity' -->
        <table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HF</th>
					<th align="center">Village</th>
					<th align="center" width="300">Name</th>
					<th align="center" class="kh">ចំនួនសល់ពីមុន</th>
                    <th align="center" class="kh">ចំនួនចូល</th>
                    <th align="center" class="kh">សរុប</th> 
                    <th align="center" class="kh">ចំនួនចេញ</th>
                    <th align="center" class="kh">តុល្យាការ</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Province"></td>
					<td data-bind="text: OD"></td>
					<td data-bind="text: HF"></td>
                    <td data-bind="text: Vill"></td>
					<td data-bind="text: Name"></td>
                    <td data-bind="text: StockStart"></td>
                    <td data-bind="text: StockIn"></td>
                    <td data-bind="text: StockStart + StockIn"></td>
                    <td data-bind="text: StockOut"></td>
                    <td data-bind="text: Balance"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
        <!-- /ko -->

		<!-- ko if: report() == 'SP_V1_PrimaquineDistribution' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Health Facility</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">Total Distribution</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">Needs (7.5mg)</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">OD Buffer (3 months stock)</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">HC Buffer (1 month stock)</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">Minimum Stock</th>
				</tr>
				<tr>
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E" class="text-nowrap"></td>
					<td data-bind="text: Name_OD_E" class="text-nowrap"></td>
					<td data-bind="text: Name_Facility_E" class="text-nowrap"></td>
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: $parent['N' + $data] + ($parent['B' + $data] * 4) + ($parent['N' + $data] + $parent['B' + $data] < 10 ? 10 : 0),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: $parent['N' + $data],
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: $parent['B' + $data] * 3,
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: $parent['B' + $data],
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: $parent['N' + $data] + $parent['B' + $data] < 10 ? 10 : 0,
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_Primaquine' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Health Facility</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">Total</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">Primaquine 7.5 mg Needs</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">HC Buffer (1 month stock)</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">OD Buffer (3 months stock)</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">Central Buffer (6 month stock)</th>
				</tr>
				<tr>
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E" class="text-nowrap"></td>
					<td data-bind="text: Name_OD_E" class="text-nowrap"></td>
					<td data-bind="text: Name_Facility_E" class="text-nowrap"></td>
					
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data]) * 10,
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data]),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data] * $root.primaquineV2().minHF()),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data] * $root.primaquineV2().minOD()),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data] * $root.primaquineV2().minCMS()),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_G6PD' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">Health Facility</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">Total</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">G6PD Needs</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">HC Buffer (1 month stock)</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">OD Buffer (3 months stock)</th>
					<th rowspan="2" class="no-border">&emsp;</th>
					<th data-bind="attr: { colspan: monthTo() + 1 - monthFrom() }" align="center">Central Buffer (6 month stock)</th>
				</tr>
				<tr>
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
					<!-- ko foreach: monthNum -->
					<th data-bind="text: moment($data, 'M').format('MMM'), visible: $root.visibleMonth($data)" align="center"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E" class="text-nowrap"></td>
					<td data-bind="text: Name_OD_E" class="text-nowrap"></td>
					<td data-bind="text: Name_Facility_E" class="text-nowrap"></td>
					
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data]) * 10,
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data]),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data] * $root.G6PD().minHF()),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data] * $root.G6PD().minOD()),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
					<td class="no-border"></td>
					<!-- ko foreach: $root.monthNum -->
					<td data-bind="text: _.ceil($parent['N' + $data] * $root.G6PD().minCMS()),
						visible: $root.visibleMonth($data)" align="center"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: report() == 'SP_V1_StockForecasting' && type() == 'rdt' -->
        <table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2" align="center">Place </th>
					<th rowspan="2" class="no-border">&emsp;</th>
                    <th data-bind="visible: app.user.role == 'AU'" rowspan="2">Pop <span data-bind="text: year"></span></th>
                    <th data-bind="visible: app.user.role == 'AU'" rowspan="2">Pop <span data-bind="text: prevYear"></span></th>
                    <th data-bind="visible: app.user.role == 'AU'" rowspan="2">Aber RDT </th>
                   
                    <th data-bind="visible: app.user.role == 'AU'" rowspan="2">RDT Tested</th>
                    <th data-bind="visible: app.user.role == 'AU'" rowspan="2">Microscopy Tested</th>
                    <th data-bind="visible: app.user.role == 'AU'" rowspan="2">Positive</th>
                    <th rowspan="2">RDT Need</th>
                    <th rowspan="2">Buffer OD</th>
                    <th rowspan="2">Buffer HC</th>
                    <th rowspan="2">Central Buffer</th>
                    <th rowspan="2">Total Need</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td>
						<span data-bind="text: '&emsp;'.repeat(Level == 'Nation' ? 0 : Level == 'Province' ? 1 : Level == 'OD' ? 2 : Level == 'HC' ? 3 : 4)"></span>
						<span data-bind="text: Level == 'OD' ? 'OD - ' : Level == 'HC' ? 'HF - ' : Level == 'Village' ? 'VL - ' : ''"></span>
						<span data-bind="text: $data[Level]"></span>
					</td>
					<td class="no-border"></td>
					<td data-bind="visible: app.user.role == 'AU', text: _.ceil(NextPop)" class="text-nowrap"></td>
                    <td data-bind="visible: app.user.role == 'AU', text: _.ceil(PrevPop)" class="text-nowrap"></td>
                    <td data-bind="visible: app.user.role == 'AU', text: parseFloat(AberRDT).toFixed(3);"></td>
                    <td data-bind="visible: app.user.role == 'AU', text: RDT"></td>
                    <td data-bind="visible: app.user.role == 'AU', text: Microscopy"></td>
                    <td data-bind="visible: app.user.role == 'AU', text: Positive"></td>
                    <td data-bind="text: _.ceil(RDTNeed)" class="text-nowrap"></td>

                    <td data-bind="text: BufferRDTOD" class="text-nowrap"></td>
                    <td data-bind="text: BufferRDTHC" class="text-nowrap"></td>
                    <td data-bind="text: BufferRDTCentral"  class="text-nowrap"></td>
                    <td data-bind="text: RDTNeed + BufferRDTHC+ BufferRDTOD+BufferRDTCentral" class="text-nowrap"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
        <!-- /ko -->

        <!-- ko if: report() == 'SP_V1_StockForecasting' && type() == 'asmq' -->
        <table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2" align="center">Place</th>
                    <!-- ko if: app.user.role == 'AU' -->
                    <th rowspan="2" class="no-border">&emsp;</th>
                    <th colspan="10" align="center">Other info</th>
                    <th colspan="4" align="center"># Postive by Age Group</th>
                    <!--/ko-->
					<th rowspan="2" class="no-border">&emsp;</th>
                    <th colspan="4" align="center">Need</th>
                    <th rowspan="2" class="no-border">&emsp;</th>
                    <th colspan="4" align="center">Buffer OD</th>
                    <th rowspan="2" class="no-border">&emsp;</th>
                    <th colspan="4" align="center">Buffer HC</th>
                    <th rowspan="2" class="no-border">&emsp;</th>
                    <th colspan="4" align="center">Central Buffer</th>
                    <th rowspan="2" class="no-border">&emsp;</th>
                    <th colspan="4" align="center">Total</th>
				</tr>
                <tr>
                    <!-- ko if: app.user.role == 'AU' -->
                    <th rowspan="2">Pop <span data-bind="text: year"></span></th>
                    <th rowspan="2">Pop <span data-bind="text: prevYear"></span></th>
                    <th rowspan="2">Microscopy Test</th>
                    <th rowspan="2">RDT Test</th>
                    <th rowspan="2">Total Test</th>
                    <th rowspan="2">Expected Test</th>
                    <th rowspan="2">Positive</th>
                    <th rowspan="2">Positive Rate %</th>
                    <th rowspan="2">Severe</th>
                    <th rowspan="2">Pregnant < 3 months</th>
                    <th rowspan="2">6m-11m</th> 
                    <th rowspan="2">1y-6y</th> 
                    <th rowspan="2">7y-12y</th> 
                    <th rowspan="2">> 12y</th>  
                    <!--/ko-->
                    <th rowspan="2">6 – 11 months Need</th>
                    <th rowspan="2">1 – 6 years Need</th>
                    <th rowspan="2">7 – 12 years Need</th>
                    <th rowspan="2"> > 12 year Need</th>
                    
                    <th rowspan="2">6 – 11 months Need</th>
                    <th rowspan="2">1 – 6 years Need</th>
                    <th rowspan="2">7 – 12 years Need</th>
                    <th rowspan="2"> > 12 year Need</th>
                   
                    <th rowspan="2">6 – 11 months Need</th>
                    <th rowspan="2">1 – 6 years Need</th>
                    <th rowspan="2">7 – 12 years Need</th>
                    <th rowspan="2"> > 12 year Need</th>

                    <th rowspan="2">6 – 11 months Need</th>
                    <th rowspan="2">1 – 6 years Need</th>
                    <th rowspan="2">7 – 12 years Need</th>
                    <th rowspan="2"> > 12 year Need</th>

                    <th rowspan="2">6 – 11 months Need</th>
                    <th rowspan="2">1 – 6 years Need</th>
                    <th rowspan="2">7 – 12 years Need</th>
                    <th rowspan="2"> > 12 year Need</th>
                </tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
                    <td class="text-nowrap">
						<span data-bind="text: '&emsp;'.repeat(Level == 'Nation' ? 0 : Level == 'Province' ? 1 : Level == 'OD' ? 2 : Level == 'HC' ? 3 : 4)"></span>
						<span data-bind="text: Level == 'OD' ? 'OD - ' : Level == 'HC' ? 'HF - ' : Level == 'Village' ? 'VL - ' : ''"></span>
						<span data-bind="text: $data[Level]"></span>
					</td>
                    <!-- ko if: app.user.role == 'AU' -->
                    <td class="no-border"></td>
                    <td data-bind="text: _.ceil(NextPop)" class="text-nowrap"></td>
                    <td data-bind="text: _.ceil(PrevPop)" class="text-nowrap"></td>
                    <td data-bind="text: Microscopy" class="text-nowrap"></td>
                    <td data-bind="text: RDT" class="text-nowrap"></td>
                    <td data-bind="text: Test" class="text-nowrap"></td>
                    <td data-bind="text: ExpectedTest" class="text-nowrap"></td>
                    <td data-bind="text: Positive" class="text-nowrap"></td>
                    <td data-bind="text: isNaN((Positive/Test *100).toFixed(3)) ? 0 : (Positive/Test *100).toFixed(3)" class="text-nowrap"></td>
                    <td data-bind="text: Severe" class="text-nowrap"></td>
                    <td data-bind="text: PregnantMTHS" class="text-nowrap"></td>
                    <td data-bind="text: Positive_6m_11m" class="text-nowrap"></td>
                    <td data-bind="text: Positive_1y_6y" class="text-nowrap"></td>
                    <td data-bind="text: Positive_7y_12y" class="text-nowrap"></td>
                    <td data-bind="text: Positive_gt_12y" class="text-nowrap"></td>
                    <!--/ko-->

                    <td class="no-border"></td>
					<td data-bind="text: _.ceil(Need_6m_11m)" class="text-nowrap"></td>
                    <td data-bind="text: _.ceil(Need_1y_6y)" class="text-nowrap"></td>
                    <td data-bind="text: _.ceil(Need_7y_12y)" class="text-nowrap"></td>
                    <td data-bind="text: _.ceil(Need_gt_12y)" class="text-nowrap"></td>

                    <td class="no-border"></td>
					<td data-bind="text: BufferOD_6m_11m" class="text-nowrap"></td>
                    <td data-bind="text: BufferOD_1y_6y" class="text-nowrap"></td>
                    <td data-bind="text: BufferOD_7y_12y" class="text-nowrap"></td>
                    <td data-bind="text: BufferOD_gt_12y" class="text-nowrap"></td>

                    <td class="no-border"></td>
					<td data-bind="text: BufferHC_6m_11m" class="text-nowrap"></td>
                    <td data-bind="text: BufferHC_1y_6y" class="text-nowrap"></td>
                    <td data-bind="text: BufferHC_7y_12y" class="text-nowrap"></td>
                    <td data-bind="text: BufferHC_gt_12y" class="text-nowrap"></td>

                    <td class="no-border"></td>
					<td data-bind="text: BufferCentral_6m_11m" class="text-nowrap"></td>
                    <td data-bind="text: BufferCentral_1y_6y" class="text-nowrap"></td>
                    <td data-bind="text: BufferCentral_7y_12y" class="text-nowrap"></td>
                    <td data-bind="text: BufferCentral_gt_12y" class="text-nowrap"></td>

                    <td class="no-border"></td>
					<td data-bind="text: Need_6m_11m + BufferOD_6m_11m + BufferHC_6m_11m + BufferCentral_6m_11m" class="text-nowrap"></td>
                    <td data-bind="text: Need_1y_6y  + BufferOD_1y_6y + BufferHC_1y_6y + BufferCentral_1y_6y" class="text-nowrap"></td>
                    <td data-bind="text: Need_7y_12y + BufferOD_7y_12y + BufferHC_7y_12y + BufferCentral_7y_12y" class="text-nowrap"></td>
                    <td data-bind="text: Need_gt_12y + BufferOD_gt_12y + BufferHC_gt_12y + BufferCentral_gt_12y" class="text-nowrap"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
        <!-- /ko -->

		<!-- ko if: ['SP_V1_DashboardLogByRole','SP_V1_SystemLogByRole'].contain(report()) -->
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th width="200">Role</th>
					<th>Access Count</th>
					<th width="200" align="center">Country</th>
					<th width="200" align="center">City</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Role"></td>
					<td data-bind="text: AccessCount" align="center"></td>
					<td data-bind="text: Country" align="center"></td>
					<td data-bind="text: City" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: ['SP_V1_DashboardLogByUser','SP_V1_SystemLogByUser'].contain(report()) -->
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th width="200">User</th>
					<th width="200" align="center">Role</th>
					<th width="200" align="center">Province</th>
					<th width="200" align="center">OD</th>
					<th>Access Count</th>
					<th width="200" align="center">Country</th>
					<th width="200" align="center">City</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Username"></td>
					<td data-bind="text: Role" align="center"></td>
					<td data-bind="text: Name_Prov_E" align="center"></td>
					<td data-bind="text: Name_OD_E" align="center"></td>
					<td data-bind="text: AccessCount" align="center"></td>
					<td data-bind="text: Country" align="center"></td>
					<td data-bind="text: City" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: ['SP_V1_HFErrorCheck','SP_V1_VMWErrorCheck'].contain(report()) -->
		<div class="inlineblock">
			<table id="tblErrorCheck" class="table table-bordered table-striped table-hover widthauto">
				<thead>
					<tr>
						<th align="center" width="40">#</th>
						<th align="center">Province</th>
						<th align="center">OD</th>
						<th align="center">HC</th>
						<!-- ko if: report() == 'SP_V1_VMWErrorCheck' -->
						<th align="center">Village</th>
						<!-- /ko -->
						<th align="center">Year</th>
						<th align="center">Month</th>
						<th align="center">Name</th>
						<th align="center">Age</th>
						<th align="center">Sex</th>
						<th align="center">Pregnant</th>
						<th align="center">Species</th>
						<th align="center">Medicine</th>
						<!-- ko if: report() == 'SP_V1_VMWErrorCheck' -->
						<th align="center">PQ Treatment</th>
						<!-- /ko -->
						<th align="center">Refer</th>
						<th align="center">Not Error</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: listModel, fixedHeader: true">
					<tr>
						<td align="center" data-bind="text: $index() + 1"></td>
						<td align="center" data-bind="text: Name_Prov_K" class="kh"></td>
						<td align="center" data-bind="text: Name_OD_K" class="kh"></td>
						<td align="center" data-bind="text: Name_Facility_K" class="kh"></td>
						<!-- ko if: $root.report() == 'SP_V1_VMWErrorCheck' -->
						<td align="center" data-bind="text: Name_Vill_K" class="kh"></td>
						<!-- /ko -->
						<td align="center" data-bind="text: Year"></td>
						<td align="center" data-bind="text: Month"></td>
						<td align="center" data-bind="text: Name" class="kh"></td>
						<td align="center" data-bind="text: Age"></td>
						<td align="center" data-bind="text: Sex"></td>
						<td align="center" data-bind="text: Pregnant"></td>
						<td align="center" data-bind="text: Diagnosis"></td>
						<td align="center" data-bind="text: Treatment"></td>
						<!-- ko if: $root.report() == 'SP_V1_VMWErrorCheck' -->
						<td align="center" data-bind="text: PQTreatment"></td>
						<!-- /ko -->
						<td align="center" data-bind="text: Refered == 1 ? '✔' : '✘'"></td>
						<td align="center" class="no-padding">
							<input type="checkbox" class="checkbox checkbox-lg" data-bind="attr: { recid: Rec_ID }" />
						</td>
					</tr>
				</tbody>
				<tfoot data-bind="visible: app.tableFooter($element)">
					<tr>
						<td class="text-center text-warning h4" style="padding:10px">No Data</td>
					</tr>
				</tfoot>
			</table>
			<div class="text-right" style="padding-top:10px">
				<button class="btn btn-primary btn-sm width100" data-bind="click: saveNotError">Save</button>
			</div>
		</div>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_PopCompleteness' -->
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(8) -->
					<th align="center" data-bind="text: $index() + 2018"></th>
					<!-- /ko -->
					<th align="center">CSO</th>
					<th align="center" data-bind="visible: app.user.role == 'AU' && hc() != null">Reason</th>
					<th align="center" width="88" data-bind="visible: app.user.role == 'AU' && hc() != null"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(8) -->
					<td data-bind="text: isnot($root.valueByYear($parent, $index()), '', r => r + '%'), style: {backgroundColor: $root.bgWarningPop($parent, $index())}" align="center"></td>
					<!-- /ko -->
                    <td data-bind="text: CSO, style: {backgroundColor: $root.bgWarningPopCSO($data)}" align="center"></td>
                    <td data-bind="text: Reason, visible: app.user.role == 'AU' && $root.hc() != null"></td>
					<td align="center" data-bind="visible: app.user.role == 'AU' && $root.hc() != null">
						<a data-bind="click: $root.noPeopleClick, visible: Code_Vill_T != ''">No People</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<div style="border:1px solid #ccc; display:inline-block; margin-top:10px; padding:5px">
			<div class="clearfix">
				<div class="circlepoint pull-left" style="background:#ff3535; margin-top:2px"></div>
				<div class="text-bold pull-left" style="margin-left:5px;">&lt; 50%</div>
			</div>
			<div class="clearfix" style="margin-top:5px">
				<div class="circlepoint pull-left" style="background:#ffae49; margin-top:2px"></div>
				<div class="text-bold pull-left" style="margin-left:5px;">&lt; 90%</div>
			</div>
		</div>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_SupervisionChecklist' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th rowspan="2" valign="middle">Place</th>
					<!-- ko foreach: listModel().groupby('Month') -->
					<th align="center" data-bind="text: $data[0].Month" colspan="4"></th>
					<!-- /ko -->
				</tr>
				<tr data-bind="foreach: Array(3)">
					<th align="center" width="100">PF</th>
					<th align="center" width="100">PV</th>
					<th align="center" width="100">Mix</th>
					<th align="center" width="100">Negative</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel().groupby('Type'), fixedHeader: true">
				<tr data-bind="with: $data">
					<td data-bind="text: $data[0].Type"></td>
					<!-- ko foreach: $data -->
					<td data-bind="text: Pf" align="center"></td>
					<td data-bind="text: Pv" align="center"></td>
					<td data-bind="text: Mix" align="center"></td>
					<td data-bind="text: Negative" align="center"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_LastMile' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th align="center" width="100">Province</th>
					<th align="center" width="100">OD</th>
					<th align="center" width="100">HC</th>
					<th align="center" width="100">Village</th>
					<th align="center" width="100">House</th>
					<th align="center" width="100">Member</th>
                    <th align="center" width="100">TDA Census</th>
					<th align="center" width="100">TDA1</th>
					<th align="center" width="100">TDA2</th>
                    <th align="center" width="100">IPT Census</th>
					<th align="center" width="100">IPT</th>
					<th align="center" width="100">AFS</th>
					<th align="center" width="100">Level</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Province"></td>
					<td data-bind="text: OD"></td>
					<td data-bind="text: HC"></td>
					<td data-bind="text: Village"></td>
					<td data-bind="text: House" align="center"></td>
					<td data-bind="text: Member" align="center"></td>
                    <td data-bind="text: TDACensus" align="center"></td>
					<td data-bind="text: TDA1" align="center"></td>
					<td data-bind="text: TDA2" align="center"></td>
                    <td data-bind="text: IPTCensus" align="center"></td>
					<td data-bind="text: IPT" align="center"></td>
					<td data-bind="text: AFS" align="center"></td>
					<td data-bind="text: Level" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_LastMileCompleteness' -->
		<table class="table table-bordered">
			<thead>
				<tr>
                    <th align="center" width="40">#</th>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HC</th>
					<th align="center">Village</th>
					<th align="center" width="100">House Hold</th>
                    <th align="center" width="100">Member</th>
                    <th align="center" width="100">TDA Census</th>
					<th align="center" width="100">TDA1</th>
					<th align="center" width="100">TDA2</th>
                    <th align="center" width="100">IPT Census</th>
					<th align="center" width="100">IPT</th>
					<th align="center" width="100">AFS</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
                    <td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: House" align="center"></td>
                    <td data-bind="text: Member" align="center"></td>
                    <td data-bind="text: TDACensus" align="center"></td>
					<td data-bind="text: TDACensus == '0' || TDA1 == 'NA' ? 'NA' : TDA1 + ' (' + (TDA1 * 100 / TDACensus).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: TDACensus == '0' || TDA2 == 'NA' ? 'NA' : TDA2 + ' (' + (TDA2 * 100 / TDACensus).toFixed(0) + '%)'" align="center"></td>
                    <td data-bind="text: IPTCensus" align="center"></td>
					<td data-bind="text: IPTCensus == 'NA' || IPT == 'NA' ? 'NA' : IPT + ' (' + (IPT * 100 / IPTCensus).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: AFS == 'NA'? 'NA': AFS + ' (' + (AFS * 100 / Member).toFixed(0) + '%)'" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: report() == 'SP_V1_LastMileNoLatLong' -->
		<table class="table table-bordered">
			<thead>
				<tr>
                    <th align="center" width="40">#</th>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HC</th>
					<th align="center">Village</th>
					<th align="center" width="100">Total House</th>
					<th align="center" width="250">Total House Without Lat Long</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
                    <td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: Name_Prov_K"></td>
					<td data-bind="text: Name_OD_K"></td>
					<td data-bind="text: Name_Facility_K"></td>
					<td data-bind="text: Name_Vill_K"></td>
					<td data-bind="text: TotalHouse" align="center"></td>
					<td data-bind="text: NoLatLong" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: report() == 'SP_V1_LastmileSummary' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th align="center" rowspan="2">Province</th>
					<th align="center" rowspan="2">OD</th>
                    <th align="center" rowspan="2">Village</th>
					<th align="center" rowspan="2">Household</th>
					<th align="center" rowspan="2">Member</th>
					<th align="center" rowspan="2">AFS</th>
					<th align="center" colspan="3">TDA</th>
					<th align="center" colspan="2">IPT</th>
				</tr>
                <tr>
                    <th align="center">Eligible</th>
                    <th align="center">Received (TDA 1)</th>
                    <th align="center">Received (TDA 2)</th>
                    <th align="center">Eligible</th>
                    <th align="center">Received</th>
                </tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: { 'text-bold': Name_Prov_E == 'All' }">
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Village" align="center"></td>
					<td data-bind="text: House" align="center"></td>
					<td data-bind="text: Member" align="center"></td>
                    <td data-bind="text: AFS + ' (' + (AFS * 100 / Member).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: EligibleTDA" align="center"></td>
					<td data-bind="text: TDA1 + ' (' + (EligibleTDA == 0 ? 100 : (TDA1 * 100 / EligibleTDA)).toFixed(0) + '%)'" align="center"></td>
                    <td data-bind="text: TDA2 + ' (' + (EligibleTDA == 0 ? 100 : (TDA2 * 100 / EligibleTDA)).toFixed(0) + '%)'" align="center"></td>
					<td data-bind="text: EligibleIPT" align="center"></td>
					<td data-bind="text: IPT + ' (' + (EligibleIPT == 0 ? 100 : (IPT * 100 / EligibleIPT)).toFixed(0) + '%)'" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: report() == 'SP_V1_LastmileNoData' -->
		<table class="table table-bordered">
			<thead>
				<tr>
                    <th align="center" width="40">#</th>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HC</th>
					<th align="center">Village</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
                    <td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

        <!-- ko if: ['SP_V1_LastMileAFS', 'SP_V1_LastMileIPT'].contain(report()) -->
        <table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: $parent[moment($index() + 1, 'M').format('MM')], style: { color: parseInt($parent[moment($index() + 1, 'M').format('MM')].split("/")[1]) == 0 ? 'red' : 'black' }" align="center"></td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
        <br />
        <p class="text-bold text-danger" data-bind="visible: report() == 'SP_V1_LastMileAFS'">Note: House Member / AFS data</p>
        <p class="text-bold text-danger" data-bind="visible: report() == 'SP_V1_LastMileIPT'">Note: House Member Age between 15 and 49 and Male / IPTf data</p>
        <!-- /ko -->

		<!-- ko if: report() == 'SP_V1_Death' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HC</th>
					<th align="center">Village</th>
					<th align="center">Name</th>
					<th align="center">Sex</th>
					<th align="center">Age</th>
					<th align="center">Death</th>
					<th align="center">Report Month</th>
					<th align="center">Report Source</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: NameK"></td>
					<td data-bind="text: Sex" align="center"></td>
					<td data-bind="text: Age" align="center"></td>
					<td data-bind="text: Dead" align="center"></td>
					<td data-bind="text: Month" align="center"></td>
					<td data-bind="text: Type" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_HighRiskVillage' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th align="center" width="100">Province</th>
					<th align="center" width="100">OD</th>
					<th align="center" width="100">HC</th>
					<th align="center" width="100">Village</th>
					<th align="center" width="100">STD</th>
					<th align="center" width="100">AVG</th>
					<th align="center" width="100">STD+AVG</th>
					<th align="center" width="100">Positive last month</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: STD" align="center"></td>
					<td data-bind="text: Average" align="center"></td>
					<td data-bind="text: STDAVG" align="center"></td>
					<td data-bind="text: PositiveLastMonth" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_V1_CaseAfterDeadline' -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th rowspan="2">Place</th>
					<th colspan="2" align="center">Total Positive</th>
					<th colspan="2" align="center">HF Positive</th>
					<th colspan="2" align="center">VMW Positive</th>
					<th colspan="2" align="center">Total Negative</th>
					<th colspan="2" align="center">HF Negative</th>
					<th colspan="2" align="center">VMW Negative</th>
				</tr>
				<tr>
					<th align="center">Added</th>
					<th align="center">Deleted</th>
					<th align="center">Added</th>
					<th align="center">Deleted</th>
					<th align="center">Added</th>
					<th align="center">Deleted</th>
					<th align="center">Added</th>
					<th align="center">Deleted</th>
					<th align="center">Added</th>
					<th align="center">Deleted</th>
					<th align="center">Added</th>
					<th align="center">Deleted</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place" class="text-nowrap"></td>
					<td data-bind="text: PositiveAdd" align="center"></td>
					<td data-bind="text: PositiveDelete" align="center"></td>
					<td data-bind="text: PositiveAddHF" align="center"></td>
					<td data-bind="text: PositiveDeleteHF" align="center"></td>
					<td data-bind="text: PositiveAddVMW" align="center"></td>
					<td data-bind="text: PositiveDeleteVMW" align="center"></td>
					<td data-bind="text: NegativeAdd" align="center"></td>
					<td data-bind="text: NegativeDelete" align="center"></td>
					<td data-bind="text: NegativeAddHF" align="center"></td>
					<td data-bind="text: NegativeDeleteHF" align="center"></td>
					<td data-bind="text: NegativeAddVMW" align="center"></td>
					<td data-bind="text: NegativeDeleteVMW" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->
	</div>
</div>

<!-- Modal Primaquine -->
<div class="modal" id="modalPrimaquine" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content" data-bind="with: primaquine">
			<div class="modal-header">
				<h3 class="modal-title text-primary" data-bind="text: level() + ' mg Primaquine'"></h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr class="bg-primary">
							<th align="center"># Pills</th>
							<th align="center" width="180">VMW</th>
							<th align="center" width="180">HC</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td valign="middle">5-14 years Pf + Mix ONLY</td>
							<td>
								<input type="text" data-bind="value: vmw1, visible: app.user.role == 'AU'" class="form-control input-sm text-center" />
								<div data-bind="text: vmw1, visible: app.user.role != 'AU'" class="text-center"></div>
							</td>
							<td>
								<input type="text" data-bind="value: hc1, visible: app.user.role == 'AU'" class="form-control input-sm text-center" />
								<div data-bind="text: hc1, visible: app.user.role != 'AU'" class="text-center"></div>
							</td>
						</tr>
						<tr>
							<td valign="middle">&gt;15 years Pf + Mix ONLY</td>
							<td>
								<input type="text" data-bind="value: vmw2, visible: app.user.role == 'AU'" class="form-control input-sm text-center" />
								<div data-bind="text: vmw2, visible: app.user.role != 'AU'" class="text-center"></div>
							</td>
							<td>
								<input type="text" data-bind="value: hc2, visible: app.user.role == 'AU'" class="form-control input-sm text-center" />
								<div data-bind="text: hc2, visible: app.user.role != 'AU'" class="text-center"></div>
							</td>
						</tr>
						<tr>
							<th colspan="3">Needs (Calculation = # cases from same month the year before x # pills)</th>
						</tr>
						<tr>
							<th colspan="3">OD Buffer (Calculation = Average monthly pill needs for past 12 months x 3)</th>
						</tr>
						<tr>
							<th colspan="3">HC Buffer (Calculation = Average monthly pill needs for past 12 months x 1)</th>
						</tr>
						<tr>
							<th colspan="3">Minimum Stock (Calculation = If Needs + HC Buffer for an HC is &lt;10 for a full year, give 10 as minimum stock</th>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Primaquine V2-->
<div class="modal" id="modalPrimaquineV2" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h3 class="modal-title text-primary"></h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr class="bg-primary">
							<td>Deficiency</td>
							<td>Min Stock HF</td>
							<td>Min Stock OD</td>
							<td>Min Stock CMS</td>
						</tr>
					</thead>
					<tbody>
						<tr data-bind="with : primaquineV2">
							<td><input type="text" data-bind="value: deficiency" class="form-control input-sm text-center" /></td>
							<td><input type="text" data-bind="value: minHF" class="form-control input-sm text-center" /></td>
							<td><input type="text" data-bind="value: minOD" class="form-control input-sm text-center" /></td>
							<td><input type="text" data-bind="value: minCMS" class="form-control input-sm text-center" /></td>
						</tr>
						<tr>
							<th colspan="4">Needs (Calculation = PF( Age(5,14y) x 1 ) + PF(Age>14y) x 2 + PV+Mix(Age>5y, G6PD (U/g Hb) > 6 & Hb(g/dL) > 9)) Age5-10y: 14, Age11-14y: 28, Age15-49y: 42, Age>49: 56</th>
						</tr>
						<tr>
							<th colspan="4">OD Buffer (Calculation = Need x Min Stock OD)</th>
						</tr>
						<tr>
							<th colspan="4">HC Buffer (Calculation = Need x Min Stock HC)</th>
						</tr>
						<tr>
							<th colspan="4">Central (Calculation = Need x Min Stock CMS)</th>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal G6PD-->
<div class="modal" id="modalG6PD" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h3 class="modal-title text-primary"></h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr class="bg-primary">
							<td>Refered</td>
							<td>Min Stock HF</td>
							<td>Min Stock OD</td>
							<td>Min Stock CMS</td>
						</tr>
					</thead>
					<tbody>
						<tr data-bind="with : G6PD">
							<td><input type="text" data-bind="value: refered" class="form-control input-sm text-center" /></td>
							<td><input type="text" data-bind="value: minHF" class="form-control input-sm text-center" /></td>
							<td><input type="text" data-bind="value: minOD" class="form-control input-sm text-center" /></td>
							<td><input type="text" data-bind="value: minCMS" class="form-control input-sm text-center" /></td>
						</tr>
						<tr>
							<th colspan="4">Needs (Calculation = #case_HF (PV+Mix) + #case_VMW (PV+Mix) * refered )</th>
						</tr>
						<tr>
							<th colspan="4">OD Buffer (Calculation = Need x Min stock OD)</th>
						</tr>
						<tr>
							<th colspan="4">HC Buffer (Calculation = Need x Min stock HC)</th>
						</tr>
						<tr>
							<th colspan="4">Central (Calculation = Need x Min stock CMS)</th>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal RDT Distribution -->
<div class="modal" id="modalRDT" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h3 class="modal-title text-primary" >RDT</h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr class="bg-primary">
							<th align="center" width="180"># New VMW</th>
                            <th align="center" width="180"># Removed VMW</th>
							<th align="center" width="180"># Non-Endemic HC</th>
                            <th align="center" width="180"># M&E Aber % </th>
                            <th align="center" width="180"># Anual Aber %</th>
                            <th align="center" width="180"># Growth Rate</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="text" data-bind="value: nvmw" class="form-control input-sm text-center" />
							</td>
                            <td>
								<input type="text" data-bind="value: removevmw" class="form-control input-sm text-center" />
							</td>
							<td>
								<input type="text" data-bind="value: neHC" class="form-control input-sm text-center" />			
							</td>
                            <td>
								<input type="text" data-bind="value: meAber" class="form-control input-sm text-center" />							
							</td>
                            <td>
								<input disabled type="text" data-bind="value: anualAber" class="form-control input-sm text-center" />							
							</td>
                            <td>
								<input type="text" data-bind="value: growthRate" class="form-control input-sm text-center" />							
							</td>
						</tr>	
                        <tr>
							<th colspan="6">Aber (Calculation = # Test / # Population)</th>
						</tr>
                        <tr>
							<th colspan="6">Need (Calculation = RDT x (1+GrowthRate))</th>
						</tr>
                        <tr>
							<th colspan="6">OD Buffer (Calculation = Average monthly RDT needs for past 12 months x 3)</th>
						</tr>
                        <tr>
							<th colspan="6">HC Buffer (Calculation = Average monthly RDT needs for past 12 months x 1)</th>
						</tr>
                        <tr>
							<th colspan="6">Central Buffer (Calculation = Average monthly RDT needs for past 12 months x 6)</th>
						</tr>
                        <tr>
							<th colspan="6">None-Endemic HC (Calculation = # None-Endemic Province	* 25)</th>
						</tr>
                        <tr>
							<th colspan="6">New VMW	(Calculation = # New VMW * 100)</th>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div class="clearfix">
					<div class="pull-left">
						<label class="checkbox-inline checkbox-lg">
							<input type="checkbox" data-bind="checked: popFromHC, enable: od() == null" />
							<span>Pop From HC</span>
						</label>
					</div>
					<div class="pull-right">
						<button class="btn btn-primary btn-sm width100">OK</button>
						<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal ASMQ Distribution -->
<div class="modal" id="modalASMQ" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="margin: 0 auto; width: 888px">
		<div class="modal-content" >
			<div class="modal-header">
				<h3 class="modal-title text-primary" >ASMQ</h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr class="bg-primary">
							<th align="center" width="180"># New VMW</th>
                            <th align="center" width="180"># Removed VMW</th>
							<th align="center" width="180"># Non-Endemic HC</th>
                            <th align="center" width="180"># Non-Endemic HC Positive %</th>
                            <th align="center" width="180"># M&E Aber % </th>
                            <th align="center" width="180"># Anual Aber %</th>
                            <th align="center" width="180"># Anual Positive Rate %</th>
						</tr>
					</thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" data-bind="value: nvmw" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: removevmw" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: neHC" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: neHCPositive" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: meAber" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input disabled type="text" data-bind="value: anualAber" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input disabled type="text" data-bind="value: anualPositiveRate" class="form-control input-sm text-center" />
                            </td>
                        </tr>
                        <tr class="bg-primary">
                            <th align="center" colspan="4">% Malaria by Age Group</th>
                            <th rowspan="2" align="center" width="180"># M&E Positive Rate %</th>
                            <th rowspan="2" align="center" width="180"># Reduction rate %</th>
                            <th rowspan="2" align="center" width="180"># Growth Rate</th>
                        </tr>
                        <tr class="bg-primary" data-bind="with: preData">
							<th align="center" width="180">6m - 11m <br><span style="color:aquamarine" data-bind="text: p6m_11m"></span><span style="color:aquamarine"> %</span></th>
                            <th align="center" width="180">1y - 6y <br><span style="color:aquamarine" data-bind="text: p1y_6y"></span><span style="color:aquamarine"> %</span></th>
							<th align="center" width="180">7y - 12y <br><span style="color:aquamarine" data-bind="text: p7y_12y"></span><span style="color:aquamarine"> %</span></th>
                            <th align="center" width="180">> 12y <br><span style="color:aquamarine" data-bind="text: p12y"></span><span style="color:aquamarine"> %</span></th>
						</tr>
                        <tr>
                            <td>
                                <input type="text" data-bind="value: positive_6m_11m" class="form-control input-sm text-center" />
                            </td>                                     
                            <td>                                     
                                <input type="text" data-bind="value: positive_1y_6y" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: positive_7y_12y" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: positive_gt_12y" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: positiveRate" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: reduction" class="form-control input-sm text-center" />
                            </td>
                            <td>
                                <input type="text" data-bind="value: growthRate" class="form-control input-sm text-center" />
                            </td>
                        </tr>
                        <tr>
                            <th colspan="8">Need (Calculation = Positive rate x # Expected No. of Test - # Pregnant Woman < 3 months + # Severe case)</th>
                        </tr>
                        <tr>
                            <th colspan="8">OD Buffer (Calculation = Average monthly ASMQ needs for past 12 months x 3)</th>
                        </tr>
                        <tr>
                            <th colspan="8">HC Buffer (Calculation = Average monthly ASMQ needs for past 12 months x 1)</th>
                        </tr>
                        <tr>
                            <th colspan="8">Central Buffer (Calculation = Average monthly ASMQ needs for past 12 months x 6)</th>
                        </tr>
                    </tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div class="clearfix">
					<div class="pull-left">
						<label class="checkbox-inline checkbox-lg">
							<input type="checkbox" data-bind="checked: popFromHC, enable: od() == null" />
							<span>Pop From HC</span>
						</label>
					</div>
					<div class="pull-right">
						<button class="btn btn-primary btn-sm width100">OK</button>
						<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Investigation Detail -->
<div class="modal" id="modalInvestDetail" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" data-bind="with: investDetail">
			<div class="modal-header">
				<h4 class="modal-title text-primary" data-bind="text: title"></h4>
			</div>
			<div class="modal-body">
				<h3 class="text-warning text-center" data-bind="visible: table.length == 0">No Data</h3>
				<table class="table table-bordered table-striped table-hover" data-bind="visible: table.length > 0">
					<thead>
						<tr>
							<th rowspan="2" align="center" valign="middle" width="40">#</th>
							<th rowspan="2" align="center" valign="middle">Name</th>
							<th rowspan="2" align="center" valign="middle" width="50">Age</th>
							<th rowspan="2" align="center" valign="middle" width="50">Sex</th>
							<th colspan="3" align="center">Species</th>
							<th colspan="4" align="center">Classification</th>
							<th rowspan="2" align="center" valign="middle" width="100">Diagnosis Date</th>
						</tr>
						<tr>
							<th align="center" width="50">Pf</th>
							<th align="center" width="50">Pv</th>
							<th align="center" width="50">Mix</th>
							<th align="center" width="50">Relapse</th>
							<th align="center" width="50">L1</th>
							<th align="center" width="50">LC</th>
							<th align="center" width="50">IMP</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: table">
						<tr>
							<td data-bind="text: $index() + 1" align="center"></td>
							<td data-bind="text: Name" class="kh"></td>
							<td data-bind="text: Age" align="center"></td>
							<td data-bind="text: Sex" align="center"></td>
							<td data-bind="text: Pf == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: Pv == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: Mix == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: Relapse == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: L1 == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: LC == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: IMP == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: moment(DateCase).format('DD-MM-YYYY')" align="center"></td>
						</tr>
					</tbody>
					<tfoot data-bind="visible: table.length > 1, with: table">
						<tr>
							<th colspan="4" align="center">Total</th>
							<th data-bind="text: $data.sum(r => r.Pf)" align="center"></th>
							<th data-bind="text: $data.sum(r => r.Pv)" align="center"></th>
							<th data-bind="text: $data.sum(r => r.Mix)" align="center"></th>
							<th data-bind="text: $data.sum(r => r.Relapse)" align="center"></th>
							<th data-bind="text: $data.sum(r => r.L1)" align="center"></th>
							<th data-bind="text: $data.sum(r => r.LC)" align="center"></th>
							<th data-bind="text: $data.sum(r => r.IMP)" align="center"></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Investigation Popup -->
<div class="modal" id="modalInvestPopup" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="height:calc(100% - 60px); width:calc(100% - 60px)">
		<div class="modal-content" style="height:100%; width:calc(100% + 1px)">
			<div class="modal-body" style="height:calc(100% - 47px); overflow-y:auto">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th align="center" width="40">#</th>
							<th sortable>OD</th>
							<th sortable>HF</th>
							<th sortable>Village</th>
							<th align="center" width="60" sortable>Report Type</th>
							<th align="center" width="70" sortable>Report Month</th>
							<th align="center" sortable>Name</th>
							<th align="center" width="40" sortable>Age</th>
							<th align="center" width="40" sortable>Sex</th>
							<th align="center" width="85" sortable>Diagnosis Date</th>
							<th align="center" width="90" sortable>Entry Date</th>
							<th align="center" width="40" sortable="desc">PF</th>
							<th align="center" width="40" sortable="desc">PV</th>
							<th align="center" width="40" sortable="desc">Mix</th>
							<th align="center" width="40" sortable="desc">PM</th>
							<th align="center" width="40" sortable="desc">PO</th>
							<th align="center" width="40" sortable="desc">PK</th>
							<th align="center" width="40" sortable="desc">Relapse</th>
							<th align="center" width="40" sortable="desc">L1</th>
							<th align="center" width="40" sortable="desc">LC</th>
							<th align="center" width="40" sortable="desc">IMP</th>
							<th align="center" width="40" sortable="desc">ReACD</th>
							<th align="center" width="40" sortable="desc">Eligible Foci</th>
							<th align="center" width="40" sortable="desc">Foci Inv</th>
							<th align="center" width="40" sortable="desc">Lastmile Village</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: investPopup, fixedHeader: true, scrollContainer: $($element).closest('.modal-body')">
						<tr data-bind="css: Investigated == 0 ? 'text-danger' : ''">
							<td data-bind="text: $index() + 1" align="center"></td>
							<td data-bind="text: Name_OD_E"></td>
							<td data-bind="text: Name_Facility_E"></td>
							<td data-bind="text: Name_Vill_E, css: { kh: iskhmer(Name_Vill_E) }"></td>
							<td data-bind="text: ReportType" align="center"></td>
							<td data-bind="text: $root.year() + '-' + ReportMonth" align="center" class="text-nowrap"></td>
							<td data-bind="text: Name, css: { kh: iskhmer(Name) }" class="text-nowrap"></td>
							<td data-bind="text: Age" align="center"></td>
							<td data-bind="text: Sex" align="center"></td>
							<td data-bind="text: DateCase" align="center" class="text-nowrap"></td>
							<td data-bind="text: EntryDate" align="center" class="text-nowrap"></td>
							<td data-bind="text: Pf == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Pv == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Mix == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Pm == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Po == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Pk == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Relapse == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: L1 == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: LC == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: IMP == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Reactive == 1 ? '✔' : '', click: $root.showReactiveForm" align="center" class="underline"></td>
							<td data-bind="text: FociNeed == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: Foci == 1 ? '✔' : '', click: $root.showFociForm" align="center" class="underline"></td>
							<td data-bind="text: LastmileVillage == 1 ? '✔' : ''" align="center"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-sm width100" data-bind="click: exportExcelInvest">Export Excel</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Investigation Popup Rai4 -->
<div class="modal" id="modalInvestPopupRai4" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="height:calc(100% - 60px); width:calc(100% - 60px)">
		<div class="modal-content" style="height:100%; width:calc(100% + 1px)">
			<div class="modal-body" style="height:calc(100% - 47px); overflow-y:auto">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th align="center" width="40">#</th>
							<th sortable>OD</th>
							<th sortable>HF</th>
							<th sortable>Village</th>
							<th sortable>Infection Source</th>
							<th align="center" sortable>Report Type</th>
							<th align="center" sortable>Report Month</th>
							<th align="center" sortable>Name</th>
							<th align="center" sortable>Age</th>
							<th align="center" sortable>Sex</th>
							<th align="center" sortable>Weight</th>
							<th align="center" sortable>Diagnosis Date</th>
							<th align="center" sortable>Entry Date</th>
							<th align="center" width="40" sortable="desc">PF</th>
							<th align="center" width="40" sortable="desc">PV</th>
							<th align="center" width="40" sortable="desc">Mix</th>
							<th align="center" width="40" sortable="desc">PM</th>
							<th align="center" width="40" sortable="desc">PO</th>
							<th align="center" width="40" sortable="desc">PK</th>
							<th align="center" sortable="desc">Relapse</th>
							<th align="center" width="40" sortable="desc">LA</th>
							<th align="center" width="40" sortable="desc">DI</th>
							<th align="center" width="40" sortable="desc">II</th>
							<th align="center" sortable="desc">Induced</th>
							<th align="center" sortable="desc">ReACD</th>
							<th align="center" sortable="desc">Eligible Foci</th>
							<th align="center" sortable="desc">Foci Inv</th>
							<th align="center" sortable="desc">Foci 7D Response</th>
							<th align="center" sortable="desc">Foci Response Date</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: investPopupRai4, fixedHeader: true, scrollContainer: $($element).closest('.modal-body')">
						<tr data-bind="css: Investigated == 0 ? 'text-danger' : ''">
							<td data-bind="text: $index() + 1" align="center"></td>
							<td data-bind="text: Name_OD_E" class="text-nowrap"></td>
							<td data-bind="text: Name_Facility_E"></td>
							<td data-bind="text: Name_Vill_E"></td>
							<td data-bind="text: $root.getVill(InfectionSourceAddress)"></td>
							<td data-bind="text: ReportType" align="center"></td>
							<td data-bind="text: $root.year() + '-' + ReportMonth" align="center" class="text-nowrap"></td>
							<td data-bind="text: Name, css: { kh: iskhmer(Name) }" class="text-nowrap"></td>
							<td data-bind="text: Age" align="center"></td>
							<td data-bind="text: Sex" align="center"></td>
							<td data-bind="text: Weight" align="center"></td>
							<td data-bind="text: DateCase" align="center" class="text-nowrap"></td>
							<td data-bind="text: EntryDate" align="center" class="text-nowrap"></td>
							<td data-bind="text: Pf == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Pv == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Mix == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Pm == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Po == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Pk == 1 ? '✔' : '', click: $root.showCaseEntryForm" align="center" class="underline"></td>
							<td data-bind="text: Relapse == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: L1 == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: LC == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: IMP == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: Induce == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: Reactive == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: FociNeed == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: Foci == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: Foci7d == 1 ? '✔' : ''" align="center"></td>
							<td data-bind="text: FociResponseDate" align="center" class="text-nowrap"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-sm width100" data-bind="click: exportExcelInvestRai4">Export Excel</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal NoPeople -->
<div class="modal" id="modalNoPeople" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-danger">Are you sure?</h3>
			</div>
			<div class="modal-body">
				<input type="text" class="form-control" placeholder="Reason" />
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger btn-sm" data-dismiss="modal" style="width:100px">Yes</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">No</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal RDT Image -->
<div class="modal" id="modalRDTImage" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="height:calc(100% - 60px); width:fit-content">
		<div class="modal-content" style="height:100%">
			<div class="modal-body" style="height:calc(100% - 47px); overflow-y:auto">
				<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="40" align="center">#</th>
                            <th align="center">OD</th>
                            <th align="center">HC</th>
                            <th align="center" data-bind="visible: report() == 'SP_V1_VMWFingerprint'">Village</th>
                            <th align="center">Species</th>
                            <th align="center">Diagnosis Date</th>
                            <th align="center">Entry Date</th>
                            <th align="center">View Image</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: RDTImagePopup, fixedHeader: true, scrollContainer: $($element).closest('.modal-body')">
                        <tr>
                            <td align="center" data-bind="text: $index() + 1"></td>
                            <td data-bind="text: Name_OD_E"></td>
                            <td data-bind="text: Name_Facility_E"></td>
                            <td data-bind="text: $data.Name_Vill_E, visible: $root.report() == 'SP_V1_VMWFingerprint'"></td>
                            <td align="center" data-bind="text: Species"></td>
                            <td align="center" data-bind="text: moment(DateCase).displayformat()"></td>
                            <td align="center" data-bind="text: moment(EntryDate).displayformat()"></td>
                            <td align="center">
                                <a data-bind="attr: { href: '/media/RDT/' + RdtImage }" target="_blank">View Image</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCVXxd9fjjh1c2wrsRlZfyHfEkBiI4XQ8Q"></script>
<script src="/media/JavaScript/maplabel.js"></script>
<?=latestJs('/media/JavaScript/loadash.js')?>
<?=latestJs('/media/ViewModel/Report.js')?>