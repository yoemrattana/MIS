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
				<select class="form-control widthauto" data-bind="value: qt" style="border-left:none">
					<option>Q1</option>
					<option>Q2</option>
					<option>Q3</option>
					<option>Q4</option>
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
		<table class="table table-bordered table-hover">
			<thead>
				<tr fc="1">
					<th rowspan="2" align="center" valign="middle" fc="2">No</th>
					<th align="center" colspan="4" fc="3" style="border-right-color: white !important">Slide Result</th>
					<th align="center" colspan="2"></th>
					<th align="center" colspan="4" style="background:#DAEEF3">Detection</th>
					<th align="center" colspan="4" style="background:#FDE9D9">Pf Species</th>
					<th rowspan="2" valign="middle" style="background:#F2DCDB">Accuracy</th>
					<th rowspan="2" valign="middle" style="background:#C5D9F1">Counting</th>
					<th align="center" colspan="3" class="success">Quality of smear</th>
					<th align="center" colspan="3" class="success">Quality of staining</th>
					<th align="center" valign="middle" rowspan="2">Lab Staff</th>
				</tr>
				<tr fc="4">
					<th align="center" fc="5">Slide ID</th>
					<th align="center" fc="6">Collection Date</th>
					<th align="center" fc="7" colspan="2">Microscopist</th>
					<th align="center" colspan="2">Cross-checker</th>
					<th align="center" width="60" style="background:#DAEEF3">A</th>
					<th align="center" width="60" style="background:#DAEEF3">B</th>
					<th align="center" width="60" style="background:#DAEEF3">C</th>
					<th align="center" width="60" style="background:#DAEEF3">D</th>
					<th align="center" width="60" style="background:#FDE9D9">A</th>
					<th align="center" width="60" style="background:#FDE9D9">B</th>
					<th align="center" width="60" style="background:#FDE9D9">C</th>
					<th align="center" width="60" style="background:#FDE9D9">D</th>
					<th align="center" class="success" width="60">Excellent</th>
					<th align="center" class="success" width="60">Good</th>
					<th align="center" class="success" width="60">Poor</th>
					<th align="center" class="success" width="60">Excellent</th>
					<th align="center" class="success" width="60">Good</th>
					<th align="center" class="success" width="60">Poor</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true, fixedColumn: 'manual', fixedLeft: $('.menubox').outerWidth()">
				<tr>
					<td data-bind="text: $index() + 1" align="center" fc></td>
					<td data-bind="text: Logbook_ID" align="center" fc></td>
					<td data-bind="text: CollectionDate() == null ? '' : moment(CollectionDate()).displayformat()" align="center" fc></td>
					<td data-bind="text: $root.getSpecies(D1())" align="center" fc></td>
					<td data-bind="text: ParaCount" align="center" fc width="70"></td>
					<td>
						<select data-bind="value: Microscope">
							<option></option>
							<option value="F">PF</option>
							<option value="V">PV</option>
							<option value="A">PM</option>
							<option value="K">PK</option>
							<option value="O">PO</option>
							<option value="N">NMPS</option>
						</select>
					</td>
					<td width="70">
						<input type="text" data-bind="textInput: ParasiteCount" numonly="int" class="text-center" />
					</td>
					<td data-bind="text: $root.calcDetect($data,'DetectionA')" class="text-center" style="background:#DAEEF3"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionB')" class="text-center" style="background:#DAEEF3"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionC')" class="text-center" style="background:#DAEEF3"></td>
					<td data-bind="text: $root.calcDetect($data,'DetectionD')" class="text-center" style="background:#DAEEF3"></td>
					<td data-bind="text: $root.calcPf($data,'PfA')" class="text-center" style="background:#FDE9D9"></td>
					<td data-bind="text: $root.calcPf($data,'PfB')" class="text-center" style="background:#FDE9D9"></td>
					<td data-bind="text: $root.calcPf($data,'PfC')" class="text-center" style="background:#FDE9D9"></td>
					<td data-bind="text: $root.calcPf($data,'PfD')" class="text-center" style="background:#FDE9D9"></td>
					<td data-bind="text: $root.getAccuracy($data)" align="center" style="background:#F2DCDB"></td>
					<td data-bind="text: $root.getCounting($data)" align="center" style="background:#C5D9F1"></td>
					<td class="success">
						<input type="text" data-bind="textInput: SmearExcellent" numonly="int" class="text-center" />
					</td>
					<td class="success">
						<input type="text" data-bind="textInput: SmearGood" numonly="int" class="text-center" />
					</td>
					<td class="success">
						<input type="text" data-bind="textInput: SmearPoor" numonly="int" class="text-center" />
					</td>
					<td class="success">
						<input type="text" data-bind="textInput: StainingExcellent" numonly="int" class="text-center" />
					</td>
					<td class="success">
						<input type="text" data-bind="textInput: StainingGood" numonly="int" class="text-center" />
					</td>
					<td class="success">
						<input type="text" data-bind="textInput: StainingPoor" numonly="int" class="text-center" />
					</td>
					<td>
						<select data-bind="value: Staff_ID, options: $root.staffList, optionsValue: 'Staff_ID', optionsText: 'Name', optionsCaption: ''"></select>
					</td>
				</tr>
			</tbody>
			<tfoot style="background-color:#FFC000">
				<tr>
					<th class="text-center" data-bind="text: 'Total = ' + listModel().length" colspan="7"></th>
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

					<th class="text-center" data-bind="text: countTotal('SmearExcellent')"></th>
					<th class="text-center" data-bind="text: countTotal('SmearGood')"></th>
					<th class="text-center" data-bind="text: countTotal('SmearPoor')"></th>
					<th class="text-center" data-bind="text: countTotal('StainingExcellent')"></th>
					<th class="text-center" data-bind="text: countTotal('StainingGood')"></th>
					<th class="text-center" data-bind="text: countTotal('StainingPoor')"></th>
					<td></td>
				</tr>
			</tfoot>
		</table>
		<br />

		<table class="table table-bordered">
			<thead>
				<tr>
					<th align="center" rowspan="2" valign="middle" style="background:#F2DCDB">Total Slide (Last 3 Months)</th>
					<th align="center" rowspan="2" valign="middle" style="background:#F2DCDB">Total slide<br />Cross-checked</th>
					<th align="center" style="background:#F2DCDB">% Parasite detection</th>
					<th align="center" rowspan="2" valign="middle" style="background:#F2DCDB">% Species ID Agreement</th>
					<th align="center" style="background:#F2DCDB">% false positive rate</th>
					<th align="center" style="background:#F2DCDB">% false negative rate</th>
					<th align="center" style="background:#F2DCDB">% Pf_agreement with species identification</th>
					<th align="center" rowspan="2" valign="middle" style="background:#F2DCDB">% Parasite Counting</th>
					<th align="center" rowspan="2" valign="middle" style="background:#F2DCDB">% of Accuracy</th>
					<th align="center" style="background:#F2DCDB">% Sensitivity</th>
					<th align="center" style="background:#F2DCDB">% Specificity</th>
					<th align="center" colspan="3" class="success">Quality of smear</th>
					<th align="center" colspan="3" class="success">Quality of staining</th>
				</tr>
				<tr>
					<th align="center" style="background:#F2DCDB">(A+D/A+B+C+D)x100)</th>
					<th align="center" style="background:#F2DCDB">(B/A+B)x100</th>
					<th align="center" style="background:#F2DCDB">(C/C+D)x100</th>
					<th align="center" style="background:#F2DCDB">(A+D/A+B+C+D)x100)</th>
					<th align="center" style="background:#F2DCDB">(A/A+C)x100</th>
					<th align="center" style="background:#F2DCDB">(D/B+D)x100</th>

					<th align="center" class="success">Excellent</th>
					<th align="center" class="success">Good</th>
					<th align="center" class="success">Poor</th>
					<th align="center" class="success">Excellent</th>
					<th align="center" class="success">Good</th>
					<th align="center" class="success">Poor</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td align="center" data-bind="text: listModel().length"></td>
					<td align="center" data-bind="text: listModel().length"></td>
					<td align="center" data-bind="text: calcA()"></td>
					<td align="center" data-bind="text: calcB()"></td>
					<td align="center" data-bind="text: calcC()"></td>
					<td align="center" data-bind="text: calcD()"></td>
					<td align="center" data-bind="text: calcE()"></td>
					<td align="center" data-bind="text: calcF()"></td>
					<td align="center" data-bind="text: calcG()"></td>
					<td align="center" data-bind="text: calcH()"></td>
					<td align="center" data-bind="text: calcI()"></td>
					<td align="center" data-bind="text: calcSmearExcellent()"></td>
					<td align="center" data-bind="text: calcSmearGood()"></td>
					<td align="center" data-bind="text: calcSmearPoor()"></td>
					<td align="center" data-bind="text: calcStainExcellent()"></td>
					<td align="center" data-bind="text: calcStainGood()"></td>
					<td align="center" data-bind="text: calcStainPoor()"></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabCrossCheck.js')?>