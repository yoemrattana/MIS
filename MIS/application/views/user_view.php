<style>
	#fixedtop { position:fixed; top:0; left:0; right:0; z-index:2; }
	body.modal-open #fixedtop { right:16px; }

	thead { background-color: #9AD8ED; }
	thead th { text-align: center; }
	tbody td { white-space: nowrap; }
	td.hasCheckbox { padding: 0 !important; }
	td.hasCheckbox input { width:20px; height:20px; margin-top: 5px; }
	#modalEditUser a { user-select: none; }

	#rolePermission { display:flex; align-items:flex-start; justify-content:space-between; }
	#rolePermission table:not(:first-child) { margin-left:30px; }
</style>

<div id="fixedtop" class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<button class="btn minwidth100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">User</button>
			<button class="btn minwidth100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">Role</button>
			<button class="btn minwidth100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">Role Permission</button>
			<button class="btn minwidth100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">Permission Group</button>
			<button class="btn minwidth100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">Permission</button>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>

	<!--User-->
	<div class="panel-heading clearfix" data-bind="visible: menu() == 'User'">
		<div class="pull-left lh34 font16">
			<b>User Management</b>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showCreateUser">New User</button>
		</div>
	</div>

	<!--Role-->
	<div class="panel-heading clearfix" data-bind="visible: menu() == 'Role'">
		<div class="pull-left lh34 font16">
			<b>Role Management</b>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showCreateRole">New Role</button>
		</div>
	</div>

	<!--Role Permission-->
	<div class="panel-heading clearfix" data-bind="visible: menu() == 'Role Permission'">
		<div class="pull-left form-inline">
			<b>Role</b>
			<select data-bind="value: role,
					options: roleList,
					optionsValue: 'Role',
					change: roleChange"
				class="form-control minwidth150"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: saveRole">Save</button>
		</div>
	</div>

	<!--Permission Group-->
	<div class="panel-heading clearfix" data-bind="visible: menu() == 'Permission Group'">
		<div class="pull-left lh34 font16">
			<b>Permission Group Management</b>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showCreatePermissGroup">New Group</button>
		</div>
	</div>

	<!--Permission Panel-->
	<div class="panel-heading clearfix" data-bind="visible: menu() == 'Permission'">
		<div class="pull-left form-inline">
			<b>Group</b>
			<select data-bind="value: permissGroup,
					options: permissGroupList,
					optionsValue: 'GroupID',
                    optionsText: 'GroupName',
					change: refreshPermissList"
				class="form-control minwidth150"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary" data-bind="click: showCreatePermiss">New Permission</button>
		</div>
	</div>

</div>

<div class="panel panel-default" data-bind="visible: true, style: { marginTop: $('#fixedtop').outerHeight() + 'px' }" style="display:none">
	<!--User-->
	<div class="panel-body" data-bind="visible: menu() == 'User'">
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th style="min-width:40px">#</th>
					<th sortable>Username</th>
					<th sortable>Password</th>
					<th sortable>Role</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>HF</th>
					<th sortable>Regional</th>
					<th sortable>Unit</th>
					<th sortable>Province Notification</th>
					<th sortable>OD Notification</th>
					<th sortable>Specie Notification</th>
					<th style="min-width:60px">Edit</th>
					<th style="min-width:60px">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: userList, fixedHeader: true, fixedTop: $('#fixedtop').outerHeight()">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Us"></td>
					<td data-bind="text: Role == 'AU' ? '●●●●●' : Ps"></td>
					<td data-bind="text: Role" width="100"></td>
					<td data-bind="text: isempty($root.getProvName(Code_Prov), 'All')"></td>
					<td data-bind="text: isempty($root.getODName(Code_OD), 'All')"></td>
					<td data-bind="text: isempty($root.getHCName(Code_HC), 'All')"></td>
					<td data-bind="text: $root.getRGName(Code_RG, Role)"></td>
					<td data-bind="text: $root.getUnitName(Code_Unit)"></td>
					<td data-bind="text: (v => v == null ? '' : v.length == 62 ? 'All' : v)($root.getProvName(Code_Prov_Notification))"></td>
					<td data-bind="text: $root.getODName(Code_OD_Notification)"></td>
					<td data-bind="text: Specie_Notification"></td>
					<td class="text-center">
						<a data-bind="click: $root.showEditUser">Edit</a>
					</td>
					<td class="text-center">
						<a class="text-danger" data-bind="click: $root.deleteUser">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<!--Role-->
	<div class="panel-body" data-bind="visible: menu() == 'Role'">
		<div style="display:inline-block">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th width="200">Role Name</th>
						<th width="200">Description</th>
						<th class="no-sort" style="min-width:50px">Edit</th>
						<th class="no-sort" style="min-width:50px">Delete</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: roleList, fixedHeader: true, fixedTop: $('#fixedtop').outerHeight()">
					<tr>
						<td data-bind="text: Role"></td>
						<td data-bind="text: Description"></td>
						<td align="center">
							<a data-bind="click: $parent.showEditRole">Edit</a>
						</td>
						<td align="center">
							<a class="text-danger" href="#" data-bind="click: $parent.deleteRole">Delete</a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>

	<!--Role Permission-->
	<div class="panel-body" data-bind="visible: menu() == 'Role Permission'">
		<div id="rolePermission" data-bind="foreach: ['Malaria','Stock','Report','Configuration']">
			<table class="table table-bordered table-striped widthauto">
				<thead>
					<tr>
						<th width="200" data-bind="text: $data + ' Block'" class="text-nowrap text-left"></th>
						<th width="60">Allow</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: $root.PPChildren().filter(r => r.category == $data), fixedHeader: true, fixedTop: $('#fixedtop').outerHeight()">
					<tr style="color:#3742fa">
						<td data-bind="text: name"></td>
						<td class="text-center">
							<a data-bind="click: $root.selectAll" href="#">All</a>
						</td>
					</tr>
					<!-- ko foreach: children -->
					<tr>
						<td style="padding-left: 20px" data-bind="text: Permission"></td>

						<td class="hasCheckbox text-center">
							<input type="checkbox" data-bind="checked: allow" />
						</td>
					</tr>
					<!-- /ko -->
				</tbody>
			</table>
		</div>
	</div>

	<!--Permission Group-->
	<div class="panel-body" data-bind="visible: menu() == 'Permission Group'">
		<div style="display:inline-block">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th align="center" width="50">#</th>
						<th>Permission Group Name</th>
						<th>Category</th>
						<th width="60">Edit</th>
						<th width="60">Delete</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: permissGroupList, fixedHeader: true, fixedTop: $('#fixedtop').outerHeight()">
					<tr>
						<td data-bind="text: $index() + 1" align="center"></td>
						<td data-bind="text: GroupName"></td>
						<td data-bind="text: Category"></td>
						<td align="center">
							<a data-bind="click: $parent.showEditPermissGroup">Edit</a>
						</td>
						<td align="center">
							<a class="text-danger" data-bind="click: $parent.deletePermissGroup">Delete</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!--Permission Panel-->
	<div class="panel-body" data-bind="visible: menu() == 'Permission'">
		<div style="display:inline-block">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th align="center" width="50">#</th>
						<th>Permission Name</th>
						<th width="60">Edit</th>
						<th width="60">Delete</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: permissionList">
					<tr>
						<td data-bind="text: $index() + 1" align="center"></td>
						<td data-bind="text: Permission"></td>
						<td align="center">
							<a data-bind="click: $parent.showEditPermiss">Edit</a>
						</td>
						<td align="center">
							<a class="text-danger" data-bind="click: $parent.deletePermiss">Delete</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Edit User -->
<div id="modalEditUser" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document" data-bind="with: userEditModel">
			<div class="modal-header">
				<h4 class="modal-title text-primary" data-bind="text: Us() == '' ? 'New User' : 'Edit User'"></h4>
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="control-label col-xs-3">Username:</label>
					<div class="col-xs-9">
						<input type="text" data-bind="value: Us, disable: ID() != ''" class="form-control" maxlength="20" autocomplete="one-time-code" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Password:</label>
					<div class="col-xs-9">
						<input type="text" data-bind="value: Ps, attr: { type: Role() == 'AU' ? 'password' : 'text' }" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Role:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Role, options: $root.roleList, optionsValue: 'Role'"></select>
					</div>
				</div>
				<div class="form-group" data-bind="visible: Role().in('OD','PHD','STOCK OD','RH LAB')">
					<label class="control-label col-xs-3">Province:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_Prov, options: pvList, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group" data-bind="visible: $root.getRolePreSetup(Role()) == 0">
					<label class="control-label col-xs-3">Province:</label>
					<div class="col-xs-9">
						<div style="padding:4px 0">
							<a data-bind="click: () => multiPvList().forEach(r => r.check(true))">Select All</a>
							<a data-bind="click: () => multiPvList().forEach(r => r.check(false))" style="margin-left:20px">Select None</a>
						</div>
						<table data-bind="foreach: multiPvList">
							<tr>
								<td class="hasCheckbox">
									<input type="checkbox" data-bind="checked: check" />
								</td>
								<td style="padding-left:10px">
									<span data-bind="text: name, click: () => check(!check())" style="cursor:pointer"></span>
								</td>
							</tr>
						</table>
						<div id="selectProvince" style="color:#a94442; display:none">
							Please select province at least one.
						</div>
					</div>
				</div>
				<div class="form-group" data-bind="visible: Role().in('OD','STOCK OD','RH LAB')">
					<label class="control-label col-xs-3">OD:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_OD, options: odList, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group" data-bind="visible: Role().in('RH LAB')">
					<label class="control-label col-xs-3">HF:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_HC, options: hcList, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group" data-bind="visible: Role() == 'ML'">
					<label class="control-label col-xs-3">Regional:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_RG, options: $root.rgList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
					</div>
				</div>
				<div class="form-group" data-bind="visible: Role() == 'ML'">
					<label class="control-label col-xs-3">Unit:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: Code_Unit, options: unitList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
					</div>
				</div>

				<div class="form-group" data-bind="visible: Role().in('AU', 'DIRECTOR', 'VICE DIRECTOR', 'M&E CNM', 'VMW', 'HEAD VMW')">
					<label class="control-label col-xs-3 text-danger">Province Notification: </label>
					<div class="col-xs-9">
						<div style="padding:4px 0">
							<a data-bind="click: () => notificationPvList().forEach(r => r.check(true))">Select All</a>
							<a data-bind="click: () => notificationPvList().forEach(r => r.check(false))" style="margin-left:20px">Select None</a>
						</div>
						<table data-bind="foreach: notificationPvList">
							<tr>
								<td class="hasCheckbox">
									<input type="checkbox" data-bind="checked: check" />
								</td>
								<td style="padding-left:10px">
									<span data-bind="text: name, click: () => check(!check())" style="cursor:pointer"></span>
								</td>
							</tr>
						</table>
						<div id="selectProvince" style="color:#a94442; display:none">
							Please select province at least one.
						</div>
					</div>
				</div>

				<div class="form-group" data-bind="visible: Role() != 'RH LAB'">
					<label class="control-label col-xs-3 text-danger">Specie Notification:</label>
					<div class="col-xs-9">
						<div style="padding:4px 0">
							<a data-bind="click: () => specieList().forEach(r => r.check(true))">Select All</a>
							<a data-bind="click: () => specieList().forEach(r => r.check(false))" style="margin-left:20px">Select None</a>
						</div>
						<table data-bind="foreach: specieList">
							<tr>
								<td class="hasCheckbox">
									<input type="checkbox" data-bind="checked: check" />
								</td>
								<td style="padding-left:10px">
									<span data-bind="text: name, click: () => check(!check())" style="cursor:pointer"></span>
								</td>
							</tr>
						</table>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" data-bind="click: $root.editUser" style="width:100px">Save</button>
				<button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>


<!-- Modal New Role -->
<div id="modalNewRole" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" role="document" data-bind="with: roleNewModel">
            <div class="modal-header">
                <h4 class="modal-title text-primary" >New Role</h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label class="control-label col-xs-3">Role:</label>
                    <div class="col-xs-9">
                        <input type="text" data-bind="value:Role" class="form-control ucase" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">Description:</label>
                    <div class="col-xs-9">
                        <input type="text" data-bind="value:Description" class="form-control" />
                    </div>
                </div>
                            
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bind="click: $root.newRole" style="width:100px">Save</button>
                <button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Role -->
<div id="modalEditRole" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" role="document" data-bind="with: roleEditModel">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Edit Role</h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label class="control-label col-xs-3">Role:</label>
                    <div class="col-xs-9">
                        <input type="text" data-bind="value:Role" class="form-control ucase" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">Description:</label>
                    <div class="col-xs-9">
                        <input type="text" data-bind="value:Description" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bind="click: $root.editRole" style="width:100px">Save</button>
                <button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Permission Goup -->
<div id="modalEditPermissGroup" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" role="document" data-bind="with: permissGroupEditModel">
            <div class="modal-header">
				<h4 class="modal-title text-primary" data-bind="text: (GroupID() == 0 ? 'New' : 'Edit') + ' Permission Group'"></h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label class="control-label col-xs-3">Group Name:</label>
                    <div class="col-xs-9">
                        <input type="text" data-bind="value: GroupName" class="form-control" />
                    </div>
                </div>
				<div class="form-group">
					<label class="control-label col-xs-3">Category:</label>
					<div class="col-xs-9">
						<select type="text" data-bind="value: Category" class="form-control">
							<option>Malaria</option>
							<option>Stock</option>
							<option>Report</option>
							<option>Configuration</option>
						</select>
					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bind="click: $root.editPermissGroup" style="width:100px">Save</button>
                <button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Permission -->
<div id="modalEditPermission" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" role="document" data-bind="with: permissEditModel">
            <div class="modal-header">
				<h4 class="modal-title text-primary" data-bind="text: (PermissionID() == 0 ? 'New' : 'Edit') + ' Permission'"></h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label class="control-label col-xs-3">Permission:</label>
                    <div class="col-xs-9">
                        <input type="text" data-bind="value: Permission" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bind="click: $root.editPermiss" style="width:100px">Save</button>
                <button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?=latestJs('/media/ViewModel/User.js')?>