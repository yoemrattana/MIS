<style>
	.table-hover thead { background-color: #9AD8ED; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<a href="/RDTReader/index/1" class="btn btn-default minwidth150">RDT Reader</a>
			<a href="/RDTReader/report" class="btn btn-default minwidth150">Report</a>
			<a href="/RDTReader/pcr" class="btn btn-info minwidth150">PCR</a>
		</div>
		<div class="pull-right">
			<button class="btn btn-success" data-bind="click: exportExcel" style="margin-right:30px">Export Excel</button>
			<a href="/Home">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: ready">
		<table class="table table-bordered table-hover widthauto">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th>ID</th>
					<th>Province</th>
					<th>OD</th>
					<th>HC</th>
					<th>DBS (sheet number)</th>
					<th>DBS (spot number)</th>
					<th>Reception Time</th>
					<th>Cq Screening</th>
					<th>Tm Screening</th>
					<th>Species</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<!-- ko foreach: $data -->
					<td data-bind="text: $data"></td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/RDTReaderPCR.js')?>