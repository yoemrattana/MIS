<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<table class="table table-bordered">
		<tr>
			<td width="300" align="center">
				<img src="/media/images/find_logo.jpg" />
			</td>
			<td align="center" valign="middle">
				<h4>CRF #4 VISUAL and APP INTERPRETATION OF RDT</h4>
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
			<td align="center" valign="middle">Reading performed (initials)</td>
			<td>
				<input type="text" class="form-control text-center" data-bind="value: ReadingPerformed" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info">
				<b>A. VISUAL INTERPRETATION OF RDT</b>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle" width="40">1.</td>
			<td valign="middle" width="500">
				Is this test an initial or a repeat test?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="TestType" value="Initial" data-bind="checked: TestType" />
					<span>Initial</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="TestType" value="Repeat" data-bind="checked: TestType" />
					<span>Repeat</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">2.</td>
			<td valign="middle">
				Time of interpretation (HH:MM):
			</td>
			<td valign="middle" class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: InterpretationTime, format: 'HH:mm'" />
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">3.</td>
			<td valign="middle">
				Date of interpretation (DD/MM/YY):
			</td>
			<td valign="middle" class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: InterpretationDate, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td align="center" rowspan="4">4.</td>
			<td>Did you observe a band:</td>
			<td></td>
		</tr>
		<tr>
			<td valign="middle" style="padding-left:35px">
				a. In the Control line:
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
			<td valign="middle" style="padding-left:35px">
				b. In the Pv line:
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
			<td valign="middle" style="padding-left:35px">
				c. In the Pf line:
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
			<td align="center" valign="middle">5.</td>
			<td valign="middle">
				RDT result interpretation:
			</td>
			<td valign="middle">
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
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="RDTResult" value="Negative" data-bind="checked: RDTResult" />
					<span>Negative</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="RDTResult" value="Invalid" data-bind="checked: RDTResult" />
					<span>Invalid</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center">6.</td>
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
		<tr>
			<td colspan="3" class="bg-info">
				<b>B. APP INTERPRETATION OF RDT</b>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">7.</td>
			<td valign="middle">
				Time of interpretation (HH:MM):
			</td>
			<td valign="middle" class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: AppInterpretationTime, format: 'HH:mm'" />
			</td>
		</tr>
		<tr>
			<td align="center" rowspan="2">8.</td>
			<td valign="middle">
				Any problems or irregularities in using the app?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="AppHasProblem" value="Yes" data-bind="checked: AppHasProblem" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="AppHasProblem" value="No" data-bind="checked: AppHasProblem" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td>
				a. If YES, tick the appropriate box(es):
			</td>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="AppProblem" value="App stops responding" data-bind="checked: AppProblem" />
						<span>App stops responding</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="AppProblem" value="App crashes suddenly" data-bind="checked: AppProblem" />
						<span>App crashes suddenly</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="AppProblem" value="App does not open" data-bind="checked: AppProblem" />
						<span>App does not open</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="AppProblem" value="App does not take a picture" data-bind="checked: AppProblem" />
						<span>App does not take a picture</span>
					</label>
				</div>
				<div class="form-inline">
					<label class="radio-inline radio-lg">
						<input type="radio" name="AppProblem" value="Other" data-bind="checked: AppProblem" />
						<span>Other:</span>
					</label>
					<input type="text" class="form-control" style="width:400px" data-bind="value: AppProblemOther" />
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

<?=latestJs('/media/ViewModel/CRFRDTUser2.js')?>