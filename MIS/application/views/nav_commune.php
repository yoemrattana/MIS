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

			<strong style="margin-left:10px">District</strong>
			<select class="form-control input-sm" data-bind="value: dist, options: distList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All District'"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm" data-bind="click: showCreate, visible: app.user.permiss['System Menu'].contain('Commune - Edit')">Add Commune</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Province EN</th>
					<th>Province KH</th>
					<th sortable>District EN</th>
					<th sortable>District KH</th>
					<th sortable>Commune EN</th>
					<th sortable>Commune KH</th>
					<th sortable>Commune Code</th>
					<th width="50" data-bind="visible: app.user.permiss['System Menu'].contain('Commune - Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['System Menu'].contain('Commune - Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_Prov_K" class="kh"></td>
					<td data-bind="text: Name_Dist_E"></td>
					<td data-bind="text: Name_Dist_K" class="kh"></td>
					<td data-bind="text: Name_Comm_E"></td>
					<td data-bind="text: Name_Comm_K" class="kh"></td>
					<td data-bind="text: Code_Comm_T"></td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Commune - Edit')">
						<a data-bind="click: $parent.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Commune - Delete')">
						<a class="text-danger" data-bind="click: $parent.delete">Delete</a>
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
				<h4 class="modal-title text-primary">Edit Commune</h4>
			</div>
			<div class="modal-body">
				<div class="form-horizontal" data-bind="with: editModel">
					<div class="form-group form-group-sm" data-bind="visible: isNew">
						<label class="control-label col-xs-4">District:</label>
						<div class="col-xs-8">
							<select class="form-control" data-bind="value: dist, options: $parent.distList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label class="control-label col-xs-4">Commune Name English:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" data-bind="value: Name_Comm_E" />
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label class="control-label col-xs-4">Commune Name Khmer:</label>
						<div class="col-xs-8">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" data-bind="value: Name_Comm_K" />
								<span class="input-group-addon">Unicode</span>
							</div>
						</div>
					</div>
					<div class="form-group form-group-sm no-margin-bottom">
						<label class="control-label col-xs-4">Commune Code:</label>
						<div class="col-xs-8">
							<p class="form-control-static" data-bind="text: isempty(Code_Comm_T(), '0000')" />
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

<?=latestJs('/media/ViewModel/Nav_Commune.js')?>