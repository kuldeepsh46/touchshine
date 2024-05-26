	<?php
	$comdatas = $this->db->get_where('dmtcharge',array('package' => $pk))->result();
	
	
	
	?>
	
	<h5 class="card-title">DMT CHARGE</h5>
								
								<hr class="my-2">
									<form action="/comission/dmt" method="POST">
								    <input type="hidden" name="auth" value="<?php echo $auth; ?>">
								    <input type="hidden" name="package" value="<?php echo $pk; ?>">
								<div class="table-responsive">
									<table class="table table-bordered mg-b-0 text-md-nowrap">
										<thead>
											<tr>
												
												<th>FROM AMOUNT</th>
												<th>TO AMOUNT</th>
												<th>CHARGE</th>
												<th>IS PERCENT</th>
											</tr>
										</thead>
										<tbody>
										    <?php $index =1; ?>
										    <?php foreach($comdatas as $comdata) : ?>
										    
										   
										    
										    
										    
											<tr>
											<td><input class="form-control" type="number" name="froma<?php echo $index; ?>" placeholder="FROM AMOUNT" autocomplete="off" value="<?php echo $comdata->froma; ?>"></td>
											
											
											<td><input class="form-control" type="number" name="toa<?php echo $index; ?>" placeholder="TO AMOUNT" autocomplete="off" value="<?php echo $comdata->toa; ?>"></td>
											
											
												<td><input class="form-control" type="number" step="0.01" name="amount<?php echo $index; ?>" placeholder="COMISSION" autocomplete="off" value="<?php echo $comdata->amount; ?>"></td>
												
												<?php if($comdata->percent == 1) : ?>
												<td><input  class="form-control" type="checkbox" name="percent<?php echo $index; ?>" value="1" checked></td>
												<?php else : ?>
												<td><input  class="form-control" type="checkbox" name="percent<?php echo $index; ?>" value="1"></td>
												<?php endif; ?>
												
												
												
											</tr>
											
											<?php $index++; ?>
										 <?php endforeach; ?>
											
										</tbody>
									</table>
								</div>
								
								
								<button type="submit" class="btn btn-primary float-right mr-3 mt-3">Save Changes</button>
								</form>