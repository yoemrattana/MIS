<style>
	.chartbox {
		border: 2px solid #01c0c8;
		box-shadow: 0 0 10px rgba(0,0,0,.15), 0 3px 3px rgba(0,0,0,.15);
		margin-bottom: 20px;
	}
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<div class="inlineblock">
				<div class="text-bold">Year</div>
				<select class="form-control" data-bind="value: year, options: yearList"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">From</div>
				<select class="form-control" data-bind="value: mf, options: monthList"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">To</div>
				<select class="form-control" data-bind="value: mt, options: $root.monthList"></select>
			</div>
			<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
		</div>
		<div class="pull-right">
			<a href="/Lastmile" class="btn btn-default">Back</a>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<div class="row">
			<div class="col-xs-6">
				<div id="countVillage" class="chartbox"></div>
			</div>
			<div class="col-xs-6">
				<div id="countHouse" class="chartbox"></div>
			</div>
		</div>

		<div id="peoplePositive" class="chartbox"></div>
		<div id="percentIPT" class="chartbox"></div>
		<div id="percentTDA" class="chartbox"></div>

		<div class="row">
			<div class="col-xs-offset-3 col-xs-6">
				<div id="numberIPTTDA" class="chartbox"></div>
			</div>
		</div>

		<hr />

		<h3 class="text-center text-primary" data-bind="text: 'Lastmile Data ' + year()"></h3>
		<table class="table table-bordered table-hover table-striped widthauto" style="margin:auto">
			<thead>
				<tr>
					<th rowspan="2" width="40" align="center">#</th>
					<th rowspan="2" align="center">OD</th>
					<th rowspan="2" align="center">HC</th>
					<th rowspan="2" align="center">Village</th>
					<th rowspan="2" align="center">House</th>
					<th rowspan="2" align="center">Member</th>
					<th colspan="2" align="center">Census</th>
					<th colspan="3" align="center">Implementation</th>
				</tr>
				<tr>
                    <th align="center" width="60">TDA</th>
					<th align="center" width="60">IPT</th>
					<th align="center" width="60">TDA 1</th>
                    <th align="center" width="60">TDA 2</th>
                    <th align="center" width="100">IPT (<span data-bind="text:year()"></span>)</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: table">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: House" align="center"></td>
					<td data-bind="text: Member" align="center"></td>
                    <td data-bind="text: TargetTDA" align="center"></td>
					<td data-bind="text: TargetIPT" align="center"></td>
                    <td data-bind="text: TDA1" align="center"></td>
                    <td data-bind="text: TDA2" align="center"></td>
					<td data-bind="text: IPT" align="center"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr class="warning">
					<th align="center" colspan="4">Total</th>
					<th align="center" data-bind="text: table().sum('House')"></th>
					<th align="center" data-bind="text: table().sum('Member')"></th>
                    <th align="center" data-bind="text: table().sum('TargetTDA')"></th>
					<th align="center" data-bind="text: table().sum('TargetIPT')"></th>
                    <th align="center" data-bind="text: table().sum('TDA1')"></th>
                    <th align="center" data-bind="text: table().sum('TDA2')"></th>
					<th align="center" data-bind="text: table().sum('IPT')"></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/LastmileDashboard.js')?>