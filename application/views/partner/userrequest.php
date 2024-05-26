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
														<th class="border-bottom-0">FIRST</th>
														<th class="border-bottom-0">LAST</th>
														<th class="border-bottom-0">MOBILE</th>
														<th class="border-bottom-0">EMAIL</th>
														<th class="border-bottom-0">ROLE</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
												<?php $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
												$this->db->where('site',$site);
												$data = $this->db->get('register')->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $dat->first; ?></td>
														<td><?php echo $dat->last; ?></td>
														<td><?php echo $dat->mobile; ?></td>
														<td><?php echo $dat->email; ?></td>
														<td><?php echo $this->db->get_where('role',array('id' => $dat->role))->row()->name; ?></td>
														<td><button class="btn btn-primary btn-pill" onclick="approve('<?php echo $dat->id; ?>');" id="apbtn">Approve</button>   <button class="btn btn-danger btn-pill" onclick="reject('<?php echo $dat->id; ?>');" id="rjbtn">Reject</button></td>
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
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
        $('#apbtn').html(dat);
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/approveuser",
            method : "POST",
            data : {
                "auth" : auth,
                "rid" : rid
            },
            success:function(data,status)
            {
                $('#apbtn').html(dat);
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                    document.getElementById("apbtn").disabled = false;
                    $('#apbtn').html("Approve");
                }else{
                    $("#info").modal("show");
                    $("#infocont").html(data);
                    document.getElementById("apbtn").disabled = false;
                    $('#apbtn').html("Approve");
                }
            }
        });
    }
    function verify()
    {
        
        document.getElementById("regverify").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#regverify').html(dat);
        var apackage = $("#apackage").val();
        var rid = $("#rid").val();
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/approveusers",
            method : "POST",
            data : {
                "apackage" : apackage,
                "rid" : rid,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("regverify").disabled = false;
                var dat = 'dorecharge';
                $('#regverify').html(dat);
                if(data  == 1)
                {
                    alert("Approved");
                    location.href="/partner/userrequest";
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
            url : "/partner/rejectusers",
            method : "POST",
            data : {
                "rid" : rid,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("rjbtn").disabled = false;
                var dat = 'dorecharge';
                $('#rjbtn').html(dat);
                if(data  == 1)
                {
                    alert("Rejected");
                    location.href="/partner/userrequest";
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