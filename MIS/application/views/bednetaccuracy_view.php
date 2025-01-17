<style>
	input[type='text']:focus {
		width: 200px !important;
	}
	.red { color: red}
	.orange { color: orange}
	.red-box { border: 1px solid red; padding: 3px 3px 3px 23px;}
	.orange-box { border: 1px solid orange; padding: 3px 3px 3px 23px;}
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline lh28" style="position:sticky; left:21px">
			<span>Province</span>
			<select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Province'"></select>

			<span style="margin-left: 10px">Quarter</span>
			<select class="form-control input-sm" data-bind="value: quarter" id="quarter">
				<option>Q1</option>
				<option>Q2</option>
				<option>Q3</option>
				<option>Q4</option>
			</select>

			<span style="margin-left:10px">Year</span>
			<select class="form-control input-sm" data-bind="value: year, options: yearList"></select>

			<span class="red-box"></span> <kh> លើស</kh> &nbsp;&nbsp; 
			<span class="orange-box"></span>​​ <kh> ខ្វះ</kh>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<button class="btn btn-primary btn-sm width100" data-bind="click: save" style="margin-right:30px">Save All</button>
			<a data-bind="click: home">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover widthauto" style="min-width:100%">
			<thead>
				<tr>
					<th rowspan="3" align="center" valign="middle">Province</th>
					<th rowspan="3" align="center" valign="middle">OD</th>
				</tr>
				<tr>
					<th colspan="8" align="center">Continue</th>
					<th colspan="8" align="center">Mobile</th>
					<th colspan="8" align="center">Campaign</th>
				</tr>
				<tr data-bind="foreach: Array(3)">
					<th colspan="4" align="center">LLIN</th>
					<th colspan="4" align="center">LLIHN</th>
				</tr>
			</thead>
			<thead data-bind="with: getListModel">
				<tr data-bind="visible: $data.length > 0">
					<th colspan="2" align="center">Total</th>
					<!-- ko foreach: $root.loop -->
					<th data-bind="text: $parent.sum(r => r[$data])" align="right"></th>
					<th data-bind="text: $parent.sum(r => parseInt(isempty(r[$data + 'A'](),0)))"></th>
					<th data-bind="text: $parent.sum(r => $root.calculate(r, $data))" class="bg-info" align="right"></th>
					<th></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true">
				<tr data-bind="click: app.selectTr">
					<td data-bind="text: Name_Prov_E" valign="middle" class="text-nowrap"></td>
					<td data-bind="text: Name_OD_E" valign="middle" class="text-nowrap"></td>

					<!-- ko foreach: $root.loop -->
					<td data-bind="text: $parent[$data]" align="right" valign="middle" style="min-width:50px"></td>
					<td>
						<input type="number" data-bind="textInput: $parent[$data + 'A']" style="width:50px" class="numonly" />
					</td>
					<td data-bind="text: is($root.calculate($parent, $data), 0, ''), css: $root.getColor(is($root.calculate($parent, $data), 0, ''))" class="bg-info" align="right" valign="middle" style="min-width:60px"></td>
					<td>
						<i class="fa fa-file-word-o"></i> <input type="text" data-bind="textInput: $parent[$data + 'Note']" style="width:50px" />
					</td>
					<!-- /ko -->
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
				<button class="btn btn-primary btn-sm width100">Yes</button>
				<button class="btn btn-danger btn-sm width100">No</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/BednetAccuracy.js')?>