<style>
	.table-hover thead { background-color: #9AD8ED; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left" data-bind="style: { position: app.isMobile ? '' : 'sticky', left: app.isMobile ? '' : '21px' }">
			<a href="/RDTReader/index/1" class="btn btn-default minwidth150">RDT Reader</a>
			<a href="/RDTReader/report" class="btn btn-info minwidth150">Report</a>
			<a href="/RDTReader/pcr" class="btn btn-default minwidth150">PCR</a>
		</div>
		<div class="pull-right" data-bind="style: { position: app.isMobile ? '' : 'sticky', right: app.isMobile ? '' : '21px' }">
			<a href="/Home">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: ready">
		<div id="chartDuplicate" style="border:1px solid #ccc"></div>
		<br />

		<div id="chartUndefined" style="border:1px solid #ccc"></div>
		<br />

		<div id="chartComplete" style="border:1px solid #ccc"></div>
		<br />

		<h4 class="text-primary">Patients have scan time &gt; 15 minutes</h4>
		<table class="table table-bordered table-striped table-hover widthauto">
			<thead>
				<tr>
					<th align="center">#</th>
					<th>HC</th>
					<th>Patient ID</th>
					<th>User 1</th>
					<th>RDT Reader</th>
					<th>Minute Difference</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: tableDiff, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $root.getHCName(ParticipantCode)"></td>
					<td data-bind="text: 'AM002' + ParticipantCode"></td>
					<td data-bind="text: User1Time.format('DD-MM-YYYY HH:mm')"></td>
					<td data-bind="text: ScanTime.format('DD-MM-YYYY HH:mm')"></td>
					<td data-bind="text: MinDiff" align="right"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<br />

		<h4 class="text-primary">HF Malaria Cases and Patients Count by Month</h4>
		<table class="table table-bordered table-hover widthauto" data-bind="with: tableMonthCount">
			<thead>
				<tr>
					<th rowspan="2" valign="middle">Health Facility</th>
					<!-- ko foreach: months -->
					<th colspan="6" align="center" data-bind="text: moment($data, 'YYYYMM').format('MMM YYYY')"></th>
					<!-- /ko -->
				</tr>
				<tr>
					<!-- ko foreach: months -->
					<th align="center">Test</th>
					<th align="center">Positive</th>
					<th align="center">Pf</th>
					<th align="center">Pv</th>
					<th align="center">Mix</th>
					<th align="center" class="text-danger">RDT Study</th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: hfs, fixedHeader: true, fixedColumn: 1">
				<tr>
					<td data-bind="text: name" class="text-nowrap"></td>
					<!-- ko foreach: items -->
					<td align="center" data-bind="text: test, css: { 'success': $index() % 2 == 0 }"></td>
					<td align="center" data-bind="text: positive, css: { 'success': $index() % 2 == 0 }"></td>
					<td align="center" data-bind="text: pf, css: { 'success': $index() % 2 == 0 }"></td>
					<td align="center" data-bind="text: pv, css: { 'success': $index() % 2 == 0 }"></td>
					<td align="center" data-bind="text: mix, css: { 'success': $index() % 2 == 0 }"></td>
					<td align="center" data-bind="text: patient, css: { 'success': $index() % 2 == 0 }" class="text-danger"></td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script src="/media/highchart/dumbbell.js"></script>
<script src="/media/highchart/lollipop.js"></script>
<?=latestJs('/media/ViewModel/RDTReaderReport.js')?>