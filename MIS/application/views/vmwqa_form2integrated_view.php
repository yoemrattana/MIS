<!-- ko if: masterModel() != null && masterModel().FormType() == 'Integrated' -->
<div data-bind="with: detailIntegrated">
    <table class="table table-bordered">
	    <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ២៖ ការធ្វើតេស្ត និងរោគសញ្ញាជំងឺគ្រុនចាញ់</th>
	    </tr>
        <tr class="kh">
            <th align="center">ល.រ</th>
            <th align="center">សំនួរ</th>
            <th align="center">ចំលើយ</th>
            <th align="center">ពិន្ទុសរុប</th>
            <th align="center">ពិន្ទុ</th>
        </tr>
	    <tr>
		    <td align="center">1</td>
		    <th colspan="2" class="kh">សាកសួរព័ត៌មានរបស់អ្នកជំងឺ (តើព័ត៌មានអ្វីខ្លះដែល VMW សួរទៅអ្នកជំងឺ?)</th>
		    <td align="center" valign="middle" class="pink">2</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">1.1</td>
		    <td class="kh">ឈ្មោះ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="1.1" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="1.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">1.2</td>
		    <td class="kh">អាយុ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="1.2" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="1.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">1.3</td>
		    <td class="kh">ទីលំនៅអចិន្ត្រៃយ៍ (រស់នៅក្នុងភូមិ VMW)</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="1.3" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="1.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">1.4</td>
		    <td class="kh">ស្ត្រីមានផ្ទៃពោះ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="1.4" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="1.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">2</td>
		    <td class="kh">
			    សាកសួរប្រវត្តិអ្នកជំងឺ
			    <br />
			    (ការធ្វើដំណើរទៅកាន់ព្រៃក្នុងរយៈពេល ១ខែមុន)
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">3</td>
		    <td class="kh">
			    រៀបរាប់សញ្ញាណ និងរោគសញ្ញាគ្រោះថ្នាក់
			    <br /><br />
			    <b><i>គូសចំលើយច្រើនបំផុត ៣</i></b>
		    </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="3" value="Loss of consciousness/coma" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាត់បង់ស្មារតី/សន្លប់</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="3" value="Little urine" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទឹកនោមតិច</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="3" value="Convulsion" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ប្រកាច់</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="3" value="Unable to sit/eat/drink" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. មិនអាចអង្គុយ/ញ៉ាំអាហារ/ផឹក</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="3" value="Frequent vomiting" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. ក្អួតញឹកញាប់</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="3" value="Jaundice or very pale" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. ជំងខាន់លឿង ឬស្លេកស្លាំង</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="3" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>7. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">3</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">4</td>
		    <td class="kh">
			    រៀបរាប់សញ្ញាណ និងរោគសញ្ញាកំរិតស្រាល
			    <br /><br />
			    <b><i>គូសចំលើយច្រើនបំផុត ៣</i></b>
		    </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="4" value="Fever" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ក្តៅខ្លួន</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="4" value="Headache" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ឈឺក្បាល</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="4" value="Chills" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. រងារ/ញាក់</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="4" value="Nausea" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. ចង្អោរ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="4" value="Vomiting" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. ក្អួត</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="4" value="Sweating" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. បែកញើស</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="4" value="Diarrhea" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>7. រាគ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="4" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>8. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">3</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td colspan="5" class="kh">
			    <i>កំណត់ចំណាំ៖ ចំពោះសំណួរទី 6 និង 7 អានសំណួរឲ្យ VMW ដោយផ្ទាល់ ប៉ុន្តែមិនត្រូវអានចំលើយនោះទេ។</i>
		    </td>
	    </tr>
	    <tr>
		    <td align="center">5</td>
		    <th colspan="2" class="kh">ក្នុងករណីណាខ្លះដែលអ្នកត្រូវបញ្ជូនអ្នកជំងឺ?</th>
		    <td align="center" valign="middle" class="pink">6</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">5.1</td>
		    <td class="kh">ស្ត្រីមានផ្ទៃពោះក្នុងត្រីមាសទី១</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.1" value="Yes" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">5.2</td>
		    <td class="kh">សង្ស័យបរាជ័យក្នុងការព្យាលបាលជំងឺគ្រុនចាញ់</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.2" value="Yes" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">5.3</td>
		    <td class="kh">មានសញ្ញា និងរោគសញ្ញាធ្ងន់ធ្ងរ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.3" value="Yes" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">5.4</td>
		    <td class="kh">បើដាច់ស្តុកតេស្តរហ័ស(RDT)</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.4" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">5.5</td>
		    <td class="kh">បើដាច់ស្តុកឱសថគ្រុនចាញ់(ACT)</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.5" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">5.6</td>
		    <td class="kh">ករណីគ្រុនចាញ់អវិជ្ជមានប៉ុន្តែមានរោគសញ្ញានៃជំងឺផ្សេងៗ (ក្តៅខ្លួន/ក្អួត/រាគ)</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.6" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="5.6" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">6</td>
		    <td class="kh">
			    តើអ្នកត្រូវបញ្ជូនអ្នកជំងឺទៅកន្លែងណា?
			    <br /><br />
			    <b>
                    <i>ចំលើយអាចជ្រើសរើសលើសពី១</i>
                </b>
		    </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="6" value="Health Center" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. មណ្ឌលសុខភាព</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="6" value="Referral Hospital" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. មន្ទីរពេទ្យបង្អែក</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="6" value="Other" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ផ្សេងៗ (ឳសថស្ថាន ឬក្លីនិចផ្សេងៗ)</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">7</td>
		    <td class="kh">នៅពេលអ្នកសង្ស័យថាអ្នកជំងឺមានជំងឺគ្រុនចាញ់ តើអ្នកធ្វើអ្វី?</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="7" value="Conduct blood test (RDT)" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ធ្វើតេស្តឈាម (ឧ. RDT)</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="7" value="Presumptive treatment" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ផ្តល់ការព្យាបាលដោយគ្មានការធ្វើតេស្តផ្សេងៗ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8</td>
		    <th colspan="2" class="kh">១៤ ជំហាននៃការធ្វើតេស្តរហ័ស(RDT) (ការដាក់ពិន្ទុដោយផ្អែកលើការសាកល្បងនៃការធ្វើតេស្ត)</th>
		    <td align="center" valign="middle" class="pink">24</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.1</td>
		    <td class="kh">ពិនិត្យកាលបរិច្ឆេទផុតកំណត់នៅលើកញ្ចប់តេស្ត</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.1" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.2</td>
		    <td class="kh">ពាក់ស្រោមដៃថ្មី (ប្រសិនបើគ្មានស្រោមដៃ គឺតំរូវអោយពួកគាត់និយាយផ្ទាល់មាត់)</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.2" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.3</td>
		    <td class="kh">
			    ហែកកញ្ចប់តេស្ត និងពិនិត្យសារធាតុសម្ងួត
			    <br />
			    (ប្រសិនបើសារធាតុសម្ងួតមិនមែនព៌ណស ត្រូវចាត់ទុកថាហួសថ្ងៃផុតកំណត់)
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.3" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.4</td>
		    <td class="kh">សរសេរឈ្មោះអ្នកជំងឺ និងកាលបរិច្ឆេទ ភេទ អាយុ លើបន្ទះខ្នងតេស្ត</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.4" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.5</td>
		    <td class="kh">
			    សំអាតម្រាមដៃដែលត្រូវជោះឈាមជាមួយសំឡីអាល់កុលអោយស្អាត
			    <br />
			    រួចទុកអោយស្ងួតមុនពេលជោះឈាម
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.5" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.6</td>
		    <td class="kh">មួលផ្តាច់ក្បាលម្ជុលជោះឈាម រួចជោះម្រាមដៃអ្នកជំងឺដើម្បីយកឈាម</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.6" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.6" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.7</td>
		    <td class="kh">ចោលម្ជុលជោះឈាមក្នុងប្រអប់សុវត្ថិភាពភ្លាមបនា្ទប់ពីជោះឈាមអ្នកជំងឺរួច</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.7" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.7" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.8</td>
		    <td class="kh">ផ្តិតយកឈាមដោយប្រើចុងបំពង់យកឈាមមាត់ឈ្លើង</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.8" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.8" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.9</td>
		    <td class="kh">ដាក់ឈាមក្នុងចង្អូរមូលតូច រួចចោលបំពង់យកឈាមទៅក្នុងប្រអប់សុវត្ថិភាពភ្លាម</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.9" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.9" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.10</td>
		    <td class="kh">បន្តក់ទឹកប្រតិករ៤តំណក់ទៅក្នុងចង្អូរបួនជ្រុង</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.10" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.10" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.11</td>
		    <td class="kh">
			    រង់ចាំរយៈពេល១៥នាទីមុនពេលអានលទ្ធផលតេស្ត
			    <br />
			    (ទោះបីជាលទ្ធផលនោះអាចអានបានមុន ១៥នាទីក៏ដោយ) រួចបកស្រាយលទ្ធផលតេស្តបានត្រឹមត្រូវ
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.11" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.11" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.12</td>
		    <td class="kh">កត់ត្រាលទ្ធផលនៅពីក្រោយខ្នងតេស្ត</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.12" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.12" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">8.13</td>
		    <td class="kh">កត់ត្រាលទ្ធផលតេស្តនៅក្នុងសៀវភៅកត់ត្រាករណីជំងឺគ្រុនចាញ់ប្រចាំខែ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.13" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="8.13" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>

        <tr>
            <td align="center">8.14</td>
            <td class="kh"> បញ្ចូលទិន្នន័យគ្រុនចាញ់ក្នុងប្រព័ន្ធទូរស័ព្ទ</td>
            <td class="kh">
                <div class="radio radio-lg">
                    <label>
                        <input type="radio" name="8.14" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
                        <span>1. បាទ/ចាស៎</span>
                    </label>
                </div>
                <div class="radio radio-lg">
                    <label>
                        <input type="radio" name="8.14" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
                        <span>2. ទេ</span>
                    </label>
                </div>
            </td>
            <td align="center" valign="middle">2</td>
            <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
        </tr>

	    <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ៣៖ ការព្យាបាល</th>
	    </tr>
	    <tr>
		    <td colspan="5" class="kh">
			    <i>កំណត់ចំណាំ៖ ចំពោះសំណួរទី 11​ និង14 អានសំណួរឲ្យ VMW ដោយផ្ទាល់ ប៉ុន្តែមិនត្រូវអានចំលើយនោះទេ។</i>
		    </td>
	    </tr>
	    <tr>
		    <td align="center">9</td>
		    <td class="kh">តើថ្នាំប្រភេទអ្វីដែលអ្នកបានផ្តល់ទៅឲ្យអ្នកជំងឺ ដែលមានលទ្ធផលតេស្តជំងឺគ្រុនចាញ់វិជ្ជមាន?</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="9" value="ACT or ACT+PQ" score="3" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ACT ឬ ACT+ Primaquine</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="9" value="Any other drug" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ថ្នាំផ្សេងៗទៀត</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">3</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">10</td>
		    <td class="kh">
			    តាមរយៈចំណេះដឹងរបស់អ្នក តើអ្នកកំណត់កម្រិតនៃឱសថយ៉ាងដូចម្តេចចំពោះអ្នកជំងឺ
			    <br />
			    ដែលមានលទ្ធផលតេស្តជំងឺគ្រុនចាញ់វិជ្ជមាន?
		    </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="10" value="Weight" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. កំណត់តាមទំងន់អ្នកជំងឺ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="10" value="Age" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. កំណត់តាមអាយុអ្នកជំងឺ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="10" value="Other" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ផ្សេងៗ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">11</td>
		    <th colspan="2" class="kh">
			    តើកម្រិតថ្នាំព្យាបាលមួយណាដែលអ្នកផ្តល់ ទៅតាមក្រុមទម្ងន់ខាងក្រោម
			    <i>(ត្រូវតែធ្វើការឆ្លើយគ្រប់ផ្នែកនៃសំនួរអោយបានត្រឹមត្រូវដើម្បីទទួលបានពិន្ទុ)</i>
		    </th>
		    <td align="center" valign="middle" class="pink">5</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">11.1</td>
		    <td class="kh">
			    ៥-៨ គីឡូ៖ សរុប ៣គ្រាប់តូចនៃ ASMQ (១គ្រាប់តូច ២៥/៥០mg),
			    ១ គ្រាប់តូចក្នុង១ថ្ងៃ សម្រាប់រយៈពេល ៣ថ្ងៃ
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">11.2</td>
		    <td class="kh">
			    ៩-១៧ គីឡូ៖ សរុប 6 គ្រាប់តូចនៃ ASMQ (១គ្រាប់តូច ២៥/៥០mg),
			    ២គ្រាប់តូចក្នុង១ថ្ងៃ សម្រាប់រយៈពេល ៣ថ្ងៃ
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">11.3</td>
		    <td class="kh">
			    ១៨-២៩ គីឡូ៖ សរុប ៣ គ្រាប់នៃ ASMQ (១គ្រាប់ ១០០/២០០mg),
			    ១គ្រាប់ក្នុង១ថ្ងៃ សម្រាប់រយៈពេល ៣ថ្ងៃ
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.3" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">11.4</td>
		    <td class="kh">
			    ≥៣០ គីឡូ៖ សរុប ៦គ្រាប់នៃ ASMQ (១គ្រាប់ ១០០/២០០mg),២គ្រាប់ក្នុង១ថ្ងៃ
            <br />សម្រាប់រយៈពេល ៣ថ្ងៃ
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.4" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">11.5</td>
		    <td class="kh">
			    ២០ ដល់ ៤៩ គីឡូ សម្រាប់ករណី ហ្វាល់ស៊ីប៉ារ៉ូម(Pf) ឬ ចំរុះ(Mix):
			    <br />
			    ផ្តល់ថ្នាំ ASMQ (១០០/២០០mg) តាមមគ្គុទ្ទេសក៏ព្យាបាល និងបន្ថែមថ្នាំព្រីម៉ាគីន
			    <br />
			    កម្រិតទាប (៧.៥mg) ១គ្រាប់ តែមួយពេលគត់ នៅថ្ងៃដំបូងនៃការព្យាបាល
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.5" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">11.6</td>
		    <td class="kh">
			    ≥ ៥០គីឡូ សម្រាប់ករណី ហ្វាល់ស៊ីប៉ារ៉ូម(Pf) ឬ ករណីចំរុះ(Mix):
			    <br />
			    សរុប ៦គ្រាប់នៃ ASMQ(១គ្រាប់ ១០០/២០០mg), ២គ្រាប់ក្នុង១ថ្ងៃ
			    <br />
			    សម្រាប់រយៈពេល៣ថ្ងៃ និងបន្ថែមជាមួយថ្នាំពី្រម៉ាគីន ក្រមិតទាប (៧.៥mg)
			    <br />
			    ២គ្រាប់ តែមួយពេលគត់នៅថ្ងៃដំបូងនៃការព្យាបាល
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.6" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="11.6" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">12</td>
		    <th colspan="2" class="kh">
			    តើអ្នកធ្វើអ្វីខ្លះ ប្រសិនបើអ្នកជំងឺមានក្អួត ក្រោយពេលមានលេបថ្នាំ?​​
		    </th>
		    <td align="center" valign="middle" class="pink">2</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">12.1</td>
		    <td class="kh">ចន្លោះពី ០-៣០ នាទី៖  ព្យាបាលឡើងវិញ ត្រូវលេប១ដូសឡើងវិញ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="12.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="12.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">12.2</td>
		    <td class="kh">ចន្លោះពី ៣០-៦០ នាទី៖ ព្យាបាលឡើងវិញ ត្រូវលេបពាក់កណ្តាលដូសឡើងវិញ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="12.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="12.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
				
	    <tr>
		    <td align="center">13</td>
		    <td colspan="2" class="kh">
			    <b>
				    ហេតុអ្វីបានជា ការព្យាបាលដោយការសង្កេតដោយផ្ទាល់ (DOT) នៃ ថ្នាំព្យាបាលគ្រុនចាញ់
                    (ACT) មានសារៈសំខាន់សំរាប់អ្នកជំងឺដែលបានធ្វើតេស្តវិជ្ជមាន?
			    </b>
                <br />
			    <i>
				    (គូស "បាទ/ចាស៎" ប្រសិនបើបានឆ្លើយនូវចំលើយនីមួយៗខាងក្រោម 
                    និង គូស "ទេ" ប្រសិនបើមិនបានឆ្លើយនូវ ចំលើយនីមួយៗខាងក្រោម)
			    </i>
		    </td>
		    <td align="center" valign="middle" class="pink">1.5</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">13.1</td>
		    <td class="kh">កាត់បន្ថយការព្យាបាលបរាជ័យ និងការលាប់</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="13.1" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="13.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">13.2</td>
		    <td class="kh">
			    កាត់បន្ថយភាពស៊ាំនឹងថ្នាំ ដែលជាវិបាកនៃការព្យាបាលដែលមិនប្រក្រតី
			    ឬមិនពេញលេញ
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="13.2" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="13.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">13.3</td>
		    <td class="kh">
			    ទប់ស្កាត់ការរីករាលដាលនៃភាពស៊ាំនឹងថ្នាំនៅក្នុងសហគមន៍
			    និងតំបន់ដទៃផ្សេងៗទៀត
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="13.3" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="13.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ៤៖ ការធ្វើរបាយការណ៍ និងឯកសារ</th>
	    </tr>
	    <tr>
		    <td colspan="5" class="kh">
			    <i>កំណត់ចំណាំ៖ ចំពោះផ្នែកទី ៤ សូមពិនិត្យដោយផ្ទាល់ រួចបំពេញចំលើយដូចខាងក្រោម</i>
		    </td>
	    </tr>
	    <tr>
		    <td align="center">14</td>
		    <th colspan="2" class="kh">តើសំភារៈទាំងនេះមាននៅផ្ទះរបស់អ្នកស្ម័គ្រចិត្តភូមិព្យាលបាលជំងឺគ្រុនចាញ់ទេ?</th>
		    <td align="center" valign="middle" class="pink">3</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
				
	    <tr>
		    <td align="center">14.1</td>
		    <td class="kh">សៀវភៅកត់ត្រាករណីជំងឺគ្រុនចាញ់ប្រចាំខែ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="14.1" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="14.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">14.2</td>
		    <td class="kh">ទម្រង់បញ្ចូនអ្នកជំងឺគ្រុនចាញ់</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="14.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="14.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>

	    <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ៥៖ ការវាយតំលៃទៅលើកន្លែងធ្វើការ</th>
	    </tr>
	    <tr>
		    <td align="center">15</td>
		    <th colspan="2" class="kh">ការអង្កេតដោយអ្នកអភិបាល</th>
		    <td align="center" valign="middle" class="pink">8</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	   
	    <tr>
		    <td align="center">15.1</td>
		    <td class="kh">វត្តមាននៃ ស្រោមដៃ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.1" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">15.2</td>
		    <td class="kh">
			    វត្តមាននៃ សំភារៈអប់រំគ្រុនចាញ់
			    <br />
			    (វត្តមាននៃ សំភារៈជំនួយ(Job Aids) នៅពេលអនុវត្តតេស្តរហ័ស)
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.2" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">15.3</td>
		    <td class="kh">
			    នាឡិកាកំណត់ពេលវេលាដែលនៅមានដំណើរការ
			    <br />
			    (នាឡិកាប៉ោ នាឡិកាដៃ រឺ ទូរស័ព្ទដៃ)
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.3" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.3" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">15.4</td>
		    <td class="kh">
			    ជញ្ជីងសំរាប់ថ្លឹងអ្នកជំងឺដែលដំណើរការល្អ
			    <br />
			    (ថ្លឹងខ្លួនឯងសិនដើម្បីបញ្ជាក់ថាជញ្ជីងត្រឹមត្រូវ)
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.4" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">15.5</td>
		    <td class="kh">ប្រដាប់វាស់ស្ទង់កំដៅអ្នកជំងឺដែលដំណើរការ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.5" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.5" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">15.6</td>
		    <td class="kh">ឱសថគ្រុនចាញ់(ACT) មានដាក់នៅកន្លែងស្ងួត និងមិនចំពន្លឺព្រះអាទិត្យ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.6" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.6" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">15.7</td>
		    <td class="kh">តេស្តរហ័ស(RDT) មានដាក់នៅកន្លែងស្ងួត និងមិនចំពន្លឺព្រះអាទិត្យ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.7" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.7" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">15.8</td>
		    <td class="kh">វត្តមាននៃប្រអប់សុវត្ថិភាព</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.8" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="15.8" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">16</td>
		    <th colspan="2" class="kh">អ្នកអភិបាលត្រួតពិនិត្យស្តុកថ្នាំ និងតេស្តរហ័ស</th>
		    <td align="center" valign="middle" class="pink">9</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	   <tr>
		    <td align="center">16.1</td>
		    <td class="kh">ចំនួនឱសថគ្រុនចាញ់(ACT) និងឱសថព្រីម៉ាគីនមាននៅក្នុងស្តុកក្នុងថ្ងៃដែលចុះមកពិនិត្យ</td>
		    <td class="form-inline">
				<p>
					<kh>ឱសថគ្រុនចាញ់ (ACT):</kh>
					<input type="text" name="16.1.1" data-bind="value: $root.getAnswer($element)" class="form-control text-center width100" />
				</p>
                <p>
					<kh>ឱសថព្រីម៉ាគីន:</kh>
					<input type="text" name="16.1.2" data-bind="value: $root.getAnswer($element)" class="form-control text-center width100" />
				</p>
		    </td>
		    <td class="pink"></td>
		    <td class="pink"></td>
	    </tr>
	    <tr>
		    <td align="center">16.2</td>
		    <td class="kh">ឱសថគ្រុនចាញ់(ACT) ហួសកំណត់កាលបរិច្ឆេទប្រើក្នុងថ្ងៃដែលចុះមកពិនិត្យ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="16.2" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
                        <input type="radio" name="16.2" value="No" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">16.3</td>
		    <td class="kh">ឱសថគ្រុនចាញ់(ACT) ដាច់ស្តុកក្នុងរយៈពេលលើសពីមួយសប្តាហ៍ក្នុងមួយខែកន្លងមក</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="16.3" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
                        <input type="radio" name="16.3" value="No" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">16.4</td>
		    <td class="kh">ស្នើសុំស្តុកឱសថគ្រុនចាញ់(ACT) បន្ទាន់ក្នុងករណីដាច់ស្តុក</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="16.4" value="Yes" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="16.4" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">16.5</td>
		    <td class="kh">ចំនួនតេស្តរហ័ស(RDT) មាននៅក្នុងស្តុកក្នុងថ្ងៃដែលចុះមកពិនិត្យ</td>
		    <td>
			    <input type="text" name="16.5" data-bind="value: $root.getAnswer($element)" class="form-control text-center width100" />
		    </td>
		    <td class="pink"></td>
		    <td class="pink"></td>
	    </tr>
	    <tr>
		    <td align="center">16.6</td>
		    <td class="kh">តេស្តរហ័ស(RDT) ហួសកំណត់កាលបរិច្ឆេទប្រើក្នុងថ្ងៃដែលចុះមកពិនិត្យ</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="16.6" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
                        <input type="radio" name="16.6" value="No" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">16.7</td>
		    <td class="kh">តេស្តរហ័ស(RDT) ដាច់ស្តុកក្នុងរយៈពេលលើសពីមួយសប្តាហ៍ក្នុងមួយខែកន្លងមក</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="16.7" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
                        <input type="radio" name="16.7" value="No" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">16.8</td>
		    <td class="kh">ស្នើសុំស្តុកតេស្តរហ័ស(RDT) បន្ទាន់ក្នុងករណីដាច់ស្តុក</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="16.8" value="Yes" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="16.8" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ៦៖ ការគ្រប់គ្រងកាកសំណល់</th>
	    </tr>
	    <tr>
		    <td align="center">17</td>
		    <td colspan="2" class="kh">អ្នកអភិបាលធ្វើការអង្គេត</td>
		    <td align="center" valign="middle" class="pink">4</td>
		    <td align="center" valign="middle" class="pink" data-bind="text: $root.getGroupScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">17.1</td>
		    <td class="kh">តើមានការបែងចែកសំរាមត្រឹមត្រូវដែរឬទេ?</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="17.1" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="17.1" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">17.2</td>
		    <td class="kh">
			    តើអ្នកស្ម័គ្រចិត្តដឹងថាត្រូវចោលកាក់សំណល់វេជ្ជសាស្ត្រនៅកន្លែងណា?
			    <br />
			    (គូស "បាទ/ចាស៎" ប្រសិនបើអ្នកស្ម័គ្រចិត្តលើកឡើងកន្លែងផ្តល់សេវាសុខភាពសាធារណៈ
			    <br />
			    និង គូស "ទេ" បើបានលើកឡើងកន្លែងផ្សេងទៀត)
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="17.2" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="17.2" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ៧៖ ការពិនិត្យលើការអប់រំសុខភាព</th>
	    </tr>
	    <tr>
		    <td align="center">18</td>
		    <td class="kh">
			    តើអ្នកស្ម័គ្រចិត្តបានរៀបចំសកម្មភាពអប់រំសុខភាពជំងឺគ្រុនចាញ់
			    <br />
			    កាលពីខែមុននៅក្នុងសហគមន៍គាត់ដែរឬទេ?
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="18" value="Yes" score="2" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="18" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">2</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">19</td>
		    <td class="kh">
			    តើសារគន្លឹះយ៉ាងហោចណាស់ចំនួន៣អ្វីខ្លះដែលជាវិធានការ
			    <br />
			    ការពារជំងឹគ្រុនចាញ់ដែលអ្នកអាចផ្តល់ទៅអោយសហគមន៍របស់អ្នក?
			    <br />
			    <br />
			    <b><i>គូសចំលើយច្រើនបំផុត ៣</i></b>
		    </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="19" value="Sleep under a bednet every night" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. គេងនៅក្នុងមុងគ្រប់ពេលវេលា</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="19" value="Wear long sleeved clothes especially at night and in the forest" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ស្លៀកពាក់ខោអាវវែង ជាពិសេសពេលល្ងាច និងនៅក្នុងព្រៃ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="19"  value="Use mosquito repellent on exposed skin" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. លាបថ្នាំបណ្តេញមូស</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="19" value="Light a campfire in the forest to deter mosquitos" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. ដុតភ្នក់ភ្លើងនៅពេលស្ថិតក្នុងព្រៃដើម្បីរារាំងមូស</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="19" value="Plant holy basil around your home" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. ដាំម្រះព្រៅនៅជុំវិញផ្ទះ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="19" value="Clear excess vegetation from around your home" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. សំអាតព្រៃកន្ទ្រប់ជុំវិញផ្ទះ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="19" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>7. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">3</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>

        <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ៨៖ ការតាមដានការព្យាបាលផ្តាច់វីវ៉ាក់ឬចម្រុះ</th>
	    </tr>
	    <tr>
		    <td align="center">20</td>
		    <td class="kh">
			    តើរយៈពេល៣ខែចុងក្រោយមានករណីវីវ់ាក់ ឬចម្រុះដែលត្រូវលក្ខខ័ណ្ឌបានធ្វើការតាមដានការព្យាបាលផ្តាច់ដែរឬទេ?
                <br/>
                <br/>
                <b>
                    <i>(ចម្លើយបាទ/ចាស មិនបានពិន្ទុ លុះត្រាគាត់បានតាមដានករណីព្យាបាលផ្តាច់នោះទើបបានពិទ្ទុនៅសំណួរបន្ទាប់។  
                       ចម្លើយទេ គឺបានពិន្ទុ ព្រោះមិនមានករណីត្រូវតាមដាននោះទេរយៈពេល៣ខែចុងក្រោយ និងបញ្ចប់ការសម្ភាសន៍)
                   </i>
                </b>
		    </td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="20" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="20" value="No" score="3" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
                <br/>
		    </td>
		    <td align="center" valign="middle">3</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
	    <tr>
		    <td align="center">21</td>
		    <td class="kh">
			    តើអ្នកស្ម័ក្រចិត្តភូមិ/ចល័ត ធ្វើការតាមដានអ្វីខ្លះ នៅពេលមានអ្នកជំងឺគ្រុនចាញ់ព្យាបាលផ្តាច់វីវ៉ាក់ឬចម្រុះ?
			    <br />
			    <br />
			    <b><i>គូសចំលើយច្រើនបំផុត ៣</i></b>
		    </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="21" value="Ask and check patient's medicine and count the remaining" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ត្រូវសួរ និងពិនិត្យលើការលេបថ្នាំរបស់អ្នកជំងឺ និងរាប់គ្រាប់ថ្នាំដែលនៅសល់។</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="21" value="Ask side effect of medicine" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. សួរអំពីផលប៉ះពាល់នៃថ្នាំ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="21" value="Entry information to the book and MIS" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. កត់ត្រាព័ត៌មានក្នុងបញ្ជីពិនិត្យ និងបញ្ចូលទៅក្នុងប្រព័ន្ធMIS</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="21" value="Do not know" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. មិនដឹង</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">3</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>

        <tr>
		    <th colspan="5" class="kh pink"><b>ជំពូកទី២៖ ជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីក (សំណួរសម្រាប់តែសមាហរណកម្មVMWតែប៉ុណ្ណោះ)</b></th>
	    </tr>
        <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ៩៖ របៀបនៃការចម្លងជំងឺគ្រុនឈាម/គ្រុនឈីក</th>
	    </tr>
	    <tr>
		    <td align="center">22</td>
		    <td class="kh">តើជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីកចម្លងពីមនុស្សម្នាក់ទៅមនុស្សម្នាក់ទៀតតាមរយៈអ្វី?</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="22" value="Anopheles bite" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. មូសដែកគោលញីខាំ</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="22" value="Aedes aegypti bite" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. មូសខ្លាញីខាំ</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="22" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
        <tr>
		    <td align="center">23</td>
		    <td class="kh">តើមូសខាំចម្លងជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីក មកមនុស្សជាពិសេសនៅក្នុងកំឡុងពេលណាខ្លះ?</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="23" value="Morning and afternoon" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ពេលថ្ងៃ ជាពិសេសពេលព្រឹក និងពេលល្ងាចមុនថ្ងៃលិច</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="23" value="Night until Morning" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ព្រលប់ ទល់ព្រលឹម</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="23" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
        <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ១០៖ រោគសញ្ញាជំងឺគ្រុនឈាម/គ្រុនឈីក</th>
	    </tr>
	    <tr>
		    <td align="center">24</td>
		    <td class="kh">
                តើជំងឺគ្រុនឈាម មានរោគសញ្ញាអ្វីខ្លះ?
                <br/>
                <br/>
                រៀបរាប់សញ្ញា និងរោគសញ្ញាកំរិតស្រាល(៣ ក្នុងចំណោម ៧) 
                <br/>
                <b><i>សូមកុំអានចម្លើយ</i></b>
            </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="24" value="Headache and fever" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ឈឺក្បាល និងក្តៅខ្លួន</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="24" value="Eye pain" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ឈឺភ្នែក</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="24" value="Muscle pain" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ឈឺសាច់ដុំ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="24" value="Itchy skin" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. រមាស់ស្បែក</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="24" value="Nausea/Vomiting" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. ចង្អោរ/ក្អួត</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="24" value="Bone pain" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. ឈឺឆ្អឹង</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="24" value="Joint pain" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>7. ឈឺតាមសន្លាក់</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="24" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>8. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
        <tr>
		    <td align="center">25</td>
		    <td class="kh">
                តើជំងឺគ្រុនឈីក មានរោគសញ្ញាស្រាលអ្វីខ្លះ?
                <br/>
                <br/>
                រៀបរាប់សញ្ញា និងរោគសញ្ញាកំរិតស្រាល(៣ ក្នុងចំណោម ៨) 
                <br/>
                <b><i>សូមកុំអានចម្លើយ</i></b>
            </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Headache and fever" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ឈឺក្បាល និងក្តៅខ្លួន</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Eye pain" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ឈឺភ្នែក</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Muscle pain" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ឈឺសាច់ដុំ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Itchy skin" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. រមាស់ស្បែក</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Nausea/Vomiting" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. ចង្អោរ/ក្អួត</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Bone pain" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. ឈឺឆ្អឹង</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Joint pain" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>7. ឈឺតាមសន្លាក់</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Swollen feet" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>8. ហើមជើង</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="25" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>9. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
		    </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
        <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ១១៖ ការចែកថ្នាំអាប៊ែតដល់ប្រជាជនក្នុងសហគមន៍</th>
	    </tr>
        <tr>
		    <td align="center">26</td>
		    <td class="kh">តើអ្នកបានចែកថ្នាំអាប៊ែតដល់ប្រជាជននៅក្នុងសហគមន៍របស់អ្នកដែរទេ?</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="26" value="Yes" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="26" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
                <br/>
		    </td>
		    <td class="pink"></td>
		    <td class="pink"></td>
	    </tr>

        <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ១២៖ ការពិនិត្យលើការអប់រំសុខភាពជំងឺគ្រុនឈាម/គ្រុនឈីក</th>
	    </tr>
        <tr>
		    <td align="center">27</td>
		    <td class="kh">តើអ្នកអ្នកស្ម័គ្រចិត្តបានអប់រំសុខភាពជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីកកំឡុងពេល៣ខែមុននៅក្នុងសហគមន៏គាត់ដែរឬទេ?</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="27" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="27" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
                <br/>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
        <tr>
		    <td align="center">28</td>
		    <td class="kh">
                តើសារគន្លឹះយ៉ាងហោចណាស់ចំនួន៣អ្វីខ្លះដែលជាវិធានការការពារជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីកដែលអ្នកអាចផ្តល់ទៅអោយសហគមន៍របស់អ្នក?
                <br/>
                <br/>
                រៀបរាប់សារគន្លឹះនៃវិធានការការពារជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីក (៣ ក្នុងចំណោម ៥)  
                <br/>
                <b><i>សូមកុំអានចម្លើយ</i></b>
            </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="28" value="Reduce source of vector" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. កាត់បន្ថយប្រភពរបស់ភ្នាក់ងារចម្លង (ដាក់ថ្នាំអាបែត ដាក់ត្រីប្រាំពីរពណ៌ ឬកប់វត្ថុដែលដក់ទឹកដែលបោះបង់ចោល)</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="28" value="Use repellent" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ប្រើប្រាស់ថ្នាំបណ្តេញមូស</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="28" value="Use mosquito killer spray" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ប្រើថ្នាំបាញ់មូស</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="28" value="Remove pools" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. លុបថ្លុក ឬកន្លែងអាចដក់ទឹកបាន</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="28" value="Prevent you and your family" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. ការពារខ្លួនអ្នក និងគ្រួសារទាំងមូល</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="28" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
            </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
        <tr>
		    <th colspan="5" class="kh pink"><b>ជំពូកទី៣៖ ជំងឺដង្កូវព្រូន (សំណួរសម្រាប់តែសមាហរណកម្មVMWតែប៉ុណ្ណោះ)</b></th>
	    </tr>
        <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ១៣៖ ការកំណត់រោគសញ្ញា និងកត្តានាំឲកើតជំងឺដង្កូវព្រូន</th>
	    </tr>
	    <tr>
		    <td align="center">29</td>
		    <td class="kh">
                តើមូលហេតុអ្វីដែលនាំអោយកើតជំងឺដង្កូវព្រូន?
                <br/>
                <br/>
                រៀបរាប់មូលហេតុទាំងនោះ (៣ ក្នុងចំណោម ៥)  
                <br/>
                <b><i>សូមកុំអានចម្លើយ</i></b>
            </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="29" value="Defecation in the open field" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ការបន្ទោរបង់ពាស់វាលពាស់កាល</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="29" value="Use of unclean water" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ការប្រើប្រាស់ទឹកមិនស្អាត</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="29" value="Eat unwashed vegetables or fruits" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. បរិភោគបន្លែ ឬផ្លែឈើមិនបានលាងសម្អាត</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="29" value="Eating raw or undercooked fish or meat" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. ការបរិភោគត្រី ឬសាច់នៅឆៅ ឬមិនបានចម្អិនឲ្យឆ្អិនល្អ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="29" value="Walk or play or work without shoes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. ដើរ ឬលេង ឬធ្វើការងារ ដោយមិនពាក់ស្បែកជើង</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="29" value="Failed to identify" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. មិនដឹង/មិនអាចឆ្លើយបាន</span>
				    </label>
			    </div>
            </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
        </tr>

        <tr>
		    <td align="center">30</td>
		    <td class="kh">
                តើរោគសញ្ញា និងលក្ខណៈសង្ស័យអ្នកកើតជំងឺព្រូនមានអ្វីខ្លះ?
                <br/>
                <br/>
                រៀបរាប់សញ្ញា និងលក្ខណៈសង្ស័យ (៣ ក្នុងចំណោម ៩)  
                <br/>
                <b><i>សូមកុំអានចម្លើយ</i></b>
            </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Thin body" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. មានរាងកាយស្គម</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Big belly" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ធំពោះ</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Pale" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ស្លេកស្លាំង</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Frequent colic" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. ឧស្សាហ៍ចុកពោះ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Itchy buttocks" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. រមាស់គូថ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Diarrhea" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. រាគ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Nausea/vomiting" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>7. ចង្អោរ/ក្អួត</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Stinging fever" score="1.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>8. មានក្តៅខ្លួនស្ទិញៗ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="Eat a lot but do not grow" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>9. ញ៉ាំច្រើនតែមិនធំធាត់</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="30" value="No power" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>10. អត់មានកំលាំង (ខ្សោយ) ពេលគេងមានភាពរសាប់រសល់ គេងមិនសូវលក់ស្រួល </span>
				    </label>
			    </div>
            </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
        </tr>
        <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ១៤៖ ការផ្តល់ថ្នាំទំលាក់ព្រូនប្រជាជនក្នុងសហគមន៍</th>
	    </tr>
        <tr>
		    <td align="center">31</td>
		    <td class="kh">តើអ្នកបានចូលរួមយុទ្ធនាចែកថ្នាំទំលាក់ព្រូនដល់ប្រជាជននៅក្នុងសហគមន៍របស់អ្នកក្នុងរយៈពេល១ឆ្នាំចុងក្រោយដែរ ឬទេ??</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="31" value="Yes" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="31" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
                <br/>
		    </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>

         <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ១៥៖ ការពិនិត្យលើការអប់រំសុខភាពជំងឺដង្កូវព្រូន</th>
	    </tr>
        <tr>
		    <td align="center">32</td>
		    <td class="kh">តើអ្នកអ្នកស្ម័គ្រចិត្តបានអប់រំសុខភាពជំងឺដង្កូវព្រូនកាលពីកំឡុងពេល៣ខែមុននៅក្នុងសហគមន៏គាត់ដែរឬទេ?</td>
		    <td class="kh">
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="32" value="Yes" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. បាទ/ចាស៎</span>
				    </label>
			    </div>
			    <div class="radio radio-lg">
				    <label>
					    <input type="radio" name="32" value="No" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ទេ</span>
				    </label>
			    </div>
                <br/>
		    </td>
		    <td align="center" valign="middle">0.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
	    </tr>
        <tr>
		    <td align="center">33</td>
		    <td class="kh">
                ចូររៀបរាប់សារគន្លឹះចំនួន៣សំខាន់ដែលជាវិធានការការពារជំងឺដង្កូវព្រូនដែលអ្នកអាចផ្តល់ទៅ   អោយសហគមន៍របស់អ្នក។
                <br/>
                <br/>
                រៀបរាប់អោយបាន៣ចំនុច 
                <br/>
                <b><i>សូមកុំអានចម្លើយ</i></b>
            </td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="33" value="Always wash fruits and vegetables thoroughly before eating" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. ត្រូវលាងបន្លែ ផ្លែឈើអោយបានស្អាតជានិច្ចមុននឹងញុំា</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="33" value="Always trim your fingernails" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. ត្រូវកាត់ក្រចកដៃអោយស្អាតជានិច្ច</span>
				    </label>
			    </div>
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="33" value="Always drink boiled water" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ត្រូវញុំាទឹកស្អាត ដាំពុះជានិច្ច</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="33" value="Always wear shoes when walking" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>4. ពាក់ស្បែកជើងជានិច្ចនៅពេលដើរ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="33" value="Take deworming medicine as directed by your doctor" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>5. ត្រូវលេបថ្នាំទំលាក់ព្រូនតាមការណែនាំរបស់គ្រូពេទ្យ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="33" value="Always clean your teeth 3 times a day" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>6. ត្រូវដូសសំអាតធ្មេញជានិច្ច គឺ៣ដងក្នុង១ថ្ងៃ</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="33" value="Always wash your hands" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>7. ត្រូវលាងដៃ អោយស្អាតជានិច្ច និងញឹកញាប់</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="33" value="Use toilet and wash your hands after using toilet" score="0.5" data-bind="checked: $root.getAnswer($element)" />
					    <span>8. ត្រូវបត់ជើងក្នុងបង្កន់ និងលាងដៃក្រោយចេញពីបង្គន់</span>
				    </label>
			    </div>
            </td>
		    <td align="center" valign="middle">1.5</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
        </tr>

        <tr>
		    <th colspan="5" class="kh pink"><b>ជំពូកទី៤៖ ការរាយការណ៍ ការបញ្ជូនជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីក និងជំងឺដង្កូវព្រូន និងការចូលរួមប្រជុំជាមួយគណៈកម្មការគ្រប់គ្រងមណ្ឌលសុខភាព(HCMC)</b></th>
	    </tr>
        <tr>
		    <th colspan="5" class="kh pink">ផ្នែកទី ១៦៖ ការបញ្ជូនអ្នកជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីក និងជំងឺដង្កូវព្រូនទៅមណ្ឌលសុខភាព និងការចូលរួមប្រជុំជាមួយHCMC</th>
	    </tr>
        <tr>
		    <td align="center">34</td>
		    <td class="kh">តើអ្នកត្រូវបញ្ជូនអ្នកជំងឺដែលមានរោគសញ្ញាសង្ស័យជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីក និងជំងឺដង្កូវព្រូនទៅកន្លែងណា?</td>
		    <td class="kh">
			    <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="34" value="Health Center" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>1. មណ្ឌលសុខភាព</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="34" value="Referral Hospital" score="1" data-bind="checked: $root.getAnswer($element)" />
					    <span>2. មន្ទីរពេទ្យបង្អែក</span>
				    </label>
			    </div>
                <div class="checkbox checkbox-lg">
				    <label>
					    <input type="checkbox" name="34" value="Other" score="0" data-bind="checked: $root.getAnswer($element)" />
					    <span>3. ផ្សេងៗ (ឱសថស្ថានឬក្លីនិចផ្សេងៗ)</span>
				    </label>
			    </div>
         </td>
		    <td align="center" valign="middle">1</td>
		    <td align="center" valign="middle" data-bind="text: $root.getScore($element)"></td>
        </tr>
	    <tr class="pink">
		    <th colspan="4" align="right"><kh>ពិន្ទុសរុប</kh> = 100</th>
		    <td></td>
	    </tr>
    </table>
    <br />
