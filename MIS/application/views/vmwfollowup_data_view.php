<style>
	body {
		background-color: #f3f1f196;
	}

	.card {
		box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
		border: 2px solid #01c0c8;
		background: #fff;
	}

    .btn-circle {
        border-radius: 100%;
        width: 25px;
        height: 25px;
        padding: 2px;
    }
    * {
		font-family: Content, sans-serif;
    }
    .table td, .table th {
        padding: 0.2rem;
        vertical-align: top;
        white-space: nowrap;
    }

    .table thead th {
        border-bottom: none;
        vertical-align: middle;
        text-align: center;
		height: 40px;
    }

    .table thead tr th {
        font-weight: bold;
    }

    .table tbody {
        font-weight: 500;
    }

	.section-title {font-family:'Khmer OS Siemreap'; color: #2980b9; font-weight: 700}
    
</style>

<div data-bind="page: {id: 'start', title: 'Last Mile Data', scrollToTop: true, sourceCache: false}" style="display: none">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">VMW Follow up Data</h4>
					<form>
						<div class="container9">
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: pv,
											options: pvList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: pvList().length == 1 ? undefined : 'Select Province'"
											class="form-control input-sm minwidth150"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: od,
											options: odList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: odList().length == 1 ? undefined : 'All OD'"
											class="form-control input-sm minwidth150"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: hc,
											options: hcList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'All HC'"
											class="form-control"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: vl,
											options: vlList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'All Villages'"
											class="form-control"></select>
									</div>
								</div>
								<div class="col-sm-1">
									<div class="form-group">
										<select data-bind="value: year, options: yearList" class="form-control input-sm width70"></select>
									</div>
								</div>

								<div class="col-sm-1">
									<div class="form-group">
										<select data-bind="value: month, options: monthList, optionsCaption: 'All'" class="form-control"></select>
									</div>
								</div>

								<div class="col-sm-2">
									<a href="/Home" class="btn btn-dark pull-right"><i class="fa fa-home"></i> Home</a>
									<a href="/VMWFollowup" class="btn btn-success pull-right" style="margin-right: 5px"><i class="fa fa-list"></i> Form</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- List -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-striped table-hover">
						<thead class="bg-info">
							<tr>
								<th width="40" align="center">#</th>
								<th align="center">Province</th>
								<th align="center">OD</th>
								<th align="center">HC</th>
								<th align="center">Village</th>
								<th align="center">Patient Name</th>
								<th align="center">Patient Code</th>
								<th align="center">Age</th>
								<th align="center">Sex</th>
								<th align="center">Completeness</th>
								<th align="center">Action</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: dataList, fixedHeader: true">
							<tr>
								<td data-bind="text: $index() + 1" class="text-center"></td>
								<td data-bind="text: Name_Prov_E"></td>
								<td data-bind="text: Name_OD_E"></td>
								<td data-bind="text: Name_Facility_E"></td>
								<td data-bind="text: Name_Vill_E"></td>
								<td data-bind="text: NameK"></td>
								<td data-bind="text: PatientCode"></td>
								<td data-bind="text: Age"></td>
								<td data-bind="text: Sex"></td>
								<td class="text-center"> 
									Day3  <i data-bind="visible: Day3 == 1" class="fa fa-check-square text-success"></i> <i data-bind="visible: Day3 != 1" class="fa fa-times-rectangle text-warning"></i>
									Day7  <i data-bind="visible: Day7 == 1" class="fa fa-check-square text-success"></i> <i data-bind="visible: Day7 != 1" class="fa fa-times-rectangle text-warning"></i>
									Day14 <i data-bind="visible: Day14 == 1" class="fa fa-check-square text-success"></i> <i data-bind="visible: Day14 != 1" class="fa fa-times-rectangle text-warning"></i>
								</td>
								<td align="center">
									<a class="btn btn-sm btn-success" data-bind="page-href: {path: '/detail', params: {case_id: Case_ID}}">
										<i class="fa fa-list"></i> detail
									</a>
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
		</div>
	</div>

</div>

<!-- tab -->
<div data-bind="page: {id: 'detail', title: 'Follow up patient', params: ['case_id'], scrollToTop: true}" style="display: none">
	<!--header-->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Detail</h4>
					<form>
						<div class="container9">
							<div class="row">
								<div class="col-sm-4">
									<div class="button-group">
										<a data-bind="page-href: {path: 'Day3', params: {id: case_id} }" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Day 3</a>
										<a data-bind="page-href: {path: 'Day7', params: {id: case_id} }" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Day 7</a>
										<a data-bind="page-href: {path: 'Day14', params: {id: case_id} }" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Day 14</a>
									</div>
								</div>
								<div class="col-sm-8">
									<a href="#" class="btn btn-dark pull-right"> Back</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row" data-bind="page: {id: '?', params: ['id', 'day'], title: 'Follow up', scrollToTop: true, sourceCache:false, withOnShow: loadFollowup}" style="display: none">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title" style="text-align:center">
						<kh>
							តាមដានអ្នកជម្ងឺ
						</kh>
					</h5>
					<hr />

					<table style="margin:0 auto; width: 50%" class="table info-bordered-table table-striped box-shadow">
						<tbody data-bind="with: followup">
							<tr>
								<td colspan="2"><h5 class="section-title">ផ្នែកទី១</h5></td>
							</tr>
							<tr>
								<td>ថ្ងៃនៃការប្រើប្រាស់ថ្នាំ</td>
								<td style="color: #c0392b" data-bind="text: Day"></td>
							</tr>
							<tr>
								<td>១.​ កាលបរិឆ្ឆេទ</td>
								<td data-bind="text: Date"></td>
							</tr>
							<tr>
								<td>២.​ វិធីសាស្ត្រដាមដាន</td>
								<td>
									<div class="form-group">
										<div class="custom-control custom-radio">
											<input disabled   type="radio" id="method1" name="Method" class="custom-control-input" value="Direct" data-bind="checked: Method" />
											<label class="custom-control-label" for="method1">ជួបអ្នកជំងឺផ្ទាល់</label>
										</div>
										<div class="custom-control custom-radio">
											<input disabled   type="radio" id="method2" name="Method" class="custom-control-input" value="Phone" data-bind="checked: Method" />
											<label class="custom-control-label" for="method2">សាកសួរតាមទូរស័ព្ទ</label>
										</div>
									
									</div>
								</td>
							</tr>

							<tr>
								<td>៣. ពិនិត្យមើលស្ថានភាពអ្នកជំងឺ:</td>
								<td>
									<div  class="form-group">
										<div class="custom-control custom-radio">
											<input disabled  type="radio" id="feeling1" name="Feeling" class="custom-control-input" value="Better" data-bind="checked: Feeling" />
											<label class="custom-control-label" for="feeling1">ធូរស្រាល</label>
										</div>
										<div class="custom-control custom-radio">
											<input disabled  type="radio" id="feeling2" name="Feeling" class="custom-control-input" value="Same" data-bind="checked: Feeling" />
											<label class="custom-control-label" for="feeling2">នៅដដែល</label>
										</div>
										<div class="custom-control custom-radio">
											<input disabled  type="radio" id="feeling3" name="Feeling" class="custom-control-input" value="Worse" data-bind="checked: Feeling" />
											<label class="custom-control-label" for="feeling3">កាន់តែធ្ងន់ធ្ងរ</label>
										</div>
									</div>
									
								</td>
							</tr>

							<tr>
								<td colspan="2"> <h5 class="section-title">ផ្នែកទី២</h5></td>

							</tr>


							<tr>
								<td> ១. តើអ្នកជំងឺបានបញ្ចប់ការលេបថ្នាំASMQ ហើយឬនៅ?</td>
								<td>
									<div class="form-group">
										<div class="custom-control custom-radio">
											<input disabled  type="radio" id="asmq1" name="ASMQ" class="custom-control-input" value="Yes" data-bind="checked: ASMQ" />
											<label class="custom-control-label" for="asmq1">បាទ/ចាស៎</label>
										</div>
										<div class="custom-control custom-radio">
											<input disabled  type="radio" id="asmq2" name="ASMQ" class="custom-control-input" value="No" data-bind="checked: ASMQ" />
											<label class="custom-control-label" for="asmq2">ទេ</label>
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<td> ២. តើអ្នកជំងឺបានលេបថ្នាំព្រីម៉ាគីនរៀងរាល់ថ្ងៃទេ?</td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="primaquine1" name="Primaquine" class="custom-control-input" value="Yes" data-bind="checked: Primaquine" />
										<label class="custom-control-label" for="primaquine1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="primaquine2" name="Primaquine" class="custom-control-input" value="No" data-bind="checked: Primaquine" />
										<label class="custom-control-label" for="primaquine2">ទេ</label>
									</div>
								</td>
							</tr>

							<tr>
								<td> ៣. បើសិន "ទេ" តើហេតុអ្វី? (អាចគូសចំលើយលើស​ពីមួយ):</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="Forget" name="NoPrimaquineReason" value="Forget" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="Forget">ភ្លេច</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="NotSick" name="NoPrimaquineReason" value="NotSick" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="NotSick">មិនមានអារម្មណ៏ឈឺ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="SideEffect" name="NoPrimaquineReason" value="SideEffect" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="SideEffect">ទទួលផលប៉ះពាល់ពីការប្រើប្រាស់ថ្នាំ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="Travel" name="NoPrimaquineReason" value="Travel" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="Travel">ធ្វើដំណើរ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="LostMedicine" name="NoPrimaquineReason" value="LostMedicine" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="LostMedicine">បាត់ថ្នាំ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="NotTrust" name="NoPrimaquineReason" value="NotTrust" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="NotTrust">មិនទុកចិត្តលើថ្នាំ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="NotNotedOtherReason" name="NoPrimaquineReason" value="NotNotedOtherReason" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="NotNotedOtherReason">ហេតុផលផ្សេងទៀត (សូមបញ្ជាក់):</label>
									</div>
									
									<input disabled  type="text" class="form-control" data-bind="value: NoPrimaquineOtherReason" />
									
								</td>
							</tr>

							<tr>
								<td> ៤. ពិនិត្យមើលប័ណ្ណអ្នកជំងឺ។ តើអ្នកជំងឺបានកត់ត្រាលើប័ណ្ណបានត្រឹមត្រូវដែរឬទេ?</td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="note1" name="CardNoted" class="custom-control-input" value="Yes" data-bind="checked: CardNoted" />
										<label class="custom-control-label" for="note1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="note2" name="CardNoted" class="custom-control-input" value="No" data-bind="checked: CardNoted" />
										<label class="custom-control-label" for="note2">ទេ</label>
									</div>
									
									<div style="margin-left: 47px" data-bind="visible: CardNoted == 'No'">
										<div class="custom-control custom-checkbox">
											<input disabled  type="checkbox" class="custom-control-input" id="IncompleteDate" name="NotNotedReason" value="IncompleteDate" data-bind="checked: NotNotedReason" />
											<label class="custom-control-label" for="IncompleteDate">មិនបានបំពេញកាលបរិឆ្ឆេទ</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input disabled  type="checkbox" class="custom-control-input" id="NotTick" name="NotNotedReason" value="NotTick" data-bind="checked: NotNotedReason" />
											<label class="custom-control-label" for="NotTick">មិនបានគូសធីកក្រោយលេបថ្នាំរួច</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input disabled  type="checkbox" class="custom-control-input" id="AdvancedCompleted" name="NotNotedReason" value="AdvancedCompleted" data-bind="checked: NotNotedReason" />
											<label class="custom-control-label" for="AdvancedCompleted">បំពេញទុកជាមុនមុនពេលលេបថ្នាំ</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input disabled  type="checkbox" class="custom-control-input" id="NoteNotFound" name="NotNotedReason" value="NoteNotFound" data-bind="checked: NotNotedReason" />
											<label class="custom-control-label" for="NoteNotFound">រកប័ណ្ណមិនឃើញ</label>
										</div>
									</div>
								</td>
							</tr>

							<tr>
								<td> ៥.​ តើនៅសល់ប៉ុន្មានថ្ងៃទៀតអ្នកជំងឺនឹងបញ្ចប់ ការលេប​ថ្នាំព្រីម៉ាគីន?</td>
								<td>
									<input disabled  type="number" class="form-control" data-bind="value: PrimaquineRemain" />
								</td>
							</tr>

							<tr>
								<td colspan="2"> <h5 class="section-title">ផ្នែកទី៣</h5></td>
							</tr>

							<tr>
								<td>១. គ្រុនក្តៅធ្ងន់ធ្ងរ</td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="SevereFever" name="SevereFever" class="custom-control-input" value="Yes" data-bind="checked: SevereFever" />
										<label class="custom-control-label" for="SevereFever">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="SevereFever2" name="SevereFever" class="custom-control-input" value="No" data-bind="checked: SevereFever" />
										<label class="custom-control-label" for="SevereFever2">ទេ</label>
									</div>
								</td>
							</tr>

							<tr>
								<td> ២. រងាញាក់ខ្លាំង</td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="VeryChills" name="VeryChills" class="custom-control-input" value="Yes" data-bind="checked: VeryChills" />
										<label class="custom-control-label" for="VeryChills">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="VeryChills2" name="VeryChills" class="custom-control-input" value="No" data-bind="checked: VeryChills" />
										<label class="custom-control-label" for="VeryChills2">ទេ</label>
									</div>
								</td>
							</tr>

							<tr>
								<td> ៣. ឈឹកំពង់ករាំរ៉ៃ</td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="SoreThroat" name="SoreThroat" class="custom-control-input" value="Yes" data-bind="checked: SoreThroat" />
										<label class="custom-control-label" for="SoreThroat">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="SoreThroat2" name="SoreThroat" class="custom-control-input" value="No" data-bind="checked: SoreThroat" />
										<label class="custom-control-label" for="SoreThroat2">ទេ</label>
									</div>
								</td>
							</tr>

							<tr>
								<td> ៤. ស្លេកស្លាំង (ស្បែកស្លេក ឬភ្នែកលឿង)? </td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="verypale1" name="VeryPale" class="custom-control-input" value="Yes" data-bind="checked: VeryPale" />
										<label class="custom-control-label" for="verypale1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="verypale2" name="VeryPale" class="custom-control-input" value="No" data-bind="checked: VeryPale" />
										<label class="custom-control-label" for="verypale2">ទេ</label>
									</div>
								</td>
							</tr>

							<tr>
								<td> ៥. អស់កម្លាំងខ្លាំង?</td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="VeryWeak1" name="VeryWeak" class="custom-control-input" value="Yes" data-bind="checked: VeryWeak" />
										<label class="custom-control-label" for="VeryWeak1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="VeryWeak2" name="VeryWeak" class="custom-control-input" value="No" data-bind="checked: VeryWeak" />
										<label class="custom-control-label" for="VeryWeak2">ទេ</label>
									</div>
								</td>
							</tr>

							<tr>
								<td> ៦. ក្អួត? </td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="SevereVomiting1" name="SevereVomiting" class="custom-control-input" value="Yes" data-bind="checked: SevereVomiting" />
										<label class="custom-control-label" for="SevereVomiting1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="SevereVomiting2" name="SevereVomiting" class="custom-control-input" value="No" data-bind="checked: SevereVomiting" />
										<label class="custom-control-label" for="SevereVomiting2">ទេ</label>
									</div>
								</td>
							</tr>

							<tr>
								<td> ៧. រោគសញ្ញាផ្សេងទៀត:</td>
								<td>
									<input disabled  type="text" class="form-control" data-bind="value: OtherSymptom" />
								</td>
							</tr>

							<tr>
								<td> ៨. តើអ្នកជម្ងឺលេបថ្នាំព្រីម៉ាគីនលើសកំរិតដែរឬទេ?</td>
								<td>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="OverPrimaquine" name="OverPrimaquine" class="custom-control-input" value="Yes" data-bind="checked: OverPrimaquine" />
										<label class="custom-control-label" for="OverPrimaquine">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input disabled  type="radio" id="OverPrimaquine2" name="OverPrimaquine" class="custom-control-input" value="No" data-bind="checked: OverPrimaquine" />
										<label class="custom-control-label" for="OverPrimaquine2">ទេ</label>
									</div>
								</td>
							</tr>

							<tr>
								<td> ៩. ការចាត់ចែងជំងឺរបស់អ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ <br /> (ត្រូវទូរស័ព្ទ ឬក៏បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាព ប្រសិនបើមានគូស "មាន"​ ក្នុងរោគសញ្ញាណាមួយខាងលើ)</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="DoNothing" name="PatientManagement" value="DoNothing" data-bind="checked: PatientManagement" />
										<label class="custom-control-label" for="DoNothing">មិនបានធ្វើអ្វី​សោះ</label>
                                    </div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="CallHC" name="PatientManagement" value="CallHC" data-bind="checked: PatientManagement" />
										<label class="custom-control-label" for="CallHC">ទូរស័ព្ទទៅមណ្ឌលសុខភាព</label>
                                    </div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="ReferToHC" name="PatientManagement" value="ReferToHC" data-bind="checked: PatientManagement" />
										<label class="custom-control-label" for="ReferToHC">បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាព</label>
                                    </div>
									<div class="custom-control custom-checkbox">
										<input disabled  type="checkbox" class="custom-control-input" id="ReferToRH" name="PatientManagement" value="ReferToRH" data-bind="checked: PatientManagement" />
										<label class="custom-control-label" for="ReferToRH">បញ្ជូនអ្នកជំងឺទៅមន្ទីរពេទ្យ</label>
                                    </div>
								</td>
							</tr>

						</tbody​​>
					</table>

				</div>
			</div>
		</div>
	</div>

</div>

<?=latestJs('/media/ViewModel/VMWFollowupData.js')?>