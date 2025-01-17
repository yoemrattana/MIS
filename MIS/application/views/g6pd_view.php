<style>
	thead { background-color: #9AD8ED;}
    th { text-align:center}
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
</style>

<div class="panel panel-default">
	<div class="panel-heading clearfix">
		
		<div class="pull-left font16 lh28">
			<b>G6PD Investigation Form</b>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click:save, visible: app.user.permiss['Health Center Data'].contain('Edit')">Save</button>
			<button class="btn btn-danger btn-sm width100" data-bind="click: $root.delete, visible: $root.has() &amp;&amp; app.user.permiss['Health Center Data'].contain('Delete')">Delete</button>
			<button class="btn btn-default btn-sm width100" onclick="window.close()" style="margin-left:30px">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<table id="tblcase" class="table table-bordered table-striped table-hover">
			<thead>
                <tr>
                    <th colspan="7"​​><kh>អ្នកជំងឺ</kh></th>
                    <th colspan="2"​​><kh>ការធ្វើរោគវិនិឆ្ឆ័យជំងឺគ្រុនចាញ់</kh></th>
                    <th colspan="2"​​><kh>តេស្តG6PD</kh></th>
                    <th colspan="5"​​><kh>ប្រសិនបើលទ្ធផលតេស្ត​ G6PM ធម្មតា</kh></th>
                    <th><kh>ខលតាមដាន</kh></th>
                    <th colspan="12"​​><kh>រោគសញ្ញា</kh></th>
                </tr>
                <tr>
                    <th width="40">#</th>
					<th><kh>ប្រភេទមេរោគ</kh></th>
                    <th><kh>កាលបរិឆ្ឆទ</kh></th>
                    <th width="100"><kh>ឈ្មោះ</kh></th>
					<th width="100"><kh>ភេទ</kh></th>
                    <th width="100"><kh>អាយុ</kh></th>
                    <th width="100"><kh>ទំងន់</kh></th>
                    
                    <th colspan="2"​​ ><kh>ឈ្មោះទីតាំងផ្តល់សេវាគ្រុនចាញ់</kh></th>
                    <th colspan="2"​​ ><kh>លទ្ទផលតេស្ត</kh></th>
                    <th ><kh>ការប្រឹក្សា</kh></th>
                    <th ><kh>ASMQ</kh></th>
                    <th colspan="3"​​ ><kh>ការព្យាបាលរ៉ាឌីកាល់ដោយឱសថព្រីម៉ាគីន</kh></th>
                    <th><kh>លេខទូរស័ព្ធ</kh></th>
                    <th><kh>ថ្ងៃទី១</kh></th>
                    <th><kh>បញ្ជូន</kh></th​>
                    <th><kh>ថ្ងៃទី៣</kh></th​>
                    <th><kh>ទូរសព្ទ័ថ្ងៃទី៣</kh></th​>
                    <th><kh>បញ្ចូន</kh></th​>
                    <th><kh>ថ្ងៃទី៧</kh></th​>
                    <th><kh>ទូរសព្ទ័ថ្ងៃទី៧</kh></th​>
                    <th><kh>បញ្ចូន</kh></th​>
                    <th><kh>ថ្ងៃទី១៤</kh></th​>
                    <th><kh>ទូរសព្ទ័ថ្ងៃទី១៤</kh></th​>
                    <th><kh>ចំនួនគ្រាប់ថ្នាំ</kh></th​>
                    <th><kh>បញ្ចូន</kh></th​>
                </tr>
                <tr>
                    <th></th>
                    <th width="100"><kh>វីវ៉ាក់/ចម្រុះ</kh></th>
					<th width="100"><kh>ថ្ងៃ/ខែ/ឆ្នាំ</kh></th>
                    <th></th>
                    <th width="100"><kh>ប្រុស</kh></th>
                    <th width="100"><kh>ឆ្នាំ</kh></th>
                    <th width="100"><kh>គ.ក្រ</kh></th>
                    <th width="100"><kh>ឈ្មោះមណ្ខលសុខភាព</kh></th>
                    <th width="100"><kh>ឈ្មោះអ្នកស្ម័គ្រចិត្តភូមិ</kh></th>
                    <th  width="100"><kh>ធម្មតា</kh></th>
                    <th  width="100"><kh>ខ្វះ</kh></th>
                    <th  width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th  width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th  width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th  width="100"><kh>គ្រាប់15មក្រ</kh></th>
                    <th  width="100"><kh>គ្រាប់7,5មក្រ</kh></th>
                    <th></th>
                    <th width="100"><kh>កូដ #</kh></th>
                    <th width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th><kh>កូដ #</kh></th​>
                    <th width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th><kh>កូដ #</kh></th​>
                    <th width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th><kh>កូដ #</kh></th​>
                    <th width="100"><kh>បាទ/ចាស៎</kh></th>
                    <th width="100"><kh>សម្រាប់តែថ្ងៃទី១៤</kh></th>
                    <th width="100"><kh>បាទ/ចាស៎</kh></th>
                </tr>
			</thead>
            <tbody>
				<tr data-bind="with: $root.case">
                    <td></td>
					<td><input disabled type="text" data-bind="value: DiagnosisText"/></td>
                    <td><input disabled type="text" data-bind="value: DateCaseText"/></td>
                    <td><input disabled type="text" data-bind="value: NameK"/><input type="hidden" data-bind="value: HF"/></td>
                    <td><input disabled type="text" data-bind="value: Sex"/></td>
                    <td><input disabled type="text" data-bind="value: Age"/></td>
                    <td><input disabled type="text" data-bind="value: Weight"/></td>
                    <td><input disabled type="text" data-bind="value: Name_Facility_K"/></td>
                    <td><input disabled type="text" /></td>
                    <td><input type="radio" name="g6pd" value="Y" data-bind="checked: G6PD, event : {change : $root.radioChange} " /></td>
                    <td><input type="radio" name="g6pd" value="N" data-bind="checked: G6PD, event : {change : $root.radioChange}" /></td>
                    <!-- ko if: G6PD() == 'Y'-->
                    <td>
                        <select data-bind="value: Consult">
							<!-- ko if: Consult() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: ASMQ">
							<!-- ko if: ASMQ() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Primaquine">
							<!-- ko if: Primaquine() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td><input type="text" data-bind="value: Primaquine15" /></td>
                    <td><input type="text" data-bind="value: Primaquine75" /></td>
                    <!-- /ko -->
                    <!-- ko if: G6PD() == 'N' || G6PD() == null -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- /ko -->
                    <td><input type="text" data-bind="value: Phone" /></td>
                    <td>
                        <select data-bind="value: Day1Code">
							<!-- ko if: Day1Code() == '' -->
							<option></option>
							<!-- /ko -->
                            <option value="0">គ្មាន</option>
							<option value="1">ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង</option>
							<option value="2">ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដ្ហើមញាប់</option>
                            <option value="3">ជីបចរដើរញាប់, ញ័រដើមទ្រូវ, ចង្វាក់បេះដូងកើនឡើង</option>
							<option value="4">ចុករោយខ្នង</option>
                            <option value="5">ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day1Refered">
							<!-- ko if: Day1Refered() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day3Code">
							<!-- ko if: Day3Code() == '' -->
							<option></option>
							<!-- /ko -->
                            <option value="0">គ្មាន</option>
							<option value="1">ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង</option>
							<option value="2">ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដ្ហើមញាប់</option>
                            <option value="3">ជីបចរដើរញាប់, ញ័រដើមទ្រូវ, ចង្វាក់បេះដូងកើនឡើង</option>
							<option value="4">ចុករោយខ្នង</option>
                            <option value="5">ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day3Call">
							<!-- ko if: Day3Call() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day3Refered">
							<!-- ko if: Day3Refered() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day7Code">
							<!-- ko if: Day7Code() == '' -->
							<option></option>
							<!-- /ko -->
                            <option value="0">គ្មាន</option>
							<option value="1">ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង</option>
							<option value="2">ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដ្ហើមញាប់</option>
                            <option value="3">ជីបចរដើរញាប់, ញ័រដើមទ្រូវ, ចង្វាក់បេះដូងកើនឡើង</option>
							<option value="4">ចុករោយខ្នង</option>
                            <option value="5">ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day7Call">
							<!-- ko if: Day7Call() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day7Refered">
							<!-- ko if: Day7Refered() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day14Code">
							<!-- ko if: Day14Code() == '' -->
							<option></option>
							<!-- /ko -->
                            <option value="0">គ្មាន</option>
							<option value="1">ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង</option>
							<option value="2">ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដ្ហើមញាប់</option>
                            <option value="3">ជីបចរដើរញាប់, ញ័រដើមទ្រូវ, ចង្វាក់បេះដូងកើនឡើង</option>
							<option value="4">ចុករោយខ្នង</option>
                            <option value="5">ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)</option>
						</select>
                    </td>
                    <td>
                        <select data-bind="value: Day14Call">
							<!-- ko if: Day14Call() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>
                    <td><input type="text" data-bind="value: Day14Tablet" /></td>
                    <td>
                        <select data-bind="value: Day14Refered">
							<!-- ko if: Day14Refered() == '' -->
							<option></option>
							<!-- /ko -->
							<option value="Y">Yes</option>
							<option value="N">No</option>
						</select>
                    </td>                   
				</tr>
			</tbody>
		</table>
	</div>
    <div class="panel-footer text-center">
		<button class="btn btn-primary btn-sm width150" data-bind="click:save">Save</button>
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
<?=latestJs('/media/ViewModel/g6pd.js')?>