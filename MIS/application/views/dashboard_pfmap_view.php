<div data-bind="visible: tab() == 'PF Map' && app.user.permiss['Dashboard'].contain('PF Map')" style="display:none">
	<div class="row">
		<div class="col-md-6">
			<h3>
				<span>Number of places that have Pf and Mix Cases, </span>
				<span data-bind="text: lastSearch().from + '-' + lastSearch().to + ' ' + lastSearch().year"></span>
			</h3>
			<table class="table color-bordered-table info-bordered-table table-striped no-margin">
				<thead>
					<tr>
						<th></th>
						<th width="150">Province</th>
						<th width="150">OD</th>
						<th width="150">HC</th>
						<th width="150">Village</th>
						<th></th>
					</tr>
				</thead>
				<tbody data-bind="foreach: tablePfCount">
					<tr>
						<td></td>
						<td align="center" data-bind="text: Province"></td>
						<td align="center" data-bind="text: OD"></td>
						<td align="center" data-bind="text: HF"></td>
						<td align="center" data-bind="text: Village"></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<br />

			<div class="chart-container">
                <div id="mapPf" class="chartbox no-margin" style="height:600px"></div>
			</div>
		</div>
		<div class="col-md-6">
			<div id="exportPfList">
				<h3>
					<span>List of Pf and Mix Cases by Health Center, </span>
					<span data-bind="text: lastSearch().from + '-' + lastSearch().to + ' ' + lastSearch().year"></span>
				</h3>
				<table class="table color-bordered-table info-bordered-table table-striped no-margin">
					<thead>
						<tr>
							<th>#</th>
							<th class="text-left">Province</th>
							<th class="text-left">OD</th>
							<th class="text-left">HC</th>
							<th>PF + Mix</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: tablePf, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1" align="center"></td>
							<td data-bind="text: Name_Prov_E"></td>
							<td data-bind="text: Name_OD_E"></td>
							<td data-bind="text: Name_Facility_E"></td>
							<td align="center" data-bind="text: PfMix"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>