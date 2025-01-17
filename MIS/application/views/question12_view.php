<div style="width:800px" data-bind="visible: view() == 'detail', with: detailModel">
	<div class="text-center text-bold">Form: Hotspot Identification Form (Interview with Village Chief or Deputy Village Chief)</div>
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
			<!--<li>
				<span>មើលនៅក្នុងផែនទីភូមិប្រសិនជាមាន។ បើគ្មានទេ សូមគូរផែនទីភូមិជាមួយមេភូមិ (គូរផ្ទះ ផ្លូវ ព្រៃ ច្រកចូល ទន្លេ)</span><br />
				<br />
			</li>-->
			<li>
				<span>តើអ្នកសម្គាល់ឃើញមានក្រុមប្រជាជននៅក្នុងភូមិដែលឧស្សាហ៏កើតជំងឺគ្រុនចាញ់ញឹកញាប់ដែររឺទេ?</span><br />
				<label>
					<input type="radio" name="Q2" value="Yes" data-bind="checked: Q2" />
					<span>មាន</span>
				</label>
				<label>
					<input type="radio" name="Q2" value="No" data-bind="checked: Q2" />
					<span>គ្មាន</span>
				</label>
				<ol type="a">
					<li>
						<span>បើមាន តើពួកគេជាអ្នកភូមិបែបណា?</span><br />
						<label>
							<input type="radio" name="Q2a" value="Villagers whose houses are closer to the forest" data-bind="checked: Q2a" />
							<span>អ្នកភូមិដែរផ្ទះពួកគេនៅជិតព្រៃ</span>
						</label>
						<label>
							<input type="radio" name="Q2a" value="Villagers who work in forest" data-bind="checked: Q2a" />
							<span>អ្នកភូមិដែលធ្វើការក្នុងព្រៃ</span>
						</label>
						<br />
						<label>
							<input type="radio" name="Q2a" value="Villagers who travel around OD for work" data-bind="checked: Q2a" />
							<span>អ្នកភូមិដែលធ្វើដំណើរជុំវិញស្រុកប្រតិបត្តដើម្បីការងារ</span>
						</label>
						<label>
							<input type="radio" name="Q2a" value="Villagers who work at a nearby worksite" data-bind="checked: Q2a" />
							<span>អ្នកភូមិដែលធ្វើការជិតការដ្ឋាន</span>
						</label>
					</li>
				</ol>
				<br />
			</li>
			<li>
				<span>តើមានតំបន់ជាក់លាក់ណាមួយនៅក្នុងភូមិដែលភាគច្រើនប្រជាជនឆ្លងជំងឺគ្រុនចាញ់ពីកន្លែងនោះ?</span><br />
				<label>
					<input type="radio" name="Q3" value="Yes" data-bind="checked: Q3" />
					<span>មាន</span>
				</label>
				<label>
					<input type="radio" name="Q3" value="No" data-bind="checked: Q3" />
					<span>គ្មាន</span>
				</label>
				<ol type="a">
					<li>
						<span>បើមាន នៅកន្លែងណា?</span><br />
						<input type="text" style="width:100%" data-bind="value: Q3a, enable: Q3() == 'Yes'" />
					</li>
				</ol>
				<br />
			</li>
			<li>
				<span>តើមានប្រជាជនប៉ុន្មាននាក់ដែលរស់នៅក្នុងភូមិ ហើយទៅធ្វើការនៅក្នុងព្រៃ?</span><br />
				<label>
					<input type="radio" name="Q4" value="<20%" data-bind="checked: Q4" />
					<span>&lt;20%</span>
				</label>
				<label>
					<input type="radio" name="Q4" value="20-50%" data-bind="checked: Q4" />
					<span>20-50%</span>
				</label>
				<label>
					<input type="radio" name="Q4" value="50-80%" data-bind="checked: Q4" />
					<span>50-80%</span>
				</label>
				<label>
					<input type="radio" name="Q4" value=">80%" data-bind="checked: Q4" />
					<span>&gt;80%</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើការងារអ្វីដែលប្រជាជនទាំងអស់នោះចូលទៅធ្វើការនៅក្នុងព្រៃ?</span><br />
				<label>
					<input type="radio" name="Q5" value="Harvesting" data-bind="checked: Q5" />
					<span>ប្រមូលផង</span>
				</label>
				<label>
					<input type="radio" name="Q5" value="Logging" data-bind="checked: Q5" />
					<span>កាប់ឈើ</span>
				</label>
				<label>
					<input type="radio" name="Q5" value="Hunting" data-bind="checked: Q5" />
					<span>បរបាញ់</span>
				</label>
				<label>
					<input type="radio" name="Q5" value="Fishing" data-bind="checked: Q5" />
					<span>នេសាទ</span>
				</label>
				<label>
					<input type="radio" name="Q5" value="Worksite" data-bind="checked: Q5" />
					<span>កន្លែងធ្វើការ</span>
				</label>
				<label>
					<input type="radio" name="Q5" value="Other" data-bind="checked: Q5" />
					<span>ផ្សេងទៀត</span>
					<input type="text" class="width150" data-bind="value: Q5Other, enable: Q5() == 'Other'" />
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើភាគច្រើនពួគគាត់ធ្វើដំណើរនៅពេលណា?</span><br />
				<label>
					<input type="radio" name="Q6" value="Early Morning" data-bind="checked: Q6" />
					<span>ព្រឹក</span>
				</label>
				<label>
					<input type="radio" name="Q6" value="During the Day" data-bind="checked: Q6" />
					<span>ថ្ងៃ</span>
				</label>
				<label>
					<input type="radio" name="Q6" value="Late Night" data-bind="checked: Q6" />
					<span>យប់</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើពួកគាត់ស្នាក់នៅក្នុងព្រៃប៉ុន្នានយប់មុនពេលត្រឡប់ចូលភូមិវិញ?</span><br />
				<label>
					<input type="radio" name="Q7" value="Return same day" data-bind="checked: Q7" />
					<span>មកវិញថ្ងៃតែមួយ</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="1-4 nights" data-bind="checked: Q7" />
					<span>១-៤យប់</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="5-7 nights" data-bind="checked: Q7" />
					<span>៥-៧យប់</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="7-30 nights" data-bind="checked: Q7" />
					<span>៧-៣០យប់</span>
				</label>
				<label>
					<input type="radio" name="Q7" value="30+ nights" data-bind="checked: Q7" />
					<span>៣០យប់ឡើង</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>តើតំបន់ណាដែលអ្នកចូលព្រៃ រឺ អ្នកស្រុកដែលមានជំងឺគ្រុនចាញ់តែងតែធ្វើដំណើរទៅ?</span><br />
				<input type="text" style="width:100%" data-bind="value: Q8" />
				<br /><br />
			</li>
			<li>
				<span>តើអ្នកគិតថាប្រជាជនដែលរស់នៅក្នុងភូមិ ប៉ុន្ដែមិនបានធ្វើដំណើរ អាចឆ្លងជំងឺគ្រុនចាញ់ដែររឺទេ?</span><br />
				<label>
					<input type="radio" name="Q9" value="Yes" data-bind="checked: Q9" />
					<span>មាន</span>
				</label>
				<label>
					<input type="radio" name="Q9" value="No" data-bind="checked: Q9" />
					<span>គ្មាន</span>
				</label>
				<br /><br />
			</li>
			<li>
				<span>ប្រសិនបើយើងត្រូវបង្កើតអ្នកស្ម័គ្រចិត្តភូមិចល័តដើម្បីបែងចែកចំនួនប្រជាជនដែលចូលទៅក្នុងព្រៃ រឺ ឆ្លងជំងឺគ្រុនចាញ់ (នៅកន្លែងធ្វើការ ។ល។) តើកន្លែងណាដែលគួរបង្កើតអោយមាន?</span><br />
				<input type="text" style="width:100%" data-bind="value: Q10" />
			</li>
		</ol>
	</div>
</div>

<?=latestJs('/media/ViewModel/Question12.js')?>