<?php $this->load->view('header'); ?>
<?php $uid = $_SESSION['uid']; ?>
<?php $pans = $this->db->get_where('psa',array('uid' => $uid))->num_rows(); ?>
<?php $user = $this->db->get_where('users',array('id' => $uid))->row(); ?>
<?php $kyc = $this->db->get_where('kyc',array('uid' => $uid))->row(); ?>
<?php if($pans <= 0) { ?>


<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">PSA REGISTRATION</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											
												<div class="card-body">
														<form class="form-horizontal" >
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Name</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="name" placeholder="Name" disabled value="<?php echo $user->name; ?>">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Mobile</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" id="mobile" placeholder="Mobile" disabled value="<?php echo $user->phone; ?>">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Email</label>
																<div class="col-md-9">
																	<input type="email" class="form-control" id="email" placeholder="Email" disabled value="<?php echo $user->email; ?>">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Shop</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="shop" placeholder="Shop" disabled value="<?php echo $kyc->shopname; ?>">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Aadhar</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" id="adhaar" placeholder="Aadhar" disabled value="<?php echo $kyc->adhaar; ?>">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">PAN</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="pan" placeholder="PAN" disabled value="<?php echo $kyc->pan; ?>">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">Address</label>
																<div class="col-md-9">
																	<input type="text" class="form-control" id="address" placeholder="Address" disabled value="<?php echo $kyc->address; ?>">
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">State</label>
																<div class="col-md-9">
																	
																	
																	<select id="state" class="form-control">
											                            <option value="">--Select State--</option>
                                                                        <option value="1">ANDAMAN AND NICOBAR ISLANDS</option>
                                                                        <option value="2">ANDHRA PRADESH</option>
                                                                        <option value="3">ARUNACHAL PRADESH</option>
                                                                        <option value="4">ASSAM</option>
                                                                        <option value="5">BIHAR</option>
                                                                        <option value="6">CHANDIGARH</option>
                                                                        <option value="33">CHHATTISGARH</option>
                                                                        <option value="7">DADRA AND NAGAR HAVELI</option>
                                                                        <option value="8">DAMAN AND DIU</option>
                                                                        <option value="9">DELHI</option>
                                                                        <option value="10">GOA</option>
                                                                        <option value="11">GUJARAT</option>
                                                                        <option value="12">HARYANA</option>
                                                                        <option value="13">HIMACHAL PRADESH</option>
                                                                        <option value="14">JAMMU AND KASHMIR</option>
                                                                        <option value="35">JHARKHAND</option>
                                                                        <option value="15">KARNATAKA</option>
                                                                        <option value="16">KERALA</option>
                                                                        <option value="17">LAKSHADWEEP</option>
                                                                        <option value="18">MADHYA PRADESH</option>
                                                                        <option value="19">MAHARASHTRA</option>
                                                                        <option value="20">MANIPUR</option>
                                                                        <option value="21">MEGHALAYA</option>
                                                                        <option value="22">MIZORAM</option>
                                                                        <option value="23">NAGALAND</option>
                                                                        <option value="24">ODISHA</option>
                                                                        <option value="99">OTHER</option>
                                                                        <option value="25">PONDICHERRY</option>
                                                                        <option value="26">PUNJAB</option>
                                                                        <option value="27">RAJASTHAN</option>
                                                                        <option value="28">SIKKIM</option>
                                                                        <option value="29">TAMILNADU</option>
                                                                        <option value="36">TELANGANA</option>
                                                                        <option value="30">TRIPURA</option>
                                                                        <option value="31">UTTAR PRADESH</option>
                                                                        <option value="34">UTTARAKHAND</option>
                                                                        <option value="32">WEST BENGAL</option>
                                                                    </select>
																	
																</div>
															</div>
															<div class="form-group row">
																<label for="inputName1" class="col-md-3 col-form-label">PIN</label>
																<div class="col-md-9">
																	<input type="number" class="form-control" id="pin" placeholder="PIN"  disabled value="<?php echo $kyc->pincode; ?>">
																</div>
															</div>
															
															
															<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
															
															<div class="form-group mb-0 mt-3 row justify-content-end">
																<div class="col-md-9">
																	<button type="submit" class="btn btn-primary" onclick="register();" id="rbtn">Submit Form</button>
																	
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
						<!-- row closed -->








<?php }else{ ?>
<?php $psastatus = $this->db->get_Where('psa',array('uid' => $uid))->row()->status; ?>
<?php if($psastatus == "APPROVED") {?>
    <input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
    <!-- row opened -->
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">PURCHASE COUPON</div>
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
														<h4 class="card-title">COUPON DETAILS</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal" >
															<div class="form-group">
																<input type="text" class="form-control" value="<?php echo $this->db->get_where('psa',array('uid' => $_SESSION['uid']))->row()->psaid; ?>" disabled="">
															</div>
															<div class="form-group">
																<input type="number" class="form-control" placeholder="Number Of Coupon" id="qty" autocomplete="off" oninput="check();">
															</div>
															<div class="form-group">
																<input type="text" class="form-control" id="cont" value="Charge: 100" disabled="">
															</div>
															
															<div class="form-group mb-0 mt-3 justify-content-end">
																<div>
																	<button type="submit" class="btn btn-primary" id="pbtn" onclick="purchase();">PURCHASE</button>
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
						<!-- row closed -->
    
    
    
    
<?php }else{ ?>
    
    
    <div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">VIEW DETAILS</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
										</div>
									</div>
									<?php $data = $this->db->get_where('psa',array('uid' => $_SESSION['uid']))->row(); ?>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-12 col-md-12">
												<form class="form-horizontal" >
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Status</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="PENDING" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">PSA ID</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->psaid; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Name</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->name; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Mobile</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->mobile; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Email</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->email; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Shop</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->shop; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Address</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->location; ?>" disabled="">
														</div>
													</div>
													<?php 
													$state = $data->state; 
													if($state == 1){
													    $statename = "ANDAMAN AND NICOBAR ISLANDS";
													}elseif($state == 2){
													    $statename = "ANDHRA PRADESH";
													}elseif($state == 3){
													    $statename = "ARUNACHAL PRADESH";
													}elseif($state == 4){
													    $statename = "ASSAM";
													}elseif($state == 5){
													    $statename = "BIHAR";
													}elseif($state == 6){
													    $statename = "CHANDIGARH";
													}elseif($state == 7){
													    $statename = "DADRA AND NAGAR HAVELI";
													}elseif($state == 8){
													    $statename = "DAMAN AND DIU";
													}elseif($state == 9){
													    $statename = "DELHI";
													}elseif($state == 10){
													    $statename = "GOA";
													}elseif($state == 11){
													    $statename = "GUJARAT";
													}elseif($state == 12){
													    $statename = "HARYANA";
													}elseif($state == 13){
													    $statename = "HIMACHAL PRADESH";
													}elseif($state == 14){
													    $statename = "JAMMU AND KASHMIR";
													}elseif($state == 15){
													    $statename = "KARNATAKA";
													}elseif($state == 16){
													    $statename = "KERALA";
													}elseif($state == 17){
													    $statename = "LAKSHADWEEP";
													}elseif($state == 18){
													    $statename = "MADHYA PRADESH";
													}elseif($state == 19){
													    $statename = "MAHARASHTRA";
													}elseif($state == 20){
													    $statename = "MANIPUR";
													}elseif($state == 21){
													    $statename = "MEGHALAYA";
													}elseif($state == 22){
													    $statename = "MIZORAM";
													}elseif($state == 23){
													    $statename = "NAGALAND";
													}elseif($state == 24){
													    $statename = "ODISHA";
													}elseif($state == 25){
													    $statename = "PONDICHERRY";
													}elseif($state == 26){
													    $statename = "PUNJAB";
													}elseif($state == 27){
													    $statename = "RAJASTHAN";
													}elseif($state == 28){
													    $statename = "SIKKIM";
													}elseif($state == 29){
													    $statename = "TAMILNADU";
													}elseif($state == 30){
													    $statename = "TRIPURA";
													}elseif($state == 31){
													    $statename = "UTTAR PRADESH";
													}elseif($state == 32){
													    $statename = "WEST BENGAL";
													}elseif($state == 33){
													    $statename = "CHHATTISGARH";
													}elseif($state == 34){
													    $statename = "UTTARAKHAND";
													}elseif($state == 35){
													    $statename = "JHARKHAND";
													}elseif($state == 36){
													    $statename = "TELANGANA";
													}elseif($state == 99){
													    $statename = "OTHER";
													}else{
													    $statename = "ERROR";
													}
													?>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">State</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $statename; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Pin Code</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->pincode; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Aadhar No.</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->adhaar; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Pan No.</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->pan; ?>" disabled="">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-md-3 col-form-label">Date</label>
														<div class="col-md-9">
															<input type="text" class="form-control" value="<?php echo $data->date; ?>" disabled="">
														</div>
													</div>

												</form>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- row closed -->
    
    
    
    
    
    
    
    
    
<?php } ?>
<?php } ?>


