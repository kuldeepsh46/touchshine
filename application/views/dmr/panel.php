<?php $this->load->view('header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">DMT</div>
										
										<div class="card-options ">
										    
										    <button class="btn btn-danger" onclick="logout();" id="logbtn">Logout</button>
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0">
													<div class="card-header">
														<h4 class="card-title">Remitter Details</h4>
													</div>
													<div class="card-body">
														<table class="table">
														 <?php $data = $rdata; ?>  
                                                        <tbody>
                                                            <tr>
                                                              <th>Name</th>
                                                              <td><?php echo $data->name; ?></td>
                                                            </tr>
                                                            <tr>
                                                              <th>Phone No</th>
                                                              <td><?php echo $data->phone; ?></td>
                                                            </tr>
                                                            <tr>
                                                              <th>Limit</th>
                                                              <td><?php echo $data->rlimit; ?></td>
                                                            </tr>
                                                            <tr>
                                                              <th>Pin Code</th>
                                                              <td><?php echo $data->pin; ?></td>
                                                            </tr>
                                                            
														 </tbody>  
														</table>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Transaction</h4>
													</div>
													<div class="card-body">
														<form >
															<div class="">
															    <?php $data = $this->db->get_where('baccount',array('rid' => $_SESSION['rid']))->result(); ?>
																<div class="form-group">
																	<label for="exampleInputEmail1">Select Account</label>
																	
																	    <?php if($data == NULL){ ?>
																	     <div class="form-group">
        																	<label for="exampleInputPassword1">No Account Found</label>
    																    </div>
    																    <?php }else{ ?>
    																    <select class="form-control" id="account">
																	    <?php $ind = 1; ?>
																	    <?php foreach($data as $dat) : ?>
																	    <option value="<?php echo $dat->id; ?>"><?php echo $dat->name."  ".$dat->account; ?></option>
																	    <?php $ind++; ?>
																	    <?php endforeach; ?>
																	</select>
																	<?php } ?>
																</div>
																
																<div class="form-group">
																	<label for="exampleInputPassword1">Amount</label>
																	<input type="number" class="form-control" id="amount" placeholder="Amount">
																</div>
																
															</div>
															<button type="submit" class="btn btn-primary mt-3 mb-0" onclick="transfer();" id="trans">Transfer</button>
														</form>
													</div>
												</div>
											</div>
											<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 mb-0">
													<div class="card-header">
														<h4 class="card-title">Beneficiary Details</h4>&nbsp;&nbsp;&nbsp;&nbsp;
														<button class="card-title btn btn-primary" onclick="addacc();" id="addb">Add Account</button>
													</div>
													<div class="card-body">
														<table class="table">
														    <thead>
														        <tr>
    														        <th>#</th>
    														        <th>Name</th>
    														        <th>Account</th>
    														        <th>Ifsc</th>
    														        <th>Action</th>
    														        
														        </tr>
														    </thead>
														    <tbody>
														        <?php $data = $this->db->get_where('baccount',array('rid' => $_SESSION['rid']))->result(); ?>
														        <?php $ind = 1; ?>
														        <?php foreach($data as $dat) : ?>
														        <tr>
														            <td><?php echo $ind; ?></td>
														            <td><?php echo $dat->name; ?></td>
														            <td><?php echo $dat->account; ?></td>
														            <td><?php echo $dat->ifsc; ?></td>
														            
														            <td><button class="btn btn-danger" onclick="dltban('<?php echo $dat->id; ?>');" id="dlbtn<?php echo $dat->id; ?>">Delete</button></td>
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
        
    
        
        
        
        <div id="addac" class="modal fade" role="dialog">
        <div class="modal-dialog" id="addact">
            
            
            
        </div>
        </div>
        
						
						
						<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
<script>
    
    function addacc()
    {
        
        document.getElementById("addb").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#addb').html(dat);
        var auth = $("#auth").val();
        $.ajax({
            
            url : "/dmr/addaccount",
            method : "POST",
            data : {
                
                "auth" : auth
                
            },
            success:function(data,status)
            {
                $('#addb').html(dat);
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                    document.getElementById("addb").disabled = false;
                    $('#addb').html("Add Account");
                }else{
                    
                    $("#addac").modal("show");
                    $("#addact").html(data);
                    document.getElementById("addb").disabled = false;
                    $('#addb').html("Add Account");
                }
            }
            
            
            
        });
        
        
        
    }

    function accbtn()
   {
       
       
       document.getElementById("addaccount").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#addaccount').html(dat);

  var baaccount = $("#baaccount").val();
  var ifsc = $("#ifsc").val();
  var name = $("#name").val();
  $.ajax({

          url : "/dmr/verifyacc",
          method : "POST",
          data : {
               
               "baaccount" : baaccount,
               "name" : name,
               "ifsc" : ifsc

          },
          success:function(data,status)
          {
              document.getElementById("addaccount").disabled = true;
                var dat = 'Add Account';
                $('#addaccount').html(dat);
                if(data  == 1)
                {
                    alert("Account Successfull Added");
                    location.href="/dmr/panel";
                    
                }
                
                
                if(data  != 1)
                {
                    alert(data);
                    document.getElementById("addaccount").disabled = false;
                    $('#addaccount').html("Add Account");
                    
                    
                }

          }

     });

   }
      function dltban(bid)
   {
  var auth = $("#auth").val();

  $.ajax({

          url : "/dmr/delacc",
          method : "POST",
          data : {
               
               "auth" : auth,
               "bid" : bid

          },
          success:function(data,status)
          {
                if(data  == 1)
                {
                    alert("Account Successfull Deleted");
                    location.href="/dmr/panel";
                    
                }
                
                
                if(data  != 1)
                {
                    alert(data);
                    
                    
                    
                }

          }

     });

   }
   
   
    function logout()
    {
        
document.getElementById("logbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#logbtn').html(dat);
        var auth = $("#auth").val();
        $.ajax({
            url : "/dmr/logout",
            method : "POST",
            data : {
                "auth" : auth
            },
            success:function(data,status)
            {
                
                
document.getElementById("logbtn").disabled = false;
var dat = 'dorecharge';
$('#logbtn').html(dat);
                if(data  == 1)
                {
                    alert("LOGOUT SUCCESSFULL");
                    location.href="/dmr";
                    
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

          url : "/dmr/txn",
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
                    document.getElementById("regverify").disabled = false;
                    $('#regverify').html("Verify");
                }else{
                    alert(obj['msg']);
                    $('#info').modal('hide');
                    document.getElementById("regverify").disabled = false;
                    $('#regverify').html("Verify");
                }
                
                
                // if(obj['status']  != 'success')
                // {
                //     alert(data);
                //     document.getElementById("regverify").disabled = false;
                //     $('#regverify').html("Verify");
                    
                    
                // }

          }

     });

   }


    function transfer()
    {
        
        document.getElementById("trans").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#trans').html(dat);
        var amount = $("#amount").val();
        var account = $("#account").val();
        var auth = $("#auth").val();
        $.ajax({
            
            url : "/dmr/send_otp",
            method : "POST",
            data : {
                
                "auth" : auth,
                "amount" : amount,
                "account" : account
                
            },
            success:function(data,status)
            {
                $('#trans').html(dat);
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                    document.getElementById("trans").disabled = false;
                    $('#trans').html("Transfer");
                    
                }else{
                    if(data  == 2)
                    {
                        alert("PLEASE FILL ALL DATA");
                        document.getElementById("trans").disabled = false;
                        $('#trans').html("Transfer");
                        
                    }else{
                        if(data  == 3)
                            {
                                alert("INVALID AMOUNT");
                                document.getElementById("trans").disabled = false;
                                $('#trans').html("Transfer");
                                
                            }else{
                                if(data  == 4)
                                    {
                                        alert("INSUFFICIENT FUND");
                                        document.getElementById("trans").disabled = false;
                                        $('#trans').html("Transfer");
                                        
                                    }else{
                                        if(data  == 6)
                                            {
                                                alert("LIMIT ERROR");
                                                document.getElementById("trans").disabled = false;
                                                $('#trans').html("Transfer");
                                                
                                            }else{
                                                $("#info").modal("show");
                                                $("#infocont").html(data);
                                                document.getElementById("trans").disabled = false;
                                                $('#trans').html("Transfer");
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