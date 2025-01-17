<style>
	.space { margin-left:15px; }
    .width100{width:100px}
    .width200{width:300px}
    .width40{width: 40px}
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
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
        <div class="pull-left">
            <button data-bind="click: menuClick, css: menuCss($element)" class="btn btn-default">Data</button>
            <button data-bind="click: menuClick, css: menuCss($element)" class="btn btn-default">Dashboard</button>
        </div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>

    <!-- ko if: menu() == 'Data'-->
    
    <div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
        <div class="pull-left form-inline">
            <select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length > 1 ? 'All Province' : undefined"></select>
            <select class="form-control" data-bind="value: ds, options: dsList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All District'"></select>
            <select class="form-control" data-bind="value: cm, options: cmList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Commune'"></select>
            <select class="form-control" data-bind="value: vl, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Village'"></select>
        </div>
        <div class="pull-right">
            <button class="btn btn-primary width100" data-bind="click: showNew">New</button>
        </div>
    </div>
	<div class="panel-heading clearfix" data-bind="visible:  view() == 'edit'">
		<div class="pull-right" style="position:sticky; right:21px">
            <button class="btn btn-primary width100" data-bind="visible: app.user.permiss['MRRT2'].contain('Entomology Edit'), click: save">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>

    <!-- List -->
	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered table-hover text-nowrap">
			<thead class="bg-thead">
				<tr>
					<th width="40" align="center">#</th>
					<th align="center" width="130" sortable>Collection Date</th>
					<th align="center" sortable>Province</th>
					<th align="center" sortable>District</th>
					<th align="center" sortable>Commune</th>
					<th align="center" sortable>Village</th>
					<th width="50" align="center">Detail</th>
					<th width="60" align="center">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel(), fixedHeader: true, sortModel: listModel">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: moment(CollectionDate).displayformat(), sortValue: CollectionDate" align="center"></td>
					<td data-bind="text: $root.getPVName(Code_Prov_T)"></td>
					<td data-bind="text: $root.getDSName(Code_Dist_T)"></td>
					<td data-bind="text: $root.getCMName(Code_Comm_T)"></td>
					<td data-bind="text: $root.getVLName(Code_Vill_T)"></td>
					<td align="center">
						<a data-bind="click: $root.showEdit">Detail</a>
					</td>
					<td align="center">
                        <a class="text-danger" data-bind="click: $root.showDelete, visible: app.user.permiss['MRRT2'].contain('Entomology Delete')">Delete</a>
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
    <!--Form-->

    <div class="panel-body" data-bind="with: detailModel, visible: view() == 'edit'">
        <h3 class="text-bold text-center kh">ទម្រង់ចាប់មូសសម្រាប់អង្កេតសំបុកចម្លង</h3>

        <div id="detail" style="width:fit-content; margin:auto">
            <div style="border:1px solid">
                <div style="padding:5px">
                    <p class="form-inline kh">
                        <b>ថ្ងៃខែឆ្នាំចាប់មូស</b>
                        <input type="date" class="form-control" data-bind="value: CollectionDate" placeholder="dd-mm-yyyy" />

                        <b>ដល់ថ្ងៃទី</b>
                        <input type="date" class="form-control" data-bind="value: CollectionDateTo" placeholder="dd-mm-yyyy" />
                    </p>
                    <p class="form-inline kh">
                        <b>ខេត្ត:</b>
                        <select class="form-control minwidth100" data-bind="value: Code_Prov_T, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>


                        <b class="space">ស្រុក:</b>
                        <select class="form-control minwidth100" data-bind="value: Code_Dist_T, options: dsList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>


                        <b class="space">ឃុំ:</b>
                        <select class="form-control minwidth100" data-bind="value: Code_Comm_T, options: cmList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>


                        <b class="space">ភូមិ:</b>
                        <select class="form-control minwidth100" data-bind="value: Code_Vill_T, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>

                    </p>
                    <p class="form-inline kh">
                        <b>ស្រុកប្រតិបត្តិ:</b>
                        <select class="form-control minwidth100" data-bind="value: Code_OD_T, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>


                        <b class="space">មណ្ឌលសុខភាព:</b>
                        <select class="form-control minwidth100" data-bind="value: Code_Facility_T, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>


                        <b>ឈ្មោះប្រធានក្រុមOD៖</b>
                        <input type="text" class="form-control" data-bind="value: OD_Captain" />
                    </p>
                    <p class="form-inline kh">
                        <b>ទីតាំងភូមិ Latitude៖</b>
                        <input type="text" class="form-control" data-bind="value: Lat" numonly="float" />

                        <b>Longtitude៖</b>
                        <input type="text" class="form-control" data-bind="value: Long" numonly="float" />


                    </p>
                    <p class="kh">
                        <b>កំណត់សំគាល់បញ្ហាផ្សេងៗ (បើមាន)៖</b>
                        <input type="text" class="form-control" data-bind="value: Note" />
                    </p>
                    <p class="form-inline kh">
                        <b>ឈ្មោះអ្នកចាប់ំមូសទី ១៖</b>
                        <input type="text" class="form-control" data-bind="value: MosquitoCatcher1" />

                        <b>ឈ្មោះអ្នកចាប់ំមូសទី ២៖</b>
                        <input type="text" class="form-control" data-bind="value: MosquitoCatcher2" />

                        <b>ឈ្មោះអ្នកចាប់ំមូសទី ៣៖</b>
                        <input type="text" class="form-control" data-bind="value: MosquitoCatcher3" />
                    </p>
                    <p class="form-inline kh">
                        <b>ឈ្មោះសម្ភាៈសម្រាប់ចាប់់មូស៖</b>
                        <div class="form-group">
                            <input type="checkbox" class="checkbox-lg" name="CTB" value="CTB" data-bind="checked: Commodity" />
                            <label>Cattle Tent Baited (CTB)</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="CBNC" value="CBNC" data-bind="checked: Commodity" />
                            <label>Cattle Baited Net Collection (CBNC)</label>
                            &nbsp;&nbsp;
                            <br />
                            <input type="checkbox" class="checkbox-lg" name="HLT" value="HLT" data-bind="checked: Commodity" />
                            <label>Human Landing Collection (HLT)</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" class="checkbox-lg" name="HBNC" value="HBNC" data-bind="checked: Commodity" />
                            <label>Human Baited Net Collection (HBNC)</label>
                            &nbsp;&nbsp;
                        </div>
                    </p>
                </div>

                <table class="table table-bordered kh">
                    <thead>
                        <tr>
                            <th colspan="9" class="bg-info">ចំនួនមូសដែលប្រមូលបានក្នុងកំឡុងពេលនៅភូមិ និងពេលចាត់ចំណាត់ថ្នាក់ករណី</th>
                        </tr>
                        <tr class="text-center">
                            <th class="text-center width200" rowspan="2">ល.រ</th>
                            <th class="text-center" colspan="6">ម៉ោង</th>
                            <th class="text-center width100" rowspan="2">សរុប</th>
                            <th class="text-center width40" rowspan="2"></th>
                        </tr>
                        <tr>
                            <th class="text-center width100">6-7 យប់</th>
                            <th class="text-center width100">7-8 យប់</th>
                            <th class="text-center width100">8-9 យប់</th>
                            <th class="text-center width100">9-10 យប់</th>
                            <th class="text-center width100">10-11 យប់</th>
                            <th class="text-center width100">11-12 យប់</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.ចំនួនមូសសរុបទាំងអស់ដាក់តាមម៉ោង</td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: ToalMosquito6_7" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: ToalMosquito7_8" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: ToalMosquito8_9" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: ToalMosquito9_10" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: ToalMosquito10_11" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: ToalMosquito11_12" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: TotalMosquito" numonly="int" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>1.1 ចំនួនមូស មិនមែនដែកគោល តាមម៉ោង</td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: NotAnopheles6_7" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: NotAnopheles7_8" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: NotAnopheles8_9" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: NotAnopheles9_10" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: NotAnopheles10_11" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: NotAnopheles11_12" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: NotAnopheles" numonly="int" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>1.2 ចំនួនមូស ជាដែកគោល តាមម៉ោង</td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: Anopheles6_7" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: Anopheles7_8" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: Anopheles8_9" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: Anopheles9_10" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: Anopheles10_11" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: Anopheles11_12" numonly="int" />
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: Anopheles" numonly="int" />
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered kh">
                    <thead>
                        <tr class="form-inline">
                            <th colspan="9" class="bg-info">
                                ក្រុមការងាររបស់បាណកសាស្រ្ត ម.គ.ច ថ្ងៃទទួលមូស៖
                                <input type="date" class="form-control width150" data-bind="value: ReceivedDate" placeholder="dd-mm-yyyy" />
                                ថ្ងៃធ្វើការវិភាគ
                                <input type="date" class="form-control width150" data-bind="value: AnalysisDate" placeholder="dd-mm-yyyy" />
                                ថ្ងៃផ្ញើលទ្ធផល
                                <input type="date" class="form-control width150" data-bind="value: SentDate" placeholder="dd-mm-yyyy" />
                            </th>
                        </tr>
                        <tr>
                            <th colspan="7">មូសដែកគោលដែលជា ភ្នាក់ងារចំលងសំខាន់ៗ៖</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: Mosquitoes().filter(r=> r.Type() == 'Primary')">
                        <tr>
                            <td class="form-group width200">
                                <select
                                    data-bind="options: $root.mosquitoList,
                                              value: Name,
                                              optionsCaption: 'Select Mosquito',
                                              select2: { placeholder: 'Select Mosquito...', allowClear: true }"
                                    class="form-control" style="width: 200px !important"></select>
                                <span data-bind="validationMessage: Name" class="message-error"></span>
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H6_7" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H7_8" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H8_9" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H9_10" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H10_11" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H11_12" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: Total" numonly="int" />
                            </td>
                            <td class="width40">
                                <i class="text-danger fa fa-trash fa-2x" data-bind="click: $root.removeMosquito"></i>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <button class="btn btn-success btn-sm" data-bind="click: $root.addPrimaryVector">+ Add More</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <table class="table table-bordered kh">
                    <thead>
                        <tr>
                            <th colspan="7">មូសដែកគោលដែលជា ភ្នាក់ងារចំលងបន្ទាប់បន្សំ៖</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: Mosquitoes().filter(r=> r.Type() == 'Secondary')">
                        <tr>
                            <td class="form-group width200">
                                <select
                                    data-bind="options: $root.mosquitoList,
                                              value: Name,
                                              optionsCaption: 'Select Mosquito',
                                              select2: { placeholder: 'Select Mosquito...', allowClear: true }"
                                    class="form-control" style="width: 200px !important"></select>
                                <span data-bind="validationMessage: Name" class="message-error"></span>
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H6_7" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H7_8" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H8_9" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H9_10" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H10_11" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: H11_12" numonly="int" />
                            </td>
                            <td class="width100">
                                <input type="text" class="form-control" data-bind="value: Total" numonly="int" />
                            </td>
                            <td class="width40">
                                <i class="text-danger fa fa-trash fa-2x" data-bind="click: $root.removeMosquito"></i>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <button class="btn btn-success btn-sm" data-bind="click: $root.addSecondaryVector">+ Add More</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <table class="table table-bordered kh">
                    <tr class="form-inline kh">
                        <td>ប្រធានក្រុមការងារចាប់មូស ODMS</td>
                        <td>អ្នកធ្វើវិភាគ</td>
                        <td>បាណកសាស្រ្ត ម.គ.ច</td>
                    </tr>
                    <tr class="form-inline kh">
                        <td>
                            <input type="text" class="form-control" data-bind="value: Leader" />
                        </td>
                        <td>
                            <input type="text" class="form-control" data-bind="value: Analyst" />
                        </td>
                        <td>
                            <input type="text" class="form-control" data-bind="value: EntomoCNM" />
                        </td>
                    </tr>
                    <tr class="form-inline kh">
                        <td>
                            <input type="date" class="form-control" data-bind="value: LeaderDate" placeholder="dd-mm-yyyy" />
                        </td>
                        <td>
                            <input type="date" class="form-control" data-bind="value: AnalystDate" placeholder="dd-mm-yyyy" />
                        </td>
                        <td>
                            <input type="date" class="form-control" data-bind="value: EntomoCNMDate" placeholder="dd-mm-yyyy" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="panel-footer text-center" data-bind="visible: view() == 'edit'">
        <button class="btn btn-primary width150" data-bind="click: save, visible: app.user.permiss['MRRT2'].contain('Entomology Edit')">Save</button>
    </div>

    <!--/ko-->

    <!-- Dashboard -->
    <!-- ko if: menu() == 'Dashboard'-->
    <div class="panel-body">
        <select data-bind="value: mosquito, options: mosquitosByHour, optionsText: 'Name'" class="form-control" style="width:250px"></select>
        <br />

        <div id="mosquito-by-hour" style="height:800px;border: 1px solid #ccc"></div>

        <br />

        <div data-bind="hidden: $root.isReady()">
            <?php $this->load->view('skeleton_loading') ?>
            <?php $this->load->view('skeleton_loading') ?>
        </div>
        <div data-bind="visible: $root.isReady()" id="map-main-vector" class="chartbox no-margin" style="height:800px;border: 1px solid #ccc"></div>

        <br />

        <div data-bind="visible: $root.isReady()" id="map-vector" class="chartbox no-margin" style="height:800px;border: 1px solid #ccc"></div>
    </div>
    <!--/ko-->
</div>


<?=latestJs('/media/ViewModel/MRRT_Entomo.js')?>