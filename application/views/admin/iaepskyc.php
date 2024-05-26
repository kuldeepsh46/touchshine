<?php $this->load->view('admin/header'); ?>
<?php
$datas = $this->db->order_by('id',"DESC")->get('icicoutlet')->result();

?>
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
														<th class="border-bottom-0">COMPANY</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">MOBILE</th>

														<th class="border-bottom-0">AADHAR NO</th>
														<th class="border-bottom-0">PAN NO</th>
														<th class="border-bottom-0">DOCUMENT</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
												<?php  
												$data = $this->db->get_where('rtransaction',array('type' => 'CW'))->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($datas as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('sites',array('id' => $dat->site))->row()->title; ?></td>
														<td><?php echo $dat->first." ".$dat->last; ?></td>
														<td><?php echo $dat->mobile; ?></td>

														<td><?php echo $dat->adhaarno; ?></td>
														<td><?php echo $dat->pan; ?></td>
														<td><button class="btn btn-primary"><a target="_blank" style="color:white;" href="<?php echo $dat->adhaarurl; ?>">Aadhar Card</a></button></td>
														<?php if($dat->status != "1"){ ?>
														<td><button class="btn btn-primary"><a style="color:white;" href="<?php echo base_url()."/admin/iaepskycapprove?auth=".$_SESSION['auth']."&id=".$dat->id; ?>">Approve</a></button>  <button class="btn btn-danger"><a style="color:white;" href="<?php echo base_url()."/admin/iaepskycreject?auth=".$_SESSION['auth']."&id=".$dat->id; ?>">Reject</a></button></td>
														<?php }else{ ?>
														<td><button class="btn btn-primary">Approved</button></td>
														<?php } ?>
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