<div class="kh divcenter" style="width:85%" data-bind="visible: view() == 'detail'">
    <h3 class="text-center">ការអភិបាលបច្ចេកទេសជំងឺគ្រុនចាញ់</h3>
    <h5 class="text-center">នៅតាមមណ្ឌលសុខភាព ឬ ប៉ុស្ដិ៍សុខភាព</h5>
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
            <tr>
                <th colspan="2">I. ការគ្រប់គ្រងកម្មវិធីគ្រុនចាញ់</th>
            </tr>
        </table>
        <br />

        <table class="table table-bordered">
            <tr class="bg-info" data-bind="with: P1Q1">
                <td align="center">1</td>
                <td>តើមានអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជម្ងឺគ្រុនចាញ់ក្នុងតំបន់គ្របដណ្តប់ដោយមណ្ឌលសុខភាពដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q1" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q1" value="No"  data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី២</span>
                        </label>
                    </span>
                </td>
            </tr>

            <tr data-bind="with: P1Q1_1" class="form-inline">
                <td align="center" valign="middle">1.1</td>
                <td valign="middle">
                    បើមាន តើមានចំនួនប៉ុន្មាន?
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.total" />​ នាក់
                </td>
            </tr>

            <tr data-bind="with: P1Q1_2">
                <td align="center">1.2.</td>
                <td>តើមានការប្រជុំប្រចាំខែជាមួយអ្នកស្ម័គ្រចិត្ដភូមិនៅខែចុងក្រោយដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q1_2" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q1_2" value="No"  data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>

            <tr class="bg-info" data-bind="with: P1Q2">
                <td align="center">2</td>
                <td>តើមានការចែកមុងជ្រលក់ថ្នាំ  (ITN) តាមភូមិគ្របដណ្តប់ដោយមណ្ឌលសុខភាព ក្នុង៣ខែចុងក្រោយនេះដែរឫទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2" value="No"  data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី៣</span>
                        </label>
                    </span>
                </td>
            </tr>

            <tr data-bind="with: P1Q2_1" class="form-inline">
                <td align="center" valign="middle">2.1</td>
                <td valign="middle">
                    បើមាន  សូមបញ្ជាក់ចំនួនមុងដែលចែកអោយ៖
                </td>
                <td>
                    <label>ប្រជាជនគោលដៅ (ប្រជាជនមានលំនៅអចិន្ត្រៃក្នុងតំបន់គ្រុនចាញ់)</label>
                    <input type="number" class="form-control" data-bind="value: Answer.pop" />​ មុង
                    <br />
                    <label>ប្រជាជនចល័ត</label>
                    <input type="number" class="form-control" data-bind="value: Answer.mobile_pop" /> មុង
                </td>
            </tr>

            <tr class="bg-info" data-bind="with: P1Q3">
                <td align="center">3</td>
                <td>តើមានសេវាឯកជន (បន្ទប់ពិគ្រោះជំងឺ និងឪសថស្ថាន) ពិនិត្យនិងព្យាបាលជំងឺគ្រុនចាញ់  ក្នុងតំបន់គ្របដណ្តប់ដោយមណ្ឌលសុខភាពដែរឬទេ?  </td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q3" value="Yes"  data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q3" value="No"  data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី៦</span>
                        </label>
                    </span>
                </td>
            </tr>

            <tr data-bind="with: P1Q3_1" class="form-inline">
                <td align="center" valign="middle">3.1</td>
                <td valign="middle">
                    បើមាន  សូមបញ្ជាក់ចំនួន ៖
                </td>
                <td>
                    <label>សេវាស្របច្បាប់៖</label>
                    <input type="number" class="form-control" data-bind="value: Answer.legal" />​
                    <br />
                    <label>សេវាមិនស្របច្បាប់៖</label>
                    <input type="number" class="form-control" data-bind="value: Answer.ilegal" />
                </td>
            </tr>

            <tr class="bg-info" data-bind="with: P1Q4">
                <td align="center">4</td>
                <td>តើមានសេវាឯកជនដែលបានចុះកិច្ចសន្យាជាមួយ OD  អំពីកម្មវិធីភាពជាដៃគូររវាងសេវារដ្ឋនិងឯកជន រួមគ្នាប្រយុទ្ធនិងជម្ងឺគ្រុនចាញ់ដែរឫទេ (PPM)?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q4" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q4" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>

            <tr data-bind="with: P1Q4_1" class="form-inline">
                <td align="center" valign="middle">4.1.</td>
                <td valign="middle">
                    បើមាន សូមបញ្ជាក់ចំនួន៖
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.total" />​
                </td>
            </tr>
            <tr class="bg-info" data-bind="with: P1Q5">
                <td align="center">5</td>
                <td>តើមន្រ្តីមណ្ឌលសុខភាពបានចុះអភិបាលសេវាឯកជនក្នុង៣ខែចុងក្រោយដែរឫទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q5" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q5" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P1Q5_1" class="form-inline">
                <td align="center" valign="middle">5.1</td>
                <td valign="middle">
                    បើមាន  សូមបញ្ជាក់ចំនួន ៖
                </td>
                <td>
                    <label>សេវាឯកជនមានច្បាប់ដែលត្រូវបានចុះអភិបាល៖</label>
                    <input type="number" class="form-control" data-bind="value: Answer.legal" />
                    <br />
                    <label>សេវាឯកជនបានចុះកិច្ចសន្យាដែលត្រូវបានចុះអភិបាល៖</label>
                    <input type="number" class="form-control" data-bind="value: Answer.contract" />
                </td>
            </tr>
            <tr class="bg-info" data-bind="with: P1Q6">
                <td align="center">6</td>
                <td>តើមានការអភិបាលកម្មវិធីគ្រុនចាញ់ពីមន្រ្តីមណ្ឌលសុខភាពទៅអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលគ្រុនចាញ់ក្នុង៣ខែចុងក្រោយនេះដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q6" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q6" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr class="bg-info" data-bind="with: P1Q7">
                <td align="center">7</td>
                <td>តើមានមគ្គុទេសក៏ជាតិចុងក្រោយស្ដីអំពីការព្យាបាលជំងឺគ្រុនចាញ់ ដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q7" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q7" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
        </table>
        <br />
        <!--end part 1-->
        <table class="table table-bordered">
            <tr>
                <th colspan="2">II.	ការបណ្តុះបណ្តាលបុគ្គលិក (ក្នុង៣ខែចុងក្រោយនេះ) </th>
            </tr>
        </table>
        <br />

        <table class="table table-bordered">
            <tr>
                <th>ប្រភេទនៃការបណ្ដុះបណ្ដាល</th>
                <th>ចំនួនបុគ្គលិកដែលបានទទួលការបណ្តុះបណ្តាលក្នុង៣ខែចុងក្រោយ</th>
                <th>បណ្ដុះបណ្ដាលដោយ</th>
                <th>ចំនួនបុគ្គលិកដែលត្រូវការបណ្តុះបណ្តាលបន្ថែម</th>
            </tr>
            <tr data-bind="with: P2.Answer">
                <td>ផ្នែកព្យាបាលជម្ងឺគ្រុនចាញ់</td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: treatment.trainee" /><label>នាក់</label>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: treatment.trainer" />
                </td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: treatment.trainee_more" />​ <label>នាក់</label>
                </td>
            </tr>
            <tr data-bind="with: P2.Answer">
                <td>ការធ្វើរោគវិនិច្ឆ័យដោយប្រើមីក្រូទស្សន៍</td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: microscopy.trainee" /> <label>នាក់</label>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: microscopy.trainer" />
                </td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: microscopy.trainee_more" /> <label>នាក់</label>
                </td>
            </tr>
            <tr data-bind="with: P2.Answer">
                <td>ការធ្វើរោគវិនិច្ឆ័យដោយប្រើតេសរហ័ស</td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: rdt.trainee" /> <label>នាក់</label>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: rdt.trainer" />
                </td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: rdt.trainee_more" /> <label>នាក់</label>
                </td>
            </tr>
            <tr data-bind="with: P2.Answer">
                <td>ផ្នែកអប់រំសុខភាពគ្រុនចាញ់</td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: education.trainee" /> <label>នាក់</label>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: education.trainer" />
                </td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: education.trainee_more" /> <label>នាក់</label>
                </td>
            </tr>
            <tr data-bind="with: P2.Answer">
                <td>ផ្សេងៗ</td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: other.trainee" /> <label>នាក់</label>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: other.trainer" />
                </td>
                <td class="form-inline">
                    <input type="number" class="form-control" data-bind="value: other.trainee_more" /> <label>នាក់</label>
                </td>
            </tr>
        </table>
        <!--part II end-->
        <br />
        <table class="table table-bordered">
            <tr>
                <th colspan="2">III. គុណភាពនៃការពិនិត្យនិងព្យាបាលជម្ងឺគ្រុនចាញ់ (ពិនិត្យក្នុងសៀវភៅបញ្ជីរកត់ត្រាពិគ្រោះជំងឺក្រៅ) </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
           <thead>
               <tr>
                   <th rowspan="2" align="center" valign="middle">លរ</th>
                   <th rowspan="2" align="center" valign="middle">ភេទ</th>
                   <th rowspan="2" align="center" valign="middle">អាយុ </th>
                   <th rowspan="2" align="center" valign="middle">ទំងន់</th>
                   <th rowspan="2" align="center" valign="middle">ប្រភេទមេរោគ</th>
                   <th colspan="4" align="center" valign="middle">ការព្យាបាល</th>
               </tr>
               <tr>
                   <th align="center" valign="middle">ឈ្មោះថ្នាំ/បញ្ជូន</th>
                   <th align="center" valign="middle"># គ្រាប់/១ថ្ងៃ</th>
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
					<td><input type="text" class="form-control text-center en" data-bind="value: qty" numonly="int"></td>
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
         <!--part III end-->
        <br />
        <table class="table table-bordered">
            <tr>
                <th colspan="3">IV.	សម្ភារៈបរិក្ខារនិងឱសថ (ពិនិត្យពេលចុះអភិបាល)</th>
            </tr>
        </table>
        <br />

        <table class="table table-bordered">
            <tr>
                <th>ល.រ</th>
                <th>សម្ភារៈ ឱសថ និង បរិក្ខារ</th>
                <th>ស្ថានភាពស្តុកនៅថ្ងៃចុះអភិបាល</th>
                <th>ផ្សេងៗ</th>
            </tr>
            <tr data-bind="with: P4Q1.Answer">
                <td align="center">1</td>
                <td>តេស្តរហ័ស (RDT)</td>
                <td align="center" class="form-inline">
                    <select class="form-control font12" data-bind="value: status">
						<option></option>
						<option value="out_of_stock">ដាច់ស្តុក</option>
						<option value="not_out_of_stock">មិនដាច់ស្តុក</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: other.trainer" />
                </td>
            </tr>
            <tr data-bind="with: P4Q2.Answer">
                <td align="center">2</td>
                <td>ថ្នាំព្យាបាលគ្រុនចាញ់ [ACT (Eurartesim, Duo-Cotexin & A+M)]</td>
                <td align="center" class="form-inline">
                    <select class="form-control font12" data-bind="value: status">
						<option></option>
						<option value="male">ដាច់ស្តុក</option>
						<option value="female">មិនដាច់ស្តុក</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: other.trainer" />
                </td>
            </tr>
        </table>
        <br />
        <!--part IV end-->

        <table class="table table-bordered">
            <tr>
                <th colspan="3">V. ផ្នែកមន្ទីរពិសោធន៍៖</th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered"> 
            <tr class="bg-info" data-bind="with: P5Q1">
                <td align="center">1</td>
                <td>តើមានមីក្រូទស្សន៍នៅមណ្ឌលសុខភាពដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q1" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q1" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី៣</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P5Q1_1">
                <td align="center">1.1.</td>
                <td>បើមាន  សូមបញ្ជាក់ចំនួនកញ្ចក់ឈាមរកមេរោគគ្រុនចាញ់សរុបក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    <input type="number" class="form-control" data-bind="value: Answer.total" />​
                </td>
            </tr>
            <tr data-bind="with: P5Q1_1_1">
                <td align="center">1.1.1.</td>
                <td>ចំនួនកញ្ចក់ឈាមអវិជ្ជមានក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    <input type="number" class="form-control" data-bind="value: Answer.total" />​
                </td>
            </tr>
            <tr data-bind="with: P5Q1_1_2">
                <td align="center">1.1.2.</td>
                <td>ចំនួនកញ្ចក់ឈាមវិជ្ជមានក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    សរុប៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.total" />​
                     Pf៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.pf" />​
                     Pv៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.pv" />​
                     Mix៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.mix" />​
                </td>
            </tr>
            <tr class="bg-info" data-bind="with: P5Q2">
                <td align="center">2</td>
                <td>តើបានអនុវត្តប្រព័ន្ធធានាគុណភាពធ្វើតេស្តដោយមីក្រូទស្សន៍ក្នុង៣ខែចុងក្រោយនេះដែរឬទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q2" value="Yes" data-bind="checked: Answer.tick" />
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
            <tr class="bg-info" data-bind="with: P5Q3">
                <td align="center">3</td>
                <td>តើមានធ្វើតេស្តរហ័សរកមេរោគគ្រុនចាញ់ដោយមណ្ឌលសុខភាពដែឫទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q3" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q3" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី៤</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P5Q3_1">
                <td align="center">3.1.</td>
                <td>បើមាន  សូមបញ្ជាក់ចំនួនតេស្តរហ័សសរុបក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    <input type="number" class="form-control" data-bind="value: Answer.total" />​
                </td>
            </tr>
            <tr data-bind="with: P5Q3_1_1">
                <td align="center">3.1.1.</td>
                <td>ចំនួនតេស្តរហ័សអវិជ្ជមានក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    <input type="number" class="form-control" data-bind="value: Answer.total" />​
                </td>
            </tr>
            <tr data-bind="with: P5Q3_1_2">
                <td align="center">3.1.2.</td>
                <td>ចំនួនតេស្តរហ័សវិជ្ជមានក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    សរុប៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.total" />​
                     Pf៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.pf" />​
                     Pv៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.pv" />​
                     Mix៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.mix" />​
                </td>
            </tr>

            <tr class="bg-info" data-bind="with: P5Q4">
                <td align="center">4</td>
                <td>តើមានធ្វើតេស្តរហ័សរកមេរោគគ្រុនចាញ់ដោយអ្នកស្មគ្រ័ចិត្តភូមិក្នុង៣ខែចុងក្រោយនេះដែឫទេ?</td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q4" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P5Q4" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទីVI</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P5Q4_1">
                <td align="center">4.1.</td>
                <td>បើមាន  សូមបញ្ជាក់ចំនួនតេស្តរហ័សសរុបក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    <input type="number" class="form-control" data-bind="value: Answer.total" />​
                </td>
            </tr>
            <tr data-bind="with: P5Q4_1_1">
                <td align="center">4.1.1.</td>
                <td>ចំនួនតេស្តរហ័សអវិជ្ជមានក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    <input type="number" class="form-control" data-bind="value: Answer.total" />​
                </td>
            </tr>
            <tr data-bind="with: P5Q4_1_2">
                <td align="center">4.1.2.</td>
                <td>ចំនួនតេស្តរហ័សវិជ្ជមានក្នុង៣ខែចុងក្រោយនេះ</td>
                <td align="center" class="form-inline">
                    សរុប៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.total" />​
                     Pf៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.pf" />​
                     Pv៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.pv" />​
                     Mix៖<input style="width:63px" type="number" class="form-control" data-bind="value: Answer.mix" />​
                </td>
            </tr>
        </table>
        <br />
        <!--part 5 end-->
        <table class="table table-bordered">
            <tr>
                <th colspan="3">VI.	គុណភាពនៃទិន្ន័យក្នុងប្រព័ន្ធព៌តមានសុខាភិបាល </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
                <th></th>
                <th></th>
                <th align="center">ចំនួនពី HC</th>
                <th align="center">ចំនួនពី VMW</th>
                <th align="center">ចំនួនពី HC1</th>
            </tr>
            <tr data-bind="with: P5.Answer">
                <td>1</td>
                <td>ចំនួនតេស្តសរុប (ដោយកពា្ចក់ឈាម ឬ/និង តេស្តរហ័ស)</td>
                <td><input type="number" class="form-control" data-bind="value: test.hc" /></td>
                <td><input type="number" class="form-control" data-bind="value: test.vmw" /></td>
                <td><input type="number" class="form-control" data-bind="value: test.hc1" /></td>
            </tr>
             <tr data-bind="with: P5.Answer">
                <td>2</td>
                <td>ចំនួនតេស្តវិជ្ជមានសរុប (ដោយកពា្ចក់ឈាម ឬ/និង តេស្តរហ័ស)</td>
                <td><input type="number" class="form-control" data-bind="value: positive.hc" /></td>
                <td><input type="number" class="form-control" data-bind="value: positive.vmw" /></td>
                <td><input type="number" class="form-control" data-bind="value: positive.hc1" /></td>
            </tr>
             <tr data-bind="with: P5.Answer">
                <td>3</td>
                <td>ចំនួនករណីគ្រុនចាញ់កំរិតស្រាលបានទទួលការព្យាបាលសរុប</td>
                <td><input type="number" class="form-control" data-bind="value: simple.hc" /></td>
                <td><input type="number" class="form-control" data-bind="value: simple.vmw" /></td>
                <td><input type="number" class="form-control" data-bind="value: simple.hc1" /></td>
            </tr>
        </table>

        <!--Part VII end-->
        <br />
        <table class="table table-bordered">
            <tr>
                <th>VII. បញ្ហាដែលរកឃើញ និងអនុសាសន៍ សំនូមពរ  </th>
                <th class="form-inline">
                </th>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr class="bg-info">
                <th align="center">ល.រ</th>
                <th align="center">បញ្ហា</th>
                <th align="center">ដំណោះស្រាយ</th>
                <th align="center">អ្នកទទួលខុសត្រូវ</th>
                <th align="center">កាលបរិឆ្ឆេទ</th>
            </tr>
            <tr data-bind="with: P6Q1">
                <td align="center">1</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td align="center" class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
            <tr data-bind="with: P6Q2">
                <td align="center">2</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td align="center" class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
            <tr data-bind="with: P6Q3">
                <td align="center">3</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td align="center" class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
            <tr data-bind="with: P6Q4">
                <td align="center">4</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td align="center" class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
            <tr data-bind="with: P6Q5">
                <td align="center">5</td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.problem" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.solution" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Answer.responsible" />
                </td>
                <td align="center" class="relative ">
                    <input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
            </tr>
        </table>
        <br />
        <div data-bind="with: P6Q6">
            <p>សំនូមពរ</p>
            <textarea class="form-control" rows="10" style="resize:none" data-bind="value: Answer"></textarea>
        </div>
    </div>
    <div data-bind="with: masterModel">
        <label>តំណាងមណ្ឌលសុខភាព៖ </label>
        <input type="text" class="form-control" data-bind="value: HCRepresentative" />
        <label>តំណាងអ្នកចុះអភិបាល៖ </label>
        <input type="text" class="form-control" data-bind="value: VisitorName" />
    </div>
</div>

<?=latestJs('/media/ViewModel/Checklist_Cmep_HC.js')?>
