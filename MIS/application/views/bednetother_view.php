<style>
	.table > thead { background-color: #9AD8ED; }
	#tblcase thead th { text-align: center; }
	#tblcase tbody td:not(:last-child) { font-size: 12px; text-align:center; vertical-align: middle; padding: 0px 2px; height:30px; }
	#tblcase tbody td .btn-sm { font-size: 12px; line-height:15px; border-radius:2px; }
	#tblcase tbody input[type="text"] { width: 100%; padding: 0; }
	#tblcase tbody select { width: 100%; padding: 1px 1px 2px 1px; }
	#tblcase tbody td.hasCheckbox { padding: 0; }
	#tblcase tbody td.hasCheckbox input { width:20px; height:20px; margin-top: 4px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="margin:-10px -10px 0 -10px; display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh28">
			<b>Bed Net Other Report Received</b>
		</div>
		<div class="pull-right">
            <button class="btn btn-primary btn-sm width100" data-bind="click: saveReport, visible: app.user.permiss['Bed Net Other Data'].contain('Edit')">Save</button>
            <button class="btn btn-default btn-sm width100" data-bind="click: back" style="margin-left:30px">Back</button>
		</div>
	</div>
	<div class="panel-body no-padding">
		<table id="tblcase" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="100">Year</th>
					<th width="100">Month</th>
					<th width="160">Province</th>
					<th>Place Name</th>
					<th width="100">LLIN</th>
					<th width="100">LLIHN</th>
					<th width="100">HamokNet</th>
					<th width="100" class="text-center">Mobile</th>
					<th width="100"></th>
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList">
				<tr>
					<td>
						<select data-bind="value: Year, options: $root.yearList, optionsCaption: ''"></select>
					</td>
					<td>
						<select data-bind="value: Month, options: $root.monthList, optionsCaption: ''"></select>
					</td>
					<td>
						<select data-bind="value: Code_Prov_T, options: $root.provList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</td>
					<td>
						<input type="text" data-bind="textInput: Place" />
					</td>
					<td>
						<input type="text" data-bind="textInput: LLIN" />
					</td>
					<td>
						<input type="text" data-bind="textInput: LLIHN" />
					</td>
                    <td>
                        <input type="text" data-bind="textInput: HamokNet" />
                    </td>
					<td class="hasCheckbox">
						<input type="checkbox" data-bind="checked: Mobile" />
					</td>
					<td>
						<!-- ko if: Rec_ID() == -1 -->
                        <button class="btn btn-primary btn-xs btn-block" data-bind="click: $root.addCase, visible: Rec_ID() == -1 && app.user.permiss['Bed Net Other Data'].contain('Edit')">Add</button>
						<!-- /ko -->
						<!-- ko if: Rec_ID() > -1 -->
                        <button class="btn btn-danger btn-xs btn-block" data-bind="click: $root.deleteCase, visible: Rec_ID() > -1 && app.user.permiss['Bed Net Other Data'].contain('Delete')">Delete</button>
						<!-- /ko -->
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="panel-footer text-center">
        <button class="btn btn-primary btn-sm width150" data-bind="click: saveReport, visible: app.user.permiss['Bed Net Other Data'].contain('Edit')">Save</button>
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

<?=latestJs('/media/ViewModel/BednetOther.js')?>