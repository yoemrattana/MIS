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
			<?php echo form_dropdown('code_prov',$provlist,$code_prov,'class="form-control input-sm" id="code_prov"'); ?>

			<span data-bind="visible: odList().length > 1" style="display:none">
				<strong style="margin-left:10px">OD</strong>
				<select class="form-control input-sm" data-bind="value: odFilter, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All OD'"></select>
			</span>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm" data-bind="click: showCreate, visible: app.user.permiss['System Menu'].contain('Drug Outlets - Edit')">Add Drug Outlet</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>

	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th sortable>OD</th>
					<th sortable>Village</th>
					<th sortable>Type</th>
					<th sortable>Pharmacy Name EN</th>
					<th sortable>Pharmacy Name KH</th>
					<th sortable>PPM</th>
					<th>Lat</th>
					<th>Long</th>
					<th width="50" data-bind="visible: app.user.permiss['System Menu'].contain('Drug Outlets - Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['System Menu'].contain('Drug Outlets - Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr data-bind="visible: $parent.odFilter() == null || $parent.odFilter() == Code_OD_T">
					<td data-bind="text: $parent.getOdName(Code_OD_T)"></td>
					<td data-bind="text: $parent.getVillName(Code_Vill_T)"></td>
					<td data-bind="text: Type"></td>
					<td data-bind="text: Name_Outlet_E"></td>
					<td data-bind="text: Name_Outlet_K"></td>
					<td data-bind="text: PPM == '1' ? 'Yes' : 'No'" align="center"></td>
					<td data-bind="text: Lat"></td>
					<td data-bind="text: long"></td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Drug Outlets - Edit')">
						<a data-bind="click: $parent.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Drug Outlets - Delete')">
						<a data-bind="click: $parent.showDelete" class="text-danger">Delete</a>
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
				<h4 class="modal-title text-primary" data-bind="text: (ID()==''?'Add':'Edit') + ' Drug Outlet'"></h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">OD:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Code_OD_T, options: $parent.odList, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Village:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Code_Vill_T, options: $parent.villageList, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Type:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Type, options: $parent.typeList"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Pharmacy Name English:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Name_Outlet_E" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Pharmacy Name Khmer:</label>
					<div class="col-xs-8">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" data-bind="value: Name_Outlet_K" />
                            <span class="input-group-addon">Unicode</span>
                        </div>
                    </div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">PPM:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: PPM">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Lat:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Lat" />
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-4">Long:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: long" />
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

<?=latestJs('/media/ViewModel/Nav_Drugoutlet.js')?>