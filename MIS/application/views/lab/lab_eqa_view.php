<style>
	.panel-body > table th { border: 1px solid !important; }
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
			<button class="btn btn-sm btn-success width80" data-bind="click: print">Print</button>
			<button class="btn btn-sm btn-primary width80" data-bind="click: save">Save</button>
		</div>
	</div>
	<div class="panel-body" data-bind="with: editModel">
		<div class="form-inline form-group">
			<div class="text-center" style="background:#00B0F0">INDIVIDUAL RESULTS SHEET (RS1)</div>
			<div>Survey No:</div>
			<div class="form-group">
				<input type="text" class="form-control" data-bind="value: Survey" />
			</div>
			<div>Microscopist Name:</div>
			<div class="form-group">
				<input type="text" class="form-control" data-bind="value: Name" />
			</div>
			<div>Position:</div>
			<div class="form-group">
				<input type="text" class="form-control" data-bind="value: Position" />
			</div>
			<div>Laboratory Number:</div>
			<div class="form-group">
				<input type="text" class="form-control" data-bind="value: LabNum" />
			</div>
			<div>Date slides examined (dd-mm-yyyy):</div>
			<div class="form-group relative">
				<input type="text" class="form-control" data-bind="datePicker: ExaminedDate, dataType: 'string', showClear: true" />
			</div>
		</div>

		<table class="table table-bordered widthauto">
			<thead>
				<tr>
					<th colspan="5" align="center">Microscopist</th>
					<th colspan="2" align="center">EQA</th>
					<th colspan="4" style="background:#DDEBF7" align="center">Detection</th>
					<th colspan="4" class="success" align="center">PF Species</th>
					<th rowspan="2" style="background:#FCE4D6" align="center" valign="middle">Accuracy</th>
					<th rowspan="2" style="background:#D6DCE4" align="center" valign="middle">Counting</th>
				</tr>
				<tr>
					<th align="center" width="80">Slide No.</th>
					<th align="center">SSP.</th>
					<th align="center" width="100">Number of Parasites</th>
					<th align="center" width="100">Number of WBCs</th>
					<th align="center" width="80">Counting</th>
					<th align="center">SSP.</th>
					<th align="center" width="80">Counting</th>
					<th align="center" width="60" style="background:#DDEBF7">A</th>
					<th align="center" width="60" style="background:#DDEBF7">B</th>
					<th align="center" width="60" style="background:#DDEBF7">C</th>
					<th align="center" width="60" style="background:#DDEBF7">D</th>
					<th align="center" width="60" class="success">A</th>
					<th align="center" width="60" class="success">B</th>
					<th align="center" width="60" class="success">C</th>
					<th align="center" width="60" class="success">D</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: $root.listModel">
				<tr>
					<td>
						<input type="text" class="text-center" data-bind="value: Slide" />
					</td>
					<td>
						<select data-bind="value: SSP_Microscopist">
							<option></option>
							<option value="F">PF</option>
							<option value="V">PV</option>
							<option value="A">PM</option>
							<option value="O">PO</option>
							<option value="K">PK</option>
							<option value="N">NMPS</option>
						</select>
					</td>
					<td>
						<input type="text" class="text-center" data-bind="value: Parasite" numonly="int" />
					</td>
					<td>
						<input type="text" class="text-center" data-bind="value: WBC" numonly="int" />
					</td>
					<td>
						<input type="text" class="text-center" data-bind="textInput: Counting_Microscopist" numonly="int" />
					</td>
					<td>
						<select data-bind="value: SSP_EQA">
							<option></option>
							<option value="F">PF</option>
							<option value="V">PV</option>
							<option value="A">PM</option>
							<option value="O">PO</option>
							<option value="K">PK</option>
							<option value="N">NMPS</option>
						</select>
					</td>
					<td>
						<input type="text" class="text-center" data-bind="textInput: Counting_EQA" numonly="int" />
					</td>
					<td data-bind="text: $root.calcDetect($data,'DetectionA')" align="center" style="background:#DDEBF7"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionB')" align="center" style="background:#DDEBF7"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionC')" align="center" style="background:#DDEBF7"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionD')" align="center" style="background:#DDEBF7"></td>
					<td data-bind="text: $root.calcPf($data,'PfA')" align="center" class="success"></td>
					<td data-bind="text: $root.calcPf($data,'PfB')" align="center" class="success"></td>
					<td data-bind="text: $root.calcPf($data,'PfC')" align="center" class="success"></td>
					<td data-bind="text: $root.calcPf($data,'PfD')" align="center" class="success"></td>
					<td data-bind="text: $root.getAccuracy($data)" align="center" style="background:#FCE4D6"></td>
					<td data-bind="text: $root.getCounting($data)" align="center" style="background:#D6DCE4"></td>
				</tr>
			</tbody>
			<tfoot style="background-color:#FFC000">
				<tr>
					<th class="text-center" colspan="7">Total</th>
					<th class="text-center" data-bind="text: $root.countTotal('DetectionA')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('DetectionB')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('DetectionC')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('DetectionD')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('PfA')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('PfB')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('PfC')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('PfD')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('Accuracy')"></th>
					<th class="text-center" data-bind="text: $root.countTotal('Counting')"></th>
				</tr>
			</tfoot>
		</table>
		<br />

		<table class="table table-bordered">
			<thead style="background-color:#FCE4D6">
				<tr>
					<th align="center">% Parasite detection</th>
					<th align="center" rowspan="2" valign="middle">% Species ID Agreement</th>
					<th align="center">% false positive rate</th>
					<th align="center">% false negative rate</th>
					<th align="center">% Pf_agreement with species identification</th>
					<th align="center" rowspan="2" valign="middle">% Parasite Counting</th>
					<th align="center" rowspan="2" valign="middle">% of Accuracy</th>
					<th align="center">% Sensitivity</th>
					<th align="center">% Specificity</th>
				</tr>
				<tr>
					<th align="center">(A+D/A+B+C+D)x100)</th>
					<th align="center">(B/A+B)x100</th>
					<th align="center">(C/C+D)x100</th>
					<th align="center">(A+D/A+B+C+D)x100)</th>
					<th align="center">(A/A+C)x100</th>
					<th align="center">(D/B+D)x100</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td align="center" data-bind="text: $root.calcA()"></td>
					<td align="center" data-bind="text: $root.calcB()"></td>
					<td align="center" data-bind="text: $root.calcC()"></td>
					<td align="center" data-bind="text: $root.calcD()"></td>
					<td align="center" data-bind="text: $root.calcE()"></td>
					<td align="center" data-bind="text: $root.calcF()"></td>
					<td align="center" data-bind="text: $root.calcG()"></td>
					<td align="center" data-bind="text: $root.calcH()"></td>
					<td align="center" data-bind="text: $root.calcI()"></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabEQA.js')?>