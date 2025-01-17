<style>
	.modal-bgheader {
		background:url(/media/assetsV2/images/bg-modal.jpg);
		color:#ffffff;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
</style>

<!-- Waiting Loader -->
<div class="modal" id="modalLoader" tabindex="-1" role="dialog">
	<!--<div class='loader' style="display:block">
		<div class='circle'></div>
		<div class='circle'></div>
		<div class='circle'></div>
		<div class='circle'></div>
		<div class='circle'></div>
	</div>-->
	<div style="height:100%; display:flex; justify-content:center; align-items:center">
		<l-hourglass size="200" bg-opacity="0.2" speed="2" color="white"></l-hourglass>
	</div>
</div>

<!-- Modal Wait -->
<div class="modal" id="modalWait" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="min-width:600px; max-width:600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">Downloading</h3>
			</div>
			<div class="modal-body no-padding-horizontal">
				<img src="/media/images/waiting.gif" />
			</div>
			<div class="modal-footer" style="display:block">
				<div class="pull-left">Speed: 9.9 MB/s</div>
				<div class="pull-right">Downloaded: 9.9 MB / 9.9 MB (100.00%)</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Permission -->
<div class="modal" id="modalPermission" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary">គ្មានសិទ្ធិ - No Permission</h3>
			</div>
			<div class="modal-body">
				<p style="font-size:18px">អ្នកពុំមានសិទ្ធិកែប្រែទិន្នន័យទេ</p>
				<div style="font-size:18px">You are not allowed to edit data</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default width100" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Delete -->
<div class="modal" id="modalDelete" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-danger">Delete</h3>
			</div>
			<div class="modal-body">
				<h4>Do you want to delete?</h4>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger width100" data-dismiss="modal">Delete</button>
				<button class="btn btn-default width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Restore -->
<div class="modal" id="modalRestore" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-danger">Restore</h3>
			</div>
			<div class="modal-body">
				<h4>Do you want to restore?</h4>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger width100" data-dismiss="modal">Restore</button>
				<button class="btn btn-default width100" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Confirm -->
<div class="modal" id="modalConfirm" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-danger">Confirmation</h3>
			</div>
			<div class="modal-body">
				<h4>Are you sure?</h4>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger width100" data-dismiss="modal">Yes</button>
				<button class="btn btn-default width100" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Message -->
<div class="modal" id="modalMessage" tabindex="-1" role="dialog" style="z-index:999999">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-primary"></h3>
			</div>
			<div class="modal-body" style="font-size:18px"></div>
			<div class="modal-footer">
				<button class="btn btn-default width100" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Contact Us -->
<div class="modal fade" id="modalContactUs" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header modal-bgheader">
                <h1>Contact Us</h1>
			</div>
			<div class="modal-body">
				<ul class="text-primary">
					<li style="font-size:17px">
						Dr. <span style="font-weight: bold">Siv Sovannaroth</span>
						<br />
						<span style="font-size:12px">Email: sivsovannaroths@gmail.com</span>
					</li>
				</ul>
				<ul class="text-primary">
					<li style="font-size:17px">
						Mr. <span style="font-weight: bold">Ngor Pengby</span>
                        <br />
                        <span style="font-size:12px">Tel: 010 88 33 88</span>
                        <br />
                        <span style="font-size:12px">Email: pengby82@yahoo.com</span>
					</li>
				</ul>
                <button class="btn btn-default width100" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="modalPHPError" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl" role="document" style="height:calc(100% - 60px)">
		<div class="modal-content" style="height:100%; display:flex; flex-direction:column">
			<div class="modal-header">
				<div style="display:flex; align-items:center; justify-content:space-between">
					<h4 class="modal-title text-primary">Server Side Error</h4>
					<span role="button" class="material-icons" data-dismiss="modal">close</span>
				</div>
			</div>
			<div class="modal-body" style="flex-grow:1">
				<iframe style="width:100%; height:100%; border:none"></iframe>
			</div>
		</div>
	</div>
</div>

<!-- Modal Download -->
<div class="modal fade" id="modalDownload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog" style="max-width:600px">
		<div class="modal-content">
			<div class="modal-header justify-content-between">
				<span class="modal-title fs-4 text-primary">Downloading</span>
				<span class="spinner-border text-success"></span>
			</div>
			<div class="modal-body hstack justify-content-between">
				<div>Speed: 0.0 MB/s</div>
				<div>Downloaded: 0.0 MB / 0.0 MB (0.0%)</div>
			</div>
		</div>
	</div>
</div>