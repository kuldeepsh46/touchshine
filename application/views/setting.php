<?php $this->load->view('header'); ?>

<!-- row opened -->
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Change Credentials</div>
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
														<h4 class="card-title">Change Password</h4>
													</div>
													<div class="card-body">
														<form >
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Old Password</label>
																	<input type="password" class="form-control" id="pass" placeholder="Enter Old Password">
																</div>
																<div class="form-group">
																	<label for="exampleInputEmail1">New Password</label>
																	<input type="password" class="form-control" id="newpass" placeholder="Enter New Password">
																</div>
																<div class="form-group">
																	<label for="exampleInputEmail1">Confirm Password</label>
																	<input type="password" class="form-control" id="cpass" placeholder="Enter Confirm Password">
																</div>
																
															</div>
															<button class="btn btn-primary mt-3 mb-0" onclick="password();" id="psbtn">Update Password</button>
														</form>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Change PIN</h4>
													</div>
													<div class="card-body">
														
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Old PIN</label>
																	<input type="number" class="form-control" id="opin" placeholder="Enter Old PIN">
																</div>
																<div class="form-group">
																	<label for="exampleInputEmail1">New Password</label>
																	<input type="number" class="form-control" id="newpin" placeholder="Enter New PIN">
																</div>
																<div class="form-group">
																	<label for="exampleInputEmail1">Confirm Password</label>
																	<input type="number" class="form-control" id="cpin" placeholder="Enter Confirm PIN">
																</div>
																
															</div>
															<button class="btn btn-primary mt-3 mb-0" onclick="changepin();" id="pibtn">Update PIN</button>
														
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
    function password()
    {
        document.getElementById("psbtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#psbtn').html(dat);
        var auth = $("#auth").val();
        var pass = $("#pass").val();
        var newpass = $("#newpass").val();
        var cpass = $("#cpass").val();
        $.ajax({
            url : "/main/changepass",
            method : "POST",
            data : {
                "auth" : auth,
                "pass" : pass,
                "newpass" : newpass,
                "cpass" : cpass
            },
            success:function(data,status)
            {
                document.getElementById("psbtn").disabled = false;
                var dat = 'Update Password';
                $('#psbtn').html(dat);
                if(data  == 1)
                {
                    alert("PASSWORD UPDATE SUCCESSFULL");
                    location.href="/main/setting";
                }
                if(data  != 1)
                {
                    alert(data);
                    document.getElementById("psbtn").disabled = false;
                    var dat = 'Update Password';
                }
            }
        });
    }
    function changepin()
    {
        document.getElementById("pibtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#pibtn').html(dat);
        var auth = $("#auth").val();
        var pass = $("#opin").val();
        var newpass = $("#newpin").val();
        var cpass = $("#cpin").val();
        $.ajax({
            url : "/main/changepin",
            method : "POST",
            data : {
                "auth" : auth,
                "pass" : pass,
                "newpass" : newpass,
                "cpass" : cpass
            },
            success:function(data,status)
            {
                document.getElementById("pibtn").disabled = false;
                var dat = 'Update Password';
                $('#pibtn').html(dat);
                if(data  == 1)
                {
                    alert("PIN UPDATE SUCCESSFULL");
                    location.href="/main/setting";
                }
                if(data  != 1)
                {
                    alert(data);
                    document.getElementById("psbtn").disabled = false;
                    var dat = 'Update Password';
                }
            }
        });
    }
</script>


<?php $this->load->view('footer'); ?>