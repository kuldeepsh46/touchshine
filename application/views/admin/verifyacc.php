<?php $this->load->view('admin/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Verification</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Verify Account</h4>
													</div>
													<div class="card-body">
														<form >
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Account Number</label>
																	<input type="text" class="form-control" id="account" placeholder="Enter Account Number">
																</div>
																<div class="form-group">
																	<label for="exampleInputPassword1">Ifsc Code</label>
																	<input type="text" class="form-control" id="ifsc" placeholder="IFSC Code">
																</div>
															</div>
															<button type="button" class="btn btn-primary mt-3 mb-0" onclick="accountverify();" id="accbtn">Verify Account</button>
														</form>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Verify Pan</h4>
													</div>
													<div class="card-body">
														<form >
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Pan Number</label>
																	<input type="text" class="form-control" id="pan" placeholder="Enter Pan Number">
																</div>
																
															</div>
															<button type="button" class="btn btn-primary mt-3 mb-0"onclick="panverify();" id="panbtn">Verify Pan</button>
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
						
		<div id="info" class="modal fade" role="dialog">
        <div class="modal-dialog" id="infocont">
            
            
            
        </div>
        </div>
<script>
    function accountverify()
    {
        var auth = $("#auth").val();
        var account = $("#account").val();
        var ifsc = $("#ifsc").val();
        $.ajax({
            url : "/admin/accountverify",
            method : "POST",
            data : {
                "auth" : auth,
                "account" : account,
                "ifsc" : ifsc
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                }else{
                    if(data == 5){
                        alert("PLEASE SEND ALL DATA");
                    }else{
                        $("#info").modal("show");
                        $("#infocont").html(data);
                    }
                }
            }
        });
    }
    
    function panverify()
    {
        var auth = $("#auth").val();
        var pan = $("#pan").val();
        
        $.ajax({
            url : "/admin/panverify",
            method : "POST",
            data : {
                "auth" : auth,
                "pan" : pan
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                }else{
                    if(data == 5){
                        alert("PLEASE SEND ALL DATA");
                    }else{
                        $("#info").modal("show");
                        $("#infocont").html(data);
                    }
                }
            }
        });
    }
    
</script>

<?php $this->load->view('admin/footer'); ?>