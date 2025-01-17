<table class="table table-bordered widthauto">
	<thead class="bg-thead">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Name in Khmer</th>
			<th rowspan="2">Name in English</th>
			<th rowspan="2">Organization</th>
			<th colspan="2">Pre-test Theory</th>
		</tr>
		<tr>
			<th width="100">
				<input type="text" class="text-center" data-bind="textInput: theoryScore" numonly="int" />
			</th>
			<th width="100">%</th>
		</tr>
	</thead>
	<tbody data-bind="foreach: theoryList, fixedHeader: true">
		<tr>
			<td data-bind="text: $index() + 1" align="center"></td>
			<td data-bind="text: NameK" class="kh"></td>
			<td data-bind="text: Name"></td>
			<td data-bind="text: $root.getHCName(Code_Facility_T)" align="center"></td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Score" numonly="int" />
			</td>
			<td data-bind="text: $root.getTheoryPercent($data)" align="center"></td>
		</tr>
	</tbody>
</table>