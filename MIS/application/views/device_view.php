<style>
	.table thead { background-color:#9AD8ED; }
	.table thead th { text-align:center; }
	#panelmap, #panelCMIMap { position:absolute; left:10px; right:10px; top:112px; bottom:40px; padding:5px; }
	#map, #cmiMap { height:100%; }
	.hasCheckbox { padding:0 !important; text-align:center; vertical-align:middle !important; line-height:10px !important; }
	.hasCheckbox input { width:20px; height:20px; }
	.gm-style-iw button { display:none !important; }
	.checkbox-inline input { width:20px; height:20px; margin-top:0; margin-left:-24px !important; }
	.mapInfo { background-color:white; width:auto; padding:5px; position:fixed; bottom:50px; left:20px; border:1px solid #ddd; }
	.menuwidth { width:110px; padding-left:0; padding-right:0; }
	body { overflow-y:scroll; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none; min-width:1300px">
	<div class="panel-heading clearfix">
		<div class="pull-left" data-bind="style: { position: app.isMobile ? '' : 'sticky', left: app.isMobile ? '' : '21px' }">
			<button class="btn menuwidth" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default', visible: checkPermission($element)">HF Request</button>
			<button class="btn menuwidth" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default', visible: checkPermission($element)">VMW Request</button>
			<button class="btn menuwidth" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default', visible: checkPermission($element)">HF List</button>
			<button class="btn menuwidth" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default', visible: checkPermission($element)">VMW List</button>
			<button class="btn menuwidth" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default', visible: checkPermission($element)">CMI</button>
			<button class="btn menuwidth" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default', visible: checkPermission($element)">Map</button>
			<button class="btn menuwidth" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default', visible: checkPermission($element)">App Upload</button>
			<button class="btn menuwidth" data-bind="click: menuClick, css: menuSelected($element) ? 'btn-info' : 'btn-default', visible: checkPermission($element)">Inventory</button>
		</div>
		<div class="pull-right" data-bind="style: { position: app.isMobile ? '' : 'sticky', right: app.isMobile ? '' : '21px' }">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>

	<div class="panel-heading clearfix" data-bind="visible: menu().in('HF List', 'VMW List', 'Map', 'Inventory')">
		<div class="pull-left form-inline relative" data-bind="style: { position: app.isMobile ? '' : 'sticky', left: app.isMobile ? '' : '21px' }">
			<span><b>Province</b></span>
			<select data-bind="value: prov,
					options: provList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: provList().length == 1 ? undefined : 'All Province'" class="form-control input-sm width150"></select>

			<span style="margin-left:15px"><b>OD</b></span>
			<select data-bind="value: od,
					options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: odList().length == 1 ? undefined : 'All OD'" class="form-control input-sm width150"></select>
		
			<!-- ko if: menu().in('VMW List', 'Map', 'Inventory') -->
			<span style="margin-left:15px"><b>HC</b></span>
			<select data-bind="value: hc,
					options: hcList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All HC'" class="form-control input-sm width150"></select>
			<!-- /ko -->

			<!-- ko if: menu().in('Map', 'Inventory') -->
			<span style="margin-left:15px"><b>Type</b></span>
			<select class="form-control input-sm" data-bind="value: type">
				<!-- ko if: menu() == 'Map' -->
				<option value="all">All Type</option>
				<!-- /ko -->
				<option value="hf">Health Facility</option>
				<option value="vmw">VMW</option>
				<!-- ko if: menu() == 'Inventory' -->
				<option value="od">OD</option>
				<!-- /ko -->
			</select>
			<!-- /ko -->

			<!-- ko if: menu().in('HF List', 'VMW List') -->
			<span style="margin-left:15px"><b>Model</b></span>
			<select class="form-control input-sm" data-bind="value: deviceModel">
				<!-- ko if: menu() == 'HF List'-->
				<option>All Model</option>
				<option>samsung SM-P615</option>
				<option>samsung SM-T505</option>
				<option>Other</option>
				<!-- /ko -->

				<!-- ko if: menu() == 'VMW List'-->
				<option>All Model</option>
				<option>samsung SM-A315G</option>
				<option>Other</option>
				<!-- /ko -->
			</select>

			<label class="checkbox-inline" style="margin-left:20px">
				<input type="checkbox" data-bind="checked: newPhone">
				<span>New Phone</span>
			</label>
			<!-- /ko -->

			<!-- ko if: menu() == 'Map' -->
			<label class="checkbox-inline" style="margin-left:20px">
				<input type="checkbox" data-bind="checked: far">
				<span>Far from</span>
			</label>
			<div class="input-group input-group-sm">
				<input type="number" class="form-control" style="width:55px" min="1" data-bind="textInput: farKm" />
				<span class="input-group-addon">km</span>
			</div>
			<!-- /ko -->

			<!-- ko if: menu() == 'Inventory' -->
			<span style="margin-left:15px"><b>From</b></span>
			<input type="text" class="form-control input-sm width100 text-center" data-bind="datePicker: from, showClear: true" />
			<span><b>To</b></span>
			<input type="text" class="form-control input-sm width100 text-center" data-bind="datePicker: to, showClear: true" />
			<!-- /ko -->
			
		</div>
		
		<div class="pull-right">
			<!-- ko if: menu() == 'Inventory' -->
			<button class="btn btn-primary btn-sm" data-bind="click: showNewOD, visible: type() == 'od'">New OD Device</button>
			<button class="btn btn-success btn-sm" data-bind="click: exportExcel">Export Excel</button>
			<!-- /ko -->
		</div>
	</div>

	<div data-bind="visible: menu()== 'CMI'">
		<div class="panel-heading clearfix">
			<button data-bind="click: () => submenu('cmi-list')" class="btn btn-primary">List</button>
			<button data-bind="click: () => submenu('cmi-map')" class="btn btn-primary">Map</button>
		</div>
		<hr  style="margin: 0; padding:0"/>

		<div class="panel-heading clearfix" data-bind="visible: submenu() == 'cmi-list'" style="display:none">
			<div style="display:inline-block">
				<div class="text-bold">Year</div>
				<select data-bind="value: year, options: yearList" class="form-control input-sm width70"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Month</div>
				<select data-bind="value: month, options: monthList, optionsCaption: 'All'" class="form-control input-sm width70"></select>
			</div>

			<div style="display:inline-block">
				&nbsp; &nbsp; &nbsp;
				Android : <span data-bind="text: android"></span>

				&nbsp; &nbsp; &nbsp;
				IOS : <span data-bind="text: ios"></span>

				<span data-bind="with: cmiTotal">
					&nbsp; &nbsp; &nbsp;
					All Logedin Users : <span data-bind="text: HasUserName"></span> <sup style="color:red"> *</sup>

					&nbsp; &nbsp; &nbsp;
					All Guest : <span data-bind="text: Guest"></span> <sup style="color:red"> *</sup>

					&nbsp; &nbsp; &nbsp;
					(<span style="color:red"> * </span> total all users of CMI App from first released date till now)
				</span>
			</div>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: menu() == 'HF Request'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40">#</th>
					<th width="120">Date</th>
					<th>Province</th>
					<th>OD</th>
					<th>HF Code</th>
					<th>HF English</th>
					<th>HF Khmer</th>
					<th>IMEI</th>
					<th>App Version</th>
					<th width="60" data-bind="visible: checkPermission('Edit')">Accept</th>
					<th width="60" data-bind="visible: checkPermission('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: hfRequestList">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: moment(CreatedOn).format('ll')" class="text-center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Code_Facility_T"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Facility_K" class="kh"></td>
					<td data-bind="text: Imei"></td>
					<td data-bind="text: isnull(MalariaAppVersion, QAAppVersion)"></td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Edit')">
						<a data-bind="click: $root.hfAcceptClick">Accept</a>
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Delete')">
						<a data-bind="click: $root.hfDeleteClick" class="text-danger">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: menu() == 'VMW Request'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40">#</th>
					<th width="120">Date</th>
					<th>Province</th>
					<th>OD</th>
					<th>HC</th>
					<th>Village Code</th>
					<th>Village English</th>
					<th>Village Khmer</th>
					<th>IMEI</th>
					<th>App Version</th>
					<th width="60" data-bind="visible: checkPermission('Edit')">Accept</th>
					<th width="60" data-bind="visible: checkPermission('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: vmwRequestList">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: moment(CreatedOn).format('ll')" class="text-center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Code_Vill_T"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: Name_Vill_K" class="kh"></td>
					<td data-bind="text: Imei"></td>
					<td data-bind="text: MalariaAppVersion"></td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Edit')">
						<a data-bind="click: $root.vmwAcceptClick">Accept</a>
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Delete')">
						<a data-bind="click: $root.vmwDeleteClick" class="text-danger">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: menu() == 'HF List'">
		<table class="table table-bordered table-striped table-hover text-nowrap" style="min-width:2000px">
			<thead>
				<tr>
					<th>#</th>
					<th sortable>OD</th>
					<th sortable>HF<br>Code</th>
					<th sortable>HF Name</th>
					<th sortable>Phone</th>
					<th sortable>New Phone</th>
					<th sortable>IMEI</th>
					<th sortable>Model</th>
					<th sortable>App<br>Version</th>
					<th>CNM<br>Usage</th>
					<th>Other<br>Usage</th>
					<th>Usage From</th>
					<th>Usage To</th>
					<th>Last<br>Online</th>
					<!-- ko if: $root.checkPermission('Edit') -->
					<th>Enable<br>App</th>
					<th title="Tick to allow previous month entry">Expired<br>Entry</th>
					<th title="Tick to allow previous month entry">Expired<br>Stock</th>
					<th>Phone No<br>From App</th>
					<th>Edit</th>
					<!-- /ko -->
					<th data-bind="visible: $root.checkPermission('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: hfDeviceList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_OD_K" class="kh"></td>
					<td data-bind="text: Code_Facility_T"></td>
					<td data-bind="text: Name_Facility_K" class="kh"></td>
					<td data-bind="text: Phone"></td>
					<td><a data-bind="text: NewPhone, click: $root.newPhoneClick" class="text-danger"></a></td>
					<td data-bind="text: Imei"></td>
					<td data-bind="html: Model2" class="text-nowrap"></td>
					<td data-bind="text: isnull(MalariaAppVersion, QAAppVersion)" class="text-center"></td>
					<td data-bind="text: MalariaAppUsage" class="text-center"></td>
					<td data-bind="text: OtherAppUsage" class="text-center"></td>
					<td data-bind="text: isnot(DateFrom, null, r => moment(r).format('ll'))" class="text-center text-nowrap"></td>
					<td data-bind="text: isnot(DateTo, null, r => moment(r).format('ll'))" class="text-center text-nowrap"></td>
					<td data-bind="text: moment(UpdatedOn).format('ll')" class="text-center text-nowrap"></td>
					<!-- ko if: $root.checkPermission('Edit') -->
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Active() == 1, change: $root.hfChangeActive" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: ExpireEntry() == 1, change: $root.hfChangeExpireEntry" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: ExpireStock() == 1, change: $root.hfChangeExpireStock" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: AutoPhone() == 1, change: $root.hfChangeAutoPhone" />
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Edit')">
						<a data-bind="click: $root.hfEditClick">Edit</a>
					</td>
					<!-- /ko -->
					<td class="text-center" data-bind="visible: $root.checkPermission('Delete')">
						<a data-bind="click: $root.hfDeleteClick" class="text-danger">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: menu() == 'VMW List'">
		<table class="table table-bordered table-striped table-hover text-nowrap" style="min-width:2000px">
			<thead>
				<tr>
					<th>#</th>
					<th sortable>OD</th>
					<th sortable>HC</th>
					<th sortable>VMW Code</th>
					<th sortable>VMW Name</th>
					<th sortable>Phone</th>
					<th sortable>New Phone</th>
					<th sortable>IMEI</th>
					<th sortable>Model</th>
					<th sortable>App<br>Version</th>
					<th>CNM<br>Usage</th>
					<th>Other<br>Usage</th>
					<th>Usage From</th>
					<th>Usage To</th>
					<th>Last<br>Online</th>
					<!-- ko if: $root.checkPermission('Edit') -->
					<th>Enable<br>App</th>
					<th title="Tick to allow previous month entry">Expired<br>Entry</th>
					<th>Phone No<br>From App</th>
					<th data-bind="visible: $root.checkPermission('Edit')">Edit</th>
					<!-- /ko -->
					<th data-bind="visible: $root.checkPermission('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: vmwDeviceList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_OD_K" class="kh"></td>
					<td data-bind="text: Name_Facility_K" class="kh"></td>
					<td data-bind="text: Code_Vill_T"></td>
					<td data-bind="text: Name_Vill_K" class="kh"></td>
					<td data-bind="text: Phone"></td>
					<td><a data-bind="text: NewPhone, click: $root.newPhoneClick" class="text-danger"></a></td>
					<td data-bind="text: Imei"></td>
					<td data-bind="html: Model2"></td>
					<td data-bind="text: MalariaAppVersion" class="text-center"></td>
					<td data-bind="text: MalariaAppUsage" class="text-center"></td>
					<td data-bind="text: OtherAppUsage" class="text-center"></td>
					<td data-bind="text: isnot(DateFrom, null, r => moment(r).format('ll'))" class="text-center text-nowrap"></td>
					<td data-bind="text: isnot(DateTo, null, r => moment(r).format('ll'))" class="text-center text-nowrap"></td>
					<td data-bind="text: moment(UpdatedOn).format('ll')" class="text-center text-nowrap"></td>
					<!-- ko if: $root.checkPermission('Edit') -->
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Active() == 1, change: $root.vmwChangeActive" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: ExpireEntry() == 1, change: $root.vmwChangeExpireEntry" />
					</td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: AutoPhone() == 1, change: $root.vmwChangeAutoPhone" />
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Edit')">
						<a data-bind="click: $root.vmwEditClick">Edit</a>
					</td>
					<!-- /ko -->
					<td class="text-center" data-bind="visible: $root.checkPermission('Delete')">
						<a data-bind="click: $root.vmwDeleteClick" class="text-danger">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: menu() == 'CMI' && submenu() == 'cmi-list'" style="display:none">
		<table class="table table-bordered table-striped table-hover text-nowrap" style="min-width:2000px">
			<thead>
				<tr>
					<th>#</th>
					<th sortable>Username</th>
					<th sortable> Role</th>
					<th sortable> Province</th>
					<th sortable> OD</th>
					<th sortable>Phone Model</th>
					<th sortable>OS</th>
					<th sortable>App Version</th>
					<th sortable>Login with acc</th>
					<th sortable>IMEI</th>
					<th sortable>Lat</th>
					<th sortable>Long</th>
					<th sortable>City</th>
					<th sortable>Start Date</th>
					<th sortable>Last online</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: cmiDeviceList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: UserName, style: { color: UserName == 'Guest' ? 'red' : 'black'}"></td>
					<td data-bind="text: Role"></td>
					<td data-bind="text: Province"></td>
					<td data-bind="text: OD"></td>
					<td data-bind="text: PhoneModel"></td>
					<td data-bind="text: OS"></td>
					<td data-bind="text: AppVersion"></td>
					<td data-bind="text: HasUserAccount"></td>
					<td data-bind="text: Imei"></td>
					<td data-bind="text: Lat"></td>
					<td data-bind="text: Long"></td>
					<td data-bind="text: City" class="text-center"></td>
					<td data-bind="text: StartDate" class="text-center"></td>
					<td data-bind="text: LastOnline" class="text-center"></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="panelCMIMap" class="panel panel-default" data-bind="visible: menu() == 'CMI' && submenu() == 'cmi-map'" style="display:none" >
		<div id="cmiMap"></div>

		<div class="mapInfo">
			<div>
				<img src="/media/images/marker-red.png" />
				<span>Logged in users</span>
			</div>
			<div>
				<img src="/media/images/marker-blue.png" />
				<span>Guests</span>
			</div>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: menu() == 'App Upload'">
		<div class="form-group">
			<button class="btn btn-primary" data-bind="click: selectFile">Select File to Upload</button>
		</div>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th width="500">File Name</th>
					<th width="150">Version</th>
					<th width="150">Status</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody data-bind="with: appModel">
				<tr>
					<td align="center">1</td>
					<td align="center" data-bind="text: name"></td>
					<td align="center" data-bind="text: version"></td>
					<td align="center">
						<span data-bind="text: status"></span>
						<img data-bind="visible: status() == 'Uploading'" src="/media/images/ajax-loader.gif" height="18" style="margin-left:5px" />
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: menu() == 'Inventory'">
		<table class="table table-bordered table-striped table-hover" data-bind="style: { visibility: type() == 'hf' ? 'visible' : 'collapse' }">
			<thead>
				<tr>
					<th width="40">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>HF</th>
					<th sortable>IMEI</th>
					<th sortable>Model</th>
					<th sortable>Phone</th>
					<th>Registered On</th>
					<th sortable>Status</th>
					<th width="500">Note</th>
					<th width="60" data-bind="visible: $root.checkPermission('Edit')">Save</th>
					<th width="60" data-bind="visible: $root.checkPermission('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: hfLogList, fixedHeader: true">
				<tr data-bind="click: app.selectTr, css: Status == 'Deleted' ? 'text-danger' : ''">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Imei"></td>
					<td data-bind="text: Model"></td>
					<td data-bind="text: Phone"></td>
					<td data-bind="text: moment(CreatedOn).format('ll')"></td>
					<td data-bind="text: Status"></td>
					<td class="no-padding-vertical text-middle">
						<input type="text" class="form-control input-sm" data-bind="value: Note" style="width:100%" />
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Edit')">
						<a data-bind="click: $root.logSaveClick">Save</a>
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Delete')">
						<a data-bind="click: $root.logDeleteClick" class="text-danger">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<table class="table table-bordered table-striped table-hover" data-bind="style: { visibility: type() == 'vmw' ? 'visible' : 'collapse' }">
			<thead>
				<tr>
					<th width="40">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>HF</th>
					<th sortable>VMW</th>
					<th sortable>IMEI</th>
					<th sortable>Model</th>
					<th sortable>Phone</th>
					<th>Registered On</th>
					<th sortable>Status</th>
					<th width="500">Note</th>
					<th width="60" data-bind="visible: $root.checkPermission('Edit')">Save</th>
					<th width="60" data-bind="visible: $root.checkPermission('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: vmwLogList, fixedHeader: true">
				<tr data-bind="click: app.selectTr, css: Status == 'Deleted' ? 'text-danger' : ''">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: Imei"></td>
					<td data-bind="text: Model"></td>
					<td data-bind="text: Phone"></td>
					<td data-bind="text: moment(CreatedOn).format('ll')"></td>
					<td data-bind="text: Status"></td>
					<td class="no-padding-vertical text-middle">
						<input type="text" class="form-control input-sm" data-bind="value: Note" style="width:100%" />
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Edit')">
						<a data-bind="click: $root.logSaveClick">Save</a>
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Delete')">
						<a data-bind="click: $root.logDeleteClick" class="text-danger">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<table class="table table-bordered table-striped table-hover" data-bind="style: { visibility: type() == 'od' ? 'visible' : 'collapse' }">
			<thead>
				<tr>
					<th width="40">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>IMEI</th>
					<th sortable>Model</th>
					<th sortable>Phone</th>
					<th>Registered On</th>
					<th sortable>Status</th>
					<th width="500">Note</th>
					<th width="60" data-bind="visible: $root.checkPermission('Edit')">Save</th>
					<th width="60" data-bind="visible: $root.checkPermission('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: odLogList, fixedHeader: true">
				<tr data-bind="click: app.selectTr, css: Status == 'Deleted' ? 'text-danger' : ''">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Imei"></td>
					<td data-bind="text: Model"></td>
					<td data-bind="text: Phone"></td>
					<td data-bind="text: moment(CreatedOn).format('ll')"></td>
					<td data-bind="text: Status"></td>
					<td class="no-padding-vertical text-middle">
						<input type="text" class="form-control input-sm" data-bind="value: Note" style="width:100%" />
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Edit')">
						<a data-bind="click: $root.logSaveClick">Save</a>
					</td>
					<td class="text-center" data-bind="visible: $root.checkPermission('Delete')">
						<a data-bind="click: $root.logDeleteClick" class="text-danger">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>

</div>

<div id="panelmap" class="panel panel-default" data-bind="visible: menu() == 'Map'" style="display:none">
	<div id="map"></div>

	<div class="mapInfo">
		<div>
			<img src="/media/images/marker-hc.png" />
			<span>Health Facility</span>
		</div>
		<div>
			<img src="/media/images/marker-vmw.png" />
			<span>VMW</span>
		</div>
		<div class="form-group">
			<img src="/media/images/marker-red3.png" style="margin-left:4px" />
			<span style="margin-left:4px">HF Device</span>
		</div>
		<div>
			<img src="/media/images/marker-blue3.png" style="margin-left:4px" />
			<span style="margin-left:4px">VMW Device</span>
		</div>
	</div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Edit Information</h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group">
					<label class="control-label col-xs-3" data-bind="text: Type + ' Name:'"></label>
					<div class="col-xs-9">
						<p class="form-control-static kh" data-bind="text: Name"></p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Phone:</label>
					<div class="col-xs-9">
						<input type="text" data-bind="value: Phone" class="form-control" />
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<label class="control-label col-xs-3">Model:</label>
					<div class="col-xs-9">
						<input type="text" data-bind="value: Model" class="form-control" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: saveEdit" style="width:100px">Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal New Phone -->
<div class="modal" id="modalNewPhone" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">New Phone Number</h3>
			</div>
			<div class="modal-body">
				<h4>Do you want to accept or reject?</h4>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" style="width:100px">Accept</button>
				<button class="btn btn-danger btn-sm" style="width:100px">Reject</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal New OD -->
<div class="modal" id="modalNewOD" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">New OD Device</h3>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: newODModel">
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-3">Province</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: pv, options: pvlist, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-3">OD</label>
					<div class="col-xs-9">
						<select class="form-control" data-bind="value: od, options: odlist, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-3">IMEI</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: imei" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-3">Model</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: model" />
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-3">Phone Number</label>
					<div class="col-xs-9">
						<input type="text" class="form-control" data-bind="value: phone" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" style="width:100px" data-bind="click: saveNewOD">Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<input type="file" id="file" class="hide" data-bind="change: () => fileChanged($element.files)" accept="application/vnd.android.package-archive" />

<?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCVXxd9fjjh1c2wrsRlZfyHfEkBiI4XQ8Q"></script>
<script src="/media/JavaScript/maplabel.js"></script>
<?=latestJs('/media/ViewModel/Device.js')?>