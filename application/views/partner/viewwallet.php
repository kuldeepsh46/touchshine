

						<!-- row opened -->
						<div class="row">
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">Sn</th>
														<th class="border-bottom-0">USERNAME</th>
														<th class="border-bottom-0">TYPE</th>
														<th class="border-bottom-0">TXN ID</th>
														<th class="border-bottom-0">CREDIT</th>
														<th class="border-bottom-0">DEBIT</th>
														<th class="border-bottom-0">CLOSING</th>
														<th class="border-bottom-0">Date</th>
													</tr>
												</thead>
												<?php 
												$uid = $_SESSION['uid'];
												$data = $this->db->from("wallet")->where('uid',$id)->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->username; ?></td>
														<td><?php echo $dat->type; ?></td>
														<td><?php echo $dat->txnid; ?></td>
														<?php if($dat->txntype == "DEBIT"){ ?>
														<td><span style="color: green;">0</span></td>
														<td><span style="color: red;"><?php echo $dat->amount; ?></span></td>
														<?php }else{ ?>
														<td><span style="color: green;"><?php echo $dat->amount; ?></span></td>
														<td><span style="color: red;">0</span></td>
														<?php } ?>
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
						<!-- row closed -->






