<style>
    body {
        background-color: #f3f1f196;
    }

    .card {
        box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
        border: 2px solid #01c0c8;
        background: #fff;
    }

    .table td, .table th {
        padding: 6px !important;
        text-align: center;
        vertical-align: middle !important;
    }

    .table tr {
        height:36px;
    }

    .tbl-label {
        vertical-align: middle !important;
    }

    table thead tr th {
        font-family: 'Khmer OS Battambang';
        font-weight: 700;
    }

    .table thead th {
        border-bottom: none;
        vertical-align: middle;
        text-align: center;
        height: 40px;
    }

    .btn-circle {
        border-radius: 100%;
        width: 25px;
        height: 25px;
        padding: 2px;
    }


    .float-left {
        float: left;
    }

    body {
        font-family: 'Koh-Santepheap-Body', 'Open Sans','Battambang', sans-serif, cursive;
    }

    .control-label {
        top: 10px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .pdate {
        position: relative;
    }

    .target {
        width: 2em;
        height: 2em;
        box-sizing: initial;
        background: #fff;
        border: 0.1em solid red;
        text-align: center;
        border-radius: 50%;
        line-height: 2em;
        box-sizing: content-box;
        font-size: 13px;
        padding: 0 8px;
    }

    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }

    input[type=checkbox]
    {
      -ms-transform: scale(2); /* IE */
      -moz-transform: scale(2); /* FF */
      -webkit-transform: scale(2); /* Safari and Chrome */
      -o-transform: scale(2); /* Opera */
      padding: 10px;
    }
</style>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Telegram Group</h4>
				<form>
					<div class="container9">
						<div class="row">
							<div class="col-sm-12">
								<div>
									<a href="/Home" class="btn btn-dark pull-right">
										<i class="fa fa-home"></i> Home
									</a>
									<a style="margin-right:5px;" href="#" class="btn btn-success pull-right" data-bind="click: $root.add">
										<i class="fa fa-save"></i> New
									</a>
									<a style="margin-right:5px;" href="#" class="btn btn-primary pull-right" data-bind="click: $root.sync">
										<i class="fa fa-download"></i> Sync
									</a>
									<a style="margin-right:5px;" href="#" class="btn btn-secondary pull-right" data-bind="click: $root.readMe">
										<i class="fa fa-book"></i> Read Me
									</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- end header -->

<!--List-->
<div class="row">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			<div class="card-body">
				<div class="inbox-center table-responsive">
					<table class="table table-hover no-wrap">
						<thead class="bg-info">
							<tr>
								<th width="40" align="center">#</th>
								<th align="center">ID</th>
								<th align="center">Name</th>
								<th align="center">Province</th>
								<th align="center">OD</th>
								<th align="center">Specie</th>
								<th align="center">Action</th>
                                <th align="center">Activate</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: listModel">
							<tr>
								<td style="text-align:center" data-bind="text: $index() + 1"></td>
								<td style="text-align:center" data-bind="text: ID"></td>
								<td style="text-align:center" data-bind="text: Name"></td>
								<td style="text-align:center" data-bind="text: Code_Prov"></td>
								<td style="text-align:center" data-bind="text: Code_OD"></td>
								<td style="text-align:center" data-bind="text: Specie"></td>
								<td>
                                    <a class="btn btn-success btn-circle" data-bind="click: $root.showMsg">
                                        <i class="fa fa-telegram"></i>
                                    </a>
									<a class="btn btn-secondary btn-circle" data-bind="click: $root.edit">
										<i class="fa fa-pencil"></i>
									</a>
									<!--<a class="btn btn-danger btn-circle" data-bind="click: $root.delete">
										<i class="fa fa-trash"></i>
									</a>-->
								</td>
                                <td>
                                    <div class="form-group" style="margin-bottom:20px">
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" data-bind="checked: IsActive, click: $root.changeStatus"/>
                                            </div>
                                        </div>
                                    </div>
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
			</div>
		</div>
	</div>
</div>

