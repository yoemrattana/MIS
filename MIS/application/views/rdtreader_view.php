<style>
	.table-hover thead { background-color: #9AD8ED; }
	.form-control { height: auto; padding: 2px 5px; }
	.space { margin-left: 10px; }
	.photo { width: 802px; min-height: 400px; border: 1px solid black; position: relative; }
	.photo button { position: absolute; top: 4px; right: 4px; border-color: white; }
	.photo button:hover, .photo button:focus, .photo button:focus:active { border-color: white; }
	.highlight { background-color: #ffff99; font-weight: bold; }
	.width70 { width:70px !important; }
	.image-rdt { width: 100% }
	.form-control { width: 800px }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list'">
			<!--<h5 style="font-weight: 700">RDT Reader</h5>-->
			<div style="display:inline-block">
				<div class="text-bold">Year</div>
				<select data-bind="value: year, options: yearList" class="form-control input-sm width70"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Month</div>
				<select data-bind="value: month, options: monthList, optionsCaption: 'All'" class="form-control input-sm width70"></select>
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: showNew, visible: view() == 'list' && app.user.permiss['RDT Reader'].contain('Edit')">New</button>
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: view() == 'detail' && app.user.permiss['RDT Reader'].contain('Edit')">Save</button>
			<button class="btn btn-default btn-sm width100" data-bind="click: back, visible: view() == 'detail'">Back</button>
			<a href="/Home" data-bind="visible: view() == 'list'" style="margin-left:30px"><img src="/media/images/home_back.png"></a>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th align="center">Patient</th>
					<th align="center">Operator</th>
					<th align="center">RDT Type</th>
					<th align="center">Test Type</th>
					<th align="center">Error</th>
					<th align="center">Init Time</th>
					<th align="center">Modi Time</th>
					<th align="center">Modi User</th>
					<th align="center">App Version</th>
					<th width="60" align="center">Detail</th>
					<th width="60" align="center" data-bind="visible: app.user.permiss['RDT Reader'].contain('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: patient_id" class="kh"></td>
					<td data-bind="text: operator_name" align="center"></td>
					<td data-bind="text: rdt_type" align="center"></td>
					<td data-bind="text: test_type" class="kh"></td>
					<td data-bind="text: error" width="380"></td>
					<td data-bind="text: moment(InitTime).format('DD-MM-YYYY')" class="kh"></td>
					<td data-bind="text: ModiTime == null ? '' : moment(ModiTime).format('DD-MM-YYYY')" class="kh"></td>
					<td data-bind="text: ModiUser" class="kh"></td>
					<td data-bind="text: app_version" class="kh"></td>
					<td align="center"><a data-bind="click: $root.showDetail">Detail</a></td>
					<td align="center" data-bind="visible: app.user.permiss['RDT Reader'].contain('Delete')">
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
	<div class="panel-body" data-bind="visible: view() == 'detail', with: detailModel">
		<h3 class="kh text-center">តេស្តរហ័ស</h3>
		<h4 class="text-center">RDT Reader</h4>
		<br /><br />

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form>
					<div class="form-group">
						<label>Patient ID</label>
						<input type="text" class="form-control" data-bind="textInput: patient_id" placeholder="Patient ID" />
					</div>
					<div class="form-group">
						<label>Operator Name</label>
						<input type="text" class="form-control" data-bind="textInput: operator_name" placeholder="Operator Name" />
					</div>
					<div class="form-group">
						<label>Test start time</label>
						<input data-bind="dateTimePicker: test_start_time" type="text" class="form-control" placeholder="DD-MM-YYYY" />
					</div>
					<div class="form-group">
						<label>Scan time</label>
						<input data-bind="dateTimePicker: scan_time" type="text" class="form-control" placeholder="DD-MM-YYYY" />
					</div>
					<div class="form-group">
						<label>LOINC code test id</label>
						<input type="text" class="form-control" data-bind="textInput: LOINC_code_test_id" placeholder="LOINC code test id" />
					</div>
					<div class="form-group">
						<label>LOINC test answer list code</label>
						<input type="text" class="form-control" data-bind="textInput: LOINC_test_answer_list_code" placeholder="LOINC test answer list code" />
					</div>
					<div class="form-group">
						<label>LOINC Answer ID</label>
						<input type="text" class="form-control" data-bind="textInput: LOINC_Answer_ID" placeholder="LOINC Answer ID" />
					</div>
					<div class="form-group">
						<label>RDT Type</label>
						<input type="text" class="form-control" data-bind="textInput: rdt_type" placeholder="RDT Type" />
					</div>
					<div class="form-group">
						<label>Test Type</label>
						<input type="text" class="form-control" data-bind="textInput: test_type" placeholder="Test Type" />
					</div>
					<div class="form-group">
						<label>Probabilities</label>
						<textarea type="text" class="form-control" data-bind="textInput: probabilities" placeholder="Probabilities"></textarea>
					</div>

					<div class="photo">
						<img class="image-rdt" data-bind="attr: { src: image }" />
						<button class="btn btn-primary" data-bind="click: $root.selectFile">Choose Photo</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && app.user.permiss['RDT Reader'].contain('Edit')">
		<button class="btn btn-primary btn-sm width100" data-bind="click: save">Save</button>
		<label style="font-family: calibri; font-weight: 500; color:#3c3939" class="pull-right">RDT App Reader V1.0 (Released 2020-03-03)</label>
	</div></div>

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

<input type="file" id="file" class="hide" data-bind="change: () => fileChanged($element.files)" accept="image/*" />

<?=latestJs('/media/ViewModel/RDTReader.js')?>