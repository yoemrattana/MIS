
<div class="row-v2">
	<div class='six small-12 columns contact-box space'>
		<h4>Master Data Management</h4>
	</div>
	<div id="management-ct">
		<?php if (isset($permiss['System Menu'])) : ?>
		<a href="/Home/sysmenu">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title'>System Menu</span>
					<br />
					<i class='fa-gears fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/Treatment">
			<div class='six small-6 columns contact-box space'>
				<div class='color-10 scroll-box9'>
					<span class='box-title'>Anti Malaria Drug</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/medicines.png" />
				</div>
			</div>
		</a>
		<a href="/User">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title-up'>User</span>
					<span class='box-title'>Management</span>
					<br />

					<i class='fa-users fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>

		<?php
			$founds = array_filter($permiss['Device Management'] ?? [], function($v) { return !in_array($v, ['Edit','Delete']); });
			$hasDevice = count($founds) > 0;
		?>
		<?php if ($role == 'AU' || (isset($permiss['Device Management']) && $hasDevice)) : ?>
		<a href="/Device">
			<div class='six small-6 columns contact-box space'>
				<div class='color-7'>
					<span class='box-title-up'>Device</span>
					<span class='box-title'>Management</span>
					<br />

					<img width="55" src="/media/assetsV2/images/icon/device.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/DeviceInventory">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title-up'>Device</span>
					<span class='box-title'>Inventory</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/device.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/PlacePermission">
			<div class='six small-6 columns contact-box space'>
				<div class='color-9'>
					<span class='box-title-up'>App Feature</span>
					<span class='box-title'>Permission</span>
					<br />
					<i class='fa-sitemap fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (!in_array($role, ['GUEST'])) : ?>
		<a data-bind="click: showPassword">
			<div class='six small-6 columns contact-box space'>
				<div class='color-9'>
					<span class='box-title'>Change Password</span>
					<br />
					<i class='fa-key fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Notification'])) : ?>
		<a href="/Notification">
			<div class='six small-6 columns contact-box space'>
				<div class='color-15'>
					<span class='box-title'>Notification</span>
					<br />
					<i class='fa-bell fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/SystemMenu/vmwLogTrackingLog">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title-up'>VMW Log</span>
					<span class='box-title'>Track</span>
					<br />
					<i class='fa-history fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Contact'])) : ?>
		<a href="/Contact">
			<div class='six small-6 columns contact-box space'>
				<div class='color-9'>
					<span class='box-title'>Contact</span>
					<br />
					<i class='fa-address-card-o fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/Log">
			<div class='six small-6 columns contact-box space'>
				<div class='color-10'>
					<span class='box-title'>MIS Error Log</span>
					<br />
					<i class='fa-bug fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/Broadcast">
			<div class='six small-6 columns contact-box space'>
				<div class='color-1'>
					<span class='box-title'>Broadcast</span>
					<br />
					<i class='fa-bullhorn fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/Email">
			<div class='six small-6 columns contact-box space'>
				<div class='color-2'>
					<span class='box-title'>Email Config</span>
					<br />
					<i class='fa-envelope fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>

		<?php if ($role == 'AU') : ?>
		<a href="/Log/caseLog">
			<div class='six small-6 columns contact-box space'>
				<div class='color-15'>
					<span class='box-title'>Delete Log</span>
					<br />
					<i class='fa-trash fa fa-4x'></i>
				</div>
			</div>
		</a>
		<a href="https://mis-dev-doc.readthedocs.io/en/latest/" target="_blank">
			<div class='six small-6 columns contact-box space'>
				<div class='color-10'>
					<span class='box-title-up'>Developer</span>
					<span class='box-title'>Documentation</span>
					<br />
					<i class='fa-connectdevelop fa fa-4x'></i>
				</div>
			</div>
		</a>
		
		<a href="/Quiz">
			<div class='six small-6 columns contact-box space'>
				<div class='color-1'>
					<span class='box-title-up'>Quiz</span>
					<span class='box-title'>Questionaire</span>
					<br />
					<i class='fa-align-left fa fa-4x'></i>
				</div>
			</div>
		</a>
		<a href="/Message">
			<div class='six small-6 columns contact-box space'>
				<div class='color-2'>
					<span class='box-title-up'>Message</span>
					<span class='box-title'>Inbox</span>
					<br />
					<i class='fa-wechat fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<a href="/App/gallery">
			<div class='six small-6 columns contact-box space'>
				<div class='color-14'>
					<span class='box-title-up'>App</span>
					<span class='box-title'>Gallery</span>
					<br />
					<i class='fa-android fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php if (isset($permiss['Train Material'])) : ?>
		<a href="/Train">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title-up'>Training</span>
					<span class='box-title'>Material</span>
					<br />
					<i class='fa-film fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif; ?>
		<?php if ($role == 'AU') : ?>
        <a href="/RiskPop">
            <div class='six small-6 columns contact-box space'>
                <div class='color-7'>
                    <span class='box-title'>Pop at Risk</span>
                    <br />
                    <i class='fa-smile-o fa fa-4x'></i>
                </div>
            </div>
        </a>
		<a href="/TeleGroup">
			<div class='six small-6 columns contact-box space'>
				<div class='color-7'>
					<span class='box-title'>Telegram Group</span>
					<br />
					<i class='fa-telegram fa fa-4x'></i>
				</div>
			</div>
		</a>
		<a href="/Mission">
			<div class='six small-6 columns contact-box space'>
				<div class='color-9'>
					<span class='box-title'>Mission</span>
					<br />
					<i class='fa-calendar fa fa-4x'></i>
				</div>
			</div>
		</a>
		<a href="/Task">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title'>Task</span>
					<br />
					<i class='fa-calendar fa fa-4x'></i>
				</div>
			</div>
		</a>
        <a href="/Blog">
            <div class='six small-6 columns contact-box space'>
                <div class='color-1'>
                    <span class='box-title'>Blog</span>
                    <br />
                    <i class='fa-rss fa fa-4x'></i>
                </div>
            </div>
        </a>
        <a href="/Document">
            <div class='six small-6 columns contact-box space'>
                <div class='color-2'>
                    <span class='box-title'>Documents</span>
                    <br />
                    <i class='fa-file-pdf-o fa fa-4x'></i>
                </div>
            </div>
        </a>
		
		<?php endif; ?>
		<?php if (isset($permiss['Case Monitoring'])) : ?>
		<a href="/CaseMonitoring">
			<div class='six small-6 columns contact-box space'>
				<div class='color-14'>
					<span class='box-title-up'>Case</span>
					<span class='box-title'>Monitoring</span>
					<br />
					<i class='fa-stethoscope fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
        <?php if (isset($permiss['Case Confirm'])) : ?>
        <a href="/CaseConfirm">
            <div class='six small-6 columns contact-box space'>
                <div class='color-7'>
                    <span class='box-title'>Pf Mix Confirm</span>
                    <br />
                    <i class='fa-filter fa fa-4x'></i>
                </div>
            </div>
        </a>
        <?php endif ?>
        <?php if (isset($permiss['Patient'])) : ?>
        <a href="/Patient">
            <div class='six small-6 columns contact-box space'>
                <div class='color-1'>
                    <span class='box-title'>Patient Code</span>
                    <br />
                    <i class='fa-filter fa fa-4x'></i>
                </div>
            </div>
        </a>
        <?php endif ?>
		<a href="/Lesson">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title'>Lesson</span>
					<br />
					<i class='fa-leanpub fa fa-4x'></i>
				</div>
			</div>
		</a>
        <?php if (isset($permiss['EVENT'])) : ?>
        <a href="/Event">
            <div class='six small-6 columns contact-box space'>
                <div class='color-10'>
                    <span class='box-title'>Event</span>
                    <br />
                    <i class='fa-calendar fa fa-4x'></i>
                </div>
            </div>
        </a>
        <?php endif ?>
	</div>
</div>