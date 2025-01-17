<script type="text/html" id="thead-assessment">
    <thead>
		<tr fc="1">
			<th rowspan="4" fc="2">No</th>
			<th colspan="2" style="background:yellow" fc="3">Slide Number</th>
			<!-- ko foreach: numList() -->
			<th colspan="3" data-bind="text: $data" style="background:yellow"></th>
			<!-- /ko -->
			<th rowspan="2" style="background:#B6E0C7" width="70">True Negative</th>
			<th rowspan="2" style="background:#B6E0C7" width="70">Detection</th>
			<th rowspan="2" style="background:#B6E0C7" width="70">Identification</th>
			<th rowspan="2" style="background:#B6E0C7" width="70">Counting</th>
			<th rowspan="4" style="background:#F4A282">Detection %</th>
			<th rowspan="4" style="background:#F4A282">Identification %</th>
			<th rowspan="4" style="background:#F4A282">Parasite Counting %</th>
		</tr>
		<tr style="background:yellow" fc="4">
			<th colspan="2" fc="5">Correct Diagnosis</th>
			<!-- ko foreach: numList() -->
			<th>
				<select data-bind="value: $root.getHead('Diagnosis1',$data)">
					<option></option>
					<option value="F">PF</option>
					<option value="V">PV</option>
					<option value="A">PM</option>
					<option value="O">PO</option>
					<option value="K">PK</option>
					<option value="N">NMPS</option>
				</select>
			</th>
			<th>
				<select data-bind="value: $root.getHead('Diagnosis2',$data)">
					<option></option>
					<option value="F">PF</option>
					<option value="V">PV</option>
					<option value="A">PM</option>
					<option value="O">PO</option>
					<option value="K">PK</option>
					<option value="N">NMPS</option>
				</select>
			</th>
			<th>
				<select data-bind="value: $root.getHead('Count',$data)">
					<option value="0"></option>
					<option value="1">Count</option>
				</select>
			</th>
			<!-- /ko -->
		</tr>
		<tr fc="6">
			<th colspan="2" rowspan="2" style="background:#9BCAD9" fc="7">Parasite Count</th>
			<!-- ko foreach: numList() -->
			<th style="background:#9BCAD9; min-width:75px">Min</th>
			<th style="background:#9BCAD9; min-width:75px">Mean</th>
			<th style="background:#9BCAD9; min-width:75px">Max</th>
			<!-- /ko -->
			<th style="background:#B6E0C7" data-bind="text: $root.getHead('Negative')"></th>
			<th style="background:#B6E0C7" data-bind="text: $root.getHead('Detection')"></th>
			<th style="background:#B6E0C7" data-bind="text: $root.getHead('Identification')"></th>
			<th style="background:#B6E0C7" data-bind="text: $root.getHead('Counting')"></th>
		</tr>
		<tr>
			<!-- ko foreach: numList() -->
			<th style="background:#9bcad9" data-bind="text: $root.getMin($data)"></th>
			<th style="background:#9bcad9">
				<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getHead('Mean',$data)" />
			</th>
			<th style="background:#9bcad9" data-bind="text: $root.getMax($data)"></th>
			<!-- /ko -->
			<th style="background:#B6E0C7">slide</th>
			<th style="background:#B6E0C7">slide</th>
			<th style="background:#B6E0C7">slide</th>
			<th style="background:#B6E0C7">slide</th>
		</tr>
	</thead>
</script>

<table class="table table-bordered black-border widthauto">
	<!-- ko template: { name: 'thead-assessment' } -->
	<!-- /ko -->

	<tbody data-bind="foreach: staffs, fixedHeader: true, fixedColumn: 'manual', theadTemplate: 'thead-assessment', fixedLeft: $('.menubox').outerWidth()">
		<tr>
			<td align="center" data-bind="text: $index() + 1" fc></td>
			<td data-bind="text: NameK" class="minwidth100 text-nowrap kh" fc></td>
			<td data-bind="text: Name" class="minwidth100 text-nowrap" fc></td>
			<!-- ko foreach: $root.numList() -->
			<td data-bind="css: { correct: $root.isCorrect($parent.Staff_ID,'Diagnosis1',$data) }">
				<select data-bind="value: $root.getValue($parent.Staff_ID,'Diagnosis1',$data)">
					<option></option>
					<option value="F">PF</option>
					<option value="V">PV</option>
					<option value="A">PM</option>
					<option value="O">PO</option>
					<option value="K">PK</option>
					<option value="N">NMPS</option>
				</select>
			</td>
			<td data-bind="css: { correct: $root.isCorrect($parent.Staff_ID,'Diagnosis2',$data) }">
				<select data-bind="value: $root.getValue($parent.Staff_ID,'Diagnosis2',$data)">
					<option></option>
					<option value="F">PF</option>
					<option value="V">PV</option>
					<option value="A">PM</option>
					<option value="O">PO</option>
					<option value="K">PK</option>
					<option value="N">NMPS</option>
				</select>
			</td>
			<td data-bind="css: { correct: $root.isCorrect($parent.Staff_ID,'Count',$data) }">
				<input type="text" class="text-center" data-bind="textInput: $root.getValue($parent.Staff_ID,'Count',$data)" numonly="int" />
			</td>
			<!-- /ko -->
			<td align="center" data-bind="text: $root.getValue(Staff_ID,'Negative')"></td>
			<td align="center" data-bind="text: $root.getValue(Staff_ID,'Detection')"></td>
			<td align="center" data-bind="text: $root.getValue(Staff_ID,'Identification')"></td>
			<td align="center" data-bind="text: $root.getValue(Staff_ID,'Counting')"></td>

			<td align="center" data-bind="text: $root.getPercent(Staff_ID,'Detection')"></td>
			<td align="center" data-bind="text: $root.getPercent(Staff_ID,'Identification')"></td>
			<td align="center" data-bind="text: $root.getPercent(Staff_ID,'Counting')"></td>
		</tr>
	</tbody>
	<tfoot>
		<tr style="background:#F4A282" fc="1">
			<th colspan="3" class="text-nowrap" fc="2">No. of Correct Diagnosis & counted</th>
			<!-- ko foreach: numList() -->
			<th data-bind="text: $root.getTotal('Diagnosis1',$data)"></th>
			<th data-bind="text: $root.getTotal('Diagnosis2',$data)"></th>
			<th data-bind="text: $root.getTotal('Count',$data)"></th>
			<!-- /ko -->
		</tr>
		<tr style="background:#9BCAD9" fc="3">
			<th colspan="3" fc="4">% of Correct</th>
			<!-- ko foreach: numList() -->
			<th data-bind="text: $root.getTotalPercent('Diagnosis1',$data)"></th>
			<th data-bind="text: $root.getTotalPercent('Diagnosis2',$data)"></th>
			<th data-bind="text: $root.getTotalPercent('Count',$data)"></th>
			<!-- /ko -->
		</tr>
	</tfoot>
</table>