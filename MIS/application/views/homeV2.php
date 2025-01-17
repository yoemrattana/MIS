<?php
if ($isLogin) {
	$username = $_SESSION['username'];
	$role = $_SESSION['role'];
	$permiss = $_SESSION['permiss'];
	$hidden = '';
	if (isset($_SESSION['first_login'])) {
		$hiddenWelcome =  !$_SESSION['first_login'] ? 'hidden' : '';
	} else {
		$hiddenWelcome = '';
	}
} else {
	$username = '';
	$role     = '';
	$permiss  = '';
	$provlist = [];
	$exportList = [];
	$hidden   = 'hidden';
}
$slideMenu = '';
?>

<style>
	.count-widget {
		color: white;
		font-size: 12px;
		padding-left: 5px;
		/* ms ( IE 10.0+ ) */
		background: -ms-linear-gradient(50deg, rgba(8,98,232,1) 0.00%, rgba(99,214,250,1) 99.31% );
		/* WebKit (Chrome 10.0+, safari 5.1+ )*/
		background: -webkit-linear-gradient(50deg, rgba(8,98,232,1) 0.00%, rgba(99,214,250,1) 99.31% );
		/* Moz ( Moz 3.6+ )*/
		background: -moz-linear-gradient(50deg, rgba(8,98,232,1) 0.00%, rgba(99,214,250,1) 99.31% );
		/* Opera ( opera 11.6+ )*/
		background: -o-linear-gradient(50deg, rgba(8,98,232,1) 0.00%, rgba(99,214,250,1) 99.31% );
		/* W3C Markup */
		background: linear-gradient(50deg, rgba(8,98,232,1) 0.00%, rgba(99,214,250,1) 99.31% );
	}
</style>

<div style="zoom: <?php echo empty($username) ? '100%' : '75%' ?>" id="spaces-main" class="pt-perspective">
	<section class="page-section home-page">
		<div class="row-v2 metro-panel">
			<div class="large-12 columns">
				<div class="row-v2">
					<div class='large-3 columns contact-box space'>
						<div class="none-hover" style="padding: 0; width:150px; margin: 0 auto">
							<a href='#'>
								<img src="/media/assetsV2/images/cnm.png">
							</a>
						</div>
                        <h2 style="font-size: 33px; color: #fff; letter-spacing: 6px; text-align: center; padding: 0; margin: 0;">CNM</h2>
					</div>
					<div class='large-6 columns contact-box space' style="padding: 0">
						<div id="sys-title" class="none-hover">
							<h2 style='font-size: 45px; font-family: x-locale-heading-primary,zillaslab,Palatino,"Palatino Linotype",x-locale-heading-secondary,serif;'>Malaria Information System</h2>
						</div>
                        
                        <?php
						if (isset($nameE)) {
							echo "<div class='locationName $hidden'>$nameE - <kh>$nameK</kh></div>";
						} elseif ($role != 'M&E') {
							echo form_dropdown('code_prov',$provlist,null,'class="select-ui select-prov '.$hidden.'" id="code_prov" onchange="sessionStorage[\'code_prov\'] = this.value" style="border:2px solid black; font-weight:700"');
						}
						?>
					</div>
					
					<div class="large-3 columns menu-button text-right">
						<?php if ($isLogin) { ?>
						<a style="font-size:20px" data-toggle="tooltip" data-placement="bottom" title="Contact Us" class="showMenu" ><i data-toggle="modal" data-target="#modalContactUs" class="fa-phone fa icon-x back"></i></a>
						<a style="font-size:20px; color: #fff" data-toggle="tooltip" data-placement="bottom" title="Logout" href="/Login/logout" onclick="logoutClick()" class="showMenu search"><i class="fa-sign-out fa icon-x back"></i></a>
						<?php } ?>
					</div>
				</div>
				<br>
				<?php if ($isLogin) : ?>
				<div class="row-v2 panel-menu <?=$slideMenu?>">
					<div id="before-tiles" class="large-12 columns"></div>
					<div id="data-entry-section" class="three large-3 columns">
						<?php $this->load->view('home/malaria_widget', ['permiss' => $permiss, 'role' => $role]) ?>
					</div>

					<div id="stock-section" class="four large-3 columns">
						<?php $this->load->view('home/stock_widget', ['permiss' => $permiss, 'role' => $role]) ?>
					</div>

					<div id="report-section" class="four large-3 columns">
						<?php $this->load->view('home/report_widget', ['permiss' => $permiss, 'role' => $role]) ?>
					</div>

					<div id="management-section" class="four large-3 columns">
						<?php $this->load->view('home/master_widget', ['permiss' => $permiss, 'role' => $role, 'username' => $username]) ?>
					</div>

					<div class='twelve small-12 columns space'>
						<?php $this->load->view('home/export_widget', ['permiss' => $permiss, 'role' => $role]) ?>
						<p style="width:240px" class="count-widget pull-left">Today Visitor: <?php echo $todayVisit ?> | Yesterday Visitor: <?php echo $yesterdayVisit?></p>
						<p class="pull-right count-widget">&#9400; 2024 CNM MIS. Version <span style="font-size: 12px">4.0</span></p>
					</div>

					<div id="after-tiles" class="large-12 columns"></div>
				</div>
						
				<?php endif; ?>

				<div class="copyright">© 2024 CNM MIS.</div>
			</div>
		</div>
	</section>
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

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		if (app.user != null && document.getElementById('code_prov') != null) {
			if (sessionStorage['code_prov'] == null) {
				sessionStorage['code_prov'] = document.getElementById('code_prov').value;
	        } else {
	            document.getElementById('code_prov').value = sessionStorage['code_prov'];
	        }
	    }

	    if ($('div#data-entry-ct div').length == 0) {
	        $('#data-entry-section').addClass('hidden');
	    }

	    if ($('div#stock-ct div').length == 0) {
	        $('#stock-section').addClass('hidden');
	    }

	    if ($('div#report-ct div').length == 0) {
	        $('#report-section').addClass('hidden');
	    }

	    if ($('div#management-ct div').length == 0) {
	        $('#management-section').addClass('hidden');
	    }
	});

	function logoutClick() {
		sessionStorage.clear();
		$('body').hide();
	}
</script>

<?php if (isset($_SESSION['first_login'])) $_SESSION['first_login'] = false; ?>

<?=form_hidden('exportList', json_encode($exportList))?>
<?=latestJs('/media/ViewModel/Home.js')?>