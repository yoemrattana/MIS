<div class="kh divcenter" style="width:85%" data-bind="visible: view() == 'detail'">
    <h3 class="text-center">ការត្រួតពិនិត្យតាមដាននិងវាយតំលៃជំងឺគ្រុនចាញ់នៅការិយាល័យស្រុកប្រតិបត្ដិ</h3>
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
            <tr class="bg-info" data-bind="with: P1Q1">
                <th align="center">1</th>
                <th>តើស្រុកប្រតិបត្តិ មានផែនការសកម្មភាពសំរាប់កម្មវិធីគ្រុនចាញ់ដែរឬទេ?</th>
                <th align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q1" value="Yes" score="1.5" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q1" value="No" score="0" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី២</span>
                        </label>
                    </span>
                </th>
            </tr>
            <tr data-bind="with: P1Q1_1">
                <td align="center" valign="middle">1.1</td>
                <td colspan="2" valign="middle" class="form-inline">
                    បើមានសូមបង្ហាញ៖
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="P1Q1_1" value="yearly" data-bind="checked: Answer.tick" />
                            <span>ផែនការប្រចាំឆ្នាំ</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="P1Q1_1" value="quarterly" data-bind="checked: Answer.tick" />
                            <span>
                                ផែនការប្រចាំត្រីមាស
                            </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="P1Q1_1" value="monthly" data-bind="checked: Answer.tick" />
                            <span>ផែនការប្រចាំខែ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="bg-info" data-bind="with: P1Q2">
                <th align="center">2</th>
                <th>តើមានការចែកមុងជ្រលក់ថ្នាំ  (ITN)ក្នុងតំបន់គ្របដណ្តប់ដោយស្រុកប្រតិបត្តិក្នុង៣ខែចុងក្រោយនេះដែរឫទេ?</th>
                <th align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2" value="Yes" score="1.5" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2" value="No" score="0" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី៣</span>
                        </label>
                    </span>
                </th>
            </tr>
            <tr data-bind="with: P1Q2_1" class="form-inline">
                <td align="center" valign="middle">2.1</td>
                <td valign="middle">
                    បើមាន  សូមបញ្ជាក់ចំនួនមុងដែលចែកអោយ៖
                </td>
                <td>
                    <label>ប្រជាជនគោលដៅ (ប្រជាជនមានលំនៅអចិន្ត្រៃក្នុងតំបន់គ្រុនចាញ់)</label>
                    <input type="number" class="form-control" data-bind="value: Answer.pop" />​ មុង <br />
                    <label>ប្រជាជនចល័ត</label>
                    <input type="number" class="form-control" data-bind="value: Answer.mobile_pop" /> មុង
                </td>
            </tr>
            <tr data-bind="with: P1Q2_2" class="form-inline">
                <td align="center" valign="middle">2.2</td>
                <td  valign="middle">
                    បើមាន តើមានរបាយការណ៍ស្តីពីការចែកមុងដែរឬទេ? 
                </td>
                <td class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2_2" value="Yes" score="1.5" data-bind="checked: Answer.tick" />
                            <span>មាន (បើមាន សូមបង្ហាញរបាយការណ៍)</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2_2" value="No" score="0" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P1Q2_3" class="form-inline">
                <td align="center" valign="middle">2.3</td>
                <td valign="middle">
                    តើបានបញ្ចូលរបាយការណ៍នេះទៅក្នុង ប្រព័ន្ធ MIS ដែរឬទេ?
                </td>
                <td class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2_3" value="Yes" score="1.5" data-bind="checked: Answer.tick" />
                            <span>មាន (បើបាន សូមមើលក្នុង computer)	</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q2_3" value="No" score="0" data-bind="checked: Answer.tick" />
                            <span>មិនបាន</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr class="bg-info" data-bind="with: P1Q3">
                <td align="center">3</td>
                <td>តើមានសេវាឯកជន (បន្ទប់ពិគ្រោះជំងឺ និងឪសថស្ថាន) ពិនិត្យនិងព្យាបាលជំងឺគ្រុនចាញ់  ក្នុងតំបន់គ្របដណ្តប់ដោយស្រុកប្រតិបត្តិដែរឬទេ?  </td>
                <td align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q3" value="Yes" score="1.5" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q3" value="No" score="0" data-bind="checked: Answer.tick" />
                            <span>គ្មាន </span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P1Q3_1" class="form-inline">
                <td align="center" valign="middle">3.1</td>
                <td valign="middle">
                    បើមាន  សូមបញ្ជាក់ចំនួន៖
                </td>
                <td>
                    <label>សេវាស្របច្បាប់ចាស់ </label>
                    <input type="number" class="form-control" data-bind="value: Answer.legal" />​ 
                    <label>ក្នុងនោះមាន PPM ប៉ុន្មាន</label> <input type="number" class="form-control" data-bind="value: Answer.ppm" />​
                    <br /> <br />
                    <label>សេវាស្របច្បាប់ថ្មី </label>
                    <input type="number" class="form-control" data-bind="value: Answer.new" />
                    <br /> <br />
                    <label>សេវាមិនស្របច្បាប់ </label>
                    <input type="number" class="form-control" data-bind="value: Answer.ilegal" />
                </td>
            </tr>
            <tr class="form-inline">
                <td align="center" valign="middle">3.2</td>
                <td valign="middle">
                   បើគ្មាន
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: P1Q3_2.Answer" />
                </td>
            </tr>
            <tr class="bg-info" data-bind="with: P1Q4">
                <th align="center">4</th>
                <th>តើមានការត្រួតពិនិត្យតាមដាននិងវាយតំលៃការងារគ្រុនចាញ់ក្នុង៣ខែចុងក្រោយនេះដែរឫទេ?</th>
                <th align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q4" value="Yes" score="1.5" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P1Q4" value="No" score="0" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទីII</span>
                        </label>
                    </span>
                </th>
            </tr>
            <tr data-bind="with: P1Q4_1" class="form-inline">
                <td align="center" valign="middle">3.1</td>
                <td valign="middle">
                    បើមាន៖
                </td>
                <td>
                    <label>តើបានចុះត្រួតពិនិត្យតាមដាននិងវាយតំលៃទៅមណ្ឌលសុខភាពសឬប៉ុស្តិ៍សុខភាពរុបបានចំនួនប៉ុន្មាន? </label>
                    <input type="number" class="form-control" data-bind="value: Answer.hc" /> HC/HP
                    <br />
                    <br />
                    <label>តើបានចុះត្រួតពិនិត្យតាមដាននិងវាយតំលៃទៅ PPM សរុបបានចំនួនប៉ុន្មានកន្លែង? </label>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" /> PPM
                    <br />
                    <br />
                    <label>តើបានចុះត្រួតពិនិត្យតាមដាននិងវាយតំលៃទៅ VMW/MMW សរុបបានចំនួនប៉ុន្មាននាក់? </label>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" /> VMW/MMW
                </td>
            </tr>
        </table>
        <br />

        <table class="table table-bordered">
            <tr data-bind="with:P2">
                <th >II. ការបណ្តុះបណ្តាលបុគ្គលិក៖ (ក្នុងរយៈពេល៣ខែចុងក្រោយ) </th>
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
            <tr class="bg-info" data-bind="with: P2Q1">
                <th align="center">1</th>
                <th>តើបានបណ្តុះបណ្តាល បុគ្គលិកពីជំងឺគ្រុនចាញ់ដែរឬទេ?</th>
                <th colspan="6" align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P2Q1" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P2Q1" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី2</span>
                        </label>
                    </span>
                </th>
            </tr>

            <tr>
                <td rowspan="7" align="center" valign="middle">១.១.</td>
                <td rowspan="2" valign="middle"> បើបាន សូមបញ្ជាក់ចំនួនក្នុងតារាងខាងក្រោម៖ </td>
                <td colspan="2" align="center" width="50">នៅថ្នាក់ OD</td>
                <td colspan="2" align="center" width="50">នៅថ្នាក់ HC</td>
                <td colspan="2" align="center" width="50">នៅថ្នាក់ VMW/MMW</td>
            </tr>
            <tr align="center">
                <td>ប្រុស</td>
                <td>ស្រី</td>
                <td>ប្រុស</td>
                <td>ស្រី</td>
                <td>ប្រុស</td>
                <td>ស្រី</td>
            </tr>
            <tr data-bind="with: P2Q1_1.Answer">
                <td>ការព្យាបាលជំងឺគ្រុនចាញ់</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.vmw_female" />
                </td>
            </tr>
            <tr data-bind="with: P2Q1_1.Answer">
                <td>ការធ្វើរោគវិនិច្ឆ័យដោយប្រើមីក្រូទស្សន៍</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.vmw_female" />
                </td>
            </tr>
            <tr data-bind="with: P2Q1_1.Answer">
                <td>ការធ្វើរោគវិនិច្ឆ័យដោយប្រើតេសរហ័ស</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.vmw_female" />
                </td>
            </tr>
            <tr data-bind="with: P2Q1_1.Answer">
                <td>ការអប់រំសុខភាពគ្រុនចាញ់</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.vmw_female" />
                </td>
            </tr>
            <tr data-bind="with: P2Q1_1.Answer">
                <td>ការបណ្តុះបណ្តាលផ្សេងៗទៀត</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.vmw_female" />
                </td>
            </tr>
            <!--qestion 1 end-->
            <tr class="bg-info" data-bind="with: P2Q2">
                <th align="center">2</th>
                <th>តើអ្នកត្រូវការបណ្តុះបណ្តាល បុគ្គលិកពីជំងឺគ្រុនចាញ់បន្ថែមដែរឬទេ?</th>
                <th colspan="6" align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P2Q2" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P2Q2" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទីIII</span>
                        </label>
                    </span>
                </th>
            </tr>

            <tr>
                <td rowspan="7" align="center" valign="middle">២.១.</td>
                <td rowspan="2" valign="middle"> បើត្រូវការ សូមបញ្ជាក់ចំនួនក្នុងតារាងខាងក្រោម៖  </td>
                <td colspan="2" align="center" width="50">នៅថ្នាក់ OD</td>
                <td colspan="2" align="center" width="50">នៅថ្នាក់ HC</td>
                <td colspan="2" align="center" width="50">នៅថ្នាក់ VMW/MMW</td>
            </tr>
            <tr align="center">
                <td>ប្រុស</td>
                <td>ស្រី</td>
                <td>ប្រុស</td>
                <td>ស្រី</td>
                <td>ប្រុស</td>
                <td>ស្រី</td>
            </tr>
            <tr data-bind="with: P2Q2_1.Answer">
                <td>ការព្យាបាលជំងឺគ្រុនចាញ់</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: treatment.vmw_female" />
                </td>
            </tr>
            <tr data-bind="with: P2Q2_1.Answer">
                <td>ការធ្វើរោគវិនិច្ឆ័យដោយប្រើមីក្រូទស្សន៍</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: microscopy.vmw_female" />
                </td>
            </tr>
            <tr data-bind="with: P2Q2_1.Answer">
                <td>ការធ្វើរោគវិនិច្ឆ័យដោយប្រើតេសរហ័ស</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: rdt.vmw_female" />
                </td>
            </tr>
            <tr data-bind="with: P2Q2_1.Answer">
                <td>ការអប់រំសុខភាពគ្រុនចាញ់</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: education.vmw_female" />
                </td>
            </tr>
            <tr data-bind="with: P2Q2_1.Answer">
                <td>ការបណ្តុះបណ្តាលផ្សេងៗទៀត</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.od_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.od_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.hc_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.hc_female" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.vmw_male" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: training.vmw_female" />
                </td>
            </tr>
        </table> 
        <!--part 2 end-->
        <br />
        <table class="table table-bordered">
            <tr data-bind="with:P3">
                <th>III.សម្ភារៈបរិក្ខារនិងឱសថ៖ (ពិនិត្យពេលចុះអភិបាល) </th>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">1</td>
                <td valign="middle">RDT</td>
                <td align="center" width="150"><input type="number" class="form-control" data-bind="value: rdt.amc" /></td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: rdt.balance" />
                </td>
                <td align="center" width="150">
                    <input type="number" class="form-control" data-bind="value: rdt.mos" />
                </td>
                <td align="center" width="150">
                    <input type="text" class="form-control" data-bind="value: rdt.status" />
                </td>
            </tr>
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">2</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">3</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">4</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">5</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">6</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">7</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">8</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">9</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">10</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">11</td>
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
            <tr data-bind="with:P3Q1.Answer">
                <td align="center" valign="middle">12</td>
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
        <!--part 3 end-->
        <br />
        <table class="table table-bordered">
            <tr data-bind="with:P4">
                <th>IV.	ប្រព័ន្ធព័ត៌មានសុខាភិបាល៖  </th>
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
            <tr data-bind="with: P4Q1">
                <td align="center">1</td>
                <td>តើអ្នកទទួលខុសត្រូវលើប្រព័ន្ធព័ត៌មានសុខាភិបាល បានទទួលការបណ្តុះបណ្តាលអំពីប្រព័ន្ធពត៌មានជំងឺគ្រុនចាញ់ (MIS) ដែឬទេ?</td>
                <td colspan="6" align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P4Q1" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P4Q1" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P4Q2">
                <td align="center">2</td>
                <td>តើមានកុំព្យូទ័រសំរាប់ប្រើប្រាស់ដែរឬទេ? </td>
                <td colspan="6" align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P4Q2" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P4Q2" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន &#8594; សំនួរទី3</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="center">2.1</td>
                <td>បើមាន តើបានទទួលពីឆ្នាំណា?</td>
                <td colspan="6" align="center" class="form-inline">
                    <input type="text" class="form-control" data-bind="value: P4Q2_1.Answer" />
                </td>
            </tr>
            <tr data-bind="with: P4Q2_2">
                <td align="center">2.2</td>
                <td>បើមាន តើនៅប្រើប្រាស់បានដែរឬទេ? (ពិនិត្យផ្ទាល់)</td>
                <td colspan="6" align="center" class="form-inline">
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P4Q2_2" value="Yes" data-bind="checked: Answer.tick" />
                            <span>មាន</span>
                        </label>
                    </span>
                    <span class="radio radio-lg">
                        <label>
                            <input type="radio" name="P4Q2_2" value="No" data-bind="checked: Answer.tick" />
                            <span>គ្មាន</span>
                        </label>
                    </span>
                </td>
            </tr>
            <tr data-bind="with: P4Q3">
                <td align="center">3</td>
                <td>តើអ្នកផ្ញើរបាយការណ៍ MIS មកថ្នាក់ជាតិដោយរបៀបណា?</td>
                <td colspan="6" align="center" class="form-inline">
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="P4Q3" value="monthly" data-bind="checked: Answer.tick" />
                            <span>ដោយប្រព័ន្ធ Internet</span>
                        </label>
                        <label>
                            &nbsp;&nbsp;<span>ផ្សេងៗ</span>
                            <input type="text" class="form-control" data-bind="value: Answer.other" />
                        </label>
                    </div>
                </td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <th colspan="2" valign="middle" rowspan="2">ការផ្ទៀងផ្ទាត់របាយការណ៍គ្រុនចាញ់ </th>
                <th valign="middle" align="center" colspan="2" rowspan="2">នៅក្នុងប្រព័ន្ធ HIS(HC1 + HO2)</th>
                <th colspan="4" align="center"  valign="middle">នៅក្នុងប្រព័ន្ធ MIS</th>
            </tr>
            <tr>
                <th align="center" colspan="2" valign="middle">ពីអ្នកស្ម័គ្រចិត្ត</th>
                <th align="center" valign="middle" colspan="2">ពី PPM</th>
            </tr>
            <tr>
                <td colspan="2"  data-bind="with: P4Q3_1" class="relative kh form-inline">
                    ពីថ្ងៃទី<input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date_from, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                    ដល់ថ្ងៃទី<input type="text" class="form-control width150 text-center" data-bind="datePicker: Answer.date_to, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />
                </td>
                <td>ក្នុងក្រដាសរបាយការណ៍  HC1 + HO2</td>
                <td>ក្នុងប្រព័ន្ធ HIS(ក្នុង Computer)</td>
                <td>ក្នុងក្រដាសរបាយការណ៍ប្រជុំប្រចាំខែ</td>
                <td>ក្នុងប្រព័ន្ធ MIS(ក្នុង Computer)</td>
                <td>ក្នុងក្រដាសរបាយការណ៍ពី PPM</td>
                <td>ក្នុងប្រព័ន្ធ MIS(ក្នុង Computer)</td>
            </tr>
            
            <tr data-bind="with:rdt">
                <td>4.</td>
                <td>ចំនួនតេស្តសរុប (ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស)</td>
                <td><input type="number" class="form-control" data-bind="value: Answer.hc1" /></td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr data-bind="with:positive">
                <td>5.</td>
                <td>ចំនួនតេស្តវិជ្ជមានសរុប (ដោយកពា្ចក់ឈាមនិងតេស្តរហ័ស)</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:pf">
                <td></td>
                <td>Pf</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:pv">
                <td></td>
                <td>Pv</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:mix">
                <td></td>
                <td>Mix</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:pk">
                <td></td>
                <td>Pk</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:pm">
                <td></td>
                <td>Pm</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:po">
                <td></td>
                <td>Po</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:simple">
                <td></td>
                <td>ចំនួនករណីគ្រុនចាញ់កំរិតស្រាលបានទទួលការព្យាបាលសរុប</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:severe">
                <td></td>
                <td>ចំនួនករណីគ្រុនចាញ់កំរិតធ្ងន់បានទទួលការព្យាបាលសរុប</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
            <tr data-bind="with:morality">
                <td></td>
                <td>ចំនួនករណីគ្រុនចាញ់ស្លាប់សរុប</td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.hc1" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.his" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.vmw_mis" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm" />
                </td>
                <td>
                    <input type="number" class="form-control" data-bind="value: Answer.ppm_mis" />
                </td>
            </tr>
        </table>

        <!--Part 4 end-->
        <br />
        <table class="table table-bordered">
            <tr data-bind="with:P4">
                <th>V. បញ្ហាដែលរកឃើញនិងដំណោះស្រាយ៖  </th>
                <th class="form-inline">
                </th>
            </tr>
        </table>
        <table class="table table-bordered">
            <tr class="bg-info">
                <th>ល.រ</th>
                <th>បញ្ហា</th>
                <th>ដំណោះស្រាយ</th>
                <th>អ្នកទទួលខុសត្រូវ</th>
                <th>កាលបរិឆ្ឆេទ</th>
            </tr>
            <tr data-bind="with: P5Q1">
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
            <tr data-bind="with: P5Q2">
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
            <tr data-bind="with: P5Q3">
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
            <tr data-bind="with: P5Q4">
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
            <tr data-bind="with: P5Q5">
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
        <div data-bind="with: P5Q6_1">
            <p>៦.១. សំណូមពរពីអ្នកត្រួតពិនិត្យតាមដាននិងវាយតំលៃ៖</p>
            <textarea class="form-control" rows="10" style="resize:none" data-bind="value: Answer"></textarea>
        </div>
        <div data-bind="with: P5Q6_2">
            <p>៦.២. សំណូមពរពីស្រុកប្រតិបត្តិ៖</p>
            <textarea class="form-control" rows="10" style="resize:none" data-bind="value: Answer"></textarea>
        </div>
    </div>

    <div data-bind="with: masterModel">
        <label>តំណាងស្រុកប្រតិបត្តិ៖ </label>
        <input type="text" class="form-control" data-bind="value: ODRepresentative" />
        <label>តំណាងអ្នកចុះត្រួតពិនិត្យតាមដាននិងវាយតំលៃ៖ ៖ </label>
        <input type="text" class="form-control" data-bind="value: MnERepresentative" />
    </div>
    
</div>

<?=latestJs('/media/ViewModel/Checklist_Cmep_OD.js')?>
