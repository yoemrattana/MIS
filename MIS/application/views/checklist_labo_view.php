<div class="kh" data-bind="visible: view() == 'detail'" style="width:1090px; margin:auto">
	<h3 class="text-center">ទម្រង់របាយការណ៍អភិបាលកិច្ចសំរាប់វាយតម្លៃគុណភាពមន្ទីរពិសោធន៍មីក្រូទស្សន៍គ្រុនចាញ់</h3>
	<br />

	<div class="form-inline" style="border:2px solid; padding:10px" data-bind="with: masterModel">
		<p>
			<span>ឈ្មោះគ្រឹះស្ថានសុខាភិបាល</span>
			<input type="text" class="form-control" data-bind="value: HFName" style="width:400px" />
		</p>
		<p class="relative en">
			<kh>ថ្ងៃចុះអភិបាល</kh>
			<input type="text" data-bind="datePicker: VisitDate" class="form-control width150 text-center" placeholder="DD-MM-YYYY" />

			<kh class="space">លេខបេសកកម្ម</kh>
			<input type="text" class="form-control en" min="0"
               oninput="this.value = this.value.replace(/[^0-9-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-bind="value: MissionNo" />

            <kh class="space">ទីកន្លែងធ្វើការ</kh>
			<select class="form-control kh" data-bind="value: VisitorWorkplace">
				<option></option>
				<option value="HC">មណ្ឌលសុខភាព</option>
				<option value="RH">មន្ទីរពេទ្យបង្អែក</option>
				<option value="PH">មន្ទីរពេទ្យខេត្ត</option>
				<option value="NH">មន្ទីរពេទ្យជាតិ</option>
				<option value="Other">ផ្សេងៗ</option>
			</select>
		</p>
		<p>
			<span>ខេត្ត</span>
			<select data-bind="value: Code_Prov_N,
					options: pvList,
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>

			<span class="space">ស្រុក</span>
			<select data-bind="value: Code_Dist_T,
					options: dsList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>
		</p>
		<p>
			<span>លេខទូរសព្ទគ្រឹះស្ថានសុខភាព</span>
			<input type="text" class="form-control" data-bind="value: HFPhone" />
			
			<span class="space">លេខតេឡេក្រាម</span>
			<input type="text" class="form-control" data-bind="value: HFTelegram" />
		</p>
		<p>
			<span>ប្រធានមន្ទីរពិសោធន៍</span>
			<input type="text" class="form-control" data-bind="value: LaboChief" />
			
			<span class="space">លេខតេឡេក្រាម</span>
			<input type="text" class="form-control" data-bind="value: LaboChiefTelegram" />
		</p>
		<p>
			<span>ប្រធានមន្ទីរពេទ្យ</span>
			<input type="text" class="form-control" data-bind="value: HospitalChief" />
			
			<span class="space">លេខតេឡេក្រាម</span>
			<input type="text" class="form-control" data-bind="value: HospitalChiefTelegram" />
		</p>
		<p>
			<span>បុគ្គលិកមន្ទីរពិសោធន៍ទទួលសម្ភាសន៍</span>
			<input type="text" class="form-control" data-bind="value: Interviewee" />
		</p>
		<p>
			<span>អ្នកសម្ភាសន៍</span>
			<input type="text" class="form-control" data-bind="value: Interviewer" />
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

	<div id="laboDetail" data-bind="with: detailModel">
		<h4>2. អង្គភាពនិងការគ្រប់គ្រង</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="warning">
					<th align="center"></th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P2Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើអ្នកបច្ចេកទេសមន្ទីរពិសោធន៍បានចូលវគ្គបណ្តុះបណ្តាលមីក្រូទស្សន៍ទៀងទាត់ដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមន្ទីរពិសោធន៍ឯកជនមានអាជ្ញាប័ណ្ណដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានមីក្រូទស្សន៍សំរាប់អនុវត្តក្នុងមន្ទីរពិសោធន៍ឯកជនដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th rowspan="2" align="center">អ្នកមីក្រូទស្សន៍បានទទួល​​ការបណ្តុះបណ្តាល</th>
					<th rowspan="2" align="center" width="120">ចំនួនខែធ្វើការក្នុងមន្ទីរពិសោធន៍</th>
					<th colspan="3" align="center">ថ្ងៃទទួលការបណ្តុះបណ្តាលចុងក្រោយ</th>
					<th rowspan="2" align="center">កំណត់សម្គាល់</th>
				</tr>
				<tr class="info">
					<th align="center">មូលដ្ឋានគ្រឹះ</th>
					<th align="center" width="120">វគ្គរំលឹក</th>
					<th align="center" width="120">វគ្គវាយតម្លៃជំនាញផ្ទៃក្នុង</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: Array(5)">
				<tr data-bind="with: $parent.P2Q4[$index()]">
					<td>
						<input type="text" class="form-control" data-bind="value: microscope" />
					</td>
					<td>
						<input type="text" class="form-control" data-bind="value: month" />
					</td>
					<td>
						<input type="text" class="form-control" data-bind="value: basis" />
					</td>
					<td>
						<input type="text" class="form-control" data-bind="value: refresher" />
					</td>
					<td>
						<input type="text" class="form-control" data-bind="value: evaluation" />
					</td>
					<td>
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<h4>3. ឯកសារមន្ទីរពិសោធន៍</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center"></th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P3Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានប័ណ្ណវិភាគស្នើសុំធ្វើតេស្តឈាមដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើការកត់ត្រាក្នុងសៀវភៅមន្ទីរពិសោធន៍មានរបៀបត្រឹមត្រូវឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមាននិយាមប្រតិបត្តិ(SOPs)ដែលមានការទទួលស្គាល់(ផ្លូវការ)ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានសៀវភៅបច្ចេកទេសមន្ទីរពិសោធន៍គ្រុនចាញ់ និងផ្ទាំងរូបភាពឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានបញ្ជីត្រួតពិនិត្យគុណភាពផ្ទៃក្នុងឬទេ (ការត្រួតពិនិត្យផ្ទៃក្នុងរវាងគ្នានឹងគ្នា)?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានសៀវភៅកត់ត្រាការថែទាំមីក្រូទស្សន៍ និងប្រដាប់វាស់ pH ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមីក្រូទស្សន៍មានម៉ាកនិងលេខស៊េរីដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<h4>4. និតិវិធី</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">4.1 ការរៀបចំធ្វើភ្នាសឈាម</th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P4_1Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមាននិយាមប្រតិបត្តិ(SOPs)សម្រាប់ធ្វើភ្នាសឈាមឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានធ្វើផ្ទៃឈាមស្តើងនិងផ្ទៃឈាមក្រាស់ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើបានកត់ត្រាលើកញ្ចក់ឈាមត្រឹមត្រូវឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានការតាមដានគុណភាពនៃការធ្វើភ្នាសឈាមឬទេ (ពុម្ភកញ្ចក់ឈាមគំរូ)?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើកញ្ចក់ឈាមមិនទាន់បំពាក់ពណ៌ត្រូវបានការពារពីសត្វល្អិតនិងការឡើងស្អិតជាប់ដោយឯងៗ<br />(Auto Fixation)ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">4.2 ការរៀបចំបំពាក់ពណ៌ភ្នាសឈាម</th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P4_2Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមាននិយាមប្រតិបត្តិ(SOPs)សម្រាប់បំពា់ពណ៌កញ្ចក់ឈាមឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើបានធ្វើតាមនីតិវិធីបំពាក់ពណ៌ដែលមាននៅក្នុងសៀវភៅនែនាំឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើបានត្រួតពិនិត្យគុណភាពផ្ទៃក្នុងទៀងទាត់ចំពោះកញ្ចក់វិជ្ជមាននិងកញ្ចក់អវិជ្ជមានក្នុងពេលបំពាក់ពណ៌ហើយឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">
						<span>តើបានប្រើបច្ចេកទេសបំពាក់ពណ៌ដោយអ្វី?</span>
						<div class="checkbox-inline checkbox-lg space">
							<label>
								<input type="checkbox" data-bind="checked: useColor" />
								<span>បំពាក់ពណ៌ហ្សីមស្សា</span>
							</label>
						</div>
						<div class="form-inline">
							<span>ប្រតិករផ្សេងទៀត(បញ្ជាក់)</span>
							<input type="text" class="form-control" data-bind="value: other" />
						</div>
					</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">4.3 សម្រាប់បច្ចេកទេសប្រើហ្សីមសា</th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P4_3Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានប្រើទឹកមាន pH 7.2 ± 0.2 ដោយថ្នាំបាសហ្វឺយកទៅលាយហ្សីមសាឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើសូលុយស្យុងហ្សីមសាសម្រាប់ប្រើប្រាស់ត្រូវបានលាយភ្លាមៗ(˂ ១៥ mn)មុនបំពាក់ពណ៌ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">4.4 ការពិនិត្យរកប៉ារ៉ាស៊ីតលើកញ្ចក់ឈាម</th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P4_4Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមាននិយាមប្រតិបត្តិ(SOPs)សម្រាប់ពិនិត្យរកប៉ារ៉ាស៊ីតលើភ្នាសឈាមឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើអ្នកមីក្រូទស្សន៍បានរាយការណ៍វត្តមានឬអវត្តមានប៉ារ៉ាស៊ីត ប្រភេទប៉ារ៉ាស៊ីត និង ចំនួនប៉ារ៉ាស៊ីតឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើអ្នកពិនិត្យមីក្រូទស្សន៍ប្រើពេល១០នាទីសម្រាប់១កញ្ចក់ឈាមដូចការណែនាំឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើកញ្ចក់ឈាមពិនិត្យរួចត្រូវបានទុកដាក់ថែរក្សាត្រឹមត្រូវឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" colspan="2" class="form-inline">
						<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យជាមធ្យមក្នុង១ខែ​​​:</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">កញ្ចក់</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" colspan="2" class="form-inline">
						<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យជាមធ្យមក្នុង១ថ្ងៃ(តំបន់ចម្លងខ្ពស់):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">កញ្ចក់</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" colspan="2" class="form-inline">
						<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យជាមធ្យមក្នុង១ថ្ងៃសម្រាប់អ្នកមីក្រូទស្សន៍១នាក់(តំបន់ចម្លងខ្ពស់):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">កញ្ចក់</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" colspan="2" class="form-inline">
						<span>ចំនួនកញ្ចក់ឈាមបានរក្សាទុក ឬបានត្រួតពិនិត្យដោយអ្នកវាយតម្លៃ​​​:</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">កញ្ចក់</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<h4>5. ការវាយតម្លៃអំពីកម្រិតជំនាញ</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">5.1 ការពិនិត្យកញ្ចក់ឈាមនិងការពិនិត្យរកប៉ារ៉ាស៊ីត (cross-checking)</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P5_1Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យរកប៉ារ៉ាស៊ីតដោយដោយអ្នកវាយតម្លៃ​​​:</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">កញ្ចក់</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ភាពត្រូវគ្នានៃការរកឃើញវត្តមានប៉ារ៉ាស៊ីតគិតជា(%):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>វិជ្ជមានមិនពិត(%):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>អវិជ្ជមានមិនពិត(%):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ចំនួនកញ្ចក់ឈាមវិជ្ជមានពិត:</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">កញ្ចក់</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ភាពត្រូវគ្នានៃការរកឃើញប្រភេទប៉ារ៉ាស៊ីតគិតជា(%):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ភាពត្រូវគ្នានៃកម្រិតដង់ស៊ីតេប៉ារ៉ាស៊ីតគិតជា(%):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ផ្ទៃឈាមក្រាស់មានគុណភាពមិនល្អ(ទំហំ រូបរាង បរិមាណឈាម)គិតជា(%):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ផ្ទៃឈាមស្តើងមានគុណភាពមិនល្អ(ទំហំ​ រូបរាង បរិមាណឈាម)គិតជា(%):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ភាគរយនៃបំពាក់ពណ៌ផ្ទៃឈាមមានគុណភាពមិនល្អ:</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ភាគរយនៃផ្ទៃឈាមក្រោយបំពាក់ពណ៍មានកំទេចកំទីនិងសាធាតុបន្លំ:</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle" class="form-inline">
						<span>ភាគរយនៃផ្ទៃឈាមក្រាសស្អិត (Slides auto-fixed) (%):</span>
						<span class="input-group" style="width:170px">
							<input type="text" class="form-control text-center" data-bind="value: answer" />
							<span class="input-group-addon">%</span>
						</span>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th rowspan="2" align="center" valign="middle">5.2 កញ្ចក់ឈាមគំរូផ្តល់ដោយអ្នកអភិបាលឲ្យ<br />អ្នកមន្ទីរពិសោធន៍ពិនិត្យរកប៉ារ៉ាស៊ីត</th>
					<th colspan="5" align="center">អ្នកមីក្រូទស្សន៍</th>
				</tr>
				<tr class="info" data-bind="foreach: Array(5)">
					<th align="center" width="120" data-bind="text: $index() + 1"></th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P5_2Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ចំនួនកញ្ចក់ឈាមបានពិនិត្យរកប៉ារ៉ាស៊ីត</td>
					<!-- ko foreach: Array(5) -->
					<td><input type="text" class="form-control text-center" data-bind="value: $parent.answer[$index()]" /></td>
					<!-- /ko -->
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ភាពត្រូវគ្នានៃការរកឃើញប៉ារ៉ាស៊ីតគិតជា(%)</td>
					<!-- ko foreach: Array(5) -->
					<td><input type="text" class="form-control text-center" data-bind="value: $parent.answer[$index()]" /></td>
					<!-- /ko -->
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">វិជ្ជមានមិនពិតគិតជា(%)</td>
					<!-- ko foreach: Array(5) -->
					<td><input type="text" class="form-control text-center" data-bind="value: $parent.answer[$index()]" /></td>
					<!-- /ko -->
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">អវិជ្ជមានមិនពិតគិតជា(%)</td>
					<!-- ko foreach: Array(5) -->
					<td><input type="text" class="form-control text-center" data-bind="value: $parent.answer[$index()]" /></td>
					<!-- /ko -->
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ភាពត្រូវគ្នានៃការរកឃើញប្រភេទប៉ារ៉ាស៊ីតគិតជា(%)</td>
					<!-- ko foreach: Array(5) -->
					<td><input type="text" class="form-control text-center" data-bind="value: $parent.answer[$index()]" /></td>
					<!-- /ko -->
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ភាពត្រូវគ្នានៃកម្រិតដង់ស៊ីតេប៉ារ៉ាស៊ីតគិតជា(%)</td>
					<!-- ko foreach: Array(5) -->
					<td><input type="text" class="form-control text-center" data-bind="value: $parent.answer[$index()]" /></td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
		<br />

		<h4>6. ការត្រួតពិនិត្យនិងធានាគុណភាព</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center"></th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P6Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមន្ទីរពិសោធន៍អនុវត្តតាមមគ្គុទេសក៍ជាតិស្តីអំពីការត្រួតពិនិត្យនិងធានាគុណភាពពេញលេញឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានមគ្គុទេសក៍ផ្លូវការសម្រាប់វិភាគលទ្ធផលត្រួតពិនិត្យគុណភាពផ្ទៃក្នុងនិងបានកែតម្រូវចំណុចខ្វះខាតឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍មីក្រូទស្សន៏នេះដែលបានចូលរួមជាទៀងទាត់នៅក្នុងគ្រោងការសាកល្បងសមត្ថភាព (proficiency testing) ឬទម្រង់ដទៃទៀតនៃ QA ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើការអនុវត្តរបស់មន្ទីរពិសោធន៍មីក្រូទស្សន៍នេះក្នុងគម្រោងធ្វើតេស្តសមត្ថភាព ​(proficiency testing) ឬទម្រង់ផ្សេងទៀតនៃការវាយតម្លៃគុណភាពខាងក្រៅមានភាពល្អប្រសើរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមន្ទីរពិសោធន៍នេះមាននីតិវិធីដើម្បីដោះស្រាយការអនុវត្តមិនល្អនៅក្នុងការធ្វើតេស្តសមត្ថភាព (proficiency testing) ឬទម្រង់ផ្សេងទៀតនៃការវាយតម្លៃគុណភាពខាងក្រៅ (EQA) ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<h4>7. ការរៀបចំបន្ទប់មន្ទីរពិសោធន៍និងបរិស្ថានជុំវិញ</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center"></th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P7Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ទីធ្លាសម្រាប់រៀបចំកញ្ចក់ឈាម (Bench space)</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ឡាវាបូ សំរាប់បំពាក់ពណ៌ និងលាងសំអាតកញ្ចក់ឈាម</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានប្រព័ន្ធទឹកស្អាតប្រើប្រាស់</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានពន្លឺគ្រប់គ្រាន់</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានប្រព័ន្ធអគ្គីសនីប្រើប្រាស់</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានចរន្តខ្យល់ចេញចូលគ្រប់គ្រាន់</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានប្រព័ន្ធថែរក្សានិងទុកដាក់ឧបករណ៍និងសម្ភារៈប្រើប្រាស់ត្រឹមត្រូវ</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ទីកន្លែងទុកដាក់កញ្ចក់ឈាមមិនទាន់បំពាក់ពណ៌និងកញ្ចក់ឈាមបានពិនិត្យរួច</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ទីតាំងទុកដាក់លទ្ធផលអ្នកជំងឺនិងរក្សាការសម្ងាត់</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<h4>8. សុវត្ថិភាពជីវសាស្រ្ត</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center"></th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P8Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍បានពាក់អាវពេទ្យនិងវែនតាការពារឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍បានពាក់ស្រោមដៃឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍រៀបចំទុកដាក់សំណាកឈាមបានល្អឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមន្ទីរពិសោធន៍មានសាប៊ូលាងដៃឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានប្រព័ន្ធអគ្គីសនីសម្រាប់មីក្រូទស្សន៍និងសម្រាប់មន្ទីរពិសោធន៍ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមាន​​ធុងសំរាមសម្រាប់ដាក់កាកសំណល់ស្ងួតដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានធុងដាក់កាកសំណល់អាចឆ្លងរោគឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានធុងដាក់កាកសំណល់មុតស្រួចដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានធុងដាក់កាកសំណល់តាមសេចក្តីណែនាំថ្នាក់ជាតិឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ការបំផ្លាញកាកសំណល់តាមគោលការណ៍ណែនាំថ្នាក់ជាតិឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<h4>9. ឧបករណ៍និងប្រតិករ</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">9.1 មីក្រូទស្សន៍</th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P9_1Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមីក្រូទស្សន៍ភ្នែកពីរមានកែវពង្រីកលេខ១០០អាចប្រើនឹងប្រេងពង្រីកឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមីក្រូទស្សន៍មានអំពូលភ្លើងអាចផ្តល់ពន្លឺគ្រប់គ្រាន់ឲ្យមានរូបភាពច្បាស់នៅពេលដាក់កែវពង្រីកលេខ១០០ដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើកញ្ចក់ឈាមអាចតម្រង់រូបភាពច្បាស់នៅពេលដាក់កែវពង្រីកលេខ១០០ដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ការរំកិលទម្រកញ្ចក់ឈាមអាចតម្រង់រូបភាពច្បាស់និងមានលំនឹង</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមីក្រូទស្សន៍ត្រូវបានដាក់លើទីតាំងមានលំនឹង​និង​មានកន្លែងទូលាយសមស្រប នៅឆ្ងាយពីទីតាំងបំពាក់ពណ៌និងម៉ាស៊ីនរំញ័រ</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មីក្រូទស្សន៍ត្រូវបានប្រើប្រាស់ទៀងទាត់ប្រចាំថ្ងៃឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មីក្រូទស្សន៍ត្រូវសំអាតនិងការពារដោយគម្របឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើមានអំពូលភ្លើងមីក្រូទស្សន៍ បម្រុងឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">9.2 កញ្ចក់ឈាមមីក្រូទស្សន៏</th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P9_2Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើកញ្ចក់ឈាមត្រូវបានជូតសំអាតម៉ត់ចត់មុនយកមកប្រើឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើកញ្ចក់ឈាមមិនមានស្នាមឆូតឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើកញ្ចក់ឈាមមិនមានឡើងពណ៌ខៀវជាប់កញ្ចក់ក្រោយបំពាក់ពណ៌ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើកញ្ចក់ឈាមមិនមានដុះផ្សិតឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">តើកញ្ចក់ឈាមមានដុះផ្សិតត្រូវបានបោះចោលមិនយកមកប្រើទៀតឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">នៅតំបន់មានសំណើមខ្ពស់កញ្ចក់ឈាមត្រូវបានការពារមិនឲ្យមានដុះផ្សិតឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">កញ្ចក់ឈាមត្រូវបានយកមកប្រើច្រើនដងឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">9.3 ប្រតិករសម្រាប់បំពាក់ពណ៌</th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P9_3Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានគ្រប់ប្រតិករសម្រាប់បំពាក់ពណ៌ចាំបាច់ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានប្រតិករសម្រាប់បំពាក់ពណ៌មិនផុតកាលបរិច្ឆេទប្រើប្រាស់ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានសូលុយស្យុងឬប្រតិករសម្រាប់បំពាក់ពណ៌បានទុកដាក់ត្រឹមត្រូវតាមការណែនាំរបស់រោងចក្រឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មាននិយាមប្រតិបត្តិ(SOPs)សម្រាប់លាយសូលុយស្យុងប្រតិករសម្រាប់​​បំពាក់ពណ៌ឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានពិធីសារត្រួតពិនិត្យគុណភាពផ្ទៃក្នុងសម្រាប់លាយសូលុយស្យុងប្រតិករបំពាក់ពណ៌ម្តងៗដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ការលាយល្បាយសូលុយស្យុងសម្រាប់បំពាក់ពណ៌ត្រឹមត្រូវតាមស្តង់ដាដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">គម្របដបប្រតិករបិទជិតល្អ លើកលែងតែបានបើកប្រើហើយមែនដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ប្រតិករបំពាក់ពណ៌ជានិច្ចកាលត្រូវបឺតចេញពីដបដោយពីប៉ែតស្អាត?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មិនត្រូវបន្ថែមទឹកទៅក្នុងដបរក្សាប្រតិករបំពាក់ពណ៌ឡើយមែនឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ប្រតិករបំពាក់ពណ៌យកចេញពីដបមិនត្រូវដាក់ចូលវិញឡើយមែនឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center">9.4 សម្ភារៈទូទៅផ្គត់ផ្គង់ដល់មន្ទីរពិសោធន៍</th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P9_4Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មានអាល់កុលនិងសំឡីសម្រាប់សំអាតស្បែកអ្នកជំងឺមុនបូមឈាមដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ម្ជុលជោះឈាម(Lancets)</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">មេតាណុល</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ហ្សីមសា</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">គ្រាប់ថ្នាំបាសហ្វឺ សម្រាប់លាយកម្រិត pH ទឹក</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ល្បាយសូលុយស្យុងមានកម្រិតpH ត្រឹមត្រូវ</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ក្រឡឬចានសម្រាប់បំពាក់ពណ៌</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">អំពូលភ្លើងមីក្រូទស្សន៍</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ធុងដាក់កាកសំណល់មុតស្រួច</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ខ្មៅដៃ ប៊ិច ក្រហម វែនតាសម្រាប់សរសេរ(glass-writing)</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">អាវមន្ទីរពិសោធន៍</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ស្រោមដៃ</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ទឹកលាងកែវពង្រីក ក្រដាសជូតកែវពង្រីក</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ប៊ិចដិតជាប់</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">កំណត់សម្គាល់កញ្ចក់ឈាម</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ទម្របំពាក់ពណ៌​ (Staining rack)</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ទម្របំពាក់ពណ៌</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ស៊ីឡាំងមានក្រិតទំហំត្រឹមត្រូវ</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ដបដាក់ទឹកសំរាប់លាងកញ្ចក់ឈាមបំពាក់ពណ៍(Pisette)</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">នាឡិការោទិ៍</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ប្រេងពង្រីកមានគុណភាព</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ប្រដាប់រាប់ប៉ារ៉ាស៊ីត​ (Tally counters)</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ប្រអប់ដាក់កញ្ចក់ឈាមរក្សាទុក</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />

		<h4>10. សូចនាករ បំពេញមុខងារ (Performance Indicators)</h4>
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th align="center"></th>
					<th align="center" width="100">ចម្លើយ</th>
					<th align="center" width="300">កំណត់សំគាល់</th>
				</tr>
			</thead>
			<tbody data-bind="with: { P: 'P10Q', Q: 1 }">
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ចំនួនកញ្ចក់ឈាមបានពិនិត្យរកប៉ារ៉ាស៊ីត</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ចំនួនកញ្ចក់ឈាមវិជ្ជមាន</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">បែងចែកតាមប្រភេទប៉ារ៉ាស៊ីត</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ការប្រើប្រាស់សម្ភារៈផ្សេងៗក្នុងផ្នែកមន្ទីរពិសោធន៍</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ការដាច់ស្តុក ប្រតិករ មីក្រូទស្សន៍ប្រចាំខែ</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
				<tr data-bind="with: $parent[P + Q++]">
					<td valign="middle">ការផ្ដល់លទ្ធផលវិភាគរបស់អ្នកពិនិត្យមីក្រូទស្សន៍ទាន់ពេលដែរឬទេ?</td>
					<td valign="middle">
						<select class="form-control en" data-bind="value: answer, options: ['', 'Yes', 'No']"></select>
					</td>
					<td valign="middle">
						<input type="text" class="form-control" data-bind="value: note" />
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<br />

		<p class="text-bold text-center">ការរកឃើញទូទៅ និង អនុសាសន៍</p>
		<textarea class="form-control" rows="10" style="resize:none" data-bind="value: ProblemSolution"></textarea>
	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_Labo.js')?>