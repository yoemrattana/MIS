<tbody>
	<tr id="2.1.2-1">
		<td field="number" align="center"></td>
		<td field="indicator">All sectors mandated to report</td>
		<td field="question" class="en">Do you report/ Is there a mandate to report malaria cases here?</td>
		<td class="kh">តើការធ្វើរបាយការណ៍គ្រុនចាញ់ មានពេលវេលាកំណត់ផ្លូវការឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. បាទ/ចាស</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. ទេ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="2.1.2-2">
		<td field="number" align="center"></td>
		<td field="indicator">All sectors mandated to report</td>
		<td field="question" class="en">Do you report case based data?</td>
		<td class="kh">តើអ្នករាយការណ៍ករណីជំងឺគ្រុនចាញ់ម្នាក់ៗ ឬយ៉ាងណា?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. បាទ/ចាស</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. ទេ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="2.3.1">
		<td field="number" align="center"></td>
		<td field="indicator">Guideline availability</td>
		<td field="question" class="en">Are there national guidelines for surveillance?</td>
		<td class="kh">តើមានគោលការណ៍ណែនាំថ្នាក់ជាតិសម្រាប់ការតាមដានជំងឺគ្រុនចាញ់ដែរឬទេ?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">Yes</span>
					<span class="kh">មាន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">No</span>
					<span class="kh">មិនមាន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">Don't know</span>
					<span class="kh">មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="2.4.2-4">
		<td field="number" align="center"></td>
		<td field="indicator">Equipment availability</td>
		<td class="en">
			<span field="question">Do you require the following items to record and report malaria data?</span>
			<br><br>
			A. Patient register books<br>
			B. Mobile phone(s)<br>
			C. Mobile network connection (voice or SMS)<br>
			D. Internet connection (mobile or fixed)<br>
			E. Electricity<br>
			F. Other
		</td>
		<td class="kh">
			តើអ្នកត្រូវការរបស់ទាំងនេះទេដើម្បីកត់ត្រា និង រាយការណ៍ទិន្នន័យគ្រុនចាញ់?
			<br><br>
			A. សៀវភៅចុះឈ្មោះអ្នកជំងឺ<br>
			B. ទូរស័ព្ទដៃ<br>
			C. ការភ្ជាប់បណ្ដាញទូរស័ព្ទចល័ត (ជាសំឡេង ឬ សារ SMS)<br>
			D. ការភ្ជាប់អ៊ីនធើណែត (ចល័ត ឬ ថេរ)<br>
			E. អគ្គិសនី<br>
			F. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Patient register books">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Mobile phone(s)">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Mobile network connection (voice or SMS)">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Internet connection (mobile or fixed)">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Electricity">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Other">
					<span>F</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="2.4.2-5">
		<td field="number" align="center"></td>
		<td field="indicator">Equipment availability</td>
		<td class="en">
			<span field="question">Which equipment required was consistently  available in the last 30 days?</span>
			<br><br>
			A. Patient register books<br>
			B. Mobile phone(s)<br>
			C. Mobile network connection (voice or SMS)<br>
			D. Internet connection (mobile or fixed)<br>
			E. Electricity<br>
			F. Other
		</td>
		<td class="kh">
			តើឧបករណ៍មួយណាដែលបានប្រើប្រាស់ជាប់លាប់ក្នុងរយៈពេល៣០ថ្ងៃចុងក្រោយនេះ?
			<br><br>
			A. សៀវភៅចុះឈ្មោះអ្នកជំងឺ<br>
			B. ទូរស័ព្ទដៃ<br>
			C. ការភ្ជាប់បណ្ដាញទូរស័ព្ទចល័ត (ជាសំឡេង ឬ សារ SMS)<br>
			D. ការភ្ជាប់អ៊ីនធើណែត (ចល័ត ឬ ថេរ)<br>
			E. អគ្គិសនី<br>
			F. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Patient register books">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Mobile phone(s)">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Mobile network connection (voice or SMS)">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Internet connection (mobile or fixed)">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Electricity">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Other">
					<span>F</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="2.4.2-6">
		<td field="number" align="center"></td>
		<td field="indicator">Equipment availability</td>
		<td class="en">
			<span field="question">In the last 30 days, select which equipment required was functional</span>
			<br><br>
			A. Mobile phone(s)<br>
			B. Mobile network connection (voice or SMS)<br>
			C. Internet connection (mobile or fixed)<br>
			D. Electricity
		</td>
		<td class="kh">
			ក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយនេះ ឧបករណ៍មួយណាដែលដំណើរការបានល្អ
			<br><br>
			A. ទូរស័ព្ទដៃ<br>
			B. ការភ្ជាប់បណ្ដាញទូរស័ព្ទចល័ត (ជាសំឡេង ឬ សារ SMS)<br>
			C. ការភ្ជាប់អ៊ីនធើណែត (ចល័ត ឬ ថេរ)<br>
			D. អគ្គិសនី
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Mobile phone(s)">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Mobile network connection (voice or SMS)">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Internet connection (mobile or fixed)">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Electricity">
					<span>D</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="2.4.3">
		<td field="number" align="center"></td>
		<td field="indicator">Infrastructure availability</td>
		<td field="question" class="en">Have you experienced infrastructure failure (of internet connectivity, cellular service/data, and/or electricity as applicable) within the last 30 days?</td>
		<td class="kh">តើអ្នកធ្លាប់ជួបប្រទះបញ្ហា (ភ្ជាប់អ៊ីនធឺណិត, សេវាទូរស័ព្ទ ឬអគ្គិសនី)? នៅក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយនេះទេ?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Yes, internet connectivity</span>
					<span class="kh">A. មាន, បញ្ហាអ៊ីនធើណែត</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Yes, cellular service/data</span>
					<span class="kh">B. មាន, បញ្ហាសេវាទូរស័ព្ទ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Yes, electricity</span>
					<span class="kh">C. មាន, បញ្ហាដាច់ភ្លើង</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">D. No</span>
					<span class="kh">D. ទេ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">E. Don't know</span>
					<span class="kh">E. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="2.4.4">
		<td field="number" align="center"></td>
		<td field="indicator">Documented resource allocation and troubleshooting</td>
		<td field="question" class="en">Do you have someone to ask about troubleshooting resource availability (Register book, phone, etc.)?</td>
		<td class="kh">តើអ្នកដឹងថា អ្នកណាដែលអ្នកអាចសួររក (សៀវភៅកត់ត្រាជំងឺ ទូរស័ព្ទមិនដំណើការល្អ...)?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. ស្គាល់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. មិនស្គាល់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.1.2">
		<td field="number" align="center"></td>
		<td field="indicator">Adequate commodities for testing</td>
		<td field="question" class="en">Have you experienced stock-outs of rapid diagnostic tests (RDTs) in the previous 6 months?</td>
		<td class="kh">ក្នុងរយៈពេល៦ខែមុន តើអ្នកធ្លាប់ជួបបញ្ហាដាច់ស្ដុកតេស្ដរហ័ស (RDT) ទេ ដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. បាទ/ចាស</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. ទេ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.1.3">
		<td field="number" align="center"></td>
		<td field="indicator">Adequate commodities for treatment</td>
		<td field="question" class="en">Have you experienced stock-outs of ACTs in the previous 6 months?</td>
		<td class="kh">ក្នុងរយៈពេល៦ខែមុន តើអ្នកធ្លាប់ជួបបញ្ហាដាច់ស្ដុកថ្នាំគ្រុនចាញ់ (ACT) ទេ ដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. បាទ/ចាស</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. ទេ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.2.1">
		<td field="number" align="center"></td>
		<td field="indicator">Number of recording forms/tools</td>
		<td class="en">
			<span field="question">Which forms/tools are used to record malaria case data here?</span>
			<br /><br />
			A. Paper forms<br />
			B. MIS app<br />
			C. Don't know<br />
			D. None<br />
			E. Other
		</td>
		<td class="kh">
			តើទម្រង់/ឧបករណ៍ណាខ្លះដែលត្រូវបានប្រើដើម្បីកត់ត្រាទិន្នន័យជំងឺគ្រុនចាញ់នៅទីនេះ?
			<br /><br />
			A. ទម្រង់ក្រដាស<br />
			B. MIS app<br />
			C. មិនដឹង<br />
			D. គ្មាន<br />
			E. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Paper forms">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. MIS app">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Don't know">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. None">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Other">
					<span>E</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.2.3">
		<td field="number" align="center"></td>
		<td field="indicator">Recording forms/tools are standardized</td>
		<td field="question" class="en">Data collector: OBSERVE if the tool is the standard tool issued by the national program</td>
		<td class="kh">អ្នកប្រមូលទិន្នន័យ៖ សង្កេតមើលប្រសិនបើទំរង់/ ឧបករណ៍នោះ គឺជារបស់ស្ដង់ដារដែលត្រូវបានបង្កើតឡើងដោយកម្មវិធីជាតិ</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. បាទ/ចាស</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. ទេ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.2.4">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of recording process</td>
		<td field="question" class="en text-bold">Read each statement below and indicate to what extent you agree or disagree with the statement</td>
		<td class="kh text-bold">សូមអានចំណុចៗខាងក្រោមនេះ ហើយបង្ហាញពីកម្រិតណាដែលអ្នកយល់ស្រប ឬមិនយល់ស្របទៅតាមឃ្លានីមួយៗ៖</td>
		<td field="answer"></td>
	</tr>
	<tr id="3.2.4.1">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of recording process</td>
		<td field="question" class="en">I understand data elements/ variables/ fields recorded for malaria surveillance</td>
		<td class="kh">ចំពោះចំណុចៗខាងក្រោមនេះ តើអ្នកយល់កម្រិតណា ឬអ្នកមិនយល់?<br />អថេរនៅក្នុង Surveillance Form មានដូចជា (VMW Book, RCD, Investigation, Foci, Last Mile) សួរតែឯកសារពាក់ព័ន្ធដែលគាត់មាន</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Understand 100%</span>
					<span class="kh">A. យល់ 100%</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Understand 80%</span>
					<span class="kh">B. យល់ 80%</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Understand 50%</span>
					<span class="kh">C. យល់ 50%</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. Not understand</span>
					<span class="kh">D. មិនសូវយល់</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.2.4.2">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of recording process</td>
		<td field="question" class="en">The process for data recording (tools, personnel, frequency) is clearly documented in Job Aid or SOPs?</td>
		<td class="kh">ដំណើរការសម្រាប់ការកត់ត្រាទិន្នន័យ មាននៅក្នុង Job Aid ដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. No</span>
					<span class="kh">A. មិនមាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Yes</span>
					<span class="kh">B. មាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.2.4.3">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of recording process</td>
		<td field="question" class="en">I feel that recording malaria data for routine surveillance is straightforward and streamlined (i.e. no overlapping or duplicative processes)</td>
		<td class="kh">ខ្ញុំមានអារម្មណ៍ថា ការកត់ត្រាទិន្នន័យតាមដានជំងឺគ្រុនចាញ់ គឺមានភាពរលូន (ឧ. មិនមានដំណើរការជាន់គ្នា ឬស្ទួនទេ)</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Understand</span>
					<span class="kh">A. បាទ/ចាស</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Not clear</span>
					<span class="kh">B. មិនច្បាស់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Complicate</span>
					<span class="kh">C. ស្មុគស្មាញ</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.2.4.4">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of recording process</td>
		<td field="question" class="en">I know who to ask or what documents to reference for troubleshooting and support for data recording</td>
		<td class="kh">ខ្ញុំស្គាល់អ្នកណាត្រូវសួរ ឬដឹងពីឯកសារយោង នៅពេលមានបញ្ហាផ្សេងៗ ចំពោះការកត់ត្រាទិន្នន័យ</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. ដឹង</span>
					<span class="kh">A. យល់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Not clear</span>
					<span class="kh">B. មិនសូវដឹង</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Complicate</span>
					<span class="kh">C. ស្មុគស្មាញ</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.3.4-1">
		<td field="number" align="center"></td>
		<td field="indicator">Reporting process adheres to WHO recommendation</td>
		<td field="question" class="en">What type of data is reported?</td>
		<td class="kh">តើទិន្នន័យប្រភេទណាដែលត្រូវរាយការណ៍?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Case based data</span>
					<span class="kh">A. ទិន្នន័យអ្នកជំងឺម្នាក់ៗ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Aggregate data</span>
					<span class="kh">B. ទិន្នន័យសរុប</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.3.4-2">
		<td field="number" align="center"></td>
		<td field="indicator">Reporting process adheres to WHO recommendation</td>
		<td field="question" class="en">Are reports of zero or no cases sent to higher levels?</td>
		<td class="kh">តើករណីសូន្យ ឬមិនមានករណី ត្រូវចាំបាច់រាយការណ៍ ទៅក្នុងប្រព័ន្ធ/ ទៅលើដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. ធ្វើ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. មិនធ្វើ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.3.4-3">
		<td field="number" align="center"></td>
		<td field="indicator">Reporting process adheres to WHO recommendation</td>
		<td field="question" class="en">How often do you/they report malaria case data?</td>
		<td class="kh">តើការរាយការណ៍ករណីគ្រុនចាញ់ធ្វើឡើងញឹកញាប់ប៉ុណ្ណា?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Immediate</span>
					<span class="kh">A. ភ្លាមៗពេលមានករណី</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Weekly</span>
					<span class="kh">B. ប្រចាំសប្ដាហ៍</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Monthly</span>
					<span class="kh">C. ប្រចាំខែ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">D. Other</span>
					<span class="kh">D. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="4.4.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Training</td>
		<td field="question" class="en">Have you received surveillance training in the previous year?</td>
		<td class="kh">តើអ្នកបានទទួលការបណ្ដុះបណ្ដាលផ្នែកតាមដានជំងឺគ្រុនចាញ់កាលពីឆ្នាំមុនៗដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. បាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. មិនបាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't Know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.1-3">
		<td field="number" align="center"></td>
		<td field="indicator">Training</td>
		<td class="en">
			<span field="question">What surveillance activities were covered in the training?</span>
			<br /><br />
			A. Data collection (recording patient information)<br />
			B. Data reporting (compiling malaria case reports)<br />
			C. Conducting data quality review of malaria case data<br />
			D. Conducting data analysis of malaria case data and data use<br />
			E. Supervision<br />
			F. Case notification<br />
			G. Don't know<br />
			H. Other
		</td>
		<td class="kh">
			តើសកម្មភាពតាមដានជំងឺគ្រុនចាញ់អ្វីខ្លះ ដែលអ្នកបានរៀននៅក្នុងវគ្គបណ្ដុះបណ្ដាល?
			<br /><br />
			A. ការប្រមូលទិន្នន័យ (បញ្ចូលព័ត៌មានអ្នកជំងឺ)<br />
			B. ការរាយការណ៍ទិន្នន័យ (របាយការណ៍ករណីជំងឺគ្រុនចាញ់)<br />
			C. ពិនិត្យគុណភាពទិន្នន័យ<br />
			D. ធ្វើការវិភាគទិន្នន័យ<br />
			E. ការចុះអភិបាល<br />
			F. ការជូនដំណឹងពីការមានករណីគ្រុនចាញ់<br />
			G. មិនដឹង<br />
			H. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Data collection (recording patient information)">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Data reporting (compiling malaria case reports)">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Conducting data quality review of malaria case data">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Conducting data analysis of malaria case data and data use">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Supervision">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Case notification">
					<span>F</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="G. Don't know">
					<span>G</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="H. Other">
					<span>H</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="4.4.2">
		<td field="number" align="center"></td>
		<td field="indicator">Job aids</td>
		<td field="question" class="en">Have you been provided with a job-aid for malaria surveillance (e.g. poster or leaflet)?</td>
		<td class="kh">តើអ្នកធ្លាប់ទទួលខិត្តប័ណ្ណ រឺ ផ្ទាំងរូបភាពទាក់ទងនឹងការការងារតាមដានជំងឺគ្រុនចាញ់ដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. ធ្លាប់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. មិនធ្លាប់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Don't Know</span>
					<span class="kh">C. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.3-1">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en text-bold">Read each statement below and indicate to what extent you agree or disagree with the statement</td>
		<td class="kh text-bold">សូមអានចំណុចៗខាងក្រោមនេះ ហើយបង្ហាញពីកម្រិតណាដែលអ្នកយល់ស្រប ឬមិនយល់ស្របទៅតាមឃ្លានីមួយៗ</td>
		<td field="answer"></td>
	</tr>
	<tr id="4.4.3-2">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en">I am confident in my ability to record malaria data in source documents (patient register, etc.)</td>
		<td class="kh">ខ្ញុំជឿជាក់លើសមត្ថភាពរបស់ខ្ញុំក្នុងការកត់ត្រាទិន្នន័យជំងឺគ្រុនចាញ់នៅក្នុងឯកសារ (ទម្រង់ចុះឈ្មោះអ្នកជំងឺ, ។ល។)</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (Not able)</span>
					<span class="kh">A. (មិនជឿជាក់)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (Able 25%)</span>
					<span class="kh">B. (ជឿ 25%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (Able 50%)</span>
					<span class="kh">C. (ជឿ 50%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (Able 75%)</span>
					<span class="kh">D. (ជឿ 75%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (Very confident in my abilities)</span>
					<span class="kh">E. (ជឿជាក់)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.3-3">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en">I am confident in my ability to use information for problem solving or making decisions</td>
		<td class="kh">ខ្ញុំជឿជាក់លើសមត្ថភាពរបស់ខ្ញុំក្នុងការប្រើប្រាស់ទិន្នន័យគ្រុនចាញ់សម្រាប់ដោះស្រាយបញ្ហា ឬធ្វើការសម្រេចចិត្តនានា</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (Not able)</span>
					<span class="kh">A. (មិនជឿជាក់)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (Able 25%)</span>
					<span class="kh">B. (ជឿ 25%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (Able 50%)</span>
					<span class="kh">C. (ជឿ 50%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (Able 75%)</span>
					<span class="kh">D. (ជឿ 75%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (Very confident in my abilities)</span>
					<span class="kh">E. (ជឿជាក់)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.4">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff knowledge</td>
		<td field="question" class="en">What are the reasons or objective for malaria surveillance? Please list at least three reasons for collecting or using malaria surveillance data</td>
		<td class="kh">តើមូលហេតុ ឬគោលបំណងអ្វីខ្លះសម្រាប់ការងារតាមដានជំងឺគ្រុនចាញ់? សូមផ្តល់ហេតុផលយ៉ាងតិច៣ ក្នុងការប្រមូល ឬប្រើប្រាស់ទិន្នន័យតាមដានជំងឺគ្រុនចាញ់</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)">
		</td>
	</tr>
</tbody>