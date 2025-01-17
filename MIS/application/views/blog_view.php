
<style>
    body {
        background-color: #f3f1f196;
    }

    .card {
        box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
        border: 2px solid #01c0c8;
        background: #fff;
    }

    .table td, .table th {
        padding: 6px !important;
        text-align: center;
        vertical-align: middle !important;
    }

    .table tr {
        height:36px;
    }

    .tbl-label {
        vertical-align: middle !important;
    }

    table thead tr th {
        font-family: 'Khmer OS Battambang';
        font-weight: 700;
    }

    .table thead th {
        border-bottom: none;
        vertical-align: middle;
        text-align: center;
        height: 40px;
    }

    .btn-circle {
        border-radius: 100%;
        width: 25px;
        height: 25px;
        padding: 2px;
    }


    .float-left {
        float: left;
    }

    body {
        font-family: 'Koh-Santepheap-Body', 'Open Sans','Battambang', sans-serif, cursive;
    }

    .control-label {
        top: 10px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .pdate {
        position: relative;
    }

    .target {
        width: 2em;
        height: 2em;
        box-sizing: initial;
        background: #fff;
        border: 0.1em solid red;
        text-align: center;
        border-radius: 50%;
        line-height: 2em;
        box-sizing: content-box;
        font-size: 13px;
        padding: 0 8px;
    }

    .message-error {
        color: tomato;
        padding: 5px 0;
        font-size: 14px;
        display: block;
    }

</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Blog</h4>
                <form>
                    <div class="container9">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <a href="/Home" class="btn btn-dark pull-right">
                                        <i class="fa fa-home"></i> Home
                                    </a>
                                    <div data-bind="visible: $root.view()== 'list';">
                                        <button data-bind="click: $root.add" style="margin-right:5px;" class="btn btn-success pull-right">
                                            <i class="fa fa-save"></i> New
                                        </button>
                                    </div>
                                    
                                    <div data-bind="visible: $root.view() == 'addEdit';">
                                        <button data-bind="click: () => {$root.view('list')};" style="margin-right:5px;" class="btn btn-info pull-right">
                                            <i class="fa fa-back"></i> Back
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end header -->

<!--List-->
<div class="row">
    <div class="col-lg-12">
        <div class="card" margin: 0 auto">
            <div class="card-body">
                <div data-bind="visible: view() == 'list'" class="inbox-center table-responsive">
                    <table class="table table-hover no-wrap">
                        <thead class="bg-info">
                            <tr>
                                <th width="40" align="center">#</th>
                                <th align="center">Title</th>
                                <th align="center">Action</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach: listModel">
                            <tr>
                                <td style="text-align:center" data-bind="text: $index() + 1"></td>
                                <td style="text-align:center" data-bind="text: Title"></td>
                                <td>
                                    <a class="btn btn-secondary btn-circle" data-bind="click: $root.edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger btn-circle" data-bind="click: $root.delete">
										<i class="fa fa-trash"></i>
									</a>
                                </td>
                                
                            </tr>
                        </tbody>
                        <tfoot data-bind="visible: app.tableFooter($element)">
                            <tr>
                                <td class="text-center text-warning h4" style="padding:10px">No Data</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div data-bind="visible: view() == 'addEdit'">
                    <form id="quiz" data-bind="with: model">
                        <div class="form-group">
                            <label class="control-label" style="font-size:17px">
                                Title
                            </label>
                            <input type="text" class="form-control" placeholder="Title" data-bind="value: Title" />
                            <span data-bind="validationMessage: Title" class="message-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" style="font-size:17px">
                                Description
                            </label>
                            <textarea rows="4" type="text" class="form-control" placeholder="Description" data-bind="value: Description"></textarea>
                            <span data-bind="validationMessage: Description" class="message-error"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                Thumbnail
                            </label>
                            <br />
                            <button class="btn btn-outline-dark" data-bind="click: $root.selectThumbnail">Select Thumbnail</button>

                            <span data-bind="validationMessage: Thumbnail" class="message-error"></span>
                        </div>
                    </form>
                    <br />
                    <button type="button" class="btn btn-primary" data-bind="click: $root.save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="file" id="thumbnail" class="hide" data-bind="change: () => thumbnailChanged($element.files)" accept="image/jpeg" />

<?=latestJs('/media/ViewModel/Blog.js')?>