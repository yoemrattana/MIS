<style>
	.table > thead { background-color: #9AD8ED; }
	#tblreport a { display: block; }
	#tblcase { min-width: 100%; width: auto; max-width: none; }
	#tblcase thead td { text-align: center; }
	#tblcase tbody td { font-size: 12px; text-align:center; vertical-align: middle; padding: 0px 2px; height:30px; }
	#tblcase tbody td .btn-sm { font-size: 12px; line-height:15px; border-radius:2px; position:relative; width:100%; padding-left:2px; border-color:#767676; }
	#tblcase tbody input[type="text"] { width: 100%; padding: 0; }
	#tblcase tbody select { width: 100%; padding: 1px 1px 2px 1px; }
	#tblcase tbody td.hasCheckbox { padding: 0; }
	#tblcase tbody td.hasCheckbox input { width:20px; height:20px; margin-top: 4px; }
	.popover { z-index: 1040; display: block; background-color: #ffff99; }
	.popover-content { padding: 8px; }
	.popover-content .form-group { margin-bottom: 5px; }
	.popover-content select { width: 155px !important; font-size: 12px; }
	.popover.bottom .arrow:after { border-bottom-color: #ffff99; }
	.btn-group > .btn + .dropdown-toggle { padding-left: 6px; padding-right: 6px; }
	.dropdown-menu > li > a { padding: 4px 12px; }
	.dropdown-menu > li > a:hover { background-color: #ffff99; }
	.total { display:table; margin:auto; margin-top:20px; margin-bottom:20px; padding:10px 20px; border:1px solid #ccc; background-color: #f5f5f5; }
	.total p { width: 270px; }
	.total .form-control { width: 70px; text-align: center; }
	.total .form-group { margin-bottom: 5px; }
	select[disabled] { cursor: not-allowed; background-color: #eeeeee; }
	input[type="text"][disabled] { cursor: not-allowed !important; }
	.btn-link { line-height: 22px; cursor: pointer; outline: none; width: 70px; }
	.thead1 { background: #f6e58d}
</style>

<div class="panel panel-default" data-bind="visible: isListView" style="display:none">
	<div class="panel-heading clearfix relative">
		<div class="pull-center form-inline">
			<div class="input-group width150">
				<span class="input-group-btn">
					<button data-bind="click: previousYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-left"></i>
					</button>
				</span>
				<input data-bind="value: year" type="text" class="form-control text-center" readonly />
				<span class="input-group-btn">
					<button data-bind="click: nextYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-right"></i>
					</button>
				</span>
			</div>
			<select data-bind="options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: isSingle(odList()) ? undefined : 'Select OD',
					value: od" class="form-control minwidth150"></select>
		</div>
		<div class="pull-left font16 lh34">
			<b>Health Facility Report Received</b>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table id="tblreport" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Heath Facility</th>
					<th>Khmer Name</th>
					<!--ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
					<th width="110" class="text-center">Facility Type</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: reportList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Facility_K" class="kh"></td>
					<!--ko foreach: reports -->
					<th class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? 'X' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.editReport,
						   visible: $root.visibleReport($data)" style="padding-top:2px"></a>
					</th>
					<!-- /ko -->
					<td data-bind="text: Type_Facility" class="text-center"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="hidden: isListView" style="margin:-10px -10px 0 -10px; display:none">
	<div class="panel-heading clearfix" data-bind="with: master">
		<div class="pull-left lh34 relative" style="position:sticky; left:11px; z-index:3">
			<b>OD:</b>
			<kh data-bind="text: od"></kh>

			<b style="margin-left:30px">Health Faciliy:</b>
			<kh data-bind="text: hc"></kh>

			<b style="margin-left:30px">Report Month:</b>
			<input type="text" data-bind="datePicker: month, format: 'MM-YYYY', maxDate: moment()" class="btn-link" />
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<button class="btn btn-primary width80" data-bind="click: $root.saveReport, visible: app.user.permiss['Health Center Data'].contain('Edit')">Save</button>
			<button class="btn btn-danger width80" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['Health Center Data'].contain('Delete')">Delete</button>
			<button class="btn btn-default" name="move main" data-bind="click: $root.showMoveData, visible: has && app.user.role == 'AU'">Move Data</button>
			<button class="btn btn-default width80" data-bind="click: $root.back" style="margin-left:10px">Back</button>
		</div>
	</div>
	<div class="panel-body no-padding">
		<table id="tblcase" class="table table-bordered table-hover">
			<thead>
				<tr>
					<td style="min-width:40px" class="text-middle">#</td>
                    <td style="min-width:100px"><kh>សង្ស័យ</kh><br />Suspect</td>
                    <td style="min-width:80px"><kh>លទ្ធផល</kh><br />Result</td>
                    <td style="min-width:60px"><kh>កូដជំងឺ</kh><br />Code</td>
					<td style="min-width:100px"><kh>ថ្ងៃខែឆ្នាំ</kh><br />Date</td>
					<td style="min-width:150px"><kh>ឈ្មោះ</kh><br />Name</td>
					<td style="min-width:100px"><kh>លេខទូរស័ព្ទ</kh><br />Phone</td>
					<td style="min-width:160px"><kh>ភូមិ</kh><br />Village</td>
					<td style="min-width:50px"><kh>ភេទ</kh><br />Sex</td>
					<td style="min-width:100px"><kh>អាយុ (ឆ្នាំ)</kh><br />Age (Year)</td>
                    <td style="min-width:100px"><kh>អាយុ (ខែ)</kh><br />Age (Month)</td>
                    <td style="min-width:100px"><kh>ទំងន់ (Kg)</kh><br />Weight (Kg)</td>
					<td style="min-width:100px"><kh>កំដៅ (&#8451;)</kh><br />Temperature</td>
					<td style="min-width:80px"><kh>ផ្ទៃពោះ</kh><br />Pregnant</td>
					<td style="min-width:84px"><kh>ស្ថានភាពជំងឺ</kh><br />Diagnosis</td>
					<td style="min-width:102px"><kh>វិធីធ្វើរោគវិនិច្ឆ័យ</kh><br />Test</td>
                    <td style="min-width:100px"><kh>អ្នកជំងឺចល័ត</kh><br />Mobile Patient</td>
                    <td style="min-width:100px">IPD/OPD</td>
					<td colspan="4"><kh>ការព្យាបាល</kh><br />Treatment</td>
                    <td style="min-width:80px"><kh>ដូតស៍ថ្ងៃទី១</kh><br />DOT1</td>
                    <td style="min-width:110px"><kh>បញ្ជូនមកពី</kh><br />Referred From</td>
					<td colspan="3" style="min-width:70px"><kh>បញ្ជូនទៅ</kh><br />Referred To</td>
					<td style="min-width:50px"><kh>ស្លាប់</kh><br />Dead</td>
					
                    <td class="thead1" style="min-width:120px;"><kh>តេស្តមានគ័ភ</kh></td>
					<td class="thead1" style="min-width:120px;"><kh>លទ្ធផល</kh> G6PD (U/g Hb)</td>
					<td class="thead1" style="min-width:120px;"><kh>លទ្ធផល</kh> Hb(g/dL)</td>
                    <td class="thead1" style="min-width:120px;"><kh>ថ្ងៃទី00</kh> Hb(g/dL)</td>
                    <td class="thead1" style="min-width:120px;"><kh>ថ្ងៃទី03</kh> Hb(g/dL)</td>
                    <td class="thead1" style="min-width:120px;"><kh>ថ្ងៃទី07</kh> Hb(g/dL)</td>

					<td class="thead1" ><kh>ប្រឹក្សា</kh></td>
					<td class="thead1" >ACT</td>
					<td class="thead1" style="min-width:104px;"><kh>ការព្យាបាលផ្តាច់ដោយព្រីម៉ាគីន</kh></td>
					<td class="thead1" style="min-width:100px;"><kh>ព្រីម៉ាគីន គ្រាប់ ១៥ម.ក្រ</kh></td>
					<td class="thead1" style="min-width:100px;"><kh>ព្រីម៉ាគីន គ្រាប់ ៧.៥ម.ក្រ</kh></td>

					<td style="min-width:80px">Fingerprint</td>
                    <td style="min-width:60px">RDT Image</td>
                    <td style="min-width:70px" data-bind="visible: app.user.role == 'AU'">Exclude (Admin)</td>
                    <td style="min-width:70px" data-bind="visible: app.user.role == 'AU'">Radical Cure (Admin)</td>
					<td style="min-width:106px"><kh>ថ្ងៃបញ្ចូល</kh></td>
					<td colspan="2"><kh>បញ្ជូលពីទូរស័ព្ទ</kh></td>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: Rec_ID() == -1 ? '-' : $index() + 1"></td>
                    <td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Suspect" />
					</td>
                    <!-- ko if: Suspect() == true -->
                    <td>
						<select data-bind="value: Diagnosis">
							<option value="S">Suspect</option>
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
							<option value="N">Negative</option>
							<option value="K">Pk</option>
							<option value="A">Pm</option>
							<option value="O">Po</option>
						</select>
					</td>
                    <td data-bind="if: !Diagnosis().in('N', 'S')" width="70" class="relative">
						<input type="text" data-bind="value:PatientCode" class="text-center"/>
					</td>
					<td class="relative" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" data-bind="datePicker: DateCase, minDate: Rec_ID() < 1 ? $root.getMinDate() : undefined, maxDate: Rec_ID() < 1 ? $root.getMaxDate() : undefined, defaultDate: Rec_ID() < 1 ? $root.getDefaultDate() : undefined" class="text-center" />
					</td>
					<td data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" data-bind="value: NameK" />
					</td>
					<td data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" data-bind="value: PatientPhone" />
					</td>

					<!-- ko if: !Diagnosis().in('N', 'S') -->
					<td data-bind="with: Code_Vill_t.popObject">
						<button class="btn btn-default btn-sm btnvill" data-bind="click: villClick, style: { 'border': villWarn() ? '2px solid red' : '' }">
							<div style="width:140px; height:15px; overflow-x:hidden" data-bind="text: $root.getVill(base())"></div>
							<span class="caret" style="position:absolute; right:5px; top:8px"></span>
						</button>
						<!-- ko if: popVisible -->
						<div class="popover bottom" data-bind="style: { top: $root.getTop($element), left: $root.getLeft($element) }">
							<div class="arrow"></div>
							<div class="popover-content">
								<div class="form-group">
									<select data-bind="value: province, options: provList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Province --'"></select>
								</div>
								<div class="form-group">
									<select data-bind="value: district, options: distList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- District --'"></select>
								</div>
								<div class="form-group">
									<select data-bind="value: commune, options: commList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Commune --'"></select>
								</div>
								<div class="form-group">
									<select data-bind="value: village, options: villList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Village --'"></select>
								</div>
								<div class="checkbox-inline checkbox-lg">
									<label>
										<input type="checkbox" data-bind="checked: base() == '999', click: unknownClick" />
										<span style="font-weight:normal">Unknown</span>
									</label>
									<button class="btn btn-sm btn-success" data-bind="click: ok">OK</button>
								</div>
							</div>
						</div>
						<!-- /ko -->
					</td>
					<!-- /ko -->

					<!-- ko if: Diagnosis().in('N', 'S') -->
					<td></td>
					<!-- /ko -->
					<td data-bind="if: !Diagnosis().in('S')">
						<select data-bind="value: Sex, options: ['M','F']"></select>
					</td>
					<td style="min-width:50px" data-bind="if: !Diagnosis().in('S')">
						<input type="text" data-bind="textInput: Age" class="text-center" maxlength="2" />
					</td>
                    <td style="min-width:50px" data-bind="if: !Diagnosis().in('S')">
						<input type="text" data-bind="textInput: AgeMonth" class="text-center" maxlength="2" />
					</td>
                    <td data-bind="if: !Diagnosis().in('S', 'N')">
                        <input type="text" data-bind="textInput: Weight" class="text-center" maxlength="4"/>
                    </td>   
					<td data-bind="if: !Diagnosis().in('S', 'N')">
                        <input type="text" data-bind="textInput: Temperature" class="text-center" maxlength="4"/>
                    </td>
					<td data-bind="if: !Diagnosis().in('S', 'N')">
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
					<td data-bind="if: !Diagnosis().in('S', 'N')">
						<select data-bind="value: DiagnosisText">
							<!-- ko if: Rec_ID() == -1 -->
							<option></option>
							<!-- /ko -->
							<option>Simple</option>
							<option>Severe</option>
							<option>0 - Missing</option>
						</select>
					</td>
					<td data-bind="if: !Diagnosis().in('S')">
						<select data-bind="value: Test">
							<!-- ko if: Rec_ID() == -1 -->
							
							<!-- /ko -->
							<option></option>
							<option>RDT</option>
							<option>Microscope</option>
						</select>
					</td>
                    <td data-bind="if: !Diagnosis().in('S', 'N')" class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Mobile" />
					</td>
                    <td data-bind="if: !Diagnosis().in('S', 'N')">
						<select data-bind="value: Admit">
							<option></option>
                            <option>OPD</option>
							<option>IPD</option>
						</select>
					</td>
					<td style="min-width:120px" data-bind="if: !Diagnosis().in('S', 'N')">
						<select data-bind="value: Treatment, options: $root.treatmentList, optionsCaption: Rec_ID() == -1 ? '' : null"></select>
					</td>
					<td style="min-width:100px" data-bind="if: !Diagnosis().in('S', 'N')">
						<input type="text" placeholder="Other Treatment" data-bind="textInput: OtherTreatment, enable: Treatment() == 'Other'" />
					</td>
                    <td style="min-width:60px" data-bind="if: !Diagnosis().in('S', 'N')">
						<input type="text" placeholder="# ASMQ" data-bind="textInput: ASMQ, enable: Treatment() == 'ASMQ + PQ' || Treatment() == 'ASMQ'" maxlength="2"/>
					</td>
					<td style="min-width:60px" data-bind="if: !Diagnosis().in('S', 'N')">
						<input type="text" placeholder="# PQ" data-bind="textInput: Primaquine, enable: Treatment() == 'ASMQ + PQ'" maxlength="2"/>
					</td>
                    <td class="hasCheckbox" data-bind="if: !Diagnosis().in('S', 'N')">
						<input type="checkbox" data-bind="checked: DOT1" />
					</td>
                    <td data-bind="if: !Diagnosis().in('S', 'N')">
						<select data-bind="value: ReferredFromService">
							<option></option>
							<option>VMW</option>
							<option>PPM</option>
						</select>
					</td>
					<td style="min-width:20px">
						<i class="fa fa-close" data-bind="visible: !Refered() && !Diagnosis().in('N', 'S')" style="color:red;"></i>
						<i class="fa fa-check-square-o" data-bind="visible: Refered()" style="color:blue;"></i>
					</td>
					<td style="min-width:80px" data-bind="if: !Diagnosis().in('N', 'S')">
						<select data-bind="value: ReferedReason">
							<option></option>
							<option value="Severe">Severe</option>
                            <option value="Study">Study</option>
                            <option value="Pv Radical Cure">Pv Radical Cure</option>
							<option value="Other">Other</option>
						</select>
					</td>
					<td style="min-width:100px" data-bind="if:!Diagnosis().in('N', 'S')">
						<input type="text" placeholder="Other Refered Reason" data-bind="textInput: ReferedOtherReason, enable: ReferedReason() == 'Other'" />
					</td>
					<td class="hasCheckbox" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="checkbox" data-bind="checked: Dead" />
					</td>
                    <td data-bind="if: Diagnosis().in('V','M', 'O')">
						<select data-bind="value: PregnantTest">
							<option></option>
                            <option value="P">វិជ្ជមាន</option>
							<option value="N">អវិជ្ជមាន</option>
						</select>
					</td>
					<td data-bind="if: Diagnosis().in('V','M', 'O')">
						<input type="text" data-bind="textInput: G6PDHb" class="text-center" maxlength="5" />
					</td>
					<td data-bind="if: Diagnosis().in('V','M', 'O')">
						<input type="text" data-bind="textInput: G6PDdL" class="text-center" maxlength="5" />
					</td>
                    <td data-bind="if: Diagnosis().in('V','M', 'O')">
						<input type="text" data-bind="textInput: HbD0" class="text-center" maxlength="5" />
					</td>
                    <td data-bind="if: Diagnosis().in('V','M', 'O')">
						<input type="text" data-bind="textInput: HbD3" class="text-center" maxlength="5" />
					</td>
                    <td data-bind="if: Diagnosis().in('V','M', 'O')">
						<input type="text" data-bind="textInput: HbD7" class="text-center" maxlength="5" />
					</td>

					<td data-bind="if: Diagnosis().in('V','M', 'O')" class="hasCheckbox">
						<input type="checkbox" data-bind="checked: IsConsult" />
					</td>
					<td data-bind="if: Diagnosis().in('V','M', 'O')" class="hasCheckbox">
						<input type="checkbox" data-bind="checked: IsACT" />
					</td>
					<td data-bind="if: Diagnosis().in('V','M', 'O')" class="hasCheckbox">
						<input type="checkbox" data-bind="checked: IsPrimaquine" />
					</td>
					<td data-bind="if: Diagnosis().in('V','M', 'O')">
						<input type="text" data-bind="textInput: Primaquine15" class="text-center" maxlength="2" />
					</td>
					<td data-bind="if: Diagnosis().in('V','M', 'O')">
						<input type="text" data-bind="textInput: Primaquine75" class="text-center" maxlength="2" />
					</td>
                    <td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Fingerprint() != null" disabled />
					</td>
					<td data-bind="if: RdtImage() != null">
                        <a data-bind="click: $root.viewRdtImage"><span class="fa fa-file-image-o"></span></a>
                    </td>
                    <td class="hasCheckbox" data-bind="visible: app.user.role == 'AU', if: !Diagnosis().in('S', 'N')">
						<input type="checkbox" data-bind="checked: Exclude" />
					</td>
					<td class="relative" data-bind="visible: app.user.role == 'AU'">
						<input type="text" data-bind="datePicker: PrimaquineDate"/>
					</td>
					<td data-bind="text: isnot($data.InitTime, undefined, r => moment(r()).format('DD-MM-YYYY HH:mm'))"></td>
					<td class="hasCheckbox" style="min-width:30px">
						<input type="checkbox" data-bind="checked: Is_Mobile_Entry() == 1" disabled />
					</td>
					<td style="min-width:104px">
						<div class="btn-group">
							<!-- ko if: Rec_ID() == -1 -->
							<button class="btn btn-primary btn-xs" style="width:70px" data-bind="click: $root.addCase, visible: app.user.permiss['Health Center Data'].contain('Edit')">Add</button>
							<!-- /ko -->

							<!-- ko if: Rec_ID() > -1 -->
							<button class="btn btn-danger btn-xs" style="width:70px" data-bind="click: $root.deleteCase, visible: app.user.permiss['Health Center Data'].contain('Delete')">Delete</button>
							<!-- /ko -->

							<!-- ko if: Rec_ID() > -1 -->
							<button data-bind="visible: !app.user.permiss['Health Center Data'].contain('Delete')" class="btn btn-danger btn-xs" style="width:70px">&nbsp;</button>
							<!-- /ko -->

							<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>

							<ul class="dropdown-menu dropdown-menu-right" style="min-width:92px">
								<li data-bind="visible: Rec_ID() == -1">
									<a data-bind="click: $root.resetCase"><b>Reset</b></a>
								</li>
								<li data-bind="visible: Rec_ID() > 0 && (Diagnosis() == 'F' || Diagnosis() == 'M')">
									<a style="color:green" data-bind="click: () => open(`/CaseReport/investigation/${Rec_ID()}_HC/${$root.od()}`)"><b>Investigate</b></a>
								</li>
								<li data-bind="visible: $root.visibleReactive($data)">
									<a style="color:green" data-bind="click: $root.openReactiveForm"><b>Reactive</b></a>
								</li>
								<li data-bind="visible: Rec_ID() > 0 && L1()">
									<a style="color:green" data-bind="click: () => open(`/Foci/open/${Code_Vill_t()}`)"><b>Foci</b></a>
								</li>
								<li data-bind="visible: Rec_ID() > 0 && app.user.role == 'AU'">
									<a style="color:green" name="move detail" data-bind="click: $root.showMoveData"><b>Move Data</b></a>
								</li>
							</ul>
						</div>
					</td>
                    <!-- /ko -->
				</tr>
			</tbody>
		</table>

		<div class="total">
			<div class="form-inline">
				<p class="form-control-static"><kh>តេស្តសរុប</kh> (Total Tests)</p>
				<input type="text" class="form-control input-sm font14" data-bind="value: getTest()" disabled />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>ករណី វិជ្ជមាន</kh> (Positive Cases)</p>
				<input type="text" class="form-control input-sm font14" data-bind="value: getPositive()" disabled />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>ករណី អវិជ្ជមាន</kh> (Negative Cases)</p>
				<input type="text" class="form-control input-sm font14" data-bind="value: getNegative()" disabled />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>តេស្តដោយ តេស្តរហ័ស</kh> (RDT Tests)</p>
				<input type="text" class="form-control input-sm font14" data-bind="value: getRDT()" disabled />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>តេស្តដោយ មីក្រូទស្សន៍</kh> (Microscope Tests)</p>
				<input type="text" class="form-control input-sm font14" data-bind="value: getMicroscope()" disabled />
			</div>
		</div>
	</div>
	<!-- ko if: app.user.permiss['Health Center Data'].contain('Edit') -->
	<div class="panel-footer text-center">
		<button class="btn btn-primary btn-sm width150" data-bind="click: saveReport">Save</button>
	</div>
	<!-- /ko -->
</div>

<!-- Modal Image -->
<div class="modal" id="RdtImage" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary"><kh>រូបភាព</kh> - RDT Image</h3>
			</div>
			<div class="modal-body" style="font-size:18px">
				<!-- ko if: $root.RdtImagePath -->
                <img alt="RDT Image" style="width:100%" data-bind="attr: { src: '/media/RDT/' + $root.RdtImagePath() }"/>
				<!-- /ko -->
			</div>
			<div class="modal-footer">
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Close</button>
			</div>
		</div>
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

<!-- Modal Move Data -->
<div class="modal" id="modalMove" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Move Data To</h3>
			</div>
			<div class="modal-body">
				<table class="table" data-bind="with: moveModel">
					<tr>
						<th width="100" align="right" valign="middle">Province</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">OD</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">HC</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Year</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: year, options: yearList, optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Month</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: month, options: monthList, optionsCaption: ''"></select>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" style="width:100px" data-bind="click: moveData">Move</button>
				<button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Input Place -->
<div class="modal" id="modalInputPlace" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Input Place</h3>
			</div>
			<div class="modal-body">
				<table class="table" data-bind="with: inputPlaceModel">
					<tr>
						<th width="100" align="right" valign="middle">Province</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">District</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: ds, options: dsList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Commune</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: cm, options: cmList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Village</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
				</table>
				<hr />
				<table class="table" data-bind="with: inputPlaceModel">
					<tr>
						<th width="100" align="right" valign="middle">Other</th>
						<td class="form-group">
							<input type="text" class="form-control input-sm" data-bind="value: other" />
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100" data-dismiss="modal" data-bind="click: inputPlaceOKClick">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal" data-bind="click: inputPlaceCancelClick">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/HfCase.js')?>