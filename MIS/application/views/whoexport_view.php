<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh28 font16">
			<b>WHO Data Exporting</b>
		</div>
		<div class="pull-right">
			<a href="/Login/logout">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-hover table-striped widthauto">
			<thead>
				<tr>
					<th valign="middle">File Name</th>
					<th align="center" class="form-inline">
						<span>Year</span>
						<select class="form-control input-sm" data-bind="value: year, options: yearList, optionsCaption: 'All'"></select>
					</th>
					<th align="center" class="form-inline">
						<span>Month</span>
						<select class="form-control input-sm" data-bind="value: month, options: monthList, optionsCaption: 'All'"></select>
					</th>
					<th align="center" valign="middle">Download</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr data-bind="visible: ($root.year() == null || $root.year() == year) && ($root.month() == null || $root.month() == month)">
					<td data-bind="text: filename"></td>
					<td data-bind="text: year" align="center"></td>
					<td data-bind="text: month" align="center"></td>
					<td align="center">
						<a data-bind="click: $root.export">Download</a>
					</td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: listModel().filter(r => ($root.year() == null || $root.year() == r.year) && ($root.month() == null || $root.month() == r.month)).length == 0">
				<tr>
					<td colspan="4" class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/WhoExport.js')?>