<style>
	.table td, .table th {
		padding: 6px !important;
	}
	.btn-circle {
		border-radius: 100%;
		width: 25px;
		height: 25px;
		padding: 2px;
	}
	table thead tr th {
		font-family: 'Khmer OS Battambang';
		font-weight: 700;
	}
	.float-left {
		float:left;
	}

	body{
		font-family: 'Koh-Santepheap-Body', 'Open Sans','Battambang', sans-serif, cursive;
	}
</style>

<div class="row" data-bind="visible: $root.view() == 'list'" style="display:none">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">G6PD Investigation</h4>
				<form>
					<div class="container9">
						<div class="row">
							<div class="col-sm-1">
								<div class="form-group">
									<select data-bind="value: year, options: yearList" class="form-control input-sm width70"></select>
								</div>
							</div>

							<div class="col-sm-1">
								<div class="form-group">
									<select data-bind="value: month, options: monthList, optionsValue: 'id', optionsText: 'name', optionsCaption: 'Select Month'" class="form-control input-sm width70"></select>
								</div>
							</div>

							<div class="col-sm-2">
								<div class="form-group">
									<select data-bind="options: odList,
									optionsValue: 'code',
									optionsText: 'name',
									optionsCaption: isSingle(odList()) ? undefined : 'Select OD',
									value: od"
										class="form-control input-sm minwidth150"></select>
								</div>
							</div>

							<div class="col-sm-2">
								<div class="form-group">
									<select data-bind="options: hcList,
									optionsValue: 'code',
									optionsText: 'name',
									optionsCaption: isSingle(hcList()) ? undefined : 'Select HC',
									value: hc"
										class="form-control input-sm minwidth150"></select>
								</div>
							</div>
							<div class="col-sm-6">
								<a href="/Home" class="btn btn-dark pull-right"> Home</a>
							</div>
						</div>
						
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<!--list-->
<div class="row" data-bind="visible: $root.view() == 'list'" style="display:none">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="tablesaw-bar tablesaw-mode-stack"></div>
				<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-stack" data-tablesaw-mode="stack" id="tablesaw-605">
					<thead>
						<tr>
							<th scope="col" data-tablesaw-priority="persist" width="2">#</th>
							<th scope="col" data-tablesaw-sortable-default-col="" data-tablesaw-priority="3">កូដអ្នកជំងឺ</th>
							<th scope="col" data-tablesaw-priority="3">ឈ្មោះ</th>
							<th scope="col" data-tablesaw-priority="2">ប្រភេទមេរោគ</th>
							<th scope="col" data-tablesaw-priority="5">កាលបរិច្ឆេត</th>
							<th scope="col" data-tablesaw-priority="6">លទ្ធផល G6PD (U/g Hb)</th>
							<th scope="col" data-tablesaw-priority="7">លទ្ធផល G6PD (g/dL)</th>
							<th scope="col" data-tablesaw-priority="8">Action</th>
						</tr>
					</thead>
					<tbody>
						<!--ko foreach: reportList-->
						<tr>
							<td>
								<b class="tablesaw-cell-label">#</b> 
								<span class="tablesaw-cell-content" data-bind="text: $index() + 1"></span>
							</td>
							<td>
								<b class="tablesaw-cell-label">កូដអ្នកជំងឺ</b> 
								<span class="tablesaw-cell-content" data-bind="text: PatientCodeText"></span>
							</td>
							<td>
								<b class="tablesaw-cell-label">ឈ្មោះ</b> 
								<span class="tablesaw-cell-content" data-bind="text: NameText"></span>
							</td>
							<td>
								<b class="tablesaw-cell-label">ប្រភេទមេរោគ</b> 
								<span class="tablesaw-cell-content" data-bind="text: DiagnosisText"></span>
							</td>
							<td>
								<b class="tablesaw-cell-label">កាលបរិច្ឆេត</b> 
								<span class="tablesaw-cell-content" data-bind="text: $root.dateFormat(DateCaseText)"></span>
							</td>
							<td>
								<b class="tablesaw-cell-label">G6PD (U/g Hb)</b> 
								<span class="tablesaw-cell-content" data-bind="text: G6PDHb"></span>
							</td>
							<td>
								<b class="tablesaw-cell-label">G6PD (g/dL)</b> 
								<span class="tablesaw-cell-content" data-bind="text: G6PDdL"></span>
							</td>
							<td>
								<b class="tablesaw-cell-label">Action</b>
								<span class="tablesaw-cell-content">
									<button type="button" class="btn btn-success btn-circle" data-bind="click: $root.edit">
										<i class="fa fa-edit"></i>
									</button>
									<button type="button" class="btn btn-danger btn-circle" data-bind="click: $root.delete">
										<i class="fa fa-trash"></i>
									</button>
								</span>
							</td>
						</tr>
						<!-- /ko -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- form -->
