<style>
    .table-hover thead { background-color: #9AD8ED; }
	.form-control { padding: 2px 5px; }
	.space { margin-left: 10px; }
	.photo { width: 802px; min-height: 400px; border: 1px solid black; position: relative; }
	.photo button { position: absolute; top: 4px; right: 4px; border-color: white; }
	.photo button:hover, .photo button:focus, .photo button:focus:active { border-color: white; }
	.highlight { background-color: #ffff99; font-weight: bold; }
	.width70 { width:70px !important; }
    .underline:not(:empty) { cursor: pointer; color: blue; }
    .underline:not(:empty):hover { text-decoration: underline; }
    .underscore { border-bottom:1px solid; display:inline-block; text-align:center; }
	.panel-body { border:1px solid; margin:10px; }
	.width60 { width:60px !important; }
    .custom-control {
        position: relative;
        display: block;
        min-height: 1.3125rem;
        padding-left: 1.5rem;
    }
    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }
    .input-error {
		border-color: tomato;
		color: tomato;
	}
    .radioerror {
		color: tomato;
	}
    .displayTable {
        display:table
    }

    .ct {
        justify-content: space-evenly;
    }

    .numbers {
        width: 50px;
        text-align: center;
        background: tomato;
        color: white;
    } 
</style>

<div class="panel panel-default" data-bind="visible: view() == 'list'" style="display:none">
    <div class="panel-heading clearfix">
        <div class="pull-left">
            <div class="inlineblock">
                <div class="text-bold">Province</div>
                <select data-bind="value: pv,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: pvList().length == 1 ? undefined : 'All Province'"
                    class="form-control minwidth150"></select>
            </div>
            <div class="inlineblock">
                <div class="text-bold">OD</div>
                <select data-bind="value: od,
						options: odList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: odList().length == 1 ? undefined : 'All OD'"
                    class="form-control minwidth150"></select>
            </div>
            <div class="inlineblock">
                <div class="text-bold">HC</div>
                <select data-bind="value: hc,
						options: hcList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All HC'"
                    class="form-control minwidth150"></select>
            </div>
            <div class="inlineblock">
                <select data-bind="value: year, options: yearList" class="form-control width100"></select>
            </div>
            
        </div>
        <div class="pull-right">
            <a data-bind="click: $root.create, visible: app.user.permiss['Checklist Pv'].contain('Edit')" class="btn btn-success">Add New</a>
            <a href="/Home" class="btn btn-default">Home</a>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered kh">
            <thead>
                <tr>
                    <th width="250">Province</th>
                    <th>OD </th>
                    <th>HC</th>
                    <th>Date</th>
                    <th>Evaluated By</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: $root.getListModel()">
                <tr>
                    <td data-bind="text: $root.getProvName(Code_Prov_T)"></td>
                    <td data-bind="text: $root.getODName(Code_OD_T)"></td>
                    <td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
                    <td data-bind="text: DateAssessment"></td>
                    <td data-bind="text: EvaluatedBy"></td>
                    <td data-bind="text: AssessmentType"></td>
                    <td>
                        <button class="btn btn-sm btn-default" data-bind="click: $root.viewDetail, visible: app.user.permiss['Checklist Pv'].contain('Edit')">Detail</button>
                        <button class="btn btn-sm btn-danger" data-bind="click: $root.delete, visible: app.user.permiss['Checklist Pv'].contain('Delete')">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!--Form-->

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
    <div class="panel-heading clearfix">
        <div class="pull-left font16 text-bold lh26">Pv Radical Cure Checklist</div>
        <div class="pull-right">
            <button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('Foci Edit')">Save</button>
            <button class="btn btn-default btn-sm width100" data-bind="click: $root.back">Back</button>
        </div>
    </div>
    <div class="panel-body displayTable" style="min-width: 1200px; margin: auto">

        <div data-bind="with: detailModel">
            <!-- Part 1 -->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th>
                        <div class="inlineblock">
                            <div class="text-bold">ខេត្ត</div>
                            <select class="form-control" data-bind="value: Code_Prov_T, options: $root.pvList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: 'All'"></select>
                        </div>
                    </th>
                    <th>
                        <div class="inlineblock">
                            <div class="text-bold">ស្រុកប្រតិបត្តិ</div>
                            <select class="form-control minwidth100" data-bind="value: Code_OD_T, options: $root.odList(), optionsValue: 'code', optionsText: 'nameK', optionsCaption: 'All'"></select>
                        </div>
                    </th>
                    <th>
                        <div class="inlineblock">
                            <div class="text-bold">មូលដ្ឋានសុខាភិបាល</div>
                            <select class="form-control minwidth100" data-bind="value: Code_Facility_T, options: $root.hcList(), optionsValue: 'code', optionsText: 'nameK', optionsCaption: 'All'"></select>
                        </div>
                    </th>
                </tr>
                <tr class="form-inline relative">
                    <th>
                        ថ្ងៃខែឆ្នាំវាយតម្លៃ
                        <input type="text" class="form-control" data-bind="datePicker: DateAssessment" />
                    </th>
                    <th colspan="2">
                        អ្នកធ្វើស្វ័យវាយតម្លៃ
                        <input type="text" class="form-control" data-bind="value: EvaluatedBy" />
                    </th>
                </tr>
                <tr class="form-inline relative">
                    <th colspan="3">
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="AssessmentType" value="Byown" data-bind="checked: AssessmentType" />
                            <kh data-bind="css: {radioerror: AssessmentType.isValid() == false}">ស្វ័យវាយតម្លៃប្រចាំខែ</kh>
                        </label>
                        &nbsp;&nbsp; ឬ 
                        <label class="radio-inline radio-lg">
                            <input type="radio" name="AssessmentType" value="ByCNM" data-bind="checked: AssessmentType" />
                            <kh data-bind="css: {radioerror: AssessmentType.isValid() == false}">ចូលរួមអភិបាលជាមួយ ម.គ.ច</kh>
                        </label>
                    </th>
                </tr>
                <tr class="
                                form-inline relative">
                                <th>
                                    ម៉ោងចាប់ផ្តើមការវាយតម្លៃ៖
                                    <input type="time" class="form-control" data-bind="value: TimeStart" />
                                </th>
                                <th colspan="2">
                                    ម៉ោងបញ្ចប់ការវាយតម្លៃ៖
                                    <input type="time" class="form-control" data-bind="value: TimeEnd" />
                                </th>
</tr>
            </table>

            <br />
            <h4 class="kh">ពិន្ទុសរុប៖</h4>
            <div>
                <p style="border: solid 1px black; display: inline-block; padding: 20px !important">
                    <span style="font-size: 50px; color: darkblue" data-bind="text: Children().filter( r=> r.Section() == '4-1-2').reduce( (t, e) => t + e.Score(), 0)"></span> / 45
                </p>
            </div>
            <!--section 1 -1 -->

            <h3 class="kh">ផ្នែកទី ០១	៖ វាយតម្លៃសមត្ថភាពរបស់មន្រ្តីមូលដ្ឋានសុខាភិបាល និងសម្ភារៈប្រើប្រាស់</h3>

            <table class="table table-bordered kh">
                <thead>
                    <tr>
                        <th colspan="5" class="bg-info">
                            ១.១. មន្រ្តីបានទទួលការបណ្តុះបណ្តាល៖ ការធ្វើរោគវិនិច្ឆ័យ និងការព្យាបាលផ្តាច់ វីវ៉ាក់
                            ការណែនាំពីស្វ័យវាយតម្លៃ៖
                            សូមឆ្លើយសំណួរខាងក្រោមដោយឆ្លុះបញ្ចាំងពីផ្នែកដែលអ្នកត្រូវធ្វើឱ្យប្រសើរឡើងមុនពេលដែលអ្នកធ្វើស្វ័យវាយតម្លៃម្ដងទៀត ឬការធ្វើអភិបាលដោយម.គ.ច។
                            សម្រាប់ការធ្វើអភិបាលដោយម.គ.ច៖ មន្ត្រីម.គ.ច/មន្ទីរសុខាភិបាលខេត្ត/ស្រុកប្រតិបត្តិ នឹងសួរសំណួរខាងក្រោម៖
                        </th>
                    </tr>
                    <tr class="bg-info">
                        <th colspan="2">កម្រងសំណួរ</th>
                        <th>Not Applicable</th>
                        <th>ចំនួន</th>
                        <th>ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '1-1')">
                    <tr data-bind="component: { name: 'section-1-1', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score, DataType: DataType, NotApplicable: NotApplicable }}"></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                                របៀបផ្ដល់ពិន្ទុ៖ <br />
                                ១.  ផ្តល់ពិន្ទុ ០ ប្រសិនបើ ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាល < ២ នាក់ <br />
                                ២. ផ្តល់ពិន្ទុ ១ ប្រសិនបើ ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាល=២ នាក់ <br />
                                ៣. ផ្តល់ពិន្ទុ ២ ប្រសិនបើ ចំនួនមន្ត្រីដែលបានបណ្តុះបណ្តាល > ២ នាក់ <br />
                                សរសេរពិន្ទុដែលទទួលបាននៅផ្នែកខាងលើ រួចគណនារកមធ្យមភាគពិន្ទុដែលទទួលបាន <br />
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '1-1').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '1-1').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>

            <br />
            <!--section 1-2 -->
            <table class="table table-bordered kh">
                <thead>
                    <tr class="bg-info">
                        <td colspan="4">
                            ១.២. ពិនិត្យរកឯកសារជំនួយស្មារតី ស្តុកឱសថ និងសម្ភារៈ បរិក្ខារជំងឺគ្រុនចាញ់
                            ការណែនាំពីស្វ័យវាយតម្លៃ៖ សូមផ្តល់ពិន្ទុមូលដ្ឋានសុខាភិបាល និងថតរូបភាពសម្ភារៈដែលមាន។
                            សម្រាប់ការធ្វើអភិបាលដោយម.គ.ច/មន្ទីរសុខាភិបាលខេត្ត/ស្រុកប្រតិបត្តិ៖ សូមបំពេញផ្នែកនេះដោយធ្វើការសាកសួរផ្ទាល់មាត់ និងពិនិត្យសម្ភារៈដែលមាននៅទីនោះ។
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <th colspan="2">កម្រងសំណួរ</th>
                        <th>បាទ/ចាស៎</th>
                        <th>ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '1-2')">
                    <tr data-bind="component: { name: 'section-1-2', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score }}"></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            របៀបផ្ដល់ពិន្ទុ៖ <br />
                            ផ្តល់ ១ ពិន្ទុ ចំពោះចម្លើយដែល បាទ/ចាស៎ <br />
                            ផ្តល់ ០ ពិន្ទុ ចំពោះចម្លើយដែល ទេ <br />
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '1-2').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '1-2').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>

            <br />
            <!--section 1 -3 -->
            <table class="table table-bordered kh">
                <thead>
                    <tr class="bg-info">
                        <td colspan="4">
                            ១.៣.ការផ្ទៀងផ្ទាត់សៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដ G6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ និងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់(MIS)
                            ការណែនាំពីស្វ័យវាយតម្លៃ៖ សូមដាក់ពិន្ទុមូលដ្ឋានសុខាភិបាលរបស់ខ្លួនឯងចំពោះការកត់ត្រាករណី។
                            សម្រាប់ការធ្វើអភិបាលដោយម.គ.ច/មន្ទីរសុខាភិបាលខេត្ត/ស្រុកប្រតិបត្តិ៖ គួរធ្វើការផ្ទៀងផ្ទាត់ទិន្នន័យជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ ដែលបានកត់ត្រាក្នុងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់(MIS) និងសៀវភៅកត់ត្រាករណីយោងទៅតាមចំនួនករណីដែលបានរកឃើញក្រោយពីការធ្វើអភិបាលលើកមុន៖
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <th class="text-center" colspan="2">កម្រងសំណួរ</th>
                        <th>បាទ/ចាស៎</th>
                        <th>ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '1-3')">
                    <tr data-bind="component: { name: 'section-1-2', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score }}"></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            រៀបផ្ដលពិន្ទុពិន្ទុ៖ (លក្ខខណ្ឌត្រូវកត់ត្រាទាំងក្នុងសៀវភៅ និងប្រព័ន្ធព័ត៌មានគ្រុនចាញ់(MIS) ដូចគ្នា <br />
                            ផ្តល់ ១ ពិន្ទុ ចំពោះសំនួរដែល បាទ/ចាស៎ <br />
                            ផ្តល់ ០ ពិន្ទុ ចំពោះចម្លើយដែល ទេ <br />
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '1-3').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '1-3').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>
            <!--section 2-1-1-->
            <h3 class="kh">ផ្នែកទី ០២	៖ វាយតម្លៃការធ្វើរោគវិនិច្ឆ័យគ្រុនចាញ់ វីវ៉ាក់ និងតេស្ដមន្ទីរពិសោធន៍</h3>

            <table class="table table-bordered kh">
                <thead>
                    <tr class="bg-info">
                        <td colspan="4">
                            ២.១. សមត្ថភាពរបស់មន្ត្រីដែលបានទទួលការបណ្តុះបណ្តាលក្នុងការធ្វើរោគវិនិច្ឆ័យ
                            ការណែនាំពីស្វ័យវាយតម្លៃ៖ សូមដាក់ពិន្ទុមន្ត្រីមូលដ្ឋានសុខាភិបាលរបស់ខ្លួន តាមរយៈវិធីសាស្ត្រនៃការធ្វើតេស្ត និងដាក់ពិន្ទុតាមការអនុវត្តផ្ទាល់។
                            សម្រាប់ការធ្វើអភិបាលដោយម.គ.ច/មន្ទីរសុខាភិបាលខេត្ត/ស្រុកប្រតិបត្តិ៖ មន្ត្រីមន្ទីរពិសោធន៍ម.គ.ចពិនិត្យពីវិធីសាស្ត្រធ្វើតេស្ត និងផ្តល់ពិន្ទុ៖
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <th colspan="2">២.១.១.ការធ្វើតេស្តរហ័ស</th>
                        <th>បាទ/ចាស៎</th>
                        <th>ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '2-1-1')">
                    <tr data-bind="component: { name: 'section-1-2', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score }}"></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            របៀបផ្ដល់ពិន្ទុ៖(លក្ខខណ្ឌ៖ ត្រូវមានមន្ត្រីម្នាក់ទៀតអង្កេត) <br />
                            <br /> ឈ្មោះអ្នកអង្កេត
                            <input type="text" class="form-control" style="width:350px" data-bind="value: Children().filter(r => r.Section() == '2-1-1' && r.ShortName() == 'staff_name' )[0].Value" />
                            <br />
                            ផ្តល់ ១ ពិន្ទុ ចំពោះសំនួរដែល បាទ/ចាស៎ <br />
                            ផ្តល់ ០ ពិន្ទុ ចំពោះចម្លើយដែល ទេ <br />
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '2-1-1').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '2-1-1').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!--section 2-1-2-->

            <table class="table table-bordered kh">
                <thead>
                    <tr>
                        <td colspan="4">
                            
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <th colspan="2">២.១.២.ការអនុវត្តផ្ទាល់លើការធ្វើតេស្ត G6PD</th>
                        <th>បាទ/ចាស៎</th>
                        <th>ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '2-1-2')">
                    <tr data-bind="component: { name: 'section-1-2', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score }}"></tr>
                    <!-- ko if: Sort() == 14-->
                    <tr>
                        <td></td>
                        <td style="background: red ; color: white">លទ្ទផល</td>
                        <td style="background: red ; color: white">Level 1 G6PD:0.1-3-0; T-Hb: 6.0-12.0</td>
                        <td style="background: red ; color: white">Level 2 G6PD:6.0-17.0; T-Hb: 13.0-20.0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>G6PD</td>
                        <td>
                            <input type="text" class="form-control" style="width:350px" data-bind="value: $parent.Children().find(r => r.Section() == '2-1-2' && r.ShortName() == 'g6pd_level_1' ).Value" />
                        </td> 
                        <td>
                            <input type="text" class="form-control" style="width:350px" data-bind="value: $parent.Children().find(r => r.Section() == '2-1-2' && r.ShortName() == 'g6pd_level_2' ).Value" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>T-Hb</td>
                        <td>
                            <input type="text" class="form-control" style="width:350px" data-bind="value: $parent.Children().find(r => r.Section() == '2-1-2' && r.ShortName() == 'hb_level_1' ).Value" />
                        </td>
                        <td>
                            <input type="text" class="form-control" style="width:350px" data-bind="value: $parent.Children().find(r => r.Section() == '2-1-2' && r.ShortName() == 'hb_level_2' ).Value" />
                        </td>
                    </tr>
                    <!-- /ko -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            របៀបផ្ដល់ពិន្ទុ៖(លក្ខខណ្ឌ៖ ត្រូវមានមន្ត្រីម្នាក់ទៀតអង្កេត) <br />
                            <br /> ឈ្មោះអ្នកអង្កេត
                            <input type="text" class="form-control" style="width:350px" data-bind="value: Children().filter(r => r.Section() == '2-1-2' && r.ShortName() == 'staff_name' )[0].Value" />
                            <br />
                            ផ្តល់ 1 ពិន្ទុ ចំពោះសំនួរដែល បាទ/ចាស៎ <br />
                            ផ្តល់ ០ ពិន្ទុ ចំពោះចម្លើយដែល ទេ <br />
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '2-1-2').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '2-1-2').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>

            <br />

            <!--section 2-1-3-->
            <table class="table table-bordered kh">
                <thead>
                    <tr>
                        <td colspan="4">
                            
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <th colspan="2">២.១.៣.ការអនុវត្តផ្ទាល់លើកាតេស្តអេម៉ូក្លូប៊ីនដោសយឧបករណ៍វិភាគ HEMOCUE (សូមរំលង ប្រសិនបើមិនទាន់ទទួលបានការបណ្ដុះបណ្ដាលពីថ្នាក់ជាតិអំពីការព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់៨សប្ដាហ៍)</th>
                        <th>បាទ/ចាស៎</th>
                        <th>ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '2-1-3')">
                    <tr data-bind="component: { name: 'section-1-2', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score }}"></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            របៀបផ្ដល់ពិន្ទុ៖(លក្ខខណ្ឌ៖ ត្រូវមានមន្ត្រីម្នាក់ទៀតអង្កេត)
                            <br /> ឈ្មោះអ្នកអង្កេត 
                            <input type="text" class="form-control" style="width:350px" data-bind="value: Children().filter(r => r.Section() == '2-1-3' && r.ShortName() == 'staff_name' )[0].Value" />
                            <br />
                            ផ្តល់ 1 ពិន្ទុ ចំពោះសំនួរដែល បាទ/ចាស៎
                            <br />
                            ផ្តល់ ០ ពិន្ទុ ចំពោះចម្លើយដែល ទេ
                            <br />
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '2-1-3').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '2-1-3').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!--section 2-1-4-->
            <table class="table table-bordered kh">
                <thead>
                    <tr>
                        <td colspan="4"></td>
                    </tr>
                    <tr class="bg-info">
                        <th  colspan="2">
                            ២.១.៤.ការអនុវត្តផ្ទាល់លើការធ្វើតេស្តពិនិត្យរកស្រ្តីមានគភ៌
                            (សូមរំលងប្រសិនបើមិនទាន់ទទួលបានការបណ្ដុះបណ្ដាលពីថ្នាក់ជាតិអំពីការព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់៨សប្ដាហ៍)
                        </th>
                        <th>បាទ/ចាស៎</th>
                        <th>ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '2-1-4')">
                    <tr data-bind="component: { name: 'section-1-2', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score }}"></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            របៀបផ្ដល់ពិន្ទុ៖(លក្ខខណ្ឌ៖ ត្រូវមានមន្ត្រីម្នាក់ទៀតអង្កេត)
                            <br /> ឈ្មោះអ្នកអង្កេត
                            <input type="text" class="form-control" style="width:350px" data-bind="value: Children().filter(r => r.Section() == '2-1-4' && r.ShortName() == 'staff_name' )[0].Value" />
                            <br />
                            <br />
                            ផ្តល់ 1 ពិន្ទុ ចំពោះសំនួរដែល បាទ/ចាស៎
                            <br />
                            ផ្តល់ ០ ពិន្ទុ ចំពោះចម្លើយដែល ទេ
                            <br />
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '2-1-4').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '2-1-4').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>
            <!--section 3-->
            <h3 class="kh">ផ្នែកទី ០៣	៖ វាយតម្លៃចំណេះដឹងអំពីការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់</h3>

            <table class="table table-bordered kh">
                <thead>
                    <tr class="bg-info">
                        <td colspan="6">
                            ៣.១.សមត្ថភាពរបស់មន្ត្រីដែលបានទទួលការបណ្តុះបណ្តាលការផ្តល់ការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់
                            ការណែនាំពីស្វ័យវាយតម្លៃ៖ សូមដាក់ពិន្ទុមន្ត្រីមូលដ្ឋានសុខាភិបាលរបស់ខ្លួនឯងយោងតាមចម្លើយ។
                            សម្រាប់ការធ្វើអភិបាលដោយម.គ.ច/មន្ទីរសុខាភិបាលខេត្ត/ស្រុកប្រតិបត្តិ៖ គួរជ្រើសរើសសំណួរខាងក្រោមចំនួន ៥ ដើម្បីសាកសួរទាក់ទងនឹងការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់។
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <th  colspan="2">
                            ៣.១.១.សំណួរ៖ សូមជ្រើសរើសសំណួរនៃការព្យាបាលផ្តាច់ជំងឺគ្រុនចាញ់វីវ៉ាក់ទៅតាមលទ្ធផលការធ្វើតេស្តរបស់អ្នកជំងឺ
                        </th>
                        <th>Do</th>
                        <th>ការព្យាបាល</th>
                        <th>ចំនួនគ្រាប់ថ្នាំព្រីម៉ាគីន ៧.៥ ម.ក្រ</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '3-1-1')">
                    <tr data-bind="component: { name: 'section-3-1-1', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score, Subscore: Subscore, NotApplicable: NotApplicable }}"></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            របៀបផ្ដល់ពិន្ទុ៖ ផ្តល់ ២ ពិន្ទុ ចំពោះសំណួរដែលបានឆ្លើយត្រូវ (១ ពិន្ទុ សម្រាប់ការឆ្លើយត្រូវប្រភេទនៃការព្យាបាល និង ១ ពិន្ទុ សម្រាប់ការផ្តល់ចំនួនគ្រាប់ថ្នាំត្រឹមត្រូវ)។ សម្រាប់មន្ត្រីរបស់មូលដ្ឋានសុខាភិបាលដែលឆ្លើយមិនត្រឹមត្រូវ ត្រូវធ្វើការពិភាក្សាជាមួយ ម.គ.ច ឬត្រូវពិនិត្យមគ្គុទេសក៍ព្យាបាលឡើងវិញ។
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '3-1-1').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '3-1-1').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!--section 4-->
            <h3 class="kh">ផ្នែកទី ០៤ ៖ វាយតម្លៃលើការតាមដាន និងការរាយការណ៍ផលរំខានឱសថព្រីម៉ាគីន</h3>

            <table class="table table-bordered kh">
                <thead>
                    <tr class="bg-info">
                        <td colspan="5">
                            ៤.១.សមត្ថភាពរបស់មន្ត្រីក្នុងការតាមដាន និងការរាយការណ៍ផលរំខានឱសថព្រីម៉ាគីន
                            ការណែនាំពីស្វ័យវាយតម្លៃ៖ សូមដាក់ពិន្ទុមន្ត្រីមូលដ្ឋានសុខាភិបាលរបស់ខ្លួនឯងយោងតាមចម្លើយ។
                            សម្រាប់ការធ្វើអភិបាលដោយម.គ.ច/មន្ទីរសុខាភិបាលខេត្ត/ស្រុកប្រតិបត្តិ៖ គួរធ្វើត្រូវសាកសួរដោយផ្ទាល់ទៅមន្ត្រីមូលដ្ឋានសុខាភិបាល និងពិនិត្យមើលទិន្នន័យដែលបានរាយការណ៍ចាប់ពីការធ្វើអភិបាលលើកមុន។
                        </td>
                    </tr>
                    <tr class="bg-info">
                        <th colspan="2">
                            ៤.១.១.ពិនិត្យមើលទិន្នន័យដែលបានរាយការណ៍ក្នុងសៀវភៅបញ្ជីកត់ត្រាការធ្វើតេស្ដ G6PD និងព្យាបាលផ្ដាច់ជំងឺគ្រុនចាញ់ប្រភេទវីវ៉ាក់ ចាប់ពីការធ្វើអភិបាលលើកមុន៖
                        </th>
                        <th>Not Applicable</th>
                        <th style="width:116px">បាទ/ចាស៎</th>
                        <th>ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r=> r.Section() == '4-1-1')">
                    <tr data-bind="component: { name: 'section-4-1-1', params: {Sort: Sort, AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score, NotApplicable: NotApplicable }}"></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            របៀបផ្ដល់ពិន្ទុ៖(លក្ខខណ្ឌ៖ ត្រូវមានមន្ត្រីម្នាក់ទៀតអង្កេត)
                            <br />
                            ផ្តល់ 1 ពិន្ទុ ចំពោះសំនួរដែល បាទ/ចាស៎
                            <br />
                            ផ្តល់ ០ ពិន្ទុ ចំពោះចម្លើយដែល ទេ
                            <br />
                            <span style="color: tomato">ពិន្ទុះ</span>
                            <span style="font-size: 40px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '4-1-1').score"></span>,
                            <span style="font-size: 40px; color: aqua; margin-left: 35px" class="text-bold" data-bind="text: $root.totalScoreBySection(Children(), '4-1-1').percentage"></span> %
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- 4.1 -->
            <table class="table table-bordered kh">
                <thead class="bg-info">
                    <tr class="bg-info">
                        <th colspan="7">៤.១.២.ការណែនាំ៖សូមគូសរង្វង់លើពិន្ទុដែលទទួលបានតាមផ្នែកនីមួយៗដែលបានរៀបរាប់ខាងក្រោម</th>
                    </tr>
                    <tr class="bg-info">
                        <th>ចំនុចសំខាន់ៗវាយតម្លៃ</th>
                        <th>៥ ពិន្ទុ</th>
                        <th>៤ ពិន្ទុ</th>
                        <th>៣ ពិន្ទុ</th>
                        <th>២ ពិន្ទុ</th>
                        <th>១ ពិន្ទុ</th>
                        <th>០ ពិន្ទុ</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Children().filter( r => r.Section() == '4-1-2')">
                    <!--<tr data-bind="component: { name: 'section-4-1-2', params: {AttributeName: AttributeName(), ShortName: ShortName, Value: Value, Score: Score, Arr: $parent, Sort: Sort() }}"></tr>-->
                    <tr>
                        <td data-bind="text: AttributeName"></td>   
                        <td class="ct">
                            <span data-bind="css: {numbers: $root.partScore($parent,$data , $index()) == 5}">៩០% - ១០០%</span>
                        </td> 
                        <td class="ct">
                            <span data-bind="css: {numbers: $root.partScore($parent, $data ,$index()) == 4}">៧៥% - ៨៩%</span>
                        </td>   
                        <td class="ct">
                            <span data-bind="css: {numbers: $root.partScore($parent,$data , $index()) == 3}">៦០% - ៧៤%</span>
                        </td>  
                        <td class="ct">
                            <span data-bind="css: {numbers: $root.partScore($parent, $data ,$index()) == 2}">៥០% - ៥៩%</span>
                        </td>  
                        <td class="ct">
                            <span data-bind="css: {numbers: $root.partScore($parent, $data ,$index()) == 1}">៤០% - ៤៩%</span>
                        </td>  
                        <td class="ct">
                            <span data-bind="css: {numbers: $root.partScore($parent, $data ,$index()) == 0}">៤០%</span>
                            
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="background-color: orange">
                        <td>ពិន្ទុសរុប</td>
                        <td colspan="6">
                            <span data-bind="text: Children().filter( r=> r.Section() == '4-1-2').reduce( (t, e) => t + e.Score(), 0)"></span> /៤៥ (សរសេរពិន្ទុនេះនៅក្នុងទំព័រទី ១)
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">ការឆ្លុះបញ្ចាំង៖</td>
                    </tr>
                    <!-- ko foreach: Children().filter( r => r.Section() == '4-1-2-A' ) -->
                    <tr data-bind="component: { name: 'section-4-1-2-A', params: {AttributeName: AttributeName(), ShortName: ShortName, Value: Value }}"></tr>

                    <!-- /ko -->
                </tfoot>
            </table>
        </div>
    </div>
    <div class="panel-footer text-center">
        <button class="btn btn-primary btn-sm width150" data-bind="click: save, visible: app.user.permiss['Checklist Pv'].contain('Edit')">Save</button>
    </div>
</div>

<?=latestJs('/media/ViewModel/Checklist_Pv.js')?>