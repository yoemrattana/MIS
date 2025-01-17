<style>
	.space { margin-left: 15px; }
	.bootstrap-datetimepicker-widget { font-family: sans-serif; }
	[data-bind*=datePicker] { font-family: sans-serif; text-align: center; width: 150px !important; }
	.underscore { width: 70px; text-align: center; display: inline-block; border-bottom: 1px solid; font-weight: bold; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list'">
			<div class="inlineblock">
				<div class="text-bold">Province</div>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length == 1 ? undefined : 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">OD</div>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: odList().length == 1 ? undefined : 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">HC</div>
				<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">Year</div>
				<select class="form-control" data-bind="value: year, options: yearList"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">Month</div>
				<select class="form-control" data-bind="value: month, options: monthList, optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">Filter</div>
				<select class="form-control" data-bind="value: filter">
					<option>All</option>
					<option>Has Form</option>
				</select>
			</div>
			<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: save, visible: view() == 'detail' && ifcan('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back, visible: view() == 'detail'">Back</button>

			<button class="btn btn-success" data-bind="click: exportExcel, visible: view() == 'list'">Export Excel</button>
			<a href="/Home" class="btn btn-default" data-bind="visible: view() == 'list'">Home</a>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: view() == 'list' && loaded()">
		<table class="table table-bordered table-hover">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center" sortable>Province</th>
					<th align="center" sortable>OD</th>
					<th align="center" sortable>Health Facility</th>
					<th align="center" sortable>Patient Name</th>
					<th align="center" sortable>Diagnosis Date</th>
					<th align="center" sortable>Age</th>
					<th align="center" sortable>Sex</th>
					<th align="center" sortable>Species</th>
					<th align="center" sortable>Month</th>
					<th align="center" sortable>Has Form</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60" data-bind="visible: $root.ifcan('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
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
					<td align="center" data-bind="text: HasForm == 1 ? '✔' : ''"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="if: HasForm == 1, visible: $root.ifcan('Delete')">
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
		<div class="kh fit-content relative" style="margin:auto" data-bind="with: editModel">
			<h3 class="text-center text-primary" style="text-decoration:underline">
				<b>ទម្រង់របាយការណ៍បន្ថែម</b> (ការតាមដាន អង្កេត និងឆ្លើយតប)
			</h3>
			<br />
			<p class="text-bold">1. ការតាមដានការព្យាបាលជំងឺគ្រុនចាញ់ ពីថ្ងៃទី១ដល់ទី២៨</p>
			<div style="border:1px solid gray; padding:10px">
				<!-- ko with: displayOnly -->
				<p class="text-bold">ពត៌មានទូទៅ៖</p>
				<p class="form-inline" style="padding-left:40px">
					<span>មណ្ឌលសុខភាព</span>
					<input type="text" class="form-control en" data-bind="value: HC" readonly />
					<span class="space">ស្រុកប្រតិបត្តិ</span>
					<input type="text" class="form-control en" data-bind="value: OD" readonly />
					<span class="space">ខេត្ត</span>
					<input type="text" class="form-control en" data-bind="value: Prov" readonly />
				</p>
				<p class="form-inline" style="padding-left:40px">
					<span>អ្នកជំងឺឈ្មោះ</span>
					<input type="text" class="form-control" data-bind="value: PatientName" readonly />
					<span class="space">លេខកូដសំគាល់ករណី (យកចេញពីទំរង់អង្កេត)</span>
					<input type="text" class="form-control" data-bind="value: CaseCode" readonly />
				</p>
				<!-- /ko -->

				<!-- ko with: data.Detail -->
				<p class="form-inline" style="padding-left:40px" data-bind="with: SickAddress">
					<span style="display:inline-block; width:200px">អាស័យដ្ឋានកំពុងស្នាក់នៅពេលឈឺ៖</span>
					<span>ខេត្ត</span>
					<select data-bind="value: pvcode, options: $root.pvList2(), optionsValue: 'code', optionsText: 'name'" class="form-control width150"></select>
					<span class="space">ស្រុក</span>
					<select data-bind="value: dscode, options: $root.dsList(pvcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150"></select>
					<span class="space">ឃុំ</span>
					<select data-bind="value: cmcode, options: $root.cmList(dscode), optionsValue: 'code', optionsText: 'name'" class="form-control width150"></select>
					<span class="space">ភូមិ</span>
					<select data-bind="value: vlcode, options: $root.vlList(cmcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150"></select>
				</p>
				<p class="form-inline" style="padding-left:40px" data-bind="with: SickAddress">
					<span style="display:inline-block; width:200px"></span>
					<span>ផ្សេង</span>
					<input type="text" data-bind="value: other" class="form-control" style="width:727px" />
				</p>
				<p class="form-inline" style="padding-left:40px" data-bind="with: Address">
					<span style="display:inline-block; width:200px">អាស័យដ្ឋានអចិន្ត្រៃយ៍៖</span>
					<span>ខេត្ត</span>
					<select data-bind="value: pvcode, options: $root.pvList2(), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ស្រុក</span>
					<select data-bind="value: dscode, options: $root.dsList(pvcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ឃុំ</span>
					<select data-bind="value: cmcode, options: $root.cmList(dscode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ភូមិ</span>
					<select data-bind="value: vlcode, options: $root.vlList(cmcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
				</p>
				<p class="form-inline" style="padding-left:40px" data-bind="with: Address">
					<span style="display:inline-block; width:200px"></span>
					<span>ផ្សេង</span>
					<input type="text" data-bind="value: other" class="form-control" style="width:727px" />
				</p>

				<p class="text-bold">កត់ត្រាភូមិទាំងឡាយដែលអ្នកជំងឺបានស្នាក់នៅ ឬឆ្លងកាត់ពេលយប់ ក្នុងអំឡុងពេល២សប្តាហ៍ចុងក្រោយ៖</p>
				<p class="form-inline" style="padding-left:40px" data-bind="with: Week1A">
					<span style="display:inline-block; width:200px">សប្តាយ៍ទី១:</span>
					<span>ខេត្ត</span>
					<select data-bind="value: pvcode, options: $root.pvList2(), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ស្រុក</span>
					<select data-bind="value: dscode, options: $root.dsList(pvcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ឃុំ</span>
					<select data-bind="value: cmcode, options: $root.cmList(dscode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ភូមិ</span>
					<select data-bind="value: vlcode, options: $root.vlList(cmcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
				</p>
				<p class="form-inline" style="padding-left:40px" data-bind="with: Week1A">
					<span style="display:inline-block; width:200px"></span>
					<span>ផ្សេង</span>
					<input type="text" data-bind="value: other" class="form-control" style="width:727px" />
				</p>

				<p class="form-inline" style="padding-left:40px" data-bind="with: Week1B">
					<span style="display:inline-block; width:200px"></span>
					<span>ខេត្ត</span>
					<select data-bind="value: pvcode, options: $root.pvList2(), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ស្រុក</span>
					<select data-bind="value: dscode, options: $root.dsList(pvcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ឃុំ</span>
					<select data-bind="value: cmcode, options: $root.cmList(dscode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ភូមិ</span>
					<select data-bind="value: vlcode, options: $root.vlList(cmcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
				</p>
				<p class="form-inline" style="padding-left:40px" data-bind="with: Week1B">
					<span style="display:inline-block; width:200px"></span>
					<span>ផ្សេង</span>
					<input type="text" data-bind="value: other" class="form-control" style="width:727px" />
				</p>

				<p class="form-inline" style="padding-left:40px" data-bind="with: Week2A">
					<span style="display:inline-block; width:200px">សប្តាយ៍ទី២:</span>
					<span>ខេត្ត</span>
					<select data-bind="value: pvcode, options: $root.pvList2(), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ស្រុក</span>
					<select data-bind="value: dscode, options: $root.dsList(pvcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ឃុំ</span>
					<select data-bind="value: cmcode, options: $root.cmList(dscode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ភូមិ</span>
					<select data-bind="value: vlcode, options: $root.vlList(cmcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
				</p>
				<p class="form-inline" style="padding-left:40px" data-bind="with: Week2A">
					<span style="display:inline-block; width:200px"></span>
					<span>ផ្សេង</span>
					<input type="text" data-bind="value: other" class="form-control" style="width:727px" />
				</p>

				<p class="form-inline" style="padding-left:40px" data-bind="with: Week2B">
					<span style="display:inline-block; width:200px"></span>
					<span>ខេត្ត</span>
					<select data-bind="value: pvcode, options: $root.pvList2(), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ស្រុក</span>
					<select data-bind="value: dscode, options: $root.dsList(pvcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ឃុំ</span>
					<select data-bind="value: cmcode, options: $root.cmList(dscode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
					<span class="space">ភូមិ</span>
					<select data-bind="value: vlcode, options: $root.vlList(cmcode), optionsValue: 'code', optionsText: 'name'" class="form-control width150 en"></select>
				</p>
				<p class="form-inline" style="padding-left:40px" data-bind="with: Week2B">
					<span style="display:inline-block; width:200px"></span>
					<span>ផ្សេង</span>
					<input type="text" data-bind="value: other" class="form-control" style="width:727px" />
				</p>

				<p class="text-bold">ការធ្វើរោគវិនិច្ឆ័យនិងតាមដាន៖</p>
				<p class="form-inline" style="padding-left:20px">
					<b>ការធ្វើរោគវិនិច្ឆ័យនៅថ្ងៃទី១៖</b>
					<input type="text" class="form-control" data-bind="datePicker: DiagnosisDate, dataType: 'string', showClear: true" />

					<span class="space">ថ្ងៃក្តៅខ្លួនដំបូង៖</span>
					<input type="text" class="form-control" data-bind="datePicker: FeverDate, dataType: 'string', showClear: true" />
				</p>
				<div class="form-group form-inline" style="padding-left:40px">
					<span>ឧបករណ៍ធ្វើរោគវិនិច្ឆ័យ</span>
					<select class="form-control" data-bind="value: DiagnosticTool">
						<option></option>
						<option value="RDT">តេស្តរហ័ស</option>
						<option value="Microscope">មីក្រូទស្សន៍</option>
					</select>
					<span>៖</span>
					<select class="form-control en" data-bind="value: Species">
						<option></option>
						<option>Pf</option>
						<option>Pv</option>
						<option>Mix</option>
						<option>Pm</option>
						<option>Po</option>
						<option>Pk</option>
						<option>Negative</option>
					</select>

					<span class="space">បើវិជ្ជមានដោយមេរោគហ្វាល់ស៊ីប៉ារ៉ូម/ចំរុះ ដង់ស៊ីតេប៉ារ៉ាស៊ីតគឺ</span>
					<div class="input-group">
						<input type="text" class="form-control width100 text-center" data-bind="value: MicroscopeIncidence" />
						<span class="input-group-addon">/μl</span>
					</div>
				</div>

				<p style="padding-left:20px">
					<b>ការព្យាលដោយវិធីសាស្ត្រដូត</b> (ពិនិត្យមើលអ្នកជំងឺលេបថ្នាំដោយផ្ទាល់)៖
				</p>
				<div class="form-group form-inline" style="padding-left:40px">
					<span>ដូតថ្ងៃទី១៖</span>
					<input type="text" class="form-control" data-bind="datePicker: Dot1.Date, dataType: 'string', showClear: true" />
					<span>ម៉ោង</span>
					<input type="text" class="form-control width100" data-bind="value: Dot1.Time" />
					<span>ចំនួនគ្រាប់ថ្នាំ</span>
					<input type="text" class="form-control width100" data-bind="value: Dot1.Drug" />
					<span>គ្រាប់</span>

					<select class="form-control" data-bind="value: Dot1.Receive" style="margin-left:100px">
						<option></option>
						<option value="Yes">បាន</option>
						<option value="No">មិនបាន</option>
					</select>
				</div>
				<div class="form-group form-inline" style="padding-left:40px">
					<span>ដូតថ្ងៃទី២៖</span>
					<input type="text" class="form-control" data-bind="datePicker: Dot2.Date, dataType: 'string', showClear: true" />
					<span>ម៉ោង</span>
					<input type="text" class="form-control width100" data-bind="value: Dot2.Time" />
					<span>ចំនួនគ្រាប់ថ្នាំ</span>
					<input type="text" class="form-control width100" data-bind="value: Dot2.Drug" />
					<span>គ្រាប់</span>

					<select class="form-control" data-bind="value: Dot2.Receive" style="margin-left:100px">
						<option></option>
						<option value="Yes">បាន</option>
						<option value="No">មិនបាន</option>
					</select>
				</div>
				<div class="form-group form-inline" style="padding-left:40px">
					<span>ដូតថ្ងៃទី៣៖</span>
					<input type="text" class="form-control" data-bind="datePicker: Dot3.Date, dataType: 'string', showClear: true" />
					<span>ម៉ោង</span>
					<input type="text" class="form-control width100" data-bind="value: Dot3.Time" />
					<span>ចំនួនគ្រាប់ថ្នាំ</span>
					<input type="text" class="form-control width100" data-bind="value: Dot3.Drug" />
					<span>គ្រាប់</span>

					<select class="form-control" data-bind="value: Dot3.Receive" style="margin-left:100px">
						<option></option>
						<option value="Yes">បាន</option>
						<option value="No">មិនបាន</option>
					</select>
				</div>
				<p class="form-inline" style="padding-left:40px">
					<span>បើដូតមិនពេញលេញ សូមបញ្ចាក់ពីមូលហេតុ៖</span>
					<input type="text" class="form-control" style="width:770px" data-bind="value: DotReason" />
				</p>

				<p style="padding-left:20px">
					<b>ការតាមដានការព្យាបាលនៅថ្ងៃទី២៨៖</b>
					<b style="color:orange">គ្រប់អ្នកជំងឺដែលមានមេរោគប្រភេទហ្វាល់ស៊ីប៉ារ៉ូម និងចំរុះ ត្រូវធ្វើកញ្ចក់ឈាមនៅថ្ងៃទី២៨ជាចាំបាច់។</b>
				</p>
				<p class="form-inline" style="padding-left:40px">
					<span>កាលបរិច្ឆេទការតាមដាននៅថ្ងៃទី២៨៖</span>
					<input type="text" class="form-control" data-bind="datePicker: Day28, dataType: 'string', showClear: true" />
				</p>
				<div class="form-inline form-group" style="padding-left:40px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="MetPatient" value="No" data-bind="checked: MetPatient" />
							<span>មិនជួបអ្នកជំងឺ ➜ មូលហេតុ៖</span>
						</label>
					</div>
					<input type="text" class="form-control" style="width:400px" data-bind="value: NoMetReason" />
					<span>(បញ្ចាក់ការតាមដានត្រឹមនេះ)</span>

					<div class="radio-inline radio-lg" style="margin-left:100px">
						<label>
							<input type="radio" name="MetPatient" value="Yes" data-bind="checked: MetPatient" />
							<span>ជួបអ្នកជំងឺ ➜ សំនួរបន្ទាប់</span>
						</label>
					</div>
				</div>
				<div class="form-inline form-group" style="padding-left:40px">
					<span>រោគសញ្ញា៖ កំដៅខ្លួន(វាស់ផ្ទាល់)</span>
					<input type="text" class="form-control width100" data-bind="value: Temperature" />
					<span>អង្សាសេ (°C)</span>

					<span style="margin-left:50px">ចំនួនថ្ងៃអ្នកជំងឺមានសញ្ញាដំអូញថ្មីបន្ទាប់ពីថ្ងៃទី៣៖ ក្តៅ</span>
					<input type="text" class="form-control width100" data-bind="value: Hot" />
					<span>ថ្ងៃ</span>
				</div>
				<div class="form-inline form-group" style="padding-left:40px">
					<span>រងារញាក់</span>
					<input type="text" class="form-control width100" data-bind="value: Cold" />
					<span>ថ្ងៃ</span>

					<span class="space">បែកញើស</span>
					<input type="text" class="form-control width100" data-bind="value: Sweat" />
					<span>ថ្ងៃ</span>

					<span class="space">ឈឺក្បាល</span>
					<input type="text" class="form-control width100" data-bind="value: Headache" />
					<span>ថ្ងៃ</span>

					<span class="space">រោគសញ្ញាផ្សេងទៀត</span>
					<input type="text" class="form-control" style="width:300px" data-bind="value: OtherSymptom" />
				</div>
				<div class="form-inline form-group" style="padding-left:40px">
					<span>ការធ្វើកញ្ចក់ឈាម៖ លទ្ធផលកញ្ចក់៖</span>
					<select class="form-control" data-bind="value: Result">
						<option></option>
						<option value="Pf">ហ្វាល់ស៊ីប៉ារ៉ូម</option>
						<option value="Mix">ចំរុះ</option>
						<option value="Pv">វីវ៉ាក់</option>
						<option value="Negative">អវិជ្ជមាន</option>
					</select>

					<span class="space">(ដង់ស៊ីតេប៉ារ៉ាស៊ីតគឺ</span>
					<input type="text" class="form-control width100" data-bind="value: MixIncidence" />
					<span>/μl)</span>
				</div>
				<div class="form-inline form-group" style="padding-left:40px">
					<span style="margin-left:113px">ហ្គាម៉ែត្រតូស៊ីត៖</span>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="Gametocyte" value="Positive" data-bind="checked: Gametocyte" />
							<span>វិជ្ជមាន</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="Gametocyte" value="Negative" data-bind="checked: Gametocyte" />
							<span>អវិជ្ចមាន</span>
						</label>
					</div>
				</div>

				<p>
					<b style="color:orangered; display:inline-block; width:60px">សំគាល់៖</b>
					<b style="color:orange">
						<i>- បើអ្នកជំងឺនៅមានរោគសញ្ញាដូចខាងលើ ចន្លោះថ្ងៃទី៣និងថ្ងៃទី២៨ ត្រូវមកជួបអ្នកផ្តល់សេវាវិញ</i>
					</b>
				</p>
				<p>
					<span style="color:orangered; display:inline-block; width:60px"></span>
					<b style="color:orange">
						<i>- បើតេស្តវិជ្ជមានថ្ងៃទី២៨ ត្រូវបញ្ចូនអ្នកជំងឺទៅមន្ទីរពេទ្យ ដើម្បីធ្វើការព្យាបាលដោយថ្នាំជំរើសទី២</i>
					</b>
				</p>
				<!-- /ko -->
			</div>
			<br />

			<!-- ko with: data.Detail -->
			<p class="text-bold">2. តារាងរបាយការណ៍សង្ខេបសកម្មភាពឆ្លើយតប</p>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th align="center" rowspan="2">សូចនាករ</th>
						<th align="center" colspan="2">ផ្ទះករណីគោល</th>
						<th align="center" colspan="2">អ្នករួមដំណើរ</th>
						<th align="center" colspan="2">(*) ចំនួនខ្នងផ្ទះជុំវិញករណីគោល</th>
						<th align="center" rowspan="2">កំណត់សំគាល់</th>
					</tr>
					<tr data-bind="foreach: Array(3)">
						<th align="center" width="100">ប្រុស</th>
						<th align="center" width="100">ស្រី</th>
					</tr>
				</thead>
				<tbody>
					<tr data-bind="with: Member">
						<td>ចំនួនសមាជិកសរុប</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: MetMember">
						<td>ចំនួនសមាជិកដែលបានជួបសរុប</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td>(*) ចំនួនបានជួប</td>
					</tr>
					<tr data-bind="with: Test">
						<td>ចំនួនករណីបានធ្វើតេស្តសរុប</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td>(*) តេស្តតែករណីសង្ស័យ</td>
					</tr>
					<tr data-bind="with: Positive">
						<td>ចំនួនករណីវិជ្ចមានសរុប</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: Pf">
						<td align="right">ប្រភេទ ហ្វាល់ស៊ីប៉ារ៉ូម (Pf) សរុប</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: Pv">
						<td align="right">ប្រភេទ វីវ៉ាក់ (Pv) សរុប</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: Mix">
						<td align="right">ប្រភេទ ចំរុះ (Mix) សរុប</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: Treated">
						<td>ចំនួនករណីដែលបានព្យាបាលសរុប</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: Educated">
						<td>ចំនួនប្រជាជនសរុបដែលបានទទួលការអប់រំ</td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: House.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: Traveler.Female" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Male" numonly="int" /></td>
						<td><input type="text" class="input-block text-center" data-bind="textInput: HouseQty.Female" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: HouseLLIN100">
						<td>ចំនួនផ្ទះដែលមាន LLINs គ្របដណ្តប់ 100%</td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: House" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: Traveler" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: HouseQty" numonly="int" /></td>
						<td rowspan="2" valign="middle">
							មុង១សំរាប់១.៨នាក់ ចំពោះអ្នកភូមិ
							<br />មុង១សំរាប់១នាក់ ចំពោះអ្នកចំនាកស្រុក
						</td>
					</tr>
					<tr data-bind="with: HouseLLINLess100">
						<td>ចំនួនផ្ទះដែលមាន LLINs គ្របដណ្តប់ &lt;100%</td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: House" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: Traveler" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: HouseQty" numonly="int" /></td>
					</tr>
					<tr data-bind="with: LLIN">
						<td>ចំនួនមុងគ្រែជ្រលក់ថ្នាំបានចែក (LLINs)</td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: House" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: Traveler" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: HouseQty" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: LLIHN">
						<td>ចំនួនមុងអង្រឹងជ្រលក់ថ្នាំបានចែក (LLIHNs)</td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: House" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: Traveler" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: HouseQty" numonly="int" /></td>
						<td></td>
					</tr>
					<tr data-bind="with: Repellent">
						<td>ចំនួនថ្នាំបណ្តេញមូសបានចែក</td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: House" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: Traveler" numonly="int" /></td>
						<td colspan="2"><input type="text" class="input-block text-center" data-bind="textInput: HouseQty" numonly="int" /></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<br />

			<div style="border:1px solid; padding:10px">
				<p class="text-bold">របាយការណ៍សង្ខេប</p>
				<p>
					<span>ចំនួនសមាជិកសរុប ប្រុស</span>
					<span class="underscore" data-bind="text: $root.getTotal('Member','Male')"></span>
					<span>ស្រី</span>
					<span class="underscore" data-bind="text: $root.getTotal('Member','Female')"></span>

					<span>ចំនួនអវត្តមាន ប្រុស</span>
					<span class="underscore" data-bind="text: $root.getTotal('MetMember','Male')"></span>
					<span>ស្រី</span>
					<span class="underscore" data-bind="text: $root.getTotal('MetMember','Female')"></span>

					<span>ចំនួនអ្នកដែលបានធ្វើតេស្ត ប្រុស</span>
					<span class="underscore" data-bind="text: $root.getTotal('Test','Male')"></span>
					<span>ស្រី</span>
					<span class="underscore" data-bind="text: $root.getTotal('Test','Female')"></span>
				</p>
				<p>
					<span>ចំនួនវិជ្ជមាន ប្រុស</span>
					<span class="underscore" data-bind="text: $root.getTotal('Positive','Male')"></span>
					<span>ស្រី</span>
					<span class="underscore" data-bind="text: $root.getTotal('Positive','Female')"></span>

					<span>ចំនួនអ្នកដែលទទួលបានការអប់រំ ប្រុស</span>
					<span class="underscore" data-bind="text: $root.getTotal('Educated','Male')"></span>
					<span>ស្រី</span>
					<span class="underscore" data-bind="text: $root.getTotal('Educated','Female')"></span>
				</p>
				<p>
					<span>ចំនួនមុងជ្រលក់ថ្នាំដែលបានចែក មុងគ្រែ</span>
					<span class="underscore" data-bind="text: $root.getTotal('LLIN')"></span>
					<span>មុងអង្រឹង</span>
					<span class="underscore" data-bind="text: $root.getTotal('LLIHN')"></span>

					<span>ចំនួនថ្នាំបណ្តេញមូសដែលបានចែក</span>
					<span class="underscore" data-bind="text: $root.getTotal('Repellent')"></span>
				</p>
			</div>
			<br />

			<p class="form-inline">
				<b>អ្នកធ្វើរបាយការណ៍</b>
				<span>(មណ្ឌលសុខភាពដោយមានជំនួយពីអ្នកស្ម័គ្រចិត្ត)៖</span>
				<b>ឈ្មោះ</b>
				<input type="text" class="form-control" data-bind="value: Reporter" style="width:400px" />
			</p>
			<!-- /ko -->
		</div>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && ifcan('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<?=latestJs('/media/ViewModel/RCD_CMEP.js')?>