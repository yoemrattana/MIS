<?php
$isMobile = $this->agent->is_mobile();
if($isMobile) $navClass = '';
else $navClass = 'autohide navbar2';
?>

<div class="sticky <?php echo $navClass ?>">
    <section class="row">
	    <div class="col-md-12">
            <nav class="navbar navbar-dark bg-info">
                <a style="font-size:20px; font-weight:bold" class="navbar-brand" href="\Home">Malaria Dashboard</a>
                <p style="margin:0 ; color: white">Yesterday Visit: <span data-bind="text: yesterdayVisit"></span> | Today Visit: <span data-bind="text: todayVisit"></span> </p>
            </nav>
	    </div>
    </section>
    <div class="row">
        <div class="col-sm-8">
            <section class="margin-top-5">
	            <form>
		            <div class="form-row">
			            <div class="col-sm-2">
                            <label class="form-group has-float-label">
                                <select class="form-control custom-select" data-bind="disable: isGuest, value: prov, options: provList, optionsValue: 'code', optionsText: 'name', optionsCaption: provList().length > 1 ? 'All Provinces' : undefined, change: changeOpt">
                                </select>
                                <span>Province</span>
                             </label>
			            </div>
			            <div class="col-sm-1">    
                            <label class="form-group has-float-label">
                                <select class="form-control custom-select" data-bind="disable: isGuest, value: year, options: yearList, change: changeOpt">
                                </select>
                                <span>Year</span>
                             </label>
			            </div>
			            <div class="col-sm-1">
                            <label class="form-group has-float-label">
                                <select class="form-control custom-select" data-bind="value: from, options: monthList, change: changeOpt">
                                </select>
                                <span>From</span>
                             </label>
			            </div>
			            <div class="col-sm-1">
                            <label class="form-group has-float-label">
                                <select class="form-control custom-select" data-bind="value: to, options: monthList, change: changeOpt">
                                </select>
                                <span>To</span>
                             </label>
			            </div>
			            <div class="col-sm-2">
                            <label class="form-group has-float-label">
                                <select class="form-control custom-select" data-bind="disable: isGuest, value: filterMode, change: changeOpt">
                                    <option value="0">By Report Date</option>
						            <option value="1">By Diagnosis Date</option>
                                </select>
                                <span>Filter Mode</span>
                             </label>
			            </div>     
                        
			            <div class="col-sm-3">
				            <button type="button" class="btn waves-effect waves-light box-shadow btn-info btn-sm" data-bind="disable: isGuest, click: submit" style="font-weight: 900; padding-left:15px; padding-right:15px;"><i class="fa fa-search"></i> View</button>
                            <a class="btn btn-primary box-shadow btn-sm" data-bind="attr: { href: app.user.role == 'GUEST' ? '/Login/logout' : '/Home' }, visible: app.user.role != 'GUEST'" ><i class="fa fa-home"></i> Home</a>
			            </div>
		            </div>
	            </form>
                
            </section>
        </div> 
        
        <div class="col-sm-4 pull-right">
            <?php if($_SESSION['role'] == 'GUEST') : ?>
            <form action="/Login" method="post" style="margin-top: 5px;">
                <div class="form-row justify-content-end">
                    <div class="wrap-input100 validate-input col-sm-4" data-validate="Name is required">
                        <input class="input100" required type="text" name="username" placeholder="Username" />
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input col-sm-4">
                        <input class="input100" required type="password" name="password" placeholder="Password" />

                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-contact100-form-btn col-sm-4" style="padding-top:0px">
                        <button class="contact100-form-btn">
                            <i class="fa fa-sign-in"></i> &nbsp; Login
                        </button>
                    </div>
                </div>
                       
                <?php if (isset($invalid) && $invalid == true) { ?>
                <h5 class="text-danger">Username or Password is not correct.</h5>
                <?php } ?>
            
            </form>
            <?php endif ;?>
        </div>
    </div>

    <a class="btn btn-primary pull-right box-shadow" data-toggle="modal" data-target="#modalContactUs" style="margin-left:2px"> <i class="fa fa-phone"></i> Contact Us</a>
    <button class="btn btn-info pull-right box-shadow" data-bind="click: exportExcel, visible: app.user.permiss['Dashboard'].contain('Export') && tab() != 'Stock'"><i class="fa fa-file-excel-o"></i> Export Excel</button>
    <div class="row">
        <div class="col-sm-12">
            <section class="margin-top-5">
		        <div class="button-group">
			        <button type="button" data-bind="click: menuClick, visible: app.user.permiss['Dashboard'].contain('Overview')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow active">Overview</button>
			        <button type="button" data-bind="click: menuClick, visible: app.user.permiss['Dashboard'].contain('Surveillance')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Surveillance</button>
			        <button type="button" data-bind="click: menuClick, visible: app.user.permiss['Dashboard'].contain('Stock')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Stock</button>
			        <button type="button" data-bind="click: menuClick, visible: app.user.permiss['Dashboard'].contain('Border')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Border</button>
			        <button type="button" data-bind="click: menuClick, visible: app.user.permiss['Dashboard'].contain('Map')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Map</button>			        
			        <button type="button" data-bind="click: menuClick, visible: app.user.permiss['Dashboard'].contain('PF Map')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">PF Map</button>
                    <button type="button" data-bind="click: menuClick" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Documents</button>
                    <!--<a type="button" href="/App/gallery" target="_blank" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">App Gallery</a>-->
                    <button type="button" data-bind="click: menuClick" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">App Gallery</button>
		        </div>
	        </section>
        </div>
    </div>
