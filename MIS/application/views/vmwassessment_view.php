
<style>
	#detail .input-group-addon { width: 115px !important; text-align: left; }
</style>

<div class="panel panel-default" data-bind="visible: view() == 'list'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left" style="display:flex; gap:5px;">
			<div class="input-group">
				<span class="input-group-addon">Province</span>
				<select class="form-control minwidth100" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">OD</span>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">HC</span>
				<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-success width80" data-bind="click: exportExcel">Export</button>
			<button class="btn btn-primary width80" data-bind="click: showNew">New</button>
			<a href="/home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center">Province</th>
					<th align="center">OD</th>
					<th align="center">HC</th>
					<th align="center">Village</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel(), fixedHeader: true">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div id="detail" class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-right" style="position: sticky; right: 10px;">
			<button class="btn btn-primary width80" form="myform">Save</button>
			<button class="btn btn-default width80" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<div class="kh" style="width:1000px; margin:auto;">
			<h3 class="text-center text-primary">
				កម្រងសំណួរវាយតម្លៃរហ័ស VMW/MMW 2024
			</h3>
			<br />

			<div class="font16" style="padding:10px; border:1px solid">
				<h4>
					<b>គោលបំណង៖</b>
				</h4>
				គោលបំណងរបស់ការវាយតម្លៃរហ័សនេះ គឺដើម្បីប្រមូលនូវព័ត៌មានទូទៅ និងជំនាញរបស់ VMW/MMW។
				<br />
				<br />
				<h4>
					<b>វិធីសាស្រ្តប្រមូលទិន្នន័យ ៖</b>
				</h4>
				ការសិក្សានេះ នឹងត្រូវបំពេញដោយVMW/MMW  និងសមាហរណកម្មVMW/MMW នៅលើប្រព័ន្ធ MIS ក្នុងអំឡុងពេលប្រជុំប្រចាំខែ/ត្រីមាសនៅមណ្ឌលសុខភាព។
				<br />
				ការសិក្សានេះនឹងប្រើពេលវេលាតិចជាង 10 នាទីប៉ុណ្ណោះក្នុងVMW/MMW ម្នាក់ៗ។ បុគ្គលិកមណ្ឌលសុខភាព និងអង្គការដៃគូ នឹងជួយសម្របសម្រួលការងារនេះ
				<br /> ដើម្បីធានាថា គ្រប់ VMW/MMW បានបំពេញកម្រងសំណួរនេះ។
			</div>
			<br />

			<form id="myform" data-bind="submit: save">
				<table class="table table-bordered" data-bind="with: masterModel">
					<tr class="bg-warning">
						<th colspan="3">កម្រងសំណួរវាយតម្លៃរហ័ស</th>
					</tr>
					<tr>
						<td align="center" class="en">1</td>
						<th>ទីតាំងរបស់ VMW/MMW</th>
						<td>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">A. ខេត្ត</span>
									<select data-bind="value: Code_Prov_N,
									options: pvList,
									optionsValue: 'code',
									optionsText: 'name',
									optionsCaption: ''"
										class="form-control minwidth150" required></select>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">B. ស្រុកប្រតិបត្តិ</span>
									<select data-bind="value: Code_OD_T,
									options: odList(),
									optionsValue: 'code',
									optionsText: 'name',
									optionsCaption: ''"
										class="form-control minwidth150" required></select>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">C. មណ្ឌលសុខភាព</span>
									<select data-bind="value: Code_Facility_T,
									options: hcList(),
									optionsValue: 'code',
									optionsText: 'name',
									optionsCaption: ''"
										class="form-control minwidth150" required></select>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">D. ភូមិ</span>
									<select data-bind="value: Code_Vill_T,
									options: vlList(),
									optionsValue: 'code',
									optionsText: 'name',
									optionsCaption: ''"
										class="form-control minwidth150" required></select>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">2</td>
						<th>ឈ្មោះ VMW/MMW</th>
						<td>
							<input type="text" class="form-control" data-bind="value: VMWName" required />
						</td>
					</tr>
					<tr>
						<td align="center">3</td>
						<th>តួនាទី VMW/MMW</th>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="3" value="VMW/MMW ចម្បង" data-bind="checked: $root.getAnswer($element)" required />
									<span>VMW/MMW ចម្បង</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="3" value="ជំនួយការ VMW/MMW" data-bind="checked: $root.getAnswer($element)" />
									<span>ជំនួយការ VMW/MMW</span>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">4</td>
						<th>ប្រភេទអ្នកស្ម័គ្រចិត្ត </th>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="4" value="VMW" data-bind="checked: $root.getAnswer($element)" required />
									<span>VMW</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="4" value="MMW" data-bind="checked: $root.getAnswer($element)" />
									<span>MMW</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="4" value="សមាហរណកម្ម VMW" data-bind="checked: $root.getAnswer($element)" />
									<span>សមាហរណកម្ម VMW</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="4" value="សមាហរណកម្ម MMW" data-bind="checked: $root.getAnswer($element)" />
									<span>សមាហរណកម្ម MMW</span>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">5</td>
						<th>ប្រភេទភូមិ VMW/MMW </th>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="5" value="ភូមិរដ្ឋបាល" data-bind="checked: $root.getAnswer($element)" required />
									<span>ភូមិរដ្ឋបាល</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="5" value="ភូមិឧបសម្ព័ន្ធ" data-bind="checked: $root.getAnswer($element)" />
									<span>ភូមិឧបសម្ព័ន្ធ</span>
								</label>
							</div>
							<div class="form-inline" style="margin-top:5px">
								<div class="radio-inline radio-lg">
									<label>
										<input type="radio" name="5" value="ផ្សេងៗ" data-bind="checked: $root.getAnswer($element)" />
										<span>ផ្សេងៗ៖</span>
									</label>
								</div>
								<input type="text" class="form-control input-sm" name="5.Other" data-bind="value: $root.getAnswer($element)" />
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">6</td>
						<th>ភេទ</th>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="6" value="ប្រុស" data-bind="checked: $root.getAnswer($element)" required />
									<span>ប្រុស</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="6" value="ស្រី" data-bind="checked: $root.getAnswer($element)" />
									<span>ស្រី</span>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">7</td>
						<th>អាយុ </th>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="7" value="តិចជាង 18 ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" required />
									<span>តិចជាង 18 ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="7" value="18 – 29 ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" />
									<span>18 – 29 ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="7" value="30 – 44 ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" />
									<span>30 – 44 ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="7" value="45 – 59 ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" />
									<span>45 – 59 ឆ្ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="7" value="ចាប់ពី 60 ឡើង" data-bind="checked: $root.getAnswer($element)" />
									<span>ចាប់ពី 60 ឡើង</span>
								</label>
							</div>
						</td>
					</tr>

					<tr>
						<td align="center">8</td>
						<th>កម្រិតវប្បធម៌  </th>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="8" value="មិនបានសិក្សា" data-bind="checked: $root.getAnswer($element)" required />
									<span>មិនបានសិក្សា</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="8" value="ថ្នាក់បឋមសិក្សា" data-bind="checked: $root.getAnswer($element)" />
									<span>ថ្នាក់បឋមសិក្សា</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="8" value="អនុវិទ្យាល័យ" data-bind="checked: $root.getAnswer($element)" />
									<span>អនុវិទ្យាល័យ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="8" value="វិទ្យាល័យ" data-bind="checked: $root.getAnswer($element)" />
									<span>វិទ្យាល័យ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="8" value="បរិញ្ញាប័ត្រ" data-bind="checked: $root.getAnswer($element)" />
									<span>បរិញ្ញាប័ត្រ</span>
								</label>
							</div>
						</td>
					</tr>

					<tr>
						<td align="center">9</td>
						<th>តើរយៈពេលប៉ុន្មានដែលអ្នកបានធ្វើជា VMW/MMW?</th>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="9" value="តិចជាង 2ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" required />
									<span>តិចជាង 2ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="9" value="2 – 5 ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" />
									<span>2 – 5 ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="9" value="6 – 9 ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" />
									<span>6 – 9 ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="9" value="ចាប់ពី 10 ឆ្នាំ ឡើង" data-bind="checked: $root.getAnswer($element)" />
									<span>ចាប់ពី 10 ឆ្នាំ ឡើង</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="9" value="ចាប់ពីពេលកម្មវិធី VMW/MMW ចាប់ផ្តើម (តាំងពីឆ្នាំ 2004)" data-bind="checked: $root.getAnswer($element)" />
									<span>ចាប់ពីពេលកម្មវិធី VMW/MMW ចាប់ផ្តើម (តាំងពីឆ្នាំ 2004)</span>
								</label>
							</div>
						</td>
					</tr>

					<tr>
						<td align="center">10</td>
						<td>
							<b>ក្នុងនាមជា VMW/MMW តើអ្វីជាតួនាទីរបស់អ្នកនៅក្នុងសហគមន៍?</b>
							<br />
							<br />
							<i>(អាចជ្រើសរើសចម្លើយបានច្រើន)</i>
						</td>
						<td>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="ធ្វើតេស្តស្វែងរកជំងឺគ្រុនចាញ់ដោយ តេស្តរហ័ស (RDT)" data-bind="checked: $root.getAnswer($element)" />
									<span>ធ្វើតេស្តស្វែងរកជំងឺគ្រុនចាញ់ដោយ តេស្តរហ័ស (RDT)</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="ផ្តល់ការព្យាបាលជំងឺគ្រុនចាញ់ (ជំងឺគ្រុនចាញ់ស្រាល)" data-bind="checked: $root.getAnswer($element)" />
									<span>ផ្តល់ការព្យាបាលជំងឺគ្រុនចាញ់ (ជំងឺគ្រុនចាញ់ស្រាល)</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាព (ឧ. ព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់ ជំងឺគ្រុនចាញ់ធ្ងន់ធ្ងរ និងករណីសង្ស័យជំងឺគ្រុនចាញ់)" data-bind="checked: $root.getAnswer($element)" />
									<span>បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាព (ឧ. ព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់ ជំងឺគ្រុនចាញ់ធ្ងន់ធ្ងរ និងករណីសង្ស័យជំងឺគ្រុនចាញ់)</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="ការកៀរគរសហគមន៍" data-bind="checked: $root.getAnswer($element)" />
									<span>ការកៀរគរសហគមន៍</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="ផ្តល់សារអប់រំសុខភាព" data-bind="checked: $root.getAnswer($element)" />
									<span>ផ្តល់សារអប់រំសុខភាព</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="តាមដានអ្នកជំងឺព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់ជំងឺគ្រុនចាញ់វីវ៉ាក់" data-bind="checked: $root.getAnswer($element)" />
									<span>តាមដានអ្នកជំងឺព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់ជំងឺគ្រុនចាញ់វីវ៉ាក់</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="ផ្តល់ដំណឹងករណីជំងឺគ្រុនចាញ់ / បញ្ចូលព័ត៌មានអ្នកជំងឺតាមរយៈទូរស័ព្ទ" data-bind="checked: $root.getAnswer($element)" />
									<span>ផ្តល់ដំណឹងករណីជំងឺគ្រុនចាញ់ / បញ្ចូលព័ត៌មានអ្នកជំងឺតាមរយៈទូរស័ព្ទ</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="ប្រមូលសំណាកកញ្ចក់ឈាមសម្រាប់កម្មវិធី iDES" data-bind="checked: $root.getAnswer($element)" />
									<span>ប្រមូលសំណាកកញ្ចក់ឈាមសម្រាប់កម្មវិធី iDES</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="កំណត់អត្តសញ្ញាណប្រជាជននៅក្នុងសហគមន៍ដែលប្រឈមនឹងជំងឺគ្រុនចាញ់" data-bind="checked: $root.getAnswer($element)" />
									<span>កំណត់អត្តសញ្ញាណប្រជាជននៅក្នុងសហគមន៍ដែលប្រឈមនឹងជំងឺគ្រុនចាញ់</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="10" value="ផ្សេងៗ" data-bind="checked: $root.getAnswer($element)" />
									<span>ផ្សេងៗ៖</span>
								</label>
							</div>
							<input type="text" class="form-control input-sm" name="10.Other" data-bind="value: $root.getAnswer($element)" />
						</td>
					</tr>

					<tr>
						<td align="center">11</td>
						<td>
							<b>ក្រៅពីជា VMW/MMW តើអ្នកកំពុងតែបំរើការងារដ៏ទៃផ្សេងទៀតនៅក្នុងសហគមន៍ដែរ ឬទេ?</b>
							<br />
							<br />
							<i>(អាចជ្រើសរើសចម្លើយបានច្រើន)៖ </i>
						</td>
						<td>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="ទេ" data-bind="checked: $root.getAnswer($element)" />
									<span>ទេ</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" id="vhsg" name="11" value="បាទ/ចាស៎! ជា VHSG" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា VHSG</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា មេឃុំ" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា មេឃុំ</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា មេភូមិ" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា មេភូមិ</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា អនុភូមិ" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា អនុភូមិ</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា គ្រូបង្រៀនកុមារនៅក្នុងសហគមន៍" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា គ្រូបង្រៀនកុមារនៅក្នុងសហគមន៍</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តជំងឺរបេង" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តជំងឺរបេង</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តកាកបាទក្រហម" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តកាកបាទក្រហម</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តអាហាររូបត្ថម្ភ" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តអាហាររូបត្ថម្ភ</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តជំងឺអេដស៍" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តជំងឺអេដស៍</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តគាំពារមាតា និងទារក" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តគាំពារមាតា និងទារក</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា ឆ្មបបុរាណ" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា ឆ្មបបុរាណ</span>
								</label>
							</div>
							<div class="checkbox checkbox-lg">
								<label>
									<input type="checkbox" name="11" value="បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តផ្សេងទៀត" data-bind="checked: $root.getAnswer($element)" />
									<span>បាទ/ចាស៎! ជា អ្នកស័្មគ្រចិត្តផ្សេងទៀត(សូមសរសេរ)៖ </span>
								</label>
							</div>
							<input type="text" class="form-control input-sm" name="11.Other" data-bind="value: $root.getAnswer($element)" />
						</td>
					</tr>

					<tr>
						<td align="center">12</td>
						<td>
							<b>តើរយៈពេលប៉ុន្មានដែលអ្នកបានធ្វើជា VHSG នេះ?</b>
							<br />
							<br />
							<i>ចំណាំ៖ (សូមរំលង ប្រសិនបើ ទេ នៅចម្លើយសំណួរទី 11)</i>
						</td>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="12" value="តិចជាង 2ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" />
									<span>តិចជាង 2ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="12" value="2 – 5 ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" />
									<span>2 – 5 ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="12" value="6 – 9 ឆ្នាំ" data-bind="checked: $root.getAnswer($element)" />
									<span>6 – 9 ឆ្នាំ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="12" value="ចាប់ពី 10 ឆ្នាំ ឡើង" data-bind="checked: $root.getAnswer($element)" />
									<span>ចាប់ពី 10 ឆ្នាំ ឡើង</span>
								</label>
							</div>
						</td>
					</tr>

					<tr>
						<td align="center">13</td>
						<th>តើមានអ្នកដ៏ទៃទៀត ដែលកំពុងបំរើការងារជា VHSG នៅក្នុងភូមិរបស់អ្នកដែរ ឬទេ?</th>
						<td>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="13" value="បាទ/ចាស៎" data-bind="checked: $root.getAnswer($element)" required />
									<span>បាទ/ចាស៎</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="13" value="ទេ" data-bind="checked: $root.getAnswer($element)" />
									<span>ទេ</span>
								</label>
							</div>
							<div class="radio radio-lg">
								<label>
									<input type="radio" name="13" value="មិនដឹង" data-bind="checked: $root.getAnswer($element)" />
									<span>មិនដឹង</span>
								</label>
							</div>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>



<?=latestJs('/media/ViewModel/Checklist_CMEP_PPM.js')?>

<?=latestJs('/media/viewModel/VMWAssessment.js')?>