<style>
	.panel { position: absolute; left: 10px; right: 10px; top: 10px; bottom: 40px; }
	.panel-body { height: calc(100% - 67px); padding: 5px; }
	#map { height: 100%; }
	body { overflow: auto; }
	.gm-style-iw button { display: none !important; }
	#modalDetail div.fixed-header { top: 47px; margin-left: 1px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<div class="inlineblock">
				<div class="text-bold">Province</div>
				<select class="form-control input-sm minwidth150" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">OD</div>
				<select class="form-control input-sm minwidth150" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
			</div>
			<div class="inlineblock">
				<div class="text-bold">From</div>
				<input type="text" class="form-control input-sm width100 text-center" data-bind="datePicker: monthFrom, format: 'MMM YYYY', minDate: '2020-01'" />
			</div>
			<div class="inlineblock">
				<div class="text-bold">To</div>
				<input type="text" class="form-control input-sm width100 text-center" data-bind="datePicker: monthTo, format: 'MMM YYYY', minDate: '2020-01'" />
			</div>
			<button class="btn btn-primary btn-sm width100" data-bind="click: viewClick">View</button>

			<div class="checkbox-inline checkbox-lg" style="margin-left:50px">
				<label>
					<input type="checkbox" data-bind="checked: displayPercent" />
					<span>Display Percentage</span>
				</label>
			</div>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<div id="map"></div>
	</div>
</div>

<div class="modal" id="modalDetail" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document" style="height:calc(100% - 60px); overflow:hidden">
		<div class="modal-content" style="height:100%">
			<div class="modal-header" style="height:47px">
				<h4 class="modal-title text-primary"></h4>
			</div>
			<div class="modal-body" style="height:calc(100% - 94px); overflow-y:auto">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th align="center" width="40">#</th>
							<th align="center">Village</th>
							<th align="center">Diagnosis</th>
							<th align="center">Primaquine</th>
							<th align="center">Day 3</th>
							<th align="center">Day 7</th>
							<th align="center">Day 14</th>
							<th align="center" width="100">Have VMW</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: detailList, fixedHeader: true, scrollContainer: $($element).closest('.modal-body')">
						<tr>
							<td align="center" data-bind="text: $index() + 1"></td>
							<td data-bind="text: Name_Vill_E"></td>
							<td align="center" data-bind="text: DiagnosisDate"></td>
							<td align="center" data-bind="text: PrimaquineDate"></td>
							<td align="center" data-bind="text: Day3Date"></td>
							<td align="center" data-bind="text: Day7Date"></td>
							<td align="center" data-bind="text: Day14Date"></td>
							<td align="center" data-bind="text: HaveVMW == 1 ? '✔' : ''"></td>
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

<?=form_hidden('cso', json_encode($cso))?>
<?=form_hidden('hf', json_encode($hf))?>
<?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCVXxd9fjjh1c2wrsRlZfyHfEkBiI4XQ8Q"></script>
<script src="/media/JavaScript/maplabel.js"></script>
<?=latestJs('/media/ViewModel/PvRadicalCureMap.js')?>