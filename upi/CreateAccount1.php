<?php
require_once('system/function.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo webdata('company_name');?> | Create Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="assets/dist/css/adminx.css" media="screen" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
	<script src="assets/dist/js/historry.js"></script>
	<script src="assets/dist/js/sweetalert.min.js"></script>

<style>
.navbar-brand-image {
    width: 3.875rem;
    height: 1.875rem;
}    
.brand-logo{
   background-image: url('images/brand.png');
   background-size: contain; 
   background-repeat: no-repeat;
   background-position: 
   center;
   height: 40px; width: 120px 
    
}

.small-logo {
    /* height: 60px; */
    width: 150px;
}

.adminx-container .navbar {
    font-size: .875rem;
    /* background-color: #000; */
    height: 3.5rem;
    padding: 0;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    background-image: linear-gradient(90deg, #085bac, #11c4cb);
}
.adminx-sidebar {
    /* background: #fff; */
    position: fixed;
    width: 260px;
    top: 3.5rem;
    bottom: 0;
    left: 0;
    z-index: 1040;
    -webkit-box-shadow: 1px 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 1px 1px 1px 0 rgba(0,0,0,.1);
    background-image: linear-gradient(180deg, #095fae, #11c4cb);
}
.sidebar-nav-link {
    padding: .5rem 1.5rem;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    color: #ffffff;
}
.sidebar-nav-link.active {
    color: #ffffff;
}
.sidebar-sub-nav {
    list-style-type: none;
    margin: 0;
    padding: .5rem 0;
    font-size: .875rem;
    background-image: linear-gradient(180deg, #095fae, #11c4cb);
}
a:hover {
  color: white;
}
.card{
border-radius: 5px;	
}
.sp-background {
  background:#0857ab;
  background-size: cover;  
}
.card-nblue {
 background: #011f3f;	
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #0e98be;
}

.bg-mix{
  background: linear-gradient(#0857ab,#11c9cc);	
}
.table-hover tbody tr:hover {
    background-color: #011f3f;
    color: white;
}
</style>

  </head>
<body class="sp-background">

<div class="p-4">
<div class="container">	
<div class="row justify-content-center">
<?php
if(isset($_POST['create_account']) && 
!empty($_POST['pan_no']) &&  
!empty($_POST['name']) &&  
!empty($_POST['company_name']) &&  
!empty($_POST['uid_no']) &&  
!empty($_POST['email']) &&  
!empty($_POST['mobile']) ){

$pan_no = safe_str($_POST['pan_no']);
$name = strip_tags($_POST['name']);
$company_name = strip_tags($_POST['company_name']);
$uid_no = safe_str($_POST['uid_no']);
$email = strip_tags($_POST['email']);
$mobile = safe_str($_POST['mobile']);

$res = sql_query("SELECT * FROM `tb_partner` WHERE pan_no='".$pan_no."' || uid_no='".$uid_no."' || email='".$email."' || mobile='".$mobile."' ");
if(sql_num_rows($res)==''){
$rand = GenRandomString(3).time();  
$pwd = pwd_hash($rand);
$query = sql_query("INSERT INTO tb_partner (`login_id`, `login_pwd`, `name`, `company_name`, `mobile`, `email`, `pan_no`, `uid_no`, `status`) 
VALUES ('".$pan_no."','".$pwd."','".$name."','".$company_name."','".$mobile."','".$email."','".$pan_no."','".$uid_no."','inactive')");
if($query){
$msg = "Dear $name, Username is:$pan_no, Pwd is:$rand,  Thank you for register, never share with anyone. ".webdata('socket').base_url();
$sms_status = SendSMS($mobile,$msg);      



$email_message = "<html><head><title>Login Credentials</title></head><body style='font-family: Arial, Helvetica, sans-serif;'>
    <table style='border:1px solid #ccc;border-radius:8px;' cellpadding='8'>
    <tr><td><img src='" .webdata("company_logo"). "' width='100' style='background: linear-gradient(#0857ab,#11c9cc); border-radius: 10px; padding: 5px;'/></td></tr>
    <tr><td style>Dear " . $name . "</td></tr>
    <tr><td>Your Username: <b>$pan_no</b></td></tr>
    <tr><td>Your Password: <b>$rand</b></td></tr>
  
    <tr><td>We are sharing a Login Credentials to access your account.(<b style='color:red;'>never share with anyone.</b>)</td></tr>
    <tr><td>Thank you</td></tr>
    <tr><td>Admin - " . webdata('company_name') . "</td></tr>
    <tr><td>Email: " . support('email') . "</td></tr>
    <tr><td>Phone: " . support('mobile') . "</td></tr></table></body></html>";
    
$mail_status = SendMail($email, " ".webdata('company_name')." ($name) Login Credentials", $email_message);


echo '<script>swal("Registered Mobile Number!", "Login Credentials Has Been Sent Successfully!", "success");</script>';
$msg = "Dear $name, Complete Your KYC Verification, Contact your Account Manager:+91 ".support('mobile').", Thank You: ".webdata('socket').base_url();
$sms_status = SendSMS($mobile,$msg);  


$email_message = "<html><head><title>Dear $name, Complete Your KYC Verification,</title></head><body style='font-family: Arial, Helvetica, sans-serif;'>
    <table style='border:1px solid #ccc;border-radius:8px;' cellpadding='8'>
    <tr><td><img src='" .webdata("company_logo"). "' width='100' style='background: linear-gradient(#0857ab,#11c9cc); border-radius: 10px; padding: 5px;'/></td></tr>
    <tr><td style>Dear " . $name . "</td></tr>
    <tr><td style>Greetings from " . webdata('company_name') . "..!!</td></tr>
    <tr><td>Your Username: <b>$pan_no</b></td></tr>
    <tr><td>Your Password: <b>$rand</b></td></tr>
    <tr><td>Your Account Manager: <b>+91 ".support('mobile')."</b></td></tr>
    <tr><td>Registration Form: <b><a href='".webdata('socket').base_url()."/docs/RechPayPaymentGatewayRegistrationForm.pdf'>Download</a></b></td></tr>
  
    <tr><td>I need the following details to submit to our acquiring bank to proceed with this process.</td></tr>
    <tr><td>
    <div>
<div>
<ol>
<li>Contact Person name&nbsp;for&nbsp;CPV&nbsp;(verification):&nbsp;</li>
<li>Contact&nbsp;details&nbsp;(mobile):</li>
<li>Registered company name:</li>
<li>Operating Center's Address &amp; nearby Landmark:&nbsp;</li>
<li>Website URL:&nbsp;</li>
<li>Do you have any mobile app?:</li>
<li>Do you have a signboard at your center in the name of your registered business?</li>
<li>Please provide business setup photos:</li>
<li>Go Live date to start transactions:</li>
<li>Expected transactions volume in&nbsp;the next two months:&nbsp;&nbsp;</li>
<li>Purpose of Payment gateway;</li>
<li>Please explain your Business Model.</li>
<li>Please share personal&nbsp;<span>KYC</span>&nbsp;documents (PAN CArd and Aadhar card)</li>
</ol>
</div>
</div>
<p>Please Feel free to share your queries.&nbsp;</p>
    </td></tr>
    <tr><td><b>With Regards</b></td></tr>
    <tr><td>" . webdata('company_name') . "</td></tr>
    <tr><td>Email: " . support('email') . "</td></tr>
    <tr><td>Phone: +91" . support('mobile') . "</td></tr></table></body></html>";
    
$mail_status = SendMail($email, " ".webdata('company_name')." ($name), CPV Details || Requirements,", $email_message);



//function SendSMS($mobile, $message) 
{
    //$o11 = new stdClass();

    //$factory = new TypeFactory($dbName);
    //$o11 = $factory->get_object("30", "api", "api_id");
//$mobile = "91"($result['mobile']);
   // if ($o11->api_id == "30") {
        
        //$message = $message;
		$curl = curl_init();
        $url = "https://wamsg.tk/wa.php?api_key=Bo3CIkeI5KYFF2aEq83DizWmPN&sender=919749850057&number=91".$mobile."&message=$msg";
        
       // https://wamsgapi.online/wa.php?api_key=BRQv1hfrfh8vrv44xXnESrZhM6r2Ok&sender=918145344963&number=917431936136&message=Test%C2%A0msg
       // &sender_id=" . $o11->md_key . "&message=".urlencode($message)."&language=english&route=" . $o11->corporate_id . "&numbers=".urlencode($mobile);
		
		
		
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
         //pt($url);die;
        curl_close($ch);
		//pt($response);die;
     
}




}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}



}else{
echo '<script>setTimeout(function(){ swal("Alert!", "Data Already Exist!", "error"); }, 200);</script>';
redirect('','2000');
}	
	
}
?>
<div class="col-md-6 card  card-nblue p-4 mb-5">	
<h4 class="text-white text-center">Create Account</h4>
  <form action="" method="post">
    <div class="form-group">
      <label class="text-white">PAN Number</label>
      <input type="text" class="form-control form-control-sm" id="pan_no" minlength="12" maxlength="10"  name="pan_no" onchange="panValidation(this.value)" placeholder="PAN Number" required>
    </div>
    <div class="form-group">
      <label class="text-white">Name as per PAN</label>
      <input type="text" class="form-control form-control-sm" maxlength="50" name="name" placeholder="Name as per PAN" required>
    </div>
    <div class="form-group">
      <label class="text-white">Bussiness Name</label>
      <input type="text" class="form-control form-control-sm" maxlength="50" name="company_name" placeholder="Bussiness Name" required>
    </div>
    <div class="form-group">
      <label class="text-white">Aadhaar Number</label>
      <input type="text" class="form-control form-control-sm" placeholder="Aadhaar Number" name="uid_no" minlength="12" maxlength="12" onkeypress="return isNumber(event)" required>
    </div>
    <div class="form-group">
      <label class="text-white">Email Address</label>
      <input type="email" class="form-control form-control-sm" placeholder="Email Address" name="email" maxlength="50" required>
    </div>
    <div class="form-group">
      <label class="text-white">Mobile Number</label>
      <input type="text" class="form-control form-control-sm" placeholder="Mobile Number" name="mobile" minlength="10" maxlength="10" onkeypress="return isNumber(event)" required>
    </div>
	<div class="form-check mb-2">
    <input type="checkbox" class="form-check-input" required>
    <label class="form-check-label text-white">I accept the <a href="TermsConditions">Terms & Conditions</a></label>
    </div>
    <button type="submit" name="create_account" class="btn bg-white text-dark btn-sm"><i class="fa fa-check-circle"></i> Proceed</button>
  </form>
</div>

</div>
</div>
</div>
    <!-- If you prefer jQuery these are the required scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="assets/dist/js/vendor.js"></script>
    <script src="assets/dist/js/adminx.js"></script>
	<script src="assets/dist/js/custom-new.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
  </body>
</html> 
	 