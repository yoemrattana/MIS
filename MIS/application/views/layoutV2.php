<?php
$header = $main == 'home' ? '' : 'hide';
if ($isLogin) {
    $user = [
	    'username' => $_SESSION['username'],
	    'role' => $_SESSION['role'],
	    'od' => $_SESSION['code_od'],
	    'prov' => $_SESSION['prov'],
		'rg' => $_SESSION['code_rg'],
	    'permiss' => $_SESSION['permiss']
    ];
}
?>

<html>
<head>
    <title><?php echo isset($title) ? $title : 'MIS' ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link href="/manifest.json" rel="manifest" />
	
	<link href="/media/CSS/font-awesome.css" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' />
    <link href='/media/assetsV2/css/animations.css' rel='stylesheet'  media='all' />
    <?=latestCss('/media/assetsV2/css/mystyle.css')?>
	<?=latestCss('/media/assetsV2/css/colors.css')?>
    <?=latestCss('/media/assetsV2/css/login.css')?>
	<?=latestCss('/media/assetsV2/CSS/preloader.css')?>
    <?=latestCss('/media/CSS/bootstrap.css')?>
    <?=latestCss('/media/CSS/style.css')?>

    <script src="/media/JavaScript/jquery-3.3.1.min.js"></script>
    <script src="/media/JavaScript/moment.min.js"></script>
    <script src="/media/JavaScript/bootstrap.min.js"></script>
    <script src="/media/JavaScript/FileSaver.js"></script>
    <?=latestJs('/media/JavaScript/script.js')?>
	<?=latestJs("/media/JavaScript/pre-config.js")?>
	
    <script src='/media/assetsV2/js/jquery.js'></script>
    <script src='/media/assetsV2/js/foundation.min.js'></script>
    <script src='/media/assetsV2/js/modernizr.custom.js'></script>
    <script src='/media/assetsV2/js/foundation.section.js'></script>
    <script src='/media/assetsV2/js/responsiveslides.js'></script>
    <script src='/media/assetsV2/js/scripts.js'></script>

	<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/hourglass.js"></script>

    <!-- Knockout -->
    <?=latestJs('/media/JavaScript/knockout-3.4.0.js')?>
    <script src="/media/JavaScript/knockout.mapping.js"></script>
    <?=latestJs('/media/JavaScript/knockout.extension.js')?>
    <?=latestJs('/media/ViewModel/app.js')?>
   
</head>
<body class="v2">
    <?php $this->load->view('modals'); ?>
    <?php $this->load->view($main); ?>

    <?php if ($isLogin) echo form_hidden('SessionUser', json_encode($user)); ?>
    <?=form_hidden('PlaceUpdate', json_encode(readPlaceUpdate()))?>
	<?=form_hidden('IsMobile', $this->agent->is_mobile() ? 1 : 0)?>

	<?=latestJs("/media/JavaScript/post-config.js")?>
</body>
</html>