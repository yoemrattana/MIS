<style>
	body { background-color: white; }
	#wrapper { padding: 0; }
	#footer { display: none; }

	.panelA { background-color: #E2EFDA; padding: 10px; }
	.panelA td { padding: 5px 0; }

	.panelB { border: 1px solid gray; border-bottom-width: 0; background-color: #FFF2CC; padding: 10px; }

	.color1 { background-color: #DDEBF7; }
	.color2 { background-color: #E2EFDA; }
	.color3 { background-color: #FCE4D6; }
	.color4 { background-color: #D6DCE4; }
	.color5 { background-color: #FFC000; }

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

<div class="panelB" data-bind="with: head">
	<div class="row">
		<div class="col-xs-4">
			<div class="form-group">
				<i>Name of the controlled laboratory:</i>
				<i data-bind="text: hc.name"></i>
			</div>
			<div class="form-group">
				<i>Round:</i>
				<i data-bind="text: Round"></i>
			</div>
			<div>
				<i>Name of Microscopist:</i>
				<i data-bind="text: Microscopist"></i>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="text-center text-bold" style="font-size:20px; padding:15px 0">
				Panel Testing
			</div>
			<div class="text-center">
				<i>Slide set 49</i>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="form-group">
				<i>Laboratory Panel testing slide:</i>
				<i>CNM</i>
			</div>
			<div class="form-group">&nbsp;</div>
			<div>
				<i>Provided by:</i>
				<i data-bind="text: Provider"></i>
			</div>
		</div>
	</div>
</div>

<table id="detail" border="1" class="width100p">
	<thead>
		<tr>
			<th rowspan="2">lam code</th>
			<th colspan="4">Slide Result</th>
			<th colspan="4" class="color1">Detection</th>
			<th colspan="4" class="color2">PF_Species</th>
			<th rowspan="2" class="color3">Accuracy</th>
			<th rowspan="2" class="color4">Counting</th>
		</tr>
		<tr>
			<th>Microscopist</th>
			<th>Parasite count</th>
			<th>Reference slide result</th>
			<th>Parasite count</th>
			<th class="color1">A</th>
			<th class="color1">B</th>
			<th class="color1">C</th>
			<th class="color1">D</th>
			<th class="color2">A</th>
			<th class="color2">B</th>
			<th class="color2">C</th>
			<th class="color2">D</th>
		</tr>
	</thead>
	<tbody data-bind="foreach: list">
		<tr>
			<td data-bind="text: LamCode"></td>
			<td data-bind="text: $root.getSpecies(Microscopist)"></td>
			<td data-bind="text: ParasiteCount1"></td>
			<td data-bind="text: $root.getSpecies(ReferenceSlide)"></td>
			<td data-bind="text: ParasiteCount2"></td>
			<td data-bind="text: DetectionA"></td>
			<td data-bind="text: DetectionB"></td>
			<td data-bind="text: DetectionC"></td>
			<td data-bind="text: DetectionD"></td>
			<td data-bind="text: PfA"></td>
			<td data-bind="text: PfB"></td>
			<td data-bind="text: PfC"></td>
			<td data-bind="text: PfD"></td>
			<td data-bind="text: Accuracy"></td>
			<td data-bind="text: Counting"></td>
		</tr>
	</tbody>
	<tfoot class="color5">
		<tr>
			<th colspan="5">Total</th>
			<th data-bind="text: list().sum('DetectionA')"></th>
			<th data-bind="text: list().sum('DetectionB')"></th>
			<th data-bind="text: list().sum('DetectionC')"></th>
			<th data-bind="text: list().sum('DetectionD')"></th>
			<th data-bind="text: list().sum('PfA')"></th>
			<th data-bind="text: list().sum('PfB')"></th>
			<th data-bind="text: list().sum('PfC')"></th>
			<th data-bind="text: list().sum('PfD')"></th>
			<th data-bind="text: list().sum('Accuracy')"></th>
			<th data-bind="text: list().sum('Counting')"></th>
		</tr>
	</tfoot>
</table>

<script>
	function viewModel() {
		var self = this;

		self.head = ko.observable();
		self.list = ko.observableArray();

		app.getPlace(['pv', 'od', 'hc'], function (place) {
			var arr = location.pathname.split('/');
			var submit = {
				hc: arr[4],
				s: decodeURI(arr[5])
			};

			app.ajax('/Lab/getPanelTesting', submit).done(function (rs) {
				if (rs.head != null) {
					var h = rs.head;
					h.hc = place.hc.find(r => r.code == h.Code_Facility_T);
					h.od = place.od.find(r => r.code == h.hc.odcode);
					h.pv = place.pv.find(r => r.code == h.od.pvcode);

					var arr = h.hc.name.split('_');
					h.type = arr.length == 1 ? 'HC' : arr[1];

					self.head(h);
					self.list(rs.list);
				}
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
				: v == 'N' ?'NMPS'
				: '';
		};
	}
</script>