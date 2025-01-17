<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="robots" content="noindex" />

	<title>MIS Log Viewer</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css" />
	<style type="text/css">
		td {
			word-wrap: break-word;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>MIS Log Viewer</h1>
		<a style="margin-bottom: 10px" class="btn btn-primary btn-sm pull-right" href="/">Home</a>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="input-group">
							<input type="date" class="form-control" value="<?=$log_date?>" id="log_date" />
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" id="apply">Apply</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table" id="log_table">
								<thead>
									<tr>
										<th>id</th>
										<th>level</th>
										<th width="80">time</th>
										<th>message</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$classes = array(
										'ERROR' => 'danger',
										'DEBUG' => 'warning',
										'INFO'  => 'info'
									);
									if( !empty( $cols ) ) {
									for ($i=0; $i<count($cols['level']); $i++) {
									?>
									<tr>
										<td class="<?php echo $classes[$cols['level'][$i]]; ?>">
											<?php echo $i+1; ?>
										</td>
										<td class="<?php echo $classes[$cols['level'][$i]]; ?>">
											<?php echo $cols['level'][$i]; ?>
										</td>
										<td class="<?php echo $classes[$cols['level'][$i]]; ?>">
											<?php
												$date=date_create($cols['time'][$i]);
												echo date_format($date, "d-m-Y") . '<br>' . date_format($date, "H:i:s");
											?>
										</td>
										<td class="<?php echo $classes[$cols['level'][$i]]; ?>">
											<?php echo $cols['message'][$i]; ?>
										</td>
									</tr>
									<?php
									}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#log_table').dataTable({
				"pageLength": 50
			});

			$('#apply').on('click', function() {
				window.location.href = "<?php echo base_url('log/'); ?>" + $('#log_date').val();
			});
		});
	</script>
</body>
</html>
