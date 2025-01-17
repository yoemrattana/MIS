<div style="width:800px" data-bind="visible: view() == 'detail', with: detailModel">
	<div class="text-center text-bold">Form: MMW Active Screening</div>
	<br />
	<div class="kh">
		<div class="form-group relative">
			<span>ខេត្ត</span>
			<input type="text" class="width150" data-bind="value: $root.getProvName(Code_Prov_T()), click: $parent.choosePlace" />
			<span class="space">ស្រុកប្រតិបត្ត</span>
			<input type="text" class="width150" data-bind="value: $root.getODName(Code_OD_T()), click: $parent.choosePlace" />
			<span class="space">កាលបរិច្ឆេទ</span>
			<input type="text" class="width150" data-bind="datePicker: FormDate, format: 'YYYY-MM-DD', dataType: 'string'" />
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
						<input type="text" class="width150" data-bind="value: A1Q1aName" />
					</li>
					<li>
						<span>ឈ្មោះទីតាំងទី២</span>
						<input type="text" class="width150" data-bind="value: A1Q1bName" />
					</li>
					<li>
						<span>ឈ្មោះទីតាំងទី៣</span>
						<input type="text" class="width150" data-bind="value: A1Q1cName" />
					</li>
				</ol>
				<br />
			</li>
			<li>
				<span>MMW គួរតែបំពេញព័ត៌មានដូចខាងក្រោមសម្រាប់ការធ្វើការជួសឈាមនីមួយៗ។ ជួសឈាមតែមនុស្សមានគ្រោះថ្នាក់ប៉ុណ្ណោះ។ ទាំងនេះរួមបញ្ចូលទាំងអ្នកដែលទៅរកតំបន់ដែលមានហានិភ័យខ្ពស់នៅជិតព្រៃឈើ និងអ្នកដែលមានគ្រុនក្តៅ។</span>
				<ol type="a">
					<li>
						<span>ឈ្មោះទីតាំងទី១</span>
						<ul>
							<li>
								<span>ចំនួនអ្នកដើរព្រៃ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2aForest" />
							</li>
							<li>
								<span>ចំនួនអ្នកគ្រុនក្តៅ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2aFever" />
							</li>
							<li>
								<span>ចំនួនអ្នកបានធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2aTested" />
							</li>
							<li>
								<span>ចំនួនករណីវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2aPositive" />
							</li>
							<li>
								<span>ចំនួនករណីអវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2aNegative" />
							</li>
							<li>
								<span>ចំនួនអ្នកមិនព្រមធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2aRefused" />
							</li>
						</ul>
						<br />
					</li>
					<li>
						<span>ឈ្មោះទីតាំងទី២</span>
						<ul>
							<li>
								<span>ចំនួនអ្នកដើរព្រៃ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2bForest" />
							</li>
							<li>
								<span>ចំនួនអ្នកគ្រុនក្តៅ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2bFever" />
							</li>
							<li>
								<span>ចំនួនអ្នកបានធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2bTested" />
							</li>
							<li>
								<span>ចំនួនករណីវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2bPositive" />
							</li>
							<li>
								<span>ចំនួនករណីអវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2bNegative" />
							</li>
							<li>
								<span>ចំនួនអ្នកមិនព្រមធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2bRefused" />
							</li>
						</ul>
						<br />
					</li>
					<li>
						<span>ឈ្មោះទីតាំងទី៣</span>
						<ul>
							<li>
								<span>ចំនួនអ្នកដើរព្រៃ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2cForest" />
							</li>
							<li>
								<span>ចំនួនអ្នកគ្រុនក្តៅ</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2cFever" />
							</li>
							<li>
								<span>ចំនួនអ្នកបានធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2cTested" />
							</li>
							<li>
								<span>ចំនួនករណីវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2cPositive" />
							</li>
							<li>
								<span>ចំនួនករណីអវិជ្ជមាន</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2cNegative" />
							</li>
							<li>
								<span>ចំនួនអ្នកមិនព្រមធ្វើតេស្ត</span>
								<input type="text" class="width150 numonly" data-type="int" data-bind="value: A1Q2cRefused" />
							</li>
						</ul>
					</li>
				</ol>
			</li>
		</ol>
	</div>

	<br /><br />
	<div class="text-center text-bold">Annex 2: MMP Questionaire</div>
	<br />

	<div class="kh">
		<div class="form-group">
			<span>មណ្ឌលសុខភាព MMW</span>
			<input type="text" class="width150" data-bind="value: $root.getHCName(A2HFMMW()), click: $parent.chooseMMW" />
			<span class="space kh">ភូមិ MMW</span>
			<input type="text" class="width150" data-bind="value: $root.getVillName(A2VillMMW()), click: $parent.chooseMMW" />
		</div>
		<br />
		<div class="form-group kh">រកឃើញដោយរបៀបណា:</div>
		<div class="form-group">
			<label>
				<input type="radio" name="A2Type" value="Suspected Malaria Patient coming to MMW" data-bind="checked: A2Type" />
				<span>អ្នកជំងឺគ្រុនចាញ់មកជួប MMW</span>
			</label>
		</div>
		<div class="form-group">
			<label>
				<input type="radio" name="A2Type" value="Healthy Individual requesting forest pack" data-bind="checked: A2Type" />
				<span>សំភារៈដើរព្រៃ</span>
			</label>
		</div>
		<div class="form-group">
			<label>
				<input type="radio" name="A2Type" value="Individual screened for active case detection" data-bind="checked: A2Type" />
				<span>ការជួសឈាម</span>
			</label>
		</div>
		<div class="line"></div>
		<div class="form-group">
			<span>ឈ្មោះ</span>
			<input type="text" class="width150" data-bind="value: A2Name" />
			<span class="space">លេខទូរសព្ទ</span>
			<input type="text" class="width150 numonly" data-type="int" data-bind="value: A2Phone" />
			<span class="space">អាយុ</span>
			<input type="text" class="width100 numonly" data-type="int" maxlength="2" data-bind="value: A2Age" />
			<span class="space">ភេទ</span>
			<select class="width100" data-bind="value: A2Sex">
				<option value=""></option>
				<option value="Male">ប្រុស</option>
				<option value="Female">ស្រី</option>
			</select>
		</div>
		<div class="form-group relative">
			<span>កាលបរិច្ឆេទ</span>
			<input type="text" class="width150" data-bind="datePicker: A2Date, format: 'YYYY-MM-DD', dataType: 'string'" />
			<span class="space">ភូមិ</span>
			<input type="text" class="width150" data-bind="value: $root.getVillName(A2VOR()), click: $parent.chooseVill" />
		</div>
		<div class="form-group text-bold" style="text-decoration:underline">សំនួរ</div>
		<ol>
			<li>
				<span>តើអ្នកធ្វើដំណើរឆ្ងាយពីភូមិរបស់អ្នកទៅក្នុងព្រៃញឹកញាប់ដែរឬទេ?</span><br />
				<label>
					<input type="radio" name="A2Q1" value="Every day " data-bind="checked: A2Q1" />
					<span>រាល់ថ្ងៃ</span>
				</label>
				<label>
					<input type="radio" name="A2Q1" value="Every week" data-bind="checked: A2Q1" />
					<span>រាល់អាទិត្យ</span>
				</label>
				<label>
					<input type="radio" name="A2Q1" value="Twice a month" data-bind="checked: A2Q1" />
					<span>១ខែ២ដង</span>
				</label>
				<label>
					<input type="radio" name="A2Q1" value="Once a month" data-bind="checked: A2Q1" />
					<span>១ខែម្តង</span>
				</label>
				<label>
					<input type="radio" name="A2Q1" value="Once every 3 months" data-bind="checked: A2Q1" />
					<span>៣ខែម្តង</span>
				</label>
				<label>
					<input type="radio" name="A2Q1" value="Never" data-bind="checked: A2Q1" />
					<span>មិនដែរ</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើជាធម្មតាអ្នកធ្វើដំណើរទៅកន្លែងណា និងឆ្ងាយប៉ុណ្ណា? (សរសេរគ្រប់ទីកន្លែងដែលអ្នកបានទៅ និងពេលវេលាធ្វើដំណើរ)</span><br />
				<input type="text" style="width:100%" data-bind="value: A2Q2" />
				<br /><br />
			</li>
			<li>
				<span>តើជាធម្មតាអ្នកធ្វើដំណើរជាមួយមនុស្សប៉ុន្មាននាក់?</span><br />
				<label>
					<input type="radio" name="A2Q3" value="Alone" data-bind="checked: A2Q3" />
					<span>ម្នាក់ឯង</span>
				</label>
				<label>
					<input type="radio" name="A2Q3" value="2-3 people" data-bind="checked: A2Q3" />
					<span>២-៣នាក់</span>
				</label>
				<label>
					<input type="radio" name="A2Q3" value="4-7 people" data-bind="checked: A2Q3" />
					<span>៤-៧នាក់</span>
				</label>
				<label>
					<input type="radio" name="A2Q3" value="8+ people" data-bind="checked: A2Q3" />
					<span>៨នាក់ឡើង</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកស្នាក់នៅកន្លែងទាំងនេះរយៈពេលប៉ុន្មាន?</span><br />
				<label>
					<input type="radio" name="A2Q4" value="Return same day" data-bind="checked: A2Q4" />
					<span>មកវិញថ្ងៃតែមួយ</span>
				</label>
				<label>
					<input type="radio" name="A2Q4" value="1-4 nights" data-bind="checked: A2Q4" />
					<span>១-៤យប់</span>
				</label>
				<label>
					<input type="radio" name="A2Q4" value="5-7 nights" data-bind="checked: A2Q4" />
					<span>៥-៧យប់</span>
				</label>
				<label>
					<input type="radio" name="A2Q4" value="7-30 nights" data-bind="checked: A2Q4" />
					<span>៧-៣០យប់</span>
				</label>
				<label>
					<input type="radio" name="A2Q4" value="30+ nights" data-bind="checked: A2Q4" />
					<span>៣០យប់ឡើង</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកធ្វើអ្វីខ្លះនៅទីតាំងទាំងនេះ (ជ្រើសរើសយកទាំងអស់នៅអ្វីដែលអ្នកធ្វើ)?</span><br />
				<label>
					<input type="radio" name="A2Q5" value="Harvesting" data-bind="checked: A2Q5" />
					<span>ប្រមូលផង</span>
				</label>
				<label>
					<input type="radio" name="A2Q5" value="Logging" data-bind="checked: A2Q5" />
					<span>កាប់ឈើ</span>
				</label>
				<label>
					<input type="radio" name="A2Q5" value="Hunting" data-bind="checked: A2Q5" />
					<span>បរបាញ់</span>
				</label>
				<label>
					<input type="radio" name="A2Q5" value="Fishing" data-bind="checked: A2Q5" />
					<span>នេសាទ</span>
				</label>
				<label>
					<input type="radio" name="A2Q5" value="Worksite" data-bind="checked: A2Q5" />
					<span>កន្លែងធ្វើការ</span>
				</label>
				<label>
					<input type="radio" name="A2Q5" value="Other" data-bind="checked: A2Q5" />
					<span>ផ្សេងទៀត</span>
					<input type="text" class="width150" data-bind="value: A2Q5Other, enable: A2Q5() == 'Other'" />
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើមានមនុស្សប៉ុន្មាននាក់ផ្សេងទៀតដែលធ្វើការនៅទីតាំងទាំងនេះ?</span><br />
				<label>
					<input type="radio" name="A2Q6" value="Alone" data-bind="checked: A2Q6" />
					<span>ម្នាក់ឯង</span>
				</label>
				<label>
					<input type="radio" name="A2Q6" value="2-3 people" data-bind="checked: A2Q6" />
					<span>២-៣នាក់</span>
				</label>
				<label>
					<input type="radio" name="A2Q6" value="4-7 people" data-bind="checked: A2Q6" />
					<span>៤-៧នាក់</span>
				</label>
				<label>
					<input type="radio" name="A2Q6" value="8+ people" data-bind="checked: A2Q6" />
					<span>៨នាក់ឡើង</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>នៅពេលដែលអ្នកធ្វើដំណើរទៅកាន់ទីតាំងទាំងនេះ តើអ្នកគេងយ៉ាងដូចម្ដេច?</span><br />
				<label>
					<input type="radio" name="A2Q7" value="Hammock" data-bind="checked: A2Q7" />
					<span>អង្រឹង</span>
				</label>
				<label>
					<input type="radio" name="A2Q7" value="Tent" data-bind="checked: A2Q7" />
					<span>តង់</span>
				</label>
				<label>
					<input type="radio" name="A2Q7" value="Camp" data-bind="checked: A2Q7" />
					<span>ជំរំ</span>
				</label>
				<label>
					<input type="radio" name="A2Q7" value="Plot Hut" data-bind="checked: A2Q7" />
					<span>ខ្ទម</span>
				</label>
				<label>
					<input type="radio" name="A2Q7" value="House" data-bind="checked: A2Q7" />
					<span>ផ្ទះ</span>
				</label>
				<ol type="a">
					<li>
						<span>បើអ្នកគេងក្នុងអង្រឹងពេលយប់នៅកន្លែងទាំងនេះ តើអ្នកប្រើមុងអង្រឹងទេ?</span><br />
						<label>
							<input type="radio" name="A2Q7a" value="Yes" data-bind="checked: A2Q7a" />
							<span>ប្រើ</span>
						</label>
						<label>
							<input type="radio" name="A2Q7a" value="No, don’t have a net" data-bind="checked: A2Q7a" />
							<span>គ្មានមុង</span>
						</label>
						<label>
							<input type="radio" name="A2Q7a" value="No, don’t like using the net " data-bind="checked: A2Q7a" />
							<span>មិនចូលចិត្តប្រើមុង</span>
						</label>
						<label>
							<input type="radio" name="A2Q7a" value="No, I forget" data-bind="checked: A2Q7a" />
							<span>ភ្លេចយកតាម</span>
						</label>
					</li>
				</ol>
				<br />
			</li>
			<li>
				<span>នៅពេលដែលអ្នកគេងនៅទីតាំងទាំងនេះ តើអ្នកប្រើអ្វីដើម្បីការពារមូស(ជ្រើសរើសយកទាំងអស់នៅអ្វីដែលអ្នកធ្វើ)?</span><br />
				<label>
					<input type="radio" name="A2Q8" value="IN / LLIHN" data-bind="checked: A2Q8" />
					<span>មុងគ្រែ មុងអង្រឹង</span>
				</label>
				<label>
					<input type="radio" name="A2Q8" value="Insect Spray" data-bind="checked: A2Q8" />
					<span>ថ្នាំបាញ់មូស</span>
				</label>
				<label>
					<input type="radio" name="A2Q8" value="Long Sleeves" data-bind="checked: A2Q8" />
					<span>អាវដៃវែង</span>
				</label>
				<label>
					<input type="radio" name="A2Q8" value="Coil / Smoke" data-bind="checked: A2Q8" />
					<span>ធូកមូស</span>
				</label>
				<label>
					<input type="radio" name="A2Q8" value="Other" data-bind="checked: A2Q8" />
					<span>ផ្សេងទៀត</span>
					<input type="text" class="width150" data-bind="value: A2Q8Other, enable: A2Q8() == 'Other'" />
				</label>
				<br /><br />
			</li>
			<li>
				<span>នៅពេលដែលអ្នកទៅព្រៃតើអ្នកធ្លាប់យកថ្នាំគ្រុនចាញ់ទៅជាមួយអ្នកដែរឬទេ?</span><br />
				<label>
					<input type="radio" name="A2Q9" value="Yes" data-bind="checked: A2Q9" />
					<span>ធ្លាប់</span>
				</label>
				<label>
					<input type="radio" name="A2Q9" value="No" data-bind="checked: A2Q9" />
					<span>មិនធ្លាប់</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកធ្លាប់ធ្វើការនៅខាងក្រៅពេលយប់ទេ?</span><br />
				<label>
					<input type="radio" name="A2Q10" value="Yes" data-bind="checked: A2Q10" />
					<span>ធ្លាប់</span>
				</label>
				<label>
					<input type="radio" name="A2Q10" value="No" data-bind="checked: A2Q10" />
					<span>មិនធ្លាប់</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកធ្លាប់មានជំងឺគ្រុនចាញ់ពីមុនទេ?</span><br />
				<label>
					<input type="radio" name="A2Q11" value="Yes" data-bind="checked: A2Q11" />
					<span>ធ្លាប់</span>
				</label>
				<label>
					<input type="radio" name="A2Q11" value="No" data-bind="checked: A2Q11" />
					<span>មិនធ្លាប់</span>
				</label>
				<label>
					<input type="radio" name="A2Q11" value="Not Sure" data-bind="checked: A2Q11" />
					<span>មិនប្រាកដ</span>
				</label>
				<ol type="a">
					<li>
						<span>បើធ្លាប់មានជំងឺគ្រុនចាញ់ តើយូរប៉ុនណាហើយ?</span><br />
						<label>
							<input type="radio" name="A2Q11a" value="<1 month ago" data-bind="checked: A2Q11a" />
							<span>១ខែ</span>
						</label>
						<label>
							<input type="radio" name="A2Q11a" value="1-6 months ago" data-bind="checked: A2Q11a" />
							<span>១-៦ខែ</span>
						</label>
						<label>
							<input type="radio" name="A2Q11a" value="6 months – 1 year ago" data-bind="checked: A2Q11a" />
							<span>៦ខែ-១ឆ្នាំ</span>
						</label>
						<label>
							<input type="radio" name="A2Q11a" value=">1 year ago" data-bind="checked: A2Q11a" />
							<span>យូរជាង១ឆ្នាំ</span>
						</label>
					</li>
				</ol>
				<br />
			</li>
			<li>
				<span>ប្រសិនបើអ្នកឈឺ តើអ្នកទៅព្យាបាលនៅកន្លែងណា?</span><br />
				<label>
					<input type="radio" name="A2Q12" value="Health Center" data-bind="checked: A2Q12" />
					<span>មណ្ឌលសុខភាព</span>
				</label>
				<label>
					<input type="radio" name="A2Q12" value="Private Provider" data-bind="checked: A2Q12" />
					<span>ពេទ្យឯកជន</span>
				</label>
				<label>
					<input type="radio" name="A2Q12" value="Pharmacy" data-bind="checked: A2Q12" />
					<span>ឱសថស្ថាន</span>
				</label>
				<label>
					<input type="radio" name="A2Q12" value="VMW" data-bind="checked: A2Q12" />
					<span>អ្នកស្ម័គ្រចិត្តគ្រុនចាញ់ភូមិ</span>
				</label>
				<label>
					<input type="radio" name="A2Q12" value="Home Remedy" data-bind="checked: A2Q12" />
					<span>កន្លែងលក់ថ្នាំខ្មែរ</span>
				</label>
				<br />
				<label>
					<input type="radio" name="A2Q12" value="I do not seek treatment" data-bind="checked: A2Q12" />
					<span>ខ្ញុំមិនទៅព្យាបាលទេ</span>
				</label>
				<label>
					<input type="radio" name="A2Q12" value="Other" data-bind="checked: A2Q12" />
					<span>ផ្សេងទៀត</span>
					<input type="text" class="width150" data-bind="value: A2Q12Other, enable: A2Q12() == 'Other'" />
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នករស់នៅក្នុងភូមិបច្ចុប្បន្នរបស់អ្នកយូរប៉ុនណាហើយ?</span><br />
				<label>
					<input type="radio" name="A2Q13" value="<1 week" data-bind="checked: A2Q13" />
					<span>តិចជាង១អាទិត្យ</span>
				</label>
				<label>
					<input type="radio" name="A2Q13" value="1 week - 6 months" data-bind="checked: A2Q13" />
					<span>១អាទិត្យ-៦ខែ</span>
				</label>
				<label>
					<input type="radio" name="A2Q13" value="6 months – 1 year" data-bind="checked: A2Q13" />
					<span>៦ខែ-១ឆ្នាំ</span>
				</label>
				<label>
					<input type="radio" name="A2Q13" value="1-2 years" data-bind="checked: A2Q13" />
					<span>១-២ឆ្នាំ</span>
				</label>
				<label>
					<input type="radio" name="A2Q13" value="2-5 years" data-bind="checked: A2Q13" />
					<span>២-៥ឆ្នាំ</span>
				</label>
				<label>
					<input type="radio" name="A2Q13" value="Always" data-bind="checked: A2Q13" />
					<span>តាំងពីកើត</span>
				</label>
			</li>
		</ol>
	</div>
</div>

<?=latestJs('/media/ViewModel/Question23.js')?>