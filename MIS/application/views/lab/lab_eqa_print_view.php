<style>
	body { background-color: white; }
	#wrapper { padding: 0; }
	#footer { display: none; }

	.panelB { border: 1px solid gray; border-bottom-width: 0; background-color: #FFF2CC; padding: 10px; }

	#detail th, #detail td { padding: 3px; height: 27px; text-align: center; }
</style>

<div class="panelB" data-bind="with: head">
	<div style="width:500px">
		<div class="form-group text-center">
			<i>INDIVIDUAL RESULTS SHEET (RS1)</i>
		</div>
		<div class="form-group">
			<i>Survey No:</i>
			<i data-bind="text: Survey"></i>
		</div>
		<div class="form-group">
			<i>Microscopist Name:</i>
			<i data-bind="text: Name"></i>
		</div>
		<div class="form-group">
			<i>Position:</i>
			<i data-bind="text: Position"></i>
		</div>
		<div class="form-group">
			<i>Laboratory Number:</i>
			<i data-bind="text: LabNum"></i>
		</div>
		<div class="form-group">
			<i>Date slides examined (dd-mm-yyyy):</i>
			<i data-bind="text: moment(ExaminedDate).displayformat()"></i>
		</div>
	</div>
</div>

<table id="detail" border="1" class="width100p">
	<thead>
		<tr>
			<th colspan="5" align="center">Microscopist</th>
			<th colspan="2" align="center">EQA</th>
			<th colspan="4" style="background:#DDEBF7" align="center">Detection</th>
			<th colspan="4" style="background:#E2EFDA" align="center">PF Species</th>
			<th rowspan="2" style="background:#FCE4D6" align="center" valign="middle">Accuracy</th>
			<th rowspan="2" style="background:#D6DCE4" align="center" valign="middle">Counting</th>
		</tr>
		<tr>
			<th align="center" width="80">Slide No.</th>
			<th align="center">SSP.</th>
			<th align="center" width="100">Number of Parasites</th>
			<th align="center" width="100">Number of WBCs</th>
			<th align="center" width="80">Counting</th>
			<th align="center">SSP.</th>
			<th align="center" width="80">Counting</th>
			<th align="center" width="60" style="background:#DDEBF7">A</th>
			<th align="center" width="60" style="background:#DDEBF7">B</th>
			<th align="center" width="60" style="background:#DDEBF7">C</th>
			<th align="center" width="60" style="background:#DDEBF7">D</th>
			<th align="center" width="60" style="background:#E2EFDA">A</th>
			<th align="center" width="60" style="background:#E2EFDA">B</th>
			<th align="center" width="60" style="background:#E2EFDA">C</th>
			<th align="center" width="60" style="background:#E2EFDA">D</th>
		</tr>
	</thead>
	<tbody data-bind="foreach: list">
		<tr>
			<td align="center" data-bind="text: Slide"></td>
			<td align="center" data-bind="text: SSP_Microscopist"></td>
			<td align="center" data-bind="text: Parasite"></td>
			<td align="center" data-bind="text: WBC"></td>
			<td align="center" data-bind="text: Counting_Microscopist"></td>
			<td align="center" data-bind="text: SSP_EQA"></td>
			<td align="center" data-bind="text: Counting_EQA"></td>
			<td align="center" data-bind="text: DetectionA" style="background:#DDEBF7"></td>
			<td align="center" data-bind="text: DetectionB" style="background:#DDEBF7"></td>
			<td align="center" data-bind="text: DetectionC" style="background:#DDEBF7"></td>
			<td align="center" data-bind="text: DetectionD" style="background:#DDEBF7"></td>
			<td align="center" data-bind="text: PfA" style="background:#E2EFDA"></td>
			<td align="center" data-bind="text: PfB" style="background:#E2EFDA"></td>
			<td align="center" data-bind="text: PfC" style="background:#E2EFDA"></td>
			<td align="center" data-bind="text: PfD" style="background:#E2EFDA"></td>
			<td align="center" data-bind="text: Accuracy" style="background:#FCE4D6"></td>
			<td align="center" data-bind="text: Counting" style="background:#D6DCE4"></td>
		</tr>
	</tbody>
	<tfoot style="background-color:#FFC000">
		<tr>
			<th class="text-center" colspan="7">Total</th>
			<th class="text-center" data-bind="text: list().sum('DetectionA')"></th>
			<th class="text-center" data-bind="text: list().sum('DetectionB')"></th>
			<th class="text-center" data-bind="text: list().sum('DetectionC')"></th>
			<th class="text-center" data-bind="text: list().sum('DetectionD')"></th>
			<th class="text-center" data-bind="text: list().sum('PfA')"></th>
			<th class="text-center" data-bind="text: list().sum('PfB')"></th>
			<th class="text-center" data-bind="text: list().sum('PfC')"></th>
			<th class="text-center" data-bind="text: list().sum('PfD')"></th>
			<th class="text-center" data-bind="text: list().sum('Accuracy')"></th>
			<th class="text-center" data-bind="text: list().sum('Counting')"></th>
		</tr>
	</tfoot>
</table>
<br />

<table class="table table-bordered">
	<thead style="background-color:#FCE4D6">
		<tr>
			<th align="center">% Parasite detection</th>
			<th align="center" rowspan="2" valign="middle">% Species ID Agreement</th>
			<th align="center">% false positive rate</th>
			<th align="center">% false negative rate</th>
			<th align="center">% Pf_agreement with species identification</th>
			<th align="center" rowspan="2" valign="middle">% Parasite Counting</th>
			<th align="center" rowspan="2" valign="middle">% of Accuracy</th>
			<th align="center">% Sensitivity</th>
			<th align="center">% Specificity</th>
		</tr>
		<tr>
			<th align="center">(A+D/A+B+C+D)x100)</th>
			<th align="center">(B/A+B)x100</th>
			<th align="center">(C/C+D)x100</th>
			<th align="center">(A+D/A+B+C+D)x100)</th>
			<th align="center">(A/A+C)x100</th>
			<th align="center">(D/B+D)x100</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td align="center" data-bind="text: calcA()"></td>
			<td align="center" data-bind="text: calcB()"></td>
			<td align="center" data-bind="text: calcC()"></td>
			<td align="center" data-bind="text: calcD()"></td>
			<td align="center" data-bind="text: calcE()"></td>
			<td align="center" data-bind="text: calcF()"></td>
			<td align="center" data-bind="text: calcG()"></td>
			<td align="center" data-bind="text: calcH()"></td>
			<td align="center" data-bind="text: calcI()"></td>
		</tr>
	</tfoot>
