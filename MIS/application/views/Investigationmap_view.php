<style>
	.panel { position: absolute; left: 10px; right: 10px; top: 10px; bottom: 40px; }
	.panel-body { height: calc(100% - 67px); padding: 5px; }
	#map { height: 100%; }
	body { overflow: auto; }
	.gm-style-iw button { display: none !important; }
	#modalList div.fixed-header { top: 47px; margin-left: 1px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<div class="inlineblock">
				<div class="text-bold">Province</div>
				<select class="form-control input-sm" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All Province'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">From</div>
				<input type="text" class="form-control input-sm width100 text-center" data-bind="datePicker: monthFrom, format: 'MMM YYYY', minDate: '2020-01'" />
			</div>
			<div class="inlineblock">
				<div class="text-bold">To</div>
				<input type="text" class="form-control input-sm width100 text-center" data-bind="datePicker: monthTo, format: 'MMM YYYY', minDate: '2020-01'" />
			</div>
			<div class="inlineblock">
				<div class="text-bold">Species</div>
				<select class="form-control input-sm" data-bind="value: species">
					<option value="all">All Species</option>
					<option value="FM">PF + Mix</option>
					<option value="F">PF</option>
					<option value="V">PV</option>
					<option value="M">Mix</option>
				</select>
			</div>
			<button class="btn btn-primary btn-sm width100" data-bind="click: viewClick">View</button>

			<label class="checkbox-inline checkbox-lg" style="margin-left:100px">
				<input type="checkbox" data-bind="checked: measure">
				<span>Measure Distance</span>
			</label>
			<label class="checkbox-inline checkbox-lg" style="margin-left:20px">
				<input type="checkbox" data-bind="checked: displayLabel">
				<span>Display All Labels</span>
			</label>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<div id="map"></div>
	</div>
</div>

<div class="modal" id="modalList" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="height:calc(100% - 60px); overflow:hidden" data-bind="css: { 'modal-lg': bigModal }">
		<div class="modal-content" style="height:100%">
			<div class="modal-header" style="height:47px">
				<h4 class="modal-title text-primary"></h4>
			</div>
			<div class="modal-body" style="height:calc(100% - 94px); overflow-y:auto">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th align="center">#</th>
							<th align="center" data-bind="visible: bigModal">Village</th>
							<th align="center">Species</th>
							<th align="center">Age</th>
							<th align="center">Date</th>
							<th align="center">Relapse</th>
							<th align="center">L1</th>
							<th align="center">LC</th>
							<th align="center">IMP</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: listModel, fixedHeader: true, scrollContainer: $($element).closest('.modal-body')">
						<tr data-bind="style: { color: Diagnosis == 'V' ? '' : 'red' }">
							<td align="center" data-bind="text: $index() + 1"></td>
							<td data-bind="text: Name_Vill_E, visible: $root.bigModal"></td>
							<td align="center" data-bind="text: Diagnosis == 'F' ? 'Pf' : Diagnosis == 'V' ? 'Pv' : 'Mix'"></td>
							<td align="center" data-bind="text: Age"></td>
							<td align="center" data-bind="text: moment(DateCase).format('DD MMM YYYY')"></td>
							<td align="center" data-bind="text: Relapse == 1 ? '✔' : ''"></td>
							<td align="center" data-bind="text: L1 == 1 ? '✔' : ''"></td>
							<td align="center" data-bind="text: LC == 1 ? '✔' : ''"></td>
							<td align="center" data-bind="text: IMP == 1 ? '✔' : ''"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default btn-sm width100" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCVXxd9fjjh1c2wrsRlZfyHfEkBiI4XQ8Q"></script>
<script src="/media/JavaScript/maplabel.js"></script>
<?=latestJs('/media/ViewModel/InvestigationMap.js')?>