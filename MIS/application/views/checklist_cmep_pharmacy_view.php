<style>
	.pad5 { padding: 5px; }
	textarea { resize: vertical; }
</style>

<div class="kh" data-bind="visible: view() == 'detail', with: masterModel">
	<div class="divcenter relative">
		<h3 class="text-center text-primary">តាមដាននិងវាយតម្លៃការគ្រប់គ្រងឱសថនិងបរិក្ខារនៅតាមឃ្លាំងមណ្ឌលសុខភាព</h3>
		<br />

		<div class="form-group bg-gray pad5 text-bold">បំពេញមុនចុះអភិបាល</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon">ឈ្មោះមន្ត្រីចុះអភិបាល</span>
				<input type="text" class="form-control" data-bind="value: VisitorName" />
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon">ខេត្ត</span>
				<select data-bind="value: Code_Prov_N,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''"
					class="form-control minwidth150 kh"></select>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon">ស្រុកប្រតិបត្ដិ</span>
				<select data-bind="value: Code_OD_T,
						options: odList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''"
					class="form-control minwidth150 kh"></select>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon">មណ្ឌលសុខភាព</span>
				<select data-bind="value: Code_Facility_T,
						options: hcList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''"
					class="form-control minwidth150 kh"></select>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon">កាលបរិច្ឆេទត្រូវចុះត្រួតពិនិត្យ (ថ្ងៃ-ខែ-ឆ្នាំ)</span>
				<input type="text" class="form-control text-center en" data-bind="datePicker: Schedule" />
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon">កាលបរិច្ឆេទចុះត្រួតពិនិត្យ(ថ្ងៃ-ខែ-ឆ្នាំ)</span>
				<input type="text" class="form-control text-center en" data-bind="datePicker: VisitDate" />
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="input-group">
				<span class="input-group-addon">ចំនួនករណី</span>
				<input type="text" class="form-control text-center en" data-bind="value: CaseQty" numonly="int" />
			</div>
		</div>
		<br />

		<div class="form-group bg-gray pad5 text-bold">ការសង្កេត</div>
		<table class="table">
			<tr>
				<th>១</th>
				<td>
					<b>តើឃ្លាំងឱសថបើកទ្វារ និងមានបុគ្គលិកឬទេនៅពេលចុះអភិបាល?</b>
					<br />
					បើគ្មាន: យោបល់ និងមូលហេតុ៖
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<textarea class="form-control" name="1.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
				</td>
			</tr>
			<tr>
				<th>២</th>
				<td>
					<b>តើឃ្លាំងឱសថអនុវត្តតាមការណែនាំសុវត្ថិភាពដែររឺទែ?</b>
					<br />
					ពណ៌នា
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<textarea class="form-control" rows="5" name="2.1" data-bind="value: $root.getAnswer($element)"></textarea>
				</td>
			</tr>
			<tr>
				<th class="bg-gray" colspan="3">ឃ្លាំងឱសថ</th>
			</tr>
			<tr>
				<th>៣</th>
				<td>
					<b>តើមានបញ្ចីឱសថគ្រុនចាញ់ចំណូល និងចំណាយ ថ្មី និងចុងក្រោយឬទេ?</b>
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>៤</th>
				<td>
					<b>តើមានឱសថគ្រុនចាញ់ណាមួយដាច់ស្តុកឬទេ?</b>
					<br />
					បើមានរាយឈ្មោះឱសថ និងរយះពេលដាច់ស្តុក៖
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<textarea class="form-control" name="4.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
				</td>
			</tr>
			<tr>
				<th>៥</th>
				<td>
					<b>តើមានឱសថគ្រុនចាញ់ណាមួយផុតកំណត់កាលប្រើប្រាស់ឬទេ?</b>
					<br />
					បើមានរាយឈ្មោះឱសថ និងរយះពេលផុតកំណត់
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<textarea class="form-control" name="5.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
				</td>
			</tr>
			<tr>
				<th>៦</th>
				<td>
					<b>តើនិតិវិធីទទួលមុនប្រើមុនត្រូវបានប្រើប្រាស់មុនបានអនុវត្តត្រឹមត្រូវរឺទេ? (FIFO)</b>
					<br />
					ចំណាប់អារម្មណ៍ រឺ យោបល់
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<textarea class="form-control" name="6.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
				</td>
			</tr>
			<tr>
				<th>៧</th>
				<td>
					<b>តើនិតិវិធីផុតកំណត់កាលប្រើប្រាស់មុនត្រូវបានប្រើប្រាស់មុនបានអនុវត្តត្រឹមត្រូវរឺទេ? (FEFO)</b>
					<br />
					ចំណាប់អារម្មណ៍ រឺ យោបល់
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<textarea class="form-control" name="7.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
				</td>
			</tr>
			<tr>
				<th>៨</th>
				<td>
					<b>តើឃ្លាំងឱសថរៀបចំ និងសំអាតបានល្អឬទេ?</b>
					<br />
					ពណ៌នា
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8" value="Average" data-bind="checked: $root.getAnswer($element)" />
							<span>មធ្យម</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<textarea class="form-control" name="8.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
				</td>
			</tr>
			<tr>
				<th>៩</th>
				<td>
					<b>តើការរៀបចំទុកដាក់ឱសថ និងសំភារះបានល្អឬទេ?</b>
					<br />
					<b>បើមធ្យម  ឬ មិនល្អ តើមានចំណុចអ្វីខ្លះដែលគួរកែលម្អ?</b>
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9" value="Average" data-bind="checked: $root.getAnswer($element)" />
							<span>មធ្យម</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<textarea class="form-control" name="9.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
				</td>
			</tr>
			<tr>
				<th>១០</th>
				<td>
					<b>
						តើការទុកដាក់ឯកសារចំណូលចំណាយនឹងឯកសារផ្សេងទៀតដែលទាក់ទងនឹងការគ្រប់គ្រងឃ្លាំងបានល្អ
						<br />និងត្រូវបានកត់ត្រាបានត្រឹមត្រូវរឺទេ?
					</b>
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th class="bg-gray" colspan="3">ឱសថនិងតេស្តគ្រុនចាញ់</th>
			</tr>
			<tr>
				<th>១១</th>
				<td>
					<b>តើឱសថគ្រុនចាញ់ក្នុងឃ្លាំងឱសថគ្រប់គ្រាន់រឺទេ?</b>
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="11" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="11" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>១២</th>
				<td>
					<b>ប្រសិនជាមិនមានគ្រប់គ្រាន់ ចូរគូសឈ្មោះឱសថនិងតេស្តគ្រុនចាញ់ដែលខ្វះខាត</b>
					<br />
					<en>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="12" value="ASMQ (25/50mg)" data-bind="checked: $root.getAnswer($element)" />
								<span>ASMQ (25/50mg)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="12" value="ASMQ (100/200mg)" data-bind="checked: $root.getAnswer($element)" />
								<span>ASMQ (100/200mg)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="12" value="Primaquine 15mg" data-bind="checked: $root.getAnswer($element)" />
								<span>Primaquine 15mg</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="12" value="Injectable artesunate vials" data-bind="checked: $root.getAnswer($element)" />
								<span>Injectable artesunate vials</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="12" value="Injectable quinine (ampoules)" data-bind="checked: $root.getAnswer($element)" />
								<span>Injectable quinine (ampoules)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="12" value="Quinine tablets" data-bind="checked: $root.getAnswer($element)" />
								<span>Quinine tablets</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="12" value="Doxycycline 150mg" data-bind="checked: $root.getAnswer($element)" />
								<span>Doxycycline 150mg</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="12" value="Tetracycline 250mg" data-bind="checked: $root.getAnswer($element)" />
								<span>Tetracycline 250mg</span>
							</label>
						</div>
					</en>
				</td>
			</tr>
			<tr>
				<th>១៣</th>
				<td>
					<b>តើតេស្តគ្រុនចាញ់ក្នុងឃ្លាំងឱសថគ្រប់គ្រាន់រឺទេ?</b>
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="13" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="13" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<b>តេស្តដែលមិនគ្រប់គ្រាន់គឺ</b>
				</td>
				<td>
					<div class="checkbox-inline checkbox-lg">
						<label>
							<input type="checkbox" name="13.1" value="RDT" data-bind="checked: $root.getAnswer($element)" />
							<span>តេស្តរហ័ស</span>
						</label>
					</div>
					<div class="checkbox-inline checkbox-lg">
						<label>
							<input type="checkbox" name="13.1" value="G6PD Test" data-bind="checked: $root.getAnswer($element)" />
							<span>តេស្ត G6PD</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>១៤</th>
				<td>
					<b>តើមូលហេតុអ្វីបណ្តាលអោយមានកង្វះខាតនេះ? (ចំលើយលើសពីមួយ)</b>
					<br />
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="14" value="ការដឹកជញ្ចូនយឺតយ៉ាវ" data-bind="checked: $root.getAnswer($element)" />
							<span>ការដឹកជញ្ចូនយឺតយ៉ាវ</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="14" value="ការប៉ាន់ប្រមាណមិនត្រឹមត្រូវ" data-bind="checked: $root.getAnswer($element)" />
							<span>ការប៉ាន់ប្រមាណមិនត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="14" value="ការកើនឡើងនៃករណីជំងឺគ្រុនចាញ់ខុសពីការរំពឹងទុក" data-bind="checked: $root.getAnswer($element)" />
							<span>ការកើនឡើងនៃករណីជំងឺគ្រុនចាញ់ខុសពីការរំពឹងទុក</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="14" value="អស់ពីស្តុក រឺ ដាច់ស្តុក" data-bind="checked: $root.getAnswer($element)" />
							<span>អស់ពីស្តុក រឺ ដាច់ស្តុក</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="14" value="ការផ្គត់ផ្គង់ពីស្រុកប្រត្តិបត្តមិនគ្រប់គ្រាន់" data-bind="checked: $root.getAnswer($element)" />
							<span>ការផ្គត់ផ្គង់ពីស្រុកប្រត្តិបត្តមិនគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="form-inline" style="margin:5px 0 0 -5px">
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="14" value="ផ្សេងៗ" data-bind="checked: $root.getAnswer($element)" />
								<span>ផ្សេងៗ</span>
							</label>
						</div>
						<input type="text" class="form-control" name="14.1" data-bind="value: $root.getAnswer($element)" style="width:400px" />
					</div>
				</td>
			</tr>
			<tr>
				<th class="bg-gray" colspan="3">សំភារៈផ្នែកមន្ទីរពិសោធន៏</th>
			</tr>
			<tr>
				<th>១៥</th>
				<td>
					<b>តើសំភារៈផ្នែកមន្ទីរពិសោធន៏សំរាប់ធ្វើរោគវិនិច្ជ័យជំងឺគ្រុនចាញ់មានគ្រប់គ្រាន់ដែររឺទេ?</b>
				</td>
				<td>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="15" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="15" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<th>១៦</th>
				<td>
					<b>ប្រសិនជាមិនគ្រប់គ្រាន់ ចូររៀបរាប់សំភារៈផ្នែកមន្ទីរពិសោធន៏ដែលខ្វះខាត</b>
					<br />
					<en>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Giemsa (50ml/Fl)" data-bind="checked: $root.getAnswer($element)" />
								<span>Giemsa (50ml/Fl)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Xylene (100ml/Fl)" data-bind="checked: $root.getAnswer($element)" />
								<span>Xylene (100ml/Fl)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Methanol (100ml/Fl)" data-bind="checked: $root.getAnswer($element)" />
								<span>Methanol (100ml/Fl)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Immersion Oil (50ml/Fl)" data-bind="checked: $root.getAnswer($element)" />
								<span>Immersion Oil (50ml/Fl)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Blood slide (Box/50)" data-bind="checked: $root.getAnswer($element)" />
								<span>Blood slide (Box/50)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Vaccinostyle (Box/100)" data-bind="checked: $root.getAnswer($element)" />
								<span>Vaccinostyle (Box/100)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Slide Storage for 100 slides" data-bind="checked: $root.getAnswer($element)" />
								<span>Slide Storage for 100 slides</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Minutery" data-bind="checked: $root.getAnswer($element)" />
								<span>Minutery</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Parasite Counter" data-bind="checked: $root.getAnswer($element)" />
								<span>Parasite Counter</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Eprouvette" data-bind="checked: $root.getAnswer($element)" />
								<span>Eprouvette</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Pipette tips 0.5-20ul" data-bind="checked: $root.getAnswer($element)" />
								<span>Pipette tips 0.5-20ul</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Pyrex becher 100ml" data-bind="checked: $root.getAnswer($element)" />
								<span>Pyrex becher 100ml</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Pyrex Becher 20ml" data-bind="checked: $root.getAnswer($element)" />
								<span>Pyrex Becher 20ml</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Rack for slide" data-bind="checked: $root.getAnswer($element)" />
								<span>Rack for slide</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Glove latex, Size M (Box/50 pairs)" data-bind="checked: $root.getAnswer($element)" />
								<span>Glove latex, Size M (Box/50 pairs)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Glove latex, Size L (Box/50 pairs)" data-bind="checked: $root.getAnswer($element)" />
								<span>Glove latex, Size L (Box/50 pairs)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Permanence (Box/10)" data-bind="checked: $root.getAnswer($element)" />
								<span>Permanence (Box/10)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Cotton wool absorbent (0.5/kg)" data-bind="checked: $root.getAnswer($element)" />
								<span>Cotton wool absorbent (0.5/kg)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Alcohol 70 degree (liter)" data-bind="checked: $root.getAnswer($element)" />
								<span>Alcohol 70 degree (liter)</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="16" value="Book for laboratory" data-bind="checked: $root.getAnswer($element)" />
								<span>Book for laboratory</span>
							</label>
						</div>
					</en>
				</td>
			</tr>
			<tr>
				<th>១៧</th>
				<td>
					<b>តើមូលហេតុអ្វីបណ្តាលអោយមានកង្វះខាតនេះ? (ចំលើយលើសពីមួយ)</b>
					<br />
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="17" value="ការដឹកជញ្ចូនយឺតយ៉ាវ" data-bind="checked: $root.getAnswer($element)" />
							<span>ការដឹកជញ្ចូនយឺតយ៉ាវ</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="17" value="ការប៉ាន់ប្រមាណមិនត្រឹមត្រូវ" data-bind="checked: $root.getAnswer($element)" />
							<span>ការប៉ាន់ប្រមាណមិនត្រឹមត្រូវ</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="17" value="ការកើនឡើងនៃករណីជំងឺគ្រុនចាញ់ខុសពីការរំពឹងទុក" data-bind="checked: $root.getAnswer($element)" />
							<span>ការកើនឡើងនៃករណីជំងឺគ្រុនចាញ់ខុសពីការរំពឹងទុក</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="17" value="ប្រតិករមានគុណភាពមិនល្អ" data-bind="checked: $root.getAnswer($element)" />
							<span>ប្រតិករមានគុណភាពមិនល្អ</span>
						</label>
					</div>
					<div class="checkbox checkbox-lg">
						<label>
							<input type="checkbox" name="17" value="ការផ្គត់ផ្គង់ពីស្រុកប្រត្តិបត្តមិនគ្រប់គ្រាន់" data-bind="checked: $root.getAnswer($element)" />
							<span>ការផ្គត់ផ្គង់ពីស្រុកប្រត្តិបត្តមិនគ្រប់គ្រាន់</span>
						</label>
					</div>
					<div class="form-inline" style="margin:5px 0 0 -5px">
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="17" value="ផ្សេងៗ" data-bind="checked: $root.getAnswer($element)" />
								<span>ផ្សេងៗ</span>
							</label>
						</div>
						<input type="text" class="form-control" name="17.1" style="width:400px" data-bind="value: $root.getAnswer($element)" />
					</div>
				</td>
			</tr>
		</table>
	</div>
	<br />

	<div class="bg-gray pad5 text-bold">របាយការណ៍ស្តុកក្នុងឃ្លាំងឱសថ</div>
	<div class="pad5 text-bold">១៨ ចូរកត់ត្រារបាយការណ៍ស្តុកក្នុងឃ្លាំងឱសថតាមមុខឱសថនិងសំភារៈដែលបានរាយដូចខាងក្រោម៖</div>
	<br />

	<table class="table table-bordered">
		<thead>
			<tr>
				<th align="center" valign="top">លរ</th>
				<th align="center" valign="top">ឈ្មោះឱសថនិងសំភារៈ</th>
				<th align="center" valign="top">ខ្នាត</th>
				<th align="center" valign="top">ស្តុកបច្ចុប្បន្ន</th>
				<th align="center" valign="top">បរិមាណប្រើប្រាស់បីខែមុន</th>
				<th align="center" valign="top">បរិមាណប្រើប្រាស់ជាមធម្យប្រចាំខែ</th>
				<th align="center" valign="top">ចំនួនខែនៃស្តុកដែលអាចប្រើប្រាស់បាន</th>
				<th align="center" valign="top">កាលបរិច្ឆេទប្រើ</th>
				<th align="center" valign="top">សំគាល់</th>
			</tr>
			<tr class="en">
				<td align="center">A</td>
				<td align="center">B</td>
				<td align="center">C</td>
				<td align="center">D</td>
				<td align="center">E</td>
				<td align="center">F is Average Monthly Consumption (AMC) = E/3</td>
				<td align="center">G is Month of Stock (MoS) = D/F</td>
				<td align="center">H</td>
				<td align="center">I</td>
			</tr>
		</thead>
		<tbody data-bind="foreach: $root.stockList, fixedHeader: true" class="en">
			<tr>
				<td align="center" valign="middle" data-bind="text: $index() + 1"></td>
				<td valign="middle" data-bind="text: name"></td>
				<td>
					<input type="text" class="form-control" data-bind="value: unit" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: stock" numonly="float" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: qty" numonly="float" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: amc" numonly="float" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: mos" numonly="float" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: date" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: note" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<br />

	<p>
		<b>ចំណាប់អារម្មណ៏របស់មន្រ្តីចុះអភិបាល</b>
	</p>
	<textarea class="form-control" rows="5" data-bind="value: Interest"></textarea>
	<br />

	<div class="form-group form-inline relative">
		<div class="input-group">
			<span class="input-group-addon">ថ្ងៃចុះអភិបាលបន្ទាប់</span>
			<input type="text" class="form-control text-center en" data-bind="datePicker: NextVisitDate" />
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_CMEP_Pharmacy.js')?>