<style>
	th, td { vertical-align:middle !important; }
	.orange { background-color:orangered; color:white; }
	.orange-light { background-color:orange; color:white; }
	.gray { background-color:gray; color:white; }
	.gray-light { background-color:lightgray; }
	.sky { color:dodgerblue; }
	.green { color:green; }
	.objective {
		color: white;
		font-size: 24px;
		margin: -5px 5px -5px -6px;
		padding: 8px 18px 8px 12px;
		border-top-right-radius: 50%;
		border-bottom-right-radius: 50%;
		float: left;
	}
	.objective.blue { background-color:#2f4b9d; }
	.objective.sky { background-color:dodgerblue; }
	.objective.green { background-color:darkgreen; }
	.objective-text { width:calc(100% - 50px); height:40px; display:table; }
	.objective-text > div { display:table-cell; vertical-align:middle; }
	hr { margin-top:5px; margin-bottom:5px; border-top: 1px solid #ddd; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh34 font16">
			<b>Cambodia Malaria Elimination Action Framework Indicator 2021 - 2025</b>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-hover">
			<thead>
				<tr class="orange">
					<th rowspan="2" align="center" style="min-width:400px">Impact Indicators</th>
					<th width="170" rowspan="2" align="center">Disaggregated By</th>
					<th width="120" rowspan="2" align="center">Baseline (2019)</th>
					<th rowspan="2"></th>
					<th colspan="5" align="center">Timeline</th>
					<th width="100" rowspan="2" align="center">Data Source</th>
					<th rowspan="2" align="center">Frequency</th>
				</tr>
				<tr class="orange-light">
					<th width="120" align="center">2021</th>
					<th width="120" align="center">2022</th>
					<th width="120" align="center">2023</th>
					<th width="120" align="center">2024</th>
					<th width="120" align="center">2025</th>
				</tr>
			</thead>
			<tbody data-bind="fixedHeader: true">
				<tr>
					<th colspan="11" class="gray">GOAL: By 2025, eliminate all forms of malaria, maintain zero mortality, and prevent reintroduction of malaria and multi-drug resistance</th>
				</tr>
				<tr id="Tpr">
					<th>Test positivity rate: Percentage of positive malaria tests for all species</th>
					<td align="center">HF, VMW/MMW, PHD, OD</td>
					<td align="center">5.32</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">1.45</td>
					<td align="center">0.76</td>
					<td align="center">0.41</td>
					<td align="center">0.21</td>
					<td align="center">0</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="Api">
					<th>Annual Parasite Incidence: Number of local malaria cases for all species per 1,000 population</th>
					<td align="center">PHD, OD</td>
					<td align="center">1.92</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">0.59</td>
					<td align="center">0.35</td>
					<td align="center">0.21</td>
					<td align="center">0.08</td>
					<td align="center">0</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="ApiPfMix">
					<th>Annual Plasmodium falciparum Incidence: Number of local Plasmodium falciparum and miexed malaria cases per 1,000 populaiton</th>
					<td align="center">PHD, OD</td>
					<td align="center">0.31</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">0.06</td>
					<td align="center">0.01</td>
					<td align="center">0</td>
					<td align="center">0</td>
					<td align="center">0</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="Severe">
					<th>In-patient severe malaria rate per 10,000 population</th>
					<td align="center">Sex, PHD, OD</td>
					<td align="center">0.2</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">0.06</td>
					<td align="center">0.04</td>
					<td align="center">0.02</td>
					<td align="center">0.01</td>
					<td align="center">0</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="Death">
					<th>In-patient mortality rate per 100,000 population</th>
					<td align="center">Sex, Age, PHD, OD</td>
					<td align="center">0</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">0</td>
					<td align="center">0</td>
					<td align="center">0</td>
					<td align="center">0</td>
					<td align="center">0</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="OdApi">
					<th>Number of Operational Districts (ODs) that have malaria API less than 1 per 1,000 population for all species</th>
					<td align="center">PHD, OD</td>
					<td align="center">75% (77/102)</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">83% (85/102)</td>
					<td align="center">87% (89/102)</td>
					<td align="center">91% (93/102)</td>
					<td align="center">95% (97/102)</td>
					<td align="center">100% (102/102)</td>
					<td align="center">MIS</td>
					<td align="center">Annually</td>
				</tr>
				<tr id="OdApiPfMix">
					<th>Number of Operational Districts (ODs) that have malaria API less than 1 per 1,000 population for P.falciparum and mixed</th>
					<td align="center">PHD, OD</td>
					<td align="center">90% (92/102)</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">94% (96/102)</td>
					<td align="center">96% (98/102)</td>
					<td align="center">98% (100/102)</td>
					<td align="center">100% (102/102)</td>
					<td align="center">100% (102/102)</td>
					<td align="center">MIS</td>
					<td align="center">Annually</td>
				</tr>
				<tr id="L1L3">
					<th>Percentage of cases that are classified as indigenous (L1-L3)</th>
					<td align="center">Species, Province/OD</td>
					<td align="center">53.44%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">40%</td>
					<td align="center">35%</td>
					<td align="center">30%</td>
					<td align="center">15%</td>
					<td align="center">0%</td>
					<td align="center">MIS</td>
					<td align="center">Annually</td>
				</tr>
				<tr id="Foci">
					<th>Number of active foci (village with L1 case)</th>
					<td align="center">Species, Province/OD</td>
					<td align="center">Not available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">71</td>
					<td align="center">14</td>
					<td align="center">3</td>
					<td align="center">0</td>
					<td align="center">0</td>
					<td align="center">MIS</td>
					<td align="center">Annually</td>
				</tr>
				<tr>
					<th colspan="11" class="gray-light">
						<span class="objective blue">1</span>
						<div class="objective-text">
							<div>
								<span class="sky">Objective 1</span> Early detect, effectively and safely treat 100% of cases, and provide effective personal protection to at least 90% of the high risk population
							</div>
						</div>
					</th>
				</tr>
				<tr>
					<th>Percentage of at-risk villages covered by a VMW</th>
					<td align="center">PHD, OD</td>
					<td align="center">99%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">MIS</td>
					<td align="center">Quarterly</td>
				</tr>
				<tr id="AberEndemic">
					<th>Annual blood Examination Rate: Number of parasitological tests carried out per 100 endemic population</th>
					<td align="center">Microscopy/RDT, HF, VMW/MMW, PHD, OD, PCD/ACD</td>
					<td align="center">6</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">7</td>
					<td align="center">8</td>
					<td align="center">9</td>
					<td align="center">10</td>
					<td align="center">10</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="Aber">
					<th>Annual blood Examination Rate: Number of parasitological tests carried out per 100 population</th>
					<td align="center">Microscopy/RDT, HF, VMW/MMW, PHD, OD, PCD/ACD</td>
					<td align="center">3.2</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">4</td>
					<td align="center">4</td>
					<td align="center">4</td>
					<td align="center">4</td>
					<td align="center">4</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="PfMixTreat">
					<th>Percentage of total Plasmodium falciparum and mix cases that received treatment according to NTG</th>
					<td align="center">ACT/PQSD, HF, VMW/MMW, PHD, OD</td>
					<td align="center">95% (only P.f)</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">>95%</td>
					<td align="center">>95%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>100%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="PvTreat">
					<th>Percentage of total Plasmodium vivax cases that received treatment according to NTG</th>
					<td align="center">G6PD status, ACT/PQSD, HF, VMW/MMW, PHD, OD</td>
					<td align="center">Not available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">60%</td>
					<td align="center">75%</td>
					<td align="center">85%</td>
					<td align="center">>95%</td>
					<td align="center">100%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr>
					<th>Percentage of care providers with adequate case management practices observed during supervision to VMW/MMW (high QA checklist score >80%)</th>
					<td align="center">VMW/MMW</td>
					<td align="center">Not Available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">75%</td>
					<td align="center">85%</td>
					<td align="center">90%</td>
					<td align="center">>95%</td>
					<td align="center">>95%</td>
					<td align="center">MIS</td>
					<td align="center">Quarterly</td>
				</tr>
				<tr>
					<th>Percentage of points of care with a closing balance of sufficient stock (defined as between 0.5 to 3 AMC) of diagnostic supplies with viable stock</th>
					<td align="center">Microscopy/RDT, HF, VMW/MMW, PHD, OD</td>
					<td align="center">Not Available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">>95%</td>
					<td align="center">>95%</td>
					<td align="center">99%</td>
					<td align="center">99%</td>
					<td align="center">99%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr>
					<th>Percentage of points of care with a closing balance of sufficient stock (defined as between 0.5 to 3 AMC) of first-line antimalarials (ACT/PQ)</th>
					<td align="center">ACT/PQ, HF, VMW/MMW, PHD, OD</td>
					<td align="center">Not Available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">>95%</td>
					<td align="center">>95%</td>
					<td align="center">99%</td>
					<td align="center">99%</td>
					<td align="center">99%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr>
					<th>Percentage of TES/iDES completed according to targets</th>
					<td align="center">Site</td>
					<td align="center">100%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">100%</td>
					<td align="center">100%</td>
					<td align="center">100%</td>
					<td align="center">100%</td>
					<td align="center">100%</td>
					<td align="center">TES/iDES</td>
					<td align="center">Monthly</td>
				</tr>
				<tr>
					<th>Percentage of microscopist that receiving valid NCA accreditation (grade A&B)</th>
					<td align="center">NRH/PRH/DRH, PHD</td>
					<td align="center">36% (2018)</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">NA</td>
					<td align="center">70%</td>
					<td align="center">NA</td>
					<td align="center">90%</td>
					<td align="center">NA</td>
					<td align="center">CNM Lab unit</td>
					<td align="center">Every 2 years</td>
				</tr>
				<tr>
					<th>Percentage of population in targeted hotspots who slept under an insecticide-treated net (ITN) during the previous night after LLIN Mass Campaign</th>
					<td align="center">Sex</td>
					<td align="center">86%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">>90%</td>
					<td align="center">NA</td>
					<td align="center">NA</td>
					<td align="center">>90%</td>
					<td align="center">NA</td>
					<td align="center">Quick LLIN assessment</td>
					<td align="center">Every 3 years</td>
				</tr>
				<tr>
					<th>Percentage of households in targeted hotspots with at least one insecticide-treated net for every two people after LLIN Mass Campaign</th>
					<td align="center">ITN, LLIN</td>
					<td align="center">94%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">80%</td>
					<td align="center">NA</td>
					<td align="center">NA</td>
					<td align="center">>90%</td>
					<td align="center">NA</td>
					<td align="center">Quick LLIN assessment</td>
					<td align="center">Every 3 years</td>
				</tr>
				<tr>
					<th>Percentage of community mobilization session conducted in targeted villages with VMW</th>
					<td align="center">village</td>
					<td align="center">70%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">80%</td>
					<td align="center">90%</td>
					<td align="center">95%</td>
					<td align="center">95%</td>
					<td align="center">95%</td>
					<td align="center">MIS</td>
					<td align="center">Quarterly</td>
				</tr>
				<tr>
					<th colspan="11" class="gray-light">
						<div class="objective sky">2</div>
						<div class="objective-text">
							<div>
								<span class="sky">Objective 2</span> Intensify focal interventions to interrupt transmission in endemic with highest risk (including mobile migrant population/forest goers) to eliminate Plasmodium falciparum by 2023 and all species by 2025
							</div>
						</div>
					</th>
				</tr>
				<tr>
					<th>Percentage of target hotspots (defined as high risk by CNM stratification) covered by MMW</th>
					<td align="center">PHD, OD</td>
					<td align="center">Not available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">95%</td>
					<td align="center">95%</td>
					<td align="center">99%</td>
					<td align="center">99%</td>
					<td align="center">100%</td>
					<td align="center">MIS</td>
					<td align="center">Quarterly</td>
				</tr>
				<tr>
					<th>Percentage of community network (MMW/VMW) reaching the targets during active case detection</th>
					<td align="center">PHD, OD</td>
					<td align="center">70%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">>85%</td>
					<td align="center">>90%</td>
					<td align="center">>95%</td>
					<td align="center">>95%</td>
					<td align="center">>95%</td>
					<td align="center">MIS/IP Scorecard</td>
					<td align="center">Monthly</td>
				</tr>
				<tr>
					<th>Percentage of forest goers in hotspots who reported sleeping under an ITN the last time they slept in the forest</th>
					<td align="center">PHD, OD, Sex</td>
					<td align="center">Not available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">50%</td>
					<td align="center">75%</td>
					<td align="center">85%</td>
					<td align="center">90%</td>
					<td align="center">90%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr>
					<th colspan="11" class="gray-light">
						<span class="objective green">3</span>
						<div class="objective-text">
							<div>
								<span class="green">Objective 3</span> Investigate, clear, document and follow-up 100% fo cases and foci to interrupt transmission and prevent re-establishment
							</div>
						</div>
					</th>
				</tr>
				<tr id="HFCompleteness">
					<th>Percentage of expected monthly MIS case management reports submitted from public HFs (provincial hospitals, referral hospitals, health cneters) with completeness</th>
					<td align="center">PHD, OD</td>
					<td align="center">99%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="StockCompleteness">
					<th>Percentage of expected monthly MIS stock reports submitted from public HFs (provincial hospitals, referral hospitals, health cneters) with completeness</th>
					<td align="center">PHD, OD</td>
					<td align="center">98%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="VMWCompleteness">
					<th>Percentage of expected monthly MIS case management reports submitted from VMW/MMWs, with completeness</th>
					<td align="center">PHD, OD</td>
					<td align="center">98%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">>99%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="Classified">
					<th>Percentage of malaria cases notified, investigated and classified with 24h according to surveillance manual</th>
					<td align="center">PHD, OD</td>
					<td align="center">25%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">80%</td>
					<td align="center">80%</td>
					<td align="center">90%</td>
					<td align="center">95%</td>
					<td align="center">100%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="Investigated">
					<th>Percentage of cases investigated who were diagnosed with 24 hours after onset of symptoms</th>
					<td align="center">PHD, OD</td>
					<td align="center">12%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">80%</td>
					<td align="center">80%</td>
					<td align="center">90%</td>
					<td align="center">95%</td>
					<td align="center">100%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="Responded">
					<th>Percentage of malaria cases responded with 7 days according to surveillance manual</th>
					<td align="center">PHD, OD</td>
					<td align="center">60%</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">70%</td>
					<td align="center">80%</td>
					<td align="center">90%</td>
					<td align="center">95%</td>
					<td align="center">100%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="NewFoci">
					<th>Percentage of new active foci classified and investigated according to surveillance manual</th>
					<td align="center">PHD, OD</td>
					<td align="center">Not available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">80%</td>
					<td align="center">80%</td>
					<td align="center">90%</td>
					<td align="center">95%</td>
					<td align="center">100%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
				<tr id="FociResponse">
					<th>Percentage of investigatd foci in which response was initiated according to surveillance manual</th>
					<td align="center">PHD, OD</td>
					<td align="center">Not available</td>
					<td align="center">Target<hr>Result</td>
					<td align="center">80%</td>
					<td align="center">80%</td>
					<td align="center">90%</td>
					<td align="center">95%</td>
					<td align="center">100%</td>
					<td align="center">MIS</td>
					<td align="center">Monthly</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/MeafIndicator.js')?>