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
    .dis {
        pointer-events:none;
        opacity:0.5
    }
    .gold {
        background: gold;
    }
    .cyan {
        background: cyan;
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
                <button class="btn btn-primary" data-bind="click: getData">View</button>
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
                    <th width="10">#</th>
                    <th width="20">Province</th>
                    <th width="20">OD</th>
                    <th width="250">HC</th>
                    <th>Patient Code</th>
                    <th>Patient Name</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Diagnosis</th>
                    <th>Date case</th>
                    <th>Year</th>
                    <th sortable>Month</th>
                    <th>Case From</th>
                    <th width="10">Classify</th>
                    <th sortable width="10">Has Data</th>
                    <th>Action</th>
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
                    <td data-bind="sortValue: CICC_ID() ? 1:2" class="text-center">
                        <i data-bind="visible: CICC_ID" class="fa fa-check-square-o"></i>
                    </td>
                    <td><a class="btn btn-sm btn-primary" data-bind="click: $root.viewDetail">Detail</a></td>
                    <td><a class="btn btn-sm btn-success" data-bind="visible: app.user.permiss['MRRT2'].contain('CICC Note'), click: $root.createNote">Note</a></td>
                     <td>
                         <span data-bind="visible: NotDo" class="text-danger fa fa-times"></span>
                         <span data-bind="text: ReasonNotDo"></span>
                    </td> 
                    <td><span data-bind="visible: ToOD != undefined">ផ្តល់សិទ្ទទៅ OD</span> <span data-bind="text: $root.getODName(ToOD)" class="badge"></span></td>
                </tr>

            </tbody>
        </table>
     </div>
</div>

<!--Form-->

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 text-bold lh26">MRRT CICC</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('CICC Edit')">Save</button>
			<!--ko if: isDelete-->
			<button class="btn btn-danger btn-sm width100" data-bind="click: showDelete, visible: app.user.permiss['MRRT2'].contain('CICC Delete')">Delete</button>
            <!-- /ko -->
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back">Back</button>
		</div>
	</div>
	<div class="panel-body displayTable" style="min-width: 900px; margin: auto">
		<h3 class="kh text-center text-bold">ទម្រង់ការអង្កេតករណីឡើងវិញ និងការចាត់ថ្នាក់ជំងឺគ្រុនចាញ់ <br />(ដោយក្រុមMRRT)</h3>
        <h5 class="kh text-center text-bold">សូមស្រង់ទិន្នន័យអង្កេតករណីដោយPOCចេញពីប្រព័ន្ធ MIS</h5>
		<br />
		<br />
		
        <div data-bind="with: detailModel">
            <table class="table table-bordered kh">
                <!-- Part 1 -->
                <tr class="form-inline relative">
                    <th class="bg-info" colspan="2">ផ្នែកទី 1៖ ព័ត៌មានអ្នកជំងឺ</th>
                    <th class="bg-info">
                        លេខកូដអ្នកជំងឺ៖
                        <input type="text" class="form-control" data-bind="value: PatientCode" />
                    </th>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">1.1 ថ្ងៃខែឆ្នាំធ្វើរោគវិនិច្ឆ័យ៖ <span data-bind="text: $root.dateFormat(DateCase())"></span></td>
                    <td>
                        1.2 ថ្ងៃខែឆ្នាំការអង្កេត៖
                        <input type="date" class="form-control width150 text-center" data-bind="value: InvDate" placeholder="DD-MM-YYYY" />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">
                        1.3 ឈ្មោះ៖
                        <input type="text" class="form-control" data-bind="value: PatientName" />
                    </td>
                    <td>1.4 លេខទូរស័ព្ទ៖ <input type="number" class="form-control" data-bind="value: PatientPhone" /></td>
                </tr>
                
                <tr class="form-inline relative">
                    <td>
                        1.5 អាយុ៖
                        <input type="number" class="form-control" data-bind="value: Age"  />
                    </td>
                    <td>
                        1.6 ភេទ
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Sex" value="M" data-bind="checked: Sex" />
                            <kh>ប្រុស</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Sex" value="F" data-bind="checked: Sex" />
                            <kh>ស្រី</kh>
                        </label>
                        <span data-bind="validationMessage: Sex" class="message-error"></span>
                    </td>
                    <td>
                        1.7 ទម្ងន់៖
                        <input type="number" class="form-control" data-bind="value: Weight"  />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    
                    <td colspan="3">1.8 អាស័យដ្ឋានកំពុងស្នាក់នៅ៖ 
                    <span style="color:red" data-bind="text: $root.getVill(Address())"></span>
                    <input type="hidden" param="address" class="form-control" data-bind="value: Address" />
                    <span data-bind="validationMessage: Address" class="message-error"></span>
                    <button param="address" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="3">1.9 អាស័យដ្ឋានអចិន្ត្រៃយ៍៖ 
                        <span style="color:red" data-bind="text: $root.getVill(PermanentAddress())"></span>
                        <input type="hidden"  class="form-control" data-bind="value: PermanentAddress" />
                        <span data-bind="validationMessage: PermanentAddress" class="message-error"></span>
                        <button param="peraddress" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>1.10 តើក្នុងភូមិមាន VMW/MMW ទេ?៖ 
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="HasVMW" value="1" data-bind="checked: HasVMW" />
                            <kh>មាន</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="HasVMW" value="0" data-bind="checked: HasVMW" />
                            <kh>មិនមាន</kh>
                        </label>
                    </td>
                    <td>Lat <input type="text" class="form-control" data-bind="value: Lat" /></td>
                    <td>Long <input type="text" class="form-control" data-bind="value: Long" /></td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="3">1.11 មុខរបរ៖ 
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Occupation" value="Agricultural Worker" data-bind="checked: Occupation" />
                            <kh>កម្មករកសិកម្ម</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Occupation" value="Foresting" data-bind="checked: Occupation" />
                            <kh>រកអនុផលព្រៃឈើ</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Occupation" value="Farmer" data-bind="checked: Occupation" />
                            <kh>កសិករ</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Occupation" value="Miner" data-bind="checked: Occupation" />
                            <kh>កម្មកររ៉ែ</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Occupation" value="Construction Worker" data-bind="checked: Occupation" />
                            <kh>កម្មករសំណង់</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Occupation" value="Traveler" data-bind="checked: Occupation" />
                            <kh>អ្នកធ្វើដំណើរ</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Occupation" value="Solider" data-bind="checked: Occupation" />
                            <kh>ទាហាន</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Occupation" value="Other" data-bind="checked: Occupation" />
                            <kh>ផ្សេងៗ</kh>
                        </label>
                        <input type="text" class="form-control width150" data-bind="value: OtherOccupation" />
                    </td>
                </tr>

                <!-- Part 2 -->
                <tr class="form-inline relative">
                    <th class="bg-info" colspan="3">ផ្នែកទី 2៖ ការអង្កេតករណីជំងឺគ្រុនចាញ់</th>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">2.1 ថ្ងៃខែឆ្នាំចុះអង្កេតករណីជំងឺគ្រុនចាញ់បញ្ចាក់ឡើងវិញដោយក្រុម MRRT៖</td>
                    <td>
                        <input type="date" class="form-control width150 text-center" data-bind="value: ConfirmDate" placeholder="DD-MM-YYYY" />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">2.2 តើអ្នកជំងឺបានទៅព្យាបាលនៅឯកជនមុនមកទទួលការព្យាបាលនៅ VMW/HC ដែរឬទេ?៖</td>
                    <td>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverPPMCure" value="1" data-bind="checked: EverPPMCure, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverPPMCure" value="0" data-bind="checked: EverPPMCure, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">2.3 តើមានបុគ្គលិកមូលដ្ឋានសុខាភិបាលបានសួរ ឬហៅអ្នកឲ្យទៅធ្វើតេស្តជំងឺគ្រុនចាញ់ដែរឬទេ?៖</td>
                    <td>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="HCTest" value="1" data-bind="checked: HCTest, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="HCTest" value="0" data-bind="checked: HCTest, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">2.4 វិធីសាស្រ្តរកឃើញករណី៖</td>
                    <td>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DetectionMethod" value="PCD" data-bind="checked: DetectionMethod, click: $root.radioClick" />
                            <kh>ការស្វែងរកករណីបែបអកម្ម (PCD)</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DetectionMethod" value="RACDT" data-bind="checked: DetectionMethod, click: $root.radioClick" />
                            <kh>ការស្រាវជ្រាវរកជំងឺគ្រុនចាញ់ និងការព្យាបាលជុំវិញករណីគោល (RACDT) </kh>
                        </label>
                        <br /><br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DetectionMethod" value="PACD" data-bind="checked: DetectionMethod, click: $root.radioClick" />
                            <kh>ការស្វែងរកករណីបែបសកម្ម (PACD) </kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DetectionMethod" value="Other" data-bind="checked: DetectionMethod, click: $root.radioClick" />
                            <kh>ផ្សេងទៀត </kh>
                        </label>
                        <input type="text" class="form-control width150" data-bind="value: OtherDetectionMethod" />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">2.5 វិធីសាស្រ្តធ្វើរោគវិនិច្ឆ័យ (បញ្ជាក់ឡើងវិញដោយMRRT)៖</td>
                    <td>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DiagnosticMethod" value="RDT" data-bind="checked: DiagnosticMethod, click: $root.radioClick" />
                            <kh>តេស្តរហ័ស</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DiagnosticMethod" value="Microscopy" data-bind="checked: DiagnosticMethod, click: $root.radioClick" />
                            <kh>មីក្រូទស្សន៍ </kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="DiagnosticMethod" value="PCR" data-bind="checked: DiagnosticMethod, click: $root.radioClick" />
                            <kh>PCR</kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">2.6 លទ្ធផលតេស្ត៖</td>
                    <td>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="F" data-bind="checked: Diagnosis, click: $root.radioClick" />
                            <kh>Pf</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="V" data-bind="checked: Diagnosis, click: $root.radioClick" />
                            <kh>Pv</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="M" data-bind="checked: Diagnosis, click: $root.radioClick" />
                            <kh>Mix</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="A" data-bind="checked: Diagnosis, click: $root.radioClick" />
                            <kh>Pm</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="K" data-bind="checked: Diagnosis, click: $root.radioClick" />
                            <kh>Pk</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="O" data-bind="checked: Diagnosis, click: $root.radioClick" />
                            <kh>Po</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Diagnosis" value="Other" data-bind="checked: Diagnosis, click: $root.radioClick" />
                            <kh>ផ្សេងទៀត</kh>
                        </label>
                        <input type="text" class="form-control width150" data-bind="value: OtherDiagnosis" />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>2.7 ការព្យាបាល៖</td>
                    <td>
                        <div class="form-group">
                            <input type="checkbox" class="checkbox-lg" name="ASMQ" value="ASMQ" data-bind="checked: Treatment" />
                            <label>ASMQ</label>
                            <br /> <br />                            <input type="checkbox" class="checkbox-lg" name="ASMQ + SLDP" value="ASMQ + SLDP" data-bind="checked: Treatment" />
                            <label>ASMQ + SLDP</label>
                            <br /> <br />
                            <input type="checkbox" class="checkbox-lg" name="PV Radical Cure" value="PV Radical Cure" data-bind="checked: Treatment" />
                            <label>ការព្យាបាលផ្តាច់វីវ៉ាក់</label>
                            <br /> <br />
                            <input type="checkbox" class="checkbox-lg" name="Other" value="Other" data-bind="checked: Treatment" />
                            <label>ផ្សេងទៀត</label>
                            &nbsp;&nbsp;
                            <input type="text" class="form-control width150" data-bind="value: OtherTreatment" />
                        </div>
                    </td>
                    <td>
                        កម្រិតថ្នាំ ACT
                        <input type="number" class="form-control text-center width60" data-bind="value: Dosage"   /> mg /
                        <input type="number" class="form-control text-center width60" data-bind="value: Dosage2"   /> mg
                        <br /> <br />
                        ចំនួនថ្នាំគ្រាប់៖ <input type="number" class="form-control text-center width60" data-bind="value: DosePerDay"  /> កញ្ចប់​ ឬ គ្រាប់/ថ្ងៃ 
                        រយៈពេល <input type="number" class="form-control text-center width60" data-bind="value: TreatmentDay"  /> ថ្ងៃ
                        <br /> <br />
                        កម្រិតថ្នាំ PQ
                        <input type="number" class="form-control text-center width60" data-bind="value: PQDosage"   /> mg
                        <br /> <br />
                        ចំនួនថ្នាំគ្រាប់៖ <input type="number" class="form-control text-center width60" data-bind="value: PQDosePerDay"  /> កញ្ចប់​ ឬ គ្រាប់/ថ្ងៃ 
                        រយៈពេល <input type="number" class="form-control text-center width60" data-bind="value: PQDuration"  /> 
                        <select class="form-control" data-bind="value: PQDurationType">
							<option value="Day"><kh>ថ្ងៃ</kh></option>
							<option value="Week"><kh>សប្តាហ៍</kh></option>
						</select>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>2.8 លទ្ធផលនៃការធ្វើតេស្ត G6PD (P.Vivax/Mix/P.Ovalae) (សម្រាប់ HC):</td>
                    <td>G6PD (U/g Hb):
                        <input type="number" class="form-control width150 text-center" data-bind="value: G6PDHb"  />
                    </td>
                    <td>Hb(g/dL):
                        <input type="number" class="form-control width150 text-center" data-bind="value: G6PDdL"  />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="3">2.9 ថ្ងៃខែឆ្នាំនៃការចាប់ផ្តើមរោគសញ្ញាដំបូង៖  <input type="date" class="form-control width150 text-center" data-bind="value: SymptomDate" /></td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="3">2.10 រោគសញ្ញា៖
                        <div class="form-group">
                            <input type="checkbox" class="checkbox-lg" name="Fever" value="Fever" data-bind="checked: Symptom" />
                            <label>ក្តៅខ្លួន</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Chills" value="Chills" data-bind="checked: Symptom" />
                            <label>ញាក់</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Headache" value="Headache" data-bind="checked: Symptom" />
                            <label>ឈឺក្បាល</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Vomit" value="Vomit" data-bind="checked: Symptom" />
                            <label>ក្អួត</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Diarrhea" value="Diarrhea" data-bind="checked: Symptom" />
                            <label>រាគ</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Cough" value="Cough" data-bind="checked: Symptom" />
                            <label>ក្អក</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Sweat" value="Sweat" data-bind="checked: Symptom" />
                            <label>បែកញើស</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Nausea" value="Nausea" data-bind="checked: Symptom" />
                            <label>ចង្អោរ</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="No Symptoms" value="No Symptoms" data-bind="checked: Symptom" />
                            <label>គ្មានរោគសញ្ញា</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Other" value="Other" data-bind="checked: Symptom" />
                            <label>រោគសញ្ញាផ្សេងទៀត៖</label>
                            &nbsp;&nbsp;
                            <input type="text" class="form-control width150" data-bind="value: OtherSymptom" />
                        </div>
                    </td>
                </tr>

                <!--Part 3-->
                <tr class="form-inline relative">
                    <th class="bg-info" colspan="3">ផ្នែកទី៣៖ ការចាត់ថ្នាក់ករណីជំងឺគ្រុនចាញ់</th>
                </tr>
                <tr class="form-inline relative">
                    <th class="bg-info text-danger" colspan="3">ប្រវត្តិជំងឺគ្រុនចាញ់ និងការព្យាបាល</th>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="2">3.1 តើអ្នកធ្លាប់កើតជំងឺគ្រុនចាញ់ដែរ ឬទេ?</td>
                    <td>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverHadMalaria" value="1" data-bind="checked: EverHadMalaria, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ > បន្តទៅសំណួរទី 3.2 </kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverHadMalaria" value="0" data-bind="checked: EverHadMalaria, click: $root.radioClick" />
                            <kh>ទេ > ទៅកាន់សំណួរទី 3.7</kh>
                        </label>
                    </td>
                </tr>
                
                <tr class="form-inline relative" data-bind="css: EverHadMalaria() == 0? 'dis' : ''">
                    <td colspan="2">3.2 តើជំងឺគ្រុនចាញ់ប្រភេទអ្វីដែលអ្នកបានកើត?</td>
                    <td>
                        
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OldDiagnosis" value="F" data-bind="checked: OldDiagnosis, click: $root.radioClick" />
                            <kh>Pf</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OldDiagnosis" value="V" data-bind="checked: OldDiagnosis, click: $root.radioClick" />
                            <kh>Pv</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OldDiagnosis" value="M" data-bind="checked: OldDiagnosis, click: $root.radioClick" />
                            <kh>Mix</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OldDiagnosis" value="A" data-bind="checked: OldDiagnosis, click: $root.radioClick" />
                            <kh>Pm</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OldDiagnosis" value="K" data-bind="checked: OldDiagnosis, click: $root.radioClick" />
                            <kh>Pk</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OldDiagnosis" value="O" data-bind="checked: OldDiagnosis, click: $root.radioClick" />
                            <kh>Po</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="OldDiagnosis" value="unknown" data-bind="checked: OldDiagnosis, click: $root.radioClick" />
                            <kh>មិនដឹង</kh>
                        </label>
                        
                    </td>
                </tr>
                <tr class="form-inline relative" data-bind="css: EverHadMalaria() == 0? 'dis' : ''">
                    <td colspan="2">3.3 តើជំងឺគ្រុនចាញ់ដែលអ្នកកើតពេលនេះ ដូចគ្នានឹងជំងឺគ្រុនចាញ់ដែលអ្នកបានកើតកាលពីលើកមុនដែរ ឬទេ?</td>
                    <td>
                        
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="SameDiagnosis" value="1" data-bind="checked: SameDiagnosis, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ > បន្តទៅសំណួរទី 3.4    </kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="SameDiagnosis" value="0" data-bind="checked: SameDiagnosis, click: $root.radioClick" />
                            <kh>ទេ > ទៅកាន់សំណួរទី 3.7</kh>
                        </label>
                        
                    </td>
                </tr>
                
            </table>

            <table class="table table-bordered kh" data-bind="css: EverHadMalaria() == 0 || SameDiagnosis() == 0? 'dis' : ''">
                <tr class="form-inline relative">
                    <td class="cyan" colspan="2" style="font-weight: bold">ក្នុងករណីគ្រុនចាញ់ Pf / Pf + Pv / Pm / Pk </td>
                    <td class="gold" colspan="2" style="font-weight: bold">ករណីជំងឺគ្រុនចាញ់ Pv / Po</td>
                </tr>
                <tr class="form-inline relative">
                    <td class="cyan">3.4 តើអ្នកធ្លាប់មានជំងឺគ្រុនចាញ់នៃប្រភេទដូចគ្នាក្នុងរយៈពេល42ថ្ងៃចុងក្រោយនេះដែរ ឬទេ? </td>
                    <td class="cyan">
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverHadfakv" value="1" data-bind="checked: EverHadfakv, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverHadfakv" value="0" data-bind="checked: EverHadfakv, click: $root.radioClick" />
                            <kh>ទេ/មិនចាំ</kh>
                        </label>
                        
                    </td>
                    <td class="gold">3.4 តើអ្នកធ្លាប់មានជំងឺគ្រុនចាញ់នៃប្រភេទដូចគ្នានេះដែរ ឬទេ ក្នុងរយៈពេល ៣ខែចុងក្រោយ? </td>
                    <td class="gold">
                        
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverHadvo" value="1" data-bind="checked: EverHadvo, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ </kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverHadvo" value="0" data-bind="checked: EverHadvo, click: $root.radioClick" />
                            <kh>ទេ/មិនចាំ</kh>
                        </label>
                        
                    </td>
                </tr>

                <tr class="form-inline relative">
                    <td class="cyan">3.5 តើ​ថ្នាំ​មួយ​ណា​ដែល​អ្នក​បាន​ប្រើ​សម្រាប់​ព្យាបាល​ជំងឺ      គ្រុនចាញ់ ហើយ​អ្នក​បាន​លេប​ថ្នាំ​នោះរយៈពេល​ប៉ុន្មាន​ថ្ងៃ?</td>
                    <td class="cyan">
                        
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverTreatfakv" value="1" data-bind="checked: EverTreatfakv, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverTreatfakv" value="0" data-bind="checked: EverTreatfakv, click: $root.radioClick" />
                            <kh>ទេ/មិនចាំ</kh>
                        </label>
                        
                    </td>
                    <td class="gold">3.5 តើ​ថ្នាំ​មួយ​ណា​ដែល​អ្នក​បាន​ប្រើ​សម្រាប់​ព្យាបាល​ជំងឺគ្រុនចាញ់ ហើយ​អ្នក​បាន​លេប​ថ្នាំ​នោះរយៈពេល​ប៉ុន្មាន​ថ្ងៃ?</td>
                    <td class="gold">
                        
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverTreatvo" value="1" data-bind="checked: EverTreatvo, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ </kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="EverTreatvo" value="0" data-bind="checked: EverTreatvo, click: $root.radioClick" />
                            <kh>ទេ/មិនចាំ</kh>
                        </label>
                        
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td class="cyan" colspan="2">
                        
                        ប្រសិនបើ បាទ/ចាស៎  សូមបញ្ជាក់៖ &nbsp;&nbsp; ASMQ
                        <input type="number" class="form-control width60" data-bind="value: ASMQfakvDay"  /> ថ្ងៃ &nbsp;&nbsp;
                                ASMQ+SLDP
                        <input type="number" class="form-control width60" data-bind="value: ASMQSLDPfakvDay"  /> ថ្ងៃ &nbsp;&nbsp;
                        <br />
                        <br />
                                
                        <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: RadicalCure7Dayfakv"  />  ការព្យាបាលផ្តាច់វីវ៉ាក់07ថ្ងៃ &nbsp;&nbsp;
                        <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: RadicalCure8Weekfakv"  />   ការព្យាបាលផ្តាច់វីវ៉ាក់០៨សប្តាហ៍ &nbsp;&nbsp;
                        ផ្សេងទៀត៖ <input type="text" class="form-control width60" data-bind="value: FAKVOther"  />
                        
                    </td>

                    <td class="gold" colspan="2">
                        
                        ប្រសិនបើ បាទ/ចាស៎  សូមបញ្ជាក់៖ &nbsp;&nbsp; ASMQ
                        <input type="number" class="form-control width60" data-bind="value: ASMQvoDay"  /> ថ្ងៃ &nbsp;&nbsp;
                                ASMQ+SLDP
                        
                        <input type="number" class="form-control width60" data-bind="value: ASMQSLDPvoDay"  /> ថ្ងៃ &nbsp;&nbsp;
                        <br />
                        <br />
                                
                        <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: RadicalCure7Dayvo"  />  ការព្យាបាលផ្តាច់វីវ៉ាក់07ថ្ងៃ  &nbsp;&nbsp;
                        <input type="checkbox" class="checkbox-lg" value="1" data-bind="checked: RadicalCure8Weekvo"  />   ការព្យាបាលផ្តាច់វីវ៉ាក់០៨សប្តាហ៍ &nbsp;&nbsp;
                                
                        ផ្សេងទៀត៖
                        <input type="text" class="form-control width60" data-bind="value: VOOther" />
                        
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td class="cyan">3.6 តើអ្នកបានបញ្ចប់ការព្យាបាលជំងឺគ្រុនចាញ់របស់អ្នកបានពេញលេញដែរ ឬទេ?</td>
                    <td class="cyan">
                        
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="FAKVCompleted" value="1" data-bind="checked: FAKVCompleted, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="FAKVCompleted" value="0" data-bind="checked: FAKVCompleted, click: $root.radioClick" />
                            <kh>ទេ/មិនចាំ</kh>
                        </label>
                        
                    </td>
                    <td class="gold">
                        3.6 តើអ្នកបានបញ្ចប់ការព្យាបាលជំងឺគ្រុនចាញ់របស់អ្នកបានពេញលេញដែរ ឬទេ ជាមួយនឹងថ្នាំ ACT
                        <br />និង 8-aminoquinoline (ឧ. primaquine, tafenoquine ។ល។ សម្រាប់រយៈពេល ១៤ថ្ងៃ ៧ថ្ងៃ ឬក៏ ៨សប្តាហ៍)?
                    </td>
                    <td class="gold">
                        
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="VOCompleted" value="1" data-bind="checked: VOCompleted, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ </kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="VOCompleted" value="0" data-bind="checked: VOCompleted, click: $root.radioClick" />
                            <kh>ទេ/មិនចាំ</kh>
                        </label>
                        
                    </td>
                </tr>
            </table>

            <table class="table table-bordered kh">
                <tr>
                    <td colspan="2">
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Q3Confirm"  value="0" data-bind="checked: Q3Confirm, click: $root.radioClick">
                            <kh> ប្រសិនបើសំណួរទី 3.4: បាទ/ចាស៎ (សំណួរទី 3.5 ឬ ទី 3.6: ទេ/មិនចាំ) </kh>
                        </label>
                    </td>
                    <td colspan="2">ជា ករណីលាប់/ករណីរើកើតឡើងវិញ > បន្តទៅកាន់ផ្នែកទី 4</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Q3Confirm" value="1" data-bind="checked: Q3Confirm, click: $root.radioClick">
                            <kh> ប្រសិនបើសំណួរទី 3.4: ទេ/មិនចាំ </kh>
                        </label>
                    </td>
                    <td colspan="2" rowspan="2">ជា ករណីឆ្លងថ្មី > បន្តទៅកាន់សំណួរទី 3.7</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Q3Confirm" value="2" data-bind="checked: Q3Confirm, click: $root.radioClick">
                            <kh>ប្រសិនបើសំណួរទី 3.4: បាទ/ចាស៎ (សំនួរទី 3.5 ឬ ទី 3.6: បាទ/ចាស៎) </kh>
                        </label>
                    </td>
                </tr>
            </table>

            <!--Induce-->
            <table class="table table-bordered kh" data-bind="css: EverHadMalaria() == 1 || Q3Confirm() == 0 ? 'dis' : ''">
                <tr class="form-inline relative">
                    <th class="bg-info">ការឆ្លងតាមឈាម</th>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        3.7 អ្នកជំងឺបានទទួលការបញ្ចូលឈាមក្នុងរយៈពេល 17 ថ្ងៃចុងក្រោយនេះដែរទេ គិតចាប់ពីពេលធ្វើតេស្ត? <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="BloodTransfusion" value="1" data-bind="checked: BloodTransfusion, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ (បញ្ជាក់ អ្នកបរិច្ចាគឈាមបានធ្វើតេស្តវិជ្ជមានសម្រាប់ជំងឺគ្រុនចាញ់? ☐ បាទ/ចាស បន្តទៅកាន់សំណួរទី 3.8 ☐ ទេ/មិនចាំ បន្តទៅកាន់សំណួរទី 3.9) </kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="BloodTransfusion" value="0" data-bind="checked: BloodTransfusion, click: $root.radioClick" />
                            <kh>ទេ បន្តទៅកាន់សំណួរទី 3.9 </kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative" data-bind="css: BloodTransfusion() == 0? 'dis' : ''">
                    <td>
                        3.8 តើអ្នកជំងឺធ្វើដំណើរទៅកាន់តំបន់មានហានិភ័យ ឬ តំបន់ដែរមានការរាតត្បាតជំងឺគ្រុនចាញ់ក្នុងកំឡុងពេលប្រហាក់ប្រហែលនៃការឆ្លង? <br />
                        (ប្រសិនបើអ្នកជំងឺបានធ្វើដំណើរទៅកន្លែងច្រើនជាង ៤ ក្នុងអំឡុងពេលដែលទំនងជាមានការឆ្លង សូមរាយឈ្មោះទីតាំង៤ ដែលទំនងបំផុតជាប្រភពនៃការឆ្លងមេរោគគ្រុនចាញ់)<br />
                        *រយៈពេល​នៃ​ការ​ឆ្លង​តាម​ប្រភេទ​ជំងឺគ្រុនចាញ់៖<br />
                        Pf, Pk, Mix – ពិនិត្យមើលកន្លែងដែលអ្នកជំងឺស្នាក់នៅអំឡុងពេល ៩-១៤ ថ្ងៃ មុនពេលរោគសញ្ញាគ្រុនចាញ់ចាប់ផ្តើម។<br />
                        Pv, Po - ពិនិត្យមើលកន្លែងដែលអ្នកជំងឺស្នាក់នៅអំឡុងពេល១២-១៧ ថ្ងៃ មុនពេលរោគសញ្ញាគ្រុនចាញ់ចាប់ផ្តើម។<br />
                        Pm - ពិនិត្យមើលកន្លែងដែលអ្នកជំងឺស្នាក់នៅអំឡុងពេល៣០-៣៥ ថ្ងៃ មុនពេលរោគសញ្ញាគ្រុនចាញ់ចាប់ផ្តើម។
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="GoRiskArea" value="1" data-bind="checked: GoRiskArea, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎៖ បន្តទៅកាន់សំណួរទី 3.9</kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="GoRiskArea" value="0" data-bind="checked: GoRiskArea, click: $root.radioClick" />
                            <kh>ទេ៖ ជា "ករណីឆ្លងតាមឈាម" ត្រូវព្យាបាល​អ្នកជំងឺ និងត្រូវបន្តតាមដានអ្នកបរិច្ចាគឈាមបន្តទៀត </kh>
                        </label>
                    </td>
                </tr>
            </table>

            <!--Travel history-->
            <table class="table table-bordered kh" data-bind="css: Q3Confirm() == 0? 'dis' : ''">
                <tr class="form-inline relative">
                    <th class="bg-info" colspan="9">ប្រវត្តិធ្វើដំណើរ</th>
                </tr>
                <tr>
                    <td colspan="9">
                        3.9 តើអ្នកជំងឺធ្លាប់ធ្វើដំណើរទៅកន្លែងណាក្នុងអំឡុងពេលដែលទំនងជាឆ្លងជំងឺគ្រុនចាញ់* សម្រាប់ប្រភេទជំងឺគ្រុនចាញ់ដែលពួកគេបានធ្វើតេស្តវិជ្ជមាន?<br />
                        (ប្រសិនបើអ្នកជំងឺបានធ្វើដំណើរទៅកន្លែងច្រើនជាង ៤ ក្នុងអំឡុងពេលដែលទំនងជាមានការឆ្លង សូមកត់ត្រាចំនួនទាំង ៤ ដែលទំនងបំផុតជាប្រភពនៃការឆ្លងជំងឺគ្រុនចាញ់)<br />
                        *រយៈពេល​នៃ​ការ​ឆ្លង​តាម​ប្រភេទ​ជំងឺគ្រុនចាញ់៖<br />
                        Pf, Pk, Mix – ពិនិត្យមើលកន្លែងដែលអ្នកជំងឺស្នាក់នៅអំឡុងពេល ៩-១៤ ថ្ងៃ មុនពេលរោគសញ្ញាគ្រុនចាញ់ចាប់ផ្តើម។<br />
                        Pv, Po - ពិនិត្យមើលកន្លែងដែលអ្នកជំងឺស្នាក់នៅអំឡុងពេល១២-១៧ ថ្ងៃ មុនពេលរោគសញ្ញាគ្រុនចាញ់ចាប់ផ្តើម។<br />
                        Pm - ពិនិត្យមើលកន្លែងដែលអ្នកជំងឺស្នាក់នៅអំឡុងពេល៣០-៣៥ ថ្ងៃ មុនពេលរោគសញ្ញាគ្រុនចាញ់ចាប់ផ្តើម។<br />
                    </td>
                </tr>
                <tr class="text-center text-bold">
                    <td>ល.រ</td>
                    <td>ថ្ងៃខែឆ្នាំធ្វើដំណើរ <br />  (ពីថ្ងៃណាដល់ថ្ងៃណា)</td>
                    <td>អាសយដ្ឋាន (ភូមិ/ឃុំ/ស្រុក/ខេត្ត) <br /> ឈ្មោះទីតាំងប្រឈមខ្ពស់</td>
                    <td>គោលបំណង</td>
                    <td>ចំនួន ថ្ងៃ</td>
                    <td>គេងយប់? <br /> [បាទ/ទេ]</td>
                    <td>ស្ថានភាពជំងឺគ្រុនចាញ់ <br /> នៅទីតាំង</td>
                    <td>សូមជ្រើសរើស <br /> ប្រភពនៃកាចម្លង</td>
                    <td>Action</td>
                </tr>
                <tbody data-bind="foreach: Travel">
                    <tr class="text-center">
                        <td data-bind="text: $index()+1"></td>
                        <td>
                            <input type="date" class="form-control " data-bind="value: DateFrom" />
                            <input type="date" class="form-control " data-bind="value: DateTo" />
                        </td>
                        <td>
                            <span style="color:red" data-bind="text: $root.getVill(AddressRisk())"></span>
                            <input type="hidden" class="form-control " param="addressrisk" data-bind="value: AddressRisk" />
                            <span data-bind="validationMessage: AddressRisk" class="message-error"></span>
                            <button param="addressrisk" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                        </td>
                        <td><input type="text" class="form-control " data-bind="value: Goal" /></td>
                        <td>
                            <input type="number" class="form-control " data-bind="value: Day"  />
                        </td>
                        <td>
                            <select class="form-control" data-bind="value: Sleep">
							    <option></option>
							    <option value="1"><kh>បាទ/ចាស៎</kh></option>
							    <option value="0"><kh>ទេ</kh></option>
						    </select>
                        </td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: MalariaStatus" />
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="Fever" value="1" data-bind="checked: InfectionSource" />
                        </td>
                        <td>
                            <i class="text-danger fa fa-trash fa-2x" data-bind="click: $root.removeArea"></i>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="9">
                            <button class="btn btn-success btn-sm" data-bind="click: $root.addArea">+ Add More</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9">
                            **កំណត់សម្គាល់៖
                            <input type="text" class="form-control" data-bind="value: TravelNote"/>
                            3.1០ ការកំណត់ទីតាំងទំនងជាប្រភពនៃការចម្លង គួរត្រូវធ្វើឡើងដើម្បីស្វែងទីតាំងរបស់ករណីក្នុងរយៈពេល​នៃ​ការ​ឆ្លងប្រហាក់ប្រហែល​តាម​ប្រភេទ​ជំងឺគ្រុនចាញ់ និងសម្រាប់វិភាគពីទីតាំង
                            <br />
                            (ឧ.ធ្វើការក្នុងព្រៃ សួរសុខទុក្ខគ្រួសារ)ដែលអ្នកជំងឺបានគេង និងវិភាគពីស្ថានភាពជំងឺគ្រុនចាញ់ក្នុងតំបន់នោះ។ សូមគូសសញ្ញា ធីក (√) ដើម្បីបញ្ជាក់ថាជាប្រភពនៃការចម្លង។
                        </td>
                    </tr>
                </tfoot>
            </table>

            <table class="table table-bordered kh" data-bind="css: Q3Confirm() == 0? 'dis' : ''">
                <tr class="form-inline relative">
                    <th class="bg-info">ផ្អែកលើ [តារាងប្រវត្តិនៃការធ្វើដំណើរ]</th>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        3.11 តើអ្នកជំងឺបានដេករាល់យប់នៅក្នុងភូមិរបស់ពួកគេដែរឬទេ ក្នុងអំឡុងពេលនៃការឆ្លងជំងឺគ្រុនចាញ់ ឬតើភូមិរស់នៅរបស់អ្នកជំងឺ គឺទំនងជាប្រភពនៃការឆ្លងជំងឺគ្រុនចាញ់ដែរឬទេ?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="SleepInVillage" value="1" data-bind="checked: SleepInVillage, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ : ជា "ករណីឆ្លងនៅក្នុងតំបន់" សូមទៅកាន់សំណួរទី 3.12 </kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="SleepInVillage" value="0" data-bind="checked: SleepInVillage, click: $root.radioClick" />
                            <kh>ទេ : សូមទៅកាន់សំណួរទី 3.14 </kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative" data-bind="css: SleepInVillage() == 0 ? 'dis' : ''">
                    <td>
                        3.12 តើ​ករណី​នេះ​រកឃើញក្នុងសំបុកចម្លងសំណល់មិនសកម្ម ឬសំបុកចម្លងសម្អាតរួច?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="FoundInClearup" value="1" data-bind="checked: FoundInClearup, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ : សូមទៅកាន់សំណួរទី 3.13 </kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="FoundInClearup" value="0" data-bind="checked: FoundInClearup, click: $root.radioClick" />
                            <kh>ទេ : ជា "ករណីឆ្លងនៅក្នុងតំបន់" និង សូមទៅកាន់ផ្នែកទី 4 </kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative" data-bind="css: SleepInVillage() == 0 ? 'dis' : ''">
                    <td>
                        3.13 តើករណីនេះមានទំនាក់ទំនងទៅនឹងករណីនាំចូលថ្មីៗដែរឬទេ?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="NewImpCase" value="1" data-bind="checked: NewImpCase, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ : ជា "ករណីឆ្លងពីករណីនាំចូល" និង សូមទៅកាន់ផ្នែកទី 4 </kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="NewImpCase" value="0" data-bind="checked: NewImpCase, click: $root.radioClick" />
                            <kh>ទេ : ជា "ករណីឆ្លងនៅនឹងកន្លែង" និង សូមទៅកាន់ផ្នែកទី 4 </kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        3.14 តើអ្នកជំងឺបានដេកយ៉ាងហោចណាស់មួយយប់នៅខាងក្រៅភូមិដែលពួកគេរស់នៅក្នុងអំឡុងពេលនៃការឆ្លងជំងឺគ្រុនចាញ់ និងតំបន់ដែលពួកគេដេកគឺទំនងជាប្រភពនៃការឆ្លងជំងឺគ្រុនចាញ់?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="SleepOtherVillage" value="1" data-bind="checked: SleepOtherVillage, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ : ជា "ករណីនាំចូលក្នុងស្រុក" និង សូមទៅកាន់ផ្នែកទី 4 </kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="SleepOtherVillage" value="0" data-bind="checked: SleepOtherVillage, click: $root.radioClick" />
                            <kh>ទេ : សូមទៅកាន់សំណួរទី 3.15 </kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        3.15 តើអ្នកជំងឺបានគេងយ៉ាងហោចណាស់មួយយប់នៅក្រៅប្រទេសក្នុងអំឡុងពេលនៃការឆ្លងជំងឺគ្រុនចាញ់ និងប្រទេសនោះទំនងជាប្រភពនៃការឆ្លងជំងឺគ្រុនចាញ់?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="SleepAbroad" value="1" data-bind="checked: SleepAbroad, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎ : ជា "ករណីនាំចូលក្រៅប្រទេស" សូមទៅកាន់ផ្នែកទី 4 </kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="SleepAbroad" value="0" data-bind="checked: SleepAbroad, click: $root.radioClick" />
                            <kh>ទេ : ជា "ករណីឆ្លងនៅក្នុងតំបន់" សូមទៅកាន់ផ្នែកទី 4 </kh>
                        </label>
                    </td>
                </tr>
            </table>
            <!--Part 4-->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th class="bg-info" colspan="7">ផ្នែកទី 4. បញ្ជីឈ្មោះអ្នកពាក់ព័ន្ធនឹងការប្រឈមជំងឺគ្រុនចាញ់ (នៅក្នុងប្រភពនៃការចម្លង)</th>
                </tr>
                <tr>
                    <td colspan="7">ក. ការ​រក​ឃើញ​ទាន់​ពេល និង​ការ​ព្យាបាល​នៃ​ការ​ឆ្លង​ដែល​អាច​រួម​មាន៖ ធ្វើ (RACDT) ករណីឆ្លងនៅក្នុងតំបន់ និងករណីនាំចូលក្នុងស្រុក (ប្រភពនៃចម្លង) អ្នកពាក់ព័ន្ធនឹងការប្រឈមជំងឺគ្រុនចាញ់ដូចមាននៅសំណួរទី 5។</td>
                </tr>
                <tr>
                    <td colspan="7">
                        ខ. ការបង្ការការការឆ្លងបន្ត៖ (ការតាមដានករណី) ករណីនាំចូលក្នុងស្រុក និងករណីនាំចូលក្រៅប្រទេស និងករណីលាប់/រើកើតឡើងវិញ អ្នកពាក់ព័ន្ធនឹងការប្រឈមជំងឺគ្រុនចាញ់គួរផ្អែកលើប្រវត្តិធ្វើដំណើរក្នុងអំឡុងពេលឆ្លង៖ ខ.១ P. vivax - ថ្ងៃទី 1 -8 ចាប់ពីថ្ងៃចេញរោគសញ្ញាដំបូង ;ខ.២ P. falciparum - ថ្ងៃទី 8 ចាប់ពីថ្ងៃរោគសញ្ញាដំបូង
                    </td>
                </tr>
                <tr class="text-center text-bold">
                    <td>ល.រ</td>
                    <td>ឈ្មោះ</td>
                    <td>អាស័យដ្ឋាន (ភូមិ/ឃុំ/ស្រុក/ខេត្ត)</td>
                    <td>លេខទូរសព្ទ</td>
                    <td>អ្នករួមដំណើរ <br />
                        អ្នកប្រឈមឆ្លងជំងឺគ្រុនចាញ់បន្ត</td>
                    <td>ថ្ងៃខែឆ្នាំតាមដានអ្នកប្រឈម <br />ឆ្លងជំងឺគ្រុនចាញ់បន្ត</td>
                    <td>Action</td>
                </tr>

                <tbody data-bind="foreach: Stakeholders">
                    <tr class="text-center">
                        <td data-bind="text: $index()+1"></td>
                        <td>
                            <input type="text" class="form-control " data-bind="value: Name" />
                        </td>
                        <td>
                            <span style="color:red" data-bind="text: $root.getVill(Address())"></span>
                            <input type="hidden" class="form-control " param="addressstake" data-bind="value: Address" />
                            <span data-bind="validationMessage: Address" class="message-error"></span>
                            <button param="addressstake" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                        </td>
                        <td>
                            <input type="number" class="form-control " data-bind="value: Phone" />
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="Passenger" value="Passenger" data-bind="checked: Passenger" />
                            <label>អ្នករួមដំណើរ </label>
                            <br />
                            <input type="checkbox" class="checkbox-lg" name="RiskInfection" value="RiskInfection" data-bind="checked: RiskInfection" />
                            <label>អ្នកប្រឈមឆ្លងជំងឺគ្រុនចាញ់បន្ត</label>
                        </td>
                        <td>
                            <input type="date" class="form-control " data-bind="value: InvDateFrom" />
                            <input type="date" class="form-control " data-bind="value: InvDateTo" />
                        </td>
                        <td>
                            <i class="text-danger fa fa-trash fa-2x" data-bind="click: $root.removeStakeHolder"></i>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <button class="btn btn-success btn-sm" data-bind="click: $root.addStakeHolder">+ Add More</button>
                        </td>
                    </tr>
                    
                </tfoot>
            </table>

            <!--Part 5-->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th class="bg-info">ផ្នែកទី 5: ការចាត់ថ្នាក់ចុងក្រោយ</th>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        5.1 សូមចាត់ថ្នាក់ករណីយោងទៅតាមផ្នែកទី 3?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Classify" value="LocallyAcquired" data-bind="checked: Classify, click: $root.radioClick" />
                            <kh> ករណីឆ្លងនៅក្នុងតំបន់ </kh>
                        </label>
                        &nbsp;&nbsp;
                        (
                        <label class="radio-inline radio-lg">
                            
                             <input type="radio" name="LAType" value="Indigneous" data-bind="checked: LAType, click: $root.radioClick" />
                            <kh> ករណីឆ្លងនៅនឹងកន្លែង </kh>
                            </label>
                        <label class="radio-inline radio-lg">
                            &nbsp;&nbsp;
                             <input type="radio" name="LAType" value="Introduced" data-bind="checked: LAType, click: $root.radioClick" />
                            <kh> ករណីឆ្លងពីករណីនាំចូល </kh>
                            )
                             </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Classify" value="DomesticallyImported" data-bind="checked: Classify, click: $root.radioClick" />
                            <kh>ករណីនាំចូលក្នុងស្រុក </kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Classify" value="InternationalImported" data-bind="checked: Classify, click: $root.radioClick" />
                            <kh>ករណីនាំចូលក្រៅប្រទេស</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Classify" value="Induce" data-bind="checked: Classify, click: $root.radioClick" />
                            <kh>ករណីឆ្លងតាមឈាម</kh>
                        </label>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="Classify" value="Relapse" data-bind="checked: Classify, click: $root.radioClick" />
                            <kh>ករណីលាប់/រើកើតឡើងវិញ</kh>
                        </label>
                        <span data-bind="validationMessage: Classify" class="message-error"></span>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        5.2 តើ​ការចាត់ថ្នាក់ករណីនេះ​ត្រូវ​គ្នា​នឹង​ការ​ចាត់​ថ្នាក់ករណីធ្វើដោយ POC ឬទេ?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="POC" value="1" data-bind="checked: POC, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="POC" value="0" data-bind="checked: POC, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                    </td>
                </tr>
            </table>

            <!--Part 6-->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th class="bg-info">ផ្នែកទី 6៖ ឥរិយាបទរបស់អ្នកជំងឺ និងការគ្រប់គ្រងភ្នាក់ងារចម្លង</th>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        6.1 តើអ្នកជំងឺមានមុងប្រើដែរឬទេ?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="HasBednet" value="1" data-bind="checked: HasBednet, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="HasBednet" value="0" data-bind="checked: HasBednet, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        6.2 ប្រសិនបើ "បាទ/ចាស" តើមុងប្រភេទអ្វី?
                        <br />
                        <div class="form-group">
                            <input type="checkbox" class="checkbox-lg" name="LLIN" value="LLIN" data-bind="checked: BednetType" />
                            <label>LLIN</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="LLIHN" value="LLIHN" data-bind="checked: BednetType" />
                            <label>LLIHN</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Normal" value="Normal" data-bind="checked: BednetType" />
                            <label>Normal</label>
                        </div>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        6.3 តើ​អ្នក​ជំងឺ​ដេកក្នុងមុងជាប់ជាប្រចាំ​ពេល​ចេញ​ទៅ​ក្រៅ​ភូមិ ឬ​ក្នុង​ព្រៃដែរ​ឬទេ?
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="AlwaysSleepInBednet" value="1" data-bind="checked: AlwaysSleepInBednet, click: $root.radioClick" />
                            <kh>បាទ/ចាស៎</kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="AlwaysSleepInBednet" value="0" data-bind="checked: AlwaysSleepInBednet, click: $root.radioClick" />
                            <kh>ទេ</kh>
                        </label>
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        Note:
                    <br />
                        <input type="text" class="form-control" data-bind="value: Note" style="width: 100%"/>
                    </td>
                </tr>
            </table>
        </div>
				
	</div>
	<div class="panel-footer text-center">
		<button class="btn btn-primary btn-sm width150" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('CICC Edit')">Save</button>
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
                                <input type="radio" value="0" data-bind="checked: isOther"/>
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
                                <input type="radio" value="1" data-bind="checked: isOther"/>
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
                            <div class="input-group">
                                <span class="input-group-addon">មិនបានធ្វើ</span> &nbsp;&nbsp;
                                <input type="checkbox" class="checkbox-lg" name="Active_1" value="1" data-bind="checked: NotDo" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">ហេតុផលមិនបានធ្វើ</span>
                                <select class="form-control" data-bind="value: ReasonNotDo" >
                                    <option></option>
                                    <option>Not Eligible</option>
                                    <option>In Forest</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">ហេតុផលផ្សេងៗ</span>
                                <input type="text" class="form-control" data-bind="value: OtherReasonNotDo" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">ដោយ (ឈ្មោះ)</span>
                                <input type="text" class="form-control" data-bind="value: DeclaredNotDoBy" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">Completed</span> &nbsp;&nbsp;
                                <input type="checkbox" class="checkbox-lg" name="Active_1" value="1" data-bind="checked: Completed" />
                            </div>
                        </td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm width100" data-bind="click: saveNote">Save Note</button>
                <button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<?=latestJs('/media/ViewModel/MRRT_CICC.js')?>
