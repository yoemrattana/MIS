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
					<th sortable>Regional Code</th>
					<th width="60" data-bind="visible: app.user.permiss['System Menu'].contain('Military - Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['System Menu'].contain('Military - Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader">
				<tr>
					<td data-bind="text: Name_Regional_E"></td>
					<td data-bind="text: Name_Regional_K" class="kh"></td>
					<td data-bind="text: Code_Regional_T"></td>
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
					<label class="control-label col-xs-4">Regional Code:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Code_Regional_T" disabled />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Regional Name English:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Name_Regional_E" />
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-4">Regional Name Khmer:</label>
					<div class="col-xs-8">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" data-bind="value: Name_Regional_K" />
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

<?=latestJs('/media/ViewModel/Nav_Regional.js')?>