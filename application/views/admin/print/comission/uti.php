
	<h5 class="card-title">UTI COPON COST</h5>
								
								<hr class="my-2">
								<form action="/comission/uti" method="POST">
								    <input type="hidden" name="auth" value="<?php echo $auth; ?>">
								    <input type="hidden" name="package" value="<?php echo $pk; ?>">
								<div class="table-responsive">
									<table class="table table-bordered mg-b-0 text-md-nowrap">
										<thead>
											<tr>
												
											
												<th>AMOUNT</th>
											
											</tr>
										</thead>
										<tbody>
										    
										   
										    
										    
										    <?php
										    
										    $cdata = $this->db->get_where('coponcharge',array('package' => $pk))->row();
										    
										    ?>
										    
										    
										    
											<tr>
												<td><input class="form-control" type="text" name="amount" placeholder="AMOUNT"  value="<?php echo $cdata->amount; ?>"></td>
											
												
												
												
												
											</tr>
											
										
										 
											
										</tbody>
									</table>
								</div>
								
								<button type="submit" class="btn btn-primary float-right mr-3 mt-3">Save Changes</button>
								</form>
								
								
								