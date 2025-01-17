<style>
	.panel-body .table { width: max-content; }
	tbody input { width: 100%; }
	tbody select { width: 100%; height: 25px; }
	td { vertical-align: middle !important; }
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
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Date</span>
				<select class="form-control widthauto" data-bind="value: year, options: yearList"></select>
				<select class="form-control widthauto" data-bind="value: month, options: monthList" style="border-left:none"></select>
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
					<th align="center" width="60">Slide ID</th>
					<th align="center">Name</th>
					<th align="center" width="60">Age</th>
					<th align="center">Sex</th>
					<th align="center">Address</th>
					<th align="center">Cross Area</th>
					<th align="center">Transfer From</th>
					<th align="center" width="80">RDT</th>
					<th align="center" width="80">Microscope D1</th>
					<th align="center" width="80">Microscope D2</th>
					<th align="center" width="80">Parasite Counting</th>
					<th align="center" width="60">C1</th>
					<th align="center" width="60">C2</th>
					<th align="center" width="70">G6PD</th>
					<th align="center" width="70">Hb</th>
					<th align="center" width="70">Hb-3</th>
					<th align="center" width="70">Hb-7</th>
					<th align="center" width="100">Collection Date</th>
					<th align="center">Lab Staff</th>
					<th width="35"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Rec_ID() || 'Auto'" align="center"></td>
					<td>
						<input type="text" data-bind="value: Name, disable: D1() == 'N' && Name('')" />
					</td>
					<td>
						<input type="text" data-bind="value: Age" numonly="int" />
					</td>
					<td>
						<select data-bind="value: Sex">
							<option></option>
							<option>M</option>
							<option>F</option>
						</select>
					</td>
					<td>
						<input type="text" data-bind="value: $root.getPlaceName(Address()), click: $root.choosePlace, disable: D1() == 'N' && Address(null)" readonly />
					</td>
					<td>
						<input type="text" data-bind="value: CrossArea, disable: D1() == 'N' && CrossArea('')" />
					</td>
					<td>
						<input type="text" data-bind="value: TransferFrom, disable: D1() == 'N' && TransferFrom('')" />
					</td>
					<td>
						<select data-bind="value: RDT, disable: D1() == 'N' && RDT('')">
							<option></option>
							<option value="F">PF</option>
							<option value="V">PV</option>
							<option value="A">PM</option>
							<option value="K">PK</option>
							<option value="O">PO</option>
							<option value="N">NMPS</option>
						</select>
					</td>
					<td>
						<select data-bind="value: D1">
							<option></option>
							<option value="F">PF</option>
							<option value="V">PV</option>
							<option value="A">PM</option>
							<option value="K">PK</option>
							<option value="O">PO</option>
							<option value="N">NMPS</option>
						</select>
					</td>
					<td>
						<select data-bind="value: D2, disable: D1() == 'N' && D2('')">
							<option></option>
							<option value="F">PF</option>
							<option value="V">PV</option>
							<option value="A">PM</option>
							<option value="K">PK</option>
							<option value="O">PO</option>
							<option value="N">NMPS</option>
						</select>
					</td>
					<td>
						<input type="text" data-bind="value: ParasiteCount, disable: D1() == 'N' && ParasiteCount('')" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: C1, disable: D1() == 'N' && C1('')" />
					</td>
					<td>
						<input type="text" data-bind="value: C2, disable: D1() == 'N' && C2('')" />
					</td>
					<td>
						<input type="text" data-bind="value: G6PD, disable: D1() == 'N' && G6PD('')" numonly="float" />
					</td>
					<td>
						<input type="text" data-bind="value: Hb, disable: D1() == 'N' && Hb('')" numonly="float" />
					</td>
					<td>
						<input type="text" data-bind="value: Hb3, disable: D1() == 'N' && Hb3('')" numonly="float" />
					</td>
					<td>
						<input type="text" data-bind="value: Hb7, disable: D1() == 'N' && Hb7('')" numonly="float" />
					</td>
					<td class="relative">
						<input type="text" class="text-center" data-bind="datePicker: CollectionDate, dataType: 'string'" />
					</td>
					<td>
						<select data-bind="value: Staff_ID, options: $root.staffList, optionsValue: 'Staff_ID', optionsText: 'Name', optionsCaption: ''"></select>
					</td>
					<td role="button" data-bind="click: $root.showDelete">
						<span class="material-icons text-danger">delete_outline</span>
					</td>
				</tr>
			</tbody>
		</table>
		<button class="btn btn-sm btn-success width80" data-bind="click: addNew">New</button>
	</div>
</div>

<div class="modal" id="modalPlace" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content" data-bind="with: placeModel">
			<div class="modal-header">
				<h3 class="modal-title text-primary"></h3>
			</div>
			<div class="modal-body">
				<table class="table">
					<tr>
						<th width="100" align="right" valign="middle">Province</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">District</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: ds, options: dsList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Commune</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: cm, options: cmList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Village</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: vl, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-primary width80" data-dismiss="modal" data-bind="click: ok">OK</button>
				<button class="btn btn-sm btn-default width80" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabLogbook.js')?>