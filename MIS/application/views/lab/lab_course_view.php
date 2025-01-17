<style>
	table input { width: 100%; border: none; background: transparent; }
	thead th { text-align: center; vertical-align: middle !important; }
	tbody td { vertical-align: middle !important; }
	.black-border th, .black-border td { border: 1px solid !important; }
	td:has(input) { padding: 4px !important; }
</style>

<?php $this->view('lab/lab_menu'); ?>

<div class="panel panel-default" data-bind="visible: view() == 'list'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh26 font16" style="position:sticky; left:21px">
			<b>Malaria National Reference Laboratory System</b>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<a href="/Home" class="btn btn-sm btn-home">Home</a>
		</div>
	</div>

	<div class="panel-heading clearfix">
		<div class="pull-left" style="position:sticky; left:21px">
			<?php $this->view('lab/lab_menu_'.$menu); ?>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: view() == 'list'">
		<table class="table table-bordered widthauto">
			<thead class="bg-thead">
				<tr>
					<th width="40">#</th>
					<th>Date From</th>
					<th>Date To</th>
					<th>Venue</th>
					<th>Detail</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td align="center" data-bind="text: moment(DateFrom).displayformat()"></td>
					<td align="center" data-bind="text: moment(DateTo).displayformat()"></td>
					<td align="center" data-bind="text: Venue"></td>
					<td align="center">
						<a data-bind="click: $root.showDetail">Detail</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">

	<div class="panel-heading clearfix">
		<div class="pull-left lh26" style="position:sticky; left:21px">
			<div class="input-group input-group-sm">
				<span class="input-group-addon text-bold">Total Participant</span>
				<input type="text" class="form-control text-center width100 text-bold" data-bind="value: participant" readonly />
			</div>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<button class="btn btn-sm btn-primary width80" data-bind="click: save">Save</button>
			<button class="btn btn-sm btn-default width80" data-bind="click: back">Back</button>
		</div>
	</div>

	<div class="panel-body">
		<table class="table table-bordered widthauto black-border">
			<thead class="bg-thead">
				<tr>
					<th colspan="2">Questionnaire of Training Evaluation</th>
					<th colspan="4">Total</th>
					<th rowspan="2" width="120">SATISFACTORY INDEX (%)</th>
				</tr>
				<tr>
					<th colspan="2" align="left">A. Overall assessment of the training activity</th>
					<th width="80">1</th>
					<th width="80">2</th>
					<th width="80">4</th>
					<th width="80">5</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td align="center">1</td>
					<td width="700">The training covered all the subject matter in adequate detail according to the stated course objectives (if you disagree with this, which subjects/topics should have been given more coverage?).</td>
					<!-- ko foreach: [1,2,4,5] -->
					<td onclick="$(this).find('input').focus()" style="cursor:text; background:yellow">
						<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getTotal($element,$data)" />
					</td>
					<!-- /ko -->
					<th align="center" valign="middle" data-bind="text: $root.getPercent($element)" style="background:#92D050"></th>
				</tr>
				<tr>
					<td align="center">2</td>
					<td>The trainers/facilitators for the training course had sufficient knowledge and teaching abilities.</td>
					<!-- ko foreach: [1,2,4,5] -->
					<td onclick="$(this).find('input').focus()" style="cursor:text; background:yellow">
						<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getTotal($element,$data)" />
					</td>
					<!-- /ko -->
					<th align="center" valign="middle" data-bind="text: $root.getPercent($element)" style="background:#92D050"></th>
				</tr>
				<tr>
					<td align="center">3</td>
					<td>The time allotted to each part of the training was adequate relative to the total time available. (If you disagree with this particular topic/activity should have been given more time?).</td>
					<!-- ko foreach: [1,2,4,5] -->
					<td onclick="$(this).find('input').focus()" style="cursor:text; background:yellow">
						<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getTotal($element,$data)" />
					</td>
					<!-- /ko -->
					<th align="center" valign="middle" data-bind="text: $root.getPercent($element)" style="background:#92D050"></th>
				</tr>
				<tr>
					<th colspan="7">B. Assessment of teaching-learning materials</th>
				</tr>
				<tr>
					<td align="center">4</td>
					<td>The audiovisual materials (Power point presentations and  slide sets) used in the training were very helpful</td>
					<!-- ko foreach: [1,2,4,5] -->
					<td onclick="$(this).find('input').focus()" style="cursor:text; background:yellow">
						<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getTotal($element,$data)" />
					</td>
					<!-- /ko -->
					<th align="center" valign="middle" data-bind="text: $root.getPercent($element)" style="background:#92D050"></th>
				</tr>
				<tr>
					<td align="center">5</td>
					<td>The course materials (training kits, hand-outs, etc.) provided were satisfactory</td>
					<!-- ko foreach: [1,2,4,5] -->
					<td onclick="$(this).find('input').focus()" style="cursor:text; background:yellow">
						<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getTotal($element,$data)" />
					</td>
					<!-- /ko -->
					<th align="center" valign="middle" data-bind="text: $root.getPercent($element)" style="background:#92D050"></th>
				</tr>
				<tr>
					<th colspan="7">C. Implementation of training and accommodation</th>
				</tr>
				<tr>
					<td align="center">6</td>
					<td>The accommodation provided for the trainees was satisfactory</td>
					<!-- ko foreach: [1,2,4,5] -->
					<td onclick="$(this).find('input').focus()" style="cursor:text; background:yellow">
						<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getTotal($element,$data)" />
					</td>
					<!-- /ko -->
					<th align="center" valign="middle" data-bind="text: $root.getPercent($element)" style="background:#92D050"></th>
				</tr>
				<tr>
					<td align="center">7</td>
					<td>The objectives of the training course were satisfactorily achieved</td>
					<!-- ko foreach: [1,2,4,5] -->
					<td onclick="$(this).find('input').focus()" style="cursor:text; background:yellow">
						<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getTotal($element,$data)" />
					</td>
					<!-- /ko -->
					<th align="center" valign="middle" data-bind="text: $root.getPercent($element)" style="background:#92D050"></th>
				</tr>
				<tr>
					<th colspan="7">D. Overall evaluation of the training</th>
				</tr>
				<tr>
					<td align="center">8</td>
					<td>What overall rating would you give to this training course</td>
					<!-- ko foreach: [1,2,4,5] -->
					<td onclick="$(this).find('input').focus()" style="cursor:text; background:yellow">
						<input type="text" class="text-center" numonly="int" data-bind="textInput: $root.getTotal($element,$data)" />
					</td>
					<!-- /ko -->
					<th align="center" valign="middle" data-bind="text: $root.getPercent($element)" style="background:#92D050"></th>
				</tr>
				<tr>
					<td align="center">9</td>
					<td colspan="6">With regards to this training experience, state the following:</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="6">
						<div class="text-bold">a. The aspects  that impressed you most favorably</div>
						<textarea class="width100p" rows="5" style="background:#FEE6DE" data-bind="value: getAnswer('9a')"></textarea>
						<div class="text-bold">b. the aspects that impressed you least favorably</div>
						<textarea class="width100p" rows="5" style="background:#FEE6DE" data-bind="value: getAnswer('9b')"></textarea>
					</td>
				</tr>
				<tr>
					<th>10</th>
					<td colspan="6">
						<div class="text-bold">Do you have any additional comments or suggestions regarding the aspect of the training.</div>
						<textarea class="width100p" rows="5" style="background:#FEE6DE" data-bind="value: getAnswer('10')"></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabCourse.js')?>