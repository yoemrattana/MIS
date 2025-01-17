<style>
    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }
    table tr td {
        font-family: "Khmer OS Content"
    }
</style>
<div class="panel-body divcenter" data-bind="visible: view() == 'detail'">
	<h3 class="text-center text-primary">DQA Detail</h3>
	<br />
    <div class="form-inline" data-bind="with: detailModel">
        <div class="input-group">
            <span class="input-group-addon">Visitor</span>
            <input required type="text" class="form-control" data-bind="value: dqa.Visitor" />
        </div>
        <div class="input-group">
            <span class="input-group-addon">Visit Date</span>
            <input type="date" class="form-control"  data-bind="value: dqa.VisitDate" />
        </div>

        <div class="input-group">
            <div class="checkbox checkbox-lg">
		    <label>
			    <input type="checkbox" data-bind="checked: dqa.HasDoc">
			    <span>Has Paper Document?</span>
		    </label>
        </div>

	</div>
    </div>
    
    <br />
    <table id="tbldetail" class="table table-bordered">
		<thead>
			<tr class="bg-info">
				<th colspan="3" align="center" width="100">Variable</th>
				<th align="center">MIS</th>
				<th align="center">Health Facility</th>
                <th align="center">Note</th>
			</tr>
            <tr>
                <th align="center">Category</th>
                <th width="10">Question Number</th>
                <th style="text-align:center">Method of case detection</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
		</thead>
		<tbody data-bind="with: detailModel">
            <tr>
                <td rowspan="4" valign="middle" align="center">Patient details</td>
                <td align="center">1</td>
                <td>Patient Name </td>
                <td data-bind="text: NameK"></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqa.Name"/>
                    <span data-bind="validationMessage: dqa.Name" class="message-error"></span>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.Name"/>
                </td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td>Age</td>
                <td data-bind="text: Age"></td>
                <td>
                    <input type="number" class="form-control" data-bind="value: dqa.Age"/>
                    <span data-bind="validationMessage: dqa.Age" class="message-error"></span>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.Age"/>
                </td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td>Sex</td>
                <td data-bind="text: $root.getSex(Sex())"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.Sex">
						<option></option>
						<option value="M">Male</option>
						<option value="F">Female</option>
					</select>
                    <span data-bind="validationMessage: dqa.Sex" class="message-error"></span>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.Sex"/>
                </td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td>Patient permanent address (Village)</td>
                <td data-bind="text: $root.getVill(Code_Vill_T())"></td>
                <td>
                    <span data-bind="text: $root.getVill(dqa.PermanentAddress())"></span>
                    <input type="text" param="address" class="form-control" data-bind="value: dqa.PermanentAddress, click: $root.selectAddress"/>
                    <!--<span data-bind="validationMessage: dqa.PermanentAddress" class="message-error"></span>-->
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.PermanentAddress"/>
                </td>
            </tr>

            <tr>
                <td rowspan="3"  valign="middle" align="center">Location of treatment facility</td>
                <td align="center">5</td>
                <td>Health Facility</td>
                <td data-bind="text: $root.getHCName(Code_Facility_T())"></td>
                <td>
                    <span data-bind="text: $root.getHCName(dqa.Code_Facility_T())"></span>
                    <input type="text" class="form-control" data-bind="value: dqa.Code_Facility_T, click: $root.selectHF"/>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.Code_Facility_T"/>
                </td>
            </tr>
            <tr>
                <td align="center">6</td>
                <td>District</td>
                <td data-bind="text: $root.getDistName(Code_Dist_T())"></td>
                <td>
                    <span data-bind="text: $root.getDistName(dqa.Code_Dist())"></span>
                    <input type="text" class="form-control" data-bind="value: dqa.Code_Dist, click: $root.selectDist"/>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.Code_Dist"/>
                </td>
            </tr>
             <tr>
                <td align="center">7</td>
                <td>Province</td>
                <td data-bind="text: $root.getProvName(Code_Prov_T())"></td>
                <td>
                    <span data-bind="text: $root.getProvName(dqa.Code_Prov())"></span>
                    <input type="text" class="form-control" data-bind="value: dqa.Code_Prov, click: $root.selectProv"/>
                </td>
                 <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.Code_Prov"/>
                </td>
            </tr>

            <tr>
                <td rowspan="4"  valign="middle" align="center">Diagnosis and Treatment</td>
                <td align="center">8</td>
                <td>Date of diagnosis (dd/mm/yy)</td>
                <td data-bind="text:  $root.dateFormat(DateCase)"></td>
                <td>
                    <input type="date" placeholder="dd-mm-yyyy"  class="form-control" data-bind="value: dqa.DiagnosisDate"/>
                    <!--<span data-bind="validationMessage: dqa.DiagnosisDate" class="message-error"></span>-->
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.DiagnosisDate"/>
                </td>
            </tr>
            <tr>
                <td align="center">9</td>
                <td>Diagnosis confirmation method (RDT, miscroscopy, PCR)</td>
                <td data-bind="text: Method"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.DiagnosisMethod">
						<option></option>
						<option value="RDT">RDT</option>
						<option value="Miscroscopy">Miscroscopy</option>
                        <option value="PCR">PCR</option>
					</select>
                    <span data-bind="validationMessage: dqa.DiagnosisMethod" class="message-error"></span>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.DiagnosisMethod"/>
                </td>
            </tr>
            <tr>
                <td align="center">10</td>
                <td>Species identified (Pv, Pf, Mix, Pk, Pm, Po, unknown)</td>
                <td data-bind="text: $root.getSpecie(Diagnosis())"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.Species">
						<option></option>
						<option value="F">Pf</option>
						<option value="V">Pv</option>
                        <option value="M">Mix</option>
                        <option value="K">Pk</option>
                        <option value="A">Pm</option>
                        <option value="O">Po</option>
                        <option value="No">Unknown</option>
					</select>
                    <span data-bind="validationMessage: dqa.Species" class="message-error"></span>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.Species"/>
                </td>
            </tr>
            <tr>
                <td align="center">11</td>
                <td>Treatment prescribed</td>
                <td data-bind="text: Treatment"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.TreatmentPrescribe">
                        <option></option>
                        <option value="ASMQ"> ASMQ</option>
                        <option value="ASMQ + PQ"> ASMQ + PQ</option>
                        <option value="ASMQ + Primaquine">ASMQ + Primaquine</option>
                        <option value="ASMQ + PQ (1 Dose)"> ASMQ + PQ (1 Dose)</option>
                        <option value="ASMQ + PQ (14 Days)"> ASMQ + PQ (14 Days)</option>
                        <option value="ASMQ + PQ (7Days)"> ASMQ + PQ (7Days)</option>
                        <option value="Primaquine">Primaquine</option>
                        <option value="No Stock"> No Stock</option>
                        <option value="None"> None</option>
                        <option value="Other"> Other</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.TreatmentPrescribe"/>
                </td>
            </tr>

            <tr>
                <td rowspan="12"  valign="middle" align="center">Case notification and investigation</td>
                <td align="center">12</td>
                <td>Case notification form found? (y/n)</td>
                <td ></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.IsFoundNotification">
						<option></option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.IsFoundNotification"/>
                </td>
            </tr>
            <tr>
                <td align="center">13</td>
                <td>Date of case notification (dd/mm/yy)</td>
                <td data-bind="text: $root.dateFormat(DateCase)"></td>
                <td><input type="date" placeholder="dd-mm-yyyy"  class="form-control" data-bind="value: dqa.NotificationDate"/></td>
                 <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.NotificationDate"/>
                </td>
            </tr>
             <tr>
                 <td align="center">14</td>
                <td>Recent travel within the country ( Y/N Red response if YES)</td>
                <td data-bind="text: IsInCountry"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.IsWithinCountry">
						<option></option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
                </td>
                 <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.IsWithinCountry"/>
                </td>
            </tr>      
            <tr>
                <td align="center">15</td>
                <td>Province / district name, Town/village name of travel destination </td>
                <td data-bind="text: InCountry"></td>
                <td>
                    <span data-bind="text: $root.getVill(dqa.WithinCountry())"></span>
                    <input type="text" param="incountry" class="form-control" data-bind="value: dqa.WithinCountry, click: $root.selectAddress"/>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.WithinCountry"/>
                </td>
            </tr>
            <tr>
                <td align="center">16</td>
                <td>Recent travel outside the country ( Y/N Red response if YES)</td>
                <td data-bind="text: IsOutCountry"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.IsOutSideCountry">
						<option></option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.IsOutSideCountry"/>
                </td>
            </tr>
            <tr>
                <td align="center">17</td>
                <td>Country name of travel destination</td>
                <td data-bind="text: OutCountry"></td>
                <td><input type="text" class="form-control" data-bind="value: dqa.OutSideCountry"/></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.OutSideCountry"/>
                </td>
            </tr>
            <tr>
                <td align="center">18</td>
                <td>Date of case investigation (dd/mm/yy)</td>
                <td data-bind="text: $root.dateFormat(DateCase)"></td>
                <td><input type="date" placeholder="dd-mm-yyyy"  class="form-control" data-bind="value: dqa.InvestigationDate"/></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.InvestigationDate"/>
                </td>
            </tr>
            <tr>
                <td align="center">19</td>
                <td>Location of case investigation ( Lat) </td>
                <td data-bind="text: InvLat"></td>
                <td><input type="text" class="form-control" data-bind="value: dqa.InvestigationLat"/></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.InvestigationLat"/>
                </td>
            </tr>
            <tr>
                <td align="center">20</td>
                <td>Location of case investigation ( Long) </td>
                <td data-bind="text: InvLong"></td>
                <td><input type="text" class="form-control" data-bind="value: dqa.InvestigationLong"/></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.InvestigationLong"/>
                </td>
            </tr>
            <tr>
                <td align="center">21</td>
                <td>Final Classification </td>
                <td data-bind="text: Classify"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.Classification">
						<option></option>
						<option value="Relapse">Relapse</option>
						<option value="L1">L1</option>
                        <option value="L2">L2</option>
                        <option value="L3">L3</option>
                        <option value="L4">L4</option>
                        <option value="LC">LC</option>
                        <option value="IMP">IMP</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.Classification"/>
                </td>
            </tr>
            <tr>
                <td align="center">22</td>
                <td>Is Classification appropriate </td>
                <td></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.IsAppropriate">
						<option></option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.IsAppropriate"/>
                </td>
            </tr>
            <tr>
                <td align="center">23</td>
                <td>Explain why classification is or is not appropriate</td>
                <td></td>
                <td><input type="text" class="form-control" data-bind="value: dqa.ReasonClasAppro"/></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.ReasonClasAppro"/>
                </td>
            </tr>

            <tr>
                <td rowspan="4"  valign="middle" align="center">Foci Investigation</td>
                <td align="center">24</td>
                <td>Focus investigation form found? (y/n)</td>
                <td ></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.IsFoundFocusInv">
						<option></option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.IsFoundFocusInv"/>
                </td>
            </tr>
            <tr>
                <td align="center">25</td>
                <td>Date of focus investigation (dd/mm/yy)</td>
                <td data-bind="text: $root.dateFormat(FociInvestigationDate)"></td>
                <td><input type="date" placeholder="dd-mm-yyyy"  class="form-control" data-bind="value: dqa.FocusInvDate"/></td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.FocusInvDate"/>
                </td>
            </tr>
            <tr>
                <td align="center">26</td>
                <td>Foci classification (active, residual non-active and cleared, no classification)</td>
                <td data-bind="text: FociClassification"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.FociClassification">
						<option></option>
						<option value="Active">Active</option>
						<option value="Residual">Residual</option>
                        <option value="Non-active">Non-active</option>
                        <option value="Cleared">Cleared</option>
                        <option value="No classification">No classification</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.FociClassification"/>
                </td>
            </tr>
            <tr>
                <td align="center">27</td>
                <td>Focus investigation complete? (y/n)</td>
                <td data-bind="text: Completed"></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.IsCompleteFocusInv">
						<option></option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.IsCompleteFocusInv"/>
                </td>
            </tr>

            <tr>
                <td valign="middle" align="center">Indicator 1.2.11</td>
                <td align="center">28</td>
                <td>Core variables complete in register (Y/N) (columns C16- C21)</td>
                <td ></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.IsCompleteRegister">
						<option></option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.IsCompleteRegister"/>
                </td>
            </tr>

            <tr>
                <td valign="middle" align="center">Indicator 1.2.12</td>
                <td align="center">29</td>
                <td>Concordance between data in national database and source document for all core variables (Y/N) <br /> (columns C16-C20 match between the national database and patient register) <br /> and (columns C23-C32 and C36 match between the national database and the case investigation forms )</td>
                <td ></td>
                <td>
                    <select class="form-control font12" data-bind="value: dqa.IsConcordance">
						<option></option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
                </td>
                <td>
                    <input type="text" class="form-control" data-bind="value: dqaNote.IsConcordance"/>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal Input Place -->
