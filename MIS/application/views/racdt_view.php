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
                    <th style="width:35px">Province</th>
                    <th style="width:35px">OD</th>
                    <th style="width:200px">HC</th>
                    <th style="width:200px">Infection Source</th>
                    <th>Patient Code</th>
                    <th>Patient Name</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Diagnosis</th>
                    <th>Date case</th>
                    <th>Year</th>
                    <th sortable>Month</th>
                    <th width="10">Case From</th>
                    <th width="10">Classify</th>
                    <th sortable width="10">Has Data</th>
                    <th width="20">Action</th>
                    <th colspan="2">Note</th>
                    <th colspan="2">ផ្តល់សិទ្ធទៅ</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listModel, fixedHeader: true">
                <tr>
                    <td data-bind="text: $index() + 1"></td>
                    <td data-bind="text: $root.getProvName(Code_Prov_N)"></td>
                    <td data-bind="text: $root.getODName(Code_OD_T)"></td>
                    <td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
                    <td data-bind="text: $root.getVill(InfectionSourceAddress)"></td>
                    <td data-bind="text: PatientCode"></td>
                    <td data-bind="text: NameK"></td>
                    <td data-bind="text: Sex"></td>
                    <td data-bind="text: Age"></td>
                    <td data-bind="text: $root.getSpecie(Diagnosis)"></td>
                    <td data-bind="text: $root.dateFormat(DateCase)"></td>
                    <td data-bind="text: Year"></td>
                    <td sortable data-bind="text: Month"></td>
                    <td data-bind="text: Type"></td>
                    <td data-bind="text: Classify"></td>
                    <td data-bind="sortValue: CI_ID() && NotDo != 1 ? 1:2" class="text-center">
                        <i data-bind="visible: CI_ID() && NotDo != 1" class="fa fa-check-square-o"></i>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" data-bind="click: $root.viewDetail">Detail</a>
                    </td>
                    <td style="width:30px">
                        <button class="btn btn-sm btn-success" data-bind="visible: app.user.permiss['MRRT2'].contain('Foci Note'), click: $root.createNote">Note</button>
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
		<div class="pull-left font16 text-bold lh26">Case Investigation</div>
		<div class="pull-right">
            <button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['RACDT'].contain('RACDT Edit')">Save</button>
            <!--ko if: isDelete-->
            <button class="btn btn-danger btn-sm width100" data-bind="click: showDelete, visible: app.user.permiss['RACDT'].contain('RACDT Delete')">Delete</button>
            <!-- /ko -->
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back">Back</button>
		</div>
	</div>
    <div class="panel-body displayTable" style="min-width: 900px; margin: auto">
        <h3 class="kh text-center text-bold">ទម្រង់កត់ត្រា ការធ្វើអន្តរាគមន៍ឆ្លើយតបនឹងករណី</h3>
        <h5 class="kh text-center text-bold">RACDT</h5>
        <br />
        <br />

        <div data-bind="with: detailModel">
            <table class="table table-bordered kh">
                <!-- Part 1 -->
                <tr class="form-inline relative">
                    <th class="bg-info">ផ្នែកទី 1៖ ព័ត៌មានករណី</th>
                    <th class="bg-info">
                        លេខកូដអ្នកជំងឺ៖
                        <input type="text" class="form-control" data-bind="value: PatientCode" />
                    </th>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        1.1 ឈ្មោះ៖
                        <input type="text" class="form-control" data-bind="value: PatientName" />
                    </td>
                    <td>
                        1.2 ថ្ងៃខែឆ្នាំធ្វើរោគវិនិច្ឆ័យ៖
                        <input type="date" class="form-control width150 text-center" data-bind="value: DateCase" placeholder="DD-MM-YYYY" />
                    </td>

                </tr>
                <tr class="form-inline relative">
                    <td>
                        1.3 អាសយដ្ឋានប្រភពចម្លង៖
                        <span style="color:red" data-bind="text: $root.getVill(InfectionSourceAddress())"></span>
                        <input type="hidden" param="address" class="form-control" data-bind="value: InfectionSourceAddress" />
                        <span data-bind="validationMessage: InfectionSourceAddress" class="message-error"></span>
                        <button param="address" class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                    </td>
                    <td>
                        1.4 ថ្ងៃអនុវត្តសកម្មភាព៖
                        <input type="date" class="form-control width150 text-center" data-bind="value: RacdtDate" placeholder="DD-MM-YYYY" />
                    </td>
                </tr>
            </table>

            <table class="table table-bordered kh">
                <thead>
                    <tr>
                        <th rowspan="2" colspan="4" class="text-center">
                            ព័ត៌មានអ្នកជិតខាង/អ្នកពាក់ព័ន្ធនឹងការប្រឈម
                        </th>
                        <th colspan="9" class="text-center">
                            ធ្វើតេស្តស្រាវជ្រាវរកជំងឺគ្រុនចាញ់តាមខ្នងផ្ទះ
                        </th>
                        <th colspan="3" class="text-center"> ការតាមដានករណី</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-center">កត្តាហាប្រឈមនឹងជំងឺគ្រុនចាញ់ </th>
                        <th class="text-center">តេស្ត</th>
                        <th class="text-center">លទ្ធផលតេស្ត</th>
                        <th class="text-center">បានព្យាបាល</th>
                        <th></th>
                        <th colspan="2" class="text-center">បើទេ ហេតុអ្វី?</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th class="text-center">ល.រខ្នងផ្ទះ</th>
                        <th class="text-center">ល.រសមាជិកគ្រួសារ</th>
                        <th class="text-center">ភេទ</th>
                        <th class="text-center">អាយុ</th>

                        <th class="text-center">សាច់ញាតិ</th>
                        <th class="text-center">
                            ក្តៅខ្លួន រងារញាក់
                            <br /> បែកញើស ក្នុងរយៈពេល
                            <br /> ពីរសប្តាហ៍ចុងក្រោយ
                        </th>
                        <th class="text-center">
                            ដេកក្នុងព្រៃ
                            <br /> ឬនៅកន្លែងធ្វើការ
                            <br />/ចំការក្នុងរយៈពេល
                            <br /> 30 ថ្ងៃចុងក្រោយ
                        </th>
                        <th class="text-center">
                            ត្រលប់ពីតំបន់
                            <br />ដែលប្រឈមខ្ពស់នឹង
                            <br />ជំងឺគ្រុនចាញ់ក្នុង
                            <br />រយៈពេល30ថ្ងៃចុងក្រោយ
                        </th>
                        <th class="text-center">
                            មានប្រវត្តិ
                            <br />កើតជំងឺគ្រុនចាញ់
                        </th>
                        <th class="text-center">អ្នករួមដំណើរ</th>

                        <th class="text-center">
                            ☐ បានធ្វើតេស្ត
                            <br />
                            ☐ អវត្តមាន
                            <br />
                            ☐ បដិសេធ
                            <br />
                            ☐ មិនត្រូវលក្ខខ័ណ្ឌ
                            <br />
                        </th>
                        <th class="text-center">
                            ☐ អវិជ្ជមាន
                            <br />
                            ☐ Pf ☐ Pv
                            <br />
                            ☐ Pk ☐ Po
                            <br />
                            ☐ Pm
                        </th>
                        <th class="text-center"></th>

                        <th class="text-center">
                            ☐ បាទ
                            <br /> ☐ ទេ
                        </th>

                        <th class="text-center">
                            មិនអាច
                            <br />ទាក់ទងបាន
                        </th>
                        <th class="text-center">ផ្សេងៗ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Houses">
                    <tr class="text-center">
                        <td>
                            <input type="text" class="form-control width60" data-bind="value: HouseN" numonly="int" />
                        </td>
                        <td>
                            <input type="text" class="form-control width60" data-bind="value: MemberN" numonly="int" />
                        </td>
                        <td class="text-left">
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="M" data-bind="checked: Sex" />
                                <kh>ប្រុស</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="F" data-bind="checked: Sex" />
                                <kh>ស្រី</kh>
                            </label>
                        </td>
                        <td>
                            <input type="text" class="form-control width60" data-bind="value: Age" numonly="int" />
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="Relative" value="1" data-bind="checked: Relative" />
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="Fever" value="1" data-bind="checked: Fever" />
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="SleepForest" value="1" data-bind="checked: SleepForest" />
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="ReturnRiskArea" value="1" data-bind="checked: ReturnRiskArea" />
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="EverHadMalaria" value="1" data-bind="checked: EverHadMalaria" />
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="Passenger" value="1" data-bind="checked: Passenger" />
                        </td>
                        <td class="text-left">
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="Test" data-bind="checked: Test, attr: {name: 'Test-'+$index()}, click: $root.radioClick" />
                                <kh>បានធ្វើតេស្ត </kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="Absent" data-bind="checked: Test, attr: {name: 'Test-'+$index()}, click: $root.radioClick" />
                                <kh>អវត្តមាន </kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="Deny" data-bind="checked: Test, attr: {name: 'Test-'+$index()}, click: $root.radioClick" />
                                <kh>បដិសេធ</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="NotEligible" data-bind="checked: Test, attr: {name: 'Test-'+$index()}, click: $root.radioClick" />
                                <kh>មិនត្រូវលក្ខខ័ណ្ឌ</kh>
                            </label>
                        </td>
                        <td class="text-left">
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="N" data-bind="checked: Diagnosis, attr: {name: 'Diagnosis-'+$index()}, click: $root.radioClick" />
                                <kh>អវិជ្ចមាន</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="F" data-bind="checked: Diagnosis, attr: {name: 'Diagnosis-'+$index()}, click: $root.radioClick" />
                                <kh>Pf</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="V" data-bind="checked: Diagnosis, attr: {name: 'Diagnosis-'+$index()}, click: $root.radioClick" />
                                <kh>Pv</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="M" data-bind="checked: Diagnosis, attr: {name: 'Diagnosis-'+$index()}, click: $root.radioClick" />
                                <kh>Mix</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="A" data-bind="checked: Diagnosis, attr: {name: 'Diagnosis-'+$index()}, click: $root.radioClick" />
                                <kh>Pm</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="K" data-bind="checked: Diagnosis, attr: {name: 'Diagnosis-'+$index()}, click: $root.radioClick" />
                                <kh>Pk</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="O" data-bind="checked: Diagnosis, attr: {name: 'Diagnosis-'+$index()}, click: $root.radioClick" />
                                <kh>Po</kh>
                            </label>
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="UnableContact" value="1" data-bind="checked: Treated" />
                        </td>
                        <td class="text-left">
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: CaseFollowup, attr: {name: 'CaseFollowup-'+$index()}, click: $root.radioClick" />
                                <kh>បាទ</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: CaseFollowup, attr: {name: 'CaseFollowup-'+$index()}, click: $root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox-lg" name="UnableContact" value="1" data-bind="checked: UnableContact" />
                        </td>
                        <td>
                            <input type="text" class="form-control width60" data-bind="value: OtherReason" />
                        </td>
                        <td>
                            <i class="text-danger fa fa-trash fa-2x" data-bind="click: $root.removeHouse"></i>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="17">
                            <a data-bind="click: $root.addHouse">+ Add More</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <!--Part 2-->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th colspan="4" class="bg-info">ផ្នែកទី 2៖ សង្ខេបសរុប</th>
                </tr>

                <tr class="form-inline relative">
                    <td>
                        ចំនួនខ្នងផ្ទះបានចុះ៖
                        <input type="text" class="form-control width70" data-bind="value: House" numonly="int" />
                    </td>
                    <td>
                        ចំនួនសមាជិកគ្រួសារបានជួប៖
                        <input type="text" class="form-control width70 text-center" data-bind="value: Member" numonly="int" />
                    </td>
                    <td>
                        ចំនួនបានធ្វើតេស្ត៖
                        <input type="text" class="form-control width70 text-center" data-bind="value: Test" numonly="int" />
                    </td>
                    <td>
                        ចំនួនវិជ្ជមាន៖
                        <br />
                        <br />
                        Pf
                        <input type="text" class="form-control width60 text-center" data-bind="value: Pf" numonly="int" />
                        Pv
                        <input type="text" class="form-control width60 text-center" data-bind="value: Pv" numonly="int" />
                        Mix
                        <input type="text" class="form-control width60 text-center" data-bind="value: Mix" numonly="int" />
                        <br />
                        <br />
                        Pk
                        <input type="text" class="form-control width60 text-center" data-bind="value: Pk" numonly="int" />
                        Po
                        <input type="text" class="form-control width60 text-center" data-bind="value: Po" numonly="int" />
                        Pm
                        <input type="text" class="form-control width60 text-center" data-bind="value: Pm" numonly="int" />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        ចំនួនការព្យាបាល៖
                        <input type="text" class="form-control width70" data-bind="value: Treatment" numonly="int" />
                    </td>
                    <td>
                        ចំនួនអវត្តមាន៖
                        <input type="text" class="form-control width70 text-center" data-bind="value: Absent" numonly="int" />
                    </td>
                    <td>
                        ចំនួនបដិសេធការធ្វើតេស្ត៖
                        <input type="text" class="form-control width70 text-center" data-bind="value: Refuse" numonly="int" />
                    </td>
                    <td>
                        ក្រុម MRRT បានទូរសព្ទទៅចំនួន៖
                        <input type="text" class="form-control width70 text-center" data-bind="value: MRRTCall" numonly="int" />
                    </td>
                </tr>
                <tr class="form-inline relative">
                    <td colspan="3">
                        រាយការណ៍ដោយ៖
                        <input type="text" class="form-control width150 text-center" data-bind="value: ReportedBy" />
                    </td>
                    <td>
                        កាលបរិច្ឆេទ៖
                        <input type="date" class="form-control width150 text-center" data-bind="value: ReportedDate" placeholder="DD-MM-YYYY" />
                    </td>
                </tr>

            </table>
        </div>

    </div>
	<div class="panel-footer text-center">
        <button class="btn btn-primary btn-sm width150" data-bind="click: save, visible: app.user.permiss['RACDT'].contain('RACDT Edit')">Save</button>
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

