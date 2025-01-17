<style>
	.table th { background: #9AD8ED; text-align: center; }
	.table td { white-space: nowrap; }
	body { overflow-y: scroll; }
	.table input { width: 100%; padding: 0; text-align: center; }
	input[type=checkbox] { width: 20px; height: 20px; margin: 0; }
</style>

<div id="sysmenuboard" class="panel panel-default" style="display:none" data-bind="visible: true">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<strong style="margin-left:5px">System Table</strong>
			<?php echo form_dropdown('systable',$systablelist,$systable,'class="form-control input-sm" id="systable"');?>

			<strong style="margin-left:10px">Province</strong>
			<select class="form-control input-sm" id="code_prov" data-bind="value: prov, options: provList, optionsValue: 'code', optionsText: 'name'"></select>

			<strong style="margin-left:10px">OD</strong>
			<select class="form-control input-sm minwidth100" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name'"></select>

			<strong style="margin-left:10px">HC</strong>
			<select class="form-control input-sm minwidth100" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All HC'"></select>

			<strong style="margin-left:10px">Year</strong>
			<select class="form-control input-sm" data-bind="value: year">
				<option value="2007">2007 - 2015</option>
				<option value="2016">2016 - 2024</option>
			</select>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save, visible: app.user.permiss['System Menu'].contain('Bed Net Target - Edit')">Save All</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>

	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th sortable>OD</th>
					<th sortable>HC</th>
					<th sortable>Village</th>
					<th sortable>Khmer</th>
					<!-- ko foreach: Array(9) -->
					<th data-bind="text: parseInt($root.year()) + $index()"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: [1,2]">
				<tr data-bind="visible: ($parent.od() == null || $parent.od() == odCode) && ($parent.hc() == null || $parent.hc() == hcCode)">
					<td data-bind="text: odName" style="vertical-align:middle"></td>
					<td data-bind="text: hcName" style="vertical-align:middle" class="kh"></td>
					<td data-bind="text: vlName" style="vertical-align:middle"></td>
					<td data-bind="text: vlNameK" style="vertical-align:middle" class="kh"></td>
					<!-- ko foreach: Array(9) -->
					<td align="center">
						<input class="text-middle" type="checkbox" data-bind="checked: $parent[parseInt($root.year()) + $index()]" />
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Nav_BedNetTarget.js')?>