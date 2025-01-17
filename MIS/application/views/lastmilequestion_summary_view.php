<div class="panel panel-default">
    <div class="panel-heading clearfix">
		<div class="pull-left">
			<button name="VMW" class="btn btn-default width100" data-bind="click: $root.viewSummary">VMW</button>
            <button name="Vill" class="btn btn-default " data-bind="click: $root.viewSummary">Village Leader</button>
            <button name="Pop" class="btn btn-default " data-bind="click: $root.viewSummary">Target Population</button>
		</div>
	</div>

     <div class="panel-body divcenter" >
	    <!--<h3 class="text-center text-primary" data-bind="text: 'Target ' + $root.submenu() != null ? $root.submenu() : ''"></h3>-->
	    <br />
         
        <!--ko if: $root.submenu().in('VMW', 'Vill', 'Pop')-->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Province</th>
                    <th>OD</th>
                    <th>HC</th>
                    <th>Village</th>
                    <th>Instead Village</th>
                    <th>Done</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: vmwSummary">
                <tr>
                    <td data-bind="text: $index() + 1"></td>
                    <td data-bind="text: Name_Prov_E"></td>
                    <td data-bind="text: Name_OD_E"></td>
                    <td data-bind="text: Name_Facility_E"></td>
                    <td data-bind="text: Name_Vill_E"></td>
                    <td data-bind="text: $root.getVill(InsteadVill)"></td>
                    <td data-bind="text: HasData == 1 ? '✓': ''"></td>
                </tr>
            </tbody>
            <tfoot data-bind="visible: app.tableFooter($element)">
				<tr>
					<td class="text-center text-warning h4" style="padding:10px">No Data</td>
				</tr>
			</tfoot>
        </table>
         <!--/ko-->
        
    </div>

</div>
