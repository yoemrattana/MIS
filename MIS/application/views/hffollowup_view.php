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
	.card-title {font-family: 'Khmer OS Bokor'; color: dodgerblue}

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
				<h4 class="card-title">HF Follow up</h4>
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
								<a href="/Home" class="btn btn-dark pull-right"> Home</a>
								<a href="/HFFollowupData" class="btn btn-success pull-right" style="margin-right: 5px">
									<i class="fa fa-list"></i> Data
								</a>
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
								<a param="Day3" data-bind="click: $root.showDetail, text: Day3() > 0 ? 'Detail' : $root.getFollowupDate($data,3,'day'), attr: { class: Day3() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
							</td>
							<td align="center">
                                <a class="btn btn-success btn-sm" param="Day7" data-bind="click: $root.showDetail, text: Day7() > 0 ? 'Detail' : $root.getFollowupDate($data,7,'day'), attr: { class: Day7() > 0 ? 'btn btn-sm btn-success' : 'btn btn-sm btn-danger'}"></a>
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
					<button class="btn btn-danger" data-bind="click: $root.deleteDay, visible: app.user.permiss['HF Followup Patient'].contain('Delete') && ! $root.new()">
						<i class="fa fa-trash"></i>&nbsp Delete
					</button>
					<button type="button" class="btn btn-dark" data-bind="click: $root.back">
						<i class="fa fa-angle-double-left"></i>&nbsp Back
					</button>
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
										ឈ្មោះ
									</label>
									<input disabled type="text" class="form-control" data-bind="value: NameK" />
								</div>

								<div class="form-group">
									<label class="control-label">
										ភេទ
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Sex" />
								</div>

								<div class="form-group">
									<label class="control-label">
										អាយុ
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Age" />
								</div>

								<div class="form-group">
									<label class="control-label">
										កូដអ្នកជំងឺ
									</label>
									<input disabled type="text" class="form-control" data-bind="value: PatientCode" />
								</div>

								<div class="form-group">
									<label class="control-label">
										ឈ្មោះភូមិ
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Name_Vill_K" />
								</div>

								<div class="form-group">
									<label class="control-label">
										មណ្ឌលសុខភាព
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Name_Facility_K" />
								</div>

								<div class="form-group">
									<label class="control-label">
										ស្រុកប្រតិបត្តិ
									</label>
									<input disabled type="text" class="form-control" data-bind="value: Name_OD_K" />
								</div>

							</div>
						</div>

						<h3 class="card-title">
							តាមដានអ្នកជម្ងឺ
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
										កាលបរិចឆ្ឆេទ​ (ថ្ងៃ/ខែ/ឆ្នាំ)
									</label>
									<input type="text" class="form-control" data-bind="datePicker: Date, format: 'YYYY-MM-DD', dataType: 'string'" />
									<span data-bind="validationMessage: Date" class="message-error"></span>
								</div>
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="Call" name="Call" data-bind="checked: Call" />
										<label class="custom-control-label" for="Call">តាមរយះទូរសព្ទ</label>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label">
										កូដ
									</label>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck11" name="Code" value="0"
											data-bind="checked: Code, enable: !Code().includes('1') && !Code().includes('2') && !Code().includes('3') && !Code().includes('4') && !Code().includes('5') " />
										<label class="custom-control-label" for="customCheck11">
											0 - គ្មាន
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck12" name="Code" value="1" data-bind="checked: Code, enable: !Code().includes('0')" />
										<label class="custom-control-label" for="customCheck12">
											1 - ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck13" name="Code" value="2" data-bind="checked: Code, enable: !Code().includes('0')" />
										<label class="custom-control-label" for="customCheck13">
											2 - ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដង្ហើមញាប់
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck14" name="Code" value="3" data-bind="checked: Code, enable: !Code().includes('0')" />
										<label class="custom-control-label" for="customCheck14">
											3 - ជីពចរដើរញាប់, ញ័រដើមទ្រូង, ចង្វាក់បេះដូងកើនឡើង
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck15" name="Code" value="4" data-bind="checked: Code, enable: !Code().includes('0')" />
										<label class="custom-control-label" for="customCheck15">
											4 - ចុករោយខ្នង
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck16" name="Code" value="5" data-bind="checked: Code, enable: !Code().includes('0')" />
										<label class="custom-control-label" for="customCheck16">
											5 - ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)
										</label>
									</div>
									<span data-bind="validationMessage: Code" class="message-error"></span>
								</div>

								<div class="form-group">
									<div class="custom-control custom-checkbox"> 
										<input type="checkbox" class="custom-control-input" id="Refered" name="Refered" data-bind="checked: Refered" />
										<label class="custom-control-label" for="Refered">បញ្ចូន</label>
									</div>
								</div>

								<div class="form-group" data-bind="visible: Day() == 'Day14'">
									<label class="control-label">
										ចំនួនថ្នាំនៅសល់
									</label>
									<input type="number" data-bind="value: TabletRemain" class="form-control" />
								</div>
							</div>
						</div>

						<!-- /ko -->
					</div><!--/form-body end-->
					<div class="form-actions">
						<button type="submit" class="btn btn-success" data-bind="click: $root.save, visible: app.user.permiss['HF Followup Patient'].contain('Edit')">
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
					មានការកែទិន្នន័យ - Data Changing
				</h3>
			</div>
			<div class="modal-body" style="font-size:18px">
				តើអ្នកចង់រក្សាទុកការកែទិន្នន័យនេះទេ?
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

<?=latestJs('/media/ViewModel/HFFollowup.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>