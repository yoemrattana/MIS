<style>
	.table th, .table td { vertical-align:middle !important; }
	.space { margin-left:20px; }
	.form-group { margin-bottom:5px; }
	.chart-container {
		border: 2px solid #01c0c8;
		box-shadow: 0 0 10px rgba(0,0,0,.15), 0 3px 3px rgba(0,0,0,.15);
		margin-bottom: 15px;
		padding: 15px 10px;
	}
</style>

<div class="panel panel-default" data-bind="visible: true" style="display:none">
	<div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
		<div class="pull-left">
            <button class="btn" data-bind="click: menuClick, css: menuCss($element), visible: app.user.permiss['iDes'].contain('Linelist of iDES Cases')">Linelist of iDES Cases</button>
            <button class="btn" data-bind="click: menuClick, css: menuCss($element), visible: app.user.permiss['iDes'].contain('Blood Slides/DBS')">Blood Slides/DBS</button>
            <button class="btn width100" data-bind="click: menuClick, css: menuCss($element), visible: app.user.permiss['iDes'].contain('Tables') ">Tables</button>
            <button class="btn width100" data-bind="click: menuClick, css: menuCss($element), visible: app.user.permiss['iDes'].contain('Graphs')">Graphs</button>
            <button class="btn width100" data-bind="click: menuClick, css: menuCss($element), visible: app.user.permiss['iDes'].contain('Notification')">Notification</button>
            <button class="btn" data-bind="click: menuClick, css: menuCss($element), visible: app.user.permiss['iDes'].contain('Upcoming Follow-up')">Upcoming Follow-up</button>
			<button class="btn width100" data-bind="click: menuClick, css: menuCss($element), visible: app.user.permiss['iDes'].contain('Permission')" style="margin-left:15px">Permission</button>
		</div>
		<div class="pull-right" style="position:sticky; right:21px">
			<a href="/Home" class="btn btn-default">Home</a>
		</div>
	</div>
	<div class="panel-heading" data-bind="visible: view() == 'list' && menu().in('Linelist of iDES Cases','HC','VMW','PRH/RH')">
		<button class="btn width100" data-bind="click: menuClick, css: menuCss($element)">HC</button>
		<button class="btn width100" data-bind="click: menuClick, css: menuCss($element)">VMW</button>
		<button class="btn width100" data-bind="click: menuClick, css: menuCss($element)">PRH/RH</button>
	</div>
    <div class="panel-heading" data-bind="visible: view() == 'list' && menu().contain('Follow-up')">
		<button class="btn" data-bind="click: menuClick, css: menuCss($element)">PRH Follow-up</button>
		<button class="btn" data-bind="click: menuClick, css: menuCss($element)">RH Follow-up</button>
		<button class="btn" data-bind="click: menuClick, css: menuCss($element)">HC Follow-up</button>
        <button class="btn" data-bind="click: menuClick, css: menuCss($element)">VMW Follow-up</button>
    </div>

	<?php $this->load->view('ides_form_view') ?>
	<?php $this->load->view('ides_dbs_view') ?>
	<?php $this->load->view('ides_table_view') ?>
	<?php $this->load->view('ides_graph_view') ?>
	<?php $this->load->view('ides_permission_view') ?>
    <?php $this->load->view('ides_notification_view') ?>
    <?php $this->load->view('ides_upcomingfu_view') ?>
</div>

<?=form_hidden('chartODBorder', latestFile('/media/Maps/chartODBorder.js'))?>

<?=latestJs('/media/ViewModel/iDes.js')?>
<?=latestJs('/media/ViewModel/iDes_DBS.js')?>
<?=latestJs('/media/ViewModel/iDes_Table.js')?>
<?=latestJs('/media/ViewModel/iDes_Graph.js')?>
<?=latestJs('/media/ViewModel/iDes_Permission.js')?>
<?=latestJs('/media/ViewModel/iDes_Notification.js')?>