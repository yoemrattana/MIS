<style>
	body {
		background-color: #f3f1f196;
	}

	.card {
		box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
		border: 2px solid #01c0c8;
		background: #fff;
	}

    .btn-circle {
        border-radius: 100%;
        width: 25px;
        height: 25px;
        padding: 2px;
    }
    * {
		font-family: Content, sans-serif;
    }
    .table td, .table th {
        padding: 0.2rem;
        vertical-align: top;
        white-space: nowrap;
    }

    .table thead th {
        border-bottom: none;
        vertical-align: middle;
        text-align: center;
		height: 40px;
    }

    .table thead tr th {
        font-weight: bold;
    }

    .table tbody {
        font-weight: 500;
    }

	.section-title {font-family:'Khmer OS Siemreap'; color: #2980b9; font-weight: 700}
    
</style>

<div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Delete case/stock log</h4>
					<form>
						<div class="container9">
							<div class="row">
								<div class="col-sm-4">
									<div class="button-group">
										<button type="button" data-bind="click: $root.menuClick" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow active">Case</button>
										<button type="button" data-bind="click: $root.menuClick" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Stock HC</button>
										<button type="button" data-bind="click: $root.menuClick" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Stock OD</button>
                                        <button type="button" data-bind="click: $root.menuClick" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Follow Up</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: pv,
											options: pvList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: pvList().length == 1 ? undefined : 'Select Province'"
											class="form-control input-sm minwidth150"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: od,
											options: odList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: odList().length == 1 ? undefined : 'All OD'"
											class="form-control input-sm minwidth150"></select>
									</div>
								</div>
								<div class="col-sm-2" data-bind="if: tab() != 'Stock OD'">
									<div class="form-group">
										<select data-bind="value: hc,
											options: hcList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'All HC'"
											class="form-control"></select>
									</div>
								</div>
								<div class="col-sm-1">
									<div class="form-group">
										<select data-bind="value: year, options: yearList" class="form-control input-sm width70"></select>
									</div>
								</div>

								<div class="col-sm-1">
									<div class="form-group">
										<select data-bind="value: month, options: monthList, optionsCaption: 'Select Month'" class="form-control"></select>
									</div>
								</div>

								<div class="col-sm-4">
									<a href="/Home" class="btn btn-dark pull-right"><i class="fa fa-home"></i> Home</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- List -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-striped table-hover" >
						<thead class="bg-info">
							<tr>
								<th width="40" align="center">#</th>
								<th align="center">Province</th>
								<th align="center">OD</th>
								<th align="center">HC</th>
								<th align="center">Year</th>
								<th align="center">Month</th>
								<th align="center">Description</th>
								<th align="center">Deleted Date</th>
								<th align="center">Deleted By</th>
								<th align="center">Module</th>
								<th>By Mobile</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: dataList, fixedHeader: true">
							<tr>
								<td data-bind="text: $index() + 1" class="text-center"></td>
								<td data-bind="text: $root.getProvinceName(Code_Prov_N)"></td>
								<td data-bind="text: $root.getODName(Code_OD_T)"></td>
								<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
								<td align="center" data-bind="text: Year"></td>
								<td align="center" data-bind="text: Month"></td>
								<td data-bind="html: Description"></td>
								<td align="center" data-bind="text: InitTime"></td>
								<td align="center" data-bind="text: InitUser"></td>
								<td align="center" data-bind="text: Module"></td>
								<td align="center" data-bind="html: IsMobile"></td>
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
		</div>
	</div>

</div>

<?=latestJs('/media/ViewModel/CaseLog.js')?>