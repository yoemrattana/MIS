<style>
	.btnmenu { min-width:100px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left">
			<a href="/QMalaria/index/labo" class="btn btn-default btnmenu">Laboratory</a>
			<a href="/QMalaria/index/clinic" class="btn btn-default btnmenu">Clinical</a>
			<a href="/QMalaria/index/testing" class="btn btn-default btnmenu">CRP Testing</a>
			<a href="/QMalaria/index/sample" class="btn btn-default btnmenu">Sample Reception</a>
			<a href="/QMalaria/index/baselinedata" class="btn btn-default btnmenu">Baseline Data</a>
			<a href="/QMalaria/index/followup" class="btn btn-default btnmenu">Follow Up</a>
			<a href="/QMalaria/report1" class="btn btn-default btnmenu">Report Phase 1</a>
			<a href="/QMalaria/report2" class="btn btn-default btnmenu">Report Phase 2</a>
			<button class="btn btn-success" data-bind="click: exportAll">Export Labo &amp; Clincal</button>
		</div>
		<div class="pull-right">
			<a href="/Home">
				<img src="/media/images/home_back.png" />
			</a>
		</div>
	</div>
	<div class="panel-heading clearfix">
		<div class="form-inline">
			<span class="text-bold">Province:</span>
			<span>Kampong Speu</span>

			<span class="text-bold" style="margin-left:15px">OD:</span>
			<span>Kampong Speu</span>
		</div>
	</div>
	<div class="panel-body" data-bind="visible: loaded">
		<h2 class="text-center text-primary no-margin-top">Baseline Data</h2>

		<table class="table table-bordered table-striped widthauto">
			<thead>
				<tr>
					<th width="40" align="center">#</th>
					<th class="minwidth150">HC Name</th>
					<th width="110" align="center"># of Patients</th>
					<th width="110" align="center">% of RDT</th>
					<th width="110" align="center">% of Antibiotic</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel">
				<tr>
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: Name_Facility_E"></td>
					<td data-bind="text: Patient" align="center"></td>
					<td data-bind="text: (RDT * 100 / Patient).toFixed(0) + '%'" align="center"></td>
					<td data-bind="text: (Antibiotic * 100 / Patient).toFixed(0) + '%'" align="center"></td>
				</tr>
			</tbody>
			<tfoot>
				<tr data-bind="with: listModel().sum(r => r.Patient)">
					<th align="center" colspan="2">Total</th>
					<th align="center" data-bind="text: $data"></th>
					<th align="center" data-bind="text: ($root.listModel().sum(r => r.RDT) * 100 / $data).toFixed(0) + '%'"></th>
					<th align="center" data-bind="text: ($root.listModel().sum(r => r.Antibiotic) * 100 / $data).toFixed(0) + '%'"></th>
				</tr>
			</tfoot>
			<tfoot data-bind="visible: listModel().length == 0">
				<tr>
					<td align="center" class="text-warning h4" style="padding:10px" colspan="5">No Data</td>
				</tr>
			</tfoot>
		</table>
		<br />

		<div id="chart1" style="border: 1px solid #ccc; width:1200px; height:700px"></div>
		<br />
		<div id="chart2" style="border: 1px solid #ccc; width:1200px"></div>
	</div>
</div>

<?=latestJs('/media/ViewModel/QMReport1.js')?>