<?php
$isMobile = $this->agent->is_mobile();
?>
<div class="overview" data-bind="visible: tab() == 'Overview' && app.user.permiss['Dashboard'].contain('Overview')" style="display:none; min-width:1600px">
	<div class="row">
        <div class="col-sm-6">
            <div data-bind="hidden: overviewPart2Ready">
			    <?php $this->load->view('skeleton_loading') ?>
		    </div> <!--Loading end-->

            <div data-bind="visible: overviewPart2Ready" class="d-flex flex-row card1 border-color1" style="align-items:center;  display:none !important">
                <div class="col-sm-12 text-center">
                    <div class="row">
                        <h3>Today Case</h3>
                    </div>
                    <div class="row" data-bind="with: dailyCase">
                        <div class="col-sm-2">
                            <div class="card" param="F" data-bind="click: $root.showDailyCase" style="cursor: pointer;">
                              <h5 style="font-weight:bold; background:#3498db; color: white; font-size:20px" class="card-header">Pf</h5>
                              <div class="card-body" style="border: 1px solid #3498db; background:#3498db; opacity:0.3">
                                <h5 class="card-title" style="color: white; font-size:28px; font-weight:bold; opacity:1" data-bind="text: Pf">12</h5>
                              </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="card" param="V" data-bind="click: $root.showDailyCase" style="border: none; cursor: pointer;">
                              <h5 style="font-weight:bold; background:#1abc9c; color: white; font-size:20px" class="card-header">Pv</h5>
                              <div class="card-body" style="border: 1px solid #1abc9c; background:#1abc9c; opacity:0.3">
                                <h5 class="card-title" style="color: white; font-size:28px; font-weight:bold; opacity:1" data-bind="text: Pv">12</h5>
                              </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="card" param="M" data-bind="click: $root.showDailyCase" style="border: none; cursor: pointer;">
								<h5 style="font-weight:bold; background:#f39c12; color: white; font-size:20px" class="card-header no-padding-horizontal">
									Mix
									<span style="font-size:12px">(Pf + Pv)</span>
								</h5>
                              <div class="card-body" style="border: 1px solid #f39c12; background:#f39c12; opacity:0.3">
                                <h5 class="card-title" style="color: white; font-size:28px; font-weight:bold; opacity:1" data-bind="text: Mix">12</h5>
                              </div>
                            </div>
                        </div>

						<div class="col-sm-2">
							<div class="card" param="A" data-bind="click: $root.showDailyCase" style="cursor: pointer;">
								<h5 style="font-weight:bold; background:#3498db; color: white; font-size:20px" class="card-header">Pm</h5>
								<div class="card-body" style="border: 1px solid #3498db; background:#3498db; opacity:0.3">
									<h5 class="card-title" style="color: white; font-size:28px; font-weight:bold; opacity:1" data-bind="text: Pm">12</h5>
								</div>
							</div>
						</div>

						<div class="col-sm-2">
							<div class="card" param="O" data-bind="click: $root.showDailyCase" style="border: none; cursor: pointer;">
								<h5 style="font-weight:bold; background:#1abc9c; color: white; font-size:20px" class="card-header">Po</h5>
								<div class="card-body" style="border: 1px solid #1abc9c; background:#1abc9c; opacity:0.3">
									<h5 class="card-title" style="color: white; font-size:28px; font-weight:bold; opacity:1" data-bind="text: Po">12</h5>
								</div>
							</div>
						</div>

						<div class="col-sm-2">
							<div class="card" param="K" data-bind="click: $root.showDailyCase" style="border: none; cursor: pointer;">
								<h5 style="font-weight:bold; background:#f39c12; color: white; font-size:20px" class="card-header">Pk</h5>
								<div class="card-body" style="border: 1px solid #f39c12; background:#f39c12; opacity:0.3">
									<h5 class="card-title" style="color: white; font-size:28px; font-weight:bold; opacity:1" data-bind="text: Pk">12</h5>
								</div>
							</div>
						</div>

                    </div>
                </div>
            </div> <!--today case end-->

            <br/>

            <div data-bind="hidden: overviewPart3Ready">
                <?php $this->load->view('skeleton_loading') ?>
		    </div> <!--Loading end-->

            <div data-bind="visible: overviewPart3Ready" class="d-flex flex-row card1 border-color1" style="align-items:center; padding: 5px;display:none !important">
                <div class="col-sm-12 text-center">
                    <div class="row">
                        <h3>Malaria Case in <span data-bind="text: moment().add(-1, 'M').format('MMMM YYYY') + ' - '+ moment().format('MMMM YYYY')"></span></h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card" style="cursor: pointer;">
                              <div class="card-body1">
                                 <div class="chart-container1" style="border: none;">
                                     <div id="pfChart" class="chartbox1"></div>
                                 </div>
                              </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card" style="cursor: pointer;">
                              <div class="card-body1">
                                 <div class="chart-container1" style="border: none">
                                     <div id="pvChart" class="chartbox1"></div>
                                 </div>
                              </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card" style="cursor: pointer;">
                              <div class="card-body1">
                                 <div class="chart-container1" style="border: none">
                                     <div id="mixChart" class="chartbox1"></div>
                                 </div>
                              </div>
                            </div>
                        </div>

						<div class="col-sm-3">
							<div class="card" style="cursor: pointer;">
								<div class="card-body1">
									<div class="chart-container1" style="border: none">
										<div id="pmpopkChart" class="chartbox1"></div>
									</div>
								</div>
							</div>
						</div>

                    </div>
                </div>
            </div> <!--this month case end-->
        </div> <!--end col-sm-6-->

        <!--slide go here-->
        <div class="col-sm-6">
            <?php if(!$isMobile) :?>
            <!-- ko if: slideShow().length == 1 -->
            <img width="665" data-bind="attr:{src: slideShow()[0].image}" />
            <!-- /ko -->
            <!-- ko if: slideShow().length > 1 -->
            <ul id="slide" data-bind="foreach: slideShow">
                <li>
                    <a href="#">
                        <img data-bind="attr:{src: image}" />
                        <div class="caption kh" data-bind="text: Title"></div>
                        <div class="desc kh" data-bind="text: Description"></div>
                    </a>
                </li>
            </ul>
            <!-- /ko -->
            <?php endif; ?>
        </div> <!--end col-sm-6-->
    </div> <!--End row-->
    <div class="row">
		<div class="pull-left col col-sm-12" style="margin-bottom:20px">
			<div id="exportOverview2" >
				<table style="margin-top:30px" class="table color-bordered-table info-bordered-table table-striped box-shadow border-color rounded-corners">
					<thead>
						<tr style="height:26px">
							<th class="tbl-title" colspan="10">
								<span>Case Investigation</span>
								<span data-bind="text: lastSearch().from + ' - ' + lastSearch().to"></span>
								<span data-bind="text: '(' + (prov() == null ? 'Endemic Area' : getPvName(prov())) + ')'"></span>
							</th>
						</tr>
                        <tr>
							<th style="border-right: 2px solid #e9ecef">Species</th>
							<th style="border-right: 2px solid #e9ecef">Malaria Patient (Persons)</th>
							<th style="border-right: 2px solid #e9ecef">Cases</th>
							<th style="border-right: 2px solid #e9ecef">Investigated</th>
							<th style="border-right: 2px solid #e9ecef">Relapse/Recrudecent</th>
							<th style="border-right: 2px solid #e9ecef">Locally Aquired</th>
							<th style="border-right: 2px solid #e9ecef">Domestically Imported</th>
							<th style="border-right: 2px solid #e9ecef">Internationally Imported</th>
							<th>Induced</th>
                        </tr>
					</thead>
                    <tbody data-bind="foreach: caseInvestigate">
                        <tr>
							<td data-bind="text: Diagnosis"></td>
							<td align="right" data-bind="text: $root.lastSearch().year > 2022 ? Patient : 'N/A'"></td>
							<td align="right" data-bind="text: Cases"></td>
							<td align="right" data-bind="text: Classify"></td>
							<td align="right" data-bind="text: Relapse"></td>
							<td align="right" data-bind="text: L1"></td>
							<td align="right" data-bind="text: LC"></td>
							<td align="right" data-bind="text: IMP"></td>
							<td align="right" data-bind="text: $root.lastSearch().year >= 2024 ? Induce : 'N/A'"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
							<th align="right" data-bind="text: $root.lastSearch().year > 2022 ? caseInvestigate()?.sum('Patient') : 'N/A'"></th>
							<th align="right" data-bind="text: caseInvestigate()?.sum('Cases')"></th>
							<th align="right" data-bind="text: caseInvestigate()?.sum('Classify')"></th>
							<th align="right" data-bind="text: caseInvestigate()?.sum('Relapse')"></th>
							<th align="right" data-bind="text: caseInvestigate()?.sum('L1')"></th>
							<th align="right" data-bind="text: caseInvestigate()?.sum('LC')"></th>
							<th align="right" data-bind="text: caseInvestigate()?.sum('IMP')"></th>
							<th align="right" data-bind="text: $root.lastSearch().year >= 2024 ? caseInvestigate()?.sum('Induce') : 'N/A'"></th>
                        </tr>
                    </tfoot>
				</table>

                <div data-bind="visible: prov() >= 0">
                    <table style="margin-bottom:0" id="tbl-surveillance" class="table color-bordered-table info-bordered-table table-striped box-shadow border-color rounded-corners">
                        <thead>
                            <tr style="height:26px">
                                <th class="tbl-title" colspan="16">
                                    <span data-bind="text: lastSearch().prov == null ? 'National' : provList().find(r => r.code == lastSearch().prov).name"></span>
                                    <span> Surveillance data for the period </span>
                                    <span data-bind="text: lastSearch().from + ' - ' + lastSearch().to"></span>
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="2" style="border-right: 2px solid #e9ecef;vertical-align:middle">Indicators</th>
                                <th colspan="3" style="border-right: 2px solid #e9ecef">HF</th>
                                <th colspan="3" style="border-right: 2px solid #e9ecef">VMW</th>
                                <th colspan="3" style="border-right: 2px solid #e9ecef">Total</th>
                                <th colspan="3" style="border-right: 2px solid #e9ecef">Male Total</th>
                                <th colspan="3">Female Total</th>
                            </tr>
                            <tr>
                                <!-- ko foreach: Array(5) -->
                                <th class="bg-info" data-bind="text: $root.lastSearch().year - 1" style="border:none"></th>
                                <th class="bg-primary" data-bind="text: $root.lastSearch().year" style="border:none"></th>
                                <!-- ko if: ($index() == 4) -->
                                <th class="bg-purple" style="border-top: none">Change</th>
                                <!-- /ko -->
                                <!-- ko if: ($index() != 4) -->
                                <th class="bg-purple" style="border-top: none; border-right: 2px solid #e9ecef">Change</th>
                                <!-- /ko -->
                                <!-- /ko -->
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: caseList">
                            <tr data-bind="foreach: Object.keys($data), style: { background: $index() == 1 ? 'antiquewhite' : '' } ">
                                <!-- ko if: $data == 'Indicators' -->
                                <td data-bind="html: $parent[$data]"></td>
                                <!-- /ko -->
                                <!-- ko if: $data != 'Indicators' -->
                                <td align="right">
                                    <span data-bind="text: $root.fixValue($parent[$data], $data, $parent.Indicators), css: $root.highlight($parent[$data], $data, $parent.Indicators)"></span>
                                </td>
                                <!-- /ko -->
                            </tr>
                        </tbody>
                    </table>
                    <span>
                        <sup>1</sup>Cases per 1000 pop (2017 is under estimated) &emsp;&emsp;&emsp;
                        <sup>2</sup>Deaths per 100,000 pop &emsp;&emsp;&emsp;
                        <sup>3</sup>Included imported cases <span data-bind="text: caseInvestigate()[0]?.IMP"></span>
                    </span>
                </div>

                <div data-bind="visible: prov() == null">
                    <table style="margin-top:30px; margin-bottom:0" id="tbl-surveillance" class="table color-bordered-table info-bordered-table table-striped box-shadow border-color rounded-corners">
                        <thead>
                            <tr style="height:26px">
                                <th class="tbl-title" colspan="16">
                                    <span>National Surveillance data for the period </span>
                                    <span data-bind="text: lastSearch().from + ' - ' + lastSearch().to"></span>
                                    <span> (Whole Country)</span>
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="2" style="border-right: 2px solid #e9ecef;vertical-align:middle">Indicators</th>
                                <th colspan="3" style="border-right: 2px solid #e9ecef">HF</th>
                                <th colspan="3" style="border-right: 2px solid #e9ecef">VMW</th>
                                <th colspan="3" style="border-right: 2px solid #e9ecef">Total</th>
                                <th colspan="3" style="border-right: 2px solid #e9ecef">Male Total</th>
                                <th colspan="3">Female Total</th>
                            </tr>
                            <tr>
                                <!-- ko foreach: Array(5) -->
                                <th class="bg-info" data-bind="text: $root.lastSearch().year - 1" style="border:none"></th>
                                <th class="bg-primary" data-bind="text: $root.lastSearch().year" style="border:none"></th>
                                <!-- ko if: ($index() == 4) -->
                                <th class="bg-purple" style="border-top: none">Change</th>
                                <!-- /ko -->
                                <!-- ko if: ($index() != 4) -->
                                <th class="bg-purple" style="border-top: none; border-right: 2px solid #e9ecef">Change</th>
                                <!-- /ko -->
                                <!-- /ko -->
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: caseCountryList">
                            <tr data-bind="foreach: Object.keys($data), style: { background: $index() == 1 ? 'antiquewhite' : '' }">
                                <!-- ko if: $data == 'Indicators' -->
                                <td data-bind="html: $parent[$data]"></td>
                                <!-- /ko -->
                                <!-- ko if: $data != 'Indicators' -->
                                <td align="right">
                                    <span data-bind="text: $root.fixValue($parent[$data], $data, $parent.Indicators), css: $root.highlight($parent[$data], $data, $parent.Indicators)"></span>
                                </td>
                                <!-- /ko -->
                            </tr>
                        </tbody>
                    </table>
                    <span>All cases in none-endemic area are imported case.</span> &emsp;&emsp;&emsp;
                    <sup>3</sup>Included imported cases <span data-bind="text: caseInvestigate()[0]?.IMP"></span>
                </div>
			</div>
		</div>
	</div> <!--End row-->

    <div class="row">
        <div class="col-sm-4">
            <div class="chart-container2">
                <div id="notify" class="chartbox"></div>
            </div>

            <div class="chart-container2">
                <div id="reactiveCaseDetection" class="chartbox"></div>
            </div>

            <div class="chart-container2">
                <div id="foci" class="chartbox"></div>
            </div>
            
        </div>
        <div class="col-sm-4">
            <table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow border-color rounded-corners">
                <thead>
                    <tr class="tbl-title" style="height:26px; font-size:11px !important">
                        <th colspan="2">
                            Malaria Risk Stratification
                            <span data-bind="text: year"></span>
                        </th>
                    </tr>
                    <tr>
                        <th class="bg-purple">Category</th>
                        <th class="bg-info">Population</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: riskPop">
                    <tr>
                        <td>High Risk</td>
                        <td align="center" data-bind="text: High == null ? 'N/A' : comma(is(High, 0, ''))"></td>
                    </tr>
                    <tr>
                        <td>Medium Risk</td>
                        <td align="center" data-bind="text: Medium == null ? 'N/A' :  comma(is(Medium, 0, ''))"></td>
                    </tr>
                    <tr>
                        <td>Low Risk</td>
                        <td align="center" data-bind="text: Low == null ? 'N/A' :  comma(is(Low, 0, ''))"></td>
                    </tr>
                    <tr>
                        <td>No Risk</td>
                        <td align="center" data-bind="text: No == null ? 'N/A' :  comma(is(No, 0, ''))"></td>
                    </tr>
                </tbody>
            </table>
            <br />
            <table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow border-color rounded-corners">
                <thead>
                    <tr class="tbl-title" style="height:26px; font-size:11px !important">
                        <th>Insecticide Treated Net (ITN) <span data-bind="text: duration"></span></th>
                        <th class="bg-info">Static</th>
                        <th class="bg-primary">Mobile</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: netList">
                    <tr>
                        <td data-bind="text: Name"></td>
                        <td align="right" data-bind="text: comma(is(Static, 0, '')) + ($index() == 5 ? '%' : '')"></td>
                        <td align="right" data-bind="text: comma(is(Mobile, 0, ''))"></td>
                    </tr>
                </tbody>
            </table>
            <div>Included bednet at other ministries</div>

            <table class="table color-bordered-table info-bordered-table table-striped box-shadow border-color rounded-corners">
                <thead>
                    <tr>
                        <th class="tbl-title" colspan="4">Foci</th>
                    </tr>
                    <tr>
                        <th>Year</th>
                        <th class="bg-primary">Active Focus</th>
                        <th class="bg-info">Residual Focus</th>
                        <th class="bg-purple">Cleared-up Focus</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: foci">
                    <tr style="text-align:center">
                        <td data-bind="text: Year"></td>
                        <td data-bind="text: Active"></td>
                        <td data-bind="text: Residual"></td>
                        <td data-bind="text: Cleared"></td>
                    </tr>
                </tbody>
            </table>

            <div class="chart-container2">
                <div id="radicalCure" class="chartbox"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <table class="table color-bordered-table info-bordered-table table-striped box-shadow border-color rounded-corners">
                <thead>
                    <tr>
                        <th class="tbl-title" colspan="2">Last mile (2022 - 2023)</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: lastmileList">
                    <tr>
                        <td data-bind="text: Criteria"></td>
                        <td data-bind="text: $root.lastmileFormat(Criteria, Value)"></td>
                    </tr>
                </tbody>
            </table>

            <div class="chart-container2">
                <div id="lastmileChart" class="chartbox"></div>
                <div class="btn">
					<label class="checkbox-inline checkbox-sm">
						<input class="lastmCbox" id="tda-eli" type="checkbox" checked />
						<span>TDA Eligible</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input class="lastmCbox" id="tda" type="checkbox" checked />
						<span>TDA</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input class="lastmCbox" id="ipt-eli" type="checkbox" checked />
						<span>IPT Eligible</span>
					</label>
                    <label class="checkbox-inline checkbox-sm">
						<input class="lastmCbox" id="ipt" type="checkbox" checked />
						<span>IPT</span>
					</label>
				</div>
            </div>

        </div>
    </div>

	<div class="row hidden" style="margin:0 auto; width: 35%; margin-top: 15px">
		<table  class="table color-bordered-table info-bordered-table table-striped box-shadow">
			<thead>
				<tr style="height:26px">
					<th colspan="10">
						<span>None Endemic OD Surveillance data for the period </span>
						<span data-bind="text: lastSearch().from + ' - ' + lastSearch().to"></span>
					</th>
				</tr>
				<tr>
					<th style="border-right: 2px solid #e9ecef" rowspan="2">Indicators</th>
					<th colspan="3">HF</th>
				</tr>
				<tr data-bind="foreach: Array(1)">
					<th class="bg-info" data-bind="text: $root.lastSearch().year - 1" style="border:none"></th>
					<th class="bg-primary" data-bind="text: $root.lastSearch().year" style="border:none"></th>
					<th class="bg-purple" style="border-top:none; border-left:none">Change</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: caseNList">
				<tr data-bind="foreach: Object.keys($data)">
					<!-- ko if: $data == 'Indicators' -->
					<td data-bind="html: $parent[$data]"></td>
					<!-- /ko -->
					<!-- ko if: $data != 'Indicators' -->
					<td align="right" data-bind="style: { borderRight: $parents[1].removeCellBorder($data) }">
						<span data-bind="text: $root.fixValue($parent[$data], $data, $parent.Indicators), css: $root.highlight($parent[$data], $data, $parent.Indicators)"></span>
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div> <!--/None Endemic OD-->
    
	<section>
        <br>
        <div class="card" style="background-color: #3498db;">
            <div class="card-body collapse show">
                <h4 class="card-title" style="margin: 0; text-align: center">
                    TRENDS IN SURVEILLANCE
                </h4>
            </div>
        </div>

        <br />

		<div>
			<h3>Surveillance chart</h3>

			<div class="row">
				<div class="col-md-6 padding-r">
                    <div class="chart-container">
                        <div id="chartTop30Vill" class="chartbox"></div>
                        <div class="btn">
                            <label class="checkbox-inline checkbox-sm">
                                <input id="chartTop30VillPf" type="checkbox" data-bind="click: drawChartTop30Vill" checked />
                                <span>PF</span>
                            </label>
                            <label class="checkbox-inline checkbox-sm">
                                <input id="chartTop30VillPv" type="checkbox" data-bind="click: drawChartTop30Vill" checked />
                                <span>PV</span>
                            </label>
                            <label class="checkbox-inline checkbox-sm">
                                <input id="chartTop30VillMix" type="checkbox" data-bind="click: drawChartTop30Vill" checked />
                                <span>Mix</span>
                            </label>
                        </div>
                    </div>
				</div>
				<div class="col-md-6 padding-l">
					<div class="chart-container">		
						<div id="chartTop30HFbySpecies" class="chartbox"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input id="chartTop30HFbySpeciesPf" type="checkbox" data-bind="click: drawChartTop30HFbySpecies" checked />
								<span>PF</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input id="chartTop30HFbySpeciesPv" type="checkbox" data-bind="click: drawChartTop30HFbySpecies" checked />
								<span>PV</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input id="chartTop30HFbySpeciesMix" type="checkbox" data-bind="click: drawChartTop30HFbySpecies" checked />
								<span>Mix</span>
							</label>
						</div>
					</div><!--/chartTop30HFbySpecies-->
				</div>
			</div>

			<h3> Trend of Malaria</h3>

			<div class="row">
				<div class="col-md-6 padding-r">
					<div class="chart-container">
						<div id="treated" class="chartbox"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input class="lgCbox" id="HF" type="checkbox" checked />
								<span>HF</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="lgCbox" id="VMW" type="checkbox" checked />
								<span>VMW</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="lgCbox" id="All" type="checkbox" checked />
								<span>All</span>
							</label>
						</div>
					</div>
				</div>

				<div class="col-md-6 padding-l">
					<div class="chart-container">
						<div id="severe" class="chartbox"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input class="servereCbox" id="Severe" type="checkbox" checked />
								<span>Severe</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="servereCbox" id="Deaths" type="checkbox" checked />
								<span>Deaths</span>
							</label>
						</div>
					</div>
				</div>
			</div><!--/row-->

            <br />

			<div class="chart-container">
				<div id="test" class="chartbox "></div>
				<div class="btn">
					<label class="checkbox-inline checkbox-sm">
						<input class="testCbox" id="PV" type="checkbox" checked />
						<span>PV</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input class="testCbox" id="PF + Mix" type="checkbox" checked />
						<span>PF + Mix</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input class="testCbox" id="TPR" type="checkbox" checked />
						<span>TPR</span>
					</label>
				</div>
			</div>
            <br />
			<div class="row">
				<div class="col-md-6 padding-r">
					<div class="chart-container">
						<div id="chartCaseDeath" class="chartbox"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input class="cdCbox" id="Cases" type="checkbox" checked />
								<span>Cases</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="cdCbox" id="Deaths" type="checkbox" checked />
								<span>Deaths</span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-6 padding-l">
					<div class="chart-container">
						<div id="chartSpecie" class="chartbox"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input class="specieCbox" id="Pf" type="checkbox" checked />
								<span>Pf</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="specieCbox" id="Pv" type="checkbox" checked />
								<span>Pv</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="specieCbox" id="Mix" type="checkbox" checked />
								<span>Mix</span>
							</label>
						</div>
					</div>
				</div>
			</div>

            <br />

			<div class="chart-container">
				<div id="chartSexAge" class="chartbox stack"></div>
				<div class="btn">
					<label class="checkbox-inline checkbox-sm">
						<input class="sexCbox" id="Male" type="checkbox" checked />
						<span>Male</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input class="sexCbox" id="Female" type="checkbox" checked />
						<span>Female</span>
					</label>
				</div>
			</div>

            <br />

			<div class="chart-container">
				<div id="chartSpecieProvince" class="chartbox stack"></div>
				<div class="btn">
					<label class="checkbox-inline checkbox-sm">
						<input class="spCbox" id="Pv" type="checkbox" checked />
						<span>Pv</span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input class="spCbox" id="Pf+Mix" type="checkbox" checked />
						<span>Pf+Mix</span>
					</label>
				</div>
			</div>

            <br />

			<div class="chart-container">
				<div id="chartIncidentMortality" class="chartbox"></div>
				<div class="btn">
					<label class="checkbox-inline checkbox-sm">
						<input class="imCbox" id="inc-0" type="checkbox" checked />
						<span id="im-lg-0"></span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input class="imCbox" id="inc-1" type="checkbox" checked />
						<span id="im-lg-1"></span>
					</label>
					<label class="checkbox-inline checkbox-sm">
						<input class="imCbox" id="mr" type="checkbox" checked />
						<span id="im-lg-2"></span>
					</label>
				</div>
			</div>
		</div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCase" tabindex="-1" role="dialog" aria-labelledby="modalDailyCaseTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width:950px">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDailyCaseTitle" data-bind="text: $root.title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="container-fluid">
             <div class="row">
                 <div class="col-sm-12">
                     <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr style="background:cornflowerblue">
                                <th>#</th>
                                <th>Province</th>
                                <th>OD</th>
                                <th>HF</th>
                                <th>Village</th>
                                <th>Diagnosis</th>
                                <th>Clasify</th>
                                <th>Sex</th>
                                <th>Age</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: cases">
                            <tr>
                                <td data-bind="text: $index() +1" align="center"></td>
                                <td data-bind="text: Name_Prov_E"></td>
                                <td data-bind="text: Name_OD_E"></td>
                                <td data-bind="text: Name_Facility_E"></td>
                                <td data-bind="text: Village"></td>
                                <td data-bind="text: $root.getSpecie(Diagnosis)"></td>
                                <td data-bind="text: Clasify"></td>
                                <td data-bind="text: Sex"></td>
                                <td data-bind="text: Age"></td>
                            </tr>
                        </tbody>
                        <tfoot data-bind="visible: app.tableFooter($element)">
				            <tr>
					            <td class="text-center text-warning h4" style="padding:10px">No Data</td>
				            </tr>
			            </tfoot>
                     </table>
                 </div>
             </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
