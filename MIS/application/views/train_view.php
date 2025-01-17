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

	.radius-right {
        border-radius: unset;
        border-top-right-radius: 20px;
    }

    .btn-tab {
        font-weight: 800 !important;
        font-size: 16px !important;
    }

	/*comment style*/
	/**
 * Oscuro: #283035
 * Azul: #03658c
 * Detalle: #c7cacb
 * Fondo: #dee1e3
 ----------------------------------*/
 * {
 	margin: 0;
 	padding: 0;
 	-webkit-box-sizing: border-box;
 	-moz-box-sizing: border-box;
 	box-sizing: border-box;
 }

 a {
 	color: #03658c;
 	text-decoration: none;
 }

ul {
	list-style-type: none;
}

body {
	font-family: 'Roboto', Arial, Helvetica, Sans-serif, Verdana;
	background: #dee1e3;
}

/** ====================
 * Lista de Comentarios
 =======================*/
.comments-container {
	margin: 60px auto 15px;
	width: 768px;
}

.comments-container h1 {
	font-size: 36px;
	color: #283035;
	font-weight: 400;
}

.comments-container h1 a {
	font-size: 18px;
	font-weight: 700;
}

.comments-list {
	margin-top: 30px;
	position: relative;
}

/**
 * Lineas / Detalles
 -----------------------*/
.comments-list:before {
	content: '';
	width: 2px;
	height: 100%;
	background: #c7cacb;
	position: absolute;
	left: 32px;
	top: 0;
}

.comments-list:after {
	content: '';
	position: absolute;
	background: #c7cacb;
	bottom: 0;
	left: 27px;
	width: 7px;
	height: 7px;
	border: 3px solid #dee1e3;
	-webkit-border-radius: 50%;
	-moz-border-radius: 50%;
	border-radius: 50%;
}

.reply-list:before, .reply-list:after {display: none;}
.reply-list li:before {
	content: '';
	width: 60px;
	height: 2px;
	background: #c7cacb;
	position: absolute;
	top: 25px;
	left: -55px;
}


.comments-list li {
	margin-bottom: 15px;
	display: block;
	position: relative;
}

.comments-list li:after {
	content: '';
	display: block;
	clear: both;
	height: 0;
	width: 0;
}

.reply-list {
	padding-left: 88px;
	clear: both;
	margin-top: 15px;
}
/**
 * Avatar
 ---------------------------*/
.comments-list .comment-avatar {
	width: 65px;
	height: 65px;
	position: relative;
	z-index: 99;
	float: left;
	border: 3px solid #FFF;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	-moz-box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	overflow: hidden;
}

.comments-list .comment-avatar img {
	width: 100%;
	height: 100%;
}

.reply-list .comment-avatar {
	width: 50px;
	height: 50px;
}

.comment-main-level:after {
	content: '';
	width: 0;
	height: 0;
	display: block;
	clear: both;
}
/**
 * Caja del Comentario
 ---------------------------*/
.comments-list .comment-box {
	width: 680px;
	float: right;
	position: relative;
	-webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.15);
	-moz-box-shadow: 0 1px 1px rgba(0,0,0,0.15);
	box-shadow: 0 1px 1px rgba(0,0,0,0.15);
}

.comments-list .comment-box:before, .comments-list .comment-box:after {
	content: '';
	height: 0;
	width: 0;
	position: absolute;
	display: block;
	border-width: 10px 12px 10px 0;
	border-style: solid;
	border-color: transparent #FCFCFC;
	top: 8px;
	left: -11px;
}

.comments-list .comment-box:before {
	border-width: 11px 13px 11px 0;
	border-color: transparent rgba(0,0,0,0.05);
	left: -12px;
}

.reply-list .comment-box {
	width: 610px;
}
.comment-box .comment-head {
	background: #FCFCFC;
	padding: 10px 12px;
	border-bottom: 1px solid #E5E5E5;
	overflow: hidden;
	-webkit-border-radius: 4px 4px 0 0;
	-moz-border-radius: 4px 4px 0 0;
	border-radius: 4px 4px 0 0;
}

