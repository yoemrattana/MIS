<style>
	.stock-seciton { padding:5px; cursor:pointer; font-weight:bold; }
	.myh3 { line-height:1; text-transform:none; margin:0; }

	.Over { background-color:yellow; color:black; }
	.Good { background-color:#00B050; color:black; }
	.Low { background-color:orange; color:black; }
	.Out { background-color:red; }

	#modalStockStatus .fixed-header,
	#modalStockCompleteness .fixed-header { top: 53px; margin-left: 0.5px; }
</style>

<div id="tabStock" data-bind="visible: tab() == 'Stock'" style="display: none">
	<div class="relative form-inline" style="padding-bottom:10px">
		<button class="btn width100" data-bind="css: $element.innerHTML == stockMenu() ? 'btn-success' : 'btn-default', click: () => stockMenu($element.innerHTML)">Charts</button>
		<button class="btn width100" data-bind="css: $element.innerHTML == stockMenu() ? 'btn-success' : 'btn-default', click: () => stockMenu($element.innerHTML)" style="margin-left:5px">Monitor</button>
		<button class="btn width100" data-bind="css: $element.innerHTML == stockMenu() ? 'btn-success' : 'btn-default', click: () => stockMenu($element.innerHTML)" style="margin-left:5px">Table</button>

		<!-- ko if: stockMenu().in('Charts','Monitor') -->
		<label class="form-group has-float-label" style="margin-left:5px">
			<select class="form-control custom-select" data-bind="value: stockItemCode">
				<option value="ND0010">ND0010 Albendazol</option>
				<option value="ND0067">ND0067 Artesunate + Mefloquine</option>
				<option value="ND0068">ND0068 Artesunate + Pyronaridine</option>
				<option value="AA0280">AA0280 Mebendazol</option>
				<option value="ND0132">ND0132 Primaquine 7.5mg</option>
				<option value="ND0075">ND0075 Pyramax 60/20mg</option>
				<option value="ND0150">ND0150 Quinine sulfate</option>
				<option value="ND0082">ND0082 RDT</option>
			</select>
			<span>Commodity</span>
        </label>
		<!-- /ko -->

		<!-- ko if: stockMenu() == 'Monitor' -->
		<label class="form-group has-float-label" style="margin-left:5px">
			<select class="form-control custom-select" data-bind="value: stockLevel">
				<option value="OD">OD Stock</option>
				<option value="HC">HC Stock</option>
			</select>
			<span>Stock Level</span>
        </label>
		<!-- /ko -->

		<!-- ko if: stockMenu().in('Monitor','Table') -->
		<label class="form-group has-float-label" style="margin-left:5px">
			<select class="form-control custom-select" data-bind="value: stockYear, options: yearList"></select>
			<span>Year</span>
        </label>
		<label class="form-group has-float-label" style="margin-left:5px">
			<select class="form-control custom-select" data-bind="value: stockMonth, options: monthList"></select>
			<span>Month</span>
        </label>
		<button class="btn btn-info waves-effect waves-light" data-bind="click: viewMonitor" style="width:70px; margin-left:5px">View</button>
		<!-- /ko -->
	</div>
	
	<div data-bind="visible: stockMenu() == 'Charts'">
		<div class="row">
			<div class="col-md-6">
				<div id="stockStatusOD" class="chart-container" style="height:400px"></div>
			</div>
			<div class="col-md-6">
				<div id="stockStatusHC" class="chart-container" style="height:400px"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div id="stockCompleteness" class="chart-container" style="height:400px"></div>
			</div>
			<div class="col-md-6">
				<div id="stockOut" class="chart-container" style="height:400px"></div>
			</div>
		</div>

		<div id="stockMalaria" class="chart-container" style="height:400px"></div>

		<div class="row">
			<div class="col-md-6">
				<button data-bind="click:$root.fullScreen" class="btn btn-sm btn-danger pull-right">Full Screen</button>
				<div id="mapStock" class="chart-container" style="height:800px"></div>
			</div>
		</div>
	</div>

	<div data-bind="visible: stockMenu() == 'Monitor'">
		<div class="stock-seciton" style="background:#548235; color:white" data-bind="click: () => $($element).next().toggle()">Summary ►</div>
		<table class="table table-bordered" style="display:none">
			<thead style="background-color:skyblue">
				<tr>
					<th rowspan="2">PHD</th>
					<th rowspan="2" data-bind="visible: stockLevel() == 'HC'">OD</th>
					<th colspan="4" data-bind="text: stockLevel() == 'OD' ? '# of ODs' : '# of Health Facilities'"></th>
				</tr>
				<tr>
					<th>Overstock</th>
					<th>Sufficient Stock</th>
					<th>Low Stock</th>
					<th>Stock Out</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: tblStockSummary, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E, visible: $root.stockLevel() == 'HC'"></td>
					<td data-bind="text: StockOver" align="center"></td>
					<td data-bind="text: StockGood" align="center"></td>
					<td data-bind="text: StockLow" align="center"></td>
					<td data-bind="text: StockOut" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<div class="stock-seciton" style="background:yellow" data-bind="click: () => $($element).next().toggle()">
			<span data-bind="text: 'Overstock (' + tblStockOver().length + ') ►'"></span>
		</div>
		<div data-bind="template: { name: 'tblStockTemplate', data: tblStockOver }" style="display:none"></div>

		<div class="stock-seciton" style="background:#00B050" data-bind="click: () => $($element).next().toggle()">
			<span data-bind="text: 'Sufficient Stock (' + tblStockGood().length + ') ►'"></span>
		</div>
		<div data-bind="template: { name: 'tblStockTemplate', data: tblStockGood }" style="display:none"></div>

		<div class="stock-seciton" style="background:orange" data-bind="click: () => $($element).next().toggle()">
			<span data-bind="text: 'Low Stock (' + tblStockLow().length + ') ►'"></span>
		</div>
		<div data-bind="template: { name: 'tblStockTemplate', data: tblStockLow }" style="display:none"></div>

		<div class="stock-seciton" style="background:red; color:white" data-bind="click: () => $($element).next().toggle()">
			<span data-bind="text: 'Stock Out (' + tblStockOut().length + ') ►'"></span>
		</div>
		<div data-bind="template: { name: 'tblStockTemplate', data: tblStockOut }" style="display:none"></div>
	</div>

	<div data-bind="visible: stockMenu() == 'Table'">
		<div class="clearfix">
			<div class="pull-left">
				<h3 class="myh3" style="margin-top:10px">30 HFs HAVING MOST CASES vs MALARIA COMMODITY</h3>
			</div>
			<div class="pull-right">
				<span class="label Out">Stock Out</span>
				<span class="label Low">Low Stock</span>
				<span class="label Good">Sufficient Stock</span>
				<span class="label Over">Overstock</span>
			</div>
		</div>
		<table class="table table-bordered">
			<thead style="background-color:skyblue">
				<tr>
					<th rowspan="2">PHD</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">HF</th>
					<th rowspan="2">Test</th>
					<th colspan="4">Positive Case</th>
					<th colspan="4">Current Stock Balance</th>
				</tr>
				<tr>
					<th>Pf</th>
					<th>Pv</th>
					<th>Mix</th>
					<th>Total</th>
					<th>ASMQ</th>
					<th>RDT</th>
					<th>PQ7.5</th>
					<th>Pyramax 60/20mg</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: tblStockTop30, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td align="center" data-bind="text: Test"></td>
					<td align="center" data-bind="text: Pf"></td>
					<td align="center" data-bind="text: Pv"></td>
					<td align="center" data-bind="text: Mix"></td>
					<td align="center" data-bind="text: Total"></td>
					<td align="center">
						<span data-bind="text: ASMQ, css: ASMQStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: RDT, css: RDTStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: PQ, css: PQStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: Pyramax, css: PyramaxStatus" class="label"></span>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<h3 class="myh3" style="margin-top:30px">Current Stock at Foci Response HFs</h3>
		<table class="table table-bordered">
			<thead style="background-color:skyblue">
				<tr>
					<th rowspan="2">PHD</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">HF</th>
					<th rowspan="2"># Village</th>
					<th rowspan="2"># Foci Village</th>
					<th rowspan="2">Total<br>Pop.</th>
					<th rowspan="2">Target<br>TDA</th>
					<th rowspan="2">Target<br>iPTf</th>
					<th colspan="2">Received TDA</th>
					<th rowspan="2">Received<br>iPTf</th>
					<th rowspan="2">Test</th>
					<th colspan="4">Positive Case</th>
					<th colspan="4">Current Stock Balance</th>
				</tr>
				<tr>
					<th>TDA 1</th>
					<th>TDA 2</th>
					<th>Pf</th>
					<th>Pv</th>
					<th>Mix</th>
					<th>Total</th>
					<th>ASMQ</th>
					<th>RDT</th>
					<th>PQ7.5</th>
					<th>Pyramax 60/20mg</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: tblStockFoci, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td align="center" data-bind="text: VillCount"></td>
					<td align="center" data-bind="text: FociVill"></td>
					<td align="center" data-bind="text: Pop"></td>
					<td align="center" data-bind="text: TargetTDA"></td>
					<td align="center" data-bind="text: TargetIPT"></td>
					<td align="center" data-bind="text: TDA1"></td>
					<td align="center" data-bind="text: TDA2"></td>
					<td align="center" data-bind="text: IPT"></td>
					<td align="center" data-bind="text: Test"></td>
					<td align="center" data-bind="text: Pf"></td>
					<td align="center" data-bind="text: Pv"></td>
					<td align="center" data-bind="text: Mix"></td>
					<td align="center" data-bind="text: Total"></td>
					<td align="center">
						<span data-bind="text: ASMQ, css: ASMQStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: RDT, css: RDTStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: PQ, css: PQStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: Pyramax, css: PyramaxStatus" class="label"></span>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<h3 class="myh3" style="margin-top:30px">Current Stock at Pv Radical Cure HFs</h3>
		<table class="table table-bordered">
			<thead style="background-color:skyblue">
				<tr>
					<th rowspan="2">PHD</th>
					<th rowspan="2">OD</th>
					<th rowspan="2">HF</th>
					<th colspan="3">Positive Case</th>
					<th colspan="4">Received G6PD Testing</th>
					<th rowspan="2">Test</th>
					<th colspan="6">Current Stock Balance</th>
				</tr>
				<tr>
					<th>Pv</th>
					<th>Mix</th>
					<th>Total</th>
					<th># of Normal</th>
					<th># of Intermediate</th>
					<th># of Deficient</th>
					<th># of Invalid</th>
					<th>ASMQ</th>
					<th>RDT</th>
					<th>PQ7.5</th>
					<th>G6PD Test Strip</th>
					<th>G6PD Control</th>
					<th>Pyramax 60/20mg</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: tblStockPvRadical, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td align="center" data-bind="text: Pv"></td>
					<td align="center" data-bind="text: Mix"></td>
					<td align="center" data-bind="text: Pv + Mix"></td>
					<td align="center" data-bind="text: Normal"></td>
					<td align="center" data-bind="text: Inter"></td>
					<td align="center" data-bind="text: Deficient"></td>
					<td align="center" data-bind="text: Invalid"></td>
					<td align="center" data-bind="text: Test"></td>
					<td align="center">
						<span data-bind="text: ASMQ, css: ASMQStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: RDT, css: RDTStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: PQ, css: PQStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: G6PDTest, css: G6PDTestStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: G6PDControl, css: G6PDControlStatus" class="label"></span>
					</td>
					<td align="center">
						<span data-bind="text: Pyramax, css: PyramaxStatus" class="label"></span>
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

<div id="waitingTemplate" class="hidden">
	 <div class='loader black' style="top:49%; left:49%; z-index:1; height:100px">
		<div class='circle'></div>
		<div class='circle'></div>
		<div class='circle'></div>
		<div class='circle'></div>
		<div class='circle'></div>
	</div>
</div>

<div class="modal" id="modalStockStatus" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="height:calc(100% - 60px); max-width:1200px">
		<div class="modal-content" style="height:100%">
			<div class="modal-header" style="justify-content:flex-end">
				<label class="label Out mr-1 mb-0 fs-16">
					<input type="checkbox" value="Out" data-bind="checked: tickFilter" />
					<span>Stock Out</span>
				</label>
				<label class="label Low mr-1 mb-0 fs-16">
					<input type="checkbox" value="Low" data-bind="checked: tickFilter" />
					<span>Low Stock</span>
				</label>
				<label class="label Good mr-1 mb-0 fs-16">
					<input type="checkbox" value="Good" data-bind="checked: tickFilter" />
					<span>Sufficient Stock</span>
				</label>
				<label class="label Over mb-0 fs-16">
					<input type="checkbox" value="Over" data-bind="checked: tickFilter" />
					<span>Overstock</span>
				</label>
			</div>
			<div class="modal-body" style="height:calc(100% - 47px); overflow-y:auto">
				<div data-bind="template: { name: 'tblStockTemplate', data: tblStockStatusPopup }"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modalStockCompleteness" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="height:calc(100% - 60px); max-width:1200px">
		<div class="modal-content" style="height:100%">
			<div class="modal-header">
				<span data-bind="text: 'Incomplete Stock - ' + stockLevel().replace('HC','HF')" style="font-weight:900"></span>
			</div>
			<div class="modal-body" style="height:calc(100% - 47px); overflow-y:auto">
				<table class="table table-bordered table-hover no-margin">
					<thead style="background-color:skyblue">
						<tr>
							<th>#</th>
							<th>PHD</th>
							<th>OD</th>
							<th data-bind="visible: $root.stockLevel() == 'HC'">HF</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: tblStockCompletePopup, fixedHeader: true, scrollContainer: $($element).closest('.modal-body')">
						<tr>
							<td align="center" data-bind="text: $index() + 1"></td>
							<td data-bind="text: Name_Prov_E"></td>
							<td data-bind="text: Name_OD_E"></td>
							<!-- ko if: $root.stockLevel() == 'HC' -->
							<td data-bind="text: $data?.Name_Facility_E"></td>
							<!-- /ko -->
						</tr>
					</tbody>
					<tfoot data-bind="visible: app.tableFooter($element)">
						<tr>
							<td class="text-center text-warning h4" style="padding:10px">No Data</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script id="tblStockTemplate" type="text/html">
	<table class="table table-bordered table-hover no-margin">
		<thead style="background-color:skyblue">
			<tr>
				<th rowspan="2">PHD</th>
				<th rowspan="2">OD</th>
				<th rowspan="2" data-bind="visible: $root.stockLevel() == 'HC'">HF</th>
				<th rowspan="2" width="80">Test</th>
				<th colspan="4">Positive Cases</th>
				<th colspan="3">Stock</th>
			</tr>
			<tr>
				<th width="80">Pf</th>
				<th width="80">Pv</th>
				<th width="80">Mix</th>
				<th width="80">Total</th>
				<th width="80">Balance</th>
				<th width="80">AMC</th>
				<th width="80">MOS</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: $data, fixedHeader: true, scrollContainer: $($element).closest('.modal-body')[0]">
			<tr>
				<td data-bind="text: Name_Prov_E"></td>
				<td data-bind="text: Name_OD_E"></td>
				<!-- ko if: $root.stockLevel() == 'HC' -->
				<td data-bind="text: $data?.Name_Facility_E" style="white-space:normal"></td>
				<!-- /ko -->
				<td data-bind="text: Test || 0" align="center"></td>
				<td data-bind="text: Pf || 0" align="center"></td>
				<td data-bind="text: Pv || 0" align="center"></td>
				<td data-bind="text: Mix || 0" align="center"></td>
				<td data-bind="text: Total || 0" align="center"></td>
				<td data-bind="text: Balance" align="center"></td>
				<td data-bind="text: AMC.toFixed(1)" align="center"></td>
				<td align="center">
					<span data-bind="text: MOS.toFixed(1), css: $root.inModal($element) ? 'label ' + Status : ''"></span>
				</td>
			</tr>
		</tbody>
		<tfoot data-bind="visible: app.tableFooter($element)">
			<tr>
				<td class="text-center text-warning h4" style="padding:10px">No Data</td>
			</tr>
		</tfoot>
	</table>
</script>