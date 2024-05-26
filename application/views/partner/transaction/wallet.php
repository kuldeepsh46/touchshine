
<!-- row opened -->
						<div class="row">

											<table id="example" class="table table-bordered key-buttons text-wrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">TYPE</th>
														<th class="border-bottom-0">TXN ID</th>
														
                                                        <th class="border-bottom-0">CREDIT</th>
														<th class="border-bottom-0">DEBIT</th>
														
														<th class="border-bottom-0">OPENING BAL</th>
														<th class="border-bottom-0">CLOSING BAL</th>
														<th class="border-bottom-0">DATE</th>
													</tr>
												</thead>
												<?php 
												
												$data = $this->db->from("rtransaction")->where("rid",$_SESSION['rid'])->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result();
												
                                                                                                ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) :
                                                        $txntype = $this->db->get_where('wallet', array('site' => $dat->rid,'txnid'=>$dat->txnid))->row()->txntype;
                                                    ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $dat->type; ?></td>
														<td><?php echo $dat->txnid; ?></td>
														<?php if($txntype == "DEBIT"){ ?>
														<td><span style="color: green;">0</span></td>
														<td><span style="color: red;"><?php echo $dat->amount; ?></span></td>
														<?php }else{ ?>
														<td><span style="color: green;"><?php echo $dat->amount; ?></span></td>
														<td><span style="color: red;">0</span></td>
														<?php } ?>
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


