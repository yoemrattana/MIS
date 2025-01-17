<style>
	.bootstrap-datetimepicker-widget { font-family: sans-serif; }
</style>

<div class="panel panel-default" data-bind="visible: view() == 'report'" style="display:none">
	<div class="panel-heading clearfix relative">
		<div class="pull-center form-inline">
			<div class="input-group width150">
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
			<select data-bind="value: od,
					options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: odList().length == 1 ? undefined : 'Select OD'"
				class="form-control minwidth150"></select>
		</div>
		<div class="pull-left font16 lh34">
			<b>PPM Referral Slip</b>
		</div>
		<div class="pull-right">
			<button class="btn btn-success" data-bind="click: exportExcel">Export Excel</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table id="tblreport" class="table table-bordered table-striped table-hover">
			<thead class="bg-thead">
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Heath Facility</th>
					<th>Khmer Name</th>
					<!-- ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: reportList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Facility_K" class="kh"></td>
					<!-- ko foreach: reports -->
					<th class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? '✔' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.showList,
						   visible: $root.visibleReport($data)" style="padding-top:2px"></a>
					</th>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="visible: view() == 'list'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: ifcan('Edit')">New</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-bordered">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center">Card Number</th>
					<th align="center">Service Person</th>
					<th align="center">Private Service</th>
					<th align="center">Patient Name</th>
					<th align="center">Referred Date</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60" data-bind="visible: ifcan('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: Card, css: { kh: iskhmer(Card) }"></td>
					<td data-bind="text: ServicePerson, css: { kh: iskhmer(ServicePerson) }"></td>
					<td data-bind="text: PrivateService, css: { kh: iskhmer(PrivateService) }"></td>
					<td data-bind="text: PatientName, css: { kh: iskhmer(PatientName) }"></td>
					<td data-bind="text: moment(ReferredDate).displayformat()" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: $root.ifcan('Delete')">
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
</div>

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: save, visible: ifcan('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body kh" data-bind="with: editModel">
		<div class="form-group form-inline">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ប័ណ្ណលេខ</span>
					<input type="text" class="form-control" data-bind="value: Card" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ឈ្មោះអ្នកផ្លល់សេវា</span>
					<input type="text" class="form-control" data-bind="value: ServicePerson" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ឈ្មោះសេវាឯកជន</span>
					<input type="text" class="form-control" data-bind="value: PrivateService" />
				</div>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ខេត្ត</span>
					<select class="form-control en" data-bind="value: pv1, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ស្រុក</span>
					<select class="form-control en minwidth150" data-bind="value: ds, options: dsList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ឃុំ</span>
					<select class="form-control en minwidth150" data-bind="value: cm, options: cmList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ភូមិ</span>
					<select class="form-control en minwidth150" data-bind="value: Code_Vill_T, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				</div>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">មូលដ្ឋានសុខាភិបាលដែលនៅជិត</span>
					<input type="text" class="form-control" data-bind="value: NearbyHF" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ខេត្ត</span>
					<select class="form-control en" data-bind="value: pv2, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ស្រុកប្រតិបត្តិ</span>
					<select class="form-control en minwidth150" data-bind="value: Code_OD_T, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				</div>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">បញ្ចូនអ្នកជំងឺសង្ស័យគ្រុនចាញ់ឈ្មោះ</span>
					<input type="text" class="form-control" data-bind="value: PatientName" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ភេទ</span>
					<select class="form-control" data-bind="value: Sex">
						<option></option>
						<option value="M">ប្រុស</option>
						<option value="F">ស្រី</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">អាយុ</span>
					<input type="number" class="form-control width100 text-center" data-bind="value: Age" min="1" max="150" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ផ្ទៃពោះ</span>
					<select class="form-control" data-bind="value: Pregnant">
						<option></option>
						<option value="1">មាន</option>
						<option value="0">គ្មាន</option>
					</select>
				</div>
			</div>
		</div>
		<p>ដែលមានរោគសញ្ញា និង/ឬ ប្រវត្តិជំងឺដូចខាងក្រោម (ជ្រើសរើសច្រើនជាងមួយ)៖</p>
		<table class="table widthauto">
			<tr>
				<td>រោគសញ្ញាចំបង៖</td>
				<td>រោគសញ្ញាបន្ទាប់បន្សំ៖</td>
				<td>ប្រវត្តិអ្នកជំងឺថ្មីៗ៖</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Fever" data-bind="checked: Symptom" />
							<span>គ្រុនក្តៅ</span>
						</label>
					</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Heachache" data-bind="checked: Symptom" />
							<span>ឈឺក្បាល</span>
						</label>
					</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Just came from the forest" data-bind="checked: Symptom" />
							<span>ទើបតែមកពីក្នុងព្រៃ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Chills" data-bind="checked: Symptom" />
							<span>រងារញាក់</span>
						</label>
					</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Nausea" data-bind="checked: Symptom" />
							<span>ចង្អោរ</span>
						</label>
					</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Live or have just traveled to a malaria area" data-bind="checked: Symptom" />
							<span>រស់នៅ ឬទើបតែធ្វើដំណើរទៅកាន់តំបន់គ្រុនចាញ់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Sweating" data-bind="checked: Symptom" />
							<span>បែកញើស</span>
						</label>
					</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Vomiting" data-bind="checked: Symptom" />
							<span>ក្អួត</span>
						</label>
					</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Have had malaria in the past 28 days" data-bind="checked: Symptom" />
							<span>ធ្លាប់មានជំងឺគ្រុនចាញ់ក្នុងរយៈពេល២៨ថ្ងៃកន្លងមក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Severe malaria symptoms" data-bind="checked: Symptom" />
							<span>រោគសញ្ញាគ្រុនចាញ់ធ្ងន់ធ្ងរ*</span>
						</label>
					</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Diarrhea" data-bind="checked: Symptom" />
							<span>រាគ</span>
						</label>
					</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Live or work with other malaria patients" data-bind="checked: Symptom" />
							<span>រស់នៅ ឬធ្វើការជាមួយអ្នកជំងឺគ្រុនចាញ់ផ្សេងទៀត</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="form-inline no-padding-left">
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="symptom" value="Other" data-bind="checked: Symptom" />
							<span>ផ្សេងទៀត</span>
						</label>
					</div>
					<input type="text" class="form-control" style="width:800px" data-bind="value: OtherSymptom" />
				</td>
			</tr>
		</table>
		<br />
		<p style="text-decoration:underline">បញ្ជូនទៅកាន់មូលដ្ឋានសុខាភិបាលតែមួយក្នុងចំណោម៖</p>
		<div class="form-group form-inline">
			<div class="form-group">
				<select class="form-control" data-bind="value: ReferredHFType">
					<option></option>
					<option value="HP">ឈ្មោះប៉ុស្តិ៍សុខភាព</option>
					<option value="HC">ឈ្មោះមណ្ឌលសុខភាព</option>
					<option value="RH">ឈ្មោះមន្ទីរពេទ្យបង្អែក</option>
					<option value="PH">ឈ្មោះមន្ទីរពេទ្យខេត្ត</option>
					<option value="VMW">ឈ្មោះភូមិដែលមានអ្នកស្ម័គ្រចិត្ត</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" style="width:500px" data-bind="value: ReferredHFName" />
			</div>
		</div>
		<div class="form-group form-inline relative">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">បញ្ជូននៅថ្ងៃទី</span>
					<input type="text" class="form-control text-center width120 en" data-bind="datePicker: ReferredDate, dataType: 'string'" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ម៉ោង</span>
					<input type="text" class="form-control text-center width100 en" data-bind="value: ReferredTime" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">អ្នកជំងឺនេះមានអាការៈរោគខាងលើចាប់ពីថ្ងៃទី</span>
					<input type="text" class="form-control text-center width120 en" data-bind="datePicker: SymptomDate, dataType: 'string'" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">ប្រសិនផ្តល់ថ្នាំមុនបញ្ជូន សូមបញ្ជាក់ថ្នាំដែលផ្តល់អោយអ្នកជំងឺ</span>
				<input type="text" class="form-control" data-bind="value: MedicineName" />
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/PPMReferralSlip.js')?>