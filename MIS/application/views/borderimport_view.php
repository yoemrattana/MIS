<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left">
            <button class="btn btn-default" data-bind="click: () => view('completeness')">
                Completeness
            </button>
            <button class="btn btn-default" data-bind="click: () => view('data')">Data</button>
		</div>
		<div class="pull-right">
            <button class="btn btn-success" data-bind="click: selectFile">Import Excel File</button>
            <a class="btn btn-default" href="/media/Maps/Border_Data_Sample.xlsx">Sample Excel File</a>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>

    <div class="panel-heading clearfix" data-bind="visible: $root.view() == 'data'">
        <div class="pull-left form-inline">
            <div class="input-group">
                <span class="input-group-addon text-bold">From</span>
                <input type="text" class="form-control text-center width100" data-bind="datePicker: mf, format: 'MMM YYYY'" />           
            </div>
            <button class="btn btn-primary width100" data-bind="click: viewClick">View</button>
        </div>
    </div>

	<div class="panel-body">
		<table data-bind="visible:view() =='completeness'" class="table table-bordered table-striped table-hover widthauto">
			<thead class="bg-thead">
				<tr>
					<th align="center" width="100">Year</th>
					<!-- ko foreach: Array(12) -->
					<th align="center" width="50" data-bind="text: moment().month($index()).format('MMM')"></th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td align="center" data-bind="text: year"></td>
					<!-- ko foreach: months -->
					<th align="center" width="50" data-bind="text: $data ? '✔' : ''"></th>
					<!-- /ko -->
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

        <table data-bind="visible:view() =='data'" class="table table-bordered table-striped table-hover widthauto">
            <thead class="bg-thead">
                <tr>
                    <th align="center" width="100">Country</th>
                    <th align="center" width="100">Place Code</th>
                    <th align="center" width="100">Test</th>
                    <th align="center" width="100">Positive</th>
                    <th align="center" width="100">Pf</th>
                    <th align="center" width="100">Pv</th>
                    <th align="center" width="100">Mix</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listData, fixedHeader: true">
                <tr>
                    <td align="center" data-bind="text: Country"></td>
                    <td align="center" data-bind="text: PlaceCode"></td>
                    <td align="center" data-bind="text: Test"></td>
                    <td align="center" data-bind="text: Positive"></td>
                    <td align="center" data-bind="text: Pf"></td>
                    <td align="center" data-bind="text: Pv"></td>
                    <td align="center" data-bind="text: Mix"></td>
                    
                </tr>
            </tbody>
            <tfoot data-bind="visible: app.tableFooter($element)">
                <tr>
                    <td class="text-center text-warning h4" style="padding:10px">No Data</td>
                </tr>
            </tfoot>
        </table>

	</div>

	<input type="file" class="hide" id="file" data-bind="event: { change: () => fileChanged($element.files, true) }" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
</div>


<!-- Modal Import -->
<div id="modalImport" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Import Excel File</h3>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>File Name</th>
							<th width="150" align="center">Status</th>
						</tr>
					</thead>
					<tbody data-bind="with: importModel">
						<tr>
							<td data-bind="text: name"></td>
							<td align="center">
								<span data-bind="text: status"></span>
								<img data-bind="visible: status() == 'Importing'" src="/media/images/ajax-loader.gif" height="18" style="margin-left:5px" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/BorderImport.js')?>