</div><!--sticky end-->

<div data-bind="hidden: overviewPart1Ready">
	<?php $this->load->view('skeleton_loading'); ?>
    <br />
   <?php $this->load->view('skeleton_loading'); ?>
</div> <!--Loading end-->

<div data-bind="visible: true" style="display:none">
	<div class="bluecontainer" data-bind="visible: loaded">
		<?php $this->load->view('dashboard_overview_view'); ?>
		<?php $this->load->view('dashboard_surveillance_view'); ?>
		<?php $this->load->view('dashboard_border_view'); ?>
		<?php $this->load->view('dashboard_stock_view'); ?>
		<?php $this->load->view('dashboard_map_view'); ?>
		<?php $this->load->view('dashboard_table_view'); ?>
		<?php $this->load->view('dashboard_outbreak_view'); ?>
		<?php $this->load->view('dashboard_intensification_view'); ?>
		<?php $this->load->view('dashboard_pfmap_view'); ?>
        <?php $this->load->view('dashboard_doc_view'); ?>
        <?php $this->load->view('dashboard_app_view'); ?>
	</div>
</div>

<?=form_hidden('percent', $percent)?>
<?=form_hidden('chartODBorder', latestFile('/media/Maps/chartODBorder.js'))?>
<?=form_hidden('chartNeighbourBorder', latestFile('/media/Maps/chartNeighbourBorder.js'))?>
<?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>

<script src="/media/highchart/grouped-categories.js"></script>
<?=latestJs('/media/JavaScript/loadash.js')?>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCVXxd9fjjh1c2wrsRlZfyHfEkBiI4XQ8Q"></script>
<script src="/media/JavaScript/maplabel.js"></script>
<script src="/media/JavaScript/dom-to-image.js"></script>

<script>
    var isMobile = <?php echo json_encode($isMobile); ?> ;
</script>

<?=latestJs('/media/ViewModel/Dashboard.js')?>
<?=latestJs('/media/ViewModel/Dashboard_Overview.js')?>
<?=latestJs('/media/ViewModel/Dashboard_Border.js')?>
<?=latestJs('/media/ViewModel/Dashboard_Stock.js')?>
<?=latestJs('/media/ViewModel/Dashboard_Map.js')?>
<?=latestJs('/media/ViewModel/Dashboard_Outbreak.js')?>
<?=latestJs('/media/ViewModel/Dashboard_Intensification.js')?>
<?=latestJs('/media/ViewModel/Dashboard_PFMap.js')?>
<?=latestJs('/media/ViewModel/Dashboard_Doc.js')?>
<?=latestJs('/media/ViewModel/Dashboard_App.js')?>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        el_autohide = document.querySelector('.autohide');

        if (el_autohide) {
            var last_scroll_top = 0;
            window.addEventListener('scroll', function () {
                let scroll_top = window.scrollY;
                if (scroll_top < last_scroll_top) {
                    el_autohide.classList.remove('scrolled-down');
                    el_autohide.classList.add('scrolled-up');
                }
                else {
                    el_autohide.classList.remove('scrolled-up');
                    el_autohide.classList.add('scrolled-down');
                }
                last_scroll_top = scroll_top;
            });
        }
    });
</script>