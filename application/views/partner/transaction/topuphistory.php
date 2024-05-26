<!-- row opened -->
<div class="row">

    <div class="table-responsive">
        <table id="example" class="table table-bordered key-buttons text-nowrap">
            <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">MEMBER ID</th>
					<th class="border-bottom-0">MAME</th>
                    <th class="border-bottom-0">Date</th>
					<th class="border-bottom-0">TYPE</th>
					<th class="border-bottom-0">TXN ID</th>
					<th class="border-bottom-0">CREDIT</th>
					<th class="border-bottom-0">DEBIT</th>
					<th class="border-bottom-0">Balance</th>
                </tr>
            </thead>
            <?php
            $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;
            $data = $this->db->from("amounttransaction")->where('status','Completed')->where('rid',$_SESSION['rid'])->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); 
			
			?>
            <tbody>
                <?php $ind = 1; ?>
<?php foreach ($data as $dat) : ?>
                    <tr>
                        <td><?php echo $ind; ?></td>
                        <td><?php echo $this->db->get_where('users', array('id' => $dat->uid))->row()->username; ?></td>
						<td><?php echo $this->db->get_where('users', array('id' => $dat->uid))->row()->name; ?></td>
                        <td><?php echo $dat->date; ?></td>
						<td><?php echo $dat->type; ?></td>
						<td><?php echo $dat->order_id; ?></td>
						<?php if($dat->txntype == "DEBIT"){ ?>
						<td><span style="color: green;">0</span></td>
						<td><span style="color: red;"><?php echo $dat->amount; ?></span></td>
						<?php }else{ ?>
						<td><span style="color: green;"><?php echo $dat->amount; ?></span></td>
						<td><span style="color: red;">0</span></td>
						<?php } ?>
						<td><?php echo $dat->closing; ?></td>
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
<!-- row closed -->
<!-- row closed -->
<script>
    function recharge_status_chk(idx) {

        var id_parts = idx.split('__');
        var mtxnid = id_parts[1];
        var auth = $("#auth").val();
        $.ajax({

            url: "<?php echo site_url(); ?>/rccontroller/chkStatus",
            method: "POST",
            data: {
                "auth": auth,
                "id": mtxnid

            },
            success: function (data, status)
            {
                if (data == '1') {
                    alert('RECHARGE SUCCESSFULL');
                    location.href = "<?php echo site_url(); ?>/partner/transrecharge";
                } else if (data == '2') {
                    alert('RECHARGE PENDING CHECK AFTER 5 MIN');
                } else if (data == '3') {
                    alert('TRANSACTION FAILED');
                    location.href = "<?php echo site_url(); ?>/partner/transrecharge";
                } else {
                    alert('ERROR FROM SERVER');
                }
            }



        });
    }
</script>