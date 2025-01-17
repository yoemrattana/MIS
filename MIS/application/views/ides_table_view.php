<!-- ko with: table -->
<div class="panel-heading clearfix relative" data-bind="visible: $root.menu() == 'Tables'">
	<div class="pull-left">
		<div class="inlineblock">
			<div class="text-bold">Table</div>
			<select class="form-control" data-bind="value: filter">
				<option>iDES Summary</option>
				<option>iDES Sites</option>
				<option>Case Notification</option>
				<option>Case Enrollment</option>
				<option>Follow-up</option>
			</select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">From</div>
			<input type="text" class="form-control text-center width80" data-bind="datePicker: mf, format: 'MMM YYYY', minDate: '2022-01-01'" />
		</div>
		<div class="inlineblock">
			<div class="text-bold">To</div>
			<input type="text" class="form-control text-center width80" data-bind="datePicker: mt, format: 'MMM YYYY', minDate: '2022-01-01'" />
		</div>
		<div class="inlineblock">
			<div class="text-bold">Province</div>
			<select class="form-control" data-bind="value: pv, options: $root.pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">OD</div>
			<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">HC</div>
			<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock">
			<div class="text-bold">VMW/MMW</div>
			<select class="form-control minwidth100" data-bind="value: vl, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="inlineblock" data-bind="visible: filter().in('Case Notification','Follow-up')">
			<div class="text-bold">iDES Site Type</div>
			<select class="form-control width100" data-bind="value: site">
				<option value="">All</option>
				<option>PRH</option>
				<option>RH</option>
				<option>HC</option>
				<option>VMW</option>
				<option>MMW</option>
			</select>
		</div>
		<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
	</div>
</div>

