<?php $this->load->view('lesson/header') ?>

<style>
        .badge {
  background-color: #12CBC4;
  color: white;
  padding: 4px 8px;
  text-align: center;
  border-radius: 5px;
}
</style>

<section class="bg-blue py-7">
	<div class="container">
		<div class="row justify-content-lg-between">

			<div class="col-lg-8">
				<!-- Title -->
				<h1 class="text-white"><?php echo $title?></h1>

			</div>

			<div class="col-lg-3">
				<a href="/Lesson/index" class="btn btn-warning mb-3 w-100">Unit</a>
			</div>
		</div>
	</div>
</section>

<section class="pt-0">
	<div class="container">
		<div class="row">
			<!-- Main content START -->
			<div class="col-12">
				<div class="card shadow rounded-2 p-0 mt-n5">
					<!-- Tabs START -->
					<div class="card-header border-bottom px-4 pt-3 pb-0">
						<ul class="nav nav-bottom-line py-0" id="course-pills-tab" role="tablist">
							<!-- Tab item -->
							<li class="nav-item me-2 me-sm-4" role="presentation">
								<button class="nav-link mb-2 mb-md-0 active" id="course-pills-tab-1" data-bs-toggle="pill" data-bs-target="#course-pills-1" type="button" role="tab" aria-controls="course-pills-1" aria-selected="true">Course Materials</button>
							</li>

						</ul>
					</div>
					<!-- Tabs END -->

					<!-- Tab contents START -->
					<div class="card-body p-sm-4">
						<div class="tab-content" id="course-pills-tabContent">
							<!-- Content START -->
							<div class="tab-pane fade show active" id="course-pills-1" role="tabpanel" aria-labelledby="course-pills-tab-1">
								<!-- Accordion START -->
								<div class="accordion accordion-icon accordion-border" id="accordionExample2">
									<!-- Item -->
									<div class="accordion-item mb-3">
										<h6 class="accordion-header font-base" id="heading-1">
											<button class="accordion-button fw-bold rounded d-flex collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
												VMW
											</button>
										</h6>

                                        <div id="collapse-1" class="accordion-collapse collapse" aria-labelledby="heading-1" data-bs-parent="#accordionExample1">
                                            <div class="accordion-body mt-3">
                                                <!-- Course lecture -->
                                                <?php foreach( $vmws as $k => $vmw ) : ?>
                                                <h4 style="font-weight: bold;">
                                                    <?php echo $k ?>
                                                </h4>

                                                <?php foreach ($vmw as $sub) : ?>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <?php if ( $sub['Type'] == 'Video' ) : ?>
                                                        <a data-glightbox data-gallery="office-tour" href="<?php echo $sub['YouTube']?>" class="icon-md position-relative glightbox3">
                                                            <img src="/media/assetsLesson/images/courses/4by3/01.jpg" class="rounded-1" alt="" />
                                                            <small class="text-white position-absolute top-50 start-50 translate-middle">
                                                                <i class="fas fa-play me-0 "></i>
                                                            </small>
                                                        </a>
                                                        <?php endif; ?>

                                                        <?php if ( in_array($sub['Type'], ['PDF', 'Slide'] )  ) : ?>
                                                        <a href="/media/Training/<?php echo $sub['Source']?>" target="_blank" class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                            <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                        </a>
                                                        <?php endif; ?>

                                                        <div class="ms-3">
                                                            <span class="badge">
                                                                <?php echo $sub['Category']?>
                                                            </span>
                                                            <a href="/media/Training/<?php echo $sub['Source']?>" style="font-family: 'Khmer OS Battambang'; line-height: 2.1" class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">
                                                                <?php echo $sub['Title']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php endforeach ; ?>
                                                <hr /><!-- Divider -->
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
									</div>

									<!-- Item -->
									<div class="accordion-item mb-3">
										<h6 class="accordion-header font-base" id="heading-2">
											<button class="accordion-button fw-bold rounded d-flex collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="true" aria-controls="collapse-2">
												HC
											</button>
										</h6>

                                        <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2" data-bs-parent="#accordionExample2">
                                            <div class="accordion-body mt-3">
                                                <!-- Course lecture -->
                                                <?php foreach( $hcs as $k => $hc ) : ?>
                                                <h4 style="font-weight: bold;">
                                                    <?php echo $k ?>
                                                </h4>

                                                <?php foreach ($hc as $sub) : ?>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <?php if ( $sub['Type'] == 'Video' ) : ?>
                                                        <a data-glightbox data-gallery="office-tour" href="<?php echo $sub['YouTube']?>" class="icon-md position-relative glightbox3">
                                                            <img src="/media/assetsLesson/images/courses/4by3/01.jpg" class="rounded-1" alt="" />
                                                            <small class="text-white position-absolute top-50 start-50 translate-middle">
                                                                <i class="fas fa-play me-0 "></i>
                                                            </small>
                                                        </a>
                                                        <?php endif; ?>

                                                        <?php if ( in_array($sub['Type'], ['PDF', 'Slide'] )  ) : ?>
                                                        <a href="/media/Training/<?php echo $sub['Source']?>" target="_blank" class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                            <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                        </a>
                                                        <?php endif; ?>

                                                        <div class="ms-3">
                                                            <span class="badge">
                                                                <?php echo $sub['Category']?>
                                                            </span>
                                                            <a href="/media/Training/<?php echo $sub['Source']?>" style="font-family: 'Khmer OS Battambang'; line-height: 2.1" class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">
                                                                <?php echo $sub['Title']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php endforeach ; ?>
                                                <hr /><!-- Divider -->
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
										
									</div>

                                    <!-- Item -->
                                    <div class="accordion-item mb-3">
                                        <h6 class="accordion-header font-base" id="heading-3">
                                            <button class="accordion-button fw-bold rounded d-flex collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="true" aria-controls="collapse-3">
                                                OD
                                            </button>
                                        </h6>

                                        <div id="collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3" data-bs-parent="#accordionExample3">
                                            <div class="accordion-body mt-3">
                                                <!-- Course lecture -->
                                                <?php foreach( $ods as $k => $od ) : ?>
                                                <h4 style="font-weight: bold;">
                                                    <?php echo $k ?>
                                                </h4>

                                                <?php foreach ($od as $sub) : ?>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <?php if ( $sub['Type'] == 'Video' ) : ?>
                                                        <a data-glightbox data-gallery="office-tour" href="<?php echo $sub['YouTube']?>" class="icon-md position-relative glightbox3">
                                                            <img src="/media/assetsLesson/images/courses/4by3/01.jpg" class="rounded-1" alt="" />
                                                            <small class="text-white position-absolute top-50 start-50 translate-middle">
                                                                <i class="fas fa-play me-0 "></i>
                                                            </small>
                                                        </a>
                                                        <?php endif; ?>

                                                        <?php if ( in_array($sub['Type'], ['PDF', 'Slide'] )  ) : ?>
                                                        <a href="/media/Training/<?php echo $sub['Source']?>" target="_blank" class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                            <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                        </a>
                                                        <?php endif; ?>

                                                        <div class="ms-3">
                                                            <span class="badge">
                                                                <?php echo $sub['Category']?>
                                                            </span>
                                                            <a href="/media/Training/<?php echo $sub['Source']?>" style="font-family: 'Khmer OS Battambang'; line-height: 2.1" class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">
                                                                <?php echo $sub['Title']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php endforeach ; ?>
                                                <hr /><!-- Divider -->
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <!-- Item -->
                                    <div class="accordion-item mb-3">
                                        <h6 class="accordion-header font-base" id="heading-4">
                                            <button class="accordion-button fw-bold rounded d-flex collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="true" aria-controls="collapse-4">
                                                PHD
                                            </button>
                                        </h6>

                                        <div id="collapse-4" class="accordion-collapse collapse" aria-labelledby="heading-4" data-bs-parent="#accordionExample4">
                                            <div class="accordion-body mt-3">
                                                <!-- Course lecture -->
                                                <?php foreach( $phds as $k => $phd ) : ?>
                                                <h4 style="font-weight: bold;"> <?php echo $k ?></h4>
                                                
                                                <?php foreach ($phd as $sub) : ?>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <?php if ( $sub['Type'] == 'Video' ) : ?>
                                                        <a data-glightbox data-gallery="office-tour" href="<?php echo $phd['YouTube']?>" class="icon-md position-relative glightbox3">
                                                            <img src="/media/assetsLesson/images/courses/4by3/01.jpg" class="rounded-1" alt="" />
                                                            <small class="text-white position-absolute top-50 start-50 translate-middle">
                                                                <i class="fas fa-play me-0 "></i>
                                                            </small>
                                                        </a>
                                                        <?php endif; ?>

                                                        <?php if ( in_array($sub['Type'], ['PDF', 'Slide'] )  ) : ?>
                                                        <a href="/media/Training/<?php echo $sub['Source']?>" target="_blank" class="icon-md mb-0 position-static flex-shrink-0 text-body">
                                                            <i class="fas fa-fw fa-file-signature fs-5"></i>
                                                        </a>
                                                        <?php endif; ?>

                                                        <div class="ms-3">
                                                            <span class="badge">
                                                                <?php echo $sub['Category']?>
                                                            </span>
                                                            <a href="/media/Training/<?php echo $sub['Source']?>" style="font-family: 'Khmer OS Battambang'; line-height: 2.1" class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">
                                                                <?php echo $sub['Title']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php endforeach ; ?>
                                                <hr /><!-- Divider -->
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
									
								</div>
								<!-- Accordion END -->
							</div>
							<!-- Content END -->

						</div>
					</div>
					<!-- Tab contents END -->
				</div>
			</div>
			<!-- Main content END -->
		</div><!-- Row END -->
	</div>
</section>
<?php $this->load->view('lesson/footer') ?>