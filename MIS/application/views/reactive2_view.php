<style>
	.form-control { height:26px; padding:2px 5px; }
	.space { margin-left:20px; }
	.underscore { border-bottom:1px solid; display:inline-block; text-align:center; }
	.panel-body { border:1px solid; margin:10px; }
	.width60 { width:60px !important; }
</style>

<div class="panel panel-default" style="display:none" data-bind="visible: true">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 text-bold lh26">Reactive Cases Detection</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save">Save</button>
			<button class="btn btn-danger btn-sm width100" data-bind="click: showDelete">Delete</button>
			<button class="btn btn-default btn-sm width100" onclick="window.close()">Back</button>
		</div>
	</div>
	<div class="panel-body inlineblock">
		<h3 class="kh text-center text-bold">ទម្រង់កត់ត្រា ការស្វែងរកករណីគ្រុនចាញ់ជុំវិញករណីគោល</h3>
		<br />
		<br />
		<!-- ko with: headModel -->
		<p class="form-inline relative">
			<kh>កាលបរិច្ឆេទដែលរកឃើញករណីគោល</kh>
			<input type="text" class="form-control text-center width150" data-bind="datePicker: DateCase" placeholder="DD-MM-YYYY">

			<kh class="space">កូដអ្នកជំងឺ</kh>
			<input type="text" class="form-control text-center width100" data-bind="value: PatientCode">
		</p>
		<p class="form-inline">
			<kh>ឈ្មោះអ្នកជំងឺ</kh>
			<input type="text" class="form-control" data-bind="value: PatientName">

			<kh class="space">លេខអត្តសញ្ញាណប័ណ្ណ</kh>
			<input type="text" class="form-control width150" data-bind="value: PatientIDCard">

			<kh class="space">លេខទូរស័ព្ទ</kh>
			<input type="text" class="form-control width150" data-bind="value: PatientPhone">
		</p>
		<p class="form-inline">
			<kh>អាយុ</kh>
			<input type="text" class="form-control text-center width60" data-bind="value: PatientAge" maxlength="2">
			<kh>(ឆ្នាំ)</kh>

			<kh class="space">ភេទ</kh>
			<label class="radio-inline radio-lg">
				<input type="radio" name="PatientSex" value="M" data-bind="checked: PatientSex">
				<kh>ប្រុស</kh>
			</label>
			<label class="radio-inline radio-lg">
				<input type="radio" name="PatientSex" value="F" data-bind="checked: PatientSex">
				<kh>ស្រី</kh>
			</label>

			<span class="space">GPS <kh>ផ្ទះអ្នកជំងឺ:</kh> Lat:</span>
			<input type="text" class="form-control width150" data-bind="value: Lat">
			<span class="space">Long:</span>
			<input type="text" class="form-control width150" data-bind="value: Long">
		</p>
		<p class="form-inline">
			<kh>ទីកន្លែងស្នាក់នៅ ភូមិ</kh>
			<kh class="underscore minwidth100" data-bind="text: $root.getVLName(Code_Vill_T)"></kh>

			<kh class="space">មណ្ឌលសុខភាព</kh>
			<kh class="underscore minwidth100" data-bind="text: $root.getHCName(Code_Vill_T)"></kh>
			
			<kh class="space">ស្រុកប្រតិបត្តិ</kh>
			<kh class="underscore minwidth100" data-bind="text: $root.getODName(Code_Vill_T)"></kh>
			
			<kh class="space">ខេត្ត</kh>
			<kh class="underscore minwidth100" data-bind="text: $root.getPVName(Code_Vill_T)"></kh>
		</p>
		<div style="margin-left:30px">
			<p class="form-inline">
				<kh>តើអ្នកបានដេកក្នុងព្រៃឬ?</kh>
				<label class="radio-inline radio-lg space">
					<input type="radio" name="ForestSleep" value="No" data-bind="checked: ForestSleep">
					<kh>ទេ</kh>
				</label>
				<kh class="space">បើបាន តើទៅធ្វើអី្វ? ➤</kh>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ForestSleep" value="Farming" data-bind="checked: ForestSleep">
					<kh>ធ្វើកសិកម្ម</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ForestSleep" value="Foresting" data-bind="checked: ForestSleep">
					<kh>រកអនុផលព្រៃឈើ</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ForestSleep" value="Hunting" data-bind="checked: ForestSleep">
					<kh>រកសត្វ</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ForestSleep" value="Fishing" data-bind="checked: ForestSleep">
					<kh>រកត្រី</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ForestSleep" value="Other" data-bind="checked: ForestSleep">
					<kh>ផ្សេងៗ</kh>
				</label>
				<input type="text" class="form-control width150" data-bind="value: ForestSleepOther">
			</p>
			<p class="form-inline">
				<kh>តើអ្នកដេកនៅកន្លែងធ្វើការឬ?</kh>
				<label class="radio-inline radio-lg space">
					<input type="radio" name="Workplace" value="No" data-bind="checked: Workplace">
					<kh>ទេ</kh>
				</label>
				<kh class="space">បើបាន តើទៅធ្វើអី្វ? ➤</kh>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Workplace" value="Crop Farm" data-bind="checked: Workplace">
					<kh>ចំការ</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Workplace" value="Animal Farm" data-bind="checked: Workplace">
					<kh>កសិដ្ឋាន</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Workplace" value="Mining Area" data-bind="checked: Workplace">
					<kh>កន្លែងរករ៉ែ</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Workplace" value="Construction Site" data-bind="checked: Workplace">
					<kh>ការដ្ឋានសំណង់</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Workplace" value="Other" data-bind="checked: Workplace">
					<kh>ផ្សេងៗ</kh>
				</label>
				<input type="text" class="form-control width150" data-bind="value: WorkplaceOther">
			</p>
			<p class="form-inline">
				<kh>តើអ្នកបានដេកក្នុងអ្វី?</kh>
				<label class="radio-inline radio-lg space">
					<input type="radio" name="Shelter" value="House" data-bind="checked: Shelter">
					<kh>ផ្ទះ</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Shelter" value="Hut" data-bind="checked: Shelter">
					<kh>ខ្ទម</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Shelter" value="Tent" data-bind="checked: Shelter">
					<kh>តង់</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Shelter" value="Camp" data-bind="checked: Shelter">
					<kh>ជម្រុំ (តង់)</kh>
				</label>
			</p>
			<p class="form-inline">
				<kh>តើអ្នកបានដេកក្នុង មុងជ្រលក់ថ្នាំ ឬ មុងអង្រឹងដែរឬទេ?</kh>
				<label class="radio-inline radio-lg space">
					<input type="radio" name="Bednet" value="No" data-bind="checked: Bednet">
					<kh>អត់ទេ</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Bednet" value="LLIN" data-bind="checked: Bednet">
					<kh>មុងជ្រលក់ថ្នាំ</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Bednet" value="LLIHN" data-bind="checked: Bednet">
					<kh>មុងអង្រឹង</kh>
				</label>
			</p>
		</div>
		<br />
		<p class="form-inline relative">
			<kh>កាលបរិច្ឆេទនៃការចុះស្វែងរកជុំវិញករណីគោល</kh>
			<input type="text" class="form-control width150 text-center" data-bind="datePicker: InvestigationDate" placeholder="DD-MM-YYYY">
		</p>
		<p class="form-inline">
			<kh>ឈ្មោះអ្នកចុះ</kh>
			<input type="text" class="form-control" data-bind="textInput: Investigator">

			<kh class="space">តួនាទី</kh>
			<input type="text" class="form-control" data-bind="textInput: InvestigatorJob">

			<kh class="space">លេខទូរស័ព្ទ</kh>
			<input type="text" class="form-control width150" data-bind="textInput: InvestigatorPhone">
		</p>
		<p class="form-inline">
			<kh>ចំណាត់ថ្នាក់ករណី</kh>
			<kh>Pf/Mix:</kh>
			<label class="radio-inline radio-lg">
				<input type="radio" name="Rank" value="LC" data-bind="checked: Classify">
				<span>LC</span>
			</label>
			<label class="radio-inline radio-lg">
				<input type="radio" name="Rank" value="IMP" data-bind="checked: Classify">
				<span>IMP</span>
			</label>
			<label class="radio-inline radio-lg" style="margin-left:40px">
				<input type="radio" name="Rank" value="L1" data-bind="checked: Classify">
				<span>Pv: (L1)</span>
			</label>
		</p>
		<!-- /ko -->

		<table class="table table-bordered form-group">
			<thead>
				<tr>
					<td colspan="14" class="kh info">
						<b>ការជោះឈាមរកមេរោគគ្រុនចាញ់លើ២០ខ្នងផ្ទះនៅជុំវិញករណីគោល</b> (ជាពិសេសសមាជិកគ្រួសារ និងអ្នករួមដំណើរជាមួយអ្នកជំងឺ)
					</td>
				</tr>
				<tr>
					<td rowspan="2" class="kh" align="center" valign="middle">ល.រ<br />ខ្នងផ្ទះ</td>
					<td colspan="3" class="kh" align="center">ល.រ សមាជិក</td>
					<td colspan="2" class="kh" align="center">មិនបានជោះឈាម</td>
					<td class="kh" align="center">លទ្ធផលតេស្ត</td>
					<td class="kh" align="center">ការព្យាបាល</td>
					<td colspan="5" class="kh" align="center">កត្តាប្រឈម</td>
					<td rowspan="2"></td>
				</tr>
				<tr>
					<td align="center" valign="middle" class="kh">ល.រ<br />សមាជិក</td>
					<td align="center" valign="middle" class="kh">ភេទ</td>
					<td align="center" valign="middle" class="kh">អាយុ<br />(ឆ្នាំ)</td>
					<td valign="middle" class="kh">អវត្តមាន</td>
					<td valign="middle" class="kh">មិនព្រម</td>
					<td valign="middle">0. <kh>អវិជ្ជមាន</kh><br />1. Pf<br />2. Pv<br />3. Mix</td>
					<td valign="middle">1. ASMQ<br />2. ASMQ + PQ<br />3. Other</td>
					<td valign="middle" class="kh">គ្រុនក្តៅ</td>
					<td valign="middle" class="kh">ដេកក្នុងព្រៃ</td>
					<td align="center" valign="middle" class="kh">ធ្វើដំណើរ<br />ចូលព្រៃ</td>
					<td align="center" valign="middle" class="kh">ប្រវត្តិកើត<br />គ្រុនចាញ់</td>
					<td valign="middle" class="kh">សាច់ញាតិ</td>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td width="60">
						<input type="text" class="form-control text-center" data-bind="value: HouseNumber" maxlength="2" numonly />
					</td>
					<td width="60">
						<input type="text" class="form-control text-center" data-bind="textInput: Member" />
					</td>
					<td width="60">
						<select class="form-control" data-bind="value: Sex, valueAllowUnset: true">
							<option>M</option>
							<option>F</option>
						</select>
					</td>
					<td width="60">
						<input type="text" class="form-control text-center" data-bind="textInput: Age" maxlength="2" numonly />
					</td>
					<td align="center" valign="middle">
						<input type="radio" class="radio-lg" value="Absent" data-bind="checked: Missing, attr: { name: 'M' + $index() }, click: $root.missingClick" />
					</td>
					<td align="center" valign="middle">
						<input type="radio" class="radio-lg" value="Reject" data-bind="checked: Missing, attr: { name: 'M' + $index() }, click: $root.missingClick" />
					</td>
					<td>
						<select class="form-control" data-bind="value: Diagnosis">
							<option></option>
							<option value="N">Negative</option>
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
						</select>
					</td>
					<td>
						<select class="form-control" data-bind="value: Treatment">
							<option></option>
							<option>ASMQ</option>
							<option>ASMQ + PQ</option>
							<option>Other</option>
						</select>
					</td>
					<td align="center">
						<input type="checkbox" class="checkbox-lg" data-bind="checked: Fever" />
					</td>
					<td align="center">
						<input type="checkbox" class="checkbox-lg" data-bind="checked: Forest" />
					</td>
					<td align="center">
						<input type="checkbox" class="checkbox-lg" data-bind="checked: Travel" />
					</td>
					<td align="center">
						<input type="checkbox" class="checkbox-lg" data-bind="checked: History" />
					</td>
					<td align="center">
						<input type="checkbox" class="checkbox-lg" data-bind="checked: Relative" />
					</td>
					<td align="center" valign="middle">
						<a class="text-danger" data-bind="click: $root.remove">Remove</a>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="14">
						<a data-bind="click: addMore">+ Add More</a>
					</td>
				</tr>
			</tfoot>
		</table>

		<div style="border:1px solid #ccc; padding:5px">
			<p class="kh text-bold">ស្រង់ព័ត៌មានសង្ខេបចូលទៅក្នុងតារាងខាងក្រោម</p>
			<p class="form-inline">
				<kh>ចំនួនខ្នងផ្ទះបានចុះពិនិត្យ</kh>
				<span class="underscore width60" data-bind="text: Math.max(...listModel().map(r => r.HouseNumber()))"></span>
				
				<kh>ចំនួនវិជ្ជមាន</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => ['F','V','M'].contain(r.Diagnosis())).length"></span>

				<kh>ចំនួនអវិជ្ជមាន</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => r.Diagnosis() == 'N').length"></span>

				<kh>ចំនួនមិនបានជោះឈាម</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => ['Absent','Reject'].contain(r.Missing())).length"></span>

				<kh>ចំនួនអវត្តមាន</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => r.Missing() == 'Absent').length"></span>
			</p>
			<p class="form-inline">				
				<kh>អ្នកដែលមានតេស្តរហ័សវិជ្ជមាន៖</kh>
				<kh style="margin-left:10px">គ្រុនក្តៅ</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => ['F','V','M'].contain(r.Diagnosis()) && r.Fever()).length"></span>

				<kh>ដេកក្នុងព្រៃ</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => ['F','V','M'].contain(r.Diagnosis()) && r.Forest()).length"></span>
				
				<kh>ធ្វើដំណើរចូលព្រៃ</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => ['F','V','M'].contain(r.Diagnosis()) && r.Travel()).length"></span>
				
				<kh>ប្រវត្តិកើតគ្រុនចាញ់់</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => ['F','V','M'].contain(r.Diagnosis()) && r.History()).length"></span>

				<kh>សាច់ញាតិ</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => ['F','V','M'].contain(r.Diagnosis()) && r.Relative()).length"></span>
			</p>
			<p class="form-inline">
				<kh>អ្នកដែលមានតេស្តរហ័សអវិជ្ជមាន៖ គ្រុនក្តៅ</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => r.Diagnosis() == 'N' && r.Fever()).length"></span>

				<kh>ដេកក្នុងព្រៃ</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => r.Diagnosis() == 'N' && r.Forest()).length"></span>
				
				<kh>ធ្វើដំណើរចូលព្រៃ</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => r.Diagnosis() == 'N' && r.Travel()).length"></span>
				
				<kh>ប្រវត្តិកើតគ្រុនចាញ់់</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => r.Diagnosis() == 'N' && r.History()).length"></span>

				<kh>សាច់ញាតិ</kh>
				<span class="underscore width60" data-bind="text: listModel().filter(r => r.Diagnosis() == 'N' && r.Relative()).length"></span>
			</p>
		</div>
	</div>
	<div class="panel-footer text-center">
		<button class="btn btn-primary btn-sm width150" data-bind="click: save">Save</button>
	</div>
</div>

<?=latestJs('/media/ViewModel/Reactive2.js')?>