<style>
	.table-hover thead {
		background-color: #9AD8ED;
	}

	.form-control {
		height: auto;
		padding: 2px 5px;
	}

	.space {
		margin-left: 10px;
	}

	.highlight {
		background-color: #ffff99;
		font-weight: bold;
	}

	.width70 {
		width: 70px !important;
	}

	.padding-5 {
		padding: 5px;
	}

	ul li {
		cursor: pointer;
	}
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading">
		<div class="clearfix hidden-print">
			<div class="pull-left" style="width: calc(100% - 120px)">
				<button class="btn minwidth100" data-bind="click: () => tab('List'), css: tab() == 'List' ? 'btn-info' : 'btn-default'">Data</button>
				<button class="btn minwidth100" data-bind="click: () => tab('Upload'), css: tab() == 'Upload' ? 'btn-info' : 'btn-default'">Upload</button>
				<button class="btn minwidth100" data-bind="click: () => tab('Report'), css: tab() == 'Report' ? 'btn-info' : 'btn-default'">Report</button>
				<button class="btn minwidth100" data-bind="click: () => tab('Discrepancy'), css: tab() == 'Discrepancy' ? 'btn-info' : 'btn-default'">Discrepancy</button>
			</div>
		</div>
	</div>
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list' && tab() == 'List'">

			<div style="display:inline-block">
				<div class="text-bold">Year</div>
				<select data-bind="value: year, options: yearList" class="form-control input-sm width70"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Month</div>
				<select data-bind="value: month, options: monthList, optionsCaption: 'All'" class="form-control input-sm width70"></select>
			</div>
		</div>

		<div class="pull-left form-inline" data-bind="visible: view() == 'list' && tab().in('Report','Discrepancy')">
			<div style="display:inline-block">
				<div class="text-bold">Province</div>
				<select data-bind="value: pv,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: pvList().length == 1 ? undefined : 'All Province'"
					class="form-control input-sm minwidth150"></select>
			</div>

			<div style="display:inline-block">
				<div class="text-bold">Year</div>
				<select data-bind="value: y, options: yearList" class="form-control input-sm width70"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Month</div>
				<select data-bind="value: m, options: monthList, optionsCaption: 'Select Month'" class="form-control input-sm width70"></select>
			</div>

		</div>

		<div class="pull-right">
			<button class="btn btn-default btn-sm width100" data-bind="click: () => tab('List'), visible: tab() == 'detail'">Back</button>
			<a href="/Home" data-bind="visible: view() == 'list'" style="margin-left:30px">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>
	<!-- data -->
	<div class="panel-body" data-bind="visible: view() == 'list' && tab() == 'List'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th align="center">Year / <kh>ឆ្នាំ</kh></th>
					<th align="center">Month / <kh>ខែ</kh></th>
					<th align="center"> Completeness</th>
					<th align="center">Action / <kh>សកម្មភាព</kh></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Year"></td>
					<td data-bind="text: Month"></td>
					<td align="center">
						Treat <span data-bind="visible: Treat == 1" class="fa fa-check-square"></span> <span data-bind="visible: Treat != 1" class="fa fa-times-rectangle"></span>
						Slide <span data-bind="visible: Slide == 1" class="fa fa-check-square"></span> <span data-bind="visible: Slide != 1" class="fa fa-times-rectangle"></span>
						Dipstick <span data-bind="visible: Dipstick == 1" class="fa fa-check-square"></span> <span data-bind="visible: Dipstick != 1" class="fa fa-times-rectangle"></span>
						VMW <span data-bind="visible: VMW == 1" class="fa fa-check-square"></span> <span data-bind="visible: VMW != 1" class="fa fa-times-rectangle"></span>
					</td>
					<td>
						<a class="btn btn-primary btn-sm" data-bind="click: $root.getDetail" style=""> <i class="fa fa-list"></i> Detail</a> 
						<a class="btn btn-danger btn-sm" data-bind="click: $root.delete" style=""> <i class="fa fa-trash"></i> Delete</a>
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

	<!-- detail -->
	<div class="panel-body" data-bind="visible: view() == 'list' && tab() == 'detail'">
		<h3>Treat case</h3>
		<table class="table table-bordered table-striped table-hover">
			<thead data-bind="foreach: detailTreat.slice(0, 1)">
				<tr data-bind="foreach: Object.keys($data)">
					<th data-bind="text: $data"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailTreat">
				<tr data-bind="foreach: Object.keys($data)">
					<td data-bind="text: $parent[$data]"></td>
				</tr>
			</tbody>
		</table>

		<h3>Dipstick case</h3>
		<table class="table table-bordered table-striped table-hover">
			<thead data-bind="foreach: detailDipstick.slice(0, 1)">
				<tr data-bind="foreach: Object.keys($data)">
					<th data-bind="text: $data"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailDipstick">
				<tr data-bind="foreach: Object.keys($data)">
					<td data-bind="text: $parent[$data]"></td>
				</tr>
			</tbody>
		</table>

		<h3>Slide case</h3>
		<table class="table table-bordered table-striped table-hover">
			<thead data-bind="foreach: detailSlide.slice(0, 1)">
				<tr data-bind="foreach: Object.keys($data)">
					<th data-bind="text: $data"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailSlide">
				<tr data-bind="foreach: Object.keys($data)">
					<td data-bind="text: $parent[$data]"></td>
				</tr>
			</tbody>
		</table>

		<h3>VMW case</h3>
		<table class="table table-bordered table-striped table-hover">
			<thead data-bind="foreach: detailVMW.slice(0, 1)">
				<tr data-bind="foreach: Object.keys($data)">
					<th data-bind="text: $data"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailVMW">
				<tr data-bind="foreach: Object.keys($data)">
					<td data-bind="text: $parent[$data]"></td>
				</tr>
			</tbody>
		</table>
	</div>

	<!--upload-->
	<div class="panel-body" data-bind="visible: view() == 'list' && tab() == 'Upload'">
		<p>please name file as </p>
		<ul>
			<li>1-treat.xls</li>
			<li>2-dipstick.xls</li>
			<li>3-slide.xls</li>
			<li>4-vmw.xls</li>
		</ul>
		<div>
			<button class="btn btn-default" data-bind="click: $root.selectFile">Select File</button>
		</div>
	</div>

	<input type="file" multiple="multiple" class="hide" id="file" data-bind="event: { change: () => fileChanged($element.files, true) }" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

	<!--Report-->
	<div class="panel-body" data-bind="visible: view() == 'list' && tab() == 'Report'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th style="vertical-align: middle;" rowspan="3" width="40" align="center">#</th>
					<th style="vertical-align: middle;" rowspan="3" align="center">Province / <kh>ខេត្ត</kh></th>
					<th style="vertical-align: middle;" rowspan="3" align="center">OD​​ / <kh>ស្រុកប្រតិបត្តិ</kh></th>
					<th colspan="15" align="center">MIS</th>
					<th colspan="15" align="center">HIS</th>
				</tr>
				<tr>
					<th colspan="5" align="center">All</th>
					<th colspan="5" align="center">VMW</th>
					<th colspan="5" align="center">HC</th>

					<th colspan="5" align="center">All</th>
					<th colspan="5" align="center">VMW</th>
					<th colspan="5" align="center">HC</th>
				</tr>
				<tr>
					<!-- ko foreach: Array(6)-->
					<th>Positive</th>
					<th>PF</th>
					<th>PV</th>
					<th>Mix</th>
					<th>Negative</th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listReport">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getPvName(Code_Prov_T)" class="kh"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>

					<td data-bind="text: MisPositive"></td>
					<td data-bind="text: MisPF"></td>
					<td data-bind="text: MisPV"></td>
					<td data-bind="text: MisMix"></td>
					<td data-bind="text: MisNegative"></td>

					<td style="background: #e67e22" data-bind="text: MisVMWPositive"></td>
					<td style="background: #e67e22" data-bind="text: MisVMWPF"></td>
					<td style="background: #e67e22" data-bind="text: MisVMWPV"></td>
					<td style="background: #e67e22" data-bind="text: MisVMWMix"></td>
					<td style="background: #e67e22" data-bind="text: MisVMWNegative"></td>

					<td data-bind="text: MisHCPositive"></td>
					<td data-bind="text: MisHCPF"></td>
					<td data-bind="text: MisHCPV"></td>
					<td data-bind="text: MisHCMix"></td>
					<td data-bind="text: MisHCNegative"></td>

					<td data-bind="text: HisPositive"></td>
					<td data-bind="text: HisPF"></td>
					<td data-bind="text: HisPV"></td>
					<td data-bind="text: HisMix"></td>
					<td data-bind="text: HisNegative"></td>

					<td style="background: #e67e22" data-bind="text: HisVMWPositive"></td>
					<td style="background: #e67e22" data-bind="text: HisVMWPF"></td>
					<td style="background: #e67e22" data-bind="text: HisVMWPV"></td>
					<td style="background: #e67e22" data-bind="text: HisVMWMix"></td>
					<td style="background: #e67e22" data-bind="text: HisVMWNegative"></td>

					<td data-bind="text: HisHCPositive"></td>
					<td data-bind="text: HisHCPF"></td>
					<td data-bind="text: HisHCPV"></td>
					<td data-bind="text: HisHCMix"></td>
					<td data-bind="text: HisHCNegative"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<!--Discrepancy-->
	<div class="panel-body" data-bind="visible: view() == 'list' && tab() == 'Discrepancy'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th style="vertical-align: middle;" rowspan="3" width="40" align="center">#</th>
					<th style="vertical-align: middle;" rowspan="3" align="center">
						Province /
						<kh>ខេត្ត</kh>
					</th>
					<th style="vertical-align: middle;" rowspan="3" align="center">
						OD​​ /
						<kh>ស្រុកប្រតិបត្តិ</kh>
					</th>
				</tr>
				<tr>
					<th style="background: red" align="center">MIS</th>
					<th style="background: red" align="center">HIS</th>
					<th style="background: red" align="center">Difference %</th>
					<th style="background: orange" align="center">MIS HC</th>
					<th style="background: orange" align="center">HIS HC</th>
					<th style="background: orange" align="center">Difference %</th>
					<th style="background: yellow" align="center">MIS VMW</th>
					<th style="background: yellow" align="center">HIS VMW</th>
					<th style="background: yellow" align="center">Difference %</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listDiscrepancy">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getPvName(Code_Prov_T)" class="kh"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>

					<td data-bind="text: MIS"></td>
					<td data-bind="text: HIS"></td>
					<td data-bind="text: $root.calculatePer(MIS,HIS)"></td>

					<td data-bind="text: MISHC"></td>
					<td data-bind="text: HISHC"></td>
					<td data-bind="text: $root.calculatePer(MISHC,HISHC)"></td>

					<td data-bind="text: MISVMW"></td>
					<td data-bind="text: HISVMW"></td>
					<td data-bind="text: $root.calculatePer(MISVMW,HISVMW)"></td>
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

<!-- Modal Confirm -->
<div class="modal" id="modalContinue" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Duplicated Data</h3>
			</div>
			<div class="modal-body">
				<h4>
					<span>File is dupplicated</span>
				</h4>
				<h4>Do you want to overwrite importing?</h4>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100" data-dismiss="modal">Overwrite</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/His.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>