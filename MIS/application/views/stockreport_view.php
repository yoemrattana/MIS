<style>
	.bluehead > thead { background-color:#9AD8ED; }
	#tblreportod a, #tblreporthf a, #tblreportvmw a { display:block; }
	.tbldetail input { width:100%; }
	.tbldetail .btn-default { width:100%; color:black; border-color:dimgray; border-radius:2px; }
	.tbldetail > tbody > tr > td { vertical-align:middle; }
	.mos kh { margin-right:5px; padding:2px 10px; border-radius:4px; }
	.red { background-color:red; color:white; }
	.green { background-color:green; color:white; }
	.yellow { background-color:yellow; }
	.orange { background-color:orange; }
	.menu button { width:80px; }
	.error { color:red; font-weight:bold; }
	.btn-link { line-height:22px; cursor:pointer; outline:none; width:70px; }
</style>

<div class="panel panel-default" data-bind="visible: isListView" style="display:none; min-width:1300px">
	<div class="panel-heading clearfix relative">
		<div class="pull-center form-inline">
			<div class="input-group width150">
				<span class="input-group-btn">
					<button data-bind="click: previousYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-left"></i>
					</button>
				</span>
				<input data-bind="value: year" type="text" class="form-control text-center" readonly />
				<span class="input-group-btn">
					<button data-bind="click: nextYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-right"></i>
					</button>
				</span>
			</div>

            <select data-bind="value: pv,
					options: pvList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: pvList().length == 1 ? undefined : 'Select Province',
                    visible: ['od', 'hf','vmw'].contain(menu())"
                class="form-control minwidth150"></select>

			<select data-bind="value: od,
					options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: odList().length == 1 ? undefined : 'Select OD',
					visible: ['hf','vmw'].contain(menu())"
				class="form-control minwidth150"></select>

			<select data-bind="value: hc,
					options: hcList(),
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: odList().length == 1 ? undefined : 'Select HC',
					visible: menu() == 'vmw'"
				class="form-control minwidth150"></select>
		</div>
		<div class="pull-left">
			<span class="menu">
				<button class="btn btn-default" data-bind="click: () => menu('od'), css: menu() == 'od' ? 'btn-info' : 'btn-default', visible: checkPermiss('OD')">OD</button>
				<button class="btn btn-default" data-bind="click: () => menu('hf'), css: menu() == 'hf' ? 'btn-info' : 'btn-default', visible: checkPermiss('HF')">HF</button>
				<button class="btn btn-default" data-bind="click: () => menu('vmw'), css: menu() == 'vmw' ? 'btn-info' : 'btn-default', visible: checkPermiss('VMW')">VMW</button>
			</span>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: menu() != null">
		<table id="tblreportod" class="table table-bordered table-striped table-hover bluehead text-nowrap" data-bind="visible: menu() == 'od'">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Operational District</th>
					<th>Khmer Name</th>
					<!-- ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: reportListOD, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_OD_K" class="kh"></td>
					<!-- ko foreach: reports -->
					<td data-bind="if: $root.visibleReport($data)" class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? '✔' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.editReportOD" class="text-bold" style="padding-top:2px"></a>
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>

		<table id="tblreporthf" class="table table-bordered table-striped table-hover bluehead text-nowrap" data-bind="visible: menu() == 'hf'">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Heath Facility</th>
					<th>Khmer Name</th>
					<!-- ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
					<th width="100" class="text-center">Facility Type</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: reportListHF, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Facility_K" class="kh"></td>
					<!-- ko foreach: reports -->
					<td data-bind="if: $root.visibleReport($data)" class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? '✔' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.editReportHF" class="text-bold" style="padding-top:2px"></a>
					</td>
					<!-- /ko -->
					<td data-bind="text: Type_Facility" align="center"></td>
				</tr>
			</tbody>
		</table>

		<table id="tblreportvmw" class="table table-bordered table-striped table-hover bluehead text-nowrap" data-bind="visible: menu() == 'vmw'">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>VMW</th>
					<th>Khmer Name</th>
					<!-- ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: reportListVMW, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: Name_Vill_K" class="kh"></td>
					<!-- ko foreach: reports -->
					<td data-bind="if: $root.visibleReport($data)" class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? '✔' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.editReportVMW"
							class="text-bold" style="padding-top:2px"></a>
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>

	</div>
</div>

<div class="panel panel-default" data-bind="hidden: isListView" style="margin:-10px -10px 0 -10px; display:none; min-width:1600px">
	<div class="panel-heading clearfix" data-bind="with: master">
		<div class="pull-left lh34 form-inline relative">
			<b>OD:</b>
			<kh data-bind="text: odkh"></kh>

			<!-- ko if: $root.menu() == 'hf' -->
			<b style="margin-left:20px">HF:</b>
			<kh data-bind="text: kh"></kh>
			<!-- /ko -->

			<!-- ko if: $root.menu() == 'vmw' -->
			<b style="margin-left:20px">HC:</b>
			<kh data-bind="text: kh"></kh>

			<b style="margin-left:20px">VMW:</b>
			<kh data-bind="text: hckh"></kh>
			<!-- /ko -->

			<b style="margin-left:20px">Report Month:</b>
			<input type="text" data-bind="datePicker: month, format: 'MM-YYYY', maxDate: moment()" class="btn-link" />
			
			<!-- ko if: ['od','hf'].contain($root.menu()) -->
			<b style="margin-left:20px">Positive:</b>
			<span data-bind="text: positive"></span> (HF: <span data-bind="text: positiveHF"></span> , VMW/MMW: <span data-bind="text: positiveVMW"></span>)
			
			<b style="margin-left:20px">Test:</b>
			<span data-bind="text: test"></span> (HF: <span data-bind="text: testHF"></span>, VMW/MMW: <span data-bind="text: testVMW"></span>)

            <b style="margin-left:20px">RDT:</b>
            <span data-bind="text: rdt"></span>

            <b style="margin-left:20px">Microscopy:</b>
            <span data-bind="text: microscopy"></span>
			<!-- /ko -->
		</div>
		<div class="pull-right">
            <button class="btn btn-primary width80" data-bind="click: $root.saveReport, visible: app.user.permiss['Stock Data'].contain('Edit') && !$root.reportLock()">Save</button>
			<button class="btn btn-danger width80" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['Stock Data'].contain('Delete') && !$root.reportLock()">Delete</button>
            <button class="btn btn-success width80" data-bind="click: $root.export, visible: has">Export</button>
			<button class="btn btn-default width80" data-bind="click: $root.back" style="margin-left:10px">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<!-- ko if: menu() == 'od' -->
		<table class="tbldetail table table-bordered table-striped table-hover bluehead">
			<thead>
				<tr>
					<th width="40" align="center" valign="middle">#</th>
					<th align="center" valign="middle">Code</th>
					<th align="center" valign="middle">Item</th>
					<th align="center" valign="middle">Strength</th>
					<th align="center" valign="middle">Unit</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនសល់ពីមុន</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនចូល</th>
					<th align="center" valign="middle" width="90" class="kh">សរុប</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនចេញ</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនកែតំរូវ</th>
					<th align="center" valign="middle" width="90" class="kh">តុល្យាការ</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនប៉ាន់ប្រមាណ</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនស្នើ</th>
					<th align="center" valign="middle" width="110">Expiration</th>
					<th align="center" valign="middle" width="200">Note</th>
					<th align="center" valign="middle">AMC</th>
					<th align="center" valign="middle">MOS</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<!-- ko if: ItemId != 0 -->
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Code, css: $root.getHighlight(Code)"></td>
					<td data-bind="text: Description, css: $root.getHighlight(Code)"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td><input type="text" data-bind="textInput: StockStart" class="text-center" disabled /></td>
					<td><input type="text" data-bind="textInput: StockIn" class="text-center" /></td>
					<td data-bind="text: Total" align="center"></td>
					<td><input type="text" data-bind="textInput: StockOut" class="text-center" /></td>
					<td><button data-bind="text: isnull(Adjustment(),'&nbsp;'), click: $root.showAdjustment" class="btn btn-default btn-sm"></button></td>
					<td data-bind="text: Balance, css: { error: Balance() < 0 }" align="center"></td>
					<td data-bind="text: Estimate" align="center"></td>
					<td><input type="text" data-bind="value: Request" class="text-center" /></td>
					<td><button data-bind="value: Expire, text: Expire() == null ? '&nbsp;' : Expire().displayformat(), click: $root.showExpire" class="btn btn-default btn-sm"></button></td>
					<td><input type="text" data-bind="value: Note" /></td>
					<td data-bind="text: AMC" align="center"></td>
					<td data-bind="text: MOS, css: $root.getColor(MOS())" align="center"></td>
				</tr>
				<!-- /ko -->
				<!-- ko if: ItemId == 0 -->
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Code"></td>
					<td data-bind="text: Description"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td data-bind="text: StockStart" align="center"></td>
					<td data-bind="text: StockIn" align="center"></td>
					<td data-bind="text: Total" align="center"></td>
					<td data-bind="text: StockOut" align="center"></td>
					<td data-bind="text: Adjustment" align="center"></td>
					<td data-bind="text: Balance, css: { error: Balance() < 0 }" align="center"></td>
					<td data-bind="text: Estimate" align="center"></td>
					<td data-bind="text: Request" align="center"></td>
					<td></td>
					<td></td>
					<td data-bind="text: AMC" align="center"></td>
					<td data-bind="text: MOS, css: $root.getColor(MOS())" align="center"></td>
				</tr>
				<!-- /ko -->
			</tbody>
		</table>
		<!-- /ko -->

		<!-- ko if: menu() == 'hf' -->
		<table class="tbldetail table table-bordered table-striped table-hover bluehead">
			<thead>
				<tr>
					<th align="center" valign="middle" width="40">#</th>
					<th align="center" valign="middle">Code</th>
					<th align="center" valign="middle">Item</th>
					<th align="center" valign="middle">Strength</th>
					<th align="center" valign="middle">Unit</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនសល់ពីមុន</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនចូល</th>
					<th align="center" valign="middle" width="90" class="kh">សរុប</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនចេញ</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនកែតំរូវ</th>
					<th align="center" valign="middle" width="90" class="kh">តុល្យាការ</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនប៉ាន់ប្រមាណ</th>
					<th align="center" valign="middle" width="110">Expiration</th>
					<th align="center" valign="middle" width="200">Note</th>
					<th align="center" valign="middle">AMC</th>
					<th align="center" valign="middle">MOS</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<!-- ko if: ItemId != 0 -->
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Code, css: $root.getHighlight(Code)"></td>
					<td data-bind="text: Description, css: $root.getHighlight(Code)"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td><input type="text" data-bind="textInput: StockStart" class="text-center" disabled /></td>
					<td><input type="text" data-bind="textInput: StockIn" class="text-center" /></td>
					<td data-bind="text: Total" align="center"></td>
					<td><input type="text" data-bind="textInput: StockOut" class="text-center" /></td>
					<td><button data-bind="text: isnull(Adjustment(),'&nbsp;'), click: $root.showAdjustment" class="btn btn-default btn-sm"></button></td>
					<td data-bind="text: Balance, css: { error: Balance() < 0 }" align="center"></td>
					<td data-bind="text: Estimate" align="center"></td>
					<td><button data-bind="value: Expire, text: Expire() == null ? '&nbsp;' : Expire().displayformat(), click: $root.showExpire" class="btn btn-default btn-sm"></button></td>
					<td><input type="text" data-bind="value: Note" /></td>
					<td data-bind="text: AMC" align="center"></td>
					<td data-bind="text: MOS, css: $root.getColor(MOS())" align="center"></td>
				</tr>
				<!-- /ko -->
				<!-- ko if: ItemId == 0 -->
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Code"></td>
					<td data-bind="text: Description"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td data-bind="text: StockStart" align="center"></td>
					<td data-bind="text: StockIn" align="center"></td>
					<td data-bind="text: Total" align="center"></td>
					<td data-bind="text: StockOut" align="center"></td>
					<td data-bind="text: Adjustment" align="center"></td>
					<td data-bind="text: Balance, css: { error: Balance() < 0 }" align="center"></td>
					<td data-bind="text: Estimate" align="center"></td>
					<td></td>
					<td></td>
					<td data-bind="text: AMC" align="center"></td>
					<td data-bind="text: MOS, css: $root.getColor(MOS())" align="center"></td>
				</tr>
				<!-- /ko -->
			</tbody>
		</table>
		<!-- /ko -->

		<!-- ko if: menu() == 'vmw' -->
		<table class="tbldetail table table-bordered table-striped table-hover bluehead">
			<thead>
				<tr>
					<th width="40" align="center" valign="middle">#</th>
					<th align="center" valign="middle">Code</th>
					<th align="center" valign="middle">Item</th>
					<th align="center" valign="middle">Strength</th>
					<th align="center" valign="middle">Unit</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនសល់ពីមុន</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនចូល</th>
					<th align="center" valign="middle" width="90" class="kh">សរុប</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនចេញ</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនកែតំរូវ</th>
					<th align="center" valign="middle" width="90" class="kh">តុល្យាការ</th>
					<th align="center" valign="middle" width="90" class="kh">ចំនួនប៉ាន់ប្រមាណ</th>
					<th align="center" valign="middle" width="110">Expiration</th>
					<th align="center" valign="middle">AMC</th>
					<th align="center" valign="middle">MOS</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<!-- ko if: ItemId != 0 -->
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Code, css: $root.getHighlight(Code)"></td>
					<td data-bind="text: Description, css: $root.getHighlight(Code)"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td>
						<input type="text" data-bind="textInput: StockStart" class="text-center" disabled />
					</td>
					<td>
						<input type="text" data-bind="textInput: StockIn" class="text-center" />
					</td>
					<td data-bind="text: Total" align="center"></td>
					<td>
						<input type="text" data-bind="textInput: StockOut" class="text-center" />
					</td>
					<td>
						<input type="text" data-bind="textInput: Adjustment" class="text-center" />
					</td>
					<td data-bind="text: Balance, css: { error: Balance() < 0 }" align="center"></td>
					<td data-bind="text: Estimate" align="center"></td>
					<td class="relative">
						<input type="text" data-bind="value: Expire" class="text-center" />
					</td>
					<td data-bind="text: AMC" align="center"></td>
					<td data-bind="text: MOS, css: $root.getColor(MOS())" align="center"></td>
				</tr>
				<!-- /ko -->
				<!-- ko if: ItemId == 0 -->
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Code"></td>
					<td data-bind="text: Description"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td data-bind="text: StockStart" align="center"></td>
					<td data-bind="text: StockIn" align="center"></td>
					<td data-bind="text: Total" align="center"></td>
					<td data-bind="text: StockOut" align="center"></td>
					<td data-bind="text: Adjustment" align="center"></td>
					<td data-bind="text: Balance, css: { error: Balance() < 0 }" align="center"></td>
					<td data-bind="text: Estimate" align="center"></td>
					<td></td>
					<td data-bind="text: AMC" align="center"></td>
					<td data-bind="text: MOS, css: $root.getColor(MOS())" align="center"></td>
				</tr>
				<!-- /ko -->
			</tbody>
		</table>
		<!-- /ko -->

		<div class="mos" style="margin-top:20px">
			<b>MOS: </b>
			<kh class="red">ដាច់ស្តុក</kh>
			<kh class="orange">ជិតដាច់ស្តុក</kh>
			<kh class="green">ស្តុកសមស្រប</kh>
			<kh class="yellow">ស្តុកកកស្ទះ</kh>
		</div>
	</div>
	<div class="panel-footer text-center">
		<button class="btn btn-danger" data-bind="click: showAllExpiration"><span class="fa fa-calendar"></span> Show All Expiration</button>
	</div>
</div>

<!-- Modal Adjustment -->
<div class="modal" id="modalAdjustment" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width:450px" data-bind="with: adjustmentPopup">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Adjustment</h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th align="center">Description</th>
							<th align="center" width="100">Quantity</th>
							<th width="65"></th>
						</tr>
					</thead>
					<tbody data-bind="foreach: list">
						<tr>
							<td>
								<!-- ko if: $root.menu() != 'hf' -->
								<input type="text" class="input-block" data-bind="textInput: Name" />
								<!-- /ko -->

								<!-- ko if: $root.menu() == 'hf' -->
								<select class="input-block" data-bind="value: Name, options: $root.adjustmentOptions, optionsCaption: ''" style="height:25px"></select>
								<!-- /ko -->
							</td>
							<td>
								<input type="text" class="text-center input-block" data-bind="textInput: Qty" />
							</td>
							<td align="center" valign="middle">
								<a class="text-danger" data-bind="click: $parent.remove">Remove</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100" data-bind="click: ok">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Expire -->
<div class="modal" id="modalExpire" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width:450px" data-bind="with: expirePopup">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Expiration</h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered widthauto">
					<thead>
						<tr>
							<th align="center">Expiration Date</th>
							<th align="center">Quantity</th>
							<th></th>
						</tr>
					</thead>
					<tbody data-bind="foreach: list">
						<tr>
							<td class="relative">
								<input type="text" class="text-center width150" data-bind="datePicker: Date" placeholder="DD-MM-YYYY" />
							</td>
							<td>
								<input type="text" class="text-center width100" data-bind="textInput: Qty" />
							</td>
							<td valign="middle">
								<a class="text-danger" data-bind="click: $parent.remove">Remove</a>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th align="center">Total</th>
							<th align="center" data-bind="text: list().sum(r => r.Qty().toFloat())"></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100" data-bind="click: ok">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal All Expiration -->
<div class="modal" id="modalAllExpiration" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:1300px">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">All Expiration</h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th align="center" width="80">Code</th>
							<th align="center" width="320">Item</th>
							<th align="center" width="150">Strength</th>
							<th align="center" width="150">Unit</th>
							<th align="center">Expiration</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: allExpirationList">
						<tr>
							<td data-bind="text: Code"></td>
							<td data-bind="text: Description"></td>
							<td data-bind="text: Strength"></td>
							<td data-bind="text: Unit"></td>
							<td data-bind="text: $root.mergeExpire(ExpireDetail)"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer" style="text-align:center">
				<button class="btn btn-success width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Notify Expire -->
<div class="modal" id="modalNotifyExpire" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Expire Next Month or Already Expired</h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead class="bg-thead">
						<tr>
							<th align="center">Code</th>
							<th align="center">Item</th>
							<th align="center">Expiration</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: notifyExpire">
						<tr>
							<td data-bind="text: Code"></td>
							<td data-bind="text: Description"></td>
							<td data-bind="text: Date" align="center"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/StockReport.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>