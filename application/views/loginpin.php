<h5 class="card-title text-center  mb-4">Please Enter Security PIN</h5>
    <div class="form-group">
		<input type="password" class="form-control" placeholder="Security PIN" id="pin">
	</div>

<button id="signInButton" class="btn btn-primary btn-block" onclick="verify();">Sign In</button>
	      
	      
	      
	      <script>
	
// JavaScript code to handle the Enter key press event
document.addEventListener('keydown', function(event) {
    if (event.key === "Enter") {
        // Check if the active element is the Sign In button
        if (document.activeElement.id === "signInButton") {
            // If the active element is the Sign In button, trigger the verify function
            verify();
        }
    }
});
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