<?php
$user = [
	'username' => $_SESSION['username'],
	'role' => $_SESSION['role'],
	'od' => $_SESSION['code_od'],
	'hc' => $_SESSION['code_hc'],
	'prov' => $_SESSION['prov'],
	'rg' => $_SESSION['code_rg'],
	'unit' => $_SESSION['code_unit'],
	'permiss' => $_SESSION['permiss']
];
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($title) ? $title : 'MIS' ?></title>
	<meta charset="utf-8" />
	<link href="/manifest.json" rel="manifest" />

	<?=latestCss('/media/assetsV2/CSS/preloader.css')?>
	<?=latestCss('/media/CSS/bootstrap.css')?>
	<link href="/media/CSS/font-awesome.css" rel="stylesheet" />
	<link href="/media/CSS/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="/media/Plugin/select2/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
	<?=latestCss('/media/CSS/style.css')?>

	<script src="/media/JavaScript/jquery-3.3.1.min.js"></script>
	<script src="/media/JavaScript/moment.min.js"></script>
    <script src="/media/Plugin/select2/select2.full.min.js"></script>
	<script src="/media/JavaScript/bootstrap.min.js"></script>
	<script src="/media/JavaScript/bootstrap-datetimepicker.min.js"></script>
	<script src="/media/JavaScript/jszip.min.js"></script>
	<script src="/media/JavaScript/merge-images.js"></script>
	<script src="/media/JavaScript/fontawesome-markers.min.js"></script>
	<script src="/media/JavaScript/FileSaver.js"></script>
	<script src="/media/JavaScript/xlsx.full.js"></script>
    
    <?php $this->load->view('highchartV8') ?>
    <?php $this->load->view('highchartV11') ?>
	<script src="/media/JavaScript/script.js"></script>
	<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/hourglass.js"></script>
	<?=latestJs("/media/JavaScript/pre-config.js")?>

	<!-- Knockout -->
	<?=latestJs('/media/JavaScript/knockout-3.4.0.js')?>
	<script src="/media/JavaScript/knockout.mapping.js"></script>
	<?=latestJs('/media/JavaScript/knockout.extension.js')?>
	<?=latestJs('/media/ViewModel/app.js')?>
    <?=latestJs('/media/JavaScript/knockout.validation.js')?>
    <?=latestJs('/media/JavaScript/loadash.js')?>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs@gh-pages/qrcode.min.js"></script>
    <?=form_hidden('chartODBorder', latestFile('/media/Maps/chartODBorder.js'))?>
    <?=form_hidden('chartNeighbourBorder', latestFile('/media/Maps/chartNeighbourBorder.js'))?>
    <?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>
    <?=form_hidden('forestFile', json_encode([latestFile('/media/Maps/forestMap.zip'), filesize('media/Maps/forestMap.zip')]))?>

	<script src="/media/JavaScript/google.maps.js"></script>
    <script src="/media/JavaScript/maplabel.js"></script>
</head>
<body id="style-6">
	<?php $this->view('modals'); ?>

    <div id="wrapper">
       <?php $this->view($main); ?>
    </div>

	<div id="footer">
		<marquee behavior="alternate">
			Copyright &copy; <?=date('Y')?> National Center for Parasitology Entomology and Malaria Control
		</marquee>
	</div>

    <?=form_hidden('SessionUser', json_encode($user))?>
    <?=form_hidden('PlaceUpdate', json_encode(readPlaceUpdate()))?>
	<?=form_hidden('IsMobile', $this->agent->is_mobile() ? 1 : 0)?>
    <?=latestJs("/media/JavaScript/post-config.js")?>

</body>
</html>