<?php $this->load->view('header'); ?>

<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
    <!-- row opened -->
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title"> 
										    <div class="row" >
										        <div class="col-md-4">
										                <span>Payout</span>
										        </div>
										        <div class="col-md-6"></div>
										        <div class="col-md-2">
										            	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Bank Account</button>
										        </div>
										        
										    </div>
										
										
										
									
		                               </div>
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
														<h4 class="card-title">Transfer To Own Account</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal" >
														    <div class="form-group">
														        <select class="form-control" id="bid">
														            <?php $ind = 1; ?>
														            <?php $data = $this->db->get_where('payoutaccount',array('uid' => $_SESSION['uid'],'status' => "APPROVED"))->result(); ?>
														            <?php foreach($data as $dat) : ?>
														            <option value="<?php echo $dat->id; ?>"><?php echo $dat->name." (".$dat->account." & ".$dat->ifsc.")"; ?></option>
														            <?php $ind++; ?>
														            <?php endforeach; ?>
														        </select>
															</div>
															<div class="form-group">
														        <select class="form-control" id="mode">
														            <option value="IMPS">IMPS</option>
														            <option value="NEFT">NEFT</option>
														        </select>
															</div>
															
															<div class="form-group">
																<input type="number" class="form-control" placeholder="Amount" id="amount" autocomplete="off">
															</div>

															<div class="form-group mb-0 mt-3 justify-content-end">
																<div>
																	<button type="submit" class="btn btn-primary" id="pbtn" onclick="purchase();">Transfer</button>
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
		
	
		<div id="info" class="modal fade" role="dialog">
        <div class="modal-dialog" id="infocont">
            
            
            
        </div>
        </div>
		
			
			
			
			
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="<?php echo base_url(); ?>/payout/addaccount" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Enter Account Holder Name">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="account" placeholder="Enter Account Number">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="ifsc" placeholder="Enter IFSC Code">
        </div>
        <div class="form-group">
            <label>Bank Passbook</label>
            <input type="file" class="form-control" name="bank" accept="image/jpeg">
        </div>
      </div>
      <input type="hidden" name="auth" value="<?php echo $_SESSION['auth']; ?>">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit" name="submit">Add Account</button>
      </div>
      </form>
    </div>
  </div>
</div>
			
			
			
			
			
						
						
<script>


function addaccs()
    {
        document.getElementById("adac").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
        $('#adac').html(dat);
        var name = $("#name").val();
        var account = $("#account").val();
        var ifsc = $("#ifsc").val();
        var auth = $("#auth").val();
        $.ajax({
            url : "/payout/addaccount",
            method : "POST",
            data : {
                
                "auth" : auth,
                "name" : name,
                "account" : account,
                "ifsc" : ifsc
            },
            success:function(data,status)
            {
            document.getElementById("adac").disabled = false;
            var dat = 'Add Account';
            $('#adac').html(dat);
                if(data  == 1)
                {
                    alert("ACCOUNT ADD SUCCESSFULL");
                    location.href="/payout";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }








    function verify()
   {
       
       
       document.getElementById("regverify").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
        $('#regverify').html(dat);

  var otp = $("#otp").val();
  var auth = $("#auth").val();
  $.ajax({

          url : "/payout/txn",
          method : "POST",
          data : {
               
               "auth" : auth,
               "otp" : otp

          },
          success:function(data,status)
          {
              document.getElementById("regverify").disabled = true;
                var dat = 'Verify';
                $('#regverify').html(dat);
                if(data  == 1)
                {
                    alert("Payout Successfull Processed");
                    location.href="/payout";
                    
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


    function purchase()
    {
        
        document.getElementById("pbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#pbtn').html(dat);
        var amount = $("#amount").val();
        var mode = $("#mode").val();
        var bid = $("#bid").val();
        var auth = $("#auth").val();
        $.ajax({
            
            url : "/payout/send_otp",
            method : "POST",
            data : {
                
                "auth" : auth,
                "amount" : amount,
                "bid" : bid,
                "mode" : mode
                
            },
            success:function(data,status)
            {
                $('#pbtn').html(dat);
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                    document.getElementById("pbtn").disabled = false;
                    $('#pbtn').html("Transfer");
                    
                }else{
                    if(data  == 2)
                    {
                        alert("PLEASE FILL ALL DATA");
                        document.getElementById("pbtn").disabled = false;
                        $('#pbtn').html("Transfer");
                        
                    }else{
                        if(data  == 3)
                            {
                                alert("INVALID AMOUNT");
                                document.getElementById("pbtn").disabled = false;
                                $('#pbtn').html("Transfer");
                                
                            }else{
                                if(data  == 4)
                                    {
                                        alert("INSUFFICIENT FUND");
                                        document.getElementById("pbtn").disabled = false;
                                        $('#pbtn').html("Transfer");
                                        
                                    }else{
                                        if(data  == 6)
                                            {
                                                alert("LIMIT ERROR");
                                                document.getElementById("pbtn").disabled = false;
                                                $('#pbtn').html("Transfer");
                                                
                                            }else{
                                                $("#info").modal("show");
                                                $("#infocont").html(data);
                                                outprocess();
                                            }
                                    }
                            }
                    }
                }
                
                
                
                
            }
            
            
            
        });
        
        
        
    }
    
    
    
    function inprocess()
	{

document.getElementById("pbtn").disabled = true;
var data = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#').html(data);

	}

	function outprocess()
	{

document.getElementById("pbtn").disabled = false;
$('#pbtn').html("Transfer");


	}
</script>

<?php $this->load->view('footer'); ?>
