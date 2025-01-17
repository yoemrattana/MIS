<?php $this->load->view('app/header') ?>

<nav class="navbar navbar-fixed-top transparent navbar-light bg-white">
	<div class="container">

		<!-- Navbar Logo -->
		<a class="ui-variable-logo navbar-brand" href="#" title="Cambodia Malaria Information">
			<!-- Default Logo -->
			<img class="logo-default" src="/media/assetsApp/img/cnm.png" alt="Cambodia Cambodia Malaria Information" data-uhd />
			<!-- Transparent Logo -->
			<img class="logo-transparent" src="/media/assetsApp/img/cnm.png" alt="Cambodia Cambodia Malaria Information" data-uhd />
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
						Cambodia Malaria Info
					</h1>
					<p class="paragraph">
						Available for Guest, OD, PHD, CSO, National
					</p>
					<div class="actions">
						<a class="btn ui-gradient-blue shadow-xl" data-scrollto="features">Learn More</a>
						<a class="btn ui-gradient-green shadow-xl" href="#" data-scrollto="download">Download</a>
					</div>
				</div>
				<div class="col-sm-12">
					<img src="/media/assetsApp/img/cmi.png" alt="Cambodia Malaria Reporting App" data-uhd data-max_width="740" class="responsive-on-md" />
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
					Main Features
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
							<img src="/media/assetsApp/img/device.png" style="height:625px !important" data-uhd alt="Cambodia Malaria Information" />
						</div>
						<!-- Slider Images -->
						<div id="device-slider-2" class="screens owl-carousel owl-theme">
							<div class="item">
								<img src="/media/assetsApp/img/cmi/1.jpg" data-uhd alt="Cambodia Malaria Information" />
							</div>
							<div class="item">
								<img src="/media/assetsApp/img/cmi/2.jpg" data-uhd alt="Cambodia Malaria Information" />
							</div>
							<div class="item">
								<img src="/media/assetsApp/img/cmi/3.jpg" data-uhd alt="Cambodia Malaria Information" />
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
								<a class="nav-link active" href="#summary" role="tab" data-toggle="tab" data-toggle_screen="1" data-toggle_slider="device-slider-2">
									<span class="icon icon-home"></span> Summary
								</a>
							</li>
							<!-- Nav Tab 2 -->
							<li role="presentation" class="nav-item">
								<a class="nav-link" href="#dashboard" role="tab" data-toggle="tab" data-toggle_screen="2" data-toggle_slider="device-slider-2">
									<span class="fa fa-wpforms"></span> Dashboard
								</a>
							</li>

							<li role="presentation" class="nav-item">
								<a class="nav-link" href="#contact" role="tab" data-toggle="tab" data-toggle_screen="3" data-toggle_slider="device-slider-2">
									<span class="fa fa-th"></span> Contact
								</a>
							</li>

						</ul>

						<!-- Tab Panels -->
						<div class="tab-content">
							<!-- Tab 1 -->
							<div role="tabpanel" class="tab-pane fade show active" id="summary">
								<p class="sub-heading">Summary Page</p>
								<ul class="ui-checklist">
									<li>
										<h6 class="heading">Monthly case</h6>
									</li>
									<li>
										<h6 class="heading">Weekly</h6>
									</li>
									<li>
										<h6 class="heading">Top malaria cases by OD</h6>
									</li>
									<li>
										<h6 class="heading">Number of Malaria Workers</h6>
									</li>
									<li>
										<h6 class="heading">Timeliness</h6>
									</li>
								</ul>
							</div>
							<!-- Tab 2 -->
							<div role="tabpanel" class="tab-pane fade" id="dashboard">
								<p class="sub-heading">Only for loged in user</p>
								<ul class="ui-checklist">
									<li>
										<h6 class="heading">Chart of Number of malaria cases and tests</h6>
									</li>
									<li>
										<h6 class="heading">Chart of Top 10 villages with Pf and Mix</h6>
									</li>
									<li>
										<h6 class="heading">Table of Top 10 villages by OD</h6>
									</li>
									<li>
										<h6 class="heading">Table of Stock out</h6>
									</li>
									<li>
										<h6 class="heading">Map of Malaria hotspot</h6>
									</li>
									<li>
										<h6 class="heading">Map of Health center and malaria worker</h6>
									</li>
								</ul>
							</div>

							<!-- Tab 3 -->
							<div role="tabpanel" class="tab-pane fade" id="contact">
								<p class="sub-heading">Mobile phone number and email</p>
								<ul class="ui-checklist">
									<li>
										<h6 class="heading">National</h6>
									</li>
									<li>
										<h6 class="heading">CSO</h6>
									</li>
									<li>
										<h6 class="heading">PHD</h6>
									</li>
									<li>
										<h6 class="heading">OD</h6>
									</li>
									<li>
										<h6 class="heading">HC</h6>
									</li>
									<li>
										<h6 class="heading">VMW</h6>
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
							Available for Android & iOS
						</h2>
						<p class="paragraph">
							Click the following button to download.
						</p>
						<div class="actions">
							<a href="https://apps.apple.com/kh/app/cambodia-malaria-info/id1561521536" target="_blank" class="btn ui-gradient-green btn-app-store btn-download shadow-lg">
								<span>Available on the</span>
								<span>App Store</span>
							</a>
							<a href="https://play.google.com/store/apps/details?id=kh.gov.cnm.mis.malaria&hl=en&gl=US" target="_blank" class="btn ui-gradient-blue btn-google-play btn-download shadow-lg">
								<span>Available on </span>
								<span>Google Play</span>
							</a>
						</div>
					</div><!-- .section-heading -->
				</div>
				<!-- Image Column -->
				<div class="col-md-6 col-sm-5 img-block animate" data-show="fade-in-left">
					<img src="/media/assetsApp/img/cmi.png" alt="Cambodia Malaria Information" data-uhd class="responsive-on-sm" data-max_width="547" />
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
					<img src="/media/assetsApp/img/cmi/1.jpg" alt="Cambodia Malaria Information" data-uhd/ />
				</div>

				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/cmi/2.jpg" alt="Cambodia Malaria Information" data-uhd/ />
				</div>

				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/cmi/3.jpg" alt="Cambodia Malaria Information" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/cmi/4.jpg" alt="Cambodia Malaria Information" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/cmi/5.jpg" alt="Cambodia Malaria Information" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/cmi/6.jpg" alt="Cambodia Malaria Information" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/cmi/7.jpg" alt="Cambodia Malaria Information" data-uhd/ />
				</div>
				<div class="ui-card shadow-lg">
					<img src="/media/assetsApp/img/cmi/8.jpg" alt="Cambodia Malaria Information" data-uhd/ />
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
					<h2 class="stat heading">1363</h2>
				</div>

				<!-- Active Device -->
				<div class="col-sm-6 col-6 ui-icon-block">
					<span class="icon icon-user"></span>
					<h6 class="sub-heading">Active Devices</h6>
					<h2 class="stat heading">909</h2>
				</div>

			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .section -->

</div><!-- /main-->

<?php $this->load->view('app/footer') ?>