<div class="kh divcenter" data-bind="visible: view() == 'detail'">
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
						<td><input type="text" class="form-control" data-bind="value: name"/></td>
						<td><input type="text" class="form-control" data-bind="value: position"/></td>
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
		<h4 class="text-bold">ផ្នែកទី១៖ ការគ្រប់គ្រងកម្មវិធីគ្រុនចាញ់ (៣០ពិន្ទុ)</h4>
		<p>
			<span>ចំនួនអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជម្ងឺគ្រុនចាញ់ភូមិ/ចល័តក្នុងតំបន់គ្របដណ្តប់នៃមណ្ឌលសុខភាព៖</span>
			<span data-bind="text: $root.vmwQty"></span>
		</p>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center">ចម្លើយ</th>
				<th align="center" width="110">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr data-bind="with: P1Q1">
				<td align="center" valign="middle">1</td>
				<td valign="middle">តើមានការប្រជុំប្រចាំខែជាមួយអ្នកស្ម័គ្រចិត្ដភូមិព្យាបាលជម្ងឺគ្រុនចាញ់នៅខែចុងក្រោយដែរឬទេ? (២ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1" value="Yes" score="2" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1" value="No" score="2" data-bind="checked: Answer.tick" />
							<span>គ្មាន (រំលងទៅសំនួរទី២)</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q1_1">
				<td align="center" valign="middle">1.1</td>
				<td valign="middle">បើមានប្រជុំប្រចាំខែ តើអ្នកស្ម័គ្រចិត្ដភូមិព្យាបាលជម្ងឺគ្រុនចាញ់បានទទួលប្រាក់ឧបត្ថម្ភ និង​បានទទួលប្រាក់ទូរស័ព្ទប្រចាំខែ នៅពេលណា? (២ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_1" value="Over 7 days" score="0" data-bind="checked: Answer.tick" />
							<span>&gt; ៧ ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_1" value="5-7 days" score="0.5" data-bind="checked: Answer.tick" />
							<span>៥ ទៅ ៧ ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_1" value="3-4 days" score="1" data-bind="checked: Answer.tick" />
							<span>៣ ទៅ ៤ ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_1" value="1-2 days" score="1.5" data-bind="checked: Answer.tick" />
							<span>១ ទៅ ២ ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_1" value="Meeting day" score="2" data-bind="checked: Answer.tick" />
							<span>ក្នុងថ្ងៃប្រជុំ</span>
						</label>
					</div>
                    <div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_1" value="No Meeting" score="2" data-bind="checked: Answer.tick" />
							<span>គ្មានប្រជុំប្រចាំខែ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q1_2">
				<td align="center" valign="middle">1.2</td>
				<td valign="middle">បើមានប្រជុំប្រចាំខែ តើអ្នកស្ម័គ្រចិត្ដភូមិព្យាបាលជម្ងឺគ្រុនចាញ់បានទទួលសម្ភារ​ ឱសថ និង បរិក្ខារតាមគោលការណ៍ណែនាំរបស់ ម.គ.ច ដែរឬទេ? (១ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_2" value="Yes" score="1" data-bind="checked: Answer.tick" />
							<span>បានទទួល</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_2" value="No" score="0.5" data-bind="checked: Answer.tick" />
							<span>មិនបានទទួល</span>
						</label>
					</div>
                    <div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_2" value="No Meeting" score="1" data-bind="checked: Answer.tick" />
							<span>គ្មានប្រជុំប្រចាំខែ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q2">
				<td align="center" valign="middle">2</td>
				<td valign="middle">តើមានសេវាឯកជន (បន្ទប់ពិគ្រោះជំងឺ និងឱសថស្ថាន) ពិនិត្យនិងព្យាបាលជំងឺគ្រុនចាញ់  ក្នុងតំបន់គ្របដណ្តប់​ដោយ​មណ្ឌលសុខភាពដែរ​ឬ​ទេ?​ (៤ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q2" value="Yes" score="0" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q2" value="No" score="4" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q3">
				<td align="center" valign="middle">3</td>
				<td valign="middle">តើមានសេវាឯកជន (បន្ទប់ពិគ្រោះជំងឺ និងឱសថស្ថាន) បានបញ្ជូនករណីសង្ស័យជម្ងឺគ្រុនចាញ់មកមណ្ឌលសុខភាពដែរ​ឬ​ទេ? (២ពិន្ទុ)​   </td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3" value="Referred" score="2" data-bind="checked: Answer.tick" />
							<span>មានបញ្ជូន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3" value="Did not refer" score="0" data-bind="checked: Answer.tick" />
							<span>មានជំងឺ តែមិនបានបញ្ជូន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3" value="No patients" score="2" data-bind="checked: Answer.tick" />
							<span>មិនមានអ្នកជំងឺបញ្ជូន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q4">
				<td align="center" valign="middle">4</td>
				<td valign="middle">តើមន្រ្តីមណ្ឌលសុខភាពបានចុះអភិបាលសេវាឯកជនក្នុង៣ខែចុងក្រោយដែរឫទេ? (៤ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="Yes" score="4" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q5">
				<td align="center" valign="middle">5</td>
				<td valign="middle">តើមានការចុះអភិបាលកម្មវិធីគ្រុនចាញ់ពីមន្រ្តីមណ្ឌលសុខភាពទៅភូមិដែរឬទេ? (៥ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q5" value="Yes" score="5" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q5" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q6">
				<td align="center" valign="middle">6</td>
				<td valign="middle">តើមណ្ឌលសុខភាពមានឯកសារជំនួយណាខ្លះ?​ (បើមាន សូមបង្ហាញ) (៦ពិន្ទុ)<br /><br />(អាចជ្រើសបានច្រើន)</td>
				<td valign="middle">
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q6" value="National guidelines" data-bind="checked: Answer.tick" />
							<span>មគ្គុទេសក៏ជាតិ​សំរាប់ព្យាបាលជំងឺគ្រុនចាញ់</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q6" value="Surveillance book" data-bind="checked: Answer.tick" />
							<span>សៀវភៅប្រតិបត្តិសំរាប់តាមដានជំងឺគ្រុនចាញ់<br />ក្នុងដំណាក់កាលលុបបំបាត់</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q6" value="Other" data-bind="checked: Answer.tick" />
							<span>ឯកសារជំនួយផ្សេងៗទៀត</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q7">
				<td align="center" valign="middle">7</td>
				<td valign="middle">តើមណ្ឌលសុខភាពបានចូលរួមធ្វើផែនការកម្មវិធីគ្រុនចាញ់ប្រចាំឆមាសជាមួយស្រុកប្រតិបតិ្តដែរឬទេ? (ក្នុងរយះពេល៦ខែចុងក្រោយ) (៤ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q7" value="Yes" score="4" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q7" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
		</table>
		<br />
		<br />

		<h4 class="text-bold">ផ្នែកទី២៖ គុណភាពនៃទិន្នន័យក្នុងប្រព័ន្ធព័ត៌មានសុខាភិបាល ក្នុងរយៈពេល៣ខែចុងក្រោយ (៣០ពិន្ទុ)</h4>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center">ចម្លើយ</th>
				<th align="center" width="110">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr data-bind="with: P2Q1">
				<td align="center" valign="middle">1</td>
				<td valign="middle">តើមណ្ឌលសុខភាពមានបំពេញរបាយការណ៍ស្តុកទៅក្នុងប្រព័ន្ធ MIS ទាន់ពេលដែរឬទេ? (៥ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="Everyday" score="5" data-bind="checked: Answer.tick" />
							<span>រាល់ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="Every week" score="4" data-bind="checked: Answer.tick" />
							<span>មួយអាទិត្យម្តង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="Every 2 weeks" score="3" data-bind="checked: Answer.tick" />
							<span>ពីរអាទិត្យម្តង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="Every month" score="2" data-bind="checked: Answer.tick" />
							<span>មួយខែម្តង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="No" score="1" data-bind="checked: Answer.tick" />
							<span>មិនបំពេញ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q2">
				<td align="center" valign="middle">2</td>
				<td valign="middle">តើមណ្ឌលសុខភាពមានបំពេញរបាយការណ៍តេស្តទៅក្នុងប្រព័ន្ធ MIS ទាន់ពេលដែរឬទេ? (៥ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="Everyday" score="5" data-bind="checked: Answer.tick" />
							<span>រាល់ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="Every week" score="4" data-bind="checked: Answer.tick" />
							<span>មួយអាទិត្យម្តង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="Every 2 weeks" score="3" data-bind="checked: Answer.tick" />
							<span>ពីរអាទិត្យម្តង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="Every month" score="2" data-bind="checked: Answer.tick" />
							<span>មួយខែម្តង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="No" score="1" data-bind="checked: Answer.tick" />
							<span>មិនបំពេញ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q3">
				<td align="center" valign="middle">3</td>
				<td valign="middle">តើមណ្ឌលសុខភាពមានបំពេញរបាយការណ៍ករណីទៅក្នុងប្រព័ន្ធ MIS ទាន់ពេលដែរឬទេ? (៥ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="On time" score="5" data-bind="checked: Answer.tick" />
							<span>ទាន់ពេល (ក្រោម២៤ម៉ោង)</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="Late 1-2 days" score="4" data-bind="checked: Answer.tick" />
							<span>យឺត ១ទៅ២ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="Late 3-7 days" score="3" data-bind="checked: Answer.tick" />
							<span>យឺត ៣ទៅ៧ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="Late 8-14 days" score="2" data-bind="checked: Answer.tick" />
							<span>យឺត ៨ទៅ១៤ថ្ងៃ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="Later than 15 days" score="1" data-bind="checked: Answer.tick" />
							<span>យឺតជាង ១៥ថ្ងៃ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q4">
				<td align="center" valign="middle">4</td>
				<td valign="middle">តើមណ្ឌលសុខភាពបំពេញរបាយការណ៍ស្តុកទៅក្នុង MIS បានត្រឹមត្រូវដែរឬទេ? (៥ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="Correct" score="5" data-bind="checked: Answer.tick" />
							<span>ត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="Incorrect" score="0" data-bind="checked: Answer.tick" />
							<span>មិនត្រឹមត្រូវ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q5">
				<td align="center" valign="middle">5</td>
				<td valign="middle">តើមណ្ឌលសុខភាពបំពេញរបាយការណ៍តេស្តទៅក្នុង MIS បានត្រឹមត្រូវដែរឬទេ? (៥ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q5" value="Correct" score="5" data-bind="checked: Answer.tick" />
							<span>ត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q5" value="Incorrect" score="0" data-bind="checked: Answer.tick" />
							<span>មិនត្រឹមត្រូវ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q6">
				<td align="center" valign="middle">6</td>
				<td valign="middle">តើមណ្ឌលសុខភាពបំពេញរបាយការណ៍ករណីទៅក្នុង MIS បានត្រឹមត្រូវដែរឬទេ? (៥ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q6" value="Correct" score="5" data-bind="checked: Answer.tick" />
							<span>ត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q6" value="Incorrect" score="0" data-bind="checked: Answer.tick" />
							<span>មិនត្រឹមត្រូវ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
		</table>
		<br />
		<br />

		<h4 class="text-bold">ផ្នែកទី៣៖ សកម្មភាពលុបបំបាត់ជំងឺគ្រុនចាញ់​ ក្នុងរយៈពេល៣ខែចុងក្រោយ (២០ពិន្ទុ)</h4>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center" width="400">ចម្លើយ</th>
				<th align="center" width="110">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr data-bind="with: P3Q1">
				<td align="center" valign="middle">1</td>
				<td valign="middle">តើមណ្ឌលសុខភាព មានករណីគ្រុនចាញ់សរុបប៉ុន្មាន? (ក្នុងរយៈពេល ៣ខែចុងក្រោយ)</td>
				<td valign="middle" class="form-inline">
					<div>
						<span class="inlineblock" style="width:120px">ចំនួនធ្វើតេស្តសរុប:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.test" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Pf:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.pf" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Pv:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.pv" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Mix:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.mix" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួនសរុប:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.positive" numonly="int" />
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q2">
				<td align="center" valign="middle">2</td>
				<td valign="middle">តើមានប៉ុន្មានករណីដែលបានរាយការណ៍ចុះអង្កេតតាមដានក្នុងរយៈពេល ២៤ម៉ោង? (ក្នុងរយៈពេល ៣ខែចុងក្រោយ)</td>
				<td valign="middle" class="form-inline">
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Pf:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.pf" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Pv:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.pv" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Mix:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.mix" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួនសរុប:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.positive" numonly="int" />
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q2_1">
				<td align="center" valign="middle">2.1</td>
				<td valign="middle">ករណីមិនបានរាយការណ៍ សូមបញ្ជាក់៖</td>
				<td valign="middle">
					<input type="text" class="form-control" data-bind="value: Answer" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q3">
				<td align="center" valign="middle">3</td>
				<td valign="middle">តើមានប៉ុន្មានករណីដែលបានចុះឆ្លើយតប ក្នុងរយៈពេល ៣ថ្ងៃ? (ក្នុងរយៈពេល ៣ខែចុងក្រោយ)</td>
				<td valign="middle" class="form-inline">
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Pf:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.pf" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Pv:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.pv" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួន Mix:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.mix" numonly="int" />
					</div>
					<div>
						<span class="inlineblock" style="width:120px">ចំនួនសរុប:</span>
						<input type="text" class="form-control text-center width100 en" data-bind="value: Answer.positive" numonly="int" />
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q3_1">
				<td align="center" valign="middle">3.1</td>
				<td valign="middle">ករណីមិនចុះឆ្លើយតប សូមបញ្ជាក់៖</td>
				<td valign="middle">
					<input type="text" class="form-control" data-bind="value: Answer" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q3_2">
				<td align="center" valign="middle"></td>
				<td valign="middle">តើមានករណី Pf និង Mix ប៉ុន្មានភាគរយដែលបានរាយការណ៍ចុះអង្កេតតាមដានក្នុងរយៈពេល ២៤ម៉ោង?<br />(This indicator will be calculated in background by MIS) (៨ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_2" value="No" data-bind="checked: Answer.tick(), click: () => false" />
							<span>មិនមានករណី Pf និង Mix</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_2" value="Under 25%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>តិចជាង ២៥%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_2" value="25%-49%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ២៥% ទៅ ៤៩%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_2" value="50%-74%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ៥០% ទៅ ៧៤%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_2" value="75%-100%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ៧៥% ទៅ ១០០%</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q3_3">
				<td align="center" valign="middle"></td>
				<td valign="middle">តើមានករណី Pv ប៉ុន្មានភាគរយដែលបានរាយការណ៍ចុះអង្កេតតាមដានក្នុងរយៈពេល ២៤ម៉ោង?<br />(This indicator will be calculated in background by MIS) (៨ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_3" value="No" data-bind="checked: Answer.tick(), click: () => false" />
							<span>មិនមានករណី Pv</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_3" value="Under 25%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>តិចជាង ២៥%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_3" value="25%-49%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ២៥% ទៅ ៤៩%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_3" value="50%-74%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ៥០% ទៅ ៧៤%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_3" value="75%-100%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ៧៥% ទៅ ១០០%</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q3_4">
				<td align="center" valign="middle"></td>
				<td valign="middle">តើមានករណី Pf និង Mix ប៉ុន្មានភាគរយដែលបានចុះឆ្លើយតប ក្នុងរយៈពេល ៣ថ្ងៃ?<br />(This indicator will be calculated in background by MIS) (៤ពិន្ទុ)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_4" value="No" data-bind="checked: Answer.tick(), click: () => false" />
							<span>មិនមានករណី Pf និង Mix</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_4" value="Under 25%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>តិចជាង ២៥%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_4" value="25%-49%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ២៥% ទៅ ៤៩%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_4" value="50%-74%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ៥០% ទៅ ៧៤%</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3_4" value="75%-100%" data-bind="checked: Answer.tick(), click: () => false" />
							<span>ចាប់ពី ៧៥% ទៅ ១០០%</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q4">
				<td align="center" valign="middle">4</td>
				<td valign="middle">តើមានចំនួន L1 & LC ប៉ុន្មានដែលបានរកឃើញ?</td>
				<td valign="middle" class="form-inline">
                    <div>
                        <span class="inlineblock" style="width:60px">ចំនួន L1</span>
					    <input type="text" class="form-control text-center width100 en" data-bind="value: Answer.l1" numonly="int" />
                    </div>
					<div>
                        <span class="inlineblock" style="width:60px">ចំនួន LC</span>
					    <input type="text" class="form-control text-center width100 en" data-bind="value: Answer.lc" numonly="int" />
                    </div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P3Q5">
				<td align="center" valign="middle">5</td>
				<td valign="middle">តើមានសំបុកចម្លងសកម្មចំនួនប៉ុន្មានដែលបានរកឃើញ?</td>
				<td valign="middle" class="form-inline">
					<span>ចំនួន</span>
					<input type="text" class="form-control text-center width100 en" data-bind="value: Answer" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
		</table>
		<br />
		<br />

		<h4 class="text-bold">ផ្នែកទី៤៖ គុណភាពនៃការពិនិត្យនិងព្យាបាលជម្ងឺគ្រុនចាញ់ (១០ពិន្ទុ)</h4>
		<p class="form-inline">
			<span>ចំនួន ៣០%នៃចំនួនករណីសរុប រយៈពេល០៣ខែចុងក្រោយ (ពិនិត្យក្នុងសៀវភៅបញ្ជីកត់ត្រាពិគ្រោះជំងឺក្រៅ)៖</span>
			<input type="text" class="form-control text-center width100 en" data-bind="value: P4.Answer.qty" numonly="int" />
		</p>
		<table class="table table-bordered widthauto">
			<thead>
				<tr class="bg-info">
					<th align="center" valign="middle" rowspan="2" width="40">លរ</th>
					<th align="center" valign="middle" rowspan="2" width="80">ភេទ</th>
					<th align="center" valign="middle" rowspan="2" width="80">អាយុ (ឆ្នាំ)</th>
					<th align="center" valign="middle" rowspan="2" width="80">ប្រភេទមេរោគ</th>
					<th align="center" colspan="3">ការព្យាបាល</th>
					<th align="center" valign="middle" rowspan="2" width="120">ចម្លើយ</th>
					<th align="center" valign="middle" rowspan="2" width="110">ពិន្ទុទទួលបាន</th>
				</tr>
				<tr class="bg-info">
					<th align="center" width="300">ឈ្មោះថ្នាំ</th>
					<th align="center" width="130"># គ្រាប់/១ថ្ងៃ</th>
					<th align="center" width="120">រយៈពេល</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: P4.Answer.list">
				<tr>
					<td align="center" valign="middle" data-bind="text: $index() + 1"></td>
					<td align="center">
						<select class="form-control en" data-bind="value: sex">
							<option value=""></option>
							<option value="M">ប្រុស</option>
							<option value="F">ស្រី</option>
						</select>
					</td>
					<td align="center">
						<input type="text" class="form-control text-center en" data-bind="value: age" numonly2="int" />
					</td>
					<td align="center">
						<select class="form-control en" data-bind="value: virus">
							<option value=""></option>
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
						</select>
					</td>
					<td align="center">
						<input type="text" class="form-control en" data-bind="value: medicine" />
					</td>
					<td align="center">
						<div class="input-group">
							<input type="text" class="form-control text-center en" data-bind="value: pill" numonly2="int" />
							<span class="input-group-addon">គ្រាប់</span>
						</div>
					</td>
					<td align="center">
						<div class="input-group">
							<input type="text" class="form-control text-center en" data-bind="value: duration" numonly2="int" />
							<span class="input-group-addon">ថ្ងៃ</span>
						</div>
					</td>
					<td align="center">
						<select class="form-control en" data-bind="value: tick">
							<option value=""></option>
							<option value="Correct">ត្រឹមត្រូវ</option>
							<option value="Incorrect">មិនត្រឹមត្រូវ</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: getScore()"></td>
				</tr>
			</tbody>
		</table>
		<br />
		<br />

		<h4 class="text-bold">ផ្នែកទី៥៖ សំភារៈបរិក្ខារនិង​ឱសថ (ពិនិត្យពេលចុះអភិបាល)  *ដាច់ស្តុក = សមតុល្យស្មើសូន្យ ឬ ផុតកាលបរិច្ឆេទប្រើប្រាស់ (១០ពិន្ទុ)</h4>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center">ចម្លើយ</th>
				<th align="center" width="110">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr data-bind="with: P5Q1">
				<td align="center" valign="middle">1</td>
				<td valign="middle">តេស្តរហ័ស (RDT)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q1" value="Not stockout" data-bind="checked: Answer.tick">
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q1" value="Stockout" data-bind="checked: Answer.tick">
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P5Q2">
				<td align="center" valign="middle">2</td>
				<td valign="middle">Artesunate 100mg+ Mefloquin 200mg (A+M)/គ្រាប់</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q2" value="Not stockout" data-bind="checked: Answer.tick">
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q2" value="Stockout" data-bind="checked: Answer.tick">
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P5Q3">
				<td align="center" valign="middle">3</td>
				<td valign="middle">Artesunate 25mg+ Mefloquin 50mg (A+M)/គ្រាប់</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q3" value="Not stockout" data-bind="checked: Answer.tick">
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q3" value="Stockout" data-bind="checked: Answer.tick">
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P5Q4">
				<td align="center" valign="middle">4</td>
				<td valign="middle">ថ្នាំព្រីម៉ាគីន (Primaquine 15mg)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q4" value="Not stockout" data-bind="checked: Answer.tick">
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q4" value="Stockout" data-bind="checked: Answer.tick">
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P5Q5">
				<td align="center" valign="middle">5</td>
				<td valign="middle">ថ្នាំព្រីម៉ាគីន (Primaquine 7.5mg)</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q5" value="Not stockout" data-bind="checked: Answer.tick">
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q5" value="Stockout" data-bind="checked: Answer.tick">
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
		</table>
		<br />
		<br />

		<h4 class="text-bold">ផ្នែកទី៦៖ បញ្ហាប្រឈម និងដំណោះស្រាយ</h4>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">លរ</th>
				<th align="center">បញ្ហាដែលរកឃើញ</th>
				<th align="center">ដំណោះស្រាយ</th>
				<th align="center" width="200">អ្នកទទួលខុសត្រូវ</th>
				<th align="center" width="150">កាលបរិច្ឆេទ</th>
			</tr>
			<tr data-bind="with: P6Q1">
				<td align="center" valign="middle">1</td>
				<td><input type="text" class="form-control" data-bind="value: Answer.problem" /></td>
				<td><input type="text" class="form-control" data-bind="value: Answer.solution" /></td>
				<td><input type="text" class="form-control" data-bind="value: Answer.person" /></td>
				<td class="relative en">
					<input type="text" class="form-control text-center" data-bind="datePicker: Answer.date, showClear: true" placeholder="DD-MM-YYYY">
				</td>
			</tr>
			<tr data-bind="with: P6Q2">
				<td align="center" valign="middle">2</td>
				<td><input type="text" class="form-control" data-bind="value: Answer.problem" /></td>
				<td><input type="text" class="form-control" data-bind="value: Answer.solution" /></td>
				<td><input type="text" class="form-control" data-bind="value: Answer.person" /></td>
				<td class="relative en">
					<input type="text" class="form-control text-center" data-bind="datePicker: Answer.date, showClear: true" placeholder="DD-MM-YYYY">
				</td>
			</tr>
		</table>
		<br />
		<br />

		<h4 class="text-bold">តារាងសង្ខេបពិន្ទុតាមផ្នែក</h4>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">ផ្នែក</th>
				<th align="center" width="180">ពិន្ទុពេញ</th>
				<th align="center" width="180">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr>
				<td>ផ្នែកទី១៖ ការគ្រប់គ្រងកម្មវិធីគ្រុនចាញ់</td>
				<td align="center">30</td>
				<td align="center" data-bind="text: $root.P1score()"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី២៖ គុណភាពនៃទិន្ន័យក្នុងប្រព័ន្ធព៌តមានសុខភិបាល</td>
				<td align="center">30</td>
				<td align="center" data-bind="text: $root.P2score()"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី៣៖ សកម្មភាពលុបបំបាត់ជំងឺគ្រុនចាញ់​</td>
				<td align="center">20</td>
				<td align="center" data-bind="text: $root.P3score()"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី៤៖ គុណភាពនៃការពិនិត្យនិងព្យាបាលជម្ងឺគ្រុនចាញ់</td>
				<td align="center">10</td>
				<td align="center" data-bind="text: $root.P4score()"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី៥៖ សំភារៈបរិក្ខារនិង​ឱសថ</td>
				<td align="center">10</td>
				<td align="center" data-bind="text: $root.P5score()"></td>
			</tr>
			<tr>
				<th align="right">ពិន្ទុសរុប៖</th>
				<th align="center">100</th>
				<th align="center" data-bind="text: $root.grandTotal()"></th>
			</tr>
			<tr>
				<td align="right">
					<b>ការវាយតំលៃ៖</b><br />
					(ពិន្ទុសរុប &le; ៧៥ : ត្រូវចុះទៅអភិបាលក្នុងកំឡុងពេល ៣ខែក្រោយ)<br />
					(ពិន្ទុសរុប &gt; ៧៥ : ត្រូវចុះទៅអភិបាលក្នុងកំឡុងពេល ៦ខែក្រោយ)
				</td>
				<td align="center" valign="middle" colspan="2" class="text-bold">
					<span data-bind="visible: $root.grandTotal() <= 75">ត្រូវចុះទៅអភិបាលក្នុងកំឡុងពេល ៣ខែក្រោយ</span>
					<span data-bind="visible: $root.grandTotal() > 75">ត្រូវចុះទៅអភិបាលក្នុងកំឡុងពេល ៦ខែក្រោយ</span>
				</td>
			</tr>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_MnE_HC.js')?>