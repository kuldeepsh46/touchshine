
<?php
    $uid = $_SESSION['aid'];
    $user = $this->db->get_where('admin',array('id' => $uid))->row();
   
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
        
        
        <!-- Data table css -->
		<link href="/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
		<link href="/assets/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="/assets/plugins/datatable/css/buttons.bootstrap4.min.css">
		<link href="/assets/plugins/datatable/responsive.bootstrap4.min.css" rel="stylesheet" />
        
        <!--  Date-picker css -->
		<link href="/assets/plugins/date-picker/date-picker.css" rel="stylesheet"/>
        
		<!-- Nice-select css  -->
		<link href="/assets/plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet"/>

		<!-- Color-palette css-->
		<link rel="stylesheet" href="/assets/css/skins.css"/>

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
								<a class="header-brand" href="/admin">
									<img src="/uploads/icon/moonex.png" alt="<?php echo $title; ?>" width="150" height="61">
								</a>
								<a href="#" data-toggle="sidebar" class="nav-link icon toggle"><i class="fe fe-align-justify fs-20"></i></a>
								
								<div class="d-flex header-right ml-auto">
								    
									 
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
												<small class="text-muted mr-3">Admin</small>
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
											<a class="dropdown-item mb-1" href="/admin/logout">
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
								<span class="text-muted app-sidebar__user-designation text-sm">Admin</span>
							</a>
						</div>
					</div>
					<?php $data = $this->db->get_where('admin',array('id' => $_SESSION['aid']))->row(); ?>
					<ul class="side-menu toggle-menu">
						<li class="slide">
							<a class="side-menu__item" href="/admin"><span class="icon-menu-img"><img src="/assets/images/svgs/homepage.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Dashboard</span><i class="angle fa fa-angle-right"></i></a>
						</li>
						<?php if($data->menu_member == 1){ ?>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/bitcoin-logo.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Members</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							    <?php if($data->add_whitelabel == 1){ ?>
								<li><a href="/admin/registration" class="slide-item">Add Whitelabel</a></li>
								<?php } ?>
								<?php if($data->list_whitelabel == 1){ ?>
								<li><a href="/admin/listuser" class="slide-item">List Whitelabel</a></li>
								<?php } ?>
								<?php if($data->list_users == 1){ ?>
								<li><a href="/admin/listusers" class="slide-item">List Users</a></li>
								<?php } ?>
								
							</ul>
						</li>
						<?php } ?>
						<?php if($data->menu_wallet == 1){ ?>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/testing.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Wallet</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							    <?php if($data->wallet == 1){ ?>
								<li><a href="/admin/wallet" class="slide-item">Wallet</a></li>
								<?php } ?>
						        <?php if($data->credit == 1){ ?>
								<li><a href="/admin/credit" class="slide-item">Credit Fund</a></li>
								<?php } ?>
						        <?php if($data->debit == 1){ ?>
								<li><a href="/admin/debit" class="slide-item">Debit Fund</a></li>
								<?php } ?>
						        
							</ul>
						</li>
						<?php } ?>
						<?php if($data->menu_transactions == 1){ ?>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/shopping-cart.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Transactions</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
						        <?php if($data->naeps == 1){ ?>
						        <li><a href="<?php echo site_url('admin/aepslist')?>" class="slide-item">AePS Pending</a></li>
								<li><a href="/admin/transaeps" class="slide-item">AePS TXN</a></li>
								<?php } ?>
						        <?php if($data->bbps == 1){ ?>
								<li><a href="#" class="slide-item">BBPS</a></li>
								<?php } ?>
						        <?php if($data->recharge == 1){ ?>
								<li><a href="/admin/transrecharge" class="slide-item">Recharge</a></li>
								<?php } ?>
						        <?php if($data->dmt == 1){ ?>
								<li><a href="/admin/transdmt" class="slide-item">DMT</a></li>
								<?php } ?>
						        <?php if($data->menu_member == 1){ ?>
								<li><a href="/admin/transpayout" class="slide-item">Payout</a></li>
								<?php } ?>
						        <?php if($data->qtransfer == 1){ ?>
								<li><a href="/admin/transquick" class="slide-item">Quick Transfer</a></li>
								<?php } ?>
						        <?php if($data->preg == 1){ ?>
								<li><a href="/admin/transpanreg" class="slide-item">Pan Registration</a></li>
								<?php } ?>
						        <?php if($data->pcopon == 1){ ?>
								<li><a href="/admin/transpanc" class="slide-item">Pan Coupon</a></li>
								<?php } ?>
						        <li><a href="/admin/credittxn" class="slide-item">Credit Fund</a></li>
						        <li><a href="/admin/debittxn" class="slide-item">Debit Fund</a></li>
								<li><a href="/admin/topuphistory" class="slide-item">Topup History</a></li>
							</ul>
						</li>
						<?php } ?>
						<?php if($data->menu_setting == 1){ ?>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/search.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Setting</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
    							<?php if($data->pkg == 1){ ?>
    							<li><a href="/admin/package" class="slide-item">Package</a></li>
								<?php } ?>
						        <?php if($data->commission == 1){ ?>
								<li><a href="/admin/commission" class="slide-item">Commission & Charges</a></li>
								<?php } ?>
						        <?php if($data->manage_service == 1){ ?>
								<li><a href="/admin/manage" class="slide-item">Manage Service</a></li>
								<?php } ?>
						        <?php if($data->change_payout == 1){ ?>
								<li><a href="/admin/changepayout" class="slide-item">Change Payout Mode</a></li>
								<?php } ?>
						       <?php if($data->change_payout == 1){ ?>
								<li><a href="/admin/apisetting" class="slide-item">Change Recharge Mode</a></li>
								<?php } ?>
						        <?php if($data->news == 1){ ?>
								<li><a href="/admin/news" class="slide-item">News</a></li>
								<?php } ?>
						        
							</ul>
						</li>
						<?php } ?>
						<?php if($data->menu_validation == 1){ ?>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/writing.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Validation</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							    <?php if($data->icicikyc == 1){ ?>
								<li><a href="/admin/induskyc" class="slide-item">Indus Aeps Kyc</a></li>
								<?php } ?>
						        <?php if($data->verifyacp == 1){ ?>
								<li><a href="/admin/verifyacc" class="slide-item">Verify Account & pan</a></li>
								<?php } ?>
						        
							</ul>
						</li>
						<?php } ?>
						<?php if($data->menu_emp == 1){ ?>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#"><span class="icon-menu-img"><img src="/assets/images/svgs/login.svg" class="side_menu_img svg-1" alt="image"></span><span class="side-menu__label">Epployee Management</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							    <?php if($data->add_emp == 1){ ?>
								<li><a href="/admin/addemp" class="slide-item">Add Employee</a></li>
								<?php } ?>
						        <?php if($data->view_emp == 1){ ?>
								<li><a href="/admin/viewemp" class="slide-item">View Employee</a></li>
								<?php } ?>
						        
							</ul>
						</li>
						<?php } ?>

						
						
					</ul>
				</aside>
				<!-- Sidemenu closed -->

				<!-- App-content opened -->
				<div class="app-content icon-content">
					<div class="section">

						<!-- Page-header opened -->
						<div class="page-header">
							<div class="page-leftheader">
							</div>
							
						</div>
						<!-- Page-header closed -->

					

