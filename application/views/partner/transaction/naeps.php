

						<!-- row opened -->
						<div class="row">

										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">MEMBER ID</th>
														<th class="border-bottom-0">Agent id</th>
														<th class="border-bottom-0">TYPE</th>
														<th class="border-bottom-0">TXN ID</th>
														<th class="border-bottom-0">BANK TXN ID</th>
														<th class="border-bottom-0">AMOUNT</th>
														<th class="border-bottom-0">STATUS</th>
														<th class="border-bottom-0">MESSAGE</th>
														<th class="border-bottom-0">AADHAR</th>
														<th class="border-bottom-0">RRN</th>
														<th class="border-bottom-0">COMPANY</th>
														<th class="border-bottom-0">DATE</th>
													</tr>
												</thead>
												<?php  
												$site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
												$data = $this->db->from("naepstxn")->where("site",$site)->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->username; ?></td>
														<td><?php echo $dat->agentid; ?></td>
														<td><?php echo $dat->type; ?></td>
														<td><?php echo $dat->txnid; ?></td>
														<td><?php echo $dat->merchant_txn_no; ?></td>
														<td><?php echo $dat->amount; ?></td>
														<td><?php echo $dat->status; ?></td>
														<td><?php echo $dat->message; ?></td>
														<td><?php echo $dat->aadhar; ?></td>
														<td><?php echo $dat->rrn; ?></td>
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
