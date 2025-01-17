<div id="sysmenuboard" class="panel panel-default">
	<div class="panel-heading clearfix">
		<div class="pull-left form-inline">
			<strong>System Table</strong>
			<?php echo form_dropdown('systable',$systablelist,$systable,'class="form-control input-sm" id="systable"');?>

			<strong style="margin-left:10px">Province</strong>
			<?php echo form_dropdown('code_prov',$provlist,$code_prov,'class="form-control input-sm" id="code_prov"'); ?>
		</div>
		<div class="pull-right">
			<a href="/Home" class="btn btn-default btn-sm">Home</a>
		</div>
	</div>
</div>