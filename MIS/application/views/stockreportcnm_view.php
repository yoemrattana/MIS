<style>
	.bluehead > thead { background-color:#9AD8ED; }
	#tblreport a { display:block; }
	.tbldetail input { width:100%; }
	.tbldetail .btn-default { width:100%; color:black; border-color:dimgray; border-radius:2px; }
	.tbldetail > tbody > tr > td { vertical-align:middle; }
	.mos kh { margin-right:5px; padding:2px 10px; border-radius:4px; }
	.red { background-color:red; color:white; }
	.orange { background-color:orange; }
	.green { background-color:green; color:white; }
	.yellow { background-color:yellow; }
	.menu { margin-left:20px; }
	.menu button { width:120px; }
	.btn-link { line-height:22px; cursor:pointer; outline:none; width:70px; }
	.width80 { width:80px; }
</style>

<div class="panel panel-default" data-bind="visible: isListView" style="display:none">
	<div class="panel-heading clearfix relative">
		<div class="pull-center form-inline">
			<div class="input-group width150">
				<span class="input-group-btn">
					<button data-bind="click: previousYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-left"></i>
					</button>
				</span>
				<input data-bind="value: year" type="text" class="form-control text-center" style="background-color:white" readonly />
				<span class="input-group-btn">
					<button data-bind="click: nextYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-right"></i>
					</button>
				</span>
			</div>
		</div>
		<div class="pull-left font16 lh34">
			<b>CNM Stock Report</b>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table id="tblreport" class="table table-bordered table-striped table-hover bluehead">
			<thead>
				<tr>
					<th>Place</th>
					<!--ko foreach: Array(12) -->
					<th width="100" class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="if: reportList().length > 0">
				<tr>
					<td>CNM</td>
					<!--ko foreach: reportList -->
					<td data-bind="if: $root.visibleReport($data)" class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? '✔' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.editReport" class="text-bold" style="padding-top:2px"></a>
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="hidden: isListView" style="margin:-10px -10px 0 -10px; display:none">
	<div class="panel-heading clearfix" data-bind="with: master">
		<div class="pull-left lh34 relative">
			<b>Report Month:</b>
			<input type="text" data-bind="datePicker: month, format: 'MM-YYYY', maxDate: moment()" class="btn-link" />
			
			<b style="margin-left:20px">Positive:</b>
			<span data-bind="text: positive"></span>
			
			<b style="margin-left:20px">Test:</b>
			<span data-bind="text: test"></span>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<button class="btn btn-primary width80" data-bind="click: $root.saveReport, visible: app.user.permiss['CNM Stock Data'].contain('Edit')">Save</button>
			<button class="btn btn-danger width80" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['CNM Stock Data'].contain('Delete')">Delete</button>
			<button class="btn btn-default width80" data-bind="click: $root.back" style="margin-left:10px">Back</button>
		</div>
	</div>
	<div class="panel-body">
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
					<td data-bind="text: Code"></td>
					<td data-bind="text: Description"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td><input type="text" data-bind="textInput: StockStart" class="text-center" /></td>
					<td><input type="text" data-bind="textInput: StockIn" class="text-center" /></td>
					<td data-bind="text: Total" align="center"></td>
					<td><input type="text" data-bind="textInput: StockOut" class="text-center" /></td>
					<td><input type="text" data-bind="textInput: Adjustment" class="text-center" /></td>
					<td data-bind="text: Balance" align="center"></td>
					<td><button data-bind="value: Expire, text: Expire() == null ? '&nbsp;' : Expire().format('DD-MM-YYYY'), click: $root.showExpire" class="btn btn-default btn-sm"></button></td>
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
					<td data-bind="text: Balance" align="center"></td>
					<td></td>
					<td></td>
					<td data-bind="text: AMC" align="center"></td>
					<td data-bind="text: MOS, css: $root.getColor(MOS())" align="center"></td>
				</tr>
				<!-- /ko -->
			</tbody>
		</table>

		<div class="mos" style="margin-top:20px">
			<b>MOS: </b>
			<kh class="red">ដាច់ស្តុក</kh>
			<kh class="orange">ជិតដាច់ស្តុក</kh>
			<kh class="green">ស្តុកសមស្រប</kh>
			<kh class="yellow">ស្តុកកកស្ទះ</kh>
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
								<input type="text" class="text-center width150" data-bind="datePicker: Date, allowKeyboard: true" placeholder="DD-MM-YYYY" />
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

<?=latestJs('/media/ViewModel/StockReportCNM.js')?>