<script>
    
    function register()
    {
        
    document.getElementById("rbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#rbtn').html(dat);
            var name = $("#name").val();
            var mobile = $("#mobile").val();
            var email = $("#email").val();
            var shop = $("#shop").val();
            var adhaar = $("#adhaar").val();
            var pan = $("#pan").val();
            var address = $("#address").val();
            var state = $("#state").val();
            var pin = $("#pin").val();
             var auth = $("#auth").val();
            
            $.ajax({
                url : "/main/utipsa",
                method : "POST",
                data : {
                    "name" : name,
                    "mobile" : mobile,
                    "email" : email,
                    "shop" : shop,
                    "adhaar" : adhaar,
                    "pan" : pan,
                    "address" : address,
                    "state" : state,
                    "pin" : pin,
                    "auth" : auth
                    
                    
                },
                success:function(data,status)
                {
                    
                    
    document.getElementById("rbtn").disabled = false;
    var dat = 'Register';
    $('#rbtn').html(dat);
                    if(data  == 1)
                    {
                        alert("REGISTRATION SUCCESSFULL");
                        location.href="/main/pan";
                        
                    }
                    
                    
                    if(data  != 1)
                    {
                        alert(data);
                        
                    }
                    
                }
                
                
            });
        
        
    }
    
    
    function check()
    {
        var qty = $("#qty").val();
        var auth = $("#auth").val();
        $.ajax({
            
            url : "/main/utiparse",
            method : "POST",
            data : {
                
                "auth" : auth,
                "qty" : qty
                
            },
            success:function(data,status)
            {
                $("#cont").html(data);
                
            }
            
            
            
        });
        
    }
    function purchase()
    {
        
        document.getElementById("pbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#pbtn').html(dat);
        var qty = $("#qty").val();
        var auth = $("#auth").val();
        $.ajax({
            
            url : "/main/getpurchase",
            method : "POST",
            data : {
                
                "auth" : auth,
                "qty" : qty
                
            },
            success:function(data,status)
            {
                
                document.getElementById("pbtn").disabled = false;
var dat = 'Purchase';
$('#pbtn').html(dat);
               if(data == 1)
               {
                   alert("COPON PURCHASED SUCCESSFULLY");
                   location.href="/main/pan";
                   
               }
               
               if(data != 1)
               {
                   alert(data);
                   
               }
                
            }
            
            
            
        });
        
        
        
    }
    
</script>











<?php $this->load->view('footer'); ?>