<style>
	tbody input { width: 100%; }
	tbody select { width: 100%; height: 26px; }

	.table-wide { min-width: 100%; width: max-content; }
	.table-wide tbody td { height: 37px; }

	.orange { background-color: #FFC000; }
	.gray { background-color: #757171; color: white; }
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix">
		<div class="pull-left" style="position:sticky; left:21px">
			<button class="btn btn-default menu">OD Availability</button>
			<button class="btn btn-default menu">OD Accessibility</button>
			<button class="btn btn-default menu">OD Comp-Accuracy</button>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline" style="position:sticky; left:21px">
			<div class="input-group">
				<span class="input-group-addon">Province</span>
				<select class="form-control" data-bind="value: pv, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<div class="input-group">
				<span class="input-group-addon">OD</span>
				<select class="form-control minwidth100" data-bind="value: od, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</div>
			<button class="btn btn-primary width80" data-bind="click: viewClick">View</button>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<button class="btn btn-primary width100" data-bind="click: save, visible: visibleSave()">Save</button>
		</div>
	</div>

	<div class="panel-body" data-bind="visible: menu().contain('Availability') && loaded1()">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th align="center" rowspan="2" class="bg-thead">S.N</th>
					<th align="center" rowspan="2" class="bg-thead">Code</th>
					<th align="center" rowspan="2" class="bg-thead">Documentation Name</th>
					<th align="center" rowspan="2" class="bg-thead">Material</th>
					<th align="center" rowspan="2" class="bg-thead">Retention Years</th>
					<th align="center" width="80" rowspan="2" class="warning">Expected in 2020</th>
					<th align="center" class="warning">Baseline</th>
					<th align="center" class="warning">End-line</th>
					<th align="center" width="80" rowspan="2" class="info">Expected in 2021</th>
					<th align="center" class="info">Baseline</th>
					<th align="center" class="info">End-line</th>
					<th align="center" width="80" rowspan="2" class="danger">Expected in 2022</th>
					<th align="center" class="danger">Baseline</th>
					<th align="center" class="danger">End-line</th>
					<th align="center" width="80" rowspan="2" class="success">Expected in 2023</th>
					<th align="center" class="success">Baseline</th>
					<th align="center" class="success">End-line</th>
					<th align="center" width="80" rowspan="2" class="orange">Expected in 2024</th>
					<th align="center" class="orange">Baseline</th>
					<th align="center" class="orange">End-line</th>
					<th align="center" class="gray">Total Baseline</th>
					<th align="center" class="gray">Total End-line</th>
				</tr>
				<tr>
					<th align="center" width="80" class="warning">Actual in 2020</th>
					<th align="center" width="80" class="warning">Actual in 2020</th>
					<th align="center" width="80" class="info">Actual in 2021</th>
					<th align="center" width="80" class="info">Actual in 2021</th>
					<th align="center" width="80" class="danger">Actual in 2022</th>
					<th align="center" width="80" class="danger">Actual in 2022</th>
					<th align="center" width="80" class="success">Actual in 2023</th>
					<th align="center" width="80" class="success">Actual in 2023</th>
					<th align="center" width="80" class="orange">Actual in 2024</th>
					<th align="center" width="80" class="orange">Actual in 2024</th>
					<th align="center" width="110" class="gray">Availability Rate (%)</th>
					<th align="center" width="110" class="gray">Availability Rate (%)</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel1, fixedHeader: true">
				<tr>
					<td align="center" valign="middle" data-bind="text: SN"></td>
					<th align="center" valign="middle" data-bind="text: Code"></th>
					<td valign="middle" data-bind="text: Name"></td>
					<td align="center" valign="middle" data-bind="text: Material"></td>
					<td align="center" valign="middle" data-bind="text: Retention"></td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect20" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual20, disable: $root.getDisable1(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual20e, disable: $root.getDisable1(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect21" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual21, disable: $root.getDisable1(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual21e, disable: $root.getDisable1(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect22" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual22, disable: $root.getDisable1(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual22e, disable: $root.getDisable1(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect23" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual23, disable: $root.getDisable1(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual23e, disable: $root.getDisable1(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect24" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual24, disable: $root.getDisable1(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Actual24e, disable: $root.getDisable1(SN(),24)" />
					</td>
					<td align="center" valign="middle" data-bind="text: $root.getRate($data,'') + '%'"></td>
					<td align="center" valign="middle" data-bind="text: $root.getRate($data,'e') + '%'"></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: menu().contain('Accessibility') && loaded2()">
		<table class="table table-bordered table-hover table-striped table-wide">
			<thead>
				<tr>
					<th align="center" rowspan="2" class="bg-thead">S.N</th>
					<th align="center" rowspan="2" class="bg-thead">Code</th>
					<th align="center" rowspan="2" class="bg-thead" width="400">Documentation Name</th>
					<th align="center" rowspan="2" class="bg-thead">Material</th>
					<th align="center" rowspan="2" class="bg-thead">Retention Years</th>
					<th align="center" colspan="5" class="warning">Baseline 2020</th>
					<th align="center" colspan="5" class="warning">End-line 2020</th>
					<th align="center" colspan="5" class="success">Baseline 2021</th>
					<th align="center" colspan="5" class="success">End-line 2021</th>
					<th align="center" colspan="5" class="info">Baseline 2022</th>
					<th align="center" colspan="5" class="info">End-line 2022</th>
					<th align="center" colspan="5" class="danger">Baseline 2023</th>
					<th align="center" colspan="5" class="danger">End-line 2023</th>
					<th align="center" colspan="5" class="orange">Baseline 2024</th>
					<th align="center" colspan="5" class="orange">End-line 2024</th>
					<th align="center" colspan="5" class="gray">Total Baseline</th>
					<th align="center" colspan="5" class="gray">Total End-line</th>
				</tr>
				<tr>
					<th align="center" class="warning" width="100">No Accessed in 2020</th>
					<th align="center" class="warning" width="100">Hard-Copies in 2020</th>
					<th align="center" class="warning" width="100">Soft-Copies in 2020</th>
					<th align="center" class="warning" width="100">MIS in 2020</th>
					<th align="center" class="warning" width="100">CNM Website in 2020</th>

					<th align="center" class="warning" width="100">No Accessed in 2020</th>
					<th align="center" class="warning" width="100">Hard-Copies in 2020</th>
					<th align="center" class="warning" width="100">Soft-Copies in 2020</th>
					<th align="center" class="warning" width="100">MIS in 2020</th>
					<th align="center" class="warning" width="100">CNM Website in 2020</th>

					<th align="center" class="success" width="100">No Accessed in 2021</th>
					<th align="center" class="success" width="100">Hard-Copies in 2021</th>
					<th align="center" class="success" width="100">Soft-Copies in 2021</th>
					<th align="center" class="success" width="100">MIS in 2021</th>
					<th align="center" class="success" width="100">CNM Website in 2021</th>

					<th align="center" class="success" width="100">No Accessed in 2021</th>
					<th align="center" class="success" width="100">Hard-Copies in 2021</th>
					<th align="center" class="success" width="100">Soft-Copies in 2021</th>
					<th align="center" class="success" width="100">MIS in 2021</th>
					<th align="center" class="success" width="100">CNM Website in 2021</th>

					<th align="center" class="info" width="100">No Accessed in 2022</th>
					<th align="center" class="info" width="100">Hard-Copies in 2022</th>
					<th align="center" class="info" width="100">Soft-Copies in 2022</th>
					<th align="center" class="info" width="100">MIS in 2022</th>
					<th align="center" class="info" width="100">CNM Website in 2022</th>

					<th align="center" class="info" width="100">No Accessed in 2022</th>
					<th align="center" class="info" width="100">Hard-Copies in 2022</th>
					<th align="center" class="info" width="100">Soft-Copies in 2022</th>
					<th align="center" class="info" width="100">MIS in 2022</th>
					<th align="center" class="info" width="100">CNM Website in 2022</th>

					<th align="center" class="danger" width="100">No Accessed in 2023</th>
					<th align="center" class="danger" width="100">Hard-Copies in 2023</th>
					<th align="center" class="danger" width="100">Soft-Copies in 2023</th>
					<th align="center" class="danger" width="100">MIS in 2023</th>
					<th align="center" class="danger" width="100">CNM Website in 2023</th>

					<th align="center" class="danger" width="100">No Accessed in 2023</th>
					<th align="center" class="danger" width="100">Hard-Copies in 2023</th>
					<th align="center" class="danger" width="100">Soft-Copies in 2023</th>
					<th align="center" class="danger" width="100">MIS in 2023</th>
					<th align="center" class="danger" width="100">CNM Website in 2023</th>

					<th align="center" class="orange" width="100">No Accessed in 2024</th>
					<th align="center" class="orange" width="100">Hard-Copies in 2024</th>
					<th align="center" class="orange" width="100">Soft-Copies in 2024</th>
					<th align="center" class="orange" width="100">MIS in 2024</th>
					<th align="center" class="orange" width="100">CNM Website in 2024</th>

					<th align="center" class="orange" width="100">No Accessed in 2024</th>
					<th align="center" class="orange" width="100">Hard-Copies in 2024</th>
					<th align="center" class="orange" width="100">Soft-Copies in 2024</th>
					<th align="center" class="orange" width="100">MIS in 2024</th>
					<th align="center" class="orange" width="100">CNM Website in 2024</th>

					<th align="center" class="gray" width="100">No Accessed Rate (%)</th>
					<th align="center" class="gray" width="100">Hard-Copies Rate (%)</th>
					<th align="center" class="gray" width="100">Soft-Copies Rate (%)</th>
					<th align="center" class="gray" width="100">MIS Rate (%)</th>
					<th align="center" class="gray" width="100">CNM Website Rate (%)</th>

					<th align="center" class="gray" width="100">No Accessed Rate (%)</th>
					<th align="center" class="gray" width="100">Hard-Copies Rate (%)</th>
					<th align="center" class="gray" width="100">Soft-Copies Rate (%)</th>
					<th align="center" class="gray" width="100">MIS Rate (%)</th>
					<th align="center" class="gray" width="100">CNM Website Rate (%)</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel2, fixedHeader: true, fixedColumn: 3">
				<tr>
					<td align="center" valign="middle" data-bind="text: SN"></td>
					<th align="center" valign="middle" data-bind="text: Code"></th>
					<td valign="middle" data-bind="text: Name"></td>
					<td align="center" valign="middle" data-bind="text: Material"></td>
					<td align="center" valign="middle" data-bind="text: Retention"></td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess20, disable: $root.getDisable2(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard20, disable: $root.getDisable2(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft20, disable: $root.getDisable2(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS20, disable: $root.getDisable2(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web20, disable: $root.getDisable2(SN(),20)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess20e, disable: $root.getDisable2(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard20e, disable: $root.getDisable2(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft20e, disable: $root.getDisable2(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS20e, disable: $root.getDisable2(SN(),20)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web20e, disable: $root.getDisable2(SN(),20)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess21, disable: $root.getDisable2(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard21, disable: $root.getDisable2(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft21, disable: $root.getDisable2(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS21, disable: $root.getDisable2(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web21, disable: $root.getDisable2(SN(),21)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess21e, disable: $root.getDisable2(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard21e, disable: $root.getDisable2(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft21e, disable: $root.getDisable2(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS21e, disable: $root.getDisable2(SN(),21)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web21e, disable: $root.getDisable2(SN(),21)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess22, disable: $root.getDisable2(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard22, disable: $root.getDisable2(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft22, disable: $root.getDisable2(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS22, disable: $root.getDisable2(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web22, disable: $root.getDisable2(SN(),22)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess22e, disable: $root.getDisable2(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard22e, disable: $root.getDisable2(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft22e, disable: $root.getDisable2(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS22e, disable: $root.getDisable2(SN(),22)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web22e, disable: $root.getDisable2(SN(),22)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess23, disable: $root.getDisable2(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard23, disable: $root.getDisable2(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft23, disable: $root.getDisable2(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS23, disable: $root.getDisable2(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web23, disable: $root.getDisable2(SN(),23)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess23e, disable: $root.getDisable2(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard23e, disable: $root.getDisable2(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft23e, disable: $root.getDisable2(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS23e, disable: $root.getDisable2(SN(),23)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web23e, disable: $root.getDisable2(SN(),23)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess24, disable: $root.getDisable2(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard24, disable: $root.getDisable2(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft24, disable: $root.getDisable2(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS24, disable: $root.getDisable2(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web24, disable: $root.getDisable2(SN(),24)" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: NoAccess24e, disable: $root.getDisable2(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Hard24e, disable: $root.getDisable2(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Soft24e, disable: $root.getDisable2(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: MIS24e, disable: $root.getDisable2(SN(),24)" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Web24e, disable: $root.getDisable2(SN(),24)" />
					</td>

					<td align="center" valign="middle" data-bind="text: $root.getNoAccessRate($data,'')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getHardRate($data,'')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getSoftRate($data,'')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getMISRate($data,'')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getWebRate($data,'')"></td>

					<td align="center" valign="middle" data-bind="text: $root.getNoAccessRate($data,'e')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getHardRate($data,'e')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getSoftRate($data,'e')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getMISRate($data,'e')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getWebRate($data,'e')"></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="panel-body" data-bind="visible: menu().contain('Comp-Accuracy') && loaded3()">
		<table class="table table-bordered table-hover table-wide">
			<thead>
				<tr>
					<th align="center" rowspan="2" class="bg-thead">S.N</th>
					<th align="center" rowspan="2" class="bg-thead">Code</th>
					<th align="center" rowspan="2" class="bg-thead" width="300">Record Name</th>
					<th align="center" rowspan="2" class="bg-thead" width="81">Retention Years</th>
					<th align="center" rowspan="2" class="bg-thead" width="190">Assessed Record # (*selected 2 records/year)</th>
					<th align="center" class="warning" rowspan="2" width="80">Expected in 2020</th>
					<th align="center" class="warning" colspan="2">Baseline</th>
					<th align="center" class="warning" colspan="2">End-line</th>
					<th align="center" class="success" rowspan="2" width="80">Expected in 2021</th>
					<th align="center" class="success" colspan="2">Baseline</th>
					<th align="center" class="success" colspan="2">End-line</th>
					<th align="center" class="info" rowspan="2" width="80">Expected in 2022</th>
					<th align="center" class="info" colspan="2">Baseline</th>
					<th align="center" class="info" colspan="2">End-line</th>
					<th align="center" class="danger" rowspan="2" width="80">Expected in 2023</th>
					<th align="center" class="danger" colspan="2">Baseline</th>
					<th align="center" class="danger" colspan="2">End-line</th>
					<th align="center" class="orange" rowspan="2" width="80">Expected in 2024</th>
					<th align="center" class="orange" colspan="2">Baseline</th>
					<th align="center" class="orange" colspan="2">End-line</th>
					<th align="center" class="gray" colspan="2">Baseline</th>
					<th align="center" class="gray" colspan="2">End-line</th>
				</tr>
				<tr>
					<th align="center" class="warning" width="80">Completed in 2020</th>
					<th align="center" class="warning" width="80">Accurated in 2020</th>
					<th align="center" class="warning" width="80">Completed in 2020</th>
					<th align="center" class="warning" width="80">Accurated in 2020</th>
					<th align="center" class="success" width="80">Completed in 2021</th>
					<th align="center" class="success" width="80">Accurated in 2021</th>
					<th align="center" class="success" width="80">Completed in 2021</th>
					<th align="center" class="success" width="80">Accurated in 2021</th>
					<th align="center" class="info" width="80">Completed in 2022</th>
					<th align="center" class="info" width="80">Accurated in 2022</th>
					<th align="center" class="info" width="80">Completed in 2022</th>
					<th align="center" class="info" width="80">Accurated in 2022</th>
					<th align="center" class="danger" width="80">Completed in 2023</th>
					<th align="center" class="danger" width="80">Accurated in 2023</th>
					<th align="center" class="danger" width="80">Completed in 2023</th>
					<th align="center" class="danger" width="80">Accurated in 2023</th>
					<th align="center" class="orange" width="80">Completed in 2024</th>
					<th align="center" class="orange" width="80">Accurated in 2024</th>
					<th align="center" class="orange" width="80">Completed in 2024</th>
					<th align="center" class="orange" width="80">Accurated in 2024</th>
					<th align="center" class="gray" width="100">Completeness Rate (%)</th>
					<th align="center" class="gray" width="100">Accuracy Rate (%)</th>
					<th align="center" class="gray" width="100">Completeness Rate (%)</th>
					<th align="center" class="gray" width="100">Accuracy Rate (%)</th>
				</tr>
			</thead>
			<tbody data-bind="foreach: listModel3, fixedHeader: true, fixedColumn: 5">
				<tr>
					<!-- ko if: $root.ifNewGroup($index()) -->
					<td align="center" valign="middle" data-bind="text: SN" style="border-bottom:none"></td>
					<th align="center" valign="middle" data-bind="text: Code" style="border-bottom:none"></th>
					<td valign="middle" data-bind="text: Name" style="border-bottom:none"></td>
					<td align="center" valign="middle" data-bind="text: Retention" style="border-bottom:none"></td>
					<!-- /ko -->
					<!-- ko ifnot: $root.ifNewGroup($index()) -->
					<td style="border-top:none; border-bottom:none"></td>
					<td style="border-top:none; border-bottom:none"></td>
					<td style="border-top:none; border-bottom:none"></td>
					<td style="border-top:none; border-bottom:none"></td>
					<!-- /ko -->

					<td align="center" valign="middle" data-bind="text: Record"></td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect20" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete20" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate20" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete20e" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate20e" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect21" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete21" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate21" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete21e" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate21e" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect22" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete22" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate22" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete22e" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate22e" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect23" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete23" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate23" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete23e" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate23e" />
					</td>

					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Expect24" disabled />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete24" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate24" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Complete24e" />
					</td>
					<td align="center" valign="middle">
						<input type="text" class="text-center" data-bind="textInput: Accurate24e" />
					</td>

					<td align="center" valign="middle" data-bind="text: $root.getCompleteRate($data,'')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getAccuracyRate($data,'')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getCompleteRate($data,'e')"></td>
					<td align="center" valign="middle" data-bind="text: $root.getAccuracyRate($data,'e')"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?=latestJs('/media/ViewModel/DOC_OD.js')?>