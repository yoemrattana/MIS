<style>
	.table th { background: #9AD8ED; text-align: center; }
	.table td { white-space: nowrap; }
	body { overflow-y: scroll; }
	.checkbox-lg label { font-weight:normal; }
	.lastmile-error { border:1px solid red; padding:0 5px; }
</style>

<div id="sysmenuboard" class="panel panel-default" style="display:none" data-bind="visible: true">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" data-bind="style: { position: app.isMobile ? '' : 'sticky', left: app.isMobile ? '' : '26px' }">
			<strong>System Table</strong>
			<?php echo form_dropdown('systable',$systablelist,$systable,'class="form-control input-sm" id="systable"');?>

			<strong style="margin-left:10px">Province</strong>
			<?php echo form_dropdown('code_prov',$provlist,$code_prov,'class="form-control input-sm" id="code_prov"'); ?>

			<span data-bind="visible: odList().length > 1" style="display:none">
				<strong style="margin-left:10px">OD</strong>
				<select class="form-control input-sm" data-bind="value: odFilter, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All OD'"></select>
			</span>

			<span data-bind="visible: hcList().length > 1" style="display:none">
				<strong style="margin-left:10px">HC</strong>
				<select class="form-control input-sm" data-bind="value: hcFilter, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All HC'"></select>
			</span>
		</div>
		<div class="pull-right" data-bind="style: { position: app.isMobile ? '' : 'sticky', right: app.isMobile ? '' : '26px' }">
			<button class="btn btn-primary btn-sm width100" data-bind="click: showAdd, visible: app.user.permiss['System Menu'].contain('Village - Edit')">Add Village</button>
			<button class="btn btn-primary btn-sm" data-bind="click: showAddAnnex, visible: app.user.permiss['System Menu'].contain('Village - Edit')">Add Annex Village</button>
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th class="clickable" onclick="app.vm.sortTable('Code_Dist_T', 'getDistName')">District</th>
					<th class="clickable" onclick="app.vm.sortTable('Code_Comm_T', 'getCommName')">Commune</th>
					<th class="clickable" onclick="app.vm.sortTable('Name_Vill_E')">Village EN</th>
					<th class="clickable" onclick="app.vm.sortTable('Name_Vill_K')">Village KH</th>
					<th class="clickable" onclick="app.vm.sortTable('Code_Vill_T')">Village Code</th>
					<th>Annex</th>
					<th>Has VMW</th>
					<th>VMW Type</th>
					<th>Unreg</th>
					<th class="clickable" onclick="app.vm.sortTable('Code_OD_T', 'getOdName')">OD</th>
					<th class="clickable" onclick="app.vm.sortTable('HCCode', 'getHcName')">HC</th>
					<th>Meeting HC</th>
					<th class="clickable" onclick="app.vm.sortTable('MeetingMonth')">Meeting Month</th>
					<th>HC Distance</th>
					<th>Border</th>
					<th>Border Distance</th>
					<th>Lat</th>
					<th>Long</th>
					<th style="min-width:100px">Lat Long<br />Updated On</th>
					<th class="clickable" onclick="app.vm.sortTable('IsLastmile')">Lastmile</th>
					<th class="text-nowrap">Lastmile<br />Start Date</th>
					<th class="text-nowrap">Lastmile<br />Activity</th>
					<th style="min-width:40px" data-bind="visible: app.user.permiss['System Menu'].contain('Village - Edit')">Edit</th>
					<th style="min-width:70px" data-bind="visible: isAdmin">Move Data</th>
					<th style="min-width:40px" data-bind="visible: app.user.permiss['System Menu'].contain('Village - Delete')">Delete</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: getListModel, fixedHeader: true">
				<tr data-bind="click: app.selectTr, attr: { id: Code_Vill_T }">
					<td data-bind="text: $index() + 1" align="center"></td>
					<td data-bind="text: $parent.getDistName(Code_Dist_T)" class="text-nowrap"></td>
					<td data-bind="text: $parent.getCommName(Code_Comm_T)"></td>
					<td data-bind="text: Name_Vill_E"></td>
					<td data-bind="text: Name_Vill_K" class="kh"></td>
					<td data-bind="text: Code_Vill_T.substr(0, 8)"></td>
					<td data-bind="text: Code_Vill_T.substr(-2)"></td>
					<td data-bind="text: HaveVMW == '1' ? 'Yes' : 'No'" align="center"></td>
					<td data-bind="text: VMWType"></td>
					<td data-bind="text: Unregistered == '1' ? 'Yes' : 'No'" align="center"></td>
					<td data-bind="text: $parent.getOdName(Code_OD_T)"></td>
					<td data-bind="text: $parent.getHcName(HCCode)"></td>
					<td data-bind="text: $parent.getHcName(HCCode_Meeting)"></td>
					<td data-bind="text: MeetingMonth == 1 ? 'Monthly' : MeetingMonth == 3 ? 'Quarterly' : ''"></td>
					<td data-bind="text: DistanceFromHC == null ? '' : parseFloat(DistanceFromHC.toFixed(1)) + ' km'" align="right"></td>
					<td data-bind="text: $parent.getBorder(BorderCountry)"></td>
					<td data-bind="text: $parent.getBorderDistance(BorderDistance)"></td>
					<td data-bind="text: Lat"></td>
					<td data-bind="text: long"></td>
					<td data-bind="text: (LatLongUpdateDate || '').substr(0, 10)" align="center"></td>
					<td data-bind="text: IsLastmile == 1 ? 'Yes' : ''" align="center"></td>
					<td data-bind="text: LastmileStartDate" align="center"></td>
					<td data-bind="text: $root.getLastmileActivity($data)" align="center"></td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Village - Edit')">
						<a data-bind="click: $parent.showEdit">Edit</a>
					</td>
					<td align="center" data-bind="visible: $parent.isAdmin">
						<a data-bind="click: $parent.showMove">Move Data</a>
					</td>
					<td align="center" data-bind="visible: app.user.permiss['System Menu'].contain('Village - Delete')">
						<a class="text-danger" data-bind="click: $parent.delete">Delete</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal Add -->
<div id="modalAdd" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Add Village</h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: addModel">
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">District:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: district, options: distList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Commune:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: commune, options: commList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">OD:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Health Center:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Village Name English:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: english" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Village Name Khmer:</label>
					<div class="col-xs-8">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" data-bind="value: khmer" />
							<span class="input-group-addon">Unicode</span>
						</div>
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-4">Village Code:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: village" maxlength="8" style="width:80px" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: add" style="width:100px">Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Add Annex -->
<div id="modalAddAnnex" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Add Annex Village</h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: addAnnexModel">
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">District:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: district, options: distList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Commune:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: commune, options: commList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Village:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: village, options: villList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Village Name English:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: english" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Village Name Khmer:</label>
					<div class="col-xs-8">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" data-bind="value: khmer" />
							<span class="input-group-addon">Unicode</span>
						</div>
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-4">Annex Code:</label>
					<div class="col-xs-8">
						<p class="form-control-static">
							<strong data-bind="text: village() == null ? '00' : annex().substr(-2)"></strong>
						</p>
					</div>
				</div>
				<div class="form-group form-group-sm no-margin-bottom">
					<label class="control-label col-xs-4">Full Code:</label>
					<div class="col-xs-8">
						<p class="form-control-static text-primary">
							<strong data-bind="text: village() == null ? '0000000000' : annex()"></strong>
						</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: addAnnex" style="width:100px">Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Edit Village</h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: editModel">
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">District:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Code_Dist_T, options: distList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Commune:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Code_Comm_T, options: commList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Village Name English:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Name_Vill_E" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Village Name Khmer:</label>
					<div class="col-xs-8">
						<div class="input-group input-group-sm">
							<input type="text" class="form-control" data-bind="value: Name_Vill_K" />
							<span class="input-group-addon">Unicode</span>
						</div>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Has VMW:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: HaveVMW, options: [{code:1,name:'Yes'},{code:0,name:'No'}], optionsValue: 'code', optionsText: 'name', enable: $parent.isAdmin"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">VMW Type:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: VMWType, options: ['VMW','MMW', 'MMP'], optionsCaption: '-- Choose --', enable: $parent.isAdmin"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Unregistered:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: Unregistered, options: [{code:1,name:'Yes'},{code:0,name:'No'}], optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">OD:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Health Center:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: HCCode, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Meeting HC:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: HCCode_Meeting, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Meeting Month:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: MeetingMonth">
							<option></option>
							<option value="1">Monthly</option>
							<option value="3">Quarterly</option>
						</select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Distance From HC:</label>
					<div class="col-xs-8">
						<div class="input-group input-group-sm" style="width:100px">
							<input type="text" class="form-control" data-bind="value: DistanceFromHC" />
							<span class="input-group-addon">km</span>
						</div>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Border:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: BorderCountry, options: countryList, optionsCaption: 'No Border'"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Distance From Border:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: BorderDistance, options: BorderCountry() == null ? [] : distanceList, optionsValue: 'code', optionsText: 'name', disable: BorderCountry() == null"></select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Lat:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: Lat" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Long:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="value: long" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Lastmile:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: IsLastmile">
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Lastmile Start Date:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" data-bind="datePicker: LastmileStartDate, dataType: 'string'" />
					</div>
				</div>
				<div class="form-group form-group-sm">
					<label class="control-label col-xs-4">Lastmile Activity:</label>
					<div class="col-xs-8">
						<div data-bind="css: { 'lastmile-error': $root.lastmileRequire }">
							<div class="checkbox-inline checkbox-lg">
								<label>
									<input type="checkbox" data-bind="checked: Census" />
									<span>Census</span>
								</label>
							</div>
							<div class="checkbox-inline checkbox-lg">
								<label>
									<input type="checkbox" data-bind="checked: TDA" />
									<span>TDA</span>
								</label>
							</div>
							<div class="checkbox-inline checkbox-lg">
								<label>
									<input type="checkbox" data-bind="checked: IPT" />
									<span>IPT</span>
								</label>
							</div>
							<div class="checkbox-inline checkbox-lg">
								<label>
									<input type="checkbox" data-bind="checked: AFS" />
									<span>AFS</span>
								</label>
							</div>
							<div class="text-danger" data-bind="visible: $root.lastmileRequire">Please tick some box.</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: edit" style="width:100px">Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Move -->
<div id="modalMove" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" role="document">
			<div class="modal-header">
				<h4 class="modal-title text-primary">Move Village Data</h4>
			</div>
			<div class="modal-body form-horizontal" data-bind="with: moveModel">
				<div class="form-group no-margin-bottom">
					<label class="control-label col-xs-4">From Province:</label>
					<div class="col-xs-8">
						<p class="form-control-static" data-bind="text: fromPV"></p>
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<label class="control-label col-xs-4">From OD:</label>
					<div class="col-xs-8">
						<p class="form-control-static" data-bind="text: fromOD"></p>
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<label class="control-label col-xs-4">From HC:</label>
					<div class="col-xs-8">
						<p class="form-control-static" data-bind="text: fromHC"></p>
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<label class="control-label col-xs-4">From Village:</label>
					<div class="col-xs-8">
						<p class="form-control-static" data-bind="text: fromVL"></p>
					</div>
				</div>
				<hr class="no-margin-top" />
				<div class="form-group">
					<label class="control-label col-xs-4">To Province:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name'"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">To OD:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: od, options: odList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">To HC:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: hc, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
				<div class="form-group no-margin-bottom">
					<label class="control-label col-xs-4">To Village:</label>
					<div class="col-xs-8">
						<select class="form-control" data-bind="value: vl, options: vlList, optionsValue: 'code', optionsText: 'name', optionsCaption: '-- Choose --'"></select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-bind="click: moveData" style="width:100px">Move</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Nav_Village.js')?>