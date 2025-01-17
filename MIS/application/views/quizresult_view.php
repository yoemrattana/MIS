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

    .outline-shadow {
        box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
        border: 1px solid #000;
    }

    .radius-right {
        border-radius: unset;
        border-top-right-radius: 20px;
    }

</style>

<div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Quiz Result</h4>
					<form>
						<div class="container9">
							<div class="row">
								<div class="col-sm-6">
									<div class="button-group">
										<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('MIS')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">MIS</button>
										<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('M&E')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">M&E</button>
										<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('EPI')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">EPI</button>
										<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('Finance')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Finance</button>
										<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('VMW')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">VMW</button>
										<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('Education')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Education</button>
									</div>
								</div>
								<div class="col-sm-6">
									<a href="/Home" class="btn btn-dark pull-right">
										<i class="fa fa-home"></i> Home
									</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<form style="display: none" data-bind="visible: tab() != undefined">
		<div class="container9">
			<div class="row">
				<div class="col-sm-8">
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<select data-bind="value: pv,
											options: pvList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: pvList().length == 1 ? undefined : 'All Province'"
									class="form-control input-sm minwidth150 outline-shadow"></select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<select data-bind="value: od,
											options: odList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: odList().length == 1 ? undefined : 'All OD'"
									class="form-control input-sm minwidth150 outline-shadow"></select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<select data-bind="value: hc,
											options: hcList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'All HC'"
									class="form-control outline-shadow"></select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<hr style="margin-top:0"/>
</div>

<!--List-->
<div class="row" style="display: none" data-bind="visible: tab() != undefined">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			<!--<div class="card-header bg-info">
				<h4 class="m-b-0 text-white float-left">Questionaire</h4>
			</div>-->
			<div class="card-body">
				<table class="table table-bordered table-striped table-hover">
					<thead class="bg-info">
						<tr>
							<th width="40" align="center">#</th>
							<th align="center">Province</th>
							<th align="center">OD</th>
							<th align="center">Place</th>
							<th align="center">Category</th>
							<th align="center">Score (%)</th>
							<th align="center">Duration (Second)</th>
							<th align="center">#Correct</th>
							<th align="center">#Incorrect</th>
							<th align="center">Status</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: dataList, fixedHeader: true">
						<tr>
							<td style="text-align:center" data-bind="text: $index() + 1" class="text-center"></td>
							<td style="text-align:center" data-bind="text: Name_Prov_E" class="kh"></td>
							<td style="text-align:center" data-bind="text: Name_OD_E" class="kh"></td>
							<td style="text-align:center" data-bind="text: Code_Place.length == 10 ? $root.getVLName(Code_Place) : $root.getHCName(Code_Place)" class="kh"></td>
							<td style="text-align:center" data-bind="text: Category" class="kh"></td>
							<td style="text-align:center" data-bind="text: TotalScore"></td>
							<td style="text-align:center" data-bind="text: Duration"></td>
							<td style="text-align:center" data-bind="text: Correct"></td>
							<td style="text-align:center" data-bind="text: Incorrect"></td>
							<td style="text-align:center" data-bind="html: Status"></td>
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

<?=latestJs('/media/ViewModel/QuizResult.js')?>