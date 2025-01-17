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
    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }
    .input-error {
		border-color: tomato;
		color: tomato;
	}
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    .width50{width:50px !important}
</style>

<div class="panel panel-default" data-bind="visible: isListView" style="display:none">
	<div class="panel-heading clearfix relative">
		<div class="pull-center form-inline text-nowrap">
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

			<select data-bind="options: hcList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: isSingle(hcList()) ? undefined : 'Select HC',
					value: hc" class="form-control minwidth150"></select>
		</div>
		<div class="pull-left font16 lh34">
			<b>VMW Report Received</b>
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
					<th>Village</th>
					<th>Khmer Name</th>
					<!--ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
					<th width="90" class="text-center">Has VMW</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: reportList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: Name_Vill_K" class="kh"></td>
					<!--ko foreach: reports -->
					<th class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? 'X' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },                           
						   click: $root.editReport,
						   visible: $root.visibleReport($data)" style="padding-top:2px"></a>
					</th>
					<!-- /ko -->
					<td data-bind="text: HaveVMW ? 'Yes' : 'No'" class="text-center"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="hidden: isListView" style="margin:-10px -10px 0 -10px; display:none">
	<div class="panel-heading clearfix" data-bind="with: master">
		<div class="pull-left lh34 relative" style="left:11px; z-index:3">
			<b>OD:</b>
			<kh data-bind="text: od"></kh>

			<b style="margin-left:30px">HC:</b>
			<kh data-bind="text: hc"></kh>

			<b style="margin-left:30px">Village:</b>
			<kh data-bind="text: vl"></kh>

			<b style="margin-left:30px">Report Month:</b>
			<input type="text" data-bind="datePicker: month, format: 'MM-YYYY', maxDate: moment().add(1,'month')" class="btn-link" />

            <button class="btn kh" style="background: #ff9f1a" data-bind="click: $root.showWorm"><i class="fa fa-th"></i> ថ្នាំទម្លាក់ព្រូន / អាបែត</button>
            <button class="btn kh" style="background: #badc58" data-bind="click: $root.showEdu"><i class="fa fa-graduation-cap"></i> អប់រំសុខភាព</button>
            <button class="btn kh" style="background: #7ed6df" data-bind="click: $root.showCommodity"><i class="fa fa-cubes"></i> សម្ភារៈគ្រុនចាញ់</button>
			<button class="btn btn-primary width80" data-bind="click: $root.saveReport, visible: app.user.permiss['VMW Data']?.contain('Edit')">Save</button>
			<button class="btn btn-danger width80" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['VMW Data']?.contain('Delete')">Delete</button>
			<button class="btn btn-success" data-bind="click: $root.showMoveData, visible: has && app.user.role == 'AU'">Move Data</button>
			<button class="btn btn-default width80" data-bind="click: $root.back" style="margin-left:10px">Back</button>
		</div>
	</div>
	<div class="panel-body no-padding">
		<table id="tblcase" class="table table-bordered table-hover">
			<thead>
				<tr>
					<td style="min-width:40px" class="text-middle">#</td>
                    <td style="min-width:90px"><kh>សង្ស័យ</kh><br />Suspect</td>
                    <td style="min-width:80px"><kh>លទ្ធផល</kh><br />Result</td>
					<td style="min-width:60px"><kh>កូដ</kh><br />Code</td>
					<td style="min-width:100px"><kh>ថ្ងៃខែឆ្នាំ</kh><br />Date</td>
					<td style="min-width:150px"><kh>ឈ្មោះ</kh><br />Name</td>
					<td style="min-width:100px"><kh>លេខទូរស័ព្ទ</kh><br />Phone</td>
                    <td style="min-width:160px"><kh>អាស័យដ្ឋាន</kh><br />Address</td>
					<td style="min-width:50px"><kh>ភេទ</kh><br />Sex</td>
					<td style="min-width:80px"><kh>អាយុ (ឆ្នាំ)</kh><br />Age (Year)</td>
					<td style="min-width:80px"><kh>ផ្ទៃពោះ</kh><br />Pregnant</td>
					<td style="min-width:80px"><kh>ទម្ងន់ (Kg)</kh><br />Weight</td>
					<td style="min-width:90px"><kh>កំដៅ (°C)</kh><br />Temperature</td>
					<td style="min-width:100px"><kh>អ្នកជំងឺចល័ត</kh><br />Mobile Patient</td>
                    <td style="min-width:100px"><kh>ថ្ងៃខែឆ្នាំ</kh><br /> <kh>ចេញរោគសញ្ញាដំបូង</kh></td>
					<td colspan="4"><kh>ការព្យាបាល</kh><br />Treatment</td>
					<td style="min-width:80px"><kh>ដូតស៍ថ្ងៃទី១<br />DOT1</kh></td>
                    <td colspan="2"><kh>បញ្ជូនមកពី</kh><br />Referred From</td>
					<td colspan="3"><kh>បញ្ជូនទៅ</kh><br />Referred To</td>
					<td style="min-width:50px">Case Study</td>
					<td style="min-width:50px"><kh>ស្លាប់</kh><br />Dead</td>
                    <td style="min-width:90px"><kh>តេស្តក្រៅភូមិ</kh><br />Outreach</td>

                    <td class="thead1" style="min-width:120px;"><kh>តេស្តមានគ័ភ</kh></td>
					<td class="thead1" style="min-width:120px"><kh>លទ្ធផល</kh> G6PD (U/g Hb)</td>
					<td class="thead1" style="min-width:120px"><kh>លទ្ធផល</kh> Hb(g/dL)</td>
                    <td class="thead1" style="min-width:120px;"><kh>ថ្ងៃទី00</kh> Hb(g/dL)</td>
                    <td class="thead1" style="min-width:120px;"><kh>ថ្ងៃទី03</kh> Hb(g/dL)</td>
                    <td class="thead1" style="min-width:120px;"><kh>ថ្ងៃទី07</kh> Hb(g/dL)</td>
					<td class="thead1"><kh>ប្រឹក្សា</kh></td>
					<td class="thead1">ACT</td>
					<td class="thead1" style="min-width:104px"><kh>ការព្យាបាលផ្តាច់ដោយព្រីម៉ាគីន</kh></td>
					<td class="thead1" style="min-width:100px"><kh>ព្រីម៉ាគីន គ្រាប់ ១៥ម.ក្រ</kh></td>
					<td class="thead1" style="min-width:100px"><kh>ព្រីម៉ាគីន គ្រាប់ ៧.៥ម.ក្រ</kh></td>

                    <td style="min-width:110px; background:#83fba2"><kh>1.1 ធ្លាប់កើតជំងឺគ្រុនចាញ់</kh></td>
					<td style="min-width:165px; background:#83fba2"><kh>1.2 Relapse/Recrudescence <br /> ករណីលាប់/រើកើតឡើងវិញ</kh></td>
					<td style="min-width:165px; background:#83fba2">2.1 Locally Aquiry <br /> <kh>ករណីឆ្លងនៅក្នុងតំបន់</kh></td>
					<td style="min-width:173px; background:#83fba2">2.2 Domestically Imported <br /> <kh>ករណីនាំចូលក្នុងស្រុក</kh></td>
					<td style="min-width:173px; background:#83fba2">2.3 International Imported <br /> <kh>ករណីនាំចូលក្រៅប្រទេស</kh></td>
					<td style="min-width:80px">Fingerprint</td>
                    <td style="min-width:60px">RDT Image</td>
                    <td style="min-width:70px" data-bind="visible: app.user.role == 'AU'">Exclude (Admin)</td>
                    <td style="min-width:70px" data-bind="visible: app.user.role == 'AU'">Radical cure (Admin)</td>
					<td style="min-width:106px"><kh>ថ្ងៃបញ្ចូល</kh></td>
					<td colspan="2"><kh>បញ្ជូលពីទូរស័ព្ទ</kh></td>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: Rec_ID() == -1 ? '-' : $index() + 1"></td>
                    <td class="hasCheckbox">
                        <input type="checkbox" data-bind="checked: Suspect"/>
                    </td>
                    <!--ko if: Suspect() == true-->
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
					<td data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" data-bind="value:PatientCode" class="text-center"/>
					</td>
					<td data-bind="if: !Diagnosis().in('N', 'S')" class="relative">
						<input type="text" data-bind="datePicker: DateCase, minDate: Rec_ID() < 1 ? $root.getMinDate() : undefined, maxDate: Rec_ID() < 1 ? $root.getMaxDate() : undefined, defaultDate: Rec_ID() < 1 ? $root.getDefaultDate() : undefined" class="text-center" />
					</td>
					<td data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" data-bind="value: NameK" />
					</td>
                    
					<td data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" data-bind="value: PatientPhone" />
					</td>
                    <!-- ko if: !Diagnosis().in('N', 'S') -->
					<td data-bind="with: Address.popObject">
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
					<td data-bind="if: !Diagnosis().in('S')">
						<input type="text" data-bind="textInput: Age" class="text-center" maxlength="2" />
					</td>
					<td data-bind="if: !Diagnosis().in('N', 'S')">
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
					<td data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" data-bind="textInput: Weight" class="text-center" maxlength="3" />
					</td>
					<td data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" data-bind="textInput: Temperature" class="text-center" maxlength="4" />
					</td>
					<td data-bind="if: !Diagnosis().in('N', 'S')" class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Mobile" />
					</td>
                    <td data-bind="if: !Diagnosis().in('N', 'S')" class="relative">
						<input type="text" data-bind="datePicker: SymptomDate, minDate: Rec_ID() < 1 ? $root.getMinDate() : undefined, maxDate: Rec_ID() < 1 ? $root.getMaxDate() : undefined, defaultDate: Rec_ID() < 1 ? $root.getDefaultDate() : undefined" class="text-center" />
					</td>
					
					<td style="min-width:100px" data-bind="if: !Diagnosis().in('N', 'S')">
						<select data-bind="value: Treatment, options: $root.treatmentList, optionsCaption: Rec_ID() == -1 ? '' : null"></select>
					</td>
					<td style="min-width:100px" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" placeholder="Other Treatment" data-bind="value: OtherTreatment, enable: Treatment() == 'Other'" />
					</td>
					<td style="min-width:60px" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" placeholder="# ASMQ" data-bind="textInput: ASMQ, enable: Treatment() == 'ASMQ + PQ' || Treatment() == 'ASMQ'" maxlength="2"/>
					</td>
					<td style="min-width:60px" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" placeholder="# PQ" data-bind="textInput: Primaquine, enable: Treatment() == 'ASMQ + PQ'" maxlength="2"/>
					</td>
					<td class="hasCheckbox" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="checkbox" data-bind="checked: DOT1" />
					</td>
					<td style="min-width:100px" data-bind="if: !Diagnosis().in('N', 'S')">
						<select data-bind="value: ReferredFromService">
							<option></option>
							<option value="None">None</option>
							<option value="PPM">PPM</option>
							<option value="Other">Other</option>
						</select>
					</td>
                    <td style="min-width:100px" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" placeholder="Referred From Other Reason" data-bind="value: ReferredFromServiceOther, enable: ReferredFromService() == 'Other'" />
					</td>
					<td style="min-width:20px">
						<i class="fa fa-close" data-bind="visible: !Refered() && !Diagnosis().in('N', 'S')" style="color:red"></i>
						<i class="fa fa-check-square-o" data-bind="visible: Refered()" style="color:blue"></i>
					</td>
					<td style="min-width:100px" data-bind="if: !Diagnosis().in('N', 'S')">
						<select data-bind="value: ReferedReason">
							<option></option>
							<option value="PV Radical Cure">PV Radical Cure</option>
							<option value="Severe">Severe</option>
							<option value="Other">Other</option>
						</select>
					</td>
					<td style="min-width:100px" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="text" placeholder="Other Reason" data-bind="value: ReferedOtherReason, enable: ReferedReason() == 'Other'" />
					</td>
					<!--<td colspan="2" data-bind="visible: ReferedReason() == null || ReferedReason() == ''"><span data-bind="visible: Diagnosis() != 'N'" style="color: red" class="fa fa-remove"></span></td>-->
					<td class="hasCheckbox" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="checkbox" data-bind="checked: ReferedStudy, enable: ReferedReason() == 'Other'" />
					</td>
					<td class="hasCheckbox" data-bind="if: !Diagnosis().in('N', 'S')">
						<input type="checkbox" data-bind="checked: Dead" />
					</td>
                    <td class="hasCheckbox" data-bind="if: !Diagnosis().in('S')">
                        <input type="checkbox" data-bind="checked: Passive"/>
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
                    <td data-bind="if: !Diagnosis().in('N', 'S')" class="hasCheckbox relative">
						<div style="border:2px solid red; position:absolute; height:100%; width:452px; pointer-events:none; display:none"></div>
						<input type="checkbox" data-bind="checked: EverHadMalaria, click: $root.everHadMalariaClick" />
					</td>
                    
					<td data-bind="if: Diagnosis().in('V', 'F')" class="hasCheckbox relative">
						<div style="border:2px solid red; position:absolute; height:100%; width:452px; pointer-events:none; display:none"></div>
                        <!--ko if: Diagnosis() == 'V'-->
						<input type="checkbox" data-bind="checked: Relapse, disable: !EverHadMalaria() || LocallyAcquired() || DomesticallyImported() || InternationalImported(), click: $root.relapseClick" />
                        <!--/ko-->
                        <!--ko if: Diagnosis() == 'F'-->
						<input type="checkbox" data-bind="checked: Recrudescence, disable: !EverHadMalaria() || LocallyAcquired() || DomesticallyImported() || InternationalImported(), click: $root.RecrudescenceClick" />
                        <!--/ko-->
					</td>
                    
					<td data-bind="if: !Diagnosis().in('N', 'S')" class="hasCheckbox relative">
                        <div style="border:2px solid red; position:absolute; height:100%; width:452px; pointer-events:none; display:none"></div>
						<input type="checkbox" data-bind="checked: LocallyAcquired, disable: Relapse() || Recrudescence() || DomesticallyImported() || InternationalImported(), click: $root.LocallyAcquiredClick" />
					</td>
                    <td data-bind="if: !Diagnosis().in('N', 'S')" class="hasCheckbox">
						<input type="checkbox" data-bind="checked: DomesticallyImported, disable: Relapse() || Recrudescence() || LocallyAcquired() ||  InternationalImported(), click: $root.DomesticallyImportedClick" />
					</td>
					<td data-bind="if: !Diagnosis().in('N', 'S')" class="hasCheckbox">
						<input type="checkbox" data-bind="checked: InternationalImported, disable: Relapse() || Recrudescence() || DomesticallyImported() || LocallyAcquired(), click: $root.InternationalImportedClick" />
					</td>
					                    
                    <td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Fingerprint() != null" disabled />
					</td>
					<td data-bind="if: RdtImage() != null">
                        <a data-bind="click: $root.viewRdtImage"><span class="fa fa-file-image-o"></span></a>
                    </td>
                    <td class="hasCheckbox" data-bind="visible: app.user.role == 'AU', if: !Diagnosis().in('N', 'S')">
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
						<div class="btn-group btn-group-xs">
							<!-- ko if: Rec_ID() == -1 -->
							<button class="btn btn-primary" style="width:70px" data-bind="click: $root.addCase, visible: app.user.permiss['VMW Data']?.contain('Edit')">Add</button>
							<!-- /ko -->
							
							<!-- ko if: Rec_ID() > -1 -->
							<button class="btn btn-danger" style="width:70px" data-bind="click: $root.deleteCase, visible: app.user.permiss['VMW Data']?.contain('Delete')">Delete</button>
							<!-- /ko -->

							<!-- ko if: Rec_ID() > -1 -->
							<button data-bind="visible: !app.user.permiss['VMW Data']?.contain('Delete')" class="btn btn-danger" style="width:70px">&nbsp;</button>
							<!-- /ko -->

							<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu dropdown-menu-right" style="min-width:92px">
								<li data-bind="visible: Rec_ID() == -1">
									<a data-bind="click: $root.resetCase"><b>Reset</b></a>
								</li>
								<li data-bind="visible: Rec_ID() > 0 && (Diagnosis() == 'F' || Diagnosis() == 'M')">
									<a style="color:green" data-bind="click: () => open(`/CaseReport/investigation/${Rec_ID()}_VMW/${$root.od()}`)"><b>Investigate</b></a>
								</li>
								<li data-bind="visible: $root.visibleReactive($data)">
									<a style="color:green" data-bind="click: () => open(`/Reactive/open/${Rec_ID()}_VMW`)"><b>Reactive</b></a>
								</li>
								<li data-bind="visible: Rec_ID() > 0 && L1()">
									<a style="color:green" data-bind="click: () => open(`/Foci/open/${ID()}`)"><b>Foci</b></a>
								</li>
								<li data-bind="visible: Rec_ID() > 0 && app.user.role == 'AU'">
									<a style="color:green" name="move detail" data-bind="click: $root.showMoveData"><b>Move Data</b></a>
								</li>
							</ul>
						</div>
					</td>

                    <!--/ko-->
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
		</div>
	</div>
	<!-- ko if: app.user.permiss['VMW Data']?.contain('Edit') -->
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
						<th align="right" valign="middle">Village</th>
						<td class="form-group">
							<select class="form-control" data-bind="value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
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

