<div style="width:800px" data-bind="visible: view() == 'detail', with: detailModel">
	<div class="text-center text-bold">Form: Active Case Detection Form</div>
	<br />
	<div class="kh">
		<div class="form-group">
			<span>ខេត្ត</span>
			<input type="text" class="width150" data-bind="value: $root.getProvName(Code_Prov_T()), click: $parent.choosePlace" />
			<span class="space">ស្រុកប្រតិបត្ត</span>
			<input type="text" class="width150" data-bind="value: $root.getODName(Code_OD_T()), click: $parent.choosePlace" />
		</div>
		<div class="form-group">
			<span>មណ្ឌលសុខភាព</span>
			<input type="text" class="width150" data-bind="value: $root.getHCName(Code_Facility_T()), click: $parent.choosePlace" />
			<span class="space">ភូមិ</span>
			<input type="text" class="width150" data-bind="value: $root.getVillName(Code_Vill_T()), click: $parent.choosePlace" />
		</div>
		<ol>
			<li>
				<span>ក្រុមការងារគួរតែកំណត់ទីតាំង ២-៣ នៅជិតភូមិដើម្បីធ្វើការជួសឈាម:</span>
				<ol type="a">
					<li>
						<span>ឈ្មោះទីតាំងទី១</span>
						<input type="text" class="width150" data-bind="value: Q1aName" />
						<span class="space">Latitude</span>
						<input type="text" class="width150 numonly" data-type="float" data-bind="value: Q1aLat" />
						<span class="space">Longitude</span>
						<input type="text" class="width150 numonly" data-type="float" data-bind="value: Q1aLong" />
					</li>
					<li>
						<span>ឈ្មោះទីតាំងទី២</span>
						<input type="text" class="width150" data-bind="value: Q1bName" />
						<span class="space">Latitude</span>
						<input type="text" class="width150 numonly" data-type="float" data-bind="value: Q1bLat" />
						<span class="space">Longitude</span>
						<input type="text" class="width150 numonly" data-type="float" data-bind="value: Q1bLong" />
					</li>
					<li>
						<span>ឈ្មោះទីតាំងទី៣</span>
						<input type="text" class="width150" data-bind="value: Q1cName" />
						<span class="space">Latitude</span>
						<input type="text" class="width150 numonly" data-type="float" data-bind="value: Q1cLat" />
						<span class="space">Longitude</span>
						<input type="text" class="width150 numonly" data-type="float" data-bind="value: Q1cLong" />
					</li>
				</ol>
				<br />
			</li>
			<li>
				<span>MMW គួរតែបំពេញព័ត៌មានដូចខាងក្រោមសម្រាប់ការធ្វើការជួសឈាមនីមួយៗ។ ជួសឈាមតែមនុស្សមានគ្រោះថ្នាក់ប៉ុណ្ណោះ។ ទាំងនេះរួមបញ្ចូលទាំងអ្នកដែលទៅរកតំបន់ដែលមានហានិភ័យខ្ពស់នៅជិតព្រៃឈើ និងអ្នកដែលមានគ្រុនក្តៅ។</span>
				<ol type="a">
					<li>
						<span>ឈ្មោះទីតាំងទី១</span> <a name="L1" data-bind="click: $root.addCases" class="btn btn-primary btn-xs">Location 1 Cases</a>
						<ul>
							<li>
								<span>ចំនួនអ្នកដើរព្រៃ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2aForest" />
							</li>
							<li>
								<span>ចំនួនអ្នកគ្រុនក្តៅ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2aFever" />
							</li>
							<li>
								<span>ចំនួនអ្នកបានធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2aTested" />
							</li>
							<li>
								<span>ចំនួនករណីវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2aPositive" />
							</li>
							<li>
								<span>ចំនួនករណីអវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2aNegative" />
							</li>
							<li>
								<span>ចំនួនអ្នកមិនព្រមធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2aRefused" />
							</li>
						</ul>
						<br />
					</li>
					<li>
						<span>ឈ្មោះទីតាំងទី២</span> <a name="L2" data-bind="click: $root.addCases" class="btn btn-primary btn-xs">Location 2 Cases</a>
						<ul>
							<li>
								<span>ចំនួនអ្នកដើរព្រៃ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2bForest" />
							</li>
							<li>
								<span>ចំនួនអ្នកគ្រុនក្តៅ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2bFever" />
							</li>
							<li>
								<span>ចំនួនអ្នកបានធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2bTested" />
							</li>
							<li>
								<span>ចំនួនករណីវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2bPositive" />
							</li>
							<li>
								<span>ចំនួនករណីអវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2bNegative" />
							</li>
							<li>
								<span>ចំនួនអ្នកមិនព្រមធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2bRefused" />
							</li>
						</ul>
						<br />
					</li>
					<li>
						<span>ឈ្មោះទីតាំងទី៣</span> <a name="L3" data-bind="click: $root.addCases" class="btn btn-primary btn-xs">Location 3 Cases</a>
						<ul>
							<li>
								<span>ចំនួនអ្នកដើរព្រៃ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2cForest" />
							</li>
							<li>
								<span>ចំនួនអ្នកគ្រុនក្តៅ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2cFever" />
							</li>
							<li>
								<span>ចំនួនអ្នកបានធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2cTested" />
							</li>
							<li>
								<span>ចំនួនករណីវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2cPositive" />
							</li>
							<li>
								<span>ចំនួនករណីអវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2cNegative" />
							</li>
							<li>
								<span>ចំនួនអ្នកមិនព្រមធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: Q2cRefused" />
							</li>
						</ul>
					</li>
				</ol>
			</li>
		</ol>
	</div>

	<br /><br />
	<div class="text-center text-bold">Form: MMP Questionnaire (To be given by HC Only)</div>
	<br />

	<div class="kh">
		<div class="form-group">
			<span>មណ្ឌលសុខភាព MMW</span>
			<input type="text" class="width150" data-bind="value: $root.getHCName(HFMMW()), click: $parent.chooseMMW" />
			<span class="space kh">ភូមិ MMW</span>
			<input type="text" class="width150" data-bind="value: $root.getVillName(VillMMW()), click: $parent.chooseMMW" />
		</div>
		<div class="form-group">
			<span>ឈ្មោះ</span>
			<input type="text" class="width150" data-bind="value: Name" />
			<span class="space">លេខទូរសព្ទ</span>
			<input type="text" class="width150 numonly" data-type="int" data-bind="value: Phone" />
			<span class="space">អាយុ</span>
			<input type="text" class="width100 numonly" data-type="int" maxlength="2" data-bind="value: Age" />
			<span class="space">ភេទ</span>
			<select class="width100" data-bind="value: Sex">
				<option value=""></option>
				<option value="Male">ប្រុស</option>
				<option value="Female">ស្រី</option>
			</select>
		</div>
		<div class="form-group relative">
			<span>កាលបរិច្ឆេទ</span>
			<input type="text" class="width150" data-bind="datePicker: Date, format: 'YYYY-MM-DD', dataType: 'string'" />
			<span class="space">ភូមិ</span>
			<input type="text" class="width150" data-bind="value: $root.getVillName(VOR()), click: $parent.chooseVill" />
		</div>
		<div class="form-group text-bold" style="text-decoration:underline">សំនួរ</div>
		<ol>
			<li>
				<span>តើអ្នកធ្វើដំណើរឆ្ងាយពីភូមិរបស់អ្នកទៅក្នុងព្រៃញឹកញាប់ដែរឬទេ?</span><br />
				<label>
					<input type="radio" name="Q1" value="Every day " data-bind="checked: Q1" />
					<span>រាល់ថ្ងៃ</span>
				</label>
				<label>
					<input type="radio" name="Q1" value="Every week" data-bind="checked: Q1" />
					<span>រាល់អាទិត្យ</span>
				</label>
				<label>
					<input type="radio" name="Q1" value="Twice a month" data-bind="checked: Q1" />
					<span>១ខែ២ដង</span>
				</label>
				<label>
					<input type="radio" name="Q1" value="Once a month" data-bind="checked: Q1" />
					<span>១ខែម្តង</span>
				</label>
				<label>
					<input type="radio" name="Q1" value="Once every 3 months" data-bind="checked: Q1" />
					<span>៣ខែម្តង</span>
				</label>
				<label>
					<input type="radio" name="Q1" value="Never" data-bind="checked: Q1" />
					<span>មិនដែរ</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកស្នាក់នៅកន្លែងទាំងនេះរយៈពេលប៉ុន្មាន?</span><br />
				<label>
					<input type="radio" name="Q2" value="Return same day" data-bind="checked: Q2" />
					<span>មកវិញថ្ងៃតែមួយ</span>
				</label>
				<label>
					<input type="radio" name="Q2" value="1-4 nights" data-bind="checked: Q2" />
					<span>១-៤យប់</span>
				</label>
				<label>
					<input type="radio" name="Q2" value="5-7 nights" data-bind="checked: Q2" />
					<span>៥-៧យប់</span>
				</label>
				<label>
					<input type="radio" name="Q2" value="7-30 nights" data-bind="checked: Q2" />
					<span>៧-៣០យប់</span>
				</label>
				<label>
					<input type="radio" name="Q2" value="30+ nights" data-bind="checked: Q2" />
					<span>៣០យប់ឡើង</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើជាធម្មតាអ្នកធ្វើដំណើរទៅកន្លែងណា? (សរសេរគ្រប់ទីកន្លែងដែលអ្នកបានទៅ)</span><br />
				<input type="text" style="width:100%" data-bind="value: Q3" />
				<br /><br />
			</li>
			<li>
				<span>តើជាធម្មតាអ្នកធ្វើដំណើរជាមួយមនុស្សប៉ុន្មាននាក់?</span><br />
				<label>
					<input type="radio" name="Q4" value="Alone" data-bind="checked: Q4" />
					<span>ម្នាក់ឯង</span>
				</label>
				<label>
					<input type="radio" name="Q4" value="Family" data-bind="checked: Q4" />
					<span>គ្រួសារ</span>
				</label>
				<label>
					<input type="radio" name="Q4" value="Group of People " data-bind="checked: Q4" />
					<span>ជាក្រុម</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកធ្វើអ្វីខ្លះនៅទីតាំងទាំងនេះ (ជ្រើសរើសយកទាំងអស់នៅអ្វីដែលអ្នកធ្វើ)?</span><br />
				<label>
					<input type="checkbox" data-bind="checked: Q5Harvesting" />
					<span>ប្រមូលផង</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q5Forest" />
					<span>កាប់ឈើ</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q5Hunting" />
					<span>បរបាញ់</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q5Fishing" />
					<span>នេសាទ</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q5Worksite" />
					<span>កន្លែងធ្វើការ</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q5Other" />
					<span>ផ្សេងទៀត</span>
					<input type="text" class="width150" data-bind="value: Q5OtherText, enable: Q5Other" />
				</label>
				<ol type="a">
					<li>
						<span>តើអ្នកធ្លាប់ធ្វើការនៅពេលយប់ទេ?</span><br />
						<label>
							<input type="radio" name="Q5a" value="Yes" data-bind="checked: Q5a" />
							<span>ធ្លាប់</span>
						</label>
						<label>
							<input type="radio" name="Q5a" value="No" data-bind="checked: Q5a" />
							<span>មិនធ្លាប់</span>
						</label>
					</li>
				</ol>
				<br />
			</li>
			<li>
				<span>នៅពេលដែលអ្នកគេងនៅទីតាំងទាំងនេះ តើអ្នកប្រើអ្វីដើម្បីការពារមូស(ជ្រើសរើសយកទាំងអស់នៅអ្វីដែលអ្នកធ្វើ)?</span><br />
				<label>
					<input type="checkbox" data-bind="checked: Q6LLIN" />
					<span>មុងគ្រែ មុងអង្រឹង</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q6Insect" />
					<span>ថ្នាំបាញ់មូស</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q6Sleeves" />
					<span>អាវដៃវែង</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q6Smoke" />
					<span>ធូកមូស</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q6Other" />
					<span>ផ្សេងទៀត</span>
					<input type="text" class="width150" data-bind="value: Q6OtherText, enable: Q6Other" />
				</label>
				<br /><br />
			</li>
			<li>
				<span>ប្រសិនបើអ្នកឈឺ តើអ្នកទៅព្យាបាលនៅកន្លែងណា?</span><br />
				<label>
					<input type="radio" name="Q7" value="Health Center" data-bind="checked: Q7" />
					<span>មណ្ឌលសុខភាព</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="Private Provider" data-bind="checked: Q7" />
					<span>ពេទ្យឯកជន</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="Pharmacy" data-bind="checked: Q7" />
					<span>ឱសថស្ថាន</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="VMW" data-bind="checked: Q7" />
					<span>អ្នកស្ម័គ្រចិត្តគ្រុនចាញ់ភូមិ</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="Home Remedy" data-bind="checked: Q7" />
					<span>កន្លែងលក់ថ្នាំខ្មែរ</span>
				</label>
				<br />
				<label>
					<input type="radio" name="Q7" value="I do not seek treatment" data-bind="checked: Q7" />
					<span>ខ្ញុំមិនទៅព្យាបាលទេ</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="Other" data-bind="checked: Q7" />
					<span>ផ្សេងទៀត</span>
					<input type="text" class="width150" data-bind="value: Q7Other, enable: Q7() == 'Other'" />
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកស្គាល់អ្នកដែលចូលព្រៃយកថ្នាំគ្រុនចាញ់ទៅជាមួយដែរឬទេ?</span><br />
				<label>
					<input type="radio" name="Q8" value="Yes" data-bind="checked: Q8" />
					<span>ធ្លាប់</span>
				</label>
				<label>
					<input type="radio" name="Q8" value="No" data-bind="checked: Q8" />
					<span>មិនធ្លាប់</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកធ្លាប់មានជំងឺគ្រុនចាញ់ពីមុនទេ?</span><br />
				<label>
					<input type="radio" name="Q9" value="Yes" data-bind="checked: Q9" />
					<span>ធ្លាប់</span>
				</label>
				<label>
					<input type="radio" name="Q9" value="No" data-bind="checked: Q9" />
					<span>មិនធ្លាប់</span>
				</label>
				<label>
					<input type="radio" name="Q9" value="Not Sure" data-bind="checked: Q9" />
					<span>មិនប្រាកដ</span>
				</label>
				<ol type="a">
					<li>
						<span>បើធ្លាប់មានជំងឺគ្រុនចាញ់ តើយូរប៉ុនណាហើយ?</span><br />
						<label>
							<input type="radio" name="Q9a" value="<1 month ago" data-bind="checked: Q9a" />
							<span>១ខែ</span>
						</label>
						<label>
							<input type="radio" name="Q9a" value="1-6 months ago" data-bind="checked: Q9a" />
							<span>១-៦ខែ</span>
						</label>
						<label>
							<input type="radio" name="Q9a" value="6 months – 1 year ago" data-bind="checked: Q9a" />
							<span>៦ខែ-១ឆ្នាំ</span>
						</label>
						<label>
							<input type="radio" name="Q9a" value=">1 year ago" data-bind="checked: Q9a" />
							<span>យូរជាង១ឆ្នាំ</span>
						</label>
					</li>
				</ol>
				<br />
			</li>
			<li>
				<span>តើអ្នករស់នៅក្នុងភូមិបច្ចុប្បន្នរបស់អ្នកយូរប៉ុនណាហើយ?</span><br />
				<label>
					<input type="radio" name="Q10" value="<1 week" data-bind="checked: Q10" />
					<span>តិចជាង១អាទិត្យ</span>
				</label>
				<label>
					<input type="radio" name="Q10" value="1 week - 6 months" data-bind="checked: Q10" />
					<span>១អាទិត្យ-៦ខែ</span>
				</label>
				<label>
					<input type="radio" name="Q10" value="6 months – 1 year" data-bind="checked: Q10" />
					<span>៦ខែ-១ឆ្នាំ</span>
				</label>
				<label>
					<input type="radio" name="Q10" value="1-2 years" data-bind="checked: Q10" />
					<span>១-២ឆ្នាំ</span>
				</label>
				<label>
					<input type="radio" name="Q10" value="2-5 years" data-bind="checked: Q10" />
					<span>២-៥ឆ្នាំ</span>
				</label>
				<label>
					<input type="radio" name="Q10" value="Always" data-bind="checked: Q10" />
					<span>តាំងពីកើត</span>
				</label>
			</li>
		</ol>
	</div>
</div>

<!-- Modal Save Change -->
<div class="modal" id="modalSave" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary"><kh>មានការកែទិន្នន័យ</kh> - Data Changing</h3>
			</div>
			<div class="modal-body" style="font-size:18px">
				<kh>សូមចុចប៊ូតុង Save ដើម្បីរក្សាទិន្នន័យក្នុងទំព័រនេះជាមុនសិន</kh>
				<br /><br />
				Please click button Save first?
			</div>
			<div class="modal-footer">
				<!--<button data-bind="click: $root.notSave" class="btn btn-danger btn-sm" data-dismiss="modal" style="width:100px">Don't Save</button>-->
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Question13.js')?>