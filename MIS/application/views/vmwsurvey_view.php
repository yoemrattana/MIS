<style>
	.space-between > :not(:first-child) { margin-left:15px; }
	#headerbox { padding:15px; display:table; margin:0 auto; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list'">
			<div class="inlineblock">
				<div class="text-bold">Province</div>
				<select data-bind="value: pv,
					options: pvList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: pvList().length == 1 ? undefined : 'All'"
					class="form-control minwidth100"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">OD</div>
				<select data-bind="value: od,
					options: odList(),
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: odList().length == 1 ? undefined : 'All'"
					class="form-control minwidth100"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">HC</div>
				<select data-bind="value: hc,
					options: hcList(),
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All'"
					class="form-control minwidth100"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">Village</div>
				<select data-bind="value: vl,
					options: vlList(),
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All'"
					class="form-control minwidth100"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">Year</div>
				<select class="form-control" data-bind="value: year, options: yearList, optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">Month</div>
				<select class="form-control" data-bind="value: month, options: monthList, optionsCaption: 'All'"></select>
			</div>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'detail'">
			<button class="btn btn-primary width100" data-bind="click: save, visible: ifcan('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'list'">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: ifcan('Edit')">New</button>
			<button class="btn btn-success" data-bind="click: exportExcel">Export Excel</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered table-hover table-striped">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HC</th>
					<th align="center">Village</th>
					<th align="center">Auditor Name</th>
					<th align="center">Audit Date</th>
					<th align="center">VMW Name</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60" data-bind="visible: ifcan('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: AuditorName"></td>
					<td data-bind="text: moment(AuditDate).displayformat()" align="center"></td>
					<td data-bind="text: VMWName"></td>
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

	<div class="panel-body" data-bind="visible: view() == 'detail'">
		<h3 class="text-center text-primary kh">
			តារាងតាមដាន ត្រួតពិនិត្យមុងជ្រលក់ថ្នាំ និងអប់រំសុខភាពតាមខ្នងផ្ទះ/ចំការ
			<br />
			<br />
			ដោយអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់
		</h3>
		<br />

		<div id="headerbox" class="form-inline space-between thumbnail" data-bind="with: masterModel">
			<div class="input-group form-group">
				<span class="input-group-addon kh">ស្រុកប្រត្តិបត្តិ</span>
				<select data-bind="value: od,
							options: odList,
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: odList().length == 1 ? undefined : ''"
					class="form-control minwidth150"></select>
			</div>

			<div class="input-group form-group">
				<span class="input-group-addon kh">មណ្ឌលសុខភាព</span>
				<select data-bind="value: hc,
							options: hcList,
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: hcList().length == 1 ? undefined : ''"
					class="form-control minwidth150"></select>
			</div>

			<div class="input-group form-group">
				<span class="input-group-addon kh">ភូមិ</span>
				<select data-bind="value: Code_Vill_T,
							options: vlList,
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: vlList().length == 1 ? undefined : ''"
					class="form-control minwidth150"></select>
			</div>
		</div>
		<br />
		<br />

		<table class="table table-bordered table-responsive">
			<thead class="kh">
				<tr>
					<th rowspan="2" align="center" valign="middle">ល.រ</th>
					<th rowspan="2" align="center" valign="middle" width="200">ឈ្មោះអ្នកឆ្លើយ</th>
					<th rowspan="2" align="center" valign="middle">អាយុ (ឆ្នាំ)</th>
					<th rowspan="2" align="center" valign="middle" width="80">ភេទ</th>
					<th colspan="2" align="center" valign="middle">ចំនួនសមាជិកក្នុងគ្រួសារ/ចំការ</th>
					<th colspan="2" align="center" valign="middle">ចំនួនមុងជ្រលក់ថ្នាំដែលអាចប្រើបាន</th>
					<th rowspan="2" align="center" valign="middle">ហេតុអ្វីបានជាគ្រួសារអ្នកមិនមានមុងជ្រលក់ថ្នាំ?</th>
					<th rowspan="2" align="center" valign="middle">ក្នុងចំណោមសមាជិកក្នុងគ្រួសាររបស់អ្នក តើប៉ុន្មាននាក់ដែលបានគេងក្នុងមុងជ្រលក់ថ្នាំកាលពីយប់មិញ?</th>
					<th rowspan="2" align="center" valign="middle">តើសមាជិកគ្រួសារអ្នកគេងក្នុងមុងជ្រលក់ថ្នាំរាល់យប់ឬទេ?</th>
					<th rowspan="2" align="center" valign="middle">តើមានមុងជ្រលក់ថ្នាំបានចងព្យួរដែរឬទេ?</th>
					<th rowspan="2" align="center" valign="middle">ហេតុអ្វីបានជាអ្នក ឬក្រុមគ្រួសាររបស់អ្នកមិនប្រើប្រាស់មុងជ្រលក់ថ្នាំ?</th>
					<th rowspan="2" align="center" valign="middle">ចំនួនមុងដែលខូច</th>
					<th colspan="2" align="center" valign="middle">ចំនួនមុងបន្ថែម</th>
					<th rowspan="2" align="center" valign="middle">តើអ្នកនឹងប្រើប្រាស់មុងជ្រលក់ថ្នាំដោយរបៀបណា?</th>
					<th colspan="2" align="center" valign="middle">ចំនួនអ្នកទទួលបានការអប់រំ</th>
					<th rowspan="2" align="center" valign="middle"></th>
				</tr>
				<tr>
					<th align="center">អចិន្រ្តៃយ៍</th>
					<th align="center">ចល័ត</th>
					<th align="center">មុងគ្រែ</th>
					<th align="center">មុងអង្រឹង</th>
					<th align="center">មុងគ្រែ</th>
					<th align="center">មុងអង្រឹង</th>
					<th align="center">ប្រុស</th>
					<th align="center">ស្រី</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailModel, fixedHeader: true">
				<tr>
					<td align="center" valign="middle" data-bind="text: $index() + 1"></td>
					<td>
						<input type="text" class="form-control input-sm" data-bind="value: Name" />
					</td>
					<td>
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: Age" numonly="int" />
					</td>
					<td>
						<select class="form-control input-sm" data-bind="value: Sex">
							<option></option>
							<option>ប្រុស</option>
							<option>ស្រី</option>
						</select>
					</td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: Permanence" numonly="int" /></td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: Mobile" numonly="int" /></td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: UsableLLIN" numonly="int" /></td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: UsableLLIHN" numonly="int" /></td>
					<td>
						<select class="form-control input-sm" data-bind="value: NoBednet">
							<option></option>
							<option>មិនត្រូវការ</option>
							<option>មិនមានកន្លែងចង</option>
							<option>ពិបាកប្រើ</option>
							<option>មិនមានគុណភាព</option>
							<option>មិនដឹង(គ្មានចំលើយ)</option>
							<option>ផ្សេងៗ</option>
						</select>
					</td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: LastNightBednet" numonly="int" /></td>
					<td>
						<select class="form-control input-sm" data-bind="value: EveryNightBednet">
							<option></option>
							<option>មិនដែលគេងសោះ</option>
							<option>១ដង ក្នុងមួយសប្តាហ៍</option>
							<option>២ ទៅ ៣ដង ក្នុងមួយសប្តាហ៍</option>
							<option>៤ ទៅ ៥ដង ក្នុងមួយសប្តាហ៍</option>
							<option>គេងរាល់យប់</option>
						</select>
					</td>
					<td>
						<select class="form-control input-sm" data-bind="value: HangedBednet">
							<option></option>
							<option>មាន</option>
							<option>ទេ</option>
						</select>
					</td>
					<td>
						<select class="form-control input-sm" data-bind="value: UnusedBednet">
							<option></option>
							<option>មិនត្រូវការ</option>
							<option>មិនមានកន្លែងចង</option>
							<option>ពិបាកប្រើ</option>
							<option>មិនមានគុណភាព</option>
							<option>មិនដឹង(គ្មានចំលើយ)</option>
							<option>ផ្សេងៗ</option>
						</select>
					</td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: BrokenBednet" numonly="int" /></td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: MoreLLIN" numonly="int" /></td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: MoreLLIHN" numonly="int" /></td>
					<td>
						<select class="form-control input-sm" data-bind="value: BednetUsage">
							<option></option>
							<option>ទុកសំរាប់ប្រើប្រាស់</option>
							<option>យកទៅបង់ត្រី</option>
							<option>យកទៅរំព័ទ្ធបន្លែ</option>
							<option>យកទៅរំព័ទ្ធរោងសត្វ</option>
							<option>មិនដឹង(គ្មានចំលើយ)</option>
							<option>ផ្សេងៗ</option>
						</select>
					</td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: EducatedMale" numonly="int" /></td>
					<td><input type="text" class="form-control input-sm text-center" data-bind="textInput: EducatedFemale" numonly="int" /></td>
					<td valign="middle" class="no-padding" data-bind="click: $root.removeRow" role="button">
						<span class="material-icons text-danger">delete_outline</span>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="with: masterModel">
				<tr>
					<td colspan="2" align="center" class="kh">សរុប៖</td>
					<td></td>
					<td></td>
					<th align="center" data-bind="text: $root.getTotal('Permanence')"></th>
					<th align="center" data-bind="text: $root.getTotal('Mobile')"></th>
					<th align="center" data-bind="text: $root.getTotal('UsableLLIN')"></th>
					<th align="center" data-bind="text: $root.getTotal('UsableLLIHN')"></th>
					<td></td>
					<th align="center" data-bind="text: $root.getTotal('LastNightBednet')"></th>
					<td></td>
					<td></td>
					<td></td>
					<th align="center" data-bind="text: $root.getTotal('BrokenBednet')"></th>
					<th align="center" data-bind="text: $root.getTotal('MoreLLIN')"></th>
					<th align="center" data-bind="text: $root.getTotal('MoreLLIHN')"></th>
					<td></td>
					<th align="center" data-bind="text: $root.getTotal('EducatedMale')"></th>
					<th align="center" data-bind="text: $root.getTotal('EducatedFemale')"></th>
					<td rowspan="3"></td>
				</tr>
				<tr>
					<td rowspan="2" colspan="16" style="border-left-color:white; border-bottom-color:white; padding-left:0">
						<button class="btn btn-success width100" data-bind="click: $root.addRow">Add Row</button>
					</td>
					<td class="kh" align="center" valign="middle">អន្តរបុគ្គល</td>
					<td data-bind="text: $root.getInterpersonal()" align="center"></td>
					<td data-bind="text: $root.getInterpersonal()" align="center"></td>
				</tr>
				<tr>
					<td class="kh" align="center" valign="middle">ក្រុម</td>
					<td data-bind="text: $root.getTotal('EducatedMale') - $root.getInterpersonal()" align="center"></td>
					<td data-bind="text: $root.getTotal('EducatedFemale') - $root.getInterpersonal()" align="center"></td>
				</tr>
			</tfoot>
		</table>
		<br />
		<br />

		<div class="relative clearfix" data-bind="with: masterModel">
			<div class="pull-left">
				<div style="width:300px">
					<p class="kh">អ្នកត្រួតពិនិត្យរបាយការណ៍៖</p>
					<div class="input-group form-group">
						<span class="input-group-addon kh">ឈ្មោះ</span>
						<input type="text" class="form-control" data-bind="value: AuditorName" />
					</div>
					<div class="input-group form-group">
						<span class="input-group-addon kh">កាលបរិច្ឆេទ</span>
						<input type="text" class="form-control text-center" data-bind="datePicker: AuditDate, dataType: 'string'" />
					</div>
				</div>
			</div>
			<div class="pull-right">
				<div style="width:300px; margin:0 0 0 auto">
					<p class="kh">អ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់៖</p>
					<div class="input-group form-group">
						<span class="input-group-addon kh">ឈ្មោះ</span>
						<input type="text" class="form-control" data-bind="value: VMWName" />
					</div>
					<div class="input-group form-group">
						<span class="input-group-addon kh">កាលបរិច្ឆេទ</span>
						<input type="text" class="form-control text-center" data-bind="datePicker: VMWDate, dataType: 'string'" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && ifcan('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<?=latestJs('/media/ViewModel/VMWSurvey.js')?>