<!-- ko with: foci1 -->
<div class="panel panel-default" data-bind="visible: $root.view() == 'detail1'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: save, visible: app.user.permiss['Foci Investigation'].contain('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body inlineblock" data-bind="with: detailModel">
		<h3 class="kh text-center">ទម្រង់អង្គេតទីតាំងសំបុកចម្លង</h3>
		<h4 class="text-center">FOCI INVESTIGATION FORM</h4>
		<br /><br />
		<div class="form-group form-inline">
			<div class="form-group">
				<kh>ឈ្មោះអ្នកអង្គេត</kh>
				<input type="text" data-bind="value: Investigator" class="form-control font16" />
			</div>
			<div class="form-group">
				<kh class="space">ទូរស័ព្ទ</kh>
				<input type="text" data-bind="value: Phone" class="form-control font16 width150" numonly="int" maxlength="10" />
			</div>
		</div>
		<div class="form-group form-inline">
			<div class="form-group">
				<kh>ខេត្ត</kh>
				<select data-bind="value: Code_Prov_N,
						options: $parent.getDetailPVList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh"></select>
			</div>
			
			<div class="form-group">
				<kh>ស្រុកប្រតិបត្តិ</kh>
				<select data-bind="value: Code_OD_T,
						options: $parent.getDetailODList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh"></select>
			</div>

			<div class="form-group">
				<kh class="space">មណ្ឌលសុខភាព</kh>
				<select data-bind="value: Code_Facility_T,
						options: $parent.getDetailHCList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh"></select>
			</div>

			<div class="form-group">
				<kh class="space">ឈ្មោះភូមិ</kh>
				<select data-bind="value: Code_Vill_T,
						options: $parent.getDetailVLList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''" class="form-control minwidth150 kh"></select>
			</div>
		</div>
		<div class="form-group form-inline" data-bind="with: $parent.fociCode">
			<kh>លេខកូដសម្គាល់សំបុកចម្លងគ្រុនចាញ់</kh>
			<div class="form-group">
				<input type="text" data-bind="value: vv" class="form-control text-center" style="width:34px" placeholder="VV" numonly="int" maxlength="2" />
			</div>
			<span>/</span>
			<div class="form-group">
				<input type="text" data-bind="value: cc" class="form-control text-center" style="width:34px" placeholder="CC" numonly="int" maxlength="2" />
			</div>
			<span>/</span>
			<div class="form-group">
				<input type="text" data-bind="value: dd" class="form-control text-center" style="width:34px" placeholder="DD" numonly="int" maxlength="2" />
			</div>
			<span>/</span>
			<div class="form-group">
				<input type="text" data-bind="value: pp" class="form-control text-center" style="width:34px" placeholder="PP" numonly="int" maxlength="2" />
			</div>
			<span>/</span>
			<div class="form-group">
				<input type="text" data-bind="value: yyyy" class="form-control text-center" style="width:50px" placeholder="YYYY" numonly="int" maxlength="4" />
			</div>
			<span>(VV/CC/DD/PP/YYYY)</span>
		</div>
		<div class="form-group form-inline relative">
			<kh>ថ្ងៃចុះអង្គេតសំបុកចម្លង</kh>
			<div class="form-group">
				<input data-bind="datePicker: FociInvestigationDate" type="text" class="form-control text-center" style="width:120px" placeholder="DD-MM-YYYY" />
			</div>
			<kh>(ថ្ងៃ-ខែ-ឆ្នាំ)</kh>
		</div>
		<br />
		<p class="text-bold"><kh>1- ការពិនិត្យទិន្ន័យ</kh> (DESK REVIEW)</p>
		<p class="kh">ករណី ហ្វាល់ស៊ីប៉ារូមឬចំរុះក្នុងភូមិដែលបានកត់ត្រាក្នុងប្រព័ន្ធ MIS ក្នុងរយៈពេល១២ខែកន្លងមក៖</p>
		<table class="table table-bordered widthauto">
			<thead>
				<tr>
					<th align="center" rowspan="2"><kh>ល.រ</kh></th>
					<th align="center" rowspan="2" style="min-width:250px"><kh>ឈ្មោះ</kh></th>
					<th align="center" rowspan="2" width="50"><kh>អាយុ</kh></th>
					<th align="center" rowspan="2" width="50"><kh>ភេទ</kh></th>
					<th align="center" colspan="6"><kh>ចំណាត់ថ្នាក់ករណី</kh></th>
					<th align="center" colspan="2"><kh>រោគវិនិច្ឆ័យ</kh></th>
				</tr>
				<tr>
					<th align="center" width="40">L1</th>
					<th align="center" width="40">L2</th>
					<th align="center" width="40">L3</th>
					<th align="center" width="40">L4</th>
					<th align="center" width="40">IMP</th>
					<th align="center" class="kh">មិនបានធ្វើចំណាត់ថ្នាក់</th>
					<th align="center" class="kh">ថ្ងៃធ្វើ</th>
					<th align="center" class="kh">កន្លែងធ្វើ</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: $parent.patientList, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Name" class="kh"></td>
					<td data-bind="text: Age" align="center"></td>
					<td data-bind="text: Sex == 'M' ? 'ប្រុស' : 'ស្រី'" align="center" class="kh"></td>
					<td data-bind="text: L1 == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: L2 == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: L3 == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: L4 == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: Imp == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: NoGrade == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: moment(DateCase).format('DD-MM-YYYY')"></td>
					<td data-bind="text: $root.foci1.getPlaceName(PlaceCode)" class="kh"></td>
				</tr>
			</tbody>
			<tfoot data-bind="foreach: $parent.patientList().length > 4 ? [] : Array(5 - $parent.patientList().length)">
				<tr data-bind="foreach: Array(12)">
					<td>&nbsp;</td>
				</tr>
			</tfoot>
		</table>
		<br />
		<p class="text-bold"><kh>អន្តរាគមន៍កំចាត់ភ្នាក់ងារចម្លង</kh> (Vector Control Interventions):</p>
		<table class="table table-bordered widthauto" data-bind="with: $parent">
			<tr>
				<th><kh>យុទ្ធនាការចែកមុងជ្រលក់ថ្នាំក្នុងអំឡុងពេល៣ឆ្នាំចុងក្រោយ</kh> (Mass distribution in last 3 years)</th>
				<th align="center" class="kh" width="100">ចំនួន</th>
			</tr>
			<tr>
				<td><kh>ចំនួនមុងគ្រែបានចែក</kh> (Number of LLINs distributed)</td>
				<td data-bind="text: isnot(bednet(), null, r => r.y3llin)" align="center"></td>
			</tr>
			<tr>
				<td><kh>ចំនួនមុងអង្រឹងបានចែក</kh> (Number of LLIHNs distributed)</td>
				<td data-bind="text: isnot(bednet(), null, r => r.y3llihn)" align="center"></td>
			</tr>
			<tr>
				<th colspan="2"><kh>ការចែកមុងជ្រលក់ថ្នាំបន្តក្នុងអំឡុងពេល១២ខែចុងក្រោយ</kh> (Continuous distribution in last 12 months)</th>
			</tr>
			<tr>
				<td><kh>ចំនួនមុងគ្រែបានចែក</kh> (Number of LLINs distributed)</td>
				<td data-bind="text: isnot(bednet(), null, r => r.y1llin)" align="center"></td>
			</tr>
			<tr>
				<td><kh>ចំនួនមុងអង្រឹងបានចែក</kh> (Number of LLIHNs distributed)</td>
				<td data-bind="text: isnot(bednet(), null, r => r.y1llihn)" align="center"></td>
			</tr>
		</table>
		<br />
		<p class="kh text-bold">សាវតានៃករណីគ្រុនចាញ់ឆ្លងនៅនឹងកន្លែង (L1) ចុងក្រោយ ដែលស្រង់ចេញពីទម្រង់អង្គេតក្នុងប្រព័ន្ធ MIS</p>
		<p class="text-bold">(Profile of last L1 case extracted from MIS - Investigation form)</p>
		<table class="table table-bordered widthauto" data-bind="with: $parent">
			<tr>
				<th class="kh">ឈ្មោះ</th>
				<td data-bind="text: isnot(profile(), null, r => r.Name_K)" class="kh minwidth100" align="center"></td>
				<th class="kh">អាយុ</th>
				<td data-bind="text: isnot(profile(), null, r => r.Age)" class="minwidth100" align="center"></td>
			</tr>
			<tr>
				<th class="kh">ភេទ</th>
				<td data-bind="text: isnot(profile(), null, r => r.Gender == 'M' ? 'ប្រុស' : 'ស្រី')" align="center" class="kh"></td>
				<th class="kh">មុខរបរ</th>
				<td data-bind="text: isnot(profile(), null, r => r.Job)" align="center" class="kh"></td>
			</tr>
			<tr>
				<th class="kh">អាស័យដ្ឋានបច្ចុប្បន្ន</th>
				<td colspan="3" data-bind="with: profile">
					<kh data-bind="text: Address"></kh>
				</td>
			</tr>
			<tr>
				<th class="kh">កន្លែងធ្វើរោគវិនិច្ឆ័យ</th>
				<td data-bind="text: isnot(profile(), null, r => r.DiagnosisPlace)" align="center" class="kh"></td>
				<th class="kh">រយៈពេលពីរោគសញ្ញាដល់ពេលធ្វើរោគវិនិច្ឆ័យ</th>
				<td data-bind="with: profile" align="center">
					<span data-bind="text: DiagnosisDuration"></span>
					<kh>ថ្ងៃ</kh>
				</td>
			</tr>
			<tr>
				<th class="kh">ការព្យាបាលបានពេញលេញ</th>
				<td data-bind="text: isnot(profile(), null, r => r.Treatment_Completed == 1 ? 'បាន' : 'មិនបាន')" align="center" class="kh"></td>
				<th class="kh">ប្រវត្តិមានជំងឺគ្រុនចាញ់</th>
				<td data-bind="text: isnot(profile(), null, r => r.Had_Malaria_Ever == 1 ? 'មាន' : 'គ្មាន')" align="center" class="kh"></td>
			</tr>
			<tr>
				<th class="kh">ប្រវត្តិធ្វើដំណើរ</th>
				<td data-bind="text: isnot(profile(), null, r => r.PassVill == 1 ? 'មាន' : 'គ្មាន')" align="center" class="kh"></td>
				<th class="kh">ដេកក្នុងមុងជ្រលក់ថ្នាំ</th>
				<td data-bind="text: isnot(profile(), null, r => r.Sleep_Under_Mosquito_Net_Last_Night == 1 ? 'មាន' : 'គ្មាន')" align="center" class="kh"></td>
			</tr>
			<tr>
				<th class="kh">ដេកក្នុងព្រៃ</th>
				<td data-bind="text: isnot(profile(), null, r => r.Forest == 1 ? 'មាន' : 'គ្មាន')" align="center" class="kh"></td>
				<th class="kh">ដេកក្នុងកន្លែងធ្វើការ</th>
				<td data-bind="text: isnot(profile(), null, r => r.Work_Site == 1 ? 'មាន' : 'គ្មាន')" align="center" class="kh"></td>
			</tr>
		</table>
		<br /><br />
		<p class="text-bold"><kh>2- ភូមិសាស្ត្រ</kh> (GEOGRAPHICAL RECONNAISSANCE)</p>
		<p class="kh">ពត៌មានបានពីការពិភាក្សាជាមួយប្រធានភូមិ រួមនិង ទិន្ន័យ និងកំណត់ត្រាជាអំណះអំណាង។</p>
		<br />
		<p class="text-bold"><kh>ព្រំដែននៃសំបុកចម្លង</kh> (Foci boundary)</p>
		<p>
			<label class="radio-inline radio-lg">
				<input type="radio" value="Whole Village" data-bind="checked: FociBoundary" name="FociBoundary">
				<span class="kh">ភូមិទាំងមូល៖ ប្រសិនបើចម្ងាយពីចុងភូមិម្ខាងទៅម្ខាងតិចជាង ២ គីឡូម៉ែត្រ</span>
			</label>
		</p>
		<p>
			<label class="radio-inline radio-lg">
				<input type="radio" value="Big Village" data-bind="checked: FociBoundary" name="FociBoundary">
				<span class="kh">សម្រាប់ភូមិធំ (> ២គីឡូម៉ែត្រ) ការអង្កេតនឹងគ្របដណ្តប់ទីតាំងស្ថិតក្នុងរង្វង់មានកាំ១គីឡូម៉ែត្រជុំវិញករណីគ្រុនចាញ់ (L1)</span>
			</label>
		</p>
		<br />
		<p class="text-bold"><kh>ប្រជាជនប៉ាន់ប្រមាណ និងខ្នងផ្ទះ</kh> (Estimated population and households)</p>
		<p class="form-inline">
			<span><kh>ប្រជាជនសរុប</kh> (Total population)</span>
			<input type="text" data-bind="value: Population" numonly="int" class="form-control width100 text-center" />
			<span class="space"><kh>ចំនួនខ្នងផ្ទះ</kh> (Number of houses)</span>
			<input type="text" data-bind="value: House" numonly="int" class="form-control width100 text-center" />
		</p>
		<p class="form-inline">
			<span><kh>ទីតាំង (កូអរឌីណេ) ផ្ទះករណីគ្រុនចាញ់</kh> L1</span>
			<span style="margin-left:20px">Lat</span>
			<input type="text" data-bind="value: Lat" numonly="float" class="form-control text-center width150" />
			<span style="margin-left:20px">Long</span>
			<input type="text" data-bind="value: Long" numonly="float" class="form-control text-center width150" />
		</p>
		<p class="form-inline">
			<span><kh>ចម្ងាយពីផ្ទះករណីគ្រុនចាញ់</kh> L1 <kh>ទៅផ្ទះអ្នកស្ម័គ្រចិត្តភូមិ</kh></span>
			<span class="input-group input-group-sm">
				<input type="text" data-bind="value: L1ToVMW" numonly="float" class="form-control text-center width100" />
				<span class="input-group-addon">km</span>
			</span>
		</p>
		<p class="form-inline">
			<kh>ចម្ងាយពីផ្ទះអ្នកស្ម័គ្រចិត្តភូមិ ទៅមណ្ឌលសុខភាព</kh>
			<span class="input-group input-group-sm">
				<input type="text" data-bind="value: VMWToHC" numonly="float" class="form-control text-center width100" />
				<span class="input-group-addon">km</span>
			</span>
		</p>
		<p class="form-inline">
			<kh>ចម្ងាយពីមណ្ឌលសុខភាព ទៅមន្ទីរពេទ្យបង្អែក</kh>
			<span class="input-group input-group-sm">
				<input type="text" data-bind="value: HCToRH" numonly="float" class="form-control text-center width100" />
				<span class="input-group-addon">km</span>
			</span>
		</p>
		<br />
		<p class="text-bold"><kh>ទិដ្ឋភាពធម្មជាតិ</kh> (Natural land scape)</p>
		<p class="form-inline">
			<span><kh>ចម្ងាយពីផ្ទះករណីគ្រុនចាញ់</kh> L1 <kh>ទៅប្រភពទឹកអចិន្ត្រៃយ៍</kh></span>
			<span class="input-group input-group-sm">
				<input type="text" data-bind="value: L1ToWater" numonly="int" class="form-control text-center width100" />
				<span class="input-group-addon">m</span>
			</span>
		</p>
		<p class="form-inline">
			<span><kh>ចម្ងាយពីផ្ទះករណីគ្រុនចាញ់</kh> L1 <kh>ទៅព្រៃ</kh></span>
			<span class="input-group input-group-sm">
				<input type="text" data-bind="value: L1ToForest" numonly="int" class="form-control text-center width100" />
				<span class="input-group-addon">m</span>
			</span>
		</p>
		<p>
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" data-bind="checked: PeopleFromHighRisk">
				<b class="kh">វត្តមាននៃប្រជាជនចល័តពីខេត្តដែលមានការចម្លងគ្រុនចាញ់ខ្ពស់</b>
			</label>
		</p>
		<p class="kh text-bold">
			<label class="checkbox-inline checkbox-lg">
				<input type="checkbox" data-bind="checked: WorkerNearVillage">
				<b class="kh">វត្តមាននៃកម្មករធ្វើការតាមរដូវនៅជិតភូមិ (ការដ្ឋានសំណង់/ក្រុមហ៊ុន)</b>
			</label>
		</p>
		<br />
		<p class="text-bold"><kh>ផែនទីគូរដោយដៃ គ្របដណ្តប់ទីតាំងក្នុងរង្វង់១គីឡូម៉ែត្រជុំវិញករណី</kh> L1</p>
		<p class="kh">គូសទីតាំងភូមិសាស្ត្រ (ឧ. ផ្លូវ ស្ទឹង អូរ ប្រឡាយ បឹង ព្រៃ ទីទួលខ្ពស់ឬភ្នំ)។ ករណីគ្រុនចាញ់ថ្មីៗ និងដែលបានធ្វើអង្កេតក៏ត្រូវគួសបង្ហាញក្នុងផែនទីដែរ។</p>

		<div class="photo">
			<img data-bind="attr: { src: Photo }" />
			<button class="btn btn-primary" data-bind="click: $parent.selectFile">Choose Photo</button>
		</div>

		<br /><br />
		<p class="text-bold"><kh>3- ការអង្កេតខ្នងផ្ទះ</kh> (HOUSEHOLD SURVEY)</p>
		<table class="table table-bordered widthauto">
			<tr>
				<td class="kh" valign="middle">ភាគរយខ្នងផ្ទះដែលមានមុងយ៉ាងតិច១សម្រាប់មនុស្ស២នាក់</td>
				<td width="120">
					<div class="input-group input-group-sm">
						<input type="text" data-bind="value: HouseHasBednet" numonly="float" class="form-control text-center">
						<span class="input-group-addon">%</span>
					</div>
				</td>
			</tr>
			<tr>
				<td class="kh" valign="middle">ភាគរយប្រជាជនដេកក្នុងមុងកាលពីយប់មិញ</td>
				<td>
					<div class="input-group input-group-sm">
						<input type="text" data-bind="value: BednetSleeper" numonly="float" class="form-control text-center">
						<span class="input-group-addon">%</span>
					</div>
				</td>
			</tr>
			<tr>
				<td class="kh" valign="middle">ភាគរយនៃអ្នកធ្វើដំណើរ</td>
				<td>
					<div class="input-group input-group-sm">
						<input type="text" data-bind="value: Traveller" numonly="float" class="form-control text-center">
						<span class="input-group-addon">%</span>
					</div>
				</td>
			</tr>
			<tr>
				<td class="kh" valign="middle">ភាគរយនៃអ្នកដេកព្រៃ</td>
				<td>
					<div class="input-group input-group-sm">
						<input type="text" data-bind="value: Forester" numonly="float" class="form-control text-center">
						<span class="input-group-addon">%</span>
					</div>
				</td>
			</tr>
		</table>
		<br /><br />
		<p class="text-bold"><kh>4- ការចាប់មូសពេលយប់</kh> (MOSQUITO NIGHT CAPTURE)</p>
		<table class="table table-bordered widthauto">
			<thead>
				<tr>
					<th></th>
					<th class="kh" align="center" width="300">ឈ្មោះមូស</th>
					<th class="kh" align="center">ចំនួន</th>
					<th>Mosquito Collection Program</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td valign="middle"><kh>ចំនួនភ្នាក់ងារចម្លងចម្បងដែលចាប់បាន</kh> (Number of primary vector captured)</td>
					<td><input type="text" data-bind="value: PrimaryVectorName" class="form-control" /></td>
					<td><input type="text" data-bind="textInput: PrimaryVectorQty" numonly="int" class="form-control width100 text-center" /></td>
					<td align="center" valign="middle" class="text-bold" data-bind="text: $parent.primaryVector, style: { color: PrimaryVectorQty() != $parent.primaryVector() ? 'red' : null }"></td>
				</tr>
				<tr>
					<td valign="middle"><kh>ចំនួនភ្នាក់ងារចម្លងបន្ទាប់បន្សំដែលចាប់បាន</kh> (Number of secondary vector captured)</td>
					<td><input type="text" data-bind="value: SecondaryVectorName" class="form-control" /></td>
					<td><input type="text" data-bind="textInput: SecondaryVectorQty" numonly="int" class="form-control width100 text-center" /></td>
					<td align="center" valign="middle" class="text-bold" data-bind="text: $parent.secondaryVector, style: { color: SecondaryVectorQty() != $parent.secondaryVector() ? 'red' : null }"></td>
				</tr>
			</tbody>
		</table>
		<br /><br />
		<p class="text-bold"><kh>5- ចំណាត់ថ្នាក់សំបុកចម្លង</kh> (FOCI CLASSIFICATION)</p>
		<p><kh>ចំណាត់ថ្នាក់សំបុកចម្លង ក្នុងរយៈពេល ៥ឆ្នាំកន្លងមក</kh> (Foci classification in past 5 years):</p>
		<table class="table table-bordered widthauto" data-bind="with: $parent.classify">
			<thead>
				<tr>
					<th class="kh">ចំណាត់ថ្នាក់ (Classification)</th>
					<th class="kh">៥ឆ្នាំមុន</th>
					<th class="kh">៤ឆ្នាំមុន</th>
					<th class="kh">៣ឆ្នាំមុន</th>
					<th class="kh">២ឆ្នាំមុន</th>
					<th class="kh">១ឆ្នាំមុន</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><kh>ករណីគ្រុនចាញ់ដែលឆ្លងក្នុងមូលដ្ឋាន</kh> (L1 Case)</td>
                    <!-- ko foreach: actives -->
					<td align="center" data-bind="text: $data > 0 ? '✔' : ''"></td>
                    <!-- /ko -->
				</tr>
				<tr>
					<td><kh>សំបុកកំពុងចម្លងសកម្ម</kh> (Active Foci)</td>
					<!-- ko foreach: actives -->
					<td align="center" data-bind="text: $data > 0 ? '✔' : ''"></td>
                    <!-- /ko -->
				</tr>
				<tr>
					<td><kh>សំបុកដែលគ្មានការចម្លងក្នុងមូលដ្ឋាន ១២-៣៦ខែ</kh> (Residual Non-Active Foci)</td>
					<!-- ko foreach: nonActives -->
					<td align="center" data-bind="text: $data > 0 ? '✔' : ''"></td>
                    <!-- /ko -->
				</tr>
				<tr>
					<td><kh>សំបុកដែលគ្មានការចម្លងក្នុងមូលដ្ឋាន ច្រើនជាង ៣៦ ខែ</kh> (Cleared Foci)</td>
					<!-- ko foreach: clears -->
					<td align="center" data-bind="text: $data > 0 ? '✔' : ''"></td>
                    <!-- /ko -->
				</tr>
			</tbody>
		</table>
		<br />
		<p class="text-bold"><kh>ចំណាត់ថ្នាក់សំបុកចម្លង ក្នុងឆ្នាំនេះ</kh> (Foci classification this year):</p>
		<p class="kh">យោងប្រវត្តិ៥ឆ្នាំកន្លងមក និងវត្តមានករណី L1 ក្នុងឆ្នាំនេះ សំបុកចម្លងនេះត្រូវបានចាត់ថ្នាក់ជា៖</p>
		<table class="table table-bordered widthauto">
			<tr>
				<td><kh>សំបុកកំពុងចម្លងសកម្ម</kh> (Active Foci)</td>
				<td align="center" width="80" data-bind="text: FociClassification() == 'Active Foci' ? '✔' : ''"></td>
			</tr>
			<tr>
				<td><kh>សំបុកដែលគ្មានការចម្លងក្នុងមូលដ្ឋាន ១២-៣៦ខែ</kh> (Residual Non-Active Foci)</td>
				<td align="center" data-bind="text: FociClassification() == 'Residual Non-Active Foci' ? '✔' : ''"></td>
			</tr>
			<tr>
				<td><kh>សំបុកដែលគ្មានការចម្លងក្នុងមូលដ្ឋាន ច្រើនជាង ៣៦ ខែ</kh> (Cleared Foci)</td>
				<td align="center" data-bind="text: FociClassification() == 'Cleared Foci' ? '✔' : ''"></td>
			</tr>
		</table>
		<br />
		<p class="text-bold kh">ការផ្តល់ពិន្ទុពីសក្តានុពលនៃការចម្លង RECEPTIVITY SCORE</p>
		<table class="table table-bordered widthauto">
			<thead>
				<tr>
					<th align="center" class="kh" colspan="4">តារាងទី១៖ សក្តានុពលនៃការចម្លង</th>
				</tr>
				<tr>
					<th class="kh" align="center">ល.រ</th>
					<th class="kh">ប៉ារ៉ាម៉ែត្រ</th>
					<th class="kh" align="center">ចំលើយ</th>
					<th class="kh" align="center" width="80">ពិន្ទុ</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td align="center" valign="middle">1</td>
					<td class="kh" valign="middle">វត្តមានអចិន្ត្រៃយ៍នៃប្រភពទឹកក្នុងព្រំដែនដី៣គីឡូម៉ែត្រ</td>
					<td>
						<select class="form-control kh" data-bind="value: WaterIn3km">
							<option value="" hidden></option>
							<option value="2">មាន</option>
							<option value="0">គ្មាន</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: WaterIn3km"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">2</td>
					<td class="kh" valign="middle">ចាប់បានប្រភេទមូសដែកគោល</td>
					<td>
						<select class="form-control kh" data-bind="value: VectorType">
							<option value="">មិនទាន់ចាប់មូស</option>
							<option value="4">ភ្នាក់ងារចម្បង</option>
							<option value="2">ភ្នាក់ងារបន្ទាប់បន្សំ</option>
							<option value="0">គ្មានភ្នាក់ងារចម្លង</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: VectorType"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">3</td>
					<td class="kh" valign="middle">ចម្ងាយទៅព្រៃ</td>
					<td>
						<select class="form-control kh" data-bind="value: DistanceToForest">
							<option value="" hidden></option>
							<option value="2">&lt; 1 km</option>
							<option value="1">&lt; 5 km</option>
							<option value="0">&gt; 5 km</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: DistanceToForest"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">4</td>
					<td class="kh" valign="middle">មានករណីគ្រុនចាញ់អាយុតិចជាង៥ឆ្នាំ ក្នុងអំឡុងពេល១២ខែកន្លងមក</td>
					<td>
						<select class="form-control kh" data-bind="value: Under5yIn12m">
							<option value="" hidden></option>
							<option value="2">មាន</option>
							<option value="0">គ្មាន</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: Under5yIn12m"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2"></th>
					<th align="center"><kh>សរុប</kh> (Total)</th>
					<th align="center" valign="middle" data-bind="text: $parent.getTotal1()"></th>
				</tr>
			</tfoot>
		</table>
		<br />
		<table class="table table-bordered widthauto">
			<thead>
				<tr>
					<th align="center"><kh>កំរិតនៃសក្តានុពលចម្លង</kh> (Receptivity Level)</th>
					<th align="center"><kh>កំរិតកំណត់</kh></th>
					<th align="center"><kh>ជ្រើសរើស</kh></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><kh>ខ្ពស់</kh>/HIGH (R1)</td>
					<td align="center">&gt; 6</td>
					<td align="center" data-bind="text: R1() == 1 ? '✔' : ''"></td>
				</tr>
				<tr>
					<td><kh>ទាប</kh>/LOW (R0)</td>
					<td align="center">&le; 6</td>
					<td align="center" data-bind="text: R1() == 0 ? '✔' : ''"></td>
				</tr>
			</tbody>
		</table>
		<br />
		<p class="text-bold"><kh>ការផ្តល់ពិន្ទុពីភាពងាយរងគ្រោះ</kh> (VULNERABILITY SCORE)</p>
		<table class="table table-bordered widthauto">
			<thead>
				<tr>
					<th align="center" class="kh" colspan="5">តារាងទី២៖ ភាពងាយរងការចម្លង</th>
				</tr>
				<tr>
					<th class="kh" align="center">ល.រ</th>
					<th class="kh">ប៉ារ៉ាម៉ែត្រ</th>
					<th class="kh" align="center">ចំលើយ</th>
					<th class="kh" align="center" width="80">ពិន្ទុ</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td align="center" valign="middle">1</td>
					<td class="kh" valign="middle">មានអ្នកជំងឺគ្រុនចាញ់ជាករណីនាំចូលក្នុងរយៈពេល១២ខែកន្លងមល</td>
					<td>
						<select class="form-control kh" data-bind="value: ImportedIn12m">
							<option value="" hidden></option>
							<option value="5">មាន</option>
							<option value="0">គ្មាន</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: ImportedIn12m"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">2</td>
					<td class="kh" valign="middle">វត្តមានប្រជាជនចល័តមកពីខេត្តដែលមានការចម្លងគ្រុនចាញ់ខ្ពស់</td>
					<td>
						<select class="form-control kh" data-bind="value: MobileFromHighProvince">
							<option value="" hidden></option>
							<option value="4">មាន</option>
							<option value="0">គ្មាន</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: MobileFromHighProvince"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">3</td>
					<td valign="middle"><kh>ភាគរយអ្នកធ្វើដំណើរលើសពី</kh> 20%</td>
					<td>
						<select class="form-control kh" data-bind="value: TravellerOver20p">
							<option value="" hidden></option>
							<option value="2">លើស</option>
							<option value="0">មិនលើស</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: TravellerOver20p"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">4</td>
					<td valign="middle"><kh>ភាគរយអ្នកចូលព្រៃលើសពី</kh> 20%</td>
					<td>
						<select class="form-control kh" data-bind="value: ForesterOver20p">
							<option value="" hidden></option>
							<option value="2">លើស</option>
							<option value="0">មិនលើស</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: ForesterOver20p"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">5</td>
					<td valign="middle"><kh>វត្តមាននៃកម្មករធ្វើការតាមរដូវនៅជិតភូមិ (ការដ្ឋានសំណង់/ក្រុមហ៊ុន)</kh></td>
					<td>
						<select class="form-control kh" data-bind="value: SeasonWorker">
							<option value="" hidden></option>
							<option value="2">មាន</option>
							<option value="0">គ្មាន</option>
						</select>
					</td>
					<td align="center" valign="middle" data-bind="text: SeasonWorker"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2"></th>
					<th align="center"><kh>សរុប</kh> (Total)</th>
					<th align="center" valign="middle" data-bind="text: $parent.getTotal2()"></th>
				</tr>
			</tfoot>
		</table>
		<br />
		<table class="table table-bordered widthauto">
			<thead>
				<tr>
					<th align="center"><kh>កំរិតនៃភាពងាយរងគ្រោះចម្លង</kh> (Vulnerability Level)</th>
					<th align="center"><kh>កំរិតកំណត់</kh></th>
					<th align="center"><kh>ជ្រើសរើស</kh></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><kh>ខ្ពស់</kh>/HIGH (V1)</td>
					<td align="center">&gt; 10</td>
					<td align="center" data-bind="text: V1() == 1 ? '✔' : ''"></td>
				</tr>
				<tr>
					<td><kh>ទាប</kh>/LOW (V0)</td>
					<td align="center">&le; 10</td>
					<td align="center" data-bind="text: V1() == 0 ? '✔' : ''"></td>
				</tr>
			</tbody>
		</table>
		<br /><br />
		<p class="text-bold"><kh>6- ការគ្រប់គ្រងសំបុកចម្លង</kh> (Foci MANAGEMENT)</p>
		<p class="kh">ការគ្រប់គ្រងសំបុកចម្លងគឺអនុវត្តន៍អន្តរាគមន៍ចាំបាច់ដើម្បីកាត់ផ្តាច់ការចម្លងក្នុងសំបុកចម្លង។ សកម្មភាពសំខាន់ៗរួមមាន ការតាមដានបន្ត</p>
		<p class="kh">នៅតាមផ្ទះក្នុងសំបុកចម្លង ការធ្វើវិធានការបង្ការនិងការជោះឈាមនិងព្យាបាលទាន់ពេលវេលាតាមបែបសកម្មដើម្បីទប់ស្កាត់ការចម្លងបន្ត។</p>
		<br />
		<p class="kh">ការជោះឈាមទៅលើអ្នកគ្រុនក្តៅត្រូវធ្វើរៀងរាល់សប្តាហ៍ (AFS)</p>
		<p class="kh">ការអប់រំនិងផ្តល់វិធានការណ៍បង្កាសម្រាប់ប្រជាជនចល័តនិងអ្នកចូលព្រៃសមស្រប (PMF)</p>
		<table class="table table-bordered widthauto">
			<tr>
				<th colspan="2" rowspan="2" align="center" valign="middle"><kh>តារាងគ្រប់គ្រងសំបុកចម្លង</kh> (✔)</th>
				<th colspan="2" align="center"><kh>សក្តានុពលចម្លង</kh> (Receptivity)</th>
			</tr>
			<tr>
				<th align="center" valign="middle" width="150" height="50" data-bind="css: { highlight: R1() == 0 }">
					<span data-bind="text: R1() == 0 ? '✔' : ''"></span>
					<span>R0</span>
				</th>
				<th align="center" valign="middle" width="150" data-bind="css: { highlight: R1() == 1 }">
					<span data-bind="text: R1() == 1 ? '✔' : ''"></span>
					<span>R1</span>
				</th>
			</tr>
			<tr>
				<th rowspan="2" align="center" valign="middle" width="150"><kh>ភាពងាយរងការចម្លង</kh><br />(Vulnerability)</th>
				<th align="center" valign="middle" width="120" height="120" data-bind="css: { highlight: V1() == 0 }">
					<span data-bind="text: V1() == 0 ? '✔' : ''"></span>
					<span>V0</span>
				</th>
				<td align="center" valign="middle" data-bind="css: { highlight: R1() == 0 && V1() == 0 }">VMW</td>
				<td align="center" valign="middle" data-bind="css: { highlight: R1() == 1 && V1() == 0 }">
					<span class="text-left" style="display:inline-block">VMW + AFS<br />ITN</span>
				</td>
			</tr>
			<tr>
				<th align="center" valign="middle" height="120" data-bind="css: { highlight: V1() == 1 }">
					<span data-bind="text: V1() == 1 ? '✔' : ''"></span>
					<span>V1</span>
				</th>
				<td align="center" valign="middle" data-bind="css: { highlight: R1() == 0 && V1() == 1 }">
					<span class="text-left" style="display:inline-block">VMW<br />PMF</span>
				</td>
				<td align="center" valign="middle" data-bind="css: { highlight: R1() == 1 && V1() == 1 }">
					<span class="text-left" style="display:inline-block">VMW + AFS<br />ITN<br />PMF</span>
				</td>
			</tr>
		</table>
		<br />

		<div class="input-group" style="width:350px">
			<kh class="input-group-addon">ថ្ងៃបញ្ចប់សកម្មភាពអង្គេតសំបុកចម្លង</kh>	
			<input type="text" class="form-control text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: EndDate, showClear: true" />
		</div>
		<br />
		<br />

        <p class="text-bold"><kh>ចំណាត់ថ្នាក់សំបុកចម្លងមាន ៤ចំណាត់ថ្នាក់៖</kh> V0 R0, V0 R1, V1 R0, V1 R1</p>
		<p class="kh">ការកំណត់កញ្ចប់អន្តរាគមន៍ដែលសមស្រប ដោយយោងតាមការចាត់ថ្នាក់សំបុកចម្លង៖</p>
		<ul>
			<li class="form-inline form-group">
				<b>VMW/MMWs:</b> <kh>ជ្រើសរើសVMW/MMWs បើសិនភូមិមិនទាន់មាន VMW/MMWs</kh>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">កាលបរិច្ឆេទ</kh>	
					<input type="text" class="form-control input-sm width100 text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: VMWDate, showClear: true" />
				</div>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">ផ្សេងៗ</kh>	
					<input type="text" class="form-control input-sm" style="width:200px" data-bind="value: VMWOther" />
				</div>
			</li>
			<li class="form-inline form-group">
				<b>ITN/Forest Pack:</b> <kh>ចែកមុងបំពេញបន្ថែម</kh>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">កាលបរិច្ឆេទ</kh>	
					<input type="text" class="form-control input-sm width100 text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: ITNDate, showClear: true" />
				</div>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">ផ្សេងៗ</kh>	
					<input type="text" class="form-control input-sm" style="width:200px" data-bind="value: ITNOther" />
				</div>
			</li>
			<li class="form-inline form-group">
				<b>AFS:</b> <kh>ការចុះពិនិត្យស្រាវជ្រាវរកគ្រុនក្តៅពីផ្ទះមួយទៅផ្ទះមួយប្រចាំសប្តាហ៍</kh>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">កាលបរិច្ឆេទ</kh>	
					<input type="text" class="form-control input-sm width100 text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: AFSDate, showClear: true" />
				</div>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">ផ្សេងៗ</kh>	
					<input type="text" class="form-control input-sm" style="width:200px" data-bind="value: AFSOther" />
				</div>
			</li>
			<li class="form-inline form-group">
				<b>TDA:</b> <kh>ផ្តល់ថ្នាំសម្រាប់ប្រជាជនគោលដៅ ចំពោះតែបុរសអាយុ ចាប់ពី 15 – 49 ឆ្នាំ</kh>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">កាលបរិច្ឆេទ</kh>	
					<input type="text" class="form-control input-sm width100 text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: TDADate, showClear: true" />
				</div>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">ផ្សេងៗ</kh>	
					<input type="text" class="form-control input-sm" style="width:200px" data-bind="value: TDAOther" />
				</div>
			</li>
			<li class="form-inline form-group">
				<b>IPTf:</b> <kh>សម្រាប់ការលេបថ្នាំការពារជាមុន (IPT) សម្រាប់អ្នកចូលព្រៃ</kh>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">កាលបរិច្ឆេទ</kh>	
					<input type="text" class="form-control input-sm width100 text-center" placeholder="DD-MM-YYYY" data-bind="datePicker: IPTDate, showClear: true" />
				</div>
				<div class="input-group input-group-sm">
					<kh class="input-group-addon">ផ្សេងៗ</kh>	
					<input type="text" class="form-control input-sm" style="width:200px" data-bind="value: IPTOther" />
				</div>
			</li>
		</ul>
	</div>
	<div class="panel-footer text-center" data-bind="visible: app.user.permiss['Foci Investigation'].contain('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<input type="file" id="file1" class="hide" data-bind="change: () => fileChanged($element.files)" accept="image/*" />
<!-- /ko -->

<?=latestJs('/media/ViewModel/Foci1.js')?>