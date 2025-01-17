<div class="kh" data-bind="visible: view() == 'detail'" style="width:1090px; margin:auto">
	<h3 class="text-center">បញ្ជីផ្ទៀងផ្ទាត់ការធានាគុណភាព<br><br>ប្រព័ន្ធអង្កេតតាមដានករណីជំងឺគ្រុនចាញ់</h3>
	<br />

	<div class="form-inline" style="border:2px solid; padding:10px" data-bind="with: masterModel">
		<p>
			<span>ការចុះអភិបាលនៅ ខេត្ត</span>
			<select data-bind="value: Code_Prov_N,
					options: pvList,
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>

			<span class="space">ស្រុកប្រតិបត្តិ</span>
			<select data-bind="value: Code_OD_T,
					options: odList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>

			<span class="space">មណ្ឌលសុខភាព</span>
			<select data-bind="value: Code_Facility_T,
					options: hcList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>
		</p>
		<p class="relative en">
			<kh>ថ្ងៃចុះអភិបាល</kh>
			<input type="text" class="form-control width150 text-center" data-bind="datePicker: VisitDate, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />

            <kh class="space">ត្រួតពិនិត្យពី</kh>
            <input type="text" class="form-control width100 text-center" data-bind="datePicker: CheckFrom, format: 'MMM YYYY'" placeholder="MMM YYYY" />

			<kh>ដល់</kh>
            <input type="text" class="form-control width100 text-center" data-bind="datePicker: CheckTo, minDate: CheckFrom() || undefined, format: 'MMM YYYY'" placeholder="MMM YYYY" />
		</p>
		<p>
			<span>ឈ្មោះអ្នកបំពេញទំរង់</span>
			<input type="text" class="form-control" data-bind="value: VisitorName" />

			<span class="space">ភេទ</span>
			<select class="form-control kh" data-bind="value: VisitorSex">
				<option value="M">ប្រុស</option>
				<option value="F">ស្រី</option>
			</select>
			
			<span class="space">តួនាទី</span>
			<input type="text" class="form-control" data-bind="value: VisitorPosition" />
			
			<span class="space">ទូរស័ព្ទលេខ</span>
			<input type="text" class="form-control en" data-bind="value: VisitorPhone" />
		</p>
		<p>
			<span>ទីកន្លែងធ្វើការ</span>
			<select class="form-control kh" data-bind="value: VisitorWorkplace">
				<option></option>
				<option value="CNM">ម.គ.ច</option>
				<option value="PHD">មន្ទីរសុខាភិបាលខេត្ត</option>
				<option value="OD">ស្រុកប្រតិបត្តិ</option>
			</select>

			<kh class="space">លេខបេសកកម្ម</kh>
			<input type="text" class="form-control en" min="0"
               oninput="this.value = this.value.replace(/[^0-9-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-bind="value: MissionNo" />
		</p>
		<p>
			<span>សមាសភាពចូលរួម</span>
			<table class="table table-bordered widthauto en font14">
				<thead>
					<tr>
						<th>Name</th>
						<th>Position</th>
						<th></th>
					</tr>
				</thead>
				<tbody data-bind="foreach: Participants">
					<tr>
						<td><input type="text" class="form-control kh" data-bind="value: name"/></td>
						<td><input type="text" class="form-control kh" data-bind="value: position"/></td>
						<td>
							<button class="btn btn-danger" data-bind="click: $root.deleteParticipant">
								<i class="fa fa-trash"></i>
							</button>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3">
							<button class="btn btn-success btn-sm" data-bind="click: $root.addParticipant">Add Participant</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</p>
	</div>
	<br />

	<div data-bind="with: detailModel">
		<table class="table table-bordered">
			<tr>
				<td colspan="3">
					<b>ការណែនាំ៖</b>
					<ul>
						<li class="text-bold">សូមកត់ត្រាចំលើយក្នុងប្រអប់ខាងក្រោមនេះ</li>
						<li>
							<b>ក្នុងករណីទូទៅ៖</b>
							<ul>
								<li>ការដាក់ពិន្ទុនឹងផ្តល់អោយទៅតាមការគណនាមធ្យមភាគនៃចំលើយ</li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<th align="center" width="40">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center" width="600">ចំលើយ</th>
			</tr>
			<tr class="bg-warning">
				<th align="center">ក</th>
				<th colspan="2">ពិនិត្យឡើងវិញនូវទិន្នន័យជំងឺគ្រុនចាញ់នៅក្នុងប្រព័ន្ធMISក្នុងរយៈពេល ៣ ខែចុងក្រោយ ឆ្នាំបច្ចុប្បន្ន និងឆ្នាំមុន ដូចតទៅ (HC+VMW)</th>
			</tr>
			<tr data-bind="with: Q1">
				<td align="center" valign="middle">1</td>
				<td valign="middle">ចំនួនករណីជំងឺគ្រុនចាញ់អវិជ្ជមានសរុប</td>
				<td data-bind="foreach: Array(2)">
					<!-- ko with: $parent.Answer[$index() == 0 ? 'thisYear' : 'lastYear'] -->
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<!-- /ko -->
					<hr data-bind="visible: $index() == 0" />
				</td>
			</tr>
			<tr data-bind="with: Q2">
				<td align="center" valign="middle">2</td>
				<td valign="middle">ចំនួនករណី Pf</td>
				<td data-bind="foreach: Array(2)">
					<!-- ko with: $parent.Answer[$index() == 0 ? 'thisYear' : 'lastYear'] -->
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<!-- /ko -->
					<hr data-bind="visible: $index() == 0" />
				</td>
			</tr>
			<tr data-bind="with: Q3">
				<td align="center" valign="middle">3</td>
				<td valign="middle">ចំនួនករណី Mix</td>
				<td data-bind="foreach: Array(2)">
					<!-- ko with: $parent.Answer[$index() == 0 ? 'thisYear' : 'lastYear'] -->
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<!-- /ko -->
					<hr data-bind="visible: $index() == 0" />
				</td>
			</tr>
			<tr data-bind="with: Q4">
				<td align="center" valign="middle">4</td>
				<td valign="middle">ចំនួនករណី Pv</td>
				<td data-bind="foreach: Array(2)">
					<!-- ko with: $parent.Answer[$index() == 0 ? 'thisYear' : 'lastYear'] -->
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<!-- /ko -->
					<hr data-bind="visible: $index() == 0" />
				</td>
			</tr>
			<tr class="bg-warning">
				<th align="center">ខ</th>
				<th colspan="2">ស្រង់ទិន្នន័យជាក់ស្តែងនៅក្នុងបញ្ជីកត់ត្រាជំងឺគ្រុនចាញ់ប្រចាំខែ ក្នុងសៀវភៅគ្រុនចាញ់ (សៀវភៅតារាងស្ថិតិអ្នកជំងឺគ្រុនចាញ់ប្រចាំខែរបស់ HC) +<br />របាយការណ៍ករណីជំងឺគ្រុនចាញ់ប្រចាំខែរបស់ VMW</th>
			</tr>
			<tr data-bind="with: Q5">
				<td align="center" valign="middle">5</td>
				<td valign="middle">ចំនួនករណីជំងឺគ្រុនចាញ់អវិជ្ជមានសរុប (ឆ្នាំបច្ចុប្បន្ន)</td>
				<td data-bind="with: Answer">
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
				</td>
			</tr>
			<tr data-bind="with: Q6">
				<td align="center" valign="middle">6</td>
				<td valign="middle">ចំនួនករណី Pf (ឆ្នាំបច្ចុប្បន្ន)</td>
				<td data-bind="with: Answer">
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
				</td>
			</tr>
			<tr data-bind="with: Q7">
				<td align="center" valign="middle">7</td>
				<td valign="middle">ចំនួនករណី Mix (ឆ្នាំបច្ចុប្បន្ន)</td>
				<td data-bind="with: Answer">
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
				</td>
			</tr>
			<tr data-bind="with: Q8">
				<td align="center" valign="middle">8</td>
				<td valign="middle">ចំនួនករណី Pv (ឆ្នាំបច្ចុប្បន្ន)</td>
				<td data-bind="with: Answer">
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle">9</td>
				<td valign="middle">តើទិន្នន័យក្នុងMIS និងទិន្នន័យជាក់ស្តែងមានចំនួនករណីខុសគ្នាអ្វីខ្លះ?</td>
				<td>
					<textarea class="form-control" data-bind="value: Q9.Answer" style="width:100%; height:100px; resize:none"></textarea>
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle">10</td>
				<td valign="middle">តើការកត់ត្រាឬបញ្ចូលទិន្នន័យដូចម្តេចដែរ?</td>
				<td>
					<textarea class="form-control" data-bind="value: Q10.Answer" style="width:100%; height:100px; resize:none"></textarea>
				</td>
			</tr>
		</table>
		<br />
		<br />

		<table class="table table-bordered">
			<tr>
				<th align="center" width="40">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center" width="600">ចំលើយ</th>
				<th align="center" width="50">ពិន្ទុសរុប</th>
				<th align="center" width="50">ពិន្ទុ</th>
			</tr>
			<tr class="bg-warning">
				<th colspan="3">ផ្នែកទី ១៖ ការរាយការណ៍ករណីបន្ទាន់ ការអង្កេតករណី ធ្វើចំណាត់ថ្នាក់ និងការរុករកករណីគ្រុនចាញ់ជុំវិញករណីគោល (Notification, Case Investigation, Classification and RACD)</th>
				<th align="center" valign="middle">(100)</th>
				<th></th>
			</tr>
			<tr>
				<td align="center">A</td>
				<th colspan="2" class="bg-warning">ការរាយការណ៍ករណីបន្ទាន់ (Notification) ពិនិត្យ៣ខែចុងក្រោយ</th>
				<th align="center" class="bg-warning">(40)</th>
				<th class="bg-warning"></th>
			</tr>
			<tr data-bind="with: P1Q1">
				<td align="center">1</td>
				<td>តើមានចំនួនករណីជំងឺគ្រុនចាញ់ (Pf + Mix) ប៉ុន្មាននាក់ដែលបានរាយការណ៍បន្ទាន់?<br />(ទិន្នន័យនៅក្នុងMISពីCNM)</td>
				<td data-bind="with: Answer">
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
				</td>
				<td align="center" valign="middle">10</td>
				<td valign="middle">
					<input type="text" data-bind="value: Score" class="form-control text-center en" numonly="int" />
				</td>
			</tr>
			<tr data-bind="with: P1Q2">
				<td align="center">2</td>
				<td>តើមានករណីជំងឺគ្រុនចាញ់ (Pf + Mix) ប៉ុន្មាននាក់ ដែលបានទទួលសារSMSក្នុងរយៈពេល 24ម៉ោង? <br />(ពិនិត្យទិន្នន័យក្នុងថេប្លេត/ទូរស័ព្ទPHD/OD)</td>
				<td data-bind="with: Answer">
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
				</td>
				<td align="center" valign="middle">15</td>
				<td valign="middle">
					<input type="text" data-bind="value: Score" class="form-control text-center en" numonly="int" />
				</td>
			</tr>
			<tr data-bind="with: P1Q3">
				<td align="center">3</td>
				<td>ហេតុអ្វីបានជាមានករណីរាយការណ៍លើសពី២៤ម៉ោង? (PHD/OD)<br /><br />(ចម្លើយអាចមានលើសពី១)</td>
				<td data-bind="with: Answer">
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q3" value="No internet" data-bind="checked: tick" />
							<span>មិនមានសេវាអ៊ីនធឺណែត</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q3" value="Phone/Tablet broken" data-bind="checked: tick" />
							<span>ទូរស័ព្ទ/ថេប្លេតខូច</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q3" value="Unknown usage" data-bind="checked: tick" />
							<span>មិនចេះប្រើ</span>
						</label>
					</div>
					<div class="form-inline">
						<label class="checkbox-inline checkbox-lg">
							<input type="checkbox" name="P1Q3" value="Other" data-bind="checked: tick" />
							<span>ផ្សេងៗ៖</span>
						</label>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td class="bg-gray"></td>
				<td class="bg-gray"></td>
			</tr>
			<tr data-bind="with: P1Q4">
				<td align="center">4</td>
				<td>តើមានករណីជំងឺគ្រុនចាញ់ (Pf + Mix) ប៉ុន្មាននាក់ ដែលបានរាយការណ៍ក្នុងរយៈពេល &lt;24 ម៉ោង? <br />(ពិនិត្យទិន្នន័យក្នុងថេប្លេតHC)</td>
				<td data-bind="with: Answer">
					<p class="form-inline" data-bind="with: hc">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: vmw">
						<span class="inlineblock" style="width:50px">VMW:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
					<p class="form-inline" data-bind="with: total">
						<span class="inlineblock" style="width:50px">សរុប:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</p>
				</td>
				<td align="center" valign="middle">15</td>
				<td valign="middle">
					<input type="text" data-bind="value: Score" class="form-control text-center en" numonly="int" />
				</td>
			</tr>
			<tr data-bind="with: P1Q5">
				<td align="center">5</td>
				<td>ហេតុអ្វីបានជាមានករណីរាយការណ៍លើសពី២៤ម៉ោង? (HC)<br /><br />(ចម្លើយអាចមានលើសពី១)</td>
				<td data-bind="with: Answer">
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q5" value="No internet" data-bind="checked: tick" />
							<span>មិនមានសេវាអ៊ីនធឺណែត</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q5" value="Tablet broken" data-bind="checked: tick" />
							<span>ថេប្លេតខូច</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q5" value="Unknown usage" data-bind="checked: tick" />
							<span>មិនចេះប្រើ</span>
						</label>
					</div>
					<div class="form-inline">
						<label class="checkbox-inline checkbox-lg">
							<input type="checkbox" name="P1Q5" value="Other" data-bind="checked: tick" />
							<span>ផ្សេងៗ៖</span>
						</label>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td class="bg-gray"></td>
				<td class="bg-gray"></td>
			</tr>
			<tr>
				<td align="center">B</td>
				<th colspan="2" class="bg-warning">ការអង្កេតករណី និិងចំណាត់ថ្នាក់ (Case Investigation / Classification) រយៈពេល៣ខែចុងក្រោយ</th>
				<th align="center" class="bg-warning">(30)</th>
				<th class="bg-warning"></th>
			</tr>
			<tr data-bind="with: P1Q6">
				<td align="center">6</td>
				<td>តើមានករណីជំងឺគ្រុនចាញ់ (Pf + Mix) ចំនួនប៉ុន្មានដែលបានចុះអង្កេតក្នុងរយៈពេល &lt;៧២ ម៉ោង? <br />(ពិនិត្យទិន្នន័យក្នុងថេប្លេតHC)</td>
				<td valign="middle" data-bind="with: Answer">
					<div class="form-inline">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</div>
				</td>
				<td align="center" valign="middle">10</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr data-bind="with: P1Q6_1">
				<td align="center">6.1</td>
				<td>អត្រា Pf + Mix ដែលបានចុះអង្កេតក្នុងរយៈពេល៣ខែចុងក្រោយ៖ ចំនួន Pf + Mix អង្កេតតិចជាង៧២ម៉ោង ចែកចំនួន Pf + Mix សរុប<br />(ប្រៀបធៀបចម្លើយសំណួរទី១ផ្នែកA)</td>
				<td valign="middle">
					<div class="input-group width150">
						<input type="text" class="form-control text-center en" numonly="float" data-bind="value: Answer" />
						<span class="input-group-addon en">%</span>
					</div>
				</td>
				<td class="bg-gray"></td>
				<td class="bg-gray"></td>
			</tr>
			<tr data-bind="with: P1Q7">
				<td align="center">7</td>
				<td>តើមានករណីចំនួនប៉ុន្មានដែលបានចុះអង្កេតលើសពី >៧២ ម៉ោង? (ពិនិត្យទិន្នន័យក្នុងថេប្លេតHC)</td>
				<td valign="middle" data-bind="with: Answer">
					<div class="form-inline">
						<span class="inlineblock" style="width:50px">HC:</span>
						<span>ឆ្នាំ</span>
						<input type="text" data-bind="value: year" class="form-control input-sm en width50 text-center" maxlength="4" numonly="int" />
						<span>ខែ</span>
						<input type="text" data-bind="value: month1" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value1" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month2" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value2" class="form-control input-sm en width50" numonly="int" />
						<span>; ខែ</span>
						<input type="text" data-bind="value: month3" class="form-control input-sm en width50 text-center" maxlength="2" numonly="int" />
						<span>=</span>
						<input type="text" data-bind="value: value3" class="form-control input-sm en width50" numonly="int" />
					</div>
				</td>
				<td align="center" valign="middle">10</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr data-bind="with: P1Q7_1">
				<td align="center">7.1</td>
				<td>អត្រាPf + Mixដែលបានចុះអង្កេតក្នុងរយៈពេល៣ខែចុងក្រោយ៖ ចំនួនPf + Mixអង្កេតលើស៧២ម៉ោង ចែក ចំនួនPf + Mix សរុប<br />(ប្រៀបធៀបចម្លើយសំណួរទី១ផ្នែកA)</td>
				<td valign="middle">
					<div class="input-group width150">
						<input type="text" class="form-control text-center en" numonly="float" data-bind="value: Answer" />
						<span class="input-group-addon en">%</span>
					</div>
				</td>
				<td class="bg-gray"></td>
				<td class="bg-gray"></td>
			</tr>
			<tr data-bind="with: P1Q8">
				<td align="center">8</td>
				<td>ហេតុអ្វីបានជាមានករណីមិនទាន់ចុះអង្កេតករណី? <br />(យោងតាមសំណួរទី7.1)<br /><br />(ចម្លើយអាចមានលើសពី១)</td>
				<td data-bind="with: Answer">
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q8" value="Far village" data-bind="checked: tick" />
							<span>ភូមិឆ្ងាយ</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q8" value="Not enough staff" data-bind="checked: tick" />
							<span>មិនមានបុគ្គលិកគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q8" value="Passing patient" data-bind="checked: tick" />
							<span>អ្នកជំងឺជាអ្នកឆ្លងកាត់តំបន់</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q8" value="No reports from VMW" data-bind="checked: tick" />
							<span>មិនបានរាយការណ៍ទាន់ពេលពីអ្នកស្ម័គ្រចិត្ត</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q8" value="Wait for OD" data-bind="checked: tick" />
							<span>រងចាំបញ្ជាពីOD</span>
						</label>
					</div>
					<div class="form-inline">
						<label class="checkbox-inline checkbox-lg">
							<input type="checkbox" name="P1Q8" value="Other" data-bind="checked: tick" />
							<span>ផ្សេងៗ៖</span>
						</label>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td class="bg-gray"></td>
				<td class="bg-gray"></td>
			</tr>
			<tr data-bind="with: P1Q9">
				<td align="center">9</td>
				<td>តើមានករណីPf + Mix ចំនួនប៉ុន្មានដែលបានចំណាត់ថ្នាក់ L1, LC និង នាំចូល? (ប្រៀបធៀបថេប្លេតHC និងឯកសារទម្រង់ចុះអង្តេតHC)</td>
				<td valign="middle">
					<p class="form-inline" data-bind="with: Answer.tablet">
						<span class="inlineblock" style="width:60px">ថេប្លេត:</span>
						<span>L1:</span>
						<input type="text" class="form-control input-sm en width50 text-center" numonly="int" data-bind="value: L1" />
						<span>LC:</span>
						<input type="text" class="form-control input-sm en width50 text-center" numonly="int" data-bind="value: L2" />
						<span>នាំចូល:</span>
						<input type="text" class="form-control input-sm en width50 text-center" numonly="int" data-bind="value: IMP" />
					</p>
					<p class="form-inline" data-bind="with: Answer.paper">
						<span class="inlineblock" style="width:60px">ឯកសារ:</span>
						<span>L1:</span>
						<input type="text" class="form-control input-sm en width50 text-center" numonly="int" data-bind="value: L1" />
						<span>LC:</span>
						<input type="text" class="form-control input-sm en width50 text-center" numonly="int" data-bind="value: L2" />
						<span>នាំចូល:</span>
						<input type="text" class="form-control input-sm en width50 text-center" numonly="int" data-bind="value: IMP" />
					</p>
				</td>
				<td align="center" valign="middle">5</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr data-bind="with: P1Q10">
				<td align="center">10</td>
				<td>តើបានកត់ត្រាកូអរដោនេ (GPS) និងបំពេញក្នុងទម្រង់អង្កេតបានត្រឹមត្រូវដែរឬទេ?</td>
				<td data-bind="with: Answer">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q10" value="Yes" data-bind="checked: tick" />
							<span>បាទ/ចាស៎</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q10" value="No" data-bind="checked: tick" />
							<span>ទេ</span>
						</label>
					</div>
					<div class="form-inline">
						<span>សូមបញ្ជាក់៖</span>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td align="center" valign="middle">5</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr>
				<td align="center">C</td>
				<th colspan="2" class="bg-warning">ការរុករកករណីគ្រុនចាញ់ជុំវិញករណីគោល (RACD) រយៈពេល៣ខែចុងក្រោយ</th>
				<th align="center" class="bg-warning">(30)</th>
				<th class="bg-warning"></th>
			</tr>
			<tr data-bind="with: P1Q11">
				<td align="center">11</td>
				<td>អត្រាចំនួនករណីគ្រុនចាញ់ Pf + Mix ដែលបានធ្វើRACD?<br />(ពិនិត្យទិន្នន័យក្នុងថេប្លេតHC)</td>
				<td data-bind="with: Answer">
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:100px">
							<input type="radio" name="P1Q11" value="Under 7 days" data-bind="checked: tick" />
							<span>ក្រោម៧ថ្ងៃ</span>
						</label>
						<div class="input-group" style="width:260px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty1" />
							<span class="input-group-addon en">=</span>
							<input type="text" class="form-control text-center en" numonly="float" data-bind="value: percent1" />
							<span class="input-group-addon en">%</span>
						</div>
					</div>
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:100px">
							<input type="radio" name="P1Q11" value="Over 7 days" data-bind="checked: tick" />
							<span>លើស៧ថ្ងៃ</span>
						</label>
						<div class="input-group" style="width:260px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty2" />
							<span class="input-group-addon en">=</span>
							<input type="text" class="form-control text-center en" numonly="float" data-bind="value: percent2" />
							<span class="input-group-addon en">%</span>
						</div>
					</div>
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:100px">
							<input type="radio" name="P1Q11" value="Did not do" data-bind="checked: tick" />
							<span>មិនបានធ្វើ</span>
						</label>
						<div class="input-group" style="width:260px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty3" />
							<span class="input-group-addon en">=</span>
							<input type="text" class="form-control text-center en" numonly="float" data-bind="value: percent3" />
							<span class="input-group-addon en">%</span>
						</div>
					</div>
					<div class="form-inline">
						<span>សូមបញ្ជាក់៖</span>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td align="center" valign="middle">5</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr class="bg-warning">
				<th colspan="3">ផ្នែកទី ២៖ ការអង្កេតសំបុកចម្លង (Foci Investigation) រយៈពេល១ឆ្នាំកន្លង</th>
				<th align="center">(100)</th>
				<th></th>
			</tr>
			<tr data-bind="with: P2Q1">
				<td align="center">1</td>
				<td>អត្រាចំនួនករណី L1 ដែលបានធ្វើការអង្កេតសំបុកចម្លង?<br />(ផ្ទៀងផ្ទាត់ឯកសារអង្កេតសំបុកចម្លងនៅOD និងMIS)</td>
				<td data-bind="with: Answer">
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:110px">
							<input type="radio" name="P2Q1" value="Under 14 days" data-bind="checked: tick" />
							<span>ក្រោម១៤ថ្ងៃ</span>
						</label>
						<div class="input-group" style="width:260px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty1" />
							<span class="input-group-addon en">=</span>
							<input type="text" class="form-control text-center en" numonly="float" data-bind="value: percent1" />
							<span class="input-group-addon en">%</span>
						</div>
					</div>
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:110px">
							<input type="radio" name="P2Q1" value="Over 14 days" data-bind="checked: tick" />
							<span>លើស១៤ថ្ងៃ</span>
						</label>
						<div class="input-group" style="width:260px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty2" />
							<span class="input-group-addon en">=</span>
							<input type="text" class="form-control text-center en" numonly="float" data-bind="value: percent2" />
							<span class="input-group-addon en">%</span>
						</div>
					</div>
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:110px">
							<input type="radio" name="P2Q1" value="Did not do" data-bind="checked: tick" />
							<span>មិនបានធ្វើ</span>
						</label>
						<div class="input-group" style="width:260px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty3" />
							<span class="input-group-addon en">=</span>
							<input type="text" class="form-control text-center en" numonly="float" data-bind="value: percent3" />
							<span class="input-group-addon en">%</span>
						</div>
					</div>
					<div class="form-inline">
						<span>សូមបញ្ជាក់៖</span>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td align="center" valign="middle">20</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr data-bind="with: P2Q2">
				<td align="center">2</td>
				<td>តើឯកសារអង្កេតសំបុកចម្លងបានបំពេញត្រឹមត្រូវឬទេ?</td>
				<td data-bind="with: Answer">
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:160px">
							<input type="radio" name="P2Q2" value="Full" data-bind="checked: tick" />
							<span>ពេញលេញ</span>
						</label>
						<div class="input-group" style="width:130px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty1" />
						</div>
					</div>
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:160px">
							<input type="radio" name="P2Q2" value="Not full" data-bind="checked: tick" />
							<span>មិនពេញលេញ</span>
						</label>
						<div class="input-group" style="width:130px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty2" />
						</div>
					</div>
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:160px">
							<input type="radio" name="P2Q2" value="Did not fill" data-bind="checked: tick" />
							<span>មិនបានបំពេញសោះ</span>
						</label>
						<div class="input-group" style="width:130px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty3" />
						</div>
					</div>
					<div class="form-inline">
						<span>សូមបញ្ជាក់៖</span>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td align="center" valign="middle">20</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr data-bind="with: P2Q3">
				<td align="center">3</td>
				<td>តើមានគូសផែនទីក្នុងរង្វង់១គីឡូម៉ែត្រជុំវិញករណីគោល (L1) នៅក្នុងឯកសារអង្កេតសំបុកចម្លងឬទេ?</td>
				<td data-bind="with: Answer">
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:110px">
							<input type="radio" name="P2Q3" value="Draw" data-bind="checked: tick" />
							<span>បានគូស</span>
						</label>
						<div class="input-group" style="width:130px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty1" />
						</div>
					</div>
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:110px">
							<input type="radio" name="P2Q3" value="Did not draw" data-bind="checked: tick" />
							<span>មិនបានគូស</span>
						</label>
						<div class="input-group" style="width:130px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty2" />
						</div>
					</div>
					<div class="form-inline">
						<span>សូមបញ្ជាក់៖</span>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td align="center" valign="middle">20</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr data-bind="with: P2Q4">
				<td align="center">4</td>
				<td>ចំនួនសំបុកចម្លងដែលបានធ្វើការអង្កេតបាណកសាស្រ្ត?</td>
				<td data-bind="with: Answer">
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:110px">
							<input type="radio" name="P2Q4" value="Done" data-bind="checked: tick" />
							<span>បានធ្វើ</span>
						</label>
						<div class="input-group" style="width:130px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty1" />
						</div>
					</div>
					<div class="form-inline form-group">
						<label class="radio-inline radio-lg" style="width:110px">
							<input type="radio" name="P2Q4" value="Did not do" data-bind="checked: tick" />
							<span>មិនបានធ្វើ</span>
						</label>
						<div class="input-group" style="width:130px">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center en" numonly="int" data-bind="value: qty2" />
						</div>
					</div>
					<div class="form-inline">
						<span>សូមបញ្ជាក់៖</span>
						<input type="text" class="form-control" style="width:500px" data-bind="value: other" />
					</div>
				</td>
				<td align="center" valign="middle">20</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr data-bind="with: P2Q5">
				<td align="center">5</td>
				<td>
					<span>ការឆ្លើយតបសំបុកចម្លងសកម្ម (R1 V1) ក្រោយពេលអង្កេតសំបុកចម្លង៖</span>
					<ul>
						<li>ការធ្វើតេស្ត</li>
						<li>ចែកមុង</li>
						<li>អប់រំសុខភាព</li>
					</ul>
				</td>
				<td data-bind="with: Answer">
					<p class="form-inline">
						<span>ចំនួនភូមិសំបុកចម្លងដែលបានធ្វើតេស្ត៖</span>
						<input type="text" class="form-control input-sm text-center en width100" numonly="int" data-bind="value: test" />
					</p>
					<p class="form-inline">
						<span>ចំនួនភូមិសំបុកចម្លងដែលបានចែកមុង៖</span>
						<input type="text" class="form-control input-sm text-center en width100" numonly="int" data-bind="value: bednet" />
					</p>
					<p class="form-inline">
						<span>ចំនួនភូមិសំបុកចម្លងដែលបានអប់រំសុខភាព៖</span>
						<input type="text" class="form-control input-sm text-center en width100" numonly="int" data-bind="value: educate" />
					</p>
				</td>
				<td align="center" valign="middle">20</td>
				<td valign="middle">
					<input type="text" class="form-control text-center en" numonly="int" data-bind="value: Score" />
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<span>បញ្ហាប្រឈម៖</span>
					<textarea class="form-control" style="width:100%; height:120px; resize:none" data-bind="value: Problem.Answer"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<span>ដំណោះស្រាយ៖</span>
					<textarea class="form-control" style="width:100%; height:120px; resize:none" data-bind="value: Solution.Answer"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<span>សំណូមពរទូទៅ៖</span>
					<textarea class="form-control" style="width:100%; height:120px; resize:none" data-bind="value: Request.Answer"></textarea>
				</td>
			</tr>
		</table>
		<br />
	</div>

	<table class="table table-bordered" data-bind="with: masterModel">
		<tr class="bg-info">
			<th colspan="4">ពិន្ទុសរុបតាមផ្នែកនីមួយៗ</th>
		</tr>
		<tr class="bg-info">
			<th>ផ្នែក</th>
			<th align="center" width="160">ពិន្ទុសរុបតាមផ្នែក</th>
			<th align="center" width="160">ពិន្ទុទទួលបាន</th>
			<th align="center" width="160">មធ្យមភាគ</th>
		</tr>
		<tr>
			<td valign="middle">ផ្នែកទី១៖ ការរាយការណ៍ អង្កេត ចំណាត់ថ្នាក់ និង RACD (A+B+C)</td>
			<td align="center" valign="middle">១០០</td>
			<td>
				<input type="text" class="form-control text-center" data-bind="value: Part1Score" numonly="int" maxlength="3" />
			</td>
			<td align="center" valign="middle" data-bind="text: isnullempty(Part1Score()) ? '' : Part1Score() + '%'"></td>
		</tr>
		<tr>
			<td valign="middle">ផ្នែកទី២៖ ការអង្កេតសំបុកចម្លង</td>
			<td align="center" valign="middle">១០០</td>
			<td>
				<input type="text" class="form-control text-center" data-bind="value: Part2Score" numonly="int" maxlength="3" />
			</td>
			<td align="center" valign="middle" data-bind="text: isnullempty(Part1Score()) ? '' : Part1Score() + '%'"></td>
		</tr>
	</table>
	<br />

	<ol>
		<li>
			<span class="inlineblock" style="width:200px">ពិន្ទុមធ្យមភាគ ≤ 49%</span> ក្រុមអភិបាលត្រូវ៖ ត្រឡប់ទៅអភិបាលវិញនៅ(1)ខែបន្ទាប់
		</li>
		<li>
			<span class="inlineblock" style="width:200px">ពិន្ទុមធ្យមភាគ 50-79%</span> ក្រុមអភិបាលត្រូវ៖ ត្រឡប់ទៅអភិបាលវិញនៅ(3ខែ)ត្រីមាសបន្ទាប់
		</li>
		<li>
			<span class="inlineblock" style="width:200px">ពិន្ទុមធ្យមភាគ ≥ 80%</span> ក្រុមអភិបាលត្រូវ៖ ត្រឡប់ទៅអភិបាលវិញនៅ(6ខែ)ឆមាសបន្ទាប់
		</li>
	</ol>
</div>

<?=latestJs('/media/ViewModel/Checklist_Epi.js')?>