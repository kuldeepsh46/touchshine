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
				<h4 class="text-white"><b>My QR Code</b></h4><hr class="bg-white">

				<div class="card" style="border-radius: 10px;">
				<!-- begin::Title-->
				<div class="text-center mt-4">
					<!-- begin::User-->
					<img src="../assets/img/bhimupi.png" width="300" class="img-fluid"><br>
					<h5 class="mt-2" style="font-weight: bold;"><b><?php echo get_upi_id($userdata['id'],"upi_name");?></b></h5>
					<div class="pl-5 pr-5"> <hr class="bg-dark">
					<img src="<?=my_qr_code($userdata['id']);?>" width="200" class="img-fluid"><br>
					<div class="mt-2" style="font-weight: bold;">Scan & Pay Using Any App</div>
					</div>
					<div class="mb-3">
					<img src="../assets/img/upiapps.png" width="300" class="img-fluid">
					</div>
					
	            </div>
	<!-- End::Card-->
	<!-- begin::Card-->
</div>

	<!--div id="previewImage"></div--> 			  
			   
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
<!--script src= "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"> </script>
<script> 
function html_to_img(elm,pre){	
          $(pre).html("");
			// Global variable 
			var element = $(elm); 
		
			// Global variable 
			var getCanvas; 

				html2canvas(element, { 
					onrendered: function(canvas) { 
						$(pre).append(canvas); 
						getCanvas = canvas; 
					} 
				}); 

}

//html_to_img("#html-content-holder","#previewImage");
</script--> 