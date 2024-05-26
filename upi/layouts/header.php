<?php
session_start();
session_regenerate_id();
require_once('system/function.php');
$uid = $_SESSION['uid'];
$is_otp = $_SESSION['is_otp'];
$usql = sql_query("SELECT * FROM `tb_partner` WHERE id='".$uid."' AND login_otp='".$is_otp."' ");
$userdata = sql_fetch_array($usql);

$plan_slab = sql_fetch_array(sql_query("SELECT * FROM `tb_slab` WHERE id='".$userdata['slab']."' "));

if(!isset($_SESSION['uid']) || !isset($_SESSION['is_otp']) || $is_otp!=$userdata['login_otp']){
redirect('Logout','0');	
exit();
}
// Check expired or not
$filename = basename($_SERVER['SCRIPT_NAME']);
if($filename == 'plans.php' || $filename == 'plans'){
}else{
    $exp_date = $userdata['expire_date'];
    if(getExpiredays(date('d-m-Y H:i:s'),$exp_date) < 0){
        redirect('plans.php',0);
    }
}

    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo webdata('company_name');?> | Partner</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="assets/dist/css/adminx.css" media="screen" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="icon" href="<?php echo webdata('web_fav');?>" type="image/*" />
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
    background-image: linear-gradient(90deg, #00274d, #095dad);
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
    background-image: linear-gradient(180deg, #00274d, #095dad);
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
  background: linear-gradient(#0857ab,#11c9cc);
  border-radius: 5px;	
}
.card-nblue {
 background: #011f3f;	
}
.text-nblue {
 color: #011f3f;	
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
.btn-group-xs > .btn, .btn-xs {
  padding: .25rem .4rem;
  font-size: .875rem;
  line-height: .5;
  border-radius: .2rem;
}

a {
    text-decoration: none;
}
</style>

  </head>
  <body>
    <div class="adminx-container">
      <nav class="navbar navbar-expand justify-content-between fixed-top">
        <div class="navbar-brand mb-1 mb-1 ml-2 d-md-block">
		<img src="<?php echo webdata('company_logo');?>">
        </div>

      

        <ul class="navbar-nav d-flex justify-content-end mr-2">
        
        <div class="d-flex flex-1 d-block d-md-none">
          <a class="sidebar-toggle ml-3 text-white">
            <i data-feather="menu"></i>
          </a>
        </div> 
             
        <div class="d-flex flex-1 mr-2">
          <a href="Logout" class="ml-3 text-white">
            <i data-feather="log-out"></i>
          </a> 
        </div> 
        
        
        </ul>
      </nav>

      <!-- expand-hover push -->
      <!-- Sidebar -->
      <div class="adminx-sidebar expand-hover push" style="overflow: hidden;">
        <ul class="sidebar-nav">
          <li class="sidebar-nav-item mt-2">
            <a href="Dashboard" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fas fa-tasks"></i>
              </span>
              <span class="sidebar-nav-name">
                Dashboard 
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
		  
		  <li class="sidebar-nav-item">
            <a href="PaytmBusiness" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-bold"></i>
              </span>
              <span class="sidebar-nav-name">
                Paytm Business <span class="badge badge-danger font-weight-bolder mr-1">Robotics</span>
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>		  
		  
          
          <li class="sidebar-nav-item">
            <a href="PaytmReports" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-wallet"></i>
              </span>
              <span class="sidebar-nav-name">
                Paytm Reports <span class="badge badge-danger font-weight-bolder mr-1">Robotics</span>
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>          
          		  
		  
		  <li class="sidebar-nav-item">
            <a href="UPIsSettings" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-cog"></i>
              </span>
              <span class="sidebar-nav-name">
                UPIs Settings <span class="badge badge-primary font-weight-bolder mr-1">Advanced</span>
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
          
          
          
		  <li class="sidebar-nav-item">
            <a href="MyQRCode" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-qrcode"></i>
              </span>
              <span class="sidebar-nav-name">
                My QR Code <span class="badge badge-primary font-weight-bolder mr-1">Advanced</span>
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
          
          <li class="sidebar-nav-item">
            <a href="UPITransactions" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-tablet-alt"></i>
              </span>
              <span class="sidebar-nav-name">
                UPIReports <span class="badge badge-primary font-weight-bolder mr-1">Advanced</span>
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>

          		  
		  
		  
          <li class="sidebar-nav-item">
            <a href="UPIsAccounts" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-at"></i>
              </span>
              <span class="sidebar-nav-name">
                UPIs Accounts
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
		  
		  <li class="sidebar-nav-item">
            <a href="Transactions" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-list-alt"></i>
              </span>
              <span class="sidebar-nav-name">
                Transactions
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
          
		  <li class="sidebar-nav-item">
            <a href="Settlement" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-book"></i>
              </span>
              <span class="sidebar-nav-name">
                Settlements 
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
		  
		 
		  <li class="sidebar-nav-item">
            <a href="Developer" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-tools"></i>
              </span>
              <span class="sidebar-nav-name">
                Developer
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
		  
		  
		  <li class="sidebar-nav-item">
            <a href="Settings" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-cogs"></i>
              </span>
              <span class="sidebar-nav-name">
                Settings
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
		  
		  <li class="sidebar-nav-item">
            <a href="plans" class="sidebar-nav-link active">
              <span class="sidebar-nav-icon">
                <i class="fa fa-wallet"></i>
              </span>
              <span class="sidebar-nav-name">
                Plans
              </span>
              <span class="sidebar-nav-end">

              </span>
            </a>
          </li>
		  
          
         
            </ul>
          </li>
        </ul>
      </div><!-- Sidebar End -->