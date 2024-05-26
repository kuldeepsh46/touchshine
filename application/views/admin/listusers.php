<?php $this->load->view('admin/header'); ?>
<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Deatils Display Data Table</div>
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
														<th class="border-bottom-0">MEMBER ID</th>
														<th class="border-bottom-0">NAME</th>
														<th class="border-bottom-0">MOBILE</th>
												     	<th class="border-bottom-0">Wallet</th>
														<th class="border-bottom-0">Package</th>
														<th class="border-bottom-0">Status</th>
														<th class="border-bottom-0">OWNER</th>
														<th class="border-bottom-0">Company</th>
														<th class="border-bottom-0">Action</th>
														
													</tr>
												</thead>
												<?php  
												$data = $this->db->get('users')->result(); ?>
												<tbody>
												    <?php $ind = 1; ?>
												    <?php foreach($data as $dat) : ?>
													<tr>
														<td><?php echo $ind; ?></td>
														<td><?php echo $dat->username; ?></td>
														<td><?php echo $dat->name; ?></td>
														<td><?php echo $dat->phone; ?></td>
														<td><?php echo $dat->wallet; ?></td>
														<td><?php echo $dat->package; ?></td>
														<td><?php if($dat->active == 1){ echo "Active"; } if($dat->active == 0){ echo "Deactive"; }?></td>
														<td><?php if($dat->owner == 0){ echo "ADMIN"; }else{ echo $this->db->get_where('users',array('id' => $dat->owner))->row()->username; } ?></td>
														<td><?php echo $dat->site; ?></td>
														<td> <button class="btn btn-primary" id="logbtn" onclick="login('<?php echo $dat->id; ?>');">Login</button> <button class="btn btn-primary" id="viewbtn" onclick="viewdata('<?php echo $dat->id; ?>');">View</button>    <button class="btn btn-warning" id="srcbtn" onclick="service('<?php echo $dat->id; ?>');">Service</button>    <button class="btn btn-secondary" id="edtbtn" onclick="editdata('<?php echo $dat->id; ?>');">Edit</button>    <button class="btn btn-success" id="crbtn" onclick="creditfund('<?php echo $dat->id; ?>');">Credit</button>    <button class="btn btn-danger" id="dbtbtn" onclick="debitfund('<?php echo $dat->id; ?>');">Debit</button></td>
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
							
								<div id="info" class="modal fade" role="dialog">
        <div class="modal-dialog" id="infocont">
            
            
            
        </div>
        </div>
							
							
<script>
    function viewdata(uid)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/admin/viewuser",
            method : "POST",
            data : {
                "auth" : auth,
                "uid" : uid
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
    function service(uid)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/admin/viewuserservice",
            method : "POST",
            data : {
                "auth" : auth,
                "uid" : uid
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
    
     function updateservice(uid)
    {
        
    document.getElementById("serbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#serbtn').html(dat);
        var recharge = (document.getElementById("recharge").checked)?"1":"0";
        var dmt = (document.getElementById("dmt").checked)?"1":"0";
        var aeps = (document.getElementById("aeps").checked)?"1":"0";
        var iaeps = (document.getElementById("iaeps").checked)?"1":"0";
        var qtransfer = (document.getElementById("qtransfer").checked)?"1":"0";
        var payout = (document.getElementById("payout").checked)?"1":"0";
        var uti = (document.getElementById("uti").checked)?"1":"0";
        var bbps = (document.getElementById("bbps").checked)?"1":"0";
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/updateserviceuser",
            method : "POST",
            data : {
                "uid" : uid,
                "recharge" : recharge,
                "dmt" : dmt,
                "aeps" : aeps,
                "iaeps" : iaeps,
                "bbps" : bbps,
                "qtransfer" : qtransfer,
                "payout" : payout,
                "uti" : uti,
                "auth" : auth
            },
            success:function(data,status)
            {
            document.getElementById("serbtn").disabled = false;
            var dat = 'Update';
            $('#serbtn').html(dat);
                if(data  == 1)
                {
                    alert("UPDATE SUCCESSFULL");
                    location.href="/admin/listusers";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }
    function editdata(uid)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/admin/edituser",
            method : "POST",
            data : {
                "auth" : auth,
                "uid" : uid
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
       function login(uid)
    {
        
    document.getElementById("logbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#logbtn').html(dat);
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/partner/loginuser",
            method : "POST",
            data : {
                "uid" : uid,
                "auth" : auth
            },
            success:function(data,status)
            {
            document.getElementById("logbtn").disabled = false;
            var dat = 'Login';
            $('#logbtn').html(dat);
                if(data  == 1)
                {
                    alert("LOGIN SUCCESSFULL");
                    location.href="/";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }
    function updatedata(uid)
    {
        
    document.getElementById("upbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#upbtn').html(dat);
        var name = $("#name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var active = (document.getElementById("active").checked)?"1":"0";
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/updatedatauser",
            method : "POST",
            data : {
                "uid" : uid,
                "name" : name,
                "email" : email,
                "phone" : phone,
                "active" : active,
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
                    location.href="/admin/listusers";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }
    function creditfund(uid)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/admin/creditviewuser",
            method : "POST",
            data : {
                "auth" : auth,
                "uid" : uid
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
    function creditverify(uid)
    {
        
    document.getElementById("cvrbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#cvrbtn').html(dat);
        var amount = $("#amount").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/updatecredituser",
            method : "POST",
            data : {
                "uid" : uid,
                "amount" : amount,
                "auth" : auth
            },
            success:function(data,status)
            {
            document.getElementById("cvrbtn").disabled = false;
            var dat = 'Credit Fund';
            $('#cvrbtn').html(dat);
                if(data  == 1)
                {
                    alert("FUND UPDATE SUCCESSFULL");
                    location.href="/admin/listusers";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }
    function debitfund(uid)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/admin/debitviewuser",
            method : "POST",
            data : {
                "auth" : auth,
                "uid" : uid
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
    function debitverify(uid)
    {
        
    document.getElementById("dvrbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#dvrbtn').html(dat);
        var amount = $("#amount").val();
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/updatedebituser",
            method : "POST",
            data : {
                "uid" : uid,
                "amount" : amount,
                "auth" : auth
            },
            success:function(data,status)
            {
            document.getElementById("dvrbtn").disabled = false;
            var dat = 'Debit Fund';
            $('#dvrbtn').html(dat);
                if(data  == 1)
                {
                    alert("FUND UPDATE SUCCESSFULL");
                    location.href="/admin/listusers";
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