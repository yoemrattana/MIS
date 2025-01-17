<!-- ko with: summary -->
<div class="panel-heading form-inline" data-bind="visible: $root.menu() == 'Summary'">
	<div class="input-group">
		<span class="input-group-addon text-bold">Year</span>
		<select class="form-control" data-bind="value: year, options: $root.yearList"></select>
	</div>
	<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
</div>
<div class="panel-body" data-bind="visible: $root.menu() == 'Summary' && loaded()">
	<h4 class="text-primary">I. iDES Sites</h4>
	<div style="display:flex; align-items:flex-start">
		<table class="table table-bordered table-striped widthauto">
			<thead class="bg-thead">
				<tr>
					<th align="center" colspan="4">Distribution of iDES Sites</th>
				</tr>
				<tr>
					<th align="center">Name of Province</th>
					<th align="center">Name of OD</th>
					<th align="center">Name PRH, RH, and HC</th>
					<th align="center">Name of VMW/MMW Village</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: tblSite, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Vill_E"></td>
				</tr>
			</tbody>
		</table>

		<table class="table table-bordered widthauto" style="margin-left:50px">
			<thead class="bg-thead">
				<tr>
					<th>iDES Sites</th>
					<th>No. of Sites</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>Province</td>
					<td align="right" data-bind="text: tblSite().distinct('Name_Prov_E').length"></td>
				</tr>
				<tr>
					<td>OD</td>
					<td align="right" data-bind="text: tblSite().distinct('Name_OD_E').length"></td>
				</tr>
				<tr>
					<td>PRH/RH</td>
					<td align="right" data-bind="text: tblSite().filter(r => r.Name_Facility_E.contain(' RH')).distinct('Code_Facility_T').length"></td>
				</tr>
				<tr>
					<td>HC</td>
					<td align="right" data-bind="text: tblSite().filter(r => !r.Name_Facility_E.contain(' RH')).distinct('Code_Facility_T').length"></td>
				</tr>
				<tr>
					<td>VMW/MMW Village</td>
					<td align="right" data-bind="text: tblSite().filter(r => r.Code_Vill_T != null).distinct('Code_Vill_T').length"></td>
				</tr>
			</thead>
		</table>
	</div>
	<br />

	<h4 class="text-primary">II. Case Notification</h4>
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
				<th align="center" rowspan="6" class="bg-thead">Total Cases Notified</th>
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

	<table class="table table-bordered widthauto">
		<thead class="bg-thead">
			<tr>
				<th align="center" rowspan="2" colspan="2">Type of Site</th>
				<th align="center" rowspan="2">Grand Total</th>
				<th align="center" rowspan="2">% of Cases Notified from iDES Sites</th>
				<th align="center" colspan="4">iDES Sites</th>
				<th align="center" colspan="4">Non-iDES Sites</th>
			</tr>
			<tr data-bind="foreach: Array(2)">
				<th align="center">Total</th>
				<th align="center">PRH/RH</th>
				<th align="center">HC</th>
				<th align="center">VMW/MMW</th>
			</tr>
		</thead>
		<tbody data-bind="with: tblCase">
			<tr>
				<td class="bg-thead"></td>
				<th align="center" class="bg-thead">No. of Sites</th>
				<td align="right" data-bind="text: Site_iDES + Site_Non"></td>
				<td></td>
				<td align="right" data-bind="text: Site_iDES"></td>
				<td align="right" data-bind="text: RH_iDES"></td>
				<td align="right" data-bind="text: HC_iDES"></td>
				<td align="right" data-bind="text: VMW_iDES"></td>
				<td align="right" data-bind="text: Site_Non"></td>
				<td align="right" data-bind="text: RH_Non"></td>
				<td align="right" data-bind="text: HC_Non"></td>
				<td align="right" data-bind="text: VMW_Non"></td>
			</tr>
			<tr>
				<th align="center" rowspan="6" class="bg-thead">Total Cases Notified</th>
				<th align="center" class="bg-thead">Pf</th>
				<td align="right" data-bind="text: Pf"></td>
				<td align="right" data-bind="text: Pf == 0 ? 'NA' : (Pf_iDES * 100 / Pf).toFixed(0)"></td>
				<td align="right" data-bind="text: Pf_iDES"></td>
				<td align="right" data-bind="text: Pf_RH_iDES"></td>
				<td align="right" data-bind="text: Pf_HC_iDES"></td>
				<td align="right" data-bind="text: Pf_VMW_iDES"></td>
				<td align="right" data-bind="text: Pf - Pf_iDES"></td>
				<td align="right" data-bind="text: Pf_RH_Non"></td>
				<td align="right" data-bind="text: Pf_HC_Non"></td>
				<td align="right" data-bind="text: Pf_VMW_Non"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pv</th>
				<td align="right" data-bind="text: Pv"></td>
				<td align="right" data-bind="text: Pv == 0 ? 'NA' : (Pv_iDES * 100 / Pv).toFixed(0)"></td>
				<td align="right" data-bind="text: Pv_iDES"></td>
				<td align="right" data-bind="text: Pv_RH_iDES"></td>
				<td align="right" data-bind="text: Pv_HC_iDES"></td>
				<td align="right" data-bind="text: Pv_VMW_iDES"></td>
				<td align="right" data-bind="text: Pv - Pv_iDES"></td>
				<td align="right" data-bind="text: Pv_RH_Non"></td>
				<td align="right" data-bind="text: Pv_HC_Non"></td>
				<td align="right" data-bind="text: Pv_VMW_Non"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pm</th>
				<td align="right" data-bind="text: Pm"></td>
				<td align="right" data-bind="text: Pm == 0 ? 'NA' : (Pm_iDES * 100 / Pm).toFixed(0)"></td>
				<td align="right" data-bind="text: Pm_iDES"></td>
				<td align="right" data-bind="text: Pm_RH_iDES"></td>
				<td align="right" data-bind="text: Pm_HC_iDES"></td>
				<td align="right" data-bind="text: Pm_VMW_iDES"></td>
				<td align="right" data-bind="text: Pm - Pm_iDES"></td>
				<td align="right" data-bind="text: Pm_RH_Non"></td>
				<td align="right" data-bind="text: Pm_HC_Non"></td>
				<td align="right" data-bind="text: Pm_VMW_Non"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Po</th>
				<td align="right" data-bind="text: Po"></td>
				<td align="right" data-bind="text: Po == 0 ? 'NA' : (Po_iDES * 100 / Po).toFixed(0)"></td>
				<td align="right" data-bind="text: Po_iDES"></td>
				<td align="right" data-bind="text: Po_RH_iDES"></td>
				<td align="right" data-bind="text: Po_HC_iDES"></td>
				<td align="right" data-bind="text: Po_VMW_iDES"></td>
				<td align="right" data-bind="text: Po - Po_iDES"></td>
				<td align="right" data-bind="text: Po_RH_Non"></td>
				<td align="right" data-bind="text: Po_HC_Non"></td>
				<td align="right" data-bind="text: Po_VMW_Non"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Pk</th>
				<td align="right" data-bind="text: Pk"></td>
				<td align="right" data-bind="text: Pk == 0 ? 'NA' : (Pk_iDES * 100 / Pk).toFixed(0)"></td>
				<td align="right" data-bind="text: Pk_iDES"></td>
				<td align="right" data-bind="text: Pk_RH_iDES"></td>
				<td align="right" data-bind="text: Pk_HC_iDES"></td>
				<td align="right" data-bind="text: Pk_VMW_iDES"></td>
				<td align="right" data-bind="text: Pk - Pk_iDES"></td>
				<td align="right" data-bind="text: Pk_RH_Non"></td>
				<td align="right" data-bind="text: Pk_HC_Non"></td>
				<td align="right" data-bind="text: Pk_VMW_Non"></td>
			</tr>
			<tr>
				<th align="center" class="bg-thead">Total</th>
				<td align="right" data-bind="text: Total"></td>
				<td align="right" data-bind="text: Total == 0 ? 'NA' : (Total_iDES * 100 / Total).toFixed(0)"></td>
				<td align="right" data-bind="text: Total_iDES"></td>
				<td align="right" data-bind="text: Total_RH_iDES"></td>
				<td align="right" data-bind="text: Total_HC_iDES"></td>
				<td align="right" data-bind="text: Total_VMW_iDES"></td>
				<td align="right" data-bind="text: Total - Total_iDES"></td>
				<td align="right" data-bind="text: Total_RH_Non"></td>
				<td align="right" data-bind="text: Total_HC_Non"></td>
				<td align="right" data-bind="text: Total_VMW_Non"></td>
			</tr>
		</tbody>
	</table>
	<br />

	<h4 class="text-primary">III. Case Enrollment and Follow-up</h4>
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
			<tr>
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
	<br />

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
</div>
<!-- /ko -->