<div class="panel-heading clearfix" data-bind="visible: view() == 'list' && ['HC','VMW','PRH/RH'].contain(menu())">
	<div class="pull-left form-inline">
		<div class="inlineblock">
			<div class="text-bold">Province</div>
			<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length == 1 ? undefined : 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">OD</div>
			<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: odList().length == 1 ? undefined : 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">HF</div>
			<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock" data-bind="visible: menu() == 'VMW'">
			<div class="text-bold">VMW</div>
			<select class="form-control minwidth100" data-bind="value: vl, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock relative">
			<div class="text-bold">From</div>
			<input type="text" class="form-control text-center width80" data-bind="datePicker: mf, format: 'MMM YYYY', minDate: '2022-01-01'" />
		</div>
		<div class="inlineblock relative">
			<div class="text-bold">To</div>
			<input type="text" class="form-control text-center width80" data-bind="datePicker: mt, format: 'MMM YYYY', minDate: '2022-01-01'" />
		</div>
		<div class="inlineblock">
			<div class="text-bold">Filter</div>
			<select class="form-control" data-bind="value: filter">
				<option>All</option>
				<option>Has iDes</option>
			</select>
		</div>
		<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
	</div>
    <div class="pull-right" style="padding-top:20px">
        <!-- ko if: app.user.permiss['iDes'].contain('Export Excel') -->
        <button class="btn btn-success" data-bind="click: exportExcel, visible: ((menu() == 'HC' && hcLoaded()) || (menu() == 'VMW' && vmwLoaded()) || (menu() == 'PRH/RH' && rhLoaded()))">Export Excel</button>
        <!-- /ko -->
    </div>
</div>
<div class="panel-heading clearfix" data-bind="visible: view() == 'detail'">
	<div class="pull-left" style="position:sticky; left:21px">
		<button class="btn width100" data-bind="click: () => formMenu('ides'), css: formMenu() == 'ides' ? 'btn-info' : 'btn-default'">iDes</button>
		<button class="btn width100" data-bind="click: () => formMenu('followup'), css: formMenu() == 'followup' ? 'btn-info' : 'btn-default'">Followup</button>
	</div>
	<div class="pull-right" style="position:sticky; right:21px">
        <!-- ko if: app.user.permiss['iDes'].contain('Edit') -->
		<button class="btn btn-primary width100" data-bind="click: save">Save</button>
        <!-- /ko -->
		<button class="btn btn-default width100" data-bind="click: back">Back</button>
	</div>
</div>

<div class="panel-body" data-bind="visible: view() == 'list' && menu() == 'HC' && hcLoaded()">
	<table id="tblHC" class="table table-bordered table-hover">
		<thead class="bg-thead">
			<tr>
				<th align="center" export="no" width="40">#</th>
				<th align="center" sortable>Province</th>
				<th align="center" sortable>OD</th>
				<th align="center" sortable>Health Facility</th>
				<th align="center" sortable>Patient Name</th>
				<th align="center" sortable>Diagnosis Date</th>
				<th align="center" sortable>Age</th>
				<th align="center" sortable>Sex</th>
				<th align="center" sortable>Species</th>
				<th align="center" sortable>Month</th>
				<th align="center" sortable>Has iDes</th>
				<th align="center" sortable>iDes Date</th>
				<th align="center" export="no" width="60">Detail</th>
                <th align="center" export="no" width="60" data-bind="visible: app.user.permiss['iDes'].contain('Delete')">Delete</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: hcListModel, fixedHeader: true">
			<tr>
				<td align="center" data-bind="text: $index() + 1"></td>
				<td data-bind="text: $root.getPVName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getODName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
				<td data-bind="text: NameK, css: { kh: iskhmer(NameK) }"></td>
				<td align="center" data-bind="text: moment(DateCase).displayformat(), sortValue: DateCase"></td>
				<td align="center" data-bind="text: Age"></td>
				<td align="center" data-bind="text: Sex == 'M' ? 'Male' : 'Female'"></td>
				<td align="center" data-bind="text: $root.getSpecies(Diagnosis)"></td>
				<td align="center" data-bind="text: Month"></td>
				<td align="center" data-bind="text: HasiDes == 1 ? '✔' : ''"></td>
				<td align="center" data-bind="text: moment(iDesDate).displayformat(), sortValue: iDesDate"></td>
				<td align="center">
					<a data-bind="click: $root.showDetail">Detail</a>
				</td>
                <td align="center" data-bind="if: HasiDes == 1, visible: app.user.permiss['iDes'].contain('Delete')">
					<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
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

