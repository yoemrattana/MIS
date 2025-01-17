
<style>
	.table-hover thead {
		background-color: #9AD8ED;
	}

	.form-control {
		height: auto;
		padding: 2px 5px;
	}

	.space {
		margin-left: 10px;
	}

	.highlight {
		background-color: #ffff99;
		font-weight: bold;
	}

	.width70 {
		width: 70px !important;
	}

	.padding-5 {
		padding: 5px;
	}

	ul li {
		cursor: pointer;
	}
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading">
		<div class="clearfix hidden-print">
			<div class="pull-left" style="width: calc(100% - 120px)">
				<button class="btn minwidth100 hidden" data-bind="click: () => tab('List'), css: tab() == 'List' ? 'btn-info' : 'btn-default'">List</button>
				<button class="btn minwidth100" data-bind="click: () => tab('Setting'), css: tab() == 'Setting' ? 'btn-info' : 'btn-default'">Setting</button>
			</div>
		</div>
	</div>
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list' && tab() == 'List'">
			<div style="display:inline-block">
				<div class="text-bold">Province</div>
				<select data-bind="value: pv,
						options: pvList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: pvList().length == 1 ? undefined : 'All Province'"
					class="form-control input-sm minwidth150"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">OD</div>
				<select data-bind="value: od,
						options: odList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: odList().length == 1 ? undefined : 'All OD'"
					class="form-control input-sm minwidth150"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">HC</div>
				<select data-bind="value: hc,
						options: hcList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: 'All HC'"
					class="form-control input-sm minwidth150"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Year</div>
				<select data-bind="value: year, options: yearList" class="form-control input-sm width70"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Month</div>
				<select data-bind="value: month, options: monthList, optionsCaption: 'All'" class="form-control input-sm width70"></select>
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-default btn-sm width100" data-bind="click: back, visible: view() == 'detail'">Back</button>
			<a href="/Home" data-bind="visible: view() == 'list'" style="margin-left:30px">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>
	
	<div class="panel-body" data-bind="visible: view() == 'list' && tab() == 'List'">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th align="center">Patient Code</th>
					<th align="center">Patient</th>
					<th align="center">Date case</th>
					<th align="center">Entry Date</th>
					<th align="center">OD</th>
					<th align="center">HC</th>
					<th align="center">Village</th>
					<th align="center">Day 3</th>
					<th align="center">Day 3 Date</th>
					<th align="center">Day 7</th>
					<th align="center">Day 7 Date</th>
					<th align="center">Day 14</th>
					<th align="center">Day 14 Date</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: PatientCode" class="kh"></td>
					<td data-bind="text: NameK" align="center"></td>
					<td data-bind="text: moment(DateCase).format('DD-MM-YYYY')" align="center"></td>
					<td data-bind="text: moment(InitTime).format('DD-MM-YYYY')" align="center"></td>
					<td data-bind="text: $root.getODName(Code_OD_T)" class="kh"></td>
					<td data-bind="text: $root.getHCName(Code_Facility_T)" class="kh"></td>
					<td data-bind="text: $root.getVLName(Code_Vill_T)" class="kh"></td>
					<td data-bind="text: Day3 ==1 ? 'Notified' : ''" align="center"></td>
					<td data-bind="text: moment(Day3Date).format('DD-MM-YYYY')" align="center"></td>
					<td data-bind="text: Day7 ==1 ? 'Notified' : ''" align="center"></td>
					<td data-bind="text: moment(Day7Date).format('DD-MM-YYYY')" align="center"></td>
					<td data-bind="text: Day14 ==1 ? 'Notified' : ''" align="center"></td>
					<td data-bind="text: moment(Day14Date).format('DD-MM-YYYY')" align="center"></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: tab() == 'Setting'">
		<div class="pull-right">
			<button class="btn btn-primary btn-sm width100" data-bind="click: $root.saveSetting">Save</button>
		</div>

		<h4>Alert Day Before: </h4>
		<input class="padding-5" type="number" min="1" name="DayBefore" data-bind="textInput: AlertDayBefore" />

		<hr />
		
		<h4>Threshold: </h4>
		<input class="padding-5" type="number" min="1" name="Threshold" data-bind="textInput: Threshold" />

		<hr />

		<h4>Stock Grace Period: </h4>
		<input class="padding-5" type="number" min="1" name="StockGrace" data-bind="textInput: StockGrace" />

		<hr />

		<h4>Species: </h4>

		<div class="dragitems">
			<p>Specie Available Fields:</p>
			<ul id="NotifySpecies-fields">
				<li id="node1f" class="ui-draggable label label-info"> F </li>
				 <li id="node2f" class="ui-draggable label label-info"> V </li>
				 <li id="node3f" class="ui-draggable label label-info"> M </li>
			</ul>
		</div>

		<textarea id="NotifySpecies" class="padding-5" rows="4" cols="150" name="NotifySpecies" data-bind="textInput: NotifySpecies"></textarea>

		<hr />

		<h4>VMW Follow up Template: </h4>

		<div class="dragitems">
			<p>VMW Available Fields:</p>
			<ul id="FollowupVMW-fields">
				<li id="node1" class="ui-draggable label label-info">code</li>
				<li id="node2" class="ui-draggable label label-info">name</li>
				<li id="node3" class="ui-draggable label label-info">sex</li>
				<li id="node4" class="ui-draggable label label-info">age</li>
				<li id="node5" class="ui-draggable label label-info">village</li>
				<li id="node6" class="ui-draggable label label-info">patient_phone</li>
				<li id="node7" class="ui-draggable label label-info">day</li>
				<li id="node8" class="ui-draggable label label-info">follow_up_date</li>
				<li id="node9" class="ui-draggable label label-info">vmw_phone</li>
				<li id="node10" class="ui-draggable label label-info">diagnosis</li>
			</ul>
		</div>

		<div class="dropitems">
			<textarea id="FollowupVMW" class="padding-5 ui-droppable" rows="4" cols="150" name="FollowupVMW" data-bind="textInput: FollowupVMW"></textarea>
		</div>

		<hr />

		<h4>HF Follow up Template: </h4>

		<div class="dragitems">
			<p>HF Available Fields:</p>
			<ul id="FollowupHC-fields">
				<li id="node1" class="ui-draggable label label-info">code</li>
				<li id="node2" class="ui-draggable label label-info">name</li>
				<li id="node3" class="ui-draggable label label-info">sex</li>
				<li id="node4" class="ui-draggable label label-info">age</li>
				<li id="node5" class="ui-draggable label label-info">village</li>
				<li id="node6" class="ui-draggable label label-info">patient_phone</li>
				<li id="node7" class="ui-draggable label label-info">day</li>
				<li id="node8" class="ui-draggable label label-info">follow_up_date</li>
				<li id="node9" class="ui-draggable label label-info">vmw_phone</li>
				<li id="node10" class="ui-draggable label label-info">diagnosis</li>
			</ul>
		</div>

		<textarea id="FollowupHC" class="padding-5" rows="4" cols="150" name="FollowupHC" data-bind="textInput: FollowupHC"></textarea>

		<hr />

		<h4>VMW and HF Template: </h4>

		<div class="dragitems">
			<p>Available Fields:</p>
			<ul id="CaseVmwHc-fields">
				<li id="node1f" class="ui-draggable label label-info">code</li>
				<li id="node2f" class="ui-draggable label label-info">name</li>
				<li id="node3f" class="ui-draggable label label-info">sex</li>
				<li id="node4f" class="ui-draggable label label-info">age</li>
				<li id="node5f" class="ui-draggable label label-info">village</li>
				<li id="node6f" class="ui-draggable label label-info">patient_phone</li>
				<li id="node7f" class="ui-draggable label label-info">diagnosis</li>
			</ul>
		</div>

		<textarea id="CaseVmwHc" class="padding-5" rows="4" cols="150" name="CaseVmwHc" data-bind="textInput: CaseVmwHc"></textarea>

		<hr />

		<h4>OD/PHD/CSO Template (case): </h4>

		<div class="dragitems">
			<p>OD/PHD/CSO Available Fields:</p>
			<ul id="CmiCase-fields">
				<li id="node1f" class="ui-draggable label label-info">code</li>
				<li id="node2f" class="ui-draggable label label-info">name</li>
				<li id="node3f" class="ui-draggable label label-info">sex</li>
				<li id="node4f" class="ui-draggable label label-info">age</li>
				<li id="node5f" class="ui-draggable label label-info">diagnosis</li>
				<li id="node6f" class="ui-draggable label label-info">village</li>
				<li id="node7f" class="ui-draggable label label-info">hc</li>
				<li id="node8f" class="ui-draggable label label-info">od</li>
				<li id="node9f" class="ui-draggable label label-info">province</li>
				<li id="node10f" class="ui-draggable label label-info">entry_by</li>
				<li id="node11f" class="ui-draggable label label-info">patient_phone</li>
				<li id="node12f" class="ui-draggable label label-info">phone</li>
			</ul>
		</div>

		<textarea id="CmiCase" class="padding-5" rows="4" cols="150" name="CmiCase" data-bind="textInput: CmiCase"></textarea>

		<hr />

		<h4>OD/PHD/CSO Template (Foci case): </h4>

		<div class="dragitems">
			<p>OD/PHD/CSO Available Fields:</p>
			<ul id="FociCase-fields">
				<li id="node1f" class="ui-draggable label label-info">code</li>
				<li id="node2f" class="ui-draggable label label-info">name</li>
				<li id="node3f" class="ui-draggable label label-info">sex</li>
				<li id="node4f" class="ui-draggable label label-info">age</li>
				<li id="node5f" class="ui-draggable label label-info">diagnosis</li>
				<li id="node6f" class="ui-draggable label label-info">village</li>
				<li id="node7f" class="ui-draggable label label-info">hc</li>
				<li id="node8f" class="ui-draggable label label-info">od</li>
				<li id="node9f" class="ui-draggable label label-info">province</li>
				<li id="node10f" class="ui-draggable label label-info">entry_by</li>
				<li id="node11f" class="ui-draggable label label-info">patient_phone</li>
				<li id="node12f" class="ui-draggable label label-info">phone</li>
			</ul>
		</div>

		<textarea id="FociCase" class="padding-5" rows="4" cols="150" name="FociCase" data-bind="textInput: FociCase"></textarea>

		<hr />

		<h4>OD/PHD/CSO Template (Foci reminder): </h4>

		<div class="dragitems">
			<p>OD/PHD/CSO Available Fields:</p>
			<ul id="FociReminder-fields">
				<li id="node1f" class="ui-draggable label label-info">code</li>
				<li id="node2f" class="ui-draggable label label-info">name</li>
				<li id="node3f" class="ui-draggable label label-info">sex</li>
				<li id="node4f" class="ui-draggable label label-info">age</li>
				<li id="node5f" class="ui-draggable label label-info">diagnosis</li>
				<li id="node6f" class="ui-draggable label label-info">village</li>
				<li id="node7f" class="ui-draggable label label-info">hc</li>
				<li id="node8f" class="ui-draggable label label-info">od</li>
				<li id="node9f" class="ui-draggable label label-info">province</li>
				<li id="node10f" class="ui-draggable label label-info">entry_by</li>
				<li id="node11f" class="ui-draggable label label-info">patient_phone</li>
				<li id="node12f" class="ui-draggable label label-info">phone</li>
			</ul>
		</div>

		<textarea id="FociReminder" class="padding-5" rows="4" cols="150" name="FociReminder" data-bind="textInput: FociReminder"></textarea>

		<hr />

		<h4>OD/PHD/CSO Template (Reactive case): </h4>

		<div class="dragitems">
			<p>OD/PHD/CSO Available Fields:</p>
			<ul id="ReactiveCase-fields">
				<li id="node1f" class="ui-draggable label label-info">code</li>
				<li id="node2f" class="ui-draggable label label-info">name</li>
				<li id="node3f" class="ui-draggable label label-info">sex</li>
				<li id="node4f" class="ui-draggable label label-info">age</li>
				<li id="node5f" class="ui-draggable label label-info">diagnosis</li>
				<li id="node6f" class="ui-draggable label label-info">village</li>
				<li id="node7f" class="ui-draggable label label-info">hc</li>
				<li id="node8f" class="ui-draggable label label-info">od</li>
				<li id="node9f" class="ui-draggable label label-info">province</li>
				<li id="node10f" class="ui-draggable label label-info">entry_by</li>
				<li id="node11f" class="ui-draggable label label-info">patient_phone</li>
				<li id="node12f" class="ui-draggable label label-info">phone</li>
			</ul>
		</div>

		<textarea id="ReactiveCase" class="padding-5" rows="4" cols="150" name="ReactiveCase" data-bind="textInput: ReactiveCase"></textarea>

		<hr />

		<h4>OD/PHD/CSO Template (Reactive reminder): </h4>

		<div class="dragitems">
			<p>OD/PHD/CSO Available Fields:</p>
			<ul id="ReactiveReminder-fields">
				<li id="node1f" class="ui-draggable label label-info">code</li>
				<li id="node2f" class="ui-draggable label label-info">name</li>
				<li id="node3f" class="ui-draggable label label-info">sex</li>
				<li id="node4f" class="ui-draggable label label-info">age</li>
				<li id="node5f" class="ui-draggable label label-info">diagnosis</li>
				<li id="node6f" class="ui-draggable label label-info">village</li>
				<li id="node7f" class="ui-draggable label label-info">hc</li>
				<li id="node8f" class="ui-draggable label label-info">od</li>
				<li id="node9f" class="ui-draggable label label-info">province</li>
				<li id="node10f" class="ui-draggable label label-info">entry_by</li>
				<li id="node11f" class="ui-draggable label label-info">patient_phone</li>
				<li id="node12f" class="ui-draggable label label-info">phone</li>
			</ul>
		</div>

		<textarea id="ReactiveReminder" class="padding-5" rows="4" cols="150" name="ReactiveReminder" data-bind="textInput: ReactiveReminder"></textarea>

		<hr />

		<h4>OD/PHD/CSO Template (Stock Out): </h4>

		<div class="dragitems">
			<p>OD/PHD/CSO Available Fields:</p>
			<ul id="StockOut-fields">
				<li id="node1f" class="ui-draggable label label-info">items</li>
				<li id="node2f" class="ui-draggable label label-info">hc</li>
				<li id="node3f" class="ui-draggable label label-info">od</li>
				<li id="node4f" class="ui-draggable label label-info">province</li>
				<li id="node5f" class="ui-draggable label label-info">phone</li>
			</ul>
		</div>

		<textarea id="StockOut" class="padding-5" rows="4" cols="150" name="StockOut" data-bind="textInput: StockOut"></textarea>

		<hr />

	</div><!--/Setting-->

</div>

<script
	src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
	integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
	crossorigin="anonymous"></script>

<?=latestJs('/media/ViewModel/Notification.js')?>