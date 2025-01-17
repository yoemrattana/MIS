<style>
	body {
		background-color: #f3f1f196;
	}

    input[type=checkbox]
    {
      -ms-transform: scale(2); /* IE */
      -moz-transform: scale(2); /* FF */
      -webkit-transform: scale(2); /* Safari and Chrome */
      -o-transform: scale(2); /* Opera */
      padding: 10px;
    }

	.card {
		box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
		border: 2px solid #01c0c8;
		background: #fff;
	}

    .table td, .table th {
        padding: 6px !important;
        text-align: center;
        vertical-align: middle !important;
    }

    .tbl-label {
        vertical-align: middle !important;
    }

    table thead tr th {
        font-family: 'Khmer OS Battambang';
        font-weight: 700;
    }

	.table thead th {
        border-bottom: none;
        vertical-align: middle;
        text-align: center;
		height: 40px;
    }

    .btn-circle {
        border-radius: 100%;
        width: 25px;
        height: 25px;
        padding: 2px;
    }

    
    .float-left {
        float: left;
    }

    body {
        font-family: 'Koh-Santepheap-Body', 'Open Sans','Battambang', sans-serif, cursive;
    }

    .control-label {
		top: 10px;
    }

	.form-group { margin-bottom:0}

	.pdate {position:relative}

    .target {
        width: 2em;
        height: 2em;
        box-sizing: initial;
        background: #fff;
        border: 0.1em solid red;
        text-align: center;
        border-radius: 50%;
        line-height: 2em;
        box-sizing: content-box;
        font-size: 13px;
		padding: 0 8px;
    }

	.message-error {
		color: tomato;
		padding: 5px 0;
		font-size: 14px;
		display: block;
	}

</style>

<div data-bind="page: {id: 'start', title: 'Last Mile', scrollToTop: true, sourceCache: false}" style="display: none">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Lastmile</h4>
					<form>
						<div class="container9">
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: od,
											options: odList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: odList().length == 1 ? undefined : 'Select OD'"
											class="form-control input-sm minwidth150"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: hc,
											options: hcList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'Select HC'",
											
											class="form-control"></select>
									</div>
								</div>

								<div class="col-sm-8">
									<a href="/Home" class="btn btn-dark pull-right"><i class="fa fa-home"></i> Home</a>
									<a href="/LastmileData" class="btn btn-success pull-right" style="margin-right: 5px"><i class="fa fa-list"></i> Data</a>
									<a href="/LastmileDashboard" class="btn btn-success pull-right" style="margin-right: 5px">Dashboard</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Village List -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-striped table-hover">
						<thead class="bg-info">
							<tr>
								<th width="40" align="center">#</th>
								<th align="center">Village (KH)</th>
								<th align="center">Village (EN)</th>
								<th align="center">View</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: reportList, fixedHeader: true">
							<tr>
								<td data-bind="text: $index() + 1" class="text-center"></td>
								<td data-bind="text: Name_Vill_K" class="kh"></td>
								<td data-bind="text: Name_Vill_E"></td>
								<td align="center">
									<a class="btn btn-success btn-sm" data-bind="page-href: {path: '/houses', params: {vl: Code_Vill_T}}">
										<i class="fa fa-home"></i> House Hold
									</a>
									<a class="btn btn-primary btn-sm" data-bind="page-href: {path: '/tdasummary', params: {vl: Code_Vill_T}}">
										<i class="fa fa-home"></i> TDA Summary
									</a>
									<a class="btn btn-info btn-sm" data-bind="page-href: {path: '/iptsummary', params: {vl: Code_Vill_T}}">
										<i class="fa fa-home"></i> IPT Summary
									</a>
								</td>
							</tr>
						</tbody>
						<tfoot data-bind="visible: app.tableFooter($element)">
							<tr>
								<td class="text-center text-warning h4" style="padding:10px">No Data</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- tda summary -->
