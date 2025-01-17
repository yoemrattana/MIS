<style>
	.table thead { background-color: #9AD8ED; }
	.table thead th { text-align: center; }
	.width70 { width: 70px !important; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none; min-width:1300px">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="visible: view() == 'list'">
			<div style="display:inline-block">
				<div class="text-bold">Province</div>
				<select data-bind="value: prov,
						options: provList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: provList().length == 1 ? undefined : 'All Province'" class="form-control input-sm minwidth150"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">OD</div>
				<select data-bind="value: od,
						options: odList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: odList().length == 1 ? undefined : 'All OD'" class="form-control input-sm minwidth150"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Status</div>
				<select data-bind="value: status" class="form-control input-sm width100">
					<option>Requested</option>
					<option>Offered</option>
					<option>Rejected</option>
					<option>Received</option>
				</select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Year</div>
				<select data-bind="value: year, options: yearList" class="form-control input-sm width70"></select>
			</div>
			<div style="display:inline-block">
				<div class="text-bold">Month</div>
				<select data-bind="value: month, options: monthList, optionsValue: 'id', optionsText: 'name', optionsCaption: 'All'" class="form-control input-sm width70"></select>
			</div>
		</div>
		<div class="pull-left lh26" data-bind="visible: view() == 'detail'">
			<b>Health Faciliy:</b>
			<span data-bind="text: detailName"></span>

			<b style="margin-left:30px">Month:</b>
			<span data-bind="text: detailMonth"></span>

			<b style="margin-left:30px">Status:</b>
			<span data-bind="text: status"></span>
		</div>
		<div class="pull-right">
			<a href="/Home" data-bind="visible: view() == 'list'"><img src="/media/images/home_back.png" /></a>
			<button class="btn btn-default btn-sm width100" data-bind="click: back, visible: view() == 'detail'">Back</button>
		</div>
	</div>

	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover" data-bind="visible: view() == 'list'">
			<thead>
				<tr>
					<th width="40">#</th>
					<th>Province</th>
					<th>OD</th>
					<th>HF</th>
					<th>Year</th>
					<th>Month</th>
					<th width="60">Detail</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Name_Prov_E"></td>
					<td data-bind="text: Name_OD_E"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Year" align="center"></td>
					<td data-bind="text: Month" align="center"></td>
					<td class="text-center"><a data-bind="click: $root.detailClick">Detail</a></td>
				</tr>
			</tbody>
			<tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
		</table>

		<table class="table table-bordered table-striped table-hover" data-bind="visible: view() == 'detail'">
			<thead>
				<tr>
					<th width="40">#</th>
					<th>Code</th>
					<th>Item</th>
					<th>Strength</th>
					<th>Unit</th>
					<th class="kh">តុល្យាការ</th>
					<th class="kh">ចំនួនប៉ាន់ប្រមាណ</th>
					<th class="kh">ចំនួនស្នើ</th>
					<th class="kh">ចំនួនផ្តល់អោយ</th>
					<th class="kh">ចំនួនទទួល</th>
					<th>Status</th>
					<th>Comment</th>
					<!-- ko if: status() == 'Requested' && app.user.permiss['Stock Request'].contain('Edit') -->
					<th width="60">Offer</th>
					<th width="60">Reject</th>
					<!-- /ko -->
				</tr>
			</thead>
			<tbody data-bind="foreach: detailList">
				<tr>
					<td data-bind="text: $index() + 1" class="text-center"></td>
					<td data-bind="text: Code"></td>
					<td data-bind="text: Description"></td>
					<td data-bind="text: Strength"></td>
					<td data-bind="text: Unit"></td>
					<td data-bind="text: Balance" align="right"></td>
					<td data-bind="text: Estimate" align="right"></td>
					<td data-bind="text: Request" align="right"></td>
					<td data-bind="text: Offer" align="right"></td>
					<td data-bind="text: Receive" align="right"></td>
					<td data-bind="text: Status"></td>
					<td data-bind="text: Comment"></td>
					<!-- ko if: $root.status() == 'Requested' -->
					<td class="text-center">
						<a data-bind="click: $root.showOffer, visible: Status == 'Requested' && app.user.permiss['Stock Request'].contain('Edit')">Offer</a>
					</td>
					<td class="text-center">
						<a data-bind="click: $root.showReject, visible: Status == 'Requested' && app.user.permiss['Stock Request'].contain('Edit')" class="text-danger">Reject</a>
					</td>
					<!-- /ko -->
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal Offer -->
<div id="modalOffer" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Offer The Rquest</h4>
			</div>
			<div class="modal-body">
				<div class="form-horizontal" data-bind="with: offerModel">
					<div class="form-group form-group-sm">
						<label class="control-label col-xs-3">Offer Quantity:</label>
						<div class="col-xs-9">
							<input type="text" data-bind="value: Offer" class="form-control width100" />
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label class="control-label col-xs-3">Comment:</label>
						<div class="col-xs-9">
							<input type="text" data-bind="value: Comment" class="form-control" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: $root.saveOffer" style="width:100px">Offer</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Reject -->
<div id="modalReject" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Reject The Rquest</h4>
			</div>
			<div class="modal-body">
				<div class="form-horizontal" data-bind="with: rejectModel">
					<div class="form-group form-group-sm">
						<label class="control-label col-xs-3">Comment:</label>
						<div class="col-xs-9">
							<input type="text" data-bind="value: Comment" class="form-control" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger btn-sm" data-dismiss="modal" data-bind="click: $root.saveReject" style="width:100px">Reject</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/StockRequest.js')?>