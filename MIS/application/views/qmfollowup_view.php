<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<h3 class="text-center">
		<b>FOLLOW UP FORM v1.0</b>
	</h3>
	<div class="text-center">
		<b>Impact study of the Standard&trade; Q Malaria/CRP Duo Test</b>
	</div>
	<br />

	<div class="form-inline text-center">
		<div class="form-group" style="vertical-align:top; margin-top:7px">Health Center</div>
		<div class="form-group">
			<input id="hcname" type="text" class="form-control text-center" data-bind="value: $root.getHCNameE(Code_Facility_T()), click: $parent.choosePlace" style="width:300px" />
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
			<td colspan="6" class="bg-info">
				<b>A. General information</b>
			</td>
		</tr>
		<tr>
			<td valign="middle">1. Date of patient visit (dd/mm/yy)</td>
			<td class="relative">
				<input type="text" class="form-control text-center width100" data-bind="datePicker: ConsultDate, format: 'DD/MM/YY'" />
			</td>
			<td valign="middle">2. Site code</td>
			<td>
				<input type="text" class="form-control text-center width150 numonly" data-bind="value: PlaceCode" maxlength="10" />
			</td>
			<td valign="middle">3. HC staff initials</td>
			<td>
				<input type="text" class="form-control text-center" data-bind="value: Verifier" />
			</td>
		</tr>
		<tr>
			<td valign="middle">4. Date of data entry into database (dd/mm/yy)</td>
			<td colspan="3" class="relative">
				<input type="text" class="form-control text-center width100" data-bind="datePicker: DataEntryDate, format: 'DD/MM/YY'" />
			</td>
			<td>5. Data entry staff initials</td>
			<td valign="middle">
				<input type="text" class="form-control text-center" data-bind="value: DataEntryUser" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="4" class="bg-info">
				<b>B. PARTICIPANT CURRENT MEDICAL STATUS</b>
			</td>
		</tr>
		<tr>
			<td align="center" width="40" valign="middle">1.</td>
			<td valign="middle">Axillary temperature</td>
			<td>
				<div class="input-group width150">
					<input type="text" class="form-control text-center numonly" data-type="float" data-bind="value: Temp" />
					<span class="input-group-addon">&#8451;</span>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">2.</td>
			<td>Chief complaint? <br /> (Can check more than one complaint)</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="Complaint" value="Yes" data-bind="checked: Complaint" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="Complaint" value="No" data-bind="checked: Complaint" />
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
						<span>
							Other
							<i>(specify)</i>
						</span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: DiseaseOther, enable: isnull(Disease(), []).contain('Other')" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="5" class="bg-info">
				<b>C. TESTING WITH MALARIA RDT (SD BIOLINE Pf/Pv test)</b>
			</td>
		</tr>
		<tr>
			<td>1. Malaria test result?</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="RDTResult" value="Pf" data-bind="checked: RDTResult" />
					<span>Pf</span>
				</label>
			</td>
			<td width="150" align="center">
				<label class="radio-inline radio-lg">
					<input type="radio" name="RDTResult" value="non Pf" data-bind="checked: RDTResult" />
					<span>non Pf</span>
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
				<input type="text" class="form-control" data-bind="value: RDTVerifier" />
			</td>
		</tr>
		<tr>
			<td>
				3. Observations/comments on the malaria RDT
				<br />(e.g. why no test done? any issues? red background? etc.)
			</td>
			<td colspan="4">
				<textarea class="form-control" rows="4" style="resize:none" data-bind="value: RDTSuggestion"></textarea>
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info">
				<b>D. ANTIMALARIAL TREATMENT</b>
			</td>
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
						<span>
							Other
							<i>(specify)</i>
						</span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: MalariaTreatmentOther, enable: isnull(MalariaTreatment(), []).contain('Other')" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info">
				<b>E. ANTIBIOTIC TREATMENT</b>
			</td>
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
				<div class="form-group">
					<label class="checkbox-inline checkbox-lg">
						<input type="checkbox" name="AntibioticTreatment" value="Other" data-bind="checked: AntibioticTreatment" />
						<span>
							Other
							<i>(specify)</i>
						</span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: AntibioticTreatmentOther, enable: isnull(AntibioticTreatment(), []).contain('Other')" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="3" class="bg-info">
				<b>F. OTHER TREATMENT</b>
			</td>
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
						<span>
							Other
							<i>(specify)</i>
						</span>
					</label>
				</div>
				<input type="text" class="form-control" data-bind="value: OtherTreatmentOther, enable: isnull(OtherTreatment(), []).contain('Other')" />
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td colspan="2" class="bg-info">
				<b>G. GENERAL COMMENTS</b>
			</td>
		</tr>
		<tr>
			<td class="col-xs-6">
				1. Observations/comments
				<br />(e.g. referral? general observations? etc.)
			</td>
			<td>
				<textarea class="form-control" rows="4" style="resize:none" data-bind="value: GeneralSuggestion"></textarea>
			</td>
		</tr>
	</table>
	<br />

	<div class="text-info font14">
		Standard&trade; Q Malaria/CRP Duo Test - Follow-up Form v1.0 - 17 Jun 2020
	</div>
</div>

<?=latestJs('/media/ViewModel/QMFollowup.js')?>