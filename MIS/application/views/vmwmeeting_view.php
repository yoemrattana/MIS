<style>
	.space-between > :not(:first-child) { margin-left:5px; }
	#fixedtop { position:fixed; top:0; left:0; right:0; z-index:2; }
	body.modal-open #fixedtop { right:16px; }
</style>

<div id="fixedtop" class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix relative">
		<div class="pull-left form-inline space-between">
			<div class="input-group">
				<span class="input-group-addon">OD</span>
				<select data-bind="value: od,
						options: odList,
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: odList().length == 1 ? undefined : ''"
					class="form-control minwidth100"></select>
			</div>

			<div class="input-group">
				<span class="input-group-addon">HC</span>
				<select data-bind="value: hc,
						options: hcList(),
						optionsValue: 'code',
						optionsText: 'name',
						optionsCaption: ''"
					class="form-control minwidth100"></select>
			</div>

			<div class="input-group width120">
				<span class="input-group-addon">Year</span>
				<input type="text" class="form-control text-center" data-bind="datePicker: year, format: 'YYYY'" name="disableSuggestion" />
			</div>
		</div>
		<div class="pull-right">
			<button class="btn btn-primary width100" data-bind="click: save, visible: app.user.permiss['VMW Meeting'].contain('Edit')">Save</button>
			<button class="btn btn-success" data-bind="click: exportExcel">Export Excel</button>
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
</div>

<div class="panel panel-default" data-bind="visible: true, style: { marginTop: $('#fixedtop').outerHeight() + 'px' }" style="display:none">
	<div class="panel-body">
		<h3 class="kh text-center text-primary">ទម្រង់ព័ត៌មានការប្រជុំប្រចាំខែ និង ប្រចាំត្រីមាស របស់អ្នកស្ម័គ្រចិត្តភូមិ</h3>
		<br />

		<table class="table table-bordered table-hover">
			<thead class="bg-thead">
				<tr>
					<th width="30" align="center">#</th>
					<th align="center">Village</th>
					<th align="center">Khmer</th>
					<!-- ko foreach: Array(12) -->
					<th width="70" align="center" data-bind="text: ($index() + 1).toString().padStart(2,'0')"></th>
					<!-- /ko -->
					<th width="80" align="center">Has VMW</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td align="center" valign="middle" class="text-danger">Meeting Date</td>
					<td align="center" valign="middle" class="text-danger kh">ថ្ងៃប្រជុំ</td>
					<!-- ko foreach: Array(12) -->
					<td align="center" class="relative">
						<input type="text" data-bind="datePicker: $root.dateList()[$index()], format: 'DD-MM-YY', showClear: true" class="form-control input-sm text-center text-danger no-padding" placeholder="Date" />
					</td>
					<!-- /ko -->
					<td></td>
				</tr>
			</tbody>
			<tbody data-bind="foreach: listModel, fixedHeader: true, fixedTop: $('#fixedtop').outerHeight()">
				<tr>
					<td align="center" data-bind="text: $index() + 1"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: Name_Vill_K" class="kh"></td>
					<!-- ko foreach: months -->
					<td align="center" valign="middle" data-bind="if: active">
						<input type="checkbox" class="checkbox-lg" data-bind="checked: met" />
					</td>
					<!-- /ko -->
					<td data-bind="text: HaveVMW == 1 ? '✔' : ''" align="center" valign="middle"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/VMWMeeting.js')?>