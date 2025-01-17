<style>
	.btnmenu { min-width:100px; }
	.table-hover thead { background-color: #9AD8ED; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left" data-bind="style: { position: app.isMobile ? '' : 'sticky', left: app.isMobile ? '' : '21px' }">
			<a href="/QMalaria/index/labo" class="btn btn-default btnmenu">Laboratory</a>
			<a href="/QMalaria/index/clinic" class="btn btn-default btnmenu">Clinical</a>
			<a href="/QMalaria/index/testing" class="btn btn-default btnmenu">CRP Testing</a>
			<a href="/QMalaria/index/sample" class="btn btn-default btnmenu">Sample Reception</a>
			<a href="/QMalaria/index/baselinedata" class="btn btn-default btnmenu">Baseline Data</a>
			<a href="/QMalaria/index/followup" class="btn btn-default btnmenu">Follow Up</a>
			<a href="/QMalaria/report1" class="btn btn-default btnmenu">Report Phase 1</a>
			<a href="/QMalaria/report2" class="btn btn-default btnmenu">Report Phase 2</a>
			<button class="btn btn-success" data-bind="click: exportAll">Export Labo &amp; Clincal</button>
		</div>
		<div class="pull-right" data-bind="style: { position: app.isMobile ? '' : 'sticky', right: app.isMobile ? '' : '21px' }">
			<a href="/Home">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>
	<div class="panel-heading clearfix">
		<div class="form-inline">
			<span class="text-bold">Province:</span>
			<span>Kampong Speu</span>

			<span class="text-bold" style="margin-left:15px">OD:</span>
			<span>Kampong Speu</span>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<h4 class="text-primary">Test Count by Month</h4>
		<table class="table table-bordered table-hover widthauto" data-bind="with: tableMonthReport">
			<thead>
				<tr>
					<th rowspan="2" valign="middle">Health Facility</th>
					<!-- ko foreach: yearMonths -->
					<th colspan="4" align="center" data-bind="text: moment($data, 'YYYYMM').format('MMM YYYY')"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<!-- ko foreach: yearMonths -->
					<th align="center" valign="middle">Labo</th>
					<th align="center" valign="middle">Clinic</th>
					<th align="center">Follow Up</th>
					<th align="center">Malaria Test</th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: hfs, fixedHeader: true, fixedColumn: 1">
				<tr>
					<td data-bind="text: name" class="text-nowrap"></td>
					<!-- ko foreach: items -->
					<td align="center" data-bind="text: labo, css: { 'success': $index() % 2 == 0 }"></td>
					<td align="center" data-bind="text: clinic, css: { 'success': $index() % 2 == 0 }"></td>
					<td align="center" data-bind="text: followup, css: { 'success': $index() % 2 == 0 }"></td>
					<td align="center" data-bind="text: test, css: { 'success': $index() % 2 == 0 }"></td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
		<br />

		<h4 class="text-primary">Missing Data of Laboratory Forms</h4>
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>HC</th>
					<th>Patient Code</th>
					<th>Missing Fields</th>
					<th align="center">Detail</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: laboList, fixedHeader: [2]">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
					<td data-bind="text: $root.getIdentityCode($data)"></td>
					<td data-bind="text: missingList.join(', ')"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<br />

		<h4 class="text-primary">Missing Data of Clinical Forms</h4>
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>HC</th>
					<th>Patient Code</th>
					<th>Missing Fields</th>
					<th align="center">Detail</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: clinicList, fixedHeader: [2]">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
					<td data-bind="text: $root.getIdentityCode($data)"></td>
					<td data-bind="text: missingList.join(', ')"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<br />

		<h4 class="text-primary">List of patients which are not in both Laboratory and Clinical</h4>
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>HC</th>
					<th>Patient Code</th>
					<th>Laboratory</th>
					<th>Clinical</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: notBothList, fixedHeader: [2]">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
					<td data-bind="text: PatientCode"></td>
					<td data-bind="text: Labo == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: Clinic == 1 ? '✔' : ''" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<br />

		<h4 class="text-primary">Checking Laboratory Measured Level and Clinical Test Result</h4>
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>HC</th>
					<th>Patient Code</th>
					<th align="center">Laboratory<br />Measured Level</th>
					<th align="center">Clinical<br />Test Result</th>
					<th align="center">Clinical<br />Detail</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: checkResultList, fixedHeader: [2]">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
					<td data-bind="text: ParticipantCode"></td>
					<td data-bind="text: CRPLevel + ' mg/L'" align="right"></td>
					<td data-bind="text: CRPResult" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

	</div>
</div>

<?=latestJs('/media/ViewModel/QMReport2.js')?>