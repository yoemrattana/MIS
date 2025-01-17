<style>
	tbody input { width: 100%; }
	td a { display: block; }
</style>

<?php $this->view('lab/lab_menu'); ?>

<div class="panel panel-default" data-bind="visible: view() == 'list'" style="display:none">
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
			<div class="input-group input-group-sm relative">
				<span class="input-group-addon">Year</span>
				<input type="text" class="form-control width80 text-center" data-bind="datePicker: year, format: 'YYYY', minDate: '2024-01-01'" />
			</div>
			<button class="btn btn-sm btn-primary width80" data-bind="click: viewClick">View</button>
		</div>
		<div class="pull-right" style="position:sticky; right:11px" data-bind="visible: app.user.prov == '' && pv() == null">
			<button class="btn btn-sm btn-success" data-bind="click: exportExcel">Export All</button>
		</div>
		<div class="pull-right" style="position:sticky; right:11px" data-bind="visible: loaded">
			<button class="btn btn-sm btn-success width80" data-bind="click: exportExcel">Export</button>
			<button class="btn btn-sm btn-success" data-bind="click: showManage">Manage Item</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<table class="table table-bordered">
			<thead class="bg-thead">
				<tr data-bind="foreach: Array(12)">
					<th align="center" data-bind="text: moment().month($index()).format('MMM')"></th>
				</tr>
			</thead>
			<tbody>
				<tr data-bind="foreach: reportList">
					<td align="center" class="text-bold font16" data-bind="if: Month <= moment().month() + 1">
						<a data-bind="click: $root.showDetail, text: Has() ? '✔' : 'O', style: { color: Has() ? 'darkblue' : 'red' }"></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh26">
			<b>HF:</b>
			<span data-bind="text: getHCName()"></span>

			<b style="margin-left:20px">Report Month:</b>
			<span data-bind="text: head().month + '-' + head().year"></span>
		</div>
		<div class="pull-right">
			<button class="btn btn-sm btn-primary width80" data-bind="click: saveStock">Save</button>
			<button class="btn btn-sm btn-danger width80" data-bind="click: deleteStock, visible: head().has">Delete</button>
			<button class="btn btn-sm btn-default width80" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-hover table-striped">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center">Item Description</th>
					<th align="center" width="100">Start</th>
					<th align="center" width="100">In</th>
					<th align="center" width="100">Out</th>
					<th align="center" width="100">Adjust</th>
					<th align="center" width="100">Balance</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td align="center" valign="middle" data-bind="text: $index() + 1"></td>
					<td valign="middle" data-bind="text: ItemName"></td>
					<td align="center" valign="middle" data-bind="text: StockStart"></td>
					<td>
						<input type="text" class="text-center" data-bind="textInput: StockIn" />
					</td>
					<td>
						<input type="text" class="text-center" data-bind="textInput: StockOut" />
					</td>
					<td>
						<input type="text" class="text-center" data-bind="textInput: Adjustment" />
					</td>
					<td align="center" valign="middle" data-bind="text: Balance, css: Balance() < 0 ? 'text-danger text-bold' : ''"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="modal" id="modalManage" tabindex="-1" role="dialog" style="z-index:1049">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" data-bind="text: getHCName()"></h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead class="bg-thead">
						<tr>
							<th align="center" width="30">#</th>
							<th align="center">Item Description</th>
							<th align="center" width="60">Delete</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: itemList">
						<tr>
							<td align="center" valign="middle" data-bind="text: $index() + 1"></td>
							<td>
								<input type="text" data-bind="value: ItemName" />
							</td>
							<td align="center" valign="middle">
								<a class="text-danger" data-bind="click: $root.deleteItem">Delete</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer clearfix">
				<div class="pull-left">
					<button class="btn btn-sm btn-success width80" data-bind="click: addItem">Add</button>
				</div>
				<div class="pull-right">
					<button class="btn btn-sm btn-primary width80" data-bind="click: saveItem">Save</button>
					<button class="btn btn-sm btn-default width80" data-dismiss="modal" data-bind="click: closeManage">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabStock.js')?>