.comment-box .comment-head i {
	float: right;
	margin-left: 14px;
	position: relative;
	top: 2px;
	color: #A6A6A6;
	cursor: pointer;
	-webkit-transition: color 0.3s ease;
	-o-transition: color 0.3s ease;
	transition: color 0.3s ease;
}

.comment-box .comment-head i:hover {
	color: #03658c;
}

.comment-box .comment-name {
	color: #283035;
	font-size: 14px;
	font-weight: 700;
	float: left;
	margin-right: 10px;
}

.comment-box .comment-name a {
	color: #283035;
}

.comment-box .comment-head span {
	float: left;
	color: #999;
	font-size: 13px;
	position: relative;
	top: 1px;
}

.comment-box .comment-content {
	background: #FFF;
	padding: 12px;
	font-size: 15px;
	color: #595959;
	-webkit-border-radius: 0 0 4px 4px;
	-moz-border-radius: 0 0 4px 4px;
	border-radius: 0 0 4px 4px;
}

.comment-box .comment-name.by-author, .comment-box .comment-name.by-author a {color: #03658c;}
.comment-box .comment-name.by-author:after {
	content: 'autor';
	background: #03658c;
	color: #FFF;
	font-size: 12px;
	padding: 3px 5px;
	font-weight: 700;
	margin-left: 10px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}

/** =====================
 * Responsive
 ========================*/
@media only screen and (max-width: 766px) {
	.comments-container {
		width: 480px;
	}

	.comments-list .comment-box {
		width: 390px;
	}

	.reply-list .comment-box {
		width: 320px;
	}
}

.highligh {
	border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0 0 8px rgb(102 175 233 / 60%);
    /*box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0px 0px 20px rgb(102 175 233 / 60%) !important;*/
	box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0px 0px 20px #6f42c1 !important;
}
</style>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Training Material</h4>
				<form>
					<div class="container9">
						<div class="row">
							<div class="col-sm-8">
								<div class="button-group" data-bind="visible: view() == 'list'">
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Train Material']).contain('MIS')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">MIS</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Train Material']).contain('M&E')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">M&E</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Train Material']).contain('EPI')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">EPI</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Train Material']).contain('Finance')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Finance</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Train Material']).contain('VMW')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">VMW</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Train Material']).contain('Education')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Education</button>
                                    <button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Train Material']).contain('Laboratory')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Laboratory</button>
								</div>
							</div>
							<div class="col-sm-4">
								<a href="/Home" class="btn btn-dark pull-right" data-bind="visible: view() == 'list'">
									<i class="fa fa-home"></i> Home
								</a>
								<a  href="#" class="btn btn-success pull-right" style="margin-right:5px" data-bind="click: $root.add, visible: tab() != undefined && view() == 'list'">
									<i class="fa fa-upload"></i> New
								</a>
                                <a  href="#" class="btn btn-outline-dark pull-right" style="margin-right:5px" data-bind="click: $root.addSubCat, visible: tab() != undefined && view() == 'list'">
									<i class="fa fa-upload"></i> Sub Category
								</a>
								<a  href="#" class="btn btn-dark pull-right" style="margin-right:5px" data-bind="click: () => $root.view('list'), visible: view().in('comment', 'unread')">
									<i class="fa fa-caret-square-o-left"></i> Back
								</a>
								<a style="margin-right:5px;" href="#" class="btn btn-secondary pull-right" data-bind="click: $root.readMe">
									<i class="fa fa-book"></i> Read Me
								</a>
								<a style="margin-right:5px;" href="#" class="btn btn-primary pull-right" data-bind="click: () => $root.view('unread')">
									<i class="fa fa-comments-o"></i> <span class="badge badge-light" data-bind="text: unreadCmtCount"></span>
								</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Place filter -->
<form style="display: none" data-bind="visible: view().in('comment', 'unread')">
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
				</div>
			</div>
		</div>
	</div>
</form>
<br />