<!-- Modal Add-->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add/Edit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" data-bind="with: model">
				<form id="quiz">
					<div class="form-group">
						<label class="control-label" style="font-size:17px">
							ID
						</label>
						<input type="text" class="form-control" placeholder="ID" data-bind="value: ID"/>
						<span data-bind="validationMessage: ID" class="message-error"></span>
					</div>
					<div class="form-group">
						<label class="control-label" style="font-size:17px">
							Name
						</label>
						<input type="text" class="form-control" placeholder="Name" data-bind="value: Name" />
						<span data-bind="validationMessage: Name" class="message-error"></span>
					</div>
					<hr />
					<div class="form-group form-group-sm" style="float: left">
						<label class="control-label col-xs-3">Province:</label>
						<div class="col-md-12">
							<div style="padding:4px 0">
								<a data-bind="click: () => multiPvList().forEach(r => r.check(true))">Select All</a>
								<a data-bind="click: () => multiPvList().forEach(r => r.check(false))" style="margin-left:20px">Select None</a>
							</div>
							<table data-bind="foreach: multiPvList">
								<tr style="height:33px">
									<td class="hasCheckbox">
										<input type="checkbox" data-bind="checked: check" />
									</td>
									<td style="padding-left:10px">
										<span data-bind="text: name, click: () => check(!check())" style="cursor:pointer"></span>
									</td>
								</tr>
							</table>
							<div id="selectProvince" style="color:#a94442; display:none">
								Please select province at least one.
							</div>
						</div>
					</div>

					<div class="form-group form-group-sm" style="float: right; margin-top: 83px; border: 1px solid #ccc; padding: 5px">
						
						<div data-bind="visible: multiPvList().filter(r=>r.check()).length == 1">
							<label class="control-label col-xs-3">OD:</label>
							<div class="col-md-12">
								<div style="padding:4px 0">
									<a data-bind="click: () => multiOdList().forEach(r => r.check(true))">Select All</a>
									<a data-bind="click: () => multiOdList().forEach(r => r.check(false))" style="margin-left:20px">Select None</a>
								</div>
								<table data-bind="foreach: multiOdList">
                                    <tr style="height:33px">
                                        <td class="hasCheckbox">
                                            <input type="checkbox" data-bind="checked: check" />
                                        </td>
                                        <td style="padding-left:10px">
                                            <span data-bind="text: name, click: () => check(!check())" style="cursor:pointer"></span>
                                        </td>
                                    </tr>
								</table>
								<div id="selectProvince" style="color:#a94442; display:none">
									Please select od at least one.
								</div>
							</div>
						</div>

						<p style="color: red" data-bind="visible: multiPvList().filter(r=>r.check()).length > 1">OD are only available for <br /> only one selected province.</p>

					</div>

					<div class="clearfix"></div>
					<hr />
					<div class="form-group form-group-sm">
						<label class="control-label col-xs-3">Specie:</label>
						<div class="col-xs-9">
							<div style="padding:4px 0">
								<a data-bind="click: () => specieList().forEach(r => r.check(true))">Select All</a>
								<a data-bind="click: () => specieList().forEach(r => r.check(false))" style="margin-left:20px">Select None</a>
							</div>
							<table data-bind="foreach: specieList">
                                <tr style="height:33px">
                                    <td class="hasCheckbox">
                                        <input type="checkbox" data-bind="checked: check" />
                                    </td>
                                    <td style="padding-left:10px">
                                        <span data-bind="text: name, click: () => check(!check())" style="cursor:pointer"></span>
                                    </td>
                                </tr>
							</table>
						</div>
					</div>
				
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-bind="click: $root.save">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Sync-->
<div class="modal fade" id="modalSync" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sync</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-striped table-hover">
					<thead class="bg-info">
						<tr>
							<th width="40" align="center">#</th>
							<th align="center">ID</th>
							<th align="center">Title</th>
							<th align="center">Type</th>
							<th align="center">Date</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: listGroup, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1" class="text-center"></td>
							<td data-bind="text: id" class="kh"></td>
							<td data-bind="text: title" class="kh"></td>
							<td data-bind="text: type" class="kh"></td>
							<td data-bind="text: date"></td>
						</tr>
					</tbody>
					<tfoot data-bind="visible: app.tableFooter($element)">
						<tr>
							<td class="text-center text-warning h4" style="padding:10px">No Data</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Read Me-->
<div class="modal fade" id="modalReadMe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Read Me</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul>
					<li>- Add Bot (Malaria_Cambodia_Bot) to Telegram group</li>
					<li>- Write <code>/start</code> in group chat</li>
					<li>- Click on button Sync (MIS) to view group information</li>
				</ul>
				<hr />
				<div style="text-align: center">
					<img src="/media/images/bot.jpg" alt="bot" width="200"/>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Message-->
<div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 1000px">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="inbox-center table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="bg-info">
                            <tr>
                                <th width="40" align="center">#</th>
                                <th align="center">Group Name</th>
                                <th align="center">Status Code</th>
                                <th align="center">Message</th>
                                <th align="center">Date</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: listMessage">
                            <tr>
                                <td style="text-align:center" data-bind="text: $index() + 1"></td>
                                <td style="text-align:center" data-bind="text: GroupName"></td>
                                <td style="text-align:center" data-bind="text: StatusCode"></td>
                                <td style="text-align:left" data-bind="text: Message"></td>
                                <td style="text-align:center" data-bind="text: $root.formatDate(InitTime)"></td>
                            </tr>
                        </tbody>
                        <tfoot data-bind="visible: app.tableFooter($element)">
                            <tr>
                                <td class="text-center text-warning h4" style="padding:10px">No Data</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?=latestJs('/media/ViewModel/TeleGroup.js')?>