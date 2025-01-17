<div class="panel-heading clearfix" data-bind="visible: view() == 'list' && ['PRH Follow-up','RH Follow-up','HC Follow-up','VMW Follow-up'].contain(menu())">
	<div class="pull-left form-inline">
		<div class="inlineblock">
			<div class="text-bold">Province</div>
			<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length == 1 ? undefined : 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">OD</div>
			<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: odList().length == 1 ? undefined : 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">HF</div>
			<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock" data-bind="visible: menu() == 'VMW Follow-up'">
			<div class="text-bold">VMW</div>
			<select class="form-control minwidth100" data-bind="value: vl, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
        <div class="inlineblock">
			<div class="text-bold">Year</div>
			<select class="form-control" data-bind="value: year, options: yearList"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">Month</div>
			<select class="form-control" data-bind="value: month, options: monthList, optionsCaption: 'All'"></select>
		</div>
		<button class="btn btn-primary width100" data-bind="click: getUpcomingFU">View</button>
	</div>
</div>

<div class="panel-body" data-bind="visible: view() == 'list' && menu().in('PRH Follow-up','RH Follow-up','HC Follow-up')">
	<table id="tblHC" class="table table-bordered table-hover">
		<thead class="bg-thead">
			<tr>
				<th align="center" export="no" width="40">#</th>
				<th align="center" sortable>Province</th>
				<th align="center" sortable>OD</th>
				<th align="center" sortable>Health Facility</th>
				<th align="center" sortable>Patient Name</th>
				<th align="center" sortable>Age</th>
				<th align="center" sortable>Sex</th>
				<th align="center" sortable>Species</th>
				<th align="center" sortable>Day Follow-up</th>
				<th align="center" sortable>Follow-up Date</th>
				<th align="center">DBS D28</th>
				<th align="center">DBS D42</th>
				<th align="center">DBS D90</th>
                <th align="center">Note</th>
                <th align="center"> Action</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: hcFuListModel, fixedHeader: true">
			<tr data-bind="style: { color: IsOver == 1 ? 'red' : 'black'} ">
				<td align="center" data-bind="text: $index() + 1"></td>
				<td data-bind="text: Name_Prov_E"></td>
				<td data-bind="text: Name_OD_E"></td>
				<td data-bind="text: Name_Facility_E"></td>
				<td data-bind="text: NameK, css: { kh: iskhmer(NameK) }"></td>
				<td align="center" data-bind="text: Age"></td>
				<td align="center" data-bind="text: Sex == 'M' ? 'Male' : 'Female'"></td>
				<td align="center" data-bind="text: Species"></td>
				<td align="center" data-bind="text: Day"></td>
				<td align="center" data-bind="text: moment(Date).displayformat(), sortValue: Date"></td>
				<td align="center" data-bind="text: DBS_D28 == 1 ? '✔' : ''"></td>
				<td align="center" data-bind="text: DBS_D42 == 1 ? '✔' : ''"></td>
				<td align="center" data-bind="text: DBS_D90 == 1 ? '✔' : ''"></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Note"/>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary" data-bind="click: $root.saveNote">Save Note</button>
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

<div class="panel-body" data-bind="visible: view() == 'list' && menu() == 'VMW Follow-up'">
	<table id="tblHC" class="table table-bordered table-hover">
		<thead class="bg-thead">
			<tr>
				<th align="center" export="no" width="40">#</th>
				<th align="center" sortable>Province</th>
				<th align="center" sortable>OD</th>
				<th align="center" sortable>Health Facility</th>
                <th align="center" sortable>VMW</th>
				<th align="center" sortable>Patient Name</th>
				<th align="center" sortable>Age</th>
				<th align="center" sortable>Sex</th>
				<th align="center" sortable>Species</th>
				<th align="center" sortable>Day Follow-up</th>
				<th align="center" sortable>Follow-up Date</th>
				<th align="center">DBS D28</th>
				<th align="center">DBS D42</th>
				<th align="center">DBS D90</th>
                <th align="center">Note</th>
                <th align="center"> Action</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: vmwFuListModel, fixedHeader: true">
			<tr data-bind="style: { color: IsOver == 1 ? 'red' : 'black'}">
				<td align="center" data-bind="text: $index() + 1"></td>
				<td data-bind="text: Name_Prov_E"></td>
				<td data-bind="text: Name_OD_E"></td>
				<td data-bind="text: Name_Facility_E"></td>
                <td data-bind="text: Name_Vill_E"></td>
				<td data-bind="text: NameK, css: { kh: iskhmer(NameK) }"></td>
				<td align="center" data-bind="text: Age"></td>
				<td align="center" data-bind="text: Sex == 'M' ? 'Male' : 'Female'"></td>
				<td align="center" data-bind="text: Species"></td>
				<td align="center" data-bind="text: Day"></td>
				<td align="center" data-bind="text: moment(Date).displayformat(), sortValue: Date"></td>
				<td align="center" data-bind="text: DBS_D28 == 1 ? '✔' : ''"></td>
				<td align="center" data-bind="text: DBS_D42 == 1 ? '✔' : ''"></td>
				<td align="center" data-bind="text: DBS_D90 == 1 ? '✔' : ''"></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: Note"/>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary" data-bind="click: $root.saveNote">Save Note</button>
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
