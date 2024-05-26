<?php
require_once('system/function.php');
header('Content-Type: application/json');
$headers = apache_request_headers();

$authorization = $headers['Authorization'];

$arr = array("status"=>'FAILED', "message"=>'Authorization Failed');

if($authorization==webdata('authorization')){
	
$json = json_encode($_POST);
$post = json_decode($json);

$reason = $post->reason;
$bank_ref_num = $post->bank_ref_num;
$reference_number = $post->reference_number;
$status = $post->status;
$txn_type = $post->txn_type;


$res = sql_query("SELECT * FROM `tb_transactions` WHERE order_id='".$reference_number."' ");
$result = sql_fetch_array($res);
if(sql_num_rows($res)>0){
	
if($status=="COMPLETED"){	
sql_query("UPDATE `tb_transactions` SET status='".$status."', rrn='".$bank_ref_num."' WHERE order_id='".$reference_number."' ");	
$arr = array("status"=>'SUCCESS',"rrn"=>$bank_ref_num, "message"=>$txn_type);	
}else{
	
if($result['status']=="PENDING" || 1==1){
sql_query("UPDATE `tb_transactions` SET status='".$status."', rrn='".$reason."' WHERE order_id='".$reference_number."' ");	

$arr = array("status"=>'FAILED',"message"=>$reason);
	
}else{
$arr = array("status"=>'FAILED', "message"=>'Already Updated');	
}

}


}else{
	
$arr = array("status"=>'FAILED', "message"=>'Invalid Reference Number');

}


}

echo json_encode($arr);
?>