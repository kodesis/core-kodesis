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
						<a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>src/images/logosaja_bdl.png" alt="..." height="42" width="60"><span>Andara Office</span></a>
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
					<div class="col-md-4 col-sm-4 col-xs-4 tile_stats_count">
						<span class="count_top"><i class="fa fa-folder-open-o"></i>Current Queue</span>
						<div class="count" style="color:#16a085;"><?php echo $utility->current_antrian; ?></div>
						<span class="count_bottom"><i class="green"><strong>Date: <?php $date = date_create($utility->tgl_antrian);
																					echo date_format($date, 'd-m-Y'); ?></strong></i></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 tile_stats_count">
						<span class="count_top"><i class="fa fa-line-chart"></i>Sisa antrian</span>
						<div class="count" style="color:red;"><?php echo $sisa_antrian; ?></div><br>
						<!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 tile_stats_count">
						<span class="count_top"><i class="fa fa-line-chart"></i>Antrian besok</span>
						<div class="count" style="color:#f39c12;"><?php echo $antrian_besok; ?></div><br>
						<!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
					</div>
				</div>

				<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
					<div class="tile-stats" style="background:#f1c40f; height:130px;">
						<?php
						if ($utility->slot1 == 0) { ?>
							<button class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 1</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 1 &raquo; On Load</button>
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
							<button class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 2</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 2 &raquo; On Load</button>
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
							<button class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 3</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 3 &raquo; On Load</button>
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
							<button class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 4</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 4 &raquo; On Load</button>
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
							<button class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 5</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 5 &raquo; On Load</button>
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
							<button class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 6</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 6 &raquo; On Load</button>
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
							<button class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 7</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 7 &raquo; On Load</button>
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
							<button class="btn btn-success btn-lg col-md-12 col-xs-12">Slot 8</button>
						<?php } else { ?>
							<button class="btn btn-danger btn-lg col-md-12 col-xs-12">Slot 8 &raquo; On Load</button>
						<?php }
						?>
						<div style="color:#34495e; text-align: center; font-weight: bold;">
							<h1><?php echo $utility->slot8; ?></h1> Loading Start : <?php if (!empty($antrian8)) {
																						echo $antrian8->start_time;
																					} ?>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<p>
								<font size="4"><strong>Loading Monitoring</font></strong>
							</p>
							<div class="table-responsive">
								<table class="table table-striped jambo_table bulk_action">
									<thead>
										<tr class="headings">
											<th class="column-title">No.</th>
											<th class="column-title">Tanggal</th>
											<th class="column-title">No. Mobil</th>
											<th class="column-title">Jam</th>
											<th class="column-title">Des</th>
											<th class="column-title">Driver</th>
											<th class="column-title">Slot</th>
											<th class="column-title">Start</th>
											<th class="column-title">Finish</th>
											<th class="column-title">Duration</th>
											<th class="column-title">Status</th>
											<th class="column-title">Mark</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										if (empty($antrian)) { ?>
											<div class="alert alert-info">Tidak ditemukan data antrian</div>
											<?php } else {
											foreach ($antrian as $data) :
											?>
												<tr class="even pointer">
													<td class=" "><?php echo $data->nomor_antrian; ?></td>
													<td class=" "><?php $date = $data->date_pic;
																	echo $newDate = date("d-m-Y", strtotime($date)); ?></td>
													<td class=" "><?php echo $data->nomor_mobil; ?> </td>
													<td class=" "><?php echo $data->jam_terpilih; ?> </td>
													<td class=" "><?php echo $data->tujuan; ?> </td>
													<td class=" "><?php echo $data->nama_driver; ?> </td>
													<td class=" "><?php echo $data->slot; ?></td>
													<td class=" "><?php echo $data->start_time; ?></td>
													<td class=" "><?php echo $data->finish_time; ?></td>
													<td class=" "><?php
																	$d1 = new DateTime($data->start_time);
																	$d2 = new DateTime($data->finish_time);
																	$interval = $d2->diff($d1);
																	//echo $interval->format('%d days, %H hours, %I minutes, %S seconds');
																	echo $interval->format('%H:%I:%S'); ?></td>
													<td class=" ">
														<?php
														if ($data->status == 2) { ?>
															<div class="alert-success tile-stats" style="text-align: center;">Approved</div>
														<?php } elseif ($data->status == 3) { ?>
															<div class="alert-danger tile-stats" style="text-align: center;">Unloading WH</div>
														<?php } elseif ($data->status == 4) { ?>
															<!--span class="glyphicon glyphicon-comment" aria-hidden="true"></span-->
															<div class="alert-info tile-stats" style="text-align: center;">Done</div>
														<?php } elseif ($data->status == 0) { ?>
															<!--span class="glyphicon glyphicon-comment" aria-hidden="true"></span-->
															<div class="alert-pry tile-stats" style="text-align: center;">On Create</div>
														<?php } elseif ($data->status == 1) { ?>
															<!--span class="glyphicon glyphicon-comment" aria-hidden="true"></span-->
															<div class="alert-warning tile-stats" style="text-align: center;">Waiting Approve</div>
														<?php } elseif ($data->status == 9) { ?>
															<div class="alert-danger tile-stats" style="text-align: center;">Rejected</div>
														<?php } ?>
													</td>
													<td class="">
														<span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo $data->remark; ?>">
															<?php if (empty($data->remark)) { ?>
																<?php if ($data->status == 0) { ?>
																	<a href="<?php echo base_url() . 'app/antrian_input/' . $data->Id; ?>" class="btn btn-success btn-sm col-md-12 col-xs-12" style="height: 25px;">Edit</a>
																<?php } ?>
															<?php } else { ?>
																<span style="color:red; font-size: 15px;" class="glyphicon glyphicon-comment"></span>
															<?php } ?>
														</span>
													</td>
												</tr>
										<?php
												$no++;
											endforeach;
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<br><br><br><br><br>
				</div>


				<!-- Start content-->

				<!-- Finish content-->

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
	<!-- bootstrap-datetimepicker -->
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Custom Theme Scripts -->
	<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>

	<script>
		$('#myDatepicker2').datetimepicker({
			format: 'YYYY-MM-DD'
		});

		function myFunction(slot) {
			swal({
				title: "Anda yakin ?",
				text: "Start Antrian Selanjutnya!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Lets Start",
				closeOnConfirm: false
			}, function(isConfirm) {
				if (isConfirm) window.location.href = 'slot/' + slot;
			});
		}

		function myFunction_2(slot) {
			swal({
				title: "Anda yakin ?",
				text: "Finish Loading Antrian!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, Lets Finish",
				closeOnConfirm: false
			}, function(isConfirm) {
				if (isConfirm) window.location.href = 'slot_e/' + slot;
			});
		}

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
	</script>

</body>

</html>