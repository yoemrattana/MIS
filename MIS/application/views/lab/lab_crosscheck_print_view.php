<style>
	body { background-color: white; }
	#wrapper { padding: 0; }
	#footer { display: none; }

	.panelA { background-color: #E2EFDA; padding: 10px; }
	.panelA td { padding: 5px 0; }

	.color1 { background-color: #DDEBF7; }
	.color2 { background-color: #E2EFDA; }
	.color3 { background-color: #FCE4D6; }
	.color4 { background-color: #D6DCE4; }
	.color5 { background-color: #FFC000; }
	.color6 { background-color: yellow; }

	#detail th, #detail td { padding: 3px; height: 27px; text-align: center; }
</style>

<div class="panelA">
	<table data-bind="with: head">
		<tr>
			<td width="100">Province</td>
			<td align="center" width="150">
				<div style="background:#F2F2F2" data-bind="text: pv.name"></div>
			</td>
			<td align="center" width="150">
				<div style="background:white" data-bind="text: pv.nameK"></div>
			</td>
			<td width="100"></td>
			<td width="300" align="center">HFAC_Name</td>
		</tr>
		<tr>
			<td>OD</td>
			<td align="center">
				<div style="background:#F2F2F2" data-bind="text: od.name"></div>
			</td>
			<td align="center">
				<div style="background:white" data-bind="text: od.nameK"></div>
			</td>
			<td></td>
			<td align="center">
				<div style="background:#F2F2F2" data-bind="text: hc.name"></div>
			</td>
		</tr>
		<tr>
			<td>Facility</td>
			<td align="center">
				<div style="background:#F2F2F2" data-bind="text: type"></div>
			</td>
			<td></td>
			<td></td>
			<td align="center">
				<div style="background:white" data-bind="text: hc.nameK"></div>
			</td>
		</tr>
		<tr>
			<td>HFAC_Code</td>
			<td align="center">
				<div style="background:#F2F2F2" data-bind="text: Code_Facility_T"></div>
			</td>
		</tr>
	</table>
</div>

<table id="detail" border="1" class="width100p">
	<thead>
		<tr>
			<th colspan="7" rowspan="2" class="color6">PRH and RH</th>
			<th colspan="18" class="color5">CNM</th>
		</tr>
		<tr>
			<th rowspan="2" class="color5">Microscope</th>
			<th rowspan="2" class="color5">Parasite Counting</th>
			<th colspan="4" class="color5">Detection</th>
			<th colspan="4" class="color5">Pf Species</th>
			<th rowspan="2" class="color5">Accuracy</th>
			<th rowspan="2" class="color5">Counting</th>
			<th colspan="3" class="color5">Quality of smear</th>
			<th colspan="3" class="color5">Quality of staining</th>
		</tr>
		<tr>
			<th class="color6">Sample ID</th>
			<th class="color6">Collection Date</th>
			<th class="color6">Name</th>
			<th class="color6">Age</th>
			<th class="color6">Sex</th>
			<th class="color6">Microscope</th>
			<th class="color6">Parasite Counting</th>
			<th class="color5">A</th>
			<th class="color5">B</th>
			<th class="color5">C</th>
			<th class="color5">D</th>
			<th class="color5">A</th>
			<th class="color5">B</th>
			<th class="color5">C</th>
			<th class="color5">D</th>
			<th class="color5">Excellent</th>
			<th class="color5">Good</th>
			<th class="color5">Poor</th>
			<th class="color5">Excellent</th>
			<th class="color5">Good</th>
			<th class="color5">Poor</th>
		</tr>
	</thead>
	<tbody data-bind="foreach: list">
		<tr>
			<td data-bind="text: $index() + 1"></td>
			<td data-bind="text: CollectionDate == null ? '' : moment(CollectionDate).displayformat()" align="center"></td>
			<td data-bind="text: Name"></td>
			<td data-bind="text: Age"></td>
			<td data-bind="text: Sex"></td>
			<td data-bind="text: $root.getSpecies(D1)"></td>
			<td data-bind="text: ParaCount"></td>
			<td data-bind="text: $root.getSpecies(Microscope)"></td>
			<td data-bind="text: ParasiteCount"></td>
			<td data-bind="text: DetectionA" class="color1"></td>
			<td data-bind="text: DetectionB" class="color1"></td>
			<td data-bind="text: DetectionC" class="color1"></td>
			<td data-bind="text: DetectionD" class="color1"></td>
			<td data-bind="text: PfA" class="color2"></td>
			<td data-bind="text: PfB" class="color2"></td>
			<td data-bind="text: PfC" class="color2"></td>
			<td data-bind="text: PfD" class="color2"></td>
			<td data-bind="text: Accuracy" class="color3"></td>
			<td data-bind="text: Counting" class="color4"></td>
			<td data-bind="text: SmearExcellent"></td>
			<td data-bind="text: SmearGood"></td>
			<td data-bind="text: SmearPoor"></td>
			<td data-bind="text: StainingExcellent"></td>
			<td data-bind="text: StainingGood"></td>
			<td data-bind="text: StainingPoor"></td>
		</tr>
	</tbody>
</table>

<script>
	function viewModel() {
		var self = this;

		self.head = ko.observable();
		self.list = ko.observableArray();

		app.getPlace(['pv', 'od', 'hc'], function (place) {
			var arr = location.pathname.split('/');
			var q = decodeURI(arr[5]);
			var submit = {
				hc: arr[4],
				year: q.substr(0, 4),
				mf: q.substr(-1) * 3 - 2,
				mt: q.substr(-1) * 3
			};

			app.ajax('/Lab/getCrossCheck', submit).done(function (rs) {
				var h = { Code_Facility_T: submit.hc };
				h.hc = place.hc.find(r => r.code == submit.hc);
				h.od = place.od.find(r => r.code == h.hc.odcode);
				h.pv = place.pv.find(r => r.code == h.od.pvcode);

				var arr = h.hc.name.split('_');
				h.type = arr.length == 1 ? 'HC' : arr[1];

				self.head(h);
				self.list(rs.list);

				print();
			});
		});

		self.getSpecies = function (v) {
			return v == 'F' ? 'Pf'
				: v == 'V' ? 'Pv'
				: v == 'M' ? 'Mix'
				: v == 'A' ? 'Pm'
				: v == 'O' ? 'Po'
				: v == 'K' ? 'Pk'
				: v == 'N' ? 'NMPS'
				: '';
		};
	}
</script>