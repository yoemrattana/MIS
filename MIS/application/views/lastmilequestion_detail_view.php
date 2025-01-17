<style>
	#footer { display: none; }
</style>

<div class="panel-body" data-bind="visible: view() == 'detail'" style="width:1200px; margin:auto">
	<h3 class="text-center text-primary">
		Last Mile Elimination Assessment
		<span data-bind="text: '(' + getTitle() + ')'"></span>
	</h3>
	<br>

	<div style="border:1px solid; padding:10px" data-bind="with: masterModel">
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
			<div class="form-group" data-bind="visible: $root.menu().in('OD','HC','VMW','Vill','Pop')">
				<div class="input-group">
					<span class="input-group-addon">OD</span>
					<select data-bind="value: od,
							options: odList(),
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: ''" class="form-control minwidth150"></select>
				</div>
			</div>
			<div class="form-group" data-bind="visible: $root.menu().in('HC','VMW','Vill','Pop')">
				<div class="input-group">
					<span class="input-group-addon">HC</span>
					<select data-bind="value: hc,
							options: hcList(),
							optionsValue: 'code',
							optionsText: 'name',
							optionsCaption: ''" class="form-control minwidth150"></select>
				</div>
			</div>
			<div class="form-group" data-bind="visible: $root.menu().in('VMW','Vill','Pop')">
				<div class="input-group">
					<span class="input-group-addon">Village</span>
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
	<br>

	<table id="tbldetail" class="table">
		<thead>
			<tr>
				<td width="100"></td>
				<td></td>
				<td width="600"></td>
			</tr>
		</thead>

		<tbody id="PHD">
			<tr>
				<td colspan="3">
					<b>Indicator 1: Acceptability</b>
					<br /><br />
					<u>Sub-indicator 1.1: Attitude of the service providers</u>
				</td>
			</tr>
			<tr>
				<th>Question 1:</th>
				<td colspan="2">
					<span class="en">How would you evaluate each of the following "Last Mile Activities" in your Province? Please rate on the following scale:</span>
					<span class="kh">តើអ្នកវាយតម្លៃសកម្មភាព last mile ក្នុងខេត្តរបស់អ្នកដោយរបៀបណា? សូមដាក់ពិន្ទុ:</span>
				</td>
			</tr>
			<tr id="1.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement:</span>
					<span class="kh">a. ការអប់រំនៅសហគមន៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.a.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.b">
				<td></td>
				<td>
					<span class="en">b. Community Engagement Round 2:</span>
					<span class="kh">b. ការអប់រំនៅសហគមន៍លើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.b.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.c">
				<td></td>
				<td>
					<span class="en">c. Village Census:</span>
					<span class="kh">c. ជំរឿនប្រជាជន</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.c.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.d">
				<td></td>
				<td>
					<span class="en">d. Top Up Distribution of LLINs/LLIHNs:</span>
					<span class="kh">d. ការចែកបន្ថែមមុងគ្រែ និង មុងអង្រឹង</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.d.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.e">
				<td></td>
				<td>
					<span class="en">e. Targeted Drug administration (TDA) Round 1:</span>
					<span class="kh">e. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី១</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.e.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.f">
				<td></td>
				<td>
					<span class="en">f. Targeted Drug Administration (TDA) Round 2:</span>
					<span class="kh">f. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.f.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.g">
				<td></td>
				<td>
					<span class="en">g. Active Fever Screening (AFS):</span>
					<span class="kh">g. AFS ការជួសឈាមប្រចាំសប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.g.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.h">
				<td></td>
				<td>
					<span class="en">h. Intermittent Preventive Therapy for Forest-goers (IPTF):</span>
					<span class="kh">h. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.h.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr id="2">
				<th>Question 2:</th>
				<td>
					<span class="en">Do you think the LME activity is making an impact on the community?</span>
					<span class="kh">តើអ្នកគិតថាសកម្មភាពនេះកំពុងមានឥទ្ធិពលដល់សហគមន៍អ្នកដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="2.a">
				<th></th>
				<td>
					<span class="en">a. If yes, in what way?</span>
					<span class="kh">a. បើមាន តើមានតាមរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.2: Timing of delivery</u>
				</td>
			</tr>
			<tr>
				<th>Question 3:</th>
				<td colspan="2">
					<span class="en">What do you think about the timeframe of each activity?</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះរយៈពេលនៃសកម្មភាពនីមួយៗ?</span>
				</td>
			</tr>

			<tr id="3.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement: 2 days</span>
					<span class="kh">a. ការចូលរួមសហគមន៍៖ ២ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.a.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.b">
				<td></td>
				<td>
					<span class="en">b. Village Census: 5 days</span>
					<span class="kh">b. ជំរឿនប្រជាជន៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.b.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.c">
				<td></td>
				<td>
					<span class="en">c. LLIN/LLHIN top-up: 5 days</span>
					<span class="kh">c. ការបន្ថែមមុងគ្រែ/មុងអង្រឹង៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.c.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.d">
				<td></td>
				<td>
					<span class="en">d. TDA: 5 days for each round</span>
					<span class="kh">ការអោយថ្នាំដល់ប្រជាជនគោលដៅ៖ ៥ថ្ងៃសម្រាប់ជុំនីមួយៗ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.d.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.e">
				<td></td>
				<td>
					<span class="en">e. AFS: 5 days per week</span>
					<span class="kh">e. ការជួសឈាមប្រចាំសប្ដាហ៍៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.e.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.f">
				<td></td>
				<td>
					<span class="en">f. IPTf: 5 days per week</span>
					<span class="kh">f. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.f.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="4">
				<th>Question 4:</th>
				<td>
					<span class="en">Have you faced challenges in completing LME activities on schedule?</span>
					<span class="kh">តើអ្នកមានបានជួបប្រទះនូវបញ្ហាប្រឈមអ្វីខ្លះក្នុងការបំពេញសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាទៅតាមសកម្មភាពនីមួយៗដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="en">a. If yes:</span>
					<span class="kh">a. បើមាន:</span>
				</td>
			</tr>
			<tr id="4.a.i">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">i. What are the reasons that contributed to delays?</span>
					<span class="kh">i. តើមូលហេតុអ្វីខ្លះដែលរួមចំណែកដល់ការពន្យាពេល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.a.ii">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">ii. What are the steps you have taken to correct these issues?</span>
					<span class="kh">ii. តើអ្នកមានវិធានការអ្វីខ្លះដើម្បីដោះស្រាយបញ្ហាទាំងនេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.b">
				<td></td>
				<td>
					<span class="en">b. If no: What do you think that helps in completing these activities on time?</span>
					<span class="kh">b. បើមិនមាន, តើអ្នកគិតថាអ្វីដែលអាចជួយអ្នកក្នុងការបំពេញសកម្មភាពទាំងនេះទាន់ពេល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.3: Completion and adherence to the drug option</u>
				</td>
			</tr>

			<tr id="5">
				<th>Question 5:</th>
				<td>
					<span class="en">Please share 2-3 things you think have been a barrier to people completing TDA and IPTF in Province:</span>
					<span class="kh">សូមចែករំលែក 2-3រឿងកន្លងមក ដែលអ្នកគិតថាជាឧបសគ្គដល់ការបំពេញការងារ TDA និង IPTF នៅក្នុងខេត្ត</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="5.a">
				<td></td>
				<td>
					<span class="en">a. Follow-up Question (only ask if was not mentioned by the respondent): Have you heard any complaints or received any reports on adverse reactions?</span>
					<span class="kh">តើអ្នកធ្លាប់បានលឺពីការត្អួញត្អែរ ឬ ទទួលបានរបាយការណ៍ណាមួយពីផលរំខាននៃការប្រើប្រាស់ឱសថ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="6">
				<th>Question 6:</th>
				<td>
					<span class="en">Please share 2-3 things that have been helpful</span>
					<span class="kh">សូមចែករំលែក 2-3 រឿងកន្លងមកដែលអ្នកគិតថាមានប្រយោជន៍</span>
				</td>
			</tr>
			<tr id="6.a">
				<td></td>
				<td>
					<span class="en">a. Follow-up Question (only ask if was not mentioned by the respondent): What were the steps taken to encourage the patient to adhere and complete the treatment course?</span>
					<span class="kh">តើមានជំហ៊ានណាមួយដែលបានធ្វើឡើងដើម្បីលើកទឹកចិត្តដល់អ្នកជំងឺឱ្យទទួលបានការព្យាបាលពេញលេញ។</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.4: Usage of the LLIN and LLHIN</u>
				</td>
			</tr>

			<tr id="7">
				<th>Question 7:</th>
				<td>
					<span class="en">Can you tell us about the usage of LLIN among the community and LLHIN among the forest-goers?</span>
					<span class="kh">តើអ្នកអាចប្រាប់បានទេពីការប្រើប្រាស់មុងគ្រែនៅក្នុងសហគមន៍ និង ការប្រើប្រាស់មុងអង្រឹងក្នុងចំណោមអ្នកចូលព្រៃ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="7.a">
				<td></td>
				<td>
					<span class="en">a. Do you think that they are comfortable using the LLIN/LLIHN?</span>
					<span class="kh">a. តើអ្នកគិតថាពួកគេងាយស្រួលប្រើមុងគ្រែ និង មុងអង្រឹងដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">ងាយស្រួល</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="en">b. If no</span>
					<span class="kh">b. បើទេ</span>
				</td>
			</tr>
			<tr id="7.b.i">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">i. What do you think the reason of this?</span>
					<span class="kh">i. តើអ្នកគិតថាមូលហេតុអ្វី?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="7.b.ii">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">ii. How can we address this issue?</span>
					<span class="kh">ii. តើយើងអាចដោះស្រាយបញ្ហានេះដោយរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="8">
				<th>Question 8:</th>
				<td>
					<span class="en">Are there any other factors that help or prevent people in your Province from participating in LME activities?</span>
					<span class="kh">តើមានកត្តាផ្សេងទេដែលជួយដល់ប្រជាជននៅក្នុងខេត្តរបស់អ្នកពីការចូលរួមក្នុងសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<th colspan="3">Indicator 2: Feasibility</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 2.1: Delivery of task and other competing priorities</u></td>
			</tr>

			<tr id="9">
				<th>Question 9:</th>
				<td>
					<span class="en">During the implementation of LME activities, how do you feel your responsibilities have changed or expanded?</span>
					<span class="kh">ក្នុងអំឡុងពេលនៃការអនុវត្តសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លា តើអ្នកមានអារម្មណ៍ថាការទទួលខុសត្រូវរបស់អ្នកបានផ្លាស់ប្តូរ ឬពង្រីកដោយរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="9.a">
				<th></th>
				<td>
					<span class="en">a. How have you managed to prioritize LME work with competing priorities?</span>
					<span class="kh">a. តើអ្នកបានគ្រប់គ្រង ការងារអនុ្ដរគមន៍បន្ទាន់ខ្លាំងក្លាដោយរបៀបណាជាមួយនឹងការងារជាអាទិភាពផ្សេងទៀត?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 2.2: Recording and reporting</u></td>
			</tr>

			<tr id="10">
				<th>Question 10:</th>
				<td>
					<span class="en">How do you feel about using the LME forms (easy, hard, confusing)</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះការប្រើប្រាស់ទម្រង់ជាក្រដាសអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លា? (ងាយស្រួល, ពិបាក, ឬច្រឡំ)</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10.a">
				<th></th>
				<td>
					<span class="en">a. If it is hard or confusing, can you tell us more about which part of the process or form makes it difficult?</span>
					<span class="kh">a. បើវាពិបាក ឬមានការភ័ន្តច្រឡំ, តើអ្នកអាចប្រាប់យើងបន្ថែមអំពីផ្នែកណាមួយនៃដំណើរការ ឬទម្រង់ដែលធ្វើឱ្យពិបាកក្នុងការធ្វើរបាយការណ៍ និងការកត់ត្រាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10.b">
				<th></th>
				<td>
					<span class="en">b. What do you think should be done to address this?</span>
					<span class="kh">b. តើអ្នកគិតថាគួរធ្វើអ្វីដើម្បីដោះស្រាយបញ្ហានេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="11">
				<th>Question 11:</th>
				<td>
					<span class="en">How do you feel about using the LME MIS application to report data? (easy, hard, confusing?)</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះការប្រើប្រាស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាក្នុងប្រព័ន្ធ MIS ក្នុងការរាយការណ៍ទិន្នន័យ? (ងាយស្រួល, ពិបាក, ឬច្រឡំ)?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11.a">
				<th></th>
				<td>
					<span class="en">a. If it is hard or confusing, can you tell us more about which part of the process or form makes it difficult?</span>
					<span class="kh">a. បើវាពិបាក ឬមានការភ័ន្តច្រឡំ, តើអ្នកអាចប្រាប់យើងបន្ថែមអំពីផ្នែកណាមួយនៃដំណើរការ ឬទម្រង់ដែលធ្វើឱ្យពិបាកក្នុងការធ្វើរបាយការណ៍ និងការកត់ត្រាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11.b">
				<th></th>
				<td>
					<span class="en">b. What do you think should be done to address this?</span>
					<span class="kh">b. តើអ្នកគិតថាគួរធ្វើអ្វីដើម្បីដោះស្រាយបញ្ហានេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="12">
				<th>Question 12:</th>
				<td>
					<span class="en">
						Have you received a copy of the LME SOPs and guidelines, or had training on this?
						<br />
						Note: If the respondent did not receive or cannot remember the LME SOPs or guidelines and training, provide him a paper or electronic copy or remind him of the training on LME recently conducted
					</span>
					<span class="kh">
						តើអ្នកបានទទួលច្បាប់ចម្លងនៃនិតិវិធីស្ដង់ដារប្រតិបត្តិរបស់កម្មវិធីអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លា និង គោលការណ៍ណែនាំ ឬមានការបណ្ដុះបណ្ដាលលើបញ្ហានេះដែរឬទេ?
						<br />
						ចំណាំ៖ បើអ្នកឆ្លើយ សំណួរមិនបានទទួល ឬមិនចាំពី និតិវិធីស្ដង់ដារប្រតិបត្តិរបស់កម្មវិធីអន្តាគមន៍បន្ទាន់ខ្លាំងក្លា, គោលការណ៍ណែនាំ និង វគ្គបណ្ដុះបណ្ដាលណាមួយទេ សូមផ្តល់ឯកសារជាក្រដាស ឬច្បាប់ចម្លងអេឡិចត្រូនិចដល់គាត់ ឬ រំលឹកគាត់ពីការ បណ្តុះបណ្តាលលើកម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លា ដែលទើបតែបានធ្វើឡើងនាពេលថ្មីៗនេះ
					</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 2.2: Understanding of the protocols and guideline</u></td>
			</tr>

			<tr id="13">
				<th>Question 13:</th>
				<td>
					<span class="en">how is your understanding of the Last Mile protocols and guidelines?</span>
					<span class="kh">តើអ្នកមានអារម្មណ៍ថាអ្នកយល់ពីពិធីសារ និង គោលការណ៍ណែនាំ របស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="13.a">
				<th></th>
				<td>
					<span class="en">a. If you have a good understanding of it, please share 2-3 things that were most helpful for your understanding?</span>
					<span class="kh">a. បើអ្នកយល់, សូមជួយចែករំលែក ២ ៣ រឿងដែលមានប្រយោជន៍បំផុតសម្រាប់ការយល់ដឹងរបស់អ្នក?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="13.b">
				<th></th>
				<td>
					<span class="en">b. Are there any aspects that you are unclear on? If yes, please describe</span>
					<span class="kh">b. តើមានទិដ្ឋភាពណាមួយដែលអ្នកមិនទាន់ច្បាស់ទេ? បើមានសូមបកស្រាយ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="14">
				<th>Question 14:</th>
				<td>
					<span class="en">What other challenges or barriers have you faced to enable delivery LME activities in your Province?</span>
					<span class="kh">តើមានបញ្ហាប្រឈម ឬឧបសគ្គអ្វីផ្សេង ទៀតដែលអ្នកបានជួបប្រទះ ដើម្បីនៅក្នុងដំណើរការសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លានៅក្នុងខេត្តរបស់អ្នក?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="14.a">
				<th></th>
				<td>
					<span class="en">a. What has helped to complete them?</span>
					<span class="kh">a. តើអ្វីដែលបានជួយដល់ពួកគេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<th colspan="3">Indicator 3: Adaptability</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 3.1: Best practices and corrective measures implemented</u></td>
			</tr>

			<tr id="15">
				<th>Question 15:</th>
				<td>
					<span class="en">Can you give an example of a situation in which your Province faced a challenge in implementing an activity, and describe what solutions were used?</span>
					<span class="kh">តើអ្នកអាចផ្តល់ឧទាហរណ៍អំពីស្ថានភាពដែលខេត្តរបស់អ្នកប្រឈមមុខនឹងបញ្ហាក្នុងការអនុវត្តសកម្មភាព និងពណ៌នា អំពីដំណោះ ស្រាយអ្វីខ្លះដែលត្រូវបានប្រើប្រាស់?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="16">
				<th>Question 16:</th>
				<td>
					<span class="en">What do you think are the best practice or innovations to successfully implement the LME activities?</span>
					<span class="kh">តើអ្នកគិតថាអ្វីជាការអនុវត្តល្អបំផុតដើម្បីអនុវត្តសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាអោយជោគជ័យ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
		</tbody>

		<tbody id="OD">
			<tr>
				<td colspan="3">
					<b>Indicator 1: Acceptability</b>
					<br /><br />
					<u>Sub-indicator 1.1: Attitude of the service providers</u>
				</td>
			</tr>
			<tr>
				<th>Question 1:</th>
				<td colspan="2">
					<span class="en">How would you evaluate each of the following "Last Mile Activities" in your OD? Please rate on the following scale:</span>
					<span class="kh">តើអ្នកវាយតម្លៃសកម្មភាព last mile ក្នុងស្រុករបស់អ្នកដោយរបៀបណា? សូមដាក់ពិន្ទុ:</span>
				</td>
			</tr>
			<tr id="1.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement:</span>
					<span class="kh">a. ការអប់រំនៅសហគមន៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.a.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.b">
				<td></td>
				<td>
					<span class="en">b. Community Engagement Round 2:</span>
					<span class="kh">b. ការអប់រំនៅសហគមន៍លើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.b.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.c">
				<td></td>
				<td>
					<span class="en">c. Village Census:</span>
					<span class="kh">c. ជំរឿនប្រជាជន</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.c.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.d">
				<td></td>
				<td>
					<span class="en">d. Top Up Distribution of LLINs/LLIHNs:</span>
					<span class="kh">d. ការចែកបន្ថែមមុងគ្រែ និង មុងអង្រឹង</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.d.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.e">
				<td></td>
				<td>
					<span class="en">e. Targeted Drug administration (TDA) Round 1:</span>
					<span class="kh">e. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី១</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.e.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.f">
				<td></td>
				<td>
					<span class="en">f. Targeted Drug Administration (TDA) Round 2:</span>
					<span class="kh">f. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.f.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.g">
				<td></td>
				<td>
					<span class="en">g. Active Fever Screening (AFS):</span>
					<span class="kh">g. AFS ការជួសឈាមប្រចាំសប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.g.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.h">
				<td></td>
				<td>
					<span class="en">h. Intermittent Preventive Therapy for Forest-goers (IPTF):</span>
					<span class="kh">h. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.h.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr id="2">
				<th>Question 2:</th>
				<td>
					<span class="en">Do you think the LME activity is making an impact on the community?</span>
					<span class="kh">តើអ្នកគិតថាសកម្មភាពនេះកំពុងមានឥទ្ធិពលដល់សហគមន៍អ្នកដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="2.a">
				<th></th>
				<td>
					<span class="en">a. If yes, in what way?</span>
					<span class="kh">a. បើមាន តើមានតាមរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.2: Timing of delivery</u>
				</td>
			</tr>
			<tr>
				<th>Question 3:</th>
				<td colspan="2">
					<span class="en">What do you think about the timeframe of each activity?</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះរយៈពេលនៃសកម្មភាពនីមួយៗ?</span>
				</td>
			</tr>

			<tr id="3.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement: 2 days</span>
					<span class="kh">a. ការចូលរួមសហគមន៍៖ ២ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.a.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.b">
				<td></td>
				<td>
					<span class="en">b. Village Census: 5 days</span>
					<span class="kh">b. ជំរឿនប្រជាជន៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.b.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.c">
				<td></td>
				<td>
					<span class="en">c. LLIN/LLHIN top-up: 5 days</span>
					<span class="kh">c. ការបន្ថែមមុងគ្រែ/មុងអង្រឹង៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.c.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.d">
				<td></td>
				<td>
					<span class="en">d. TDA: 5 days for each round</span>
					<span class="kh">ការអោយថ្នាំដល់ប្រជាជនគោលដៅ៖ ៥ថ្ងៃសម្រាប់ជុំនីមួយៗ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.d.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.e">
				<td></td>
				<td>
					<span class="en">e. AFS: 5 days per week</span>
					<span class="kh">e. ការជួសឈាមប្រចាំសប្ដាហ៍៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.e.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.f">
				<td></td>
				<td>
					<span class="en">f. IPTf: 5 days per week</span>
					<span class="kh">f. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.f.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="4">
				<th>Question 4:</th>
				<td>
					<span class="en">Have you faced challenges in completing LME activities on schedule?</span>
					<span class="kh">តើអ្នកមានបានជួបប្រទះនូវបញ្ហាប្រឈមអ្វីខ្លះក្នុងការបំពេញសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាទៅតាមសកម្មភាពនីមួយៗដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="en">a. If yes:</span>
					<span class="kh">a. បើមាន:</span>
				</td>
			</tr>
			<tr id="4.a.i">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">i. What are the reasons that contributed to delays?</span>
					<span class="kh">i. តើមូលហេតុអ្វីខ្លះដែលរួមចំណែកដល់ការពន្យាពេល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.a.ii">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">ii. What are the steps you have taken to correct these issues?</span>
					<span class="kh">ii. តើអ្នកមានវិធានការអ្វីខ្លះដើម្បីដោះស្រាយបញ្ហាទាំងនេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.b">
				<td></td>
				<td>
					<span class="en">b. If no: What do you think that helps in completing these activities on time?</span>
					<span class="kh">b. បើមិនមាន, តើអ្នកគិតថាអ្វីដែលអាចជួយអ្នកក្នុងការបំពេញសកម្មភាពទាំងនេះទាន់ពេល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.3: Completion and adherence to the drug option</u>
				</td>
			</tr>

			<tr id="5">
				<th>Question 5:</th>
				<td>
					<span class="en">Please share 2-3 things you think have been a barrier to people completing TDA and IPTF in OD:</span>
					<span class="kh">សូមចែករំលែក 2-3រឿងកន្លងមក ដែលអ្នកគិតថាជាឧបសគ្គដល់ការបំពេញការងារ TDA និង IPTF នៅក្នុងស្រុក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="5.a">
				<td></td>
				<td>
					<span class="en">a. Follow-up Question (only ask if was not mentioned by the respondent): Have you heard any complaints or received any reports on adverse reactions?</span>
					<span class="kh">តើអ្នកធ្លាប់បានលឺពីការត្អួញត្អែរ ឬ ទទួលបានរបាយការណ៍ណាមួយពីផលរំខាននៃការប្រើប្រាស់ឱសថ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="6">
				<th>Question 6:</th>
				<td>
					<span class="en">Please share 2-3 things that have been helpful</span>
					<span class="kh">សូមចែករំលែក 2-3 រឿងកន្លងមកដែលអ្នកគិតថាមានប្រយោជន៍</span>
				</td>
			</tr>
			<tr id="6.a">
				<td></td>
				<td>
					<span class="en">a. Follow-up Question (only ask if was not mentioned by the respondent): What were the steps taken to encourage the patient to adhere and complete the treatment course?</span>
					<span class="kh">តើមានជំហ៊ានណាមួយដែលបានធ្វើឡើងដើម្បីលើកទឹកចិត្តដល់អ្នកជំងឺឱ្យទទួលបានការព្យាបាលពេញលេញ។</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.4: Usage of the LLIN and LLHIN</u>
				</td>
			</tr>

			<tr id="7">
				<th>Question 7:</th>
				<td>
					<span class="en">Can you tell us about the usage of LLIN among the community and LLHIN among the forest-goers?</span>
					<span class="kh">តើអ្នកអាចប្រាប់បានទេពីការប្រើប្រាស់មុងគ្រែនៅក្នុងសហគមន៍ និង ការប្រើប្រាស់មុងអង្រឹងក្នុងចំណោមអ្នកចូលព្រៃ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="7.a">
				<td></td>
				<td>
					<span class="en">a. Do you think that they are comfortable using the LLIN/LLIHN?</span>
					<span class="kh">a. តើអ្នកគិតថាពួកគេងាយស្រួលប្រើមុងគ្រែ និង មុងអង្រឹងដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">ងាយស្រួល</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="en">b. If no</span>
					<span class="kh">b. បើទេ</span>
				</td>
			</tr>
			<tr id="7.b.i">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">i. What do you think the reason of this?</span>
					<span class="kh">i. តើអ្នកគិតថាមូលហេតុអ្វី?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="7.b.ii">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">ii. How can we address this issue?</span>
					<span class="kh">ii. តើយើងអាចដោះស្រាយបញ្ហានេះដោយរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="8">
				<th>Question 8:</th>
				<td>
					<span class="en">Are there any other factors that help or prevent people in your OD from participating in LME activities?</span>
					<span class="kh">តើមានកត្តាផ្សេងទេដែលជួយដល់ប្រជាជននៅក្នុងស្រុករបស់អ្នកពីការចូលរួមក្នុងសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<th colspan="3">Indicator 2: Feasibility</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 2.1: Delivery of task and other competing priorities</u></td>
			</tr>

			<tr id="9">
				<th>Question 9:</th>
				<td>
					<span class="en">During the implementation of LME activities, how do you feel your responsibilities have changed or expanded?</span>
					<span class="kh">ក្នុងអំឡុងពេលនៃការអនុវត្តសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លា តើអ្នកមានអារម្មណ៍ថាការទទួលខុសត្រូវរបស់អ្នកបានផ្លាស់ប្តូរ ឬពង្រីកដោយរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="9.a">
				<th></th>
				<td>
					<span class="en">a. How have you managed to prioritize LME work with competing priorities?</span>
					<span class="kh">a. តើអ្នកបានគ្រប់គ្រង ការងារអនុ្ដរគមន៍បន្ទាន់ខ្លាំងក្លាដោយរបៀបណាជាមួយនឹងការងារជាអាទិភាពផ្សេងទៀត?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 2.2: Recording and reporting</u></td>
			</tr>

			<tr id="10">
				<th>Question 10:</th>
				<td>
					<span class="en">How do you feel about using the LME forms (easy, hard, confusing)</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះការប្រើប្រាស់ទម្រង់ជាក្រដាសអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លា? (ងាយស្រួល, ពិបាក, ឬច្រឡំ)</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10.a">
				<th></th>
				<td>
					<span class="en">a. If it is hard or confusing, can you tell us more about which part of the process or form makes it difficult?</span>
					<span class="kh">a. បើវាពិបាក ឬមានការភ័ន្តច្រឡំ, តើអ្នកអាចប្រាប់យើងបន្ថែមអំពីផ្នែកណាមួយនៃដំណើរការ ឬទម្រង់ដែលធ្វើឱ្យពិបាកក្នុងការធ្វើរបាយការណ៍ និងការកត់ត្រាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10.b">
				<th></th>
				<td>
					<span class="en">b. What do you think should be done to address this?</span>
					<span class="kh">b. តើអ្នកគិតថាគួរធ្វើអ្វីដើម្បីដោះស្រាយបញ្ហានេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="11">
				<th>Question 11:</th>
				<td>
					<span class="en">How do you feel about using the LME MIS application to report data? (easy, hard, confusing?)</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះការប្រើប្រាស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាក្នុងប្រព័ន្ធ MIS ក្នុងការរាយការណ៍ទិន្នន័យ? (ងាយស្រួល, ពិបាក, ឬច្រឡំ)?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11.a">
				<th></th>
				<td>
					<span class="en">a. If it is hard or confusing, can you tell us more about which part of the process or form makes it difficult?</span>
					<span class="kh">a. បើវាពិបាក ឬមានការភ័ន្តច្រឡំ, តើអ្នកអាចប្រាប់យើងបន្ថែមអំពីផ្នែកណាមួយនៃដំណើរការ ឬទម្រង់ដែលធ្វើឱ្យពិបាកក្នុងការធ្វើរបាយការណ៍ និងការកត់ត្រាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11.b">
				<th></th>
				<td>
					<span class="en">b. What do you think should be done to address this?</span>
					<span class="kh">b. តើអ្នកគិតថាគួរធ្វើអ្វីដើម្បីដោះស្រាយបញ្ហានេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="12">
				<th>Question 12:</th>
				<td>
					<span class="en">
						Have you received a copy of the LME SOPs and guidelines, or had training on this?
						<br />
						Note: If the respondent did not receive or cannot remember the LME SOPs or guidelines and training, provide him a paper or electronic copy or remind him of the training on LME recently conducted
					</span>
					<span class="kh">
						តើអ្នកបានទទួលច្បាប់ចម្លងនៃនិតិវិធីស្ដង់ដារប្រតិបត្តិរបស់កម្មវិធីអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លា និង គោលការណ៍ណែនាំ ឬមានការបណ្ដុះបណ្ដាលលើបញ្ហានេះដែរឬទេ?
						<br />
						ចំណាំ៖ បើអ្នកឆ្លើយ សំណួរមិនបានទទួល ឬមិនចាំពី និតិវិធីស្ដង់ដារប្រតិបត្តិរបស់កម្មវិធីអន្តាគមន៍បន្ទាន់ខ្លាំងក្លា, គោលការណ៍ណែនាំ និង វគ្គបណ្ដុះបណ្ដាលណាមួយទេ សូមផ្តល់ឯកសារជាក្រដាស ឬច្បាប់ចម្លងអេឡិចត្រូនិចដល់គាត់ ឬ រំលឹកគាត់ពីការ បណ្តុះបណ្តាលលើកម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លា ដែលទើបតែបានធ្វើឡើងនាពេលថ្មីៗនេះ
					</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 2.2: Understanding of the protocols and guideline</u></td>
			</tr>

			<tr id="13">
				<th>Question 13:</th>
				<td>
					<span class="en">how is your understanding of the Last Mile protocols and guidelines?</span>
					<span class="kh">តើអ្នកមានអារម្មណ៍ថាអ្នកយល់ពី protocols និង guidelines របស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="13.a">
				<th></th>
				<td>
					<span class="en">a. If you have a good understanding of it, please share 2-3 things that were most helpful for your understanding?</span>
					<span class="kh">a. បើអ្នកយល់, សូមជួយចែករំលែក ២ ៣ រឿងដែលមានប្រយោជន៍បំផុតសម្រាប់ការយល់ដឹងរបស់អ្នក?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="13.b">
				<th></th>
				<td>
					<span class="en">b. Are there any aspects that you are unclear on? If yes, please describe</span>
					<span class="kh">b. តើមានទិដ្ឋភាពណាមួយដែលអ្នកមិនទាន់ច្បាស់ទេ? បើមានសូមបកស្រាយ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="14">
				<th>Question 14:</th>
				<td>
					<span class="en">What other challenges or barriers have you faced to enable delivery LME activities in your OD?</span>
					<span class="kh">តើមានបញ្ហាប្រឈម ឬឧបសគ្គអ្វីផ្សេង ទៀតដែលអ្នកបានជួបប្រទះ ដើម្បីនៅក្នុងដំណើរការសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លានៅក្នុងស្រុករបស់អ្នក?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="14.a">
				<th></th>
				<td>
					<span class="en">a. What has helped to complete them?</span>
					<span class="kh">a. តើអ្វីដែលបានជួយដល់ពួកគេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<th colspan="3">Indicator 3: Adaptability</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 3.1: Best practices and corrective measures implemented</u></td>
			</tr>

			<tr id="15">
				<th>Question 15:</th>
				<td>
					<span class="en">Can you give an example of a situation in which your Province faced a challenge in implementing an activity, and describe what solutions were used?</span>
					<span class="kh">តើអ្នកអាចផ្តល់ឧទាហរណ៍អំពីស្ថានភាពដែលស្រុករបស់អ្នកប្រឈមមុខនឹងបញ្ហាក្នុងការអនុវត្តសកម្មភាព និងពណ៌នា អំពីដំណោះ ស្រាយអ្វីខ្លះដែលត្រូវបានប្រើប្រាស់?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="16">
				<th>Question 16:</th>
				<td>
					<span class="en">What do you think are the best practice or innovations to successfully implement the LME activities?</span>
					<span class="kh">តើអ្នកគិតថាអ្វីជាការអនុវត្តល្អបំផុតដើម្បីអនុវត្តសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាអោយជោគជ័យ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
		</tbody>

		<tbody id="HC">
			<tr>
				<td colspan="3">
					<b>Indicator 1: Acceptability</b>
					<br /><br />
					<u>Sub-indicator 1.1: Attitude of the service providers</u>
				</td>
			</tr>
			<tr>
				<th>Question 1:</th>
				<td colspan="2">
					<span class="en">How would you evaluate each of the following "Last Mile Activities" in your HC catchment area? Please rate on the following scale:</span>
					<span class="kh">តើអ្នកវាយតម្លៃសកម្មភាព last mile ក្នុងតំបន់គ្រប់ដណ្តប់ក្រោមមណ្ឌលសុខភាពរបស់អ្នកដោយរបៀបណា? សូមដាក់ពិន្ទុ:</span>
				</td>
			</tr>
			<tr id="1.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement:</span>
					<span class="kh">a. ការអប់រំនៅសហគមន៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.a.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.b">
				<td></td>
				<td>
					<span class="en">b. Community Engagement Round 2:</span>
					<span class="kh">b. ការអប់រំនៅសហគមន៍លើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.b.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.c">
				<td></td>
				<td>
					<span class="en">c. Village Census:</span>
					<span class="kh">c. ជំរឿនប្រជាជន</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.c.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.d">
				<td></td>
				<td>
					<span class="en">d. Top Up Distribution of LLINs/LLIHNs:</span>
					<span class="kh">d. ការចែកបន្ថែមមុងគ្រែ និង មុងអង្រឹង</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.d.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.e">
				<td></td>
				<td>
					<span class="en">e. Targeted Drug administration (TDA) Round 1:</span>
					<span class="kh">e. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី១</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.e.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.f">
				<td></td>
				<td>
					<span class="en">f. Targeted Drug Administration (TDA) Round 2:</span>
					<span class="kh">f. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.f.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.g">
				<td></td>
				<td>
					<span class="en">g. Active Fever Screening (AFS):</span>
					<span class="kh">g. AFS ការជួសឈាមប្រចាំសប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.g.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.h">
				<td></td>
				<td>
					<span class="en">h. Intermittent Preventive Therapy for Forest-goers (IPTF):</span>
					<span class="kh">h. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.h.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr id="2">
				<th>Question 2:</th>
				<td>
					<span class="en">Do you think the LME activity is making an impact on the community?</span>
					<span class="kh">តើអ្នកគិតថាសកម្មភាពនេះកំពុងមានឥទ្ធិពលដល់សហគមន៍អ្នកដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="2.a">
				<th></th>
				<td>
					<span class="en">a. If yes, in what way?</span>
					<span class="kh">a. បើមាន តើមានតាមរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.2: Timing of delivery</u>
				</td>
			</tr>
			<tr>
				<th>Question 3:</th>
				<td colspan="2">
					<span class="en">What do you think about the timeframe of each activity?</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះរយៈពេលនៃសកម្មភាពនីមួយៗ?</span>
				</td>
			</tr>

			<tr id="3.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement: 2 days</span>
					<span class="kh">a. ការចូលរួមសហគមន៍៖ ២ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.a.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.b">
				<td></td>
				<td>
					<span class="en">b. Village Census: 5 days</span>
					<span class="kh">b. ជំរឿនប្រជាជន៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.b.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.c">
				<td></td>
				<td>
					<span class="en">c. LLIN/LLHIN top-up: 5 days</span>
					<span class="kh">c. ការបន្ថែមមុងគ្រែ/មុងអង្រឹង៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.c.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.d">
				<td></td>
				<td>
					<span class="en">d. TDA: 5 days for each round</span>
					<span class="kh">ការអោយថ្នាំដល់ប្រជាជនគោលដៅ៖ ៥ថ្ងៃសម្រាប់ជុំនីមួយៗ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.d.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.e">
				<td></td>
				<td>
					<span class="en">e. AFS: 5 days per week</span>
					<span class="kh">e. ការជួសឈាមប្រចាំសប្ដាហ៍៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.e.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.f">
				<td></td>
				<td>
					<span class="en">f. IPTf: 5 days per week</span>
					<span class="kh">f. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.f.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="4">
				<th>Question 4:</th>
				<td>
					<span class="en">Have you faced challenges in completing LME activities on schedule?</span>
					<span class="kh">តើអ្នកមានបានជួបប្រទះនូវបញ្ហាប្រឈមអ្វីខ្លះក្នុងការបំពេញសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាទៅតាមសកម្មភាពនីមួយៗដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="en">a. If yes:</span>
					<span class="kh">a. បើមាន:</span>
				</td>
			</tr>
			<tr id="4.a.i">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">i. What are the reasons that contributed to delays?</span>
					<span class="kh">i. តើមូលហេតុអ្វីខ្លះដែលរួមចំណែកដល់ការពន្យាពេល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.a.ii">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">ii. What are the steps you have taken to correct these issues?</span>
					<span class="kh">ii. តើអ្នកមានវិធានការអ្វីខ្លះដើម្បីដោះស្រាយបញ្ហាទាំងនេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.b">
				<td></td>
				<td>
					<span class="en">b. If no: What do you think that helps in completing these activities on time?</span>
					<span class="kh">b. បើមិនមាន, តើអ្នកគិតថាអ្វីដែលអាចជួយអ្នកក្នុងការបំពេញសកម្មភាពទាំងនេះទាន់ពេល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.3: Completion and adherence to the drug option</u>
				</td>
			</tr>

			<tr id="5">
				<th>Question 5:</th>
				<td>
					<span class="en">Please share 2-3 things you think have been a barrier to people completing TDA and IPTF in HC:</span>
					<span class="kh">សូមចែករំលែក 2-3រឿងកន្លងមក ដែលអ្នកគិតថាជាឧបសគ្គដល់ការបំពេញការងារ TDA និង IPTF នៅក្នុងមណ្ឌលសុខភាព</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="5.a">
				<td></td>
				<td>
					<span class="en">a. Follow-up Question (only ask if was not mentioned by the respondent): Have you heard any complaints or received any reports on adverse reactions?</span>
					<span class="kh">តើអ្នកធ្លាប់បានលឺពីការត្អួញត្អែរ ឬ ទទួលបានរបាយការណ៍ណាមួយពីផលរំខាននៃការប្រើប្រាស់ឱសថ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="6">
				<th>Question 6:</th>
				<td>
					<span class="en">Please share 2-3 things that have been helpful</span>
					<span class="kh">សូមចែករំលែក 2-3 រឿងកន្លងមកដែលអ្នកគិតថាមានប្រយោជន៍</span>
				</td>
			</tr>
			<tr id="6.a">
				<td></td>
				<td>
					<span class="en">a. Follow-up Question (only ask if was not mentioned by the respondent): What were the steps taken to encourage the patient to adhere and complete the treatment course?</span>
					<span class="kh">តើមានជំហ៊ានណាមួយដែលបានធ្វើឡើងដើម្បីលើកទឹកចិត្តដល់អ្នកជំងឺឱ្យទទួលបានការព្យាបាលពេញលេញ។</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.4: Usage of the LLIN and LLHIN</u>
				</td>
			</tr>

			<tr id="7">
				<th>Question 7:</th>
				<td>
					<span class="en">Can you tell us about the usage of LLIN among the community and LLHIN among the forest-goers?</span>
					<span class="kh">តើអ្នកអាចប្រាប់បានទេពីការប្រើប្រាស់មុងគ្រែនៅក្នុងសហគមន៍ និង ការប្រើប្រាស់មុងអង្រឹងក្នុងចំណោមអ្នកចូលព្រៃ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="7.a">
				<td></td>
				<td>
					<span class="en">a. Do you think that they are comfortable using the LLIN/LLIHN?</span>
					<span class="kh">a. តើអ្នកគិតថាពួកគេងាយស្រួលប្រើមុងគ្រែ និង មុងអង្រឹងដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">ងាយស្រួល</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="en">b. If no</span>
					<span class="kh">b. បើទេ</span>
				</td>
			</tr>
			<tr id="7.b.i">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">i. What do you think the reason of this?</span>
					<span class="kh">i. តើអ្នកគិតថាមូលហេតុអ្វី?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="7.b.ii">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">ii. How can we address this issue?</span>
					<span class="kh">ii. តើយើងអាចដោះស្រាយបញ្ហានេះដោយរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="8">
				<th>Question 8:</th>
				<td>
					<span class="en">Are there any other factors that help or prevent people from participating in LME activities?</span>
					<span class="kh">តើមានកត្តាផ្សេងទេដែលជួយដល់ប្រជាជនក្នុងការចូលរួមក្នុងសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<th colspan="3">Indicator 2: Feasibility</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 2.1: Delivery of task and other competing priorities</u></td>
			</tr>

			<tr id="9">
				<th>Question 9:</th>
				<td>
					<span class="en">During the implementation of LME activities, how do you feel your responsibilities have changed or expanded?</span>
					<span class="kh">ក្នុងអំឡុងពេលនៃការអនុវត្តសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លា តើអ្នកមានអារម្មណ៍ថាការទទួលខុសត្រូវរបស់អ្នកបានផ្លាស់ប្តូរ ឬពង្រីកដោយរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="9.a">
				<th></th>
				<td>
					<span class="en">a. How have you managed to prioritize LME work with competing priorities?</span>
					<span class="kh">a. តើអ្នកបានគ្រប់គ្រង ការងារអនុ្ដរគមន៍បន្ទាន់ខ្លាំងក្លាដោយរបៀបណាជាមួយនឹងការងារជាអាទិភាពផ្សេងទៀត?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 2.2: Recording and reporting</u></td>
			</tr>

			<tr id="10">
				<th>Question 10:</th>
				<td>
					<span class="en">How do you feel about using the LME forms (easy, hard, confusing)</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះការប្រើប្រាស់ទម្រង់ជាក្រដាសអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លា? (ងាយស្រួល, ពិបាក, ឬច្រឡំ)</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10.a">
				<th></th>
				<td>
					<span class="en">a. If it is hard or confusing, can you tell us more about which part of the process or form makes it difficult?</span>
					<span class="kh">a. បើវាពិបាក ឬមានការភ័ន្តច្រឡំ, តើអ្នកអាចប្រាប់យើងបន្ថែមអំពីផ្នែកណាមួយនៃដំណើរការ ឬទម្រង់ដែលធ្វើឱ្យពិបាកក្នុងការធ្វើរបាយការណ៍ និងការកត់ត្រាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10.b">
				<th></th>
				<td>
					<span class="en">b. What do you think should be done to address this?</span>
					<span class="kh">b. តើអ្នកគិតថាគួរធ្វើអ្វីដើម្បីដោះស្រាយបញ្ហានេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="11">
				<th>Question 11:</th>
				<td>
					<span class="en">How do you feel about using the LME MIS application to report data? (easy, hard, confusing?)</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះការប្រើប្រាស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាក្នុងប្រព័ន្ធ MIS ក្នុងការរាយការណ៍ទិន្នន័យ? (ងាយស្រួល, ពិបាក, ឬច្រឡំ)?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11.a">
				<th></th>
				<td>
					<span class="en">a. If it is hard or confusing, can you tell us more about which part of the process or form makes it difficult?</span>
					<span class="kh">a. បើវាពិបាក ឬមានការភ័ន្តច្រឡំ, តើអ្នកអាចប្រាប់យើងបន្ថែមអំពីផ្នែកណាមួយនៃដំណើរការ ឬទម្រង់ដែលធ្វើឱ្យពិបាកក្នុងការធ្វើរបាយការណ៍ និងការកត់ត្រាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11.b">
				<th></th>
				<td>
					<span class="en">b. What do you think should be done to address this?</span>
					<span class="kh">b. តើអ្នកគិតថាគួរធ្វើអ្វីដើម្បីដោះស្រាយបញ្ហានេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 2.2: Understanding of the protocols and guideline</u></td>
			</tr>

			<tr id="12">
				<th>Question 12:</th>
				<td>
					<span class="en">how is your understanding of the Last Mile protocols and guidelines?</span>
					<span class="kh">តើអ្នកមានអារម្មណ៍ថាអ្នកយល់ពីពិធីសារ និង គោលការណ៍ណែនាំ របស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="12.a">
				<th></th>
				<td>
					<span class="en">a. If you have a good understanding of it, please share 2-3 things that were most helpful for your understanding?</span>
					<span class="kh">a. បើអ្នកយល់, សូមជួយចែករំលែក ២ ៣ រឿងដែលមានប្រយោជន៍បំផុតសម្រាប់ការយល់ដឹងរបស់អ្នក?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="12.b">
				<th></th>
				<td>
					<span class="en">b. Are there any aspects that you are unclear on? If yes, please describe</span>
					<span class="kh">b. តើមានទិដ្ឋភាពណាមួយដែលអ្នកមិនទាន់ច្បាស់ទេ? បើមានសូមបកស្រាយ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="13">
				<th>Question 13:</th>
				<td>
					<span class="en">What other challenges or barriers have you faced to enable delivery LME activities?</span>
					<span class="kh">តើមានបញ្ហាប្រឈម ឬឧបសគ្គអ្វីផ្សេង ទៀតដែលអ្នកបានជួបប្រទះ ដើម្បីនៅក្នុងដំណើរការសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="13.a">
				<th></th>
				<td>
					<span class="en">a. What has helped to complete them?</span>
					<span class="kh">a. តើអ្វីដែលបានជួយដល់ពួកគេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<th colspan="3">Indicator 3: Adaptability</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 3.1: Best practices and corrective measures implemented</u></td>
			</tr>

			<tr id="14">
				<th>Question 14:</th>
				<td>
					<span class="en">Can you give an example of a situation in which your Province faced a challenge in implementing an activity, and describe what solutions were used?</span>
					<span class="kh">តើអ្នកអាចផ្តល់ឧទាហរណ៍អំពីស្ថានភាពដែលស្រុករបស់អ្នកប្រឈមមុខនឹងបញ្ហាក្នុងការអនុវត្តសកម្មភាព និងពណ៌នា អំពីដំណោះ ស្រាយអ្វីខ្លះដែលត្រូវបានប្រើប្រាស់?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="15">
				<th>Question 15:</th>
				<td>
					<span class="en">What do you think are the best practice or innovations to successfully implement the LME activities?</span>
					<span class="kh">តើអ្នកគិតថាអ្វីជាការអនុវត្តល្អបំផុតដើម្បីអនុវត្តសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាអោយជោគជ័យ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
		</tbody>

		<tbody id="VMW">
			<tr>
				<td colspan="3">
					<b>Indicator 1: Acceptability</b>
					<br /><br />
					<u>Sub-indicator 1.1: Attitude of the service providers</u>
				</td>
			</tr>
			<tr>
				<th>Question 1:</th>
				<td colspan="2">
					<span class="en">How would you evaluate each of the following "Last Mile Activities" in your assigned village? Please rate on the following scale:</span>
					<span class="kh">តើអ្នកវាយតម្លៃសកម្មភាព last mile ក្នុងភូមិរបស់អ្នកដោយរបៀបណា? សូមដាក់ពិន្ទុ:</span>
				</td>
			</tr>
			<tr id="1.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement:</span>
					<span class="kh">a. ការអប់រំនៅសហគមន៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.a.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.b">
				<td></td>
				<td>
					<span class="en">b. Community Engagement Round 2:</span>
					<span class="kh">b. ការអប់រំនៅសហគមន៍លើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.b.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.c">
				<td></td>
				<td>
					<span class="en">c. Village Census:</span>
					<span class="kh">c. ជំរឿនប្រជាជន</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.c.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.d">
				<td></td>
				<td>
					<span class="en">d. Top Up Distribution of LLINs/LLIHNs:</span>
					<span class="kh">d. ការចែកបន្ថែមមុងគ្រែ និង មុងអង្រឹង</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.d.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.e">
				<td></td>
				<td>
					<span class="en">e. Targeted Drug administration (TDA) Round 1:</span>
					<span class="kh">e. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី១</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.e.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.f">
				<td></td>
				<td>
					<span class="en">f. Targeted Drug Administration (TDA) Round 2:</span>
					<span class="kh">f. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.f.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.g">
				<td></td>
				<td>
					<span class="en">g. Active Fever Screening (AFS):</span>
					<span class="kh">g. AFS ការជួសឈាមប្រចាំសប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.g.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.h">
				<td></td>
				<td>
					<span class="en">h. Intermittent Preventive Therapy for Forest-goers (IPTF):</span>
					<span class="kh">h. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.h.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr id="2">
				<th>Question 2:</th>
				<td>
					<span class="en">Do you think the LME activity is making an impact on the community?</span>
					<span class="kh">តើអ្នកគិតថាសកម្មភាពនេះកំពុងមានឥទ្ធិពលដល់សហគមន៍អ្នកដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="2.a">
				<th></th>
				<td>
					<span class="en">a. If yes, in what way?</span>
					<span class="kh">a. បើមាន តើមានតាមរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.2: Timing of delivery</u>
				</td>
			</tr>
			<tr>
				<th>Question 3:</th>
				<td colspan="2">
					<span class="en">What do you think about the timeframe of each activity?</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះរយៈពេលនៃសកម្មភាពនីមួយៗ?</span>
				</td>
			</tr>

			<tr id="3.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement: 2 days</span>
					<span class="kh">a. ការចូលរួមសហគមន៍៖ ២ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.a.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.b">
				<td></td>
				<td>
					<span class="en">b. Village Census: 5 days</span>
					<span class="kh">b. ជំរឿនប្រជាជន៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.b.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.c">
				<td></td>
				<td>
					<span class="en">c. LLIN/LLHIN top-up: 5 days</span>
					<span class="kh">c. ការបន្ថែមមុងគ្រែ/មុងអង្រឹង៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.c.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.d">
				<td></td>
				<td>
					<span class="en">d. TDA: 5 days for each round</span>
					<span class="kh">ការអោយថ្នាំដល់ប្រជាជនគោលដៅ៖ ៥ថ្ងៃសម្រាប់ជុំនីមួយៗ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.d.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.e">
				<td></td>
				<td>
					<span class="en">e. AFS: 5 days per week</span>
					<span class="kh">e. ការជួសឈាមប្រចាំសប្ដាហ៍៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.e.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.f">
				<td></td>
				<td>
					<span class="en">f. IPTf: 5 days per week</span>
					<span class="kh">f. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.f.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="4">
				<th>Question 4:</th>
				<td>
					<span class="en">Have you faced challenges in completing LME activities on schedule?</span>
					<span class="kh">តើអ្នកមានបានជួបប្រទះនូវបញ្ហាប្រឈមអ្វីខ្លះក្នុងការបំពេញសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាទៅតាមសកម្មភាពនីមួយៗដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="en">a. If yes:</span>
					<span class="kh">a. បើមាន:</span>
				</td>
			</tr>
			<tr id="4.a.i">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">i. What are the reasons that contributed to delays?</span>
					<span class="kh">i. តើមូលហេតុអ្វីខ្លះដែលរួមចំណែកដល់ការពន្យាពេល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.a.ii">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">ii. What are the steps you have taken to correct these issues?</span>
					<span class="kh">ii. តើអ្នកមានវិធានការអ្វីខ្លះដើម្បីដោះស្រាយបញ្ហាទាំងនេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.b">
				<td></td>
				<td>
					<span class="en">b. If no: What do you think that helps in completing these activities on time?</span>
					<span class="kh">b. បើមិនមាន, តើអ្នកគិតថាអ្វីដែលអាចជួយអ្នកក្នុងការបំពេញសកម្មភាពទាំងនេះទាន់ពេល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.3: Completion and adherence to the drug option</u>
				</td>
			</tr>

			<tr id="5">
				<th>Question 5:</th>
				<td>
					<span class="en">Please share 2-3 things you think have been a barrier to people completing TDA and IPTF in assigned village:</span>
					<span class="kh">សូមចែករំលែក 2-3រឿងកន្លងមក ដែលអ្នកគិតថាជាឧបសគ្គដល់ការបំពេញការងារ TDA និង IPTF នៅក្នុងភូមិ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="5.a">
				<td></td>
				<td>
					<span class="en">a. Follow-up Question (only ask if was not mentioned by the respondent): Have you heard any complaints or received any reports on adverse reactions?</span>
					<span class="kh">តើអ្នកធ្លាប់បានលឺពីការត្អួញត្អែរ ឬ ទទួលបានរបាយការណ៍ណាមួយពីផលរំខាននៃការប្រើប្រាស់ឱសថ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="6">
				<th>Question 6:</th>
				<td>
					<span class="en">Please share 2-3 things that have been helpful</span>
					<span class="kh">សូមចែករំលែក 2-3 រឿងកន្លងមកដែលអ្នកគិតថាមានប្រយោជន៍</span>
				</td>
			</tr>
			<tr id="6.a">
				<td></td>
				<td>
					<span class="en">a. Follow-up Question (only ask if was not mentioned by the respondent): What were the steps taken to encourage the patient to adhere and complete the treatment course?</span>
					<span class="kh">តើមានជំហ៊ានណាមួយដែលបានធ្វើឡើងដើម្បីលើកទឹកចិត្តដល់អ្នកជំងឺឱ្យទទួលបានការព្យាបាលពេញលេញ។</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.4: Usage of the LLIN and LLHIN</u>
				</td>
			</tr>

			<tr id="7">
				<th>Question 7:</th>
				<td>
					<span class="en">Can you tell us about the usage of LLIN among the community and LLHIN among the forest-goers?</span>
					<span class="kh">តើអ្នកអាចប្រាប់បានទេពីការប្រើប្រាស់មុងគ្រែនៅក្នុងសហគមន៍ និង ការប្រើប្រាស់មុងអង្រឹងក្នុងចំណោមអ្នកចូលព្រៃ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="7.a">
				<td></td>
				<td>
					<span class="en">a. Do you think that they are comfortable using the LLIN/LLIHN?</span>
					<span class="kh">a. តើអ្នកគិតថាពួកគេងាយស្រួលប្រើមុងគ្រែ និង មុងអង្រឹងដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">ងាយស្រួល</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<span class="en">b. If no</span>
					<span class="kh">b. បើទេ</span>
				</td>
			</tr>
			<tr id="7.b.i">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">i. What do you think the reason of this?</span>
					<span class="kh">i. តើអ្នកគិតថាមូលហេតុអ្វី?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="7.b.ii">
				<td></td>
				<td style="padding-left:30px">
					<span class="en">ii. How can we address this issue?</span>
					<span class="kh">ii. តើយើងអាចដោះស្រាយបញ្ហានេះដោយរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="8">
				<th>Question 8:</th>
				<td>
					<span class="en">Are there any other factors that help or prevent people from participating in LME activities?</span>
					<span class="kh">តើមានកត្តាផ្សេងទេដែលជួយដល់ប្រជាជនក្នុងការចូលរួមក្នុងសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<th colspan="3">Indicator 2: Feasibility</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 2.1: Delivery of task and other competing priorities</u></td>
			</tr>

			<tr id="9">
				<th>Question 9:</th>
				<td>
					<span class="en">During the implementation of LME activities, how do you feel your responsibilities have changed or expanded?</span>
					<span class="kh">ក្នុងអំឡុងពេលនៃការអនុវត្តសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លា តើអ្នកមានអារម្មណ៍ថាការទទួលខុសត្រូវរបស់អ្នកបានផ្លាស់ប្តូរ ឬពង្រីកដោយរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="9.a">
				<th></th>
				<td>
					<span class="en">a. How have you managed to prioritize LME work with competing priorities?</span>
					<span class="kh">a. តើអ្នកបានគ្រប់គ្រង ការងារអនុ្ដរគមន៍បន្ទាន់ខ្លាំងក្លាដោយរបៀបណាជាមួយនឹងការងារជាអាទិភាពផ្សេងទៀត?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 2.2: Recording and reporting</u></td>
			</tr>

			<tr id="10">
				<th>Question 10:</th>
				<td>
					<span class="en">How do you feel about using the LME forms (easy, hard, confusing)</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះការប្រើប្រាស់ទម្រង់ជាក្រដាសអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លា? (ងាយស្រួល, ពិបាក, ឬច្រឡំ)</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10.a">
				<th></th>
				<td>
					<span class="en">a. If it is hard or confusing, can you tell us more about which part of the process or form makes it difficult?</span>
					<span class="kh">a. បើវាពិបាក ឬមានការភ័ន្តច្រឡំ, តើអ្នកអាចប្រាប់យើងបន្ថែមអំពីផ្នែកណាមួយនៃដំណើរការ ឬទម្រង់ដែលធ្វើឱ្យពិបាកក្នុងការធ្វើរបាយការណ៍ និងការកត់ត្រាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10.b">
				<th></th>
				<td>
					<span class="en">b. What do you think should be done to address this?</span>
					<span class="kh">b. តើអ្នកគិតថាគួរធ្វើអ្វីដើម្បីដោះស្រាយបញ្ហានេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="11">
				<th>Question 11:</th>
				<td>
					<span class="en">How do you feel about using the LME MIS application to report data? (easy, hard, confusing?)</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះការប្រើប្រាស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាក្នុងប្រព័ន្ធ MIS ក្នុងការរាយការណ៍ទិន្នន័យ? (ងាយស្រួល, ពិបាក, ឬច្រឡំ)?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11.a">
				<th></th>
				<td>
					<span class="en">a. If it is hard or confusing, can you tell us more about which part of the process or form makes it difficult?</span>
					<span class="kh">a. បើវាពិបាក ឬមានការភ័ន្តច្រឡំ, តើអ្នកអាចប្រាប់យើងបន្ថែមអំពីផ្នែកណាមួយនៃដំណើរការ ឬទម្រង់ដែលធ្វើឱ្យពិបាកក្នុងការធ្វើរបាយការណ៍ និងការកត់ត្រាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11.b">
				<th></th>
				<td>
					<span class="en">b. What do you think should be done to address this?</span>
					<span class="kh">b. តើអ្នកគិតថាគួរធ្វើអ្វីដើម្បីដោះស្រាយបញ្ហានេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 2.2: Understanding of the protocols and guideline</u></td>
			</tr>

			<tr id="12">
				<th>Question 12:</th>
				<td>
					<span class="en">how is your understanding of the Last Mile protocols and guidelines?</span>
					<span class="kh">តើអ្នកមានអារម្មណ៍ថាអ្នកយល់ពីពិធីសារ និង គោលការណ៍ណែនាំ របស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="12.a">
				<th></th>
				<td>
					<span class="en">a. If you have a good understanding of it, please share 2-3 things that were most helpful for your understanding?</span>
					<span class="kh">a. បើអ្នកយល់, សូមជួយចែករំលែក ២ ៣ រឿងដែលមានប្រយោជន៍បំផុតសម្រាប់ការយល់ដឹងរបស់អ្នក?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="12.b">
				<th></th>
				<td>
					<span class="en">b. Are there any aspects that you are unclear on? If yes, please describe</span>
					<span class="kh">b. តើមានទិដ្ឋភាពណាមួយដែលអ្នកមិនទាន់ច្បាស់ទេ? បើមានសូមបកស្រាយ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="13">
				<th>Question 13:</th>
				<td>
					<span class="en">What other challenges or barriers have you faced to enable delivery LME activities?</span>
					<span class="kh">តើមានបញ្ហាប្រឈម ឬឧបសគ្គអ្វីផ្សេង ទៀតដែលអ្នកបានជួបប្រទះ ដើម្បីនៅក្នុងដំណើរការសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="13.a">
				<th></th>
				<td>
					<span class="en">a. What has helped to complete them?</span>
					<span class="kh">a. តើអ្វីដែលបានជួយដល់ពួកគេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<th colspan="3">Indicator 3: Adaptability</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 3.1: Best practices and corrective measures implemented</u></td>
			</tr>

			<tr id="14">
				<th>Question 14:</th>
				<td>
					<span class="en">Can you give an example of a situation in which your Province faced a challenge in implementing an activity, and describe what solutions were used?</span>
					<span class="kh">តើអ្នកអាចផ្តល់ឧទាហរណ៍អំពីស្ថានភាពដែលស្រុករបស់អ្នកប្រឈមមុខនឹងបញ្ហាក្នុងការអនុវត្តសកម្មភាព និងពណ៌នា អំពីដំណោះ ស្រាយអ្វីខ្លះដែលត្រូវបានប្រើប្រាស់?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="15">
				<th>Question 15:</th>
				<td>
					<span class="en">What do you think are the best practice or innovations to successfully implement the LME activities?</span>
					<span class="kh">តើអ្នកគិតថាអ្វីជាការអនុវត្តល្អបំផុតដើម្បីអនុវត្តសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាអោយជោគជ័យ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
		</tbody>

		<tbody id="Vill">
			<tr>
				<td colspan="3">
					<b>Indicator 1: Acceptability</b>
					<br /><br />
					<u>Sub-indicator 1.1: Attitude of the service providers</u>
				</td>
			</tr>
			<tr>
				<th>Question 1:</th>
				<td colspan="2">
					<span class="en">How would you evaluate each of the following "Last Mile Activities" in your village? Please rate on the following scale:</span>
					<span class="kh">តើអ្នកវាយតម្លៃសកម្មភាព last mile ក្នុងភូមិរបស់អ្នកដោយរបៀបណា? សូមដាក់ពិន្ទុ:</span>
				</td>
			</tr>
			<tr id="1.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement:</span>
					<span class="kh">a. ការអប់រំនៅសហគមន៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.a.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.b">
				<td></td>
				<td>
					<span class="en">b. Community Engagement Round 2:</span>
					<span class="kh">b. ការអប់រំនៅសហគមន៍លើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.b.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.c">
				<td></td>
				<td>
					<span class="en">c. Village Census:</span>
					<span class="kh">c. ជំរឿនប្រជាជន</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.c.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.d">
				<td></td>
				<td>
					<span class="en">d. Top Up Distribution of LLINs/LLIHNs:</span>
					<span class="kh">d. ការចែកបន្ថែមមុងគ្រែ និង មុងអង្រឹង</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.d.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.e">
				<td></td>
				<td>
					<span class="en">e. Targeted Drug administration (TDA) Round 1:</span>
					<span class="kh">e. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី១</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.e.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.f">
				<td></td>
				<td>
					<span class="en">f. Targeted Drug Administration (TDA) Round 2:</span>
					<span class="kh">f. ការអោយថ្នាំដល់ក្រុមប្រជាជនគោលដៅលើកទី២</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.f.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.g">
				<td></td>
				<td>
					<span class="en">g. Active Fever Screening (AFS):</span>
					<span class="kh">g. AFS ការជួសឈាមប្រចាំសប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.g.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="1.h">
				<td></td>
				<td>
					<span class="en">h. Intermittent Preventive Therapy for Forest-goers (IPTF):</span>
					<span class="kh">h. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">0. Don't know</span>
							<span class="kh">0. មិនដឹង</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">1. Very Poor</span>
							<span class="kh">1. ខ្សោយណាស់</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">2. Poor</span>
							<span class="kh">2. ខ្សោយ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">3. Average</span>
							<span class="kh">3. មធ្យម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">4. Good</span>
							<span class="kh">4. ល្អ</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">5. Excellent</span>
							<span class="kh">5. ល្អណាស់</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="1.h.why">
				<td></td>
				<td>
					<span class="en">Please explain why you assigned each activity the score:</span>
					<span class="kh">សូមពន្យល់ពីមូលហេតុដែលអ្នកបានកំណត់ពិន្ទុសកម្មភាពនីមួយៗ</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr id="2">
				<th>Question 2:</th>
				<td>
					<span class="en">Do you think the LME activity is making an impact on the community?</span>
					<span class="kh">តើអ្នកគិតថាសកម្មភាពនេះកំពុងមានឥទ្ធិពលដល់សហគមន៍អ្នកដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="2.a">
				<th></th>
				<td>
					<span class="en">a. If yes, in what way?</span>
					<span class="kh">a. បើមាន តើមានតាមរបៀបណា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			
			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.2: Timing of delivery</u>
				</td>
			</tr>
			<tr>
				<th>Question 3:</th>
				<td colspan="2">
					<span class="en">What do you think about the timeframe of each activity?</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះរយៈពេលនៃសកម្មភាពនីមួយៗ?</span>
				</td>
			</tr>

			<tr id="3.a">
				<td></td>
				<td>
					<span class="en">a. Community Engagement: 2 days</span>
					<span class="kh">a. ការចូលរួមសហគមន៍៖ ២ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.a.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.b">
				<td></td>
				<td>
					<span class="en">b. Village Census: 5 days</span>
					<span class="kh">b. ជំរឿនប្រជាជន៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.b.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.c">
				<td></td>
				<td>
					<span class="en">c. LLIN/LLHIN top-up: 5 days</span>
					<span class="kh">c. ការបន្ថែមមុងគ្រែ/មុងអង្រឹង៖ ៥ថ្ងៃ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.c.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.d">
				<td></td>
				<td>
					<span class="en">d. TDA: 5 days for each round</span>
					<span class="kh">ការអោយថ្នាំដល់ប្រជាជនគោលដៅ៖ ៥ថ្ងៃសម្រាប់ជុំនីមួយៗ</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.d.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.e">
				<td></td>
				<td>
					<span class="en">e. AFS: 5 days per week</span>
					<span class="kh">e. ការជួសឈាមប្រចាំសប្ដាហ៍៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.e.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3.f">
				<td></td>
				<td>
					<span class="en">f. IPTf: 5 days per week</span>
					<span class="kh">f. ការផ្ដល់ថ្នាំដល់ប្រជាជនមុនចូលព្រៃ៖ ៥ថ្ងៃក្នុង១សប្ដាហ៍</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too short</span>
							<span class="kh">ខ្លីពេក</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">adequate</span>
							<span class="kh">ល្មម</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">too long</span>
							<span class="kh">វែងពេក</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="3.f.why">
				<td></td>
				<td>
					<span class="en">Please explain if it is too short or long:</span>
					<span class="kh">សូមពន្យល់បើវាខ្លីពេក ឬវែងពេក</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 1.3: Completion and adherence to the drug option:</u></td>
			</tr>

			<tr id="4">
				<th>Question 4:</th>
				<td>
					<span class="en">What do you think about people in your village taking TDA or IPTf?</span>
					<span class="kh">តើអ្នកគិតយ៉ាងណាចំពោះប្រជាជនក្នុងភូមិរបស់អ្នកដែលទទួល TDA ឬ IPTf?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.a">
				<td></td>
				<td>
					<span class="en">a. What are some reasons people in your village are hesitant to take medication for TDA or IPTf?</span>
					<span class="kh">a. តើហេតុផលអ្វីខ្លះដែលប្រជាជននៅក្នុងភូមិរបស់អ្នកស្ទាក់ស្ទើរនៅក្នុងការលេបថ្នាំសម្រាប់ TDA ឬ IPTf?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.b">
				<td></td>
				<td>
					<span class="en">b. What are some reasons which have encouraged them to participate?</span>
					<span class="kh">b. តើមានហេតុផលអ្វីខ្លះដែលជំរុញឱ្យពួកគេចូលរួម?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3">
					<u>Sub-indicator 1.4: Usage of the LLIN and LLHIN</u>
				</td>
			</tr>

			<tr id="5">
				<th>Question 5:</th>
				<td>
					<span class="en">Can you tell us about people using LLIN or LLHIN in your village?</span>
					<span class="kh">តើអ្នកអាចប្រាប់បានទេពីការប្រើប្រាស់មុងគ្រែ ឬ មុងអង្រឹងនៅក្នុងភូមិរបស់អ្នក?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="5.a">
				<td></td>
				<td>
					<span class="en">a. What are some reasons people in your village do not use a bed-net?</span>
					<span class="kh">a. តើមានមូលហេតុអ្វីខ្លះដែលធ្វើអោយប្រជាជនក្នុងភូមិរបស់អ្នកមិនប្រើប្រាស់មុង?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="5.b">
				<td></td>
				<td>
					<span class="en">b. What are some reasons which encourage them to use them?</span>
					<span class="kh">b. តើមានមូលហេតុអ្វីខ្លះដែលជំរុញឱ្យពួកគាត់ប្រើប្រាស់មុងវិញ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="6">
				<th>Question 6:</th>
				<td>
					<span class="en">Are there any other factors that help or prevent people in your village from participating in LME activities?</span>
					<span class="kh">តើមានកត្តាផ្សេងទេដែលជួយដល់ប្រជាជននៅក្នុងភូមិរបស់អ្នកពីការចូលរួមក្នុងសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
		</tbody>

		<tbody id="Pop">
			<tr>
				<th colspan="3">Indicator 1: Knowledge/awareness</th>
			</tr>

			<tr id="1">
				<th>Question 1:</th>
				<td>
					<span class="en">Have you heard about malaria?</span>
					<span class="kh">តើអ្នកធ្លាប់លឺពីជំងឺគ្រុនចាញ់ដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="1.a">
				<th></th>
				<td>
					<span class="en">a. If no, interviewer has to provide basic information about malaria?</span>
					<span class="kh">a. បើអត់ធ្លាប់លឺ, អ្នកសម្ភាសន៍ត្រូវផ្ដល់ព័ត៌មានជាមូលដ្ឋានខ្លះៗអំពីជំងឺគ្រុនចាញ់?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="1.b">
				<th></th>
				<td>
					<span class="en">b. If yes, can you tell us about malaria?</span>
					<span class="kh">b. បើធ្លាប់លឺ, តើអ្នកអាចប្រាប់យើងបានទេពីជំងឺគ្រុនចាញ់?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="2">
				<th>Question 2:</th>
				<td>
					<span class="en">Have you or anyone in your family or someone that you know of recently got infected by malaria?</span>
					<span class="kh">តើអ្នក ឬនរណាម្នាក់ក្នុងគ្រួសាររបស់អ្នក ឬមាននរណាម្នាក់ដែលអ្នកស្គាល់ បានឆ្លងជំងឺគ្រុនចាញ់ដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="2.a">
				<th></th>
				<td>
					<span class="en">a. If yes, can you tell us what happened to the patient?</span>
					<span class="kh">a. បើមាន, តើអ្នកអាចប្រាប់យើងបានទេថាមានអ្វីកើតឡើងចំពោះអ្នកជំងឺ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="2.b">
				<th></th>
				<td>
					<span class="en">b. What do you think about the process of accessing the testing services and treatment?</span>
					<span class="kh">b. តើអ្នកយល់យ៉ាងណាចំពោះដំណើរការនៃការទទួលបានការព្យាបាល?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="3">
				<th>Question 3:</th>
				<td colspan="2">
					<span class="en">[Vignette] A young man in this neighborhood has gone to the forest for logging in past 14 days ago. He received an IPTf from VMW/MMW but forgot to take it. 2 days ago, he had a fever.</span>
					<span class="kh">ការពិពណ៌នាសង្ខេប៖ យុវជនម្នាក់នៅក្នុងស្រុកភូមិជាមួយគ្នា បានចូលព្រៃកាប់ឈើកាលពី១៤ថ្ងៃមុន។ គាត់បានទទួលថ្នាំការពារមុនចូលព្រៃពីអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់ ប៉ុន្តែគាត់បានភ្លេចលេបថ្នាំ។ ២ថ្ងៃបន្ទាប់ យុវជននោះក៏មានអាការៈគ្រុនក្តៅ។</span>
				</td>
			</tr>
			<tr id="3.a">
				<th></th>
				<td>
					<span class="en">a. What do you think happened to a young man?</span>
					<span class="kh">a. តើអ្នកគិតថាមានអ្វីកើតឡើងចំពោះយុវជនម្នាក់នោះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="3.b">
				<th></th>
				<td>
					<span class="en">b. What should he do?</span>
					<span class="kh">b. តើគាត់គួរតែធ្វើដូចម្ដេច?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr>
				<td colspan="3">
					<i>
						<span class="en">Note: The interviewer should note if the respondent was able to recognize the likely malaria infection and know where is the nearest to health center/ VMW/MMW where they can seek for malaria testing services.</span>
						<span class="kh">ចំណាំ៖ អ្នកសម្ភាសន៍គួរកត់សម្គាល់ បើអ្នកឆ្លើយតបបានដឹងពីជំងឺគ្រុនចាញ់ និងដឹងថាមណ្ឌលសុខភាពណា ឬ VMW/MMW ដែលនៅជិតបំផុតដែលពួកគេអាចស្វែងរកសេវាធ្វើតេស្តរកជំងឺគ្រុនចាញ់បាន</span>
					</i>
				</td>
			</tr>

			<tr>
				<th colspan="3">Indicator 2: Acceptability</th>
			</tr>
			<tr>
				<td colspan="3"><u>Sub-indicator 2.1: Attitude of the service providers (HC/VMW/MMW)</u></td>
			</tr>

			<tr id="4">
				<th>Question 4:</th>
				<td>
					<span class="en">Can you share your overall experience receiving [LME activities] in your village?</span>
					<span class="kh">តើអ្នកអាចចែករំលែកបទពិសោធន៍របស់អ្នកបានទេនៅពេលដែលអ្នកទទួលបានសេវាកម្មពីកម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លានៅក្នុងភូមិរបស់អ្នក?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="4.a">
				<th></th>
				<td>
					<span class="en">a. What do you think about the LME services received from the VMW/MMW?</span>
					<span class="kh">a. តើអ្នកគិតយ៉ាងដូចម្ដេចចំពោះការផ្ដល់សេវារបស់កម្មវិធីអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាពី VMW/MMW?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 3: Timing of delivery</u></td>
			</tr>

			<tr id="5">
				<th>Question 5:</th>
				<td>
					<span class="en">Have you faced any challenges in participating in [LME activities] due to the timing of their delivery?</span>
					<span class="kh">តើអ្នកបានជួបប្រទះនូវបញ្ហាប្រឈមអ្វីខ្លះក្នុងការចូលរួមក្នុងសកម្មភាពអន្ដរាគមន៍បន្ទាន់ខ្លាំងក្លាដោយសារតែកត្តាពេលវេលាដែរឬទេ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="5.a">
				<th></th>
				<td>
					<span class="en">a. If yes, can you share what would improve your ability to participate in these activities?</span>
					<span class="kh">a. តើអ្នកគិតថាអ្វីដែលនឹងជួយពង្រឹងដល់សមត្ថភាពអ្នកភូមិរបស់អ្នកក្នុងការចូលរួមសកម្មភាពទាំងនេះ?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 4: Completion and adherence to the drug option</u></td>
			</tr>

			<tr id="6">
				<th>Question 6:</th>
				<td>
					<span class="en">What do you think about taking in the TDA or IPTf drugs?</span>
					<span class="kh">តើអ្នកគិតយ៉ាងដូចម្ដេចចំពោះការទទួលថ្នាំ TDA ឬ IPTF?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr id="7">
				<th>Question 7:</th>
				<td>
					<span class="en">Were there any instances that you missed or refused to take these medicines?</span>
					<span class="kh">តើមានករណីណាមួយដែលអ្នកខកខាន ឬបដិសេធមិនលេបថ្នាំទាំងនេះដែរឬទេ?</span>
				</td>
				<td class="form-inline">
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">Yes</span>
							<span class="kh">មាន</span>
						</label>
					</div>
					<div class="radio radio-lg">
						<label>
							<input type="radio" data-bind="checked: getAnswer($element)" />
							<span class="en">No</span>
							<span class="kh">ទេ</span>
						</label>
					</div>
				</td>
			</tr>
			<tr id="7.a">
				<th></th>
				<td>
					<span class="en">a. If yes, what is the reason?</span>
					<span class="kh">a. បើមាន, តើមកពីមូលហេតុអ្វី?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>

			<tr>
				<td colspan="3"><u>Sub-indicator 5: Usage of the LLIN and LLHIN</u></td>
			</tr>

			<tr id="8">
				<th>Question 8:</th>
				<td>
					<span class="en">What are some reasons you or your family may not use a bed-net?</span>
					<span class="kh">តើមានហេតុផលអ្វីខ្លះដែលអ្នក ឬគ្រួសាររបស់អ្នកមិនប្រើមុង?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="9">
				<th>Question 9:</th>
				<td>
					<span class="en">What are some reasons why you use them?</span>
					<span class="kh">តើមានហេតុផលអ្វីខ្លះដែលអ្នកប្រើមុង?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="10">
				<th>Question 10:</th>
				<td>
					<span class="en">What are there any other factors that help you participating in [LME activities]?</span>
					<span class="kh">តើមានកត្តាផ្សេងទេដែលជំរុញអ្នកចូលរួមក្នុងសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
			<tr id="11">
				<th>Question 11:</th>
				<td>
					<span class="en">What are there any other factors that prevent you from participating in [LME activities]?</span>
					<span class="kh">តើមានកត្តាផ្សេងទេដែលរារាំងអ្នកពីការចូលរួមក្នុងសកម្មភាពអន្តរាគមន៍បន្ទាន់ខ្លាំងក្លា?</span>
				</td>
				<td><input type="text" class="form-control input-sm" data-bind="value: getAnswer($element)" /></td>
			</tr>
		</tbody>
	</table>
</div>