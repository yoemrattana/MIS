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
    .double {
        transform: scale(2);
        -ms-transform: scale(1.5);
        -webkit-transform: scale(1.5);
        -o-transform: scale(1.5);
        -moz-transform: scale(1.5);
        transform-origin: 0 0;
        -ms-transform-origin: 0 0;
        -webkit-transform-origin: 0 0;
        -o-transform-origin: 0 0;
        -moz-transform-origin: 0 0;
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
				<h4 class="card-title">Quiz Questionaire</h4>
				<form>
					<div class="container9">
						<div class="row">
							<div class="col-sm-6">
								<div class="button-group">
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('MIS')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">MIS</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('M&E')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">M&E</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('EPI')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">EPI</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('Finance')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Finance</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('VMW')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">VMW</button>
									<button type="button" data-bind="click: $root.menuClick, visible: (app.user.permiss['Quiz']).contain('Education')" class="btn btn-tab waves-effect waves-light btn-outline-dark radius-right btn-menu box-shadow">Education</button>
								</div>
							</div>
							<div class="col-sm-6">
								<a href="/Home" class="btn btn-dark pull-right">
									<i class="fa fa-home"></i> Home
								</a>
								<a style="margin-right:5px;" href="/Quiz/result" class="btn btn-outline-success pull-right">
									<i class="fa fa-graduation-cap"></i> Result
								</a>
								<a style="margin-right:5px;" href="/Quiz/Dashboard" class="btn btn-outline-success pull-right">
									<i class="fa fa-graduation-cap"></i> Dashboard
								</a>
								<a style="margin-right:5px; display: none" href="#" class="btn btn-success pull-right" data-bind="click: $root.addQuiz, visible: view() == 'quiz'">
									<i class="fa fa-save"></i> New Quiz
								</a>
								<a style="margin-right:5px; display: none" href="#" class="btn btn-success pull-right" data-bind="click: $root.addQuestion, visible: view() == 'question'">
									<i class="fa fa-save"></i> New Question
								</a>
								<a style="margin-right:5px; display: none" href="#" class="btn btn-primary pull-right" data-bind="click: $root.selectFile , visible: view() == 'question'">
									<i class="fa fa-upload"></i> Upload
								</a>
								<a style="margin-right:5px" href="/media/Quiz/Quiz.xlsx" class="btn btn-outline-dark pull-right" data-bind="visible: view() == 'question'"><i class="fa fa-file-excel-o"></i> Template</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!--Quiz List-->
<div class="row" style="display: none" data-bind="visible: tab() != undefined && view() == 'quiz'">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			<!--<div class="card-header bg-info">
				<h4 class="m-b-0 text-white float-left">Questionaire</h4>
			</div>-->
			<div class="card-body">
				<table class="table table-bordered table-striped table-hover">
					<thead class="bg-info">
						<tr>
							<th width="40" align="center">#</th>
							<th align="center">Title</th>
							<th align="center">Description</th>
							<th align="center">Category</th>
							<th align="center">Candidate</th>
							<th align="center">Init Date</th>
							<th align="center">Action</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: quizList, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1" class="text-center"></td>
							<td data-bind="text: Title" class="kh"></td>
							<td data-bind="text: Description" class="kh"></td>
							<td data-bind="text: Category" class="kh"></td>
							<td data-bind="text: Candidate"></td>
							<td data-bind="text: $root.dateFormat(InitTime)"></td>
							<td align="center">
								<a class="btn btn-secondary btn-circle" data-bind="click: $root.editQuiz">
									<i class="fa fa-pencil"></i>
								</a>
								<a class="btn btn-success btn-circle" data-bind="click: $root.viewQuestions">
									<i class="fa fa-eye"></i>
								</a>
								<a class="btn btn-danger btn-circle" data-bind="click: $root.deleteQuiz">
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

<!--Question List-->
<div class="row" style="display: none" data-bind="visible: tab() != undefined && view() == 'question'">
	<div class="col-lg-12">
		<div class="card" margin: 0 auto">
			<div class="card-header bg-info" data-bind="with: selectedQuiz">
				<h4 class="m-b-0 text-white float-left">Questionaire: <span class="kh" data-bind="text: Title"></span></h4>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped table-hover">
					<thead class="bg-info">
						<tr>
							<th width="40" align="center">#</th>
							<th align="center">Question</th>
							<th align="center">Module</th>
							<th align="center">Init Date</th>
							<th align="center">Action</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: questionList, fixedHeader: true">
						<tr>
							<td data-bind="text: $index() + 1" class="text-center"></td>
							<td data-bind="text: Question" class="kh"></td>
							<td data-bind="text: Module" class="kh"></td>
							<td data-bind="text: $root.dateFormat(InitTime)"></td>
							<td align="center">
								<a class="btn btn-secondary btn-circle" data-bind="click: $root.editQuestion">
									<i class="fa fa-pencil"></i>
								</a>
								
								<a class="btn btn-danger btn-circle" data-bind="click: $root.deleteQuestion">
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

<div>
	<input type="file" class="hide" id="file" data-bind="event: { change: () => fileChanged($element.files, true) }" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
</div>

<!-- Modal Add Quiz-->
<div class="modal fade" id="modalQuiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Insert/Edit Quiz</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" data-bind="with: quiz">
				<form id="quiz">
					<div class="form-group">
					<label class="control-label" style="font-size:17px">
						Title
					</label>
					<input type="text" class="form-control" placeholder="Title" data-bind="value: Title"/>
					<span data-bind="validationMessage: Title" class="message-error"></span>
				</div>

				<div class="form-group">
					<label class="control-label" style="font-size:17px">
						Description
					</label>
					<input type="text" class="form-control" placeholder="Description" data-bind="value: Description"/>
					<span data-bind="validationMessage: Description" class="message-error"></span>
				</div>

				<div class="form-group">
					<label class="control-label">
						Category
					</label>
					<select class="form-control" data-bind="value: Category">
						<option value="">Select category</option>
						<option value="MIS">MIS</option>
						<option value="M&E">M&E</option>
						<option value="Finance">Finance</option>
						<option value="EPI">EPI</option>
						<option value="VMW">VMW</option>
						<option value="Education">Education</option>
					</select>
					<span data-bind="validationMessage: Category" class="message-error"></span>
				</div>

				<div class="form-group">
					<label class="control-label">
						Candidate
					</label>
					<select class="form-control" data-bind="value: Candidate">
						<option value="">Select Candidate</option>
						<option value="OD">OD</option>
						<option value="HC">HC</option>
						<option value="VMW">VMW</option>
					</select>
					<span data-bind="validationMessage: Candidate" class="message-error"></span>
				</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-bind="click: $root.saveQuiz">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!--Modal Add Quiz Question-->
<div class="modal fade" id="modalQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Insert/Edit Question</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" data-bind="with: question">
                <form id="question">
					<div class="form-group">
						<label class="control-label" style="font-size:17px">
							Question
						</label>
						<input type="text" class="form-control" placeholder="Question" data-bind="value: Question"/>
						<span data-bind="validationMessage: Question" class="message-error"></span>
					</div>

					<div class="form-group">
						<label class="control-label" style="font-size:17px">
							Module
						</label>
						<input type="text" class="form-control" placeholder="Module" data-bind="value: Module"/>
						<span data-bind="validationMessage: Module" class="message-error"></span>
					</div>
				
				<hr />

				<h4>Answer</h4>
				<br />
				<!-- ko foreach: Answers -->
				<div class="row">
					<div class="col-sm-10">
						<input type="text" class="form-control" aria-label="Answer" data-bind="value: Answer, attr: {placeholder: 'Answer ' + parseInt($index() + 1 ) }" />
						<span data-bind="validationMessage: Answer" class="message-error"></span>
					</div>
					<div class="col-sm-2">
						<div class="form-check double">
							<input class="form-check-input" type="checkbox" data-bind="checked: IsCorrect, attr: {id: 'answer' + $index()}"/>
							<!--<span data-bind="validationMessage: IsCorrect" class="message-error"></span>-->
							<label class="form-check-label" for="gridCheck" data-bind="attr: {for: 'answer' + $index()}">
								Correct
							</label>
						</div>
					</div>
				</div>
				<br />
				
				<!-- /ko -->
				</form>

				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-bind="click: $root.saveQuestion">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Upload-->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Upload</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>File Name</th>
							<th width="150" align="center">Status</th>
						</tr>
					</thead>
					<tbody data-bind="with: importModel">
						<tr>
							<td data-bind="text: name"></td>
							<td align="center">
								<span data-bind="text: status"></span>
								<img data-bind="visible: status() == 'Importing'" src="/media/images/ajax-loader.gif" height="18" style="margin-left:5px" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?=latestJs('/media/ViewModel/Quiz.js')?>