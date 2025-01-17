<style>
	.tblyellow { border:1px solid black; }
	.tblyellow > thead { background-color: yellow; }
	
	.tblyellow > thead > tr > th,
	.tblyellow > thead > tr > td,
	.tblyellow > tbody > tr > th,
	.tblyellow > tbody > tr > td { border:1px solid black !important; }
	
	textarea { resize:vertical; }
</style>

<div class="divcenter kh" data-bind="visible: view() == 'detail', with: masterModel">
	<h3 class="text-center text-primary">ទម្រង់របាយការណ៍អភិបាលកិច្ចសម្រាប់វាយតម្លៃគុណភាពមន្ទីរពិសោធន៍មីក្រូទស្សន៍គ្រុនចាញ់</h3>
	<br />

	<div class="text-bold">១.ព័ត៌មានទូទៅ</div>
	<div class="form-group form-inline">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">ខេត្ត</span>
				<select data-bind="value: Code_Prov_N,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh"></select>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">ស្រុកប្រតិបត្តិ</span>
				<select data-bind="value: Code_OD_T,
						options: odList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh"></select>
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">គ្រឹស្ថានសុខាភិបាល</span>
				<select data-bind="value: Code_Facility_T,
						options: hcList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh"></select>
			</div>
		</div>
	</div>
	<div class="form-group form-inline">
		<div class="input-group">
			<span class="input-group-addon">ប្រភេទគ្រឹស្ថាន</span>
			<select class="form-control" data-bind="value: FacilityType">
				<option></option>
				<option value="HC">មណ្ឌលសុខភាព</option>
				<option value="RH">មន្ទីរពេទ្យបង្អែក</option>
				<option value="PH">មន្ទីរពេទ្យខេត្ត</option>
				<option value="NH">មន្ទីរពេទ្យជាត់</option>
				<option value="Other">ផ្សេងៗទៀត</option>
			</select>
		</div>
	</div>
	<div class="form-group form-inline">
		<div class="input-group">
			<span class="input-group-addon">អាស័យដ្ឋានមន្ទីរពិសោធន៍</span>
			<span class="input-group-addon">ស្រុក</span>
			<select data-bind="value: Code_Dist_T,
					options: dsList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>
		</div>
	</div>
	<div class="form-group form-inline">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">លេខទូរស័ព្ទគ្រឹស្ថានសុខភាព</span>
				<input type="text" class="form-control en" data-bind="value: Phone" />
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">ហ្វាក់លេខ</span>
				<input type="text" class="form-control en" data-bind="value: Fax" />
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">អ៊ីម៉ែល</span>
				<input type="text" class="form-control en" data-bind="value: Email" />
			</div>
		</div>
	</div>
	<div class="form-group form-inline">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">ប្រធានមន្ទីរពិសោធន៍</span>
				<input type="text" class="form-control" data-bind="value: LaboDirector" />
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">ប្រធានមន្ទីរពេទ្យ</span>
				<input type="text" class="form-control" data-bind="value: HospitalDirector" />
			</div>
		</div>
	</div>
	<div class="form-group form-inline">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">បុគ្គលិកមន្ទីរពិសោធន៍ ទទួលសម្ភាសន៍</span>
				<input type="text" class="form-control" data-bind="value: Interviewee" />
			</div>
		</div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">អ្នកសម្ភាសន៍</span>
				<input type="text" class="form-control" data-bind="value: Interviewer" />
			</div>
		</div>
	</div>
	<div class="form-group form-inline">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">ឈ្មោះមន្ត្រីអភិបាល</span>
				<input type="text" class="form-control" data-bind="value: VisitorName" />
			</div>
		</div>
		<div class="form-group">
			<div class="input-group relative">
				<span class="input-group-addon">ថ្ងៃចុះអភិបាល</span>
				<input type="text" class="form-control text-center width120 en" data-bind="datePicker: VisitDate" />
			</div>
		</div>
	</div>
	<br />

	<div class="text-bold">២.អង្គភាព និងការគ្រប់គ្រង</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<td></td>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើអ្នកបច្ចេកទេសមន្ទីរពិសោធន៍បានចូលរួមវគ្គបណ្តុះបណ្តាលមីក្រូទស្សន៍ទៀងទាត់ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="2.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមន្ទីរពិសោធន៍ឯកជនមានអាជ្ញាបណ្ណ័ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="2.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានមីក្រូទស្សន៍សម្រាប់អនុវត្តក្នុងដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="2.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="2.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />

	<table class="table table-bordered tblyellow">
		<tbody>
			<tr>
				<td align="center" valign="middle" rowspan="2">អ្នកមីក្រូទស្សន៍បានទទួលវគ្គបណ្តុះបណ្តាល</td>
				<td align="center" valign="middle" rowspan="2">ចំនួនឆ្នាំធ្វើការក្នុងមន្ទីរពិសោធន៍</td>
				<td align="center" colspan="3" class="form-inline relative">
					<span>ថ្ងៃទទួលវគ្គបណ្តុះបណ្តាលចុងក្រោយ</span>
					<input type="text" name="2.4" class="form-control width100 text-center en" data-bind="datePicker: $root.getAnswer($element), dataType: 'string'" />
				</td>
				<td align="center" valign="middle" rowspan="2">កំណត់សម្គាល់</td>
			</tr>
			<tr>
				<td align="center">មូលដ្ឋានគ្រឹះមីក្រូទស្សន៍</td>
				<td align="center">វគ្គរំលឹក</td>
				<td align="center">វគ្គវាយតម្លៃជំនាញផ្ទៃក្នុង</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td><input type="text" class="form-control" name="2.4.1.A" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" class="form-control" name="2.4.1.B" data-bind="value: $root.getAnswer($element)" /></td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.1.C" value="Basic of microscopy" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.1.C" value="Refresher" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.1.C" value="Internal evaluation" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td><input type="text" class="form-control" name="2.4.1.D" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
			<tr>
				<td><input type="text" class="form-control" name="2.4.2.A" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" class="form-control" name="2.4.2.B" data-bind="value: $root.getAnswer($element)" /></td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.2.C" value="Basic of microscopy" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.2.C" value="Refresher" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.2.C" value="Internal evaluation" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td><input type="text" class="form-control" name="2.4.2.D" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
			<tr>
				<td><input type="text" class="form-control" name="2.4.3.A" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" class="form-control" name="2.4.3.B" data-bind="value: $root.getAnswer($element)" /></td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.3.C" value="Basic of microscopy" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.3.C" value="Refresher" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td align="center">
					<input type="radio" class="radio-lg" name="2.4.3.C" value="Internal evaluation" data-bind="checked: $root.getAnswer($element)" />
				</td>
				<td><input type="text" class="form-control" name="2.4.3.D" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">៣.ឯកសារមន្ទីរពិសោធន៍</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<td></td>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើមានបណ្ណ័វិភាគស្នើសុំធ្វើតេស្តឈាមដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="3.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើការកត់ត្រាក្នុងសៀវភៅមន្ទីរពិសោធន៍មានរបៀបត្រឹមត្រូវដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="3.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមាននិយាមប្រតិបត្តិ(SOPs)ដែលមានការទទួលស្គាល់ (ផ្លូវការ) ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="3.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានសៀវភៅបច្ចេកទេសមន្ទីរពិសោធន៍គ្រុនចាញ់ និងផ្ទាំងរូបភាពដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="3.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានបញ្ជីត្រួតពិនិត្យគុណភាពផ្ទៃក្នុងដែរឬទេ? (ការត្រួតពិនិត្យផ្ទៃក្នុងរវាងគ្នានិងគ្នា)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="3.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានសៀវភៅកត់ត្រាការថែទាំមីក្រូទស្សន៍ និងប្រដាប់វាស់pHដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="3.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមីក្រូទស្សន៍មានម៉ាកនិងលេខស៊េរីដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="3.7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="3.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">៤.និតិវិធី</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<th>៤.១.ការរៀបចំធ្វើភ្នាសឈាម</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើមាននិយាមប្រតិបត្តិ(SOPs)សម្រាប់ធ្វើភ្នាសឈាមដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.1.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានធ្វើផ្ទៃឈាមស្តើង និងផ្ទៃឈាមក្រាស់ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.1.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើបានកត់ត្រាលើកញ្ចក់ឈាមត្រឹមត្រូវដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.1.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានការតាមដានគុណភាពនៃការធ្វើភ្នាសឈាមដែរឬទេ? (ពុម្ពកញ្ចក់ឈាមគំរូ)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.1.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើកញ្ចក់ឈាមមិនទាន់បំពាក់ពណ៌ត្រូវបានការពារពីសត្វល្អិត និងការឡើងស្អិតជាប់ដោយឯង៊(Auto Fixation)ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.1.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.1.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th>៤.២.ការរៀបចំបំពាក់ពណ៌ភ្នាសឈាម</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើមាននិយាមប្រតិបត្តិ(SOPs)សម្រាប់បំពាក់ពណ៌កញ្ចក់ឈាមដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.2.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.2.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.2.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើបានធ្វើតាមនិតិវិធីបំពាក់ពណ៌ដែលមាននៅក្នុងសៀវភៅណែនាំដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.2.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.2.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.2.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើបានត្រួតពិនិត្យគុណភាពផ្ទៃក្នុងទៀងទាត់ចំពោះកញ្ចក់វិជ្ជមាន និងអវិជ្ជមានក្នុងពេលបំពាក់ពណ៌ហើយដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.2.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.2.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.2.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">
					<div>តើបានប្រើបច្ចេកទេសបំពាក់ពណ៌ដោយអ្វី?</div>
					<div class="form-inline">
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="4.2.4.A" value="បំពាក់ពណ៌ហ្សីមសារ" data-bind="checked: $root.getAnswer($element)" />
								<span>បំពាក់ពណ៌ហ្សីមសារ</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg space">
							<label>
								<input type="checkbox" name="4.2.4.A" value="ប្រតិករផ្សេងៗទៀត" data-bind="checked: $root.getAnswer($element)" />
								<span>ប្រតិករផ្សេងៗទៀត (កញ្ចក់)</span>
							</label>
						</div>
						<input type="text" class="form-control" name="4.2.4.B" data-bind="value: $root.getAnswer($element)" />
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.2.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.2.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.2.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th>៤.៣.សម្រាប់បច្ចេកទេសប្រើហ្សីមសារ</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើមានប្រើទឹកមាន pH 7.2 ± 0.2 ដោយថ្នាំបាសហ្វឺយកទៅលាយហ្សីមសារដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.3.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.3.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.3.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើសូលុយស្យុងហ្សីមសារសម្រាប់ប្រើប្រាស់ត្រូវបានលាយភ្លាមៗ (&lt;១៥នាទី) មុនបំពាក់ពណ៌ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.3.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.3.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.3.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th>៤.៤.ការពិនិត្យរកប៉ារ៉ាស៊ីតលើកញ្ចក់ឈាម</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើមាននិយាមប្រតិបត្តិ(SOPs)សម្រាប់ពិនិត្យរកប៉ារ៉ាស៊ីតលើភ្នាសឈាម ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.4.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើអ្នកមីក្រូទស្សន៍បានរាយការណ៍វត្តមាន ឬអវត្តមានប៉ារ៉ាស៊ីត ប្រភេទប៉ារ៉ាស៊ីត និងចំនួនប៉ារ៉ាស៊ីតដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.4.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើអ្នកពិនិត្យមីក្រូទស្សន៍ប្រើពេល១០នាទីសម្រាប់១កញ្ចក់ឈាមដូចការណែនាំដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.4.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើកញ្ចក់ឈាមពិនិត្យរួចត្រូវបានទុកដាក់ថែរក្សាត្រឹមត្រូវដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.4.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យជាមធ្យមក្នុង១ខែ:</span>
					<div class="input-group">
						<input type="text" name="4.4.5.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">កញ្ចក់</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.4.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យជាមធ្យមក្នុង១ថ្ងៃ(តំបន់ចម្លងខ្ពស់):</span>
					<div class="input-group">
						<input type="text" name="4.4.6.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">កញ្ចក់</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.4.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យជាមធ្យមក្នុង១ថ្ងៃសម្រាប់អ្នកមីក្រូទស្សន៍១នាក់(តំបន់ចម្លងខ្ពស់):</span>
					<div class="input-group">
						<input type="text" name="4.4.7.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">កញ្ចក់</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.4.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យដែលបានរក្សាទុក ឬបានត្រួតពិនិត្យ ដោយអ្នកវាយតម្លៃ:</span>
					<div class="input-group">
						<input type="text" name="4.4.8.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">កញ្ចក់</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.8" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="4.4.8" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="4.4.8.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">៥.ការវាយតម្លៃអំពីកម្រិតជំនាញ</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<th>៥.១.ការពិនិ្យកញ្ចក់ឈាម និងការពិនិត្យរកប៉ារ៉ាស៊ីត (Cross-Checking)</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ចំនួនកញ្ចក់ឈាមបានពិនិត្យរកប៉ារ៉ាស៊ីតដោយអ្នកវាយតម្លៃ:</span>
					<div class="input-group">
						<input type="text" name="5.1.1.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">កញ្ចក់</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ភាពត្រូវគ្នានៃការរកឃើញវត្តមានប៉ារ៉ាស៊ីតគិតជា(%):</span>
					<div class="input-group">
						<input type="text" name="5.1.2.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>វិជ្ជមានមិនពិត(%):</span>
					<div class="input-group">
						<input type="text" name="5.1.3.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>អវិជ្ជមានមិនពិត(%):</span>
					<div class="input-group">
						<input type="text" name="5.1.4.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ចំនួនកញ្ចក់ឈាមវិជ្ជមានពិត:</span>
					<div class="input-group">
						<input type="text" name="5.1.5.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ភាពត្រូវគ្នានៃការរកឃើញប្រភេទប៉ារ៉ាស៊ីតគិតជា(%):</span>
					<div class="input-group">
						<input type="text" name="5.1.6.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ភាពត្រូវគ្នានៃកម្រិតដង់ស៊ីតេប៉ារ៉ាស៊ីតគិតជា(%):</span>
					<div class="input-group">
						<input type="text" name="5.1.7.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ផ្ទៃឈាមក្រាស់មានគុណភាពមិនល្អ(ទំហំ រូបរាង បរិមាណឈាម)គិតជា(%):</span>
					<div class="input-group">
						<input type="text" name="5.1.8.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.8" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.8" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.8.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ផ្ទៃឈាមស្តើងមានគុណភាពមិនល្អ(ទំហំ រូបរាង បរិមាណឈាម)គិតជា(%):</span>
					<div class="input-group">
						<input type="text" name="5.1.9.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.9" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.9" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.9.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ភាគរយនៃការបំពាក់ពណ៌ផ្ទៃឈាមមានគុណភាពមិនល្អ:</span>
					<div class="input-group">
						<input type="text" name="5.1.10.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.10" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.10" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.10.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ភាគរយនៃផ្ទៃឈាមកកកំណកពណ៌និងកំទេចកំទី(Stain Precipitate or Artefacts)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.11" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.11" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.11.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle" class="form-inline">
					<span>ភាគរយនៃផ្ទៃឈាមក្រាស់ស្អិត(Slides Auto-fixed)គិតជា(%):</span>
					<div class="input-group">
						<input type="text" name="5.1.12.A" class="form-control width100 text-center" data-bind="value: $root.getAnswer($element)" />
						<span class="input-group-addon">%</span>
					</div>
				</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.12" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="5.1.12" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="5.1.12.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>

	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<th colspan="7">៥.២.កញ្ចក់ឈាមគំរូផ្តល់ដោយអ្នកអភិបាលឱ្យអ្នកមន្ទីរពិសោធន៍ពិនិត្យរកប៉ារ៉ាស៊ីត</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td rowspan="2"></td>
				<td colspan="5" align="center">អ្នកមីក្រូទស្សន៍</td>
				<td rowspan="2" align="center" valign="middle">កំណត់សម្គាល់</td>
			</tr>
			<tr>
				<td align="center" width="100">១</td>
				<td align="center" width="100">២</td>
				<td align="center" width="100">៣</td>
				<td align="center" width="100">៤</td>
				<td align="center" width="100">៥</td>
			</tr>
			<tr>
				<td valign="middle">ចំនួនកញ្ចក់ឈាមបានពិនិ្យរកប៉ារ៉ាស៊ីត</td>
				<td><input type="text" name="5.2.1.A" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.1.B" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.1.C" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.1.D" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.1.E" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.1.Note" class="form-control" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
			<tr>
				<td valign="middle">ភាពត្រូវគ្នានៃការរកឃើញប៉ារ៉ាស៊ីតគិតជា(%)</td>
				<td><input type="text" name="5.2.2.A" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.2.B" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.2.C" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.2.D" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.2.E" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.2.Note" class="form-control" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
			<tr>
				<td valign="middle">វិជ្ជមានមិនពិតគិតជា(%)</td>
				<td><input type="text" name="5.2.3.A" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.3.B" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.3.C" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.3.D" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.3.E" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.3.Note" class="form-control" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
			<tr>
				<td valign="middle">អវិជ្ជមានមិនពិតគិតជា(%)</td>
				<td><input type="text" name="5.2.4.A" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.4.B" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.4.C" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.4.D" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.4.E" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.4.Note" class="form-control" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
			<tr>
				<td valign="middle">ភាពត្រូវគ្នានៃការរកឃើញប្រភេទប៉ារ៉ាស៊ីតគិតជា(%)</td>
				<td><input type="text" name="5.2.5.A" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.5.B" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.5.C" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.5.D" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.5.E" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.5.Note" class="form-control" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
			<tr>
				<td valign="middle">ភាពត្រូវគ្នានៃកម្រិតដង់ស៊ីតេប៉ារ៉ាស៊ីតគិតជា(%)</td>
				<td><input type="text" name="5.2.6.A" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.6.B" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.6.C" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.6.D" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.6.E" class="form-control text-center" data-bind="value: $root.getAnswer($element)" /></td>
				<td><input type="text" name="5.2.6.Note" class="form-control" data-bind="value: $root.getAnswer($element)" /></td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">៦.ការត្រួតពិនិត្យិ និងធានាគុណភាព</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<th width="800"></th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើមន្ទីរពិសោធន៍អនុវត្តតាមមគ្គុទេសក៍ជាតិស្តីអំពីការត្រួតពិនិត្យ និងធានាគុណភាពពេញលេញដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="6.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានមគ្គុទេសក៍ផ្លូវការសម្រាប់វិភាគលទ្ធផលត្រួតពិនិត្យគុណភាពផ្ទៃក្នុង និងបានកែតម្រូវចំណុចខ្វះខាតដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="6.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍មីក្រូទស្សន៍នេះដែលបានចូលរួមជាទៀងទាត់នៅក្នុងគ្រោងការសាកល្បងសមត្ថភាព(Proficiency testing)ឬទម្រង់ដទៃទៀតនៃQAដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="6.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើការអនុវត្តរបស់មន្ទីរពិសោធន៍មីក្រូទស្សន៍នេះក្នុងគម្រោងធ្វើតេស្តសមត្ថភាព(Proficiency testing)ឬទម្រង់ផ្សេងទៀតនៃការវាយតម្លៃគុណភាពខាងក្រៅមានភាពល្អប្រសើរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="6.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមន្ទីរពិសោធន៍នេះមាននីតិវិធីដើម្បីដោះស្រាយការអនុវត្តមិនល្អនៅក្នុងការធ្វើតេស្តសមត្ថភាព(Proficiency testing)ឬទម្រង់ផ្សេងទៀតនៃការវាយតម្លៃគុណភាពខាងក្រៅ(EQA)ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="6.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="6.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">៧.ការរៀបចំបន្ទប់មន្ទីរពិសោធន៍ និងបរិស្ថានជុំវិញ</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<th width="800"></th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">ទីធ្លាសម្រាប់រៀបចំកញ្ចក់ឈាម (Bench Space)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.1" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.1" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ឡាវាបូសម្រាប់បំពាក់ពណ៌ និងលាងសម្អាតកញ្ចក់ឈាម</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.2" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.2" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានប្រព័ន្ធទឹកស្អាតប្រើប្រាស់</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.3" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.3" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានពន្លឺគ្រប់គ្រាន់</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.4" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.4" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានប្រព័ន្ធអគ្គីសនីប្រើប្រាស់</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.5" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.5" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានចរន្តខ្យល់ចេញចូលគ្រប់គ្រាន់</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.6" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.6" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានប្រព័ន្ធថែរក្សា និងទុកដាក់ឧបករណ៍ សម្ភារៈប្រើប្រាស់ត្រឹមត្រូវ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.7" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.7" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ទីកន្លែងទុកដាក់កញ្ចក់ឈាមមិនទាន់បំពាក់ពណ៌ និងកញ្ចក់ឈាមបានពិនិត្យរួច</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.8" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.8" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.8.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ទីតាំងទុកដាក់លទ្ធផលអ្នកជម្ងឹ និងរក្សាការសម្ងាត់</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.9" value="Good" data-bind="checked: $root.getAnswer($element)" />
							<span>ល្អ</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="7.9" value="Bad" data-bind="checked: $root.getAnswer($element)" />
							<span>មិនល្អ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="7.9.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">៨.សុវត្ថិភាបជីវសាស្ត្រ</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<th width="800"></th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍បានពាក់អាវពេទ្យ និងវ៉ែនតាការពារដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍បានពាក់ស្រោមដៃដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍រៀបចំទុកដាក់សំណាកឈាមបានល្អដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើអ្នកមន្ទីរពិសោធន៍មានសាប៊ូលាងដៃដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានប្រព័ន្ធអគ្គីសនីសម្រាប់មីក្រូទស្សន៍ និងសម្រាប់មន្ទីរពិសោធន៍ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានធុងសម្រាមសម្រាប់ដាក់កាកសំណល់ស្ងួតដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានធុងដាក់កាកសំណល់អាចឆ្លងរោគដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានធុងដាក់កាកសំណល់មុងស្រួចដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.8" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.8" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.8.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានធុងដាក់កាកសំណល់តាមសេចក្តីណែនាំថ្នាក់ជាតិដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.9" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.9" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.9.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ការបំផ្លាញកាកសំណល់តាមគោលការណ៍ណែនាំថ្នាក់ជាតិដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.10" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="8.10" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="8.10.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">៩.ឧបករណ៍ និងប្រតិករ</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<th width="800">៩.១.មីក្រូទស្សន៍</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើមីក្រូទស្សន៍ភ្នែកពីរមានកែវពង្រីកលេខ១០០អាចប្រើនិងប្រេងពង្រីកដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.1.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមីក្រូទស្សន៍មានអំពូលភ្លើងអាចផ្តល់ពន្លឺគ្រប់គ្រាន់ឱ្យមានរូបភាពច្បាស់នៅពេលដាក់កែវពង្រីកលេខ១០០ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.1.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើបញ្ចក់ឈាមអាចតម្រង់រូបភាពច្បាស់នៅពេលដាក់កែវពង្រីកលេខ១០០ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.1.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ការរំកិលទម្រកញ្ចក់ឈាមអាចតម្រង់រូបភាពច្បាស់និងមានលំនឹង</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.1.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមីក្រូទស្សន៍ត្រូវបានដាក់លើទីតាំងមានលំនឹង និងមានកន្លែងទូលាយសមស្របនៅឆ្ងាយពីទីតាំងបំពាក់ពណ៌និងម៉ាស៊ីនរំញ័រ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.1.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មីក្រូទស្សន៍ត្រូវបានប្រើប្រាស់ទៀងទាត់ប្រចាំថ្ងៃដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.1.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មីក្រូទស្សន៍ត្រូវសំអាត និងការពារដោយគម្របដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.1.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើមានអំពូលភ្លើងមីក្រូទស្សន៍បម្រុងដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.8" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.1.8" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.1.8.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th>៩.២.កញ្ចក់ឈាមមីក្រូទស្សន៍</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">តើកញ្ចក់ឈាមត្រូវបានជូតសម្អាតម៉ត់ចត់មុនយកមកប្រើដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.2.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើកញ្ចក់ឈាមមិនមានស្នាមឆូតដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.2.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើកញ្ចក់ឈាមមិនមានឡើងពណ៌ខៀវជាប់កញ្ចក់ក្រោយបំពាក់ពណ៌ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.2.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើកញ្ចក់ឈាមមិនមានដុះផ្សិតដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.2.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">តើកញ្ចក់ឈាមមានដុះផ្សិតត្រូវបានបោះចោលមិនយកមកប្រើទៀតដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.2.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">នៅតំបន់មានសំណើមខ្ពស់កញ្ចក់ឈាមត្រូវបានការពារមិនឱ្យមានដុះផ្សិតដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.2.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">កញ្ចក់ឈាមត្រូវបានយកមកប្រើច្រើនដងដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.2.7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.2.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th>៩.៣.ប្រតិករសម្រាប់បំពាក់ពណ៌</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">មានគ្រប់ប្រតិករសម្រាប់បំពាក់ពណ៌ចាំបាច់ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានប្រតិករសម្រាប់បំពាក់ពណ៌ផុតកាលបរិច្ឆេទប្រើប្រាស់ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានសូលុយស្យុង ឬប្រតិករសម្រាប់បំពាក់ពណ៌បានទុកដាក់ត្រឹមត្រូវតាមការណែនាំរបស់រោងចក្រដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មាននិយាមប្រតិបត្តិ(SOPs)សម្រាប់លាយសូលុយស្យុងប្រតិករសម្រាប់បំពាក់ពណ៌ដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មានពិធីសារត្រួតពិនិត្យគុណភាពផ្ទៃក្នុងសម្រាប់លាយសូលុស្យុងប្រតិករបំពាក់ពណ៌ម្តងៗដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ការលាយល្បាយសូលុយស្យុងសម្រាប់បំពាក់ពណ៌ត្រឹមត្រូវតាមស្តង់ដាដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">កម្របដបប្រតិករបិទជិតល្អ លើកលែងតែបានបើកប្រើហើយមែនដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ប្រតិករបំពាក់ពណ៌ជានិច្ចកាលត្រូវបឺតចេញពីដបដោយពីប៉ែតស្អាតដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.8" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.8" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.8.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មិនត្រូវបន្ថែមទឹកទៅក្នុងដបរក្សាប្រតិករបំពាក់ពណ៌ឡើយមែនដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.9" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.9" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.9.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ប្រតិករបំពាក់ពណ៌យកចេញពីដបមិនត្រូវដាក់ចូលវិញឡើយមែនដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.10" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.3.10" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.3.10.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th>៩.៤.សម្ភារៈទូទៅផ្គត់ផ្គង់ដល់មន្ទីរពិសោធន៍</th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">មានអាល់កុល និងសំឡីសម្រាប់សម្អាតស្បែកអ្នកជម្ងឺមុនបូមឈាមឬជោះម្រាមដៃដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ម្ជុលជោះឈាម(Lancets)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">មេតាណុល</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ហ្ស៊ីមសារ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">គ្រាប់ថ្នាំបាសហ្វឺ សម្រាប់លាយកម្រិតpHទឹក</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ម៉ែត្រវាស់កម្រិតpH ឬក្រដាសpH</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ល្បាយសូលុយស្យុងមានកម្រិតpHត្រឹមត្រូវ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.7" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.7.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ក្រឡ ឬចានសម្រាប់បំពាក់ពណ៍</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.8" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.8" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.8.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">អំពូលភ្លើងមីក្រូទស្សន៍</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.9" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.9" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.9.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ធុងដាក់កាកសំណល់មុតស្រួច</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.10" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.10" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.10.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ខ្មៅដៃ ប៊ិចក្រហម វ៉ែនតាសម្រាប់សរសេរ(Glass-Writing)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.11" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.11" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.11.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">អាវមន្ទីរពិសោធន៍</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.12" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.12" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.12.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ស្រោមដៃ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.13" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.13" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.13.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ទឹកលាងកែវពង្រីក ក្រដាសជូតកែវពង្រីក</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.14" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.14" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.14.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ប៊ិចដិតជាប់</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.15" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.15" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.15.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">វ៉ែនតាការពារ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.16" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.16" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.16.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ម្ជុលនិងស៊ីរាំង</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.17" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.17" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.17.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ម្ជុលវ៉ាក់ក្យូបឺតឈាម</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.18" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.18" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.18.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">កំណត់សម្គាល់កញ្ចក់ឈាម</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.19" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.19" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.19.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ឡាម៉ែល</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.20" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.20" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.20.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">Mounting medium</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.21" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.21" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.21.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ខ្សែរឺតដៃ(Tourniquet)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.22" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.22" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.22.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">បង់បិតស្នាមចាក់ថ្នាំ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.23" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.23" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.23.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ទម្របំពាក់ពណ៌(Staining rack)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.24" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.24" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.24.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ទម្របំពាក់ពណ៌</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.25" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.25" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.25.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ស៊ីឡាំងមានក្រិតទំហំត្រឹមត្រូវ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.26" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.26" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.26.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">Wash bottles (ដបទទេ)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.27" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.27" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.27.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">នាឡិកា</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.28" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.28" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.28.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ប្រេងពង្រីកមានគុណភាព</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.29" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.29" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.29.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ប្រដាប់រាប់ប៉ារ៉ាស៊ីត(Tally Counters)</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.30" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.30" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.30.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ប្រអប់ដាក់កញ្ចក់ឈាមរក្សាទុក</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.31" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.31" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.31.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">សម្រាប់មន្ទីរពិសោធន៍ដែលពណ៌លាយពីម្សៅ ត្រូវមាន អ្លឺសេរ៉ូល មេតាណុល ម៉្សៅ និង (Beakers) ស៊ីឡាំងមានក្រិត ក្រដាសច្រោះ ជណ្ជីងនិង Funnels, Stirring rods, Spatulas and Storage bottles</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.32" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="9.4.32" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="9.4.32.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">១០.សូចនាករ បំពេញមុខងារ (Performance Indicators)</div>
	<table class="table table-bordered tblyellow">
		<thead>
			<tr>
				<th width="800"></th>
				<td></td>
				<td align="center">កំណត់សម្គាល់</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td valign="middle">ចំនួនកញ្ចក់ឈាមបានពិនិត្យរកប៉ារ៉ាស៊ីត</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.1" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="10.1.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ចំនួនកញ្ចក់ឈាមវិជ្ជមាន</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.2" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="10.2.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">បែងចែកតាមប្រភេទប៉ារ៉ាស៊ីត</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.3" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="10.3.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ការប្រើប្រាស់សម្ភារៈផ្សេងៗក្នុងមន្ទីរពិសោធន៍</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.4" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="10.4.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ការដាច់ស្តុក ប្រតិករមីក្រូទស្សន៍ប្រចាំខែ</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.5" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="10.5.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
			<tr>
				<td valign="middle">ការផ្តល់លទ្ធផលវិភាគរបស់អ្នកពិនិត្យមីក្រូទស្សន៍ទាន់ពេលដែរឬទេ?</td>
				<td valign="middle">
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
							<span>បាទ/ចាស</span>
						</label>
					</div>
					<div class="radio-inline radio-lg">
						<label>
							<input type="radio" name="10.6" value="No" data-bind="checked: $root.getAnswer($element)" />
							<span>ទេ</span>
						</label>
					</div>
				</td>
				<td>
					<input type="text" class="form-control" name="10.6.Note" data-bind="value: $root.getAnswer($element)" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />

	<div class="text-bold">ការរកឃើញទូទៅ និងអនុសាសន៍</div>
	<textarea class="form-control" rows="20" name="11" data-bind="value: $root.getAnswer($element)"></textarea>
</div>

<?=latestJs('/media/ViewModel/Checklist_CMEP_Microscopy.js')?>