<div data-bind="page: {id: 'tdasummary', title: 'TDA Summary', params: ['vl'], scrollToTop: true, sourceCache:false, withOnShow: loadTDASummary}" style="display:none">
	<div class="row" >
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">TDA Summary</h4>
					<form>
						<div class="container9">
							<div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-3">
								            <div class="form-group">
									            <select data-bind="value: $root.year, options: $root.yearList, optionsCaption: 'All'" class="form-control input-sm width70"></select>
								            </div>
							            </div>
							            <div class="col-sm-3">
								            <div class="form-group">
									            <select data-bind="value: $root.month, options: $root.monthList, optionsCaption: 'All'" class="form-control"></select>
								            </div>
							            </div>
                                        <div class="col-sm-1">
                                            <button class="btn btn-primary" data-bind="click: $root.getTDASummary">View Data</button>
                                        </div>
                                    </div>
                                </div>    
								<div class="col-sm-4">
									<a class="btn btn-dark pull-right" data-bind="page-href: '../start'" style="color:white;margin-right: 5px"> Back</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-striped table-hover">
						<thead class="bg-info">
							<tr>
								<th rowspan="3" align="center">ល.រ ខ្នងផ្ទះ</th>
								<th rowspan="3" align="center">#ចំនួនសមាជិកគ្រួសារ</th>
								<th colspan="4" align="center">ការចែកមុងបន្ថែម</th>
								<th rowspan="3" align="center">#ក្រុមគោលដៅTDA</th>
								<th colspan="6" align="center">ការផ្តល់ថ្នាំដល់ក្រុមគោលដៅសម្រាប់ក្រុមបុរសអាយុ15-49ឆ្នាំលើកទី១(TDA1)</th>
								<th colspan="6" align="center">ការផ្តល់ថ្នាំដល់ក្រុមគោលដៅសម្រាប់ក្រុមបុរសអាយុ15-49ឆ្នាំលើកទី២(TDA2)</th>
							</tr>
							
							<tr>
								<th rowspan="2" align="center">#មុងគ្រែដែលខ្វះ</th>
								<th rowspan="2" align="center">#មុងគ្រែដែលបានផ្តល់</th>
								<th rowspan="2" align="center">#មុងអង្រឹងដែលខ្វះ</th>
								<th rowspan="2" align="center">#មុងអង្រឹងដែលបានផ្តល់</th>
								
								<th rowspan="2" align="center">#អ្នកបានទទួលថ្នាំ</th>
								<th rowspan="2" align="center">#ហាមប្រើ</th>
								<th colspan="3" align="center">បដិសេដ</th>
								<th rowspan="2" align="center">#អវត្តមាន</th>

								<th rowspan="2" align="center">#អ្នកបានទទួលថ្នាំ</th>
								<th rowspan="2" align="center">#ហាមប្រើ</th>
								<th colspan="3" align="center">បដិសេដ</th>
								<th rowspan="2" align="center">#អវត្តមាន</th>
							</tr>

							<tr>
								<th align="center">#ផលរំខាននៃថ្នាំ</th>
								<th align="center">#មិនឈឺ</th>
								<th align="center">#ផ្សេងៗ</th>

								<th align="center">#ផលរំខាននៃថ្នាំ</th>
								<th align="center">#មិនឈឺ</th>
								<th align="center">#ផ្សេងៗ</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: TDAsummary2, fixedHeader: true">
							<tr>
								<td data-bind="text: HouseNumber" ></td>
								<td data-bind="text: TotalMember"></td>
								<td data-bind="text: LLINLack"></td>
								<td data-bind="text: LLIN"></td>
								<td data-bind="text: LLIHNLack"></td>
								<td data-bind="text: LLIHN"></td>
								<td data-bind="text: TDA"></td>
								<td data-bind="text: TDA1Received"></td>
								<td data-bind="text: TDA1DoNotUse"></td>
								<td data-bind="text: TDA1SideEffect"></td>
								<td data-bind="text: TDA1NotSick"></td>
								<td data-bind="text: TDA1OtherReason"></td>
								<td data-bind="text: TDA1Absent"></td>
								<td data-bind="text: TDA2Received"></td>
								<td data-bind="text: TDA2DoNotUse"></td>
								<td data-bind="text: TDA2SideEffect"></td>
								<td data-bind="text: TDA2NotSick"></td>
								<td data-bind="text: TDA2OtherReason"></td>
								<td data-bind="text: TDA2Absent"></td>
							</tr>
						</tbody>
						<tfoot>
							<tr style="font-weight:bold">
                                <td>Total</td>
								<td data-bind="text: $root.TDAsummary2().sum('TotalMember')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('LLINLack')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('LLIN')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('LLIHNLack')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('LLIHN')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA1Received')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA1DoNotUse')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA1SideEffect')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA1NotSick')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA1OtherReason')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA1Absent')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA2Received')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA2DoNotUse')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA2SideEffect')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA2NotSick')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA2OtherReason')"></td>
                                <td data-bind="text: $root.TDAsummary2().sum('TDA2Absent')"></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ipt summary -->
<div data-bind="page: {id: 'iptsummary', title: 'IPT Summary', params: ['vl'], scrollToTop: true, sourceCache:false, withOnShow: loadIPTSummary}" style="display:none">
	<div class="row" >
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">IPT Summary</h4>
					<form>
						<div class="container9">
							<div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-3">
								            <div class="form-group">
									            <select data-bind="value: $root.year, options: $root.yearList, optionsCaption: 'All'" class="form-control input-sm width70"></select>
								            </div>
							            </div>
							            <div class="col-sm-3">
								            <div class="form-group">
									            <select data-bind="value: $root.month, options: $root.monthList, optionsCaption: 'All'" class="form-control"></select>
								            </div>
							            </div>
                                        <div class="col-sm-1">
                                            <button class="btn btn-primary" data-bind="click: $root.getIPTSummary">View Data</button>
                                        </div>
                                    </div>
                                </div>    
								<div class="col-sm-4">
									<a class="btn btn-dark pull-right" data-bind="page-href: '../start'" style="color:white;margin-right: 5px"> Back</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-striped table-hover">
						<thead class="bg-info">
							<tr>
								<th rowspan="3" align="center">ល.រ ខ្នងផ្ទះ</th>
								<th rowspan="3" align="center">#ចំនួនសមាជិកគ្រួសារ</th>
								<th colspan="8" align="center">ការប្រើប្រាស់ថ្នាំការពារជាមុនសម្រាប់អ្នកចូលព្រៃ(IPTf)</th>
								<th colspan="3" align="center">តេស្តឈាម(AFS)</th>
							</tr>
							
							<tr>
								<th rowspan="2" align="center">#អវត្តមាន</th>
								<th rowspan="2" align="center">#ហាមប្រើ</th>
								<th colspan="3" align="center">#បដិសេដ</th>
								<th rowspan="2" align="center">#ចូលព្រៃ</th>
								<th rowspan="2" align="center">#មិនចូលព្រៃ</th>
								<th rowspan="2" align="center">#អ្នកបានទទួលថ្នាំIPTf</th>
								
								<th rowspan="2" align="center">#អវត្តមាន</th>
								<th rowspan="2" align="center">#បានតេស្ត</th>
								<th rowspan="2" align="center">#មិនបានតេស្ត</th>
							</tr>

							<tr>
								<th align="center">#ផលរំខាននៃថ្នាំ</th>
								<th align="center">#មិនឈឺ</th>
								<th align="center">#ផ្សេងៗ</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: IPTsummary2, fixedHeader: true">
							<tr>
								<td data-bind="text: HouseNumber"></td>
								<td data-bind="text: TotalMember"></td>
								<td data-bind="text: Absent"></td>
								<td data-bind="text: DoNotUse"></td>
								<td data-bind="text: SideEffect"></td>
								<td data-bind="text: NotSick"></td>
								<td data-bind="text: OtherReason"></td>
								<td data-bind="text: EnterForest"></td>
								<td data-bind="text: NotEnterForest"></td>
								<td data-bind="text: Received"></td>
								<td data-bind="text: W1Absent+W2Absent+W3Absent+W4Absent"></td>
								<td data-bind="text: W1Tested+W2Tested+W3Tested+W4Tested"></td>
								<td data-bind="text: W1NotTested+W2NotTested+W3NotTested+W4NotTested"></td>
							</tr>
						</tbody>
                        <tfoot>
                            <tr style="font-weight:bold">
                                <td>Total</td>
                                <td data-bind="text: $root.IPTsummary2().sum('TotalMember')"></td>
                                <td data-bind="text: $root.IPTsummary2().sum('Absent')"></td>
                                <td data-bind="text: $root.IPTsummary2().sum('DoNotUse')"></td>
                                <td data-bind="text: $root.IPTsummary2().sum('SideEffect')"></td>
                                <td data-bind="text: $root.IPTsummary2().sum('NotSick')"></td>
                                <td data-bind="text: $root.IPTsummary2().sum('OtherReason')"></td>
                                <td data-bind="text: $root.IPTsummary2().sum('EnterForest')"></td>
                                <td data-bind="text: $root.IPTsummary2().sum('NotEnterForest')"></td>
                                <td data-bind="text: $root.IPTsummary2().sum('Received')"></td>
                                <td data-bind="text: parseInt($root.IPTsummary2().sum('W1Absent')) + parseInt($root.IPTsummary2().sum('W2Absent')) + parseInt($root.IPTsummary2().sum('W3Absent')) + parseInt($root.IPTsummary2().sum('W4Absent'))"></td>
                                <td data-bind="text: parseInt($root.IPTsummary2().sum('W1Tested')) + parseInt($root.IPTsummary2().sum('W2Tested')) + parseInt($root.IPTsummary2().sum('W3Tested')) + parseInt($root.IPTsummary2().sum('W4Tested'))"></td>
                                <td data-bind="text: parseInt($root.IPTsummary2().sum('W1NotTested')) + parseInt($root.IPTsummary2().sum('W2NotTested')) + parseInt($root.IPTsummary2().sum('W3NotTested')) + parseInt($root.IPTsummary2().sum('W4NotTested'))"></td>
                            </tr>
                        </tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- House Hold List-->
