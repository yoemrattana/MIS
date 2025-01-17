<style>
	#tablelist thead { background-color: #9AD8ED; }
	.panel_orange { background: #ED7D31; padding:0 10px; }
	.text_blue { color: #002060; }
	textarea { resize: vertical; }
	.green_box1 { height: 200px; width: 30px; border-left: 100px solid #92D050; border-top: 100px solid white; border-bottom: 100px solid white; }
	.green_box2 { height: 200px; width: 855px; background: #92D050; border-right: none; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline relative">
			<b class="font16 lh26" data-bind="visible: view() == 'detail'">Bulletin</b>
			
			<!-- ko if: view() == 'list' -->
			<b>Province</b>
			<select class="form-control width150" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length > 1 ? 'All Province' : undefined"></select>

			<b style="margin-left:20px">Month</b>
			<input type="text" class="form-control width100 text-center" data-bind="datePicker: month, format: 'MMM YYYY', showClear: true" placeholder="All Month" />
			<!-- /ko -->
		</div>
		<div class="pull-right" data-bind="visible: view() == 'list'">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: app.user.permiss['Bulletin'].contain('Create')">New</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'detail'">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: isNew">Save</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: back">Back</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table id="tablelist" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th align="center">Province</th>
					<th align="center">Year</th>
					<th align="center">Month</th>
					<th align="center">Publish Date</th>
					<th align="center">Volume</th>
					<th align="center">Created By</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60" data-bind="visible: app.user.permiss['Bulletin'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedheader: true">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td align="center" data-bind="text: $root.getProvName(Code_Prov_T)"></td>
					<td align="center" data-bind="text: Year"></td>
					<td align="center" data-bind="text: Month"></td>
					<td align="center" data-bind="text: moment(PublishDate).format('ll')"></td>
					<td align="center" data-bind="text: Volume"></td>
					<td align="center" data-bind="text: InitUser"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Bulletin'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.delete">Delete</a>
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

	<div class="panel-body" data-bind="visible: view() == 'detail', with: editModel">
		<div style="width:1000px; background:white; border:2px solid darkblue">
			<div class="text_blue">
				<div class="panel_orange">
					<div class="row">
						<div class="col-xs-4">
							<h3 data-bind="text: 'Report for ' + PublishDate.format('MMMM-YYYY')"></h3>
						</div>
						<div class="col-xs-4 text-center">
							<h1 class="text-bold">BULLETIN</h1>
						</div>
						<div class="col-xs-4 text-right">
							<h4>
								<span>Publish on</span>
								<br />
								<span data-bind="text: PublishDate.format('DD MMMM YYYY')"></span>
								<br />
								<span data-bind="text: 'Volume ' + Volume"></span>
							</h4>
						</div>
					</div>
					<div class="text-center">
						<img src="/media/images/cso_logo.png" height="70" />
					</div>
				</div>
				<div>
					<div class="row">
						<div class="col-xs-4 text-center">
							<img src="/media/images/mosquitomap.png" />
						</div>
						<div class="col-xs-4 text-center">
							<h3 data-bind="text: $root.getProvName(Code_Prov_T)"></h3>
							<h4>PROVINCE</h4>
						</div>
						<div class="col-xs-4" style="padding-top:8px">
							<div style="background:#92D050; padding:0 5px">
								<b>CONTENT</b>
							</div>
							<div style="padding:5px 10px; background:#D1E5C4">
								<div>I. Background</div>
								<div>II. Caseloads</div>
								<div data-bind="text: 'III. Activity/Result - ' + PublishDate.format('MMMM')"></div>
								<div data-bind="text: 'IV. Challenges - ' + PublishDate.format('MMMM')"></div>
								<div data-bind="text: 'V. Way Forwards - ' + PublishDate.format('MMMM')"></div>
							</div>
						</div>
					</div>
				</div>
				<div style="background:#92D050; padding:3px">
					<b>I. BACKGROUND</b>
				</div>
				<div class="row" style="padding:0 3px">
					<div class="col-xs-4">
						<div class="text-bold">Demo-Geographic</div>
						<div>NA</div>
					</div>
					<div class="col-xs-4">
						<div class="text-bold">Malaria Stakeholders</div>
						<div>NA</div>
					</div>
					<div class="col-xs-4">
						<div class="text-bold">Health infrastructure & HR</div>
						<div data-bind="with: Infrastructure">
							<div data-bind="text: OD + ' ODs and 1 PH,'"></div>
							<div data-bind="text: RH + ' RHs, ' + HC + ' HCs and '+ FDH +' FDHs'"></div>
							<div>Doctors: NA, Nurses: NA</div>
							<div>Average staff/HC: NA</div>
							<div data-bind="text: 'VMWs: ' + VMW + ', Average VMW/HC: ' + Math.round(VMW / HC)"></div>
							<div>PPs: NA</div>
							
						</div>
					</div>
				</div>
				<div style="background:#ED7D31; padding:3px">
					<b>II. CASELOADS</b>
				</div>
				<div>
					<div id="chart1" style="border:1px solid #ccc; margin:15px"></div>

					<div class="text-bold text-center" data-bind="text: 'Report for ' + PublishDate.format('MMMM - YYYY')"></div>
					<div data-bind="foreach: Array(Math.ceil($root.tableModel().length / 3))">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th rowspan="2" align="center" valign="middle">Summary Table</th>
									<!-- ko foreach: $root.get3Row($index()) -->
									<th align="center" colspan="4" data-bind="text: $data[0].Name_OD_E"></th>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<th align="center" colspan="4">-</th>
									<!-- /ko -->
									<th rowspan="2" align="center" valign="middle" width="60" style="background:#FFD966">Total</th>
								</tr>
								<tr data-bind="foreach: Array(3)" style="background:#FFF2CC">
									<th align="center" width="50">HF</th>
									<th align="center" width="50">VMW</th>
									<th align="center" width="50">MMW</th>
									<th align="center" width="80">Sub Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Reporting Rate:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" style="background:#FFD966">0</td>
								</tr>
								<tr>
									<td>Total #Tested:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Test')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Test')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Test')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Test')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>Total # Positive:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Positive')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Positive')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Positive')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Positive')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>Positivity Rate:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'PositiveRate')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'PositiveRate')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getAvg($data, 'PositiveRate')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0%</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getAvg3($index(), 'PositiveRate')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>Treament Rate:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'TreatmentRate')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'TreatmentRate')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getAvg($data, 'TreatmentRate')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0%</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getAvg3($index(), 'TreatmentRate')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>ACT Treatment Rate:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right">100%</td>
									<td align="right">100%</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">100%</td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0%</td>
									<!-- /ko -->
									<td align="right" style="background:#FFD966">100%</td>
								</tr>
								<tr>
									<td>Primaquine Treatment Rate:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'PrimaquineRate')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'PrimaquineRate')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getAvg($data, 'PrimaquineRate')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0%</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getAvg3($index(), 'PrimaquineRate')" style="background:#FFD966"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<br />

					<div style="border:1px solid darkblue"></div>
					<div id="chart2" style="border:1px solid #ccc; margin:15px"></div>

					<div class="text-bold text-center" data-bind="text: 'Report for ' + PublishDate.format('MMMM - YYYY')"></div>
					<div data-bind="foreach: Array(Math.ceil($root.tableModel().length / 3))">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th rowspan="2" align="center" valign="middle">Summary Table</th>
									<!-- ko foreach: $root.get3Row($index()) -->
									<th align="center" colspan="4" data-bind="text: $data[0].Name_OD_E"></th>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<th align="center" colspan="4">-</th>
									<!-- /ko -->
									<th rowspan="2" align="center" valign="middle" width="60" style="background:#FFD966">Total</th>
								</tr>
								<tr data-bind="foreach: Array(3)" style="background:#FFF2CC">
									<th align="center" width="50">HF</th>
									<th align="center" width="50">VMW</th>
									<th align="center" width="50">MMW</th>
									<th align="center" width="80">Sub Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td># PF:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Pf')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Pf')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Pf')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Pf')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td># Mix:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Mix')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Mix')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Mix')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Mix')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td># PV:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Pv')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Pv')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Pv')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Pv')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>M:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Male')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Male')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Male')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Male')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>F:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Female')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Female')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Female')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Female')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>0-4 years old:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Age0_4')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Age0_4')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Age0_4')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Age0_4')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>5-14 years old:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Age5_14')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Age5_14')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Age5_14')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Age5_14')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>15-49 years old:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Age15_49')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Age15_49')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Age15_49')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Age15_49')" style="background:#FFD966"></td>
								</tr>
								<tr>
									<td>50 years old or over:</td>
									<!-- ko foreach: $root.get3Row($index()) -->
									<td align="right" data-bind="text: $root.getValue($data, 'HF', 'Age50')"></td>
									<td align="right" data-bind="text: $root.getValue($data, 'VMW', 'Age50')"></td>
									<td align="center">-</td>
									<td align="right" data-bind="text: $root.getSum($data, 'Age50')" style="background:#FFF2CC"></td>
									<!-- /ko -->
									<!-- ko foreach: Array($root.fulfill($index())) -->
									<td align="right">-</td>
									<td align="right">-</td>
									<td align="center">-</td>
									<td align="right" style="background:#FFF2CC">0</td>
									<!-- /ko -->
									<td align="right" data-bind="text: $root.getSum3($index(), 'Age50')" style="background:#FFD966"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<br />

			<div style="background:#92D050; padding:3px">
				<b>III. Activity/Result</b>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<table style="margin:5px; width:100%">
						<tbody data-bind="foreach: Activity">
							<tr>
								<td align="center" width="40" style="font-size:24px">●</td>
								<td>
									<input class="form-control input-sm" data-bind="value: text" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-xs-4">
					<img width="200" height="150" data-bind="attr: { src: Photo }" style="border:1px solid green; margin:5px" />
					<button class="btn btn-primary btn-sm" data-bind="click: $root.selectFile, visible: $root.isNew">
						Choose<br />Photo
					</button>
				</div>
			</div>
			<div style="background:#ED7D31; padding:3px">
				<b>IV. CHALLENGES (Top 3)</b>
			</div>
			<div style="padding:5px 20px 5px 5px">
				<table class="width100p">
					<tbody data-bind="foreach: Challenge">
						<tr>
							<td align="center" width="40" style="font-size:24px">●</td>
							<td>
								<input class="form-control input-sm" data-bind="value: text" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="clearfix" style="padding:10px 0px 10px 30px">
				<div class="pull-right green_box1"></div>
				<div class="pull-right green_box2">
					<table style="width:100%; height:100%">
						<tr>
							<td width="120" style="padding-left:10px">
								<img src="/media/images/butterfly.png" />
							</td>
							<td style="padding-right:20px">
								<div class="text-bold">V. WAYS FORWARD</div>
								<div style="margin-top:5px">
									<table class="width100p">
										<tbody data-bind="foreach: WayForward">
											<tr>
												<td width="30" style="font-size:20px">➤</td>
												<td>
													<input class="form-control input-sm" data-bind="value: text" />
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && isNew()">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<input type="file" id="file" class="hide" data-bind="change: () => fileChanged($element.files)" accept="image/*" />

<!-- Modal Province -->
<div class="modal" id="modalProvince" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Select Province</h3>
			</div>
			<div class="modal-body">
				<select class="form-control" data-bind="value: modalPv, options: pvList, optionsValue: 'code', optionsText: 'name'"></select>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" style="width:100px">OK</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Bulletin.js')?>