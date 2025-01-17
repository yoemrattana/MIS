<div class="kh divcenter" data-bind="visible: view() == 'detail'">
	<h3 class="text-center">ការអភិបាលកម្មវីធីជំងឺគ្រុនចាញ់សំរាប់មណ្ឌលសុខភាព</h3>
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
			<input type="text" class="form-control en" data-bind="value: MissionNo" />
		</p>
		<span>សមាសភាពចូលរួម៖</span>
		<table class="table table-bordered widthauto">
			<thead>
				<tr>
					<th align="center">ឈ្មោះ</th>
					<th align="center">តួនាទី</th>
					<th></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: Participants">
				<tr>
					<td><input type="text" class="form-control" data-bind="value: name"/></td>
					<td><input type="text" class="form-control" data-bind="value: position"/></td>
					<td valign="middle" data-bind="click: $root.deleteParticipant" role="button">
						<span class="material-icons text-danger">delete_outline</span>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3">
						<button class="btn btn-success btn-sm en" data-bind="click: $root.addParticipant">Add Participant</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<br />

	<div data-bind="with: detailModel">
		<p class="text-bold">ផ្នែកទី១៖ ការគ្រប់គ្រងកម្មវិធីគ្រុនចាញ់</p>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center">ចម្លើយ</th>
			</tr>
			<tr data-bind="with: P1Q1">
				<td align="center">១</td>
				<td class="relative">
					<p>តើមានការប្រជុំប្រចាំខែ/ត្រីមាសជាមួយអ្នកស្ម័គ្រចិត្ដភូមិព្យាបាលជម្ងឺគ្រុនចាញ់នៅខែចុងក្រោយដែរឬទេ?</p>
					<p class="text-danger">សូមបញ្ជាក់កាលបរិច្ឆេទប្រជុំខែចុងក្រោយ</p>
					<div class="input-group">
						<span class="input-group-addon">កាលបរិច្ឆេទ</span>
						<input type="text" class="form-control width150 text-center" data-bind="datePicker: date, showClear: true" placeholder="DD-MM-YYYY">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន (រំលងទៅសំនួរទី២)</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q1_1">
				<td align="center">១.១</td>
				<td>បើមានប្រជុំប្រចាំខែ/ត្រីមាស តើអ្នកស្ម័គ្រចិត្ដភូមិព្យាបាលជម្ងឺគ្រុនចាញ់បានទទួលសម្ភារៈ ឱសថ និងបរិក្ខារតាមគោលការណ៍ណែនាំរបស់ ម.គ.ច ដែរឬទេ?</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q1_1" value="ឱសថ" data-bind="checked: tick" />
							<span>ឱសថ</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q1_1" value="តេស្ត" data-bind="checked: tick" />
							<span>តេស្ត</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q1_1" value="បរិក្ខារ" data-bind="checked: tick" />
							<span>បរិក្ខារ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q2">
				<td align="center">២</td>
				<td>
					<p>តើមានការចុះអភិបាលសេវាឯកជន (បន្ទប់ពិគ្រោះជំងឺ និងឱសថស្ថាន) ពិនិត្យនិងព្យាបាលជំងឺគ្រុនចាញ់  ក្នុងតំបន់គ្របដណ្តប់ដោយមណ្ឌលសុខភាពដែរឬទេ?</p>
					<p class="text-danger">បើគ្មានការចុះអភិបាលសេវាឯកជន សូមបញ្ជាក់ពីមូលហេតុ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q2" value="មានការចុះអភិបាលសេវាឯកជន" data-bind="checked: tick" />
							<span>មានការចុះអភិបាលសេវាឯកជន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q2" value="គ្មានការចុះអភិបាលសេវាឯកជន" data-bind="checked: tick" />
							<span>គ្មានការចុះអភិបាលសេវាឯកជន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q2" value="គ្មានសេវាឯកជន" data-bind="checked: tick" />
							<span>គ្មានសេវាឯកជន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q3">
				<td align="center">៣</td>
				<td>
					<p>តើមានសេវាឯកជន (បន្ទប់ពិគ្រោះជំងឺ និងឱសថស្ថាន) បានបញ្ជូនករណីសង្ស័យជម្ងឺគ្រុនចាញ់មកមណ្ឌលសុខភាពដែរឬទេ?</p>
					<p class="text-danger">បើមានជំងឺ តែមិនបានបញ្ជូន សូមបញ្ជាក់មូលហេតុ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3" value="មានបញ្ជូន" data-bind="checked: tick" />
							<span>មានបញ្ជូន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3" value="មានជំងឺ តែមិនបានបញ្ជូ" data-bind="checked: tick" />
							<span>មានជំងឺ តែមិនបានបញ្ជូន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3" value="មិនមានអ្នកជំងឺបញ្ជូន" data-bind="checked: tick" />
							<span>មិនមានអ្នកជំងឺបញ្ជូន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q4">
				<td align="center">៤</td>
				<td>
					<p>តើមានការចុះអភិបាលកម្មវិធីគ្រុនចាញ់ពីមន្រ្តីមណ្ឌលសុខភាពរួមបញ្ចូលជាមួយថ្នាក់មន្ទីរឬស្រុកប្រតិបត្តិទៅភូមិដែរឬទេ?</p>
					<p class="text-danger">បើគ្មាន សូមបញ្ជាក់ពីមូលហេតុ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="N/A" data-bind="checked: tick" />
							<span>N/A</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q5">
				<td align="center">៥</td>
				<td>
					<p>តើមណ្ឌលសុខភាពមានឯកសារជំនួយណាខ្លះ?</p>
					<div class="text-danger">(បើមាន សូមបង្ហាញ)</div>
				</td>
				<td>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q5" value="មគ្គុទេសក៏ជាតិសំរាប់ព្យាបាលជំងឺគ្រុនចាញ់" data-bind="checked: tick" />
							<span>មគ្គុទេសជាតិសំរាប់ព្យាបាលជំងឺគ្រុនចាញ់</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q5" value="សៀវភៅប្រតិបត្តិសំរាប់តាមដានជំងឺគ្រុនចាញ់ ក្នុងដំណាក់កាលលុបបំបាត់" data-bind="checked: tick" />
							<span>សៀវភៅប្រតិបត្តិសំរាប់តាមដានជំងឺគ្រុនចាញ់ ក្នុងដំណាក់កាលលុបបំបាត់</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q5" value="សៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្តG6PDនិងការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់ប្រភេទប្លាស្មូដ្យូមវីវ៉ាក់" data-bind="checked: tick" />
							<span>សៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្តG6PDនិងការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់ប្រភេទប្លាស្មូដ្យូមវីវ៉ាក់</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q5" value="ឯកសារជំនួយផ្សេងៗទៀត" data-bind="checked: tick" />
							<span>ឯកសារជំនួយផ្សេងៗទៀត</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q6">
				<td align="center">៦</td>
				<td>
					<p>តើមណ្ឌលសុខភាពបានចូលរួមធ្វើផែនការកម្មវិធីគ្រុនចាញ់ប្រចាំឆមាសជាមួយស្រុកប្រតិបតិ្តដែរឬទេ? (ក្នុងរយះពេល៦ខែចុងក្រោយ)</p>
					<p class="text-danger">បើគ្មាន សូមបញ្ជាក់ពីមូលហេតុ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q6" value="បាន" data-bind="checked: tick" />
							<span>បាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q6" value="មិនបាន" data-bind="checked: tick" />
							<span>មិនបាន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td align="center">៧</td>
				<th>អ្នកចុះអភិបាលបានត្រួតពិនិត្យមើ់ល</th>
				<th>ចំណុចដែលបានរកឃើញ</th>
			</tr>
			<tr data-bind="with: P1Q7_1">
				<td align="center">៧.១</td>
				<td>សៀវភៅសម្រង់ទិន្នន័យជំងឺគ្រុនចាញ់ប្រចាំខែ(Malaria logbook)</td>
				<td>
					<div style="display:flex">
						<div class="checkbox checkbox-lg" style="margin-top:6px">
							<label>
								<input type="checkbox" data-bind="checked: tick" />
							</label>
						</div>
						<input type="text" class="form-control" placeholder="ចំនុចដែលបានរកឃើញ" data-bind="value: problem" />
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q7_2">
				<td align="center">៧.២</td>
				<td>សៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្តG6PDនិងការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់ប្រភេទប្លាស្មូដ្យូមវីវ៉ាក់</td>
				<td>
					<div style="display:flex">
						<div class="checkbox checkbox-lg" style="margin-top:6px">
							<label>
								<input type="checkbox" data-bind="checked: tick" />
							</label>
						</div>
						<input type="text" class="form-control" placeholder="ចំនុចដែលបានរកឃើញ" data-bind="value: problem" />
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q7_3">
				<td align="center">៧.៣</td>
				<td>របាយការណ៍ប្រចាំខែមណ្ឌលសុខភាព (HC1)</td>
				<td>
					<div style="display:flex">
						<div class="checkbox checkbox-lg" style="margin-top:6px">
							<label>
								<input type="checkbox" data-bind="checked: tick" />
							</label>
						</div>
						<input type="text" class="form-control" placeholder="ចំនុចដែលបានរកឃើញ" data-bind="value: problem" />
					</div>
				</td>
			</tr>
			 <tr data-bind="with: P1Q7_4">
				<td align="center">៧.៤</td>
				<td>របាយការណ៍ប្រចាំខែរបស់អ្នកស្ម័គ្រចិត្តភូមិ (VMWs Report)</td>
				<td>
					<div style="display:flex">
						<div class="checkbox checkbox-lg" style="margin-top:6px">
							<label>
								<input type="checkbox" data-bind="checked: tick" />
							</label>
						</div>
						<input type="text" class="form-control" placeholder="ចំនុចដែលបានរកឃើញ" data-bind="value: problem" />
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q7_5">
				<td align="center">៧.៥</td>
				<td>ថេបប្លេត (MIS)</td>
				<td>
					<div style="display:flex">
						<div class="checkbox checkbox-lg" style="margin-top:6px">
							<label>
								<input type="checkbox" data-bind="checked: tick" />
							</label>
						</div>
						<input type="text" class="form-control" placeholder="ចំនុចដែលបានរកឃើញ" data-bind="value: problem" />
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q7_6">
				<td align="center">៧.៦</td>
				<td>ផ្សេង (Others)</td>
				<td>
					<div style="display:flex">
						<div class="checkbox checkbox-lg" style="margin-top:6px">
							<label>
								<input type="checkbox" data-bind="checked: tick" />
							</label>
						</div>
						<input type="text" class="form-control" placeholder="ចំនុចដែលបានរកឃើញ" data-bind="value: problem" />
					</div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		
		<p class="text-bold">ផ្នែកទី២៖ គុណភាពនៃទិន្នន័យគ្រុនចាញ់ក្នុងប្រព័ន្ធព័ត៌មានសុខាភិបាល ក្នុងរយៈពេល៣ខែចុងក្រោយ</p>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center">ចម្លើយ</th>
			</tr>

			<tr data-bind="with: P2Q1">
				<td align="center">១</td>
				<td>
					<p>តើមណ្ឌលសុខភាពមានបំពេញរបាយការណ៍ស្តុកឱសថគ្រុនចាញ់ទៅក្នុងប្រព័ន្ធ MIS ទាន់ពេលដែរឬទេ?</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="រៀងរាល់ចុងខែ" data-bind="checked: tick" />
							<span>រៀងរាល់ចុងខែ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="មិនបំពេញ" data-bind="checked: tick" />
							<span>មិនបំពេញ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q2">
				<td align="center">២</td>
				<td valign="middle">
					<p>តើមណ្ឌលសុខភាពមានបំពេញរបាយការណ៍តេស្តគ្រុនចាញ់ទៅក្នុងប្រព័ន្ធ MIS ទាន់ពេលដែរឬទេ?</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="រៀងរាល់ចុងខែ" data-bind="checked: tick" />
							<span>ទាន់ពេល</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="មិនបំពេញ" data-bind="checked: tick" />
							<span>មិនទាន់ពេល</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q3">
				<td align="center">៣</td>
				<td>
					<p>តើមណ្ឌលសុខភាពមានករណីវិជ្ជមានក្នុងរយៈពេល០៣ខែចុងក្រោយដែរទេ?</p>
					<p class="text-danger">បើគ្មាននឹងរំលងទៅសំណួរទី៦ និងរំលងផ្នែកទី៤</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q4">
				<td align="center">៤</td>
				<td>
					<p>តើមណ្ឌលសុខភាពមានបំពេញរបាយការណ៍ករណីវិជ្ជមានទៅក្នុងប្រព័ន្ធ MIS ទាន់ពេលដែរឬទេ?</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="ទាន់ពេល (ក្រោម២៤ម៉ោង)" data-bind="checked: tick" />
							<span>ទាន់ពេល (ក្រោម២៤ម៉ោង)</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="មិនទាន់ពេល" data-bind="checked: tick" />
							<span>មិនទាន់ពេល</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q5">
				<td align="center">៥</td>
				<td>
					<p>តើមណ្ឌលសុខភាពបំពេញរបាយការណ៍ករណីវិជ្ជមានទៅក្នុង MIS បានត្រឹមត្រូវដែរឬទេ?</p>
					<p class="text-danger">សូមបញ្ជាក់ភាពមិនស៊ីគ្នានៃចំនួនជាក់ស្តែង និង ប្រព័ន្ធMIS</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q5" value="ត្រឹមត្រូវ" data-bind="checked: tick" />
							<span>ត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q5" value="មិនត្រឹមត្រូវ" data-bind="checked: tick" />
							<span>មិនត្រឹមត្រូវ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q6">
				<td align="center">៦</td>
				<td>
					<p>តើមណ្ឌលសុខភាពមានឱសថគ្រុនចាញ់ដែលដាច់ស្តុកដែររឺទេ?</p>
					<p class="text-danger">បើមានឱសថគ្រុនចាញ់ដែលដាច់ស្តុក សូមបញ្ជាក់ប្រភេទឱសថ ចំនួន និង កាលបរិច្ឆេទ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q6" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q6" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q7">
				<td align="center">៧</td>
				<td>
					<p>តើមណ្ឌលសុខភាពមានរក្សាទុកឱសថគ្រុនចាញ់ដែលផុតកាលបរិច្ឆេទដែរទេ?</p>
					<p class="text-danger">បើមានឱសថគ្រុនចាញ់ដែលផុតកាលបរិច្ឆេទ សូមបញ្ជាក់ប្រភេទឱសថ ចំនួន និង កាលបរិច្ឆេទ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q7" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q7" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q8">
				<td align="center">៨</td>
				<td>
					<p>តើមណ្ឌលសុខភាពបានបញ្ជូលទិន្នន័យស្តុកឱសថគ្រុនចាញ់ក្នុង MIS ត្រឹមត្រូរដែររឺទេ?</p>
					<p class="text-danger">សូមបញ្ជាក់ភាពមិនស៊ីគ្នានៃចំនួនជាក់ស្តែង និង ប្រព័ន្ធMIS</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q8" value="ត្រឹមត្រូវ" data-bind="checked: tick" />
							<span>ត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q8" value="មិនត្រឹមត្រូវ" data-bind="checked: tick" />
							<span>មិនត្រឹមត្រូវ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q9">
				<td align="center">៩</td>
				<td>
					<p>តើមណ្ឌលសុខភាពបំពេញរបាយការណ៍តេស្ត RDT/MICROSOPE ទៅក្នុង MIS បានត្រឹមត្រូវដែរឬទេ?</p>
					<p class="text-danger">សូមបញ្ជាក់ភាពមិនស៊ីគ្នានៃចំនួនជាក់ស្តែង និង ប្រព័ន្ធMIS</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q9" value="ត្រឹមត្រូវ" data-bind="checked: tick" />
							<span>ត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q9" value="មិនត្រឹមត្រូវ" data-bind="checked: tick" />
							<span>មិនត្រឹមត្រូវ</span>
						</label>
					</div>
				</td>
			</tr>
				<tr data-bind="with: P2Q10">
				<td align="center">១០</td>
				<td>
					<p>តើមណ្ឌលសុខភាពបានបញ្ចូលទិន្នន័យបច្ចុប្បន្តភាពចំនួនប្រជាជនតាមភូមិគ្របដណ្តប់ដែរទេ?</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q10" value="បាន" data-bind="checked: tick" />
							<span>បាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q10" value="មិនបាន" data-bind="checked: tick" />
							<span>មិនបាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q10" value="មិនមានទិន្នន័យបច្ចុប្បន្តភាពចុងក្រោយដែលត្រូវបញ្ចូល" data-bind="checked: tick" />
							<span>មិនមានទិន្នន័យបច្ចុប្បន្តភាពចុងក្រោយដែលត្រូវបញ្ចូល</span>
						</label>
					</div>
				</td>
			</tr>
		</table>
		<br/>

		<table class="table table-bordered" data-bind="with: P2Q11">
			<tr>
				<th align="center"></th>
				<th align="center" class="bg-warning" colspan="3">ក្នុងក្រដាសរបាយការណ៍<br />(សៀវភៅសម្រង់ទិន្នន័យគ្រុនចាញ់ប្រចាំខែ)</th>
				<th align="center" class="bg-info" colspan="3">ក្នុងប្រព័ន្ធ MIS (បង្ហាញស្វ័យប្រវត្តិ)</th>
			</tr>
			<tr class="bg-info">
				<th valign="middle">ការផ្ទៀងផ្ទាត់របាយការណ៍គ្រុនចាញ់ ក្នុងរយៈពេល៣ខែចុងក្រោយ</td>
				<th width="100" align="center" class="en">Month 1</th>
				<th width="100" align="center" class="en">Month 2</th>
				<th width="100" align="center" class="en">Month 3</th>
				<th width="100" align="center" class="en">Month 1</th>
				<th width="100" align="center" class="en">Month 2</th>
				<th width="100" align="center" class="en">Month 3</th>
				<th width="300" align="center" class="en">Remarks</th>
			</tr>
			<tr>
				<td valign="middle">ចំនួនតេស្តសរុប (ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស)</td>
				<td><input type="text" class="form-control text-center en" data-bind="value: test.month1" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: test.month2" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: test.month3" numonly="int" /></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().testMonth1"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().testMonth2"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().testMonth3"></td>
				<td><input type="text" class="form-control" data-bind="value: test.remark" /></td>
			</tr>
			<tr>
				<td valign="middle">Pf</td>
				<td><input type="text" class="form-control text-center en" data-bind="value: pf.month1" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: pf.month2" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: pf.month3" numonly="int" /></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().pfMonth1"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().pfMonth2"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().pfMonth3"></td>
				<td><input type="text" class="form-control" data-bind="value: pf.remark" /></td>
			</tr>
			<tr>
				<td valign="middle">Pv</td>
				<td><input type="text" class="form-control text-center en" data-bind="value: pv.month1" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: pv.month2" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: pv.month3" numonly="int" /></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().pvMonth1"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().pvMonth2"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().pvMonth3"></td>
				<td><input type="text" class="form-control" data-bind="value: pv.remark" /></td>
			</tr>
			<tr>
				<td valign="middle">MIX</td>
				<td><input type="text" class="form-control text-center en" data-bind="value: mix.month1" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: mix.month2" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: mix.month3" numonly="int" /></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().mixMonth1"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().mixMonth2"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().mixMonth3"></td>
				<td><input type="text" class="form-control" data-bind="value: mix.remark" /></td>
			</tr>
			<tr>
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់កំរិតស្រាលបានទទួលការព្យាបាលសរុប</td>
				<td><input type="text" class="form-control text-center en" data-bind="value: minor.month1" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: minor.month2" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: minor.month3" numonly="int" /></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().minorMonth1"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().minorMonth2"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().minorMonth3"></td>
				<td><input type="text" class="form-control" data-bind="value: minor.remark" /></td>
			</tr>
			<tr>
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់កំរិតធ្ងន់បានទទួលការព្យាបាលសរុប</td>
				<td><input type="text" class="form-control text-center en" data-bind="value: severe.month1" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: severe.month2" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: severe.month3" numonly="int" /></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().severeMonth1"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().severeMonth2"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().severeMonth3"></td>
				<td><input type="text" class="form-control" data-bind="value: severe.remark" /></td>
			</tr>
			<tr>
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់ស្លាប់សរុប</td>
				<td><input type="text" class="form-control text-center en" data-bind="value: death.month1" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: death.month2" numonly="int" /></td>
				<td><input type="text" class="form-control text-center en" data-bind="value: death.month3" numonly="int" /></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().deathMonth1"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().deathMonth2"></td>
				<td align="center" valign="middle" class="en" data-bind="text: $root.misData().deathMonth3"></td>
				<td><input type="text" class="form-control" data-bind="value: death.remark" /></td>
			</tr>
		</table>
		<br />
		<br />
		
		<p class="text-bold">ផ្នែកទី៣៖ ពត៌មានអំពីសកម្មភាពអង្កេតតាមដានជំងឺគ្រុនចាញ់ក្នុងរយៈពេល៣ខែចុងក្រោយ</p>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th width="200" align="center">ចំនួន</th>
			</tr>

			<tr data-bind="with: P3Q1">
				<td align="center">១</td>
				<td>
					<p>តើមានប៉ុន្មានករណីដែលបានរាយការណ៍និងចំណាត់ថ្នាក់ករណីក្នុងរយៈពេល ២៤ម៉ោង? (ក្នុងរយៈពេល ៣ខែចុងក្រោយ)</p>
					<p class="text-danger">ករណីមិនបានរាយការណ៍ សូមបញ្ជាក់៖</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td><input type="text" class="form-control text-center" data-bind="value: qty" numonly="int" /></td>
			</tr>
			<tr data-bind="with: P3Q2">
				<td align="center">២</td>
				<td>
					<p>តើមានប៉ុន្មានករណីដែលបានធ្វើការរុករកកណីសកម្មសារជាថ្មីក្នុងរយៈពេល ៣ថ្ងៃ? (ក្នុងរយៈពេល ៣ខែចុងក្រោយ)</p>
					<p class="text-danger">ករណីមិនចុះឆ្លើយតប សូមបញ្ជាក់៖</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td><input type="text" class="form-control text-center" data-bind="value: qty" numonly="int" /></td>
			</tr>
				<tr>
				<td align="center">៣</td>
				<td>តើមានករណី Pf និង Mix ប៉ុន្មានភាគរយដែលបានរាយការណ៍និងចំណាត់ថ្នាក់ករណីក្នុងរយៈពេល ២៤ម៉ោង?</td>
				<td align="center" data-bind="text: $root.misData().pfmix24"></td>
			</tr>
			<tr>
				<tr>
				<td align="center">៤</td>
				<td>តើមានករណី Pv ប៉ុន្មានភាគរយដែលបានរាយការណ៍និងចំណាត់ថ្នាក់ករណីក្នុងរយៈពេល ២៤ម៉ោង?</td>
				<td align="center" data-bind="text: $root.misData().pv24"></td>
			</tr>
			<tr>
			<tr>
				<td align="center">៥</td>
				<td>តើមានករណី Pf និង Mix ប៉ុន្មានភាគរយដែលបានចុះឆ្លើយតប ក្នុងរយៈពេល ៣ថ្ងៃ?</td>
				<td align="center" data-bind="text: $root.misData().pfmix3"></td>
			</tr>
			<tr data-bind="with: P3Q6">
				<td align="center">៦</td>
				<td>
					<p>តើមានចំនួន L1 & LC ប៉ុន្មានដែលបានរកឃើញ?</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td><input type="text" class="form-control text-center" data-bind="value: qty" numonly="int" /></td>
			</tr>
			<tr data-bind="with: P3Q7">
				<td align="center">៧</td>
				<td>
					<p>តើមានសំបុកចម្លងសកម្មចំនួនប៉ុន្មានដែលបានរកឃើញ?</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td><input type="text" class="form-control text-center" data-bind="value: qty" numonly="int" /></td>
			</tr>
		</table>
		<br />
		<br />
		
		<p class="text-bold">ផ្នែកទី៤៖ គុណភាពនៃការពិនិត្យនិងព្យាបាលជម្ងឺគ្រុនចាញ់</p>
		<table class="table table-bordered">
			<thead>
				<tr>
					<td colspan="10" class="bg-warning">ចំនួន ៣០%នៃចំនួនករណីសរុប រយៈពេល០៣ខែចុងក្រោយ (ពិនិត្យក្នុងសៀវភៅបញ្ជីកត់ត្រាពិគ្រោះជំងឺក្រៅ)៖</td>
				</tr>
				<tr class="bg-info">
					<th align="center" valign="middle" rowspan="2" width="40">ល.រ</th>
					<th align="center" valign="middle" rowspan="2" width="80">ភេទ</th>
					<th align="center" valign="middle" rowspan="2" width="100">អាយុ (ឆ្នាំ)</th>
					<th align="center" valign="middle" rowspan="2" width="130">ប្រភេទមេរោគ</th>
					<th align="center" colspan="3">ការព្យាបាល</th>
					<th align="center" valign="middle" rowspan="2" width="110">ចម្លើយ</th>
					<th align="center" valign="middle" rowspan="2">កំណត់សម្គាល់</th>
					<th rowspan="2" width="35"></th>
				</tr>
				<tr class="bg-info">
					<th align="center" width="200">ឈ្មោះថ្នាំ</th>
					<th align="center" width="100"># គ្រាប់/១ថ្ងៃ</th>
					<th align="center" width="100">រយៈពេល</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: P4">
				<tr>
					<td align="center" valign="middle" data-bind="text: $root.khmerNum($index() + 1)"></td>
					<td>
						<select class="form-control font12" data-bind="value: sex">
							<option></option>
							<option value="male">ប្រុស</option>
							<option value="female">ស្រី</option>
						</select>
					</td>
					<td><input type="text" class="form-control text-center en" data-bind="value: age" numonly="int"></td>
					<td>
						<select class="form-control en" data-bind="value: species">
							<option></option>
							<option>Pf</option>
							<option>Pv</option>
							<option>Mix</option>
						</select>
					</td>
					<td><input type="text" class="form-control en" data-bind="value: medicine"></td>
					<td><input type="text" class="form-control text-center en" data-bind="value: qty" numonly="int"></td>
					<td><input type="text" class="form-control text-center en" data-bind="value: duration" numonly="int"></td>
					<td>
						<select class="form-control font12" data-bind="value: answer">
							<option></option>
							<option value="right">ត្រឹមត្រូវ</option>
							<option value="wrong">មិនត្រឹមត្រូវ</option>
						</select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note">
					</td>
					<td align="center" valign="middle" role="button" data-bind="click: $root.deletePatient">
						<span class="material-icons text-danger">delete_outline</span>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="10">
						<button class="btn btn-success btn-sm width100" data-bind="click: $root.addPatient">Add</button>
					</td>
				</tr>
			</tfoot>
		</table>
		<br />
		<br />

		<p class="text-bold">ផ្នែកទី៥៖ សំភារៈបរិក្ខារនិងឱសថ (ពិនិត្យពេលចុះអភិបាល) *ដាច់ស្តុក = សមតុល្យស្មើសូន្យ ឬ ផុតកាលបរិច្ឆេទប្រើប្រាស់ </p>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center">ចម្លើយ</th>
			</tr>

			<tr data-bind="with: P5Q1">
				<td align="center">១</td>
				<td>
					<p>តេស្តរហ័ស (RDT)</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q1" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q1" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q1" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P5Q2">
				<td align="center">២</td>
				<td>
					<p>Artesunate 100mg+ Mefloquin 200mg (A+M)/គ្រាប់</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q2" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q2" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q2" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P5Q3">
				<td align="center">៣</td>
				<td>
					<p>Artesunate 25mg+ Mefloquin 50mg (A+M)/គ្រាប់</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q3" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q3" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q3" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
				<tr data-bind="with: P5Q4">
				<td align="center">៤</td>
				<td>
					<p>ថ្នាំព្រីម៉ាគីន (Primaquine 15mg)</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q4" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q4" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q4" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P5Q5">
				<td align="center">៥</td>
				<td>
					<p>ថ្នាំព្រីម៉ាគីន (Primaquine 7.5mg)</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q5" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q5" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q5" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P5Q6">
				<td align="center">៦</td>
				<td>
					<p>ថ្នាំPyramax</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q6" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q6" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q6" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P5Q7">
				<td align="center">៧</td>
				<td>
					<p>ចំនួនមុងគ្រែ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q7" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q7" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q7" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P5Q8">
				<td align="center">៨</td>
				<td>
					<p>ចំនួនមុងអង្រឹង</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q8" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q8" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q8" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P5Q9">
				<td align="center">៩</td>
				<td>
					<p>ចំនួនតេស្តG6PD</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q9" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q9" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q9" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P5Q10">
				<td align="center">១០</td>
				<td>
					<p>ចំនួនកញ្ចប់ចូលព្រៃ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q10" value="មិនដាច់ស្តុក" data-bind="checked: tick" />
							<span>មិនដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q10" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P5Q10" value="Not applicable" data-bind="checked: tick" />
							<en>Not applicable</en>
						</label>
					</div>
				</td>
			</tr>
		</table>
		<br />
		<br />

		<p class="text-bold">ផ្នែកទី៦៖ បញ្ហាប្រឈម និងដំណោះស្រាយ</p>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="7" class="text-danger">ការណែនាំ៖ សូមសរសេរបញ្ហាចម្បង និងទូទៅ ដែលក្រុមការងារចុះអភិបាលបានរកឃើញ</th>
				</tr>
				<tr class="bg-info">
					<th align="center" width="40">ល.រ</th>
					<th align="center">បញ្ហាដែលរកឃើញ</th>
					<th align="center">ដំណោះស្រាយ</th>
					<th align="center" width="170">អ្នកទទួលខុសត្រូវ</th>
					<th align="center">ស្ថានភាព</th>
					<th align="center" width="120">កាលបរិច្ឆេទ</th>
					<th width="35"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: P6">
				<tr>
					<td align="center" valign="middle" data-bind="text: $root.khmerNum($index() + 1)"></td>
					<td><input type="text" class="form-control" data-bind="value: problem" /></td>
					<td><input type="text" class="form-control" data-bind="value: solution" /></td>
					<td>
						<div class="dropup en">
							<button class="btn btn-default btn-block dropdown-toggle" style="padding:6px" data-toggle="dropdown">
								<span data-bind="text: duty().join(' ') || '&nbsp;'"></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" data-bind="foreach: ['CNM','PHD','OD','HC']" onclick="event.stopPropagation()">
								<li>
									<a class="no-padding">
										<div class="checkbox checkbox-lg">
											<label class="width100p" style="padding:5px 0 5px 30px">
												<input type="checkbox" name="duty" data-bind="checked: $parent.duty, attr: { value: $data }" />
												<span data-bind="text: $data"></span>
											</label>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</td>
					<td>
						<input type="text" class="form-control" data-bind="value: status" />
					</td>
					<td class="relative">
						<input type="text" class="form-control text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: date" />
					</td>
					<td align="center" valign="middle" role="button" data-bind="click: $root.deleteChallenge">
						<span class="material-icons text-danger">delete_outline</span>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<button class="btn btn-success btn-sm width100" data-bind="click: $root.addChallenge">Add</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_HC.js')?>
