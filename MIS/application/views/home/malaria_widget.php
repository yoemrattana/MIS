<style>
	.subMenu {
		border: 1px solid gray;
		border-radius: 12px;
		background-color: white;
		padding: 5px !important;
		position: absolute !important;
		left: -142px;
		bottom: 100px;
		z-index: 2;
		width: 429px;
		box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19) !important;
	}

	.subMenu div {
		width: 100px;
		height: 100px;
		margin: 2px;
		padding: 5px;
		float: left;
		text-align: center;
		display: flex;
		justify-content: center;
		align-items: center;
		color: white;
		font-size: 16px;
		border-radius: 12px;
	}

	.color-99 { background-color: darkcyan; }
</style>

<div class="row-v2">
	<div class='six small-12 columns contact-box space'>
		<h4>Malaria & ITN Data</h4>
	</div>
	<div id="data-entry-ct">
		<?php if (isset($permiss['VMW Data'])) : ?>
		<a href="/CaseReport/vmw">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title'>VMW</span>
					<br />
					<i class='fa-home fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['VMW Data Accuracy'])) : ?>
		<a href="/CaseReport/vmwDataAccuracy">
			<div class='six small-6 columns contact-box space'>
				<div class='color-10'>
					<span class='box-title-up'>VMW</span>
					<span class='box-title'>Data Accuracy</span>
					<br />
					<i class='fa-home fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Health Center Data'])) : ?>
		<a href="/CaseReport/hf">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title'>Health Center</span>
					<br />
					<i class='fa-user-md fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Health Center Data Accuracy'])) : ?>
		<a href="/CaseReport/hfDataAccuracy">
			<div class='six small-6 columns contact-box space'>
				<div class='color-7'>
					<span class='box-title-up'>HC</span>
					<span class='box-title'>Data Accuracy</span>
					<br />
					<i class='fa-user-md fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['MMP Data'])) : ?>
		<a href="/CaseReport/ml">
			<div class='six small-6 columns contact-box space'>
				<div class='color-13'>
					<span class='box-title'>MMP</span>
					<br />
					<i class='fa-maxcdn fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['MMP Bed Net'])) : ?>
		<a href="/CaseReport/bednetML">
			<div class='six small-6 columns contact-box space'>
				<div class='color-10'>
					<span class='box-title'>MMP Bed Net</span>
					<br />
					<i class='fa-maxcdn fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>

		<?php if (isset($permiss['Police Data'])) : ?>
		<a href="/CaseReport/pl">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title'>Police</span>
					<br />
					<i class='fa-product-hunt fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Police Bed Net'])) : ?>
		<a href="/CaseReport/bednetPL">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title'>Police Bed Net</span>
					<br />
					<i class='fa-product-hunt fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>

		<?php if (isset($permiss['Environment Bed Net'])) : ?>
		<a href="/CaseReport/bednetEnv">
			<div class='six small-6 columns contact-box space'>
				<div class='color-12'>
					<span class='box-title-up'>Environment</span>
					<span class='box-title'>Bed Net</span>
					<br />
					<i class='fa-tree fa fa-4x'></i>
				</div>
			</div>
		</a>

		<?php endif ?>

		<?php if (isset($permiss['Bed Net Data'])) : ?>
		<a href="/CaseReport/bednet">
			<div class='six small-6 columns contact-box space'>
				<div class='color-14'>
					<span class='box-title'>Bed Net</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/bednet.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Bed Net Other Data'])) : ?>
		<a href="/CaseReport/bednetother">
			<div class='six small-6 columns contact-box space'>
				<div class='color-15'>
					<span class='box-title'>Bed Net Other</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/bednet.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Private Sector Data'])) : ?>
		<a href="/CaseReport/ppm">
			<div class='six small-6 columns contact-box space'>
				<div class='color-16'>
					<span class='box-title'>Private Sector</span>
					<br />
					<i class='fa-hospital-o fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Questionnaire'])) : ?>
		<a href="/Question">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title'>Questionnaire</span>
					<br />
					<i class='fa-question-circle fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Foci Investigation'])) : ?>
		<a href="/Foci">
			<div class='six small-6 columns contact-box space'>
				<div class='color-14'>
					<span class='box-title-up'>Foci</span>
					<span class='box-title'>Investigation</span>
					<br />
					<i class='fa-search fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['G6PD'])) : ?>
		<a href="CaseReport/g6pdInvestigation">
			<div class='six small-6 columns contact-box space'>
				<div class='color-1'>
					<span class='box-title-up'>G6PD</span>
					<span class='box-title'>Investigation</span>
					<br />
					<i class='fa-search-plus fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['VMW Followup Patient'])) : ?>
		<a href="/VMWFollowup">
			<div class='six small-6 columns contact-box space'>
				<div class='color-15'>
					<span class='box-title-up' style="font-size: 11px">Follow up</span>
					<span style="font-weight: 900;float: right;padding-top: 0px; font-size: 11px;">VMW</span>
					<span class='box-title'>Radical Cure</span>
					<br />
					<i class='fa-clipboard fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['HF Followup Patient'])) : ?>
		<a href="/HFFollowup">
			<div class='six small-6 columns contact-box space'>
				<div class='color-1'>
					<span class='box-title-up' style="font-size: 11px">Follow up</span>
					<span style="font-weight: 900;float: right;padding-top: 0px; font-size: 11px;">HF</span>
					<span class='box-title'>Radical Cure</span>
					<br />
					<i class='fa-clipboard fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Q Malaria'])) : ?>
		<a href="/QMalaria">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title-up'>Q Malaria</span>
					<span class='box-title'>CRP Duo Test</span>
					<br />
					<i class='fa-question-circle fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['CRF'])) : ?>
		<a href="/CRF">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title'>CRF Form</span>
					<br />
					<i class='fa-question-circle fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/CaseReport/bednetAccuracy">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title-up'>Bed Net</span>
					<span class='box-title'>Data Accuracy</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/bednet.png" />
				</div>
			</div>
		</a>
		<a href="/His">
			<div class='six small-6 columns contact-box space'>
				<div class='color-1'>
					<span class='box-title'>HIS Data Import</span>
					<br />
					<i class='fa-cloud-upload fa fa-4x'></i>
				</div>
			</div>
		</a>
		<a href="/BorderImport">
			<div class='six small-6 columns contact-box space'>
				<div class='color-15'>
					<span class='box-title'>Border Data Import</span>
					<br />
					<i class='fa-cloud-upload fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['RDT Reader'])) : ?>
		<a href="/RDTReader">
			<div class='six small-6 columns contact-box space'>
				<div class='color-2'>
					<span class='box-title'>RDT Reader</span>
					<br />
					<i class='fa-eyedropper fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['VMW QA'])) : ?>
		<a href="/VMWQA">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title'>VMW QA</span>
					<br />
					<img width="65" src="/media/assetsV2/images/icon/quality-assurance.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Lastmile'])) : ?>
		<a href="/Lastmile">
			<div class='six small-6 columns contact-box space'>
				<div class='color-7'>
					<span class='box-title'>Last Mile</span>
					<br />
					<img width="80" src="/media/assetsV2/images/icon/lastmile.png" />
				</div>
			</div>
		</a>
		<?php endif ?>

		<?php
			$founds = array_filter($permiss['Checklist'] ?? [], function($v) { return !in_array($v, ['Edit','Delete']); });
			$hasChecklist = count($founds) > 0;
		?>
		<?php if (isset($permiss['Checklist']) && $hasChecklist) : ?>
		<a href="/Checklist">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title'>Checklist</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/report.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['iDes'])) : ?>
		<a href="/iDes">
			<div class='six small-6 columns contact-box space'>
				<div class='color-14'>
					<span class='box-title'>iDES</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/report.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Entomology'])) : ?>
		<a href="/Entomology">
			<div class="six small-6 columns contact-box space">
				<div class="color-9" style="padding-top:0; padding-left:10px">
					<span class="box-title">Entomology</span>
					<br />
					<img width="90" src="/media/assetsV2/images/icon/MEAF.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['VMW Survey'])) : ?>
		<a href="/VMWSurvey">
			<div class='six small-6 columns contact-box space'>
				<div class='color-15'>
					<span class='box-title'>VMW Survey</span>
					<br />
					<i class='fa-clipboard fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['VMW Meeting'])) : ?>
		<a href="/VMWMeeting">
			<div class='six small-6 columns contact-box space'>
				<div style="background-color:darkcyan">
					<span class='box-title'>VMW Meeting</span>
					<br />
					<i class='fa-calendar fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['RCD CMEP'])) : ?>
		<a href="/RCD_CMEP">
			<div class='six small-6 columns contact-box space'>
				<div class="color-12">
					<span class="box-title-up">RACD</span>
					<span class='box-title'>CMEP Form</span>
					<br />
					<i class="fa-clipboard fa fa-4x"></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Training and Meeting'])) : ?>
		<a href="/TrainingMeeting">
			<div class='six small-6 columns contact-box space'>
				<div class="color-9">
					<span class="box-title-up">Training</span>
					<span class='box-title'>and Meeting</span>
					<br />
					<i class='fa-calendar fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Surveillance Assessment Questionnaire'])) : ?>
		<a href="/QuestionBank">
			<div class='six small-6 columns contact-box space'>
				<div class="color-11">
					<span class="box-title-up">Surveillance</span>
					<span class='box-title text-left'>Assessment Questionnaire</span>
					<br />
					<i class='fa-question-circle fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Last Mile Elimination Assessment'])) : ?>
		<a href="/LastmileQuestion">
			<div class='six small-6 columns contact-box space'>
				<div style="background-color:darkcyan">
					<span class="box-title-up">Last Mile</span>
					<span class='box-title text-left'>Elimination Assessment</span>
					<br />
					<i class='fa-question-circle fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['PPM Referral Slip'])) : ?>
		<a href="/PPMReferralSlip">
			<div class='six small-6 columns contact-box space'>
				<div class="color-3">
					<span class="box-title-up">PPM</span>
					<span class='box-title text-left'>Referral Slip</span>
					<br />
					<i class='fa-hospital-o fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
        <?php if (isset($permiss['DQA'])) : ?>
        <a href="/DQA">
            <div class='six small-6 columns contact-box space'>
                <div class='color-2'>
                    <span class="box-title-up">DQA</span>
                    <span class='box-title text-left'>Surveillance Assessment</span>
                    <br />
                    <i class='fa-question-circle fa fa-4x'></i>
                </div>
            </div>
        </a>
        <?php endif ?>

		<?php if (isset($permiss['Lab'])) : ?>
		<a class="mainMenu">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class="box-title">Laboratory</span>
					<br />
					<i class='fa-flask fa fa-4x'></i>
				</div>

				<div class="subMenu" permiss="Lab" style="display:none">
					<div href="/Lab/index/staff" class="color-3">Staff Profile</div>
					<div href="/Lab/index/logbook" class="color-3">Log Book</div>
					<div href="/Lab/index/crosscheck" class="color-3">Cross-Checking</div>
					<div href="/Lab/index/referenceslide" class="color-3">Reference Slide</div>
					<div href="/Lab/index/paneltesting" class="color-11">Panel Testing</div>
					<div href="/Lab/index/eqa" class="color-11">EQA</div>
					<div href="/Lab/index/equipment" class="color-11">Equipment</div>
					<div href="/Lab/index/iqa" class="color-11">IQA</div>
					<div href="/Lab/index/stock" class="color-9">Stock</div>
					<div href="/Lab/index/ncamm_training" class="color-9">NCAMM</div>
					<div href="/Lab/index/ecamm_training" class="color-9">ECAMM</div>
					<div href="/Lab/index/preecamm_training" class="color-9">Pre-ECAMM</div>
					<div href="/Lab/index/basic_training" class="color-99">Basic</div>
					<div href="/Lab/index/refresher_training" class="color-99">Refresher</div>
					<div href="/Lab/index/slidebank" class="color-99">Slide Bank</div>
					<div href="/Lab/index/dashboard" class="color-99">Dashboard</div>
				</div>
			</div>
		</a>
		<?php endif ?>

		<?php if (isset($permiss['DOC'])) : ?>
		<a class="mainMenu">
			<div class='six small-6 columns contact-box space'>
				<div class='color-15'>
					<span class="box-title">DOC</span>
					<br />
					<i class="fa-clipboard fa fa-4x"></i>
				</div>

				<div class="subMenu" permiss="DOC" style="display:none">
					<div href="/DOC/index/phd" class="color-99">PHD</div>
					<div href="/DOC/index/od" class="color-11">OD</div>
					<div href="/DOC/index/rh" class="color-15">PRH/RH</div>
					<div href="/DOC/index/hc" class="color-5">HC</div>
					<div href="/DOC/index/vmw" class="color-14">VMW</div>
				</div>
			</div>
		</a>
		<?php endif ?>

        <?php if (isset($permiss['MRRT2'])) : ?>
        <a class="mainMenu">
            <div class='six small-6 columns contact-box space'>
                <div class='color-14'>
                    <span class="box-title">MRRT</span>
                    <br />
                    <i class="fa-medium fa fa-4x"></i>
                </div>

                <div class="subMenu" permiss="MRRT2" style="display:none">
                    <div href="/MRRT_Foci/" class="color-11">Foci</div>
                    <div href="/MRRT_CICC/" class="color-99">CICC</div>
                    <div href="/MRRT_Entomo/" class="color-2">Entomology</div>
                    <div href="/MRRT_TDA/" class="color-7">TDA</div>
                    <div href="/MRRT_IPTf/" class="color-5">IPTf</div>
					<div href="/MRRT_Traveler/" class="color-1">Travel</div>
                </div>

            </div>
        </a>
        <?php endif ?>

        <?php if (isset($permiss['RACDT'])) : ?>
        <a class="mainMenu">
            <div class='six small-6 columns contact-box space'>
                <div class='color-13'>
                    <span style="font-weight: 900;float: right;padding-top: 0px; font-size: 11px;">HF</span>
                    <span class="box-title">RACDT + CIHF</span>
                    <br />
                    <i class="fa-clipboard fa fa-4x"></i>
                </div>
                <div class="subMenu" permiss="RACDT" style="display:none">
                    <div href="/CIHF/" class="color-3">CIHF</div>
					<div href="/RACDT/" class="color-1">RACDT</div>
                </div>
            </div>
        </a>
        <?php endif ?>

        <?php if (isset($permiss['Checklist Pv'])) : ?>
        <a href="/ChecklistPv">
            <div class='six small-6 columns contact-box space'>
                <div class='color-2'>
                    <span class="box-title-up">Checklist</span>
                    <span class='box-title text-left'>Pv Redical Cure</span>
                    <br />
                    <i class='fa-question-circle fa fa-4x'></i>
                </div>
            </div>
        </a>
        <?php endif ?>

		<?php if (isset($permiss['VMW Assessment'])) : ?>
		<a href="/vmwassessment">
			<div class='six small-6 columns contact-box space'>
				<div class='color-2'>
					<span class="box-title-up">VMW/MMW</span>
					<span class='box-title text-left'>Assessment</span>
					<br />
					<i class='fa-question-circle fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
	</div>
</div>