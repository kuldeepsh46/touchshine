<?php $this->load->view('partner/header'); ?>
<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Package</div>
										<div class="card-options ">
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0">
													<div class="card-header">
														<h4 class="card-title">Create Package</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal" >
															<div class="form-group">
															    <select class="form-control" id="pkg">
															        <option value="2">State Head</option>
															        <option value="3">Master Distributor</option>
															        <option value="4">Distributor</option>
															        <option value="5">Retailer</option>
															    </select>
																
															</div>
															<div class="form-group">
																<input type="text" class="form-control" id="name" placeholder="Package Name">
															</div>
															
															<div class="form-group mb-0 mt-3 justify-content-end">
																<div>
																	<button type="submit" class="btn btn-primary" onclick="create();" id="pbtn">Create Package</button>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0">
													<div class="card-header">
														<h4 class="card-title">LIST PACKAGE</h4>
													</div>
													<div class="card-body">
														<table class="table">
														    
														    <tr>
														        <th>Sr. No.</th>
														        <th>Package Name</th>
														    </tr>
														    <?php
														    $domain = $_SESSION['rid'];
	                                                        $site = $this->db->get_where('sites',array('rid' => $domain))->row()->id;
														    $pa = $this->db->get_where('package',array('site' => $site))->result(); ?>
														    <?php $ind = 1; ?>
														    <?php foreach($pa as $data) :?>
														    <tr>
														        <td><?php echo $ind; ?></td>
														        <td><?php echo $data->name; ?></td>
														    </tr>
														    <?php $ind++; ?>
														    <?php endforeach; ?>
														</table>
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
    function create()
    {
        
document.getElementById("pbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#pbtn').html(dat);
        var name = $("#name").val();
        var auth = $("#auth").val();
        var pkg = $("#pkg").val();
        
        $.ajax({
            url : "/partner/createpackage",
            method : "POST",
            data : {
                "name" : name,
                "auth" : auth,
                "pkg" : pkg
            },
            success:function(data,status)
            {
                
                
document.getElementById("pbtn").disabled = false;
var dat = 'Create Package';
$('#pbtn').html(dat);
                if(data  == 1)
                {
                    alert("PACKAGE CREATE SUCCESSFULL");
                    location.href="/partner/package";
                    
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