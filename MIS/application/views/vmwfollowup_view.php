<style>

    body {
        background-color: #f3f1f196;
        font-family: 'Koh-Santepheap-Body', 'Open Sans','Battambang', sans-serif, cursive;
    }

    .card {
        box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
        border: 2px solid #01c0c8;
        background: #fff;
    }
    .card-title {
        font-family: 'Khmer OS Bokor';
        color: dodgerblue;
    }
    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }
</style>

<div class="row" data-bind="visible: $root.view() == 'list'" style="display:none">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Follow up</h4>
				<form>
					<div class="container9">
						<div class="row">
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
							<div class="col-sm-6">
								<a href="/Home" class="btn btn-dark pull-right"><i class="fa fa-home"></i> Home</a>
								<a href="/VMWFollowupData" class="btn btn-success pull-right" style="margin-right: 5px"><i class="fa fa-list"></i> Data</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- List -->
<div class="row" data-bind="visible: $root.view() == 'list'" style="display:none">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered table-striped table-hover">
					<thead class="bg-info">
						<tr>
							<th width="40" align="center">#</th>
							<th align="center">Patient Code</th>
							<th align="center">Patient</th>
							<th align="center">Date case</th>
							<th align="center">Diagnosis</th>
							<th align="center">OD</th>
							<th align="center">HC</th>
							<th align="center">Village</th>
							<th align="center">Day3</th>
							<th align="center">Day7</th>
                            <th align="center">W 2</th>
                            <th align="center">W 3</th>
                            <th align="center">W 4</th>
                            <th align="center">W 5</th>
                            <th align="center">W 6</th>
                            <th align="center">W 7</th>
                            <th align="center">W 8</th>
							<th align="center">Radical Cure HC</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: listModel, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1" class="text-center"></td>
							<td data-bind="text: PatientCode" class="kh"></td>
							<td data-bind="text: NameK" align="center"></td>
							<td data-bind="text: moment(DateCase).format('DD-MM-YYYY')" align="center"></td>
							<td data-bind="text: Diagnosis" align="center"></td>
							<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>
							<td data-bind="text: $root.getHCName(Code_Facility_T)" class="kh"></td>
							<td data-bind="text: $root.getVLName(Code_Vill_T)" class="kh"></td>
							<td align="center">
								<a class="btn btn-primary btn-sm" param="Day3" data-bind="click: $root.showDetail, text: Day3() > 0 ? 'Detail' : $root.getFollowupDate($data,3), attr: { class: Day3() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
							</td>
							<td align="center">
								<a class="btn btn-primary btn-sm" param="Day7" data-bind="click: $root.showDetail, text: Day7() > 0 ? 'Detail' : $root.getFollowupDate($data,7), attr: { class: Day7() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
							</td>
                            <td align="center">
                                <a class="btn btn-success btn-sm" param="W2" data-bind="click: $root.showDetail, text: W2() > 0 ? 'Detail' : $root.getFollowupDate($data,2,'week'), attr: { class: W2() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
                            </td>
                            <td align="center">
                                <a class="btn btn-success btn-sm" param="W3" data-bind="click: $root.showDetail, text: W3() > 0 ? 'Detail' : $root.getFollowupDate($data,3,'week'), attr: { class: W3() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
                            </td>
                            <td align="center">
                                <a class="btn btn-success btn-sm" param="W4" data-bind="click: $root.showDetail, text: W4() > 0 ? 'Detail' : $root.getFollowupDate($data,4,'week'), attr: { class: W4() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
                            </td>
                            <td align="center">
                                <a class="btn btn-success btn-sm" param="W5" data-bind="click: $root.showDetail, text: W5() > 0 ? 'Detail' : $root.getFollowupDate($data,5,'week'), attr: { class: W5() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
                            </td>
                            <td align="center">
                                <a class="btn btn-success btn-sm" param="W6" data-bind="click: $root.showDetail, text: W6() > 0 ? 'Detail' : $root.getFollowupDate($data,6,'week'), attr: { class: W6() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
                            </td>
                            <td align="center">
                                <a class="btn btn-success btn-sm" param="W7" data-bind="click: $root.showDetail, text: W7() > 0 ? 'Detail' : $root.getFollowupDate($data,7,'week'), attr: { class: W7() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
                            </td>
                            <td align="center">
                                <a class="btn btn-success btn-sm" param="W8" data-bind="click: $root.showDetail, text: W8() > 0 ? 'Detail' : $root.getFollowupDate($data,8,'week'), attr: { class: W8() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
                            </td>
							<td align="center" data-bind="text: IsReminder == 1 ? 'Yes' : 'No'"></td>
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
<!--Form-->
<div class="row" data-bind="visible: $root.view() == 'detail'" style="display:none">
    <div class="col-lg-12">
        <div class="card" style="width: 500px; margin: 0 auto">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white float-left">Patient Follow up</h4>
				<div class="card-actions">
					<button class="btn btn-danger" data-bind="click: $root.deleteDay, visible: app.user.permiss['VMW Followup Patient'].contain('Delete') && ! $root.new()">
						<i class="fa fa-trash"></i>&nbsp Delete
					</button>
					<button type="button" class="btn btn-dark" data-bind="click: $root.back"><i class="fa fa-angle-double-left"></i>&nbsp Back</button>
				</div>
            </div>
            <div class="card-body">
                <form action="#">
					<div style="width: 480px" class="container form-body">
						<h3 class="card-title">
							ព័ត៌មានអ្នកជំងឺ
						</h3>
						<hr />
						<div class="row p-t-20">
							<div class="col-md-12" data-bind="with: patient">
								<div class="form-group">
									<label class="control-label">
										<kh>ឈ្មោះ</kh>
									</label>
									<input disabled type="text" class="form-control" data-bind="value: NameK" />
								</div>

								<div class="form-group">
									<label class="control-label">
										<kh>ភេទ</kh>
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Sex" />
								</div>

								<div class="form-group">
									<label class="control-label">
										<kh>អាយុ</kh>
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Age" />
								</div>

								<div class="form-group">
									<label class="control-label">
										<kh>កូដអ្នកជំងឺ</kh>
									</label>
									<input disabled type="text" class="form-control" data-bind="value: PatientCode" />
								</div>

								<div class="form-group">
									<label class="control-label">
										<kh>ឈ្មោះភូមិ</kh>
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Name_Vill_K" />
								</div>

								<div class="form-group">
									<label class="control-label"><kh>មណ្ឌុលសុខភាព</kh></label>
									<input disabled type="text" class="form-control" data-bind="value: Name_Facility_K"/>
								</div>

								<div class="form-group">
									<label class="control-label">
										<kh>ស្រុកប្រតិបត្តិ</kh>
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Name_OD_K" />
								</div>

							</div>
						</div>

						<h3 class="card-title">
							ផ្នែកទី១
						</h3>
						<hr />

						<!-- ko with: detailModel -->

						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										កូដអ្នកជម្ងឺ
									</label>
									<input type="text" class="form-control" data-bind="value: PatientCode" />
									<span data-bind="validationMessage: PatientCode" class="message-error"></span>
								</div>
								<div class="form-group">
									<label class="control-label">
										ថ្ងៃនៃការប្រើប្រាស់ថ្នាំ
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Day" />
								</div>
								<div class="form-group">
									<label class="control-label">
										១. កាលបរិចឆ្ឆេទ​ (ថ្ងៃ/ខែ/ឆ្នាំ)
									</label>
									<input type="text" class="form-control" data-bind="datePicker: Date, format: 'YYYY-MM-DD', dataType: 'string'" />
									<span data-bind="validationMessage: Date" class="message-error"></span>
								</div>
								<div class="form-group">
									<label class="control-label">
										២. វិធីសាស្រ្តតាមដានៈ
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="method1" name="Method" class="custom-control-input" value="Direct" data-bind="checked: Method" />
										<label class="custom-control-label" for="method1">ជួបអ្នកជំងឺផ្ទាល់</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="method2" name="Method" class="custom-control-input" value="Phone" data-bind="checked: Method" />
										<label class="custom-control-label" for="method2">សាកសួរតាមទូរស័ព្ទ</label>
									</div>
									<span data-bind="validationMessage: Method" class="message-error"></span>
								</div>
								<div class="form-group">
									<label class="control-label">
										៣. ពិនិត្យមើលស្ថានភាពអ្នកជំងឺ:
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="feeling1" name="Feeling" class="custom-control-input" value="Better" data-bind="checked: Feeling" />
										<label class="custom-control-label" for="feeling1">ធូរស្រាល</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="feeling2" name="Feeling" class="custom-control-input" value="Same" data-bind="checked: Feeling" />
										<label class="custom-control-label" for="feeling2">នៅដដែល</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="feeling3" name="Feeling" class="custom-control-input" value="Worse" data-bind="checked: Feeling" />
										<label class="custom-control-label" for="feeling3">កាន់តែធ្ងន់ធ្ងរ</label>
									</div>
									<span data-bind="validationMessage: Feeling" class="message-error"></span>
								</div>
							</div>
						</div>

						<h3 class="card-title">
							ផ្នែកទី២
						</h3>
						<hr />

						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group" data-bind="if: Day() == 'Day3'">
									<label class="control-label">
										១. តើអ្នកជំងឺបានបញ្ចប់ការលេបថ្នាំASMQ ហើយឬនៅ?
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="asmq1" name="ASMQ" class="custom-control-input" value="Yes" data-bind="checked: ASMQ" />
										<label class="custom-control-label" for="asmq1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="asmq2" name="ASMQ" class="custom-control-input" value="No" data-bind="checked: ASMQ" />
										<label class="custom-control-label" for="asmq2">ទេ</label>
									</div>
									<span data-bind="validationMessage: ASMQ" class="message-error"></span>
								</div>

								<div class="form-group">
									<label class="control-label">
										២. តើអ្នកជំងឺបានលេបថ្នាំព្រីម៉ាគីនរៀងរាល់ថ្ងៃទេ?
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="primaquine1" name="Primaquine" class="custom-control-input" value="Yes" data-bind="checked: Primaquine" />
										<label class="custom-control-label" for="primaquine1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="primaquine2" name="Primaquine" class="custom-control-input" value="No" data-bind="checked: Primaquine" />
										<label class="custom-control-label" for="primaquine2">ទេ</label>
									</div>
									<span data-bind="validationMessage: Primaquine" class="message-error"></span>
								</div>

								<div data-bind="if: Primaquine() == 'No'" class="form-group">
									<label class="control-label">
										៣. បើសិន "ទេ" តើហេតុអ្វី? (អាចគូសចំលើយលើស​ពីមួយ):
									</label>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="Forget" name="NoPrimaquineReason" value="Forget" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="Forget">ភ្លេច</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="NotSick" name="NoPrimaquineReason" value="NotSick" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="NotSick">មិនមានអារម្មណ៏ឈឺ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="SideEffect" name="NoPrimaquineReason" value="SideEffect" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="SideEffect">ទទួលផលប៉ះពាល់ពីការប្រើប្រាស់ថ្នាំ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="Travel" name="NoPrimaquineReason" value="Travel" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="Travel">ធ្វើដំណើរ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="LostMedicine" name="NoPrimaquineReason" value="LostMedicine" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="LostMedicine">បាត់ថ្នាំ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="NotTrust" name="NoPrimaquineReason" value="NotTrust" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="NotTrust">មិនទុកចិត្តលើថ្នាំ</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="NotNotedOtherReason" name="NoPrimaquineReason" value="NotNotedOtherReason" data-bind="checked: NoPrimaquineReason" />
										<label class="custom-control-label" for="NotNotedOtherReason">ហេតុផលផ្សេងទៀត (សូមបញ្ជាក់):</label>
									</div>
									<!-- ko if: NoPrimaquineReason().includes('NotNotedOtherReason') -->
									<input type="text" class="form-control" data-bind="value: NoPrimaquineOtherReason" />
									<span data-bind="validationMessage: NoPrimaquineOtherReason" class="message-error"></span>
									<!-- /ko -->
									<span data-bind="validationMessage: NoPrimaquineReason" class="message-error"></span>
								</div>

								<div class="form-group">
									<label class="control-label">
										៤. ពិនិត្យមើលប័ណ្ណអ្នកជំងឺ។ តើអ្នកជំងឺបានកត់ត្រាលើប័ណ្ណបានត្រឹមត្រូវដែរឬទេ?
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="note1" name="CardNoted" class="custom-control-input" value="Yes" data-bind="checked: CardNoted" />
										<label class="custom-control-label" for="note1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="note2" name="CardNoted" class="custom-control-input" value="No" data-bind="checked: CardNoted" />
										<label class="custom-control-label" for="note2">ទេ</label>
										<span data-bind="validationMessage: CardNoted" class="message-error"></span>
									</div>
									
									<div style="margin-left: 47px" data-bind="visible: CardNoted() == 'No'">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="IncompleteDate" name="NotNotedReason" value="IncompleteDate" data-bind="checked: NotNotedReason" />
											<label class="custom-control-label" for="IncompleteDate">មិនបានបំពេញកាលបរិឆ្ឆេទ</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="NotTick" name="NotNotedReason" value="NotTick" data-bind="checked: NotNotedReason" />
											<label class="custom-control-label" for="NotTick">មិនបានគូសធីកក្រោយលេបថ្នាំរួច</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="AdvancedCompleted" name="NotNotedReason" value="AdvancedCompleted" data-bind="checked: NotNotedReason" />
											<label class="custom-control-label" for="AdvancedCompleted">បំពេញទុកជាមុនមុនពេលលេបថ្នាំ</label>
										</div>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="NoteNotFound" name="NotNotedReason" value="NoteNotFound" data-bind="checked: NotNotedReason" />
											<label class="custom-control-label" for="NoteNotFound">រកប័ណ្ណមិនឃើញ</label>
										</div>
										<span data-bind="validationMessage: NotNotedReason" class="message-error"></span>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label">
										៥.​ តើនៅសល់ប៉ុន្មានថ្ងៃទៀតអ្នកជំងឺនឹងបញ្ចប់ ការលេប​ថ្នាំព្រីម៉ាគីន?
									</label>
									<input type="number" class="form-control" data-bind="value: PrimaquineRemain" />
									<span data-bind="validationMessage: PrimaquineRemain" class="message-error"></span>
								</div>

							</div>
						</div>

					<h3 class="card-title">
						ផ្នែកទី៣
					</h3>
					<hr />

						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										១. គ្រុនក្តៅធ្ងន់ធ្ងរ
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="SevereFever" name="SevereFever" class="custom-control-input" value="Yes" data-bind="checked: SevereFever" />
										<label class="custom-control-label" for="SevereFever">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="SevereFever2" name="SevereFever" class="custom-control-input" value="No" data-bind="checked: SevereFever" />
										<label class="custom-control-label" for="SevereFever2">ទេ</label>
									</div>
									<span data-bind="validationMessage: SevereFever" class="message-error"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										២. រងាញាក់ខ្លាំង
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="VeryChills" name="VeryChills" class="custom-control-input" value="Yes" data-bind="checked: VeryChills" />
										<label class="custom-control-label" for="VeryChills">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="VeryChills2" name="VeryChills" class="custom-control-input" value="No" data-bind="checked: VeryChills" />
										<label class="custom-control-label" for="VeryChills2">ទេ</label>
									</div>
									<span data-bind="validationMessage: VeryChills" class="message-error"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										៣. ឈឺកំពង់ករាំរ៉ៃ
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="SoreThroat" name="SoreThroat" class="custom-control-input" value="Yes" data-bind="checked: SoreThroat" />
										<label class="custom-control-label" for="SoreThroat">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="SoreThroat2" name="SoreThroat" class="custom-control-input" value="No" data-bind="checked: SoreThroat" />
										<label class="custom-control-label" for="SoreThroat2">ទេ</label>
									</div>
									<span data-bind="validationMessage: SoreThroat" class="message-error"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										៤. ស្លេកស្លាំង (ស្បែកស្លេក ឬភ្នែកលឿង)? 
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="verypale1" name="VeryPale" class="custom-control-input" value="Yes" data-bind="checked: VeryPale" />
										<label class="custom-control-label" for="verypale1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="verypale2" name="VeryPale" class="custom-control-input" value="No" data-bind="checked: VeryPale" />
										<label class="custom-control-label" for="verypale2">ទេ</label>
									</div>
									<span data-bind="validationMessage: VeryPale" class="message-error"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										៥. អស់កម្លាំងខ្លាំង? 
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="VeryWeak1" name="VeryWeak" class="custom-control-input" value="Yes" data-bind="checked: VeryWeak" />
										<label class="custom-control-label" for="VeryWeak1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="VeryWeak2" name="VeryWeak" class="custom-control-input" value="No" data-bind="checked: VeryWeak" />
										<label class="custom-control-label" for="VeryWeak2">ទេ</label>
									</div>
									<span data-bind="validationMessage: VeryWeak" class="message-error"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										៦. ក្អួត? 
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="SevereVomiting1" name="SevereVomiting" class="custom-control-input" value="Yes" data-bind="checked: SevereVomiting" />
										<label class="custom-control-label" for="SevereVomiting1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="SevereVomiting2" name="SevereVomiting" class="custom-control-input" value="No" data-bind="checked: SevereVomiting" />
										<label class="custom-control-label" for="SevereVomiting2">ទេ</label>
									</div>
									<span data-bind="validationMessage: SevereVomiting" class="message-error"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										៧. រោគសញ្ញាផ្សេងទៀត:
									</label>

									<div class="custom-control custom-radio">
										<input type="radio" id="OtherSymptom1" name="OtherSymptom" class="custom-control-input" value="Yes" data-bind="checked: OtherSymptom" />
										<label class="custom-control-label" for="OtherSymptom1">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="OtherSymptom2" name="OtherSymptom" class="custom-control-input" value="No" data-bind="checked: OtherSymptom" />
										<label class="custom-control-label" for="OtherSymptom2">ទេ</label>
									</div>
									<span data-bind="validationMessage: OtherSymptom" class="message-error"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										៨. តើអ្នកជម្ងឺលេបថ្នាំព្រីម៉ាគីនលើសកំរិតដែរឬទេ?
									</label>
									<div class="custom-control custom-radio">
										<input type="radio" id="OverPrimaquine" name="OverPrimaquine" class="custom-control-input" value="Yes" data-bind="checked: OverPrimaquine" />
										<label class="custom-control-label" for="OverPrimaquine">បាទ/ចាស៎</label>
									</div>
									<div class="custom-control custom-radio">
										<input type="radio" id="OverPrimaquine2" name="OverPrimaquine" class="custom-control-input" value="No" data-bind="checked: OverPrimaquine" />
										<label class="custom-control-label" for="OverPrimaquine2">ទេ</label>
									</div>
									<span data-bind="validationMessage: OverPrimaquine" class="message-error"></span>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">
										៩. ការចាត់ចែងជំងឺរបស់អ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ (ត្រូវទូរស័ព្ទ ឬក៏បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាព ប្រសិនបើមានគូស "មាន"​ ក្នុងរោគសញ្ញាណាមួយខាងលើ)
									</label>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="DoNothing" name="PatientManagement" value="DoNothing" data-bind="checked: PatientManagement" />
										<label class="custom-control-label" for="DoNothing">មិនបានធ្វើអ្វី​សោះ</label>
                                    </div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="CallHC" name="PatientManagement" value="CallHC" data-bind="checked: PatientManagement" />
										<label class="custom-control-label" for="CallHC">ទូរស័ព្ទទៅមណ្ឌលសុខភាព</label>
                                    </div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="ReferToHC" name="PatientManagement" value="ReferToHC" data-bind="checked: PatientManagement" />
										<label class="custom-control-label" for="ReferToHC">បញ្ជូនអ្នកជំងឺទៅមណ្ឌលសុខភាព</label>
                                    </div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="ReferToRH" name="PatientManagement" value="ReferToRH" data-bind="checked: PatientManagement" />
										<label class="custom-control-label" for="ReferToRH">បញ្ជូនអ្នកជំងឺទៅមន្ទីរពេទ្យ</label>
                                    </div>
									<span data-bind="validationMessage: PatientManagement" class="message-error"></span>
								</div>
							</div>
						</div>
					
						<!-- /ko -->
					</div><!--/form-body end-->
                    <div class="form-actions">
						<button type="submit" class="btn btn-success" data-bind="click: $root.save, visible: app.user.permiss['VMW Followup Patient'].contain('Edit')">
							<i class="fa fa-check"></i> Save
						</button>
                        <button type="button" class="btn btn-inverse" data-bind="click: $root.back">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Save Change -->
<div class="modal" id="modalSave" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">
					<kh>មានការកែទិន្នន័យ</kh> - Data Changing
				</h3>
			</div>
			<div class="modal-body" style="font-size:18px">
				<kh>តើអ្នកចង់រក្សាទុកការកែទិន្នន័យនេះទេ?</kh>
				<br />
				<br />
				Do you want to save changes?
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-dismiss="modal" style="width:100px">Save</button>
				<button class="btn btn-danger btn-sm" data-dismiss="modal" style="width:100px">Don't Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<input type="file" id="file" class="hide" data-bind="change: () => fileChanged($element.files)" accept="image/*" />

<?=latestJs('/media/ViewModel/VMWFollowup.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>