<!--List-->
<div class="row" style="display: none" data-bind="visible: tab() != undefined && view() == 'list'">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			
			<div class="card-body">
				<table class="table table-bordered table-striped table-hover">
					<thead class="bg-info">
						<tr>
							<th width="40" align="center">#</th>
							<th align="center">Thumbnail</th>
							<th align="center">Title</th>
							<th align="center">Type</th>
							<th align="center">Category</th>
                            <th align="center">Sub Category</th>
							<th align="center">Audience</th>
							<th align="center">Init Date</th>
							<th align="center">Action</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: listModel, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1" class="text-center"></td>
							<td> <img data-bind="attr: { src: '/media/Training/Thumbnail/' + Thumbnail}" width="39" /></td>
							<td data-bind="text: Title" class="kh"></td>
							<td data-bind="text: Type" class="kh"></td>
							<td data-bind="text: Category"></td>
                            <td data-bind="text: $root.getSubCat(SubCategory)"></td>
							<td data-bind="text: Audience"></td>
							<td data-bind="text: $root.dateFormat(InitTime)"></td>
							<td align="center">
								<a class="btn btn-success btn-circle" data-bind="attr: {href: Type == 'Video' ? YouTube : Link, target: '_blank'}">
									<i class="fa fa-eye"></i>
								</a>
								<a class="btn btn-primary btn-circle" data-bind="click: $root.edit">
									<i class="fa fa-pencil"></i>
								</a>
								<a class="btn btn-secondary btn-circle" data-bind="click: $root.viewComment">
									<i class="fa fa-comments-o"></i>
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

<!-- comment -->
<div class="comments-container" style="display:none" data-bind="visible: view() == 'comment'">
	<h1><span style="font-family: 'Khmer OS Battambang'; font-size: 27px;" data-bind="text: titleComment"></span></h1> 
	<ul id="comments-list" class="comments-list">
		<li data-bind="foreach: listComment">
			<div class="comment-main-level">
				<!-- Avatar -->
				<div class="comment-avatar">
					<svg data-bind="attr:{id: 'i' + Code_Place}" width="100%" height="100%"></svg>
				</div>
				<!-- main comment -->
				<div class="comment-box" data-bind="attr:{id: 'b' + Rec_ID}">
					<div class="comment-head">
						<h6 class="comment-name by-author"><a style="font-family: 'Khmer OS Battambang'" href="#" data-bind="text: Place, attr:{id:'s' + Rec_ID}"></a></h6>
						<span data-bind="text: $root.dateFormat(InitTime)">20 minute ago</span>
						<i class="fa fa-reply" data-bind="click: $root.reply"></i>
						<i class="fa fa-trash" style="color: red"  data-bind="click: $root.deleteComment, visible: app.user.role == 'AU'"></i>
					</div>
					<div class="comment-content" >
						<span data-bind="text: Text"></span>
					</div>
				</div>
			</div>
			<!-- Repy section -->
			<ul class="comments-list reply-list" data-bind="foreach: Reply">
				<li>
					<!-- Avatar -->
					<div class="comment-avatar">
						<svg data-bind="attr:{id: 'i' + Code_Place}" width="100%" height="100%"></svg>
					</div>
					
					<!-- Contenedor del Comentario -->
					<!-- ko if: IsNew() == 0 -->
					<div class="comment-box" data-bind="attr:{id: 'b' + Rec_ID}">
						<div class="comment-head">
							<h6 class="comment-name"><a style="font-family: 'Khmer OS Battambang'" href="#" data-bind="text: Code_Place, attr:{id: 's' + Rec_ID}"></a></h6>
							<span data-bind="text: $root.dateFormat(InitTime)">10 ms ago</span>
							<i class="fa fa-trash" style="color: red"  data-bind="click: $root.deleteComment, visible: app.user.role == 'AU'"></i>
						</div>
						<div class="comment-content" data-bind="text: Text">
							reply text  go here
						</div>
					</div>
					<!-- /ko -->
					<!-- ko if: IsNew() == 1 -->
					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name"><a href="#" data-bind="text: Code_Place"></a></h6>
							<span data-bind="text: $root.dateFormat(InitTime)">10 ms ago</span>
							<i class="fa fa-save" style="color: #3498db" data-bind="click: $root.saveReply"></i>
							<i class="fa fa-trash" style="color: red"  data-bind="click: $root.cancelComment, visible: app.user.role == 'AU'"></i>
						</div>
						<div class="comment-content">
							<textarea style="width:100%" rows="3" data-bind="value: Text"></textarea>
							<span data-bind="validationMessage: Text" class="message-error"></span>
						</div>
					</div>
					<!-- /ko -->
				</li>
			</ul>
		</li>
	</ul>
	
	<div data-bind="visible: listComment().length == 0"><p>No comment</p></div>