<div data-bind="page: {id: 'houses', title: 'House List', params: ['vl'], scrollToTop: true, sourceCache:false, withOnShow: loadHouses}" style="display:none">
	<div class="row" >
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Houses</h4>
					<form>
						<div class="container9">
							<div class="row">
								<div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-2" style="border:1px solid;">
                                            <p style="font-weight: bold; margin:0">Note: The meaning of button color</p>
                                            <button class="btn btn-primary btn-xs"></button> : No Data
                                            <button class="btn btn-success btn-xs"></button> : Has Data
                                        </div>
                                        <div class="checkbox col-sm-2" style="border:1px solid;">
                                          <label style="color:red; margin-top:12px"><input type="checkbox" data-bind="checked: $root.noLatLong" style="margin-right: 6px">Filter House Without Lat Long</label>
                                        </div>
                                    </div>

									<a class="btn btn-dark pull-right" data-bind="page-href: '../start'" style="color:white;margin-right: 5px"> Back</a>
									<a class="btn btn-success pull-right" data-bind="page-href: {path: '/house', params: {vl: vl, h: 0}}" style="margin-right: 5px">
										<i class="fa fa-edit"></i>&nbsp; New House
									</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-striped table-hover">
						<thead class="bg-info">
							<tr>
								<th width="40" align="center">#</th>
								<th align="center">House Number</th>
								<th align="center">House Holder</th>
								<th align="center">Phone Number</th>
                                <th>Lat</th>
                                <th>Long</th>
								<th align="center">Action</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: houseList, fixedHeader: true">
							<tr>
								<td data-bind="text: $index() + 1" class="text-center"></td>
								<td data-bind="text:HouseNumber" class="kh"></td>
								<td data-bind="text: HouseHolder"></td>
								<td data-bind="text: Phone"></td>
                                <td data-bind="text: Lat"></td>
                                <td data-bind="text: Long"></td>
								<td align="center">
									<a class="btn btn-success btn-xs" data-bind="page-href: {path: '/house', params: {vl: Code_Vill_T, h: Rec_ID}}">
										<span style="font-size: 13px">ជំរឿនខ្នងផ្ទះ</span>
									</a>
									<a class="" data-bind="page-href: {path: '/tda', params: {vl: Code_Vill_T, h: Rec_ID, tda: 1, date_tda: TDA1, houseNumber: HouseNumber}}, attr: {class: TDA1 == null ? 'btn btn-xs btn-primary' : 'btn btn-xs btn-success'}" style="font-size: 13px">
										TDA 1
									</a>
									<a class="btn btn-success btn-xs" data-bind="page-href: {path: '/tda', params: {vl: Code_Vill_T, h: Rec_ID, tda: 2, date_tda: TDA1,houseNumber: HouseNumber}}, attr: {class: TDA1 == null ? 'btn btn-xs btn-primary' : 'btn btn-xs btn-success'}" style="font-size: 13px">
										TDA 2
									</a>
									<button class="btn btn-success btn-xs" data-bind="click: $root.preLoadIPT, attr: {class: IPT == null ? 'btn btn-xs btn-primary' : 'btn btn-xs btn-success'}" style="font-size: 13px">
										IPT
									</button>
									<button class="btn btn-success btn-xs" data-bind="click: $root.preLoadAFS, attr: {class: AFS == null ? 'btn btn-xs btn-primary' : 'btn btn-xs btn-success'}" style="font-size: 13px">
										AFS
									</button>
									<button type="button" class="btn btn-danger btn-xs" data-bind="click: $root.deleteHouse, visible: app.user.permiss['Lastmile'].contain('Delete')" style="font-size: 13px">
										Delete
									</button>
								</td>
							</tr>
						</tbody>
						<tfoot data-bind="visible: app.tableFooter($element)">
							<tr>
								<td class="text-center text-warning h4" style="padding:10px">No Data</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>

