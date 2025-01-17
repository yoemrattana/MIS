<?php $this->load->view('app/header') ?>

<nav class="navbar navbar-fixed-top transparent navbar-light bg-white">
	<div class="container">

		<!-- Navbar Logo -->
		<a class="ui-variable-logo navbar-brand" href="#" title="Malaria Reporting App for VMW">
			<!-- Default Logo -->
			<img class="logo-default" src="/media/assetsApp/img/cnm.png" alt="Cambodia Malaria Reporting App for VMW" data-uhd />
			<!-- Transparent Logo -->
			<img class="logo-transparent" src="/media/assetsApp/img/cnm.png" alt="Cambodia Malaria Reporting App for VMW" data-uhd />
		</a><!-- .navbar-brand -->

		<!-- Navbar Navigation -->
		<div class="ui-navigation navbar-right">
			<ul class="nav navbar-nav">
				<li>
					<a href="#" data-scrollto="features">Features</a>
				</li>
				<li>
					<a href="#" data-scrollto="screens">Screens</a>
				</li>
			</ul><!--.navbar-nav -->
		</div><!--.ui-navigation -->

		<!-- Navbar Button -->
		<a href="#" data-scrollto="download" class="btn btn-sm ui-gradient-green pull-right">Download</a>

		<!-- Navbar Toggle -->
		<a href="#" class="ui-mobile-nav-toggle pull-right"></a>

	</div><!-- .container -->
</nav><!-- nav -->

