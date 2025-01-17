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
		<table class="table table-bordered">
			<tr>
				<th>I. ការគ្រប់គ្រងកម្មវិធីគ្រុនចាញ់ (ក្នុងរយៈពេល៣ខែចុងក្រោយ) 50 ពិន្ទុ</th>
				<th align="center">ពិន្ទុសរុបទទួលបាន</th>
				<th align="center" width="100" data-bind="text: $root.P1score()"></th>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">1</th>
				<th>តើស្រុកប្រតិបត្តិ មានផែនការសកម្មភាពសំរាប់កម្មវិធីគ្រុនចាញ់ដែរឬទេ? 5 ពិន្ទុ</th>
				<th align="center">ពិន្ទុ</th>
				<th align="center">ជម្រើស</th>
				<th align="center">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr data-bind="with: P1Q1_1">
				<td align="center" valign="middle">1.1</td>
				<td valign="middle">ផែនការប្រចាំឆ្នាំ</td>
				<td align="center" valign="middle">1.5</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_1" value="Yes" score="1.5" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_1" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q1_2">
				<td align="center" valign="middle">1.2</td>
				<td valign="middle">ផែនការប្រចាំត្រីមាស</td>
				<td align="center" valign="middle">2</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_2" value="Yes" score="2" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_2" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q1_3">
				<td align="center" valign="middle">1.3</td>
				<td valign="middle">ផែនការប្រចាំខែ</td>
				<td align="center" valign="middle">1.5</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_3" value="Yes" score="1.5" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q1_3" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr>
				<th colspan="3"></th>
				<th align="center" class="bg-info">ពិន្ទុទទួលបាន</th>
				<th align="center" data-bind="text: $root.P1G1score()"></th>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<th colspan="2"></th>
				<th align="center">ពិន្ទុសរុប</th>
				<th align="center">ចម្លើយ ពីលទ្ធផល</th>
				<th align="center">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr>
				<th align="center" valign="middle">2</th>
				<th>តើស្រុកប្រតិបត្តិបានអនុវត្តតាមផែនការដែរឬទេ? ផ្ទៀងផ្ទាត់ជាមួយផែនការថវិកា​ទាំងអស់របស់ស្រុកប្រតិបត្តិ <br /><span class="text-danger">(សកម្មភាពគោលសម្រេចបានធៀបនិងផែនការ គិតជាភាគរយ)</span></th>
				<td align="center" valign="middle">5</td>
				<td align="center" valign="middle" data-bind="text: $root.P1Q2score() + '%'"></td>
				<td align="center" valign="middle" data-bind="text: $root.P1G2score()"></td>
			</tr>
			<tr class="bg-info">
				<th align="center" valign="middle" rowspan="2">លរ</th>
				<th align="center" valign="middle" rowspan="2">ឈ្មោះសកម្មភាព</th>
				<th align="center" valign="middle" rowspan="2">លទ្ធផលគ្រោងទុក<br />(ក្នុងផែនការណ៍)</th>
				<th align="center" valign="middle" colspan="2">លទ្ធផលសម្រេចបាន</th>
			</tr>
			<tr class="bg-info">
				<th align="center">លទ្ធផល</th>
				<th align="center">%</th>
			</tr>
			<tr data-bind="with: P1Q2_1">
				<td align="center" valign="middle">2.1</td>
				<td valign="middle">1.1.3.3 មន្ទីរសុខាភិបាល ស្រុកប្រតិបត្តិ ផ្ដល់ការបណ្ដុះបណ្ដាលបន្ត បុគ្គលិកមណ្ឌលសុខភាព​</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.plan" numonly="int" />
				</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.result" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score() == '' ? '' : Score() + '%'"></td>
			</tr>
			<tr data-bind="with: P1Q2_2">
				<td align="center" valign="middle">2.2</td>
				<td valign="middle">1.1.4.7 ចុះអភិបាលប្រចាំខែដោយ PHD និងប្រចាំត្រីមាសដោយ OD ទៅមណ្ឌលសុខភាពដោយផ្អែកទៅលើ​លទ្ធផលកំរងសំនួរ អេឡិចត្រូនិច ស្មាតហ្វូន​</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.plan" numonly="int" />
				</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.result" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score() == '' ? '' : Score() + '%'"></td>
			</tr>
			<tr data-bind="with: P1Q2_3">
				<td align="center" valign="middle">2.3</td>
				<td valign="middle">4.2.7.3 ប្រជុំសិក្ខាសាលា ដើម្បីធ្វើផែនការសកម្មភាពប្រចាំឆមាសថ្នាក់ក្រោមជាតិ</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.plan" numonly="int" />
				</td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.result" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score() == '' ? '' : Score() + '%'"></td>
			</tr>
			<tr>
				<th colspan="3"></th>
				<th align="center" class="bg-info">មធ្យមភាគ</th>
				<th align="center" data-bind="text: $root.P1Q2score() + '%'"></th>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr>
				<th align="center">3</th>
				<td>តើមានការចែកមុងជ្រលក់ថ្នាំ[1] (LLIN/LLHIN ITN)ក្នុងតំបន់គ្របដណ្តប់ដោយស្រុកប្រតិបត្តិក្នុង៣ខែចុងក្រោយនេះដែរឫទេ?</td>
				<th align="center" class="bg-info"width="60">ពិន្ទុ</th>
				<th align="center" class="bg-info">ជម្រើស</th>
				<th align="center" class="bg-info">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr data-bind="with: P1Q3_1">
				<td align="center" valign="middle">3.1</td>
				<td valign="middle">បើមាន សូមបញ្ជាក់ចំនួនមុងដែលចែកអោយ</td>
				<td align="center" valign="middle">1</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_1" value="Yes" score="1" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_1" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q3_2">
				<td align="center" valign="middle">3.2</td>
				<td valign="middle">បើមាន តើមានរបាយការណ៍ស្តីពីការចែកមុងដែរឬទេ?</td>
				<td align="center" valign="middle">1</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_2" value="Yes" score="1" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_2" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q3_3">
				<td align="center" valign="middle">3.3</td>
				<td valign="middle">តើបានបញ្ចូលរបាយការណ៍នេះទៅក្នុង ប្រព័ន្ធ MIS ដែរឬទេ?</td>
				<td align="center" valign="middle">3</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_3" value="Yes" score="3" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q3_3" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q4">
				<td align="center" valign="middle">4</td>
				<td valign="middle" class="form-inline">
					តើមានសេវាឯកជន (បន្ទប់ពិគ្រោះជំងឺ និងឱសថស្ថាន) ពិនិត្យនិងព្យាបាលជំងឺគ្រុនចាញ់ ក្នុងតំបន់គ្របដណ្តប់​ដោយ​ស្រុកប្រតិបត្តិដែរ​ឬ​ទេ?​
					<br /><br />បើមាន សូមបញ្ជាក់ចំនួន​និងទីកន្លែង៖
					<input type="text" class="form-control" style="width:300px" data-bind="value: Answer.other" />
				</td>
				<td align="center" valign="middle">5</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="Yes" score="0" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q4" value="No" score="5" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q5">
				<td align="center" valign="middle">5</td>
				<td valign="middle">តើមានការរៀចំនិងចូលរួមការប្រជុំសមាជិក (DMEC) តាមស្រុកប្រចាំឆមាសដែរឬទេ? (៦ខែចុងក្រោយ)</td>
				<td align="center" valign="middle">15</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q5" value="Yes" score="15" data-bind="checked: Answer.tick" />
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
				<td valign="middle">តើមានចូលរួមការប្រជុំពីរខែម្តងជាមួយខេត្តទាក់ទងនិងផែនការសកម្មភាពកម្មវីធីគ្រុនចាញ់ដែរឬទេ?</td>
				<td align="center" valign="middle">5</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q6" value="Yes" score="5" data-bind="checked: Answer.tick" />
							<span>មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q6" value="No" score="0" data-bind="checked: Answer.tick" />
							<span>គ្មាន</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q7">
				<td align="center" valign="middle">7</td>
				<td valign="middle">តើស្រុកប្រតិបត្តិផ្ញើរបាយការណ៍រីកចំរើនទៅមន្ទីរសុខាភិបាលបានទាន់ពេលវេលាដែរឬទេ?</td>
				<td align="center" valign="middle">5</td>
				<td>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P1Q7" value="Yes" score="5" data-bind="checked: Answer.tick" />
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
			<tr>
				<th colspan="3"></th>
				<th align="center" class="bg-info">ពិន្ទុទទួលបាន</th>
				<th align="center" data-bind="text: $root.P1G3score()"></th>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">8</th>
				<th>តើមានការចុះត្រួតពិនិត្យតាមដាននិងវាយតំលៃការងារគ្រុនចាញ់ក្នុង៣ខែចុងក្រោយនេះដែរឫទេ?</th>
				<th align="center" width="60">ពិន្ទុ</th>
				<th align="center">ផែនការណ៍</th>
				<th align="center">បញ្ចូលចំនួនបានធ្វើ</th>
				<th align="center">ពិន្ទុទទួលបាន</th>
			</tr>
			<tr data-bind="with: P1Q8_1">
				<td align="center" valign="middle">8.1</td>
				<td valign="middle">តើបានចុះត្រួតពិនិត្យតាមដាននិងវាយតំលៃទៅមណ្ឌលសុខភាពសឬប៉ុស្តិ៍សុខភាពរុប​បានចំនួនប៉ុន្មាន?</td>
				<td align="center" valign="middle">2</td>
				<td align="center" valign="middle">
                    <input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.plan" numonly="int" />
                </td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.result" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q8_2">
				<td align="center" valign="middle">8.2</td>
				<td valign="middle">តើបានចុះត្រួតពិនិត្យតាមដាននិងវាយតំលៃទៅ PPM សរុបបានចំនួនប៉ុន្មានកន្លែង?</td>
				<td align="center" valign="middle">1</td>
				<td align="center" valign="middle">
                    <input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.plan" numonly="int" />
                </td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.result" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P1Q8_3">
				<td align="center" valign="middle">8.3</td>
				<td valign="middle">តើបានចុះត្រួតពិនិត្យតាមដាននិងវាយតំលៃទៅ VMW/MMW សរុបបានចំនួនប៉ុន្មាននាក់?</td>
				<td align="center" valign="middle">2</td>
				<td align="center" valign="middle">
                    <input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.plan" numonly="int" />
                </td>
				<td align="center" valign="middle">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: Answer.result" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr>
				<th colspan="4"></th>
				<th align="center" class="bg-info">ពិន្ទុទទួលបាន</th>
				<th align="center" data-bind="text: $root.P1G4score()"></th>
			</tr>
		</table>
		<br />
		<br />

		<table class="table table-bordered">
			<tr>
				<th>II. សម្ភារៈបរិក្ខារនិង​​ឱសថ៖ (ពិនិត្យពេលចុះអភិបាល) ពិន្ទុសរុប​១០</th>
				<th align="center">ពិន្ទុសរុបទទួលបាន</th>
				<th align="center" width="100" data-bind="text: $root.P2score()"></th>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">#</th>
				<th align="center">ឈ្មោតេស្តនិងថ្នាំ</th>
				<th align="center">សល់ចុងគ្រា</th>
				<th align="center" width="80">ពិន្ទុ</th>
			</tr>
			<tr data-bind="with: P2Q1">
				<td align="center" valign="middle">1</td>
				<td valign="middle" class="form-inline">
					<p>RDT (១ពិន្ទុ)</p>
					<table class="table table-bordered widthauto">
						<tr>
							<td align="center">បរិមានចូល</td>
							<td align="center">បរិមាណចេញ</td>
							<td align="center">តុល្យការ</td>
							<td align="center">AMC</td>
						</tr>
						<tr>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockin" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockout" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.balance" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.amc" numonly="float" /></td>
						</tr>
					</table>
				</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="Under" score="0.5" data-bind="checked: Answer.tick">
							<span>0 &lt; MOS &lt; 3: ឈានទៅរកការដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="Enough" score="1" data-bind="checked: Answer.tick">
							<span>3 &le; MOS &lt; 6: ស្តុកគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q1" value="Over" score="0.5" data-bind="checked: Answer.tick">
							<span>MOS &ge; 6: ស្តុកលើសតំរូវការ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q2">
				<td align="center" valign="middle">2</td>
				<td valign="middle" class="form-inline">
					<p>Artesunate25mg + Mefloquin50mg (A+M) / គ្រាប់ (១ពិន្ទុ)</p>
					<table class="table table-bordered widthauto">
						<tr>
							<td align="center">បរិមានចូល</td>
							<td align="center">បរិមាណចេញ</td>
							<td align="center">តុល្យការ</td>
							<td align="center">AMC</td>
						</tr>
						<tr>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockin" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockout" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.balance" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.amc" numonly="float" /></td>
						</tr>
					</table>
				</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="Under" score="0.5" data-bind="checked: Answer.tick">
							<span>0 &lt; MOS &lt; 3: ឈានទៅរកការដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="Enough" score="1" data-bind="checked: Answer.tick">
							<span>3 &le; MOS &lt; 6: ស្តុកគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q2" value="Over" score="0.5" data-bind="checked: Answer.tick">
							<span>MOS &ge; 6: ស្តុកលើសតំរូវការ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q3">
				<td align="center" valign="middle">3</td>
				<td valign="middle" class="form-inline">
					<p>Artesunate100mg + Mefloquin200mg (A+M) / គ្រាប់ (១ពិន្ទុ)</p>
					<table class="table table-bordered widthauto">
						<tr>
							<td align="center">បរិមានចូល</td>
							<td align="center">បរិមាណចេញ</td>
							<td align="center">តុល្យការ</td>
							<td align="center">AMC</td>
						</tr>
						<tr>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockin" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockout" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.balance" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.amc" numonly="float" /></td>
						</tr>
					</table>
				</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="Under" score="0.5" data-bind="checked: Answer.tick">
							<span>0 &lt; MOS &lt; 3: ឈានទៅរកការដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="Enough" score="1" data-bind="checked: Answer.tick">
							<span>3 &le; MOS &lt; 6: ស្តុកគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q3" value="Over" score="0.5" data-bind="checked: Answer.tick">
							<span>MOS &ge; 6: ស្តុកលើសតំរូវការ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q4">
				<td align="center" valign="middle">4</td>
				<td valign="middle" class="form-inline">
					<p>ថ្នាំព្រីម៉ាគីន (Primaquine 15mg) (០.៥ពិន្ទុ)</p>
					<table class="table table-bordered widthauto">
						<tr>
							<td align="center">បរិមានចូល</td>
							<td align="center">បរិមាណចេញ</td>
							<td align="center">តុល្យការ</td>
							<td align="center">AMC</td>
						</tr>
						<tr>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockin" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockout" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.balance" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.amc" numonly="float" /></td>
						</tr>
					</table>
				</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="Under" score="0.25" data-bind="checked: Answer.tick">
							<span>0 &lt; MOS &lt; 3: ឈានទៅរកការដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="Enough" score="0.5" data-bind="checked: Answer.tick">
							<span>3 &le; MOS &lt; 6: ស្តុកគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q4" value="Over" score="0.25" data-bind="checked: Answer.tick">
							<span>MOS &ge; 6: ស្តុកលើសតំរូវការ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
			<tr data-bind="with: P2Q5">
				<td align="center" valign="middle">5</td>
				<td valign="middle" class="form-inline">
					<p>ថ្នាំព្រីម៉ាគីន (Primaquine 7.5mg) (០.៥ពិន្ទុ)</p>
					<table class="table table-bordered widthauto">
						<tr>
							<td align="center">បរិមានចូល</td>
							<td align="center">បរិមាណចេញ</td>
							<td align="center">តុល្យការ</td>
							<td align="center">AMC</td>
						</tr>
						<tr>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockin" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.stockout" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.balance" numonly="int" /></td>
							<td><input type="text" class="form-control width100 text-center" data-bind="value: Answer.amc" numonly="float" /></td>
						</tr>
					</table>
				</td>
				<td valign="middle">
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q5" value="Under" score="0.25" data-bind="checked: Answer.tick">
							<span>0 &lt; MOS &lt; 3: ឈានទៅរកការដាច់ស្តុក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q5" value="Enough" score="0.5" data-bind="checked: Answer.tick">
							<span>3 &le; MOS &lt; 6: ស្តុកគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" name="P2Q5" value="Over" score="0.25" data-bind="checked: Answer.tick">
							<span>MOS &ge; 6: ស្តុកលើសតំរូវការ</span>
						</label>
					</div>
				</td>
				<td align="center" valign="middle" data-bind="text: Score()"></td>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<th></th>
				<th align="center">ចម្លើយពី MIS</th>
				<th align="center">ពិន្ទុគណនាស្វ័យប្រវត្តិ</th>
			</tr>
			<tr data-bind="with: $root.misAuto('stock','Report')">
				<td>ចំនួនមណ្ឌលសុខភាពដែលបានធ្វើបច្ចុប្បន្នភាពស្តុកឱសថក្នុងប្រព័ន្ធMIS​​​​​​​​​​​​ ២ ពិន្ទុ</td>
				<td align="center" data-bind="text: mis"></td>
				<td align="center" data-bind="text: score"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('stock','ACT')">
				<td>ចំនួនមណ្ឌលសុខភាពដែលមិនមានដាច់ស្តុកឱសថ ២ ពិន្ទុ</td>
				<td align="center" data-bind="text: mis"></td>
				<td align="center" data-bind="text: score"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('stock','RDT')">
				<td>ចំនួនមណ្ឌលសុខភាពដែលមិនមានដាច់ស្តុកតេស្ត ២ ពិន្ទុ</td>
				<td align="center" data-bind="text: mis"></td>
				<td align="center" data-bind="text: score"></td>
			</tr>
		</table>
		<br />
		<br />

		<table class="table table-bordered">
			<tr>
				<th>III. ប្រព័ន្ធព័ត៌មានសុខាភិបាល៖ ពិន្ទុសរុប១០</th>
				<th align="center">ពិន្ទុសរុបទទួលបាន</th>
				<th align="center" width="100" data-bind="text: $root.P3score()"></th>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr>
				<td></td>
				<td align="center" colspan="2">ពីអ្នកស្ម័គ្រចិត្ត 5 ពិន្ទុ</td>
				<td align="center">ពិន្ទុ</td>
				<td align="center" data-bind="text: $root.misAuto('total', 'VMW')"></td>
			</tr>
			<tr class="bg-info">
				<th>ការផ្ទៀងផ្ទាត់របាយការណ៍គ្រុនចាញ់ ក្នុងរយៈពេល៣ខែមុន</th>
				<th align="center">ក្នុងក្រដាសរបាយ​ការណ៍ប្រជុំប្រចាំខែ​</th>
				<th align="center">ក្នុងប្រព័ន្ធ MIS</th>
				<th align="center">មិនបានបញ្ចូល</th>
				<th align="center">ភាគរយ</th>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Test')">
				<td valign="middle">ចំនួនតេស្តសរុប ​(ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស) (Paper- MIS)/ Paper</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Positive')">
				<td valign="middle">ចំនួនតេស្តវិជ្ជមានសរុប (ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស)</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Pf')">
				<td valign="middle">Pf</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Pv')">
				<td valign="middle">Pv</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Mix')">
				<td valign="middle">Mix</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Minor')">
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់កំរិតស្រាលបានទទួលការព្យាបាលសរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Severe')">
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់កំរិតធ្ងន់បានទទួលការព្យាបាលសរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Death')">
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់ស្លាប់សរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('VMW', 'Report')">
				<td valign="middle">ភាគរយនៃអ្នកស្ម័គ្រចិត្តដែលបានបញ្ជូនរបាយការណ៍</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr>
				<th colspan="3"></th>
				<th align="center" class="bg-info">មធ្យមភាគ</th>
				<th align="center" data-bind="text: $root.misAuto('avg', 'VMW')"></th>
			</tr>
		</table>
		<br />
		
		<table class="table table-bordered">
			<tr>
				<td></td>
				<td align="center" colspan="2">មណ្ឌលសុខភាព 5 ពិន្ទុ</td>
				<td align="center">ពិន្ទុ</td>
				<td align="center" data-bind="text: $root.misAuto('total', 'HC')"></td>
			</tr>
			<tr class="bg-info">
				<th>ការផ្ទៀងផ្ទាត់របាយការណ៍គ្រុនចាញ់ ក្នុងរយៈពេល៣ខែមុន</th>
				<th align="center">ក្នុងក្រដាសរបាយ​ការណ៍ប្រជុំប្រចាំខែ​</th>
				<th align="center">ក្នុងប្រព័ន្ធ MIS</th>
				<th align="center">មិនបានបញ្ចូល</th>
				<th align="center">ភាគរយ</th>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Test')">
				<td valign="middle">ចំនួនតេស្តសរុប ​(ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស) (Paper- MIS)/ Paper</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Positive')">
				<td valign="middle">ចំនួនតេស្តវិជ្ជមានសរុប (ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស)</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Pf')">
				<td valign="middle">Pf</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Pv')">
				<td valign="middle">Pv</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Mix')">
				<td valign="middle">Mix</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Minor')">
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់កំរិតស្រាលបានទទួលការព្យាបាលសរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Severe')">
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់កំរិតធ្ងន់បានទទួលការព្យាបាលសរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Death')">
				<td valign="middle">ចំនួនករណីគ្រុនចាញ់ស្លាប់សរុប</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('HC', 'Report')">
				<td valign="middle">ភាគរយនៃមណ្ឌលសុខភាពដែលបានបញ្ជូនរបាយការណ៍</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: paper" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: mis"></td>
				<td align="center" valign="middle" data-bind="text: remain()"></td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
			</tr>
			<tr>
				<th colspan="3"></th>
				<th align="center" class="bg-info">មធ្យមភាគ</th>
				<th align="center" data-bind="text: $root.misAuto('avg', 'HC')"></th>
			</tr>
		</table>
		<br />
		<br />

		<table class="table table-bordered">
			<tr>
				<th>IV. សកម្មភាពលុបបំបាត់ជំងឺគ្រុនចាញ់​(ក្នុងរយៈពេល៣ខែចុងក្រោយ) 30 ពិន្ទុ</th>
				<th align="center">ពិន្ទុសរុបទទួលបាន</th>
				<th align="center" data-bind="text: $root.P4score()"></th>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<td>ចំនួន (MISទាញមកបង្ហាញ)</td>
				<th align="center">PF</th>
				<th align="center">PV</th>
				<th align="center">Mix</th>
				<th align="center">សរុប</th>
			</tr>
			<tr>
				<td>តើស្រុកប្រតិបត្តិ មានករណីគ្រុនចាញ់ Pf & Mix, Pv សរុបប៉ុន្មាន?</td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'pf')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'pv')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'mix')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', ['pf','pv','mix'])"></td>
			</tr>
			<tr>
				<td>ចំនួន L1 ប៉ុន្មានដែលបានរកឃើញ?</td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'pfL1')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'pvL1')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'mixL1')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', ['pfL1','pvL1','mixL1'])"></td>
			</tr>
			<tr>
				<td>ចំនួន LC ប៉ុន្មានដែលបានរកឃើញ?</td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'pfLC')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'pvLC')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'mixLC')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', ['pfLC','pvLC','mixLC'])"></td>
			</tr>
			<tr>
				<td>តើមានសំបុកចម្លងសកម្មចំនួនប៉ុន្មានដែលបានរកឃើញ?</td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'pfFoci')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'pvFoci')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', 'mixFoci')"></td>
				<td align="center" data-bind="text: $root.misAuto('P4G1', ['pfFoci', 'pvFoci','mixFoci'])"></td>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<td></td>
				<td></td>
				<th align="center">ពិន្ទុ</th>
				<th align="center">ចម្លើយចំនួនករណី</th>
				<th align="center">ភាគរយធៀបករណីសរុប</th>
				<th align="center">ពិន្ទទទួលបាន</th>
			</tr>
			<tr data-bind="with: $root.misAuto('P4G2', 'P4Q1')">
				<td align="center" valign="middle">1</td>
				<td valign="middle">តើមានប៉ុន្មានករណីដែលបានរាយការណ៍និងបានអង្កេតតាមដានក្នុងរយៈពេល ២៤ម៉ោង?<br />(ចំនួនរាយការការណ៍ ធៀបចំនួនករណីសរុប)</td>
				<td align="center" valign="middle">12</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: answer" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
				<td align="center" valign="middle" data-bind="text: score()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('P4G2', 'P4Q2')">
				<td align="center" valign="middle">2</td>
				<td valign="middle">តើមានប៉ុន្មានករណីL1ដែលបានឆ្លើយតប ក្នុងរយៈពេល ៧២ម៉ោង?</td>
				<td align="center" valign="middle">4.5</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: answer" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
				<td align="center" valign="middle" data-bind="text: score()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('P4G2', 'P4Q3')">
				<td align="center" valign="middle">3</td>
				<td valign="middle">ចំនួនសំបុកចម្លងសកម្មដែលបានអង្កេតនិងចំណាត់ថ្នាក់ក្នុងរយៈពេល១សប្តាហ៍</td>
				<td align="center" valign="middle">4.5</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: answer" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
				<td align="center" valign="middle" data-bind="text: score()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('P4G2', 'P4Q4')">
				<td align="center" valign="middle">4</td>
				<td valign="middle">ចំនួនសំបុកចម្លងដែលឆ្លើយតប</td>
				<td align="center" valign="middle">4.5</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: answer" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
				<td align="center" valign="middle" data-bind="text: score()"></td>
			</tr>
			<tr data-bind="with: $root.misAuto('P4G2', 'P4Q5')">
				<td align="center" valign="middle">5</td>
				<td valign="middle">តើមានការព្យាបាលផ្តាច់(Radical cure) PV  ចំនួនប៉ុន្មានករណី?​</td>
				<td align="center" valign="middle">4.5</td>
				<td align="center">
					<input type="text" class="form-control width100 text-center" data-bind="textInput: answer" numonly="int" />
				</td>
				<td align="center" valign="middle" data-bind="text: percent()"></td>
				<td align="center" valign="middle" data-bind="text: score()"></td>
			</tr>
		</table>
		<br />
		<br />

		<table class="table table-bordered">
			<tr>
				<th>V. បញ្ហាប្រឈម និង ដំណោះស្រាយ</th>
			</tr>
		</table>
		<br />

		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center" width="40">លរ</th>
				<th align="center">បញ្ហាដែលរកឃើញ សូមសរសេរ តែ២ចំ​នុច</th>
				<th align="center">ដំណោះស្រាយ</th>
				<th align="center" width="200">អ្នកទទួលខុសត្រូវ</th>
				<th align="center" width="150">កាលបរិច្ឆេទ</th>
			</tr>
			<tr data-bind="with: P5Q1">
				<td align="center" valign="middle">1</td>
				<td><input type="text" class="form-control" data-bind="value: Answer.problem" /></td>
				<td><input type="text" class="form-control" data-bind="value: Answer.solution" /></td>
				<td><input type="text" class="form-control" data-bind="value: Answer.person" /></td>
				<td class="relative en">
					<input type="text" class="form-control text-center" data-bind="datePicker: Answer.date, showClear: true" placeholder="DD-MM-YYYY">
				</td>
			</tr>
			<tr data-bind="with: P5Q2">
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

		<table class="table table-bordered">
			<tr class="bg-info">
				<th align="center">ផ្នែក</th>
				<th align="center">ពិន្ទុសរុប</th>
				<th align="center">ពិន្ទុទទួលបាន</th>
				<th align="center">ភាគរយតាមផ្នែក</th>
			</tr>
			<tr>
				<td>I. ការគ្រប់គ្រងកម្មវិធីគ្រុនចាញ់</td>
				<td align="center">50</td>
				<td align="center" data-bind="text: $root.P1score()"></td>
				<td align="center" data-bind="text: ($root.P1score() * 100 / 50).toFixed(0) + '%'"></td>
			</tr>
			<tr>
				<td>II. សម្ភារៈបរិក្ខារនិង​​ឱសថ</td>
				<td align="center">10</td>
				<td align="center" data-bind="text: $root.P2score()"></td>
				<td align="center" data-bind="text: ($root.P2score() * 100 / 10).toFixed(0) + '%'"></td>
			</tr>
			<tr>
				<td>III. ប្រព័ន្ធព័ត៌មានសុខាភិបាល</td>
				<td align="center">10</td>
				<td align="center" data-bind="text: $root.P3score()"></td>
				<td align="center" data-bind="text: ($root.P3score() * 100 / 10).toFixed(0) + '%'"></td>
			</tr>
			<tr>
				<td>IV. សកម្មភាពលុបបំបាត់ជំងឺគ្រុនចាញ់​</td>
				<td align="center">30</td>
				<td align="center" data-bind="text: $root.P4score()"></td>
				<td align="center" data-bind="text: ($root.P4score() * 100 / 30).toFixed(0) + '%'"></td>
			</tr>
			<tr>
				<td>​</td>
				<th align="center" class="bg-info">មធ្យមភាគ</th>
				<th align="center" data-bind="text: $root.grandTotal()"></th>
				<th align="center" data-bind="text: $root.grandTotal().toFixed(0) + '%'"></th>
			</tr>
		</table>
		<br />
		<br />

		<ol>
			<li><p>ពិន្ទុមធ្យមភាគ &le; 75% : ត្រឡប់ទៅអភិបាលវិញនៅ (3ខែ) ត្រីមាសបន្ទាប់</p></li>
			<li><p>ពិន្ទុមធ្យមភាគ &gt; 75% : ត្រឡប់ទៅអភិបាលវិញនៅ (6ខែ) ឆមាសបន្ទាប់</p></li>
		</ol>
	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_MnE_OD.js')?>
