<?php $this->load->view('header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">DMT</div>
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
														<h4 class="card-title">Login</h4>
													</div>
													<div class="card-body">
														<form >
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Mobile Number</label>
																	<input type="number" class="form-control" id="mobile" placeholder="Mobile Number">
																</div>
																
																
															</div>
															<button type="submit" class="btn btn-primary mt-3 mb-0" onclick="login();" id="loginbtn">Login</button>
														</form>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Register</h4>
													</div>
													<div class="card-body">
														<form >
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Name</label>
																	<input type="text" class="form-control" id="name" placeholder="Name">
																</div>
																<div class="form-group">
																	<label for="exampleInputPassword1">Mobile Number</label>
																	<input type="number" class="form-control" id="rmobile" placeholder="Mobile Number">
																</div>
																<div class="form-group">
																	<label for="exampleInputPassword1">Pin Code</label>
																	<input type="number" class="form-control" id="pin" placeholder="Pin Code">
																</div>
															</div>
															<button type="submit" class="btn btn-primary mt-3 mb-0" onclick="register();" id="regbtn">Register</button>
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
    
    function login()
    {
        
document.getElementById("loginbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#loginbtn').html(dat);
        var mobile = $("#mobile").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/dmr/login",
            method : "POST",
            data : {
                "mobile" : mobile,
                "auth" : auth
            },
            success:function(data,status)
            {
                
                
document.getElementById("loginbtn").disabled = false;
var dat = 'Login';
$('#loginbtn').html(dat);
                if(data  == 1)
                {
                    alert("LOGIN SUCCESSFULL");
                    location.href="/dmr/panel";
                    
                }
                
                
                if(data  != 1)
                {
                    alert(data);
                    
                }
                
            }
            
            
        });
        
        
    }
    function register()
    {
        
document.getElementById("regbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#regbtn').html(dat);
        var rmobile = $("#rmobile").val();
        var name = $("#name").val();
        var pin = $("#pin").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/dmr/register",
            method : "POST",
            data : {
                "rmobile" : rmobile,
                "name" : name,
                "pin" : pin,
                "auth" : auth
            },
            success:function(data,status)
            {
                
                
document.getElementById("regbtn").disabled = false;
var dat = 'Register';
$('#regbtn').html(dat);
                if(data  == 1)
                {
                    alert("REGISTRATION SUCCESSFULL");
                    location.href="/dmr";
                }
                
                
                if(data  != 1)
                {
                    alert(data);
                    
                }
                
            }
            
            
        });
        
        
    }
    
</script>


















<?php $this->load->view('footer'); ?>