<style>
	body{
		overflow-x: scroll;
	}
</style>
<div id="exportSurveillance" data-bind="visible: tab() == 'Surveillance' && app.user.permiss['Dashboard'].contain('Surveillance')" style="display: none">
	<h3 data-bind="text: String.format('Surveillance Data, {0}-{1} {2} AND {3}', lastSearch().from, lastSearch().to, lastSearch().year - 1, lastSearch().year)"></h3>
	<table id="table-sur" class="table color-bordered-table info-bordered-table table-striped box-shadow" style="width:100%">
		<thead>
			<tr>
				<th class="border-right" rowspan="4">Province / OD</th>
				<th class="border-right" colspan="2" rowspan="2">Population</th>
				<th class="border-right" colspan="15">HF + VMW</th>
				<th class="border-right" colspan="3" rowspan="2">TPR</th>
				<th class="border-right" colspan="3" rowspan="2">Incidence<br />(per 1000 pop)</th>
				<th class="border-right" colspan="3" rowspan="2">ABER</th>
			</tr>
			<tr>
				<th class="border-right" colspan="3">All Cases</th>
				<th class="border-right" colspan="3">Pf</th>
				<th class="border-right" colspan="3">Pv</th>
				<th class="border-right" colspan="3">Mix</th>
				<th class="border-right" colspan="3">Pm/Po/Pk</th>
			</tr>
			<tr>
				<th class="bg-info" data-bind="text: lastSearch().year - 1" style="border:none">2016</th>
				<th class="bg-primary" data-bind="text: lastSearch().year" style="border-top:none;border-left:none; border-bottom: none">2017</th>
				<!-- ko foreach: Array(8) -->
				<th class="bg-info" data-bind="text: $root.lastSearch().year - 1" style="border:none">2016</th>
				<th class="bg-primary" data-bind="text: $root.lastSearch().year" style="border:none">2017</th>
				<th class="bg-purple" style="border-top:none;border-left:none; border-bottom: none">Change</th>
				<!-- /ko -->
			</tr>
			<tr style="line-height:8px">
				<th class="bg-info" style="border:none">n</th>
				<th class="bg-primary" style="border-top:none;border-left:none; border-bottom: none">n</th>
				<!-- ko foreach: Array(8) -->
				<th class="bg-info" style="border:none">n</th>
				<th class="bg-primary" style="border:none">n</th>
				<th class="bg-purple" style="border-top:none;border-left:none; border-bottom:none">%</th>
				<!-- /ko -->
			</tr>
		</thead>
		<tbody data-bind="foreach: surveillanceList, fixedHeader: true">
			<!-- ko if: Level != '1' && $index() > 0 -->
			<tr data-bind="foreach: Object.keys($data)">
				<!-- ko if: $data != 'Level' -->
				<td>&nbsp;</td>
				<!-- /ko -->
			</tr>
			<!-- /ko -->
			<tr data-bind="foreach: Object.keys($data)">
				<!-- ko if: $data == 'Name' -->
				<td data-bind="text: ($parent['Level'] == '1' ? '&nbsp;&nbsp;&nbsp;' : '') + $parent[$data], style: { fontWeight: $parent['Level'] != 1 ? 'bold' : '' }"></td>
				<!-- /ko -->
				<!-- ko if: $data != 'Name' && $data != 'Level' -->
				<td align="right" data-bind="style: { fontWeight: $parent['Level'] != 1 ? 'bold' : '',  }">
					<span data-bind="text: $parents[1].fixValue($parent[$data], $data), css: $parents[1].highlight($parent[$data], $data)"></span>
				</td>
				<!-- /ko -->
			</tr>
		</tbody>
		<tfoot style="background-color:antiquewhite" data-bind="with: surveillanceFooter">
			<tr data-bind="foreach: Object.keys($data)" style="border-top: 2px solid #ddd">
				<!-- ko if: $data == 'Name' -->
				<td data-bind="text: $parent[$data]" class="text-bold" style="padding-top:5px; padding-bottom:5px; border-right: 1px solid #ccc"></td>
				<!-- /ko -->
				<!-- ko if: $data != 'Name' && $data != 'Level' -->
				<td style="border-right:1px solid #ccc" align="right" class="text-bold">
					<span data-bind="text: $parents[1].fixValue($parent[$data], $data), css: $parents[1].highlight($parent[$data], $data)"></span>
				</td>
				<!-- /ko -->
			</tr>
		</tfoot>
	</table>
</div>