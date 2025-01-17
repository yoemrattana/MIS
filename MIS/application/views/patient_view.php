<style>
	table.child { position:sticky; left:60px; }
	table { cursor:default; }
	.underline:not(:empty):hover { text-decoration: underline; cursor: pointer; }
    .reviewed {background: #dff9fb}
    .pending {background:#f9ca24}
    .duplicate {background:tomato}
    .modal-size {
        min-width: 1200px;
        margin: auto;
    }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
    <div class="panel-heading clearfix">
        <div class="pull-left form-inline" style="position:sticky; left:21px">
            <div class="inlineblock">
                <div class="text-bold">Province</div>
                <select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
            </div>
            <div class="inlineblock">
                <div class="text-bold">OD</div>
                <select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
            </div>
            <div class="inlineblock">
                <div class="text-bold">HC</div>
                <select class="form-control minwidth100" data-bind="value: hc, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'"></select>
            </div>

            <div class="inlineblock">
                <div class="text-bold">Year</div>
                <div class="form-group">
                    <select data-bind="value: $root.year, options: $root.yearList, optionsCaption: 'All'" class="form-control"></select>
                </div>
            </div>
            <div class="inlineblock">
                <div class="text-bold">Month</div>
                <div class="form-group">
                    <select data-bind="value: $root.month, options: $root.monthList, optionsCaption: 'All'" class="form-control"></select>
                </div>
            </div>

        </div>
		<div class="pull-right" style="position:sticky; right:21px">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>

    </div>
    <div class="panel-heading clearfix">
        <div class="pull-left form-inline" style="position:sticky; left:21px">
            <button data-bind="click: menuClick, css: menuCss($element)" class="btn btn-default" style="width:89px">List</button>
            <button data-bind="click: menuClick, css: menuCss($element)" class="btn btn-default">Duplicated Code</button>
        </div>
    </div>

    <div  class="panel-body" >
        <table style="display: none" id="tblmain" class="table table-bordered table-hover text-nowrap" data-bind="visible: menu() == 'List'">
            <thead class="bg-thead">
                <tr>
                    <th align="center" width="40">#</th>
                    <th># Sick</th>
                    <th align="center" sortable>Patient Code</th>
                    <th align="center" sortable>Patient Name</th>
                    <th align="center" sortable>Status</th>
                    <th align="center" sortable>Age</th>
                    <th align="center" sortable>Sex</th>
                    <th align="center" sortable>Phone</th>
                    <th align="center">Date Case</th>
                    <th align="center">Year</th>
                    <th align="center">Month</th>
                    <th align="center" sortable>Province</th>
                    <th align="center" sortable>OD</th>
                    <th align="center" sortable>HC</th>
                    <th align="center" sortable>Village</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: getListModel, fixedHeader: true, sortModel: listModel">
                <tr data-bind="css: Status() == 'Reviewed' ? 'reviewed' : Status() == 'Pending' ? 'pending' : '' ,click: $root.viewCase">
                    <td align="center" data-bind="text: $index() +1"></td>
                    <td data-bind="text: n"></td>
                    <td data-bind="text: PatientCode"></td>
                    <td class="kh" data-bind="text: NameK"></td>
                    <td class="kh" data-bind="text: Status"></td>
                    <td data-bind="text: Age"></td>
                    <td data-bind="text: Sex"></td>
                    <td data-bind="text: PatientPhone"></td>
                    <td data-bind="text: DateCase"></td>
                    <td data-bind="text: Year"></td>
                    <td data-bind="text: Month"></td>
                    <td class="kh" data-bind="text: $root.getProvName(Code_Prov_T)"></td>
                    <td class="kh" data-bind="text: $root.getODName(Code_OD_T)"></td>
                    <td class="kh" data-bind="text: $root.getHCName(Code_Facility_T)"></td>
                    <td class="kh" data-bind="text: $root.getVLName(Code_Vill_t)"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <table style="display: none; width:300px" class="table table-bordered table-hover" data-bind="visible: menu() == 'Duplicated Code'">
        <thead class="bg-thead">
                <tr>
                    <th align="center" width="40">#</th>
                    <th align="center" sortable>Patient Code</th>
                    <th align="center" sortable>Patient Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listDuplicatedPatientCode, fixedHeader: true, sortModel: listDuplicatedPatientCode">
                <tr data-bind="click: $root.viewDuplicatedPatientCode">
                    <td align="center" data-bind="text: $index() + 1"></td>
                    <td data-bind="text: PatientCode"></td>
                    <td class="kh" data-bind="text: NameK"></td>
                    <td data-bind="text: Code"></td>
                    <td class="kh" data-bind="text: Name"></td>
                </tr>
            </tbody>
    </table>
</div>

<!--modal for patient list-->
<div class="modal" id="modalPatient" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-size" role="document">
        <div class="modal-content ">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Patients</h4>
            </div>
            <div class="modal-body " >
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th align="center" width="40">#</th>
                            <th align="center">Action</th>
                            <th align="center">Patient Code</th>
                            <th align="center">Patient Name</th>
                            <th align="center">Status</th>
                            <th align="center">Age</th>
                            <th align="center">Sex</th>
                            <th align="center">Phone</th>
                            <th align="center">Province</th>
                            <th align="center">OD</th>
                            <th align="center">HC</th>
                            <th align="center">Village</th>
                            <th align="center">Date case</th>
                            <th align="center" style="color:tomato">Score</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: listSearch">
                        <tr data-bind="style: {background: $index() == 0 ? 'red': ''}">
                            <td align="center" data-bind="text: $index() +1"></td>
                            <td>
                                <a class="btn btn-sm btn-success" data-bind="click: $root.updateCode">Update</a>
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: PatientCode" style="width: 80px"/>
                            </td>
                            <td class="kh">
                                <input type="text" class="form-control" data-bind="value: NameK" style="width:140px"/>
                            </td>
                            <td>
                                <select class="form-control" data-bind="value: Status">
                                    <option value=""></option>
							        <option value="Pending">Pending</option>
							        <option value="Reviewed">Reviewed</option>
						        </select>
                            </td>
                            <td data-bind="text: Age"></td>
                            <td data-bind="text: Sex"></td>
                            <td data-bind="text: PatientPhone"></td>
                            <td class="kh" data-bind="text: $root.getProvName(Code_Prov_T)"></td>
                            <td class="kh" data-bind="text: $root.getODName(Code_OD_T)"></td>
                            <td class="kh" data-bind="text: $root.getHCName(Code_Facility_T)"></td>
                            <td class="kh" data-bind="text: $root.getVLName(Code_Vill_t)"></td>
                            <td data-bind="text: DateCase"></td>
                            <td style="color:tomato; font-weight:bold" data-bind="text: score.toFixed(2)"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default width100" data-bind="click: $root.closeModal" style="float: left">Close</button>
            </div>
        </div>
	</div>
</div>

<!-- modal duplicate-->

<div class="modal" id="modalDuplicatedPatient" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-size" role="document">
        <div class="modal-content ">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Patients</h4>
            </div>
            <div class="modal-body " >
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th align="center" width="40">#</th>
                            <th align="center">Action</th>
                            <th align="center">Patient Code</th>
                            <th align="center">Patient Name</th>
                            <th class="text-danger" align="center">Patient Code 2</th>
                            <th class="text-danger" align="center">Patient Name 2</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: listSelectedDuplicatedPatient">
                        <tr >
                            <td align="center" data-bind="text: $index() +1"></td>
                            <td>
                                <a class="btn btn-sm btn-success" data-bind="click: $root.updateCode">Update</a>
                            </td>
                            <td>
                                <input type="text" class="form-control" data-bind="value: PatientCode" style="width: 80px"/>
                            </td>
                            <td class="kh">
                                <input type="text" class="form-control" data-bind="value: NameK" style="width:140px"/>
                            </td>
                             <td>
                                <input disabled type="text" class="form-control" data-bind="value: Code" style="width: 80px"/>
                            </td>
                            <td class="kh">
                                <input disabled type="text" class="form-control" data-bind="value: Name" style="width:140px"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/minisearch@6.3.0/dist/umd/index.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"> </script>
<?=latestJs('/media/ViewModel/Patient.js')?>