<style>
    body {
        background-color: #f3f1f196;
    }

    .card {
        box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
        border: 2px solid #01c0c8;
        background: #fff;
    }
    .btn-circle {
        border-radius: 100%;
        width: 25px;
        height: 25px;
        padding: 2px;
    }
    * {
		font-family: Content, sans-serif;
    }
    .table td, .table th {
        padding: 0.2rem;
        vertical-align: top;
        white-space: nowrap;
    }

    .table thead th {
        border-bottom: none;
        vertical-align: middle;
        text-align: center;
        height: 40px;
    }

    .table thead tr th {
        font-weight: bold;
    }

    .table tbody {
        font-weight: 500;
		text-align:center;
    }
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
</style>

<div data-bind="page: {id: 'start', title: 'Last Mile Data', scrollToTop: true, sourceCache: true}" style="display: none">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Last Mile Data</h4>
					<form>
						<div class="container9">
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: pv,
											options: pvList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: pvList().length == 1 ? undefined : 'Select Province'"
											class="form-control input-sm minwidth150"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: od,
											options: odList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: odList().length == 1 ? undefined : 'All OD'"
											class="form-control input-sm minwidth150"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: hc,
											options: hcList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'All HC'"
											class="form-control"></select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<select data-bind="value: vl,
											options: vlList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'All Villages'"
											class="form-control"></select>
									</div>
								</div>

								<div class="col-sm-4">
									<a href="/Home" class="btn btn-dark pull-right"><i class="fa fa-home"></i> Home</a>
									<a href="/Lastmile" class="btn btn-success pull-right" style="margin-right: 5px">
										<i class="fa fa-list"></i> Form
									</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- List -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-striped table-hover">
						<thead class="bg-info">
							<tr>
								<th width="40" align="center">#</th>
								<th align="center">Province</th>
								<th align="center">OD</th>
								<th align="center">HC</th>
								<th align="center">Village</th>
								<th align="center">House Number</th>
								<th align="center">HouseHolder</th>
								<th align="center">Action</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: dataList.slice(0, rowLimit()), fixedHeader: true">
							<tr>
								<td data-bind="text: $index() + 1" class="text-center"></td>
								<td data-bind="text: Name_Prov_E"></td>
								<td data-bind="text: Name_OD_E"></td>
								<td data-bind="text: Name_Facility_E"></td>
								<td data-bind="text: Name_Vill_E"></td>
								<td data-bind="text: HouseNumber"></td>
								<td data-bind="text: HouseHolder" class="kh"></td>

								<td align="center">
									<a class="btn btn-sm btn-success" data-bind="page-href: {path: '/detail', params: {house_id: Rec_ID}}"><i class="fa fa-list"></i> detail</a>
								</td>
							</tr>
						</tbody>
						<tfoot data-bind="visible: app.tableFooter($element)">
							<tr>
								<td class="text-center text-warning h4" style="padding:10px">No Data</td>
							</tr>
						</tfoot>
						<tfoot data-bind="visible: rowLimit() != null && dataList().length > rowLimit()">
							<tr>
								<td align="center" data-bind="attr: { colspan: $($element).closest('table').find('thead th').length }">
									<a class="btn btn-sm btn-primary" data-bind="click: () => rowLimit(rowLimit() + 200)">Display More Rows</a>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- tab -->
