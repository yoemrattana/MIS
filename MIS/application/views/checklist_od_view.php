<div class="kh divcenter" data-bind="visible: view() == 'detail'">
	<h3 class="text-center">ការអភិបាលកម្មវីធីជំងឺគ្រុនចាញ់ស្រុកប្រតិបត្តិ</h3>
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
		<p>
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
		</p>
		<p>
			<span>ជួបសម្ភាសជាមួយ៖ ឈ្មោះ</span>
			<input type="text" class="form-control" data-bind="value: Interviewee" />

			<span class="space">តួនាទី</span>
			<input type="text" class="form-control" data-bind="value: IntervieweePosition" />
		</p>
	</div>
	<br />

	<div data-bind="with: detailModel">
		<p class="text-bold">I. ការគ្រប់គ្រងកម្មវិធីគ្រុនចាញ់ (ក្នុងរយៈពេល៣ខែចុងក្រោយ)</p>
		
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">១</th>
				<th>តើស្រុកប្រតិបត្តិ មានផែនការសកម្មភាពសំរាប់កម្មវិធីគ្រុនចាញ់ដែរឬទេ?</th>
				<th align="center">ជម្រើស</th>
			</tr>
			<tr data-bind="with: P1Q1_1">
				<td align="center">១.១</td>
				<td>
					<p>ផែនការប្រចាំឆ្នាំ</p>
					<p class="text-danger">បើមាន សូមពិនិត្យមើលផែនការ<br />បើគ្មាន សូមបញ្ជាក់មូលហេតុ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
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
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q1_2">
				<td align="center">១.២</td>
				<td valign="middle">
					<p>ផែនការប្រចាំត្រីមាស</p>
					<p class="text-danger">បើមាន សូមពិនិត្យមើលផែនការ<br />បើគ្មាន សូមបញ្ជាក់មូលហេតុ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q2" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q2" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="7">២. តើស្រុកប្រតិបត្តិបានអនុវត្តតាមផែនការដែរឬទេ? ផ្ទៀងផ្ទាត់ជាមួយផែនការថវិកាទាំងអស់របស់ស្រុកប្រតិបត្តិ</th>
				</tr>
				<tr class="bg-info">
					<th align="center" width="150">លេខកូដថវិកា</th>
					<th align="center" width="400">ឈ្មោះសកម្មភាព</th>
					<th align="center" width="120">ផែនការ</th>
					<th align="center" width="120">លទ្ធផល</th>
					<th align="center" width="120">ភាគរយ</th>
					<th align="center">កំណត់សម្គាល់</th>
					<th width="35"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: P1Q2">
				<tr>
					<td><input type="text" class="form-control text-center en" data-bind="value: budget" /></td>
					<td><input type="text" class="form-control" data-bind="value: name" /></td>
					<td><input type="text" class="form-control text-center en" data-bind="textInput: plan" numonly="float" /></td>
					<td><input type="text" class="form-control text-center en" data-bind="textInput: result" numonly="float" /></td>
					<td align="center" valign="middle" class="en" data-bind="text: percent()"></td>
					<td><input type="text" class="form-control" data-bind="value: note" /></td>
					<td align="center" valign="middle" class="no-padding" data-bind="click: $root.deleteBudget" role="button">
						<span class="material-icons text-danger">delete_outline</span>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<button class="btn btn-success btn-sm width100 en" data-bind="click: $root.addBudget">Add</button>
					</td>
				</tr>
			</tfoot>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">៣</th>
				<th>តើមានការចែកមុងជ្រលក់ថ្នាំ (LLIN/LLHIN ITN) ក្នុងតំបន់គ្របដណ្តប់ដោយស្រុកប្រតិបត្តិក្នុង៣ខែចុងក្រោយនេះដែរឫទេ?</th>
				<th align="center" width="450">ជម្រើស</th>
			</tr>
			<tr data-bind="with: P1Q3_1">
				<td align="center">៣.១</td>
				<td>
					<p>តើមានការចែកមុងជ្រលក់ថ្នាំ (LLIN/LLHIN) ក្នុងតំបន់គ្របដណ្តប់ដោយស្រុកប្រតិបត្តិក្នុង៣ខែចុងក្រោយនេះដែរឫទេ?</p>
					<p class="text-danger">បើមាន  សូមបញ្ជាក់ចំនួនមុងដែលចែកអោយ<br />បើគ្មាន សូមបញ្ជាក់មូលហេតុ</p>
					<div class="form-inline form-group">
						<div class="input-group">
							<span class="input-group-addon">LLIN</span>
							<input type="text" class="form-control text-center width150" data-bind="value: llin" numonly="int" />
						</div>
						<div class="input-group">
							<span class="input-group-addon">LLIHN</span>
							<input type="text" class="form-control text-center width150" data-bind="value: llihn" numonly="int" />
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_1" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_1" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_1" value="N/A" data-bind="checked: tick" />
							<span>N/A</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q3_2">
				<td align="center">៣.២</td>
				<td>
					<p>បើមាន តើមានរបាយការណ៍ស្តីពីការចែកមុងដែរឬទេ?</p>
					<div class="text-danger">មាន សូមបង្ហាញរបាយការណ៍</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_2" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_2" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q3_3">
				<td align="center">៣.៣</td>
				<td>
					<p>តើបានបញ្ចូលរបាយការណ៍នេះទៅក្នុងប្រព័ន្ធ MIS ដែរឬទេ?</p>
					<div class="text-danger">មាន សូមបង្ហាញរបាយការណ៍</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_3" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_3" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q4">
				<td align="center">៤</td>
				<td>
					<p>តើPHD/ODបានចុះអភិបាលទៅសេវាឯកជន (បន្ទប់ពិគ្រោះជំងឺ និងឱសថស្ថាន) ពិនិត្យរឺព្យាបាលជំងឺគ្រុនចាញ់  ក្នុងតំបន់គ្របដណ្តប់ដោយស្រុកប្រតិបត្តិដែរឬទេ?</p>
					<p class="text-danger">បើមានសេវាឯកជន ហើយពិនិត្យរឺព្យាបាលជំងឺគ្រុនចាញ់   សូមបញ្ជាក់ចំនួននិងទីកន្លែង</p>
					<div class="form-inline form-group">
						<div class="input-group">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control text-center width150" data-bind="value: qty" numonly="int" />
						</div>
						<div class="input-group">
							<span class="input-group-addon">ទីកន្លែង</span>
							<input type="text" class="form-control" data-bind="value: place" />
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-addon">មតិយោបល់</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="មានសេវាឯកជន ហើយពិនិត្យរឺព្យាបាលជំងឺគ្រុនចាញ់" data-bind="checked: tick" />
							<span>មានសេវាឯកជន ហើយពិនិត្យរឺព្យាបាលជំងឺគ្រុនចាញ់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="មានសេវាឯកជន ប៉ុន្តែគ្មានពិនិត្យរឺព្យាបាលជំងឺគ្រុនចាញ់ទេ" data-bind="checked: tick" />
							<span>មានសេវាឯកជន ប៉ុន្តែគ្មានពិនិត្យរឺព្យាបាលជំងឺគ្រុនចាញ់ទេ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="គ្មានសេវាឯកជន" data-bind="checked: tick" />
							<span>គ្មានសេវាឯកជន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q5">
				<td align="center">៥</td>
				<td>
					<p>នៅពេលមានប្រជុំប្រចាំខែ/ត្រីមាស តើអ្នកស្ម័គ្រចិត្ដភូមិព្យាបាលជម្ងឺគ្រុនចាញ់បានទទួលប្រាក់ឧបត្ថម្ភ និងបានទទួលប្រាក់ទូរស័ព្ទប្រចាំខែ/ត្រីមាស នៅពេលណា? ដោយមធ្យោបាយអ្វី?</p>
					<div class="input-group">
						<span class="input-group-addon">មតិយោបល់</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q5" value="ក្នុងថ្ងៃប្រជុំ" data-bind="checked: tick" />
							<span>ក្នុងថ្ងៃប្រជុំ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q5" value="ក្រោយថ្ងៃប្រជុំ" data-bind="checked: tick" />
							<span>ក្រោយថ្ងៃប្រជុំ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q5x" value="សាច់ប្រាក់ផ្ទាល់" data-bind="checked: money" />
							<span>សាច់ប្រាក់ផ្ទាល់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q5x" value="អេឡិចត្រូវនីក(Wing, E-Money)" data-bind="checked: money" />
							<span>អេឡិចត្រូវនីក(Wing, E-Money)</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P1Q6">
				<td align="center">៦</td>
				<td class="relative">
					<p>តើស្រុកប្រតិបត្តិផ្ញើរបាយការណ៍រីកចំរើនទៅមន្ទីរសុខាភិបាលបានទាន់ពេលវេលាដែរឬទេ?</p>
					<p class="text-danger">កាលបរិច្ឆេទបានផ្ញើរបាយការណ៍</p>
					<div class="input-group">
						<span class="input-group-addon">កាលបរិច្ឆេទ</span>
						<input type="text" class="form-control width150 text-center" data-bind="datePicker: date, showClear: true" placeholder="DD-MM-YYYY">
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q6" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q6" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				  
				</td>
			</tr>
			<tr data-bind="with: P1Q7">
				<td align="center">៧</td>
				<td>
					<p>តើមណ្ឌលសុខភាពដែលគ្របដណ្តប់បានបញ្ជូនរបាយការណ៍គ្រប់ជ្រុងជ្រោយទៅស្រុកប្រតិបត្តិដែររឺទេ?</p>
					<p class="text-danger">បើគ្មាន សូមបញ្ជាក់មូលហេតុ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q7" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q7x" value="របាយការណ៍ប្រចំាខែ HC1" data-bind="checked: report" />
							<span>របាយការណ៍ប្រចំាខែ HC1</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q7x" value="សៀវភៅសម្រង់ទិន្នន័យជំងឺគ្រុនចាញ់ប្រចាំខែ (Malaria Logbook)" data-bind="checked: report" />
							<span>សៀវភៅសម្រង់ទិន្នន័យជំងឺគ្រុនចាញ់ប្រចាំខែ (Malaria Logbook)</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q7x" value="របាយការណ៍សកម្មភាពប្រចាំខែរបស់ VMW" data-bind="checked: report" />
							<span>របាយការណ៍សកម្មភាពប្រចាំខែរបស់ VMW</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q7x" value="របាយការណ៍មុង" data-bind="checked: report" />
							<span>របាយការណ៍មុង</span>
						</label>
					</div>
					 <div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P1Q7x" value="របាយការណ៍ផ្សេងៗ" data-bind="checked: report" />
							<span>របាយការណ៍ផ្សេងៗ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q7" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">៨</th>
				<th>តើស្រុកប្រតិបត្តិមានការចុះអភិបាលការងារគ្រុនចាញ់ក្នុង៣ខែចុងក្រោយនេះដែរឫទេ?</th>
				<th align="center" width="150">ផែនការណ៍</th>
				<th align="center" width="150">បញ្ចូលចំនួនបានធ្វើ</th>
				<th align="center">ភាគរយ</th>
			</tr>
			<tr data-bind="with: P1Q8_1">
				<td align="center">៨.១</td>
				<td>
					<p>តើស្រុកប្រតិបត្តិមានការចុះអភិបាលការងារគ្រុនចាញ់ទៅមណ្ឌលសុខភាពឬប៉ុស្តិ៍សុខភាពសរុបបានប៉ុន្មានដង?</p>
					<p class="text-danger">សូមបញ្ជាក់ចំនួនមណ្ឌលសុខភាពឬប៉ុស្តិ៍សុខភាព</p>
					<div class="input-group">
						<span class="input-group-addon">ចំនួន</span>
						<input type="text" class="form-control text-center width150" data-bind="value: qty" numonly="int" />
					</div>
				</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control text-center" data-bind="textInput: plan" numonly="int" /></td>
				<td align="center" valign="middle">
					<input type="text" class="form-control text-center" data-bind="textInput: done" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: P1Q8_2">
				<td align="center">៨.២</td>
				<td>
					<p>តើស្រុកប្រតិបត្តិមានការចុះអភិបាលការងារគ្រុនចាញ់ទៅ VMW/MMW សរុបបានចំនួនប៉ុន្មានដង?</p>
					<p class="text-danger">សូមបញ្ជាក់ចំនួនVMW/MMW</p>
					<div class="input-group">
						<span class="input-group-addon">ចំនួន</span>
						<input type="text" class="form-control text-center width150" data-bind="value: qty" numonly="int" />
					</div>
				</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control text-center" data-bind="textInput: plan" numonly="int" />
				</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control text-center" data-bind="textInput: done" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
		</table>
		<br />
		<br />

		<p class="text-bold">II. សម្ភារៈបរិក្ខារនិងឱសថ៖ (ពិនិត្យពេលចុះអភិបាល)</p>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center">ជម្រើស</th>
			</tr>
			<tr data-bind="with: P2Q1">
				<td align="center">១</td>
				<td class="relative">
					<p>តើស្តុកឱសថគ្រុនចាញ់នៅស្រុកប្រតិបតិ្តមានស្ថានភាពយ៉ាងដូចម្តេច?</p>
					<p class="text-danger">សូមបញ្ជាក់ប្រភេទឱសថ ចំនួន និង កាលបរិច្ឆេទ</p>
					<div class="form-inline">
						<div class="input-group">
							<span class="input-group-addon">ប្រភេទឱសថ</span>
							<select type="text" class="form-control width150 en" data-bind="value: medicine">
								<option></option>
								<option>Pyramax sachet</option>
								<option>Primaquine</option>
								<option>ASMQ</option>
								<option>Other</option>
							</select>
						</div>
						<div class="input-group">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control width100 text-center" data-bind="value: qty" numonly="int">
						</div>
						<div class="input-group">
							<span class="input-group-addon">កាលបរិច្ឆេទ</span>
							<input type="text" class="form-control width150 text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: date, showClear: true">
						</div>
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="មានស្តុកគ្រប់គ្រាន់" data-bind="checked: tick" />
							<span>មានស្តុកគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="ស្តុកលើសតម្រូវការ" data-bind="checked: tick" />
							<span>ស្តុកលើសតម្រូវការ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="ឈានទៅរកដាច់ស្តុក" data-bind="checked: tick" />
							<span>ឈានទៅរកដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q2">
				<td align="center">២</td>
				<td class="relative">
					<p>តើស្តុកតេស្តគ្រុនចាញ់នៅស្រុកប្រតិបតិ្តមានស្ថានភាពយ៉ាងដូចម្តេច?</p>
					<p class="text-danger">សូមបញ្ជាក់ប្រភេទតេស្ត ចំនួន និង កាលបរិច្ឆេទ</p>
					<div class="form-inline">
						<div class="input-group">
							<span class="input-group-addon">ប្រភេទតេស្ត</span>
							<input type="text" class="form-control width150" data-bind="value: test" numonly="int">
						</div>
						<div class="input-group">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control width100 text-center" data-bind="value: qty" numonly="int">
						</div>
						<div class="input-group">
							<span class="input-group-addon">កាលបរិច្ឆេទ</span>
							<input type="text" class="form-control width150 text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: date, showClear: true">
						</div>
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="មានស្តុកគ្រប់គ្រាន់" data-bind="checked: tick" />
							<span>មានស្តុកគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="ស្តុកលើសតម្រូវការ" data-bind="checked: tick" />
							<span>ស្តុកលើសតម្រូវការ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="ឈានទៅរកដាច់ស្តុក" data-bind="checked: tick" />
							<span>ឈានទៅរកដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="ដាច់ស្តុក" data-bind="checked: tick" />
							<span>ដាច់ស្តុក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q3">
				<td align="center">៣</td>
				<td class="relative">
					<p>តើស្រុកប្រតិបត្តិមានរក្សាទុកឱសថគ្រុនចាញ់ដែលផុតកាលបរិច្ឆេទដែរទេ?</p>
					<p class="text-danger">បើមានឱសថគ្រុនចាញ់ដែលផុតកាលបរិច្ឆេទ សូមបញ្ជាក់ប្រភេទឱសថ ចំនួន និង កាលបរិច្ឆេទ និងមូលហេតុ</p>
					<div class="form-inline form-group">
						<div class="input-group">
							<span class="input-group-addon">ប្រភេទឱសថ</span>
							<select type="text" class="form-control width150 en" data-bind="value: medicine">
								<option></option>
								<option>Pyramax sachet</option>
								<option>Primaquine</option>
								<option>ASMQ</option>
								<option>Other</option>
							</select>
						</div>
						<div class="input-group">
							<span class="input-group-addon">ចំនួន</span>
							<input type="text" class="form-control width100 text-center" data-bind="value: qty" numonly="int">
						</div>
						<div class="input-group">
							<span class="input-group-addon">កាលបរិច្ឆេទ</span>
							<input type="text" class="form-control width150 text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: date, showClear: true">
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
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
					<p>តើស្រុកប្រតិបត្តិបានបញ្ជទិន្នន័យស្តុកឱសថគ្រុនចាញ់ក្នុង MIS បានត្រឹមត្រូវដែររឺទេ?</p>
					<p class="text-danger">សូមបញ្ជាក់ភាពមិនស៊ីគ្នានៃចំនួនជាក់ស្តែង និង ប្រព័ន្ធMIS</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="ត្រឹមត្រូវ" data-bind="checked: tick" />
							<span>ត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="មិនត្រឹមត្រូវ" data-bind="checked: tick" />
							<span>មិនត្រឹមត្រូវ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q5">
				<td align="center">៥</td>
				<td>
					<p>តើស្រុកប្រតិបត្តិបានបញ្ជូលទិន្នន័យស្តុកតេស្តគ្រុនចាញ់ក្នុងប្រព័ន្ធMISបានត្រឹមត្រូវដែររឺទេ?</p>
					<p class="text-danger">សូមបញ្ជាក់ភាពមិនស៊ីគ្នានៃចំនួនជាក់ស្តែង និង ប្រព័ន្ធMIS</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
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
					<p>តើមណ្ឌលសុខភាពដែលនៅក្រោមស្រុកប្រតិបត្តិបានធ្វើបច្ចុប្បន្នភាពស្តុកឱសថគ្រុនចាញ់ក្នុងប្រព័ន្ធMISដែរទេ?</p>
					<p class="text-danger">បើមិនបាន សូមបញ្ជាក់មូលហេតុ</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q6" value="បាន" data-bind="checked: tick" />
							<span>បាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q6" value="មិនបាន" data-bind="checked: tick" />
							<span>មិនបាន</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P2Q7">
				<td align="center">៧</td>
				<td>
					<p>តើមណ្ឌលសុខភាពដែលនៅក្រោមស្រុកប្រតិបត្តិមានដាច់ស្តុកឱសថគ្រុនចាញ់ដែរទេ?</p>
					<p class="text-danger">បើសិនជាមាន សូមបញ្ជាក់ចំនួនHC និងមូលហេតុ</p>
					<div style="display:flex">
						<div class="input-group">
							<span class="input-group-addon">ចំនួន HC</span>
							<input type="text" class="form-control text-center width150" data-bind="value: qty" numonly="ïnt" />
						</div>
						<div class="input-group width100p" style="margin-left:5px">
							<span class="input-group-addon">មូលហេតុ</span>
							<input type="text" class="form-control" data-bind="value: reason" />
						</div>
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
					<p>តើមណ្ឌលសុខភាពដែលនៅក្រោមស្រុកប្រតិបត្តិមានដាច់ស្តុកតេស្តគ្រុនចាញ់ដែរទេ?</p>
					<p class="text-danger">បើសិនជាមាន សូមបញ្ជាក់ចំនួនHC និងមូលហេតុ</p>
					<div style="display:flex">
						<div class="input-group">
							<span class="input-group-addon">ចំនួន HC</span>
							<input type="text" class="form-control text-center width150" data-bind="value: qty" numonly="ïnt" />
						</div>
						<div class="input-group width100p" style="margin-left:5px">
							<span class="input-group-addon">មូលហេតុ</span>
							<input type="text" class="form-control" data-bind="value: reason" />
						</div>
					</div>
				</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q8" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q8" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
			</tr>
		</table>
		<br />
		<br />

		<p class="text-bold">III. ប្រព័ន្ធព័ត៌មានជំងឺគ្រុនចាញ់៖</p>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center" width="600">ជម្រើស</th>
			</tr>
			<tr data-bind="with: P3Q1">
				<td align="center">១</td>
				<td>តើអ្នកទទួលខុសត្រូវលើប្រព័ន្ធព័ត៌មានសុខាភិបាល បានទទួលការបណ្តុះបណ្តាល បច្ចុប្បន្នភាពអំពីប្រព័ន្ធពត៌មានជំងឺគ្រុនចាញ់ (MIS) ដែរឬទេ?</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q1" value="មាន" data-bind="checked: tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q1" value="គ្មាន" data-bind="checked: tick" />
							<span>គ្មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q1" value="N/A" data-bind="checked: tick" />
							<span>N/A</span>
						</label>
					</div>
				</td>
			</tr>
			<tr data-bind="with: P3Q2">
				<td align="center">២</td>
				<td>បើមាន តើបានទទួលការបណ្តុះបណ្តាលMIS ចុងក្រោយពេលណា?</td>
				<td class="relative">
					<div class="input-group">
						<span class="input-group-addon">កាលបរិច្ឆេទ</span>
						<input type="text" class="form-control width150 text-center" data-bind="datePicker: date, showClear: true" placeholder="DD-MM-YYYY" />
					</div>
				</td>
			</tr>
			<tr data-bind="with: P3Q3">
				<td align="center">៣</td>
				<td>តើអ្នកត្រូវការអោយមានការបណ្តុះបណ្តាលបន្ថែមឬរំលឹកដល់បុគ្គលិកសុខាភិបាលឬ អ្នកស្ម័គ្រចិត្តភូមិរបស់អ្នកដែរឬទេ?</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3" value="បាទ/ចាស" data-bind="checked: tick" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P3Q3" value="ទេ" data-bind="checked: tick" />
							<span>ទេ</span>
						</label>
					</div>
					<br />

					<p class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" data-bind="checked: od" />
							<span>ស្រុកប្រតិបត្តិ</span>
						</label>
					</p>
					<div class="input-group">
						<span class="input-group-addon">ប្រធានបទ</span>
						<input type="text" class="form-control" data-bind="value: od_topic" />
					</div>
					<br />

					<p class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" data-bind="checked: hc" />
							<span>មណ្ឌលសុខភាព</span>
						</label>
					</p>
					<div class="input-group">
						<span class="input-group-addon">ប្រធានបទ</span>
						<input type="text" class="form-control" data-bind="value: hc_topic" />
					</div>
					<br />

					<p class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" data-bind="checked: vmw" />
							<span>អ្នកស្ម័គ្រចិត្ត</span>
						</label>
					</p>
					<div class="input-group">
						<span class="input-group-addon">ប្រធានបទ</span>
						<input type="text" class="form-control" data-bind="value: vmw_topic" />
					</div>
				</td>
			</tr>
		</table>
		<br />

		<table class="table table-bordered" data-bind="with: P3Q4">
			<tr class="bg-info">
				<th align="center" width="40">ល.រ</th>
				<th align="center" width="420">ការផ្ទៀងផ្ទាត់របាយការណ៍គ្រុនចាញ់</th>
				<th align="center" width="250">ក្នុងក្រដាសរបាយការណ៍ប្រជុំប្រចាំខែ</th>
				<th align="center" width="120">ក្នុងប្រព័ន្ធ MIS</th>
				<th align="center" width="120">លម្អៀង</th>
				<th align="center">កំណត់សម្គាល់</th>
			</tr>
			<tr>
				<td align="center" valign="middle">១</td>
				<td valign="middle">ចំនួនតេស្តសរុប (ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស)</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: test" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().test"></td>
				<td align="center" valign="middle" data-bind="text: test().toFloat() - ($root.misData().test || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: test_note" />
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle">២</td>
				<td valign="middle">ចំនួនតេស្តវិជ្ជមានសរុប (ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស)</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: positive" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().positive"></td>
				<td align="center" valign="middle" data-bind="text: positive().toFloat() - ($root.misData().positive || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: positive_note" />
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle"></td>
				<td valign="middle">Pf</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: pf" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().pf"></td>
				<td align="center" valign="middle" data-bind="text: pf().toFloat() - ($root.misData().pf || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: pf_note" />
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle"></td>
				<td valign="middle">Pv</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: pv" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().pv"></td>
				<td align="center" valign="middle" data-bind="text: pv().toFloat() - ($root.misData().pv || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: pv_note" />
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle"></td>
				<td valign="middle">Mix</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: mix" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().mix"></td>
				<td align="center" valign="middle" data-bind="text: mix().toFloat() - ($root.misData().mix || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: mix_note" />
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle"></td>
				<td valign="middle">Other (PO, PK, PM)</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: other" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().other"></td>
				<td align="center" valign="middle" data-bind="text: other().toFloat() - ($root.misData().other || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: other_note" />
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle">៣</td>
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់កំរិតស្រាលបានទទួលការព្យាបាលសរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: minor" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().minor"></td>
				<td align="center" valign="middle" data-bind="text: minor().toFloat() - ($root.misData().minor || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: minor_note" />
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle">៤</td>
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់កំរិតធ្ងន់បានទទួលការព្យាបាលសរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: severe" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().severe"></td>
				<td align="center" valign="middle" data-bind="text: severe().toFloat() - ($root.misData().severe || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: severe_note" />
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle">៥</td>
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់ស្លាប់សរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: death" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: $root.misData().hcDeath"></td>
				<td align="center" valign="middle" data-bind="text: death().toFloat() - ($root.misData().hcDeath || 0)"></td>
				<td align="center">
					<input type="text" class="form-control" data-bind="value: death_note" />
				</td>
			</tr>
		</table>
		<br />
		<br />

		<p class="text-bold">IV. សកម្មភាពអង្កេតតាមដានជំងឺគ្រុនចាញ់ (ក្នុងរយៈពេល៣ខែចុងក្រោយ)</p>
		<table class="table table-bordered">
			<tr class="bg-info">
				<th width="40" align="center">ល.រ</th>
				<th align="center">សំនួរ</th>
				<th align="center">ចម្លើយចំនួនករណី</th>
				<th align="center">ភាគរយធៀបករណីសរុប</th>
			</tr>
			<tr data-bind="with: P4Q1">
				<td align="center">១</td>
				<td>
					<p>តើមានប៉ុន្មានករណីដែលបានរាយការណ៍និងបានអង្កេតតាមដានក្នុងរយៈពេល ២៤ម៉ោង?<br />(ចំនួនរាយការការណ៍ ធៀបចំនួនករណីសរុប)</p>
					<p class="text-danger">ករណីមិនបានរាយការណ៍ សូមបញ្ជាក់</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: qty" numonly="int" />
				</td>
				<td align="center" data-bind="text: (qty().toFloat() * 100 / ($root.misData().positive || 1)).toFixed(0) + '%'"></td>
			</tr>
			<tr data-bind="with: P4Q2">
				<td align="center">២</td>
				<td>
					<p>តើមានប៉ុន្មានករណីដែលបានធ្វើការរុករកកណីសកម្មសារជាថ្មីក្នុងរយៈពេល ៣ថ្ងៃ?</p>
					<p class="text-danger">ករណីមិនបានអង្កេតតាមដាន សូមបញ្ជាក់</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: qty" numonly="int" />
				</td>
				<td align="center" data-bind="text: (qty().toFloat() * 100 / ($root.misData().positive || 1)).toFixed(0) + '%'"></td>
			</tr>
			<tr data-bind="with: P4Q3">
				<td align="center">៣</td>
				<td>
					<p>ចំនួនសំបុកចម្លងភូមិ L1 ដែលបានអង្កេត ក្នុងរយៈពេល១សប្តាហ៍</p>
					<p class="text-danger">ករណីមិនបានអង្កេតតាមដាន សូមបញ្ជាក់</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: qty" numonly="int" />
				</td>
				<td align="center" data-bind="text: (qty().toFloat() * 100 / ($root.misData().pfL1 || 1)).toFixed(0) + '%'"></td>
			</tr>
			<tr data-bind="with: P4Q4">
				<td align="center">៤</td>
				<td>
					<p>ចំនួនសំបុកចម្លងដែលឆ្លើយតប តើចំនួនសំបុកចម្លងដែលមឆ្លើយតបមានប៉ុន្មាន?</p>
					<p>ឆ្លើយតបដោយសកម្មភាពណាមួយក្នុងចំណោមខាងក្រោម៖</p>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P4Q4" value="VMW/MMWs" data-bind="checked: tick" />
							<span>VMW/MMWs: ជ្រើសរើស VMW/MMWs បើសិនភូមិមិនទាន់មាន VMW/MMWs</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P4Q4" value="ITN/Forest Pack" data-bind="checked: tick" />
							<span>ITN/Forest Pack: ចែកមុងបំពេញបន្ថែម</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P4Q4" value="AFS" data-bind="checked: tick" />
							<span>AFS: ការចុះពិនិត្យស្រាវជ្រាវរកគ្រុនក្តៅពីផ្ទះមួយទៅផ្ទះមួយប្រចាំសប្តាហ៍</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P4Q4" value="TDA" data-bind="checked: tick" />
							<span>TDA: ផ្តល់ថ្នាំសម្រាប់ប្រជាជនគោលដៅ ចំពោះតែបុរសអាយុ ចាប់ពី 15 - 49 ឆ្នាំ</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="P4Q4" value="IPTf" data-bind="checked: tick" />
							<span>IPTf: សម្រាប់ការលេបថ្នាំការពារជាមុន (IPT) សម្រាប់អ្នកចូលព្រៃ</span>
						</label>
					</div>
					<br />
					<p class="text-danger">ករណីមិនបានឆ្លើយតប សូមបញ្ជាក់</p>
					<div class="input-group">
						<span class="input-group-addon">មូលហេតុ</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: qty" numonly="int" />
				</td>
				<td align="center" data-bind="text: (qty().toFloat() * 100 / ($root.misData().pfFoci || 1)).toFixed(0) + '%'"></td>
			</tr>
			<tr data-bind="with: P4Q5">
				<td align="center">៥</td>
				<td>
					<p>តើអ្នកជម្ងឺ PV ចំនួនប៉ុន្មានករណី ដែលបានធ្វើតេស្ត G6PD? (ចែកនឹងចំនួនករណី PV សរុប)</p>
					<div class="input-group">
						<span class="input-group-addon">មតិយោបល់</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: qty" numonly="int" />
				</td>
				<td align="center" data-bind="text: (qty().toFloat() * 100 / ($root.misData().pv || 1)).toFixed(0) + '%'"></td>
			</tr>
			<tr data-bind="with: P4Q6">
				<td align="center">៦</td>
				<td>
					<p>តើអ្នកជម្ងឺ PV ចំនួនប៉ុន្មានករណី ដែលមាន G6PD ត្រូវលក្ខខណ្ឌ? (ចែកនឹងចំនួនករណី PV សរុប)</p>
					<div class="input-group">
						<span class="input-group-addon">មតិយោបល់</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: qty" numonly="int" />
				</td>
				<td align="center" data-bind="text: (qty().toFloat() * 100 / ($root.misData().pv || 1)).toFixed(0) + '%'"></td>
			</tr>
			<tr data-bind="with: P4Q7">
				<td align="center">៧</td>
				<td>
					<p>តើមានការព្យាបាលផ្តាច់ (Radical cure) PV នៅថ្ងៃទី៧ និងសប្តាហ៍ទី៨ ចំនួនប៉ុន្មានករណី? (ចែកនឹងចំនួនអ្នកបានតេស្ត G6PD)</p>
					<p class="text-danger">ករណីមិនបានព្យាបាលផ្តាច់ សូមបញ្ជាក់</p>
					<div class="input-group">
						<span class="input-group-addon">មតិយោបល់</span>
						<input type="text" class="form-control" data-bind="value: reason" />
					</div>
				</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: qty" numonly="int" />
				</td>
				<td align="center" data-bind="text: (qty().toFloat() * 100 / ($parent.P4Q6.qty().toFloat() || 1)).toFixed(0) + '%'"></td>
			</tr>
		</table>
		<br />
		<br />

		<p class="text-bold">V. បញ្ហាប្រឈម និង ដំណោះស្រាយ</p>
		<p class="text-danger">ការណែនាំ៖ សូមសរសេរបញ្ហាចម្បងនិងទូទៅ ដែលក្រុមការងារចុះអភិបាលបានរកឃើញ</p>

		<table class="table table-bordered">
			<thead>
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
			<tbody data-bind="foreach: P5">
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

<?=latestJs('/media/ViewModel/Checklist_OD.js')?>
