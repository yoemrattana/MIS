<style>
	tbody input { width: 100%; }
	tbody select { width: 100%; height: 25px; }
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
		<div class="pull-left" style="position:sticky; left:21px">
			<?php $this->view('lab/lab_menu_'.$menu); ?>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<button class="btn btn-sm btn-success width80" data-bind="click: exportExcel">Export</button>
			<button class="btn btn-sm btn-primary width80" data-bind="click: showNew">New</button>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered table-hover widthauto">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center">Date From</th>
					<th align="center">Date To</th>
					<th align="center">Venue</th>
					<th align="center">Support</th>
					<th align="center">Batch</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td align="center" data-bind="text: moment(DateFrom).displayformat()"></td>
					<td align="center" data-bind="text: moment(DateTo).displayformat()"></td>
					<td align="center" data-bind="text: Venue"></td>
					<td align="center" data-bind="text: Support"></td>
					<td align="center" data-bind="text: Batch"></td>
					<td align="center">
						<a data-bind="click: $root.showEdit">Detail</a>
					</td>
					<td align="center">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
	<div class="panel-heading clearfix hidden-print">
		<div class="pull-left lh26" style="position:sticky; left:21px">
			<b>Detail</b>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<button class="btn btn-sm btn-success width80" data-bind="click: () => print()">Print</button>
			<button class="btn btn-sm btn-primary width80" data-bind="click: save">Save</button>
			<button class="btn btn-sm btn-default width80" data-bind="click: back">Back</button>
		</div>
	</div>

	<div class="panel-body">
		<div class="form-group form-inline" data-bind="with: editModel">
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Date From</span>
				<input type="text" class="form-control width100 text-center" data-bind="datePicker: DateFrom, dataType: 'string'" />
				<span class="input-group-addon">To</span>
				<input type="text" class="form-control width100 text-center" data-bind="datePicker: DateTo, dataType: 'string'" />
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Venue</span>
				<input type="text" class="form-control" data-bind="textInput: Venue" style="width:500px" />
			</div>
		</div>
		<div class="form-group form-inline" data-bind="with: editModel">
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Support</span>
				<input type="text" class="form-control" data-bind="textInput: Support" />
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Batch</span>
				<input type="text" class="form-control" data-bind="textInput: Batch" />
			</div>
		</div>

		<table class="table table-bordered table-hover widthauto form-group">
			<thead class="bg-thead">
				<tr>
					<th align="center">No</th>
					<th align="center">Name in Khmer</th>
					<th align="center">Name in English</th>
					<th align="center">Sex</th>
					<th align="center">Age</th>
					<th align="center">Year in Service</th>
					<th align="center">Education Level</th>
					<th align="center">Province</th>
					<th align="center">Organization</th>
					<th align="center">Phone</th>
					<th align="center">ACLEDA Account</th>
					<th align="center" class="hidden-print">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: NameK" class="kh"></td>
					<td data-bind="text: Name"></td>
					<td data-bind="text: Sex" align="center"></td>
					<td data-bind="text: $root.getAge(YOB)" align="center"></td>
					<td data-bind="text: Working" align="center"></td>
					<td data-bind="text: Certificate" align="center"></td>
					<td data-bind="text: $root.getPVName(Code_Facility_T)" align="center"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)" align="center"></td>
					<td data-bind="text: Phone" align="center"></td>
					<td data-bind="text: BankAccount" align="center"></td>
					<td align="center" class="hidden-print">
						<a class="text-danger" data-bind="click: $root.deleteStaff">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<button class="btn btn-sm btn-success hidden-print" data-bind="click: showAdd">Add Trainee</button>
	</div>
</div>

<div class="modal" id="modalStaff" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:400px">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Add Staff</h3>
			</div>
			<div class="modal-body">
				<table class="table">
					<tr>
						<th valign="middle" width="80">Province:</th>
						<td>
							<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr data-bind="visible: pv() != 'CNM'">
						<th valign="middle">OD:</th>
						<td>
							<select class="form-control" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr data-bind="visible: pv() != 'CNM'">
						<th valign="middle">RH:</th>
						<td>
							<select class="form-control" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th valign="middle">Staff:</th>
						<td>
							<select class="form-control" data-bind="value: staff, options: staffList(), optionsText: 'Name', optionsCaption: ''"></select>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-success width80" data-bind="click: addStaff">Add</button>
				<button class="btn btn-sm btn-default width80" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabTraining.js')?>