<div class="panel-body" data-bind="visible: view() == 'list' && menu() == 'VMW' && vmwLoaded()">
	<table id="tblVMW" class="table table-bordered table-hover">
		<thead class="bg-thead">
			<tr>
				<th align="center" export="no" width="40">#</th>
				<th align="center" sortable>Province</th>
				<th align="center" sortable>OD</th>
				<th align="center" sortable>Health Facility</th>
				<th align="center" sortable>VMW</th>
				<th align="center" sortable>Patient Name</th>
				<th align="center" sortable>Diagnosis Date</th>
				<th align="center" sortable>Age</th>
				<th align="center" sortable>Sex</th>
				<th align="center" sortable>Species</th>
				<th align="center" sortable>Month</th>
				<th align="center" sortable>Has iDes</th>
				<th align="center" sortable>iDes Date</th>
				<th align="center" export="no" width="60">Detail</th>
                <th align="center" export="no" width="60" data-bind="visible: app.user.permiss['iDes'].contain('Delete')">Delete</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: vmwListModel, fixedHeader: true">
			<tr>
				<td align="center" data-bind="text: $index() + 1"></td>
				<td data-bind="text: $root.getPVName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getODName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getVLName(Code_Vill_T)"></td>
				<td data-bind="text: NameK, css: { kh: iskhmer(NameK) }"></td>
				<td align="center" data-bind="text: moment(DateCase).displayformat(), sortValue: DateCase"></td>
				<td align="center" data-bind="text: Age"></td>
				<td align="center" data-bind="text: Sex == 'M' ? 'Male' : 'Female'"></td>
				<td align="center" data-bind="text: $root.getSpecies(Diagnosis)"></td>
				<td align="center" data-bind="text: Month"></td>
				<td align="center" data-bind="text: HasiDes == 1 ? '✔' : ''"></td>
				<td align="center" data-bind="text: moment(iDesDate).displayformat(), sortValue: iDesDate"></td>
				<td align="center">
					<a data-bind="click: $root.showDetail">Detail</a>
				</td>
                <td align="center" data-bind="if: HasiDes == 1, visible: app.user.permiss['iDes'].contain('Delete')">
					<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
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

<div class="panel-body" data-bind="visible: view() == 'list' && menu() == 'PRH/RH' && rhLoaded()">
	<table id="tblPRHRH" class="table table-bordered table-hover">
		<thead class="bg-thead">
			<tr>
				<th align="center" export="no" width="40">#</th>
				<th align="center" sortable>Province</th>
				<th align="center" sortable>OD</th>
				<th align="center" sortable>Health Facility</th>
				<th align="center" sortable>Patient Name</th>
				<th align="center" sortable>Diagnosis Date</th>
				<th align="center" sortable>Age</th>
				<th align="center" sortable>Sex</th>
				<th align="center" sortable>Species</th>
				<th align="center" sortable>Month</th>
				<th align="center" sortable>Has iDes</th>
				<th align="center" sortable>iDes Date</th>
				<th align="center" export="no" width="60">Detail</th>
                <th align="center" export="no" width="60" data-bind="visible: app.user.permiss['iDes'].contain('Delete')">Delete</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: rhListModel, fixedHeader: true">
			<tr>
				<td align="center" data-bind="text: $index() + 1"></td>
				<td data-bind="text: $root.getPVName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getODName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
				<td data-bind="text: NameK, css: { kh: iskhmer(NameK) }"></td>
				<td align="center" data-bind="text: moment(DateCase).displayformat(), sortValue: DateCase"></td>
				<td align="center" data-bind="text: Age"></td>
				<td align="center" data-bind="text: Sex == 'M' ? 'Male' : 'Female'"></td>
				<td align="center" data-bind="text: $root.getSpecies(Diagnosis)"></td>
				<td align="center" data-bind="text: Month"></td>
				<td align="center" data-bind="text: HasiDes == 1 ? '✔' : ''"></td>
				<td align="center" data-bind="text: moment(iDesDate).displayformat(), sortValue: iDesDate"></td>
				<td align="center">
					<a data-bind="click: $root.showDetail">Detail</a>
				</td>
                <td align="center" data-bind="if: HasiDes == 1, visible: app.user.permiss['iDes'].contain('Delete')">
					<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
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

