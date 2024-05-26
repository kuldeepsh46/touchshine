<?php $this->load->view('header'); ?>

<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
    <!-- row opened -->
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Quick Transfer</div>
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
														<h4 class="card-title">Send Money</h4>
													</div>
													<div class="card-body">
														<form class="form-horizontal" >
														    <div class="form-group">
														        <input type="text" class="form-control" placeholder="Name" id="name" autocomplete="off">
															</div>
															<div class="form-group">
														        <input type="text" class="form-control" placeholder="Account Number" id="account" autocomplete="off">
															</div>
															<div class="form-group">
														        <input type="text" class="form-control" placeholder="IFSC Code" id="ifsc" autocomplete="off">
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
		
<div class="modal" tabindex="-1" role="dialog" id="infor">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Transaction Receipt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="printThis">
            
      </div>
        

      </div>
      
    </div>
  </div>



<script>
    function makeprint()
{
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
    
</script>
						
		
		
		
						
<script>
    function verify()
   {
       
       
       document.getElementById("regverify").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#regverify').html(dat);

  var otp = $("#otp").val();
  var auth = $("#auth").val();
  $.ajax({

          url : "/qtransfer/txn",
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
                
                var obj = JSON.parse(data);
                if(obj['status']  == 'success')
                {
                    $('#info').modal('hide');
                    $("#infor").modal("show");
                    $('#printThis').html(obj['data']);
                }
                
                
                if(obj['status']  != 'success')
                {
                    alert(obj['msg']);
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
        var account = $("#account").val();
        var ifsc = $("#ifsc").val();
        var auth = $("#auth").val();
        var name = $("#name").val();
        $.ajax({
            
            url : "/qtransfer/send_otp",
            method : "POST",
            data : {
                
                "auth" : auth,
                "amount" : amount,
                "account" : account,
                "name" : name,
                "ifsc" : ifsc
                
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
