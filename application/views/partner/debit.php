<?php $this->load->view('partner/header'); ?>
<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Debit Fund</div>
										<div class="card-options ">
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0">
													<div class="card-header">
														<h4 class="card-title">Debit Fund</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal" >
															<div class="form-group">
															    <select class="form-control" id="user">
															        <?php $ind = 1; ?>
															        <?php $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id; ?>
															        <?php $users = $this->db->get_where('users',array('site' => $site))->result(); ?>
															        <?php foreach($users as $dat) : ?>
    																<option value="<?php echo $dat->id; ?>"> <?php echo $dat->name; ?> / <?php echo $dat->username; ?> / <?php echo $dat->phone; ?> / <?php echo $dat->wallet; ?></option>
															        <?php $ind++; ?>
															        <?php endforeach; ?>
															    </select>
															</div>
															<div class="form-group">
																<input type="number" class="form-control" id="amount" min="1" placeholder="Enter Amount">
															</div>
															<div class="form-group">
																<input type="text" class="form-control" id="remark" minlength="1" maxlength="35" placeholder="Enter Remark">
															</div>
															
															<div class="form-group mb-0 mt-3 justify-content-end">
																<div>
																	<button type="button" class="btn btn-primary" onclick="debit();" id="crbtn">Debit</button>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
											
											
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
<script>
    function debit()
    {
        
    document.getElementById("crbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#crbtn').html(dat);
            var user = $("#user").val();
            var amount = $("#amount").val();
            var remark = $("#remark").val();
            var auth = $("#auth").val();
            
            $.ajax({
                url : "/partner/debitfund",
                method : "POST",
                data : {
                    "user" : user,
                    "amount" : amount,
                    "remark" : remark,
                    "auth" : auth
                },
                success:function(data,status)
                {
                    
                    
    document.getElementById("crbtn").disabled = false;
    var dat = 'Debit';
    $('#crbtn').html(dat);
                    if(data  == 1)
                    {
                        alert("FUND DEBIT SUCCESSFULL");
                        location.href="/partner/debit";
                        
                    }
                    
                    
                    if(data  != 1)
                    {
                        alert(data);
                        
                    }
                    
                }
                
                
            });
            
            
        }
</script>
<?php $this->load->view('partner/footer'); ?>