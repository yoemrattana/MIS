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
    .displayTable {
        display:table
    }
    .middle {vertical-align:middle !important}
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
                <div class="text-bold">Village</div>
                <select class="form-control minwidth150" data-bind="value: vl, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Village'"></select>
            </div>
           
            <div class="inlineblock">
                <select data-bind="value: year, options: yearList" class="form-control width100"></select>
            </div>
            <div class="inlineblock">
                <button class="btn btn-primary" data-bind="click: viewData">View</button>
            </div>
        </div>
        <div class="pull-right">
            <button class="btn btn-primary width100" data-bind="click: showNew , visible: app.user.permiss['MRRT2'].contain('TDA Edit')">New</button>
            <a href="/Home" class="btn btn-default">Home</a>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover text-nowrap">
            <thead class="bg-thead">
                <tr>
                    <th width="40" align="center">#</th>
                    <th align="center" sortable>Province</th>
                    <th align="center" sortable>OD</th>
                    <th align="center" sortable>HC</th>
                    <th align="center" sortable>Village</th>
                    <th width="50" align="center">Detail</th>
                    <th width="60" align="center">Delete</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: getListModel(), fixedHeader: true, sortModel: listModel">
                <tr class="kh">
                    <td align="center" data-bind="text: $index() + 1"></td>
                    <td data-bind="text: $root.getPVName(Code_Prov_T)"></td>
                    <td data-bind="text: $root.getODName(Code_OD_T)"></td>
                    <td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
                    <td data-bind="text: $root.getVLName(Code_Vill_T)"></td>
                    <td align="center">
                        <a data-bind="click: $root.viewDetail">Detail</a>
                    </td>
                    <td align="center">
                        <a class="text-danger" data-bind="click: $root.showDelete, visible: app.user.permiss['MRRT2'].contain('TDA Delete')">Delete</a>
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

