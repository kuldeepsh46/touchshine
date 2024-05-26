<?php
require('inc/head.php');
?>
         <div class="banner_section layout_padding">
            <div id="my_slider" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="taital_main">
                                 <h4 class="banner_taital" style="font-size:30px"><span class="font_size_80">No Transaction Charge<br>Instant Settlements</span></h4>
                                 <p class="banner_text">Accept Payments Directly to your Bank Account At 0% Transaction Fee for businesses UPI payment gateway, QR code checkout, deep linking APIs, API for bulk UPI payments and more...</p>
                                 <div class="book_bt"><a href="CreateAccount">Get Started</a></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div><img src="images/jiffy-trading-app.svg" class="image_1"></div>
                           </div>
                        </div>
                        <!--div class="button_main">
						<button class="all_text">All</button>
						<input type="text" class="Enter_text" placeholder="Enter keywords" name="">
						<button class="search_text">Search</button>
						</div-->
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="taital_main">
                                 <h4 class="banner_taital"><span class="font_size_80">Web UPI Payment<br> Integration</span></h4>
                                 <p class="banner_text">To accept payments via UPI Apps like PhonePe, Google Pay, Paytm etc, you can integrate with a payment gateway that supports UPI flow.</p>
                                 <div class="book_bt"><a href="CreateAccount">Get Started</a></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div><img src="images/step1-illus.svg" class="image_1 pl-5" width="450"></div>
                           </div>
                        </div>
                        <!--div class="button_main">
						<button class="all_text">All</button>
						<input type="text" class="Enter_text" placeholder="Enter keywords" name="">
						<button class="search_text">Search</button>
						</div-->
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="taital_main">
                                 <h4 class="banner_taital"><span class="font_size_80">Payments Collect<br>UPI QR Codes</span></h4>
                                 <p class="banner_text">UPI Quick Response (QR) Code is a unique graphics code that helps to accept UPI payments when scanned with a compatible mobile phone.</p>
                                 <div class="book_bt"><a href="CreateAccount">Get Started</a></div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div><img src="images/Machine - UP.svg" class="image_1" width="500"></div>
                           </div>
                        </div>
                        <!--div class="button_main">
						<button class="all_text">All</button>
						<input type="text" class="Enter_text" placeholder="Enter keywords" name="">
						<button class="search_text">Search</button>
						</div-->
					</div>
                  </div>
               </div>
               <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
               <i class=""><img src="images/left-icon.png"></i>
               </a>
               <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
               <i class=""><img src="images/right-icon.png"></i>
               </a>
            </div>
         </div>
         <!--banner section end -->
      </div>
      <!--header section end -->
      <!-- beauty product section start -->
      <div class="sign-new-up">
         <div class="container">
            <div class="row"  id="Payments">
                
			<div class="col-lg-12 col-sm-12 text-center mt-5">
            <h1 class="text-white" style="font-size: 50px;">Accept Payments<br>Directly to your Bank Account<br>At 0% Transaction Fee
</h1>
            <span class="text-white" style="font-size: 20px;">Your customers can pay directly to your<br>Bank A/C using BHIM or any other UPI Apps</span><br>
			<a href="CreateAccount"><button class="btn btn-primary-outline mt-3">Sign Up for Free  </button></a>
			</div>
			   
               <div class="col-lg-12 col-sm-12">
                <img src="images/upi-illus.svg" class="image_3">
               </div>
               <!--div class="col-lg-8 col-sm-12 ">
                  <div class="beauty_box_1 mt-5"">
                     <h1 class="bed_text_1">Web UPI Payment Gateway API Integration</h1>
                     <div><img src="images/upi_intent_final_2x.webp" class="image_3" width="400"></div>
                     <div class="seemore_bt_1"><a href="#">Integration</a></div>
                  </div>
               </div-->
            </div>
         </div>
      </div>
      <!-- beauty product section end -->
      <!-- product section start -->
      <div class="product_section layout_padding background-1" id="Developers">
         <div class="container">
            <h1 class="text-white text-center" style="font-size: 50px;">Web UPI Payment Gateway Integration</h1>
            <p class="text-white text-center" style="font-size: 15px;">UPI Quick Response (QR) Code is a unique graphics code that helps to accept UPI payments when scanned with a compatible web and mobile phone.</p>
            <div class="product_section_1">
               <div class="row">
                  <div class="col-sm-12 mb-3">
                    <img src="images/web-developer-master-tn.svg" class="image_8" style="width: 50%;">
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- product section end -->
      
      <!-- newsletter section start -->
      <!--div class="layout_padding price">
         <div class="container">
            <h1 class="newsletter_taital"  id="Pricing">Pricing</h1>
            <p class="newsletter_text">No setup fee. No recurring fee. Offer Valid Till 31st March 2021</p>
            <div class="row mb-3">
             <div class="col-lg-12 col-sm-12"> 
