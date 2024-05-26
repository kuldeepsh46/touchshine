<?php $this->load->view('admin/header'); ?>

<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Add Employee</div>
										<div class="card-options ">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
										</div>
									</div>
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
																	<input type="text" class="form-control" id="name" placeholder="Enter Name">
																</div>
															</div>
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Mobile</label>
																	<input type="number" class="form-control" id="mobile" placeholder="Enter Mobile Number">
																</div>
															</div>
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Email</label>
																	<input type="email" class="form-control" id="email" placeholder="Enter Email">
																</div>
															</div>
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Username</label>
																	<input type="text" class="form-control" id="username" placeholder="Enter Username">
																</div>
															</div>
															<div class="">
																<div class="form-group">
																	<label for="exampleInputEmail1">Password</label>
																	<input type="text" class="form-control" id="password" placeholder="Enter Password">
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
														        <input type="checkbox" value="1" id="menu_member"> Member
														    </div>
														    <div class="col-md-8">
														      <input type="checkbox" value="1" id="add_whitelabel"> Add Whitelabel &nbsp;
														      <input type="checkbox" value="1" id="list_whitelabel"> List Whitelabel &nbsp;
														      <input type="checkbox" value="1" id="list_users"> List User &nbsp;
														    </div>
														</div>
														<hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <input type="checkbox" value="1" id="menu_wallet"> Wallet
    														    </div>
    														    <div class="col-md-8">
    														        <input type="checkbox" value="1" id="wallet"> Wallet &nbsp;
    														        <input type="checkbox" value="1" id="credit"> Credit Fund &nbsp;
    														        <input type="checkbox" value="1" id="debit"> Debit Fund &nbsp;
    														    </div>
														    </div>
														    <hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <input type="checkbox" value="1" id="menu_transactions"> Transactions
    														    </div>
    														    <div class="col-md-8">
    														        <input type="checkbox" value="1" id="iaeps"> AePS ICICI &nbsp;
    														        <input type="checkbox" value="1" id="naeps"> AePS Indus &nbsp;
    														        <input type="checkbox" value="1" id="bbps"> BBPS &nbsp;
    														        <input type="checkbox" value="1" id="recharge"> Recharge &nbsp;
    														        <input type="checkbox" value="1" id="dmt"> DMT &nbsp;
    														        <input type="checkbox" value="1" id="payout"> Payout &nbsp;
    														        <input type="checkbox" value="1" id="qtransfer"> Quick Transfer &nbsp;
    														        <input type="checkbox" value="1" id="preg"> Pan Registration &nbsp;
    														        <input type="checkbox" value="1" id="pcopon"> Pan Coupon &nbsp;
    														    </div>
														    </div>
														    <hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <input type="checkbox" value="1" id="menu_setting"> Settings
    														    </div>
    														    <div class="col-md-8">
    														        <input type="checkbox" value="1" id="pkg"> Package &nbsp;
    														        <input type="checkbox" value="1" id="commission"> Commission &nbsp;
    														        <input type="checkbox" value="1" id="manage_service"> Manage Service &nbsp;
    														        <input type="checkbox" value="1" id="change_payout"> Change Payout &nbsp;
    														        <input type="checkbox" value="1" id="news"> News &nbsp;
    														    </div>
														    </div>
														    <hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <input type="checkbox" value="1" id="menu_validation"> Validation
    														    </div>
    														    <div class="col-md-8">
    														        <input type="checkbox" value="1" id="icicikyc"> ICICI Kyc &nbsp;
    														        <input type="checkbox" value="1" id="verifyacp"> Verify Acc & Pan &nbsp;
    														    </div>
														    </div>
														    <hr>
														   <div class="row">
    														    <div class="col-md-4">
    														        <input type="checkbox" value="1" id="menu_emp"> Employee Management
    														    </div>
    														    <div class="col-md-8">
    														        <input type="checkbox" value="1" id="add_emp"> Add Employee &nbsp;
    														        <input type="checkbox" value="1" id="view_emp"> View Employee &nbsp;
    														    </div>
														    </div>
													</div>
												</div>
											</div>
											
										</div>
										
										<div class="row">

											    <button type="submit" class="btn btn-primary col-lg-6 col-xl-12 col-md-12 col-sm-12" onclick="addemp();" id="empbtn">Add Employee</button>

										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
<script>
    
     function addemp()
    {
        
    document.getElementById("empbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#empbtn').html(dat);
        var name = $("#name").val();
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
            url : "/admin/addempreg",
            method : "POST",
            data : {
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
                    alert("EMPLOYEE ADD SUCCESSFULL");
                    location.href="/admin/addemp";
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