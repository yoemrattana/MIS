<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left" id="menu">
			<button name="PHD" class="btn btn-default width100">PHD</button>
			<button name="OD" class="btn btn-default width100">OD</button>
			<button name="HC" class="btn btn-default width100">HC</button>
			<button name="VMW" class="btn btn-default width100">VMW/MMW</button>
            <button name="Summary" class="btn btn-default width100">Summary</button>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-heading clearfix" data-bind="visible: menu() != '' && !['Summary'].includes(menu())">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list'">
			<div class="input-group">
				<span class="input-group-addon">Province</span>
				<select data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'" class="form-control minwidth150"></select>
			</div>
			<div class="input-group" data-bind="visible: menu().in('OD','HC','VMW')">
				<span class="input-group-addon">OD</span>
				<select data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'" class="form-control minwidth150"></select>
			</div>
			<div class="input-group" data-bind="visible: menu().in('HC','VMW')">
				<span class="input-group-addon">HC</span>
				<select data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'" class="form-control minwidth150"></select>
			</div>
		</div>
		<div class="pull-left form-inline" data-bind="visible: view() == 'detail'">
			<div class="input-group">
				<span class="input-group-addon">Language</span>
				<select class="form-control" data-bind="value: lang">
					<option>Khmer</option>
					<option>English</option>
				</select>
			</div>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'list'">
			<button class="btn btn-primary width100" data-bind="click: showNew, visible: ifcan('Edit')">New</button>
			<button class="btn btn-success width100" data-bind="click: exportExcel">Export</button>
		</div>
		<div class="pull-right" data-bind="visible: view() == 'detail'">
			<button class="btn btn-primary width100" data-bind="click: save, visible: ifcan('Edit')">Save</button>
			<button class="btn btn-default width100" data-bind="click: back">Back</button>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: menu() != '' && view() == 'list' && !['Summary'].includes(menu())">
		<table class="table table-bordered">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="40">#</th>
					<th align="center" sortable>Province</th>
					<th align="center" sortable data-bind="visible: menu().in('OD','HC','VMW')">OD</th>
					<th align="center" sortable data-bind="visible: menu().in('HC','VMW')">HC</th>
					<th align="center" sortable data-bind="visible: menu().in('VMW')">VMW/MMW</th>
					<th align="center" sortable>Date</th>
					<th align="center" width="60">Detail</th>
					<th align="center" width="60" data-bind="visible: ifcan('Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: $data.Name_OD_E, visible: $root.menu().in('OD','HC','VMW')"></td>
					<td data-bind="text: $data.Name_Facility_E, visible: $root.menu().in('HC','VMW')"></td>
					<td data-bind="text: $data.Name_Vill_E, visible: $root.menu().in('VMW')"></td>
					<td align="center" data-bind="text: moment(InterviewDate).displayformat()"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
					<td align="center" data-bind="visible: $root.ifcan('Delete')">
						<a data-bind="click: $root.showDelete" class="text-danger">Delete</a>
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

	<?php if ($type) $this->load->view('questionbank_detail_view') ?>

	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && ifcan('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<?php if ($type=='Summary') $this->load->view('questionbank_summary_view') ?>

<?=latestJs('/media/ViewModel/QuestionBank.js')?>