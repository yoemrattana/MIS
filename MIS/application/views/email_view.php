<style>
    body {
        background-color: #f3f1f196;
        font-family: 'Koh-Santepheap-Body', 'Open Sans','Battambang', sans-serif, cursive;
    }

    .card {
        box-shadow: 0 0 10px rgb(0 0 0 / 15%), 0 3px 3px rgb(0 0 0 / 15%);
        border: 2px solid #01c0c8;
        background: #fff;
    }

    .card-title {
        font-family: 'Khmer OS Bokor';
        color: dodgerblue;
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
				<h4 class="card-title">Email Configuration</h4>
				<form>
					<div class="container9">
						<div class="row">
							<div class="col-sm-12">
								<a href="/Home" class="btn btn-dark pull-right">
									<i class="fa fa-home"></i> Home
								</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!--Form-->
<div class="row">
	<div class="col-lg-12">
		<div class="card"  margin: 0 auto">
			<div class="card-header bg-info">
				<h4 class="m-b-0 text-white float-left">Email Configuration</h4>
			</div>
			<div class="card-body">
				<form action="#">
					<div style="width: 606px" class="container form-body">
						<div class="row p-t-20">
							<div class="col-md-12" data-bind="with: config">
								<div class="form-group">
									<label class="control-label">
										SMTP User <span style="color:tomato">*(this information get from gmail configuration, becareful when to change it)</span>
									</label>
									<input type="text" class="form-control" data-bind="value: smtp_user"/>
									<span data-bind="validationMessage: smtp_user" class="message-error"></span>
								</div>

								<div class="form-group">
									<label class="control-label">
										SMTP Password 
										<span style="color:tomato">*(this information get from gmail configuration, becareful when to change it)</span>
									</label>
									<input type="text" class="form-control" data-bind="value: smtp_pass" />
									<span data-bind="validationMessage: smtp_pass" class="message-error"></span>
								</div>

								<div class="form-group">
									<label class="control-label">
										To
									</label>
									<input type="text" class="form-control" data-bind="value: to" />
									<span data-bind="validationMessage: to" class="message-error"></span>
								</div>

								<div class="form-group">
									<label class="control-label">
										CC
									</label>
									<input type="text" class="form-control" data-bind="value: cc" />
									<span data-bind="validationMessage: cc" class="message-error"></span>
								</div>

							</div>	
						</div>

					</div><!--/form-body end-->
					<div class="form-actions">
						<button type="submit" class="btn btn-success" data-bind="click: $root.save">
							<i class="fa fa-check"></i> Save
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- Modal Save Change -->
<div class="modal" id="modalSave" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">
					<kh>មានការកែទិន្នន័យ</kh> - Data Changing
				</h3>
			</div>
			<div class="modal-body" style="font-size:18px">
				<kh>តើអ្នកចង់រក្សាទុកការកែទិន្នន័យនេះទេ?</kh>
				<br />
				<br />
				Do you want to save changes?
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary btn-sm" data-dismiss="modal" style="width:100px">Save</button>
				<button class="btn btn-danger btn-sm" data-dismiss="modal" style="width:100px">Don't Save</button>
				<button class="btn btn-default btn-sm" data-dismiss="modal" style="width:100px">Cancel</button>
			</div>
		</div>
	</div>
</div>


<?=latestJs('/media/ViewModel/Email.js')?>
<?=latestJs('/media/JavaScript/loadash.js')?>