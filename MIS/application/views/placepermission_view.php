<style>
	thead { background-color: #9AD8ED; }
	thead th { text-align: center; }
	tbody td { white-space: nowrap; }
	.hasCheckbox { padding: 4px 0 0 0 !important; text-align: center; }
	.hasCheckbox input { width: 20px; height: 20px; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left lh28 form-inline">
			<span><b>Province</b></span>
			<select data-bind="value: prov,
					options: provList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All Province'" class="form-control input-sm minwidth150"></select>
            <!-- ko if: tab() != 'Permission'-->
            <span style="margin-left:15px"><b>OD</b></span>
            <select data-bind="value: od,
					options: odList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All OD'" class="form-control input-sm width150"></select>

            <span style="margin-left:15px"><b>HC</b></span>
            <select data-bind="value: hc,
					options: hcList,
					optionsValue: 'code',
					optionsText: 'name',
					optionsCaption: 'All HC'" class="form-control input-sm width150"></select>
            <!-- /ko -->

		</div>
		<div class="pull-right">
			<a href="/Home"><img src="/media/images/home_back.png" /></a>
		</div>
	</div>
    <div class="panel-heading">
        <div class="clearfix hidden-print">
            <div class="pull-left" style="width: calc(100% - 120px)">
                <button class="btn minwidth100" data-bind="click: () => tab('Permission'), css: tab() == 'Permission' ? 'btn-primary' : 'btn-default'">Permission</button>
                <button class="btn minwidth100" data-bind="click: () => tab('RadicalCure'), css: tab() == 'RadicalCure' ? 'btn-primary' : 'btn-default'">Radical Cure</button>
                <button class="btn minwidth100" data-bind="click: () => tab('FingerPrint'), css: tab() == 'FingerPrint' ? 'btn-primary' : 'btn-default'">Finger Print</button>
                <button class="btn minwidth100" data-bind="click: () => tab('RdtPhoto'), css: tab() == 'RdtPhoto' ? 'btn-primary' : 'btn-default'">RDT Photo</button>
                <button class="btn minwidth100" data-bind="click: () => tab('Device'), css: tab() == 'Device' ? 'btn-primary' : 'btn-default'">Device</button>
				<!--<button class="btn minwidth100" data-bind="click: () => tab('Lastmile'), css: tab() == 'Lastmile' ? 'btn-primary' : 'btn-default'">Lastmile</button>-->
            </div>
        </div>
    </div>

	<div class="panel-body">

        <div data-bind="visible: tab() == 'Permission'">
            <table class="table table-bordered table-striped table-hover text-nowrap widthauto">
                <thead>
                    <tr>
                        <th>Province English</th>
                        <th>Province Khmer</th>
                        <th>OD English</th>
                        <th>OD Khmer</th>
                        <th>VMW Report</th>
                        <th>Investigation Report</th>
                        <th>Reactive Report</th>
                        <th>SMS Alert</th>
                        <th>Elimination</th>
                        <th>URCStock</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: listModel, fixedHeader: true">
                    <tr>
                        <td data-bind="text: provE"></td>
                        <td data-bind="text: provK" class="kh"></td>
                        <td data-bind="text: Name_OD_E"></td>
                        <td data-bind="text: Name_OD_K" class="kh"></td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: Is_Enable_VMW_Report, click: $root.changeVMW" />
                        </td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: Is_Enable_Investigation_Report, click: $root.changeInvestigate" />
                        </td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: Is_Enable_Reactive_Report, click: $root.changeReactive" />
                        </td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: Is_Enable_SMS_Alert, click: $root.changeSMS" />
                        </td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: Is_Elimination, click: $root.changeElimination" />
                        </td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: Is_URC_Stock, click: $root.changeURCStock" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div data-bind="visible: tab() == 'RadicalCure'">
            <table class="table table-bordered table-striped table-hover text-nowrap widthauto">
                <thead>
                    <tr>
                        <th>Province</th>
                        <th>OD</th>
                        <th>HC</th>
                        <th>Reminder</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: hcListModel, fixedHeader: true">
                    <tr>
                        <td data-bind="text: Name_Prov_E"></td>
                        <td data-bind="text: Name_OD_E"></td>
                        <td data-bind="text: Name_Facility_E"></td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: IsReminder, click: $root.changeReminder" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div data-bind="visible: tab() == 'FingerPrint'">
            <table class="table table-bordered table-striped table-hover text-nowrap widthauto">
                <thead>
                    <tr>
                        <th>Province</th>
                        <th>OD</th>
                        <th>HC</th>
                        <th>Finger Print</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: hcListModel, fixedHeader: true">
                    <tr>
                        <td data-bind="text: Name_Prov_E"></td>
                        <td data-bind="text: Name_OD_E"></td>
                        <td data-bind="text: Name_Facility_E"></td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: IsFinger, click: $root.changeFinger" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div data-bind="visible: tab() == 'RdtPhoto'">
            <table class="table table-bordered table-striped table-hover text-nowrap widthauto">
                <thead>
                    <tr>
                        <th>Province</th>
                        <th>OD</th>
                        <th>HC</th>
                        <th>RDT Photo</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: hcListModel, fixedHeader: true">
                    <tr>
                        <td data-bind="text: Name_Prov_E"></td>
                        <td data-bind="text: Name_OD_E"></td>
                        <td data-bind="text: Name_Facility_E"></td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: IsRdtPhoto, click: $root.changeRdt" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div data-bind="visible: tab() == 'Device'">
            <table class="table table-bordered table-striped table-hover widthauto">
                <thead>
                    <tr>
                        <th width="150">Permission</th>
                        <th width="80">Allow</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: permissModel">
                    <tr>
                        <td data-bind="text: Permiss"></td>
                        <td class="hasCheckbox">
                            <input type="checkbox" data-bind="checked: Val, click: $root.changePermiss" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

		<div data-bind="visible: tab() == 'Lastmile'">
			<table class="table table-bordered table-striped table-hover text-nowrap widthauto">
				<thead>
					<tr>
						<th width="40">#</th>
						<th>Village Name Khmer</th>
						<th>Village Name English</th>
						<th>Lastmile</th>
					</tr>
				</thead>
				<tbody data-bind="foreach: vlListModel, fixedHeader: true">
					<tr data-bind="visible: $root.hc() != undefined">
						<td data-bind="text: $index() + 1" align="center"></td>
						<td data-bind="text: Name_Vill_K" class="kh"></td>
						<td data-bind="text: Name_Vill_E"></td>
						<td class="hasCheckbox">
							<input type="checkbox" data-bind="checked: IsLastmile, click: $root.changeLastmile" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
</div>
<?=form_hidden('listModel', json_encode($listModel))?>
<?=latestJs('/media/ViewModel/PlacePermission.js')?>