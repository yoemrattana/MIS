<style>
	table.child { position:sticky; left:60px; }
	table { cursor:default; }
	.underline:not(:empty):hover { text-decoration: underline; cursor: pointer; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" style="position:sticky; left:21px">
			<div class="inlineblock">
				<div class="text-bold">Province</div>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">OD</div>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">HC</div>
				<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table id="tblmain" class="table table-bordered table-hover text-nowrap">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center" sortable>Report<br />Type</th>
					<th align="center" sortable>Report<br />Month</th>
                    <th align="center" sortable>Report<br />Year</th>
                    <th align="center" sortable>Province</th>
                    <th align="center" sortable>OD</th>
                    <th align="center" sortable>HC</th>
                    <th align="center" sortable>VMW</th>
					<th align="center" sortable>Patient Name</th>
					<th align="center" sortable>Age</th>
					<th align="center" sortable>Sex</th>
					<th align="center" sortable>Species</th>
                    <th align="center">Status</th>
                    <th align="center">Confirm</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr>
                    <td align="center" data-bind="text: $index() +1"></td>
                    <td data-bind="text: CaseType"></td>
                    <td data-bind="text: Month"></td>
                    <td data-bind="text: Year"></td>
                    <td class="kh" data-bind="text: $root.getProvName(Code_Prov_T)"></td>
                    <td class="kh" data-bind="text: $root.getODName(Code_OD_T)"></td>
                    <td class="kh" data-bind="text: $root.getHCName(Code_Facility_T)"></td>
                    <td class="kh" data-bind="text: $root.getVLName(Code_Vill_T)"></td>
                    <td class="kh" data-bind="text: NameK"></td>
                    <td data-bind="text: Age"></td>
                    <td data-bind="text: Sex"></td>
                    <td data-bind="text: $root.getSpecie(Specie)"></td>
                    <td > <span class="badge" data-bind="visible: IsConfirm() == 1">Confirmed</span>
                        <span class="badge" data-bind="visible: IsConfirm() == 2">Rejected</span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success" data-bind="click: $root.confirm, enable: IsConfirm()== null">Confirm</button>
                        <button class="btn btn-sm btn-danger" data-bind="click: $root.reject, enable: IsConfirm() ==null">Reject</button>
                    </td>
                </tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/CaseConfirm.js')?>