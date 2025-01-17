<style>
	.fixRight { position: fixed; right: 10px; top: 11px; }
	.table > thead { background-color: #9AD8ED; }
	#tblreport a { display: block; }
	#tblcase { min-width: 1700px; }
	#tblcase thead td { text-align: center; }
	#tblcase tbody td { font-size: 12px; text-align:center; vertical-align: middle; padding: 0px 2px; height:30px; }
	#tblcase tbody td .btn-sm { font-size: 12px; line-height:15px; border-radius:2px; }
	#tblcase tbody input[type="text"] { width: 100%; padding: 0; }
	#tblcase tbody select { width: 100%; padding: 1px 1px 2px 1px; }
	#tblcase tbody td.hasCheckbox { padding: 0; }
	#tblcase tbody td.hasCheckbox input { width:20px; height:20px; margin-top: 4px; }
	.btn-group > .btn + .dropdown-toggle { padding-left: 6px; padding-right: 6px; }
	.dropdown-menu > li > a { padding: 4px 12px; }
	.dropdown-menu > li > a:hover { background-color: #ffff99; }
	.total { display:table; margin:auto; margin-top:20px; margin-bottom:20px; padding:10px 20px; border:1px solid #ccc; background-color: #f5f5f5; }
	.total p { width: 270px; }
	.total .form-control { width: 70px; text-align: center; }
	.total .form-group { margin-bottom: 5px; }
	select[disabled] { cursor: not-allowed; background-color: #eeeeee; }
	input[type="text"][disabled] { cursor: not-allowed !important; }
</style>

<div class="panel panel-default" data-bind="visible: isListView" style="display:none">
	<div class="panel-heading clearfix relative">
		<div class="pull-center form-inline">
			<div class="input-group input-group-sm width150">
				<span class="input-group-btn">
					<button data-bind="click: previousYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-left"></i>
					</button>
				</span>
				<input data-bind="value: year" type="text" class="form-control text-center" style="background-color:white" readonly />
				<span class="input-group-btn">
					<button data-bind="click: nextYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-right"></i>
					</button>
				</span>
			</div>
			<select data-bind="options: rgList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: isSingle(rgList()) ? undefined : 'Select Regional',
					value: rg" class="form-control input-sm minwidth150 kh"></select>

			<select data-bind="options: unitList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: isSingle(unitList()) ? undefined : 'Select Unit',
					value: unit" class="form-control input-sm minwidth150"></select>
		</div>
		<div class="pull-left font16 lh28">
			<b>MMP Report Received</b>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table id="tblreport" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Group</th>
					<th>Khmer Name</th>
					<!--ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: reportList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Group_E"></td>
					<td data-bind="text: Name_Group_K" class="kh"></td>
					<!--ko foreach: reports -->
					<th class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? 'X' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $parent?.HasPhone ? $root.showCaseEntryForm : $root.editReport,
						   visible: $root.visibleReport($data)" style="padding-top:2px"></a>
					</th>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="hidden: isListView" style="margin:-10px; display:none">
	<div class="panel-heading clearfix" data-bind="with: master">
		<div class="pull-left lh26">
			<b>Regional:</b>
			<span data-bind="text: rg"></span>

			<b style="margin-left:20px">Province:</b>
			<span data-bind="text: unit"></span>

			<b style="margin-left:20px">Group:</b>
			<span data-bind="text: en"></span>
			<span> - </span>
			<kh data-bind="text: kh"></kh>

			<b style="margin-left:20px">Monthly Report:</b>
			<span data-bind="text: month"></span>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: $root.saveReport, visible: app.user.permiss['MMP Data'].contain('Edit')">Save</button>
			<button class="btn btn-danger btn-sm width100" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['MMP Data'].contain('Delete')">Delete</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back" style="margin-left:30px">Back</button>
		</div>
	</div>
	<div class="panel-body no-padding">
		<table id="tblcase" class="table table-bordered table-hover">
			<thead>
				<tr>
					<td width="40" class="text-middle">#</td>
					<td width="100"><kh>ថ្ងៃខែឆ្នាំ</kh><br />Date</td>
					<td><kh>ឈ្មោះ</kh><br />Name</td>
					<td width="50"><kh>ភេទ</kh><br />Sex</td>
					<td width="50"><kh>អាយុ</kh><br />Age</td>
					<td width="122"><kh>ប្រភេទអ្នកចូលរួម</kh><br />Participant Type</td>
					<td width="64"><kh>ធ្លាប់មាន<br />គ្រុនចាញ់</kh></td>
					<td width="78"><kh>សញ្ញាគ្លីនិក</kh><br />Clinic Sign</td>
					<td width="104"><kh>សភាពជំងឺ</kh><br />Status</td>
					<td width="80"><kh>ផ្ទៃពោះ</kh><br />Pregnant</td>
					<td width="74"><kh>លទ្ធផល<br />តេស្តរហ័ស</kh></td>
					<td width="90"><kh>លទ្ធផល<br />មន្ទីរពិសោធន៍</kh></td>
					<td colspan="2"><kh>ថ្នាំព្យាបាល</kh><br />Medicine</td>
					<td width="115"><kh>លទ្ធផល</kh><br />Result</td>
					<td width="56"><kh>ប្រើមុង</kh><br />Bednet</td>
					<td width="150"><kh>ផ្សេងៗ</kh><br />Other</td>
					<td width="96" data-bind="visible: app.user.role.in('ML','AU')"></td>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: Rec_ID() == -1 ? '-' : $index() + 1"></td>
					<td class="relative">
						<input type="text" data-bind="datePicker: DateCase, minDate: Rec_ID() < 1 ? $root.getMinDate() : undefined, maxDate: Rec_ID() < 1 ? $root.getMaxDate() : undefined, defaultDate: Rec_ID() < 1 ? $root.getDefaultDate() : undefined" class="text-center" />
					</td>
					<td>
						<input type="text" data-bind="textInput: Name" />
					</td>
					<td>
						<select data-bind="value: Sex">
							<option>M</option>
							<option>F</option>
						</select>
					</td>
					<td>
						<input type="text" data-bind="textInput: Age" class="text-center" maxlength="2" />
					</td>
					<td>
						<select data-bind="value: Participant">
							<!-- ko if: Rec_ID() == -1 -->
							<option></option>
							<!-- /ko -->
							<option value="Military">យោធា Military</option>
							<option value="People">ប្រជាជន People</option>
							<option value="Mobile">ចល័ត Mobile</option>
						</select>
					</td>
					<td>
						<input type="text" data-bind="textInput: SickQty" class="text-center" maxlength="2" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: ClinicSign" />
					</td>
					<td>
						<select data-bind="value: Status">
							<!-- ko if: Rec_ID() == -1 -->
							<option></option>
							<!-- /ko -->
							<option value="Severe">ធ្ងន់ Severe</option>
							<option value="Simple">ស្រាល Simple</option>
						</select>
					</td>
					<td>
						<select data-bind="value: Pregnant, enable: Sex() == 'F'">
							<option></option>
							<option value="N">No</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="0">Unknown</option>
						</select>
					</td>
					<td>
						<select data-bind="value: RDT">
							<option></option>
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
						</select>
					</td>
					<td>
						<select data-bind="value: Microscopy">
							<option></option>
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
						</select>
					</td>
					<td width="120">
						<select data-bind="value: Treatment, options: $root.treatmentList, optionsCaption: Rec_ID() == -1 ? '' : null"></select>
					</td>
					<td width="120">
						<input type="text" placeholder="Other Treatment" data-bind="textInput: OtherTreatment, enable: Treatment() == 'Other'" />
					</td>
					<td>
						<select data-bind="value: Result">
							<!-- ko if: Rec_ID() == -1 -->
							<option></option>
							<!-- /ko -->
							<option value="Cured">ជា Cured</option>
							<option value="Referred">បញ្ជូន Referred</option>
							<option value="Dead">ស្លាប់ Dead</option>
						</select>
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Bednet" />
					</td>
					<td>
						<input type="text" data-bind="value: Note" />
					</td>
					<td>
						<div class="btn-group" data-bind="visible: Rec_ID() == -1">
							<button class="btn btn-primary btn-xs" style="width:70px" data-bind="click: $root.addCase, visible: app.user.permiss['MMP Data'].contain('Edit')">Add</button>
							<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu dropdown-menu-right" style="min-width:92px">
								<li data-bind="visible: Rec_ID() == -1">
									<a data-bind="click: $root.resetCase"><b>Reset</b></a>
								</li>
						  </ul>
						</div>

						<button class="btn btn-danger btn-xs btn-block" data-bind="visible: Rec_ID() > -1 && app.user.permiss['MMP Data'].contain('Delete'), click: $root.deleteCase">Delete</button>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="total" data-bind="with: master">
			<div class="form-group form-inline">
				<p class="form-control-static"><kh>ករណី វិជ្ជមាន</kh> (Positive Cases)</p>
				<input type="text" class="form-control input-sm font14" data-bind="textInput: NumberPositive" />
			</div>
			<div class="form-group form-inline">
				<p class="form-control-static"><kh>ករណី អវិជ្ជមាន</kh> (Negative Cases)</p>
				<input type="text" class="form-control input-sm font14" data-bind="value: NumberNeg" disabled />
			</div>
			<div class="form-group form-inline">
				<p class="form-control-static"><kh>តេស្តដោយ តេស្តរហ័ស</kh> (RDT Tests)</p>
				<input type="text" class="form-control input-sm font14" data-bind="textInput: NumberRDT" />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>តេស្តដោយ មីក្រូទស្សន៍</kh> (Microscope Tests)</p>
				<input type="text" class="form-control input-sm font14" data-bind="textInput: NumberMicroscopy" />
			</div>
		</div>
	</div>
	<div class="panel-footer text-center">
		<button class="btn btn-primary btn-sm width150" data-bind="click: saveReport, visible: app.user.permiss['MMP Data'].contain('Edit')">Save</button>
	</div>
</div>

<!-- Modal Save Change -->
<div class="modal" id="modalSave" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary"><kh>មានការកែទិន្នន័យ</kh> - Data Changing</h3>
			</div>
			<div class="modal-body" style="font-size:18px">
				<kh>តើអ្នកចង់រក្សាទុកការកែទិន្នន័យនេះទេ?</kh>
				<br /><br />
				Do you want to save changes?
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-dismiss="modal" style="width:100px">Save</button>
				<button class="btn btn-danger btn-sm" data-dismiss="modal" style="width:100px">Don't Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/MLCase.js')?>