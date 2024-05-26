<?php $this->load->view('partner/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Set Fees</div>
										<div class="card-options ">
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">User Registration Fees</h4>
													</div>
													<div class="card-body">
														<form >
															<div class="">
															    <?php $sites = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row(); ?>
																<div class="form-group">
																	<label for="exampleInputEmail1">Master Distributor</label>
																	<input type="number" value="<?php echo $sites->md; ?>" class="form-control" id="md" placeholder="Master Distributor Charges">
																</div>
																<div class="form-group">
																	<label for="exampleInputEmail1">Distributor</label>
																	<input type="number" value="<?php echo $sites->dt; ?>" class="form-control" id="dt" placeholder="Distributor Charges">
																</div>
																<div class="form-group">
																	<label for="exampleInputEmail1">Retailler</label>
																	<input type="number" value="<?php echo $sites->rt; ?>" class="form-control" id="rt" placeholder="Retailler Charges">
																</div>
																
															</div>
															<button type="submit" class="btn btn-primary mt-3 mb-0" onclick="update();" id="sbt">Update</button>
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
    
    function update()
    {
        
        document.getElementById("sbt").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#sbt').html(dat);
        var md = $("#md").val();
        var dt = $("#dt").val();
        var rt = $("#rt").val();
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/updatecharge",
            method : "POST",
            data : {
                "md" : md,
                "dt" : dt,
                "rt" : rt,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("sbt").disabled = false;
                var dat = 'Update';
                $('#sbt').html(dat);
                if(data  == 1)
                {
                    alert("UPDATE SUCCESSFULL");
                    location.href="/partner/regfees";
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