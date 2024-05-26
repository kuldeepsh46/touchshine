<?php $this->load->view('header'); ?>
<?php $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
$kyc = $this->db->get_where('kyc',array('uid' => $_SESSION['uid']))->row();
?>
<div class="row" id="user-profile">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<div class="wideget-user">
											<div class="row">
												<div class="col-lg-12 col-xl-6 col-md-12">
													<div class="wideget-user-desc d-flex">
														<div class="wideget-user-img">
															<img class="" src="<?php echo $user->profile; ?>" alt="img" height="150">
														</div>
														<div class="user-wrap mt-lg-0">
															<h4><?php echo $user->name; ?></h4>
															<h6 class="text-muted mb-3 font-weight-normal">Member Since: <?php echo $user->create_date; ?></h6>
															<a href="#" class="btn btn-primary mt-1 mb-1"><i class="fa fa-rss"></i> Follow</a>
															<a href="#" class="btn btn-secondary mt-1 mb-1"><i class="fa fa-envelope"></i> E-mail</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="border-top">
										<div class="wideget-user-tab p-4">
											<div class="tab-menu-heading">
												<div class="tabs-menu1">
													<ul class="nav">
														<li class=""><a href="#tab-51" class="active show" data-toggle="tab">Profile</a></li>
														<li><a href="#tab-61" data-toggle="tab" class="">Members</a></li>
														
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-body h-100">
										<div class="border-0">
											<div class="tab-content">
												<div class="tab-pane active show" id="tab-51">
													<div id="profile-log-switch">
														<div class="table-responsive mb-5">
															<table class="table row table-borderless w-100 m-0 border">
																<tbody class="col-lg-6 p-0">
																	<tr>
																		<td><strong>Full Name :</strong> <?php echo $user->name; ?></td>
																	</tr>
																	<tr>
																		<td><strong>Location :</strong> <?php echo $kyc->address; ?></td>
																	</tr>
																	<tr>
																		<td><strong>Languages :</strong> English, Hindi.</td>
																	</tr>
																	<tr>
																		<td><strong>PIN CODE :</strong> <?php echo $kyc->pincode; ?></td>
																	</tr>
																</tbody>
																<tbody class="col-lg-6 p-0">
																	<tr>
																		<td><strong>Occupation :</strong> <?php echo $this->db->get_where('role',array('id' => $user->role))->row()->name; ?></td>
																	</tr>
																	<tr>
																		<td><strong>Website :</strong> <?php echo base_url(); ?></td>
																	</tr>
																	<tr>
																		<td><strong>Email :</strong> <?php echo $user->email; ?></td>
																	</tr>
																	<tr>
																		<td><strong>Phone :</strong> <?php echo $user->phone; ?></td>
																	</tr>
																</tbody>
															</table>
														</div>
														<!--<div class="p-5 border">-->
														<!--	<div class="media-heading"> <h4><strong>About me</strong></h4> </div>-->
														<!--	<p class="description mb-5">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>-->
														<!--	<div class="media-heading mt-3"> <h4><strong>Biography</strong></h4> </div>-->
														<!--	<p class="mb-0">Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus</p>-->
														<!--</div>-->
													</div>
												</div>
												<div class="tab-pane" id="tab-61">
													<ul class="widget-users row">
													    <?php $data = $this->db->get_where('users',array('owner' => $_SESSION['uid']))->result(); ?>
													    <?php $ind = 1; ?>
													    <?php foreach($data as $dat) : ?>
														<li class="col-lg-4 col-xl-3 col-md-6 col-sm-12 col-12">
															<div class="card box-shadow-0">
																<div class="card-body text-center">
																	<span class="avatar avatar-xxl brround cover-image" data-image-src="<?php echo $dat->profile; ?>"></span>
																	<h4 class="h4 mb-0 mt-3"><?php echo $dat->name; ?></h4>
																	<p class="card-text"><?php echo $this->db->get_where('role',array('id' => $dat->role))->row()->name; ?></p>
																	<p class="card-text"><strong>Mobile: </strong><?php echo $dat->phone; ?></p>
																	<p class="card-text"><strong>Email: </strong><?php echo $dat->email; ?></p>
																	<p class="card-text"><strong>Wallet: </strong><?php echo $dat->wallet; ?></p>
																</div>
															</div>
														</li>
														<?php $ind++; ?>
														<?php endforeach; ?>
													</ul>
												</div>
												
											
											</div>
										</div>
									</div>
								</div>
							</div><!-- col end -->
						</div>

<?php $this->load->view('footer'); ?>