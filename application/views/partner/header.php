<?php
    $rid = $_SESSION['rid'];
    $user = $this->db->get_where('reseller',array('id' => $rid))->row();
    $sql="SELECT ROUND(SUM(wallet),2) AS tot_user_wallet FROM `users` WHERE site=$rid ";
    $qsw=$this->db->query($sql);
    $uwallet=$qsw->row()->tot_user_wallet;
	
	$sql1="SELECT ROUND(SUM(main_wallet),2) AS tot_user_wallet FROM `users` WHERE site=$rid ";
    $qsw1=$this->db->query($sql1);
    $muwallet=$qsw1->row()->tot_user_wallet;
   
?>
<?php $mai = $this->db->get_where('settings',array('name' => 'main'))->row()->value; ?>
<?php if($mai == 1){ $this->load->view('error'); exit(); }  ?>
<html lang="en" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta content="Dashlot - Bootstrap Responsive Admin panel Dashboard Template Ui Kit & Premium Dashboard Design Modern Flat HTML Template. This Template Includes 100 HTML Pages & 40+ Plugins. No Need to do hard work for this template customization." name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin template,bootstrap 4 templates,bootstrap admin template,bootstrap dashboard,bootstrap form template,premium,html5,admin dashboard template,admin panel template,bootstrap 4 admin template,bootstrap 4 dashboard,\nbootstrap admin dashboard,bootstrap dashboard template,dashboard bootstrap 4,dashboard ui kit,html admin template,html dashboard template,template admin bootstrap 4">

		<!-- Favicon-->
		<link rel="icon" href="<?php echo $logo; ?>" type="image/x-icon"/>

		<!-- Title -->
		<title><?php echo $title; ?></title>

		<!-- Bootstrap css -->
		<link href="/assets/plugins/bootstrap-4.1.3/css/bootstrap.min.css" rel="stylesheet" />

		<!-- Style css -->
		<link  href="/assets/css/style.css" rel="stylesheet" />

		<!-- Default css -->
		<link href="/assets/css/default.css" rel="stylesheet">

		<!-- Sidemenu css-->
		<link rel="stylesheet" href="/assets/css/closed-sidemenu.css">

		<!-- Owl-carousel css-->
		<link href="/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />

		<!-- Bootstrap-daterangepicker css -->
		<link rel="stylesheet" href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css">

		<!-- Bootstrap-datepicker css -->
		<link rel="stylesheet" href="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css">
        
		<!-- Custom scroll bar css -->
		<link href="/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!-- P-scroll css -->
		<link href="/assets/plugins/p-scroll/p-scroll.css" rel="stylesheet" type="text/css">

		<!-- Font-icons css -->
		<link  href="/assets/css/icons.css" rel="stylesheet">

		<!-- Rightsidebar css -->
		<link href="/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- Nice-select css  -->
		<link href="/assets/plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet"/>

		<!-- Color-palette css-->
		<link rel="stylesheet" href="/assets/css/skins.css"/>
        
        <!-- Data table css -->
		<link href="/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
		<link href="/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/assets/plugins/datatable/css/buttons.bootstrap4.min.css">
		<link href="/assets/plugins/datatable/responsive.bootstrap4.min.css" rel="stylesheet" />
        
        
        
        
	</head>

	<body class="sidebar-mini2 app sidebar-mini">

		<!-- Loader -->
		<div id="loading">
			<img src="/assets/images/other/loader.svg" class="loader-img" alt="Loader">
		</div>

		<!-- PAGE -->
		<div id="app" class="page">
			<div class="page-main">

				<!-- Top-header opened -->
				<div class="header-main header sticky">
					<div class="app-header header top-header navbar-collapse ">
						<div class="container-fluid">
							<div class="d-flex">
								<a class="header-brand" href="/partner">
									<img src="<?php echo $logo; ?>" alt="<?php echo $title; ?>" width="150" height="61">
								</a>
								<a href="#" data-toggle="sidebar" class="nav-link icon toggle"><i class="fe fe-align-justify fs-20"></i></a>
								
								<div class="d-flex header-right ml-auto">
								    <div class="page-rightheader">
								<div class="ml-3 ml-auto d-flex">
									
								    
					<a "style: margin-right: 1em"; href="/partner/transwallet" class="btn btn-info ml-0 ml-md-4 mt-1 "><i class="typcn typcn-archive mr-1"></i>AEPS WALLET : Rs.<?php echo round($user->wallet,2); ?></a>
					<a "style: margin-right: 1em"; href="/partner/mainwallet" class="btn btn-info ml-0 ml-md-4 mt-1 "><i class="typcn typcn-archive mr-1"></i>MAIN WALLET : Rs.<?php echo round($user->main_wallet,2); ?></a>
								</div>
							</div>
											 
									<div class="dropdown header-fullscreen">
										<a class="nav-link icon full-screen-link" id="fullscreen-button">
											<i class="mdi mdi-arrow-collapse fs-20"></i>
										</a>
									</div><!-- Fullscreen -->
									<div class="" id="bs-example-navbar-collapse-1">
										<form class="navbar-form" role="search">
											<div class="input-group ">
												<input type="text" class="form-control" placeholder="Search.">
												<span class="input-group-btn">
													<button type="reset" class="btn btn-default">
														<i class="fa fa-times"></i>
													</button>
													<button type="submit" class="btn btn-default">
														<i class="fa fa-search"></i>
													</button>
												</span>
											</div>
										</form>
									</div><!-- Search -->
									
									
									
									
									<div class="dropdown drop-profile">
										<a class="nav-link pr-0 leading-none" href="#" data-toggle="dropdown" aria-expanded="false">
											<div class="profile-details mt-1">
												<span class="mr-3 mb-0  fs-15 font-weight-semibold"><?php echo $user->name; ?></span>
												<small class="text-muted mr-3">Partner</small>
											</div>
											<img class="avatar avatar-md brround" src="<?php echo $user->profile; ?>" alt="image">
										 </a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated bounceInDown w-250">
											<div class="user-profile bg-header-image border-bottom p-3">
												<div class="user-image text-center">
													<img class="user-images" src="<?php echo $user->profile; ?>" alt="image">
												</div>
												<div class="user-details text-center">
													<h4 class="mb-0"><?php echo $user->name; ?></h4>
													<p class="mb-1 fs-13 text-white-50"><?php echo $user->email; ?></p>
												</div>
											</div>
											<a class="dropdown-item" href="#">
												<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
											</a>
											<a class="dropdown-item" href="#">
												<i class="dropdown-icon  mdi mdi-settings"></i> Settings
											</a>
											
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="#">
												<i class="dropdown-icon mdi mdi-compass"></i> Need help?
											</a>
											<a class="dropdown-item mb-1" href="/partner/logout">
												<i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
											</a>
										</div>
									</div><!-- Profile -->
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Top-header closed -->

				<!-- Sidebar menu-->
				<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
				<aside class="app-sidebar toggle-sidebar">
					<div class="app-sidebar__user">
						<div class="user-body">
							<img src="<?php echo $user->profile; ?>" alt="profile-img" class="rounded-circle w-25">
						</div>
						<div class="user-info">
							<a href="#" class=""><span class="app-sidebar__user-name font-weight-semibold"><?php echo $user->name; ?></span><br>
								<span class="text-muted app-sidebar__user-designation text-sm">Partner</span>
							</a>
						</div>
					</div>
					<ul class="side-menu toggle-menu">
						<li class="slide">
							<a class="side-menu__item" href="/partner"><span class="icon-menu-img"><img src="/assets/images/svgs/homepage.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Dashboard</span><i class="angle fa fa-angle-right"></i></a>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/bitcoin-logo.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Members</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/partner/registration" class="slide-item">Add Member</a></li>
								<li><a href="/partner/memberlist" class="slide-item">List Member</a></li>
								<li><a href="/partner/userrequest" class="slide-item">User Request</a></li>
								<li><a href="/partner/movemember" class="slide-item">Move Member</a></li>
								<li><a href="/partner/upgrade" class="slide-item">Upgrade Member</a></li>
							</ul>
							<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/search.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Kyc Request</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
                                <li><a href="/partner/profilekyc" class="slide-item">Profile Kyc</a></li>
                                <li><a href="/partner/approvepayout" class="slide-item">Account Approval request</a></li>
							</ul>
						</li>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/testing.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Wallet</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/partner/wallet" class="slide-item">AEPS Wallet</a></li>
								<li><a href="/partner/mwallet" class="slide-item">Main Wallet</a></li>
								<li><a href="/partner/credit" class="slide-item">Credit Fund</a></li>
								<li><a href="/partner/debit" class="slide-item">Debit Fund</a></li>
								<li><a href="/partner/fundrequest" class="slide-item">Fund Request</a></li>
								<li><a href="/partner/lockamount" class="slide-item">Lock Amount</a></li>
								<li><a href="/partner/transwallet" class="slide-item">AEPS Ledger</a></li>
								<li><a href="/partner/mainwallet" class="slide-item">Main Ledger</a></li>
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/shopping-cart.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Transactions</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/partner/transiaeps" class="slide-item">Aeps Icici</a></li>
								<li><a href="/partner/transaeps" class="slide-item">AePS Indus</a></li>
								<li><a href="/partner/" class="slide-item">BBPS</a></li>
								<li><a href="/partner/transrecharge" class="slide-item">Recharge</a></li>
								<li><a href="/partner/transdmt" class="slide-item">DMT</a></li>
								<li><a href="/partner/transpayout" class="slide-item">Payout</a></li>
								<li><a href="/partner/transquick" class="slide-item">Quick Transfer</a></li>
								<li><a href="/partner/transpanr" class="slide-item">Pan Registration</a></li>
								<li><a href="/partner/transpanrc" class="slide-item">Pan Coupon</a></li>
								<li><a href="/partner/transcredit" class="slide-item">Credit Fund</a></li>
								<li><a href="/partner/transdebit" class="slide-item">Debit Fund</a></li>
								<li><a href="/partner/topuphistory" class="slide-item">Topup History</a></li>
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/search.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Setting</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/partner/package" class="slide-item">Package</a></li>
								<li><a href="/partner/commission" class="slide-item">Commission & Charges</a></li>
								<li><a href="/partner/manageservice" class="slide-item">Manage Service</a></li>
								<li><a href="/partner/regfees" class="slide-item">Registration Fees</a></li>
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/search.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Manage Website</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/partner/manageservice" class="slide-item">Manage Service</a></li>
								<li><a href="/partner/news" class="slide-item">News</a></li>
							</ul>
						</li>
						
						
						
						
					</ul>
				</aside>
				<!-- Sidemenu closed -->

				<!-- App-content opened -->
				<div class="app-content icon-content">
					<div class="section">
					    
					    <?php
					    $curDate=date('Y-m-d');
					    $curMonth=date('m');
					    $curYear=date('Y');
					    $ptoday=$this->db->query("SELECT Round((SUM(opening)-SUM(closing)),2) AS profit_today FROM `rtransaction` WHERE rid=$rid AND DATE(date)='$curDate' ")->row()->profit_today;
					    $pmn=$this->db->query("SELECT Round((SUM(opening)-SUM(closing)),2) AS profit_cm FROM `rtransaction` WHERE rid=$rid AND YEAR(date)='$curYear' AND MONTH(date)='$curMonth' ")->row()->profit_cm;
					   
					    ?>

						<!-- Page-header opened -->
						<div class="page-header">
							<div class="page-leftheader">
							
							<a "style: margin-right: 1em"; href="/partner/wallet" class="btn btn-info ml-0 ml-md-4 mt-1 "><i class="typcn typcn-archive mr-1"></i> AEPS WALLET : Rs. <?php echo $uwallet;?></a>
							<a "style: margin-right: 1em"; href="/partner/mwallet" class="btn btn-info ml-0 ml-md-4 mt-1 "><i class="typcn typcn-archive mr-1"></i> Main WALLET : Rs. <?php echo $muwallet;?></a>
									</span>
								</div>
							</div>
						</div>
						<!-- Page-header closed -->
							<!-- Page-header opened -->
						<div class="page-header">
						    <marquee class="mb-0 fs-16 text-danger text-capitalize font-weight-bold">Dear All Partners Your All Service Is Working Fine</marquee>
						</div>
						<!-- Page-header closed -->


					

