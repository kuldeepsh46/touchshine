	<?php
	$ops = $this->db->get('rechargev2op')->result();
	
	
	
	?>
	
	<h5 class="card-title">RECHARGE COMISSION</h5>
								
								<hr class="my-2">
								<form action="/partnercommission/recharge" method="POST">
								    <input type="hidden" name="auth" value="<?php echo $auth; ?>">
								    <input type="hidden" name="package" value="<?php echo $pk; ?>">
								<div class="table-responsive">
									<table class="table table-bordered mg-b-0 text-md-nowrap">
										<thead>
											<tr>
												
												<th>OPERATOR NAME</th>
												<th>COMISSION</th>
												<th>IS PERCENT</th>
											</tr>
										</thead>
										<tbody>
										    <?php $index = 1;?>
										    <?php foreach($ops as $op) : ?>
										    
										    
										    <?php
										    
										    $comdata = $this->db->get_where('comissionv2',array('package' => $pk,'operator' => $op->id))->row();
										    
										    ?>
										    
										    
										    
											<tr>
												<td><input class="form-control" type="text" name="name" placeholder="OPERATOR NAME" disabled="true" value="<?php echo $op->name; ?>"></td>
												<input type="hidden" name="op<?php echo $index; ?>" value="<?php echo $op->id; ?>">
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
								
								
								