</div>

<table class="table table-bordered" data-bind="with: masterModel">
	<tr class="bg-gray">
		<th colspan="4" class="kh">ពិន្ទុសរុបតាមផ្នែកនីមួយៗរបស់អ្នកស្ម័គ្រចិត្តភូមិ</th>
	</tr>
	<tr class="bg-gray">
		<th class="kh">ផ្នែក</th>
		<th align="center" class="kh">ពិន្ទុសរុបតាមផ្នែក</th>
		<th align="center" class="kh">ពិន្ទុអ្នកស្ម័គ្រចិត្តទទួលបាន</th>
		<th align="center" class="kh">មធ្យមភាគ</th>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ១៖ ព័ត៌មានទូទៅ</td>
		<td align="center">0</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ២៖ ការធ្វើតេស្ត</td>
		<td align="center">42</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section2')"></td>
		<td align="center" data-bind="text: Math.round(Section2() * 100 / 42) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៣៖ ការព្យាបាល</td>
		<td align="center">13</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section3')"></td>
		<td align="center" data-bind="text: Math.round(Section3() * 100 / 13) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៤៖ ការធ្វើរបាយការណ៍ និងឯកសារ</td>
		<td align="center">3</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section4')"></td>
		<td align="center" data-bind="text: Math.round(Section4() * 100 / 3) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៥៖ ការវាយតំលៃទៅលើកន្លែងធ្វើការ</td>
		<td align="center">17</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section5')"></td>
		<td align="center" data-bind="text: Math.round(Section5() * 100 / 17) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៦៖ ការគ្រប់គ្រងកាសំណល</td>
		<td align="center">4</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section6')"></td>
		<td align="center" data-bind="text: Math.round(Section6() * 100 / 4) + '%'"></td>
	</tr>
	<tr>
		<td class="kh">ផ្នែកទី ៧៖ ការពិនិត្យលើការអប់រំសុខភាព</td>
		<td align="center">5</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section7')"></td>
		<td align="center" data-bind="text: Math.round(Section7() * 100 / 5) + '%'"></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ៨៖ ការតាមដានការព្យាបាលផ្តាច់វិវ៉ាក់/ចម្រុះ</td>
		<td align="center">3</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section8')"></td>
		<td align="center" data-bind="text: Math.round(Section8() * 100 / 3) + '%'"></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ៩៖ របៀបនៃការចម្លងជំងឺគ្រុនឈាម/គ្រុនឈីក</td>
		<td align="center">1</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section9')"></td>
		<td align="center" data-bind="text: Math.round(Section9() * 100) + '%'"></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ១០៖ រោគសញ្ញាជំងឺគ្រុនឈាម/គ្រុនឈីក</td>
		<td align="center">3</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section10')"></td>
		<td align="center" data-bind="text: Math.round(Section10() * 100 / 3) + '%'"></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ១១៖ ការចែកថ្នាំអាប៊ែតដល់ប្រជាជនក្នុងសហគមន៍</td>
		<td align="center">0</td>
		<td></td>
		<td></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ១២៖ ការពិនិត្យលើការអប់រំសុខភាពជំងឺគ្រុនឈាម/គ្រុនឈីក</td>
		<td align="center">2</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section12')"></td>
		<td align="center" data-bind="text: Math.round(Section12() * 100 / 2) + '%'"></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ១៣៖ ការកំណត់រោគសញ្ញា និងកត្តានាំឲកើតជំងឺដង្កូវព្រូន</td>
		<td align="center">3</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section13')"></td>
		<td align="center" data-bind="text: Math.round(Section13() * 100 / 3) + '%'"></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ១៤៖ ការផ្តល់ថ្នាំទំលាក់ព្រូនប្រជាជនក្នុងសហគមន៍</td>
		<td align="center">1</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section14')"></td>
		<td align="center" data-bind="text: Math.round(Section14() * 100) + '%'"></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ១៥៖ ការពិនិត្យលើការអប់រំសុខភាពជំងឺដង្កូវព្រូន</td>
		<td align="center">2</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section15')"></td>
		<td align="center" data-bind="text: Math.round(Section15() * 100 / 2) + '%'"></td>
	</tr>
    <tr>
		<td class="kh">ផ្នែកទី ១៦៖ ការបញ្ជូនអ្នកជំងឺគ្រុនឈាម/ជំងឺគ្រុនឈីក និងជំងឺដង្កូវព្រូនទៅមណ្ឌលសុខភាព និងការចូលរួមប្រជុំជាមួយHCMC</td>
		<td align="center">1</td>
		<td align="center" data-bind="text: $root.getTotalScore('Section16')"></td>
		<td align="center" data-bind="text: Math.round(Section16() * 100) + '%'"></td>
	</tr>
	<tr>
		<th colspan="2" class="kh" align="right">ពិន្ទុសរុប</th>
		<th align="center" data-bind="text: $root.getTotalScore('TotalScore')"></th>
		<th align="center" data-bind="text: Math.round(TotalScore()) + '%'"></th>
	</tr>
</table>
<!-- /ko -->