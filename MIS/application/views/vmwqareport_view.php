<style>
	.scorebox { width:100px; height:100px; line-height:100px; border:1px solid black; margin:5px auto; font-size:26px; }
	.bgRed { background:#ff3f3f; }
	.bgOrange { background:orange; }
	.bgGreen { background:lime; }
</style>

<div class="panel-body" data-bind="visible: menu() == 'Supervision Schedule' && supervisionLoaded()">
	<table class="table table-bordered" data-bind="with: supervisionModel">
		<tbody>
			<tr>
				<th colspan="9" data-bind="text: 'Never Assessed (' + never.length + ')', click: () => neverOpen(!neverOpen())" class="clickable" style="background:red; color:white"></th>
			</tr>
			<tr data-bind="visible: neverOpen">
				<th>Province</th>
				<th>OD</th>
				<th>HC</th>
				<th>Village</th>
				<th align="center">Type</th>
				<th align="center">TPR</th>
				<th align="center">Previous Score</th>
				<th align="center">Last Visit Date</th>
				<th align="center">Lowest Section Score</th>
			</tr>
		</tbody>
		<tbody data-bind="foreach: never, visible: neverOpen">
			<tr>
				<td data-bind="text: Name_Prov_E"></td>
				<td data-bind="text: Name_OD_E"></td>
				<td data-bind="text: Name_Facility_E"></td>
				<td data-bind="text: Name_Vill_E"></td>
				<td align="center" data-bind="text: VMWType"></td>
				<td align="center" data-bind="text: TPR + '%'"></td>
				<td align="center" data-bind="text: TotalScore"></td>
				<td align="center" data-bind="text: VisitDate"></td>
				<td align="center" data-bind="text: LowestSectionScore"></td>
			</tr>
		</tbody>

		<tbody>
			<tr>
				<td colspan="9" style="border-left-color:white; border-right-color:white">&nbsp;</td>
			</tr>
			<tr>
				<th colspan="9" data-bind="text: 'Overdue (' + overdue.length + ')', click: () => overdueOpen(!overdueOpen())" class="clickable" style="background:darkorange; color:white"></th>
			</tr>
			<tr data-bind="visible: overdueOpen">
				<th>Province</th>
				<th>OD</th>
				<th>HC</th>
				<th>Village</th>
				<th align="center">Type</th>
				<th align="center">TPR</th>
				<th align="center">Previous Score</th>
				<th align="center">Last Visit Date</th>
				<th align="center">Lowest Section Score</th>
			</tr>
		</tbody>
		<tbody data-bind="foreach: overdue, visible: overdueOpen">
			<tr>
				<td data-bind="text: Name_Prov_E"></td>
				<td data-bind="text: Name_OD_E"></td>
				<td data-bind="text: Name_Facility_E"></td>
				<td data-bind="text: Name_Vill_E"></td>
				<td align="center" data-bind="text: VMWType"></td>
				<td align="center" data-bind="text: TPR + '%'"></td>
				<td align="center" data-bind="text: TotalScore"></td>
				<td align="center" data-bind="text: VisitDate"></td>
				<td align="center" data-bind="text: LowestSectionScore"></td>
			</tr>
		</tbody>

		<tbody>
			<tr>
				<td colspan="9" style="border-left-color:white; border-right-color:white">&nbsp;</td>
			</tr>
			<tr>
				<th colspan="9" data-bind="text: 'Next 30 days (' + next30.length + ')', click: () => next30Open(!next30Open())" class="clickable" style="background:yellow"></th>
			</tr>
			<tr data-bind="visible: next30Open">
				<th>Province</th>
				<th>OD</th>
				<th>HC</th>
				<th>Village</th>
				<th align="center">Type</th>
				<th align="center">TPR</th>
				<th align="center">Previous Score</th>
				<th align="center">Last Visit Date</th>
				<th align="center">Lowest Section Score</th>
			</tr>
		</tbody>
		<tbody data-bind="foreach: next30, visible: next30Open">
			<tr>
				<td data-bind="text: Name_Prov_E"></td>
				<td data-bind="text: Name_OD_E"></td>
				<td data-bind="text: Name_Facility_E"></td>
				<td data-bind="text: Name_Vill_E"></td>
				<td align="center" data-bind="text: VMWType"></td>
				<td align="center" data-bind="text: TPR + '%'"></td>
				<td align="center" data-bind="text: TotalScore"></td>
				<td align="center" data-bind="text: VisitDate"></td>
				<td align="center" data-bind="text: LowestSectionScore"></td>
			</tr>
		</tbody>

		<tbody>
			<tr>
				<td colspan="9" style="border-left-color:white; border-right-color:white">&nbsp;</td>
			</tr>
			<tr>
				<th colspan="9" data-bind="text: 'Next 90 days (' + next90.length + ')', click: () => next90Open(!next90Open())" class="clickable" style="background:green; color:white"></th>
			</tr>
			<tr data-bind="visible: next90Open">
				<th>Province</th>
				<th>OD</th>
				<th>HC</th>
				<th>Village</th>
				<th align="center">Type</th>
				<th align="center">TPR</th>
				<th align="center">Previous Score</th>
				<th align="center">Last Visit Date</th>
				<th align="center">Lowest Section Score</th>
			</tr>
		</tbody>
		<tbody data-bind="foreach: next90, visible: next90Open">
			<tr>
				<td data-bind="text: Name_Prov_E"></td>
				<td data-bind="text: Name_OD_E"></td>
				<td data-bind="text: Name_Facility_E"></td>
				<td data-bind="text: Name_Vill_E"></td>
				<td align="center" data-bind="text: VMWType"></td>
				<td align="center" data-bind="text: TPR + '%'"></td>
				<td align="center" data-bind="text: TotalScore"></td>
				<td align="center" data-bind="text: VisitDate"></td>
				<td align="center" data-bind="text: LowestSectionScore"></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="panel-body" data-bind="visible: menu() == 'Monitor'">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th align="center" valign="middle">Province</th>
				<th align="center" valign="middle">OD</th>
				<th align="center" valign="middle">HF</th>
				<th align="center" valign="middle">Village</th>
				<th align="center" valign="top" width="120">Section 2<br />Test</th>
				<th align="center" valign="top" width="120">Section 3<br />Treat</th>
				<th align="center" valign="top" width="120">Section 4<br />Reporting</th>
				<th align="center" valign="top" width="120">Section 5<br />Workplace<br />Assessment</th>
				<th align="center" valign="top" width="120">Section 6<br />Waste<br />Management</th>
				<th align="center" valign="top" width="120">Section 7<br />Education</th>
				<th align="center" valign="middle" width="120">Total</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: filteredMonitorList">
			<tr>
				<td data-bind="text: $root.getPVName(Code_Prov_T)"></td>
				<td data-bind="text: $root.getODName(Code_OD_T)"></td>
				<td data-bind="text: $root.getHCName(Code_Facility_T)"></td>
				<td data-bind="text: $root.getVLName(Code_Vill_T)"></td>
				<td align="center" data-bind="text: Section2 + ' / 35'"></td>
				<td align="center" data-bind="text: Section3 + ' / 35'"></td>
				<td align="center" data-bind="text: Section4 + ' / 15'"></td>
				<td align="center" data-bind="text: Section5 + ' / 5'"></td>
				<td align="center" data-bind="text: Section6 + ' / 5'"></td>
				<td align="center" data-bind="text: Section7 + ' / 5'"></td>
				<td align="center" data-bind="text: TotalScore + ' / 100'"></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="panel-body" data-bind="visible: menu() == 'Report' && reportLoaded(), with: reportModel">
	<div class="row">
		<div class="col-xs-4 text-center">
			<b>Overall Score of VMWs/MMWs</b>
			<div class="scorebox text-bold" data-bind="text: Overall, css: { bgRed: Priority <= 2, bgOrange: Priority.in(3,4,5,6), bgGreen: Priority >= 7 }"></div>
		</div>
		<div class="col-xs-4 text-center">
			<b>Expected Visits</b>
			<div class="scorebox text-bold" data-bind="text: Expected">33</div>
		</div>
		<div class="col-xs-4 text-center">
			<b>Visits Conducted</b>
			<div class="scorebox text-bold" data-bind="text: Conducted">33</div>
		</div>
	</div>
	<br />
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th align="center" valign="middle">Province</th>
				<th align="center" valign="middle">OD</th>
				<th align="center" valign="middle">HF</th>
				<th align="center" valign="middle">Village</th>
				<th align="center" valign="middle">Type</th>
				<th align="center" valign="middle">Date of Last<br />Supervision</th>
				<th align="center" valign="middle" width="94">Next Visit<br />Status</th>
				<th align="center" valign="top" width="130">Total<br />Score</th>
				<th align="center" valign="top" width="130">Section 2<br />Test (%)</th>
				<th align="center" valign="top" width="130">Section 3<br />Treat (%)</th>
				<th align="center" valign="top" width="130">Section 4<br />Reporting (%)</th>
				<th align="center" valign="top" width="130">Section 5<br />Workplace<br />Assessment (%)</th>
				<th align="center" valign="top" width="130">Section 6<br />Waste<br />Management (%)</th>
				<th align="center" valign="top" width="130">Section 7<br />Education (%)</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: Detail, fixedHeader: true">
			<tr>
				<td data-bind="text: Name_Prov_E"></td>
				<td data-bind="text: Name_OD_E"></td>
				<td data-bind="text: Name_Facility_E"></td>
				<td data-bind="text: Name_Vill_E"></td>
				<td align="center" data-bind="text: VMWType"></td>
				<td align="center" data-bind="text: VisitDate == null ? '' : moment(VisitDate).displayformat()"></td>
				<td align="center" data-bind="text: NextVisit, css: { bgRed: Priority <= 2, bgOrange: Priority.in(3,4,5,6), bgGreen: Priority >= 7 }"></td>
				<td align="center" data-bind="text: TotalScore, css: { bgRed: Priority <= 2, bgOrange: Priority.in(3,4,5,6), bgGreen: Priority >= 7 }"></td>
				<td align="center" data-bind="text: Section2, css: { bgRed: Section2 < 40, bgOrange: Section2 >= 40 && Section2 < 80, bgGreen: Section2 >= 80 }"></td>
				<td align="center" data-bind="text: Section3, css: { bgRed: Section3 < 40, bgOrange: Section3 >= 40 && Section3 < 80, bgGreen: Section3 >= 80 }"></td>
				<td align="center" data-bind="text: Section4, css: { bgRed: Section4 < 40, bgOrange: Section4 >= 40 && Section4 < 80, bgGreen: Section4 >= 80 }"></td>
				<td align="center" data-bind="text: Section5, css: { bgRed: Section5 < 40, bgOrange: Section5 >= 40 && Section5 < 80, bgGreen: Section5 >= 80 }"></td>
				<td align="center" data-bind="text: Section6, css: { bgRed: Section6 < 40, bgOrange: Section6 >= 40 && Section6 < 80, bgGreen: Section6 >= 80 }"></td>
				<td align="center" data-bind="text: Section7, css: { bgRed: Section7 < 40, bgOrange: Section7 >= 40 && Section7 < 80, bgGreen: Section7 >= 80 }"></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="panel-body" data-bind="visible: menu() == 'Dashboard' && dashboardReady()">
	<div class="clearfix form-group" style="border:1px solid #ccc">
		<div class="pull-left" style="width:50%" data-bind="with: overall">
			<div style="border:1px solid #ccc; margin:-1px; padding:20px 0">
				<h2 class="text-center">Overall Average Score</h2>
				<h2 class="text-center" data-bind="text: parseFloat(Average).toFixed(0) + '%'"></h2>
			</div>
			<div style="border:1px solid #ccc; margin:-1px; padding:20px 0">
				<h2 class="text-center">Total Never Assessed</h2>
				<h2 class="text-center" data-bind="text: NeverAssessed"></h2>
			</div>
		</div>
		<div class="pull-right" style="width:50%; padding:2px">
			<div id="chartPie" class="chartexport" style="height:300px"></div>
		</div>
	</div>

	<div class="chartbox" style="margin:30px 0">
		<div id="chartQAVisit" class="chartexport"></div>
		<div class="form-group text-center">
			<i>
				<b>Completed:</b> Number of assessments conducted.
				<b>Targeted:</b> Number of assessments budgeted.
				<b>Expected:</b> Number of assessments based on QA prioritization.
			</i>
		</div>
	</div>

	<div class="chartbox" style="margin-bottom:30px">
		<div id="chartNeverAssessed" class="chartexport"></div>
		<div class="form-group text-center">
			<i>
				<b>Never Assessed:</b> HC/VMW has not yet received supervision and needs to be assessed (Priority 0).
				<b>Overdue:</b> Based on the previous supervision result, HC/VMW should be supervised again prior to this quarter, but was supervised this quarter (Priority 1).
				<b>This quarter:</b> Based on the previous supervision, HC/VMW should be supervised again this quarter, and was supervised this quarter (Priority 2).
				<b>Future:</b> Based on previous supervision, HC/VMW does not need to be supervised again this quarter, but was supervised this quarter (Priority 3).
			</i>
		</div>
	</div>

	<div class="chartbox" style="margin-bottom:30px">
		<div id="chartTop5" class="chartexport"></div>
	</div>

	<div class="chartbox" style="margin-bottom:30px">
		<div id="chartBoxPlot" class="chartexport"></div>
	</div>

	<div class="chartbox" style="margin-bottom:30px">
		<div id="mapQA" class="chartexport" style="height:600px"></div>
	</div>

	<div class="chartbox" style="margin-bottom:30px">
		<div id="chartSupervision" class="chartexport"></div>
	</div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th align="center" width="33%">Supervisor</th>
				<th align="center" width="33%">Number of Supervisions Conducted</th>
				<th align="center">Percentage of Total Supervisions</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: supervisorList">
			<tr>
				<td align="center" data-bind="text: WorkPlace"></td>
				<td align="center" data-bind="text: Number"></td>
				<td align="center" data-bind="text: Percent + '%'"></td>
			</tr>
		</tbody>
	</table>
</div>