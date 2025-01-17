<style>
	 body {
        font-family: 'Koh-Santepheap-Body', 'Open Sans','Battambang', sans-serif, cursive;
    }

	* { box-sizing: border-box }

	.radius-right {
		border-radius: unset;
		border-top-right-radius: 20px;
	}

	.btn-tab {
		font-weight:800 !important;
		font-size:16px !important;
	}

	.box-shadow {
		box-shadow: 0 0 10px rgba(0,0,0,.15), 0 3px 3px rgba(0,0,0,.15);
	}
</style>

<div class="row" style="">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Broadcast message</h4>
				<form>
					<div class="container9">
						<div class="row">
							<div class="col-sm-4">
								<div class="button-group">
									<button type="button" data-bind="click: $root.menuClick"  class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow active">Log</button>
									<button type="button" data-bind="click: $root.menuClick" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Message</button>
								</div>
							</div>
							<div class="col-sm-8">
								<a href="/Home" class="btn btn-dark pull-right"> Home</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Log list -->
<div class="row" data-bind="visible: $root.tab() == 'Log'" style="display:none">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th width="40" align="center">#</th>
							<th>Title</th>
							<th align="center">Recipient</th>
							<th align="center">Message</th>
							<th align="center">Date</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: listModel, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1"></td>
							<td data-bind="text: Title"></td>
							<td data-bind="text: Recipient"></td>
							<td data-bind="text: Message"></td>
							<td data-bind="text: $root.dateFormat(InitTime)"></td>
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

<!-- Form -->
<div class="row" data-bind="visible: $root.tab() == 'Message'" style="display:none">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="#">
					<div style="width: 480px" class="container form-body">
						<h3 class="card-title">
							Message
						</h3>
						<hr />
						<div class="row p-t-20">
							<div class="col-md-12" data-bind="with: message">
								<div class="form-group">
									<label class="control-label">
										Title
									</label>
									<input type="text" class="form-control" data-bind="value: title"/>
								</div>

								<div class="form-group">
									<label class="control-label">
										Receipient
									</label>
									<select class="form-control custom-select" data-bind="value: recipient">
										<option value="">Select Recipient</option>
										<option value="all">All</option>
										<option value="cmi">CMI</option>
										<option value="hc">HC</option>
										<option value="vmw">VMW</option>
									</select>
								</div>

								<div class="form-group" data-bind="visible: recipient() == 'cmi'">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="logedin" name="logedin" value="logedin" data-bind="checked: logedin">
										<label class="custom-control-label" for="logedin">Only Loged in user</label>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label">
										Message text
									</label>
									<textarea rows="4" cols="50" class="form-control" data-bind="value: body"></textarea>
								</div>
							</div>
						</div>
					</div><!--/form-body end-->
					<div style="width: 480px" class="container form-actions">
						<button type="submit" class="btn btn-success" data-bind="click: $root.send">
							<i class="fa fa-check"></i> Send
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?=latestJs('/media/ViewModel/Broadcast.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>