<!-- ko if: masterModel() != null && masterModel().FormType() != 'Old' -->
<div data-bind="with: masterModel">
	<table class="table table-bordered">
		<tr>
			<td colspan="2" class="kh">
				<b>ការណែនាំ</b>
				<ul>
					<li class="text-danger">
						<b>សូមជ្រើសរើសតួនាទីអ្នកស្ម័គ្រចិត្តឲបានត្រឹមត្រូវ តើគាត់ជាVMW ឬ Integrated VMW ឬ MMW</b>
					</li>
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
			<th colspan="2" class="kh pink">ផ្នែកទី ១៖ ព័ត៌មានទូទៅ</th>
		</tr>

		<tr>
			<td class="kh">
				តើអ្នកជាអ្នកស័្មគ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ (VMW) ឬជាសមាហរណកម្មអ្នកស្ម័គ្រចិត្ត
				<br />ភូមិព្យាបាលជំងឺគ្រុនចាញ់ (Integrated VMW) ឬជាអ្នកស្ម័គ្រចិត្តព្យាបាលជំងឺគ្រុនចាញ់ចល័ត(MMW)?
				<br />
				<br />
				<b>
					<i class="text-danger">(សូមជ្រើសរើសតួនាទីអ្នកស្ម័គ្រចិត្តឲបានត្រឹមត្រូវ តើគាត់ជាVMW ឬ Integrated VMW ឬ MMW)</i>
				</b>
				<br />
				<b>
					<i>សូមបង្ហាញកម្រងសំណួរទៅតាមចំលើយដែលបានជ្រើសរើស</i>
				</b>
			</td>
			<td class="kh">
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="FormType" value="VMW" data-bind="checked: FormType, enable: Rec_ID() == 0" />
						<span>1. អ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ (VMW)</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="FormType" value="Integrated" data-bind="checked: FormType, enable: Rec_ID() == 0" />
						<span>2. សមាហរណកម្មអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ (Integrated)</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="FormType" value="MMW" data-bind="checked: FormType, enable: Rec_ID() == 0" />
						<span>3. អ្នកស្ម័គ្រចិត្តព្យាបាលជំងឺគ្រុនចាញ់ចល័ត (MMW)</span>
					</label>
				</div>
			</td>
		</tr>

		<tr>
			<td class="kh">តើអ្នកស្ម័គ្រចិត្តជាមនុស្សប្រុស ឬស្រី?</td>
			<td class="kh">
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Sex" value="Male" data-bind="checked: Sex" />
						<span>1. ប្រុស</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Sex" value="Female" data-bind="checked: Sex" />
						<span>2. ស្រី</span>
					</label>
				</div>
			</td>
		</tr>

		<tr>
			<td class="kh">តើអ្នកបានទទួលការបណ្តុះបណ្តាលចុងក្រោយបំផុតនៅពេលណា?</td>
			<td class="kh">
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Training" value="<= 6 Months" data-bind="checked: Training" />
						<span>1. ≤ 6 ខែ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Training" value="7 Months - 12 Months" data-bind="checked: Training" />
						<span>2. 7 ខែ - 12 ខែ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Training" value="13 Months - 24 Months" data-bind="checked: Training" />
						<span>3. 13 ខែ - 24 ខែ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Training" value="No" data-bind="checked: Training" />
						<span>4. ទេ</span>
					</label>
				</div>
			</td>
		</tr>
	</table>
</div>
<br />

<?php $this->load->view('vmwqa_form2vmw_view'); ?>
<?php $this->load->view('vmwqa_form2integrated_view'); ?>
<!-- /ko -->