<?php
require_once('layouts/header.php');

$account = json_decode($userdata['settle_account']);
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
<?php if($userdata['upi_active']>0){ ?> 
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

<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid card-nblue">
                <div class="row p-4">
                <div class="col-md-4 mb-4">
				<h4 class="text-white">UPI Settings</h4><hr class="bg-white">
<form action="" method="post">
    
    <div class="form-group">
      <label class="text-white">UPI Address</label>
      <input type="text" name="upi_id" value="<?php echo get_upi_id($userdata['id'],"upi_id");?>" id="upi_id" onchange="UPIValid(this.value);" class="form-control form-control-sm" placeholder="Enter Your UPI Address" required>
    </div>
    
    <div class="form-group">
      <label class="text-white">Bank Account Name</label>
      <input type="text" name="upi_name" value="<?php echo get_upi_id($userdata['id'],"upi_name");?>" class="form-control form-control-sm" placeholder="Enter Your Bank Account Name" required>
    </div>
	
    <div class="form-group">
      <label class="text-white">IFSC Code</label>
      <input type="text" name="ifsc" value="<?php echo get_upi_id($userdata['id'],"ifsc");?>" onkeyup="icsf_valid(this.value);" class="form-control form-control-sm" placeholder="Enter Your IFSC Code" minlength="11" maxlength="11" required>
      <span id="ifsc_bank" class="text-white"></span>
    </div>
	
    <button type="submit" name="upiupdate" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Submit</button>
<script>
function icsf_valid(ifsc){
document.getElementById("ifsc_bank").innerHTML = '';
 if(ifsc.length==11){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var myObj = JSON.parse(this.responseText);
      document.getElementById("ifsc_bank").innerHTML = myObj.BANK+', '+myObj.BRANCH;
    }
  };
  xhttp.open("GET", "https://ifsc.razorpay.com/"+ifsc, true);
  xhttp.send();
  
}

}

function UPIValid(upi_id) { 
  if(isUPI(upi_id)!=true){
  alert("UPI Adress is not valid");
  document.getElementById("upi_id").value = ""; 
  }
}


function isUPI(upi) {
    return upi.endsWith('@paytm') || upi.endsWith('@sbi');
}
</script>    
</form> 
				
			  
			   
                </div>	
				
                <div class="col-md-8 mb-4">
				<h4 class="text-white">Connected Device</h4><hr class="bg-white">

				<div class="card card-custom gutter-b">
	<!-- Begin::Body-->
	<div class="card-body">
		<div class="d-flex">
			<!-- begin: Info-->
			<div class="flex-grow-1">
				<!-- begin::Title-->
				<div class="d-flex align-items-center justify-content-between flex-wrap">
					<!-- begin::User-->
					<div class="mr-3">
						<div class="d-flex align-items-center mr-3 mb-3">
							<!-- begin::Name-->
							<div class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3"
 								href="#"><i class="fa fa-mobile-alt fa-lg text-nblue"></i>&nbsp;&nbsp; <?=get_device($userdata['id'],16)?> <?=get_device($userdata['id'],17)?></div>
							<!-- end::Name-->
							<?php if(get_device($userdata['id'],16)!=""){?>
							<span class="badge badge-success font-weight-bolder mr-1">Connected</span>
							<?php }else{?>
							<span class="badge badge-danger font-weight-bolder mr-1">Disconnected</span>
							<?php }?>
						</div>
						<!-- begin::Contacts-->
						<div class="text-dark text-hover-primary  mr-lg-8 mr-5 mb-lg-0 mb-2"
 							href="#">
							<i class="fa fa-lock text-nblue"></i>&nbsp;&nbsp;Android ID <?=get_device($userdata['id'],15)?></div>
						<div class="d-flex flex-wrap my-2">
							<div class="text-dark text-hover-primary  mr-lg-8 mr-5 mb-lg-0 mb-2"
 								href="#">
								<i class="fa fa-tools text-nblue"></i>&nbsp;&nbsp;Android <?=get_device($userdata['id'],1)?></div>
						</div>
						<div class="text-dark text-hover-primary mr-lg-8 mr-5 mb-lg-0 mb-2"
 							href="#">
							<i class="fa fa-history text-nblue"></i>&nbsp;&nbsp;<?=misec_datetime(get_device($userdata['id'],21),"Y-m-d h:i:s")?></div>
						<!-- end::Contacts-->
					</div>
					<!-- begin::User-->
					<!-- begin::Actions-->
					<div class="mb-10"/>
					<!-- end::Actions-->
				</div>
				<!-- end::Title-->
				<!-- end::Content-->
			</div>
			<!-- end::Info-->
		</div>
		<!-- end::Body-->
	</div>
	<!-- End::Card-->
	<!-- begin::Card-->