<div data-bind="page: {id: 'detail', title: 'Detail house hold', params: ['house_id'], scrollToTop: true, sourceCache: true}" style="display: none">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Detail</h4>
					<form>
						<div class="container9">
							<div class="row">
								<div class="col-sm-4">
									<div class="button-group">
										<a data-bind="page-href: 'house'" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">ជំរឿនខ្នងផ្ទះ</a>
										<a data-bind="page-href: 'tda'" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">TDA</a>
										<a data-bind="page-href: 'ipt'" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">IPT</a>
										<a data-bind="page-href: 'afs'" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">AFS</a>
									</div>
								</div>
								<div class="col-sm-8">
									<a href="#" class="btn btn-dark pull-right"> Back</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- house -->
	<div class="row" data-bind="page: {id: 'house', params:{'id': house_id}, title: 'ជំរឿនសមាជិកខ្នងផ្ទះ', scrollToTop: true,  withOnShow: loadHouse}" style="display: none">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">
						<kh>ផ្នែកទី១ ៖ ជំរឿនសមាជិកខ្នងផ្ទះ</kh>
					</h5>
					<hr />
					<table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow">
						<tbody>
							<tr class="tbl-title" style="height:26px">
								<th>
									ល.រខ្នងផ្ទះ
									<span data-bind="text: house.HouseNumber"></span>
								</th>
								<th>
									ឈ្មោះមេគ្រួសារ
									<span data-bind="text: house.HouseHolder"></span>
								</th>
								<th>
									លេខទូរស័ព្ទ
									<span data-bind="text: house.Phone"></span>
								</th>
								<th>
									Lat
									<span data-bind="text: house.Lat"></span>
								</th>
								<th>
									Long
									<span data-bind="text: house.Long"></span>
								</th>
							</tr>
						</tbody>
					</table>
					<br />
					<table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow">
						<thead>
							<tr class="tbl-title" style="height:26px">
								<th>ល.រ</th>
								<th>ឈ្មោះ</th>
								<th>អាយុ</th>
								<th>ភេទ</th>
								<th>អ្នកចូលព្រៃ</th>
								<th>ក្រុមគោលដៅTDA</th>
								<th>ក្រុមគោលដៅIPT</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: members">
							<tr>
								<td data-bind="text: $index() +1"></td>
								<td data-bind="text: Name"></td>
								<td data-bind="text: Age"></td>
								<td data-bind="text: Sex"></td>
								<td data-bind="text: ForestEntry"></td>
								<td data-bind="text: TDA"></td>
								<td data-bind="text: IPT"></td>
							</tr>
						</tbody>
					</table>
					<br />
					<table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow">
						<tbody data-bind="with: house">
							<tr class="tbl-title" style="height:26px">
								<th>
									ចំនួនសមាជិកសរុប 
									<span data-bind="text: TotalMember"></span>
								</th>
								<th>
									ចំនួន LLINs
									<span data-bind="text: LLIN"></span>
								</th>
								<th>
									ចំនួន LLINs ដែលខ្វះ
									<span data-bind="text: LLINLack"></span>
								</th>
							</tr>
							<tr class="tbl-title" style="height:26px">
								<th>
									ចំនួនអ្នកចូលព្រៃ
									<span data-bind="text: TotalForestEntry"></span>
								</th>
								<th>
									ចំនួន LLIHNs
									<span data-bind="text: LLIHN"></span>
								</th>
								<th>
									ចំនួន LLIHNs ដែលខ្វះ
									<span data-bind="text: LLIHNLack"></span>
								</th>
							</tr>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>

	<!-- tda -->
	<div class="row" data-bind="page: {id: 'tda', title: 'TDA', scrollToTop: true, withOnShow: loadTda}" style="display: none">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">TDA</h4>
					<h5 class="card-title">
						<kh>ផ្នែកទី២ ៖ អន្តរាគមន៍ផ្តោតគោលដៅលើមនុស្សនៅក្នុងផ្ទះដែលប្រឈមការប្រើប្រាស់ដោយផ្តោតគោលដៅជាក់លាក់ (TDA) លើក្រុមបុរសអាយុ 15-49 ឆ្នាំ</kh>
					</h5>
					<hr />
					<!-- tda 1 -->
					<table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow">
						<thead>
							<tr>
								<th></th>
								<th style="text-align: center" colspan="6">
									ការប្រើថ្នាំដោយផ្តោតលើគោលដៅជាក់លាក់ លើកទី 1
								</th>
							</tr>
							<tr>
								<th></th>
								<th>ហាមប្រើ</th>
								<th>បដិសេដ</th>
								<th>មូលហេតុបដិសេដ</th>
								<th>អវត្តមាន</th>
								<th>ផលរំខាន</th>
								<th> ថ្ងៃ TDA 1</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: tda1">
							<tr>
								<td style="text-align:center">
									<span data-bind="text: $index() + 1, css: {target: IsTDA == '1'}" class="target">1</span>
								</td>
								<td data-bind="text: DoNotUse"></td>
								<td data-bind="text: Reject"></td>
								<td data-bind="text: RejectReason"></td>
								<td data-bind="text: Absent"></td>
								<td data-bind="text: SideEffect"></td>
								<td data-bind="text: Date"></td>
							</tr>
						</tbody>
					</table>
					<br />
					<!-- tda 2-->
					<table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow">
						<thead>
							<tr>
								<th></th>
								<th style="text-align: center" colspan="6">
									ការប្រើថ្នាំដោយផ្តោតលើគោលដៅជាក់លាក់ លើកទី 2
								</th>
							</tr>
							<tr>
								<th></th>
								<th>ហាមប្រើ</th>
								<th>បដិសេដ</th>
								<th>មូលហេតុបដិសេដ</th>
								<th>អវត្តមាន</th>
								<th>ផលរំខាន</th>
								<th>ថ្ងៃ TDA 2</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: tda2">
							<tr>
								<td style="text-align:center">
									<span data-bind="text: $index() + 1, css: {target: IsTDA == '1'}" class="target">1</span>
								</td>
								<td data-bind="text: DoNotUse"></td>
								<td data-bind="text: Reject"></td>
								<td data-bind="text: RejectReason"></td>
								<td data-bind="text: Absent"></td>
								<td data-bind="text: SideEffect"></td>
								<td data-bind="text: Date"></td>
							</tr>
						</tbody>
					</table>

					<br />
					<h5 class="card-title">
						<kh>ពត័មានសង្ខេប​ - ត្រូវបំពេញនៅចុងបញ្ចប់</kh>
					</h5>
					<hr />
					<!-- net -->
					<table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow">
						<thead>
							<tr class="bg-primary">
								<th style="text-align: center; vertical-align:middle" rowspan="2">ល.រ​ ខ្នងផ្ទះ</th>
								<th style="text-align: center; vertical-align:middle" rowspan="2">ចំនួនសមាជិក</th>
								<th style="text-align: center" colspan="4">ការចែកបន្ថែម</th>
							</tr>
							<tr class="bg-info">
								<th>ចំនួន LLINs ដែលខ្វះ</th>
								<th>ចំនួន LLINs ដែលបានផ្តល់</th>
								<th>ចំនួន LLIHNs ដែលខ្វះ</th>
								<th>ចំនួន LLIHNs ដែលបានផ្តល់</th>
							</tr>
						</thead>
						<tbody data-bind="with: net">
							<tr>
								<td style="text-align:center" data-bind="text:HouseNumber"></td>
								<td data-bind="text: TotalMember"></td>
								<td data-bind="text: LLINLack"></td>
								<td data-bind="text: LLINOffer"></td>
								<td data-bind="text: LLIHNLack"></td>
								<td data-bind="text: LLIHNOffer"></td>
							</tr>
						</tbody>
					</table>
					<br />
					<!-- summary -->
					<table style="margin-bottom:0" class="table color-bordered-table info-bordered-table table-striped box-shadow">
						<thead>
							<tr class="bg-primary">
								<th style="text-align: center" colspan="5">ការប្រើឳសថដោយផ្តោតគោលដៅជាក់លាក់​ - TDA</th>
							</tr>
							<tr class="bg-info">
								<th>ក្រុមគោលដៅ TDA</th>
								<th>
									បដិសេដ TDA 1
								</th>
								<th>
									បានផ្តល់ TDA 1
								</th>
								<th>
									បដិសេដ TDA 2
								</th>
								<th>
									បានផ្តល់ TDA 2
								</th>
							</tr>
						</thead>
						<tbody data-bind="with: summary">
							<tr>
								<td data-bind="text: TotalTDA"></td>
								<td data-bind="text: RejectTDA1"></td>
								<td data-bind="text: TDA1"></td>
								<td data-bind="text: RejectTDA2"></td>
								<td data-bind="text: TDA2"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- ipt -->
	<div class="row" data-bind="page: {id: 'ipt', title: 'IPT', scrollToTop: true, withOnShow: loadIpt}" style="display: none">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">TDA</h4>
					<h5 class="card-title">
						<kh>ផ្នែកទី៣៖ ការផ្តល់ថ្នាំការពារជាមុន IPT សម្រាប់អ្នកចូលព្រៃ</kh>
					</h5>
					<hr />
					<!-- iptf and afs -->
					<!-- ko foreach: ipts -->
					
					<p data-bind="text: $data[0].IPTDate"></p>
					
					<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
						<thead>
							<tr>
								<th rowspan="2" style="text-align:center; vertical-align: middle">លរ</th>
								<td class="bg-primary" colspan="6" style="text-align:center">IPTf</td>
								
							</tr>
							<tr class="bg-info">
								<th>ហាមប្រើ</th>
								<th>បដិសេដ</th>
								<th width="10">មូលហេតុបដិសេដ</th>
								<th>អវត្តមាន</th>
								<th>មិនចូលព្រៃ</th>
								<th width="109">ថ្ងៃទី</th>

							</tr>
						</thead>
						<tbody data-bind="foreach: $data">
							<tr>
								<td style="text-align:center"><span data-bind="text: $index() + 1, css: {target: IsIPT == '1'}"></span></td>
								<td data-bind="text: DoNotUse"></td>
								<td data-bind="text: Reject"></td>

								<td data-bind="text: RefuseReason"></td>
								<td data-bind="text: Absent"></td>
								<td data-bind="text: NotEnterForest"></td>

								<td data-bind="text: $root.formatDate(Date)"></td>
								
							</tr>
						</tbody>
					</table>
					<!-- /ko -->
				</div>
			</div>
		</div>
	</div>

	<!-- afs -->
	<div class="row" data-bind="page: {id: 'afs', title: 'AFS', scrollToTop: true, withOnShow: loadAfs}" style="display: none">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">AFS</h4>
					<h5 class="card-title">
						<kh>ផ្នែកទី៤៖ AFS</kh>
					</h5>
					<hr />
					<!-- afs -->
					<!-- ko foreach: afses -->

					<p data-bind="text: $data[0].AFSDate"></p>

					<table class="tablesaw no-wrap table-bordered table-hover table tablesaw-swipe">
						<thead>
							<tr>
								<th rowspan="2" style="text-align:center; vertical-align: middle">លរ</th>
								<td class="bg-success" colspan="8" style="text-align:center">AFS</td>
							</tr>
							<tr class="bg-info">
								<th>W1</th>
								<th>W1 Specie</th>
								<th>W2</th>
								<th>W2 Specie</th>
								<th>W3</th>
								<th>W3 Specie</th>
								<th>W4</th>
								<th>W4 Specie</th>
							</tr>
						</thead>
						<tbody data-bind="foreach: $data">
							<tr>
								<td style="text-align:center">
									<span data-bind="text: $index() + 1"></span>
								</td>
								<td data-bind="text: W1"></td>
								<td data-bind="text: W1Specie"></td>
								<td data-bind="text: W2"></td>
								<td data-bind="text: W2Specie"></td>
								<td data-bind="text: W3"></td>
								<td data-bind="text: W3Specie"></td>
								<td data-bind="text: W4"></td>
								<td data-bind="text: W4Specie"></td>
							</tr>
						</tbody>
					</table>
					<!-- /ko -->
				</div>
			</div>
		</div>
	</div>

</div>


<?=latestJs('/media/ViewModel/LastmileData.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>