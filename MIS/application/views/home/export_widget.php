<div class="none-hover" style="overflow-x:auto; padding-left:0; padding-right:0">
	<div class="export-area">
		<?php if ($isLogin && isset($permiss['Export Data'])) { ?>
		<div class="div-viewdata" style="background:none; height:160px; width:660px">
			<div>
				<h4 class="text-left">Export Data</h4>
				<table>
					<tr>
						<td>
							<select data-bind="value: exportItem, options: exportList, optionsText: 'Text'" class="form-control widthauto"></select>
						</td>
						<td valign="middle" style="padding:0 20px">
							<?php if (strlen($_SESSION['prov']) != 2) { ?>
							<label class="checkbox-inline checkbox-lg">
								<input type="checkbox" data-bind="checked: national" />
								<span style="color:white; white-space:nowrap"><?=$_SESSION['prov'] === '' ? 'National Data' : 'All Provinces'?></span>
							</label>
							<?php } ?>
						</td>
						<td>
							<div data-bind="visible: exportItem().DateFilter" class="text-nowrap">
								<div style="width:95px; display:inline-block">
									<div class="dropdown">
										<input type="text" id="datefrom" class="form-control choosemonth text-center" style="cursor:default" readonly />
										<div class="dropdown-menu" style="padding:10px; min-width:unset" onclick="event.stopPropagation()">
											<div style="display:inline-block">
												<div>Month</div>
												<select class="form-control widthauto" data-bind="value: thisMonth, options: monthList"></select>
											</div>
											<div style="display:inline-block">
												<div>Year</div>
												<select class="form-control widthauto" data-bind="value: thisYear, options: yearList"></select>
											</div>
										</div>
									</div>
									<div class="ex-period">From</div>
								</div>
								<div style="width:95px; display:inline-block">
									<div class="dropdown">
										<input type="text" id="dateto" class="form-control choosemonth text-center" style="cursor:default" readonly />
										<div class="dropdown-menu" style="padding:10px; min-width:unset; left: auto; right:0" onclick="event.stopPropagation()">
											<div style="display:inline-block">
												<div>Month</div>
												<select class="form-control widthauto" data-bind="value: thisMonth, options: monthList"></select>
											</div>
											<div style="display:inline-block">
												<div>Year</div>
												<select class="form-control widthauto" data-bind="value: thisYear, options: yearList"></select>
											</div>
										</div>
									</div>
									<div class="ex-period">To</div>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding-top:15px; display:flex; justify-content:space-between">
							<a data-bind="click: previewExcel">
								<span class="glyphicon glyphicon-search"></span>
								<span>Preview</span>
							</a>
							<a data-bind="click: exportExcel">
								<span class="glyphicon glyphicon-save"></span>
								<span>Export Excel</span>
							</a>
						</td>
						<td></td>
						<td valign="bottom">
							<select class="form-control" data-bind="value: filterMode, visible: exportItem().DateFilter">
								<!-- ko if: exportItem().StoreName != 'SP_Export_HFVMWWeeklyHC' -->
								<option value="0">Filter by Report Date</option>
								<!-- /ko -->
								<option value="1">Filter by Diagnosis Date</option>
							</select>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php } ?>
	</div>
</div>