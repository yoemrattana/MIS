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
			<a href="/Entomology/Mosquito" class="btn btn-info">Mosquito Collection</a>
			<a href="/Entomology/Insecticide" class="btn btn-default">Insecticide Resistance</a>
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
		<div class="pull-right" style="position:sticky; right:21px">
			<button class="btn btn-primary width100" data-bind="click: save, visible: app.user.permiss['Entomology'].contain('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered table-hover text-nowrap">
			<thead class="bg-thead">
				<tr>
					<th width="40" align="center">#</th>
					<th align="center" width="130" sortable>Collection Date</th>
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
					<td data-bind="text: moment(CollectionDate).displayformat(), sortValue: CollectionDate" align="center"></td>
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
		<h3 class="text-bold text-center">Mosquito Collection Form</h3>

		<div id="detail" style="width:fit-content; margin:auto">
			<div class="clearfix">
				<div class="col-xs-6 form-inline" style="border:1px solid; padding:5px">
					<p>
						<b>Institution Completing Collection:</b>
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
					<b>Date of Mosquito Collection:</b>
					<input type="text" class="form-control text-center width150" placeholder="DD-MM-YYYY" data-bind="datePicker: CollectionDate" />
				</div>
			</div>

			<div style="border:1px solid">
				<div style="background:#E2EFD9; padding:5px;">
					<b>SECTION 1: MOSQUITO COLLECTION LOCATION DETAILS</b>
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
						<i>Type in the name of the Sentinel Site that data was collected for</i>
					</p>
					<div class="form-inline">
						<span>
							<b>GPS Coordinates</b>
							(in decimal degrees):
						</span>

						<b class="space">Latitude</b>
						<input type="text" class="form-control" placeholder="XX.XXXXX" data-bind="value: Lat, event: { keydown: $root.latOnly }" maxlength="8" />

						<b class="space">Longitude</b>
						<input type="text" class="form-control" placeholder="XXX.XXXXX" data-bind="value: Long, event: { keydown: $root.longOnly }" maxlength="9" />
					</div>
				</div>
			</div>

			<div style="border:1px solid">
				<div style="background:#E2EFD9; padding:5px;">
					<b>SECTION 2: MOSQUITO COLLECTION AND HOUSEHOLD DETAILS</b>
				</div>
				<div style="padding:5px">
					<div class="row">
						<div class="col-xs-5">
							<p class="form-inline">
								<b>Collection Method:</b>
								<select class="form-control" data-bind="value: CollectionMethod">
									<option></option>
									<option>Double Net Trap with Human Attractant</option>
									<option>Double Net Trap with Cow Attractant</option>
									<option>CDC-LT with human attractant</option>
									<option>Cattle-Baited Tent Trap</option>
								</select>
							</p>
							<p class="form-inline">
								<b>Collection Location:</b>
								<select class="form-control" data-bind="value: TrapPlacement">
									<option></option>
									<option>Indoor</option>
									<option>Outdoor</option>
								</select>
							</p>
						</div>
						<div class="col-xs-7">
							<p class="form-inline">
								<b>Type of Mosquito Collection:</b>
								<select class="form-control" data-bind="value: CollectionType">
									<option></option>
									<option>Hourly Collection</option>
									<option>Non-hourly Collection</option>
								</select>
							</p>
						</div>
					</div>

					<div class="text-bold">Surrounding Environment:</div>
					<table class="table">
						<tr>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Rain forest" data-bind="checked: SurroundingEnvironment" />
									<span>Rain forest</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Evergreen forest" data-bind="checked: SurroundingEnvironment" />
									<span>Evergreen forest</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Deciduous forest" data-bind="checked: SurroundingEnvironment" />
									<span>Deciduous forest</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Coniferous forest" data-bind="checked: SurroundingEnvironment" />
									<span>Coniferous forest</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Swamp forest" data-bind="checked: SurroundingEnvironment" />
									<span>Swamp forest</span>
								</label>
							</td>
						</tr>
						<tr>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Pasture/grassland" data-bind="checked: SurroundingEnvironment" />
									<span>Pasture/grassland</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Rice paddy" data-bind="checked: SurroundingEnvironment" />
									<span>Rice paddy</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Bamboo groove" data-bind="checked: SurroundingEnvironment" />
									<span>Bamboo groove</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Urban" data-bind="checked: SurroundingEnvironment" />
									<span>Urban</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Farm" data-bind="checked: SurroundingEnvironment" />
									<span>Farm</span>
								</label>
							</td>
						</tr>
						<tr>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="River" data-bind="checked: SurroundingEnvironment" />
									<span>River</span>
								</label>
							</td>
							<td colspan="4">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="SurroundingEnvironment" value="Other" data-bind="checked: SurroundingEnvironment" />
									<span>Other</span>
								</label>
								<input type="text" class="form-control widthauto inlineblock" placeholder="Specify" data-bind="value: SurroundingEnvironmentOther, visible: SurroundingEnvironment().contain('Other')" />
							</td>
						</tr>
					</table>
					<br />
					<div class="row">
						<div class="col-xs-5">
							<p class="form-inline">
								<b>Is this collection for Foci Investigation?</b>
								<select class="form-control" data-bind="value: IsFoci">
									<option></option>
									<option>Yes</option>
									<option>No</option>
								</select>
							</p>
							<div class="form-inline relative" data-bind="visible: IsFoci() == 'Yes'">
								<b>If Foci Investigation, specify the alert date:</b>
								<input type="text" class="form-control text-center width150" placeholder="DD-MM-YYYY" data-bind="datePicker: FociDate, dataType: 'string'" />
							</div>
						</div>
						<div class="col-xs-7" data-bind="visible: IsFoci() == 'Yes'">
							<p class="form-inline">
								<b>If Foci Investigation, specify the Foci Investigation Number?</b>
								<input type="text" class="form-control" data-bind="value: FociNumber" />
							</p>
							<div class="form-inline">
								<b>If Foci Investigation, specify Health Center Name:</b>
								<input type="text" class="form-control" data-bind="value: FociHC" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<div style="border:1px solid" data-bind="visible: CollectionMethod().in('Double Net Trap with Human Attractant','Double Net Trap with Cow Attractant')">
				<div style="background:#E2EFD9; padding:5px;">
					<b>SECTION 3A: HUMAN AND COW DOUBLE NET TRAPS (HDN/CDN) ONLY</b>
				</div>
				<div style="padding:5px">
					<div class="row">
						<div class="col-xs-5">
							<p class="form-inline">
								<b>Was manual aspiration conducted with Prokopack?</b>
								<select class="form-control" data-bind="value: Prokopack">
									<option></option>
									<option>Yes</option>
									<option>No</option>
								</select>
							</p>
							<div class="form-inline">
								<b>Location Code:</b>
								<input type="text" class="form-control" data-bind="value: LocationCode" />
							</div>
						</div>
						<div class="col-xs-7">
							<p class="form-inline">
								<b>Collection Location:</b>
								<select class="form-control" data-bind="value: CollectionLocation">
									<option></option>
									<option value="Village">Village*</option>
									<option value="Fringe Forest">Fringe Forest**</option>
									<option value="Deep Forest">Deep Forest***</option>
								</select>
							</p>
							<div class="form-inline">
								<b>Trap Number:</b>
								<input type="text" class="form-control" data-bind="value: TrapNumber" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<div style="border:1px solid" data-bind="visible: TrapPlacement() == 'Indoor'">
				<div style="background:#E2EFD9; padding:5px;">
					<b>Section 3B: Indoor Only</b>
				</div>
				<div style="padding:5px">
					<div class="row">
						<div class="col-xs-5">
							<p class="form-inline">
								<b>Type of roof:</b>
								<select class="form-control" data-bind="value: RoofType">
									<option></option>
									<option>Metal roof</option>
									<option>Thatched roof</option>
									<option>Tile roof</option>
									<option>Other</option>
								</select>
								<input type="text" class="form-control" placeholder="Specify" data-bind="value: RoofTypeOther, visible: RoofType() == 'Other'" />
							</p>
							<p class="form-inline">
								<b>Status of eaves:</b>
								<select class="form-control" data-bind="value: EaveStatus">
									<option></option>
									<option>Fully open</option>
									<option>Fully closed</option>
									<option>Open on 1 to 3 sides</option>
								</select>
							</p>
							<p class="form-inline">
								<b>Number of mosquito nets in house:</b>
								<input type="text" class="form-control width100 text-center" data-bind="value: NetsInHouse" numonly="int" />
							</p>
						</div>
						<div class="col-xs-7">
							<p class="form-inline">
								<b>Type of wall surface:</b>
								<select class="form-control" data-bind="value: WallType">
									<option></option>
									<option>Mud</option>
									<option>Cement</option>
									<option>Wood</option>
									<option>Painted Mud</option>
									<option>Painted Cement</option>
									<option>Thatch</option>
									<option>Brick</option>
									<option>Bamboo</option>
									<option>Metal</option>
									<option>Other</option>
								</select>
								<input type="text" class="form-control" placeholder="Specify" data-bind="value: WallTypeOther, visible: WallType() == 'Other'" />
							</p>
							<p class="form-inline">
								<b>Type of ceiling in the household:</b>
								<select class="form-control" data-bind="value: CeilingType">
									<option></option>
									<option>Fully closed ceiling</option>
									<option>Partially closed ceiling</option>
									<option>No ceiling</option>
								</select>
							</p>
							<p class="form-inline">
								<b>Number of people who slept under net last night:</b>
								<input type="text" class="form-control width100 text-center" data-bind="value: SleepUnderNet" numonly="int" />
							</p>
							<p class="form-inline">
								<b>Number of people who did not sleep under a net last night:</b>
								<input type="text" class="form-control width100 text-center" data-bind="value: NotSleepUnderNet" numonly="int" />
							</p>
						</div>
					</div>
					<div>
						<b>Which brand of Mosquito Nets are hung in the household?</b>
						<span>(choose as many as apply):</span>
					</div>
					<table class="table">
						<tr>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="TSARANet" data-bind="checked: NetBrand" />
									<span>TSARANet</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="DawaPlus 3.0" data-bind="checked: NetBrand" />
									<span>DawaPlus 3.0</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="MiraNet" data-bind="checked: NetBrand" />
									<span>MiraNet</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="PermaNet 2.0" data-bind="checked: NetBrand" />
									<span>PermaNet 2.0</span>
								</label>
							</td>
							<td width="20%">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Yahe LN" data-bind="checked: NetBrand" />
									<span>Yahe LN</span>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="TSARABoost" data-bind="checked: NetBrand" />
									<span>TSARABoost</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="DawaPlus 4.0" data-bind="checked: NetBrand" />
									<span>DawaPlus 4.0</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="MAGNet" data-bind="checked: NetBrand" />
									<span>MAGNet</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="PermaNet 3.0" data-bind="checked: NetBrand" />
									<span>PermaNet 3.0</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Yorkool LN" data-bind="checked: NetBrand" />
									<span>Yorkool LN</span>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="TSARAPlus" data-bind="checked: NetBrand" />
									<span>TSARAPlus</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Duranet" data-bind="checked: NetBrand" />
									<span>Duranet</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="OLYSET Net" data-bind="checked: NetBrand" />
									<span>OLYSET Net</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Royal sentry" data-bind="checked: NetBrand" />
									<span>Royal sentry</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Unknown" data-bind="checked: NetBrand" />
									<span>Unknown</span>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="TSARASoft" data-bind="checked: NetBrand" />
									<span>TSARASoft</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Intercepter" data-bind="checked: NetBrand" />
									<span>Intercepter</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="OLYSET Plus" data-bind="checked: NetBrand" />
									<span>OLYSET Plus</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="SafeNet" data-bind="checked: NetBrand" />
									<span>SafeNet</span>
								</label>
							</td>
							<td class="form-inline">
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Other" data-bind="checked: NetBrand" />
									<span>Other</span>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="DawaPlus 2.0" data-bind="checked: NetBrand" />
									<span>DawaPlus 2.0</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Interceptor G2" data-bind="checked: NetBrand" />
									<span>Interceptor G2</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="Panda Net 2.0" data-bind="checked: NetBrand" />
									<span>Panda Net 2.0</span>
								</label>
							</td>
							<td>
								<label class="checkbox-inline checkbox-lg">
									<input type="checkbox" name="NetBrand" value="VEERALIN" data-bind="checked: NetBrand" />
									<span>VEERALIN</span>
								</label>
							</td>
							<td>
								<input type="text" class="form-control" style="width:200px" placeholder="Specify" data-bind="value: NetBrandOther, visible: NetBrand().contain('Other')" />
							</td>
						</tr>
					</table>
					<br />

					<p class="text-bold">For each net brand chosen above, record how many of each brand of net are hung in the household:</p>
					<table class="table table-bordered widthauto">
						<thead>
							<tr>
								<th align="center">Brand of Nets in Household</th>
								<th align="center">Number of Each Brand of Net Listed in Household</th>
							</tr>
						</thead>
						<tfoot data-bind="foreach: NetBrandList">
							<tr>
								<td valign="middle" data-bind="text: brand"></td>
								<td>
									<input type="text" class="form-control input-sm text-center" data-bind="value: qty" numonly="int" />
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>

			<div style="border:1px solid">
				<div style="background:#E2EFD9; padding:5px;">
					<b>SECTION 4: MOSQUITO COLLECTION SUMMARY</b>
				</div>
				<div class="form-inline relative" style="padding:5px" data-bind="visible: CollectionType() != 'Hourly Collection'">
					<span>
						<b>Time of Mosquito Collection (if non-hourly):</b> Start Time:
					</span>
					<input type="text" class="form-control text-center width100" placeholder="HH:MM" data-bind="datePicker: StartTime, format: 'HH:mm'" />

					<span class="space">End Time:</span>
					<input type="text" class="form-control text-center width100" placeholder="HH:MM" data-bind="datePicker: EndTime, format: 'HH:mm'" />
				</div>
				<div class="form-inline" style="padding:5px">
					<b>Number of collection nights:</b>
					<input type="text" class="form-control text-center width100" data-bind="value: CollectionNight" numonly="int" />

					<b class="space">Number of collection traps:</b>
					<input type="text" class="form-control text-center width100" data-bind="value: CollectionTrap" numonly="int" />

					<b class="space">If Hourly Collection: Length of each collection per hour:</b>
					<div class="input-group">
						<input type="text" class="form-control text-center width100" data-bind="value: CollectionLength, event: { keydown: $root.only60 }" maxlength="2" />
						<span class="input-group-addon">(in mins)</span>
					</div>
				</div>
			</div>

			<div style="border:1px solid">
				<div class="form-inline" style="background:#E2EFD9; padding:5px; position:relative">
					<div>
						<b>If Non-Hourly Collection:</b>
						<b class="space">Total Anopheles Female Collected:</b>
						<input type="text" class="form-control text-center width100" data-bind="value: $root.sumAnophelesFemale()" readonly />

						<b style="margin-left:30px">Total Culicine Female Collected:</b>
						<input type="text" class="form-control text-center width100" data-bind="value: $root.sumCulicineFemale()" readonly />
					</div>
					<div style="position:absolute; right:5px; bottom:5px">
						<button class="btn btn-warning" data-bind="click: $root.addColumn">Add Column</button>
					</div>
				</div>
			</div>

			<table class="table table-bordered text-nowrap widthauto" data-bind="with: $root.detailModel">
				<tr>
					<th align="center" valign="middle">Species Collected</th>

					<!-- ko foreach: head -->
					<td width="160" style="min-width:100px" valign="middle">
						<select class="form-control input-sm inlineblock" data-bind="value: value, options: $root.mosquitoList($index()), optionsCaption: ''" style="font-style:italic; width:131px"></select>
						<a class="text-bold text-danger" data-bind="click: $root.removeColumn">
							<i class="glyphicon glyphicon-trash" style="top:2px"></i>
						</a>
					</td>
					<!-- /ko -->

					<th align="center" valign="middle">Total Female Culicine</th>
				</tr>

				<!-- ko foreach: body -->
				<tr data-bind="visible: $root.editModel().CollectionType() != 'Non-hourly Collection'">
					<td align="center" valign="middle" data-bind="text: time"></td>

					<!-- ko foreach: values -->
					<td align="center">
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: value" numonly="int" />
					</td>
					<!-- /ko -->

					<td align="center">
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: female" numonly="int" />
					</td>
				</tr>
				<!-- /ko -->

				<tr>
					<th align="center" valign="middle">Total</th>

					<!-- ko foreach: total.values -->
					<td align="center">
						<span data-bind="text: $root.sumDetail($index()), visible: $root.editModel().CollectionType() != 'Non-hourly Collection'"></span>
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: value, visible: $root.editModel().CollectionType() == 'Non-hourly Collection'" numonly="int" />
					</td>
					<!-- /ko -->

					<td align="center">
						<span data-bind="text: $root.sumDetail('female'), visible: $root.editModel().CollectionType() != 'Non-hourly Collection'"></span>
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: total.female, visible: $root.editModel().CollectionType() == 'Non-hourly Collection'" numonly="int" />
					</td>
				</tr>

				<!-- ko if: $root.editModel().CollectionMethod() == 'CDC-LT with human attractant' -->
				<tr>
					<th align="center" valign="middle">Unfed</th>

					<!-- ko foreach: UF -->
					<td align="center">
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: value, style: { 'border-color': $root.checkEqualTotal($index()) }" numonly="int" />
					</td>
					<!-- /ko -->

					<td></td>
				</tr>
				<tr>
					<th align="center" valign="middle">Fed</th>

					<!-- ko foreach: F -->
					<td align="center">
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: value, style: { 'border-color': $root.checkEqualTotal($index()) }" numonly="int" />
					</td>
					<!-- /ko -->

					<td></td>
				</tr>
				<tr>
					<th align="center" valign="middle">Half Gravid</th>

					<!-- ko foreach: HG -->
					<td align="center">
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: value, style: { 'border-color': $root.checkEqualTotal($index()) }" numonly="int" />
					</td>
					<!-- /ko -->

					<td></td>
				</tr>
				<tr>
					<th align="center" valign="middle">Gravid</th>

					<!-- ko foreach: G -->
					<td align="center">
						<input type="text" class="form-control input-sm text-center" data-bind="textInput: value, style: { 'border-color': $root.checkEqualTotal($index()) }" numonly="int" />
					</td>
					<!-- /ko -->

					<td></td>
				</tr>
				<!-- /ko -->
			</table>
			<br />

			<div>
				*Select Village if the collection occurs within the village boundaries.<br />
				**Fringe Forest is defined as any collection occurring within 2 to 3 km away from a village.<br />
				***Deep Forest is defined as any collection occurring within 5 to 10 km away from a village.
			</div>
		</div>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'edit' && app.user.permiss['Entomology'].contain('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<?=latestJs('/media/ViewModel/Entomology_Mosquito.js')?>