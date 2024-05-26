<?php $this->load->view('admin/header'); ?>
<div id="info">
<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Member List</div>
										<div class="card-options">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example-1" class="table table-striped table-bordered text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">USERNAME</th>
														<th class="border-bottom-0">EMAIL</th>
														<th class="border-bottom-0">PHONE</th>
														<th class="border-bottom-0">WALLET</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
												<?php 
												$data = $this->db->get('reseller')->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $dat->username; ?></td>
														<td><?php echo $dat->email; ?></td>
														<td><?php echo $dat->phone; ?></td>
														<td><?php echo $dat->wallet; ?></td>
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
            url : "/admin/viewwallet",
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
<?php $this->load->view('admin/footer'); ?>