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
	<link href="<?= base_url() ?>src/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="<?php echo base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">
	<!-- footer menu -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/header.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/icons.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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

		#map {
			height: 400px;
			width: 100%;
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
 footer menu -->
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
					<div align="center">
						<font style="font-size:17px;">
							<?php
							if ($this->uri->segment(3) == null) { ?>
								Tambah
							<?php
							} else {
							?>
								Ubah
							<?php
							}
							?>
							Member Nasabah
							<hr />

						</font>
					</div>
					<div class="form">
						<?php
						if ($this->uri->segment(3) == null) { ?>
							<form method="POST" action="<?= base_url('tabungan/proses_tambah_tabungan') ?>">
								<div class="row" style="margin-bottom: 10px;">
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="jenis_tabungan">Jenis Tabungan</label>
										<select class="form-control" name="jenis_tabungan" id="jenis_tabungan">
											<option selected disabled>-- Pilih Jenis Tabungan --</option>
											<?php
											foreach ($tabungan as $t) {
											?>
												<option value="<?= $t->kode_tabungan ?>"><?= $t->kode_tabungan ?> - <?= $t->nama_tabungan ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="no_tabungan">No Tabungan</label>
										<input type="number" min="0" class="form-control" name="no_tabungan" id="no_tabungan">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="no_cib">No CIB</label>
										<select class="form-control" name="no_cib" id="no_cib">
											<?php
											foreach ($nasabah as $n) {
											?>
												<option value="<?= $n->no_cib ?>"><?= $n->no_cib ?> - <?= $n->nama ?></option>
											<?php
											}
											?>
										</select>
									</div>

									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="status_tabungan">Status Tabungan</label>
										<select class="form-control" name="status_tabungan" id="status_tabungan">
											<option value="Aktif">Aktif</option>
											<option value="Beku">Beku</option>
											<option value="Non-Aktif">Non-Aktif</option>
										</select>
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="no_urut">No Urut</label>
										<input type="number" min="0" class="form-control" name="no_urut" id="no_urut">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="nominal">Nominal (Rp.)</label>
										<input type="number" min="0" class="form-control" name="nominal" id="nominal">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="spread_rate">Spread Rate (%)</label>
										<input type="number" min="0" max="100" class="form-control" name="spread_rate" id="spread_rate">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="nominal_blokir">Nominal Blokir (Rp.)</label>
										<input type="number" min="0" class="form-control" name="nominal_blokir" id="nominal_blokir">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="pos_rate">Pos Rate (Rp.)</label>
										<input type="number" min="0" class="form-control" name="pos_rate" id="pos_rate">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="nolsp">NOLSP (Rp.)</label>
										<input type="number" min="0" class="form-control" name="nolsp" id="nolsp">
									</div>
								</div>
								<button type="submit" class="btn btn-primary">Submit</button>
								<button type="reset" class="btn btn-warning">Reset</button>
							</form>
						<?php
						} else {
						?>
							<form method="POST" action="<?= base_url('tabungan/proses_update_tabungan') ?>">
								<input type="hidden" name="id_tabungan" id="id_tabungan" value="<?= $detail->no_tabungan ?>">
								<div class="col-md-6" style="margin-bottom: 10px;">
									<label for="jenis_tabungan">Jenis Tabungan</label>
									<!-- <input type="text" class="form-control" name="jenis_tabungan" id="jenis_tabungan" value="<?= $detail->jenis_tabungan ?>"> -->
									<select class="form-control" name="jenis_tabungan" id="jenis_tabungan">
										<option disabled>-- Pilih Jenis Tabungan --</option>
										<?php
										foreach ($tabungan as $t) {
										?>
											<option <?php if ($t->kode_tabungan == $detail->jenis_tabungan) {
														echo "Selected";;
													} ?> value="<?= $t->kode_tabungan ?>"><?= $t->kode_tabungan ?> - <?= $t->nama_tabungan ?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="row" style="margin-bottom: 10px;">
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="no_tabungan">No Tabungan</label>
										<input type="number" min="0" class="form-control" name="no_tabungan" id="no_tabungan" value="<?= $detail->no_tabungan ?>">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="no_cib">No CIB</label>
										<select class="form-control" name="no_cib" id="no_cib">
											<?php
											foreach ($nasabah as $n) {
											?>
												<option <?php if ($n->no_cib == $detail->no_cib) {
															echo "Selected";;
														} ?> value="<?= $n->no_cib ?>"><?= $n->no_cib ?> - <?= $n->nama ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="status_tabungan">Status Tabungan</label>
										<input type="text" class="form-control" name="status_tabungan" id="status_tabungan" value="<?= $detail->status_tabungan ?>">

										<select class="form-control" name="status_tabungan" id="status_tabungan">
											<option <?php if ($detail->status_tabungan == 'Aktif') echo "Selected" ?> value="Aktif">Aktif</option>
											<option <?php if ($detail->status_tabungan == 'Beku') echo "Selected" ?> value="Beku">Beku</option>
											<option <?php if ($detail->status_tabungan == 'Non-Aktif') echo "Selected" ?> value="Non-Aktif">Non-Aktif</option>
										</select>
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="no_urut">No Urut</label>
										<input type="number" min="0" class="form-control" name="no_urut" id="no_urut" value="<?= $detail->no_urut ?>">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="nominal">Nominal (Rp.)</label>
										<input type="number" min="0" class="form-control" name="nominal" id="nominal" value="<?= $detail->nominal ?>">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="spread_rate">Spread Rate (%)</label>
										<input type="number" min="0" max="100" class="form-control" name="spread_rate" id="spread_rate" value="<?= $detail->spread_rate ?>">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="nominal_blokir">Nominal Blokir (Rp.)</label>
										<input type="number" min="0" class="form-control" name="nominal_blokir" id="nominal_blokir" value="<?= $detail->nominal_blokir ?>">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="pos_rate">Pos Rate (Rp.)</label>
										<input type="number" min="0" class="form-control" name="pos_rate" id="pos_rate" value="<?= $detail->pos_rate ?>">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="nolsp">NOLSP (Rp.)</label>
										<input type="number" min="0" class="form-control" name="nolsp" id="nolsp" value="<?= $detail->nolsp ?>">
									</div>
								</div>
								<button type="submit" class="btn btn-primary">Submit</button>
								<button type="reset" class="btn btn-warning">Reset</button>
							</form>
						<?php
						}
						?>
						<form action="">

						</form>
					</div>
				</div>
			</div>
		</div>
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
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js">
	</script>
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
	<script src="<?= base_url() ?>src/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>
	<!-- Select2 -->
	<link rel="stylesheet" href="<?= base_url() ?>src/select2/css/select2.min.css">
	<script type="text/javascript" src="<?= base_url() ?>src/select2/js/select2.min.js"></script>

	<!-- DataTables -->
	<script src="<?= base_url() ?>src/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	<script src="<?= base_url() ?>src/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const today = new Date().toISOString().split('T')[0];
			document.getElementById('tgl_lahir').value = today;
			document.getElementById('tgl_pendaftaran').value = today;
		});

		$(document).ready(function() {
			$(document).ready(function() {
				$('#jenis_tabungan').change(function() {
					let jenisTabungan = $(this).val(); // Get selected 'jenis_tabungan'
					if (jenisTabungan) {
						$.ajax({
							url: '<?= base_url("Tabungan/getNextTabunganNumber") ?>', // Update this URL to your controller method
							type: 'POST',
							data: {
								jenis_tabungan: jenisTabungan
							},
							dataType: 'json',
							success: function(response) {
								if (response.status) {
									// Populate the no_tabungan and no_urut input fields
									$('#no_tabungan').val(response.no_tabungan);
									$('#no_urut').val(response.no_urut);
								} else {
									alert(response.message);
								}
							},
							error: function() {
								alert('Error processing your request. Please try again.');
							}
						});
					}
				});
			});
		});
	</script>

</body>

</html>