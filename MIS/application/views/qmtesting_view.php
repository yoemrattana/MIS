<div class="container font16" data-bind="visible: view() == 'detail', with: detailModel">
	<h3 class="text-center">
		<b>CRP TESTING FORM v1.0</b>
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
	</div>
	<br />

	<table class="table table-bordered widthauto" style="margin:auto">
		<tr>
			<td width="120" align="center" valign="middle">Patient Code</td>
			<td align="center" valign="middle">
				<div class="input-group width150">
					<span class="input-group-addon">MA011</span>
					<input type="text" class="form-control text-center numonly" maxlength="6" data-bind="value: ParticipantCode" />
				</div>
			</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td class="bg-info">A. CRP REFERENCE TESTING</td>
		</tr>
	</table>
	<br />

	<table class="table table-bordered">
		<tr>
			<td class="col-xs-6">1. CRP reference testing performed (If no, put an explanation in comments)</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="TestCRP" value="Yes" data-bind="checked: TestCRP" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="TestCRP" value="No" data-bind="checked: TestCRP" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td valign="middle">2. Date of testing the sample (dd/mm/yy)</td>
			<td class="relative">
				<input type="text" class="form-control text-center width150" data-bind="datePicker: BloodDate, format: 'DD/MM/YY'" />
			</td>
		</tr>
		<tr>
			<td valign="middle">3. Nycocard lot number</td>
			<td>
				<input type="text" class="form-control text-center widthauto" data-bind="value: Nycocoard" />
			</td>
		</tr>
		<tr>
			<td class="col-xs-6">4. CRP level is below the detection limit</td>
			<td>
				<label class="radio-inline radio-lg width100">
					<input type="radio" name="TestCRP" value="Yes" data-bind="checked: TestCRP" />
					<span>Yes</span>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="TestCRP" value="No" data-bind="checked: TestCRP" />
					<span>No</span>
				</label>
			</td>
		</tr>
		<tr>
			<td valign="middle">5. Level of CRP measured</td>
			<td>
				<div class="input-group width150">
					<input type="text" class="form-control text-center numonly" data-bind="value: CRPLevel" />
					<span class="input-group-addon">mg/L</span>
				</div>
			</td>
		</tr>
		<tr>
			<td>6. Observations/comments on the CRP reference testing (e.g. why no test done? any issues? etc.)</td>
			<td valign="middle">
				<input type="text" class="form-control" data-bind="value: Suggestion" />
			</td>
		</tr>
	</table>

	<table class="table table-bordered" style="margin-top:-1px">
		<tr>
			<td class="col-xs-3" valign="middle">7. Date (dd/mm/yy)</td>
			<td class="col-xs-3">
				<div class="relative">
					<input type="text" class="form-control text-center width150" data-bind="datePicker: DataEntryDate, format: 'DD/MM/YY'" />
				</div>
			</td>
			<td class="col-xs-3" valign="middle">8. Lab staff initials</td>
			<td>
				<input type="text" class="form-control" data-bind="value: DataEntryUser" />
			</td>
		</tr>
	</table>
	<br />

</div>

<?=latestJs('/media/ViewModel/QMLabo.js')?>