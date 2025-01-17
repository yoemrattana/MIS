<div style="width:800px" data-bind="visible: view() == 'detail', with: detailModel">
	<div class="text-center text-bold">Form: Forest Pack Questionnaire</div>
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
				<span>តើមានមនុស្សប៉ុន្មាននាក់ដែលអ្នកធ្វើដំណើរជាមួយ?</span><br />
				<label>
					<input type="radio" name="Q4" value="Alone" data-bind="checked: Q4" />
					<span>ម្នាក់ឯង</span>
				</label>
				<label>
					<input type="radio" name="Q4" value="Family" data-bind="checked: Q4" />
					<span>គ្រួសារ</span>
				</label>
				<label>
					<input type="radio" name="Q4" value="Group of People" data-bind="checked: Q4" />
					<span>ជាក្រុម</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកធ្វើអ្វីខ្លះនៅទីតាំងទាំងនេះ (ចំលើយលើសពី១)?</span><br />
				<label>
					<input type="checkbox" data-bind="checked: Q5Harvesting" />
					<span>ប្រមូលផង</span>
				</label>
				<label>
					<input type="checkbox" data-bind="checked: Q5Forest" />
					<span>ប្រមួលរបស់ក្នុងព្រៃ</span>
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
			</li>
            <li>
                <span>តើអ្នកធ្លាប់ទទួលបានកញ្ចប់ដើរព្រៃពីមុនទេ?</span><br />
                <label>
					<input type="radio" name="Q6" value="Yes" data-bind="checked: Q6" />
					<span>ធ្លាប់</span>
				</label>
				<label>
					<input type="radio" name="Q6" value="No" data-bind="checked: Q6" />
					<span>មិនធ្លាប់</span>
				</label>
                <span>ប្រសិនបើមាន,តើមានសម្ភារះអ្វីដែលត្រូវប្តូរទេ?</span><br/>
				<label>
					<input type="checkbox" data-bind="checked: Q6LLIN" />
					<span>មុងអង្រឹងជ្រលក់ថ្នាំ</span>
				</label>
                <label>
					<input type="checkbox" data-bind="checked: Q6SkinGel" />
					<span>ថ្នាំលាបលើស្បែកសម្រាប់បណ្តេញមូស</span>
				</label>
            </li>
		</ol>
	</div>
</div>

<?=latestJs('/media/ViewModel/Question22.js')?>