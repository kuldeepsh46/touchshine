
						<!-- row opened -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
										<div class="table-responsive">
											<table id="example" class="table table-bordered key-buttons text-nowrap">
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">MEMBER ID</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">ACCOUNT NUMBER</th>
														<th class="border-bottom-0">IFSC</th>
														<th class="border-bottom-0">PASSBOOK</th>
														<th class="border-bottom-0">ACTION</th>
													</tr>
												</thead>
												<?php  
												$site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
												$data = $this->db->from("payoutaccount")->where("site",$site)->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $this->db->get_where('users',array('id' => $dat->uid))->row()->username; ?></td>
														<td><?php echo $dat->name; ?></td>
														<td><?php echo $dat->account; ?></td>
														<td><?php echo $dat->ifsc; ?></td>
														<td><a href="<?php echo $dat->passbook; ?>" target="_blank"><button class="btn btn-primary">VIEW PASSBOOK</button></a></td>
														<td><?php if($dat->status == "APPROVED"){ ?> <button class="btn btn-Green">APPROVED</button>     <button class="btn btn-danger" onclick="reject('<?php echo $dat->id; ?>');" id="rjbtn">DELETE</button>  <?php }else{ ?><button class="btn btn-yellow" onclick="approve('<?php echo $dat->id; ?>');" id="apbtn">APPROVE</button>  <button class="btn btn-danger" onclick="reject('<?php echo $dat->id; ?>');" id="rjbtn">REJECT</button> <?php } ?>  </td>
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
						
						<!-- Modal -->
<div class="modal fade" id="exampleModalnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="exampleModalnewd">
      
    </div>
  </div>
</div>
						
<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
<script>
     function reject(bid)
           {
          var auth = $("#auth").val();
          $.ajax({
                  url : "/partner/rejectpayaccount",
                  method : "POST",
                  data : {
                       "auth" : auth,
                       "bid" : bid
                  },
                  success:function(data,status)
                  {
                        if(data  == 1)
                        {
                            alert("ACCOUNT DELETED SUCCESS");
                            location.href="/partner/approvepayout";
                        }
                        if(data  != 1)
                        {
                            alert(data);
                        }
                  }
             });
           }
           function approve(bid)
            {
                var auth = $("#auth").val();
                $.ajax({
                    url : "/partner/approvepayaccount",
                    method : "POST",
                    data : {
                        "auth" : auth,
                        "bid" : bid
                    },
                    success:function(data,status)
                    {
                        if(data  == 1)
                        {
                            alert("INVALID TOKEN");
                        }else{
                            $("#exampleModalnew").modal("show");
                            $("#exampleModalnewd").html(data);
                        }
                    }
                });
            }
            
         
           
</script>
						
