<?php
require_once('system/function.php');

// get payment data from db

$activeKeyData = ['key'=>'d9fe71-a2e52e','secret'=>'rDPgvngh','upiuid'=>'pafh@paytm'];
$keyId = $activeKeyData['key'];
$keySecret = $activeKeyData['secret'];

$status = $_POST['status'];
$message = $_POST['message'];
$hash = $_POST['hash'];
$checksum = $_POST['checksum'];

echo "<h4>Please do not reload, payment is processing.</h4>";

// Payment Status.
if($status=="SUCCESS"){
    $paramList = hash_decrypt($hash,$keySecret);
    require_once('system/checksum.php');
    $verifySignature = AhkWebCheckSum::verifySignature($paramList, $keySecret, $checksum);
    if($verifySignature){
        $array = json_decode($paramList,true); 
        // print_r($array);
        // save payment request data
		$payment_request_id = $array['txnId'];
		$request_id = $array['orderId'];
		$amount = $array['txnAmount'];
		$start_date = date('d-m-Y H:i:s');
		$ssql = sql_query("SELECT * FROM tb_partner WHERE plan_txn_id='$request_id' LIMIT 1 ");
		$sdata = mysqli_fetch_assoc($ssql);
		$exp_date = date('d-m-Y H:i:s', strtotime($sdata['expire_date']. ' + 30 days'));
		$usql = sql_query("UPDATE `tb_partner` SET start_date='$start_date', expire_date='$exp_date' WHERE plan_txn_id='".$request_id."'");
        $user = sql_fetch_array($usql);
		return redirect('plans?paystatus=success','1');
    }
}else{
    redirect('plans?paystatus=failed','1');
}



?>