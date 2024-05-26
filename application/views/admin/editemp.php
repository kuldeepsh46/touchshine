
<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Update Employee</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
										</div>
									</div>
									<?php $emp = $this->db->get_where('admin',array('id' => $id))->row(); ?>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0">
													<div class="card-header">
														<h4 class="card-title">Employee Details</h4>
													</div>
													<div class="card-body">
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Name</label>
																	<input type="text" value="<?php echo $emp->name; ?>" class="form-control" id="name" placeholder="Enter Name">
																</div>
															</div>
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Mobile</label>
																	<input disabled="" type="number" value="<?php echo $emp->phone; ?>" class="form-control" id="mobile" placeholder="Enter Mobile Number">
																</div>
															</div>
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Email</label>
																	<input disabled="" type="email" value="<?php echo $emp->email; ?>" class="form-control" id="email" placeholder="Enter Email">
																</div>
															</div>
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Username</label>
																	<input disabled="" type="text" value="<?php echo $emp->username; ?>" class="form-control" id="username" placeholder="Enter Username">
																</div>
															</div>
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Password</label>
																	<input type="text" value="<?php echo $emp->password; ?>" class="form-control" id="password" placeholder="Enter Password">
																</div>
															</div>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
												<div class="card  box-shadow-0 ">
													<div class="card-header">
														<h4 class="card-title">Employee Rights</h4>
													</div>
													<div class="card-body">
														<div class="row">
														    <div class="col-md-4">
														        <?php if($emp->menu_member == 1){ ?>
														        <input type="checkbox" checked="" value="1" id="menu_member">
														        <?php }else{ ?>
														        <input type="checkbox" value="1" id="menu_member">
														        <?php } ?>
														        Member
														    </div>
														    <div class="col-md-8">
														        <?php if($emp->add_whitelabel == 1){ ?>
														      <input type="checkbox" value="1" checked="" id="add_whitelabel">
														      <?php }else{ ?>
														      <input type="checkbox" value="1" id="add_whitelabel">
														      <?php } ?>
														      Add Whitelabel &nbsp;
														      <?php if($emp->list_whitelabel == 1){ ?>
														      <input type="checkbox" value="1" checked="" id="list_whitelabel">
														      <?php }else{ ?>
														      <input type="checkbox" value="1" id="list_whitelabel">
														      <?php } ?>
														      List Whitelabel &nbsp;
														      <?php if($emp->list_users == 1){ ?>
														      <input type="checkbox" checked="" value="1" id="list_users">
														      <?php }else{ ?>
														      <input type="checkbox" value="1" id="list_users">
														      <?php } ?>
														      List User &nbsp;
														    </div>
														</div>
														<hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <?php if($emp->menu_wallet == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="menu_wallet">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="menu_wallet">
    														        <?php } ?>
    														        Wallet
    														    </div>
    														    <div class="col-md-8">
    														        <?php if($emp->wallet == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="wallet">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="wallet">
    														        <?php } ?>
    														        Wallet &nbsp;
    														        <?php if($emp->credit == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="credit">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="credit">
    														        <?php } ?>
    														        Credit Fund &nbsp;
    														        <?php if($emp->debit == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="debit">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="debit">
    														        <?php } ?>
    														        Debit Fund &nbsp;
    														    </div>
														    </div>
														    <hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <?php if($emp->menu_transactions == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="menu_transactions">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="menu_transactions">
    														        <?php } ?>
    														        Transactions
    														    </div>
    														    <div class="col-md-8">
    														        <?php if($emp->iaeps == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="iaeps">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="iaeps">
    														        <?php } ?>
    														        AePS ICICI &nbsp;
    														        <?php if($emp->naeps == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="naeps">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="naeps">
    														        <?php } ?>
    														        AePS Indus &nbsp;
    														        <?php if($emp->bbps == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="bbps">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="bbps">
    														        <?php } ?>
    														        BBPS &nbsp;
    														        <?php if($emp->recharge == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="recharge">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="recharge">
    														        <?php } ?>
    														        Recharge &nbsp;
    														        <?php if($emp->dmt == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="dmt">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="dmt">
    														        <?php } ?>
    														        DMT &nbsp;
    														        <?php if($emp->payout == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="payout">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="payout">
    														        <?php } ?>
    														        Payout &nbsp;
    														        <?php if($emp->qtransfer == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="qtransfer">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="qtransfer">
    														        <?php } ?>
    														        Quick Transfer &nbsp;
    														        <?php if($emp->preg == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="preg">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="preg">
    														        <?php } ?>
    														        Pan Registration &nbsp;
    														        <?php if($emp->pcopon == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="pcopon">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="pcopon">
    														        <?php } ?>
    														        Pan Coupon &nbsp;
    														    </div>
														    </div>
														    <hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <?php if($emp->menu_setting == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="menu_setting">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="menu_setting">
    														        <?php } ?>
    														        Settings
    														    </div>
    														    <div class="col-md-8">
    														        <?php if($emp->pkg == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="pkg">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="pkg">
    														        <?php } ?>
    														        Package &nbsp;
    														        <?php if($emp->commission == 1){ ?>
    														        <input type="checkbox" value="1" checked="" id="commission">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="commission">
    														        <?php } ?>
    														        Commission &nbsp;
    														        <?php if($emp->manage_service == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="manage_service">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="manage_service">
    														        <?php } ?>
    														        Manage Service &nbsp;
    														        <?php if($emp->change_payout == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="change_payout">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="change_payout">
    														        <?php } ?>
    														        Change Payout &nbsp;
    														        <?php if($emp->news == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="news">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="news">
    														        <?php } ?>
    														        News &nbsp;
    														    </div>
														    </div>
														    <hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <?php if($emp->menu_validation == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="menu_validation">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="menu_validation">
    														        <?php } ?>
    														        Validation
    														    </div>
    														    <div class="col-md-8">
    														        <?php if($emp->icicikyc == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="icicikyc">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="icicikyc">
    														        <?php } ?>
    														        ICICI Kyc &nbsp;
    														        <?php if($emp->verifyacp == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="verifyacp">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="verifyacp">
    														        <?php } ?>
    														        Verify Acc & Pan &nbsp;
    														    </div>
														    </div>
														    <hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <?php if($emp->menu_emp == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="menu_emp">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="menu_emp">
    														        <?php } ?>
    														        Employee Management
    														    </div>
    														    <div class="col-md-8">
    														        <?php if($emp->add_emp == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="add_emp">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="add_emp">
    														        <?php } ?>
    														        Add Employee &nbsp;
    														        <?php if($emp->view_emp == 1){ ?>
    														        <input type="checkbox" checked="" value="1" id="view_emp">
    														        <?php }else{ ?>
    														        <input type="checkbox" value="1" id="view_emp">
    														        <?php } ?>
    														        View Employee &nbsp;
    														    </div>
														    </div>
													</div>
												</div>
											</div>
											
										</div>
										
										<div class="row">

											    <button type="submit" class="btn btn-primary col-lg-6 col-xl-12 col-md-12 col-sm-12" onclick="addemp();" id="empbtn">Update Employee</button>

										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
						<input type="hidden" value="<?php echo $id; ?>" id="id">
