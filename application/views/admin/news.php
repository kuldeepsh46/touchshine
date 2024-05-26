<?php $this->load->view('admin/header'); ?>

<!-- row opened -->
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">News</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-12 col-md-12">
												<form class="form-horizontal" >
													<div class="form-group row">
														<label class="col-md-3 col-form-label">News</label>
														<div class="col-md-9">
														    <input type="text" value="<?php echo $this->db->get_where('settings',array('name' => 'news'))->row()->value; ?>" id="news" class="form-control">
														</div>
														<div class="col-md-9">
														    <button class="btn btn-primary" onclick="update();" id="upbtn">Update News</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
						<!-- row closed -->
<script>
    
    function update()
    {
        
document.getElementById("upbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
$('#upbtn').html(dat);
        var news = $("#news").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/updatenews",
            method : "POST",
            data : {
                "news" : news,
                "auth" : auth
            },
            success:function(data,status)
            {
                
                
document.getElementById("upbtn").disabled = false;
var dat = 'Update';
$('#upbtn').html(dat);
                if(data  == 1)
                {
                    alert("UPDATE SUCCESSFULL");
                    location.href="/admin/news";
                    
                }
                
                
                if(data  != 1)
                {
                    alert(data);
                    
                }
                
            }
            
            
        });
        
        
    }
    
    
</script>
<?php $this->load->view('admin/footer'); ?>