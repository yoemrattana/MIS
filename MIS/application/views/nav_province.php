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
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Province EN</th>
					<th>Province KH</th>
					<th>Province Code</th>
					<th>CSO</th>
					<th>CSO 2021</th>
					<th width="50" data-bind="visible: app.user.permiss['System Menu'].contain('Province - Edit')">Edit</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_Prov_K" class="kh"></td>
					<td data-bind="text: Code_Prov_T"></td>
					<td data-bind="text: CSO"></td>
					<td data-bind="text: CSO2021"></td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Province - Edit')">
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
				<h4 class="modal-title text-primary">Edit Province</h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Province Name English:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Name_Prov_E" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Province Name Khmer:</label>
					<div class="col-xs-8">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" data-bind="value: Name_Prov_K" />
							<span class="input-group-addon">Unicode</span>
						</div>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">CSO:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: CSO" />
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-4">CSO 2021:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: CSO2021" />
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

<?=latestJs('/media/ViewModel/Nav_Province.js')?>