<!--Form-->

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
    <div class="panel-heading clearfix">
        <div class="pull-left font16 text-bold lh26">MRRT DTA</div>
        <div class="pull-right">
            <button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('TDA Edit')">Save</button>
            <button class="btn btn-default btn-sm width100" data-bind="click: $root.back">Back</button>
        </div>
    </div>
    <div class="panel-body displayTable" style="min-width: 900px; margin: auto">
        <h3 class="kh text-center text-bold">
            ជំរឿនគ្រួសារ និងការផ្តល់ថ្នាំដល់ក្រុមគោលដៅ (TDA)
            <br />(ដោយក្រុមMRRT)
        </h3>
        <br />
        <br />

        <div data-bind="with: detailModel">
            <!-- Part 1 -->
            <table class="table table-bordered kh">
                <tr class="form-inline relative">
                    <th class="bg-info" >ផ្នែកទី 1៖ ព័ត៌មានគ្រួសារ</th>
                    <th class="bg-info" >
                        លេខកូដភូមិ៖
                        <input type="text" class="form-control" data-bind="value: Code_Vill" />
                    </th>
                    <th class="bg-info">
                        Lat៖
                        <input type="text" class="form-control" data-bind="value: Lat" numonly="float" />
                    </th>
                    <th class="bg-info">
                        Long៖
                        <input type="text" class="form-control" data-bind="value: Long" numonly="float" />
                    </th>
                </tr>
                <tr class="form-inline relative">
                    <td>
                        ឈ្មោះភូមិសំបុកចម្លង៖
                        <span style="color:red" data-bind="text: $root.getVill(Code_Vill_T())"></span>
                        <input type="hidden" class="form-control" data-bind="value: Code_Vill_T" />
                        <span data-bind="validationMessage: Code_Vill_T" class="message-error"></span>
                        <button class="btn btn-sm btn-success" data-bind="click: $root.selectAddress">Choose Village</button>
                    </td>
                    <td>
                        #សមាជិកគ្រួសារ៖
                        <input type="text" class="form-control" data-bind="value: Member" numonly="int" />
                    </td>
                    <td>
                        ឈ្មោះមេគ្រួសារ៖
                        <input type="text" class="form-control" data-bind="value: HouseHolder" />
                    </td>
                    <td>
                        ឈ្មោះលេខទូរស័ព្ទ៖
                        <input type="text" class="form-control" data-bind="value: Phone" numonly="int" />
                    </td>
                </tr>
            </table>

            <table class="table table-bordered kh">
                <thead>
                    <tr>
                        <th class="bg-info" colspan="13">តារាងបញ្ជីឈ្មោះសមាជិកគ្រួសារ</th>
                    </tr>
                    <tr>
                        <th class="text-center middle" rowspan="3">#</th>
                        <th class="text-center middle" rowspan="3">ឈ្មោះ</th>
                        <th class="text-center middle" rowspan="3">អាយុ</th>
                        <th class="text-center middle" rowspan="3">ភេទ</th>
                        <th class="text-center middle" rowspan="3">ចូលព្រៃ</th>
                        <th class="text-center middle" rowspan="3">ដេកក្នុងព្រៃ/​<br />ចំការខែមុន</th>
                        <th class="text-center middle" rowspan="3">ប្រជាជនចល័ត/ <br /> ចំណាកស្រុក <br /> ប្រសិនបើស្នាក់ <br /> នៅក្នុងភូមិ</th>
                        <th class="text-center middle" rowspan="3">គោលដៅ <br /> TDA</th>
                        <th class="text-center middle" rowspan="3">គោលដៅ <br /> IPTf</th>

                        <th class="text-center form-inline" colspan="2">TDA1 ថ្ងៃខែឆ្នាំ <input type="date" class="form-control" data-bind="value: TDA1Date" /></th>
                        <th class="text-center form-inline" colspan="2">TDA2 ថ្ងៃខែឆ្នាំ <input type="date" class="form-control" data-bind="value: TDA2Date" /></th>

                        <th class="text-center" rowspan="3"></th>
                    </tr>
                    <tr>
                        <th class="text-center">មិនបានលេប</th>
                        <th rowspan="2" class="middle text-center">បានទទួលTDA1 <br /> (ថ្ងៃខែឆ្នាំ)</th>
                        <th class="text-center">មិនបានលេប</th>
                        <th rowspan="2" class="middle text-center">បានទទួលTDA2 <br /> (ថ្ងៃខែឆ្នាំ)</th>
                    </tr>
                    <tr>
                        <th>អវត្តមាន <br />
                            មានបញ្ហាសុខភាពហាមប្រើ (CI) <br />
                            ផលរំខាននៃថ្នាំ
                        </th>
                        <th>អវត្តមាន <br />
                            មានបញ្ហាសុខភាពហាមប្រើ (CI) <br />
                            ផលរំខាននៃថ្នាំ
                        </th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: Members">
                    <tr>
                        <td class="text-center" data-bind="text: $index()+1"></td>
                        <td><input type="text" class="form-control" data-bind="value: Name" /></td>
                        <td><input type="text" class="form-control width60" data-bind="value: Age" numonly="int" /></td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="M" data-bind="checked: Sex, attr: {name: 'Sex-'+$index()}, click: $root.radioClick" />
                                <kh>ប្រុស</kh>
                            </label> <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="F" data-bind="checked: Sex, attr: {name: 'Sex-'+$index()}, click: $root.radioClick" />
                                <kh>ស្រី</kh>
                            </label>
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: ForestGo, attr: {name: 'ForestGo-'+$index()}, click: $root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label> <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: ForestGo, attr: {name: 'ForestGo-'+$index()}, click: $root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: ForestSleep, attr: {name: 'ForestSleep-'+$index()}, click:$root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label> <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: ForestSleep, attr: {name: 'ForestSleep-'+$index()}, click:$root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: MobilePop, attr: {name: 'MobilePop-'+$index()}, click:$root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label> <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: MobilePop, attr: {name: 'MobilePop-'+$index()}, click:$root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: TDATarget, attr: {name: 'TDATarget-'+$index()}, click:$root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label> <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: TDATarget, attr: {name: 'TDATarget-'+$index()}, click:$root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: IPTfTarget, attr: {name: 'IPTfTarget-'+$index()}, click:$root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label> <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: IPTfTarget, attr: {name: 'IPTfTarget-'+$index()}, click:$root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="Absent" data-bind="checked: TDA1NotDrug, attr: {name: 'TDA1NotDrug-'+$index()}, click:$root.radioClick" />
                                <kh>អវត្តមាន</kh>
                            </label> <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="CI" data-bind="checked: TDA1NotDrug, attr: {name: 'TDA1NotDrug-'+$index()}, click:$root.radioClick" />
                                <kh>មានបញ្ហាសុខភាពហាមប្រើ (CI) </kh>
                            </label> <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="SideEffect" data-bind="checked: TDA1NotDrug, attr: {name: 'TDA1NotDrug-'+$index()}, click:$root.radioClick" />
                                <kh>ផលរំខាននៃថ្នាំ</kh>
                            </label>
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: TDA1Received, attr: {name: 'TDA1Received-'+$index()}, click:$root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: TDA1Received, attr: {name: 'TDA1Received-'+$index()}, click:$root.radioClick" />
                                <kh>ទេ</kh>
                            </label> <br />
                            ថ្ងៃខែឆ្នាំ 
                            <input type="date" class="form-control"  data-bind="value: TDA1ReceivedDate" />
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="Absent" data-bind="checked: TDA2NotDrug, attr: {name: 'TDA2NotDrug-'+$index()}, click:$root.radioClick" />
                                <kh>អវត្តមាន</kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="CI" data-bind="checked: TDA2NotDrug, attr: {name: 'TDA2NotDrug-'+$index()}, click:$root.radioClick" />
                                <kh>មានបញ្ហាសុខភាពហាមប្រើ (CI) </kh>
                            </label>
                            <br />
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="SideEffect" data-bind="checked: TDA2NotDrug, attr: {name: 'TDA2NotDrug-'+$index()}, click:$root.radioClick" />
                                <kh>ផលរំខាននៃថ្នាំ</kh>
                            </label>
                        </td>
                        <td>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="1" data-bind="checked: TDA2Received, attr: {name: 'TDA2Received-'+$index()}, click:$root.radioClick" />
                                <kh>បាទ/ចាស៎</kh>
                            </label>
                            <label class="radio-inline radio-lg">
                                <input type="radio" value="0" data-bind="checked: TDA2Received, attr: {name: 'TDA2Received-'+$index()}, click:$root.radioClick" />
                                <kh>ទេ</kh>
                            </label>
                            <br />
                            ថ្ងៃខែឆ្នាំ
                            <input type="date" class="form-control" data-bind="value: TDA2ReceivedDate" />
                        </td>
                        <td>
                            <i class="text-danger fa fa-trash fa-2x" data-bind="click: $root.removeMember"></i>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="14">
                            <button class="btn btn-success btn-sm" data-bind="click: $root.addMember">+ Add More</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <br /> 
            <table class="table table-bordered kh">
                <tr class="form-inline">
                    <td>សង្ខេប៖</td>
                    <td>សមាជិក៖ <input type="text" class="form-control width70 text-center" data-bind="value: Member" numonly="int" /></td>
                    <td>ប្រុស៖ <input type="text" class="form-control width70 text-center" data-bind="value: Male" numonly="int" /></td>
                    <td>ស្រី៖ <input type="text" class="form-control width70 text-center" data-bind="value: Female" numonly="int" /></td>
                    <td rowspan="2" class="text-center middle">អ្នកចូលព្រៃ៖ <input type="text" class="form-control width70 text-center" data-bind="value: ForestGoer" numonly="int" /></td>
                    <td>បានទទួលTDA1 <input type="text" class="form-control width70 text-center" data-bind="value: TDA1Received" numonly="int" /></td>
                    <td>អវត្តមាន <input type="text" class="form-control width70 text-center" data-bind="value: TDA1Absent" numonly="int" /></td>
                    <td>បានទទួលTDA2 <input type="text" class="form-control width70 text-center" data-bind="value: TDA2Received" numonly="int" /></td>
                    <td>អវត្តមាន <input type="text" class="form-control width70 text-center" data-bind="value: TDA2Absent" numonly="int" /></td>
                </tr>
                <tr class="form-inline">
                    <td colspan="2">ប្រជាជនចល័ត/ចំណាកស្រុក៖ <input type="text" class="form-control width70 text-center" data-bind="value: MobilePop" numonly="int" /></td>
                    <td>គោលដៅTDA៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDATarget" numonly="int" /></td>
                    <td>គោលដៅIPTf៖ <input type="text" class="form-control width70 text-center" data-bind="value: IPTfTarget" numonly="int" /></td>

                    <td>ហាមប្រើ (CI)៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDA1CI" numonly="int" /></td>
                    <td>ផលរំខានថ្នាំ៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDA1SideEffect" numonly="int" /></td>
                    <td>ហាមប្រើ (CI)៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDA2CI" numonly="int" /></td>
                    <td>ផលរំខានថ្នាំ៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDA2SideEffect" numonly="int" /></td>
                </tr>
                <tr class="form-inline">
                    <td rowspan="2" colspan="2" class="middle">ព័ត៌មានមុងគ្រែ និងមុងអង្រឹង (LLINs និង LLIHNs)</td>  
                    <td colspan="2">មុងអង្រឹងនៅក្នុងផ្ទះ៖ <input type="text" class="form-control width70 text-center" data-bind="value: LLIHN" numonly="int" /></td>
                    <td>មុងអង្រឹងត្រូវការ៖ <input type="text" class="form-control width70 text-center" data-bind="value: LLIHNNeed" numonly="int" /></td>
                    <td colspan="2">បំពេញបន្ថែមមុងអង្រឹង៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDA1LLIHNTopup" numonly="int" /></td>
                    <td colspan="2">បំពេញបន្ថែមមុងអង្រឹង៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDA2LLIHNTopup" numonly="int" /></td>
                </tr>
                <tr class="form-inline"> 
                    <td colspan="2">មុង​គ្រែនៅក្នុងផ្ទះ៖ <input type="text" class="form-control width70 text-center" data-bind="value: LLIN" numonly="int" /></td>
                    <td>មុង​គ្រែត្រូវការ៖ <input type="text" class="form-control width70 text-center" data-bind="value: LLINNeed" numonly="int" /></td>
                    <td colspan="2">បំពេញបន្ថែមមុងគ្រែ៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDA1LLIHNTopup" numonly="int" /></td>
                    <td colspan="2">បំពេញបន្ថែមមុងគ្រែ៖ <input type="text" class="form-control width70 text-center" data-bind="value: TDA2LLIHNTopup" numonly="int" /></td>
                </tr>

                <tr class="form-inline">
                    <td colspan="9">បាន​ធ្វើឡើង​ដោយ៖ <input type="text" class="form-control" data-bind="value: ReportedBy" /></td>
                </tr>
            </table>
        </div>

    </div>
    <div class="panel-footer text-center">
        <button class="btn btn-primary btn-sm width150" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('TDA Edit')">Save</button>
    </div>
</div>


<!-- Modal Input Place -->
<div class="modal" id="modalInputPlace" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" data-bind="with: inputPlaceModel">
            <div class="modal-header">
                <h3 class="modal-title text-primary">Input Place</h3>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th width="100" align="right" valign="middle">ខេត្ត</th>
                        <td class="form-group">
                            <select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" valign="middle">ស្រុក</th>
                        <td class="form-group">
                            <select class="form-control input-sm" data-bind="value: ds, options: dsList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" valign="middle">ឃុំ</th>
                        <td class="form-group">
                            <select class="form-control input-sm" data-bind="value: cm, options: cmList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
                        </td>
                    </tr>
                    <tr>
                        <th align="right" valign="middle">ភូមិ</th>
                        <td class="form-group">
                            <select class="form-control input-sm" data-bind="value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm width100" data-dismiss="modal" data-bind="enable: vl()!=undefined ,click: $root.inputPlaceOKClick">OK</button>
                <button class="btn btn-default btn-sm width100" data-dismiss="modal" data-bind="click: $root.inputPlaceCancelClick">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?=latestJs('/media/ViewModel/MRRT_TDA.js')?>