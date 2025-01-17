<style>
	.panel-body .table { width: max-content; }
	.panel-body th { border: 1px solid !important; }
	tbody input { width: 100%; }
	tbody select { width: 100%; height: 25px; }
	td { vertical-align: middle !important; }
	tbody tr:last-child td { border-bottom: 1px solid; }
	tfoot td { border: 1px solid !important; }
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
		<div class="pull-left form-inline" style="position:sticky; left:21px">
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Province</span>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">OD</span>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">HF</span>
				<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Date</span>
				<select class="form-control widthauto" data-bind="value: year, options: yearList"></select>
				<select class="form-control widthauto" data-bind="value: smt" style="border-left:none">
					<option>Semester 1</option>
					<option>Semester 2</option>
				</select>
			</div>
			<button class="btn btn-sm btn-primary width80" data-bind="click: viewClick">View</button>
		</div>
		<div class="pull-right" style="position:sticky; right:11px" data-bind="visible: app.user.prov == '' && pv() == null">
			<button class="btn btn-sm btn-success" data-bind="click: exportExcel">Export All</button>
		</div>
		<div class="pull-right" data-bind="visible: loaded" style="position:sticky; right:11px">
			<button class="btn btn-sm btn-success width80" data-bind="click: exportExcel">Export</button>
			<button class="btn btn-sm btn-success width80" data-bind="click: print">Print</button>
			<button class="btn btn-sm btn-primary width80" data-bind="click: save">Save</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<div class="bg-warning" style="border:1px solid; padding:5px 10px">
			<div class="row">
				<div class="col-xs-4">
					<div class="form-group form-inline">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Name of the controlled laboratory:</span>
							<input type="text" class="form-control" data-bind="value: hcName" disabled />
						</div>
					</div>
					<div class="form-group form-inline">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Round:</span>
							<input type="number" class="form-control width100" data-bind="value: Round" min="0" />
						</div>
					</div>
					<div class="form-inline">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Name of Microscopist:</span>
							<input type="text" class="form-control" data-bind="value: Microscopist" />
						</div>
					</div>
				</div>
				<div class="col-xs-4 form-inline">
					<div class="input-group input-group-sm">
						<span class="input-group-addon">Slide set:</span>
						<input type="text" class="form-control" data-bind="value: SlideSet" />
					</div>
				</div>
				<div class="col-xs-4">
					<div class="form-group form-inline">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Laboratory Panel testing slide:</span>
							<input type="text" class="form-control" value="CNM" disabled />
						</div>
					</div>
					<div class="form-inline">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Provided by:</span>
							<input type="text" class="form-control" data-bind="value: Provider" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<br />

		<table class="table table-bordered">
			<thead>
				<tr>
					<th align="center" valign="middle" width="30" rowspan="2">#</th>
					<th align="center" valign="middle" rowspan="2" width="70">Lam Code</th>
					<th align="center" colspan="2">Slide Result (Hospital)</th>
					<th align="center" colspan="2">Slide Result (CNM)</th>
					<th align="center" colspan="4" style="background:#DDEBF7">Detection</th>
					<th align="center" colspan="4" class="success">PF_Species</th>
					<th align="center" valign="middle" rowspan="2" style="background:#FCE4D6">Accuracy</th>
					<th align="center" valign="middle" rowspan="2" style="background:#D6DCE4">Counting</th>
				</tr>
				<tr>
					<th align="center">Microscopist</th>
					<th align="center" width="110">Parasite Count</th>
					<th align="center">Reference</th>
					<th align="center" width="110">Parasite Count</th>
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
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td>
						<input type="text" data-bind="value: LamCode" />
					</td>
					<td>
						<select type="text" data-bind="value: Microscopist,">
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
						<input type="text" data-bind="textInput: ParasiteCount1" numonly="int" />
					</td>
					<td>
						<select type="text" data-bind="value: ReferenceSlide, disable: app.user.hc != ''">
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
						<input type="text" data-bind="textInput: ParasiteCount2, disable: app.user.hc != ''" numonly="int" />
					</td>
					<td data-bind="text: $root.calcDetect($data,'DetectionA')" class="text-center" style="background:#DDEBF7"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionB')" class="text-center" style="background:#DDEBF7"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionC')" class="text-center" style="background:#DDEBF7"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionD')" class="text-center" style="background:#DDEBF7"></td>
					<td data-bind="text: $root.calcPf($data,'PfA')" class="text-center success"></td>
					<td data-bind="text: $root.calcPf($data,'PfB')" class="text-center success"></td>
					<td data-bind="text: $root.calcPf($data,'PfC')" class="text-center success"></td>
					<td data-bind="text: $root.calcPf($data,'PfD')" class="text-center success"></td>
					<td data-bind="text: $root.getAccuracy($data)" align="center" style="background:#FCE4D6"></td>
					<td data-bind="text: $root.getCounting($data)" align="center" style="background:#D6DCE4"></td>
				</tr>
			</tbody>
			<tfoot style="background-color:#FFC000">
				<tr>
					<th class="text-center" colspan="6">Total</th>
					<th class="text-center" data-bind="text: countTotal('DetectionA')"></th>
					<th class="text-center" data-bind="text: countTotal('DetectionB')"></th>
					<th class="text-center" data-bind="text: countTotal('DetectionC')"></th>
					<th class="text-center" data-bind="text: countTotal('DetectionD')"></th>
					<th class="text-center" data-bind="text: countTotal('PfA')"></th>
					<th class="text-center" data-bind="text: countTotal('PfB')"></th>
					<th class="text-center" data-bind="text: countTotal('PfC')"></th>
					<th class="text-center" data-bind="text: countTotal('PfD')"></th>
					<th class="text-center" data-bind="text: countTotal('Accuracy')"></th>
					<th class="text-center" data-bind="text: countTotal('Counting')"></th>
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
					<td align="center" data-bind="text: calcA()"></td>
					<td align="center" data-bind="text: calcB()"></td>
					<td align="center" data-bind="text: calcC()"></td>
					<td align="center" data-bind="text: calcD()"></td>
					<td align="center" data-bind="text: calcE()"></td>
					<td align="center" data-bind="text: calcF()"></td>
					<td align="center" data-bind="text: calcG()"></td>
					<td align="center" data-bind="text: calcH()"></td>
					<td align="center" data-bind="text: calcI()"></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabPanelTesting.js')?>