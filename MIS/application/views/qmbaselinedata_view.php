<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<h3 class="text-center text-bold">BASELINE DATA FORM v0.1</h3>
	<div class="text-center text-bold">Impact study of the Standard<sup>TM</sup> Q Malaria/CRP Duo Test</div>
	<br />

	<table class="table table-bordered widthauto" style="margin:auto">
		<tr>
			<td width="170" align="center" valign="middle">Document Number</td>
			<td width="200">
				<input type="text" class="form-control text-center numonly" data-bind="value: DocNumber" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="4" class="text-bold bg-info">A. General information</td>
		</tr>
		<tr>
			<td valign="middle">1. Name of HC</td>
			<td>
				<input type="text" class="form-control" data-bind="value: $root.getHCNameE(Code_Facility_T()), click: $parent.choosePlace" />
			</td>
			<td valign="middle">2. Site code</td>
			<td data-bind="text: Code_Facility_T"></td>
		</tr>
		<tr>
			<td valign="middle">3. Date of data entry (dd/mm/yy)</td>
			<td class="relative">
				<input type="text" class="form-control text-center width150" data-bind="datePicker: DataEntryDate, format: 'DD/MM/YY'" />
			</td>
			<td valign="middle">4. Data entry staff initials</td>
			<td>
				<input type="text" class="form-control" data-bind="value: DataEntryUser" />
			</td>
		</tr>
	</table>
	<br />

	<div class="form-group table-bordered bg-info" style="padding:5px">
		<b>B. Data records for febrile partients</b> NOTE: record data ONLY for patients with fever (T° ≥37.5°C) or reported history of fever
	</div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<td>Date (dd/mm/yy)</td>
				<td>Patient number</td>
				<td width="130">Reported fever?</td>
				<td width="230">Malaria RDT?</td>
				<td width="200">If RDT positive, malaria species?</td>
				<td width="130">Treated with antimalarial?</td>
				<td width="130">Treated with antibiotic?</td>
				<td width="60"></td>
			</tr>
		</thead>
		<tbody data-bind="foreach: $root.detailListModel" id="tbllist">
			<tr>
				<td class="relative">
					<input type="text" class="form-control text-center" data-bind="datePicker: DateCase, format: 'DD/MM/YY', allowKeyboard: true" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: PatientCode" />
				</td>
				<td align="center" valign="middle">
					<label class="radio-inline radio-lg">
						<input type="radio" value="yes" data-bind="checked: Fever, attr: { name: 'Fever' + Rec_ID }" />
						<span>yes</span>
					</label>
					<label class="radio-inline radio-lg">
						<input type="radio" value="no" data-bind="checked: Fever, attr: { name: 'Fever' + Rec_ID }" />
						<span>no</span>
					</label>
				</td>
				<td align="center" valign="middle">
					<label class="radio-inline radio-lg">
						<input type="radio" value="yes" data-bind="checked: RDT, attr: { name: 'RDT' + Rec_ID }" />
						<span>yes</span>
					</label>
					<label class="radio-inline radio-lg">
						<input type="radio" value="no" data-bind="checked: RDT, attr: { name: 'RDT' + Rec_ID }" />
						<span>no</span>
					</label>
					<label class="radio-inline radio-lg">
						<input type="radio" value="not done" data-bind="checked: RDT, attr: { name: 'RDT' + Rec_ID }" />
						<span>not done</span>
					</label>
				</td>
				<td align="center" valign="middle">
					<label class="radio-inline radio-lg">
						<input type="radio" value="pf" data-bind="checked: Species, attr: { name: 'Species' + Rec_ID }" />
						<span>Pf</span>
					</label>
					<label class="radio-inline radio-lg">
						<input type="radio" value="pv" data-bind="checked: Species, attr: { name: 'Species' + Rec_ID }" />
						<span>Pv</span>
					</label>
					<label class="radio-inline radio-lg">
						<input type="radio" value="pfpv" data-bind="checked: Species, attr: { name: 'Species' + Rec_ID }" />
						<span>PfPv</span>
					</label>
				</td>
				<td align="center" valign="middle">
					<label class="radio-inline radio-lg">
						<input type="radio" value="yes" data-bind="checked: Antimalarial, attr: { name: 'Antimalarial' + Rec_ID }" />
						<span>yes</span>
					</label>
					<label class="radio-inline radio-lg">
						<input type="radio" value="no" data-bind="checked: Antimalarial, attr: { name: 'Antimalarial' + Rec_ID }" />
						<span>no</span>
					</label>
				</td>
				<td align="center" valign="middle">
					<label class="radio-inline radio-lg">
						<input type="radio" value="yes" data-bind="checked: Antibiotic, attr: { name: 'Antibiotic' + Rec_ID }" />
						<span>yes</span>
					</label>
					<label class="radio-inline radio-lg">
						<input type="radio" value="no" data-bind="checked: Antibiotic, attr: { name: 'Antibiotic' + Rec_ID }" />
						<span>no</span>
					</label>
				</td>
				<td align="center" valign="middle">
					<a class="text-danger" data-bind="click: $root.showDelete">Delete</a>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8" align="center">
					<a data-bind="click: $root.addNewRow">Add New Row</a>
				</td>
			</tr>
		</tfoot>
	</table>
	<br />

	<div>
		<span>QC done by <i class="font14">(name)</i>:</span>
		<input type="text" class="form-control inlineblock" data-bind="value: QCBy" style="width:300px" />
	</div>
	<br />
</div>

<?=latestJs('/media/ViewModel/QMBaselineData.js')?>