<?php $this->load->view('header'); ?>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Fund Request</div>
									</div>
									<div class="card-body">
										<div class="row">
											
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Add Fund in Main Wallet</h4>
													</div>
													<div class="card-body">
														<form action="/main/addfundreq" method="POST" enctype="multipart/form-data">
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Select Bank</label>
																	<select class="form-control" name="bank">
																	    <?php $site = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->site;
																	    $bank = $this->db->get_where('bank',array('site' => $site))->result(); ?>
																	    <?php $ind = 1; ?>
																	    <?php foreach($bank as $data) : ?>
																	    <option value="<?php echo $data->id; ?>"><?php echo $data->name."  ".$data->account."  ".$data->ifsc; ?></option>
																	    <?php $ind++; ?>
																	    <?php endforeach; ?>
																	</select>
																</div>
																<div class="form-group">
																	<label for="exampleInputPassword1">Amount</label>
																	<input type="number" class="form-control" name="amount" placeholder="Amount">
																</div>
																<div class="form-group">
																	<label for="">RRN No</label>
																	<input type="text" class="form-control" name="rrn" placeholder="Bank Transaction Number">
																</div>
																	<div class="form-group">
																	<label for="">Transaction Date</label>
																	<input type="date" class="form-control" name="transaction_date" placeholder="Transaction Date">
																</div>
																<div class="form-group">
																	<label for="exampleInputPassword1">Proof</label>
																	<input type="file" class="form-control" name="image">
																</div>
															</div>
															
															<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" name="auth">
															<button type="submit" class="btn btn-primary mt-3 mb-0" name="submit">Submit</button>
														</form>
													</div>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>



<?php $this->load->view('footer'); ?>