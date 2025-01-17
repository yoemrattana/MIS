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
			<br /><br />
			A. Yes on MIS dashboard<br />
			B. Yes I made it myself on Excel or other<br />
			C. No
		</td>
		<td class="kh">
			តើអ្នកអាចមើលទិន្នន័យជា របារ រឺ ក្រាហ្វិក តាមមធ្យោបាយណា?
			<br /><br />
			A. មើលនៅលើ MIS Dashboard<br />
			B. ធ្វើខ្លួនឯង លើកម្មវិធី Excel ឬកម្មវិធីផ្សេង<br />
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
	<tr id="2.3.1">
		<td field="number" align="center"></td>
		<td field="indicator">Guideline availability</td>
		<td class="en">
			<span field="question">Are there national guidelines for surveillance?</span>
			<br /><br />
			A. Yes<br />
			B. Yes, on the internet (check internet connectivity and accessibility)<br />
			C. Yes, in a manual or other reference document<br />
			D. No<br />
			E. Don't know
		</td>
		<td class="kh">
			តើអ្នកមានសៀវភៅ គោលការណ៍ណែនាំថ្នាក់ជាតិសម្រាប់ការតាមដានជំងឺគ្រុនចាញ់ដែរឬទេ?
			<br /><br />
			A. មាន<br />
			B. មាន ក្នុងបណ្តាញអ៊ិនធើណែត<br />
			C. មាន នៅក្នុងឯកសារដទៃ<br />
			D. មិនមាន<br />
			E. មិនដឹង
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Yes">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Yes, on the internet (check internet connectivity and accessibility)">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Yes, in a manual or other reference document">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. No">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Don't know">
					<span>E</span>
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
		<td class="en">
			<span field="question">Have you experienced infrastructure failure within the last 30 days?</span>
			<br /><br />
			A. Internet connectivity<br />
			B. Cellular service/data<br />
			C. Electricity<br />
			D. No<br />
			E. Don't know
		</td>
		<td class="kh">
			នៅក្នុងរយៈពេល 30 ថ្ងៃចុងក្រោយនេះ តើអ្នកធ្លាប់ជួបប្រទះ បង្ហាដំណើរការមិនល្អលើ៖
			<br /><br />
			A. ការតភ្ជាប់អ៊ីនធឺណិត<br />
			B. សេវាទូរស័ព្ទចល័ត<br />
			C. ដាច់អគ្គិសនី<br />
			D. មិនមានបញ្ហា<br />
			E. មិនដឹង
		</td>
		<td field="answer">
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="A. Internet connectivity">
					<span>A</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="B. Cellular service/data">
					<span>B</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="C. Electricity">
					<span>C</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="D. No">
					<span>D</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Don't know">
					<span>E</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="2.4.4">
		<td field="number" align="center"></td>
		<td field="indicator">Documented resource allocation and troubleshooting</td>
		<td field="question" class="en">Do you have someone to ask about troubleshooting resource availability (Register book, phone, etc.)?</td>
		<td class="kh">តើអ្នកដឹងថាមានអ្នកណា ដែលអាចដោះស្រាយបាន (លើបញ្ហាខ្វះ form រាយការណ៍ស្តុក, ទូរស័ព្ទ ឬ tablet ដែលដំណើការមិនល្អ)</td>
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
		<td class="kh">អ្នកប្រមូលទិន្នន័យសង្កេតមើល៖ តើគាត់កំពុងប្រើ ឧបករណ៍ស្ដង់ដារ ដែលបានបង្កើតឡើងដោយកម្មវិធីជាតិ?</td>
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
		<td class="kh">ចំពោះចំណុចៗខាងក្រោមនេះ តើអ្នកយល់កម្រិតណា ឬអ្នកមិនយល់?<br />អថេរនៅក្នុង Surveillance Form មានដូចជា (HC Book, VMW Book, RCD, Investigation, Foci, Last Mile)</td>
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
		<td class="kh">ខ្ញុំស្គាល់អ្នកត្រូវសួរ ឬដឹងឯកសារយោង សម្រាប់ដោះស្រាយបញ្ហាកត់ត្រាទិន្នន័យ</td>
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
	<tr id="3.3.4-1">
		<td field="number" align="center"></td>
		<td field="indicator">Reporting process adheres to WHO recommendation</td>
		<td class="en">
			<span field="question">What type of data is reported?</span>
			<br /><br />
			A. Case based data<br />
			B. Aggregate data
		</td>
		<td class="kh">
			តើទិន្នន័យប្រភេទណាដែលត្រូវរាយការណ៍?
			<br /><br />
			A. ទិន្នន័យអ្នកជំងឺម្នាក់ៗ<br />
			B. ទិន្នន័យសរុប
		</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick" value="A. Case based data">
					<span>A</span>
				</label>
			</div>
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick" value="B. Aggregate data">
					<span>B</span>
				</label>
			</div>
		</td>
	</tr>
	<tr id="3.3.4-2">
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
	<tr id="3.4.1">
		<td field="number" align="center"></td>
		<td field="indicator">Number of expected outputs from routine analysis</td>
		<td field="question" class="en">Which expected outputs from routine analysis do you receive?</td>
		<td class="kh">តើគិតថាលទ្ធផលពីការវិភាគទិន្នន័យមានប្រយោជន៍អ្វៅខ្លះ (Dashboard in App)?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)">
		</td>
	</tr>
	<tr id="3.4.3">
		<td field="number" align="center"></td>
		<td field="indicator">Perceived complexity of routine analysis process</td>
		<td field="question" class="en">I understand data elements/ variables/ indicators that should be calculated for malaria surveillance routine analysis</td>
		<td class="kh">ខ្ញុំដឺងពីអថេរ ទិន្នន័យ សូចនាករ ដែលគួរយកមកគណនា សម្រាប់ការវិភាគទិន្នន័យតាមដានជំងឺគ្រុនចាញ់</td>
		<td field="answer">
			<div class="radio radio-lg">
				<label>
					<input type="radio" data-bind="checked: getAnswer($element), click: radioClick">
					<span class="en">A. Understand</span>
					<span class="kh">A. ដឹង</span>
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
	<tr id="3.6.1">
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
	<tr id="3.6.2">
		<td field="number" align="center"></td>
		<td field="indicator">Access frequency</td>
		<td class="en">
			<span field="question">How often, on average, have you accessed data in the previous 12 months? i.e. how often do you/did you request data, or how often to you login to view/ export data</span>
			<br /><br />
			A. Daily<br />
			B. Weekly<br />
			C. Monthly<br />
			D. Quarterly<br />
			E. Never<br />
			F. Don't know<br />
			G. Other
		</td>
		<td class="kh">
			ក្នុងរយៈពេល 12 ខែមុន តើអ្នកបានចូលទៅប្រើទិន្នន័យញឹកញាប់ប៉ុណ្ណា? ឧ. តើអ្នកបានស្នើសុំទិន្នន័យញឹកញាប់ប៉ុណ្ណា ឬញឹកញាប់ប៉ុណ្ណាដែលអ្នកចូលប្រើ
			<br /><br />
			A. ប្រចាំថ្ងៃ<br />
			B. ប្រចាំសប្ដាហ៍<br />
			C. ប្រចាំខែ<br />
			D. ប្រចាំត្រីមាស<br />
			E. មិនដែល<br />
			F. មិនដឹង<br />
			G. ផ្សេងៗ
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
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="E. Never">
					<span>E</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="F. Don't know">
					<span>F</span>
				</label>
			</div>
			<div class="checkbox checkbox-lg">
				<label>
					<input type="checkbox" data-bind="checked: getAnswer($element)" value="G. Other">
					<span>G</span>
				</label>
			</div>
			<div class="input-group mt-5">
				<span class="input-group-addon en">Specify</span>
				<span class="input-group-addon kh">សូមបញ្ជាក់</span>
				<input type="text" class="form-control" data-bind="value: getAnswer($element,'specify')">
			</div>
		</td>
	</tr>
	<tr id="1.3.1">
		<td field="number" align="center"></td>
		<td field="indicator">Data used for strategic, policy and operational processes</td>
		<td field="question" class="en">Is there routine review of data from proactive and reactive case detection to determine whether the approach is efficient and useful?</td>
		<td class="kh">តើការត្រួតពិនិត្យទិន្នន័យជាប្រចាំ (ទិន្នន័យរុករកបែប Proactive & Active) អាចអោយយើងដឹងពី ប្រសិទ្ធភាពនៃការអនុវត្តសកម្មភាព</td>
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
	<tr id="1.3.3">
		<td field="number" align="center"></td>
		<td field="indicator">Data reviewed for monitoring</td>
		<td field="question" class="en">How many data review meetings were held in the previous year?</td>
		<td class="kh">តើមានកិច្ចប្រជុំ (យកទិន្នន័យមកប្រើ) ចំនួនប៉ុន្មានដងដែលត្រូវបានធ្វើឡើងកាលពីឆ្នាំមុន?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)" numonly="int">
		</td>
	</tr>
	<tr id="1.3.4">
		<td field="number" align="center"></td>
		<td field="indicator">Data are used to produce routine outputs</td>
		<td field="question" class="en">How many expected monthly bulletins were produced in the previous year?</td>
		<td class="kh">តើអ្នកបានទាញយក ព្រឹត្តិបត្រប្រចាំខែ( ពីMIS)  ចំនួនប៉ុន្មាន ក្នុងឆ្នាំមុន?</td>
		<td field="answer">
			<input type="text" class="form-control" data-bind="value: getAnswer($element)" numonly="int">
		</td>
	</tr>
	<tr id="1.3.7">
		<td field="number" align="center"></td>
		<td field="indicator">Challenges to data use</td>
		<td field="question" class="en">In your opinion, what are the challenges in use of data from malaria-related surveillance for decision-making?</td>
		<td class="kh">បើតាមគំនិតរបស់អ្នក, តើបញ្ហាប្រឈមអ្វីខ្លះ ក្នុងការប្រើប្រាស់ទិន្នន័យជំងឺគ្រុនចាញ់ ដើម្បីធ្វើការការសម្រេចចិត្តក្នុងការអនុវត្ត?</td>
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
	<tr id="4.3.1">
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
	<tr id="4.3.3-1">
		<td field="number" align="center"></td>
		<td field="indicator">Supervision visit quality</td>
		<td field="question" class="en">During the previous supervision visit, the supervisor checked data quality (using a checklist or other outlined procedure)</td>
		<td class="kh">ក្នុងអំឡុងពេលចុះអភិបាលលើកមុន, អ្នកត្រួតពិនិត្យបានប្រើបញ្ជីត្រួតពិនិត្យ (Checklist) ឬ នីតិវិធីផ្សេងទៀត</td>
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
		<td class="kh">អ្នកចុះអភិបាលបាន ផ្តល់ព័ត៌មានត្រឡប់ បន្ទាប់ពីចុះអភិបាល?</td>
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
		<td class="kh">តើ អ្នក ឬបុគ្គលិកតាមដានជំងឺគ្រុនចាញ់របស់អ្នកបានទទួលការបណ្ដុះបណ្ដាលផ្នែកតាមដានជំងឺគ្រុនចាញ់កាលពីឆ្នាំមុនៗដែរឬទេ?</td>
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
			<br /><br />
			A. Data collection (recording patient information)<br />
			B. Data reporting (compiling malaria case reports)<br />
			C. Conducting data quality review of malaria case data<br />
			D. Conducting data analysis of malaria case data and data use<br />
			E. Preparing dissemination reports (such as bulletin, newsletters, feedback reports)<br />
			F. Supervision<br />
			G. Case notification<br />
			H. Don't know<br />
			I. Other
		</td>
		<td class="kh">
			តើសកម្មភាពតាមដានជំងឺគ្រុនចាញ់អ្វីខ្លះ ដែលបានយកទៅបង្រៀនក្នុងវគ្គបណ្ដុះបណ្ដាល?
			<br /><br />
			A. ការប្រមូលទិន្នន័យ (បញ្ចូលព័ត៌មានអ្នកជំងឺ)<br />
			B. ការរាយការណ៍ទិន្នន័យ (របាយការណ៍ករណីជំងឺគ្រុនចាញ់)<br />
			C. ធ្វើការត្រួតពិនិត្យគុណភាពទិន្នន័យករណីជំងឺគ្រុនចាញ់<br />
			D. ធ្វើការវិភាគទិន្នន័យជំងឺគ្រុនចាញ់ និងការប្រើប្រាស់ទិន្នន័យ<br />
			E. ការរៀបចំរបាយការណ៍ផ្សព្វផ្សាយ (ដូចជាព្រឹត្តិបត្រ, ព្រឹត្តិបត្រព័ត៌មាន, របាយការណ៍មតិកែលម្អ)<br />
			F. ការចុះអភិបាល<br />
			G. ការជូនដំណឹងពីការមានករណីគ្រុនចាញ់<br />
			H. មិនដឹង<br />
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
	<tr id="4.4.3">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en text-bold">Read each statement below and indicate to what extent you agree or disagree with the statement</td>
		<td class="kh text-bold">សូមអានចំណុចៗខាងក្រោមនេះ ហើយបង្ហាញពីកម្រិតណាដែលអ្នកយល់ស្រប ឬមិនយល់ស្របទៅតាមឃ្លានីមួយៗ</td>
		<td field="answer"></td>
	</tr>
	<tr id="4.4.3.1">
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
	<tr id="4.4.3.2">
		<td field="number" align="center"></td>
		<td field="indicator">Surveillance staff perceived abilities</td>
		<td field="question" class="en">I am confident in my ability to report malaria data to the district/etc.</td>
		<td class="kh">ខ្ញុំជឿជាក់លើសមត្ថភាពរបស់ខ្ញុំក្នុងការរាយការណ៍ករណីគ្រុនចាញ់ទៅកាន់ថ្នាក់ស្រុក</td>
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
	<tr id="4.4.3.3">
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
	<tr id="4.4.3.4">
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
	<tr id="4.4.3.5">
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
	<tr id="4.4.3.6">
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
	<tr id="4.4.3.7">
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
</tbody>