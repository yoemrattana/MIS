<!-- ko with: graph -->
<div class="panel-heading clearfix relative" data-bind="visible: $root.menu() == 'Graphs'">
	<div class="pull-left">
		<div class="inlineblock">
			<div class="text-bold">Graph</div>
			<select class="form-control" data-bind="value: filter">
				<option>iDES follow up rate</option>
				<option>Geographical Distribution of Cases</option>
				<option>Case Enrollment</option>
				<option>Weekly Case Enrollment</option>
				<option>Blood Slides/DBS</option>
				<option>Samples Collected</option>
				<option>iDES cases with side effects</option>
				<option>PCR Result</option>
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
		<div class="inlineblock">
			<div class="text-bold">Species</div>
			<select class="form-control minwidth100" data-bind="value: species">
				<option value="">All</option>
				<option value="F">Pf</option>
				<option value="V">Pv</option>
				<option value="M">Mix</option>
				<option value="A">Pm</option>
				<option value="K">Pk</option>
				<option value="O">Po</option>
			</select>
		</div>
		<div class="inlineblock">
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

<div class="panel-body" data-bind="visible: $root.menu() == 'Graphs' && loaded()">
	<!-- ko if: filter() == 'iDES follow up rate' -->
	<h4 class="text-primary">Graph 1</h4>
	<div class="chart-container">
		<div id="chartFollowup"></div>
	</div>

	<div class="row">
		<div class="col-xs-6">
			<h4 class="text-primary">Graph 11</h4>
			<div class="chart-container">
				<div id="chartPv"></div>
			</div>
		</div>
		<div class="col-xs-6">
			<h4 class="text-primary">Graph 12</h4>
			<div class="chart-container">
				<div id="chartPf"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<h4 class="text-primary">Graph 13</h4>
			<div class="chart-container">
				<div id="chartPm"></div>
			</div>
		</div>
		<div class="col-xs-6">
			<h4 class="text-primary">Graph 14</h4>
			<div class="chart-container">
				<div id="chartPk"></div>
			</div>
		</div>
	</div>
	<!-- /ko -->

	<!-- ko if: filter() == 'Geographical Distribution of Cases' -->
	<div class="row">
		<div class="col-xs-6">
			<h4 class="text-primary">Graph 2</h4>
			<div class="chart-container">
				<div id="chartMap" style="height:600px"></div>
			</div>
		</div>
		<div class="col-xs-6">
			<h4 class="text-primary">Graph 3</h4>
			<div class="chart-container">
				<div id="chartMap2" style="height:600px"></div>
			</div>
		</div>
	</div>
	<!-- /ko -->

	<!-- ko if: filter() == 'Case Enrollment' -->
	<h4 class="text-primary">Graph 4</h4>
	<div class="chart-container">
		<div id="chartCaseEnroll"></div>
	</div>

	<h4 class="text-primary">Graph 5</h4>
	<div class="chart-container">
		<div id="chartCaseEnrollOD"></div>
	</div>
	<!-- /ko -->

	<!-- ko if: filter() == 'Weekly Case Enrollment' -->
	<h4 class="text-primary">Graph 6</h4>
	<div class="chart-container">
		<div id="chartiDesWeek"></div>
	</div>
	<!-- /ko -->

	<!-- ko if: filter() == 'Blood Slides/DBS' -->
	<h4 class="text-primary">Graph 7</h4>
	<div class="chart-container">
		<div id="chartDBS"></div>
	</div>
	<!-- /ko -->

	<!-- ko if: filter() == 'Samples Collected' -->
	<h4 class="text-primary">Graph 8</h4>
	<div class="chart-container">
		<div id="chartSample"></div>
	</div>
	<!-- /ko -->

	<!-- ko if: filter() == 'iDES cases with side effects' -->
	<h4 class="text-primary">Graph 9</h4>
	<div class="chart-container">
		<div id="chartSideEffect"></div>
	</div>
	<!-- /ko -->

	<!-- ko if: filter() == 'PCR Result' -->
	<h4 class="text-primary">Graph 10</h4>
	<div class="chart-container">
		<div id="chartPCR"></div>
	</div>
	<!-- /ko -->
</div>
<!-- /ko -->