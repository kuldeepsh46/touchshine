<?php
header('Content-Type: application/json');
require_once('../system/function.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
if(isset($_POST['token'])&& 
!empty($_POST['orderId'])){

$token = strip_tags($_POST['token']);
$orderId = safe_str($_POST['orderId']);

$res = sql_query("SELECT * FROM `tb_partner` WHERE token='".$token."' AND status='active' ");
$uresult = sql_fetch_array($res);
if(sql_num_rows($res)>0 && $uresult['token']==$token){

$txn_query = sql_query("SELECT * FROM `tb_transactions` WHERE client_orderid='".$orderId."' AND user_uid='".$uresult['id']."' ");
$result = sql_fetch_array($txn_query);
if(sql_num_rows($txn_query)>0){
	
$json_string = array(
"txnStatus"=>$result['status'], 
"resultInfo"=>$result['remark'],
"orderId"=>$result['client_orderid'],
"txnAmount"=>$result['txn_amount'],
"fees"=>$result['fees'],
"settle_amount"=>$result['settle_amount'],
"txnId"=>$result['order_id'],
"bankTxnId"=>$result['rrn'],
"paymentMode"=>$result['mode'],
"txnDate"=>$result['date'].' '.$result['time'],
"utr"=>$result['rrn'],
"sender_vpa"=>$result['pay_upi'],
"sender_note"=>$result['remark'],
"payee_vpa"=>$result['upi_id'],
);		
	
$arr = array("status"=>'SUCCESS', "message"=>'Transactions Successfully', "result"=>$json_string);		

}else{	
$arr = array("status"=>'FAILED', "message"=>'This Order Id is Not Available');
}



}else{	
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Access or Token Is Invalid');
}

	
}else{
$arr = array("status"=>'FAILED', "message"=>'Parameter Missing');
}

}else{
$arr = array("status"=>'FAILED', "message"=>'Unauthorized Request');
}

echo json_encode($arr);
?>
