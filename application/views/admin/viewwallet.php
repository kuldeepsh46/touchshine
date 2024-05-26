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
														<th class="border-bottom-0">Narration</th>
														<th class="border-bottom-0">AMOUNT</th>
														<th class="border-bottom-0">OPENING</th>
														<th class="border-bottom-0">CLOSING</th>
														<th class="border-bottom-0">DATE</th>
													</tr>
												</thead>
												<?php  
												$data = $this->db->get_where('rtransaction',array('rid' => $id ))->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $dat->type."  Txnid: ".$dat->txnid; ?></td>
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

<?php $this->load->view('admin/footer'); ?>