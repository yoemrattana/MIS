<style>
	.btnmenu { min-width: 150px; margin-bottom: 4px; }
	.table-hover thead { background-color: #9AD8ED; }
	.space { margin-left: 15px; }
	li { margin-bottom: 5px }
	.kh label { font-weight: normal; display: inline; }	
	.kh span { line-height: 26px; }
	.line { border: 1px solid black; margin-bottom: 10px; }
	#tbl1 th { text-align: center; }
	#tbl1 th, #tbl1 td { border: 1px solid black; }
	.col-xs-9 { padding-left: 0; }
	.form-group-sm select.form-control { height: 30px; }
	.form-horizontal .form-group-sm .control-label { padding-top: 8px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left">
			<a href="/Question/index/Q11" class="btn btn-default btnmenu">Annex 1: Village Selection </a>
			<a href="/Question/index/Q12" class="btn btn-default btnmenu">Annex 2: Hotspot Identification</a>
			<a href="/Question/index/Q21" class="btn btn-default btnmenu">Annex 4: ​MMW Recruitment</a>
			<a href="/Question/index/Q13" class="btn btn-default btnmenu">Annex 5, 6: Site Visit Active Screening</a>
			<a href="/Question/index/Q22" class="btn btn-default btnmenu">Annex 7: Forest Pack</a>
			<a href="/Question/index/Q23" class="btn btn-default btnmenu hidden">MMW Active Screening</a>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<!-- ko if: hasSub -->
	<div class="panel-heading clearfix">
        <div class="pull-left font16 lh28" data-bind="visible: view() != 'list'">
            <b data-bind="text: $root.tab"></b>
        </div>
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
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="visible: view() == 'list', click: showNew">New</button>
			<button class="btn btn-default btn-sm width100" data-bind="visible: view() == 'detail', click: back">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Province</th>
					<th>OD</th>
					<th>Created By</th>
					<th>Created Date</th>
					<th>Edited By</th>
					<th>Edited Date</th>
					<th width="60" class="text-center">Detail</th>
					<th width="60" class="text-center" data-bind="visible: app.user.permiss['Questionnaire'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getProvNameE(SubmitOD)"></td>
					<td data-bind="text: $root.getODNameE(SubmitOD)"></td>
					<td data-bind="text: InitUser"></td>
					<td data-bind="text: moment(InitTime).format('lll')"></td>
					<td data-bind="text: ModiUser"></td>
					<td data-bind="text: isnot(ModiTime, null, r => moment(r).format('lll'))"></td>
					<td class="text-center"><a data-bind="click: $root.showDetail">Detail</a></td>
					<td class="text-center" data-bind="visible: app.user.permiss['Questionnaire'].contain('Delete')">
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

		<?php if ($sub != '') $this->load->view($sub); ?>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'detail'">
        <button class="btn btn-primary btn-sm width150" data-bind="click: save, visible: app.user.permiss['Questionnaire'].contain('Edit')">Save</button>
	</div>
	<!-- /ko -->
</div>

<!-- Modal Place1 -->
<div id="modalPlace1" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:350px">
		<div class="modal-content" data-bind="with: placeModel1">
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group form-group-sm">
						<label class="control-label col-xs-3">Province:</label>
						<div class="col-xs-9">
                            <select class="form-control" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: $root.isSingle(provList()) ? undefined : ''"></select>
						</div>
					</div>
					<div class="form-group form-group-sm" data-bind="visible: level() >= 2">
						<label class="control-label col-xs-3">OD:</label>
						<div class="col-xs-9">
                            <select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: $root.isSingle(odList()) ? undefined : ''"></select>
						</div>
					</div>
					<div class="form-group form-group-sm" data-bind="visible: level() >= 3">
						<label class="control-label col-xs-3">HC:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group form-group-sm" data-bind="visible: level() >= 4">
						<label class="control-label col-xs-3">Village:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: vill, options: villList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
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

<!-- Modal Place2 -->
<div id="modalPlace2" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:350px">
		<div class="modal-content" data-bind="with: placeModel2">
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group form-group-sm">
						<label class="control-label col-xs-3">Province:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group form-group-sm" data-bind="visible: level() >= 2">
						<label class="control-label col-xs-3">District:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: dist, options: distList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group form-group-sm" data-bind="visible: level() >= 3">
						<label class="control-label col-xs-3">Commune:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: comm, options: commList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group form-group-sm" data-bind="visible: level() >= 4">
						<label class="control-label col-xs-3">Village:</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: vill, options: villList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: ''"></select>
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

<?=latestJs('/media/ViewModel/Question.js')?>