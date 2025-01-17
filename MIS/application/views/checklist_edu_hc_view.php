<div class="kh divcenter" data-bind="visible: view() == 'detail'">
	<h3 class="text-center">សំណួរសំរាប់អភិបាលនៅថ្នាក់មណ្ឌលសុខភាពស្តីពីការងារអប់រំសុខភាពជំងឺគ្រុនចាញ់</h3>
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

			<span class="space">មណ្ឌលសុខភាព</span>
			<select data-bind="value: Code_Facility_T,
					options: hcList(),
					optionsValue: 'code',
					optionsText: 'nameK',
					optionsCaption: ''" class="form-control minwidth150 kh"></select>
		</p>
		<p class="relative en">
			<kh>ថ្ងៃចុះអភិបាល</kh>
			<input type="text" data-bind="datePicker: VisitDate" class="form-control width150 text-center" placeholder="DD-MM-YYYY" />
		</p>
		<p>
			<span>ឈ្មោះអ្នកអភិបាល</span>
			<input type="text" class="form-control" data-bind="value: VisitorName" />

			<span class="space">តួនាទី</span>
			<input type="text" class="form-control" data-bind="value: VisitorPosition" />

			<span class="space">ទីកន្លែងធ្វើការ</span>
			<select class="form-control kh" data-bind="value: VisitorWorkplace">
				<option></option>
				<option value="CNM">ម.គ.ច</option>
				<option value="PHD">មន្ទីរសុខាភិបាលខេត្ត</option>
				<option value="OD">ស្រុកប្រតិបត្តិ</option>
			</select>
		</p>
		<p>
			<span>ឈ្មោះមន្ត្រីមណ្ឌលសុខភាព</span>
			<input type="text" class="form-control" data-bind="value: DoctorName" />

			<span class="space">ភេទ</span>
			<select class="form-control kh" data-bind="value: DoctorSex">
				<option value="M">ប្រុស</option>
				<option value="F">ស្រី</option>
			</select>
			
			<span class="space">លេខទូរស័ព្ទ</span>
			<input type="text" class="form-control en" data-bind="value: DoctorPhone" />
		</p>
		<p>
			<span>តួនាទី</span>
			<input type="text" class="form-control" data-bind="value: DoctorPosition" />

			<kh class="space">លេខបេសកកម្ម</kh>
			<input type="text" class="form-control en" min="0"
               oninput="this.value = this.value.replace(/[^0-9-]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" data-bind="value: MissionNo" />
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

	<div class="form-inline" data-bind="with: detailModel">
		<!-- ko with: Q2 -->
		<p><b>២. ការងារគ្រប់គ្រង</b></p>
		<p>
			<span>តើមណ្ឌលសុខភាពមានភូមិទាំងអស់ចំនួនប៉ុន្មាន</span>
			<input type="text" data-bind="value: village" class="form-control text-center width70 en" numonly="int" />

			<span class="space">ភូមិVMW</span>
			<input type="text" data-bind="value: villageVMW" class="form-control text-center width70 en" numonly="int" />
			
			<span class="space">ភូមិMMW</span>
			<input type="text" data-bind="value: villageMMW" class="form-control text-center width70 en" numonly="int" />
		</p>
		<p>
			<span>ចំនួនVMW</span>
			<span class="input-group">
				<input type="text" data-bind="value: vmw" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>

			<span class="space">ចំនួនMMW</span>
			<span class="input-group">
				<input type="text" data-bind="value: mmw" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>

			<span class="space">ចំនួនVHV/VHSG</span>
			<span class="input-group">
				<input type="text" data-bind="value: vhv" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>
		</p>
		<p>
			<span>ចំនួនអ្នកចល័ត</span>
			<span class="input-group">
				<input type="text" data-bind="value: mobile" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>

			<span class="space">ចំនួនអ្នកចំណាកស្រុក</span>
			<span class="input-group">
				<input type="text" data-bind="value: immigration" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>
		</p>
		<p>
			<span>ចំនួនក្រុមហ៊ុន, កសិដ្ឋាន, ម្ចាស់ចំការ</span>
			<input type="text" data-bind="value: site" class="form-control text-center width100 en" numonly="int" />

			<span class="space">ចំនួនកម្មករ</span>
			<span class="input-group">
				<input type="text" data-bind="value: worker" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>
		</p>
		<p>ចំនួនតេស្ត និង ករណីគ្រុនចាញ់រយៈពេល៣ខែចុងក្រោយ(មើលឯកសារ)</p>
		<div style="padding-left:50px">
			<p>នៅមណ្ឌលសុខភាព</p>
			<div style="padding-left:170px" data-bind="with: hcData">
				<p data-bind="with: m1">
					<span class="input-group">
						<span class="input-group-addon">ខែទី១</span>
						<input type="text" data-bind="value: total" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Test</span>
						<input type="text" data-bind="value: test" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PF</span>
						<input type="text" data-bind="value: pf" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PV</span>
						<input type="text" data-bind="value: pv" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Mix</span>
						<input type="text" data-bind="value: mix" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pm</span>
						<input type="text" data-bind="value: pm" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pk</span>
						<input type="text" data-bind="value: pk" numonly="int" class="form-control text-center width70 en" />
					</span>
				</p>
				<p data-bind="with: m2">
					<span class="input-group">
						<span class="input-group-addon">ខែទី២</span>
						<input type="text" data-bind="value: total" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Test</span>
						<input type="text" data-bind="value: test" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PF</span>
						<input type="text" data-bind="value: pf" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PV</span>
						<input type="text" data-bind="value: pv" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Mix</span>
						<input type="text" data-bind="value: mix" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pm</span>
						<input type="text" data-bind="value: pm" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pk</span>
						<input type="text" data-bind="value: pk" numonly="int" class="form-control text-center width70 en" />
					</span>
				</p>
				<p data-bind="with: m3">
					<span class="input-group">
						<span class="input-group-addon">ខែទី៣</span>
						<input type="text" data-bind="value: total" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Test</span>
						<input type="text" data-bind="value: test" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PF</span>
						<input type="text" data-bind="value: pf" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PV</span>
						<input type="text" data-bind="value: pv" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Mix</span>
						<input type="text" data-bind="value: mix" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pm</span>
						<input type="text" data-bind="value: pm" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pk</span>
						<input type="text" data-bind="value: pk" numonly="int" class="form-control text-center width70 en" />
					</span>
				</p>
			</div>
			<p>នៅសេវាអ្នកស្ម័គ្រចិត្តភូមិ</p>
			<div style="padding-left:170px" data-bind="with: vmwData">
				<p data-bind="with: m1">
					<span class="input-group">
						<span class="input-group-addon">ខែទី១</span>
						<input type="text" data-bind="value: total" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Test</span>
						<input type="text" data-bind="value: test" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PF</span>
						<input type="text" data-bind="value: pf" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PV</span>
						<input type="text" data-bind="value: pv" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Mix</span>
						<input type="text" data-bind="value: mix" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pm</span>
						<input type="text" data-bind="value: pm" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pk</span>
						<input type="text" data-bind="value: pk" numonly="int" class="form-control text-center width70 en" />
					</span>
				</p>
				<p data-bind="with: m2">
					<span class="input-group">
						<span class="input-group-addon">ខែទី២</span>
						<input type="text" data-bind="value: total" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Test</span>
						<input type="text" data-bind="value: test" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PF</span>
						<input type="text" data-bind="value: pf" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PV</span>
						<input type="text" data-bind="value: pv" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Mix</span>
						<input type="text" data-bind="value: mix" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pm</span>
						<input type="text" data-bind="value: pm" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pk</span>
						<input type="text" data-bind="value: pk" numonly="int" class="form-control text-center width70 en" />
					</span>
				</p>
				<p data-bind="with: m3">
					<span class="input-group">
						<span class="input-group-addon">ខែទី៣</span>
						<input type="text" data-bind="value: total" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Test</span>
						<input type="text" data-bind="value: test" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PF</span>
						<input type="text" data-bind="value: pf" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">PV</span>
						<input type="text" data-bind="value: pv" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Mix</span>
						<input type="text" data-bind="value: mix" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pm</span>
						<input type="text" data-bind="value: pm" numonly="int" class="form-control text-center width70 en" />
					</span>
					<span class="input-group">
						<span class="input-group-addon">Pk</span>
						<input type="text" data-bind="value: pk" numonly="int" class="form-control text-center width70 en" />
					</span>
				</p>
			</div>
			
		</div>
		<!-- /ko -->
		<br />

		<p><b>៣. ការងារជាទម្លាប់របស់មណ្ឌលសុខភាព</b></p>
		<p><b>៣.១. ការប្រជុំអ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់</b></p>
		<!-- ko with: Q31 -->
		<p>
			<span>តើខែមុនមានបានប្រជុំអ្នកស្ម័គ្រចិត្តភូមិដែរឬទេ?</span>
			<select class="form-control kh" data-bind="value: meeting">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p>
			<span>មិនបានមូលហេតុ</span>
			<input type="text" data-bind="value: meetingReason" class="form-control" style="width:700px" />
		</p>
		<p>
			<span>បើបាន ចំនួនអ្នកស្ម័គ្រចិត្តភូមិ</span>
			<span class="input-group">
				<input type="text" data-bind="value: vmw" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>

			<span class="space">ចំនួនអវត្ត</span>
			<span class="input-group">
				<input type="text" data-bind="value: absent" numonly="int" class="form-control text-center width70 en" />
				<span class="input-group-addon">នាក់</span>
			</span>

			<span class="space">បញ្ជាក់មូលហេតុ</span>
			<input type="text" data-bind="value: absentReason" class="form-control" />
		</p>
		<p>
			<span>មានបានបញ្ជ្រាបសារអប់រំសុខភាពជំងឺគ្រុនចាញ់</span>
			<select class="form-control kh" data-bind="value: message">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>

			<span class="space">មូលហេតុ</span>
			<input type="text" data-bind="value: messageReason" class="form-control" />
		</p>
		<p>ប្រធានបទអ្វីខ្លះដែលបានបញ្ជ្រាប</p>
		<p>
			<input type="text" data-bind="value: topic" class="form-control input-block" />
		</p>
		<p>
			<span>តើមានបានធ្វើកំណត់នៃការប្រជុំអ្នកស្ម័គ្រចិត្ត</span>
			<select class="form-control kh" data-bind="value: meetingSetup">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p>មូលហេតុ</p>
		<p>
			<input type="text" data-bind="value: meetingSetupReason" class="form-control input-block" />
		</p>
		<!-- /ko -->
		<br />

		<p><b>៣.២. សកម្មភាពអប់រំសុខភាពនៅថ្នាក់មណ្ឌលសុខភាព</b></p>
		<!-- ko with: Q32 -->
		<p>
			<span>កាលពីខែមុននៅក្នុងមណ្ឌលសុខភាពបានធ្វើការអប់រំសុខភាពដែរទេ?</span>
			<select class="form-control kh" data-bind="value: educate">
				<option></option>
				<option>បានធ្វើ</option>
				<option>មិនបានធ្វើ</option>
			</select>

			<span class="space">ហេតុអ្វី?</span>
		</p>
		<p>
			<input type="text" data-bind="value: reason" class="form-control input-block" />
		</p>
		<p>
			<span>បើបានធ្វើ តើបានប៉ុន្មានដងក្នុង១ខែ</span>
			<input type="text" data-bind="value: times" numonly="int" class="form-control text-center width70 en" />

			<span class="space">បានចំនួនប៉ុន្មាននាក់</span>
			<input type="text" data-bind="value: people" numonly="int" class="form-control text-center width70 en" />

			<span class="space">(ស្រី)</span>
			<input type="text" data-bind="value: female" numonly="int" class="form-control text-center width70 en" />
		</p>
		<p>
			<span>បានអប់រំទៅអ្នកណា</span>
			<select class="form-control kh" data-bind="value: who">
				<option></option>
				<option>អ្នកជំងឺគ្រុនចាញ់</option>
				<option>អ្នកមកពិគ្រោះជំងឺក្រៅ</option>
				<option>អ្នកមកសំរាល</option>
				<option>អ្នកជូនឬកំដរអ្នកជំងឺ</option>
			</select>

			<span class="space">ផ្សេងៗ(បញ្ជាក់)</span>
			<input type="text" data-bind="value: other" class="form-control" style="width:460px" />
		</p>
		<p>
			<span>តើមានរៀបចំកាលវិភាគសំរាប់ធ្វើការអប់រំទេ?</span>
			<select class="form-control kh" data-bind="value: schedule">
				<option></option>
				<option>បាន</option>
				<option>មិនបាន</option>
			</select>
		</p>
		<p>
			<span>តើប្រើវិធីសាស្ត្របែបណាក្នុងការអប់រំសុខភាពនេះ?</span>
			<select class="form-control kh" data-bind="value: method">
				<option></option>
				<option>និយាយផ្ទាល់មាត់</option>
				<option>បង្ហាញផ្ទាំងរូបភាព</option>
				<option>ចាក់ស្ពុតខ្លីៗតាមទូរទស្សន៍ម.ស</option>
				<option>អប់រំលើបុគ្គលម្នាក់ៗ</option>
				<option>ជាក្រុមតូចៗ(តិចជាង១០នាក់)</option>
				<option>ជាក្រុមធំ(លើពី១០នាក់)</option>
			</select>
		</p>
		<!-- /ko -->
		<br />

		<p><b>៣.៣. សកម្មភាពអប់រំសុខភាពនៅថ្នាក់សហគមន៍</b></p>
		<p>៣.៣.១. តើបុគ្គលិកមណ្ឌលសុខភាពបានចុះអប់រំសុខភាពនៅតាមសហគមន៍ទេក្នុងរយៈពេល៣កន្លងមក?</p>
		<div style="padding-left:50px" data-bind="with: Q331">
			<p>
				<select class="form-control kh" data-bind="value: community">
					<option></option>
					<option>បានអប់រំ</option>
					<option>មិនបាន</option>
				</select>

				<span class="space">មូលហេតុអ្វី</span>
				<input type="text" data-bind="value: reason" class="form-control" style="width:600px" />
			</p>
			<p>
				<span>បើបាន តើមានប្រជាជនចូលរួម</span>
				<span class="input-group">
					<input type="text" data-bind="value: people" numonly="int" class="form-control text-center width70 en" />
					<span class="input-group-addon">នាក់</span>
				</span>

				<span class="space">ស្រី</span>
				<input type="text" data-bind="value: female" numonly="int" class="form-control text-center width70 en" />
				<span class="space">ប្រុស</span>
				<input type="text" data-bind="value: male" numonly="int" class="form-control text-center width70 en" />
			</p>
			<p>
				<span>តើបានប្រើប្រាស់សំភារៈអ្វីខ្លះ?</span>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q331" value="ផ្ទាល់មាត់" data-bind="checked: equipment" />
					<span>ផ្ទាល់មាត់</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q331" value="ផ្ទាំងរូបភាព" data-bind="checked: equipment" />
					<span>ផ្ទាំងរូបភាព</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q331" value="រូបភាពសន្លឹកបត់" data-bind="checked: equipment" />
					<span>រូបភាពសន្លឹកបត់</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q331" value="រូបភាពសន្លឹកផ្ទាត់" data-bind="checked: equipment" />
					<span>រូបភាពសន្លឹកផ្ទាត់</span>
				</label>
			</p>
			<p>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q331" value="វីដេអូស្ពត់" data-bind="checked: equipment" />
					<span>វីដេអូស្ពត់</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q331" value="ឧបករណ៏បំពងសម្លេង" data-bind="checked: equipment" />
					<span>ឧបករណ៏បំពងសម្លេង</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q331" value="ផ្សេងៗ" data-bind="checked: equipment" />
					<span>ផ្សេងៗ</span>
				</label>
			</p>
			<p>
				<span>តើសកម្មភាពអប់រំនេះអាចអនុវត្តទៅបានតាមរយៈអ្វី?</span>
				<select class="form-control kh" data-bind="value: implement">
					<option></option>
					<option>ក្រុមចុះអភិបាលតាមភូមិ (តាមផែនការ)</option>
					<option>ក្រុមមណ្ឌលសុខភាពចុះផ្តល់សេវាតាមមូលដ្ឋាន</option>
					<option>កិច្ចសហការជាមួយអង្គការដៃគូផ្សេងៗ</option>
					<option>កម្មវិធីចែកមុង</option>
					<option>សកម្មភាពអប់រំតាមសហគមន៏</option>
				</select>
			</p>
			<p>តើបានទទួលបទពិសោធន៍បែបណា? (ផលល្អ/ផលវិបាក)ពីសកម្មភាពអប់រំតាមសហគមន៏</p>
			<p>
				<input type="text" data-bind="value: experience" class="form-control input-block" />
			</p>
		</div>

		<p>៣.៣.២. តើអ្នកស្ម័គ្រចិត្តភូមិបានធ្វើការអប់រំសុខភាពដែរឬទេ?</p>
		<div style="padding-left:50px" data-bind="with: Q332">
			<p>
				<select class="form-control kh" data-bind="value: educate">
					<option></option>
					<option>បានធ្វើ</option>
					<option>មិនបានធ្វើ</option>
				</select>
			</p>
			<p>
				<span>ចំនួនភូមិ</span>
				<input type="text" data-bind="value: educatedVillage" numonly="int" class="form-control text-center width70 en" />
				<span>បានធ្វើការអប់រំសុខភាពគ្រុនចាញ់</span>
			</p>
			<p>
				<span>ចំនួន ប្រជាជនបានចូលរួម</span>
				<input type="text" data-bind="value: people" numonly="int" class="form-control text-center width70 en" />

				<span class="space">ស្រី</span>
				<input type="text" data-bind="value: female" numonly="int" class="form-control text-center width70 en" />
				
				<span class="space">ប្រុស</span>
				<input type="text" data-bind="value: male" numonly="int" class="form-control text-center width70 en" />

				<span class="space">ចំនួនដង</span>
			</p>
			<p>
				<span>ភូមិចំនួន</span>
				<input type="text" data-bind="value: noneducatedVillage" numonly="int" class="form-control text-center width70 en" />
				<span>មិនបានធ្វើការអប់រំសុខភាព</span>

				<span class="space">បញ្ជាក់មូលហេតុ</span>
			</p>
			<p>
				<input type="text" data-bind="value: reason" class="form-control input-block" />
			</p>
			<p>តើពួកគាត់បានជួបភាពងាយស្រួលឬការលំបាកអ្វីខ្លះ?</p>
			<p>
				<textarea data-bind="value: challenge" class="form-control input-block" rows="4" style="resize:none"></textarea>
			</p>
		</div>
		<br />

		<p><b>៣.៤. ការបែងចែកនិងប្រើប្រាស់សំភារៈអប់រំឲ្យចំគោលដៅនិងមានប្រសិទ្ធភាព</b></p>
		<p>
			<span>៣.៤.១. តើម.ស ធ្លាប់បានទទួលសំភារៈអប់រំសុខភាព ក្នុងរយៈពេល៦ខែកន្លងមកដែរឫទេ?</span>
			<select class="form-control kh" data-bind="value: Q341">
				<option></option>
				<option>ធ្លាប់បានទទួល</option>
				<option>មិនធ្លាប់បានទទួល</option>
			</select>
		</p>

		<p>៣.៤.២. តើមានសំភារៈអប់រំអ្វីខ្លះដែលធ្លាប់បានទទួលឬកំពុងប្រើប្រាស់?</p>
		<div style="padding-left:50px" data-bind="with: Q342">
			<p>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="វីដេអូស្ពត់" data-bind="checked: equipment" />
					<span>វីដេអូស្ពត់</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="ស្ពុតវិទ្យុ" data-bind="checked: equipment" />
					<span>ស្ពុតវិទ្យុ</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="ផ្ទាំងរូបភាព" data-bind="checked: equipment" />
					<span>ផ្ទាំងរូបភាព</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="រូបភាពសន្លឹកបត់" data-bind="checked: equipment" />
					<span>រូបភាពសន្លឹកបត់</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="សៀវភៅសន្លឹកផ្ទាត់" data-bind="checked: equipment" />
					<span>សៀវភៅសន្លឹកផ្ទាត់</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="ប៉ាណូ" data-bind="checked: equipment" />
					<span>ប៉ាណូ</span>
				</label>
			</p>
			<p>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="បដាក្រណាត់ឬកៅស៊ូ" data-bind="checked: equipment" />
					<span>បដាក្រណាត់ឬកៅស៊ូ</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="ទូរទស្សន៍" data-bind="checked: equipment" />
					<span>ទូរទស្សន៍</span>
				</label>
				<label class="checkbox-inline checkbox-lg">
					<input type="checkbox" name="Q342" value="ឧបករណ៍បំពងសំម្លេង" data-bind="checked: equipment" />
					<span>ឧបករណ៍បំពងសំម្លេង</span>
				</label>
			</p>
			<p>
				<span>បានធ្វើតារាងបែងចែកទេ?</span>
				<select class="form-control kh" data-bind="value: distribution">
					<option></option>
					<option>បាន</option>
					<option>មិនបាន</option>
				</select>
			</p>
			<p>
				<span>តើធ្លាប់ទទួលបានផ្ទាំងប៉ាណូចំនួនប៉ុន្មាន?</span>
				<input type="text" data-bind="value: banner" numonly="int" class="form-control text-center width70 en" />

				<span class="space">តើទីតាំងនៅកន្លែងណាខ្លះ?</span>
			</p>
			<p>
				<input type="text" data-bind="value: location" class="form-control input-block" />
			</p>
			<p>
				<span>តើផ្ទាំងប៉ាណូនៅក្នុងតំបន់គ្របដណ្តប់មណ្ឌលសុខភាពមានខូចខាតចំនួន</span>
				<input type="text" data-bind="value: broken" numonly="int" class="form-control text-center width70 en" />
			</p>
		</div>
		<br />

		
		<br />
		<p><b>៥. បញ្ហាដែលបានជួបប្រទះ</b></p>
		<p>
			<textarea data-bind="value: Problem" class="form-control input-block" rows="6" style="resize:none"></textarea>
		</p>
		<br />
		<p><b>៦. ដំណោះស្រាយ</b></p>
		<p>
			<textarea data-bind="value: Solution" class="form-control input-block" rows="8" style="resize:none"></textarea>
		</p>
		<br />
		<p><b>៧. សំណូមពរ</b></p>
		<p>
			<textarea data-bind="value: Q7" class="form-control input-block" rows="5" style="resize:none"></textarea>
		</p>
	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_Edu_HC.js')?>