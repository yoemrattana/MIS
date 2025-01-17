<style>
	#tabMap path.highcharts-point { opacity: 1 !important; }
</style>

<div id="tabMap" data-bind="visible: tab() == 'Border' && app.user.permiss['Dashboard'].contain('Border')" style="display: none">
	<div class="chart-container card">
		<div id="chartborder" class="chartbox"></div>
		<div class="btn" style="opacity:1">
			<label class="checkbox-inline checkbox-sm">
				<input class="borderCbox" id="Lao" type="checkbox" checked />
				<span>Lao</span>
			</label>
			<label class="checkbox-inline checkbox-sm">
				<input class="borderCbox" id="Thailand" type="checkbox" checked />
				<span>Thailand</span>
			</label>
			<label class="checkbox-inline checkbox-sm">
				<input class="borderCbox" id="Vietnam" type="checkbox" checked />
				<span>Vietnam</span>
			</label>
			<label class="checkbox-inline checkbox-sm">
				<input class="borderCboxFilter" col="Type" val="HC" type="checkbox" checked data-bind="click: drawBorderChart" />
				<span>HC</span>
			</label>
			<label class="checkbox-inline checkbox-sm">
				<input class="borderCboxFilter" col="Type" val="VMW" type="checkbox" checked data-bind="click: drawBorderChart" />
				<span>VMW</span>
			</label>
			<label class="checkbox-inline checkbox-sm">
				<input class="borderCboxFilter" col="Diagnosis" val="F" type="checkbox" checked data-bind="click: drawBorderChart" />
				<span>PF</span>
			</label>
			<label class="checkbox-inline checkbox-sm">
				<input class="borderCboxFilter" col="Diagnosis" val="V" type="checkbox" checked data-bind="click: drawBorderChart" />
				<span>PV</span>
			</label>
			<label class="checkbox-inline checkbox-sm">
				<input class="borderCboxFilter" col="Diagnosis" val="M" type="checkbox" checked data-bind="click: drawBorderChart" />
				<span>Mix</span>
			</label>
		</div>
	</div>

	<div class="chart-container card" style="width:fit-content; margin-left:auto; margin-right:auto">
		<div id="mapCommuneBorder" class="chartbox" style="min-width:1300px; height:600px"></div>
	</div>

	<div class="chart-container card" style="width:fit-content; margin-left:auto; margin-right:auto">
		<div id="mapCommuneBorderPfMix" class="chartbox" style="min-width:1300px; height:600px"></div>
	</div>

	<div class="chart-container card" style="width:fit-content; margin-left:auto; margin-right:auto">
		<div id="mapCommuneBorderPv" class="chartbox" style="min-width:1300px; height:600px"></div>
	</div>
</div>