<h5 class="card-title text-center  mb-4">Please Enter OTP</h5>
<h6 class="card-title text-center  mb-4">OTP Send To Your Register Mobile XXXXXX<?php echo substr($_SESSION['phone'], -4); ?></h6>

    <div class="form-group">
		<input type="number" class="form-control" placeholder="Please Enter OTP" id="otp">
	</div>

	<button class="btn btn-primary btn-block" onclick="verifyotp();">Verify OTP</button>