<style>
	.fixRight { position: fixed; right: 10px; top: 11px; }
	.table > thead { background-color: #9AD8ED; }
	#tblreport a { display: block; }
	#tblcase thead td { text-align: center; }
	#tblcase tbody td { text-align: center; vertical-align: middle; padding: 0px 2px; height:30px; }
	#tblcase tbody td .btnvill { line-height:16px; border-radius:2px; }
	#tblcase tbody input[type="text"] { width: 100%; padding: 0; }
	#tblcase tbody select { width: 100%; padding: 1px 1px 2px 1px; }
	#tblcase tbody td.hasCheckbox { padding: 4px 0 0 0; }
	#tblcase tbody td.hasCheckbox div { border: 2px solid transparent; border-radius: 50%; width: 23px; height: 23px; }
	#tblcase tbody td.hasCheckbox input { margin: 0; }
	.popover { z-index: 1040; display: block; background-color: #ffff99; }
	.popover-content { padding: 8px; }
	.popover-content .form-group { margin-bottom: 5px; }
	.popover-content select { width: 155px !important; }
	.popover.bottom .arrow:after { border-bottom-color: #ffff99; }
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
			<b>Bet Net Report Received</b>
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
					<th>Heath Facility</th>
					<th>Khmer Name</th>
					<!--ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
					<th width="100" class="text-center">Facility Type</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: reportList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Name_Facility_K" class="kh"></td>
					<!--ko foreach: reports -->
					<th class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? 'X' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.editReport,
						   visible: $root.visibleReport($data)" style="padding-top:2px"></a>
					</th>
					<!-- /ko -->
					<td data-bind="text: Type_Facility" class="text-center"></td>
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

			<b style="margin-left:30px">Health Faciliy:</b>
			<span data-bind="text: en"></span>
			<span> - </span>
			<kh data-bind="text: kh"></kh>

			<b style="margin-left:30px">Monthly Report:</b>
			<span data-bind="text: month"></span>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: $root.saveReport, visible: app.user.permiss['Bed Net Data'].contain('Edit')">Save</button>
			<button class="btn btn-danger btn-sm width100" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['Bed Net Data'].contain('Delete')">Delete</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back" style="margin-left:30px">Back</button>
		</div>
	</div>
	<div class="panel-body no-padding">
		<table id="tblcase" class="table table-bordered table-hover">
			<thead>
				<tr>
					<td width="40" class="text-middle">#</td>
					<td></td>
					<td width="160"><kh>ភូមិ</kh><br />Village</td>
					<td width="100"><kh>មុងគ្រែ</kh><br />LLIN</td>
					<td width="100"><kh>មុងអង្រឹង</kh><br />LLIHN</td>
                    <td width="100"><kh>អង្រឹងមានមុង</kh><br />Hammok+Net</td>
                    <td width="100"><kh>ស្រ្តីមានផ្ទៃពោះ</kh><br />Pregnacy</td>
					<td width="100"><kh>យុទ្ធនាការ</kh><br />Campaign</td>
					<td width="100"><kh>ចល័ត</kh><br />Mobile</td>
					<td width="100"><kh>បន្ត</kh><br />Continue</td>
					<td width="96"></td>
					<td></td>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: Rec_ID() == -1 ? '-' : $index() + 1"></td>
					<td></td>
					<td data-bind="with: VillCode.popObject">
						<button class="btn btn-default btn-sm relative btnvill" style="width:100%; padding-left:2px; border-radius:0" data-bind="click: villClick, style: { 'border': villWarn() ? '2px solid red' : '' }">
							<div style="width:140px; height:18px; overflow-x:hidden" data-bind="text: $root.getVill(base())"></div>
							<span class="caret" style="position:absolute; right:5px; top:8px"></span>
						</button>
						<!-- ko if: popVisible -->
						<div class="popover bottom" data-bind="style: { top: $root.getTop($element), left: $root.getLeft($element) }">
							<div class="arrow"></div>
							<div class="popover-content">
								<div class="form-group">
									<select data-bind="value: commune, options: commList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Commune --'"></select>
								</div>
								<div class="form-group">
									<select data-bind="value: village, options: villList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Village --'"></select>
								</div>
								<div class="form-group">
									<button class="btn btn-sm btn-success" data-bind="click: ok">OK</button>
								</div>
							</div>
						</div>
						<!-- /ko -->
					</td>
					<td>
						<input type="text" data-bind="textInput: LLIN" class="text-center" />
					</td>
                    <td>
                        <input type="text" data-bind="textInput: LLIHN" class="text-center" />
                    </td>
					<td>
						<input type="text" data-bind="textInput: HammokNet" class="text-center" />
					</td>
                    <td>
						<input type="text" data-bind="textInput: Pregnancy" class="text-center" />
					</td>
					<td class="hasCheckbox">
						<div class="inlineblock">
							<input type="radio" class="radio-lg" value="Campaign" data-bind="checked: Type, attr: { name: 'Row' + $index() }" />
						</div>
					</td>
					<td class="hasCheckbox">
						<div class="inlineblock">
							<input type="radio" class="radio-lg" value="Mobile" data-bind="checked: Type, attr: { name: 'Row' + $index() }" />
						</div>
					</td>
					<td class="hasCheckbox">
						<div class="inlineblock">
							<input type="radio" class="radio-lg" value="Continued" data-bind="checked: Type, attr: { name: 'Row' + $index() }" />
						</div>
					</td>
					<td>
						<!-- ko if: Rec_ID() == -1 -->
                        <button class="btn btn-primary btn-sm btn-block" data-bind="click: $root.addCase, visible: app.user.permiss['Bed Net Data'].contain('Edit')">Add</button>
						<!-- /ko -->

						<!-- ko if: Rec_ID() > -1 -->
						<button class="btn btn-danger btn-sm btn-block" data-bind="click: $root.deleteCase, visible: app.user.permiss['Bed Net Data'].contain('Delete')">Delete</button>
						<!-- /ko -->
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="panel-footer text-center">
		<button class="btn btn-primary btn-sm width150" data-bind="click: saveReport, visible: app.user.permiss['Bed Net Data'].contain('Edit')">Save</button>
	</div>
</div>

<!-- Modal Save Change -->
<div class="modal" id="modalSave" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary"><kh>មានការកែទិន្នន័យ</kh> - Data Changing</h3>
			</div>
			<div class="modal-body" style="font-size:18px">
				<kh>តើអ្នកចង់រក្សាទុកការកែទិន្នន័យនេះទេ?</kh>
				<br /><br />
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

<?=latestJs('/media/ViewModel/Bednet.js')?>