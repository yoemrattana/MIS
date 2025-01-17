<!-- ko if: masterModel() != null && masterModel().FormType() == 'Old' -->
<table class="table table-bordered" data-bind="with: detailModel">
	<tr>
		<td colspan="5" class="kh">
			<b>ការណែនាំ</b>
			<ul>
				<li>
					<b>សូមកត់ត្រាចំលើយក្នុងប្រអប់ ☑ ខាងក្រោមនេះ</b>
				</li>
				<li>
					<b>ក្នុងករណីទូទៅ</b>
					<ul>
						<li>ចំលើយ “បាទ/ចាស៎” ទទួលពិន្ទុពេញ</li>
						<li>ចំលើយ “ទេ” ទទួលពិន្ទុ 0</li>
					</ul>
				</li>
			</ul>
		</td>
	</tr>
	<tr>
		<th colspan="5" class="kh pink">ផ្នែកទី ១៖ ព័ត៌មានទូទៅ</th>
	</tr>
	<tr class="kh">
		<th align="center">ល.រ</th>
		<th align="center">សំនួរ</th>
		<th align="center">ចំលើយ</th>
		<th align="center">ពិន្ទុសរុប</th>
		<th align="center">ពិន្ទុ</th>
	</tr>
	<tr>
		<td></td>
		<td class="kh">តើអ្នកបានទទួលការបណ្តុះបណ្តាលចុងក្រោយបំផុតនៅពេលណា?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="0.1" value="≤ 6 Months" data-bind="checked: $root.getAnswer($element)" />
					<span>1. ≤ 6 ខែ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="0.1" value="7 Months - 12 Months" data-bind="checked: $root.getAnswer($element)" />
					<span>2. 7 ខែ - 12 ខែ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="0.1" value="13 Months - 24 Months" data-bind="checked: $root.getAnswer($element)" />
					<span>3. 13 ខែ - 24 ខែ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="0.1" value="No" data-bind="checked: $root.getAnswer($element)" />
					<span>4. ទេ</span>
				</label>
			</div>
		</td>
		<td class="pink gray"></td>
		<td class="pink gray"></td>
	</tr>
	<tr>
		<td></td>
		<td class="kh">តើអ្នកដែលកំពុងវាស់វែងជាមនុស្សប្រុសឬស្រី?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="0.2" value="Male" data-bind="checked: $root.getAnswer($element)" />
					<span>1. ប្រុស</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="0.2" value="Female" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ស្រី</span>
				</label>
			</div>
		</td>
		<td class="pink gray"></td>
		<td class="pink gray"></td>
	</tr>
	<tr>
		<th colspan="5" class="kh pink">ផ្នែកទី ២៖ ការធ្វើតេស្ត</th>
	</tr>
	<tr>
		<td align="center">1</td>
		<th colspan="2" class="kh">សាកសួរព័ត៌មានរបស់អ្នកជំងឺ (តើព័ត៌មានអ្វីខ្លះដែល VMW សួរទៅអ្នកជំងឺ?)</th>
		<td align="center" valign="middle" class="pink gray">Q1=1</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">1.1</td>
		<td class="kh">ឈ្មោះ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="1.1" value="Yes" score="0.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="1.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">1.2</td>
		<td class="kh">អាយុ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="1.2" value="Yes" score="0.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="1.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">1.3</td>
		<td class="kh">ទីលំនៅអចិន្ត្រៃយ៍ (រស់នៅក្នុងភូមិ VMW)</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="1.3" value="Yes" score="0.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="1.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">1.4</td>
		<td class="kh">
			ស្ត្រីមានផ្ទៃពោះ
			<br />
			(រំលងសំណួរនេះ មិនចាំបាច់ឆ្លើយបើមិនពាក់ព័ន្ធ)
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="1.4" value="Yes" score="0.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="1.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td class="kh">
			សាកសួរប្រវត្តិអ្នកជំងឺ
			<br />
			(ការធ្វើដំណើរទៅកាន់ព្រៃក្នុងរយៈពេល ១ខែមុន)
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="2" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">2</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">3</td>
		<th colspan="2" class="kh">
			សាកសួរអ្នកជំងឺអំពីប្រវត្តិនៃការព្យាបាលជំងឺគ្រុនចាញ់ក្នុងរយៈពេល ២៨ថ្ងៃមុន
			<br />
			(តើព័ត៌មានអ្វីខ្លះ ដែល VMW សួរទៅអ្នកជំងឺ)
		</th>
		<td align="center" valign="middle" class="pink gray">Q3=3</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">3.1</td>
		<td class="kh">សាកសួរអ្នកជំងឺថាតើគាត់បានស្វែងរកការធ្វើតេស្តមេរោគគ្រុនចាញ់កន្លងមកដែរឬទេ?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="3.1" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="3.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.5</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">3.2</td>
		<td class="kh">សាកសួរអ្នកជំងឺថាតើគាត់បានស្វែងរកការព្យាលបាលជំងឺគ្រុនចាញ់កន្លងមកដែរឬទេ?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="3.2" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="3.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">3.3</td>
		<td class="kh">សាកសួរអ្នកជំងឺថាតើបច្ចុប្បន្ននេះគាត់កំពុងតែស្ថិតនៅក្នុងព្យាបាលជំងឺគ្រុនចាញ់ដែរឬទេ?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="3.3" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="3.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">4</td>
		<td class="kh">
			រៀបរាប់សញ្ញាណ និងរោគសញ្ញាគ្រោះថ្នាក់
			<br /><br />
			<b><i>គូសចំលើយច្រើនបំផុត ៣</i></b>
		</td>
		<td class="kh">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="4" value="Loss of consciousness/coma" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាត់បង់ស្មារតី/សន្លប់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="4" value="Little urine" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទឹកនោមតិច</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="4" value="Convulsion" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>3. ប្រកាច់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="4" value="Unable to sit/eat/drink" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>4. មិនអាចអង្គុយ/ញ៉ាំអាហារ/ផឹក</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="4" value="Frequent vomiting" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>5. ក្អួតញឹកញាប់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="4" value="Jaundice or very pale" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>6. ជំងខាន់លឿង ឬស្លេកស្លាំង</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="4" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>7. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">5</td>
		<td class="kh">
			រៀបរាប់សញ្ញាណ និងរោគសញ្ញាកំរិតស្រាល
			<br /><br />
			<b><i>គូសចំលើយច្រើនបំផុត ៣</i></b>
		</td>
		<td class="kh">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="5" value="Fever" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. ក្តៅខ្លួន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="5" value="Headache" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ឈឺក្បាល</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="5" value="Chills" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>3. រងារ/ញាក់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="5" value="Nausea" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>4. ចង្អោរ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="5" value="Vomiting" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>5. ក្អួត</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="5" value="Sweating" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>6. បែកញើស</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="5" value="Diarrhea" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>7. រាគ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="5" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>8. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td colspan="5" class="kh">
			<i>កំណត់ចំណាំ៖ ចំពោះសំណួរទី 6 និង 7 អានសំណួរឲ្យ VMW ដោយផ្ទាល់ ប៉ុន្តែមិនត្រូវអានចំលើយនោះទេ។</i>
		</td>
	</tr>
	<tr>
		<td align="center">6</td>
		<th colspan="2" class="kh">ក្នុងករណីណាខ្លាំដែលអ្នកត្រូវបញ្ចូនអ្នកជំងឺ?</th>
		<td align="center" valign="middle" class="pink gray">Q6=6</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">6.1</td>
		<td class="kh">ស្ត្រីមានផ្ទៃពោះក្នុងត្រីមាសទី១</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">6.2</td>
		<td class="kh">សង្ស័យបរាជ័យក្នុងការព្យាលបាលជំងឺគ្រុនចាញ់</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">6.3</td>
		<td class="kh">សញ្ញា និងរោគសញ្ញាធ្ងន់ធ្ងរ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.3" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">6.4</td>
		<td class="kh">បើដាច់ស្តុកតេស្តរហ័ស(RDT)</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.4" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">6.5</td>
		<td class="kh">បើដាច់ស្តុកឱសថគ្រុនចាញ់(ACT)</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.5" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">6.6</td>
		<td class="kh">ករណីគ្រុនចាញ់អវិ​ជ្ជមាន</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.6" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="6.6" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">7</td>
		<td class="kh">
			តើអ្នកត្រូវបញ្ជូនអ្នកជំងឺទៅកន្លែងណា?
			<br /><br />
			<i class="gray">ចំលើយអាចលើសពី១</i>
		</td>
		<td class="kh">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="7" value="Health Center" score="3" data-bind="checked: $root.getAnswer($element)" />
					<span>1. មណ្ឌលសុខភាព</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="7" value="Referral Hospital" score="3" data-bind="checked: $root.getAnswer($element)" />
					<span>2. មន្ទីរពេទ្យបង្អែក</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="7" value="Other" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>3. ផ្សេងៗ (ឳសថស្ថាន ឬក្លីនិចផ្សេងៗ)</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">8</td>
		<td class="kh">នៅពេលអ្នកសង្ស័យថាអ្នកជំងឺមានជំងឺគ្រុនចាញ់ តើអ្នកធ្វើអ្វី?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="8" value="Conduct blood test (RDT)" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. ធ្វើតេស្តឈាម (ឧ. RDT)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="8" value="Presumptive treatment" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ផ្តល់ការព្យាបាលដោយគ្មានការធ្វើតេស្តផ្សេងៗ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9</td>
		<th colspan="2" class="kh">១៣ ជំហាននៃការធ្វើតេស្តរហ័ស(RDT) (ការដាក់ពិន្ទុដោយផ្អែកលើការសាកល្បងនៃការធ្វើតេស្ត)</th>
		<td align="center" valign="middle" class="pink gray">Q9=13</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.1</td>
		<td class="kh">ពិនិត្យកាលបរិច្ឆេទផុតកំណត់នៅលើកញ្ចប់តេស្ត</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.1" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.5</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.2</td>
		<td class="kh">ពាក់ស្រោមដៃថ្មី (ប្រសិនបើគ្មានស្រោមដៃ គឺតំរូវអោយពួកគាត់និយាយផ្ទាល់មាត់)</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.2" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.3</td>
		<td class="kh">
			ហែកកញ្ចប់តេស្ត និងពិនិត្យសារធាតុសម្ងួត
			<br />
			(ប្រសិនបើសារធាតុសម្ងួតមិនមែនព៌ណស ត្រូវចាត់ទុកថាហួសថ្ងៃផុតកំណត់)
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.3" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.5</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.4</td>
		<td class="kh">សរសេរឈ្មោះអ្នកជំងឺ និងកាលបរិច្ឆេទ ភេទ អាយុ លើបន្ទះខ្នងតេស្ត</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.4" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.5</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.5</td>
		<td class="kh">
			សំអាតម្រាមដៃដែលត្រូវជោះឈាមជាមួយសំឡីអាល់កុលអោយស្អាត
			<br />
			រួចទុកអោយស្ងួតមុនពេលជោះឈាម
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.5" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.6</td>
		<td class="kh">មួលផ្តាច់ក្បាលម្ជុលជោះឈាម រួចជោះម្រាមដៃអ្នកជំងឺដើម្បីយកឈាម</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.6" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.6" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.7</td>
		<td class="kh">ចោលម្ជុលជោះឈាមក្នុងប្រអប់សុវត្ថិភាពភ្លាមបនា្ទប់ពីជោះឈាមអ្នកជំងឺរួច</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.7" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.7" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.8</td>
		<td class="kh">ផ្តិតយកឈាមដោយប្រើចុងបំពង់យកឈាមមាត់ឈ្លើង</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.8" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.8" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.9</td>
		<td class="kh">ដាក់ឈាមក្នុងចង្អូរមូលតូច រួចចោលបំពង់យកឈាមទៅក្នុងប្រអប់សុវត្ថិភាពភ្លាម</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.9" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.9" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.10</td>
		<td class="kh">បន្តក់ទឹកប្រតិករ៤តំណក់ទៅក្នុងចង្អូរបួនជ្រុង</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.10" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.10" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.11</td>
		<td class="kh">
			រង់ចាំរយៈពេល១៥នាទីមុនពេលអានលទ្ធផលតេស្ត
			<br />
			(ទោះបីជាលទ្ធផលនោះអាចអានបានមុន ១៥នាទីក៏ដោយ)
			<br />
			រួចបកស្រាយលទ្ធផលតេស្តបានត្រឹមត្រូវ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.11" value="Yes" score="1.25" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.11" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.25</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.12</td>
		<td class="kh">កត់ត្រាលទ្ធផលនៅពីក្រោយខ្នងតេស្ត</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.12" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.12" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">9.13</td>
		<td class="kh">កត់ត្រាលទ្ធផលតេស្តនៅក្នុងសៀវភៅកត់ត្រាករណីជំងឺគ្រុនចាញ់ប្រចាំខែ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.13" value="Yes" score="0.75" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="9.13" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.75</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<th colspan="5" class="kh pink">ផ្នែកទី ៣៖ ការព្យាបាល</th>
	</tr>
	<tr>
		<td colspan="5" class="kh">
			<i>កំណត់ចំណាំ៖ ចំពោះសំណួរទី 11​ និង14 អានសំណួរឲ្យ VMW ដោយផ្ទាល់ ប៉ុន្តែមិនត្រូវអានចំលើយនោះទេ។</i>
		</td>
	</tr>
	<tr>
		<td align="center">10</td>
		<td class="kh">តើថ្នាំប្រភេទអ្វីដែលអ្នកបានផ្តល់ទៅឲ្យអ្នកជំងឺ ដែលមានលទ្ធផលតេស្តជំងឺគ្រុនចាញ់វិជ្ជមាន?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="10" value="ACT or ACT+PQ" score="3.5" data-bind="checked: $root.getAnswer($element)" />
					<span>1. ACT ឬ ACT+ Primaquine</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="10" value="Any other drug" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ថ្នាំផ្សេងៗទៀត</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3.5</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">11</td>
		<td class="kh">
			តាមរយៈចំនេះដឹងរបស់អ្នក តើអ្នកកំណត់កម្រិតនៃឱសថយ៉ាងដូចម្តេចចំពោះអ្នកជំងឺ
			<br />
			ដែលមានលទ្ធផលតេស្តជំងឺគ្រុនចាញ់វិជ្ជមាន?
		</td>
		<td class="kh">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="11" value="Weight" score="3.5" data-bind="checked: $root.getAnswer($element)" />
					<span>1. កំណត់តាមទំងន់អ្នកជំងឺ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="11" value="Age" score="3.5" data-bind="checked: $root.getAnswer($element)" />
					<span>2. កំណត់តាមអាយុអ្នកជំងឺ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="11" value="Other" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>3. ផ្សេងៗ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3.5</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">12</td>
		<th colspan="2" class="kh">
			តើកម្រិតថ្នាំព្យាបាលមួយណាដែលអ្នកផ្តល់ ទៅតាមក្រុមទម្ងន់ខាងក្រោម
			<i>(ត្រូវតែធ្វើការឆ្លើយគ្រប់ផ្នែកនៃសំនួរអោយបានត្រឹមត្រូវដើម្បីទទួលបានពិន្ទុ)</i>
		</th>
		<td align="center" valign="middle" class="pink gray">Q12=20</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">12.1</td>
		<td class="kh">
			៥-៨ គីឡូ៖ សរុប ៣គ្រាប់តូចនៃ ASMQ (១គ្រាប់តូច ២៥/៥០mg),
			<br />
			១ គ្រាប់តូចក្នុង១ថ្ងៃ សម្រាប់រយៈពេល ៣ថ្ងៃ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.1" value="Yes" score="3.33" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3.33</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">12.2</td>
		<td class="kh">
			៩-១៧ គីឡូ៖ សរុប 6 គ្រាប់តូចនៃ ASMQ (១គ្រាប់តូច ២៥/៥០mg),
			<br />
			២គ្រាប់តូចក្នុង១ថ្ងៃ សម្រាប់រយៈពេល ៣ថ្ងៃ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.2" value="Yes" score="3.33" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3.33</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">12.3</td>
		<td class="kh">
			១៨-២៩ គីឡូ៖ សរុប ៣ គ្រាប់នៃ ASMQ (១គ្រាប់ ១០០/២០០mg),
			<br />
			១គ្រាប់ក្នុង១ថ្ងៃ សម្រាប់រយៈពេល ៣ថ្ងៃ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.3" value="Yes" score="3.33" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3.33</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">12.4</td>
		<td class="kh">
			≥៣០ គីឡូ៖ សរុប ៦គ្រាប់នៃ ASMQ (១គ្រាប់ ១០០/២០០mg),
			<br />
			២គ្រាប់ក្នុង១ថ្ងៃ សម្រាប់រយៈពេល ៣ថ្ងៃ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.4" value="Yes" score="3.33" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3.33</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">12.5</td>
		<td class="kh">
			២០ ដល់ ៤៩ គីឡូ សម្រាប់ករណី ហ្វាល់ស៊ីប៉ារ៉ូម(Pf) ឬ ចំរុះ(Mix):
			<br />
			ផ្តល់ថ្នាំ ASMQ (១០០/២០០mg) តាមមគ្គុទ្ទេសក៏ព្យាបាល និងបន្ថែមថ្នាំព្រីម៉ាគីន
			<br />
			កម្រិតទាប (៧.៥mg) ១គ្រាប់ តែមួយពេលគត់ នៅថ្ងៃដំបូងនៃការព្យាបាល
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.5" value="Yes" score="3.33" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3.33</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">12.6</td>
		<td class="kh">
			≥ ៥០គីឡូ សម្រាប់ករណី ហ្វាល់ស៊ីប៉ារ៉ូម(Pf) ឬ ករណីចំរុះ(Mix):
			<br />
			សរុប ៦គ្រាប់នៃ ASMQ(១គ្រាប់ ១០០/២០០mg), ២គ្រាប់ក្នុង១ថ្ងៃ
			<br />
			សម្រាប់រយៈពេល៣ថ្ងៃ និងបន្ថែមជាមួយថ្នាំពី្រម៉ាគីន ក្រមិតទាប (៧.៥mg)
			<br />
			២គ្រាប់ តែមួយពេលគត់នៅថ្ងៃដំបូងនៃការព្យាបាល
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.6" value="Yes" score="3.35" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="12.6" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3.35</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">13</td>
		<th colspan="2" class="kh">
			តើអ្នកធ្វើអ្វីខ្លះ ប្រសិនបើអ្នកជំងឺក្អួត ក្នុងកំឡុងពេលមួយបន្ទាប់ពីទទួលការព្យាបាល?​​
		</th>
		<td align="center" valign="middle" class="pink gray">Q13=2</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">13.1</td>
		<td class="kh">ចន្លោះពី ០-៣០ នាទី៖  ព្យាបាលឡើងវិញ ត្រូវលេប១ដូសឡើងវិញ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="13.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="13.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">13.2</td>
		<td class="kh">ចន្លោះពី ៣០-៦០ នាទី៖ ព្យាបាលឡើងវិញ ត្រូវលេបពាក់កណ្តាលដូសឡើងវិញ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="13.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="13.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">14</td>
		<td class="kh">
			តើអ្នកបានពន្យល់របៀបនៃការលេបថ្នាំគ្រុនចាញ់ដល់អ្នកជំងឺបានច្បាស់លាស់ទេ?
			<br />
			<i>
				(គូស "បាទ/ចាស៎" ប្រសិនបើអ្នកស្ម័គ្រចិត្តលើកឡើងនូវកម្រិតថ្នាំ
				<br />
				និងរយៈពេលសំរាប់ការព្យាបាល និងគូស "ទេ" ប្រសិនបើមិនបានលើកឡើង)
			</i>
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="14" value="Yes" score="3" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="14" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">15</td>
		<td colspan="2" class="kh">
			<b>
				ហេតុអ្វីបានជា ការព្យាបាលដោយការសង្កេតដោយផ្ទាល់ (DOT) នៃ ថ្នាំព្យាបាលគ្រុនចាញ់ (ACT)
				<br />
				មានសារៈសំខាន់សំរាប់អ្នកជំងឺដែលបានធ្វើតេស្តវិជ្ជមាន?
			</b>
			<i>
				(គូស "បាទ/ចាស៎" ប្រសិនបើបានឆ្លើយនូវចំលើយនីមួយៗខាងក្រោម
				<br />
				និង គូស "ទេ" ប្រសិនបើមិនបានឆ្លើយនូវ ចំលើយនីមួយៗខាងក្រោម)
			</i>
		</td>
		<td align="center" valign="middle" class="pink gray">Q15=3</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">15.1</td>
		<td class="kh">កាត់បន្ថយហានិភ័យនៃការព្យាបាលបរាជ័យ និងការលាប់</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="15.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="15.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">15.2</td>
		<td class="kh">
			កាត់បន្ថយហានិភ័យនៃភាពស៊ាំនឹងថ្នាំ ដែលជាវិបាកនៃការព្យាបាលដែលមិនប្រក្រតី
			<br />
			ឬមិនពេញលេញ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="15.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="15.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">15.3</td>
		<td class="kh">
			ទប់ស្កាត់ការរីករាលដាលនៃភាពស៊ាំនឹងថ្នាំនៅក្នុងសហគមន៍
			<br />
			និងតំបន់ដទៃផ្សេងៗទៀត
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="15.3" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="15.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<th colspan="5" class="kh pink">ផ្នែកទី ៤៖ ការធ្វើរបាយការណ៏ និងឯកសារ</th>
	</tr>
	<tr>
		<td colspan="5" class="kh">
			<i>កំណត់ចំណាំ៖ ចំពោះផ្នែកទី ៤ សូមពិនិត្យដោយផ្ទាល់ រួចបំពេញចំលើយដូចខាងក្រោម</i>
		</td>
	</tr>
	<tr>
		<td align="center">16</td>
		<th colspan="2" class="kh">តើសំភារៈទាំងនេះមាននៅផ្ទះរបស់អ្នកស្ម័គ្រចិត្តភូមិព្យាលបាលជំងឺគ្រុនចាញ់ទេ?</th>
		<td align="center" valign="middle" class="pink gray">Q16=3</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">16.1</td>
		<td class="kh">តេស្តរហ័ស(RDT) ដែលប្រើរួច</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="16.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="16.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">16.2</td>
		<td class="kh">សៀវភៅកត់ត្រាករណីជំងឺគ្រុនចាញ់ប្រចាំខែ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="16.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="16.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">16.3</td>
		<td class="kh">ទម្រង់បញ្ចូនអ្នកជំងឺគ្រុនចាញ់</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="16.3" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="16.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">17</td>
		<th colspan="2" class="kh">តើលទ្ធផលតេស្តរហ័សត្រូវបានបញ្ជូល និងកត់ត្រាត្រឹមត្រូវដែរឬទេ?</th>
		<td align="center" valign="middle" class="pink gray">Q17=6</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">17.1</td>
		<td class="kh">
			តើអ្នកស្ម័គ្រចិត្តភូមិមានតេស្តរហ័សដែរប្រើរួចរឺទេ? (ពីរបាយការណ៍ខែបច្ចុប្បន្ន)
			<br />
			<i class="text-bold">ប្រសិនបើទេ សូមរំលងទៅ 18</i>
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.1" value="Yes" score="1.2" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.2</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">17.2</td>
		<td class="kh">
			តើចំនួនតេស្តវិជ្ជមាន ត្រូវគ្នានឹងចំនួនករណីវិជ្ជមានដែលមាននៅក្នុង
			<br />
			សៀវភៅកត់ត្រាករណីជំងឺគ្រុនចាញ់ប្រចាំខែ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.2" value="Yes" score="1.2" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.2</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">17.3</td>
		<td class="kh">
			តើចំនួនតេស្តអវិជ្ជមាន ត្រូវគ្នានឹងចំនួនករណីអវិជ្ជមានដែលមាននៅក្នុង
			<br />
			សៀវភៅកត់ត្រាករណីជំងឺគ្រុនចាញ់ប្រចាំខែ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.3" value="Yes" score="1.2" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.2</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">17.4</td>
		<td class="kh">
			លើខ្នងតេស្តរហ័សមានកាលបរិច្ឆេទនៃការធ្វើតេស្ត
			<br />
			ឈ្មោះអ្នកជំងឺ ភេទ អាយុ និងលទ្ធផល
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.4" value="Yes" score="1.2" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.2</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">17.5</td>
		<td class="kh">
			លទ្ធផលតេស្តបានបែងចែកយ៉ាងត្រឹមត្រូវទៅតាម
			<br />
			ប្រភេទនៃមេរោគ នៅពេលដែលលទ្ធផលវិជ្ជមាន
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.5" value="Yes" score="1.2" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="17.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.2</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">18</td>
		<th colspan="2" class="kh">
			តើសៀវភៅកត់ត្រាករណីជំងឺគ្រុនចាញ់ប្រចាំខែត្រូវបានកត់ត្រាត្រឹមត្រូវ និងបានធ្វើបច្ចុប្បន្នភាពឬទេ?
			<i>(ពិនិត្យក្នុងរយៈពេល ១ ខែមុន)</i>
		</th>
		<td align="center" valign="middle" class="pink gray">Q18=3</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">18.1</td>
		<td class="kh">ចំនួនតេស្តសរុប</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="18.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="18.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">18.2</td>
		<td class="kh">ព័ត៌មានលម្អិតនៃករណីវិជ្ជមាន​</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="18.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="18.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">18.3</td>
		<td class="kh">បច្ចុប្បន្នភាពនៃស្តុក</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="18.3" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="18.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">19</td>
		<th colspan="2" class="kh">
			តើទម្រង់បញ្ជូនអ្នកជំងឺត្រូវបានបំពេញត្រឹមត្រូវ ឬទេ?
			<i>(ពិនិត្យក្នុងរយៈពេល ១ ខែមុន)</i>
		</th>
		<td align="center" valign="middle" class="pink gray">Q19=3</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">19.1</td>
		<td class="kh">ពណ៌សសម្រាប់អ្នកជំងឺ, ពណ៌ផ្កាឈូកសម្រាប់អ្នកស្ម័គ្រចិត្តភូមិ (VMW)</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="19.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="19.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">19.2</td>
		<td class="kh">លទ្ធផលនៃតេស្តរហ័សត្រូវបានកត់ត្រាត្រឹមត្រូវនៅក្នុងទម្រង់បញ្ចូនអ្នកជំងឺ​​</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="19.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="19.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">19.3</td>
		<td class="kh">
			ចំនួនករណីបញ្ចូននៅក្នុងសៀវភៅកត់ត្រាជំងឺគ្រុនចាញ់ប្រចាំខែត្រូវគ្នា
			<br />
			ជាមួយនឹងករណីបញ្ចូននៅក្នុងទម្រង់បញ្ចូនអ្នកជំងឺ
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="19.3" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="19.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<th colspan="5" class="kh pink">ផ្នែកទី ៥៖ ការវាយតំលៃទៅលើកន្លែងធ្វើការ</th>
	</tr>
	<tr>
		<td align="center">20</td>
		<th colspan="2" class="kh">ការអង្កេតដោយអ្នកអភិបាល</th>
		<td align="center" valign="middle" class="pink gray">Q20=2.5</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.1</td>
		<td class="kh">មាន​ការផ្គត់ផ្គង់អគ្គិសនី (ភ្លើងពិល, ទៀន, អំពូលម៉ែត)</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.1" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.2</td>
		<td class="kh">វត្តមាននៃ ស្រោមដៃ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.2" value="Yes" score="0.31" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.31</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.3</td>
		<td class="kh">
			វត្តមាននៃ សំភារៈអប់រំគ្រុនចាញ់
			<br />
			(វត្តមាននៃ សំភារៈជំនួយ(Job Aids) នៅពេលអនុវត្តតេស្តរហ័ស)
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.3" value="Yes" score="0.31" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.31</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.4</td>
		<td class="kh">
			នាឡិកាកំណត់ពេលវេលាដែលនៅមានដំណើរការ
			<br />
			(នាឡិកាប៉ោ នាឡិកាដៃ រឺ ទូរស័ព្ទដៃ)
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.4" value="Yes" score="0.31" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.31</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.5</td>
		<td class="kh">
			ជញ្ជីងសំរាប់ថ្លឹងអ្នកជំងឺដែលដំណើរការល្អ
			<br />
			(ថ្លឹងខ្លួនឯងសិនដើម្បីបញ្ជាក់ថាជញ្ជីងត្រឹមត្រូវ)
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.5" value="Yes" score="0.31" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.31</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.6</td>
		<td class="kh">ប្រដាប់វាស់ស្ទង់កំដៅអ្នកជំងឺដែលដំណើរការ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.6" value="Yes" score="0.31" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.6" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.31</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.7</td>
		<td class="kh">ឱសថគ្រុនចាញ់(ACT) មានដាក់នៅកន្លែងស្ងួត និងមិនចំពន្លឺព្រះអាទិត្យ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.7" value="Yes" score="0.31" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.7" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.31</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.8</td>
		<td class="kh">តេស្តរហ័ស(RDT) មានដាក់នៅកន្លែងស្ងួត និងមិនចំពន្លឺព្រះអាទិត្យ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.8" value="Yes" score="0.31" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.8" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.31</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">20.9</td>
		<td class="kh">វត្តមាននៃប្រអប់សុវត្ថិភាព</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.9" value="Yes" score="0.33" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="20.9" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.33</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">21</td>
		<th colspan="2" class="kh">អ្នកអភិបាលត្រួតពិនិត្យស្តុកថ្នាំ</th>
		<td align="center" valign="middle" class="pink gray">Q21=2.5</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">21.1</td>
		<td class="kh">ចំនួនឱសថគ្រុនចាញ់(ACT) មាននៅក្នុងស្តុកក្នុងថ្ងៃដែលចុះមកពិនិត្យ</td>
		<td class="form-inline">
			<input type="text" name="21.1" data-bind="value: $root.getAnswer($element)" class="form-control text-center blue width100" />
			<kh>គ្រាប់</kh>
		</td>
		<td align="center" valign="middle" class="gray">0</td>
		<td></td>
	</tr>
	<tr>
		<td align="center">21.2</td>
		<td class="kh">ឱសថគ្រុនចាញ់(ACT) ហួសកំណត់កាលបរិច្ឆេទប្រើក្នុងថ្ងៃដែលចុះមកពិនិត្យ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="21.2" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
                    <input type="radio" name="21.2" value="No" score="0.42" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.42</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">21.3</td>
		<td class="kh">ឱសថគ្រុនចាញ់(ACT) ដាច់ស្តុកក្នុងរយៈពេលលើសពីមួយសប្តាហ៍ក្នុងមួយខែកន្លងមក</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="21.3" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
                    <input type="radio" name="21.3" value="No" score="0.42" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.42</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">21.4</td>
		<td class="kh">ស្នើសុំស្តុកឱសថគ្រុនចាញ់(ACT) បន្ទាន់ក្នុងករណីដាច់ស្តុក</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="21.4" value="Yes" score="0.42" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="21.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.42</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">21.5</td>
		<td class="kh">ចំនួនតេស្តរហ័ស(RDT) មាននៅក្នុងស្តុកក្នុងថ្ងៃដែលចុះមកពិនិត្យ</td>
		<td class="form-inline">
			<input type="text" name="21.5" data-bind="value: $root.getAnswer($element)" class="form-control text-center blue width100" />
			<kh>បន្ទះ</kh>
		</td>
		<td align="center" valign="middle" class="gray">0</td>
		<td></td>
	</tr>
	<tr>
		<td align="center">21.6</td>
		<td class="kh">តេស្តរហ័ស(RDT) ហួសកំណត់កាលបរិច្ឆេទប្រើក្នុងថ្ងៃដែលចុះមកពិនិត្យ</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="21.6" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
                    <input type="radio" name="21.6" value="No" score="0.42" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.42</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">21.7</td>
		<td class="kh">តេស្តរហ័ស(RDT) ដាច់ស្តុកក្នុងរយៈពេលលើសពីមួយសប្តាហ៍ក្នុងមួយខែកន្លងមក</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="21.7" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
                    <input type="radio" name="21.7" value="No" score="0.42" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.42</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">21.8</td>
		<td class="kh">ស្នើសុំស្តុកតេស្តរហ័ស(RDT) បន្ទាន់ក្នុងករណីដាច់ស្តុក</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="21.8" value="Yes" score="0.4" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="21.8" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">0.4</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<th colspan="5" class="kh pink">ផ្នែកទី ៦៖ ការគ្រប់គ្រងកាកសំណល់</th>
	</tr>
	<tr>
		<td align="center">22</td>
		<td colspan="2" class="kh">អ្នកអភិបាលធ្វើការអង្គេត</td>
		<td align="center" valign="middle" class="pink gray">Q22=5</td>
		<td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	</tr>
	<tr>
		<td align="center">22.1</td>
		<td class="kh">តើប្រអប់សុវត្ថិភាពពេញលើសលុបដែរឬទេ?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="22.1" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
                    <input type="radio" name="22.1" value="No" score="1.67" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.67</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">22.2</td>
		<td class="kh">តើមានការបែងចែកសំរាមត្រឹមត្រូវដែរឬទេ?</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="22.2" value="Yes" score="1.67" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="22.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.67</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">22.3</td>
		<td class="kh">
			តើអ្នកស្ម័គ្រចិត្តដឹងថាត្រូវចោលកាក់សំណល់វេជ្ជសាស្ត្រនៅកន្លែងណា?
			<br />
			(គូស "បាទ/ចាស៎" ប្រសិនបើអ្នកស្ម័គ្រចិត្តលើកឡើងកន្លែងផ្តល់សេវាសុខភាពសាធារណៈ
			<br />
			និង គូស "ទេ" បើបានលើកឡើងកន្លែងផ្សេងទៀត)
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="22.3" value="Yes" score="1.66" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="22.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">1.66</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<th colspan="5" class="kh pink">ផ្នែកទី ៧៖ ការពិនិត្យលើការអប់រំសុខភាព</th>
	</tr>
	<tr>
		<td align="center">23</td>
		<td class="kh">
			តើអ្នកស្ម័គ្រចិត្តបានរៀបចំសកម្មភាពអប់រំសុខភាពជំងឺគ្រុនចាញ់
			<br />
			កាលពីខែមុននៅក្នុងសហគមន៍គាត់ដែរឬទេ?
		</td>
		<td class="kh">
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="23" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					<span>1. បាទ/ចាស៎</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" name="23" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ទេ</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">2</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr>
		<td align="center">24</td>
		<td class="kh">
			តើសារគន្លឹះយ៉ាងហោចណាស់ចំនួន៣អ្វីខ្លះដែលជាវិធានការ
			<br />
			ការពារជំងឹគ្រុនចាញ់ដែលអ្នកអាចផ្តល់ទៅអោយសហគមន៍របស់អ្នក?
			<br />
			<br />
			<b><i>គូសចំលើយច្រើនបំផុត ៣</i></b>
		</td>
		<td class="kh">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="24" value="Sleep under a bednet every night" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>1. គេងនៅក្នុងមុងគ្រប់ពេលវេលា</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="24" value="Wear long sleeved clothes especially at night and in the forest" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>2. ស្លៀកពាក់ខោអាវវែង ជាពិសេសពេលល្ងាច និងនៅក្នុងព្រៃ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="24" value="Use mosquito repellent on exposed skin" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>3. លាបថ្នាំបណ្តេញមូស</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="24" value="Light a campfire in the forest to deter mosquitos" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>4. ដុតភ្នក់ភ្លើងនៅពេលស្ថិតក្នុងព្រៃដើម្បីរារាំងមូស</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="24" value="Plant holy basil around your home" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>5. ដាំម្រះព្រៅនៅជុំវិញផ្ទះ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="24" value="Clear excess vegetation from around your home" score="1" data-bind="checked: $root.getAnswer($element)" />
					<span>6. សំអាតព្រៃកន្ទ្រប់ជុំវិញផ្ទះ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" name="24" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					<span>7. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				</label>
			</div>
		</td>
		<td align="center" valign="middle" class="gray">3</td>
		<td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	</tr>
	<tr class="pink">
		<td colspan="4" align="right"><kh>ពិន្ទុសរុប</kh> = 100</td>
		<td></td>
	</tr>
