<style>
	.table th { background: #9AD8ED; text-align: center; }
	body { overflow-y: scroll; }
	input[type=checkbox] { width: 20px; height: 20px; margin: 0; }
	tbody td { padding-bottom: 0 !important; }
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

			<strong style="margin-left:10px">Year</strong>
			<select class="form-control input-sm width100" data-bind="value: year, options: yearList"></select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['System Menu'].contain('HF Log - Edit')">Save All</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
                    <th sortable>OD English</th>
                    <th sortable>OD Khmer</th>
                    <th sortable>HF English</th>
                    <th sortable>HF Khmer</th>
					<th sortable width="80">HF Type</th>
					<th width="30">IP1</th>
					<th width="30">IP2</th>
					<!-- ko foreach: Array(12) -->
					<th data-bind="text: moment($index() + 1, 'M').format('MMM')" width="50"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader:[0,2]">
				<tr data-bind="visible: $parent.od() == null || $parent.od() == odCode">
					<td data-bind="text: odName" style="vertical-align:middle"></td>
					<td data-bind="text: odNameK" style="vertical-align:middle" class="kh"></td>
					<td data-bind="text: hcName" style="vertical-align:middle"></td>
					<td data-bind="text: hcNameK" style="vertical-align:middle" class="kh"></td>
					<td data-bind="text: type" style="vertical-align:middle"></td>
					<td align="center"><input type="checkbox" class="text-middle" data-bind="checked: IP1" /></td>
					<td align="center"><input type="checkbox" class="text-middle" data-bind="checked: IP2" /></td>
					<!-- ko foreach: Array(12) -->
					<td align="center" data-bind="if: $root.year() < moment().year() || $index() < moment().month()">
						<input type="checkbox" data-bind="checked: $parent[$index() + 1]" />
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Nav_HFLog.js')?>