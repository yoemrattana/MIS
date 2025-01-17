<!-- ko if: menu() == 'Permission' -->
<!-- ko with: permission -->
<div class="panel-heading clearfix">
	<div class="pull-left form-inline">
		<div class="inlineblock">
			<div class="text-bold">Province</div>
			<select class="form-control" data-bind="value: pv, options: $root.pvList, optionsValue: 'code', optionsText: 'name'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">OD</div>
			<select class="form-control" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
	</div>
	<div class="pull-right" style="padding-top:20px">
		<button class="btn btn-primary width100" data-bind="click: save">Save</button>
	</div>
</div>
<div class="panel-body" data-bind="visible: listModel().length > 0">
	<table class="table table-bordered table-hover widthauto">
		<thead class="bg-thead">
			<tr>
				<th align="center">Province</th>
				<th align="center">OD</th>
				<th align="center">HC</th>
				<th align="center">Permission</th>
				<th align="center">Start Date</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: getListModel, fixedHeader: true">
			<tr>
				<td data-bind="text: $root.getPVName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getODName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
				<td align="center">
					<input type="checkbox" class="checkbox-inline checkbox-lg" data-bind="checked: Permission, change: $parent.changePermission" />
				</td>
				<td class="relative">
					<input type="text" class="form-control input-sm width80 text-center font14" data-bind="datePicker: StartDate, format: 'MMM YYYY', minDate: '2022-01', enable: Permission" />
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- /ko -->
<!-- /ko -->