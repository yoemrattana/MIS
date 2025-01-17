<tbody>
	<tr id="2.2.2-1">
		<td field="number" align="center"></td>
		<td field="indicator">Information system attributes are adequate</td>
		<td field="question" class="en">In the last 2 weeks, did you experience any temporary information system failures that prevented you from collecting or reporting data?</td>
		<td class="kh">នៅក្នុងរយៈពេល២សប្ដាហ៍ចុងក្រោយនេះ, តើអ្នកមានជួបប្រទះនូវបញ្ហាប្រព័ន្ធរបាយការណ៍ឬទេ? (ដែលធ្វើអោយការ រាយការណ៍ទិន្នន័យគ្រុនចាញ់មិនបាន)</td>
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
	<tr id="2.2.2-2">
		<td field="number" align="center"></td>
		<td field="indicator">Information system attributes are adequate</td>
		<td class="en">
			<span field="question">Are you able to visualise the data?</span>
			<br><br>
			A. Yes on MIS dashboard<br>
			B. Yes I made it myself on Excel or other<br>
			C. No
		</td>
		<td class="kh">
			តើអ្នកអាចមើលទិន្នន័យ និងមើលក្រាហ្វិកដោយរបៀបណា?
			<br><br>
			A. មើលនៅលើ MIS Dashboard<br>
			B. ធ្វើខ្លួនឯង លើកម្មវិធី Excel ឬកម្មវិធីផ្សេង<br>
			C. មិនអាចមើល
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Yes on MIS dashboard">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Yes I made it myself on Excel or other">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. No">
					<span>C</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="2.3.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Guideline availability</td>
		<td field="question" class="en">Are there national guidelines for surveillance?</td>
		<td class="kh">តើអ្នកមានសៀវភៅ គោលការណ៍ណែនាំថ្នាក់ជាតិសម្រាប់ការតាមដានជំងឺគ្រុនចាញ់ដែរឬទេ?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Yes</span>
					<span class="kh">A. មាន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Yes, on the internet (check internet connectivity and accessibility)</span>
					<span class="kh">B. មាន (មានលើបណ្ដាញអ៊ីនធើណែត)</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Yes, in a manual or other reference document</span>
					<span class="kh">C. មាន, នៅក្នុងសៀវភៅ ឬ ឯកសារយោងផ្សេងទៀត</span>
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
	<tr id="2.3.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Guideline availability</td>
		<td field="question" class="en">Do you have a copy here of each malaria surveillance guideline(s)?</td>
		<td class="kh">តើអ្នកមានច្បាប់ចម្លងគោលការណ៍ណែនាំអំពីការតាមដានជំងឺគ្រុនចាញ់ទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. មាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. ទេ</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="2.4.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff availability</td>
		<td field="question" class="en">How many staff are required for malaria surveillance here?</td>
		<td class="kh">តើត្រូវការបុគ្គលិកប៉ុន្មាននាក់សម្រាប់ការងារតាមដានជំងឺគ្រុនចាញ់នៅថ្នាក់នេះ?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)" numonly="int">
		</td>
	</tr>
	<tr id="2.4.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff availability</td>
		<td field="question" class="en">How many staff required for malaria surveillance are available here?</td>
		<td class="kh">តើឥឡូវនេះមានបុគ្គលិកប៉ុន្មាននាក់ដែលបម្រើការងារតាមដានជំងឺគ្រុនចាញ់នៅថ្នាក់នេះ?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)" numonly="int">
		</td>
	</tr>
	<tr id="2.4.2-1">
		<td field="number" align="center"></td>
		<td field="indicator">Equipment availability</td>
		<td class="en">
			<span field="question">Do you require the following items to record and report malaria data?</span>
			<br><br>
			A. Patient register books<br>
			B. Paper forms<br>
			C. Computers<br>
			D. Printer<br>
			E. Tablet<br>
			F. Mobile phone(s)<br>
			G. Mobile network connection (voice or SMS)<br>
			H. Internet connection (mobile or fixed)<br>
			I. Electricity<br>
			J. Other
		</td>
		<td class="kh">
			តើអ្នកត្រូវការរបស់ទាំងនេះទេដើម្បីកត់ត្រា និង រាយការណ៍ទិន្នន័យគ្រុនចាញ់?
			<br><br>
			A. សៀវភៅចុះឈ្មោះអ្នកជំងឺ<br>
			B. ទម្រង់ក្រដាស<br>
			C. កំព្យូទ័រ<br>
			D. ម៉ាស៊ីនព្រីន<br>
			E. ថេប្លេត<br>
			F. ទូរស័ព្ទដៃ<br>
			G. ការភ្ជាប់បណ្ដាញទូរស័ព្ទចល័ត (ជាសំឡេង ឬ សារ SMS)<br>
			H. ការភ្ជាប់អ៊ីនធើណែត (ចល័ត ឬ ថេរ)<br>
			I. អគ្គិសនី<br>
			J. ផ្សេងៗ
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
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Paper forms">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Computers">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Printer">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Tablet">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Mobile phone(s)">
					<span>F</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="G. Mobile network connection (voice or SMS)">
					<span>G</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="H. Internet connection (mobile or fixed)">
					<span>H</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="I. Electricity">
					<span>I</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="J. Other">
					<span>J</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="2.4.2-2">
		<td field="number" align="center"></td>
		<td field="indicator">Equipment availability</td>
		<td class="en">
			<span field="question">Which equipment required was consistently  available in the last 30 days?</span>
			<br><br>
			A. Patient register books<br>
			B. Paper forms<br>
			C. Computers<br>
			D. Printer<br>
			E. Tablet<br>
			F. Mobile phone(s)<br>
			G. Mobile network connection (voice or SMS)<br>
			H. Internet connection (mobile or fixed)<br>
			I. Electricity<br>
			J. Other
		</td>
		<td class="kh">
			តើឧបករណ៍មួយណាដែលបានប្រើប្រាស់ជាប់លាប់ក្នុងរយៈពេល៣០ថ្ងៃចុងក្រោយនេះ?
			<br><br>
			A. សៀវភៅចុះឈ្មោះអ្នកជំងឺ<br>
			B. ទម្រង់ក្រដាស<br>
			C. កំព្យូទ័រ<br>
			D. ម៉ាស៊ីនព្រីន<br>
			E. ថេប្លេត<br>
			F. ទូរស័ព្ទដៃ<br>
			G. ការភ្ជាប់បណ្ដាញទូរស័ព្ទចល័ត (ជាសំឡេង ឬ សារ SMS)<br>
			H. ការភ្ជាប់អ៊ីនធើណែត (ចល័ត ឬ ថេរ)<br>
			I. អគ្គិសនី<br>
			J. ផ្សេងៗ
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
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Paper forms">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Computers">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Printer">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Tablet">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Mobile phone(s)">
					<span>F</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="G. Mobile network connection (voice or SMS)">
					<span>G</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="H. Internet connection (mobile or fixed)">
					<span>H</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="I. Electricity">
					<span>I</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="J. Other">
					<span>J</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="2.4.2-3">
		<td field="number" align="center"></td>
		<td field="indicator">Equipment availability</td>
		<td class="en">
			<span field="question">For electronic equipment:<br>In the last 30 days, select which equipment required was functional:</span>
			<br><br>
			A. Computers<br>
			B. Printer<br>
			C. Tablet<br>
			D. Mobile phone(s)<br>
			E. Mobile network connection (voice or SMS)<br>
			F. Internet connection (mobile or fixed)<br>
			G. Electricity<br>
			H. Other
		</td>
		<td class="kh">
			សម្រាប់ឧបករណ៍អេឡិចត្រូនិក៖<br>ក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយនេះ ជ្រើសរើសឧបករណ៍មួយណាដែលដំណើរការបានល្អ
			<br><br>
			A. កំព្យូទ័រ<br>
			B. ម៉ាស៊ីនព្រីន<br>
			C. ថេប្លេត<br>
			D. ទូរស័ព្ទដៃ<br>
			E. ការភ្ជាប់បណ្ដាញទូរស័ព្ទចល័ត (ជាសំឡេង ឬ សារ SMS)<br>
			F. ការភ្ជាប់អ៊ីនធើណែត (ចល័ត ឬ ថេរ)<br>
			G. អគ្គិសនី<br>
			H. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Computers">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Printer">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Tablet">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Mobile phone(s)">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Mobile network connection (voice or SMS)">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Internet connection (mobile or fixed)">
					<span>F</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="G. Electricity">
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
		<td class="kh">តើមានអ្នកណាដែលសួរនាំ ពីបញ្ហាអស់ Form រាយការណ៍ស្តុក ឧបករណ៍រាយការណ៍មិនដំណើរការ ដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. មាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. មិនមាន</span>
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
		<td class="kh">ចំពោះចំណុចៗខាងក្រោមនេះ តើអ្នកយល់កម្រិតណា ឬអ្នកមិនយល់?<br>អថេរនៅក្នុង Surveillance Form មានដូចជា (HC Book, VMW Book, RCD, Investigation, Foci, Last Mile)</td>
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
		<td class="kh">ដំណើរការសម្រាប់ការកត់ត្រាទិន្នន័យ មាននៅក្នុង guidelinesដែរឬទេ?</td>
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
		<td class="kh">ខ្ញុំមានអារម្មណ៍ថាការកត់ត្រាជាប្រចាំនូវទិន្នន័យជំងឺគ្រុនចាញ់ គឺមានភាពរលូន (ឧ. មិនមានជាន់គ្នា ឬស្ទួនទេ)</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Understand</span>
					<span class="kh">A. ច្បាស់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Not clear</span>
					<span class="kh">B. មិនសូវច្បាស់</span>
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
					<span class="en">A. Understand</span>
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
	<tr id="3.3.2-1">
		<td field="number" align="center"></td>
		<td field="indicator">Reporting tools transmitting malaria variables</td>
		<td class="en">
			<span field="question">Where is the case notification form sent to?</span>
			<br><br>
			A. Subnational level - OD<br>
			B. Subnational level - PHD<br>
			C. Central level - CNM<br>
			D. PMET<br>
			E. DMET<br>
			F. Other
		</td>
		<td class="kh">
			តើការជូនដំណឹង (Notification) ស្ដីពីករណីគ្រុនចាញ់ ត្រូវជូនដំណឹងទៅខាងណា?
			<br><br>
			A. ថ្នាក់ក្រោមជាតិ ស្រុកប្រតិបត្តិ<br>
			B. ថ្នាក់ក្រោមជាតិ ខេត្ត<br>
			C. ថ្នាក់ជាតិ មគច<br>
			D. PMET<br>
			E. DMET<br>
			F. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Subnational level - OD">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Subnational level - PHD">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Central level - CNM">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. PMET">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. DMET">
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
	<tr id="3.3.2-2">
		<td field="number" align="center"></td>
		<td field="indicator">Reporting tools transmitting malaria variables</td>
		<td class="en">
			<span field="question">Where is the case investigation form sent to?</span>
			<br><br>
			A. Subnational level - OD<br>
			B. Subnational level - PHD<br>
			C. Central level - CNM<br>
			D. PMET<br>
			E. DMET<br>
			F. Other
		</td>
		<td class="kh">
			តើការជូនដំណឹងស្ដីពីការចុះអង្កេតករណីគ្រុនចាញ់ ត្រូវជូនដំណឹងទៅខាងណា?
			<br><br>
			A. ថ្នាក់ក្រោមជាតិ ស្រុកប្រតិបត្តិ<br>
			B. ថ្នាក់ក្រោមជាតិ ខេត្ត<br>
			C. ថ្នាក់ជាតិ មគច<br>
			D. PMET<br>
			E. DMET<br>
			F. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Subnational level - OD">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Subnational level - PHD">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Central level - CNM">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. PMET">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. DMET">
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
	<tr id="3.3.2-3">
		<td field="number" align="center"></td>
		<td field="indicator">Reporting tools transmitting malaria variables</td>
		<td field="question" class="en">Where is the foci investigation form sent to?</td>
		<td class="kh">តើការជូនដំណឹងស្ដីពីការចុះធ្វើសំបុកចម្លងជំងឺគ្រុនចាញ់ ត្រូវជូនដំណឹងទៅខាងណា?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Subnational level - OD</span>
					<span class="kh">A. ថ្នាក់ក្រោមជាតិ ស្រុកប្រតិបត្តិ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Subnational level - PHD</span>
					<span class="kh">B. ថ្នាក់ក្រោមជាតិ ខេត្ត</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Central level - CNM</span>
					<span class="kh">C. ថ្នាក់ជាតិ មគច</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span>D. PMET</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span>E. DMET</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">F. Other</span>
					<span class="kh">F. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.3.4-1">
		<td field="number" align="center"></td>
		<td field="indicator">Reporting process adheres to WHO recommendation</td>
		<td field="question" class="en">Are reports of zero or no cases sent to higher levels?</td>
		<td class="kh">តើករណីសូន្យ ឬមិនមានករណី ត្រូវធ្វើរបាយការណ៍ទៅលើដែរឬទេ?</td>
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
	<tr id="3.3.4-2">
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
	<tr id="3.4.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Number of expected outputs from routine analysis</td>
		<td field="question" class="en">Which expected outputs from routine analysis do you receive?</td>
		<td class="kh">តើអ្វីជាលទ្ធផលរំពឹងទុក បន្ទាប់ពីវិភាគទិន្នន័យជាប្រចាំ?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)">
		</td>
	</tr>
	<tr id="3.4.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Number of expected outputs from routine analysis</td>
		<td field="question" class="en">Who uses the outputs?</td>
		<td class="kh">តើអ្នកណាជាអ្នកប្រើប្រាស់លទ្ធផលបន្ទាប់ពីវិភាគ?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)">
		</td>
	</tr>
	<tr id="3.4.1-3">
		<td field="number" align="center"></td>
		<td field="indicator">Number of expected outputs from routine analysis</td>
		<td class="en">
			<span field="question">How do you receive outputs?</span>
			<br><br>
			A. Access outputs directly through the electronic surveillance system e.g. dashboards/reporting function<br>
			B. Weekly/Monthly reports<br>
			C. Annual report only<br>
			D. Presented at surveillance/data review meetings<br>
			E. Routinely published on a website<br>
			F. No method of dissemination
		</td>
		<td class="kh">
			តើអ្នកទទួលលទ្ធផលវិភាគទិន្នន័យបានដោយរបៀបណា?
			<br><br>
			A. ទាញយកលទ្ធផលវិភាគ ដោយផ្ទាល់ពីប្រព័ន្ធ។ ឧ. ផ្ទាំងសង្ខេបទិន្នន័យ / មុខងារទាញយករបាយការណ៍<br>
			B. បានពីរបាយការណ៍វិភាគប្រចាំសប្ដាហ៍/ប្រខែ<br>
			C. បានពីរបាយការណ៍វិភាគប្រចាំឆ្នាំតែមួយគត់<br>
			D. បទបង្ហាញនៅពេលមានកិច្ចប្រជុំ<br>
			E. ការបោះផ្សាយជាសាធារណៈ នៅលើទំព័រវេបសាយ<br>
			F. មិនរបៀបនៃការចែករំលែក ផ្សព្វផ្សាយទេ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Access outputs directly through the electronic surveillance system e.g. dashboards/reporting function">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Weekly/Monthly reports">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Annual report only">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Presented at surveillance/data review meetings">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Routinely published on a website">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. No method of dissemination">
					<span>F</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.4.1-4">
		<td field="number" align="center"></td>
		<td field="indicator">Number of expected outputs from routine analysis</td>
		<td field="question" class="en">How often are the outputs received or updated?</td>
		<td class="kh">តើលទ្ធផលវិភាគទិន្នន័យត្រូវបានទទួល ឬ ធ្វើបច្ចុប្បន្នភាពញឹកញាប់ប៉ុណ្ណា?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Real-time (for dashboards)</span>
					<span class="kh">A. ធ្វើភ្លាម (ផ្ទាំងសង្ខេបទិន្នន័យ)</span>
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
					<span class="en">D. Never</span>
					<span class="kh">D. មិនដែល</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">E. Don't know</span>
					<span class="kh">E. មិនដឹង</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">F. Other</span>
					<span class="kh">F. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.4.2">
		<td field="number" align="center"></td>
		<td field="indicator">Expected outputs include malaria indicators</td>
		<td class="en">
			<span field="question">What is included in these outputs/dissemination materials?</span>
			<br><br>
			A. Trends over time for all WHO core facility indicators<br>
			B. Trends over time for IPTf coverage (if applicable)<br>
			C. Trends over time but not all recommended indicators are included<br>
			D. Monitoring of treatment<br>
			E. Descriptive maps<br>
			F. Trends over time for patients tested for malaria<br>
			G. Trends over time for confirmed malaria cases (by parasite specieis, if applicable)
		</td>
		<td class="kh">
			តើមានអ្វីខ្លះ ដែលបានបញ្ចូលនៅក្នុងលទ្ធផលវិភាគទិន្នន័យ សំរាប់ផ្សព្វផ្សាយ?
			<br><br>
			A. បង្ហាញសូចនាករសំខាន់ៗទាំងអស់ តាមពេលវេលា<br>
			B. បង្ហាញពីការគ្របដណ្តប់ IPTf (ប្រសិនបើមាន) តាមពេលវេលា<br>
			C. មិនបង្ហាញសូចនាករសំខាន់ៗទាំងអស់ តាមពេលវេលា<br>
			D. ការតាមដានការព្យាបាល<br>
			E. បង្ហាញពិពណ៌នាជាផែនទី<br>
			F. បង្ហាញពីរបាយការណ៍តេស្តអ្នកជំងឺគ្រុនចាញ់ តាមពេលវេលា<br>
			G. បង្ហាញពីចំនួនបញ្ជាក់រោគវិនិច្ឆ័យ (Confirm) ជំងឺគ្រុនចាញ់ (តាមប្រភេទមេរោគ ប្រសិនបានអនុវត្ត)
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Trends over time for all WHO core facility indicators">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Trends over time for IPTf coverage (if applicable)">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Trends over time but not all recommended indicators are included">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Monitoring of treatment">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Descriptive maps">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Trends over time for patients tested for malaria">
					<span>F</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="G. Trends over time for confirmed malaria cases (by parasite specieis, if applicable)">
					<span>G</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.4.3-1">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of routine analysis process</td>
		<td class="en">
			<span field="question">What are the key challenges with using outputs of routine analyses?</span>
			<br><br>
			A. There are open positions for malaria surveillance staff<br>
			B. Malaria surveillance staff positions are full, but there still are not enough staff<br>
			C. I'm required to do it even though it's not my assigned role<br>
			D. I have other responsibilities outside of malaria that take priority<br>
			E. I haven't received enough training to do it well<br>
			F. The guidelines for this activity are not clear<br>
			G. It's too difficult/complicated<br>
			H. It takes too much time<br>
			I. Don't know<br>
			J. Don't answer<br>
			K. Other
		</td>
		<td class="kh">
			តើអ្វីជាបញ្ហាប្រឈម ក្នុងការប្រើប្រាស់លទ្ធផលនៃការវិភាគ?
			<br><br>
			A. តួនាទីសម្រាប់ការតាមដានជំងឺគ្រុនចាញ់ មិនតែងតាំងច្បាស់ (បើកចំហ)<br>
			B. មន្រ្តីទទួលការងារតាមដានជំងឺគ្រុនចាញ់មានពេញអស់ហើយ ប៉ុន្ដែនៅតែមិនគ្រប់គ្រាន់<br>
			C. ខ្ញុំតម្រូវអោយធ្វើការងារនេះ បើទោះបីជាខ្ញុំមិនមែនជាទំនួលខុសត្រូវក៏ដោយ<br>
			D. ខ្ញុំមានការងារអាទិភាពផ្សេងទៀតក្រៅពីការងារគ្រុនចាញ់<br>
			E. ខ្ញុំមិនបានទទួលការបណ្ដុះបណ្ដាលគ្រប់គ្រាន់ ដើម្បីធ្វើវាអោយបានល្អទេ<br>
			F. គោលការណ៍ណែនាំសម្រាប់សកម្មភាពនេះមិនច្បាស់លាស់<br>
			G. វាពិបាក / ស្មុគស្មាញពេក<br>
			H. វាត្រូវការចំណាយពេលច្រើន<br>
			I. មិនដឹង<br>
			J. មិនឆ្លើយ<br>
			K. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. There are open positions for malaria surveillance staff">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Malaria surveillance staff positions are full, but there still are not enough staff">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. I'm required to do it even though it's not my assigned role">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. I have other responsibilities outside of malaria that take priority">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. I haven't received enough training to do it well">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. The guidelines for this activity are not clear">
					<span>F</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="G. It's too difficult/complicated">
					<span>G</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="H. It takes too much time">
					<span>H</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="I. Don't know">
					<span>I</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="J. Don't answer">
					<span>J</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="K. Other">
					<span>K</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.4.3-2">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of routine analysis process</td>
		<td field="question" class="en">I understand data elements/ variables/ indicators that should be calculated for malaria surveillance routine analysis</td>
		<td class="kh">ខ្ញុំយល់ពីធាតុទិន្នន័យ/អថេរ/សូចនាករដែលគួរត្រូវបានយកមកគណនាសម្រាប់ការវិភាគទិន្នន័យតាមដានជំងឺគ្រុនចាញ់</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Understand</span>
					<span class="kh">A. យល់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Not clear</span>
					<span class="kh">B. មិនសូវយល់</span>
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
	<tr id="3.4.3-3">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of routine analysis process</td>
		<td field="question" class="en">The process for data analysis (tools, personnel, frequency) is clearly documented in guidelines or SOPs</td>
		<td class="kh">ដំណើរការសម្រាប់ការវិភាគទិន្នន័យ (ឧបករណ៍ បុគ្គលិក គំរូដែលផ្ដល់ឱ្យ) ត្រូវបានចងក្រងជាឯកសារយ៉ាងច្បាស់នៅក្នុងការណែនាំ ឬ នីតិវិធីស្ដង់ដារប្រតិបត្តិ</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Understand</span>
					<span class="kh">A. យល់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Not clear</span>
					<span class="kh">B. មិនសូវយល់</span>
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
	<tr id="3.4.3-4">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of routine analysis process</td>
		<td field="question" class="en">I feel that data analysis for routine surveillance is straightforward and streamlined (i.e. no overlapping or duplicative processes, multiple forms, etc.)</td>
		<td class="kh">ខ្ញុំមានអារម្មណ៍ថាការកត់ត្រាជាប្រចាំនូវទិន្នន័យតាមដានជំងឺគ្រុនចាញ់គឺមានភាពរលូនទៅមុខ និងសម្រួលច្រើន (ឧ. មិនមានដំណើរការជាន់គ្នា ឬស្ទួនទេ, ទម្រង់ច្រើន,…....)</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Understand</span>
					<span class="kh">A. យល់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Not clear</span>
					<span class="kh">B. មិនសូវយល់</span>
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
	<tr id="3.4.3-5">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of routine analysis process</td>
		<td field="question" class="en">I know who to ask or what documents to refer to for troubleshooting and support for data analysis</td>
		<td class="kh">ខ្ញុំដឹងថាអ្នកណាត្រូវសួរ ឬឯកសារអ្វីខ្លះដែលត្រូវយោងសម្រាប់ការដោះស្រាយបញ្ហាផ្សេងៗ និង ការគាំទ្រដល់ការកត់ត្រាទិន្នន័យ</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Understand</span>
					<span class="kh">A. យល់</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Not clear</span>
					<span class="kh">B. មិនសូវយល់</span>
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
	<tr id="3.5.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Data quality assurance procedures are in place</td>
		<td field="question" class="en">How do you receive feedback on malaria data quality?</td>
		<td class="kh">តើអ្នកទទួលបានមតិកែលម្អអំពីគុណភាពទិន្នន័យជំងឺគ្រុនចាញ់ដោយរបៀបណា?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Routine reports on data quality indicators</span>
					<span class="kh">A. របាយការណ៍លើសូចនាករទិន្នន័យ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Standardized presentations on data quality indicators used during data review meetings</span>
					<span class="kh">B. បទបង្ហាញស្ដង់ដារលើសូចនាករគុណភាពទិន្នន័យដែលបានប្រើក្នុងអំឡុងពេលកិច្ចប្រជុំត្រួតពិនិត្យទិន្នន័យ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Feedback with corrective action given by what's app, phone or email</span>
					<span class="kh">C. មតិកែលម្អជាមួយនឹងសកម្មភាពកែតម្រូវដែលផ្ដល់ឳ្យដោយកម្មវិធីទូរស័ព្ទ ឬ អ៊ីមែល</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">D. Quarterly bulletin</span>
					<span class="kh">D. ព្រឹត្តិបត្រប្រចាំត្រីមាស</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">E. None</span>
					<span class="kh">E. គ្មាន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">F. Don't know</span>
					<span class="kh">F. មិនដឹង</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">G. Other</span>
					<span class="kh">G. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.5.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Data quality assurance procedures are in place</td>
		<td field="question" class="en">What types of quality assurance procedures are systematically undertaken for malaria data?</td>
		<td class="kh">តើនីតិវិធីធានាគុណភាពប្រភេទណាខ្លះ ដែលត្រូវបានអនុវត្តជាប្រចាំ សម្រាប់ទិន្នន័យជំងឺគ្រុនចាញ់?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Data cleaning</span>
					<span class="kh">A. ការសម្អាតទិន្នន័យ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Data review meetings</span>
					<span class="kh">B. ការប្រជុំត្រួតពិនិត្យទិន្នន័យ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Data quality assessments (routine or part of supervision)</span>
					<span class="kh">C. ការវាយតម្លៃគុណភាពទិន្នន័យ (ទម្លាប់ ឬ ការចុះអភិបាល)</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">D. Monitoring of data quality indicators</span>
					<span class="kh">D. ការត្រួតពិនិត្យសូចនាករគុណភាពទិន្នន័យ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">E. None</span>
					<span class="kh">E. មិនមាន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">F. Don't know</span>
					<span class="kh">F. មិនដឹង</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">G. Other</span>
					<span class="kh">G. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.5.1-3">
		<td field="number" align="center"></td>
		<td field="indicator">Data quality assurance procedures are in place</td>
		<td field="question" class="en">Who are the personnel involved?</td>
		<td class="kh">តើបុគ្គលិកណាខ្លះដែលពាក់ព័ន្ធ?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)">
		</td>
	</tr>
	<tr id="3.5.1-4">
		<td field="number" align="center"></td>
		<td field="indicator">Data quality assurance procedures are in place</td>
		<td field="question" class="en">What are the key challenges with validating malaria case surveillance data?</td>
		<td class="kh">តើមានបញ្ហាប្រឈមសំខាន់ៗអ្វីខ្លះទាក់ទងនឹងការផ្ទៀតផ្ទាត់គុណភាពទិន្នន័យជំងឺគ្រុនចាញ់?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. There are open positions for malaria surveillance staff</span>
					<span class="kh">A. មានមុខតំណែងបើកចំហសម្រាប់បុគ្គលិកតាមដានជំងឺគ្រុនចាញ់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Malaria surveillance staff positions are full, but there still are not enough staff</span>
					<span class="kh">B. មុខតំណែងបុគ្គលិកសម្រាប់តាមដានជំងឺគ្រុនចាញ់មានពេញអស់ហើយ ប៉ុន្ដែនៅតែមានបុគ្គលិកមិនគ្រប់គ្រាន់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. I'm required to do it even though it's not my assigned role</span>
					<span class="kh">C. ខ្ញុំតម្រូវអោយធ្វើវា បើទោះបីវាជាមិនមែនជាទំនួលខុសត្រូវខ្ញុំក៏ដោយ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">D. I have other responsibilities outside of malaria that take priority</span>
					<span class="kh">D. ខ្ញុំមានការងារអាទិភាពផ្សេងទៀតក្រៅពីការងារគ្រុនចាញ់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">E. I haven't received enough training to do it well</span>
					<span class="kh">E. ខ្ញុំមិនបានទទួលបានវគ្គបណ្ដុះបណ្ដាលគ្រប់គ្រាន់ដើម្បីធ្វើវាទេ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">F. The guidelines for this activity are not clear</span>
					<span class="kh">F. គោលការណ៍ណែនាំសម្រាប់សកម្មភាពនេះមិនច្បាស់លាស់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">G. It's too difficult/complicated</span>
					<span class="kh">G. វាពិបាក / ស្មុគស្មាញពេក</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">H. It takes too much time</span>
					<span class="kh">H. វាត្រូវការចំណាយពេលច្រើនពេក</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">I. Don't know</span>
					<span class="kh">I. មិនដឹង</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">J. Refusal</span>
					<span class="kh">J. ការបដិសេធ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">K. Other</span>
					<span class="kh">K. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.5.2">
		<td field="number" align="center"></td>
		<td field="indicator">Frequency of quality control</td>
		<td field="question" class="en">How often are data quality assurance activities usually performed?</td>
		<td class="kh">តើការអនុវត្តសកម្មភាពធានាគុណភាពទិន្នន័យជាធម្មតាត្រូវបានធ្វើញឹកញាប់ដែរឬទេ?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Monthly</span>
					<span class="kh">A. ប្រចាំខែ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Quarterly</span>
					<span class="kh">B. ប្រចាំត្រីមាស</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Yearly</span>
					<span class="kh">C. ប្រចាំឆ្នាំ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">D. Ad-hoc</span>
					<span class="kh">D. ធ្វើភ្លាមៗ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">E. Never</span>
					<span class="kh">E. មិនដែល</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">F. Other</span>
					<span class="kh">F. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.6.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Users with access</td>
		<td class="en">
			<span field="question">Do malaria staff here have access to the following?</span>
			<br /><br />
			A. Raw databases<br />
			B. Cleaned databases<br />
			C. Dashboards<br />
			D. Reports and/ or bulletins<br />
			E. Meetings where data summaries are presented and/ or discussed<br />
			F. Other
		</td>
		<td class="kh">
			តើបុគ្គលិកមន្រ្ដីគ្រុនចាញ់អាចចូលទៅប្រើប្រាស់ទិន្នន័យទាំងអស់នេះបានទេ?
			<br /><br />
			A. ទិន្នន័យលំអិតមិនទាន់វិភាគ<br />
			B. ទិន្នន័យដែលបានកែសំរួល<br />
			C. ទិន្នន័យលើ Dashboard<br />
			D. របាយការណ៍ ឬព្រឹត្តប័ត្រព័ត៏មាន<br />
			E. តាមការរាយការណ៍ពេលប្រជុំ<br />
			F. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Raw databases">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Cleaned databases">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Dashboards">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Reports and/ or bulletins">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Meetings where data summaries are presented and/ or discussed">
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
	<tr id="3.6.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Users with access</td>
		<td field="question" class="en">How do malaria staff access data?</td>
		<td class="kh">តើបុគ្គលិកមន្រ្ដីគ្រុនចាញ់ចូលទៅប្រើប្រាស់ទិន្នន័យគ្រុនចាញ់ដោយរបៀបណា?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Log-in</span>
					<span class="kh">A. ចូលប្រើប្រាស់តាមរយៈការបញ្ចូល ឈ្មោះ និង លេខសំងាត់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Manager shares</span>
					<span class="kh">B. អ្នកគ្រប់គ្រងចែករំលែក</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Data request</span>
					<span class="kh">C. ការស្នើរសុំទិន្នន័យ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">D. Don't know</span>
					<span class="kh">D. មិនដឹង</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">E. Other</span>
					<span class="kh">E. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="3.6.2-2">
		<td field="number" align="center"></td>
		<td field="indicator">Access frequency</td>
		<td class="en">
			<span field="question">How often, on average, have you accessed data in the previous 12 months? i.e. how often do you/did you request data, or how often to you login to view/ export data</span>
			<br /><br />
			A. Daily<br />
			B. Weekly<br />
			C. Monthly<br />
			D. Quarterly<br />
			E. Before DQA/MTR/supervision<br />
			F. Never<br />
			G. Don't know<br />
			H. Other
		</td>
		<td class="kh">
			ជាមធ្យម តើអ្នកបានចូលទៅប្រើទិន្នន័យញឹកញាប់ប៉ុណ្ណាក្នុងរយៈពេល 12 ខែមុន? ឧ. តើអ្នកបានស្នើសុំទិន្នន័យញឹកញាប់ប៉ុណ្ណា ឬញឹកញាប់ប៉ុណ្ណាដែលអ្នកចូលទៅ
			<br /><br />
			A. ប្រចាំថ្ងៃ<br />
			B. ប្រចាំសប្ដាហ៍<br />
			C. ប្រចាំខែ<br />
			D. ប្រចាំត្រីមាស<br />
			E. មុន DQA/MTR/ការចុះអភិបាល<br />
			F. មិនដែល<br />
			G. មិនដឹង<br />
			H. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Daily">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Weekly">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Monthly">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. Quarterly">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Before DQA/MTR/supervision">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Never">
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
	<tr id="1.3.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Data used for strategic, policy and operational processes</td>
		<td field="question" class="en">What strategic and operational processes have been informed by surveillance data in the previous 36 months?</td>
		<td class="kh">តើទិន្នន័យក្នុងប្រព័ន្ធ(MIS) ដែលបានយកទៅធ្វើផែនការ ឬប្រតិបត្តការណ៍អ្វីខ្លះក្នុងរយៈពេល៣ឆ្នាំចុងក្រោយ?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. Develop subnational operational plans</span>
					<span class="kh">A. បង្កើតផែនការប្រតិបត្តិការសម្រាប់ថ្នាក់ក្រោមជាតិ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Stratification for targeting and prioritising of intervention</span>
					<span class="kh">B. ការដាក់កម្រិតសម្រាប់កំណត់គោលដៅ និង អាទិភាពសម្រាប់ការអន្តរាគមន៍</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Advocate for a policy or program</span>
					<span class="kh">C. ការតស៊ូមតិសម្រាប់គោលនយោបាយ ឬកម្មវិធី</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">D. Monitor program performance/progress towards achieving national targets</span>
					<span class="kh">D. តាមដានការអនុវត្តកម្មវិធី ឬ វឌ្ឈនភាពឆ្ពោះទៅរកការសម្រេចគោលដៅសម្រាប់ថ្នាក់ជាតិ</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">E. Distribute commodities</span>
					<span class="kh">E. ការចែកចាយឪសថគ្រុនចាញ់</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">F. None</span>
					<span class="kh">F. គ្មាន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">G. Don't know</span>
					<span class="kh">G. មិនដឹង</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">H. Other</span>
					<span class="kh">H. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="1.3.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Data used for strategic, policy and operational processes</td>
		<td field="question" class="en">Is there routine review of data from proactive and reactive case detection to determine whether the approach is efficient and useful?</td>
		<td class="kh">តើមានការត្រួតពិនិត្យជាប្រចាំទៅលើទិន្នន័យបានមកពីការរកឃើញករណីសកម្ម និង ការរុករកទិន្នន័យសកម្មឡើងវិញដែរឬទេ? ដើម្បីកំណត់ថាតើវិធីសាស្រ្ដនោះមានប្រសិទ្ធភាព និងមានប្រយោជន៍</td>
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
					<span class="kh">B. មិនមាន</span>
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
	<tr id="1.3.2">
		<td field="number" align="center"></td>
		<td field="indicator">Data used for decisions to improve the surveillance system</td>
		<td class="en">
			<span field="question">Have you or someone at this facility/district/etc. used malaria surveillance data to improve malaria surveillance in the following ways in the previous 12 months?</span>
			<br /><br />
			A. Made improvements to feedback or supervision processes<br />
			B. Made improvements to data quality, completeness, timeliness and consistency<br />
			C. Initiated trainings or other surveillance staff capacity development including data analysis and use<br />
			D. None<br />
			E. Other<br />
		</td>
		<td class="kh">
			តើមានអ្នក ឬនរណាម្នាក់នៅ មណ្ឌលសុខភាព/ស្រុកប្រតិបត្តិ ដែលបានប្រើទិន្នន័យតាមដានជំងឺគ្រុនចាញ់ ដើម្បីកែលម្អការតាមដានជំងឺគ្រុនចាញ់តាមវិធីខាងក្រោមក្នុងរយៈពេល 12 ខែមុនដែរឬទេ?
			<br /><br />
			A. បានធ្វើឱ្យប្រសើរឡើងចំពោះមតិកែលម្អ ឬដំណើរការត្រួតពិនិត្យ<br />
			B. មានការកែលម្អគុណភាពទិន្នន័យ, ភាពពេញលេញនៃទិន្នន័យ, ភាពទាន់ពេលវេលា និងភាពជាប់លាប់នៃទិន្នន័យ<br />
			C. ការផ្ដួចផ្ដើមក្នុងការបណ្តុះបណ្តាល ឬការអភិវឌ្ឍន៍សមត្ថភាពបុគ្គលិកតាមដានជំងឺគ្រុនចាញ់ផ្សេងទៀត រួមទាំងការវិភាគទិន្នន័យ និងការប្រើប្រាស់ទិន្នន័យ<br />
			D. មិនមាន<br />
			E. ផ្សេងៗ
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Made improvements to feedback or supervision processes">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Made improvements to data quality, completeness, timeliness and consistency">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Initiated trainings or other surveillance staff capacity development including data analysis and use">
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
	<tr id="1.3.3">
		<td field="number" align="center"></td>
		<td field="indicator">Data reviewed for monitoring</td>
		<td field="question" class="en">How many data review meetings were held in the previous year?</td>
		<td class="kh">តើមានកិច្ចប្រជុំត្រួតពិនិត្យទិន្នន័យចំនួនប៉ុន្មានដងដែលត្រូវបានធ្វើឡើងកាលពីឆ្នាំមុន?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)" numonly="int">
		</td>
	</tr>
	<tr id="1.3.4-1">
		<td field="number" align="center"></td>
		<td field="indicator">Data are used to produce routine outputs</td>
		<td field="question" class="en">How many expected monthly bulletins were produced in the previous year?</td>
		<td class="kh">តើព្រឹត្តិបត្រប្រចាំខែ(bulletins) ដែលត្រូវបានគេរំពឹងទុកចំនួនប៉ុន្មានត្រូវបានធ្វើក្នុងឆ្នាំមុន?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)" numonly="int">
		</td>
	</tr>
	<tr id="1.3.4-2">
		<td field="number" align="center"></td>
		<td field="indicator">Data are used to produce routine outputs</td>
		<td field="question" class="en">How many expected weekly malaria epidemic monitoring graphs were produced in the previous year? (Please indicate weekly in the response)</td>
		<td class="kh">តើក្រាហ្វបង្ហាញទិន្នន័យតាមដានការផ្ទុះជំងឺគ្រុនចាញ់ប្រចាំសប្តាហ៍ដែលរំពឹងទុកប៉ុន្មានត្រូវបានធ្វើក្នុងឆ្នាំមុន? (សូមបញ្ជាក់រាល់សប្តាហ៍ប្ក្នុងការឆ្លើយតប)</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)" numonly="int">
		</td>
	</tr>
	<tr id="1.3.4-3">
		<td field="number" align="center"></td>
		<td field="indicator">Data are used to produce routine outputs</td>
		<td field="question" class="en">How many expected monthly malaria epidemic monitoring graphs were produced in the previous year? (Please indicate monthy in the response)</td>
		<td class="kh">តើក្រាហ្វបង្ហាញទិន្នន័យតាមដានការផ្ទុះជំងឺគ្រុនចាញ់ប្រចាំខែដែលរំពឹងទុកប៉ុន្មានត្រូវបានធ្វើក្នុងឆ្នាំមុន? (សូមបញ្ជាក់រាល់ប្រចាំខែក្នុងការឆ្លើយតប)</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)" numonly="int">
		</td>
	</tr>
	<tr id="1.3.7">
		<td field="number" align="center"></td>
		<td field="indicator">Challenges to data use</td>
		<td field="question" class="en">In your opinion, what are the challenges in use of data from malaria-related surveillance for decision-making?</td>
		<td class="kh">បើតាមគំនិតរបស់អ្នក, តើបញ្ហាប្រឈមអ្វីខ្លះក្នុងការប្រើប្រាស់ទិន្នន័យពីការឃ្លាំមើលទាក់ទងនឹងជំងឺគ្រុនចាញ់ក្នុងការធ្វើការការសម្រេចចិត្ត?</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">A. The data required is not available</span>
					<span class="kh">A. ទិន្នន័យដែលចង់បានមិនមាន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">B. Poor data quality/Data are not trusted</span>
					<span class="kh">B. ទិន្នន័យមិនមានគុណភាព ឬ ទិន្នន័យដែលមិនអាចទុកចិត្តបាន</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)">
					<span class="en">C. Surveillance staff are not trained to interpret and use data</span>
					<span class="kh">C. បុគ្គលិកតាមដានជំងឺគ្រុនចាញ់មិនត្រូវបានបណ្ដុះបណ្ដាលគ្រប់គ្រាន់ដើម្បីបកស្រាយទិន្នន័យ និង ប្រើទិន្នន័យ</span>
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
	<tr id="4.1.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Governance structure in place</td>
		<td field="question" class="en">Do you have a list of monitoring indicators for review of subnational implementation activities?</td>
		<td class="kh">តើអ្នកមានបញ្ជីសូចនាករសម្រាប់តាមដានពិនិត្យសកម្មភាពអនុវត្តថ្នាក់ក្រោមជាតិដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes (copy shown)</span>
					<span class="kh">A. មាន (ច្បាប់ចម្លងត្រូវបានបង្ហាញ)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Yes (copy not shown)</span>
					<span class="kh">B.  មាន (ច្បាប់ចម្លងមិនត្រូវបានបង្ហាញ)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. No</span>
					<span class="kh">C. មិនមាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. Don't know</span>
					<span class="kh">D. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.1.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Governance structure in place</td>
		<td field="question" class="en">What other governance structures are in place for malaria surveillance?</td>
		<td class="kh">តើមានរចនាសម្ព័ន្ធរដ្ឋផ្សេងទៀតក្នុងការប្រមូលទិន្នន័យ និងតាមដានជំងឺគ្រុនចាញ់?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)">
		</td>
	</tr>
	<tr id="4.2.1">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff are encouraged to use data</td>
		<td field="question" class="en text-bold">Read each statement below and indicate to what extent you agree or disagree with the statement</td>
		<td class="kh text-bold">សូមអានចំណុចៗខាងក្រោមនេះ ហើយបង្ហាញពីកម្រិតណាដែលអ្នកយល់ស្រប ឬមិនយល់ស្របទៅតាមឃ្លានីមួយៗ</td>
		<td field="answer"></td>
	</tr>
	<tr id="4.2.1.1">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff are encouraged to use data</td>
		<td field="question" class="en">The {MoH/HI/NMP/ other governance or organization} advocates for use of information at all levels of the health system</td>
		<td class="kh">តើអ្នកឬបុគ្គលិកដទៃទៀតមានផ្តល់មតិក្នុងការប្រើប្រាស់ព័ត៌មានគ្រុនចាញ់ទៅគ្រប់កំរិតដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (strongly agree)</span>
					<span class="kh">A. (យល់ស្របខ្លាំង)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (agree)</span>
					<span class="kh">B. (យល់ស្រប)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (neutral)</span>
					<span class="kh">C. (អព្យាក្រឹត)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (disagree)</span>
					<span class="kh">D. (មិនយល់ស្រប)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (strongly disagree)</span>
					<span class="kh">E. (មិនយល់ស្របខ្លាំង)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.2.1.2">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff are encouraged to use data</td>
		<td field="question" class="en">The {MoH/HI/NMP/ other governance or organization} promotes feedback to and from surveillance staff</td>
		<td class="kh">តើអ្នកឬបុគ្គលិកដទៃទៀតមានផ្តល់មតិកែតម្រូវពីការប្រើប្រាស់ព័ត៌មានគ្រុនចាញ់ទៅគ្រប់កំរិតដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (strongly agree)</span>
					<span class="kh">A. (យល់ស្របខ្លាំង)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (agree)</span>
					<span class="kh">B. (យល់ស្រប)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (neutral)</span>
					<span class="kh">C. (អព្យាក្រឹត)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (disagree)</span>
					<span class="kh">D. (មិនយល់ស្រប)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (strongly disagree)</span>
					<span class="kh">E. (មិនយល់ស្របខ្លាំង)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.2.1.3">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff are encouraged to use data</td>
		<td field="question" class="en">The {MoH/HI/NMP/ other governance or organization} empowers me/surveillance staff to ask questions, learn, and improve</td>
		<td class="kh">តើថ្នាក់លើមានលើកទឹកចិត្តដល់អ្នកក្នុងការសួរ ឬធ្វើឱ្យប្រសើរឡើងប្រព័ន្ធគ្រុនចាញ់ដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (strongly agree)</span>
					<span class="kh">A. (យល់ស្របខ្លាំង)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (agree)</span>
					<span class="kh">B. (យល់ស្រប)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (neutral)</span>
					<span class="kh">C. (អព្យាក្រឹត)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (disagree)</span>
					<span class="kh">D. (មិនយល់ស្រប)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (strongly disagree)</span>
					<span class="kh">E. (មិនយល់ស្របខ្លាំង)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.3.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision plan in place</td>
		<td field="question" class="en">Do you have proper surveillance supervision documentation available here?</td>
		<td class="kh">តើអ្នកមានឯកសារត្រួតពិនិត្យការងារចុះអភិបាលរតាមដានជំងឺគ្រុនចាញ់ត្រឹមត្រូវដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. មាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. No</span>
					<span class="kh">C. មិនមាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. Don't Know</span>
					<span class="kh">D. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.3.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision plan in place</td>
		<td field="question" class="en">Do you have proper surveillance supervision documentation* available here? Please show or provide copies:</td>
		<td class="kh">
			តើអ្នកមានឯកសារត្រួតពិនិត្យការងារចុះអភិបាលរតាមដានជំងឺគ្រុនចាញ់ត្រឹមត្រូវដែរឬទេ? សូមបង្ហាញ ឬផ្តល់ច្បាប់ចម្លង៖
			* ឯកសារត្រួតពិនិត្យការឃ្លាំមើលគួរតែរួមបញ្ចូលការណែនាំអំពីការគ្រប់គ្រង និងបញ្ជីត្រួតពិនិត្យណាមួយ ក៏ដូចជាកាលវិភាគសម្រាប់ការងារចុះអភិបាលត្រួតពិនិត្យតាមដានការងារគ្រុនចាញ់
		</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes (copy shown)</span>
					<span class="kh">A. មាន (ច្បាប់ចម្លងត្រូវបានបង្ហាញ)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Yes (copy not shown)</span>
					<span class="kh">B. មាន (ច្បាប់ចម្លងមិនត្រូវបានបង្ហាញ)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. No</span>
					<span class="kh">C. មិនមាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. Don't Know</span>
					<span class="kh">D. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.3.1-3">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision plan in place</td>
		<td field="question" class="en">Are all supervision activities carried out as per guideance/checklist?</td>
		<td class="kh">តើសកម្មភាពចុះអភិបាលទាំងអស់ត្រូវបានអនុវត្តតាមការណែនាំ ឬបញ្ជីត្រួតពិនិត្យដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A.  អនុវត្ត</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B.  មិនអនុវត្ត</span>
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
	<tr id="4.3.1-4">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision plan in place</td>
		<td field="question" class="en">If not provide reasons why</td>
		<td class="kh">ប្រសិនបើមិនអនុវត្ត សូមផ្ដល់មូលហេតុ</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)">
		</td>
	</tr>
	<tr id="4.3.1-5">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision plan in place</td>
		<td field="question" class="en">Do you know who to ask for support for surveillance tasks?</td>
		<td class="kh">តើអ្នកដឹងថាអ្នកណាត្រូវសុំជំនួយសម្រាប់កិច្ចការតាមដានជំងឺគ្រុនចាញ់ដែរឬទេ?</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. ដឹង</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. មិនដឹង</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.3.1-6">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision plan in place</td>
		<td field="question" class="en">What do you do when you have issues or problems with your routine surveillance tasks?</td>
		<td class="kh">តើអ្នកធ្វើអ្វីនៅពេលមានបញ្ហា ឬក៏បញ្ហាដែលអ្នកតែងតែកើតមានក្នុងការងារតាមដានជំងឺគ្រុនចាញ់របស់អ្នក?</td>
		<td field="answer">
			<input type="text" class="form-control form-group" data-bind="textInput: getAnswer($element)">

			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Refusal</span>
					<span class="kh">A. បដិសេធ</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. Don't Know</span>
					<span class="kh">B. មិនដឹង</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. Other</span>
					<span class="kh">C. ផ្សេងៗ</span>
				</label>
			</div>
			<div class="input-group mt-5" style="display: none">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="4.3.3-1">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision visit quality</td>
		<td field="question" class="en">During the previous supervision visit, the supervisor checked data quality (using a checklist or other outlined procedure)</td>
		<td class="kh">ក្នុងអំឡុងពេលចុះអភិបាលលើកមុន, អ្នកត្រួតពិនិត្យបានពិនិត្យគុណភាពទិន្នន័យ (ដោយប្រើបញ្ជីត្រួតពិនិត្យ ឬ នីតិវិធីដែលបានគូសបញ្ជាក់ផ្សេងទៀត</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. មាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. មិនមាន</span>
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
	<tr id="4.3.3-2">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision visit quality</td>
		<td field="question" class="en">During the previous supervision visit, the supervisor discussed your health facility's performance based on the data quality</td>
		<td class="kh">ក្នុងអំឡុងពេលចុះអភិបាលលើកមុន, អ្នកត្រួតពិនិត្យបានពិភាក្សាអំពីការអនុវត្តការងាររបស់បុគ្គលិកមណ្ឌលសុខភាពដោយផ្អែកលើគុណភាពទិន្នន័យ</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Yes</span>
					<span class="kh">A. មាន</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. No</span>
					<span class="kh">B. មិនមាន</span>
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
	<tr id="4.3.3-3">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision visit quality</td>
		<td field="question" class="en">During the previous supervision visit, the supervisor helped you to take corrective action based on the data quality</td>
		<td class="kh">ក្នុងអំឡុងពេលចុះអភិបាលលើកមុន, អ្នកត្រួតពិនិត្យបានជួយអ្នកក្នុងការកែតម្រូវគុណភាពទិន្នន័យ</td>
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
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. Not applicable</span>
					<span class="kh">D. មិនអាចអនុវត្តបាន</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.3.3-4">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision visit quality</td>
		<td field="question" class="en">The supervisor sent a report/ written feedback after the previous supervision visit</td>
		<td class="kh">អ្នកចុះអភិបាលបានផ្ញើររបាយការណ៍ ឬព័ត៌មានត្រឡប់ទៅវិញទេបន្ទាប់ពីចុះអភិបាលលើកមុនរួច?</td>
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
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. Not applicable</span>
					<span class="kh">D. មិនអាចអនុវត្តបាន</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.1-1">
		<td field="number" align="center"></td>
		<td field="indicator">Training</td>
		<td field="question" class="en">Have you received surveillance training in the previous year?</td>
		<td class="kh">តើ {អ្នក/ បុគ្គលិកតាមដានជំងឺគ្រុនចាញ់របស់អ្នក/ បុគ្គលិកតាមដានជំងឺគ្រុនចាញ់ទាំងអស់នៅគ្រប់កម្រិត/បុគ្គលិកមណ្ឌលសុខភាព} បានទទួលការបណ្ដុះបណ្ដាលផ្នែកតាមដានជំងឺគ្រុនចាញ់កាលពីឆ្នាំមុនៗដែរឬទេ?</td>
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
	<tr id="4.4.1-2">
		<td field="number" align="center"></td>
		<td field="indicator">Training</td>
		<td class="en">
			<span field="question">What surveillance activities were covered in the training?</span>
			<br><br>
			A. Data collection (recording patient information)<br>
			B. Data reporting (compiling malaria case reports)<br>
			C. Conducting data quality review of malaria case data<br>
			D. Conducting data analysis of malaria case data and data use<br>
			E. Preparing dissemination reports (such as bulletin, newsletters, feedback reports)<br>
			F. Supervision<br>
			G. Case notification<br>
			H. Don't know<br>
			I. Other
		</td>
		<td class="kh">
			តើសកម្មភាពតាមដានជំងឺគ្រុនចាញ់អ្វីខ្លះ ដែលបានយកទៅបង្រៀនក្នុងវគ្គបណ្ដុះបណ្ដាល?
			<br><br>
			A. ការប្រមូលទិន្នន័យ (បញ្ចូលព័ត៌មានអ្នកជំងឺ)<br>
			B. ការរាយការណ៍ទិន្នន័យ (របាយការណ៍ករណីជំងឺគ្រុនចាញ់)<br>
			C. ធ្វើការត្រួតពិនិត្យគុណភាពទិន្នន័យករណីជំងឺគ្រុនចាញ់<br>
			D. ធ្វើការវិភាគទិន្នន័យជំងឺគ្រុនចាញ់ និងការប្រើប្រាស់ទិន្នន័យ<br>
			E. ការរៀបចំរបាយការណ៍ផ្សព្វផ្សាយ (ដូចជាព្រឹត្តិបត្រ, ព្រឹត្តិបត្រព័ត៌មាន, របាយការណ៍មតិកែលម្អ)<br>
			F. ការចុះអភិបាល<br>
			G. ការជូនដំណឹងពីការមានករណីគ្រុនចាញ់<br>
			H. មិនដឹង<br>
			I. ផ្សេងៗ
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
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Preparing dissemination reports (such as bulletin, newsletters, feedback reports)">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Supervision">
					<span>F</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="G. Case notification">
					<span>G</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="H. Don't know">
					<span>H</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="I. Other">
					<span>I</span>
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
					<span class="kh">A. (មិនអាច)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (Able 25%)</span>
					<span class="kh">B. (អាច 25%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (Able 50%)</span>
					<span class="kh">C. (អាច 50%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (Able 75%)</span>
					<span class="kh">D. (អាច 75%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (Very confident in my abilities)</span>
					<span class="kh">E. (ជឿជាក់ខ្លាំងលើសមត្ថភាពរបស់ខ្ញុំ)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.3-4">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en">I am confident in my ability to perform data quality checks</td>
		<td class="kh">ខ្ញុំជឿជាក់លើសមត្ថភាពរបស់ខ្ញុំក្នុងការត្រួតពិនិត្យទិន្នន័យ</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (Not able)</span>
					<span class="kh">A. (មិនអាច)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (Able 25%)</span>
					<span class="kh">B. (អាច 25%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (Able 50%)</span>
					<span class="kh">C. (អាច 50%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (Able 75%)</span>
					<span class="kh">D. (អាច 75%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (Very confident in my abilities)</span>
					<span class="kh">E. (ជឿជាក់ខ្លាំងលើសមត្ថភាពរបស់ខ្ញុំ)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.3-5">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en">I am confident in my ability to calculate malaria indicators</td>
		<td class="kh">ខ្ញុំជឿជាក់លើសមត្ថភាពរបស់ខ្ញុំក្នុងការគណនាសូចនាករជំងឺគ្រុនចាញ់</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (Not able)</span>
					<span class="kh">A. (មិនអាច)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (Able 25%)</span>
					<span class="kh">B. (អាច 25%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (Able 50%)</span>
					<span class="kh">C. (អាច 50%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (Able 75%)</span>
					<span class="kh">D. (អាច 75%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (Very confident in my abilities)</span>
					<span class="kh">E. (ជឿជាក់ខ្លាំងលើសមត្ថភាពរបស់ខ្ញុំ)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.3-6">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en">I am confident in my ability to prepare data visuals of malaria indicators</td>
		<td class="kh">ខ្ញុំជឿជាក់លើសមត្ថភាពរបស់ខ្ញុំក្នុងការរៀបចំទិន្នន័យជារបារ រឺ ជាក្រាហ្វសម្រាប់សូចនាករជំងឺគ្រុនចាញ់</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (Not able)</span>
					<span class="kh">A. (មិនអាច)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (Able 25%)</span>
					<span class="kh">B. (អាច 25%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (Able 50%)</span>
					<span class="kh">C. (អាច 50%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (Able 75%)</span>
					<span class="kh">D. (អាច 75%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (Very confident in my abilities)</span>
					<span class="kh">E. (ជឿជាក់ខ្លាំងលើសមត្ថភាពរបស់ខ្ញុំ)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.3-7">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en">I am confident in my ability to interpret malaria data</td>
		<td class="kh">ខ្ញុំជឿជាក់លើសមត្ថភាពរបស់ខ្ញុំក្នុងការបកស្រាយទិន្នន័យជំងឺគ្រុនចាញ់</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (Not able)</span>
					<span class="kh">A. (មិនអាច)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (Able 25%)</span>
					<span class="kh">B. (អាច 25%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (Able 50%)</span>
					<span class="kh">C. (អាច 50%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (Able 75%)</span>
					<span class="kh">D. (អាច 75%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (Very confident in my abilities)</span>
					<span class="kh">E. (ជឿជាក់ខ្លាំងលើសមត្ថភាពរបស់ខ្ញុំ)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.3-8">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en">I am confident in my ability to use information for problem solving or making decisions</td>
		<td class="kh">ខ្ញុំជឿជាក់លើសមត្ថភាពរបស់ខ្ញុំក្នុងការប្រើប្រាស់ទិន្នន័យគ្រុនចាញ់សម្រាប់ដោះស្រាយបញ្ហា ឬធ្វើការសម្រេចចិត្តនានា</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. (Not able)</span>
					<span class="kh">A. (មិនអាច)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">B. (Able 25%)</span>
					<span class="kh">B. (អាច 25%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">C. (Able 50%)</span>
					<span class="kh">C. (អាច 50%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">D. (Able 75%)</span>
					<span class="kh">D. (អាច 75%)</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">E. (Very confident in my abilities)</span>
					<span class="kh">E. (ជឿជាក់ខ្លាំងលើសមត្ថភាពរបស់ខ្ញុំ)</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="4.4.4">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff knowledge</td>
		<td field="question" class="en">What are the reasons or objective for malaria surveillance? Please list at least three reasons for collecting or using malaria surveillance data</td>
		<td class="kh">តើមូលហេតុ ឬគោលបំណងអ្វីខ្លះសម្រាប់ការងារតាមដានជំងឺគ្រុនចាញ់? សូមរាយបញ្ជីហេតុផលយ៉ាងតិច៣សម្រាប់ការប្រមូល ឬប្រើប្រាស់ទិន្នន័យតាមដានជំងឺគ្រុនចាញ់</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)">
		</td>
	</tr>
</tbody>