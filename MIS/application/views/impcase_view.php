<div class="panel panel-default" data-bind="visible: true" style="display:none">
    <div class="panel-heading clearfix" data-bind="visible: view() == 'list'">
        <div class="pull-left" id="menu">
            <button name="Case" class="btn btn-default width100">Case</button>
            <button name="Map" class="btn btn-default width100">Map</button>
        </div>
        <div class="pull-right">
            <a class="btn btn-default" href="/home">Home</a>
        </div>
    </div>

    <!-- -->
    <?php if ($tab == 'Case') $this->load->view('impcase_table_view') ?>
    <?php if ($tab == 'Map') $this->load->view('impcase_map_view') ?>

    <div class="panel-footer text-center" data-bind="visible: view() == 'detail' && ifcan('Edit')">
        <button class="btn btn-primary width150" data-bind="click: save">Save</button>
    </div>
</div>


<?=form_hidden('googleODBorder', latestFile('/media/Maps/googleODBorder.js'))?>

<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCVXxd9fjjh1c2wrsRlZfyHfEkBiI4XQ8Q"></script>
<script src="/media/JavaScript/maplabel.js"></script>
<?=latestJs('/media/ViewModel/ImpCase.js')?>