<?php
$query = sql_query("SELECT * FROM `tb_slab` WHERE id='".webdata('slab_id')."' ");
$rows = sql_fetch_array($query);
$imps = json_decode($rows['imps'],true);
$neft = json_decode($rows['neft'],true);
?>
<table class="table">
  <tbody>
    <tr class="text-white text-center" style="font-size: 1rem;background-color: #006cbf!important; ">
      <td>Payment Instrument</td>
      <td>Merchant Discount Rate (MDR)</td>
      <td>Monthly Limit</td>
    </tr>
	 <tr class="text-white text-center" style="font-size: 1rem;">
      <td>UPI Collect</td>
      <td><i style="color:white;text-decoration:line-through"><span style="font-size:15px;color:white;"><b>1.95%</b></span></i> <?php echo $rows['upi'];?>%</td>
      <td>Unlimited</td>
    </tr>
	<tr class="text-white text-center" style="font-size: 1rem;">
      <td>Virtual Account</td>
      <td><i style="color:white;text-decoration:line-through"><span style="font-size:15px;color:white;"><b>1.95%</b></span></i> <?php echo $rows['van'];?>%</td>
      <td>Unlimited</td>
    </tr>
	<tr class="text-white text-center" style="font-size: 1rem;">
      <td>Instant Setelment</td>
      <td>Min Rs.<?php echo $imps['slab1'];?>, Max Rs.<?php echo $imps['slab3'];?></td>
      <td>Upto Rs.<?php echo moneyformat(3000000);?></td>
    </tr>
	<tr class="text-white text-center" style="font-size: 1rem;">
      <td>Normal Setelment</td>
      <td>Rs.<?php echo $neft['slab1'];?></td>
      <td>Unlimited</td>
    </tr>
  </tbody>
</table>
			 </div>
            </div>
         </div>
      </div-->
      
            <!-- product section end -->
<style>
.pricing-h3{
    color: #fff;
    background: #1acc8d;
    border-radius: .55rem;
}


