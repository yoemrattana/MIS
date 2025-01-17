<div data-bind="visible: view() == 'detail', with: detailModel" style="display:inline-block">
	<div class="text-center text-bold">Form: MMWs Contract</div>
	<br />
	<div class="kh">
		<div style="border:1px solid black; padding:20px">
			<b>ឈ្មោះ</b>
			<select data-bind="value: Title">
				<option value="Mr.">Mr.</option>
				<option value="Miss.">Miss.</option>
				<option value="Mrs.">Mrs.</option>
			</select>
			<input type="text" class="width150" data-bind="value: Name" />
			<b>ភេទ</b>
			<select data-bind="value: Sex">
				<option value=""></option>
				<option value="Male">ប្រុស</option>
				<option value="Female">ស្រី</option>
			</select>
			<b>អាយុ:</b>
			<input type="text" class="width100 numonly" data-type="int" data-bind="value: Age" maxlength="2" />
			<b>សញ្ជាត:</b>
			<input type="text" class="width150" data-bind="value: Nationality" />
			<br /><br />
			<b>អាសយដ្ឋានបច្ចុប្បន្ន: កន្លែងធ្វើការ/ភូមិ</b>
			<input type="text" class="width150" data-bind="value: Address" />
			<b>លេខទូរសព្ទ</b>
			<input type="text" class="width150 numonly" data-type="int" data-bind="value: Phone" />
			<br /><br />
			<b>ភូមិ</b>
			<input type="text" class="width150" data-bind="value: $root.getVillName(Village()), click: $parent.choosePlace" />
			<b>ឃុំ</b>
			<input type="text" class="width150" data-bind="value: $root.getCommName(Commune()), click: $parent.choosePlace" />
            <br /><br />
            <b>រយៈបណ្តោយ​​ (Longtitude)</b>
			<input type="text" class="width150 numonly" data-type="float" data-bind="value: Long" />
            <b>រយៈទទឹង (Latitude)</b>
			<input type="text" class="width150 numonly" data-type="float" data-bind="value: Lat" />
            <br /><br />
			<b>ស្រុក</b>
			<input type="text" class="width150" data-bind="value: $root.getDistName(District()), click: $parent.choosePlace" />
			<b>ខេត្ត</b>
			<input type="text" class="width150" data-bind="value: $root.getProvName(Province()), click: $parent.choosePlace" />
			<br /><br />
			<span>ខ្ញុំ</span>
			<input type="text" class="width150" data-bind="value: Name2" />
			<span>ត្រូវបានជាប់ឆ្នោតជា MMW សម្រាប់តំបន់ការងារ/ភូមិរបស់ខ្ញុំ</span>
			<br /><br />
			<span>ខ្ញុំនឹងគោរពតាមតួនាទីនិងការទទួលខុសត្រូវដែលបានកំណត់នៅក្នុងគម្រោង MMW ដើម្បីជួយដល់ CNM ដើម្បីកាត់បន្ថយអត្រាជំងឺនិងការស្លាប់នៃជំងឺគ្រុនចាញ់។</span>
			<br /><br />
			<span>ខ្ញុំមានកិត្តិយសដោយចូលរួមនិងកែលម្អសុខភាពសហគមន៍។ ខ្ញុំប្តេជ្ញាធ្វើការដោយមិនស្ទាក់ស្ទើរ</span>
			<br /><br />
			<div class="relative">
				<b>កាលបរិច្ឆេទ</b>
				<input type="text" class="text-center width100" data-bind="datePicker: Date, format: 'YYYY-MM-DD', dataType: 'string'" />
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Question21.js')?>