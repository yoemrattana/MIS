<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<div class="panel panel-default">
    <div class="panel-body divcenter" >
	    <h3 class="text-center text-primary">Summary</h3>
        <h4 class="text-center text-primary">Case from 2019 to 2023</h4>
	    <br />
        <button class="btn btn-success pull-right"  data-bind="click: $root.exportSummary">Export</button>
        <br />
        <br />
        <table id="tbldetail" class="table table-bordered tableSummary">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Province</th>
                    <th>OD</th>
                    <th>Health Facility</th>
                    <th>Confirmed Cases</th>
                    <th>Number of cases with 100% of core variables  completed</th>
                    <th>Number of cases in the register where all variables match the data from the national database</th>
                </tr>
            </thead>
            <tbody data-bind="foreach: summary">
                <tr>
                    <td data-bind="text: Year"></td>
                    <td data-bind="text: Month"></td>
                    <td data-bind="text: Name_Prov_E"></td>
                    <td data-bind="text: Name_OD_E"></td>
                    <td data-bind="text: Name_Facility_E"></td>
                    <td data-bind="text: Positive"></td>
                    <td data-bind="text: MatchData"></td>
                    <td data-bind="text: Complete"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>