<?php
$role = $_SESSION['role'];
$permiss = $_SESSION['permiss'];
?>

<style>
	.province-menu { background: #D4F1F9; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; height: 34px; position: relative; }
	#code_prov { width: 250px; margin: -1px auto 0 auto; border-radius: 0; }
	.choosemonth { background-color: white !important; cursor: text; }
	.contactus { position: absolute; right: 3px; top: 3px; }
	.locationName { margin-top: 5px; font-size: 16px; font-weight: bold; text-align: center; }
	.locationName kh { font-size: 14px; }
</style>

<div id="dashboard">
	<div>
		<img id="logo_header" class="img-responsive" src="<?=latestFile('/media/images/cnm-header.png')?>" />
		<h3 style="color:#2E96BE; margin-top:5px; text-align:center">Malaria Information System (MIS)</h3>
	</div>
	<div class="province-menu">
		<?php
		if (isset($nameE)) {
			echo "<div class='locationName'>$nameE - <kh>$nameK</kh></div>";
		} elseif ($role != 'M&E') {
			echo form_dropdown('code_prov',$provlist,null,'class="form-control" id="code_prov" onchange="sessionStorage[\'code_prov\'] = this.value"');
		}
		?>
		<script>
			if (document.getElementById('code_prov') != null) {
				if (sessionStorage['code_prov'] == null) {
					sessionStorage['code_prov'] = document.getElementById('code_prov').value;
				} else {
					document.getElementById('code_prov').value = sessionStorage['code_prov'];
				}
			}
		</script>
		<button class="btn btn-default btn-sm contactus" data-toggle="modal" data-target="#modalContactUs">Contact Us</button>
	</div>

	<div class="clearfix" style="margin-bottom:10px">
		<div class="col-xs-6">
			<div>
                <?php
				$menu = '';
                if (isset($permiss['VMW Data'])) {
					$menu .= '<a href="/CaseReport/vmw" class="btn btn-primary">VMW Data</a>';
				}
                if (isset($permiss['VMW Data Accuracy'])) {
                    $menu .= '<a href="/CaseReport/vmwDataAccuracy" class="btn btn-primary">VMW Data Accuracy</a>';
                }
				if (isset($permiss['Health Center Data'])) {
                    $menu .= '<a href="/CaseReport/hf" class="btn btn-primary">Health Center Data</a>';
				}
                if (isset($permiss['Health Center Data Accuracy'])) {
                    $menu .= '<a href="/CaseReport/hfDataAccuracy" class="btn btn-primary">Health Center Data Accuracy</a>';
				}
				if (isset($permiss['MMP Data'])) {
                    $menu .= '<a href="/CaseReport/ml" class="btn btn-primary">MMP Data</a>';
				}
				if (isset($permiss['Bed Net Data'])) {
					$menu .= '<a href="/CaseReport/bednet" class="btn btn-primary">Bed Net Data</a>';
				}
				if (isset($permiss['Bed Net Other Data'])) {
					$menu .= '<a href="/CaseReport/bednetother" class="btn btn-primary">Bed Net Other Data</a>';
				}
				if (isset($permiss['Private Sector Data'])) {
					$menu .= '<a href="/CaseReport/ppm" class="btn btn-primary">Private Sector Data</a>';
				}
				if (isset($permiss['Questionnaire'])) {
					$menu .= '<a href="/Question" class="btn btn-primary">Questionnaire</a>';
				}

				if ($menu != '') {
					echo '<h4 class="text-center">Data Entry</h4>';
					echo $menu;
				}
                ?>
			</div>

			<div>
				<?php
				$menu = '';
				if (isset($permiss['Stock Request'])) {
					$menu .= '<a href="/Stock/request" class="btn btn-primary">Stock Request</a>';
				}
				if (isset($permiss['Stock Data'])) {
					$menu .= '<a href="/Stock/report" class="btn btn-primary">Stock Data</a>';
				}
				if (isset($permiss['CNM Stock Data'])) {
					$menu .= '<a href="/Stock/reportCNM" class="btn btn-primary">CNM Stock Data</a>';
				}
				if ($role == 'AU') {
					$menu .= '<a href="/Stock/item" class="btn btn-primary">Stock Item</a>';
				}

				if ($menu != '') {
					echo '<h4 class="text-center">Stock Management</h4>';
					echo $menu;
				}
				?>
			</div>
		</div>

		<div class="col-xs-6">
			<div>
                <?php
				$menu = '';
				if (isset($permiss['Dashboard'])) {
					$menu .= '<a href="/Dashboard" class="btn btn-primary">Dashboard</a>';
				}
				if (isset($permiss['Reports'])) {
					$menu .= '<a href="/Report" class="btn btn-primary">Reports</a>';
				}
				if (isset($permiss['Reports V2'])) {
					$menu .= '<a href="/ReportV2" class="btn btn-primary">Reports V2 (M&E)</a>';
				}
				if (isset($permiss['Reports MMP'])) {
					$menu .= '<a href="/ReportMilitary" class="btn btn-primary">Reports MMP</a>';
				}
				if (isset($permiss['Reports Director'])) {
					$menu .= '<a href="/ReportDirector" class="btn btn-primary">Reports Director</a>';
				}

				if ($menu != '') {
					echo '<h4 class="text-center">Reports</h4>';
					echo $menu;
				}
                ?>
			</div>

			<div>
				<?php
				$menu = '';
				if (isset($permiss['System Menu'])) {
					$menu .= '<a href="/Home/sysmenu" class="btn btn-primary">System Menu</a>';
				}
				if ($role == 'AU') {
					$menu .= '<a href="/Treatment" class="btn btn-primary">Treatment Management</a>';
					$menu .= '<a href="/User" class="btn btn-primary">User Management</a>';
					$menu .= '<a href="/Device" class="btn btn-primary">Device Management</a>';
					$menu .= '<a href="/Home/placePermission" class="btn btn-primary">Place Permission Management</a>';
				} else if (!in_array($role, ['GUEST','M&E'])) {
					$menu .= '<a data-bind="click: showPassword" class="btn btn-primary">Change Password</a>';
				}

				if ($menu != '') {
					echo '<h4 class="text-center">Master Data Management</h4>';
					echo $menu;
				}
				?>
			</div>
		</div>
	</div>

	<?php if (isset($permiss['Export Data'])) { ?>
	<div class="div-viewdata">
		<div class="field-view">
			<h4>Export Data</h4>
			<table>
				<tr>
					<td valign="top" style="height:54px">
						<select data-bind="value: exportItem, options: exportList, optionsText: 'Text'" class="form-control" style="width:300px"></select>
					</td>
					<td valign="top" style="padding-top:5px">
						<?php if (strlen($_SESSION['prov']) != 2) { ?>
						<label class="checkbox-inline checkbox-lg">
							<input type="checkbox" data-bind="checked: national" />
							<span><?=$_SESSION['prov'] === '' ? 'National Data' : 'All Provinces'?></span>
						</label>
						<?php } ?>
					</td>
					<td style="width:180px">
						<div data-bind="visible: exportItem().DateFilter" style="display:none">
							<div style="width:80px; display:inline-block">
								<div class="dropdown">
									<input type="text" id="datefrom" class="form-control choosemonth" readonly />
									<div class="dropdown-menu" style="padding:10px; min-width:140px">
										<div class="row no-margin">
											<div class="col-xs-6 no-padding">Month</div>
											<div class="col-xs-6 no-padding">Year</div>
										</div>
										<div class="row no-margin">
											<div class="col-xs-6 no-padding">
												<select class="form-control input-sm" style="width:50px; height:26px"
													data-bind="value: thisMonth, options: monthList"></select>
											</div>
											<div class="col-xs-6 no-padding">
												<select class="form-control input-sm" style="width:60px; height:26px"
													data-bind="value: thisYear, options: yearList"></select>
											</div>
										</div>
									</div>
								</div>
								<div class="text-center">From</div>
							</div>
							<div style="width:80px; display:inline-block">
								<div class="dropdown">
									<input type="text" id="dateto" class="form-control choosemonth" readonly />
									<div class="dropdown-menu" style="padding:10px; min-width:140px">
										<div class="row no-margin">
											<div class="col-xs-6 no-padding">Month</div>
											<div class="col-xs-6 no-padding">Year</div>
										</div>
										<div class="row no-margin">
											<div class="col-xs-6 no-padding">
												<select class="form-control input-sm" style="width:50px; height:26px"
													data-bind="value: thisMonth, options: monthList"></select>
											</div>
											<div class="col-xs-6 no-padding">
												<select class="form-control input-sm" style="width:60px; height:26px"
													data-bind="value: thisYear, options: yearList"></select>
											</div>
										</div>
									</div>
								</div>
								<div class="text-center">To</div>
							</div>
						</div>
					</td>
				</tr>
			</table>
			<div class="clearfix" style="padding:0 5px; width:300px">
				<a data-bind="click: previewExcel" class="pull-left">
					<span class="glyphicon glyphicon-search"></span>
					<span>Preview</span>
				</a>
				<a data-bind="click: exportExcel" class="pull-right">
					<span class="glyphicon glyphicon-save"></span>
					<span>Export Excel</span>
				</a>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

<div class="modal" id="modalPassword" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Change Password</h3>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-xs-3">New Password:</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" data-bind="value: password" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" data-dismiss="modal" style="width:100px" data-bind="click: changePassword">Save</button>
				<button class="btn btn-default" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>

<?=form_hidden('exportList', json_encode($exportList))?>

<?=latestJs('/media/ViewModel/Home.js')?>