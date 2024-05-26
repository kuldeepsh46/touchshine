<?php $this->load->view('admin/header'); ?>
<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Package</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
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
																<input type="text" class="form-control" disabled="" value="Whitelabel">
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
														    <?php $pa = $this->db->get_where('package',array('role' => "1"))->result(); ?>
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
        
        $.ajax({
            url : "/admin/createpackage",
            method : "POST",
            data : {
                "name" : name,
                "auth" : auth
            },
            success:function(data,status)
            {
                
                
document.getElementById("pbtn").disabled = false;
var dat = 'Create Package';
$('#pbtn').html(dat);
                if(data  == 1)
                {
                    alert("PACKAGE CREATE SUCCESSFULL");
                    location.href="/admin/package";
                    
                }
                
                
                if(data  != 1)
                {
                    alert(data);
                    
                }
                
            }
            
            
        });
        
        
    }
</script>
<?php $this->load->view('admin/footer'); ?>