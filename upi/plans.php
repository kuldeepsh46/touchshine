<?php
require_once('layouts/header.php');

$account = json_decode($userdata['settle_account']);
if(isset($_GET['paystatus'])){
if($_GET['paystatus']=='success'){
    echo '<script>swal("Success!", "Plan Activated Successfully!", "success");</script>';
}else{
    echo '<script>swal("Alert!", "Payment failed!", "error");</script>';
}
}
if(isset($_POST['trial']) && $_POST['trial'] =='free'){
    	$start_date = date('d-m-Y H:i:s');
		$exp_date = date('d-m-Y H:i:s', strtotime($start_date. ' + 3 days'));
		if($userdata['trial_done']=='0'){
		    $usql = sql_query("UPDATE `tb_partner` SET start_date='$start_date', expire_date='$exp_date', trial_done='1'  WHERE id='".$userdata['id']."'");
		    if($usql){
		         echo '<script>swal("Success!", "Trial Activated Successfully!", "success");</script>';
		    }else{
		        echo '<script>swal("Alert!", "Update Error!", "error");</script>';
		    }
		}else{
		    echo '<script>swal("Alert!", "Already Trial taken active genuine Plan!", "error");</script>';
		}
}
if(isset($_POST['plan']) && $_POST['plan'] =='basic'){
       // get payment data from db
        
        $activeKeyData = ['key'=>'d9fsdfsdfe','secret'=>'sfdsdfds','upiuid'=>'sdfdsfdsffsd@paytm'];
		$keyId = $activeKeyData['key'];
		$keySecret = $activeKeyData['secret'];
		$upiuid = $activeKeyData['upiuid'];
		$request_id = rand(1111,9999).time();
		$callback_url = "https://touchshine.in/activePlan.php";
		sql_query("UPDATE  `tb_partner` SET plan_txn_id='$request_id' WHERE id='".$userdata['id']."'");
		$amount = 199;

        $client_name = $userdata['name'];
		$client_email = $userdata['email'];
		$client_mobile = $userdata['mobile'];

        $paramList["upiuid"] = $upiuid;
        $paramList["token"] = $keyId;
        $paramList["orderId"] = $request_id;
        $paramList["txnAmount"] = $amount;
        $paramList["txnNote"] = "Payment received from ".$client_name;
        $paramList["cust_Mobile"] = $client_mobile;
        $paramList["cust_Email"] = $client_email;
        $paramList["callback_url"] = $callback_url;
        require_once('system/checksum.php');
        $checkSum = AhkWebCheckSum::generateSignature($paramList,$keySecret);
        $paramList['checksum']=$checkSum;
        
        if(isset($paramList['checksum'])){
                echo '<html>
                <head>
                <title>Gateway Check Out Page</title>
                </head>
                <body>
                	<center><h1>Please do not refresh this page...</h1></center>
                		<form method="post" action="https://upifast.in/order/paytm" name="f1">
                		<table border="1">
                			<tbody>';
                			foreach($paramList as $name => $value) {
                				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
                			}
                echo '</tbody>
                    </table>
                		<script type="text/javascript">
                			 document.f1.submit();
                		</script>
                	</form>
                </body>
                </html>';
           
        }else{
            echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
            redirect('','1500');
        }
}
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
<?php
if(isset($_POST['upiupdate']) && 
!empty($_POST['upi_id']) && 
!empty($_POST['upi_name']) && 
!empty($_POST['ifsc']) ){
	
$upi_id = safe_str($_POST['upi_id']);
$upi_name = safe_str($_POST['upi_name']);
$ifsc = safe_str($_POST['ifsc']);
$allow = array("paytm", "sbi");

if(isUPI($upi_id,$allow)){
$upis = json_encode(array("upi_id"=>$upi_id, "upi_name"=>$upi_name, "ifsc"=>$ifsc));

if(sql_query("UPDATE `tb_partner` SET upis='".$upis."' WHERE id='".$userdata['id']."' ")){
echo '<script>swal("Successfully!", "UPI Details Updated!", "success");</script>';
redirect('','1500');		
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}else{
echo '<script>swal("Alert!", "UPI Address is not valid, currently support '.implode(", ",$allow).'", "error");</script>';
redirect('','1500');
}

}
?>
<form action="" method="POST">
<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid card-nblue">
                <div class="row p-3">
        <div class="col-md-3 mb-3">
				<h4 class="text-white">Gateway Plans</h4><hr class="bg-white">
		    <div class="card card-custom">				
        	<div class="card-body row">
        	  <div class="col-md-6  mb-2"> 
        	 <!--  <a class="nav-link border d-flex flex-grow-1 rounded flex-column align-items-center">-->
        		<!--<img src="assets/img/bank_paytm.jpg" alt="" width="150"></a>   -->
        		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>Plan Price :</b> <span class="text-dark"> 199<br>
        		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>Plan Validity :</b> <span class="text-dark"> 30 Days<br>
        		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>Usage Limit :</b> <span class="text-dark"> Unlimited<br>
        		<input name="plan" hidden value="basic">
        			<button class="btn bg-mix text-white btn-sm">Active Now</button>
        			</span>
        		</span>
        	  </div>
            </div>
        </div>
        </div>
      </form>  
      
        <div class="col-md-3 mb-3">
				<h4 class="text-white">Free Trial</h4><hr class="bg-white">
		    <div class="card card-custom">				
        	<div class="card-body row">
        	  <div class="col-md-6  mb-2"> 
        	  <form action="" method="POST">
        	 <!--  <a class="nav-link border d-flex flex-grow-1 rounded flex-column align-items-center">-->
        		<!--<img src="assets/img/bank_paytm.jpg" alt="" width="150"></a>   -->
        		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>Plan Price :</b> <span class="text-dark"> <b>Free</b><br>
        		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>Plan Validity :</b> <span class="text-dark"> 3 Days<br>
        		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>Usage Limit :</b> <span class="text-dark"> Unlimited<br>
        	
        		<input name="trial" hidden value="free">
        			<button class="btn bg-mix text-white btn-sm">Active Trial</button>
        			  </span>
        		</span>
        	  </div>
            </div></form>
        </div>
        </div>
         
        
      </div>
    </div>
  </div>
</div>

      
      </div>
<?php
require_once('layouts/footer.php');
?>