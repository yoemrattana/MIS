<style>
	.mb-5 { margin-bottom: 5px; }
	textarea { resize: vertical; }

	/* Hide Arrows From Input Number: Chrome, Safari, Edge, Opera */
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
	}

	/* Hide Arrows From Input Number: Firefox */
	input[type=number] {
		-moz-appearance: textfield;
	}
</style>

<div class="kh divcenter" data-bind="visible: view() == 'detail'">
	<h3 class="text-center">បញ្ជីផ្ទៀងផ្ទាត់ការធានាគុណភាពប្រព័ន្ធអង្គេតតាមដានករណីជំងឺគ្រុនចាញ់</h3>
	<br />
	<form id="myform">
		<div class="form-inline" style="border:2px solid; padding:10px" data-bind="with: masterModel">
			<p>
				<span>ការចុះអភិបាលនៅ ខេត្ត</span>
				<select data-bind="value: Code_Prov_N,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh" required></select>

				<span class="space">ស្រុកប្រតិបត្តិ</span>
				<select data-bind="value: Code_OD_T,
						options: odList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh" required></select>

				<span class="space">មណ្ឌលសុខភាព</span>
				<select data-bind="value: Code_Facility_T,
						options: hcList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh" required></select>
			</p>
			<p class="relative en">
				<kh>កាលបរិច្ឆេទ</kh>
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: VisitDate, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" required />
			</p>
			<p>
				<span>ឈ្មោះអ្នកបំពេញបញ្ជីផ្ទៀងផ្ទាត់</span>
				<input type="text" class="form-control" data-bind="value: VisitorName" required />

				<span class="space">ភេទ</span>
				<select class="form-control kh" data-bind="value: VisitorSex" required>
					<option value="M">ប្រុស</option>
					<option value="F">ស្រី</option>
				</select>

				<span class="space">តួនាទី</span>
				<input type="text" class="form-control" data-bind="value: Position" required />

				<span class="space">ទូរស័ព្ទលេខ</span>
				<input type="text" class="form-control" data-bind="value: Phone" required />
			</p>
			<p>
				<span>ទីកន្លែងធ្វើការ</span>
				<select class="form-control kh" data-bind="value: Workplace" required>
					<option value=""></option>
					<option value="CNM">ម.គ.ច</option>
					<option value="PHD">មន្ទីរសុខាភិបាលខេត្ត</option>
					<option value="OD">ស្រុកប្រតិបត្តិ</option>
				</select>
			</p>
			<span>សមាសភាពចូលរួម៖</span>
			<table class="table table-bordered widthauto">
				<thead>
					<tr>
						<th align="center">ឈ្មោះ</th>
						<th align="center">តួនាទី</th>
						<th></th>
					</tr>
				</thead>
				<tbody data-bind="foreach: Participants">
					<tr>
						<td><input type="text" class="form-control" data-bind="value: name" required /></td>
						<td><input type="text" class="form-control" data-bind="value: position" required /></td>
						<td valign="middle" data-bind="click: $root.deleteParticipant" role="button">
							<span class="material-icons text-danger">delete_outline</span>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3">
							<button class="btn btn-success btn-sm en" data-bind="click: $root.addParticipant">Add Participant</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<br />

		<div data-bind="with: detailModel">
			<table class="table table-bordered">
				<tr class="bg-info">
					<th align="center" width="40">ល.រ</th>
					<th align="center">សំនួរ</th>
					<th align="center">ចម្លើយ</th>
				</tr>
				<tr class="bg-warning">
					<th align="center" width="40">ក</th>
					<th colspan="2">ពិនិត្យឡើងវិញនូវទិន្នន័យជំងឺគ្រុនចាញ់នៅក្នុងប្រព័ន្ធMISក្នុងរយៈពេល ៣ខែចុងក្រោយ ឆ្នាំបច្ចុប្បន្ន និងឆ្នាំមុន ដូចតទៅ (HC+VMW)៖</th>
				</tr>
				<tr data-bind="with: Q1">
					<td align="center">1</td>
					<td>ចំនួនតេស្តគ្រុនចាញ់អវិជ្ជមានសរុប (HC+VMW)</td>
					<td class="form-inline">
						<div class="mb-5">
							<span>សរុប៣ខែឆ្នាំមុន</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: lastYear" />
						</div>
						<div>
							<span>សរុប៣ខែចុងក្រោយ</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: thisYear" />
						</div>
					</td>
				</tr>
				<tr data-bind="with: Q2">
					<td align="center">2</td>
					<td>ចំនួនករណីជំងឺគ្រុនចាញ់គ្រប់ប្រភេទ (HC+VMW)</td>
					<td class="form-inline">
						<div class="mb-5">
							<span>សរុប៣ខែឆ្នាំមុន</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: lastYear" />
						</div>
						<div>
							<span>សរុប៣ខែចុងក្រោយ</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: thisYear" />
						</div>
					</td>
				</tr>
				<tr data-bind="with: Q3">
					<td align="center">3</td>
					<td>ចំនួនករណី Pf (HC+VMW)</td>
					<td class="form-inline">
						<div class="mb-5">
							<span>សរុប៣ខែឆ្នាំមុន</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: lastYear" />
						</div>
						<div>
							<span>សរុប៣ខែចុងក្រោយ</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: thisYear" />
						</div>
					</td>
				</tr>
				<tr data-bind="with: Q4">
					<td align="center">4</td>
					<td>ចំនួនករណី Pv</td>
					<td class="form-inline">
						<div class="mb-5">
							<span>សរុប៣ខែឆ្នាំមុន</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: lastYear" />
						</div>
						<div>
							<span>សរុប៣ខែចុងក្រោយ</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: thisYear" />
						</div>
					</td>
				</tr>
				<tr data-bind="with: Q5">
					<td align="center">5</td>
					<td>ចំនួនករណី Pm/Po/Pk</td>
					<td class="form-inline">
						<div class="mb-5">
							<span>សរុប៣ខែឆ្នាំមុន</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: lastYear" />
						</div>
						<div>
							<span>សរុប៣ខែចុងក្រោយ</span>
							<input type="number" class="form-control input-sm width100" data-bind="value: thisYear" />
						</div>
					</td>
				</tr>
				<tr class="bg-warning">
					<th align="center" width="40">ខ</th>
					<th colspan="2">
						ពិនិត្យជាក់ស្តែងនៅក្នុងបញ្ជីកត់ត្រាជំងឺគ្រុនចាញ់ប្រចាំខែ ក្នុងសៀវភៅគ្រុនចាញ់ (សៀវភៅតារាងស្ថិតិអ្នកជំងឺគ្រុនចាញ់ប្រចាំខែរបស់ HC)
						+ របាយការណ៍ករណីជំងឺគ្រុនចាញ់ប្រចាំខែ VMW
					</th>
				</tr>
				<tr data-bind="with: Q6">
					<td align="center">6</td>
					<td>តើទិន្នន័យក្នុងMIS និងទិន្នន័យជាក់ស្តែងមានចំនួនករណីខុសគ្នាអ្វីខ្លះ?</td>
					<td>
						<textarea class="form-control input-sm" rows="5" data-bind="value: answer"></textarea>
					</td>
				</tr>
				<tr data-bind="with: Q7">
					<td align="center">7</td>
					<td>តើការកត់ត្រាឬបញ្ចូលទិន្នន័យដូចម្តេចដែរ?</td>
					<td>
						<textarea class="form-control input-sm" rows="5" data-bind="value: answer"></textarea>
					</td>
				</tr>
			</table>

			<table class="table table-bordered">
				<tr class="bg-info">
					<th>ល.រ</th>
					<th>សំនួរ</th>
					<th>ចំលើយ</th>
					<th>ពិន្ទុសរុប</th>
					<th>ពិន្ទុ</th>
				</tr>
				<tr class="bg-warning">
					<th colspan="5">
						ផ្នែកទី១៖ ការរាយការណ៍ករណីបន្ទាន់ (Notification) និងចំណាត់ថ្នាក់ករណី (Case Classification) ពិនិត្យ៣ខែចុងក្រោយ (40)
					</th>
				</tr>
				<tr data-bind="with: Q8">
					<td align="center">8</td>
					<td>
						តើមានចំនួនករណីជំងឺគ្រុនចាញ់ (គ្រប់ប្រភេទ) ប៉ុន្មានដែលបានរាយការណ៍ និងចំណាត់ថ្នាក់ករណីក្នុងរយៈពេល២៤ម៉ោង?
						(ចំនួនករណីបានរាយការណ៍២៤ម៉ោងក្នុងMIS ប្រៀបធៀបនឹងករណីសរុប)
					</td>
					<td class="form-inline text-nowrap">
						<span>ករណី២៤ម៉ោង</span>
						<input type="number" class="form-control input-sm width80 text-center" data-bind="value: cases" />
						<span>/ករណីសរុប</span>
						<input type="number" class="form-control input-sm width80 text-center" data-bind="value: total" />
						<span>(</span>
						<input type="number" step="any" class="form-control input-sm width80 text-center" data-bind="value: percent" />
						<span>%)</span>
					</td>
					<td align="center">20</td>
					<td>
						<input type="number" min="0" max="20" class="form-control input-sm width80 text-center" data-bind="textInput: score" />
					</td>
				</tr>
				<tr data-bind="with: Q9">
					<td align="center">9</td>
					<td>
						តើមានករណីចំនួនប៉ុន្មានដែលបានចំណាត់ថ្នាក់លាប់​​​​/រើកើតឡើងវិញ, LA, ID, និងនាំចូល?
						(ប្រៀបធៀបថេប្លេតHC និងរបាយការណ៍HC&VMW)
					</td>
					<td>
						<div class="form-inline text-nowrap mb-5" data-bind="with: tablet">
							<span>ថេប្លេត៖ Rel/Rec</span>
							<input type="number" class="form-control input-sm width80 text-center" data-bind="value: rec" />
							<span>LA</span>
							<input type="number" class="form-control input-sm width80 text-center" data-bind="value: la" />
							<span>ID</span>
							<input type="number" class="form-control input-sm width80 text-center" data-bind="value: id" />
							<span>នាំចូល</span>
							<input type="number" class="form-control input-sm width80 text-center" data-bind="value: imp" />
						</div>
						<div class="form-inline text-nowrap" data-bind="with: paper">
							<span>ឯកសារ៖ Rel/Rec</span>
							<input type="number" class="form-control input-sm width80 text-center" data-bind="value: rec" />
							<span>LA</span>
							<input type="number" class="form-control input-sm width80 text-center" data-bind="value: la" />
							<span>ID</span>
							<input type="number" class="form-control input-sm width80 text-center" data-bind="value: id" />
							<span>នាំចូល</span>
							<input type="number" class="form-control input-sm width80 text-center" data-bind="value: imp" />
						</div>
					</td>
					<td align="center">10</td>
					<td>
						<input type="number" min="0" max="10" class="form-control input-sm width80 text-center" data-bind="textInput: score" />
					</td>
				</tr>
				<tr data-bind="with: Q10">
					<td align="center">10</td>
					<td>
						តើមានករណីជំងឺគ្រុនចាញ់ (Pf+Mix) ប៉ុន្មានដែលបានរាយការណ៍ក្នុងរយៈពេល &lt;២៤ម៉ោង?
						(ចំនួនករណីPf+Mixបានរាយការណ៍២៤ម៉ោងក្នុងMIS ប្រៀបធៀបនឹងករណីPf+Mixសរុប)
					</td>
					<td class="form-inline text-nowrap">
						<span>ករណីPf+Mix២៤ម៉ោង</span>
						<input type="number" class="form-control input-sm width80 text-center" data-bind="value: cases" />
						<span>/ករណីសរុប</span>
						<input type="number" class="form-control input-sm width80 text-center" data-bind="value: total" />
						<span>(</span>
						<input type="number" step="any" class="form-control input-sm width80 text-center" data-bind="value: percent" />
						<span>%)</span>
					</td>
					<td align="center">10</td>
					<td>
						<input type="number" min="0" max="10" class="form-control input-sm width80 text-center" data-bind="textInput: score" />
					</td>
				</tr>
				<tr data-bind="with: Q11">
					<td align="center">11</td>
					<td>
						ហេតុអ្វីបានជាមានករណីរាយការណ៍លើស២៤ម៉ោង? (HC)
						<br /><br />
						<i>(ចម្លើយអាចមានលើសពី១)</i>
					</td>
					<td>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="Q11" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>មិនមានសេវាអ៊ីនធឺណែត</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="Q11" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>ថេប្លេតខូច</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="Q11" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>មិនចេះប្រើ</span>
							</label>
						</div>
						<div class="form-inline" style="margin-left:-5px">
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="Q11" data-bind="checked: tick, checkedValue: $($element).next().text()" />
									<span>ផ្សេងៗ</span>
								</label>
							</div>
							<input type="text" class="form-control input-sm" data-bind="value: other" />
						</div>
					</td>
					<td align="center"></td>
					<td></td>
				</tr>
				<tr class="bg-warning">
					<th colspan="5">
						ផ្នែកទី២៖ ការស្រាវជ្រាវជុំវិញករណីគោល (RACDT) រយៈពេល៣ខែចុងក្រោយ (30)
					</th>
				</tr>
				<tr data-bind="with: Q12">
					<td align="center">12</td>
					<td>
						តើមានករណីជំងឺគ្រុនចាញ់ (គ្រប់ប្រភេទ) ចំនួនប៉ុន្មានដែលបានចុះស្រាវជ្រាវជុំវិញករណីគោល(RACDT) រយៈពេល &lt;៧២ម៉ោង?
						<br />
						<i>(ពិនិត្យទិន្នន័យក្នុងថេប្លេតHC)</i>
					</td>
					<td class="form-inline text-nowrap">
						<span>ករណីRACDTក្នុង៧២ម៉ោង</span>
						<input type="number" class="form-control input-sm width80 text-center" data-bind="value: cases" />
						<span>/ករណីសរុប</span>
						<input type="number" class="form-control input-sm width80 text-center" data-bind="value: total" />
						<span>(</span>
						<input type="number" step="any" class="form-control input-sm width80 text-center" data-bind="value: percent" />
						<span>%)</span>
					</td>
					<td align="center">15</td>
					<td>
						<input type="number" min="0" max="15" class="form-control input-sm width80 text-center" data-bind="textInput: score" />
					</td>
				</tr>
				<tr data-bind="with: Q13">
					<td align="center">13</td>
					<td>
						តើមានករណីជំងឺគ្រុនចាញ់ (Pf+Mix) ចំនួនប៉ុន្មានដែលបានចុះស្រាវជ្រាវជុំវិញករណីគោល(RACDT) រយៈពេល &lt;៧២ម៉ោង?
						<br />
						<i>(ពិនិត្យទិន្នន័យក្នុងថេប្លេតHC)</i>
					</td>
					<td class="form-inline text-nowrap">
						<span>ករណីRACDTក្នុង៧២ម៉ោង</span>
						<input type="number" class="form-control input-sm width80 text-center" data-bind="value: cases" />
						<span>/ករណីសរុប</span>
						<input type="number" class="form-control input-sm width80 text-center" data-bind="value: total" />
						<span>(</span>
						<input type="number" step="any" class="form-control input-sm width80 text-center" data-bind="value: percent" />
						<span>%)</span>
					</td>
					<td align="center">15</td>
					<td>
						<input type="number" min="0" max="15" class="form-control input-sm width80 text-center" data-bind="textInput: score" />
					</td>
				</tr>
				<tr data-bind="with: Q14">
					<td align="center">14</td>
					<td>
						ហេតុអ្វីបានជាមានករណីមិនទាន់ចុះស្រាវជ្រាវជុំវិញករណីគោល?
						<br /><br />
						<i>
							(យោងតាមសំណួរទី7.1)
							<br />
							(ចម្លើយអាចមានលើសពី១)
						</i>
					</td>
					<td>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="Q14" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>ភូមិឆ្ងាយ</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="Q14" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>មិនមានបុគ្គលិកគ្រប់គ្រាន់</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="Q14" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>អ្នកជំងឺជាអ្នកឆ្លងកាត់តំបន់</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="Q14" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>មិនបានរាយការណ៍ទាន់ពេលពីអ្នកស្ម័គ្រចិត្ត</span>
							</label>
						</div>
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" name="Q14" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>រងចាំបញ្ជាពីOD</span>
							</label>
						</div>
						<div class="form-inline" style="margin-left:-5px">
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="Q14" data-bind="checked: tick, checkedValue: $($element).next().text()" />
									<span>ផ្សេងៗ</span>
								</label>
							</div>
							<input type="text" class="form-control input-sm" data-bind="value: other" />
						</div>
					</td>
					<td align="center"></td>
					<td></td>
				</tr>
				<tr class="bg-warning">
					<th colspan="5">
						ផ្នែកទី៣៖ ការអង្កេតសំបុកចម្លង (Foci Investigation) រយៈពេល១ឆ្នាំកន្លង (30)
					</th>
				</tr>
				<tr data-bind="with: Q15">
					<td align="center">15</td>
					<td>
						តើមានករណីPf+Mix L1 ចំនួនប៉ុន្មានដែលបានធ្វើការអង្កេតសំបុកចម្លង?
						<br />
						<i>(ផ្ទៀងផ្ទាត់ឯកសារមានករណីមិនទាន់ចុះអង្កេតនៅOD និងMIS)</i>
					</td>
					<td>
						<div style="margin-left:-5px">
							<div class="form-inline mb-5">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q15" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>ក្រោម៧ថ្ងៃ</span>
									</label>
								</div>
								<span>ចំនួន</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: a.qty" />
								<span>=</span>
								<input type="number" step="any" class="form-control input-sm width80 text-center" data-bind="value: a.percent" />
								<span>%</span>
							</div>
							<div class="form-inline mb-5">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q15" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>លើស៧ថ្ងៃ</span>
									</label>
								</div>
								<span>ចំនួន</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: b.qty" />
								<span>=</span>
								<input type="number" step="any" class="form-control input-sm width80 text-center" data-bind="value: b.percent" />
								<span>%</span>
							</div>
							<div class="form-inline mb-5">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q15" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>មិនបានធ្វើ</span>
									</label>
								</div>
								<span>ចំនួន</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: c.qty" />
								<span>=</span>
								<input type="number" step="any" class="form-control input-sm width80 text-center" data-bind="value: c.percent" />
								<span>%</span>
							</div>
							<div class="form-inline">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q15" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>មិនមានករណីត្រូវឆ្លើយតប</span>
									</label>
								</div>
								<span>(បានពិន្ទុពេញ)</span>
							</div>
						</div>
					</td>
					<td align="center">15</td>
					<td>
						<input type="number" min="0" max="15" class="form-control input-sm width80 text-center" data-bind="textInput: score" />
					</td>
				</tr>
				<tr data-bind="with: Q16">
					<td align="center">16</td>
					<td>
						ហេតុអ្វីបានជាមានករណីមិនទាន់ចុះអង្កេតសំបុកម្លង?
					</td>
					<td>
						<div class="radio radio-lg">
							<label>
								<input type="radio" name="Q16" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>ភូមិឆ្ងាយ</span>
							</label>
						</div>
						<div class="radio radio-lg">
							<label>
								<input type="radio" name="Q16" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>មិនមានបុគ្គលិកគ្រប់គ្រាន់</span>
							</label>
						</div>
						<div class="radio radio-lg">
							<label>
								<input type="radio" name="Q16" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>អ្នកជំងឺជាអ្នកឆ្លងកាត់តំបន់</span>
							</label>
						</div>
						<div class="radio radio-lg">
							<label>
								<input type="radio" name="Q16" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>មិនបានរាយការណ៍ទាន់ពេលពីអ្នកស្ម័គ្រចិត្ត</span>
							</label>
						</div>
						<div class="radio radio-lg">
							<label>
								<input type="radio" name="Q16" data-bind="checked: tick, checkedValue: $($element).next().text()" />
								<span>រងចាំបញ្ជាពីPHD</span>
							</label>
						</div>
						<div class="form-inline" style="margin-left:-5px">
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="Q16" data-bind="checked: tick, checkedValue: $($element).next().text()" />
									<span>ផ្សេងៗ</span>
								</label>
							</div>
							<input type="text" class="form-control input-sm" data-bind="value: other" />
						</div>
					</td>
					<td align="center"></td>
					<td></td>
				</tr>
				<tr data-bind="with: Q17">
					<td align="center">17</td>
					<td>
						ការឆ្លើយតបសំបុកចម្លងសកម្ម ក្រោយពេលអង្កេតសំបុកចម្លង៖
					</td>
					<td>
						<div style="margin-left:-5px">
							<div class="form-inline mb-5 text-nowrap">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q17" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>ការចូលរួមរបស់ប្រជាជនក្នុងសហគមន៍ (CE)</span>
									</label>
								</div>
								<span>ចំនួន</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: ce" />
								<span>ភូមិ</span>
							</div>
							<div class="form-inline mb-5">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q17" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>ជំរឿន (Census)</span>
									</label>
								</div>
								<span>ចំនួន</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: census" />
								<span>ភូមិ</span>
							</div>
							<div class="form-inline mb-5 text-nowrap">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q17" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>VMW/MMWs</span>
									</label>
								</div>
								<span>ជ្រើសរើសVMW/MMWs បើសិនភូមិមិនទាន់មានVMW/MMWs ចំនួន៖</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: vmw" />
								<span>ភូមិ</span>
							</div>
							<div class="form-inline mb-5 text-nowrap">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q17" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>ITN/Forest Pack</span>
									</label>
								</div>
								<span>ចែកមុងបំពេញបន្ថែមចំនួន៖</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: itn" />
								<span>ភូមិ</span>
							</div>
							<div class="form-inline mb-5 text-nowrap">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q17" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>AFS</span>
									</label>
								</div>
								<span>ការចុះពិនិត្យស្រាវជ្រាវរកគ្រុនចាញ់ក្តៅពីផ្ទះមួយទៅផ្ទះមួយប្រចាំសប្តាហ៍ចំនួន៖</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: afs" />
								<span>ភូមិ</span>
							</div>
							<div class="form-inline mb-5 text-nowrap">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q17" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>TDA</span>
									</label>
								</div>
								<span>ផ្តល់ថ្នាំសម្រាប់ប្រជាជនគោលដៅ ចំពោះតែបុរសអាយុចាប់ពី១៥-៤៩ឆ្នាំចំនួន៖</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: tda" />
								<span>ភូមិ</span>
							</div>
							<div class="form-inline mb-5 text-nowrap">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q17" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>IPTf</span>
									</label>
								</div>
								<span>សម្រាប់ការលេបថ្នាំការពារជាមុន (IPT) សម្រាប់អ្នកចូលព្រៃចំនួន៖</span>
								<input type="number" class="form-control input-sm width80 text-center" data-bind="value: ipt" />
								<span>ភូមិ</span>
							</div>
							<div class="form-inline text-nowrap">
								<div class="radio radio-lg">
									<label>
										<input type="radio" name="Q17" data-bind="checked: tick, checkedValue: $($element).next().text()" />
										<span>ផ្សេងៗ</span>
									</label>
								</div>
								<input type="text" class="form-control input-sm" data-bind="value: other" />
							</div>
						</div>
					</td>
					<td align="center">15</td>
					<td>
						<input type="number" min="0" max="15" class="form-control input-sm width80 text-center" data-bind="textInput: score" />
					</td>
				</tr>
			</table>
			<br />

			<b>សំណូមពរទូទៅ៖</b>
			<textarea class="form-control" rows="8" data-bind="value: Q18.answer"></textarea>
			<br />

			<table class="table table-bordered form-group">
				<thead class="bg-info">
					<tr>
						<th colspan="4">ពិន្ទុសរុបតាមផ្នែកនីមួយៗ</th>
					</tr>
					<tr>
						<th>ផ្នែក</th>
						<th align="center">ពិន្ទុសរុបតាមផ្នែក</th>
						<th align="center">ពិន្ទុទទួលបាន</th>
						<th align="center">មធ្យមភាគ</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>ផ្នែកទី១៖ ការរាយការណ៍ និងចំណាត់ថ្នាក់ករណី</td>
						<td align="center">40</td>
						<td align="center" data-bind="text: $root.totalScore(1)"></td>
						<td align="center" data-bind="text: $root.percent(1,40)"></td>
					</tr>
					<tr>
						<td>ផ្នែកទី២៖ ការស្រាវជ្រាវជុំវិញករណីគោល</td>
						<td align="center">30</td>
						<td align="center" data-bind="text: $root.totalScore(2)"></td>
						<td align="center" data-bind="text: $root.percent(2,30)"></td>
					</tr>
					<tr>
						<td>ផ្នែកទី៣៖ ការអង្គេតសំបុកចម្លង</td>
						<td align="center">30</td>
						<td align="center" data-bind="text: $root.totalScore(3)"></td>
						<td align="center" data-bind="text: $root.percent(3,30)"></td>
					</tr>
					<tr>
						<td>ពិន្ទុសរុប៖</td>
						<td align="center">100</td>
						<td align="center" data-bind="text: $root.totalScore('all')"></td>
						<td align="center" data-bind="text: $root.percent('all',100)"></td>
					</tr>
				</tbody>
			</table>

			<table class="table">
				<tr>
					<td width="200">១. ពិន្ទុមធ្យមភាគ &le; 49%</td>
					<td>ក្រុមអភិបាលត្រូវ៖ ត្រឡប់ទៅអភិបាលវិញនៅ(១)ខែបន្ទាប់</td>
				</tr>
				<tr>
					<td>២. ពិន្ទុមធ្យមភាគ 50-79%</td>
					<td>ក្រុមអភិបាលត្រូវ៖ ត្រឡប់ទៅអភិបាលវិញនៅ(៣ខែ)ត្រីមាសបន្ទាប់</td>
				</tr>
				<tr>
					<td>៣. ពិន្ទុមធ្យមភាគ &ge; 80%</td>
					<td>ក្រុមអភិបាលត្រូវ៖ ត្រឡប់ទៅអភិបាលវិញនៅ(៦ខែ)ឆមាសបន្ទាប់</td>
				</tr>
			</table>

		</div>
	</form>
</div>

<?=latestJs('/media/ViewModel/Checklist_Surv.js')?>