<!--Form House hold-->
<div class="row" data-bind="page: {id: 'house', params: ['vl', 'h'], title: 'House', scrollToTop: true, sourceCache:false, withOnShow: loadHouse}" style="display:none">
	<div class="col-lg-12">
		<div class="card" style="width: 100%; margin: 0 auto">
			
			<div class="card-header bg-info">
				<h4 class="m-b-0 text-white float-left">Lastmile</h4>
				<a class="btn btn-dark pull-right" data-bind="page-step: -1">
					<i class="fa fa-angle-double-left"></i>&nbsp Back
				</a>
			</div>
			<div class="card-body">
				<form action="#">
					<div class="form-body">
						<h3 class="card-title">
							<kh>ផ្នែកទី១៖ ជំរឿនសមាជិកខ្នងផ្ទះ</kh>
						</h3>
						<hr />
						<div class="row" >
							<div class="col-md-3">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">ខែ៖</label>
									<div class="col-md-9 question">
										<select data-bind="value: Month, options: $root.monthList, optionsCaption: 'Month'" class="form-control"></select>
										<span data-bind="validationMessage: Month" class="message-error"></span>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">ឆ្នាំ៖</label>
									<div class="col-md-9">
										<select data-bind="value: Year, options: $root.yearList, optionsCaption: 'Year'" class="form-control input-sm width70"></select>
										<span data-bind="validationMessage: Year" class="message-error"></span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">មានមនុស្សនៅផ្ទះ?៖</label>
									<div class="col-md-9">
										<select class="form-control" data-bind="value: HasMemberAtHome, optionsCaption: 'Select', options: ['Yes','No']"></select>
										<span data-bind="validationMessage: HasMemberAtHome" class="message-error"></span>
									</div>
								</div>
							</div>
							
						</div>

						<div class="row p-t-20" >
							<div class="col-md-3">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">លរ ខ្នងផ្ទះ​​​​ </label>
									<div class="col-md-9">
										<input type="text" class="form-control" min="0"
               oninput="this.value = this.value.replace(/[^0-9-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-bind="value:HouseNumber"/>
										<span data-bind="validationMessage: HouseNumber" class="message-error"></span>
									</div>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">ឈ្មោះមេគ្រួសារ៖</label>
									<div class="col-md-9 question">
										<input type="text" class="form-control" data-bind="value: HouseHolder"/>
										<span data-bind="validationMessage: HouseHolder" class="message-error"></span>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">ទូរស័ព្ទ៖</label>
									<div class="col-md-9">
										<input type="text" class="form-control" data-bind="value: Phone" />
										<span data-bind="validationMessage: Phone" class="message-error"></span>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">Lat៖</label>
									<div class="col-md-9">
										<input type="text" class="form-control" data-bind="value: Lat" />
										<span data-bind="validationMessage: Lat" class="message-error"></span>
									</div>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">Long៖</label>
									<div class="col-md-9">
										<input type="text" class="form-control" data-bind="value: Long" />
										<span data-bind="validationMessage: Long" class="message-error"></span>
									</div>
								</div>
							</div>
						</div> <!--/row end-->
						<br />
						<div >
							<table data-bind="if: HasMemberAtHome() == 'Yes'" class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
								<thead class="bg-info">
									<tr>
										<th>លរ</th>
										<th>ឈ្មោះ</th>
										<th>អាយុ</th>
										<th>ភេទ</th>
										<th>អ្នកចូលព្រៃ</th>
										<th>ក្រុមគោលដៅ TDA</th>
										<th>ក្រុមគោលដៅ IPT</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody data-bind="foreach: $root.memberList">
									<tr>
										<td class="tbl-label" data-bind="text: $index() + 1"></td>
										<td><input class="form-control" type="text" data-bind="value: Name"/><span data-bind="validationMessage: Name" class="message-error"></span></td>
										<td><input class="form-control" type="number" data-bind="value: Age" /><span data-bind="validationMessage: Age" class="message-error"></span></td>
										<td><select class="form-control" data-bind="value: Sex, options: ['M','F']"></select></td>
										<td>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input"  name="ForestEntry" data-bind="checked: ForestEntry, attr: { id: 'ForestEntry' + $index() }" />
												<label class="custom-control-label" data-bind="attr: {for: 'ForestEntry'+$index()}"></label>
											</div>
										<!--<select class="form-control" data-bind="value: ForestEntry, options: ['Yes','No']"></select>-->
										</td>
										<td>
											<div class="custom-control custom-checkbox">
												<input disabled type="checkbox" class="custom-control-input"  name="TDA" data-bind="checked: TDA, attr: { id: 'TDA' + $index() }" />
												<label class="custom-control-label" data-bind="attr: {for: 'TDA'+$index()}"></label>
											</div>
										<!--<input class="form-control" disabled type="text" data-bind="value: TDA" />-->
										</td>
										<td>
											<div class="custom-control custom-checkbox">
												<input disabled type="checkbox" class="custom-control-input"  name="IPT" data-bind="checked: IPT, attr: { id: 'IPT' + $index() }" />
												<label class="custom-control-label" data-bind="attr: {for: 'IPT'+$index()}"></label>
											</div>
										<!--<input class="form-control" disabled type="text" data-bind="value: IPT" />-->
										</td>
										<td>
											<!-- ko if: Rec_ID() == -1 -->
											<button class="btn btn-primary btn-xs" style="width:70px" data-bind="click: $root.addMember, visible: app.user.permiss['Lastmile'].contain('Edit')">Add</button>
											<!-- /ko -->

											<!-- ko if: Rec_ID() > -1 -->
											<button class="btn btn-danger btn-xs" style="width:70px" data-bind="click: $root.deleteMember, visible: app.user.permiss['Lastmile'].contain('Delete')">Delete</button>
											<!-- /ko -->
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
							<tbody >
								<tr>
									<td class="tbl-label">ចំនួនសមាជិកសរុប៖​</td>
									<td><input class="form-control" type="text" disabled data-bind="value: TotalMember" /></td>
									<td class="tbl-label">ចំនួន LLINs៖​ </td>
									<td><input class="form-control" type="number"  oninput="this.value = this.value.replace(/[^0-9-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-bind="value: LLIN" /></td>
									<td class="tbl-label">ចំនួន LLINs ដែលខ្វះ៖​</td>
									<td><input disabled class="form-control" type="text" data-bind="value: LLINLack" /></td>
								</tr>
								<tr>
									<td class="tbl-label">ចំនួនអ្នកចូលព្រៃ៖​</td>
									<td><input class="form-control" type="text" disabled data-bind="value: TotalForestEntry" /></td>
									<td class="tbl-label">ចំនួន LLIHNs៖​</td>
									<td><input class="form-control" type="number"  oninput="this.value = this.value.replace(/[^0-9-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-bind="value: LLIHN" /></td>
									<td class="tbl-label">ចំនួន LLIHNs ដែលខ្វះ៖​ </td>
									<td><input disabled class="form-control" type="text" data-bind="value: LLIHNLack" /></td>
								</tr>
							</tbody>
						</table>

						<br />
						
						<div class="row p-t-20">
							<div class="col-md-5">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">បំពេញរបាយការណ៍ដោយ៖ </label>
									<div class="col-md-9">
										<input type="text" class="form-control" data-bind="value:CompleteBy"/>
										<span data-bind="validationMessage: CompleteBy" class="message-error"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">តួនាទី៖ </label>
									<div class="col-md-9">
										<input type="text" class="form-control" data-bind="value:Position"/>
										<span data-bind="validationMessage: Position" class="message-error"></span>
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group row">
									<label class="control-label text-right col-md-3">ថ្ងៃទី៖ </label>
									<div class="col-md-9">
										<input type="text" class="form-control" data-bind="datePicker: CompleteDate, format: 'YYYY-MM-DD', dataType: 'string'" />
										<span data-bind="validationMessage: CompleteDate" class="message-error"></span>
									</div>
								</div>
							</div>

						</div>
						
					</div><!--/form-body end-->
					<div class="form-actions">
						<button type="submit" class="btn btn-success" data-bind="click: $root.saveHouse, visible: app.user.permiss['Lastmile'].contain('Edit')">
							<i class="fa fa-check"></i> Save
						</button>
						<a class="btn btn-inverse" data-bind="page-step:-1">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Form TDA-->
