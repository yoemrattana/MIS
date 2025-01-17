<!-- ko with: report -->
<div class="panel-heading clearfix relative" data-bind="visible: $root.menu() == 'Report'">
	<div class="pull-left">
		<div class="inlineblock">
			<div class="text-bold">Province</div>
			<select class="form-control" data-bind="value: pv, options: $root.pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">OD</div>
			<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">HC</div>
			<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">Source</div>
			<select class="form-control" data-bind="value: filter">
				<option>HC + VMW</option>
				<option>HC</option>
				<option>VMW</option>
			</select>
		</div>

		<div class="inlineblock">
			<div class="text-bold">From</div>
			<input type="text" class="form-control text-center width100" data-bind="datePicker: mf, format: 'MMM YYYY', minDate: '2022-01-01'" />
		</div>
		<div class="inlineblock">
			<div class="text-bold">To</div>
			<input type="text" class="form-control text-center width100" data-bind="datePicker: mt, format: 'MMM YYYY', minDate: mf" />
		</div>
		<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
	</div>
	<div class="pull-right" style="padding-top:20px">
		<button class="btn btn-success" data-bind="click: exportExcel">Export Excel</button>
	</div>
</div>

<div class="panel-body" data-bind="visible: $root.menu() == 'Report' && loaded()">
	<div style="display:flex; align-items:flex-start">
		<table class="table table-bordered table-striped table-hover widthauto text-nowrap">
			<thead>
				<tr>
					<th rowspan="2">Place</th>
					<th align="center">Positive</th>
					<th align="center">Eligible iDES</th>
					<th align="center">iDES</th>
					<th align="center">iDES (%)</th>
					<th align="center">CSO</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place" class="text-nowrap"></td>
					<td data-bind="text: Positive" align="center"></td>
					<td data-bind="text: Eligible_iDes" align="center"></td>
					<td data-bind="text: iDes" align="center"></td>
					<td data-bind="text: Eligible_iDes == 0 ? '-' : (iDes * 100 / Eligible_iDes).toFixed(0) + '%'" align="center"></td>
					<td data-bind="text: CSO" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<div style="margin-left:15px; flex-grow:1">
			<div class="chart-container">
				<div id="chartiDes"></div>
			</div>
			<div class="chart-container">
				<div id="chartiDesOD"></div>
			</div>
		</div>
	</div>

	<div class="chart-container form-inline" style="margin-top:15px">
		<div class="input-group" style="width:160px">
			<span class="input-group-addon">Month</span>
			<input type="text" class="form-control text-center" data-bind="datePicker: chartmonth, format: 'MMM YYYY', minDate: '2022-01-01'" />
		</div>
		<div id="chartiDesWeek"></div>
	</div>
</div>
<!-- /ko -->