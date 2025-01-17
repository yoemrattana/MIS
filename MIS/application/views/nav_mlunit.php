
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

			<strong style="margin-left:10px">Regional</strong>
			<select class="form-control input-sm kh" data-bind="value: rg, options: rgList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
        </div>
        <div class="pull-right">
			<button class="btn btn-primary btn-sm width80" data-bind="click: showNew">New</button>
            <a href="/Home" class="btn btn-default btn-sm">Home</a>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
					<th sortable>Regional EN</th>
					<th sortable>Regional KH</th>
					<th sortable>Unit EN</th>
                    <th sortable>Unit KH</th>
                    <th sortable>Unit Code</th>
                    <th width="60" data-bind="visible: app.user.permiss['System Menu'].contain('Military - Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['System Menu'].contain('Military - Delete')">Delete</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: getListModel(), fixedHeader: true, sortModel: listModel">
                <tr>
					<td data-bind="text: Name_Regional_E"></td>
					<td data-bind="text: Name_Regional_K"></td>
                    <td data-bind="text: Name_Unit_E"></td>
                    <td data-bind="text: Name_Unit_K" class="kh"></td>
                    <td data-bind="text: Code_Unit_T"></td>
                    <td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Military - Edit')">
                        <a data-bind="click: $parent.showEdit">Edit</a>
                    </td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Military - Delete')">
						<a class="text-danger" data-bind="click: $parent.showDelete">Delete</a>
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
					<label class="control-label col-xs-4">Regional:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Code_Regional_T, options: $root.rgList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Unit Code:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Code_Unit_T" disabled />
					</div>
				</div>
                <div class="form-group form-group-sm">
                    <label class="control-label col-xs-4">Unit Name English:</label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" data-bind="value: Name_Unit_E" />
                    </div>
                </div>
                <div class="form-group form-group-sm no-margin-bottom">
                    <label class="control-label col-xs-4">Unit Name Khmer:</label>
                    <div class="col-xs-8">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" data-bind="value: Name_Unit_K" />
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

<?=latestJs('/media/ViewModel/Nav_MLUnit.js')?>