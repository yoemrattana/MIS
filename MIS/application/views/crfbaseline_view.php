<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<table class="table table-bordered">
		<tr>
			<td width="300" align="center">
				<img src="/media/images/find_logo.jpg" />
			</td>
			<td align="center" valign="middle">
				<h4>CRF #1 Baseline Assessment Form</h4>
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
			<td align="center" valign="middle">Date of assessment (DD/MM/YY)</td>
			<td class="relative">
				<input type="text" class="form-control text-center" data-bind="datePicker: DateOfAssessment, format: 'DD/MM/YY'" />
			</td>
			<td align="center" valign="middle">Assessment performed by (initials)</td>
			<td>
				<input type="text" class="form-control text-center" data-bind="value: AssessmentPerformedBy" />
			</td>
		</tr>
	</table>
	<br />

	<div>
		<i class="text-info font14">Complete this form for each participant who signed the consent form.</i>
	</div>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info text-bold">A. PARTICIPANT DEMOGRAPHICS</td>
		</tr>
		<tr>
			<td align="center" valign="middle" width="40">1.</td>
			<td valign="middle" width="300">Date of birth (DD/MM/YY):</td>
			<td class="relative">
				<input type="text" class="form-control text-center width150" data-bind="datePicker: DateOfBirth, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td align="center">2.</td>
			<td>Sex:</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Sex" value="Female" data-bind="checked: Sex" />
					<span>Female</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Sex" value="Male" data-bind="checked: Sex" />
					<span>Male</span>
				</label>
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info text-bold">B. PARTICIPANT MEDICAL HISTORY</td>
		</tr>
		<tr>
			<td width="40" align="center">1.</td>
			<td width="500">History of malaria?</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="MalariaHistory" value="Yes" data-bind="checked: MalariaHistory" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="MalariaHistory" value="No" data-bind="checked: MalariaHistory" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td valign="middle">If YES, How long ago?</td>
			<td>
				<input type="text" class="form-control text-center width100 inlineblock numonly" data-bind="value: HowLongAgo" />

				<label class="radio-inline radio-lg" style="margin-left:20px">
					<input type="radio" name="HowLongAgoUnit" value="Days" data-bind="checked: HowLongAgoUnit" />
					<span>days</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="HowLongAgoUnit" value="Months" data-bind="checked: HowLongAgoUnit" />
					<span>months</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="HowLongAgoUnit" value="Years" data-bind="checked: HowLongAgoUnit" />
					<span>years</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center">2.</td>
			<td>History of malaria during the preceding 2-month period?</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="History2Month" value="Yes" data-bind="checked: History2Month" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="History2Month" value="No" data-bind="checked: History2Month" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center">3.</td>
			<td>Any anti-malarial drug received during the preceding 2-month period?</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Drug2Month" value="Yes" data-bind="checked: Drug2Month" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Drug2Month" value="No" data-bind="checked: Drug2Month" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>If YES, Treatment:</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="HistoryTreatment" value="ACT" data-bind="checked: HistoryTreatment" />
					<span>ACT</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="HistoryTreatment" value="Primaquine" data-bind="checked: HistoryTreatment" />
					<span>Primaquine</span>
				</label>
				<br />
				<br />
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="HistoryTreatment" value="NA" data-bind="checked: HistoryTreatment" />
					<span>NA</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="HistoryTreatment" value="Other" data-bind="checked: HistoryTreatment" />
					<span>Other</span>
				</label>
				<input class="form-control inlineblock" style="width:250px" data-bind="value: HistoryTreatmentOther" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info text-bold">C. PARTICIPANT CURRENT MEDICAL STATUS</td>
		</tr>
		<tr>
			<td width="40" align="center">1.</td>
			<td width="600">
				Actual axillary temperature:
				<br />
				<i class="text-info font14">(measured as part of the study procedure)</i>
			</td>
			<td valign="middle">
				<div class="input-group width150">
					<input type="text" class="form-control text-center numonly" data-type="float" data-bind="value: AxillaryTemperature" />
					<span class="input-group-addon">°C</span>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">2.</td>
			<td>
				Axillary temperature measured ≥ 37.5 °C within the last 72 hours?
				<br />
				<i class="text-info font14">(based on participant interview and/or medical records)</i>
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="AxillaryTemperature72" value="Yes" data-bind="checked: AxillaryTemperature72" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="AxillaryTemperature72" value="No" data-bind="checked: AxillaryTemperature72" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td>
				If YES,
				<br />
				<span style="margin-left:30px">a. When did it start?</span>
			</td>
			<td valign="middle">
				<div class="input-group" style="width:200px">
					<input type="text" class="form-control text-center numonly" data-bind="value: WhenStart" />
					<span class="input-group-addon">days ago</span>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px">
				b. The highest axillary temperature measured within the last 72 hours:
				<br />
				<i class="text-info font14">(including actual axillary temperature measured)</i>
			</td>
			<td class="form-inline" valign="middle">
				<div class="input-group width150">
					<input type="text" class="form-control text-center numonly" data-type="float" data-bind="value: HightestTemperature72" />
					<span class="input-group-addon">°C</span>
				</div>
				<label class="checkbox-inline checkbox-lg" style="margin-left:30px">
					<input type="checkbox" data-bind="checked: HightestTemperature72NA" />
					<span>NA</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px">
				c. Any drugs received during the current febrile episode?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="ReceivedDrug" value="Yes" data-bind="checked: ReceivedDrug" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ReceivedDrug" value="No" data-bind="checked: ReceivedDrug" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px">
				If YES,
				<br />
				<div style="margin-left:30px">
					i. Treatment 1:
					<br />
					<i class="text-info font14">(write down the drug name)</i>
				</div>
			</td>
			<td valign="middle">
				<input type="text" class="form-control" data-bind="value: Treatment1" />
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:65px" valign="middle">
				ii. Date of treatment 1 (DD/MM/YY):
			</td>
			<td valign="middle" class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: Treatment1Date, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:65px">
				iii. Treatment 2:
				<br />
				<i class="text-info font14">(write down the drug name)</i>
			</td>
			<td valign="middle">
				<input type="text" class="form-control" data-bind="value: Treatment2" />
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:65px" valign="middle">
				iv. Date of treatment 2 (DD/MM/YY):
			</td>
			<td valign="middle" class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: Treatment2Date, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:65px">
				v. Treatment 3:
				<br />
				<i class="text-info font14">(write down the drug name)</i>
			</td>
			<td valign="middle">
				<input type="text" class="form-control" data-bind="value: Treatment3" />
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:65px" valign="middle">
				vi. Date of treatment 3 (DD/MM/YY):
			</td>
			<td valign="middle" class="relative">
				<input type="text" class="form-control width150 text-center" data-bind="datePicker: Treatment3Date, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td align="center">3.</td>
			<td>
				Any clinical symptoms currently?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Symptoms" value="Yes" data-bind="checked: Symptoms" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Symptoms" value="No" data-bind="checked: Symptoms" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td>
				If YES,
				<br />
				<span style="margin-left:30px">a. Abdominal pain?</span>
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="AbdominalPain" value="Yes" data-bind="checked: AbdominalPain" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="AbdominalPain" value="No" data-bind="checked: AbdominalPain" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				b. Sweats?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Sweats" value="Yes" data-bind="checked: Sweats" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Sweats" value="No" data-bind="checked: Sweats" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				c. Dizziness?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Dizziness" value="Yes" data-bind="checked: Dizziness" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Dizziness" value="No" data-bind="checked: Dizziness" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				d. Chills?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Chills" value="Yes" data-bind="checked: Chills" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Chills" value="No" data-bind="checked: Chills" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				e. Nausea?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Nausea" value="Yes" data-bind="checked: Nausea" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Nausea" value="No" data-bind="checked: Nausea" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				f. Stomachache?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Stomachache" value="Yes" data-bind="checked: Stomachache" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Stomachache" value="No" data-bind="checked: Stomachache" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				g. Fatigue?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Fatigue" value="Yes" data-bind="checked: Fatigue" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Fatigue" value="No" data-bind="checked: Fatigue" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				h. Cough?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Cough" value="Yes" data-bind="checked: Cough" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Cough" value="No" data-bind="checked: Cough" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				i. Dysuria?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Dysuria" value="Yes" data-bind="checked: Dysuria" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Dysuria" value="No" data-bind="checked: Dysuria" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				j. Headache?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Headache" value="Yes" data-bind="checked: Headache" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Headache" value="No" data-bind="checked: Headache" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				k. Diarrhea?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Diarrhea" value="Yes" data-bind="checked: Diarrhea" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Diarrhea" value="No" data-bind="checked: Diarrhea" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				l. Vomiting?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Vomiting" value="Yes" data-bind="checked: Vomiting" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Vomiting" value="No" data-bind="checked: Vomiting" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				m. Rash?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Rash" value="Yes" data-bind="checked: Rash" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Rash" value="No" data-bind="checked: Rash" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				n. Conjunctival Redness?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="ConjunctivalRedness" value="Yes" data-bind="checked: ConjunctivalRedness" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="ConjunctivalRedness" value="No" data-bind="checked: ConjunctivalRedness" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td style="padding-left:35px" valign="middle">
				o. Other, please specify:
			</td>
			<td valign="middle">
				<input type="text" class="form-control" data-bind="value: SymptomOther" />
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">5.</td>
			<td valign="middle">
				Pregnancy status:
			</td>
			<td valign="middle">
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="PregnancyStatus" value="Positive" data-bind="checked: PregnancyStatus" />
						<span>Positive</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="PregnancyStatus" value="Negative" data-bind="checked: PregnancyStatus" />
						<span>Negative</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="PregnancyStatus" value="Unknown" data-bind="checked: PregnancyStatus" />
						<span>Unknown</span>
					</label>
				</div>
				<div class="radio radio-lg">
					<label>
						<input type="radio" name="PregnancyStatus" value="NA" data-bind="checked: PregnancyStatus" />
						<span>NA</span>
					</label>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center"></td>
			<td valign="middle">
				If POSITIVE, which trimester?
			</td>
			<td valign="middle">
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Trimester" value="First" data-bind="checked: Trimester" />
					<span>First</span>
				</label>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Trimester" value="Second" data-bind="checked: Trimester" />
					<span>Second</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Trimester" value="Third" data-bind="checked: Trimester" />
					<span>Third</span>
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

<?=latestJs('/media/ViewModel/CRFBaseline.js')?>