<div class="row" data-bind="page: {id: 'tda', params: ['vl', 'h', 'tda', 'date_tda', 'houseNumber'], title: 'TDA', scrollToTop: true, sourceCache:false, withOnShow: loadTda}" style="display:none">
	<div class="col-lg-12">
		<div class="card" style="width: 100%; margin: 0 auto">
			<div class="card-header bg-info">
				<h4 class="m-b-0 text-white float-left">TDA ផ្ទះលេខ : <span data-bind="text: houseNumber()"></span></h4>
				<a class="btn btn-dark pull-right" data-bind="page-href: '/houses?vl='+vl()">
					<i class="fa fa-angle-double-left"></i>&nbsp Back
				</a>
			</div>
			<div class="card-body">
				<form action="#">
					<div class="form-body">
						<h3 class="card-title">
							<kh>ផ្នែកទី២៖ អន្តរាគមន៍គោលដៅលើមនុស្សនៅក្នុងខ្នងផ្ទះដែលប្រឈម</kh>
						</h3>
						<hr />

						<div class="row" style="margin-bottom: 10px">
							<div class="col-md-4">
								<div class="form-group row">
									<label class="control-label text-right col-md-4">ថ្ងៃធ្វើTDA៖</label>
									<div class="col-md-8">
										<div class="form-group">
											<input type="text" class="form-control pdate" data-bind="datePicker: TDADate, format: 'YYYY-MM-DD', dataType: 'string'" />
											<span data-bind="validationMessage: TDADate" class="message-error"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<button class="btn btn-danger pull-right" data-bind="click: $root.deleteTDA, visible: app.user.permiss['Lastmile'].contain('Delete')"> <i class="fa fa-trash"> </i> Delete TDA</button>
							</div>
						</div>
						
						<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
							<thead>
								<tr class="bg-primary">
									<th></th>
									<th style="text-align: center" colspan="7">ការប្រើថ្នាំដោយផ្តោតលើគោលដៅជាក់លាក់ លើកទី <span data-bind="text: $root.TDAtype"></span></th>
								</tr>
								<tr class="bg-info">
									<th rowspan="2">ល.រ សមាជិក</th>
									<th rowspan="2">ហាមប្រើ</th>
									<th colspan="3">បដិសេដ</th>
									<th rowspan="2">អវត្តមាន</th>
									<th rowspan="2">ថ្ងៃ TDA <span data-bind="text: $root.TDAtype"></span></th>
								</tr>
								<tr class="bg-info">
									<th>ផលរំខាន</th>
									<th>មិនឈឺ</th>
									<th>ផ្សេងៗ</th>
								</tr>
							</thead>
							<tbody data-bind="foreach: TDAList">
								<tr>
									<td style="text-align:center"><span data-bind="text: $index() + 1, css: {target: IsTDA() == '1'}"></span></td>
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="DoNotUse" name="DoNotUse" data-bind="checked: DoNotUse, attr: { id: 'DoNotUse' + $index() }" />
											<label class="custom-control-label" data-bind="attr: { for: 'DoNotUse' + $index() }"></label>
										</div>
									</td>
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="SideEffect" data-bind="checked: SideEffect, attr: { id: 'SideEffect' + $index() }" />
											<label class="custom-control-label" data-bind="attr: { for: 'SideEffect' + $index() }"></label>
										</div>
									</td​​>
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="NotSick" data-bind="checked: NotSick, attr: { id: 'NotSick' + $index() }" />
											<label class="custom-control-label" data-bind="attr: { for: 'NotSick' + $index() }"></label>
										</div>
									</td>
									<td>
										<input class="form-control" data-bind="value: RejectOtherReason"/>
									</td>
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="Absent" name="Absent" data-bind="checked: Absent, attr: { id: 'Absent' + $index() }" />
											<label class="custom-control-label" data-bind="attr: { for: 'Absent' + $index() }"></label>
										</div>
									</td>
									
									<td>							
										<!--<div class="form-group">
											<input type="text" class="form-control pdate" data-bind="datePicker: Date, format: 'YYYY-MM-DD', dataType: 'string'" />
										</div>-->
                                        <input type="date" class="form-control pdate" data-bind="value: Date" />
									</td>
								</tr>
							</tbody>
						</table>
						
						<h5 class="card-title">
							<kh>ពត័មានសង្ខេប​ - ត្រូវបំពេញនៅចុងបញ្ចប់</kh>
						</h5>
						<hr />

						<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
							<thead>
								<tr>
									<th style="text-align: center; vertical-align:middle" rowspan="2">ល.រ​ ខ្នងផ្ទះ</th>
									<th style="text-align: center; vertical-align:middle" rowspan="2">ចំនួនសមាជិក</th>
									<th style="text-align: center" class="bg-primary" colspan="4">ការចែកបន្ថែម</th>
								</tr>
								<tr class="bg-info">
									<th>ចំនួន LLINs ដែលខ្វះ</th>
									<th>ចំនួន LLINs ដែលបានផ្តល់</th>
									<th>ចំនួន LLIHNs ដែលខ្វះ</th>
									<th>ចំនួន LLIHNs ដែលបានផ្តល់</th>
								</tr>
							</thead>
							<tbody data-bind="with: TDAnet">
								<tr>
									<td style="text-align:center" data-bind="text:HouseNumber"></td>
									<td data-bind="text: TotalMember"></td>
									<td>
										<input disabled type="text" class="form-control" data-bind="value: LLINLack" />
									</td>
									<td>
										<input type="number" class="form-control" data-bind="value: LLINOffer" />
									</td>
									<td>
										<input disabled type="text" class="form-control" data-bind="value: LLIHNLack" />
									</td>
									<td>
										<input type="number" class="form-control" data-bind="value: LLIHNOffer" />
									</td>
								</tr>
							</tbody>
						</table>

						<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
							<thead>
								<tr class="bg-primary">
									<th style="text-align: center" colspan="8">ការប្រើឳសថដោយផ្តោតគោលដៅជាក់លាក់​ - TDA</th>
								</tr>
								<tr class="bg-info">
									<th rowspan="2">ក្រុមគោលដៅ TDA</th>
									<th rowspan="2">#ក្រុមគោលដៅ TDA </th>
									<th rowspan="2">#បានទទួលថ្នាំ</th>
									<th rowspan="2">#ហាមប្រើ</th>
									<th colspan="3">បដិសេដ</th>
									<th rowspan="2">#អវត្តមាន</th>
								</tr>
								<tr class="bg-info">
									<th>#ផលរំខាននៃថ្នាំ</th>
									<th>#មិនឈឺ</th>
									<th>#ផ្សេងៗ</th>
								</tr​>
							</thead>
							<tbody data-bind="with: TDAsummary">
								<tr data-bind="if: $root.TDAtype() == 1">
									<td>លើកទី <span data-bind="text: $root.TDAtype()"></span></td>
									<td data-bind="text: TDA1Total"></td>
									<td data-bind="text: TDA1Recieved"></td>
									<td data-bind="text: TDA1DoNotUse"></td>
									<td data-bind="text: TDA1SideEffect"></td>
									<td data-bind="text: TDA1NotSick"></td>
									<td data-bind="text: TDA1OtherReason"></td>
									<td data-bind="text: TDA1Absent"></td>
								</tr>
								<tr data-bind="if: $root.TDAtype() == 2">
									<td>លើកទី <span data-bind="text: $root.TDAtype()"></span></td>
									<td data-bind="text: TDA2Total"></td>
									<td data-bind="text: TDA2Recieved"></td>
									<td data-bind="text: TDA2DoNotUse"></td>
									<td data-bind="text: TDA2SideEffect"></td>
									<td data-bind="text: TDA2NotSick"></td>
									<td data-bind="text: TDA2OtherReason"></td>
									<td data-bind="text: TDA2Absent"></td>
								</tr>
							</tbody>
						</table>

					</div><!--/form-body end-->
					<div class="form-actions">
						<button type="submit" class="btn btn-success" data-bind="click: $root.saveTDA, visible: app.user.permiss['Lastmile'].contain('Edit')">
							<i class="fa fa-check"></i> Save
						</button>
						<a class="btn btn-inverse" data-bind="page-href: '/houses?vl='+vl()">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- IPT form-->
