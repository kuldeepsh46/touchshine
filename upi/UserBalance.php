<?php
session_start();
session_regenerate_id();
require_once('system/function.php');
$uid = $_SESSION['uid'];
$is_otp = $_SESSION['is_otp'];
$usql = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uid."' AND login_otp='".$is_otp."' ");
$userdata = sql_fetch_array($usql);

if(!isset($_SESSION['uid']) || !isset($_SESSION['is_otp']) || $is_otp!=$userdata['login_otp']){
redirect('Logout','0');	
}
$arr = array("status"=>'SUCCESS', "balance"=>moneyformat($userdata['balance']));

echo json_encode($arr);
?>