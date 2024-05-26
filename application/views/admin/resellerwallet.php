<?php $this->load->view('admin/header'); ?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <span class="badge badge-secondary mr-2">Member ID:&nbsp;<?php echo $rdetail['username']; ?></span>   
                    <span class="badge badge-secondary mr-2">Name:&nbsp;<?php echo $rdetail['name']; ?></span>   
                    <span class="badge badge-secondary mr-2">Mobile:&nbsp;<?php echo $rdetail['phone']; ?></span>   
                    <span class="badge badge-secondary mr-2">Owner Name:&nbsp;<?php echo $rdetail['ownername']; ?></span>   
                    <span class="badge badge-primary">Wallet:&nbsp;<?php echo $rdetail['wallet']; ?></span> <br>
                    <span class="badge badge-warning mt-1">Company:&nbsp;<?php echo $rdetail['cname']; ?></span>
                </div>
            </div>
            <div>
                <div class="search-product">
                    <div class="form row no-gutters">
                        <div class="form-group  col-xl-4 col-lg-3 col-md-12 mb-0 bg-white">
                            <input class="form-control input-lg fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="from" value="<?php echo date('m/d/Y');?>">
                        </div>
                        <div class="form-group  col-xl-1 col-lg-3 col-md-12 mb-0 bg-white">
                            <center><h3 class="pt-4"><i class="fa fa-arrows-h" aria-hidden="true"></i></h3></center>
                        </div>
                        <div class="form-group  col-xl-4 col-lg-3 col-md-12 mb-0 bg-white">
                            <input class="form-control input-lg fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="to" value="<?php echo date('m/d/Y');?>">
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-12 mb-0">
                            <input type="hidden" value="<?php echo $rdetail['id']; ?>" id="rid">
                            <input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
                            <button class="br-tl-md-0 br-bl-md-0 btn btn-lg btn-block btn-primary" onclick="search_rw();" id="srbtn">Search Here</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Wallet History</div>
                <div class="card-options">
                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div id="cont">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="example_1" class="table table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">Narration</th>
                                        <th class="border-bottom-0">AMOUNT</th>
                                        <th class="border-bottom-0">OPENING</th>
                                        <th class="border-bottom-0">CLOSING</th>
                                        <th class="border-bottom-0">DATE</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $ind = 1; ?>
                                    <?php foreach ($rwallets as $dat) : ?>
                                        <tr>
                                            <td><?php echo $ind; ?></td>
                                            <td><?php echo $dat->type . "  Txnid: " . $dat->txnid; ?></td>
                                            <td><?php echo $dat->amount; ?></td>
                                            <td><?php echo $dat->opening; ?></td>
                                            <td><?php echo $dat->closing; ?></td>
                                            <td><?php echo $dat->date; ?></td>
                                        </tr>
                                        <?php $ind++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div> 
                    </div> 
                </div>

            </div>
        </div>
    </div>
</div>


<script>

    function search_rw()
    {

        document.getElementById("srbtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
        $('#srbtn').html(dat);
        var from = $("#from").val();
        var to = $("#to").val();
        var auth = $("#auth").val();
        var rid = $("#rid").val();
        $.ajax({

            url: "<?php echo site_url('admin/searchRtrans'); ?>",
            method: "POST",
            data: {

                "sid": rid,
                "auth": auth,
                "from": from,
                "to": to
            },
            success: function (data)
            {
                //alert(data);
                $('#srbtn').html(dat);
                if (data == 1)
                {
                    alert("INVALID TOKEN");
                    document.getElementById("srbtn").disabled = false;
                    $('#srbtn').html("Search Here");

                } else {
                    if (data == 2)
                    {
                        alert("PLEASE FILL ALL DATA");
                        document.getElementById("srbtn").disabled = false;
                        $('#srbtn').html("Search Here");

                    } else {
                        $("#cont").html(data);
                        var i = setInterval(function () {
                            var table = $("#example").DataTable({
                                lengthChange: false,
                               
                                paging:false,
                                buttons: ['copy', 'excel', 'pdf']
                            });
                            table.buttons().container()
                                    .appendTo('#example_wrapper .col-md-6:eq(0)');
                            clearInterval(i);
                        }, 1000);
                        outprocess();
                    }
                }




            }



        });



    }



    function inprocess()
    {

        document.getElementById("srbtn").disabled = true;
        var data = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
        $('#').html(data);

    }

    function outprocess()
    {

        document.getElementById("srbtn").disabled = false;
        $('#srbtn').html("Search Here");


    }
</script>

<?php $this->load->view('admin/footer'); ?>