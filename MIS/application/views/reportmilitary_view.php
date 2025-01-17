<style>
	.frame {
		margin: 5px;
		float: left;
		height: 250px;
		border: 1px solid #ccc;
		padding: 10px;
	}
	.frame header { 
		font-weight: bold;
		margin: -10px -10px 10px -10px;
		background-color: #428bca;
		padding: 6px 10px;
		color: white;
		font-size: 16px;
	}
	.frame table td { padding: 5px; }
	input[type="radio"] {  margin: 4px 0 0; }

	@media print {
		.panel.print { border: none; }
		.panel-heading.print { border: none; padding: 0; }
		.panel-body.print { padding: 0; }
	}
</style>

<div class="panel panel-default" style="display:none" data-bind="visible: report() == null">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh34">
			<b>Reports MMP</b>
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
					<span>Regional</span>
					<select class="form-control kh" data-bind="value: rg, options: rgList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: 'All'"></select>
				</div>
				<div class="form-group">
					<span>Unit</span>
					<select class="form-control kh" data-bind="value: unit, options: unitList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: 'All'"></select>
				</div>
				<div class="form-group">
					<span>Group</span>
					<select class="form-control kh" data-bind="value: gp, options: gpList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: 'All'"></select>
				</div>
			</div>
		</div>

		<div class="frame">
			<header>Reports</header>
			<button name="SP_MLCompletenessReport" class="btn btn-primary btn-block" data-bind="click: getReport">MMP Completeness Report</button>
			<button name="SP_MLCaseReport" class="btn btn-primary btn-block" data-bind="click: getReport">MMP Case Report</button>
			<button name="SP_MLBetNetReport" class="btn btn-primary btn-block" data-bind="click: getReport">MMP Bed Net Report</button>
			<button name="SP_MLBednetReportV2" class="btn btn-primary btn-block" data-bind="click: getReport">MMP Bed Net Report V2</button>
			<button name="SP_MLCaseByPhone" class="btn btn-primary btn-block" data-bind="click: getReport">MMP Case Report (By Mobile)</button>
		</div>

	</div>
</div>

<div class="panel panel-default print" style="display:none; margin:-10px" data-bind="visible: report() != null">
	<div class="panel-heading clearfix print">
		<div class="pull-left font16 lh34">
			<b data-bind="text: title"></b>
		</div>
		<div class="pull-right">
			<button class="btn btn-default width100 hidden-print" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body print">

		<!-- ko if: report() == 'SP_MLCompletenessReport' -->
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<th align="center">Jan</th>
					<th align="center">Feb</th>
					<th align="center">Mar</th>
					<th align="center">Apr</th>
					<th align="center">May</th>
					<th align="center">Jun</th>
					<th align="center">Jul</th>
					<th align="center">Aug</th>
					<th align="center">Sep</th>
					<th align="center">Oct</th>
					<th align="center">Nov</th>
					<th align="center">Dec</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr data-bind="with: $data, css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + NameK" class="kh"></td>
					<!-- ko foreach: Array(12) -->
					<td data-bind="text: isnot($root.valueByMonth($parent, $index()), '', r => r + '%'), style: {backgroundColor: $root.bgWarning($parent, $index())}" align="center"></td>
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

		<!-- ko if: report() == 'SP_MLCaseReport' -->
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<th align="center">Test</th>
					<th align="center">Positive</th>
                    <th align="center">MMP Case</th>
                    <th align="center">Civil Case</th>
					<th align="center">Negative</th>
					<th align="center">PF</th>
					<th align="center">PV</th>
					<th align="center">Mix</th>
					<th align="center">Severe</th>
					<th align="center">Referred</th>
					<th align="center">Death</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr data-bind="with: $data, css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place" class="kh"></td>
					<td data-bind="text: Test" align="center"></td>
					<td data-bind="text: Positive" align="center"></td>
                    <td data-bind="text: ML" align="center"></td>
                    <td data-bind="text: P" align="center"></td>
					<td data-bind="text: Negative" align="center"></td>
					<td data-bind="text: Pf" align="center"></td>
					<td data-bind="text: Pv" align="center"></td>
					<td data-bind="text: Mix" align="center"></td>
					<td data-bind="text: Severe" align="center"></td>
					<td data-bind="text: Referred" align="center"></td>
					<td data-bind="text: Death" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_MLBednetReportV2' -->
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<th align="center">LLIN</th>
					<th align="center">LLIHN</th>
					<th align="center">Hamok Net</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr data-bind="with: $data, css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place" class="kh"></td>
					<td data-bind="text: LLIN" align="center"></td>
					<td data-bind="text: LLIHN" align="center"></td>
					<td data-bind="text: HamokNet" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_MLBetNetReport' -->
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<th align="center">Total LLIN</th>
					<th align="center">Total LLIHN</th>
					<th align="center">Target LLIN</th>
					<th align="center">Target LLIHN</th>
					<th align="center">Mobile LLIN</th>
					<th align="center">Mobile LLIHN</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: Place" class="kh"></td>
					<td data-bind="text: LLIN" align="center"></td>
					<td data-bind="text: LLIHN" align="center"></td>
					<td data-bind="text: LLIN_Target" align="center"></td>
					<td data-bind="text: LLIHN_Target" align="center"></td>
					<td data-bind="text: LLIN_Mobile" align="center"></td>
					<td data-bind="text: LLIHN_Mobile" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: report() == 'SP_MLCaseByPhone' -->
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Province</th>
					<th>Village</th>
					<th align="center">Test</th>
					<th align="center">Positive</th>
					<th align="center">Negative</th>
					<th align="center">PF</th>
					<th align="center">PV</th>
					<th align="center">Mix</th>
					<th align="center">Referred</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr data-bind="with: $data, css: {'text-bold': $index() == 0}">
					<td data-bind="text: Name_Prov_K" class="kh"></td>
					<td data-bind="text: Name_Vill_K" class="kh"></td>
					<td data-bind="text: Test" align="center"></td>
					<td data-bind="text: Positive" align="center"></td>
					<td data-bind="text: Negative" align="center"></td>
					<td data-bind="text: Pf" align="center"></td>
					<td data-bind="text: Pv" align="center"></td>
					<td data-bind="text: Mix" align="center"></td>
					<td data-bind="text: Refered" align="center"></td>
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

<?=latestJs('/media/ViewModel/ReportMilitary.js')?>