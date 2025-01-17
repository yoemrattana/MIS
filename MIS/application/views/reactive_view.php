<style>
	.search-area { background: #eee; border: 1px solid #ccc; padding: 4px 4px 2px 4px; }
	.headbox { color: white; padding: 2px 5px; font-size: 14px; }
	.headbox * { font-size: 14px; color: white; }
	.headboxblack { padding: 2px 5px; font-size: 14px; }
	.headboxblack * { font-size: 14px; }
	.tbl td { border: 1px solid black !important; }
	.tblfill tr { height: 20px; vertical-align: bottom; }
	.checkfont { font-size: 14px; }
	.underscore { display: inline-block; border-bottom: 1px solid black; text-align: center; }
	.blacksection { background-color: black; color: white; padding: 2px 5px; font-size: 14px; }
	.blacksection span { font-size: 14px; }
	.gray { background-color: lightgray; }
	.bold { font-weight: bold; }
</style>

<div class="panel panel-default" style="display:none" data-bind="visible: true">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 text-bold lh26">Reactive Cases</div>
		<div class="pull-right">
			<button class="btn btn-danger btn-sm width100" data-bind="click: deleteReport, visible: app.user.permiss['Health Center Data'].contain('Delete')">Delete</button>
			<button class="btn btn-default btn-sm width100" onclick="window.close()">Back</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: detailModel() != null">
		<div style="border:1px solid black; width:900px">
			<!-- ko with: detailModel -->
			<div class="blacksection">
				<span>INDEX CASE</span>
				<span style="margin-left:100px; padding-right:5px">CASE ID #</span>
				<span style="width:150px; display:inline-block; border-bottom:1px solid white" class="text-center"
					data-bind="text: Passive_Case_Id"></span>
				<span style="margin-left:70px">IF NOT AVAILABLE FILL THE FOLLOWING:</span>
			</div>
			<table class="tblfill" style="margin:0 5px">
				<tr>
					<td width="130">Date of notification</td>
					<td width="150">
						<div class="col-xs-6 no-padding">DD/MM/YY</div>
						<div class="col-xs-6 no-padding text-right" style="text-decoration:underline"
							data-bind="text: isempty(Date_Of_Nof,'&emsp;/&emsp;/&emsp;')"></div>
					</td>
					<td width="30"></td>
					<td width="100">Date of birth</td>
					<td width="150">
						<div class="col-xs-6 no-padding">DD/MM/YY</div>
						<div class="col-xs-6 no-padding text-right" style="text-decoration:underline"
							data-bind="text: isempty(Date_Of_Birth,'&emsp;/&emsp;/&emsp;')"></div>
					</td>
				</tr>
				<tr>
					<td>First name</td>
					<td style="border-bottom:1px solid black" class="text-center" data-bind="text: First_Name"></td>
					<td></td>
					<td>Citizen ID #</td>
					<td style="border-bottom:1px solid black" class="text-center" data-bind="text: Citizen_Id"></td>
				</tr>
				<tr>
					<td>Last name</td>
					<td style="border-bottom:1px solid black" class="text-center" data-bind="text: Last_Name"></td>
					<td></td>
					<td>Telephone #</td>
					<td style="border-bottom:1px solid black" class="text-center" data-bind="text: Telephone"></td>
				</tr>
				<tr>
					<td>Age (Year)</td>
					<td style="border-bottom:1px solid black" class="text-center" data-bind="text: Age"></td>
					<td></td>
					<td>Gender</td>
					<td style="border-bottom:1px solid black" class="text-center" data-bind="text: Gender"></td>
				</tr>
			</table>
			<table class="tblfill" style="margin:0px 5px 5px 5px">
				<tr>
					<td width="130">Village of residence</td>
					<td width="150" style="border-bottom:1px solid black" class="text-center" data-bind="text: Name_Vill_E"></td>
					<td width="30"></td>
					<td width="100">OD</td>
					<td width="150" style="border-bottom:1px solid black" class="text-center" data-bind="text: Name_OD_E"></td>
					<td width="30"></td>
					<td width="60">Province</td>
					<td width="150" style="border-bottom:1px solid black" class="text-center" data-bind="text: Name_Prov_E"></td>
				</tr>
			</table>
			<div style="background-color:black;height:1px"></div>
			<table class="tblfill" style="margin:0 5px">
				<tr>
					<td width="130">Date of investigation</td>
					<td width="150">
						<div class="col-xs-6 no-padding">DD/MM/YY</div>
						<div class="col-xs-6 no-padding text-right" style="text-decoration:underline"
							data-bind="text: isempty(Date_Of_Invest,'&emsp;/&emsp;/&emsp;')"></div>
					</td>
					<td width="30"></td>
					<td width="100">Job title</td>
					<td width="150" style="border-bottom:1px solid black" class="text-center" data-bind="text: Invest_Job_Title"></td>
				</tr>
				<tr>
					<td>Conducted by</td>
					<td style="border-bottom:1px solid black" class="text-center" data-bind="text: Conducted_By"></td>
					<td></td>
					<td>Telephone #</td>
					<td style="border-bottom:1px solid black" class="text-center" data-bind="text: Invest_Telephone"></td>
				</tr>
			</table>
			<div style="margin:8px 5px 5px 5px">
				<span style="padding-right:5px">Village of residence if L1</span>
				<span class="checkfont" data-bind="text: L1=='1'?'☑':'☐'">☐</span>
				<span style="padding:0 10px">Name of other village in catchment area if L2</span>
				<span style="width:150px; border-bottom:1px solid black; display:inline-block; text-align:center" data-bind="text: L2"></span>
			</div>
			<div class="blacksection">
				Section 1: PRESUMPTIVE TREATMENT OF INDEX HOUSEHOLD MEMBERS
			</div>
			<div style="margin:10px 5px 5px 5px">
				<span>Members treated</span>
				<span style="width:50px; display:inline-block; border-bottom:1px solid black" class="text-center" data-bind="text: Members_Treated"></span>
				<span style="padding-left:10px">Members refused</span>
				<span style="width:50px; display:inline-block; border-bottom:1px solid black" class="text-center" data-bind="text: Members_Refused"></span>
				<span style="padding-left:10px">Members absent</span>
				<span style="width:50px; display:inline-block; border-bottom:1px solid black" class="text-center" data-bind="text: Members_Absent"></span>
			</div>
			<!-- /ko -->
			<div class="blacksection">
				Section 2: SCREENING OF 20 NEIGHBOURING HOUSEHOLDS
			</div>
			<div>
				<span style="margin-left: 5px; margin-right:30px">PAGE #</span>
				<span style="margin-right:30px">Take new form for each batch of 20 individuals </span>
				<span>Person#: start from 1 for each new HH</span>
			</div>
			<table class="table table-bordered tbl">
				<thead>
					<tr class="text-center">
						<td rowspan="2">HH#</td>
						<td colspan="3">Person</td>
						<td colspan="3">Reason for not tested (✓)</td>
						<td colspan="2">Tested (✓)</td>
						<td colspan="5">Risk Factors (✓)</td>
					</tr>
					<tr>
						<td align="center">#</td>
						<td align="center">Age</td>
						<td align="center">Sex</td>
						<td align="center">Absent</td>
						<td align="center">Refused</td>
						<td align="center">No risk</td>
						<td align="center" class="gray bold">P</td>
						<td align="center">N</td>
						<td align="center">Fever</td>
						<td align="center">Forest</td>
						<td align="center">Travel</td>
						<td align="center">History</td>
						<td align="center">Relative</td>
					</tr>
				</thead>
				<tbody class="text-center">
					<!-- ko foreach: list -->
					<tr>
						<td data-bind="text: House_number"></td>
						<td data-bind="text: Present"></td>
						<td data-bind="text: Person_Age"></td>
						<td data-bind="text: Person_Gender == '1' ? 'Male' : 'Female'"></td>
						<td data-bind="text: Absent == 'P' ? '✓' : ''">Absent</td>
						<td data-bind="text: Refused == 'P' ? '✓' : ''">Refused</td>
						<td data-bind="text: No_Risk == 'P' ? '✓' : ''">No risk</td>
						<td class="gray bold" data-bind="text: Tested == 'P' ? '✓' : ''">P</td>
						<td data-bind="text: Tested == 'N' ? '✓' : ''">N</td>
						<td data-bind="text: Fever == 'P' ? '✓' : ''">Fever</td>
						<td data-bind="text: Forest == 'P' ? '✓' : ''">Forest</td>
						<td data-bind="text: Travel == 'P' ? '✓' : ''">Travel</td>
						<td data-bind="text: History == 'P' ? '✓' : ''">History</td>
						<td data-bind="text: Relative == 'P' ? '✓' : ''">Relative</td>
					</tr>
					<!-- /ko -->
					<!-- ko foreach: Array(list().length >= 20 ? 0 : 20 - list().length) -->
					<tr>
						<td>&nbsp;</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="gray"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<!-- /ko -->
				</tbody>
				<tfoot>
					<tr style="border:2px solid black" class="text-center">
						<td>Total</td>
						<td data-bind="text: list().length"></td>
						<td></td>
						<td></td>
						<td class="bold" data-bind="text: list().sum(r => r.Absent == 'P' ? 1 : 0)"></td>
						<td class="bold" data-bind="text: list().sum(r => r.Refused == 'P' ? 1 : 0)"></td>
						<td class="bold" data-bind="text: list().sum(r => r.No_Risk == 'P' ? 1 : 0)"></td>
						<td class="gray bold" data-bind="text: list().sum(r => r.Tested == 'P' ? 1 : 0)"></td>
						<td class="bold" data-bind="text: list().sum(r => r.Tested == 'N' ? 1 : 0)"></td>
						<td class="bold" data-bind="text: list().sum(r => r.Fever == 'P' ? 1 : 0)"></td>
						<td class="bold" data-bind="text: list().sum(r => r.Forest == 'P' ? 1 : 0)"></td>
						<td class="bold" data-bind="text: list().sum(r => r.Travel == 'P' ? 1 : 0)"></td>
						<td class="bold" data-bind="text: list().sum(r => r.History == 'P' ? 1 : 0)"></td>
						<td class="bold" data-bind="text: list().sum(r => r.Relative == 'P' ? 1 : 0)"></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Reactive.js')?>