<script>
    
     function addemp()
    {
        
    document.getElementById("empbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#empbtn').html(dat);
        var name = $("#name").val();
        var id = $("#id").val();
        var mobile = $("#mobile").val();
        var email = $("#email").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var menu_member = (document.getElementById("menu_member").checked)?"1":"0";
        var add_whitelabel = (document.getElementById("add_whitelabel").checked)?"1":"0";
        var list_whitelabel = (document.getElementById("list_whitelabel").checked)?"1":"0";
        var list_users = (document.getElementById("list_users").checked)?"1":"0";
        var menu_wallet = (document.getElementById("menu_wallet").checked)?"1":"0";
        var wallet = (document.getElementById("wallet").checked)?"1":"0";
        var credit = (document.getElementById("credit").checked)?"1":"0";
        var debit = (document.getElementById("debit").checked)?"1":"0";
        var menu_transactions = (document.getElementById("menu_transactions").checked)?"1":"0";
        var iaeps = (document.getElementById("iaeps").checked)?"1":"0";
        var naeps = (document.getElementById("naeps").checked)?"1":"0";
        var bbps = (document.getElementById("bbps").checked)?"1":"0";
        var recharge = (document.getElementById("recharge").checked)?"1":"0";
        var dmt = (document.getElementById("dmt").checked)?"1":"0";
        var payout = (document.getElementById("payout").checked)?"1":"0";
        var qtransfer = (document.getElementById("qtransfer").checked)?"1":"0";
        var preg = (document.getElementById("preg").checked)?"1":"0";
        var pcopon = (document.getElementById("pcopon").checked)?"1":"0";
        var menu_setting = (document.getElementById("menu_setting").checked)?"1":"0";
        var pkg = (document.getElementById("pkg").checked)?"1":"0";
        var commission = (document.getElementById("commission").checked)?"1":"0";
        var manage_service = (document.getElementById("manage_service").checked)?"1":"0";
        var change_payout = (document.getElementById("change_payout").checked)?"1":"0";
        var news = (document.getElementById("news").checked)?"1":"0";
        var menu_validation = (document.getElementById("menu_validation").checked)?"1":"0";
        var icicikyc = (document.getElementById("icicikyc").checked)?"1":"0";
        var verifyacp = (document.getElementById("verifyacp").checked)?"1":"0";
        var menu_emp = (document.getElementById("menu_emp").checked)?"1":"0";
        var add_emp = (document.getElementById("add_emp").checked)?"1":"0";
        var view_emp = (document.getElementById("view_emp").checked)?"1":"0";
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/editempreg",
            method : "POST",
            data : {
                "id" : id,
                "name" : name,
                "mobile" : mobile,
                "email" : email,
                "username" : username,
                "password" : password,
                "menu_member" : menu_member,
                "add_whitelabel" : add_whitelabel,
                "list_whitelabel" : list_whitelabel,
                "list_users" : list_users,
                "menu_wallet" : menu_wallet,
                "wallet" : wallet,
                "credit" : credit,
                "debit" : debit,
                "menu_transactions" : menu_transactions,
                "iaeps" : iaeps,
                "naeps" : naeps,
                "bbps" : bbps,
                "recharge" : recharge,
                "dmt" : dmt,
                "payout" : payout,
                "qtransfer" : qtransfer,
                "preg" : preg,
                "pcopon" : pcopon,
                "menu_setting" : menu_setting,
                "pkg" : pkg,
                "commission" : commission,
                "manage_service" : manage_service,
                "change_payout" : change_payout,
                "news" : news,
                "menu_validation" : menu_validation,
                "icicikyc" : icicikyc,
                "verifyacp" : verifyacp,
                "menu_emp" : menu_emp,
                "add_emp" : add_emp,
                "view_emp" : view_emp,
                "auth" : auth
            },
            success:function(data,status)
            {
            document.getElementById("empbtn").disabled = false;
            var dat = 'Add Employee';
            $('#empbtn').html(dat);
                if(data  == 1)
                {
                    alert("EMPLOYEE UPDATED SUCCESSFULL");
                    location.href="/admin/viewemp";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }
    
</script>

