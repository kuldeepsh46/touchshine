

						<!-- row opened -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
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
														<th class="border-bottom-0">DATE</th>
													</tr>
												</thead>
												<?php  
												$data = $this->db->from("payouttxn")->where('uid',$_SESSION['uid'])->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->username; ?></td>
														<td><?php echo $dat->txnid; ?></td>
														<td><?php echo $dat->account; ?></td>
														<td><?php echo $dat->ifsc; ?></td>
														<td><?php echo $dat->name; ?></td>
														<td><?php echo $dat->amount; ?></td>
														<td><?php echo $dat->status; ?></td>
														<td><?php echo $dat->message; ?></td>
														<td><?php echo $dat->rrn; ?></td>
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
