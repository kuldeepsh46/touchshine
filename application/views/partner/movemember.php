<?php $this->load->view('partner/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Update Owner</div>
										<div class="card-options ">
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Change Owner</h4>
													</div>
													<div class="card-body">
														<form >
															<div class="">
																<div class="form-group">
																    <label for="exampleInputEmail1">Select User</label>
																    <select class="form-control" id="user" onchange="getd();"> 
																        <?php $ind = 1; ?>
																        <?php $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id; ?>
    																    <?php $data = $this->db->get_where('users',array('site' => $site))->result(); ?>
    																    <?php foreach($data as $dat) : ?>
    																    <option value="<?php echo $dat->id; ?>"><?php echo $dat->username; ?></option>
    																    <?php $ind++; ?>
    																    <?php endforeach; ?>
																    </select>
																    
																</div>
																<div id="cont">
																    
																
    																
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
					<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">	
<script>
    
    
    function getd()
			{
			    $("#cont").html("Please Wait..");
			    var user = $("#user").val();
			     var auth = $("#auth").val();
			     $.ajax({
                      url : "/partner/getdata",
                      method : "POST",
                      data : {
                           "user" : user,
                           "auth" : auth
                        },
          success:function(data,status)
          {
           
              $("#cont").html(data);
          }
                        });
			        
			    
			    
			}
			
			
			
			function move()
    {
        
document.getElementById("mbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#mbtn').html(dat);
        var user = $("#user").val();
        var owner = $("#owner").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/partner/movemembertra",
            method : "POST",
            data : {
                "user" : user,
                "owner" : owner,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("mbtn").disabled = false;
                var dat = 'Move Member';
                $('#mbtn').html(dat);
                if(data  == 1)
                {
                    alert("MEMBER SUCCESSFULL TRANSFER");
                    location.href="/partner/movemember";
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