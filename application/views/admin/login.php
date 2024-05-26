
<!doctype html>
<html lang="en" dir="ltr">
	<head>

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
		<link href="/assets/css/style.css" rel="stylesheet" />
		<link href="/assets/css/default.css" rel="stylesheet" />

		<!-- Sidemenu css -->
		<link rel="stylesheet" href="/assets/css/closed-sidemenu.css">

		<!-- owl-carousel css-->
		<link href="/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />

		<!--Bootstrap-daterangepicker css-->
		<link rel="stylesheet" href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css">

		<!--Bootstrap-datepicker css-->
		<link rel="stylesheet" href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css">

		<!-- Sidemenu-responsive  css -->
		<link href="/assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css" rel="stylesheet">

		<!-- P-scroll css -->
		<link href="/assets/plugins/p-scroll/p-scroll.css" rel="stylesheet" type="text/css">

		<!--Font icons css-->
		<link  href="/assets/css/icons.css" rel="stylesheet">

		<!-- Rightsidebar css -->
		<link href="/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- Nice-select css  -->
		<link href="/assets/plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet"/>

		<!-- Color-palette css-->
		<link rel="stylesheet" href="/assets/css/skins.css"/>

	</head>
	<body class="sidebar-mini2 error-page2  app h-100vh">

		<!-- Loader -->
	<!--	<div id="loading">
			<img src="/assets/images/other/loader.svg" class="loader-img" alt="Loader">
		</div>---!>


		<!-- Page opened -->
		<div class="page h-100">
			<div class="">
				<div class="col col-login mx-auto">
					<div class="text-center">
						<img src="<?php echo $logo; ?>" class="header-brand-img desktop-logo h-100 mb-5" alt="<?php echo $title; ?>">	
					</div>
				</div>
				<!-- container opened -->
				<div class="container">
					<div class="row">
						<div class="col-xl-9 justify-content-center mx-auto text-center">
							<div class="card">
								<div class="row h-100">
									<div class="col-md-12 col-lg-7 pr-0 d-none d-lg-block">
										<img src="<?php echo $this->db->get_where('settings',array('name' => 'login_banner'))->row()->value; ?>" alt="img" class="br-tl-2 br-bl-2 h-100">
									</div>
									<div class="col-md-12 col-lg-5 pl-0 " >
										<div class="card-body p-6 about-con pabout" id="cont">
											<div class="card-title text-center  mb-4">ADMIN LOGIN</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Username" id="username">
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="password" id="password">
											</div>
											
											<div class="form-footer mt-1">
											    <button class="btn btn-success btn-block" onclick="login();">Login</button>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- container closed -->
			</div>
		</div>
		<!-- Page closed -->
<input type="hidden" value="<?php echo $auth; ?>" id="auth">
		<!-- Dashboard js -->
		<script>
		    function login()
            	{
                  var auth = $("#auth").val();
                  var username = $("#username").val();
                  var password = $("#password").val();
                  $.ajax({
            		  url: "/admin/login",
            		  method : "POST",
            		  data : {
                          "auth" : auth,
            			  "username" : username,
            			  "password" : password
            		  },
            		  success:function(data,status)
            		  {
                        var n = data.includes("Sign");
                      if(n)
        			  {
        			  	$("#cont").html(data);
        			  }
        
        			  if(!n)
        			  {
        				  alert(data);
        			  }
            			 
            		  }
            
            
            
            	  });
            
            
            	}
            	function  gotforlogin(lat,log)
            	{
            		var auth = $("#auth").val();
            		var otp = $("#otp").val();
            
            		$.ajax({
            
            			url: "/admin/verify",
            			method : "POST",
            			data : {
            				"auth" : auth,
            				"otp" : otp,
            				"lat" : lat,
            				"log" : log
            
            			},
            			success:function(data,status)
            			{
            				if (data == 1)
            				{
                            location.href="/admin";
            
            				}
            
            				if(data != 1)
            				{
                               alert(data);
            				}
            
            
            			}
            
            
            
            		});
            
            	}
            	
            	
            	
            	
        function verify() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition,showError);
  } else {
    alert("GeoLocation is not supported by your browser.");
  }
}

function showPosition(position) {
  var lat = position.coords.latitude;
  var log = position.coords.longitude;    
  gotforlogin(lat,log);
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      alert("Please Allow Location. Please Try again Later");
      break;
    case error.POSITION_UNAVAILABLE:
       alert("Location Error. Please Try again Later");
      break;
    case error.TIMEOUT:
     alert("Location Timeout Error. Please Try again Later");
      break;
    case error.UNKNOWN_ERROR:
      alert("Error in Location. Please try again later");
      break;
  }
}
		</script>

		<script src="/assets/js/vendors/jquery-3.2.1.min.js"></script>
		<script src="/assets/plugins/bootstrap-4.1.3/popper.min.js"></script>
		<script src="/assets/plugins/bootstrap-4.1.3/js/bootstrap.min.js"></script>
		<script src="/assets/js/vendors/jquery.sparkline.min.js"></script>
		<script src="/assets/js/vendors/circle-progress.min.js"></script>
		<script src="/assets/plugins/rating/jquery.rating-stars.js"></script>

		<!--Moment js-->
        <script src="/assets/plugins/moment/moment.min.js"></script>

		<!-- Custom scroll bar js-->
		<script src="/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!--owl-carousel js-->
		<script src="/assets/plugins/owl-carousel/owl.carousel.js"></script>

		<!-- Bootstrap-daterangepicker js -->
		<script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

		<!-- Bootstrap-datepicker js -->
		<script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

		<!--Counters -->
		<script src="/assets/plugins/jquery-countdown/countdown.js"></script>
		<script src="/assets/plugins/jquery-countdown/jquery.plugin.min.js"></script>
		<script src="/assets/plugins/jquery-countdown/jquery.countdown.js"></script>

		<!-- Custom js-->
		<script src="/assets/js/custom.js"></script>

	</body>
</html>
