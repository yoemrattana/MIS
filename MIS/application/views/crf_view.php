<style>
	.table-hover thead { background-color: #9AD8ED; }
	.form-control { padding: 6px; }
	.container .form-control, .container .input-group-addon { font-size: 16px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left">
			<a href="/CRF/index/baseline" class="btn btn-default minwidth150 btnmenu">Baseline Assessment</a>
			<a href="/CRF/index/sample" class="btn btn-default minwidth150 btnmenu">Sample Collection</a>
			<a href="/CRF/index/rdtuser1" class="btn btn-default minwidth150 btnmenu">RDT Interpretation User 1</a>
			<a href="/CRF/index/rdtuser2" class="btn btn-default minwidth150 btnmenu">RDT Interpretation User 2</a>
			<a href="/CRF/index/rdtuser3" class="btn btn-default minwidth150 btnmenu">RDT Interpretation User 3</a>
			<a href="/CRF/index/elisa" class="btn btn-default minwidth150 btnmenu">ELISA Reference</a>
            <a href="/CRF/index/report" class="btn btn-default minwidth150 btnmenu">Report</a>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<!-- ko if: hasSub() && menu() != 'report' -->
	<div class="panel-heading clearfix" data-bind="visible: view() != 'detail' && app.user.permiss['CRF'].contain('Edit')">
		<div class="pull-left form-inline">
			<b>Health Center</b>
			<select data-bind="value: hc, options: hcList, optionsValue: 'id', optionsText: 'name', optionsCaption: 'All'" class="form-control input-sm"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: showNew">New</button>
		</div>
	</div>
	<div class="panel-heading clearfix" data-bind="visible: view() == 'detail'">
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: view() == 'detail' && app.user.permiss['CRF'].contain('Edit')">Save</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Health Center</th>
					<th>Participant Code</th>
					<th>Created Date</th>
					<th>Edited By</th>
					<th>Edited Date</th>
					<th width="60" class="text-center">Detail</th>
					<th width="60" class="text-center" data-bind="visible: app.user.permiss['CRF'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.hcNames[ParticipantCode.substr(0,2)]"></td>
					<td data-bind="text: 'AM002' + ParticipantCode"></td>
					<td data-bind="text: moment(InitTime).format('lll')"></td>
					<td data-bind="text: ModiUser"></td>
					<td data-bind="text: isnot(ModiTime, null, r => moment(r).format('lll'))"></td>
					<td class="text-center"><a data-bind="click: $root.showDetail">Detail</a></td>
					<td class="text-center" data-bind="visible: app.user.permiss['CRF'].contain('Delete')">
						<a data-bind="click: $root.delete" class="text-danger">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

        <?php if ($sub != '' && $sub != 'crfreport_view') $this->load->view($sub); ?>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && app.user.permiss['CRF'].contain('Edit')">
		<button class="btn btn-primary btn-sm width150" data-bind="click: save">Save</button>
	</div>
	<!-- /ko -->

    <?php if ($sub == 'crfreport_view') $this->load->view($sub); ?>
</div>

<?=latestJs('/media/ViewModel/CRF.js')?>