</table>
<br />

<table class="table table-bordered" data-bind="with: masterModel">
	<tr class="bg-gray">
		<th colspan="4" class="kh">ពិន្ទុសរុបតាមផ្នែកនីមួយៗ</th>
	</tr>
	<tr class="bg-gray">
		<th class="kh">ផ្នែក</th>
		<th align="center" class="kh">ពិន្ទុសរុបតាមផ្នែក</th>
		<th align="center" class="kh">ពិន្ទុអ្នកស្ម័គ្រចិត្តទទួលបាន</th>
		<th align="center" class="kh">មធ្យមភាគ</th>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ១៖ ព័ត៌មានទូទៅ</td>
		<td align="center">0</td>
		<td align="center"></td>
		<td align="center"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ២៖ ការធ្វើតេស្ត</td>
		<td align="center">35</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section2')"></td>
		<td align="center" data-bind="text: Math.round(Section2() * 100 / 35) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៣៖ ការព្យាបាល</td>
		<td align="center">35</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section3')"></td>
		<td align="center" data-bind="text: Math.round(Section3() * 100 / 35) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៤៖ ការធ្វើរបាយការណ៍ និងឯកសារ</td>
		<td align="center">15</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section4')"></td>
		<td align="center" data-bind="text: Math.round(Section4() * 100 / 15) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៥៖ ការវាយតំលៃទៅលើកន្លែងធ្វើការ</td>
		<td align="center">5</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section5')"></td>
		<td align="center" data-bind="text: Math.round(Section5() * 100 / 5) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៦៖ ការគ្រប់គ្រងកាសំណល</td>
		<td align="center">5</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section6')"></td>
		<td align="center" data-bind="text: Math.round(Section6() * 100 / 5) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៧៖ ការពិនិត្យលើការអប់រំសុខភាព</td>
		<td align="center">5</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section7')"></td>
		<td align="center" data-bind="text: Math.round(Section7() * 100 / 5) + '%'"></td>
	</tr>
	<tr>
		<th colspan="2" class="kh" align="right">ពិន្ទុសរុប</th>
		<th align="center" data-bind="text: $root.getTotalScore('TotalScore')"></th>
		<th align="center" data-bind="text: Math.round(TotalScore()) + '%'"></th>
	</tr>
</table>
<!-- /ko -->