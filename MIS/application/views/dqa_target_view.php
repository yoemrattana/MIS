<div class="panel panel-default">
    <div class="panel-heading clearfix">
		<div class="pull-left">
			<button name="HC" class="btn btn-default width100" data-bind="click: $root.viewTarget">HC</button>
			<button name="VMW" class="btn btn-default width100" data-bind="click: $root.viewTarget">VMW</button>
		</div>
	</div>
    <div class="panel-body divcenter" >
	    <h3 class="text-center text-primary" data-bind="text: 'Target ' + $root.submenu() != null ? $root.submenu() : ''"></h3>
        <h4 class="text-center text-primary">Case from 2019 to 2023</h4>
	    <br />
        <table id="tbldetail" class="table table-bordered" style="display: none" data-bind="visible: $root.submenu() == 'HC'">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Province</th>
                    <th>OD</th>
                    <th>HC</th>
                    <th>Positive</th>
                    <th>Done</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listHcTarget">
                <tr>
                    <td data-bind="text: $index() + 1"></td>
                    <td data-bind="text: Name_Prov_E"></td>
                    <td data-bind="text: Name_OD_E"></td>
                    <td data-bind="text: Name_Facility_E"></td>
                    <td data-bind="text: Positive"></td>
                    <td data-bind="text: Done == 1 ? '✓': ''"></td>
                </tr>
            </tbody>
        </table>

        <table id="tbldetail" class="table table-bordered" style="display: none" data-bind="visible: $root.submenu() == 'VMW'">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Province</th>
                    <th>OD</th>
                    <th>HC</th>
                    <th>VMW</th>
                    <th>Positive</th>
                    <th>Done</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: listVmwTarget">
                <tr>
                    <td data-bind="text: $index() + 1"></td>
                    <td data-bind="text: Name_Prov_E"></td>
                    <td data-bind="text: Name_OD_E"></td>
                    <td data-bind="text: Name_Facility_E"></td>
                    <td data-bind="text: Name_Vill_E"></td>
                    <td data-bind="text: Positive"></td>
                    <td data-bind="text: Done == 1 ? '✓': ''"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>