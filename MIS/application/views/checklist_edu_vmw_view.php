<div class="kh divcenter" data-bind="visible: view() == 'detail'">
	<h3 class="text-center">សំណួរសំរាប់អភិបាលអ្នកស្ម័គ្រចិត្តភូមិស្តីពីការងារអប់រំសុខភាពជំងឺគ្រុនចាញ់</h3>
	<br />

	<div class="form-inline" style="border:2px solid; padding:10px" data-bind="with: masterModel">
		<p>
			<span>ខេត្ត</span>
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

			<span class="space">ភូមិ</span>
			<select data-bind="value: Code_Vill_T,
					options: vlList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>
		</p>
		<p class="relative en">
			<kh>ថ្ងៃចុះអភិបាល</kh>
			<input type="text" data-bind="datePicker: VisitDate" class="form-control width150 text-center" placeholder="DD-MM-YYYY" />

			<kh class="space">លេខបេសកកម្ម</kh>
			<input type="text" class="form-control en" min="0"
               oninput="this.value = this.value.replace(/[^0-9-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-bind="value: MissionNo" />
		</p>
		<p>
			<span>ឈ្មោះអ្នកអភិបាល</span>
			<input type="text" class="form-control" data-bind="value: VisitorName" />

			<span class="space">តួនាទី</span>
			<input type="text" class="form-control" data-bind="value: VisitorPosition" />

			<span class="space">ទីកន្លែងធ្វើការ</span>
			<select class="form-control kh" data-bind="value: VisitorWorkplace">
				<option></option>
				<option value="CNM">ម.គ.ច</option>
				<option value="PHD">មន្ទីរសុខាភិបាលខេត្ត</option>
				<option value="OD">ស្រុកប្រតិបត្តិ</option>
				<option value="HC">មណ្ឌលសុខភាព</option>
			</select>
		</p>
		<p>
			<span>ឈ្មោះអ្នកស្ម័គ្រចិត្តភូមិ</span>
			<input type="text" class="form-control" data-bind="value: VMWName" />

			<span class="space">ភេទ</span>
			<select class="form-control kh" data-bind="value: VMWSex">
				<option value="M">ប្រុស</option>
				<option value="F">ស្រី</option>
			</select>
			
			<span class="space">លេខទូរស័ព្ទ</span>
			<input type="text" class="form-control en" data-bind="value: VMWPhone" />
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

	<div class="form-inline" data-bind="with: detailModel">
		<p>
			<span>១. តើខែមុនអ្នកបានចូលរួមប្រជុំដែរឫទេ?</span>
			<select class="form-control kh" data-bind="value: Q1.meeting">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>

			<span class="space">បើមិនបានធ្វើតើមូលហេតុអ្វី?</span>
			<select class="form-control kh" data-bind="value: Q1.reason">
				<option></option>
				<option>រវល់ផ្ទាល់ខ្លួន/គ្រួសារ</option>
				<option>រវល់ធ្វើស្រែចំការ</option>
				<option>ទៅព្រៃ</option>
				<option>ធ្វើចំណាកស្រុក</option>
				<option>ធ្វើចំណាកស្រុកក្រៅប្រទេស</option>
			</select>
		</p>
		<p>
			<span>២. តើអ្នកបានធ្វើការអប់រំសុខភាពជូនដល់ប្រជាជនដែរឫទេក្នុងខែមុន?</span>
			<select class="form-control kh" data-bind="value: Q2">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>

			<span class="space">មិនបានសុំរំលងទៅសំណួរទី៤</span>
		</p>
		<p>
			<span>៣. បើបានតើអ្នកធ្វើបានប៉ុន្មានដងក្នុងខែមុន?</span>
			<span class="input-group">
				<input type="text" data-bind="value: Q3.times" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">ដង</span>
			</span>

			<span class="space">ចំនួនអ្នកចូលរួម</span>
			<span class="input-group">
				<input type="text" data-bind="value: Q3.participant" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>

			<span class="space">ស្រី</span>
			<span class="input-group">
				<input type="text" data-bind="value: Q3.female" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>
		</p>
		<p>
			<span>៤. តើអ្នកធ្វើអប់រំសុខភាពតាមវិធីណា?</span>
			<select class="form-control kh" data-bind="value: Q4.how">
				<option></option>
				<option>ជាក្រុមតូច</option>
				<option>ជាសមូហភាព</option>
				<option>ជាបុគ្គល</option>
			</select>

			<span class="space">បើមិនបានធ្វើតើមូលហេតុអ្វី?</span>
			<select class="form-control kh" data-bind="value: Q4.reason">
				<option></option>
				<option>រវល់ផ្ទាល់ខ្លួន/គ្រួសារ</option>
				<option>រវល់ធ្វើស្រែចំការ</option>
				<option>ទៅព្រៃ</option>
				<option>ធ្វើចំណាកស្រុក</option>
				<option>ធ្វើចំណាកស្រុកក្រៅប្រទេស</option>
			</select>
		</p>
		<p>
			<span>៥. តើអ្នកធ្លាប់ទទួលបានសំភារៈអប់រំសុខភាពដែរឫទេ?</span>
			<select class="form-control kh" data-bind="value: Q5">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p>៦. តើសំភារៈអប់រំសុខភាពអ្វីខ្លះដែលអ្នកបានទទួល?</p>
		<p style="padding-left:30px">
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="សារសម្លេង" data-bind="checked: Q6" />
				<span>សារសម្លេង</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="វីដេអូ" data-bind="checked: Q6" />
				<span>វីដេអូ</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="ផ្ទាំងរូបភាព" data-bind="checked: Q6" />
				<span>ផ្ទាំងរូបភាព</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="អាវភ្លៀង" data-bind="checked: Q6" />
				<span>អាវភ្លៀង</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="កញ្ចប់ចូលព្រៃ" data-bind="checked: Q6" />
				<span>កញ្ចប់ចូលព្រៃ</span>
			</label>
		</p>
		<p style="padding-left:30px">
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="រូបភាពសន្លឹកបត់" data-bind="checked: Q6" />
				<span>រូបភាពសន្លឹកបត់</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="រូបភាពសន្លឹកផ្ទាត់" data-bind="checked: Q6" />
				<span>រូបភាពសន្លឹកផ្ទាត់</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="អាវយឺត" data-bind="checked: Q6" />
				<span>អាវយឺត</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="មួក" data-bind="checked: Q6" />
				<span>មួក</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="ប្រតិទិន" data-bind="checked: Q6" />
				<span>ប្រតិទិន</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q6" value="បដា" data-bind="checked: Q6" />
				<span>បដា</span>
			</label>
		</p>
		<p>
			<span>៧. តើអ្នកទទួលបានសំភារៈអប់រំពីអ្នកណា?</span>
			<select class="form-control kh" data-bind="value: Q7.who">
				<option></option>
				<option>មណ្ឌលសុខភាព</option>
				<option>អង្គការដៃគូ</option>
			</select>

			<span class="space">ឈ្មោះ</span>
			<input type="text" class="form-control" data-bind="value: Q7.name" />
		</p>
		<p>
			<span>៨. ក្នុងចំណោមសំភារៈទាំងអស់ខាងលើតើប្រភេទមួយណាដែលអ្នកចូលចិត្តប្រើបំផុត?</span>
			<select class="form-control kh" data-bind="value: Q8">
				<option></option>
				<option>សារសម្លេង</option>
				<option>វីដេអូ</option>
				<option>ផ្ទាំងរូបភាព</option>
				<option>អាវភ្លៀង</option>
				<option>កញ្ចប់ចូលព្រៃ</option>
				<option>រូបភាពសន្លឹកបត់</option>
				<option>រូបភាពសន្លឹកផ្ទាត់</option>
				<option>អាវយឺត</option>
				<option>មួក</option>
				<option>ប្រតិទិន</option>
				<option>បដា</option>
			</select>
		</p>
		<p>៩. តើសារអប់រំប្រភេទណាដែលអ្នកធ្លាប់យកមកអប់រំប្រជាជន?</p>
		<p style="padding-left:30px">
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q9" value="ការបង្ការ" data-bind="checked: Q9" />
				<span>ការបង្ការ</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q9" value="ការព្យបាល" data-bind="checked: Q9" />
				<span>ការព្យបាល</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q9" value="ការចម្លង" data-bind="checked: Q9" />
				<span>ការចម្លង</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q9" value="រោគសញ្ញា" data-bind="checked: Q9" />
				<span>រោគសញ្ញា</span>
			</label>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" name="Q9" value="ការថែរក្សាមុង/មុងអង្រឹង" data-bind="checked: Q9" />
				<span>ការថែរក្សាមុង/មុងអង្រឹង</span>
			</label>
		</p>
		<p>
			<span>១០. តើសព្វថ្ងៃជំងឺគ្រុនចាញ់ក្នុងភូមិអ្នកមានស្ថានភាពយ៉ាងណាដែរ?</span>
			<select class="form-control kh" data-bind="value: Q10">
				<option></option>
				<option>ថយចុះ</option>
				<option>កើនឡើង</option>
				<option>មានសញ្ញារាតត្បាត</option>
				<option>នៅដដែល</option>
			</select>
		</p>
		<p>
			<span>១១. តើកាលពីខែមុនអ្នកបានបញ្ជូនជំងឺគ្រុនចាញ់ទៅមណ្ឌលសុខភាពទេ?</span>
			<select class="form-control kh" data-bind="value: Q11.transfer">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>

			<span class="space">បើបានជាមេរោគប្រភេទអ្វី?</span>
			<select class="form-control kh" data-bind="value: Q11.virus">
				<option></option>
				<option>វ៉ីវាក់</option>
				<option>ហ្វាល់ស៊ីប៉ារ៉ូម</option>
				<option>ចម្រុះ</option>
			</select>
		</p>
		<p>១២. តើអ្នកជួបនិងបញ្ហាអ្វីខ្លះទេនៅពេលធ្វើការងារអប់រំសុខភាព?</p>
		<p style="padding-left:35px">
			<textarea class="form-control input-block" rows="5" data-bind="value: Q12" style="resize:none"></textarea>
		</p>
		<p>១៣. សំណូមពរ</p>
		<p style="padding-left:35px">
			<textarea class="form-control input-block" rows="5" data-bind="value: Q13" style="resize:none"></textarea>
		</p>

		<p>១៤. បញ្ហាដែលជួបប្រទះ</p>
		<p style="padding-left:35px">
			<textarea class="form-control input-block" rows="5" data-bind="value: Problem" style="resize:none"></textarea>
		</p>

		<p>១៥. ដំណោះស្រាយ</p>
		<p style="padding-left:35px">
			<textarea class="form-control input-block" rows="5" data-bind="value: Solution" style="resize:none"></textarea>
		</p>

	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_Edu_VMW.js')?>
