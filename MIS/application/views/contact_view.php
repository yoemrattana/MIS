<style>
	.table thead { background-color: #9AD8ED; }
	.table thead th { text-align: center; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left" style="position:sticky; left:21px">
			<button class="btn width100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">CNM</button>
			<button class="btn width100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">Partner</button>
			<button class="btn width100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">PHD</button>
			<button class="btn width100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">OD</button>
			<button class="btn width100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">HC</button>
			<button class="btn width100" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default'">VMW</button>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<a href="/Home"><img src="/media/images/home_back.png" style="margin-top:3px" /></a>
		</div>
	</div>
	<div class="panel-heading clearfix" data-bind="visible: menu() != '' && (menu().in('Partner','OD','HC','VMW') || app.user.permiss['Contact'].contain('Edit'))">
		<div class="pull-left form-inline relative" style="position:sticky; left:21px">
			<!-- ko if: menu() == 'Partner' -->
			<span>
				<b>Partner</b>
			</span>
			<select data-bind="value: pn,
					options: pnList,
					optionsCaption: 'All'"
				class="form-control input-sm minwidth150"></select>
			<!-- /ko -->

			<!-- ko if: menu().in('PHD','OD','HC','VMW') -->
			<span>
				<b>Province</b>
			</span>
			<select data-bind="value: pv,
					options: pvList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All'"
				class="form-control input-sm minwidth150"></select>
			<!-- /ko -->

			<!-- ko if: menu().in('HC','VMW') -->
			<span style="margin-left:15px">
				<b>OD</b>
			</span>
			<select data-bind="value: od,
					options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All'"
				class="form-control input-sm minwidth150"></select>
			<!-- /ko -->

			<!-- ko if: menu() == 'VMW' -->
			<span style="margin-left:15px">
				<b>HC</b>
			</span>
			<select data-bind="value: hc,
					options: hcList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All'"
				class="form-control input-sm minwidth150"></select>
			<!-- /ko -->
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm" data-bind="click: showNew, visible: app.user.permiss['Contact'].contain('Edit')">New Contact</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: menu() != ''">
		<!-- ko if: menu() == 'CNM' -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="50">#</th>
					<th sortable>Title</th>
					<th sortable>Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th sortable>Position</th>
					<th sortable>Unit</th>
					<th>Edited User</th>
					<th>Edited Date</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listCNM, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Name.split('.')[0] + '.'"></td>
					<td data-bind="text: Name.split('.').last(), css: { kh: iskhmer(Name) }"></td>
					<td data-bind="text: Phone"></td>
					<td data-bind="text: Email"></td>
					<td data-bind="text: Position"></td>
					<td data-bind="text: $root.getUnitName(Unit)"></td>
					<td data-bind="text: ModiUser" align="center"></td>
					<td data-bind="text: moment(ModiTime).format('lll')" align="center"></td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">
						<a data-bind="click: $root.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- /ko -->

		<!-- ko if: menu() == 'Partner' -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="50">#</th>
					<th sortable>Partner</th>
					<th sortable>Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Position</th>
					<th>Edited User</th>
					<th>Edited Date</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listPartner, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Partner" align="center"></td>
					<td data-bind="text: Name, css: { kh: iskhmer(Name) }"></td>
					<td data-bind="text: Phone"></td>
					<td data-bind="text: Email"></td>
					<td data-bind="text: Position"></td>
					<td data-bind="text: ModiUser" align="center"></td>
					<td data-bind="text: moment(ModiTime).format('lll')" align="center"></td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">
						<a data-bind="click: $root.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- /ko -->

		<!-- ko if: menu() == 'PHD' -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="50">#</th>
					<th sortable>Province</th>
					<th sortable>Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th sortable>Position</th>
					<th>Edited User</th>
					<th>Edited Date</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listPHD, fixedHeader: [1,5], sortModel: dataPHD">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getPVName(pv)" class="kh"></td>
					<td data-bind="text: Name, css: { kh: iskhmer(Name) }"></td>
					<td data-bind="text: Phone"></td>
					<td data-bind="text: Email"></td>
					<td data-bind="text: Position"></td>
					<td data-bind="text: ModiUser" align="center"></td>
					<td data-bind="text: moment(ModiTime).format('lll')" align="center"></td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">
						<a data-bind="click: $root.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- /ko -->

		<!-- ko if: menu() == 'OD' -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="50">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th sortable>Position</th>
					<th>Edited User</th>
					<th>Edited Date</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listOD, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getPVName(pv)" class="kh"></td>
					<td data-bind="text: $root.getODName(od)" class="kh"></td>
					<td data-bind="text: Name, css: { kh: iskhmer(Name) }"></td>
					<td data-bind="text: Phone"></td>
					<td data-bind="text: Email"></td>
					<td data-bind="text: Position"></td>
					<td data-bind="text: ModiUser" align="center"></td>
					<td data-bind="text: moment(ModiTime).format('lll')" align="center"></td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">
						<a data-bind="click: $root.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- /ko -->

		<!-- ko if: menu() == 'HC' -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="50">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>HC</th>
					<th sortable>Name</th>
					<th>Phone</th>
					<th>Edited User</th>
					<th>Edited Date</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listHC, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getPVName(pv)" class="kh"></td>
					<td data-bind="text: $root.getODName(od)" class="kh"></td>
					<td data-bind="text: $root.getHCName(hc)" class="kh"></td>
					<td data-bind="text: Name, css: { kh: iskhmer(Name) }"></td>
					<td data-bind="text: Phone" align="center"></td>
					<td data-bind="text: ModiUser" align="center"></td>
					<td data-bind="text: moment(ModiTime).format('lll')" align="center"></td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">
						<a data-bind="click: $root.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- /ko -->

		<!-- ko if: menu() == 'VMW' -->
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="50">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>HC</th>
					<th sortable>Village</th>
					<th>Name</th>
					<th>Phone</th>
					<th>Edited User</th>
					<th>Edited Date</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">Edit</th>
					<th width="60" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listVMW, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getPVName(pv)" class="kh"></td>
					<td data-bind="text: $root.getODName(od)" class="kh"></td>
					<td data-bind="text: $root.getHCName(hc)" class="kh"></td>
					<td data-bind="text: $root.getVLName(vl)" class="kh"></td>
					<td data-bind="text: Name, css: { kh: iskhmer(Name) }"></td>
					<td data-bind="text: Phone" align="center"></td>
					<td data-bind="text: ModiUser" align="center"></td>
					<td data-bind="text: moment(ModiTime).format('lll')" align="center"></td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Edit')">
						<a data-bind="click: $root.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Contact'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- /ko -->
	</div>
</div>


<!-- Modal Edit -->
<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header" data-bind="with: editModel">
				<h4 class="modal-title text-primary" data-bind="text: (Rec_ID() == 0 ? 'New Contact' : 'Edit Contact') + ' - ' + $root.menu()"></h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group" data-bind="visible: $root.menu() == 'Partner'">
					<label class="control-label col-xs-3">Partner:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: Partner" />
					</div>
				</div>
				<div class="form-group" data-bind="visible: $root.menu().in('PHD','OD','HC','VMW')">
					<label class="control-label col-xs-3">Province:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group" data-bind="visible: $root.menu().in('OD','HC','VMW')">
					<label class="control-label col-xs-3">OD:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group" data-bind="visible: $root.menu().in('HC','VMW')">
					<label class="control-label col-xs-3">HC:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group" data-bind="visible: $root.menu() == 'VMW'">
					<label class="control-label col-xs-3">Village:</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Name:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: Name" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Phone:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: Phone" />
					</div>
				</div>
				<div class="form-group" data-bind="visible: $root.menu().in('CNM','Partner','PHD','OD')">
					<label class="control-label col-xs-3">Email:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: Email" />
					</div>
				</div>
				<div class="form-group" data-bind="visible: $root.menu().in('CNM','Partner','PHD','OD')">
					<label class="control-label col-xs-3">Position:</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: Position" />
					</div>
				</div>
				<div class="form-group" data-bind="visible: $root.menu().in('CNM')">
					<label class="control-label col-xs-3">Unit:</label>
					<div class="col-xs-9">
						<select data-bind="value: Unit,
							options: unitList,
							optionsValue: 'unit',
							optionsText: 'Name',
							optionsCaption: 'Select Unit'"
							class="form-control input-sm minwidth150"></select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: save" style="width:100px">Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Contact.js')?>