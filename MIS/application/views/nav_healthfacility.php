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
			<button class="btn btn-primary btn-sm" data-bind="click: showCreate, visible: isAdmin && app.user.permiss['System Menu'].contain('Health Facilities - Edit')" style="display:none">Add Health Facility</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>

	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th sortable>OD</th>
					<th sortable>HC Name EN</th>
					<th sortable>HC Name KH</th>
					<th sortable>Type</th>
					<th sortable>MIS Code</th>
					<th sortable>HIS Code</th>
					<th>Lat</th>
					<th>Long</th>
					<th sortable>District</th>
					<th sortable>Commune</th>
					<th sortable>Village</th>
					<th width="50" data-bind="visible: app.user.permiss['System Menu'].contain('Health Facilities - Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.role == 'AU'">Delete</th>
				</tr>
			</thead>
            <tbody data-bind="foreach: listModel, fixedHeader: 1">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $parent.getOdName(Code_OD_T)"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Facility_K" class="kh"></td>
					<td data-bind="text: Type_Facility"></td>
					<td data-bind="text: Code_Facility_T"></td>
					<td data-bind="text: HIS_HFCode"></td>
					<td data-bind="text: Lat"></td>
					<td data-bind="text: long"></td>
					<td data-bind="text: $parent.getDistName(Code_Vill_T)"></td>
					<td data-bind="text: $parent.getCommName(Code_Vill_T)"></td>
					<td data-bind="text: $parent.getVillName(Code_Vill_T)"></td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Health Facilities - Edit')">
						<a data-bind="click: $parent.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.role == 'AU'">
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
				<h4 class="modal-title text-primary" data-bind="text: (isnew() == 1 ? 'Add' : 'Edit') + ' Health Facility'"></h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group form-group-sm" data-bind="visible: isnew() == 0">
					<label class="control-label col-xs-4">Province:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Code_Prov_N, options: pvList, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">OD:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Code_OD_T, options: odList(), optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">HC Name English:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Name_Facility_E" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">HC Name Khmer:</label>
					<div class="col-xs-8">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" data-bind="value: Name_Facility_K" />
							<span class="input-group-addon">Unicode</span>
						</div>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Type:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Type_Facility, options: $parent.typeList"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Code:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Code_Facility_T" style="width:50%" maxlength="6" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">HIS Code:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: HIS_HFCode" style="width:50%" maxlength="15" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Lat:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Lat" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Long:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: long" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">District:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: distCode, options: distList(), optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Commune:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: commCode, options: commList(), optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-4">Village:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Code_Vill_T, options: villList(), optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
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

<?=latestJs('/media/ViewModel/Nav_Healthfacility.js')?>