<div class="panel-body" data-bind="visible: $root.menu() == 'Tables' && loaded()">
	<!-- ko if: filter() == 'iDES Summary' -->
	<h4 class="text-primary">Table 1</h4>
	<table class="table table-bordered table-striped table-hover widthauto text-nowrap">
		<thead class="bg-thead">
			<tr>
				<th rowspan="2">Place</th>
				<th align="center">Positive</th>
				<th align="center">Eligible iDES</th>
				<th align="center">In iDES Site</th>
				<th align="center">iDES Enrolled</th>
				<th align="center">% iDES Enrolled</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tblSummary, fixedHeader: true">
			<tr data-bind="css: {'text-bold': $index() == 0}">
				<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place" class="text-nowrap"></td>
				<td data-bind="text: Positive" align="center"></td>
				<td data-bind="text: Eligible" align="center"></td>
				<td data-bind="text: Eligible" align="center"></td>
				<td data-bind="text: iDes" align="center"></td>
				<td data-bind="text: Eligible == 0 ? '-' : (iDes * 100 / Eligible).toFixed(0) + '%'" align="center"></td>
			</tr>
		</tbody>
		<tfoot data-bind="visible: app.tableFooter($element)">
			<tr>
				<td class="text-center text-warning h4" style="padding:10px">No Data</td>
			</tr>
		</tfoot>
	</table>
	<!-- /ko -->

	<!-- ko if: filter() == 'iDES Sites' -->
	<div style="display:flex; align-items:flex-start">
		<div>
			<h4 class="text-primary">Table 2</h4>
			<table class="table table-bordered table-striped widthauto">
				<thead class="bg-thead">
					<tr>
						<th align="center" colspan="5">Distribution of iDES Sites</th>
					</tr>
					<tr>
						<th align="center">Name of Province</th>
						<th align="center">Name of OD</th>
						<th align="center">Name PRH, RH, and HC</th>
						<th align="center">Name of VMW/MMW</th>
						<th align="center">Start Enrollment of iDES cases</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: tblSite, fixedHeader: true">
					<tr>
						<td data-bind="text: Name_Prov_E"></td>
						<td data-bind="text: Name_OD_E"></td>
						<td data-bind="text: Name_Facility_E"></td>
						<td data-bind="text: Name_Vill_E"></td>
						<td data-bind="text: StartDate == null ? '' : moment(StartDate).format('MMM YYYY')" align="center"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div style="margin-left:50px">
			<h4 class="text-primary">Table 3</h4>
			<table class="table table-bordered widthauto">
				<thead class="bg-thead">
					<tr>
						<th rowspan="2" align="center">iDES Site Type</th>
						<th align="center" data-bind="attr: { colspan: tblSiteCount().distinct('Year').length }">No. of iDES Sites</th>
						<th colspan="2" rowspan="2" align="center">iDES Sites reporting cases in 2024</th>
					</tr>
					<tr data-bind="foreach: tblSiteCount().distinct('Year')">
						<th align="center" data-bind="text: Year"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Province</td>
						<!-- ko foreach: tblSiteCount -->
						<td align="center" data-bind="text: Province"></td>
						<!-- /ko -->
						<th rowspan="2" align="center" class="bg-thead">No.</th>
						<th rowspan="2" align="center" class="bg-thead">%</th>
					</tr>
					<tr>
						<td>OD</td>
						<!-- ko foreach: tblSiteCount -->
						<td align="center" data-bind="text: OD"></td>
						<!-- /ko -->
					</tr>
					<tr>
						<td>PRH</td>
						<!-- ko foreach: tblSiteCount -->
						<td align="center" data-bind="text: PRH"></td>
						<td align="center" data-bind="text: ReportedPRH, visible: Year == 2024"></td>
						<td align="center" data-bind="text: (ReportedPRH * 100 / PRH).toFixed(0) + '%', visible: Year == 2024"></td>
						<!-- /ko -->
					</tr>
					<tr>
						<td>RH</td>
						<!-- ko foreach: tblSiteCount -->
						<td align="center" data-bind="text: RH"></td>
						<td align="center" data-bind="text: ReportedRH, visible: Year == 2024"></td>
						<td align="center" data-bind="text: (ReportedRH * 100 / RH).toFixed(0) + '%', visible: Year == 2024"></td>
						<!-- /ko -->
					</tr>
					<tr>
						<td>HC</td>
						<!-- ko foreach: tblSiteCount -->
						<td align="center" data-bind="text: HC"></td>
						<td align="center" data-bind="text: ReportedHC, visible: Year == 2024"></td>
						<td align="center" data-bind="text: (ReportedHC * 100 / HC).toFixed(0) + '%', visible: Year == 2024"></td>
						<!-- /ko -->
					</tr>
					<tr>
						<td>VMW</td>
						<!-- ko foreach: tblSiteCount -->
						<td align="center" data-bind="text: VMW"></td>
						<td align="center" data-bind="text: ReportedVMW, visible: Year == 2024"></td>
						<td align="center" data-bind="text: (ReportedVMW * 100 / VMW).toFixed(0) + '%', visible: Year == 2024"></td>
						<!-- /ko -->
					</tr>
					<tr>
						<td>MMW</td>
						<!-- ko foreach: tblSiteCount -->
						<td align="center" data-bind="text: MMW"></td>
						<td align="center" data-bind="text: ReportedMMW, visible: Year == 2024"></td>
						<td align="center" data-bind="text: (ReportedMMW * 100 / MMW).toFixed(0) + '%', visible: Year == 2024"></td>
						<!-- /ko -->
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th>Total</th>
						<!-- ko foreach: tblSiteCount -->
						<th align="center" data-bind="text: PRH + RH + HC + VMW + MMW"></th>
						<th align="center" data-bind="text: ReportedPRH + ReportedRH + ReportedHC + ReportedVMW + ReportedMMW, visible: Year == 2024"></th>
						<th align="center" data-bind="text: ((ReportedPRH + ReportedRH + ReportedHC + ReportedVMW + ReportedMMW) * 100 / (PRH + RH + HC + VMW + MMW)).toFixed(0) + '%', visible: Year == 2024"></th>
						<!-- /ko -->
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<!-- /ko -->

	<!-- ko if: filter() == 'Case Notification' -->
	<h4 class="text-primary">Table 4</h4>
	<table class="table table-bordered widthauto" data-bind="with: tblCase">
		<thead class="bg-thead">
			<tr>
				<th align="center" colspan="2">Type Province</th>
				<th>Grand Total</th>
				<th>iDES Province</th>
				<th>Non-iDES Province</th>
			</tr>
			<tr>
				<th align="center" colspan="2">No. of provinces</th>
				<td align="right" data-bind="text: Province"></td>
				<td align="right" data-bind="text: Province_iDES"></td>
				<td align="right" data-bind="text: Province - Province_iDES"></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th align="center" rowspan="7" class="bg-thead">Total Cases Notified</th>
				<th align="center" class="bg-thead">Pf</th>
				<td align="right" data-bind="text: Pf"></td>
				<td align="right" data-bind="text: Pf_iDES"></td>
				<td align="right" data-bind="text: Pf - Pf_iDES"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pv</th>
				<td align="right" data-bind="text: Pv"></td>
				<td align="right" data-bind="text: Pv_iDES"></td>
				<td align="right" data-bind="text: Pv - Pv_iDES"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Mix</th>
				<td align="right" data-bind="text: Mix"></td>
				<td align="right" data-bind="text: Mix_iDES"></td>
				<td align="right" data-bind="text: Mix - Mix_iDES"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pm</th>
				<td align="right" data-bind="text: Pm"></td>
				<td align="right" data-bind="text: Pm_iDES"></td>
				<td align="right" data-bind="text: Pm - Pm_iDES"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Po</th>
				<td align="right" data-bind="text: Po"></td>
				<td align="right" data-bind="text: Po_iDES"></td>
				<td align="right" data-bind="text: Po - Po_iDES"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pk</th>
				<td align="right" data-bind="text: Pk"></td>
				<td align="right" data-bind="text: Pk_iDES"></td>
				<td align="right" data-bind="text: Pk - Pk_iDES"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Total</th>
				<td align="right" data-bind="text: Total"></td>
				<td align="right" data-bind="text: Total_iDES"></td>
				<td align="right" data-bind="text: Total - Total_iDES"></td>
			</tr>
		</tbody>
	</table>
	<br />

	<h4 class="text-primary">Table 5</h4>
	<table class="table table-bordered widthauto">
		<thead class="bg-thead">
			<tr>
				<th colspan="5"></th>
				<th colspan="12" align="center">iDES Provinces</th>
				<th colspan="7" align="center">Non-iDES Provinces</th>
			</tr>
			<tr>
				<th align="center" rowspan="2" colspan="2">Type of Site</th>
				<th align="center" rowspan="2">Grand Total</th>
				<th align="center" rowspan="2">% of Cases Notified<br>from iDES Sites</th>
				<th align="center" rowspan="2">Total Cases</th>
				<th align="center" colspan="6">iDES Sites</th>
				<th align="center" colspan="6">Non-iDES Sites</th>
				<th align="center" colspan="7">Non-iDES Sites</th>
			</tr>
			<tr>
				<th align="center">Total</th>
				<th align="center">PRH</th>
				<th align="center">RH</th>
				<th align="center">HC</th>
				<th align="center">VMW</th>
				<th align="center">MMW</th>
				<th align="center">Total</th>
				<th align="center">PRH</th>
				<th align="center">RH</th>
				<th align="center">HC</th>
				<th align="center">VMW</th>
				<th align="center">MMW</th>
				<th align="center">Total</th>
				<th align="center">PRH</th>
				<th align="center">RH</th>
				<th align="center">HC</th>
				<th align="center">VMW</th>
				<th align="center">MMW</th>
				<!--<th align="center">Non-Endemic</th>-->
			</tr>
		</thead>
		<tbody data-bind="with: tblCase">
			<tr>
				<th align="center" colspan="2" class="bg-thead">No. of Sites</th>
				<td align="right" data-bind="text: Site"></td>
				<td></td>
				<td></td>
				<td align="right" class="bg-warning" data-bind="text: Site_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: PRH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: RH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: HC_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: VMW_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: MMW_iDES"></td>
				<td align="right" data-bind="text: Site_Non"></td>
				<td align="right" data-bind="text: PRH_Non"></td>
				<td align="right" data-bind="text: RH_Non"></td>
				<td align="right" data-bind="text: HC_Non"></td>
				<td align="right" data-bind="text: VMW_Non"></td>
				<td align="right" data-bind="text: MMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Site_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: PRH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: RH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: HC_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: VMW_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: MMW_Non_Prov"></td>
				<!--<td align="right" class="bg-success">NA</td>-->
			</tr>
			<tr>
				<th align="center" rowspan="7" class="bg-thead">Total Cases Notified</th>
				<th align="center" class="bg-thead">Pf</th>
				<td align="right" data-bind="text: Pf"></td>
				<td align="right" data-bind="text: Pf == 0 ? 'NA' : (Pf_iDES * 100 / Pf).toFixed(0)"></td>
				<td align="right" data-bind="text: Pf_iDES + Pf_Non"></td>
				<td align="right" class="bg-warning" data-bind="text: Pf_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pf_PRH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pf_RH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pf_HC_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pf_VMW_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pf_MMW_iDES"></td>
				<td align="right" data-bind="text: Pf_Non"></td>
				<td align="right" data-bind="text: Pf_PRH_Non"></td>
				<td align="right" data-bind="text: Pf_RH_Non"></td>
				<td align="right" data-bind="text: Pf_HC_Non"></td>
				<td align="right" data-bind="text: Pf_VMW_Non"></td>
				<td align="right" data-bind="text: Pf_MMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Pf_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pf_PRH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pf_RH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pf_HC_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pf_VMW_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pf_MMW_Non_Prov"></td>
				<!--<td align="right" class="bg-success" data-bind="text: Pf_HIS"></td>-->
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pv</th>
				<td align="right" data-bind="text: Pv"></td>
				<td align="right" data-bind="text: Pv == 0 ? 'NA' : (Pv_iDES * 100 / Pv).toFixed(0)"></td>
				<td align="right" data-bind="text: Pv_iDES + Pv_Non"></td>
				<td align="right" class="bg-warning" data-bind="text: Pv_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pv_PRH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pv_RH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pv_HC_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pv_VMW_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pv_MMW_iDES"></td>
				<td align="right" data-bind="text: Pv_Non"></td>
				<td align="right" data-bind="text: Pv_PRH_Non"></td>
				<td align="right" data-bind="text: Pv_RH_Non"></td>
				<td align="right" data-bind="text: Pv_HC_Non"></td>
				<td align="right" data-bind="text: Pv_VMW_Non"></td>
				<td align="right" data-bind="text: Pv_MMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Pv_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pv_PRH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pv_RH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pv_HC_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pv_VMW_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pv_MMW_Non_Prov"></td>
				<!--<td align="right" class="bg-success" data-bind="text: Pv_HIS"></td>-->
			</tr>
			<tr>
				<th align="center" class="bg-thead">Mix</th>
				<td align="right" data-bind="text: Mix"></td>
				<td align="right" data-bind="text: Mix == 0 ? 'NA' : (Mix_iDES * 100 / Mix).toFixed(0)"></td>
				<td align="right" data-bind="text: Mix_iDES + Mix_Non"></td>
				<td align="right" class="bg-warning" data-bind="text: Mix_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Mix_PRH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Mix_RH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Mix_HC_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Mix_VMW_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Mix_MMW_iDES"></td>
				<td align="right" data-bind="text: Mix_Non"></td>
				<td align="right" data-bind="text: Mix_PRH_Non"></td>
				<td align="right" data-bind="text: Mix_RH_Non"></td>
				<td align="right" data-bind="text: Mix_HC_Non"></td>
				<td align="right" data-bind="text: Mix_VMW_Non"></td>
				<td align="right" data-bind="text: Mix_MMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Mix_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Mix_PRH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Mix_RH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Mix_HC_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Mix_VMW_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Mix_MMW_Non_Prov"></td>
				<!--<td align="right" class="bg-success" data-bind="text: Mix_HIS"></td>-->
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pm</th>
				<td align="right" data-bind="text: Pm"></td>
				<td align="right" data-bind="text: Pm == 0 ? 'NA' : (Pm_iDES * 100 / Pm).toFixed(0)"></td>
				<td align="right" data-bind="text: Pm_iDES + Pm_Non"></td>
				<td align="right" class="bg-warning" data-bind="text: Pm_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pm_PRH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pm_RH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pm_HC_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pm_VMW_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pm_MMW_iDES"></td>
				<td align="right" data-bind="text: Pm_Non"></td>
				<td align="right" data-bind="text: Pm_PRH_Non"></td>
				<td align="right" data-bind="text: Pm_RH_Non"></td>
				<td align="right" data-bind="text: Pm_HC_Non"></td>
				<td align="right" data-bind="text: Pm_VMW_Non"></td>
				<td align="right" data-bind="text: Pm_MMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Pm_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pm_PRH_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Pm_RH_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Pm_HC_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Pm_VMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Pm_MMW_Non"></td>
				<!--<td align="right" class="bg-success">0</td>-->
			</tr>
			<tr>
				<th align="center" class="bg-thead">Po</th>
				<td align="right" data-bind="text: Po"></td>
				<td align="right" data-bind="text: Po == 0 ? 'NA' : (Po_iDES * 100 / Po).toFixed(0)"></td>
				<td align="right" data-bind="text: Po_iDES + Po_Non"></td>
				<td align="right" class="bg-warning" data-bind="text: Po_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Po_PRH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Po_RH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Po_HC_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Po_VMW_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Po_MMW_iDES"></td>
				<td align="right" data-bind="text: Po_Non"></td>
				<td align="right" data-bind="text: Po_PRH_Non"></td>
				<td align="right" data-bind="text: Po_RH_Non"></td>
				<td align="right" data-bind="text: Po_HC_Non"></td>
				<td align="right" data-bind="text: Po_VMW_Non"></td>
				<td align="right" data-bind="text: Po_MMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Po_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Po_PRH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Po_RH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Po_HC_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Po_VMW_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Po_MMW_Non_Prov"></td>
				<!--<td align="right" class="bg-success">0</td>-->
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pk</th>
				<td align="right" data-bind="text: Pk"></td>
				<td align="right" data-bind="text: Pk == 0 ? 'NA' : (Pk_iDES * 100 / Pk).toFixed(0)"></td>
				<td align="right" data-bind="text: Pk_iDES + Pk_Non"></td>
				<td align="right" class="bg-warning" data-bind="text: Pk_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pk_PRH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pk_RH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pk_HC_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pk_VMW_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Pk_MMW_iDES"></td>
				<td align="right" data-bind="text: Pk_Non"></td>
				<td align="right" data-bind="text: Pk_PRH_Non"></td>
				<td align="right" data-bind="text: Pk_RH_Non"></td>
				<td align="right" data-bind="text: Pk_HC_Non"></td>
				<td align="right" data-bind="text: Pk_VMW_Non"></td>
				<td align="right" data-bind="text: Pk_MMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Pk_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pk_PRH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pk_RH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pk_HC_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pk_VMW_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Pk_MMW_Non_Prov"></td>
				<!--<td align="right" class="bg-success">0</td>-->
			</tr>
			<tr>
				<th align="center" class="bg-thead">Total</th>
				<td align="right" data-bind="text: Total"></td>
				<td align="right" data-bind="text: Total == 0 ? 'NA' : (Total_iDES * 100 / Total).toFixed(0)"></td>
				<td align="right" data-bind="text: Total_iDES + Total_Non"></td>
				<td align="right" class="bg-warning" data-bind="text: Total_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Total_PRH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Total_RH_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Total_HC_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Total_VMW_iDES"></td>
				<td align="right" class="bg-warning" data-bind="text: Total_MMW_iDES"></td>
				<td align="right" data-bind="text: Total_Non"></td>
				<td align="right" data-bind="text: Total_PRH_Non"></td>
				<td align="right" data-bind="text: Total_RH_Non"></td>
				<td align="right" data-bind="text: Total_HC_Non"></td>
				<td align="right" data-bind="text: Total_VMW_Non"></td>
				<td align="right" data-bind="text: Total_MMW_Non"></td>
				<td align="right" class="bg-success" data-bind="text: Total_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Total_PRH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Total_RH_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Total_HC_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Total_VMW_Non_Prov"></td>
				<td align="right" class="bg-success" data-bind="text: Total_MMW_Non_Prov"></td>
				<!--<td align="right" class="bg-success" data-bind="text: Total_HIS"></td>-->
			</tr>
		</tbody>
	</table>
	<!-- /ko -->

	<!-- ko if: filter() == 'Case Enrollment' -->
	<h4 class="text-primary">Table 6</h4>
	<table class="table table-bordered widthauto">
		<thead class="bg-thead">
			<tr>
				<th align="center" rowspan="2">Type of Sites</th>
				<th align="center" colspan="7">Total Cases Notified at iDES Sites</th>
				<th align="center" colspan="7">Total Cases Enrolled to iDES</th>
				<th align="center" colspan="7">% of Notified Cases Enrolled to iDES</th>
			</tr>
			<tr data-bind="foreach: Array(3)">
				<th align="center" width="50">Pf</th>
				<th align="center" width="50">Pv</th>
				<th align="center" width="50">Pm</th>
				<th align="center" width="50">Po</th>
				<th align="center" width="50">Pk</th>
				<th align="center" width="50">Mix</th>
				<th align="center" width="50">Total</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tblEnroll">
			<tr data-bind="css: { 'text-bold': SiteType == 'Total' }">
				<td data-bind="text: SiteType"></td>
				<td align="right" data-bind="text: Pf"></td>
				<td align="right" data-bind="text: Pv"></td>
				<td align="right" data-bind="text: Pm"></td>
				<td align="right" data-bind="text: Po"></td>
				<td align="right" data-bind="text: Pk"></td>
				<td align="right" data-bind="text: Mix"></td>
				<td align="right" data-bind="text: Total"></td>

				<td align="right" data-bind="text: Pf_Enroll"></td>
				<td align="right" data-bind="text: Pv_Enroll"></td>
				<td align="right" data-bind="text: Pm_Enroll"></td>
				<td align="right" data-bind="text: Po_Enroll"></td>
				<td align="right" data-bind="text: Pk_Enroll"></td>
				<td align="right" data-bind="text: Mix_Enroll"></td>
				<td align="right" data-bind="text: Total_Enroll"></td>

				<td align="right" data-bind="text: Pf == 0 ? 'NA' : (Pf_Enroll * 100 / Pf).toFixed(0)"></td>
				<td align="right" data-bind="text: Pv == 0 ? 'NA' : (Pv_Enroll * 100 / Pv).toFixed(0)"></td>
				<td align="right" data-bind="text: Pm == 0 ? 'NA' : (Pm_Enroll * 100 / Pm).toFixed(0)"></td>
				<td align="right" data-bind="text: Po == 0 ? 'NA' : (Po_Enroll * 100 / Po).toFixed(0)"></td>
				<td align="right" data-bind="text: Pk == 0 ? 'NA' : (Pk_Enroll * 100 / Pk).toFixed(0)"></td>
				<td align="right" data-bind="text: Mix == 0 ? 'NA' : (Mix_Enroll * 100 / Mix).toFixed(0)"></td>
				<td align="right" data-bind="text: Total == 0 ? 'NA' : (Total_Enroll * 100 / Total).toFixed(0)"></td>
			</tr>
		</tbody>
	</table>
	<!-- /ko -->

	<!-- ko if: filter() == 'Follow-up' -->
	<h4 class="text-primary">Table 7</h4>
	<table class="table table-bordered widthauto">
		<thead class="bg-thead">
			<tr>
				<th align="center" rowspan="2">Day</th>
				<th align="center" colspan="7">No. of Cases Enrolled and Followed Up</th>
				<th align="center" colspan="7">% of Cases Followed Up</th>
			</tr>
			<tr data-bind="foreach: Array(2)">
				<th align="center" width="50">Pf</th>
				<th align="center" width="50">Pv</th>
				<th align="center" width="50">Pm</th>
				<th align="center" width="50">Po</th>
				<th align="center" width="50">Pk</th>
				<th align="center" width="50">Mix</th>
				<th align="center" width="50">Total</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tblFollowup">
			<tr>
				<td data-bind="text: Day"></td>
				<td align="right" data-bind="text: Pf"></td>
				<td align="right" data-bind="text: Pv"></td>
				<td align="right" data-bind="text: Pm"></td>
				<td align="right" data-bind="text: Po"></td>
				<td align="right" data-bind="text: Pk"></td>
				<td align="right" data-bind="text: Mix"></td>
				<td align="right" data-bind="text: Total"></td>

				<td align="right" data-bind="text: $parent.getFollowupPercent(Day,'Pf')"></td>
				<td align="right" data-bind="text: $parent.getFollowupPercent(Day,'Pv')"></td>
				<td align="right" data-bind="text: $parent.getFollowupPercent(Day,'Pm')"></td>
				<td align="right" data-bind="text: $parent.getFollowupPercent(Day,'Po')"></td>
				<td align="right" data-bind="text: $parent.getFollowupPercent(Day,'Pk')"></td>
				<td align="right" data-bind="text: $parent.getFollowupPercent(Day,'Mix')"></td>
				<td align="right" data-bind="text: $parent.getFollowupPercent(Day,'Total')"></td>
			</tr>
		</tbody>
	</table>
	<!-- /ko -->
</div>
<!-- /ko -->