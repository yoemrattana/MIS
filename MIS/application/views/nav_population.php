<style>
	.table th { background: #9AD8ED; text-align: center; }
	.table td { white-space: nowrap; }
	body { overflow-y: scroll; }
	.table input { width:100%; padding:0; text-align:center; }
</style>

<div id="sysmenuboard" class="panel panel-default" style="display:none" data-bind="visible: true">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<strong style="margin-left:5px">System Table</strong>
			<?php echo form_dropdown('systable',$systablelist,$systable,'class="form-control input-sm" id="systable"');?>

			<strong style="margin-left:10px">Province</strong>
			<?php echo form_dropdown('code_prov',$provlist,$code_prov,'class="form-control input-sm" id="code_prov"'); ?>

			<strong style="margin-left:10px">OD</strong>
			<select class="form-control input-sm" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All OD'"></select>

			<strong style="margin-left:10px">HC</strong>
			<select class="form-control input-sm" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All HC'"></select>

            <strong style="margin-left:10px">Year</strong>
			<select class="form-control input-sm" data-bind="value: year, options: Array.range(2006, moment().year())"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['System Menu'].contain('Population - Edit')">Save All</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>

	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="clickable" onclick="app.vm.sortTable('Name_OD_E')">OD</th>
					<th class="clickable" onclick="app.vm.sortTable('Name_Facility_E')">HC</th>
					<th class="clickable" onclick="app.vm.sortTable('Name_Vill_E')">Village</th>
					<th class="clickable" onclick="app.vm.sortTable('Name_Vill_K')">Khmer</th>
					<th>Code</th>
                    <th>Total Pop</th>
                    <th>0 - 4 Years</th>
                    <th>5 - 14 Years</th>
                    <th>15 - 49 Years</th>
                    <th> > 49 Years</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Name_OD_E" valign="middle"></td>
					<td data-bind="text: Name_Facility_E" valign="middle"></td>
					<td data-bind="text: Name_Vill_E" valign="middle"></td>
					<td data-bind="text: Name_Vill_K" valign="middle" class="kh"></td>
					<td data-bind="text: Code_Vill_T" valign="middle"></td>
					<td width:60><input type="text" data-bind="value: Pop" /></td>
                    <td width:60><input type="text" data-bind="value: AgeU4" /></td>
                    <td width:60><input type="text" data-bind="value: Age5_14" /></td>
                    <td width:60><input type="text" data-bind="value: Age15_49" /></td>
                    <td width:60><input type="text" data-bind="value: AgeOver49" /></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal Save -->
<div class="modal" id="modalSave" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Do you want to save?</h3>
			</div>
			<div class="modal-body">
				<div style="font-size:18px">You have changed something.</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: yes" style="width:100px">Yes</button>
				<button class="btn btn-default btn-sm" data-bind="click: no" style="width:100px">No</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Nav_Population.js')?>