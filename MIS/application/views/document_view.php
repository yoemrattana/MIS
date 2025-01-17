<style>
    body {
        background-color: #f3f1f196;
		font-family: Content;
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

    .input-error {
        border-color: tomato;
    }

	.radius-right {
        border-radius: unset;
        border-top-right-radius: 20px;
    }

    .btn-tab {
        font-weight: 800 !important;
        font-size: 16px !important;
    }

</style>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Documents</h4>
				<form>
					<div class="container9">
						<div class="row">
							<div class="col-sm-8">

							</div>
							<div class="col-sm-4">
								<a href="/Home" class="btn btn-dark pull-right" data-bind="visible: view() == 'list'">
									<i class="fa fa-home"></i> Home
								</a>
								<a  href="#" class="btn btn-success pull-right" style="margin-right:5px" data-bind="click: $root.add, visible: view() == 'list'">
									<i class="fa fa-upload"></i> New
								</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!--List-->
<div class="row" style="display: none" data-bind="visible: view() == 'list'">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			
			<div class="card-body">
				<table class="table table-bordered table-striped table-hover">
					<thead class="bg-info">
						<tr>
							<th width="40" align="center">#</th>
							<th align="center">Thumbnail</th>
							<th align="center">Title</th>
                            <th align="center">Publish Year</th>
                            <th align="center">Language</th>
							<th align="center">Init Date</th>
							<th align="center">Action</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: listModel, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1" class="text-center"></td>
							<td> <img data-bind="attr: { src: '/media/Documents/Thumbnail/' + Thumbnail}" width="39" /></td>
							<td data-bind="text: Title" class="text-left"></td>
							<td data-bind="text: PublishYear"></td>
							<td data-bind="text: Language"></td>
							<td data-bind="text: $root.dateFormat(InitTime)"></td>
							<td align="center">
								<a class="btn btn-success btn-circle" data-bind="attr: {href: Link, target: '_blank'}">
									<i class="fa fa-eye"></i>
								</a>
								<a class="btn btn-primary btn-circle" data-bind="click: $root.edit">
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
		</div>
	</div>
</div>

<!--Modal Form-->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Insert/Edit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" data-bind="with: item">
                    <div class="form-group">
                        <label class="control-label">
                            Title
                        </label>
                        <input type="text" name="Title" class="form-control" data-bind="value: Title" />
                        <span data-bind="validationMessage: Title" class="message-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Published Year
                        </label>
                        <input type="text" class="form-control" data-bind="value: PublishYear" />
                        <span data-bind="validationMessage: PublishYear" class="message-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Language
                        </label>

                        <select class="form-control" data-bind="value: Language">
                            <option></option>
                            <option>Khmer</option>
                            <option>English</option>
                        </select>

                        <span data-bind="validationMessage: Language" class="message-error"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Thumbnail
                        </label>
                        <br />
                        <button class="btn btn-outline-dark" data-bind="click: $root.selectThumbnail">
                            Select Thumbnail 
                            <span data-bind="visible: Thumbnail() != ''" class="fa fa-check" style="color:#fec107; font-size:20px"></span>
                        </button>

                        <span data-bind="validationMessage: Thumbnail" class="message-error"></span>
                    </div>
                    <br />
                    <div class="form-group">
                        <button class="btn btn-dark" data-bind="click: $root.selectFile">
                            Select File
                            <span data-bind="visible: File() != ''" class="fa fa-check" style="color:#fec107; font-size:20px"></span>
                        </button>
                        <span data-bind="validationMessage: File" class="message-error"></span>
                    </div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-bind="click: $root.save">Save changes</button>
			</div>
		</div>
	</div>
</div>

<input type="file" id="file" class="hide" data-bind="change: () => fileChanged($element.files)" accept="application/pdf" />
<input type="file" id="thumbnail" class="hide" data-bind="change: () => thumbnailChanged($element.files)" accept="image/jpeg"/>

<?=latestJs('/media/ViewModel/Document.js')?>