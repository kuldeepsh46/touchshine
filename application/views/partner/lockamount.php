<?php $this->load->view('partner/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Lock Amount</div>
										<div class="card-options ">
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Lock Wallet</h4>
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
    																    <option value="<?php echo $dat->id; ?>"> <?php echo $dat->name; ?> / <?php echo $dat->username; ?> / <?php echo $dat->phone; ?></option>
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
                      url : "/partner/getwdata",
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
			
				function transfer()
    {
        
document.getElementById("tbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#tbtn').html(dat);
        var user = $("#user").val();
        var amount = $("#amount").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/partner/unlockamountd",
            method : "POST",
            data : {
                "user" : user,
                "amount" : amount,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("tbtn").disabled = false;
                var dat = 'Unlock Amount';
                $('#tbtn').html(dat);
                if(data  == 1)
                {
                    alert("AMOUNT UNLOCK SUCCESSFULL");
                    location.href="/partner/lockamount";
                }
                if(data  != 1)
                {
                    alert(data);
                    
                }
                
            }
            
            
        });
        
        
    }
			
			function move()
    {
        
document.getElementById("mbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#mbtn').html(dat);
        var user = $("#user").val();
        var amount = $("#amount").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/partner/lockamountd",
            method : "POST",
            data : {
                "user" : user,
                "amount" : amount,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("mbtn").disabled = false;
                var dat = 'Lock Amount';
                $('#mbtn').html(dat);
                if(data  == 1)
                {
                    alert("AMOUNT LOCK SUCCESSFULL");
                    location.href="/partner/lockamount";
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