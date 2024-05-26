<?php
$user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();

$patron_id=$user->patron_id;

$token=$user->token;
?>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta content="Dashlot - Bootstrap Responsive Admin panel Dashboard Template Ui Kit & Premium Dashboard Design Modern Flat HTML Template. This Template Includes 100 HTML Pages & 40+ Plugins. No Need to do hard work for this template customization." name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin template,bootstrap 4 templates,bootstrap admin template,bootstrap dashboard,bootstrap form template,premium,html5,admin dashboard template,admin panel template,bootstrap 4 admin template,bootstrap 4 dashboard,\nbootstrap admin dashboard,bootstrap dashboard template,dashboard bootstrap 4,dashboard ui kit,html admin template,html dashboard template,template admin bootstrap 4">

		<!-- Favicon-->
		<link rel="icon" href="<?php echo $logo; ?>" type="image/x-icon"/>

		<!-- Title -->
		<title><?php echo $title; ?></title>

		<!-- Bootstrap css -->
		<link href="/assets/plugins/bootstrap-4.1.3/css/bootstrap.min.css" rel="stylesheet" />

		<!-- Style css -->
		<link  href="/assets/css/style.css" rel="stylesheet" />

		<!-- Default css -->
		<link href="/assets/css/default.css" rel="stylesheet">

		<!-- Sidemenu css-->
		<link rel="stylesheet" href="/assets/css/closed-sidemenu.css">

		<!-- Owl-carousel css-->
		<link href="/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />

		<!-- Bootstrap-daterangepicker css -->
		<link rel="stylesheet" href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css">

		<!-- Bootstrap-datepicker css -->
		<link rel="stylesheet" href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css">

		<!-- Custom scroll bar css -->
		<link href="/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!-- P-scroll css -->
		<link href="/assets/plugins/p-scroll/p-scroll.css" rel="stylesheet" type="text/css">

		<!-- Font-icons css -->
		<link  href="/assets/css/icons.css" rel="stylesheet">

		<!-- Rightsidebar css -->
		<link href="/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- Nice-select css  -->
		<link href="/assets/plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet"/>

		<!-- Color-palette css-->
		<link rel="stylesheet" href="/assets/css/skins.css"/>
		
		
         <script type="e0caf6261d78922bab7a7596-text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
         <script type="e0caf6261d78922bab7a7596-text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
         <h1 style="border:bule; border-width:8px; border-style:solid;</h1>
	</head>
    <body>
        <?php 
        $kyc = $this->db->get_where('kyc',array('uid' => $_SESSION['uid']))->row();
        $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
        if($kyc->active=='0'){ 
        ?>
            
                <!--Loader-->
		<div id="loading">
		</div>

		<div class="page">
		   <!-- PAGE-CONTENT OPEN -->
			<div class="page-content error-page">
				<div class="container text-center">
					<div class="error-template">
						<h1 class="display-1 mb-2">PENDING<span class="fs-20"></span></h1>
						<h5 class="error-details ">
							Dear <?php echo $user->name; ?> Your KYC has been submitted successfully, please wait for approval team
						</div>
                    </div>
				</div>
			</div>
			<!-- PAGE-CONTENT OPEN CLOSED -->
		</div>
        
        
        
        <?php } else{ ?>
        <div class="row">
			<div class="col-12">
				<div class="card">
				<center><div class="card-title" style="font-size: 25px; font-color: green; border:white; background:SeaGreen; border-width:1px; border-style:solid;">Please Complate Youe KYC </div></center>
					</div>
					<div class="card-body">
						<div class="row">
						   
									<div class="card-body">
										<form class="form-horizontal" action="<?php echo base_url(); ?>/main/uploadkyc" method="post" enctype="multipart/form-data">
										    	
											<div class="form-group row">
												<label for="inputName1" class="col-md-3 col-form-label">Pan Card Number</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="pan" name="pan" placeholder="Pan Number">
												</div>
											</div>
											 <div class="form-group row">
												<label for="inputName1" class="col-md-3 col-form-label">Pan As per Name</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="pan_name" name="pan_name" placeholder="Pan Name" style="pointer-events: none;  background-color:#DCDCDC;">
													
												</div>
											</div>
											   
										
										
											<div class="form-group row">
												<label for="inputName1" class="col-md-3 col-form-label">Aadhar Number</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="aadhar" placeholder="Aadhar Number " >
												</div>
											</div>
									      	<div class="form-group row">
												<label for="inputName1" class="col-md-3 col-form-label">Store Name</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="shopname"  placeholder="Store Name">
												</div>
											</div>
											<div class="form-group row">
												<label for="inputName1" class="col-md-3 col-form-label">Store Address</label>
												<div class="col-md-9">
													<input type="text" class="form-control" name="shopaddress" placeholder="Store Address">
												</div>
											</div>

											<hr>
											<center><div class="card-title" style="font-size: 25px; font-color: green; border:white; border-width:0px; border-style:solid;">Please Uploade Your Orignel Docoment</div></center>
                                            <hr>
											<div class="form-group row">
											    <hr> 
												<label for="inputName1" class="col-md-3 col-form-label">Aadhar Card Front Side</label>
												<div class="col-md-9">
													<input type="file" class="form-control" name="aadharimg">
												</div>
											</div>
											<div class="form-group row">
											    <hr>
												<label for="inputName1" class="col-md-3 col-form-label">Aadhar Card Back Side</label>
												<div class="col-md-9">
													<input type="file" class="form-control" name="aadhar_back">
												</div>
											</div>
											<div class="form-group row">
												<label for="inputName1" class="col-md-3 col-form-label">Pan Card</label>
												<div class="col-md-9">
													<input type="file" class="form-control" name="panimg">
												</div>
											</div>
											<input type="hidden" class="form-control" id="token" value="<?php echo $token ;?>" placeholder="City" style="pointer-events: none;  background-color:#DCDCDC;">
											<input type="hidden" class="form-control"  id="patron_id" value="<?php echo $patron_id ;?>" placeholder="City" style="pointer-events: none;  background-color:#DCDCDC;">
											
											<div class="form-group mb-0 row justify-content-end">
												<div class="col-md-9">
													<div class="checkbox">
														<div class="custom-checkbox custom-control">
															<input type="checkbox" value="1" name="agree" id="Checks"  class="custom-control-input mt-1">
															<label for="Checks" class="custom-control-label mt-1">I Agree Treams & Conditions</label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group mb-0 mt-3 row justify-content-end">
												<div class="col-md-9">
													<button type="submit" class="btn btn-primary">Submit Kyc</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
						
						
	<?php } ?>					
						
						
		</div>

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>

		<!-- Jquery-scripts -->
		<script src="/assets/js/vendors/jquery-3.2.1.min.js"></script>

		<!-- Moment js-->
        <script src="/assets/plugins/moment/moment.min.js"></script>

		<!-- Bootstrap-scripts js -->
		<script src="/assets/js/vendors/bootstrap.bundle.min.js"></script>

		<!-- Sparkline JS-->
		<script src="/assets/js/vendors/jquery.sparkline.min.js"></script>

		<!-- Bootstrap-daterangepicker js -->
		<script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

		<!-- Bootstrap-datepicker js -->
		<script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

		<!-- Chart-circle js -->
		<script src="/assets/js/vendors/circle-progress.min.js"></script>

		<!-- Rating-star js -->
		<script src="/assets/plugins/rating/jquery.rating-stars.js"></script>

		<!-- Clipboard js -->
		<script src="/assets/plugins/clipboard/clipboard.min.js"></script>
		<script src="/assets/plugins/clipboard/clipboard.js"></script>

		<!-- Prism js -->
		<script src="/assets/plugins/prism/prism.js"></script>

		<!-- Custom scroll bar js-->
		<script src="/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!-- Nice-select js-->
		<script src="/assets/plugins/jquery-nice-select/js/jquery.nice-select.js"></script>
		<script src="/assets/plugins/jquery-nice-select/js/nice-select.js"></script>

        <!-- P-scroll js -->
		<script src="/assets/plugins/p-scroll/p-scroll.js"></script>
		<script src="/assets/plugins/p-scroll/p-scroll-1.js"></script>

		<!-- Sidemenu js-->
		<script src="/assets/plugins/sidemenu/icon-sidemenu.js"></script>

		<!-- JQVMap -->
		<script src="/assets/plugins/jqvmap/jquery.vmap.js"></script>
		<script src="/assets/plugins/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="/assets/plugins/jqvmap/jquery.vmap.sampledata.js"></script>

		<!-- Apexchart js-->
		<script src="/assets/js/apexcharts.js"></script>

		<!-- Chart js-->
		<script src="/assets/plugins/chart/chart.min.js"></script>

		<!-- Index js -->
		<script src="/assets/js/index.js"></script>
		<script src="/assets/js/index-map.js"></script>
        <!-- Rightsidebar js -->
		<script src="/assets/plugins/sidebar/sidebar.js"></script>

		<!-- Custom js -->
		<script src="/assets/js/custom.js"></script>
		
		
		
		
		
		
		
		
        <!-- Data tables -->
		<script src="/assets/plugins/datatable/js/jquery.dataTables.js"></script>
		<script src="/assets/plugins/datatable/js/dataTables.bootstrap4.js"></script>
		<script src="/assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="/assets/plugins/datatable/js/buttons.bootstrap4.min.js"></script>
		<script src="/assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="/assets/plugins/datatable/js/pdfmake.min.js"></script>
		<script src="/assets/plugins/datatable/js/vfs_fonts.js"></script>
		<script src="/assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="/assets/plugins/datatable/js/buttons.print.min.js"></script>
		<script src="/assets/plugins/datatable/js/buttons.colVis.min.js"></script>
		<script src="/assets/plugins/datatable/dataTables.responsive.min.js"></script>
		<script src="/assets/plugins/datatable/responsive.bootstrap4.min.js"></script>

		<!-- Data table js -->
		<script src="/assets/js/datatable.js"></script>
		
		
		<!-- Bootstrap-colorpicker js -->
		<script src="/assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>

		<!-- Bootstrap-timepicker js -->
		<script src="/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>

		

		<!-- Sidemenu-respoansive-tabs js -->
		<script src="/assets/plugins/sidemenu-responsive-tabs/js/sidemenu-responsive-tabs.js"></script>

		<!-- Select2 js -->
		<script src="/assets/plugins/select2/select2.full.min.js"></script>
		<script src="/assets/js/select2.js"></script>

		<!-- Timepicker js -->
		<script src="/assets/plugins/time-picker/jquery.timepicker.js"></script>
		<script src="/assets/plugins/time-picker/toggles.min.js"></script>

		<!-- Datepicker js  -->
		<script src="/assets/plugins/date-picker/date-picker.js"></script>
		<script src="/assets/plugins/date-picker/jquery-ui.js"></script>
		<script src="/assets/plugins/input-mask/jquery.maskedinput.js"></script>

		<!-- Inputmask js  -->
		<script src="/assets/js/inputmask.js"></script>

		<!-- Multi select js -->
		<script src="/assets/plugins/multipleselect/multiple-select.js"></script>
		<script src="/assets/plugins/multipleselect/multi-select.js"></script>

		<!-- sidemenu js -->
		<script src="/assets/js/left-menu.js"></script>
		
		<script>
		
		 	$(document).ready(function(){
  $("#pan").change(function(){
      
      
                  var token = $("#token").val();
                  var patron_id = $("#patron_id").val();
                  var pan = $("#pan").val();
                  $.ajax({
            		  url: "https://moonexsoftware.co/pan_data.php",
            		  method : "POST",
            		  data : {
                          "token" : token,
            			  "patron_id" : patron_id,
            			  "pan" : pan
            		  },
            		  success:function(resp)
            		  {
                        
            			 var arr=JSON.parse(resp);
            			 $("#pan_name").val(arr.result.name);
            		  }
            
            
            
            	  });
    
  });
});
         
                  
            
            window.onbeforeunload = function() { return "Your work will be lost."; };
            	
		</script>

    </body>
</html>