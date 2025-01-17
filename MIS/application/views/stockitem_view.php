<style>
	thead { background-color: #9AD8ED; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh34">
			<b>Stock Item</b>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showAdd">Add Item</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th align="center">#</th>
					<th>Code</th>
					<th>Item Name</th>
					<th>Strength</th>
					<th>Unit</th>
					<th align="center">Category</th>
					<th align="center">Enable OD</th>
					<th align="center">Enable HF</th>
					<th align="center">Enable VMW</th>
					<th align="center">Edit</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Code"></td>
					<td data-bind="text: Description"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td data-bind="text: Category" align="center"></td>
					<td data-bind="text: EnableOD == 1 ? 'Yes' : 'No'" align="center"></td>
					<td data-bind="text: EnableHF == 1 ? 'Yes' : 'No'" align="center"></td>
					<td data-bind="text: EnableVMW == 1 ? 'Yes' : 'No'" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showEdit">Edit</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document" data-bind="with: editModel">
			<div class="modal-header">
				<h4 class="modal-title text-primary" data-bind="text: Id() == 0 ? 'New Item' : 'Edit Item'"></h4>
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="control-label col-xs-3">Code:</label>
					<div class="col-xs-9">
						<input type="text" data-bind="value: Code" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Item Name:</label>
					<div class="col-xs-9">
						<input type="text" data-bind="value: Description" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Strength:</label>
					<div class="col-xs-9">
						<input type="text" data-bind="value: Strength" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Unit:</label>
					<div class="col-xs-9">
						<input type="text" data-bind="value: Unit" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Category:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Category, options: $root.categoryList, optionsCaption: 'None'"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Enable OD:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: EnableOD">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Enable HF:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: EnableHF">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Enable VMW:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: EnableVMW">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" data-bind="click: $root.save" style="width:100px">Save</button>
				<button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/StockItem.js')?>