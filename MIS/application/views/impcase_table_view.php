<style>
     .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }
    .input-error {
		border-color: tomato;
		color: tomato;
	}
</style>
<div class="panel-heading clearfix">
    <div class="pull-left form-inline" data-bind="visible: view() == 'list'">
        <button class="btn btn-primary width100" data-bind="click: $root.add">Add</button>
    </div>
    <div class="pull-right" data-bind="visible: view() == 'detail'">
        <button class="btn btn-primary width100" data-bind="click: save, visible: ifcan('Edit')">Save</button>
        <button class="btn btn-default width100" data-bind="click: back">Back</button>
    </div>
</div>

<div class="panel-body">
    <table class="table table-bordered" data-bind="visible: view() == 'list'">
        <thead class="bg-thead">
            <tr>
                <th align="center" width="40">#</th>
                <th align="center" sortable>Name</th>
                <th align="center" sortable>Sex</th>
                <th align="center" sortable>Date Collect</th>
                <th align="center" sortable>RDT</th>
                <th align="center" sortable>Microscope</th>
                <th align="center" sortable>PCR</th>
                <th align="center" sortable>Lat</th>
                <th align="center" sortable>Long</th>
                <th align="center" sortable>Address</th>
                <th align="center" sortable>From Country</th>
                <th align="center" sortable>Note</th>
                <th align="center" width="60">Edit</th>
                <th align="center" width="60" data-bind="visible: ifcan('Delete')">Delete</th>
            </tr>
        </thead>
        <tbody data-bind="foreach: listModel,  fixedHeader: true">
            <tr>
                <td align="center" data-bind="text: $index() + 1"></td>
                <td class="kh" data-bind="text: NameK"></td>
                <td data-bind="text: $root.getSex(Sex())"></td>
                <td align="center" data-bind="text: moment(DateCollect()).displayformat()"></td>
                <td data-bind="text: $root.getSpecie(RDT())"></td>
                <td data-bind="text: $root.getSpecie(Microscope())"></td>
                <td data-bind="text: $root.getSpecie(PCR())"></td>
                <td class="kh" data-bind="text: Lat"></td>
                <td class="kh" data-bind="text: Long"></td>
                <td class="kh" data-bind="text: Address"></td>
                <td class="kh" data-bind="text: FromCountry"></td>
                <td class="kh" data-bind="text: Note"></td>
                <td align="center">
                    <a data-bind="click: $root.edit">Edit</a>
                </td>
                <td align="center" data-bind="visible: $root.ifcan('Delete')">
                    <a data-bind="click: $root.showDelete" class="text-danger">Delete</a>
                </td>
            </tr>
        </tbody>
        <tfoot data-bind="visible: app.tableFooter($element)">
            <tr>
                <td class="text-center text-warning h4" style="padding:10px">No Data</td>
            </tr>
        </tfoot>
    </table>

    <div data-bind="visible: view() == 'detail'">
        <table class="table table-bordered form-group">
			<thead>
				<tr>
					<th align="center">NameK</th>
					<th align="center">Sex</th>
					<th align="center">Age</th>
					<th align="center">Date Of Birth</th>
					<th align="center">Date Collect</th>
					<th align="center">RDT</th>
					<th align="center">Microscope</th>
					<th align="center">PCR</th>
					<th align="center">Address</th>
					<th align="center">Village</th>
					<th align="center">Lat</th>
					<th align="center">Long</th>
					<th align="center">Phone</th>
					<th align="center">From Country</th>
					<th align="center">Note</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: $root.detailModel">
				<tr>
					<td>
						<input type="text" class="text-center" data-bind="value: NameK">
					</td>
					<td>
						<select data-bind="value: Sex, options: ['M','F']"></select>
					</td>
					<td>
						<input type="number" class="text-center" data-bind="value: Age">
					</td>
					<td>
						<input type="date" class="text-center" data-bind="value: DB">
					</td>
                    <td>
						<input type="date" class="text-center" data-bind="value: DateCollect">
					</td>
                    <td>
						<select data-bind="value: RDT">
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
							<option value="N">Negative</option>
							<option value="K">Pk</option>
							<option value="A">Pm</option>
							<option value="O">Po</option>
						</select>
					</td>
                    <td>
						<select data-bind="value: Microscope">
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
							<option value="N">Negative</option>
							<option value="K">Pk</option>
							<option value="A">Pm</option>
							<option value="O">Po</option>
                            <option value="P">NMPS</option>
						</select>
					</td>
                    <td>
						<select data-bind="value: PCR">
							<option value="S">Spp</option>
							<option value="F">Pf</option>
							<option value="V">Pv</option>
							<option value="M">Mix</option>
							<option value="N">Negative</option>
							<option value="K">Pk</option>
							<option value="A">Pm</option>
							<option value="O">Po</option>
							<option value="D">Non-Detected</option>
						</select>
					</td>
                    <td>
						<input type="text" class="text-center" data-bind="value: Address">
					</td>
                    <td>
						<input type="text" class="text-center" data-bind="value: Code_Vill_T">
					</td>
                    <td>
						<input type="number" class="text-center" data-bind="value: Lat">
					</td>
                    <td>
						<input type="number" class="text-center" data-bind="value: Long">
					</td>
                    <td>
						<input type="text" class="text-center" data-bind="value: Phone">
					</td>
                    <td>
						<input type="text" class="text-center" data-bind="value: FromCountry">
					</td>
                    <td>
						<input type="text" class="text-center" data-bind="value: Note">
					</td>
				</tr>
			</tbody>
		</table>
    </div>
</div>