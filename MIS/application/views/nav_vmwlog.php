<style>
	.table th { background: #9AD8ED; text-align: center; }
	body { overflow-y: scroll; }
	input[type=checkbox] { width: 20px; height: 20px; margin: 0; }
	tbody td { vertical-align: middle !important; }
</style>

<div id="sysmenuboard" class="panel panel-default" style="display:none" data-bind="visible: true">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<strong style="margin-left:5px">System Table</strong>
			<?php echo form_dropdown('systable',$systablelist,$systable,'class="form-control input-sm" id="systable"');?>

			<strong style="margin-left:10px">Province</strong>
			<select class="form-control input-sm" id="code_prov" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'name'"></select>

			<strong style="margin-left:10px">OD</strong>
			<select class="form-control input-sm minwidth100" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All OD'"></select>

			<strong style="margin-left:10px">HC</strong>
			<select class="form-control input-sm minwidth100" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All HC'"></select>

			<strong style="margin-left:10px">Year</strong>
			<select class="form-control input-sm width100" data-bind="value: year, options: yearList"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['System Menu'].contain('VMW Log - Edit')">Save All</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<div class="font16 text-bold" style="padding:7px 0 3px 0">
			<span data-bind="text: 'Total VMW: ' + listModel().filter(r => r.HaveVMW() && !r.vlName.contain('(M)')).length"></span>
			<span data-bind="text: 'Total MMW: ' + listModel().filter(r => r.HaveVMW() && r.vlName.contain('(M)')).length" style="margin-left:30px"></span>
			<span data-bind="text: 'Care: ' + listModel().filter(r => r.HaveVMW() && r.CSO() == 'Care').length" style="margin-left:30px"></span>
			<span data-bind="text: 'CHAI: ' + listModel().filter(r => r.HaveVMW() && r.CSO() == 'CHAI').length" style="margin-left:30px"></span>
			<span data-bind="text: 'CRS: ' + listModel().filter(r => r.HaveVMW() && r.CSO() == 'CRS').length" style="margin-left:30px"></span>
			<span data-bind="text: 'HPA: ' + listModel().filter(r => r.HaveVMW() && r.CSO() == 'HPA').length" style="margin-left:30px"></span>
			<span data-bind="text: 'MC: ' + listModel().filter(r => r.HaveVMW() && r.CSO() == 'MC').length" style="margin-left:30px"></span>
			<span data-bind="text: 'PFD: ' + listModel().filter(r => r.HaveVMW() && r.CSO() == 'PFD').length" style="margin-left:30px"></span>
			<span data-bind="text: 'PSI: ' + listModel().filter(r => r.HaveVMW() && r.CSO() == 'PSI').length" style="margin-left:30px"></span>
			<span data-bind="text: 'URC: ' + listModel().filter(r => r.HaveVMW() && r.CSO() == 'URC').length" style="margin-left:30px"></span>
		</div>

		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>OD</th>
					<th>HF</th>
                    <th>Village Code</th>
					<th class="clickable" onclick="app.vm.sortTable('vlName')">Village EN</th>
					<th class="clickable" onclick="app.vm.sortTable('vlNameK')">Village KH</th>
					<th width="50">CSO</th>
					<th>VMW</th>
					<th>MMW</th>
					<th width="50">IP1</th>
					<th width="50">IP2</th>
					<!-- ko foreach: Array(12) -->
					<th data-bind="text: moment($index() + 1, 'M').format('MMM')" width="50"></th>
					<!-- /ko -->
					<th>Note</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true">
				<tr>
					<td data-bind="text: odNameK" class="kh"></td>
					<td data-bind="text: hcNameK" class="kh"></td>
                    <td data-bind="text: vlCode"></td>
					<td data-bind="text: vlName"></td>
					<td data-bind="text: vlNameK" class="kh"></td>
					<td data-bind="text: CSO" align="center"></td>
					<td align="center"><input type="checkbox" class="text-middle" data-bind="checked: HaveVMW" /></td>
					<td data-bind="text: vlName.contain('(M)') ? 'Yes' : 'No'" align="center"></td>
					<td align="center"><input type="checkbox" class="text-middle" data-bind="checked: IP1" /></td>
					<td align="center"><input type="checkbox" class="text-middle" data-bind="checked: IP2" /></td>
					<!-- ko foreach: Array(12) -->
					<td align="center" data-bind="if: $root.year() < moment().year() || $index() < moment().month()">
						<input type="checkbox" class="text-middle" data-bind="checked: $parent[$index() + 1]" />
					</td>
					<!-- /ko -->
					<td><input type="text" class="form-control input-sm" data-bind="value: note" /></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Nav_VMWLog.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>