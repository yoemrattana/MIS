<div class="row-v2">
	<div class='six small-12 columns contact-box space'>
		<h4>Reports</h4>
	</div>
	<div id="report-ct">
		<?php if (isset($permiss['Dashboard'])) : ?>
		<div class="row-v2">
			<div class="twelve large-12 columns space work-box big" style="padding-left: 23px; padding-right: 55px">
				<div>
					<div class="projects-slider">
						<ul>
							<li>
								<a href="/Dashboard">
									<img height="140" src="/media/assetsV2/images/slide/graph-1.png" alt="1j5JfNg" />
								</a>
							</li>
							<li>
								<a href="/Dashboard">
									<img height="140" src="/media/assetsV2/images/slide/graph-2.png" alt="1m7ZhI3" />
								</a>
							</li>
							<li>
								<a href="/Dashboard">
									<img height="140" src="/media/assetsV2/images/slide/graph-3.png" alt="1m7ZhI3" />
								</a>
							</li>
						</ul>

					</div>
				</div>
				<span class='box-title-dashboard'>Dashboard</span>
			</div>
		</div>
		<?php endif ?>
		<?php if (isset($permiss['Reports'])) : ?>
		<a href="/Report">
			<div class='six small-6 columns contact-box space'>
				<div class='color-10'>
					<span class='box-title'>Reports</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/report.png" />
					<!--<i class='fa-file-text-o fa fa-4x'></i>-->
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Reports V2'])) : ?>
		<a href="/ReportV2">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title'>M&E Reports</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/report.png" />
					<!--<i class='fa-files-o fa fa-4x'></i>-->
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Reports MMP'])) : ?>
		<a href="/ReportMilitary">
			<div class='six small-6 columns contact-box space'>
				<div class='color-7'>
					<span class='box-title'>Reports MMP</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/report.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Reports Police'])) : ?>
		<a href="/ReportPolice">
			<div class='six small-6 columns contact-box space'>
				<div class='color-7'>
					<span class='box-title'>Reports Police</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/report.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Reports Director'])) : ?>
		<a href="/ReportDirector">
			<div class='six small-6 columns contact-box space'>
				<div class='color-9'>
					<span class='box-title'>Reports Director</span>
					<br />
					<img width="55" src="/media/assetsV2/images/icon/report.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Pivot Table'])) : ?>
		<a href="/PivotChart">
			<div class='six small-6 columns contact-box space'>
				<div class='color-14'>
					<span class='box-title'>Pivot Table</span>
					<br />
					<img width="55" src="/media/images/pivot.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Investigation Map'])) : ?>
		<a href="/InvestigationMap">
			<div class='six small-6 columns contact-box space'>
				<div class='color-14'>
					<span class='box-title-up'>Investigation</span>
					<span class='box-title'>Map</span>
					<br />
					<i class='fa-map fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Bulletin'])) : ?>
		<a href="/Bulletin">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title'>Bulletin</span>
					<br />
					<i class='fa-list-ul fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['Pv Radical Cure Map'])) : ?>
		<a href="/PvRadicalCureMap">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3'>
					<span class='box-title-up'>Pv Radical</span>
					<span class='box-title'>Cure Map</span>
					<br />
					<i class='fa-map fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['MEAF Indicators'])) : ?>
		<a href="/MEAFIndicator">
			<div class='six small-6 columns contact-box space'>
				<div class='color-3' style="padding-top:0; padding-left:10px">
					<span class='box-title-up'>MEAF</span>
					<span class='box-title'>Indicators</span>
					<br />
					<img width="90" src="/media/assetsV2/images/icon/MEAF.png" />
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['RDT Calculate'])) : ?>
		<a href="/RDTCalculate">
			<div class='six small-6 columns contact-box space'>
				<div class='color-11'>
					<span class='box-title-up'>RDT</span>
					<span class='box-title'>Calculate</span>
					<br />
					<i class='fa-sitemap fa fa-4x fa-rotate-270'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
		<?php if (isset($permiss['MRRT Members'])) : ?>
		<a href="/MRRT">
			<div class='six small-6 columns contact-box space'>
				<div style="background-color:darkcyan">
					<span class='box-title-up'>MRRT</span>
					<span class='box-title'>Members</span>
					<br />
					<i class='fa-graduation-cap fa fa-4x'></i>
				</div>
			</div>
		</a>
		<?php endif ?>
        <?php if (isset($permiss['Imported Cases'])) : ?>
        <a href="/ImpCase">
            <div class='six small-6 columns contact-box space'>
                <div class='color-3'>
                    <span class='box-title-up'>Imported</span>
                    <span class='box-title'>Cases</span>
                    <br />
                    <i class='fa-plane fa fa-4x'></i>
                </div>
            </div>
        </a>
        <?php endif ?>
	</div>
</div>