<style type="text/css" media="all">
    * {
        margin: 0;
        padding: 0;
        font-size: 9pt;
    }

    body {
        color: #000;
    }

    h1 {
        font-family: 'Khmer OS Muol Light';
        font-size: 12pt;
        line-height: 5px;
    }

    h2 {
        font-family: 'Khmer OS Battambang';
        font-size: 11pt;
        line-height: 5px;
    }

    h3 {
        font-family: 'Khmer OS Battambang';
        font-size: 12pt;
        font-weight: bold;
    }

    p {
        font-family: 'Khmer OS Battambang';
        font-size: 12pt;
        margin-left: 33px;
    }

    li {
        font-family: 'Khmer OS Battambang';
        font-size: 12pt;
        margin-left: 53px;
    }

    span {
        font-family: 'Khmer OS Battambang';
        font-size: 12pt;
    }

    #content {
        height: auto;
        margin: 0 auto;
        padding: 0.2in;
        width: 8.3in;
        margin: 0 auto;
        background: #FFF;
        border-radius: 1px;
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    }

    .logo {
        width: 33%;
        /*float: left*/
        text-align: center;
    }

    .text-header-moul {
        font-family: 'Khmer OS Muol';
        text-align: center !important;
        padding-bottom: 10px;
    }

        .text-header-moul p {
            font-size: 19px;
        }

    .btn {
        border-radius: 0;
        margin-bottom: 5px;
    }

    h3 {
        margin: 5px 0;
    }

    @page {
        size: A4;
        margin: 0;
    }

    .content-footer {
        height: 47px;
        margin-top: 43px;
    }

    .left {
        float: left;
        text-align: center;
        width: 49%;
    }

    .right {
        float: right;
        text-align: center;
        width: 49%;
    }

    @media print {
        #content {
            height: 99%;
            margin-top: 0px;
            padding: 0.15in;
        }

        .no-print {
            display: none;
        }

        #wrapper {
            max-width: 8.3in;
            min-width: 8.3in;
            height: 11.7in;
            margin-top: 0px;
            padding: 0.15in;
            height: 99%;
        }

        .no-border {
            border: none !important;
        }

        @page {
            /*margin-top: 0in;
			margin-bottom: 0.35in*/
            margin: 0;
        }
    }
</style>

