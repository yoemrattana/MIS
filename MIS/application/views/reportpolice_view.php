<style>
	.frame {
		margin: 5px;
		float: left;
		height: 250px;
		border: 1px solid #ccc;
		padding: 10px;
	}
	.frame header { 
		font-weight: bold;
		margin: -10px -10px 10px -10px;
		background-color: #428bca;
		padding: 6px 10px;
		color: white;
		font-size: 16px;
	}
	.frame table td { padding: 5px; }
	input[type="radio"] {  margin: 4px 0 0; }

	@media print {
		.panel.print { border: none; }
		.panel-heading.print { border: none; padding: 0; }
		.panel-body.print { padding: 0; }
	}
</style>

<div class="panel panel-default" style="display:none" data-bind="visible: report() == null">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh28">
			<b>Reports Police</b>
		</div>
		<div class="pull-right">
			<a href="/Home"><img src="/media/images/home_back.png" /></a>
		</div>
	</div>

	<div class="panel-body">
		<div class="frame">
			<div class="pull-left" style="width:220px">
				<table>
					<tr>
						<td style="padding-top:7px">
							<span style="margin-left:20px">Year</span>
						</td>
						<td>
							<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button class="btn btn-default" data-bind="click: previousClick">
										<i class="glyphicon glyphicon-triangle-left"></i>
									</button>
								</span>
								<input type="text" class="form-control text-center" data-bind="value: year" readonly />
								<span class="input-group-btn">
									<button class="btn btn-default" data-bind="click: nextClick">
										<i class="glyphicon glyphicon-triangle-right"></i>
									</button>
								</span>
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding-top:7px">
							<label class="radio-inline">
								<input type="radio" name="filterType" value="quarter" data-bind="checked: filterType" />
								<span>Quarter</span>
							</label>
						</td>
						<td>
							<select class="form-control input-sm" data-bind="value: quarter, enable: filterType() == 'quarter'">
								<option>Q1</option>
								<option>Q2</option>
								<option>Q3</option>
								<option>Q4</option>
							</select>
						</td>
					</tr>
					<tr>
						<td style="padding-top:7px">
							<label class="radio-inline">
								<input type="radio" name="filterType" value="month" data-bind="checked: filterType" />
								<span>Month</span>
							</label>
						</td>
						<td>
							<select class="form-control input-sm" data-bind="value: month, options: monthList, optionsValue: 'value', optionsText: 'text', enable: filterType() == 'month'"></select>
						</td>
					</tr>
					<tr>
						<td style="padding-top:7px">
							<label class="radio-inline">
								<input type="radio" name="filterType" value="custom" data-bind="checked: filterType" />
								<span>Custom</span>
							</label>
						</td>
						<td>
							<div class="row">
								<div class="col-xs-6" style="padding-right:5px">
									<select class="form-control input-sm" data-bind="value: from, options: monthList, optionsValue: 'value', optionsText: 'text', enable: filterType() == 'custom'"></select>
								</div>
								<div class="col-xs-6" style="padding-left:5px">
									<select class="form-control input-sm" data-bind="value: to, options: monthList, optionsValue: 'value', optionsText: 'text', enable: filterType() == 'custom'"></select>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<button class="btn btn-primary btn-sm btn-block" data-bind="click: resetClick">Reset</button>
						</td>
					</tr>
				</table>
			</div>

			<div class="pull-left" style="width:170px; margin-left:30px">
				<div class="form-group">
					<span>Province</span>
					<select class="form-control kh" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: 'All'"></select>
				</div>
				<div class="form-group">
					<span>Troop</span>
					<select class="form-control kh" data-bind="value: tp, options: tpList, optionsValue: 'code', optionsText: 'nameK', optionsCaption: 'All'"></select>
				</div>
			</div>
		</div>

		<div class="frame">
			<header>Reports</header>
			<button name="SP_PLBednetReport" class="btn btn-primary btn-block" data-bind="click: getReport">Bed Net Report</button>
		</div>

	</div>
</div>

<div class="panel panel-default print" style="display:none; margin:-10px" data-bind="visible: report() != null">
	<div class="panel-heading clearfix print">
		<div class="pull-left font16 lh26">
			<b data-bind="text: title"></b>
		</div>
		<div class="pull-right">
			<button class="btn btn-default btn-sm width100 hidden-print" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body print">

		

		<!-- ko if: report() == 'SP_PLBednetReport' -->
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Place</th>
					<th align="center">LLIN</th>
					<th align="center">LLIHN</th>
					<th align="center">Hamok Net</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr data-bind="with: $data, css: {'text-bold': $index() == 0}">
					<td data-bind="text: ($index() == 0 ? '' : '&emsp;') + Place" class="kh"></td>
					<td data-bind="text: LLIN" align="center"></td>
					<td data-bind="text: LLIHN" align="center"></td>
					<td data-bind="text: HamokNet" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
		<!-- /ko -->

	</div>
</div>

<?=latestJs('/media/ViewModel/ReportPolice.js')?>