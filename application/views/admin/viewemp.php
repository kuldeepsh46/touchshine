<?php $this->load->view('admin/header'); ?>

<!-- row opened -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">File export Datatable</div>
										<div class="card-options">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">USERNAME</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">MOBILE</th>
														<th class="border-bottom-0">EMAIL</th>
														<th class="border-bottom-0">PASSWARD</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
												<?php  
												$data = $this->db->get_where('admin',array('type' => '1'))->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $dat->username; ?></td>
														<td><?php echo $dat->name; ?></td>
														<td><?php echo $dat->phone; ?></td>
														<td><?php echo $dat->email; ?></td>
														<td><?php echo $dat->password; ?></td>
														<td><button class="btn btn-primary btn-pill" onclick="viewdata('<?php echo $dat->id; ?>');" id="vbtn">Edit</button>  <button class="btn btn-danger btn-pill" onclick="dltemp('<?php echo $dat->id; ?>');" id="dbtn">Delete</button></td>
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
<div class="modal" tabindex="-1" role="dialog" id="info">
  <div class="modal-dialog" role="document" style="width: 75vw; float: left; margin-left: 12.5vw;">
    <div class="modal-content" style="width: 74vw; float: left; ">
      
      <div class="modal-body" id="infocont">

      </div>
     
    </div>
  </div>
</div>

<script>
    
  function viewdata(id)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/admin/viewempdata",
            method : "POST",
            data : {
                "auth" : auth,
                "id" : id
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                }else{
                    $("#info").modal("show");
                    $("#infocont").html(data);
                }
            }
        });
    } 
      function dltemp(id)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/admin/dltempdata",
            method : "POST",
            data : {
                "auth" : auth,
                "id" : id
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    alert("EMPLOYEE DELETED SUCCESSFULL");
                    location.href="/admin/viewemp";
                    
                }else{
                    alert(data);
                }
            }
        });
    } 
    
</script>

<?php $this->load->view('admin/footer'); ?>