<!-- Main Wrapper -->
<div class="main" role="main">
	<!-- Hero Waves Center -->
	<div class="ui-hero hero-lg hero-center ui-gradient-blue ui-waves hero-svg-layer-3">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="heading">
						Malaria Reporting App
					</h1>
					<p class="paragraph">
						Village Malaria Worker
					</p>
					<div class="actions">
						<a class="btn ui-gradient-blue shadow-xl" data-scrollto="features">Learn More</a>
						<a class="btn ui-gradient-green shadow-xl" href="#" data-scrollto="download">Download</a>
					</div>
				</div>
				<div class="col-sm-12">
					<img src="/media/assetsApp/img/mis-app.png" alt="Cambodia Malaria Reporting App" data-uhd data-max_width="740" class="responsive-on-md" />
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .ui-hero -->

	<!-- Tabbed Showcase Section -->
	<div id="features" class="section">
		<div class="container">
			<!-- Section Heading -->
			<div class="section-heading center">
				<h2 class="heading text-indigo">
					Showcase
				</h2>
				<p class="paragraph">
					VMW Reporting App Main Features
				</p>
			</div><!-- .section-heading -->
			<!-- UI Tabbed Showcase -->
			<div class="row ui-tabbed-showcase">

				<!-- Device Slider Column -->
				<div class="col-md-6 col-sm-5 animate" data-show="fade-in-right">
					<!-- Device Slider -->
					<div class="ui-device-slider">
						<!-- Device Image -->
						<div class="device">
							<img src="/media/assetsApp/img/device.png" style="height:625px !important" data-uhd alt="Cambodia Malaria Reporting for VMW" />
						</div>
						<!-- Slider Images -->
						<div id="device-slider-2" class="screens owl-carousel owl-theme" >
							<div class="item">
								<img src="/media/assetsApp/img/vmw/home.jpg" data-uhd alt="Cambodia Malaria Reporting for VMW" />
							</div>
							<div class="item">
								<img src="/media/assetsApp/img/vmw/form.jpg" data-uhd alt="Cambodia Malaria Reporting for VMW" />
							</div>
							<div class="item">
								<img src="/media/assetsApp/img/vmw/report.jpg" data-uhd alt="Cambodia Malaria Reporting for VMW" />
							</div>
							<div class="item">
								<img src="/media/assetsApp/img/vmw/followup.jpg" data-uhd alt="Cambodia Malaria Reporting for VMW" />
							</div>
						</div>
					</div><!-- .ui-device-slider -->
				</div><!-- Device Slider Column -->

				<!-- Tabs Column -->
				<div class="col-md-6 col-sm-7" data-vertical_center="true">
					<!-- UI Tabs -->
					<div class="ui-tabs ui-green">
						<!-- Nav Tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<!-- Nav Tab 1 -->
							<li role="presentation" class="nav-item">
								<a class="nav-link active" href="#home" role="tab" data-toggle="tab" data-toggle_screen="1" data-toggle_slider="device-slider-2">
									<span class="icon icon-home"></span> Home
								</a>
							</li>
							<!-- Nav Tab 2 -->
							<li role="presentation" class="nav-item">
								<a class="nav-link" href="#form" role="tab" data-toggle="tab" data-toggle_screen="2" data-toggle_slider="device-slider-2">
									<span class="fa fa-wpforms"></span> VMW Form
								</a>
							</li>

							<li role="presentation" class="nav-item">
								<a class="nav-link" href="#report" role="tab" data-toggle="tab" data-toggle_screen="3" data-toggle_slider="device-slider-2">
									<span class="fa fa-th"></span> Report
								</a>
							</li>

							<li role="presentation" class="nav-item">
								<a class="nav-link" href="#followup" role="tab" data-toggle="tab" data-toggle_screen="4" data-toggle_slider="device-slider-2">
									<span class="fa fa-list-ol"></span> Follow up
								</a>
							</li>

						</ul>

						<!-- Tab Panels -->
						<div class="tab-content">
							<!-- Tab 1 -->
							<div role="tabpanel" class="tab-pane fade show active" id="home">
								<p class="sub-heading">Home page</p>
								<ul class="ui-checklist">
									<li>
										<h6 class="heading">Data Entry Form</h6>
									</li>
									<li>
										<h6 class="heading">Report</h6>
									</li>
									<li>
										<h6 class="heading">Follow up patient</h6>
									</li>
								</ul>
							</div>
							<!-- Tab 2 -->
							<div role="tabpanel" class="tab-pane fade" id="form">
								<p class="sub-heading">Allow vmw to enter malaria data with specie</p>
								<ul class="ui-checklist">
									<li>
										<h6 class="heading">Pf</h6>
									</li>
									<li>
										<h6 class="heading">Pv</h6>
									</li>
									<li>
										<h6 class="heading">Mix</h6>
									</li>
									<li>
										<h6 class="heading">Negative</h6>
									</li>
								</ul>
							</div>

							<!-- Tab 3 -->
							<div role="tabpanel" class="tab-pane fade" id="report">
								<p class="sub-heading">Allow vmw to see data with filter by</p>
								<ul class="ui-checklist">
									<li>
										<h6 class="heading">Year</h6>
									</li>
									<li>
										<h6 class="heading">Month</h6>
									</li>
								</ul>
							</div>
							<!-- Tab 4 -->
							<div role="tabpanel" class="tab-pane fade" id="followup">
								<p class="sub-heading">Allow VMW to enter Follow up pateint data and able to filter by</p>
								<ul class="ui-checklist">
									<li>
										<h6 class="heading">Year</h6>
									</li>
									<li>
										<h6 class="heading">Month</h6>
									</li>
								</ul>
							</div>
							
							
						</div><!-- .tab-content -->
					</div><!-- .ui-tabs -->

				</div><!-- Tabs Column -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .section -->

	<!-- Call To Action Section -->
	<div id="download" class="section bg-indigo ui-section-tilt ui-action-section">
		<div class="container">
			<div class="row">
				<!-- Text Column -->
				<div class="col-md-6 col-sm-7 text-block">
					<!-- Section Heading -->
					<div class="section-heading">
						<h2 class="heading">
							Available for Android OS
						</h2>
						<p class="paragraph">
							Click the following button to download for Android Mobile Phone.
						</p> 
						<div class="actions">
							<a href="/App" class="btn ui-gradient-green btn-google-play btn-download shadow-lg">
								<span>Available to</span>
								<span>Download</span>
							</a>
						</div>
					</div><!-- .section-heading -->
				</div>
				<!-- Image Column -->
				<div class="col-md-6 col-sm-5 img-block animate" data-show="fade-in-left">
					<img src="/media/assetsApp/img/mis-app.png" alt="Malaria Reporting App for VMW" data-uhd class="responsive-on-sm" data-max_width="547" />
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .section -->

	<!-- App Screens Section -->
	<div id="screens" class="section">
		<div class="container">
			<!-- Dection Heading -->
			<div class="section-heading center">
				<h2 class="heading text-indigo">
					App Screens
				</h2>
				<p class="paragraph">
					Browse our features
				</p>
			</div><!-- .section-heading -->
			<!-- App Screens Carousel -->
			<div class="ui-app-screens owl-carousel owl-theme animate" data-show="fade-in">
				
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/home.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>

				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/main-1.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/1.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/2.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/3.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/4.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/5.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/6.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/7.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/report.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/case-report/offline.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/followup/list.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/vmw/followup/1.jpg" alt="Malaria Reporting App for VMW" data-uhd/ />
				</div>
				
			</div><!-- .ui-app-screens -->
		</div><!-- .container -->
	</div><!-- .section -->

	<!-- App Stats Section -->
	<div class="section bg-overlay bg-overlay-gradient-blue" data-uhd>
		<div class="container">
			<div class="row ui-icon-blocks ui-blocks-h ui-stats icons-lg" data-duration="2000">
				<!-- Downloads -->
				<div class="col-sm-6 col-6 ui-icon-block">
					<span class="icon icon-cloud-download"></span>
					<h6 class="sub-heading">Downloads</h6>
					<h2 class="stat heading">8922</h2>
				</div>

				<!-- Active Device -->
				<div class="col-sm-6 col-6 ui-icon-block">
					<span class="icon icon-user"></span>
					<h6 class="sub-heading">Active Devices</h6>
					<h2 class="stat heading">2974</h2>
				</div>

			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .section -->

</div> <!-- /main-->

<?php $this->load->view('app/footer') ?>