<div class="panel-body">
	<div id="chart" style="border:1px solid #ccc"></div>
	<br />

	<h4 class="text-primary">Duration of interpretation time which has more than 15 minutes between user 1 and user 3</h4>
	<table class="table table-bordered table-striped table-hover widthauto">
		<thead>
			<tr>
				<th align="center">#</th>
				<th>HC</th>
				<th>Patient ID</th>
				<th>User 1</th>
				<th>User 3</th>
				<th>Minute Difference</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableDiff, fixedHeader: true">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: $root.getHCName(ParticipantCode)"></td>
				<td data-bind="text: 'AM002' + ParticipantCode"></td>
				<td data-bind="text: isnot(User1, null, r => r.substr(0, 5))"></td>
				<td data-bind="text: isnot(User3, null, r => r.substr(0, 5))"></td>
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

	<h4 class="text-primary">CRFs which have the same initials</h4>
	<table class="table table-bordered table-striped table-hover widthauto">
		<thead>
			<tr>
				<th align="center">#</th>
				<th>HC</th>
				<th>Patient ID</th>
				<th>Intials User 1</th>
				<th>Intials User 2</th>
				<th>Intials User 3</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableSame, fixedHeader: true">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: $root.getHCName(ParticipantCode)"></td>
				<td data-bind="text: 'AM002' + ParticipantCode"></td>
				<td data-bind="text: User1"></td>
				<td data-bind="text: User2"></td>
				<td data-bind="text: User3"></td>
			</tr>
		</tbody>
		<tfoot data-bind="visible: app.tableFooter($element)">
			<tr>
				<td class="text-center text-warning h4" style="padding:10px">No Data</td>
			</tr>
		</tfoot>
	</table>
	<br />

	<h4 class="text-primary">Participants don't complete 5 forms</h4>
	<table class="table table-bordered table-striped table-hover widthauto">
		<thead>
			<tr>
				<th align="center">#</th>
				<th>HC</th>
				<th>Patient ID</th>
				<th>Form Baseline</th>
				<th>Form Sample</th>
				<th>Form User 1</th>
				<th>Form User 2</th>
				<th>Form User 3</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableFive, fixedHeader: true">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: $root.getHCNameByObj($data)"></td>
				<td data-bind="text: 'AM002' + Object.values($data).find(r => r != null)"></td>
				<td data-bind="text: Code1 == null ? '' : '✔'" align="center"></td>
				<td data-bind="text: Code2 == null ? '' : '✔'" align="center"></td>
				<td data-bind="text: Code3 == null ? '' : '✔'" align="center"></td>
				<td data-bind="text: Code4 == null ? '' : '✔'" align="center"></td>
				<td data-bind="text: Code5 == null ? '' : '✔'" align="center"></td>
			</tr>
		</tbody>
		<tfoot data-bind="visible: app.tableFooter($element)">
			<tr>
				<td class="text-center text-warning h4" style="padding:10px">No Data</td>
			</tr>
		</tfoot>
	</table>
	<br />

	<h4 class="text-primary">Summary of Sample</h4>
	<table class="table table-bordered table-striped table-hover widthauto">
		<thead>
			<tr>
				<th rowspan="2" align="center" valign="middle">#</th>
				<th rowspan="2" valign="middle">HC</th>
				<th rowspan="2" width="70" valign="middle">Negative</th>
				<th colspan="4" align="center">Positive</th>
			</tr>
			<tr>
				<th width="70" align="center">Pf</th>
				<th width="70" align="center">Pv</th>
				<th width="70" align="center">Mix</th>
				<th width="70" align="center">Total</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableSummary, fixedHeader: true">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: $root.getHCName(Code)"></td>
				<td data-bind="text: Negative" align="center"></td>
				<td data-bind="text: Pf" align="center"></td>
				<td data-bind="text: Pv" align="center"></td>
				<td data-bind="text: Mix" align="center"></td>
				<td data-bind="text: Positive" align="center"></td>
			</tr>
		</tbody>
		<tfoot data-bind="with: tableSummary">
			<tr>
				<th align="center" colspan="2">Grand Total</th>
				<th align="center" data-bind="text: $data.sum(r => r.Negative)"></th>
				<th align="center" data-bind="text: $data.sum(r => r.Pf)"></th>
				<th align="center" data-bind="text: $data.sum(r => r.Pv)"></th>
				<th align="center" data-bind="text: $data.sum(r => r.Mix)"></th>
				<th align="center" data-bind="text: $data.sum(r => r.Positive)"></th>
			</tr>
		</tfoot>
	</table>
	<br />

	<h4 class="text-primary">Malaria RDT used while expired</h4>
	<table class="table table-bordered table-striped table-hover widthauto">
		<thead>
			<tr>
				<th align="center">#</th>
				<th>HC</th>
				<th>Patient ID</th>
				<th>Testing Date</th>
				<th>Expiration Date</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableExpire, fixedHeader: true">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: $root.getHCName(ParticipantCode)"></td>
				<td data-bind="text: 'AM002' + ParticipantCode"></td>
				<td data-bind="text: moment(TestingDate).format('DD-MM-YYYY')" align="center"></td>
				<td data-bind="text: moment(Expiration).format('DD-MM-YYYY')" align="center"></td>
			</tr>
		</tbody>
		<tfoot data-bind="visible: app.tableFooter($element)">
			<tr>
				<td class="text-center text-warning h4" style="padding:10px">No Data</td>
			</tr>
		</tfoot>
	</table>
	<br />

	<h4 class="text-primary">Potential invalid results interpreted by the HCW</h4>
	<table class="table table-bordered table-striped table-hover widthauto">
		<thead>
			<tr>
				<th align="center" width="30">#</th>
				<th class="minwidth150">HC</th>
				<th width="120">Patient ID</th>
				<th>Form</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableInvalid, fixedHeader: true">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: $root.getHCName(ParticipantCode)"></td>
				<td data-bind="text: 'AM002' + ParticipantCode"></td>
				<td data-bind="text: Form"></td>
			</tr>
		</tbody>
		<tfoot data-bind="visible: app.tableFooter($element)">
			<tr>
				<td class="text-center text-warning h4" style="padding:10px">No Data</td>
			</tr>
		</tfoot>
	</table>
	<br />

	<h4 class="text-primary">Non eligible patients were recruited (DOB/Under age)</h4>
	<table class="table table-bordered table-striped table-hover widthauto">
		<thead>
			<tr>
				<th align="center">#</th>
				<th>HC</th>
				<th>Patient ID</th>
				<th>Date of Birth</th>
				<th>Testing Date</th>
				<th>Age</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableAge, fixedHeader: true">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: $root.getHCName(ParticipantCode)"></td>
				<td data-bind="text: 'AM002' + ParticipantCode"></td>
				<td data-bind="text: moment(DateOfBirth).format('DD-MM-YYYY')" align="center"></td>
				<td data-bind="text: moment(DateOfAssessment).format('DD-MM-YYYY')" align="center"></td>
				<td data-bind="text: Age" align="center"></td>
			</tr>
		</tbody>
		<tfoot data-bind="visible: app.tableFooter($element)">
			<tr>
				<td class="text-center text-warning h4" style="padding:10px">No Data</td>
			</tr>
		</tfoot>
	</table>
	<br />

	<h4 class="text-primary">Interpretations non-concordant by the user 3</h4>
	<table class="table table-bordered table-striped table-hover widthauto">
		<thead>
			<tr>
				<th align="center" width="30">#</th>
				<th class="minwidth150">HC</th>
				<th width="120">Patient ID</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableNonconcordant, fixedHeader: true">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: $root.getHCName(ParticipantCode)"></td>
				<td data-bind="text: 'AM002' + ParticipantCode"></td>
			</tr>
		</tbody>
		<tfoot data-bind="visible: app.tableFooter($element)">
			<tr>
				<td class="text-center text-warning h4" style="padding:10px">No Data</td>
			</tr>
		</tfoot>
	</table>
	<br />
</div>

<?=latestJs('/media/ViewModel/CRFReport.js')?>