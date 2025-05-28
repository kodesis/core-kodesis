<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="<?= $this->session->userdata('icon') ?>" type="image/ico" />
	<title><?= $this->session->userdata('nama_singkat') ?> | Bussines Development</title>
	<title>Kodesis | Business Development</title>
	<!-- Select2 -->
	<link href="<?php echo base_url(); ?>src/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>src/vendors/select2/dist/css/select2.css" rel="stylesheet" />
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
						<a href="<?php echo base_url(); ?>" class="site_title"><img src="<?= $this->session->userdata('icon') ?>" alt="..." width="60">
							<span><?= $this->session->userdata('nama_singkat') ?></span></a>
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
							<form method="POST" action="<?= base_url('member/proses_tambah_tabungan') ?>">
								<div class="row" style="margin-bottom: 10px;">
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="nama">Nama</label>
										<input type="text" class="form-control" name="nama" id="nama">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="alamat">Alamat</label>
										<textarea class="form-control" name="alamat" id="alamat"></textarea>
									</div>
									<div class="col-md-6">
										<label for="no_ktp">No KTP</label>
										<input type="number" class="form-control" name="no_ktp" id="no_ktp">
									</div>
									<div class="col-md-6">
										<label for="no_telp">No Telepon</label>
										<input type="text" class="form-control" name="no_telp" id="no_telp">
									</div>
									<div class="col-md-6">
										<label for="ahli_waris">Ahli Waris</label>
										<input type="text" class="form-control" name="ahli_waris" id="ahli_waris">
									</div>
									<div class="col-md-6">
										<label for="kode_pos">Kode Pos</label>
										<input type="number" class="form-control" name="kode_pos" id="kode_pos">
									</div>
									<div class="col-md-6">
										<label for="nama_ibu_kandung">Nama Ibu Kandung</label>
										<input type="text" class="form-control" name="nama_ibu_kandung" id="nama_ibu_kandung">
									</div>
									<div class="col-md-6">
										<label for="pekerjaan">Pekerjaan</label>
										<input type="text" class="form-control" name="pekerjaan" id="pekerjaan">
									</div>
									<div class="col-md-6">
										<label for="kode_ao">Kode AO</label>
										<select class="form-control select2" name="kode_ao" id="kode_ao">
											<option selected disabled>-- Pilih Kode AO --</option>
											<?php
											foreach ($karyawan as $k) {
											?>
												<option value="<?= $k->kode_ao ?>"><?= $k->kode_ao ?> - <?= $k->nama_ao ?></option>
											<?php
											}
											?>
										</select>
										<!-- <input type="text" class="form-control" name="kode_ao" id="kode_ao"> -->
									</div>
									<div class="col-md-6">
										<label for="nama_panggilan">Nama Panggilan</label>
										<input type="text" class="form-control" name="nama_panggilan" id="nama_panggilan">
									</div>
									<div class="col-md-3">
										<label for="tgl_lahir">Tanggal Lahir</label>
										<input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir">
									</div>
									<div class="col-md-3">
										<label for="tempat_lahir">Tempat Lahir</label>
										<input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir">
									</div>
									<div class="col-md-6">
										<label for="tempat_lahir">Cabang</label>
										<select class="form-control select2" name="cabang" id="cabang">
											<option selected disabled>-- Pilih Cabang --</option>
											<?php
											foreach ($cabang as $c) {
											?>
												<option value="<?= $c->uid ?>"><?= $c->uid ?> - <?= $c->nama_cabang ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-6">
										<label for="kota">Kota</label>
										<input type="text" class="form-control" name="kota" id="kota">
									</div>
									<!-- <div class="col-md-6">
										<label for="tgl_pendaftaran">Tanggal Pendaftaran</label>
										<input type="date" class="form-control" name="tgl_pendaftaran" id="tgl_pendaftaran">
									</div> -->
									<div class="col-md-6">
										<label for="tipe_nasabah">Tipe Nasabah</label>
										<select class="form-control select2" name="tipe_nasabah" id="tipe_nasabah">
											<option selected disabled>-- Pilih Tipe Nasabah --</option>
											<?php
											foreach ($tipe as $t) {
											?>
												<option value="<?= $t->kode_tipe ?>"><?= $t->kode_tipe ?> - <?= $t->nama_tipe ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-6">
										<label for="segmen_nasabah">Segmen Nasabah</label>
										<select class="form-control select2" name="segmen_nasabah" id="segmen_nasabah">
											<option selected disabled>-- Pilih Segmen Nasabah --</option>
											<?php
											foreach ($segmen as $s) {
											?>
												<option value="<?= $s->kode_segmen ?>"><?= $s->kode_segmen ?> - <?= $s->nama_segmen ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-6">
										<label for="warga_negara">Warga Negara</label>
										<input type="text" class="form-control" name="warga_negara" id="warga_negara">
									</div>
									<!-- <div class="col-md-6">
										<label for="no_cib">No CIB</label>
										<input type="text" class="form-control" name="no_cib" id="no_cib">
									</div> -->
								</div>
								<button type="submit" class="btn btn-primary">Submit</button>
								<button type="reset" class="btn btn-warning">Reset</button>
							</form>
						<?php
						} else {
						?>
							<form method="POST" action="<?= base_url('member/proses_update_member') ?>">
								<input type="hidden" name="id_member" id="id_member" value="<?= $detail->no_cib ?>">
								<div class="row" style="margin-bottom: 10px;">
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="nama">Nama</label>
										<input type="text" class="form-control" name="nama" id="nama" value="<?= $detail->nama ?>">
									</div>
									<div class="col-md-6" style="margin-bottom: 10px;">
										<label for="alamat">Alamat</label>
										<textarea class="form-control" name="alamat" id="alamat"><?= $detail->alamat ?></textarea>
									</div>
									<div class="col-md-6">
										<label for="no_ktp">No KTP</label>
										<input type="text" class="form-control" name="no_ktp" id="no_ktp" value="<?= $detail->no_ktp ?>">
									</div>
									<div class="col-md-6">
										<label for="no_telp">No Telepon</label>
										<input type="text" class="form-control" name="no_telp" id="no_telp" value="<?= $detail->no_telp ?>">
									</div>
									<div class="col-md-6">
										<label for="ahli_waris">Ahli Waris</label>
										<input type="text" class="form-control" name="ahli_waris" id="ahli_waris" value="<?= $detail->ahli_waris ?>">
									</div>
									<div class="col-md-6">
										<label for="kode_pos">Kode Pos</label>
										<input type="text" class="form-control" name="kode_pos" id="kode_pos" value="<?= $detail->kode_pos ?>">
									</div>
									<div class="col-md-6">
										<label for="nama_ibu_kandung">Nama Ibu Kandung</label>
										<input type="text" class="form-control" name="nama_ibu_kandung" id="nama_ibu_kandung" value="<?= $detail->nama_ibu_kandung ?>">
									</div>
									<div class="col-md-6">
										<label for="pekerjaan">Pekerjaan</label>
										<input type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="<?= $detail->pekerjaan ?>">
									</div>
									<div class="col-md-6">
										<label for="kode_ao">Kode AO</label>
										<select class="form-control select2" name="kode_ao" id="kode_ao">
											<option disabled>-- Pilih Kode AO --</option>
											<?php
											foreach ($karyawan as $k) {
											?>
												<option <?php if ($k->kode_ao == $detail->kode_ao) {
															echo "Selected";
														} ?> value="<?= $k->kode_ao ?>"><?= $k->kode_ao ?> - <?= $k->nama_ao ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-6">
										<label for="nama_panggilan">Nama Panggilan</label>
										<input type="text" class="form-control" name="nama_panggilan" id="nama_panggilan" value="<?= $detail->nama_panggilan ?>">
									</div>
									<div class="col-md-3">
										<label for="tgl_lahir">Tanggal Lahir</label>
										<input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="<?= $detail->tgl_lahir ?>">
									</div>
									<div class="col-md-3">
										<label for="tempat_lahir">Tempat Lahir</label>
										<input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="<?= $detail->tempat_lahir ?>">
									</div>
									<div class="col-md-6">
										<label for="tempat_lahir">Cabang</label>
										<select class="form-control select2" name="cabang" id="cabang">
											<option selected disabled>-- Pilih Cabang --</option>
											<?php
											foreach ($cabang as $c) {
											?>
												<option <?php if ($c->uid == $detail->cabang)
															echo "Selected";
														?> value="<?= $c->uid ?>"><?= $c->uid ?> - <?= $c->nama_cabang ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-md-6">
										<label for="kota">Kota</label>
										<input type="text" class="form-control" name="kota" id="kota" value="<?= $detail->kota ?>">
									</div>
									<!-- <div class="col-md-6">
										<label for="tgl_pendaftaran">Tanggal Pendaftaran</label>
										<input type="date" class="form-control" name="tgl_pendaftaran" id="tgl_pendaftaran" value="<?= $detail->tgl_pendaftaran ?>">
									</div> -->
									<div class="col-md-6">
										<label for="tipe_nasabah">Tipe Nasabah</label>
										<select class="form-control select2" name="tipe_nasabah" id="tipe_nasabah">
											<option disabled>-- Pilih Tipe Nasabah --</option>
											<?php
											foreach ($tipe as $t) {
											?>
												<option <?php if ($t->kode_tipe == $detail->tipe_nasabah) {
															echo "Selected";;
														} ?> value="<?= $t->kode_tipe ?>"><?= $t->kode_tipe ?> - <?= $t->nama_tipe ?></option>
											<?php
											}
											?>
										</select>
										<!-- <input type="text" class="form-control" name="tipe_nasabah" id="tipe_nasabah" value="<?= $detail->tipe_nasabah ?>"> -->
									</div>
									<div class="col-md-6">
										<label for="segmen_nasabah">Segmen Nasabah</label>
										<select class="form-control select2" name="segmen_nasabah" id="segmen_nasabah">
											<option disabled>-- Pilih Segmen Nasabah --</option>
											<?php
											foreach ($segmen as $s) {
											?>
												<option <?php if ($s->kode_segmen == $detail->segmen_nasabah) {
															echo "Selected";;
														} ?> value="<?= $s->kode_segmen ?>"><?= $s->kode_segmen ?> - <?= $s->nama_segmen ?></option>
											<?php
											}
											?>
										</select>
										<!-- <input type="text" class="form-control" name="segmen_nasabah" id="segmen_nasabah" value="<?= $detail->segmen_nasabah ?>"> -->
									</div>
									<div class="col-md-6">
										<label for="warga_negara">Warga Negara</label>
										<input type="text" class="form-control" name="warga_negara" id="warga_negara" value="<?= $detail->warga_negara ?>">
									</div>
									<!-- <div class="col-md-6">
										<label for="no_cib">No CIB</label>
										<input type="text" class="form-control" name="no_cib" id="no_cib" value="<?= $detail->no_cib ?>">
									</div> -->
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
	<script src="<?php echo base_url(); ?>src/vendors/select2/dist/js/select2.min.js"></script>

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
		$(document).ready(() => {
			$('.select2').select2();

		})
		document.addEventListener('DOMContentLoaded', function() {
			const today = new Date().toISOString().split('T')[0];
			document.getElementById('tgl_lahir').value = today;
			document.getElementById('tgl_pendaftaran').value = today;
		});
	</script>

</body>

</html>