<style>
	#fixedtop { position:fixed; top:0; left:0; right:0; z-index:2; }
	body.modal-open #fixedtop { right:16px; }

	table { margin-bottom:20px; }
	tr.active th { width:46px; }
	tbody td { height:35px; }

	.todayline { background:red; position:absolute; width:4px; height:176px; margin-left:16px; margin-top:5px; }

	.progress { position:absolute; cursor:pointer; }
	.progress-bar span { display:inline-block; width:100%; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; }
	
	.progress-bar-warning { background-color: darkorange; }
	.progress-bar-success { background-color: #2cb02c; }
	.progress-bar-info { background-color: #3e3e3e; }
    .progress-bar-default { background-color: #9b59b6; }

	.progress-striped.active .progress-bar {
		background-image: -webkit-linear-gradient(45deg, rgba(0, 0, 0, 0.5) 25%, transparent 25%, transparent 50%, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0.5) 75%, transparent 75%, transparent);
		background-image: -o-linear-gradient(45deg, rgba(0, 0, 0, 0.5) 25%, transparent 25%, transparent 50%, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0.5) 75%, transparent 75%, transparent);
		background-image: linear-gradient(45deg, rgba(0, 0, 0, 0.5) 25%, transparent 25%, transparent 50%, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0.5) 75%, transparent 75%, transparent);
	}
	
	.Vanna { color:blue; }
	.Kimleng { color:red; }
	.Rattana { color:green; }
	.Serey { color:darkorange; }
    .Saky { color:darkviolet; }
</style>

<div id="fixedtop" class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh34 font16 form-inline">
			<b>Task</b>

			<select class="form-control" data-bind="value: filter" style="margin-left:10px">
				<option>All</option>
				<option>In Progress</option>
				<option>Done</option>
			</select>
		</div>
		<div class="pull-center">
			<div class="input-group width150">
				<span class="input-group-btn">
					<button class="btn btn-default" data-bind="click: previousYear">
						<i class="glyphicon glyphicon-triangle-left"></i>
					</button>
				</span>
				<input type="text" class="form-control text-center" data-bind="value: year" readonly />
				<span class="input-group-btn">
					<button class="btn btn-default" data-bind="click: nextYear">
						<i class="glyphicon glyphicon-triangle-right"></i>
					</button>
				</span>
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: showNew">New</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
</div>

<div class="panel panel-default" data-bind="visible: true" style="display:none; margin-top:55px; min-width:1518px">
	<div class="panel-body" data-bind="foreach: calendar()">
		<table class="table table-bordered table-hover widthauto" data-bind="attr: { id: moment($data[0]).format('MMM') }">
			<thead>
				<tr class="info">
					<th data-bind="text: moment($data[0]).format('MMMM'), attr: { colspan: moment($data[0]).daysInMonth() + 1 }"></th>
				</tr>
				<tr class="active">
					<th align="center" valign="middle">Name</th>
					<!-- ko foreach: $data -->
					<th align="center" data-bind="css: [0,6].contain(moment($data).day()) ? 'text-danger' : ''">
						<span data-bind="text: moment($data).format('ddd')"></span>
						<br />
						<span data-bind="text: moment($data).date()"></span>

						<div class="todayline" data-bind="visible: $data == $root.today"></div>
					</th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: $root.nameList">
				<tr>
					<th valign="middle" data-bind="text: $data, css: $data"></th>
					<!-- ko foreach: $parent -->
					<td data-bind="with: $root.getInfo($parent, $data)">
						<div class="progress progress-striped active" data-placement="top" data-bind="click: $root.showEdit, style: { width: length }, attr: { title: tooltip }, css: { active: !done }">
							<div class="progress-bar" data-bind="css: color" style="width:100%">
								<span data-bind="text: title"></span>
							</div>
						</div>
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" data-bind="with: editModel">
			<div class="modal-header">
				<h4 class="modal-title text-primary" data-bind="text: Rec_ID() == 0 ? 'New Task' : 'Edit Task'"></h4>
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="control-label col-xs-2">Title:</label>
					<div class="col-xs-10">
						<input type="text" class="form-control" data-bind="value: Title" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Description:</label>
					<div class="col-xs-10">
						<textarea class="form-control" rows="9" data-bind="value: Description" style="resize:vertical"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Name:</label>
					<div class="col-xs-10">
						<select class="form-control width150" data-bind="value: Name, options: $root.nameList, optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Date:</label>
					<div class="col-xs-10 form-inline">
						<input type="text" class="form-control text-center width150" data-bind="datePicker: DateFrom, dataType: 'string', hidden: app.isMobile" />
						<input type="date" class="form-control width150" data-bind="value: DateFrom, visible: app.isMobile" />
						<span style="padding:0 12px">to</span>
						<input type="text" class="form-control text-center width150" data-bind="datePicker: DateTo, dataType: 'string', hidden: app.isMobile" />
						<input type="date" class="form-control width150" data-bind="value: DateTo, visible: app.isMobile" />
						<span class="text-danger" style="padding-left:10px" data-bind="text: dateError()"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Done:</label>
					<div class="col-xs-10">
						<div class="checkbox checkbox-lg">
							<label>
								<input type="checkbox" data-bind="checked: Done" />
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="pull-left" data-bind="visible: Rec_ID() > 0">
					<button class="btn btn-danger width100" data-dismiss="modal" data-bind="click: $root.delete">Delete</button>
				</div>
				<div class="pull-right">
					<button class="btn btn-primary width100" data-bind="click: $root.save">Save</button>
					<button class="btn btn-default width100" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Task.js')?>