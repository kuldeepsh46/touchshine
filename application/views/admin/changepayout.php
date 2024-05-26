<?php $this->load->view('admin/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Change Payout</div>
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
														<h4 class="card-title">Change Payout</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal" >
															<div class="form-group">
																<input type="text" class="form-control" value="<?php if($this->db->get_where('payoutmode',array('id' => '1'))->row()->value == 1){ echo "ICICI BANK"; }else{ echo "PAYTM BANK"; } ?>" disabled="">
															</div>
															<div class="form-group">
															    <select class="form-control" id="bank">
															        <option value="1">ICICI BANK</option>
															        <option value="2">PAYTM BANK</option>
															    </select>
																
															</div>
															
															<div class="form-group mb-0 mt-3 justify-content-end">
																<div>
																	<button type="submit" class="btn btn-primary" onclick="change();" id="chb">Change Payout</button>
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
    
    function change()
    {
        
document.getElementById("chb").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#chb').html(dat);
        var bank = $("#bank").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/dochangepayout",
            method : "POST",
            data : {
                "bank" : bank,
                "auth" : auth
            },
            success:function(data,status)
            {
                
                
document.getElementById("chb").disabled = false;
var dat = 'Change Payout';
$('#chb').html(dat);
                if(data  == 1)
                {
                    alert("CHANGED SUCCESSFULL");
                    location.href="/admin/changepayout";
                    
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