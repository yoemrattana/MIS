<style>
	.table > thead { background-color: #9AD8ED; }
	#tblreport a { display: block; }
	#tblcase { min-width: 1700px; }
	#tblcase thead td { text-align: center; }
	#tblcase tbody td { font-size: 12px; text-align:center; vertical-align: middle; padding: 0px 2px; height:30px; }
	#tblcase tbody td .btn-sm { font-size: 12px; line-height:15px; border-radius:2px; }
	#tblcase tbody input[type="text"] { width: 100%; padding: 0; }
	#tblcase tbody select { width: 100%; padding: 1px 1px 2px 1px; }
	.popover { z-index: 1040; display: block; background-color: #ffff99; }
	.popover-content { padding: 8px; }
	.popover-content .form-group { margin-bottom: 5px; }
	.popover-content select { width: 155px !important; font-size: 12px; }
	.popover.bottom .arrow:after { border-bottom-color: #ffff99; }
	.btn-group > .btn + .dropdown-toggle { padding-left: 6px; padding-right: 6px; }
	.dropdown-menu > li > a { padding: 4px 12px; }
	.dropdown-menu > li > a:hover { background-color: #ffff99; }
	.total { display:table; margin:auto; margin-top:20px; margin-bottom:20px; padding:10px 20px; border:1px solid #ccc; background-color: #f5f5f5; }
	.total p { width: 350px; }
	.total .form-control { width: 70px; text-align: center; }
	.total .form-group { margin-bottom: 5px; }
	.checkbox-inline input { width: 20px; height: 20px; }
</style>

<div class="panel panel-default" data-bind="visible: isListView" style="display:none">
	<div class="panel-heading clearfix relative">
		<div class="pull-center form-inline">
			<div class="input-group input-group-sm width150">
				<span class="input-group-btn">
					<button data-bind="click: previousYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-left"></i>
					</button>
				</span>
				<input data-bind="value: year" type="text" class="form-control text-center" readonly />
				<span class="input-group-btn">
					<button data-bind="click: nextYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-right"></i>
					</button>
				</span>
			</div>
			<select data-bind="options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: isSingle(odList()) ? undefined : 'Select OD',
					value: od" class="form-control input-sm minwidth150"></select>
		</div>
		<div class="pull-left font16 lh28">
			<b>Private Sector Report Received</b>
		</div>
		<div class="pull-right">
			<a href="/Home"><img src="/media/images/home_back.png" /></a>
		</div>
	</div>
	<div class="panel-body">
		<table id="tblreport" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" class="text-center">#</th>
					<th>Private Sector</th>
					<!--ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
					<th width="100" class="text-center">Facility Type</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: reportList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Outlet_E"></td>
					<!--ko foreach: reports -->
					<th class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? 'X' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.editReport,
						   visible: $root.visibleReport($data)" style="padding-top:2px"></a>
					</th>
					<!-- /ko -->
					<td data-bind="text: Type" class="text-center"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="hidden: isListView" style="margin:-10px -10px 0 -10px; display:none">
	<div class="panel-heading clearfix" data-bind="with: master">
		<div class="pull-left lh26">
			<b>OD:</b>
			<span data-bind="text: od"></span>

			<b style="margin-left:30px">Provider:</b>
			<span data-bind="text: en"></span>

			<b style="margin-left:30px">Monthly Report:</b>
			<span data-bind="text: month"></span>

			<b style="margin-left:30px">Submission Date:</b>
			<span data-bind="text: DateAdded"></span>
		</div>
		<div class="pull-right">
            <button class="btn btn-danger btn-sm width100" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['Private Sector Data'].contain('Delete')">Delete</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back" style="margin-left:30px">Back</button>
		</div>
	</div>
	<div class="panel-body no-padding">
		<table id="tblcase" class="table table-bordered table-hover">
			<thead>
				<tr>
					<td width="40" class="text-middle">#</td>
					<td width="100"><kh>ថ្ងៃខែឆ្នាំ</kh><br />Date</td>
					<td width="160"><kh>ភូមិ</kh><br />Village</td>
					<td colspan="2"><kh>អាយុ / ខ្នាត់</kh><br />Age / Unit</td>
					<td width="100"><kh>ភេទ</kh><br />Sex</td>
					<td width="100"><kh>ផ្ទៃពោះ</kh><br />Pregnant</td>
					<td width="100"><kh>លទ្ធផល</kh><br />Result</td>
					<td colspan="2"><kh>ថ្នាំ</kh><br />ACT</td>
					<td><kh>បញ្ជូន</kh><br />Referred</td>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1"></td>
					<td data-bind="text: DateCase"></td>
					<td data-bind="with: ExtraCode.popObject">
						<button class="btn btn-default btn-sm relative btnvill" style="width:100%; padding-left:2px; border-radius:0" data-bind="click: villClick, style: { 'border': villWarn() ? '2px solid red' : '' }">
							<div style="width:140px; height:15px; overflow-x:hidden" data-bind="text: $root.getVill(base())"></div>
							<span class="caret" style="position:absolute; right:5px; top:8px"></span>
						</button>
						<!-- ko if: popVisible -->
						<div class="popover bottom" data-bind="style: { top: $root.getTop($element), left: $root.getLeft($element) }">
							<div class="arrow"></div>
							<div class="popover-content">
								<div class="form-group">
									<select data-bind="value: province, options: provList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Province --'"></select>
								</div>
								<div class="form-group">
									<select data-bind="value: district, options: distList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- District --'"></select>
								</div>
								<div class="form-group">
									<select data-bind="value: commune, options: commList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Commune --'"></select>
								</div>
								<div class="form-group">
									<select data-bind="value: village, options: villList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Village --'"></select>
								</div>
								<div>
									<label class="checkbox-inline">
										<input type="checkbox" data-bind="checked: base() == '999', click: unknownClick" style="width:20px; height:20px;" />
										<span style="margin-left:3px">Unknown</span>
									</label>
								</div>
							</div>
						</div>
						<!-- /ko -->
					</td>
					<td width="100" data-bind="text: Age"></td>
					<td width="100" data-bind="text: AgeType"></td>
					<td data-bind="text: Sex"></td>
					<td data-bind="text: PregnantMTHS"></td>
					<td data-bind="text: $root.getDiagnosis(Diagnosis)"></td>
					<td width="100" data-bind="text: Treatment"></td>
					<td width="200" data-bind="text: OtherTreatment"></td>
					<td data-bind="text: $root.getReason(RefReason)"></td>
				</tr>
			</tbody>
		</table>

		<div class="total" data-bind="with: master">
			<div class="form-inline">
				<p class="form-control-static"><kh>ករណីសង្ស័យថាមានជម្ងឺគ្រុនចាញ់</kh></p>
				<input type="text" class="form-control input-sm font14" data-bind="value: SuspectedCases" />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>ធ្វើតេស្តឈាមជាមួយឧបករណ៏តេស្តឈាមរហ័ស (RDT) ក</kh></p>
				<input type="text" class="form-control input-sm font14" data-bind="value: RDTtest" />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>មិនធ្វើតេស្តឈាម - អស់ឧបករណ៏តេស្តឈាមរហ័ស (RDT) ខ</kh></p>
				<input type="text" class="form-control input-sm font14" data-bind="value: $data['NoTest-NoRDT']" />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>មិនធ្វើតេស្តឈាម - អ្នកជម្ងឺមិនព្រមធ្វើតេស្តឈាម គ</kh></p>
				<input type="text" class="form-control input-sm font14" data-bind="value: $data['NoTest-NotAgree']" />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>មិនធ្វើតេស្តឈាម - អ្នកជម្ងឺគ្រុនចាញ់ធ្ងន់ធ្ងរ ឃ</kh></p>
				<input type="text" class="form-control input-sm font14" data-bind="value: $data['NoTest-Severe']" />
			</div>
			<div class="form-inline">
				<p class="form-control-static"><kh>ចំនួនឧបករណ៏តេស្តឈាមរហ័សប្រើរួចដែលបានប្រមូលមកវិញ</kh></p>
				<input type="text" class="form-control input-sm font14" data-bind="value: $data['TotalRDT-NotCollect']" />
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/PPMCase.js')?>