
	
	<h5 class="card-title">ICICI MINI STATEMENT COMISSION</h5>
								
								<hr class="my-2">
								<form action="/comission/nms" method="POST">
								    <input type="hidden" name="auth" value="<?php echo $auth; ?>">
								    <input type="hidden" name="package" value="<?php echo $pk; ?>">
								<div class="table-responsive">
									<table class="table table-bordered mg-b-0 text-md-nowrap">
										
										<tbody>
										  
										    
										   
										    
										    <?php
										    
						$amount = $this->db->get_where('mscom',array('package' => $pk,'type' => "2"))->row()->amount;				    
										    ?>
										
											
												<td><input class="form-control" type="number" step="0.01" name="amount" placeholder="COST" autocomplete="off" value="<?php echo $amount; ?>"></td>
												
												
												
											</tr>
											
										
											
										</tbody>
									</table>
								</div>
								
								<button type="submit" class="btn btn-primary-gradient float-right mr-3 mt-3">Save Changes</button>
								</form>
								
								
								