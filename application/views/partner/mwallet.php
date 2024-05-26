<?php $this->load->view('partner/header'); ?>
<div id="info">
<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Member List</div>
										<div class="card-options">
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example-1" class="table table-striped table-bordered text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">USERNAME</th>
														<th class="border-bottom-0">Name</th>
														<th class="border-bottom-0">PHONE</th>
														<th class="border-bottom-0">Main WALLET</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
												<?php $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
												$data = $this->db->get_where('users',array('site' => $site))->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $dat->username; ?></td>
														<td><?php echo $dat->name; ?></td>
														<td><?php echo $dat->phone; ?></td>
														<td><?php echo $dat->main_wallet; ?></td>
														<td><button class="btn btn-primary" onclick="view('<?php echo $dat->id; ?>');">View</button></td>
														
														
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
							<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
<script>
    function view(vid)
    {
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/partner/viewmwallet",
            method : "POST",
            data : {
                "vid" : vid,
                "auth" : auth
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    alert('INVALID TOKEN');
                }
                if(data  != 1)
                {
                    $("#info").html(data);
                    var i = setInterval(() => {
                         $('.fc-datepicker').datepicker({
	 showOtherMonths: true,
	 selectOtherMonths: true
   });
   clearInterval(i);
                    });
                }
            }
        });
    }
</script>
<?php $this->load->view('partner/footer'); ?>