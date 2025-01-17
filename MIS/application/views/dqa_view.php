<style>
    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }
</style>
<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left" id="menu">
			<button name="HC" class="btn btn-default width100">HC</button>
			<button name="VMW" class="btn btn-default width100">VMW/MMW</button>
            <button name="Summary" class="btn btn-default width100">Summary</button>
            <button name="Target" class="btn btn-default width100">Target</button>
		</div>
		<div class="pull-right">
			<a class="btn btn-default" href="/home">Home</a>
		</div>
	</div>
    <div class="panel-heading clearfix" data-bind="visible: menu() != '' && menu()!='Summary' && menu() != 'Target'">
        <div class="pull-left form-inline" data-bind="visible: view() == 'list'">
            <div class="input-group">
                <span class="input-group-addon">Province</span>
                <select data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'Select'" class="form-control minwidth150"></select>
            </div>
            <div class="input-group" data-bind="visible: menu().in('OD','HC','VMW')">
                <span class="input-group-addon">OD</span>
                <select data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'Select'" class="form-control minwidth150"></select>
            </div>
            <div class="input-group" data-bind="visible: menu().in('HC','VMW')">
                <span class="input-group-addon">HC</span>
                <select data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'Select'" class="form-control minwidth150"></select>
            </div>
            <div class="input-group" data-bind="visible: menu().in('VMW')">
                <span class="input-group-addon">VMW</span>
                <select data-bind="value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'Select'" class="form-control minwidth150"></select>
            </div>
            <button class="btn btn-primary width100" data-bind="click: viewData">View</button>
        </div>
        <div class="pull-right" data-bind="visible: view() == 'detail'">
            <button class="btn btn-primary width100" data-bind="click: save, visible: ifcan('Edit')">Save</button>
            <button class="btn btn-default width100" data-bind="click: back">Back</button>
        </div>
    </div>

    <div class="panel-body" data-bind="visible: menu() != '' && menu()!='Summary' && view() == 'list' && menu() != 'Target'">
        <table class="table table-bordered">
            <thead class="bg-thead">
                <tr>
                    <th align="center" width="40">#</th>
                    <th align="center" sortable>Name</th>
                    <th align="center" sortable>Age</th>
                    <th align="center" sortable>Sex</th>
                    <th align="center" sortable>Date Case</th>
                    <th align="center" sortable>Specie</th>
                    <th align="center" width="60">Detail</th>
                    <th align="center" width="60" data-bind="visible: ifcan('Delete')">Delete</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listModel,  fixedHeader: true">
                <tr data-bind="style: { color: HasDQA() == 1 ? 'red' : 'black'} ">
                    <td align="center" data-bind="text: $index() + 1"></td>
                    <td class="kh" data-bind="text: NameK"></td>
                    <td data-bind="text: Age"></td>
                    <td data-bind="text: $root.getSex(Sex())"></td>
                    <td align="center" data-bind="text: moment(DateCase()).displayformat()"></td>
                    <td data-bind="text: $root.getSpecie(Diagnosis())"></td>
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

	<?php if ($type) $this->load->view('dqa_detail_view') ?>

	<div class="panel-footer text-center" data-bind="visible: view() == 'detail' && ifcan('Edit')">
		<button class="btn btn-primary width150" data-bind="click: save">Save</button>
	</div>
</div>

<?php if ($type=='Summary') $this->load->view('dqa_summary_view') ?>
<?php if ($type=='Target') $this->load->view('dqa_target_view') ?>

<?=latestJs('/media/ViewModel/DQA.js')?>