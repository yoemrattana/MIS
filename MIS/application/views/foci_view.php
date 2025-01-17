<style>
	.table-hover thead { background-color: #9AD8ED; }
	.form-control { padding: 2px 5px; }
	.space { margin-left: 10px; }
	.photo { width: 802px; min-height: 400px; border: 1px solid black; position: relative; }
	.photo button { position: absolute; top: 4px; right: 4px; border-color: white; }
	.photo button:hover, .photo button:focus, .photo button:focus:active { border-color: white; }
	.highlight { background-color: #ffff99; font-weight: bold; }
	.width70 { width:70px !important; }
    .underline:not(:empty) { cursor: pointer; color: blue; }
    .underline:not(:empty):hover { text-decoration: underline; }
</style>

<div class="panel panel-default" data-bind="visible: view() == 'list'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<div class="inlineblock">
				<div class="text-bold">Province</div>
				<select data-bind="value: pv,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: pvList().length == 1 ? undefined : 'All Province'" class="form-control minwidth150"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">OD</div>
				<select data-bind="value: od,
						options: odList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: odList().length == 1 ? undefined : 'All OD'" class="form-control minwidth150"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">HC</div>
				<select data-bind="value: hc,
						options: hcList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All HC'" class="form-control minwidth150"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">Completed</div>
				<select data-bind="value: completed" class="form-control width100">
					<option>All</option>
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">Filter</div>
				<select data-bind="value: filter" class="form-control">
					<option value="Real">Real Foci Only</option>
					<option value="Match Report">Foci Match Report</option>
				</select>
			</div>
			<div class="inlineblock">
				<div class="text-bold" data-bind="text: filter() == 'Real' ? 'Foci Year' : 'Report Year'"></div>
				<select data-bind="value: year, options: yearList, optionsCaption: 'All'" class="form-control width100"></select>
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: app.user.permiss['Foci Investigation'].contain('Edit')">New</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th align="center" sortable>Investigator</th>
					<th align="center">Code</th>
					<th align="center" sortable>Foci Date</th>
					<th align="center">Diagnosis Date</th>
					<th align="center" sortable>OD</th>
					<th align="center" sortable>HC</th>
					<th align="center" sortable>Village</th>
					<th width="70" align="center" sortable>Classify</th>
					<th align="center">Lastmile Village</th>
					<th width="90" align="center">Completed</th>
					<th width="60" align="center">Detail</th>
					<th width="60" align="center" data-bind="visible: app.user.permiss['Foci Investigation'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Investigator, css: { kh: iskhmer(Investigator) }"></td>
					<td data-bind="text: FociCode" align="center"></td>
					<td data-bind="text: moment(FociInvestigationDate).format('DD-MM-YYYY'), sortValue: FociInvestigationDate" align="center"></td>
					<td data-bind="text: $root.getDiagnosisDate(Code_Vill_T), click: $root.showDateList" align="center" class="underline"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)" class="kh"></td>
					<td data-bind="text: $root.getVLName(Code_Vill_T)" class="kh"></td>
					<td data-bind="text: [R1,V1].contain(null) ? '' : 'R' + R1 + 'V' + V1" align="center"></td>
					<td data-bind="text: IsLastmile == 1 ? '✔' : ''" align="center"></td>
					<td data-bind="text: Completed == 1 ? '✔' : ''" align="center" class="text-bold"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['Foci Investigation'].contain('Delete')">
						<a data-bind="click: $root.delete" class="text-danger">Delete</a>
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

<!-- Modal Date List -->
<div class="modal" id="modalDateList" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="40" align="center">#</th>
                            <th align="center">Diagnosis Date</th>
                            <th align="center">Report Date</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: dateList">
                        <tr>
                            <td data-bind="text: $index() + 1" align="center"></td>
                            <td data-bind="text: moment(DateCase).displayformat()" align="center"></td>
                            <td data-bind="text: moment(YearMonth).format('MM-YYYY')" align="center"></td>
                        </tr>
                    </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('foci1_view'); ?>
<?php $this->load->view('foci2_view'); ?>

<?=form_hidden('open', $open)?>
<?=latestJs('/media/ViewModel/Foci.js')?>
