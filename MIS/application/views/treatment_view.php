<style>
	thead { background-color: #9AD8ED; }
	input[type=checkbox] { width: 20px; height: 20px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<button class="btn" data-bind="click: tabClick, css: tab() == 'Treatment' ? 'btn-primary' : 'btn-default'">Treatment</button>
			<button class="btn" data-bind="click: tabClick, css: tab() == 'Treatment by Specie' ? 'btn-primary' : 'btn-default'">Treatment by Specie</button>
		</div>
        <div class="pull-right">
			<button class="btn btn-primary" style="margin-right:30px" data-bind="click: showAdd, visible: tab() == 'Treatment' && app.user.role == 'AU'">Add Treatment</button>
            <a href="/Home" class="btn btn-default">Home</a>
        </div>
	</div>
	<div class="panel-body" data-bind="visible: listModel().length > 0">
        <!-- ko if: tab() == 'Treatment by Specie' -->
        <div class="form-group">
            <select data-bind="value: specie, options: species, optionsValue: 'key', optionsText: 'val', change: changeSpecie" ​​class="form-control" style="width: 150px; height: 33px"></select>
        </div>
        <!-- /ko -->
        
        <!-- ko if: tab() == 'Treatment' -->
        <table class="table table-bordered widthauto">
            <thead>
                <tr>
                    <th width="300">Treatment</th>
                    <th width="300">Description</th>
                    <th width="110" align="center">Health Facility</th>
                    <th width="110" align="center">VMW</th>
                    <th width="100" align="center">Update</th>
                    <th width="100" align="center">Delete</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listModel">
                <tr>
                    <td>
                        <input type="text" class="form-control input-sm" data-bind="value: Treatment" />
                    </td>
                    <td>
                        <input type="text" class="form-control input-sm" data-bind="value: Description" />
                    </td>
                    <td align="center">
                        <input type="checkbox" data-bind="checked: HF" />
                    </td>
                    <td align="center">
                        <input type="checkbox" data-bind="checked: VMW" />
                    </td>
                    <td align="center">
                        <a data-bind="click: $root.updateClick, visible: app.user.role == 'AU'" class="text-middle">Update</a>
                    </td>
                    <td align="center">
                        <a data-bind="click: $root.deleteClick, visible: app.user.role == 'AU'" class="text-danger text-middle">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- /ko -->

        <!-- ko if: tab() == 'Treatment by Specie'-->
        <div style="display:inline-block">
            <table class="table table-bordered widthauto">
                <thead>
                    <tr>
                        <th width="300">Treatment</th>
                        <th width="300">Description</th>
                        <th width="300">Allow</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: listModel">
                    <tr>
                        <td data-bind="text: Treatment"></td>
                        <td data-bind="text: Description"></td>
                        <td>
                            <input type="checkbox" data-bind="checked: Match" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-right" style="margin-top:10px">
                <button class="btn btn-primary btn-sm width100 text-right" data-bind="click: saveTreatmentSpecie">Save</button>
            </div>
        </div>
        <!-- /ko -->
        
	</div>
</div>

<!-- Modal Edit -->
<div id="modalAdd" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Add Treatment</h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: addModel">
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-3">Treatment:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: treatment" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-3">Description:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: description" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-3">Health Facility:</label>
					<div class="col-xs-9">
						<input type="checkbox" data-bind="checked: hf" />
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-3">VMW:</label>
					<div class="col-xs-9">
						<input type="checkbox" data-bind="checked: vmw"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: saveClick" style="width:100px">Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Treatment.js')?>