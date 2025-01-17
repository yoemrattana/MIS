<style>
	.tblmember { border:1px solid gray; }
	.tblmember th, .tblmember td { border:1px solid gray !important; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() != 'detail'">
		<div class="pull-left">
			<button class="btn width100" data-bind="click: menuClick, css: menuCss($element)">Training</button>
			<button class="btn width100" data-bind="click: menuClick, css: menuCss($element)">Meeting</button>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>

	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left form-inline">
			<div class="input-group">
				<span class="input-group-addon">OD</span>
				<select type="text" class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Year</span>
				<select type="text" class="form-control" data-bind="value: year, options: yearList"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Month</span>
				<select type="text" class="form-control" data-bind="value: month, options: monthList, optionsCaption: 'All'"></select>
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: ifcan('Edit')">New</button>
			<button class="btn btn-success" data-bind="click: exportExcel">Export Excel</button>
		</div>
	</div>

	<!-- ko if: menu() == 'Training' -->
	<!-- ko with: Training -->
	<div class="panel-heading clearfix" data-bind="visible: view() == 'detail'">
		<div class="pull-right" data-bind="visible: view() == 'detail'">
			<button class="btn btn-primary width100" data-bind="click: save, visible: $root.ifcan('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered table-hover">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center" sortable>OD</th>
					<th align="center" sortable>Training Type</th>
					<th align="center" sortable>Training On</th>
					<th align="center" sortable>Training Date</th>
					<th align="center" sortable>Training To</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60" data-bind="visible: $root.ifcan('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel(), fixedHeader: true, sortModel: listModel">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)"></td>
					<td align="center" data-bind="text: Type"></td>
					<td data-bind="text: About, css: { kh: iskhmer(About) }"></td>
					<td align="center" data-bind="text: moment(StartDate).displayformat()"></td>
					<td align="center" data-bind="text: TrainTo"></td>
					<td align="center">
						<a data-bind="click: $parent.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: $root.ifcan('Delete')">
						<a class="text-danger" data-bind="click: $parent.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: view() == 'detail', with: editModel">
		<div class="kh" style="margin:auto; width:1000px">
			<h3 class="text-center text-primary">ទម្រង់វគ្គបណ្តុះបណ្តាល</h3>
			<br />

			<div style="border:1px solid gray; padding:10px" data-bind="with: head">
				<div class="form-group form-inline">
					<div class="input-group">
						<span class="input-group-addon">ស្រុកប្រតិបត្តិ</span>
						<select class="form-control en" data-bind="value: Code_OD_T, options: $root.odList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group form-inline en">
					<div class="form-group">
						<div class="input-group">
							<kh class="input-group-addon">ចាប់ពីថ្ងៃ</kh>
							<input type="text" class="form-control text-center width120" data-bind="datePicker: StartDate, dataType: 'string'" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<kh class="input-group-addon">រហូតដល់ថ្ងៃ</kh>
							<input type="text" class="form-control text-center width120 en" data-bind="datePicker: EndDate, dataType: 'string'" />
						</div>
					</div>
				</div>
				<div class="form-group form-inline">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">ប្រភេទវគ្គបណ្តុះបណ្តាល</span>
							<select class="form-control en" data-bind="value: Type">
								<option></option>
								<option>Case Management</option>
								<option>Surveillance</option>
								<option>MIS</option>
								<option>Laboratory (Microscopist)</option>
								<option>iDES</option>
								<option>Entomology</option>
								<option>Pv Radical Cure</option>
								<option>Drug Store Management</option>
								<option>MRRT – Malaria Rapid Response Team</option>
								<option>FETP Frontline – Field Epidemiology Training Program</option>
								<option>POR – Prevention of Malaria Introduction Training</option>
								<option>Integration VMWs Training</option>
								<option>Micro Plan</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">បណ្តុះបណ្តាលទៅកាន់</span>
							<select class="form-control en" data-bind="value: TrainTo">
								<option></option>
								<option>PHD</option>
								<option>ODMS</option>
								<option>HFs</option>
								<option>VMWs/MMWs</option>
								<option>PHD & ODMS</option>
								<option>ODMS & HFs</option>
								<option>Other</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<div class="input-group">
						<span class="input-group-addon">បណ្តុះបណ្តាលអំពី</span>
						<input type="text" class="form-control" data-bind="value: About" />
					</div>
				</div>
			</div>
			<br />

			<h4>បញ្ជីរាយនាមអ្នកចូលរួម</h4>
			<table class="table table-bordered tblmember">
				<thead class="bg-thead">
					<tr>
						<th align="center" width="40">#</th>
						<th align="center">ឈ្មោះ</th>
						<th align="center" width="120">ភេទ</th>
						<th align="center">តួនាទី</th>
						<th align="center" width="120">ប្រភេទ</th>
						<th width="35"></th>
					</tr>
				</thead>
				<tbody data-bind="foreach: body, fixedHeader: true">
					<tr>
						<td align="center" valign="middle" class="en" data-bind="text: $index() + 1 < $parent.body().length ? $index() + 1 : ''"></td>
						<td>
							<input type="text" class="form-control" data-bind="textInput: Name" />
						</td>
						<td>
							<select class="form-control en" data-bind="value: Sex">
								<option></option>
								<option>Male</option>
								<option>Female</option>
							</select>
						</td>
						<td>
							<input type="text" class="form-control" data-bind="textInput: Position" />
						</td>
						<td>
							<select class="form-control en" data-bind="value: Type">
								<option></option>
								<option>Trainee</option>
								<option>Trainer</option>
								<option>Facilitator</option>
							</select>
						</td>
						<td align="center" valign="middle" role="button" data-bind="click: $parents[1].removeParticipant">
							<span class="material-icons text-danger">delete_outline</span>
						</td>
					</tr>
				</tbody>
			</table>
			<br />

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">លទ្ធផលវគ្គបណ្តុះបណ្តាល</span>
					<input type="text" class="form-control" data-bind="value: head.Result" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ជំហានបន្ទាប់</span>
					<input type="text" class="form-control" data-bind="value: head.NextStep" />
				</div>
			</div>
		</div>
	</div>

	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && $root.ifcan('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
	<!-- /ko -->
	<!-- /ko -->

	<!-- ko if: menu() == 'Meeting' -->
	<!-- ko with: Meeting -->
	<div class="panel-heading clearfix" data-bind="visible: view() == 'detail'">
		<div class="pull-right" data-bind="visible: view() == 'detail'">
			<button class="btn btn-primary width100" data-bind="click: save, visible: $root.ifcan('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered table-hover">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center" sortable>OD</th>
					<th align="center" sortable>Meeting Type</th>
					<th align="center" sortable>Meeting On</th>
					<th align="center" sortable>Meeting Date</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60" data-bind="visible: $root.ifcan('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel(), fixedHeader: true, sortModel: listModel">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)"></td>
					<td align="center" data-bind="text: Type"></td>
					<td data-bind="text: About, css: { kh: iskhmer(About) }"></td>
					<td align="center" data-bind="text: moment(StartDate).displayformat()"></td>
					<td align="center">
						<a data-bind="click: $parent.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: $root.ifcan('Delete')">
						<a class="text-danger" data-bind="click: $parent.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: view() == 'detail', with: editModel">
		<div class="kh" style="margin:auto; width:1000px">
			<h3 class="text-center text-primary">ទម្រង់កិច្ចប្រជុំ</h3>
			<br />

			<div style="border:1px solid gray; padding:10px" data-bind="with: head">
				<div class="form-group form-inline">
					<div class="input-group">
						<span class="input-group-addon">ស្រុកប្រតិបត្តិ</span>
						<select class="form-control en" data-bind="value: Code_OD_T, options: $root.odList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group form-inline en">
					<div class="form-group">
						<div class="input-group">
							<kh class="input-group-addon">ចាប់ពីថ្ងៃ</kh>
							<input type="text" class="form-control text-center width120" data-bind="datePicker: StartDate, dataType: 'string'" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<kh class="input-group-addon">រហូតដល់ថ្ងៃ</kh>
							<input type="text" class="form-control text-center width120 en" data-bind="datePicker: EndDate, dataType: 'string'" />
						</div>
					</div>
				</div>
				<div class="form-group form-inline">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">ប្រភេទនៃកិច្ចប្រជុំ</span>
							<select class="form-control en" data-bind="value: Type">
								<option></option>
								<option>PSMET – Provincial Special Malaria Elimination Task Force</option>
								<option>DSMET – District Special Malaria Elimination Task Force</option>
								<option>AOP – Annual Operational Plan</option>
								<option>HCMC – Health Center Management Committee (Semester Meeting)</option>
								<option>PPM – Private Provider Meeting (Semester Meeting)</option>
								<option>Inter Provincial Meeting</option>
								<option>Elimination Working Group</option>
								<option>Other</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<div class="input-group">
						<span class="input-group-addon">កិច្ចប្រជុំស្តីអំពី</span>
						<input type="text" class="form-control" data-bind="value: About" />
					</div>
				</div>
			</div>
			<br />

			<h4>បញ្ជីរាយនាមអ្នកចូលរួម</h4>
			<table class="table table-bordered tblmember">
				<thead class="bg-thead">
					<tr>
						<th align="center" width="40">#</th>
						<th align="center">ឈ្មោះ</th>
						<th align="center" width="120">ភេទ</th>
						<th align="center">តួនាទី</th>
						<th width="35"></th>
					</tr>
				</thead>
				<tbody data-bind="foreach: body, fixedHeader: true">
					<tr>
						<td align="center" valign="middle" class="en" data-bind="text: $index() + 1 < $parent.body().length ? $index() + 1 : ''"></td>
						<td>
							<input type="text" class="form-control" data-bind="textInput: Name" />
						</td>
						<td>
							<select class="form-control en" data-bind="value: Sex">
								<option></option>
								<option>Male</option>
								<option>Female</option>
							</select>
						</td>
						<td>
							<input type="text" class="form-control" data-bind="textInput: Position" />
						</td>
						<td align="center" valign="middle" role="button" data-bind="click: $parents[1].removeParticipant">
							<span class="material-icons text-danger">delete_outline</span>
						</td>
					</tr>
				</tbody>
			</table>
			<br />

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">លទ្ធផលនៃកិច្ចប្រជុំ</span>
					<input type="text" class="form-control" data-bind="value: head.Result" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ជំហានបន្ទាប់</span>
					<input type="text" class="form-control" data-bind="value: head.NextStep" />
				</div>
			</div>
		</div>
	</div>

	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && $root.ifcan('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
	<!-- /ko -->
	<!-- /ko -->
</div>

<?=latestJs('/media/ViewModel/TrainingMeeting.js')?>