<div class="row" data-bind="page: {id: 'ipt', params: ['vl', 'h','date','is_new', 'houseNumber'], title: 'IPT', scrollToTop: true, sourceCache:false, withOnShow: loadIpt}" style="display:none">
	<div class="col-lg-12">
		<div class="card" style="width: 100%; margin: 0 auto">
			<div class="card-header bg-info">
				<h4 class="m-b-0 text-white float-left">IPT​ ផ្ទះលេខ : <span data-bind="text: houseNumber()"></span></h4>
				<a class="btn btn-dark pull-right" data-bind="page-href: '/houses?vl='+vl()">
					<i class="fa fa-angle-double-left"></i>&nbsp Back
				</a>
			</div>
			<div class="card-body">
				<form action="#">
					<div class="form-body">
						<h3 class="card-title">
							<kh>ផ្នែកទី៣៖ ការផ្តល់ថ្នាំការពារជាមុន IPT សម្រាប់អ្នកចូលព្រៃ</kh>
						</h3>
						<hr />

						<div class="row" style="margin-bottom: 10px">
							<div class="col-md-4">
								<div class="form-group row">
									<label class="control-label text-right col-md-4">IPT Date៖</label>
									<div class="col-md-8">
										<div class="form-group">
											<input type="text" class="form-control" data-bind="datePicker: IPTDate, format: 'YYYY-MM-DD', dataType: 'string'" />
											<span data-bind="validationMessage: IPTDate" class="message-error"></span>
											<br />
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<button class="btn btn-danger pull-right" data-bind="click: $root.deleteIPT, visible: app.user.permiss['Lastmile'].contain('Delete')"> <i class="fa fa-trash"> </i> Delete IPT</button>
							</div>
						</div>

						<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
							<thead>
								<tr>
									<th rowspan="3" style="text-align:center; vertical-align: middle">ល.រ សមាជិក</th>
									<td class="bg-primary" colspan="7" style="text-align:center">IPTf</td>
								</tr>
								<tr class="bg-info">
									<th rowspan="2">អវត្តមាន</th>
									<th rowspan="2">ហាមប្រើ</th>
									<th colspan="3">បដិសេដ</th>
									<th rowspan="2">ចូលព្រៃ</th>
									<th rowspan="2" width="115">ថ្ងៃ/ខែ/ឆ្នាំ <br /> បានទទួលថ្នាំ</th>
								</tr>
								<tr class="bg-info">
									<th>ផលរំខាននៃថ្នាំ</th>
									<th>មិនឈឺ</th>
									<th>ផ្សេងៗ</th>
								</tr>
							</thead>
							<tbody data-bind="foreach: IPTfList">
								<tr>
									<td style="text-align:center"><span data-bind="text: $index() + 1, css: {target: IsIPT() == '1'}"></span></td>
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input"  name="Absent" data-bind="checked: Absent, enable: IsIPT(), attr: { id: 'Absent' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'Absent'+$index()}"></label>
										</div>
									</td>
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input"  name="DoNotUse" data-bind="checked: DoNotUse, enable: IsIPT(), attr: { id: 'DoNotUse' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'DoNotUse'+$index()}"></label>
										</div>
									</td>
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input"  name="SideEffect" data-bind="checked: SideEffect, enable: IsIPT(), attr: { id: 'SideEffect' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'SideEffect'+$index()}"></label>
										</div>
										<!--<select class="form-control" data-bind="value: Reject, options: ['', 'N\/A', 'Yes','No']"></select>-->
									</td>
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input"  name="NotSick" data-bind="checked: NotSick, enable: IsIPT(), attr: { id: 'NotSick' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'NotSick'+$index()}"></label>
										</div>
									</td>

									<td><input type="text" class="form-control" data-bind="value: RefuseOtherReason" /></td>
									
									<td>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input"  name="NotEnterForest" data-bind="checked: NotEnterForest, enable: IsIPT(), attr: { id: 'NotEnterForest' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'NotEnterForest'+$index()}"></label>
										</div>
									</td>

									<td>
                                        <!--<div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" data-bind="enable: NotEnterForest() , datePicker: Date, format: 'YYYY-MM-DD', dataType: 'string'" />
                                            </div>
                                        </div>-->
                                        <input type="date" class="form-control" data-bind="enable: NotEnterForest() , value: Date" />
                                    </td>
									
								</tr>
							</tbody>
						</table>

					</div><!--/form-body end-->
					<div class="form-actions">
						<button type="submit" class="btn btn-success" data-bind="click: $root.saveIPT, visible: app.user.permiss['Lastmile'].contain('Edit')">
							<i class="fa fa-check"></i> Save
						</button>
						<a class="btn btn-inverse" data-bind="page-href: '/houses?vl='+vl()">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- AFS form -->
