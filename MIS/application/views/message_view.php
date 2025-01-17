
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

	.table tr td {
		text-align: left;
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
</style>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Messenger</h4>
				<form>
					<div class="container9">
						<div class="row">
							<div class="col-sm-12">
								<div data-bind="visible: $root.view() == 'list'">
									<a href="/Home" class="btn btn-dark pull-right">
										<i class="fa fa-home"></i> Home
									</a>
									
								</div>
								<div data-bind="visible: $root.view() == 'detail'">
									<a class="btn btn-dark pull-right" data-bind="click: () => $root.view('list')">
										<i class="fa fa-backward"></i> Back
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
<div class="row" data-bind="visible: $root.view() == 'list'" style="display: none">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			<div class="card-body">
				<div class="inbox-center table-responsive">
					<table class="table table-hover no-wrap">
						<thead class="bg-info">
							<tr >
								<th width="40" align="center">#</th>
								<th align="center">Place</th>
								<th align="center">Message</th>
								<th align="center">Init Date</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: listModel">
							<tr data-bind="click: $root.viewDetail" class="unread">
								<td data-bind="text: $index() + 1"></td>
								<td data-bind="text: Place"></td>
								<td class="max-texts">
									<a href="#"></a>
									<span class="label label-info m-r-10" data-bind="text: Label"></span>
									<span data-bind="text: Text"></span>
								</td>
								<td class="text-right" data-bind="text: InitTime"></td>
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

<!-- detail -->
<div class="row" data-bind="visible: $root.view() == 'detail'" style="display: none">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			<div class="card-body">​
				<div class="chat-right-aside">
					<div class="chat-main-header">
						<div class="p-3 b-b">
							<h4 class="box-title">Chat Message</h4>
						</div>
					</div>
					<div class="chat-rbox ps ps--theme_default" data-ps-id="d1078392-175a-c4b0-abfb-f49780c0eef2">
						<ul class="chat-list p-3" data-bind="foreach: detail">
							<!--chat Row -->
							<li data-bind="if: !isCNM">
								<div class="chat-img">
									<img src="../media/images/avatar2.png" alt="user" />
								</div>
								<div class="chat-content">
									<h5 data-bind="text: Place"></h5>
									<div class="box bg-light-info" data-bind="text: Text"></div>
									<div class="chat-time" data-bind="text: InitTime"></div>
								</div>
							</li>
							
							<!--chat Row -->
							<li class="reverse" data-bind="if: isCNM">
								<div class="chat-content">
									<h5 data-bind="text: Place"></h5>
									<div class="box bg-light-inverse" data-bind="text: Text"></div>
									<div style="text-align: right" class="chat-time" data-bind="text: InitTime"></div>
								</div>
								<div class="chat-img">
									<img src="../media/images/avatar1.png" alt="user" />
								</div>
							</li>
							
							<!--chat Row -->
						</ul>
						<div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;">
							<div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
						</div>
						<div class="ps__scrollbar-y-rail" style="top: 0px; right: 0px;">
							<div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
						</div>
					</div>
					<div class="card-body border-top">
						<div class="row">
							<div class="col-8">
								<textarea placeholder="Type your message here" class="form-control border-0" data-bind="value: textReply"></textarea>
								<span data-bind="validationMessage: textReply" class="message-error"></span>
							</div>
							<div class="col-4 text-right">
								<button type="button" class="btn btn-info btn-circle btn-lg" data-bind="click: $root.reply">
									<i class="fa fa-send"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?=latestJs('/media/ViewModel/Message.js')?>