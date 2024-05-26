
					

						<!-- row opened -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">MEMBER ID</th>
														<th class="border-bottom-0">PSA ID</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">MOBILE</th>
														<th class="border-bottom-0">EMAIL</th>
														<th class="border-bottom-0">SHOP</th>
														<th class="border-bottom-0">LOCATION</th>
														
														<th class="border-bottom-0">PIN CODE</th>
														<th class="border-bottom-0">AADHAR</th>
														<th class="border-bottom-0">PAN</th>
														<th class="border-bottom-0">STATUS</th>
														<th class="border-bottom-0">DATE</th>
													</tr>
												</thead>
												<?php  
												$data = $data = $this->db->from("psa")->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->username; ?></td>
														<td><?php echo $dat->psaid; ?></td>
														<td><?php echo $dat->name; ?></td>
														<td><?php echo $dat->mobile; ?></td>
														<td><?php echo $dat->email; ?></td>
														<td><?php echo $dat->shop; ?></td>
														<td><?php echo $dat->location; ?></td>
														
														<td><?php echo $dat->pincode; ?></td>
														<td><?php echo $dat->adhaar; ?></td>
														<td><?php echo $dat->pan; ?></td>
														<td><?php echo $dat->status; ?></td>
														<td><?php echo $dat->date; ?></td>
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
