<style>
	.table-hover thead { background-color: #9AD8ED; }
	.form-control { padding: 6px; }
	.container .form-control, .container .input-group-addon { font-size: 16px; }
	#modalPlace1 .form-control { padding: 0 15px 0 6px; }
	.btnmenu { min-width:100px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left">
			<a href="/QMalaria/index/labo" class="btn btn-default btnmenu">Laboratory</a>
			<a href="/QMalaria/index/clinic" class="btn btn-default btnmenu">Clinical</a>
			<a href="/QMalaria/index/testing" class="btn btn-default btnmenu">CRP Testing</a>
			<a href="/QMalaria/index/sample" class="btn btn-default btnmenu">Sample Reception</a>
			<a href="/QMalaria/index/baselinedata" class="btn btn-default btnmenu">Baseline Data</a>
			<a href="/QMalaria/index/followup" class="btn btn-default btnmenu">Follow Up</a>
			<a href="/QMalaria/report1" class="btn btn-default btnmenu">Report Phase 1</a>
			<a href="/QMalaria/report2" class="btn btn-default btnmenu">Report Phase 2</a>
			<button class="btn btn-success" data-bind="click: exportAll">Export Labo &amp; Clincal</button>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<!-- ko if: hasSub -->
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list'">
			<span><b>Province</b></span>
			<select data-bind="value: prov,
					options: provList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All Province'" class="form-control input-sm minwidth150"></select>

			<span style="margin-left:15px"><b>OD</b></span>
			<select data-bind="value: od,
					options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All OD'" class="form-control input-sm minwidth150"></select>

			<span style="margin-left:15px"><b>HC</b></span>
			<select data-bind="value: hc,
					options: hcList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All HC'" class="form-control input-sm minwidth150"></select>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'list' && !location.pathname.contain('baselinedata') && app.user.permiss['Q Malaria'].contain('Edit')">
			<button class="btn btn-primary btn-sm width100" data-bind="click: showNew">New</button>
			<button class="btn btn-success btn-sm" data-bind="click: exportExcel">Export Excel</button>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'detail'">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['Q Malaria'].contain('Edit')">Save</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: back">Back</button>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'log'">
			<button class="btn btn-default btn-sm width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Province</th>
					<th>OD</th>
					<th>HC</th>
					<th>Identity Code</th>
					<th>Activity Date</th>
					<th width="60" class="text-center">Detail</th>
					<th width="60" class="text-center" data-bind="visible: app.user.permiss['Q Malaria'].contain('Delete')">Delete</th>
					<th width="60" class="text-center" data-bind="visible: app.user.permiss['Q Malaria'].contain('Log')">Log</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getProvNameE(Code_Facility_T)"></td>
					<td data-bind="text: $root.getODNameE(Code_Facility_T)"></td>
					<td data-bind="text: $root.getHCNameE(Code_Facility_T)"></td>
					<td data-bind="text: $root.getIdentityCode($data)"></td>
					<td data-bind="text: $root.getActivityDate($data)"></td>
					<td class="text-center"><a data-bind="click: $root.showDetail">Detail</a></td>
					<td class="text-center" data-bind="visible: app.user.permiss['Q Malaria'].contain('Delete')">
						<a data-bind="click: $root.delete" class="text-danger">Delete</a>
					</td>
					<td class="text-center" data-bind="visible: app.user.permiss['Q Malaria'].contain('Log')">
						<a data-bind="click: $root.showLog">Log</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<table class="table table-bordered table-striped table-hover" data-bind="visible: view() == 'log'">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th sortable>Edited By</th>
					<th sortable>Edited Date</th>
					<th sortable>Field Name</th>
					<th>Old Value</th>
					<th>New Value</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: logList, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: ModiUser"></td>
					<td data-bind="text: ModiTime.substr(0, 19)"></td>
					<td data-bind="text: Name"></td>
					<td data-bind="text: OldValue"></td>
					<td data-bind="text: NewValue"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<?php if ($sub != '') $this->load->view($sub); ?>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && app.user.permiss['Q Malaria'].contain('Edit')">
		<button class="btn btn-primary btn-sm width150" data-bind="click: save">Save</button>
	</div>
	<!-- /ko -->
</div>

<!-- Modal Place1 -->
<div id="modalPlace1" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:350px">
		<div class="modal-content" data-bind="with: placeModel1">
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-xs-3">Province:</label>
						<div class="col-xs-9 kh">
                            <select class="form-control" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">OD:</label>
						<div class="col-xs-9 kh">
							<select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">HC:</label>
						<div class="col-xs-9 kh">
							<select class="form-control" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" style="width:100px" data-bind="click: ok">OK</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Place1 -->
<div id="modalPlace1English" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:350px">
		<div class="modal-content" data-bind="with: placeModel1">
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-xs-3">Province:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">OD:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">HC:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" style="width:100px" data-bind="click: ok">OK</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/QM.js')?>