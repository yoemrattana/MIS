<style>
	table.ip-place tr {
		padding-bottom: 5px;
	}
	.inten.active {
		background-color: #f8f9fa;
	}
	table.tableIPSLDP th {border:none}
	table.tableIPSLDP {border-top:none !important}
</style>
<div data-bind="visible: tab() == 'Intensification Plan' && app.user.permiss['Dashboard'].contain('Intensification Plan')" style="display: none">
	<div class="row">
		<div class="col-12">
			<h3>Intensification Plan</h3>
			<div class="card" style="line-height:15px">
				<div class="left-aside bg-light-part">
					<!---->
					<table class="ip-place table-hover" style="font-size:12px; font-weight:500; width:100%">
						<thead>
							<tr>
								<td colspan="2">
									<select class="form-control input-sm" data-bind="value: ip" style="width:100%">
										<option value="1">IP1</option>
										<option value="2">IP2</option>
									</select>
								</td>
							</tr>
							<tr>
								<th style="font-weight:700; padding-top:10px">Place</th>
								<th style="padding-top:10px" align="center">
									<input type="checkbox" data-bind="click: changeTick30HF" style="margin:0;" checked />
								</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: table30HF">
							<tr>
								<td data-bind="text: cso, style: { color: color }" class="text-bold" style="padding:10px 0 0 5px"></td>
								<td align="center" valign="bottom" width="20" style="padding:0">
									<input type="checkbox" data-bind="checked: checked, click: tickChange" style="margin:0" />
								</td>
							</tr>
							<!-- ko foreach: ods -->
							<tr>
								<td data-bind="text: od, style: { color: color }" class="text-bold" style="padding:0 0 0 15px"></td>
								<td align="center" valign="bottom" width="20" style="padding:0">
									<input type="checkbox" data-bind="checked: checked, click: tickChange" style="margin:0" />
								</td>
							</tr>
							<!-- ko foreach: hfs -->
							<tr>
								<td data-bind="text: hf, style: { color: color }" style="padding:0 0 0 25px"></td>
								<td align="center" width="20" style="padding:0">
									<input type="checkbox" data-bind="checked: checked, click: tickChange" style="margin:0" />
								</td>
							</tr>
							<!-- /ko -->
							<!-- /ko -->
						</tbody>
					</table>
					<br />
					<!-- ko if: $root.ip() == '2'-->
					<table class="table color-bordered-table info-bordered-table table-striped" style="font-size:12px">
						<thead>
							<tr>
								<th width="20" style="padding:0 !important; border-top:none">Positive Rate By Primaquine</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="20" style="padding:0 !important; border-top:none" data-bind="text: $root.primaquineRate() + ' %'"></td>
							</tr>
						</tbody>
					</table>
					<!-- /ko -->
				</div><!--/left-side-->

				<div class="right-aside">
					<div>
						<div class="chart-container form-group">
							<div id="chartIntenSpecies" class="chartbox no-margin"></div>
							<div class="btn">
								<label class="checkbox-inline checkbox-sm">
									<input class="chartIntenSpeciesCbox" id="PF" type="checkbox" checked />
									<span>PF</span>
								</label>
								<label class="checkbox-inline checkbox-sm">
									<input class="chartIntenSpeciesCbox" id="PV" type="checkbox" checked />
									<span>PV</span>
								</label>
								<label class="checkbox-inline checkbox-sm">
									<input class="chartIntenSpeciesCbox" id="Mix" type="checkbox" checked />
									<span>Mix</span>
								</label>
							</div>
						</div>
					</div>

					<div class="chart-container form-group">
						<div id="chartIntenFacility" class="chartbox no-margin" style="height:450px"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input class="chartIntenFacilityCbox" value="pf" data-bind="change: drawChartIntenFacility" type="checkbox" checked />
								<span>PF</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="chartIntenFacilityCbox" value="pv" data-bind="change: drawChartIntenFacility" type="checkbox" checked />
								<span>PV</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="chartIntenFacilityCbox" value="mix" data-bind="change: drawChartIntenFacility" type="checkbox" checked />
								<span>Mix</span>
							</label>
						</div>
					</div>

					<div class="chart-container form-group">
						<div id="chartIntenRate" class="chartbox no-margin"></div>
					</div>
					
					<div style="position:absolute">
						<select class="form-control" data-bind="change: drawChartIntenTop10Vill, options: ipFilterDateList, optionsCaption: 'All Months'"></select>
					</div> <br /><br /><br />

					<div class="chart-container form-group">
						<div id="chartIntenTop10Vill" class="chartbox no-margin"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input id="chartIntenTop10VillPf" type="checkbox" data-bind="click: drawChartIntenTop10Vill" checked />
								<span>PF</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input id="chartIntenTop10VillPv" type="checkbox" data-bind="click: drawChartIntenTop10Vill" checked />
								<span>PV</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input id="chartIntenTop10VillMix" type="checkbox" data-bind="click: drawChartIntenTop10Vill" checked />
								<span>Mix</span>
							</label>
						</div>
					</div>
					
					<div class="form-group" data-bind="visible: $root.ip() == 2">
						<div style="border:1px solid #2b908f; padding:10px">
							<div class="chart-container form-group">
								<div id="chartSLDP" class="chartbox no-margin"></div>
							</div>
							<table class="tableIPSLDP table color-bordered-table info-bordered-table table-hover box-shadow">
								<thead>
									<tr>
										<th rowspan="2" align="center" valign="middle">CSO</th>
										<th rowspan="2" align="center" valign="middle">HF Name</th>
										<!-- ko foreach: ipFilterDateList -->
										<th colspan="3" align="center" data-bind="text: $data; css: $parent.headerColor($index)"></th>
										<!-- /ko -->
									</tr>
									<tr data-bind="foreach: ipFilterDateList">
										<th class="bg-info" align="center">PF + Mix</th>
										<th class="bg-primary" align="center">SLDP</th>
										<th class="bg-warning" align="center">%</th>
									</tr>
								</thead>
								<tbody data-bind="foreach: tableIPSLDP, fixedHeader: true">
									<tr data-bind="css: HF == 'Total' ? 'text-bold info' : HF == 'Grand Total' ? 'text-bold success' : ''">
										<!-- ko if: RowSpan > 0 -->
										<td style="border-right: 1px solid #ccc" data-bind="text: CSO, attr: { rowSpan: RowSpan }" align="center" valign="middle"></td>
										<!-- /ko -->

										<td data-bind="text: HF"></td>
										<!-- ko foreach: Values -->
										<td align="right" data-bind="text: pfmix"></td>
										<td align="right" data-bind="text: sldp"></td>
										<td class="inten" align="right" data-bind="text: isnot(percent, '', r => r + '%'), style: { color: percent < 90 ? 'red' : 'green' }, css: { 'active': !$parent.HF.contain('Total') }"></td>
										<!-- /ko -->
									</tr>
								</tbody>
							</table>
						</div>

						<br />
						<div style="position:absolute">
							<select class="form-control" data-bind="value: ipFilterDate, options: ipFilterDateList, optionsCaption: 'All Months'"></select>
						</div>
						<h3 class="text-center text-primary">
							<span>Table of Summary Data By HFs in IP2, DEC 2019 - </span>
							<span class="text-uppercase" data-bind="text: moment().add(-1, 'months').format('MMM YYYY')"></span>
						</h3>
						<table class="tableIPSLDP table color-bordered-table info-bordered-table table-striped table-hover box-shadow">
							<thead>
								<tr>
									<th rowspan="2" align="center" valign="middle">CSO</th>
									<th class="bg-info" rowspan="2" align="center" valign="middle">HF Name</th>
									<th colspan="5" align="center">Positive Case</th>
									<th class="bg-info" colspan="2" align="center" valign="middle">Outreach (MMW - IP)</th>
									<th rowspan="2" align="center" valign="middle">Primaquine</th>
									<th class="bg-info" rowspan="2" align="center" valign="middle">Forest Pack</th>
								</tr>
								<tr>
									<th class="bg-success" align="center">HF</th>
									<th class="bg-primary" align="center">MMW - IP</th>
									<th class="bg-purple" align="center">MMW - Non IP</th>
									<th class="bg-success" align="center">VMW</th>
									<th class="bg-warning" align="center">Total</th>
									<th class="bg-cyan" align="center">Test</th>
									<th class="bg-danger" align="center">Positive</th>
								</tr>
							</thead>
							<tbody data-bind="foreach: tableIPCase, fixedHeader: true">
								<tr data-bind="css: HFName == 'Total' ? 'text-bold info' : HFName == 'Grand Total' ? 'text-bold success' : ''">
									<!-- ko if: RowSpan > 0 -->
									<td style="border-right: 1px solid #ccc" data-bind="text: CSO, attr: { rowSpan: RowSpan }" align="center" valign="middle"></td>
									<!-- /ko -->

									<td data-bind="text: HFName"></td>
									<td align="right" data-bind="text: HF"></td>
									<td align="right" data-bind="text: MMWIP"></td>
									<td align="right" data-bind="text: MMW"></td>
									<td align="right" data-bind="text: VMW"></td>
									<td align="right" data-bind="text: Positive"></td>
									<td align="right" data-bind="text: OutreachTest"></td>
									<td align="right" data-bind="text: OutreachPositive"></td>
									<td align="right" data-bind="text: PrimaquineACT"></td>
									<td align="right" data-bind="text: ForestPack"></td>
								</tr>
							</tbody>
						</table>

						<br />
						<div style="position:absolute">
							<select class="form-control" data-bind="value: ipFilterDate, options: ipFilterDateList, optionsCaption: 'All Months'"></select>
						</div>
						<h3 class="text-center text-primary">
							<span>Table of Out Reach Data By HFs in IP2, DEC 2019 - </span>
							<span class="text-uppercase" data-bind="text: moment().add(-1, 'months').format('MMM YYYY')"></span>
						</h3>
						<table class="tableIPSLDP table color-bordered-table info-bordered-table table-striped table-hover box-shadow">
							<thead>
								<tr>
									<th rowspan="2" align="center" valign="middle">CSO</th>
									<th class="bg-danger" rowspan="2" align="center" valign="middle">HF Name</th>
									<th colspan="3" align="center">Test</th>
									<th class="bg-danger" colspan="3" align="center">PF</th>
									<th colspan="3" align="center">PV</th>
									<th class="bg-danger" colspan="3" align="center">Mix</th>
									<th colspan="3" align="center">Positive</th>
								</tr>
								<tr data-bind="foreach: Array(5)">
									<th class="bg-info" align="center">Passive</th>
									<th class="bg-primary" align="center">Out Reach</th>
									<th class="bg-purple" align="center">Total</th>
								</tr>
							</thead>
							<tbody data-bind="foreach: tableIPOutReach, fixedHeader: true">
								<tr data-bind="css: HF == 'Total' ? 'text-bold info' : HF == 'Grand Total' ? 'text-bold success' : ''">
									<!-- ko if: RowSpan > 0 -->
									<td style="border-right: 1px solid #ccc" data-bind="text: CSO, attr: { rowSpan: RowSpan }" align="center" valign="middle"></td>
									<!-- /ko -->

									<td data-bind="text: HF"></td>

									<td align="right" data-bind="text: TestPassive"></td>
									<td align="right" data-bind="text: TestOutReach"></td>
									<td align="right" data-bind="text: TestTotal"></td>

									<td align="right" data-bind="text: PfPassive"></td>
									<td align="right" data-bind="text: PfOutReach"></td>
									<td align="right" data-bind="text: PfTotal"></td>

									<td align="right" data-bind="text: PvPassive"></td>
									<td align="right" data-bind="text: PvOutReach"></td>
									<td align="right" data-bind="text: PvTotal"></td>

									<td align="right" data-bind="text: MixPassive"></td>
									<td align="right" data-bind="text: MixOutReach"></td>
									<td align="right" data-bind="text: MixTotal"></td>

									<td align="right" data-bind="text: PositivePassive"></td>
									<td align="right" data-bind="text: PositiveOutReach"></td>
									<td align="right" data-bind="text: PositiveTotal"></td>
								</tr>
							</tbody>
						</table>
					</div>

					<br />
					<div class="inlineblock" style="margin-bottom:5px">
						<select class="form-control" data-bind="value: ipFilterDate, options: ipFilterDateList, optionsCaption: 'All Months'"></select>
					</div>
					<div class="chart-container">
						<div id="chartIntenMap" class="chartbox no-margin" style="height:800px"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input class="chartIntenMapCbox" specie="F" type="checkbox" checked data-bind="click: drawIntenMap" />
								<span>PF</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="chartIntenMapCbox" specie="V" type="checkbox" checked data-bind="click: drawIntenMap" />
								<span>PV</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="chartIntenMapCbox" specie="M" type="checkbox" checked data-bind="click: drawIntenMap" />
								<span>Mix</span>
							</label>
						</div>
					</div>

					<div data-bind="visible: $root.ip() == 2" class="chart-container" style="margin-top: 10px">
						<br />
						<div style="position:absolute">
							<select class="form-control" data-bind="value: ipFilterDate, options: ipFilterDateList, optionsCaption: 'All Months'"></select>
						</div>
						<h3 class="text-center text-primary">
							<span>Out Reach Test and Positive of MMW-IP2, DEC 2019 - </span>
							<span class="text-uppercase" data-bind="text: moment().add(-1, 'months').format('MMM YYYY')"></span>
						</h3>
						<div id="IP2Map" class="chartbox no-margin" style="height:800px"></div>
					</div>
				</div><!--/right-side-->
			</div><!--/card-->
		</div>
	</div>
</div>