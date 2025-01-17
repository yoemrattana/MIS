<style>
    .table th {
        background: #9AD8ED;
        text-align: center;
    }

    .table td {
        white-space: nowrap;
    }

    body {
        overflow-y: scroll;
    }
</style>

<div id="sysmenuboard" class="panel panel-default" style="display:none" data-bind="visible: true">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<strong style="margin-left:5px">System Table</strong>
			<?php echo form_dropdown('systable',$systablelist,$systable,'class="form-control input-sm" id="systable"');?>
			<input type="hidden" id="code_prov" value="01" />

			<strong style="margin-left:10px">Province</strong>
			<select class="form-control input-sm minwidth150" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Province'"></select>
			<strong style="margin-left:10px">Office</strong>
			<select class="form-control input-sm minwidth150" data-bind="value: Office, options: OfficeList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Office'"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm minwidth100" data-bind="click: showCreate" style="margin-right:20px">Add Community</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th sortable>Province EN</th>
					<th sortable>Office EN</th>
					<th sortable>Office KH</th>
					<th sortable>Community EN</th>
					<th sortable>Community KH</th>
					<th sortable>Community Code</th>
					<th width="50">Edit</th>
					<th width="60">Delete</th>
				</tr>
			</thead>
            <tbody data-bind="foreach: listModel, fixedHeader: [0,1,3], sortModel: mainData">
                <tr>
                    <td data-bind="text: Name_Prov_E"></td>
                    <td data-bind="text: Name_Office_E"></td>
                    <td data-bind="text: Name_Office_K" class="kh"></td>
                    <td data-bind="text: Name_Community_E"></td>
                    <td data-bind="text: Name_Community_K" class="kh"></td>
                    <td data-bind="text: Code_Community_T"></td>
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
				<h4 class="modal-title text-primary" data-bind="text: Rec_ID() == 0 ? 'Add Community' : 'Edit Community'"></h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group">
					<label class="control-label col-xs-3">Province:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_Prov_T, options: $parent.provList, optionsValue: 'code', optionsText: 'name', optionsCaption: Rec_ID() == 0 ? '-- Choose --' : undefined"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Office:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_Office_T, options: OfficeList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Community Name EN:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: Name_Community_E" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Community Name KH:</label>
					<div class="col-xs-9">
						<div class="input-group">
							<input type="text" class="form-control" data-bind="value: Name_Community_K" />
							<span class="input-group-addon">Unicode</span>
						</div>
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<label class="control-label col-xs-3">Community Code:</label>
					<div class="col-xs-9">
						<p class="form-control-static" data-bind="text: Code_Community_T"></p>
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

<?=latestJs('/media/ViewModel/Nav_EnvCommunity.js')?>