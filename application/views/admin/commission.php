<?php $this->load->view('admin/header'); ?>
<?php $pkss = $this->db->get_where('package',array('role' => '1'))->result(); ?>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Update Commission</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											
											
											<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 mb-0">
													<div class="card-header">
														<h4 class="card-title">Commission And Charges</h4>
													</div>
													<div class="card-body">
														
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Service</label>
																<div class="col-md-9">
																    <select class="form-control" id="service" onchange="change();">
																        <option value="1">RECHARGE Commission</option>
																		<option value="14">RECHARGE Commission Lapu</option>
                                                                         <option value="2">DMT Charge</option>
                                                                         <option value="3">ICICI CASH WITHDRAWAL</option>
                                                                         <option value="4">ICICI CASH DEPOSIT</option>
                                                                         <option value="5">ICICI AADHARPAY</option>
                                                                         <option value="6">MINI STATEMENT ICICI</option>
                                                                         <option value="7">CASH WITHDRWAL Commission</option>
                                                                         <option value="8">ADHAARPAY Charge</option>
                                                                         <option value="9">MINI STATEMENT Commission</option>
                                                                         <option value="10">UTI Charge</option>
                                                                         <option value="11">PAYOUT IMPS Charge</option>
                                                                         <option value="12">PAYOUT NEFT Charge</option>
                                                                         <option value="13">QUICK TRANSFER Charge</option>
																    </select>
																</div>
															</div>
														    <div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Package</label>
																<div class="col-md-9">
																    <select class="form-control" id="package" onchange="change();">
																        <?php $ind = 1; ?>
																        <?php  foreach ($pkss as $p) : ?>
																        <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
																        <?php $ind++; ?>
																        <?php endforeach; ?>
																    </select>
																</div>
															</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 mb-0">
													<div class="card-header">
														<h4 class="card-title">Commission And Charges</h4>
													</div>
													<div class="card-body">
														<div id="cont">
						      
							
								
                            						  </div>
													</div>
												</div>
											</div>
											
											
				
						
						
						
							<input type="hidden" id="auth" value="<?php  echo $auth; ?>">
<script>
    function change()
		{
		    
		    

            var pk = $("#package").val();
		    var auth = $("#auth").val();
		    var sv = $("#service").val();
		  
		      $.ajax({

          url : "/admin/loadcomission",
          method : "POST",
          data : {

               "sv" : sv,
               "pk" : pk,
               "auth" : auth

          },
          success:function(data,status)
          {
               $("#cont").html(data);

          }

          });
     
		}
		
		function getdata()
		{
		 change();   
		}
</script>

<?php $this->load->view('admin/footer'); ?>