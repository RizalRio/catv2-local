<?= $this->extend('IM\CI\Views\vP') ?>

<?= $this->section('content') ?>
<div class="row">
	<div class="col-lg-3">
		<?= $this->include('client/info-card'); ?>
	</div>
	<div class="col-lg-9">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-custom">
					<div class="card-header card-header-tabs-line nav-tabs-line-3x">
						<div class="card-toolbar">
							<ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
								<li class="nav-item mr-3">
									<a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1">
										<span class="nav-icon">
											<span class="svg-icon">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24"></polygon>
														<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
														<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
													</g>
												</svg>
											</span>
										</span>
										<span class="nav-text font-size-lg">Data Diri</span>
									</a>
								</li>
								<li class="nav-item mr-3">
									<a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_2">
										<span class="nav-icon">
											<span class="svg-icon">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24"></polygon>
														<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
														<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
													</g>
												</svg>
											</span>
										</span>
										<span class="nav-text font-size-lg">Akun</span>
									</a>
								</li>
								<li class="nav-item mr-3">
									<a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_3">
										<span class="nav-icon">
											<span class="svg-icon">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24"></rect>
														<path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
														<path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"></path>
														<path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"></path>
													</g>
												</svg>
											</span>
										</span>
										<span class="nav-text font-size-lg">Ubah Password</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane show px-7 active" id="kt_user_edit_tab_1" role="tabpanel">
								<div class="row">
									<div class="col-12 my-2">
										<?php if (user()->complete_reg == 0) : ?>
											<div class="form-group row">
												<div class="col-12">
													<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
														<div class="alert-icon"><i class="flaticon-warning"></i></div>
														<div class="alert-text">Lengkapi profil Anda!</div>
													</div>
												</div>
											</div>
										<?php endif; ?>
										<?= form_open('', $form_personal); ?>
										<?= $formPersonal; ?>
										<div class="form-group row">
											<div class="col-3"></div>
											<div class="col-9">
												<?= form_button($btnSubmitPersonal); ?>
												<?= form_button($btnResetPersonal); ?>
											</div>
										</div>
										<?= form_close(); ?>
									</div>
								</div>
							</div>
							<div class="tab-pane px-7" id="kt_user_edit_tab_2" role="tabpanel">
								<div class="row">
									<div class="col-12 my-2">
										<?= form_open_multipart('', $form_account); ?>
										<div class="form-group row">
											<label class="col-3">Avatar</label>
											<div class="col-9">
												<div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar" style="background-image: url('<?= (user()->avatar == DEFAULT_AVATAR) ? user()->avatar : 'uploads/' . user()->username . '/' . user()->avatar; ?>')">
													<div class="image-input-wrapper"></div>
													<label class="btn btn-xs btn-icon btn-circle btn-primary btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
														<i class="fa fa-pen icon-sm text-white"></i>
														<input type="file" name="avatar" accept=".jpg, .jpeg">
														<input type="hidden" name="avatar_remove">
													</label>
													<span class="btn btn-xs btn-icon btn-circle btn-warning btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar" id="cancel-avatar">
														<i class="ki ki-bold-close icon-xs text-white"></i>
													</span>
												</div>
											</div>
										</div>
										<?= $formAccount; ?>
										<div class="form-group row">
											<div class="col-3"></div>
											<div class="col-9">
												<?= form_button($btnSubmitAccount); ?>
												<?= form_button($btnResetAccount); ?>
											</div>
										</div>
										<?= form_close(); ?>
									</div>
								</div>
							</div>
							<div class="tab-pane px-7" id="kt_user_edit_tab_3" role="tabpanel">
								<div class="row">
									<div class="col-12 my-2">
										<?= form_open('', $form_password); ?>
										<?= $formPassword; ?>
										<div class="form-group row">
											<div class="col-3"></div>
											<div class="col-9">
												<?= form_button($btnSubmitPassword); ?>
												<?= form_button($btnResetPassword); ?>
											</div>
										</div>
										<?= form_close(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>