</div>

<!-- unread comment -->
<div class="row" style="display: none" data-bind="visible: view() == 'unread'">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			<div class="card-body">
				<table class="table table-bordered table-striped table-hover">
					<thead class="bg-info">
						<tr>
							<th width="40" align="center">#</th>
							<th align="center">Place</th>
							<th align="center">Text</th>
							<th align="center">Init Date</th>
							<th align="center">Action</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: unreadComments, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1" class="text-center"></td>
							<td data-bind="text: Place" class="kh"></td>
							<td data-bind="text: Text" class="kh"></td>
							<td data-bind="text: $root.dateFormat(InitTime)"></td>
							<td align="center">
								<a class="btn btn-success btn-circle" data-bind="click: $root.viewUnreadCmt">
									<i class="fa fa-eye"></i>
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
				<form action="#">
					<div class="container form-body">
                    <div class="form-group">
						<label class="control-label">
							Title
						</label>
						<input type="text" class="form-control" data-bind="value: Title" />
						<span data-bind="validationMessage: Title" class="message-error"></span>
					</div>
					<div class="form-group">
						<label class="control-label">
							Thumbnail
						</label>
						<br/>
						<button class="btn btn-outline-dark" data-bind="click: $root.selectThumbnail">Select Thumbnail</button>
					
						<span data-bind="validationMessage: Thumbnail" class="message-error"></span>
					</div>
					<div class="form-group">
						<label class="control-label">
							Audience
						</label>
                        <br />
                        <div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck10" name="Audience" value="PHD"
								data-bind="checked: Audience " />
							<label class="custom-control-label" for="customCheck10">
								PHD
							</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck11" name="Audience" value="OD"
								data-bind="checked: Audience " />
							<label class="custom-control-label" for="customCheck11">
								OD
							</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck12" name="Audience" value="HC" data-bind="checked: Audience" />
							<label class="custom-control-label" for="customCheck12">
								HC
							</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck13" name="Audience" value="VMW" data-bind="checked: Audience" />
							<label class="custom-control-label" for="customCheck13">
								VMW
							</label>
						</div>
						<span data-bind="validationMessage: Audience" class="message-error"></span>
					</div>
					<div class="form-group">
						<label class="control-label">
							Type
						</label>
						<select class="form-control" data-bind="value: Type">
							<option value="">Select type</option>
							<option value="Video">Video</option>
							<option value="PDF">PDF</option>
							<option value="Slide">Slide</option>
						</select>
						<span data-bind="validationMessage: Type" class="message-error"></span>
					</div>
					<div class="form-group">
						<label class="control-label">
							Unit
						</label>
						<select class="form-control" data-bind="value: Unit">
							<option value="">Select Unit</option>
							<option value="MIS">MIS</option>
							<option value="M&E">M&E</option>
							<option value="Finance">Finance</option>
							<option value="EPI">EPI</option>
							<option value="VMW">VMW</option>
							<option value="Education">Education</option>
                            <option value="Laboratory">Laboratory</option>
						</select>
						<span data-bind="validationMessage: Category" class="message-error"></span>
					</div>
                    <div class="form-group">
						<label class="control-label">
							Category
						</label>
						<select class="form-control" data-bind="value: Category">
							<option value="">Select category</option>
							<option value="Guideline">Guideline</option>
							<option value="SOP">SOP</option>
							<option value="Lesson">Lesson</option>
						</select>
						<span data-bind="validationMessage: Category" class="message-error"></span>
					</div>
                    <div class="form-group">
						<label class="control-label">
							Sub Category
						</label>
                        <select data-bind="value: SubCategory, options: $root.subCatList, optionsValue: 'Rec_ID', optionsText: 'Title', optionsCaption: 'Select Sub Category'" class="form-control"></select>
						
						<span data-bind="validationMessage: Category" class="message-error"></span>
					</div>
					<!--<div class="form-group">
						<label class="control-label">
							Source
						</label>
						<input type="text" class="form-control" data-bind="value: Source, visible: Type() == 'Video'" />
					
						<span data-bind="validationMessage: Source" class="message-error"></span>
					</div>-->
					<br />
					<div class="form-group">
						<button class="btn btn-dark" data-bind="click: $root.selectFile">Select File</button>
						<span data-bind="validationMessage: File" class="message-error"></span>
					</div>

					<div class="form-group">
						<label class="control-label">
							YouTube
						</label>
						<input type="text" class="form-control" data-bind="value: YouTube" />
						<span data-bind="validationMessage: YouTube" class="message-error"></span>
					</div>
                    </div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-bind="click: $root.save">Save changes</button>
			</div>
		</div>
	</div>