<!-- Modal Worm -->
<div class="modal" id="modalWorm" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary kh">ថ្នាំទម្លាក់ព្រូន / អាបែត</h3>
			</div>
			<div class="modal-body" data-bind="with: worm">
				<p class="kh form-inline">
                    •<b>ថ្នាំទម្លាក់ព្រូន៖</b> 
                    ចំនួននៅសល់ពីខែមុន=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: WormStockStart"/> គ្រាប់
                    ចំនួន<b>ប្រើអស់=</b>​​ <input type="number" min="0" class="form-control width50 text-center" data-bind="value: WormStockOut"/> គ្រាប់
                    ចំនួន<b>បន្ថែម=</b>​​ <input type="number" min="0" class="form-control width50 text-center" data-bind="value: WormStockIn"/> គ្រាប់
                    ចំនួន<b>សរុបខែថ្មី=</b>​​ <input type="number" min="0" class="form-control width50 text-center" data-bind="value: WormBalance"/> គ្រាប់
                </p>
                <p class="kh form-inline">
                    •ចំនួនប្រជាជនទទួល <b>ថ្នាំទម្លាក់ព្រូន=</b> <input type="number" min="0" class="form-control width50 text-center" data-bind="value: WormPeopleReceived"/> នាក់ 
                    (ស្រី = <input type="number" min="0" class="form-control width50 text-center" data-bind="value: WormFemaleReceived"/>)
                </p>
                <p class="kh form-inline">
                    •ចំនួនគ្រួសារទទួល<b>ថ្នាំអាបែត (គ្រុនឈាម/គ្រុនឈីក)=</b> <input type="number" min="0" class="form-control width50 text-center" data-bind="value: AbetFamilyReceived"/> 
                    ចំនួន <b>ថ្នាំអាបែត</b>បានទទួល = <input type="number" min="0" class="form-control width50 text-center" data-bind="value: AbetStockIn"/> គីឡូក្រាម
                </p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" style="width:100px" data-bind="click: $root.saveWorm">Save</button>
				<button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Health Education -->
