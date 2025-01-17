<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<table class="table table-bordered">
		<tr>
			<td width="300" align="center">
				<img src="/media/images/find_logo.jpg" />
			</td>
			<td align="center" valign="middle">
				<h4>CRF #3 VISUAL INTERPRETATION OF RDT</h4>
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
			<td align="center" valign="middle">Date of testing (DD/MM/YY)</td>
			<td class="relative">
				<input type="text" class="form-control text-center" data-bind="datePicker: TestingDate, format: 'DD/MM/YY'" />
			</td>
			<td align="center" valign="middle">Test performed by (initials)</td>
			<td>
				<input type="text" class="form-control text-center" data-bind="value: TestPerformedBy" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td align="center" valign="middle" width="40">1.</td>
			<td valign="middle" width="600">Is this testing a repeat test?</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="RepeatTest" value="Yes" data-bind="checked: RepeatTest" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="RepeatTest" value="No" data-bind="checked: RepeatTest" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<b>Information from the RDT package:</b>
			</td>
		</tr>
		<tr>
			<td align="center">2.</td>
			<td>
				Is the Malaria RDT SD Bioline Malaria Ag P.f/P.v 05FK80?
			</td>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="RDT" value="Yes" data-bind="checked: RDT" />
						<span>Yes</span>
					</label>
				</div>
				<div class="form-inline">
					<label class="radio-inline radio-lg">
						<input type="radio" name="RDT" value="No" data-bind="checked: RDT" />
						<span>No, it is</span>
					</label>
					<input type="text" class="form-control" data-bind="value: OtherRDT" />
				</div>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">3.</td>
			<td valign="middle">RDT lot number:</td>
			<td>
				<input type="text" class="form-control" data-bind="value: LotNumber" />
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">4.</td>
			<td valign="middle">RDT date of expiration (DD/MM/YY):</td>
			<td class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: Expiration, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<b>RDT testing detail:</b>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">5.</td>
			<td valign="middle">Time of adding sample (HH:MM):</td>
			<td class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: SampleTime, format: 'HH:mm'" />
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">6.</td>
			<td valign="middle">Time of interpretation (HH:MM):</td>
			<td class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: InterpretationTime, format: 'HH:mm'" />
			</td>
		</tr>
		<tr>
			<td align="center" rowspan="3">7.</td>
			<td valign="middle">
				Did you get an invalid results?
				<br />
				<i>If yes, repeat the testing with a new test and a new sample, and fill the questions a and b below:</i>
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="InvalidResult" value="Yes" data-bind="checked: InvalidResult" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="InvalidResult" value="No" data-bind="checked: InvalidResult" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td valign="middle" style="padding-left:35px">
				a. Time of adding sample (HH:MM):
			</td>
			<td class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: SampleTime2, format: 'HH:mm'" />
			</td>
		</tr>
		<tr>
			<td valign="middle" style="padding-left:35px">
				b. Time of interpretation (HH:MM):
			</td>
			<td class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: InterpretationTime2, format: 'HH:mm'" />
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<b>RDT results (visual interpretation):</b>
			</td>
		</tr>
		<tr>
			<td align="center" rowspan="3">8.</td>
			<td valign="middle">
				Did you observe a band:
				<br />
				<span style="margin-left:30px">- In the Control line:</span>
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="ControlLine" value="Yes" data-bind="checked: ControlLine" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ControlLine" value="No" data-bind="checked: ControlLine" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td valign="middle">
				<span style="margin-left:30px">- In the Pv line:</span>
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="PvLine" value="Yes" data-bind="checked: PvLine" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="PvLine" value="No" data-bind="checked: PvLine" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td valign="middle">
				<span style="margin-left:30px">- In the Pf line:</span>
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="PfLine" value="Yes" data-bind="checked: PfLine" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="PfLine" value="No" data-bind="checked: PfLine" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center">9.</td>
			<td valign="middle">
				RDT result interpretation:
			</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="RDTResult" value="Pv" data-bind="checked: RDTResult" />
					<span>Pv</span>
				</label>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="RDTResult" value="Pf" data-bind="checked: RDTResult" />
					<span>Pf</span>
				</label>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="RDTResult" value="Pv + Pf" data-bind="checked: RDTResult" />
					<span>Pv + Pf</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="RDTResult" value="Negative" data-bind="checked: RDTResult" />
					<span>Negative</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center">10.</td>
			<td>
				RDT strip background:
			</td>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="RDTStrip" value="No observations" data-bind="checked: RDTStrip" />
						<span>No observations</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="RDTStrip" value="Red background" data-bind="checked: RDTStrip" />
						<span>Red background</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="RDTStrip" value="Incomplete clearing" data-bind="checked: RDTStrip" />
						<span>Incomplete clearing</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="RDTStrip" value="Streaking blood" data-bind="checked: RDTStrip" />
						<span>Streaking blood</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="RDTStrip" value="Diffuse test line" data-bind="checked: RDTStrip" />
						<span>Diffuse test line</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="RDTStrip" value="Patchy broken test line" data-bind="checked: RDTStrip" />
						<span>Patchy broken test line</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="RDTStrip" value="Ghost test line" data-bind="checked: RDTStrip" />
						<span>Ghost test line</span>
					</label>
				</div>
				<div class="form-inline">
					<label class="radio-inline radio-lg">
						<input type="radio" name="RDTStrip" value="Other" data-bind="checked: RDTStrip" />
						<span>Other:</span>
					</label>
					<input type="text" class="form-control" style="width:400px" data-bind="value: RDTStripOther" />
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

<?=latestJs('/media/ViewModel/CRFRDTUser1.js')?>