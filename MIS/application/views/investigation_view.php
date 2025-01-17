<style>
	#tblList thead { background-color: #9AD8ED; }
	#tblList thead *, #tblList tbody * { font-size: 14px !important; }
	.search-area { background: #eee; border: 1px solid #ccc; padding: 4px 4px 2px 4px; }
	.headbox { color: white; padding: 2px 5px; font-size: 14px; }
	.headbox * { font-size: 14px; color: white; }
	.headboxblack { padding: 2px 5px; font-size: 14px; }
	.headboxblack * { font-size: 14px; }
	.tbl td { border: 1px solid black !important; }
	.tbl thead tr:first-child td { border-bottom-color: white !important; }
	.tblfill tr { height: 20px; vertical-align: bottom; }
	.checkfont { font-size:14px; }
	.underscore { display:inline-block; border-bottom:1px solid black; text-align:center; }

	.blacksection { background-color:black; color:white; padding:2px 5px; font-size: 14px; }
	.blacksection span { font-size: 14px; }
	.gray { background-color: lightgray; }
	.bold { font-weight: bold; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 text-bold lh26">Investigation Cases</div>
		<div class="pull-right">
			<button class="btn btn-default btn-sm width100" onclick="window.close()">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover" id="tblList">
			<thead>
				<tr>
					<th>Investigation Date</th>
					<th>Patient Name</th>
					<th>Passive Case ID</th>
					<th width="70" class="text-center">Detail</th>
					<th width="70" class="text-center" data-bind="visible: app.user.permiss['Health Center Data'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: isnot(Date_Of_Invest, null, r => moment(r).format('ll'))"></td>
					<td data-bind="text: Name_K"></td>
					<td data-bind="text: Passive_Case_Id"></td>
					<td class="text-center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td class="text-center" data-bind="visible: app.user.permiss['Health Center Data'].contain('Delete')">
						<a class="text-danger" data-bind="click: $root.deleteCase">Delete</a>
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
</div>

<div data-bind="visible: model() != null" style="display:none">
	<div class="panel panel-default" style="margin-top:15px; display:inline-block">
		<div class="panel-body" style="width:800px">
			<div class="headbox" style="background-color:#1d5867">
				<span>MALARIA CASE INVESTIGATION FORM</span>
				<span style="margin-left:80px">FOR P.Falciparum or mixed ONLY</span>
			</div>

			<div class="form-inline" style="margin:10px 5px -10px 5px">
				<div data-bind="if: listModel().length == 0">
					<span>Referred From HC: </span>
					<select data-bind="value: referredFrom,
							options: hcList,
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: '',
							change: changeReferredFrom" class="form-control input-sm minwidth150"></select>
				</div>
				<div data-bind="if: listModel().length > 0 && model() != null">
					<div data-bind="hidden: isnullempty(model().IncompleteReason)">
						<span>Incomplete Investigation Reason: </span>
						<kh data-bind="text: model().IncompleteReason"></kh>
					</div>
				</div>
			</div>

			<div style="border:1px solid black; margin-top:20px" data-bind="with: model">
				<div class="headbox" style="background-color:black">
					Section 1: CASE NOTIFICATION
				</div>
				<div style="border-bottom:1px solid black; padding:2px 5px">
					<table class="tblfill" style="width:100%">
						<tr>
							<td colspan="2">Notification Date:</td>
							<td width="70">DD/MM/YY</td>
							<td width="120">
							<span style="width:84%" class="underscore" data-bind="text: Date_Nof"></span>
							</td>
							<td colspan="2">Case ID #</td>
							<td colspan="2" width="120">
							<span style="width:100%" class="underscore" data-bind="text: Passive_Case_Id"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2">Family Name:</td>
							<td colspan="2">
							<span style="width:90%" class="underscore" data-bind="text: Family_Name"></span>
							</td>
							<td colspan="2">Given Name:</td>
							<td colspan="2">
							<span style="width:100%" class="underscore" data-bind="text: Given_Name"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2">Telephone:</td>
							<td colspan="2">
							<span style="width:90%" class="underscore" data-bind="text: Tel"></span>
							</td>
							<td colspan="2">Age (Years):</td>
							<td colspan="2">
							<span style="width:100%" class="underscore" data-bind="text: Age"></span>
							</td>
						</tr>
						<tr>
							<td>Sex</td>
							<td>
							<span>M </span>
							<span class="checkfont" data-bind="text: Gender=='M'?'☑':'☐'">☐</span>
							<span style="margin-left:10px">F </span>
							<span class="checkfont" data-bind="text: Gender=='F'?'☑':'☐'">☐</span>
							</td>
							<td colspan="4"></td>
						</tr>
						<tr>
							<td colspan="2">Village of residence:</td>
							<td colspan="2">
							<span style="width:90%" class="underscore" data-bind="text: Name_Vill_E"></span>
							</td>
							<td width="30">HC:</td>
							<td width="100">
							<span style="width:90%" class="underscore" data-bind="text: Name_Facility_E"></span>
							</td>
							<td width="30">OD:</td>
							<td width="100">
							<span style="width:90%" class="underscore" data-bind="text: Name_OD_E"></span>
							</td>
							<td>Province:</td>
							<td width="100">
							<span style="width:100%" class="underscore" data-bind="text: Name_Prov_E"></span>
							</td>
						</tr>
					</table>
				</div>
				<table style="width:100%; margin-top:-1px">
					<tr style="background-color: #ddd9c2">
						<td colspan="6">Type of Notification</td>
					</tr>
					<tr>
						<td width="250" >Passive case detection</td>
						<td width="140" class="checkfont" data-bind="text: Passive_Case_Detection=='1'?'☑':'☐'">☐</td>

						<td width="250" >Reactive-case detection</td>
						<td width="140" class="checkfont" data-bind="text: Reactive_Case_Detection=='1'?'☑':'☐'">☐</td>

						<td width="250" >Pro-active case detection</td>
						<td width="140" class="checkfont" data-bind="text: Pro_Active_Case_Detection=='1'?'☑':'☐'">☐</td>
					</tr>
					<tr>
						<td>Point Of Care OD</td>
						<td><span style="width:100%" class="underscore" data-bind="text: Point_Of_Care_OD"></span></td>
						<td>&nbsp;</td>
						<td width='230'>Point Of Care Province</td>
						<td><span style="width:100%" class="underscore" data-bind="text: Point_Of_Care_Province"></span></td>
					</tr>
				</table>
				<table style="width:100%; margin-top:-1px">
					<tr>
						<td style="border:1px solid black; border-left:none; padding:0 3px; position:relative" width="45%">
							<table style="width:100%; position:relative" class="tblfill" >
								<tr>
									<td>If Passive case detection</td>
								</tr>
								<tr>
									<td>Referral Hospital</td>
									<td align="right" class="checkfont" data-bind="text: Referral_Hospital=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Former District Hospital</td>
									<td align="right" class="checkfont" data-bind="text: Former_Dist_Hospital=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Health Center</td>
									<td align="right" class="checkfont" data-bind="text: Health_Center=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Health Post</td>
									<td align="right" class="checkfont" data-bind="text: Health_Post=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Village Malaria Worker</td>
									<td align="right" class="checkfont" data-bind="text: Vill_Malaria_Worker=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Mobile Malaria Worker</td>
									<td align="right" class="checkfont" data-bind="text: Mobile_Malaria_Worker=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Private Provider</td>
									<td align="right" class="checkfont" data-bind="text: Private_Provider=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Armed Force</td>
									<td align="right" class="checkfont" data-bind="text: Armed_Force=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Police</td>
									<td align="right" class="checkfont" data-bind="text: Police=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Point of care name</td>
									<td>
										<span style="width:100%" class="underscore" data-bind="text: Point_Of_Care_Name"></span>
									</td>
								</tr>
								<tr>
									<td>Point of care ID #</td>
									<td>
										<span style="width:100%" class="underscore" data-bind="text: Point_Of_Care_Id_1"></span>
									</td>
								</tr>
							</table>
						</td>
						<td width="20"></td>
						<td style="border:1px solid black; border-right:none; padding:0 3px; position:relative">

							<table style="width:100%; position:relative" class="tblfill">
								<tr>
									<td>If Re-active case detection</td>
								</tr>
								<tr>
									<td>Index case ID  #</td>
									<td>
										<span style="width:100%" class="underscore" data-bind="text: Reactive_Index_Case_Id"></span>
									</td>
								</tr>
								<tr>
									<td>Health Center Name</td>
									<td>
										<span style="width:100%" class="underscore" data-bind="text: Health_Center_Name"></span>
									</td>
								</tr>
								<tr>
									<td>Point of care ID #</td>
									<td>
										<span style="width:100%" class="underscore" data-bind="text: Point_Of_Care_Id"></span>
									</td>
								</tr>
								<tr style="border-bottom:1px solid black">
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td>If Pro-active case detection</td>
									<td align="right" class="checkfont" data-bind="text: Pro_Active_Case_Detection=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Mobile and migrants</td>
									<td align="right" class="checkfont" data-bind="text: Mobile_And_Migrants=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Border screening</td>
									<td align="right" class="checkfont" data-bind="text: Border_Screening=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Focal mass screening</td>
									<td align="right" class="checkfont" data-bind="text: Focal_Mass_Screening=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Focal fever screening</td>
									<td align="right" class="checkfont" data-bind="text: Focal_Fever_Screening=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr>
									<td>Focal targeted screening</td>
									<td align="right" class="checkfont" data-bind="text: Focal_Target_Screening=='1'?'☑':'☐'">☐</td>
								</tr>
								<tr >
									<td colspan="2">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<div class="headbox" style="background-color:black; margin-top:-1px">
					SECTION 2: CASE INVESTIGATION
				</div>

				<div style="padding:2px 5px">
					<table class="tblfill">
						<tr>
							<td width="140">Date of investigation:</td>
							<td width="70">DD/MM/YY</td>
							<td width="120">
								<span style="width:84%" class="underscore" data-bind="text: Date_Of_Invest"></span>
							</td>
						</tr>
						<tr>
							<td>Conducted by: (name)</td>
							<td colspan="2">
								<span style="width:90%" class="underscore" data-bind="text: Conducted_By"></span>
							</td>
							<td>Telephone: #</td>
							<td>
								<span style="width:100%" class="underscore" data-bind="text: Case_Invest_Tel"></span>
							</td>
						</tr>
					</table>
				</div>

				<div class="" style=" border-top:1px solid black">
					<table class="tblfill">
						<tr>
							<td colspan="2">Introduction to village authority, community leaders</td>
							<td style="width:100px">Village with VMW  </td>
							<td class="checkfont" data-bind="text: Vill_With_VMW=='1'?'☑':'☐'">☐</td>

							<td colspan="3">Available today for case investigation</td>
							<td class="checkfont" data-bind="text: Available_Today_For_Case_Invest=='1'?'☑':'☐'">☐</td>

						</tr>
						<tr>
							<td colspan="3">Localization of the residence:	GPS coordinates</td>
							<td style="width:80px">LONG</td>
							<td><span style="width:80px" class="underscore" data-bind="text: Longitude"></span></td>
							<td style="width:80px; padding-left: 20px">LAT</td>
							<td><span style="width:80px" class="underscore" data-bind="text: Latitude"></span></td>
						</tr>
						<tr>
							<td colspan="2">Verify case ID, introduction, informed verbal consent           Respondent: </td>
							<td>&nbsp;</td>
							<td>Case Himself</td>
							<td class="checkfont" data-bind="text: Case_Himself=='1'?'☑':'☐'">☐</td>

							<td>Relative</td>
							<td class="checkfont" data-bind="text: Relative=='1'?'☑':'☐'">☐</td>

							<td>Not met</td>
							<td class="checkfont" data-bind="text: Not_Met=='1'?'☑':'☐'">☐</td>
						</tr>
					</table>
				</div>
				<div class="headboxblack" style="background-color:#ddd9c2; border-top:1px solid black">
					CASE'S PROFILE
				</div>
				<div style="border-top:1px solid black">
					<div>
						<span>Occupation: Agriculture, farming</span>
						<span class="checkfont" data-bind="text: Agriculture=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Manufacture</span>
						<span class="checkfont" data-bind="text: Manufacture=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Student</span>
						<span class="checkfont" data-bind="text: Student=='1'?'☑':'☐'">☐</span>
						<span>Trade, Service</span>
						<span class="checkfont" data-bind="text: Trade=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Civil servant</span>
						<span class="checkfont" data-bind="text: Civil_Servant=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Other</span>
						<span class="checkfont" data-bind="text: Other_Activity=='1'?'☑':'☐'">☐</span>
						<span style="width:80px" class="underscore" data-bind="text: Other_Activity_Note"></span>
					</div>
					<div>
						<span>Current residence since : </span>
						<span style="margin-left:10px"> >1 Year</span>
						<span class="checkfont" data-bind="text: Residence_Gth_1Y=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">6 months - 1 year </span>
						<span class="checkfont" data-bind="text: Residence_Lth_1Y_Gth_6M=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">1 week - < 6 months</span>
						<span class="checkfont" data-bind="text: Residence_Lth_6M=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">< 1 Week </span>
						<span class="checkfont" data-bind="text: Residence_Lth_1W=='1'?'☑':'☐'">☐</span>
					</div>

					<div>
						<span>Citizenship:</span>
						<span style="margin-left:10px">Cambodia </span>
						<span class="checkfont" data-bind="text: Cambodia=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Other country: </span>
						<span style="width:150px" class="underscore" data-bind="text: Other_Citizen"></span>
					</div>
				</div>

				<div class="headboxblack" style="background-color:#b7cbe5; border-top:1px solid black">
					HISTORY OF CURRENT EPISODE
				</div>
				<div style="padding:2px 5px; border-top:1px solid black">
					<div>
						<span>Symptoms before diagnosis: Fever</span>
						<span class="checkfont" data-bind="text: Fever=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Chills</span>
						<span class="checkfont" data-bind="text: Chills=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Sweat</span>
						<span class="checkfont" data-bind="text: Sweat=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Headache</span>
						<span class="checkfont" data-bind="text: Headache=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Nausea</span>
						<span class="checkfont" data-bind="text: Nausea=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Vomiting</span>
						<span class="checkfont" data-bind="text: Vomiting=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Diarrhoea</span>
						<span class="checkfont" data-bind="text: Diarrhoea=='1'?'☑':'☐'">☐</span>
					</div>
					<div>
						<span>Date of first symptoms DD/MM/YY</span>
						<span style="width:100px" class="underscore" data-bind="text: Date_Of_First_Symtom"></span>
						<span style="margin-left:20px">No symptom</span>
						<span class="checkfont" data-bind="text: No_Symtom=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Other notifable signs</span>
						<span style="width:150px" class="underscore" data-bind="text: Other_Notifable_Signs"></span>
					</div>
				</div>

				<div class="headboxblack" style="background-color:#b7cbe5; border-top:1px solid black">
					COMPLETION OF TREATMENT
				</div>
				<div style="padding:2px 5px; border-top:1px solid black">
					<div>
						<span>Treatment prescribed: AS+MQ</span>
						<span class="checkfont" data-bind="text: ASMQ=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Other</span>
						<span style="width:150px" class="underscore" data-bind="text: Treatment_Other"></span>
						<span style="margin-left:10px">SLD Primaquine </span>
						<span class="checkfont" data-bind="text: SLD_Primaquine=='1'?'☑':'☐'">☐</span>
						<span style="width:150px" class="underscore" data-bind="text: SLD_Primaquine_Mg"></span>
					</div>
					<div>
						<span>Treatment completed</span>
						<span class="checkfont" data-bind="text: Treatment_Completed=='1'?'☑':'☐'">☐</span>
						<span>Tablets of </span>
						<span style="width:50px" class="underscore" data-bind="text: Tablets_Of"></span>
						<span>mg/</span>
						<span style="width:50px" class="underscore" data-bind="text: Mg"></span>
						<span>mg,</span>
						<span style="width:50px" class="underscore" data-bind="text: Tablets"></span>
						<span>tablets</span>
						<span style="width:50px" class="underscore" data-bind="text: Times_Per_Day"></span>
						<span>times per day, for</span>
						<span style="width:50px" class="underscore" data-bind="text: For_Days"></span>
						<span>days</span>
					</div>
					<div>
						<span>Treatment not yet completed </span>
						<span class="checkfont" data-bind="text: Treatment_Not_Completed=='1'?'☑':'☐'">☐</span>
						<span>(if visited before D2)</span>
					</div>
				</div>

				<div class="headboxblack" style="background-color:#ddd9c2; border-top:1px solid black">
					MALARIA HISTORY
				</div>

				<div style="padding:2px 5px;; border-top:1px solid black">
					<div>
						<span>Had malaria ever: </span>
						<span class="checkfont" data-bind="text: Had_Malaria_Ever=='1'?'☑':'☐'">☐</span>
						<span>Yes</span>
						<span class="checkfont" data-bind="text: Had_Malaria_Ever=='0'?'☑':'☐'">☐</span>
						<span>No</span>
						<span>If yes, date last episode of malaria:    </span>
						<span style="width:100px" class="underscore" data-bind="text: Last_Episode"></span>
					</div>

					<div>
						<span>Was confirmed by testing </span>
						<span class="checkfont" data-bind="text: Confirm_By_Testing=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:10px">Diagnosis made by:     Public HF </span>
						<span class="checkfont" data-bind="text: Diagnosis_By_Public_HF=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:10px">VMW</span>
						<span class="checkfont" data-bind="text: Diagnosis_By_VMW=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:10px">PPM</span>
						<span class="checkfont" data-bind="text: Diagnosis_By_PPM=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:10px">Other</span>
						<span class="checkfont" data-bind="text: Diagnosis_By_Other=='1'?'☑':'☐'">☐</span>
					</div>

					<div>
						<span>Got treatment from:	Public HF </span>
						<span class="checkfont" data-bind="text: Got_Treatment_From_Public_HF=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">PPM</span>
						<span class="checkfont" data-bind="text: Got_Treatment_From_PPM=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">VMW</span>
						<span class="checkfont" data-bind="text: Got_Treatment_From_VMW=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">Pharmacy</span>
						<span class="checkfont" data-bind="text: Got_Treatment_From_Pharmacy=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">Shop</span>
						<span class="checkfont" data-bind="text: Got_Treatment_From_Shop=='1'?'☑':'☐'">☐</span>
					</div>
					<div>
						<span>Remember which drug? </span>
						<span style="width:150px" class="underscore" data-bind="text: Remember_Drug"></span>
						<span>, for</span>
						<span style="width:50px" class="underscore" data-bind="text: Drug_For_Days"></span>
						<span>days?</span>
					</div>
				</div>

				<div class="headboxblack" style="background-color:#ddd9c2; border-top:1px solid black">
					HOUSE-HOLD AND PREVENTION  (Optional)
				</div>
				<div  style="padding:2px 5px;; border-top:1px solid black">
					<div>
						<span>Did somebody in your household had malaria </span>
						<span class="checkfont" data-bind="text: Somebody_Has_Malaria_Ever=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">Ever   Within last month </span>
						<span class="checkfont" data-bind="text: Somebody_Has_Malaria_With_Last_M=='1'?'☑':'☐'">☐</span>
						<span>Last 12 months </span>
						<span class="checkfont" data-bind="text: Somebody_Has_Malaria_With_Last_12M=='1'?'☑':'☐'">☐</span>
					</div>

					<div>
						<span>How many people living in this house-hold? </span>
						<span style="width:50px" class="underscore" data-bind="text: Household"></span>
						<span  style="margin-left:20px">How many separate sleeping places? </span>
						<span style="width:50px" class="underscore" data-bind="text: Sleeping_Places"></span>
					</div>

					<div>
						<span>How many mosquito nets </span>
						<span style="width:50px" class="underscore" data-bind="text: Mosquito_Nets"></span>
						<span  style="margin-left:20px">Did you sleep under a mosquito net last night?  Yes</span>
						<span class="checkfont" data-bind="text: Sleep_Under_Mosquito_Net_Last_Night=='1'?'☑':'☐'">☐</span>
						<span>No</span>
						<span class="checkfont" data-bind="text: Sleep_Under_Mosquito_Net_Last_Night=='0'?'☑':'☐'">☐</span>
					</div>

					<div>
						<span>Got the net less than one year ago </span>
						<span class="checkfont" data-bind="text: Got_Net_Lth_1Y=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">1-2 Years</span>
						<span class="checkfont" data-bind="text: Got_Net_1_To_2Y=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">More than 2 years</span>
						<span class="checkfont" data-bind="text: Got_Net_Gth_2Y=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">More than 3 years</span>
						<span class="checkfont" data-bind="text: Got_Net_Gth_3Y=='1'?'☑':'☐'">☐</span>
					</div>

					<div>
						<span>Got the net from Government </span>
						<span class="checkfont" data-bind="text: Got_Net_From_Gov=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">From NGO </span>
						<span class="checkfont" data-bind="text: Got_Net_From_NGO=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">Bought it from shop/market </span>
						<span class="checkfont" data-bind="text: Got_Net_From_Shop=='1'?'☑':'☐'">☐</span>
						<span  style="margin-left:20px">(HE on spot)</span>
					</div>
				</div>

				<div class="headboxblack" style="background-color:#ddd9c2; border-top:1px solid black">
					SECTION 3: CASE CLASSIFICATION
				</div>
				<div  style="padding:2px 5px;; border-top:1px solid black">
					<div>
						<div>1.	Did you sleep every night in this village within the last 2 weeks?</div>
						<div style="margin-left: 15px; background-color:yellow">
							Yes
							<span class="checkfont" data-bind="text: Sleep_Every_Night_In_This_Vill=='1'?'☑':'☐'">☐</span>
							→ classify L1	CONDUCT REACTIVE CASE DETECTION
						</div>
						<div style="margin-left: 15px">
							No
								<span class="checkfont" data-bind="text: Sleep_Every_Night_In_This_Vill=='0'?'☑':'☐'">☐</span>
							→ Go to 2
						</div>
					</div>
				</div>

				<div  style="padding:2px 5px; border-top:1px solid black">
					<div>
						<div>2.	Did you sleep at least one night in another village in the same catchment area of this HC within the last 2 weeks?  </div>
						<div style="margin-left: 15px; background-color:yellow">
								Yes
								<span class="checkfont" data-bind="text: Sleep_At_Least_One_Night_In_Other_Village_In_Same_HC=='1'?'☑':'☐'">☐</span>
								→ classify L2 AND CONDUCT REACTIVE CASE DETECTION   Name of the other village
								<span style="width:150px" class="underscore" data-bind="text: $root.getVLName(Other_Village_Name)"></span>
						</div>
						<div style="margin-left: 15px">
							No
							<span class="checkfont" data-bind="text: Sleep_At_Least_One_Night_In_Other_Village_In_Same_HC=='0'?'☑':'☐'">☐</span>
							→ Go to 3
						</div>
					</div>
				</div>

				<div  style="padding:2px 5px; border-top:1px solid black">
					<div>
						<div>3.	Did you sleep at least one night in another village in the same OD within the last 2 weeks? </div>
						<div style="margin-left: 15px;">
							<span>
								Yes
								<span class="checkfont" data-bind="text: Sleep_At_Least_One_Night_In_Other_Village_In_Same_OD=='1'?'☑':'☐'">☐</span>
									→ classify L3
							</span>

								<span style="margin-left: 100px">
									No
									<span class="checkfont" data-bind="text: Sleep_At_Least_One_Night_In_Other_Village_In_Same_OD=='0'?'☑':'☐'">☐</span>
									→ Go to 4
								</span>
						</div>
					</div>
				</div>

				<div  style="padding:2px 5px; border-top:1px solid black">
					<div>
						<div>4.	Did you sleep at least one night elsewhere in Cambodia within the last 2 weeks? </div>
						<div style="margin-left: 15px;">
							<span>
								Yes
								<span class="checkfont" data-bind="text: Sleep_At_Least_One_Night_Elsewhere_Cambodia=='1'?'☑':'☐'">☐</span>
								→ classify L4 In Which Province
								<span style="width:100px" class="underscore" data-bind="text: $root.getPVName(Which_Province)"></span>
							</span>

							<span style="margin-left:50px">
								No
								<span class="checkfont" data-bind="text: Sleep_At_Least_One_Night_Elsewhere_Cambodia=='0'?'☑':'☐'">☐</span>
								→ Go to 5
							</span>
						</div>
					</div>
				</div>

				<div  style="padding:2px 5px; border-top:1px solid black">
					<div>
						<div>5.	Did you sleep at least one night in another country within the last 2 weeks?</div>
						<div style="margin-left: 15px;">
							<span>
								Yes
								<span class="checkfont" data-bind="text: Sleep_At_Least_One_Night_In_Other_Country=='1'?'☑':'☐'">☐</span>
								→ classify L4 in Which Country
								<span style="width:100px" class="underscore" data-bind="text: Which_Country"></span>
							</span>

							<span style="margin-left:50px">
								No
								<span class="checkfont" data-bind="text: Sleep_At_Least_One_Night_In_Other_Country=='0'?'☑':'☐'">☐</span>
								→ Go back to 1
							</span>
						</div>
					</div>
				</div>

				<div class="headboxblack" style="background-color:#ddd9c2; border-top:1px solid black">
					FOR L1/L2 CASES ONLY: DETAIL OVERNIGHT STAYS AROUND THE VILLAGE
				</div>

				<div  style="padding:2px 5px; border-top:1px solid black">
					<div>
						<span>1. Did you sleep outside your house around the village?</span>
						<span>Yes</span>
						<span class="checkfont" data-bind="text: Sleep_Outside_House=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">→ Last week</span>
						<span class="checkfont" data-bind="text: Sleep_Outside_House_Last_Week=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Week before last week</span>
						<span class="checkfont" data-bind="text: Sleep_Outside_House_Week_Before=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">No</span>
						<span class="checkfont" data-bind="text: Sleep_Outside_House=='-1'?'☑':'☐'">☐</span>
						<span>→ Stop here</span>
					</div>

					<div>
						<span>2. Did you sleep in the forest? No</span>
						<span class="checkfont" data-bind="text: Forest=='0'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Yes</span>
						<span class="checkfont" data-bind="text: Forest=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">→ Harvesting</span>
						<span class="checkfont" data-bind="text: For_Harvesting=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Logging</span>
						<span class="checkfont" data-bind="text: Logging=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Hunting</span>
						<span class="checkfont" data-bind="text: Hunting=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Fishing</span>
						<span class="checkfont" data-bind="text: Fishing=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Other</span>
						<span class="checkfont" data-bind="text: Other=='1'?'☑':'☐'">☐</span>
						<span style="width:100px" class="underscore" data-bind="text: Other_Note"></span>
					</div>

					<div>
						<span>3. Did you sleep at worksite? No </span>
						<span class="checkfont" data-bind="text: Work_Site=='0'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Yes</span>
						<span class="checkfont" data-bind="text: Work_Site=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">→ Plantation </span>
						<span class="checkfont" data-bind="text: Plantation=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Farm</span>
						<span class="checkfont" data-bind="text: Farm=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Logging</span>
						<span class="checkfont" data-bind="text: Work_Logging=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Mine</span>
						<span class="checkfont" data-bind="text: Mine=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">Construction Site</span>
						<span class="checkfont" data-bind="text: Construction_Site=='1'?'☑':'☐'">☐</span>
					</div>

					<div>
						<span>4. Did you sleep in: A house</span>
						<span class="checkfont" data-bind="text: Sleep_In_House=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">A plot hut</span>
						<span class="checkfont" data-bind="text: A_Plot_Hut=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">A tent</span>
						<span class="checkfont" data-bind="text: A_Tent=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">A camp</span>
						<span class="checkfont" data-bind="text: A_Camp=='1'?'☑':'☐'">☐</span>
					</div>

					<div>
						<span>5. Did you sleep under: A mosquito net? Yes</span>
						<span class="checkfont" data-bind="text: Sleep_Under_Mosquito_Net=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">No</span>
						<span class="checkfont" data-bind="text: Sleep_Under_Mosquito_Net=='0'?'☑':'☐'">☐</span>
						<span style="margin-left:100px">A hammock with net? Yes </span>
						<span class="checkfont" data-bind="text: Hammock_With_Net=='1'?'☑':'☐'">☐</span>
						<span style="margin-left:10px">No</span>
						<span class="checkfont" data-bind="text: Hammock_With_Net=='0'?'☑':'☐'">☐</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Investigation.js')?>