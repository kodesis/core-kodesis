<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="<?= base_url($setting[2]->object) ?>" type="image/ico" />
	<title><?= $setting['3']->object ?> | Bussines Development</title>
	<title>Andara Office | Business Development</title>
	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?php echo base_url(); ?>src/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="<?php echo base_url(); ?>src/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

	<!-- bootstrap-progressbar -->
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
	<!-- JQVMap -->
	<link href="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
	<!-- bootstrap-daterangepicker -->
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- bootstrap-datetimepicker -->
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="<?php echo base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">
	<!-- footer menu -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/header.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/icons.css">
	<!-- Sweetalert -->
	<script src="<?php echo base_url(); ?>src/build/js/sweetalert.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/build/css/sweetalert.css" />

	<style>
		.col-xs-3 {
			width: 25%;
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
	</style>
</head>

<header class="header_area sticky-header">
	<!-- footer menu -->
	<div class="footer_panel">
		<div class="container-fluid text-center">
			<div class="row">

				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/antrian_input">
						<i class="la-i la-i-m la-i-home"></i>
						<div class="tag_">
							<font color="white">Create</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/antrian_panggil">
						<i class="la-i la-i-m la-i-order"></i>
						<div class="tag_">
							<font color="white">Manage</font>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/antrian_monitor">
						<i class="la-i la-i-m la-i-notif">
						</i>
						<div class="tag_">
							<font color="white">Monitor</font>
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
						<a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>src/images/logosaja_bdl.png" alt="..." height="42" width="60"><span> Andara Office</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<div class="profile clearfix">
						<div class="profile_pic">
							<img src="<?php echo base_url(); ?>src/images/img.jpg" alt="..." class="img-circle profile_img">
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
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<img src="<?php echo base_url(); ?>src/images/img.jpg" alt=""><?php echo $this->session->userdata('nama'); ?>
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
									<li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
								</ul>
							</li>

							<li role="presentation" class="dropdown">
								<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-envelope-o"></i>
									<span class="badge bg-green">0</span>
								</a>
								<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
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
								</ul>
							</li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="row tile_count">
					<div class="col-md-2 col-sm-2 col-xs-2 tile_stats_count">
						<span class="count_top"><i class="fa fa-folder-open-o"></i>Current Queue</span>
						<div class="count" style="color:#16a085;"><?php echo $utility->current_antrian; ?></div>
						<span class="count_bottom"><i class="red"><strong>&raquo;&raquo;&raquo;</strong></i></span>
					</div>
					<div class="col-md-5 col-sm-5 col-xs-5 tile_stats_count">
						<span class="count_top"><i class="fa fa-line-chart"></i>Left &laquo; Need Approve</span>
						<div class="count" style="color:red;"><?php echo $sisa_antrian . ' &laquo; '; ?><font color="blue"><?php echo $need_approve; ?></font>
							<a href="<?php echo base_url(); ?>app/list_antrian"><button type="submit" id="btn-view" class="btn btn-primary">View</button></a>
						</div>
						<span class="count_bottom"><i class="red"><strong>Date: <?php $date = date_create($utility->tgl_antrian);
																				echo date_format($date, 'd-m-Y'); ?></strong></i></span>
						<!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
					</div>
					<div class="col-md-3 col-sm-3 col-xs-3 tile_stats_count">
						<span class="count_top"><i class="fa fa-line-chart"></i>Next Day</span>
						<div class="count" style="color:#f39c12;"><?php echo $antrian_besok; ?></div><br>
						<!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
					</div>
				</div>

				<?php echo form_open_multipart('app/set_date', 'class="form-horizontal form-label-left" name="form_input" id="form_input"'); ?>
				<div class="item form-group">
					<label style="text-align: right;" class="control-label col-md-2 col-sm-2 col-xs-3">Queue Date<span class="required">*</span></label>
					<div class="col-md-3 col-sm-3 col-xs-5">
						<div class='input-group date' id='myDatepicker2'>
							<input type='text' name='date_pic' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
					<button type="submit" id="btn-reset" onclick="" class="btn btn-primary btn">Set Date</button>
				</div>
				</form>

				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot1 == 0) { ?>
							<!--button type="button" id="btn-slot1" onclick="myFunction('1')" class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 1 &raquo; Start</button-->
							<button type="button" id="btn-slot1" onclick="myFunction('1')" class="btn btn-success">Slot 1 &raquo;</button>
						<?php } else { ?>
							<!--button type="button" id="btn-slot1e" onclick="myFunction_2('1')" class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 1 &raquo; On Load</button-->
							<button type="button" class="btn btn-danger col-md-12 col-xs-12" onclick="get_val('1');" data-toggle="modal" data-target="#myModal1">Close &raquo; <?php echo $utility->nopol1; ?></button>
						<?php }
						?>

						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot1; ?></h1> Loading Start : <?php if (!empty($antrian1)) {
																						echo $antrian1->start_time;
																					} ?>
						</div>
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot2 == 0) { ?>
							<button type="button" id="btn-slot1" onclick="myFunction('2')" class="btn btn-success">Slot 2 &raquo;</button>
						<?php } else { ?>
							<!--button type="button" id="btn-slot1e" onclick="myFunction_2('2')" class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 2 &raquo; On Load</button-->
							<button type="button" class="btn btn-danger col-md-12 col-xs-12" onclick="get_val('2');" data-toggle="modal" data-target="#myModal1">Close &raquo; <?php echo $utility->nopol2; ?></button>
						<?php }
						?>
						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot2; ?></h1> Loading Start : <?php if (!empty($antrian2)) {
																						echo $antrian2->start_time;
																					} ?>
						</div>
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot3 == 0) { ?>
							<button type="button" id="btn-slot1" onclick="myFunction('3')" class="btn btn-success">Slot 3 &raquo;</button>
						<?php } else { ?>
							<!--button type="button" id="btn-slot1e" onclick="myFunction_2('3')" class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 3 &raquo; On Load</button-->
							<button type="button" class="btn btn-danger col-md-12 col-xs-12" onclick="get_val('3');" data-toggle="modal" data-target="#myModal1">Close &raquo; <?php echo $utility->nopol3; ?></button>
						<?php }
						?>
						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot3; ?></h1> Loading Start : <?php if (!empty($antrian3)) {
																						echo $antrian3->start_time;
																					} ?>
						</div>
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot4 == 0) { ?>
							<button type="button" id="btn-slot1" onclick="myFunction('4')" class="btn btn-success">Slot 4 &raquo;</button>
						<?php } else { ?>
							<!--button type="button" id="btn-slot1e" onclick="myFunction_2('4')" class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 4 &raquo; On Load</button-->
							<button type="button" class="btn btn-danger col-md-12 col-xs-12" onclick="get_val('4');" data-toggle="modal" data-target="#myModal1">Close &raquo; <?php echo $utility->nopol4; ?></button>
						<?php }
						?>
						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot4; ?></h1> Loading Start : <?php if (!empty($antrian4)) {
																						echo $antrian4->start_time;
																					} ?>
						</div>
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot5 == 0) { ?>
							<button type="button" id="btn-slot1" onclick="myFunction('5')" class="btn btn-success">Slot 5 &raquo;</button>
						<?php } else { ?>
							<!--button type="button" id="btn-slot1e" onclick="myFunction_2('5')" class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 5 &raquo; On Load</button-->
							<button type="button" class="btn btn-danger col-md-12 col-xs-12" onclick="get_val('5');" data-toggle="modal" data-target="#myModal1">Close &raquo; <?php echo $utility->nopol5; ?></button>
						<?php }
						?>
						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot5; ?></h1> Loading Start : <?php if (!empty($antrian5)) {
																						echo $antrian5->start_time;
																					} ?>
						</div>
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot6 == 0) { ?>
							<button type="button" id="btn-slot1" onclick="myFunction('6')" class="btn btn-success">Slot 6 &raquo;</button>
						<?php } else { ?>
							<!--button type="button" id="btn-slot1e" onclick="myFunction_2('6')" class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 6 &raquo; On Load</button-->
							<button type="button" class="btn btn-danger col-md-12 col-xs-12" onclick="get_val('6');" data-toggle="modal" data-target="#myModal1">Close &raquo; <?php echo $utility->nopol4; ?></button>
						<?php }
						?>
						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot6; ?></h1> Loading Start : <?php if (!empty($antrian6)) {
																						echo $antrian6->start_time;
																					} ?>
						</div>
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot7 == 0) { ?>
							<button type="button" id="btn-slot1" onclick="myFunction('7')" class="btn btn-success">Slot 7 &raquo;</button>
						<?php } else { ?>
							<!--button type="button" id="btn-slot1e" onclick="myFunction_2('7')" class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 7 &raquo; On Load</button-->
							<button type="button" class="btn btn-danger col-md-12 col-xs-12" onclick="get_val('7');" data-toggle="modal" data-target="#myModal1">Close &raquo; <?php echo $utility->nopol7; ?></button>
						<?php }
						?>
						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot7; ?></h1> Loading Start : <?php if (!empty($antrian7)) {
																						echo $antrian7->start_time;
																					} ?>
						</div>
					</div>
				</div>
				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot8 == 0) { ?>
							<button type="button" id="btn-slot1" onclick="myFunction('8')" class="btn btn-success">Slot 8 &raquo;</button>
						<?php } else { ?>
							<!--button type="button" id="btn-slot1e" onclick="myFunction_2('8')" class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 8 &raquo; On Load</button-->
							<button type="button" class="btn btn-danger col-md-12 col-xs-12" onclick="get_val('8');" data-toggle="modal" data-target="#myModal1">Close &raquo; <?php echo $utility->nopol8; ?></button>
						<?php }
						?>
						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot8; ?></h1> Loading Start : <?php if (!empty($antrian8)) {
																						echo $antrian8->start_time;
																					} ?>
						</div>
					</div>
				</div>

				<!-- Start content-->
				<?php echo form_open_multipart('app/slot//', 'class="form-horizontal form-label-left" name="form_input" id="form_input"'); ?>
				<div class="item form-group">
					<label style="text-align: right;" class="control-label col-md-1 col-sm-2 col-xs-3">Cust. Call<span class="required">*</span></label>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<input type="number" id="nom_antrian" name="nom_antrian" required="required" class="form-control col-md-3 col-xs-6" data-validate-words="1" placeholder="Queue Number">
					</div>
					<select id="pilih_slot" class="form-control col-sm-2 col-xs-3" name="pilih_slot" required="required">
						<option value="">Select Slot</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>
				</div>
				<div class="item form-group">
					<label style="text-align: right;" class="control-label col-md-2 col-sm-2 col-xs-3">Queue Date<span class="required">*</span></label>
					<div class="col-md-3 col-sm-3 col-xs-5">
						<div class='input-group date' id='myDatepicker3'>
							<input type='text' name='date_pic1' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
					<button type="submit" id="btn-submit" name="btn-submit" onclick="" class="btn btn-primary btn">Start</button>
				</div>
				</form>
				<br><br><br>
				<!-- Finish content-->

			</div>

			<!--Modal Content-->
			<form data-parsley-validate action="<?php echo base_url(); ?>app/slot_e" method="post" name="modal_slot" id="modal_slot" class="form-horizontal form-label-left">
				<div class="modal fade" id="myModal1" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h2 class="modal-title">Attention </h2>
							</div>
							<div class="modal-body text-center">
								<h4>
									<font color="Green"><Strong>Note to Regulated Agent
								</h4><br>
								<div class="form-group">
									<label style="text-align: left;" for="informasi" class="control-label col-md-3 col-sm-3 col-xs-12">Note Content</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<textarea name="remark" class="form-control" rows="3" placeholder="Write your information"></textarea>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<input id="id_slot" name="id_slot" type="hidden" required="required" value="">
								<button name="btn-submit" id="btn-submit" type="submit" class="btn btn-success">Finish</button>
								<?php //echo form_submit('submit', 'Finish', 'class="btn btn-primary"'); 
								?>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</form>

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
	<!-- bootstrap-datetimepicker -->
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<!-- validator -->
	<script src="<?php echo base_url(); ?>src/vendors/validator/validator.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>

	<script>
		$('#myDatepicker2').datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$('#myDatepicker3').datetimepicker({
			format: 'YYYY-MM-DD'
		});

		function get_val(val) {
			document.getElementById('id_slot').value = val;
		}

		function myFunction(slot) {
			swal({
				title: "Are You Sure ?",
				text: "Start Next Queue!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Lets Start",
				closeOnConfirm: false
			}, function(isConfirm) {
				//if (isConfirm) window.location.href = 'slot/'+slot;
				if (isConfirm) window.location = '<?php echo base_url(); ?>app/slot/' + slot;
			});
		}

		function myFunction_2(slot) {
			swal({
				title: "Are You Sure ?",
				text: "Finish Queue Loading !",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Lets Finish",
				closeOnConfirm: false
			}, function(isConfirm) {
				//if (isConfirm) window.location.href = 'slot_e/'+slot;
				if (isConfirm) window.location = '<?php echo base_url(); ?>app/slot_e/' + slot;
			});
		}
		$('#btn-submit').on('click', function(e) {
			e.preventDefault();
			var form = $(this).parents('form');
			swal({
				title: "Are You Sure ?",
				text: "Queue Custom Call!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Start it!",
				closeOnConfirm: false
			}, function(isConfirm) {
				if (isConfirm) form.submit();
			});
		});

		//sweet alert sample
		$('#btn-reset').on('click', function(e) {
			e.preventDefault();
			var form = $(this).parents('form');
			swal({
				title: "Anda yakin ?",
				text: "Melakukan seting tanggal Antrian ?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Lets Seting",
				closeOnConfirm: false
			}, function(isConfirm) {
				if (isConfirm) form.submit();
			});
		});
		$(document.getElementsByName("btn_custome")).on('click', function(e) {
			e.preventDefault();
			var form = $(this).parents('form');
			swal({
				title: "Anda yakin ?",
				text: "Custome Start Antrian ?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Lets Start",
				closeOnConfirm: false
			}, function(isConfirm) {
				if (isConfirm) form.submit();
			});
		});
	</script>

</body>

</html>