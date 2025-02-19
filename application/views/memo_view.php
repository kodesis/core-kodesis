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
	<title>Kodesis | Business Development</title>
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
	<!-- Custom Theme Style -->
	<link href="<?php echo base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">
	<!-- footer menu -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/header.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/icons.css">

	<style>
		.col-xs-3 {
			width: 25%;
			background-color: #004e81;
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

		table,
		th,
		td {
			border: 0px solid black;
		}

		table.center {
			margin-left: auto;
			margin-right: auto;
		}

		.button1 {
			background-color: #4CAF50;
		}

		/* Green */
	</style>
</head>

<header class="header_area sticky-header">
	<!-- footer menu -->
	<!--div class="footer_panel">
		<div class="container-fluid text-center">
			<div class="row">

				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/antrian_input">
					<i class="la-i la-i-m la-i-home"></i>
					<div class="tag_"><font color="white">Create</font></div></a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/antrian_panggil">
					<i class="la-i la-i-m la-i-order"></i>
					<div class="tag_"><font color="white">Manage</font></div></a>
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
					<div class="tag_"><font color="white">Logout</font></div></a>
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
						<a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>img/logo-kodesis.png" alt="..." height="42" width="60"><span> Kodesis</span></a>
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
								<a href="<?php echo base_url() . "app/inbox"; ?>" class="dropdown-toggle info-number">
									<i class="fa fa-envelope-o"></i>
									<?php if ($count_inbox == 0) { ?>
										<span class="badge bg-green"><?php echo $count_inbox; ?></span>
									<?php } else { ?>
										<span class="badge bg-red"><?php echo $count_inbox; ?></span>
									<?php } ?>
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
							<?php include 'notif_tello.php' ?>

						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->

			<!-- Start content-->
			<div class="right_col" role="main">
				<div class="clearfix"></div>

				<div class="x_panel card">
					<strong>
						<font style="color:blue;font-size:24px;">Kodesis</font>
					</strong></br>
					<!--<font style="font-size:17px;">PT. Lohjinawi Agritama International</font></br></br>-->

					<div align="center">
						<font style="font-size:17px;">
							E-MEMO INTERN</br>
							No. <?php
								$array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
								$bln = $array_bln[date('n', strtotime($memo->tanggal))];

								echo sprintf("%03d", $memo->nomor_memo) . '/E-MEMO/' . $memo->kode_nama . '/' . $bln . '/' . date('Y', strtotime($memo->tanggal));
								?>
							<hr />
						</font>
					</div>
					<font style="font-size:14px;">
						<table class="center">
							<tr>
								<td style="width:30%"><strong>Dari</td>
								<td> : &nbsp;</td>
								<td><?php echo $memo->nama . " (" . $memo->nama_jabatan . ")"; ?></td>
							</tr>
							<tr>
								<td valign="top"><strong>Kepada&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"> : &nbsp;</td>
								<td>
									<?php
									$no = 0;
									$string = substr($memo->nip_kpd, 0, -1);
									$arr_kpd = explode(";", $string);
									foreach ($arr_kpd as $data) :
										$sql = "SELECT nama,nama_jabatan FROM users WHERE nip='$data';";
										$query = $this->db->query($sql);
										$result = $query->row();
										echo $result->nama . " (" . $result->nama_jabatan . ")";
										echo "</br>";
										$no++;
									endforeach;
									?></td>
							</tr>
							<tr>
								<td valign="top"><strong>Tembusan&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"> : &nbsp;</td>
								<td>
									<?php
									$no = 0;
									if (!empty($memo->nip_cc)) {
										$string = substr($memo->nip_cc, 0, -1);
										$arr_kpd = explode(";", $string);
										foreach ($arr_kpd as $data) :
											$sql = "SELECT nama,nama_jabatan FROM users WHERE nip='$data';";
											$query = $this->db->query($sql);
											$result = $query->row();
											echo $result->nama . " (" . $result->nama_jabatan . ")";
											echo "</br>";
											$no++;
										endforeach;
									} else {
										echo "--";
									};
									?></td>
							</tr>
							<tr>
								<td style="width:30%"><strong>Perihal</td>
								<td> : </td>
								<td><?php echo $memo->judul; ?></td>
							</tr>
						</table>
						<hr />
						</br>

						<table>
							<tr>
								<td style="word-wrap: break-word; text-align:justify;" width="100%"><?php echo $memo->isi_memo; ?></td>
							</tr>
						</table></br></br>

						<table>
							<tr>
								<td width="80%">Jakarta, <?php $date = $memo->tanggal;
															echo $newDate = date("d F Y", strtotime($date)); ?></td>
								<td></td>
							</tr>
							<!--tr>
				<td>Dibuat oleh,</td>
				<?php if (($this->session->userdata('level_jabatan') >= 2) and ($memo->nip_dari <> $this->session->userdata('nip'))) { ?>
					<td></td>
				<?php } ?>
			</tr-->

							<?php if (($this->session->userdata('level_jabatan') >= 1) and ($memo->nip_dari <> $this->session->userdata('nip'))) { ?>
								<tr style="height:100px;">
									<!--td style="vertical-align:bottom"><?php echo $memo->nama; ?></td-->
									<td style="text-align:right">
										<form action="<?php echo base_url() . "app/inbox/"; ?>" target="">
											<button type="submit" class="btn btn-warning">Back</button>
										</form>
									</td>
									<td style="text-align:right">
										<form action="<?php echo base_url() . "app/create_memo_approve/" . $memo->Id . "/x"; ?>" target="">
											<button type="submit" class="btn btn-primary">Reply</button>
										</form>
									</td>
									<td style="text-align:right">
										<form action="<?php echo base_url() . "app/create_memo_approve/" . $memo->Id; ?>" target="">
											<button type="submit" class="btn btn-primary">Reply All</button>
										</form>
									</td>
									<td style="text-align:right"><a href="<?= base_url('app/memo_pdf/' . $memo->Id) ?>" class="btn btn-success" target="_blank">Cetak PDF</a></td>
								</tr>
							<?php } else { ?>
								<!--tr style="height:100px;">
					<td style="vertical-align:bottom"><?php echo $memo->nama; ?></td>
				</tr-->
							<?php } ?>

						</table>
						<br>
						<table>
							<tr>
								<td>Attachment : </td>
							</tr>
							<?php if (!empty($memo->attach)) { ?>
								<tr>
									<td>
										<?php
										$attach_ = '';
										$no = '1';
										$attch1 = explode(";", $memo->attach);
										$attch2 = explode(";", $memo->attach_name);

										foreach (array_combine($attch1, $attch2) as $attch1 => $attch2) {
											if (!empty($attch1)) {
												$attach_ .= "<a href='" . base_url() . "upload/att_memo/" . $attch1 . "' target='_blank'>" . $no . '. ' . $attch2 . "</a></br>\n";
												$no++;
											}
										}
										echo $attach_;
										// foreach($attch2 as $data) {
										// $data = trim($data);
										// $attach_ .= "<a href='"."/upload/att_memo/".$data."'>".$no.'. '.$data."</a></br>\n";
										// $no++;
										// }
										?>
									</td>
								</tr>
							<?php } ?>
						</table>
					</font>


				</div>

				<!-- Finish content-->


				<!-- /page content -->

				<!-- footer content -->

				<!-- /footer content --></br>


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

</body>

</html>