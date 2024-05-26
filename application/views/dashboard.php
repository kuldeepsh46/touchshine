<?php $this->load->view('header'); ?>
<?php
    $uid = $_SESSION['uid'];
    $user = $this->db->get_where('users',array('id' => $uid))->row();
    $site = $this->db->get_where('sites',array('id' => $user->site))->row();
?>
						<!-- partial:partials/_navbar.html -->
						<!-- row opened -->
						<div class="row">
						    
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/mobile_recharge.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/recharge" >Mobile Recharge</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>	<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/mobile_recharge.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/drecharge" >DTH Recharge</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/electricity_bill.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/bbps" >BBPS Pay</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/aeps.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/pwaeps" >AEPS 1 </a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
														<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/aeps.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/pwaeps" >AEPS 2 </a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/money_transfer.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/dmr" >DMT </a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/pancard.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/main/pan" >PAN Card</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/payout.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/payout" >Payout</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/express_payout.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/qtransfer" >Q Transfer</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="https://register.eshram.gov.in/assets/images/eshram.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="https://register.eshram.gov.in/#/user/self" >E-Shram</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div><div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/pmkisan.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="https://www.pmkisan.gov.in/" >PM-Kisan</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div><div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="https://uidai.gov.in/images/logo/aadhaar_english_logo.svg" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="https://tathya.uidai.gov.in/login" >E-Aadhaar</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/uploads/icon/logo_center.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="https://mera.pmjay.gov.in/search/login" >Ayushman Card</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div><div class="col-sm-12 col-md-12 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="d-flex">
										    <div class=" my-auto ml-auto">
												<div class="chart-wrapper text-center">
													<img src="/commssion.png" height="100px">
												</div>
											</div>
											<div class="d-flex">
												
												<h2 class="mt-6"><a href="/Commission.pdf" >Commission</a></h2>
											
											</div>
											
										</div>
									</div>
								</div>
							</div>
						
						</div>
						<!-- row closed -->




<?php $this->load->view('footer'); ?>

