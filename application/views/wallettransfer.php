<?php $this->load->view('header'); ?>

<!-- row opened -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Transfer Money AEPS Wallet To Main Wallet</div>
                <div class="card-options ">
                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a>
                    <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i
                            class="fe fe-maximize"></i></a>

                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                        <div class="card  box-shadow-0">
                            <div class="card-header">
                                <h4 class="card-title">Transfer To Main Wallet</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal">
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="amount"
                                                    placeholder="Amount">
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 mt-3 justify-content-end">
                                        <div>
                                            <button type="button" class="btn btn-primary" onclick="dotransfer();"
                                                id="rech">Do Transfer</button>
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
<!-- row closed -->

<div class="modal" id="pending">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button> <i
                    class="icon icon ion-ios-alert-circle-outline tx-100 tx-warning lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-warning mg-b-20"> Please Wait..!</h4>
                <p class="mg-b-20 mg-x-20">Recharge Pending.</p><a aria-label="Close"
                    class="btn ripple btn-warning pd-x-25 text-white" data-dismiss="modal"
                    href="/recharge/prepaid">Continue</a>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script>


    function dotransfer() {
        document.getElementById("rech").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        $('#rech').html(dat);
        var amount = $("#amount").val();
        var auth = $("#auth").val();

        $.ajax({
            url: "<?php echo site_url(); ?>main/dotransfer",
            method: "POST",
            data: {
                "amount": amount,
                "auth": auth
            },
            success: function (data, status) {
                document.getElementById("rech").disabled = false;
                var dat = 'dotransfer';
                $('#rech').html(dat);
                
                var jsonData = JSON.parse(data);
                console.log(jsonData.status)
                
                if (jsonData.status == "success") {
                   swal(
						'Success',
						jsonData.response,
						'success'
					)
					 setTimeout(function () {
						window.location.reload();
					 }, 1000);
                } else {
                    
                   swal(
						'Oops...',
						jsonData.response,
						'error'
					)
                }
            }
        });
    }


    function get_last_transactions() {
        $.ajax({
            url: "<?php echo site_url(); ?>main/get_last_rechargetxn",
            method: "POST",
            data: {
                "auth": auth
            },
            success: function (htmdata) {
                //alert(htmdata)

                $("#div-last-transaction").html(htmdata)

            }


        });
    }

    function recharge_status_chk(idx) {

        var id_parts = idx.split('__');
        var mtxnid = id_parts[1];
        var auth = $("#auth").val();
        $.ajax({

            url: "<?php echo site_url();?>rccontroller/chkStatus",
            method: "POST",
            data: {
                "auth": auth,
                "id": mtxnid

            },
            success: function (data, status) {
                if (data == '1') {
                    alert('RECHARGE SUCCESSFULL');
                    location.href = "<?php echo site_url(); ?>/recharge";
                } else if (data == '2') {
                    alert('RECHARGE PENDING CHECK AFTER 5 MIN');
                } else if (data == '3') {
                    alert('TRANSACTION FAILED');
                    location.href = "<?php echo site_url(); ?>/recharge";
                } else {
                    alert('ERROR FROM SERVER');
                }
            }
        });
    }

</script>

<?php $this->load->view('footer'); ?>