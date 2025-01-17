<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" style="position:sticky; left:21px">
			<div class="input-group">
				<span class="input-group-addon">Province</span>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">OD</span>
				<select class="form-control minwidth150" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Group</span>
				<select class="form-control" data-bind="value: group">
					<option>All</option>
					<option>MRRT 1</option>
					<option>MRRT 2</option>
				</select>
			</div>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: app.user.permiss['MRRT Members'].contain('Edit')">New</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-hover table-striped">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center" sortable>Province</th>
					<th align="center" sortable>OD</th>
					<th align="center" sortable>Group</th>
					<th align="center" sortable>Member Name</th>
					<th align="center" sortable>Role</th>
					<th align="center" sortable>MRRT Training</th>
					<th align="center" sortable>Entomology Training</th>
					<th align="center">Comment</th>
					<th align="center" width="60" data-bind="visible: app.user.permiss['MRRT Members'].contain('Edit')">Edit</th>
					<th align="center" width="60" data-bind="visible: app.user.permiss['MRRT Members'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel(), fixedHeader: true, sortModel: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getPVName(Code_Prov_T)"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)"></td>
					<td data-bind="text: GroupName" align="center"></td>
					<td data-bind="text: Member"></td>
					<td data-bind="text: Position" align="center"></td>
					<td data-bind="text: moment(TrainFrom).format('DD/MM/YY') + ' - ' + moment(TrainTo).format('DD/MM/YY'), sortValue: TrainFrom" align="center"></td>
					<td data-bind="text: EntomoFrom == null ? '' : moment(EntomoFrom).format('DD/MM/YY') + ' - ' + moment(EntomoTo).format('DD/MM/YY'), sortValue: EntomoFrom" align="center"></td>
					<td data-bind="text: Note"></td>
					<td align="center" data-bind="visible: app.user.permiss['MRRT Members'].contain('Edit')">
						<a data-bind="click: $root.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['MRRT Members'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="modal" id="modalEdit" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body" data-bind="with: editModel">
				<table class="table">
					<tr>
						<th align="right" valign="middle">Province:</th>
						<td><select class="form-control" data-bind="value: Code_Prov_T, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select></td>
					</tr>
					<tr>
						<th align="right" valign="middle">OD:</th>
						<td><select class="form-control" data-bind="value: Code_OD_T, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select></td>
					</tr>
					<tr>
						<th align="right" valign="middle">Group:</th>
						<td>
							<select class="form-control" data-bind="value: GroupName">
								<option></option>
								<option>MRRT 1</option>
								<option>MRRT 2</option>
							</select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle" class="text-nowrap">Member Name:</th>
						<td>
							<div class="input-group">
								<input type="text" class="form-control" data-bind="value: Member" />
								<span class="input-group-addon">English</span>
							</div>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Role:</th>
						<td>
							<select class="form-control" data-bind="value: Position">
								<option></option>
								<option>PHD</option>
								<option>PMS</option>
								<option>ODMS</option>
								<option>Epidemiologist</option>
								<option>Entomologist</option>
								<option>Technician Lab</option>
								<option>N/A</option>
							</select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle" class="text-nowrap">MRRT Training:</th>
						<td class="relative">
							<div class="input-group">
								<span class="input-group-addon">From</span>
								<input type="text" class="form-control text-center" data-bind="datePicker: TrainFrom, showClear: true, format: 'DD/MM/YYYY'" placeholder="DD/MM/YYYY" />
								<span class="input-group-addon">To</span>
								<input type="text" class="form-control text-center" data-bind="datePicker: TrainTo, showClear: true, format: 'DD/MM/YYYY'" placeholder="DD/MM/YYYY" />
							</div>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle" class="text-nowrap">Entomology Training:</th>
						<td class="relative">
							<div class="input-group">
								<span class="input-group-addon">From</span>
								<input type="text" class="form-control text-center" data-bind="datePicker: EntomoFrom, showClear: true, format: 'DD/MM/YYYY'" placeholder="DD/MM/YYYY" />
								<span class="input-group-addon">To</span>
								<input type="text" class="form-control text-center" data-bind="datePicker: EntomoTo, showClear: true, format: 'DD/MM/YYYY'" placeholder="DD/MM/YYYY" />
							</div>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Comment:</th>
						<td><input type="text" class="form-control" data-bind="value: Note" /></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary width100" data-bind="click: save">Save</button>
				<button class="btn btn-default width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/MRRT.js')?>