<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<table class="table table-bordered">
		<tr>
			<td width="300" align="center">
				<img src="/media/images/find_logo.jpg" />
			</td>
			<td align="center" valign="middle">
				<h4>CRF #6 ELISA REFERENCE TEST FORM</h4>
			</td>
		</tr>
	</table>
	<br />

	<div class="clearfix">
		<div class="pull-left">
			<b>Protocol Title:</b> RDT app reader evaluation study in Cambodia
		</div>
		<div class="pull-right">
			<b>Protocol Number:</b> AMR002
		</div>
	</div>
	<br />

	<table class="table table-bordered widthauto" style="margin:auto">
		<tr class="en">
			<td width="150" align="center" valign="middle">
				<b>Participant Code</b>
			</td>
			<td align="center" valign="middle">
				<div class="form-inline">
					<div class="input-group width150">
						<span class="input-group-addon">AM002</span>
						<input type="text" class="form-control text-center numonly" maxlength="6" data-bind="value: ParticipantCode" />
					</div>
					<span class="text-danger">Require</span>
				</div>
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info">
				<b>A. REFERENCE TEST BY ELISA</b>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle" width="40">1.</td>
			<td valign="middle" width="400">
				Was ELISA done?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="ElisaDone" value="Yes" data-bind="checked: ElisaDone" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ElisaDone" value="No" data-bind="checked: ElisaDone" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>If YES,</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td valign="middle" style="padding-left:35px">
				a. ELISA done by (initials):
			</td>
			<td>
				<input type="text" class="form-control" data-bind="value: ElisaDoneBy" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td valign="middle" style="padding-left:35px">
				b. Date of testing (DD/MM/YY):
			</td>
			<td class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: TestingDate, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td valign="middle" style="padding-left:35px">
				c. Date of analysis (DD/MM/YY):
			</td>
			<td class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: AnalysisDate, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td valign="middle" style="padding-left:35px">
				d. Result:
			</td>
			<td>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Result" value="Plasmodium-positive" data-bind="checked: Result" />
					<span>Plasmodium-positive</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Result" value="Plasmodium-negative" data-bind="checked: Result" />
					<span>Plasmodium-negative</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td valign="middle" style="padding-left:35px">
				If PLASMODIUM-POSITIVE,
				<br />
				<span style="margin-left:30px">
					i. Species identified: <i>(can check ≥1 box)</i>
				</span>
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg">
					<input type="radio" name="SpeciesIdentified" value="Undetermined" data-bind="checked: SpeciesIdentified" />
					<span>Undetermined</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="SpeciesIdentified" value="Pf" data-bind="checked: SpeciesIdentified" />
					<span>Pf</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="SpeciesIdentified" value="Pv" data-bind="checked: SpeciesIdentified" />
					<span>Pv</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="SpeciesIdentified" value="Pm" data-bind="checked: SpeciesIdentified" />
					<span>Pm</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="SpeciesIdentified" value="Po" data-bind="checked: SpeciesIdentified" />
					<span>Po</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="SpeciesIdentified" value="Pk" data-bind="checked: SpeciesIdentified" />
					<span>Pk</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td valign="middle" style="padding-left:65px">
				ii. Density (parasite/µL):
			</td>
			<td>
				<input type="text" class="form-control text-center width150 numonly" data-type="float" data-bind="value: Density" />
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				If NO,
				<br />
				<span style="margin-left:30px">e. Please provide reason:</span>
			</td>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Reason" value="Insufficient sample volume" data-bind="checked: Reason" />
						<span>Insufficient sample volume</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Reason" value="ELISA reader not functional" data-bind="checked: Reason" />
						<span>ELISA reader not functional</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="Reason" value="No kit available" data-bind="checked: Reason" />
						<span>No kit available</span>
					</label>
				</div>
				<div class="form-inline">
					<label class="radio-inline radio-lg">
						<input type="radio" name="Reason" value="Other" data-bind="checked: Reason" />
						<span>Other:</span>
					</label>
					<input type="text" class="form-control" style="width:400px" data-bind="value: ReasonOther" />
				</div>
			</td>
		</tr>

	</table>
	<br />

	<div class="form-inline form-group">
		<span>Completed by:</span>
		<input type="text" class="form-control" data-bind="value: CompeletedBy" />
	</div>
	<div class="form-inline form-group relative">
		<span>Date of recording (DD/MM/YY):</span>
		<input type="text" class="form-control width150 text-center" data-bind="datePicker: RecordingDate, format: 'DD/MM/YY'" />
	</div>
	<div class="form-inline form-group">
		<span>QC done by:</span>
		<input type="text" class="form-control" data-bind="value: QCBy" />
	</div>
	<div class="form-inline form-group relative">
		<span>Date of QC (DD/MM/YY):</span>
		<input type="text" class="form-control width150 text-center" data-bind="datePicker: QCDate, format: 'DD/MM/YY'" />
	</div>
	<br />

	<table class="table table-bordered">
		<thead class="bg-info">
			<tr>
				<th align="center">Comments</th>
				<th align="center">Date (DD/MM/YY)</th>
				<th align="center">Initials</th>
				<th align="center">Signature</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<input type="text" class="form-control" data-bind="value: Comment" />
				</td>
				<td class="relative">
					<input type="text" class="form-control text-center" data-bind="datePicker: CommentDate, format: 'DD/MM/YY'" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: CommentInitial" />
				</td>
				<td>
					<input type="text" class="form-control" data-bind="value: CommentSignature" />
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<div class="form-inline form-group">
		<span>QC done by:</span>
		<input type="text" class="form-control" data-bind="value: CommentQCBy" />
	</div>
	<div class="form-inline form-group relative">
		<span>Date of QC (DD/MM/YY):</span>
		<input type="text" class="form-control width150 text-center" data-bind="datePicker: CommentQCDate, format: 'DD/MM/YY'" />
	</div>
</div>

<?=latestJs('/media/ViewModel/CRFElisa.js')?>