<div class="row" data-bind="visible: $root.view() == 'detail'" style="display:none">
    <div class="col-lg-12">
        <div class="card" style="width: 500px; margin: 0 auto">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white float-left">G6PD Investigation</h4>
				<div class="card-actions">
					<button type="button" class="btn btn-dark" data-bind="click: $root.back"><i class="fa fa-angle-double-left"></i>&nbsp Back</button>
				</div>
            </div>
            <div class="card-body">
                <form action="#">
                    <div style="width: 480px" class="container form-body" data-bind="with: detail">
                        <h3 class="card-title"><kh>ទិន្នន័យអ្នកជំងឺ</kh></h3>
                        <hr>
						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label"><kh>កូដអ្នកជំងឺ</kh></label>
									<input disabled type="text" class="form-control" data-bind="value: PatientCodeText"/>
								</div>
								
								<div class="form-group">
                                    <label class="control-label"><kh>ទីតាំងធ្វើរោគវិនិច្ឆ័យដំបូង</kh></label>
                                    <select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: DiagnosedBy">
										<option value="">Select</option>
                                        <option value="HC">HC</option>
                                        <option value="VMW">VMW</option>
                                    </select>
                                </div>

								<div class="form-group">
                                    <label class="control-label"><kh>ប្រភេទមេរោគ</kh></label>
                                    <input disabled type="text" class="form-control" data-bind="value: DiagnosisText"/>
                                </div>

								<div class="form-group">
									<label class="control-label"><kh>កាលបរិច្ឆេទ</kh></label>
									<input disabled type="text" class="form-control" data-bind="value: $root.dateFormat(DateCaseText)"/>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>ឈ្មោះ</kh></label>
									<input disabled type="text" class="form-control" data-bind="value: NameText"/>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>ភេទ</kh></label>
									<input disabled type="text" class="form-control" data-bind="value: SexText"/>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>អាយុ</kh></label>
									<input disabled type="text" class="form-control" data-bind="value: AgeText"/>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>ទម្ងន់</kh></label>
									<input type="text" class="form-control" data-bind="value: WeightText"/>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>ឈ្មោះភូមិ</kh></label>
									<input disabled type="text" class="form-control" data-bind="value: Name_Vill_K"/>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>លេខទូរសព្ទ</kh></label>
									<input type="text" class="form-control" data-bind="value: Phone"/>
								</div>

							</div>
						</div>

						<h3 class="card-title"><kh>លទ្ធផល G6PD</kh></h3>
                        <hr>

						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label"><kh>លទ្ធផលG6PD (U/g Hb)</kh></label>
									<input type="number" class="form-control" data-bind="value: G6PDHb"/>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>លទ្ធផល Hb (g/dL)</kh></label>
									<input type="number" class="form-control" data-bind="value: G6PDdL"/>
								</div>
							</div>
						</div>

						<h3 class="card-title"><kh>ការព្យបាលនិងប្រឹក្សា</kh></h3>
						<hr>

						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label"><kh>ប្រឹក្សា</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: Consult">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>ACT</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: ACT">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>ការព្យាបាលដោយPrimaquine</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: Primaquine">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>
								<div class="form-group">
									<label class="control-label">#<kh>គ្រាប់15ម.ក្រ</kh></label>
									<input type="number" class="form-control" data-bind="value: Primaquine15"/>
								</div>
								<div class="form-group">
									<label class="control-label">#<kh>គ្រាប់7,5ម.ក្រ</kh></label>
									<input type="number" class="form-control" data-bind="value: Primaquine75"/>
								</div>
							</div>
						</div>

						<h3 class="card-title"><kh>រោគសញ្ញា និងការតាមដាន</kh></h3>
						<hr>

						<div class="row p-t-20">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label"><kh>តាមដានដោយ</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: FollowUpBy">
										<option value="">Select</option>
                                        <option value="HC">HC</option>
                                        <option value="VMW">VMW</option>
                                    </select>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>ថ្ងៃទី១</kh></label>
								
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck11" name="Day1Code" value="0" data-bind="checked: Day1Code">
                                        <label class="custom-control-label" for="customCheck11"> <kh>0 - គ្មាន</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck12" name="Day1Code" value="1" data-bind="checked: Day1Code">
                                        <label class="custom-control-label" for="customCheck12"> <kh>1 - ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck13" name="Day1Code" value="2" data-bind="checked: Day1Code">
                                        <label class="custom-control-label" for="customCheck13"> <kh>2 - ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដង្ហើមញាប់</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck14" name="Day1Code" value="3" data-bind="checked: Day1Code">
                                        <label class="custom-control-label" for="customCheck14"> <kh>3 - ជីពចរដើរញាប់, ញ័រដើមទ្រូង, ចង្វាក់បេះដូងកើនឡើង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck15" name="Day1Code" value="4" data-bind="checked: Day1Code">
                                        <label class="custom-control-label" for="customCheck15"> <kh>4 - ចុករោយខ្នង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck16" name="Day1Code" value="5" data-bind="checked: Day1Code">
                                        <label class="custom-control-label" for="customCheck16"> <kh>5 - ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)</kh></label>
                                    </div>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>ទូរសព្ទថ្ងៃទី៣</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: Day3Call">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>ថ្ងៃទី៣</kh></label>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck21" name="Day3Code" value="0" data-bind="checked: Day3Code">
                                        <label class="custom-control-label" for="customCheck21"> <kh>0 - គ្មាន</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck22" name="Day3Code" value="1" data-bind="checked: Day3Code">
                                        <label class="custom-control-label" for="customCheck22"> <kh>1 - ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck23" name="Day3Code" value="2" data-bind="checked: Day3Code">
                                        <label class="custom-control-label" for="customCheck23"> <kh>2 - ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដង្ហើមញាប់</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck24" name="Day3Code" value="3" data-bind="checked: Day3Code">
                                        <label class="custom-control-label" for="customCheck24"> <kh>3 - ជីពចរដើរញាប់, ញ័រដើមទ្រូង, ចង្វាក់បេះដូងកើនឡើង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck25" name="Day3Code" value="4" data-bind="checked: Day3Code">
                                        <label class="custom-control-label" for="customCheck25"> <kh>4 - ចុករោយខ្នង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck26" name="Day3Code" value="5" data-bind="checked: Day3Code">
                                        <label class="custom-control-label" for="customCheck26"> <kh>5 - ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)</kh></label>
                                    </div>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>បញ្ជូន</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: Day3Refered">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>ទូរសព្ទថ្ងៃទី៧</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: Day7Call">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>ថ្ងៃទី៧</kh></label>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck31" name="Day7Code" value="0" data-bind="checked: Day7Code">
                                        <label class="custom-control-label" for="customCheck31"> <kh>0 - គ្មាន</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck32" name="Day7Code" value="1" data-bind="checked: Day7Code">
                                        <label class="custom-control-label" for="customCheck32"> <kh>1 - ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck33" name="Day7Code" value="2" data-bind="checked: Day7Code">
                                        <label class="custom-control-label" for="customCheck33"> <kh>2 - ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដង្ហើមញាប់</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck34" name="Day7Code" value="3" data-bind="checked: Day7Code">
                                        <label class="custom-control-label" for="customCheck34"> <kh>3 - ជីពចរដើរញាប់, ញ័រដើមទ្រូង, ចង្វាក់បេះដូងកើនឡើង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck35" name="Day7Code" value="4" data-bind="checked: Day7Code">
                                        <label class="custom-control-label" for="customCheck35"> <kh>4 - ចុករោយខ្នង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck36" name="Day7Code" value="5" data-bind="checked: Day7Code">
                                        <label class="custom-control-label" for="customCheck36"> <kh>5 - ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)</kh></label>
                                    </div>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>បញ្ជូន</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: Day7Refered">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>

								<div class="form-group">
									<label class="control-label"><kh>ទូរសព្ទថ្ងៃទី១៤</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: Day14Call">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>ថ្ងៃទី១៤</kh></label>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck41" name="Day14Code" value="0" data-bind="checked: Day14Code">
                                        <label class="custom-control-label" for="customCheck41"> <kh>0 - គ្មាន</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck42" name="Day14Code" value="1" data-bind="checked: Day14Code">
                                        <label class="custom-control-label" for="customCheck42"> <kh>1 - ស្លេកស្លាំង - ស្បែកភ្នែកពណ័លឿង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck43" name="Day14Code" value="2" data-bind="checked: Day14Code">
                                        <label class="custom-control-label" for="customCheck43"> <kh>2 - ហត់ដង្ហក់ពេលដើរ ឬធ្វើសកម្មភាព, ដង្ហើមញាប់</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck44" name="Day14Code" value="3" data-bind="checked: Day14Code">
                                        <label class="custom-control-label" for="customCheck44"> <kh>3 - ជីពចរដើរញាប់, ញ័រដើមទ្រូង, ចង្វាក់បេះដូងកើនឡើង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck45" name="Day14Code" value="4" data-bind="checked: Day14Code">
                                        <label class="custom-control-label" for="customCheck45"> <kh>4 - ចុករោយខ្នង</kh></label>
                                    </div>
									<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck46" name="Day14Code" value="5" data-bind="checked: Day14Code">
                                        <label class="custom-control-label" for="customCheck46"> <kh>5 - ពណ៏ទឹកនោមឡើងក្រម៉ៅ (ពិន្ទុ៥ឬលើសពីនេះ)</kh></label>
                                    </div>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>ចំនួនគ្រាប់ថ្នាំនៅសល់</kh></label>
									<input type="number" class="form-control" data-bind="value: Day14Tablet"/>
								</div>
								<div class="form-group">
									<label class="control-label"><kh>បញ្ជូន</kh></label>
									<select class="form-control custom-select" data-placeholder="Select" tabindex="1" data-bind="value: Day14Refered">
										<option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
								</div>
							</div>
						</div>
						
                    </div><!--/form-body end-->

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" data-bind="click: $root.update"> <i class="fa fa-check"></i> Save</button>
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
				<button data-bind="click: $root.notSave" class="btn btn-danger btn-sm" data-dismiss="modal" style="width:100px">Don't Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>
<?=latestJs('/media/ViewModel/G6PDinvestigation.js')?>
<?=latestCss('/media/assetsV3/plugins/tablesaw/tablesaw.css')?>
<?=latestJs('/media/assetsV3/plugins/tablesaw/tablesaw.jquery.js')?>
<?=latestJs('/media/assetsV3/plugins/tablesaw/tablesaw-init.js')?>