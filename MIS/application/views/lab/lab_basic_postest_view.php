<style>
	table input { width: 100%; border:none; background: transparent; }
	table select { width: 100%; height: 22px; border:none; background: transparent; }
	thead th, tfoot th { text-align: center; vertical-align: middle !important; }
	tbody td { vertical-align: middle !important; }
	.black-border th, .black-border td { border: 1px solid !important; }
	th:has(input), td:has(input), td:has(select) { padding: 4px !important; }
	.correct { background: #FFC7CE; }
	.correct select, .correct input { color: #9C0006; }
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

	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
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
					<th width="70">Theory</th>
					<th width="70">Practical</th>
					<th width="70">Smear</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel, fixedHeader: true">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td align="center" data-bind="text: moment(DateFrom).displayformat()"></td>
					<td align="center" data-bind="text: moment(DateTo).displayformat()"></td>
					<td align="center" data-bind="text: Venue"></td>
					<td align="center">
						<a data-bind="click: $root.showTheory">Detail</a>
					</td>
					<td align="center">
						<a data-bind="click: $root.showPractical">Detail</a>
					</td>
					<td align="center">
						<a data-bind="click: () => $root.showSmear($data,'postest')">Detail</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="panel panel-default" data-bind="visible: view() == 'detail'" style="display:none">
	<div class="panel-heading clearfix">
		<div class="lh26" style="float:left; position:sticky; left:21px">
			<b data-bind="text: mode"></b>
		</div>
		<div class="pull-right" style="position:sticky; right:11px">
			<button class="btn btn-sm btn-primary width80" data-bind="click: save">Save</button>
			<button class="btn btn-sm btn-default width80" data-bind="click: back">Back</button>
		</div>
	</div>

	<div class="panel-body">
		<!-- ko if: mode() == 'Theory' -->
		<?php $this->view('lab/lab_theory_table'); ?>
		<!-- /ko -->

		<!-- ko if: mode() == 'Practical' -->
		<?php $this->view('lab/lab_assessment_table'); ?>
		<!-- /ko -->

		<!-- ko if: mode() == 'Smear' -->
		<?php $this->view('lab/lab_smear_table'); ?>
		<!-- /ko -->
	</div>
</div>

<?=latestJs('/media/ViewModel/Lab.js')?>
<?=latestJs('/media/ViewModel/LabPretest.js')?>
<?=latestJs('/media/ViewModel/LabAssessmentFunction.js')?>