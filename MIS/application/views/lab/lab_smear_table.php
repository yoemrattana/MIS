<table class="table table-bordered black-border" style="width:max-content">
	<thead>
		<tr fc="1">
			<th rowspan="3" style="background:#B6E0C7" fc="2" width="30">No</th>
			<th rowspan="3" style="background:#B6E0C7" fc="3" width="100" class="text-nowrap">Name in English</th>
			<th colspan="10" style="background:#DDEDF2">Blood Smearing</th>
			<th colspan="7" style="background:#FEE6DE">Smear Staining</th>
			<th rowspan="3" width="50">Total</th>
		</tr>
		<tr>
			<th style="background:#DDEDF2">Smearing</th>
			<th colspan="7" style="background:#DDEDF2">Smear Evaluation Criteria</th>
			<th colspan="2" style="background:#DDEDF2">Total</th>
			<th colspan="5" style="background:#FEE6DE">Staining Evaluation Criteria</th>
			<th colspan="2" style="background:#FEE6DE">Total</th>
		</tr>
		<tr>
			<th width="80" style="background:#DDEDF2">5 slides</th>
			<td width="130" style="background:#DDEDF2">1. is the blood film labeled correctly?</td>
			<td width="130" style="background:#DDEDF2">2. Is the thick film adequate in size?</td>
			<td width="130" style="background:#DDEDF2">3. Does the thick film appear to be of the correct thickness?</td>
			<td width="130" style="background:#DDEDF2">4. Does the thin film appear with a feathered edge?</td>
			<td width="130" style="background:#DDEDF2">5. Is there adequate space between thin and thick film?</td>
			<td width="130" style="background:#DDEDF2">6. Does the thin film appear to have no space/holes?</td>
			<td width="130" style="background:#DDEDF2">7. Is the thin film >/-1.5cm?</td>
			<th width="50" style="background:#DDEDF2">35</th>
			<th width="50" style="background:#DDEDF2">%</th>
			<td width="130" style="background:#FEE6DE">8. Are the WBCs in the thick film properly stained( is the nuclear material purple?</td>
			<td width="130" style="background:#FEE6DE">9. Are the RBCs completely lysed in the thick film?</td>
			<td width="130" style="background:#FEE6DE">10. Do the RBCs in the thin film appear in a single layer towards the feathery edge?</td>
			<td width="130" style="background:#FEE6DE">11. Does the RBC show correct staining (is the color grey-blue?</td>
			<td width="130" style="background:#FEE6DE">12. Do the thick and thin films contain debris or is the background transparent?</td>
			<th width="50" style="background:#FEE6DE">25</th>
			<th width="50" style="background:#FEE6DE">%</th>
		</tr>
	</thead>
	<tbody data-bind="foreach: smearList, fixedHeader: true, fixedColumn: 'manual', fixedLeft: $('.menubox').outerWidth()">
		<tr>
			<td align="center" data-bind="text: $index() + 1" fc></td>
			<td data-bind="text: Name" class="text-nowrap" fc></td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Slide" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question1" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question2" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question3" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question4" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question5" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question6" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question7" numonly="int" />
			</td>
			<td align="center" style="background:#DDEDF2" data-bind="text: $root.getTotalSmear1($data)"></td>
			<td align="center" style="background:#DDEDF2" data-bind="text: $root.getPercentSmear1($data)"></td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question8" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question9" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question10" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question11" numonly="int" />
			</td>
			<td>
				<input type="text" class="text-center" data-bind="textInput: Question12" numonly="int" />
			</td>
			<td align="center" style="background:#FEE6DE" data-bind="text: $root.getTotalSmear2($data)"></td>
			<th align="center" style="background:#FEE6DE" data-bind="text: $root.getPercentSmear2($data)"></th>
			<th align="center" data-bind="text: $root.getGrandTotalSmear($data)"></th>
		</tr>
	</tbody>
</table>