<style>
	.dis {pointer-events: none;
			opacity: 0.5;
		}
</style>

<div class="divcenter kh" data-bind="visible: view() == 'detail', with: masterModel">
	<h3 class="text-center text-primary" style="line-height:1.7">
		បញ្ជីផ្ទៀងផ្ទាត់ការធានាគុណភាពសេវាឯកជន
		<br />
		កម្មវិធីភាពជាដៃគូររវាងសេវាសាធារណៈនិងឯកជន
	</h3>
	<br />

	<div style="padding:10px; border:1px solid">
		<div class="form-group form-inline">
			<div class="form-group">
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
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ស្រុកប្រតិបត្តិ</span>
					<select data-bind="value: Code_OD_T,
						options: odList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''"
						class="form-control minwidth150 kh"></select>
				</div>
			</div>
			<div class="form-group">
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
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ភូមិ</span>
					<select data-bind="value: Code_Vill_T,
						options: vlList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''"
						class="form-control minwidth150 kh"></select>
				</div>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ឈ្មោះកន្លែងផ្តល់សេវាឯកជន</span>
					<input type="text" class="form-control" data-bind="value: PPM" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group relative">
					<span class="input-group-addon">កាលបរិច្ឆេទអភិបាល</span>
					<input type="text" class="form-control text-center width120 en" data-bind="datePicker: VisitDate" />
				</div>
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ឈ្មោះអ្នកបំពេញទំរង់អភិបាល</span>
					<input type="text" class="form-control" data-bind="value: VisitorName" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group relative">
					<span class="input-group-addon">តួនាទី</span>
					<input type="text" class="form-control" data-bind="value: Position" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">ទីកន្លែងធ្វើការ</span>
					<select class="form-control kh" data-bind="value: WorkPlace">
						<option></option>
						<option value="CNM">ម.គ.ច</option>
						<option value="PHD">មន្ទីរសុខាភិបាលខេត្ត</option>
						<option value="OD">ស្រុកប្រតិបត្តិ</option>
						<option value="HC">មណ្ឌលសុខភាព</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div style="padding:10px; border:1px solid">
		<b>ការណែនាំ៖</b>
		<ul class="text-bold">
			<li>សូមកត់ត្រាចំលើយក្នុងប្រអប់ ☑ ខាងក្រោមនេះ</li>
			<li>ផ្តល់ពិន្ទុចំពោះចំណុចដែលមានបញ្ហា (ពិន្ទុកាន់តែច្រើន បញ្ហាកាន់តែច្រើន)</li>
			<li>អនុវត្តរាល់ពេលចុះអភិបាលនៅគ្រប់កន្លែងផ្តល់សេវាឯកជនរួមមានអ្នកដែលបានចូលរួមក្នុងកម្មវិធី PPM និង អ្នកដែលមិនចូលរួមក្នុងកម្មវិធី PPM</li>
		</ul>

		អ្នកអភិបាលត្រូវរៀបចំឯកសារជាមុន មុនពេលចុះត្រួតពិនិត្យដើម្បីយកទៅប្រើពេលអភិបាលដូចខាងក្រោម៖
		<br />
		១. បញ្ជីរាយនាមកន្លែងផ្តល់សេវាឯកជនដែលបានចុះបញ្ជីនៅក្នុងស្រុកប្រតិបត្តិនីមួយៗ (ប្រសិនបើមានការផ្លាស់ប្តូរណាមួយនោះបញ្ជីគួរតែធ្វើបច្ចុប្បន្នភាព)
		<br />
		២. របាយការណ៍ខែមុន (បញ្ជីផ្ទៀងផ្ទាត់ការធានាគុណភាពសេវាឯកជនពីមុនប្រសិនបើមាន)
		<br />
		៣. ជំនួយស្មារតី ឬសម្ភារៈអប់រំសុខភាពសម្រាប់គាំទ្រការអភិបាល
	</div>
	<br />

	<table class="table table-bordered">
		<tr class="bg-warning">
			<th colspan="3">ផ្នែកទី១ ព័ត៍មានអ្នកផ្តល់សេវា</th>
			<th align="center" width="200">ការណែនាំអំពីពិន្ទុ</th>
			<th align="center" width="80">ពិន្ទុ</th>
		</tr>
		<tr>
			<td align="center" class="bg-success en">1</td>
			<th width="600">ឈ្មោះកន្លែងផ្តលសេវា</th>
			<td width="400"><input type="text" name="1" class="form-control" data-bind="value: $root.getAnswer($element)" /></td>
			<td align="center" colspan="2">បើគ្មានឈ្មោះ សរសេរ "គ្មានឈ្មោះ" ឬឈ្មោះរបស់អ្នកសំភាស</td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">2</td>
			<th>ប្រភេទសេវាឯកជន</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="2" value="មន្ទីរពហុព្យាបាល" data-bind="checked: $root.getAnswer($element)" />
						<span>មន្ទីរពហុព្យាបាល</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="2" value="មន្ទីរសំរាកព្យាលបាល" data-bind="checked: $root.getAnswer($element)" />
						<span>មន្ទីរសំរាកព្យាលបាល</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="2" value="បន្ទប់ពិគ្រោះ" data-bind="checked: $root.getAnswer($element)" />
						<span>បន្ទប់ពិគ្រោះជំងឺ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="2" value="បន្ទប់ថែទាំជំងឺ" data-bind="checked: $root.getAnswer($element)" />
						<span>បន្ទប់ថែទាំជំងឺ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="2" value="ឱសថស្ថាន" data-bind="checked: $root.getAnswer($element)" />
						<span>ឱសថស្ថាន</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2" value="ផ្សេងៗ" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (សូមបញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="2.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center" colspan="2"></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">3</td>
			<th>ស្ថានភាពអាជ្ញាប័ណ្ណនៃកន្លែងផ្តល់សេវា</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="3" value="បានចុះអាជ្ញាប័ណ្ណ" data-bind="checked: $root.getAnswer($element)" />
						<span>បានចុះអាជ្ញាប័ណ្ណ</span>
					</label>
				</div>
				<div class="form-inline" style="padding:5px 0 5px 25px">
					<span>(អាជ្ញាប័ណ្ណលេខ):</span>
					<input type="text" class="form-control input-sm" name="3.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="3" value="អាជ្ញាប័ណ្ណ ផុតកំណត់" data-bind="checked: $root.getAnswer($element)" />
						<span>អាជ្ញាប័ណ្ណ ផុតកំណត់</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="3" value="មិនមាន អាជ្ញាប័ណ្ណ" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន អាជ្ញាប័ណ្ណ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="3" value="បដិសេធមិនប្រាប់" data-bind="checked: $root.getAnswer($element)" />
						<span>បដិសេធមិនប្រាប់</span>
					</label>
				</div>
			</td>
			<td align="center" colspan="2">បើមិនបានចុះអាជ្ញាប័ណ្ណ អ្នកចុះអភិបាល ត្រូវណែនាំ អ្នកផ្តល់សេវាអំពីច្បាប់ និងរបៀបនៃការចុះបញ្ជី</td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">4</td>
			<th>តើអ្នកផ្តល់សេវាឯកជននេះមានកំរិតវប្បធម៌កំរិតណា?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="4" value="វេជ្ជបណ្ឌិត/គ្រូពេទ្យ" data-bind="checked: $root.getAnswer($element)" />
						<span>វេជ្ជបណ្ឌិត/គ្រូពេទ្យ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="4" value="គិលានុបដ្ឋ" data-bind="checked: $root.getAnswer($element)" />
						<span>គិលានុបដ្ឋ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="4" value="ឆ្មប" data-bind="checked: $root.getAnswer($element)" />
						<span>ឆ្មប</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="4" value="ទទួលការបណ្តុះបណ្តាលផ្នែកវេជ្ជសាស្ត្រមួយចំនួន" data-bind="checked: $root.getAnswer($element)" />
						<span>ទទួលការបណ្តុះបណ្តាលផ្នែកវេជ្ជសាស្ត្រមួយចំនួន (មិនមានសញ្ញាបត្រ័)</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="4" value="គ្រូខ្មែរបុរាណ" data-bind="checked: $root.getAnswer($element)" />
						<span>គ្រូខ្មែរបុរាណ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="4" value="ពុំមានវេជ្ជាជីវៈជាពេទ្យ" data-bind="checked: $root.getAnswer($element)" />
						<span>ពុំមានវេជ្ជាជីវៈជាពេទ្យ (ឧ.អ្នកជំនួញ)</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="4" value="ឳសថការី" data-bind="checked: $root.getAnswer($element)" />
						<span>ឳសថការី</span>
					</label>
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “5” នៅក្នុងប្រអប់ពិន្ទុ បើសិនជាចំលើយមួយក្នុងចំណោមចំលើយឌិតត្រូវបានជ្រើសរើស។ បើមិនដូច្នោះទេ សូមដាក់ពិន្ទុ “0”</td>
			<td><input type="text" class="form-control text-center" name="4" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">5</td>
			<th>តើនៅពេលណាដែលអ្នកផ្តល់សេវាបាន ទទួលការបណ្តុះបណ្តាលអំពីជំងឺគ្រុនចាញ់ពីអង្គការសង្គមស៊ីវិល ឬរដ្ឋាភិបាល(CNM)?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="5" value="6 ខែឬតិចជាងនេះ" data-bind="checked: $root.getAnswer($element)" />
						<span>6 ខែឬតិចជាងនេះ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="5" value="7 ខែ - 12 ខែ" data-bind="checked: $root.getAnswer($element)" />
						<span>7 ខែ - 12 ខែ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="5" value="13 ខែ - 18 ខែ" data-bind="checked: $root.getAnswer($element)" />
						<span>13 ខែ - 18 ខែ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="5" value="19 ខែឬច្រើនខែ" data-bind="checked: $root.getAnswer($element)" />
						<span>19 ខែឬច្រើនខែ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="5" value="មិនបានទទួល" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនបានទទួល</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើការបណ្តុះបណ្តាលគឺចាប់ពី 19 ខែឡើងទៅ / មិនដែលបានទទួល ចូរដាក់ “5” ពិន្ទុ។ ក្រៅពីនេះដាក់ពិន្ទុ “0”</td>
			<td><input type="text" class="form-control text-center" name="5" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">6</td>
			<th>តើខ្ញុំអាចទំនាក់ទំនងទៅកាន់កន្លែងផ្តល់សេវារបស់អ្នកតាមរបៀបណា?</th>
			<td><input type="text" class="form-control text-center" name="6" data-bind="value: $root.getAnswer($element)" /></td>
			<td align="center">ឧ. លេខទូរស័ព្ទ / អ៊ីម៉ែល</td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">7</td>
			<th>ប្រសិនបើអ្នកផ្តល់សេវាមិនព្រមផ្តល់បទសំភាស<br /><br />សូមសួរមូលហេតុមុននឹងបញ្ចប់ការវាយតម្លៃនេះ</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="7" value="មានអតិថិជនច្រើន" data-bind="checked: $root.getAnswer($element)" />
						<span>មានអតិថិជនច្រើន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="7" value="គិតថាវាមិនមានប្រយោជន៍" data-bind="checked: $root.getAnswer($element)" />
						<span>គិតថាវាមិនមានប្រយោជន៍</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="7" value="បដិសេធមិនផ្តល់មូលហេតុ" data-bind="checked: $root.getAnswer($element)" />
						<span>បដិសេធមិនផ្តល់មូលហេតុ</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="7.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr class="bg-warning">
			<th colspan="3">ផ្នែកទី២ ចំណេះដឹងរបស់អ្នកផ្តល់សេវាអំពីជំងឺគ្រុនចាញ់</th>
			<th align="center">ការណែនាំអំពីពិន្ទុ</th>
			<th align="center">ពិន្ទុ</th>
		</tr>
		<tr>
			<td colspan="5"><i>កំណត់ចំណាំ៖ ចំពោះសំនួរទី 8 9 និង 11 អានសំនួរអោយអ្នកផ្តល់សេវាដោយផ្ទាល់ ប៉ុន្តែមិនត្រូវអានចំលើយនោះទេ។</i></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">8</td>
			<td>
				<b>តើអ្នកអាចរៀបរាប់ សញ្ញាណគ្រោះថ្នាក់ និងរោគសញ្ញាគ្រុនចាញ់ យ៉ាងតិច 3 បានដែរឬទេ?</b>
				<br /><br />
				<i>(កុំអានចម្លើយ)</i>
			</td>
			<td>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="8" value="បាត់បង់ស្មារតី / សន្លប់" data-bind="checked: $root.getAnswer($element)" />
						<span>បាត់បង់ស្មារតី / សន្លប់</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="8" value="ទឹកនោមតិច" data-bind="checked: $root.getAnswer($element)" />
						<span>ទឹកនោមតិច</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="8" value="ការស្ទះ" data-bind="checked: $root.getAnswer($element)" />
						<span>ការស្ទះ</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="8" value="មិនអាចអង្គុយ / ញ៉ាំ/ផឹកបានទេ" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនអាចអង្គុយ / ញ៉ាំ/ផឹកបានទេ</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="8" value="មានក្អួតញឹកញាប់" data-bind="checked: $root.getAnswer($element)" />
						<span>មានក្អួតញឹកញាប់</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="8" value="ឡើងពណ៌លឿង ឬស្លេកស្លាំងខ្លាំង" data-bind="checked: $root.getAnswer($element)" />
						<span>ឡើងពណ៌លឿង ឬស្លេកស្លាំងខ្លាំង</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="8" value="មិនអាចកំណត់រោគសញ្ញាបាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនអាចកំណត់រោគសញ្ញាបាន</span>
					</label>
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “3” នៅក្នុងប្រអប់ពិន្ទុ បើសិនជាសេវាឯកជនមិនដឹងសញ្ញាចំនួន 3 ក្នុងចំនោមសញ្ញាទាំងអស់។ បើមិនដូច្នោះទេ សូមដាក់ពិន្ទុ “0”</td>
			<td><input type="text" class="form-control text-center" name="8" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">9</td>
			<td>
				<b>តើអ្នកអាចរៀបរាប់ពីរោគសញ្ញានៃជំងឺគ្រុនចាញ់យ៉ាងហោចណាស់ 3 ដែរឬទេ?</b>
				<br /><br />
				<i>(កុំអានចម្លើយ)</i>
			</td>
			<td>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="9" value="គ្រុនក្តៅ" data-bind="checked: $root.getAnswer($element)" />
						<span>គ្រុនក្តៅ</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="9" value="ឈឺក្បាល" data-bind="checked: $root.getAnswer($element)" />
						<span>ឈឺក្បាល</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="9" value="ញាក់" data-bind="checked: $root.getAnswer($element)" />
						<span>ញាក់</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="9" value="ក្អួតចង្អោ" data-bind="checked: $root.getAnswer($element)" />
						<span>ក្អួតចង្អោ</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="9" value="ក្អួត" data-bind="checked: $root.getAnswer($element)" />
						<span>ក្អួត</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="9" value="ការបែកញើស" data-bind="checked: $root.getAnswer($element)" />
						<span>ការបែកញើស</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="9" value="ជំងឺរាគ" data-bind="checked: $root.getAnswer($element)" />
						<span>ជំងឺរាគ</span>
					</label>
				</div>
				<div class="checkbox checkbox-lg">
					<label>
						<input type="checkbox" name="9" value="មិនអាចធ្វើការកំណត់អត្តសញ្ញាណ" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនអាចធ្វើការកំណត់អត្តសញ្ញាណ</span>
					</label>
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “3” នៅក្នុងប្រអប់ពិន្ទុ បើសិនជាសេវាឯកជនមិនដឹងសញ្ញាចំនួន 3 ក្នុងចំនោមសញ្ញាទាំងអស់។ បើមិនដូច្នោះទេ សូមដាក់ពិន្ទុ “0”</td>
			<td><input type="text" class="form-control text-center" name="10" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">10</td>
			<th>តើអ្នកជំងឺដែលមានសញ្ញានិងរោគសញ្ញាខាងលើនេះបានមកទទួលសេវារបស់អ្នកក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយនេះមានចំនួនសរុបប៉ុន្មាន?</th>
			<td align="center" colspan="3">
				<div class="form-group text-bold">ចំនួនអ្នកជំងឺដែលមានសញ្ញានិងរោគសញ្ញាជំងឺគ្រុនចាញ់សរុប:</div>
				<div class="form-inline">
					<input type="text" class="form-control text-center" name="10" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">11</td>
			<td>
				<b>នៅពេលអ្នកសង្ស័យថាអ្នកជំងឺកំពុងមានជំងឺគ្រុនចាញ់ តើអ្នកធ្វើអ្វី?</b>
				<br /><br />
				<i>(កុំអានចម្លើយ)</i>
			</td>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="11" value="ធ្វើតេស្តឈាមដោយប្រើ RDT" data-bind="checked: $root.getAnswer($element)" />
						<span>ធ្វើតេស្តឈាមដោយប្រើ RDT</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="11" value="ធ្វើតេស្តឈាមដោយប្រើមីក្រូទស្សន៍" data-bind="checked: $root.getAnswer($element)" />
						<span>ធ្វើតេស្តឈាមដោយប្រើមីក្រូទស្សន៍</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="11" value="ផ្តល់ឱសថដោយមិនចាំបាច់ធ្វើតេស្ត" data-bind="checked: $root.getAnswer($element)" />
						<span>ផ្តល់ឱសថដោយមិនចាំបាច់ធ្វើតេស្ត</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="11" value="បញ្ជូនទៅគ្លីនីកឬគ្លីនីកពហុព្យាបាល" data-bind="checked: $root.getAnswer($element)" />
						<span>បញ្ជូនទៅគ្លីនីកឬគ្លីនីកពហុព្យាបាល</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="11" value="បញ្ជូនទៅមណ្ឌលសុខភាពសាធារណៈ" data-bind="checked: $root.getAnswer($element)" />
						<span>បញ្ជូនទៅមណ្ឌលសុខភាពសាធារណៈ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="11" value="បញ្ជូនទៅអ្នកស្ម័គ្រចិត្តព្យាលបាលជំងឺគ្រុនចាញ់" data-bind="checked: $root.getAnswer($element)" />
						<span>បញ្ជូនទៅអ្នកស្ម័គ្រចិត្តព្យាលបាលជំងឺគ្រុនចាញ់</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="11" value="ស្វែងរកចំពោះជំងឺផ្សេងៗទៀត" data-bind="checked: $root.getAnswer($element)" />
						<span>ស្វែងរកចំពោះជំងឺផ្សេងៗទៀត</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="11" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="11.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយ “បញ្ជូន” ដាក់ ”0” នៅក្នុងប្រអប់ពិន្ទុ។ ប្រសិនបើចម្លើយ ត្រូវបានផ្តល់ថ្នាំឱ្យដោយគ្មានការធ្វើតេស្ត ត្រូវដាក់ពិន្ទុ “9” ក្រៅពីនោះ ដាក់ពិន្ទុ “5” ក្នុងប្រអប់ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="11" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr class="bg-warning">
			<th colspan="3">ផ្នែកទី៣ តេស្ត និងឱសថព្យាបាលជំងឺគ្រុនចាញ់</th>
			<th align="center">ការណែនាំអំពីពិន្ទុ</th>
			<th align="center">ពិន្ទុ</th>
		</tr>
		<tr>
			<td align="center" class="bg-success en">12</td>
			<td>
				<b>តើអ្នកមានតេស្ត និងថ្នាំព្យាបាលជំងឺគ្រុនចាញ់នៅកន្លែងរបស់អ្នកដែរឬទេ?</b>
				<br><br>
				<i>(អ្នកអភិបាល ត្រូវសង្កេតមើលនៅលើធ្នើប្រសិនបើទំនិញទាំងនេះមាន)</i>
			</td>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="12" value="តេស្ត RDT" data-bind="checked: $root.getAnswer($element)" />
						<span>តេស្ត RDT</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="12" value="តេស្តដោយមីក្រូទស្សន៍" data-bind="checked: $root.getAnswer($element)" />
						<span>តេស្តដោយមីក្រូទស្សន៍ (រំលងទៅសំនួរទី២២)</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="12" value="ថ្នាំចាក់ ឬថ្នាំគ្រាប់ព្យាបាលជំងឺគ្រុនចាញ់ (Artemisinin រួមបញ្ចូល)" data-bind="checked: $root.getAnswer($element)" />
						<span>ថ្នាំចាក់ ឬថ្នាំគ្រាប់ព្យាបាលជំងឺគ្រុនចាញ់ (Artemisinin រួមបញ្ចូល) (រំលងទៅសំនួរទី២៧)</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="12" value="តេស្ត RDT និងមីក្រូទស្សន៍" data-bind="checked: $root.getAnswer($element)" />
						<span>តេស្ត RDT និងមីក្រូទស្សន៍</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="12" value="តេស្ត RDT មីក្រូទស្សន៍ និងថ្នាំខាងលើ" data-bind="checked: $root.getAnswer($element)" />
						<span>តេស្ត RDT មីក្រូទស្សន៍ និងថ្នាំខាងលើ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="12" value="គ្មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>គ្មាន​(រំលងទៅ33)</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើមានការតេស្ត និងថ្នាំ ដាក់ “5” នៅក្នុងប្រអប់ពិន្ទុ ប្រសិនបើមានតែតេស្ត ឬមានតែថ្នាំ សូមដាក់ “3” នៅក្នុងប្រអប់ពិន្ទុ ប្រសិនបើ “គ្មាន” ដាក់ “0” ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="12" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">13</td>
			<th>ហេតុអ្វីបានជាអ្នកស្តុកតេស្ត និងថ្នាំទាំងនេះ?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="13" value="មានតម្រូវការ" data-bind="checked: $root.getAnswer($element)" />
						<span>មានតម្រូវការ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="13" value="អាចរកប្រាក់ចំណេញបានខ្ពស់" data-bind="checked: $root.getAnswer($element)" />
						<span>អាចរកប្រាក់ចំណេញបានខ្ពស់</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="13" value="ការផ្គត់ផ្គង់ដោយឥតគិតថ្លៃ" data-bind="checked: $root.getAnswer($element)" />
						<span>ការផ្គត់ផ្គង់ដោយឥតគិតថ្លៃ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="13" value="ការណែនាំរបស់រដ្ឋាភិបាល" data-bind="checked: $root.getAnswer($element)" />
						<span>ការណែនាំរបស់រដ្ឋាភិបាល</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="13" value="តំលៃថោក" data-bind="checked: $root.getAnswer($element)" />
						<span>តំលៃថោក</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="13" value="មានប្រសិទ្ធិភាពបំផុតសម្រាប់ការធ្វើតេស្ត និងព្យាបាលជំងឺគ្រុនចាញ់" data-bind="checked: $root.getAnswer($element)" />
						<span>មានប្រសិទ្ធិភាពបំផុតសម្រាប់ការធ្វើតេស្ត និងព្យាបាលជំងឺគ្រុនចាញ់</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="13" value="មិនដឺង" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនដឺង</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="13" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="13.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center" colspan="2">ចំលើយមានលើសពីមួយដូច្នេះសូមគូសទាំងអស់ប្រសិនបើមាន</td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">14</td>
			<th>តើកន្លែងផ្តល់សេវារបស់អ្នកមានតេស្ត RDT សរុបចំនួនប៉ុន្មាន?</th>
			<td class="form-inline">
				<span>ចំនួនតេស្តសរុប</span>
				<input type="text" class="form-control text-center width120" name="14" data-bind="value: $root.getAnswer($element)" />
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">14.1</td>
			<th>ឈ្មោះយីហោ និងកាលបរិច្ឆេទផុតកំណត់របស់តេស្ត</th>
			<td>
				<div class="form-group form-inline">
					<span>តេស្ត</span>
					<input type="text" class="form-control" name="14.1.Test" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline">
					<span>ថ្ងៃផុតកំណត់</span>
					<input type="text" class="form-control text-center width120" name="14.1.Expire" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">14.2</td>
			<th>ឈ្មោះយីហោ និងកាលបរិច្ឆេទផុតកំណត់របស់តេស្ត</th>
			<td>
				<div class="form-group form-inline">
					<span>តេស្ត</span>
					<input type="text" class="form-control" name="14.2.Test" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline">
					<span>ថ្ងៃផុតកំណត់</span>
					<input type="text" class="form-control text-center width120" name="14.2.Expire" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">14.3</td>
			<th>ឈ្មោះយីហោ និងកាលបរិច្ឆេទផុតកំណត់របស់តេស្ត</th>
			<td>
				<div class="form-group form-inline">
					<span>តេស្ត</span>
					<input type="text" class="form-control" name="14.3.Test" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline">
					<span>ថ្ងៃផុតកំណត់</span>
					<input type="text" class="form-control text-center width120" name="14.3.Expire" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">15</td>
			<th colspan="2">តើអ្នកទទួលបានការផ្គត់ផ្គង់តេស្ត RDT មកពីកន្លែងណា?</th>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">15.1</td>
			<th>ម៉ាកទី ១</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.1" value="ផ្សារ" data-bind="checked: $root.getAnswer($element)" />
						<span>ផ្សារ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.1" value="ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ" data-bind="checked: $root.getAnswer($element)" />
						<span>ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.1" value="កន្លែងសុខភាពសាធារណៈជាក់លាក់" data-bind="checked: $root.getAnswer($element)" />
						<span>កន្លែងសុខភាពសាធារណៈជាក់លាក់</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="15.1" value="អង្គការក្រៅរដ្ឋាភិបាល" data-bind="checked: $root.getAnswer($element)" />
							<span>អង្គការក្រៅរដ្ឋាភិបាល (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="15.1.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="15.1.Other" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="15.1.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="15.1" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">15.2</td>
			<th>ម៉ាកទី ២</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.2" value="ផ្សារ" data-bind="checked: $root.getAnswer($element)" />
						<span>ផ្សារ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.2" value="ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ" data-bind="checked: $root.getAnswer($element)" />
						<span>ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.2" value="កន្លែងសុខភាពសាធារណៈជាក់លាក់" data-bind="checked: $root.getAnswer($element)" />
						<span>កន្លែងសុខភាពសាធារណៈជាក់លាក់</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="15.2" value="អង្គការក្រៅរដ្ឋាភិបាល" data-bind="checked: $root.getAnswer($element)" />
							<span>អង្គការក្រៅរដ្ឋាភិបាល (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="15.2.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="15.2" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="15.2.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="15.2" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">15.3</td>
			<th>ម៉ាកទី ៣</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.3" value="ផ្សារ" data-bind="checked: $root.getAnswer($element)" />
						<span>ផ្សារ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.3" value="ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ" data-bind="checked: $root.getAnswer($element)" />
						<span>ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="15.3" value="កន្លែងសុខភាពសាធារណៈជាក់លាក់" data-bind="checked: $root.getAnswer($element)" />
						<span>កន្លែងសុខភាពសាធារណៈជាក់លាក់</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="15.3" value="អង្គការក្រៅរដ្ឋាភិបាល" data-bind="checked: $root.getAnswer($element)" />
							<span>អង្គការក្រៅរដ្ឋាភិបាល (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="15.3.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="15.3" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="15.3.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="15.3" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">16</td>
			<th colspan="2">តើអ្នកប្រើតេស្ត RDT យ៉ាងដូចម្តេច?</th>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">16.1</td>
			<th>ម៉ាកទី ‌១</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.1" value="ប្រើយីហោនេះដើម្បីតេស្តអ្នកជំងឺដែលសង្ស័យមានជំងឺនៅកន្លែងរបស់អ្នក" data-bind="checked: $root.getAnswer($element)" />
						<span>ប្រើយីហោនេះដើម្បីតេស្តអ្នកជំងឺដែលសង្ស័យមានជំងឺនៅកន្លែងរបស់អ្នក</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.1" value="លក់ទៅអោយអ្នកផ្គត់ផ្គង់សេវាដទៃ" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកផ្គត់ផ្គង់សេវាដទៃ (ឧ. កន្លែងលក់ថ្នាំ)</span>
					</label>
				</div>
				<div class="form-inline" style="margin:5px 0 5px 25px">
					<span>(បញ្ជាក់)</span>
					<input type="text" class="form-control input-sm" name="16.1.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.1" value="លក់ទៅអោយអ្នកជំងឺដែលសង្ស័យគ្រុនចាញ់អោយយកទៅធ្វើតេស្តនៅកន្លែងផ្សេង" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកជំងឺដែលសង្ស័យគ្រុនចាញ់អោយយកទៅធ្វើតេស្តនៅកន្លែងផ្សេង</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="16.1" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="16.1.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “3” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="16.1" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">16.2</td>
			<th>ម៉ាកទី ‌២</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.2" value="ប្រើយីហោនេះដើម្បីតេស្តអ្នកជំងឺដែលសង្ស័យមានជំងឺនៅកន្លែងរបស់អ្នក" data-bind="checked: $root.getAnswer($element)" />
						<span>ប្រើយីហោនេះដើម្បីតេស្តអ្នកជំងឺដែលសង្ស័យមានជំងឺនៅកន្លែងរបស់អ្នក</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.2" value="លក់ទៅអោយអ្នកផ្គត់ផ្គង់សេវាដទៃ" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកផ្គត់ផ្គង់សេវាដទៃ (ឧ. កន្លែងលក់ថ្នាំ)</span>
					</label>
				</div>
				<div class="form-inline" style="margin:5px 0 5px 25px">
					<span>(បញ្ជាក់)</span>
					<input type="text" class="form-control input-sm" name="16.2.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.2" value="លក់ទៅអោយអ្នកជំងឺដែលសង្ស័យគ្រុនចាញ់អោយយកទៅធ្វើតេស្តនៅកន្លែងផ្សេង" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកជំងឺដែលសង្ស័យគ្រុនចាញ់អោយយកទៅធ្វើតេស្តនៅកន្លែងផ្សេង</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="16.2" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="16.2.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “3” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="16.2" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">16.3</td>
			<th>ម៉ាកទី ‌៣</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.3" value="ប្រើយីហោនេះដើម្បីតេស្តអ្នកជំងឺដែលសង្ស័យមានជំងឺនៅកន្លែងរបស់អ្នក" data-bind="checked: $root.getAnswer($element)" />
						<span>ប្រើយីហោនេះដើម្បីតេស្តអ្នកជំងឺដែលសង្ស័យមានជំងឺនៅកន្លែងរបស់អ្នក</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.3" value="លក់ទៅអោយអ្នកផ្គត់ផ្គង់សេវាដទៃ" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកផ្គត់ផ្គង់សេវាដទៃ (ឧ. កន្លែងលក់ថ្នាំ)</span>
					</label>
				</div>
				<div class="form-inline" style="margin:5px 0 5px 25px">
					<span>(បញ្ជាក់)</span>
					<input type="text" class="form-control input-sm" name="16.3.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="16.3" value="លក់ទៅអោយអ្នកជំងឺដែលសង្ស័យគ្រុនចាញ់អោយយកទៅធ្វើតេស្តនៅកន្លែងផ្សេង" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកជំងឺដែលសង្ស័យគ្រុនចាញ់អោយយកទៅធ្វើតេស្តនៅកន្លែងផ្សេង</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="16.3" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="16.3.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “3” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="16.3" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">17</td>
			<th>តើមានមនុស្សប៉ុន្មាននាក់ត្រូវបានធ្វើតេស្តដោយប្រើប្រាស់តេស្ត RDT ក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយ?</th>
			<td align="center" colspan="3">
				<div class="form-group text-bold">ចំនួនមនុស្សត្រូវបានធ្វើតេស្តដោយប្រើប្រាស់តេស្ត RDT ក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយ</div>
				<div class="form-inline">
					<input type="text" class="form-control text-center" name="17" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
		</tr>
		<tr>
			<td align="center" class="en">17.1</td>
			<th>ម៉ាកទី ‌១</th>
			<td><input type="text" class="form-control text-center width120" name="17.1" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">17.2</td>
			<th>ម៉ាកទី ‌២</th>
			<td><input type="text" class="form-control text-center width120" name="17.2" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">17.3</td>
			<th>ម៉ាកទី ‌៣</th>
			<td><input type="text" class="form-control text-center width120" name="17.3" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">18</td>
			<th colspan="2">តើមានតេស្ត RDT ចំនួនប៉ុន្មានដែលត្រូវបានលក់ក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយ?</th>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">18.1</td>
			<th>ម៉ាកទី ‌១</th>
			<td><input type="text" class="form-control text-center width120" name="18.1" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">18.2</td>
			<th>ម៉ាកទី ‌២</th>
			<td><input type="text" class="form-control text-center width120" name="18.2" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">18.3</td>
			<th>ម៉ាកទី ‌៣</th>
			<td><input type="text" class="form-control text-center width120" name="18.3" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">19</td>
			<th>នៅពេលការធ្វើតេស្ត RDT មានភាពវិជ្ជមាន តើអ្នកធ្វើអ្វី?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="19" value="ព្យាបាលអ្នកជំងឺជាមួយនឹងថ្នាំផ្សំ" data-bind="checked: $root.getAnswer($element)" />
						<span>ព្យាបាលអ្នកជំងឺជាមួយនឹងថ្នាំផ្សំ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name=19"" value="ថ្នាំចាក់ ឬថ្នាំគ្រាប់ព្យាបាលជំងឺគ្រុនចាញ់ (Artemisinin រួមចញ្ចូល)" data-bind="checked: $root.getAnswer($element)" />
						<span>ថ្នាំចាក់ ឬថ្នាំគ្រាប់ព្យាបាលជំងឺគ្រុនចាញ់ (Artemisinin រួមចញ្ចូល)</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="19" value="បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាពសាធារណៈ" data-bind="checked: $root.getAnswer($element)" />
						<span>បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាពសាធារណៈ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="19" value="ការណែនាំបញ្ជូនទៅគ្លីនីក ឬគ្លីនីកពហុព្យាបាល" data-bind="checked: $root.getAnswer($element)" />
						<span>ការណែនាំបញ្ជូនទៅគ្លីនីក ឬគ្លីនីកពហុព្យាបាល</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="19" value="បញ្ជូនទៅអ្នកស្ម័គ្រចិត្តព្យាបាលជំងឺគ្រុនចាញ់" data-bind="checked: $root.getAnswer($element)" />
						<span>បញ្ជូនទៅអ្នកស្ម័គ្រចិត្តព្យាបាលជំងឺគ្រុនចាញ់</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="19" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="19.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយ “បញ្ជូន” ដាក់ “0” នៅក្នុងពិន្ទុ។ បើមិនដូច្នោះទេដាក់ “3”</td>
			<td><input type="text" class="form-control text-center" name="19" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">20</td>
			<th>តើមានមនុស្សប៉ុន្មាននាក់ត្រូវបានបញ្ជូនក្នុងរយៈពេល 30 ចុងក្រោយ (RDT)?</th>
			<td align="center" colspan="3">
				<div class="form-group text-bold">ចំនួនអ្នកជំងឺត្រូវបានបញ្ជូនក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយ</div>
				<div class="form-inline">
					<input type="text" class="form-control text-center" name="20" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">21</td>
			<th>តើអ្នកអាចផ្តល់ឈ្មោះកន្លែងសុខភាពសាធារណៈធំៗ៣ ដែលអ្នកបញ្ជូនអ្នកជំងឺទៅបានដែរឬទេ?</th>
			<td>
				<div class="form-group form-inline">
					<span>ទី១</span>
					<input type="text" class="form-control" name="21.1" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-group form-inline">
					<span>ទី២</span>
					<input type="text" class="form-control" name="21.2" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline">
					<span>ទី៣</span>
					<input type="text" class="form-control" name="21.3" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">22</td>
			<th>តើអ្នកមានផ្តល់សេវាធ្វើតេស្តគ្រុនចាញ់ដោយមីក្រូទស្សន៍ដែរឬទេ?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="22" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="22" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយ “មាន” ដាក់ “2” ពិន្ទុ។ បើមិនមាន ដាក់ “0”</td>
			<td><input type="text" class="form-control text-center" name="22" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">23</td>
			<th>តើមានមនុស្សប៉ុន្មាននាក់ត្រូវបានធ្វើតេស្តដោយមីក្រូទស្សន៍ក្នុងរយៈពេល 30 ចុងក្រោយ?</th>
			<td align="center" colspan="3">
				<div class="form-group text-bold">ចំនួនមនុស្សត្រូវបានធ្វើតេស្តដោយមីក្រូទស្សន៍ក្នុងរយៈពេល 30 ចុងក្រោយ</div>
				<div class="form-inline">
					<input type="text" class="form-control text-center" name="23" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">24</td>
			<th>នៅពេលការធ្វើតេស្ត RDT មានភាពវិជ្ជមាន តើអ្នកធ្វើអ្វី?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="24" value="ព្យាបាលអ្នកជំងឺជាមួយនឹងថ្នាំផ្សំ" data-bind="checked: $root.getAnswer($element)" />
						<span>ព្យាបាលអ្នកជំងឺជាមួយនឹងថ្នាំផ្សំ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="24" value="ថ្នាំចាក់ ឬថ្នាំគ្រាប់ព្យាបាលជំងឺគ្រុនចាញ់ (Artemisinin រួមចញ្ចូល)" data-bind="checked: $root.getAnswer($element)" />
						<span>ថ្នាំចាក់ ឬថ្នាំគ្រាប់ព្យាបាលជំងឺគ្រុនចាញ់ (Artemisinin រួមចញ្ចូល)</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="24" value="បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាពសាធារណៈ" data-bind="checked: $root.getAnswer($element)" />
						<span>បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាពសាធារណៈ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="24" value="ការណែនាំបញ្ជូនទៅគ្លីនីក ឬគ្លីនីកពហុព្យាបាល" data-bind="checked: $root.getAnswer($element)" />
						<span>ការណែនាំបញ្ជូនទៅគ្លីនីក ឬគ្លីនីកពហុព្យាបាល</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="24" value="បញ្ជូនទៅអ្នកស្ម័គ្រចិត្តព្យាបាលជំងឺគ្រុនចាញ់" data-bind="checked: $root.getAnswer($element)" />
						<span>បញ្ជូនទៅអ្នកស្ម័គ្រចិត្តព្យាបាលជំងឺគ្រុនចាញ់</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="24" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="24.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយ “បញ្ជូន” ដាក់ “0” នៅក្នុងពិន្ទុ។ បើមិនដូច្នោះទេដាក់ “3”</td>
			<td><input type="text" class="form-control text-center" name="24" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">25</td>
			<th>តើមានមនុស្សប៉ុន្មាននាក់ត្រូវបានបញ្ជូនក្នុងរយៈពេល 30 ចុងក្រោយ (មីក្រូទស្សន៍)?</th>
			<td align="center" colspan="3">
				<div class="form-group text-bold">ចំនួនអ្នកជំងឺត្រូវបានបញ្ជូនក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយ</div>
				<div class="form-inline">
					<input type="text" class="form-control text-center" name="25" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">26</td>
			<th>តើអ្នកអាចផ្តល់ឈ្មោះកន្លែងសុខភាពសាធារណៈធំៗ៣ ដែលអ្នកជារឿយៗបញ្ជូនអ្នកជំងឺទៅ?</th>
			<td>
				<div class="form-group form-inline">
					<span>ទី១</span>
					<input type="text" class="form-control" name="26.1" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-group form-inline">
					<span>ទី២</span>
					<input type="text" class="form-control" name="26.2" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline">
					<span>ទី៣</span>
					<input type="text" class="form-control" name="26.3" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">27</td>
			<th>តើចំនួនសរុបនៃថ្នាំ ACT នៅកន្លែងរបស់អ្នកពេលបច្ចុប្បន្នមានប៉ុន្មាន?</th>
			<td class="form-inline">
				<span>ចំនួនថ្នាំសរុប</span>
				<input type="text" class="form-control text-center width120" name="27" data-bind="value: $root.getAnswer($element)" />
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">27.1</td>
			<th>ឈ្មោះទូទៅ និងកាលបរិច្ឆេទផុតកំណត់</th>
			<td>
				<div class="form-group form-inline">
					<span>បន្ទះ</span>
					<input type="text" class="form-control" name="27.1.Name" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline">
					<span>ថ្ងៃផុតកំណត់</span>
					<input type="text" class="form-control text-center width120" name="27.1.Expire" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">27.2</td>
			<th>ឈ្មោះទូទៅ និងកាលបរិច្ឆេទផុតកំណត់</th>
			<td>
				<div class="form-group form-inline">
					<span>បន្ទះ</span>
					<input type="text" class="form-control" name="27.2.Name" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline">
					<span>ថ្ងៃផុតកំណត់</span>
					<input type="text" class="form-control text-center width120" name="27.2.Expire" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">27.3</td>
			<th>ឈ្មោះទូទៅ និងកាលបរិច្ឆេទផុតកំណត់</th>
			<td>
				<div class="form-group form-inline">
					<span>បន្ទះ</span>
					<input type="text" class="form-control" name="27.3.Name" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline">
					<span>ថ្ងៃផុតកំណត់</span>
					<input type="text" class="form-control text-center width120" name="27.3.Expire" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">28</td>
			<th colspan="2">តើអ្នកទទួលបានការផ្គត់ផ្គង់ ACT ពីណាមក?</th>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">28.1</td>
			<th>ម៉ាកទី ១</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.1" value="ផ្សារ" data-bind="checked: $root.getAnswer($element)" />
						<span>ផ្សារ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.1" value="ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ" data-bind="checked: $root.getAnswer($element)" />
						<span>ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.1" value="កន្លែងសុខភាពសាធារណៈជាក់លាក់" data-bind="checked: $root.getAnswer($element)" />
						<span>កន្លែងសុខភាពសាធារណៈជាក់លាក់</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="28.1" value="អង្គការក្រៅរដ្ឋាភិបាល" data-bind="checked: $root.getAnswer($element)" />
							<span>អង្គការក្រៅរដ្ឋាភិបាល (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="28.1.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="28.1" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="28.1.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="28.1" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">28.2</td>
			<th>ម៉ាកទី ២</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.2" value="ផ្សារ" data-bind="checked: $root.getAnswer($element)" />
						<span>ផ្សារ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.2" value="ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ" data-bind="checked: $root.getAnswer($element)" />
						<span>ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.2" value="កន្លែងសុខភាពសាធារណៈជាក់លាក់" data-bind="checked: $root.getAnswer($element)" />
						<span>កន្លែងសុខភាពសាធារណៈជាក់លាក់</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="28.2" value="អង្គការក្រៅរដ្ឋាភិបាល" data-bind="checked: $root.getAnswer($element)" />
							<span>អង្គការក្រៅរដ្ឋាភិបាល (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="28.2.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="28.2" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="28.2.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="28.2" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">28.3</td>
			<th>ម៉ាកទី ៣</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.3" value="ផ្សារ" data-bind="checked: $root.getAnswer($element)" />
						<span>ផ្សារ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.3" value="ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ" data-bind="checked: $root.getAnswer($element)" />
						<span>ឃ្លាំងឱសថកណ្តាល / ឃ្លាំងឱសថថ្នាក់ក្រោមជាតិណាមួយ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="28.3" value="កន្លែងសុខភាពសាធារណៈជាក់លាក់" data-bind="checked: $root.getAnswer($element)" />
						<span>កន្លែងសុខភាពសាធារណៈជាក់លាក់</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="28.3" value="អង្គការក្រៅរដ្ឋាភិបាល" data-bind="checked: $root.getAnswer($element)" />
							<span>អង្គការក្រៅរដ្ឋាភិបាល (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="28.3.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="28.3" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="28.3.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="28.3" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">29</td>
			<th colspan="2">តើអ្នកប្រើ ACT ដោយរបៀបណា?</th>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">29.1</td>
			<th>ម៉ាកទី ‌១</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="29.1" value="ប្រើយីហោនេះដើម្បីព្យាបាលអ្នកជំងឺនៅទីនេះ" data-bind="checked: $root.getAnswer($element)" />
						<span>ប្រើយីហោនេះដើម្បីព្យាបាលអ្នកជំងឺនៅទីនេះ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="29.1" value="លក់ទៅអោយអ្នកដទៃ" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកដទៃ</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="29.1" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="29.1.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="29.1" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">29.2</td>
			<th>ម៉ាកទី ‌២</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="29.2" value="ប្រើយីហោនេះដើម្បីព្យាបាលអ្នកជំងឺនៅទីនេះ" data-bind="checked: $root.getAnswer($element)" />
						<span>ប្រើយីហោនេះដើម្បីព្យាបាលអ្នកជំងឺនៅទីនេះ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="29.2" value="លក់ទៅអោយអ្នកដទៃ" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកដទៃ</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="29.2" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="29.2.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="29.2" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">29.3</td>
			<th>ម៉ាកទី ‌៣</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="29.3" value="ប្រើយីហោនេះដើម្បីព្យាបាលអ្នកជំងឺនៅទីនេះ" data-bind="checked: $root.getAnswer($element)" />
						<span>ប្រើយីហោនេះដើម្បីព្យាបាលអ្នកជំងឺនៅទីនេះ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="29.3" value="លក់ទៅអោយអ្នកដទៃ" data-bind="checked: $root.getAnswer($element)" />
						<span>លក់ទៅអោយអ្នកដទៃ</span>
					</label>
				</div>
				<div class="form-inline" style="margin-top:5px">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="29.3" value="ផ្សេងៗ (បញ្ជាក់)" data-bind="checked: $root.getAnswer($element)" />
							<span>ផ្សេងៗ (បញ្ជាក់)</span>
						</label>
					</div>
					<input type="text" class="form-control input-sm" name="29.3.Other" data-bind="value: $root.getAnswer($element)" />
				</div>
			</td>
			<td align="center">ដាក់ពិន្ទុ “2” នៅក្នុងប្រអប់ពិន្ទុ នៅពេលមានចម្លើយចំពោះសំនួរនេះ</td>
			<td><input type="text" class="form-control text-center" name="29.3" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">30</td>
			<th colspan="2">តើមានអ្នកជំងឺប៉ុន្មាននាក់ត្រូវបានព្យាបាលក្នុងរយៈពេល 30 ចុងក្រោយ?</th>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">30.1</td>
			<th>ម៉ាកទី ‌១</th>
			<td><input type="text" class="form-control text-center width120" name="30.1" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">30.2</td>
			<th>ម៉ាកទី ‌២</th>
			<td><input type="text" class="form-control text-center width120" name="30.2" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">30.3</td>
			<th>ម៉ាកទី ‌៣</th>
			<td><input type="text" class="form-control text-center width120" name="30.3" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">31</td>
			<th colspan="2">តើមានថ្នាំចំនួនប៉ុន្មានគ្រាប់ដែលបានលក់ក្នុងរយៈពេល 30 ចុងក្រោយ?</th>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">31.1</td>
			<th>ម៉ាកទី ‌១</th>
			<td><input type="text" class="form-control text-center width120" name="31.1" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">31.2</td>
			<th>ម៉ាកទី ‌២</th>
			<td><input type="text" class="form-control text-center width120" name="31.2" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">31.3</td>
			<th>ម៉ាកទី ‌៣</th>
			<td><input type="text" class="form-control text-center width120" name="31.3" data-bind="value: $root.getAnswer($element)" /></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">32</td>
			<th>ក្រៅពី ACT តើអ្នកប្រើថ្នាំប្រឆាំងគ្រុនចាញ់ អ្វីខ្លះទៀតអោយទៅអ្នកជំងឺ?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="32" value="ការព្យាបាលដោយប្រើថ្នាំ Artemisinin" data-bind="checked: $root.getAnswer($element)" />
						<span>ការព្យាបាលដោយប្រើថ្នាំ Artemisinin</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="32" value="ថ្នាំផ្សេងទៀត (ថ្នាំផ្សំ ថ្នាំបំបាត់ការឈឺចាប់)" data-bind="checked: $root.getAnswer($element)" />
						<span>ថ្នាំផ្សេងទៀត (ថ្នាំផ្សំ ថ្នាំបំបាត់ការឈឺចាប់)</span>
					</label>
				</div>
				<div class="form-inline" style="margin:5px 0 5px 25px">
					<span>(បញ្ជាក់)</span>
					<input type="text" class="form-control input-sm" name="32.A" data-bind="value: $root.getAnswer($element)" />
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="32" value="គ្មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>គ្មាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយ “គ្មាន” មិនត្រូវបានជ្រើសរើស ដាក់ “1” នៅក្នុងប្រអប់ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="32" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr class="bg-warning">
			<th colspan="3">ផ្នែកទី៤ របាយការណ៍ និងឯកសារ</th>
			<th align="center">ការណែនាំអំពីពិន្ទុ</th>
			<th align="center">ពិន្ទុ</th>
		</tr>
		<tr>
			<td colspan="5"><i>កំណត់ចំណាំ៖ ចំពោះផ្នែកទី៤ សូមពិនិត្យដោយផ្ទាល់</i></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">33</td>
			<th colspan="2">តើអ្នកផ្តល់សេវាឯកជនមានសំភារៈទាំងអស់នេះដែរឬទេ?</th>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">33.1</td>
			<th>សៀវភៅកត់ត្រាអ្នកជំងឺ</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="33.1" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="33.1" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយគឺ មិនមាន ដាក់ “3” នៅក្នុងប្រអប់ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="33.1" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">33.2</td>
			<th>សៀវភៅបញ្ជូន</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="33.2" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="33.2" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយគឺ មិនមាន ដាក់ “3” នៅក្នុងប្រអប់ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="33.2" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">34</td>
			<th>តើរបាយការណ៍បញ្ជូនត្រូវបានរាយការណ៍ត្រឹមត្រូវឬទេ?</th>
			<td colspan="3" align="center">ពិនិត្យរបាយការណ៍ក្នុងខែមុនៗ ជាមួយនឹងចំនួនករណីបញ្ជូន</td>
		</tr>
		<tr>
			<td align="center" class="en">34.1</td>
			<th>ចំនួនករណីដែលត្រូវបានបញ្ជូនត្រូវគ្នានឹងករណីសង្ស័យ</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="34.1" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="34.1" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយគឺ មិនមាន ដាក់ “4” នៅក្នុងប្រអប់ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="34.1" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">34.2</td>
			<th>ចំនួនត្រូវបានបញ្ជូនទៅត្រូវនឹងករណីវិជ្ជមាន</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="34.2" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="34.2" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយគឺ មិនមាន ដាក់ “4” នៅក្នុងប្រអប់ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="34.2" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">34.3</td>
			<th>ចំនួននៃការបញ្ជូននៅក្នុងសៀវភៅកត់ត្រាអ្នកជំងឺ / របាយការណ៍ត្រូវគ្នានឹងចំនួនប័ណ្ណបញ្ជូន</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="34.3" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="34.3" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយគឺ មិនមាន ដាក់ “4” នៅក្នុងប្រអប់ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="34.3" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">35</td>
			<th>តើចំនួនករណីវិជ្ជមាន និងRDTs ក្នុងសៀវភៅកំណត់ហេតុដូចគ្នានឹងរបាយការណ៍ពី PPM ដែរឬទេក្នុងរយៈពេល៣ខែចុងក្រោយ?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="35" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="35" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="35" value="មិនបានទទួលរបាយការន៍សំរាប់រយៈពេល៣ខែ" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនបានទទួលរបាយការន៍សំរាប់រយៈពេល៣ខែ</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយគឺ មិនមានឬមិនបានទទួលសំរាប់រយៈពេល៣ខែ ដាក់ “2” នៅក្នុងប្រអប់ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="35" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr class="bg-warning">
			<th colspan="3">ផ្នែកទី៥ ការវាយតម្លៃនៅកន្លែងធ្វើការ</th>
			<th align="center">ការណែនាំអំពីពិន្ទុ</th>
			<th align="center">ពិន្ទុ</th>
		</tr>
		<tr>
			<td align="center" class="bg-success en">36</td>
			<th>ការសង្កេតរបស់អ្នកអភិបាល</th>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="en">36.1</td>
			<th>អំពីក្រដាសជំនួយការងារ</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="36.1" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="36.1" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយគឺ មិនមាន ដាក់ “5” ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="36.1" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="en">36.2</td>
			<th>សំភារៈអប់រំសុខភាព គ្រុនចាញ់ IEC / BCC</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="36.2" value="មាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="36.2" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយគឺ មិនមាន ដាក់ “5” ពិន្ទុ</td>
			<td><input type="text" class="form-control text-center" name="36.2" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr class="bg-warning">
			<th colspan="3">ផ្នែកទី៦ ការយល់ដឹងរបស់អ្នកផ្តល់សេវាលើគម្រោង PPM</th>
			<th align="center">ការណែនាំអំពីពិន្ទុ</th>
			<th align="center">ពិន្ទុ</th>
		</tr>
		<tr>
			<td align="center" class="bg-success en">37</td>
			<th>តើអ្នកផ្តល់សេវាឯកជនត្រូវបានអនុញ្ញាតអោយធ្វើតេស្ត និងព្យាបាលជំងឺគ្រុនចាញ់ដែរឬទេនៅឆ្នាំ 2019?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="37" value="អ្នកផ្តល់សេវាឯកជនមិនត្រូវបានអនុញ្ញាតអោយធ្វើតេស្ត" data-bind="checked: $root.getAnswer($element)" />
						<span>អ្នកផ្តល់សេវាឯកជនមិនត្រូវបានអនុញ្ញាតអោយធ្វើតេស្ត</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="37" value="អ្នកផ្តល់សេវាឯកជនមិនត្រូវបានអនុញ្ញាតអោយព្យាលបាល" data-bind="checked: $root.getAnswer($element)" />
						<span>អ្នកផ្តល់សេវាឯកជនមិនត្រូវបានអនុញ្ញាតអោយព្យាលបាល</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="37" value="អ្នកផ្តល់សេវាឯកជនអាចទិញ RDT សំរាប់ការធ្វើតេស្ត" data-bind="checked: $root.getAnswer($element)" />
						<span>អ្នកផ្តល់សេវាឯកជនអាចទិញ RDT សំរាប់ការធ្វើតេស្ត</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="37" value="អ្នកផ្តល់សេវាឯកជនអាចទិញថ្នាំ ដើម្បីព្យាបាល" data-bind="checked: $root.getAnswer($element)" />
						<span>អ្នកផ្តល់សេវាឯកជនអាចទិញថ្នាំ ដើម្បីព្យាបាល</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="37" value="អ្នកផ្តល់សេវាឯកជនគួរបញ្ជូនអ្នកសង្ស័យថាមានជំងឺគ្រុនចាញ់ទៅមូលដ្ឋានសុខាភិបាលសាធារណៈ" data-bind="checked: $root.getAnswer($element)" />
						<span>អ្នកផ្តល់សេវាឯកជនគួរបញ្ជូនអ្នកសង្ស័យថាមានជំងឺគ្រុនចាញ់ទៅមូលដ្ឋានសុខាភិបាលសាធារណៈ</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="37" value="មិនដឹង" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនដឹង</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយមិនត្រឹមត្រូវ ត្រូវបានរើស ដាក់ពិន្ទុ “2.5”</td>
			<td><input type="text" class="form-control text-center" name="37" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">38</td>
			<th>តើអ្នកគិតថាអ្នកផ្តល់សេវាមីក្រូស្កុបអាចផ្តល់សេវាធ្វើតេស្តអ្នកដែលសង្ស័យជំងឺគ្រុនចាញ់បានដែរឬទេ?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="38" value="បាន" data-bind="checked: $root.getAnswer($element)" />
						<span>បាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="38" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td align="center" class="bg-success en">39</td>
			<th>ចាប់ពីខែឧសភាឆ្នាំ 2018 មក តើអ្នកបានទទួលការទំនាក់ទំនងឬលិខិត (អ៊ីម៉ែល) ពីរដ្ឋាភិបាលឬអង្គការក្រៅរដ្ឋាភិបាលដើម្បីប្រាប់អំពីការផ្លាស់ប្តូរយុទ្ធសាស្ត្រកម្មវិធី PPM ដែរឬទេ?</th>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="39" value="បាន" data-bind="checked: $root.getAnswer($element)" />
						<span>បាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="39" value="មិនមាន" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនមាន</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="39" value="មិនប្រាកដ" data-bind="checked: $root.getAnswer($element)" />
						<span>មិនប្រាកដ</span>
					</label>
				</div>
			</td>
			<td align="center">ប្រសិនបើចម្លើយ “ទេ” ឬ “មិនប្រាកដ” ត្រូវបានរើស ដាក់ពិន្ទុ “2.5”</td>
			<td><input type="text" class="form-control text-center" name="39" numonly="float" data-bind="textInput: $root.getScore($element)" /></td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<thead class="bg-warning">
			<tr>
				<th colspan="3">ពិន្ទុរបស់អ្នកផ្តល់សេវា</th>
			</tr>
			<tr>
				<th>ផ្នែក</th>
				<th align="center" width="200">ចំនួនពិន្ទុដែលធ្វើបាន</th>
				<th align="center" width="200">ពិន្ទុ</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>ផ្នែកទី ១: ព័ត៌មានពីអ្នកផ្តល់សេវា</td>
				<td align="center" class="en">10</td>
				<td align="center" class="en" data-bind="text: $root.getPartScore('1')"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី ២: ចំណេះដឹងរបស់អ្នកផ្តល់សេវាអំពីជំងឺគ្រុនចាញ់</td>
				<td align="center" class="en">15</td>
				<td align="center" class="en" data-bind="text: $root.getPartScore('2')"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី ៣: លទ្ធភាពនៃការប្រឆាំងនឹងជំងឺគ្រុនចាញ់</td>
				<td align="center" class="en">40</td>
				<td align="center" class="en" data-bind="text: $root.getPartScore('3')"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី ៤: របាយការណ៍ និងឯកសារ</td>
				<td align="center" class="en">20</td>
				<td align="center" class="en" data-bind="text: $root.getPartScore('4')"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី ៥: ការវាយតម្លៃនៅកន្លែងធ្វើការ</td>
				<td align="center" class="en">10</td>
				<td align="center" class="en" data-bind="text: $root.getPartScore('5')"></td>
			</tr>
			<tr>
				<td>ផ្នែកទី ៦: ការយល់ដឹងរបស់អ្នកផ្តល់សេវាលើកម្មវិធី PPM</td>
				<td align="center" class="en">5</td>
				<td align="center" class="en" data-bind="text: $root.getPartScore('6')"></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th>សរុប ពិន្ទុ</th>
				<th align="center" class="en">100</th>
				<th align="center" class="en" data-bind="text: $root.getTotalScore()"></th>
			</tr>
		</tfoot>
	</table>
</div>

<?=latestJs('/media/ViewModel/Checklist_CMEP_PPM.js')?>