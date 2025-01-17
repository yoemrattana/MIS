<div class="panel-body" data-bind="visible: view() == 'detail'">
	<h3 class="kh text-center">
		បញ្ជីផ្ទៀងផ្ទាត់ការធានាគុណភាពសេវាអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់
	</h3>
	<br />
	<div class="container font16">
		<div class="box form-group" data-bind="with: masterModel">
			<p class="form-inline">
				<kh>ខេត្ត</kh>
				<select class="form-control blue" data-bind="value: Code_Prov_N, options: pvList, optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				<kh class="space">ស្រុកប្រតិបត្តិ</kh>
				<select class="form-control blue minwidth100" data-bind="value: Code_OD_T, options: odList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				<kh class="space">មណ្ឌលសុខភាព</kh>
				<select class="form-control blue minwidth100" data-bind="value: Code_Facility_T, options: hcList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
				<kh class="space">ភូមិ</kh>
				<select class="form-control blue minwidth100" data-bind="value: Code_Vill_T, options: vlList(), optionsValue: 'code', optionsText: 'name', optionsCaption: ''"></select>
			</p>
			<p class="form-inline">
				<kh>ឈ្មោះអ្នកស្ម័គ្រចិត្តភូមិ</kh>
				<input type="text" class="form-control blue" data-bind="value: VMWName" />
			</p>
			<p class="form-inline relative">
				<kh>កាលបរិច្ឆេទអភិបាល</kh>
				<input type="text" class="form-control width150 blue text-center" data-bind="datePicker: VisitDate, dataType: 'string'" />
			</p>
			<p class="form-inline">
				<kh>ឈ្មោះអ្នកបំពេញទំរង់អភិបាល</kh>
				<input type="text" class="form-control blue" data-bind="value: VisitorName" />
				<kh class="space">តួនាទី</kh>
				<input type="text" class="form-control blue" data-bind="value: Position" />
			</p>
			<p class="form-inline">
				<kh>ទីកន្លែងធ្វើការ</kh>
				<label class="radio-inline radio-lg space">
					<input type="radio" name="WorkPlace" value="CNM" data-bind="checked: WorkPlace" />
					<kh>ម.គ.ច</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="WorkPlace" value="PHD" data-bind="checked: WorkPlace" />
					<kh>មន្ទីរសុខាភិបាលខេត្ត</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="WorkPlace" value="OD" data-bind="checked: WorkPlace" />
					<kh>ស្រុកប្រតិបត្តិ</kh>
				</label>
				<label class="radio-inline radio-lg">
					<input type="radio" name="WorkPlace" value="HC" data-bind="checked: WorkPlace" />
					<kh>មណ្ឌលសុខភាព</kh>
				</label>
			</p>
		</div>

		<?php $this->load->view('vmwqa_form1_view'); ?>
		<?php $this->load->view('vmwqa_form2_view'); ?>
	</div>
</div>