<div class="panel panel-default" style="margin:-10px">
	<div class="panel-heading clearfix">
		<div class="pull-left font16 lh26 text-bold" style="position:sticky; left:11px">
			Loading Data - Prease Wait...
		</div>
		<div class="pull-right hidden-print" style="position:sticky; right:11px">
			<button class="btn btn-default btn-sm width100" onclick="window.close()">Back</button>
		</div>
	</div>
	<div class="panel-body">
		<?php
		if (count($data) > 0) {
			$template = [
				'table_open' => '<table class="table table-bordered table-hover">',
				'tbody_open' => '<tbody data-bind="fixedHeader: true">'
			];
			$this->table->set_template($template);
			$this->table->set_heading(array_keys($data[0]));
			echo $this->table->generate($data);
		} else {
			echo '<h2 class="text-warning text-center">No Data</h2>';
		}
		?>
	</div>
</div>

<script>
	$('.pull-left').text('Preview Data');
</script>