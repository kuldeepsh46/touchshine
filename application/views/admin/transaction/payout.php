

						<!-- row opened -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">PAYOUT TRANSACTION</div>
										<div class="card-options">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">MEMBER ID</th>
														<th class="border-bottom-0">TXNID</th>
														<th class="border-bottom-0">ACCOUNT</th>
														<th class="border-bottom-0">IFSC</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">AMOUNT</th>
														<th class="border-bottom-0">STATUS</th>
														<th class="border-bottom-0">MESSAGE</th>
														<th class="border-bottom-0">RRN</th>
														<th class="border-bottom-0">Type</th>
														<th class="border-bottom-0">COMPANY</th>
														<th class="border-bottom-0">DATE</th>
													</tr>
												</thead>
												<?php  
												$data = $this->db->from("payouttxn")->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->username; ?></td>
														<td><?php echo $dat->txnid; ?></td>
														<td><?php echo $dat->account; ?></td>
														<td><?php echo $dat->ifsc; ?></td>
														<td><?php echo $dat->bname; ?></td>
														<td><?php echo $dat->amount; ?></td>
														<td><?php echo $dat->status; ?></td>
														<td><?php echo $dat->message; ?></td>
														<td><?php echo $dat->rrn; ?></td>
														<td><?php echo $dat->mode; ?></td>
														<td><?php echo $this->db->get_where('sites',array('id' => $dat->site))->row()->title; ?></td>
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