<div class="row" data-bind="page: {id: 'afs', params: ['vl', 'h','date','is_new', 'houseNumber'], title: 'AFS', scrollToTop: true, sourceCache:false, withOnShow: loadAfs}" style="display:none">
	<div class="col-lg-12">
		<div class="card" style="width: 100%; margin: 0 auto">
			<div class="card-header bg-info">
				<h4 class="m-b-0 text-white float-left">AFS ផ្ទះលេខ : <span data-bind="text: houseNumber()"></span></h4>
				<a class="btn btn-dark pull-right" data-bind="page-href: '/houses?vl='+vl()">
					<i class="fa fa-angle-double-left"></i>&nbsp Back
				</a>
			</div>
			<div class="card-body">
				<form action="#">
					<div class="form-body">
						<h3 class="card-title">
							<kh>ផ្នែកទី៤៖ AFS</kh>
						</h3>
						<hr />

						<div class="row"   style="margin-bottom: 10px">
							<div class="col-md-4">
								<div class="form-group row">
									<label class="control-label text-right col-md-4">AFS Date៖</label>
									<div class="col-md-8">
										<div class="form-group">
											<input type="text" class="form-control" data-bind="datePicker: AFSDate, format: 'YYYY-MM-DD', dataType: 'string'" />
											<span data-bind="validationMessage: AFSDate" class="message-error"></span>
											<br />
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<button class="btn btn-danger pull-right" data-bind="click: $root.deleteAFS, visible: app.user.permiss['Lastmile'].contain('Delete')"> <i class="fa fa-trash"> </i> Delete AFS</button>
							</div>
						</div>

						<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
							<thead>
								<tr>
									<th rowspan="2" style="text-align:center; vertical-align: middle">ល.រ សមាជិក</th>
									<td class="bg-success" colspan="5" style="text-align:center">AFS</td>
								</tr>
								<tr class="bg-info">
									<th>សប្តាហ៍ទី 1</th>
									<th>សប្តាហ៍ទី 2</th>
									<th>សប្តាហ៍ទី 3</th>
									<th>សប្តាហ៍ទី 4</th>
                                    <th>សប្តាហ៍ទី 5</th>
								</tr>
							</thead>
							<tbody data-bind="foreach: AFSList">
								<tr>
									<td style="text-align:center"><span data-bind="text: $index() + 1"></span></td>

									<td class="text-left">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="N/A" data-bind="checked: W1, attr: { id: 'W1' + $index() + '3', name: 'W1' + $index()  }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W1'+$index() + '3'}">អវត្តមាន</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="Yes" data-bind="checked: W1, attr: { id: 'W1' + $index() + '1', name: 'W1' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W1'+$index() + '1'}">បានតេស្ត</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="No" data-bind="checked: W1, attr: { id: 'W1' + $index() + '2', name: 'W1' + $index()  }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W1'+$index() + '2'}">មិនបានតេស្ត</label>
										</div>
									</td>
									<td class="text-left">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="N/A" data-bind="checked: W2, attr: { id: 'W2' + $index() + '3', name: 'W2' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W2'+$index() + '3'}">អវត្តមាន</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="Yes" data-bind="checked: W2, attr: { id: 'W2' + $index() + '1', name: 'W2' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W2'+$index() + '1'}">បានតេស្ត</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="No" data-bind="checked: W2, attr: { id: 'W2' + $index() + '2', name: 'W2' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W2'+$index() + '2'}">មិនបានតេស្ត</label>
										</div>
									</td>
									<td class="text-left">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="N/A" data-bind="checked: W3, attr: { id: 'W3' + $index() + '3', name: 'W3' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W3'+$index() + '3'}">អវត្តមាន</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="Yes" data-bind="checked: W3, attr: { id: 'W3' + $index() + '1', name: 'W3' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W3'+$index() + '1'}">បានតេស្ត</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="No" data-bind="checked: W3, attr: { id: 'W3' + $index() + '2', name: 'W3' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W3'+$index() + '2'}">មិនបានតេស្ត</label>
										</div>
									</td>
									<td class="text-left">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="N/A" data-bind="checked: W4, attr: { id: 'W4' + $index() + '3', name: 'W4' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W4'+$index() + '3'}">អវត្តមាន</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="Yes" data-bind="checked: W4, attr: { id: 'W4' + $index() + '1', name: 'W4' + $index()}" />
											<label class="custom-control-label" data-bind="attr: {for: 'W4'+$index() + '1'}">បានតេស្ត</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="No" data-bind="checked: W4, attr: { id: 'W4' + $index() + '2', name: 'W4' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W4'+$index() + '2'}">មិនបានតេស្ត</label>
										</div>
									</td>
                                    <td class="text-left">
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="N/A" data-bind="checked: W5, attr: { id: 'W5' + $index() + '3', name: 'W5' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W5'+$index() + '3'}">អវត្តមាន</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="Yes" data-bind="checked: W5, attr: { id: 'W5' + $index() + '1', name: 'W5' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W5'+$index() + '1'}">បានតេស្ត</label>
										</div>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" value="No" data-bind="checked: W5, attr: { id: 'W5' + $index() + '2', name: 'W5' + $index() }" />
											<label class="custom-control-label" data-bind="attr: {for: 'W5'+$index() + '2'}">មិនបានតេស្ត</label>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					
					</div><!--/form-body end-->
					<div class="form-actions">
						<button type="submit" class="btn btn-success" data-bind="click: $root.saveAFS, visible: app.user.permiss['Lastmile'].contain('Edit')">
							<i class="fa fa-check"></i> Save
						</button>
						<a class="btn btn-inverse" data-bind="page-href: '/houses?vl='+vl()">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>

