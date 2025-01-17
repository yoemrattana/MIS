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
    .width120 { width:120px !important; }
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
                    <th style="width:10px">#</th>
                    <th style="width:30px">Province</th>
                    <th style="width:30px">OD</th>
                    <th style="width:200px">HC</th>
                    <th>Patient Code</th>
                    <th>Patient Name</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Diagnosis</th>
                    <th>Date case</th>
                    <th>Year</th>
                    <th>Month</th>
                    <th width="10">Case From</th>
                    <th width="10">Has Data</th>
                    <th width="20">Action</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listModel">
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
                    <td class="text-center">
                        <i data-bind="visible: Id()" class="fa fa-check-square-o"></i>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" data-bind="visible: app.user.permiss['MRRT2'].contain('Travel Edit'), click: $root.viewDetail">Detail</a>
                    </td>
                    
                </tr>

            </tbody>
        </table>
     </div>
</div>

<!--Form-->

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 text-bold lh26">Follow-up onward transmission</div>
		<div class="pull-right">
            <button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('Travel Edit')">Save</button>
            <!--ko if: isDelete-->
            <button class="btn btn-danger btn-sm width100" data-bind="click: showDelete, visible: app.user.permiss['MRRT2'].contain('Travel Delete')">Delete</button>
            <!-- /ko -->
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back">Back</button>
		</div>
	</div>
    <div class="panel-body displayTable" style="min-width: 900px; margin: auto">
        <h3 class="kh text-center text-bold">ការឆ្លើយតបទៅតាមករណី៖ ទម្រង់កាតាមដានអ្នករួមដំណើរ និងអ្នកដែលប្រឈមឆ្លងជំងឺគ្រុនចាញ់បន្ត</h3>
        <br />
        <br />

        <table class="table table-bordered" data-bind="with: detailModel">
            <tr>
                <td colspan="14">ផ្នែកទី១៖ ព័ត៌មានអំពីករណីគោល</td>
            </tr>
            <tr>
                <td>លេខកូដអ្នកជំងឺ៖</td>
                <td><input data-bind="value: PatientCode" type="text" class="form-control"/></td>
                <td>ឈ្មោះអ្នកជំងឺ</td>
                <td><input data-bind="value: PatientName" type="text" class="form-control"/></td>
                <td>អាយុ៖</td>
                <td><input data-bind="value: Age" type="text" class="form-control"/></td>
                <td>ភេទ៖</td>
                <td>
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Sex" value="M" data-bind="checked: Sex" />
                        <kh>ប្រុស</kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Sex" value="F" data-bind="checked: Sex" />
                        <kh>ស្រី</kh>
                    </label>
                    <span data-bind="validationMessage: Sex" class="message-error"></span>
                </td>
                <td>លេខទូរសព្ទ៖</td>
                <td><input data-bind="value: PatientPhone" type="text" class="form-control"/></td>
                <td>ប្រភេទមេរោគ៖</td>
                <td>
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Diagnosis" value="F" data-bind="checked: Diagnosis, click: $root.radioClick" />
                        <kh>Pf</kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Diagnosis" value="V" data-bind="checked: Diagnosis, click: $root.radioClick" />
                        <kh>Pv</kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Diagnosis" value="M" data-bind="checked: Diagnosis, click: $root.radioClick" />
                        <kh>Mix</kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Diagnosis" value="A" data-bind="checked: Diagnosis, click: $root.radioClick" />
                        <kh>Pm</kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Diagnosis" value="K" data-bind="checked: Diagnosis, click: $root.radioClick" />
                        <kh>Pk</kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Diagnosis" value="O" data-bind="checked: Diagnosis, click: $root.radioClick" />
                        <kh>Po</kh>
                    </label>
                    <span data-bind="validationMessage: Diagnosis" class="message-error"></span>
                </td>
                <td>ចំណាត់ថ្នាក៉</td>
                <td>
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Classify" value="LocallyAcquired" data-bind="checked: Classify, click: $root.radioClick" />
                        <kh> ករណីឆ្លងនៅក្នុងតំបន់ </kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Classify" value="DomesticallyImported" data-bind="checked: Classify, click: $root.radioClick" />
                        <kh>ករណីនាំចូលក្នុងស្រុក </kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Classify" value="InternationalImported" data-bind="checked: Classify, click: $root.radioClick" />
                        <kh>ករណីនាំចូលក្រៅប្រទេស</kh>
                    </label>
                    <br />
                    <label class="radio-inline radio-lg">
                        <input type="radio" name="Classify" value="Induce" data-bind="checked: Classify, click: $root.radioClick" />
                        <kh>ករណីឆ្លងតាមឈាម</kh>
                    </label>
                    <br />
                    <span data-bind="validationMessage: Classify" class="message-error"></span>
                </td>
            </tr>

            <tr>
                <td colspan="2">អាសយដ្ឋានអចិន្ត្រៃយ៍</td>
                <td>
                    <span style="color:red" data-bind="text: $root.getVill(PermanentAddress())"></span>
                    <input type="hidden" class="form-control" data-bind="value: PermanentAddress" />
                    <span data-bind="validationMessage: PermanentAddress" class="message-error"></span>
                    <button param="peraddress" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                </td>
                <td colspan="2">អាសយដ្ឋានកំពុងរស់នៅ</td>
                <td>
                    <span style="color:red" data-bind="text: $root.getVill(Address())"></span>
                    <input type="hidden" class="form-control" data-bind="value: Address" />
                    <span data-bind="validationMessage: Address" class="message-error"></span>
                    <button param="address" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                </td>
                <td colspan="2">មណ្ឌលសុខភាព</td>
                <td data-bind="text: $root.getHCName(Code_Facility_T())"></td>
                <td colspan="2">ស្រុកប្រតិបត្តិ</td>
                <td data-bind="text: $root.getODName(Code_OD_T())"></td>
                <td>ខេត្ត</td>
                <td data-bind="text: $root.getProvName(Code_Prov_N())"></td>
            </tr>
        </table>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="10">ផ្នែកទី២ ការតាមដានអ្នករួមដំណើរ និងអ្នកដែលប្រឈមឆ្លងជំងឺគ្រុនចាញ់បន្ត</th>
                </tr>
                <tr>
                    <th width="15">ល.រ</th>
                    <th>ឈ្មោះ</th>
                    <th>អាសយដ្ឋាន</th>
                    <th>លេខទូរសព្ទ</th>
                    <th>ប្រភេទបុគ្គលដែលត្រូវតាមដាន</th>
                    <th>ចន្លោះកាលបរិច្ឆេទត្រូវតាមដានតាមទូរសព្ទ</th>
                    <th>កាលបរិច្ឆេទបានទូសព្ទតាមដាន</th>
                    <th>អការៈ</th>
                    <th>គូសធីក លើអាការៈណាដែលកើតមាន</th>
                    <th>ជំហានបន្ទាប់</th>
                    <th></th>
                </tr>
            </thead>
            <tbody data-bind="foreach: membersModel">
                <tr>
                    <td data-bind="text: $index()+1"></td>
                    <td><input data-bind="value: Name" type="text" class="form-control" /></td>
                    <td>
                        <span style="color:red" data-bind="text: $root.getVill(Address())"></span>
                        <input type="hidden" class="form-control" data-bind="value: Address" />
                        <button param="addressstake" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                        <span data-bind="validationMessage: Address" class="message-error"></span>
                    </td>
                    <td><input data-bind="value: Phone" type="text" class="form-control" /></td>
                    <td><input data-bind="value: FollowerType" type="text" class="form-control" /></td>
                    <td><input data-bind="value: FollowDateFrom" type="date" class="form-control" /> <br /> <input data-bind="value: FollowDateTo" type="date" class="form-control" /></td>
                    <td>
                        <input data-bind="value: CalledDate" type="date" class="form-control" />
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="CanContact" value="1" data-bind="checked: CanContact, attr:{name: 'contact' + $index()}" />
                            <kh>អាចទាក់ទងបាន</kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="CanContact" value="0" data-bind="checked: CanContact, attr:{name: 'contact' + $index()}" />
                            <kh>មិនអាចទាក់ទងបាន</kh>
                        </label>
                        <br />
                        <span data-bind="validationMessage: CanContact" class="message-error"></span>
                    
                    </td>
                    <td>
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="IsSymptom" value="1" data-bind="checked: IsSymptom, attr:{name: 'symptom' + $index()}" />
                            <kh>មាន</kh>
                        </label>
                        <br />
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="IsSymptom" value="0" data-bind="checked: IsSymptom, attr:{name: 'symptom' + $index()}" />
                            <kh>គ្មាន</kh>
                        </label>
                        <br />
                        <span data-bind="validationMessage: IsSymptom" class="message-error"></span>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="checkbox" class="checkbox-lg" name="Fever" value="Fever" data-bind="checked: Symptom" />
                            <label>ក្តៅខ្លួន</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Chills" value="Chills" data-bind="checked: Symptom" />
                            <label>ញាក់</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Headache" value="Headache" data-bind="checked: Symptom" />
                            <label>ឈឺក្បាល</label>
                            <br />
                            <input type="checkbox" class="checkbox-lg" name="Vomit" value="Vomit" data-bind="checked: Symptom" />
                            <label>ក្អួត</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Diarrhea" value="Diarrhea" data-bind="checked: Symptom" />
                            <label>រាគ</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Cough" value="Cough" data-bind="checked: Symptom" />
                            <label>ក្អក</label>
                            <br />
                            <input type="checkbox" class="checkbox-lg" name="Sweat" value="Sweat" data-bind="checked: Symptom" />
                            <label>បែកញើស</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="Nausea" value="Nausea" data-bind="checked: Symptom" />
                            <label>ចង្អោរ</label>
                            <br />
                            <input type="checkbox" class="checkbox-lg" name="No Symptoms" value="No Symptoms" data-bind="checked: Symptom" />
                            <label>គ្មានរោគសញ្ញា</label>
                            <br />
                            <input type="checkbox" class="checkbox-lg" name="Other" value="Other" data-bind="checked: Symptom" />
                            <label>រោគសញ្ញាផ្សេងទៀត៖</label>
                            &nbsp;&nbsp;
                            <input type="text" class="form-control width150" data-bind="value: OtherSymptom" />
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="checkbox" class="checkbox-lg" name="ReferToHF" value="ReferToHF" data-bind="checked: WayForward" />
                            <label>បញ្ជូនទៅ HF</label>
                            <br />
                            <input type="checkbox" class="checkbox-lg" name="ReferToVMW" value="ReferToVMW" data-bind="checked: WayForward" />
                            <label>បញ្ជូនទៅ VMW/MMW</label>
                            <br />
                            <input type="checkbox" class="checkbox-lg" name="HealthEducation" value="HealthEducation" data-bind="checked: WayForward" />
                            <label>អប់រំសុខភាព</label>
                        </div>
                    </td>
                    <td><i class="fa fa-trash fa-lg text-danger" data-bind="click: $root.removeMember"></i></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10"><button data-bind="click:$root.addMember" class="btn btn-sm btn-primary"> + Add</button></td>
                </tr>
            </tfoot>
        </table>

        <table class="table table-bordered" data-bind="with: detailModel">
            <tr>
                <td>តាមដានដោយឈ្មោះ</td>
                <td><input data-bind="value: FollowupBy" type="text" class="form-control"/></td>
                <td>តួនាទី</td>
                <td><input data-bind="value: PositionFollowup" type="text" class="form-control"/></td>
                <td>កាលបរិច្ឆេទ</td>
                <td><input data-bind="value: DateRespone" type="date" class="form-control"/></td>
            </tr>
        </table>

    </div>
	<div class="panel-footer text-center">
        <button class="btn btn-primary btn-sm width150" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('Travel Edit')">Save</button>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<?=latestJs('/media/ViewModel/MRRT_Traveler.js')?>