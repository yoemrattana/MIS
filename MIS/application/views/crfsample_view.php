
<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<table class="table table-bordered">
		<tr>
			<td width="300" align="center">
				<img src="/media/images/find_logo.jpg" />
			</td>
			<td align="center" valign="middle">
				<h4>CRF #2 SAMPLE COLLECTION FORM</h4>
			</td>
		</tr>
	</table>
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
			<td colspan="3" class="bg-info text-bold">A. FINGER-PRICK BLOOD COLLECTION</td>
		</tr>
		<tr>
			<td align="center" valign="middle" width="40">1.</td>
			<td valign="middle" width="600">Finger-prick blood collected?</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="FingerPrickBlood" value="Yes" data-bind="checked: FingerPrickBlood" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="FingerPrickBlood" value="No" data-bind="checked: FingerPrickBlood" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center">2.</td>
			<td>If NO to 1, please provide a reason:</td>
			<td>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="IfNoReason" value="Insufficient sample" data-bind="checked: IfNoReason" />
						<span>Insufficient sample</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="IfNoReason" value="Other" data-bind="checked: IfNoReason" />
						<span>Other, please specify:</span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: IfNoReasonOther" />
			</td>
		</tr>
		<tr>
			<td align="center">3.</td>
			<td>If YES to 1, fill question 3a to 3c below</td>
			<td></td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				a. Blood collected by (initials):
			</td>
			<td>
				<input type="text" class="form-control" data-bind="value: BloodCollectedBy" />
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				b. Date of finger-prick blood collection (DD/MM/YY):
			</td>
			<td class="relative">
				<input type="text" class="form-control text-center width150" data-bind="datePicker: FingerPrickBloodDate, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td valign="middle">
				<span style="margin-left:30px">c. Time of finger-prick blood collection (HH:MM):</span>
				<br />
				<br />
				<i>(Repeat sample details to be filled only in case of an invalid result has been obtained with the malaria RDT and a new sample is required)</i>
			</td>
			<td class="relative">
				<div class="form-group form-inline">
					<span>- Initial sample:</span>
					<input type="text" class="form-control text-center width150" data-bind="datePicker: FingerPrickBloodTimeInitial, format: 'HH:mm'" />
				</div>
				<div class="form-group form-inline">
					<span>- Repeat sample:</span>
					<input type="text" class="form-control text-center width150" data-bind="datePicker: FingerPrickBloodTimeRepeat, format: 'HH:mm'" />
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">4.</td>
			<td valign="middle">
				Filter papers with a total of two (2) dried blood spots prepared & stored?
			</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="FilterPapers" value="Yes" data-bind="checked: FilterPapers" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="FilterPapers" value="No" data-bind="checked: FilterPapers" />
					<span>No</span>
				</label>
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

<?=latestJs('/media/ViewModel/CRFSample.js')?>