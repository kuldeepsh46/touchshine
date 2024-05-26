<?php $this->load->view('admin/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Credit Fund</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0">
													<div class="card-header">
														<h4 class="card-title">Credit</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal" >
															<div class="form-group">
															    <?php $reseller = $this->db->get('reseller')->result(); ?>
															    <select class="form-control" id="user">
															        <?php $ind = "1"; ?>
															        <?php foreach($reseller as $dat) : ?>
															        <option value="<?php echo $dat->id; ?>"><?php echo $dat->username." ".$dat->name." Wallet: ".$dat->wallet; ?></option>
															        <?php  $ind++; ?>
															        <?php endforeach; ?>
															    </select>
															</div>
															<div class="form-group">
																<input type="number" class="form-control" id="amount" placeholder="Amount">
															</div>
															
															
															<div class="form-group mb-0 mt-3 justify-content-end">
																<div>
																	<button type="submit" class="btn btn-primary" onclick="credit();" id="crbtn">Credit Fund</button>
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
<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
<script>
    function credit()
    {
        
document.getElementById("crbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#crbtn').html(dat);
        var user = $("#user").val();
        var amount = $("#amount").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/creditfund",
            method : "POST",
            data : {
                "user" : user,
                "amount" : amount,
                "auth" : auth
            },
            success:function(data,status)
            {
                
                
document.getElementById("crbtn").disabled = false;
var dat = 'Credit Fund';
$('#crbtn').html(dat);
                if(data  == 1)
                {
                    alert("FUND CREDITED SUCCESSFULL");
                    location.href="/admin/credit";
                    
                }
                
                
                if(data  != 1)
                {
                    alert(data);
                    
                }
                
            }
            
            
        });
        
        
    }
    
</script>
<?php $this->load->view('admin/footer'); ?>