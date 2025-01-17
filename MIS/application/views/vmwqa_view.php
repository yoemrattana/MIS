<style>
	.table-hover thead { background-color: #9AD8ED; }
	.space { margin-left: 30px; }
	.box { border: 1px solid; padding: 5px; }
	.radio:first-child, .checkbox:first-child { margin-top: 0; }
	.radio:last-child, .checkbox:last-child { margin-bottom: 0; }
	.pink { background: #FBE4D5; }
	.gray { color: gray; }
	.blue { color: blue; }
	.bg-gray { background: #D9D9D9; }

	.container .table-bordered > tbody > tr > th,
	.container .table-bordered > tbody > tr > td { border: 1px solid black; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">	
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left">
			<button class="btn btn-default minwidth150" data-bind="click: menuClick">Questionnaire Form</button>
			<button class="btn btn-default minwidth150" data-bind="click: menuClick">Supervision Schedule</button>
			<button class="btn btn-default minwidth150" data-bind="click: menuClick">Monitor</button>
			<button class="btn btn-default minwidth150" data-bind="click: menuClick">Report</button>
			<button class="btn btn-default minwidth150" data-bind="click: menuClick">Dashboard</button>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-heading clearfix" data-bind="visible: menu() != null">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list'">
			<div style="display:inline-block">
				<div class="text-bold">Province</div>
				<select data-bind="value: pv,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All Province'"
					class="form-control minwidth150"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">OD</div>
				<select data-bind="value: od,
						options: odList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All OD'"
					class="form-control minwidth150"></select>
			</div>
			<!-- ko if: menu() != 'Dashboard' -->
			<div style="display:inline-block">
				<div class="text-bold">HC</div>
				<select data-bind="value: hc,
						options: hcList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All HC'"
					class="form-control minwidth150"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Village</div>
				<select data-bind="value: vl,
						options: vlList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All Village'"
					class="form-control minwidth150"></select>
			</div>
			<!-- /ko -->
			<!-- ko ifnot: ['Supervision Schedule','Dashboard'].contain(menu()) -->
			<div style="display:inline-block">
				<div class="text-bold">Year</div>
				<select data-bind="value: year, options: yearList" class="form-control"></select>
			</div>
			<div style="display:inline-block" data-bind="visible: menu() != 'Supervision Schedule'">
				<div class="text-bold">Month</div>
				<select data-bind="value: month,
						options: monthList,
						optionsCaption: ['Questionnaire Form','Monitor'].contain(menu()) ? 'All' : undefined" class="form-control"></select>
			</div>
			<!-- /ko -->
			<button class="btn btn-primary width100" data-bind="click: showReport, visible: ['Supervision Schedule','Report','Dashboard'].contain(menu())">View</button>
		</div>
		<div class="pull-right" data-bind="visible: menu() == 'Questionnaire Form' && view() == 'list'" style="padding-top:20px">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: app.user.permiss['VMW QA'].contain('New')">New</button>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'detail'">
			<button class="btn btn-primary width100" data-bind="click: save, visible: app.user.permiss['VMW QA'].contain('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
		<div class="pull-right" data-bind="visible: ['Monitor','Report'].contain(menu())" style="padding-top:20px">
			<button class="btn btn-success width100" data-bind="click: exportExcel">Export Excel</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: menu() == 'Questionnaire Form' && view() == 'list'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th align="center" sortable>Province</th>
					<th align="center" sortable>OD</th>
					<th align="center" sortable>HC</th>
					<th align="center" sortable>Village</th>
					<th align="center" sortable>VMW Name</th>
					<th align="center" sortable>Visit Date</th>
					<th align="center" sortable>Visitor Name</th>
					<th align="center" sortable>Position</th>
					<th align="center" sortable>Workplace</th>
					<th align="center" sortable>Score</th>
					<th align="center" sortable>TPR</th>
					<th width="60" align="center">Detail</th>
					<th width="60" align="center" data-bind="visible: app.user.permiss['VMW QA'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: filteredListModel, fixedHeader: true, sortModel: listModel">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getPVName(Code_Prov_N)"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
					<td data-bind="text: $root.getVLName(Code_Vill_T)"></td>
					<td data-bind="text: VMWName, css: { kh: iskhmer(VMWName) }"></td>
					<td data-bind="text: VisitDate" align="center"></td>
					<td data-bind="text: VisitorName, css: { kh: iskhmer(VisitorName) }"></td>
					<td data-bind="text: Position, css: { kh: iskhmer(VMWName) }"></td>
					<td data-bind="text: WorkPlace"></td>
					<td data-bind="text: TotalScore" align="center"></td>
					<td data-bind="text: FormType == 'Old' ? TPR + '%' : ''" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['VMW QA'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
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

	<?php $this->load->view('vmwqa_form_view'); ?>
	<?php $this->load->view('vmwqareport_view'); ?>

	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && app.user.permiss['VMW QA'].contain('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<?=form_hidden('chartODBorder', latestFile('/media/Maps/chartODBorder.js'))?>

<?=latestJs('/media/ViewModel/VMWQA.js')?>
<?=latestJs('/media/ViewModel/VMWQADashboard.js')?>