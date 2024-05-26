<?php $this->load->view('partner/header'); ?>



						<!-- row opened -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">User Request</div>
										<div class="card-options">

										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">MEMBERID</th>
														<th class="border-bottom-0">AMOUNT</th>
														<th class="border-bottom-0">rrn</th>
														<th class="border-bottom-0">Txn Date</th>
														<th class="border-bottom-0">txnid</th>
														<th class="border-bottom-0">Proof</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
												<?php $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
												$this->db->where('site',$site);
												$data = $this->db->get('topup')->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->username; ?></td>
														<td><?php echo $dat->amount; ?></td>
														<td><?php echo $dat->rrn; ?></td>
														<td><?php echo $dat->transaction_date; ?></td>
														<td><?php echo $dat->txnid; ?></td>
														<td><a href="<?php echo $dat->proof; ?>" target="_blank"><button class="btn btn-primary btn-pill">Proof</button></a></td>
														<td><?php if($dat->status == "PENDING") { ?>
														<button class="btn btn-primary btn-pill" onclick="approve('<?php echo $dat->id; ?>');" id="apbtn">Approve</button>   <button class="btn btn-danger btn-pill" onclick="reject('<?php echo $dat->id; ?>');" id="rjbtn">Reject</button>
														<?php }else{ ?>
														<?php echo $dat->status; } ?>
														</td>
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

<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
<div id="info" class="modal fade" role="dialog">
<div class="modal-dialog" id="infocont">
    
    
    
</div>
</div>

<script>
   function approve(rid)
    {
        
        document.getElementById("apbtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#apbtn').html(dat);
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/approvefund",
            method : "POST",
            data : {
                "rid" : rid,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("apbtn").disabled = false;
                var dat = 'Approve';
                $('#apbtn').html(dat);
                if(data  == 1)
                {
                    alert("Approved");
                    location.href="/partner/fundrequest";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }
    function reject(rid)
    {
        
        document.getElementById("rjbtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#rjbtn').html(dat);
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/rejectfund",
            method : "POST",
            data : {
                "rid" : rid,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("rjbtn").disabled = false;
                var dat = 'Reject';
                $('#rjbtn').html(dat);
                if(data  == 1)
                {
                    alert("Rejected");
                    location.href="/partner/fundrequest";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }
</script>





<?php $this->load->view('partner/footer'); ?>