</table>

<script>
	function viewModel() {
		var self = this;

		self.head = ko.observable();
		self.list = ko.observableArray();

		function getData(){
			var arr = location.pathname.split('/');
			var submit = {
				hc: arr[4],
				q: decodeURI(arr[5])
			};

			app.ajax('/Lab/getEQA', submit).done(function (rs) {
				self.head(rs.head);
				self.list(rs.list);

				print();
			});
		}
		getData();

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

		self.calcA = function () {
			var list = self.list();
			var a = list.filter(r => r.DetectionA > 0).length;
			var b = list.filter(r => r.DetectionB > 0).length;
			var c = list.filter(r => r.DetectionC > 0).length;
			var d = list.filter(r => r.DetectionD > 0).length;
			var abcd = a + b + c + d;
			var rs = abcd == 0 ? 0 : ((a + d) / abcd) * 100;
			return rs.toFixed(0) + '%';
		};

		self.calcB = function () {
			var list = self.list();
			var a = list.filter(r => r.SSP_Microscopist.in('', 'N') == false && r.SSP_Microscopist == r.SSP_EQA).length;
			return (a / list.length * 100).toFixed(0) + '%';
		};

		self.calcC = function () {
			var list = self.list();
			var a = list.filter(r => r.DetectionA > 0).length;
			var b = list.filter(r => r.DetectionB > 0).length;
			var ab = a + b;
			return ab == 0 ? '0%' : (b / ab * 100).toFixed(0) + '%';
		};

		self.calcD = function () {
			var list = self.list();
			var c = list.filter(r => r.DetectionC > 0).length;
			var d = list.filter(r => r.DetectionD > 0).length;
			var cd = c + d;
			return cd == 0 ? '0%' : (c / cd * 100).toFixed(0) + '%';
		};

		self.calcE = function () {
			var list = self.list();
			var a = list.filter(r => r.PfA > 0).length;
			var b = list.filter(r => r.PfB > 0).length;
			var c = list.filter(r => r.PfC > 0).length;
			var d = list.filter(r => r.PfD > 0).length;
			var abcd = a + b + c + d;
			var rs = abcd == 0 ? 0 : ((a + d) / abcd) * 100;
			return rs.toFixed(0) + '%';
		};

		self.calcF = function () {
			var list = self.list();
			var a = list.filter(r => r.Counting_Microscopist == r.Counting_EQA).length;
			return (a / list.length * 100).toFixed(0) + '%';
		};

		self.calcG = function () {
			var list = self.list();
			var a = list.filter(r => r.Accuracy > 0).length;
			return (a / list.length * 100).toFixed(0) + '%';
		};

		self.calcH = function () {
			var list = self.list();
			var a = list.filter(r => r.DetectionA > 0).length;
			var c = list.filter(r => r.DetectionC > 0).length;
			var ac = a + c;
			var rs = ac == 0 ? 0 : a / ac * 100;
			return rs.toFixed(0) + '%';
		};

		self.calcI = function () {
			var list = self.list();
			var b = list.filter(r => r.DetectionB > 0).length;
			var d = list.filter(r => r.DetectionD > 0).length;
			var bd = b + d;
			var rs = bd == 0 ? 0 : d / bd * 100;
			return rs.toFixed(0) + '%';
		};
	}
</script>