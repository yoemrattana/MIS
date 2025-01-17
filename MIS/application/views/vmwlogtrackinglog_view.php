
<style>
	.table-hover thead { background-color: #9AD8ED; }
	.form-control { height: auto; padding: 2px 5px; }
	.space { margin-left: 10px; }
	.highlight { background-color: #ffff99; font-weight: bold; }
	.width70 { width: 70px !important; }
	.padding-5 { padding: 5px; }
	ul li { cursor: pointer; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh28">
			<b>Tracking Log</b>
		</div>
		<div class="pull-right">
			<button class="btn btn-default btn-sm width100" data-bind="click: back, visible: view() == 'detail'">Back</button>
			<a href="/Home" data-bind="visible: view() == 'list'" style="margin-left:30px">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" align="center" rowspan="2">#</th>
					<th align="center" rowspan="2">Province</th>
					<th align="center" rowspan="2">OD</th>
					<th align="center" rowspan="2">HC</th>
					<th align="center" rowspan="2">Village</th>
					<th align="center"  colspan="3">New Value</th>
					<th align="center"  colspan="3">Old Value</th>
					<th align="center" rowspan="2">Modified By</th>
					<th align="center" rowspan="2">Modified Date</th>
				</tr>
				<tr>
					<th align="center">VMW</th>
					<th align="center">IP1</th>
					<th align="center">IP2</th>
					<th align="center">VMW</th>
					<th align="center">IP1</th>
					<th align="center">IP2</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td align="center">
						<span data-bind="text: NewValue.VMW == 1 ? '☑' : '☒', style: { color:  NewValue.VMW == 1 ? 'darkblue' : 'red' }" style="padding-top:2px"></span>
					</td>
					<td align="center">
						<span data-bind="text: NewValue.IP1 == 1 ? '☑' : '☒', style: { color:  NewValue.IP1 == 1 ? 'darkblue' : 'red' }" style="padding-top:2px"></span>
					</td>
					<td align="center">
						<span data-bind="text: NewValue.IP2 == 1 ? '☑' : '☒', style: { color:  NewValue.IP2 == 1 ? 'darkblue' : 'red' }" style="padding-top:2px"></span>
					</td>

					<td align="center">
						<span data-bind="text: OldValue.VMW == 1 ? '☑' : '☒', style: { color:  OldValue.VMW == 1 ? 'darkblue' : 'red' }" style="padding-top:2px"></span>
					</td>
					<td align="center">
						<span data-bind="text: OldValue.IP1 == 1 ? '☑' : '☒', style: { color:  OldValue.IP1 == 1 ? 'darkblue' : 'red' }" style="padding-top:2px"></span>
					</td>
					<td align="center">
						<span data-bind="text: OldValue.IP2 == 1 ? '☑' : '☒', style: { color:  OldValue.IP2 == 1 ? 'darkblue' : 'red' }" style="padding-top:2px"></span>
					</td>
					
					<td data-bind="text: ModiUser"></td>
					<td data-bind="text: moment(ModiTime).format('DD-MM-YYYY HH:mm:ss')"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>

</div>

<?=latestJs('/media/ViewModel/VMWLogTrackingLog.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>