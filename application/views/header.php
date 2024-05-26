<?php
    $uid = $_SESSION['uid'];
    $user = $this->db->get_where('users',array('id' => $uid))->row();
    $site = $this->db->get_where('sites',array('id' => $user->site))->row();
    $kyc_chk = $this->db->get_where("kyc",array('uid' => $uid))->num_rows();
    if($kyc_chk!=0){
    
    $kyc = $this->db->get_where('kyc',array('uid' => $_SESSION['uid']))->row();
            if($kyc->active!="1"){
                redirect('main/kyc_data');
            }
    }else{
      redirect('main/kyc');exit;  
    }
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
        <style rel="stylesheet">
            @media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
}



        </style>
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
								<a class="header-brand" href="index.php">
								    <img src="<?php echo $logo; ?>" alt="<?php echo $title; ?>" width="150" height="61">

								</a>
								<a href="#" data-toggle="sidebar" class="nav-link icon toggle"><i class="fe fe-align-justify fs-20"></i></a>
								
								<div class="d-flex header-right ml-auto">
								    <div class="page-rightheader">
								<div class="ml-3 ml-auto d-flex">
									
									
									<span class="mt-3 mt-md-0 pg-header">
										<a href="/transaction/ledger" class="btn btn-info ml-0 ml-md-4 mt-1 "><i class="typcn typcn-archive mr-1"></i>AEPS WALLET : Rs.<?php if($user->lamount == ""){$lamount = 0;}else{$lamount = $user->lamount;}  $wallet = $user->wallet + $lamount; echo round($wallet,2); ?></a>
									</span>
									<span class="mt-3 mt-md-0 pg-header">
										<a href="/transaction/mwledger" class="btn btn-info ml-0 ml-md-4 mt-1 "><i class="typcn typcn-archive mr-1"></i>MAIN WALLET : Rs.<?php if($user->lamount == ""){$lamount = 0;}else{$lamount = $user->lamount;}  $main_wallet = $user->main_wallet + $lamount; echo round($main_wallet,2); ?></a>
									</span>
									<span class="mt-3 mt-md-0 pg-header">
										<a href="/main/topup" class="btn btn-primary ml-0 ml-md-4 mt-1 "><i class="typcn typcn-archive mr-1"></i>Add Money</a>
									</span>
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
												<small class="text-muted mr-3"><?php echo $this->db->get_Where('role',array('id' => $user->role))->row()->name; ?></small>
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
											<a class="dropdown-item" href="/main/profile">
												<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
											</a>
											<a class="dropdown-item" href="/main/setting">
												<i class="dropdown-icon  mdi mdi-settings"></i> Settings
											</a>
											
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="">
												<i class="dropdown-icon mdi mdi-compass"></i> MY Commission
											</a>
											<a class="dropdown-item mb-1" href="/main/logout">
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
								<span class="text-muted app-sidebar__user-designation text-sm"><?php echo $this->db->get_Where('role',array('id' => $user->role))->row()->name; ?></span>
							</a>
						</div>
					</div>
					<ul class="side-menu toggle-menu">
						<li class="slide">
							<a class="side-menu__item" href="/"><span class="icon-menu-img"><img src="/assets/images/svgs/homepage.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Dashboard</span><i class="angle fa fa-angle-right"></i></a>
						</li>
						<?php if($user->role != 5) { ?>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/bitcoin-logo.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Members</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/main/registration" class="slide-item">Registration</a></li>
								<li><a href="/main/listmember" class="slide-item">Member List</a></li>
							</ul>
							</li>
							<?php } ?>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/email.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Wallet</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/transaction/ledger" class="slide-item">Wallet History</a></li>
								<li><a href="/main/addfund" class="slide-item">Add Fund Request</a></li>
								<li><a href="/main/topup" class="slide-item">Add Topup</a></li>
								<li><a href="/transaction/topupledger" class="slide-item">Topup History</a></li>
								<li><a href="/main/wallettransfer" class="slide-item">Wallet Transfer</a></li>
							</ul>
						</li>
						
						
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/bitcoin-logo.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Recharge</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/recharge" class="slide-item">Panel</a></li>
								<li><a href="/transaction/recharge" class="slide-item">History</a></li>
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/testing.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">BBPS</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="bbps" class="slide-item">Panel</a></li>
								<li><a href="#" class="slide-item">History</a></li>
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/bars-graphic.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">AEPS Panel</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/pwaeps" class="slide-item">Aeps Panel</a></li>
								<li><a href="/transaction/naeps" class="slide-item">History</a></li>
								
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/shopping-cart.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Money Transfer</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/dmr" class="slide-item">Send Money</a></li>
								<li><a href="/transaction/dmr" class="slide-item">History</a></li>
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/writing.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Quick Transfer</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/qtransfer" class="slide-item">Send Money</a></li>
								<li><a href="/transaction/qtransfer" class="slide-item">History</a></li>
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/email.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Payout</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/payout" class="slide-item">Payout</a></li>
								<li><a href="/transaction/payout" class="slide-item">History</a></li>
							</ul>
						</li>
						
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/search.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Pan Card</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="/main/pan" class="slide-item">PAN Panel</a></li>
								<li><a href="/transaction/pan" class="slide-item">History</a></li>
							</ul>
						</li>

						
						
						
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/happy.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Offline Services</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="#" class="slide-item">Demo</a></li>
							</ul>
						</li>
						
					</ul>
				</aside>
				<!-- Sidemenu closed -->

				<!-- App-content opened -->
				<div class="app-content icon-content">
					<div class="section">

						<!-- Page-header opened -->
						<div class="page-header">
						    <marquee class="mb-0 fs-16 text-danger text-capitalize font-weight-bold"><?php echo $site->news; ?></marquee>
						</div>
						<!-- Page-header closed -->

					

