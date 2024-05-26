<?php $this->load->view('admin/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Whitelabel Registration</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											
											
											<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 mb-0">
													<div class="card-header">
														<h4 class="card-title">Fill Data</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal" action="/admin/registerr" method="POST" enctype="multipart/form-data">
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Company Name</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" name="name" placeholder="Company Name" required="">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Owner Name</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" name="ownername" placeholder="Owner Name" required="">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Email</label>
																<div class="col-md-9">
																	<input type="email" class="form-control" name="email" placeholder="Email" required="">
																</div>
															</div>
															<input type="hidden" name="auth" value="<?php echo $_SESSION['auth']; ?>">
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Mobile</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" name="mobile" placeholder="Mobile Number" required="">
																</div>
															</div>
															<?php $pk = $this->db->get_where('package',array('role' => '1'))->result(); ?>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Package</label>
																<div class="col-md-9">
																    <select class="form-control" name="package" required="">
																        <?php $ind = 1; ?>
																        <?php foreach($pk as $da) : ?>
																        <option value="<?php echo $da->id; ?>"><?php echo $da->name; ?></option>
																        <?php $ind++; ?>
																        <?php endforeach; ?>
																    </select>
																	
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Web</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" name="web" placeholder="example.com OR partner.example.com" required="">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Site Title</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" name="title" placeholder="Site Title" required="">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Contact Number</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" name="cnumber" placeholder="Contact Number" required="">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Contact Email</label>
																<div class="col-md-9">
																	<input type="email" class="form-control" name="cmail" placeholder="Contact Email" required="">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Logo</label>
																<div class="col-md-9">
																	<input type="file" class="form-control" name="logo" accept=".png" placeholder="Contact Email" required="">
																</div>
															</div>
															
															
															
															<div class="form-group mb-0 mt-3 row justify-content-end">
																<div class="col-md-9">
																	<button type="submit" class="btn btn-primary">Registration</button>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						
						
					
<?php $this->load->view('admin/footer'); ?>