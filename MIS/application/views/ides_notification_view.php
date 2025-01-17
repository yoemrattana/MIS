<!-- ko if: menu() == 'Notification' -->
<!-- ko with: notification -->
<div class="panel-body" data-bind="visible: listModel().length > 0">
	<table class="table table-bordered widthauto">
		<thead class="bg-thead">
			<tr>
				<th align="center">#</th>
				<th>Place</th>
				<th>Message</th>
				<th align="center">Type</th>
				<th>Notification Date</th>
			</tr>
		</thead>
		<tbody data-bind="foreach: listModel">
			<tr>
				<td data-bind="text: $index() + 1" align="center"></td>
				<td data-bind="text: Place"></td>
				<td data-bind="text: Message"></td>
				<td data-bind="text: Type" align="center"></td>
				<td data-bind="text: InitDate" align="center"></td>
			</tr>
		</tbody>
	</table>
</div>
<!-- /ko -->
<!-- /ko -->