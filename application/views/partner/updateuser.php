<?php $this->load->view('partner/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Upgrade Member</div>
										<div class="card-options ">
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Upgrade Member</h4>
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
						
						<div id="addac" class="modal fade" role="dialog">
        <div class="modal-dialog" id="addact">
            
            
            
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
                      url : "/partner/getupdata",
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
        var role = $("#role").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/partner/upgradenewuser",
            method : "POST",
            data : {
                "user" : user,
                "role" : role,
                "auth" : auth
            },
            success:function(data,status)
            {
                $('#mbtn').html(dat);
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                    document.getElementById("mbtn").disabled = false;
                    $('#mbtn').html("Upgrade User");
                }else{
                    
                    $("#addac").modal("show");
                    $("#addact").html(data);
                    document.getElementById("mbtn").disabled = false;
                    $('#mbtn').html("Upgrade User");
                }
                
            }
            
            
        });
        
        
    }
    
    function verify()
   {
       
       
       document.getElementById("regverify").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#regverify').html(dat);
  var role = $("#role").val();
  var user = $("#user").val();
  var auth = $("#auth").val();
  var pkg = $("#pkg").val();
  $.ajax({

          url : "/partner/newtoupgrade",
          method : "POST",
          data : {
               
               "auth" : auth,
               "role" : role,
               "user" : user,
               "pkg" : pkg

          },
          success:function(data,status)
          {
              document.getElementById("regverify").disabled = true;
                var dat = 'Verify';
                $('#regverify').html(dat);
                if(data  == 1)
                {
                    alert("USER UPGRADE SUCCESSFULL");
                    location.href="/partner/upgrade";
                    
                }
                
                
                if(data  != 1)
                {
                    alert(data);
                    document.getElementById("regverify").disabled = false;
                    $('#regverify').html("Verify");
                    
                    
                }

          }

     });

   }

    
    
</script>						
						
<?php $this->load->view('partner/footer'); ?>