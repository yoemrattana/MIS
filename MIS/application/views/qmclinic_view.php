<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<h3 class="text-center">
		<b>CLINICAL FORM v1.0</b>
	</h3>
	<div class="text-center">
		<b>Impact study of the Standard™ Q Malaria/CRP Duo Test</b>
	</div>
	<br />

	<div class="form-inline text-center">
		<div class="form-group" style="vertical-align:top; margin-top:7px">Health Center</div>
		<div class="form-group">
			<input id="hcname" type="text" class="form-control text-center" data-bind="value: $root.getHCNameE(Code_Facility_T()), click: $parent.choosePlace" style="width:300px" />
		</div>
		<div class="form-group">
			<span class="text-danger">Require</span>
		</div>
	</div>
	<br />

	<table class="table table-bordered widthauto" style="margin:auto">
		<tr>
			<td width="120" align="center" valign="middle">Patient Code</td>
			<td align="center" valign="middle">
				<div class="form-inline">
					<div class="input-group width150">
						<span class="input-group-addon">MA011</span>
						<input type="text" class="form-control text-center numonly" maxlength="6" data-bind="value: PatientCode" />
					</div>
					<span class="text-danger">Require</span>
				</div>
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="6" class="bg-info"><b>A. General information</b></td>
		</tr>
		<tr>
			<td valign="middle">1. Date of patient visit (dd/mm/yy)</td>
			<td class="relative">
				<input type="text" class="form-control text-center width100" data-bind="datePicker: ConsultDate, format: 'DD/MM/YY'" />
			</td>
			<td valign="middle">2. Site code</td>
			<td>
				<input type="text" class="form-control text-center width150" data-bind="value: PlaceCode" maxlength="2" />
			</td>
			<td valign="middle">3. HC staff initials</td>
			<td>
				<input type="text" class="form-control text-center" data-bind="value: Verifier" maxlength="3" />
			</td>
		</tr>
	</table>
	<br />

	<div class="table-bordered bg-info" style="padding:5px">
		<b>B. INCLUSION CRITERIA</b> (All answers to questions 1–2 must be <b>YES</b> for the participant to be eligible)
	</div>
	<table class="table">
		<tr>
			<td class="text-bold" align="center" width="60">YES</td>
			<td class="text-bold" align="center" width="60">NO</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="center">
				<input type="radio" name="B1" value="Yes" data-bind="checked: B1" class="radio-lg" />
			</td>
			<td align="center">
				<input type="radio" name="B1" value="No" data-bind="checked: B1" class="radio-lg" />
			</td>
			<td valign="middle">1. Patient aged 2 years or above?</td>
		</tr>
		<tr>
			<td align="center">
				<input type="radio" name="B2" value="Yes" data-bind="checked: B2" class="radio-lg" />
			</td>
			<td align="center">
				<input type="radio" name="B2" value="No" data-bind="checked: B2" class="radio-lg" />
			</td>
			<td valign="middle">2. Did the patient qualify to be tested with a malaria RDT based on local testing guidelines?</td>
		</tr>
		<tr>
			<td align="center">
				<input type="radio" name="B3" value="Yes" data-bind="checked: B3" class="radio-lg" />
			</td>
			<td align="center">
				<input type="radio" name="B3" value="No" data-bind="checked: B3" class="radio-lg" />
			</td>
			<td valign="middle">3. Is there a signed informed consent by participant and/or parent/l guardian?</td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td class="relative">
				<span>Date Informed Consent/Assent Signed (DD/MM/YY):</span>
				<input type="text" class="form-control text-center inlineblock width100" data-bind="datePicker: B3Date, format: 'DD/MM/YY'" />
			</td>
		</tr>
	</table>
	<br />

	<div class="text-info font14">
		If any of these criteria is answered with a <b>NO</b>, withdraw the participant from the study and inform the study coordinator.
	</div>
	<br />

	<div class="table-bordered bg-info" style="padding:5px">
		<b>C. EXCLUSION CRITERIA</b> (Answer to these questions 1-2 must be <b>NO</b> for the participant to be eligible)
	</div>
	<table class="table">
		<tr>
			<td class="text-bold" align="center" width="60">YES</td>
			<td class="text-bold" align="center" width="60">NO</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="center">
				<input type="radio" name="C1" value="Yes" data-bind="checked: C1" class="radio-lg" />
			</td>
			<td align="center">
				<input type="radio" name="C1" value="No" data-bind="checked: C1" class="radio-lg" />
			</td>
			<td valign="middle">1. Symptoms and signs of severe disease or severe health condition?</td>
		</tr>
		<tr>
			<td align="center">
				<input type="radio" name="C2" value="Yes" data-bind="checked: C2" class="radio-lg" />
			</td>
			<td align="center">
				<input type="radio" name="C2" value="No" data-bind="checked: C2" class="radio-lg" />
			</td>
			<td valign="middle">2. Unable to come back for a follow-up visit at day 5?</td>
		</tr>
	</table>
	<br />

	<div class="text-info font14">
		If this criteria is answered with a <b>YES</b>, withdraw the participant from the study and inform the study coordinator.
	</div>
	<br />

	<div class="text-info font14">
		Complete the subsequent sections <i>ONLY</i> for the participants who meet the eligibility criteria above.
	</div>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="4" class="bg-info"><b>D. PARTICIPANT DEMOGRAPHICS</b></td>
		</tr>
		<tr>
			<td align="center" width="40" valign="middle">1.</td>
			<td valign="middle">Age (completed years)</td>
			<td>
				<input type="text" class="form-control text-center width100 numonly" data-bind="value: Age" maxlength="3" />
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">2.</td>
			<td valign="middle">Gender</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Sex" value="F" data-bind="checked: Sex" />
					<span>Female</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Sex" value="M" data-bind="checked: Sex" />
					<span>Male</span>
				</label>
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="4" class="bg-info"><b>E. PARTICIPANT CURRENT MEDICAL STATUS</b></td>
		</tr>
		<tr>
			<td align="center" width="40" valign="middle">1.</td>
			<td valign="middle">Axillary temperature</td>
			<td class="form-group">
				<div class="input-group width150">
					<input type="text" class="form-control text-center numonly" data-type="float" data-bind="value: Temp" />
					<span class="input-group-addon">°C</span>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">2.</td>
			<td>Chief complaint? (can check more than one complaint)</td>
			<td>
				<label class="radio-inline radio-lg width100">
                    <input type="radio" name="ChiefComplaint" value="Yes" data-bind="checked: ChiefComplaint" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
                    <input type="radio" name="ChiefComplaint" value="No" data-bind="checked: ChiefComplaint" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Abdominal Pain" data-bind="checked: Disease" />
					<span>Abdominal pain</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Sweats" data-bind="checked: Disease" />
					<span>Sweats</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Dizziness" data-bind="checked: Disease" />
					<span>Dizziness</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Chills" data-bind="checked: Disease" />
					<span>Chills</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Nausea" data-bind="checked: Disease" />
					<span>Nausea</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Stomachache" data-bind="checked: Disease" />
					<span>Stomachache</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Fatigue" data-bind="checked: Disease" />
					<span>Fatigue</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Cough" data-bind="checked: Disease" />
					<span>Cough</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Dysuria" data-bind="checked: Disease" />
					<span>Dysuria</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Headache" data-bind="checked: Disease" />
					<span>Headache</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Diarrhea" data-bind="checked: Disease" />
					<span>Diarrhea</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Vomiting" data-bind="checked: Disease" />
					<span>Vomiting</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Rash" data-bind="checked: Disease" />
					<span>Rash</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Disease" value="Conjunctival Redness" data-bind="checked: Disease" />
					<span>Conjunctival Redness</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<div class="form-group">
					<label class="checkbox-inline checkbox-lg">
						<input type="checkbox" name="Disease" value="Other" data-bind="checked: Disease" />
						<span>Other <i>(specify)</i></span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: DiseaseOther, enable: isnull(Disease(), []).contain('Other')" />
			</td>
		</tr>
	</table>
	<br />

	<!-- F -->

	<table class="table table-bordered">
		<tr>
			<td colspan="6" class="bg-info"><b>F. TESTING WITH MALARIA RDT (SD BIOLINE Pf/Pv test)</b></td>
		</tr>
		<tr>
			<td>1. Malaria test result?</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="RDTResult" value="Negative" data-bind="checked: RDTResult" />
					<span>neg</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="RDTResult" value="Pf" data-bind="checked: RDTResult" />
					<span>Pf</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
                    <input type="radio" name="RDTResult" value="Pv" data-bind="checked: RDTResult" />
					<span>Pv</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="RDTResult" value="invalid" data-bind="checked: RDTResult" />
					<span>invalid</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="RDTResult" value="not done" data-bind="checked: RDTResult" />
					<span>not done</span>
				</label>
			</td>
		</tr>
		<tr>
			<td valign="middle">2. HC staff initials (if known who did the Malaria RDT)</td>
			<td colspan="4">
				<input type="text" class="form-control" data-bind="value: RDTVerifier, disable: RDTVerifierUnknown" />
			</td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="RDTVerifierUnknown" data-bind="checked: RDTVerifierUnknown, change: $root.chboxUnknownChange" />
					<span>Unknown</span>
				</label>
			</td>
		</tr>
		<tr>
			<td>3. Observations/comments on the malaria RDT<br />(e.g. why no test done? any issues? red background? etc.)</td>
			<td colspan="5">
				<textarea class="form-control" rows="4" style="resize:none" data-bind="value: RDTSuggestion"></textarea>
			</td>
		</tr>
	</table>
	<br />

	<!-- G -->

	<table class="table table-bordered">
		<tr>
			<td colspan="6" class="bg-info"><b>G. TESTING WITH STANDARD™ Q MALARIA/CRP DUO TEST</b></td>
		</tr>
		<tr>
			<td>1. Malaria test result?</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPMalariaResult" value="Negative" data-bind="checked: CRPMalariaResult" />
					<span>neg</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPMalariaResult" value="Pf" data-bind="checked: CRPMalariaResult" />
					<span>Pf Positive</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPMalariaResult" value="Pan" data-bind="checked: CRPMalariaResult" />
					<span>Pan Positive</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPMalariaResult" value="invalid" data-bind="checked: CRPMalariaResult" />
					<span>invalid</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPMalariaResult" value="not done" data-bind="checked: CRPMalariaResult" />
					<span>not done</span>
				</label>
			</td>
		</tr>
		<tr>
			<td>2. CRP test result?</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPResult" value="Negative" data-bind="checked: CRPResult" />
					<span>CRP negative</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPResult" value="Positive" data-bind="checked: CRPResult" />
					<span>CRP positive</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPResult" value="invalid" data-bind="checked: CRPResult" />
					<span>invalid</span>
				</label>
			</td>
			<td width="150" align="center" colspan="2">
				<label class="radio-inline radio-lg">
					<input type="radio" name="CRPResult" value="not done" data-bind="checked: CRPResult" />
					<span>not done</span>
				</label>
			</td>
		</tr>
		<tr>
			<td valign="middle">3. HC staff initials (if known who did the Malaria/RDT DUO test)</td>
			<td colspan="4">
				<input type="text" class="form-control" data-bind="value: CRPVerifier, disable: CRPVerifierUnknown" />
			</td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="CRPVerifierUnknown" data-bind="checked: CRPVerifierUnknown, change: $root.chboxUnknownChange" />
					<span>Unknown</span>
				</label>
			</td>
		</tr>
		<tr>
			<td>4. Observations/comments on the Malaria/CRP DUO test<br />(e.g. why no test done? any issues? red background? etc.)</td>
			<td colspan="5">
				<textarea class="form-control" rows="4" style="resize:none" data-bind="value: CRPSuggestion"></textarea>
			</td>
		</tr>
	</table>
	<br />

	<!-- H -->

	<table class="table table-bordered">
		<tr>
			<td colspan="4" class="bg-info"><b>H. FINGERPRICK BLOOD COLLECTION</b></td>
		</tr>
		<tr>
			<td class="col-xs-6">1. Fingerprick blood collected (one EDTA tube of 100 µL)?</td>
			<td colspan="2" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="Blood" value="Yes" data-bind="checked: Blood" />
					<span>Yes</span>
				</label>
			</td>
			<td align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="Blood" value="No" data-bind="checked: Blood" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td valign="middle">2. HC staff initials (if known who did the blood collection)</td>
			<td colspan="2" align="center">
				<input type="text" class="form-control" data-bind="value: BloodVerifier, disable: BloodVerifierUnknown" />
			</td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="BloodVerifierUnknown" data-bind="checked: BloodVerifierUnknown, change: $root.chboxUnknownChange" />
					<span>Unknown</span>
				</label>
			</td>
		</tr>
		<tr>
			<td>3. Observations/comments on the fingerprick blood sample<br />(e.g. why no blood collected? any issues? Volume lower than 100 µL? etc.)</td>
			<td colspan="3">
				<textarea class="form-control" rows="4" style="resize:none" data-bind="value: BloodSuggestion"></textarea>
			</td>
		</tr>
	</table>
	<br />

	<!-- I -->

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info"><b>I. ANTIMALARIAL TREATMENT</b></td>
		</tr>
		<tr>
			<td align="center" width="40">1.</td>
			<td width="500">Antimalarial treatment</td>
			<td class="col-xs-6">
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="MalariaTreatment" value="No" data-bind="checked: MalariaTreatment" />
					<span>No antimalarial given</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="MalariaTreatment" value="Chloroquine" data-bind="checked: MalariaTreatment" />
					<span>Chloroquine</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="MalariaTreatment" value="Primaquine" data-bind="checked: MalariaTreatment" />
					<span>Primaquine</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="MalariaTreatment" value="Arthemeter + Lumefantrine" data-bind="checked: MalariaTreatment" />
					<span>Arthemeter + Lumefantrine</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="MalariaTreatment" value="Arthemeter + Mefloquine" data-bind="checked: MalariaTreatment" />
					<span>Arthemeter + Mefloquine</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<div class="form-group">
					<label class="checkbox-inline checkbox-lg">
						<input type="checkbox" name="MalariaTreatment" value="Other" data-bind="checked: MalariaTreatment" />
						<span>Other <i>(specify)</i></span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: MalariaTreatmentOther, enable: isnull(MalariaTreatment(), []).contain('Other')" />
			</td>
		</tr>
	</table>
	<br />

	<!-- J -->

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info"><b>J. ANTIBIOTIC TREATMENT</b></td>
		</tr>
		<tr>
			<td align="center" width="40">2.</td>
			<td width="500">Antibiotic treatment</td>
			<td class="col-xs-6">
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="AntibioticTreatment" value="No" data-bind="checked: AntibioticTreatment" />
					<span>No antibiotic treatment given</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="AntibioticTreatment" value="Amoxicillin" data-bind="checked: AntibioticTreatment" />
					<span>Amoxicillin</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="AntibioticTreatment" value="Ciprofloxacin" data-bind="checked: AntibioticTreatment" />
					<span>Ciprofloxacin</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="AntibioticTreatment" value="Cefalosporin" data-bind="checked: AntibioticTreatment" />
					<span>Cefalosporin</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="AntibioticTreatment" value="Gentamycin IM" data-bind="checked: AntibioticTreatment" />
					<span>Gentamycin IM</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="AntibioticTreatment" value="Azithromycin" data-bind="checked: AntibioticTreatment" />
					<span>Azithromycin</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<div class="form-group">
					<label class="checkbox-inline checkbox-lg">
						<input type="checkbox" name="AntibioticTreatment" value="Other" data-bind="checked: AntibioticTreatment" />
						<span>Other <i>(specify)</i></span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: AntibioticTreatmentOther, enable: isnull(AntibioticTreatment(), []).contain('Other')" />
			</td>
		</tr>
	</table>
	<br />

	<!-- K -->

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info"><b>K. OTHER TREATMENT</b></td>
		</tr>
		<tr>
			<td align="center" width="40">2.</td>
			<td width="500">Other treatment given</td>
			<td class="col-xs-6">
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="OtherTreatment" value="No" data-bind="checked: OtherTreatment" />
					<span>No other treatment given</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="OtherTreatment" value="Paracetamol" data-bind="checked: OtherTreatment" />
					<span>Paracetamol</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="OtherTreatment" value="Ibuprofen" data-bind="checked: OtherTreatment" />
					<span>Ibuprofen</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="OtherTreatment" value="Cetirizine" data-bind="checked: OtherTreatment" />
					<span>Cetirizine</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="OtherTreatment" value="Bromexine" data-bind="checked: OtherTreatment" />
					<span>Bromexine</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="OtherTreatment" value="Promethazine" data-bind="checked: OtherTreatment" />
					<span>Promethazine</span>
				</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<div class="form-group">
					<label class="checkbox-inline checkbox-lg">
						<input type="checkbox" name="OtherTreatment" value="Other" data-bind="checked: OtherTreatment" />
						<span>Other <i>(specify)</i></span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: OtherTreatmentOther, enable: isnull(OtherTreatment(), []).contain('Other')" />
			</td>
		</tr>
	</table>
	<br />

	<!-- L -->

	<table class="table table-bordered">
		<tr>
			<td colspan="2" class="bg-info"><b>L. GENERAL COMMENTS</b></td>
		</tr>
		<tr>
			<td class="col-xs-6">
				1. Observations/comments<br />(e.g. referral? general observations? etc.)
			</td>
			<td>
				<textarea class="form-control" rows="4" style="resize:none" data-bind="value: GeneralSuggestion"></textarea>
			</td>
		</tr>
	</table>
	<br />

	<div class="text-info font14">
		Malaria/CRP impact study - Clinical Form v1.0 - 6 May 2020
	</div>
</div>

<?=latestJs('/media/ViewModel/QMClinic.js')?>