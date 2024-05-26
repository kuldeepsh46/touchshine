<?php $this->load->view('partner/header'); ?>

<div class="row">
							<div class="col-12">
											<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 mb-0">
													<div class="card-header">
														<h4 class="card-title">Add Member</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal">
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Name</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="name" placeholder="Name">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Mobile No</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="mobile" placeholder="Mobile Number">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Email</label>
																<div class="col-md-9">
																	<input type="email" class="form-control" id="email" placeholder="Email">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Role</label>
																<div class="col-md-9">
																	<select class="form-control" id="role" onchange="setpack();">
																	    <option value="2">State Head</option>
																	    <option value="3">Master Distributor</option>
																	    <option value="4">Distributor</option>
																	    <option value="5">Retailer</option>
																	</select>
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Package</label>
																<div class="col-md-9">
																	<select class="form-control" id="pkg">
																	    
																	</select>
																</div>
															</div>
															
															
															
															<div class="form-group mb-0 mt-3 row justify-content-end">
																<div class="col-md-9">
																	<button type="submit" class="btn btn-primary" onclick="register();" id="rgbtn">Register</button>
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



    function register()
    {
        
    document.getElementById("rgbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#rgbtn').html(dat);
            var name = $("#name").val();
            var mobile = $("#mobile").val();
            var email = $("#email").val();
            var role = $("#role").val();
            var pkg = $("#pkg").val();
            var auth = $("#auth").val();
            
            $.ajax({
                url : "/partner/memberreg",
                method : "POST",
                data : {
                    "name" : name,
                    "mobile" : mobile,
                    "email" : email,
                    "role" : role,
                    "pkg" : pkg,
                    "auth" : auth
                },
                success:function(data,status)
                {
                    
                    
    document.getElementById("rgbtn").disabled = false;
    var dat = 'Register';
    $('#rgbtn').html(dat);
                    if(data  == 1)
                    {
                        alert("REGISTRATION SUCCESSFULL");
                        location.href="/partner/registration";
                        
                    }
                    
                    
                    if(data  != 1)
                    {
                        alert(data);
                        
                    }
                    
                }
                
                
            });
        
        
    }
    
    
    
        function setpack()
			    {
			        var role = $("#role").val();
			        var auth = $("#auth").val();
			        
			         $.ajax({

          url : "/partner/setpack",
          method : "POST",
          data : {
               
               "auth" : auth,
               "role" : role

          },
          success:function(data,status)
          {
 
               $("#pkg").html(data);


          }

     });
			        
			        
			    }
			    
			   function getdata()
			    {
			        
			        setpack();
			    }


</script>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
$(document).bind("contextmenu",function(e){
  return false;
    });
</script>

<?php $this->load->view('partner/footer'); ?>