<!-- Modal Note -->
<div class="modal" id="modalNote" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 900px">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Note</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" data-bind="with: noteModel">
                    <tr>
                        <th>Patient Name</th>
                        <th>Patient Code</th>
                        <th>Date Case</th>
                    </tr>
                    <tr>
                        <td data-bind="text: PatientName"></td>
                        <td data-bind="text: PatientCode"></td>
                        <td data-bind="text: DateCase"></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-group" style="border: 1px solid #ccc">
                                <span class="input-group-addon" style="border: none !important">មិនបានធ្វើ</span> &nbsp;&nbsp;
                                <input type="checkbox" class="checkbox-lg" name="Active_1" value="1" data-bind="checked: NotDo" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group" data-bind="if: NotDo() == 1">
                                <span class="input-group-addon">ហេតុផលមិនបានធ្វើ</span>
                                <select class="form-control" data-bind="value: ReasonNotDo" >
                                    <option></option>
                                    <option>Ineligible</option>
                                    <option>Already Conducted Foci</option>
                                    <option>In Forest</option>
                                    <option>Not Year Apply New Surveillance</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="input-group" data-bind="if: NotDo() == 1">
                                <span class="input-group-addon">ហេតុផលផ្សេងៗ (Other)</span>
                                <input type="text" class="form-control" data-bind="value: OtherReasonNotDo" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
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
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="input-group">
                                <span class="input-group-addon">កំណត់សម្គាល់</span>
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
                <button class="pull-left btn btn-primary width100" data-bind="click: $root.transfer" style="float: left">Save</button>
                <button class="pull-left btn btn-default width100" data-bind="click: $root.closeTransfer" style="float: left">Close</button>
            </div>
        </div>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<?=latestJs('/media/ViewModel/RACDT.js')?>
