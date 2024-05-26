<?php $this->load->view('admin/header'); ?>
<?php
$datas = $this->db->order_by('id',"DESC")->get('indus_kyc')->result();

?>
<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Deatils Display Data Table</div>
										<div class="card-options">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example-1" class="table table-striped table-bordered text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">COMPANY</th>
														<th class="border-bottom-0">STATUS</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">Agent ID</th>
														<th class="border-bottom-0">MOBILE</th>
														<th class="border-bottom-0">EMAIL</th>
														<th class="border-bottom-0">Date Of Birth</th>
														<th class="border-bottom-0">CITY</th>
														<th class="border-bottom-0">ADDRESS</th>
														<th class="border-bottom-0">SHOP</th>
														<th class="border-bottom-0">Pin Code</th>
														<th class="border-bottom-0">PAN NO</th>
														<th class="border-bottom-0">AGENT ID</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
											
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($datas as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('sites',array('id' => $dat->site))->row()->title; ?></td>
														<td>
														    <?php if($dat->status == "PENDING"){ ?>
														    <div class="alert alert-danger" role="alert">
                                                                <?php echo $dat->status; ?>
                                                            </div>
                                                            <?php }else{ ?>
                                                                <div class="alert alert-success" role="alert">
                                                                    <?php echo $dat->status; ?>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        
														<td><?php echo $dat->first." ".$dat->last; ?></td>
														<td><?php echo $dat->agentId; ?></td>
														<td><?php echo $dat->mobile; ?></td>
														<td><?php echo $dat->email; ?></td>
														<td><?php echo $dat->state; ?></td>
														<td><?php echo $dat->city; ?></td>
														<td><?php echo $dat->address; ?></td>
														<td><?php echo $dat->shop; ?></td>
														<td><?php echo $dat->pincode; ?></td>
														<td><?php echo $dat->pan; ?></td>
														
														<?php if($dat->status != "APPROVED"){ ?>
                                                                                                                <td>
                                                                                                                    <input class="form-control form-control-sm col-md-4" type="text" id="aid__<?php echo $dat->id; ?>" onkeyup="updateaid(this.value)" onblur="updateaid(this.value)">
                                                                                                                </td>
														<td><button class="btn btn-primary" onclick="approve('<?php echo $dat->id; ?>');" id="apbtn">APPROVE</button>  <button class="btn btn-danger"onclick="reject('<?php echo $dat->id; ?>');" id="rjbtn">REJECT</button></td>
														<?php }else{ ?>
                                                                                                                <td><?php echo $dat->agentId; ?></td>
														<td><button class="btn btn-primary">Approved</button></td>
														<?php } ?>
													</tr>
													<?php $ind++; ?>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							</div>
							<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
							<input type="hidden" value="" id="agentID">
<script>
    function updateaid(vv){
       $("#agentID").val(vv); 
    }
    function approve(kid)
    {
        var auth = $("#auth").val();
        var agentId = $("#agentID").val();
        
        if(agentId!=""){
        $.ajax({
            url : "<?php echo site_url();?>/admin/approvenaeps",
            method : "POST",
            data : {
                "auth" : auth,
                "kid" : kid,
                "agentId" : agentId
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    $("#agentID").val("");
                    alert("KYC APPROVE SUCCESS");
                    location.href="<?php echo site_url();?>/admin/induskyc";
                }else{
                    $("#agentID").val("");
                    alert(data);
                }
            }
        });
        }else{
        alert("Please Enter Agent ID.");
        }
    }
    function reject(kid)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "<?php echo site_url();?>/admin/rejectnaeps",
            method : "POST",
            data : {
                "auth" : auth,
                "kid" : kid
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    alert("KYC REJECT SUCCESS");
                    location.href="<?php echo site_url();?>/admin/induskyc";
                }else{
                    alert(data);
                }
            }
        });
    }
</script>
<?php $this->load->view('admin/footer'); ?>