<!-- Modal Save Change -->
<div class="modal" id="modalSave" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">
					<kh>មានការកែទិន្នន័យ</kh> - Data Changing
				</h3>
			</div>
			<div class="modal-body" style="font-size:18px">
				<kh>តើអ្នកចង់រក្សាទុកការកែទិន្នន័យនេះទេ?</kh>
				<br />
				<br />
				Do you want to save changes?
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-dismiss="modal" style="width:100px">Save</button>
				<button class="btn btn-danger btn-sm" data-dismiss="modal" style="width:100px">Don't Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal IPT -->
<div id="ipt" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="vcenter">IPTf</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<p>Date:</p>
				<div data-bind="foreach: IPTDates">
					<a class="btn btn-info" data-bind="text: ipt_date, page-href: {path: '/ipt', params: {vl: vl, h: h, date:ipt_date, is_new: false, houseNumber:houseNumber}}"></a>
				</div>

				<div data-bind="with: IPTmaster">
					<a style="margin-top: 5px" class="btn btn-success" data-bind="page-href: {path: '/ipt', params: {vl: vl, h: h, date:'', is_new: true,houseNumber:houseNumber}}" > Create</a>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal AFS -->
<div id="afs" class="modal" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="vcenter">AFS</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<p>Date:</p>
				<div data-bind="foreach: AFSDates">
					<a class="btn btn-info" data-bind="text: afs_date, page-href: {path: '/afs', params: {vl: vl, h: h, date:afs_date, is_new: false,houseNumber:houseNumber}}"></a>
				</div>

				<div data-bind="with: AFSmaster">
					<a style="margin-top: 5px" class="btn btn-success" data-bind="page-href: {path: '/afs', params: {vl: vl, h: h, date:'', is_new: true,houseNumber:houseNumber}}" > Create</a>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Lastmile.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>