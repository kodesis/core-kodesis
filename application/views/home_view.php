<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />
	<title><?= $this->session->userdata('nama_singkat') ?> | Business Development</title>
	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link href="<?php echo base_url(); ?>login_lib/vendor/bootstrap/css/bootstrap-grid.css" rel="stylesheet"> -->
	<!-- Font Awesome -->
	<link href="<?php echo base_url(); ?>src/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="<?php echo base_url(); ?>src/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

	<!-- bootstrap-progressbar -->
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css"
		rel="stylesheet">
	<!-- JQVMap -->
	<link href="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
	<!-- bootstrap-daterangepicker -->
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="<?php echo base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>src/build/css/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>src/build/css/owl.theme.default.min.css" rel="stylesheet">
	<!-- footer menu -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/header.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/icons.css">
	<style>
		.col-xs-3 {
			width: 25%;
			background-color: #008080;
		}

		.row {
			margin-left: 0px;
		}

		.container-fluid {
			padding-right: 0px;
			padding-left: 0px
		}

		.btn_footer_panel .tag_ {
			padding-top: 37px;
		}

		body {}

		.justify-content-center {
			display: flex;
			justify-content: center;
		}
	</style>
</head>

<header class="header_area sticky-header">
	<!-- footer menu -->
	<div class="footer_panel">
		<div class="container-fluid text-center">
			<div class="row">

				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/create_memo">
						<i class="la-i la-i-m la-i-home"></i>
						<div class="tag_">
							<font color="white">Create</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/inbox">
						<i class="la-i la-i-m la-i-order"></i>
						<div class="tag_">
							<font color="white">Inbox</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/send_memo">
						<i class="la-i la-i-m la-i-notif"></i>
						<div class="tag_">
							<font color="white">Outbox</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>login/logout">
						<i class="la-i la-i-m la-i-akun"></i>
						<div class="tag_">
							<font color="white">Logout</font>
						</div>
					</a>
				</div>

			</div>
		</div>
	</div>
	<!-- footer menu -->
