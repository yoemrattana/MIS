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
			<button class="btn btn-sm btn-primary width80" data-bind="click: viewClick">View</button>
		</div>
		<div class="pull-right" style="position:sticky; right:11px" data-bind="visible: app.user.prov == '' && pv() == null">
			<button class="btn btn-sm btn-success" data-bind="click: exportExcel">Export All</button>
		</div>
		<div class="pull-right" style="position:sticky; right:11px" data-bind="visible: loaded">
			<button class="btn btn-sm btn-success width80" data-bind="click: exportExcel">Export</button>
			<button class="btn btn-sm btn-primary width80" data-bind="click: save">Save</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<table class="table table-bordered table-hover form-group">
			<thead class="bg-thead">
				<tr>
					<th align="center" rowspan="2" width="30">#</th>
					<th align="center" rowspan="2" width="150">Staff Name (English)</th>
					<th align="center" rowspan="2" width="150">Staff Name (Khmer)</th>
					<th align="center" rowspan="2" width="150">Position</th>
					<th align="center" rowspan="2" width="90">Marital Status</th>
					<th align="center" rowspan="2" width="50">Sex</th>
					<th align="center" rowspan="2" width="80">YOB</th>
					<th align="center" rowspan="2">Age</th>
					<th align="center" rowspan="2" width="80">YOW</th>
					<th align="center" rowspan="2">Working</th>
					<th align="center" rowspan="2" width="150">Certificate</th>
					<th align="center" rowspan="2" width="150">Phone</th>
					<th align="center" rowspan="2" width="150">ACLEDA Account</th>
					<th align="center" rowspan="2" width="150">Remark</th>
					<th align="center" colspan="2">Basic Malaria Training</th>
					<th align="center" colspan="2">Refresher Malaria Training</th>
					<th align="center" colspan="2">NCAMM</th>
					<th align="center" colspan="2">Pre-ECAMM</th>
					<th align="center" colspan="2">ECAMM</th>
					<th align="center" rowspan="2" width="90">Interesting for</th>
					<th align="center" rowspan="2" width="70">Forcol Group</th>
					<th align="center" rowspan="2" width="70">Activity</th>
					<th align="center" rowspan="2" width="60">Delete</th>
				</tr>
				<tr>
					<th align="center">Year</th>
					<th align="center">Score</th>
					<th align="center">Year</th>
					<th align="center">Score</th>
					<th align="center">Year</th>
					<th align="center">Level</th>
					<th align="center">Year</th>
					<th align="center">Level</th>
					<th align="center">Year</th>
					<th align="center">Level</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true, fixedColumn: 3, fixedLeft: $('.menubox').outerWidth()">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td><input type="text" data-bind="value: Name" /></td>
					<td><input type="text" data-bind="value: NameK" /></td>
					<td><input type="text" data-bind="value: Position" /></td>
					<td>
						<select data-bind="value: MaritalStatus">
							<option></option>
							<option>Single</option>
							<option>Married</option>
						</select>
					</td>
					<td>
						<select data-bind="value: Sex">
							<option></option>
							<option>M</option>
							<option>F</option>
						</select>
					</td>
					<td><input type="text" data-bind="value: YOB" class="text-center" numonly="int" maxlength="4" /></td>
					<td align="center" data-bind="text: $root.getAge(YOB())"></td>
					<td><input type="text" data-bind="value: YOW" class="text-center" numonly="int" maxlength="4" /></td>
					<td align="center" data-bind="text: Working"></td>
					<td><input type="text" data-bind="value: Certificate" /></td>
					<td><input type="text" data-bind="value: Phone" class="text-center" numonly="int" /></td>
					<td><input type="text" data-bind="value: BankAccount" class="text-center" /></td>
					<td><input type="text" data-bind="value: Remark" /></td>
					<td align="center" data-bind="text: BasicYear"></td>
					<td align="center" data-bind="text: BasicScore"></td>
					<td align="center" data-bind="text: RefresherYear"></td>
					<td align="center" data-bind="text: RefresherScore"></td>
					<td align="center" data-bind="text: NCAMMYear"></td>
					<td align="center" data-bind="text: NCAMMScore"></td>
					<td align="center" data-bind="text: PreECAMMYear"></td>
					<td align="center" data-bind="text: PreECAMMScore"></td>
					<td align="center" data-bind="text: ECAMMYear"></td>
					<td align="center" data-bind="text: ECAMMScore"></td>
					<td>
						<select data-bind="value: Interesting">
							<option></option>
							<option>Yes</option>
							<option>No</option>
						</select>
					</td>
					<td>
						<select data-bind="value: Forcol">
							<option></option>
							<option>Yes</option>
							<option>No</option>
						</select>
					</td>
					<td align="center">
						<a data-bind="click: $root.showEvent, visible: Staff_ID() > 0">Activity</a>
					</td>
					<td align="center">
						<a class="text-danger" data-bind="click: $root.delete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<button class="btn btn-sm btn-success" data-bind="click: addStaff">Add Staff</button>
	</div>
</div>

<div class="modal" id="modalEvent" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:750px">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" data-bind="text: staffName"></h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead class="bg-thead">
						<tr>
							<th width="100" align="center">From Date</th>
							<th width="100" align="center">To Date</th>
							<th width="110" align="center">Event Type</th>
							<th width="170" align="center">Event Name</th>
							<th width="100" align="center">Score/Level</th>
							<th align="center">Next Training</th>
							<th></th>
						</tr>
					</thead>
					<tbody data-bind="foreach: eventList">
						<tr>
							<td class="relative">
								<input type="text" class="text-center" data-bind="datePicker: FromDate, dataType: 'string'" />
							</td>
							<td class="relative">
								<input type="text" class="text-center" data-bind="datePicker: ToDate, dataType: 'string'" />
							</td>
							<td>
								<select data-bind="value: EventType, change: $root.eventChange">
									<option></option>
									<option>Training</option>
									<option>Meeting</option>
									<option>Supervision</option>
								</select>
							</td>
							<td>
								<input type="text" data-bind="value: EventName, visible: EventType() != 'Training'" />

								<select data-bind="value: EventName, visible: EventType() == 'Training'">
									<option></option>
									<option>Basic Malaria</option>
									<option>Refresher</option>
									<option>NCAMM</option>
									<option>Pre-ECAMM</option>
									<option>ECAMM</option>
								</select>
							</td>
							<td>
								<input type="text" class="text-center" data-bind="value: Score, enable: EventType() == 'Training'" />
							</td>
							<td>
								<input type="text" class="text-center" data-bind="value: NextTraining, enable: EventType() == 'Training'" />
							</td>
							<td valign="middle" role="button" class="no-padding" data-bind="click: $root.deleteEvent">
								<span class="material-icons text-danger">delete_outline</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer clearfix">
				<div class="pull-left">
					<button class="btn btn-sm btn-success width80" data-bind="click: addEvent">Add</button>
				</div>
				<div class="pull-right">
					<button class="btn btn-sm btn-primary width80" data-bind="click: saveEvent">Save</button>
					<button class="btn btn-sm btn-default width80" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabStaff.js')?>