<style>
	tbody input { width: 100%; }
</style>

<?php $this->view('lab/lab_menu'); ?>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh26 font16" style="position:sticky; left:21px">
			<b>Malaria National Reference Laboratory System</b>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<a href="/Home" class="btn btn-sm btn-home">Home</a>
		</div>
	</div>

	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" style="position:sticky; left:21px">
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Province</span>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group input-group-sm" data-bind="visible: pv() != 'CNM'">
				<span class="input-group-addon">OD</span>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group input-group-sm" data-bind="visible: pv() != 'CNM'">
				<span class="input-group-addon">HF</span>
				<select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">Date</span>
				<select class="form-control widthauto" data-bind="value: year, options: yearList"></select>
				<select class="form-control widthauto" data-bind="value: qt" style="border-left:none">
					<option>Q1</option>
					<option>Q2</option>
					<option>Q3</option>
					<option>Q4</option>
				</select>
			</div>
			<button class="btn btn-sm btn-primary width80" data-bind="click: viewClick">View</button>
		</div>
		<div class="pull-right" style="position:sticky; right:11px" data-bind="visible: app.user.prov == '' && pv() == null">
			<button class="btn btn-sm btn-success" data-bind="click: exportExcel">Export All</button>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<button class="btn btn-sm btn-success width80" data-bind="click: exportExcel, visible: listModel().length > 0">Export</button>
			<button class="btn btn-sm btn-primary width80" data-bind="click: save, visible: listModel().length > 0">Save</button>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<table class="table table-bordered table-hover form-group">
			<thead class="bg-thead">
				<tr>
					<th align="center" rowspan="2">Category</th>
					<th align="center" rowspan="2">Statement</th>
					<th align="center" colspan="2">Total Score:</th>
					<th align="center" data-bind="text: getTotal()" class="total"></th>
					<th align="center" rowspan="2">Remark</th>
				</tr>
				<tr>
					<th align="center" width="50">Yes</th>
					<th align="center" width="50">No</th>
					<th align="center">Score</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: Category" class="text-nowrap"></td>
					<td data-bind="text: Statement"></td>
					<td align="center">
						<input type="radio" class="radio-lg" value="1" data-bind="checked: Answer, attr: { name: Statement_ID }" />
					</td>
					<td align="center">
						<input type="radio" class="radio-lg" value="0" data-bind="checked: Answer, attr: { name: Statement_ID }" />
					</td>
					<td align="center" data-bind="text: Answer"></td>
					<td align="center">
						<input type="text" data-bind="value: Remark" style="width:300px" />
					</td>
				</tr>
			</tbody>
		</table>
		<button class="btn btn-sm btn-success" data-bind="click: showNew">New Statement</button>
	</div>
</div>

<div class="modal" id="modalNew" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">New Statement</h3>
			</div>
			<div class="modal-body" data-bind="with: newModel">
				<div class="text-bold">Category</div>
				<div class="form-group">
					<input type="text" class="form-control" data-bind="value: Category" />
				</div>
				<div class="text-bold">Statement</div>
				<div class="form-group">
					<textarea class="form-control" rows="5" data-bind="value: Statement" style="resize:vertical"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width80" data-bind="click: saveNew">Save</button>
				<button class="btn btn-default btn-sm width80" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabIQA.js')?>