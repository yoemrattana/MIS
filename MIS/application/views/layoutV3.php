<?php
$user = [
	'username' => $_SESSION['username'],
	'role' => $_SESSION['role'],
	'od' => $_SESSION['code_od'],
	'prov' => $_SESSION['prov'],
	'rg' => $_SESSION['code_rg'],
	'permiss' => $_SESSION['permiss']
];

$isMobile = $this->agent->is_mobile();
?>

<html>
<head>
	<title>
		<?php echo isset($title) ? $title : 'MIS' ?>
	</title>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

	<?=latestCss('/media/assetsV2/CSS/preloader.css')?>
	<?=latestCss('/media/assetsV3/css/style.min.css')?>
	<?=latestCss('/media/assetsV3/css/contact/util.css')?>
	<?=latestCss('/media/assetsV3/css/contact/main.css')?>
    <?=latestCss('/media/assetsV3/css/dashboard.css')?>

	<link href="/media/CSS/font-awesome.css" rel="stylesheet" />
	<link href="/media/CSS/bootstrap-datetimepicker.min.css" rel="stylesheet" />
	<link href="/media/assetsV3/css/pages/chat-app-page.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<?=latestCss('/media/CSS/style.css')?>
	<link href="/media/CSS/pager.css" rel="stylesheet" />
    <link href="/media/assetsV3/css/bootstrap-float-label.min.css" rel="stylesheet" />

    <link href="/media/assetsV3/plugins/nineslider/css/style.css" rel="stylesheet" />

	<script src="/media/JavaScript/jquery-3.3.1.min.js"></script>
	<script src="/media/JavaScript/moment.min.js"></script>
	<script src="/media/JavaScript/bootstrap-datetimepicker.min.js"></script>
	<script src="/media/JavaScript/jszip.min.js"></script>
	<script src="/media/JavaScript/merge-images.js"></script>
	<script src="/media/JavaScript/fontawesome-markers.min.js"></script>
	<script src="/media/JavaScript/FileSaver.js"></script>
	<script src="/media/highchart/proj4.js"></script>
	<script src="/media/highchart/highcharts.js"></script>
	<script src="/media/highchart/highcharts-map.js"></script>
	<script src="/media/highchart/highcharts-more.js"></script>
    <script src="/media/highchart/solid-gauge.js"></script>
	<script src="/media/highchart/exporting.js"></script>
	<script src="/media/highchart/offline-exporting.js"></script>
	<script src="/media/highchart/export-data.js"></script>

	<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/hourglass.js"></script>
    
	<?=latestJs('/media/JavaScript/script.js')?>
	<?=latestJs("/media/JavaScript/pre-config.js")?>

	<!-- Knockout -->
	<?=latestJs('/media/JavaScript/knockout-3.4.0.js')?>
	<script src="/media/JavaScript/knockout.mapping.js"></script>
	<?=latestJs('/media/JavaScript/knockout.extension.js')?>
	
	<?=latestJs('/media/JavaScript/pager.min.js')?>
	<script src="/media/JavaScript/jquery.ba-hashchange.min.js"></script>
	<?=latestJs('/media/ViewModel/app.js')?>
	<?=latestJs('/media/JavaScript/knockout.validation.js')?>
	<?=latestJs('/media/assetsV3/js/bootstrap.min.js')?>
	<?=latestJs('/media/assetsV3/js/custom.min.js')?>
	<?=latestJs('/media/assetsV3/js/perfect-scrollbar.jquery.min.js')?>
    
</head>
<body>
	<?php $this->load->view('modals'); ?>

    <div id="wrapper9" style="padding: 10px 10px 50px 10px;">
        <?php $this->load->view($main); ?>
    </div>

	<div id="footer">
		Copyright &copy; <?=date('Y')?> National Center for Parasitology Entomology and Malaria Control
	</div>

	<?=form_hidden('SessionUser', json_encode($user))?>
	<?=form_hidden('PlaceUpdate', json_encode(readPlaceUpdate()))?>
	<?=form_hidden('IsMobile', $this->agent->is_mobile() ? 1 : 0)?>

	<?=latestJs("/media/JavaScript/run2.js")?>
    <script src="/media/assetsV3/plugins/nineslider/js/nineslider.js"></script>
</body>

</html>