<!DOCTYPE html>
<html>
<head>
	<title>MIS</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

	<?=latestCss('/media/CSS/bootstrap.css')?>
	<?=latestCss('/media/CSS/style.css')?>
	<script src="/media/javascript/jquery-3.3.1.min.js"></script>

	<style>
		.panel { max-width: 500px; margin: 10px auto; }
		.input-group-addon { padding: 10px !important; }
		.input-group-addon span { width: 90px; display: inline-block; }
	</style>
</head>
<body>
	<div class="panel panel-default">
		<div class="panel-heading text-center">
			<span class="text-primary" style="font-size:26px">Malaria Information System (MIS)</span>
		</div>
		<div class="panel-body">
			<form method="post" onsubmit="$('body').hide()">
				<div class="form-group">
					<div class="input-group input-group-lg">
						<span class="input-group-addon">
							<span>Username</span>
						</span>
						<input type="text" name="usr" class="form-control" required />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
						<span class="input-group-addon">
							<span>Password</span>
						</span>
						<input type="password" name="pwd" class="form-control" required />
					</div>
				</div>

				<?php if ($invalid) { ?>
				<div class="form-group text-danger text-center">Username or Password is not correct.</div>
				<?php } ?>

				<button class="btn btn-primary btn-block btn-lg">Login</button>

				<input type="hidden" name="form" value="questionbank" />
			</form>
		</div>
	</div>
</body>
</html>