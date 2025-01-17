<div id="exportTable" data-bind="visible: tab() == 'Table' && app.user.permiss['Dashboard'].contain('Table')" style="display: none">
	<h3>
		<span>Monthly malaria cases by species reported</span>
		<span data-bind="visible: prov() == null"> by provinces (55 ODs)</span>
	</h3>
	<table class="table color-bordered-table info-bordered-table table-striped hover-table box-shadow">
		<thead>
			<tr>
				<th align="center" data-bind="text: year"></th>
				<!-- ko foreach: Array(12) -->
				<th colspan="3" align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')" style="border-left:1px solid #ddd"></th>
				<!-- /ko -->
				<th colspan="3" align="center" style="border-left:1px solid #ddd">Total</th>
			</tr>
			<tr>
				<th>Province</th>
				<!-- ko foreach: Array(13) -->
				<th class="bg-info" align="center" style="border-left:1px solid #ddd">Pf</th>
				<th class="bg-primary" align="center">Pv</th>
				<th class="bg-purple" align="center">Mix</th>
				<!-- /ko -->
			</tr>
		</thead>
		<tbody data-bind="foreach: tableSpecieProvinceMonth">
			<tr>
				<td data-bind="text: Name_Prov_E"></td>
				<!-- ko foreach: Array(12) -->
				<td align="center" data-bind="text: $parent['Pf' + ($index() + 1)]" style="border-left:1px solid #ddd"></td>
				<td align="center" data-bind="text: $parent['Pv' + ($index() + 1)]"></td>
				<td align="center" data-bind="text: $parent['Mix' + ($index() + 1)]"></td>
				<!-- /ko -->
				<th align="center" data-bind="text: Pf" style="border-left:1px solid #ddd"></th>
				<th align="center" data-bind="text: Pv"></th>
				<th align="center" data-bind="text: Mix"></th>
			</tr>
		</tbody>
		<tfoot data-bind="with: tableSpecieProvinceMonth, visible: prov() == null">
			<tr>
				<th>Grand Total</th>
				<!-- ko foreach: Array(12) -->
				<th align="center" data-bind="text: $parent.sum(r => r['Pf' + ($index() + 1)])" style="border-left:1px solid #ddd"></th>
				<th align="center" data-bind="text: $parent.sum(r => r['Pv' + ($index() + 1)])"></th>
				<th align="center" data-bind="text: $parent.sum(r => r['Mix' + ($index() + 1)])"></th>
				<!-- /ko -->
				<th align="center" data-bind="text: $data.sum(r => r.Pf)" style="border-left:1px solid #ddd"></th>
				<th align="center" data-bind="text: $data.sum(r => r.Pv)"></th>
				<th align="center" data-bind="text: $data.sum(r => r.Mix)"></th>
			</tr>
		</tfoot>
	</table>
	<br />
	<br />

	<h3>
		<span>Monthly severe malaria cases reported</span>
		<span data-bind="visible: prov() == null"> by provinces (55 ODs)</span>
	</h3>
	<table class="table color-bordered-table info-bordered-table table-striped box-shadow">
		<thead>
			<tr>
				<th colspan="14" align="center" data-bind="text: year"></th>
			</tr>
			<tr>
				<th>Province</th>
				<!-- ko foreach: Array(12) -->
				<th align="center" data-bind="text: moment($index() + 1, 'M').format('MMM')"></th>
				<!-- /ko -->
				<th align="center">Total</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableSevereMonth">
			<tr>
				<td data-bind="text: Name_Prov_E"></td>
				<!-- ko foreach: Array(12) -->
				<td align="center" data-bind="text: $parent['Severe' + ($index() + 1)]"></td>
				<!-- /ko -->
				<th align="center" data-bind="text: Severe"></th>
			</tr>
		</tbody>
		<tfoot data-bind="with: tableSevereMonth, visible: prov() == null">
			<tr>
				<th>Grand Total</th>
				<!-- ko foreach: Array(12) -->
				<th align="center" data-bind="text: $parent.sum(r => r['Severe' + ($index() + 1)])"></th>
				<!-- /ko -->
				<th align="center" data-bind="text: $data.sum(r => r.Severe)"></th>
			</tr>
		</tfoot>
	</table>
	<br />
	<br />

	<h3 style="text-align:center">
		<span>Number / percentage of malaria cases by age groups and sex</span>
		<span data-bind="visible: prov() == null"> by year (55 ODs)</span>
	</h3>
	<table class="table color-bordered-table info-bordered-table table-striped widthauto box-shadow" style="margin:auto">
		<thead>
			<tr>
				<th class="bg-info">Age group (year)</th>
				<th class="bg-primary" align="center" width="100">Year</th>
				<th class="bg-purple" align="center" width="100">Male</th>
				<th class="bg-danger" align="center" width="100">Female</th>
				<th class="bg-success" align="center" width="100">Male</th>
				<th class="bg-warning" align="center" width="100">Female</th>
				<th class="bg-cyan" align="center" width="100">Total</th>
				<th class="bg-info" align="center">Annual cases</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableAgeSex">
			<tr>
				<td align="center" class="border-right" valign="middle" data-bind="text: Age, visible: $index() % Duration == 0, attr: { rowspan: Duration }"></td>
				<td align="center" data-bind="text: Year"></td>
				<td align="center" data-bind="text: Male"></td>
				<td align="center" data-bind="text: Female"></td>
				<td align="center" data-bind="text: MalePercent + '%'"></td>
				<td align="center" data-bind="text: FemalePercent + '%'"></td>
				<td align="center" data-bind="text: Total"></td>
				<td align="center" data-bind="text: Annual + '%'"></td>
			</tr>
		</tbody>
	</table>
	<br />
	<br />

	<h3 style="text-align:center">
		<span>Number of malaria species by age groups and sex</span>
		<span data-bind="visible: prov() == null"> (55 ODs)</span>
	</h3>
	<table class="table color-bordered-table info-bordered-table table-striped widthauto box-shadow" style="margin:auto">
		<thead>
			<tr>
				<th class="bg-info" valign="middle" rowspan="2">Age group (year)</th>
				<th class="bg-primary" align="center" valign="middle" rowspan="2" width="100">Year</th>
				<th class="bg-cyan" align="center" colspan="3" style="border-left:1px solid #ddd">Male</th>
				<th class="bg-danger" align="center" colspan="3" style="border-left:1px solid #ddd">Female</th>
				<th class="bg-warning" align="center" valign="middle" rowspan="2" width="100" style="border-left:1px solid #ddd">Total</th>
			</tr>
			<tr>
				<th class="bg-info" align="center" width="70" style="border-left:1px solid #ddd">Pf</th>
				<th class="bg-primary" align="center" width="70">Pv</th>
				<th class="bg-purple" align="center" width="70">Mix</th>
				<th class="bg-info" align="center" width="70" style="border-left:1px solid #ddd">Pf</th>
				<th class="bg-primary" align="center" width="70">Pv</th>
				<th class="bg-purple" align="center" width="70">Mix</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableAgeSexSpecie">
			<tr>
				<td align="center" class="border-right" valign="middle" data-bind="text: Age, visible: $index() % Duration == 0, attr: { rowspan: Duration }"></td>
				<td align="center" data-bind="text: Year"></td>
				<td align="center" data-bind="text: MalePf" style="border-left:1px solid #ddd"></td>
				<td align="center" data-bind="text: MalePv"></td>
				<td align="center" data-bind="text: MaleMix"></td>
				<td align="center" data-bind="text: FemalePf" style="border-left:1px solid #ddd"></td>
				<td align="center" data-bind="text: FemalePv"></td>
				<td align="center" data-bind="text: FemaleMix"></td>
				<td align="center" data-bind="text: Total" style="border-left:1px solid #ddd"></td>
			</tr>
		</tbody>
	</table>
	<br />
	<br />

	<h3 style="text-align:center">
		<span>Number of malaria severe cases by age groups and sex</span>
		<span data-bind="visible: prov() == null"> (55 ODs)</span></h3>
	<table class="table color-bordered-table info-bordered-table table-striped widthauto box-shadow" style="margin:auto">
		<thead>
			<tr>
				<th class="bg-info">Age group (year)</th>
				<th class="bg-primary" align="center" width="100">Year</th>
				<th class="bg-success" align="center" width="100">Male</th>
				<th class="bg-warning" align="center" width="100">Female</th>
				<th class="bg-cyan" align="center" width="100">Total</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: tableAgeSexSevere">
			<tr>
				<td align="center" class="border-right" valign="middle" data-bind="text: Age, visible: $index() % Duration == 0, attr: { rowspan: Duration }"></td>
				<td align="center" data-bind="text: Year"></td>
				<td align="center" data-bind="text: Male"></td>
				<td align="center" data-bind="text: Female"></td>
				<td align="center" data-bind="text: Total"></td>
			</tr>
		</tbody>
	</table>
</div>