<style>
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
	.checkbox-inline input { width: 20px; height: 20px; }
    input[type="number"] {width: 100%;}
	.species p { padding-left: 10px; color: #125792; }
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
			<select data-bind="options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: isSingle(odList()) ? undefined : 'Select OD',
					value: od" class="form-control input-sm minwidth150"></select>
		</div>
		<div class="pull-left font16 lh28">
			<b>Health Facility Data Accuracy Report</b>
		</div>
		<div class="pull-right">
			<a href="/Home"><img src="/media/images/home_back.png" /></a>
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
					<th width="100" class="text-center">Facility Type</th>
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
		<div class="pull-left lh26">
			<b>OD:</b>
			<span data-bind="text: od"></span>

			<b style="margin-left:30px">Health Faciliy:</b>
			<span data-bind="text: en"></span>
			<span> - </span>
			<kh data-bind="text: kh"></kh>

			<b style="margin-left:30px">Monthly Report:</b>
			<span data-bind="text: month"></span>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: $root.saveReport, visible: app.user.permiss['Health Center Data Accuracy'].contain('Edit')">Save</button>
            <button class="btn btn-danger btn-sm width100" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['Health Center Data Accuracy'].contain('Delete')">Delete</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back" style="margin-left:30px">Back</button>
		</div>
	</div>
    <div class="panel-heading">
        <div class="form-inline relative" data-bind="with: master">
            <span>
                <kh>ថ្ងៃចុះ</kh> (Mission Date)
            </span>
            <input type="text" class="form-control input-sm text-center" style="width:120px" data-bind="datePicker: DateAdded" />
            <span>
                <kh>ពិនិត្យដោយ</kh>
            </span>
            <span class="badge" data-bind="text: createdby"></span>
        </div>
    </div>
    <div class="panel-body no-padding">
        <!--
        <table id="tblcase" class="table table-bordered table-hover">
            <thead>
                <tr data-bind="click: app.selectTr">
                    <td>
                        <input type="number" disabled min="0" data-bind="value: getPVByHF()" class="text-center" maxlength="2" />
                    </td>
                    <td>
                        <input type="number" disabled min="0" data-bind="value: getPFByHF()" class="text-center" maxlength="3" />
                    </td>
                    <td>
                        <input type="number" disabled min="0" data-bind="value: getMixByHF()" class="text-center" maxlength="4" />
                    </td>
                    <td>
                        <input type="number" disabled min="0" data-bind="value: getNegativeByHF()" class="text-center" maxlength="4" />
                    </td>
                </tr>
            </thead>
            <thead>
                <tr>
                    <td>
                        <kh>ហ្វាល់ស៊ីប៉ារ៉ូម</kh>
                        <br />PF
                    </td>
                    <td>
                        <kh>វីវ៉ាក់</kh>
                        <br />PV
                    </td>
                    <td>
                        <kh>ចម្រុះ</kh>
                        <br />Mix
                    </td>
                    <td>
                        <kh>អវិជ្ជមាន</kh>
                        <br />Negative
                    </td>
                </tr>
            </thead>
            <tbody data-bind="with: data, fixedHeader: true">
                <tr data-bind="click: app.selectTr">
                    <td>
                        <input type="number" min="0" data-bind="textInput: NumberPF" class="text-center" maxlength="2" />
                    </td>
                    <td>
                        <input type="number" min="0" data-bind="textInput: NumberPV" class="text-center" maxlength="3" />
                    </td>
                    <td>
                        <input type="number" min="0" data-bind="textInput: NumberMix" class="text-center" maxlength="4" />
                    </td>
                    <td>
                        <input type="number" min="0" data-bind="textInput: NumberNegative" class="text-center" maxlength="4" />
                    </td>
                </tr>
            </tbody>
        </table>
        -->
        <div class="row">
            <div class="col-sm-6">
                <h4 class="text-center">
                    <k>ទិន្នន័យបញ្ចូលដោយ Auditor</k> (Data By Auditor)
                </h4>
                <!--
                <div class="total">
                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>តេស្តសរុប</kh> (Total Tests)
                        </p>
                        <input type="text" class="form-control input-sm font14" data-bind="value: getTest()" disabled />
                    </div>
                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>ករណី វិជ្ជមាន</kh> (Positive Cases)
                        </p>
                        <input type="text" class="form-control input-sm font14" data-bind="value: getPositive()" disabled />
                    </div>
                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>ករណី អវិជ្ជមាន</kh> (Negative Cases)
                        </p>
                        <input type="text" class="form-control input-sm font14" data-bind="value: getNegative()" disabled />
                    </div>
                </div>
                -->
                <div class="total" data-bind="with:data">
                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>តេស្តសរុប</kh> (Total Tests)
                        </p>
                        <input type="number" class="form-control input-sm font14" data-bind="value: NumberTest" disabled />
                    </div>
                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>វិជ្ជមាន</kh> (Positive Cases)
                        </p>
                        <input type="number" class="form-control input-sm font14" data-bind="value: NumberPositive, disable: IncludedSpecies" />
                        <label class="checkbox-inline checkbox-lg">
                            <input type="checkbox" data-bind="checked: IncludedSpecies" /> Species
                        </label>
                    </div>
                    <div class="species" data-bind="visible: IncludedSpecies">
                        <div class="form-inline">
                            <p class="form-control-static">
                                <kh>ហ្វាល់ស៊ីប៉ារ៉ូម</kh> (PF)
                            </p>
                            <input type="number" min="0" class="form-control input-sm font14" data-bind="value: NumberPF" />
                        </div>
                        <div class="form-inline">
                            <p class="form-control-static">
                                <kh>វីវ៉ាក់</kh> (PV)
                            </p>
                            <input type="number" min="0" class="form-control input-sm font14" data-bind="value: NumberPV" />
                        </div>
                        <div class="form-inline">
                            <p class="form-control-static">
                                <kh>ចម្រុះ</kh> (Mix)
                            </p>
                            <input type="number" min="0" class="form-control input-sm font14" data-bind="value: NumberMix" />
                        </div>
                    </div>
                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>អវិជ្ជមាន</kh> (Negative Cases)
                        </p>
                        <input type="number" class="form-control input-sm font14" data-bind="value: NumberNegative" required />
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <h4 class="text-center">
                    <k>ទិន្នន័យបញ្ចូលដោយ HF</k> (Data By HF)
                </h4>
                <div class="total">
                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>តេស្តសរុប</kh> (Total Tests)
                        </p>
                        <input type="text" class="form-control input-sm font14" data-bind="value: getTestByHF()" disabled />
                    </div>
                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>វិជ្ជមាន</kh> (Positive Cases)
                        </p>
                        <input type="text" class="form-control input-sm font14" data-bind="value: getPositiveByHF()" disabled />
                    </div>

                    <div class="species">
                        <div class="form-inline">
                            <p class="form-control-static">
                                <kh>ហ្វាល់ស៊ីប៉ារ៉ូម</kh> (PF)
                            </p>
                            <input type="text" min="0" class="form-control input-sm font14" data-bind="value: getPFByHF()" disabled />
                        </div>
                        <div class="form-inline">
                            <p class="form-control-static">
                                <kh>វីវ៉ាក់</kh> (PV)
                            </p>
                            <input type="text" min="0" class="form-control input-sm font14" data-bind="value: getPVByHF()" disabled />
                        </div>
                        <div class="form-inline">
                            <p class="form-control-static">
                                <kh>ចម្រុះ</kh> (Mix)
                            </p>
                            <input type="text" class="form-control input-sm font14" data-bind="value: getMixByHF()" disabled />
                        </div>
                    </div>

                    <div class="form-inline">
                        <p class="form-control-static">
                            <kh>អវិជ្ជមាន</kh> (Negative Cases)
                        </p>
                        <input type="text" class="form-control input-sm font14" data-bind="value: getNegativeByHF()" disabled />
                    </div>
                </div>
            </div>
        </div>

    </div>
	<div class="panel-footer text-center">
		<button class="btn btn-primary btn-sm width150" data-bind="click: saveReport, visible: app.user.permiss['Health Center Data Accuracy'].contain('Edit')">Save</button>
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

<?=latestJs('/media/ViewModel/HFDataAccuracy.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>