<style>
	.space { margin-left:15px; }

	#detail .table-bordered > tbody > tr > th,
	#detail .table-bordered > tbody > tr > td {
		border: 1px solid;
	}
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left">
			<a href="/Entomology/Mosquito" class="btn btn-default">Mosquito Collection</a>
			<a href="/Entomology/Insecticide" class="btn btn-info">Insecticide Resistance</a>
			<a href="/Entomology/Dashboard" class="btn btn-default">Dashboard</a>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left form-inline">
			<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length > 1 ? 'All Province' : undefined"></select>
			<select class="form-control" data-bind="value: ds, options: dsList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All District'"></select>
			<select class="form-control" data-bind="value: cm, options: cmList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Commune'"></select>
			<select class="form-control" data-bind="value: vl, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Village'"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: app.user.permiss['Entomology'].contain('Edit')">New</button>
		</div>
	</div>
	<div class="panel-heading clearfix" data-bind="visible: view() == 'edit'">
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: save, visible: app.user.permiss['Entomology'].contain('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered text-nowrap">
			<thead class="bg-thead">
				<tr>
					<th width="40" align="center">#</th>
					<th align="center" sortable>Province</th>
					<th align="center" sortable>District</th>
					<th align="center" sortable>Commune</th>
					<th align="center" sortable>Village</th>
					<th align="center" sortable>Sentinel Site</th>
					<th width="50" align="center">Detail</th>
					<th width="60" align="center" data-bind="visible: app.user.permiss['Entomology'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel(), fixedHeader: true, sortModel: listModel">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: $root.getPVName(Code_Prov_T)"></td>
					<td data-bind="text: $root.getDSName(Code_Dist_T)"></td>
					<td data-bind="text: $root.getCMName(Code_Comm_T)"></td>
					<td data-bind="text: $root.getVLName(Code_Vill_T)"></td>
					<td data-bind="text: Site"></td>
					<td align="center">
						<a data-bind="click: $root.showEdit">Detail</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Entomology'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="panel-body" data-bind="with: editModel, visible: view() == 'edit'">
		<h3 class="text-bold text-center">Insecticide Resistance Form</h3>

		<div id="detail" style="width:1200px; margin:auto;">
			<div class="clearfix">
				<div class="col-xs-6 form-inline" style="border:1px solid; padding:5px">
					<p>
						<b>Institution Completing Test:</b>
						<select class="form-control" data-bind="value: Institution">
							<option>CNM</option>
							<option>PMI</option>
							<option>Other</option>
						</select>
						<input type="text" class="form-control" placeholder="Specify" data-bind="value: InstitutionOther, visible: Institution() == 'Other', event: { keydown: $root.letterOnly }" />
					</p>
					
					<b>Name of Person Completing Form:</b>
					<input type="text" class="form-control" data-bind="value: CompletingPerson" />
				</div>
				<div class="col-xs-6 form-inline" style="border:1px solid; padding:5px; height:90px">
					<b>Date of Insecticide Resistance Test:</b>
					<input type="text" class="form-control text-center width150" placeholder="DD/MM/YYYY" data-bind="datePicker: InsecticideDate, format: 'DD/MM/YYYY'" />
				</div>
			</div>

			<div style="border:1px solid">
				<div style="background:#FBE4D5; padding:5px;">
					<b>SECTION 1: LOCATION DETAILS</b>
				</div>
				<div style="padding:5px">
					<p class="form-inline">
						<b>Province:</b>
						<select class="form-control minwidth100" data-bind="value: Code_Prov_T, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>

						<b class="space">District:</b>
						<select class="form-control minwidth100" data-bind="value: Code_Dist_T, options: dsList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>

						<b class="space">Commune:</b>
						<select class="form-control minwidth100" data-bind="value: Code_Comm_T, options: cmList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>

						<b class="space">Village:</b>
						<select class="form-control minwidth100" data-bind="value: Code_Vill_T, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</p>
					<p class="form-inline">
						<b>Sentinel Site:</b>
						<input type="text" class="form-control" data-bind="value: Site" />
					</p>
					<p class="form-inline">
						<span>
							<b>GPS Coordinates</b>
							(in decimal degrees):
						</span>

						<b class="space">Latitude</b>
						<input type="text" class="form-control" placeholder="XX.XXXXX" data-bind="value: Lat, event: { keydown: $root.latOnly }" maxlength="8" />

						<b class="space">Longitude</b>
						<input type="text" class="form-control" placeholder="XXX.XXXXX" data-bind="value: Long, event: { keydown: $root.longOnly }" maxlength="9" />
					</p>
					<div class="form-inline">
						<b>Collection Location:</b>
						<select class="form-control" data-bind="value: CollectionLocation">
							<option></option>
							<option value="Village">Village*</option>
							<option value="Fringe Forest">Fringe Forest**</option>
							<option value="Deep Forest">Deep Forest***</option>
						</select>
					</div>
				</div>
			</div>

			<div style="border:1px solid">
				<div style="background:#FBE4D5; padding:5px;">
					<b>SECTION 2: MOSQUITO DETAILS</b>
				</div>
				<div class="form-inline" style="padding:5px">
					<b>Mosquito Origin:</b>
					<select class="form-control" data-bind="value: Origin">
						<option></option>
						<option>Susceptible colony</option>
						<option>F0: Reared from wild larvae</option>
						<option>F1: Reared from eggs of wild adults</option>
						<option>F2: Reared from F1 adults</option>
						<option>Wild caught mosquito</option>
					</select>
				</div>
			</div>

			<div style="border:1px solid">
				<div class="form-inline" style="padding:5px">
					<b>Mosquito Species Tested:</b>
					<select class="form-control" data-bind="value: Species">
						<option></option>
						<option>An. dirus s.l.</option>
						<option>An. minimus s.l.</option>
						<option>An. maculatus s.l.</option>
						<option>Other</option>
					</select>
					<input type="text" class="form-control" placeholder="Specify" data-bind="value: SpeciesOther, visible: Species() == 'Other'" />
				</div>
			</div>

			<div style="border:1px solid">
				<div class="form-inline" style="padding:5px">
					<b>Mosquito Age:</b>
					<i>Note: It is standard to perform tube test on mosquitoes 2-5 days of age:</i>
					<select class="form-control" data-bind="value: Age">
						<option></option>
						<option>2-5 days</option>
						<option>Unknown</option>
						<option>Other age (days)</option>
					</select>
					<input type="text" class="form-control" placeholder="Specify in days" data-bind="value: AgeOther, visible: Age().contain('Other'), event: { keydown: $root.only10 }" maxlength="2" />
				</div>
			</div>

			<div style="border:1px solid">
				<div style="background:#FBE4D5; padding:5px;">
					<b>SECTION 3: TEST DETAILS</b>
				</div>
				<div class="form-inline relative" style="padding:5px">
					<b>What type of test is being completed?</b>
					<select class="form-control" data-bind="value: TestType">
						<option></option>
						<option>WHO Tube Test</option>
						<option>CDC Bottle Bioassay</option>
					</select>

					<!-- ko if: TestType() == 'WHO Tube Test' -->
					<b class="space">Expiration date of WHO Tube Paper:</b>
					<input type="text" class="form-control text-center width150" placeholder="DD/MM/YYYY" data-bind="datePicker: ExpirationDate, format: 'DD/MM/YYYY'" />
					<!-- /ko -->
				</div>
			</div>

			<div style="border:1px solid">
				<div class="form-inline" style="padding:5px">
					<b>What insecticide was tested?</b>
					<select class="form-control" data-bind="value: InsecticideTested, options: $root.insecticideList(), optionsCaption: ''"></select>
					<input type="text" class="form-control" placeholder="Specify" data-bind="value: InsecticideTestedOther, visible: InsecticideTested() == 'Other'" />
				</div>
			</div>

			<div style="border:1px solid">
				<div class="form-inline" style="padding:5px">
					<b>Insecticide Concentration:</b>
					<select class="form-control" data-bind="value: InsecticideConcentration, options: $root.insecticideConcentrationList(), optionsCaption: ''"></select>
					<input type="text" class="form-control" placeholder="Specify" data-bind="value: InsecticideConcentrationOther, visible: InsecticideConcentration() == 'Other'" />
				</div>
			</div>

			<div style="border:1px solid">
				<div class="form-inline" style="padding:5px">
					<b>Was this test completed with a synergist?</b>
					<select class="form-control" data-bind="value: SynergistTestCompleted">
						<option></option>
						<option>Yes</option>
						<option>No</option>
					</select>
				</div>
			</div>

			<div style="border:1px solid" data-bind="visible: SynergistTestCompleted() == 'Yes'">
				<div class="form-inline" style="padding:5px">
					<b>If synergist assay completed, what synergist was tested?</b>
					<select class="form-control" data-bind="value: SynergistTested">
						<option></option>
						<option>PBO</option>
						<option>DEF</option>
						<option>Ethacrynic</option>
						<option>Other</option>
					</select>
					<input type="text" class="form-control" placeholder="Specify" data-bind="value: SynergistTestedOther, visible: SynergistTested() == 'Other'" />
				</div>
			</div>

			<div style="border:1px solid" data-bind="visible: SynergistTestCompleted() == 'Yes'">
				<div class="form-inline" style="padding:5px">
					<b>If synergist assay completed, Synergist Concentration:</b>
					<select class="form-control" data-bind="value: SynergistConcentration, options: $root.synergistConcentrationList(), optionsCaption: ''"></select>
					<input type="text" class="form-control" placeholder="Specify" data-bind="value: SynergistConcentrationOther, visible: SynergistConcentration() == 'Other'" />
				</div>
			</div>

			<table class="table table-bordered">
				<tr>
					<td width="50%">
						<div class="form-group">
							<b>Temperature</b>
							<span>(&deg; Celsius):</span>
						</div>
						<div class="form-inline form-group">
							<span class="inlineblock" style="width:106px">Exposure period:</span>
							<div class="input-group">
								<span class="input-group-addon">Max</span>
								<input type="text" class="form-control width100 text-center" numonly="float" data-bind="textInput: TemperatureExposureMax, event: { keydown: $root.only30 }" />
								<span class="input-group-addon">(Celsius)</span>
							</div>
							<div class="input-group">
								<span class="input-group-addon">Min</span>
								<input type="text" class="form-control width100 text-center" numonly="float" data-bind="value: TemperatureExposureMin, event: { keydown: $root.notOverExposure }" />
								<span class="input-group-addon">(Celsius)</span>
							</div>
						</div>
						<div class="form-inline">
							<span class="inlineblock" style="width:106px">Holding period:</span>
							<div class="input-group">
								<span class="input-group-addon">Max</span>
								<input type="text" class="form-control width100 text-center" numonly="float" data-bind="textInput: TemperatureHoldingMax, event: { keydown: $root.only30 }" />
								<span class="input-group-addon">(Celsius)</span>
							</div>
							<div class="input-group">
								<span class="input-group-addon">Min</span>
								<input type="text" class="form-control width100 text-center" numonly="float" data-bind="value: TemperatureHoldingMin, event: { keydown: $root.notOverHolding }" />
								<span class="input-group-addon">(Celsius)</span>
							</div>
						</div>
					</td>
					<td width="50%">
						<div class="form-group">
							<b>Relative humidity (%):</b>
						</div>
						<div class="form-inline form-group">
							<span class="inlineblock" style="width:106px">Exposure period:</span>
							<div class="input-group">
								<span class="input-group-addon">Max</span>
								<input type="text" class="form-control width100 text-center" data-bind="value: HumidityExposureMax, event: { keydown: $root.only100 }" />
								<span class="input-group-addon">%</span>
							</div>
							<div class="input-group">
								<span class="input-group-addon">Min</span>
								<input type="text" class="form-control width100 text-center" data-bind="value: HumidityExposureMin, event: { keydown: $root.only100 }" />
								<span class="input-group-addon">%</span>
							</div>
						</div>
						<div class="form-inline">
							<span class="inlineblock" style="width:106px">Holding period:</span>
							<div class="input-group">
								<span class="input-group-addon">Max</span>
								<input type="text" class="form-control width100 text-center" data-bind="value: HumidityHoldingMax, event: { keydown: $root.only100 }" />
								<span class="input-group-addon">%</span>
							</div>
							<div class="input-group">
								<span class="input-group-addon">Min</span>
								<input type="text" class="form-control width100 text-center" data-bind="value: HumidityHoldingMin, event: { keydown: $root.only100 }" />
								<span class="input-group-addon">%</span>
							</div>
						</div>
					</td>
				</tr>
			</table>

			<div style="border:1px solid">
				<div style="background:#FBE4D5; padding:5px;">
					<b>SECTION 4: MORTALITY RESULTS</b>
				</div>
			</div>

			<table class="table table-bordered">
				<tbody>
					<tr>
						<td></td>
						<td align="center" width="19%">Insecticide Only</td>
						<td align="center" width="19%">Solvent Only Control</td>
						<td align="center" width="19%">Insecticide & Synergist</td>
						<td align="center" width="19%">Synergist Only Control</td>
					</tr>
				</tbody>
				<tbody data-bind="foreach: $root.detailModel">
					<tr>
						<th valign="middle" data-bind="text: Indicator"></th>
						<td><input type="text" class="form-control text-center" numonly="int" data-bind="textInput: InsecticideOnly, style: { 'border-color': $root.checkEqualTotal(Indicator, 'InsecticideOnly') }" /></td>
						<td><input type="text" class="form-control text-center" numonly="int" data-bind="textInput: SolventOnlyControl, style: { 'border-color': $root.checkEqualTotal(Indicator, 'SolventOnlyControl') }" /></td>
						<td><input type="text" class="form-control text-center" numonly="int" data-bind="textInput: InsecticideSynergist, style: { 'border-color': $root.checkEqualTotal(Indicator, 'InsecticideSynergist') }, visible: $root.editModel().SynergistTestCompleted() == 'Yes'" /></td>
						<td><input type="text" class="form-control text-center" numonly="int" data-bind="textInput: SynergistOnlyControl, style: { 'border-color': $root.checkEqualTotal(Indicator, 'SynergistOnlyControl') }, visible: $root.editModel().SynergistTestCompleted() == 'Yes'" /></td>
					</tr>
				</tbody>
				<tbody data-bind="if: $root.detailModel().length > 0">
					<tr>
						<th>
							<span data-bind="visible: (v => v >= 5 && v <= 20)($root.calculateMortality('SolventOnlyControl'))">Corrected</span>
							<span>Mortality at 24hr (%)</span>
						</th>
						<td align="center" data-bind="with: $root.calculateMortality('InsecticideOnly')">
							<span data-bind="text: $data == null ? null : $data == '-1' ? 'Discarded' : $data + '%'"></span>
						</td>
						<td align="center" data-bind="text: isnot($root.calculateMortality('SolventOnlyControl'),null,r => r + '%')"></td>

						<td align="center" data-bind="if: $root.editModel().SynergistTestCompleted() == 'Yes'">
							<span data-bind="text: isnot($root.calculateMortality('InsecticideSynergist'),null,r => r + '%')"></span>
						</td>
						<td align="center" data-bind="if: $root.editModel().SynergistTestCompleted() == 'Yes'">
							<!-- ko with: $root.calculateMortality('SynergistOnlyControl') -->
							<span data-bind="text: isnot($data, null, r => r + '%'), css: $data > 20 ? 'text-danger text-bold' : ''"></span>
							<!-- /ko -->
						</td>
					</tr>
				</tbody>
			</table>
			<br />

			<p>
				*Select Village if the collection occurs within the village boundaries.<br />
				**Fringe Forest is defined as any collection occurring within 2 to 3 km away from a village.<br />
				***Deep Forest is defined as any collection occurring within 5 to 10 km away from a village.
			</p>

			<div class="clearfix">
				<div class="pull-left">Note:</div>
				<div class="pull-left">
					<ul style="padding-left:25px">
						<li>If only the Susceptibility test was completed, do not fill in the “Insecticide plus Synergist” or “Synergist only (control)” sections. KD: Knock-down</li>
						<li>If control mortality >=5% and <=20%, the corrected mortality is presented. Caption of Discarded is presented if control mortality more than 20%</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'edit' && app.user.permiss['Entomology'].contain('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<?=latestJs('/media/ViewModel/Entomology_Insecticide.js')?>