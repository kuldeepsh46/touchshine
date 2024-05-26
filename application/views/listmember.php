<?php $this->load->view('header'); ?>



						<!-- row opened -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">User List</div>
										<div class="card-options">
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
													    <th class="border-bottom-0">#</th>
														<th class="border-bottom-0">User id</th>
														<th class="border-bottom-0">Name</th>
														<th class="border-bottom-0">Email</th>
														<th class="border-bottom-0">Mobile</th>
														<th class="border-bottom-0">User Type</th>
														<th class="border-bottom-0">Address</th>
													</tr>
												</thead>
												<?php $data = $this->db->get_where('users',array('owner' => $_SESSION['uid']))->result(); 
												$kyc = $this->db->get_where('kyc',array('uid' => $_SESSION['uid']))->row()->id;
												  ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
													    <td><?php echo $ind; ?></td>
														<td><?php echo $dat->username; ?></td>
														<td><?php echo $dat->name; ?></td>
														<td><?php echo $dat->email; ?></td>
														<td><?php echo $dat->phone; ?></td>
														<td><?php echo $this->db->get_where('role',array('id' => $dat->role))->row()->name; ?></td>
														<td><?php echo $kyc->address; ?></td>
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
						<!-- row closed -->






<?php $this->load->view('footer'); ?>