</div>
			  
			   
                </div>					
				
				<h4 class="text-white mt-3"><b>Smart Gateway work with</b></h4>
				<div class="font-size-sm text-white">Smart Gateway currently support selected UPI App right now. Which are given below</div>
				<hr class="bg-white">
<div class="card card-custom">				
	<div class="card-body row">
	  <div class="col-md-4  mb-2"> 
	   <a class="nav-link border d-flex flex-grow-1 rounded flex-column align-items-center">
		<img src="assets/img/bank_paytm.jpg" alt="" width="150"></a>   
		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>Paytm :</b> <span class="text-dark"> App<br>
			<button class="btn bg-mix text-white btn-sm" onclick="window.open('https://play.google.com/store/apps/details?id=net.one97.paytm', '_blank')">Click Here</button>
			</span>
		</span>
	  </div>  
	    
	  <div class="col-md-4  mb-2"> 
	   <a class="nav-link border d-flex flex-grow-1 rounded flex-column align-items-center">
		<img src="assets/img/bank_sbi.jpg" alt="" width="150"></a>   
		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>SBI Pay :</b> <span class="text-dark"> App<br>
			<button class="btn bg-mix text-white btn-sm" onclick="window.open('https://play.google.com/store/apps/details?id=com.sbi.upi', '_blank')">Click Here</button>
			</span>
		</span>
	  </div>  
	  
	  <div class="col-md-4 mb-2"> 
	   <a class="nav-link border d-flex flex-grow-1 rounded flex-column align-items-center">
		<img src="assets/img/smartgateway chopy.jpg" alt="" width="150"></a>   
		<span class="font-size-lg py-2 font-weight-bolder text-center"><b>Mitra Gateway :</b> <span class="text-dark"> App<br>
			<button class="btn bg-mix text-white btn-sm" onclick="window.open('../docs/com.mitragateway.mitragatewayapp.apk', '_blank')">Click Here</button>
			</span>
		</span>
	  </div>
	  
	  <div class="col-md-12 mt-4"> 
	   <a class="nav-link border d-flex flex-grow-1 rounded flex-column align-items-center"><b>Payee an pay use with</b>
	   <p class="text-dark">Your client can pay with UPI App like GooglePay, Phonepay, Freecharge UPI, Bhim UPI, SBI UPI and many more.</p></a> 
	  </div>
    </div>
</div>    
                </div>
                
                
              </div>
            </div>

            
            
          </div>
        </div>
<?php }else{ ?>        
<div class="col-md-12 col-lg-12 d-flex mt-4">
<div class="card mb-grid w-100 card-nblue text-center">
<h2 class="mt-3 text-white"><b>Accept Payments Directly to your Bank Account</b></h2>
<h3 class="text-white"><b>At 0% Transaction Fee</b></h3>
<button class="btn btn-success btn-sm text-white" onclick="window.open('https://wa.me/91<?=support('mobile')?>?text=<?=urlencode("I'm interested in your UPI Smart Gateway")?>');">Activate UPI Smart Gateway</button>
<div class="card card-custom p-2"><?=webdata("notification")?></div>
</div>
</div>        
<?php } ?>        
      </div>
<?php
require_once('layouts/footer.php');
?>