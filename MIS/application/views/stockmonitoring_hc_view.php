
<style>
	#fixedtop { position:fixed; top:0; left:0; right:0; z-index:2; }
	body.modal-open #fixedtop { right:16px; }
</style>

<div id="fixedtop" class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<div class="input-group">
				<span class="input-group-addon">Province</span>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">OD</span>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Year</span>
				<select class="form-control" data-bind="value: year, options: yearList"></select>
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: save">Confirm</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
</div>

<div class="panel panel-default" data-bind="visible: true, style: { marginTop: $('#fixedtop').outerHeight() + 'px' }" style="display:none">
	<div class="panel-body">
		<table id="tblmain" class="table table-bordered table-hover text-nowrap widthauto">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HF</th>
					<!-- ko foreach: Array(12) -->
					<th colspan="2" align="center" data-bind="text: moment().month($index()).format('MMM')"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel(), fixedHeader: true, fixedTop: $('#fixedtop').outerHeight()">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<!-- ko foreach: Array(12) -->
					<td align="center" valign="middle" class="no-padding" data-bind="if: $parent[moment().month($index()).format('MM')] == 1" width="30" style="border-right-color:white">
						<span class="material-icons text-danger" data-bind="click: () => $root.showDetail($parent, $index())" role="button">launch</span>
					</td>
					<td align="center" valign="middle" class="no-padding" data-bind="if: $parent[moment().month($index()).format('MM')] == 1" width="30">
						<input type="checkbox" class="checkbox-lg" data-bind="checked: $root.updateList, attr: { value: $parent['Code_Facility_T'] + '|' + $index() }" />
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot data-bind="visible: getListModel().length == 0">
				<tr>
					<td colspan="28" class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/StockMonitoringHC.js')?>