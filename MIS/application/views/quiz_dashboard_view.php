
<style>
	body {
		background-color: #f3f1f196;
	}

	.card {
		box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
		border: 2px solid #01c0c8;
		background: #fff;
	}
    .btn-circle {
        border-radius: 100%;
        width: 25px;
        height: 25px;
        padding: 2px;
    }
    * {
		font-family: Content, sans-serif;
    }
    .table td, .table th {
        padding: 0.2rem;
        vertical-align: top;
        white-space: nowrap;
    }

    .table thead th {
        border-bottom: none;
        vertical-align: middle;
        text-align: center;
		height: 40px;
    }

    .table thead tr th {
        font-weight: bold;
    }

    .table tbody {
        font-weight: 500;
    }

	.section-title {font-family:'Khmer OS Siemreap'; color: #2980b9; font-weight: 700}

    .outline-shadow {
        box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
        border: 1px solid #000;
    }

    .radius-right {
        border-radius: unset;
        border-top-right-radius: 20px;
    }

</style>

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dashboard</h4>
                    <div class="pull-right">
                        <a href="/Home" class="btn btn-dark pull-right">
                            <i class="fa fa-home"></i> Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form >
        <div class="container9">
            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select data-bind="value: pv,
											options: pvList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: pvList().length == 1 ? undefined : 'All Province'"
                                    class="form-control input-sm minwidth150 outline-shadow"></select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select data-bind="value: od,
											options: odList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: odList().length == 1 ? undefined : 'All OD'"
                                    class="form-control input-sm minwidth150 outline-shadow"></select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select data-bind="value: hc,
											options: hcList,
											optionsValue: 'code',
											optionsText: 'name',
											optionsCaption: 'All HC'"
                                    class="form-control outline-shadow"></select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button data-bind="click: $root.viewChart" class="btn btn-primary">View</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
    <hr style="margin-top:0" />
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card" margin: 0 auto">
            <div class="card-body">
                <div id="vmw"></div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card" margin: 0 auto">
            <div class="card-body">
                <div id="hc"></div>

            </div>
        </div>
    </div>
</div>


<?=latestJs('/media/ViewModel/QuizDashboard.js')?>