<style>
	table.child { position:sticky; left:60px; }
	table { cursor:default; }
	.underline:not(:empty):hover { text-decoration: underline; cursor: pointer; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left" style="position:sticky; left:21px">
			<a href="/CaseMonitoring/pf" class="btn btn-default width100">PF</a>
			<a href="/CaseMonitoring/pv" class="btn btn-info width100">PV</a>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" style="position:sticky; left:21px">
			<div class="inlineblock">
				<div class="text-bold">Province</div>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">OD</div>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">HC</div>
				<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock relative">
				<div class="text-bold">Notify Date</div>
				<input type="text" class="form-control text-center width100" data-bind="datePicker: notifyDate, showClear: true, dataType: 'string'" />
			</div>
			<div class="inlineblock">
				<div class="text-bold">Filter</div>
				<select class="form-control" data-bind="value: filter">
					<option>All Cases</option>
					<option>Eligible RCD</option>
					<option>Eligible G6PD</option>
					<option>Eligible Followup</option>
				</select>
				<select class="form-control" data-bind="value: colorFilter">
					<option value="all">All</option>
					<option value="red">Red Only</option>
					<option value="black">Black Only</option>
				</select>
			</div>
		</div>
        <div class="pull-right" style="position:sticky; right:21px; padding-top:20px">
            <button class="btn btn-success" data-bind="click: exportExcel, visible: app.user.role == 'AU'">Export Excel</button>
        </div>
	</div>
	<div class="panel-body">
		<table id="tblmain" class="table table-bordered table-hover text-nowrap">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center" sortable>Report<br />Type</th>
					<th align="center" sortable>Report<br />Month</th>
					<th align="center" sortable>Diagnosis<br />Date</th>
					<th align="center" sortable>Notify Date</th>
					<th align="center" sortable>Province</th>
					<th align="center" sortable>OD</th>
					<th align="center" sortable>HC</th>
					<th align="center" sortable>Village</th>
					<th align="center" sortable>Patient Name</th>
					<th align="center" sortable>Age</th>
					<th align="center" sortable>Sex</th>
					<th align="center" sortable>Weight</th>
					<th align="center" sortable>Pregnant</th>
					<th align="center" sortable>Species</th>
					<th align="center" sortable>Treatment</th>
					<th align="center" sortable>Refer</th>
					<th align="center" sortable>G6PD</th>
					<th align="center" sortable>Hemoglobin</th>
					<th align="center" sortable>Primaquine</th>
					<th align="center" sortable>Day3</th>
					<th align="center" sortable>Day7</th>
					<th align="center" sortable>Day14</th>
					<th align="center" sortable>Classify</th>
					<th align="center" sortable>RCD</th>
					<th align="center" sortable>Lastmile</th>
					<th sortable>Comment</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr data-bind="click: $root.rowClick, css: { 'text-danger': $root.isRed($data) }">
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: ReportType" align="center"></td>
					<td data-bind="text: ReportMonth" align="center"></td>
					<td data-bind="text: DateCase" align="center"></td>
					<td data-bind="text: NotifyDate" align="center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: NameK"></td>
					<td data-bind="text: Age" align="center"></td>
					<td data-bind="text: Sex == 'F' ? 'Female' : 'Male'" align="center"></td>
					<td data-bind="text: Weight" align="center"></td>
					<td data-bind="text: Pregnant == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: Diagnosis.toUpperCase(), click: $root.showCaseEntryForm" align="center" class="underline"></td>
					<td data-bind="text: Treatment"></td>
					<td data-bind="text: Refer"></td>
					<td data-bind="text: G6PDHb" align="center"></td>
					<td data-bind="text: G6PDdL" align="center"></td>
					<td data-bind="text: Primaquine" align="center"></td>
					<td data-bind="text: Day3 == 1 ? '✔' : $root.getFollowupDate($data, 3)" align="center"></td>
					<td data-bind="text: Day7 == 1 ? '✔' : $root.getFollowupDate($data, 7)" align="center"></td>
					<td data-bind="text: Day14 == 1 ? '✔' : $root.getFollowupDate($data, 14)" align="center"></td>
					<td data-bind="text: Classify" align="center"></td>
					<td data-bind="text: Reactive == 1 ? '✔' : '', click: $root.showReactiveForm" align="center" class="underline"></td>
					<td data-bind="text: Lastmile == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: Comment"></td>
				</tr>
				<tr data-bind="visible: visible">
					<td class="relative bg-success" data-bind="attr: { colspan: $root.colspan }">
						<table class="table table-bordered widthauto child">
							<thead class="bg-thead">
								<tr>
									<th align="center">RCD Date</th>
									<th align="center">Primaquine Date</th>
									<th align="center">Call Date</th>
									<th align="center">Call Person</th>
									<th align="center">Complete Response</th>
									<th>Comment</th>
									<th align="center">Edit</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td data-bind="text: ReactiveDate"></td>
									<td data-bind="text: PrimaquineDate" align="center"></td>
									<td data-bind="text: CallDate"></td>
									<td data-bind="text: CallPerson"></td>
									<td data-bind="text: Comment"></td>
									<td data-bind="text: CompleteDate" align="center"></td>
									<td align="center">
										<a data-bind="click: $root.showEdit, visible: app.user.permiss['Case Monitoring'].contain('Edit')">Edit</a>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Edit</h3>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group">
					<label class="control-label col-xs-2">Call:</label>
					<div class="col-xs-10">
						<div class="checkbox-inline checkbox-lg">
							<label>
								<input type="checkbox" data-bind="checked: CallDate() != '', click: $root.callClick" />
								<span style="margin-left:10px" data-bind="text: CallDate"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Call Person:</label>
					<div class="col-xs-10">
						<input type="text" data-bind="value: CallPerson" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Comment:</label>
					<div class="col-xs-10">
						<input type="text" data-bind="value: Comment" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Complete:</label>
					<div class="col-xs-10">
						<div class="checkbox-inline checkbox-lg">
							<label>
								<input type="checkbox" data-bind="checked: CompleteDate() != '', click: $root.completeClick" />
								<span style="margin-left:10px" data-bind="text: CompleteDate"></span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary width100" data-bind="click: save">Save</button>
				<button class="btn btn-default width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/CaseMonitoringPv.js')?>