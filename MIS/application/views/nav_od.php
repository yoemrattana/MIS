<style>
	.table th { background: #9AD8ED; text-align: center; }
	.table td { white-space: nowrap; }
	body { overflow-y: scroll; }
</style>

<div id="sysmenuboard" class="panel panel-default" style="display:none" data-bind="visible: true">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<strong style="margin-left:5px">System Table</strong>
			<?php echo form_dropdown('systable',$systablelist,$systable,'class="form-control input-sm" id="systable"');?>

			<strong style="margin-left:10px">Province</strong>
			<select class="form-control input-sm" id="code_prov" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'name'"></select>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th sortable>Province EN</th>
					<th sortable>Province KH</th>
					<th sortable>OD EN</th>
					<th sortable>OD KH</th>
					<th sortable>OD Code</th>
					<th width="50" data-bind="visible: app.user.permiss['System Menu'].contain('OD - Edit')">Edit</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: 2">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_Prov_K" class="kh"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_OD_K" class="kh"></td>
					<td data-bind="text: Code_OD_T"></td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('OD - Edit')">
						<a data-bind="click: $parent.showEdit">Edit</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Edit District</h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-3">OD Name English:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control input-sm" data-bind="value: Name_OD_E" />
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-3">OD Name Khmer:</label>
					<div class="col-xs-9">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" data-bind="value: Name_OD_K" />
							<span class="input-group-addon">Unicode</span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: edit" style="width:100px">Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Nav_OD.js')?>