<div id="wrapper">
	<div id="receiptData">
		<div id="content">
			<div class="text-header-moul">
				<h1>ព្រះរាជាណាចក្រកម្ពុជា</h1>
				<h1>ជាតិ សាសនា ព្រះមហាក្សត្រ</h1>
			</div>
			<div class="logo">
				<img src="/media/images/cnm_android_icon.png" style="width: 0.84in" alt="Alternate Text" />
				<h2>មជ្ឈមណ្ឌលជាតិប្រយុទ្ធនឹងជំងឺគ្រុនចាញ់</h2>
				<h2>ប៉ារ៉ាស៊ីតសាស្ត្រ និង បាណកសាស្ត្រ</h2>
			</div>
			<div class="text-header-moul">
				<h1>របាយការណ៌សកម្មភាពអភិបាល</h1>
				<h1>សកម្មភាពអង្កេតតាមដានករណីគ្រុនចាញ់</h1>
			</div>

			<div class="content-body">
				<h3>១. សេចក្តីផ្តើម</h3>
				<p>
					ផ្នែកទិន្នន័យធ្វើសកម្មភាពចុះអភិបាលដើម្បីជំរុញគុណភាពក្នុងការអនុវត្តសកម្មភាពអង្កេតតាមដានជំងឺគ្រុនចាញ់ដល់ថ្នាក់ខេត្ត ស្រុកប្រតិបត្តិ និងជាពិសេសថ្នាក់មណ្ឌលសុខភាព ដើម្បីឆ្លើយតបទៅនឹងសុចនាករដែលបានកំណត់ក្នុង ប្រពន្ធ័អង្កេតតាមដានសំរាប់លុបបំបាត់គ្រុនចាញ់អភិបាលក្រុមការងារលុបបំបាត់ជំងឺគ្រុនចាញ់របស់ក្រសួងសុខាភិបាល ។
				</p>

				<h3>២. សមាសភាពអ្នកចូលរួម</h3>
				<h3 style="margin-left:33px">២.១ លេខកូដបេសកកម្ម៖ <span data-bind="text: mission_no"></span></h3>
				<h3 style="margin-left:33px">២.២ សមាសភាពចូលរួម៖</h3>

				<ul data-bind="foreach: participants">
					<li style="margin-left: 83px"> 
						<div style="width:23%; float:left; font-size:12pt" data-bind="text: name"></div> 
						<div style="font-size:12pt" data-bind="text: '(' + position + ')'"></div>
					</li>
				</ul>

				<h3>៣. កាលបរិច្ឆេទ / ទីកន្លែង</h3>
				<p>
					ចាប់ពីថ្ងៃទី
					<span data-bind="text: date"></span> នៅមណ្ឌលសុខភាព
					<span data-bind="text: place"></span>
				</p>

				<h3>៤. គោលបំណង</h3>
				<ul>
					<li>ពិនិត្យឡើងវិញនូវទិន្នន័យជំងឺគ្រុនចាញ់នៅក្នុងប្រព័ន្ធMISក្នុងរយៈពេល ៣ ខែចុងក្រោយ ឆ្នាំបច្ចុប្បន្ន និងឆ្នាំមុន (HC+VMW)</li>
					<li>ស្រង់ទិន្នន័យជាក់ស្តែងនៅក្នុងបញ្ជីកត់ត្រាជំងឺគ្រុនចាញ់ប្រចាំខែ ក្នុងសៀវភៅគ្រុនចាញ់ (សៀវភៅតារាងស្ថិតិអ្នកជំងឺគ្រុនចាញ់ប្រចាំខែរបស់ HC) +
						របាយការណ៍ករណីជំងឺគ្រុនចាញ់ប្រចាំខែរបស់ VMW</li>
					<li>ពិនិត្យការរាយការណ៍ករណីបន្ទាន់ ការអង្កេតករណី ធ្វើចំណាត់ថ្នាក់ និងការរុករកករណីគ្រុនចាញ់ជុំវិញករណីគោល (Notification, Case Investigation, Classification and RACD)</li>
					<li>ពិនិត្យការការអង្កេតសំបុកចម្លង (Foci Investigation) រយៈពេល១ឆ្នាំកន្លង</li>
				</ul>

				<h3>៥. វិធីសាស្រ្ត / ដំណើរការសកម្មភាពការងារ</h3>
				<h3 style="margin-left:33px">៥.១ វិធីសាស្រ្ត៖ </h3>
				<ul>
					<li>ផ្ទៀងផ្ទាត់របាយការណ៍គ្រុនចាញ់លើក្រដាស់ជាកស្តែងនិងលើTablet</li>
					<li>ពិនិត្យការរាយការណ៍ករណីបន្ទាន់ (Notification) ពិនិត្យ៣ខែចុងក្រោយ</li>
					<li>ពិនិត្យការអង្កេតករណី និងចំណាត់ថ្នាក់ (Case Investigation / Classification) រយៈពេល៣ខែចុងក្រោយ</li>
					<li>ពិនិត្យការរុករកករណីគ្រុនចាញ់ជុំវិញករណីគោល (RACD) រយៈពេល៣ខែចុងក្រោយ</li>
				</ul>

				<h3>៦.​ បញ្ហាប្រឈម/ដំណោះស្រាយ</h3>
				<ul data-bind="foreach: problems">
					<li data-bind="text: $data"></li>
				</ul>
				<ul data-bind="foreach: solutions">
					<li data-bind="text: $data"></li>
				</ul>
			</div>
			<div class="content-footer">
				<div class="left">
					<p>ប្រធានមជ្ឈមណ្ឌលជាតិប្រយុទ្ធនឹងជំងឺគ្រុនចាញ់</p>
					<p>ប៉ារ៉ាស៊ីតសាស្ត្រ និង បាណកសាស្ត្រ</p>
				</div>

				<div class="right">
					<p>
						ភ្នំពេញ, <?php echo date('d-m-Y')?>
					</p>
					<p>អ្នកធ្វើរបាយការណ៍ </p>
				</div>
			</div>
		</div><!-- /content-->
		<div style="clear:both;"></div>
	</div>

	<div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
		<hr />
		<span class="pull-left col-xs-12">
			<button onclick="window.print();" class="btn btn-block btn-primary">
				Print
			</button>
		</span>
		<div style="clear:both;"></div>
	</div>
</div>

<?=latestJs('/media/ViewModel/Checklist_EpiReport.js')?>