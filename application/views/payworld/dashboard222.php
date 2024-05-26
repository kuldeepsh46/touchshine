<?php if (count($indus_kyc) == 0) { ?>
   

        <div class="row">
            <div class="col-12 col-lg-12 col-md-12">
                <div class="card" style="width:100% ;">
                    <div class="card-header">
                        <div class="card-title"><center>KYC UPLOAD</div>
                        <div class="card-options ">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <form class="form-horizontal" >
                                <div class="form-group row">
                                    <label for="inputName1" class="col-md-3 col-form-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="first" placeholder="First Name"disabled value="<?php echo $user->name; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName1" class="col-md-3 col-form-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="last" placeholder="Last Name"disabled value="<?php echo $user->name; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmai2" class="col-md-3 col-form-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" id="email" placeholder="Email"disabled value="<?php echo $user->email; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmai2" class="col-md-3 col-form-label">Mobile</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" id="mobile" placeholder="Mobile"disabled value="<?php echo $user->phone; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmai2" class="col-md-3 col-form-label">Date Of Birth</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="state" placeholder="State"disabled value="<?php echo $kyc->dob; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmai2" class="col-md-3 col-form-label">City</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="city" placeholder="City"disabled value="<?php echo $kyc->district; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmai2" class="col-md-3 col-form-label">Address</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="address" placeholder="Address"disabled value="<?php echo $kyc->address; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmai2" class="col-md-3 col-form-label">Shop Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="shop" placeholder="Shop Name"disabled value="<?php echo $kyc->shopname; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmai2" class="col-md-3 col-form-label">Pincode</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" id="aadhar" placeholder="Aadhar Number"disabled value="<?php echo $kyc->pincode; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmai2" class="col-md-3 col-form-label">Pan Number</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="pan" placeholder="Pan Number"disabled value="<?php echo $kyc->pan; ?>">
                                    </div>
                                </div>
                                <div class="form-group mb-0 mt-3 row justify-content-end">
                                    <input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
                                    <div class="col-md-9">
                                        <button class="btn btn-primary" onclick="uploadkyc();" id="upkyc" type="button">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php } elseif ($indus_kyc->status == "PENDING") { ?>
    <div class="row">
        <div class="col-12  col-lg-12 col-xl-12 col-md-12">
            <div class="card" style="width:100%;">
                <div class="card-body">
                    <h5 class="card-title">KYC STATUS</h5>

                    <hr class="mt-2 mb-5">
                    <div class="row mx-5 my-3">
                        <i class="fa fa-check-circle fa-2x text-success" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<h5 class="text-success">Personal Details</h5>
                    </div>
                    <div class="row mx-5 my-3">
                        <i class="fa fa-check-circle fa-2x text-success" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<h5 class="text-success">Contact Details</h5>
                    </div>
                    <div class="row mx-5 my-3">
                        <i class="fa fa-check-circle fa-2x text-success" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<h5 class="text-success">Adhaar Verification</h5>
                    </div>
                    <div class="row mx-5 my-3">
                        <i class="fa fa-check-circle fa-2x text-success" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<h5 class="text-success"> Upload Documents</h5>
                    </div>
                    <div class="row mx-5 my-3">
                        <i class="fa fa-exclamation-circle fa-2x text-warning" aria-hidden="true" data-container="body" data-popover-color="warning" data-placement="top" title="" data-content="Documents Are Submitted Successfully and under verification" data-original-title="Popover top"></i>&nbsp;&nbsp;&nbsp;&nbsp;<h5 class="text-warning">KYC Verification</h5><br><p class="text-warning">Documents Are Submitted Successfully and under verification</p>

                    </div>

                </div>
            </div>
        </div>




    </div>

<?php } else { ?>

    <div class="row">
        <div class="col-12">
<center>
    <iframe src="<?php echo site_url('payworld/panel'); ?>" id="paymentFrame" width="100%" height="600" frameborder="0" scrolling="No" ></iframe>
</center>
        </div>
    </div>
<?php } ?>



<script>

    function uploadkyc()
    {
        document.getElementById("upkyc").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#upkyc').html(dat);
        var auth = $("#auth").val();
        var first = $("#first").val();
        var last = $("#last").val();
        var email = $("#email").val();
        var mobile = $("#mobile").val();
        var dob = $("#dob").val();
        var city = $("#city").val();
        var address = $("#address").val();
        var shop = $("#shop").val();
        var pincode = $("#pincode").val();
        var pan = $("#pan").val();

        $.ajax({
            url: "<?php echo site_url().'/payworld/kycup';?>",
            method: "POST",
            data: {
                "auth": auth,
                "first": first,
                "last": last,
                "email": email,
                "mobile": mobile,
                "dob": dob,
                "city": city,
                "address": address,
                "shop": shop,
                "pincode": pincode,
                "pan": pan
            },
            success: function (data)
            {
                //alert(data)
                document.getElementById("upkyc").disabled = false;
                var dat = 'Upload Kyc';
                $('#upkyc').html(dat);
                if (data == 1)
                {
                    alert("KYC UPLOAD SUCCESSFULL");
                    location.href = "<?php echo site_url().'/payworld';?>";
                }
                if (data != 1)
                {
                    alert(data);
                }
            }
        });
    }


</script>



