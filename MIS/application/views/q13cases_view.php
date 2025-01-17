
<style>
	thead { background-color: #9AD8ED; }
	#tblreport a { display: block; }
	#tblcase { min-width: 1600px; }
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
	.checkbox-inline input { width: 20px; height: 20px; }
</style>

<div class="panel panel-default" data-bind="visible: true" >
	<div class="panel-heading clearfix">
        <div class="pull-left font16 lh28">
			<b>Active Case Detection Form</b>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: $root.saveReport, visible: app.user.permiss['Questionnaire'].contain('Edit')">Save</button>
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
					<td colspan="2"><kh>អាយុ / ខ្នាត់</kh><br />Age / Unit</td>
					<td width="50"><kh>ភេទ</kh><br />Sex</td>
					<td width="80"><kh>ផ្ទៃពោះ</kh><br />Pregnant</td>
					<td width="80"><kh>ទម្ងន់ (Kg)</kh><br />Weight</td>
					<td width="90"><kh>កំដៅ (°C)</kh><br />Temperature</td>
					<td width="100"><kh>អ្នកជំងឺចល័ត</kh><br />Mobile Patient</td>
					<td width="80"><kh>លទ្ធផល</kh><br />Result</td>
					<td colspan="2"><kh>ថ្នាំ</kh><br />ACT</td>
					<td width="80"><kh>បានលេបថ្នាំ<br />គ្រប់៣ថ្ងៃ</kh></td>
					<td width="70"><kh>បញ្ជូន</kh><br />Referred</td>
					<td width="50"><kh>ស្លាប់</kh><br />Dead</td>
					<td width="200"><kh>ផ្សេងៗ</kh><br />Note</td>
                    <td>Passive</td>
					<td colspan="2"><kh>បញ្ជូលពីកម្មវិធី</kh><br />Entry by Mobile</td>
				</tr>
			</thead>
			<tbody data-bind="foreach: reportList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: Rec_ID() == -1 ? '-' : $index() + 1"></td>
					<!-- ko if: Diagnosis() == 'N' -->
					<td></td>
					<td></td>
					<!-- /ko -->
					<!-- ko if: Diagnosis() != 'N' -->
					<td class="relative">
						<input type="text" data-bind="datePicker: DateCase" class="text-center" />
					</td>
					<td>
						<input type="text" data-bind="value: NameK" />
					</td>
					<!-- /ko -->
					
					<td width="50">
						<input type="text" data-bind="textInput: Age" class="text-center" maxlength="2" />
					</td>
					<td width="50">
						<select data-bind="value: AgeType">
							<!-- ko if: Rec_ID() > 0 && (AgeType() === null || AgeType() === '') -->
							<option></option>
							<!-- /ko -->
							<option>Y</option>
							<option>M</option>
						</select>
					</td>
					<td>
						<select data-bind="value: Sex, options: ['M','F']"></select>
					</td>
					<!-- ko if: Diagnosis() == 'N' -->
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<!-- /ko -->
					<!-- ko if: Diagnosis() != 'N' -->
					<td>
						<select data-bind="value: PregnantMTHS, enable: Sex() == 'F'">
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
						<input type="text" data-bind="textInput: Weight" class="text-center" maxlength="3" />
					</td>
					<td>
						<input type="text" data-bind="textInput: Temperature" class="text-center" maxlength="4" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Mobile" />
					</td>
					<!-- /ko -->


					<td>
						<select data-bind="value: Diagnosis">
							<!-- ko if: Rec_ID() == -1 -->
							<option></option>
							<!-- /ko -->
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
							<option value="N">Negative</option>
						</select>
					</td>
					<!-- ko if: Diagnosis() == 'N' -->
					<td width="100"></td>
					<td width="120"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<!-- /ko -->
					<!-- ko if: Diagnosis() != 'N' -->
					<td width="100">
						<select data-bind="value: Treatment, options: $root.treatmentList, optionsCaption: Rec_ID() == -1 ? '' : null"></select>
					</td>
					<td width="120">
						<input type="text" placeholder="Other Treatment" data-bind="textInput: OtherTreatment, enable: Treatment() == 'Other'" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: DOT3" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Refered" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Dead" />
					</td>
					<td>
						<input type="text" data-bind="value: Remark" />
					</td>
					<!-- /ko -->
                    <td class="hasCheckbox">
                        <input type="checkbox" data-bind="checked: Passive" disabled/>
                    </td>

					<td class="hasCheckbox" width="50">
						<input type="checkbox" disabled data-bind="click: $root.preventChange, checked: Is_Mobile_Entry() == 1" />
					</td>
					<td width="100">
						<div class="btn-group">
						    <!-- ko if: Rec_ID() == -1 -->
						    <button class="btn btn-primary btn-xs" style="width:70px" data-bind="click: $root.addCase, visible: app.user.permiss['VMW Data'].contain('Edit')">Add</button>
						    <!-- /ko -->
							
						    <!-- ko if: Rec_ID() > -1 -->
						    <button class="btn btn-danger btn-xs" style="width:70px" data-bind="click: $root.deleteCase, visible: app.user.permiss['VMW Data'].contain('Delete')">Delete</button>
						    <!-- /ko -->

						    <!-- ko if: Rec_ID() > -1 -->
						    <button data-bind="visible: !app.user.permiss['VMW Data'].contain('Delete')" class="btn btn-danger btn-xs" style="width:70px">&nbsp;</button>
						    <!-- /ko -->

						    <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
							    <span class="caret"></span>
						    </button>

						    <ul class="dropdown-menu dropdown-menu-right" style="min-width:92px">
							    <li data-bind="visible: Rec_ID() == -1">
								    <a data-bind="click: $root.resetCase"><b>Reset</b></a>
							    </li>
						    </ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

	</div>
	
	<div class="panel-footer text-center">
		<button class="btn btn-primary btn-sm width150" data-bind="click: saveReport, visible: app.user.permiss['Questionnaire'].contain('Edit')">Save</button>
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


<?=latestJs('/media/ViewModel/Q13Case.js')?>