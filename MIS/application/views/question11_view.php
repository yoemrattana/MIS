<div data-bind="visible: view() == 'detail', with: detailModel">
	<div class="kh">
		<div class="text-center text-bold">Form: Health Center Data Review</div>
		<br />
		<span>ក្រុមការងារគួរសើរសុំមើលសៀវភៅកត់ត្រាគ្រុនចាញ់ពីបុគ្គលិតមណ្ឌលសុខភាព។ ពិនិត្យមើលទិន្ន័យ២ខែចុងក្រោយ ក្រុមការងារគួរសំគាល់៥ភូមិដែលមានផ្ទុកគ្រុនចាញ់ ហើយបំពេញតារាងខាងក្រោម។</span>
		<br /><br />
		<table class="table" id="tbl1">
			<thead>
				<tr>
					<th></th>
					<th colspan="2">ករណីសរុប</th>
					<th colspan="8"></th>
				</tr>
				<tr>
					<th>ភូមិ</th>
					<th>ករណីប្រុស</th>
					<th>ករណីស្រី</th>
					<th>ករណីអាយុក្រោម៥ឆ្នាំ</th>
					<th width="205">មុខរបរទូទៅរបស់អ្នកភូមិ</th>
					<th width="200">សណ្ឋានដីរបស់ភូមិ</th>
					<th>ចម្ងាយពីមណ្ខល<br />សុខភាព (KM)</th>
					<th>មានកន្លែងដែល MMP<br />រឺអ្នកដើរព្រៃចូលចិត្តឆ្លងកាត់ទេ?</th>
					<th>មានអ្នកស្ម័គ្រចិត្តភូមិទេ?</th>
					<th>ភូមិមានបានជ្រើសរើស<br />សំរាប់ MMW អត់?</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="text" class="width150" data-bind="value: $root.getVillName(Q2Vill1()), click: () => { $parent.chooseVill(Q2Vill1) }" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Male1" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Female1" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Patient1" />
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Job1" value="Farming" data-bind="checked: Q2Job1" />
								<span>កសិករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job1" value="Manufacture " data-bind="checked: Q2Job1" />
								<span>កម្មករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job1" value="Forest Work" data-bind="checked: Q2Job1" />
								<span>អ្នកដើរព្រៃ</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Job1" value="Trade" data-bind="checked: Q2Job1" />
							<span>អ្នកជំនួញ</span>
						</label>
						<br />
						<label>
							<input type="radio" name="Q2Job1" value="Other" data-bind="checked: Q2Job1" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther1, enable: Q2Job1() == 'Other'" />
						</label>
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Geo1" value="Forest" data-bind="checked: Q2Geo1" />
								<span>ព្រៃ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo1" value="Mountain" data-bind="checked: Q2Geo1" />
								<span>ភ្នំ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo1" value="Swamp" data-bind="checked: Q2Geo1" />
								<span>លិចទឹក</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo1" value="Plains" data-bind="checked: Q2Geo1" />
								<span>រាប</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Geo1" value="Other" data-bind="checked: Q2Geo1" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther1, enable: Q2Geo1() == 'Other'" />
						</label>
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="float" data-bind="value: Q2Distance1" />
					</td>
					<td>
						<label>
							<input type="radio" name="Q2Pass1" value="Yes" data-bind="checked: Q2Pass1" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2Pass1" value="No" data-bind="checked: Q2Pass1" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2VMW1" value="Yes" data-bind="checked: Q2VMW1" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2VMW1" value="No" data-bind="checked: Q2VMW1" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2MMW1" value="Yes" data-bind="checked: Q2MMW1" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2MMW1" value="No" data-bind="checked: Q2MMW1" />
							<span>គ្មាន</span>
						</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" class="width150" data-bind="value: $root.getVillName(Q2Vill2()), click: () => { $parent.chooseVill(Q2Vill2) }" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Male2" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Female2" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Patient2" />
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Job2" value="Farming" data-bind="checked: Q2Job2" />
								<span>កសិករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job2" value="Manufacture " data-bind="checked: Q2Job2" />
								<span>កម្មករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job2" value="Forest Work" data-bind="checked: Q2Job2" />
								<span>អ្នកដើរព្រៃ</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Job2" value="Trade" data-bind="checked: Q2Job2" />
							<span>អ្នកជំនួញ</span>
						</label>
						<br />
						<label>
							<input type="radio" name="Q2Job2" value="Other" data-bind="checked: Q2Job2" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther2, enable: Q2Job2() == 'Other'" />
						</label>
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Geo2" value="Forest" data-bind="checked: Q2Geo2" />
								<span>ព្រៃ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo2" value="Mountain" data-bind="checked: Q2Geo2" />
								<span>ភ្នំ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo2" value="Swamp" data-bind="checked: Q2Geo2" />
								<span>លិចទឹក</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo2" value="Plains" data-bind="checked: Q2Geo2" />
								<span>រាប</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Geo2" value="Other" data-bind="checked: Q2Geo2" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther2, enable: Q2Geo2() == 'Other'" />
						</label>
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="float" data-bind="value: Q2Distance2" />
					</td>
					<td>
						<label>
							<input type="radio" name="Q2Pass2" value="Yes" data-bind="checked: Q2Pass2" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2Pass2" value="No" data-bind="checked: Q2Pass2" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2VMW2" value="Yes" data-bind="checked: Q2VMW2" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2VMW2" value="No" data-bind="checked: Q2VMW2" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2MMW2" value="Yes" data-bind="checked: Q2MMW2" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2MMW2" value="No" data-bind="checked: Q2MMW2" />
							<span>គ្មាន</span>
						</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" class="width150" data-bind="value: $root.getVillName(Q2Vill3()), click: () => { $parent.chooseVill(Q2Vill3) }" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Male3" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Female3" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Patient3" />
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Job3" value="Farming" data-bind="checked: Q2Job3" />
								<span>កសិករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job3" value="Manufacture " data-bind="checked: Q2Job3" />
								<span>កម្មករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job3" value="Forest Work" data-bind="checked: Q2Job3" />
								<span>អ្នកដើរព្រៃ</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Job3" value="Trade" data-bind="checked: Q2Job3" />
							<span>អ្នកជំនួញ</span>
						</label>
						<br />
						<label>
							<input type="radio" name="Q2Job3" value="Other" data-bind="checked: Q2Job3" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther3, enable: Q2Job3() == 'Other'" />
						</label>
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Geo3" value="Forest" data-bind="checked: Q2Geo3" />
								<span>ព្រៃ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo3" value="Mountain" data-bind="checked: Q2Geo3" />
								<span>ភ្នំ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo3" value="Swamp" data-bind="checked: Q2Geo3" />
								<span>លិចទឹក</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo3" value="Plains" data-bind="checked: Q2Geo3" />
								<span>រាប</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Geo3" value="Other" data-bind="checked: Q2Geo3" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther3, enable: Q2Geo3() == 'Other'" />
						</label>
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="float" data-bind="value: Q2Distance3" />
					</td>
					<td>
						<label>
							<input type="radio" name="Q2Pass3" value="Yes" data-bind="checked: Q2Pass3" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2Pass3" value="No" data-bind="checked: Q2Pass3" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2VMW3" value="Yes" data-bind="checked: Q2VMW3" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2VMW3" value="No" data-bind="checked: Q2VMW3" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2MMW3" value="Yes" data-bind="checked: Q2MMW3" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2MMW3" value="No" data-bind="checked: Q2MMW3" />
							<span>គ្មាន</span>
						</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" class="width150" data-bind="value: $root.getVillName(Q2Vill4()), click: () => { $parent.chooseVill(Q2Vill4) }" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Male4" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Female4" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Patient4" />
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Job4" value="Farming" data-bind="checked: Q2Job4" />
								<span>កសិករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job4" value="Manufacture " data-bind="checked: Q2Job4" />
								<span>កម្មករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job4" value="Forest Work" data-bind="checked: Q2Job4" />
								<span>អ្នកដើរព្រៃ</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Job4" value="Trade" data-bind="checked: Q2Job4" />
							<span>អ្នកជំនួញ</span>
						</label>
						<br />
						<label>
							<input type="radio" name="Q2Job4" value="Other" data-bind="checked: Q2Job4" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther4, enable: Q2Job4() == 'Other'" />
						</label>
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Geo4" value="Forest" data-bind="checked: Q2Geo4" />
								<span>ព្រៃ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo4" value="Mountain" data-bind="checked: Q2Geo4" />
								<span>ភ្នំ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo4" value="Swamp" data-bind="checked: Q2Geo4" />
								<span>លិចទឹក</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo4" value="Plains" data-bind="checked: Q2Geo4" />
								<span>រាប</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Geo4" value="Other" data-bind="checked: Q2Geo4" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther4, enable: Q2Geo4() == 'Other'" />
						</label>
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="float" data-bind="value: Q2Distance4" />
					</td>
					<td>
						<label>
							<input type="radio" name="Q2Pass4" value="Yes" data-bind="checked: Q2Pass4" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2Pass4" value="No" data-bind="checked: Q2Pass4" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2VMW4" value="Yes" data-bind="checked: Q2VMW4" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2VMW4" value="No" data-bind="checked: Q2VMW4" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2MMW4" value="Yes" data-bind="checked: Q2MMW4" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2MMW4" value="No" data-bind="checked: Q2MMW4" />
							<span>គ្មាន</span>
						</label>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" class="width150" data-bind="value: $root.getVillName(Q2Vill5()), click: () => { $parent.chooseVill(Q2Vill5) }" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Male5" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Female5" />
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="int" data-bind="value: Q2Patient5" />
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Job5" value="Farming" data-bind="checked: Q2Job5" />
								<span>កសិករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job5" value="Manufacture " data-bind="checked: Q2Job5" />
								<span>កម្មករ</span>
							</label>
							<label>
								<input type="radio" name="Q2Job5" value="Forest Work" data-bind="checked: Q2Job5" />
								<span>អ្នកដើរព្រៃ</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Job5" value="Trade" data-bind="checked: Q2Job5" />
							<span>អ្នកជំនួញ</span>
						</label>
						<br />
						<label>
							<input type="radio" name="Q2Job5" value="Other" data-bind="checked: Q2Job5" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther5, enable: Q2Job5() == 'Other'" />
						</label>
					</td>
					<td>
						<span class="text-nowrap">
							<label>
								<input type="radio" name="Q2Geo5" value="Forest" data-bind="checked: Q2Geo5" />
								<span>ព្រៃ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo5" value="Mountain" data-bind="checked: Q2Geo5" />
								<span>ភ្នំ</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo5" value="Swamp" data-bind="checked: Q2Geo5" />
								<span>លិចទឹក</span>
							</label>
							<label>
								<input type="radio" name="Q2Geo5" value="Plains" data-bind="checked: Q2Geo5" />
								<span>រាប</span>
							</label>
						</span>
						<br />
						<label>
							<input type="radio" name="Q2Geo5" value="Other" data-bind="checked: Q2Geo5" />
							<span>ផ្សេងទៀត</span>
							<input type="text" class="width100" data-bind="value: Q2JobOther5, enable: Q2Geo5() == 'Other'" />
						</label>
					</td>
					<td>
						<input type="text" class="width100 numonly" data-type="float" data-bind="value: Q2Distance5" />
					</td>
					<td>
						<label>
							<input type="radio" name="Q2Pass5" value="Yes" data-bind="checked: Q2Pass5" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2Pass5" value="No" data-bind="checked: Q2Pass5" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2VMW5" value="Yes" data-bind="checked: Q2VMW5" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2VMW5" value="No" data-bind="checked: Q2VMW5" />
							<span>គ្មាន</span>
						</label>
					</td>
					<td>
						<label>
							<input type="radio" name="Q2MMW5" value="Yes" data-bind="checked: Q2MMW5" />
							<span>មាន</span>
						</label>
						<label>
							<input type="radio" name="Q2MMW5" value="No" data-bind="checked: Q2MMW5" />
							<span>គ្មាន</span>
						</label>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Question11.js')?>