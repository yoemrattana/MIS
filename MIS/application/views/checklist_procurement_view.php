<style>
	.mg-left-1{margin-left: 37px}
	.mg-left-2{margin-left: 60px}
</style>
<div class="kh divcenter" data-bind="visible: view() == 'detail'">
	<h3 class="text-center">ការអភិបាលកម្មវីធីលទ្ធកម្មស្រុកប្រតិបត្តិ</h3>
	<br />

	<div class="form-inline" style="border:2px solid; padding:10px" data-bind="with: masterModel">
		<p>
			<span>ការចុះអភិបាលនៅ ខេត្ត</span>
			<select data-bind="value: Code_Prov_N,
					options: pvList,
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>

			<span class="space">ស្រុកប្រតិបត្តិ</span>
			<select data-bind="value: Code_OD_T,
					options: odList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>
		</p>
		<p class="relative en">
			<kh>ថ្ងៃចុះអភិបាល</kh>
			<input type="text" class="form-control width150 text-center" data-bind="datePicker: VisitDate, format: 'DD MMM YYYY'" placeholder="DD MMM YYYY" />

            <kh class="space">ត្រួតពិនិត្យពី</kh>
            <input type="text" class="form-control width100 text-center" data-bind="datePicker: CheckFrom, format: 'MMM YYYY'" placeholder="MMM YYYY" />

			<kh>ដល់</kh>
            <input type="text" class="form-control width100 text-center" data-bind="datePicker: CheckTo, minDate: CheckFrom() || undefined, format: 'MMM YYYY'" placeholder="MMM YYYY" />
		</p>
		<p>
			<span>ឈ្មោះអ្នកបំពេញទំរង់</span>
			<input type="text" class="form-control" data-bind="value: VisitorName" />

			<kh class="space">លេខបេសកកម្ម</kh>
			<input type="text" class="form-control en" min="0"
               oninput="this.value = this.value.replace(/[^0-9-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-bind="value: MissionNo" />
		</p>
		<p>
			<span>រយៈពេលពិនិត្យឯកសារត្រីមាសទី</span>
			<select class="form-control kh" data-bind="value: Quarter">
				<option></option>
				<option>Q1</option>
				<option>Q2</option>
				<option>Q3</option>
				<option>Q4</option>
			</select>
		</p>
		<p>
			<span>សមាសភាពចូលរួម</span>
			<table class="table table-bordered widthauto en font14">
				<thead>
					<tr>
						<th>Name</th>
						<th>Position</th>
						<th></th>
					</tr>
				</thead>
				<tbody data-bind="foreach: Participants">
					<tr>
						<td><input type="text" class="form-control" data-bind="value: name"/></td>
						<td><input type="text" class="form-control" data-bind="value: position"/></td>
						<td>
							<button class="btn btn-danger" data-bind="click: $root.deleteParticipant">
								<i class="fa fa-trash"></i>
							</button>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3">
							<button class="btn btn-success btn-sm" data-bind="click: $root.addParticipant">Add Participant</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</p>
	</div>
	<br />

	<div data-bind="with: detailModel">
		<!-- ko with: Q1 -->
		<p>
			<b>I. តើស្រុកប្រតិបត្តិបានធ្វើលទ្ធកម្មតាមផែនការដែរឬទេ?</b>
		</p>
		<p class="mg-left-1">
			<span>ផែនការប្រចាំត្រីមាស</span>
			<select class="form-control kh" data-bind="value: quarter_plan">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-1">
			<span>ផែនការប្រចាំឆមាស</span>
			<select class="form-control kh" data-bind="value: semester_plan">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<!-- /ko -->

		<!-- ko with: Q21 -->
		<p>
			<b>II. ការធ្វើលទ្ធកម្មតាមនិតិវិធីដូចខាងក្រោម៖</b>
		</p>
		<p class="mg-left-1">១.​ទម្រង់ស្នើសុំទិញ</p>
		<p class="mg-left-2">
			<span>ក.យោងតាមផែនការឬទេ?</span>
			<select class="form-control kh" data-bind="value: plan_reference">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>ខ.មានអ្នកអនុម័តឬទេ?</span>
			<select class="form-control kh" data-bind="value: approver">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<!-- /ko -->

		<!-- ko with: Q22 -->
		<p class="mg-left-1">២.តារាងស្រង់តម្លៃ</p>
		<p class="mg-left-2">
			<span>ក.សម្រង់តាមទូរសព្ទ័/ផ្ទាល់មាត់</span>
			<select class="form-control kh" data-bind="value: phone">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>ខ.តាមរយៈអ៊ីមែល/តេឡេក្រាម</span>
			<select class="form-control kh" data-bind="value: email">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>គ.ទៅហាង</span>
			<select class="form-control kh" data-bind="value: goshop">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>ង.អ្នកផ្គត់ផ្គង់យ៉ាងហោចណាស់03ហាង</span>
			<select class="form-control kh" data-bind="value: atleast3suplier">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<!-- /ko -->

		<!-- ko with: Q23 -->
		<p class="mg-left-1">៣.ប័ណ្ណបញ្ជាទិញ</p>
		<p class="mg-left-2">
			<span>ក.មានទម្រង់បញ្ជាទិញ</span>
			<select class="form-control kh" data-bind="value: quotation">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>ខ.មានអ្នកអនុម័តឬទេ?</span>
			<select class="form-control kh" data-bind="value: approver">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<!-- /ko -->
		<p class="mg-left-1">
			<span>៤.របាយការណ៍ទទួល</span>
			<select class="form-control kh" data-bind="value: Q24">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>

		<!-- ko with: Q25 -->
		<p class="mg-left-1">៥.ប័ណ្ណទូទាត់</p>
		<p class="mg-left-2">
			<span>ក.ទូទាត់មុនទទួលទំនិញ</span>
			<select class="form-control kh" data-bind="value: pre_payment">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>ខ.ទូទាត់ក្រោយទទួលទំនិញ</span>
			<select class="form-control kh" data-bind="value: post_payment">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>គ.ស្នើសុំថវិការមុន</span>
			<select class="form-control kh" data-bind="value: pre_badget">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>ង.មានវិក័យបត្រដែរឬទេ?</span>
			<select class="form-control kh" data-bind="value: invoice">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p class="mg-left-2">
			<span>បើគ្មានវិក័យបត្រមូលហេតុអ្វី?</span>
            <textarea type="text" rows="4" class="form-control"  data-bind="value: no_invoice_reason"> </textarea>
		</p>
		<!-- /ko -->
		<p>
			<b>III.បញ្ហា</b>
            <textarea type="text" rows="4" class="form-control"  data-bind="value: Problem"> </textarea>
		</p>
		<p>
			<b>IV.ដំណោះស្រាយ</b>
            <textarea type="text" rows="4" class="form-control"  data-bind="value: Solution"> </textarea>
		</p>
		<p>
			<b>V.សំណូមពរ</b>
            <textarea type="text" rows="4" class="form-control"  data-bind="value: Enquiry"> </textarea>
		</p>
	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_Procurement.js')?>