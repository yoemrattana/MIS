<style>
	.chartbox {
		margin: 0 10px 15px 10px;
	}

	.chart-container {
		border: 2px solid #01c0c8;
		box-shadow: 0 0 10px rgba(0,0,0,.15), 0 3px 3px rgba(0,0,0,.15);
		margin-bottom: 15px;
	}
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<a href="/Entomology/Mosquito" class="btn btn-default">Mosquito Collection</a>
			<a href="/Entomology/Insecticide" class="btn btn-default">Insecticide Resistance</a>
			<a href="/Entomology/Dashboard" class="btn btn-info">Dashboard</a>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-heading form-inline relative">
		<div class="input-group">
			<span class="input-group-addon">From</span>
			<input type="text" class="form-control text-center width100" data-bind="datePicker: from, format: 'MMM YYYY'" />
			<span class="input-group-addon">To</span>
			<input type="text" class="form-control text-center width100" data-bind="datePicker: to, format: 'MMM YYYY'" />
		</div>
        <div class="input-group">
			<span class="input-group-addon">Province</span>
			<input type="text" class="form-control width150" data-bind="value: getProvInfo(), click: () => $('#modalProv').modal('show')" style="cursor:pointer" readonly />
		</div>
		<div class="input-group">
			<span class="input-group-addon">Foci Investigation</span>
			<select class="form-control" data-bind="value: isFoci">
				<option>All</option>
				<option>Yes</option>
				<option>No</option>
			</select>
		</div>
		<div class="input-group">
			<span class="input-group-addon">Location</span>
			<select class="form-control" data-bind="value: trap">
				<option>All</option>
				<option>Indoor</option>
				<option>Outdoor</option>
			</select>
		</div>
		<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<div class="chart-container">
			<div id="pie" class="chartbox"></div>
		</div>
		<div class="chart-container">
			<div id="abdominalStage" class="chartbox"></div>
		</div>

        <div class="chart-container" style="width:fit-content; margin-left:auto; margin-right:auto">
			<table class="table table-bordered widthauto">
				<thead>
					<tr>
						<th align="center" valign="middle" width="40">#</th>
						<th align="center" valign="middle">Foci Number</th>
						<th align="center" valign="middle">Primary Species Collected<br>(An. dirus s.l., An. minimus s.l., An. maculatus s.l.)</th>
						<th align="center" valign="middle">Total Anopheles Female Collected</th>
                        <th align="center" valign="middle">Primary Vectors<br>(Foci Program)</th>
                        <th align="center" valign="middle">Secondary Vectors<br>(Foci Program)</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: tableFoci">
					<tr data-bind="css: { 'text-danger': PrimaryCollected != PrimaryVectorQty }">
						<td align="center" data-bind="text: $index() + 1"></td>
						<td align="center" data-bind="text: FociNumber"></td>
						<td align="center" data-bind="text: PrimaryCollected"></td>
						<td align="center" data-bind="text: TotalCollected"></td>
						<td align="center" data-bind="text: PrimaryVectorQty"></td>
						<td align="center" data-bind="text: SecondaryVectorQty"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="chart-container">
			<div id="map" class="chartbox"></div>
		</div>
		<div class="chart-container">
			<div id="mapFoci" class="chartbox"></div>
		</div>
		<div class="chart-container form-inline">
			<div class="input-group" style="padding:10px">
				<span class="input-group-addon">Foci Number</span>
				<select class="form-control" data-bind="value: hourlyFoci, options: fociList, optionsCaption: ''"></select>
			</div>
			<select class="form-control" data-bind="value: hourlyMethod">
                <option value="Double Net Trap with Human Attractant">Human Double Net</option>
                <option value="Double Net Trap with Cow Attractant">Cow Double Net</option>
                <option value="Cattle-Baited Tent Trap">Cattle-Baited Tent Trap</option>
            </select>

			<div id="chartHourlyBiting" class="chartbox"></div>
		</div>
		<div class="chart-container">
			<div id="chartMonthlyBitingHDN" class="chartbox"></div>
		</div>
		<div class="chart-container">
			<div id="chartMonthlyBitingCDN" class="chartbox"></div>
		</div>
		<div class="chart-container">
			<div id="chartMonthlyBitingCDC" class="chartbox"></div>
		</div>
		<div class="chart-container">
			<div id="chartMonthlyBitingCBT" class="chartbox"></div>
		</div>
		<div class="chart-container">
			<div id="chartMortality" class="chartbox" style="height:500px"></div>

            <div class="text-center" style="margin:15px">
                <label class="radio-inline radio-lg">
                    <input type="radio" name="mortalitySpecies" value="An. dirus s.l." data-bind="checked: mortalitySpecies" />
                    <b>An. dirus s.l.</b>
                </label>
                <label class="radio-inline radio-lg">
                    <input type="radio" name="mortalitySpecies" value="An. maculatus s.l." data-bind="checked: mortalitySpecies" />
                    <b>An. maculatus s.l.</b>
                </label>
                <label class="radio-inline radio-lg">
                    <input type="radio" name="mortalitySpecies" value="An. minimus s.l." data-bind="checked: mortalitySpecies" />
                    <b>An. minimus s.l.</b>
                </label>
            </div>
		</div>
	</div>
</div>

<div class="modal" id="modalProv" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Select Province</h3>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-xs-6" data-bind="foreach: provList.slice(0, 11)">
                        <div class="form-group checkbox checkbox-lg">
                            <label>
                                <input type="checkbox" data-bind="checked: $root.selectedProv, attr: { value: code }" />
                                <span data-bind="text: name"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-6" data-bind="foreach: provList.slice(11)">
                        <div class="form-group checkbox checkbox-lg">
                            <label>
                                <input type="checkbox" data-bind="checked: $root.selectedProv, attr: { value: code }" />
                                <span data-bind="text: name"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
			<div class="modal-footer clearfix">
                <div class="pull-left">
                    <button class="btn btn-default width100" data-bind="click: () => selectedProv(provList().map(r => r.code))">Select All</button>
                    <button class="btn btn-default width100" data-bind="click: () => selectedProv.removeAll()">Select None</button>
                </div>
                <div class="pull-right">
                    <button class="btn btn-primary width100" data-dismiss="modal">OK</button>
                </div>
			</div>
		</div>
	</div>
</div>

<?=form_hidden('chartODBorder', latestFile('/media/Maps/chartODBorder.js'))?>
<?=latestJs('/media/ViewModel/Entomology_Dashboard.js')?>