<div class="modal" id="modalInputPlace" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Input Place</h3>
			</div>
			<div class="modal-body">
				<table class="table" data-bind="with: inputPlaceModel">
					<tr>
						<th width="100" align="right" valign="middle">Province</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">District</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: ds, options: dsList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Commune</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: cm, options: cmList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">Village</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
				</table>
				<hr />
				<table class="table" data-bind="with: inputPlaceModel">
					<tr>
						<th width="100" align="right" valign="middle">Other</th>
						<td class="form-group">
							<input type="text" class="form-control input-sm" data-bind="value: other" />
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100" data-dismiss="modal" data-bind="click: inputPlaceOKClick">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal" data-bind="click: inputPlaceCancelClick">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Input HF -->
<div class="modal" id="modalInputHF" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Input Place</h3>
			</div>
			<div class="modal-body">
				<table class="table" data-bind="with: inputHcModel">
					<tr>
						<th width="100" align="right" valign="middle">Province</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">OD</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">HC</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
				</table>
				<hr />
				<table class="table" data-bind="with: inputPlaceModel">
					<tr>
						<th width="100" align="right" valign="middle">Other</th>
						<td class="form-group">
							<input type="text" class="form-control input-sm" data-bind="value: other" />
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100" data-dismiss="modal" data-bind="click: inputHcOKClick">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal" data-bind="click: inputHcCancelClick">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Input Dist -->
<div class="modal" id="modalInputDist" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">District</h3>
			</div>
			<div class="modal-body">
				<table class="table" data-bind="with: inputDistModel">
					<tr>
						<th width="100" align="right" valign="middle">Province</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
					<tr>
						<th align="right" valign="middle">District</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: ds, options: dsList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
				</table>
				<hr />
				<table class="table" data-bind="with: inputPlaceModel">
					<tr>
						<th width="100" align="right" valign="middle">Other</th>
						<td class="form-group">
							<input type="text" class="form-control input-sm" data-bind="value: other" />
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100" data-dismiss="modal" data-bind="click: inputDistOKClick">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal" data-bind="click: inputDistCancelClick">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Input Province -->
<div class="modal" id="modalInputProv" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">District</h3>
			</div>
			<div class="modal-body">
				<table class="table" data-bind="with: inputProvModel">
					<tr>
						<th width="100" align="right" valign="middle">Province</th>
						<td class="form-group">
							<select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm width100" data-dismiss="modal" data-bind="click: inputProvOKClick">OK</button>
				<button class="btn btn-default btn-sm width100" data-dismiss="modal" data-bind="click: inputProvCancelClick">Cancel</button>
			</div>
		</div>
	</div>
</div>