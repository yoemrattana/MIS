<!-- ko with: dashboard -->
<div class="panel-heading" data-bind="visible: $root.menu() == 'Dashboard'">
	<div class="form-inline">
		<select class="form-control" data-bind="value: version">
			<option value="1">Dashboard 1</option>
			<option value="2">Dashboard 2</option>
		</select>
		<div class="input-group">
			<span class="input-group-addon text-bold">From</span>
			<input type="text" class="form-control text-center width100" data-bind="datePicker: mf, format: 'MMM YYYY', minDate: '2022-01-01'" />
			<span class="input-group-addon text-bold">To</span>
			<input type="text" class="form-control text-center width100" data-bind="datePicker: mt, format: 'MMM YYYY', minDate: mf" />
		</div>
		<!-- ko if: version() == 2 -->
		<div class="input-group">
			<span class="input-group-addon text-bold">Species</span>
			<select class="form-control" data-bind="value: species">
				<option value="">All</option>
				<option value="V">Pv</option>
				<option value="F">Pf</option>
				<option value="M">Mix</option>
				<option value="A">Pm</option>
				<option value="K">Pk</option>
				<option value="0">Po</option>
			</select>
		</div>
		<!-- /ko -->

		<button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
	</div>
</div>

<div class="panel-body" data-bind="visible: $root.menu() == 'Dashboard' && version() == 1 && loaded()">
	<h4>A. Outcome Indicators</h4>
	<div class="chart-container">
		<div id="chartOutcome1"></div>
	</div>

	<div class="chart-container">
		<div id="chartOutcome2"></div>
	</div>
	<br />
	<br />

	<h4>B. Process Indicators</h4>
	<div class="chart-container">
		<div id="chartProcess1"></div>
	</div>

	<div class="chart-container">
		<div id="chartProcess3"></div>
	</div>
</div>

<div class="panel-body" data-bind="visible: $root.menu() == 'Dashboard' && version() == 2 && loaded2()">
	<h3 class="text-center text-primary" style="margin-bottom:30px">The Integrated Drug Efficacy Surveillance (iDES)</h3>

	<div class="chart-container form-inline">
		<div class="input-group">
			<span class="input-group-addon">Province</span>
			<select class="form-control" data-bind="value: follow2Prov, options: $root.pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
		</div>
		<div class="input-group">
			<span class="input-group-addon">Species</span>
			<div class="input-group-btn">
				<button class="btn btn-default dropdown-toggle width150" style="padding:6px 6px 6px 12px; text-align:right" data-toggle="dropdown">
					<span class="pull-left" data-bind="text: follow2Species().length == speciesList.length ? 'All' : follow2Species().join(' ')"></span>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" data-bind="foreach: speciesList">
					<li>
						<a class="no-padding">
							<div class="checkbox checkbox-lg display-block">
								<label class="display-block" style="padding:3px">
									<input type="checkbox" name="follow2Species" data-bind="checked: $parent.follow2Species, attr: { value: $data }" />
									<span data-bind="text: $data"></span>
								</label>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div id="chartFollowup2"></div>
	</div>

	<div class="row">
		<div class="col-xs-6">
			<div class="chart-container">
				<div id="chartMap" style="height:600px"></div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="chart-container">
				<div id="chartMap2" style="height:600px"></div>
			</div>
		</div>
	</div>
</div>
<!-- /ko -->