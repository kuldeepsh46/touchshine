    <head>
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo $logo; ?>" type="image/gif" sizes="16x16">
        <link defer type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
        <link defer type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
         <script type="e0caf6261d78922bab7a7596-text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
         <script type="e0caf6261d78922bab7a7596-text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <style>

body {
    background-image: url("https://touchshine.in/assets/background.jpg");
    background-size: 750; /* Set background image size to cover */
    background-attachment: fixed; /* Ensure background image remains fixed while scrolling */
}

.sideimg{
    background-image:url("https://d2r9qgijm7hhx1.cloudfront.net/webpos/promotions/images/LbtN7YHjqQJzWLoPPmGGBj6RlRvOkcM2mFnLPALh.jpeg");
    height:70vh;
    width:600px;
    
}

#particles-js {
    height: 100%
}

.loginBox {
    position: absolute;
    top: 50%;
    display:flax-box;
    left: 80%;
    transform: translate(-50%, -50%);
    width: 350px;
    min-height: 200px;
    background: #fff;
    padding: 40px;
    box-sizing: border-box
}

.sideiimg {
            //background-image: url("/uploads/banner/b2b.jpg");
            //background-repeat: no-repeat;
           // margin-top: 10px;
            //margin-left: 50px;
            //height: 110%;
            //width: 50%;
           // background-size: cover;
            //border-radius: 10px;
            //animation: scroll 10s infinite linear;
            /border: 15px solid rgba(255, 255, 255, 0.95);

}

.user {
    margin: 0 auto;
    display: block;
    margin-bottom: 20px
}

h3 {
    margin: 0;
    padding: 0 0 20px;
    color: #000;
    text-align: center
}

.loginBox input {
    width: 100%;
    margin-bottom: 20px
    

}

.loginBox input[type="text"],
.loginBox select,
.loginBox input[type="number"],
.loginBox input[type="password"] {
    border: none;
    border-bottom: 2px solid #262626;
    outline: none;
    height: 40px;
    border:1.5px solid black;
    color: black;
    background: transparent;
    font-size: 16px;
    padding-left: 20px;
    box-sizing: border-box
}

.loginBox input[type="text"]:hover,
.loginBox input[type="password"]:hover {
    color: #1e31b0;
    border: 1px solid #1e31b0;
    box-shadow: 0 0 8px rgba(0, 255, 0, .3), 0 0 10px rgba(0, 255, 0, .2), 0 0 15px rgba(0, 255, 0, .1), 0 2px 0 black
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
.su:hover {
    color: #00ffff
}

.su {
    cursor: pointer;
    color: black
}
.fp:hover {
    color: #00ffff
}

.fp {
    cursor: pointer;
    color: #383434;
}
.userlogo{
            height: 20px;
            position: absolute;
            margin-top: 10px;
            margin-left:2px;
            
            
        }
        
.passwd{
            height: 20px;
            width: 20px;
            
            position: absolute;
            margin-top: 70px;
            margin-left: -270px;
            
}
        </style>
    </head>
    <body>
        
       <div class="sideiimg"></div>
       
  <div class="loginBox"> <img class="user" src="<?php echo $logo; ?>" height="80px" width="150px">
    <h3>Login here</h3>
   
        <div class="inputBox" id="cont"> 
            <input id="username" type="text" placeholder="User Id">
            <input id="password" type="password" placeholder="Password">
           <button id="loginButton" class="btn btn-primary btn-block" onclick="login();">Login</button>
        </div>
        &nbsp;&nbsp;
        <center>
            <p><strong class="fp" style="color:black" onclick="forgot();">Forget Password & Pin</strong></p>
        </center>
    <div class="text-center">
        <p class="su">Register Here</p>
    </div>
</div>
<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">


      <script>
      function verifychangepass()
    {
        document.getElementById("ubtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#ubtn').html(dat);
        var auth = $("#auth").val();
        var type = $("#type").val();
        var pass = $("#pass").val();
        var cpass = $("#cpass").val();
        $.ajax({
            url : "/main/verifychangepass",
            method : "POST",
            data : {
                "auth" : auth,
                "type" : type,
                "pass" : pass,
                "cpass" : cpass
            },
            success:function(data,status)
            {
                document.getElementById("ubtn").disabled = false;
                var dat = 'Update Data';
                $('#ubtn').html(dat);
                if(data  == 1)
                {
                    alert("PASSWORD CHANGE SUCCESSFULL");
                    location.href="/";
                }else{
                    if(data  == 2)
                    {
                        alert("PIN CHANGE SUCCESSFULL");
                        location.href="/";
                    }else{
                        alert(data);
                    }
                }
                
            }
        });
    }
      function forgot()
            	{
                  var auth = $("#auth").val();
                  
                  $.ajax({
            		  url: "/main/forgotpass",
            		  method : "POST",
            		  data : {
                          "auth" : auth
            		  },
            		  success:function(data,status)
            		  {
                        var n = data.includes("Send");
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
            	function verifyfor()
            	{
                  var auth = $("#auth").val();
                  var user = $("#user").val();
                  $.ajax({
            		  url: "/main/verifyforgotpass",
            		  method : "POST",
            		  data : {
                          "auth" : auth,
                          "user" : user
            		  },
            		  success:function(data,status)
            		  {
                        var n = data.includes("Verify");
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
            	
            	function verifyotp()
            	{
                  var auth = $("#auth").val();
                  var otp = $("#otp").val();
                  $.ajax({
            		  url: "/main/verifyotpfor",
            		  method : "POST",
            		  data : {
                          "auth" : auth,
                          "otp" : otp
            		  },
            		  success:function(data,status)
            		  {
                        var n = data.includes("Update");
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
            	
// JavaScript code to handle the Enter key press event
document.addEventListener('keydown', function(event) {
    if (event.key === "Enter") {
        // Check if the active element is the login button
        if (document.activeElement.id === "loginButton") {
            // If the active element is the login button, trigger the login function
            login();
        }
    }
});

            	
            	
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