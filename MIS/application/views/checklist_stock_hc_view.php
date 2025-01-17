<style>
	.pad5 { padding: 5px; }
	textarea { resize: vertical; }
</style>

<div class="kh" data-bind="visible: view() == 'detail', with: masterModel">
    <div class="divcenter relative">
        <h3 class="text-center text-primary">តាមដាននិងវាយតម្លៃការគ្រប់គ្រងឱសថនិងបរិក្ខារនៅតាមឃ្លាំងមណ្ឌលសុខភាព</h3>
        <br />

        <div class="form-group bg-gray pad5 text-bold">បំពេញមុនចុះអភិបាល</div>
        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">ឈ្មោះមន្ត្រីចុះអភិបាល</span>
                <input type="text" class="form-control" data-bind="value: VisitorName" />
            </div>
        </div>
        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">ខេត្ត</span>
                <select data-bind="value: Code_Prov_N,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''"
                    class="form-control minwidth150 kh"></select>
            </div>
        </div>
        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">ស្រុកប្រតិបត្ដិ</span>
                <select data-bind="value: Code_OD_T,
						options: odList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''"
                    class="form-control minwidth150 kh"></select>
            </div>
        </div>
        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">មណ្ឌលសុខភាព</span>
                <select data-bind="value: Code_Facility_T,
						options: hcList(),
						optionsValue: 'code',
						optionsText: 'nameK',
						optionsCaption: ''"
                    class="form-control minwidth150 kh"></select>
            </div>
        </div>
        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">កាលបរិច្ឆេទចុះត្រួតពិនិត្យ(ថ្ងៃ-ខែ-ឆ្នាំ)</span>
                <input type="text" class="form-control text-center en" data-bind="datePicker: VisitDate" />
            </div>
        </div>
        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">ចំនួនករណី</span>
                <input type="text" class="form-control text-center en" data-bind="value: CaseQty" numonly="int" />
            </div>
        </div>
        <br />

        <div class="form-group bg-gray pad5 text-bold">ការសង្កេត</div>
        <table class="table">
            <tr>
                <th>១</th>
                <td>
                    <b>តើឃ្លាំងឱសថបើកទ្វារ និងមានបុគ្គលិកឬទេនៅពេលចុះអភិបាល?</b>
                    <br />
                    បើគ្មាន: យោបល់ និងមូលហេតុ៖
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="1" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="1" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="1.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>២</th>
                <td>
                    <b>តើមានឱសថ និងតេស្តគ្រុនចាញ់ណាមួយដាច់ស្តុកឬទេ?</b>
                    <br />
                    បើមានរាយឈ្មោះ និងរយៈពេលដាច់ស្តុក៖
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="2" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="2" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="2.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>៣</th>
                <td>
                    <b>តើមានឱសថ និងតេស្តគ្រុនចាញ់ណាមួយផុតកំណត់កាលប្រើប្រាស់ឬទេ?</b>
                    <br />
                    បើមានរាយឈ្មោះ និងរយៈពេលផុតកំណត់
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="3" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="3" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="3.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>៤</th>
                <td>
                    <b>តើនិតិវិធីផុតកំណត់កាលប្រើប្រាស់មុនត្រូវបានប្រើប្រាស់មុនបានអនុវត្តត្រឹមត្រូវរឺទេ? (FEFO)</b>
                    <br />
                    ចំណាប់អារម្មណ៍ រឺ យោបល់
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="4" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="4" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="4.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>៥</th>
                <td>
                    <b>តើការរៀបចំទុកដាក់ឱសថ និងសំភារៈបានល្អឬទេ?</b>
                    
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="5" value="Good" data-bind="checked: $root.getAnswer($element)" />
                            <span>ល្អ</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="5" value="Medium" data-bind="checked: $root.getAnswer($element)" />
                            <span>មធ្យម</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="5" value="Bad" data-bind="checked: $root.getAnswer($element)" />
                            <span>មិនល្អ</span>
                        </label>
                    </div>
                    <br />
                    
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    បើមធ្យម  ឬ មិនល្អ តើមានចំណុចអ្វីខ្លះដែលគួរកែលម្អ?
                    <textarea class="form-control" name="5.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>6</th>
                <td>
                    <b>តើការទុកដាក់ឯកសារចំណូលចំណាយ សលាកបត្រឃ្លាំង និងឯកសារផ្សេងទៀតដែលទាក់ទងនឹងការគ្រប់គ្រងឃ្លាំងបានល្អ និងកត់ត្រាបានត្រឹមត្រូវរឺទេ?</b>
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="6" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="6" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="6.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>7</th>
                <td>
                    <b>តើមណ្ឌលសុខភាពបានបញ្ចូលរបាយការណ៍ស្តុកឱសថ បរិក្ខារកម្មវិធីគ្រុនចាញ់បានទៀងទាត់ដែរ ឬទេ? (MIS) </b>
                    <br />ប្រសិនជា ទេ ចូរបញ្ជា្កក់
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="7" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="7" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="7.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>8</th>
                <td>
                    <b>តើការបញ្ចូលរបាយការណ៍ស្តុកឱសថ បរិក្ខារកម្មវិធីគ្រុនចាញ់ក្នុង MIS របស់
                     ម.ស ត្រឹមត្រូវផ្ទៀងផ្ទាត់នឹងរបាយការណ៍ឱសថ ឬសលាកបត្រឃ្លាំង និងឱសថ
                     បរិក្ខារ លើធ្នើដែរឬទេ? </b>
                    <br />ប្រសិនជាមិនត្រឹមត្រូវ ចូរបញ្ជាក់
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="8" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="8" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="8.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>9</th>
                <td>
                    <b>
                        តើការបញ្ចូលរបាយការណ៍ស្តុកឱសថ បរិក្ខារកម្មវិធីគ្រុនចាញ់ក្នុង MIS របស់
                       ម.ស ត្រឹមត្រូវដែរឬទេនូវការបញ្ចូល ឯកត្តា កាលបរិច្ឆេទផុតកំណត់ប្រើប្រាស់
                       ខ្ទង់កែតម្រូវ ។ល៕
                    </b>
                    <br />ចូរបញ្ជាក់ចំនុចមិនត្រឹមត្រូវ
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="9" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="9" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <textarea class="form-control" name="9.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
        </table>
    </div>
    <br />
    <div class="pad5 text-bold">១០ ស្តុកឱសថ សំភារៈ បរិក្ខារកម្មវិធីគ្រុនចាញ់នៅថ្ងៃចុះអភិបាល៖</div>
    <br />

    <table class="table table-bordered">
        <thead>
            <tr>
                <th align="center" valign="top">លរ</th>
                <th align="center" valign="top">ឈ្មោះឱសថនិងសំភារៈ</th>
                <th align="center" valign="top">កម្រិត</th>
                <th align="center" valign="top">ខ្នាត</th>
                <th align="center" valign="top">ស្តុកបច្ចុប្បន្ន</th>
                <th align="center" valign="top">ស្តុកលើធ្នើ</th>
                <th align="center" valign="top">កាលបរិច្ឆេទប្រើ</th>
                <th align="center" valign="top">សំគាល់</th>
            </tr>
        </thead>
        <tbody data-bind="foreach: $root.stockList, fixedHeader: true" class="en">
            <tr>
                <td align="center" valign="middle" data-bind="text: code"></td>
                <td valign="middle" data-bind="text: name"></td>
                <td valign="middle" data-bind="text: strength"></td>
                <td valign="middle" data-bind="text: unit"></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: stock" numonly="float" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: qty" numonly="float" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: date" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: note" />
                </td>
            </tr>
        </tbody>
    </table>
    <br />
    <br />

    <p>
        <b>ចំណាប់អារម្មណ៏របស់មន្រ្តីចុះអភិបាល</b>
    </p>
    <textarea class="form-control" rows="5" data-bind="value: Interest"></textarea>
    <br />

</div>

<?=latestJs('/media/ViewModel/Checklist_Stock_HC.js')?>