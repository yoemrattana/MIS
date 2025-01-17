<style>
	#footer { display: none; }
	.divcenter { max-width: 1300px; margin: auto; }
	.mt-5 { margin-top: 5px; }
	.ml-20 { margin-left: 20px; }
	label { font-weight: normal; }
	label span { user-select: none; }
	[field=indicator] { font-weight: bold; }
	#tbldetail .input-group-addon { border-top-left-radius: 4px; border-bottom-left-radius: 4px; }
	#tbldetail th, #tbldetail td { border: 1px solid !important; }
</style>

<div class="panel-body divcenter" data-bind="visible: view() == 'detail'">
	<h3 class="text-center text-primary">
		Surveillance Assessment Questionnaire
		<span data-bind="text: '(' + getTitle() + ')'"></span>
	</h3>
	<br />

	<!-- ko with: masterModel -->
	<div style="border:1px solid; padding:10px">
		<div class="form-group form-inline">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">Province</span>
					<select data-bind="value: pv,
							options: pvList,
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: ''" class="form-control minwidth150"></select>
				</div>
			</div>
			<div class="form-group" data-bind="visible: $root.menu().in('OD','HC','VMW')">
				<div class="input-group">
					<span class="input-group-addon">OD</span>
					<select data-bind="value: od,
							options: odList(),
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: ''" class="form-control minwidth150"></select>
				</div>
			</div>
			<div class="form-group" data-bind="visible: $root.menu().in('HC','VMW')">
				<div class="input-group">
					<span class="input-group-addon">HC</span>
					<select data-bind="value: hc,
							options: hcList(),
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: ''" class="form-control minwidth150"></select>
				</div>
			</div>
			<div class="form-group" data-bind="visible: $root.menu().in('VMW')">
				<div class="input-group">
					<span class="input-group-addon">VMW/MMW</span>
					<select data-bind="value: vl,
							options: vlList(),
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: ''" class="form-control minwidth150"></select>
				</div>
			</div>
		</div>
		<div class="form-inline form-group">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">Interviewer</span>
					<input type="text" class="form-control" data-bind="value: Interviewer" />
				</div>
			</div>
			<div class="form-group">
				<!-- ko ifnot: app.isMobile -->
				<div class="input-group relative">
					<span class="input-group-addon">Interview Date</span>
					<input type="text" class="form-control text-center width120" data-bind="datePicker: InterviewDate, dataType: 'string'" />
				</div>
				<!-- /ko -->
				<!-- ko if: app.isMobile -->
				<div class="input-group">
					<span class="input-group-addon">Interview Date</span>
					<input type="date" class="form-control text-center width120" data-bind="value: InterviewDate" />
				</div>
				<!-- /ko -->
			</div>
		</div>
		<div class="form-inline">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">Interviewee</span>
					<input type="text" class="form-control" data-bind="value: Interviewee" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group relative">
					<span class="input-group-addon">Interviewee Position</span>
					<input type="text" class="form-control" data-bind="value: IntervieweePosition" />
				</div>
			</div>
		</div>
	</div>
	<br />

	<p>We would like to invite you to participate in this 45–60-minute interview to talk about the current situation, gaps, and challenges on the national malaria surveillance system, how we can address these. The results of this interview will be used to put forward recommendations on how we can further improve malaria testing in the country hence halting the further disease transmission in the country. This interview will be electronically recorded, and your answers will remain anonymous and confidential. If anytime you would like to speak off the record, please let me know.</p>
	<div class="checkbox checkbox-lg">
		<label>
			<input type="checkbox" data-bind="checked: Agree" />
			<span>I agree</span>
		</label>
	</div>
	<br />
	<!-- /ko -->

	<table id="tbldetail" class="table table-bordered">
		<thead>
			<tr>
				<th align="center" width="40">#</th>
				<th align="center" width="100">Indicator Number</th>
				<th align="center">Indicator</th>
				<th align="center">Question</th>
				<th align="center" style="min-width:250px">Answer</th>
			</tr>
		</thead>

		<?php if (in_array($type,['PHD','OD'])) $this->load->view('questionbank_detail_phdod_view ') ?>
		<?php if ($type == 'HC') $this->load->view('questionbank_detail_hc_view ') ?>
		<?php if ($type == 'VMW') $this->load->view('questionbank_detail_vmw_view ') ?>
	</table>
</div>