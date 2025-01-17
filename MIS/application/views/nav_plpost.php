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
			<input type="hidden" id="code_prov" value="01" />

			<strong style="margin-left:10px">Province</strong>
			<select class="form-control input-sm minwidth150" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Province'"></select>
			<strong style="margin-left:10px">Troop</strong>
			<select class="form-control input-sm minwidth150" data-bind="value: troop, options: troopList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Troop'"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm minwidth100" data-bind="click: showCreate" style="margin-right:20px">Add Post</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th sortable>Province EN</th>
					<th sortable>Troop EN</th>
					<th sortable>Troop KH</th>
					<th sortable>Post EN</th>
					<th sortable>Post KH</th>
					<th sortable>Post Code</th>
					<th width="50">Edit</th>
					<th width="60">Delete</th>
				</tr>
			</thead>
            <tbody data-bind="foreach: listModel, fixedHeader: [0,1,4], sortModel: mainData">
                <tr>
                    <td data-bind="text: Name_Prov_E"></td>
                    <td data-bind="text: Name_Troop_E"></td>
                    <td data-bind="text: Name_Troop_K" class="kh"></td>
                    <td data-bind="text: Name_Post_E"></td>
                    <td data-bind="text: Name_Post_K" class="kh"></td>
                    <td data-bind="text: Code_Post_T"></td>
                    <td align="center">
                        <a data-bind="click: $parent.showEdit">Edit</a>
                    </td>
                    <td align="center">
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
			<div class="modal-header" data-bind="with: editModel">
				<h4 class="modal-title text-primary" data-bind="text: Rec_ID() == 0 ? 'Add Troop' : 'Edit Troop'"></h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group">
					<label class="control-label col-xs-3">Province:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_Prov_T, options: $parent.provList, optionsValue: 'code', optionsText: 'name', optionsCaption: Rec_ID() == 0 ? '-- Choose --' : undefined"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Troop:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_Troop_T, options: troopList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Post Name EN:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: Name_Post_E" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Post Name KH:</label>
					<div class="col-xs-9">
						<div class="input-group">
							<input type="text" class="form-control" data-bind="value: Name_Post_K" />
							<span class="input-group-addon">Unicode</span>
						</div>
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<label class="control-label col-xs-3">Post Code:</label>
					<div class="col-xs-9">
						<p class="form-control-static" data-bind="text: Code_Post_T" />
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

<?=latestJs('/media/ViewModel/Nav_PLPost.js')?>