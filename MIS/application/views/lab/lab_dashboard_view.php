<style>
	td, th { vertical-align: middle !important; }
	th { text-align: center; }
	.flex { display: flex; }
	.flex > div:not(:first-child) { margin-left: 30px; }
	hr { border-top: 1px dashed black; margin-bottom: 80px; }
	#tblDash2 thead td { text-align: center; }
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
			<select class="form-control input-sm" data-bind="value: dash">
				<option value="1">Dashboard 1</option>
				<option value="2">Dashboard 2</option>
				<option value="3">Dashboard 3</option>
			</select>
			<div class="input-group input-group-sm" data-bind="visible: dash() == 1">
				<span class="input-group-addon">Year</span>
				<select class="form-control" data-bind="value: year, options: yearList"></select>
			</div>
			<div class="input-group input-group-sm" data-bind="visible: dash() >= 2">
				<span class="input-group-addon">Province</span>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: dash() == 2 ? 'All' : undefined"></select>
			</div>
			<select class="form-control input-sm" data-bind="value: training, visible: dash() == 3">
				<option value="BMMT">Basic Malaria Microscopy Training</option>
				<option value="RMMT">Refresher Malaria Microscopy Training</option>
				<option value="NCAMM">National Competency Assessment Malaria Microscopy</option>
				<option value="ECAMM">External Competency Assessment Malaria Microscopy</option>
			</select>
			<button class="btn btn-sm btn-primary width80" data-bind="click: viewClick">View</button>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: loaded1() && dash() == 1">
		<div class="text-bold font16 text-primary">Malaria Cases</div>
		<table class="table table-bordered widthauto text-center">
			<thead class="bg-thead">
				<tr>
					<th width="80">PF</th>
					<th width="80">Pv</th>
					<th width="80">Mix</th>
					<th width="80">PM</th>
					<th width="80">PO</th>
					<th width="80">PK</th>
				</tr>
			</thead>
			<tbody data-bind="with: totalCase">
				<tr>
					<td data-bind="text: Pf"></td>
					<td data-bind="text: Pv"></td>
					<td data-bind="text: Mix"></td>
					<td data-bind="text: Pm"></td>
					<td data-bind="text: Po"></td>
					<td data-bind="text: Pk"></td>
				</tr>
			</tbody>
		</table>
		<br />

		<table class="table table-bordered table-hover widthauto">
			<thead class="bg-thead">
				<tr>
					<th rowspan="3">Province</th>
					<th colspan="24" data-bind="text: reportYear"></th>
				</tr>
				<tr data-bind="foreach: Array(12)">
					<th colspan="2" data-bind="text: moment().month($index()).format('MMM')"></th>
				</tr>
				<tr data-bind="foreach: Array(12)">
					<th width="50">Total</th>
					<th width="50">Pos</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: monthlyCase, fixedHeader: true">
				<tr>
					<td data-bind="text: province"></td>
					<!-- ko foreach: months -->
					<td align="right" data-bind="text: !$root.checkMonth($index()) ? '' : $data?.Total ?? 0"></td>
					<td align="right" data-bind="text: !$root.checkMonth($index()) ? '' : $data?.Positive ?? 0"></td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
		<br />
		<br />

		<div class="text-bold font16 text-primary">Malaria QA</div>
		<div class="flex">
			<div>
				<div class="text-bold text-center">Malaria Supervision</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th rowspan="2">Province</th>
							<th colspan="4" data-bind="text: reportYear"></th>
						</tr>
						<tr>
							<th style="min-width:50px">Q1</th>
							<th style="min-width:50px">Q2</th>
							<th style="min-width:50px">Q3</th>
							<th style="min-width:50px">Q4</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: logbook, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: Name_Prov_E"></td>
							<td align="right" data-bind="text: Q1"></td>
							<td align="right" data-bind="text: Q2"></td>
							<td align="right" data-bind="text: Q3"></td>
							<td align="right" data-bind="text: Q4"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div>
				<div class="text-bold text-center">Malaria Cross Checking</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th rowspan="2">Province</th>
							<th colspan="4" data-bind="text: reportYear"></th>
						</tr>
						<tr>
							<th style="min-width:50px">Q1</th>
							<th style="min-width:50px">Q2</th>
							<th style="min-width:50px">Q3</th>
							<th style="min-width:50px">Q4</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: crosscheck, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: Name_Prov_E"></td>
							<td align="right" data-bind="text: Q1"></td>
							<td align="right" data-bind="text: Q2"></td>
							<td align="right" data-bind="text: Q3"></td>
							<td align="right" data-bind="text: Q4"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div>
				<div class="text-bold text-center">Malaria Referance Slide</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th rowspan="2">Province</th>
							<th colspan="4" data-bind="text: reportYear"></th>
						</tr>
						<tr>
							<th style="min-width:50px">Q1</th>
							<th style="min-width:50px">Q2</th>
							<th style="min-width:50px">Q3</th>
							<th style="min-width:50px">Q4</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: reference, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: Name_Prov_E"></td>
							<td align="right" data-bind="text: Q1"></td>
							<td align="right" data-bind="text: Q2"></td>
							<td align="right" data-bind="text: Q3"></td>
							<td align="right" data-bind="text: Q4"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div>
				<div class="text-bold text-center">Malaria Panel Testing</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th rowspan="2">Province</th>
							<th colspan="4" data-bind="text: reportYear"></th>
						</tr>
						<tr>
							<th class="text-nowrap">Semester 1</th>
							<th class="text-nowrap">Semester 2</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: panel, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: Name_Prov_E"></td>
							<td align="right" data-bind="text: S1"></td>
							<td align="right" data-bind="text: S2"></td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
		<br />
		<br />

		<table class="table table-bordered table-hover widthauto">
			<thead class="bg-thead">
				<tr>
					<th rowspan="2">Province</th>
					<th rowspan="2">Status</th>
					<th colspan="3">OD</th>
					<th colspan="3">Hospital</th>
					<th colspan="3">Number</th>
				</tr>
				<tr>
					<th>Number of OD</th>
					<th>OD with Microscopist</th>
					<th>Percentage</th>
					<th>Number of Hospital</th>
					<th>Hospital with Microscopist</th>
					<th>Percentage</th>
					<th>Taget Number</th>
					<th>Actual Number</th>
					<th>Percentage</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: staff, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Status"></td>
					<td align="center" data-bind="text: OD"></td>
					<td align="center" data-bind="text: StaffOD"></td>
					<td align="center" data-bind="text: (StaffOD * 100 / OD).toFixed(0) + '%'"></td>
					<td align="center" data-bind="text: RH"></td>
					<td align="center" data-bind="text: StaffRH"></td>
					<td align="center" data-bind="text: (StaffRH * 100 / RH).toFixed(0) + '%'"></td>
					<td align="center" data-bind="text: RH * 2"></td>
					<td align="center" data-bind="text: Staff"></td>
					<td align="center" data-bind="text: RH == 0 ? '0%' : (Staff * 100 / (RH * 2)).toFixed(0) + '%'"></td>
				</tr>
			</tbody>
		</table>
		<br />
		<br />

		<div class="flex">
			<div>
				<div class="text-bold text-center">Basic Malaria Microscopy Training</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th>Province</th>
							<!-- ko foreach: yearList -->
							<th colspan="4" data-bind="text: $data"></th>
							<!-- /ko -->
						</tr>
					</thead>
					<tbody data-bind="foreach: basic, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: province"></td>
							<!-- ko foreach: list -->
							<td align="right" data-bind="text: $data"></td>
							<!-- /ko -->
						</tr>
					</tbody>
				</table>
			</div>

			<div>
				<div class="text-bold text-center">Refresher Malaria Microscopy Training</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th>Province</th>
							<!-- ko foreach: yearList -->
							<th colspan="4" data-bind="text: $data"></th>
							<!-- /ko -->
						</tr>
					</thead>
					<tbody data-bind="foreach: refresher, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: province"></td>
							<!-- ko foreach: list -->
							<td align="right" data-bind="text: $data"></td>
							<!-- /ko -->
						</tr>
					</tbody>
				</table>
			</div>

			<div>
				<div class="text-bold text-center">NCAMM</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th>Province</th>
							<!-- ko foreach: yearList -->
							<th colspan="4" data-bind="text: $data"></th>
							<!-- /ko -->
						</tr>
					</thead>
					<tbody data-bind="foreach: ncamm, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: province"></td>
							<!-- ko foreach: list -->
							<td align="right" data-bind="text: $data"></td>
							<!-- /ko -->
						</tr>
					</tbody>
				</table>
			</div>

			<div>
				<div class="text-bold text-center">Pre-ECAMM</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th>Province</th>
							<!-- ko foreach: yearList -->
							<th colspan="4" data-bind="text: $data"></th>
							<!-- /ko -->
						</tr>
					</thead>
					<tbody data-bind="foreach: preecamm, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: province"></td>
							<!-- ko foreach: list -->
							<td align="right" data-bind="text: $data"></td>
							<!-- /ko -->
						</tr>
					</tbody>
				</table>
			</div>

			<div>
				<div class="text-bold text-center">ECAMM</div>
				<table class="table table-bordered table-hover">
					<thead class="bg-thead">
						<tr>
							<th>Province</th>
							<!-- ko foreach: yearList -->
							<th colspan="4" data-bind="text: $data"></th>
							<!-- /ko -->
						</tr>
					</thead>
					<tbody data-bind="foreach: ecamm, fixedHeader: true">
						<tr>
							<td class="text-nowrap" data-bind="text: province"></td>
							<!-- ko foreach: list -->
							<td align="right" data-bind="text: $data"></td>
							<!-- /ko -->
						</tr>
					</tbody>
				</table>
			</div>

		</div>
		<br />
		<br />

		<div id="chart" style="border:1px solid gray"></div>

	</div>

	<div class="panel-body" data-bind="visible: loaded2() && dash() == 2">
		<div id="D2MainChart"></div>
		<div><b>BMMT :</b> Basic Malaria Microscopy Training</div>
		<div><b>RMMT :</b> Refresher Malaria Microscopy Training</div>
		<div><b>NCAMM :</b> National Competency Assessment Malaria Microscopy</div>
		<div><b>ECAMM :</b> External Competency Assessment Malaria Microscopy</div>
		<hr />

		<table id="tblDash2" class="table table-bordered table-hover">
			<thead>
				<tr>
					<td colspan="8" style="background:#eee"></td>
					<td colspan="3" style="background:yellow">Microscopist Population</td>
					<td colspan="6" style="background:#92D14F">Basic Malaria Microscopy Training</td>
					<td colspan="6" style="background:#01B0F1">Refresher Malaria Microscopy Training</td>
					<td colspan="6" style="background:#FFC000">NCAMM</td>
					<td colspan="6" style="background:#E49EDD">ECAMM</td>
				</tr>
				<tr style="background:#155F82; color: white">
					<td>No</td>
					<td>Year</td>
					<td>Province</td>
					<td>OD</td>
					<td>Type</td>
					<td>PRH/RH</td>
					<td>Target</td>
					<td>% Target</td>
					<td>Total Number of lab technicians</td>
					<td>Micropist Population</td>
					<td>% Microscopist</td>

					<td>BMMT Eligibility</td>
					<td>% BMMT Eligibility</td>
					<td>BMMT Output</td>
					<td>% BMMT Output</td>
					<td>BMMT Outcome</td>
					<td>% BMMT Outcome</td>

					<td>RMMT Eligibility</td>
					<td>% RMMT Eligibility</td>
					<td>RMMT Output</td>
					<td>% RMMT Output</td>
					<td>RMMT Outcome</td>
					<td>% RMMT Outcome</td>

					<td>NCAMM Eligibility</td>
					<td>% NCAMM Eligibility</td>
					<td>NCAMM Output</td>
					<td>% NCAMM Output</td>
					<td>NCAMM Outcome</td>
					<td>% NCAMM Outcome</td>
					
					<td>ECAMM Eligibility</td>
					<td>% ECAMM Eligibility</td>
					<td>ECAMM Output</td>
					<td>% ECAMM Output</td>
					<td>ECAMM Outcome</td>
					<td>% ECAMM Outcome</td>
				</tr>
			</thead>
			<tbody data-bind="foreach: dash2Table, fixedHeader: true">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td align="center" data-bind="text: Year"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td align="center" data-bind="text: Type_Facility"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td align="center" data-bind="text: 2"></td>
					<td align="center" data-bind="text: (MicroPop * 100 / 2).toFixed(0) + '%'"></td>
					<td align="center" data-bind="text: LabTechnician"></td>
					<td align="center" data-bind="text: MicroPop"></td>
					<td align="center" data-bind="text: (MicroPop * 100 / LabTechnician).toFixed(0) + '%'"></td>

					<td align="center" data-bind="text: BasicEligible"></td>
					<td align="center" data-bind="text: BasicEligiblePercent + '%'"></td>
					<td align="center" data-bind="text: BasicOutput"></td>
					<td align="center" data-bind="text: BasicOutputPercent + '%'"></td>
					<td align="center" data-bind="text: BasicOutcome"></td>
					<td align="center" data-bind="text: BasicOutcomePercent + '%'"></td>
					
					<td align="center" data-bind="text: RefresherEligible"></td>
					<td align="center" data-bind="text: RefresherEligiblePercent + '%'"></td>
					<td align="center" data-bind="text: RefresherOutput"></td>
					<td align="center" data-bind="text: RefresherOutputPercent + '%'"></td>
					<td align="center" data-bind="text: RefresherOutcome"></td>
					<td align="center" data-bind="text: RefresherOutcomePercent + '%'"></td>
					
					<td align="center" data-bind="text: NCAMMEligible"></td>
					<td align="center" data-bind="text: NCAMMEligiblePercent + '%'"></td>
					<td align="center" data-bind="text: NCAMMOutput"></td>
					<td align="center" data-bind="text: NCAMMOutputPercent + '%'"></td>
					<td align="center" data-bind="text: NCAMMOutcome"></td>
					<td align="center" data-bind="text: NCAMMOutcomePercent + '%'"></td>
					
					<td align="center" data-bind="text: ECAMMEligible"></td>
					<td align="center" data-bind="text: ECAMMEligiblePercent + '%'"></td>
					<td align="center" data-bind="text: ECAMMOutput"></td>
					<td align="center" data-bind="text: ECAMMOutputPercent + '%'"></td>
					<td align="center" data-bind="text: ECAMMOutcome"></td>
					<td align="center" data-bind="text: ECAMMOutcomePercent + '%'"></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: loaded3() && dash() == 3">
		<!-- ko foreach: Array.range(1, 3) -->
		<div data-bind="attr: { id: 'D2SubChart' + $data }"></div>
		<hr />
		<!-- /ko -->
	</div>
</div>

<?=latestJs('/media/ViewModel/LabDashboard.js')?>