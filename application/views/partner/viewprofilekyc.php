<div class="row" id="user-profile">
							<div class="col-lg-12">
								<?php 
								$kyc = $this->db->get_where('kyc',array('id' => $kid))->row();
								$user = $this->db->get_where('users',array('id' => $kyc->uid))->row();
								?>
								<div class="card">
								    <textareame="" style="border:10px double yellowgreen;">
									<div class="card-body h-100">
										<div class="border-0">
											<div class="tab-content">
												<div class="tab-pane active show" id="tab-51">
													<div id="profile-log-switch">
														<div class="table-responsive mb-5">
															<table class="table row table-borderless w-100 m-0 border">
																<tbody class="col-lg-12 p-0">
																	<tr>
																	    <th><strong>Name As per User ID  :</strong></th>
																		<td> <?php echo $user->name; ?></td>
																	</tr>
																	<tr>
																	    <th><strong>Name As Per Aadhar:</strong></th>
																		<td> <?php echo $kyc->aadhaar_name; ?></td>
																	</tr>
																	<tr>
																	    <tr>
																	    <th><strong>Gender Type :</strong></th>
																		<td> <?php echo $kyc->gender; ?></td>
																	</tr>
																	<tr>
																	    <tr>
																	    <th><strong>Date Of Birth :</strong></th>
																		<td> <?php echo $kyc->dob; ?></td>
																	</tr>
																	<tr>
																	    <th><strong>Address :</strong> </th>
																		<td><?php echo $kyc->address; ?> , <?php echo $kyc->city; ?> , <?php echo $kyc->district; ?> ,<?php echo $kyc->state; ?></td>
																	</tr>
																	<tr>
																	    <th> <strong>Pin Code :</strong></th>
																		<td> <?php echo $kyc->pincode; ?></td>
																	</tr>
																	<tr>
																	    <th><strong>Shop Name :</strong></th>
																		<td> <?php echo $kyc->shopname; ?></td>
																	</tr>
																	<tr>
																	    <th><strong>Shop Address :</strong></th>
																		<td> <?php echo $kyc->shopaddress; ?></td>
																	</tr>
																	<tr>
																	    <th> <strong>Mobile No :</strong> </th>
																		<td><?php echo $user->phone; ?></td>
																	</tr>
																	<tr>
																	    <th><strong>Email Id :</strong></th>
																		<td><?php echo $user->email; ?></td>
																	</tr>
																	
																	<tr>
																	    <th> <strong>Validated Aadhar No. :</strong></th>
																		<td> <?php echo $kyc->aadhar_last; ?></td>
																	</tr>
																		<tr>
																	    <th> <strong>Aadhar No. :</strong></th>
																		<td> <?php echo $kyc->adhaar; ?></td>
																	</tr>
																	<tr>
																	    <th><strong>Pan No. :</strong></th>
																		<td> <?php echo $kyc->pan; ?></td>
																		<td><button class="btn btn-primary" onclick="verifypan('<?php echo $kyc->pan; ?>');" id="pnbtn">Verify Pan</button></td>
																		<td><div id="verifydetails"></div></td>
																	</tr>
																	<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
																	<script>
																	    function verifypan(pan)
                                                                            {
                                                                                document.getElementById("pnbtn").disabled = true;
                                                                                var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
                                                                                $('#pnbtn').html(dat);
                                                                                var auth = $("#auth").val();
                                                                                $.ajax({
                                                                                    url : "/partner/panverification",
                                                                                    method : "POST",
                                                                                    data : {
                                                                                        "auth" : auth,
                                                                                        "pan" : pan
                                                                                    },
                                                                                    success:function(data,status)
                                                                                    {
                                                                                        // document.getElementById("pnbtn").disabled = false;
                                                                                        var dat = 'VERIFIED';
                                                                                        $('#pnbtn').html(dat);
                                                                                        if(data  == 1)
                                                                                        {
                                                                                            alert("INVALID TOKEN");
                                                                                        }else{
                                                                                            $("#verifydetails").html(data);
                                                                                        }
                                                                                    }
                                                                                });
                                                                            }
																	</script>
																	<tr>
																	    <th> <strong>KYC Date & Time</strong></th>
																		<td> <?php echo $kyc->date; ?></td>
																	</tr>
																	<tr>
																	    <th><strong>User Photo As Per Aadhaar :</strong> </th>
																		<td><a class="btn btn-primary" href="<?php echo $kyc->photo; ?>" target="_blank">User Photo </a></td>
																	</tr>
																	<tr>
																	    <th><strong>Aadhaar Front Side :</strong> </th>
																		<td><a class="btn btn-primary" href="<?php echo $kyc->adhaarimg; ?>" target="_blank">Aadhaar Front Side</a></td>
																	</tr>
																	<tr>
																	    <th><strong>Aadhaar Back Side :</strong> </th>
																		<td><a class="btn btn-primary" href="<?php echo $kyc->adhaarback; ?>" target="_blank">Aadhaar Front Side</a></td>
																	</tr>
																	<tr>
																	    <th><strong>Pan Image :</strong> </th>
																		<td><a class="btn btn-primary" href="<?php echo $kyc->panimg; ?>" target="_blank">Pan Card</a></td>
																	</tr>
																	
																</tbody>
																
															</table>
														</div>
														<center>
														<div class="p-5 border">
															<div class="media-heading"> <h4><strong>Action</strong></h4> </div>
															<?php if($kyc->active == 1){ ?>
																	<button class="btn btn-primary">Already Approved</button>
																	<?php }else{ ?>
																	<button class="btn btn-primary" onclick="approvekyc('<?php echo $kyc->id; ?>');" id="apbtn">Approve</button> 
																	<button class="btn btn-danger" onclick="rejectkyc('<?php echo $kyc->id; ?>');" id="rjbtn">Reject</button>
																	<?php } ?>
														</div>
														</center>
													</div>
												</div>
												
												
												
											</div>
										</div>
									</div>
								</div>
							</div><!-- col end -->
						</div>
						
						<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
						
<script>
    function approvekyc(kid)
    {
        document.getElementById("apbtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#apbtn').html(dat);
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/kycapproverequest",
            method : "POST",
            data : {
                "kid" : kid,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("apbtn").disabled = false;
                var dat = 'Approve';
                $('#apbtn').html(dat);
                if(data  == 1)
                {
                    alert("KYC APPROVED SUCCESSFULL");
                    location.href="/partner/profilekyc";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }
    function rejectkyc(kid)
    {
        document.getElementById("rjbtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#rjbtn').html(dat);
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/kycrejectrequest",
            method : "POST",
            data : {
                "kid" : kid,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("rjbtn").disabled = false;
                var dat = 'Reject';
                $('#rjbtn').html(dat);
                if(data  == 1)
                {
                    alert("KYC REJECT SUCCESSFULL");
                    location.href="/partner/profilekyc";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }



</script>
						
						
						