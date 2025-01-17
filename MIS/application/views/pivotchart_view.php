<style>
	body { overflow: hidden; }
	.panel { position: absolute; left: 0; top: 0; bottom: 29px; width: calc(100% - 364px); }
	.panel-heading { height: 50px; max-height: 50px; user-select: none; }
	.panel-body { padding: 0; height: calc(100% - 50px); }

	.splitbar { position: absolute; right: 350px; top: 0; bottom: 0; cursor: e-resize; background-color: #d4f1f9; }
	.splitbar div { width: 2px; height: 100%; background-color: #aaa; margin: 0 4px 0 8px; }

	.displaybox { padding: 4px; overflow: scroll; height: 100%; position: relative; }
	.controlbox { width: 350px; background-color: #d4f1f9; position: absolute; right: 0; top: 0; bottom: 30px; user-select:none; }
	.filterbox, .chartbox { padding: 4px; overflow-y: auto; overflow-x:hidden; height: calc(100% - 35px); }
	.pivotbox { height: calc(100% - 35px); overflow-y: auto; overflow-x: hidden; padding-left: 12px; padding-right: 15px; }
	.fieldbox { position: absolute; top: 35px; bottom: 4px; left: 4px; right: calc(50% + 11px); }

	.displaybox thead { user-select: none; cursor: text; }
	.displaybox thead th.active { background-color: #ffff99 !important; }
	.displaybox th, .displaybox td { padding: 3px !important; min-width: 50px; height: 27px; }

	.tabbox { margin-left: 4px; padding: 4px; border-bottom: 1px solid #ddd; background-color: white; }
	.btn-group .active { font-weight: bold; }
	.input-sm { font-size: 14px; }
	select.input-sm { padding: 2px; }

	.row .col-xs-6:first-child { padding-right: 4px; }
	.row .col-xs-6:last-child { padding-left: 4px; }
	.listbox { background-color: white; border: 1px solid #ccc; overflow-y: auto; height: 195px; }
	.listbox.lg { height: calc(100% - 19px); }

	.listitem { border: 1px solid #ccc; background: white; margin: 2px; padding: 0 2px; cursor: default; }
	.listitem-place { height: 3px; background: green; }
	.listbox .listitem { word-break: break-word; }
	.listbox .listitem:hover { background-color: #ffff99; }
	body > .listitem { white-space: nowrap; }

	.ctmenu { position: absolute; border: 1px solid #aaa; background-color: white; white-space: nowrap; user-select: none; display: none; }
	.ctmenu .item { padding: 4px 10px;}
	.ctmenu .item:hover { background-color: #ffff99; }
	.ctmenu .item span:first-child { visibility: hidden; margin-right: 4px; }
	.ctmenu .item.active span:first-child { visibility: visible; }
	.ctmenu .item.active span:last-child { font-weight: bold; }

	.filtermenu { position: absolute; bottom: 60px; min-width: 200px; max-width: 300px; display: none; }
	.filtermenu .search { border: 1px solid #aaa; background: white; padding: 4px; }
	.filtermenu .list { border: 1px solid #aaa; border-top: none; background: white; overflow-x: hidden; overflow-y: auto; padding: 4px; max-height: calc(100% - 36px); user-select:none; }
	.filtermenu .checkbox { margin: 0 0 2px; }
	.filtermenu .checkbox input[type="checkbox"] { margin-top: 3px; }

	.celleditor { position: absolute; font-weight: bold; border: none; text-align: center; }
	#chartboard { border: 1px solid black; height: 500px; }

	body > .listitem, .ctmenu, .filtermenu .search, .filtermenu .list { box-shadow: 4px 4px 4px rgba(0,0,0,.2); }

	.filterdisplay .input-group-addon { font-size: 14px; line-height: normal; background-color: white; }
	#modalJoinFilter td { border: none; }
</style>

<div class="panel panel-default" data-bind="visible: true, event: { contextmenu: rightClick }" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left text-center" style="margin-top:-10px" data-bind="visible: tab() == 'Pivot Table'">
			<span>Decimal</span>
			<div class="input-group input-group-sm" style="width:100px">
				<span class="input-group-btn">
					<button data-bind="click: () => changeDecimal(-1)" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-left"></i>
					</button>
				</span>
				<input data-bind="value: decimal" type="text" class="form-control text-center" style="background:white;cursor:default" readonly />
				<span class="input-group-btn">
					<button data-bind="click: () => changeDecimal(1)" class="btn btn-default">
						<i class="glyphicon glyphicon-triangle-right"></i>
					</button>
				</span>
			</div>
		</div>
		<div class="pull-left" style="margin-left:20px" data-bind="visible: tab() == 'Pivot Table' && pivot() != null">
			<button class="btn btn-sm btn-default" data-bind="click: joinFitlerClick">Join Filter</button>
		</div>
		<div class="pull-right">
			<button class="btn btn-success btn-sm" data-bind="click: exportExcel">Export Excel</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<div class="displaybox" data-bind="with: pivot">

			<div class="filterdisplay form-group form-inline" data-bind="visible: $root.tab() == 'Pivot Table' && (filterList().length > 0 || joinFilterList().length > 0)">
				<b>Filter:</b>
				<!-- ko foreach: filterList -->
				<button class="btn btn-default btn-sm" data-bind="click: $root.showFitlerMenu">
					<span data-bind="text: name + filterText()"></span>
					<span class="caret"></span>
				</button>
				<!-- /ko -->

				<!-- ko foreach: joinFilterList -->
				<div class="input-group input-group-sm">
					<span class="input-group-addon" data-bind="text: text"></span>
					<span class="input-group-btn">
						<button class="btn btn-default text-default" data-bind="click: $parent.removeJoinFilter">╳</button>
					</span>
				</div>
				<!-- /ko -->
			</div>

			<table class="table table-bordered widthauto" data-bind="visible: $root.tab() == 'Pivot Table'">
				<thead data-bind="foreach: tableHead">
					<tr data-bind="foreach: $data">
						<th data-bind="text: text, click: $root.cellEditor.edit,
							attr: { rowspan: rowspan, colspan: colspan },
							event: { contextmenu: $root.showContextMenu }" align="center" valign="middle"></th>
					</tr>
				</thead>
				<tbody data-bind="foreach: getTableBody, event: { contextmenu: $root.showContextMenu }">
					<tr data-bind="foreach: $data">
						<td data-bind="text: $root.checkValue($data), css: { 'text-right': typeof $data == 'number' }"></td>
					</tr>
				</tbody>
				<tbody data-bind="if: tableBody().length > $root.displayRow()">
					<tr>
						<td data-bind="attr: { colspan: tableBody()[0].length }" align="center">
							<span>Display:</span>
							<span data-bind="if: $root.displayRow() < 200">
								<a data-bind="click: () => $root.displayRow(200)">More rows</a>
								<span>,</span>
							</span>
							<a data-bind="click: () => $root.displayRow(undefined)">All rows</a>
						</td>
					</tr>
				</tbody>
				<tfoot data-bind="if: tableBody().length > 1">
					<tr>
						<th data-bind="attr: { colspan: rowList().length }">Grand Total</th>
						<!-- ko foreach: tableFoot -->
						<th data-bind="text: $root.checkValue($data)" align="right"></th>
						<!-- /ko -->
					</tr>
				</tfoot>
			</table>

			<div id="chartboard" data-bind="visible: $root.tab() == 'Chart'"></div>

			<!-- ko with: $root.cellEditor -->
			<input data-bind="textInput: value().text,
				   visible: editing, hasFocus: editing,
				   event: { keydown: onKeydown }" type="text" class="celleditor" />
			<!-- /ko -->
		</div>
	</div>
</div>

<div class="controlbox">
	<div class="tabbox">
		<div class="btn-group btn-group-sm btn-group-justified" data-bind="foreach: ['Pre Filter','Pivot Table','Chart']">
			<a data-bind="text: $data, click: $root.tabClick,
			   css: { active: $root.tab() == $element.innerHTML },
			   attr: { disabled: $data != 'Filter' && $root.pivot() == null }" class="btn btn-default"></a>
		</div>
	</div>

	<div class="filterbox" data-bind="visible: tab() == 'Pre Filter'">
        <div class="form-group" style="margin-top:20px">
			<div class="btn-group btn-group-sm btn-group-justified">
			    <a class="btn btn-default" data-bind="css: { active: !isCountry() }, click: () => isCountry(false)">Endemic Area</a>
			    <a class="btn btn-default" data-bind="css: { active: isCountry() }, click: () => isCountry(true)">Whole country</a>
		    </div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6">
				<div>From</div>
				<input type="text" data-bind="datePicker: dateFrom, format: 'MMM YYYY', minDate: '2018-01', maxDate: moment()" class="form-control input-sm text-center" />
			</div>
			<div class="col-xs-6">
				<div>To</div>
				<input type="text" data-bind="datePicker: dateTo, format: 'MMM YYYY', minDate: '2018-01', maxDate: moment()" class="form-control input-sm text-center" />
			</div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6">
				<div>Province</div>
				<select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length == 1 ? undefined : 'All'"></select>
			</div>
			<div class="col-xs-6">
				<div>OD</div>
				<select class="form-control input-sm" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: odList().length == 1 ? undefined : 'All'"></select>
			</div>
		</div>
		<div class="text-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: submitClick">Submit</button>
		</div>
	</div>

	<div class="fieldbox" data-bind="visible: tab() == 'Pivot Table', with: pivot">
		<div>Fields</div>
		<div class="listbox lg" data-bind="foreach: fieldList, event: { contextmenu: $root.rightClick }" id="fieldList">
			<div class="listitem" data-bind="text: name, event: { 
                 mousedown: $root.itemMousedown,
                 touchstart: $root.itemMousedown,
                 contextmenu: $root.rightClick }"></div>
		</div>
	</div>

	<div class="pivotbox" data-bind="visible: tab() == 'Pivot Table', with: pivot">
		<div class="row">
			<div class="col-xs-6 col-xs-offset-6">
				<div>Columns</div>
				<div class="listbox" data-bind="foreach: columnList, event: { contextmenu: $root.rightClick }" id="columnList">
					<div data-bind="text: name, event: {
							mousedown: $root.itemMousedown,
                            touchstart: $root.itemMousedown,
							contextmenu: $root.showContextMenu }"
						class="listitem"></div>
				</div>

				<div>Rows</div>
				<div class="listbox" data-bind="foreach: rowList, event: { contextmenu: $root.rightClick }" id="rowList">
					<div data-bind="text: name, event: {
							mousedown: $root.itemMousedown,
                            touchstart: $root.itemMousedown,
							contextmenu: $root.showContextMenu }"
						class="listitem"></div>
				</div>

				<div>Values</div>
				<div class="listbox" data-bind="foreach: valueList, event: { contextmenu: $root.rightClick }" id="valueList">
					<div data-bind="text: name + ' (' + formula() + ')', event: {
							mousedown: $root.itemMousedown,
                            touchstart: $root.itemMousedown,
							contextmenu: $root.showContextMenu }"
						class="listitem"></div>
				</div>

				<div>Filters</div>
				<div class="listbox" data-bind="foreach: filterList, event: { contextmenu: $root.rightClick }" id="filterList">
					<div data-bind="text: name, event: {
							mousedown: $root.itemMousedown,
                            touchstart: $root.itemMousedown,
							contextmenu: $root.showContextMenu }"
						class="listitem"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="chartbox" data-bind="visible: tab() == 'Chart', with: chart">
		<div class="form-group">
			<div>Chart Title</div>
			<input type="text" class="form-control input-sm" data-bind="textInput: chartTitle" />
		</div>
		<div class="form-group">
			<div>Chart Type</div>
			<select class="form-control input-sm" data-bind="value: chartType">
				<option value="spline">Line</option>
				<option value="column">Column</option>
				<option value="bar">Bar</option>
				<option value="pie">Pie</option>
			</select>
		</div>
		<div class="form-group">
			<div>Series Selection</div>
			<select class="form-control input-sm" data-bind="value: seriesType">
				<option value="row">Use rows in pivot table as series</option>
				<option value="column">Use columns in pivot table as series</option>
			</select>
		</div>
		<div class="form-group" data-bind="visible: chartType().in('column','bar')">
			<div>Stacking</div>
			<select class="form-control input-sm" data-bind="value: stacking">
				<option value="no">No</option>
				<option value="normal">Normal</option>
				<option value="percent">Percentage</option>
			</select>
		</div>
		<div class="form-group">
			<div>Display Data Label</div>
			<select class="form-control input-sm" data-bind="value: dataLabel">
				<option value="yes">Yes</option>
				<option value="no">No</option>
			</select>
		</div>

		<!-- ko if: chartType() == 'spline' || (chartType().in('column','bar') && stacking() == 'no') -->
		<div class="form-group">
			<div>Y Axis Label</div>
			<input type="text" class="form-control input-sm" data-bind="textInput: YLabel" />
		</div>
		<div class="form-group" style="border:1px solid black; padding:8px;">
			<div class="form-group">
				<div>Use Second Y Axis</div>
				<select class="form-control input-sm" data-bind="value: secondY, options: secondYList, optionsCaption: 'No'"></select>
			</div>
			<div class="form-group">
				<div>Second Y Axis Label</div>
				<input type="text" class="form-control input-sm" data-bind="textInput: secondYLabel" />
			</div>
			<div >
				<div>Second Chart type</div>
				<select class="form-control input-sm" data-bind="value: secondChartType, options: secondChartTypeList, optionsValue: 'key', optionsText: 'text'"></select>
			</div>
		</div>
		<!-- /ko -->
	</div>
</div>

<div class="splitbar">
	<div></div>
</div>

<div class="ctmenu">
	<div class="sort">
		<div class="item" type="sort" id="asc">
			<span>●</span>
			<span>Sort Ascending</span>
		</div>
		<div class="item" type="sort" id="desc">
			<span>●</span>
			<span>Sort Descending</span>
		</div>
	</div>
	<div class="formula" data-bind="foreach: ['Sum','Count','Avg','Max','Min']">
		<div class="item" type="formula" data-bind="attr: { id: $data }">
			<span>●</span>
			<span data-bind="text: $data"></span>
		</div>
	</div>
</div>

<div class="filtermenu" data-bind="with: pivot">
	<div class="search">
		<input type="text" class="input-block" placeholder="Search" data-bind="textInput: filterMenu.search" />
	</div>
	<div class="list" data-bind="with: filterMenu">
		<div class="clearfix" data-bind="visible: search() == ''">
			<div class="pull-left">
				<a data-bind="click: list().forEach(r => r.checked(true))">Select All</a>
			</div>
			<div class="pull-right">
				<a data-bind="click: list().forEach(r => r.checked(false))">Deselect All</a>
			</div>
		</div>
		<!-- ko foreach: list -->
		<div class="checkbox">
			<label>
				<input type="checkbox" data-bind="checked: checked, click: $parent.checkClick" />
				<span data-bind="text: isempty(value, '(Blank)')"></span>
			</label>
		</div>
		<!-- /ko -->
	</div>
</div>

<!-- Modal Join Filters -->
<div id="modalJoinFilter" class="modal" tabindex="-1" role="dialog" data-bind="with: joinFilter">
    <div class="modal-dialog">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <h4 class="modal-title text-primary">Join Filter</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-left:5px">
                    <div class="btn-group btn-group-sm">
						<a data-bind="click: () => mode('Only'), css: { active: mode() == 'Only' }" class="btn btn-default width100">Only</a>
						<a data-bind="click: () => mode('Exclude'), css: { active: mode() == 'Exclude' }" class="btn btn-default width100">Exclude</a>
					</div>
                </div>
				<table class="table">
					<tbody data-bind="foreach: list">
						<tr>
							<td>
								<select data-bind="value: field, options: $parent.fields, optionsCaption: ''" class="form-control input-sm"></select>
							</td>
							<td>
								<select data-bind="value: operator, options: $parent.operators, optionsValue: 'value', optionsText: 'text'" class="form-control input-sm"></select>
							</td>
							<td>
								<input type="text" class="form-control input-sm" data-bind="value: value" />
							</td>
						</tr>
					</tbody>
				</table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm width100" data-dismiss="modal" data-bind="click: okClick">OK</button>
                <button class="btn btn-default btn-sm width100" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Loading -->
<div class="modal" id="modalLoading" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="min-width:600px; max-width:600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Data Loaded: 10 / 10 (100%)</h3>
			</div>
			<div class="modal-body no-padding-horizontal">
				<img src="/media/images/waiting.gif" />
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/pivotchart.js')?>