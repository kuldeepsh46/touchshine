


<!-- row opened -->
						<div class="row">

										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">MEMBER ID</th>
														<th class="border-bottom-0">Name</th>
														<th class="border-bottom-0">TXN ID</th>
														<th class="border-bottom-0">AMOUNT</th>
														<th class="border-bottom-0">OPENING</th>
														<th class="border-bottom-0">CLOSING</th>
														<th class="border-bottom-0">DATE</th>
													</tr>
												</thead>
												<?php  $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
												$data = $this->db->get_where('transaction',array('type' => 'DEDUCT','site' => $site))->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->username; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->name; ?></td>
														<td><?php echo $dat->txnid; ?></td>
														<td><?php echo $dat->amount; ?></td>
														<td><?php echo $dat->opening; ?></td>
														<td><?php echo $dat->closing; ?></td>
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

