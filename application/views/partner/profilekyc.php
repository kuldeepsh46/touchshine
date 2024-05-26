
						<div class="row">
							<div class="col-md-12 col-lg-12">
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">MEMBER ID</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">MOBILE</th>
														<th class="border-bottom-0">STATUS</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
												<?php  $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
												$data = $this->db->from("kyc")->where("site",$site)->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result();
												 ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
													    <?php $user = $this->db->get_where('users',array('id' => $dat->uid))->row(); ?>
														<td><?php echo $ind; ?></td>
														<td><?php echo $user->username; ?></td>
														<td><?php echo $user->name; ?></td>
														<td><?php echo $user->phone; ?></td>
														<td><?php if($dat->active == "1"){ echo "APPROVED"; }else{if($dat->active == "0") {echo "PENDING";}else{ echo "INCOMPLETE";} }?></td>
														<td>
														    <?php if($dat->active =="1" || $dat->active =="0"){?>
														    <button class="btn btn-primary" onclick="view('<?php echo $dat->id; ?>');" id="vbtn<?php echo $dat->id; ?>">View</button>
														    <?php }else{ ?>
														    <button class="btn btn-primary" onclick="alert('KYC Not Completed!');" id="vbtn<?php echo $dat->id; ?>">View</button>
														    <?php }?>
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
    function view(kid)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/viewprofilekyc",
            method : "POST",
            data : {
                "auth" : auth,
                "kid" : kid
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                }else{
                    if(data == 5){
                        alert("PLEASE SEND ALL DATA");
                    }else{
                        $("#info").modal("show");
                        $("#infocont").html(data);
                    }
                }
            }
        });
    }
</script>