.pricing{
    border-radius: .55rem;
}
</style>      
      <!-- newsletter section start -->
      <div class="layout_padding price">
         <div class="container">
          <div class="row text-center"  id="Pricing">
              
          <div class="col-md-12 mt-4 mb-5">
             <div class="row" data-aos="fade-left">

          <div class="col-lg-6 col-md-8">
            <div class="card pricing" data-aos="zoom-in" data-aos-delay="100">
              <h3 class="pricing-h3 p-3" style="background: #4e1acc;" ><b>Start your Free Trial</b><br>
              <span>₹0</span><br>
              <span>For 3 Days</span>
              </h3>
              <ul class="text-info pt-1">
                <b>0 Transaction Fee</b><br>
                <b>No Monthly Limit of usage</b><br>
                <b>Realtime Bank Settlement</b><br>
                <b>No Transactions Limit</b><br>
                <b>No Limit In Adding UPI</b><br>
                <b>Hassle Free Setup (Charge Applicable if take support)</b><br>
                <b>Clean Documentation with Integration Free Kit </b><br>
                <b class="text-danger">Migration Assistance</b><br>
                <b>24*7 Whatsapp Support</b><br>
                <b class="text-danger">Transaction Alert Via SMS</b>
              </ul>
              <div class="p-4">
                <button class="btn btn-primary btn-block" style="background: #4e1acc;"  onclick="window.location.href = 'CreateAccount?trial=true';">Active Trial</button>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-8">
            <div class="card pricing" data-aos="zoom-in" data-aos-delay="100">
              <h3 class="pricing-h3 p-3" style="background: #4e1acc;" ><b>Standard</b><br>
              <span>₹199</span><br>
              <span>For 30 Days</span>
              </h3>
              <ul class="text-info pt-1">
                <b>0 Transaction Fee</b><br>
                <b>No Monthly Limit of usage</b><br>
                <b>Realtime Bank Settlement</b><br>
                <b>No Transactions Limit</b><br>
                <b>No Limit In Adding UPI</b><br>
                <b>Hassle Free Setup (Charge Applicable if take support)</b><br>
                <b>Clean Documentation with Integration Free Kit </b><br>
                <b class="text-danger">Migration Assistance</b><br>
                <b>24*7 Whatsapp Support</b><br>
                <b class="text-danger">Transaction Alert Via SMS</b>
              </ul>
              <div class="p-4">
                <button class="btn btn-primary btn-block" style="background: #4e1acc;"  onclick="window.location.href = 'CreateAccount';">Buy Now</button>
              </div>
            </div>
          </div>

          <!--<div class="col-lg-3 col-md-6">-->
          <!--  <div class="card pricing" data-aos="zoom-in" data-aos-delay="100">-->
          <!--    <h3 class="pricing-h3 p-3"><b>Enterprise</b><br>-->
          <!--    <span>₹499</span><br>-->
          <!--    <span>For 28 Days</span>-->
          <!--    </h3>-->
          <!--    <ul class="text-info pt-1">-->
          <!--      <b>0 Transaction Fee</b><br>-->
          <!--      <b>Realtime Bank Settlement</b><br>-->
          <!--      <b>No Transactions Limit</b><br>-->
          <!--      <b>No Limit In Adding UPI</b><br>-->
          <!--      <b>Zero Setup Charge</b><br>-->
          <!--      <b>Migration Assistance</b><br>-->
          <!--      <b>24*7 Whatsapp Support</b><br>-->
          <!--      <b>Transaction Alert Via SMS</b>-->
          <!--    </ul>-->
          <!--    <div class="p-4">-->
          <!--      <button class="btn btn-success btn-block" onclick="window.location.href = 'https://wa.me/1<?php echo support('mobile');?>';">Buy Now</button>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>-->
          <!--<div class="col-lg-3 col-md-6">-->
          <!--  <div class="card pricing" data-aos="zoom-in" data-aos-delay="100">-->
          <!--    <h3 class="pricing-h3 p-3" style="background: #4e1acc;" ><b>Standard +</b><br>-->
          <!--    <span>₹3999</span><br>-->
          <!--    <span>For 365 Days</span>-->
          <!--    </h3>-->
          <!--    <ul class="text-info pt-1">-->
          <!--      <b>0 Transaction Fee</b><br>-->
          <!--      <b>Realtime Bank Settlement</b><br>-->
          <!--      <b>No Transactions Limit</b><br>-->
          <!--      <b>No Limit In Adding UPI</b><br>-->
          <!--      <b>Zero Setup Charge</b><br>-->
          <!--      <b class="text-danger">Migration Assistance</b><br>-->
          <!--      <b>24*7 Whatsapp Support</b><br>-->
          <!--      <b class="text-danger">Transaction Alert Via SMS</b>-->
          <!--    </ul>-->
          <!--    <div class="p-4">-->
          <!--      <button class="btn btn-primary btn-block" style="background: #4e1acc;"  onclick="window.location.href = 'https://wa.me/1<?php echo support('mobile');?>';">Buy Now</button>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>-->
          <!--<div class="col-lg-3 col-md-6">-->
          <!--  <div class="card pricing" data-aos="zoom-in" data-aos-delay="100">-->
          <!--    <h3 class="pricing-h3 p-3"><b>Enterprise</b><br>-->
          <!--    <span>₹4999</span><br>-->
          <!--    <span>For 365 Days</span>-->
          <!--    </h3>-->
          <!--    <ul class="text-info pt-1">-->
          <!--      <b>0 Transaction Fee</b><br>-->
          <!--      <b>Realtime Bank Settlement</b><br>-->
          <!--      <b>No Transactions Limit</b><br>-->
          <!--      <b>No Limit In Adding UPI</b><br>-->
          <!--      <b>Zero Setup Charge</b><br>-->
          <!--      <b>Migration Assistance</b><br>-->
          <!--      <b>24*7 Whatsapp Support</b><br>-->
          <!--      <b>Transaction Alert Via SMS</b>-->
          <!--    </ul>-->
          <!--    <div class="p-4">-->
          <!--      <button class="btn btn-success btn-block" onclick="window.location.href = 'https://wa.me/1<?php echo support('mobile');?>';">Buy Now</button>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>          -->

       </div> 
          </div>    
              
              
	<div class="col-xl-12 text-center">
		<h1 class="newsletter_taital">Accepting Payments Made Easy, Simple &amp; FREE!</h2>
		<p class="newsletter_text" style="font-size: 12px;">The logos below are the property of respective trademark owners. All the below apps support BHIM-UPI.</p>
	</div>
<style>
.p-border{
 border-top-left-radius: 25px;    
 border-bottom-right-radius: 25px;   
}    
</style>	
	<div class="col-md-3 mb-4">
		<img src="images/bank_gpay.jpg" class="p-border"
   			alt=""
   			srcset=""></div>
		<div class="col-md-3 mb-4">
			<img src="images/bank_phonepe.jpg" class="p-border"
   				alt=""
   				srcset=""></div>
			<div class="col-md-3 mb-4">
				<img src="images/bank_freecharge.jpg" class="p-border"
   					alt=""
   					srcset=""></div>
				<div class="col-md-3 mb-4">
					<img src="images/bank_bhim_upi.jpg" class="p-border"
   						alt=""
   						srcset=""></div>
					<div class="col-md-3 mb-4">
						<img src="images/bank_sbi.jpg" class="p-border"
   							alt=""
   							srcset=""></div>
						<div class="col-md-3 mb-4">
							<img src="images/bank_airtel.jpg" class="p-border"
   								alt=""
   								srcset=""></div>
							<div class="col-md-3 mb-4">
								<img src="images/bank_amazon_pay.jpg" class="p-border"
   									alt=""
   									srcset=""></div>
								<div class="col-md-3 mb-4">
									<img src="images/bank_payzapp.jpg"  class="p-border"
   										alt=""
   										srcset=""></div>
								</div>
         </div>
      </div>
      <!-- newsletter section end -->
<?php
require('inc/foot.php');
?>     