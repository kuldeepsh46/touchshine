<?php $this->load->view('header'); ?>

<!-- row opened -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Mobile Recharge</div>
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
                                <h4 class="card-title">Recharge</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="mobile" placeholder="Mobile Number"
                                            oninput="checkop();">
                                    </div>
                                    <?php 
									$operators = $this->db->where('type','1')->get('rechargev2op')->result(); ?>
                                    <div class="form-group">
                                        <select aria-describedby="basic-addon1" aria-label="Operator"
                                            class="form-control" id="operator"
                                            onchange="document.getElementById('amount').value = ''; document.getElementById('namount').value = '';">
                                            <?php foreach ($operators as $op) : ?>
                                            <option value="<?php echo $op->id; ?>">
                                                <?php echo $op->name; ?>
                                            </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                    <?php $circles = $this->db->get('circle')->result_array(); ?>
                                    <div class="form-group">
                                        <select class="form-control" id="circle_state"
                                            onchange="document.getElementById('amount').value = ''; document.getElementById('namount').value = '';">
                                            <?php foreach ($circles as $kc => $vc) : ?>
                                            <option value="<?php echo $vc['id']; ?>">
                                                <?php echo $vc['code']; ?>
                                            </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="amount"
                                                    placeholder="Amount">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-primary" id="viewp"
                                                    onclick="viewplan();">View Plan</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 mt-3 justify-content-end">
                                        <div>
                                            <button type="button" class="btn btn-primary" onclick="dorecharge();"
                                                id="rech">Do Recharge</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                        <div class="card  box-shadow-0 ">
                            <div class="card-header">
                                <h4 class="card-title">Last Transactions</h4>
                            </div>
                            <div class="card-body" id="div-last-transaction"
                                style="max-height: 50vh; overflow-y: auto;">
                                <?php $this->load->view('rechargetxnlist'); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->


<div class="modal" id="success">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button> <i
                    class="icon ion-ios-checkmark-circle-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-success tx-semibold mg-b-20">Congratulations!</h4>
                <p class="mg-b-20 mg-x-20">Recharge Successfull.</p><a aria-label="Close"
                    class="btn ripple btn-success pd-x-25 text-white" data-dismiss="modal"
                    href="/recharge/prepaid">Continue</a>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="failed">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button> <i
                    class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-danger mg-b-20">Sorry !</h4>
                <p class="mg-b-20 mg-x-20">Recharge Failed.</p><a aria-label="Close"
                    class="btn ripple btn-danger pd-x-25 text-white" data-dismiss="modal"
                    href="/recharge/prepaid">Continue</a>
            </div>
        </div>
    </div>
</div>

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

<div class="modal" tabindex="-1" role="dialog" id="info" style="left:-0%;">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="infocont" style="max-height: 400px; overflow-y: auto;">
                <!-- Your content here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script>



    function setamount(amount) {
        $("#amount").val(amount);
        $("#info").modal('hide');
    }
    // function checkop() {
    //     var mobile = $("#mobile").val();

    //     if (mobile.length == 10) {


    //         $.ajax({
    //             url: "<?php echo site_url(); ?>/main/checkop",
    //             method: "POST",
    //             data: {
    //                 'mobile': mobile


    //             },
    //             success: function (datres, status) {
    //                 //alert(datres);
    //                 if (datres !== "ERROR") {
    //                     var dataarr = datres.split('__@__');
    //                     document.getElementById("operator").selectedIndex = dataarr[0];
    //                     $("#circle_state").val(dataarr[1]);
    //                     //alert('success', "Operator Updated.");
    //                     document.getElementById('amount').value = '';
    //                     document.getElementById('namount').value = '';
    //                 } else {
    //                     alert(datres);
    //                 }
    //             }
    //         });


    //     }


    // }

    //     function viewplan()
    //     {

    //         document.getElementById("viewp").disabled = true;
    //         var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    //         $('#viewp').html(dat);
    //         var operator = $("#operator").val();
    //         var circle = $("#circle_state").val();
    //         var auth = $("#auth").val();

    //         $.ajax({
    //             url: "<?php echo site_url(); ?>/main/viewplannew",
    //             method: "POST",
    //             data: {
    //                 "operator": operator,
    //                 "circle": circle,
    //                 "auth": auth
    //             },
    //             success: function (data, status)
    //             {

    // //alert(data)
    //                 document.getElementById("viewp").disabled = true;
    //                 var dat = 'View Plan';
    //                 $('#viewp').html(dat);
    //                 $("#info").modal("show");
    //                 $("#infocont").html(data);

    //             }


    //         });


    //     }

    const infocont = document.getElementById('infocont');
    const mobile_num = document.getElementById('mobile');
    const amount_uu = document.getElementById('amount');

    function viewplan() {
        document.getElementById("viewp").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        $('#viewp').html(dat);
        var operator = $("#operator").val();
        var circle = $("#circle_state").val();
        var auth = $("#auth").val();
        var url = `https://touchshine.in/test.php?offer=roffer&tel=${mobile_num.value}&operator=Jio`;

        $.ajax({
            url: url,
            method: "GET",
            success: function (data, status) {
                document.getElementById("viewp").disabled = false;
                var dat = 'View Plan';
                $('#viewp').html(dat);
                $("#info").modal("show");

                console.log(data);

                // Creating a table using the provided data
                const tableHTML = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Details</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.map(item => `
                    <tr>
                        <td>${item.Rs}</td>
                        <td>${item.Details}</td>
                        <td><button class="btn btn-primary btn-sm" onclick="printPlan('${item.Rs}', '${item.Details}')">Select</button></td>
                    </tr>`).join('')}
                </tbody>
            </table>`;

                // Setting the inner HTML of the "infocont" element to the created table
                infocont.innerHTML = tableHTML;

            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                alert("Error fetching data. Please try again.");
                document.getElementById("viewp").disabled = false;
                var dat = 'View Plan';
                $('#viewp').html(dat);
            }
        });
    }

    function printPlan(plan, details) {
        // Modify this function as per your requirement to print the selected plan details
        console.log("Selected Plan: ", plan);
        amount_uu.value = plan;
        $('#info').modal('hide');
        console.log("Details: ", details);
    }




    function dorecharge() {
        document.getElementById("rech").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        $('#rech').html(dat);
        var mobile = $("#mobile").val();
        var amount = $("#amount").val();
        var operator = $("#operator").val();
        var circle_state = $("#circle_state").val();
        var auth = $("#auth").val();

        $.ajax({
            url: "<?php echo site_url(); ?>main/dorecharge",
            method: "POST",
            data: {
                "mobile": mobile,
                "amount": amount,
                "operator": operator,
                "circle": circle_state,
                "auth": auth
            },
            success: function (data, status) {
                document.getElementById("rech").disabled = false;
                var dat = 'dorecharge';
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
					 }, 3000);
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