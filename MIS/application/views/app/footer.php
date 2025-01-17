
   		<footer class="ui-footer">	
   			<!-- Footer Copyright -->
   			<div class="footer-copyright bg-dark-gray">
   				<div class="container">
					<div class="row">
						<!-- Copyright -->
						<div class="col-6">
							<p>
								&copy; 2021 CNM - MIS
							</p>
						</div>
					</div>
   				</div><!-- .container -->
   			</div><!-- .footer-copyright -->
   		</footer><!-- .ui-footer -->
    </div><!-- .main -->
    
    <!-- Scripts -->
	<script type="text/javascript" src="/media/assetsApp/js/libs/jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/media/assetsApp/js/libs/slider-pro/jquery.sliderPro.min.js"></script>
	<script type="text/javascript" src="/media/assetsApp/js/libs/owl.carousel/owl.carousel.min.js"></script>	
	<!--<script type="text/javascript" src="/media/assetsApp/js/libs/form-validator/form-validator.min.js"></script>-->
	<script type="text/javascript" src="/media/assetsApp/js/libs/bootstrap.js"></script>
	<script type="text/javascript" src="/media/assetsApp/js/applify/build/applify.js"></script>

	<script src="/media/assetsApp/plugin/gallery/lightgallery.umd.js"></script>

    <!-- lightgallery plugins -->
    <script src="/media/assetsApp/plugin/gallery/plugins/thumbnail/lg-thumbnail.umd.js"></script>
    <script src="/media/assetsApp/plugin/gallery/plugins/zoom/lg-zoom.umd.js"></script>

	<script type="text/javascript">
    	$(document).ready(function () {
    		lightGallery(document.getElementById('inline-gallery-container'), {
    			plugins: [lgZoom, lgThumbnail],
    			speed: 500,
    			thumbnail:true,
    			licenseKey: 'your_license_key'

    		});
    	});
		
	</script>
</body>
</html>