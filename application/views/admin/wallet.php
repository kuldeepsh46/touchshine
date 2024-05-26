<?php $this->load->view('admin/header'); ?>
<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Deatils Display Data Table</div>
										<div class="card-options">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example-1" class="table table-striped table-bordered text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">Partner ID</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">OWNER NAME</th>
														<th class="border-bottom-0">MOBILE</th>
														<th class="border-bottom-0">Main Wallet</th>
														<th class="border-bottom-0">AEPS WALLET</th>
														<th class="border-bottom-0">COMPANY</th>
														<th class="border-bottom-0">Action</th>
													</tr>
												</thead>
												<?php  
												$data = $this->db->get('reseller')->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $dat->username; ?></td>
														<td><?php echo $dat->name; ?></td>
														<td><?php echo $dat->ownername; ?></td>
														<td><?php echo $dat->phone; ?></td>
														<td><?php echo $dat->main_wallet; ?></td>
														<td><?php echo $dat->wallet; ?></td>
														<td><?php echo $this->db->get_where('sites',array('rid' => $dat->id))->row()->title; ?></td>
														<td>
														<a href="<?php echo base_url()."admin/viewwallet?id=".$dat->id."&auth=".$_SESSION['auth']; ?>"><button class="btn btn-primary">View Wallet</button></a>
														<a href="<?php echo base_url()."admin/viewmainwallet?id=".$dat->id."&auth=".$_SESSION['auth']; ?>"><button class="btn btn-primary">View Main Wallet</button></a>
														
														</td>
													</tr>
													<?php $ind++; ?>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							</div>

<?php $this->load->view('admin/footer'); ?>