<div class="panel-body" data-bind="visible: view() == 'detail'">
	<div style="margin:auto; width:1300px" data-bind="visible: formMenu() == 'ides'">
		<h4>Annex 2 Patient Follow up Form</h4>
		<br />

		<!-- ko with: masterModel -->
		<table class="table table-bordered">
			<tr>
				<th class="info" colspan="6">A. HEALTH FACILITY INFORMATION</th>
			</tr>
			<tr>
				<th class="active" align="right">Health Facility</th>
				<td>
					<div data-bind="text: $root.getHCName(Code_Facility_T)"></div>
				</td>
					
				<th rowspan="2" class="active" align="right">OD</th>
				<td rowspan="2" data-bind="text: $root.getODName(Code_Facility_T)"></td>

				<th rowspan="2" class="active" align="right">Province</th>
				<td rowspan="2" data-bind="text: $root.getPVName(Code_Facility_T)"></td>
			</tr>
			<tr>
				<th class="active" align="right">VMW Village</th>
				<td>
					<div data-bind="text: Case_Type == 'HC' ? '' : $root.getVLName(Code_Vill_T)"></div>
				</td>
			</tr>
			<tr>
				<th class="active" align="right">Date of notification</th>
				<td data-bind="text: moment(NotificationDate).format('DD-MM-YYYY')"></td>

				<th class="active" align="right">Date of diagnosis</th>
				<td data-bind="text: moment(DiagnosisDate).format('DD-MM-YYYY')"></td>

				<th class="active" align="right">Date of investigation</th>
				<td data-bind="text: moment(InvestigationDate).format('DD-MM-YYYY')"></td>
			<tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr>
				<th class="info" colspan="10">B. PATIENT INFORMATION</th>
			</tr>
			<tr>
				<th class="active" align="right">First name</th>
				<td data-bind="text: FirstName"></td>

				<th class="active" align="right">Last name</th>
				<td data-bind="text: ''"></td>

				<th class="active" align="right">Sex</th>
				<td data-bind="text: Sex == 'M' ? 'Male' : 'Female'"></td>

				<th class="active" align="right">Age</th>
				<td data-bind="text: Age"></td>

				<th class="active" align="right">Weight (Kg)</th>
				<td data-bind="text: Weight"></td>
			</tr>
			<tr>
				<th class="active" align="right">Date of Birth</th>
				<td class="relative">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: DOB, showClear: true" />
				</td>
					
				<th class="active" align="right">Occupation</th>
				<td>
					<input type="text" class="form-control input-sm" data-bind="value: Occupation" />
				</td>
					
				<th class="active" align="right">Contact phone number</th>
				<td data-bind="text: Phone" colspan="5"></td>
			</tr>
			<tr>
				<th class="active" align="right">Address</th>
				<td colspan="3">
					<div class="form-group form-inline">
						<span class="inlineblock" style="width:120px">Village name: </span>
						<span data-bind="text: isnull(Name_Vill_E,'N/A')"></span>
					</div>
					<div class="form-group form-inline">
						<span class="inlineblock" style="width:120px">Commune name: </span>
						<span data-bind="text: isnull(Name_Comm_E,'N/A')"></span>
					</div>
					<div class="form-group form-inline">
						<span class="inlineblock" style="width:120px">District name: </span>
						<span data-bind="text: isnull(Name_Dist_E,'N/A')"></span>
					</div>
					<div class="form-inline">
						<span class="inlineblock" style="width:120px">Province name: </span>
						<span data-bind="text: isnull(Name_Prov_E,'N/A')"></span>
					</div>
				</td>
				<th class="active" align="right">G6PD</th>
				<td data-bind="text: (Sex == 'M' ? 'Male: ' : 'Female: ') + isnull(G6PD,'N/A')" colspan="5"></td>
			</tr>
			<tr>
				<th class="active" align="right">Parasite species</th>
				<td data-bind="text: $root.getSpecies(Diagnosis)"></td>

				<th class="active" align="right">Type of case detection</th>
				<td data-bind="text: CaseDetection"></td>

				<th class="active" colspan="2" align="right">Type of case (based on case investigation)</th>
				<td data-bind="text: CaseInvestigation" colspan="4"></td>
			</tr>
		</table>
		<br />
			
		<table class="table table-bordered">
			<tr>
				<th colspan="9" class="info">C. TREATMENT INFORMATION</th>
			</tr>
			<tr>
				<th class="active">ASMQ</th>
				<th class="active">Dose</th>
				<td>
					<input type="text" class="form-control input-sm" data-bind="value: Dose" numonly="int" />
				</td>
				<th class="active">Total no. tablets</th>
				<td>
					<input type="text" class="form-control input-sm" data-bind="value: DoseTablet" numonly="int" />
				</td>
				<th class="active">Expiration Date</th>
				<td class="relative">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: DoseExpiration, showClear: true" placeholder="DD-MM-YYYY" />
				</td>
				<th class="active">Batch No.</th>
				<td>
					<input type="text" class="form-control input-sm" data-bind="value: DoseBatch" />
				</td>
			</tr>
			<tr>
				<th class="active">Primaquine</th>
				<th class="active">mg</th>
				<td>
					<input type="text" class="form-control input-sm" data-bind="value: Mg" numonly="int" />
				</td>
				<th class="active">Total no. tablets</th>
				<td>
					<input type="text" class="form-control input-sm" data-bind="value: MgTablet" numonly="int" />
				</td>
				<th class="active">Expiration Date</th>
				<td class="relative">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: MgExpiration, showClear: true" placeholder="DD-MM-YYYY" />
				</td>
				<th class="active">Batch No.</th>
				<td>
					<input type="text" class="form-control input-sm" data-bind="value: MgBatch" />
				</td>
			</tr>
		</table>
		<br />
		<!-- /ko -->

		<!-- ko with: detailModel -->
		<table class="table table-bordered table-hover">
			<tr>
				<th colspan="11" class="info">D. FOLLOW UP INFORMATION</th>
			</tr>
			<tr>
				<th class="active" colspan="2">Days</th>
				<!-- ko foreach: $root.days -->
				<th align="center" class="active" data-bind="text: $data" width="120"></th>
				<!-- /ko -->
			</tr>
			<tr>
				<td class="active" colspan="2">
					<b>Expected Date</b> (DD-MM-YYYY)
				</td>
				<!-- ko foreach: $root.days -->
				<td align="center" data-bind="text: moment($parent[$data].ExpectedDate).format('DD-MM-YYYY')"></td>
				<!-- /ko -->
			</tr>
			<tr>
				<td class="active" colspan="2">
					<b>Actual Date</b> (DD-MM-YYYY)
				</td>
				<!-- ko foreach: $root.days -->
				<td class="relative">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: $parent[$data].ActualDate, showClear: true" placeholder="DD-MM-YYYY" />
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Temp (&deg;C)</th>
				<!-- ko foreach: $root.days -->
				<td>
					<input type="text" class="form-control input-sm text-center" data-bind="value: $parent[$data].Temp" numonly="float" />
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Slide species (fill in Pf, Pv, Po, Pm, Pk or Mix)</th>
				<!-- ko foreach: $root.days -->
				<td>
					<select class="form-control input-sm" data-bind="value: $parent[$data].SlideSpecies">
						<option></option>
						<option value="F">Pf</option>
						<option value="V">Pv</option>
						<option value="M">Mix</option>
						<option value="A">Pm</option>
						<option value="O">Po</option>
						<option value="K">Pk</option>
                        <option value="N">N</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>

			<!-- ko if: ['F','A','K'].contain($root.masterModel().Diagnosis) -->
			<tr>
				<th class="active" rowspan="2">Pf/Pm/Pk</th>
				<th width="70" class="active">ASMQ</th>
				<!-- ko foreach: $root.days -->
				<td class="relative" data-bind="if: ['D0','D1','D2'].contain($data)">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: $parent[$data].PfPmPkASMQ, showClear: true" placeholder="DD-MM-YYYY" />
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active">PQ</th>
				<!-- ko foreach: $root.days -->
				<td class="relative" data-bind="if: $data == 'D0'">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: $parent[$data].PfPmPkPQ, showClear: true" placeholder="DD-MM-YYYY" />
				</td>
				<!-- /ko -->
			</tr>
			<!-- /ko -->

			<!-- ko if: ['V','O','M'].contain($root.masterModel().Diagnosis) -->
			<!-- ko if: isnull($root.masterModel().G6PD,'').contain('Normal') -->
			<tr>
				<th class="active" rowspan="2">Pv/Po/Mix<br />(G6PD Normal)</th>
				<th width="70" class="active">ASMQ</th>
				<!-- ko foreach: $root.days -->
				<td class="relative" data-bind="if: ['D0','D1','D2'].contain($data)">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: $parent[$data].G6PDNormalASMQ, showClear: true" placeholder="DD-MM-YYYY" />
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active">PQ</th>
				<!-- ko foreach: $root.days -->
				<td class="relative" data-bind="if: ['D0','D1','D2','D3','D7','D14'].contain($data)">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: $parent[$data].G6PDNormalPQ, showClear: true" placeholder="DD-MM-YYYY" />
				</td>
				<!-- /ko -->
			</tr>
			<!-- /ko -->

			<!-- ko ifnot: isnull($root.masterModel().G6PD,'').contain('Normal') -->
			<tr>
				<th class="active">Pv/Po/Mix<br />(G6PD Deficient)</th>
				<th class="active">ASMQ</th>
				<!-- ko foreach: $root.days -->
				<td class="relative" data-bind="if: ['D0','D1','D2'].contain($data)">
					<input type="text" class="form-control input-sm text-center" data-bind="datePicker: $parent[$data].G6PDDeficient, showClear: true" placeholder="DD-MM-YYYY" />
				</td>
				<!-- /ko -->
			</tr>
			<!-- /ko -->
			<!-- /ko -->

			<tr>
				<th class="active" colspan="2">Vomiting within 30 min of drug intake (tick)</th>
				<!-- ko foreach: $root.days -->
				<td data-bind="if: ['D0','D1','D2'].contain($data)">
					<select class="form-control input-sm" data-bind="value: $parent[$data].Vomit30min">
						<option></option>
						<option>Y</option>
						<option>N</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Collect slides (circle)</th>
				<!-- ko foreach: $root.days -->
				<td data-bind="if: ['D0','D28','D42','D90'].contain($data)">
					<select class="form-control input-sm" data-bind="value: $parent[$data].CollectSlide">
						<option></option>
						<option>Y</option>
						<option>N</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Collect DBS (tick)</th>
				<!-- ko foreach: $root.days -->
				<td data-bind="if: ['D0','D28','D42','D90'].contain($data)">
					<select class="form-control input-sm" data-bind="value: $parent[$data].CollectDBS">
						<option></option>
						<option>Y</option>
						<option>N</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th colspan="11" class="active">SIDE EFFECTS (check if present or not. fill in "Y" for present, "N" for not present, and "D" for don't know. Do not leave the cell blank)</th>
			</tr>
			<tr>
				<th class="active" colspan="2">Vomit (within 1 hrs)</th>
				<!-- ko foreach: $root.days -->
				<td align="center">
					<select class="form-control input-sm" data-bind="value: $parent[$data].Vomit2hrs">
						<option></option>
						<option>Y</option>
						<option>N</option>
						<option>D</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Dizziness</th>
				<!-- ko foreach: $root.days -->
				<td align="center">
					<select class="form-control input-sm" data-bind="value: $parent[$data].Dizziness">
						<option></option>
						<option>Y</option>
						<option>N</option>
						<option>D</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Headache</th>
				<!-- ko foreach: $root.days -->
				<td align="center">
					<select class="form-control input-sm" data-bind="value: $parent[$data].Headache">
						<option></option>
						<option>Y</option>
						<option>N</option>
						<option>D</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Abdominal pain</th>
				<!-- ko foreach: $root.days -->
				<td align="center">
					<select class="form-control input-sm" data-bind="value: $parent[$data].Pain">
						<option></option>
						<option>Y</option>
						<option>N</option>
						<option>D</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Diarrhoea</th>
				<!-- ko foreach: $root.days -->
				<td align="center">
					<select class="form-control input-sm" data-bind="value: $parent[$data].Diarrhoea">
						<option></option>
						<option>Y</option>
						<option>N</option>
						<option>D</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Skin rashes</th>
				<!-- ko foreach: $root.days -->
				<td align="center">
					<select class="form-control input-sm" data-bind="value: $parent[$data].SkinRash">
						<option></option>
						<option>Y</option>
						<option>N</option>
						<option>D</option>
					</select>
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Others: specify</th>
				<!-- ko foreach: $root.days -->
				<td align="center">
					<input type="text" class="form-control input-sm" data-bind="value: $parent[$data].OtherEffect" />
				</td>
				<!-- /ko -->
			</tr>
			<tr>
				<th class="active" colspan="2">Follow up by (Initial): </th>
				<!-- ko foreach: $root.days -->
				<td align="center">
					<input type="text" class="form-control input-sm" data-bind="value: $parent[$data].FollowupBy" />
				</td>
				<!-- /ko -->
			</tr>
		</table>
		<br />
		<!-- /ko -->

		<table class="table table-bordered" data-bind="with: masterModel">
			<tr>
				<th colspan="2" class="info">E. RESULTS & CONCLUSIONS (for national iDES team to complete)</th>
			</tr>
			<tr>
				<th class="active" width="255">Follow up completed as scheduled:</th>
				<td class="form-inline">
					<select class="form-control input-sm" data-bind="value: FollowupCompleted">
						<option></option>
						<option>Y</option>
						<option>N, terminated due to parasitemia</option>
						<option>N, terminated due to suspected treatment failure</option>
						<option>N, lost of follow-up</option>
					</select>
				</td>
			</tr>
			<tr>
				<th class="active">PCR Results</th>
				<td class="form-inline">
					<select class="form-control input-sm" data-bind="value: PCR">
						<option></option>
						<option>Undetermined</option>
						<option>Negative</option>
						<option>Recrudescence</option>
						<option>Reinfection</option>
						<option>Other species</option>
					</select>
						
					<input type="text" class="form-control input-sm" data-bind="value: PCROther, visible: PCR() == 'Other species'" placeholder="Specify" style="width:250px" />
				</td>
			</tr>
			<tr>
				<th class="active">Conclusions</th>
				<td class="form-inline relative">
					<select class="form-control input-sm" data-bind="value: Conclusion">
						<option></option>
						<option>ACPR</option>
						<option>Treatment failure</option>
					</select>

					<span data-bind="visible: Conclusion() == 'Treatment failure'">
						<span class="space">Date of failure:</span>
						<input type="text" class="form-control input-sm width100 text-center" data-bind="datePicker: DayFailure, dataType: 'string'" placeholder="DD-MM-YYYY" />
					</span>
				</td>
			</tr>
		</table>
	</div>

	<div style="width:fit-content; margin:auto; border:1px solid #ccc; padding:10px" data-bind="visible: formMenu() == 'followup', with: followupModel">
		<h4>Annex 12: Patient’s follow-up card for primaquine radical cure</h4>
		<br />
		<p class="form-inline">
			<b>Patient ID:</b>
			<span data-bind="text: isnullempty(PatientCode,'N/A')"></span>

			<b class="space">Patient Name:</b>
			<span data-bind="text: NameK"></span>

			<b class="space">Sex:</b>
			<span data-bind="text: Sex"></span>

			<b class="space">Weight (kg):</b>
			<span data-bind="text: Weight"></span>

			<b class="space">Species:</b>
			<span data-bind="text: $root.getSpecies(Diagnosis)"></span>
		</p>
		<p class="form-inline">
			<b>Date of G6PD test:</b>
			<span>N/A</span>

			<b class="space">G6PD value:</b>
			<span data-bind="text: G6PDHb == null ? 'N/A' : G6PDHb + 'U/g Hb'"></span>

			<b class="space">Hemoglobin level:</b>
			<span data-bind="text: G6PDdL == null ? 'N/A' : G6PDdL + 'g/dL'"></span>

			<b class="space">G6PD level:</b>
			<span data-bind="text: G6PDLevel == null ? 'N/A' : G6PDLevel"></span>

			<b class="space">Current Village:</b>
			<span data-bind="text: Name_Vill_E"></span>
		</p>
		<p class="form-inline">
			<b>HF Name:</b>
			<span data-bind="text: Name_Facility_E"></span>

			<b class="space">HF Phone No.:</b>
			<input type="text" class="form-control input-sm" data-bind="value: HFPhone" />

			<b class="space">Assigned Hospital Name:</b>
			<input type="text" class="form-control input-sm" data-bind="value: Hospital" />

			<b class="space">Assigned Hospital Phone No.:</b>
			<input type="text" class="form-control input-sm" data-bind="value: HospitalPhone" />
		</p>
		<div class="clearfix">
			<div class="pull-left" style="width:300px">
				<div style="background:orange" class="text-center">
					<b>ACT (for all patients)</b>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th width="60"></th>
							<th align="center">Date</th>
							<th align="center">Checked when completed</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Day 0</th>
							<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: ACTDay0Date" /></td>
							<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: ACTDay0Checked" /></td>
						</tr>
						<tr>
							<th>Day 1</th>
							<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: ACTDay1Date" /></td>
							<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: ACTDay1Checked" /></td>
						</tr>
						<tr>
							<th>Day 2</th>
							<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: ACTDay2Date" /></td>
							<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: ACTDay2Checked" /></td>
						</tr>
					</tbody>
				</table>
				<hr />

				<div style="background:green; color:white" class="text-center">
					<b>SLD PRIMAQUINE</b>
					<br />
					<span>(only form Pf patients)</span>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th width="60"></th>
							<th align="center">Date</th>
							<th align="center">Checked when completed</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Day 0</th>
							<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: SLDDay0Date" /></td>
							<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: SLDDay0Checked" /></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="pull-left">
				<div style="background:#5B9BD5" class="text-center">
					<b style="color:white">PRIMAQUINE</b>
					<b style="color:yellow">(only for Pv, Po & mixed patients)</b>
				</div>
				<div class="pull-left" style="padding:5px; border-left:1px solid #ccc; width:600px; height:390px">
					<div style="background:#5B9BD5" class="text-center">
						<b style="color:white">G6PD normal (14-day PQ)</b>
					</div>
					<table class="table">
						<thead>
							<tr>
								<th width="60"></th>
								<th align="center">Date</th>
								<th align="center">Checked when completed</th>
								<th width="60"></th>
								<th align="center">Date</th>
								<th align="center">Checked when completed</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>Day 0</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day0Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day0Checked" /></td>
								<th>Day 7</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day7Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day7Checked" /></td>
							</tr>
							<tr>
								<th>Day 1</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day1Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day1Checked" /></td>
								<th>Day 8</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day8Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day8Checked" /></td>
							</tr>
							<tr>
								<th>Day 2</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day2Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day2Checked" /></td>
								<th>Day 9</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day9Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day9Checked" /></td>
							</tr>
							<tr>
								<th>Day 3</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day3Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day3Checked" /></td>
								<th>Day 10</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day10Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day10Checked" /></td>
							</tr>
							<tr>
								<th>Day 4</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day4Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day4Checked" /></td>
								<th>Day 11</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day11Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day11Checked" /></td>
							</tr>
							<tr>
								<th>Day 5</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day5Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day5Checked" /></td>
								<th>Day 13</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day13Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day13Checked" /></td>
							</tr>
							<tr>
								<th>Day 6</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day6Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day6Checked" /></td>
								<th>Day 13</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Day13Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Day13Checked" /></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="pull-left" style="padding:5px; width:300px; border-left:1px solid #ccc">
					<div style="background:#5B9BD5" class="text-center">
						<b style="color:white">G6PD intermediate & <br /> deficient (8-week PQ)</b>
					</div>
					<table class="table">
						<thead>
							<tr>
								<th width="60"></th>
								<th align="center">Date</th>
								<th align="center">Checked when completed</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>Week 1</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Week1Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Week1Checked" /></td>
							</tr>
							<tr>
								<th>Week 2</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Week2Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Week2Checked" /></td>
							</tr>
							<tr>
								<th>Week 3</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Week3Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Week3Checked" /></td>
							</tr>
							<tr>
								<th>Week 4</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Week4Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Week4Checked" /></td>
							</tr>
							<tr>
								<th>Week 5</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Week5Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Week5Checked" /></td>
							</tr>
							<tr>
								<th>Week 6</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Week6Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Week6Checked" /></td>
							</tr>
							<tr>
								<th>Week 7</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Week7Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Week7Checked" /></td>
							</tr>
							<tr>
								<th>Week 8</th>
								<td class="relative"><input type="text" class="form-control input-sm text-center" data-bind="datePicker: Week8Date" /></td>
								<td align="center"><input type="checkbox" class="checkbox-lg" data-bind="checked: Week8Checked" /></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && app.user.permiss['iDes'].contain('Edit')">
	<button class="btn btn-primary width150" data-bind="click: save">Save</button>
</div>