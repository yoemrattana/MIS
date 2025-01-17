<!DOCTYPE html>
<html>
<head>
	<style>
		body { margin: 0; padding: 0; }
		#map { width: 1000px; height: 800px; }
		canvas { position: absolute; left: 1000px; top: 0; }
	</style>
</head>
<body>
	<div id="map"></div>
	<canvas id="canvas" width="1000" height="800"></canvas>

	<?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>

	<script src="/media/JavaScript/jquery-3.3.1.min.js"></script>
	<script src="/media/JavaScript/jszip.min.js"></script>
	<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCVXxd9fjjh1c2wrsRlZfyHfEkBiI4XQ8Q"></script>
	<script src="/media/JavaScript/maplabel.js"></script>
	<script src="/media/JavaScript/loadash.js"></script>

	<?=latestJs('/media/ViewModel/GoogleMapTester.js')?>
</body>
</html>