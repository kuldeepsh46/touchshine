<?php
session_start();
session_regenerate_id();
require_once('../system/function.php');	
if($_SERVER["REQUEST_METHOD"]=="POST"){
$arr = array("status"=>'PENDING', "message"=>'Payment Processing');	
//print_r($_SESSION);
if(isset($_SESSION['txn_ref_id']) && 
!empty($_SESSION['upi_id']) && 
!empty($_SESSION['client_orderid']) && 
!empty($_SESSION['cust_Mobile']) && 
!empty($_SESSION['cust_Email']) && 
!empty($_SESSION['muid']) && 
!empty($_SESSION['auth_token'])){
	
$txn_ref_id = $_SESSION['txn_ref_id'];
$upi_id = $_SESSION['upi_id'];	
$client_orderid = $_SESSION['client_orderid'];	
$cust_Mobile = $_SESSION['cust_Mobile'];	
$cust_Email = $_SESSION['cust_Email'];		
$txnNote = $_SESSION['txnNote'];
$muid = $_SESSION['muid'];	
$auth_token = $_SESSION['auth_token'];	

$uquery = sql_query("SELECT * FROM `tb_partner` WHERE id='".$muid."' AND token='".$auth_token."' ");
$userdata = sql_fetch_array($uquery);

$res = sql_query("SELECT * FROM `tb_virtualtxn` WHERE bene_account_ifsc='".$txn_ref_id."' ");

if(sql_num_rows($res)==0 && $userdata['id']>0){
$query = sql_query("SELECT * FROM `tb_virtualtxn` WHERE client_orderid='".$client_orderid."' ");
if(sql_num_rows($query)==0){
	
$JsonData = json_encode(array("MID"=>get_paytm_business($userdata['id'],"mid"),"ORDERID"=>$txn_ref_id));
$r = curl_get("https://securegw.paytm.in/order/status?JsonData=$JsonData","");	
$res = json_decode($r,true);	

if($res['STATUS']=="TXN_SUCCESS" && $res['MID']==get_paytm_business($userdata['id'],"mid") && $res['ORDERID']==$txn_ref_id){
   
$credited_at = date_time("Y-m-d h:i:s");
$bene_account_no = get_paytm_business($userdata['id'],"upi_id");
$bene_account_ifsc = $txn_ref_id;
$rmtr_full_name = $cust_Email;
$rmtr_account_no = $cust_Mobile." - ".$client_orderid;
$rmtr_account_ifsc = $res['RESPMSG'];
$rmtr_to_bene_note = $txnNote;
$txn_id = time();
$amount = $res['TXNAMOUNT'];
$charges_gst = 0;
$settled_amount = $res['TXNAMOUNT'];;
$txn_time = $res['TXNDATE'];
$created_at = $res['TXNDATE'];
$payment_type = $res['PAYMENTMODE'];
$bank_ref_num = $res['BANKTXNID'];


$ress = sql_query("INSERT INTO `tb_virtualtxn`(`credited_at`, `bene_account_no`, `bene_account_ifsc`, `rmtr_full_name`, `rmtr_account_no`, `rmtr_account_ifsc`, `rmtr_to_bene_note`, `txn_id`, `amount`, `charges_gst`, `settled_amount`, `txn_time`, `created_at`, `payment_type`, `bank_ref_num`,`client_orderid`, `results`, `user_id`) 
VALUES ('$credited_at','$bene_account_no','$bene_account_ifsc','$rmtr_full_name','$rmtr_account_no','$rmtr_account_ifsc','$rmtr_to_bene_note','$txn_id','$amount','$charges_gst','$settled_amount','$txn_time','$created_at','$payment_type','$bank_ref_num','$client_orderid','$r','".$userdata['id']."')");
    
if($ress){
    
$json_string = json_encode(array(
"txnStatus"=>'TXN_SUCCESS', 
"resultInfo"=>$res['RESPMSG'],
"orderId"=>$client_orderid,
"txnAmount"=>$amount,
"txnId"=>$txn_id,
"bankTxnId"=>$res['TXNID'],
"paymentMode"=>$payment_type,
"txnDate"=>$credited_at,
"utr"=>$bank_ref_num,
"sender_vpa"=>$cust_Mobile,
"sender_note"=>$txnNote,
"payee_vpa"=>$upi_id,
));	    
 
$hash = hash_encrypt($json_string, $userdata['secret']);
require_once('../system/checksum.php');
$AhkWebCheckSum = AhkWebCheckSum::generateSignature($json_string,$userdata['secret']);
$arr = array("status"=>'SUCCESS', "message"=>'Transactions Successfully', "hash"=>$hash, "checksum"=>$AhkWebCheckSum);	
//session_destroy();

unset($_SESSION['muid']);
unset($_SESSION['auth_token']);
unset($_SESSION['txn_ref_id']);
unset($_SESSION['upi_id']);
unset($_SESSION['client_orderid']);	
unset($_SESSION['txnAmount']);	
 
    
}    
    
    
    
    
}

	
}else{
$arr = array("status"=>'FAILED', "message"=>'Duplicate Order Id');	
}
}else{
$arr = array("status"=>'FAILED', "message"=>'Duplicate Request');	
}
}

}else{
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Request');		
}
echo json_encode($arr);
?>