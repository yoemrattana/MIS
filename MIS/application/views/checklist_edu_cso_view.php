<style>

	.pad5 { padding: 5px; }
	textarea { resize: vertical; }
</style>

<div class="kh" data-bind="visible: view() == 'detail', with: masterModel">
    <div class="divcenter relative">
        <h3 class="text-center text-primary">បញ្ជីសំណួរសំរាប់ការអភិបាលការងារអប់រំសុខភាពជាមួយអង្គការដៃគូ</h3>
        <br />
        <p>១ ព័ត៌មានទូទៅៈ</p>
        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">ឈ្មោះអង្គការដៃគូដែលត្រូវអភិបាលៈ</span>
                <input type="text" class="form-control" data-bind="value: CSO" />
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
                <span class="input-group-addon">រយៈពេលដែលអង្គការធ្វើការងារៈ</span>
                <div class="radio-inline radio-lg">
                    <label>
                        <span>តិចជាង១ឆ្នាំ</span>
                        <input type="radio" style="width: 83px" name="WorkDuration" value="Less1Y" data-bind="checked: WorkDuration" />
                        
                    </label>
                </div>
                <div class="radio-inline radio-lg">
                    <label>
                        <span>មួយឆ្នាំ</span>
                        <input type="radio" style="width: 83px" name="WorkDuration" value="1Y" data-bind="checked: WorkDuration" />

                    </label>
                </div>
                <div class="radio-inline radio-lg">
                    <label>
                        <span>លើសពីមួយឆ្នាំ</span>
                        <input type="radio" style="width: 83px" name="WorkDuration" value="More1Y" data-bind="checked: WorkDuration" />

                    </label>
                </div>
                
            </div>
        </div>

        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">ថ្ងៃខែឆ្នាំចុះអភិបា</span>
                <input type="text" class="form-control text-center en" data-bind="datePicker: VisitDate" />
            </div>
        </div>
        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">ឈ្មោះបុគ្គលិកអង្គការៈ</span>
                <input type="text" class="form-control text-center en" data-bind="value: VisitorName" />
            </div>
        </div>

        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">ភេទ</span>
                <div class="radio-inline radio-lg">
                    <label>
                        <span>ស្រី</span>
                        <input type="radio" style="width: 83px" value="F" data-bind="checked: Sex" />

                    </label>
                </div>
                <div class="radio-inline radio-lg">
                    <label>
                        <span>ប្រុស</span>
                        <input type="radio" style="width: 83px" value="M" data-bind="checked: Sex" />

                    </label>
                </div>
            </div>
        </div>

        <div class="form-group form-inline">
            <div class="input-group">
                <span class="input-group-addon">តួនាទីទទួលខុសត្រូវៈ</span>
                <div class="radio-inline radio-lg">
                    <label>
                        <span>ប្រធានគំរោង</span>
                        <input type="radio" style="width: 83px" name="VisitorPosition" value="Project Manager" data-bind="checked: VisitorPosition" />

                    </label>
                </div>
                <div class="radio-inline radio-lg">
                    <label>
                        <span>ប្រធានកម្មវិធី</span>
                        <input type="radio" style="width: 83px" name="VisitorPosition" value="Program Manager" data-bind="checked: VisitorPosition" />

                    </label>
                </div>
                <div class="radio-inline radio-lg">
                    <label>
                        <span>មន្រ្តីទទួលខុសត្រូវផ្នែក</span>
                        <input type="radio" style="width: 83px" name="VisitorPosition" value="Responsible Officer" data-bind="checked: VisitorPosition" />

                    </label>
                </div>
            </div>
        </div>

        <br />

        <div class="form-group bg-gray pad5 text-bold">២ ការងារគ្រប់គ្រងៈ</div>
        <table class="table">
            <tr>
                <th>-</th>
                <td>
                    <b>តើអ្នកទទួលខុសត្រូវលើការងារគ្រុនចាញ់ចំនួនប៉ុន្មាន </b>
                </td>
                <td>
                    <div class="form-group form-inline">
                        <label>ភូមិ</label>
                        <input style="width: 70px" type="text" class="form-control" name="2.1.1" data-bind="value: $root.getAnswer($element)" />
                    </div>
                </td>
                <td>
                    <div class="form-group form-inline">
                        <label>មណ្ឌលសុខភាព</label>
                        <input style="width: 70px" type="text" class="form-control" name="2.1.2" data-bind="value: $root.getAnswer($element)" />
                    </div>
                     
                </td>
                <td>
                    <div class="form-group form-inline">
                        <label>ស្រុកប្រត្តិបត្តិ</label>
                        <input style="width: 70px" type="text" class="form-control" name="2.1.3" data-bind="value: $root.getAnswer($element)" />
                    </div>
                    
                </td>
                <td>
                    <div class="form-group form-inline">
                        <label>ខេត្ត</label>
                        <input style="width: 70px" type="text" class="form-control" name="2.1.4" data-bind="value: $root.getAnswer($element)" />
                    </div>
                </td>
            </tr>
            <tr>
                <th>-</th>
                <td>
                    <b>តើអង្គការរបស់អ្នកសព្វថ្ងៃទទួលថវិការពីគំរោងណា? </b>
                </td>
                <td colspan="4">
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="2.2" value="GF" data-bind="checked: $root.getAnswer($element)" />
                            <span>មូលនិធិសកល</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="2.2" value="USAID" data-bind="checked: $root.getAnswer($element)" />
                            <span>USAID</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="2.2" value="Bill Melinda Gate" data-bind="checked: $root.getAnswer($element)" />
                            <span>Bill Melinda Gate</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="2.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>ផ្សេងៗ</span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>តើអង្គការអ្នកមានបុគ្គលិកប៉ុន្មានរូប? </td>
                <td colspan="4">
                    <div class="form-group form-inline">
                        <input style="width: 70px" type="text" class="form-control" name="2.3" data-bind="value: $root.getAnswer($element)" />
                        <label>រូប</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>ចំនួនភូមិដែលមានអ្នកស្ម័គ្រចិត្តភូមិៈ(VHV) </td>
                <td colspan="2">
                    <div class="form-group form-inline">
                        <input style="width: 70px" type="text" class="form-control" name="2.4.1" data-bind="value: $root.getAnswer($element)" />
                    </div>
                </td>
                <td>ចំនួនអ្នកស្ម័គ្រចិត្តភូមិៈ (VHV)</td>
                <td>
                    <div class="form-group form-inline">
                        <input style="width: 70px" type="text" class="form-control" name="2.4.2" data-bind="value: $root.getAnswer($element)" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>ចំនួនអ្នកព្យាបាលគ្រុនចាញ់ចល័តMMW</td>
                <td colspan="4">
                    <div class="form-group form-inline">
                        <input style="width: 70px" type="text" class="form-control" name="2.4.3" data-bind="value: $root.getAnswer($element)" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>2.1</td>
                <td>តើអង្គការអ្នកមានគំរោងផែនការសកម្មភាពការងារប្រចាំខែ  ត្រីមាស ឆមាសនិងឆ្នាំដែរឫទេ?</td>
                <td colspan="3">
                    <div class="radio-inline radio-lg">
                        <label>ចាស/បាទ</label>
                        <input style="width: 70px" type="radio"  name="2.1.A" data-bind="checked: $root.getAnswer($element)" />
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>មិនមានទេ</label>
                        <input style="width: 70px" type="radio" name="2.1.A" data-bind="checked: $root.getAnswer($element)" />
                    </div>
                </td>
                <td>
                    <div class="form-group form-inline">
                        <label>(បើគ្មានហេតុអ្វី)</label>
                        <input style="width: 170px" type="text" class="form-control" name="2.1.A.Reason" data-bind="value: $root.getAnswer($element)" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>2.2</td>
                <td>តើគំរោងផែនការសកម្មភាពការងារប្រចាំខែត្រីមាសឆមាសនិងឆ្នាំបានធ្វើជាមួយមន្ទីរសុខាភិបាល/
                    ស្រុកប្រតិ្តបត្តិ/មណ្ឌលសុខភាពដែរឫទេ?
                    </td>
                <td colspan="3">
                    <div class="radio-inline radio-lg">
                        <label>ចាស/បាទ</label>
                        <input style="width: 70px" type="radio" name="2.2.A" data-bind="checked: $root.getAnswer($element)" />
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>មិនមានទេ</label>
                        <input style="width: 70px" type="radio" name="2.2.A" data-bind="checked: $root.getAnswer($element)" />
                    </div>
                </td>
                <td>
                    <div class="form-group form-inline">
                        <label>(បើគ្មានហេតុអ្វី)</label>
                        <input style="width: 170px" type="text" class="form-control" name="2.2.A.Reason" data-bind="value: $root.getAnswer($element)" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>2.3</td>
                <td>
                    តើអង្គការអ្នកបានធ្វើការងារអ្វីខ្លះទាក់ទងនិងការងារអប់រំសុខភាព?
                </td>
                <td colspan="4">
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="A2.3.1" value="Train" data-bind="checked: $root.getAnswer($element)" />
                            <span>ការបណ្តុះបណ្តាល</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="A2.3.1" value="HealthEdu" data-bind="checked: $root.getAnswer($element)" />
                            <span>ការអប់រំសុខភាព</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="A2.3.1" value="Supervission" data-bind="checked: $root.getAnswer($element)" />
                            <span>ការអភិបាល</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="A2.3.1" value="VMWMeeting" data-bind="checked: $root.getAnswer($element)" />
                            <span>ប្រជុំជាមួយអ្នកស្ម័គ្រចិត្ត</span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="A2.3.1" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>ផ្សេងៗ</span>
                        </label>
                        <input type="text" name="A2.3.1.Other" data-bind="checked: $root.getAnswer($element)" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    តើអង្គការអ្នកមានសហការជាមួយអាជ្ញាធរមូលដ្ឋាន, មន្ទីរសុខាភិបាល,ឫអង្គការដៃគូផ្សេងទៀតដែរឫទេ? 
                </td>
                <td colspan="4">
                    <div class="radio-inline radio-lg">
                        <label>ចាស/បាទ
                            <input style="width: 90px" type="radio" name="A2.3.2" data-bind="checked: $root.getAnswer($element)" />
                        </label>
                        
                    </div>
                    <div class="radio-inline radio-lg">
                        <label>មិនមានទេ
                            <input style="width: 90px" type="radio" name="A2.3.2" data-bind="checked: $root.getAnswer($element)" />
                        </label>
                        
                    </div>
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    ចំនួនយុទ្ធនាការនៃការអប់រំសុខភាពដែលបានរៀបចំក្នុងភូមិមានការចំលងខ្ពស់
                </td>
                <td colspan="4">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.3" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    ចំនួនប្រជាជនចល័ត/អ្នកចំណាកស្រុកនិងអ្នកផ្លាស់ប្តូរទីលំនៅថ្មី បានទទួលសារអប់រំសុខភាពតាមរយៈការអប់រំជាបុគ្គល/ក្រុម/គ្រួសារ
                </td>
                <td colspan="4">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.4" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    ចំនួនមុងជ្រលក់ថ្នាំបានបែងចែកទៅប្រជាជនចល័ត/អ្នកចំណាកស្រុក/និងអ្នកផ្លាស់ប្តូរទីលំនៅថ្មី 
                </td>
                <td colspan="4">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.5" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    ចំនួនប្រជាជនចល័ត/អ្នកចំណាកស្រុកនិងអ្នកផ្លាស់ប្តូរទីលំនៅថ្មីបានគូសផែនទី 
                </td>
                <td colspan="4">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.6" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr> 
            <tr>
                <td>-</td>
                <td>
                    ចំនួនអ្នកជំងឺសង្ស័យគ្រុនចាញ់ស្វែងរកការព្យាបាលដោយអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ 
                </td>
                <td colspan="2">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.6" data-bind="value: $root.getAnswer($element)" />
                </td>
                <td>
                    /មណ្ឌលសុខភាព 
                </td>
                <td>
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.6.1" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    ចំនួនអ្នកជំងឺគ្រុនចាញ់ស្វែងរកការព្យាបាលដោយអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ 
                </td>
                <td colspan="2">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.7" data-bind="value: $root.getAnswer($element)" />
                </td>
                <td>
                    /មណ្ឌលសុខភាព
                </td>
                <td>
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.7.1" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    ចំនួនរបាយការណ៍បានរាយការណ៍ស្តីពីករណីជំងឺគ្រុនចាញ់ឫការផ្ទុះនៃជំងឺគ្រុនចាញ់ 
                </td>
                <td colspan="4">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.8" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    ចំនួនប្រជុំប្រចាំខែ/ ត្រីមាស/ ឆ្នាំ ដែលបានរៀបចំជាមួយស្រុកប្រត្តិបត្តិ មន្ទីរសុខាភិបាលនិងមណ្ឌលសុខភាព 
                </td>
                <td colspan="4">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.9" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr> 
            <tr>
                <td>-</td>
                <td>
                    ចំនួនប្រជុំជាមួយចៅហ្វាយខេត្តបានចូលរួមដោយអង្គការដៃគូ 
                </td>
                <td colspan="4">
                    <input style="width: 170px" type="text" class="form-control" name="A2.3.10" data-bind="value: $root.getAnswer($element)" />
                </td>
            </tr>

            <tr>
                <td colspan="6">៣. សំភារៈអប់រំៈ</td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    តើ អង្គការអ្នកមានបានផលិតសំភារៈអប់ំសុខភាពដែរឫទេ? 
                </td>
                <td colspan="4">
                    <div class="radio-inline radio-lg">
                        <label>
                            ចាស/បាទ
                            <input style="width: 90px" type="radio" name="3.1" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            មិនមានទេ
                            <input style="width: 90px" type="radio" name="3.1" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    តើសំភារៈអប់រំសុខភាពអ្វីខ្លះដែលអង្គការអ្នកបានផលិត?
                </td>
                <td colspan="4">
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="GF" data-bind="checked: $root.getAnswer($element)" />
                            <span>-វីដេអូស្ពុត </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="USAID" data-bind="checked: $root.getAnswer($element)" />
                            <span>ពុតវិទ្យុ </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Bill Melinda Gate" data-bind="checked: $root.getAnswer($element)" />
                            <span>ផ្ទាំងរូបភាព </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>រូបភាពសន្លឹកបត់ </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>សៀវភៅសន្លឹកផ្ទាត់  </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>ប៉ាណូ   </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>អាវយឺត     </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>មួក     </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>រឿងនិទានខ្លី      </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>ល្បែង      </span>
                        </label>
                    </div>
                    <div class="checkbox checkbox-lg">
                        <label>
                            <input type="checkbox" name="3.2" value="Other" data-bind="checked: $root.getAnswer($element)" />
                            <span>ផ្សេងៗ      </span>
                        </label>
                    </div>
                    <input type="text" name="3.2.Other" data-bind="checked: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>-</td>
                <td>
                    តើអង្គការអ្នកមានបានធ្វើការបែងចែកសំភារៈអប់រំសុខភាពដែរឫទេ?  
                </td>
                <td colspan="4">
                    <div class="radio-inline radio-lg">
                        <label>
                            ចាស/បាទ (សុំមើលតារាងបែងចែក)  
                            <input style="width: 90px" type="radio" name="3.3" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            ទេ
                            <input style="width: 90px" type="radio" name="3.3" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6">៥.តាមដានវាយតំលៃៈ</td>
                
            </tr>
            <tr>
                <td>
                    -
                </td>
                <td>តើអង្គការអ្នកធ្លាប់បានចុះអភិបាលការងារនៅតាម ភូមិ ដែរឫទេ?</td>
                <td colspan="2">
                    <div class="radio-inline radio-lg">
                        <label>
                            ចាស/បាទ (មើលឯកសារ)
                            <input style="width: 90px" type="radio" name="3.4" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            មិនបាន  
                            <input style="width: 90px" type="radio" name="3.4" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                </td>
                <td colspan="2">
                    មូលហេតុ
                    <input type="text" name="3.4.Other" data-bind="checked: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>
                    -
                </td>
                <td>តើអង្គការអ្នកមានកាលវិភាគចុះអភិបាលការងារនោះ ដែរឫទេ?</td>
                <td colspan="2">
                    <div class="radio-inline radio-lg">
                        <label>
                            មាន   (មើលឯកសារ)
                            <input style="width: 90px" type="radio" name="3.5" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            មិនមាន   
                            <input style="width: 90px" type="radio" name="3.5" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                </td>
                <td colspan="2">
                    មូលហេតុ
                    <input type="text" name="3.5.Other" data-bind="checked: $root.getAnswer($element)" />
                </td>
            </tr>
            <tr>
                <td>
                    -
                </td>
                <td>តើអង្គការអ្នកមានរបាយការណ៏នៃការចុះអភិបាល ដែរឫទេ?</td>
                <td colspan="2">
                    <div class="radio-inline radio-lg">
                        <label>
                            មាន   (មើលរបាយការណ៏)
                            <input style="width: 90px" type="radio" name="3.6" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                    <div class="radio-inline radio-lg">
                        <label>
                            មិនមាន   
                            <input style="width: 90px" type="radio" name="3.6" data-bind="checked: $root.getAnswer($element)" />
                        </label>

                    </div>
                </td>
                <td colspan="2">
                    មូលហេតុ
                    <input type="text" name="3.6.Other" data-bind="checked: $root.getAnswer($element)" />
                </td>
            </tr>
            

            
        </table>
    </div>

    <p>
        <b>៦. បញ្ហាប្រឈមនិងសំណូមពររបស់អង្គការដៃគូៈ</b>
    </p>
    <textarea class="form-control" rows="5" data-bind="value: Problem"></textarea>
    <br />

    <p>
        <b>៧. ដំណោះស្រាយរបស់ថ្នាក់ជាតិៈ</b>
    </p>
    <textarea class="form-control" rows="5" data-bind="value: Solution"></textarea>
    <br />

</div>

<?=latestJs('/media/ViewModel/Checklist_Edu_CSO.js')?>