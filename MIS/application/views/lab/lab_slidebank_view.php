<style>
	.table { width: max-content; }
	tbody input { width: 100%; }
	tbody select { width: 100%; height: 25px; }
</style>

<?php $this->view('lab/lab_menu'); ?>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh26 font16" style="position:sticky; left:21px">
			<b>Malaria National Reference Laboratory System</b>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<a href="/Home" class="btn btn-sm btn-home">Home</a>
		</div>
	</div>

	<div class="panel-heading clearfix">
		<div class="pull-right" style="position:sticky; right:11px">
			<button class="btn btn-sm btn-success width80" data-bind="click: exportExcel">Export</button>
			<button class="btn btn-sm btn-primary width80" data-bind="click: save">Save</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<table class="table table-bordered form-group">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="80">Case No</th>
					<th align="center" width="80">Year</th>
					<th align="center" width="100">Code No</th>
					<th align="center" width="80">Slide Start</th>
					<th align="center" width="80">Slide End</th>
					<th align="center" width="80">Box No</th>
					<th align="center" width="100">PCR Result</th>
					<th align="center" width="100">Microscopy</th>
					<th align="center" width="100">Density</th>
					<th align="center">Validate</th>
					<th align="center" width="80">Total Slide</th>
					<th align="center" width="80">Used Slide</th>
					<th align="center" width="80">Current Slide</th>
					<th align="center" width="100">Box Name</th>
					<th align="center" width="100">Location</th>
					<th align="center" style="min-width:300px">Remarks</th>
					<th align="center">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td>
						<input type="text" data-bind="value: CaseNo" class="text-center" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: Year" class="text-center" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: CodeNo" class="text-center" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: SlideStart" class="text-center" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: SlideEnd" class="text-center" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: BoxNo" class="text-center" numonly="int" />
					</td>
					<td>
						<select data-bind="value: PCRResult">
							<option></option>
							<option value="F">PF</option>
							<option value="V">PV</option>
							<option value="M">Pf/Pv</option>
							<option value="A">PM</option>
							<option value="K">PK</option>
							<option value="O">PO</option>
							<option value="N">NMPS</option>
						</select>
					</td>
					<td>
						<select data-bind="value: Microscopy">
							<option></option>
							<option value="F">PF</option>
							<option value="V">PV</option>
							<option value="M">Pf/Pv</option>
							<option value="A">PM</option>
							<option value="K">PK</option>
							<option value="O">PO</option>
							<option value="N">NMPS</option>
						</select>
					</td>
					<td>
						<input type="text" data-bind="value: Density" class="text-center" numonly="int" />
					</td>
					<td>
						<select data-bind="value: Validate">
							<option></option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</td>
					<td>
						<input type="text" data-bind="value: TotalSlide" class="text-center" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: UsedSlide" class="text-center" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: CurrentSlide" class="text-center" numonly="int" />
					</td>
					<td>
						<input type="text" data-bind="value: BoxName" />
					</td>
					<td>
						<input type="text" data-bind="value: Location" />
					</td>
					<td>
						<input type="text" data-bind="value: Remark" />
					</td>
					<td>
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
		<button class="btn btn-success btn-sm width80" data-bind="click: addNew">New</button>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabSlideBank.js')?>