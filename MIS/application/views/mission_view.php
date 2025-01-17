<style>
	#fixedtop { position:fixed; top:0; left:0; right:0; z-index:2; }
	body.modal-open #fixedtop { right:16px; }

	table { margin-bottom:20px; }
	tr.active th { width:46px; }
	tbody td { height:35px; }

	.todayline { background:red; position:absolute; width:4px; height:246px; margin-left:16px; margin-top:5px; }

	.progress { position:absolute; cursor:pointer; }
	.progress-bar span { /*display:inline-block;*/ width:100%; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; }
	
	.progress-bar-warning { background-color: darkorange; }
	.progress-bar-success { background-color: #2cb02c; }
	.progress-bar-info { background-color: #3e3e3e; }
    .progress-bar-default { background-color: #7158e2; }
	
	.Pengby { color:black; }
	.Vanna { color:blue; }
	.Kimleng { color:red; }
	.Rattana { color:green; }
	.Serey { color:darkorange; }
    .Saky { color:darkviolet; }

	#textMeasure { visibility:hidden; position:absolute; }

    .badge-done {
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        color: #ffffff;
        line-height: 1;
        vertical-align: middle;
        white-space: nowrap;
        text-align: center;
        background-color: #b8e994;
        border-radius: 10px;
    }
    .badge-plan {
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        color: #ffffff;
        line-height: 1;
        vertical-align: middle;
        white-space: nowrap;
        text-align: center;
        background-color: #b71540;
        border-radius: 10px;
    }
    .badge-official {
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        color: #ffffff;
        line-height: 1;
        vertical-align: middle;
        white-space: nowrap;
        text-align: center;
        background-color: #fad390;
        border-radius: 10px;
    }
    .badge-cancel {
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        color: #ffffff;
        line-height: 1;
        vertical-align: middle;
        white-space: nowrap;
        text-align: center;
        background-color: #3c6382;
        border-radius: 10px;
    }
</style>

<div id="fixedtop" class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh34 font16">
			<b>Mission</b>
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
            <button class="btn" style="background: #badc58" data-bind="click: $root.getQuarter">Trip By Quarterly</button>
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
						<div class="progress progress-striped active" data-bind="click: $root.showEdit, style: { width: length }, attr: { title: tooltip, 'data-placement': place }">
							<div class="progress-bar" data-bind="css: color" style="width:100%">
								<span data-bind="text: prov"></span>
                                <span class="badge-done" data-bind="text: status, visible: status == 'Done'"></span>
                                <span class="badge-plan" data-bind="text: status, visible: status == 'Plan'"></span>
                                <span class="badge-official" data-bind="text: status, visible: status == 'Official'"></span>
                                <span class="badge-cancel" data-bind="text: status, visible: status == 'Cancel'"></span>
							</div>
						</div>
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!--Form-->
<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width:660px">
		<div class="modal-content" data-bind="with: editModel">
			<div class="modal-header">
				<h4 class="modal-title text-primary" data-bind="text: Rec_ID() == 0 ? 'New Mission' : 'Edit Mission'"></h4>
			</div>
			<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="control-label col-xs-2">Name:</label>
					<div class="col-xs-10 form-inline">
						<select class="form-control" data-bind="value: Name, options: $root.nameList, optionsCaption: ''"></select>
						<!-- ko if: Rec_ID() == 0 -->
						<select class="form-control" data-bind="value: Name2, options: $root.nameList, optionsCaption: ''"></select>
						<select class="form-control" data-bind="value: Name3, options: $root.nameList, optionsCaption: ''"></select>
						<select class="form-control" data-bind="value: Name4, options: $root.nameList, optionsCaption: ''"></select>
						<select class="form-control" data-bind="value: Name5, options: $root.nameList, optionsCaption: ''"></select>
						<!-- /ko -->
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
					<label class="control-label col-xs-2">Province:</label>
					<div class="col-xs-10 form-inline">
						<select class="form-control" style="width:170px" data-bind="value: Code_Prov_T, options: $root.pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						<select class="form-control" style="width:170px" data-bind="value: Code_Prov_T2, options: $root.getPvList2(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Driver:</label>
					<div class="col-xs-10">
						<div class="input-group" style="width:344px">
							<input type="text" class="form-control" data-bind="value: Driver" />
							<span class="input-group-addon">Optional</span>
						</div>
					</div>
				</div>
                <div class="form-group">
                    <label class="control-label col-xs-2">Status:</label>
					<div class="col-xs-10 form-inline">
                        <select class="form-control" data-bind="value: Status, options: $root.statusList, optionsCaption: ''"></select>
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

<!--Summary Quarterly-->
<div id="modalQuarter" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:660px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary" > Trip by Quarterly <span data-bind="text: year()"></span></h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th align="center">#</th>
                            <th align="center">Name</th>
                            <th align="center">Q1</th>
                            <th align="center">Q2</th>
                            <th align="center">Q3</th>
                            <th align="center">Q4</th>
                            <th align="center">Total</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: quarterList">
                        <tr>
                            <td align="center" data-bind="text: $index() +1"></td>

                            <td align="center" > <span data-bind="text: Name"></span> <img data-bind="visible: $index() ==0" src="\media\images\crown.png"  width="30" /></td>

                            <td align="center" data-bind="text: Q1"></td>
                            <td align="center" data-bind="text: Q2"></td>
                            <td align="center" data-bind="text: Q3"></td>
                            <td align="center" data-bind="text: Q4"></td>
                            <td align="center" data-bind="text: Total"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default width100" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<span id="textMeasure"></span>

<?=latestJs('/media/ViewModel/Mission.js')?>