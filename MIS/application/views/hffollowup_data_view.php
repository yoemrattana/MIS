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
					<h4 class="card-title">HF Follow up Data</h4>
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
								<!--<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: vl,
											options: vlList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'All Villages'"
											class="form-control"></select>
									</div>
								</div>-->
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

								<div class="col-sm-4">
									<a href="/Home" class="btn btn-dark pull-right"><i class="fa fa-home"></i> Home</a>
									<a href="/HFFollowup" class="btn btn-success pull-right" style="margin-right: 5px"><i class="fa fa-list"></i> Form</a>
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
							<span data-bind="text: day"></span>
						</kh>
					</h5>
					<hr />

					<table style="margin: 0 auto; width: 50%" class="table  info-bordered-table table-striped box-shadow">
						<tbody data-bind="with: followup">
							<tr>
								<td>ថ្ងៃនៃការប្រើប្រាស់ថ្នាំ</td>
								<td style="color: #c0392b" data-bind="text: Day"></td>
							</tr>

							<tr>
								<td>កូដអ្នកជម្ងឺ</td>
								<td>
									<input disabled type="text" class="form-control" data-bind="value: PatientCode" />
								</td>
							</tr>

							<tr>
								<td>ថ្ងៃនៃការប្រើប្រាស់ថ្នាំ</td>
								<td>
									<input disabled type="text" class="form-control" data-bind="value: Day" />
								</td>
							</tr>

							<tr>
								<td>កាលបរិចឆ្ឆេទ​ (ថ្ងៃ/ខែ/ឆ្នាំ)</td>
								<td>
									<input disabled type="text" class="form-control" data-bind="datePicker: Date, format: 'YYYY-MM-DD', dataType: 'string'" />
								</td>
							</tr>

							<tr>
								<td>តាមរយះទូរសព្ទ</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input disabled type="checkbox" class="custom-control-input" id="Call" name="Call" data-bind="checked: Call" />
										<label class="custom-control-label" for="Call"></label>
									</div>
								</td>
							</tr>

							<tr>
								<td>កូដ</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input disabled type="checkbox" class="custom-control-input" id="customCheck11" name="Code" value="0" data-bind="checked: Code" />
										<label class="custom-control-label" for="customCheck11">
											0 - គ្មាន
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled type="checkbox" class="custom-control-input" id="customCheck12" name="Code" value="1" data-bind="checked: Code" />
										<label class="custom-control-label" for="customCheck12">
											1 - ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled type="checkbox" class="custom-control-input" id="customCheck13" name="Code" value="2" data-bind="checked: Code" />
										<label class="custom-control-label" for="customCheck13">
											2 - ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដង្ហើមញាប់
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled type="checkbox" class="custom-control-input" id="customCheck14" name="Code" value="3" data-bind="checked: Code" />
										<label class="custom-control-label" for="customCheck14">
											3 - ជីពចរដើរញាប់, ញ័រដើមទ្រូង, ចង្វាក់បេះដូងកើនឡើង
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled type="checkbox" class="custom-control-input" id="customCheck15" name="Code" value="4" data-bind="checked: Code" />
										<label class="custom-control-label" for="customCheck15">
											4 - ចុករោយខ្នង
										</label>
									</div>
									<div class="custom-control custom-checkbox">
										<input disabled type="checkbox" class="custom-control-input" id="customCheck16" name="Code" value="5" data-bind="checked: Code" />
										<label class="custom-control-label" for="customCheck16">
											5 - ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)
										</label>
									</div>
								</td>
							</tr>

							<tr>
								<td>បញ្ចូន</td>
								<td>
									<div class="custom-control custom-checkbox"> 
										<input disabled type="checkbox" class="custom-control-input" id="Refered" name="Refered" data-bind="checked: Refered" />
										<label class="custom-control-label" for="Refered"></label>
									</div>
								</td>
							</tr>

							<tr>
								<td>ចំនួនថ្នាំនៅសល់</td>
								<td>
									<input disabled type="number" data-bind="value: TabletRemain" class="form-control" />
								</td>
							</tr>
						</tbody​​>
					</table>

				</div>
			</div>
		</div>
	</div>

</div>

<?=latestJs('/media/ViewModel/HFFollowupData.js')?>