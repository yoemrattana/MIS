<style>
	.fixRight { position: fixed; right: 10px; top: 11px; }
	.table > thead { background-color: #9AD8ED; }
	#tblreport a { display: block; }
	#tblcase { min-width: 1700px; }
	#tblcase thead td { text-align: center; }
	#tblcase tbody td { text-align: center; vertical-align: middle; padding: 0px 2px; height:30px; }
	#tblcase tbody input[type="text"] { width: 100%; padding: 0; }
</style>

<div class="panel panel-default" data-bind="visible: isListView" style="display:none">
	<div class="panel-heading clearfix relative">
		<div class="pull-center form-inline">
			<div class="input-group width150">
				<span class="input-group-btn">
					<button data-bind="click: previousYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-left"></i>
					</button>
				</span>
				<input data-bind="value: year" type="text" class="form-control text-center" style="background-color:white" readonly />
				<span class="input-group-btn">
					<button data-bind="click: nextYear" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-right"></i>
					</button>
				</span>
			</div>
			<select data-bind="options: provList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'Select Province',
					value: prov" class="form-control minwidth150 kh" style="padding:3px 12px"></select>
		</div>
		<div class="pull-left font16 lh28">
			<b>Police Bednet Report</b>
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
					<th>Troop</th>
					<th>Khmer Name</th>
					<!--ko foreach: Array(12) -->
					<th class="text-center" data-bind="text: ('0' + ($index() + 1)).substr(-2)"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: reportList, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Troop_E"></td>
					<td data-bind="text: Name_Troop_K" class="kh"></td>
					<!--ko foreach: reports -->
					<th class="text-center text-middle no-padding font16">
						<a data-bind="text: has() ? 'X' : 'O',
						   style: { color: has() ? 'darkblue' : 'red' },
						   click: $root.editReport,
						   visible: $root.visibleReport($data)" style="padding-top:2px"></a>
					</th>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="hidden: isListView" style="margin:-10px; display:none">
	<div class="panel-heading clearfix" data-bind="with: master">
		<div class="pull-left lh26">
			<b class="kh">ខេត្ត</b>
			<span data-bind="text: prov" class="kh"></span>

			<b style="margin-left:20px" class="kh">កង</b>
			<kh data-bind="text: kh" class="kh"></kh>

			<b style="margin-left:20px" class="kh">របាយការណ៍ខែ</b>
			<span data-bind="text: month"></span>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: $root.saveReport, visible: app.user.permiss['Police Bed Net'].contain('Edit')">Save</button>
			<button class="btn btn-danger btn-sm width100" data-bind="click: $root.deleteReport, visible: has && app.user.permiss['Police Bed Net'].contain('Delete')">Delete</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: $root.back" style="margin-left:30px">Back</button>
		</div>
	</div>
	<div class="panel-body no-padding">
		<table id="tblcase" class="table table-bordered table-hover">
			<thead>
				<tr>
					<td width="35%"></td>
					<td width="100">
						<kh>មុងគ្រែ</kh>
						<br />LLIN
					</td>
					<td width="100">
						<kh>មុងអង្រឹង</kh>
						<br />LLIHN
					</td>
					<td width="100">
						<kh>មុងជាប់អង្រឹង</kh>
						<br />HamokNet
					</td>
					<td width="35%"></td>
				</tr>
			</thead>
			<tbody data-bind="with: detail, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td width="35%"></td>
					<td>
						<input type="text" data-bind="textInput: LLIN" class="text-center" />
					</td>
					<td>
						<input type="text" data-bind="textInput: LLIHN" class="text-center" />
					</td>
					<td>
						<input type="text" data-bind="textInput: HamokNet" class="text-center" />
					</td>
					<td width="35%"></td>
				</tr>
			</tbody>
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

<?=latestJs('/media/ViewModel/PLBednet.js')?>