<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<div class="pull-left" style="display:flex; gap:5px">
			<div class="input-group">
				<span class="input-group-addon">Province</span>
				<select class="form-control minwidth100" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">OD</span>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">HC</span>
				<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Type</span>
				<select class="form-control minwidth100" data-bind="value: type">
					<option>All</option>
					<option>OD</option>
					<option>HC</option>
					<option>VMW</option>
				</select>
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width80" data-bind="click: showNew">New</button>
			<button class="btn btn-success width80" data-bind="click: exportExcel">Export</button>
			<a href="/home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-hover">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center" width="200" sortable>Province</th>
					<th align="center" width="200" sortable>OD</th>
					<th align="center" width="200" sortable>HC</th>
					<th align="center" width="200" sortable>Village</th>
					<th align="center" width="200" sortable>Model</th>
					<th align="center" width="200" sortable>IMEI</th>
					<th align="center" width="200" sortable>Serial</th>
					<th align="center" width="200" sortable>Phone</th>
					<th align="center" class="minwidth150">Note</th>
					<th align="center" width="60">Save</th>
					<th align="center" width="60">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel(), sortModel: listModel">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td>
						<select class="form-control input-sm" data-bind="value: Code_Prov_T, options: $root.pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</td>
					<td>
						<select class="form-control input-sm" data-bind="value: Code_OD_T, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</td>
					<td>
						<select class="form-control input-sm" data-bind="value: Code_Facility_T, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</td>
					<td>
						<select class="form-control input-sm" data-bind="value: Code_Vill_T, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</td>
					<td>
						<input type="text" class="form-control input-sm" data-bind="value: Model" />
					</td>
					<td>
						<input type="text" class="form-control input-sm" data-bind="value: Imei" />
					</td>
					<td>
						<input type="text" class="form-control input-sm" data-bind="value: Serial" />
					</td>
					<td>
						<input type="text" class="form-control input-sm" data-bind="value: Phone" />
					</td>
					<td>
						<input type="text" class="form-control input-sm" data-bind="value: Note" />
					</td>
					<td align="center" valign="middle">
						<a data-bind="click: $root.save">Save</a>
					</td>
					<td align="center" valign="middle">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/DeviceInventory.js')?>