<div class="modal" id="modalEdu" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary kh">អប់រំសុខភាព</h3>
			</div>
			<div class="modal-body" data-bind="with: education">
				<p class="kh form-inline">
                    •ចំនួនប្រជាជនសរុបបានអប់រំសុខភាព
                    <b>អំពីគ្រុនឈាម/គ្រុនឈីក</b>=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: Dangue"/> នាក់
                    (ស្រី=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: DangueFemale"/> នាក់) 
                    ចំនួនដង=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: DangueTime"/>
                </p>
                <p class="kh form-inline">
                    •ចំនួនប្រជាជនសរុបបានអប់រំសុខភាព
                    <b>អំពីដង្កូវ</b>=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: Worm"/> នាក់
                    (ស្រី=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: WormFemale"/> នាក់) 
                    ចំនួនដង=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: WormTime"/>
                </p>
                <p class="kh form-inline">
                    •ចំនួនប្រជាជនសរុបបានអប់រំសុខភាព
                    <b>គ្រុនចាញ់</b>=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: Malaria"/> នាក់
                    (ស្រី=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: MalariaFemale"/> នាក់) 
                    ចំនួនដង=<input type="number" min="0" class="form-control width50 text-center" data-bind="value: MalariaTime"/>
                </p>
                <p class="kh form-inline">
                    •<b>ថ្នាំបាញ់លើស្បែកបណ្តេញមូស៖</b> ចំនួន<b>នៅសល់ពីខែមុន=</b> <input type="number" min="0" class="form-control width50 text-center" data-bind="value: RepellentStockStart"/> ដប
                    ចំនួន<b>ប្រើអស់=</b> <input type="number" min="0" class="form-control width50 text-center" data-bind="value: RepellentStockOut"/> ដប 
                    ចំនួន<b>បន្ថែម</b> <input type="number" min="0" class="form-control width50 text-center" data-bind="value: RepellentStockIn"/> ដប 
                    ចំនួន<b>សរុបខែថ្មី</b> <input type="number" min="0" class="form-control width50 text-center" data-bind="value: RepellentBalance"/> ដប
                </p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" style="width:100px" data-bind="click: $root.saveEdu">Save</button>
				<button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Commodity -->
<div class="modal" id="modalCommodity" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary kh">សម្ភារៈគ្រុនចាញ់</h3>
			</div>
			<div class="modal-body">
                <table class="table table-bordered table-hover kh">
                    <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th>សម្ភារៈគ្រុនចាញ់</th>
                            <th>សល់ពីខែមុន</th>
                            <th>ប្រើអស់</th>
                            <th>នៅសល់</th>
                            <th>បន្ថែម</th>
                            <th>សរុប</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: commodities">
                        <tr>
                            <td class="text-center" data-bind="text: $index() + 1"></td>
                            <td data-bind="text: NameK"></td>
                            <td><input type="number" class="form-control text-center width100" data-bind="value: StockStart" /></td>
                            <td><input type="number" class="form-control text-center width100" data-bind="value: StockOut"/></td>
                            <td><input type="number" class="form-control text-center width100" data-bind="value: Total" /></td>
                            <td><input type="number" class="form-control text-center width100" data-bind="value: StockIn"/></td>
                            <td><input type="number" class="form-control text-center width100" data-bind="value: Balance" /></td>
                        </tr>
                    </tbody>
                </table>
				
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" style="width:100px" data-bind="click: $root.saveCommodity">Save</button>
				<button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/VMWCase.js')?>