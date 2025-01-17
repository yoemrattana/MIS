<style>
	.table-hover thead { background-color: #9AD8ED; }
	.btnmenu { min-width:100px; margin-bottom:5px; }
	.space { margin-left:10px; }
	.width50 { width:50px !important; }
	.width70 { width:70px !important; }
	.bg-gray { background-color:#b9b9b9; }
	.divcenter { display:table; margin:auto; }
	hr { margin:10px 0; }
	label { font-weight:normal; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'" style="padding-bottom:5px">
		<div class="pull-left" style="width:calc(100% - 80px)">
			<a data-bind="visible: app.user.permiss['Checklist'].contain('Epi')" name="Epi" href="/Checklist/index/epi" class="btn btn-default btnmenu">Epi</a>

			<a data-bind="visible: app.user.permiss['Checklist'].contain('Education')" name="Edu HC" href="/Checklist/index/edu_hc" class="btn btn-default btnmenu space" title="Health Education HC" data-placement="bottom">HE HC</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('Education')" name="Edu VMW" href="/Checklist/index/edu_vmw" class="btn btn-default btnmenu" title="Health Education VMW" data-placement="bottom">HE VMW</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('Education')" name="Edu CSO" href="/Checklist/index/edu_cso" class="btn btn-default btnmenu" title="Health Education CSO" data-placement="bottom">HE CSO</a>

			<a data-bind="visible: app.user.permiss['Checklist'].contain('Labo')" name="Labo" href="/Checklist/index/labo" class="btn btn-default btnmenu space">Labo</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('Procurement')" name="Procurement" href="/Checklist/index/procurement" class="btn btn-default btnmenu">Procurement</a>

			<a data-bind="visible: app.user.permiss['Checklist'].contain('M&E') && app.user.prov == ''" name="OD" href="/Checklist/index/mneod" class="btn btn-default btnmenu space">M&E OD</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('M&E') && app.user.prov == ''" name="HC" href="/Checklist/index/mnehc" class="btn btn-default btnmenu">M&E HC</a>

			<a data-bind="visible: app.user.permiss['Checklist'].contain('Subnation OD')" name="OD" href="/Checklist/index/od" class="btn btn-default btnmenu space">Subnation OD</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('Subnation HC')" name="HC" href="/Checklist/index/hc" class="btn btn-default btnmenu">Subnation HC</a>

			<a data-bind="visible: app.user.permiss['Checklist'].contain('CMEP OD')" name="CMEP OD" href="/Checklist/index/cmepod" class="btn btn-default btnmenu space">CMEP OD</a>
            <a data-bind="visible: app.user.permiss['Checklist'].contain('CMEP HC')" name="CMEP HC" href="/Checklist/index/cmephc" class="btn btn-default btnmenu">CMEP HC</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('CMEP RH')" name="CMEP RH" href="/Checklist/index/cmeprh" class="btn btn-default btnmenu">CMEP RH</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('CMEP Pharmacy')" name="CMEP Pharmacy" href="/Checklist/index/cmep_pharmacy" class="btn btn-default btnmenu">CMEP Pharmacy</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('CMEP Microscopy')" name="CMEP Microscopy" href="/Checklist/index/cmep_microscopy" class="btn btn-default btnmenu">CMEP Microscopy</a>

			<a data-bind="visible: app.user.permiss['Checklist'].contain('PPM')" name="PPM" href="/Checklist/index/cmep_ppm" class="btn btn-default btnmenu">PPM</a>
			<a data-bind="visible: app.user.permiss['Checklist'].contain('Surveillance')" name="Surveillance" href="/Checklist/index/surv" class="btn btn-default btnmenu">Surveillance</a>

            <a data-bind="visible: app.user.permiss['Checklist'].contain('STOCK HC')" name="STOCK HC" href="/Checklist/index/stock_hc" class="btn btn-default btnmenu">STOCK HC</a>
            <a data-bind="visible: app.user.permiss['Checklist'].contain('STOCK RH')" name="STOCK RH" href="/Checklist/index/stock_rh" class="btn btn-default btnmenu">STOCK RH</a>
            <a data-bind="visible: app.user.permiss['Checklist'].contain('STOCK OD')" name="STOCK OD" href="/Checklist/index/stock_od" class="btn btn-default btnmenu">STOCK OD</a>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<!-- ko if: hasSub -->
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list'">
			<span><b>Province</b></span>
			<select data-bind="value: prov,
					options: provList,
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: 'All'" class="form-control minwidth150 kh"></select>

			<span style="margin-left:15px"><b>OD</b></span>
			<select data-bind="value: od,
					options: odList,
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: 'All'" class="form-control minwidth150 kh"></select>

			<!-- ko if: ['Epi','M&E HC','Edu HC', 'Edu VMW','HC', 'CMEP HC', 'CMEP RH'].contain(tab) -->
			<span style="margin-left:15px"><b>HC</b></span>
			<select data-bind="value: hc,
					options: hcList,
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: 'All'" class="form-control minwidth150 kh"></select>
			<!-- /ko -->

            <span style="margin-left:15px"><b>Visit Year</b></span>
			<select data-bind="value: visitYear,
					options: visitYearList,
					optionsCaption: 'All'" class="form-control"></select>

			<a class="btn btn-default text-danger" data-bind="click: showTrash, css: trashMode() ? 'active text-bold' : '', visible: app.user.role == 'AU'" style="margin-left:15px">Trash</a>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<!-- ko if: ['CMEP HC','CMEP OD', 'CMEP RH', 'PPM', 'CMEP Pharmacy', 'CMEP Microscopy'].contain(tab) -->
			<button class="btn btn-success width100" data-bind="click: $root.export">Export</button>
			<!-- /ko -->
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: view() == 'list' && app.user.permiss['Checklist'].contain('Edit')">New</button>
			<button class="btn btn-primary width100" form="myform" data-bind="click: save, visible: view() == 'detail' && app.user.permiss['Checklist'].contain('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back, visible: view() == 'detail'">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<!-- ko if: ['Epi','M&E OD','M&E HC','Edu HC', 'Edu CSO','Edu VMW','Procurement', 'CMEP OD', 'CMEP HC','CMEP RH', 'STOCK OD'].contain(tab) -->
		<table class="table table-bordered table-striped table-hover text-nowrap" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th sortable>Province</th>
                    <th sortable>OD</th>
                    <th sortable data-bind="hidden: tab.in('M&E OD','Procurement', 'CMEP OD', 'STOCK OD', 'Edu CSO')">HC</th>
                    <!-- ko if: !['CMEP OD'].contain($root.tab)-->
                    <th sortable>Visitor</th>
                    <!-- /ko -->
                    <!-- ko if: ['CMEP OD'].contain($root.tab)-->
                    <th>OD Representative</th>
                    <!-- /ko -->
                    <th sortable align="center">Visit Date</th>

					<!-- ko if: ['Epi','M&E HC','M&E OD'].contain(tab) -->
					<th width="90" align="center" sortable>Check From</th>
					<th width="90" align="center" sortable>Check To</th>
					<th align="center" sortable>Score</th>
						<!-- ko ifnot: trashMode -->
						<th width="170" align="center" sortable data-bind="visible: tab == 'Epi'">Visit Next month</th>
						<th width="170" align="center" sortable>Visit Next 3 month</th>
						<th width="170" align="center" sortable>Visit Next 6 month</th>
						<!-- /ko -->
					<!-- /ko -->

					<!-- ko if: ['M&E HC','M&E OD', 'HC', 'OD'].contain(tab) && trashMode() == false -->
					<th width="90" align="center" sortable>Completeness</th>
					<!-- /ko -->

					<!-- ko if: trashMode -->
					<th align="center">Delete Date</th>
					<th align="center">Delete User</th>
					<!-- /ko -->

                    <th width="60" align="center">Detail</th>

					<!-- ko ifnot: trashMode -->
					<th width="60" align="center" data-bind="visible: app.user.permiss['Checklist'].contain('Delete')">Delete</th>     
                    <th width="60" align="center" data-bind="visible: !['Procurement', 'CMEP HC','CMEP RH','CMEP OD', 'Edu CSO'].contain(tab)">Report</th>
                    <!-- /ko -->

					<!-- ko if: trashMode -->
					<th width="63" align="center">Restore</th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getProvName(Code_Prov_N)" class="kh"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>
					<td data-bind="text: $root.tab.in('M&E OD','Procurement', 'CMEP OD', 'STOCK OD', 'Edu CSO') ? '' : $root.getHCName(Code_Facility_T), hidden: $root.tab.in('M&E OD','Procurement', 'CMEP OD', 'STOCK OD', 'Edu CSO')" class="kh"></td>
                    <!-- ko if: !['CMEP OD'].contain($root.tab)-->
					<td data-bind="text: VisitorName, css: { kh: iskhmer(VisitorName) }"></td>
                    <!-- /ko -->
                    <!-- ko if: ['CMEP OD'].contain($root.tab)-->
                    <td data-bind="text: ODRepresentative"></td>
                    <!-- /ko -->
                    <td data-bind="text: moment(VisitDate).displayformat(), sortValue: VisitDate" align="center"></td>

					<!-- ko if: ['Epi','M&E HC','M&E OD'].contain($root.tab) -->
					<td data-bind="text: moment(CheckFrom).format('MMM YYYY'), sortValue: CheckFrom" align="center"></td>
					<td data-bind="text: moment(CheckTo).format('MMM YYYY'), sortValue: CheckTo" align="center"></td>
                    <td data-bind="text: $root.getTotalScore($data)" align="center"></td>
					<!-- /ko -->
					
					<!-- ko if: ['Epi'].contain($root.tab) && $root.trashMode() == false -->
					<td align="center">
						<span data-bind="attr: {class: $root.getTotalScore($data) / 2 <= 50 ? 'fa fa-check-square-o' : 'fa fa-square-o'}"></span>
					</td>
					<td align="center">
						<span data-bind="attr: {class: $root.getTotalScore($data) / 2 > 50 && $root.getTotalScore($data) / 2 <= 80 ? 'fa fa-check-square-o' : 'fa fa-square-o'}"></span>
					</td>
					<td align="center">
						<span data-bind="attr: {class: $root.getTotalScore($data) / 2 > 80 ? 'fa fa-check-square-o' : 'fa fa-square-o'}"></span>
					</td>
					<!-- /ko -->

					<!-- ko if: ['M&E HC','M&E OD'].contain($root.tab) && $root.trashMode() == false -->
					<td align="center">
						<span data-bind="attr: {class: $root.getTotalScore($data) <= 75 ? 'fa fa-check-square-o' : 'fa fa-square-o'}" ></span>
					</td>
					<td align="center">
						<span data-bind="attr: {class: $root.getTotalScore($data) > 75 ? 'fa fa-check-square-o' : 'fa fa-square-o'}"></span>
					</td>
					<td align="center">
						<span data-bind="attr: {class: completeness == 1 ? 'fa fa-check-square-o' : 'fa fa-square-o'}" class="fa "></span>
					</td>
					<!-- /ko -->

					<!-- ko if: $root.trashMode -->
					<td data-bind="text: moment(DeletedTime).displayformat('datetime')" align="center"></td>
					<td data-bind="text: DeletedUser" align="center"></td>
					<!-- /ko -->

					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>

					<!-- ko ifnot: $root.trashMode -->
					<td align="center" data-bind="visible: app.user.permiss['Checklist'].contain('Delete')">
						<a data-bind="click: $root.showDelete" class="text-danger">Delete</a>
					</td>
                    <td align="center" data-bind="visible: !['Procurement', 'CMEP HC','CMEP RH','CMEP OD', 'Edu CSO'].contain($root.tab)">
                        <a data-bind="click: $root.showReport">Report</a>
                    </td>
					<!-- /ko -->

					<!-- ko if: $root.trashMode -->
					<td align="center">
						<a data-bind="click: $root.showRestore" class="text-danger">Restore</a>
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: ['OD','HC'].contain(tab) -->
		<table class="table table-bordered table-striped table-hover text-nowrap" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable data-bind="visible: tab == 'HC'">HC</th>
					<th sortable>Visitor</th>
					<th align="center" sortable>Visit Date</th>
					<th align="center" sortable>Check From</th>
					<th align="center" sortable>Check To</th>
                    <th align="center">Completeness</th>
					<th align="center" data-bind="visible: trashMode">Delete Date</th>
					<th align="center" data-bind="visible: trashMode">Delete User</th>
					<th width="60" align="center">Detail</th>
					<th width="60" align="center" data-bind="visible: !trashMode() && app.user.permiss['Checklist'].contain('Delete')">Delete</th>
					<th width="60" align="center" data-bind="visible: trashMode">Restore</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getProvName(Code_Prov_N)" class="kh"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>
					<!-- ko if: ['HC'].contain($root.tab) -->
					<td data-bind="text: $root.getHCName(Code_Facility_T)" class="kh"></td>
					<!-- /ko -->
					<td data-bind="text: VisitorName, css: { kh: iskhmer(VisitorName) }"></td>
					<td data-bind="text: moment(VisitDate).displayformat(), sortValue: VisitDate" align="center"></td>
					<td data-bind="text: moment(CheckFrom).format('MMM YYYY'), sortValue: CheckFrom" align="center"></td>
					<td data-bind="text: moment(CheckTo).format('MMM YYYY'), sortValue: CheckTo" align="center"></td>
                    <td align="center">
                        <span data-bind="attr: {class: completeness == 1 ? 'fa fa-check-square-o' : 'fa fa-square-o'}" class="fa "></span>
                    </td>
					<td data-bind="text: moment(DeletedTime).displayformat('datetime'), visible: $root.trashMode" align="center"></td>
					<td data-bind="text: DeletedUser, visible: $root.trashMode" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: !$root.trashMode() && app.user.permiss['Checklist'].contain('Delete')">
						<a data-bind="click: $root.showDelete" class="text-danger">Delete</a>
					</td>
					<td align="center" data-bind="visible: $root.trashMode">
						<a data-bind="click: $root.showRestore" class="text-danger">Restore</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: ['Surveillance'].contain(tab) -->
		<table class="table table-bordered table-striped table-hover text-nowrap" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>HC</th>
					<th sortable>Visitor</th>
					<th align="center" sortable>Visit Date</th>
					<th align="center" data-bind="visible: trashMode">Delete Date</th>
					<th align="center" data-bind="visible: trashMode">Delete User</th>
					<th width="60" align="center">Detail</th>
					<th width="60" align="center" data-bind="visible: !trashMode() && app.user.permiss['Checklist'].contain('Delete')">Delete</th>
					<th width="60" align="center" data-bind="visible: trashMode">Restore</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getProvName(Code_Prov_N)" class="kh"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)" class="kh"></td>
					<td data-bind="text: VisitorName, css: { kh: iskhmer(VisitorName) }"></td>
					<td data-bind="text: moment(VisitDate).displayformat(), sortValue: VisitDate" align="center"></td>
					<td data-bind="text: moment(DeletedTime).displayformat('datetime'), visible: $root.trashMode" align="center"></td>
					<td data-bind="text: DeletedUser, visible: $root.trashMode" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: !$root.trashMode() && app.user.permiss['Checklist'].contain('Delete')">
						<a data-bind="click: $root.showDelete" class="text-danger">Delete</a>
					</td>
					<td align="center" data-bind="visible: $root.trashMode">
						<a data-bind="click: $root.showRestore" class="text-danger">Restore</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: tab == 'Labo' -->
		<table class="table table-bordered table-striped table-hover text-nowrap" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th sortable>Province</th>
					<th sortable>District</th>
					<th sortable>HF Name</th>
					<th sortable>Internviewer</th>
					<th align="center" sortable>Visit Date</th>
					<th align="center" data-bind="visible: trashMode">Delete Date</th>
					<th align="center" data-bind="visible: trashMode">Delete User</th>
					<th width="60" align="center">Detail</th>
					<th width="60" align="center" data-bind="visible: !trashMode() && app.user.permiss['Checklist'].contain('Delete')">Delete</th>
					<th width="60" align="center" data-bind="hidden: trashMode">Report</th>
					<th width="60" align="center" data-bind="visible: trashMode">Restore</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getProvName(Code_Prov_N)" class="kh"></td>
					<td data-bind="text: $root.getDistName(Code_Dist_T)" class="kh"></td>
					<td data-bind="text: HFName, css: { kh: iskhmer(HFName) }"></td>
					<td data-bind="text: Interviewer, css: { kh: iskhmer(Interviewer) }"></td>
					<td data-bind="text: moment(VisitDate).displayformat(), sortValue: VisitDate" align="center"></td>
					<td data-bind="text: moment(DeletedTime).displayformat('datetime'), visible: $root.trashMode" align="center"></td>
					<td data-bind="text: DeletedUser, visible: $root.trashMode" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: !$root.trashMode() && app.user.permiss['Checklist'].contain('Delete')">
						<a data-bind="click: $root.showDelete" class="text-danger">Delete</a>
					</td>
					<td align="center" data-bind="hidden: $root.trashMode">
						<a data-bind="click: $root.showReport">Report</a>
					</td>
					<td align="center" data-bind="visible: $root.trashMode">
						<a data-bind="click: $root.showRestore" class="text-danger">Restore</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<!-- ko if: ['CMEP Pharmacy','CMEP Microscopy','PPM', 'STOCK HC','STOCK RH'].contain(tab) -->
		<table class="table table-bordered table-striped table-hover text-nowrap" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th sortable>Province</th>
					<th sortable>OD</th>
					<th sortable>HC</th>
					<th sortable>Visitor</th>
					<th align="center" sortable>Visit Date</th>
					<th align="center" data-bind="visible: trashMode">Delete Date</th>
					<th align="center" data-bind="visible: trashMode">Delete User</th>
					<th width="60" align="center">Detail</th>
					<th width="60" align="center" data-bind="visible: !trashMode() && app.user.permiss['Checklist'].contain('Delete')">Delete</th>
					<th width="60" align="center" data-bind="visible: trashMode">Restore</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getProvName(Code_Prov_N)" class="kh"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)" class="kh"></td>
					<td data-bind="text: VisitorName, css: { kh: iskhmer(VisitorName) }"></td>
					<td data-bind="text: moment(VisitDate).displayformat(), sortValue: VisitDate" align="center"></td>
					<td data-bind="text: moment(DeletedTime).displayformat('datetime'), visible: $root.trashMode" align="center"></td>
					<td data-bind="text: DeletedUser, visible: $root.trashMode" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: !$root.trashMode() && app.user.permiss['Checklist'].contain('Delete')">
						<a data-bind="click: $root.showDelete" class="text-danger">Delete</a>
					</td>
					<td align="center" data-bind="visible: $root.trashMode">
						<a data-bind="click: $root.showRestore" class="text-danger">Restore</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

		<?php if ($sub != '') $this->load->view($sub); ?>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && app.user.permiss['Checklist'].contain('Edit')">
		<button class="btn btn-primary width150" form="myform" data-bind="click: save">Save</button>
	</div>
	<!-- /ko -->
</div>

<?=latestJs('/media/ViewModel/Checklist.js')?>