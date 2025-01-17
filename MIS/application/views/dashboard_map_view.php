<style>
	div.fixed-header table.fixed-header { background:white; }
	.gm-style-iw button { display: none !important; }
	.foci-ball { width:15px; height:15px; border-radius:50%; }
</style>

<div data-bind="visible: tab() == 'Map' && app.user.permiss['Dashboard'].contain('Map')" style="display: none">
	<div class="row">
		<div class="col-md-6">
			<div class="chart-container">
                <div id="mapFoci" class="chartbox no-margin" style="height:600px"></div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card" style="transform:translate(0,0); width:fit-content">
				<div class="scroller-box" style="height:600px; overflow-y:auto">
					<table id="exportMap" class="table table-striped no-margin">
						<thead>
							<tr>
								<th>#</th>
								<th>Province</th>
								<th>OD</th>
								<th>HC</th>
								<th>Village</th>
								<th style="background:orange">12 Months</th>
								<th style="background:green">13-24 Months</th>
								<th style="background:green; border-left:1px solid white">25-36 Months</th>
								<th style="background:#2F75B5">37 Months</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: tableFoci, fixedHeader: true, scrollContainer: $($element).closest('.scroller-box')">
							<tr>
								<td data-bind="text: $index() + 1" align="center"></td>
								<td data-bind="text: Name_Prov_E"></td>
								<td data-bind="text: Name_OD_E"></td>
								<td data-bind="text: Name_Facility_E"></td>
								<td data-bind="text: Name_Vill_E"></td>
								<td align="center" valign="middle">
									<div class="foci-ball" data-bind="style: { backgroundColor: Year1 }"></div>
								</td>
								<td align="center" valign="middle">
									<div class="foci-ball" data-bind="style: { backgroundColor: Year2 }"></div>
								</td>
								<td align="center" valign="middle">
									<div class="foci-ball" data-bind="style: { backgroundColor: Year3 }"></div>
								</td>
								<td align="center" valign="middle">
									<div class="foci-ball" data-bind="style: { backgroundColor: Year4.replace('blue','#2F75B5') }"></div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div style="padding-left:10px;padding-right:10px" class="row">
		<div class="card-2">
			<div class="col-md-6">
				<div class="chart-container" style="border: none; box-shadow:none; border: none !important">
					<div id="chartTop10OD" style="height:600px"></div>
					<div class="btn" id="bubble" style="top: 7%">
						<label class="checkbox-inline checkbox-sm">
							<input class="top10Cbox" id="top-0" type="checkbox" checked />
							<span id="t10-lg-0"></span>
						</label>
						<label class="checkbox-inline checkbox-sm">
							<input class="top10Cbox" id="top-1" type="checkbox" checked />
							<span id="t10-lg-1"></span>
						</label>
						<label class="checkbox-inline checkbox-sm">
							<input class="top10Cbox" id="top-2" type="checkbox" checked />
							<span id="t10-lg-2"></span>
						</label>
						<label class="checkbox-inline checkbox-sm">
							<input class="top10Cbox" id="top-3" type="checkbox" checked />
							<span id="t10-lg-3"></span>
						</label>
						<label class="checkbox-inline checkbox-sm">
							<input class="top10Cbox" id="top-4" type="checkbox" checked />
							<span id="t10-lg-4"></span>
						</label>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div id="mapOD" logoopacity="1" style="height:600px"></div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="chart-container card">
                <div id="mapHotspot" class="chartbox no-margin" style="height:615px"></div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="chart-container card">
				<div id="mapAber" logoopacity="1" class="chartbox" style="height:600px; min-width:850px"></div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="chart-container card">
				<div id="mapODInc" logoopacity="1" class="chartbox" style="height:600px; min-width:850px"></div>
			</div>
		</div>

		<div class="col-md-6"></div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card option" style="line-height:15px">
				<div class="left-aside bg-light-part">
					<h6 class="panel-header">
						PERIOD
					</h6>

					<div class="divider"></div>

					<div class="form-group" style="display:inline-block">
						<span>Year</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: y, options: yearList"></select>
					</div>
					<br />
					<div class="form-group" style="display:inline-block; width:49%">
						<span> From</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: mf, options: monthList"></select>
					</div>
					<div class="form-group" style="display:inline-block; width:49%">
						<span> To</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: mt, options: monthList"></select>
					</div>
					<!--/-->
					<h6 class="panel-header mg-top-10">
						PLACE
					</h6>
					<div class="divider"></div>
					<div class="form-group">
						<span>Province</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: pvAPI, options: provList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length == 1 ? undefined : 'All'" id="code_prov"></select>
					</div>
					<div class="form-group">
						<span>OD</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: odAPI, options: odListOption, optionsValue: 'code', optionsText: 'name', optionsCaption: odListOption().length == 1 ? undefined : 'All'" id="code_od"></select>
					</div>
					<div class="form-group">
						<span>HF</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: hcAPI, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'" id="code_fa"></select>
					</div>
					<!--/-->
				
					<h6 class="panel-header mg-top-10">
						SPECIES
					</h6>

					<div class="divider"></div>

					<div class="specie" style="font-size:9.5px; border: 1px solid #ccc; padding:11px">
						<label class="checkbox-inline checkbox-sm">
							<input data-bind="disable: isGuest, checked: f" type="checkbox" />
							<span>PF</span>
						</label>
						<label class="checkbox-inline checkbox-sm">
							<input data-bind="disable: isGuest, checked: v" type="checkbox" />
							<span>PV</span>
						</label>
						<label class="checkbox-inline checkbox-sm">
							<input data-bind="disable: isGuest, checked: m" type="checkbox" />
							<span>Mix</span>
						</label>
					</div>
					<!--/-->

					<div class="form-group">
						<button data-bind="click: submitAPIVill" class="btn btn-info btn-sm" style="margin-top: 5px; width:100%">View</button>
					</div>

					<div class="divider"></div>

					<div class="row">
						<table class="table table-striped" style="font-size:13px; margin-left: 10px; margin-right:10px">
							<tr>
								<th class="bg-info">API Category</th>
								<th class="bg-primary">No. Villages</th>
							</tr>
							<tr>
								<td>
									Equal 0 
								</td>
								<td data-bind="text: $root.apiVill0"></td>
							</tr>
							<tr>
								<td>
									From 0.1 to 1
								</td>
								<td data-bind="text: $root.apiVillLt1"></td>
							</tr>
							<tr>
								<td>
									From 1 to 5
								</td>
								<td data-bind="text: $root.apiVillf1t5"></td>
							</tr>
							<tr>
								<td>
									From 5 to 30
								</td>
								<td data-bind="text: $root.apiVillf5t30"></td>
							</tr>
							<tr>
								<td>
									Greater than 30
								</td>
								<td data-bind="text: $root.apiVillgt30"></td>
							</tr>
						</table>
					</div>
				</div><!--/left-aside-->

				<div class="right-aside">
					<div class="chart-container2">
						<div id="mapAPI" logoopacity="1" class="chartbox no-margin" style="height:800px"></div>
						<div class="btn" data-bind="foreach: apiChboxs">
							<label class="checkbox-inline checkbox-sm">
								<input class="apimap" data-bind="checked: selected, attr: {id: id}" type="checkbox" />
								<span data-bind="text: name"></span>
							</label>					
						</div>
					</div>
				</div>
			</div><!--/card-->
		</div> <!--/col-12-->
	</div>
</div>