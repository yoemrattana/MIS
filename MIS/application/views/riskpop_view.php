<style>
	table.child { position:sticky; left:60px; }
	table { cursor:default; }
	.underline:not(:empty):hover { text-decoration: underline; cursor: pointer; }
    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }
    .input-error {
		border-color: tomato;
		color: tomato;
	}
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
    <div class="panel-heading clearfix">
        <div class="pull-left form-inline" style="position:sticky; left:21px">
            <div class="inlineblock hidden">
                <div class="text-bold">Year</div>
                <div class="form-group">
                    <select data-bind="value: $root.year, options: $root.yearList, optionsCaption: 'All'" class="form-control"></select>
                </div>
            </div>

        </div>
        <div class="pull-right" style="position:sticky; right:21px">
            <button class="btn btn-primary" data-bind="click: $root.addNew">New</button>
            <a href="/Home" class="btn btn-default">Home</a>

        </div>
    </div>
    <div class="panel-body">
        <table id="tblmain" class="table table-bordered table-hover text-nowrap">
            <thead class="bg-thead">
                <tr>
                    <th align="center" width="40">#</th>
                    <th align="center" sortable>Year</th>
                    <th align="center" sortable>Province</th>
                    <th align="center" sortable>High</th>
                    <th align="center" sortable>Medium</th>
                    <th align="center" sortable>Low</th>
                    <th align="center" sortable>No</th>
                    <th align="center" sortable>Action</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listModel">
                <tr>
                    <td align="center" data-bind="text: $index() +1"></td>
                    <td align="center" data-bind="text: Year"></td>
                    <td align="center" data-bind="text: $root.getProvName(Code_Prov_T)"></td>
                    <td align="center" data-bind="text: High"></td>
                    <td align="center" data-bind="text: Medium"></td>
                    <td align="center" data-bind="text: Low"></td>
                    <td align="center" data-bind="text: No"></td>
                    <td align="center">
                        <i class="fa fa-trash text-danger" data-bind="click: $root.delete"></i>
                        &nbsp;&nbsp;
                        <i class="fa fa-pencil" data-bind="click: $root.edit"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="modalEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body form-horizontal" data-bind="with: Pop">
                <div class="form-group">
                    <label class="control-label col-xs-2">Year:</label>
                    <div class="col-xs-10">
                        <div class="input-group" style="width:344px">
                            <select data-bind="value: Year, options: $root.yearList, optionsCaption: 'Select Year'" class="form-control"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">Province:</label>
                    <div class="col-xs-10">
                        <div class="input-group" style="width:344px">
                            <select data-bind="value: Code_Prov_T,optionsValue: 'code',optionsText: 'name', options: $root.pvList, optionsCaption: 'Select Province'" class="form-control"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">High:</label>
                    <div class="col-xs-10">
                        <div class="input-group" style="width:344px">
                            <input type="number" class="form-control" data-bind="value: High" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">Medium:</label>
                    <div class="col-xs-10">
                        <div class="input-group" style="width:344px">
                            <input type="number" class="form-control" data-bind="value: Medium" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">Low:</label>
                    <div class="col-xs-10">
                        <div class="input-group" style="width:344px">
                            <input type="number" class="form-control" data-bind="value: Low" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-2">No:</label>
                    <div class="col-xs-10">
                        <div class="input-group" style="width:344px">
                            <input type="number" class="form-control" data-bind="value: No" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary width100" data-bind="click: $root.save">Save</button>
                <button class="btn btn-default width100" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?=latestJs('/media/ViewModel/RiskPop.js')?>