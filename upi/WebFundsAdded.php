<?php
require_once('system/function.php');
header('Content-Type: application/json');
$headers = apache_request_headers();

$authorization = $headers['Authorization'];

$arr = array("status"=>'FAILED', "message"=>'Authorization Failed');

if($authorization==webdata('authorization')){
	
$json = json_encode($_POST);
$post = json_decode($json);

$credited_at = $post->credited_at;
$bene_account_no = $post->bene_account_no;
$bene_account_ifsc = $post->bene_account_ifsc;
$rmtr_full_name = $post->rmtr_full_name;
$rmtr_account_no = $post->rmtr_account_no;
$rmtr_account_ifsc = $post->rmtr_account_ifsc;
$rmtr_to_bene_note = $post->rmtr_to_bene_note;
$txn_id = $post->id;
$amount = $post->amount;
$charges_gst = $post->charges_gst;
$settled_amount = $post->settled_amount;
$txn_time = $post->txn_time;
$created_at = $post->created_at;
$payment_type = $post->payment_type;
$bank_ref_num = $post->bank_ref_num;

$res = sql_query("SELECT * FROM `tb_virtualtxn` WHERE bank_ref_num='".$bank_ref_num."' ");

if(sql_num_rows($res)==0){
	
$res = sql_query("INSERT INTO `tb_virtualtxn`(`credited_at`, `bene_account_no`, `bene_account_ifsc`, `rmtr_full_name`, `rmtr_account_no`, `rmtr_account_ifsc`, `rmtr_to_bene_note`, `txn_id`, `amount`, `charges_gst`, `settled_amount`, `txn_time`, `created_at`, `payment_type`, `bank_ref_num`) 
VALUES ('$credited_at','$bene_account_no','$bene_account_ifsc','$rmtr_full_name','$rmtr_account_no','$rmtr_account_ifsc','$rmtr_to_bene_note','$txn_id','$amount','$charges_gst','$settled_amount','$txn_time','$created_at','$payment_type','$bank_ref_num')");

$arr = array("status"=>'SUCCESS', "amount"=>$amount, "rrn"=>$bank_ref_num, "message"=>$rmtr_to_bene_note);	

}else{
	
$arr = array("status"=>'FAILED', "message"=>'Duplicate rrn');

}


}

echo json_encode($arr);
?>