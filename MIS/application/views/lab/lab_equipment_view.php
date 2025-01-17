<style>
	.panel-body .table { width: max-content; }
	tbody input { width: 100%; }
	tbody select { width: 100%; height: 25px; }
</style>

<?php $this->view('lab/lab_menu'); ?>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh26 font16" style="position:sticky; left:21px">
			<b>Malaria National Reference Laboratory System</b>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<a href="/Home" class="btn btn-sm btn-home">Home</a>
		</div>
	</div>

	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" style="position:sticky; left:21px">
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Province</span>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group input-group-sm" data-bind="visible: pv() != 'CNM'">
				<span class="input-group-addon">OD</span>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group input-group-sm" data-bind="visible: pv() != 'CNM'">
				<span class="input-group-addon">HF</span>
				<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<button class="btn btn-sm btn-primary width80" data-bind="click: viewClick">View</button>
		</div>
		<div class="pull-right" style="position:sticky; right:11px" data-bind="visible: app.user.prov == '' && pv() == null">
			<button class="btn btn-sm btn-success" data-bind="click: exportExcel">Export All</button>
		</div>
		<div class="pull-right" data-bind="visible: loaded" style="position:sticky; right:11px">
			<button class="btn btn-sm btn-success width80" data-bind="click: exportExcel">Export</button>
			<button class="btn btn-sm btn-primary width80" data-bind="click: save">Save</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<table class="table table-bordered table-hover form-group">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="500">Item Description</th>
					<th align="center">Manufacturer</th>
					<th align="center">Model</th>
					<th align="center">Serial</th>
					<th align="center" width="100">Received Date</th>
					<th align="center">Qaulity</th>
					<th align="center">Condition</th>
					<th align="center" width="100">Need Maintenance</th>
					<th align="center" width="100">Maintenance Detail</th>
					<th align="center" width="60">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td><input type="text" data-bind="value: ItemName" /></td>
					<td><input type="text" data-bind="value: Manufacturer" /></td>
					<td><input type="text" data-bind="value: Model" /></td>
					<td><input type="text" data-bind="value: Serial" /></td>
					<td class="relative">
						<input type="text" data-bind="datePicker: ReceivedDate, dateType: 'string'" class="text-center" />
					</td>
					<td><input type="text" data-bind="value: Quality" /></td>
					<td><input type="text" data-bind="value: Condition" /></td>
					<td>
						<select data-bind="value: NeedMaintenance">
							<option></option>
							<option>Yes</option>
							<option>No</option>
						</select>
					</td>
					<td align="center" valign="middle">
						<a data-bind="click: $root.showDetail, visible: Rec_ID != null">Detail</a>
					</td>
					<td align="center" valign="middle">
						<a class="text-danger" data-bind="click: $root.deleteItem">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<button class="btn btn-sm btn-success" data-bind="click: addItem">Add Item</button>
	</div>
</div>

<div class="modal" id="modalDetail" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Maintenance Detail</h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead class="bg-thead">
						<tr>
							<th align="center">Maintenance Date</th>
							<th align="center">Next Maintenance Date</th>
							<th align="center">Delete</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: detailList">
						<tr>
							<td class="relative">
								<input type="text" data-bind="datePicker: MaintenanceDate, dataType: 'string'" class="text-center" />
							</td>
							<td class="relative">
								<input type="text" data-bind="datePicker: NextMaintenance, dataType: 'string'" class="text-center" />
							</td>
							<td align="center" valign="middle">
								<a class="text-danger" data-bind="click: $root.deleteDetail">Delete</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer clearfix">
				<div class="pull-left">
					<button class="btn btn-sm btn-success width80" data-bind="click: addDetail">Add</button>	
				</div>
				<div class="pull-right">
					<button class="btn btn-sm btn-primary width80" data-bind="click: saveDetail">Save</button>
					<button class="btn btn-sm btn-default width80" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabEquipment.js')?>