</div>
<input type="file" id="file" class="hide" data-bind="change: () => fileChanged($element.files)" accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, video/mp4"/>
<input type="file" id="thumbnail" class="hide" data-bind="change: () => thumbnailChanged($element.files)" accept="image/jpeg"/>
<!--<input type="file" id="video" class="hide" data-bind="change: () => videoChanged($element.files)" accept="video/mp4"/>-->
<!-- Modal show -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">View</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" data-bind="with: itemPreview">
				<div data-bind="if: Category == 'PDF'">
					<iframe  width="100%" height="500px" allow="autoplay" data-bind="attr: {src: Source}"></iframe>
				</div>
				<div data-bind="if: Category == 'Video'">
					<iframe  width="100%" height="500px" allow="autoplay" data-bind="attr: {src: 'https://www.youtube.com/embed/'+ Source}"></iframe>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Read Me-->
<div class="modal fade" id="modalReadMe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Read Me</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul>
					<li>- Video/PDF/Slide cannot exceed 150MB.</li>
					<li>- Please go to <a href="https://www.adobe.com/acrobat/online/compress-pdf.html" target="_blank">PDF Compress tool</a> to compress PDF file to small size.</li>
					<li>- Please use any video converter to copresss video size with good quality for mobile phone display.</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Sub-->
<div class="modal fade" id="modalSubCat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sub Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" data-bind="with: subCat">
                <table class="table-bordered table">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Title</th>
                            <th width="20">Action</th>
                        </tr>
                    </thead>
                    <tbody data-bind="foreach: $root.subCatList">
                        <tr>
                            <td data-bind="text: $index() + 1"></td>
                            <td data-bind="text: Title"></td>
                            <td > 
                                <a class="btn btn-primary btn-circle" data-bind="click: $root.editSubCat">
									<i class="fa fa-pencil"></i>
								</a>
								<a class="btn btn-danger btn-circle" data-bind="click: $root.deleteSubCat">
									<i class="fa fa-trash"></i>
								</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
				
					<div class="container form-body" style="border: 1px solid #cccc; padding: 10px">
                        <div class="form-group">
						    <label class="control-label">
							    Title
						    </label>
						    <input type="text" class="form-control" data-bind="value: Title" required/>						    
					    </div>
                    </div>
                
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bind="click: $root.saveSubCat">Save changes</button>
			</div>
		</div>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jdenticon@3.1.1/dist/jdenticon.min.js"
    integrity="sha384-l0/0sn63N3mskDgRYJZA6Mogihu0VY3CusdLMiwpJ9LFPklOARUcOiWEIGGmFELx"
    crossorigin="anonymous">
</script>

<?=latestJs('/media/ViewModel/Train.js')?>