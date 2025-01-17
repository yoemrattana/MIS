<style>
    .table-hover thead { background-color: #9AD8ED; }
	.form-control { padding: 2px 5px; }
	.space { margin-left: 10px; }
	.photo { width: 802px; min-height: 400px; border: 1px solid black; position: relative; }
	.photo button { position: absolute; top: 4px; right: 4px; border-color: white; }
	.photo button:hover, .photo button:focus, .photo button:focus:active { border-color: white; }
	.highlight { background-color: #ffff99; font-weight: bold; }
	.width70 { width:70px !important; }
    .underline:not(:empty) { cursor: pointer; color: blue; }
    .underline:not(:empty):hover { text-decoration: underline; }
    .underscore { border-bottom:1px solid; display:inline-block; text-align:center; }
	.panel-body { border:1px solid; margin:10px; }
	.width60 { width:60px !important; }
    .custom-control {
        position: relative;
        display: block;
        min-height: 1.3125rem;
        padding-left: 1.5rem;
    }
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
    .displayTable {
        display:table
    }
</style>

<div class="panel panel-default" data-bind="visible: view() == 'list'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<div class="inlineblock">
				<div class="text-bold">Province</div>
				<select data-bind="value: pv,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: pvList().length == 1 ? undefined : 'All Province'" class="form-control minwidth150"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">OD</div>
				<select data-bind="value: od,
						options: odList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: odList().length == 1 ? undefined : 'All OD'" class="form-control minwidth150"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">HC</div>
				<select data-bind="value: hc,
						options: hcList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All HC'" class="form-control minwidth150"></select>
			</div>
			<div class="inlineblock">
				<select data-bind="value: year, options: yearList" class="form-control width100"></select>
			</div>
            <div class="inlineblock">
					<select data-bind="value: month, options: monthList, optionsCaption: 'All'" class="form-control"></select>
				</div>
            <div class="inlineblock">
                <button class="btn btn-primary" data-bind="click: viewData">View</button>
            </div>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
        <table class="table table-bordered table-hover table-striped kh">
            <thead>
                <tr>
                    <th width="8">#</th>
                    <th width="50">Province</th>
                    <th width="50">OD</th>
                    <th width="250">HC</th>
                    <th>Village </th>
                    <th>Infection Source </th>
                    <th>Patient Code</th>
                    <th>Patient Name</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Diagnosis</th>
                    <th>Date case</th>
                    <th>Year</th>
                    <th sortable>Month</th>
                    <th>Case From</th>
                    <th>Classify</th>
                    <th sortable>Done</th>
                    <th width="30">Action</th>
                    <th colspan="2">Note</th>
                    <th></th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listModel, fixedHeader: true">
                <tr>
                    <td data-bind="text: $index() + 1"></td>
                    <td data-bind="text: $root.getProvName(Code_Prov_N)"></td>
                    <td data-bind="text: $root.getODName(Code_OD_T)"></td>
                    <td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
                    <td data-bind="text: $root.getVill(Code_Vill_t)"></td>
                    <td data-bind="text: $root.getVill(InfectionSourceAddress)"></td>
                    <td data-bind="text: PatientCode"></td>
                    <td data-bind="text: NameK"></td>
                    <td data-bind="text: Sex"></td>
                    <td data-bind="text: Age"></td>
                    <td data-bind="text: $root.getSpecie(Diagnosis)"></td>
                    <td data-bind="text: $root.dateFormat(DateCase)"></td>
                    <td data-bind="text: Year"></td>
                    <td data-bind="text: Month"></td>
                    <td data-bind="text: Type"></td>
                    <td data-bind="text: Classify"></td>
                    <td class="text-center" data-bind="sortValue: Done && NotDo == 0 ? 1 : 2">
                        <i data-bind="visible: Done && NotDo==0" class="fa fa-check-square-o"></i>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success" data-bind="visible: HasData || Done == false, click: $root.viewDetail">Detail</button>
                    </td>
                    <td style="width:30px">
                        <button class="btn btn-sm btn-primary" data-bind="visible: app.user.permiss['MRRT2'].contain('Foci Note'), click: $root.createNote">Note</button>
                    </td>
                    <td>
                         <span data-bind="visible: NotDo" class="text-danger fa fa-times"></span>
                         <span data-bind="text: ReasonNotDo"></span>
                    </td> 
                    <td>
                        <button class="btn btn-sm btn-danger kh" data-bind="visible: app.user.permiss['MRRT2'].contain('Foci Transfer'), click: $root.showTransfer">ផ្តល់សិទ្ធទៅODផ្សេង</button>
                        <span data-bind="visible: ToOD() != undefined">ផ្តល់សិទ្ទទៅ OD</span> <span data-bind="text: $root.getODName(ToOD())" class="badge"></span>
                    </td> 
                </tr>

            </tbody>
        </table>
     </div>
</div>

<!--Form-->

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 text-bold lh26">MRRT Foci</div>
		<div class="pull-right">
            <button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('Foci Edit')">Save</button>
			<!--ko if: isDelete-->
            <button class="btn btn-danger btn-sm width100" data-bind="click: showDelete, visible: app.user.permiss['MRRT2'].contain('Foci Delete')">Delete</button>
            <!-- /ko -->
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back">Back</button>
		</div>
	</div>
	<div class="panel-body displayTable" style="min-width: 900px; margin: auto">
		<h3 class="kh text-center text-bold">ទម្រង់អង្កេតសំបុកចម្លង</h3>
        <h4 class="kh text-center text-bold">(ដោយក្រុមMRRT)</h4>
		<br />
		<br />
		
        <div data-bind="with: detailModel">
            <!-- Part 1 -->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th class="bg-info" colspan="2">ផ្នែកទី 1៖ ព័ត៌មានអ្នកជំងឺ</th>
                    <th class="bg-info" colspan="2">
                        លេខកូដអ្នកជំងឺ៖
                        <input type="text" class="form-control" data-bind="value: PatientCode" />
                    </th>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        ឈ្មោះ៖
                        <input type="text" class="form-control" data-bind="value: PatientName" />
                    </td>
                    <td>
                        អាយុ៖
                        <input type="number" class="form-control" data-bind="value: Age"  />
                    </td>
                    <td>
                        ភេទ
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Sex" value="M" data-bind="checked: Sex" />
                            <kh>ប្រុស</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Sex" value="F" data-bind="checked: Sex" />
                            <kh>ស្រី</kh>
                        </label>
                    </td>
                    <td>
                        ថ្ងៃចេញរោគសញ្ញាដំបូង៖
                        <input type="date" class="form-control" data-bind="value: SymptomDate" />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">
                        លទ្ធផលតេស្ត៖
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="F" data-bind="checked: Diagnosis" />
                            <kh>Pf</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="V" data-bind="checked: Diagnosis" />
                            <kh>Pv</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="M" data-bind="checked: Diagnosis" />
                            <kh>Mix</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="A" data-bind="checked: Diagnosis" />
                            <kh>Pm</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="K" data-bind="checked: Diagnosis" />
                            <kh>Pk</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="O" data-bind="checked: Diagnosis" />
                            <kh>Po</kh>
                        </label>
                    </td>
                    <td>
                        កន្លែងធ្វើរោគវិនិច្ឆ័យ៖
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DiagnosisPlace" value="VMW" data-bind="checked: DiagnosisPlace" />
                            <kh>VMW/MMW</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DiagnosisPlace" value="HC" data-bind="checked: DiagnosisPlace" />
                            <kh>HF</kh>
                        </label>
                    </td>
                    <td>
                        បានបញ្ចប់ការព្យាបាល៖
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="CompletedTreatment" value="1" data-bind="checked: CompletedTreatment, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="CompletedTreatment" value="0" data-bind="checked: CompletedTreatment, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="CompletedTreatment" value="2" data-bind="checked: CompletedTreatment, click: $root.radioClick" />
                            <kh>កំពុងព្យាបាល</kh>
                        </label>
                        <span data-bind="validationMessage: CompletedTreatment" class="message-error"></span>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="4">
                        អាស័យដ្ឋានកំពុងស្នាក់នៅ៖
                        <span style="color:red" data-bind="text: $root.getVill(Address())"></span>
                        <input type="hidden" param="address" class="form-control" data-bind="value: Address" />
                        <span data-bind="validationMessage: Address" class="message-error"></span>
                        <button param="address" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="4">
                        អាស័យដ្ឋានអចិន្ត្រៃយ៍អ្នកជំងឺ៖
                        <span style="color:red" data-bind="text: $root.getVill(PermanentAddress())"></span>
                        <input type="hidden" class="form-control" data-bind="value: PermanentAddress" />
                        <span data-bind="validationMessage: PermanentAddress" class="message-error"></span>
                        <button param="peraddress" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="4">
                        អាស័យដ្ឋានទីកន្លែងប្រភពចម្លង៖
                        <span style="color:red" data-bind="text: $root.getVill(InfectionSourceAddress())"></span>
                        <input type="hidden" class="form-control" data-bind="value: InfectionSourceAddress" />
                        <span data-bind="validationMessage: InfectionSourceAddress" class="message-error"></span>
                        <button param="infaddress" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">
                        ថ្ងៃខែឆ្នាំនៃការធ្វើរោគវិនិច្ឆ័យ៖
                        <input type="date" class="form-control" data-bind="value: DateCase" />
                    </td>
                    <td colspan="2">
                        ថ្ងៃខែឆ្នាំនៃការរាយការណ៍ករណី៖
                        <input type="date" class="form-control" data-bind="value: ReportedDate" />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">
                        ថ្ងៃខែឆ្នាំនៃការអង្កេតករណី៖
                        <input type="date" class="form-control" data-bind="value: InvDate" />
                    </td>
                    <td colspan="2">
                        ថ្ងៃខែឆ្នាំនៃការអង្កេតសំបុកចម្លង៖
                        <input type="date" class="form-control" data-bind="value: FociDate" />
                    </td>
                </tr>
            </table>

            <!--Part 2-->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th class="bg-info" colspan="7">ផ្នែកទី 2៖ ការអង្កេតសំបុកចម្លង</th>
                </tr>
                <tr>
                    <td colspan="7">សំបុកចម្លងក្នុងរយៈពេល 5 ឆ្នាំកន្លងមក & ការចាត់ថ្នាក់សំបុកចម្លងបច្ចុប្បន្ន</td>
                </tr>
                <tr style="background: azure">
                    <td>ការចាត់ថ្នាក់សំបុកចម្លង</td>
                    <td class="text-center">1 ឆ្នាំមុន</td>
                    <td class="text-center">2 ឆ្នាំមុន</td>
                    <td class="text-center">3 ឆ្នាំមុន</td>
                    <td class="text-center">4 ឆ្នាំមុន</td>
                    <td class="text-center">5 ឆ្នាំមុន</td>
                    <td class="text-center">ស្ថានភាពបច្ចុប្បន្ន</td>
                </tr>
                <tr>
                    <td>សកម្ម Active (មានករណីLAក្នុងរយៈពេល១២ខែ)</td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Active_1" value="1" data-bind="checked: Active_1" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Active_2" value="1" data-bind="checked: Active_2" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Active_3" value="1" data-bind="checked: Active_3" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Active_4" value="1" data-bind="checked: Active_4" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Active_5" value="1" data-bind="checked: Active_5" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Active_Present" value="1" data-bind="checked: Active_Present" />
                    </td>
                </tr>
                <tr>
                    <td>សំណល់មិនសកម្ម​ Residual non-active (មិនមានករណីLAចាប់ពី១២-៣៦ខែ)</td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Residual_1" value="1" data-bind="checked: Residual_1" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Residual_2" value="1" data-bind="checked: Residual_2" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Residual_3" value="1" data-bind="checked: Residual_3" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Residual_4" value="1" data-bind="checked: Residual_4" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Residual_5" value="1" data-bind="checked: Residual_5" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Residual_Present" value="1" data-bind="checked: Residual_Present" />
                    </td>
                </tr>
                <tr>
                    <td>សម្អាត Cleared (មិនមានករណីLAច្រើនជាង៣៦ខែ)</td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Cleared_1" value="1" data-bind="checked: Cleared_1" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Cleared_2" value="1" data-bind="checked: Cleared_2" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Cleared_3" value="1" data-bind="checked: Cleared_3" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Cleared_4" value="1" data-bind="checked: Cleared_4" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Cleared_5" value="1" data-bind="checked: Cleared_5" />
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="checkbox-lg" name="Cleared_Present" value="1" data-bind="checked: Cleared_Present" />
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        សំនួរទី 1. ប្រសិនបើសំបុកចម្លងបច្ចុប្បន្នត្រូវបានចាត់ថ្នាក់ថា <b>សកម្ម</b> តើមានអន្តរាគមន៍ឆ្លើយតបនឹងសំបុកចម្លងកំពុងអនុវត្ត ដែរ ឬទេ?
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="ResponseFoci" value="1" data-bind="checked: ResponseFoci, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="ResponseFoci" value="0" data-bind="checked: ResponseFoci, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                    </td>
                </tr>
            </table>

            <!--Part 3-->
            <table class="table table-bordered kh">
                <thead>
                    <tr class="form-inline relative">
                        <th class="bg-info" colspan="14">ផ្នែកទី 3៖ ការពិនិត្យទិន្នន័យដែលមានស្រាប់</th>
                    </tr>
                    <tr>
                        <td colspan="14">ករណីជំងឺគ្រុនចាញ់ក្នុងរយៈពេលបីឆ្នាំចុងក្រោយនេះ៖</td>
                    </tr>
                    <tr>
                        <td class="text-center">ឆ្នាំ</td>
                        <td class="text-center">តេស្ត</td>
                        <td class="text-center">វិជ្ជមាន</td>
                        <td class="text-center">Pf/Mix</td>
                        <td class="text-center">Pv/Pm/Pk/Po</td>
                        <td class="text-center">&lt; 5</td>
                        <td class="text-center">5-14</td>
                        <td class="text-center">15–49</td>
                        <td class="text-center">&gt; 49</td>
                        <td class="text-center">ឆ្លងនៅក្នុងតំបន់</td>
                        <td class="text-center">នាំចូលក្នុងស្រុក</td>
                        <td class="text-center">នាំចូលក្រៅប្រទេស</td>
                        <td class="text-center">ករណីលាប់/រើកើតឡើងវិញ</td>
                        <td class="text-center"></td>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Cases">
                    <tr>
                        <td>
                            <select data-bind="value: Year, options: $root.yList" class="form-control"></select>
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: Test"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: Positive"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: PfMix"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: PvPmPkPo"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: AgeU5"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: Age5_14"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: Age15_49"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: AgeG49"  />
                        </td>
                        <td>
                            <input type="text" class="form-control width70" data-bind="value: L1"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: LC"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: IMP"  />
                        </td>
                        <td>
                            <input type="number" class="form-control width70" data-bind="value: Relapse"  />
                        </td>
                        <td>
                            <i class="text-danger fa fa-trash fa-2x" data-bind="click: $root.removeMalaria"></i>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="14">
                            <button class="btn btn-success btn-sm" data-bind="click: $root.addMalaria">+ Add More</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="14">
                            សំនួរទី 2. តើមានប៉ុន្មានភាគរយនៃការរាយការណ៍ករណីក្នុងរយៈពេល 24 ម៉ោង(នៅក្នុងភូមិ) ឆ្នាំចុងក្រោយ?
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="Notify24h" value="lt90" data-bind="checked: Notify24h, click: $root.radioClick" />
                                <kh>&lt; 90%</kh>
                            </label>
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="Notify24h" value="gt90" data-bind="checked: Notify24h, click: $root.radioClick" />
                                <kh>&#8805; 90%</kh>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="14">
                            សំនួរទី 3. តើមានប៉ុន្មានភាគរយនៃការធ្វើតេស្តជំងឺគ្រុនចាញ់ (ABER) នៅក្នុងភូមិនៅឆ្នាំចុងក្រោយ?
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="ABER" value="lt10" data-bind="checked: ABER, click: $root.radioClick" />
                                <kh>&lt; 10%</kh>
                            </label>
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="ABER" value="gt10" data-bind="checked: ABER, click: $root.radioClick" />
                                <kh>&#8805; 10%</kh>
                            </label>
                        </td>
                    </tr>
                    <tr class="form-inline">
                        <td colspan="14">
                            សំនួរទី 4. តើអ្នកផ្តល់សេវាបានទទួលការអភិបាលធានាគុណភាពពី CNM/PHD/OD/HC ក្នុងរយៈពេល 3 ខែកន្លងមកឬទេ?
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="QA" value="1" data-bind="checked: QA, click: $root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label>
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="QA" value="0" data-bind="checked: QA, click: $root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                            ពិន្ទុ៖
                            <input type="number" class="form-control width70" data-bind="value: QAScore"  />
                        </td>
                    </tr>
                </tfoot>
            </table>

            <table class="table table-bordered kh">
                <thead>
                    <tr class="form-inline relative">
                        <th class="bg-info" colspan="6">ប្រវត្តិនៃអន្តរាគមន៍ឆ្លើយតបនឹងជំងឺគ្រុនចាញ់នៅក្នុងសំបុកចម្លង</th>
                    </tr>
                    <tr class="form-inline">
                        <td colspan="6">
                            សំនួរទី 5.យុទ្ធនាការចែកមុង LLIN នៅក្នុងសំបុកចម្លងក្នុងរយៈពេលបីឆ្នាំកន្លងមកនេះ៖
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="LLIN3y" value="1" data-bind="checked: LLIN3y, click: $root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label>
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="LLIN3y" value="0" data-bind="checked: LLIN3y, click: $root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center text-bold">ល.រ</td>
                        <td class="text-center text-bold">ចំនួនមុង​LLINsបានចែក(A)</td>
                        <td class="text-center text-bold">ចំនួនប្រជាជនគោលដៅ (B)</td>
                        <td class="text-center text-bold">គ្របដណ្តប់៖ (A) x 1.8 / (B)</td>
                        <td class="text-center text-bold">សម្គាល់</td>
                        <td class="text-center text-bold"></td>
                    </tr>
                </thead>
                <tbody data-bind="foreach: LLINs">
                    <tr>
                        <td class="text-center" data-bind="text: $index() + 1"></td>
                        <td class="text-center">
                            <input type="number" class="form-control" data-bind="value: LLIN" />
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control" data-bind="value: Pop"  />
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control" data-bind="value: Coverage" />
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control" data-bind="value: Note" />
                        </td>
                        <td class="text-center">
                            <i class="text-danger fa fa-trash fa-2x" data-bind="click: $root.removeLLIN"></i>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <button class="btn btn-success btn-sm" data-bind="click: $root.addLLIN">+ Add More</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            សំនួរទី 6.តើកន្លេងផ្តល់សេវាដូចជា VMW/HCនៅក្នុងភូមិ/ឬនៅជិតសំបុកចម្លងមានតេស្តរហ័ស និងថ្នាំគ្រុនចាញ់គ្រប់គ្រាន់ឬទេ?
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="SufficientRdtAct" value="0" data-bind="checked: SufficientRdtAct, click: $root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="SufficientRdtAct" value="1" data-bind="checked: SufficientRdtAct, click: $root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!--Part 4-->
            <table class="table table-bordered kh">
                <thead>
                    <tr class="form-inline relative">
                        <th class="bg-info" colspan="5">ផ្នែកទី 4៖ ការត្រួតពិនិត្យភូមិសាស្ត្រ និងការគូសផែនទី</th>
                    </tr>
                    <tr>
                        <td colspan="5">
                            ស្រង់ព័ត៍មានពីការពិភាក្សាជាមួយមេភូមិ និងទិន្នន័យផ្សេងៗដែលមាន៖
                            <br /> ព្រំដែនសំបុកចម្លង៖ សម្រាប់ភូមិធំ> 2 គីឡូម៉ែត្រ ការស្រាវជ្រាវនឹងគ្របដណ្តប់តំបន់នេះក្រោមកាំ 1 គីឡូម៉ែត្រពីករណីគោល
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">
                            សំនួរទី 7.តើក្នុងភូមិមាន VMW/MMW ទេ?
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="HasVMW" value="1" data-bind="checked: HasVMW, click: $root.radioClick" />
                                <kh>មាន</kh>
                            </label>
                            <label class="radio-inline radio-lg">
                                <input type="radio" name="HasVMW" value="0" data-bind="checked: HasVMW, click: $root.radioClick" />
                                <kh>មិនមាន</kh>
                            </label>
                        </td>
                        <td class="form-inline">
                            ចំនួនប្រជាជនសរុប៖
                            <input type="number" class="form-control width60" data-bind="value: Pop"  />
                        </td>
                        <td class="form-inline">
                            ចំនួនគ្រួសារ៖
                            <input type="number" class="form-control width60" data-bind="value: Family" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center">ចម្ងាយពី(គ.ម) (អាចស្រង់ពីប្រព័ន្ធ GPS)</td>
                    </tr>
                    <tr>
                        <td>ទីតាំង</td>
                        <td>ចម្ងាយ (Km)</td>
                        <td>ឈ្មោះ</td>
                        <td>Lat</td>
                        <td>Long</td>
                    </tr>
                    <tr>
                        <td>ផ្ទះអ្នកជំងឺទៅផ្ទះ VMW/MMW៖</td>
                        <td>
                            <input type="number" class="form-control " data-bind="value: Patient_To_VMW" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: VMWName" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: VMWLat" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: VMWLong" />
                        </td>
                    </tr>
                    <tr>
                        <td>ផ្ទះ VMW/MMW ទៅមណ្ឌលសុខភាព៖</td>
                        <td>
                            <input type="number" class="form-control " data-bind="value: VMW_To_HC" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: HCName" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: HCLat" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: HCLong" />
                        </td>
                    </tr>
                    <tr>
                        <td>មណ្ឌលសុខភាពទៅមន្ទីរពេទ្យបង្អែក៖</td>
                        <td>
                            <input type="number" class="form-control " data-bind="value: HC_To_RH" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: RHName" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: RHLat" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: RHLong" />
                        </td>
                    </tr>
                    <tr>
                        <td>ផ្ទះអ្នកជំងឺទៅព្រៃ/ឬទៅទីតាំងប្រឈមខ្ពស់៖</td>
                        <td>
                            <input type="number" class="form-control " data-bind="value: Patient_To_Forest" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: ForestName" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: ForestLat" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: ForestLong" />
                        </td>
                    </tr>
                    <tr>
                        <td>ផ្ទះអ្នកជំងឺទៅប្រភពទឹក(ទន្លេ/បឹង/អូរ)៖</td>
                        <td>
                            <input type="number" class="form-control " data-bind="value: Patient_To_WaterSource" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: WaterSourceName" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: WaterSourceLat" />
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: WaterSourceLong" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">ផែនទីគូរដោយដៃ គ្របដណ្តប់ទីតាំងក្នុងរង្វង់1Kmជុំវិញផ្ទះករណីគោល៖ (ឧទាហរណ៍ ផ្លូវ ទន្លេ អូរ)</td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <img data-bind="attr: { src: Photo }" />
                            <br />
                            <button class="btn btn-sm btn-primary" data-bind="click: $parent.selectFile">Choose Photo</button>
                            <span data-bind="validationMessage: Photo" class="message-error"></span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!--Part 5-->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th class="bg-info" colspan="2">ផ្នែកទី 5៖ ជំរឿនគ្រួសារ(ភូមិទាំងមូល)</th>
                </tr>
                <tr>
                    <td colspan="2">ព័ត៌មានទទួលបានពីការជំរឿនគ្រួសារ</td>
                </tr>
                <tr>
                    <td>សំនួរទី 8. ភាគរយនៃមនុស្សដែលដេកនៅក្នុងព្រៃ/កសិដ្ឋាន/ចំការ អ្នកចូលព្រៃ កាលពីខែមុន៖(ចំនួនអ្នកចូលព្រៃសរុប ចែកនឹងចំនួន​ប្រជាជនសរុប) x 100</td>
                    <td>
                        <input type="number" class="form-control " data-bind="value: ForestSleep"  />
                    </td>
                </tr>
                <tr>
                    <td>
                        សំនួរទី 9. ភាគរយនៃការគ្របដណ្តប់មុងគ្រែ LLIN នៅក្នុងភូមិដែលមានមនុស្សជាមធ្យម 1.8 នាក់ក្នុងមុងគ្រែមួយ?
                        <br />(ចំនួនគ្រួសារដែលមានមុងមួយក្នុងចំណោម1.8នាក់ ចែកនឹងចំនួនគ្រួសារសរុប) x 100
                    </td>
                    <td>
                        <input type="number" class="form-control " data-bind="value: LLINCoverage"  />
                    </td>
                </tr>
                <tr>
                    <td>សំនួរទី 10. ភាគរយនៃការគ្របដណ្តប់ LLIHN នៅក្នុងភូមិដែលមានមនុស្សជាមធ្យម 1 នាក់ក្នុងមុងអង្រឹងមួយ?</td>
                    <td>
                        <input type="number" class="form-control " data-bind="value: LLIHNCoverage"  />
                    </td>
                </tr>
                <tr>
                    <td>សំនួរទី 11. ភាគរយនៃប្រជាជនចំណាកស្រុក/ចល័ត (MMP) នៅក្នុងភូមិ?</td>
                    <td>
                        <input type="number" class="form-control " data-bind="value: MMP"  />
                    </td>
                </tr>
                <!--part 6-->
                <tr>
                    <td class="bg-info" colspan="2">ផ្នែកទី 6: ភ្នាក់ងារចម្លង</td>
                </tr>
                <tr>
                    <td colspan="2">ព័ត៌មានពីការចាប់មូសពេលយប់ (Receptivity)</td>
                </tr>
                <tr>
                    <td colspan="2">
                        សំនួរទី 12. តើមានភ្នាក់ងារចំបងចាប់បានឬទេ?
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="PrimaryVector" value="0" data-bind="checked: PrimaryVector, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="PrimaryVector" value="1" data-bind="checked: PrimaryVector, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <br />

                        <div class="form-group">
                            ប្រភេទ៖
                            <input type="checkbox" class="checkbox-lg" name="Dirus" value="Dirus" data-bind="checked: PrimaryVectorType" />
                            <label>Dirus</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Minimus" value="Minimus" data-bind="checked: PrimaryVectorType" />
                            <label>Minimus</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Maculatus" value="Maculatus" data-bind="checked: PrimaryVectorType" />
                            <label>Maculatus</label>
                            &nbsp;&nbsp;
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        សំនួរទី 13. តើមានភ្នាក់ងារផ្សេងទៀតចាប់បានឬទេ?
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OtherVector" value="1" data-bind="checked: OtherVector, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OtherVector" value="0" data-bind="checked: OtherVector, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                    </td>
                </tr>
            </table>

            <!--part 7-->
            <table class="table table-bordered kh">
                <thead>
                    <tr class="form-inline relative">
                        <th class="bg-info" colspan="4">ផ្នែកទី 7៖ អន្តរាគមន៍ឆ្លើយតបនឹងសំបុកចម្លង</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td align="center">អន្តរាគមន៍ឆ្លើយតបសំបុកចម្លង</td>
                        <td align="center">លទ្ធផលនៃការអង្កេតសំបុកចម្លង</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: NoIntervention" />
                        </td>
                        <td>សំណួរទី 1</td>
                        <td>គ្មានអន្តរាគមន៍ឆ្លើយតបសំបុកចម្លង</td>
                        <td>បាទ/ចាស៎</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: QALess90" />
                        </td>
                        <td>សំណួរទី 2</td>
                        <td>ការធានាគុណភាពនៃ HC/MMW/VMW</td>
                        <td>&lt; 90%</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: QALess10" />
                        </td>
                        <td>សំណួរទី 3</td>
                        <td>ការធានាគុណភាពនៃ HC/MMW/VMW</td>
                        <td>&lt; 10%</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: QALess80" />
                        </td>
                        <td>សំណួរទី 4</td>
                        <td>ការធានាគុណភាពនៃ HC/MMW/VMW</td>
                        <td>ទេ ឬ ពិន្ទុជាមធ្យម &lt; 80%</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: MoreLLIN_LLIHN" />
                        </td>
                        <td>សំណួរទី 5</td>
                        <td>បន្ថែម LLINs & LLIHNs</td>
                        <td>ទេ</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: MoreRDT_ACT" />
                        </td>
                        <td>សំណួរទី 6</td>
                        <td>ការបំពេញបន្ថែម RDTs និង ACTS សម្រាប់ HC/MMW/VMW</td>
                        <td>ទេ</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: MoreVMW" />
                        </td>
                        <td>សំណួរទី 7</td>
                        <td>បន្ថែមកន្លែងផ្តល់សេវា (VMW/MMW)</td>
                        <td>ទេ</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: IPTf" />
                        </td>
                        <td>សំណួរទី 8</td>
                        <td>ការលេបថ្នាំការពារជាមុនសម្រាប់អ្នកចូលព្រៃ (IPTf)</td>
                        <td>&gt; 0%</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: IEC_BCC" />
                        </td>
                        <td>សំណួរទី 8</td>
                        <td>IEC/BCC លើការប្រើប្រាស់ LLIHN</td>
                        <td>&gt; 0%</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: MoreLLIHN_IEC" />
                        </td>
                        <td>សំណួរទី 9</td>
                        <td>បំពេញបន្ថែម LLINs ជាមួយ IEC/BCC លើការប្រើប្រាស់ LLINs</td>
                        <td>&lt; 100%</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: MoreLLIN_IEC" />
                        </td>
                        <td>សំណួរទី 10</td>
                        <td>បំពេញបន្ថែម LLIHNs ជាមួយ IEC/BCC លើការប្រើប្រាស់ LLIHNs</td>
                        <td>&lt; 100%</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: CE" />
                        </td>
                        <td>សំណួរទី 11</td>
                        <td>ការចូលរួមសហគមន៍(ចុះតាមផ្ទះមួយទៅផ្ទះមួយនៅពេលបំពេញបន្ថែមមុង)</td>
                        <td>បាទ/ចាស៎</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: PfMix" />
                        </td>
                        <td>លទ្ធផលតេស្ត</td>
                        <td class="text-center" rowspan="2">ការផ្តល់ថ្នាំដល់ក្រុមគោលដៅ (TDA)</td>
                        <td>ករណី Pf ឬ ចម្រុះ</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: TDA" />
                        </td>
                        <td>សំណួរទី 12</td>
                        
                        <td>បាទ</td>
                    </tr>
                    <tr>
                        <td>ចំណាំ</td>
                        <td colspan="3"><input class="form-control" type="text" data-bind="value: Note"/></td>
                    </tr>
                </tbody>
            </table>

            <br />
            <table class="table table-bordered kh">
                <thead>
                    <tr class="form-inline relative">
                        <th class="bg-info" colspan="4">ផ្នែកទី 8៖ អន្តរាគមន៍ឆ្លើយតបនឹងសំបុកចម្លង</th>
                    </tr>
                    <tr>
                        <th>ល.រ</th>
                        <th>សកម្មភាពអន្តរាគមន៍ឆ្លើយតបនឹងសំបុកចម្លង</th>
                        <th>កាលបរិច្ឆេទចាប់ផ្តើម</th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                       <td>1</td>   
                       <td>ការធានាគុណភាពនៃ HC/MMW/VMW</td>   
                       <td class="relative">
                           <input type="text" data-bind="datePicker: QADate" />
                       </td>   
                   </tr> 
                    <tr>
                       <td>2</td>   
                       <td>បន្ថែម LLINs & LLIHNs</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: LLINDate" />
                        </td>   
                   </tr> 
                    <tr>
                       <td>3</td>   
                       <td>ការបំពេញបន្ថែម RDTs និង ACTs សម្រាប់ HC/MMW/VMW</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: RDT_ACTDate" />
                        </td>   
                   </tr> 
                    <tr>
                       <td>4</td>   
                       <td>បន្ថែមកន្លែងផ្តល់សេវា (VMW/MMW)</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: VMWDate" />
                        </td>   
                   </tr> 
                    <tr>
                       <td>5</td>   
                       <td>ការលេបថ្នាំការពារជាមុនសម្រាប់អ្នកចូលព្រៃ (IPTf)</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: IptfDate" />
                        </td>   
                   </tr> 
                    <tr>
                       <td>6</td>   
                       <td>IEC/BCC លើការប្រើប្រាស់ LLIHN</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: IecDate" />
                        </td>   
                   </tr> 
                    <tr>
                       <td>7</td>   
                       <td>ការបំពេញបន្ថែម LLINs ជាមួយ IEC/BCC លើការប្រើប្រាស់ LLINs</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: LLIN_IecDate" />
                        </td>   
                   </tr> 
                    <tr>
                       <td>8</td>   
                       <td>ការបំពេញបន្ថែម LLIHNs ជាមួយ IEC/BCC លើការប្រើប្រាស់ LLIHNs</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: LLIHN_IecDate" />
                        </td>   
                   </tr> 
                    <tr>
                       <td>9</td>   
                       <td>ការចូលរួមសហគមន៍(ចុះតាមផ្ទះមួយទៅផ្ទះមួយនៅពេលបំពេញបន្ថែមមុង)</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: CeDate" />
                        </td>   
                   </tr> 
                    <tr>
                       <td>10</td>   
                       <td>ការផ្តល់ថ្នាំដល់ក្រុមគោលដៅ (TDA)</td>   
                        <td class="relative">
                            <input type="text" data-bind="datePicker: DtaDate" />
                        </td>   
                   </tr> 

                </tbody>
            </table>

        </div>
				
	</div>
	<div class="panel-footer text-center">
        <button class="btn btn-primary btn-sm width150" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('Foci Edit')">Save</button>
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
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: isOther" />
                                <kh>Address</kh>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th width="100" align="right" valign="middle">ខេត្ត</th>
                        <td class="form-group">
                            <select class="form-control input-sm" data-bind="enable: isOther() == 0, value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" valign="middle">ស្រុក</th>
                        <td class="form-group">
                            <select class="form-control input-sm" data-bind="enable: isOther() == 0,value: ds, options: dsList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" valign="middle">ឃុំ</th>
                        <td class="form-group">
                            <select class="form-control input-sm" data-bind="enable: isOther() == 0,value: cm, options: cmList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" valign="middle">ភូមិ</th>
                        <td class="form-group">
                            <select class="form-control input-sm" data-bind="enable: isOther() == 0,value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
                        </td>
                    </tr>
                </table>
                <hr />

                <table class="table" data-bind="with: inputPlaceModel">
                    <tr>
                        <th width="100" align="right" valign="middle">
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: isOther" />
                                <kh>Other</kh>
                            </label>
                        </th>
                        <td class="form-group">
                            <input type="text" class="form-control input-sm" data-bind="enable: isOther() == 1, value: other" />
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

<input type="file" id="file" class="hide" data-bind="change: () => fileChanged($element.files)" accept="image/*" />

<div class="modal" id="modalTransfer" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-size" role="document">
        <div class="modal-content " data-bind="with: caseTransfer">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">ផ្តល់សិទ្ធទៅឲ្យODផ្សេង</h4>
            </div>
            <div class="modal-body " >
                <div class="inlineblock">
                    <div class="text-bold">Province</div>
                    <select data-bind="value: pv,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: pvList().length == 1 ? undefined : 'All Province'"
                        class="form-control minwidth150"></select>
                </div>
                <div class="inlineblock">
                    <div class="text-bold">OD</div>
                    <select data-bind="value: od,
						options: odList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: odList().length == 1 ? undefined : 'All OD'"
                        class="form-control minwidth150"></select>
                </div>
                <!--<div class="inlineblock">
                    <div class="text-bold">HC</div>
                    <select data-bind="value: ToHC,
						options: hcList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All HC'"
                        class="form-control minwidth150"></select>
                </div>-->
                <br />
                <div class="inlineblock">
                    <div class="text-bold">Note</div>
                    <input type="text" class="form-control" data-bind="value: Note" />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary width100" data-bind="click: $root.transfer" style="float: left">Save</button>
                <button class="btn btn-default width100" data-bind="click: $root.closeTransfer" style="float: left">Close</button>
            </div>
        </div>
	</div>
</div>

<!-- Modal Note -->
<div class="modal" id="modalNote" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 1400px">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Note</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" data-bind="with: noteModel">
                    <tr>
                        <th>Patient Name</th>
                        <th>Patient Code</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Date Case</th>
                    </tr>
                    <tr>
                        <td data-bind="text: PatientName"></td>
                        <td data-bind="text: PatientCode"></td>
                        <td data-bind="text: Age"></td>
                        <td data-bind="text: Sex"></td>
                        <td data-bind="text: DateCase"></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-group" style="border: 1px solid #ccc">
                                <span class="input-group-addon" style="border: none">មិនបានធ្វើ</span> &nbsp;&nbsp;
                                <input type="checkbox" class="checkbox-lg" name="Active_1" value="1" data-bind="checked: NotDo" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group" data-bind="if: NotDo() == 1">
                                <span class="input-group-addon">ហេតុផលមិនបានធ្វើ</span>
                                <select class="form-control" data-bind="value: ReasonNotDo" >
                                    <option></option>
                                    <option>Not Eligible</option>
                                    <option>Already Conducted Foci</option>
                                    <option>In Forest</option>
                                    <option>Not Year Apply New Surveillance</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group" data-bind="if: NotDo() == 1">
                                <span class="input-group-addon">ហេតុផលផ្សេងៗ</span>
                                <input type="text" class="form-control" data-bind="value: OtherReasonNotDo" />
                            </div>
                        </td>
                       
                    </tr>
                    <tr>
                         <td>
                            <div class="input-group">
                                <span class="input-group-addon">ដោយ (ឈ្មោះ)</span>
                                <input type="text" class="form-control" data-bind="value: DeclaredNotDoBy" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group" style="border: 1px solid #ccc">
                                <span class="input-group-addon" style="border: none">Completed</span> &nbsp;&nbsp;
                                <input type="checkbox" class="checkbox-lg" name="Active_1" value="1" data-bind="checked: Completed" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">សម្គាល់</span>
                                <input type="text" class="form-control" data-bind="value: Note" />
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button class="pull-left btn btn-primary btn-sm width100" data-bind="click: saveNote">Save Note</button>
                <button class="pull-left btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<?=latestJs('/media/ViewModel/MRRT_Foci.js')?>