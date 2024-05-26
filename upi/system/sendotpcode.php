<?php
require_once('../system/function.php');
$arr = array("status"=>false, "msg"=>'Invalid Request');
if(isset($_POST['lid']) && !empty($_POST['lid'])  && !empty($_POST['lpwd']) ){
    
$login_id = safe_str($_POST['lid']);   
$lpwd = strip_tags($_POST['lpwd']);  

$res = sql_query("SELECT * FROM `tb_partner` WHERE login_id='".$login_id."' AND status='active' ");
$result = sql_fetch_array($res);
$pwd = $result['login_pwd'];

if(sql_num_rows($res)>0 && $result['status']=="active" && pwd_verify($lpwd,$pwd)){
//$rand = GenRandomString(8);
$rand = generateNumericOTP(8);
//$msg = "Payment Gateway Login Verification code is: {#var#}, and is valid for 15 minutes. never share with anyone. Thank You - {#var#} EBRAN SEKH";
$msg = "Payment Gateway Login Verification code is: $rand, and is valid for 15 minutes. never share with anyone. Thank You - ".webdata('socket').base_url();
$sms_status = SendSMS($result['mobile'],$msg);

$email_message = "<html><head><title>Payment Gateway Login Verification code is: $rand,</title></head><body style='font-family: Arial, Helvetica, sans-serif;'>
    <table style='border:1px solid #ccc;border-radius:8px;' cellpadding='8'>
    <tr><td><img src='" .webdata("company_logo"). "' width='100' style='background: linear-gradient(#0857ab,#11c9cc); border-radius: 10px; padding: 5px;'/></td></tr>
    <tr><td style>Greetings " . $result['name'] . "</td></tr>
    <tr><td>Your OTP: <b>$rand</b></td></tr>
    <tr><td>Expires in:<b> 10 minutes only</b></td></tr>
  
    <tr><td>We are sharing a verification code to access your account. The code is valid for 10 minutes and usable only once, (<b style='color:red;'>never share with anyone.</b>)</td></tr>
    <tr><td>Thank you</td></tr>
    <tr><td>Admin - " . webdata('company_name') . "</td></tr>
    <tr><td>Email: " . support('email') . "</td></tr>
    <tr><td>Phone: " . support('mobile') . "</td></tr></table></body></html>";
    
$mail_status = SendMail($result['email'], " ".webdata('company_name')." ($rand) is your Verification code for secure access", $email_message);
sql_query("UPDATE `tb_partner` SET login_otp='".$rand."' WHERE id='".$result['id']."' ");	
$arr = array("status"=>true, "msg"=>".$msg.", "sms_status"=>$sms_status, "mail_status"=>$mail_status);
}else{
$arr = array("status"=>false, "msg"=>'Credentials is invalid'); 
}


}

//function SendSMS($mobile, $message) 
{
    //$o11 = new stdClass();

    //$factory = new TypeFactory($dbName);
    //$o11 = $factory->get_object("30", "api", "api_id");
//$mobile = "91"($result['mobile']);
   // if ($o11->api_id == "30") {
        
        //$message = $message;
		$curl = curl_init();
        $url = "https://wamsg.tk/wa.php?api_key=UTmrUQYT29HAK401akw4ws3RZUpdRA&sender=917800152849&number=91".($result['mobile'])."&message=$msg";
        
       
       // &sender_id=" . $o11->md_key . "&message=".urlencode($message)."&language=english&route=" . $o11->corporate_id . "&numbers=".urlencode($mobile);
		
		
		
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
         //pt($url);die;
        curl_close($ch);
}






echo json_encode($arr);
?>