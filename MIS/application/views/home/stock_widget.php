<div class="row-v2">
	<div class='six small-12 columns contact-box space'>
		<h4>Stock</h4>
	</div>
	<div id="stock-ct">
		<?php if (isset($permiss['Stock Request'])) : ?>
		<a href="/Stock/request">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title'>Stock Request</span>
					<img style="margin-left: -8px; margin-top: 12px;" width="80" src="/media/assetsV2/images/icon/stock.png" />
				</div>
			</div>
		</a>
		<?php endif ?>

		<?php
			$founds = array_filter($permiss['Stock Data'] ?? [], function($v) { return in_array($v, ['Stock OD','Stock HF','Stock VMW']); });
			$hasStock = count($founds) > 0;
		?>
		<?php if (isset($permiss['Stock Data']) && $hasStock) : ?>
		<a href="/Stock/report">
			<div class='six small-6 columns contact-box space'>
				<div class='color-10'>
					<span class='box-title'>Stock Data</span>
					<img style="margin-left: -8px; margin-top: 12px;" width="80" src="/media/assetsV2/images/icon/stock.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['CNM Stock Data'])) : ?>
		<a href="/Stock/reportCNM">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title'>CNM Stock Data</span>
					<img style="margin-left: -8px; margin-top: 12px;" width="80" src="/media/assetsV2/images/icon/stock.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if ($role == 'AU') : ?>
		<a href="/Stock/item">
			<div class='six small-6 columns contact-box space'>
				<div class='color-7'>
					<span class='box-title'>Stock Item</span>
					<img style="margin-left: -8px; margin-top: 12px;" width="80" src="/media/assetsV2/images/icon/stock.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['OD Stock Monitoring'])) : ?>
		<a href="/StockMonitoring/od">
			<div class="six small-6 columns contact-box space">
				<div class="color-14">
					<span class="box-title-up">OD Stock</span>
					<span class="box-title" style="text-align:left">Completeness Monitoring</span>
					<br />
					<i class="fa-stethoscope fa fa-4x"></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['HC Stock Monitoring'])) : ?>
		<a href="/StockMonitoring/hc">
			<div class="six small-6 columns contact-box space">
				<div class="color-3">
					<span class="box-title-up">HC Stock</span>
					<span class="box-title" style="text-align:left">Completeness Monitoring</span>
					<br />
					<i class="fa-stethoscope fa fa-4x"></i>
				</div>
			</div>
		</a>
		<?php endif ?>
	</div>
</div>