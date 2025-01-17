<style>
	.caret { position: absolute; right: 10px; top: 48%; }
	.cursor-default { cursor: default; }
</style>

<!-- ko with: dbs -->
<div class="panel-heading clearfix" data-bind="visible: $root.menu() == 'Blood Slides/DBS'">
	<div class="pull-left form-inline">
		<div class="input-group">
			<span class="input-group-addon text-bold">Province</span>
			<select class="form-control" data-bind="value: pv, options: $root.pvList, optionsValue: 'code', optionsText: 'name'"></select>
		</div>
		<div class="input-group">
			<span class="input-group-addon text-bold">From</span>
			<input type="text" class="form-control text-center width100" data-bind="datePicker: mf, format: 'MMM YYYY', minDate: '2022-01-01'">
			<span class="input-group-addon text-bold">To</span>
			<input type="text" class="form-control text-center width100" data-bind="datePicker: mt, format: 'MMM YYYY', minDate: mf">
		</div>
		<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
	</div>
	<div class="pull-right" style="position:sticky; right:21px">
		<button class="btn btn-primary width100" data-bind="click: save">Save</button>
	</div>
</div>

<div class="panel-body" data-bind="visible: $root.menu() == 'Blood Slides/DBS'">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th width="40" align="center" rowspan="3" class="bg-thead">No</th>
				<th align="center" rowspan="3" class="bg-thead">DBS Code</th>
				<th align="center" rowspan="3" class="bg-thead">Name of Patient Enrolled</th>
				<th align="center" colspan="2" rowspan="2" class="bg-thead">Day of Sample Collection</th>
				<th align="center" colspan="9" class="bg-warning">One Slide</th>
				<th align="center" colspan="9" class="bg-success">Two DBS</th>
			</tr>
			<tr>
				<th align="center" colspan="2" class="bg-warning">Submission</th>
				<th align="center" colspan="3" class="bg-warning">Reception</th>
				<th align="center" colspan="4" class="bg-warning">Reading</th>
				<th align="center" colspan="2" class="bg-success">Submission</th>
				<th align="center" colspan="3" class="bg-success">Recipient</th>
				<th align="center" colspan="4" class="bg-success">PCR Testing</th>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Day of Slide and DBS Collection</th>
				<th align="center" class="bg-thead">Date of Slide and DBS Collection<br>(DD/MM/YY)</th>
				<th align="center" class="bg-warning">Name of Submission VMW/MMW/HC/RH/PRH</th>
				<th align="center" class="bg-warning">Date of Submission<br>(DD/MM/YY)</th>
				<th align="center" class="bg-warning">Name of Recipient HC/RH/PRH/CNM/IPC</th>
				<th align="center" class="bg-warning">Date of Recipeint<br>(DD/MM/YY)</th>
				<th align="center" class="bg-warning">Remarks of Recipient</th>
				<th align="center" class="bg-warning">Name of Microscopist Reading the slide</th>
				<th align="center" class="bg-warning">Date of Reading<br>(DD/MM/YY)</th>
				<th align="center" class="bg-warning">Reading Results*</th>
				<th align="center" class="bg-warning">Remakrs of Microscopist</th>
				<th align="center" class="bg-success">Name of Submission VMW/MMW/HC/RH/PRH</th>
				<th align="center" class="bg-success">Date of Submission<br>(DD/MM/YY)</th>
				<th align="center" class="bg-success">Name of Recipient HC/RH/PRH/CNM/IPC</th>
				<th align="center" class="bg-success">Date of Recipeint<br>(DD/MM/YY)</th>
				<th align="center" class="bg-success">Remarks of Recipient</th>
				<th align="center" class="bg-success">Name of Lab technician conducting PCR</th>
				<th align="center" class="bg-success">Date of PCR<br>(DD/MM/YY)</th>
				<th align="center" class="bg-success">PCR Results**</th>
				<th align="center" class="bg-success">Remakrs of Lab Technician</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: listModel, fixedHeader: true">
			<tr>
				<td align="center" data-bind="text: $index() + 1, attr: { rowspan: days().length }"></td>
				<td data-bind="attr: { rowspan: days().length }">
					<input type="text" class="input-block minwidth100" data-bind="value: DBS_Code" />
				</td>
				<td align="center" data-bind="attr: { rowspan: days().length }">
					<div class="text-nowrap" data-bind="text: PatientName"></div>
					<a class="text-nowrap" data-bind="click: $parent.addDay">Add Day</a>
				</td>
				<!-- ko with: days()[0] -->
				<td class="text-nowrap">
					<select data-bind="value: Days" style="padding:3px 0">
						<option></option>
						<option value="0">Day 0</option> 
						<option value="28">Day 28</option>
						<option value="42">Day 42</option>
						<option value="90">Day 90</option>
						<option value="Other">Any Other Day</option>
					</select>
				</td>
				<td class="relative" data-bind="if: Days() != ''">
					<input type="text" class="input-block minwidth100 text-center" data-bind="datePicker: DBS_Date, format: 'DD/MM/YY'" />
				</td>
				<!-- ko foreach: details -->
				<td class="relative" data-bind="if: $parent.Days() != ''">
					<!-- ko if: Field == 'Name of Submission' -->
					<input type="text" class="input-block minwidth100 cursor-default" data-bind="value: $root.dbs.getPlaceName(Value()), click: () => $root.dbs.choosePlace(Value)" readonly />
					<span class="caret"></span>
					<!-- /ko -->

					<!-- ko if: !Field.contain('Date') && Field != 'Name of Submission'  -->
					<input type="text" class="input-block minwidth100" data-bind="value: Value" />
					<!-- /ko -->

					<!-- ko if: Field.contain('Date') && Field != 'Name of Submission' -->
					<input type="text" class="input-block minwidth100 text-center" data-bind="datePicker: Value, format: 'DD/MM/YY'" />
					<!-- /ko -->
				</td>
				<!-- /ko -->
				<!-- /ko -->
			</tr>

			<!-- ko foreach: days.slice(1) -->
			<tr>
				<td class="text-nowrap">
					<select data-bind="value: Days" style="padding:3px 0">
						<option></option>
						<option value="0">Day 0</option> 
						<option value="28">Day 28</option>
						<option value="42">Day 42</option>
						<option value="90">Day 90</option>
						<option value="Other">Any Other Day</option>
					</select>
					<a class="text-danger text-bold" style="margin-left:5px" data-bind="click: () => $root.dbs.deleteDay($parent,$data)">X</a>
				</td>
				<td class="relative" data-bind="if: Days() != ''">
					<input type="text" class="input-block minwidth100 text-center" data-bind="datePicker: DBS_Date, format: 'DD/MM/YY'" />
				</td>
				<!-- ko foreach: details -->
				<td class="relative" data-bind="if: $parent.Days() != ''">
					<!-- ko if: Field == 'Name of Submission' -->
					<input type="text" class="input-block minwidth100 cursor-default" data-bind="value: $root.dbs.getPlaceName(Value()), click: () => $root.dbs.choosePlace(Value)" readonly="">
					<span class="caret"></span>
					<!-- /ko -->

					<!-- ko if: !Field.contain('Date') && Field != 'Name of Submission'  -->
					<input type="text" class="input-block minwidth100" data-bind="value: Value" />
					<!-- /ko -->

					<!-- ko if: Field.contain('Date') && Field != 'Name of Submission' -->
					<input type="text" class="input-block minwidth100 text-center" data-bind="datePicker: Value, format: 'DD/MM/YY'" />
					<!-- /ko -->
				</td>
				<!-- /ko -->
			</tr>
			<!-- /ko -->
		</tbody>
	</table>
</div>

<div id="modalPlace" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:450px">
		<div class="modal-content" data-bind="with: placeModel">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Name of Submission</h3>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-xs-3">Province</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">OD</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">PRH/RH/HC</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">VMW/MMW</label>
						<div class="col-xs-9">
							<select class="form-control" data-bind="value: vl, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary width100" data-bind="click: ok">OK</button>
				<button class="btn btn-default width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- /ko -->