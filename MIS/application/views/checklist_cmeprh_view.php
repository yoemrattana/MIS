<div class="kh divcenter" style="width:85%" data-bind="visible: view() == 'detail'">
    <h3 class="text-center">ការត្រួតពិនិត្យតាមដាននិងវាយតំលៃជំងឺគ្រុនចាញ់នៅតាមមន្ទីរពេទ្យបង្អែកស្រុកឬខេត្ត</h3>
    <br />

    <div class="form-inline" style="border:2px solid; padding:10px" data-bind="with: masterModel">
        <p>
            <span>ការចុះអភិបាលនៅ ខេត្ត</span>
            <select data-bind="value: Code_Prov_N,
					options: pvList,
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''"
                class="form-control minwidth150 kh"></select>

            <span class="space">ស្រុកប្រតិបត្តិ</span>
            <select data-bind="value: Code_OD_T,
					options: odList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''"
                class="form-control minwidth150 kh"></select>

            <span class="space">មណ្ឌលសុខភាព</span>
            <select data-bind="value: Code_Facility_T,
					options: hcList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''"
                class="form-control minwidth150 kh"></select>
        </p>
        <p class="relative kh">
            <span>ថ្ងៃចុះអភិបាល</span>
            <input type="text" class="form-control width150 text-center" data-bind="datePicker: VisitDate, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
        </p>

    </div>
    <br />

    <div data-bind="with: detailModel">
        <table class="table table-bordered">
            <tr data-bind="with: P1">
                <th>I. ការគ្រប់គ្រងកម្មវិធីគ្រុនចាញ់ (ក្នុងរយៈពេល៣ខែចុងក្រោយ)</th>
                <th class="form-inline">
                    <label>ជួបសម្ភាសន៍ជាមួយ៖  ឈ្មោះ </label>
                    <input type="text" class="form-control" data-bind="value: Answer.interviewer" />
                    <label>តួនាទី</label>
                    <input type="text" class="form-control" data-bind="value: Answer.position" />
                </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr data-bind="with: P1Q1">
                <td align="center">1</td>
                <td>តើមានការត្រួតពិនិត្យតាមដាននិងវាយតំលៃការគ្រប់គ្រងគ្រុនចាញ់ ពីថ្នាក់ជាតិ ឬពីថ្នាក់ខេត្ត ឬពីថ្នាក់ស្រុកប្រតិបត្តិដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q1" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q1" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P1Q2">
                <td align="center">2</td>
                <td>តើមានមគ្គុទេសក៏ជាតិចុងក្រោយស្ដីពីការព្យាបាលជំងឺគ្រុនចាញ់ ដែរឬទេ? </td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី II</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P1Q2_1">
                <td align="center">2.1</td>
                <td>បើមាន តើបោះពុម្ភនៅឆ្នាំណា? </td>
                <td align="center" class="form-inline">
                    <input type="text" class="form-control" data-bind="value: Answer" />
                </td>
            </tr>
        </table>
        <br />
        <!--end part I-->
        <table class="table table-bordered">
            <tr data-bind="with: P2">
                <th>II.	ការបណ្តុះបណ្តាលបុគ្គលិក៖ (ក្នុងរយៈពេល៣ខែចុងក្រោយ) </th>
                <th class="form-inline">
                    <label>ជួបសម្ភាសន៍ជាមួយ៖  ឈ្មោះ </label>
                    <input type="text" class="form-control" data-bind="value: Answer.interviewer" />
                    <label>តួនាទី</label>
                    <input type="text" class="form-control" data-bind="value: Answer.position" />
                </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr data-bind="with: P2Q1">
                <td align="center">1</td>
                <td>តើបុគ្គលិកបានទទួលការបណ្តុះបណ្តាល ពីជំងឺគ្រុនចាញ់ដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P2Q1" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P2Q1" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី 2</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="center">1.1</td>
                <td>បើបាន សូមបញ្ជាក់ចំនួនក្នុងតារាងខាងក្រោម៖ </td>
                <td align="center" class="form-inline">ប្រុស</td>
                <td align="center" class="form-inline">ស្រី</td>
            </tr>
            <tr data-bind="with: P2Q1_1.Answer">
                <td align="center"></td>
                <td>ការព្យាបាលជំងឺគ្រុនចាញ់ </td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: treatment.male" /> នាក់</td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: treatment.female" /> នាក់</td>
            </tr>
             <tr data-bind="with: P2Q1_1.Answer">
                <td align="center"></td>
                <td>ការធ្វើរោគវិនិច្ឆ័យដោយប្រើមីក្រូទស្សន៍ </td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: microscopy.male" /> នាក់</td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: microscopy.female" /> នាក់</td>
            </tr>
             <tr data-bind="with: P2Q1_1.Answer">
                <td align="center"></td>
                <td>ការបណ្តុះបណ្តាលផ្សេងៗទៀតដែលទាក់ទងនិងជំងឺគ្រុនចាញ់ </td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: other_training.male" /> នាក់</td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: other_training.female" /> នាក់</td>
            </tr>

            <tr data-bind="with: P2Q2">
                <td align="center">2</td>
                <td>តើអ្នកត្រូវការបណ្តុះបណ្តាល បុគ្គលិកពីជំងឺគ្រុនចាញ់បន្ថែមដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P2Q1" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P2Q1" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី III</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="center">2.1</td>
                <td>បើត្រូវការ សូមបញ្ជាក់ចំនួនក្នុងតារាងខាងក្រោម៖ </td>
                <td align="center" class="form-inline">ប្រុស</td>
                <td align="center" class="form-inline">ស្រី</td>
            </tr>
            <tr data-bind="with: P2Q2_1.Answer">
                <td align="center"></td>
                <td>ការព្យាបាលជំងឺគ្រុនចាញ់ </td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: treatment.male" /> នាក់</td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: treatment.female" /> នាក់</td>
            </tr>
             <tr data-bind="with: P2Q2_1.Answer">
                <td align="center"></td>
                <td>ការធ្វើរោគវិនិច្ឆ័យដោយប្រើមីក្រូទស្សន៍ </td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: microscopy.male" /> នាក់</td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: microscopy.female" /> នាក់</td>
            </tr>
             <tr data-bind="with: P2Q2_1.Answer">
                <td align="center"></td>
                <td>ការបណ្តុះបណ្តាលផ្សេងៗទៀតដែលទាក់ទងនិងជំងឺគ្រុនចាញ់ </td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: other_training.male" /> នាក់</td>
                <td align="center" class="form-inline"><input type="number" class="form-control" data-bind="value: other_training.female" /> នាក់</td>
            </tr>
        </table>
        <br />
         <!--end part II-->
        <table class="table table-bordered">
            <tr>
                <th>III. គុណភាពនៃការពិនិត្យនិងព្យាបាលជំងឺគ្រុនចាញ់៖ (ក្នុងរយៈពេល៣ខែចុងក្រោយ)  (បើតិចជាង៣០ករណីយកទាំងអស់  បើច្រើនជាង៣០ជ្រើសរើសយកត្រឹមតែ៣០ករណី)  </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
           <thead>
               <tr>
                   <th rowspan="2" align="center" valign="middle">លរ</th>
                   <th rowspan="2" align="center" valign="middle">ភេទ</th>
                   <th rowspan="2" align="center" valign="middle">មានផ្ទៃពោះ</th>
                   <th rowspan="2" align="center" valign="middle">អាយុ </th>
                   <th rowspan="2" align="center" valign="middle">ទំងន់</th>
                   <th rowspan="2" align="center" valign="middle">ប្រភេទមេរោគ</th>
                   <th colspan="6" align="center" valign="middle">ការព្យាបាល</th>
               </tr>
               <tr>
                   <th align="center" valign="middle">ឈ្មោះថ្នាំ</th>
                   <th align="center" valign="middle">របៀបប្រើ</th>
                   <th align="center" valign="middle">កំរិតថ្នាំក្នុង១ដង</th>
                   <th align="center" valign="middle">ចំនួនដងក្នុង១ថ្ងៃ</th>
                   <th align="center" valign="middle">រយៈពេល </th>
                   <th align="center" valign="middle">ត្រឹមត្រូវដែរឬទេ? </th>
               </tr>
           </thead>
            <tbody data-bind="foreach: P3.Answer">
                <tr>
                    <td align="center" valign="middle" data-bind="text: $index() + 1"></td>
                    <td>
						<select class="form-control font12" data-bind="value: sex">
							<option></option>
							<option value="male">ប្រុស</option>
							<option value="female">ស្រី</option>
						</select>
					</td>
                    <td><input type="text" class="form-control text-center en" data-bind="value: pregnancy" numonly="int"></td>
					<td><input type="text" class="form-control text-center en" data-bind="value: age" numonly="int"></td>
                    <td><input type="text" class="form-control text-center en" data-bind="value: weight" numonly="int"></td>
					<td>
						<select class="form-control en" data-bind="value: species">
							<option></option>
							<option>Pf</option>
							<option>Pv</option>
							<option>Mix</option>
						</select>
					</td>
                    <td><input type="text" class="form-control en" data-bind="value: medicine"></td>
                    <td><input type="text" class="form-control en" data-bind="value: how_to_use"></td>
					<td><input type="text" class="form-control text-center en" data-bind="value: qty" numonly="int"></td>
                    <td><input type="text" class="form-control text-center en" data-bind="value: daily_dose" numonly="int"></td>
					<td><input type="text" class="form-control text-center en" data-bind="value: duration" numonly="int"></td>
					<td>
						<select class="form-control font12" data-bind="value: answer">
							<option></option>
							<option value="right">ត្រឹមត្រូវ</option>
							<option value="wrong">មិនត្រឹមត្រូវ</option>
						</select>
					</td>
					<td align="center" valign="middle" role="button" data-bind="click: $root.deletePatient">
						<span class="material-icons text-danger">delete_outline</span>
					</td>
                </tr>
            </tbody>
            <tfoot>
				<tr>
					<td colspan="10">
						<button class="btn btn-success btn-sm width100" data-bind="click: $root.addPatient">Add</button>
					</td>
				</tr>
			</tfoot>
        </table>
        <!--part IV end-->
        <br />
        <table class="table table-bordered">
            <tr data-bind="with:P4">
                <th>ឱសថ៖  (ពិនិត្យពេលចុះអភិបាល)</th>
                <th class="form-inline">
                    <label>ជួបសម្ភាសន៍ជាមួយ៖  ឈ្មោះ </label>
                    <input type="text" class="form-control" data-bind="value: Answer.interviewer" />
                    <label>តួនាទី</label>
                    <input type="text" class="form-control" data-bind="value: Answer.position" />
                </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
                <th align="center" valign="middle">ល.រ</th>
                <th valign="middle">សម្ភារៈបរិក្ខារនិងឱសថ</th>
                <th align="center" width="50">ចំនួនប្រើប្រាស់ជាមធ្យមប្រចាំខែ (AMC)</th>
                <th align="center" width="50">ចំនួនស្តុកបច្ចុប្បន្ន(Balance)</th>
                <th align="center" width="50">ចំនួនខែនៃស្តុក(MOS)</th>
                <th align="center" width="50">ស្ថានភាពស្តុក</th>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">1</td>
                <td valign="middle">DHA ៤0mg + PPQ ៣២0mg/ គ្រាប់ (Eurartesim) </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: dha.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: dha.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: dha.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: dha.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">2</td>
                <td valign="middle">Artesunate25mg+ Mefloquin50mg (A+M) / គ្រាប់ </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq50.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq50.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq50.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: asmq50.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">3</td>
                <td valign="middle">Artesunate100mg+ Mefloquin200mg (A+M) / គ្រាប់ </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq200.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq200.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq200.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: asmq200.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">4</td>
                <td valign="middle">Artesunate (60 mg)/ ចាក់ </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq60.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq60.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq60.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: asmq60.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">5</td>
                <td valign="middle">Artemether (80mg)/ ចាក់ </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq80.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq80.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: asmq80.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: asmq80.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">6</td>
                <td valign="middle">Quinine300mg (2ml) /ចាក់ </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: quinine2ml.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: quinine2ml.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: quinine2ml.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: quinine2ml.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">7</td>
                <td valign="middle">Quinine (300mg) / គ្រាប់ </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: quinine.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: quinine.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: quinine.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: quinine.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">8</td>
                <td valign="middle">Primaquine (7.5mg) / គ្រាប់ </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: primaquin75.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: primaquin75.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: primaquin75.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: primaquin75.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">9</td>
                <td valign="middle">Primaquine (15mg) / គ្រាប់</td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: primaquin15.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: primaquin15.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: primaquin15.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: primaquin15.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">10</td>
                <td valign="middle">Doxycycline (100mg) / គ្រាប់</td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: doxycycline.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: doxycycline.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: doxycycline.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: doxycycline.status" />
                </td>
            </tr>
            <tr data-bind="with:P4Q1.Answer">
                <td align="center" valign="middle">11</td>
                <td valign="middle">Tetracycline (250mg) / គ្រាប់</td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: tetracycline.amc" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: tetracycline.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: tetracycline.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: tetracycline.status" />
                </td>
            </tr>
        </table>
        <br />
        <p>
            <b>AMC (Average Monthly Consumption) = </b> បរិមាណប្រើប្រាស់សរុប១២ខែចុងក្រោយ / ១២   
        </p>
        <p>
            <b>Balance: </b> ចំនួនស្តុកសល់ក្រោយការផ្គត់ផ្គង់និងធ្វើសារពើភណ្ឌរូច  (ឱសថដែលហួសកាលបរិច្ឆេទប្រើប្រាស់ មិនត្រូវរាប់បញ្ចូលទេ)
        </p>
        <p>
            <b>MOS (Month of Stock) = </b> Balance/AMC:
        </p>
        <p>
            <b>ស្ថានភាពស្តុក:	</b> MOS ≥ ៦ = ស្តុកលើសតំរូវការ;         ៣ ≤ MOS < ៦ = ស្តុកគ្រប់គ្រាន់;	០ < MOS < ៣: ឈានទៅរកការដាច់ស្តុក (បើ MOS < ១.៥ ត្រូវស្នើសុំ)
        </p>
        <br />
        <!--Part V end-->
        <table class="table table-bordered">
            <tr data-bind="with:P5">
                <th>V. ផ្នែកមន្ទីរពិសោធន៍៖ (ក្នុងរយៈពេល៣ខែចុងក្រោយ) </th>
                <th class="form-inline">
                    <label>ជួបសម្ភាសន៍ជាមួយ៖  ឈ្មោះ </label>
                    <input type="text" class="form-control" data-bind="value: Answer.interviewer" />
                    <label>តួនាទី</label>
                    <input type="text" class="form-control" data-bind="value: Answer.position" />
                </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr data-bind="with: P5Q1">
                <td align="center">1</td>
                <td>តើបានពិនិត្យកញ្ចក់ឈាមរកមេរោគគ្រុនចាញ់ដោយមីក្រូទស្សន៍ចំនួនសរុបប៉ុន្មានក្នុង៣ខែចុងក្រោយនេះ? </td>
                <td align="center" class="form-inline">
                    <input type="number" class="form-control" data-bind="value: Answer.total" />
                </td>
            </tr>
            <tr data-bind="with: P5Q1_1">
                <td align="center">1.1</td>
                <td>តេស្តអវិជ្ជមានសរុបប៉ុន្មាន?</td>
                <td align="center" class="form-inline">
                    <input type="number" class="form-control" data-bind="value: Answer.total" />
                </td>
            </tr>
            <tr data-bind="with: P5Q1_2">
                <td align="center">1.2</td>
                <td>តេស្តវិជ្ជមានសរុបប៉ុន្មាន?</td>
                <td align="center" class="form-inline">
                    សរុប៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.total" />​
                     Pf៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.pf" />​
                     Pv៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.pv" />​
                     Mix៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.mix" />​
                </td>
            </tr>
            <tr data-bind="with: P5Q2">
                <td align="center">2</td>
                <td>តើបានអនុវត្តប្រព័ន្ធធានាគុណភាពធ្វើតេស្តដោយមីក្រូទស្សន៍ដែរឬទេ? (QA)</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q2" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q2" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P5Q3">
                <td align="center">3</td>
                <td>តើបានពិនិត្យរកមេរោគគ្រុនចាញ់ដោយតេស្តរហ័ស (RDT) ក្នុង៣ខែចុងក្រោយនេះដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q3" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q3" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី VI</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P5Q3_1">
                <td align="center">3.1.</td>
                <td>បើបាន  តើបានពិនិត្យបញ្ជាក់ (confirm) ដោយមីក្រូទស្សន៍ដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q3_1" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q3_1" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
        </table>
        <!--Part VI end-->
        <br />
        <table class="table table-bordered">
            <tr data-bind="with:P6">
                <th>VI.	គុណភាពនៃទិន្ន័យក្នុងប្រព័ន្ធព៌តមានសុខាភិបាល៖  </th>
                <th class="form-inline relative">
                    <label>ពីថ្ងៃទី </label>
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date_from, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                    <label>ដល់ថ្ងៃទី </label>
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date_to, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
                <th></th>
                <th></th>
                <th>សំណុំលិខិតអ្នកជំងឺសំរាកពេទ្យ</th>
                <th>ក្នុងរបាយការណ៍ H02</th>
            </tr>
            <tr data-bind="with: P6Q1">
                <td>1</td>
                <td>ចំនួនតេស្តសរុបដោយកពា្ចក់ឈាម</td>
                <td><input type="number" class="form-control" data-bind="value: Answer.patient_letter" />​</td>
                <td><input type="number" class="form-control" data-bind="value: Answer.ho2" /></td>
            </tr>
            <tr data-bind="with: P6Q2">
                <td>2</td>
                <td>ចំនួនតេស្តវិជ្ជមានសរុបដោយកពា្ចក់ឈាម</td>
                <td><input type="number" class="form-control" data-bind="value: Answer.patient_letter" />​</td>
                <td><input type="number" class="form-control" data-bind="value: Answer.ho2" /></td>
            </tr>
            <tr data-bind="with: P6Q3">
                <td>2</td>
                <td>ចំនួនករណីគ្រុនចាញ់កំរិតធ្ងន់បានទទួលការព្យាបាលសរុប</td>
                <td><input type="number" class="form-control" data-bind="value: Answer.patient_letter" />​</td>
                <td><input type="number" class="form-control" data-bind="value: Answer.ho2" /></td>
            </tr>
        </table>
        <!--part VI end-->
         <br />
        <table class="table table-bordered">
            <tr>
                <th>VII. បញ្ហាដែលរកឃើញនិងដំណោះស្រាយ៖</th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr class="bg-info">
                <th>ល.រ</th>
                <th>បញ្ហា</th>
                <th>ដំណោះស្រាយ</th>
                <th>អ្នកទទួលខុសត្រូវ</th>
                <th>កាលបរិឆ្ឆេទ</th>
            </tr>
            <tr data-bind="with: P7Q1">
                <td>1</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
            <tr data-bind="with: P7Q2">
                <td>2</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
            <tr data-bind="with: P7Q3">
                <td>3</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
            <tr data-bind="with: P7Q4">
                <td>4</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
            <tr data-bind="with: P7Q5">
                <td>5</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
        </table>
        <br />
        <br />
        <div data-bind="with: P7Q6_1">
            <p>7.1. សំណូមពរពីអ្នកត្រួតពិនិត្យតាមដាននិងវាយតំលៃ៖</p>
            <textarea class="form-control" rows="10" style="resize:none" data-bind="value: Answer"></textarea>
        </div>
        <div data-bind="with: P7Q6_1">
            <p>7.2. សំណូមពរពីមន្ទីរពេទ្យ៖</p>
            <textarea class="form-control" rows="10" style="resize:none" data-bind="value: Answer"></textarea>
        </div>
    </div>

    <div data-bind="with: masterModel">
        <label>តំណាងមណ្ឌលសុខភាព៖ </label>
        <input type="text" class="form-control" data-bind="value: RHRepresentative" />
        <label>តំណាងអ្នកចុះអភិបាល៖ </label>
        <input type="text" class="form-control" data-bind="value: VisitorName" />
    </div>
</div>

<?=latestJs('/media/ViewModel/Checklist_Cmep_RH.js')?>
