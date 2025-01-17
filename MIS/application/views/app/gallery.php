<?php $isMobile = $this->agent->is_mobile(); ?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CNM - Malaria Information System</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:600|Source+Sans+Pro:600,700" rel="stylesheet">
	<link rel="stylesheet" href="/media/assetsApp/css/applify.min.css"/>
	<style>
        div#arrow {
            position: fixed;
            bottom: 34px;
            right: 5vw;
			z-index:99999;
        }
	</style>
</head>
<body class="ui-transparent-nav" data-fade_in="on-load">

	<!-- Navbar Fixed + Default -->
	<?php if ($isMobile == false) : ?>
    <!--<nav class="navbar navbar-fixed-top transparent navbar-light bg-white">
		<div class="container">
			<a class="ui-variable-logo navbar-brand" href="#" title="CNM MIS">
				
				<img class="logo-default" src="/media/assetsApp/img/cnm.png" alt="CNM MIS" data-uhd>
				
				<img class="logo-transparent" src="/media/assetsApp/img/cnm.png" alt="CNM MIS" data-uhd>
			</a>
			<a href="/Home" class="btn btn-sm ui-gradient-peach">Back</a>
			<a href="#" class="ui-mobile-nav-toggle"></a>
		</div>
	</nav>--> 

	<?php endif; ?>
	
	<!-- Main Wrapper -->
    <div class="main" role="main">
    	
    	<!-- Waves Hero -->
		<div class="ui-hero hero-lg ui-waves ui-gradient-purple" >
			<div class="container">
				<div class="row">
					<div class="col-md-6" data-vertical_center="true" data-vertical_offset="16">
						<h1 class="heading animate" data-show="fade-in-up-big" data-delay="100">
							Cambodia Malaria Mobile Application
						</h1>
						<!-- <p class="paragraph animate" data-show="fade-in-up-big" data-delay="400">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
						</p> -->
						 <!--<div class="actions animate" data-show="fade-in-up-big" data-delay="600">
							<a class="btn ui-gradient-blue shadow-xl">Learn More</a>
							<a class="btn ui-gradient-green shadow-xl">Download</a>
						</div>--> 
					</div>
					<div class="col-md-6 animate" data-show="fade-in-left" data-delay="400">
						<img src="/media/assetsApp/img/all-app.png" alt="cnm application" data-uhd data-max_width="640" class="responsive-on-sm" />
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .ui-hero .slider-pro -->
   		
   		<!-- App Features Section -->
		<div id="how-it-works" class="section">
   			<div class="container ui-icon-blocks ui-blocks-h icons-lg">
   				<div class="section-heading cente">
   					<h2 class="heading text-indigo">
   						Welcome to CNM App
   					</h2>
   					<p class="paragraph">
   						All Applications are available to download following below links.
   					</p>
   				</div><!-- .section-heading -->
   			</div><!-- .container -->
   		</div><!-- .section -->
   			
   		<!-- Call To Action Section -->
   		<div class="section ui-gradient-blue ui-action-section z-index-2">
   			<div class="container">
   				<div class="row">
   					<!-- Text Column -->
   					<div class="col-lg-6 col-md-7 text-block" data-vertical_center="true">
   						<!-- Section Heading -->
   						<div class="section-heading">
							<h2 class="heading">
								VMW Malaria Reporting App
							</h2>
							
							<div class="actions">
								<a href="http://mis.cnm.gov.kh/app" target="_blank" class="btn ui-gradient-blue btn-google-play btn-download shadow-lg"><span>Download </span> <span>MIS App</span></a>
								<a href="http://mis.cnm.gov.kh/app/vmw" target="_blank" class="btn ui-gradient-green btn-learnmore btn-download shadow-lg">
									<span>Learn </span>
									<span>More...</span>
								</a>
							</div>
						</div><!-- .section-heading -->
   					</div>
   					<!-- Image Column -->
   					<div class="col-lg-6 col-md-5 img-block animate" data-show="fade-in-left">
   						<img src="/media/assetsApp/img/mis-app.png" alt="mis application" data-uhd class="responsive-on-sm" data-max_width="398" />
   					</div>
   				</div><!-- .row -->
   			</div><!-- .container -->
   		</div><!-- .section -->

		<div class="section bg-overlay ui-action-section z-index-2">
			<div class="container">
				<div class="row">
					<!-- Text Column -->
					<div class="col-lg-6 col-md-7 text-block" data-vertical_center="true">
						<!-- Section Heading -->
						<div class="section-heading">
							<h2 class="heading">
								HC Malaria Reporting App
							</h2>
							
							<div class="actions">
								<a href="http://mis.cnm.gov.kh/app" target="_blank" class="btn ui-gradient-blue btn-google-play btn-download shadow-lg">
									<span>Download </span>
									<span>MIS App</span>
								</a>
								<a href="http://mis.cnm.gov.kh/app/hc" target="_blank" class="btn ui-gradient-green btn-learnmore btn-download shadow-lg">
									<span>Learn </span>
									<span>More...</span>
								</a>
							</div>
						</div><!-- .section-heading -->
					</div>
					<!-- Image Column -->
					<div class="col-lg-6 col-md-5 img-block animate" data-show="fade-in-left">
						<img src="/media/assetsApp/img/main-hc.jpg" alt="mis application" data-uhd class="responsive-on-sm shadow-lg" data-max_width="425" />
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section -->

		<div class="section bg-green ui-action-section z-index-3">
			<div class="container">
				<div class="row">
					<!-- Text Column -->
					<div class="col-lg-6 col-md-7 text-block" data-vertical_center="true">
						<!-- Section Heading -->
						<div class="section-heading">
							<h2 class="heading">
								Cambodia Malaria Information
							</h2>
							
							<div class="actions">
								<a href="https://apps.apple.com/kh/app/cambodia-malaria-info/id1561521536" target="_blank" class="btn ui-gradient-green btn-app-store btn-download shadow-lg">
									<span>Available on the</span>
									<span>App Store</span>
								</a>
								<a href="https://play.google.com/store/apps/details?id=kh.gov.cnm.mis.malaria&hl=en&gl=US" target="_blank" class="btn ui-gradient-blue btn-google-play btn-download shadow-lg">
									<span>Available on </span>
									<span>Google Play</span>
								</a>
								
								<a href="http://mis.cnm.gov.kh/app/cmi" target="_blank" class="btn ui-gradient-purple btn-learnmore btn-download shadow-lg" style="margin-top: 5px">
									<span>Learn </span>
									<span>More...</span>
								</a>
							</div>
						</div><!-- .section-heading -->
					</div>
					<!-- Image Column -->
					<div class="col-lg-6 col-md-5 img-block animate" data-show="fade-in-left">
						<img src="/media/assetsApp/img/cmi.png" alt="cnm cmi" data-uhd class="responsive-on-sm" data-max_width="398" />
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section -->


   		<div class="section bg-overlay ui-action-section z-index-2">
   			<div class="container">
   				<div class="row">
   					<!-- Text Column -->
   					<div class="col-lg-6 col-md-7 text-block" data-vertical_center="true">
   						<!-- Section Heading -->
   						<div class="section-heading">
							<h2 class="heading">
								QA Application
							</h2>
							
							<div class="actions">
								<a href="https://play.google.com/store/apps/details?id=kh.gov.cnm.mis.vmwqa&hl=en&gl=US" target="_blank" class="btn ui-gradient-blue btn-google-play btn-download shadow-lg">
									<span>Available on </span>
									<span>Google Play</span>
								</a>
								<a href="http://mis.cnm.gov.kh/app/qa" target="_blank" class="btn ui-gradient-green btn-learnmore btn-download shadow-lg">
									<span>Learn </span>
									<span>More...</span>
								</a>
							</div>
						</div><!-- .section-heading -->
   					</div>
   					<!-- Image Column -->
   					<div class="col-lg-6 col-md-5 img-block animate" data-show="fade-in-left">
   						<img src="/media/assetsApp/img/qa-app.png" alt="QA application" data-uhd class="responsive-on-sm" data-max_width="425" />
   					</div>
   				</div><!-- .row -->
   			</div><!-- .container -->
   		</div><!-- .section -->

		<div class="section bg-indigo ui-action-section z-index-3">
			<div class="container">
				<div class="row">
					<!-- Text Column -->
					<div class="col-lg-6 col-md-7 text-block" data-vertical_center="true">
						<!-- Section Heading -->
						<div class="section-heading">
							<h2 class="heading">
								Checklist Application
							</h2>
							<p class="paragraph"></p>
							<div class="actions">
								
								 <!--<a class="btn ui-gradient-green btn-app-store btn-download shadow-lg"><span>Available on the</span> <span>App Store</span></a>-->
                                <a href="/media/assetsApp/Checklist-for-Supervision.apk" class="btn ui-gradient-blue btn-google-play btn-download shadow-lg">
                                    <span>Download</span>
									<span>Checklist App</span>
                                </a> 
								<a href="http://mis.cnm.gov.kh/app/checklist" target="_blank" class="btn ui-gradient-green btn-learnmore btn-download shadow-lg">
									<span>Learn </span>
									<span>More...</span>
								</a>
							</div>
						</div><!-- .section-heading -->
					</div>
					<!-- Image Column -->
					<div class="col-lg-6 col-md-5 img-block animate" data-show="fade-in-left">
						<img src="/media/assetsApp/img/checklist-app.png" alt="cnm checklist app" data-uhd class="responsive-on-sm" data-max_width="425" />
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section -->

		<div class="section bg-overlay ui-action-section z-index-3">
			<div class="container">
				<div class="row">
					<!-- Text Column -->
					<div class="col-lg-6 col-md-7 text-block" data-vertical_center="true">
						<!-- Section Heading -->
						<div class="section-heading">
							<h2 class="heading">
								MIS Web base Application
							</h2>
							
							
						</div><!-- .section-heading -->
						<div class="actions">

							<!-- <a class="btn ui-gradient-green btn-app-store btn-download shadow-lg"><span>Available on the</span> <span>App Store</span></a>
								<a class="btn ui-gradient-blue btn-google-play btn-download shadow-lg"><span>Available on </span> <span>Google Play</span></a> -->
							<a href="http://mis.cnm.gov.kh/app/web" target="_blank" class="btn ui-gradient-green btn-learnmore btn-download shadow-lg">
								<span>Learn </span>
								<span>More...</span>
							</a>
						</div>
					</div>
					<!-- Image Column -->
					<div class="col-lg-6 col-md-5 img-block animate" data-show="fade-in-left">
						<img src="/media/assetsApp/img/main-web.jpg" alt="cnm checklist app" data-uhd class="responsive-on-sm shadow-lg" data-max_width="425" />
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section -->
   		
   		<!-- Subscribe Footer -->
   		<footer class="ui-footer subscribe-footer ui-waves">
   			<div class="ui-gradient-purple footer-bg">
   					
   			</div><!-- .footer-bg -->
   				
   			<!-- Footer Copyright -->
   			<div class="footer-copyright bg-dark-gray">
   				<div class="container">
					<div class="row">
						<!-- Copyright -->
						<div class="col-6">
							<p>
								&copy; 2021 All Rights Reserved
							</p>
						</div>
					</div>
   				</div><!-- .container -->
   			</div><!-- .footer-copyright -->
   		</footer><!-- .ui-footer -->
    </div><!-- .main -->
    
    <!-- Scripts -->
	<script type="text/javascript" src="/media/assetsApp/js/libs/jquery/jquery-3.2.1.min.js"></script>
	<!--<script type="text/javascript" src="/media/assetsApp/js/libs/slider-pro/jquery.sliderPro.min.js"></script>
	<script type="text/javascript" src="/media/assetsApp/js/libs/owl.carousel/owl.carousel.min.js"></script>	
	<script type="text/javascript" src="/media/assetsApp/js/libs/form-validator/form-validator.min.js"></script>-->
	<script type="text/javascript" src="/media/assetsApp/js/libs/bootstrap.js"></script>
	<script type="text/javascript" src="/media/assetsApp/js/applify/build/applify.js"></script>

	<div id=arrow>
		<a href="#">
			<img src="https://media4.giphy.com/media/W6LvJ3rgpb68b2EA11/giphy.gif?cid=ecf05e47mmq607l9wvzh4dchqgdd4sj1wru2b1vxp9crtt6u&rid=giphy.gif&ct=s" width="80px" height="100px" alt="cnm app" />
		</a>
	</div>
</body>

</html>