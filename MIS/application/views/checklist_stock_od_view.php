<style>
	.pad5 { padding: 5px; }
	textarea { resize: vertical; }
</style>

<div class="kh" data-bind="visible: view() == 'detail', with: masterModel">
    <div class="divcenter relative">
        <h3 class="text-center text-primary">តាមដាននិងវាយតម្លៃការគ្រប់គ្រងឱសថនិងបរិក្ខារនៅតាមឃ្លាំងប្រតិបត្តិ</h3>
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
                <span class="input-group-addon">កាលបរិច្ឆេទចុះត្រួតពិនិត្យ(ថ្ងៃ-ខែ-ឆ្នាំ)</span>
                <input type="text" class="form-control text-center en" data-bind="datePicker: VisitDate" />
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
                    <b>តើឃ្លាំងឱសថអនុវត្តតាមការណែនាំសុវត្ថិភាពដែររឺទែ</b>
                    <br />
                    បើគ្មាន: យោបល់ និងមូលហេតុ៖
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
                    <b>តើមានឱសថ និងតេស្តគ្រុនចាញ់ណាមួយដាច់ស្តុកឬទេ?</b>
                    <br />
                    បើមានរាយឈ្មោះ និងរយៈពេលដាច់ស្តុក៖
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
                    <b>តើមានឱសថ និងតេស្តគ្រុនចាញ់ណាមួយផុតកំណត់កាលប្រើប្រាស់ឬទេ?</b>
                    <br />
                    បើមានរាយឈ្មោះ និងរយៈពេលផុតកំណត់
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
                    <b>និតិវិធីផុតកំណត់កាលប្រើប្រាស់មុនត្រូវបានប្រើប្រាស់មុនបានអនុវត្ត ត្រឹមត្រូវរឺទេ? (FEFO)</b>

                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="5" value="Yes" data-bind="checked: $root.getAnswer($element)" />
                            <span>បាទ/ចាស</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="5" value="No" data-bind="checked: $root.getAnswer($element)" />
                            <span>ទេ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    ចំណាប់អារម្មណ៍ រឺ យោបល់
                    <textarea class="form-control" name="5.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>
            <tr>
                <th>6</th>
                <td>
                    <b>តើការរៀបចំទុកដាក់ឱសថ និងសំភារៈបានល្អឬទេ?</b>
                </td>
                <td>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="6" value="Good" data-bind="checked: $root.getAnswer($element)" />
                            <span>ល្អ</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="6" value="Medium" data-bind="checked: $root.getAnswer($element)" />
                            <span>មធ្យម</span>
                        </label>
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            <input type="radio" name="6" value="Bad" data-bind="checked: $root.getAnswer($element)" />
                            <span>មិនល្អ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    បើមធ្យម  ឬ មិនល្អ តើមានចំណុចអ្វីខ្លះដែលគួរកែលម្អ?
                    <textarea class="form-control" name="6.1" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
                </td>
            </tr>

        </table>
    </div>
    <br />
    <div class="pad5 text-bold">7 សង្ខេបតុល្យការឱសថ បរិក្ខារកម្មវិធីគ្រុនចាញ់រយៈពេល ៣ខែចុងក្រោយរវាង ODDID និង MIS</div>
    <br />

    <table class="table table-bordered">
        <thead>
            <tr>
                <th align="center" valign="top">Code</th>
                <th align="center" valign="top">Product Name</th>
                <th align="center" valign="top">System</th>
                <th align="center" valign="top">Unit</th>
                <th align="center" valign="top">Month</th>
                <th align="center" valign="top">Month</th>
                <th align="center" valign="top">Month</th>
            </tr>
        </thead>
        <tbody data-bind="foreach: $root.stockList, fixedHeader: true" class="en">
            <tr>
                <td align="center" valign="middle" data-bind="text: code"></td>
                <td valign="middle" data-bind="text: name"></td>
                <td valign="middle" data-bind="text: system"></td>
                <td valign="middle" data-bind="text: unit"></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: month1" numonly="float" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: month2" numonly="float" />
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: month3" />
                </td>
            </tr>
        </tbody>
    </table>
    <br />
    <br />

    <table class="table">
        <tr>
            <th>8</th>
            <td>
                <b>តើឃ្លាំង ស.ប បានបញ្ចូលរបាយការណ៍ស្តុកឱសថ បរិក្ខាររបស់កម្មវិធីគ្រុនចាញ់បានទៀងទាត់ និងត្រឹមត្រូវ ដែរឬទេ?</b>
                <br />
                បើគ្មាន: យោបល់ និងមូលហេតុ៖
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
                <b>តើឃ្លាំងស.ប មានបញ្ហាជួបប្រទះអ្វីខ្លះក្នុងការបញ្ចូលរបាយការណ៍ស្តុកឱសថ បរិក្ខារកម្មវិធីគ្រុនចាញ់ក្នុង MIS?</b>
            </td>
            <td>
                
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">
                <textarea class="form-control" name="9" rows="5" data-bind="value: $root.getAnswer($element)"></textarea>
            </td>
        </tr>
    </table>

    <p>
        <b>ចំណាប់អារម្មណ៏របស់មន្រ្តីចុះអភិបាល</b>
    </p>
    <textarea class="form-control" rows="5" data-bind="value: Interest"></textarea>
    <br />

</div>

<?=latestJs('/media/ViewModel/Checklist_Stock_OD.js')?>