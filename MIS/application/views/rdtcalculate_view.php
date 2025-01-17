<style>
	.width70 { width:70px !important; }
	.input-group-addon { padding:3px 6px !important; }

	.arrow-line {
		width: 1px; /* line-width */
		height: 75px; /* line length */
		position: relative;
		background: black;
	}

	.arrow-line:after {
		content: "";
		position: absolute;
		border: 5px solid transparent;
		left: -4px;
		top: -15px;
		border-bottom: 15px solid black;
	}
</style>

<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh34">
			<b>RDT Calculate</b>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-body" style="height:780px; min-width:1550px">
		<table class="table table-bordered widthauto">
			<tr>
				<td valign="middle"># malaria RDT per year</td>
				<td width="100">
					<input type="text" class="form-control input-sm text-right" data-bind="textInput: numRDT" />
				</td>
			</tr>
			<tr>
				<td valign="middle">% malaria RDT which are positive</td>
				<td>
					<input type="text" class="form-control input-sm text-right" data-bind="textInput: pcRDT" />
				</td>
			</tr>
			<tr style="background:yellow">
				<td>Additional cases resolved</td>
				<td align="right" data-bind="text: AdditionalCasesResolved()"></td>
			</tr>
			<tr style="background:yellow">
				<td>Doses averted</td>
				<td align="right" data-bind="text: DosesAverted()"></td>
			</tr>
			<tr>
				<td valign="middle">Cost per CRP test ($)</td>
				<td width="100">
					<input type="text" class="form-control input-sm text-right" data-bind="textInput: costPerCRP" />
				</td>
			</tr>
			<tr>
				<td valign="middle">Cost per dose</td>
				<td>
					<input type="text" class="form-control input-sm text-right" data-bind="textInput: costPerDose" />
				</td>
			</tr>
			<tr style="background:yellow">
				<td>ICER (case resolution)</td>
				<td align="right" data-bind="text: ICERcase()"></td>
			</tr>
			<tr style="background:yellow">
				<td>ICER (dose reduction)</td>
				<td align="right" data-bind="text: ICERdose()"></td>
			</tr>
		</table>
		<br />

		<table class="table table-bordered widthauto">
			<tr class="bg-info">
				<th></th>
				<th align="center">Total</th>
				<th>Current practice</th>
				<th>CRP test</th>
			</tr>
			<tr>
				<td>Doses</td>
				<td align="right" data-bind="text: (sumDoses1() + sumDoses2()).toFixed(1) + '%'"></td>
				<td align="right" data-bind="text: sumDoses1().toFixed(1) + '%'"></td>
				<td align="right" data-bind="text: sumDoses2().toFixed(1) + '%'"></td>
			</tr>
			<tr>
				<td>Resolved</td>
				<td align="right" data-bind="text: (sumResolved1() + sumResolved2()).toFixed(1) + '%'"></td>
				<td align="right" data-bind="text: sumResolved1().toFixed(1) + '%'"></td>
				<td align="right" data-bind="text: sumResolved2().toFixed(1) + '%'"></td>
			</tr>
		</table>
		<br />

		<table class="table table-bordered widthauto">
			<tr class="bg-info">
				<th></th>
				<th align="center">Cost</th>
			</tr>
			<tr>
				<td>Cost current</td>
				<td align="right" data-bind="text: CostCurrent()"></td>
			</tr>
			<tr>
				<td>Cost CRP</td>
				<td align="right" data-bind="text: CostCRP()"></td>
			</tr>
			<tr>
				<td>Incremental cost</td>
				<td align="right" data-bind="text: CostCRP() - CostCurrent()"></td>
			</tr>
		</table>

		<div style="position:absolute; left:330px; top:10px; width:1220px">
			<div style="position:absolute; left:30px; top:440px">NMFI</div>

			<div style="position:absolute; left:200px; top:260px">
				<div>Current practice</div>
				<div style="margin-top:350px">CRP test</div>
			</div>

			<div style="position:absolute; left:420px; top:170px">
				<div class="form-inline">
					<span class="inlineblock" style="width:60px">Bacterial</span>
					<div class="input-group input-group-sm width70">
						<input type="text" class="form-control text-right" data-bind="textInput: Bacterial" />
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div style="margin-top:170px">
					<span class="inlineblock" style="width:60px">Viral</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Bacterial()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:155px">
					<span class="inlineblock" style="width:60px">Bacterial</span>
					<span class="inlineblock width70 text-right" data-bind="text: isempty(Bacterial(),0) + '%'"></span>
				</div>
				<div style="margin-top:160px">
					<span class="inlineblock" style="width:60px">Viral</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Bacterial()) + '%'"></span>
				</div>
			</div>

			<div style="position:absolute; left:690px; top:120px">
				<div class="form-inline">
					<span class="inlineblock" style="width:60px">Antibiotic</span>
					<div class="input-group input-group-sm width70">
						<input type="text" class="form-control text-right" data-bind="textInput: Antibiotic1" />
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div style="margin-top:70px">
					<span class="inlineblock" style="width:80px">No Antibiotic</span>
					<span class="inlineblock text-right" style="width:50px" data-bind="text: (100 - Antibiotic1()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:75px">
					<span class="inlineblock" style="width:60px">Antibiotic</span>
					<div class="input-group input-group-sm width70">
						<input type="text" class="form-control text-right" data-bind="textInput: Antibiotic2" />
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div style="margin-top:70px">
					<span class="inlineblock" style="width:80px">No Antibiotic</span>
					<span class="inlineblock text-right" style="width:50px" data-bind="text: (100 - Antibiotic2()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:65px">
					<span class="inlineblock" style="width:60px">Antibiotic</span>
					<div class="input-group input-group-sm width70">
						<input type="text" class="form-control text-right" data-bind="textInput: Antibiotic3" />
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div style="margin-top:65px">
					<span class="inlineblock" style="width:80px">No Antibiotic</span>
					<span class="inlineblock text-right" style="width:50px" data-bind="text: (100 - Antibiotic3()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:70px">
					<span class="inlineblock" style="width:60px">Antibiotic</span>
					<div class="input-group input-group-sm width70">
						<input type="text" class="form-control text-right" data-bind="textInput: Antibiotic4" />
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div style="margin-top:65px">
					<span class="inlineblock" style="width:80px">No Antibiotic</span>
					<span class="inlineblock text-right" style="width:50px" data-bind="text: (100 - Antibiotic4()) + '%'"></span>
				</div>
			</div>

			<div style="position:absolute; left:960px; top:100px">
				<div class="form-inline">
					<span class="inlineblock width70">Resolved</span>
					<div class="input-group input-group-sm width70">
						<input type="text" class="form-control text-right" data-bind="textInput: Resolved1" />
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div style="margin-top:10px">
					<span class="inlineblock width70">Unresolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Resolved1()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:40px">
					<span class="inlineblock width70">Resolved</span>
					<div class="input-group input-group-sm width70">
						<input type="text" class="form-control text-right" data-bind="textInput: Resolved2" />
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div style="margin-top:10px">
					<span class="inlineblock width70">Unresolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Resolved2()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:40px">
					<span class="inlineblock width70">Resolved</span>
					<div class="input-group input-group-sm width70">
						<input type="text" class="form-control text-right" data-bind="textInput: Resolved3" />
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div style="margin-top:10px">
					<span class="inlineblock width70">Unresolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Resolved3()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:40px">
					<span class="inlineblock width70">Resolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: isempty(Resolved3(),0) + '%'"></span>
				</div>
				<div style="margin-top:10px">
					<span class="inlineblock width70">Unresolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Resolved3()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:40px">
					<span class="inlineblock width70">Resolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: isempty(Resolved1(),0) + '%'"></span>
				</div>
				<div style="margin-top:10px">
					<span class="inlineblock width70">Unresolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Resolved1()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:40px">
					<span class="inlineblock width70">Resolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: isempty(Resolved2(),0) + '%'"></span>
				</div>
				<div style="margin-top:10px">
					<span class="inlineblock width70">Unresolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Resolved2()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:40px">
					<span class="inlineblock width70">Resolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: isempty(Resolved3(),0) + '%'"></span>
				</div>
				<div style="margin-top:10px">
					<span class="inlineblock width70">Unresolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Resolved3()) + '%'"></span>
				</div>

				<div class="form-inline" style="margin-top:40px">
					<span class="inlineblock width70">Resolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: isempty(Resolved3(),0) + '%'"></span>
				</div>
				<div style="margin-top:10px">
					<span class="inlineblock width70">Unresolved</span>
					<span class="inlineblock width70 text-right" data-bind="text: (100 - Resolved3()) + '%'"></span>
				</div>
			</div>

			<div style="position:absolute; left:1150px; top:100px">
				<div style="height:26px" data-bind="text: ((Bacterial() * Antibiotic1() * Resolved1()) / 10000).toFixed(1) + '%'"></div>
				<div style="margin-top:10px" data-bind="text: ((Bacterial() * Antibiotic1() * (100 - Resolved1())) / 10000).toFixed(1) + '%'"></div>

				<div style="margin-top:40px; height:26px" data-bind="text: ((Bacterial() * (100 - Antibiotic1()) * Resolved2()) / 10000).toFixed(1) + '%'"></div>
				<div style="margin-top:10px" data-bind="text: ((Bacterial() * (100 - Antibiotic1()) * (100 - Resolved2())) / 10000).toFixed(1) + '%'"></div>

				<div style="margin-top:40px; height:26px" data-bind="text: (((100 - Bacterial()) * Antibiotic2() * Resolved3()) / 10000).toFixed(1) + '%'"></div>
				<div style="margin-top:10px" data-bind="text: (((100 - Bacterial()) * Antibiotic2() * (100 - Resolved3())) / 10000).toFixed(1) + '%'"></div>

				<div style="margin-top:40px" data-bind="text: (((100 - Bacterial()) * (100 - Antibiotic2()) * Resolved3()) / 10000).toFixed(1) + '%'"></div>
				<div style="margin-top:10px" data-bind="text: (((100 - Bacterial()) * (100 - Antibiotic2()) * (100 - Resolved3())) / 10000).toFixed(1) + '%'"></div>

				<div style="margin-top:40px" data-bind="text: ((Bacterial() * Antibiotic3() * Resolved1()) / 10000).toFixed(1) + '%'"></div>
				<div style="margin-top:10px" data-bind="text: ((Bacterial() * Antibiotic3() * (100 - Resolved1())) / 10000).toFixed(1) + '%'"></div>

				<div style="margin-top:40px" data-bind="text: ((Bacterial() * (100 - Antibiotic3()) * Resolved2()) / 10000).toFixed(1) + '%'"></div>
				<div style="margin-top:10px" data-bind="text: ((Bacterial() * (100 - Antibiotic3()) * (100 - Resolved2())) / 10000).toFixed(1) + '%'"></div>

				<div style="margin-top:40px" data-bind="text: (((100 - Bacterial()) * Antibiotic4() * Resolved3()) / 10000).toFixed(1) + '%'"></div>
				<div style="margin-top:10px" data-bind="text: (((100 - Bacterial()) * Antibiotic4() * (100 - Resolved3())) / 10000).toFixed(1) + '%'"></div>

				<div style="margin-top:40px" data-bind="text: (((100 - Bacterial()) * (100 - Antibiotic4()) * Resolved3()) / 10000).toFixed(1) + '%'"></div>
				<div style="margin-top:10px" data-bind="text: (((100 - Bacterial()) * (100 - Antibiotic4()) * (100 - Resolved3())) / 10000).toFixed(1) + '%'"></div>
			</div>

			<div style="position:absolute; left: 124px; top: 273px; transform: rotate(40deg);">
				<div class="arrow-line" style="height:187px"></div>
			</div>
			<div style="position:absolute; left: 125px; top: 440px; transform: rotate(140deg);">
				<div class="arrow-line" style="height:198px"></div>
			</div>

			<div style="position:absolute; left: 352px; top: 168px; transform: rotate(54deg);">
				<div class="arrow-line" style="height:120px"></div>
			</div>
			<div style="position:absolute; left: 349px; top: 259px; transform: rotate(130deg);">
				<div class="arrow-line" style="height:120px"></div>
			</div>

			<div style="position:absolute; left: 330px; top: 526px; transform: rotate(62deg);">
				<div class="arrow-line" style="height:148px"></div>
			</div>
			<div style="position:absolute; left: 328px; top: 609px; transform: rotate(120deg);">
				<div class="arrow-line" style="height:148px"></div>
			</div>

			<div style="position:absolute; left: 616px; top: 110px; transform: rotate(70deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 616px; top: 144px; transform: rotate(106deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 616px; top: 301px; transform: rotate(70deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 616px; top: 337px; transform: rotate(108deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 616px; top: 477px; transform: rotate(70deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 616px; top: 513px; transform: rotate(108deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 616px; top: 660px; transform: rotate(70deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 616px; top: 696px; transform: rotate(108deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 885px; top: 70px; transform: rotate(81deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 885px; top: 84px; transform: rotate(96deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 885px; top: 162px; transform: rotate(83deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 885px; top: 176px; transform: rotate(98deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 885px; top: 260px; transform: rotate(81deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 885px; top: 274px; transform: rotate(96deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 885px; top: 354px; transform: rotate(83deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 885px; top: 366px; transform: rotate(96deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 885px; top: 442px; transform: rotate(83deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 885px; top: 454px; transform: rotate(96deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 885px; top: 531px; transform: rotate(84deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 885px; top: 543px; transform: rotate(97deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 885px; top: 624px; transform: rotate(83deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 885px; top: 636px; transform: rotate(96deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>

			<div style="position:absolute; left: 885px; top: 712px; transform: rotate(84deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
			<div style="position:absolute; left: 885px; top: 724px; transform: rotate(97deg);">
				<div class="arrow-line" style="height:110px"></div>
			</div>
		</div>
	</div>
</div>

<?=latestJs('/media/ViewModel/RDTCalculate.js')?>