<html>
    <head>
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo $logo; ?>" type="image/gif" sizes="16x16">
        <link defer type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
        <link defer type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
         <script type="e0caf6261d78922bab7a7596-text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
         <script type="e0caf6261d78922bab7a7596-text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <style>
           body {
    margin: 0;
    padding: 0;
    background: url(https://i.ibb.co/VQmtgjh/6845078.png) no-repeat;
    height: 100vh;
    font-family: sans-serif;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    overflow: hidden
}

@media screen and (max-width: 600px;

) {
    body {
        background-size: cover;
        : fixed
    }
}

#particles-js {
    height: 100%
}

.loginBox {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 350px;
    min-height: 200px;
    background: #000000;
    border-radius: 10px;
    padding: 40px;
    box-sizing: border-box
}

.user {
    margin: 0 auto;
    display: block;
    margin-bottom: 20px
}

h3 {
    margin: 0;
    padding: 0 0 20px;
    color: #59238F;
    text-align: center
}

.loginBox input {
    width: 100%;
    margin-bottom: 20px
}

.loginBox input[type="text"],
.loginBox input[type="password"] {
    border: none;
    border-bottom: 2px solid #262626;
    outline: none;
    height: 40px;
    color: #fff;
    background: transparent;
    font-size: 16px;
    padding-left: 20px;
    box-sizing: border-box
}

.loginBox input[type="text"]:hover,
.loginBox input[type="password"]:hover {
    color: #42F3FA;
    border: 1px solid #42F3FA;
    box-shadow: 0 0 5px rgba(0, 255, 0, .3), 0 0 10px rgba(0, 255, 0, .2), 0 0 15px rgba(0, 255, 0, .1), 0 2px 0 black
}

.loginBox input[type="text"]:focus,
.loginBox input[type="password"]:focus {
    border-bottom: 2px solid #42F3FA
}

.inputBox {
    position: relative
}

.inputBox span {
    position: absolute;
    top: 10px;
    color: #262626
}

.loginBox input[type="submit"] {
    border: none;
    outline: none;
    height: 40px;
    font-size: 16px;
    background: #59238F;
    color: #fff;
    border-radius: 20px;
    cursor: pointer
}

.loginBox a {
    color: #262626;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
    display: block
}

a:hover {
    color: #00ffff
}

p {
    color: #0000ff
}
        </style>
    </head>
    <body>

   <div class="loginBox"> <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" width="100px">
    <h3>Sign in here</h3>
   
        <div class="inputBox" id="cont"> 
            <input id="username" type="text" placeholder="Username">
            <input id="password" type="password" placeholder="Password">
            <button class="btn btn-primary btn-block" onclick="login();">Login</button>
        </div>

    
    <a href="#">Forget Password & Pin<br> </a>
    <div class="text-center">
        <p style="color: #59238F;">Sign-Up</p>
    </div>
</div>
<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">

      <script>
          function login()
            	{
                  var auth = $("#auth").val();
                  var username = $("#username").val();
                  var password = $("#password").val();
                  $.ajax({
            		  url: "/main/login",
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
            		var pin = $("#pin").val();
            
            		$.ajax({
            
            			url: "/main/verify",
            			method : "POST",
            			data : {
            				"auth" : auth,
            				"pin" : pin,
            				"lat" : lat,
            				"log" : log
            
            			},
            			success:function(data,status)
            			{
            				if (data == 1)
            				{
                            location.href="/";
            
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