</header>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="<?php echo base_url(); ?>" class="site_title">
														<img src="<?= $this->session->userdata('icon') ?>" alt="..." width="60">
								<span> <?= $this->session->userdata('nama_singkat') ?> </span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="<?php echo base_url(); ?>src/images/img.jpg" alt="..."
								class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Welcome,</span>
							<h2><?php echo $this->session->userdata('nama'); ?></h2>
						</div>
					</div>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
						<?php $this->load->view('side_menu.php'); ?>
					</div>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->

					<!-- /menu footer buttons -->
				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div>

						<ul class="nav navbar-nav navbar-right">
							<li class="">
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
									aria-expanded="false">
									<img src="<?php echo base_url(); ?>src/images/img.jpg"
										alt=""><?php echo $this->session->userdata('nama'); ?>
									<span class=" fa fa-angle-down"></span>
								</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<li><a href="javascript:;"> Profile</a></li>
									<li>
										<a href="javascript:;">
											<span class="badge bg-red pull-right">50%</span>
											<span>Settings</span>
										</a>
									</li>
									<li><a href="javascript:;">Help</a></li>
									<li><a href="<?php echo base_url(); ?>login/logout"><i
												class="fa fa-sign-out pull-right"></i> Log
											Out</a></li>
								</ul>
							</li>

							<li role="presentation" class="dropdown">
								<!--a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"-->
								<a href="<?php echo base_url() . "app/inbox"; ?>" class="dropdown-toggle info-number">
									<i class="fa fa-envelope-o"></i>
									<?php if ($count_inbox == 0) { ?>
										<span class="badge bg-green"><?php echo $count_inbox; ?></span>
									<?php } else { ?>
										<span class="badge bg-red"><?php echo $count_inbox; ?></span>
									<?php } ?>
								</a>
								<!--ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
									<li>
									<a>
										<span class="image"><img src="<?php echo base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
										<span>
										<span>John Smith</span>
										<span class="time">3 mins ago</span>
										</span>
										<span class="message">
										Film festivals used to be do-or-die moments for movie makers. They were where...
										</span>
									</a>
									</li>
									<li>
									<a>
										<span class="image"><img src="<?php echo base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
										<span>
										<span>John Smith</span>
										<span class="time">3 mins ago</span>
										</span>
										<span class="message">
										Film festivals used to be do-or-die moments for movie makers. They were where...
										</span>
									</a>
									</li>
									<li>
									<a>
										<span class="image"><img src="<?php echo base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
										<span>
										<span>John Smith</span>
										<span class="time">3 mins ago</span>
										</span>
										<span class="message">
										Film festivals used to be do-or-die moments for movie makers. They were where...
										</span>
									</a>
									</li>
									<li>
									<a>
										<span class="image"><img src="<?php echo base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
										<span>
										<span>John Smith</span>
										<span class="time">3 mins ago</span>
										</span>
										<span class="message">
										Film festivals used to be do-or-die moments for movie makers. They were where...
										</span>
									</a>
									</li>
									<li>
									<div class="text-center">
										<a>
										<strong>See All Alerts</strong>
										<i class="fa fa-angle-right"></i>
										</a>
									</div>
									</li>
								</ul-->
							</li>
							<?php include 'notif_tello.php' ?>

						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="container">
					<div class="row justify-content-center">
						<div class="title_left">
							<h3>
								<a href="http://103.252.51.17:8787/fornax/user_login.php" class="btn btn-warning">Fornax</a>
							</h3>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row justify-content-center">
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="justify-content-center d-flex">
								<a href="<?= base_url('mobile/home') ?>" class="btn btn-primary"><i class="fa fa-phone"></i> Go To Mobile</a>
							</div>
							<div class="owl-carousel owl-theme">
								<?php $bg = $this->db->get_where('utility', ['Id' => 1])->row_array() ?>
								<div class="item">
									<img style="height: 400px;" src="<?= base_url('upload/banner/' . $bg['banner1']) ?>" alt="">
								</div>
								<div class="item">
									<img style="height: 400px;" src="<?= base_url('upload/banner/' . $bg['banner2']) ?>" alt="">
								</div>
								<div class="item">
									<img style="height: 400px;" src="<?= base_url('upload/banner/' . $bg['banner3']) ?>" alt="">
								</div>

							</div>
						</div>
					</div>
					<?php
					$a = $this->session->userdata('level');
					if (strpos($a, '40') !== false) { ?>
						<!-- <div class="row justify-content-center">
							<div class="col-md-8">
								<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
									Add Banner
								</a>
								<div class="collapse" id="collapseExample">
									<div class="cardmb-2">
										<div class="card-body">
											<div class="item group row">
												<div class="col-md-4">
													<form method="POST" action="<?= base_url('home/banner') ?>" enctype="multipart/form-data">
														<span>Banner 1</span>
														<input type="file" onchange="this.form.submit()" class="form-control" name="banner1">
													</form>
												</div>
												<div class="col-md-4">
													<form method="POST" action="<?= base_url('home/banner') ?>" enctype="multipart/form-data">
														<span>Banner 2</span>
														<input type="file" onchange="this.form.submit()" class="form-control" name="banner2">
													</form>
												</div>
												<form method="POST" action="<?= base_url('home/banner') ?>" enctype="multipart/form-data">
													<div class="col-md-4">
														<span>Banner 3</span>
														<input type="file" onchange="this.form.submit()" class="form-control" name="banner3">
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> -->
						<style>
							/* ==========================================
   MODERN UPLOAD CARD STYLE
   ========================================== */
							.banner-upload-card {
								border: 2px dashed #dee2e6 !important;
								border-radius: 12px !important;
								background-color: #f8f9fa !important;
								padding: 24px 15px !important;
								text-align: center !important;
								position: relative !important;
								transition: all 0.25s ease-in-out !important;
								cursor: pointer !important;
								overflow: hidden !important;
							}

							/* Efek hover ketika mouse mendekat */
							.banner-upload-card:hover {
								border-color: #0d6efd !important;
								background-color: #f1f7fe !important;
								transform: translateY(-2px) !important;
							}

							/* Menyembunyikan input file bawaan asli browser */
							.banner-upload-card input[type="file"] {
								position: absolute !important;
								top: 0 !important;
								left: 0 !important;
								width: 100% !important;
								height: 100% !important;
								opacity: 0 !important;
								cursor: pointer !important;
							}

							.upload-icon {
								font-size: 28px !important;
								color: #0d6efd !important;
								margin-bottom: 10px !important;
								display: inline-block !important;
							}

							.banner-title {
								font-size: 15px !important;
								font-weight: 600 !important;
								color: #343a40 !important;
								display: block !important;
								margin-bottom: 2px !important;
							}

							.upload-hint {
								font-size: 11px !important;
								color: #6c757d !important;
								display: block !important;
							}

							/* Merapikan tombol pemicu utama */
							.btn-toggle-banner {
								padding: 10px 24px !important;
								font-weight: 600 !important;
								border-radius: 30px !important;
								letter-spacing: 0.5px !important;
								box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15) !important;
								transition: all 0.2s ease !important;
							}

							.btn-toggle-banner:hover {
								transform: translateY(-1px) !important;
								box-shadow: 0 6px 15px rgba(13, 110, 253, 0.25) !important;
							}
						</style>
						<div class="row">
							<div class="col-12 text-center mb-3">
								<a class="btn btn-primary btn-toggle-banner" data-toggle="collapse" href="#collapseBanner" role="button" aria-expanded="false" aria-controls="collapseBanner">
									<i class="fa fa-image me-2"></i> Manage Banners
								</a>
							</div>
						</div>

						<div class="row justify-content-center">
							<div class="col-12">
								<div class="collapse" id="collapseBanner">
									<div class="card mb-4 border-0 shadow-sm rounded-3">
										<div class="card-body p-4">

											<div class="row justify-content-center g-3">

												<div class="col-md-4 col-sm-6 col-12">
													<form method="POST" action="<?= base_url('home/banner') ?>" enctype="multipart/form-data">
														<div class="banner-upload-card">
															<div class="upload-icon">▲</div>
															<span class="banner-title">Banner Utama 1</span>
															<span class="upload-hint">Klik untuk upload (.jpg, .png)</span>
															<input type="file" onchange="this.form.submit()" name="banner1" accept="image/*">
														</div>
													</form>
												</div>

												<div class="col-md-4 col-sm-6 col-12">
													<form method="POST" action="<?= base_url('home/banner') ?>" enctype="multipart/form-data">
														<div class="banner-upload-card">
															<div class="upload-icon">▲</div>
															<span class="banner-title">Banner Utama 2</span>
															<span class="upload-hint">Klik untuk upload (.jpg, .png)</span>
															<input type="file" onchange="this.form.submit()" name="banner2" accept="image/*">
														</div>
													</form>
												</div>

												<div class="col-md-4 col-sm-6 col-12">
													<form method="POST" action="<?= base_url('home/banner') ?>" enctype="multipart/form-data">
														<div class="banner-upload-card">
															<div class="upload-icon">▲</div>
															<span class="banner-title">Banner Utama 3</span>
															<span class="upload-hint">Klik untuk upload (.jpg, .png)</span>
															<input type="file" onchange="this.form.submit()" name="banner3" accept="image/*">
														</div>
													</form>
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<br>
					<style>
						/* ==========================================
       CHART BAR CUSTOM STYLING (TOTAL FIX)
       ========================================== */
						.chart-container {
							display: flex !important;
							justify-content: space-around !important;
							align-items: flex-end !important;
							height: 180px !important;
							/* Beri ruang vertikal yang cukup */
							padding: 15px 10px !important;
							background: #f8f9fa !important;
							border-radius: 12px !important;
							width: 100% !important;
							box-sizing: border-box !important;
						}

						.chart-bar-wrapper {
							display: flex !important;
							flex-direction: column !important;
							align-items: center !important;
							justify-content: flex-end !important;
							width: 22% !important;
							height: 100% !important;
						}

						/* Track pembatas tinggi grafik agar label persentase tidak tabrakan */
						.chart-bar-track {
							display: flex !important;
							align-items: flex-end !important;
							width: 100% !important;
							height: 110px !important;
							/* Kunci tinggi maksimal batang */
							margin-top: 4px !important;
							margin-bottom: 6px !important;
						}

						.chart-bar {
							width: 100% !important;
							border-radius: 6px 6px 0 0 !important;
							transition: height 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
						}

						/* Mengatasi text overflow jika nama terlalu panjang / layar kecil */
						.chart-label-top {
							font-size: 11px !important;
							font-weight: 600 !important;
							color: #495057 !important;
							line-height: 1 !important;
						}

						.chart-label-bottom {
							font-size: 10px !important;
							color: #6c757d !important;
							line-height: 1 !important;
						}

						/* ==========================================
       BADGE FILTER BUTTONS FIX
       ========================================== */
						.custom-filter-btn {
							display: inline-flex !important;
							align-items: center !important;
							gap: 6px !important;
							padding: 6px 14px !important;
							font-size: 13px !important;
							font-weight: 500 !important;
							border-radius: 30px !important;
							/* Rounded pill style */
							border: 1px solid #dee2e6 !important;
							background-color: #fff !important;
							color: #495057 !important;
							transition: all 0.2s ease !important;
						}

						.custom-filter-btn:hover,
						.custom-filter-btn.active {
							background-color: #212529 !important;
							color: #fff !important;
							border-color: #212529 !important;
						}

						.custom-filter-btn .custom-badge {
							display: inline-flex !important;
							align-items: center !important;
							justify-content: center !important;
							min-width: 20px !important;
							height: 20px !important;
							padding: 0 4px !important;
							font-size: 11px !important;
							font-weight: 600 !important;
							border-radius: 50% !important;
							background-color: #f1f3f5 !important;
							color: #212529 !important;
						}

						.custom-filter-btn:hover .custom-badge,
						.custom-filter-btn.active .custom-badge {
							background-color: #fff !important;
							color: #212529 !important;
						}

						/* Tombol khusus overdue agar border merah pas */
						.btn-overdue-custom {
							color: #dc3545 !important;
							border-color: rgba(220, 53, 69, 0.3) !important;
						}

						.btn-overdue-custom:hover,
						.btn-overdue-custom.active {
							background-color: #dc3545 !important;
							border-color: #dc3545 !important;
							color: #fff !important;
						}

						/* Menggantikan fungsi d-none Bootstrap jika tidak aktif */
						.chart-hidden {
							display: none !important;
						}

						/* ==========================================
   STYLE UNTUK TOMBOL NAV TABS (Open / Closed)
   ========================================== */
						.custom-nav-tabs {
							display: flex !important;
							background-color: #f1f3f5 !important;
							padding: 4px !important;
							border-radius: 30px !important;
							border: none !important;
							margin-bottom: 25px !important;
						}

						.custom-nav-tabs .nav-item {
							flex: 1 !important;
						}

						.custom-nav-tabs .nav-link-custom {
							display: block !important;
							width: 100% !important;
							border: none !important;
							background: transparent !important;
							padding: 8px 16px !important;
							color: #495057 !important;
							font-size: 14px !important;
							font-weight: 600 !important;
							border-radius: 25px !important;
							text-align: center !important;
							cursor: pointer !important;
							transition: all 0.25s ease !important;
						}

						/* State ketika tab aktif/diklik */
						.custom-nav-tabs .nav-link-custom.active {
							background-color: #ffffff !important;
							color: #0d6efd !important;
							/* Warna biru modern */
							box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
						}


						/* ==========================================
   STYLE UNTUK TOMBOL FILTER UTAMA (All, Progress, dll)
   ========================================== */
						.filter-btn-container {
							display: flex !important;
							flex-wrap: wrap !important;
							gap: 8px !important;
							justify-content: center !important;
							margin-bottom: 20px !important;
						}

						.custom-filter-btn {
							display: inline-flex !important;
							align-items: center !important;
							gap: 8px !important;
							padding: 6px 14px !important;
							font-size: 13px !important;
							font-weight: 500 !important;
							border-radius: 30px !important;
							border: 1px solid #dee2e6 !important;
							background-color: #ffffff !important;
							color: #495057 !important;
							cursor: pointer !important;
							transition: all 0.2s ease-in-out !important;
						}

						/* Efek Hover & Active Secara Umum */
						.custom-filter-btn:hover {
							background-color: #f8f9fa !important;
							border-color: #ced4da !important;
						}

						.custom-filter-btn.active {
							background-color: #212529 !important;
							color: #ffffff !important;
							border-color: #212529 !important;
						}

						/* Style Bulatan Angka (Badge) di Dalam Tombol */
						.custom-filter-btn .custom-badge {
							display: inline-flex !important;
							align-items: center !important;
							justify-content: center !important;
							min-width: 20px !important;
							height: 20px !important;
							padding: 0 6px !important;
							font-size: 11px !important;
							font-weight: 600 !important;
							border-radius: 50% !important;
							background-color: #e9ecef !important;
							color: #212529 !important;
							transition: all 0.2s ease !important;
						}

						/* Perubahan warna badge saat tombol aktif */
						.custom-filter-btn.active .custom-badge {
							background-color: #ffffff !important;
							color: #212529 !important;
						}

						/* Variasi Khusus untuk Tombol Overdue (Border Merah) */
						.btn-overdue-custom {
							color: #dc3545 !important;
							border-color: rgba(220, 53, 69, 0.4) !important;
						}

						.btn-overdue-custom .custom-badge {
							background-color: #fde8e8 !important;
							color: #dc3545 !important;
						}

						.btn-overdue-custom:hover {
							background-color: #fdf2f2 !important;
							border-color: #dc3545 !important;
						}

						.btn-overdue-custom.active {
							background-color: #dc3545 !important;
							border-color: #dc3545 !important;
							color: #ffffff !important;
						}

						.btn-overdue-custom.active .custom-badge {
							background-color: #ffffff !important;
							color: #dc3545 !important;
						}
					</style>

					<?php
					$open_total = $task_stats['open']['total'];
					if ($open_total > 0) {
						$p_open_prog = round(($task_stats['open']['progress'] / $open_total) * 100);
						$p_open_1wk  = round(($task_stats['open']['overdue_1wk'] / $open_total) * 100);
						$p_open_1mo  = round(($task_stats['open']['overdue_1mo'] / $open_total) * 100);
						$p_open_gt   = 100 - ($p_open_prog + $p_open_1wk + $p_open_1mo);
						if ($p_open_gt < 0) $p_open_gt = 0;
					} else {
						$p_open_prog = $p_open_1wk = $p_open_1mo = $p_open_gt = 0;
					}

					$closed_total = $task_stats['closed']['total'];
					if ($closed_total > 0) {
						$p_close_prog = round(($task_stats['closed']['progress'] / $closed_total) * 100);
						$p_close_1wk  = round(($task_stats['closed']['overdue_1wk'] / $closed_total) * 100);
						$p_close_1mo  = round(($task_stats['closed']['overdue_1mo'] / $closed_total) * 100);
						$p_close_gt   = 100 - ($p_close_prog + $p_close_1wk + $p_close_1mo);
						if ($p_close_gt < 0) $p_close_gt = 0;
					} else {
						$p_close_prog = $p_close_1wk = $p_close_1mo = $p_close_gt = 0;
					}
					?>

					<div class="x_panel tile shadow-sm border-0 rounded-3">
						<div class="content p-3">
							<h5 class="font-14 text-muted fw-bold mb-3">Tello - Statistik Task</h5>

							<div class="custom-nav-tabs">
								<div class="nav-item">
									<button class="nav-link-custom active" id="btn-open" type="button" onclick="switchTab('open')">
										Open (<?= $open_total ?>)
									</button>
								</div>
								<div class="nav-item">
									<button class="nav-link-custom" id="btn-closed" type="button" onclick="switchTab('closed')">
										Closed (<?= $closed_total ?>)
									</button>
								</div>
							</div>

							<div class="tab-custom-content">
								<div id="panel-open" class="tab-panel-item">
									<div class="chart-container mb-4">
										<div class="chart-bar-wrapper">
											<span class="chart-label-top"><?= $p_open_prog ?>%</span>
											<div class="chart-bar-track">
												<div class="chart-bar bg-primary" style="height: <?= $p_open_prog ?>%;"></div>
											</div>
											<span class="chart-label-bottom">(<?= $task_stats['open']['progress'] ?>)</span>
										</div>

										<div class="chart-bar-wrapper">
											<span class="chart-label-top"><?= $p_open_1wk ?>%</span>
											<div class="chart-bar-track">
												<div class="chart-bar" style="height: <?= $p_open_1wk ?>%; background-color: #f0ad4e"></div>
											</div>
											<span class="chart-label-bottom">(<?= $task_stats['open']['overdue_1wk'] ?>)</span>
										</div>

										<div class="chart-bar-wrapper">
											<span class="chart-label-top"><?= $p_open_1mo ?>%</span>
											<div class="chart-bar-track">
												<div class="chart-bar bg-danger" style="height: <?= $p_open_1mo ?>%;"></div>
											</div>
											<span class="chart-label-bottom">(<?= $task_stats['open']['overdue_1mo'] ?>)</span>
										</div>

										<div class="chart-bar-wrapper">
											<span class="chart-label-top"><?= $p_open_gt ?>%</span>
											<div class="chart-bar-track">
												<div class="chart-bar bg-dark" style="height: <?= $p_open_gt ?>%;"></div>
											</div>
											<span class="chart-label-bottom">(<?= $task_stats['open']['overdue_gt_1mo'] ?>)</span>
										</div>
									</div>
								</div>

								<div id="panel-closed" class="tab-panel-item chart-hidden">
									<div class="chart-container mb-4">
										<div class="chart-bar-wrapper">
											<span class="chart-label-top"><?= $p_close_prog ?>%</span>
											<div class="chart-bar-track">
												<div class="chart-bar bg-primary" style="height: <?= $p_close_prog ?>%;"></div>
											</div>
											<span class="chart-label-bottom">(<?= $task_stats['closed']['progress'] ?>)</span>
										</div>

										<div class="chart-bar-wrapper">
											<span class="chart-label-top"><?= $p_close_1wk ?>%</span>
											<div class="chart-bar-track">
												<div class="chart-bar" style="height: <?= $p_close_1wk ?>%;background-color: #f0ad4e"></div>
											</div>
											<span class=" chart-label-bottom">(<?= $task_stats['closed']['overdue_1wk'] ?>)</span>
										</div>

										<div class="chart-bar-wrapper">
											<span class="chart-label-top"><?= $p_close_1mo ?>%</span>
											<div class="chart-bar-track">
												<div class="chart-bar bg-danger" style="height: <?= $p_close_1mo ?>%;"></div>
											</div>
											<span class="chart-label-bottom">(<?= $task_stats['closed']['overdue_1mo'] ?>)</span>
										</div>

										<div class="chart-bar-wrapper">
											<span class="chart-label-top"><?= $p_close_gt ?>%</span>
											<div class="chart-bar-track">
												<div class="chart-bar bg-dark" style="height: <?= $p_close_gt ?>%;"></div>
											</div>
											<span class="chart-label-bottom">(<?= $task_stats['closed']['overdue_gt_1mo'] ?>)</span>
										</div>
									</div>
								</div>
							</div>

							<div class="row g-2 text-center pb-2">
								<div class="col-6 font-11 text-start d-flex align-items-center">
									<span class="badge bg-primary rounded-circle me-2" style="width:10px; height:10px; padding:0;"></span>
									<span id="text-legenda-progress">On Progress</span>
								</div>
								<div class="col-6 font-11 text-start d-flex align-items-center">
									<span class="badge bg-warning rounded-circle me-2" style="width:10px; height:10px; padding:0;"></span> Overdue 1 Wk
								</div>
								<div class="col-6 font-11 text-start d-flex align-items-center">
									<span class="badge bg-danger rounded-circle me-2" style="width:10px; height:10px; padding:0;"></span> Overdue 1 Wk - 1 Mo
								</div>
								<div class="col-6 font-11 text-start d-flex align-items-center">
									<span class="badge bg-dark rounded-circle me-2" style="width:10px; height:10px; padding:0;"></span> Overdue &gt; 1 Mo
								</div>
							</div>

						</div>
					</div>

					<script>
						function switchTab(type) {
							const legendaText = document.getElementById('text-legenda-progress');

							if (type === 'open') {
								// 1. Atur tombol active
								document.getElementById('btn-open').classList.add('active');
								document.getElementById('btn-closed').classList.remove('active');

								// 2. Munculkan panel Open, sembunyikan panel Closed
								document.getElementById('panel-open').classList.remove('chart-hidden');
								document.getElementById('panel-closed').classList.add('chart-hidden');

								// 3. Ubah teks legenda
								legendaText.innerText = "On Progress";
							} else {
								// 1. Atur tombol active
								document.getElementById('btn-closed').classList.add('active');
								document.getElementById('btn-open').classList.remove('active');

								// 2. Munculkan panel Closed, sembunyikan panel Open
								document.getElementById('panel-closed').classList.remove('chart-hidden');
								document.getElementById('panel-open').classList.add('chart-hidden');

								// 3. Ubah teks legenda
								legendaText.innerText = "On Time";
							}
						}
					</script>
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-12">

							<div class="row">
								<!-- <div class="col-md-6 col-sm-6 col-xs-12">
									<div class="x_panel tile fixed_height_300">
										<div class="x_title">
											<h2><i class="fa fa-envelope-o"></i> Inbox</h2>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">
											<h4>Total Inbox</h4><br>
										
											<div class="widget_summary">
												<div class="w_left w_25">
													<span>In</span>
												</div>
												<div class="w_center w_55">
													<div class="progress">
														<div class="progress-bar bg-green" role="progressbar" aria-valuenow="46.288209606987"
															aria-valuemin="0" aria-valuemax="100" style="width: 46.288209606987%;">
															<span class="sr-only">46.288209606987%</span>
														</div>
													</div>
												</div>
												<div class="w_right w_20">
													<span>106</span>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="widget_summary">
												<div class="w_left w_25">
													<span>Out</span>
												</div>
												<div class="w_center w_55">
													<div class="progress">
														<div class="progress-bar bg-green" role="progressbar" aria-valuenow="20.960698689956"
															aria-valuemin="0" aria-valuemax="100" style="width: 20.960698689956%;">
															<span class="sr-only">20.960698689956%</span>
														</div>
													</div>
												</div>
												<div class="w_right w_20">
													<span>48</span>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								</div> -->
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="x_panel tile fixed_height_300">
										<div class="x_title">
											<h2><i class="fa fa-envelope-o"></i> Memo</h2>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">
											<h4>Total Memo <?= $total ?></h4><br>
											<a href="<?= base_url('app/inbox') ?>">
												<div class="widget_summary">
													<div class="w_left w_25">
														<span>Unread</span>
													</div>
													<div class="w_center w_55">
														<div class="progress">
															<div class="progress-bar bg-blue-sky" role="progressbar"
																aria-valuenow="46.288209606987" aria-valuemin="0"
																aria-valuemax="100" style="width: <?= $count_inbox ?>%;">
																<span class="sr-only">46.288209606987%</span>
															</div>
														</div>
													</div>
													<div class="w_right w_20">
														<span><?= $count_inbox ?></span>
													</div>
													<div class="clearfix"></div>
												</div>
											</a>
											<a href="<?= base_url('app/inbox') ?>">
												<div class="widget_summary">
													<div class="w_left w_25">
														<span>Read</span>
													</div>
													<div class="w_center w_55">
														<div class="progress">
															<div class="progress-bar bg-blue-sky" role="progressbar"
																aria-valuenow="20.960698689956" aria-valuemin="0"
																aria-valuemax="100" style="width: <?= $read_inbox ?>%;">
																<span class="sr-only">20.960698689956%</span>
															</div>
														</div>
													</div>
													<div class="w_right w_20">
														<span><?= $read_inbox ?></span>
													</div>
													<div class="clearfix"></div>
												</div>
											</a>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="x_panel tile fixed_height_300">
										<div class="x_title">
											<h2><i class="fa fa-envelope-o"></i> Tello</h2>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">
											<h4>Total Tello <?= $total_tello['id'] ?></h4><br>
											<a href="<?= base_url('task/task') ?>">
												<div class="widget_summary">
													<div class="w_left w_25">
														<span>Open</span>
													</div>
													<div class="w_center w_55">
														<div class="progress">
															<div class="progress-bar bg-blue-sky" role="progressbar"
																aria-valuenow="46.288209606987" aria-valuemin="0"
																aria-valuemax="100" style="width: <?= $open_tello['id'] ?>%;">
																<!-- <span class="sr-only">46.288209606987%</span> -->
															</div>
														</div>
													</div>
													<div class="w_right w_20">
														<span><?= $open_tello['id'] ?></span>
													</div>
													<div class="clearfix"></div>
												</div>
											</a>
											<a href="<?= base_url('task/task') ?>">
												<div class="widget_summary">
													<div class="w_left w_25">
														<span>Closed</span>
													</div>
													<div class="w_center w_55">
														<div class="progress">
															<div class="progress-bar bg-blue-sky" role="progressbar"
																aria-valuenow="20.960698689956" aria-valuemin="0"
																aria-valuemax="100" style="width: <?= $closed_tello['id'] ?>%;">
																<span class="sr-only">20.960698689956%</span>
															</div>
														</div>
													</div>
													<div class="w_right w_20">
														<span><?= $closed_tello['id'] ?></span>
													</div>
													<div class="clearfix"></div>
												</div>
											</a>
											<a href="<?= base_url('task/task') ?>">
												<div class="widget_summary">
													<div class="w_left w_25">
														<span>Pending</span>
													</div>
													<div class="w_center w_55">
														<div class="progress">
															<div class="progress-bar bg-blue-sky" role="progressbar"
																aria-valuenow="20.960698689956" aria-valuemin="0"
																aria-valuemax="100" style="width: <?= $pending_tello['id'] ?>%;">
																<span class="sr-only">20.960698689956%</span>
															</div>
														</div>
													</div>
													<div class="w_right w_20">
														<span><?= $pending_tello['id'] ?></span>
													</div>
													<div class="clearfix"></div>
												</div>
											</a>
											<a href="<?= base_url('task/task') ?>">
												<div class="widget_summary">
													<div class="w_left w_25">
														<span>Over Due Date</span>
													</div>
													<div class="w_center w_55">
														<div class="progress">
															<div class="progress-bar bg-blue-sky" role="progressbar"
																aria-valuenow="20.960698689956" aria-valuemin="0"
																aria-valuemax="100" style="width: <?= $over_due_card['id'] ?>%;">
																<span class="sr-only">20.960698689956%</span>
															</div>
														</div>
													</div>
													<div class="w_right w_20">
														<span><?= $over_due_card['id'] ?></span>
													</div>
													<div class="clearfix"></div>
												</div>
											</a>
										</div>
									</div>
								</div>

								<div class="clearfix"></div>



							</div>
						</div>

					</div>
					<!-- Start content-->

					<!-- Finish content-->
				</div>
				<br><br>
				<br><br>
			</div>

			<!-- /page content -->

			<!-- footer content -->

			<!-- /footer content -->
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="<?php echo base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.js"></script>
	<!-- Chart.js -->
	<script src="<?php echo base_url(); ?>src/vendors/Chart.js/dist/Chart.min.js"></script>
	<!-- gauge.js -->
	<script src="<?php echo base_url(); ?>src/vendors/gauge.js/dist/gauge.min.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="<?php echo base_url(); ?>src/vendors/iCheck/icheck.min.js"></script>
	<!-- Skycons -->
	<script src="<?php echo base_url(); ?>src/vendors/skycons/skycons.js"></script>
	<!-- Flot -->
	<script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.time.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.stack.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.resize.js"></script>
	<!-- Flot plugins -->
	<script src="<?php echo base_url(); ?>src/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/flot.curvedlines/curvedLines.js"></script>
	<!-- DateJS -->
	<script src="<?php echo base_url(); ?>src/vendors/DateJS/build/date.js"></script>
	<!-- JQVMap -->
	<script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jquery.vmap.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="<?php echo base_url(); ?>src/vendors/moment/min/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

	<!-- Custom Theme Scripts -->
	<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>
	<script src="<?php echo base_url(); ?>src/build/js/owl.carousel.min.js"></script>
	<script>
		$('.owl-carousel').owlCarousel({
			loop: true,
			margin: 10,
			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					nav: true
				},
				600: {
					items: 3,
					nav: false
				},
				1000: {
					items: 1,
					nav: true,
					loop: true,
					autoplay: true,
				}
			}
		})
	</script>

</body>

</html>