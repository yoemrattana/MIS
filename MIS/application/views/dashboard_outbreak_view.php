
<div data-bind="visible: tab() == 'CNM Outbreak Detection Tool'" style="display: none">
	<div class="row">
		<div class="col-12">
			<h3>CNM Outbreak Detection Tool</h3>
			<div class="card option" style="line-height:15px">
				<div class="left-aside bg-light-part">
					<h6 class="panel-header" style="left:75px">
						Year
					</h6>
					<div class="divider"></div>
					<h6 style="margin:0; font-size:13px">
						<strong>Select Base Line Range</strong>
					</h6>

					<div id="baseRange">
						<table class="table table-striped mg-top-10" style="width:100%; margin-bottom:0">
							<thead style="background-color: deepskyblue">
								<tr>
									<th>Year</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								<!--<tr>
									<td style="padding-right: 15px">2015</td>
									<td>
										<input id="2015" class="yrange" data-bind="disable: isGuest" type="checkbox" />
									</td>
								</tr>-->
								<!--<tr>
									<td style="padding-right: 15px">2016</td>
									<td>
										<input id="2016" class="yrange" data-bind="disable: isGuest" type="checkbox" />
									</td>
								</tr>-->
								<tr>
									<td style="padding-right: 15px">2017</td>
									<td>
										<input id="2017" class="yrange" data-bind="disable: isGuest" type="checkbox" />
									</td>
								</tr>
								<tr>
									<td style="padding-right: 15px">2018</td>
									<td>
										<input id="2018" class="yrange" data-bind="disable: isGuest" type="checkbox" checked />
									</td>
								</tr>
								<tr>
									<td style="padding-right: 15px">2019</td>
									<td>
										<input id="2019" class="yrange" data-bind="disable: isGuest" type="checkbox" checked />
									</td>
								</tr>
								<tr>
									<td style="padding-right: 15px">2020</td>
									<td>
										<input id="2020" class="yrange" data-bind="disable: isGuest" type="checkbox" checked />
									</td>
								</tr>
								<tr>
									<td style="padding-right: 15px">2021</td>
									<td>
										<input id="2021" class="yrange" data-bind="disable: isGuest" type="checkbox" checked />
									</td>
								</tr>
                                <tr>
                                    <td style="padding-right: 15px">2022</td>
                                    <td>
                                        <input id="2022" class="yrange" data-bind="disable: isGuest" type="checkbox" checked />
                                    </td>
                                </tr>
							</tbody>
						</table>
					</div>
					<br />
					<div>
						<label class="checkbox-inline checkbox-sm">
							<input data-bind="disable: isGuest, checked: incEstimateCase" type="checkbox" />
							<span>Include Estimated Case</span>
						</label>
					</div>

					<!--/-->
					<h6 class="panel-header mg-top-10" style="left:75px">Place</h6>
					<div class="divider"></div>
					<div class="form-group">
						<span>Province</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: pvOB, options: provList, optionsValue: 'code', optionsText: 'name', optionsCaption: pvList().length == 1 ? undefined : 'All'" id="code_prov"></select>
					</div>
					<div class="form-group">
						<span>OD</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: odOB, options: odListOption, optionsValue: 'code', optionsText: 'name', optionsCaption: odListOption().length == 1 ? undefined : 'All'" id="code_od"></select>
					</div>
					<div class="form-group">
						<span>HF</span>
						<select class="form-control input-sm" data-bind="disable: isGuest, value: hcOB, options: hcList, optionsValue: 'code', optionsText: 'name', optionsCaption: 'All'" id="code_fa"></select>
					</div>
					<!--/-->
					<h6 class="panel-header mg-top-10" style="left:75px">Species</h6>
					<div class="divider"></div>
					<div class="specie" style="font-size:9.5px; border: 1px solid #ccc; padding:10px">
						<label class="checkbox-inline checkbox-sm">
							<input data-bind="disable: isGuest, checked: f" type="checkbox" />
							<span>PF</span>
						</label>
						<label class="checkbox-inline checkbox-sm">
							<input data-bind="disable: isGuest, checked: v" type="checkbox" />
							<span>PV</span>
						</label>
						<label class="checkbox-inline checkbox-sm">
							<input data-bind="disable: isGuest, checked: m" type="checkbox" />
							<span>Mix</span>
						</label>
					</div>
					<!--/-->
					<div class="form-group">
						<button data-bind="disable: isGuest, click: submitDetection" class="btn btn-info btn-sm" style="margin-top: 5px;width:100%">View</button>
					</div>
					<div class="divider"></div>
					<div>
						<img class="img-responsive" src="<?=latestFile('/media/images/cnm_android_icon.png')?>" style="margin: 0 auto" />
					</div>
					<div>
						<img class="img-responsive" src="<?=latestFile('/media/images/moru.jpg')?>" style="margin-top:5px; margin: 0 auto" />
					</div>

				</div><!--/left-aside-->

				<div class="right-aside" style="height:946px">
					<div class="chart-container2">
						<div style="height: 650px" id="OutbreakDetection" class="chartbox"></div>
						<div class="btn">
							<label class="checkbox-inline checkbox-sm">
								<input class="obDetection" id="EC" type="checkbox" checked />
								<span>Estimated Case</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="obDetection" id="VMW" type="checkbox" checked />
								<span>VMW</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="obDetection" id="HF" type="checkbox" checked />
								<span>HF</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="obDetection" id="BL" type="checkbox" checked />
								<span>Base Line</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="obDetection" id="STD1" type="checkbox" checked />
								<span>STD1</span>
							</label>
							<label class="checkbox-inline checkbox-sm">
								<input class="obDetection" id="STD2" type="checkbox" checked />
								<span>STD2</span>
							</label>
						</div>
					</div>
				</div><!--/right-aside-->
			</div>
		</div>
	</div>
</div>